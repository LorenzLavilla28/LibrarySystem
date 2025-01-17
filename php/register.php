<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

function generateGUID() {
    $bytes = random_bytes(10);
    return bin2hex($bytes);
}

$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $email = $_POST['email'];
        $contactNumber = $_POST['contactNumber'];

        // Check if email exists
        $checkEmail = "SELECT Email FROM UserProfile WHERE Email = ?";
        $checkStmt = $conn->prepare($checkEmail);
        $checkStmt->bind_param("s", $email);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $response['message'] = 'Email already exists';
            echo json_encode($response);
            exit;
        }

        // Check if Student ID exists
        $studentId = $_POST['studentId'];
        $checkStudentId = "SELECT StudentId FROM UserProfile WHERE StudentId = ?";
        $checkStmt = $conn->prepare($checkStudentId);
        $checkStmt->bind_param("s", $studentId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        
        if ($result->num_rows > 0) {
            $response['message'] = 'Student ID already exists';
            echo json_encode($response);
            exit;
        }
        
        $userId = generateGUID();
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        // Updated SQL to include ContactNumber
        $sql = "INSERT INTO UserProfile (UserId, FirstName, LastName, Email, Password, Role, StudentId, ContactNumber) 
                VALUES (?, ?, ?, ?, ?, 'Student', ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssss", $userId, $firstName, $lastName, $email, $password, $studentId, $contactNumber);
        
        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Registration successful!';
        } else {
            throw new Exception($stmt->error);
        }

    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
?>