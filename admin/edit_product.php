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

// Get product ID
$product_id = intval($_GET['id'] ?? 0);

if ($product_id <= 0) {
    header('Location: products.php');
    exit;
}

$conn = getDBConnection();
$product = getSingleRow($conn, "SELECT * FROM products WHERE id = ?", [$product_id]);
$conn->close();

if (!$product) {
    header('Location: products.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    
    if ($name && $price > 0) {
        $conn = getDBConnection();
        $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssdi", $name, $description, $price, $product_id);
        
        if ($stmt->execute()) {
            $message = 'Product updated successfully!';
            $product['name'] = $name;
            $product['description'] = $description;
            $product['price'] = $price;
        } else {
            $error = 'Error updating product. Please try again.';
        }
        
        $stmt->close();
        $conn->close();
    } else {
        $error = 'Please fill in all required fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - JJ Jalebi Admin</title>
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
            <a href="dashboard.php">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="products.php" class="active">
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
        <div class="page-header">
            <h1>Edit Product</h1>
        </div>

        <div class="form-container">
            <?php if ($error): ?>
            <div style="background: #ffebee; color: #c62828; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>
            
            <?php if ($message): ?>
            <div style="background: #e8f5e9; color: #2e7d32; padding: 12px; border-radius: 8px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label for="name">Product Name *</label>
                    <input type="text" id="name" name="name" required value="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </div>
                
                <div class="form-group">
                    <label for="price">Price (₹) *</label>
                    <input type="number" id="price" name="price" required min="1" step="0.01" value="<?php echo $product['price']; ?>">
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update Product
                </button>
                <a href="products.php" class="btn-submit" style="background: #666; margin-left: 10px; text-decoration: none; display: inline-block;">
                    Cancel
                </a>
            </form>
        </div>
    </main>
</body>
</html>
