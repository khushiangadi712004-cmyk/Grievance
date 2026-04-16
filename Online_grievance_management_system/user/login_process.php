<?php
session_start();
include '../include/conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $email = strtolower($email);
    $mypswd = $_POST['mypswd'];

    $stmt = $conn->prepare("SELECT * FROM student WHERE LOWER(email)=? OR register_no=?");
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        if (password_verify($mypswd, $row['mypswd'])) {

            $_SESSION['register_no'] = $row['register_no'];
            $_SESSION['email'] = $row['email'];

            header("Location: dashboard_user.php");
            exit();

        } else {
            echo "<script>alert('Wrong Password'); window.location='../view/loginb.php';</script>";
        }

    } else {
        echo "<script>alert('User not found'); window.location='../view/loginb.php';</script>";
    }

    $stmt->close();
}
?>