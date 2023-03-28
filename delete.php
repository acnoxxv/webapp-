<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex - Elimina Pokemon</title>
    <!-- Collegamento ai fogli di stile di Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #333333;
            color: #FFFFFF;
        }
        .card {
            background-color: #444444;
            border-color: #555555;
            color: #FFFFFF;
        }
        .card-header {
            background-color: #AA0000;
        }
        .btn-primary {
            background-color: #AA0000;
            border-color: #AA0000;
        }
        .btn-primary:hover {
            background-color: #BB0000;
            border-color: #BB0000;
        }
    </style>
</head>
<body>
<div class="container my-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h3 class="card-title mb-0">Elimina Pokemon</h3>
                </div>
                <div class="card-body">
                    <?php
                    // Connessione al database
                    $host = "localhost";
                    $user = "root";
                    $password = "";
                    $dbname = "pokedex";
                    $conn = mysqli_connect($host, $user, $password, $dbname);
                    if (!$conn) {
                        die('<div class="alert alert-danger" role="alert">Connessione fallita: ' . mysqli_connect_error() . '</div>');
                    }

                    // Verifica che sia stato passato un ID valido come parametro GET
                    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
                        die('<div class="alert alert-danger" role="alert">ID non valido</div>');
                    }

                    // Prepara la query di cancellazione
                    $id = $_GET['id'];
                    $sql = "DELETE FROM pokemon WHERE id = $id";

                    if (mysqli_query($conn, $sql)) {
                        // La cancellazione è stata eseguita con successo
                        echo '<div class="alert alert-success" role="alert">Pokemon eliminato con successo</div>';
                    } else {
                        // Si è verificato un errore durante l'esecuzione della query
                        echo '<div class="alert alert-danger" role="alert">Errore durante l\'eliminazione del record: ' . mysqli_error($conn) . '</div>';
                    }

                    // Chiudi la connessione al database
                    mysqli_close($conn);
                    ?>
                    <a href="index.php" class="btn btn-primary">Torna alla lista</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Collegamento ai script di Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
