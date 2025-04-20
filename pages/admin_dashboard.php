<?php
session_start(); 
include '../includes/header.php';
include '../includes/nav.php'; // Special admin navigation
?>

<main>
    <section class="admin-dashboard">
        <h1>Tableau de Bord Administrateur</h1>
        
        <?php if (isset($_SESSION['prenom'])): ?>
            <div class="welcome-admin">Bienvenue Administrateur <?= htmlspecialchars($_SESSION['prenom']) ?></div>
        <?php endif; ?>
        
        <div class="admin-actions">
            <div class="card">
                <h3 class="card-title">Gestion des Départements</h3>
                <p>Gérez les départements de l'INPT</p>
                <a href="../admin/cruddepartements.php" class="btn btn-primary">Accéder</a>
            </div>
            
            <div class="card">
                <h3 class="card-title">Gestion des Filières</h3>
                <p>Gérez les filières de l'INPT</p>
                <a href="../admin/crudfilieres.php" class="btn btn-primary">Accéder</a>
            </div>
            
            <div class="card">
                <h3 class="card-title">Gestion des Enseignants</h3>
                <p>Gérez les enseignants de l'INPT</p>
                <a href="../admin/crudenseignants.php" class="btn btn-primary">Accéder</a>
            </div>
            
            <div class="card">
                <h3 class="card-title">Gestion des Étudiants</h3>
                <p>Gérez les étudiants de l'INPT</p>
                <a href="../admin/crudetudiants.php" class="btn btn-primary">Accéder</a>
            </div>
            
            <div class="card">
                <h3 class="card-title">Gestion des PFEs</h3>
                <p>Gérez les projets de fin d'études</p>
                <a href="../admin/crudpfes.php" class="btn btn-primary">Accéder</a>
            </div>
            
            <div class="card">
                <h3 class="card-title">Statistiques</h3>
                <p>Consultez les statistiques des PFEs</p>
                <a href="../admin/statistiques.php" class="btn btn-primary">Accéder</a>
            </div>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>