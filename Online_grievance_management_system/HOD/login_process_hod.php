<?php
session_start();
include '../include/conn.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST['email'];
    $mypswd = $_POST['mypswd'];

    $query = "SELECT * FROM staff WHERE email='$email' AND design='HOD'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0){

        $row = mysqli_fetch_assoc($result);

        // ✅ CORRECT PASSWORD CHECK
        if(password_verify($mypswd, $row['password'])){

            $_SESSION['staff_id'] = $row['staff_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['name'] = $row['stname']; 
            $_SESSION['design'] = $row['design'];

            header("Location: dashboard_hod.php");
            exit();

        } else {
            echo "<script>alert('Invalid Password'); window.location='../view/HOD_login.php';</script>";
        }

    } else {
        echo "<script>alert('HOD not found'); window.location='../view/HOD_login.php';</script>";
    }

} else {
    header("Location: ../view/HOD_login.php");
}
?>