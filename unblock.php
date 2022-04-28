<?php
    require_once 'sessionAdmin.php';
    require_once 'confidential.php';

    // Get the id from the url and add onto variable

    $type = $_GET['type'];
    $token = $_GET['id'];

    try {
        // Database connection

        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Selecting data and storing it into variable

        if($type == 'admin') {
            $sql = "update tbl_admins set status = 1 where id = $token";
        } else if($type == 'user') {
            $sql = "update tbl_users set status = 1 where id = $token";
        } else if($type == 'list') {
            $sql = "update tbl_forums set status = 1 where id = $token";
        } else if($type == 'category') {
            $sql = "update tbl_categories set status = 1 where id = $token";
        }

        // Query execution

        mysqli_query($connection, $sql);
        
        // Redirecting to the original page

        if($type == 'list') {
            header('location: list_forum.php');
        } else if($type == 'category') {
            header('location: categories_forum.php');
        } else {
            header('location: status_forum.php');
        }
    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }
?>