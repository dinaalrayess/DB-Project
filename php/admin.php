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
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
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
        $available = $_POST['available'];
        $publication_date = $_POST['publication_date'];

        // InsertBook procedure
        $sql = 'CALL InsertBook
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('sssi', $isbn, $title, $author, $available);
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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <h2>Users</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Delete</th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($result_users)): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="delete_user" value="<?php echo $user['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

        <h2>Create User</h2>
        <form method="post">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <select name="role" required>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
            <button type="submit" name="create_user">Create User</button>
        </form>

    <h2>Books</h2>
    <table>
        <tr>
            <th>ISBN</th>
            <th>Title</th>
            <th>Author</th>
                <th>Available</th>
                <th>Delete</th>
        </tr>
        <?php while ($book = mysqli_fetch_assoc($result_books)): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo $book['available'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="delete_book" value="<?php echo $book['isbn']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Loans</h2>
    <table>
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
        <?php while ($loan = mysqli_fetch_assoc($result_loans)): ?>
            <tr>
                <td><?php echo htmlspecialchars($loan['id']); ?></td>
                <td><?php echo htmlspecialchars($loan['user_id']); ?></td>
                <td><?php echo htmlspecialchars($loan['book_isbn']); ?></td>
                <td><?php echo htmlspecialchars($loan['checkout_date']); ?></td>
                <td><?php echo htmlspecialchars($loan['due_date']); ?></td>
                <td><?php echo htmlspecialchars($loan['returned_date']); ?></td>
                <td><?php echo $loan['returned_date'] ? 'Yes' : 'No'; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="delete_loan" value="<?php echo $loan['id']; ?>">
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
