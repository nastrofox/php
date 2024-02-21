<?php
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "albergo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
$sql = "SELECT id, nome_hotel, citta FROM tabella_hotel";
$result = $conn->query($sql);
$conn->close();
?>

<html>
<head>
    <style>
    </style>
</head>
<body style="background-color: #2d90e7;">
    <h1 style="text-align: center;">Login Utente</h1><br><br><br><br>
    <form method="post" action="home.html" style="text-align: center;">
        Username<br>
        <input type="text" name="user"><br><br>
        Password<br>
        <input type="password" name="password">
        <br><br>
        <input type="submit">
    </form>
</body>
</html>
