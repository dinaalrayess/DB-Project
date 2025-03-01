<?php
session_start();
include ('library_db.php');

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    echo 'You need to be an admin to access this page.';
    exit;
}

$sql_users = 'SELECT * FROM users';
$result_users = mysqli_query($mysqli, $sql_users);

$sql_books = 'SELECT * FROM books';
$result_books = mysqli_query($mysqli, $sql_books);

$sql_loans = 'SELECT * FROM loans WHERE returned_date IS NULL';
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
            <th>Active</th>
        </tr>
        <?php while ($user = mysqli_fetch_assoc($result_users)): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['first_name']) . ' ' . htmlspecialchars($user['last_name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td><?php echo htmlspecialchars($user['role']); ?></td>
                <td><?php echo $user['active'] ? 'Yes' : 'No'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Books</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Author</th>
            <th>ISBN</th>
            <th>Available</th>
        </tr>
        <?php while ($book = mysqli_fetch_assoc($result_books)): ?>
            <tr>
                <td><?php echo htmlspecialchars($book['id']); ?></td>
                <td><?php echo htmlspecialchars($book['title']); ?></td>
                <td><?php echo htmlspecialchars($book['author']); ?></td>
                <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                <td><?php echo $book['available'] ? 'Yes' : 'No'; ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Loans</h2>
    <table>
        <tr>
            <th>Loan ID</th>
            <th>User ID</th>
            <th>Book ID</th>
            <th>Checkout Date</th>
            <th>Due Date</th>
        </tr>
        <?php while ($loan = mysqli_fetch_assoc($result_loans)): ?>
            <tr>
                <td><?php echo htmlspecialchars($loan['id']); ?></td>
                <td><?php echo htmlspecialchars($loan['user_id']); ?></td>
                <td><?php echo htmlspecialchars($loan['book_id']); ?></td>
                <td><?php echo htmlspecialchars($loan['checkout_date']); ?></td>
                <td><?php echo htmlspecialchars($loan['due_date']); ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

</body>
</html>
