<?php

$servername= "localhost";
$dbhost= "mariadb";
$username= "root";
$password = "Sandonaci94";
$dbname = "myshop";
$charset = 'utf8';

// Metodo per creare la connessione
try {
    // Creazione della connessione con PDO
     // Definizione del DSN (Data Source Name)
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Attiva le eccezioni per gli errori
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Imposta il fetch mode come array associativo
        PDO::ATTR_EMULATE_PREPARES => false, // Disabilita la preparazione delle query emulata (migliora la sicurezza)
    ];

    // Creazione dell'oggetto PDO
    $pdo = new PDO('mysql:host=mariadb;dbname=$dbname;charset=utf8', $username, $password);
    // Connessione riuscita
    echo "Connessione al database riuscita!";

    // Esegui una query di esempio
    // $query = $pdo->query("SELECT * FROM utente");
    
    // Estrazione dei dati
    // while ($row = $query->fetch()) {
        // Stampa ogni riga del risultato (ad esempio)
        //    echo $row['nome_colonna'] . '<br>';
        // }
        
    } catch (PDOException $e) {
        // Gestione dell'errore di connessione
        echo 'Errore di connessione al database: ' . $e->getMessage();
}
// password mariadb 'ciaiciao94'

/*
$servername = "mariadb";
$username = "root";
$password = "ciaociao94";
$database = "myshop";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
    */