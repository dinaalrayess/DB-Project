<?php
session_start();
include ('library_db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You need to be logged in.';
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM Books WHERE isbn = \"$book_id\" AND available = true;";
$result = mysqli_query($mysqli, $sql);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    echo 'Book is not available for borrowing.';
    exit;
}

$due_date = date('Y-m-d', strtotime('+7 days'));

$sql = "INSERT INTO Loans (user_id, book_isbn, checkout_date, due_date) VALUES ($user_id, \"$book_id\", CURDATE(), '$due_date')";
$result = mysqli_query($mysqli, $sql);

if ($result) {
    echo 'You have successfully borrowed the book. Due date: ' . $due_date;
} else {
    echo 'Error borrowing the book.';
}
?>

<a href="bookslist.php">Back to books list</a>
