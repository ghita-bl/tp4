<?php
// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define base URL for the project
$base_url = '/tp4';

// Function to get the current page URL
function getCurrentPageURL() {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    return $protocol . $domainName . $_SERVER['REQUEST_URI'];
}

// Function to determine the relative path to the root
function getRelativePath() {
    $current_path = $_SERVER['PHP_SELF'];
    $path_parts = explode('/', $current_path);
    
    // Remove the last element (the current file)
    array_pop($path_parts);
    
    // Count how many directories deep we are
    $depth = count($path_parts) - 1; // -1 because the first element is empty
    
    // Build the relative path
    $relative_path = '';
    for ($i = 0; $i < $depth; $i++) {
        $relative_path .= '../';
    }
    
    return $relative_path;
}

// Get the relative path to the root
$relative_path = getRelativePath();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INPT.EDU</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>/style/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
<header>
  <img src="<?php echo $base_url; ?>/images/logo.jpg" alt="Logo INPT" />
</header>

    