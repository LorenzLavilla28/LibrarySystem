<?php
include __DIR__ . '/../config/databaseConnection.php';
session_start();
header('Content-Type: application/json');

try {
    // Set timezone to local
    date_default_timezone_set('Asia/Manila');
    
    // Check if user exists in session
    if (!isset($_SESSION['user'])) {
        throw new Exception('No active session found');
    }

    // Handle logout based on user role
    if ($_SESSION['user']['role'] === 'Admin' || $_SESSION['user']['role'] === 'superadmin') {
        // Just destroy session for admin users
        session_destroy();
        echo json_encode([
            'status' => 'success',
            'message' => 'Admin logged out successfully'
        ]);
    } else {
        // Non-admin users - update login audit
        if (!isset($_SESSION['actionId'])) {
            throw new Exception('No action ID found for user');
        }

        $actionId = $_SESSION['actionId'];
        $currentDateTime = date('Y-m-d h:i:s A');
        
        $sql = "UPDATE LoginAudit 
                SET LogoutDate = ?, 
                    IsLoggedOut = 1 
                WHERE ActionId = ? 
                AND IsLoggedOut = 0";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $currentDateTime, $actionId);
        
        if ($stmt->execute()) {
            session_destroy();
            echo json_encode([
                'status' => 'success',
                'message' => 'Logged out successfully'
            ]);
        } else {
            throw new Exception('Failed to update logout record');
        }
    }
    
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Logout failed: ' . $e->getMessage()
    ]);
}
exit;
?>