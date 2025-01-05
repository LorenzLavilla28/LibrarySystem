<?php
include __DIR__ . '/../config/databaseConnection.php';
session_start();
header('Content-Type: application/json');

$response = array(
    'status' => 'error',
    'message' => 'Invalid request'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('User not logged in');
        }

        $userId = $_SESSION['user_id'];
        $oldPassword = $_POST['oldPassword'];
        $newPassword = $_POST['newPassword'];
        $newEmail = $_POST['email'];
        $changes = false;
        $stmt = null;

        // Check if email is being changed
        if ($newEmail !== $_SESSION['email']) {
            // Check if new email already exists
            $checkEmail = "SELECT Email FROM UserProfile WHERE Email = ? AND UserId != ?";
            $stmt = $conn->prepare($checkEmail);
            $stmt->bind_param("ss", $newEmail, $userId);
            $stmt->execute();
            if ($stmt->get_result()->num_rows > 0) {
                throw new Exception('Email already exists');
            }

            // Update email
            $sql = "UPDATE UserProfile SET Email = ? WHERE UserId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $newEmail, $userId);
            if ($stmt->execute()) {
                $_SESSION['email'] = $newEmail;
                $changes = true;
            }
        }

        // Handle password update if provided
        if (!empty($newPassword)) {
            if (empty($oldPassword)) {
                throw new Exception('Current password is required to set new password');
            }

            // Check old password
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
            $password = password_hash($newPassword, PASSWORD_DEFAULT);
            $sql = "UPDATE UserProfile SET Password = ? WHERE UserId = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $password, $userId);
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

        if ($stmt) {
            $stmt->close();
        }
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    $conn->close();
}

echo json_encode($response);
?>