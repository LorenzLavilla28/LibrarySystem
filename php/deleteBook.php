<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

if (isset($_POST['bookId'])) {
    try {
        $bookId = $_POST['bookId'];
        
        $sql = "DELETE FROM Books WHERE BookId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $bookId);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Book deleted successfully';
        } else {
            throw new Exception('Failed to delete book');
        }
        
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Book ID is required';
}

echo json_encode($response);
?>