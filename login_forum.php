<?php
    // Including all the required pages.

    require_once 'functions.php';
    require_once 'confidential.php';

    // Redirecting to user home page if already logged in.

    session_start();
    if(isset($_SESSION['email'])) {
        header('location: home_forum.php');
    }

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

                $sql = "select * from tbl_users where email = '$email' and password = '$encPassword' and status = 1";

                // Query execution

                $result = mysqli_query($connection, $sql);

                // Checking if database has any data stored in it

                if(mysqli_num_rows($result) == 1) {
                    // Fetch user records using fetch

                    $user = mysqli_fetch_assoc($result);

                    // Store extra data onto session

                    $_SESSION['id'] = $user['id'];
                    $_SESSION['name'] = $user['name'];
                    $_SESSION['email'] = $email;

                    // Checkbox remember 

                    if(isset($_POST['remember'])) {
                        // Set Cookie to store data

                        setcookie('email', $email, time() + (7 * 24 * 60 * 60));
                    }

                    // Redirect to home page

                    header('location:home_forum.php');
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
        <h1 class="mainHeading">Forum - Login Page</h1>
        <?php require 'navigationPublic.php' ?>
    </div>
    <div class="container">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginForm" onsubmit="return validateForm();">
            <div class="items email">
                <label for="email">email</label><br>
                <input type="text" name="email" id="email">
                <span class="error emailErr"></span>
            </div>
            <?php echo checkError($error, 'email'); ?>
            <div class="items password">
                <label for="password">password</label><br>
                <input type="password" name="password" id="password">
                <span class="error passwordErr"></span>
            </div>
            <?php echo checkError($error, 'password'); ?>
            <div class="items remember">
                <input type="checkbox" name="remember" id="remember">Remember me
            </div>
            <div class="items btnSubmit">
                <button type="submit" name="login">Login</button>
            </div>
            <?php echo checkError($error, 'login'); ?>
            <?php
                if(isset($_GET['msg']) && $_GET['msg'] == 1) {
                    echo '<b><span class="error">Please login to continue.</span></b>';
                } else if(isset($_GET['msg']) && $_GET['msg'] == 2) {
                    echo '<b><span class="success">Logout successful.</span></b>';
                } else if(isset($_GET['msg']) && $_GET['msg'] == 3) {
                    echo '<b><span class="error">Login is required to like or comment on the post.</span></b>';
                }
            ?>
            <div class="items">
                <a href="adminLogin_forum.php">Admin Login?</a>
            </div>
            <div class="items">
                <a href="register_forum.php">Register?</a>
            </div>
        </form>
    </div>

    <!-- JavaScript & jQuery -->
    <script src="lib/jquery/jQuery.js"></script>
    <script src="lib/jquery/dist/jquery.validate.js"></script>
    <script src="scripts.js"></script>
</body>
</html>