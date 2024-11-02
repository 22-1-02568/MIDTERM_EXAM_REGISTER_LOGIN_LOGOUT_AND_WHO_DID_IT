<?php
session_start();
require_once 'core/models.php';
require_once 'core/dbConfig.php';

// Display any session message if available
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register - Bar Management System</title>
   <style>
       body {
           font-family: Arial, sans-serif;
           background-color: #f4f4f9;
           display: flex;
           justify-content: center;
           align-items: center;
           height: 100vh;
           margin: 0;
       }
       .container {
           background-color: #fff;
           padding: 20px;
           border-radius: 8px;
           box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
           width: 100%;
           max-width: 400px;
           text-align: center;
       }
       h1 {
           color: #333;
       }
       h2 {
           color: #555;
       }
       .message {
           color: #e74c3c;
           font-size: 16px;
           margin-bottom: 15px;
       }
       form {
           display: flex;
           flex-direction: column;
           gap: 10px;
       }
       input[type="text"],
       input[type="password"] {
           padding: 10px;
           font-size: 16px;
           border: 1px solid #ccc;
           border-radius: 4px;
           width: 95%;
       }
       input[type="submit"] {
           padding: 10px;
           font-size: 16px;
           color: #fff;
           background-color: #e67e22;
           border: none;
           border-radius: 4px;
           cursor: pointer;
           transition: background-color 0.3s ease;
       }
       input[type="submit"]:hover {
           background-color: #d35400;
       }
       p {
           font-size: 14px;
       }
       a {
           color: #3498db;
           text-decoration: none;
       }
       a:hover {
           text-decoration: underline;
       }
   </style>
</head>
<body>
   <div class="container">
       <h1>Bar Management System</h1>
       <p>Join our system to manage your bar operations</p>
       <br>

       <?php if ($message): ?>
           <p class="message"><?php echo htmlspecialchars($message); ?></p>
       <?php endif; ?>

       <form action="core/handleForms.php" method="POST">
           <h2>Create Your Account</h2>
           <label for="username">Username</label>
           <input type="text" name="username" id="username" required>
           <label for="password">Password</label>
           <input type="password" name="password" id="password" required>
           <input type="submit" name="createUserBtn" value="Register">
       </form>
       <p>Already have an account? <a href="login.php">Login here</a>.</p>
   </div>
</body>
</html>
