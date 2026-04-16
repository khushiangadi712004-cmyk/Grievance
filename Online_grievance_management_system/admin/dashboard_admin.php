<?php
session_start();
include '../include/conn.php';

// 👉 HANDLE ACTION
if(isset($_POST['action'])){
    
    $id = $_POST['id'];
    $remark = $_POST['remark'];
    $date = date("Y-m-d H:i:s");

    if($_POST['action']=="progress"){
        $status = "In Progress";
    }
    elseif($_POST['action']=="resolve"){
        $status = "Resolved";
    }
    elseif($_POST['action']=="escalate"){
        $status = "Escalated";
    }

    mysqli_query($conn,"UPDATE complaint 
        SET status='$status', remark='$remark', date_resolved='$date'
        WHERE complaint_id='$id'
    ");

    header("Location: dashboard_admin.php");
}

// 👉 VIEW MODE
$view_id = isset($_GET['id']) ? $_GET['id'] : null;
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Dashboard</title>

<style>
body{font-family:Arial;background:#f4f6f9;margin:0;padding:10px;}
.card{
    background:#fff;padding:15px;border-radius:10px;
    display:inline-block;width:180px;margin:10px;text-align:center;
}
.box{
    background:#fff;padding:15px;border-radius:10px;margin-top:15px;
}
.btn{
    padding:8px 12px;text-decoration:none;border-radius:6px;
    color:white;display:inline-block;border:none;cursor:pointer;
}
.blue{background:#007bff;}
.green{background:#28a745;}
.red{background:#dc3545;}

.status{
    padding:4px 10px;border-radius:20px;font-size:12px;font-weight:bold;
}
.pending{ background:#fff3cd; color:#856404; }
.progress{ background:#cce5ff; color:#004085; }
.resolved{ background:#d4edda; color:#155724; }
.escalated{ background:#f8d7da; color:#721c24; }

textarea{width:100%;padding:10px;border-radius:8px;}
a{ text-decoration:none; }
</style>

</head>

<body>

<h2>Admin Dashboard</h2>

<?php if($view_id == null){ ?>

<!-- ================= DASHBOARD ================= -->

<?php
$total = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaint"))['c'];
$pending = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaint WHERE status='Pending'"))['c'];
$progress = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaint WHERE status='In Progress'"))['c'];
$resolved = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaint WHERE status='Resolved'"))['c'];
$escalated = mysqli_fetch_assoc(mysqli_query($conn,"SELECT COUNT(*) c FROM complaint WHERE status='Escalated'"))['c'];

// ✅ JOIN QUERY
$data = mysqli_query($conn,"
SELECT c.*, 
       s.sname, s.email,
       d.dept_name,
       cat.category_name
FROM complaint c
LEFT JOIN student s ON c.register_no = s.register_no
LEFT JOIN department d ON c.department_no = d.department_no
LEFT JOIN category cat ON c.category_id = cat.category_id
ORDER BY c.complaint_id DESC
");
?>

<!-- CARDS -->
<div class="card">Total <h2><?= $total ?></h2></div>
<div class="card">Pending <h2><?= $pending ?></h2></div>
<div class="card">In Progress <h2><?= $progress ?></h2></div>
<div class="card">Resolved <h2><?= $resolved ?></h2></div>
<div class="card">Escalated <h2><?= $escalated ?></h2></div>

<h3>Complaints</h3>

<?php while($row = mysqli_fetch_assoc($data)) { 

$status = $row['status'];
$class = "";

if($status=="Pending") $class="pending";
elseif($status=="In Progress") $class="progress";
elseif($status=="Resolved") $class="resolved";
elseif($status=="Escalated") $class="escalated";
?>

<div class="box">

<b>GRV-<?= $row['complaint_id'] ?></b>

<span class="status <?= $class ?>">
<?= $status ?>
</span>

<p><?= $row['description'] ?></p>

<small>
User: 
<a href="user_profile.php?reg=<?= $row['register_no'] ?>">
<?= $row['sname'] ?>
</a> 
(<?= $row['email'] ?>) <br>

Dept: <?= $row['dept_name'] ?> <br>
Category: <?= $row['category_name'] ?> <br>
Date: <?= $row['date_submitted'] ?>
</small>

<br><br>

<a class="btn blue" href="dashboard_admin.php?id=<?= $row['complaint_id'] ?>">
View →
</a>

</div>

<?php } ?>

<?php } else { ?>

<!-- ================= VIEW PAGE ================= -->

<?php
$data = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT c.*, 
       s.sname, s.email,
       d.dept_name,
       cat.category_name
FROM complaint c
LEFT JOIN student s ON c.register_no = s.register_no
LEFT JOIN department d ON c.department_no = d.department_no
LEFT JOIN category cat ON c.category_id = cat.category_id
WHERE c.complaint_id='$view_id'
"));
?>

<div class="box">

<a href="dashboard_admin.php">← Back</a>

<h2>Complaint #<?= $data['complaint_id'] ?></h2>

<h3>Description</h3>
<p><?= $data['description'] ?></p>

<hr>

<h3>User Details</h3>
<p><b>Name:</b> <?= $data['sname'] ?></p>
<p><b>Email:</b> <?= $data['email'] ?></p>
<p><b>Department:</b> <?= $data['dept_name'] ?></p>
<p><b>Category:</b> <?= $data['category_name'] ?></p>

<p><b>Status:</b> <?= $data['status'] ?></p>
<p><b>Remark:</b> <?= $data['remark'] ?></p>

<p><b>Submitted:</b> <?= $data['date_submitted'] ?></p>
<p><b>Resolved:</b> <?= $data['date_resolved'] ?></p>

</div>

<div class="box">

<h3>Take Action</h3>

<form method="POST">

<input type="hidden" name="id" value="<?= $data['complaint_id'] ?>">

<textarea name="remark" placeholder="Add remarks..."></textarea>

<br><br>

<button class="btn blue" name="action" value="progress">In Progress</button>
<button class="btn green" name="action" value="resolve">Resolve</button>
<button class="btn red" name="action" value="escalate">Escalate</button>

</form>

</div>

<?php } ?>

</body>
</html>