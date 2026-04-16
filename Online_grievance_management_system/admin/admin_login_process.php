<?php
session_start();
include '../include/conn.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $password = trim($_POST['mypswd']);

    $stmt = $conn->prepare("SELECT * FROM admin WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){

        $row = $result->fetch_assoc();

        // ✅ HASH CHECK
        if(password_verify($password, $row['mypswd'])){

            $_SESSION['admin_id'] = $row['admin_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['aname'];

            header("Location: dashboard_admin.php");
            exit();

        } else {
            echo "<script>alert('Wrong Password'); window.location='../admin/admin_login.php';</script>";
        }

    } else {
        echo "<script>alert('Admin not found'); window.location='../admin/admin_login.php';</script>";
    }

} else {
    header("Location: ../view/admin_login.php");
}
?>