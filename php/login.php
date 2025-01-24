<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Set timezone to local
        date_default_timezone_set('Asia/Manila');

        // Generate GUID
        $actionId = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );

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
                // Start session if not already started
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                
                // Only create login audit for non-admin users
                if ($user['Role'] !== 'Admin' && $user['Role'] !== 'superadmin' ) {
                    // Format date in 12-hour format with AM/PM
                    $currentDateTime = date('Y-m-d h:i:s A');
                    $auditSql = "INSERT INTO LoginAudit (ActionId, Email, LoginDate, IsLoggedOut) 
                               VALUES (?, ?, ?, 0)";
                    $auditStmt = $conn->prepare($auditSql);
                    $auditStmt->bind_param("sss", $actionId, $email, $currentDateTime);
                    $auditStmt->execute();
        
                    // Store actionId in session for non-admin
                    $_SESSION['actionId'] = $actionId;
                }
        
                $_SESSION['user'] = array(
                    'id' => $user['UserId'],
                    'firstName' => $user['FirstName'],
                    'lastName' => $user['LastName'],
                    'email' => $user['Email'],
                    'role' => $user['Role']
                );
        
                $response = array(
                    'status' => 'success',
                    'message' => 'Login successful',
                    'user' => $_SESSION['user']
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