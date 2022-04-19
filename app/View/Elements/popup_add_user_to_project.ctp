<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Assign User(s) to');?> - <span id="add_user_pop_pname" class="ellipsis-view max-width-75"></span></h4>
        </div>
        <div class="loader_dv" id="addUPLoader" style="position:absolute;left:44%;top:65%;">
            <center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center>
        </div>
        <div id="add_user_project_resp" class="mils_ipad"><?php echo __('Response goes here');?></div>
        <input type="hidden" id="all_asgnd_usrs" />
        <input type="hidden" id="current_checked_users" />
    </div>
</div>