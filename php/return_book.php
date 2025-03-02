<?php
session_start();
include ('library_db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You need to be logged in to return books.';
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['id'])) {
        echo 'Invalid request.';
        exit();
    }

    $loan_id = $_POST['id'];
    $return_date = date('Y-m-d');
    $sql_update_loan = 'UPDATE Loans SET returned_date = ? WHERE id = ? AND user_id = ?;';
    $stmt = mysqli_prepare($mysqli, $sql_update_loan);
    mysqli_stmt_bind_param($stmt, 'sii', $return_date, $loan_id, $user_id);
    mysqli_stmt_execute($stmt);

    $message = 'You have returned the book successfully.';
}

$sql = 'SELECT Books.isbn, Books.title, Books.author, Loans.id FROM Loans JOIN Books ON Loans.book_isbn = Books.isbn
        WHERE Loans.user_id = ? AND Loans.returned_date is NULL ';
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'i', $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Book</title>
</head>
<body>
    <h1>Return Books </h1>
    <?php if (isset($message)) {
        echo $message;
    } ?>
    <h2>Books You Borrowed: </h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <li>
            <?php echo htmlspecialchars($row['title']); ?>
            <form action ="return_book.php" method="post">
                <input type = "hidden" name = "id" value = "<?php echo $row['id']; ?>">
                <button type = "submit">Return</button>
            </form>
        </li>
        <?php endwhile; ?>
    </ul>
        <?php else: ?>
            <p> No Books are Borrowed. </p>
        <?php endif; ?>
</body>
</html>
