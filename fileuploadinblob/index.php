<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<?php
/*
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	* Developed By : www.smartcoderszone.com [ Amit Kumar Paliwal ] *
	* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
include("config.php");

$content_id = $_GET['id'];
if(isset($_POST['upload']) && $_FILES['userfile']['size'] > 0)
{
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type'];
	
	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);
	
	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}
	

	$query = "INSERT INTO upload set name='".$fileName."', size='".$fileSize."', type='".$fileType."', content='".$content."', content_id='".$content_id."'";
	mysql_query($query) or die('Error, query failed');
	echo "<br>File $fileName uploaded<br>";
}


?>

<table cellpadding="10" cellspacing="0" width="100%" border="0" align="center">

<tr><td align="center">
<?php
// select records from database if exists to display
$query1 = "SELECT id, name FROM upload where content_id='".$content_id."'";
$result1 = mysql_query($query1) or die('Error, query failed');
if(mysql_num_rows($result1)>0)
{
	while(list($id, $name) = mysql_fetch_array($result1))
	{
	?>  
		<a href="download.php?id=<?php echo $id;?>"><?php echo $name;?></a> <br>
		
	<?php
	}
} else {
print "Δεν υπάρχουν διαθέσιμα αρχεία";
}
?>
</td></tr>

<tr><td align="center">
	<form method="post" enctype="multipart/form-data">
	<table width="350" border="0" cellpadding="1" cellspacing="1" class="box">
	<tr>
	<td width="246">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
	<input name="userfile" type="file" id="userfile">
	</td>
	<td width="80"><input name="upload" type="submit" class="box" id="upload" value=" Επιφόρτωση αρχείου "></td>
	</tr>
	</table>
	</form>
</td></tr>
</table>

 </head>
</html>  
