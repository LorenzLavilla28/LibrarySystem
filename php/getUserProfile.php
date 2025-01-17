<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (!isset($data['userId'])) {
        throw new Exception('User ID not provided');
    }

    $userId = $data['userId'];
    
    $sql = "SELECT FirstName, LastName, Email FROM UserProfile WHERE UserId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response['status'] = 'success';
        $response['profile'] = $row;
    } else {
        throw new Exception('User profile not found');
    }

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();
echo json_encode($response);
?>