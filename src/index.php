<?php
//session_start();

include 'dbConnection.php';
include 'login.php';

// logica per il login
if (isset($_SESSION['session_id'])) {
    header('Location: dashboard.php');
    exit;
}







