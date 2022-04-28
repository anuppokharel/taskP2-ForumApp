<?php
    require 'confidential.php';
    require 'functions.php';

    session_start();
    if(!isset($_SESSION['id'])) {
        header('location: login_forum.php?msg=3');
    }
    
    $tokenForumId = $_GET['fid'];
    $tokenUserId = $_SESSION['id'];

    try {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sql = "insert into tbl_forum_likes (action, forum_id, user_id) values('like', $tokenForumId, $tokenUserId) on duplicate key update action = 'like'";

        if(mysqli_query($connection, $sql)) {
            header("location: read.php?fid=$tokenForumId");
        }
    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    echo checkError($error, 'database');
    
?>