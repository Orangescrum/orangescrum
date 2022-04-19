<style type="text/css">
  .checkbox input[type="checkbox"]:disabled:checked + .checkbox-material .check::before, .checkbox input[type="checkbox"]:disabled:checked + .checkbox-material .check {border-color: #639fed !important;
      color: #639fed !important; }
</style>
<div class="user_profile_con">
	<form name="menu_data" id="menu_data" method="post" action="javascript:void(0);">
	  <div class="row">
		<div class="col-md-12 padlft-non padrht-non">
		<?php foreach ($menu_data as $key => $value) { ?>
		<?php $lower_menu_name = strtolower($value['QuicklinkMenu']['name']);?>
        <?php $menu_icon = '';
        switch ($lower_menu_name) {
            case 'new':
                $menu_icon = '<i class="material-icons">new_releases</i>';
                break;
            case 'analytics':
                $menu_icon = '<i class="material-icons">&#xE922;</i>';
                break;
            case 'others':
                $menu_icon = '<i class="material-icons">&#xE53B;</i>';
                break;
            case 'company settings':
                $menu_icon = '<i class="material-icons">&#xE8B8;</i>';
                break;
            default:
                $menu_icon = '<i class="material-icons">&#xE8B8;</i>';
                break;
        } ?>
		<?php $lang_prefix = str_replace('_', '', LANG_PREFIX); ?>
		<?php $ql_name = !empty($lang_prefix) ? $value['MenuLanguage'][$lang_prefix] : $value['QuicklinkMenu']['name'];?>
		<input type="hidden" name="data[UserQuicklink][<?php echo $value['QuicklinkMenu']['id'];?>][QuicklinkMenu][id]" value="<?php echo $value['QuicklinkMenu']['id'];?>">
		<input type="hidden" name="data[UserQuicklink][<?php echo $value['QuicklinkMenu']['id'];?>][QuicklinkMenu][user_id]" value="<?php echo SES_ID;?>">
		<input type="hidden" name="data[UserQuicklink][<?php echo $value['QuicklinkMenu']['id'];?>][QuicklinkMenu][company_id]" value="<?php echo SES_COMP;?>">
		  <div class="col-md-3">
			<div class="quick_link_card">
			  <div class="qlk_ttle"><span><?php echo $menu_icon;?></span><?php echo $ql_name;?></div>
			  <?php $menu_checked = '';
				if(!empty($value['QuicklinkMenu']['all'])){
					$menu_checked = 'checked="checked"';
				}?>
			  <div id="" class="checkbox all_none_check">
				<label class="all" data-id="">
				  <input type="checkbox" name="" data-id="<?php echo $value['QuicklinkMenu']['id'];?>" id="menu_chkbx_all_<?php echo $value['QuicklinkMenu']['id'];?>" <?php echo $menu_checked;?>>
				  <span>All/None</span>
				</label>
			  </div>
			  <div class="qlk_wrap">
				<?php foreach ($value['QuicklinkSubmenu'] as $k => $v) { ?>
				<?php $lowered_name = $v['QuicklinkSubmenu'][0]['smenu_lowered'];?>
                <?php $sub_menu_icon = '';
                    switch ($lowered_name) {
                        case 'user':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE7FB;</i>';
                            break;
                        case 'project':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE8F9;</i>';
                            break;
                        case 'task':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE862;</i>';
                            break;
                        case 'task group':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE065;</i>';
                            break;
                        case 'time entry':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE192;</i>';
                            break;
                        case 'start timer':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE425;</i>';
                            break;
                        case 'invoice':
                            $sub_menu_icon = '<i class="left-menu-icon material-icons cmn-icon-prop">&#xE53E;</i>';
                            break;
                        case 'hours spent':
                            $sub_menu_icon = '<i class="material-icons hs-icon">&#xE192;</i>';
                            break;
                        case 'task reports':
                            $sub_menu_icon = '<i class="material-icons">&#xE862;</i>';
                            break;
                        case 'weekly usage':
                            $sub_menu_icon = '<i class="material-icons">&#xE922;</i>';
                            break;
                        case 'resource utilization':
                            $sub_menu_icon = '<i class="material-icons">&#xE335;</i>';
                            break;
                        case 'resource availability':
                            $sub_menu_icon = '<i class="material-icons">&#xE7FB;</i>';
                            break;
                        case 'pending task':
                            $sub_menu_icon = '<i class="material-icons">&#xE85F;</i>';
                            break;
                        case 'weekly timesheet':
                            $sub_menu_icon = '<i class="material-icons">&#xE616;</i>';
                            break;
                        case 'daily timesheet':
                            $sub_menu_icon = '<i class="material-icons">&#xE8DF;</i>';
                            break;
                        case 'archive':
                            $sub_menu_icon = '<i class="left-menu-icon material-icons">&#xE149;</i>';
                            break;
                        case 'template':
                            $sub_menu_icon = '<i class="left-menu-icon material-icons">&#xE8F1;</i>';
                            break;
                        case 'gantt chart':
                            $sub_menu_icon = '<i class="left-menu-icon material-icons">&#xE919;</i>';
                            break;
                        case 'activities':
                            $sub_menu_icon = '<i class="material-icons">&#xE922;</i>';
                            break;
                        case 'calendar':
                            $sub_menu_icon = '<i class="material-icons">&#xE916;</i>';
                            break;
                        case 'companies':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE7FB;</i>';
                            break;
                        case 'my company':
                            $sub_menu_icon = '<i class="material-icons">&#xE0AF;</i>';
                            break;
                        case 'daily catch-up':
                            $sub_menu_icon = '<i class="material-icons">&#xE003;</i>';
                            break;
                        case 'import & export':
                            $sub_menu_icon = '<i class="material-icons">&#xE0C3;</i>';
                            break;
                        case 'task type':
                            $sub_menu_icon = '<i class="material-icons">&#xE862;</i>';
                            break;
                        case 'manage labels':
                            $sub_menu_icon = '<i class="material-icons">label</i>';
                            break;
                        case 'invoice setting':
                            $sub_menu_icon = '<i class="material-icons">&#xE53E;</i>';
                            break;
                        case 'task setting':
                            $sub_menu_icon = '<i class="material-icons">&#xE862;</i><i class="material-icons abs_set_icon">&#xE8B8;</i>';
                            break;
                        case 'resource setting':
                            $sub_menu_icon = '<i class="material-icons">&#xE7FB;</i><i class="material-icons abs_set_icon">&#xE8B8;</i>';
                            break;
												case 'status workflow setting':
                            $sub_menu_icon = '<i class="material-icons">format_color_fill</i>';
                            break;
                        case 'chat setting':
                            $sub_menu_icon = '<i class="material-icons">&#xE0B7;</i>';
                            break;
                        case 'my profile':
                            $sub_menu_icon = '<i class="material-icons cmn-icon-prop">&#xE7FB;</i>';
                            break;
                        case 'change password':
                            $sub_menu_icon = '<i class="material-icons">lock</i>';
                            break;
                        case 'notifications':
                            $sub_menu_icon = '<i class="material-icons">notification_important</i>';
                            break;
                        case 'email reports':
                            $sub_menu_icon = '<i class="material-icons">email</i>';
                            break;
                        case 'launchpad':
                            $sub_menu_icon = '<i class="material-icons">launch</i>';
                            break;
                        case 'default view':
                            $sub_menu_icon = '<i class="material-icons">view_agenda</i>';
                            break;
                        case 'getting started':
                            $sub_menu_icon = '<i class="material-icons">near_me</i>';
                            break;
                        case 'product updates':
                            $sub_menu_icon = '<i class="material-icons">system_update</i>';
                            break;
                        default:
                            $sub_menu_icon = '<i class="material-icons">live_help</i>';
                            break;
                    }
                ?>  
					<?php if($lowered_name == "user"){?>
						<?php if(SES_TYPE < 3){ ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "task group") { ?>
						<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "companies") { ?>
						<?php if(SES_COMP == 1 && SES_TYPE == 2) { ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "time entry" || $lowered_name == "start timer") { ?>
						<?php if($GLOBALS['user_subscription']['subscription_id'] != CURRENT_EXPIRED_PLAN){ ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "invoice") { ?>
						<?php if(SES_TYPE < 3){ ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "weekly usage" || $lowered_name == "resource utilization") { ?>
						<?php if(SES_TYPE == 1 || SES_TYPE == 2) { ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "resource availability") { ?>
						<?php if(SES_TYPE < 3) { ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
						)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "pending task") { ?>
						<?php if(SES_TYPE == 1 || SES_TYPE == 2) { ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "weekly timesheet" || $lowered_name == "daily timesheet") { ?>						
					<?php }elseif ($lowered_name == "template") { ?>
						<?php if($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) { ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "gantt chart") { ?>
						<?php if(SES_TYPE == 1 || SES_TYPE == 2) { ?>
							<?php #if($this->Format->isFeatureOn('gantt',$user_subscription['subscription_id'])) { ?>
								<?php echo $this->element('ql_div', array(
									"value" => $value,
									"v" => $v,
									"checked_ql" => $checked_ql,
                  "sub_menu_icon"=>$sub_menu_icon
								)); ?>
							<?php #} ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "companies") { ?>
						<?php if(SES_COMP == 1 && SES_TYPE == 2) { ?>
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "chat setting") { ?>
						<?php if(SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320){?> 
							<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
                                "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
					<?php }elseif ($lowered_name == "launchpad") { ?>
						<?php if(TOT_COMPANY >= 2) { ?>
							<?php echo $this->element('ql_div', array(
									"value" => $value,
									"v" => $v,
									"checked_ql" => $checked_ql,
                  "sub_menu_icon"=>$sub_menu_icon
							)); ?>
						<?php } ?>
                    <?php }elseif ($lowered_name == "task setting") { ?>
                            <?php echo $this->element('ql_div', array(
                                    "value" => $value,
                                    "v" => $v,
                                    "checked_ql" => $checked_ql,
                                    "sub_menu_icon"=>$sub_menu_icon,
                                    'double_icon'=>true
                            )); ?>
                    <?php }elseif ($lowered_name == "task") { ?>
                            <?php 
                                if($this->Format->isAllowed('Create Task',$roleAccess)){
                                    echo $this->element('ql_div', array(
                                        "value" => $value,
                                        "v" => $v,
                                        "checked_ql" => $checked_ql,
                                        "sub_menu_icon"=>$sub_menu_icon,
                                        'double_icon'=>true
                                ));
                                }
                             ?>
                    <?php }elseif ($lowered_name == "resource setting") { ?>
                            <?php echo $this->element('ql_div', array(
                                    "value" => $value,
                                    "v" => $v,
                                    "checked_ql" => $checked_ql,
                                    "sub_menu_icon"=>$sub_menu_icon,
                                    'double_icon'=>true
                            )); ?>
										<?php }elseif ($lowered_name == "status workflow setting") { ?>
												<?php echo $this->element('ql_div', array(
																"value" => $value,
																"v" => $v,
																"checked_ql" => $checked_ql,
																"sub_menu_icon"=>$sub_menu_icon,
																'double_icon'=>false
												)); ?>
					<?php }else{ ?>
						<?php echo $this->element('ql_div', array(
								"value" => $value,
								"v" => $v,
								"checked_ql" => $checked_ql,
								"sub_menu_icon"=>$sub_menu_icon
						)); ?>
					<?php } ?>
				<?php } ?>
			  </div>
			</div>
		  </div>
		<?php } ?>
		</div>
        <div class="cb"></div>
		<div class="col-lg-12">
			<div class="text-right mtop30">
				<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..."  id="loader_img_tt" style="display: none;"/>
                <a class="btn btn-default btn_hover_link cmn_size" id="ql_cancel_btn" onclick="history.go(-1);return false;"><?php echo __('Cancel');?></a>
				<button type="button" id="ql_save_btn" name="ql_save_btn" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="return saveQuickLinks();">
					<span><?php echo __('Save');?></span>
				</button>
			</div>
			<div class="cb"></div>
		</div>
	  </div>
	</form>
</div>
<script type="text/javascript">
var save_ql_url = '<?php echo $this->Html->url(array("controller" => "UserQuicklinks","action" => "ajax_add"));?>';
function saveQuickLinks() {
    var checked_cl = [];
    $('.semenu').each(function(index, el) {
        if ($(this).is(':checked')) {
            checked_cl.push($(this).val());
        }
    });
    if (checked_cl.length) {
        $('#ql_save_btn').hide();
        $('#ql_cancel_btn').hide();
        $('#loader_img_tt').show();
        var frm = $('#menu_data');
        var data = frm.serializeArray();
        $.ajax({
                url: save_ql_url,
                type: 'POST',
                dataType: 'json',
                data: data,
            })
            .done(function(res) {
                if (res.status) {
                    showTopErrSucc('success', res.msg, 1);
                    window.location.reload();
                }
            });
    } else {
        showTopErrSucc('error', "<?php echo __('Please select atleast one option');?>", 1);
    }
}
jQuery(document).ready(function($) {
    $('[id^=menu_chkbx_all_]').change(function() {
        var menu_id = $(this).attr('data-id');
        $(".s_menu_chkbx_" + menu_id).prop('checked', $(this).prop("checked"));
    });
    $("[class*='s_menu_chkbx_']").change(function() {
        var menu_class = $(this).attr('class');
        var parent_id = menu_class.replace(/[^\d.]/g, '');
        var total_length = $(".s_menu_chkbx_" + parent_id).length;
        var checked_length = $(".s_menu_chkbx_" + parent_id + ":checked").length;
        if (false == $(this).prop("checked")) {
            $("#menu_chkbx_all_" + parent_id).prop('checked', false);
        }
        if (checked_length == total_length) {
            $("#menu_chkbx_all_" + parent_id).prop('checked', true);
        }
    });
    var menu_ids = [];
    $("[class*='s_menu_chkbx_']").each(function(index, el) {
        var menu_class = $(this).attr('class');
        var parent_id = menu_class.replace(/[^\d.]/g, '');
        menu_ids.push(parent_id);
    });
    var filtered_menu_ids = menu_ids.filter(function(item, pos) {
        return menu_ids.indexOf(item) == pos;
    });
    $.each(filtered_menu_ids, function(index, val) {
        var total_length = $(".s_menu_chkbx_" + val).length;
        var checked_length = $(".s_menu_chkbx_" + val + ":checked").length;
        if (checked_length == total_length) {
            $("#menu_chkbx_all_" + val).prop('checked', true);
        } else {
            $("#menu_chkbx_all_" + val).prop('checked', false);
        }
    });
});
</script>
