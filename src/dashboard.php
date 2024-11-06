<?php
session_start(); // Avvia la sessione

include 'dbConnection.php'; // Include la connessione al database
include 'dashboard.html';
// Verifica se la sessione è attiva
if (isset($_SESSION['session_id'])) {
    // Recupera i dati della sessione
    $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['session_id']);
    
    // Mostra un messaggio di benvenuto
    echo "<h1>Benvenuto $session_user!</h1>";
    echo "<p>Il tuo session ID è: $session_id</p>";
    echo "<p><a href='logout.php'>Logout</a></p>";

    // Recupera gli articoli dal database con PDO
    try {
        $query = "SELECT * FROM articolo"; // La query per ottenere tutti gli articoli
        $check = $pdo->prepare($query);    // Prepara la query
        $check->execute();                  // Esegui la query

        $articoli = $check->fetchAll(PDO::FETCH_ASSOC);  // Ottieni tutti i risultati come array associativo

        if ($articoli) {
            echo "<h2>Catalogo degli articoli:</h2>";
            echo "<div class='catalogo'>";

            // Cicla attraverso i risultati e mostra gli articoli
            foreach ($articoli as $articolo) {
                // Prepara i dati dell'articolo
                $id = htmlspecialchars($articolo['idArticolo'], ENT_QUOTES, 'UTF-8');
                $nome = htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8');
                $descrizione = htmlspecialchars($articolo['descrizione'], ENT_QUOTES, 'UTF-8');
                $prezzo = htmlspecialchars($articolo['prezzo'], ENT_QUOTES, 'UTF-8');
                $immagine = htmlspecialchars($articolo['immagine'], ENT_QUOTES, 'UTF-8');
                $categoria_id = htmlspecialchars($articolo['Categoria_idCategoria'], ENT_QUOTES, 'UTF-8');

                // Visualizza l'articolo in un formato HTML
                echo "
                <div class='articolo'>
                    <img src='path_to_images/$immagine' alt='$nome' class='articolo-immagine'>
                    <h3>$nome</h3>
                    <p><strong>Categoria:</strong> $categoria_id</p>
                    <p><strong>Descrizione:</strong> $descrizione</p>
                    <p><strong>Prezzo:</strong> $prezzo €</p>
                    <a href='dettagli.php?id=$id'>Vedi dettagli</a>
                </div>";
            }
            echo "</div>";
        } else {
            echo "<p>Nessun articolo trovato.</p>";
        }
    } catch (PDOException $e) {
        echo "Errore durante il recupero degli articoli: " . $e->getMessage();
    }

} else {
    // Se la sessione non è attiva, invita l'utente a fare il login
    echo "<p>Per accedere all'area riservata, <a href='login.html'>effettua il login</a>.</p>";
}

