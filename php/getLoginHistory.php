<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

try {
    $sql = "SELECT 
                CONCAT(u.FirstName, ' ', u.LastName) as Name,
                l.LoginDate as TimeIn,
                l.LogoutDate as TimeOut
            FROM LoginAudit l
            JOIN UserProfile u ON l.Email = u.Email
            ORDER BY l.LoginDate DESC";
            
    $result = $conn->query($sql);
    $loginHistory = array();
    
    while($row = $result->fetch_assoc()) {
        $loginHistory[] = $row;
    }
    
    echo json_encode([
        'status' => 'success',
        'data' => $loginHistory
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>