<?php
session_start();
include '../include/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $email = strtolower($email);
    $password = $_POST['password'];

    // 👇 Check in staff table
    $stmt = $conn->prepare("SELECT * FROM staff WHERE LOWER(email)=? OR staff_id=?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        // ✅ Password check
        if (password_verify($password, $row['password'])) {

            // ✅ Store session
            $_SESSION['staff_id'] = $row['staff_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['role'] = "staff";

            header("Location: dashboard_staff.php");
            exit();

        } else {
            echo "<script>alert('Wrong Password'); window.location='../staff/staff_login.php';</script>";
        }

    } else {
        echo "<script>alert('Staff not found'); window.location='../staff/staff_login.php';</script>";
    }

    $stmt->close();
}
?>