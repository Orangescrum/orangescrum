<div class="modal-dialog" style="width:456px">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal"><i class="material-icons" onclick="closePopup();">&#xE14C;</i></button>
            <h4 class="mxwid95p">
                <div class="fl"><?php echo __('Upcoming due dates of this task');?><span id="recur_title_heading" style="display:none;"></span></div>
            </h4>
            <div class="cb"></div>
        </div>
        <div class="modal-body popup-container" style="">
            <center><div id="milestone_err_msg" class="err_msg"></div></center>
            <span id="recurring_popupload1" class="mlstn-srh-ldr" style="left:150px;"><?php echo __('Loading tasks');?>... <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" title="Loading..." alt="Loading..."/></span>
            <div id="inner_recur_case"></div>
        </div>
        <div class="modal-footer">
            <span id="tskloader" style="display: none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
            </span>
            <div class="fr popup-btn">
                <span class="fl cancel-link"><button type="button" onclick="closePopup();" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo __('Cancel');?></button></span>
                <span id="confirmbtntsk" class="fl hover-pop-btn">
                    <button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info showhidebtn" id="stoprecur" type="button" onclick="stopRecurring(this)"><?php echo __('Stop Recurring');?></button>
                </span>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
