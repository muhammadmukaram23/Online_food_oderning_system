-- KFC Restaurant Database Schema
-- Created for a fast-food restaurant management system

-- Create database
CREATE DATABASE IF NOT EXISTS kfc_restaurant;
USE kfc_restaurant;

-- Table for restaurant locations/branches
CREATE TABLE locations (
    location_id INT PRIMARY KEY AUTO_INCREMENT,
    store_name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    manager_name VARCHAR(100) NOT NULL,
    opening_time TIME DEFAULT '06:00:00',
    closing_time TIME DEFAULT '23:00:00',
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table for menu categories
CREATE TABLE categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    image_url VARCHAR(255),
    sort_order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for menu items
CREATE TABLE menu_items (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(8,2) NOT NULL,
    calories INT,
    preparation_time INT DEFAULT 10, -- in minutes
    image_url VARCHAR(255),
    ingredients TEXT,
    allergens VARCHAR(255),
    is_vegetarian BOOLEAN DEFAULT FALSE,
    is_spicy BOOLEAN DEFAULT FALSE,
    is_available BOOLEAN DEFAULT TRUE,
    featured BOOLEAN DEFAULT FALSE,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(category_id) ON DELETE CASCADE
);

-- Table for item variations (sizes, spice levels, etc.)
CREATE TABLE item_variations (
    variation_id INT PRIMARY KEY AUTO_INCREMENT,
    item_id INT NOT NULL,
    variation_name VARCHAR(50) NOT NULL, -- e.g., 'Regular', 'Large', 'Family Size'
    price_modifier DECIMAL(8,2) DEFAULT 0.00, -- additional cost
    is_default BOOLEAN DEFAULT FALSE,
    is_available BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (item_id) REFERENCES menu_items(item_id) ON DELETE CASCADE
);

-- Table for customers
CREATE TABLE customers (
    customer_id INT PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    date_of_birth DATE,
    gender ENUM('Male', 'Female', 'Other'),
    loyalty_points INT DEFAULT 0,
    total_orders INT DEFAULT 0,
    total_spent DECIMAL(10,2) DEFAULT 0.00,
    is_active BOOLEAN DEFAULT TRUE,
    email_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_phone (phone)
);

-- Table for customer addresses
CREATE TABLE customer_addresses (
    address_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    address_type ENUM('Home', 'Work', 'Other') DEFAULT 'Home',
    address_line1 VARCHAR(255) NOT NULL,
    address_line2 VARCHAR(255),
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    zip_code VARCHAR(10) NOT NULL,
    is_default BOOLEAN DEFAULT FALSE,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE
);

-- Table for employees
CREATE TABLE employees (
    employee_id INT PRIMARY KEY AUTO_INCREMENT,
    location_id INT NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NOT NULL,
    role ENUM('Manager', 'Cashier', 'Cook', 'Delivery', 'Cleaner') NOT NULL,
    salary DECIMAL(10,2),
    hire_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

-- Table for orders
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT,
    location_id INT NOT NULL,
    order_number VARCHAR(20) UNIQUE NOT NULL,
    order_type ENUM('Dine-in', 'Takeout', 'Delivery', 'Drive-thru') NOT NULL,
    order_status ENUM('Pending', 'Confirmed', 'Preparing', 'Ready', 'Out for Delivery', 'Delivered', 'Cancelled') DEFAULT 'Pending',
    subtotal DECIMAL(10,2) NOT NULL,
    tax_amount DECIMAL(8,2) NOT NULL,
    delivery_fee DECIMAL(6,2) DEFAULT 0.00,
    discount_amount DECIMAL(8,2) DEFAULT 0.00,
    total_amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('Pending', 'Paid', 'Failed', 'Refunded') DEFAULT 'Pending',
    special_instructions TEXT,
    estimated_prep_time INT, -- in minutes
    actual_prep_time INT, -- in minutes
    delivery_address_id INT,
    assigned_employee_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE SET NULL,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE,
    FOREIGN KEY (delivery_address_id) REFERENCES customer_addresses(address_id) ON DELETE SET NULL,
    FOREIGN KEY (assigned_employee_id) REFERENCES employees(employee_id) ON DELETE SET NULL,
    INDEX idx_order_number (order_number),
    INDEX idx_order_status (order_status),
    INDEX idx_order_date (created_at)
);

-- Table for order items
CREATE TABLE order_items (
    order_item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    item_id INT NOT NULL,
    variation_id INT,
    quantity INT NOT NULL DEFAULT 1,
    unit_price DECIMAL(8,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    special_instructions TEXT,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (item_id) REFERENCES menu_items(item_id) ON DELETE CASCADE,
    FOREIGN KEY (variation_id) REFERENCES item_variations(variation_id) ON DELETE SET NULL
);

-- Table for payments
CREATE TABLE payments (
    payment_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    payment_method ENUM('Cash', 'Credit Card', 'Debit Card', 'Digital Wallet', 'Gift Card') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_status ENUM('Pending', 'Completed', 'Failed', 'Refunded') DEFAULT 'Pending',
    transaction_id VARCHAR(100),
    payment_gateway VARCHAR(50),
    processed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);

-- Table for promotions and discounts
CREATE TABLE promotions (
    promotion_id INT PRIMARY KEY AUTO_INCREMENT,
    promotion_name VARCHAR(100) NOT NULL,
    promotion_code VARCHAR(20) UNIQUE,
    description TEXT,
    discount_type ENUM('Percentage', 'Fixed Amount', 'Buy One Get One') NOT NULL,
    discount_value DECIMAL(8,2) NOT NULL,
    min_order_amount DECIMAL(8,2) DEFAULT 0.00,
    max_discount_amount DECIMAL(8,2),
    usage_limit INT,
    usage_count INT DEFAULT 0,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table for customer reviews
CREATE TABLE reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    order_id INT,
    location_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    is_approved BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE SET NULL,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

-- Table for inventory management
CREATE TABLE inventory (
    inventory_id INT PRIMARY KEY AUTO_INCREMENT,
    location_id INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    current_stock INT NOT NULL DEFAULT 0,
    min_stock_level INT DEFAULT 10,
    max_stock_level INT DEFAULT 100,
    unit VARCHAR(20) DEFAULT 'pieces',
    cost_per_unit DECIMAL(8,2),
    supplier VARCHAR(100),
    last_restocked DATE,
    expiry_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (location_id) REFERENCES locations(location_id) ON DELETE CASCADE
);

-- Table for loyalty program
CREATE TABLE loyalty_transactions (
    transaction_id INT PRIMARY KEY AUTO_INCREMENT,
    customer_id INT NOT NULL,
    order_id INT,
    transaction_type ENUM('Earned', 'Redeemed', 'Expired', 'Bonus') NOT NULL,
    points INT NOT NULL,
    description VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(customer_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE SET NULL
);

-- Insert sample data for categories
INSERT INTO categories (category_name, description, sort_order) VALUES
('Chicken', 'Original Recipe and crispy chicken pieces', 1),
('Burgers', 'Delicious chicken burgers and wraps', 2),
('Sides', 'Fries, coleslaw, and other side dishes', 3),
('Beverages', 'Soft drinks, juices, and hot beverages', 4),
('Desserts', 'Sweet treats and ice cream', 5),
('Family Meals', 'Perfect for sharing with family and friends', 6);

-- Insert sample data for menu items
INSERT INTO menu_items (category_id, item_name, description, price, calories, is_spicy) VALUES
(1, 'Original Recipe Chicken', '2 pieces of our famous Original Recipe chicken', 8.99, 320, FALSE),
(1, 'Hot & Spicy Chicken', '2 pieces of hot and spicy chicken', 9.49, 340, TRUE),
(1, 'Zinger Chicken', 'Crispy spicy chicken fillet', 10.99, 380, TRUE),
(2, 'Zinger Burger', 'Spicy chicken fillet burger with lettuce and mayo', 7.99, 450, TRUE),
(2, 'Classic Chicken Burger', 'Grilled chicken breast with fresh vegetables', 6.99, 380, FALSE),
(3, 'Regular Fries', 'Crispy golden fries', 2.99, 230, FALSE),
(3, 'Large Fries', 'Crispy golden fries - large size', 3.99, 350, FALSE),
(3, 'Coleslaw', 'Fresh creamy coleslaw', 2.49, 120, FALSE),
(4, 'Pepsi', 'Refreshing cola drink', 1.99, 150, FALSE),
(4, 'Orange Juice', 'Fresh orange juice', 2.49, 110, FALSE),
(5, 'Chocolate Chip Cookie', 'Warm chocolate chip cookie', 1.99, 180, FALSE),
(6, 'Family Feast', '8 pieces chicken, 4 sides, 4 drinks', 29.99, 1200, FALSE);

-- Insert sample locations
INSERT INTO locations (store_name, address, city, state, zip_code, phone, manager_name) VALUES
('KFC Downtown', '123 Main Street', 'New York', 'NY', '10001', '555-0101', 'John Smith'),
('KFC Mall Plaza', '456 Shopping Center', 'Los Angeles', 'CA', '90210', '555-0102', 'Sarah Johnson'),
('KFC Airport', '789 Terminal Road', 'Chicago', 'IL', '60601', '555-0103', 'Mike Wilson');

-- Create indexes for better performance
CREATE INDEX idx_menu_items_category ON menu_items(category_id);
CREATE INDEX idx_menu_items_available ON menu_items(is_available);
CREATE INDEX idx_orders_customer ON orders(customer_id);
CREATE INDEX idx_orders_location ON orders(location_id);
CREATE INDEX idx_orders_status_date ON orders(order_status, created_at);
CREATE INDEX idx_order_items_order ON order_items(order_id);
CREATE INDEX idx_customers_email ON customers(email);
CREATE INDEX idx_reviews_rating ON reviews(rating);
CREATE INDEX idx_inventory_location ON inventory(location_id);

-- Create views for common queries
CREATE VIEW active_menu_items AS
SELECT 
    mi.item_id,
    mi.item_name,
    mi.description,
    mi.price,
    mi.calories,
    c.category_name,
    mi.is_vegetarian,
    mi.is_spicy,
    mi.featured
FROM menu_items mi
JOIN categories c ON mi.category_id = c.category_id
WHERE mi.is_available = TRUE AND c.is_active = TRUE
ORDER BY c.sort_order, mi.sort_order;

CREATE VIEW order_summary AS
SELECT 
    o.order_id,
    o.order_number,
    CONCAT(c.first_name, ' ', c.last_name) AS customer_name,
    l.store_name,
    o.order_type,
    o.order_status,
    o.total_amount,
    o.created_at
FROM orders o
LEFT JOIN customers c ON o.customer_id = c.customer_id
JOIN locations l ON o.location_id = l.location_id;

-- Create stored procedures for common operations

DELIMITER //

-- Procedure to add item to cart/order
CREATE PROCEDURE AddItemToOrder(
    IN p_order_id INT,
    IN p_item_id INT,
    IN p_variation_id INT,
    IN p_quantity INT,
    IN p_special_instructions TEXT
)
BEGIN
    DECLARE v_unit_price DECIMAL(8,2);
    DECLARE v_variation_price DECIMAL(8,2) DEFAULT 0;
    DECLARE v_total_price DECIMAL(10,2);
    
    -- Get base price
    SELECT price INTO v_unit_price FROM menu_items WHERE item_id = p_item_id;
    
    -- Get variation price if specified
    IF p_variation_id IS NOT NULL THEN
        SELECT price_modifier INTO v_variation_price 
        FROM item_variations 
        WHERE variation_id = p_variation_id;
    END IF;
    
    SET v_unit_price = v_unit_price + v_variation_price;
    SET v_total_price = v_unit_price * p_quantity;
    
    INSERT INTO order_items (order_id, item_id, variation_id, quantity, unit_price, total_price, special_instructions)
    VALUES (p_order_id, p_item_id, p_variation_id, p_quantity, v_unit_price, v_total_price, p_special_instructions);
END //

-- Procedure to calculate order total
CREATE PROCEDURE UpdateOrderTotal(IN p_order_id INT)
BEGIN
    DECLARE v_subtotal DECIMAL(10,2);
    DECLARE v_tax_rate DECIMAL(4,4) DEFAULT 0.0875; -- 8.75% tax
    DECLARE v_tax_amount DECIMAL(8,2);
    DECLARE v_total DECIMAL(10,2);
    
    SELECT SUM(total_price) INTO v_subtotal
    FROM order_items
    WHERE order_id = p_order_id;
    
    SET v_tax_amount = v_subtotal * v_tax_rate;
    SET v_total = v_subtotal + v_tax_amount;
    
    UPDATE orders 
    SET subtotal = v_subtotal,
        tax_amount = v_tax_amount,
        total_amount = v_total
    WHERE order_id = p_order_id;
END //

DELIMITER ;

-- Create triggers

DELIMITER //

-- Trigger to update customer stats after order completion
CREATE TRIGGER update_customer_stats AFTER UPDATE ON orders
FOR EACH ROW
BEGIN
    IF NEW.order_status = 'Delivered' AND OLD.order_status != 'Delivered' THEN
        UPDATE customers 
        SET total_orders = total_orders + 1,
            total_spent = total_spent + NEW.total_amount,
            loyalty_points = loyalty_points + FLOOR(NEW.total_amount)
        WHERE customer_id = NEW.customer_id;
        
        -- Add loyalty points transaction
        INSERT INTO loyalty_transactions (customer_id, order_id, transaction_type, points, description)
        VALUES (NEW.customer_id, NEW.order_id, 'Earned', FLOOR(NEW.total_amount), 'Points earned from order');
    END IF;
END //

DELIMITER ;