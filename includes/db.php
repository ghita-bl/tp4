<?php
$serveur = 'localhost';
$baseDD = 'inpt';
$utilisateur = 'root';
$motDePasse = '';

$conn = mysqli_connect($serveur, $utilisateur, $motDePasse, $baseDD);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}



?>