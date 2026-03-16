-- JJ Jalebi Database Setup
-- Run this file in phpMyAdmin to create the database

-- Create database
CREATE DATABASE IF NOT EXISTS jj_jalebi;
USE jj_jalebi;

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(255) DEFAULT '',
    address TEXT NOT NULL,
    notes TEXT DEFAULT '',
    payment_method VARCHAR(50) DEFAULT 'Cash on Delivery',
    total_amount DECIMAL(10,2) NOT NULL,
    order_status VARCHAR(50) DEFAULT 'Pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Admin table
CREATE TABLE IF NOT EXISTS admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample products
INSERT INTO products (name, description, price, image) VALUES
('Fresh Jalebi', 'Crispy, juicy, and soaked in sugar syrup - made fresh daily', 150.00, 'jalebi.jpg'),
('Mawa Jalebi', 'Our signature dark, rich, and juicy jalebi made with mawa - a Vasai favorite', 200.00, 'mawa_jalebi.jpg'),
('Malpua with Rabdi', 'Deep-fried sweet pancakes served with thick, creamy rabdi', 180.00, 'malpua.jpg'),
('Gulab Jamun', 'Soft dough balls soaked in rose-flavored sugar syrup', 180.00, 'gulab.jpg'),
('Fafda', 'Crispy chickpea flour snacks best enjoyed with jalebi', 120.00, 'fafda.jpg'),
('Rabdi', 'Rich, creamy sweetened condensed milk with pistachios and almonds', 160.00, 'rabdi.jpg'),
('Motichoor Laddu', 'Tiny pearl-like laddu with premium quality ingredients', 250.00, 'motichoor.jpg'),
('Jalebi Combo Pack', 'A combo of fresh jalebi and gulab jamun', 300.00, 'combo.jpg'),
('Kaju Katli', 'Premium cashew fudge with silver foil', 400.00, 'kaju.jpg'),
('Barfi Mix', 'Assorted barfis - milk, peda, and coconut', 280.00, 'barfi.jpg'),
('Sohan Halwa', 'Rich and crunchy halwa with nuts', 320.00, 'sohan.jpg'),
('Peda', 'Soft milk pedas from Mathura', 180.00, 'peda.jpg');

-- Insert default admin user (username: admin, password: admin123)
INSERT INTO admin (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
