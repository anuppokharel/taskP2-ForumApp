<?php
    // Including all the required pages.

    require_once 'functions.php';
    require_once 'confidential.php';

    // Setting variables empty string & error empty array.

    $error = [];

    if(isset($_POST['login'])) {
        if(verifyForm($_POST, 'email')) {
            $email = $_POST['email'];
        } else {
            $error['email'] = 'Enter your email';
        }

        if(verifyForm($_POST, 'password')) {
            $password = $_POST['password'];
        } else {
            $error['password'] = 'Enter your password';
        }

        // Initialize the database queries

        if(count($error) == 0) {
            try {
                // Database connection
            
                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

                // Decrypting the password and storing it into a variable.

                $encPassword = md5($password);

                // Check the data from database

                $sql = "select * from tbl_admins where email = '$email' and password = '$encPassword';";

                // Query execution

                $result = mysqli_query($connection, $sql);

                // Checking if database has any data stored in it

                if(mysqli_num_rows($result) == 1) {
                    // Fetch user records using fetch

                    $user = mysqli_fetch_assoc($result);

                    // Initialize the session

                    session_start();

                    // Store extra data onto session

                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $email;

                    // Checkbox remember 

                    if(isset($_POST['remember'])) {
                        // Set Cookie to store data

                        setcookie('email', $email, time() + (7 * 24 * 60 * 60));
                    }

                    // Redirect to home page

                    header('location:adminHome_forum.php');
                } else {
                    $error['login'] = 'No users found';
                }
            } catch(Exception $e) {
                die('Database connection error' . '<br>' . $e -> getMessage());
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
    <title>Forum - Login Page</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Admin - Login Panel</h1>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="items email">
                <label for="email">email</label><br>
                <input type="email" name="email" id="email">
            </div>
            <?php echo checkError($error, 'email'); ?>
            <div class="items password">
                <label for="password">password</label><br>
                <input type="password" name="password" id="password">
            </div>
            <?php echo checkError($error, 'password'); ?>
            <div class="items remember">
                <input type="checkbox" name="remember" id="remember">Remember me
            </div>
            <div class="items btnSubmit">
                <button type="submit" name="login">Login</button>
            </div>
            <div class="getMsg">
                <?php if(isset($_GET['msg']) && $_GET['msg'] == 1) { ?>
                    <b><span class='error'><?php $error['login'] = 'Not a admin.' ?></span></b>
                <?php } ?>
            </div>
            <div class="errorMsg">
                <?php echo checkError($error, 'login'); ?>
            </div>
            <a href="login_forum.php">Users Login?</a>
        </form>
    </div>
</body>
</html>