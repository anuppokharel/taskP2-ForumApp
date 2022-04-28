<?php
    require_once 'confidential.php'; 

    session_start();

    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
        try {        
            $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    
            $sql = "select * from tbl_admins where email = '$email';";
    
            $result = mysqli_query($connection, $sql);
    
            if(mysqli_num_rows($result) == 1) {
    
                $user = mysqli_fetch_assoc($result);
    
                $_SESSION['name'] = $user['name'];
                $checkedEmail = $user['email'];
    
                if(!isset($_SESSION['email'])) {
                    header('location:adminHome_forum.php');       
                }
            } else {
                $error['login'] = 'No admin found';
            }
        } catch(Exception $e) {
            die('Database connection error' . '<br>' . $e -> getMessage());
        }

        if($_SESSION['email'] == $checkedEmail) {
        } else {
            header('location: adminLogin_forum.php?msg=1');
        }
    } else {
        header('location: adminLogin_forum.php?msg=1');
    }     
?>