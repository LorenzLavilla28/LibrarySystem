<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

try {
    $sql = "SELECT BookId, BookTitle, Author, Accession, Available FROM Books WHERE IsFeatured = 1";
    $result = $conn->query($sql);
    
    if ($result) {
        $books = array();
        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }
        $response = array('status' => 'success', 'books' => $books);
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>