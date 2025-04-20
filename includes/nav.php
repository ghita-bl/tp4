<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base URL for the project if not already defined
if (!isset($base_url)) {
    $base_url = '/tp4';
}
?>

<nav class="navbar">
    <div class="nav-brand">
        <a href="<?php echo $base_url; ?>/pages/index.php"><i class="fas fa-graduation-cap"></i> INPT.EDU</a>
    </div>
    
    <div class="nav-search">
        <form action="<?php echo $base_url; ?>/search.php" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Rechercher par mots-clés (titre, étudiant, organisme...)" class="search-input">
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <div class="nav-links">
        <?php if (isset($_SESSION['id'])): ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="<?php echo $base_url; ?>/pages/admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                <a href="<?php echo $base_url; ?>/admin/crudpfes.php"><i class="fas fa-tasks"></i> Gérer les PFEs</a>
                <a href="<?php echo $base_url; ?>/admin/statistiques.php"><i class="fas fa-chart-bar"></i> Statistiques</a>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'enseignant'): ?>
                <a href="<?php echo $base_url; ?>/pages/enseignant_portal.php"><i class="fas fa-chalkboard-teacher"></i> Portail Encadrant</a>
            <?php else: ?>
                <a href="<?php echo $base_url; ?>/pages/etudiant_portal.php"><i class="fas fa-user-graduate"></i> Portail Étudiant</a>
            <?php endif; ?>
            <a href="<?php echo $base_url; ?>/pages/logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        <?php else: ?>
            <a href="<?php echo $base_url; ?>/pages/login.php" class="login-btn"><i class="fas fa-sign-in-alt"></i> Connexion</a>
        <?php endif; ?>
    </div>
</nav>
