<?php
ob_start(); // Start output buffering
include __DIR__ . '/../config/databaseConnection.php';
ob_clean(); // Clear any previous output

header('Content-Type: application/json');
$response = array();

try {
    $sql = "SELECT BookId, BookTitle, Author, Accession, Quantity,Available,IsFeatured FROM Books ORDER BY BookTitle";
    $result = $conn->query($sql);
    
    $books = array();
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    
    $response['status'] = 'success';
    $response['books'] = $books;
    
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
exit;
?>