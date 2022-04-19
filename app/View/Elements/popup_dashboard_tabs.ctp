<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Show/Hide Tabs');?></h4>
        </div>
		<div style="float: right;margin-right: 233px;font-size: 12px;color: #639fed;"><?php echo __('Only three tabs can be selected');?></div>
        <div class="modal-body popup-container">
            <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
            <div id="inner_select_tab"></div>
        </div>
        <div class="modal-footer">
            <span id="tab_ldr" class="fr" style="display:none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
            </span>
            <span id="btn_cattype">
                <div class="fr popup-btn">					
					<span class="cancel-link">
                        <button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button>
                    </span>
                    <span class="hover-pop-btn ">
                        <a href="javascript:void(0)" id="btn_dashboard_tabs" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="savecategorytab();"><?php echo __('Save');?></a>
                    </span>
                </div>
				<div class="cb"></div>
            </span>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
       
        
    });
</script>