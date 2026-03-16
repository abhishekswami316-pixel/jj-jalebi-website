<?php
// Start session if not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    
    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
        $response['success'] = true;
        $response['message'] = 'Item removed from cart';
    }
}

echo json_encode($response);
exit;
