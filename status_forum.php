<?php
    // Including all the important pages

    require_once 'sessionAdmin.php';
    require_once 'functions.php';
    require_once 'confidential.php';

    $error = [];
    $dataAdmins = [];
    $dataUsers = [];

    try {
        // Database connection

        $connection = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Selecting data and storing it into SQL variable

        $sqla = "select * from tbl_admins";
        $sqlu = "select * from tbl_users";

        // Query execution and return result object 

        $resulta = mysqli_query($connection, $sqla);
        $resultu = mysqli_query($connection, $sqlu);

        // Check no of rows

        if(mysqli_num_rows($resulta) > 0) {
            while($rowa = mysqli_fetch_assoc($resulta)) {
                array_push($dataAdmins, $rowa);
            }
        }

        if(mysqli_num_rows($resultu) > 0) {
            while($rowu = mysqli_fetch_assoc($resultu)) {
                array_push($dataUsers, $rowu);
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
    <title>Admin - User Status</title>
</head>
<body>
    <div class="header">
        <h1 class="mainHeading">User Status</h1>
        <div class="navBar"><?php require_once 'navigationAdmin.php'; ?></div>
    </div>
    <div class="container">
        <div class="status-data">
            <h3>Admin data</h3><br>
            <div class="admin">
                <table border="1">
                    <tr>
                        <td>SN</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                    <?php foreach($dataAdmins as $key => $data) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $data['name'] ?></td>
                            <td><?php echo $data['email'] ?></td>
                            <td><?php echo $data['status'] ?></td>
                            <td>
                                <a href="unblock.php?id=<?php echo $data['id']; ?>&type=admin" onclick="return confirm('Unblock the admin?');">Unblock</a>
                                <a href="block.php?id=<?php echo $data['id']; ?>&type=admin" onclick="return confirm('Block the admin?');">Block</a><br>
                                <a href="delete.php?id=<?php echo $data['id']; ?>&type=admin" onclick="return confirm('Delete the admin informations?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <h3>User data</h3>
            <div class="user"><br>
                <table border="1">
                    <tr>
                        <td>SN</td>
                        <td>Name</td>
                        <td>Email</td>
                        <td>Status</td>
                        <td>Action</td>
                    </tr>
                    <?php foreach($dataUsers as $key => $data) { ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $data['name'] ?></td>
                            <td><?php echo $data['email'] ?></td>
                            <td><?php echo $data['status'] ?></td>
                            <td>
                                <a href="unblock.php?id=<?php echo $data['id']; ?>&type=user" onclick="return confirm('Unblock the user?');">Unblock</a>
                                <a href="block.php?id=<?php echo $data['id']; ?>&type=user" onclick="return confirm('Block the user?');">Block</a><br>
                                <a href="delete.php?id=<?php echo $data['id']; ?>&type=user" onclick="return confirm('Delete the user informations?');">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <?php echo checkError($error, 'database'); ?>
        </div>
    </div>
</body>
</html>