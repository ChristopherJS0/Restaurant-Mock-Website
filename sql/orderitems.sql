CREATE TABLE IF NOT EXISTS orderitems (
    orderItemID INT AUTO_INCREMENT PRIMARY KEY,
    orderID INT,
    itemName VARCHAR(255) NOT NULL,
    itemDescription TEXT,
    FOREIGN KEY (orderID) REFERENCES orders(orderID)
);