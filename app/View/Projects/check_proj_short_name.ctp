<?php
if(isset($count))
{
	if($count != 0)
	{
		$err_short = "<font color='red'>'".$shortname."' ".__('is already exists',true)." !</font>";
	}
	else
	{
		$err_short = "<font color='green'>'".$shortname."' ".__('is available',true)." !</font>";
	}
	echo $err_short;
}
?>