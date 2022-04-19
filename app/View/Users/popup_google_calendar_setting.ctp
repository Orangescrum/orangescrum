
        <?php echo $this->Form->create('CalendarSetting', array('url' => array('controller' => 'users', 'action' => 'syncGoogleCalendar'), 'autocomplete' => 'off', 'id' => 'gcalendarSetting','onsubmit'=>'return validateCalenderSetting();')); ?>
        <div class="modal-body popup-container">
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="f_name"><?php echo __('Pick a calendar');?></label>
                  <?php echo $this->Form->input('calendar_id',array('type'=>'select','div'=>false,'label'=>false,'class'=>"form-control floating-label",'placeholder'=>__("Pick a calendar",true),'options'=>$allCalendar,'id'=>'gc_calid'));?>
                   <?php echo $this->Form->input('calendar_name',array('type'=>'hidden','id'=>'gc_calname' ,'value'=>reset($allCalendar)));?>
            </div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="email_id"><?php echo __('Sync project option');?></label>
                <?php echo $this->Form->input('sync',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select_cal form-control floating-label",'placeholder'=>__("Sync",true),'options'=>$sync,'id'=>'gc_sync'));?>
              
            </div>
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="mask_phone" id="changeLBLGC"><?php echo __('Select a project to Sync Events from Google Calendar');?></label>
                 <?php echo $this->Form->input('project_id',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select_cal form-control floating-label",'placeholder'=>__("Tasks created on Google Calendar will go to",true),'options'=>$compProjects));?>
                
            </div>
            <!-- <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="hlp"><?php echo __('Set event duration');?>?</label>
                <?php echo $this->Form->input('interval_time',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select_cal form-control floating-label",'placeholder'=>__("Set event duration",true),'options'=>$invertals));?>
            </div> -->
             <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="hlp"><?php echo __('When a task is closed');?>?</label>
                <?php echo $this->Form->input('removeCmpl',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select_cal form-control floating-label",'placeholder'=>__("Set event duration",true),'options'=>$removeCmpl));?>
            </div> 
            <div class="form-group form-group-lg label-floating">
                <label class="control-label" for="js_captcha"><?php echo __('Tasks without a due date');?> <span id="showcaptcha"></span></label>
                <?php echo $this->Form->input('due_time',array('type'=>'select','div'=>false,'label'=>false,'class'=>"select_cal form-control floating-label",'placeholder'=>__("Tasks without a due date",true),'options'=>$noDueDate,'value'=>1));?>
                <div class="error" for="type" generated="true" id="cpt_err"></div>
                <p class="help-block">(<?php echo __("Help us to make sure you're not a robot");?>.)</p>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="calendarSetting_loader" class="fr" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/></span>
                <span id="calendarSetting_btn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn-sm reset_btn" data-dismiss="modal" onclick="removeGoogleCalendar();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><button type="submit" value="Submit"  id="submit" class="btn btn-sm btn-raised btn_cmn_efect cmn_bg btn-info loginactive1"><?php echo __('Submit');?></button></span>
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
                $('#gc_calid').select2({
                    tags: true,
                    createTag: function(params) {
                        var term = $.trim(params.term);
                        if (term === '') {
                            return null;
                        }
                        if (term.match(/[/:-?{~"^`'\[\]<>]+/)) {
                            var msg = "'Calendar' must not contain Special characters!";
                            showTopErrSucc('error', msg);
                            return null;
                        }
                        if (term.length > 20) {
                            var msg = "Label must not exceed 20 characters!";
                            showTopErrSucc('error', msg);
                            return null;
                        }
                        $('#gc_calid option[value="0"]').remove();
                        return {
                            id: 0,
                            text: term,
                            newTag: true
                        }
                    }
                });
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
        <style>
            .gcProjectSetting .close{display:none;}
        </style>
    