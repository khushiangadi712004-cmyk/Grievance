
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>GrievanceDesk</title>

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: 'Poppins', sans-serif;
}

body{
    background:#f7f9fc;
}

/* NAVBAR */
nav{
    display:flex;
    justify-content:space-between;
    padding:15px 50px;
    background:#fff;
    box-shadow:0 2px 10px rgba(0,0,0,0.05);
}

nav h2{
    color:#0a2540;
}

nav a{
    text-decoration:none;
    margin-left:20px;
    color:#333;
    font-weight:500;
}

.btn{
    background:#f4b400;
    padding:8px 15px;
    border-radius:6px;
    color:#fff;
}

/* HERO SECTION */
.hero{
    background:linear-gradient(135deg,#0a2540,#1e4db7);
    color:#fff;
    text-align:center;
    padding:100px 20px;
}

.hero h1{
    font-size:45px;
}

.hero span{
    color:#f4b400;
}

.hero p{
    margin-top:15px;
    font-size:18px;
    max-width:700px;
    margin-left:auto;
    margin-right:auto;
}

.hero-buttons{
    margin-top:30px;
}

.hero-buttons a{
    text-decoration:none;
    padding:12px 25px;
    margin:10px;
    border-radius:8px;
    font-weight:500;
}

.primary{
    background:#f4b400;
    color:#fff;
}

.secondary{
    border:1px solid #fff;
    color:#fff;
}

/* SECTION TITLE */
.section-title{
    text-align:center;
    margin:60px 0 30px;
}

.section-title h2{
    font-size:28px;
    color:#0a2540;
}

/* HOW IT WORKS */
.steps{
    display:flex;
    justify-content:center;
    gap:20px;
    padding:20px;
    flex-wrap:wrap;
}

.step{
    background:#fff;
    padding:20px;
    width:250px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
    text-align:center;
}

.step-number{
    background:#f4b400;
    color:#fff;
    width:30px;
    height:30px;
    border-radius:50%;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    margin-bottom:10px;
}

/* FEATURES */
.features{
    display:flex;
    justify-content:center;
    gap:20px;
    flex-wrap:wrap;
    padding:20px;
}

.feature{
    background:#fff;
    padding:25px;
    width:280px;
    border-radius:10px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.05);
}

.feature h3{
    margin:10px 0;
}

/* FOOTER */
footer{
    text-align:center;
    padding:20px;
    background:#0a2540;
    color:#fff;
    margin-top:50px;
}

</style>
</head>

<body>

<!-- NAVBAR -->
<nav>
    <h2>GrievanceDesk</h2>
    <div>
        
        <a href="../view/loginb.php" class="btn">Roles</a>
        
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <h1>Your Voice <span>Matters.</span><br>We Make It <span>Count.</span></h1>
    <p>
        A streamlined platform for submitting, tracking, and resolving grievances
        across every level of your institution — from students to management.
    </p>

    <div class="hero-buttons">
        <a href="../view/loginb.php" class="primary">Get Started </a>
        
    </div>
</section>

<!-- HOW IT WORKS -->
<div class="section-title">
    <h2>How It Works</h2>
</div>

<div class="steps">

    <div class="step">
        <div class="step-number">1</div>
        <h3>Submit Grievance</h3>
        <p>Students and staff can file complaints with category and priority.</p>
    </div>

    <div class="step">
        <div class="step-number">2</div>
        <h3>Review & Investigate</h3>
        <p>HOD, Principal review and take action.</p>
    </div>

    <div class="step">
        <div class="step-number">3</div>
        <h3>Track Progress</h3>
        <p>Get real-time updates on your complaints.</p>
    </div>

    <div class="step">
        <div class="step-number">4</div>
        <h3>Resolution</h3>
        <p>Issues are resolved or escalated if needed.</p>
    </div>

</div>

<!-- FEATURES -->
<div class="section-title">
    <h2>Why Choose GrievanceDesk?</h2>
</div>

<div class="features">

    <div class="feature">
        <h3>Real-Time Tracking</h3>
        <p>Monitor grievance status with live updates.</p>
    </div>

    <div class="feature">
        <h3>Role-Based Access</h3>
        <p>Secure dashboards for students, staff & admin.</p>
    </div>

    <div class="feature">
        <h3>Escalation System</h3>
        <p>Unresolved issues are automatically escalated.</p>
    </div>

</div>

<!-- FOOTER -->
<footer>
    <p>© 2026 GrievanceDesk | All Rights Reserved</p>
</footer>

</body>
</html>