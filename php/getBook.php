<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

if (isset($_GET['id'])) {
    try {
        $bookId = $_GET['id'];
        $sql = "SELECT BookId, BookTitle, Author, ISBN, Quantity FROM Books WHERE BookId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $bookId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($book = $result->fetch_assoc()) {
            $response['status'] = 'success';
            $response['book'] = $book;
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Book not found';
        }
        
    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Book ID is required';
}

$conn->close();
echo json_encode($response);
?>