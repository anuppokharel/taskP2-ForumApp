<?php
    // Including all the important pages

    require_once 'functions.php';
    require_once 'confidential.php';

    // Setting variables empty string & error empty array.

    $error = [];
    $name = $email = $message = $password = '';

    // Checking if the contact button is pressed and if it is pressed storing the form value onto variables.

    if(isset($_POST['contact'])) {
        if(verifyForm($_POST, 'name')) {
            $name = $_POST['name'];

            // Checkin for regular expression match.

            if(!preg_match ("/^[a-z A-Z]+$/", $name)) {
                $error['name'] = 'Name must only contain characters and space';
            }
        } else {
            $error['name'] = 'Enter your name';
        }

        if(verifyForm($_POST, 'email')) {
            $email = $_POST['email'];

            // Validating email address.

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'Enter validate email address';
            }
        } else {
            $error['email'] = 'Enter your email address';
        }

        if(verifyForm($_POST, 'message')) {
            $message = $_POST['message'];
        } else {
            $error['message'] = 'Enter your message';
        }

        if(verifyForm($_POST, 'password')) {

            // Encrypting password using md5 format.

            $password = md5($_POST['password']);
        } else {
            $error['password'] = 'Enter your password';
        }

        // Inititalize the database queries

        if(count($error) == 0) {
            try {
                // Database connection

                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Insert into database

                $sql = "insert into tbl_contact(name, email, message, password) values('$name', '$email', '$message', '$password');";

                // Query execution

                if(mysqli_query($connection, $sql)) {
                    $successMsg = 'You have successfully placed a new contact message.';
                }
            } catch(Exception $e) {
                $error['contact'] = $e -> getMessage();
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
    <title>Forum - Contact Page</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Forum - Contact Page</h1>
        <?php require 'navigationPublic.php' ?>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="items name">
                <label for="name">name</label><br>
                <input type="text" name="name" id="name">
            </div>
            <?php echo checkError($error, 'name'); ?>
            <div class="items email">
                <label for="email">email</label><br>
                <input type="email" name="email" id="email">
            </div>
            <?php echo checkError($error, 'email'); ?>
            <div class="items message">
                <label for="message">Message</label><br>
                <textarea name="message" id="message" cols="30" rows="10"></textarea>
            </div>
            <div class="items password">
                <label for="password">password</label><br>
                <input type="password" name="password" id="password">
            </div>
            <?php echo checkError($error, 'password'); ?>
            <div class="items btnSubmit">
                <br><button type="submit" name="contact">Contact</button>
            </div>
            <?php if(isset($successMsg)) { ?>
                <b><span class="success"><?php echo $successMsg; ?></span></b>
            <?php } ?>
            <b><?php echo checkError($error, 'contact'); ?></b>
        </form>
    </div>
</body>
</html>