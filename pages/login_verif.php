<?php

require("../includes/db.php");
$conn =mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDD);
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}
$a = $_POST["email"];
$b =$_POST["password"];
//Table users (id, email, password,role,user_id)
$req1="SELECT * FROM users WHERE email='$a'and password='$b' ";
//exécution de la requête SELECT
$res1=mysqli_query($conn,$req1);
// nombre de lignes retournées.
$n1 = mysqli_num_rows($res1);
//si le nombre de ligne retournées est 0 => on le redirige vers la page login.php à qui on passe une donnée msg
if($n1 == 0)  {header("location:login.php?msg=Login ou mot de passe incorrect"); exit();}

// l'utilisateur existe, on  récupère ses attributs
$row1 = mysqli_fetch_assoc($res1);
// Il peut être Etudiant, Prof ou Admin.
// Dans les trois cas, on récupère ses autres attributs (nom, ...) de la table adéquate
$identifiant = $row1["user_id"]; //identifiant d'un étudiant, prof ou admin.
if($row1["role"]=='Etudiant')  $req2="SELECT * FROM etudiants WHERE id=$identifiant";
if($row1["role"]=='Enseignant')      $req2="SELECT * FROM enseignants WHERE id=$identifiant";
//echo $req2;
$res2=mysqli_query($conn,$req2);
$n2 = mysqli_num_rows($res1);
if($n2==0)  {header("location:login.php?msg=Contacter votre administrateur"); exit();}
$row2 = mysqli_fetch_assoc($res2);
session_start();
$_SESSION['username'] = $a;
$_SESSION['profil'] = $row1["role"];
$_SESSION['id'] = $row2["id"];
$_SESSION['nom'] = $row2["nom"];
$_SESSION['prenom'] = $row2["prenom"];
//echo $_SESSION['username'] ,' ',$_SESSION['profil'] ,$_SESSION['id'], $_SESSION['nom'],$_SESSION['prenom'];
//exit();

header("location:index.php");


?>


