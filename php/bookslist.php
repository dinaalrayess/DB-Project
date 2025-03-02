<?php
session_start();
include ('library_db.php');

$search_query = '';
if (isset($_POST['search'])) {
    $search_query = $_POST['search'];
}

$sql = 'SELECT * FROM AvailableBooks';

if (empty($search_query)) {
    $stmt = mysqli_prepare($mysqli, $sql);
} else {
    $sql .= ' WHERE title LIKE ? OR author LIKE ?';
    $search = '%' . $_POST['search'] . '%';
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $search, $search);
}

$stmt->execute();
$result = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library System - Books</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@2.51.6/dist/full.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <nav class="navbar bg-base-100 shadow-md">
    <div class="flex-1">
      <a class="btn btn-ghost normal-case text-xl" href="dashboard.php">Library System</a>
    </div>
    <div class="flex-none">
      <ul class="menu menu-horizontal px-1">
        <li><a href="bookslist.php">View Books</a></li>
        <li><a href="return_book.php">Return Book</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li>
          <!-- Theme Toggle -->
          <label class="swap swap-rotate">
            <input type="checkbox" id="theme-toggle" />
            <svg class="swap-off h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M5.64,17l-.71.71a1,1,0,0,0,0,1.41,1,1,0,0,0,1.41,0l.71-.71A1,1,0,0,0,5.64,17ZM5,12a1,1,0,0,0-1-1H3a1,1,0,0,0,0,2H4A1,1,0,0,0,5,12Zm7-7a1,1,0,0,0,1-1V3a1,1,0,0,0-2,0V4A1,1,0,0,0,12,5ZM5.64,7.05a1,1,0,0,0,.7.29,1,1,0,0,0,.71-.29,1,1,0,0,0,0-1.41l-.71-.71A1,1,0,0,0,4.93,6.34Zm12,.29a1,1,0,0,0,.7-.29l.71-.71a1,1,0,1,0-1.41-1.41L17,5.64a1,1,0,0,0,0,1.41A1,1,0,0,0,17.66,7.34ZM21,11H20a1,1,0,0,0,0,2h1a1,1,0,0,0,0-2Zm-9,8a1,1,0,0,0-1,1v1a1,1,0,0,0,2,0V20A1,1,0,0,0,12,19ZM18.36,17A1,1,0,0,0,17,18.36l.71.71a1,1,0,0,0,1.41,0,1,1,0,0,0,0-1.41ZM12,6.5A5.5,5.5,0,1,0,17.5,12,5.51,5.51,0,0,0,12,6.5Zm0,9A3.5,3.5,0,1,1,15.5,12,3.5,3.5,0,0,1,12,15.5Z" />
            </svg>
            <svg class="swap-on h-6 w-6 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
              <path d="M21.64,13a1,1,0,0,0-1.05-.14,8.05,8.05,0,0,1-3.37.73A8.15,8.15,0,0,1,9.08,5.49a8.59,8.59,0,0,1,.25-2A1,1,0,0,0,8,2.36,10.14,10.14,0,1,0,22,14.05,1,1,0,0,0,21.64,13Zm-9.5,6.69A8.14,8.14,0,0,1,7.08,5.22v.27A10.15,10.15,0,0,0,17.22,15.63a9.79,9.79,0,0,0,2.1-.22A8.11,8.11,0,0,1,12.14,19.73Z" />
            </svg>
          </label>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container mx-auto my-8 px-4">
    <h1 class="text-4xl font-bold mb-8">Available Books</h1>

    <form method="post" action="" class="mb-8">
      <div class="form-control">
        <div class="input-group">
          <input type="text" name="search" placeholder="Search by title or author" value="<?php echo htmlspecialchars($search_query); ?>" class="input input-bordered" />
          <button type="submit" class="btn btn-square">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
          </button>
        </div>
      </div>
    </form>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="card bg-base-100 shadow-xl">';
            echo '<div class="card-body">';
            echo '<h2 class="card-title">' . $row['title'] . '</h2>';
            echo '<p>Author: ' . $row['author'] . '</p>';
            echo '<p>Publication Date: ' . $row['publication_date'] . '</p>';
            echo '<div class="card-actions justify-end">';
            echo '<a href="book_details.php?id=' . $row['isbn'] . '" class="btn btn-primary">View Details</a>';
            echo '<a href="borrow.php?id=' . $row['isbn'] . '" class="btn btn-secondary">Borrow</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>No books found matching your search.</p>';
    }
    ?>
        </div>
        <script defer>
  const themeToggle = document.getElementById('theme-toggle');

  // Check if a theme preference is stored in localStorage
  const storedTheme = localStorage.getItem('theme');
  if (storedTheme) {
    document.documentElement.setAttribute('data-theme', storedTheme);
    if (storedTheme === 'dark') {
      themeToggle.checked = true;
    }
  }

  themeToggle.addEventListener('change', () => {
    if (themeToggle.checked) {
      document.documentElement.setAttribute('data-theme', 'dark');
      localStorage.setItem('theme', 'dark');
    } else {
      document.documentElement.setAttribute('data-theme', 'light');
      localStorage.setItem('theme', 'light');
    }
  });
</script>
</body>
</html>
