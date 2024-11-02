<?php 

require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if customerID is set in the URL
if (!isset($_GET['customerID'])) {
    die('Error: customerID is missing.');
}

$customerID = $_GET['customerID']; // Safe to access customerID
$getCustomerByID = getCustomerByID($pdo, $customerID);

// Check if data was returned
if (!$getCustomerByID) {
    die('Error: Customer not found.');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Link your styles here -->
</head>
<body>
    <h1>Bar Management System</h1>
    <br><br>
    <h2>Update Customer Information:</h2>
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customerID); ?>">

        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($getCustomerByID['fname']); ?>" required>
        <br><br>
        
        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($getCustomerByID['lname']); ?>" required>
        <br><br>
        
        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($getCustomerByID['email']); ?>" required>
        <br><br>
        
        <label for="phone">Phone</label>
        <input type="text" name="phone" value="<?php echo htmlspecialchars($getCustomerByID['phone']); ?>" required>
        <br><br>
        
        <label for="status">Status</label>
        <select name="status" required>
            <option value="" disabled>---</option>
            <option value="active" <?php echo ($getCustomerByID['status'] === 'active') ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo ($getCustomerByID['status'] === 'inactive') ? 'selected' : ''; ?>>Inactive</option>
        </select>
        <br><br>
        
        <input type="submit" value="Update" name="editCustomerBtn">
    </form>
</body>
</html>
