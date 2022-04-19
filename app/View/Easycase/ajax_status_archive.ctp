<input type="text" name="search_user" id="project_status_search" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php 
//for default status
$dft_sts = array(1=>'new',2=>'inprogress',3=>'closed',5=>'resolved');
foreach($dft_sts as $dk => $dv){ ?>
	<li class="li_check_radio">
		<div class="checkbox">
			<label>
				<input class="archive_status_cls" type="checkbox" data-id="<?php echo $dk; ?>" id="archive_<?php echo $dv; ?>" onclick="checkboxarchivestatus('<?php echo $dv; ?>', 'check');"/>
				<?php 
				if($dk == 1){ 
					echo __('New');
				}else if($dk == 2){ 
					echo __('In Progress');
				}else if($dk == 3){
					echo __('Closed');
				}else{
					echo __('Resolved');
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
			<input class="archive_status_cls" type="checkbox" data-id="c<?php echo $cv['CustomStatus']['id'];?>" id="archive_c<?php echo $cv['CustomStatus']['id'];?>" onclick="checkboxarchivestatus('c<?php echo $cv['CustomStatus']['id'];?>', 'check');"/> <?php echo $cv['CustomStatus']['name']; ?>
		</label>
	</div>
</li>
<?php } } ?>



