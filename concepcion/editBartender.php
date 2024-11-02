<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Retrieve the bartender ID from the URL
$bartenderID = $_GET['bartenderID'];

// Fetch the bartender data using the ID
$getBartenderByID = getBartenderByID($pdo, $bartenderID);

// Check if bartender data was found
if (!$getBartenderByID) {
    echo "Bartender not found.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Bartender</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Link your styles here -->
</head>
<body>
    <h1>Bar Management System</h1>
    <br><br>
    <h2>Update Bartender Information:</h2>
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="bartenderID" value="<?php echo htmlspecialchars($bartenderID); ?>">
        
        <label for="fname">First Name</label>
        <input type="text" name="fname" value="<?php echo htmlspecialchars($getBartenderByID['fname']); ?>" required>
        <br><br>

        <label for="lname">Last Name</label>
        <input type="text" name="lname" value="<?php echo htmlspecialchars($getBartenderByID['lname']); ?>" required>
        <br><br>

        <label for="experience">Years of Experience</label>
        <input type="number" name="experience" value="<?php echo htmlspecialchars($getBartenderByID['experience']); ?>" required>
        <br><br>

        <input type="submit" value="Update" name="updateBartenderBtn">
    </form>
</body>
</html>
