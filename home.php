<?php
    session_start();
    if(!isset($_SESSION['id'])){
        echo 'Please login first';
        exit;
    }

$db = new mysqli('localhost', 'root', '', 'practice');
if(mysqli_connect_errno()){
    echo '<p>Error connecting to database</p>';
    exit;
}

else{
    
}

?>

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

    .mytable{
        margin-left:auto;
        margin-right:auto;
        margin-bottom:60px;
        font-family: 'Open Sans';
    }

    table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align:center;
}

    td{
        padding:6px;
    }
</style>

<body>

<h1>My Very Own Journal</h1>

<form action="home.php" method="post">
    ID: <input type="number" name="id" placeholder="ID to edit/delete">
    <input type="submit" name="submit" value="Delete">
    <br><br>
    Date: <input type="date" name="date"> 
    <input type="submit" name="submit" value="Search Date">
    <br><br>
    Day: <input type="text" name="day" placeholder="Saturday"> 
    <input type="submit" name="submit" value="Search Day">
    <br><br>
    Entry: <br><textarea name="entry" cols="80" rows="15"></textarea>
    <br>
    <input type="submit" name="submit" value="Submit">
    <input type="submit" name="submit" value="Read All">
    <input type="submit" name="submit" value="Update">
</form>
<p><a href="login.php?logout=1">Log Out</a></p>
</body>
</html>

<?php
if($_POST['submit'] == 'Submit'){
    $date = $_POST['date'];
    $datef = date("Y-m-d", strtotime($date));
    $day = $_POST['day'];
    $entry = $_POST['entry'];
    $query = "INSERT INTO entries(`date`, `day`, `entry`) VALUES(?,?,?)";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $datef, $day, $entry);
    $stmt->execute();
}

else if($_POST['submit'] == 'Delete'){
    $id = $_POST['id'];
    $query = "DELETE FROM entries WHERE id=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
}

else if($_POST['submit'] == 'Read All'){
    $query = "SELECT `id`, `date`,`day`, `entry` FROM `entries`";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->bind_result($id, $date, $day, $entry);
    echo'<table class="mytable">';
    echo '<tr><th>ID</th><th>Date</th><th>Day</th><th>Entry</th></tr>';
    while($stmt->fetch()){
        echo '<tr>';
        echo '<td>'.$id.'</td><td>'.$date.'</td><td>'.$day.'</td>'.'<td>'.$entry.'</td>';
        echo '</tr>';
    }
    echo'</table>';
}

else if($_POST['submit']=='Update'){
    $id = $_POST['id'];
    $date = $_POST['date'];
    $day = $_POST['day'];
    $entry = $_POST['entry'];
    $query = "UPDATE entries SET `date` = ?, `day` = ?, `entry` = ? WHERE id = $id";
    $stmt = $db->prepare($query);
    $stmt->bind_param('sss', $date, $day, $entry);
    $stmt-> execute();
}

else if($_POST['submit'] == 'Search Day'){
    $day = $_POST['day'];
    $query = "SELECT `id`, `date`, `entry` FROM `entries` WHERE `day` = '$day'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->bind_result($id, $date, $entry);
    echo '<table class="mytable">';
    echo '<tr><th>ID</th><th>Date</th><th>Day</th><th>Entry</th></tr>';
    while($stmt->fetch()){
        echo '<tr>';
        echo '<td>'.$id.'</td><td>'.$date. '</td><td>'. $day. '</td><td>'.$entry. '</td>';
        echo '<tr>';
    }
    echo '</table>';
}

else if($_POST['submit'] == 'Search Date'){
    $date = $_POST['date'];
    $query = "SELECT `id`, `day`, `entry` FROM `entries` WHERE `date` = '$date'";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $stmt->bind_result($id, $day, $entry);
    echo '<table class="mytable">';
    echo '<tr><th>ID</th><th>Date</th><th>Day</th><th>Entry</th></tr>';
    while($stmt->fetch()){
        echo '<tr>';
        echo '<td>'.$id.'</td><td>'.$date. '</td><td>'. $day. '</td><td>'.$entry. '</td>';
        echo '<tr>';
    }
    echo '</table>';
}

?>