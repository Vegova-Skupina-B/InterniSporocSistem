<html>
<head>
<link rel="stylesheet" type="text/css" href="stran.css">
</head>
<body>
<?php
$mysqli = new mysqli("localhost", "root", "", "baza");
if (mysqli_connect_errno()) 
{
    echo "Link z bazo ni uspesen:";
	echo mysqli_connect_error();
    exit();
}
if(isset($_SESSION['username']))
{
	if(isset($_POST['spo'],$_POST['zadeva'],$_POST['ime_skupine']) and $_POST['spo']!='')
{
$ime_skupine = $_POST["ime_skupine"];
$q = "SELECT SkID FROM skupina WHERE ImeSk = '".$ime_skupine."'";
$result = mysqli_query($mysqli,'SELECT SkID FROM skupina WHERE ImeSk = "'.$ime_skupine.'"');
$id = mysqli_fetch_array($result);
    $id_skupine = $id["SkID"];
    
  $q = "SELECT UpID FROM JeClan WHERE SkID =".$id_skupine;
    
    $result = mysqli_query($mysqli,'SELECT UpID FROM JeClan WHERE SkID ="'.$id_skupine.'"');
     while($uporabniki = mysqli_fetch_array($result))
    {
        $sporocilo[] = $uporabniki;
    }
    foreach($sporocilo as $key => $value)
    {
		if ($result=mysqli_query($mysqli,$sql))
                $st=mysqli_num_rows($result);
			    $st=$st+1;
				$datum = date_create()->format('Y-m-d H:i:s');	
         mysqli_query($mysqli,'insert into sporocilo (SpID, UpID,ZaID, Naslovnik, Besedilo, CasPoslano, Up1Prebral,Up2Prebral, Zadeva) VALUES ("'.$st.'", '.$_SESSION["userid"].',"1", '. $value["UpID"].', "'.$_POST["sporocilo"].'", "'.$datum.'", "yes"," no","'.$_POST["zadeva"].'")');
        
     
   
    }
        
    
}}
?>
<div id="new_message">
  
    <form action="poslji_sk.php"   method="post">
        
        <input id="ime_skupine" type = "text" name = "ime_skupine">
        <br>
        <input id="tema" type = "text" name = "zadeva">
        <br>
        <textarea class="input" name="spo" rows="5" cols="40" ></textarea><br />
        <input id = "login" type = "submit" >
        </form>
   
    </div>
</body>
</html>