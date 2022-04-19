<?php $grandTotal = 0; ?>
<style type="text/css">
    .timelog-detail-tbl.btime_ig .tableDate .form-control { border-width: 0px 0px 0px;}
    .timelog-detail-tbl.btime_ig .tableDate .form-control:hover {border-width: 0px 0px 1px;}
</style>
<form name="frm_create_invoice" id="frm_create_invoice" action="<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'save_invoice'));?>" autocomplete="off">
<div id="invoice_div" class="timelog-detail-tbl m_ig_cnt">
    <div class="row">
        <div class="col-sm-7">
            <div id="preview" style="cursor:pointer; display: inline-block;" onclick="$('#photo').trigger('click');">          
                <?php if(isset($i['Invoice']['logo']) && trim($i['Invoice']['logo']) !='' && $this->Format->pub_file_exists(DIR_INVOICE_PHOTOS_S3_FOLDER. SES_COMP . '/', $i['Invoice']['logo'])) { ?>
                    <img src="<?php echo $this->Format->generateTemporaryURL(DIR_INVOICE_PHOTOS_S3 . SES_COMP . '/'.  $i['Invoice']['logo']);?>" style="max-height:100px;" />
                    <?php /*?><?php if ($i['Invoice']['logo'] != '' && file_exists(WWW_ROOT . 'invoice-logo/' . $i['Invoice']['logo'])) { ?>          
                    <img src="<?php echo HTTP_ROOT . 'invoice-logo/' . $i['Invoice']['logo']; ?>" style="max-height:100px;" /><?php */?>
                <?php } else { ?>
                    <img src="<?php echo HTTP_IMAGES; ?>default-invoice-logo.png" style="max-height:100px;" />
                <?php } ?>
            </div>
            <br/>
            <div class="clearfix"></div>
            <?php print $this->Form->input('invoice_id', array('label' => false, 'type' => 'hidden', 'value' => $i['Invoice']['id'] , 'id' => 'invoice_id')); ?>
            <div class="lft_cnt_ig_frm" >
                <div class="frm_cnt_ig"> 
                    <label class="fld_ttl_ig" style="font-size:20px;"><?php echo __('Billing From');?></label>
                    <div>
                        <?php if (!empty($i['Invoice']['invoice_from'])) {echo $i['Invoice']['invoice_from'];}?>
                        <textarea id="edit_invoice_from" style="display:none;"><?php if (!empty($i['Invoice']['invoice_from'])) {echo $i['Invoice']['invoice_from'];}?></textarea>
                </div>
                </div>
                <div class="frm_cnt_ig">
                    <label class="fld_ttl_ig" style="font-size:20px;"><?php echo __('Customer');?></label>
                    <div id="invoice_customer_opts" class="dropdown option-toggle" style="border:0px none;background:#fff;padding: 0px;">
                        <?php $customer_id = (!empty($i['Invoice']['customer_id'])) ? $i['Invoice']['customer_id'] : 0; ?>
                        <?php if(is_array($customers) && count($customers)>0){?>
                            <?php foreach($customers as $key => $val){
                                $customer_details = $val[0]['details']; ?>
                                <?php if($val['InvoiceCustomer']['id'] == $customer_id){?>
                                    <span class="opt1"><?php echo $val[0]['name'];?></span>
                                <?php }?>
                            <?php }?>
                        <?php }?>
                        
                        <input type="hidden" name="invoice_company_name" id="invoice_company_name" value="<?php if (!empty($i['Invoice']['company_name'])) { echo $i['Invoice']['company_name'];}?>">
                        <input type="hidden" name="invoice_customer_id" id="invoice_customer_id" value="<?php if (!empty($i['Invoice']['customer_id'])) { echo $i['Invoice']['customer_id'];}?>">
                        <input type="hidden" name="invoice_customer_email" id="invoice_customer_email" value="<?php if (!empty($i['InvoiceCustomers']['email'])) { echo $i['InvoiceCustomers']['email'];}?>">
                        <input type="hidden" name="invoice_customer_currency" id="invoice_customer_currency" value="<?php if (!empty($i['Invoice']['currency'])) { echo $i['Invoice']['currency'];}?>">
                        </div>
                    </div>
                
                <div  class="frm_cnt_ig">
                    <label class="fld_ttl_ig"><?php echo __('Billing To');?></label>
                    <div>
                        <?php if (!empty($i['Invoice']['invoice_to'])) { echo $i['Invoice']['invoice_to'];}else{echo '---';}?>
                        <textarea id="edit_invoice_to" style="display:none;"><?php if (!empty($i['Invoice']['invoice_to'])) { echo $i['Invoice']['invoice_to'];}?></textarea>
                </div>
            </div>
        </div>
        </div>
        <div class="col-sm-5">
            <div class="rt_cnt_ig_frm">				
                <div class="frm_cnt_ig">
                    <h1><?php echo __('Invoice');?></h1>
                    <table>
                        <tr>
                            <td style="padding-top:0px;"><?php echo __('Invoice');?> #:</td>
                            <td  style="padding-top:0px;">
                                <?php print $i['Invoice']['invoice_no'];?>
                                <input type="hidden" id="edit_invoiceNo" value="<?php print $i['Invoice']['invoice_no'];?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo __('Terms');?>:</td>
                            <td id="invoice_terms_disp123">
                                <?php if (!empty($i['Invoice']['invoice_term'])) {
                                    $invoice_term = $i['Invoice']['invoice_term'];
                                    echo $invoice_term == 0 ? __('Due on receipt',true) : __('Net',true).' ' . $invoice_term;
                                }else{
                                    echo "---";
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo __('Invoice Date');?>:</td>
                            <td id="invoice_issue_date_disp">
                                <?php if($i['Invoice']['issue_date']>0){print $this->format->get_date($i['Invoice']['issue_date']);}else{echo "---";} ?>
                                <input type="hidden" id="edit_issue_date" value="<?php if($i['Invoice']['issue_date']>0){print $this->format->get_date($i['Invoice']['issue_date']);} ?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo __('Due Date');?>:</td>
                            <td id="invoice_due_date_disp">
                                <?php if($i['Invoice']['due_date']>0){print $this->format->get_date($i['Invoice']['due_date']);}else{echo "---";}?>
                                <input type="hidden" id="edit_due_date" value="<?php if($i['Invoice']['due_date']>0){print $this->format->get_date($i['Invoice']['due_date']);}?>"/>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="b_due">
                                <div>
                                    <div class="fl"><?php echo __('Balance Due');?></div>
                                    <div class="fr">
                                        <span class="inv_currency"><?php if($i['Invoice']['currency']!=''){print $i['Invoice']['currency'];}else{echo "USD";}?></span>
                                        <span class="inv_price"></span>
                                    </div>
                                    <div class="cb"></div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="cb"></div>
        </div>
        <div class="cb"></div>
    </div>
    <div class="row">
        <div class="col-sm-12" style="padding:0px;">
            <div class="timelog-table bllbl_cnt noborder" >
                <div class="timelog-table-head">
                    <div class="fl"><span class="time-log-head"></span></div>          
                    <div class="cb"></div>
                </div>
                <div class="timelog-detail-tbl ">        
                    <table cellpadding="3" cellspacing="4">
                        <tr>
                            <th style="width:5%;"><?php echo __('Sl');?>#</th>
                            <th style="width:12%;"><?php echo __('Date');?></th>
                            <th style="width:40%;"><?php echo __('Description');?></th> 
                            <th style="width:12%;"><?php echo __('Qty');?></th>
                            <th style="width:12%;"><?php echo __('Rate');?></th>
                            <th style="width:15%;"><?php echo __('Amount');?></th>
                        </tr>
                        <?php if (!empty($i['InvoiceLog'])) { ?>
                            <?php $c=0; $cntr = 0;
                                foreach ($i['InvoiceLog'] as $log) { 
                                    $invoice_log_id = $log['id'];
                                    ?>
                                <tr id="row<?php echo $cntr; ?>" class="logrow">
                                    <td align="center">
                                        <?php echo ++$c; ?>
                                        <input type="hidden" id="invoice_log_id<?php print $cntr; ?>" name="invoice_log_id[<?php print $cntr; ?>]" value="<?php echo $invoice_log_id;?>"/>
                                    </td>
                                    <td class="tableDate">
                                        <div class="invoice-right-data"><?php if (!empty($log['task_date'])) { echo date('M d,Y', strtotime($log['task_date'])); }else{echo "---";}?></div>
                                    </td>
                                    <td class="desc_ig">
                                        <div class="invoice-right-data"><?php if (!empty($log['description'])) {echo $log['description'];}else{echo "---";}?></div>
                                    </td>                        
                                    <td>
                                        <div class="invoice-right-data">
                                                <?php if (!empty($log['total_hours'])) {echo $log['total_hours'];}else{echo "---";} ?>
                                        </div>                      
                                    </td>
                                    <td>
                                        <div class="invoice-right-data">
                                            <?php if (!empty($log['rate']) && $log['rate'] != 0) { echo $log['rate'];}else{echo "---";} ?>
                                        </div>
                                    </td>
                                    <td class="amount-align">
                                        <?php $grandTotal += floatval($log['total_hours']) *  floatval($log['rate']);        
                                        print '<span id="cost_edit_total_hours' . $cntr . '">' . $this->format->format_price(floatval($log['total_hours']) * floatval($log['rate'])) . '</span>';
                                        ?>
                                    </td>
                                </tr>
                            <?php $cntr++; ?>
                            <?php } ?>
                        <?php } ?>
                            
                            <tr style="background:#fff;">
                                <td colspan="4" class="bdr_zero"> <div class="pull-right"><label class="fld-name"><?php echo __('Subtotal');?></label></div></td>
                                <td colspan="2" class="amount-align"><div class="amount subtotal-align" style="border:none;"><span id="cost_edit_total_hours"><?php print $this->format->format_price($grandTotal); ?></span></div></td>
                                <td class="bdr_zero"></td>
                            </tr>
                            
                            <tr style="background:#fff;">
                                <td colspan="3"  class="bdr_zero">
                                    <div class="fl discnt_frm_ig"><label class="fld-name"><?php echo __('Discount');?></label></div>									
                                    <div class="amount amt_nw fr">
                                        <?php echo $i['Invoice']['discount_type'];?>
                                    </div>
                                </td>
                                <td colspan=""  class="bdr_zero">
                                    <?php print floatval($i['Invoice']['discount']); ?>
                                </td>
                                <td colspan="2" class="amount-align"> 
                                    <span id="total-discount">
                                    <?php $grandDiscount = $this->format->format_price(($i['Invoice']['discount_type'] != 'Flat') ? (($grandTotal * floatval($i['Invoice']['discount'])) / 100) : ( floatval($i['Invoice']['discount'])));
                                        print $grandDiscount;
                                    ?>
                                    </span>
                                </td>
                                <td class="bdr_zero"></td>
                            </tr>
                            
                            <tr style="background:#fff;">
                                <td colspan="3"  class="bdr_zero">
                                    <label class="fld-name"><?php echo __('Tax');?> (%)</label>                                    
                                </td>
                                <td colspan=""  class="bdr_zero">
                                    <?php print floatval($i['Invoice']['tax']); ?>
                                </td>
                                <td colspan="2" class="amount-align"><span id="total-tax"><?php $trandTax=$this->format->format_price((($grandTotal-$grandDiscount) * floatval($i['Invoice']['tax'])) / 100);print $trandTax;?></span></td>
                                <td class="bdr_zero"></td>
                            </tr>  
                            <tr style="background:#fff;">
                                <td colspan="4"  class="bdr_zero">
                                    <div class="pull-right"><label class="fld-name"><?php echo __('Total Amount');?> (<?php if($i['Invoice']['currency']!=''){print $i['Invoice']['currency'];}else{echo "USD";}?>)</label></div>
                                </td>
                                <td colspan="2" class="amount-align">
                                    <span id="final_edit_total_hours"><?php print $this->format->format_price(($grandTotal-$grandDiscount + $trandTax)); ?></span>
                                    <script>
                                    $(".b_due").find(".inv_price").html('<?php print $this->format->format_price(($grandTotal-$grandDiscount + $trandTax)); ?>');
                                    </script>
                                </td>
                                <td class="bdr_zero"></td>
                            </tr>
                    </table>                   
                </div>
            </div>
            <div>
                <div class="row not_term_ig">
                    <div class="col-sm-12" style="padding:0px;">
                            <div class="col-sm-6">
                                    <label><?php echo __('Message displayed on invoice');?></label><br />
                                    <?php if (!empty($i['Invoice']['notes'])) {echo $i['Invoice']['notes'];}else{echo '---';}?>
                            </div>
                            <div class="col-sm-6">
                                    <label><?php echo __('Memo');?></label><br />
                                    <?php if (!empty($i['Invoice']['terms'])) { echo $i['Invoice']['terms']; }else{echo '---';} ?>
                            </div>
                            <div class="cb"></div>
                    </div>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</form>        
<div class="cb"></div>
<div class="foot_btn_ig">
    <div class="InvoiceDownloadEmail fl" style="display: block;" >        
        <div class=" relative" style="left:35%;">
            <div class="mr20 fl relative inv_bts">
                <?php $invoice_id =  intval($i['Invoice']['id']);?>
                <button class="btn btn_blue mr0 fl no-border-radius saveInvoice" id="emailInvoice" onclick="sendInvoiceEmail('<?php echo $invoice_id;?>');" title="Send Email"><?php echo __('Send');?></button>
                <div class="fl invoice-extra-block relative">
                    <button class="btn toggle-invoice-opts fl no-border-radius" onclick="$('#btn_invoice_munu').toggle();"><i class="caret"></i></button>
                </div>
                <ul class="btn_invoice_munu noprint" id="btn_invoice_munu">
                    <li class="" style="">
                            <a onclick="javascript:buildInvoicePdf('<?php echo $invoice_id;?>');" class="anchor btn btn_blue no-border-radius mr0 saveInvoice"><?php echo __('Download');?></a>
                        </li>
                    </ul>
                <div class="cb"></div>
            </div>
            <span class="or_cancel cancel_on_direct_pj">or <a class="anchor" id="cancelInvoice" onclick="cancelInvoice();" title="Cancel"><?php echo __('Cancel');?></a></span>            
        </div>
    </div>
</div>
        
<script type="text/javascript">
    $(document).ready(function() { 
        
        var terms = [0,15,30,60];
        //alert(invoices.date_diff($('#edit_issue_date').val(),$('#edit_due_date').val()))
        if($.inArray(invoices.date_diff($('#edit_issue_date').val(),$('#edit_due_date').val()),terms)>-1){
            $('#invoice_terms_disp').html(invoices.date_diff($('#edit_issue_date').val(),$('#edit_due_date').val()));
        }
    });
</script>