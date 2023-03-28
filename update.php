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
                echo "Nessun Pokémon trovato.";
                exit();
            }
        } else {
            echo "Errore. Riprovare più tardi.";
            exit();
        }
        mysqli_stmt_close($stmt);
    }
} else {
    echo "Nessun ID specificato.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $descrizione = $_POST['descrizione'];
    $immagine = $_POST['immagine'];

    $sql = "UPDATE pokemon SET nome = ?, tipo = ?, descrizione = ?, immagine = ? WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssi", $nome, $tipo, $descrizione, $immagine, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("location: index.php");
            exit();
        } else {
            echo "Errore. Riprovare più tardi.";
        }
        mysqli_stmt_close($stmt);
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifica <?php echo $nome ?> - Pokedex</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Pokedex</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav> <div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Modifica <?php echo $nome ?></div>
                <div class="card-body">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>" method="post">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" value="<?php echo $nome ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tipo" class="form-label">Tipo</label>
                            <input type="text" class="form-control" name="tipo" value="<?php echo $tipo ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="descrizione" class="form-label">Descrizione</label>
                            <textarea class="form-control" name="descrizione" rows="3" required><?php echo $descrizione ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="immagine" class="form-label">URL Immagine</label>
                            <input type="text" class="form-control" name="immagine" value="<?php echo $immagine ?>" required>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Modifica</button>
                            <a href="index.php" class="btn btn-secondary">Annulla</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>