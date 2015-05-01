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
$form = true;
$otitle = '';
$orecip = '';
$omessage = '';

if(isset($_POST['Zadeva'], $_POST['Naslovnik'], $_POST['spo']))
{
	$otitle = $_POST['Zadeva'];
	$orecip = $_POST['Naslovnik'];
	$omessage = $_POST['spo'];
	
	if(get_magic_quotes_gpc())
	{
		$otitle = stripslashes($otitle);
		$orecip = stripslashes($orecip);
		$omessage = stripslashes($omessage);
	}
	
	if($_POST['Zadeva']!='' and $_POST['Naslovnik']!='' and $_POST['spo']!='')
	{
		
		$title = mysqli_real_escape_string($mysqli,$otitle);
		$recip = mysqli_real_escape_string($mysqli,$orecip);
		$message = mysqli_real_escape_string($mysqli,nl2br(htmlentities($omessage, ENT_QUOTES, 'UTF-8')));
		
		$dn1 = mysqli_fetch_array(mysqli_query($mysqli,'select count(UpID) as recip, UpID as recipid, (select count(*) from sporocilo) as npm from uporabnik where UpIme="'.$recip.'"'));
		if($dn1['recip']==1)
		{
			
			if($dn1['recipid']!=$_SESSION['userid'])
			{
				$datum = date_create()->format('Y-m-d H:i:s');	
				$id = $dn1['npm']+1;
				
				if(mysqli_query($mysqli,'insert into sporocilo (SpID,UpID,ZaID,ZapSt,Zadeva,Naslovnik,Besedilo,Up1Prebral,Up2Prebral,CasPoslano,Prikazi)values("'.$id.'","'.$_SESSION['userid'].'","1" ,"1", "'.$title.'", "'.$dn1['recipid'].'", "'.$message.'", "yes", "no","'.$datum.'","yes")'))
				{
?>
<div class="message">Sporocilo je bilo uspesno poslano.<br />
<a href="prikazi_sp.php">Vsa sporocila</a></div>
<?php
					$form = false;
				}
				else
				{
					
					$error = 'Napaka pri posiljanju';
				}
			}
			else
			{
				
				$error = 'Sam sebi si ne mores posiljati sporocil.';
			}
		}
		else
		{
			
			$error = 'Naslovnik ne obstaja.';
		}
	}
	else
	{
		
		$error = 'Eno al vec polj je praznih.';
	}
}
elseif(isset($_GET['recip']))
{
	
	$orecip = $_GET['recip'];
}
if($form)
{

if(isset($error))
{
	echo '<div class="message">'.$error.'</div>';
}

?>
<div class="content">
	<h1>Novo sporocilo</h1>
    <form action="novo_sp.php" method="post">
		Izpolni naslednje.<br />
        <label for="title">Zadeva</label><input type="text" value="<?php echo htmlentities($otitle, ENT_QUOTES, 'UTF-8'); ?>" id="title" name="Zadeva" /><br />
        <label for="recip">Naslovnik<span class="small">Uporabnisko ime</span></label><input type="text" value="<?php echo htmlentities($orecip, ENT_QUOTES, 'UTF-8'); ?>" id="recip" name="Naslovnik" /><br />
        <label for="message">Besedilo</label><textarea cols="40" rows="5" id="message" name="spo"><?php echo htmlentities($omessage, ENT_QUOTES, 'UTF-8'); ?></textarea><br />
        <input type="submit" value="Send" />
    </form>
</div>
<?php
}
}
else
{
	echo '<div class="message">You must be logged to access this page.</div>';
}
?>
		<br>
<a href="index.php">Domov</a><br>
<a href="log_in.php">Log out</a>
	</body>
</html>