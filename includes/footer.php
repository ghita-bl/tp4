<?php
// Define base URL for the project if not already defined
if (!isset($base_url)) {
    $base_url = '/tp4';
}
?>
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>INPT.EDU</h4>
                <p>Plateforme de gestion des Projets de Fin d'Études de l'Institut National des Postes et Télécommunications</p>
            </div>
            <div class="footer-section">
                <h4>Contact</h4>
                <p><i class="fas fa-envelope"></i> <a href="mailto:pfe@inpt.edu">pfe@inpt.edu</a></p>
                <p><i class="fas fa-phone"></i> +212 5XX-XXXXXX</p>
                <p><i class="fas fa-map-marker-alt"></i> Madinat Al Irfane, Rabat, Maroc</p>
            </div>
            <div class="footer-section">
                <h4>Liens Rapides</h4>
                <ul>
                    <li><a href="<?php echo $base_url; ?>/pages/index.php">Accueil</a></li>
                    <li><a href="<?php echo $base_url; ?>/pages/login.php">Connexion</a></li>
                    <li><a href="<?php echo $base_url; ?>/search.php">Recherche</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?= date('Y') ?> INPT.EDU - Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>