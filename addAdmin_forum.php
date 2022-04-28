<?php
    // Including all the important pages

    require_once 'sessionAdmin.php';
    require_once 'functions.php';
    require_once 'confidential.php';

    // Setting variables empty string & error empty array.

    $error = [];
    $name = $email = $password = '';

    // Checking if the admin button is pressed and if it is pressed storing the form value onto variables.

    if(isset($_POST['addAdmin'])) {
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

                $sql = "insert into tbl_admins(name, email, password) values('$name', '$email','$password');";

                // Query execution

                if(mysqli_query($connection, $sql)) {
                    $successMsg = 'You have successfully added a new admin.';
                }
            } catch(Exception $e) {
                $error['admin'] = $e -> getMessage();
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
    <title>Admin - Add Admin</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Add Admin</h1>
        <div class="navBar"><?php require_once 'navigationAdmin.php'; ?></div>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
            <div class="items name">
                <label for="name">name</label>
                <input type="text" name="name" id="name">
            </div>
            <?php echo checkError($error, 'name'); ?>
            <div class="items email">
                <label for="email">email</label>
                <input type="email" name="email" id="email">
            </div>
            <?php echo checkError($error, 'email'); ?>
            <div class="items password">
                <label for="password">password</label>
                <input type="password" name="password" id="password">
            </div>
            <?php echo checkError($error, 'password'); ?>
            <div class="items btnSubmit">
                <button type="submit" name="addAdmin">Add Admin</button>
            </div>
            <?php if(isset($successMsg)) { ?>
                <b><span class="success"><?php echo $successMsg; ?></span></b>
            <?php } ?>
            <b><?php echo checkError($error, 'admin'); ?></b>
        </form>
    </div>
</body>
</html>