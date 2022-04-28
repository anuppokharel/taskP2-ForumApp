<?php
    session_start();
    if(!isset($_SESSION['id'])) {
        header('location: login_forum.php?msg=3');
    }

    $tokenForumId = $_GET['fid'];
    $tokenUserId = $_SESSION['id'];

    require 'confidential.php';
    require 'functions.php';

    $error = [];
    $forums = [];
    $comments = [];

    try {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql = "select tbl_forums.*, tbl_categories.title as category_title, tbl_users.name as user_name from tbl_forums as tbl_forums join tbl_categories on tbl_forums.category_id = tbl_categories.id join tbl_users on tbl_forums.posted_by = tbl_users.id where tbl_forums.id = '$tokenForumId'";

        $result = mysqli_query($connection, $sql);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($forums, $row);
            }
        } else {
            $error['database'] = 'Database error';
        }

    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    try {
        $connectionReadComment = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sqlReadComment = "select tbl_forum_replies.*, tbl_users.name as user_name from tbl_forum_replies as tbl_forum_replies join tbl_users on tbl_forum_replies.reply_by = tbl_users.id where tbl_forum_replies.forum_id = '$tokenForumId'";

        $resultReadComment = mysqli_query($connectionReadComment, $sqlReadComment);

        if(mysqli_num_rows($resultReadComment) > 0) {
            while($row = mysqli_fetch_assoc($resultReadComment)) {
                array_push($comments, $row);
            }
        }
    } catch(Exception $e) {
        $error['database'] = 'Database error';
    }
    
    if(isset($_POST['comment'])) {
        if(verifyForm($_POST, 'comment')) {
            $comment = $_POST['comment'];
        } else {
            $error['comment'] = 'Enter atleast 5 characters';
        }
        if(count($error) == 0) {
            try {
                $connectionComment = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                echo $sqlComment = "insert into tbl_forum_replies(reply, forum_id, reply_by) values('$comment', '$tokenForumId', '$tokenUserId')";

                if(mysqli_query($connectionComment, $sqlComment)) {
                    header("location: comment.php?fid=$tokenForumId");
                }

            } catch(Exception $e) {
                $error['database'] = 'Database connection error';
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
        <h1 class="mainHeading">Forum - Home</h1>
        <?php require 'navigationPublic.php'; ?>
    </div>
    <div class="container">
        <?php foreach($forums as $forum) { ?>
            <div class="mainCard">
                <img src="images/<?php echo $forum['image']; ?>" style="height:300px; width:300px;">
                <div class="cardHeader">
                    <h3><?php echo $forum['title']; ?></h3>
                    <p class="category"><?php echo $forum['category_title']; ?></p>
                </div>
                <div class="info">
                    <small><?php echo $forum['posted_date'] . ' by <i>' . $forum['user_name'] . '</i>'; ?></small>
                </div>
                <div class="description">
                    <p><?php echo $forum['description']; ?></p>
                </div>
                <div class="action">
                    <h4>Comments</h4>
                    <?php if(!count($comments) == 0) { ?>
                        <div class="scroll-container"> 
                            <?php foreach($comments as $key => $eachComment) { ?>
                                <div class="comment">
                                    <p style="font-weight: 250"><?php echo $eachComment['reply']; ?></p>
                                    <small style="font-size:12.5px;"><?php echo 'Commented by <i>' . $eachComment['user_name'] . '</i> on ' . $eachComment['reply_date']; ?></small>
                                </div>
                            <?php } ?>                        
                        </div>
                    <?php } ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?fid=<?php echo $forum['id'] ?>" method="post">
                        <textarea name="comment" id="comment" cols="40" rows="1" placeholder="Write a comment."></textarea><br>
                        <button type="submit" name="btnSubmit">Comment</button>
                    </form>
                </div>
                <div class="error">
                    <?php echo checkError($error, 'get') ?>
                </div>
            </div>
        <?php } ?>
    </div>
</body>
</html>