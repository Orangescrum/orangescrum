<input type="text" name="search_user" id="project_pending_search" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php
//echo "<pre>";
//print_r($prjlist);exit;
if($_COOKIE['pending_project_filter'] != '' && $_COOKIE['pending_project_filter'] != 'all'){
$Asnbers = explode("-", $_COOKIE['pending_project_filter']);
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
		//$AsnUniqId = $Asn['User']['uniq_id'];
		$prjName = $list['Project']['name'];
		//if($m > 5){$h++;
		?>
        <li class="li_check_radio" <?php if($m > 5){$h++;?> id="hidprjid_<?php echo $h; ?>" style="display:block;" <?php }?>>
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="pending-project" id="prjid_<?php echo $prjId; ?>" onClick="pending_project('<?php echo $prjId; ?>','check');"  data-id="<?php echo $prjId; ?>" <?php if (in_array($prjId, $Asnbers)) { echo "checked"; } ?> />
                    &nbsp;<?php echo $this->Format->shortLength($prjName,15); ?>
                    <input type="hidden" name="prjids_<?php echo $prjId; ?>" id="prjids_<?php echo $prjId; ?>" value="<?php echo $prjId; ?>" readonly="true">
                </label>
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