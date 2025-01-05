<?php
include __DIR__ . '/../config/databaseConnection.php';
session_start();

header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    if (!isset($_SESSION['user_id'], $_POST['bookId'], $_POST['dateBorrowed'], $_POST['dateReturn'])) {
        throw new Exception('Missing required data');
    }

    // Get user details from session
    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];
    $bookId = $_POST['bookId'];
    $dateBorrowed = $_POST['dateBorrowed'];
    $dateReturn = $_POST['dateReturn'];

    // Generate Transaction ID (TRAN + timestamp)
    $transactionId = 'TRAN' . time();

    // Start transaction
    $conn->begin_transaction();

    // Insert borrow record
    $sql = "INSERT INTO BorrowHistory (TransactionId, BorrowerFirstName, BorrowerLastName, 
            BookBorrowed, DateBorrowed, DateToReturn, Status) 
            VALUES (?, ?, ?, ?, ?, ?, 'Not Yet Returned')";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", 
        $transactionId, 
        $firstName, 
        $lastName, 
        $bookId,
        $dateBorrowed, 
        $dateReturn
    );

    if (!$stmt->execute()) {
        throw new Exception("Failed to record borrow transaction");
    }

    // Update book availability
    $sql = "UPDATE Books SET Available = Available - 1 WHERE BookId = ? AND Available > 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $bookId);
    
    if (!$stmt->execute()) {
        throw new Exception("Failed to update book availability");
    }

    if ($stmt->affected_rows === 0) {
        throw new Exception("Book is no longer available");
    }

    // Commit transaction
    $conn->commit();
    
    $response['status'] = 'success';
    $response['message'] = 'Book borrowed successfully';

} catch (Exception $e) {
    if ($conn->connect_error === false) {
        $conn->rollback();
    }
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>