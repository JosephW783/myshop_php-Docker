<?php
include 'dbConnection.php'; 
include 'image.php';
include 'function.php';
session_start();  

if(!is_autenticated() || has_permission()){
    header('Location: login.php');
    $_SESSION["fail_message"] = "Non sei autorizzato per questa pagina";

    exit;
}
    try {
        // query per ottenere tutti gli articoli
        $query = "SELECT * FROM articolo";
        $check = $pdo->prepare($query);
        $check->execute();

        // Recupera tutti gli articoli come array associativo
        $articoli = $check->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Errore durante il recupero degli articoli: " . $e->getMessage();
    }
?>

<!-- codice html per il catalogo -->
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Catalogo</title>
        <link rel="stylesheet" href="/CSS/style.css"> 
    </head>
    <body>
        <header>
            <h1>Catalogo degli articoli</h1>
        </header>
        
        <main>
            <h2>Lista degli articoli disponibili</h2>
            
            <table class="catalogo-table">
                <thead>
                    <tr>
                        <th>idArticolo</th>
                        <th>Prezzo</th>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Immagine</th>
                        <th>Descrizione</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($articoli)): ?>
                        <!-- visualizza gli articoli -->
                        <?php foreach ($articoli as $articolo): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($articolo['idArticolo'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($articolo['prezzo'], ENT_QUOTES, 'UTF-8'); ?>€</td>
                                <td><?php echo htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($articolo['Categoria_idCategoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td>
                                      <?php
                                      if (!empty($articolo['immagine'])) {
                                          // Crea un link per visualizzare l'immagine in una nuova finestra
                                          echo '<a href="image.php?idArticolo=' . $articolo['idArticolo'] . '" target="_blank">';
                                          echo '<img src="data:image/jpeg;base64,' . base64_encode($articolo['immagine']) . '" alt="' . htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8') . '" style="width: 100px; cursor: pointer;">';
                                          echo '</a>';
                                      } else {
                                          echo 'Nessuna immagine disponibile';
                                      }
                                      ?>
                            </td>
                            <td><?php echo htmlspecialchars($articolo['descrizione'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <!-- Pulsante aggiungi al carrello -->
                                <form action="carrello.php" method="POST">
                                    <input type="hidden" name="idArticolo" value="<?php echo $articolo['idArticolo']; ?>">
                                    <input type="hidden" name="nome" value="<?php echo htmlspecialchars( $articolo['nome'], ENT_QUOTES, 'UTF-8');?>">
                                    <input type="hidden" name="prezzo" value="<?php echo htmlspecialchars( $articolo['prezzo'], ENT_QUOTES, 'UTF-8');?>">
                                    <input type="hidden" name="quantita" value="1"> <!-- quantita predefinita -->
                                    <button type="submit" class="btn-aggiungi">Aggiungi al Carrello</button>
                                </form>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Se non ci sono articoli, mostra il messaggio -->
                    <tr>
                        <td colspan="6">Nessun articolo trovato</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </main>

    <nav class="bottom-nav">
        <ul>
            <li><a href="dashboard.php">Torna alla Dashboard</a></li>
            <li><a href="carrello.php">Vai al Carrello</a></li>
        </ul>
    </nav>
</body>
</html>
