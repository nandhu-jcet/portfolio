<?php
include('../includes/db.php');

$pageTitle = "Manage Services";

function getServices($conn) {
    $services = array();
    $result = $conn->query("SELECT * FROM services ORDER BY id DESC");
    while($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
    return $services;
}

function addService($conn, $title, $description, $icon) {
    $stmt = $conn->prepare("INSERT INTO services (title, description, icon) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $icon);
    return $stmt->execute();
}

function updateService($conn, $id, $title, $description, $icon) {
    $stmt = $conn->prepare("UPDATE services SET title = ?, description = ?, icon = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $icon, $id);
    return $stmt->execute();
}

function deleteService($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM services WHERE id = ?");
    $stmt->bind_param("i", $id);
    return $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                addService($conn, $_POST['title'], $_POST['description'], $_POST['icon']);
                break;
            case 'update':
                updateService($conn, $_POST['id'], $_POST['title'], $_POST['description'], $_POST['icon']);
                break;
            case 'delete':
                deleteService($conn, $_POST['id']);
                break;
        }
    }
}

$services = getServices($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
   
    <main class="ml-64 p-8 pt-24">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-8"><?php echo $pageTitle; ?></h1>
        
        <!-- Add/Edit Service Form -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg mb-8">
            <h2 id="formTitle" class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Add New Service</h2>
            <form id="serviceForm" action="" method="POST">
                <input type="hidden" id="action" name="action" value="add">
                <input type="hidden" id="serviceId" name="id" value="">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" id="title" name="title" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Icon (FontAwesome class)</label>
                        <input type="text" id="icon" name="icon" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                    </div>
                </div>
                <div class="mt-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                    <textarea id="description" name="description" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white"></textarea>
                </div>
                <div class="mt-4">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Save Service</button>
                    <button type="button" id="cancelEdit" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded ml-2 hidden">Cancel</button>
                </div>
            </form>
        </div>
        
        <!-- Services List -->
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-lg">
            <h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">Existing Services</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Icon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                        <?php foreach($services as $service): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><?php echo htmlspecialchars($service['title']); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500 dark:text-gray-300"><?php echo htmlspecialchars(substr($service['description'], 0, 100)) . '...'; ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white"><i class="<?php echo $service['icon']; ?>"></i></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="editService(<?php echo htmlspecialchars(json_encode($service)); ?>)" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 mr-3">Edit</button>
                                <form action="" method="POST" class="inline">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script>
        function editService(service) {
            document.getElementById('formTitle').innerText = 'Edit Service';
            document.getElementById('action').value = 'update';
            document.getElementById('serviceId').value = service.id;
            document.getElementById('title').value = service.title;
            document.getElementById('description').value = service.description;
            document.getElementById('icon').value = service.icon;
            document.getElementById('cancelEdit').classList.remove('hidden');
            window.scrollTo(0, 0);
        }

        document.getElementById('cancelEdit').addEventListener('click', function() {
            resetForm();
        });

        function resetForm() {
            document.getElementById('formTitle').innerText = 'Add New Service';
            document.getElementById('serviceForm').reset();
            document.getElementById('action').value = 'add';
            document.getElementById('serviceId').value = '';
            document.getElementById('cancelEdit').classList.add('hidden');
        }

        document.getElementById('serviceForm').addEventListener('submit', function(e) {
            e.preventDefault();
            this.submit();
        });
    </script>
</body>
</html>