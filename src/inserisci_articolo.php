<?php
include 'dbConnection';
function inserisci_acquisto($utente_id, $totale, $dati_ordine) {
    global $pdo;

    $pdo->beginTransaction();
    
    try{
        $query = "INSERT INTO acquisto (Cliente_Utente_idUtente) 
                  VALUES (:Cliente_Utente_idUtente)";

        $check = $pdo->prepare($query);
        $check->execute([':Cliente_Utente_idUtente']);

        $idAcquisto = $pdo->lastInsertId();  // ottengo l'id dell'acquisto appena inserito

        // inserisco gli articolo nel dettaglio dell'acqiusto
        foreach ($dati_ordine['carrello'] as $articolo) {
            $check = "INSERT INTO acquisto_has_articolo (Acquisto_idAcquisto, articolo, quantita) 
                      VALUES (:Acquisto_idAcquisto, :articolo, :quantita)";
            $check = $pdo->prepare($query);
            $check->execute([$idAcquisto, $articolo['id'], $articolo['quantita']]);
        }

        $pdo->commit();
        return $idAcquisto;

    } catch (PDOException $e){
        $pdo->rollBack(); // in caso di errore annula la transazione
        error_log("Errore durante l'inserimento dell'acquisto: " . $e->getMessage());
        throw new Exception("Errore durante l'elaborazione dell'ordine.");
    }
}