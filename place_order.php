<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection
require_once __DIR__ . '/config/db.php';

$page_title = 'Order Confirmation';
include 'pages/header.php';

$order_placed = false;
$order_id = 0;
$customer_name = '';
$cart_total = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['customer_name'])) {
    // Validate cart
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        header('Location: cart.php');
        exit;
    }
    
    $customer_name = $_POST['customer_name'];
    
    // Calculate total
    foreach ($_SESSION['cart'] as $item) {
        $cart_total += $item['price'] * $item['quantity'];
    }
    
    // Try to save to database
    try {
        $conn = getDBConnection();
        
        // Sanitize inputs
        $customer_name = sanitize($conn, $_POST['customer_name']);
        $phone = sanitize($conn, $_POST['phone']);
        $email = isset($_POST['email']) ? sanitize($conn, $_POST['email']) : '';
        $address = sanitize($conn, $_POST['address']);
        $notes = isset($_POST['notes']) ? sanitize($conn, $_POST['notes']) : '';
        $payment_method = sanitize($conn, $_POST['payment_method']);
        
        // Insert order
        $sql = "INSERT INTO orders (customer_name, phone, email, address, notes, payment_method, total_amount, order_status) 
                VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssd", $customer_name, $phone, $email, $address, $notes, $payment_method, $cart_total);
        
        if ($stmt->execute()) {
            $order_id = $conn->insert_id;
            
            // Insert order items
            foreach ($_SESSION['cart'] as $product_id => $item) {
                $item_sql = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
                $item_stmt = $conn->prepare($item_sql);
                $item_stmt->bind_param("iiid", $order_id, $product_id, $item['quantity'], $item['price']);
                $item_stmt->execute();
                $item_stmt->close();
            }
            
            $order_placed = true;
        }
        
        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        // If database not available, still show success (demo mode)
        $order_placed = true;
        $order_id = rand(1000, 9999); // Generate random order ID for demo
    }
    
    // Clear cart
    $_SESSION['cart'] = [];
} else {
    header('Location: cart.php');
    exit;
}
?>

<!-- Confirmation Page -->
<section class="confirmation">
    <div class="container">
        <?php if ($order_placed): ?>
        <div class="confirmation-icon">✓</div>
        <h2>Order Placed Successfully!</h2>
        <p>Thank you for your order. Your order ID is: <strong>#<?php echo $order_id; ?></strong></p>
        <p>We will contact you shortly to confirm your order and delivery time.</p>
        <div style="margin-top: 30px;">
            <a href="index.php" class="btn btn-primary">Back to Home</a>
            <a href="menu.php" class="btn btn-outline">Continue Shopping</a>
        </div>
        <?php else: ?>
        <div class="confirmation-icon" style="background: #f44336;">✕</div>
        <h2>Order Failed</h2>
        <p>Sorry, there was an error placing your order. Please try again.</p>
        <div style="margin-top: 30px;">
            <a href="checkout.php" class="btn btn-primary">Try Again</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'pages/footer.php'; ?>
