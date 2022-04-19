<?php  echo $this->Form->create('Project',array('url'=>'/projects/add_project','id'=>'projectadd_onboard')); ?>
<div class="modal-body popup-container">
<center><div id="err_msg_onboard" style="color:#FF0000;display:none;"></div></center>
    <div class="data-scroll">
    <table cellpadding="0" cellspacing="0" class="col-lg-10" style="width:100%; margin-top:20px;">
	<tr>
	    <td class="popup_label"></td>
	    <td>
                <div class="form-group label-floating">
                <label class="control-label" for="txt_Proj"><?php echo __('Specify your project name');?></label>
		<?php echo $this->Form->text('name',array('value'=>'','class'=>'form-control','id'=>'txt_Proj_onboard','maxlength'=>'50','autocomplete'=>'off','style'=>'font-weight:bold;')); ?>
                </div>
                <?php echo $this->Form->text('short_name', array('value' => '', 'class' => 'form-control ttu', 'id' => 'txt_shortProj_onboard','placeholder'=>"MP",'maxlength'=>'5','style'=>'display:none;')); ?>
		
	    </td>
	</tr>
        <tr><td colspan="2"><h4 style="font-size:19px; position:relative; top:-20px;"><?php echo __('Select your preferred layout');?></h4></td></tr>
         <tr>
            <td class="popup_label"></td>
	    <td>
        <div class="form-group custom-drop-lebel cmn-popup dflt-drpdwn">
            <?php echo $this->Form->select('projectview', $project_views, array('value' => $projectview, 'class' => 'select form-control floating-label ', 'placeholder' => 'Show my projects in', 'data-dynamic-opts' => 'true','id'=>'default_project' ,'empty' => false)); ?>
        </div>
            </td>
        </tr>
         <tr>
            <td class="popup_label"></td>
	    <td>
        <div class="form-group custom-drop-lebel cmn-popup dflt-drpdwn">
            <?php echo $this->Form->select('defaulttaskview', $def_views, array('value' => $defviews, 'class' => 'select form-control floating-label ', 'placeholder' => __('Show my tasks in',true), 'data-dynamic-opts' => 'true','id'=>'default_tasklist' ,'empty' => false)); ?>
            <?php echo $this->Form->input('taskviews', array('value' => $taskview,'type'=>'hidden', 'id'=>'default_task')); ?>        
            <?php echo $this->Form->input('kanbanview', array('value' => $kanbanview,'type'=>'hidden', 'id'=>'default_kanban')); ?>        
        </div>
            </td>
        </tr>
    </table>    
    </div>
</div>
<div class="modal-footer popup-footer">
    <div style="padding-left:61px;">
            <input type="hidden" name="data[Project][validate]" id="validate_onboard" readonly="true" value="0"/>
            <span id="loader_onboard" style="display:none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
            </span>
            <span id="btn_onboard">
                <button type="button" value="Create" name="crtProject" id="crtProject" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive" onclick="return projectOnboardAdd('txt_Proj_onboard','txt_shortProj_onboard','loader_onboard','btn_onboard');"><i class="icon-big-tick"></i><?php echo __('Create Project');?></button>
            </span>
    </div>
</div>
<?php echo $this->Form->end(); ?>
<script>
    $(function() {
        $('#txt_Proj_onboard')
                .keyup(function(e){
                    $(this).val().trim()!=''?$("#crtProject").removeClass('loginactive'):$("#crtProject").addClass('loginactive');
                    $('#err_msg').html('');
                    
                    var str = $(this).val();
                    var str_temp = '';
                    if (e.keyCode == 32 || e.keyCode == 8 || e.keyCode == 46) {
                        makeShortName(str, 0);
                    }
                })
                .change(function(){
                    $(this).val().trim()!=''?$("#crtProject").removeClass('loginactive'):$("#crtProject").addClass('loginactive');
                    $('#err_msg').html('');
                })
                .blur(function(e) {
                    var str = $(this).val();makeShortName(str);
                });
    });
    function makeShortName(str) {
        var str_temp = '';
        str = str.trim();
        str_temp = str;
        if (str != '') {
            if ($('#txt_shortProj_onboard').val().trim().length >= 5) {
                return true;
            }
            if ($('#short_nm_prj_new').val() == 1) {
                if ($('#txt_Proj_onboard').length) {
                    $('#txt_shortProj_onboard').val(chr);
                } else {
                    $('#txt_shortProj').keyup();
                }
                return true;
            }
            str = str.replace(/\s{2,}/g, ' ');
            var spltStr = str.split(' ');
            var chr = '';
            var inValid = /[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$�\^\+\"\';:,`\s]+/;
            if (spltStr.length >= 2) {
                $.each(spltStr, function(index, value) {
                    var t_chr = value.substr(0, 1);
                    var t_test = inValid.test(t_chr);
                    if (!t_test) {
                        chr += t_chr;
                    } else {
                        var t_chr = value.substr(1, 1);
                        var t_test = inValid.test(t_chr);
                        if (!t_test) {
                            chr += t_chr;
                        }
                    }
                });
            } else {
                var t_chr = str.substr(0, 1);
                var t_test = inValid.test(t_chr);
                if (!t_test) {
                    chr = t_chr;
                } else {
                    var t_chr = str.substr(1, 1);
                    var t_test = inValid.test(t_chr);
                    if (!t_test) {
                        chr = t_chr;
                    }
                }
            }
            chr = chr.toUpperCase();
            if ($('#txt_Proj_onboard').length) {
                $('#txt_shortProj_onboard').val(chr);
            } else {
                $('#txt_shortProj').val(chr).keydown();
            }
        } else {
            $('#short_nm_prj_new').val(0);
            if ($('#txt_Proj_onboard').length) {
                $('#txt_shortProj_onboard').val('');
                $('#txt_shortProj_onboard').attr('placeholder', 'MP');
            } else {
                $('#txt_shortProj').val('');
            }
        }
    }
</script>
