<style>
	.custom-checkbox.add-user-pro-chk {width:31%;}
	.cmn-popup .custom-checkbox.checkbox.add-user-pro-chk label .oya-blk{width: 200px;}
</style>
<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header popup-header">
			<button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
			<h4><?php echo __("Disable Users");?></h4>			
		</div>
		<p style="padding: 5px 0px 5px 25px;font-size:15px;">
			<?php echo __("Unselect the ones you don't want to keep. The selected ones remain");?>.
		</p> 
		<div class="modal-body popup-container flex_scroll">
			<center><div id="err_msg_disa" class="err_msg" style=""></div></center>
			
			<div class="row">
				<div class="col-lg-12">					
					<?php foreach ($totActiveUsers AS $k => $usr) { ?>
						<div class="col-lg-4 checkbox custom-checkbox add-user-pro-chk usr_top_cnt" style="text-align: left;">
							<label>
								<?php if($usr['CompanyUser']['is_active']){ ?> 
									<input type="checkbox" checked="checked" class="comp_mem_chk" onclick="disableActiveUsers(this)"  value="<?php echo $usr['User']['uniq_id']; ?>"/>
								<?php }else{ ?>
									<input type="checkbox" class="comp_mem_chk" onclick="disableActiveUsers(this)"  value="<?php echo $usr['User']['uniq_id']; ?>"/>
								<?php } ?>
								<span class="oya-blk">
									<span title="<?php echo h($usr['User']['name'].' '.$usr['User']['last_name']);?>" rel="tooltip">
										<?php echo $this->Text->truncate(h($usr['User']['name'].' '.$usr['User']['last_name']),40,array('ellipsis' => '...','exact' => true)); ?>
									</span>
									<?php 
										if ($usr['Role']['role'] == 'Owner') {
											$colors = 'own_clr';
											$usr_typ_name = __('Owner',true);
										} else if ($usr['Role']['role'] == 'Admin') {
											$colors = 'adm_clr';
											$usr_typ_name = __('Admin',true);
										} else if ($usr['Role']['role'] == 'User' && $role != 3) {
											$colors = 'usr_clr';
											$usr_typ_name = __('User',true);
										} else{
											$colors = 'usr_clr';
											$usr_typ_name = ($usr['Role']['role'])?$usr['Role']['role']:__('User',true);
										}
										if($usr['CompanyUser']['is_client'] == 1){
											$colors = 'cli_clr';
											$usr_typ_name = __('Client',true);
										}
										if($usr['CompanyUser']['is_client'] == 1 && $usr['CompanyUser']['user_type'] == 2){
											$colors = 'cli_clr';
											$usr_typ_name = __('Admin & Client',true);
										}
									?>
									<span class="usr_cat <?php echo $colors;?>" style="position: relative;top: 1px;font-style: italic;"> <?php echo $usr_typ_name; ?></span>
								</span>
							</label>
						</div>						
					<?php if((($k+1)%3) == 0){?> <div class="cb"></div><?php } ?>
					<?php } ?>
				</div>
			</div>
			
			</div>
			<div class="modal-footer popup-footer popup_sticly_cta">
			<div class="fr popup-btn">
			</div>
			<div class="cb"></div>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>
<script type="text/javascript">
	function disableActiveUsers(obj){	
		var url = HTTP_ROOT + 'users/disable_active_users';
		var uid = $(obj).val();
		var type = ($(obj).is(':checked'))?1:0;
    $.post(url, {
        'uid': uid,
        'type': type
    }, function(res) {
			console.log(res);
    },'json');
	}
	$(function() {
	});
</script>