<?php
include 'dbConnection.php';
include 'function.php';
include 'invia_email.php';
include 'inserisci_articolo.php';
session_start();

if(!is_autenticated() || has_permission()) {
    header('Location: login.php');
    $_SESSION['fail_message'] = "Non sei autorizzato per questa pagina";
    exit;
}
if(empty($_SESSION['ordine_dati'])) {
    header('Location: carrello.php');
    exit;
}
$dati_ordine = $_SESSION['ordine_dati'];

// calcolo il totale dell'ordine
$totale = 0;
foreach ($dati_ordine['carrello'] as $articolo) {
    $totale += $articolo['prezzo'] * $articolo['quantita'];
}
$dati_ordine['totale'] = $totale;

// query per inserire l'acquisto e gli articoli nel db
try {
    $utente_id = $_SESSION['idUtente'];
    $idAcquisto = inserisci_acquisto($utente_id, $totale, $dati_ordine);

    invia_email_conferma($dati_ordine['email'], $dati_ordine);
    
    unset($_SESSION['carrello']);
    unset($_SESSION['ordine_dati']);

    // Visualizza la conferma dell'ordine
    echo '<h1>Ordine completato con successo!</h1>';
    echo '<p>Grazie per il tuo acquisto, un\'email di conferma è stata inviata a ' . htmlspecialchars($dati_ordine['email'], ENT_QUOTES, 'UTF-8') . '.</p>';
    echo '<p><a href="index.php">Torna alla home</a></p>';
} catch (Exception $e) {
    echo '<p>Si è verificato un errore durante l\'elaborazione del tuo ordine. Riprova più tardi.</p>';
    // Puoi anche loggare l'errore per analizzarlo successivamente
    error_log($e->getMessage());
}
