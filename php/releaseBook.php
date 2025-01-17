<?php
// filepath: /c:/xampp/htdocs/librarysystem/php/releaseBook.php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

try {
    // Get the JSON input
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['transactionId'])) {
        throw new Exception('Missing Transaction ID');
    }

    $transactionId = $data['transactionId'];

    // Update the status to 'Released' or appropriate status
    $sql = "UPDATE BorrowHistory SET Status = 'Not Yet Returned' WHERE TransactionId = ?";
    
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("s", $transactionId);
    
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            $response = array(
                'status' => 'success',
                'message' => 'Book released successfully.'
            );
        } else {
            throw new Exception('No records updated. Invalid Transaction ID.');
        }
    } else {
        throw new Exception($stmt->error);
    }
    
    $stmt->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>