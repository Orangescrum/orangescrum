<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal"><i class="material-icons" onclick="closePopup();">&#xE14C;</i></button>
            <h4 class="mxwid95p">
                <div class="fl">&nbsp;<?php echo __('Assign Tasks');?>&nbsp;</div>
                <div class="fl">&nbsp;<img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png">&nbsp;</div>
                <div id="header_prj_ttl" class="fl fnt-nrml"></div>
                <div class="fl">&nbsp;<img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png">&nbsp;</div>
                <div id="header_mlstn_ttl" class="fl fnt-nrml ttc adtskmlstn_ttl"></div>
            </h4>
            <div class="cb"></div>
        </div>
        <div class="modal-body popup-container" style="">
            <center><div id="milestone_err_msg" class="err_msg"></div></center>
            <div id="tsksrch"  class="col-lg-4 padlft-non padrht-non form-group  label-floating fr" style="display:none;">
                <label class="control-label" for="tsk_name"><?php echo __('Task Title');?></label>
                <?php echo $this->Form->text('name', array('class' => 'form-control', 'id' => 'tsk_name', 'maxlength' => '100', 'onkeyup' => 'searchMilestoneCase()')); ?>
                <i class="icon-srch-img chng_icn"></i>
            </div>
            <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
            <div class="cb"></div>
            <span id="tskpopupload1" class="mlstn-srh-ldr"><?php echo __('Loading tasks');?>... <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" title="Loading..." alt="Loading..."/></span>
            <div id="inner_mlstn_case"></div>
        </div>
        <div class="modal-footer">
            <span id="tskloader" style="display: none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
            </span>
            <div class="fr popup-btn">
                <span class="fl cancel-link"><button type="button" onclick="closePopup();" class="btn btn-default btn-sm" data-dismiss="modal"><?php echo __('Cancel');?></button></span>
                <span id="confirmbtntsk" class="fl hover-pop-btn">
                    <button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info showhidebtn" id="addtsk" type="button" onclick="assignCaseToMilestone(this)"><?php echo __('Assign');?></button>
                    <button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info showhidebtn" id="addtskncont" type="button" onclick="assignCaseToMilestone(this)"><?php echo __('Assign & Continue');?></button>
                </span>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
