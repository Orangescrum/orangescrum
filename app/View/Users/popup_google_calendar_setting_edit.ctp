
        <?php echo $this->Form->create('CalendarSetting', array('url' => array('controller' => 'users', 'action' => 'popupGoogleCalendarSettingEdit'), 'autocomplete' => 'off', 'id' => 'gcalendarSetting','onsubmit'=>'return validateCalenderSetting();')); ?>
        <?php echo $this->Form->input('id',array('type'=>'hidden','value'=>$res['id']));?>
        <div class="modal-body popup-container">
             <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="hlp"><?php echo __('When a task is closed');?>?</label>
                <?php echo $this->Form->input('removeCmpl',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select_cal form-control floating-label",'placeholder'=>__("Set event duration",true),'options'=>$removeCmpl,'value'=>$res['removeCmpl']));?>
            </div> 
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="js_captcha"><?php echo __('Tasks without a due date');?> <span id="showcaptcha"></span></label>
                <?php echo $this->Form->input('due_time',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select_cal form-control floating-label",'placeholder'=>__("Tasks without a due date",true),'options'=>$noDueDate,'value'=>$res['due_time']));?>
                <div class="error" for="type" generated="true" id="cpt_err"></div>
                <p class="help-block">(<?php echo __("Help us to make sure you're not a robot");?>.)</p>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="calendarSetting_loader" class="fr" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/></span>
                <span id="calendarSetting_btn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn-sm reset_btn" data-dismiss="modal" onclick="popup_close();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><button type="submit" value="Submit"  id="submit" class="btn btn-sm btn-raised btn_cmn_efect cmn_bg btn-info loginactive1"><?php echo __('Update');?></button></span>
                </span>
                <div class="cb"></div>
            </div>
        </div>
        <?php echo $this->Form->end(); ?>
        <script>
            function validateCalenderSetting(){
                $("#calendarSetting_btn").hide();
                $("#calendarSetting_loader").show();
            }
            $(document).ready(function(){
                $('.select_cal').select2();
                $('#gc_calid').on('change',function(){
                    $('#gc_calname').val($(this).find('option:selected').text());
                });
                $('#gc_sync').on('change',function(){
                    if($('#gc_sync').val() ==0){
                        $('#changeLBLGC').html('<?php echo __("Tasks created on Google Calendar will go to");?>');
                    }else{
                        $('#changeLBLGC').html('<?php echo __("Pick a project");?>');
                    }
                });
            });
        </script>
    