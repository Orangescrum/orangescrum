<?php echo $this->Html->script(array('ajaxfileupload'));?>
<?php echo $this->Html->script('invoices.js?v='.RELEASE, array('inline' => true));?>
<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<div id="invoiceListing">     
    <div class="tab tab_comon" id="mlsttab">
        <ul class="nav-tabs mod_wide fl no-border">
            
        </ul>
    </div>
    <div class="cbt"></div>
    <div id="show_invoiceListing"></div>
    <div class="Invoice_DownloadEmail" style="display: none;" ></div>
</div>
<?php /*<div class="loader_bg_new" id="caseLoader">
<div class="loader-wrapper md-preloader md-preloader-warning"><svg version="1.1" height="48" width="48" viewBox="0 0 75 75"><circle cx="37.5" cy="37.5" r="25" stroke-width="4"></circle></svg></div>
</div> */ ?>

<div class="loader_bg" id="caseLoader"> 
	<div class="loadingdata">
		<img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="<?php echo __('loading');?>..."/>
	</div>
</div>
<div id='showUnbilled' class="invoice_content_block"></div>
<div id='showInvoiceDiv' class="invoice_content_block"></div>
<div id='showCustomers' class="invoice_content_block"></div>
<div id='InvoiceSettingsDv' class="invoice_content_block"></div>
<div class="cb"></div>
<!--********** popup ********************* -->

