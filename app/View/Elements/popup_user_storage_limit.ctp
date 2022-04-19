<?php 
//avoid using bootstrap min as it destroy the originl css
//echo $this->Html->css('bootstrap.min.css'); 
?>
<div class="modal-dialog" id="dialog-form" style="display: none; position: relative; box-sizing: border-box; width: 100%;">
    <div class="modal-content">
        <div class="modal-header" style="padding: 15px 20px 0px; display: table; clear: both; width: 100%; box-sizing: border-box; text-align: left;">
            <button style="min-width:24px; padding: 0px; opacity: 0.2; float: right; background: transparent none repeat scroll 0px 0px; border: 0px none; line-height: 1px; margin: 0px; " type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 style="color: rgb(34, 34, 34); font-size: 20px; display: inline-block; font-weight: normal; line-height: 25px; margin: 0px;"><?php echo __('Manage User & Storage Limit');?></h4>
        </div>
        <div class="modal-body popup-container" style="padding: 10px 24px;">
            <form onsubmit="" id="userNstorageLimit" method="POST" action="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'userNstorageLimit')); ?>">
                <?php echo $this->Form->input('company_Id', array('label' => false, 'type' => 'hidden')); ?>
                <?php echo $this->Form->input('sub_Id', array('label' => false, 'type' => 'hidden')); ?>
                <?php echo $this->Form->input('reason', array('label' => false, 'type' => 'hidden','id'=>'reason_cmp')); ?>
                <div id="company_err" class="err_msg"></div>
                <div class="form-group label-floating ">
                    <label class="control-label" for="to"><?php echo __('No. Of Users');?></label>
                    <?php echo $this->Form->input('user_count', array('label' => false, 'class' => 'form-control required', 'required' => 'required', 'style'=>'width:100%; padding:2px 0px', 'value'=>"0")); ?>
                </div>
                <div class="form-group label-floating ">
                    <label class="control-label" for="message"><?php echo __('Storage(GB)');?></label>
                    <?php echo $this->Form->input('storage_usage', array('label'=>false, 'class'=>'form-control required', 'required' => 'required', 'style'=>'width:100%; padding:2px 0px', 'value'=>"0")); ?>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <img src="<?php echo HTTP_ROOT . "img/images/case_loader2.gif"; ?>" alt="Loading" id="company_loader" style="display:none;" alt="" class="fr"/>
                <div id="invoice_btnn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();" style="border: medium none; background: transparent none repeat scroll 0px 0px; margin: -3px 0px 0px; line-height: 16px;"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a id="userNstorageBTN" data-ridd="" href="javascript:void(0)" onclick="updateCompanyRecord(this);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __('Save');?></a></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
var updateCompany = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'userNstorageLimit')) ?>";


function updateCompanyRecord(el) {
    var reason = '';    
    var user_count = $('#user_count').val();
    var storageLimit = $('#storage_usage').val();
    var error = 0;
    var row_id = $(el).attr('data-ridd');
    var sub_id = $('#sub_Id').val();
    var company_Id = $('#company_Id').val();
    //    var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var letterNumber = /^[0-9a-zA-Z]+$/;
    var onlyNumber = /^\d+\.\d{0,2}$/;

    if (user_count == "") {
        $("#user_count").focus();
        error = 1;
    } else if (!user_count.match(letterNumber)) {
        $("#company_err").html('<?php echo __('Invalid data');?>!');
        $("#user_count").focus();
        error = 1;
    }

    if (storageLimit == "") {
        $("#storage_usage").focus();
        error = 1;
    } else if (!storageLimit.match(letterNumber)) {
        $("#company_err").html('<?php echo __('Invalid data');?>!');
        $("#storage_usage").focus();
        error = 1;
    }

    if (error == 1) {
        //        $('#tomail').focus();
        return false;
    } else {
        while (!reason) {
           var reason = prompt("Please enter the reason to add users/storages of this company", "");
        }
        $('#userNstorageBTN').hide();
        $('#company_loader').show();
        $("#reason_cmp").val(reason);
        var e = $("#userNstorageLimit");
        v = e.serialize();
        $.post(updateCompany, {
            v: v
        }, function(res) {
            //            console.log(res); return false;
            if (res == "success") {
                $('#company_loader').hide();
                $('#userNstorageBTN').show();
                closePopup();
                showErrSucc('success', "<?php echo __('Data Updated Successfully');?>!");
                $('#mng-btn-str-'+row_id).attr('onclick', "showManagePopup('"+company_Id+"', '"+user_count+"', '"+storageLimit+"', '"+sub_id+"','"+row_id+"')");
            } else {
                $('#company_loader').hide();
                $('#userNstorageBTN').show();
                showErrSucc('error', "<?php echo __('Problem in updating records. Please try later');?>!");
            }
        });
    }
}

function showErrSucc(type, msg) {
    $("#topmostdiv").show();
    $("#btnDiv").show();
    if (type == 'error') {
        //$("#upperDiv").find(".msg_span").removeClass('success');
        $("#upperDiv_err").html(msg);
        $("#upperDiv_err").show();
    } else {
        //$("#upperDiv").find(".msg_span").removeClass('error');
        $("#upperDiv").html(msg);
        $("#upperDiv").show();
    }
    //$("#upperDiv").find(".msg_span").addClass(type);
    //$("#upperDiv").find(".msg_span").html(msg);
    clearTimeout(time);
    time = setTimeout(removeMsg, 6000);
}
</script>