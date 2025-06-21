CREATE TABLE IF NOT EXISTS orders(
    orderID INT AUTO_INCREMENT PRIMARY KEY,
    userID INT,
    status ENUM('pending', 'fulfilled', 'cancelled') DEFAULT 'pending',
    orderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (userID) REFERENCES users(userID)
)