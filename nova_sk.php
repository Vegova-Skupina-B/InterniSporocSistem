
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
if(isset($_POST['SkIme']) and $_POST['SkIme']!='')
{
	
		$_POST['SkIme'] = stripslashes($_POST['SkIme']);
		
		
	
				
				$SkIme = mysqli_real_escape_string($mysqli,$_POST['SkIme']);
				
				
				$sql="SELECT SkID FROM skupina";
                if ($result=mysqli_query($mysqli,$sql))
                $st=mysqli_num_rows($result);
			
				if($st>=0)
				{
					$id = $st+1;
					
					mysqli_query($mysqli,'insert into skupina(SkID,ImeSk,Vodja) values ('.$id.', "'.$SkIme.'", "'.$_SESSION['username'].'")');
                    mysqli_query($mysqli,'insert into jeClan(SkID,UpID) values ('.$id.', "'.$_SESSION['userid'].'")');					
				}
			
		
	
}

if(isset($_POST['SkIme2'],$_POST['ImeUp']) and $_POST['SkIme']!='')
{
	
		$_POST['SkIme2'] = stripslashes($_POST['SkIme']);
		$_POST['ImeUp'] = stripslashes($_POST['Imeup']);
		
	
				
				$SkIme2 = mysqli_real_escape_string($mysqli,$_POST['SkIme2']);
				$UpIme = mysqli_real_escape_string($mysqli,$_POST['ImeUp']);
				
				
				
			
				$req1=mysqli_query($mysqli,'select UpID from uporabnik where UpIme='.$UpIme.'');
				$req2=mysqli_query($mysqli,'select SkID from uporabnik where ImeSk='.$Skime2.'');
					
				
                    mysqli_query($mysqli,'insert into jeClan(SkID,UpID) values ('.$req2[SkID].', "'.$req1[UpID].'")');					
				
			
		
	
}
if(isset($_POST['ImeZA']) and $_POST['ImeZa']!='')
{
	
		$_POST['ImeZa'] = stripslashes($_POST['SkIme']);
		
		
	
				
				$Imeza = mysqli_real_escape_string($mysqli,$_POST['ImeZa']);
				
				
				
				
			$sql="SELECT ZaID FROM zaznamek";
                if ($result=mysqli_query($mysqli,$sql))
                $st=mysqli_num_rows($result);
			
					
				if($st>=0)
				{
					$id2 = $st+1;
					
                    mysqli_query($mysqli,'insert into Zaznamek(ZaID,UpID,ImeZa) values ('.$id2.', "'.$_SESSION['userid'].'","'.$_POST['ImeZA'].'")');					
				
				}
		
	
}
}

mysqli_close($mysqli);
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="stran.css">
</head>
<body>
<div>
    <form action="nova_sk.php" method="post">
        Izpolni:<br />
        <div>
            <label for="UpIme">Ime Skupine</label><input type="text" name="SkIme"> /><br />
            
           
            <input type="submit" value="Nov up" />
		</div>
    </form>
	<br>
	<form action="nova_sk.php" method="post">
        Izpolni za dodajanje:<br />
        <div>
            <label for="UpIme">Ime uporabnika</label><input type="text" name="ImeUp"> /><br />
			<label for="UpIme">Ime skupine</label><input type="text" name="SkIme2"> /><br />
            
           
            <input type="submit" value="Nov up" />
		</div>
    </form>
	<br>
	<form action="nova_sk.php" method="post">
        Izpolni za dodajanje zaznamka:<br />
        <div>
            <label for="UpIme">Ime zaznamka</label><input type="text" name="ImeZa"> /><br />
			
            
           
            <input type="submit" value="Nov up" />
		</div>
    </form>
</div><br>
<a href="index.php">Domov</a>
</body>
</html>