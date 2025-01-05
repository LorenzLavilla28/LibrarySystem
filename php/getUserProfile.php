<?php
include __DIR__ . '/../config/databaseConnection.php';
session_start();

header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Unknown error occurred');

try {
    if (!isset($_SESSION['user_id'])) {
        throw new Exception('User not logged in');
    }

    $userId = $_SESSION['user_id'];
    
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