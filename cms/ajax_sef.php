<?php
/**
* Function to convert a title into SEF title.
* Remove all the special character inputs into en dashes (-)
* This page is called through ajax call,
* to convert the the name into sef title dynamically.
*/

$data = $_POST;

$title = strtolower(addslashes(trim($data['title'])));
$search = array('`','!','@','#','%','^','&','*','(',')','+','|',':',';','[',']','{','}','.','/',' ');
$repl = '-';
$sef_title = str_replace($search, $repl, $title);
echo $sef_title;
exit;
?>