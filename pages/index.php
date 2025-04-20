<?php
include '../includes/header.php';
include '../includes/nav.php';
?>

<main>
    <?php
    if (isset($_SESSION['profil'])) {
        // Display welcome message with name if available
        if (isset($_SESSION['nom']) && isset($_SESSION['prenom'])) {
            echo '<div class="welcome-message">Bienvenue, ' . htmlspecialchars($_SESSION['prenom']) . ' ' . htmlspecialchars($_SESSION['nom']) . '</div>';
        }
    }
    ?>
    
    <section class="hero-section">
        <div class="hero-content">
            <h1>Bienvenue à INPT.EDU</h1>
            <p class="lead">La plateforme de gestion des Projets de Fin d'Études de l'Institut National des Postes et Télécommunications</p>
            <div class="hero-buttons">
                <a href="login.php" class="btn btn-primary">Se connecter</a>
                <a href="#about" class="btn btn-secondary">En savoir plus</a>
            </div>
        </div>
    </section>
    
    <section id="about">
        <h2>Projet de Fin d'Études (PFE)</h2>
        <div class="section-intro">
            <p>
                Le <strong>Projet de Fin d'Études (PFE)</strong> est une étape essentielle dans la formation des ingénieurs de l'INPT.
                Il permet aux étudiants de mettre en pratique les connaissances théoriques acquises durant leur cursus et de se confronter
                aux réalités du monde professionnel.
            </p>
        </div>

        <div class="info-cards">
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3>Objectifs du PFE</h3>
                <ul>
                    <li>Appliquer les compétences techniques et scientifiques acquises pendant la formation.</li>
                    <li>Développer des solutions innovantes à des problèmes réels.</li>
                    <li>Améliorer les compétences en gestion de projet, travail d'équipe et communication.</li>
                    <li>Préparer les étudiants à intégrer le marché du travail avec une expérience concrète.</li>
                </ul>
            </div>
            
            <div class="info-card">
                <div class="info-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <h3>Durée</h3>
                <p>
                    Le PFE dure généralement <strong>6 mois</strong>, avec une phase de préparation, une phase de réalisation,
                    et une phase de rédaction du rapport final.
                </p>
            </div>
        </div>

        <h3>Procédure de Déroulement</h3>
        <div class="process-timeline">
            <div class="process-step">
                <div class="step-number">1</div>
                <div class="step-content">
                    <h4>Choix du sujet</h4>
                    <p>L'étudiant propose un sujet en accord avec son encadrant académique.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-number">2</div>
                <div class="step-content">
                    <h4>Planification</h4>
                    <p>Un plan de travail détaillé est établi, incluant les objectifs, les livrables et les échéances.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-number">3</div>
                <div class="step-content">
                    <h4>Réalisation</h4>
                    <p>L'étudiant travaille sur le projet, en collaboration avec son encadrant et éventuellement un partenaire industriel.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-number">4</div>
                <div class="step-content">
                    <h4>Rédaction du rapport</h4>
                    <p>Un rapport détaillé est rédigé, décrivant le travail réalisé, les résultats obtenus et les conclusions.</p>
                </div>
            </div>
            
            <div class="process-step">
                <div class="step-number">5</div>
                <div class="step-content">
                    <h4>Soutenance</h4>
                    <p>Le projet est présenté devant un jury composé d'enseignants et de professionnels.</p>
                </div>
            </div>
        </div>

        <h3>Avantages pour les Étudiants</h3>
        <div class="advantages-grid">
            <div class="advantage-item">
                <i class="fas fa-laptop-code"></i>
                <h4>Expérience pratique</h4>
                <p>Acquérir une expérience pratique dans un domaine spécifique.</p>
            </div>
            
            <div class="advantage-item">
                <i class="fas fa-network-wired"></i>
                <h4>Réseau professionnel</h4>
                <p>Développer un réseau professionnel avec des encadrants et des partenaires industriels.</p>
            </div>
            
            <div class="advantage-item">
                <i class="fas fa-puzzle-piece"></i>
                <h4>Résolution de problèmes</h4>
                <p>Améliorer les compétences en résolution de problèmes et en pensée critique.</p>
            </div>
            
            <div class="advantage-item">
                <i class="fas fa-file-alt"></i>
                <h4>CV valorisé</h4>
                <p>Valoriser son CV avec un projet concret et significatif.</p>
            </div>
        </div>

        <h3>Exemples de Projets Réussis</h3>
        <div class="card-grid">
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h4 class="card-title">Développement d'une application de gestion des ressources humaines</h4>
                <p>Une solution cloud pour les PME permettant d'optimiser la gestion du personnel.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h4 class="card-title">Conception d'un système de surveillance intelligent</h4>
                <p>Utilisation de l'IA pour la détection d'anomalies dans les systèmes de sécurité.</p>
            </div>
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-industry"></i>
                </div>
                <h4 class="card-title">Optimisation des processus industriels</h4>
                <p>Réduction des coûts et amélioration de l'efficacité dans les chaînes de production.</p>
            </div>
        </div>
    </section>
</main>

<?php
include '../includes/footer.php';
?>