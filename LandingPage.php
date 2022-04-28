<?php
    require_once 'functions.php'
    require_once 'confidential.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Forum Page</title>
</head>
<body>
    <div class="container">
        
    </div>
</body>
</html>

<!-- select f.*,c.title as category_title,u.name from forums as f join categories as c 
on f.category_id=c.id join users as u on f.posted_by=u.id where f.id=$id  -->