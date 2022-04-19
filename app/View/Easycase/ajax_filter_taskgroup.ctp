<input type="hidden" id="types_all">
<input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php
$m=0;
if(isset($groupArr))
{
	$m=0;
	$totGroupCase = 0;
	$h = 0;
	foreach($groupArr as $group)
	{   $groups=explode("-",$CookieGroup);
		$m++;
		$groupId = $group['Milestone']['id'];
		$groupName = $group['Milestone']['title'];
		$caseCount = $group[0]['cases'];
		?>
		<li class="li_check_radio" <?php if($m > 5){$h++;?> id="hidGroup_<?php echo $h; ?>"  <?php }?> >
		<div class="checkbox">
		  <label>
                      <input type="checkbox" id="groups_<?php echo $m; ?>" class="group<?php echo $groupId; ?>" onClick="checkboxGroups('groups_<?php echo $m; ?>','check');filterRequest('groups');"  style="cursor:pointer;" <?php if (in_array($groupId, $groups) ) { echo "checked"; } ?>/> <?php echo $groupName; ?> (<?php echo $caseCount;?>) 
		  </label>
		<input type="hidden" name="groupids_<?php echo $m; ?>" id="groupids_<?php echo $m; ?>" value="<?php echo $groupId; ?>" readonly="true">
		</div>
	    </li>
		<?php
	}
	if($h != 0){?>

	<?php
	} ?>

<?php } ?>
<input type="hidden" id="totGroupId" value="<?php echo $m; ?>" readonly="true"/>
