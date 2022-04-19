<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Assign Tasks');?>
                <span id="header_usr_prj_add" class="fnt-nrml ellipsis-view max-width-75"></span>
            </h4>
        </div>
        <div class="modal-body popup-container">
            <div>
                <div class="qtask fl width-70">
                    <small id="pop_up_assign_case_user_label" style="display:none;"></small>
                </div>				
                <div class="fl width-30" style="display:none;">
                </div>
                <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                <div class="cb"></div>
                <div class="popup-inner-container">
                    <div id="inner_usr_case_add"></div>
                </div>
                <div class="cb"></div>
            </div>
        </div>
        <div class="modal-footer add-prj-btn" style="display: none;">
            <div class="fr popup-btn">
                <span id="casasusrloader" class="ldr-ad-btn fr"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/></span>
                <span id="casasusrpopupload" class="ldr-ad-btn fr"><?php echo __('Loading projects');?>... <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" title="Loading..." alt="Loading..."/></span>
                <span id="confirmbtnta" style="display:block;">
                    <?php /*?><span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" onclick="closePopup();"><?php echo __('Cancel');?></button></span><?php */?>
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="confirmcasas" onclick="assigncases(this)" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></a></span>
                    <div class="cb"></div>
                </span>
            </div>
        </div>
    </div>
</div>
