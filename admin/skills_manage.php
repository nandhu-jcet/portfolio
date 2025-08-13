<?php
session_start();
include('../includes/db.php');

$pageTitle = "Manage Skills";
$message = '';
$edit_mode = false;
$current_skill = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_skill'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $proficiency = intval($_POST['proficiency']);
    $description = $conn->real_escape_string($_POST['description']);

    $query = "INSERT INTO skills (name, category, proficiency, description) VALUES ('$name', '$category', $proficiency, '$description')";
    if ($conn->query($query)) {
        $message = "Skill added successfully!";
    } else {
        $message = "Failed to add skill: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])) {
    $edit_id = intval($_GET['edit_id']);
    $query = "SELECT * FROM skills WHERE id = $edit_id";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $current_skill = $result->fetch_assoc();
        $edit_mode = true;
    } else {
        $message = "Skill not found.";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_skill'])) {
    $id = intval($_POST['id']);
    $name = $conn->real_escape_string($_POST['name']);
    $category = $conn->real_escape_string($_POST['category']);
    $proficiency = intval($_POST['proficiency']);
    $description = $conn->real_escape_string($_POST['description']);

    $query = "UPDATE skills SET name = '$name', category = '$category', proficiency = $proficiency, description = '$description' WHERE id = $id";
    if ($conn->query($query)) {
        $message = "Skill updated successfully!";
        $edit_mode = false;
    } else {
        $message = "Failed to update skill: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = intval($_POST['delete_id']);
    $query = "DELETE FROM skills WHERE id = $id";
    if ($conn->query($query)) {
        $message = "Skill deleted successfully!";
    } else {
        $message = "Failed to delete skill: " . $conn->error;
    }
}

$query = "SELECT * FROM skills ORDER BY category, name ASC";
$result = $conn->query($query);
if ($result === false) {
    die("Database error: " . $conn->error);
}
$skills = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Skills</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>

    <main class="ml-64 p-8 pt-24">
        <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">Manage Skills</h1>

        <?php if ($message): ?>
            <p class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg"><?php echo $message; ?></p>
        <?php endif; ?>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white"><?php echo $edit_mode ? 'Edit Skill' : 'Add New Skill'; ?></h2>
            <form action="" method="POST">
                <input type="hidden" name="id" value="<?php echo $edit_mode ? htmlspecialchars($current_skill['id']) : ''; ?>">
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skill Name</label>
                    <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="<?php echo $edit_mode ? htmlspecialchars($current_skill['name']) : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                    <select id="category" name="category" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
                        <option value="">Select a category</option>
                        <option value="Programming Languages" <?php echo $edit_mode && $current_skill['category'] == 'Programming Languages' ? 'selected' : ''; ?>>Programming Languages</option>
                        <option value="Frameworks" <?php echo $edit_mode && $current_skill['category'] == 'Frameworks' ? 'selected' : ''; ?>>Frameworks</option>
                        <option value="Databases" <?php echo $edit_mode && $current_skill['category'] == 'Databases' ? 'selected' : ''; ?>>Databases</option>
                        <option value="Tools" <?php echo $edit_mode && $current_skill['category'] == 'Tools' ? 'selected' : ''; ?>>Tools</option>
                        <option value="Other" <?php echo $edit_mode && $current_skill['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label for="proficiency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Proficiency (1-100)</label>
                    <input type="number" id="proficiency" name="proficiency" min="1" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white" value="<?php echo $edit_mode ? htmlspecialchars($current_skill['proficiency']) : ''; ?>" required>
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"><?php echo $edit_mode ? htmlspecialchars($current_skill['description']) : ''; ?></textarea>
                </div>
                <button type="submit" name="<?php echo $edit_mode ? 'update_skill' : 'add_skill'; ?>" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300">
                    <?php echo $edit_mode ? 'Update Skill' : 'Add Skill'; ?>
                </button>
                <?php if ($edit_mode): ?>
                    <a href="skills_manage.php" class="ml-2 px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition duration-300">Cancel</a>
                <?php endif; ?>
            </form>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Skill Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Proficiency</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    <?php foreach ($skills as $skill): ?>
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-800 dark:text-white"><?php echo htmlspecialchars($skill['name']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300"><?php echo htmlspecialchars($skill['category']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-300"><?php echo htmlspecialchars($skill['proficiency']); ?>%</td>
                            <td class="px-6 py-4 text-gray-600 dark:text-gray-300"><?php echo htmlspecialchars($skill['description']); ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="skills_manage.php?edit_id=<?php echo $skill['id']; ?>" class="text-yellow-600 hover:text-yellow-800 dark:text-yellow-400 dark:hover:text-yellow-300 mr-2">Edit</a>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="delete_id" value="<?php echo $skill['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300" onclick="return confirm('Are you sure you want to delete this skill?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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