<?php
    // Including all the required pages

    require_once 'confidential.php';

    // Define empty array variables

    $forums = [];

    // Initialize the database

    try {
        // Database connection

        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Selecting data and storing it into SQL variable

        $sql = "select tbl_forums.*,tbl_users.name, tbl_categories.title as category_title from tbl_forums as tbl_forums join tbl_users on tbl_forums.posted_by = tbl_users.id join tbl_categories on tbl_categories.id = tbl_forums.category_id ";

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
    <title>First Project - Forum</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Forum - Home</h1>
        <?php require 'navigationPublic.php'; ?>
    </div>
    <div class="container">
        <?php foreach($forums as $key => $forum) { ?>
            <div class="card">
                <img src="images/<?php echo $forum['image']; ?>" style="height:150px; width: 275px;">
                <div class="cardHeader">
                    <h3 class="subHeading"><?php echo $forum['title']; ?></h3>
                    <div class="category"><p><?php echo $forum['category_title']; ?></p></div>
                </div>
                <div class="action">
                    <div class="button"><button><a href="read.php?title=<?php echo $forum['title']; ?>&fid=<?php echo $forum['id']; ?>">Read more</a></button></div>
                    <div class="author"><small>Author - <i><?php echo $forum['name']; ?></i></small></div>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>