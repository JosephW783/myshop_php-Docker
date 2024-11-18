<?php
// Questo file gestisce il processo di login di un utente
session_start(); // session_start avvia una sessione PHP, che consente di memorizzare e gestire informazioni tra diverse richieste dell'utente.
include 'dbConnection.php';

// verifica della presenza dei dati nel login
if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
 
    // controllo della validità dei dati
    if (empty($username) || empty($password)) {
        $_SESSION['login_msg'] = 'Inserisci username e password!';
        header('Location: login.php');
        exit;
    } else { // verifica le credenziali dell'utente del database
        $query = " SELECT idUtente, username, password FROM utente WHERE username = :username ";
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetch(PDO::FETCH_ASSOC);
        // verifica della password
        if (!$user || password_verify($password, $user['password']) === false) {
            $_SESSION['login_msg'] = 'Credenziali utente errate';
            header('Location: login.php');
            exit;
        } else { // Avvio della sessione utente e reindirizzamento alla Dashboard
            session_regenerate_id();  // will replace the current session id with a new one, and keep the current session information.
            $_SESSION['session_id'] = session_id();  // restituisce l'id di sessione per la sessione corrente. Se id è specificato, sostituirà l'id di sessione corrente.
            $_SESSION['session_user'] = $user['username'];
            $_SESSION['session_user_id'] = $user['idUtente'];
            
            header('Location: dashboard.php');
            exit;
        } 
    } 
}

// include il codice htlm del login
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css"> <!-- Include il file style.css -->
    <title>Login</title>
</head>
<body>
    <h2>Benvenuto in Myshop eCommerce, effettua il Login o Registrati per accedere al catalogo!</h2>

    <!-- Mostra il messaggio di errore, se presente -->
    <?php
    if (isset($_SESSION['login_msg'])) {
        echo '<div class="message">' . htmlspecialchars($_SESSION['login_msg']) . '</div>';
        unset($_SESSION['login_msg']);  // Rimuove il messaggio dopo averlo visualizzato
    }
    ?>

    <!-- Form di login -->
    <form action="login.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <button type="submit" name="login">Accedi</button>
    </form>
    
    <!-- Link per registrarsi -->
    <form action="register.php" method="GET">
        <button type="submit">Registrati</button>
    </form>
</body>
</html>
    
