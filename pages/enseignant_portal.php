<?php
session_start();
include '../includes/header.php';
include '../includes/nav.php';
include '../includes/db.php';

// Get supervisor ID from session
$enseignant_id = $_SESSION['id'];

// Handle report confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_report'])) {
    $pfe_id = $_POST['pfe_id'];
    $sql = "UPDATE pfes SET rapport_confirme = 1 WHERE id = '$pfe_id' AND encadrant_in_id = '$enseignant_id'";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['msg'] = "Rapport confirmé avec succès";
    } else {
        $_SESSION['error'] = "Erreur lors de la confirmation: " . mysqli_error($conn);
    }
    header("Location: enseignant_portal.php");
    exit();
}

// Fetch students' PFE details for this supervisor
$sql = "SELECT p.*, e.nom as etudiant_nom, e.prenom as etudiant_prenom
        FROM pfes p 
        JOIN etudiants e ON p.etudiant_id = e.id 
        WHERE p.encadrant_in_id = '$enseignant_id'";
$result = mysqli_query($conn, $sql);
?>

<div class="enseignant-portal">
    <h1>Portail Encadrant</h1>
    <?php if (isset($_SESSION['prenom']) && isset($_SESSION['nom'])): ?>
        <div class="welcome-enseignant">Bienvenue <?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>PFEs à encadrer</h2>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="pfe-list">
                <?php while ($pfe = mysqli_fetch_assoc($result)): ?>
                    <div class="pfe-item">
                        <div class="info-section">
                            <h3>Informations Étudiant</h3>
                            <p><strong>Étudiant:</strong> <?php echo htmlspecialchars($pfe['etudiant_prenom'] . ' ' . $pfe['etudiant_nom']); ?></p>
                        </div>

                        <div class="info-section">
                            <h3>Informations PFE</h3>
                            <p><strong>Titre:</strong> <?php echo htmlspecialchars($pfe['titre']); ?></p>
                            <p><strong>Résumé:</strong> <?php echo htmlspecialchars($pfe['resume']); ?></p>
                            <p><strong>Organisme:</strong> <?php echo htmlspecialchars($pfe['organisme']); ?></p>
                        </div>

                        <div class="info-section">
                            <h3>Encadrement</h3>
                            <p><strong>Encadrant Externe:</strong> <?php echo htmlspecialchars($pfe['encadrant_ex']); ?></p>
                            <p><strong>Email Encadrant Externe:</strong> <?php echo htmlspecialchars($pfe['email_ex']); ?></p>
                        </div>

                        <div class="info-section">
                            <h3>Rapport</h3>
                            <?php if ($pfe['rapport']): ?>
                                <p>
                                    <a href="../uploads/pfes/<?php echo $pfe['rapport']; ?>" target="_blank" class="btn btn-primary">
                                        Voir le rapport
                                    </a>
                                </p>
                                <?php if (!isset($pfe['rapport_confirme']) || $pfe['rapport_confirme'] == 0): ?>
                                    <form method="POST" action="" style="display: inline;">
                                        <input type="hidden" name="pfe_id" value="<?php echo $pfe['id']; ?>">
                                        <button type="submit" name="confirm_report" class="btn btn-success">
                                            Confirmer le rapport
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="status-badge status-confirmed">
                                        Rapport confirmé
                                    </span>
                                <?php endif; ?>
                            <?php else: ?>
                                <p>Aucun rapport n'a été uploadé</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>Vous n'avez aucun PFE à encadrer pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<style>
    .enseignant-portal {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }
    .card {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .pfe-list {
        display: grid;
        gap: 20px;
    }
    .pfe-item {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-weight: bold;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }
    .btn-primary {
        background-color: #007bff;
        color: white;
    }
    .btn-success {
        background-color: #28a745;
        color: white;
    }
    .status-badge {
        padding: 5px 10px;
        border-radius: 4px;
        font-weight: bold;
    }
    .status-pending {
        background-color: #ffc107;
        color: #000;
    }
    .status-confirmed {
        background-color: #28a745;
        color: white;
    }
    .info-section {
        margin-bottom: 20px;
    }
    .info-section h3 {
        margin-bottom: 10px;
        color: #333;
        font-size: 1.1em;
    }
    .info-section p {
        margin: 5px 0;
        color: #666;
    }
    .welcome-enseignant {
        font-size: 1.2em;
        margin-bottom: 20px;
        color: #333;
    }
    .alert {
        padding: 15px;
        margin-bottom: 20px;
        border-radius: 4px;
    }
    .alert-success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
</style>

<?php include '../includes/footer.php'; ?>