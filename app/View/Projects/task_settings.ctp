<div class="user_profile_con setting_wrapper task_listing thwidth">
    <?php echo $this->Form->create('TaskSetting', array('url' => '/projects/task_settings', 'onsubmit'=>'return validateTaskSettings()')); ?>
    <div class="row inv-sett-section task-sett-section">
        <div class="col-lg-12 padlft-non">
            <div class="col-lg-6 padlft-non">
                <div class="col-lg-4 padlft-non task-set-edit-txt"><?php echo __('Who can edit task');?>?</div>
                <div class="col-lg-8 padlft-non">
                    <div class="create_priority form group">
                        <span class="radio radio-primary custom-rdo">
                            <label>
                                <input type="radio" name="data[TaskSetting][edit_task]" id="edit_all" value="1" style="cursor:pointer;" class="chk_fl" onClick="selectOne(this)" <?php if(empty($task_settings) || $task_settings['TaskSetting']['edit_task'] == 1){ ?>checked="checked"<?php } ?> />
                                <?php echo __('All Users');?>
                            </label>
                        </span>
                        <span class="radio radio-primary custom-rdo">
                            <label>
                                <input type="radio" name="data[TaskSetting][edit_task]" id="edit_ownad" value="2" style="cursor:pointer;" class="chk_fl" onClick="selectOne(this)" <?php if(!empty($task_settings) && $task_settings['TaskSetting']['edit_task'] == 2){ ?>checked="checked"<?php } ?> />
                                <?php echo __('Owner and Admin');?>
                            </label>
                        </span>
                        <?php /* <span class="radio radio-primary custom-rdo">
                            <label>
                                <input type="radio" name="data[TaskSetting][edit_task]" id="edit_taskown" value="3" style="cursor:pointer;" class="chk_fl" onClick="selectOne(this)" <?php if(!empty($task_settings) && $task_settings['TaskSetting']['edit_task'] == 3){ ?>checked="checked"<?php } ?> />
                                Task Owner
                            </label>
                        </span> */ ?>
                        <input type="hidden" name="data[TaskSetting][hid]" id="task_setting_hid" value="<?php echo $task_settings['TaskSetting']['id']; ?>" />
                    </div>
                </div>
            </div>
            <div class="cb"></div>
            <div class="mtop20">
                <div id="task-setting-btns" class="fr">
                    <div class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" onclick="document.location.reload();"><?php echo __('Cancel');?></button></div>
                    <div class="fl hover-pop-btn btn-margin"><button type="submit" name="submit_setting" id="submit_setting" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></button></div> 
                    <div class="cb"></div>
                </div>
                <span id="task-setting-loader" style="display:none;float:right">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
                </span>
                <div class="cb"></div>
            </div>
        </div>
    </div>
    <?php echo $this->Form->end(); ?>
</div>

<script type="text/javascript">
    function selectOne(obj){
        $('.task-sett-section').find('input[type="radio"]').prop('checked', false);
        $(obj).prop('checked', true);
    }
    function validateTaskSettings(){
        var checked = $('.task-sett-section').find('input[type="radio"]:checked').length;
        if(checked){
            $('#task-setting-btns').hide();
            $('#task-setting-loader').show();
            return true;
        }else{
            showTopErrSucc('error', '<?php echo __('Plese chose at least one.');?>');
            return false;
        }
    }
</script>
