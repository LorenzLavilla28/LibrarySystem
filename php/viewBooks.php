<?php
ob_clean(); // Clear any previous output
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

try {
    $sql = "SELECT BookId, BookTitle, Author, ISBN, Quantity FROM Books ORDER BY BookTitle";
    $result = $conn->query($sql);
    
    $books = array();
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    
    $response['status'] = 'success';
    $response['books'] = $books;
    $response['message'] = 'Books fetched successfully';
    
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = 'Error: ' . $e->getMessage();
}

$conn->close();
echo json_encode($response);
exit;
?>