<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validate required fields
        if (empty($_POST['bookId']) || empty($_POST['title']) || 
            empty($_POST['author']) || empty($_POST['quantity'])) {
            throw new Exception('All fields are required');
        }

        $bookId = $_POST['bookId'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $quantity = (int)$_POST['quantity'];

        // Validate quantity
        if ($quantity < 1 || $quantity > 100) {
            throw new Exception('Quantity must be between 1 and 100');
        }

        $sql = "UPDATE Books SET BookTitle = ?, Author = ?, Quantity = ? WHERE BookId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $author, $quantity, $bookId);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Book updated successfully';
        } else {
            throw new Exception('Error updating book: ' . $stmt->error);
        }

    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
?>