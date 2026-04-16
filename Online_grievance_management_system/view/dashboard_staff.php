<?php
session_start();
include '../include/conn.php';

/* ================== COUNT DATA ================== */

// Total complaints
$total = 0;
$total_query = "SELECT COUNT(*) AS total FROM complaint";
$total_result = mysqli_query($conn, $total_query);
if($total_result){
    $row = mysqli_fetch_assoc($total_result);
    $total = $row['total'];
}

// Pending
$pending = 0;
$pending_query = "SELECT COUNT(*) AS pending FROM complaint WHERE status='Pending'";
$pending_result = mysqli_query($conn, $pending_query);
if($pending_result){
    $row = mysqli_fetch_assoc($pending_result);
    $pending = $row['pending'];
}

// Resolved
$resolved = 0;
$resolved_query = "SELECT COUNT(*) AS resolved FROM complaint WHERE status='Resolved'";
$resolved_result = mysqli_query($conn, $resolved_query);
if($resolved_result){
    $row = mysqli_fetch_assoc($resolved_result);
    $resolved = $row['resolved'];
}

/* ================== RECENT COMPLAINTS ================== */

$complaints_query = "SELECT * FROM complaint ORDER BY complaint_id DESC LIMIT 5";
$complaints = mysqli_query($conn, $complaints_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Staff Dashboard</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:Arial;
}

body{
display:flex;
background:#f4f6f9;
}

.sidebar{
width:240px;
height:100vh;
background:linear-gradient(135deg,#0f3d56,#1f7a8c);
color:white;
padding:25px;
}

.sidebar h2{
margin-bottom:30px;
text-align:center;
}

.sidebar a{
display:block;
color:white;
text-decoration:none;
padding:12px;
margin:10px 0;
border-radius:6px;
transition:0.3s;
}

.sidebar a:hover{
background:rgba(255,255,255,0.2);
}

.main{
flex:1;
padding:30px;
}

.header{
display:flex;
justify-content:space-between;
align-items:center;
margin-bottom:30px;
}

.header h1{
color:#0f3d56;
}

.cards{
display:grid;
grid-template-columns:repeat(3,1fr);
gap:20px;
margin-bottom:30px;
}

.card{
background:white;
padding:20px;
border-radius:10px;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
text-align:center;
}

.card h3{
color:#1f7a8c;
margin-bottom:10px;
}

table{
width:100%;
border-collapse:collapse;
background:white;
border-radius:10px;
overflow:hidden;
box-shadow:0 2px 10px rgba(0,0,0,0.1);
text-align:center;
}

table th{
background:#0f3d56;
color:white;
padding:12px;
}

table td{
padding:12px;
border-bottom:1px solid #eee;
}

.status{
padding:5px 10px;
border-radius:5px;
font-size:12px;
}

.pending{
background:#ffc107;
color:black;
}

.progress{
background:#17a2b8;
color:white;
}

.resolved{
background:#28a745;
color:white;
}

</style>

</head>

<body>

<!-- Sidebar -->
<div class="sidebar">

<h2>Grievance System</h2>

<a href="dashboard_staff.php"><i class="fa fa-home"></i> Dashboard</a>
<a href="../user/submit_com.php"><i class="fa fa-edit"></i> Submit Complaint</a>
<a href="dashboard_staff"><i class="fa fa-list"></i> My Complaints</a>
<a href="profile.php"><i class="fa fa-user"></i> Profile</a>
<a href="../user/logout.php"><i class="fa fa-sign-out"></i> Logout</a>

</div>

<!-- Main Content -->
<div class="main">

<div class="header">
<h1>Welcome, Staff</h1>
</div>

<!-- Cards -->
<div class="cards">

<div class="card">
<h3>Total Complaints</h3>
<p><?php echo $total; ?></p>
</div>

<div class="card">
<h3>Pending</h3>
<p><?php echo $pending; ?></p>
</div>

<div class="card">
<h3>Resolved</h3>
<p><?php echo $resolved; ?></p>
</div>

</div>

<!-- Table -->
<h2 style="margin-bottom:10px;">Recent Complaints</h2>

<table>

<tr>
<th>ID</th>
<th>Category</th>
<th>Description</th>
<th>Status</th>
</tr>

<?php
if($complaints && mysqli_num_rows($complaints) > 0){
    while($row = mysqli_fetch_assoc($complaints)){
?>

<tr>
<td><?php echo $row['complaint_id']; ?></td>
<td><?php echo $row['category_id']; ?></td>
<td><?php echo $row['description']; ?></td>

<td>
<span class="status 
<?php 
if($row['status']=='Pending') echo 'pending';
elseif($row['status']=='In Progress') echo 'progress';
else echo 'resolved';
?>">
<?php echo $row['status']; ?>
</span>
</td>

</tr>

<?php
    }
} else {
    echo "<tr><td colspan='4'>No complaints found</td></tr>";
}
?>

</table>

</div>

</body>
</html>