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
                $tel = $_POST['tel'];
                $promotion = $_POST['promotion'];
                $fil_id = $_POST['fil_id'];
                $sql = "INSERT INTO etudiants (nom, prenom, email, tel, promotion, fil_id) 
                        VALUES ('$nom', '$prenom', '$email', '$tel', '$promotion', '$fil_id')";
                mysqli_query($conn, $sql);
                break;

            case 'update':
                $id = $_POST['id'];
                $nom = $_POST['nom'];
                $prenom = $_POST['prenom'];
                $email = $_POST['email'];
                $tel = $_POST['tel'];
                $promotion = $_POST['promotion'];
                $fil_id = $_POST['fil_id'];
                $sql = "UPDATE etudiants SET nom = '$nom', prenom = '$prenom', email = '$email', 
                        tel = '$tel', promotion = '$promotion', fil_id = '$fil_id' WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;

            case 'delete':
                $id = $_POST['id'];
                $sql = "DELETE FROM etudiants WHERE id = '$id'";
                mysqli_query($conn, $sql);
                break;
        }
        header("Location: crudetudiants.php");
        exit();
    }
}

// Fetch all students
$sql = "SELECT * FROM etudiants ORDER BY nom";
$result = mysqli_query($conn, $sql);
?>

<html>
<head>
    <title>Gestion des Étudiants</title>
</head>
<body>
    <h2>Gestion des Étudiants</h2>

    <!-- Add Student Form -->
    <h3>Ajouter un Étudiant</h3>
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
            <label>Téléphone:</label>
            <input type="tel" name="tel" required>
        </div>
        <div>
            <label>Promotion:</label>
            <input type="text" name="promotion" required>
        </div>
        <div>
            <label>ID de la Filière:</label>
            <input type="number" name="fil_id" required>
        </div>
        <button type="submit">Ajouter</button>
    </form>

    <!-- Students Table -->
    <h3>Liste des Étudiants</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Promotion</th>
            <th>ID Filière</th>
            <th>Actions</th>
        </tr>
        <?php while ($etudiant = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $etudiant['id']; ?></td>
            <td><?php echo $etudiant['nom']; ?></td>
            <td><?php echo $etudiant['prenom']; ?></td>
            <td><?php echo $etudiant['email']; ?></td>
            <td><?php echo $etudiant['tel']; ?></td>
            <td><?php echo $etudiant['promotion']; ?></td>
            <td><?php echo $etudiant['fil_id']; ?></td>
            <td>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="id" value="<?php echo $etudiant['id']; ?>">
                    <input type="text" name="nom" value="<?php echo $etudiant['nom']; ?>" required>
                    <input type="text" name="prenom" value="<?php echo $etudiant['prenom']; ?>" required>
                    <input type="email" name="email" value="<?php echo $etudiant['email']; ?>" required>
                    <input type="tel" name="tel" value="<?php echo $etudiant['tel']; ?>" required>
                    <input type="text" name="promotion" value="<?php echo $etudiant['promotion']; ?>" required>
                    <input type="number" name="fil_id" value="<?php echo $etudiant['fil_id']; ?>" required>
                    <button type="submit">Modifier</button>
                </form>
                <form method="POST" action="">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?php echo $etudiant['id']; ?>">
                    <button type="submit">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
