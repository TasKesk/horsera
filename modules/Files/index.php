<?php
mkdir("db/files");
$files=array_diff(scandir("db/files"),array("..","."));

if(isset($_POST["hordl_download"]) && in_array($_POST["hordl_file"],$files)){
	ob_clean();
	header('Content-Type: application/octet-stream');
	header("Content-Transfer-Encoding: Binary"); 
	header("Content-disposition: attachment; filename=\"".$_POST["hordl_file"]."\""); 
	readfile("db/files/".$_POST["hordl_file"]);
}else{
	echo "<form method='POST'><select size='".count($files)."' name='hordl_file' multiple>";
	foreach($files as &$file){
		echo "<option value='{$file}'>{$file}</option>";
	}
	echo "</select><br/><br/><input type='submit' name='hordl_download' value='Download'></form>";
}
?>
