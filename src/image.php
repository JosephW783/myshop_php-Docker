<?php
include 'dbConnection.php'; 

if(isset($_GET['idArticolo'])){
    $idArticolo = (int) $_GET['idArticolo'];

    // Prepare the SQL query using PDO
    $query = "SELECT immagine FROM articolo WHERE idArticolo = :idArticolo";
    
    // Prepare the query
    if ($check = $pdo->prepare($query)) {
        // Bind the parameter for idArticolo
        $check->bindParam(':idArticolo', $idArticolo, PDO::PARAM_INT);
        
        // Execute the query
        $check->execute();
        
        // Fetch the result
        if ($row = $check->fetch(PDO::FETCH_ASSOC)) {
            $immagine = $row['immagine'];
            
            // Check if image is not empty
            if ($immagine) {
                // Set the content-type header
                
                header("Content-Type: image/jpeg");
                echo $immagine;
            } else {
                echo "Immagine non trovata.";
            }
        } else {
            echo "Immagine non trovata.";
        }
        
        // Close the statement
       // $check->close();
    } else {
        echo "Errore nella preparazione della query.";
    }
}
