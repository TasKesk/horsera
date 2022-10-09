<?php
mkdir("db/followlists");
if(!file_exists("db/followlists/".$_SESSION["u"])){file_put_contents("db/followlists/".$_SESSION["u"], serialize(array()));}
$followlist=unserialize(file_get_contents("db/followlists/".$_SESSION["u"]));

if(isset($_POST["horf_follow"]) && !in_array($_POST["horf_follow_user"], $followlist) && strpos(file_get_contents("db/u.txt"),"%".$_POST["horf_follow_user"]."&")!==false && $_POST["horf_follow_user"]!==$_SESSION["u"]){
	array_push($followlist, $_POST["horf_follow_user"]);
	file_put_contents("db/followlists/".$_SESSION["u"], serialize($followlist));
	header("Location:");
	die();
}

if(isset($_POST["horf_unfollow"]) && in_array($_POST["horf_user"], $followlist)){
	unset($followlist[array_search($_POST["horf_user"], $followlist)]);
	file_put_contents("db/followlists/".$_SESSION["u"], serialize($followlist));
	header("Location:");
	die();
}

echo "Follow the users you would like to see on other services!<br/><br/><form method='POST'><input type='text' placeholder='Enter a username' name='horf_follow_user'><input type='submit' name='horf_follow' value='Follow'><br/><select size='".count($users)."' name='horf_user' multiple>";
foreach($followlist as &$user){
	echo "<option value='{$user}'><img src='https://www.gravatar.com/avatar/".md5($user)."?d=retro&f=y&s=16'>&nbsp{$user}</option>";
}
echo "</select><br/><input type='submit' name='horf_unfollow' class='grey' value='Unfollow selected'></form>";
?>
