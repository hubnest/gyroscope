<?
include 'connect.php';
include 'auth.php';

setcookie('userid',NULL,time()-3600);
setcookie('login',NULL,time()-3600);
setcookie('auth',NULL,time()-3600);
setcookie('groupnames',NULL,time()-3600);

$error_message='';

if ($_POST['password']||$_POST['login']){
  $password=md5($dbsalt.$_POST['password']);
  $raw_login=$_POST['login'];
  $login=mysql_real_escape_string($raw_login);
  
  $query="select * from users where login='$login' and password='$password'";
  $rs=sql_query($query,$db);  
  if ($myrow=sql_fetch_array($rs)){
	  
	  $userid=$myrow['userid'];
	  
	  $groupnames=$myrow['groupnames'];
	  $auth=md5($salt.$userid.$groupnames.$salt.$raw_login);
	  
	  setcookie('auth',$auth);
	  setcookie('userid',$userid);
	  setcookie('login',$login);
	  setcookie('groupnames',$groupnames);
	  
	  if (isset($_GET['from'])) header('location: '.$_GET['from']);
	  else header('location:index.php');
	  
	  die();
  } else $error_message='invalid username or password';
}
?>
<html>
<head>
	<title>Login</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name = "viewport" content = "width = 350, init-scale=1, user-scalable = yes" />
<style>
body{padding:0;margin:0;background-color:#E7E7E2;font-size:13px;font-family:arial,sans-serif;text-align:center;}
#loginbox{border:solid 4px #ABADB0;width:300px;margin:0 auto;background-color:#FFFFFF;text-align:left;margin-top:60px;}
</style>
</head>
<body>
<div id="loginbox">
	<form method="POST" style="padding:20px;margin:0;padding-top:10px;">
	<!-- add your logo here <img src="imgs/logo.gif" -->
	<?if ($error_message!=''){?>
	<div style="color:#ab0200;font-weight:bold;padding-top:10px;"><?echo $error_message;?></div>
	<?}?>
	
	<div style="padding-top:10px;">Username:</div>
	<div style="padding-top:5px;padding-bottom:10px;">
	<input style="width:100%" id="login" type="text" name="login"></div>
	<div>Password:</div>
	<div style="padding-top:5px;padding-bottom:15px;">
	<input style="width:100%;" type="password" name="password"></div>
	<div style="text-align:center;"><input style="width:100px;" type="submit" value="Sign In"></div>
	</form>
</div>	

	<div style="text-align:right;font-size:12px;width:300px;margin:0 auto;padding-top:10px;">Powered by Antradar Gyroscope <img src="imgs/gyroscope.gif"></div>
	
	<script src="nano.js"></script>
	<script>
		gid('login').focus();
	</script>
</body>
</html>
