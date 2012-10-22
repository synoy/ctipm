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
$fprogress = $_GET["fprogress"];
$duration = $_GET["duration"];
$dependence = $_GET["dependence"];
$level = $_GET["level"];
$starti = $_GET["starti"];
$endi = $_GET["endi"];
$startIsMilestone = $_GET["startIsMilestone"];
$endIsMilestone = $_GET["endIsMilestone"];
$full_mes = $_GET["full_mes"];
$now_mes = $_GET["now_mes"];
$ffull_mes = $_GET["ffull_mes"];
$fnow_mes = $_GET["fnow_mes"];

  $dob1=trim($starti);//$dob1='dd/mm/yyyy' format
			list($d, $m, $y) = explode('/', $dob1);
			$start=mktime(0, 0, 0, $m, $d, $y)*1000;
      
  $dob2=trim($endi);//$dob1='dd/mm/yyyy' format
			list($d, $m, $y) = explode('/', $dob2);
		//	$end=mktime(23, 59, 59, $m, $d, $y)*1000+999;
    $end=mktime(0, 0, 0, $m, $d, $y)*1000;
  
   

   if ($id) {
   
   // 8elw na dw ti progress eixe arxika i ergasia (prin to update)
    $querw ='select progress,level,now_mes from tasks where id='.$id.' ';
    $resultw = mysql_query($querw);
    $linew = mysql_fetch_row($resultw);

//   
if ($progress==$linew[0] && ($now_mes!=$linew[2])){
if (($full_mes!=0) && ($now_mes!=0)) {    //8a valw ton elegxo na ginetai eksw wste na min mporei na exei timi to now_mes enw to full_mes na eina 0
$progress = (1-(($full_mes-$now_mes)/$full_mes))*100;
}
}
//else{
//$progress = (1-(($full_mes-$now_mes)/$full_mes))*100;
//$now_mes = ($full_mes-(1-($progress/100)*$full_mes));
//}
   
   
   //ginete to update me ta nea dedomena
    $quer ='UPDATE tasks SET name = "'.$name.'" , description ="'.$description.'" , progress ="'.$progress.'" , fprogress ="'.$fprogress.'" , duration="'.$duration.'", depends="'.$dependence.'", start="'.$start.'", end="'.$end.'", level="'.$level.'",startIsMilestone="'.$startIsMilestone.'",endIsMilestone="'.$endIsMilestone.'",full_mes="'.$full_mes.'",now_mes="'.$now_mes.'",ffull_mes="'.$ffull_mes.'",fnow_mes="'.$fnow_mes.'" WHERE id='.$id.' ';
    $result = mysql_query($quer);
    $line = mysql_fetch_row($result);
   
   // vriskw to sinolo twn energeiwn poy vriskontai katw apo ena paketo ergasiwn kai to id toy paketoy ergasiwn 
    $quer1 ='select parent,count(parent) from tasks where parent = (select parent from tasks where id='.$id.') ';
    $result1 = mysql_query($quer1);
    $line1 = mysql_fetch_row($result1); 
    
 //   for ($i=0;$i=$linew[1]; $i++) {        //


/* 
 //gia na ayksanetai to pososto oloklirwseis twn parrent ergasiwn
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
    
  // $querw ='select progress from tasks where id='.$line1[0].' ';  //
  //  $resultw = mysql_query($querw);
  //  $linew = mysql_fetch_row($resultw);  
    
     $quer1 ='select parent,count(parent) from tasks where parent = (select parent from tasks where id='.$line1[0].') ';  
    $result1 = mysql_query($quer1);
    $line1 = mysql_fetch_row($result1); 
    }
 */   
    
    
    }else{
   $quer1 ="INSERT INTO tasks (name, description, progress, duration, depends, start, end, level) VALUES ('$name','$description', '$progress', '$duration', '$depends', '$start', '$end', '$level')";
     $result1 = mysql_query($quer1);
   $line1 = mysql_fetch_row($result1);
    }  

?>

 </head>
</html>  
