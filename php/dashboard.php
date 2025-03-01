<?php
session_start();
require_once ('library_db.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>
<h2>Welcome to the Library System <?php echo get_user_full_name($mysqli, $_SESSION['user_id']) ?>!
<a href="bookslist.php">View Books</a> | <a href="logout.php">Logout</a>| <a href="return_book.php">Return Book</a>
