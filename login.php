<?php
// Verifica se l'utente ha effettuato l'accesso
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include il file di connessione al database
require_once "config.php";

// Definisci le variabili e inizializzale con valori vuoti
$email = $password = "";
$email_err = $password_err = "";

// Elabora i dati del form quando viene inviato
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Verifica se l'email è vuota
    if(empty(trim($_POST["email"]))){
        $email_err = "Inserisci l'email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Verifica se la password è vuota
    if(empty(trim($_POST["password"]))){
        $password_err = "Inserisci la password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Controlla se ci sono errori di input prima di eseguire la query
    if(empty($email_err) && empty($password_err)){

        // Prepara una query SELECT
        $sql = "SELECT id, email, password FROM users WHERE email = ?";

        if($stmt = mysqli_prepare($link, $sql)){

            // Associa le variabili alla query come parametri
            mysqli_stmt_bind_param($stmt, "s", $param_email);

            // Imposta i parametri
            $param_email = $email;

            // Esegui la query preparata
            if(mysqli_stmt_execute($stmt)){

                // Memorizza il risultato
                mysqli_stmt_store_result($stmt);

                // Verifica se l'email esiste, se sì verifica la password
                if(mysqli_stmt_num_rows($stmt) == 1){

                    // Associa le variabili del risultato alla query preparata
                    mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            // Avvia una nuova sessione
                            session_start();

                            // Memorizza i dati dell'utente nella sessione
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["email"] = $email;

                            // Reindirizza l'utente alla pagina di benvenuto
                            header("location: index.php");
                        } else{

                            // Mostra un messaggio di errore se la password è errata
                            $password_err = "La password inserita non è valida.";
                        }
                    }
                } else{

                    // Mostra un messaggio di errore se l'email non esiste
                    $email_err = "Nessun account trovato con questa email.";
                }
            } else{
                echo "Oops! Qualcosa è andato storto. Riprova più tardi.";
            }

            // Chiudi la query preparata
            mysqli_stmt_close($stmt);
        }
    }

    // Chiudi la connessione al database
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper mx-auto mt-5">
        <h2>Login</h2>
        <p>Inserisci le tue credenziali per accedere.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Non hai un account? <a href="register.php">Registrati adesso</a>.</p>
        </form>
    </div>    
</body>
</html>
