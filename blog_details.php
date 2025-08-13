<?php
include('includes/db.php');

function get_blog_by_id($id) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM blog_posts WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid blog ID.");
}

$id = intval($_GET['id']);
$blog = get_blog_by_id($id);

if (!$blog) {
    die("Blog post not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($blog['title']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .glassmorphic {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 to-blue-900 text-white min-h-screen">
    <?php include('includes/header.php'); ?>

    <div class="container mx-auto py-20 px-4 sm:px-6 lg:px-8">
        <div class="glassmorphic p-8 rounded-lg animate__animated animate__fadeIn">
            <h1 class="text-4xl font-bold mb-6"><?php echo htmlspecialchars($blog['title']); ?></h1>
            <p class="text-gray-300 mb-6"><strong>Category:</strong> <?php echo htmlspecialchars($blog['category']); ?></p>
            <img src="assets/images/blog_images/<?php echo htmlspecialchars($blog['image']); ?>" alt="<?php echo htmlspecialchars($blog['title']); ?>" class="w-full h-64 object-cover rounded-lg mb-8">
            <div class="prose prose-lg prose-invert max-w-none">
                <?php echo nl2br(htmlspecialchars($blog['content'])); ?>
            </div>
            <div class="mt-8">
                <a href="blog.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out">Back to Blog</a>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>

