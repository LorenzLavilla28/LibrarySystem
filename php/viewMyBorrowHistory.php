<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['userId'])) {
        throw new Exception('User ID not provided');
    }

    // Get user details from UserProfile
    $userSql = "SELECT FirstName, LastName FROM UserProfile WHERE UserId = ?";
    $userStmt = $conn->prepare($userSql);
    $userStmt->bind_param("s", $data['userId']);
    $userStmt->execute();
    $userResult = $userStmt->get_result();
    $user = $userResult->fetch_assoc();

    $sql = "SELECT bh.*, b.BookTitle 
            FROM BorrowHistory bh
            JOIN Books b ON b.BookId = bh.BookBorrowed
            WHERE BorrowerFirstName = ? AND BorrowerLastName = ?
            ORDER BY DateBorrowed DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user['FirstName'], $user['LastName']);
    $stmt->execute();
    $result = $stmt->get_result();

    $history = array();
    while ($row = $result->fetch_assoc()) {
        $row['BookBorrowed'] = $row['BookTitle'];
        $history[] = $row;
    }

    $response['status'] = 'success';
    $response['history'] = $history;

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>