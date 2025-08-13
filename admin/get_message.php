<?php
// Include the database connection file
include('../includes/db.php');

try {
    // Get message ID from query string
    $id = intval($_GET['id']);

    // Validate ID
    if ($id <= 0) {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid ID']);
        exit;
    }

    // Fetch message details
    $stmt = $pdo->prepare("SELECT * FROM contact_messages WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $message = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if message exists
    if (!$message) {
        http_response_code(404);
        echo json_encode(['error' => 'Message not found']);
        exit;
    }

    // Return message as JSON
    header('Content-Type: application/json');
    echo json_encode($message);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>