<?php
if(isset($_GET["user_id"])){
    $user_id = $_GET["user_id"];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "vendas";

    // Connect to the database
    $connection = new mysqli($servername, $username, $password, $database);

    $sql = "DELETE FROM users WHERE user_id=$user_id";
    $connection->query($sql);
}

header("Location: vendas.php");
exit;

/*
   -- Table 1
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    profile_image BLOB
);

-- Table 2
CREATE TABLE orders (
    order_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    total_amount DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- Table 3
CREATE TABLE order_items (
    item_id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE
);
*/
?>
