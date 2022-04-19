<style>
.exist_users_list{
	padding: 6px 0px;
    font-size: 13px;
    border-bottom: 1px solid #DBEAF9;
    width: 236px;
    margin-bottom: 20px;
}
.mtop_assign {margin-top: 10px;}
</style>
<input id="proj_uniq_id" type="hidden" value="<?php echo $proj_uniq_id; ?>" />
<input id="Pjname" type="hidden" value="<?php echo $Pjname; ?>" />
<input id="Pjid" type="hidden" value="<?php echo $Pjid; ?>" />
<div class="modal-body popup-container" style="padding-bottom:0px;">
    <div class="row">
        <div class="col-lg-12">
            <ul>
                <li class="nav_tab_both active" onclick="asign_existing_users(this);">
                    <a href="javascript:void(0);"><?php echo __('Assign existing user(s)');?></a>
                </li>
                <?php if(SES_TYPE < 3) { ?>
                <li class="nav_tab_both" onclick="invite_asign_users(this);">
                    <a href="javascript:void(0);"><?php echo __('Invite new user(s)');?></a>
                </li>                    
                <?php } ?>
            </ul>
			<span id="asgnd_usr_cnt" class="fr assigned_user_to_proj">---</span>
        </div>
    </div>
</div>
<div id="puser_add_error" style="text-align:center;color:red;font-size:14px;">&nbsp;</div>
<div id="existing_conopamy_users">
    <div class="modal-body popup-container" style="padding-top:0px; " >
        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-5 col-sm-5 col-xs-5 padlft-non">
                    <div class="checkbox add-all-user">
                        <label class="">
                            <input type="checkbox" onclick="select_all_user_add_to_project($(this))">
                            <span><?php echo __('All');?></span>
                        </label>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3"></div>
                <div class="col-lg-4 col-sm-4 col-xs-4 padrht-non">
                        <div class="form-group label-floating">
												<label class="control-label" for="srch_usr_to_assgn"><?php echo __('Find User');?></label>
												<input class="form-control" id="srch_usr_to_assgn" placeholder="" type="text"/>
                        </div>
                </div>
								<div class="cb"></div>
            </div>
        </div>
        <div class="row pop-user-checkbox" id="all_chechboxes">
            <div class="col-lg-12">
				<?php if($allProjUsers){ ?>
				<div style="min-height:50px;">
					<div class="exist_users_list"><?php echo __('Current assigned user(s)');?></div>
					<?php
                        foreach ($allProjUsers as $ak => $av) {
                            if(!isset($allUsers[$av]['User']))
                                continue;
                            $name = $allUsers[$av]['User']['name'];
                            if (trim($allUsers[$av]['User']['name']) == '') {
                                $at_name = explode('@', $allUsers[$av]['User']['email']);
                                $name = $at_name[0];
                            }
                            $place_holder = '';
                            if ($allUsers[$av]['CompanyUser']['is_client']) {
                                $place_holder = '<small class="green-txt">'.__('Client',true).'</small>';
                            } else if ($allUsers[$av]['CompanyUser']['user_type'] == 1) {
                                $place_holder = '<small class="green-txt">'.__('Owner',true).'</small>';
                            } else if ($allUsers[$av]['CompanyUser']['user_type'] == 2) {
                                $place_holder = '<small class="green-txt">'.__('Admin',true).'</small>';
                            }else{
                                $place_holder = '<small class="green-txt">&nbsp;</small>';
                            }                            
                            $checked = 'checked="checked"';
                            ?>
                            <div class="checkbox custom-checkbox add-user-pro-chk">
                                <label for="add_user_proj_<?php echo $allUsers[$av]['User']['id']; ?>" title11="<?php #echo $allUsers[$av]['User']['email']; ?>">
                                    <input id="add_user_proj_<?php echo $allUsers[$av]['User']['id']; ?>" type="checkbox" value="<?php echo $allUsers[$av]['User']['id']; ?>" class="add_user_chk crntly_asgnd_usrs" <?php echo $checked; ?>/>
                                    <span class="oya-blk">
                                       <span class="assign_usr_chk" title="<?php echo $allUsers[$av]['User']['email']; ?><?php if($allUsers[$av]['CompanyUser']['is_active']==0){ echo " \n (".__('Disabled').")";}?>" rel="tooltip" <?php if($allUsers[$av]['CompanyUser']['is_active']==0){ echo "style='color:#a59b9b;text-decoration:line-through;'"; }?> >
                                           <?php echo $this->Text->truncate($name,17,array('ellipsis' => '...','exact' => true)); ?>
                                        </span>
                                       <?php echo $place_holder; ?>
                                    </span>
                                </label>
                            </div>
					<?php } ?>
				</div>
				<div class="cb"></div>
				<?php } ?>
				<div class="exist_users_list mtop_assign"><?php echo __('Choose user(s) to assign to this project');?></div>                    
                <div class="custom_scroll" style="height:200px;">
					<?php if ($allUsers) { ?>
                        <?php
						$chk_cnt = 0;
                        foreach ($allUsers as $k => $v) {
							
							if(!in_array($v['User']['id'], $allProjUsers)){
							$chk_cnt = 1;
                            $name = $v['User']['name'];
                            if (trim($v['User']['name']) == '') {
                                $t_name = explode('@', $v['User']['email']);
                                $name = $t_name[0];
                            }
                            $place_holder = '';
                            if ($v['CompanyUser']['is_client']) {
                                $place_holder = '<small class="green-txt">'.__('Client',true).'</small>';
                            } else if ($v['CompanyUser']['user_type'] == 1) {
                                $place_holder = '<small class="green-txt">'.__("Owner",true).'</small>';
                            } else if ($v['CompanyUser']['user_type'] == 2) {
                                $place_holder = '<small class="green-txt">'.__('Admin',true).'</small>';
                            }else{
                                $place_holder = '<small class="green-txt">&nbsp;</small>';
                            }
                            
                            $checked = (in_array($v['User']['id'], $allProjUsers)) ? 'checked="checked"' : "";
                            ?>
                            <div class="checkbox custom-checkbox add-user-pro-chk">
                                <label for="add_user_proj_<?php echo $v['User']['id']; ?>" title11="<?php #echo $v['User']['email']; ?>">
                                    <input id="add_user_proj_<?php echo $v['User']['id']; ?>" type="checkbox" value="<?php echo $v['User']['id']; ?>" class="add_user_chk usr_to_b_asgnd" <?php echo $checked; ?>/>
                                    <span class="oya-blk">
                                       <span class="assign_usr_chk" title="<?php echo $v['User']['email']; ?><?php #echo trim($name);?>" rel="tooltip">
                                           <?php echo $this->Text->truncate($name,17,array('ellipsis' => '...','exact' => true)); ?>
                                        </span>
                                       <?php echo $place_holder; ?>
                                    </span>
                                </label>
                            </div>
                        <?php } } if(!$chk_cnt){ echo '<span style="color:red;font-size:13px;">'.__('No more users left to assign.').'</span>'; } ?>
                        <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="fr popup-btn act_btttn">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="fl hover-pop-btn"><a href="javascript:void(0)" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive btnassignUserToPrj" onclick="assignUserToPrj();"><?php echo __('Save');?></a></span>
            <div class="cb"></div>
        </div>
        <div id="ldr_pop" style="display:none; margin-right: 10px;" class="fr">
            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="<?php echo __('Loading');?>..." title="<?php echo __('Loading');?>..." />
        </div>
    </div>
</div>
<div id="add_newconopamy_users" style="display: none;">
    <?php echo $this->element('new_user'); ?>
</div>
<script type="text/javascript">
var asgn_users_arr = new Array();
function assignUserToPrj(){
    if($('.act_btttn').find('.btnassignUserToPrj').hasClass('loginactive')){
        return false;
    }else{
	var loc = HTTP_ROOT+"projects/assignUserToProject/";
	var user_ids = '';
	$('.add_user_chk').each(function(){
		if($(this).is(':checked')){
			user_ids += ','+$(this).val();
		}
	});
	$('#puser_add_error').html('&nbsp;');
	if(user_ids == ''){
            $('#puser_add_error').html("<?php echo __('Choose at least one user.');?>");
		return false;
	}else{
		$('#ldr_pop').show();
		$('.act_btttn').hide();
		var projUniq_id = $('#proj_uniq_id').val();
		$.post(loc,{
			'user_ids':user_ids,
                'project_id': projUniq_id,
                'usr_to_remove': asgn_users_arr
		},function(res){
			if(res.status == 'nf'){
                    showTopErrSucc('error', "<?php echo __('Failed to assign user to the project.');?>");
			}else{
                    if(("rem_user_task_status" in res) && !res.rem_user_task_status.status){
                            if(trim(res.message) != ''){
					
					/* Code for Create Event tracking starts here */
					var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
					var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
					var event_name = sessionStorage.getItem('SessionStorageEventValue');
		
					if(eventRefer && event_name){
						trackEventLeadTracker(event_name, eventRefer, sessionEmail);
					}
					/* Code for Create Event tracking ends here */
					
					setTimeout(function(){
                                    showTopErrSucc('success', res.message);
					},1000);
                        }
                        $('#ldr_pop').hide();
                        $('.act_btttn').show();
                        $("#project_users").html('');
                        closePopup();
					
                        setTimeout(function() {
                            openPopup();
                            $(".ass_task_user").show();
                            $('#inner_usr_case_add').hide();
                            $('#pop_up_assign_case_user_label').hide();
                            $('.add-prj-btn').hide();
                            $('#inner_usr_case_add').html('');
                            $(".popup_bg").css({
                                "width": '850px'
                            });
                            $(".popup_form").css({
                                "margin-top": "6px"
                            });
                            $('#inner_usr_case_add').hide();
                            let resp = {};
                            resp['users'] = res.rem_user_task_status['users'];
                            resp['project_id'] = res.rem_user_task_status.project_id;
                            $.ajax({
                                url: `${HTTP_ROOT}projects/ajaxGetProjUsers`,
                                type: 'POST',
                                dataType: 'html',
                                data: {user_data:resp,page:'manage_as_users'},
                            })
                            .done(function(res_data) {
                                $(".loader_dv").hide();
                                $('#inner_usr_case_add').show();
                                $('#inner_usr_case_add').html(res_data);
                                $('#pop_up_assign_case_user_label').html('');
                                $('#pop_up_assign_case_user_label').html($('#hid_ext_use_lbl').html());
                                $('#pop_up_assign_case_user_label').css('display', 'block');
                                $('.add-prj-btn').show();
                                $.material.init();
                            });
                        }, 1000);
                    }else{
                        if (trim(res.message) != '') {
                            /* Code for Create Event tracking starts here */
                            var sessionEmail = sessionStorage.getItem('SessionStorageEmailValue');
                            var eventRefer = sessionStorage.getItem('SessionStorageReferValue');
                            var event_name = sessionStorage.getItem('SessionStorageEventValue');
                            if (eventRefer && event_name) {
                                trackEventLeadTracker(event_name, eventRefer, sessionEmail);
                            }
                            /* Code for Create Event tracking ends here */
                            setTimeout(function() {
                                showTopErrSucc('success', res.message);
                            }, 1000);
                        }
			
			setTimeout(function(){
			$('#ldr_pop').hide();
			$('.act_btttn').show();
			var sequency = ["project_users"];
			$("#project_users").html('');
                    if(CONTROLLER == 'projects' && PAGE_NAME == 'manage'){
                        window.location.reload();
                    }else{
                        loadSeqDashboardAjax(sequency, projUniq_id,'overview');
                    }
                    closePopup();
			},1000);
                    }
                }
		},'json');
	}
}
}
function asign_existing_users(obj){
    $('.nav_tab_both').removeClass('active');
    $(obj).addClass('active');
    $('#add_newconopamy_users').hide();
    $('#existing_conopamy_users').html('');
    $('#existing_conopamy_users').show();
    var PrjUid = $('#proj_uniq_id').val();
    $("#addUPLoader").show();
    $.post(HTTP_ROOT+"projects/addUsersToProject",{'projUid':PrjUid}, function(res){
        if(res) {
            $("#addUPLoader").hide();
            $('#add_user_project_resp').show();
            $('#add_user_project_resp').html(res);
            var checked_cnt = $('#existing_conopamy_users').find('.add_user_chk:checked').length;
            $('.add_user_chk:checked').each(function(){
                asgnd_usr_arr.push($(this).val());
            });
            var usr = checked_cnt > 1 ? _("users have"):_("user has");
            $('#asgnd_usr_cnt').html("<b>"+checked_cnt+"</b> "+usr+" "+_("been assigned")+".");
            $('.act_btttn').show();
            /*$('span[rel=tooltip]').tipsy({
            gravity:'s',
            fade:true
            });*/
            $('.custom_scroll').jScrollPane({autoReinitialise: true});	
            $.material.init();
        }
    });
}
function invite_asign_users(obj){
    $('#puser_add_error').html('&nbsp;');
    $('.nav_tab_both').removeClass('active');
    $(obj).addClass('active');
    $('.act_btttn').hide();

    $('.addMember_popup').html('Invite');
    $('.project_to_be_assn').hide();

    $('#add_newconopamy_users').show();
    $('#existing_conopamy_users').hide();
    $('#asgnd_usr_cnt').hide();
    //$(".add_prj_usr").hide();
    //setting default form field value
    //$('#txt_email').css('height','60px');
    $('#txt_email').val('');
    $('.auto_tab_fld').html('<select name="data[User][pid]" id="sel_custprj" class="form-control"></select>');
    $('#sel_Typ').val(3);
	
    $("#txt_email").focus();
    $('.auto_tab_fld').html('<input type="hidden" name="data[User][pid]" class="form-control" value="'+$('#Pjid').val()+'"/><input style="width: 352px;" type"text" readonly="readonly" class="form-control" value="'+$('#Pjname').val()+'"/><a href="javascript:void(0);" onclick="changeOnInvite();" style="font-size:11px;font-weight:bold;color:#5F9AC2;">Change project</a>');	
    $('.cancel_on_invite').hide();
}
var checked_usr_cnt = <?php echo count($allProjUsers); ?>;
$(document).ready(function(){
    $('.crntly_asgnd_usrs').change(function() {
        let cur_usr_id = $(this).val();
        if (asgn_users_arr.includes(cur_usr_id)) {
            asgn_users_arr.splice(asgn_users_arr.indexOf(cur_usr_id), 1);
            return;
        }
        asgn_users_arr.push(cur_usr_id);
    });
    var assinged_usrs = '';
    $('.add_user_chk').each(function(){
        if($(this).is(':checked')){
            assinged_usrs += $(this).val()+',';
        }
    });
    $('#all_asgnd_usrs').val(trim(assinged_usrs, ','));
    $('#current_checked_users').val('');
	var totalcb=$('.add_user_chk').length;
	if(totalcb==checked_usr_cnt){
		$('.add-all-user').find('input').attr('checked','checked');
	}
    $('.add_user_chk').click(function(){
		var cur_chkd_cnt = $('#existing_conopamy_users').find('.add_user_chk:checked').size();
		if(totalcb==cur_chkd_cnt){
			$('.add-all-user').find('input').attr('checked','checked');
		}else{
			$('.add-all-user').find('input').attr('checked',false);
		}
        var cur_chkd_usr= new Array() ;
        $('.add_user_chk:checked').each(function(){
            cur_chkd_usr.push($(this).val());
        });
        if(cur_chkd_usr.length != asgnd_usr_arr.length){
            $('.act_btttn').find('.btnassignUserToPrj').removeClass('loginactive');
        }else{
            for (var i = 0; i < cur_chkd_usr.length; i++) {
                if($.inArray(cur_chkd_usr[i], asgnd_usr_arr) == -1){
                    $('.act_btttn').find('.btnassignUserToPrj').removeClass('loginactive');
                    break;
                }else{
                    $('.act_btttn').find('.btnassignUserToPrj').addClass('loginactive');
                }
            }
        }
    });
});
</script>