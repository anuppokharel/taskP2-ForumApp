<?php
    require_once 'sessionAdmin.php';
    require_once 'functions.php';
    require_once 'confidential.php';
    
    $error = [];
    $categories = [];
    $title = $code = $rank = '';

    if(isset($_POST['submit'])) {
        if(verifyForm($_POST, 'title')) {
            $title = $_POST['title'];
        } else {
            $error['title'] = 'Enter the title';
        }
        if(verifyForm($_POST, 'code')) {
            $code = $_POST['code'];
        } else {
            $error['code'] = 'Enter the language';
        }
        if(verifyForm($_POST, 'rank')) {
            $rank = $_POST['rank'];
        } else {
            $error['rank'] = 'Enter the rank';
        }
        
        if(count($error) == 0) {
            try {
                $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
                $sqlInsert = "insert into tbl_categories(title, code, rank) values('$title', '$code', '$rank');";
                
                if(mysqli_query($connection, $sqlInsert)) {
                    $successMsg = 'Submited';
                }
                
            } catch(Exception $e) {
                $error['database'] = $e -> getMessage(); 
            }
        }
    }

    try {
        $connectionView = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        
        $sqlView = "select * from tbl_categories";
        
        $resultView = mysqli_query($connectionView, $sqlView);
        
        if(mysqli_num_rows($resultView) > 0) {
            while($row = mysqli_fetch_assoc($resultView)) {
                array_push($categories, $row);
            }
        }
    } catch(Exception $e) {
        $error['database'] = $e -> getMessage();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"/>
    <title>Admin - Manage Category</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">Manage Category</h1>
        <div class="navBar"><?php require 'navigationAdmin.php'; ?></div>
    </div>
    <div class="container">
        <div class="manage-category">
            <h3>View Category</h3><br>
            <table border="1">
                <tr>
                    <th>SN</th>
                    <th>Title</th>
                    <th>Code</th>
                    <th>Rank</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach($categories as $key => $data) { ?>
                    <tr>
                        <td><?php echo $key + 1 ?></td>
                        <td><?php echo $data['title']; ?></td>
                        <td><?php echo $data['code']; ?></td>
                        <td><?php echo $data['rank']; ?></td>
                        <td><?php echo $data['status']; ?></td>
                        <td>
                            <a href="unblock.php?id=<?php echo $data['id']; ?>&type=category" onclick="return confirm('Unblock category?');">Unblock</a>
                            <a href="block.php?id=<?php echo $data['id']; ?>&type=category" onclick="return confirm('Block category?');">Block</a><br>
                            <a href="delete.php?id=<?php echo $data['id']; ?>&type=category" onclick="return confirm('Delete category?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
            <h3>Add Category</h3><br>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="items title">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title">
                </div>
                <?php echo checkError($error, 'title'); ?>
                <div class="items code">
                    <label for="code">Code</label>
                    <input type="text" name="code" id="code">
                </div>
                <?php echo checkError($error, 'code'); ?>
                <div class="items rank">
                    <label for="rank">Rank</label>
                    <input type="rank" name="rank" id="rank">
                </div>
                <?php echo checkError($error, 'rank'); ?>
                <div class="items btnSubmit">
                    <button type="submit" name="submit" id="submit">Submit</button>
                </div>
                <div class="error">
                    <?php echo checkError($error, 'database'); ?>
                    <?php echo checkError($error, 'submit'); ?>
                </div>
                <div class="success">
                    <?php if(isset($successMsg)) { ?>
                        <b><span class="success"><?php echo $successMsg; ?></span></b>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</body>
</html>