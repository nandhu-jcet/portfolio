<?php
include('../includes/db.php');

$pageTitle = "Delete Project";
$message = '';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Fetch project details to get the image filename
    $result = $conn->query("SELECT image FROM projects WHERE id = $id");
    $project = $result->fetch_assoc();
    
    if ($project) {
        // Delete the project image file
        $image_path = "../assets/images/project_images/" . $project['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        
        // Delete project from database
        $stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $message = "Project deleted successfully!";
        } else {
            $message = "Error deleting project: " . $conn->error;
        }
        $stmt->close();
    } else {
        $message = "Project not found.";
    }
} else {
    $message = "Invalid request.";
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

        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate__animated animate__fadeIn">
            <p class="text-gray-800 dark:text-white mb-4"><?php echo $message; ?></p>
            <a href="manage_projects.php" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 ease-in-out inline-block">
                Back to Project Management
            </a>
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