<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

try {
    $sql = "SELECT fm.*, bh.BorrowerFirstName, bh.BorrowerLastName 
            FROM FineManagement fm
            JOIN BorrowHistory bh ON fm.TransactionId = bh.TransactionId 
            ORDER BY fm.DateOfPayment DESC";
    
    $result = $conn->query($sql);
    
    $fines = array();
    while($row = $result->fetch_assoc()) {
        $fines[] = $row;
    }
    
    $response['status'] = 'success';
    $response['fines'] = $fines;
    
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>