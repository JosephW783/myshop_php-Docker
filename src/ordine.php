<?php
include 'function.php';
session_start();

// verifica se l'utente è autenticato
if(!is_autenticated() || has_permission()){
    header('Location: login.php');
    $_SESSION["fail_message"] = "Non sei autorizzato per questa pagina";
    exit;
}
// verifica se l'ordine è stato  inviato
if (!isset($_SESSION['ordine']) || empty($_SESSION['ordine'])) {
    $_SESSION["fail_message"] = "Non hai articoli nel carrello. Torna al carrello per completare l'ordine.";
    header("Location: carrello.php");
    exit;
}

// visualizza il contenuto dell'ordine
$ordine = isset($_SESSION['ordine']) ? $_SESSION['ordine'] : [];
  
?>

<!-- Codice html per l'ordine -->
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordine</title>
    <link rel="stylesheet" href="/CSS/style.css">
</head>
<body>
    <header>
        <h1>Il tuo ordine</h1>
    </header>
    <main>
        <?php if(!empty($ordine)): ?>
            <table class="catalogo-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Prezzo Totale</th>
                        <th>Quantità Totale</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $totaleOrdine = 0;
                    foreach ($ordine as $idArticolo => $articolo):
                        $nome = htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8');
                        $prezzo = $articolo['prezzo'];
                        $quantita = $articolo['quantita'];

                        $totaleArticolo = $prezzo * $quantita;
                        $totaleOrdine += $totaleArticolo;
                    ?>
                        <tr>
                            <td><?php echo $nome; ?></td>
                            <td><?php echo number_format($totaleArticolo, 2, ',', '.')?></td>
                            <td><?php echo $quantita?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Totale Ordine</strong></td>
                        <td><strong><?php echo number_format($totaleOrdine,2,',', '.') . '€'?></strong></td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </main>
        <form action="finalizza_ordine.php" method="post">
            <button type="submit" name="conferma_acquisto">Conferma acquisto</button>
        </form>

</body>
</html>
