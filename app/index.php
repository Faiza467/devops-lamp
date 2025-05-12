<?php
include 'db.php';

// Fetch all blog posts
$posts = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Travel Blog</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <h1>🌍 My Travel Blog</h1>
            <a href="add_post.php" class="btn">+ Add New Post</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <h2>Latest Adventures</h2>

        <?php if ($posts->num_rows > 0): ?>
            <div class="cards">
                <?php while ($row = $posts->fetch_assoc()): ?>
                    <div class="card">
                        <img src="<?= htmlspecialchars($row['image_url']) ?>" alt="Post Image" class="card-img">
                        <div class="card-body">
                            <h3><?= htmlspecialchars($row['title']) ?></h3>
                            <p class="date"><?= date("F j, Y", strtotime($row['created_at'])) ?></p>
                            <p class="excerpt"><?= substr(htmlspecialchars($row['content']), 0, 100) ?>...</p>
                            <div class="card-actions">
                                <form action="delete_post.php" method="post">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn small danger">Delete</button>
                                </form>
                                <form action="edit_post.php" method="get">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn small">Edit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No blog posts yet. Start your adventure by adding one!</p>
        <?php endif; ?>
    </div>

</body>
</html>

