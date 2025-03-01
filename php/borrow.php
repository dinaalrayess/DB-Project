<?php
session_start();
include('library_db.php');


if (!isset($_SESSION['user_id'])) {
    echo "You need to be logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];
$book_id = isset($_GET['id']) ? $_GET['id'] : 0;


$sql = "SELECT * FROM books WHERE id = $book_id AND available = 1";
$result = mysqli_query($mysqli, $sql);
$book = mysqli_fetch_assoc($result);

if (!$book) {
    echo "Book is not available for borrowing.";
    exit;
}


$due_date = date('Y-m-d', strtotime('+7 days'));


$sql = "INSERT INTO loans (user_id, book_id, checkout_date, due_date) VALUES ($user_id, $book_id, CURDATE(), '$due_date')";
if (mysqli_query($library_db, $sql)) {
    
    $sql_update = "UPDATE books SET available = 0 WHERE id = $book_id";
    mysqli_query($mysqli, $sql_update);
    echo "You have successfully borrowed the book. Due date: " . $due_date;
} else {
    echo "Error borrowing the book.";
}
?>
