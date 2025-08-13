<?php
include('includes/db.php');

function get_all_blogs() {
    global $conn;
    $result = $conn->query("SELECT * FROM blog_posts ORDER BY created_at DESC");
    return $result->fetch_all(MYSQLI_ASSOC);
}

$blogs = get_all_blogs();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        .blog-card {
            transition: transform 0.3s ease-in-out;
        }
        .blog-card:hover {
            transform: translateY(-5px);
        }
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

    <section id="blog" class="py-20 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto">
            <h1 class="text-center text-5xl font-bold mb-12 animate__animated animate__fadeInDown">My Blog</h1>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($blogs as $blog): ?>
                    <div class='blog-card glassmorphic p-6 animate__animated animate__fadeIn'>
                        <img src='assets/images/blog_images/<?php echo htmlspecialchars($blog['image']); ?>' alt='<?php echo htmlspecialchars($blog['title']); ?>' class='w-full h-48 object-cover rounded-lg mb-4'>
                        <h3 class='text-xl font-semibold mb-2'><?php echo htmlspecialchars($blog['title']); ?></h3>
                        <p class='text-sm text-gray-300 mb-2'>Category: <?php echo htmlspecialchars($blog['category']); ?></p>
                        <p class='text-sm mb-4'><?php echo substr(htmlspecialchars($blog['content']), 0, 100); ?>...</p>
                        <a href='blog_details.php?id=<?php echo $blog['id']; ?>' class='bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-300 ease-in-out inline-block'>Read More</a>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($blogs)): ?>
                    <p class='text-center text-xl col-span-full'>No blogs found. Add some blogs from the admin panel.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php include('includes/footer.php'); ?>
</body>
</html>

