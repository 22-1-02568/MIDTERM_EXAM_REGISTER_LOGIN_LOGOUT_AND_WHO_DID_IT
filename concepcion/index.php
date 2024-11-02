<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Display any messages stored in the session
if (isset($_SESSION['message'])) {
    echo "<div class='alert'>" . htmlspecialchars($_SESSION['message']) . "</div>";
    unset($_SESSION['message']); // Clear the message after displaying
}

// Fetch all bartenders, customers, and orders
$allBartenders = getAllBartenders($pdo);
$allCustomers = getAllCustomers($pdo);
$allOrders = getAllOrders($pdo); // Ensure this retrieves the correct data
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bar Management System</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Optional styles for tables */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #34495e;
        }
        .alert {
            color: red;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #34495e;
            color: #ecf0f1;
        }
        .button {
            padding: 5px 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
        .button.edit {
            background-color: #007bff;
        }
        .button.delete {
            background-color: #d9534f;
        }
        .button:hover {
            opacity: 0.9;
        }
        .action-buttons {
            margin-top: 20px;
        }
        .action-buttons .button {
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bar Management System</h1>

        <!-- User Greeting and Logout Button -->
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h2>
        <a class="button" href="core/handleForms.php?logout=1">Logout</a>

        <div class="sections-container">

            <!-- Display Bartenders Section -->
            <section class="section bartenders-section">
                <h2>Bartenders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Experience</th>
                            <th>Added By</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allBartenders as $bartender): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($bartender['fname']); ?></td>
                            <td><?php echo htmlspecialchars($bartender['lname']); ?></td>
                            <td><?php echo htmlspecialchars($bartender['experience']); ?></td>
                            <td><?php echo htmlspecialchars($bartender['added_by']); ?></td>
                            <td><?php echo htmlspecialchars($bartender['last_updated']); ?></td>
                            <td>
                                <a class="button edit" href="editbartender.php?bartenderID=<?php echo urlencode($bartender['bartenderID']); ?>">Edit</a>
                                <form action="core/handleForms.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="bartenderID" value="<?php echo htmlspecialchars($bartender['bartenderID']); ?>">
                                    <input class="button delete" type="submit" name="deleteBartenderBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this bartender?');">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <!-- Display Customers Section -->
            <section class="section customers-section">
                <h2>Customers</h2>
                <table>
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Added By</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($allCustomers as $customer): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($customer['fname']); ?></td>
                            <td><?php echo htmlspecialchars($customer['lname']); ?></td>
                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                            <td><?php echo htmlspecialchars($customer['phone']); ?></td>
                            <td><?php echo htmlspecialchars($customer['added_by']); ?></td>
                            <td><?php echo htmlspecialchars($customer['last_updated']); ?></td>
                            <td>
                                <a class="button edit" href="editcustomer.php?customerID=<?php echo urlencode($customer['customerID']); ?>">Edit</a>
                                <form action="core/handleForms.php" method="POST" style="display:inline;">
                                    <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customer['customerID']); ?>">
                                    <input class="button delete" type="submit" name="deleteCustomerBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this customer?');">
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </section>

            <!-- Display Orders Section -->
            <section class="section orders-section">
                <h2>Orders</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer Name</th>
                            <th>Drink</th>
                            <th>Order Status</th>
                            <th>Added By</th>
                            <th>Last Updated</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($allOrders) > 0): ?>
                            <?php foreach ($allOrders as $order): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['orderID']); ?></td>
                                <td><?php echo htmlspecialchars($order['customerName']); ?></td>
                                <td><?php echo htmlspecialchars($order['orderDetails']); ?></td>
                                <td><?php echo htmlspecialchars($order['orderStatus']); ?></td>
                                <td><?php echo htmlspecialchars($order['added_by']); ?></td>
                                <td><?php echo htmlspecialchars($order['last_updated']); ?></td>
                                <td>
                                    <a class="button edit" href="editorder.php?orderID=<?php echo urlencode($order['orderID']); ?>">Edit</a>
                                    <form action="core/handleForms.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($order['orderID']); ?>">
                                        <input class="button delete" type="submit" name="deleteOrderBtn" value="Delete" onclick="return confirm('Are you sure you want to delete this order?');">
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7">No orders found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>

        </div>

        <!-- Action Buttons -->
        <div class="action-buttons">
            <a class="button add" href="addbartender.php">Add Bartender</a>
            <a class="button add" href="addcustomer.php">Add Customer</a>
            <a class="button add" href="addorder.php">Add Order</a>
            <a class="button" href="core/unset.php">Reset</a>
        </div>
    </div>
</body>
</html>
