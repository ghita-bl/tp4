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
        if(!isset($_SESSION["profil"]) or $_SESSION["profil"]!="Etudiant")  header("location:../pages/index.php");
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
        }
        // on récupère la liste des enseignants (id,nom,prenom,email,dept_id)
        $reqe="SELECT * FROM enseignants ";
        $rese = mysqli_query($conn,$reqe);
        $ne = mysqli_num_rows($rese); // nombre d'enseignants.
        ?>
        <!-- ce formulaire peut être pour ajouter ou modifier le PFE de l'étudiant connecté -->
        <h3><?php echo $_SESSION["msg"]; $_SESSION["msg"]=""?></h3>
        <form action="<?php echo ($n==0?"insererpfe.php":"modifierpfe.php"); ?>" method="post">
            <fieldset>
                <legend><h2><?php echo ($n==0?"Ajouter votre PFE":"Modifier votre PFE"); ?></h2></legend>
                <input type="hidden" name="id" value="<?php echo $a; ?>">
                <input type="hidden" name="etudiant_id" value="<?php echo $b; ?>">
                Titre------------------------:<input type="text" name="titre" size="50" value="<?php echo $c; ?>"><br/><br/>
                Résumé--------------------:<textarea name="resume"> <?php echo $d; ?></textarea><br/><br/>
                Organisme-----------------:<input type="text" name="organisme" size="50" value="<?php echo $e; ?>"> <br/><br/>
                Encadrant externe--------:<input type="text" name="encadrant_ex" size="50" value="<?php echo $f; ?>"> <br/><br/>
                Email-encadrant externe:<input type="text" name="email_ex" size="50" value="<?php echo $g; ?>"> <br/><br/>
                Encadrant interne--------:<select name="encadrant_in_id">
                    <?php
                    for ($j=0; $j<$ne; $j++)
                    {
                        $rowe = mysqli_fetch_assoc($rese);
                        echo "<option value=",$rowe["id"]," ",($h==$rowe['id']?"selected":""),">",$rowe["nom"]," ",$rowe["prenom"],"</option>";
                    }
                    ?>
                </select>
                <button type="submit">enregistrer</button>
            </fieldset>
        </form>

    </div>
</main>
<?php
require("../includes/footer.php");
?>