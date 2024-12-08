<?php
include __DIR__ . '/../config/databaseConnection.php';

header('Content-Type: application/json');
$response = array(
    'status' => 'error',
    'message' => 'Invalid request'
);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        if (empty($_POST['email']) || empty($_POST['password'])) {
            $response['message'] = 'Email and password are required';
            echo json_encode($response);
            exit;
        }

        $email = trim($_POST['email']);
        $password = $_POST['password'];

        $sql = "SELECT UserId, FirstName, LastName, Email, Password FROM UserProfile WHERE Email = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['Password'])) {
                session_start();
                $_SESSION['user_id'] = $row['UserId'];
                $_SESSION['first_name'] = $row['FirstName'];
                $_SESSION['last_name'] = $row['LastName'];
                $_SESSION['email'] = $row['Email'];
                
                $response['status'] = 'success';
                $response['message'] = 'Login successful!';
                $response['user'] = array(
                    'firstName' => $row['FirstName'],
                    'lastName' => $row['LastName']
                );
            } else {
                $response['message'] = 'Invalid email or password';
            }
        } else {
            $response['message'] = 'Invalid email or password';
        }

        $stmt->close();
    } catch (Exception $e) {
        $response['message'] = 'An error occurred during login';
    }
    
    $conn->close();
}

echo json_encode($response);
exit;
?>