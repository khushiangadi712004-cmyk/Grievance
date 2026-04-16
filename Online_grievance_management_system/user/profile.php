<?php
session_start();
include '../include/conn.php';

// 🔒 Check login
if(!isset($_SESSION['register_no'])){
    header("Location: login.php");
    exit();
}

$register_no = $_SESSION['register_no'];

// ✅ Fetch user data WITH department JOIN
$query = mysqli_query($conn, "
SELECT s.*, d.dept_name 
FROM student s
LEFT JOIN department d ON s.department_no = d.department_no
WHERE s.register_no='$register_no'
");

$row = mysqli_fetch_assoc($query);

// ✅ Assign values safely
$name = $row['sname'] ?? '';
$email = $row['email'] ?? '';
$department = $row['dept_name'] ?? 'Not assigned';
$role = $_SESSION['role'] ?? "Student";
$prn = $row['register_no'] ?? '';
$contact = $row['phone'] ?? '';
$address = $row['address'] ?? '';
$state = $row['state'] ?? '';
$country = $row['country'] ?? '';

// 🔄 Update profile
if(isset($_POST['update'])){
    $name = $_POST['sname'];
    $contact = $_POST['contact'];
    $address = $_POST['address'];
    $state = $_POST['state'];
    $country = $_POST['country'];

    $update = "UPDATE student SET 
                sname='$name',
                phone='$contact',
                address='$address',
                state='$state',
                country='$country'
                WHERE register_no='$register_no'";

    if(mysqli_query($conn, $update)){
        echo "<script>alert('Profile Updated Successfully'); window.location='profile.php';</script>";
    } else {
        echo "<script>alert('Update Failed');</script>";
    }
}

// ✏️ Edit mode
$edit = isset($_GET['edit']);

// Avatar initial
$initial = strtoupper(substr($name,0,1));
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
body{
font-family:Arial;
background:#f4f6fb;
margin:0;
}

.header{
display:flex;
justify-content:space-between;
padding:15px 30px;
background:white;
box-shadow:0 2px 6px rgba(0,0,0,0.1);
}

.role{
background:#e8f1ff;
color:#2b6cb0;
padding:4px 10px;
border-radius:15px;
font-size:12px;
}

.container{
width:70%;
margin:40px auto;
}

.profile-card{
background:white;
border-radius:12px;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
overflow:hidden;
margin-bottom:20px;
}

.banner{
height:120px;
background:linear-gradient(135deg,#0f3d56,#1f7a8c);
}

.profile-info{
padding:20px;
position:relative;
}

.avatar{
width:80px;
height:80px;
border-radius:50%;
background:#f1b300;
color:white;
display:flex;
align-items:center;
justify-content:center;
font-size:30px;
font-weight:bold;
border:4px solid white;
position:absolute;
top:-40px;
left:20px;
}

.name{
margin-top:40px;
font-size:22px;
font-weight:bold;
}

.edit-btn{
float:right;
background:#f2f2f2;
padding:8px 14px;
border-radius:6px;
text-decoration:none;
color:black;
}

.details{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

.detail{
display:flex;
align-items:center;
margin:15px 0;
}

.detail i{
width:30px;
color:#0f3d56;
}

.label{
font-size:13px;
color:gray;
}

.value{
font-weight:bold;
}

input{
width:100%;
padding:8px;
border:1px solid #ccc;
border-radius:5px;
}

.save-btn{
background:#0f3d56;
color:white;
border:none;
padding:10px;
border-radius:6px;
cursor:pointer;
margin-top:10px;
}
</style>
</head>

<body>

<div class="header">
<div>
<span class="logo">GrievanceDesk</span>
<span class="role"><?php echo $role ?></span>
</div>
<div><?php echo $name ?></div>
</div>

<div class="container">

<div class="profile-card">
<div class="banner"></div>

<div class="profile-info">
<div class="avatar"><?php echo $initial ?></div>

<a class="edit-btn" href="profile.php?edit=1">
<i class="fa fa-edit"></i> Edit Profile
</a>

<div class="name"><?php echo $name ?></div>
</div>
</div>

<div class="details">
<h3>Profile Details</h3>

<form method="post">

<!-- Name -->
<div class="detail">
<i class="fa fa-user"></i>
<div style="width:100%">
<div class="label">Full Name</div>
<?php if($edit){ ?>
<input type="text" name="sname" value="<?php echo $name ?>">
<?php } else { ?>
<div class="value"><?php echo $name ?></div>
<?php } ?>
</div>
</div>

<!-- Email -->
<div class="detail">
<i class="fa fa-envelope"></i>
<div style="width:100%">
<div class="label">Email</div>
<div class="value"><?php echo $email ?></div>
</div>
</div>

<!-- Register No -->
<div class="detail">
<i class="fa fa-id-card"></i>
<div style="width:100%">
<div class="label">Register No</div>
<div class="value"><?php echo $prn ?></div>
</div>
</div>

<!-- Department -->
<div class="detail">
<i class="fa fa-building"></i>
<div style="width:100%">
<div class="label">Department</div>
<div class="value"><?php echo $department ?></div>
</div>
</div>

<!-- Contact -->
<div class="detail">
<i class="fa fa-phone"></i>
<div style="width:100%">
<div class="label">Contact</div>
<?php if($edit){ ?>
<input type="text" name="contact" value="<?php echo $contact ?>">
<?php } else { ?>
<div class="value"><?php echo $contact ?: 'Not set' ?></div>
<?php } ?>
</div>
</div>

<!-- Address -->
<div class="detail">
<i class="fa fa-map-marker-alt"></i>
<div style="width:100%">
<div class="label">Address</div>
<?php if($edit){ ?>
<input type="text" name="address" value="<?php echo $address ?>">
<?php } else { ?>
<div class="value"><?php echo $address ?: 'Not set' ?></div>
<?php } ?>
</div>
</div>

<!-- State -->
<div class="detail">
<i class="fa fa-globe"></i>
<div style="width:100%">
<div class="label">State</div>
<?php if($edit){ ?>
<input type="text" name="state" value="<?php echo $state ?>">
<?php } else { ?>
<div class="value"><?php echo $state ?: 'Not set' ?></div>
<?php } ?>
</div>
</div>

<!-- Country -->
<div class="detail">
<i class="fa fa-flag"></i>
<div style="width:100%">
<div class="label">Country</div>
<?php if($edit){ ?>
<input type="text" name="country" value="<?php echo $country ?>">
<?php } else { ?>
<div class="value"><?php echo $country ?: 'Not set' ?></div>
<?php } ?>
</div>
</div>

<?php if($edit){ ?>
<button class="save-btn" name="update">Save Changes</button>
<?php } ?>

</form>

</div>
</div>

</body>
</html>