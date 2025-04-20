<?php
include '../includes/header.php';
include '../includes/nav.php';
?>

<main>
    <div class="login-container">
        <div class="login-header">
            <i class="fas fa-user-circle login-icon"></i>
            <h2 class="login-title">Connexion</h2>
            <p class="login-subtitle">Accédez à votre espace personnel</p>
        </div>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                if ($_GET['error'] == 'invalid') {
                    echo "Email ou mot de passe incorrect.";
                } else {
                    echo "Une erreur s'est produite. Veuillez réessayer.";
                }
                ?>
            </div>
        <?php endif; ?>
        
        <form action="login_verif.php" method="post" class="login-form">
            <div class="form-group">
                <label for="email" class="form-label">Email</label>
                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Entrez votre email" required>
                </div>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                </div>
            </div>
            
            <div class="form-group form-check">
                <input type="checkbox" id="remember" name="remember" class="form-check-input">
                <label for="remember" class="form-check-label">Se souvenir de moi</label>
            </div>
            
            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
            </div>
            
            <div class="login-footer">
                <p>Vous avez oublié votre mot de passe ? <a href="#">Réinitialiser</a></p>
            </div>
        </form>
    </div>
</main>

<?php
include '../includes/footer.php';
?>