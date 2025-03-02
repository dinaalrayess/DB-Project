<?php
session_start();
include ('library_db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo 'You need to be an admin to access this page.';
    exit;
}

// check if post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_user'])) {
        $user_id = $_POST['delete_user'];
        $sql = 'DELETE FROM Users WHERE id = ?';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_book'])) {
        $isbn = $_POST['delete_book'];
        $sql = 'DELETE FROM Books WHERE isbn = ?';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', $isbn);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['delete_loan'])) {
        $loan_id = $_POST['delete_loan'];
        $sql = 'DELETE FROM Loans WHERE id = ?';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('i', $loan_id);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['create_user'])) {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];

        $sql = 'CALL InsertUser(?, ?, ?, ?, ?)';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('sssss', $first_name, $last_name, $email, $password, $role);
        $stmt->execute();
        $stmt->close();
    } elseif (isset($_POST['create_book'])) {
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $publication_date = $_POST['publication_date'];
        $publication_date = date('Y-m-d', strtotime($publication_date));

        // InsertBook procedure
        $sql = 'CALL InsertBook(?, ?, ?, ?)';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('ssss', $isbn, $title, $author, $publication_date);
        $stmt->execute();
        $stmt->close();
    }
    header('Location: admin.php');
    exit();
}

$sql_users = 'SELECT * FROM Users';
$result_users = mysqli_query($mysqli, $sql_users);

$sql_books = 'SELECT * FROM Books';
$result_books = mysqli_query($mysqli, $sql_books);

$sql_loans = 'SELECT * FROM Loans';
$result_loans = mysqli_query($mysqli, $sql_loans);
?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library System - Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <nav class="navbar bg-base-100 shadow-md">
    <div class="flex-1">
      <a class="btn btn-ghost normal-case text-xl" href="dashboard.php">Library System</a>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal px-1">
        <li><a href="bookslist.php">View Books</a></li>
        <li><a href="return_book.php">Return Book</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li>
          <!-- Theme Toggle -->
          <label class="swap swap-rotate">
            <input type="checkbox" id="theme-toggle" />
            <svg class="swap-off h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
            </svg>
            <svg class="swap-on h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
            </svg>
          </label>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mx-auto my-8 px-12">

    <div class="overflow-x-auto">
      <h2 class="text-2xl font-bold mb-4">Users</h2>
      <table class="table table-compact w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = mysqli_fetch_assoc($result_users)): ?>
            <tr>
              <td><?php echo htmlspecialchars($user['id']); ?></td>
              <td><?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></td>
              <td><?php echo htmlspecialchars($user['email']); ?></td>
              <td><?php echo htmlspecialchars($user['role']); ?></td>
              <td>
                <form method="post">
                  <input type="hidden" name="delete_user" value="<?php echo $user['id']; ?>">
                  <button type="submit" class="btn btn-error btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="mt-8">
      <h2 class="text-2xl font-bold mb-4">Create User</h2>
      <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-control">
          <input type="text" name="first_name" placeholder="First Name" class="input input-bordered" required>
        </div>
        <div class="form-control">
          <input type="text" name="last_name" placeholder="Last Name" class="input input-bordered" required>
        </div>
        <div class="form-control">
          <input type="email" name="email" placeholder="Email" class="input input-bordered" required>
        </div>
        <div class="form-control">
          <input type="password" name="password" placeholder="Password" class="input input-bordered" required>
        </div>
        <div class="form-control">
          <select name="role" class="select select-bordered" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
          </select>
        </div>
        <div class="form-control">
          <button type="submit" name="create_user" class="btn btn-primary">Create User</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto mt-8">
      <h2 class="text-2xl font-bold mb-4">Books</h2>
      <table class="table table-compact w-full">
        <thead>
          <tr>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
            <th>Available</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($book = mysqli_fetch_assoc($result_books)): ?>
            <tr>
              <td><?php echo htmlspecialchars($book['isbn']); ?></td>
              <td><?php echo htmlspecialchars($book['title']); ?></td>
              <td><?php echo htmlspecialchars($book['author']); ?></td>
              <td><?php echo $book['available'] ? 'Yes' : 'No'; ?></td>
              <td>
                <form method="post">
                  <input type="hidden" name="delete_book" value="<?php echo $book['isbn']; ?>">
                  <button type="submit" class="btn btn-error btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>

    <div class="mt-8">
      <h2 class="text-2xl font-bold mb-4">Create Book</h2>
      <form method="post" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-control">
          <input type="text" name="isbn" placeholder="ISBN" class="input input-bordered" required>
        </div>
        <div class="form-control">
          <input type="text" name="title" placeholder="Title" class="input input-bordered" required>
        </div>
        <div class="form-control">
          <input type="text" name="author" placeholder="Author" class="input input-bordered" required>
        </div>
        <div class="form-control">
          <input type="date" name="publication_date" placeholder="Publication Date" class="input input-bordered" required>
        </div>
        <div class="form-control col-span-1 md:col-span-2">
          <button type="submit" name="create_book" class="btn btn-primary">Create Book</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto mt-8">
      <h2 class="text-2xl font-bold mb-4">Loans</h2>
      <table class="table table-compact w-full">
        <thead>
          <tr>
            <th>Loan ID</th>
            <th>User ID</th>
            <th>Book ISBN</th>
            <th>Checkout Date</th>
            <th>Due Date</th>
            <th>Return Date</th>
            <th>Returned</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($loan = mysqli_fetch_assoc($result_loans)): ?>
            <tr>
              <td><?php echo htmlspecialchars($loan['id']); ?></td>
              <td><?php echo htmlspecialchars($loan['user_id']); ?></td>
              <td><?php echo htmlspecialchars($loan['book_isbn']); ?></td>
              <td><?php echo htmlspecialchars($loan['checkout_date']); ?></td>
              <td><?php echo htmlspecialchars($loan['due_date']); ?></td>
              <td><?php echo empty($loan['returned_date']) ? 'NULL' : htmlspecialchars($loan['returned_date']); ?></td>
              <td><?php echo $loan['returned_date'] ? 'Yes' : 'No'; ?></td>
              <td>
                <form method="post">
                  <input type="hidden" name="delete_loan" value="<?php echo $loan['id']; ?>">
                  <button type="submit" class="btn btn-error btn-sm">Delete</button>
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
          <script defer>
    const themeToggle = document.getElementById('theme-toggle');

    // Check if a theme preference is stored
    const storedTheme = localStorage.getItem('theme');
    if (storedTheme) {
      document.documentElement.setAttribute('data-theme', storedTheme);
      if (storedTheme === 'dark') {
        themeToggle.checked = true;
      }
    }

    themeToggle.addEventListener('change', () => {
      if (themeToggle.checked) {
        document.documentElement.setAttribute('data-theme', 'dark');
        localStorage.setItem('theme', 'dark');
      } else {
        document.documentElement.setAttribute('data-theme', 'light');
        localStorage.setItem('theme', 'light');
      }
    });
  </script>
</body>
</html>
