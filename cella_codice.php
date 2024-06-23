<?php
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
</head>
<body>
    <h1>Verifica Disponibilità Prodotti</h1>
    <form action="verifica_disponibilita.php" method="post">
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
