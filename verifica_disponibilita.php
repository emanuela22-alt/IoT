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
<header>
        <h1>Verifica Disponibilità Prodotti</h1>
<p>Nello spazio sottostante è mostrata la disponibilità nella cella scelta</p>
    </header>
</html>

    <?php
    session_start();

    include 'config.php'; // Include il file di configurazione del database

    function getUserId($conn, $username, $password) {
        $sql = "SELECT username FROM users WHERE username = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['username'];
        } else {
            return null;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['cella_codice'])) {
            $cella_codice = $_POST['cella_codice'];

            $sql = "SELECT u.data_ora, u.presenza, p.nome
                    FROM ultrasonic u
                    JOIN prodotto p ON u.cella_codice = p.cella_codice
                    WHERE u.cella_codice = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $cella_codice);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $data_ora = $row['data_ora'];
                    $presenza = $row['presenza'];
                    $nome = $row['nome'];
                    if ($presenza == 1) {
                        echo "\nIl prodotto $nome è disponibile nella cella $cella_codice - data: $data_ora.<br>";
                    } else {
                        echo "\nIl prodotto $nome non è disponibile nella cella $cella_codice - data: $data_ora.<br>";
                    }
                }
            } else {
                echo "Nessun prodotto trovato nella cella $cella_codice.";
            }
        }

      // Verifica se l'utente è loggato
    if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
        // Ottenere l'ID dell'utente autenticato
        $userId = getUserId($conn, $_SESSION['username'], $_SESSION['password']);

        if ($userId) {
            // Verifica se è stato inviato l'email
            if (isset($_POST['email'])) {
                // Ottenere l'email dal modulo
                $email = $_POST['email'];

                // Query per aggiornare l'email nella riga dell'utente
                $sql = "UPDATE users SET email = ? WHERE username = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $email, $_SESSION['username']);

                if ($stmt->execute()) {
                    echo "Email inserita correttamente.";
                } else {
                    echo "Errore nell'inserimento dell'email.";
                }

                $stmt->close();
            }
        } else {
            echo "Utente non trovato.";
        }
    } else {
        echo "Accesso non autorizzato.";
    }
}


    $conn->close();
    ?>

    <h1>Se vuoi verificare altre celle clicca qui</h1>
    <form action="http://localhost/IoT_prog/sito/disponibil.php" method="post">
        <button type="submit">VERIFICA</button>
    </form>

    <h1>Se vuoi rimanere aggiornato sulla disponibilità del prodotto inserisci la tua email nel campo sottostante</h1>
    <form action="http://localhost/IoT_prog/sito/verifica_disponibilita.php" method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <button type="submit">Invia</button>
    </form>
</body>
</html>

