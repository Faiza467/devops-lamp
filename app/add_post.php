<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $image_url = trim($_POST['image_url']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO posts (title, image_url, content, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $title, $image_url, $content);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit;
    } else {
        $error = "Title and Content are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <h1>✈️ Add Travel Blogs Posts</h1>
        <a href="index.php" class="btn">← Back to Blog</a>
    </div>
</nav>

<div class="container">
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" class="form">
        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Image URL:</label>
        <input type="text" name="image_url" placeholder="Optional">

        <label>Content:</label>
        <textarea name="content" rows="6" required></textarea>

        <button type="submit" class="btn">Post Blog</button>
    </form>
</div>

</body>
</html>

