<?php
session_start();
include 'config.php'; // Include il file di configurazione del database

// Query per ottenere i valori di cella_codice
$sql = "SELECT DISTINCT cella_codice FROM ultrasonic";
$result = $conn->query($sql);

// Verifica se ci sono risultati
$cella_codici = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $cella_codici[] = $row['cella_codice'];
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica Disponibilità Prodotti</title>
   <style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
     }
    header {
        background-color: rgba(255, 255, 255, 0.2); /* Sfondo del header con trasparenza */
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    h1 {
       color: blue;
    }
    .container {
        margin-top: 50px;
    }
    .container img {
        max-width: 100%;
        height: auto;
    }
    .buttons {
        margin-top: 20px;
    }
    .buttons a {
        display: inline-block;
        margin: 10px;
        padding: 15px 30px;
        color: #ffffff;
        text-decoration: none;
        background-color: #007bff; /* Sfondo blu */
        border-radius: 5px;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    .buttons a:hover {
        background-color: #0056b3; /* Cambio colore al passaggio del mouse */
    }
</style>
</head>
<body>
    <h1>Verifica Disponibilità Prodotti</h1>
    <form action="http://localhost/IoT_prog/sito/verifica_disponibilita.php" method="post">
        <label for="cella_codice">Codice Cella:</label>
        <select id="cella_codice" name="cella_codice" required>
            <?php foreach ($cella_codici as $codice): ?>
                <option value="<?php echo htmlspecialchars($codice); ?>"><?php echo htmlspecialchars($codice); ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Verifica</button>
    </form>
</body>
</html>
