<?php
session_start(); // Ensure session is started

require_once 'core/dbConfig.php';
require_once 'core/models.php'; // Include your models

$message = ''; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $addedBy = $_SESSION['username']; // Assuming the username is stored in the session after login

    // Validate input data
    if (!empty($fname) && !empty($lname) && !empty($phone) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Call the function to add the customer with 6 parameters
        if (addCustomer($pdo, $fname, $lname, $phone, $email, $addedBy)) {
            $message = "Customer added successfully!";
        } else {
            $message = "Failed to add customer.";
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
    <title>Add Customer</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
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
        h1 {
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
        input[type="text"], input[type="tel"], input[type="email"] {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5cb85c;
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
            background-color: #4cae4c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Customer</h1>
        <?php if ($message): ?>
            <p class="alert"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required>
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required>
            
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <button type="submit">Add Customer</button>
        </form>
        <button><a href="index.php">Back</a></button>
    </div>
</body>
</html>
