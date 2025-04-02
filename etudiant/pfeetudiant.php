<html lang="fr">
<head> <title>Gestion des PFE</title> </head>
<body>
<?php
require("../includes/header.php");
require("../includes/db.php");
$conn =mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDD);
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
?>
<main style="position: absolute;top:200px; width: 100%;align-items: center">

    <div style="width: 100%;margin-left: 100px">
        <?php
        // pas de connexion ou l'utilisateur connecté n'est pas un étudiant
        if(!isset($_SESSION["profil"]) or $_SESSION["profil"]!="Etudiant") header("location:../pages/index.php");
        //Table pfes (id, etudiant_id, titre, resume, organisme, encadrant_ex, email_ex, encadrant_in_id, rapport)
        $etudiant_id=$_SESSION['id']; // l'id de l'étudiant connecté
        $req="SELECT * FROM pfes WHERE etudiant_id=$etudiant_id"; //pour avoir le pfe de l'étudiant connecté
        $res = mysqli_query($conn,$req);
        $n = mysqli_num_rows($res); // nombre de lignes retournées.
        $a=0; $b= $etudiant_id; $c="";$d="";$e="";$f="";$g="";$h="";$i=""; // pour stocker les attributs du PFE à ajouter ou modifier
        if ($n!=0) // le pfe est déjà ajouté
        {
            $row = mysqli_fetch_assoc($res);
            $a=$row["id"]; $b=$row["etudiant_id"]; $c=$row["titre"];$d=$row["resume"];$e=$row["organisme"];$f=$row["encadrant_ex"];
            $g=$row["email_ex"];$h=$row["encadrant_in_id"];$i=$row["rapport"];
            // on récupère l'encadrant interne de la table enseignants (id,nom,prenom,email,dept_id)
            $reqe="SELECT * FROM enseignants where id=$h";
            $rese = mysqli_query($conn,$reqe);
            $rowe = mysqli_fetch_assoc($rese);
        ?>
                Titre------------------------:<?php echo $c; ?><br/><br/>
                Résumé--------------------:<?php echo $d; ?><br/><br/>
                Organisme-----------------:<?php echo $e; ?><br/><br/>
                Encadrant externe--------:<?php echo $f; ?> <br/><br/>
                Email-encadrant externe: <?php echo $g; ?> <br/><br/>
                Encadrant interne--------: <?php echo $rowe['nom']," ",$rowe['prenom']; ?>
                <?php
        }
        else
            echo "<h3>Veuillez ajouter votre PFE</h3>"
        ?>
        <hr>
        <a href="../etudiant/editerpfe.php">
            <button type="button" style="background-color: blue; color: white; border-radius: 5px">
                <?php echo($n == 0 ? "Ajouter PFE" : "Modifier PFE"); ?>
            </button>
        </a>
    </div>
</main>
<?php
require("../includes/footer.php");
?>