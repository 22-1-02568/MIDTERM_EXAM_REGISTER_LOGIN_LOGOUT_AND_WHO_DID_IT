<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Fetch customers and bartenders for dropdown selection
$customers = getAllCustomers($pdo);
$bartenders = getAllBartenders($pdo);
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data and sanitize
    $customerID = trim($_POST['customerID']);
    $orderDetails = trim($_POST['drinkID']);  // Keeping this to reflect order details
    $orderStatus = trim($_POST['orderStatus']);
    $bartenderID = trim($_POST['bartenderID']);

    // Validate input data
    if (!empty($customerID) && !empty($orderDetails) && !empty($orderStatus) && !empty($bartenderID)) {
        // Set addedBy as the session's username if available
        $addedBy = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown';

        // Call the function to add the order
        if (addOrder($pdo, $customerID, $bartenderID, $orderDetails, $orderStatus, $addedBy)) {
            $message = "Order added successfully!";
        } else {
            // Capture and log the SQL error
            error_log(print_r($pdo->errorInfo(), true)); // Log the error
            $message = "Failed to add order. Please try again.";
        }
    } else {
        $message = "Please fill in all fields correctly.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Order</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1, h2 {
            color: #34495e;
        }
        .alert {
            color: red;
            margin-bottom: 20px;
        }
        label {
            margin-top: 10px;
            display: block;
        }
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #f39c12;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button a {
            color: white;
            text-decoration: none;
        }
        button:hover {
            background-color: #e67e22;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bar Management System</h1>
        <h2>Add New Order</h2>
        <?php if ($message): ?>
            <p class="alert"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form action="" method="POST">
            <label for="customerID">Customer:</label>
            <select name="customerID" required>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?php echo htmlspecialchars($customer['customerID']); ?>">
                        <?php echo htmlspecialchars($customer['fname'] . ' ' . $customer['lname']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="drinkID">Drink:</label>
            <select name="drinkID" required>
                <option value="Coke">Coke</option>
                <option value="Sprite">Sprite</option>
                <option value="Lemonade">Lemonade</option>
                <option value="Water">Water</option>
                <!-- Add more drinks as needed -->
            </select>

            <label for="bartenderID">Bartender:</label>
            <select name="bartenderID" required>
                <?php foreach ($bartenders as $bartender): ?>
                    <option value="<?php echo htmlspecialchars($bartender['bartenderID']); ?>">
                        <?php echo htmlspecialchars($bartender['fname'] . ' ' . $bartender['lname']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="orderStatus">Order Status:</label>
            <select name="orderStatus" required>
                <option value="Pending">Pending</option>
                <option value="Completed">Completed</option>
            </select>
            
            <input type="submit" value="Add Order" name="addOrderBtn">
        </form>
        <button><a href="index.php">Back</a></button>
    </div>
</body>
</html>
