<?php
    // Including all the important pages

    require_once 'sessionAdmin.php';
    require_once 'functions.php';
    require_once 'confidential.php';

    $error = [];
    $forums = [];

    try {
        // Database connection

        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Selecting data and storing it into SQL variable

        $sql = "select tbl_forums.*, tbl_users.name, tbl_categories.title from tbl_categories as tbl_categories join tbl_forums on tbl_forums.category_id = tbl_categories.id join tbl_users on tbl_users.id = tbl_forums.posted_by";

        // Query execution and return result object 

        $result = mysqli_query($connection, $sql);

        // Check no of rows

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($forums, $row);
            }
        }
    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Admin - List Forums</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">List Forums</h1>
        <div class="navBar"><?php require_once 'navigationAdmin.php'; ?></div>
    </div>
    <div class="container">
        <table border="1">
            <tr>
                <th>SN</th>
                <th>Title</th>
                <th>Description</th>
                <th>Images</th>
                <th>Category</th>
                <th>Posted by</th>
                <th>Posted date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach($forums as $key => $data) { ?>
                <tr>
                    <td><?php echo $key + 1; ?></td>
                    <td><?php echo $data['title'] ?></td>
                    <td><?php echo $data['description'] ?></td>
                    <td><img src="images/<?php echo $data['image']; ?>" alt="" style="height: 150px; width: 250px;"></td>
                    <td><?php echo $data['title'] ?></td>
                    <td><?php echo $data['name'] ?></td>
                    <td><?php echo $data['posted_date'] ?></td>
                    <td><?php echo $data['status'] ?></td>
                    <td>
                        <a href="unblock.php?id=<?php echo $data['id']; ?>&type=list" onclick="return confirm('Unblock the post?');">Unblock</a>
                        <a href="block.php?id=<?php echo $data['id']; ?>&type=list" onclick="return confirm('Block the post?');">Block</a><br>
                        <a href="delete.php?id=<?php echo $data['id']; ?>&type=list" onclick="return confirm('Delete the forum post?');">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <?php echo checkError($error, 'database'); ?>
    </div>
</body>
</html>