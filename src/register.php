<?php
session_start();
include 'dbConnection.php';

// Verifico se il form è stato inviato
if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['register'])){
    //Prendo i dati dal form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $birthdate = $_POST['birthdate'];

    if(empty($username) || empty($password) || empty($name) || empty($username) || empty($email) || empty($birthdate)){
        $_SESSION['regisert_msg'] = 'Tutti i campi sono obbligatori';
        header("Location: register.php");
        exit;
    }


    // creazione hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Controllo se l'username esiste già nel DB
    $check_username_query = "SELECT * FROM utente WHERE username = ?";
    $check = $pdo->prepare($check_username_query);
    $check->execute([$username]);

    if ($check->rowCount() > 0) {
            $_SESSION['register_msg'] = 'Username già in uso, scegline un altro!';
        } else{
            // Insersco i dati nel db
            $insert_query = "INSERT INTO utente (username, password, name, surname, email, birthdate) VALUES(?, ?, ?, ?, ?, ? )";
            $insert = $pdo->prepare($insert_query);
            $result = $insert->execute([$username, $hashed_password, $name, $surname, $email, $birthdate]);
            
            if($result) {
                // redirect alla dashboard se la registrazione è riuscita
                $_SESSION['register_msg'] = 'Registrazione completata con successo!';
                header("Location: dashboard.php");
                exit;
            } else{
                // Gestione errore nel caso l'inserimento fallisce
                $_SESSION['register_msg'] = 'Errore durante la registrazione. Riprova!';
                header("Location: register.php");
                exit;
        }        
    }
}

// Include il codice html per la registrazione nuovo utente
?>
<!DOCTYPE html>
<html>
<head>
    <title>Registrazione</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/CSS/style.css">
</head>
<body>
    <h1>Registrazione</h1>

    <!-- Mostra il messaggio di errore/successo se presente -->
    <?php
    if (isset($_SESSION['register_msg'])) {
        echo '<div class="message">' . htmlspecialchars($_SESSION['register_msg']) . '</div>';
        unset($_SESSION['register_msg']); // Rimuove il messaggio dopo averlo visualizzato
    }
    ?>

    <!-- Form di registrazione -->
    <form method="post" action="register.php">
        
        
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" maxlength="50" required><br><br>
        
        <label for="surname">Cognome:</label>
        <input type="text" id="surname" name="surname" maxlength="50" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="birthdate">Data di nascita:</label>
        <input type="date" id="birthdate" name="birthdate" required><br><br>
        
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" maxlength="50" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <button type="submit" name="register">Registrati</button>
    </form>

    <!-- Pulsante per tornare al login -->
    <form action="login.php" method="get">
        <button type="submit">Torna al Login</button>
    </form>
</body>
</html>