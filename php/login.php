<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Updated query to use UserProfile table
        $sql = "SELECT * FROM UserProfile WHERE Email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['Password'])) {
                $response = array(
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user' => array(
                        'id' => $user['UserId'],
                        'firstName' => $user['FirstName'],
                        'lastName' => $user['LastName'],
                        'email' => $user['Email'],
                        'role' => $user['Role']
                    )
                );
            } else {
                $response['message'] = 'Invalid password';
            }
        } else {
            $response['message'] = 'Email not found';
        }
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>