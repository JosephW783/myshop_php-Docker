<?php
session_start();
include 'dbConnection.php';

// verifico se la sessione dell'utente è attiva
if(isset($_SESSION['session_id']) && isset($_SESSION['session_user_id']) && $_SESSION['session_user_id'] == 4){
    $session_user_id = $_SESSION['session_user_id'];
} else {
echo " Non sei autorizzato per questa pagina";
exit;
}

// recupero l'ID del punto vendita
if(isset($_GET['idPuntoVendita'])) {
    $PuntoVendita_idPuntoVendita = (int) $_GET['idPuntoVendita'];

} else {
    echo " ID Punto Vendita non valido. Ecco cosa contiene $_GET:";
    echo'<pre>';
    print_r($_GET);
    echo'</pre>';
    exit;
}

// Query per recuperare i prodotti per il punto vendita specifico
try{
    $query = "
        SELECT a.idArticolo, a.prezzo, a.nome, a.Categoria_idCategoria, a.immagine, pp.quantita, a.descrizione 
        FROM puntovendita_has_prodotto pp
        JOIN articolo a ON pp.Prodotto_Articolo_idArticolo = a.idArticolo
        WHERE pp.PuntoVendita_idPuntoVendita = :idPuntoVendita
    ";
    $check = $pdo->prepare($query);
    $check->bindParam(':idPuntoVendita', $PuntoVendita_idPuntoVendita, PDO::PARAM_INT);
    $check->execute();

    // Recupera i prodotti come array associativo
    $prodotti = $check->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Errore durante il recupero dei prodotti: " . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo</title>
        <link rel="stylesheet" href="/CSS/style.css"> <!-- Aggiungi il tuo CSS per lo stile -->
    </head>
    <body>
        <header>
            <h1>Prodotti nel Punto Vendita</h1>
        </header>

        <main>
            <h2>Lista dei Prodotti disponibili</h2>
            <table class="catalogo-table">
                <thead>
                    <tr>
                        <th>idArticolo</th>
                        <th>Nome</th>
                        <th>Prezzo</th>
                        <th>Quantità</th>   
                        <th>Immagine</th>
                        <th>Descrizione</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($prodotti)): ?>
                        <?php foreach ($prodotti as $prodotto): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($prodotto['idArticolo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($prodotto['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <th><?php echo htmlspecialchars($prodotto['prezzo'], ENT_QUOTES, 'UTF-8'); ?></th>
                                <th><?php echo htmlspecialchars($prodotto['quantita'], ENT_QUOTES, 'UTF-8'); ?></th>
                                <td>
                                    <?php
                                    if(!empty($prodotto['immagine'])) {
                                        // crea il link per visualizzare l'immagine
                                        echo '<a href="image.php?idArticolo=' . $prodotto['idArticolo'] . '"target="_blank">';
                                        echo '<img src="data:image/jpeg;base64,' . base64_encode($prodotto['immagine']) . '" alt="' . htmlspecialchars($prodotto['nome'], ENT_QUOTES, 'UTF-8') . '" style="width: 100px; cursor: pointer; ">';
                                        echo '</a>';
                                    } else {
                                        echo 'Nessuna immagine disponibile';
                                    }
                                    ?>
                                </td>

                                <td><?php echo htmlspecialchars($prodotto['descrizione'], ENT_QUOTES, 'UTF-8'); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">Nessun articolo trovato</td>
                            </tr>
                    <?php endif; ?>
                </tbody>
            </table>
                

        </main>
        <nav class="bottom-nav">
            <ul>
                <li> <a href="puntovendita.php">Torna ai punti vendita</a> </li>
            </ul>
        </nav>
    </body>
    </html>