<?php
include('../includes/db.php');
$pageTitle = "Dashboard";

function getDashboardStats($conn) {
    $stats = array();
    
    // Fetch total projects
    $result = $conn->query("SELECT COUNT(*) as count FROM projects");
    $stats['projects'] = $result->fetch_assoc()['count'];
    
    // Fetch total blog posts
    $result = $conn->query("SELECT COUNT(*) as count FROM blog_posts");
    $stats['blogs'] = $result->fetch_assoc()['count'];
    
    // Fetch total contact messages
    $result = $conn->query("SELECT COUNT(*) as count FROM contact_messages");
    $stats['messages'] = $result->fetch_assoc()['count'];
    
    // Fetch total services (new addition)
    $result = $conn->query("SELECT COUNT(*) as count FROM services");
    $stats['services'] = $result->fetch_assoc()['count'];
    
    return $stats;
}

function getRecentActivities($conn) {
    $activities = array();
    
    // Fetch recent projects
    $result = $conn->query("SELECT title, 'project' as type, created_at FROM projects ORDER BY created_at DESC LIMIT 3");
    while($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
    
    // Fetch recent blog posts
    $result = $conn->query("SELECT title, 'blog' as type, created_at FROM blog_posts ORDER BY created_at DESC LIMIT 3");
    while($row = $result->fetch_assoc()) {
        $activities[] = $row;
    }
    
    // Sort activities by creation date
    usort($activities, function($a, $b) {
        return strtotime($b['created_at']) - strtotime($a['created_at']);
    });
    
    return array_slice($activities, 0, 5);
}

$stats = getDashboardStats($conn);
$recent_activities = getRecentActivities($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
   
    <main class="ml-64 p-8 pt-24">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Projects Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate__animated animate__fadeIn">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Total Projects</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?php echo $stats['projects']; ?></h3>
                    </div>
                    <div class="w-16 h-16 bg-blue-500 bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-project-diagram text-2xl text-blue-500"></i>
                    </div>
                </div>
            </div>
            <!-- Blog Posts Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate__animated animate__fadeIn">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Total Blog Posts</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?php echo $stats['blogs']; ?></h3>
                    </div>
                    <div class="w-16 h-16 bg-green-500 bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-blog text-2xl text-green-500"></i>
                    </div>
                </div>
            </div>
            <!-- Messages Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate__animated animate__fadeIn">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Total Messages</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?php echo $stats['messages']; ?></h3>
                    </div>
                    <div class="w-16 h-16 bg-yellow-500 bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-envelope text-2xl text-yellow-500"></i>
                    </div>
                </div>
            </div>
            <!-- Services Card (New Addition) -->
            <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg animate__animated animate__fadeIn">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">Total Services</p>
                        <h3 class="text-3xl font-bold text-gray-800 dark:text-white"><?php echo $stats['services']; ?></h3>
                    </div>
                    <div class="w-16 h-16 bg-purple-500 bg-opacity-20 rounded-full flex items-center justify-center">
                        <i class="fas fa-concierge-bell text-2xl text-purple-500"></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- Recent Activities -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg mb-8">
            <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">Recent Activities</h2>
            <div class="space-y-4">
                <?php foreach($recent_activities as $activity): ?>
                <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-700">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-blue-500 bg-opacity-20 flex items-center justify-center mr-4">
                            <i class="fas fa-<?php echo $activity['type'] == 'project' ? 'project-diagram' : 'blog'; ?> text-blue-500"></i>
                        </div>
                        <div>
                            <p class="font-medium text-gray-800 dark:text-white"><?php echo htmlspecialchars($activity['title']); ?></p>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                <?php echo date('M d, Y', strtotime($activity['created_at'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="add_project.php" class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg hover:bg-blue-600 hover:text-white group transition-all duration-300">
                <div class="flex items-center">
                    <div class="w-12 h-12 rounded-full bg-blue-500 bg-opacity-20 flex items-center justify-center mr-4 group-hover:bg-white group-hover:bg-opacity-20">
                        <i class="fas fa-plus text-blue-500 group-hover:text-white"></i>
                    </div>
                    <span class="font-medium text-gray-800 dark:text-white group-hover:text-white">New Project</span>
                </div>
            </a>
            <!-- Add more quick action cards as needed -->
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