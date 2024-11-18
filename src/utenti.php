<?php
session_start();
include 'dbConnection.php';

// verifico se la sessione è attiva e l'utente ha l'id=4
if(isset($_SESSION['session_user_id'])){
    $session_user_id = $_SESSION['session_user_id'];
} else{ 
    // se l'utente non ha l'id=4 visualizza il seguente avviso:
    echo "Non sei autorizzato per questa pagina";
}

// Query per recuperare gli utenti registrati dal database
try {
    $query = "SELECT idUtente, username, password, name, surname, email, birthdate FROM utente  ";
    $check = $pdo->prepare($query);
    $check->execute();

    // recupera gli utenti come array associativo
    $utenti = $check->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Errore durante il recupero degli utenti registrati: " . $e->getMessage();
    exit;
}
// Codice html per l'elenco degli utenti
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
            <h1>Elenco degli utenti registrati</h1>
        </header>

        <main>
            <h2>Lista degli utenti registrati</h2>

            <table class="catalogo-table">
                <thead>
                    <tr>
                        <th>iD Utente</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Name</th>
                        <th>Surname</th>
                        <th>Email</th>
                        <th>Birthdate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($utenti)): ?>
                        <?php foreach ($utenti as $utente): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($utente['idUtente'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($utente['username'], ENT_QUOTES, 'UTF-8'); ?></td>
                                <td><?php echo htmlspecialchars($utente['password'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                <td><?php echo htmlspecialchars($utente['name'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                <td><?php echo htmlspecialchars($utente['surname'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                <td><?php echo htmlspecialchars($utente['email'], ENT_QUOTES, 'UTF-8'); ?> </td>
                                <td><?php echo htmlspecialchars($utente['birthdate'], ENT_QUOTES, 'UTF-8'); ?> </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">Nessun utente trovato</td>
                        </tr>
                    <?php endif; ?>

                </tbody>

            </table>

            
        </main>
        <nav class="bottom-nav">
            <ul>
                <li><a href="dashboard.php" class="btn">Trona alla Dashboard</a> </li>
            </ul>
        </nav>

    </body>
</html>

 