<?php
mkdir("db/mail");
file_put_contents("db/mail/index.html","<!--File is used to prevent listing inboxes. -->");

if(!isset($_SESSION["u"])){
echo "You need to be logged in to use this service";
die();
}

if(isset($_POST["hormsg_send"])){
	file_put_contents("db/mail/".(microtime(true)*10000),serialize(array($_SESSION["u"], $_POST["hormsg_to"], $_POST["hormsg_message"])));
	header("Location:");
}

if(isset($_POST["hormsg_openpage_compose"])){
	echo "<form method='POST'><input type='text' placeholder='To' name='hormsg_to'><br/><textarea name='hormsg_message' placeholder='Message'></textarea><br/><input type='submit' name='hormsg_send' value='Send'></form><a href=''>Cancel</a>";
}else{
	echo "<form method='POST'><input type='submit' name='hormsg_openpage_compose' value='Compose'></form>";
	$message_nodes=array_diff(scandir("db/mail"),array(".","..","index.html"));
	foreach($message_nodes as &$nid){
		$node=unserialize(file_get_contents("db/mail/".$nid));
		if($node[0]===$_SESSION["u"] || $node[1]===$_SESSION["u"]){
			echo "<hr/><strong>From: {$node[0]}<br/>To: {$node[1]}</strong><br/><br/>".str_replace("\n","<br/>",str_replace("<","<x><</x>",$node[2]));
		}
	}
}
?>
