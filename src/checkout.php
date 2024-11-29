<?php
include 'function.php';
session_start();

// verifica se l'utente è autenticato
if(!is_autenticated() || has_permission()){
    header('Location: login.php');
    $_SESSION["fail_message"] = "Non sei autorizzato per questa pagina";
    exit;
}

if(empty($_SESSION['carrello'])) {
    header('Location: carrello.php');
    exit;
}
$error= ''; // inizializzazione variabili errore
if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cognome = trim($_POST['cognome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $indirizzo = trim($_POST['indirizzo'] ?? '');
    $modalita_pagamento = $_POST['modalita_pagamento'] ?? '' ;
} 
// valido e salvo i dati dell'ordine
if(empty($nome) || empty($cognome) || empty($email) || empty($indirizzo) || empty($modalita_pagamento)) {
    $error = "NOTA: Tutti i campi sono obbligatori";
} else {

    $_SESSION['ordine_dati'] = [
        'nome' => $nome,
        'cognome' => $cognome,
        'email' => $email,
        'indirizzo' => $indirizzo,
        'modalita_pagamento' => $modalita_pagamento,
        'carrello' => $_SESSION['carrello']
    ];

    header('Location:');
    exit;
}
?>
<!-- codice html per l'ordine -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="/CSS/style.css">
</head>
<body>
    <header>
        <h1>Finalizza il tuo acquisto</h1>
    </header>
    <main>
        <h2>Compila i seguenti campi</h2>
        <form action="checkout-complete.php" method="POST">
            <?php if($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <label for="nome">Nome</label>
            <input type="text" name="nome" id="nome" required>
            
            <label for="cognome">Cognome</label>
            <input type="text" name="cognome" id="cognome" required>

            <div class="form-group">
                <label for="email">Email</label>
                <textarea name="email" id="email" required placeholder="Inserisci una email valida"></textarea>
            </div>

            <div class="form-group">
                <label for="indirizzo">Indirizzo</label>
                <textarea name="indirizzo" id="indirizzo" required placeholder="Inserisci un indirizzo valido"></textarea>
            </div>
            <label for="modalita_pagamento">Modalità di pagamento:</label>
            <select id="modalita_pagamento" name="modalita_pagamento" required>
                <option value="">Scegli una modalità</option>
                <option value="carta_credito">Carta di credito</option>
                <option value="paypal">PayPal</option>
                <option value="bonifico">Bonifico bancario</option>
            </select>
            <div class="actions">
                <button type="submit">Conferma acquisto</button>
                <a href="carrello.php"><button type="button">Torna al carrello</button></a>
            </div>
        </form>
    </main>
</body>
</html>

