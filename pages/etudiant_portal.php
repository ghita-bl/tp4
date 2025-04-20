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

<main>
    <section class="student-portal">
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
                <div class="card-grid">
                    <div class="card">
                        <h3 class="card-title">Informations Générales</h3>
                        <p><strong>Titre:</strong> <?php echo htmlspecialchars($pfe['titre']); ?></p>
                        <p><strong>Résumé:</strong> <?php echo htmlspecialchars($pfe['resume']); ?></p>
                        <p><strong>Organisme:</strong> <?php echo htmlspecialchars($pfe['organisme']); ?></p>
                    </div>

                    <div class="card">
                        <h3 class="card-title">Encadrement</h3>
                        <p><strong>Encadrant Externe:</strong> <?php echo htmlspecialchars($pfe['encadrant_ex']); ?></p>
                        <p><strong>Email Encadrant Externe:</strong> <?php echo htmlspecialchars($pfe['email_ex']); ?></p>
                        <p><strong>ID Encadrant Interne:</strong> <?php echo $pfe['encadrant_in_id']; ?></p>
                    </div>

                    <div class="card">
                        <h3 class="card-title">Rapport</h3>
                        <?php if ($pfe['rapport']): ?>
                            <p>
                                <a href="../uploads/pfes/<?php echo $pfe['rapport']; ?>" target="_blank" class="btn btn-primary">
                                    Voir le rapport
                                </a>
                            </p>
                            <?php if (isset($pfe['rapport_confirme']) && $pfe['rapport_confirme'] == 1): ?>
                                <div class="alert alert-success">Rapport confirmé par l'encadrant</div>
                            <?php else: ?>
                                <div class="alert alert-warning">Rapport en attente de confirmation</div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="alert alert-info">Aucun rapport n'a été uploadé</div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Vous n'avez pas encore de PFE assigné.</div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>