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

//We check if the user is logged
if(isset($_SESSION['username']))
{
//We list his messages in a table
//Two queries are executes, one for the unread messages and another for read messages
$req1 = mysqli_query($mysqli,'select m1.SpID, m1.Zadeva, m1.CasPoslano, count(m2.SpID) as reps, u.UpID as userid, u.UpIme from sporocilo as m1, sporocilo as m2,uporabnik u where u.UpID="'.$_SESSION['userid'].'" and m2.SpID=m1.SpID group by m1.SpID order by m1.SpID desc');
}?>
Poslana sporocila:<br />

<table>
	<tr>
    	<th class="title_cell">Zadeva</th>
        <th>St. odgovorov</th>
        <th>Naslovnik</th>
        <th>Datum nastanka</th>
    </tr>
<?php
//We display the list of unread messages
while($dn1 = mysql_fetch_array($req1))
{
?>
	<tr>
    	<td class="left"><a href="beri_sp.php?id=<?php echo $dn1['id']; ?>"><?php echo htmlentities($dn1['Zadeva'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn1['reps']-1; ?></td>
    	<td><<?php echo $dn1['userid']; echo htmlentities($dn1['username'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td><?php echo $dn1['CasPoslano']; ?></td>
    </tr>
<?php
}
//If there is no unread message we notice it
if(intval(mysql_num_rows($req1))==0)
{
?>
	<tr>
    	<td colspan="4" class="center">Nimas poslanih sporocil.</td>
    </tr>

</table>
<?php
}
else
{
	echo 'You must be logged to access this page.';
}
?>
		</div>
		<a href="index.php">Domov</a>
<a href="log_in.php">Log out</a>
	</body>
</html>