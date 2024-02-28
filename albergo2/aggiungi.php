<?php
$servername = "localhost";
$username = "paolo";
$password = "12345";
$dbname = "albergo2";

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controllo della connessione
if ($conn->connect_error) {
    die("Connessione al database fallita: " . $conn->connect_error);
}

// Recupero dei dati inviati dalla richiesta AJAX
$id = $_POST['id'];
$menu = $_POST['menu'];
$orarioApertura = $_POST['orarioApertura'];
$orarioChiusura = $_POST['orarioChiusura'];

// Preparazione e esecuzione della query di inserimento
$sql = "INSERT INTO bar (id, menu, OrarioApertura, OrarioChiusura) VALUES ('$id', '$menu', '$orarioApertura', '$orarioChiusura')";
if ($conn->query($sql) === TRUE) {
    echo "Record inserito con successo";
} else {
    echo "Errore durante l'inserimento del record: " . $conn->error;
}

// Chiusura della connessione
$conn->close();
?>
