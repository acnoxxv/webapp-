<?php
// Includi il file di configurazione del database
require_once "config.php";
 
// Definisci le variabili e inizializzale come stringhe vuote
$name = $email = $password = $confirm_password = "";
$name_err = $email_err = $password_err = $confirm_password_err = "";
 
// Elabora i dati del form quando viene inviato
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Verifica se il nome è stato inserito
    if(empty(trim($_POST["name"]))){
        $name_err = "Inserisci il tuo nome.";
    } else{
        // Prepara una query SELECT
        $sql = "SELECT id FROM users WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Collega le variabili alla dichiarazione preparata come parametri
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Imposta i parametri
            $param_name = trim($_POST["name"]);
            
            // Esegui la dichiarazione preparata
            if(mysqli_stmt_execute($stmt)){
                /* memorizza il risultato */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "Questo nome è già stato preso.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Qualcosa è andato storto. Riprova più tardi.";
            }

            // Chiudi la dichiarazione preparata
            mysqli_stmt_close($stmt);
        }
    }
    
    // Verifica se l'email è stata inserita
    if(empty(trim($_POST["email"]))){
        $email_err = "Inserisci la tua email.";     
    } else{
        // Prepara una query SELECT
        $sql = "SELECT id FROM users WHERE email = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Collega le variabili alla dichiarazione preparata come parametri
            mysqli_stmt_bind_param($stmt, "s", $param_email);
            
            // Imposta i parametri
            $param_email = trim($_POST["email"]);
            
            // Esegui la dichiarazione preparata
            if(mysqli_stmt_execute($stmt)){
                /* memorizza il risultato */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "Questa email è già stata usata.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Qualcosa è andato storto. Riprova più tardi.";
            }

            // Chiudi la dichiarazione preparata
            mysqli_stmt_close($stmt);
        }
    }
    
    // Verifica se la password è stata inserita
    if(empty(trim($_POST["password"]))){
        $password_err = "Inserisci una password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La password deve avere almeno 6 caratteri.";
    } else{
        $password = trim($_POST["password"]);
    }
    // Verifica se la conferma password è stata inserita
    if(empty(trim($_POST["confirm_password"]))){
    $confirm_password_err = "Conferma la password.";
    } else{
    $confirm_password = trim($_POST["confirm_password"]);
    if(empty($password_err) && ($password != $confirm_password)){
    $confirm_password_err = "La password non coincide.";
    }
  }
// Controllo degli errori di input prima dell'inserimento nel database
if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
    // Preparazione della query di inserimento
$sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

if($stmt = mysqli_prepare($link, $sql)){
    // Bind delle variabili alla query preparata come parametri
    mysqli_stmt_bind_param($stmt, "sss", $param_name, $param_email, $param_password);

    // Impostazione dei parametri
    $param_name = $name;
    $param_email = $email;
    $param_password = password_hash($password, PASSWORD_DEFAULT); // Creazione dell'hash della password

    // Esecuzione della query preparata
    if(mysqli_stmt_execute($stmt)){
        // Redirezione alla pagina di login
        header("location: login.php");
    } else{
        echo "Qualcosa è andato storto. Si prega di riprovare più tardi.";
    }

    // Chiusura dello statement
    mysqli_stmt_close($stmt);
}
}
// Chiusura della connessione al database
mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrazione</title>
    <!-- Aggiunta di Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <h2>Registrazione</h2>
        <p>Per favore, inserisci le informazioni richieste per registrarti:</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($name_err)) ? 'has-error' : ''; ?>">
                <label>Nome</label>
                <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                <span class="help-block"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Conferma Password</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrati">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Hai già un account? <a href="login.php">Accedi qui</a>.</p>
        </form>
    </div>
    <!-- Aggiunta di Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

