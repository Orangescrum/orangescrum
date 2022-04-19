<?php //echo $this->Html->script('invoices', array('inline' => true));?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Send Transaction Invoice');?></h4>
        </div>
        <div class="modal-body popup-container">
            <form onsubmit="" id="senEmailForm2" method="POST" action="<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'sendTransInvoiceEmail')); ?>">
                <?php echo $this->Form->input('transaction_Id', array('label' => false, 'type' => 'hidden')); ?>
                <?php echo $this->Form->input('invoice_Id', array('label' => false, 'type' => 'hidden')); ?>
				<!-- HNEY-->
				<?php echo $this->Form->input('name', array('label' => false, 'type' => 'hidden','value'=> $email,'id'=>'inv_hn_name')); ?>
                <!--<div class="form-group label-floating ">
                    <label class="control-label" for="from">From</label>
                    <?php echo $this->Form->input('from', array('label' => false, 'class' => 'form-control required', 'required' => 'required', 'value' => @$email)); ?>
                    <div id="from_err" class="err_msg"></div>
                </div>-->
                <div class="form-group label-floating ">
                    <label class="control-label" for="to"><?php echo __('To');?></label>
                    <?php echo $this->Form->input('tomail', array('label' => false, 'class' => 'form-control required', 'required' => 'required', 'value'=>@$email)); ?>
                    <div id="to_err2" class="err_msg"></div>
                </div>
                <!--<div class="form-group label-floating ">
                    <label class="control-label" for="subject">Subject</label>
                    <?php echo $this->Form->input('subject', array('label' => false, 'class' => 'form-control required', 'required' => 'required',)); ?>
                </div>-->
                <div class="form-group label-floating ">
                    <label class="control-label" for="message"><?php echo __('Message');?></label>
                    <?php echo $this->Form->input('message', array('label'=>false, 'class'=>'form-control','id'=>'inv_to_msg')); ?>
                </div>
                <div class="form-group">
                    <span class="mceIcon"><i class="material-icons">&#xE226;</i></span>
                    <!--<a href="javascript:void(0);" class="blue-link-txt" id="downloadPDFEmailAddress" onclick="buildInvoicePdf('0')"> Invoice # 
                        <span id="trans_invoice_no"></span>
												</a>-->
                    <a title="Download Invoice" class="blue-link-txt"  rel="tooltip" href="javascript:void(0);" onclick="downloadPDF()">
                        Invoice #<span id="trans_invoice_no"></span>
                    </a>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">                
                <div id="invoice_btnn">
									<img src="<?php echo HTTP_ROOT . "img/images/case_loader2.gif"; ?>" id="invoice_loader2" style="display:none;" alt="" class="fr"/>
									<span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
									<span class="fl hover-pop-btn"><a id="invoice_send_email2" href="javascript:void(0)" onclick="sendInvoicebyEmail();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __('Send');?></a></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
var createInvoicePdfURL = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'createInvoicePdf')) ?>";
//var downloadPdfURL = "<?php //echo $this->Html->url(array('controller' => 'invoices', 'action' => 'downloadPdf')) ?>";
var downloadPdfURL = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'download_invoice')) ?>";
var sendInvoiceEmailURL = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'sendTransInvoiceEmail')) ?>";

function downloadPDF() {
    invoiceID = $('#invoice_Id').val();
    url = downloadPdfURL +'/'+invoiceID;
    window.open(url,'_blank');
}

function sendInvoicebyEmail(){
    var to = $('#tomail').val();
    //var from = $('#from').val();
    //var subject = $('#subject').val();
    var error = 0;
    var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var letterNumber = /^[0-9a-zA-Z]+$/;
    
    if (to == "") {
        $("#tomail").focus();
        error = 1;
    } else if(!to.match(emailRegEx)){
        $("#to_err2").html('Invalid email');
        $("#tomail").focus();
        error = 1;
    }

    /*if(from == "") {
            $("#from").focus();
            error = 1;
    }else if(!from.match(emlRegExpRFC)){
            $("#from_err").html('Invalid email');
            $("#from").focus();
            error = 1;
    }

    if(subject == "") {
            $("#subject").focus();
            error = 1;
    }*/

    if (error == 1) {
        $('#tomail').focus();
        return false;
    } else {
        $('#invoice_send_email2').hide();
        $('#invoice_loader2').show();
        $('#inv_hn_name').val('');
        var e=$("#senEmailForm2");
        v=e.serialize();
        $.post(sendInvoiceEmailURL, {v: v}, function(res) {
            //console.log(res); return false;
            if (res == "success") {
                    $('#invoice_loader2').hide();
                    $('#invoice_send_email2').show();
                    closePopup();
                    showTopErrSucc('success',"<?php echo __('Email sent successfully');?>.");
            }else{
                $('#invoice_loader2').hide();
                $('#invoice_send_email2').show();
                showTopErrSucc('error',"<?php echo __('Email not sent due to some problem');?>.");
            }
        });
    }
}
function hideCmnMesg(){
	var div = $(".comn_message_div");  
	div.animate({top:'-60px',height:'50px'}, "slow",function(){
		$('.comn_message_div_ctnir').html('');
	});
}
function showTopErrSucc(type,msg) {
	/*$("#topmostdiv").show();
	$("#btnDiv").show();
	$("#upperDiv").show();
	if(type == 'error') {
		$("#upperDiv").find(".msg_span").removeClass('success');
	}
	else {
		$("#upperDiv").find(".msg_span").removeClass('error');
	}
	$("#upperDiv").find(".msg_span").addClass(type);
	$("#upperDiv").find(".msg_span").html(msg);
	clearTimeout(time);
	time = setTimeout(removeMsg,6000);*/
	var div = $(".comn_message_div");  
	var mes_d = '<a class="mesg_close_icon" onclick="hideCmnMesg();" href="javascript:void(0);">x</a>';
	if(type == 'error'){
		$('.comn_message_div_ctnir').removeClass('success');
		var materialIcon= '<i class="material-icons">&#xE14B;</i>';
	}else{
		$('.comn_message_div_ctnir').removeClass('error');
		var materialIcon= '<i class="material-icons">&#xE876;</i>';
	}		
	$('.comn_message_div_ctnir').addClass(type);
	$('.comn_message_div_ctnir').html('<div class="checkInnerHeight">'+materialIcon+' '+mes_d+' '+msg+'</div>');
	div.animate({top: '108px'}, "slow");
        div.animate({height: (parseInt($(".checkInnerHeight").height())+30)+'px'}, "slow");
	div.animate({fontSize: '14px'}, "slow");
	if(typeof time != 'undefined'){
		clearTimeout(time);
	}
    time = setTimeout(hideCmnMesg, 6000);
}
</script>