


<nav style="background-color: yellow;">
    <a href="../pages/index.php"> Accueil </a> ---
    <?php
    session_start(); 
    if (isset($_SESSION['profil'])) {
        //pour afficher le nom et le prenom
        if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
            echo '<span>Bienvenue, ' . htmlspecialchars($_SESSION['prenom']) . ' ' . htmlspecialchars($_SESSION['nom']) . '</span> --- ';
        }

        // affichage des liens en fct du role de l'utilisateur
        if ($_SESSION['profil'] == "Etudiant") {
            echo '<a href="../etudiant/pfeetudiant.php">PFE</a> --- ';
            echo '<a href="../etudiant/modifierpfe.php">Modifier PFE</a> --- ';
            echo '<a href="../etudiant/editerpfe.php">Editer PFE</a> --- ';
            echo '<a href="../etudiant/insererpfe.php">Inserer PFE</a> --- ';
        }
        if ($_SESSION['profil'] == "Enseignant") {
            echo '<a href="../admin/crudenseignants.php">Encadrement</a> --- ';
        }
        if ($_SESSION['profil'] == "Admin") {
            echo '<a href="../admin/listetudiant.php">MAJ Utilisateurs</a> --- ';
        }

        // button du logout
        echo '<a href="../pages/logout.php">Déconnexion</a>';
    }
    ?>
    <hr>
</nav>