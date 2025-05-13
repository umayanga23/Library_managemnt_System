<?php
require_once 'auth_check.php';
checkLogin();
// Database connection
require_once 'config/db_connect.php';

// Initialize variables
$title = $author = $isbn = $publication_year = $message = "";
$error = [];

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input
    $title = trim(htmlspecialchars($_POST['title']));
    $author = trim(htmlspecialchars($_POST['author']));
    $isbn = trim(htmlspecialchars($_POST['isbn']));
    $publication_year = trim(htmlspecialchars($_POST['publication_year']));

    // Validation
    if (empty($title)) {
        $error[] = "Title is required";
    }
    if (empty($author)) {
        $error[] = "Author is required";
    }
    if (empty($isbn)) {
        $error[] = "ISBN is required";
    }
    if (empty($publication_year)) {
        $error[] = "Publication year is required";
    }

    // If no errors, insert into database
    if (empty($error)) {
        $sql = "INSERT INTO books (title, author, isbn, publication_year) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $title, $author, $isbn, $publication_year);

        if ($stmt->execute()) {
            $message = "Book added successfully!";
            // Clear form
            $title = $author = $isbn = $publication_year = "";
        } else {
            $error[] = "Error: " . $conn->error;
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Book</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add New Book</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error">
                <?php foreach($error as $err): ?>
                    <p><?php echo $err; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($message): ?>
            <div class="success">
                <p><?php echo $message; ?></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo $title; ?>" required>
            </div>

            <div class="form-group">
                <label for="author">Author:</label>
                <input type="text" name="author" id="author" value="<?php echo $author; ?>" required>
            </div>

            <div class="form-group">
                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" id="isbn" value="<?php echo $isbn; ?>" required>
            </div>

            <div class="form-group">
                <label for="publication_year">Publication Year:</label>
                <input type="number" name="publication_year" id="publication_year" 
                       value="<?php echo $publication_year; ?>" required>
            </div>

            <button type="submit">Add Book</button>
        </form>
    </div>
</body>
</html>
