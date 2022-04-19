<input type="hidden" id="priority_all">
<?php
$priArray = array("Low","Medium","High");
foreach($priArray as $p)
{
?>
	<li class="li_check_radio">
	<div class="checkbox">
	  <label <?php 
		if($p == "High") { echo "style='color:#AE432E'"; } else if($p == "Medium") { echo "style='color:#28AF51'"; } else { echo "style='color:#AD9227'"; } ?>>
		<input type="checkbox" id="priority_<?php echo $p; ?>" onClick="checkboxPriority('priority_<?php echo $p; ?>','check');filterRequest('priority');" style="cursor:pointer;"  <?php if(strstr($CookiePriority,(string)$p)) { echo "checked"; } ?>/> <?php 
		if($p == "High") { echo "HIGH (".$query_pri_high.")"; } else if($p == "Medium") { echo "MEDIUM (".$query_pri_medium.")"; } else { echo "LOW (".$query_pri_low.")"; } ?>
	  </label>
	</div>
	</li>
<?php
}
?>
