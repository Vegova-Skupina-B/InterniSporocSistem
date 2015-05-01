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

$req1 = mysqli_query($mysqli,'select m1.SpID, m1.Zadeva, m1.CasPoslano, count(m2.SpID) as reps, u.UpID as userid, u.UpIme from sporocilo as m1, sporocilo as m2,uporabnik u where ((m1.UpID="'.$_SESSION['userid'].'" and m1.Up1Prebral="no" and u.UpID=m1.Naslovnik) or (m1.Naslovnik="'.$_SESSION['userid'].'" and m1.Up2Prebral="no" and u.UpID=m1.UpID))  and m2.SpID=m1.SpID AND m1.Prikazi="yes" AND m2.Prikazi="yes" group by m1.SpID order by m1.SpID desc');
$req2 = mysqli_query($mysqli,'select m1.SpID, m1.Zadeva, m1.CasPoslano, count(m2.SpID) as reps, u.UpID as userid, u.UpIme from sporocilo as m1, sporocilo as m2,uporabnik u where ((m1.UpID="'.$_SESSION['userid'].'" and m1.Up1Prebral="yes" and u.UpID=m1.Naslovnik) or (m1.Naslovnik="'.$_SESSION['userid'].'" and m1.Up2Prebral="yes" and u.UpID=m1.UpID))  and m2.SpID=m1.SpID AND m1.Prikazi="yes" AND m2.Prikazi="yes" group by m1.SpID order by m1.SpID desc');
?>
Sporocila:<br />
<a href="novo_sp.php" >New PM</a><br />
<h3>Nepreberana sporocila(<?php echo mysqli_num_rows($req1); ?>):</h3>
<table>
	<tr>
    	<th class="title_cell">Title</th>
        <th>St. odgovorov</th>
        <th>Naslovnik</th>
        <th>Datum</th>
    </tr>
<?php
//We display the list of unread messages
while($dn1 = mysqli_fetch_array($req1))
{
?>
	<tr>
    	<td class="left"><a href="beri_sp.php?id=<?php echo $dn1['SpID']; ?>"><?php echo htmlentities($dn1['Zadeva'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn1['reps']-1; ?></td>
    	<td><?php echo $dn1['userid'];  echo htmlentities($dn1['UpIme'], ENT_QUOTES, 'UTF-8'); ?></td>
    	<td><?php echo date('Y/m/d H:i:s' ,$dn1['CasPoslano']); ?></td>
    </tr>
<?php
}

if(mysqli_num_rows($req1)==0)
{
?>
	<tr>
    	<td colspan="4" class="center">Nimas neprebranih sporocil.</td>
    </tr>
<?php
}
?>
</table>
<br />
<h3>Prebrana sporocila(<?php echo mysqli_num_rows($req2); ?>):</h3>
<table>
	<tr>
    	<th class="title_cell">Naslov</th>
        <th>St. odgovorov</th>
        <th>Naslovnik</th>
        <th>Datum</th>
    </tr>
<?php

while($dn2 = mysqli_fetch_array($req2))
{
?>
	<tr>
    	<td class="left"><a href="beri_sp.php?id=<?php echo $dn2['SpID']; ?>"><?php echo htmlentities($dn2['Zadeva'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn2['reps']-1; ?></td>
    	<td><?php echo $dn2['userid'];  echo htmlentities($dn2['UpIme'], ENT_QUOTES, 'UTF-8'); ?></td>
    	<td><?php echo date('Y/m/d H:i:s' ,$dn2['CasPoslano']); ?></td>
    </tr>
<?php
}
//If there is no read message we notice it
if(mysqli_num_rows($req2)==0)
{
?>
	<tr>
    	<td colspan="4" class="center">You have no messages.</td>
    </tr>
<?php
}
?>
</table>
<?php
}
else
{
	echo 'You must be logged to access this page.';
}


?>
		</div>
<br>
<a href="index.php">Domov</a>
<a href="log_in.php">Log out</a>			
	</body>
</html>