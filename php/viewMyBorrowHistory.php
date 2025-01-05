<?php
include __DIR__ . '/../config/databaseConnection.php';
session_start();

header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    if (!isset($_SESSION['first_name'], $_SESSION['last_name'])) {
        throw new Exception('User not logged in');
    }

    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];

    $sql = "SELECT bh.*, b.BookTitle 
            FROM BorrowHistory bh
            JOIN Books b ON b.BookId = bh.BookBorrowed
            WHERE BorrowerFirstName = ? AND BorrowerLastName = ?
            ORDER BY DateBorrowed DESC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $firstName, $lastName);
    $stmt->execute();
    $result = $stmt->get_result();

    $history = array();
    while ($row = $result->fetch_assoc()) {
        $row['BookBorrowed'] = $row['BookTitle']; // Replace BookId with BookTitle
        $history[] = $row;
    }

    $response['status'] = 'success';
    $response['history'] = $history;

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>