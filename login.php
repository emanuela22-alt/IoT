<?php
session_start();

include 'config.php'; // Include il file di configurazione del database

$message = ""; // Variabile per memorizzare i messaggi

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ottenere username e password dal modulo
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Query per verificare le credenziali dell'utente
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se l'utente esiste
    if ($result->num_rows > 0) {
        $_SESSION['username'] = $user;
        $_SESSION['password'] = $pass;
        // Redireziona alla pagina di verifica disponibilità
        header("Location: http://localhost/IoT_prog/sito/disponibil.php");
    } else {
        $message = "Credenziali non valide.";
    }

    // Chiudere la connessione
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<style>
    body {
        font-family: Arial, sans-serif;
        text-align: center;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }
    header {
        background-color: #007bff;
        color: #ffffff;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    h1 {
        color: #ffffff; /* Testo bianco */
    }
    .container {
        margin-top: 50px;
        padding: 20px;
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: inline-block;
    }
    form {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    label {
        margin-top: 10px;
        font-weight: bold;
        color: #333;
    }
    input {
        margin-top: 5px;
        padding: 10px;
        width: 80%;
        max-width: 300px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    button {
        margin-top: 20px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #ffffff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover {
        background-color: #0056b3;
    }
    .message {
        margin-top: 20px;
        color: red;
        font-weight: bold;
    }
</style>

</head>
<body>
    <header>
    <h1>Login</h1>
    </header>
<div class="container">
    <form action="login.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>
<?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
</div>
</body>
</html>

