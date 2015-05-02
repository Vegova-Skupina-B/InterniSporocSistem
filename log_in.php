<html>
<head>
<link rel="stylesheet" type="text/css" href="stran.css">
</head>
<body>
<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "baza");
if (mysqli_connect_errno()) 
{
    echo "Link z bazo ni uspesen:";
	echo mysqli_connect_error();
    exit();
}

?>

<?php

if(isset($_SESSION['username']))
{
	
	unset($_SESSION['username'], $_SESSION['userid']);
	session_unset(); 
?>
<div class="message">You have successfuly been loged out.<br />
<a href="index.php">Home</a></div>
<?php
}
else
{
	$ousername = '';
	
	if(isset($_POST['username'], $_POST['password']))
	{
		
		if(get_magic_quotes_gpc())
		{
			$ousername = stripslashes($_POST['username']);
			$username = mysqli_real_escape_string($mysqli,stripslashes($_POST['username']));
			$password = stripslashes($_POST['password']);
		}
		else
		{
			$username = mysqli_real_escape_string($mysqli,$_POST['username']);
			$password = $_POST['password'];
		}
		
		$req = mysqli_query($mysqli,'select geslo,UpID from uporabnik where UpIme="'.$username.'"');
		$dn = mysqli_fetch_array($req);
		
		if($dn['geslo']==$password and mysqli_num_rows($req)>0)
		{
			
			$form = false;
			
			$_SESSION['username'] = $_POST['username'];
			$_SESSION['userid'] = $dn['UpID'];
			$datum = date_create()->format('Y-m-d H:i:s');	
			mysqli_query($mysqli,'insert into uporabnik(ZadnjiLog) VALUES ('.$datum.') WHERE UpID='.$_SESSION['userid'].'');
?>
<div class="message">You have successfuly been logged. You can access to your member area.<br />
<a href="index.php">Home</a></div>
<?php
		}
		else
		{
			
			$form = true;
			$message = 'Napacno geslo.';
		}
	}
	else
	{
		$form = true;
	}
	if($form)
	{
		
	if(isset($message))
	{
		echo '<div class="message">'.$message.'</div>';
	}
	
?>
<div class="content">
    <form action="log_in.php" method="post">
        Please type your IDs to log in:<br />
        <div class="center">
            <label for="username">Username</label><input type="text" name="username" id="username" value="<?php echo htmlentities($ousername, ENT_QUOTES, 'UTF-8'); ?>" /><br />
            <label for="password">Password</label><input type="password" name="password" id="password" /><br />
            <input type="submit" value="Log in" />
		</div>
    </form>
</div>
<?php
	}
}
?>
<br>
<a href="index.php">Domov</a>

		
	</body>
</html>