<?php
include 'function.php';
include 'dbConnection.php';
session_start();

if(!has_permission()){
    header('Location: login.php');
    $_SESSION["fail_message"] = "Non sei autorizzato per questa pagina";
    exit;
}

if(isset($_GET['idPuntoVendita']) && is_numeric($_GET['idPuntoVendita'])) {
    $PuntoVendita_idPuntoVendita = (int) $_GET['idPuntoVendita'];
} else {
    echo "ID Punto Vendita non valido.";
    exit;
}

// recupero i dati dal form
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nome = trim($_POST['nome']);
    $prezzo =(float) $_POST['prezzo'] ;
    $descrizione = trim($_POST['descrizione']);
    $quantita= (int) $_POST['quantita'];
    $categoria_id= isset($_POST['Categoria_idCategoria_padre']) ? (int) $_POST['Categoria_idCategoria_padre'] : null; // Presa dalla tabella categoria
    $immagine = null;

    if(isset($_FILES['immagine']) && $_FILES['immagine']['error'] == 0 ) {
        $immagine = file_get_contents($_FILES['immagine']['tmp_name']);
    }           
}

// Query per inserire un nuovo articolo nel punto vendita
try {

    $pdo->beginTransaction();

    // inserisce il nuovo articolo nella tabella articolo
    $query = " INSERT INTO articolo (prezzo, nome, immagine, descrizione, Categoria_idCategoria) 
               VALUES (:prezzo, :nome, :immagine, :descrizione, :Categoria_idCategoria)";

    $check = $pdo->prepare($query);
    $check->bindParam(':prezzo', $prezzo, PDO::PARAM_STR);
    $check->bindParam(':nome', $nome);
    $check->bindParam(':immagine', $immagine, PDO::PARAM_LOB );
    $check->bindParam(':descrizione', $descrizione);
    $check->bindParam('Categoria_idCategoria', $categoria_id, PDO::PARAM_INT);
    $check->execute();

    // id del nuovo prodotto
    $idArticolo = $pdo->lastInsertId();

    // inserisce il nuovo idArticolo nella tabella prodotto
    $queryProduct = "INSERT INTO prodotto (Articolo_idArticolo)
                     VALUES (:idArticolo)";
    $checkProduct = $pdo->prepare($queryProduct);
    $checkProduct->bindParam(':idArticolo', $idArticolo,PDO::PARAM_INT);
    $checkProduct->execute();

    // associa il propdotto al puntovendita
    $queryAssoc = "INSERT INTO puntovendita_has_prodotto (PuntoVendita_idPuntoVendita, Prodotto_Articolo_idArticolo, quantita)
                   VALUES (:idPuntoVendita, :idArticolo, :quantita)";
    $checkAssoc = $pdo->prepare($queryAssoc);
    $checkAssoc->bindParam(':idPuntoVendita', $PuntoVendita_idPuntoVendita, PDO::PARAM_INT);
    $checkAssoc->bindParam(':idArticolo', $idArticolo, PDO::PARAM_INT);
    $checkAssoc->bindParam(':quantita', $quantita, PDO::PARAM_INT);
    $checkAssoc->execute();

    // commit transazione
    $pdo->commit();

    $_SESSION['success_message']= "Prodotto aggiunto con successo!";
    header('Location: prodotti_punto_vendita.php?idPuntoVendita=' . $PuntoVendita_idPuntoVendita);
    exit;

} catch (PDOException $e) {
    $pdo->rollBack();
    //echo "Errore durante l'inserimento del prodotto: " . $e->getMessage();
}
?>

<!-- codice html dei prodotti presenti per ogni punto vendita -->
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Nuovo Articolo</title>
        <link rel="stylesheet" href="/CSS/style.css">
    </head>
    <body>
        <h1>Aggiungi un nuovo articolo</h1>
        <!-- form per aggiungere un articolo -->
        <main>
            <h2>Compila i seguenti campi</h2>
            <form action="aggiungi_prodotto_PuntoVendita.php?idPuntoVendita=<?php echo $PuntoVendita_idPuntoVendita; ?>" method="POST" enctype="multipart/form-data">
               <input type="hidden" name="idPuntoVendita" value="<?php echo $PuntoVendita_idPuntoVendita; ?>"> 
               <label for="nome">Nome Articolo</label>
                <input type="text" name="nome" id="nome" required placeholder="Inserisci il nome dell'articolo">
                </div>
    
                <div class="form-group">
                    <label for="prezzo">Prezzo (€)</label>
                    <input type="number" name="prezzo" id="prezzo" step="0.01" required placeholder="Inserisci il prezzo dell'articolo">
                </div>

                <div class="form-group">
                    <label for="descrizione">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" required placeholder="Aggiungi una descrizione dell'articolo"></textarea>
                </div>

                <div class="form-group">
                    <label for="immagine">Immagine del Prodotto</label>
                    <input type="file" name="immagine" id="immagine" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="quantita">Quantità Disponibile</label>
                    <input type="number" name="quantita" id="quantita" required placeholder="Indica la quantità disponibile">
                </div>

                <label for="Categoria_idCategoria_padre">Categoria</label>
                <select name="Categoria_idCategoria_padre" id="Categoria_idCategoria_padre" required>
                    <option value="">Seleziona Categoria</option>
                        <?php
                        // Recupera le categorie degli articoli dalla tabella 'categoria'
                        $check = $pdo->query("SELECT idCategoria, nome FROM categoria ORDER BY nome");
                        while ($row = $check->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='" . $row['idCategoria'] . "'>" . $row['nome'] . "</option>";
                            }
                            ?>
                        </select>

                <button type="submit" name="submit">Aggiungi nuovo Articolo</button>
               
            </form>

            <form action="prodotti_punto_vendita.php" method="get">
            <input type="hidden" name="idPuntoVendita" value="<?php echo $PuntoVendita_idPuntoVendita; ?>">

            <button type="submit">Torna all'elenco degli articoli del punto vendita</button>
            </form>
        </main>
        </nav>
    </body>
</html>
   

