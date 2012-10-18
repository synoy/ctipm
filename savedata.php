<!DOCTYPE HTML>
<html>
<head>
  <meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE"/>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<?php

 
$db = 'gantt';
 $link = mysql_connect("localhost", "root", "5281")
		or die("Δεν είναι δυνατή η σύνδεση με τη βάση: " . mysql_error());
	mysql_select_db($db);
        mysql_query("SET NAMES greek");
	//return $link;

$id = $_GET["id"];  
$name = $_GET["name"];
$code = $_GET["code"];
$description = $_GET["description"];
$status = $_GET["status"];
$progress = $_GET["progress"];
$duration = $_GET["duration"];
$dependence = $_GET["dependence"];
$level = $_GET["level"];
$starti = $_GET["starti"];
$endi = $_GET["endi"];
$startIsMilestone = $_GET["startIsMilestone"];
$endIsMilestone = $_GET["endIsMilestone"];

/*
$fname = $_GET["fname"];
$size = $_GET["size"];
$mediaType = $_GET["mediaType"];
$data = $_GET["data"];
//$data = 4;
*/

  $dob1=trim($starti);//$dob1='dd/mm/yyyy' format
			list($d, $m, $y) = explode('/', $dob1);
			$start=mktime(0, 0, 0, $m, $d, $y)*1000;
      
  $dob2=trim($endi);//$dob1='dd/mm/yyyy' format
			list($d, $m, $y) = explode('/', $dob2);
		//	$end=mktime(23, 59, 59, $m, $d, $y)*1000+999;
    $end=mktime(0, 0, 0, $m, $d, $y)*1000;
  
   

   if ($id) {
   
   // 8elw na dw ti progress eixe arxika i ergasia (prin to update)
    $querw ='select progress,level from tasks where id='.$id.' ';
    $resultw = mysql_query($querw);
    $linew = mysql_fetch_row($resultw);
   
   //ginete to update me ta nea dedomena
    $quer ='UPDATE tasks SET name = "'.$name.'" , description ="'.$description.'" , progress ="'.$progress.'" , duration="'.$duration.'", depends="'.$dependence.'", start="'.$start.'", end="'.$end.'", level="'.$level.'",startIsMilestone="'.$startIsMilestone.'",endIsMilestone="'.$endIsMilestone.'" WHERE id='.$id.' ';
    $result = mysql_query($quer);
    $line = mysql_fetch_row($result);
   
   // vriskw to sinolo twn energeiwn poy vriskontai katw apo ena paketo ergasiwn kai to id toy paketoy ergasiwn 
    $quer1 ='select parent,count(parent) from tasks where parent = (select parent from tasks where id='.$id.') ';
    $result1 = mysql_query($quer1);
    $line1 = mysql_fetch_row($result1); 
    
 //   for ($i=0;$i=$linew[1]; $i++) {        //
 
 while ($linew[1])
  {
    //vriskw to progress toy paketoy ergasiwn prin
    $quer2 ='select progress from tasks where id='.$line1[0].' ';
    $result2 = mysql_query($quer2);
    $line2 = mysql_fetch_row($result2);
    
    // sigkrinw to progress tis diadikasias prin me auto meta to update, an einai megalutero prepei na pros8esw tin diafora alliws prepei na tin afairesw
    if ($progress>$linew[0]){
    $absprogress = abs($progress-$linew[0]);
    $upprogress = $line2[0]+($absprogress/$line1[1]);
    } else {
    $absprogress = abs($progress-$linew[0]);
    $upprogress = $line2[0]-($absprogress/$line1[1]);
    }
    
    $querw ='select progress,level from tasks where id='.$line1[0].' ';    //
    $resultw = mysql_query($querw);
    $linew = mysql_fetch_row($resultw);
   // $progress = $linec[0];      
    
    $quer ='UPDATE tasks SET progress ="'.$upprogress.'" WHERE id='.$line1[0].' ';
    $result = mysql_query($quer);
    $line = mysql_fetch_row($result);
    $progress = $upprogress;
    
  /*  $querw ='select progress from tasks where id='.$line1[0].' ';  //
    $resultw = mysql_query($querw);
    $linew = mysql_fetch_row($resultw);    */
    
     $quer1 ='select parent,count(parent) from tasks where parent = (select parent from tasks where id='.$line1[0].') ';    //
    $result1 = mysql_query($quer1);
    $line1 = mysql_fetch_row($result1); 
    }
    }else{
   $quer1 ="INSERT INTO tasks (name, description, progress, duration, depends, start, end, level) VALUES ('$name','$description', '$progress', '$duration', '$depends', '$start', '$end', '$level')";
     $result1 = mysql_query($quer1);
   $line1 = mysql_fetch_row($result1);
    }  
    
     //   $name = $dbLink->real_escape_string($_FILES['uploaded_file']['name']);
     //   $mime = $dbLink->real_escape_string($_FILES['uploaded_file']['type']);
     //   $data = $dbLink->real_escape_string(file_get_contents($_FILES  ['uploaded_file']['tmp_name']));
     //   $size = intval($_FILES['uploaded_file']['size']);
 
/* 
$fname = $_FILES['fileInput']['name']; 
$data = $_FILES['fileInput']['tmp_name']; 
$mediaType = $_FILES['fileInput']['type']; 
$size = $_FILES['fileInput']['size']; 
        // Create the SQL query
        $query = "INSERT INTO file (name, type, size, data, created, from_id) VALUES ('{$fname}', '{$mediaType}', {$size}, '{$data}', NOW(), '{$id}' )";      // argotera prepei na proste8ei kai project_id
  $resulta = mysql_query($query);
    $linea = mysql_fetch_row($resulta); 
    
  */
  
//  if( $_FILES['userfile']['size'] > 0)
//{ 


//if(isset($_GET['upload']) && $_FILES['userfile']['size'] > 0)
//{ 
	$fileName = $_FILES['userfile']['name'];
	$tmpName  = $_FILES['userfile']['tmp_name'];
	$fileSize = $_FILES['userfile']['size'];
	$fileType = $_FILES['userfile']['type']; 
 //$id = $_POST["id"]; 
 //  $id = 0;
	$fp      = fopen($tmpName, 'r');
	$content = fread($fp, filesize($tmpName));
	$content = addslashes($content);
	fclose($fp);
	
	if(!get_magic_quotes_gpc())
	{
		$fileName = addslashes($fileName);
	}
	

	$query = "INSERT INTO upload set name='".$fileName."', size='".$fileSize."', type='".$fileType."', content='".$content."'";
//	 mysql_query($query) or die('Error, query failed');
//} 

//$STARTFILE = 1; 
//	$ONFILE = "userfile";//. $STARTFILE; 

//	if (isset($_FILES["$ONFILE"])) {
//		$show_warn = savedata1($_FILES["$ONFILE"],$id);
//	} 
/*
     $fp      = fopen($data, 'r');
	$data1 = fread($fp, filesize($data));
	$data1 = addslashes($data1);
	fclose($fp);
  */
  
  /*
    	$query = "INSERT INTO file set name='".$fname."', size='".$size."', type='".$mediaType."', data='".$data."', created=NOW(), from_id='".$id."' ";
  // $query = "INSERT INTO file (name, type, size, created, data, from_id) VALUES ('{$fname}', '{$mediaType}', {$size}, NOW(), {$data}, '{$id}' )";      // argotera prepei na proste8ei kai project_id
  $resulta = mysql_query($query);
    $linea = mysql_fetch_row($resulta);    
    */
?>

 </head>
</html>  
