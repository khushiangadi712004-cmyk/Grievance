<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Admin Login</title>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
<script src="../js/loginpage.js"></script>

</head>

<body>

<div class="login-container">

<a href="../view/loginb.php">← Change role</a>

<br><br>

<button class="role-btn">🛡 Admin Login</button>

<h1>Sign In</h1>

<p class="subtitle">Enter your credentials to access the portal</p>

<!-- ✅ FIXED FORM -->
<form action="../admin/admin_login_process.php" method="post" onsubmit="return validateCaptcha()">

<label>Admin Email</label>
<input type="email" name="email" placeholder="Enter Admin Email" required>

<div class="password-box">
<label>Password</label>
<input type="password" name="mypswd" id="password"
required>
<i class="fa-solid fa-eye" id="eye" onclick="togglePassword()"></i>
</div>

<label>Captcha</label>

<div class="captcha-box">
<span id="captcha"></span>
<button type="button" class="refresh" onclick="generateCaptcha()">
<i class="fa fa-refresh"></i>
</button>
</div>

<input type="text" id="captchaInput" placeholder="Enter captcha" required>

<div class="options">
<a href="../view/forgot_password.php">Forgot password?</a>
</div>

<button class="login-btn" type="submit">Sign In as Admin</button>

<div class="register">
New admin? <a href="register.php">Register here</a>
</div>

</form>

</div>
</body>
</html>