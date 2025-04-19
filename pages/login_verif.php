<?php
require("../includes/db.php");
$conn = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDD);
if (!$conn) {
    die("Échec de la connexion : " . mysqli_connect_error());
}

$a = $_POST["email"];
$b = $_POST["password"];

$req1 = "SELECT * FROM users WHERE email='$a' and password='$b'";
$res1 = mysqli_query($conn, $req1);
$n1 = mysqli_num_rows($res1);

if($n1 == 0) {
    header("location:login.php?msg=Login ou mot de passe incorrect");
    exit();
}

$row1 = mysqli_fetch_assoc($res1);
session_start();
$_SESSION['username'] = $a;
$_SESSION['profil'] = $row1["role"];

// Redirect based on user role
switch($row1["role"]) {
    case 'Admin':
        // Admin specific data if needed
        $_SESSION['admin_id'] = $row1["user_id"];
        $redirect = "admin_dashboard.php";
        break;
        
    case 'Etudiant':
        $identifiant = $row1["user_id"];
        $req2 = "SELECT * FROM etudiants WHERE id=$identifiant";
        $res2 = mysqli_query($conn, $req2);
        $row2 = mysqli_fetch_assoc($res2);
        
        $_SESSION['id'] = $row2["id"];
        $_SESSION['nom'] = $row2["nom"];
        $_SESSION['prenom'] = $row2["prenom"];
        $_SESSION['filiere'] = $row2["filiere"]; // Example additional field
        $redirect = "etudiant_portal.php";
        break;
        
    case 'Enseignant':
        $identifiant = $row1["user_id"];
        $req2 = "SELECT * FROM enseignants WHERE id=$identifiant";
        $res2 = mysqli_query($conn, $req2);
        $row2 = mysqli_fetch_assoc($res2);
        
        $_SESSION['id'] = $row2["id"];
        $_SESSION['nom'] = $row2["nom"];
        $_SESSION['prenom'] = $row2["prenom"];
        $_SESSION['departement'] = $row2["departement"]; // Example additional field
        $redirect = "enseignant_portal.php";
        break;
        
    default:
        header("location:login.php?msg=Role non reconnu");
        exit();
}

header("location:$redirect");
exit();
?>


