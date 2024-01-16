<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "vendas";

// Connect to the database
$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$username = "";
$email = "";
$user_id = "";
$total_amount = "";
$order_id = "";
$product_name = "";
$quantity = "";
$price = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $username = isset($_POST["username"]) ? $_POST["username"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $total_amount = isset($_POST["total_amount"]) ? $_POST["total_amount"] : "";
    $product_name = isset($_POST["product_name"]) ? $_POST["product_name"] : "";
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
    $price = isset($_POST["price"]) ? $_POST["price"] : "";

    if (empty($username) || empty($email) || empty($total_amount) || empty($product_name) || empty($quantity) || empty($price)) {
        $errorMessage = "All the fields are required";
    } else {
        // Add user to the 'users' table
        $insertUserSql = "INSERT INTO users (username, email) VALUES ('$username', '$email')";
        $resultUser = $connection->query($insertUserSql);

        if (!$resultUser) {
            $errorMessage = "Error adding user: " . $connection->error;
        } else {
            // Get the user_id of the inserted user
            $user_id = $connection->insert_id;

            // Add order to the 'orders' table
            $insertOrderSql = "INSERT INTO orders (user_id, total_amount) VALUES ('$user_id', '$total_amount')";
            $resultOrder = $connection->query($insertOrderSql);

            if (!$resultOrder) {
                $errorMessage = "Error adding order: " . $connection->error;
            } else {
                // Get the order_id of the inserted order
                $order_id = $connection->insert_id;

                // Add order item to the 'order_items' table
                $insertOrderItemSql = "INSERT INTO order_items (order_id, product_name, quantity, price) VALUES ('$order_id', '$product_name', '$quantity', '$price')";
                $resultOrderItem = $connection->query($insertOrderItemSql);

                if (!$resultOrderItem) {
                    $errorMessage = "Error adding order item: " . $connection->error;
                } else {
                    // Reset input values
                    $username = "";
                    $email = "";
                    $user_id = "";
                    $total_amount = "";
                    $order_id = "";
                    $product_name = "";
                    $quantity = "";
                    $price = "";

                    $successMessage = "Data added successfully";
                }
            }
        }
    }
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container my-5">
        <h2>Vendas</h2>
        <?php
    if (!empty($errorMessage)) {
        echo "
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
            <strong>$errorMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
    ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">Username</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name = "username" value="<?php echo $username; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">Email</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">order_User_id</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="user_id" value="<?php echo $user_id; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">Total_amount</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="total_amount" value="<?php echo $total_amount; ?>">

                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">item_order_id</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="order_id" value="<?php echo $order_id; ?>">

                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">product_name</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>">

                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">quantity</label>
                <div class="col-sm-6">
                    <input type "text" class= "form-control" name= "quantity" value="<?php echo $quantity; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-fort-Iabel">Price</label>
                <div class="col-sm-6">
                    <input type "text" class= "form-control" name= "price" value="<?php echo $price; ?>">
                </div>
            </div>
        
            <?php
    if (!empty($successMessage)) {
        echo "
        <div class='alert alert-success alert-dismissible fade show' role='alert'>
            <strong>$successMessage</strong>
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
        </div>
        ";
    }
    ?>
    <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
            <!-- Corrected the name attribute -->
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
        <div class="col-sm-3 d-grid">
            <a class="btn btn-outline-primary" href="vendas.php" role="button">Cancel</a>
        </div>
    </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-b12eBn0rGSx7jqqomLO2AeuSZyZsZ92K5iDBbExj2FhBLvbPbPk5B1PexvfmJir" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-eVSTQN6zf6RdZNva2DP5czNFZqI5u8CpYQd8AYg4A/DwZtKj0eUIJr9uh5e8aMU6" crossorigin="anonymous"></script>

</body>
</html>