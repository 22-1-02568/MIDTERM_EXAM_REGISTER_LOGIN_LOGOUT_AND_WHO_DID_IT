<?php
require_once 'dbConfig.php'; // Database connection
require_once 'models.php';   // Data handling functions

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle User Registration
    if (isset($_POST['createUserBtn'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (createAccount($pdo, $username, $password)) {
            $_SESSION['message'] = "Registration successful! Please log in.";
            header("Location: ../login.php");
            exit;
        } else {
            $_SESSION['message'] = "Registration failed. Try again.";
            header("Location: ../register.php");
            exit;
        }
    }

    // Handle User Login
    if (isset($_POST['loginUserBtn'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $user = loginUser($username, $password, $pdo);
        if ($user) {
            $_SESSION['username'] = $user['username']; // Set session variable with username
            $_SESSION['user_id'] = $user['user_id'];   // Set session variable with user ID
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['message'] = "Invalid login credentials.";
            header("Location: ../login.php");
            exit;
        }
    }

    // Handle Bartender Operations
    if (isset($_POST['addBartenderBtn'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $experience = (int)$_POST['experience'];
        $added_by = $_SESSION['username']; // Record who added the bartender

        if (addBartender($pdo, $fname, $lname, $experience, $added_by)) {
            $_SESSION['message'] = "Bartender added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add bartender.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['deleteBartenderBtn'])) {
        $bartenderID = (int)$_POST['bartenderID'];
        if (deleteBartender($pdo, $bartenderID)) {
            $_SESSION['message'] = "Bartender deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete bartender.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['editBartenderBtn'])) {
        $bartenderID = (int)$_POST['bartenderID'];
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $experience = (int)$_POST['experience'];
        $last_updated = date('Y-m-d H:i:s'); // Update timestamp

        if (updateBartender($pdo, $fname, $lname, $experience, $bartenderID, $last_updated)) {
            $_SESSION['message'] = "Bartender updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update bartender.";
        }
        header("Location: ../index.php");
        exit;
    }

    // Handle Customer Operations
    if (isset($_POST['addCustomerBtn'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $added_by = $_SESSION['username']; // Record who added the customer

        if (addCustomer($pdo, $fname, $lname, $phone, $email, $added_by)) {
            $_SESSION['message'] = "Customer added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add customer.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['deleteCustomerBtn'])) {
        $customerID = (int)$_POST['customerID'];
        if (deleteCustomer($pdo, $customerID)) {
            $_SESSION['message'] = "Customer deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete customer.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['editCustomerBtn'])) {
        $customerID = (int)$_POST['customerID'];
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $last_updated = date('Y-m-d H:i:s'); // Update timestamp

        if (updateCustomer($pdo, $fname, $lname, $phone, $email, $customerID, $last_updated)) {
            $_SESSION['message'] = "Customer updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update customer.";
        }
        header("Location: ../index.php");
        exit;
    }

    // Handle Order Operations
    if (isset($_POST['addOrderBtn'])) {
        $customerID = (int)$_POST['customerID'];
        $bartenderID = (int)$_POST['bartenderID'];
        $orderDetails = trim($_POST['orderDetails']);
        $orderStatus = trim($_POST['orderStatus']);
        $added_by = $_SESSION['username']; // Record who added the order

        if (addOrder($pdo, $customerID, $bartenderID, $orderDetails, $orderStatus, $added_by)) {
            $_SESSION['message'] = "Order added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add order.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['deleteOrderBtn'])) {
        $orderID = (int)$_POST['orderID'];
        if (deleteOrder($pdo, $orderID)) {
            $_SESSION['message'] = "Order deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete order.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['editOrderBtn'])) {
        $orderID = (int)$_POST['orderID'];
        $customerID = (int)$_POST['customerID'];
        $bartenderID = (int)$_POST['bartenderID'];
        $orderDetails = trim($_POST['orderDetails']);
        $orderStatus = trim($_POST['orderStatus']);
        $last_updated = date('Y-m-d H:i:s'); // Update timestamp

        if (editOrder($pdo, $orderID, $customerID, $bartenderID, $orderDetails, $orderStatus, $last_updated)) {
            $_SESSION['message'] = "Order updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update order.";
        }
        header("Location: ../index.php");
        exit;
    }
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session to log out
    header("Location: ../login.php");
    exit;
}
?>
