<?php
session_start();


// verifica se i dati sono stati inviati tramite POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idArticolo'], $_POST['nome'], $_POST['prezzo'], $_POST['quantita'])) {
    $idArticolo = $_POST['idArticolo'];
    $nome = $_POST['nome'];
    $prezzo = $_POST['prezzo'];
    $quantita = $_POST['quantita'];


// Se il carrello non esiste, lo crea
if(isset($_SESSION['carrello'])) {
    $_SESSION['carrello'] = [];
}

// Se l'articolo è gia nel carrello, aumenta la quantita
if (isset($_SESSION['carrello'] [$idArticolo])) {
    $_SESSION['carrello'] [$idArticolo] ['quantita'] += $quantita;
} else {
    // Aggiunge l'articolo al carrello
    $_SESSION['carrello'] [$idArticolo] = [
        'nome' => $nome,
        'prezzo' => $prezzo,
        'quantita' => $quantita

    ];
}
    // Dopo aver aggiunto l'articolo, puoi rimanere sulla stessa pagina o fare il redirect
    header("Location: carrello.php");
    exit;

}
    //  mostra il contenuto del carrello se è presente
    $carrello = isset($_SESSION['carrello']) ? $_SESSION['carrello'] : [];

// Include il codice html del carrello
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrello</title>
    <link rel="stylesheet" href="/CSS/style.css"> <!-- Aggiunge il file CSS per lo stile -->
</head>
<body>

<header>
    <h1>Carrello</h1>
</header>

<main>
    <?php if (!empty($carrello)): ?>
        <h2>Il tuo carrello</h2>
        <table class="catalogo-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Prezzo</th>
                    <th>Quantità</th>
                    <th>Totale</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totale = 0;
                foreach ($carrello as $idArticolo => $articolo):
                    $totaleArticolo = $articolo['prezzo'] * $articolo['quantita'];
                    $totale += $totaleArticolo;
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($articolo['prezzo'], ENT_QUOTES, 'UTF-8'); ?> €</td>
                        <td><?php echo htmlspecialchars($articolo['quantita'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo number_format($totaleArticolo, 2, ',', '.') . ' €'; ?></td>
                    </tr>
                <?php endforeach; ?>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Totale</strong></td>
                    <td><strong><?php echo number_format($totale, 2, ',', '.') . ' €'; ?></strong></td>
                </tr>
            </tbody>
        </table>

        <div class="actions">
            <a href="Acquisto.php" class="btn-checkout">Acquista</a> <br>
            <a href="catalogo.php" class="btn-continua">Continua lo shopping</a>
        </div>

    <?php else: ?>
        <p>Il tuo carrello è vuoto. <a href="catalogo.php">Vai al catalogo</a> per aggiungere articoli.</p>
    <?php endif; ?>
</main>

<nav class="bottom-nav">
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="catalogo.php">Catalogo</a></li>
    </ul>
</nav>

</body>
</html>