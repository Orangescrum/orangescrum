<?php $quickEditOpen = 0;
if (! $this->request->is('ajax')) { ?>
<div id="tt_ajax_response">
<?php }else{
    $quickEditOpen = $this->request->data['quickEditOpen'];
} ?>
    <style type="text/css">
    .checkbox input[type="checkbox"]:disabled:checked + .checkbox-material .check::before, .checkbox input[type="checkbox"]:disabled:checked + .checkbox-material .check {
        border-color: #639fed !important;
        color: #639fed !important;
    }
</style>
<div class="user_profile_con task_type_disn tasktype-sett-page setting_wrapper setting_label_page">

<?php if (isset($task_types) && !empty($task_types)) {?>
    <div class="row">
			<div class="impexp_div">
					<div class="col-lg-9">
							<div class="tsk-typ-txt">
									<?php echo __('14 default Task Types listed and the #of Tasks associated with them. You can remove any of them by unchecking the checkbox and save the changes');?>.<br/><?php echo __('Click on the');?> "<b>+ <?php echo __('New Task Type');?></b>" <?php echo __('and add your new Task Types');?>.
							</div>
					</div>
					<div class="col-lg-3 text-right">
						 <button id="tour_new_task_type" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="addNewTaskType();">+ <?php echo __('New Task Type');?></button> 
					</div>
			</div>
    </div>
<?php /* ?>
    <div class="row">
        <div class="col-lg-12 tsk-typ-quick-add-btn mbtm15 mtop15" <?php if($quickEditOpen){ ?>style="display:none;"<?php }else{?> style="display:block;" <?php } ?>> 
            <div class="new_qktask_mc">                                   
                <div class="new_grp_tsk">
                    <a href="javascript:void(0)" class="cmn-bxs-btn" onclick="displayQuickTtype();" style="font-size: 14px;" id="tour_new_task_type">
                        <i class="material-icons">add</i><?php echo __("New Task Type");?>
                    </a>
                </div>                               
        </div>
        </div>
        <div class="col-lg-12 tsk-typ-quick-add-div mbtm15 mtop15" <?php if($quickEditOpen){ ?>style="display:block;" <?php } else{ ?>style="display:none;"<?php } ?>>                        
                 <form name="task_type" id="customTaskTypeForm" method="post" action="<?php echo HTTP_ROOT;?>projects/addNewTaskType" autocomplete="off">
                    <div class="col-lg-2 form-group label-floating is-empty padlft-non">
                        <label class="control-label" for="task_type_nm">Specify task type name</label>
                        <input type="text" value="" class="form-control" name="data[Type][name]" id="task_type_nm" placeholder="" maxlength="20">
                        <input type="hidden" class="form-control" name="data[Type][id]" id="new-typeid">
                    </div>
                    <div class="col-lg-2 form-group label-floating is-empty padlft-non">
                        <label class="control-label" for="task_type_shnm">Give a short name for task type</label>
                        <input type="text" value="" class="form-control" name="data[Type][short_name]" id="task_type_shnm" placeholder="" maxlength="4">
                    </div>
                    <div class="quick_tsksave_cancel">
                        <div class="btn-group save_exit_btn">        
                            <a href="javascript:void(0)" class="btn btn-primary btn-raised" onclick="validateTaskType();" id="newtask_btn_new"><?php echo __("Save");?></a>
                             <span class="dropdown">          
                                <a href="javascript:void(0);" data-target="#" class="btn btn-primary btn-raised dropdown-toggle crtaskmoreoptn" data-toggle="dropdown"><span class="caret"></span></a>          
                                <ul class="dropdown-menu crtskmenus">           
                                    <li><a href="javascript:void(0);" onclick="validateTaskType('continue')" id="newtask_btn_c_new"><?php echo __("Save");?> &amp; <?php echo __("Continue");?></a></li>
                                </ul>         
                            </span>        
                        </div>
                        <span class="ds_ib_btn">          
                            <a href="javascript:void(0);" onclick="hideQuickTtype();">Cancel</a>
                        </span>
                    </div>
                    <span id="ttloader" style="display:none;">
                        <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
                    </span>
                </form>            
                 
                <div class="cb"></div>
        </div>
    </div>
    <?php */ ?>
    <div class="row">
        <div class="col-lg-12 tsk-typ-div import-csv-file mtop20">
            <form name="task_types" id="task_types" method="post" action="javascript:void(0);">
    <?php 
    $cnt = 1;
    $custom = 0;
    $default = 0;
    $t_key = 0;
    foreach ($task_types as $key => $value) {
	$t_key = $key+1;
	if ($cnt%4 == 0) {
	    $cb = '<div class="cb"></div>';
	} else {
	    $cb = "";
	}
	
	$checked = 'checked="checked"';
	if (isset($sel_types) && !empty($sel_types)) {
	    if (intval($value['Type']['is_exist'])) {
		$checked = 'checked="checked"';
	    } else {
		$checked = '';
	    }
	}
	if (intval($value['Total']['cnt'])) {
	    //$disabled = 'disabled="true"';
	    $isDelete = 0;
	} else {
	    $isDelete = 1;
	    //$disabled = '';
	}
	?>
                                   
	<?php if($value['Type']['company_id'] == 0 && !$default){ $default = 1;?>
                    <div class="setting_title mbtm15"><h3><?php echo __('Default Task Type');?></h3></div>
                    <div class="dflt_tt_wrapp">
	<?php }else if($value['Type']['company_id'] != 0 && !$custom){ $custom = 1;?>
                <div class="cb"></div>
                <div class="setting_title"><h3><?php echo __('Custom Level Task Type');?></h3></div>
                <h4><?php echo __('Company Level Task Type');?></h4>
                <div class="cstm_tt_wrapp">
    <?php } ?>
                        <div id="dv_tsk_<?php echo $value['Type']['id'];?>" class="checkbox custom-checkbox add-user-pro-chk <?php echo  (!empty($value['Type']['is_default'])&& !empty($checked)) ? "disabled" : ''; ?>">
                            <label class="dv_tsktyp" data-id="<?php echo $value['Type']['id'];?>" id="checkIdDisbaled<?php echo $value['Type']['id']; ?>" <?php echo  (!empty($value['Type']['is_default'])&& !empty($checked)) ? "style=cursor:not-allowed" : ''; ?>>
                                <input type="checkbox" <?php echo  (!empty($value['Type']['is_default'])&& !empty($checked)) ? "disabled" : ''; ?> class="all_tt" value="<?php echo $value['Type']['id'];?>" name="data[Type][<?php echo $value['Type']['id'];?>]" <?php echo $checked;?> <?php echo $disabled;?>/>
                                <span class="ellipsis-view tsk-typ-nm" rel="tooltip" title="<?php echo $value['Type']['name'];?>"><?php echo $value['Type']['name'];?></span> &nbsp;(<?php echo $value['Type']['short_name'];?>)
<?php if (intval($value['Total']['cnt'])) {?>
                                <span class="task-type-cnt" title="<?php echo $value['Total']['cnt']." Task(s)";?>"><?php echo $value['Total']['cnt'];?></span>
		<?php }?>
		<?php if (intval($value['Type']['company_id'])){ ?>
                                <span id="edit_dvtsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                    <span id="edit_lding_tsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..." />
                                    </span>
                                                <span id="edit_tsk_<?php echo $value['Type']['id']; ?>">
                                                    <a href="javascript:void(0);" class="custom-t-type" onclick="editTaskType(this);" data-name="<?php echo $value['Type']['name']; ?>" data-id="<?php echo $value['Type']['id']; ?>" data-sortname="<?php echo $value['Type']['short_name']; ?>">
                                                        <i class="material-icons" title="Edit" id="edit_tsk_id<?php echo $value['Type']['id']; ?>">&#xE254;</i>
                                        </a>
                                    </span>
                                </span>
		<?php } ?>
		<?php if (intval($value['Type']['company_id']) && $isDelete){ ?>
                                <span id="del_dvtsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                    <span id="lding_tsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..." />
                                    </span>
                                                <span id="del_tsk_<?php echo $value['Type']['id']; ?>">
                                                    <a href="javascript:void(0);" class="custom-t-type" onclick="deleteTaskType(this);" data-name="<?php echo $value['Type']['name']; ?>" data-id="<?php echo $value['Type']['id']; ?>">
                                                        <i class="material-icons" title="Delete" id="del_tsk_id<?php echo $value['Type']['id']; ?>">&#xE872;</i>
                                        </a>
                                    </span>
                                </span>
		<?php } ?>
                            </label>
                        </div>
	<?php if((intval($task_types[$t_key]['Type']['company_id']) != 0) && ($custom == 0)){ $cnt = 0; ?>
										<div class="cb"></div>
                    </div>
	<?php } else if($key == (count($task_types)-1)){ ?>
	<?php } ?>
    <?php 
	$cnt++;
    }
    ?>
		<div class="cb"></div>
                </div>
                <?php /* ?>
                <div class="cb"></div>
                <div class="import_btn_div text-right">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..."  id="loader_img_tt" style="display: none;position: absolute;"/>
                    <button type="button" id="tt_save_btn" name="tt_save_btn" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="return saveTaskType();">
                        <span><?php echo __('Save');?></span>
                    </button>
                </div>  <?php */ ?>
                <div class="cb"></div>
            </form>
        </div><div class="cb"></div>
        </div>
<?php } ?> 

