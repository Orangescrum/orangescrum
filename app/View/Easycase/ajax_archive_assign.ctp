<?php
//echo "<pre>";
//print_r($list);exit;
if($_COOKIE['ARCHIVE_ASSIGNTO'] != '' && $_COOKIE['ARCHIVE_ASSIGNTO'] != 'all'){
$archive_usr_fil = explode("-",$_COOKIE['ARCHIVE_ASSIGNTO']);
} 
?>
<li id="archive_unassigned">
	<a>
		<div class="slide_menu_div1" style="cursor:pointer;">
			<input type="checkbox" id="unassign" onclick="checkboxarchiveassign('unassign','check');filterRequest('casearchiveassign');" <?php if($_COOKIE['ARCHIVE_ASSIGNTO'] == "unassigned"){ echo "checked"; } ?> />
			<font onclick="checkboxarchiveassign('unassign','text');filterRequest('casearchiveassign');" title="Unassigned">&nbsp;<?php echo __('Unassigned');?></font>
			<input type="hidden" name="Asnids_0" id="Asnids_0" value="0" readonly="true">
		</div>
	</a>
</li>
<?php
//echo "<pre>";
//print_r($list);exit;
if($_COOKIE['ARCHIVE_ASSIGNTO'] != '' && $_COOKIE['ARCHIVE_ASSIGNTO'] != 'all'){
$archive_usr_fil = explode("-",$_COOKIE['ARCHIVE_ASSIGNTO']);
}
$m=0;
if(isset($list))
{
	$m=0;
	$h = 0;
	foreach($list as $li)
	{
		$m++;
		$userId = $li['User']['id'];
		//$AsnUniqId = $Asn['User']['uniq_id'];
		$ArcName = $li['User']['name']." ".$li['User']['last_name'];
		$Arc_date = date('Y-m-d', strtotime($li['Archive']['dt_created']));
		$shortname =  $li['User']['short_name'];
		//if($m > 5){$h++;
		?>
			<li <?php if($m > 5){$h++;?> id="hidassignid_<?php echo $h; ?>" style="display:none;" <?php }?>>
		    <a href="javascript:void(0);">
			<div class="slide_menu_div1">
			<input class="cst_assign_cls" type="checkbox" id="assignid_<?php echo $userId; ?>" onClick="checkboxarchiveassign('<?php echo $userId; ?>','check');filterRequest('casearchiveassign');"  data-id="<?php echo $userId; ?>" <?php if (in_array($userId, $archive_usr_fil)) { echo "checked"; } ?>/>
			<font onClick="checkboxarchiveassign('<?php echo $userId; ?>','text');filterRequest('casearchiveassign');"   title='<?php echo $this->Format->formatText($shortname); ?>'>
			&nbsp;<?php //echo $this->Format->formatText($ArcName); 
				echo $this->Format->shortLength($ArcName,15);
			?>
			</font>
			<div style="margin:0;color:#999999;line-height:16px;padding-left:20px;font-size:11px;">
				<input type="hidden" name="assignids_<?php echo $userId; ?>" id="assignids_<?php echo $userId; ?>" value="<?php echo $userId; ?>" readonly="true">
			</div>
			</li>
<?php } 
if($h != 0)
	{
	?>
	<div class="slide_menu_div1 more-hide-div">
		<div class="more" align="right" id="Assign_more" >
			<a href="javascript:jsVoid();" onClick="moreLeftNav('Assign_more','Assign_hide','<?php echo $h; ?>','hidassignid_',event)"><?php echo __('more');?>...</a>
		</div>
		<div class="more" align="right" id="Assign_hide" style="display:none;">
			<a href="javascript:jsVoid();" onClick="hideLeftNav('Assign_more','Assign_hide','<?php echo $h; ?>','hidassignid_',event)"><?php echo __('hide');?>...</a>
		</div>
	</div>
	<?php
	} ?>
<?php } ?>