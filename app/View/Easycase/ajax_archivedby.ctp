<input type="text" name="search_user" id="archivedby_archive_search" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php
if($_COOKIE['ARCHIVE_USER'] != '' && $_COOKIE['ARCHIVE_USER'] != 'all'){
$archive_usr_fil = explode("-",$_COOKIE['ARCHIVE_USER']);
}else if($_COOKIE['ARCHIVE_FILE_USER'] != '' && $_COOKIE['ARCHIVE_FILE_USER'] != 'all'){
	$archive_usr_fil = explode("-",$_COOKIE['ARCHIVE_FILE_USER']);
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
		$ArcName = $li['User']['name']." ".$li['User']['last_name'];
		$Arc_date = date('Y-m-d', strtotime($li['Archive']['dt_created']));
		$shortname =  $li['User']['short_name'];
		?>
			<li <?php if($m > 5){$h++;?> id="hiduserid_<?php echo $h; ?>" style="display:block;" <?php }?> class="li_check_radio">
			
			<div class="checkbox slide_menu_div1">
			  <label>
				<input class="cst_user_cls" type="checkbox" id="userid_<?php echo $userId; ?>" onClick="checkboxarchivedby('<?php echo $userId; ?>','check');filterRequest('casearchivedby');"  data-id="<?php echo $userId; ?>" <?php if (in_array($userId, $archive_usr_fil)) { echo "checked"; } ?>/>
				<?php echo $this->Format->shortLength($ArcName,15); ?>
			  </label>
			  <input type="hidden" name="userids_<?php echo $userId; ?>" id="userids_<?php echo $userId; ?>" value="<?php echo $userId; ?>" readonly="true">
			</div>
		</li>
<?php } 
$h = 0;
if($h != 0)
	{
	?>
	<div class="slide_menu_div1 more-hide-div">
		<div class="more" align="right" id="User_more" >
			<a href="javascript:jsVoid();" onClick="moreLeftNav('User_more','User_hide','<?php echo $h; ?>','hiduserid_',event)"><?php echo __('more');?>...</a>
		</div>
		<div class="more" align="right" id="User_hide" style="display:none;">
			<a href="javascript:jsVoid();" onClick="hideLeftNav('User_more','User_hide','<?php echo $h; ?>','hiduserid_',event)"><?php echo __('hide');?>...</a>
		</div>
	</div>
	<?php
	} ?>
<?php } ?>