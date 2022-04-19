<div class="modal-dialog" id="dialog-form-pawd" style="display: none; position: relative; box-sizing: border-box; width: 100%;">
    <div class="modal-content">
        <div class="modal-header" style="padding: 15px 20px 0px; display: table; clear: both; width: 100%; box-sizing: border-box; text-align: left;">
            <button style="min-width:24px; padding: 0px; opacity: 0.2; float: right; background: transparent none repeat scroll 0px 0px; border: 0px none; line-height: 1px; margin: 0px; " type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 style="color: rgb(34, 34, 34); font-size: 20px; display: inline-block; font-weight: normal; line-height: 25px; margin: 0px;">Update Password</h4>
        </div>
        <div class="modal-body popup-container" style="padding: 10px 24px;">
            <form onsubmit="" id="userNEmail" method="POST" action="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'userNstorageLimit')); ?>">
                <?php echo $this->Form->input('user_sub_pid', array('label' => false, 'type' => 'hidden')); ?>
                <div class="form-group label-floating ">
                    <label class="control-label" for="to"><?php echo __('New Password');?></label>
                    <?php echo $this->Form->input('user_sub_password', array('type'=>'password','label' => false, 'class' => 'form-control required', 'required' => 'required', 'style'=>'width:100%; padding:2px 0px','maxlength'=>30)); ?>
                </div>
                <div class="form-group label-floating ">
                    <label class="control-label" for="to"><?php echo __('Repeat New Password');?></label>
                    <?php echo $this->Form->input('user_sub_rpassword', array('type'=>'password','label' => false, 'class' => 'form-control required', 'required' => 'required', 'style'=>'width:100%; padding:2px 0px','maxlength'=>30)); ?>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <img src="<?php echo HTTP_ROOT . "img/images/case_loader2.gif"; ?>" id="company_loader_p" style="display:none;" alt="" class="fr"/>
                <div id="invoice_btnn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();" style="border: medium none; background: transparent none repeat scroll 0px 0px; margin: -3px 0px 0px; line-height: 16px;"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a id="userPstorageBTN" href="javascript:void(0)" onclick="updatePasswordRecord();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __('Update');?></a></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
var updatep = "<?php echo $this->Html->url(array('controller' => 'Osadmins', 'action' => 'passwordUniqueEdit')) ?>";
function updatePasswordRecord() {
    var reason = '';
    var u_password = $.trim($('#user_sub_password').val());
    var u_r_password = $.trim($('#user_sub_rpassword').val());
    var error = 0;

    if (u_password == "") {
        $("#user_sub_password").focus();
        showErrSucc('error', "<?php echo __('Please Enter New Password. Spaces Are Not Allowed');?>!");
        error = 1;
    } else if (u_password.length < 6) {
        $("#user_sub_password").focus();
        showErrSucc('error', "<?php echo __('Password Length Must Be Greater Than Six');?>!");
        error = 1;
    } else if (u_r_password == "") {
        $("#user_sub_rpassword").focus();
        showErrSucc('error', "<?php echo __('Please Enter New Password Again. Spaces Are Not Allowed');?>!");
        error = 1;
    } else if ($.trim(u_password) != $.trim(u_r_password)) {
        showErrSucc('error', "<?php echo __("Both Passwords Doesn't Match");?>!");
        error = 1;
    }
    if (error == 1) {
        return false;
    } else {
        while (!reason) {
           var reason = prompt("Please enter the reason to change password of this user", "");
        }
        $('#userPstorageBTN').hide();
        $('#company_loader_p').show();
        var e = {};
        e = {
            "password": u_password,
            "rpassword": u_r_password,
            "user_id": $('#user_sub_pid').val(),
            "reason":reason
        };
        $.post(updatep, {
            v: e
        }, function(res) {
            res = JSON.parse(res);
            if (res.status) {
                $('#company_loader_p').hide();
                $('#userPstorageBTN').show();
                closePopup();
                showErrSucc('success', "<?php echo __('Password Updated Successfully');?>!");
            } else {
                $('#company_loader_p').hide();
                $('#userPstorageBTN').show();
                showErrSucc('error', "<?php echo __("Password Couldn't Updated");?>!");
            }
        });
    }
}
</script>