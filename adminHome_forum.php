<?php
    require_once 'sessionAdmin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Admin - Home Page</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Home</h1>
        <div class="navBar"><?php require_once 'navigationAdmin.php'; ?></div>
    </div>
    <div class="welcomeMsg"><br><h3>Welcome <?php echo $_SESSION['name']; ?></h3></div>
    <div class="container">
    </div>
</body>
</html>