<?php
$conn=mysqli_connect('localhost','root','');
$sql='CREATE DATABASE IF NOT EXISTS project';
$response=mysqli_query($conn,$sql);
if($response)
	echo "<br/> Project is created";
mysqli_select_db($conn,'project');

$customerTb="CREATE TABLE IF NOT EXISTS customer(
c_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
c_name VARCHAR(225),
c_email VARCHAR(225),
c_phone VARCHAR(15),
c_address VARCHAR(225),
c_password VARCHAR(150))";
$result=mysqli_query($conn,$customerTb);
if($result==true){
    echo "Create Customer table successfully";
}
if(!$conn) {
    echo "Error creating customer table: " . mysqli_error($conn);
}

$collectionTb='CREATE TABLE IF NOT EXISTS collection(
    collectionID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    colName VARCHAR(255) NOT NULL,
    colDescription TEXT,
    limitedEdition TINYINT(1) NOT NULL,
    colImage VARCHAR(255)
    )';
    $collectionReturn=mysqli_query($conn,$collectionTb);

// SQL to create Product table
$productTb = 'CREATE TABLE IF NOT EXISTS Product(
    p_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    p_name VARCHAR(40),
    p_price DECIMAL(10,2),
    p_price1 DECIMAL(10,2),
    p_description TEXT,
    p_image TEXT,
    p_stock INT,
    p_note VARCHAR(225),
    p_productionDate DATE,
    p_expirationDate DATE,
    p_size VARCHAR(225),
    p_size1 VARCHAR(225),
    p_ingredients TEXT,
    collectionID INT,
    FOREIGN KEY(collectionID) REFERENCES collection(collectionID)
    ON DELETE CASCADE
    ON UPDATE CASCADE
)';

// Execute query and check for errors
$productReturn = mysqli_query($conn, $productTb);
if (!$productReturn) {
    die('Error creating Product table: ' . mysqli_error($conn));
}

echo 'Tables created successfully.';


$cartTb='CREATE TABLE carts(
    cart_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    pqty INT,
    p_id INT,
    c_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(p_id) REFERENCES Product(p_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY(c_id) REFERENCES Customer(c_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE)';
$cartReturn=mysqli_query($conn,$cartTb);

$wishTb='CREATE TABLE wishList(
    wish_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    p_id INT,
    c_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(p_id) REFERENCES Product(p_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY(c_id) REFERENCES Customer(c_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE)';
$wishReturn=mysqli_query($conn,$wishTb);

$orderTb='CREATE TABLE `Order`(
    o_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    tracking_no  VARCHAR(255),
    c_id INT,
    name TEXT,
    email TEXT,
    phone TEXT,
    address TEXT,
    pincode INT,
    o_totalAmount DECIMAL(10,2),
    payment_mode VARCHAR(255),
    payment_id VARCHAR(255) NOT NULL,
    status TINYINT,
    comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
   
    FOREIGN KEY(c_id) REFERENCES Customer(c_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE)';
$orderReturn=mysqli_query($conn,$orderTb);

$orderItemTb='CREATE TABLE `OrderItem`(
    oi_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    oi_quantity INT,
    oi_price DECIMAL(10,2),
    o_id INT,
    p_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(o_id) REFERENCES `Order`(o_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
    FOREIGN KEY(p_id) REFERENCES Product(p_id)
    ON DELETE CASCADE
    ON UPDATE CASCADE
    )';
$orderItemReturn=mysqli_query($conn,$orderItemTb);

$AdminTb="CREATE TABLE IF NOT EXISTS admin(
    a_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    a_name VARCHAR(225),
    a_email VARCHAR(225),
    a_gender VARCHAR(15),
    a_password VARCHAR(150))";
    $result=mysqli_query($conn,$AdminTb);
    if($result==true){
        echo "Create Admin table successfully";
    }
    if(!$conn) {
        echo "Error creating customer table: " . mysqli_error($conn);
    }
?>






// $reviewTb='CREATE TABLE Review(
//     r_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
//     r_comment TEXT,
//     r_date DATE,
//     c_id INT,
//     p_id INT,
//     FOREIGN KEY(c_id) REFERENCES Customer(c_id)
//     ON DELETE CASCADE
//     ON UPDATE CASCADE,
//     FOREIGN KEY(p_id) REFERENCES Product(p_id)
//     ON DELETE CASCADE
//     ON UPDATE CASCADE
//     )';
// $reviewReturn=mysqli_query($conn,$reviewTb);
?>  