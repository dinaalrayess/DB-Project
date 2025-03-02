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
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library System - Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="hero min-h-screen bg-base-200">
    <div class="hero-content flex-col lg:flex-row-reverse">
      <div class="text-center lg:text-left">
        <h1 class="text-5xl font-bold text-center">Welcome to the Library System!</h1>
        <p class="py-6 text-center">Please log in to access the library features.</p>
        <div class="divider"></div>
        <p>Already have an account? <a href="login.php" class="link link-primary">Login</a></p>
      </div>
      <div class="card flex-shrink-0 w-full max-w-sm shadow-2xl bg-base-100">
        <div class="card-body">
          <form action="signup.php" method="POST">
            <div class="form-control">
              <label class="label">
                <span class="label-text">First Name</span>
              </label>
              <input type="text" name="first_name" placeholder="First name" class="input input-bordered" required>
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Last Name</span>
              </label>
              <input type="text" name="last_name" placeholder="Last name" class="input input-bordered" required>
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Email</span>
              </label>
              <input type="email" name="email" placeholder="Email" class="input input-bordered" required>
            </div>
            <div class="form-control">
              <label class="label">
                <span class="label-text">Password</span>
              </label>
              <input type="password" name="password" placeholder="Password" class="input input-bordered" required>
            </div>
            <div class="form-control mt-6">
              <button class="btn btn-primary">Sign Up</button>
            </div>
          </form>
          <?php if (isset($error)) echo "<p class='text-error'>$error</p>"; ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
