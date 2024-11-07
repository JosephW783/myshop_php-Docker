<?php
session_start(); // Avvia la sessione

// include 'dbConnection.php'; // Include la connessione al database
include 'dashboard.html';
// Verifica se la sessione è attiva
if (isset($_SESSION['session_id'])) {
    // Recupera i dati della sessione
    $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['session_id']);
    
    // Mostra un messaggio di benvenuto
    // echo "<h1>Benvenuto $session_user!</h1>";
   // echo "<p>Il tuo session ID è: $session_id</p>";
}
   // echo "<p><a href='logout.php'>Logout</a></p>";