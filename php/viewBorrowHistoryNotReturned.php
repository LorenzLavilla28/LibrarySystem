<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

try {
    $sql = "SELECT 
                bh.TransactionId,
                bh.BorrowerFirstName,
                bh.BorrowerLastName,
                b.BookTitle as BookBorrowed,
                bh.DateBorrowed,
                bh.DateToReturn,
                bh.Status
            FROM BorrowHistory bh
            LEFT JOIN Books b ON bh.BookBorrowed = b.BookId
            WHERE bh.Status <> 'Returned'
            ORDER BY bh.Status ASC";
            
    $result = $conn->query($sql);
    
    $history = array();
    while($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    
    $response['status'] = 'success';
    $response['history'] = $history;
    
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>