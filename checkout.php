<?php
$page_title = 'Checkout';
include 'pages/header.php';

// Calculate cart total
$cart_total = 0;
$cart_items = [];

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $item) {
        $cart_items[$id] = $item;
        $cart_total += $item['price'] * $item['quantity'];
    }
} else {
    // Redirect to cart if empty
    header('Location: cart.php');
    exit;
}
?>

<!-- Checkout Page -->
<section class="checkout-page">
    <div class="container">
        <div class="section-title">
            <h2>Checkout</h2>
            <p>Complete your order</p>
        </div>
        
        <div class="checkout-grid">
            <!-- Order Form -->
            <div class="checkout-form">
                <h3>Customer Details</h3>
                <form method="POST" action="place_order.php" id="checkout-form">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="customer_name" required placeholder="Enter your full name">
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number *</label>
                        <input type="tel" id="phone" name="phone" required placeholder="Enter your phone number">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email (Optional)</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email">
                    </div>
                    
                    <div class="form-group">
                        <label for="address">Delivery Address *</label>
                        <textarea id="address" name="address" required placeholder="Enter your complete delivery address"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="payment">Payment Method *</label>
                        <select id="payment" name="payment_method">
                            <option value="cod">Cash on Delivery</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="notes">Order Notes (Optional)</label>
                        <textarea id="notes" name="notes" placeholder="Any special instructions?"></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <i class="fas fa-check"></i> Place Order
                    </button>
                </form>
            </div>
            
            <!-- Order Summary -->
            <div class="order-summary">
                <h3>Order Summary</h3>
                
                <div class="order-items">
                    <?php foreach ($cart_items as $item): ?>
                    <div class="order-item">
                        <div>
                            <strong><?php echo htmlspecialchars($item['name']); ?></strong>
                            <p style="font-size: 0.9rem; color: #666;">Qty: <?php echo $item['quantity']; ?></p>
                        </div>
                        <span>₹<?php echo number_format($item['price'] * $item['quantity'], 0); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <div class="order-total">
                    <span>Total</span>
                    <span>₹<?php echo number_format($cart_total, 0); ?></span>
                </div>
                
                <div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 8px;">
                    <p style="font-size: 0.9rem; color: #666; margin-bottom: 10px;">
                        <i class="fas fa-info-circle"></i> Payment will be collected at the time of delivery.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'pages/footer.php'; ?>
