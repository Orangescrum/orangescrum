<div class="modal-body popup-container">
    <div class="data-scroll user_pdt">
            <div>          
           
            <div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder customize-plshdr">
                <div id="resource-avl"></div>
                    <select name="new_project" id="all_project_list" class="select form-control movetoproj"  data-dynamic-opts=true onchange="rmverrmsg();">
                        <option value="">Select Project</option>                    
                    </select>
				<div id="err_msg_dv" class="exist-prj exit-pro-txt" style="display:none">
					<?php echo __('Already in this Project');?>.</div>
                </div>
            </div>         
    </div>
</div>
<div class="modal-footer ">
    <div class="fr popup-btn">
		<span id="mvprjloader" class="mvprjlder fr" style="display: none;">
			<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..."
			 title="<?php echo __('loading');?>..." /> </span>
       
        <div id="mvprj_btn">               
			<span class="fl cancel-link">
				<button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();">
					<?php echo __('Cancel');?>
				</button>
			</span>
			<span class="fl hover-pop-btn">
				<a href="javascript:void(0)" id="mvbtn" onclick="assignProject();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size">
					<?php echo __('Assign');?>
				</a>
			</span>
            <div class="cb"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
$(function() {
		// $('#all_project_list').select2();
    $(document).on('click', '.remove-resource', function(event) {  
        $(this).parents('.new_resource').remove(); 
        checkCheckbox();  
});

});
</script>