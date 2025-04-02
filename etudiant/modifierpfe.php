<?php
require("../includes/db.php");
$conn =mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDD);
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
//Table pfes (id, etudiant_id, titre, resume, organisme,
//           encadrant_ex, email_ex, encadrant_in_id, rapport)
$req="update  pfes set titre='".$_POST['titre']."' ,".
                       "resume='".$_POST['resume']."' ,".
                       "organisme='".$_POST['organisme']."' ,".
                       "encadrant_ex='".$_POST['encadrant_ex']."' ,".
                       "email_ex='".$_POST['email_ex']."' ,".
                        "encadrant_in_id= ".$_POST['encadrant_in_id'].
                        " where id=".$_POST['id'];
echo $req;
$res = mysqli_query($conn,$req);
session_start();
if($res) $_SESSION['msg'] = "PFE Modifié";
else $_SESSION['msg'] = "Erreur, PFE non modifié";
header('Location: ../pages/index.php');
?>