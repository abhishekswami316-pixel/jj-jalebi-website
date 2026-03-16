<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/config/db.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'cart_count' => 0];

// Default products (fallback if database not available)
$default_products = [
    1 => ['id' => 1, 'name' => 'Fresh Jalebi', 'price' => 150],
    2 => ['id' => 2, 'name' => 'Besan Laddu', 'price' => 200],
    3 => ['id' => 3, 'name' => 'Gulab Jamun', 'price' => 180],
    4 => ['id' => 4, 'name' => 'Rasgulla', 'price' => 220],
    5 => ['id' => 5, 'name' => 'Motichoor Laddu', 'price' => 250],
    6 => ['id' => 6, 'name' => 'Jalebi Combo Pack', 'price' => 300],
    7 => ['id' => 7, 'name' => 'Kaju Katli', 'price' => 400],
    8 => ['id' => 8, 'name' => 'Barfi Mix', 'price' => 280]
];

// Get product ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($product_id > 0) {
    $product = null;
    
    // Try to get from database first
    try {
        $conn = getDBConnection();
        $product = getSingleRow($conn, "SELECT * FROM products WHERE id = ?", [$product_id]);
        $conn->close();
    } catch (Exception $e) {
        // Use default products
    }
    
    // Fallback to default products
    if (!$product && isset($default_products[$product_id])) {
        $product = $default_products[$product_id];
    }
    
    if ($product) {
        // Initialize cart if not exists
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        
        // Check if product already in cart
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += 1;
        } else {
            $_SESSION['cart'][$product_id] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => 1
            ];
        }
        
        // Calculate cart count
        $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
        
        $response['success'] = true;
        $response['message'] = $product['name'] . ' added to cart!';
        $response['cart_count'] = $cart_count;
    } else {
        $response['message'] = 'Product not found!';
    }
} else {
    $response['message'] = 'Invalid product!';
}

echo json_encode($response);
exit;
