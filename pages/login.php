<?php
include '../includes/header.php';
?>

<h2>Connexion</h2>
<form action="login_verif.php" method="post">
    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>
    
    <label for="password">Mot de passe:</label><br>
    <input type="password" id="password" name="password" required><br><br>
    
    <input type="submit" value="Se connecter">
    <?php
        if(isset($_GET["msg"]))  echo "<h3>",$_GET['msg'],"</h3>";
        ?>
</form>


<?php
include '../includes/footer.php';
?>