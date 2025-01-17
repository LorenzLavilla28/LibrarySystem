<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $userId = $_POST['userId'] ?? '';
        $firstName = $_POST['firstName'] ?? '';
        $lastName = $_POST['lastName'] ?? '';
        $email = $_POST['email'] ?? '';
        $oldPassword = $_POST['oldPassword'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        
        if (empty($userId)) {
            throw new Exception('User ID is required');
        }

        $changes = false;
        
        // Update basic info
        $sql = "UPDATE UserProfile SET FirstName = ?, LastName = ?, Email = ? WHERE UserId = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $firstName, $lastName, $email, $userId);
        
        if ($stmt->execute()) {
            $changes = true;
        }

        // Update password if provided
        if (!empty($newPassword)) {
            if (empty($oldPassword)) {
                throw new Exception('Current password is required');
            }

            // Verify old password
            $checkPass = "SELECT Password FROM UserProfile WHERE UserId = ?";
            $stmt = $conn->prepare($checkPass);
            $stmt->bind_param("s", $userId);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if (!password_verify($oldPassword, $user['Password'])) {
                throw new Exception('Current password is incorrect');
            }

            // Update password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE UserProfile SET Password = ? WHERE UserId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $hashedPassword, $userId);
            if ($stmt->execute()) {
                $changes = true;
            }
        }

        if ($changes) {
            $response['status'] = 'success';
            $response['message'] = 'Profile updated successfully!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'No changes made';
        }

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
?>