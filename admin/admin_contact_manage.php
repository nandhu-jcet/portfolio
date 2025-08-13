<?php
include('../includes/db.php');
// Define the page title
$pageTitle = "Manage Contact Messages";
// Handle delete action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $deleteId = intval($_POST['delete_id']);
    try {
        $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->bind_param("i", $deleteId);
        $stmt->execute();
        header("Location: admin_contact_manage.php");
        exit;
    } catch (Exception $e) {
        die("Database error: " . $e->getMessage());
    }
}
// Fetch all messages from the database
try {
    $stmt = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
    $messages = $stmt->fetch_all(MYSQLI_ASSOC);
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - <?php echo $pageTitle; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: none; /* Initially hidden */
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background-color: white;
            padding: 2rem;
            border-radius: 0.5rem;
            max-width: 500px;
            width: 100%;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <?php include('sidebar.php'); ?>
    <?php include('header.php'); ?>
    <main class="ml-64 p-8 pt-24">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6"><?php echo $pageTitle; ?></h1>
        <!-- Messages Table -->
        <div class="responsive-table">
            <table class="w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
                <thead class="bg-gray-200 dark:bg-gray-700">
                    <tr>
                        <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-300">ID</th>
                        <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-300">Name</th>
                        <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-300">Email</th>
                        <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-300">Mobile</th>
                        <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-300">Message</th>
                        <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-300">Date</th>
                        <th class="py-3 px-4 text-left text-gray-700 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="py-3 px-4 text-gray-800 dark:text-gray-300"><?php echo htmlspecialchars($message['id']); ?></td>
                        <td class="py-3 px-4 text-gray-800 dark:text-gray-300"><?php echo htmlspecialchars($message['name']); ?></td>
                        <td class="py-3 px-4 text-gray-800 dark:text-gray-300"><?php echo htmlspecialchars($message['email']); ?></td>
                        <td class="py-3 px-4 text-gray-800 dark:text-gray-300"><?php echo htmlspecialchars($message['mobile']); ?></td>
                        <td class="py-3 px-4 text-gray-800 dark:text-gray-300"><?php echo substr(htmlspecialchars($message['message']), 0, 50); ?>...</td>
                        <td class="py-3 px-4 text-gray-800 dark:text-gray-300"><?php echo date('M d, Y', strtotime($message['created_at'])); ?></td>
                        <td class="py-3 px-4 flex space-x-2">
                            <button class="view-message-btn text-blue-500 hover:text-blue-700" data-message='<?php echo json_encode($message); ?>'>
                                <i class="fas fa-eye"></i>
                            </button>
                            <form method="POST" onsubmit="return confirm('Are you sure you want to delete this message?');" class="inline">
                                <input type="hidden" name="delete_id" value="<?php echo $message['id']; ?>">
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Message Details Modal -->
        <div id="message-modal" class="modal-overlay">
            <div class="modal-content bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg">
                <h2 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4">Message Details</h2>
                <div class="space-y-2">
                    <p><strong>Name:</strong> <span id="modal-name" class="text-gray-700 dark:text-gray-300"></span></p>
                    <p><strong>Email:</strong> <span id="modal-email" class="text-gray-700 dark:text-gray-300"></span></p>
                    <p><strong>Mobile:</strong> <span id="modal-mobile" class="text-gray-700 dark:text-gray-300"></span></p>
                    <p><strong>Message:</strong> <span id="modal-message" class="text-gray-700 dark:text-gray-300"></span></p>
                </div>
                <button id="close-modal" class="mt-4 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-300 rounded hover:bg-gray-300 dark:hover:bg-gray-600">
                    Close
                </button>
            </div>
        </div>
    </main>
    <script>
        // Handle viewing message details
        document.querySelectorAll('.view-message-btn').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                const message = JSON.parse(this.getAttribute('data-message'));
                document.getElementById('modal-name').textContent = message.name || 'N/A';
                document.getElementById('modal-email').textContent = message.email || 'N/A';
                document.getElementById('modal-mobile').textContent = message.mobile || 'N/A';
                document.getElementById('modal-message').textContent = message.message || 'N/A';
                document.getElementById('message-modal').style.display = 'flex'; // Show modal
            });
        });

        // Close modal
        document.getElementById('close-modal').addEventListener('click', function () {
            document.getElementById('message-modal').style.display = 'none'; // Hide modal
        });

        // Close modal when clicking outside
        document.getElementById('message-modal').addEventListener('click', function (e) {
            if (e.target === this) {
                this.style.display = 'none'; // Hide modal
            }
        });
    </script>
</body>
</html>