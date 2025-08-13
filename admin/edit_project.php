<?php
include('../includes/db.php');

$pageTitle = "Edit Project";
$message = '';
$id = $_GET['id'];

$result = $conn->query("SELECT * FROM projects WHERE id = $id");
$project = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = htmlspecialchars($_POST['title']);
    $languages = htmlspecialchars($_POST['languages']);
    $description = htmlspecialchars($_POST['description']);
    $url = htmlspecialchars($_POST['url']);
    $image = $project['image'];

    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $target_dir = "../assets/images/project_images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }

    $stmt = $conn->prepare("UPDATE projects SET title = ?, languages = ?, description = ?, image = ?, url = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $title, $languages, $description, $image, $url, $id);

    if ($stmt->execute()) {
        $message = "Project updated successfully!";
    } else {
        $message = "Failed to update project: " . $conn->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
   
    <main class="ml-64 p-8 pt-24">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6"><?php echo $pageTitle; ?></h1>

        <?php if ($message): ?>
            <div class="bg-green-500 text-white p-4 mb-6 rounded animate__animated animate__fadeIn">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate__animated animate__fadeIn">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project Title</label>
                <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required class="w-full px-3 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label for="languages" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Technologies</label>
                <input type="text" id="languages" name="languages" value="<?php echo htmlspecialchars($project['languages']); ?>" required class="w-full px-3 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea id="description" name="description" required class="w-full px-3 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 h-40"><?php echo htmlspecialchars($project['description']); ?></textarea>
            </div>
            <div class="mb-4">
                <label for="url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Project URL</label>
                <input type="url" id="url" name="url" value="<?php echo htmlspecialchars($project['url']); ?>" required class="w-full px-3 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image</label>
                <input type="file" id="image" name="image" class="w-full px-3 py-2 text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Current image: <?php echo htmlspecialchars($project['image']); ?></p>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out transform hover:scale-105">
                Update Project
            </button>
        </form>
    </main>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('-translate-x-full');
        });
    </script>
</body>
</html>