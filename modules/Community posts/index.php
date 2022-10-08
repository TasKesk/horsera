<?php
function time_elapsed_string($datetime, $full = false) {$now = new DateTime;$ago = new DateTime($datetime);$diff = $now->diff($ago);$diff->w = floor($diff->d / 7);$diff->d -= $diff->w * 7;$string = array('y' => 'y','m' => 'm','w' => 'w','d' => 'd','h' => 'h','i' => 'min','s' => 's',);foreach ($string as $k => &$v) {if ($diff->$k) {$v = $diff->$k.$v . ($diff->$k > 1 ? '' : '');} else {unset($string[$k]);}}$string = array_slice($string, 0, 1);return $string ? implode(', ', $string) : 'now';}

mkdir("db/posts");
file_put_contents("db/posts/index.html","<!--File is used to prevent listing inboxes. -->");

if(isset($_SESSION["u"])){
	echo "<form method='POST'>";
	if(file_exists("db/followlists")){
		$followlist=unserialize(file_get_contents("db/followlists/".$_SESSION["u"]));
		if($_SESSION["horpost_filter"]==="following"){
			echo "<input type='submit' name='horpost_changefilter' value='Show all users' class='grey'>";
		}else{
			echo "<input type='submit' name='horpost_changefilter' value='Show users I follow' class='grey'>";
		}
	}
	echo " <textarea name='horpost_message' placeholder='Tell the community something'></textarea><br/><input type='submit' name='horpost_post' value='Post'></form>";
}

if(isset($_POST["horpost_changefilter"]) && file_exists("db/followlists")){
	if($_SESSION["horpost_filter"]==="following"){
		$_SESSION["horpost_filter"]="all";
	}else{
		$_SESSION["horpost_filter"]="following";
	}
	header("Location:");
	die();
}

if(isset($_POST["horpost_post"])){
	if(strlen($_POST["horpost_message"])>200){
		echo "You can post up to 200 characters";
		die();
	}
	$nid=(microtime(true)*10000);
	file_put_contents("db/posts/".$nid, serialize(array($_SESSION["u"], (string) time(), $_POST["horpost_message"], array(), $nid)));
	header("Location:");
	die();
}

if(isset($_POST["horpost_like"])&&isset($_SESSION["u"])){
	$node=unserialize(file_get_contents("db/posts/".(string)((int)$_POST["horpost_like_target"])));
	if(in_array($_SESSION["u"], $node[3])){
		unset($node[3][array_search($_SESSION["u"],$node[3])]);
	}else{
		array_push($node[3],$_SESSION["u"]);
	}
	file_put_contents("db/posts/".(string)((int)$_POST["horpost_like_target"]),serialize($node));
	header("Location:");
	die();
}

$serialized_nodes=array_diff(scandir("db/posts"),array(".","..","index.html"));
$nodes=array();
foreach($serialized_nodes as &$nid){
	array_push($nodes,unserialize(file_get_contents("db/posts/".$nid)));
}

function trending_sort($a, $b){
	if(   count($a[3]) / (time()-(int)$a[1])   <   count($b[3]) / (time()-(int)$b[1])   ){
		return 1;
	}else{
		return -1;
	}
}

usort($nodes, "trending_sort");

foreach($nodes as &$node){
	if(in_array($_SESSION["u"], $node[3])){$likebtn="Unlike";}else{$likebtn="Like";}

	if(file_exists("db/followlists") && isset($_SESSION["u"])){
		if($_SESSION["horpost_filter"]==="all" || in_array($node[0], $followlist)){
			$filtered=false;
		}else{
			$filtered=true;
		}
	}else{
		$filtered=false;
	}
	
	if(!$filtered){
		echo "<hr/><strong>{$node[0]}</strong>&nbsp<span class='small'>".time_elapsed_string("@".$node[1])."</span><br/>".str_replace("\n","<br/>",str_replace("<","<x><</x>",$node[2]))."<br/><form method='POST'><input name='horpost_like_target' value='{$node[4]}' hidden><input class='micro grey' type='submit' name='horpost_like' value='{$likebtn} (".count($node[3]).")'></form>";
	}
}
?>
