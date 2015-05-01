<?php
session_start();
$mysqli = new mysqli("localhost", "root", "", "baza");
if (mysqli_connect_errno()) 
{
    echo "Link z bazo ni uspesen:";
	echo mysqli_connect_error();
    exit();
}


if(isset($_SESSION['username']))
{

if(isset($_GET['id']))
{
$id = intval($_GET['id']);

$req1 = mysqli_query($mysqli,'select Zadeva, UpID, Naslovnik,ZapSt from sporocilo where SpID="'.$id.'" ');
$dn1 = mysqli_fetch_array($req1);

if(mysqli_num_rows($req1)==1)
{

if($dn1['UpID']==$_SESSION['userid'] or $dn1['Naslovnik']==$_SESSION['userid'])
{
	$i=$dn1['ZapSt']+1;
	$sql="SELECT SpID FROM sporocilo";
                if ($result=mysqli_query($mysqli,$sql))
                $st=mysqli_num_rows($result);
			    $st=$st+1;
				$datum = date_create()->format('Y-m-d H:i:s');
                $otitle = $_POST['Zadeva'];$otitle = stripslashes($otitle);$title = mysqli_real_escape_string($mysqli,$otitle);				
	

if($dn1['UpID']==$_SESSION['userid'])
{
	mysqli_query($mysqli,'update sporocilo set Up1Prebral="yes" where SpID="'.$id.'"');
	$user_partic = 2;
}
else
{
	mysqli_query($mysqli,'update sporocilo set Up2Prebral="yes" where SpID="'.$id.'"');
	$user_partic = 1;
}

$req2 = mysqli_query($mysqli,'select s.CasPoslano, s.Besedilo, u.UpID as userid, u.UpIme from sporocilo s, uporabnik u where s.SpID="'.$id.'" and u.UpID=s.UpID ');

if(isset($_POST['spo']) and $_POST['spo']!='')
{
	$message = $_POST['spo'];
	
	
	if(get_magic_quotes_gpc())
	{
		$message = stripslashes($message);
	}
	
	$message = mysqli_real_escape_string($mysqli,nl2br(htmlentities($message, ENT_QUOTES, 'UTF-8')));
	$i=$dn1['ZapSt']+1;
	$sql="SELECT SpID FROM sporocilo";
                if ($result=mysqli_query($mysqli,$sql))
                $st=mysqli_num_rows($result);
			    $st=$st+1;
				$datum = date_create()->format('Y-m-d H:i:s');
                $otitle = $_POST['Zadeva'];$otitle = stripslashes($otitle);$title = mysqli_real_escape_string($mysqli,$otitle);	
	
	if(mysqli_query($mysqli,'insert into sporocilo(SpID,UpID,ZaID,ZapSt,Naslovnik,Zadeva,Besedilo,CasPoslano,Up1Prebral,Up2Prebral) values("'.$st.'","'.$_SESSION['userid'].'" ,"1","'.$i.'", "'.$dn1['UpID'].'","'.$title.'", "'.$message.'", "'.$datum.'", "yes", "no")') )
	{
?>
<div class="message">Sporocilo uspesno poslano.<br />
<a href="beri_sp.php?id=<?php echo $id; ?>">Pojdi na besedilo</a></div>
<?php
	}
	else
	{
?>
<div class="message">Napaka pri posiljanju sporocila.<br />
<a href="beri_sp.php?id=<?php echo $id; ?>">Pojdi na besedilo</a></div>
<?php
	}
}
else
{
//We display the messages
?>
<div class="content">
<h1><?php echo $dn1['Zadeva']; ?></h1>
<table class="messages_table">
	<tr>
    	<th class="author">Uporabnik</th>
        <th>Besedilo</th>
    </tr>
<?php
while($dn2 = mysqli_fetch_array($req2))
{
?>
	<tr>
    	<td class="author center"><?php

?><br /><?php echo $dn2['userid']; ?>"><?php echo $dn2['UpIme']; ?></td>
    	<td class="left"><div class="date">Poslano: <?php echo $dn2['CasPoslano']; ?></div>
    	<?php echo $dn2['Besedilo']; ?></td>
    </tr>
<?php
}
//We display the reply form
?>
</table><br />
<h2>Odgovori</h2>
<div class="center">
    <form action="beri_sp.php?id=<?php echo $id; ?>" method="post">
	  <label for="title">Zadeva</label><input type="text" value="(<?php echo $i;?>)" id="Zadeva" name="Zadeva" /><br />
    	<label for="message" class="center">Sporocilo</label><br />
        <textarea cols="40" rows="5" name="message" id="message"></textarea><br />
        <input type="submit" value="Send" />
    </form>
</div>
</div>
<?php
}
}
else
{
	echo '<div class="message">You dont have the rights to access this page.</div>';
}
}
else
{
	echo '<div class="message">This discussion does not exists.</div>';
}
}
else
{
	echo '<div class="message">The discussion ID is not defined.</div>';
}
}
else
{
	echo '<div class="message">You must be logged to access this page.</div>';
}
?>
		<div class="foot"><a href="prikazi_sp.php">Go to my personnal messages</a>
		<br>
<a href="index.php">Domov</a><br>
<a href="log_in.php">Log out</a>
	</body>
</html>