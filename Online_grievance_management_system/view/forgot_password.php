<?php
include '../include/conn.php';

$msg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if($new_password != $confirm_password){
        $msg = "❌ Passwords do not match";
    }
    else{

        // 🔍 CHECK STUDENT
        $student = mysqli_query($conn, "SELECT * FROM student WHERE email='$email'");
        
        if(mysqli_num_rows($student) > 0){
            mysqli_query($conn, "UPDATE student SET mypswd='$new_password' WHERE email='$email'");
            $msg = "✅ Student password updated successfully";
        }

        // 🔍 CHECK STAFF
        else{
            $staff = mysqli_query($conn, "SELECT * FROM staff WHERE email='$email'");

            if(mysqli_num_rows($staff) > 0){
                mysqli_query($conn, "UPDATE staff SET password='$new_password' WHERE email='$email'");
                $msg = "✅ Staff password updated successfully";
            }

            // 🔍 CHECK HOD
            else{
                $hod = mysqli_query($conn, "SELECT * FROM staff WHERE email='$email' AND design='HOD'");

                if(mysqli_num_rows($hod) > 0){
                    mysqli_query($conn, "UPDATE hod SET password='$new_password' WHERE email='$email'");
                    $msg = "✅ HOD/Admin password updated successfully";
                }

                // 🔍 CHECK ADMIN / PRINCIPAL (optional table)
                else{
                    $admin = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");

                    if(mysqli_num_rows($admin) > 0){
                        mysqli_query($conn, "UPDATE admin SET mypswd='$new_password' WHERE email='$email'");
                        $msg = "✅ Admin/Principal password updated successfully";
                    }
                    else{
                        $msg = "❌ Email not found in any role";
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Forgot Password</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    display:flex;
    justify-content:center;
    align-items:center;
    height:100vh;
}

.box{
    background:white;
    padding:30px;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
    width:350px;
}

h2{
    text-align:center;
    margin-bottom:20px;
}

input{
    width:100%;
    padding:10px;
    margin:10px 0;
    border-radius:6px;
    border:1px solid #ccc;
}

button{
    width:100%;
    padding:10px;
    background:#1f7a8c;
    color:white;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

button:hover{
    background:#145f6b;
}

.msg{
    text-align:center;
    margin-bottom:10px;
    font-weight:bold;
}
</style>
</head>

<body>

<div class="box">

<h2>Forgot Password</h2>

<?php if($msg != ""){ ?>
<div class="msg"><?php echo $msg; ?></div>
<?php } ?>

<form method="POST">

<label>Email</label>
<input type="email" name="email" required>

<label>New Password</label>
<input type="password" name="new_password" required>

<label>Confirm Password</label>
<input type="password" name="confirm_password" required>

<button type="submit">Reset Password</button>

</form>

<br>
<div style="text-align:center;">
<a href="../view/loginb.php">← Back to Login</a>
</div>

</div>

</body>
</html>