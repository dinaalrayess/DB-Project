<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<h2>Welcome to the Library System</h2>
<a href="bookslist.php">View Books</a> | <a href="logout.php">Logout</a>| <a href="return_book.php">Return Book</a>
