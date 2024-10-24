<?php

$servername= 'mariadb';  // Must be the service name of the database in `docker-compose.yml`
// $dbhost= 'localhost';
$dbname = 'myshop';
$username= 'root';
$password = 'Sandonaci94';

$charset = 'utf8';

// includo la classe Utente
// include 'Utente.php';

// Metodo per creare la connessione
try {
    // Creazione della connessione con PDO
    // Definizione del DSN (Data Source Name)
     $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Imposta la modalità di errore
    // Connessione riuscita
    echo "Connessione al database riuscita!";
    


    

   
    

    
    // Stampa il risultato
   // if ($databaseExists) {
   // echo "Il database '$dbname' esiste.";
   // }   else {
   // echo "Il database '$dbname' non esiste.";
   // }

    // creo un'istanza della classe Utente.php
    // $utente = new Utente($pdo);

    // Ottengo tutti gli utenti
    // $utenti = $utente->getUtenti();

    // Mostro tutti gli utenti
    //foreach($utenti as $user) {
      //  echo "ID:" . $user['idUtente'] . "- Username:" . $user['username'] . "<br>";
   // }
}   
 catch (PDOException $e) {
// Gestione dell'errore di connessione
    echo 'Errore di connessione al database: ' . $e->getMessage();
}






// password mariadb 'ciaiciao94'