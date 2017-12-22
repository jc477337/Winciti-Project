<?php
include_once 'db_connect.php';
include_once 'functions.php';
 
sec_session_start();
 
if (login_check($mysqli) == true) {
    $logged = 'in';
} else {
    $logged = 'out';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Secure Login: Log In</title>
        <link rel="stylesheet" href="../css/custom.css" />
        <script type="text/JavaScript" src="../js/sha512.js"></script> 
        <script type="text/JavaScript" src="../js/forms.js"></script> 
    </head>
    <body>
        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?> 
		
		
		<div>
		<div class="login-box">
			<div class="login-inner-box">
				<h1>
				<div class="login-title">Log In | <a href="register.php" style="color: #2990EA;">Register</a></div>
				</h1>
			</div>
				
			<form action="process_login.php" method="post" name="login_form">                      
				<input type="text" class="email-input" name="email" placeholder="Email Address" />
				<input type="password" class="email-input" name="password" id="password" placeholder="Password"/>
				<input type="button" class="login-button"
					value="Login" 
					onclick="formhash(this.form, this.form.password);" /> 
			</form>
		</div>
		</div>
			
		<div>
		
			
			
			<!--
 
			<?php
			if (login_check($mysqli) == true) {
				echo '<p>Currently logged ' . $logged . ' as ' . htmlentities($_SESSION['username']) . '.</p>';
				echo '<p>Do you want to change user? <a href="logout.php">Log out</a>.</p>';
			} else {
				echo '<p>Currently logged ' . $logged . '.</p>';
				echo "<p>If you don't have a login, please <a href='register.php'>register</a></p>";
			}
			?>  

			-->			

		</div>
    </body>
</html>