<div class="modal-dialog" id="dialog-form-email" style="display: none; position: relative; box-sizing: border-box; width: 100%;">
    <div class="modal-content">
        <div class="modal-header" style="padding: 15px 20px 0px; display: table; clear: both; width: 100%; box-sizing: border-box; text-align: left;">
            <button style="min-width:24px; padding: 0px; opacity: 0.2; float: right; background: transparent none repeat scroll 0px 0px; border: 0px none; line-height: 1px; margin: 0px; " type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 style="color: rgb(34, 34, 34); font-size: 20px; display: inline-block; font-weight: normal; line-height: 25px; margin: 0px;">Update Email</h4>
        </div>
        <div class="modal-body popup-container" style="padding: 10px 24px;">
            <form onsubmit="" id="userNEmail" method="POST" action="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'userNstorageLimit')); ?>">
                <?php echo $this->Form->input('user_sub_id', array('label' => false, 'type' => 'hidden')); ?>
                <div id="company_err" class="err_msg"></div>
                <div class="form-group label-floating ">
                    <label class="control-label" for="to"><?php echo __('Email Address');?></label>
                    <?php echo $this->Form->input('user_sub_email', array('label' => false, 'class' => 'form-control required', 'required' => 'required', 'style'=>'width:100%; padding:2px 0px')); ?>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <img src="<?php echo HTTP_ROOT . "img/images/case_loader2.gif"; ?>" alt="Loading" id="company_loader" style="display:none;" alt="" class="fr"/>
                <div id="invoice_btnn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();" style="border: medium none; background: transparent none repeat scroll 0px 0px; margin: -3px 0px 0px; line-height: 16px;"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a id="userNstorageBTN" href="javascript:void(0)" onclick="updateEmailRecord();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __('Update');?></a></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
var updateEmail = "<?php echo $this->Html->url(array('controller' => 'Osadmins', 'action' => 'emailUniqueEdit')) ?>";
function updateEmailRecord() {
    var reason = '';
    var user_email = $('#user_sub_email').val();
    var error = 0;
    var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

    if (user_email == "") {
        $("#user_sub_email").focus();
        showErrSucc('error', "<?php echo __('Please Enter Email Address');?>!");
        error = 1;
    } else if (error == 0) {
        if (!user_email.match(emlRegExpRFC) || user_email.search(/\.\./) != -1) {
            $("#user_sub_email").focus();
            showErrSucc('error', "<?php echo __('Invalid Email');?>!");
            error = 1;
        }
    }
    if (error == 1) {
        return false;
    } else {
        while (!reason) {
           var reason = prompt("Please enter the reason to change email of this user", "");
        }
        $('#userNstorageBTN').hide();
        $('#company_loader').show();
        var e = {};
        e = {
            "email": user_email,
            "user_id": $('#user_sub_id').val(),
            "reason":reason
        };
        $.post(updateEmail, {
            v: e
        }, function(res) {
            res = JSON.parse(res);
            $('#company_loader').hide();
            $('#userNstorageBTN').show();
            if (res.status) {
                closePopup();
                $('#userIDrow-' + $('#user_sub_id').val()).find('td:eq(3)').html(user_email);
                showErrSucc('success', res.msg);
            } else {
                showErrSucc('error', res.msg);
            }
        });
    }
}

function showErrSucc(type, msg) {
    $("#topmostdiv").show();
    $("#btnDiv").show();
    if (type == 'error') {
        $("#upperDiv_err").html(msg);
        $("#upperDiv_err").show();
    } else {
        $("#upperDiv").html(msg);
        $("#upperDiv").show();
    }
    clearTimeout(time);
    time = setTimeout(removeMsg, 6000);
}
</script>