<input type="text" name="search_user" id="project_archive_search" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php
if($_COOKIE['ARCHIVE_PROJECT'] != '' && $_COOKIE['ARCHIVE_PROJECT'] != 'all'){
$Asnbers = explode("-", $_COOKIE['ARCHIVE_PROJECT']);
}else if($_COOKIE['ARCHIVE_FILE_PROJECT'] != '' && $_COOKIE['ARCHIVE_FILE_PROJECT'] != 'all'){
	$Asnbers = explode("-", $_COOKIE['ARCHIVE_FILE_PROJECT']);
}
$m=0;
if(isset($prjlist))
{
	$m=0;
	$totAsnCase = 0;
	$h = 0;
	foreach($prjlist as $list)
	{
		$m++;
		$prjId = $list['Project']['id'];
		$prjName = $list['Project']['name'];
		//if($m > 5){$h++;
		?>
			<li <?php if($m > 5){$h++;?> id="hidprjid_<?php echo $h; ?>" style="display:block;" <?php }?> class="li_check_radio">			
				<div class="checkbox slide_menu_div1">
				  <label>
					<input class="cst_prj_cls" type="checkbox" id="prjid_<?php echo $prjId; ?>" onClick="checkboxArcProject('<?php echo $prjId; ?>','check');filterRequest('project');"  data-id="<?php echo $prjId; ?>" <?php if (in_array($prjId, $Asnbers)) { echo "checked"; } ?>/> <?php echo $this->Format->shortLength($prjName,15); ?>
				  </label>
				  <input type="hidden" name="prjids_<?php echo $prjId; ?>" id="prjids_<?php echo $prjId; ?>" value="<?php echo $prjId; ?>" readonly="true">
				</div>
			</li>
<?php }
$h = 0;
if($h != 0)
	{
	?>
	<div class="slide_menu_div1 more-hide-div">
		<div class="more" align="right" id="Prj_more" >
			<a href="javascript:jsVoid();" onClick="moreLeftNav('Prj_more','Prj_hide','<?php echo $h; ?>','hidprjid_',event)"><?php echo __('more');?>...</a>
		</div>
		<div class="more" align="right" id="Prj_hide" style="display:none;">
			<a href="javascript:jsVoid();" onClick="hideLeftNav('Prj_more','Prj_hide','<?php echo $h; ?>','hidprjid_',event)"><?php echo __('hide');?>...</a>
		</div>
	</div>
	<?php
	} ?>
<?php } ?>