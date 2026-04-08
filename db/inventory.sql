-- Create database
CREATE DATABASE IF NOT EXISTS inventory_system;
USE inventory_system;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    role ENUM('admin', 'staff') DEFAULT 'staff',
    is_active TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(200) NOT NULL,
    sku VARCHAR(50) UNIQUE,
    category_id INT,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    cost_price DECIMAL(10,2),
    quantity INT DEFAULT 0,
    reorder_level INT DEFAULT 5,
    status TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- Sales table
CREATE TABLE sales (
    id INT PRIMARY KEY AUTO_INCREMENT,
    invoice_no VARCHAR(50) UNIQUE NOT NULL,
    user_id INT,
    customer_name VARCHAR(100),
    total_amount DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) DEFAULT 0,
    tax DECIMAL(10,2) DEFAULT 0,
    grand_total DECIMAL(10,2) NOT NULL,
    payment_method ENUM('cash', 'card', 'online') DEFAULT 'cash',
    payment_status ENUM('paid', 'pending', 'partial') DEFAULT 'paid',
    sale_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Sale items table
CREATE TABLE sale_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    sale_id INT,
    product_id INT,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (sale_id) REFERENCES sales(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT
);

-- Stock logs table
CREATE TABLE stock_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT,
    user_id INT,
    quantity_change INT NOT NULL,
    previous_quantity INT,
    new_quantity INT,
    type ENUM('add', 'remove', 'sale', 'return', 'adjustment') NOT NULL,
    reference_no VARCHAR(100),
    reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Activity logs table
CREATE TABLE activity_logs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    description TEXT,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, role, is_active) 
VALUES ('admin', 'admin@system.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin', 1);

-- Insert sample categories
INSERT INTO categories (name, description) VALUES
('Electronics', 'Electronic products and gadgets'),
('Clothing', 'Apparel and fashion items'),
('Groceries', 'Daily grocery items');

-- Insert sample products
INSERT INTO products (name, sku, category_id, price, cost_price, quantity, reorder_level) VALUES
('Laptop', 'LAP001', 1, 45000.00, 40000.00, 10, 3),
('Mouse', 'MOU001', 1, 500.00, 300.00, 50, 10),
('T-Shirt', 'TSH001', 2, 350.00, 200.00, 100, 20),
('Rice 5kg', 'RIC001', 3, 250.00, 220.00, 30, 5);