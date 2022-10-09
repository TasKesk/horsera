<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Horsera Embedded Microserver 0.2.1</title>
<link rel="stylesheet" href="themes/default-light-dark.css">
<div class="box">
<?php
session_start();
if(!file_exists("db")){mkdir("db");}
/*ini_set("display_errors",1);
ini_set("display_startup_errors",1);*/

$addons=array_diff(scandir("addons"), array("..",".","README"));
foreach($addons as &$addon){
	include("addons/".$addon);
}

//At home or at a module?
if(!isset($_GET["module"])){
	//Default page
	echo file_get_contents("home.txt");
	$modules=array_diff(scandir('modules'),array("..","."));
	if(count($modules)>0){
		echo "<table class='course'>";
		foreach($modules as &$featurepath){
			echo "<tr><td><img src='modules/{$featurepath}/icon.png'></td><td><a href='?module={$featurepath}'>{$featurepath}</a></td>";
		}
		echo "</table>";
	}
}else{
	echo "<a href='?'>< Go Back</a><h1>".$_GET["module"]."</h1>";
	if(!file_exists("modules/".$_GET["module"]."/index.php")){echo"Can't load module";}
	include("modules/".$_GET["module"]."/index.php");
}
?>
</div>
