<?php

require("library_db.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $email = $_POST["email"];
    $role = $_POST["role"];
    $password = $_POST["password"];
    

    
    if (empty($first_name) || empty($last_name) || empty($email)  || empty($role) || empty($password)) {
        echo "All fields are required!";
    } 

            $stmt = $mysqli->prepare("INSERT INTO Users (first_name, last_name, email, role, password) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $first_name, $last_name, $email, $role, $password);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                echo "Error registering user!";
            }
        }
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>
<body>
    <h2>Library Sign Up</h2>
    <form action="signup.php" method="POST">
        <label>First Name:</label>
        <input type="text" name="first_name" required><br>

        <label>Last Name:</label>
        <input type="text" name="last_name" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Role:</label>
        <select name="role" required>
            <option value="user">Student</option>
            <option value="admin">Admin</option>
        </select><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>


        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>

