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
{?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stran.css">
</head>
<body>
Vsi uporabniki:
<table>
    <tr>
    	<th>Id</th>
    	<th>Up Ime</th>
    	<th>Email</th>
    </tr>
<?php

$req = mysqli_query($mysqli,'select UpID, UpIme, email from uporabnik');
while($dnn = mysqli_fetch_array($req))
{
?>
	<tr>
    	<td class="left"><?php echo $dnn['UpID']; ?></td>
    	<td class="left"><?php echo htmlentities($dnn['UpIme'], ENT_QUOTES, 'UTF-8'); ?></a></td>
    	<td class="left"><?php echo htmlentities($dnn['email'], ENT_QUOTES, 'UTF-8'); ?></td>
    </tr>
<?php
}}
?>
</table>
		</div>
		<a href="index.php">Domov</a>
	</body>
</html>