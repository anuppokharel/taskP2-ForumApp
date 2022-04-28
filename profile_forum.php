<?php
    // Including all the important pages

    require_once 'session.php';
    require_once 'functions.php';
    require_once 'confidential.php';

    $error = [];
    $forums = [];
    $id = $_SESSION['id'];
   
    try {
        // Database connection

        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Selecting data and storing it into SQL variable

        $sql = "select tbl_forums.*, tbl_categories.title as category_title, tbl_users.name from tbl_forums as tbl_forums join tbl_categories on tbl_forums.category_id = tbl_categories.id join tbl_users on tbl_forums.posted_by = tbl_users.id where posted_by = '$id'";

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
    <title>Forums - My Profile</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">My Profile</h1>
        <div class="navBar"><?php require_once 'navigationUser.php'; ?></div>
    </div>
    <div class="container">
        <?php foreach($forums as $key => $forum) { ?>
            <div class="card">
                <img src="images/<?php echo $forum['image']; ?>" alt="" style="height:150px; width: 275px;">
                <div class="cardHeader">
                    <h3><?php echo $forum['title']; ?></h3>
                </div>
                <div class="description">
                    <p><?php echo $forum['description']; ?></p>
                </div>
                <div class="info">
                    <b><p>Category - <?php echo $forum['category_title']; ?></p></b>
                    <b><p>Posted By - <?php echo $forum['name']; ?> </p></b>
                </div>
                <div class="action">
                    <div class="button">
                        <button class="edit"><a href="edit.php?fid=<?php echo $forum['id']; ?>">Edit Description</a></button>
                        <button><a href="delete.php?id=<?php echo $forum['id']; ?>&type=userPost" onclick="return confirm('Delete the post from your page?');" >Delete</a></button>
                    </div>
                </div>
                <?php if(isset($successMsg)) { ?>
                    <b><span class="success"><?php echo $successMsg ?></span></b>
                <?php } ?>
                <?php echo checkError($error, 'editD'); ?>
                <?php echo checkError($error, 'database'); ?>
            </div>
        <?php } ?>
    </div>

</body>
</html>