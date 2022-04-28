<?php
    require_once 'session.php';
    require_once 'functions.php';
    require_once 'confidential.php';

    $type = $_GET['type'];
    $token = $_GET['id'];

    try {
        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if($type == 'admin') {
            $sql = "delete from tbl_admins where id = $token";
        } else if($type == 'user') {
            $sql = "delete from tbl_users where id = $token";
        } else if($type == 'list') {
            $sql = "delete from tbl_forums where id = $token";
        } else if($type == 'category') {
            $sql = "delete from tbl_categories where id = $token";
        } else if($type == 'userPost') {
            $sql = "delete from tbl_forums where id = $token";
        }

        mysqli_query($connection, $sql);
        
        if($type == 'list') {
            header('location: list_forum.php');
        } else if($type == 'category') {
            header('location: categories_forum.php');
        } else if($type == 'userPost') {
            header('location: profile_forum.php');
        } else {
            header('location: status_forum.php');
        }
    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    echo checkError($error, 'database');
?>