<?php if (isset($task_types_custom) && !empty($task_types_custom)) {?>
    <div class="row">
        <div class="col-lg-12 tsk-typ-div import-csv-file project_label_grid">
            <h4><?php echo __('Project Level Task Type');?></h4>
                <div class="cstm_tt_wrapp">                   
             <?php $cnt = 1; 
             foreach ($task_types_custom as $k => $val) {
                 if ($cnt%2 == 0) {
                    $cb = '<div class="cb"></div>';
                } else {
                    $cb = "";
                } ?>
                <div class="col-lg-6">
									<div class="light_bg">
                    <h5><?php echo $val[0]['Project']['name']; ?></h5>
    <?php foreach($val as $key=>$value){    
    $checked = 'checked="checked"';
    if (isset($sel_types) && !empty($sel_types)) {
        if (intval($value['Type']['is_exist'])) {
        $checked = 'checked="checked"';
        } else {
        $checked = '';
        }
    }
    if (intval($value['Total']['cnt'])) {
        $isDelete = 0;
    } else {
        $isDelete = 1;
    }
    ?>


           
        
                        <div id="dv_tsk_<?php echo $value['Type']['id'];?>" class="checkbox custom-checkbox add-user-pro-chk project_level_type <?php echo  (!empty($value['Type']['is_default'])&& !empty($checked)) ? "disabled" : ''; ?>">
                            <label class="dv_tsktyp" data-id="<?php echo $value['Type']['id'];?>" id="checkIdDisbaled<?php echo $value['Type']['id']; ?>" <?php echo  (!empty($value['Type']['is_default'])&& !empty($checked)) ? "style=cursor:not-allowed" : ''; ?>>
                                <input type="checkbox" <?php echo  (!empty($value['Type']['is_default'])&& !empty($checked)) ? "disabled" : ''; ?> class="all_tt" value="<?php echo $value['Type']['id'];?>" name="data[Type][<?php echo $value['Type']['id'];?>]" <?php echo $checked;?> <?php echo $disabled;?>/>
                                <span class="ellipsis-view tsk-typ-nm" rel="tooltip" title="<?php echo $value['Type']['name'];?>"><?php echo $value['Type']['name'];?></span> &nbsp;(<?php echo $value['Type']['short_name'];?>)
<?php if (intval($value['Total']['cnt'])) {?>
                                <span class="task-type-cnt" title="<?php echo $value['Total']['cnt']." Task(s)";?>"><?php echo $value['Total']['cnt'];?></span>
        <?php }?>
        <?php if (intval($value['Type']['company_id'])){ ?>
                                <span id="edit_dvtsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                    <span id="edit_lding_tsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..." />
                                    </span>
                                                <span id="edit_tsk_<?php echo $value['Type']['id']; ?>">
                                                    <a href="javascript:void(0);" class="custom-t-type" onclick="editTaskType(this);" data-name="<?php echo $value['Type']['name']; ?>" data-id="<?php echo $value['Type']['id']; ?>" data-sortname="<?php echo $value['Type']['short_name']; ?>">
                                                        <i class="material-icons" title="Edit" id="edit_tsk_id<?php echo $value['Type']['id']; ?>">&#xE254;</i>
                                        </a>
                                    </span>
                                </span>
        <?php } ?>
        <?php if (intval($value['Type']['company_id']) && $isDelete){ ?>
                                <span id="del_dvtsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                    <span id="lding_tsk_<?php echo $value['Type']['id'];?>" style="display: none;">
                                        <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..." />
                                    </span>
                                                <span id="del_tsk_<?php echo $value['Type']['id']; ?>">
                                                    <a href="javascript:void(0);" class="custom-t-type" onclick="deleteTaskType(this);" data-name="<?php echo $value['Type']['name']; ?>" data-id="<?php echo $value['Type']['id']; ?>">
                                                        <i class="material-icons" title="Delete" id="del_tsk_id<?php echo $value['Type']['id']; ?>">&#xE872;</i>
                                        </a>
                                    </span>
                                </span>
        <?php } ?>
                            </label>
                        </div>   
    <?php } ?>
		<div class="cb"></div>
		</div>
    </div>
   <?php  echo $cb;$cnt++; } ?>

        </div>
    </div>

<?php } ?>


