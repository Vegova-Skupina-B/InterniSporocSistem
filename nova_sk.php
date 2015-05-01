<?php

session_start();
$mysqli = new mysqli("localhost", "root", "", "baza");
if (mysqli_connect_errno()) 
{
    echo "Link z bazo ni uspesen:";
	echo mysqli_connect_error();
    exit();
}

if(isset($_POST))
{$q = "SELECT UpId FROM uporabniki WHERE UpIme = '".$_POST["ime_uporabnika"]."'";
    echo $q;
    echo "<hr>";
    $q1 = "SELECT SkID FROM Skupina WHERE ImeSk = '".$_POST["ime_skupine"]."'";
    echo $q1;
    $result = $mysqli->query($q);
    $id = $result->fetch_array(MYSQLI_ASSOC);
    $id_uporabnika = $id['UpID'];
    echo $id_uporabnika;
    $result = $mysqli->query($q1);
    $id = $result->fetch_array(MYSQLI_ASSOC);
    $id_skupine = $id['SkID'];
    echo $id_skupine;
    $q3= "INSERT INTO JeClan values (".$id_uporabnika.", ".$id_skupine.")";
    
    
}   

?>




<body>

    <hr>
       <div id="Nova skupina">
    <form action="nova_skupina.php" method="post">
        
        <input id="ime_skupine" placeholder="Ime Skupine" type = "text" name = "ime_skupine">
        <input id = "box4" type = "submit" value = "Ustvari novo skupino">
        </form>
    
    </div>
    <div id="dodajanje_v_skupino">
    <form action="dodaj_v_skupino.php" method="post">
       
        <input id="ime_skupine"placeholder="Ime Skupine"  type = "text" name = "ime_skupine">
         
        <input id="ime_uporabnika"placeholder="Ime Uporabnika"  type = "text" name = "ime_uporabnika">
        <input id = "nova_skup" type = "submit"  value = "Dodaj novega člana v skupino">
        </form>
    
    </div>
    
  
</body>
</html>