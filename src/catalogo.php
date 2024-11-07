<?php
 session_start();  // Avvia la sessione
include 'dbConnection.php'; // Connessione al database

// Verifica se la sessione dell'utente è attiva
if (isset($_SESSION['session_id'])) {
    $session_user = htmlspecialchars($_SESSION['session_user'], ENT_QUOTES, 'UTF-8');
    $session_id = htmlspecialchars($_SESSION['session_id']);

    try {
        // La query per ottenere tutti gli articoli
        $query = "SELECT * FROM articolo";
        $check = $pdo->prepare($query);
        $check->execute();

        // Recupera tutti gli articoli come array associativo
        $articoli = $check->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Gestione errore se c'è un problema con la query
        echo "Errore durante il recupero degli articoli: " . $e->getMessage();
    }
} else {
    // Se l'utente non è autenticato, mostra un messaggio
    echo "Per favore accedi prima di vedere gli articoli.";
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
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($articoli)): ?>
                    <!-- Ciclo per visualizzare gli articoli -->
                    <?php foreach ($articoli as $articolo): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($articolo['idArticolo'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($articolo['prezzo'], ENT_QUOTES, 'UTF-8'); ?> €</td>
                            <td><?php echo htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td><?php echo htmlspecialchars($articolo['Categoria_idCategoria'], ENT_QUOTES, 'UTF-8'); ?></td>
                            <td>
                                <img src="images/<?php echo htmlspecialchars($articolo['immagine'], ENT_QUOTES, 'UTF-8'); ?>" alt="<?php echo htmlspecialchars($articolo['nome'], ENT_QUOTES, 'UTF-8'); ?>" style="width: 100px;">
                            </td>
                            <td><?php echo htmlspecialchars($articolo['descrizione'], ENT_QUOTES, 'UTF-8'); ?></td>
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
            <li><a href="dashboard.html">Dashboard</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
