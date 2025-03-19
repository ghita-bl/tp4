<nav style="background-color: aqua;">
    <a href="../pages/index.php"> Accueil </a> ---
    <?php
    session_start();
    if (isset($_SESSION['profil'])) {
    if($_SESSION['profil']=="Etudiant") {    ?>
    <a href="../etudiants/pfe_etudiant.php">   MAJ PFE   </a> ---
    <?php  }
    if($_SESSION['profil']=="Prof")  {   ?>
    <a href="../admin/crudenseignants.php">    Encadrement     </a> ---
    <?php   }
    if($_SESSION['profil']=="Admin") {   ?>
    <a href="../admin/listetudiant.php">    MAJ Utilisateurs   </a> ---
    <?php
        }
    }
    ?>
    <hr>
</nav>