<?php
include __DIR__ . '/../config/databaseConnection.php';
header('Content-Type: application/json');

$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            throw new Exception('Password is required');
        }

        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $userId = bin2hex(random_bytes(10)); // Generate unique user ID

        $sql = "INSERT INTO UserProfile (UserId, StudentId, FirstName, LastName, Email, Password, ContactNumber, Grade, Section, Adviser, Role) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Student')";
                
        $stmt = $conn->prepare($sql);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("ssssssssss", 
            $userId,
            $_POST['studentId'],
            $_POST['firstName'],
            $_POST['lastName'],
            $_POST['email'],
            $hashedPassword,
            $_POST['contactNumber'],
            $_POST['grade'],
            $_POST['section'],
            $_POST['adviser']
        );

        if ($stmt->execute()) {
            $response = array(
                'status' => 'success',
                'message' => 'Registration successful!'
            );
        } else {
            throw new Exception($stmt->error);
        }

        $stmt->close();

    } catch (Exception $e) {
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
?>