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
    
    h2{
        text-align:center;
    }

    p{
        text-align:center;
    }
</style>

<body>

<h1>My Very Own Journal</h1>

<h2>Registration</h2>

<p><a href="login.php">Back to Login</a></p>

<form action="register.php" method="post">
    Email: <br> <input type="text" name="email">
    <br><br>
    Password: <br> <input type="password" name="password">
    <br><br>
    <input type="submit" name="submit" value="Register">
</form>
</body>
</html>

<?php

$db = new mysqli('localhost', 'root', '', 'practice');
if(mysqli_connect_errno()){
echo '<p>Error connecting to database</p>';
exit;
}

else{

}

if($_POST['submit'] == 'Register'){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $query = "INSERT INTO `users`(`email`, `password`) VALUES(?,?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    header('Location: login.php');
}

$db->close();
?>