<?php
include '../include/conn.php';

$name = "New Admin";
$email = "admin@college.com";
$password = "admin123";

// Hash password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO admin (aname, email, mypswd, phone) VALUES (?, ?, ?, ?)");
$phone = "9876543210";

$stmt->bind_param("ssss", $name, $email, $hashedPassword, $phone);

if($stmt->execute()){
    echo "Admin inserted successfully!";
} else {
    echo "Error: " . $stmt->error;
}
?>