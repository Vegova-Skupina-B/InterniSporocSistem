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
Pozdravljeni
<?php if(isset($_SESSION['username'])){echo ' '.htmlentities($_SESSION['username'], ENT_QUOTES, 'UTF-8');} ?>,<br />
<br />

<?php

if(isset($_SESSION['username']))
{

$nova_sp = mysqli_fetch_array(mysqli_query($mysqli,'select count(*) as nova_sp from sporocilo where ((UpID="'.$_SESSION['userid'].'" and Up1Prebral="no") or (Naslovnik="'.$_SESSION['userid'].'" and Up2Prebral="no"))'));

$nova_sp = $nova_sp['nova_sp'];

?>

<a href="prikazi_sp.php">Moja sporocila(<?php echo $nova_sp; ?> neprebranih)</a><br />
<a href="poslana_sp.php">Poslana spo</a>
<a href="nova_sk.php">Nova skupina in zaznamek</a>
<a href="log_in.php">Logout</a>

<?php
$rez=mysqli_fetch_row(mysqli_query($mysqli,'select * from Uporabnik where UpID='.$_SESSION['userid'].' AND Pravice=1'));

if($rez)
{
	echo '<a href="vsi_up.php">Vsi uporabniki:meni za admina</a>';
}
}
else
{

?>
<a href="nov_up.php">Vclani se</a><br />
<a href="log_in.php">Vpis</a>
<?php
}
?>
<br>
<a href="index.php">Domov</a>
<a href="log_in.php">Log out</a>
		</div>
		
	</body>
</html>