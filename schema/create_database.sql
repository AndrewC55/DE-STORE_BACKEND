-- USE THIS TO CREATE DATABASE

CREATE DATABASE DE_STORE;
USE DE_STORE;

CREATE TABLE `products` (
    productID INT(11) AUTO_INCREMENT,
    productName VARCHAR(255) NOT NULL,
    price INT(11) NOT NULL,
    delivery INT (11) NOT NULL,
    buyOneGetOneFree INT(11),
    threeForTwo INT(11),
    freeDelivery INT(11),
    PRIMARY KEY (productID)
);

INSERT INTO `products` (`productName`, `price`, `delivery`, `buyOneGetOneFree`, `threeForTwo`, `freeDelivery`) VALUES
('Hose', 15, 3, 0, 0, 0),
('Garden Shed', 300, 25, 1, 0, 1),
('Paint brush', 10, 2, 0, 1, 0),
('Large paint brush', 15, 3, 0, 0, 1),
('Lawnmower', 250, 20, 1, 0, 0);

CREATE TABLE `inventory` (
    inventoryID INT(11) AUTO_INCREMENT,
    productID INT(11) NOT NULL,
    stock INT(11) NOT NULL,
    PRIMARY KEY (inventoryID)
);

INSERT INTO `inventory` (`productID`, `stock`) VALUES
(1, 25),
(2, 10),
(3, 12),
(4, 35),
(5, 2);

CREATE TABLE `customers` (
    customerID INT(11) AUTO_INCREMENT,
    firstName VARCHAR(255) NOT NULL,
    lastName VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    loyaltyCard INT(1),
    finance INT(1),
    PRIMARY KEY (customerID)
);

INSERT INTO `customers` (`firstName`, `lastName`, `email`, `address`, `loyaltyCard`, `finance`) VALUES
('Andrew', 'Clark', '40345373@live.napier.ac.uk', '12 Willow Dell, Bo`ness', 0, 0),
('Matt', 'Smith', 'matt.smith@gmail.com', '1 Harrow Lane, Glasgow', 1, 1),
('Charles', 'Cook', 'charles.cook@hotmail.com', '25 Shearer Streee, Inverness', 1, 0);

CREATE TABLE `sales` (
    salesID INT(11) AUTO_INCREMENT,
    productID INT(11),
    customerID INT(11),
    price INT (11),
    PRIMARY KEY (salesID)
);

INSERT INTO `sales` (`productID`, `customerID`, `price`) VALUES
(1, 2, 15),
(1, 1, 15),
(1, 3, 10),
(5, 1, 200),
(3, 1, 10),
(2, 3, 150);