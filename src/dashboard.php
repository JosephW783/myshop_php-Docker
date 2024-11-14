<?php
session_start(); // Avvia la sessione
include 'dbConnection.php';

// Verifica se la sessione è attiva
if (isset($_SESSION['session_id'])) {
    // Recupera i dati della sessione
    $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['session_id']);
    $session_user_id = $_SESSION['session_user_id'];
    
    // Mostra un messaggio di benvenuto
     echo "<h1>Benvenuto $session_user!</h1>";
}

// Include il codice HTML della dashboard
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/CSS/style.css"> <!-- Aggiungi il tuo CSS se necessario -->
</head>
<body>

    <header>
        <h1>Dashboard Myshop</h1>
        <nav>
            <ul>
                <!-- Puoi aggiungere link al catalogo o altre sezioni del sito -->
                <!-- <li><a href="catalogo.php">Catalogo</a></li> -->
            </ul>
        </nav>
    </header>

        <section>

            <?php if ($session_user_id == 4): ?>
                <!-- Se l'utente ha id = 4, mostra il link per visualizzare i punti vendita -->
                <h2>Seleziona un'azione</h2>
                <a href="puntovendita.php" class="btn">Visualizza i Punti Vendita</a> <br>
            <?php else: ?>
                <a href="catalogo.php" class="btn">Visualizza il catalogo</a> <br>
            <?php endif; ?>
            <a href="logout.php" id="'logout" class="btn">Logout</a>
        </section>
</body>
</html>
