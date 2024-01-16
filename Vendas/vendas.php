<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "vendas";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$sql = "SELECT users.user_id, users.username, users.email, orders.user_id AS order_user_id, orders.total_amount, order_items.order_id, order_items.product_name, order_items.quantity, order_items.price
        FROM users
        LEFT JOIN orders ON users.user_id = orders.user_id
        LEFT JOIN order_items ON orders.order_id = order_items.order_id";

$result = $connection->query($sql);

if (!$result) {
    die("Invalid query: " . $connection->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container my-5">
        <h2>Clientes</h2>
        <a class="btn btn-primary" href="create.php" role="button">New Clientes</a>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>User_id</th>
                    <th>Total_Amount</th>
                    <th>Order_id</th>
                    <th>Product_Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['user_id']}</td>
                            <td>{$row['username']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['order_user_id']}</td>
                            <td>{$row['total_amount']}</td>
                            <td>{$row['order_id']}</td>
                            <td>{$row['product_name']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['price']}</td>
                            <td>
                                <a class='btn btn-primary btn-sm' href='edit.php?user_id={$row['user_id']}'>Edit</a>
                                <a class='btn btn-danger btn-sm' href='delete.php?user_id={$row['user_id']}'>Delete</a>
                            </td>
                        </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
