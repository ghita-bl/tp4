<?php
session_start(); 
include '../includes/header.php';
include '../includes/nav.php'; // Student specific navigation
include '../includes/db.php'; // Include database connection

// Get student ID from session
$etudiant_id = $_SESSION['id'];

// Fetch student's PFE details
$sql = "SELECT p.*, e.nom, e.prenom
        FROM pfes p 
        JOIN etudiants e ON p.etudiant_id = e.id 
        WHERE p.etudiant_id = '$etudiant_id'";
$result = mysqli_query($conn, $sql);
$pfe = mysqli_fetch_assoc($result);
?>

<div class="student-portal">
    <h1>Portail Étudiant</h1>
    <?php if (isset($_SESSION['prenom']) && isset($_SESSION['nom'])): ?>
        <div class="welcome-student">Bienvenue <?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?> <?= $_SESSION['filiere'] ?></div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
    <?php endif; ?>

    <div class="card">
        <h2>Votre PFE</h2>
        
        <?php if ($pfe): ?>
            <div class="info-section">
                <h3>Informations Générales</h3>
                <p><strong>Titre:</strong> <?php echo htmlspecialchars($pfe['titre']); ?></p>
                <p><strong>Résumé:</strong> <?php echo htmlspecialchars($pfe['resume']); ?></p>
                <p><strong>Organisme:</strong> <?php echo htmlspecialchars($pfe['organisme']); ?></p>
            </div>

            <div class="info-section">
                <h3>Encadrement</h3>
                <p><strong>Encadrant Externe:</strong> <?php echo htmlspecialchars($pfe['encadrant_ex']); ?></p>
                <p><strong>Email Encadrant Externe:</strong> <?php echo htmlspecialchars($pfe['email_ex']); ?></p>
                <p><strong>ID Encadrant Interne:</strong> <?php echo $pfe['encadrant_in_id']; ?></p>
            </div>

            <div class="info-section">
                <h3>Rapport</h3>
                <?php if ($pfe['rapport']): ?>
                    <p>
                        <a href="../uploads/pfes/<?php echo $pfe['rapport']; ?>" target="_blank" class="btn btn-primary">
                            Voir le rapport
                        </a>
                    </p>
                    <p>
                        <span class="status-badge status-pending">
                            En attente de confirmation
                        </span>
                    </p>
                <?php else: ?>
                    <p>Aucun rapport n'a été uploadé</p>
                <?php endif; ?>
            </div>

            <div class="student-actions">
                <a href="../etudiant/modifierpfe.php?id=<?php echo $pfe['id']; ?>" class="btn btn-primary">Modifier le PFE</a>
                <?php if (!$pfe['rapport']): ?>
                    <a href="../etudiant/modifierpfe.php?id=<?php echo $pfe['id']; ?>" class="btn btn-secondary">Uploader le rapport</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Vous n'avez pas encore de PFE enregistré.</p>
            <div class="student-actions">
                <a href="../etudiant/insererpfe.php" class="btn btn-primary">Créer un nouveau PFE</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .student-portal {
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
    .btn-secondary {
        background-color: #6c757d;
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
    }
    .info-section p {
        margin: 5px 0;
        color: #666;
    }
    .welcome-student {
        font-size: 1.2em;
        margin-bottom: 20px;
        color: #333;
    }
    .student-actions {
        margin-top: 20px;
    }
</style>

<?php include '../includes/footer.php'; ?>