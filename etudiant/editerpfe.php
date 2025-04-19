<?php
session_start();
header("Location: modifierpfe.php" . (isset($_GET['id']) ? "?id=" . $_GET['id'] : ""));
exit();
?>
