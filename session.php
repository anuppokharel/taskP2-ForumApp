<?php    
    session_start();
    if(!isset($_SESSION['email'])) {
        header('location: login_forum.php?msg=1');
    }
?>