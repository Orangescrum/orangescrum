<?php
$types = "";
if(isset($Date) && !empty($Date)){
	if(trim($Date) == 'one'){
		echo __("Past hour");
	}else if(trim($Date) == '24'){
		echo __("Past 24Hour");
	}else if(trim($Date) == 'week'){
		echo __("Past Week");
	}else if(trim($Date) == 'month'){
		echo __("Past month");
	}else if(trim($Date) == 'year'){
		echo __("Past Year");
	}else if(strstr(trim($Date),":")){
		echo str_replace(":"," - ",$Date);
	}
}else { echo __("Any Time"); }
?>
