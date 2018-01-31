<?php
session_start(); 
if ((isset($_SESSION['is_logged'])) && ($_SESSION['is_logged'])){
	header("Location: http://".$_SERVER['HTTP_HOST']."/www.russlls-famous-cookies.com/admin/desktop.php");
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" /> 
	<title>Login | Dashboard Admin</title> 
	<link rel="stylesheet" href="../css/text.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="../css/buttons.css" type="text/css" media="screen" title="no title" />
	<link rel="stylesheet" href="../css/login.css" type="text/css" media="screen" title="no title" />
	<script language="javascript" type="text/javascript" src="../js/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="../js/jquery.validate.min.js"></script>
	<script language="javascript" type="text/javascript" src="../js/validation-jquery.js"></script>
</head> 
<body> 
<div id="login">
<h1></h1>
	<div id="login_panel">
		<form name="login" id="login_form" action="login.php" method="post" accept-charset="utf-8">		
			<div class="login_fields">
			<?php if ((isset($_REQUEST['err'])) && ($_REQUEST['err'] == 1)){ ?>
				<div class="field-error">
					<label for="error">Invalid username or password</label>		
				</div>
			<? } ?>
				<div class="field">
					<label for="user_name">User Name</label>
					<input type="text" name="user_name" value="" id="user_name" />		
				</div>
				<div class="field">
					<label for="password">Password </label>
					<input type="password" name="password" value="" id="password"  />			
				</div>
			</div> <!-- .login_fields -->
			<div class="login_actions">
				<button type="submit" class="btn btn-orange" tabindex="3">Login</button>
			</div>
		</form>
	</div> <!-- #login_panel -->		
</div> <!-- #login -->
</body> 
</html>