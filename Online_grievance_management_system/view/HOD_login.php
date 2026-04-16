<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>HOD Login</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
<script src="../js/loginpage.js"></script>
</head>

<body>

<div class="login-container">

<a href="loginb.php">← Change role</a>

<br><br>

<button class="role-btn">📘 HOD Login</button>

<h1>Sign In</h1>

<p class="subtitle">Enter your credentials to access the portal</p>
<form action="../HOD/login_process_hod.php" method="post" onsubmit="return validateCaptcha()">

<label>HOD Email</label>
<input type="text" name="email" placeholder="e.g. hod@college.edu" required>

<div class="password-box">
<label>Password</label>
<input type="password" name="mypswd" id="password" required>
<i class="fa-solid fa-eye" id="eye" onclick="togglePassword()"></i>
</div>

<label>Captcha</label>

<div class="captcha-box">
<span id="captcha"></span>
<button type="button" onclick="generateCaptcha()">
<i class="fa fa-refresh"></i>
</button>
</div>

<input type="text" id="captchaInput" placeholder="Enter captcha" required>

<button class="login-btn" type="submit">Sign In as HOD</button>

</form>
</div>
</body>
</html>