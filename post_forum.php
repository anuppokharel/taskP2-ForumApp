<?php
    // Including all the important pages

    require_once 'session.php';
    require_once 'functions.php';
    require_once 'confidential.php';

    // Setting variables empty string & error empty array.

    $error = [];
    $categories = [];

    // Checking if the admin button is pressed and if it is pressed storing the form value onto variables.

    if(isset($_POST['btnPost'])) {
        if(verifyForm($_POST, 'title')) {
            $title = $_POST['title'];
            if(strlen($title) > 20) {
                $error['title'] = 'Enter less then 20 characters';
            }
        } else {
            $error['title'] = 'Enter your title';
        }

        if(verifyForm($_POST, 'description')) {
            $description = $_POST['description'];
        } else {
            $error['description'] = 'Enter atleast 25 characters in description.';
        }

        if(verifyForm($_POST, 'category')) {
            $category = $_POST['category'];
        } else {
            $error['category'] = 'Select the post category';
        }

        if(isset($_FILES['image'])) {
            if($_FILES['image']['error'] == 0) {
                if($_FILES['image']['size'] <= 10240000) {
                    $imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if(in_array($_FILES['image']['type'], $imageTypes)) {
                        $image = uniqid() . '_' . $_FILES['image']['name'];
                        move_uploaded_file($_FILES['image']['tmp_name'], 'images/' . $image);
                    } else {
                        $error['image'] = 'Upload valid image type';
                    }
                } else {
                    $error['image'] = 'Upload less then 512kb image';
                }   
            } else {
                $error['image'] = 'Upload valid image';
            }
        } else {
            $error['image'] = 'Upload image';
        }

        // Inititalize the database queries

        if(count($error) == 0) {
            try {
                // Database connection

                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Storing the users id from session

                $posted_by = $_SESSION['id'];

                // Insert into database

                $sql = "insert into tbl_forums(title, description, image, category_id, posted_by) values('$title', '$description', '$image', '$category', '$posted_by');";

                // Query execution

                if(mysqli_query($connection, $sql)) {
                    $successMsg = 'You have successfully posted.';
                }

            } catch(Exception $e) {
                $error['database'] = $e -> getMessage();
            }

            try {
                // Database connection

                $connectionLike = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Insert into database

                $likeSql = "insert into tbl_forum_likes(title, user_id) values('$title', '$posted_by')";

                // Query execution

                mysqli_query($connectionLike, $likeSql);

                $title = $description = '';

            } catch(Exception $e) {
                $error['database'] = $e -> getMessage();
            }
        }
    }
    try {
        $connectionView = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        $sqlView = "select * from tbl_categories where status = '1'";
        
        $resultView = mysqli_query($connectionView, $sqlView);
        
        if(mysqli_num_rows($resultView) > 0) {
            while($row = mysqli_fetch_assoc($resultView)) {
                array_push($categories, $row);
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
    <title>Forums</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Create a post</h1>
        <?php require 'navigationUser.php'; ?>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
            <div class="post">
                <div class="items title">
                    <label for="title">title</label><br>
                    <input type="text" name="title" id="title" value="<?php if(isset($title)) { echo $title; } ?>">
                </div>
                <?php echo checkError($error, 'title'); ?>
                <div class="items description">
                    <label for="description">description</label><br>
                    <textarea name="description" id="description" cols="30" rows="10"><?php if(isset($description)) { echo $description; } ?></textarea>
                </div>
                <?php echo checkError($error, 'description'); ?>
                <div class="items category">
                    <label for="category">category</label><br>
                    <select name="category" id="category">
                        <option value="">Select Category</option>   
                        <?php forEach($categories as $category) { ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo $category['title']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <?php echo checkError($error, 'category'); ?>
                <div class="items image">
                    <label for="image">add image</label><br>
                    <input type="file" name="image" id="image">            
                </div>
                <?php echo checkError($error, 'image'); ?>
                <?php if(isset($uploadMsg)) {
                    echo '<b><span class="success">' . $uploadMsg . '</span></b>';
                } ?>
                <div class="btnPost">
                    <br><button type="submit" name="btnPost">Post</button>
                </div>
                <?php if(isset($successMsg)) {
                    echo '<b><span class="success">' . $successMsg . '</span></b>';
                } ?>
                <?php echo checkError($error, 'database'); ?>
            </div>
        </form>
    </div>
</body>
</html>