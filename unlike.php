<?php
    require 'confidential.php';
    require 'functions.php';

    session_start();
    if(!isset($_SESSION['id'])) {
        header('location: login_forum.php?msg=3');
    }
    
    $forumTitle = $_GET['title'];
    $tokenForumId = $_GET['fid'];
    $tokenUserId = $_SESSION['id'];

    try {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql = "delete from tbl_forum_likes where forum_id = $tokenForumId and user_id = '$tokenUserId'";

        if(mysqli_query($connection, $sql)) {
            header("location: read.php?id=$tokenUserId&fid=$tokenForumId&title=$forumTitle");
        }
    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    echo checkError($error, 'database');
    
?>