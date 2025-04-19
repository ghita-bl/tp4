<?php
session_start();
include '../includes/db.php';
include '../includes/header.php';

// Get student ID from session
$etudiant_id = $_SESSION['id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    $sql = "INSERT INTO pfes (etudiant_id, titre, resume, organisme, encadrant_ex, email_ex, encadrant_in_id, rapport) 
            VALUES ('$etudiant_id', '$titre', '$resume', '$organisme', '$encadrant_ex', '$email_ex', '$encadrant_in_id', '$rapport')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['msg'] = "PFE créé avec succès";
        header("Location: ../pages/etudiant_portal.php");
        exit();
    } else {
        $error = "Erreur lors de la création: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Créer un nouveau PFE</title>
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
        <h1>Créer un nouveau PFE</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['msg'])): ?>
            <div class="success"><?php echo $_SESSION['msg']; unset($_SESSION['msg']); ?></div>
        <?php endif; ?>

        <form method="POST" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label>Titre:</label>
                <input type="text" name="titre" required>
            </div>
            
            <div class="form-group">
                <label>Résumé:</label>
                <textarea name="resume" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Organisme:</label>
                <input type="text" name="organisme" required>
            </div>
            
            <div class="form-group">
                <label>Encadrant Externe:</label>
                <input type="text" name="encadrant_ex" required>
            </div>
            
            <div class="form-group">
                <label>Email Encadrant Externe:</label>
                <input type="email" name="email_ex" required>
            </div>
            
            <div class="form-group">
                <label>ID Encadrant Interne:</label>
                <input type="number" name="encadrant_in_id" required>
            </div>
            
            <div class="form-group">
                <label>Rapport (PDF):</label>
                <input type="file" name="rapport" accept=".pdf">
                <small>Vous pouvez uploader le rapport plus tard</small>
            </div>
            
            <button type="submit" class="btn btn-primary">Créer le PFE</button>
            <a href="../pages/etudiant_portal.php" class="btn">Annuler</a>
        </form>
    </div>
</body>
</html>
<?php include '../includes/footer.php'; ?>
