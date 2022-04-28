<?php
    require 'session.php';
    require 'confidential.php';
    require 'functions.php';

    $error = [];
    $tokenUserId = $_SESSION['id'];
    $tokenForumId = $_GET['fid'];

    try {
        // Database connection

        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Selecting data and storing it into SQL variable

        $sql = "select tbl_forums.*, tbl_categories.title as category_title, tbl_users.name as user_name from tbl_forums as tbl_forums join tbl_categories on tbl_forums.category_id = tbl_categories.id join tbl_users where tbl_forums.id = '$tokenForumId'";

        // Query execution and return result object 

        $result = mysqli_query($connection, $sql);

        // Check no of rows
        
        $post = mysqli_fetch_assoc($result);

    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    if(isset($_POST['editBtn'])) {
        if(verifyForm($_POST, 'description')) {
            $description = $_POST['description'];
        } else {
            $error['description'] = 'Enter atleast 25 characters in description.';
        }

        if(count($error) == 0) {
            try {
                $connectionUpdate = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
                $sqlUpdate = "update tbl_forums set description = '$description' WHERE id = '$tokenForumId';";
    
                if(mysqli_query($connectionUpdate, $sqlUpdate)) {
                    $successMsg = "Description updated";
                }
    
                header('location: profile_forum.php');
            } catch(Exception $e) {
                $error['database'] = $e -> getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Document</title>
</head>
<body>
<div class="header">
        <h1 class="mainHeading">My Profile</h1>
        <?php require 'navigationUser.php'; ?>
    </div>
    <div class="container">
            <div class="mainCard">
                <img src="images/<?php echo $post['image']; ?>" style="height:300px; width:300px;">
                <div class="cardHeader">
                    <h3><?php echo $post['title']; ?></h3>
                    <p class="category"><?php echo $post['category_title']; ?></p>
                </div>
                <div class="description">
                        <p><?php echo $post['description']; ?></p>
                </div>
                <div class="textArea hidden">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?fid=<?php echo $post['id']; ?>" method="post">
                        <textarea name="description" cols="40" rows="2" placeholder="Write your new description."></textarea><br>
                        <div class="action"><button type="submit" name="editBtn">Edit</button></div>
                    </form>
                </div>
                <div class="error">
                    <?php echo checkError($error, 'fetch'); ?>
                    <?php echo checkError($error, 'database'); ?>
                </div>
            </div>
    </div>
</body>
</html>