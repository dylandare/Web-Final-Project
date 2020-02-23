<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Very Own Journal</title>
    <link href="https://fonts.googleapis.com/css?family=Dancing+Script&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

</head>
<style>
    body{
        margin:0px;
        padding:0px;
        background-color:#FCF3CF;
    }

    h1{
        font-family: 'Dancing Script';
        background-color:#F7DC6F;
        width:30%;
        text-align:center;
        padding:10px;
    }

    form{
        padding-top:80px;
        width:50%;
        margin:auto;
        text-align:center;
    }
    
    form{
        font-family: 'Open Sans';
    }

    p{
        text-align:center;
        font-family: 'Open Sans';
    }
</style>

<body>

<h1>My Very Own Journal</h1>

<form action="login.php" method="post">
    Email: <br> <input type="text" name="email">
    <br><br>
    Password: <br> <input type="password" name="password">
    <br><br>
    <input type="submit" name="submit" value="Login">
    <br><br>
    <a href="register.php">Register</a>
</form>
</body>
</html>

<?php
    session_start();

    if($_GET['logout']==1 AND ($_SESSION['id'])){
        session_destroy();
        echo '<p>You have logged out</p>';
        session_start();
    }

$db = new mysqli('localhost', '58548', 'dylan990222', '58548db2');
if(mysqli_connect_errno()){
    echo '<p>Error connecting to database</p>';
    exit;
}

else{
    
}

if($_POST['submit']=="Login"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "SELECT `id`, `email`, `password` FROM users WHERE `email` = ? AND `password` = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $stmt->bind_result($id, $email, $password);
    $stmt->store_result();
    $stmt->fetch();

    if($stmt->num_rows>0){
        $_SESSION['id'] = $id;
        header('Location: home.php');
    }

    else{
        echo '<br>Wrong email or password';
    }
}

$db->close();
?>