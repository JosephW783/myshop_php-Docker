<?php
include 'function.php';
include 'dbConnection.php';
session_start(); 

// Verifica se l'utente ha chiesto di fare il logout
if (isset($_GET['logout']) && $_GET['logout'] == 'true') {
    destroy_session();  
}

if(!is_autenticated()){
    header ('Location: login.php');
    exit;
}
// Recupero i dati dell'utente della sessione
$session_user = get_session_user(); // nome utente
$session_user_id = get_session_user_id(); // id utente
?>

<!-- codice HTML della dashboard -->
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
        <h1>Dashboard Myshop eCommerce</h1>
    </header>

        <section>
            <h2>Benvenuto <?php echo htmlspecialchars($session_user, ENT_QUOTES, 'UTF-8'); ?>, seleziona un'azione:</h2>
            <!-- Se l'utente ha id = 4, mostra il link per visualizzare i punti vendita -->
            <?php if (has_permission()): ?>
                <a href="puntovendita.php" class="btn">Visualizza i punti vendita</a> <br>
                <a href="utenti.php" class="btn">Visualizza gli utenti registrati </a> <br>
            <?php else: ?>
                <a href="catalogo.php" class="btn">Visualizza il catalogo</a> <br>
            <?php endif; ?>
            <a href="javascript:void(0);" onclick="window.location.href='?logout=true'" class="btn">Logout</a>
        </section>

</body>
</html>
