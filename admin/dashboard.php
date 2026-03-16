<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/../config/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php');
    exit;
}

$conn = getDBConnection();

// Get statistics
$products_count = getSingleRow($conn, "SELECT COUNT(*) as count FROM products");
$orders_count = getSingleRow($conn, "SELECT COUNT(*) as count FROM orders");
$pending_orders = getSingleRow($conn, "SELECT COUNT(*) as count FROM orders WHERE order_status = 'Pending'");
$total_revenue = getSingleRow($conn, "SELECT SUM(total_amount) as total FROM orders");

$conn->close();

$page_title = 'Dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - JJ Jalebi Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="css/admin.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>JJ Jalebi</h2>
            <p>Admin Panel</p>
        </div>
        
        <nav class="sidebar-nav">
            <a href="dashboard.php" class="active">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="products.php">
                <i class="fas fa-box"></i> Products
            </a>
            <a href="add_product.php">
                <i class="fas fa-plus"></i> Add Product
            </a>
            <a href="orders.php">
                <i class="fas fa-shopping-cart"></i> Orders
            </a>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="admin-header">
            <h1>Dashboard</h1>
            <div class="admin-info">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></span>
            </div>
        </header>

        <div class="dashboard-content">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon" style="background: #FF6F00;">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $products_count['count']; ?></h3>
                        <p>Total Products</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #2196F3;">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $orders_count['count']; ?></h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #FFC107;">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo $pending_orders['count']; ?></h3>
                        <p>Pending Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background: #4CAF50;">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3>₹<?php echo number_format($total_revenue['total'] ?? 0, 0); ?></h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2>Quick Actions</h2>
                <div class="actions-grid">
                    <a href="add_product.php" class="action-card">
                        <i class="fas fa-plus"></i>
                        <span>Add New Product</span>
                    </a>
                    <a href="orders.php" class="action-card">
                        <i class="fas fa-list"></i>
                        <span>View All Orders</span>
                    </a>
                    <a href="../index.php" class="action-card">
                        <i class="fas fa-globe"></i>
                        <span>View Website</span>
                    </a>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
