<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sensori_db";

// Crea connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Controlla connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}
?>
