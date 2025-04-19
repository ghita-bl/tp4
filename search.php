<?php
require_once 'includes/db.php';
require 'includes/header.php';

$search_query = isset($_GET['q']) ? trim($_GET['q']) : '';

if (!empty($search_query)) {
    // Split the search query into keywords
    $keywords = preg_split('/\s+/', $search_query);
    
    // Build the WHERE clause for each keyword
    $where_conditions = [];
    foreach ($keywords as $keyword) {
        $keyword = mysqli_real_escape_string($conn, $keyword);
        $where_conditions[] = "(p.titre LIKE '%$keyword%'
            OR p.organisme LIKE '%$keyword%'
            OR p.resume LIKE '%$keyword%'
            OR CONCAT(e.prenom, ' ', e.nom) LIKE '%$keyword%'
            OR CONCAT(en.prenom, ' ', en.nom) LIKE '%$keyword%'
            OR p.encadrant_ex LIKE '%$keyword%'
            OR p.email_ex LIKE '%$keyword%')";
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    $sql = "SELECT p.*, e.nom as etudiant_nom, e.prenom as etudiant_prenom,
            en.nom as encadrant_nom, en.prenom as encadrant_prenom
            FROM pfes p
            LEFT JOIN etudiants e ON p.etudiant_id = e.id
            LEFT JOIN enseignants en ON p.encadrant_in_id = en.id
            WHERE $where_clause
            ORDER BY p.titre";
    
    $result = mysqli_query($conn, $sql);
    $pfes = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
?>

<div class="search-container">
    <h1>Résultats de recherche</h1>
    
    <?php if (!empty($search_query)): ?>
        <div class="search-info">
            <p>Recherche pour : <strong><?php echo htmlspecialchars($search_query); ?></strong></p>
            <p>Mots-clés : 
                <?php 
                $keywords = preg_split('/\s+/', $search_query);
                foreach ($keywords as $keyword) {
                    echo '<span class="keyword">' . htmlspecialchars($keyword) . '</span> ';
                }
                ?>
            </p>
            <p>Nombre de résultats : <?php echo count($pfes); ?></p>
        </div>

        <?php if (count($pfes) > 0): ?>
            <div class="pfe-list">
                <?php foreach ($pfes as $pfe): ?>
                    <div class="pfe-card">
                        <h2><?php echo htmlspecialchars($pfe['titre']); ?></h2>
                        
                        <div class="pfe-info">
                            <p><strong>Étudiant:</strong> <?php echo htmlspecialchars($pfe['etudiant_prenom'] . ' ' . $pfe['etudiant_nom']); ?></p>
                            <p><strong>Organisme:</strong> <?php echo htmlspecialchars($pfe['organisme']); ?></p>
                            <p><strong>Encadrant Interne:</strong> <?php echo htmlspecialchars($pfe['encadrant_prenom'] . ' ' . $pfe['encadrant_nom']); ?></p>
                            <p><strong>Encadrant Externe:</strong> <?php echo htmlspecialchars($pfe['encadrant_ex']); ?></p>
                            <p><strong>Résumé:</strong> <?php echo htmlspecialchars(substr($pfe['resume'], 0, 200)) . '...'; ?></p>
                        </div>

                        <div class="pfe-actions">
                            <?php if ($pfe['rapport']): ?>
                                <a href="uploads/pfes/<?php echo $pfe['rapport']; ?>" target="_blank" class="btn btn-primary">
                                    Voir le rapport
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-results">
                <p>Aucun résultat trouvé pour votre recherche.</p>
                <p>Suggestions :</p>
                <ul>
                    <li>Vérifiez l'orthographe de vos mots-clés</li>
                    <li>Essayez des mots-clés plus généraux</li>
                    <li>Essayez de réduire le nombre de mots-clés</li>
                </ul>
            </div>
        <?php endif; ?>
    <?php else: ?>
        <div class="no-query">
            <p>Veuillez entrer des mots-clés pour votre recherche.</p>
            <p>Exemples de recherche :</p>
            <ul>
                <li>Intelligence artificielle</li>
                <li>Développement web</li>
                <li>Nom d'étudiant</li>
                <li>Nom d'organisme</li>
            </ul>
        </div>
    <?php endif; ?>
</div>

<style>
    .search-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .search-info {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f8f9fa;
        border-radius: 4px;
    }

    .keyword {
        background-color: #e3f2fd;
        padding: 2px 6px;
        border-radius: 4px;
        margin-right: 5px;
        font-size: 0.9em;
    }

    .pfe-list {
        display: grid;
        gap: 20px;
    }

    .pfe-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
    }

    .pfe-card h2 {
        margin: 0 0 15px 0;
        color: #2c3e50;
    }

    .pfe-info {
        margin-bottom: 15px;
    }

    .pfe-info p {
        margin: 5px 0;
        color: #666;
    }

    .pfe-actions {
        margin-top: 15px;
    }

    .btn {
        display: inline-block;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: bold;
        transition: background-color 0.3s;
    }

    .btn-primary {
        background-color: #3498db;
        color: white;
    }

    .btn-primary:hover {
        background-color: #2980b9;
    }

    .no-results,
    .no-query {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .no-results ul,
    .no-query ul {
        list-style: none;
        padding: 0;
        margin: 20px 0;
    }

    .no-results li,
    .no-query li {
        margin: 10px 0;
        color: #666;
    }

    @media (max-width: 768px) {
        .pfe-list {
            grid-template-columns: 1fr;
        }
    }
</style>

<?php include 'includes/footer.php'; ?>