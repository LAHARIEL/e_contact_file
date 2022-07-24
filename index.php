<!-- pas d'insertion du fichier header.php car les liens dans la nav ne sont pas dynamiques donc le lien est cassé quand on est sur une page dans le dossier 'admin' -->
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- lien pour utilisation Bootstrap - CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <!-- lien pour utilisation Bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Répertoire de Lauriane</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Mon e-répertoire</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="index.php"><i class="bi bi-house-door"></i></a>
                        <a class="nav-link" href="admin/gestion_repertoire.php"><i class="bi bi-book"></i></a>
                        <!-- liens sur la page figés selon la position du fichier index vs les pages cibles -->
                    </div>
                </div>
            </div>
        </nav>

    </header>
    <main class="container">
        <section class="p-2" style="min-height : 800px">

            <?php
            require_once 'inc/init.php';

            ?>


            <h1>E-répertoire</h1>
            <h2>Le site qui permet de gérer son répertoire de contact (CRUD)</h2>

            <a class="btn btn-info m-5" href="admin/formulaire_contact.php" role="button">Créer un nouveau contact <i class="bi bi-check2-square"></i></a>

            <a class="btn btn-secondary m-5" href="admin/gestion_repertoire.php" role="button">Voir tout le répertoire <i class="bi bi-book"></i></a>



            <?php require_once 'inc/footer.php';
