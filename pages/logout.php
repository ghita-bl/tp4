<?php
// logout.php
session_start(); // Start the session
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session
header("Location: ../pages/index.php"); // Redirect to the home page or login page
exit();
?>