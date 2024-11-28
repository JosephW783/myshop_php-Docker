<?php
include 'dbConnection.php';
include 'function.php';
session_start();


if(!is_autenticated() || !has_permission()){
    header ('Location: login.php');
    $_SESSION["fail_message"] = "Non sei autorizzato per questa pagina";
    exit;
}

?>

<!-- codice html per l'elenco dei punti vendita -->
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Punti Vendita</title>
        <link rel="stylesheet" href="/CSS/style.css">
    </head>
    <body>
        <header>
            <h1>Punti Vendita</h1>
        </header>
        <section>
            <h2>Elenco dei Punti Vendita</h2>

            <table class="catalogo-table">
                <thead>
                    <tr>
                        <th>ID Punto Vendita</th>
                        <th>Città</th>
                        <th>Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        try{

                            // Query per recuperare l'elenco dei punti vendita
                            $query = "SELECT idPuntoVendita, citta FROM puntovendita";
                            $check = $pdo->prepare($query);
                            $check->execute();

                            // recupera i punti vendita come array associativo
                            $punti_vendita = $check->fetchAll(PDO::FETCH_ASSOC);

                            if(!empty($punti_vendita)){
                                foreach ($punti_vendita as $punto_vendita){
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($punto_vendita['idPuntoVendita'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td>" . htmlspecialchars($punto_vendita['citta'], ENT_QUOTES, 'UTF-8') . "</td>";
                                    echo "<td><a href='prodotti_punto_vendita.php?idPuntoVendita=" . $punto_vendita['idPuntoVendita'] . "'class='btn'>Visualizza i Prodotti</a></td>";
                                    echo "</tr>";
                                } 
                            }  else {
                                echo "<tr><td colspan='3'> Nessun punto vendita trovato. </td></tr> ";
                            }
                        } catch (PDOException $e){
                            echo "<tr><td colspan='3'>Errore durante il recupero dei punti vendita: " . $e->getMessage() . "</td></tr>"; 
                        }
                    ?>
                </tbody>
            </table>
        <nav class="bottom-nav">
            <ul>
                <li><a href="dashboard.php" class="btn"> Torna alla Dashboard</a></li>
            </ul>
        </nav>
        </section>
    </body>
</html>