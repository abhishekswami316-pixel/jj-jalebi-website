<?php
$page_title = 'Menu';
include 'pages/header.php';

// Get all products from database
$products = [];
try {
    $conn = getDBConnection();
    $products = getResults($conn, "SELECT * FROM products ORDER BY id ASC");
    $conn->close();
} catch (Exception $e) {
    // If database not available, use default products
    $products = [
        ['id' => 1, 'name' => 'Fresh Jalebi', 'description' => 'Crispy, juicy, and soaked in sugar syrup - made fresh daily', 'price' => 150, 'image' => ''],
        ['id' => 2, 'name' => 'Besan Laddu', 'description' => 'Melt in your mouth laddus made with gram flour and ghee', 'price' => 200, 'image' => ''],
        ['id' => 3, 'name' => 'Gulab Jamun', 'description' => 'Soft dough balls soaked in rose-flavored sugar syrup', 'price' => 180, 'image' => ''],
        ['id' => 4, 'name' => 'Rasgulla', 'description' => 'Spongy cottage cheese balls in light sugar syrup', 'price' => 220, 'image' => ''],
        ['id' => 5, 'name' => 'Motichoor Laddu', 'description' => 'Tiny pearl-like laddu with premium quality ingredients', 'price' => 250, 'image' => ''],
        ['id' => 6, 'name' => 'Jalebi Combo Pack', 'description' => 'A combo of fresh jalebi and gulab jamun', 'price' => 300, 'image' => ''],
        ['id' => 7, 'name' => 'Kaju Katli', 'description' => 'Premium cashew fudge with silver foil', 'price' => 400, 'image' => ''],
        ['id' => 8, 'name' => 'Barfi Mix', 'description' => 'Assorted barfis - milk, peda, and coconut', 'price' => 280, 'image' => '']
    ];
}
?>

<!-- Menu Page -->
<section class="menu-page">
    <div class="container">
        <div class="section-title">
            <h2>Our Menu</h2>
            <p>Explore our delicious range of traditional Indian sweets</p>
        </div>
        
        <!-- Menu Filters -->
        <div class="menu-filters">
            <button class="filter-btn active" onclick="filterProducts('all')">All</button>
            <button class="filter-btn" onclick="filterProducts('jalebi')">Jalebi</button>
            <button class="filter-btn" onclick="filterProducts('laddu')">Laddoos</button>
            <button class="filter-btn" onclick="filterProducts('barfi')">Barfi</button>
            <button class="filter-btn" onclick="filterProducts('combo')">Combos</button>
        </div>
        
        <!-- Products Grid -->
        <div class="products-grid">
            <?php if (empty($products)): ?>
                <div style="grid-column: 1 / -1; text-align: center; padding: 40px;">
                    <h3>No products available at the moment.</h3>
                    <p>Please check back later!</p>
                </div>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                <div class="product-card" data-category="<?php 
                    $name = strtolower($product['name']);
                    if (strpos($name, 'jalebi') !== false) echo 'jalebi';
                    elseif (strpos($name, 'laddu') !== false || strpos($name, 'peda') !== false) echo 'laddu';
                    elseif (strpos($name, 'barfi') !== false || strpos($name, 'katli') !== false) echo 'barfi';
                    elseif (strpos($name, 'combo') !== false) echo 'combo';
                    else echo 'other';
                ?>">
                    <div class="product-image">
                        <span class="placeholder-icon">🍰</span>
                        <?php if ($product['image'] && file_exists('assets/images/' . $product['image'])): ?>
                            <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="product-price">₹<?php echo number_format($product['price'], 0); ?></div>
                        <button class="btn btn-primary product-btn add-to-cart-btn" data-id="<?php echo $product['id']; ?>">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<script>
// Filter function for menu page
function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
            setTimeout(() => product.style.opacity = '1', 10);
        } else {
            product.style.opacity = '0';
            setTimeout(() => product.style.display = 'none', 300);
        }
    });
}
</script>

<?php include 'pages/footer.php'; ?>
