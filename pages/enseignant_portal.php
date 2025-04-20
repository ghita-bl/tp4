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

<main>
    <section class="enseignant-portal">
        <h1>Portail Encadrant</h1>
        
        <?php if (isset($_SESSION['prenom']) && isset($_SESSION['nom'])): ?>
            <div class="welcome-teacher">Bienvenue <?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?></div>
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
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Étudiant</th>
                                <th>Titre du PFE</th>
                                <th>Organisme</th>
                                <th>Date de début</th>
                                <th>Date de fin</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($pfe = mysqli_fetch_assoc($result)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($pfe['etudiant_prenom'] . ' ' . $pfe['etudiant_nom']) ?></td>
                                    <td><?= htmlspecialchars($pfe['titre']) ?></td>
                                    <td><?= htmlspecialchars($pfe['organisme']) ?></td>
                                    <td><?= htmlspecialchars($pfe['date_debut']) ?></td>
                                    <td><?= htmlspecialchars($pfe['date_fin']) ?></td>
                                    <td>
                                        <?php if ($pfe['rapport_confirme'] == 1): ?>
                                            <span class="badge badge-success">Rapport confirmé</span>
                                        <?php else: ?>
                                            <span class="badge badge-warning">En attente</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="../uploads/<?= $pfe['rapport_path'] ?>" class="btn btn-primary btn-sm" target="_blank">Voir rapport</a>
                                        <?php if ($pfe['rapport_confirme'] == 0): ?>
                                            <form method="post" style="display: inline;">
                                                <input type="hidden" name="pfe_id" value="<?= $pfe['id'] ?>">
                                                <button type="submit" name="confirm_report" class="btn btn-success btn-sm">Confirmer rapport</button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info">Vous n'avez pas de PFEs à encadrer pour le moment.</div>
            <?php endif; ?>
        </div>
    </section>
</main>

<?php include '../includes/footer.php'; ?>