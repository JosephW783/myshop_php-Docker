<?php
session_start(); // Avvia la sessione

// include 'dbConnection.php'; // Include la connessione al database
// Verifica se la sessione è attiva
if (isset($_SESSION['session_id'])) {
    // Recupera i dati della sessione
    $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['session_id']);
    
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
        <h1>Benvenuto nella Dashboard</h1>
        <nav>
            <ul>
                <!-- Puoi aggiungere link al catalogo o altre sezioni del sito -->
                <!-- <li><a href="catalogo.php">Catalogo</a></li> -->
            </ul>
        </nav>
    </header>
    
    <main>
        <section>
            <!-- Mostra il messaggio di benvenuto -->
            
            <a href="catalogo.php">Visualizza il catalogo</a><br>
            <a href="logout.php" id="logout">Logout</a>
        </section>
    </main>

</body>
</html>
