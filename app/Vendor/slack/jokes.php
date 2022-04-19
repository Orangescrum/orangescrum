<?php
$file = fopen("jokes.txt","w");
echo fwrite($file,$_REQUEST);
fclose($file);
?>