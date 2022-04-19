<tr class="tgrp_tr_all edit_tg_pt_row" id="ptr_edit_<%= id %>">
    <td>
        <div class="col-md-8 form-group label-floating fl">
             <div class="form-group label-floating">
                <div class="input-group">
                    <label class="control-label" for="inline_milestone_tg"><?php echo __('Task Group Title');?></label>
                    <input class="form-control" type="text" value="<%= title %>" id="inline_milestone_tg<%= id %>" maxlength="240" >
                </div>  
            </div>
        </div>
         <div class="col-md-4 form-group label-floating fl">
             <div class="form-group label-floating">
                    <div class="input-group" style="width:50%;">
                    <label class="control-label" for="qt_estimated_hours_tg"><?php echo __('Est. Hour');?></label>
                    <span class="os_sprite est-hrs-icon" style="top:8px;"></span>
                    <input type="text" name="estimated_hours_tg" id="qt_estimated_hours_tg<%= id %>" placeholder="hh:mm" class="form-control" value="<%= estimated_hr %>" maxlength="5" onkeypress="return numeric_decimal_colon(event);">                                
                </div>
            </div>
         </div>
       <div class="cb"></div>
       <div class="col-md-8 form-group label-floating fl" style="padding-left: 0px;">
        <div class="form-group label-floating">
            <div class="input-group" >
                <label class="control-label" for="inline_milestone_desc_tg"><?php echo __('task Group Description');?></label>
                <textarea class="form-control" id="inline_milestone_desc_tg<%= id %>" ><%= description %></textarea>
            </div>
            
        </div>
        </div>
         <div class="col-md-4 form-group label-floating fl">
             <div class="fl btn-group save_exit_btn"  style="float:left;margin-right:13px;margin-top:8px;">
                <input type="hidden" value="list" id="task_view_types_span" />
                <a id="quickcase_qt" href="javascript:void(0)" class="btn btn-primary btn-raised" onclick="AddTaskGroup(<%= id %>);"><?php echo __('update');?></a>                                
            </div>
            <span style="line-height: 35px; padding-top: 10px; display:inline-block;">
              <a href="javascript:void(0);" onclick="cancelTGPT(<%= id %>);"><?php echo __('Cancel');?></a>
            </span>
         </div>
         <div class="cb"></div>
    </td>
</tr>