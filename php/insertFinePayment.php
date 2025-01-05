<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $transactionId = $_POST['transactionId'];
        $fineCost = $_POST['fineCost'];
        $finePaid = $_POST['finePaid'];
        $currentDate = date('Y-m-d H:i:s');
        
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
        
        // Insert fine payment record
        $sql = "INSERT INTO FineManagement (TransactionId, FineCost, FinePaid, DateOfPayment) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sdds", $transactionId, $fineCost, $finePaid, $currentDate);
        
        if (!$stmt->execute()) {
            throw new Exception($stmt->error);
        }

        // Update borrow status
        $updateSql = "UPDATE BorrowHistory SET Status = 'Returned' WHERE TransactionId = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("s", $transactionId);
        
        if (!$updateStmt->execute()) {
            throw new Exception($updateStmt->error);
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
        $response['message'] = 'Payment processed and book returned successfully';
        
    } catch (Exception $e) {
        $conn->rollback();
        $response['message'] = $e->getMessage();
    } finally {
        if (isset($stmtGet)) $stmtGet->close();
        if (isset($stmt)) $stmt->close();
        if (isset($updateStmt)) $updateStmt->close();
        if (isset($stmtBook)) $stmtBook->close();
    }
}

$conn->close();
echo json_encode($response);
?>