<?php
require_once '../includes/db.php';
require("../includes/header.php");
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $dept_id = $_POST['dept_id'];
                $sql = "INSERT INTO enseignants (nom, prenom, email, dept_id) VALUES ('$nom', '$prenom', '$email', '$dept_id')";
                mysqli_query($conn, $sql);
                break;

            case 'update':
                $id = $_POST['id'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $dept_id = $_POST['dept_id'];
                $sql = "UPDATE enseignants SET nom = '$nom', prenom = '$prenom', email = '$email', dept_id = '$dept_id' WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;

            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM enseignants WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;
        }
        header("Location: ../includes/header.php");
        exit();
    }
}

// Fetch all teachers
$sql = "SELECT * FROM enseignants ORDER BY nom";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <title>Gestion des Enseignants</title>
</head>
<body>
    <h2>Gestion des Enseignants</h2>

    <!-- Add Teacher Form -->
    <h3>Ajouter un Enseignant</h3>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <div>
            <label>Nom:</label>
            <input type="text" name="nom" required>
        </div>
        <div>
            <label>Prénom:</label>
            <input type="text" name="prenom" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>ID du Département:</label>
            <input type="number" name="dept_id" required>
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Teachers Table -->
    <h3>Liste des Enseignants</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>ID Département</th>
            <th>Actions</th>
        </tr>
        <?php while ($enseignant = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $enseignant['id']; ?></td>
            <td><?php echo $enseignant['nom']; ?></td>
            <td><?php echo $enseignant['prenom']; ?></td>
            <td><?php echo $enseignant['email']; ?></td>
            <td><?php echo $enseignant['dept_id']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $enseignant['id']; ?>">
                    <input type="text" name="nom" value="<?php echo $enseignant['nom']; ?>" required>
                    <input type="text" name="prenom" value="<?php echo $enseignant['prenom']; ?>" required>
                    <input type="email" name="email" value="<?php echo $enseignant['email']; ?>" required>
                    <input type="number" name="dept_id" value="<?php echo $enseignant['dept_id']; ?>" required>
                    <button type="submit">Modifier</button>
                </form>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $enseignant['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>