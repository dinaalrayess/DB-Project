<?php

require ('library_db.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        echo 'All fields are required!';
    } else {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $sql = 'CALL InsertUser(?, ?, ?, ?, "user")';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssss', $first_name, $last_name, $email, $password);

        if ($stmt->execute()) {
            header('Location: login.php');
            exit();
        } else {
            echo 'Error registering user!';
        }
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

        <label>Password:</label>
        <input type="password" name="password" required><br>


        <button type="submit">Sign Up</button>
    </form>
    <p>Already have an account? Login <a href="login.php">here</a></p>
</body>
</html>

