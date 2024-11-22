<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost:3307';
$dbname = 'website_forms';
$username = 'root';
$password = ''; 


$conn = new mysqli($host, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['ticket-form-name'];
    $email = $_POST['ticket-form-email'];
    $phone = $_POST['ticket-form-phone'];
    $donationType = $_POST['TicketForm'];
    $donationAmount = $_POST['ticket-form-number'];
    $additionalInfo = $_POST['ticket-form-message'];
    $createdAt = date('Y-m-d H:i:s'); // Capturing the current date and time

    $sql = "INSERT INTO ticketsubmissions (full_name, email, phone, donation_type, donation_amount, additional_info, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die('MySQL prepare error: ' . $conn->error);
    }

    $stmt->bind_param("ssssiss", $fullName, $email, $phone, $donationType, $donationAmount, $additionalInfo, $createdAt);

    if ($stmt->execute()) {
        $message = "New record created successfully";
    } else {
        $message = "Error: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>
