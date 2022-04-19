<style>
.value {display:none;}
.add_new_cls:hover {color:#2d6dc4;}
.dropdownjs ul li:last-child:hover, .custom-list-drop #sample a.hover_link_colr:hover {
  color: #2d6dc4;
}
</style>
<?php if (isset($proj) && $proj == 'proj') { ?>
<div class="select2__wrapper">
    <select name="new_template" id="new_template_crt"   class="form-control floating-label new_template_crt" placeholder="<?php echo __('Choose a project plan');?>"> <!--onchange="check(this.value);"--> 
        <option value="0"><?php echo __('Select Project Plan');?></option>
        <?php foreach ($templates as $k => $template) { ?>
            <option value="<?php echo $k; ?>" <?php if (isset($tempid) && $tempid == $k) { ?> selected="selected" <?php } ?>><?php echo ucwords($template); ?></option>
        <?php } ?>
        <?php /*if (SES_TYPE != 3) { ?>
            <option value="0" class="add_new_cls">+ <?php echo __('Add New Template');?></option>
        <?php } */ ?>
    </select>
</div>
	<div class="cmn_help_select"></div>
<a href="javascript:void(0);" class="onboard_help_anchor all-proj-task" onclick="openHelpWindow('https://helpdesk.orangescrum.com/cloud/what-is-project-template-how-it-helps-you/<?= HELPDESK_URL_PARAM ?>#project_template');" title="<?php echo __('Get quick help on Project Plan');?>" rel="tooltip" ><span class="help-icon"></span></a>
<?php } else { ?>
    <div class="modal-body popup-container">
        <div class="user_pdt">
            <div class="reply_task_block_info">
                            <p class="m_0"><img class="idea_icon" alt="" src="<?php echo HTTP_ROOT; ?>img/idea-ico.png"><?php echo __('Create a new project plan out of the selected tasks or add selected tasks to an existing project plan');?>.</p>
            </div>
            <div class="row mtop30">
                    <div class="col-lg-12 custom-list-drop">
                        <div id="sample" class="dropdown option-toggle p-6 fl wid">
                            <div class="opt1 opt50" id="opt50">
                                <a href="javascript:jsVoid()" class="ttfont" onclick="open_more_opt('more_opt50');">
                                    <span id="sel_tmpl_nm"><span class="value"></span><?php echo __('Select Project Plan');?></span>
                                    <i class="caret mtop-10 fr"></i>
                                </a>
                            </div>
                            <div id="more_opt50" class="more_opt">
                                <ul class="wid" style="display: none;">
                                    <?php foreach ($templates as $k => $template) { ?>
                                        <li onclick="getTmplvalue(this);"><a class="ellipsis-view" href="javascript:void(0);"  rel="tooltip" title="<?php echo ucwords($template); ?>">
                                                <span class="value"><?php echo $k; ?></span><?php echo ucwords($template); ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                    
								<li id="last">
									<div><a class="hover_link_colr link-text" href="javascript:void(0);" onclick="createNewTemplate()">+ <?php echo __('Add New Project Plan');?></a>
									</div>
                                </li>
                                </ul>
                            </div>
                        </div>
                        <input type="hidden" id="hid_tmpl" value="" />
                        <div id="errcp_msg_dv" class="exist-prj exit-pro-txt"><?php echo __('Already in this Project');?>.</div>
                    </div>
            </div>
        </div>
    </div>
    <div class="modal-footer ">
        <div class="fr popup-btn">
            <span id="crtprjtmplloader" class="mvprjlder" style="display: none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
            </span>
            <div id="crtprjtmpl_btn">
            <input type="hidden" id="project_id" value="<?php echo $projectId; ?>" />
                <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="tmpl-btn" onclick="CreateTemplate();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Create');?></a></span>
                <div class="cb"></div>
            </div>
        </div>
				<div class="cb"></div>
    </div>
<?php } ?>
<script>
    function check(id) {
//        var id = $('#new_template_crt').val();
        if (id == 0) {
            $('.crt_project_tmpl').hide();
            $('.new_project').hide();
            createNewTemplate();
        } else {
            $("#projtemptitle").val('');
            $("#projtemptitle").focus();
            $("#project_temp_err").html('');
            $(".project_temp_popup").hide();
        }
    }
    var new_tmpl = '';
    function createNewTemplate() {
        $('.crt_project_tmpl').hide();
        $('.new_project').hide();
        openPopup();
        new_tmpl = 1;
        $("#projtemptitle").val('').keyup();
        $("#projtemptitle").focus();
        $("#project_temp_err").html('');
        $(".project_temp_popup").show();
    }
    function CreateTemplate() {
        var temp_id = $("#hid_tmpl").val();
        var selected_task = $('input[name="selectedTask"]:checked').val();
        var project_id = $('#project_id').val();
        if (temp_id != 0) {
            if ($('#projFil').val() !== 'all') {
                var cbval = '';
                var case_id = new Array();
                var spval = '';
                var case_no = new Array();
                $('input[id^="actionChk"]').each(function(i) {
                    if ($(this).is(":checked") && !($(this).is(":disabled"))) {
                        cbval = $(this).val();
                        spval = cbval.split('|');
                        case_id.push(spval[0]);
                        case_no.push(spval[1]);
                    }
                });
            } else {
                return false;
            }
            if (1) {
                $("#crtprjtmpl_btn").hide();
                $("#crtprjtmplloader").show();
                $.post(HTTP_ROOT + "templates/createProjectTemplateFromTasks", {"temp_id": temp_id, "case_id": case_id,"selected_task":selected_task,'project_id':project_id}, function(res) {
                    closePopup();
                    if (res.msg == 'success') {
                        showTopErrSucc('success', '<?php echo __('Project Plan updated successfully');?>');
                        document.location.href = HTTP_ROOT + "templates/projects";
                    } else {
                        showTopErrSucc('error', "<?php echo __('Unable to update project plan');?>.");
                        return false;
                    }
                }, 'json');
            } else {
                return false;
            }
        } else {
            showTopErrSucc('error', "<?php echo __('Please select one project plan');?>.");
            return false;
        }
    }
</script>