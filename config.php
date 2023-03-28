<?php
// Configurazione del database
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'pokedex');

// Connessione al database
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Controllo della connessione
if($link === false){
    die("ERRORE: Impossibile connettersi al database. " . mysqli_connect_error());
}
?>
