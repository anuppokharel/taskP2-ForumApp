<?php
    require 'confidential.php';
    require 'functions.php';
    
    session_start();

    $error = [];
    $posts = [];
    $likes = [];
    $totalLike = [];
    $comments = [];
    $userId = $_SESSION['id'];
    $tokenForumId = $_GET['fid'];
    $tokenForumTitle = $_GET['title'];
    
    
    try {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        $sql = "select tbl_forums.*, tbl_categories.title as category_title, tbl_users.name from tbl_forums join tbl_categories on tbl_forums.category_id = tbl_categories.id join tbl_users on tbl_forums.posted_by = tbl_users.id where tbl_forums.id = $tokenForumId";

        $result = mysqli_query($connection, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($posts, $row);
            }
        }
        
    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }
    
    try {
        $connectionLike = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sqlLike = "select * from tbl_forum_likes where forum_id = $tokenForumId and user_id = $userId";

        $resultLike = mysqli_query($connectionLike, $sqlLike);
        
        if(mysqli_num_rows($resultLike) > 0) {
            while($rows = mysqli_fetch_assoc($resultLike)) {
                array_push($likes, $rows);
            }
        }
        
    } catch(Exception $e) {}
    
    try {
        $connectionLike = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql = "select * from tbl_forum_likes where forum_id = $tokenForumId";

        $result = mysqli_query($connectionLike, $sql);
        
        if(mysqli_num_rows($result) > 0) {
            while($rows = mysqli_fetch_assoc($result)) {
                array_push($totalLike, $rows);
            }
        } $totalLikes = count($totalLike);
        
    } catch(Exception $e) {}
    
    try {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql = "select id from tbl_forum_replies where forum_id = '$tokenForumId'";
        
        $result = mysqli_query($connection, $sql);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                array_push($comments, $row);
            }
        }

    } catch(Exception $e) {
        $error['database'] = 'Database error';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Forum - <?php echo $_GET['title']; ?></title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Forum - Home</h1>
        <?php require 'navigationPublic.php'; ?>
    </div>
    <div class="container">
    <div class="mainCard">
        <img src="images/<?php echo $posts[0]['image']; ?>" style="height:300px; width:300px;">
        <div class="cardHeader">
            <h3><?php echo $posts[0]['title']; ?></h3>
            <p class="category"><?php echo $posts[0]['category_title']; ?></p>
        </div>
        <div class="description">
                <p><?php echo $posts[0]['description']; ?></p>
        </div>
        <div class="likeComment">
            <small><?php if(isset($totalLikes)) { echo $totalLikes . ' Like '; } else { echo '0 Likes '; } ?>and<?php if(isset($comments)) { echo ' ' . count($comments) . ' Comment'; } else { echo ' 0 Comments'; } ?></small>
        </div>
        <div class="action">
            <div class="button">
                <?php if (isset($likes[0]['user_id']) && isset($_SESSION['id']) && $likes[0]['user_id'] == $_SESSION['id']) { ?>
                    <button><a href="unlike.php?fid=<?php echo $posts[0]['id']; ?>&title=<?php echo $posts[0]['title']; ?>" id="like">Liked</a></button>
                <?php } else { ?>
                    <button><a href="like.php?fid=<?php echo $posts[0]['id']; ?>&title=<?php echo $posts[0]['title']; ?>" id="like">Like</a></button>
                <?php } ?>
                <button><a href="comment.php?fid=<?php echo $posts[0]['id']; ?>">Comment</a></button>
                <button><a href="">Share</a></button>
            </div>
            <div class="author"><small>Posted by - <i><?php echo $posts[0]['name']; ?></i></small></div>
        </div>
        <div class="msg">
            <?php if(isset($_GET['msg']) && $_GET['msg'] == 1) { ?>
                <p class="error">Login to like the post.</p>
            <?php } ?>
        </div>
        <div class="error">
            <?php echo checkError($error, 'fetch'); ?>
            <?php echo checkError($error, 'database'); ?>
        </div>
    </div>

    <script src="lib/jquery/jQuery.js"></script>
    <script src="lib/jquery/dist/jquery.validate.js"></script>
    <script src="scripts.js"></script>
</body>
</html>