<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../config/db.php';

// Get cart count
$cart_count = 0;
if (isset($_SESSION['cart'])) {
    $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
}

$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="JJ Jalebi - Fresh Indian sweets, jalebi, laddoos, and traditional mithai. Order online for fastest delivery.">
    <meta name="keywords" content="jalebi, sweets, Indian mithai, laddoo, gulab jamun, rasgulla, kaju katli">
    <meta name="author" content="JJ Jalebi">
    <meta property="og:title" content="JJ Jalebi - Fresh Indian Sweets">
    <meta property="og:description" content="Crispy. Juicy. Pure Happiness.">
    <title><?php echo isset($page_title) ? $page_title . ' - JJ Jalebi' : 'JJ Jalebi - Fresh Indian Sweets'; ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="container">
            <nav class="navbar">
                <a href="index.php" class="logo">JJ <span>Jalebi</span></a>
                
                <ul class="nav-links">
                    <li><a href="index.php" class="<?php echo $current_page == 'index' ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="about.php" class="<?php echo $current_page == 'about' ? 'active' : ''; ?>">About</a></li>
                    <li><a href="menu.php" class="<?php echo $current_page == 'menu' ? 'active' : ''; ?>">Menu</a></li>
                    <li>
                        <a href="cart.php" class="cart-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if ($cart_count > 0): ?>
                                <span class="cart-count"><?php echo $cart_count; ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
                
                <div class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </div>
            </nav>
        </div>
    </header>

    <!-- WhatsApp Float -->
    <a href="https://wa.me/919999999999" class="whatsapp-float" target="_blank" title="Order via WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <main>
