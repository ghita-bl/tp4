<?php
require_once '../includes/db.php';
require("../includes/header.php");

// Get total number of students
$sql = "SELECT COUNT(*) as total_etudiants FROM etudiants";
$result = mysqli_query($conn, $sql);
$total_etudiants = mysqli_fetch_assoc($result)['total_etudiants'];

// Get total number of PFEs
$sql = "SELECT COUNT(*) as total_pfes FROM pfes";
$result = mysqli_query($conn, $sql);
$total_pfes = mysqli_fetch_assoc($result)['total_pfes'];

// Get total number of supervisors
$sql = "SELECT COUNT(*) as total_enseignants FROM enseignants";
$result = mysqli_query($conn, $sql);
$total_enseignants = mysqli_fetch_assoc($result)['total_enseignants'];

// Get PFEs by status
$sql = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN rapport IS NULL THEN 1 ELSE 0 END) as sans_rapport,
            SUM(CASE WHEN rapport IS NOT NULL AND rapport_confirme = 0 THEN 1 ELSE 0 END) as rapport_en_attente,
            SUM(CASE WHEN rapport_confirme = 1 THEN 1 ELSE 0 END) as rapport_confirme
        FROM pfes";
$result = mysqli_query($conn, $sql);
$pfe_stats = mysqli_fetch_assoc($result);

// Get PFEs by organization
$sql = "SELECT organisme, COUNT(*) as count 
        FROM pfes 
        GROUP BY organisme 
        ORDER BY count DESC 
        LIMIT 5";
$result = mysqli_query($conn, $sql);
$top_organismes = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Get PFEs by supervisor
$sql = "SELECT e.nom, e.prenom, COUNT(p.id) as count 
        FROM enseignants e 
        LEFT JOIN pfes p ON e.id = p.encadrant_in_id 
        GROUP BY e.id 
        ORDER BY count DESC 
        LIMIT 5";
$result = mysqli_query($conn, $sql);
$top_encadrants = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<div class="statistics-container">
    <h1>Statistiques Générales</h1>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Nombre Total d'Étudiants</h3>
            <div class="stat-value"><?php echo $total_etudiants; ?></div>
        </div>

        <div class="stat-card">
            <h3>Nombre Total de PFEs</h3>
            <div class="stat-value"><?php echo $total_pfes; ?></div>
        </div>

        <div class="stat-card">
            <h3>Nombre Total d'Encadrants</h3>
            <div class="stat-value"><?php echo $total_enseignants; ?></div>
        </div>
    </div>

    <div class="stats-section">
        <h2>Statut des Rapports de PFE</h2>
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Sans Rapport</h3>
                <div class="stat-value"><?php echo $pfe_stats['sans_rapport']; ?></div>
                <div class="stat-percentage"><?php echo round(($pfe_stats['sans_rapport'] / $pfe_stats['total']) * 100, 1); ?>%</div>
            </div>

            <div class="stat-card">
                <h3>En Attente de Confirmation</h3>
                <div class="stat-value"><?php echo $pfe_stats['rapport_en_attente']; ?></div>
                <div class="stat-percentage"><?php echo round(($pfe_stats['rapport_en_attente'] / $pfe_stats['total']) * 100, 1); ?>%</div>
            </div>

            <div class="stat-card">
                <h3>Rapports Confirmés</h3>
                <div class="stat-value"><?php echo $pfe_stats['rapport_confirme']; ?></div>
                <div class="stat-percentage"><?php echo round(($pfe_stats['rapport_confirme'] / $pfe_stats['total']) * 100, 1); ?>%</div>
            </div>
        </div>
    </div>

    <div class="stats-section">
        <h2>Top 5 Organismes d'Accueil</h2>
        <div class="table-container">
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Organisme</th>
                        <th>Nombre de PFEs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_organismes as $org): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($org['organisme']); ?></td>
                            <td><?php echo $org['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="stats-section">
        <h2>Top 5 Encadrants</h2>
        <div class="table-container">
            <table class="stats-table">
                <thead>
                    <tr>
                        <th>Encadrant</th>
                        <th>Nombre de PFEs</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($top_encadrants as $enc): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($enc['prenom'] . ' ' . $enc['nom']); ?></td>
                            <td><?php echo $enc['count']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .statistics-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        text-align: center;
    }

    .stat-card h3 {
        margin: 0 0 10px 0;
        color: #333;
        font-size: 1.1em;
    }

    .stat-value {
        font-size: 2em;
        font-weight: bold;
        color: #007bff;
        margin-bottom: 5px;
    }

    .stat-percentage {
        color: #666;
        font-size: 0.9em;
    }

    .stats-section {
        margin-bottom: 40px;
    }

    .stats-section h2 {
        margin-bottom: 20px;
        color: #333;
        border-bottom: 2px solid #007bff;
        padding-bottom: 10px;
    }

    .table-container {
        overflow-x: auto;
    }

    .stats-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .stats-table th,
    .stats-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .stats-table th {
        background-color: #f8f9fa;
        font-weight: bold;
        color: #333;
    }

    .stats-table tr:hover {
        background-color: #f5f5f5;
    }
</style>

<?php include '../includes/footer.php'; ?>
