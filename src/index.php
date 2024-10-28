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

     $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $username, $password);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Imposta la modalità di errore

     echo "Connessione al database riuscita!";
    
    // Eseguo la query
   $table = 'articolo';
   $stmt = $pdo->prepare("SELECT * FROM $table");
   $stmt->execute();

   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

   // Controllo se ci sono risultati e li visualizzo in formato html
   if ($results) {

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
        foreach ($row as $column => $data) {
            
            if ($column == 'immagine'){ // Controllo la colonna immagine

                $imageData = base64_encode(($data));
                echo "<td><img src='data:image/jpeg;base64,$imageData' alt='Immagine' style='width:100px;'/></td>";
                

            } else{
            echo "<td>" . htmlspecialchars($data) . "</td>";
            }
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