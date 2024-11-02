<?php

include_once 'dbConfig.php';

session_start(); // Start the session to manage session data

// Define the queries to reset the bartender, customer, and order data
$deleteBartendersQuery = "DELETE FROM bartenders";
$resetBartenderIncrementQuery = "ALTER TABLE bartenders AUTO_INCREMENT = 1";
$deleteCustomersQuery = "DELETE FROM customers";
$resetCustomerIncrementQuery = "ALTER TABLE customers AUTO_INCREMENT = 1";
$deleteOrdersQuery = "DELETE FROM orders";
$resetOrderIncrementQuery = "ALTER TABLE orders AUTO_INCREMENT = 1";

try {
    // Prepare the deletion and reset statements
    $deleteBartendersStmt = $pdo->prepare($deleteBartendersQuery);
    $resetBartenderIncrementStmt = $pdo->prepare($resetBartenderIncrementQuery);
    $deleteCustomersStmt = $pdo->prepare($deleteCustomersQuery);
    $resetCustomerIncrementStmt = $pdo->prepare($resetCustomerIncrementQuery);
    $deleteOrdersStmt = $pdo->prepare($deleteOrdersQuery);
    $resetOrderIncrementStmt = $pdo->prepare($resetOrderIncrementQuery);

    // Execute the queries
    $deleteBartenders = $deleteBartendersStmt->execute();
    $resetBartenderIncrement = $resetBartenderIncrementStmt->execute();
    $deleteCustomers = $deleteCustomersStmt->execute();
    $resetCustomerIncrement = $resetCustomerIncrementStmt->execute();
    $deleteOrders = $deleteOrdersStmt->execute();
    $resetOrderIncrement = $resetOrderIncrementStmt->execute();

    // Check if all queries were successful
    if ($deleteBartenders && $resetBartenderIncrement && $deleteCustomers && $resetCustomerIncrement && $deleteOrders && $resetOrderIncrement) {
        session_unset(); // Clear session variables
        session_destroy(); // Destroy the session
        header('Location: ../index.php'); // Redirect to homepage
        exit(); // Stop further script execution after redirect
    } else {
        $_SESSION['error_message'] = "Error occurred while resetting data. Please try again.";
        header('Location: ../error.php'); // Redirect to an error page (optional)
        exit();
    }
} catch (PDOException $e) {
    // Log the error and set a session message for the user
    error_log("Database error in unset.php: " . $e->getMessage());
    $_SESSION['error_message'] = "Database error occurred. Please contact support.";
    header('Location: ../error.php'); // Redirect to an error page (optional)
    exit();
}
?>
