<?php

$sessionid = (int)$_POST["sessionid"];
$userid = (int)$_POST["userid"];
$counter = (int)$_POST["counter"];
$hand_history = $_POST["hand_history"];

$filePointer = fopen("results.txt", "a");
if ($filePointer)
{
	$timestamp = date("F j, Y, g:i a");                 
	fwrite($filePointer, "$timestamp\nsessionid: $sessionid\nuserid: $userid\ncounter: $counter\nhand_history: $hand_history\n\n");
	fclose($filePointer);
}
		
?>