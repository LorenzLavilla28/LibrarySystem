<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['bookId'])) {
    try {
        $bookId = $_POST['bookId'];
        
        // Get current status and toggle it
        $sql = "UPDATE Books SET IsFeatured = NOT IsFeatured WHERE BookId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $bookId);
        
        if ($stmt->execute()) {
            // Get new status
            $getStatus = "SELECT IsFeatured FROM Books WHERE BookId = ?";
            $statusStmt = $conn->prepare($getStatus);
            $statusStmt->bind_param("s", $bookId);
            $statusStmt->execute();
            $result = $statusStmt->get_result();
            $row = $result->fetch_assoc();
            
            $response = array(
                'status' => 'success',
                'isFeatured' => (bool)$row['IsFeatured']
            );
        } else {
            throw new Exception($stmt->error);
        }
        
    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
?>