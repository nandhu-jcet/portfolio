<?php
include('../includes/db.php');

$pageTitle = "Manage Blog Posts";

// Function to fetch all blog posts
function fetch_blog_posts($conn) {
    $query = "SELECT * FROM blog_posts ORDER BY created_at DESC";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        return $result;
    } else {
        return null;
    }
}

// Function to delete a blog post
function delete_blog_post($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM blog_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Check if delete request is made
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (delete_blog_post($conn, $id)) {
        $message = "Blog post deleted successfully!";
    } else {
        $message = "Failed to delete blog post.";
    }
}

// Fetch blog posts to display
$blog_posts = fetch_blog_posts($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Blog Posts</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>

    <main class="ml-64 p-8 pt-24">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Manage Blog Posts</h1>

        <?php if (isset($message)) { ?>
            <p class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg"><?= $message ?></p>
        <?php } ?>

        <a href="add_blog.php" class="inline-block mb-6 px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">Add New Blog Post</a>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Blog Title</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php if ($blog_posts): ?>
                        <?php while ($row = $blog_posts->fetch_assoc()): ?>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-white"><?= htmlspecialchars($row['title']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300"><?= htmlspecialchars($row['category']) ?></td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="../blog_post.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 mr-2" target="_blank">View</a>
                                    <a href="edit_blog.php?id=<?= $row['id'] ?>" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 mr-2">Edit</a>
                                    <a href="manage_blog.php?delete=<?= $row['id'] ?>" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this blog post?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">No blog posts found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>