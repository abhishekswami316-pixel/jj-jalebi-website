# JJ Jalebi - Sweet Shop Website

A fully functional, responsive, and modern website for JJ Jalebi sweet shop, specializing in fresh jalebi and traditional Indian sweets.

## Features

- **Home Page**: Hero section, featured products, testimonials, about preview
- **About Page**: Company story, mission, image gallery
- **Menu Page**: Products displayed dynamically from database
- **Shopping Cart**: Session-based cart system
- **Checkout**: Order form with Cash on Delivery
- **Admin Panel**: Manage products and orders

## Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript (Vanilla)
- **Backend**: PHP (Core PHP)
- **Database**: MySQL

## Installation

### 1. Setup XAMPP
1. Download and install XAMPP from https://www.apachefriends.org/
2. Start Apache and MySQL services

### 2. Import Database
1. Open phpMyAdmin (http://localhost/phpmyadmin)
2. Create a new database named `jj_jalebi`
3. Click on "Import" tab
4. Select the file `database/jj_jalebi.sql`
5. Click "Go" to import

### 3. Configure Database
- Open `config/db.php`
- Update database credentials if needed (default: root, no password)

### 4. Run the Project
1. Place the project folder in `htdocs` folder (XAMPP)
2. Or use built-in PHP server:
   
```
   php -S localhost:8000
   
```
3. Open browser and navigate to:
   - Website: http://localhost/final project/ (or http://localhost:8000)
   - Admin Panel: http://localhost/final project/admin/

### 5. Admin Login
- **Username**: admin
- **Password**: admin123

## Project Structure

```
final project/
├── admin/              # Admin panel files
│   ├── index.php      # Login page
│   ├── dashboard.php  # Admin dashboard
│   ├── products.php   # Products management
│   ├── add_product.php
│   ├── edit_product.php
│   ├── orders.php    # Order management
│   ├── logout.php
│   └── css/admin.css
├── config/
│   └── db.php        # Database connection
├── css/
│   └── style.css     # Main stylesheet
├── js/
│   └── main.js       # JavaScript functions
├── pages/
│   ├── header.php    # Common header
│   └── footer.php    # Common footer
├── database/
│   └── jj_jalebi.sql # Database setup
├── index.php         # Home page
├── about.php         # About page
├── menu.php          # Menu page
├── cart.php          # Shopping cart
├── checkout.php      # Checkout page
├── place_order.php   # Order processing
├── add_to_cart.php  # Add to cart AJAX
├── update_cart.php  # Update cart AJAX
└── remove_from_cart.php # Remove from cart AJAX
```

## Color Palette

- Primary: Saffron Orange (#FF6F00)
- Secondary: Golden Yellow (#FFC107)
- Accent: Deep Red (#B71C1C)
- Background: Cream (#FFF8E1)

## Security Features

- Password hashing with password_hash()
- Prepared statements to prevent SQL injection
- Session-based admin authentication
- Input validation and sanitization

## License

MIT License - Feel free to use and modify for your own sweet shop!
