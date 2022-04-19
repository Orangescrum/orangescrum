<input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php 
//for default status
$dft_sts = array(1=>'new',2=>'inprogress',3=>'closed');
foreach($dft_sts as $dk => $dv){ ?>
	<li class="li_check_radio">
		<div class="checkbox">
			<label> <?php //archive_status_cls ?>
				<input class="pending-status" type="checkbox" data-id="<?php echo $dk; ?>" id="pending_sts<?php echo $dv; ?>" onclick="pending_status('<?php echo $dv; ?>', 'check');"/>
				<?php 
				if($dk == 1){ 
					echo __('New');
				}else if($dk == 2){ 
					echo __('In Progress');
				}else if($dk == 3){ 
					echo __('Closed');
				} ?>
			</label>
		</div>
	</li>
<?php } ?>

<?php
//for custom status
if(isset($allCustomStatus) && !empty($allCustomStatus)){
	foreach($allCustomStatus as $ck => $cv){
?>	
<li class="li_check_radio">
	<div class="checkbox">
		<label>
			<input class="pending-status" type="checkbox" data-id="c<?php echo $cv['CustomStatus']['id'];?>" id="pending_sts<?php echo $cv['CustomStatus']['id'];?>" onclick="pending_status('<?php echo $cv['CustomStatus']['id'];?>', 'check');"/> <?php echo $cv['CustomStatus']['name']; ?>
		</label>
	</div>
</li>
<?php } } ?>