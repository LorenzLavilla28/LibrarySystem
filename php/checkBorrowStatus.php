<?php
include __DIR__ . '/../config/databaseConnection.php';
session_start();

header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    if (!isset($_SESSION['first_name'], $_SESSION['last_name'], $_GET['bookId'])) {
        throw new Exception('Missing required data');
    }

    $firstName = $_SESSION['first_name'];
    $lastName = $_SESSION['last_name'];
    $bookId = $_GET['bookId'];

    // Check if user has unreturned copy of this book
    $sql = "SELECT bh.*, b.BookTitle 
            FROM BorrowHistory bh
            JOIN Books b ON b.BookId = bh.BookBorrowed
            WHERE bh.BorrowerFirstName = ? 
            AND bh.BorrowerLastName = ? 
            AND bh.BookBorrowed = ? 
            AND bh.Status = 'Not Yet Returned'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $firstName, $lastName, $bookId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        $response['status'] = 'error';
        $response['message'] = "Please return {$book['BookTitle']} first before borrowing the same book";
    } else {
        $response['status'] = 'success';
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>