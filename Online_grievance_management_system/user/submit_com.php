<?php
session_start();
include '../include/conn.php';

if(isset($_POST['submit']))
{
    $category_id = $_POST['category_id'];
    $department_no = $_POST['department_no'];
    $description = $_POST['description'];

    $file = $_FILES['file_upload']['name'];
    $tmp = $_FILES['file_upload']['tmp_name'];

    $target = "../uploads/".$file;
    move_uploaded_file($tmp,$target);

    $status = "Pending";

    $register_no = "NULL";
    $staff_id = "NULL";

    // 👇 Check who is submitting
    if($_SESSION['role'] == "student"){
        $register_no = "'".$_SESSION['register_no']."'";
    }
    else if($_SESSION['role'] == "staff"){
        $staff_id = "'".$_SESSION['staff_id']."'";
    }

    $sql = "INSERT INTO complaint
    (register_no, staff_id, category_id, department_no, description, file_upload, status, date_submitted)
    VALUES
    ($register_no, $staff_id, '$category_id', '$department_no', '$description', '$file', '$status', NOW())";

    mysqli_query($conn,$sql);

    echo "<script>alert('Complaint Sent to HOD Successfully');</script>";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Submit Complaint</title>

<style>

body{
font-family: Arial;
background:#f4f6f9;
}

.container{
width:60%;
margin:auto;
margin-top:40px;
background:white;
padding:30px;
border-radius:8px;
box-shadow:0 0 10px rgba(0,0,0,0.1);
}

h2{
margin-bottom:20px;
}

input,select,textarea{
width:100%;
padding:10px;
margin-top:10px;
margin-bottom:20px;
border:1px solid #ccc;
border-radius:5px;
}

textarea{
height:120px;
}

button{
padding:10px 20px;
background:#1d3c78;
color:white;
border:none;
border-radius:5px;
cursor:pointer;
}

</style>

</head>

<body>

<div class="container">

<h2>Submit New Complaint</h2>

<form method="POST" enctype="multipart/form-data">

<label>Category</label>
<select name="category_id" required>

<option value="">Select Category</option>
<option value="1">Academic</option>
<option value="2">Infrastructure</option>
<option value="3">Administration</option>

</select>

<label>Department</label>
<select name="department_no" required>

<option value="">Select Department</option>
<option value="1">BCA</option>
<option value="2">BSC</option>
<option value="3">B.COM</option>
<option value="4">BBA</option>


</select>

<label>Description</label>
<textarea name="description" placeholder="Describe your grievance in detail..." required></textarea>

<label>Upload File</label>
<input type="file" name="file_upload">

<button type="submit" name="submit">Submit</button>

</form>

</div>

</body>
</html>