<div id="add_invoice_form" class="cmn_popup" style="display: none;">
    <div class="popup_bg">
        <div style="" class="new_invoice_form invoice_add_popup">
            <div class="popup_title">
                <span><i class="icon-create-project"></i><?php echo __('Generate Invoice');?></span>
                <a onclick="closeInvoicePopup();" href="javascript:jsVoid();"><div class="fr close_popup">X</div></a>
            </div>
            <div class="popup_form" style="margin-top: 20px;">
                <div class="loader_dv" style="display: none;"><center><img title="Loading..." alt="Loading..." src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif"></center></div>
                <div style="" id="inner_log">                 
                   <?php echo $this->Form->create('Invoice', array('url' => array('controller' => 'easycases', 'action' => 'addInvoice'),'type'=>'post','id'=>'invoiceForm')); ?>               
                        <div class="logtime-content">

                            <div role="tabpanel">

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active"><a href="#essential" aria-controls="home" role="tab" data-toggle="tab"><?php echo __('Essentials');?></a></li>
                              <li role="presentation"><a href="#optional" aria-controls="profile" role="tab" data-toggle="tab"><?php echo __('Optional');?></a></li>   
                            </ul>

                            <!-- Tab panes -->
                              <div class="tab-content">
                                  <div role="tabpanel" class="tab-pane active" id="essential">                        
                                      <div style="margin:15px 30px;">
                                          <label><?php echo __('Invoice');?> # <span>*</span></label>
                                          <div>   
                                              <?php echo $this->Form->input('invoice_no', array('label' => false,'class'=>'form-control required','required'=>'required'));?>
                                          </div>
                                           <label><?php echo __('Invoice Date');?> <span>*</span></label>
                                            <div>   
                                              <?php echo $this->Form->input('issue_date', array('type' =>'text','label' => false,'id' => 'invoice_issue_data','class' => 'form-control','required'=>'required'));?>
                                          </div>
                                          <label><?php echo __('Due Date');?> <span>*</span></label>
                                            <div>   
                                              <?php echo $this->Form->input('due_date', array('type' =>'text','label' => false,'id' => 'invoice_due_data','class' => 'form-control','required'=>'required'));?>
                                          </div>

                                          <label> <?php echo __('Currency');?> <span>*</span></label>
                                            <div>   
                                              <select name="data[Invoice][currency]" class="form-control" required >                                   
                                                  <option value="usd"><?php echo __('USD');?> - <?php echo __('US Dollar');?></option>
                                              </select>
                                          </div>
                                             <label><?php echo __('Rate');?> <span>*</span></label>
                                            <div>   
                                                <?php echo $this->Form->input('price', array('label' => false,'class'=>'form-control required','required'=>'required'));?>
                                                <!--<select name="data[Invoice][price]" class="form-control" required >                                   
                                                  <option value="0">Price will be based on time and expenses </option>
                                              </select> -->
                                            </div>
                                      </div>
                                  </div>
                                  <div role="tabpanel" class="tab-pane" id="optional">
                                        <div style="margin:15px 30px;">
                                              <label><?php echo __('Note');?> <span>(<?php echo __('optional');?></span></label>
                                             <div>   
                                                 <textarea name="data[Invoice][notes]" class="form-control"></textarea>
                                             </div>
                                              <label><?php echo __('Terms');?> <span>(<?php echo __('optional');?></span></label>
                                             <div>   
                                                  <textarea name="data[Invoice][terms]" class="form-control"></textarea>
                                            </div>
                                      </div>
                                  </div>
                                  <div class="log-btn">
                                      <button class="btn btn_blue" name="crtLogTimeSave" value="Create&amp;Save" type="submit"><i class="icon-big-tick"></i><?php echo __('Generate Invoice');?></button>
                                      <span class="or_cancel cancel_on_direct_pj">or
                                          <a onclick="closeInvoicePopup();"><?php echo __('Cancel');?></a>
                                      </span>
                                  </div>
                              </div>

                        </div>
                    </div>
                    <?php echo $this->Form->end();?>

                </div>
            </div>
        </div>
    </div>
</div>

<div class="cb"></div>
<!--********** popup ********************* -->
<div id="myModal_pdf_preveiew" class="modal fade" role="dialog">
  <div class="modal-dialog" style=" width:80%;">
    <!-- Modal content-->
    <div class="modal-content" >     
        <div class="modal-header" style="padding-top: 6px;">
            <button type="button" class="close close-icon" data-dismiss="modal"><i class="material-icons">&#xE14C;</i></button>

        </div>
        <div class="modal-body" id="pdf_Preview_invoice" style="min-height: 500px; padding-top: 0px;">
      </div>     
    </div>

  </div>
</div>
<!--********** popup ********************* -->

<script type="text/javascript">

var sendInvoiceEmailURL = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'sendInvoiceEmail')) ?>";
var createInvoicePdfURL = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'createInvoicePdf')) ?>";
var updateInvoicedropdownURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'updateInvoicedropdown'));?>";
var add2InvoiceURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'add2Invoice'));?>";
var ajaxInvoicePageURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'ajaxInvoicePage'));?>";
var getCountInvoiceURL = "<?php echo $this->Html->url(array('controller'=>'easycases','action'=>'getCountInvoice'));?>";
var ajaxInvoiceListURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'ajaxInvoiceList'));?>";
var ajaxCustomerListURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'ajaxCustomerList'));?>";
var ajaxTimeListURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'ajaxTimeList'));?>";
var customer_detailsURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'customer_details'));?>";
var addInvoiceURL = "<?php print $this->Html->url(array('controller'=>'easycases','action'=>'addInvoice'));?>";
var deleteInvoiceURL = "<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'deleteInvoice'));?>";
var deleteInvoiceTimeLogURL = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'deleteInvoiceTimeLog')) ?>";
var downloadPdfURL = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'downloadPdf')) ?>";
var invoiceLogoURL = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'invoiceLogo')) ?>";
var opt_it_from = "<?php echo $from;?>";
var emode;
<?php if($this->Format->isAllowed('Create Invoice',$roleAccess)) { //SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1?>
<?php }else if($this->Format->isAllowed('Add Customer',$roleAccess) || $this->Format->isAllowed('Edit Customer',$roleAccess)){ ?>
<?php }else{?>
    emode = 'invoice';
<?php }?>
<?php if(!$this->Format->isAllowed('Create Invoice',$roleAccess)) { ?>
if(window.location.hash ==''){
	invoices.switch_tab('invoice');
}
<?php } ?>
</script>

<script type="text/template" id="paginate_tmpl">
<?php echo $this->element('task_paginate'); ?>
</script>