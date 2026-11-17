-- DIOR e-commerce database: tables + demo data.
-- Import with phpMyAdmin (Import tab) or:  mysql -u root < database/dior_shop.sql
-- Running it again resets the database to this demo state.

DROP DATABASE IF EXISTS dior_shop;
CREATE DATABASE dior_shop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE dior_shop;

-- Customers who shop on the site. Passwords are stored as password_hash() hashes.
CREATE TABLE customer (
    c_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    c_name VARCHAR(225) NOT NULL,
    c_email VARCHAR(225) NOT NULL UNIQUE,
    c_phone VARCHAR(30),
    c_address VARCHAR(225),
    c_password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Admin users who manage products and orders.
CREATE TABLE admin (
    a_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    a_name VARCHAR(225) NOT NULL,
    a_email VARCHAR(225) NOT NULL UNIQUE,
    a_gender VARCHAR(15),
    a_password VARCHAR(255) NOT NULL
) ENGINE=InnoDB;

-- Product collections, e.g. Men / Women.
CREATE TABLE collection (
    collectionID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    colName VARCHAR(255) NOT NULL UNIQUE,
    colDescription TEXT,
    limitedEdition TINYINT(1) NOT NULL DEFAULT 0,
    colImage VARCHAR(255)
) ENGINE=InnoDB;

CREATE TABLE product (
    p_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    p_name VARCHAR(100) NOT NULL,
    p_price DECIMAL(10,2) NOT NULL DEFAULT 0,
    p_price1 DECIMAL(10,2),
    p_description TEXT,
    p_image VARCHAR(255),
    p_stock INT NOT NULL DEFAULT 0,
    p_note VARCHAR(225),
    p_productionDate DATE,
    p_expirationDate DATE,
    p_size VARCHAR(225),
    p_size1 VARCHAR(225),
    p_ingredients TEXT,
    collectionID INT NOT NULL,
    FOREIGN KEY (collectionID) REFERENCES collection(collectionID)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE carts (
    cart_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pqty INT NOT NULL DEFAULT 1,
    p_id INT NOT NULL,
    c_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY one_row_per_product (c_id, p_id),
    FOREIGN KEY (p_id) REFERENCES product(p_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (c_id) REFERENCES customer(c_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE wishlist (
    wish_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    p_id INT NOT NULL,
    c_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY one_row_per_product (c_id, p_id),
    FOREIGN KEY (p_id) REFERENCES product(p_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (c_id) REFERENCES customer(c_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- status: 0 = Under Process, 1 = Completed, 2 = Cancelled
CREATE TABLE orders (
    o_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    tracking_no VARCHAR(255) NOT NULL UNIQUE,
    c_id INT NOT NULL,
    name VARCHAR(225) NOT NULL,
    email VARCHAR(225) NOT NULL,
    phone VARCHAR(30) NOT NULL,
    address TEXT NOT NULL,
    pincode VARCHAR(20),
    o_totalAmount DECIMAL(10,2) NOT NULL,
    payment_mode VARCHAR(255) NOT NULL,
    payment_id VARCHAR(255) NOT NULL,
    status TINYINT NOT NULL DEFAULT 0,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (c_id) REFERENCES customer(c_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Line items keep a copy of the product name, so past orders stay readable
-- even if the product is later deleted.
CREATE TABLE order_items (
    oi_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    oi_quantity INT NOT NULL,
    oi_price DECIMAL(10,2) NOT NULL,
    oi_name VARCHAR(100) NOT NULL,
    o_id INT NOT NULL,
    p_id INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (o_id) REFERENCES orders(o_id) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (p_id) REFERENCES product(p_id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------------
-- Demo data (images are already in cp/upload/)
-- ---------------------------------------------------------------------------

-- Demo logins (change or delete them before using this anywhere public):
--   Admin:    admin@example.com    / admin123
--   Customer: customer@example.com / customer123
INSERT INTO admin (a_name, a_email, a_gender, a_password) VALUES
('Demo Admin', 'admin@example.com', 'Other', '$2y$10$yOIthXTyCKPM.PNxg98II.5ZWE3gNbvagcIgsfmF3UdddDsIhahVq');

INSERT INTO customer (c_name, c_email, c_phone, c_address, c_password) VALUES
('Demo Customer', 'customer@example.com', '07700900123', '221B Baker Street, London', '$2y$10$kzWltOPZAO8UjGLlSZygDeqzq7Z/cRX55n4urzubgmJtJa8xKNTgy');

INSERT INTO collection (collectionID, colName, colDescription, limitedEdition, colImage) VALUES
(1, 'Men', 'Fresh, bold fragrances inspired by wide-open spaces.', 0, '1720170853.jpg'),
(2, 'Women', 'Floral, romantic fragrances with a modern twist.', 0, '1720169656.jpg'),
(3, 'La Collection Privee', 'Limited-edition creations from the Dior perfume house.', 1, '1720080085.jpg');

INSERT INTO product (p_name, p_price, p_description, p_image, p_stock, p_note, p_productionDate, p_expirationDate, p_size, p_ingredients, collectionID) VALUES
('Sauvage Eau de Parfum', 120.00, 'A fresh and spicy fragrance with a sensual vanilla trail.', '1720168349.jpg', 25, 'Fresh & spicy', '2024-01-15', '2029-01-15', '100ml', 'Bergamot, Sichuan pepper, ambroxan, vanilla', 1),
('Sauvage Parfum', 145.00, 'A richer, more intense take on Sauvage with mandarin and sandalwood.', '1720772796.jpg', 15, 'Woody & warm', '2024-02-01', '2029-02-01', '100ml', 'Mandarin, sandalwood, tonka bean', 1),
('Sauvage Elixir', 160.00, 'A highly concentrated fragrance with spices, lavender and licorice.', '1720772907.jpg', 8, 'Spicy & ambery', '2024-03-10', '2029-03-10', '60ml', 'Grapefruit, cinnamon, lavender, licorice', 1),
('Sauvage Gift Set', 135.00, 'Sauvage Eau de Parfum with a travel spray, in a gift box.', '1720773195.jpg', 0, 'Gift set', '2024-04-05', '2029-04-05', '100ml + 10ml', 'Bergamot, pepper, ambroxan', 1),
('Miss Dior Eau de Parfum', 115.00, 'A floral bouquet of rose and lily of the valley.', '1720168624.jpg', 30, 'Floral', '2024-01-20', '2029-01-20', '100ml', 'Rose, lily of the valley, iris, vanilla', 2),
('Miss Dior Eau de Toilette', 95.00, 'A lighter, fresher Miss Dior with a sparkling floral heart.', '1720170523.jpg', 20, 'Fresh floral', '2024-02-14', '2029-02-14', '100ml', 'Rose, peony, white musk', 2),
('Miss Dior Parfum', 130.00, 'An intense floral-fruity Miss Dior with jasmine and mandarin.', '1722590228.jpg', 12, 'Floral & fruity', '2024-05-01', '2029-05-01', '80ml', 'Jasmine, mandarin, rose, woods', 2),
('Dioriviera', 210.00, 'A fig and rose fragrance inspired by the French Riviera.', '1720164749.jpg', 6, 'Fruity floral', '2024-03-01', '2029-03-01', '125ml', 'Fig, rose, cedar', 3),
('Jasmin des Anges', 210.00, 'A luminous jasmine fragrance with a touch of apricot.', '1720081958.jpg', 5, 'White floral', '2024-03-01', '2029-03-01', '125ml', 'Jasmine, apricot, peach', 3);
