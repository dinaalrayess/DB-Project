<?php
session_start();
include ('library_db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You need to be logged in.';
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = 'SELECT * FROM AvailableBooks WHERE isbn = ?;';
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 's', $book_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    echo 'Book is not available for borrowing.';
    exit;
}

$due_date = date('Y-m-d', strtotime('+7 days'));

$sql = 'CALL InsertLoan(?, ?, CURDATE(), ?)';
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, 'iss', $user_id, $book_id, $due_date);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo 'You have successfully borrowed the book. Due date: ' . $due_date;
} else {
    echo 'Error borrowing the book.';
}
?>

<a href="bookslist.php">Back to books list</a>
