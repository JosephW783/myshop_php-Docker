<?php

// Avvia la sessione 
function start_session(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(session_status() == PHP_SESSION_ACTIVE){
        session_regenerate_id();
    }
}

// Verifica se l'utente è autenticato ed ha i permessi 
function is_autenticated(){
    return isset($_SESSION['session_id']);
}
function has_permission(){
    return isset($_SESSION['session_user_id']) && $_SESSION['session_user_id'] == 4;
}

// Recupero info dell'utente dalla sessione
function get_session_user(){
    return isset($_SESSION['session_user']) ? $_SESSION['session_user'] : null;
}
function get_session_user_id(){
    return isset ($_SESSION['session_user_id']) ? $_SESSION['session_user_id'] : null; 
}

// Elimina la sessione (logout) e reindirizza alla pagina di login
function destroy_session(){
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}
