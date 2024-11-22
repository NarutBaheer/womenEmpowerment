<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost:3307'; 
$dbname = 'website_forms';
$username = 'root';
$password = ''; 

// connection created
$conn = new mysqli($host, $username, $password, $dbname);

// Checking connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['contact-name'];
    $email = $_POST['contact-email'];
    $company = $_POST['contact-company'];
    $userMessage = $_POST['contact-message'];

    $sql = "INSERT INTO contactsubmissions (full_name, email, company, message) VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("ssss", $fullName, $email, $company, $userMessage);

    if ($stmt->execute()) {
        $message = "New record created successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>