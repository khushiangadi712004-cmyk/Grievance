<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<title>Staff Login</title>

<!-- Font Awesome for Eye Icon -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="../css/style.css">
<script src="../js/loginpage.js"></script>

</head>

<body>

<div class="login-container">

<a href="loginb.php">← Change role</a>

<br><br>

<button class="role-btn"> 👥Staff Login</button>

<h1>Sign In</h1>

<p class="subtitle">Enter your credentials to access the portal</p>
<form action="staff_login_process.php" method="post" onsubmit="return validateCaptcha()">


<label> Email</label>
<input type="text" placeholder="staff@college.edu">

    
<div class="password-box">
<label>Password</label>
<input type="password" name="password" id="password"required>  
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
<a href="forgot_password.php">Forgot password?</a>
</div>

<button class="login-btn" type="submit">Sign In as Staff</button>

<div class="register">
New Staff? <a href="register.php">Register here</a>
</div>

</form>
</div>
</body>
</html>