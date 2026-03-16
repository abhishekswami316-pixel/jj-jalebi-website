<?php
$page_title = 'Home';
include 'pages/header.php';

// Get featured products from database
$featured_products = [];
try {
    $conn = getDBConnection();
    $featured_products = getResults($conn, "SELECT * FROM products LIMIT 4");
    $conn->close();
} catch (Exception $e) {
    // If database not available, use default products
    $featured_products = [
        ['id' => 1, 'name' => 'Fresh Jalebi', 'description' => 'Crispy, juicy, and soaked in sugar syrup - made fresh daily', 'price' => 150, 'image' => ''],
        ['id' => 2, 'name' => 'Mawa Jalebi', 'description' => 'Our signature dark, rich, and juicy jalebi made with mawa - a Vasai favorite', 'price' => 200, 'image' => ''],
        ['id' => 3, 'name' => 'Malpua with Rabdi', 'description' => 'Deep-fried sweet pancakes served with thick, creamy rabdi', 'price' => 180, 'image' => ''],
        ['id' => 4, 'name' => 'Gulab Jamun', 'description' => 'Soft dough balls soaked in rose-flavored sugar syrup', 'price' => 180, 'image' => '']
    ];
}
?>

<!-- Hero Section -->
<section class="hero">
    <span class="decoration decoration-1">🍯</span>
    <span class="decoration decoration-2">🧁</span>
    <span class="decoration decoration-3">🍬</span>
    
    <div class="hero-content">
        <h1>JJ Jalebi</h1>
        <p class="tagline">Crispy. Juicy. Pure Happiness.</p>
        <div class="hero-buttons">
            <a href="menu.php" class="btn btn-primary">Order Now</a>
            <a href="menu.php" class="btn btn-outline" style="border-color: white; color: white;">View Menu</a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="section featured">
    <div class="container">
        <div class="section-title">
            <h2>Our Featured Sweets</h2>
            <p>Discover our most loved traditional sweets, made fresh daily with premium ingredients</p>
        </div>
        
        <div class="products-grid">
            <?php foreach ($featured_products as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <span class="placeholder-icon">🍰</span>
                    <?php if ($product['image'] && file_exists('assets/images/' . $product['image'])): ?>
                        <img src="assets/images/<?php echo $product['image']; ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <?php endif; ?>
                    <span class="product-badge">Fresh</span>
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
        </div>
        
        <div style="text-align: center; margin-top: 40px;">
            <a href="menu.php" class="btn btn-secondary">View Full Menu</a>
        </div>
    </div>
</section>

<!-- About Preview -->
<section class="section about">
    <div class="container">
        <div class="about-content">
            <div class="about-image">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=600" alt="JJ Jalebi Shop">
            </div>
            <div class="about-text">
                <h3>The Sweet Tradition of JJ Jalebi</h3>
                <p>Welcome to JJ Jalebi, where tradition meets taste in the heart of Vasai. For generations, we have been crafting the finest Indian sweets with love and dedication. Our signature Mawa Jalebis and Malpuas are made fresh every morning, using traditional recipes passed down through generations.</p>
                <p>We take pride in using only the finest ingredients - pure ghee, fresh milk, and premium nuts. Every piece is crafted with meticulous attention to detail to ensure the perfect taste and texture.</p>
                
                <div class="about-features">
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>100% Pure Ghee</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Fresh Daily</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Premium Quality</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-icon">✓</div>
                        <span>Traditional Recipe</span>
                    </div>
                </div>
                
                <a href="about.php" class="btn btn-primary" style="margin-top: 20px;">Read Our Story</a>
            </div>
        </div>
    </div>
</section>

<!-- Gallery Preview -->
<section class="section gallery">
    <div class="container">
        <div class="section-title">
            <h2>Our Creations</h2>
            <p>A glimpse into the art of traditional sweet making</p>
        </div>
        
        <div class="gallery-grid">
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1599638189898-8689ff03a1e0?w=400" alt="Fresh Jalebi">
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400" alt="Laddoos">
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1623653387945-2fd25214f8fc?w=400" alt="Barfi">
            </div>
            <div class="gallery-item">
                <img src="https://images.unsplash.com/photo-1605197136312-dba8b5595f5d?w=400" alt="Sweets Display">
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<section class="section testimonials">
    <div class="container">
        <div class="section-title">
            <h2>What Our Customers Say</h2>
            <p>Reviews from our beloved customers</p>
        </div>
        
        <div class="testimonial-slider">
            <div class="testimonial-item">
                <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Priya Sharma">
                <p class="testimonial-text">"The best jalebi I've ever had! So crispy and juicy. My family loves all their sweets. Will definitely order again!"</p>
                <p class="testimonial-author">- Priya Sharma</p>
            </div>
            
            <div class="testimonial-item">
                <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Rajesh Kumar">
                <p class="testimonial-text">"Amazing quality and taste. The gulab jamuns are melt in your mouth. JJ Jalebi never disappoints!"</p>
                <p class="testimonial-author">- Rajesh Kumar</p>
            </div>
            
            <div class="testimonial-item">
                <img src="https://randomuser.me/api/portraits/women/65.jpg" alt="Anita Patel">
                <p class="testimonial-text">"Their kaju katli is exceptional! Perfect texture and taste. Great for gifting during festivals."</p>
                <p class="testimonial-author">- Anita Patel</p>
            </div>
            
            <div class="testimonial-dots">
                <span class="dot active"></span>
                <span class="dot"></span>
                <span class="dot"></span>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="section cta">
    <div class="container">
        <div class="cta-content">
            <h2>Ready to Satisfy Your Sweet Tooth?</h2>
            <p>Order now and experience the authentic taste of traditional Indian sweets. Fresh delivery guaranteed!</p>
            <a href="menu.php" class="btn btn-primary">Browse Menu</a>
        </div>
    </div>
</section>

<?php include 'pages/footer.php'; ?>
