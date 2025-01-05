<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array();

try {
    $transactionId = $_GET['id'];
    
    $sql = "SELECT f.TransactionId, f.FineCost, f.FinePaid, f.DateOfPayment,
            bh.BorrowerFirstName, bh.BorrowerLastName, bh.DateBorrowed, 
            bh.DateToReturn, bh.Status, b.BookTitle
            FROM FineManagement f
            JOIN BorrowHistory bh ON f.TransactionId = bh.TransactionId
            JOIN Books b ON b.BookId = bh.BookBorrowed
            WHERE f.TransactionId = ?";
            
    if($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $transactionId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if($row = $result->fetch_assoc()) {
            $response['status'] = 'success';
            $response['details'] = $row;
        } else {
            throw new Exception("Fine details not found");
        }
        $stmt->close();
    } else {
        throw new Exception("Failed to prepare statement: " . $conn->error);
    }
    
} catch (Exception $e) {
    $response['status'] = 'error';
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>