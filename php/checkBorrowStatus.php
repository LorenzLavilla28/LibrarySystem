<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['userId'], $data['bookId'])) {
        throw new Exception('Missing required data');
    }

    // Get user details from UserProfile
    $userSql = "SELECT FirstName, LastName FROM UserProfile WHERE UserId = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("s", $data['userId']);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    // Check if user has unreturned copy of this book
    $sql = "SELECT bh.*, b.BookTitle 
            FROM BorrowHistory bh
            JOIN Books b ON b.BookId = bh.BookBorrowed
            WHERE bh.BorrowerFirstName = ? 
            AND bh.BorrowerLastName = ? 
            AND bh.BookBorrowed = ? 
            AND bh.Status = 'Not Yet Returned'
            OR bh.Status = 'Not Yet Released'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user['FirstName'], $user['LastName'], $data['bookId']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $response['status'] = 'error';
        $response['message'] = "Please return {$book['BookTitle']} first before borrowing the same book";
    } else {
        $response['status'] = 'success';
        $response['message'] = 'You can borrow this book';
    }

    $stmt->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>