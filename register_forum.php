<?php
    // Including all the important pages

    require_once 'functions.php';
    require_once 'confidential.php';

    // Setting variables empty string & error empty array.

    $error = [];
    $name = $phone = $email = $password = $address = '';

    // Checking if the register button is pressed and if it is pressed storing the form value onto variables.

    if(isset($_POST['register'])) {
        if(verifyForm($_POST, 'name')) {
            $name = $_POST['name'];

            // Checkin for regular expression match.

            if(!preg_match ("/^[a-z A-Z]+$/", $name)) {
                $error['name'] = 'Name must only contain characters and space';
            }
        } else {
            $error['name'] = 'Enter your name';
        }

        if(verifyForm($_POST, 'phone')) {
            $phone = $_POST['phone'];
        } else {
            $error['phone'] = 'Enter your phone number';
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

        if(verifyForm($_POST, 'password')) {

            // Encrypting password using md5 format.

            $password = md5($_POST['password']);
        } else {
            $error['password'] = 'Enter your password';
        }

        if(verifyForm($_POST, 'address')) {
            $address = $_POST['address'];
        } else {
            $error['address'] = 'Enter your address';
        }

        // Inititalize the database queries

        if(count($error) == 0) {
            try {
                // Database connection

                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Insert into database

                $sql = "insert into tbl_users(name, phone, email, password, address) values('$name','$phone','$email','$password','$address');";

                // Query execution

                if(mysqli_query($connection, $sql)) {
                    $successMsg = 'You have successfully registered.';
                }

                $name = $phone = $email = $password = $address = '';
            } catch(Exception $e) {
                $error['register'] = $e -> getMessage();
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
    <title>Forum - Register Page</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Register</h1>
        <?php require 'navigationPublic.php' ?>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="registerForm">
            <div class="register">
                <div class="items name">
                    <label for="name">name</label><br>
                    <input type="text" name="name" id="name" value="<?php echo $name; ?>">
                </div>
                <?php echo checkError($error, 'name'); ?>
                <div class="items phone">
                    <label for="phone">phone</label><br>
                    <input type="number" name="phone" id="phone" value="<?php echo $phone; ?>">
                </div>
                <?php echo checkError($error, 'phone'); ?>
                <div class="items email">
                    <label for="email">email</label><br>
                    <input type="email" name="email" id="email" value="<?php echo $email; ?>">
                    <span id="registerEmail"></span>
                </div>
                <?php echo checkError($error, 'email'); ?>
                <div class="items password">
                    <label for="password">password</label><br>
                    <input type="password" name="password" id="password">
                </div>
                <?php echo checkError($error, 'password'); ?>
                <div class="items address">
                    <label for="address">address</label><br>
                    <input type="text" name="address" id="address" value="<?php echo $address; ?>">
                </div>
                <?php echo checkError($error, 'address'); ?>
                <div class="items btnSubmit">
                    <button type="submit" name="register">Register</button>
                </div>
                <?php if(isset($successMsg)) { ?>
                    <b><span class="success"><?php echo $successMsg; ?></span></b>
                <?php } ?>
                <b><?php echo checkError($error, 'register'); ?></b>
                <div class="items">
                    <a href="login_forum.php">Login?</a>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript & jQuery -->

    <script src="lib/jquery/jQuery.js"></script>
    <script src="lib/jquery/dist/jquery.validate.js"></script>
    <script src="scripts.js"></script>
</body>
</html>