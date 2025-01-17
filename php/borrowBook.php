<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    if (!isset($_POST['userId'], $_POST['bookId'], $_POST['dateBorrowed'], $_POST['dateReturn'])) {
        throw new Exception('Missing required data');
    }

    // Get user details from UserProfile
    $userSql = "SELECT FirstName, LastName FROM UserProfile WHERE UserId = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("s", $_POST['userId']);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    $firstName = $user['FirstName'];
    $lastName = $user['LastName'];
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
            VALUES (?, ?, ?, ?, ?, ?, 'Not Yet Released')";
    
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