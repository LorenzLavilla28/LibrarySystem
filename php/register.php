<?php
// Prevent any output before JSON response
ob_clean();

include __DIR__ . '/../config/databaseConnection.php';

function generateGUID() {
    $bytes = random_bytes(10);
    $uniqueId = bin2hex($bytes);
    return $uniqueId;
}

header('Content-Type: application/json');

$response = array(
    'status' => 'error',
    'message' => 'Invalid request'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $userId = generateGUID();
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO UserProfile (UserId, FirstName, LastName, Email, Password) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $userId, $firstName, $lastName, $email, $password);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Registration successful!';
        } else {
            $response['message'] = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    $conn->close();
}

echo json_encode($response);
exit;
?>