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

$ime_skupine = $_POST["ime_skupine"];
$q = "SELECT SkID FROM skupina WHERE ImeSk = '".$ime_skupine."'";
$result = $mysqli -> query($q);
$id = $result->fetch_array(MYSQLI_ASSOC);
    $id_skupine = $id["SkID"];
    
  $q = "SELECT UpID FROM JeClan WHERE SkID =".$id_skupine;
    
    $result = $mysqli->query($q);
     while($uporabniki = $result->fetch_array(MYSQLI_ASSOC))
    {
        $sporocilo[] = $uporabniki;
    }
    foreach($sporocilo as $key => $value)
    {
		if ($result=mysqli_query($mysqli,$sql))
                $st=mysqli_num_rows($result);
			    $st=$st+1;
         $q = 'INSERT INTO sporocilo (SpID, UpID, Naslovnik, Besedilo, CasPoslano, Up1Prebral,Up2Prebral, Zadeva) VALUES ("'.$st.'", '.$_SESSION["userid"].', '. $value["UpID"].', "'.$_POST["sporocilo"].'", CURRENT_TIMESTAMP, "yes"," no","'.$_POST["tema"].'")';
        
        if($mysqli->query($q)){
        echo "sporocilo poslano!";
   
    }
        
    
}}
?>
<div id="new_message">
  
    <form action="poslji_skupini.php"   method="post">
        
        <input id="ime_skupine"placeholder="Ime skupine" type = "text" name = "ime_skupine">
        <br>
        <input id="tema"placeholder="Tema" type = "text" name = "tema">
        <br>
        <textarea class="input" name="sporocilo" rows="7" cols="30" placeholder="Sporocilo"></textarea><br />
        <input id = "login" type = "submit" value = "Poslji!">
        </form>
   
    </div>
</body>
</html>