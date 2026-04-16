<?php
session_start();
include '../include/conn.php';

// 🔒 Login check
if(!isset($_SESSION['design']) || $_SESSION['design'] != 'HOD'){
    header("Location: ../view/HOD_login.php");
    exit();
}

// ✅ HANDLE ACTION
if(isset($_POST['action'])){
    $id = $_POST['id'];
    $remark = $_POST['remark'];

    if($_POST['action'] == 'progress'){
        $status = "In Progress";
    }
    elseif($_POST['action'] == 'resolve'){
        $status = "Resolved";
    }
    elseif($_POST['action'] == 'escalate'){
        $status = "Escalated";
    }
    else{
        $status = "Pending";
    }

    mysqli_query($conn, "UPDATE complaint 
                         SET status='$status', remark='$remark' 
                         WHERE complaint_id='$id'");

    header("Location: ".$_SERVER['PHP_SELF']);
    exit();
}

// 📊 Counts
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM complaint"))['c'];
$pending = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM complaint WHERE status='Pending'"))['c'];
$resolved = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM complaint WHERE status='Resolved'"))['c'];
$escalated = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as c FROM complaint WHERE status='Escalated'"))['c'];

// 📋 Fetch complaints (STUDENT + STAFF)
$query = mysqli_query($conn, "
SELECT 
    c.complaint_id,
    c.description,
    c.status,
    c.remark,
    c.date_submitted,

    (SELECT s.sname 
     FROM student s 
     WHERE s.register_no = c.register_no 
     LIMIT 1) AS sname,

    (SELECT st.stname 
     FROM staff st 
     WHERE st.staff_id = c.staff_id 
     LIMIT 1) AS stname,

    (SELECT d.dept_name 
     FROM department d 
     WHERE d.department_no = c.department_no 
     LIMIT 1) AS dept_name,

    (SELECT cat.category_name 
     FROM category cat 
     WHERE cat.category_id = c.category_id 
     LIMIT 1) AS category_name

FROM complaint c

ORDER BY c.complaint_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>HOD Dashboard</title>

<style>
body{
font-family:Arial;
background:#f4f6fb;
margin:0;
padding:20px;
}

h2{
background:#1f3c88;
color:white;
padding:10px;
border-radius:10px;
cursor:pointer;
}

.cards{
display:flex;
gap:20px;
margin:20px 0;
}

.card{
flex:1;
background:white;
padding:20px;
border-radius:12px;
box-shadow:0 2px 8px rgba(0,0,0,0.1);
text-align:center;
}

.card p{
font-size:22px;
font-weight:bold;
}

.box{
background:white;
padding:20px;
border-radius:12px;
margin-bottom:15px;
box-shadow:0 2px 8px rgba(0,0,0,0.1);
}

.tag{
padding:4px 10px;
border-radius:12px;
font-size:12px;
margin-left:10px;
background:#eee;
}

.pending{background:#ffe0b2;color:#e65100;}
.progress{background:#bbdefb;color:#0d47a1;}
.resolved{background:#c8e6c9;color:#1b5e20;}
.escalated{background:#ffcdd2;color:#b71c1c;}

.btn{
padding:8px 12px;
border:none;
border-radius:8px;
cursor:pointer;
font-weight:bold;
margin-right:5px;
}

.progress-btn{background:#2196f3;color:white;}
.resolve-btn{background:#4caf50;color:white;}
.escalate-btn{background:#f44336;color:white;}
.cancel-btn{background:#9e9e9e;color:white;}

input[type="text"]{
padding:8px;
width:60%;
border-radius:8px;
border:1px solid #ccc;
}
</style>
</head>

<body>

<!-- HEADER -->
<h2 onclick="toggleStats()">Grievance Review Panel ⬇️</h2>

<!-- STATS -->
<div id="statsBox" style="display:none;">
<div class="cards">
<div class="card"><h3>Total</h3><p><?php echo $total; ?></p></div>
<div class="card"><h3>Pending</h3><p><?php echo $pending; ?></p></div>
<div class="card"><h3>Resolved</h3><p><?php echo $resolved; ?></p></div>
<div class="card"><h3>Escalated</h3><p><?php echo $escalated; ?></p></div>
</div>
</div>

<!-- COMPLAINT LIST -->
<?php while($row = mysqli_fetch_assoc($query)){ ?>

<div class="box">

<div>
<b>GRV-<?php echo $row['complaint_id']; ?></b>

<!-- STATUS -->
<span class="tag 
<?php 
if($row['status']=="Pending") echo 'pending';
elseif($row['status']=="In Progress") echo 'progress';
elseif($row['status']=="Resolved") echo 'resolved';
else echo 'escalated';
?>">
<?php echo $row['status']; ?>
</span>

<!-- CATEGORY -->
<span class="tag"><?php echo $row['category_name']; ?></span>

<!-- TYPE -->
<span class="tag">
<?php 
if(!empty($row['sname'])) echo "Student";
elseif(!empty($row['stname'])) echo "Staff";
?>
</span>

</div>

<!-- NAME -->
<h3>
Complaint by 
<?php 
if(!empty($row['sname'])){
    echo $row['sname'];
}
elseif(!empty($row['stname'])){
    echo $row['stname'];
}
else{
    echo "Unknown";
}
?>
</h3>

<p><?php echo $row['description']; ?></p>

<small>
Dept: <?php echo $row['dept_name']; ?> • 
<?php echo $row['date_submitted']; ?>
</small>

<br><br>

<?php if(!empty($row['remark'])){ ?>
<p><b>Remark:</b> <?php echo $row['remark']; ?></p>
<?php } ?>

<!-- TAKE ACTION -->
<button onclick="showActions(<?php echo $row['complaint_id']; ?>)" class="btn progress-btn">
Take Action
</button>

<!-- ACTION BOX -->
<div id="actionBox-<?php echo $row['complaint_id']; ?>" style="display:none; margin-top:10px;">

<form method="POST">
<input type="hidden" name="id" value="<?php echo $row['complaint_id']; ?>">

<input type="text" name="remark" placeholder="Add remarks (optional)">

<br><br>

<button name="action" value="progress" class="btn progress-btn">Mark In Progress</button>
<button name="action" value="resolve" class="btn resolve-btn">Resolve</button>
<button name="action" value="escalate" class="btn escalate-btn">Escalate</button>
<button type="button" onclick="hideActions(<?php echo $row['complaint_id']; ?>)" class="btn cancel-btn">Cancel</button>

</form>

</div>

</div>

<?php } ?>

<script>
// TOGGLE STATS
function toggleStats(){
    var box = document.getElementById("statsBox");
    box.style.display = (box.style.display === "none") ? "block" : "none";
}

// SHOW ACTIONS
function showActions(id){
    document.getElementById("actionBox-" + id).style.display = "block";
}

// HIDE ACTIONS
function hideActions(id){
    document.getElementById("actionBox-" + id).style.display = "none";
}
</script>

</body>
</html>