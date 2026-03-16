<?php
$page_title = 'Cart';
include 'pages/header.php';

// Calculate cart total
$cart_total = 0;
$cart_items = [];

if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $id => $item) {
        $cart_items[$id] = $item;
        $cart_total += $item['price'] * $item['quantity'];
    }
}
?>

<!-- Cart Page -->
<section class="cart-page">
    <div class="container">
        <div class="section-title">
            <h2>Your Cart</h2>
            <p>Review your items before checkout</p>
        </div>
        
        <?php if (empty($cart_items)): ?>
        <div class="empty-cart">
            <h3>Your cart is empty</h3>
            <p>Looks like you haven't added any sweets yet. Start shopping!</p>
            <a href="menu.php" class="btn btn-primary">Browse Menu</a>
        </div>
        <?php else: ?>
        <div class="cart-table">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $id => $item): ?>
                    <tr>
                        <td>
                            <div class="cart-product">
                                <span class="placeholder-icon" style="font-size: 2rem;">🍰</span>
                                <div>
                                    <h4><?php echo htmlspecialchars($item['name']); ?></h4>
                                </div>
                            </div>
                        </td>
                        <td>₹<?php echo number_format($item['price'], 0); ?></td>
                        <td>
                            <div class="quantity-controls">
                                <button class="quantity-btn" data-id="<?php echo $id; ?>" onclick="updateQuantity(<?php echo $id; ?>, -1)">-</button>
                                <span class="quantity-value"><?php echo $item['quantity']; ?></span>
                                <button class="quantity-btn" data-id="<?php echo $id; ?>" onclick="updateQuantity(<?php echo $id; ?>, 1)">+</button>
                            </div>
                        </td>
                        <td>₹<?php echo number_format($item['price'] * $item['quantity'], 0); ?></td>
                        <td>
                            <button class="remove-btn" onclick="removeItem(<?php echo $id; ?>)">Remove</button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        
        <div class="cart-summary">
            <div class="cart-total">
                Total: <span class="cart-total-amount">₹<?php echo number_format($cart_total, 0); ?></span>
            </div>
            <div class="cart-actions">
                <a href="menu.php" class="btn btn-outline">Continue Shopping</a>
                <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function updateQuantity(productId, change) {
    const row = event.target.closest('tr');
    const quantitySpan = row.querySelector('.quantity-value');
    let quantity = parseInt(quantitySpan.textContent) + change;
    
    if (quantity < 1) {
        removeItem(productId);
        return;
    }
    
    // Update via AJAX
    fetch('update_cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'product_id=' + productId + '&quantity=' + quantity
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function removeItem(productId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch('remove_from_cart.php?id=' + productId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            });
    }
}
</script>

<?php include 'pages/footer.php'; ?>
