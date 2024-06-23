<?php
include 'config.php'; // Include il file di configurazione del database

$message = ""; // Variabile per memorizzare i messaggi

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Controlla se l'username esiste già
    $sql = "SELECT username FROM users WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            // Username non esiste, procedi con la registrazione
            $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ss", $username, $password);
                if ($stmt->execute()) {
                    $message = "Registrazione completata con successo. Effettua il tuo primo accesso.";
                    // Redireziona alla pagina di login
                    header("Location: http://localhost/IoT_prog/sito/login.php");
                } else {
                    $message = "Errore nella registrazione.";
                }
            }
        } else {
            $message = "Username già esistente.";
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
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
        <h1>Registrazione</h1>
    </header>
    <div class="container">
        <form action="register.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Registrati</button>
        </form>
        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
    </div>
</body>
</html>
