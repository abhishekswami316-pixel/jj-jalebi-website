/* JJ Jalebi - Main JavaScript File */

// Wait for DOM to load
document.addEventListener('DOMContentLoaded', function() {
    initNavbar();
    initMobileMenu();
    initTestimonialSlider();
    initScrollEffects();
    initAnimations();
    initQuantityControls();
    initFormValidation();
    initAddToCart();
});

// Sticky Navbar
function initNavbar() {
    const header = document.querySelector('.header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }
}

// Mobile Menu Toggle
function initMobileMenu() {
    const menuBtn = document.querySelector('.mobile-menu-btn');
    const navLinks = document.querySelector('.nav-links');
    
    if (menuBtn && navLinks) {
        menuBtn.addEventListener('click', function() {
            navLinks.classList.toggle('active');
            const icon = menuBtn.querySelector('i');
            if (navLinks.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
    }
}

// Testimonial Slider
function initTestimonialSlider() {
    const slider = document.querySelector('.testimonial-slider');
    if (!slider) return;
    
    const items = slider.querySelectorAll('.testimonial-item');
    const dots = slider.querySelectorAll('.dot');
    
    if (items.length === 0) return;
    
    let currentSlide = 0;
    items.forEach((item, index) => {
        if (index !== 0) item.style.display = 'none';
    });
    
    function showSlide(index) {
        items.forEach(item => item.style.display = 'none');
        dots.forEach(dot => dot.classList.remove('active'));
        items[index].style.display = 'block';
        dots[index].classList.add('active');
    }
    
    dots.forEach((dot, index) => {
        dot.addEventListener('click', function() {
            currentSlide = index;
            showSlide(currentSlide);
        });
    });
    
    setInterval(function() {
        currentSlide = (currentSlide + 1) % items.length;
        showSlide(currentSlide);
    }, 5000);
}

// Scroll Effects
function initScrollEffects() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
}

// Animations
function initAnimations() {
    const animateElements = document.querySelectorAll('.product-card, .mission-card');
    
    const animationObserver = new IntersectionObserver(function(entries) {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                animationObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    animateElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        animationObserver.observe(el);
    });
}

// Quantity Controls
function initQuantityControls() {
    document.querySelectorAll('.quantity-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const input = this.parentElement.querySelector('.quantity-value');
            let value = parseInt(input.value);
            
            if (this.textContent === '+') {
                value++;
            } else if (value > 1) {
                value--;
            }
            
            input.value = value;
            
            // Update cart via AJAX if on cart page
            const productId = this.dataset.id;
            if (productId) {
                updateCartQuantity(productId, value);
            }
        });
    });
}

// Add to Cart
function initAddToCart() {
    document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const productId = this.dataset.id;
            addToCart(productId);
        });
    });
}

// Add to Cart Function
function addToCart(productId) {
    fetch('add_to_cart.php?id=' + productId)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                updateCartCount(data.cart_count);
            } else {
                showToast(data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Something went wrong!', 'error');
        });
}

// Update Cart Quantity
function updateCartQuantity(productId, quantity) {
    const formData = new FormData();
    formData.append('product_id', productId);
    formData.append('quantity', quantity);
    
    fetch('update_cart.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.remove) {
                location.reload();
            } else {
                document.querySelector('.cart-total-amount').textContent = '₹' + data.total;
                updateCartCount(data.cart_count);
            }
        }
    });
}

// Remove from Cart
function removeFromCart(productId) {
    if (confirm('Are you sure you want to remove this item?')) {
        fetch('remove_from_cart.php?id=' + productId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 1000);
                }
            });
    }
}

// Update Cart Count
function updateCartCount(count) {
    const cartCount = document.querySelector('.cart-count');
    if (cartCount) {
        cartCount.textContent = count;
    }
}

// Toast Notification
function showToast(message, type) {
    // Remove existing toast
    const existingToast = document.querySelector('.toast');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast ' + type;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => toast.classList.add('show'), 10);
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Form Validation
function initFormValidation() {
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const required = form.querySelectorAll('[required]');
            
            required.forEach(input => {
                if (!input.value.trim()) {
                    isValid = false;
                    input.style.borderColor = 'red';
                } else {
                    input.style.borderColor = '#ddd';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showToast('Please fill in all required fields!', 'error');
            }
        });
    });
}

// Filter Products
function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    const buttons = document.querySelectorAll('.filter-btn');
    
    buttons.forEach(btn => btn.classList.remove('active'));
    event.target.classList.add('active');
    
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}
