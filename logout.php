<?php
    session_start();
    unset($_SESSION);
    session_destroy();
    setcookie('email', null, time() - 1);
    header('location: login_forum.php?msg=2');
?>