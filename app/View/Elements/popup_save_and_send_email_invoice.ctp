<script type="text/javascript">
    var SES_COMP = "<?php echo SES_COMP;?>";
</script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closeEmailPopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Send invoice');?></h4>
        </div>
        <div class="modal-body popup-container">
            <form onsubmit="" id="senEmailForm" method="POST" action="<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'sendInvoiceEmail')); ?>">
                <?php print $this->Form->input('invoiceId', array('label' => false, 'type' => 'hidden', 'value' => $i['Invoice']['id'])); ?>
                <div class="form-group label-floating ">
                    <label class="control-label" for="from"><?php echo __('From');?></label>
                    <?php echo $this->Form->input('from', array('label' => false, 'class' => 'form-control required', 'required' => 'required', 'value' => @$email)); ?>
                    <div id="from_err" class="err_msg"></div>
                </div>
                <div class="form-group label-floating ">
                    <label class="control-label" for="to"><?php echo __('To');?></label>
                    <?php echo $this->Form->input('to', array('label' => false, 'class' => 'form-control required', 'required' => 'required', 'placeholder'=>'Use comma(,) to separate multiple email ids.')); ?>
                    <div id="to_err" class="err_msg"></div>
                </div>
                <div class="form-group label-floating ">
                    <label class="control-label" for="subject"><?php echo __('Subject');?></label>
                    <?php echo $this->Form->input('subject', array('label' => false, 'class' => 'form-control required', 'required' => 'required',)); ?>
                </div>
                <div class="form-group label-floating ">
                    <label class="control-label" for="message"><?php echo __('Message');?></label>
                    <textarea id="message" name="message" class="form-control" ></textarea>
                </div>
                <div class="form-group">
                    <!--<img class="mceIcon fl" src="<?php print HTTP_IMAGES; ?>images/attach.png" alt=""/>-->
										<span class="mceIcon"><i class="material-icons">&#xE226;</i></span>
                    <a href="javascript:void(0);" class="blue-link-txt" id="downloadPDFEmailAddress" onclick="buildInvoicePdf('0')"> <?php echo __('Invoice');?> # 
                     <span id="pop_email_invoice_no"></span></a>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <img src="<?php echo HTTP_ROOT . "img/images/case_loader2.gif"; ?>" id="invoice_loader" style="display:none;" alt="" class="fr"/>
                <div id="invoice_btnn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closeEmailPopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a id="invoice_send_email" href="javascript:void(0)" onclick="sendInvoicebyEmail();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __('Send');?></a></span>
                </div>
                <div class="cb"></div>
            </div>
						<div class="cb"></div>
        </div>
    </div>
</div>
