<html>
<head>
	<title>Login</title>
 	<link rel="stylesheet" type="text/css" href="style/login.css?v=<?php echo time(); ?>">
    <?php 
        include 'login-RegisterValidation.php'; 
    ?>

</head>

<body>
        <div class="wallpaperlogin">
            <div class="header">
            <h2>Login</h2>
            </div>
                
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <?php include 'errors.php'; ?>
            <div class="input-group">
                <label>Username:</label>
                <input type="text" name="username" >
            </div>
            <div class="input-group">
                <label>Password:</label>
                <input type="password" name="password">
            </div>
            <div class="input-group">
                <button type="submit" class="btn" name="login_user">Login</button>
            </div>
            <p>
                Not yet a member? <a href="register.php">Sign up</a>
            </p>
            <p>
                <a href="maindashboard.php">Continue as guest </a>
            </p>
            </form>
        </div>
</body>
</html>