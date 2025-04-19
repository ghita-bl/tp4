<?php
require_once '../includes/db.php';
require("../includes/header.php");

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $nom = $_POST['nom'];
                $chef_id = $_POST['chef_id'];
                $sql = "INSERT INTO departements (nom, chef_id) VALUES ('$nom', '$chef_id')";
                mysqli_query($conn, $sql);
                break;

            case 'update':
                $id = $_POST['id'];
                $nom = $_POST['nom'];
                $chef_id = $_POST['chef_id'];
                $sql = "UPDATE departements SET nom = '$nom', chef_id = '$chef_id' WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;

            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM departements WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;
        }
        header("Location: ../includes/header.php");
        exit();
    }
}

// Fetch all departments
$sql = "SELECT * FROM departements ORDER BY nom";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <title>Gestion des Départements</title>
</head>
<body>
    <h2>Gestion des Départements</h2>

    <!-- Add Department Form -->
    <h3>Ajouter un Département</h3>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <div>
            <label>Nom du Département:</label>
            <input type="text" name="nom" required>
        </div>
        <div>
            <label>ID du Chef:</label>
            <input type="number" name="chef_id" required>
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Departments Table -->
    <h3>Liste des Départements</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>ID du Chef</th>
            <th>Actions</th>
        </tr>
        <?php while ($departement = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $departement['id']; ?></td>
            <td><?php echo $departement['nom']; ?></td>
            <td><?php echo $departement['chef_id']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $departement['id']; ?>">
                    <input type="text" name="nom" value="<?php echo $departement['nom']; ?>" required>
                    <input type="number" name="chef_id" value="<?php echo $departement['chef_id']; ?>" required>
                    <button type="submit">Modifier</button>
                </form>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $departement['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
