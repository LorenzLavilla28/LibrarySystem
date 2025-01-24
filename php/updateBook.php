<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Validate required fields
        if (empty($_POST['bookId']) || empty($_POST['title']) || 
            empty($_POST['author']) ||empty($_POST['category'])) {
            throw new Exception('All fields are required');
        }

        $bookId = $_POST['bookId'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $newQuantity = (int)$_POST['quantity'];
        $category = $_POST['category'];
        $description = $_POST['description'];

        // Get current book details
        $getCurrentBook = "SELECT Quantity, Available FROM Books WHERE BookId = ?";
        $stmt = $conn->prepare($getCurrentBook);
        $stmt->bind_param("s", $bookId);
        $stmt->execute();
        $result = $stmt->get_result();
        $currentBook = $result->fetch_assoc();

        if (!$currentBook) {
            throw new Exception('Book not found');
        }

        // Calculate difference and new available count
        $quantityDifference = $newQuantity - $currentBook['Quantity'];
        $newAvailable = $currentBook['Available'] + $quantityDifference;

        if ($newAvailable < 0) {
            throw new Exception('Cannot reduce quantity below borrowed books count');
        }

        // Update query with both quantity and available
        $sql = "UPDATE Books 
                SET BookTitle = ?, 
                    Author = ?, 
                    Quantity = ?, 
                    Available = ?,
                    Category = ?,
                    Description = ?
                WHERE BookId = ?";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssiisss", $title, $author, $newQuantity, $newAvailable, $category, $description,$bookId);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Book updated successfully';
        } else {
            throw new Exception("Failed to update book: " . $stmt->error);
        }

    } catch (Exception $e) {
        $response['status'] = 'error';
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
?>