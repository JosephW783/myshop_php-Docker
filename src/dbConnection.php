<?php
 
$servername= 'mariadb';  // Must be the service name of the database in `docker-compose.yml`
$dbhost= 'localhost';
$dbname = 'myshop';
$dbuser= 'root';
$db_password = 'Sandonaci94';
$charset = 'utf8';


// Metodo per creare la connessione
try {
    // Creazione della connessione con PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $dbuser, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Imposta la modalità di errore
    // echo "Connessione al database riuscita!";
} catch (PDOException $e) {    
    //  echo "Errore di connessione: " . $e->getMessage();
}