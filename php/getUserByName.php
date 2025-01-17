<?php
// filepath: /c:/xampp/htdocs/librarysystem/php/getUserByName.php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($data['firstName'], $data['lastName'])) {
        throw new Exception('Missing required data');
    }

    $sql = "SELECT StudentId, FirstName, LastName, Email, ContactNumber, Grade, Section, Adviser 
            FROM UserProfile 
            WHERE FirstName = ? AND LastName = ?";
            
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $data['firstName'], $data['lastName']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($user = $result->fetch_assoc()) {
        $response = array(
            'status' => 'success',
            'user' => $user
        );
    } else {
        throw new Exception('User not found');
    }

    $stmt->close();

} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>