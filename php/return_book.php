<?php
session_start();
include ('library_db.php');

if (!isset($_SESSION['user_id'])) {
    echo 'You need to be logged in to return books.';
    exit();
}

$user_id = $_SESSION['user_id'];
$loan_id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT books.isbn, books.title, books.author, loans.id FROM Loans JOIN books ON loans.book_isbn = books.isbn
        WHERE loans.user_id = ? AND loans.returned_date is NULL ";
$stmt = mysqli_prepare($mysqli , $sql);
 mysqli_stmt_bind_param($stmt,"i",$loan_id );
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$loan = mysqli_fetch_assoc($result);

if (!$loan) {
    echo 'Invalid loan record.';
    exit();
}

$return_date = date('Y-m-d');
$sql_update_loan = "UPDATE Loans SET returned_date = ? WHERE id = ? AND books_isbn = ?";
$stmt = mysqli_prepare($mysqli , $sql_update_loan);
mysqli_stmt_bind_param($stmt,"sii",$return_date, $loan_id, $book_isbn);
mysqli_stmt_execute($stmt);

$message = "You have returned the book successfully.";

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
    <?php if (isset($message)){
        echo $message;} ?> 
    <h2>Books You Borrowed: </h2>
    <?php if ($result->num_rows > 0): ?>
        <ul>
    <?php while($row = mysqli_fetch_assoc($result)): ?>
        <li>
            <?php echo htmlspecialchars($row['title']); ?>
            <form action ="return_book.php" method = "POST">
                <input type = "hidden" name = "loan_id" value = "<?php echo $row['loan_id'];?>">
                <input type = "hidden" name = "return_book_id" value ="<?php echo $row['id'];?>">
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