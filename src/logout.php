<?php
session_start();  // Avvia la sessione
session_unset();  // Rimuove tutte le variabili di sessione
session_destroy();  // Distrugge la sessione

// Reindirizza l'utente alla pagina di login
header('Location: login.html');
exit;