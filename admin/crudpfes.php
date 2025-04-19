<?php
require_once '../includes/db.php';
require("../includes/header.php");
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $etudiant_id = $_POST['etudiant_id'];
                $titre = $_POST['titre'];
                $resume = $_POST['resume'];
                $organisme = $_POST['organisme'];
                $encadrant_ex = $_POST['encadrant_ex'];
                $email_ex = $_POST['email_ex'];
                $encadrant_in_id = $_POST['encadrant_in_id'];
                
                // Handle PDF upload
                $rapport = '';
                if (isset($_FILES['rapport']) && $_FILES['rapport']['error'] == 0) {
                    $file = $_FILES['rapport'];
                    if ($file['type'] == 'application/pdf') {
                        $upload_dir = '../uploads/pfes/';
                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }
                        $filename = $etudiant_id . '_' . time() . '.pdf';
                        move_uploaded_file($file['tmp_name'], $upload_dir . $filename);
                        $rapport = $filename;
                    }
                }

                $sql = "INSERT INTO pfes (etudiant_id, titre, resume, organisme, encadrant_ex, email_ex, encadrant_in_id, rapport, rapport_confirme) 
                        VALUES ('$etudiant_id', '$titre', '$resume', '$organisme', '$encadrant_ex', '$email_ex', '$encadrant_in_id', '$rapport', 0)";
                mysqli_query($conn, $sql);
                break;

            case 'update':
                $id = $_POST['id'];
                $etudiant_id = $_POST['etudiant_id'];
                $titre = $_POST['titre'];
                $resume = $_POST['resume'];
                $organisme = $_POST['organisme'];
                $encadrant_ex = $_POST['encadrant_ex'];
                $email_ex = $_POST['email_ex'];
                $encadrant_in_id = $_POST['encadrant_in_id'];
                
                // Handle PDF upload
                $rapport = $_POST['current_rapport'];
                if (isset($_FILES['rapport']) && $_FILES['rapport']['error'] == 0) {
                    $file = $_FILES['rapport'];
                    if ($file['type'] == 'application/pdf') {
                        $upload_dir = '../uploads/pfes/';
                        if (!file_exists($upload_dir)) {
                            mkdir($upload_dir, 0777, true);
                        }
                        $filename = $etudiant_id . '_' . time() . '.pdf';
                        move_uploaded_file($file['tmp_name'], $upload_dir . $filename);
                        $rapport = $filename;
                    }
                }

                $sql = "UPDATE pfes SET etudiant_id = '$etudiant_id', titre = '$titre', resume = '$resume', 
                        organisme = '$organisme', encadrant_ex = '$encadrant_ex', email_ex = '$email_ex', 
                        encadrant_in_id = '$encadrant_in_id', rapport = '$rapport' WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;

            case 'confirm_rapport':
                $id = $_POST['id'];
                $sql = "UPDATE pfes SET rapport_confirme = 1 WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;

            case 'delete':
                $id = $_POST['id'];
                // Delete the PDF file if it exists
                $sql = "SELECT rapport FROM pfes WHERE id = '$id'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if ($row['rapport']) {
                    unlink('../uploads/pfes/' . $row['rapport']);
                }
                $sql = "DELETE FROM pfes WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;
        }
        header("Location: crudpfes.php");
        exit();
    }
}

// Fetch all PFE projects
$sql = "SELECT * FROM pfes ORDER BY titre";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <title>Gestion des PFEs</title>
</head>
<body>
    <h2>Gestion des Projets de Fin d'Études</h2>

    <!-- Add PFE Form -->
    <h3>Ajouter un PFE</h3>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add">
        <div>
            <label>ID de l'Étudiant:</label>
            <input type="number" name="etudiant_id" required>
        </div>
        <div>
            <label>Titre:</label>
            <input type="text" name="titre" required>
        </div>
        <div>
            <label>Résumé:</label>
            <textarea name="resume" required></textarea>
        </div>
        <div>
            <label>Organisme:</label>
            <input type="text" name="organisme" required>
        </div>
        <div>
            <label>Encadrant Externe:</label>
            <input type="text" name="encadrant_ex" required>
        </div>
        <div>
            <label>Email Encadrant Externe:</label>
            <input type="email" name="email_ex" required>
        </div>
        <div>
            <label>ID Encadrant Interne:</label>
            <input type="number" name="encadrant_in_id" required>
        </div>
        <div>
            <label>Rapport (PDF):</label>
            <input type="file" name="rapport" accept=".pdf">
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <!-- PFE Projects Table -->
    <h3>Liste des PFEs</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID Étudiant</th>
            <th>Titre</th>
            <th>Résumé</th>
            <th>Organisme</th>
            <th>Encadrant Externe</th>
            <th>Email Externe</th>
            <th>ID Encadrant Interne</th>
            <th>Rapport</th>
            <th>Statut Rapport</th>
            <th>Actions</th>
        </tr>
        <?php while ($pfe = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $pfe['id']; ?></td>
            <td><?php echo $pfe['etudiant_id']; ?></td>
            <td><?php echo $pfe['titre']; ?></td>
            <td><?php echo $pfe['resume']; ?></td>
            <td><?php echo $pfe['organisme']; ?></td>
            <td><?php echo $pfe['encadrant_ex']; ?></td>
            <td><?php echo $pfe['email_ex']; ?></td>
            <td><?php echo $pfe['encadrant_in_id']; ?></td>
            <td>
                <?php if ($pfe['rapport']): ?>
                    <a href="../uploads/pfes/<?php echo $pfe['rapport']; ?>" target="_blank">Voir le rapport</a>
                <?php else: ?>
                    Non uploadé
                <?php endif; ?>
            </td>
            <td>
                <?php if ($pfe['rapport_confirme']): ?>
                    Confirmé
                <?php else: ?>
                    <form method="POST" action="">
                        <input type="hidden" name="action" value="confirm_rapport">
                        <input type="hidden" name="id" value="<?php echo $pfe['id']; ?>">
                        <button type="submit">Confirmer</button>
                    </form>
                <?php endif; ?>
            </td>
            <td>
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $pfe['id']; ?>">
                    <input type="hidden" name="current_rapport" value="<?php echo $pfe['rapport']; ?>">
                    <input type="number" name="etudiant_id" value="<?php echo $pfe['etudiant_id']; ?>" required>
                    <input type="text" name="titre" value="<?php echo $pfe['titre']; ?>" required>
                    <textarea name="resume" required><?php echo $pfe['resume']; ?></textarea>
                    <input type="text" name="organisme" value="<?php echo $pfe['organisme']; ?>" required>
                    <input type="text" name="encadrant_ex" value="<?php echo $pfe['encadrant_ex']; ?>" required>
                    <input type="email" name="email_ex" value="<?php echo $pfe['email_ex']; ?>" required>
                    <input type="number" name="encadrant_in_id" value="<?php echo $pfe['encadrant_in_id']; ?>" required>
                    <input type="file" name="rapport" accept=".pdf">
                    <button type="submit">Modifier</button>
                </form>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $pfe['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
