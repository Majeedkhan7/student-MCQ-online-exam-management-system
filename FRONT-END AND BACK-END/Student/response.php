<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
$from_time1=date("Y-m-d H:i:s");
$to_time=$_SESSION["end_time"];


$timefirst=strtotime($from_time1);
$timesec=strtotime($to_time);


$diff=$timesec-$timefirst;
echo  'Timeleft:'.' '.gmdate("H:i:s",$diff).' '.'mins';
?>