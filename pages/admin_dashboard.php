<?php
session_start(); 
include '../includes/header.php';
include '../includes/nav.php'; // Special admin navigation
?>
<link rel="stylesheet" href="../style/sheet.css">
<div class="admin-dashboard">
    <h1>Tableau de Bord Administrateur</h1>
    <?php if (isset($_SESSION['prenom'])): ?>
        <div class="welcome-admin">Bienvenue Administrateur <?= htmlspecialchars($_SESSION['prenom']) ?></div>
    <?php endif; ?>
    
    <!-- Admin specific content -->
    <div class="admin-actions">
        <a href="../admin/cruddepartements.php" ">Départements</a>
        <a href="../admin/crudfilieres.php" >Filières</a>
        <a href="../admin/crudenseignants.php" >Enseignants</a>
        <a href="../admin/crudetudiants.php" >Étudiants</a>
        <a href="../admin/crudpfes.php" >PFEs</a> 
        <a href="../admin/statistiques.php" >Statistiques</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>