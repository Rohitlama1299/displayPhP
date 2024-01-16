<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "vendas";

// Connect to the database
$connection = new mysqli($servername, $username, $password, $database);

$user_id = "";
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

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['user_id'])) {
        header("Location: vendas.php");
        exit;
    }

    $id = $connection->real_escape_string($_GET['user_id']);

    // Read data from users table
    $userSql = "SELECT * FROM users WHERE user_id = $id";
    $userResult = $connection->query($userSql);
    $userRow = $userResult->fetch_assoc();

    if (!$userRow) {
        header("Location: vendas.php");
        exit;
    }

    $username = $userRow["username"];
    $email = $userRow["email"];
    $user_id = $userRow["user_id"];

    // Read data from orders table
    $orderSql = "SELECT * FROM orders WHERE user_id = $user_id";
    $orderResult = $connection->query($orderSql);
    $orderRow = $orderResult->fetch_assoc();

    if (!$orderRow) {
        header("Location: vendas.php");
        exit;
    }

    $order_id = $orderRow["order_id"];
    $total_amount = $orderRow["total_amount"];

    // Read data from order_items table
    $orderItemSql = "SELECT * FROM order_items WHERE order_id = $order_id";
    $orderItemResult = $connection->query($orderItemSql);
    $orderItemRow = $orderItemResult->fetch_assoc();

    if (!$orderItemRow) {
        header("Location: vendas.php");
        exit;
    }

    $product_name = $orderItemRow["product_name"];
    $quantity = $orderItemRow["quantity"];
    $price = $orderItemRow["price"];
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission for updating the data
    $id = $connection->real_escape_string($_POST['user_id']);
    $username = $connection->real_escape_string($_POST['username']);
    $email = $connection->real_escape_string($_POST['email']);
    $total_amount = $connection->real_escape_string($_POST['total_amount']);
    $order_id = $connection->real_escape_string($_POST['order_id']);
    $product_name = $connection->real_escape_string($_POST['product_name']);
    $quantity = $connection->real_escape_string($_POST['quantity']);
    $price = $connection->real_escape_string($_POST['price']);

    if (empty($username) || empty($email) || empty($total_amount) || empty($product_name) || empty($quantity) || empty($price)) {
        $errorMessage = "All the fields are required";
    } else {
    // Update data in users table
$updateUserSql = "UPDATE users SET username='$username', email='$email' WHERE user_id=$id";
$resultUser = $connection->query($updateUserSql);

if (!$resultUser) {
    $errorMessage = "Error updating user: " . $connection->error;
    // Add this line for debugging
    echo "Query: $updateUserSql";
    exit; // Stop execution to see the error
}

// Update data in orders table
$updateOrderSql = "UPDATE orders SET total_amount='$total_amount' WHERE order_id=$order_id";
$resultOrder = $connection->query($updateOrderSql);

if (!$resultOrder) {
    $errorMessage = "Error updating order: " . $connection->error;
    // Add this line for debugging
    echo "Query: $updateOrderSql";
    exit; // Stop execution to see the error
}

// Update data in order_items table
$updateOrderItemSql = "UPDATE order_items SET product_name='$product_name', quantity='$quantity', price='$price' WHERE order_id=$order_id";
$resultOrderItem = $connection->query($updateOrderItemSql);

if (!$resultOrderItem) {
    $errorMessage = "Error updating order item: " . $connection->error;
    // Add this line for debugging
    echo "Query: $updateOrderItemSql";
    exit; // Stop execution to see the error
}


        $successMessage = "Data updated successfully";
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
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Username</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="username" value="<?php echo $username; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Total_amount</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="total_amount" value="<?php echo $total_amount; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">item_order_id</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="order_id" value="<?php echo $order_id; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">product_name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="product_name" value="<?php echo $product_name; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">quantity</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="quantity" value="<?php echo $quantity; ?>">
                </div>
            </div>
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Price</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="price" value="<?php echo $price; ?>">
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
                header("Location: vendas.php");
                exit;
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
