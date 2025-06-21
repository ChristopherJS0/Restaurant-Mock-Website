-- 1. Create the database
CREATE DATABASE IF NOT EXISTS restaurant;

-- 2. Use the database
USE restaurant;

-- 3. Create users table
CREATE TABLE IF NOT EXISTS users (
    userID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL
);

-- 4. Create orders table
CREATE TABLE IF NOT EXISTS orders (
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    status ENUM('pending', 'fulfilled', 'cancelled') DEFAULT 'pending',
    orderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES users(userID)
);

-- 5. Create orderitems table
CREATE TABLE IF NOT EXISTS orderitems (
    orderItemID INT AUTO_INCREMENT PRIMARY KEY,
    orderID INT,
    itemName VARCHAR(255) NOT NULL,
    itemDescription TEXT,
    FOREIGN KEY (orderID) REFERENCES orders(orderID)
);
-- 6. Create admin table
CREATE TABLE admin (
    adminID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL -- hashed password
);

-- 7. Create mock admin user (for testing purposes)
INSERT INTO admin (username, password) VALUES ('admin', 'admin');