<?php
include 'db.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = intval($_GET['id']);
$post = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $image_url = trim($_POST['image_url']);
    $content = trim($_POST['content']);

    if (!empty($title) && !empty($content)) {
        $stmt = $conn->prepare("UPDATE posts SET title = ?, image_url = ?, content = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $image_url, $content, $id);
        $stmt->execute();
        $stmt->close();
        header("Location: index.php");
        exit;
    } else {
        $error = "Title and Content are required.";
    }
} else {
    $stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $post = $result->fetch_assoc();
    $stmt->close();

    if (!$post) {
        echo "Post not found.";
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
    <div class="navbar-container">
        <h1>📝 Edit Post</h1>
        <a href="index.php" class="btn">← Back to Blog</a>
    </div>
</nav>

<div class="container">
    <?php if (!empty($error)): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post" class="form">
        <label>Title:</label>
        <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>

        <label>Image URL:</label>
        <input type="text" name="image_url" value="<?= htmlspecialchars($post['image_url']) ?>">

        <label>Content:</label>
        <textarea name="content" rows="6" required><?= htmlspecialchars($post['content']) ?></textarea>

        <button type="submit" class="btn">Update Post</button>
    </form>
</div>

</body>
</html>

