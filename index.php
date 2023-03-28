<?php
require_once "config.php";
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pokedex</title>
    <!-- Includi il CSS di Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container-fluid bg-light">
        <!-- Intestazione con titolo, barra di ricerca e pulsante di login/registrazione -->
        <div class="row bg-dark text-white py-3">
            <div class="col-12 col-md-8 col-lg-6 mx-auto d-flex align-items-center justify-content-between">
                <h1 class="mb-0">Pokedex</h1>
                <form class="mt-3" action="index.php" method="get">
                    <div class="input-group">
                        <input type="text" name="tipo" class="form-control" placeholder="Cerca per tipo">
                        <button class="btn btn-secondary" type="submit">Cerca</button>
                    </div>
                </form>
                <div>
                    <a href="login.php" class="btn btn-secondary me-2">Login</a>
                    <a href="register.php" class="btn btn-outline-secondary">Registrati</a>
                </div>
            </div>
        </div>

        <!-- Elenco dei Pokemon -->
        <div class="row mt-4">
            <?php
            $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : '';
            $sql = "SELECT * FROM pokemon";
            if (!empty($tipo)) {
                $sql .= " WHERE tipo LIKE '%$tipo%'";
            }

            $result = mysqli_query($link, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="img-responsive col-12 col-sm-6 col-md-4 col-lg-3 mb-4" style="width:25vw">';
                    echo '<div class="card h-100 border-50 shadow">';
                    echo '<a class="nav-link" href="read.php?id=' . $row['id'].'"></p>';
                    echo '<img src="' . $row['immagine'] . '" class="card-img-top" alt="' . $row['nome'] . '">';
                    echo '<div class="card-body">';
                    echo '<h5 class="card-title">' . $row['nome'] . '</h5>';
                    echo '<p class="card-text">' . $row['tipo'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col">';
                echo '<p class="text-center">Nessun Pokémon trovato.</p>';
                echo '</div>';
            }
            ?>
        </div>

        <!-- Bottone per aggiungere un nuovo Pokemon -->
        <div class="row justify-content-center mt-5">
        <div class="col-12 col-md-8 col-lg-6 d-flex align-items-center">
            <a href="create.php" class="btn btn-dark d-block w-100">Aggiungi un nuovo Pokémon!</a>
        </div>
        </div>