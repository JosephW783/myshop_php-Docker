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
    
   $table = 'articolo';
   $stmt = $pdo->prepare("SELECT * FROM $table");
   $stmt->execute();

   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // Controlla se ci sono risultati
   if ($results) {
    // Visualizza i dati in formato HTML
    echo "<h1>Dati estratti dalla tabella '$table'</h1>";
    echo "<table border='1'>";
    echo "<tr>";

    // Mostra le intestazioni delle colonne
    foreach (array_keys($results[0]) as $column) {
        echo "<th>" . htmlspecialchars($column) . "</th>";
    }
    echo "</tr>";

    // Mostra i dati
    foreach ($results as $row) {
        echo "<tr>";
        foreach ($row as $data) {
            echo "<td>" . htmlspecialchars($data) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Nessun dato trovato nella tabella '$table'.";
}
}   
 catch (PDOException $e) {
// Gestione dell'errore di connessione
    echo 'Errore di connessione al database: ' . $e->getMessage();
}






// password mariadb 'ciaiciao94'




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