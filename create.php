<?php
require_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $tipo = $_POST['tipo'];
    $descrizione = $_POST['descrizione'];
    $immagine = $_POST['immagine'];

    $sql = "INSERT INTO pokemon (nome, tipo, descrizione, immagine) VALUES (?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $nome, $tipo, $descrizione, $immagine);
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
    <title>Inserisci un nuovo Pokémon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="text-center mt-5">Inserisci un nuovo Pokémon</h1>
        <form action="create.php" method="post">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" name="nome" required>
    </div>
    <div class="mb-3">
        <label for="tipo" class="form-label">Tipo</label>
        <input type="text" class="form-control" name="tipo" required>
    </div>
    <div class="mb-3">
        <label for="descrizione" class="form-label">Descrizione</label>
        <textarea class="form-control" name="descrizione" required></textarea>
    </div>
    <div class="mb-3">
        <label for="immagine" class="form-label">Immagine (URL)</label>
        <input type="url" class="form-control" name="immagine" required>
    </div>
    <button type="submit" class="btn btn-primary">Aggiungi</button>
</form>
