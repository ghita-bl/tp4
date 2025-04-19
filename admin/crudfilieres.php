<?php
require_once '../includes/db.php';
require("../includes/header.php");
// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $nom = $_POST['nom'];
                $dept_id = $_POST['dept_id'];
                $coord_id = $_POST['coord_id'];
                $sql = "INSERT INTO filieres (nom, dept_id, coord_id) VALUES ('$nom', '$dept_id', '$coord_id')";
                mysqli_query($conn, $sql);
                break;

            case 'update':
                $id = $_POST['id'];
                $nom = $_POST['nom'];
                $dept_id = $_POST['dept_id'];
                $coord_id = $_POST['coord_id'];
                $sql = "UPDATE filieres SET nom = '$nom', dept_id = '$dept_id', coord_id = '$coord_id' WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;

            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM filieres WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;
        }
        header("Location: crudfilieres.php");
        exit();
    }
}

// Fetch all majors
$sql = "SELECT * FROM filieres ORDER BY nom";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <title>Gestion des Filières</title>
</head>
<body>
    <h2>Gestion des Filières</h2>

    <!-- Add Major Form -->
    <h3>Ajouter une Filière</h3>
    <form method="POST" action="">
        <input type="hidden" name="action" value="add">
        <div>
            <label>Nom de la Filière:</label>
            <input type="text" name="nom" required>
        </div>
        <div>
            <label>ID du Département:</label>
            <input type="number" name="dept_id" required>
        </div>
        <div>
            <label>ID du Coordinateur:</label>
            <input type="number" name="coord_id" required>
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Majors Table -->
    <h3>Liste des Filières</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>ID Département</th>
            <th>ID Coordinateur</th>
            <th>Actions</th>
        </tr>
        <?php while ($filiere = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $filiere['id']; ?></td>
            <td><?php echo $filiere['nom']; ?></td>
            <td><?php echo $filiere['dept_id']; ?></td>
            <td><?php echo $filiere['coord_id']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $filiere['id']; ?>">
                    <input type="text" name="nom" value="<?php echo $filiere['nom']; ?>" required>
                    <input type="number" name="dept_id" value="<?php echo $filiere['dept_id']; ?>" required>
                    <input type="number" name="coord_id" value="<?php echo $filiere['coord_id']; ?>" required>
                    <button type="submit">Modifier</button>
                </form>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $filiere['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
