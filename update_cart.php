<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$response = ['success' => false, 'message' => '', 'total' => 0, 'cart_count' => 0, 'remove' => false];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = intval($_POST['product_id']);
    $quantity = intval($_POST['quantity']);
    
    if (isset($_SESSION['cart'][$product_id])) {
        if ($quantity <= 0) {
            // Remove item from cart
            unset($_SESSION['cart'][$product_id]);
            $response['remove'] = true;
            $response['message'] = 'Item removed from cart';
        } else {
            // Update quantity
            $_SESSION['cart'][$product_id]['quantity'] = $quantity;
            $response['message'] = 'Quantity updated';
        }
        
        // Calculate totals
        $cart_total = 0;
        foreach ($_SESSION['cart'] as $item) {
            $cart_total += $item['price'] * $item['quantity'];
        }
        
        $cart_count = array_sum(array_column($_SESSION['cart'], 'quantity'));
        
        $response['success'] = true;
        $response['total'] = number_format($cart_total, 2);
        $response['cart_count'] = $cart_count;
    }
}

echo json_encode($response);
exit;
