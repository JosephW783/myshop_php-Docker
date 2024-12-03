<?php
include 'function.php';
session_start();

// verifica se l'utente è autenticato
if(!is_autenticated() || has_permission()){
    header('Location: login.php');
    $_SESSION["fail_message"] = "Non sei autorizzato per questa pagina";

    exit;
}

// Verifica se è stata inviata una richiesta per rimuovere un articolo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idArticolo']) && isset($_POST['action']) && $_POST['action'] === 'remove') {
    $idArticolo = $_POST['idArticolo'];

    // Rimuovi l'articolo dal carrello
    if (isset($_SESSION['carrello'][$idArticolo])) {
        unset($_SESSION['carrello'][$idArticolo]);
    }

    // Dopo aver rimosso l'articolo, ricarica la pagina per visualizzare i cambiamenti
    header("Location: carrello.php");
    exit;
}
// Verifica se è stata inviata una richiesta per aggiornare la quantità
if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['idArticolo'], $_POST['quantita'], $_POST['action']) && $_POST['action'] == 'update') {
    $idArticolo = $_POST['idArticolo'];
    $quantita = $_POST['quantita'];

    // Se il carrello esiste e l'articolo è presente, aggiorna la quantita dell'articolo nel carrello
    if(isset($_SESSION['carrello'][$idArticolo])){
            $_SESSION['carrello'][$idArticolo]['quantita'] = $quantita;
    }
    header("Location: carrello.php");
    exit;
}

// Verifica se i dati sono stati inviati tramite POST per aggiungere o aggiornare l'articolo nel carrello
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idArticolo'], $_POST['nome'], $_POST['prezzo'], $_POST['quantita'])) {
    $idArticolo = $_POST['idArticolo'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $quantita = $_POST['quantita'];

    // Se il carrello non esiste, lo crea
    if (!isset($_SESSION['carrello'])) {
        $_SESSION['carrello'] = [];
    }

    // Se l'articolo è già nel carrello, aumenta la quantità
    if (isset($_SESSION['carrello'][$idArticolo])) {
        $_SESSION['carrello'][$idArticolo]['quantita'] += $quantita;
    } else {
        // Aggiunge l'articolo al carrello
        $_SESSION['carrello'][$idArticolo] = [
            'nome' => $nome,
            'prezzo' => $prezzo,
            'quantita' => $quantita
        ];
    }
    // Aggiungi gli articoli presenti nel carrello all'ordine se l'utente ha cliccato sul link "Conferma Ordine"
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['conferma_ordine'])) {
        var_dump($_SESSION['carrello']);
        $_SESSION['ordine'] = $_SESSION['carrello'];
        unset($_SESSION['carrello']);
        header('Location: ordine.php');
        exit;
    }
        


    //Dopo aver aggiunto l'articolo, puoi rimanere sulla stessa pagina o fare il redirect
    header("Location: carrello.php");
    exit;
}
// Mostra il contenuto del carrello se è presente
$carrello = isset($_SESSION['carrello']) ? $_SESSION['carrello'] : [];

?>

<!-- codice html per il carrello -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="/CSS/style.css"> 
</head>
<body>

<header>
    <h1>Carrello</h1>
</header>

<table>
    <?php if (!empty($carrello)): ?>
        <h2>Il tuo carrello</h2>
        <table class="catalogo-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Prezzo</th>
                    <th>Quantità</th>
                    <th>Totale</th>
                    <th>Modifica quantità</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totale = 0;
                foreach ($carrello as $idArticolo => $articolo):
                    // Verifica che l'articolo abbia tutti i dati necessari
                    $nome = isset($articolo['nome']) ? htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8') : 'Nome non disponibile';
                    $prezzo = isset($articolo['prezzo']) ? $articolo['prezzo'] : 0;
                    $quantita = isset($articolo['quantita']) ? $articolo['quantita'] : 0;
                    
                    // Calcola il totale per questo articolo
                    $totaleArticolo = $prezzo * $quantita;
                    $totale += $totaleArticolo;
                ?>
                    <tr>
                        <td><?php echo $nome; ?></td>
                        <td><?php echo number_format($prezzo, 2, ',', '.') . ' €'; ?></td>
                        <td><?php echo $quantita; ?></td>
                        <td><?php echo number_format($totaleArticolo, 2, ',', '.') . ' €'; ?></td>
                        <td>
                            <!-- Campo per modificare la quantità -->
                            <form action="carrello.php" method="post" style="display: inline;">
                                <input type="hidden" name="idArticolo" value="<?php echo $idArticolo; ?>">
                                <input type="number" name="quantita" value="<?php echo $quantita; ?>" min="1" onchange="this.form.submit();">
                                <input type="hidden" name="action" value="update">
                            </form>
                        </td>
                        <td>
                            <!-- Form per rimuovore l'articolo dal carrello -->
                            <form action="carrello.php" method="post" style="display:inline;">
                                <input type="hidden" name="idArticolo" value="<?php echo $idArticolo; ?>">
                                <input type="hidden" name="action" value="remove">
                                <button type="submit" onclick="return confirm">Rimuovi articolo</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Totale</strong></td>
                    <td><strong><?php echo number_format($totale, 2, ',', '.') . ' €'; ?></strong></td>
                </tr>
            </tbody>
        </table> 
        <nav class="bottom-nav">
            <ul>
                <li><a href="catalogo.php">Torna al Catalogo</a></li>
                <li><a href="checkout.php">Conferma Ordine</a></li>
            </ul>
        </nav>
    <?php else: ?>
        <p>Il tuo carrello è vuoto. <a href="catalogo.php">Vai al catalogo</a> per aggiungere articoli.</p>
    <?php endif; ?>
</main>
</body>
</html>
