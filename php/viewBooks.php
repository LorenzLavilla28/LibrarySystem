<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT * FROM Books ORDER BY Category";
    $result = $conn->query($sql);
    $books = array();
    
    while($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
    
    echo json_encode([
        'status' => 'success',
        'books' => $books
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>