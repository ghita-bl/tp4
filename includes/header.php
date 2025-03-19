<?php
session_start(); // Démarrer la session pour accéder aux variables de session
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INPT.EDU</title>
    <link rel="stylesheet" href="../styles/sheet.css">
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="../images/logo.jpg" alt="logo" style="vertical-align: middle; width: 30px; height: 30px"/>
                INPT.EDU
            </div>
            <input type="checkbox" id="checkbox">
            <label for="checkbox" id="icon">...</label>
            <ul>
                <li><a href="../pages/index.php" class="active">Accueil</a></li>
                <?php
                if (isset($_SESSION['user_role'])) {
                    if ($_SESSION['user_role'] == 'admin') {
                        echo '<li><a href="../admin/cruddepartements.php">Départements</a></li>';
                        echo '<li><a href="../admin/crudfilieres.php">Filières</a></li>';
                        echo '<li><a href="../admin/crudenseignants.php">Enseignants</a></li>';
                        echo '<li><a href="../admin/crudetudiants.php">Étudiants</a></li>';
                        echo '<li><a href="../admin/crudpfes.php">PFEs</a></li>';
                    }
                    echo '<li><a href="../pages/recherche_pfes.php">Rechercher PFEs</a></li>';
                    echo '<li><a href="../pages/logout.php">Déconnexion</a></li>';
                } else {
                    echo '<li><a href="../pages/login.php">Connexion</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
    <main></main>