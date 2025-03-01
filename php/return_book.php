<?php
session_start();
include ('library_db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You need to be logged in to return books.';
    exit();
}

$user_id = $_SESSION['user_id'];
$loan_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM Loans WHERE id = $loan_id AND user_id = $user_id AND returned_date IS NULL";
$result = mysqli_query($mysqli, $sql);
$loan = mysqli_fetch_assoc($result);

if (!$loan) {
    echo 'Invalid loan record.';
    exit;
}

$return_date = date('Y-m-d');
$sql_update_loan = "UPDATE Loans SET returned_date = '$return_date' WHERE id = $loan_id";
if (mysqli_query($mysqli, $sql_update_loan)) {
    echo 'You have successfully returned the book.';
} else {
    echo 'Error returning the book.';
}
?>
