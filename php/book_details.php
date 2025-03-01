<?php
session_start();
include ('library_db.php');

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    $stmt = $mysqli->prepare('SELECT * FROM Books WHERE isbn = ?');
    $stmt->bind_param('i', $book_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $book = $result->fetch_assoc();

    if (!$book) {
        echo 'Book not found!';
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Book Details</title>
</head>
<body>
<h1>Book Details</h1>
    <p><strong>Title:</strong> <?php echo htmlspecialchars($book['title']); ?></p>
    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
    <p><strong>Publication Date:</strong> <?php echo htmlspecialchars($book['publication_date']); ?></p>
    <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book['isbn']); ?></p>
    <p><strong>Status:</strong> <?php echo $book['available'] ? 'Available' : 'Not Available'; ?></p>

    <?php if ($book['available']): ?>
        <a href="borrow.php?id=<?php echo $book['isbn']; ?>">Borrow this book</a>
    <?php else: ?>
        <p>This book is currently unavailable.</p>
    <?php endif; ?>
</body>
</html>
