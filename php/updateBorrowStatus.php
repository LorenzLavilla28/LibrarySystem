<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $transactionId = $_POST['transactionId'];
        
        // Start transaction
        $conn->begin_transaction();

        // Get BookId from BorrowHistory
        $sqlGet = "SELECT BookBorrowed FROM BorrowHistory WHERE TransactionId = ?";
        $stmtGet = $conn->prepare($sqlGet);
        $stmtGet->bind_param("s", $transactionId);
        $stmtGet->execute();
        $result = $stmtGet->get_result();
        $row = $result->fetch_assoc();
        $bookId = $row['BookBorrowed'];
        
        // Update BorrowHistory status
        $sqlUpdate = "UPDATE BorrowHistory SET Status = 'Returned', DateReturned = NOW() WHERE TransactionId = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("s", $transactionId);
        
        if (!$stmtUpdate->execute()) {
            throw new Exception($stmtUpdate->error);
        }

        // Update Books available count
        $sqlBook = "UPDATE Books SET Available = Available + 1 WHERE BookId = ?";
        $stmtBook = $conn->prepare($sqlBook);
        $stmtBook->bind_param("s", $bookId);
        
        if (!$stmtBook->execute()) {
            throw new Exception($stmtBook->error);
        }

        // Commit transaction
        $conn->commit();
        
        $response['status'] = 'success';
        $response['message'] = 'Book returned successfully';
        
    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = $e->getMessage();
    } finally {
        if (isset($stmtGet)) $stmtGet->close();
        if (isset($stmtUpdate)) $stmtUpdate->close();
        if (isset($stmtBook)) $stmtBook->close();
    }
}

$conn->close();
echo json_encode($response);
?>