<?php if(empty($task_types) && empty($task_types_custom)){?>
        <div class="row impexp_div">
            <div class="col-lg-7  padlft-non padrht-non">
                <div class="tsk-typ-txt">
                    <?php echo __('Task Types are independent of Projects, but please create a Project to get started.');?>
                </div>
            </div>
            <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
            <div class="col-lg-5 text-right padlft-non padrht-non">
                <button class="btn btn-sm btn_cmn_efect cmn_bg btn-info" onclick="setSessionStorage('Task Type Page No Project', 'Create Project');newProject();"><?php echo __('Create Project');?></button>
            </div>
        <?php } ?>
        </div>
<?php	
}
?>
    
</div>
<script type="text/javascript">
    $(document).ready(function () {
				if(localStorage.getItem("tour_type") == '1'){			
					if(typeof hopscotch !='undefined'){
						GBl_tour = onbd_tour_project<?php echo LANG_PREFIX;?>;
						var stat = hopscotch.getState().split(':');	
						//setTimeout(function() {
							hopscotch.startTour(GBl_tour);
						//},500);
					}
				}
        $.material.init();
        $('.dv_tsktyp').hover(function () {
            var tid = $(this).attr('data-id');
            if ($(this).find("#del_dvtsk_" + tid).length || $(this).find("#edit_dvtsk_" + tid).length) {
                $(this).find("#del_dvtsk_" + tid).show();
                $(this).find("#edit_dvtsk_" + tid).show();
            }
        }, function () {
            var tid = $(this).attr('data-id');
            if ($(this).find("#del_dvtsk_" + tid).length || $(this).find("#edit_dvtsk_" + tid).length) {
                $(this).find("#del_dvtsk_" + tid).hide();
                $(this).find("#edit_dvtsk_" + tid).hide();
            }
        });
        /* check/uncheck all default task type */
        $("#all_default_task_type").change(function(){
            if(this.checked){ 
              $(".dflt_tt_wrapp").find(".all_tt").not("[disabled]").each(function(){
                this.checked=true;
              })              
            }else{
              $(".dflt_tt_wrapp").find(".all_tt").not("[disabled]").each(function(){
                this.checked=false;
              })              
            }
          }); 
        $("#all_custom_task_type").change(function(){
            if(this.checked){ 
              $(".cstm_tt_wrapp").find(".all_tt").not("[disabled]").each(function(){
                this.checked=true;
              })              
            }else{
              $(".cstm_tt_wrapp").find(".all_tt").not("[disabled]").each(function(){
                this.checked=false;
              })              
            }
          });

         $(".dflt_tt_wrapp").find(".all_tt").not("[disabled]").click(function () {
            if ($(this).is(":checked")){
             checkAllTT('default');
            }else{
              $("#all_default_task_type").prop("checked", false);  
            }
          });
         $(".cstm_tt_wrapp").find(".all_tt").not("[disabled]").click(function () {
            if ($(this).is(":checked")){
             checkAllTT('custom');
            }else{
              $("#all_custom_task_type").prop("checked", false);  
            }
          });
        checkAllTT('default');
        checkAllTT('custom');
        /* end */ 
        $(document).on('keyup','#task_type_nm',function(){
            if($(this).closest('.verror').length){
               $('#tterr_msg').html(''); 
               $("#task_type_nm").closest('.field_wrapper').removeClass('verror');
            }
        });
       $(document).on('keyup','#task_type_shnm',function(){
            if($(this).closest('.verror').length){
               $('#tterr_msg').html(''); 
               $("#task_type_shnm").closest('.field_wrapper').removeClass('verror');
            }
        }); 
       $(document).on('keyup','#task_type_nm_edit',function(){
            if($(this).closest('.verror').length){
               $('#tterr_msg_edit').html(''); 
               $("#task_type_nm_edit").closest('.field_wrapper').removeClass('verror');
            }
        });
       $(document).on('keyup','#task_type_shnm_edit',function(){
            if($(this).closest('.verror').length){
               $('#tterr_msg_edit').html(''); 
               $("#task_type_shnm_edit").closest('.field_wrapper').removeClass('verror');
            }
        });
    });
    $(document).on('change','.all_tt', function(e){
        var id = $(this).val();
        var is_active = ($(this).is(':checked'))?1:0;
        $.post(HTTP_ROOT + "projects/saveTaskType",{id:id,is_active:is_active},function(res){
            if(res.status==1){
               // showTopErrSucc('success', '<?php echo __("Task type can not update now. Please try again later.");?>.'); 
            }else{
              showTopErrSucc('error', '<?php echo __("Task type can not update now. Please try again later.");?>.');  
            }
        },'json');
    })
    $(document).on('click', '[id^="checkIdDisbaled"]', function (e) {
        var typeId = $(this).attr('data-id');
        if ($(e.target).is('#edit_tsk_id' + typeId)) {
            e.preventDefault();
            //your logic for the button comes here
        } else if ($(e.target).is('#del_tsk_id' + typeId)) {
            e.preventDefault();
        } else {
        var checkDisable = $(this).find(':checkbox.all_tt').attr('disabled');
        if (checkDisable == 'disabled') {
            $.post(HTTP_ROOT + "projects/checkTaskType", {'typeId': typeId}, function (res) {
                    var msg = "<?php echo __("Sorry, You can't uncheck the task type because it has been used as default task type in the list of project(s)");?> - " + res;
                    showTopErrSucc('error', msg,1);
            });
        }
        }
    });
    function checkAllTT(typ){
        var cb_id = (typ=='default')?'all_default_task_type':'all_custom_task_type';
        var cb_class = (typ=='default')?'dflt_tt_wrapp':'cstm_tt_wrapp';
        var isAllChecked = 0;
         $("."+cb_class).find(".all_tt").each(function(){
            if(!this.checked)
               isAllChecked = 1;
          })             
          if(isAllChecked == 0){ 
            $("#"+cb_id).prop("checked", true);     
        }else {
              $("#"+cb_id).prop("checked", false);
            }
    }
    // function displayQuickTtype(){
    //     $(".tsk-typ-quick-add-btn").hide();
    //     $(".tsk-typ-quick-add-div").show();
				// 				$('#task_type_nm').focus();
    // }
    // function hideQuickTtype(){
    //     $(".tsk-typ-quick-add-div").hide();
    //     $(".tsk-typ-quick-add-btn").show();
    //     $("#customTaskTypeForm")[0].reset();
    //     $('#newtask_btn_new').text(_('Save'));
    //     $('#newtask_btn_c_new').text(_('Save & Continue'));
    // }
</script>
<?php if (! $this->request->is('ajax')) { ?>
</div>
<?php } ?>