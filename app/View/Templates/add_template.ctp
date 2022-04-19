<?php echo $this->Form->create('ProjectTemplateCase', array('url' => '/templates/add_template_task', 'id' => 'addTemplste', 'onsubmit' => 'return validateTaskTemplate()')); ?>
<div class="modal-body popup-container">
    <center><div id="task_to_temp_err" class="err_msg"></div></center>
    <input type="hidden" name="data[ProjectTemplateCase][template_id]" id="temp_id" value="<?php echo $temp_id; ?>" />
    <input type="hidden" name="data[ProjectTemplateCase][temp_name]" id="temp_name" value="<?php echo $temp_name; ?>" />
    <div class="scrl-ovr">
        <div class="" id="appendtotr">
            <div class="taskblock relative" id="taskblock0">
                <label><span class="task_lbl"><?php echo __('Task');?> 1</span> <a class="rmv_task_block"><i class="material-icons">&#xE14C;</i></a></label>
                <div class="form-group label-floating">
                    <label class="control-label" for="title0"><?php echo __('Specify task title');?></label>
                    <input type="text" name="data[ProjectTemplateCase][title][]" id="title0" class="form-control" value= "" />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="description0"><?php echo __('Give task description');?></label>
                    <textarea name="data[ProjectTemplateCase][description][]" id="description0" class="form-control input-lg expand hideoverflow"></textarea>
                </div>
            </div>
        </div>
        
        <div class="" onclick="add_more_temp();"><a style="color:#5895B4; cursor:pointer;font-size: 14px;">+ <?php echo __('Add Line-item');?></a></div>
    </div>
</div>
<div class="modal-footer">
    <div class="fr popup-btn">
        <span id="addtasktotemploader" class="ldr-ad-btn">
            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
        </span>
        <span id="taskAddBtns">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="fl hover-pop-btn"><button type="submit" name="submit_template" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Add');?></button></span>
        </span>
        <div class="cb"></div>
    </div>
</div>
<?php echo $this->Form->end(); ?>
<script>
    var clonedRow;
    var tot_counter = 0;
    $(document).ready(function() {
        clonedRow = $('#taskblock0').clone();
        tot_counter = $('div[id^="taskblock"]').length;
        $('.rmv_task_block').on('click', function(){
            $(this).closest('.taskblock').remove();
            $('.rmv_task_block:gt(0)').show();
            update_title_counter();
        });
        
        $('#btnRemove').on('click', function(){
            var rowLength = $('.appendtotr').length;
            if (rowLength > 1){deleteRow(this);}
            if (rowLength == 2) {$(".btnsForAdd").css("width", "454px");}
        });
        function deleteRow(currentNode){
            $(currentNode).parent().parent().remove();
        }
        
    });
    function add_more_temp() {
        var html = clonedRow.clone();
        html.attr('id','taskblock'+tot_counter);
        html.find('.task_lbl').html('Task '+(tot_counter+1));
        html.find('input[type="text"],textarea,label').each(function(){
            var type = this.type || this.tagName.toLowerCase();
            var oldid = $(this).attr('id');
            if(typeof oldid !='undefined'){
                var newid = oldid.replace(/\d+/,tot_counter); 
                $(this).attr('id',newid);
            }
            var oldfor = $(this).attr('for');
            if(typeof oldfor !='undefined'){
                var newfor = oldfor.replace(/\d+/,tot_counter); 
                $(this).attr('for',newfor);
            }
            
        });
        
        $('#appendtotr').append(html);
        $('input[type="text"]').keyup();
        $('textarea').autoGrow().keyup();
        $('.rmv_task_block:gt(0)').show();
        $('.rmv_task_block').on('click', function(){
            $(this).closest('.taskblock').remove();
            $('.rmv_task_block:gt(0)').show();
            update_title_counter();
        });
        tot_counter++;
        update_title_counter();
    }
    function update_title_counter(){
        $('.task_lbl').each(function(key){
            $(this).html('Task '+(key+1));
        });
    }
</script>