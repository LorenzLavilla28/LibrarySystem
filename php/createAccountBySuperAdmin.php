<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

function generateGUID() {
    $bytes = random_bytes(10);
    $uniqueId = bin2hex($bytes);
    return $uniqueId;
}

$response = array(
    'status' => 'error',
    'message' => 'Invalid request'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Check if email already exists
        $email = $_POST['email'];
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

        $userId = generateGUID();
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];

        // If role is Student, require StudentId
        if ($role === 'Student') {
            if (empty($_POST['studentId'])) {
                $response['message'] = 'Student ID is required for student accounts';
                echo json_encode($response);
                exit;
            }
            $studentId = $_POST['studentId'];
            
            // Check if Student ID exists
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

            $sql = "INSERT INTO UserProfile (UserId, FirstName, LastName, Email, Password, Role, StudentId) 
                    VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssssss", $userId, $firstName, $lastName, $email, $password, $role, $studentId);
        } else {
            // For Admin accounts, don't include StudentId
            $sql = "INSERT INTO UserProfile (UserId, FirstName, LastName, Email, Password, Role) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $userId, $firstName, $lastName, $email, $password, $role);
        }

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Account created successfully!';
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
?>