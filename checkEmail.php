<?php
    require 'confidential.php';

    $email = $_POST['token'];

    $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = "Select * from tbl_users where email = '$email'";

    $result = mysqli_query($connection, $sql);

    if(mysqli_num_rows($result) == 1) {
        echo 'Email is already taken';
    } else {
        echo 'Email is available';
    }
    
?>