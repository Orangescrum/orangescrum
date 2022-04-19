<?php
$usrArr = $this->Format->getUserDtls(SES_ID);
if (count($usrArr)) {
    $ses_name = $usrArr['User']['name'];
    $ses_email = $usrArr['User']['email'];
    $ses_last_name = $usrArr['User']['last_name'];
}
?>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><span class="support_title"><?php echo __('Feedback');?></span></h4>
        </div>
        <div class="modal-body popup-container">
            <div id="inner_support">
                <center><div id="support_err" class="err_msg" style="display:block;"></div></center>
                <div class="form-group label-floating">
                    <label class="control-label" for="support_name"><?php echo __('Your name');?></label>
                    <input type="text" name="support_name" id="support_name" class="form-control input-lg" value="<?php echo $ses_name . ' ' . $ses_last_name; ?>" />
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="support_email">Your email</label>
                    <input type="text" name="support_email" id="support_email" readOnly="readOnly" class="form-control input-lg"  value="<?php echo $ses_email; ?>" />
                </div>
                <div class="row ">
                    <div class="col-lg-12">
                        <div class="form-group label-floating">
                            <label class="control-label" for="support_msg"><?php echo __('Give your message');?></label>
                            <textarea name="support_msg" id="support_msg" class="form-control input-lg expand hideoverflow"></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden"  name="url_sendding" id="url_sendding" />
            <div class="fr popup-btn">
                <span id="spt_btn">
					<span class="cancel-link"><button type="submit" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="hover-pop-btn">
                        <a href="javascript:void(0)" id="btn_support_feedback" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive" onclick="postSupport();action_ga('Feedback Post');"><?php echo __('Post');?></a>
                    </span>
                </span>
                <span id="sprtloader" class="ldr-ad-btn" style="display:none;">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/> 
                </span>
            </div>
			<div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('#support_name,#support_email,#support_msg')
                .on('change keyup',function(){
                    ($('#support_name').val().trim()!='' && $('#support_msg').val().trim()!='')?$("#btn_support_feedback").removeClass('loginactive'):$("#btn_support_feedback").addClass('loginactive');
                    $('#support_err').html('');
                });
        $('#support_err').html('');
    });
</script>