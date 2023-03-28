<?php
require_once "config.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $sql = "SELECT * FROM pokemon WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);
                $nome = $row["nome"];
                $tipo = $row["tipo"];
                $descrizione = $row["descrizione"];
                $immagine = $row["immagine"];
            } else {
                $error_message = "Nessun Pokémon trovato.";
            }
        } else {
            $error_message = "Errore. Riprovare più tardi.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
} else {
    $error_message = "Nessun ID specificato.";
}

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $nome ?> - Pokedex</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        body {
            color: #000;
            background-color: #f8f9fa;
        }
        .card-title {
            color: #000;
        }
        .card-subtitle {
            color: #6c757d;
        }
        .card-text {
            color: #000;
        }
        .btn-outline-secondary {
            color: #000;
            border-color: #000;
        }
        .btn-outline-primary {
            color: #fff;
            background-color: #000;
            border-color: #000;
        }
        .btn-outline-danger {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-outline-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
    </style>
</head>
<body>
    <div class="container my-5">
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php } else { ?>
            <div class="card border-50">
                <div class="row no-gutters">
                    <div class="col-md-4">
                        <img src="<?php echo $immagine ?>" class="card-img img-fluid" alt="<?php echo $nome ?>">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h1 class="card-title mb-3"><?php echo $nome ?></h1>
                            <h5 class="card-subtitle mb-3"><?php echo $tipo ?></h5>
                            <p class="card-text"><?php echo $descrizione ?></p>
                            <div class="d-flex justify-content-end mt-4">
                            <a href="index.php" class="btn btn-outline-secondary me-3">Torna alla lista</a>
                            <a href="update.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary me-3">Modifica</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger">Elimina</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>