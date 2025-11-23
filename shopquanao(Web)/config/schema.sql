-- Create database
CREATE DATABASE IF NOT EXISTS laptop_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE laptop_shop;

-- Create users table
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    city VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    brand VARCHAR(100),
    processor VARCHAR(100),
    ram VARCHAR(100),
    storage VARCHAR(100),
    screen_size VARCHAR(50),
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    total_amount DECIMAL(10, 2) NOT NULL,
    shipping_address TEXT NOT NULL,
    shipping_city VARCHAR(100),
    status VARCHAR(50) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Create order_items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Insert sample products
INSERT INTO products (name, description, price, stock, brand, processor, ram, storage, screen_size, image_url) VALUES
('Dell XPS 13', 'Ultrabook mỏng nhẹ cao cấp', 29990000, 5, 'Dell', 'Intel Core i7', '16GB', '512GB SSD', '13.3 inch', '/images/dell-xps-13.jpg'),
('HP Pavilion 15', 'Laptop đa năng cho công việc', 15990000, 8, 'HP', 'AMD Ryzen 5', '8GB', '256GB SSD', '15.6 inch', '/images/hp-pavilion-15.jpg'),
('Lenovo ThinkPad', 'Doanh nhân, bảo mật cao', 24990000, 3, 'Lenovo', 'Intel Core i5', '16GB', '512GB SSD', '14 inch', '/images/lenovo-thinkpad.jpg'),
('ASUS TUF Gaming', 'Gaming mạnh mẽ, hiệu suất cao', 35990000, 4, 'ASUS', 'Intel Core i9', '32GB', '1TB SSD', '15.6 inch', '/images/asus-tuf.jpg'),
('MacBook Air M2', 'Mỏng nhẹ, hiệu suất ấn tượng', 32990000, 2, 'Apple', 'Apple M2', '16GB', '512GB SSD', '13.6 inch', '/images/macbook-air-m2.jpg'),
('Acer Aspire 5', 'Cấu hình tốt giá hợp lý', 12990000, 10, 'Acer', 'AMD Ryzen 7', '8GB', '256GB SSD', '15.6 inch', '/images/acer-aspire-5.jpg');
