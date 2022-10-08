<?php
mkdir("db/biographies");
if(isset($_POST["horbio_view"]) && strpos($_POST["horbio_user"], "..")===false){
	echo file_get_contents("db/biographies/".$_POST["horbio_user"])."<br/><br/><a href=''>Go Back</a>";
}else if(isset($_POST["horbio_savebio"])&& isset($_SESSION["u"])){
	file_put_contents("db/biographies/".$_SESSION["u"], $_POST["horbio_mybio"]);
	header("Location:");
	die();
}else if(isset($_POST["horbio_edit"])&& isset($_SESSION["u"])){
	echo "<form method='POST'><textarea name='horbio_mybio'>".file_get_contents("db/biographies/".$_SESSION["u"])."</textarea><br/><input type='submit' name='horbio_savebio' value='Save'></form>";
}else{
	echo "<form method='POST'><input type='text' placeholder='Username' name='horbio_user'><input type='submit' name='horbio_view' value='View Biography'>";
	if(isset($_SESSION["u"])){
		echo "<br/><input type='submit' name='horbio_edit' value='Edit my Biography'>";
	}
	echo "</form>";
}
?>
