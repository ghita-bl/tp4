<?php
require("../includes/db.php");
$conn =mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDD);
if (!$conn) {
die("Échec de la connexion : " . mysqli_connect_error());
}
//Table pfes (id, etudiant_id, titre, resume, organisme, encadrant_ex, email_ex, encadrant_in_id, rapport)
$req="insert into pfes(etudiant_id, titre, resume, organisme, encadrant_ex, email_ex, encadrant_in_id) 
      values (".$_POST['etudiant_id'].",'". $_POST['titre']."','". $_POST['resume']."','". $_POST['organisme']."','".
                $_POST['encadrant_ex']."','". $_POST['email_ex']."',". $_POST['encadrant_in_id'].")";

$res = mysqli_query($conn,$req);
session_start();
if($res) $_SESSION['msg'] = "PFE Ajouté";
else $_SESSION['msg'] = "Erreur, PFE non ajouté";
header('Location: ../pages/index.php');

?>