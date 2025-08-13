<?php
include('includes/db.php');

$id = intval($_GET['id']);
$result = $conn->query("SELECT * FROM projects WHERE id = $id");
$project = $result->fetch_assoc();

if (!$project) {
    die("Project not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Details - <?php echo htmlspecialchars($project['title']); ?></title>
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
        <div class="glassmorphic p-8 animate__animated animate__fadeIn">
            <h1 class="text-4xl sm:text-5xl font-bold mb-6"><?php echo htmlspecialchars($project['title']); ?></h1>
            <div class="flex flex-col md:flex-row md:space-x-8">
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <img src="assets/images/project_images/<?php echo htmlspecialchars($project['image']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="w-full h-auto object-cover rounded-lg shadow-lg">
                </div>
                <div class="md:w-1/2">
                    <p class="text-xl mb-4"><strong class="text-blue-400">Technologies:</strong> <?php echo htmlspecialchars($project['languages']); ?></p>
                    <p class="text-lg mb-6"><strong class="text-blue-400">Description:</strong> <?php echo nl2br(htmlspecialchars($project['description'])); ?></p>
                    <a href="<?php echo htmlspecialchars($project['url']); ?>" target="_blank" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">Visit Project</a>
                </div>
            </div>
        </div>
    </div>

    <?php include('includes/footer.php'); ?>
</body>
</html>

