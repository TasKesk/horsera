<?php
if(isset($_POST["hor_submit_logout"])){
	unset($_SESSION["u"]);
	header("Location:");
}

if($_SERVER["REQUEST_METHOD"]==="POST" && isset($_POST["hor_username"]) && isset($_POST["hor_password"])){
	$userdata=file_get_contents("db/u.txt");
	if(isset($_POST["hor_submit_login"])){
		if(strpos($userdata,"%".$_POST["hor_username"]."&".crc32($_POST["hor_password"])."%")!==false && strlen($_POST["hor_username"])>2 && strlen($_POST["hor_username"])<21 && strlen($_POST["hor_password"])>2 && strlen($_POST["hor_password"])<101 && preg_match("/^[a-z0-9]+$/", $_POST["hor_username"])){
			$_SESSION["u"]=$_POST["hor_username"];
			header("Location:");
		}else{
			echo "Invalid credentials.<br/><br/><a href=''>Try again</a>";
		}
	}else if(isset($_POST["hor_submit_register"])){
		if(strpos($userdata,"%".$_POST["hor_username"]."&")===false){
			if(preg_match("/^[a-z0-9]+$/", $_POST["hor_username"])){
				if(strlen($_POST["hor_username"])>2 && strlen($_POST["hor_username"])<21 && strlen($_POST["hor_password"])>2 && strlen($_POST["hor_password"])<101){
					file_put_contents("db/u.txt",$userdata."%".$_POST["hor_username"]."&".crc32($_POST["hor_password"])."%");
					$_SESSION["u"]=$_POST["hor_username"];
					header("Location:");
				}else{
					echo "Username and password should be from 3 to 20 characters long. <br/><br/><a href=''>Try again</a>";
				}
			}else{
				echo "Only lowercase characters (a-z) and numbers are allowed.<br/><br/><a href=''>Try again</a>";
			}
		}else{
			echo "This username is taken.<br/><br/><a href=''>Try again</a>";
		}
	}
}else if(isset($_POST["hor_openpage_changepassword"])){
	echo "<form method='POST'><input type='password' placeholder='Old password' name='hor_old_password'><br/><input type='password' placeholder='New password' name='hor_new_password'><br/><input type='submit' name='hor_submit_changepassword' value='Change password'></form><a href=''>Cancel</a>";
}else if(isset($_POST["hor_submit_changepassword"])&&isset($_SESSION["u"])){
	file_put_contents("db/u.txt",str_replace("%".$_SESSION["u"]."&".crc32($_POST["hor_old_password"])."%","%".$_SESSION["u"]."&".crc32($_POST["hor_new_password"])."%",file_get_contents("db/u.txt")));
	header("Location:");
}else{
	if(isset($_SESSION["u"])){
		echo "You are logged in as ".$_SESSION["u"].".<br/><br/><form method='POST'><input type='submit' class='grey' name='hor_submit_logout' value='Log Out'>&nbsp<input type='submit' class='grey' name='hor_openpage_changepassword' value='Change Password'></form>";
	}else{
		echo "<form method='POST'><input type='text' placeholder='Username' name='hor_username'><br/><input type='password' placeholder='Password' name='hor_password'><br/><input type='submit' name='hor_submit_login' value='Login'>&nbsp<input class='grey' type='submit' name='hor_submit_register' value='Register'></form>";
	}
}
?>
