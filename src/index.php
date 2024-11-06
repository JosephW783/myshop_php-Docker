<?php
session_start();

include 'dbConnection.php';
include 'login.html';

if (isset($_SESSION['session_id'])) {
    header('Location: dashboard.php');
    exit;
}


/*
$servername= 'mariadb';  // Must be the service name of the database in `docker-compose.yml`
$dbhost= 'localhost';
$dbname = 'myshop';
$dbuser= 'root';
$db_password = 'Sandonaci94';
$charset = 'utf8';


// Metodo per creare la connessione
try {
    // Creazione della connessione con PDO
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=$charset", $dbuser, $db_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Imposta la modalità di errore
    // echo "Connessione al database riuscita!";
} catch (PDOException $e) {    
    //  echo "Errore di connessione: " . $e->getMessage();
}
*/

/*
if (isset($_SESSION['session_id'])) {
    header('Location: dashboard.php');
    exit;
}

if (isset($_POST['login'])) {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $msg = 'Inserisci username e password %s';
    } else {
        $query = " SELECT username, password FROM utente WHERE username = :username ";
        
        $check = $pdo->prepare($query);
        $check->bindParam(':username', $username, PDO::PARAM_STR);
        $check->execute();
        
        $user = $check->fetch(PDO::FETCH_ASSOC);
        
        if (!$user || password_verify($password, $user['password']) === false) {
            $msg = 'Credenziali utente errate %s';
        } else {
            session_regenerate_id();
            $_SESSION['session_id'] = session_id();
            $_SESSION['session_user'] = $user['username'];
            
            header('Location: dashboard.php');
            exit;
        }
    }
}
    */

/*
    // Controllo se il modulo di login è stato inviato
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_POST['username'];
        $password = $_POST['password'];
       
    
        
        // Query per recuperare l'utente
        $stmt = $pdo->prepare("SELECT * FROM utente WHERE LOWER(username) = LOWER(:username)");
        $stmt->bindParam(':username', $user);
        $stmt->execute();
        $userdata = $stmt->fetch(PDO::FETCH_ASSOC);
        //var_dump($userdata['password']);
        var_dump($userdata);

        // Controllo se l'utente esiste e la password è corretta
        if ($userdata) {
            if (password_verify($pass, $userdata['password'])) {
                $_SESSION['user'] = $userdata['username'];
                $_SESSION['pass'] = session_id();
                header('Location: dashboard.php');
                exit;
            } else {
            $error= "Credenziali errate!";
            }
        }   
    }   
        
    

   
    
    
/*
    // Verifica se l'utente è loggato
    if (isset($_SESSION['user'])) {
    // Eseguo la query
    $table = 'utente';
    $stmt = $pdo->prepare("SELECT * FROM $table");
    $stmt->execute();
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

     // Controllo se ci sono risultati e li visualizzo in formato html
     if ($results) {
        echo "<h1>Dati estratti dalla tabella '$table'</h1>";
        echo "<table border='1'>";
        echo "<tr>";
        
        // Mostra le intestazioni delle colonne
        foreach (array_keys($results[0]) as $column) {
            echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";

        // Mostra i dati
        foreach ($results as $row) {
            echo "<tr>";
            foreach ($row as $column => $data) {
                if ($column == 'immagine') {
                    $imageData = base64_encode(($data));
                    echo "<td><img src='data:image/jpeg;base64,$imageData' alt='Immagine' style='width:200px;'/></td>";
                } else {
                    echo "<td>" . htmlspecialchars($data) . "</td>";
                }
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nessun dato trovato nella tabella '$table'.";
    } 
}
    else {
        // Modulo di login
        echo '<h2>LOGIN</h2>';
        echo '<form method="POST" action="">';
        echo '<label for="username">Username:</label>';
        echo '<input type="text" name="username" required>';
        echo '<br>';
        echo '<label for="password">Password:</label>';
        echo '<input type="password" name="password" required>';
        echo '<br>';
        echo '<input type="submit" name="LOGIN" value="Accedi">';
        echo '</form>';
    }

    

    
    
    






    /*
    
     // Eseguo la query
   $table = 'articolo';
   $stmt = $pdo->prepare("SELECT * FROM $table");
   $stmt->execute();
   
   $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
   
   // Controllo se ci sono risultati e li visualizzo in formato html
   if ($results) {
       
       echo "<h1>Dati estratti dalla tabella '$table'</h1>";
       echo "<table border='1'>";
       echo "<tr>";
       
       // Mostra le intestazioni delle colonne
       foreach (array_keys($results[0]) as $column) {
           echo "<th>" . htmlspecialchars($column) . "</th>";
        }
        echo "</tr>";
        
        // Mostra i dati
        foreach ($results as $row) {
            echo "<tr>";
            foreach ($row as $column => $data) {
                
                if ($column == 'immagine'){ // Controllo la colonna immagine
                    
                    $imageData = base64_encode(($data));
                    echo "<td><img src='data:image/jepg;base64,$imageData' alt='Immagine' style='width:200px;'/></td>";
                       
                } else{
                    echo "<td>" . htmlspecialchars($data) . "</td>";
                } 
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Nessun dato trovato nella tabella '$table'.";
    }  */

// }
// catch (PDOException $e) {
    // Gestione dell'errore di connessione
  //  echo 'Errore di connessione al database: ' . $e->getMessage();
   // var_dump($pdo->errorInfo());
// }





