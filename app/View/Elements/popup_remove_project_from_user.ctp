<style>
  .cmn-popup .modal-content .modal-body.modal-height{padding:10px 24px 30px;}
</style>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4>
                <span id="header_usr_prj_rmv" class="fnt-nrml ellipsis-view max-width-75"></span>
                <span><img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png"></span>
                <?php echo __('Remove Project');?>
            </h4>
        </div>
        <div class="modal-body popup-container modal-height">
            <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
            <div class="row">
                <div class="col-lg-7">
                    <span id="rempopupload" class="usr-srh" style="display: none"><?php echo __('Loading projects');?>... <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" title="Loading..." alt="Loading..."/></span>
                </div>
                <div class="col-lg-5">
                    <div class="form-group label-floating" id="remprjsrch" style="display:none;">
                        <label class="control-label" for="rmprjname">Search project</label>
                        <?php echo $this->Form->text('name', array('class' => 'form-control ', 'id' => 'rmprjname', 'maxlength' => '100', 'onkeyup' => "searchListWithInt('searchprojrem',600)", 'placeholder' => '')); ?>
                    </div>
                </div>
            </div>

            <div class="cb"></div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="popup-inner-container" id="inner_usr_prj_rmv">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="rmvprjloader" class="ldr-ad-btn fr">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
                </span>
                <span id="rmv_prj_btn">
                    <span class="fl cancel-link"><button type="button" onclick="closePopup();" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="rmvprjbtn" onclick="removeprojects()" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Remove');?></a></span>
                    <div class="cb"></div>
                </span>
            </div>
        </div>
    </div>
</div>
<script>
    function changeUserNotificationSetting_rmvPorj(obj,userid){
        $(obj).is(':checked')?setemail(obj, 'on', userid, 'off'):setemail(obj, 'off', userid, 'on');
        //$(obj).closest('.checkedonofflbl').find('.checkedonoffdisplay').html($(obj).is(':checked')?"ON":"OFF");
    }
</script>
