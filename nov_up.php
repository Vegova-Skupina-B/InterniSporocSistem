
<?php

$mysqli = new mysqli("localhost", "root", "", "baza");
if (mysqli_connect_errno()) 
{
    echo "Link z bazo ni uspesen:";
	echo mysqli_connect_error();
    exit();
}
//pregelde, da smo v formo vpisali vse potrebne podatke
if(isset($_POST['UpIme'], $_POST['Geslo'], $_POST['Geslopreveri'], $_POST['email']) and $_POST['UpIme']!='')
{
	
		$_POST['UpIme'] = stripslashes($_POST['UpIme']);
		$_POST['Geslo'] = stripslashes($_POST['Geslo']);
		$_POST['Geslopreveri'] = stripslashes($_POST['Geslopreveri']);
		$_POST['email'] = stripslashes($_POST['email']);
		
	
	//pregled, da se gesli ujemata
	if($_POST['Geslo']==$_POST['Geslopreveri'])
	{
		//pregled, da ima geslo vsaj 7 znakov
		if(strlen($_POST['Geslo'])>=7)
		{
			//pregled emaila
			if(filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)!=FALSE)
			{
				
				$UpIme = mysqli_real_escape_string($mysqli,$_POST['UpIme']);
				$Geslo = mysqli_real_escape_string($mysqli,$_POST['Geslo']);
				$email = mysqli_real_escape_string($mysqli,$_POST['email']);
				
				$sql="SELECT UpID FROM uporabnik";
                if ($result=mysqli_query($mysqli,$sql))
                $st=mysqli_num_rows($result);
			
				if($st>=0)
				{
					$id = $st+1;
					$datum = date_create()->format('Y-m-d H:i:s');	
					mysqli_query($mysqli,'insert into uporabnik(upid, UpIme, Geslo, email,DatumReg,Pravice) values ('.$id.', "'.$UpIme.'", "'.$Geslo.'", "'.$email.'","'.$datum.'",0)');						
				}
			}
		}
	}
}
mysqli_close($mysqli);
?>
<html>
<div>
    <form action="nov_up.php" method="post">
        Izpolni:<br />
        <div>
            <label for="UpIme">UpIme</label><input type="text" name="UpIme"> /><br />
            <label for="Geslo">Geslo<span class="small">(najmanj 7 znakov))</span></label><input type="password" name="Geslo" /><br />
            <label for="Geslopreveri">Geslo<span class="small">(vpisi geslo se enkrat)</span></label><input type="password" name="Geslopreveri" /><br />
            <label for="email">Email</label><input type="text" name="email"  ><br />
            
            <input type="submit" value="Nov up" />
		</div>
    </form>
</div><br>
<a href="index.php">Domov</a>
</html>