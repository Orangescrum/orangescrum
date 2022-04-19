<input type="hidden" id="label_all">
<input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php
$m=0;
if(isset($LabelArr) && !empty($LabelArr))
{
	$m=0;
	$h = 0;
	foreach($LabelArr as $Label)
	{   
		$m++;
		$LabelId = $Label['Label']['id'];
		$LabelName = $Label['Label']['lbl_title'];
		?>
			<li class="li_check_radio" <?php if($m > 5){$h++;?> id="hidLabel_<?php echo $h; ?>"  <?php }?>> 
		    <div class="checkbox">
			  <label>
				  <input type="checkbox" class="label_type_cls" data-id="<?php echo $m; ?>" id="Label_<?php echo $m ?>" onClick="checkboxLabel('Label_<?php echo $m; ?>','check');filterRequest('label');" /> <?php echo $this->Format->formatText($LabelName); ?> (<?php echo $Label[0]['ec_cnt']; ?>)
			  </label>
				<input type="hidden" name="Labelids_<?php echo $m; ?>" id="Labelids_<?php echo $m; ?>" value="<?php echo $LabelId; ?>" readonly="true">
			</div>
		</li>
		<?php
	}
	if($h != 0)
	{
	?>
	<?php
	} ?>
<?php }else{ ?>
<li style="color: #e47a7a;font-size: 13px;text-align: center;padding: 5px;">
<span class="no-data-found"><?php echo __('No Label Created.'); ?></span>
</li>
<?php } ?>
<input type="hidden" id="totLable" value="<?php echo $m; ?>" readonly="true"/>
