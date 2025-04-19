<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Get student ID from session
$etudiant_id = $_SESSION['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
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

    $sql = "UPDATE pfes SET 
            titre = '$titre',
            resume = '$resume',
            organisme = '$organisme',
            encadrant_ex = '$encadrant_ex',
            email_ex = '$email_ex',
            encadrant_in_id = '$encadrant_in_id',
            rapport = '$rapport'
            WHERE id = '$id' AND etudiant_id = '$etudiant_id'";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['msg'] = "PFE modifié avec succès";
        header("Location: ../pages/etudiant_portal.php");
        exit();
    } else {
        $error = "Erreur lors de la mise à jour: " . mysqli_error($conn);
    }
}

// Get PFE ID from URL
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Fetch PFE details
$sql = "SELECT * FROM pfes WHERE id = '$id' AND etudiant_id = '$etudiant_id'";
$result = mysqli_query($conn, $sql);
$pfe = mysqli_fetch_assoc($result);

if (!$pfe) {
    header("Location: ../pages/etudiant_portal.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Modifier PFE</title>
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier votre PFE</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="success"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $pfe['id']; ?>">
            <input type="hidden" name="current_rapport" value="<?php echo $pfe['rapport']; ?>">
            
            <div class="form-group">
                <label>Titre:</label>
                <input type="text" name="titre" value="<?php echo htmlspecialchars($pfe['titre']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Résumé:</label>
                <textarea name="resume" required><?php echo htmlspecialchars($pfe['resume']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Organisme:</label>
                <input type="text" name="organisme" value="<?php echo htmlspecialchars($pfe['organisme']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Encadrant Externe:</label>
                <input type="text" name="encadrant_ex" value="<?php echo htmlspecialchars($pfe['encadrant_ex']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Email Encadrant Externe:</label>
                <input type="email" name="email_ex" value="<?php echo htmlspecialchars($pfe['email_ex']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>ID Encadrant Interne:</label>
                <input type="number" name="encadrant_in_id" value="<?php echo $pfe['encadrant_in_id']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Rapport (PDF):</label>
                <?php if ($pfe['rapport']): ?>
                    <p>
                        <a href="../uploads/pfes/<?php echo $pfe['rapport']; ?>" target="_blank" class="btn btn-primary">
                            Voir le rapport actuel
                        </a>
                    </p>
                <?php endif; ?>
                <input type="file" name="rapport" accept=".pdf">
                <small>Uploader un nouveau rapport pour remplacer l'ancien</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="../pages/etudiant_portal.php" class="btn">Annuler</a>
        </form>
    </div>
</body>
</html>
<?php include '../includes/footer.php'; ?>
