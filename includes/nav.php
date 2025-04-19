<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">
    <div class="nav-brand">
        <a href="../pages/index.php">Aceuil</a>
    </div>
    
    <div class="nav-search">
        <form action="../search.php" method="GET" class="search-form">
            <input type="text" name="q" placeholder="Rechercher par mots-clés (titre, étudiant, organisme...)" class="search-input">
            <button type="submit" class="search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    <div class="nav-links">
        <?php if (isset($_SESSION['id'])): ?>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="../pages/admin_dashboard.php">Dashboard Admin</a>
                <a href="../admin/crudpfes.php">Gérer les PFEs</a>
                <a href="../admin/statistiques.php">Statistiques</a>
            <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'enseignant'): ?>
                <a href="../pages/enseignant_portal.php">Portail Encadrant</a>
            <?php else: ?>
                <a href="../pages/etudiant_portal.php">Portail Étudiant</a>
            <?php endif; ?>
            <a href="../pages/logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="../pages/login.php">Connexion</a>
        <?php endif; ?>
    </div>
</nav>

<style>
    .navbar {
        background-color: #2c3e50;
        padding: 1rem 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .nav-brand a {
        color: white;
        text-decoration: none;
        font-size: 1.5rem;
        font-weight: bold;
    }

    .nav-search {
        flex: 1;
        max-width: 500px;
        margin: 0 2rem;
    }

    .search-form {
        display: flex;
        width: 100%;
    }

    .search-input {
        flex: 1;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 4px 0 0 4px;
        font-size: 1rem;
    }

    .search-button {
        background-color: #3498db;
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0 4px 4px 0;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .search-button:hover {
        background-color: #2980b9;
    }

    .nav-links {
        display: flex;
        gap: 1rem;
    }

    .nav-links a {
        color: white;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .nav-links a:hover {
        background-color: rgba(255,255,255,0.1);
    }

    @media (max-width: 768px) {
        .navbar {
            flex-direction: column;
            gap: 1rem;
        }

        .nav-search {
            width: 100%;
            margin: 1rem 0;
        }

        .nav-links {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
