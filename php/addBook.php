<?php
include __DIR__ . '/../config/databaseConnection.php';

function generateGUID() {
    $bytes = random_bytes(10);
    $uniqueId = bin2hex($bytes);
    return $uniqueId;
}

function checkISBNExists($conn, $isbn) {
    $sql = "SELECT Accession FROM Books WHERE Accession = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $isbn);
    $stmt->execute();
    $result = $stmt->get_result();
    $exists = $result->num_rows > 0;
    $stmt->close();
    return $exists;
}

header('Content-Type: application/json');
$response = array('status' => 'error', 'message' => 'Invalid request');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $bookId = generateGUID();
        $title = $_POST['title'];
        $author = $_POST['author'];
        $isbn = trim($_POST['accession']); // Clean ISBN input
        $quantity = $_POST['quantity'];
        $available = $quantity; // Set Available equal to Quantity

        // Debug ISBN value
        error_log("Received ISBN: " . $isbn);

        // Check if ISBN already exists
        if (checkISBNExists($conn, $isbn)) {
            $response['status'] = 'error';
            $response['message'] = 'Accession already exists in database';
            echo json_encode($response);
            exit;
        }

        $sql = "INSERT INTO Books (BookId, BookTitle, Author, Accession, Quantity, Available) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssii", $bookId, $title, $author, $isbn, $quantity, $available);

        if ($stmt->execute()) {
            $response['status'] = 'success';
            $response['message'] = 'Book added successfully!';
        } else {
            $response['message'] = 'Error adding book: ' . $stmt->error;
        }

        $stmt->close();
    } catch (Exception $e) {
        $response['message'] = 'Error: ' . $e->getMessage();
    }
    
    $conn->close();
}

echo json_encode($response);
?>