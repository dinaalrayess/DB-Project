<?php
session_start();
include('library_db.php');

$search_query = '';
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($mysqli, $_POST['search']); 
}


$sql = "SELECT * FROM books WHERE available = '1'";

if (!empty($search_query)) {
    
    $sql .= " AND (title LIKE '%$search_query%' OR author LIKE '%$search_query%')";
}

$result = mysqli_query($mysqli, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Books Listing</title>
</head>
<body>
    <h1>Available Books</h1>

    
    <form method="post" action="">
        <input type="text" name="search" placeholder="Search by title or author" value="<?php echo htmlspecialchars($search_query); ?>">
        <button type="submit">Search</button>
    </form>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<ul>';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<li>';
            echo '<a href="book_details.php?id=' . $row['id'] . '">' . $row['title'] . '</a>';
            echo ' - <a href="borrow.php?id=' . $row['id'] . '">Borrow</a>';
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo "No books found matching your search.";
    }
    ?>

</body>
</html>
