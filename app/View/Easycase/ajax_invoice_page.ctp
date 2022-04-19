<?php $grandTotal = 0; ?>
<style type="text/css">
    .amt_final_block{padding:10px;}
    .amt_final_block.amt{text-align: right;}
    .amt_final_block.lbl{font-weight: bold;  text-align: right;padding:0px; float:right;margin:5px 0 4px;}
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
                    <?php /*?>
                     <img src="<?php echo HTTP_ROOT . 'invoice-logo/' . $i['Invoice']['logo']; ?>" style="max-height:100px;" />
                      <?php */?>
                <?php } else { ?>
                    <img src="<?php echo HTTP_IMAGES; ?>default-invoice-logo.png" style="max-height:100px;" />
                <?php } ?>
            </div>
            <div style="display:none;">
                <input type="file" name="photo[<?php print $i['Invoice']['id'] ?>]" id="photo" onchange="showPreviewImage('photo')" />
                <input type="hidden" name="logophoto" id="logophoto" value="<?php echo $i['Invoice']['logo'];?>"/>
            </div>
            <br/>
            <div class="clearfix"></div>
            <?php print $this->Form->input('invoice_id', array('label' => false, 'type' => 'hidden', 'value' => $i['Invoice']['id'] , 'id' => 'invoice_id')); ?>
            <div class="lft_cnt_ig_frm" >
                <div class="frm_cnt_ig"> 
                    <label class="fld_ttl_ig" style="font-size:20px;"><?php echo __('Billing From');?></label>
                    <textarea id="edit_invoice_from" name="edit_invoice_from" class="form-control" 
                              onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_invoice_from');" ><?php if (!empty($i['Invoice']['invoice_from'])) {echo $i['Invoice']['invoice_from'];}?></textarea>
                </div>
                <div class="frm_cnt_ig">
                    <label class="fld_ttl_ig" style="font-size:20px;"><?php echo __('Customer');?></label>
                    <div id="invoice_customer_opts" class="dropdown option-toggle" style="width: 270px;height: 34px;background: #fff;padding: 7px 6px;">
                        <div class="popt1 anchor" style="height: 22px;" onclick="$('#more_opt1123123').toggle()">
                            <div class="opt1 fl" style="height: 18px; display: inline-block; width: 90%;overflow: hidden;"><?php echo __('Choose a Customer');?></div><i class="caret fr" style="margin:6px;"></i>
                        </div>
                        <input type="hidden" name="invoice_company_name" id="invoice_company_name" value="<?php if (!empty($i['Invoice']['company_name'])) { echo $i['Invoice']['company_name'];}?>">
                        <input type="hidden" name="invoice_customer_id" id="invoice_customer_id" value="<?php if (!empty($i['Invoice']['customer_id'])) { echo $i['Invoice']['customer_id'];}?>">
                        <input type="hidden" name="invoice_customer_email" id="invoice_customer_email" value="<?php if (!empty($i['InvoiceCustomers']['email'])) { echo $i['InvoiceCustomers']['email'];}?>">
                        <input type="hidden" name="invoice_customer_currency" id="invoice_customer_currency" value="<?php if (!empty($i['Invoice']['currency'])) { echo $i['Invoice']['currency'];}?>">
                        <div class="more_opt" id="more_opt1123123" style="display:none;">                            
                            <ul class="" style="display: block;width:270px;  max-height: 250px; overflow-y: auto; overflow-x: hidden;">
                              <?php if($this->Format->isAllowed('Add Customer',$roleAccess)){ ?>
                                <li class="last anchor" style="border-bottom:1px solid #ccc;">
                                    <div><a onclick="invoices.add_customer();" class="anchor" style="color:#06C; font-size:12px; padding-left:0px;">+ <?php echo __('Add New Customer');?></a></div>
                                </li>
                            <?php } ?>
                                <?php if(is_array($customers) && count($customers)>0){?>
                                    <?php foreach($customers as $key => $val){
                                        $customer_details = $val[0]['details']; ?>
                                        <li>
                                            <a class="anchor customer_opts" data-name="<?php echo $val[0]['name'];?>" data-id="<?php echo addslashes($customer_details);?>" 
                                               data-cid="<?php echo $val['InvoiceCustomer']['id'];?>" data-email="<?php echo $val['InvoiceCustomer']['email'];?>"
                                               data-currency="<?php echo $val['InvoiceCustomer']['currency'];?>"
                                               id="opt_customer_<?php echo $val['InvoiceCustomer']['id'];?>">
                                                <?php echo $val[0]['name'];?>
                                            </a>
                                        </li>
                                    <?php }?>
                                <?php }else{?>
                                        <li><a class=""><?php echo __('No Customers found');?></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>                
                <div  class="frm_cnt_ig">
                    <label class="fld_ttl_ig"><?php echo __('Billing To');?></label>
                    <textarea id="edit_invoice_to" name="edit_invoice_to" class="form-control"  
                              onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_invoice_to');" ><?php if (!empty($i['Invoice']['invoice_to'])) { echo $i['Invoice']['invoice_to'];}?></textarea>
                </div>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="rt_cnt_ig_frm">				
                <div class="frm_cnt_ig">
                    <h1><?php echo __('Invoice');?></h1>
                    <table>
                        <tr>
                            <td style="padding-top:0px;">Invoice#:</td>
                            <td  style="padding-top:0px;">
                                <input type="text" name="edit_invoiceNo" id="edit_invoiceNo" class="form-control" value="<?php print $i['Invoice']['invoice_no'];?>" onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_invoiceNo');"  />
                                <?php /*?><b><?php print $i['Invoice']['invoice_no'];?></b><?php */?>
                            </td>
                        </tr>

                        <tr>
                            <td>Terms:</td>
                            <td>
                                <select class="form-control" name="invoice_terms" id="invoice_terms">
                                    <option value=""><?php echo __('Select');?></option>
                                    <option value="0"><?php echo __('Due on receipt');?></option>
                                    <option value="15"><?php echo __('Net 15');?></option>
                                    <option value="30"><?php echo __('Net 30');?></option>
                                    <option value="60"><?php echo __('Net 60');?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                                <td><?php echo __('Invoice Date');?>:</td>
                                <td><input type="text" class="form-control" id="edit_issue_date" name="edit_issue_date" value="<?php if($i['Invoice']['issue_date']>0){print $this->format->get_date($i['Invoice']['issue_date']);} ?>" onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_issue_date');" /></td>
                        </tr>
                        <tr>
                                <td><?php echo __('Due Date');?>:</td>
                                <td><input type="text" class="form-control" id="edit_due_date" name="edit_due_date" value="<?php if($i['Invoice']['due_date']>0){print $this->format->get_date($i['Invoice']['due_date']);}?>" onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_due_date');" /></td>
                        </tr>
                        <?php /*<tr>
                                <th>Default Rate:</th>
                                <td>
                                         <input type="text" id="edit_price" class="form-control" value="<?php print $i['Invoice']['price'];?>" onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_price');"  /> 
                                </td>
                        </tr>*/ ?>
                        <tr>
                            <td colspan="2" class="b_due">
                                <div class="fl" style="text-align:left;"><?php echo __('Balance Due');?></div>
                                <div class="fr">
                                    <span class="inv_currency"><?php if($i['Invoice']['currency']!=''){print $i['Invoice']['currency'];}else{echo "USD";}?></span>
                                    <span class="inv_price"></span>
                                </div>
                                <div class="cb"></div>
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
                            <th style="width:5%;"><?php echo __('Action');?></th>
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
                                        <div class="invoice-right-data">
                                                <input type="text" id="edit_log_date<?php print $cntr; ?>" name="edit_log_date[<?php print $cntr; ?>]" class="form-control border-zero" 
                                                       value="<?php if (!empty($log['task_date'])) { echo date('M d,Y', strtotime($log['task_date'])); }?>" 
                                                       onchange="customEdit('<?php print $invoice_log_id; ?>','edit_log_date<?php print $cntr; ?>');" />
                                        </div>
                                    </td>
                                    <td class="desc_ig">
                                        <div class="invoice-right-data">
                                            <textarea class="form-control edit_description border-zero" id="edit_description<?php print $cntr; ?>" name="edit_description[<?php print $cntr; ?>]" 
                                                      onchange="customEdit('<?php print $invoice_log_id; ?>','edit_description<?php print $cntr; ?>');" ><?php if (!empty($log['description'])) {echo $log['description'];}?></textarea>							
                                        </div>
                                    </td>                        
                                    <td>
                                        <div class="invoice-right-data">
                                                <input type="text" class="form-control border-zero"  id="edit_total_hours<?php print $cntr; ?>" name="edit_total_hours[<?php print $cntr; ?>]" 
                                                       value="<?php if (!empty($log['total_hours'])) {echo $log['total_hours'];} ?>"
                                                       onchange="customEdit('<?php print $invoice_log_id; ?>','edit_total_hours<?php print $cntr; ?>');" /> 
                                        </div>                      
                                    </td>
                                    <td>
                                        <div class="invoice-right-data">
                                            <input type="text" class="form-control border-zero" id="rate_edit_total_hours<?php print $cntr; ?>" name="rate_edit_total_hours[<?php print $cntr; ?>]" 
                                                   value="<?php if (!empty($log['rate']) && $log['rate'] != 0) { echo $this->format->format_price($log['rate'],2,'.',',');} ?>"
                                                   onchange="customEdit('<?php print $invoice_log_id ?>','rate_edit_total_hours<?php print $cntr ?>');" /> 
                                        </div>
                                    </td>
                                    <td class="amount-align">
                                        <?php $grandTotal += floatval($log['total_hours']) *  floatval($log['rate']);        
                                        print '<span id="cost_edit_total_hours' . $cntr . '">' . $this->format->format_price(floatval($log['total_hours']) * floatval($log['rate']),2,'.',',') . '</span>';
                                        ?>
                                    </td>
                                    <td><center><span class="sprite delete anchor" onclick="deleteInvoiceTimeLog(<?php echo $cntr; ?>);"></span></center></td>
                                </tr>
                            <?php $cntr++; ?>
                            <?php } ?>
                            
                    <?php } elseif(is_array($i['log']) && count($i['log'])>0) { ?>
                            <?php $c=0; $cntr=0;
                                foreach ($i['log'] as $log) { ?>
                                <tr id="row<?php echo $cntr; ?>" class="logrow">
                                    <td align="center">
                                        <?php echo ++$c; ?>
                                        <input type="hidden" name="edit_log_id[]" value="<?php echo $log['LogTime']['log_id'];?>"/>
                                    </td>
                                    <td class="tableDate">
                                        <div class="invoice-right-data">
                                                <input type="text" id="edit_log_date<?php print $cntr; ?>" name="edit_log_date[<?php print $cntr; ?>]" class="form-control border-zero" 
                                                       value="<?php if (!empty($log['LogTime']['start_datetime'])) { echo date('M d,Y', strtotime($log['LogTime']['start_datetime']));} ?>" 
                                                       onchange="customEdit('','edit_log_date<?php print $cntr; ?>');" />
                                        </div>
                                    </td>
                                    <td class="desc_ig">
                                        <div class="invoice-right-data">
                                            <textarea class="form-control edit_description border-zero" id="edit_description<?php print $cntr; ?>" name="edit_description[<?php print $cntr; ?>]" 
                                                      onchange="customEdit('','edit_description<?php print $cntr; ?>');" ><?php if (!empty($log['LogTime']['description'])) {echo $log['LogTime']['description'];}?></textarea>							
                                        </div>
                                    </td>                        
                                    <td>
                                        <div class="invoice-right-data">
                                                <input type="text" class="form-control border-zero" id="edit_total_hours<?php print $cntr; ?>" name="edit_total_hours[<?php print $cntr; ?>]" 
                                                       value="<?php if (!empty($log['LogTime']['hours'])) {echo $log['LogTime']['hours'];} ?>"
                                                       onchange="customEdit('','edit_total_hours<?php print $cntr; ?>');" /> 
                                        </div>                      
                                    </td>
                                    <td>
                                        <div class="invoice-right-data">
                                            <input type="text" class="form-control border-zero" id="rate_edit_total_hours<?php print $cntr; ?>" name="rate_edit_total_hours[<?php print $cntr; ?>]" 
                                                   value="" onchange="customEdit('','rate_edit_total_hours<?php print $cntr; ?>');" /> 
                                        </div>
                                    </td>
                                    <td class="amount-align">
                                        <?php print '<span id="cost_edit_total_hours' . $cntr . '"></span>';?>
                                    </td>
                                    <td><center><span class="sprite delete anchor" onclick="deleteInvoiceTimeLog(<?php echo $cntr; ?>);"></span></center></td>
                                </tr>
                            <?php $cntr++; } ?>
                            
                    <?php } else { ?>
                            <?php $c=0; $cntr=0;?>
                                <tr id="row<?php echo $cntr; ?>" class="logrow">
                                    <td align="center">
                                        <?php echo ++$c; ?>
                                    </td>
                                    <td class="tableDate">
                                        <div class="invoice-right-data">
                                            <input type="text" id="edit_log_date<?php print $cntr; ?>" name="edit_log_date[<?php print $cntr; ?>]" class="form-control border-zero" 
                                                       value="" onchange="customEdit('','edit_log_date<?php print $cntr; ?>');" />
                                        </div>
                                    </td>
                         
                                    <td class="desc_ig">
                                        <div class="invoice-right-data">
                                            <textarea class="form-control edit_description border-zero" id="edit_description<?php print $cntr; ?>" name="edit_description[<?php print $cntr; ?>]" 
                                                      onchange="customEdit('','edit_description<?php print $cntr; ?>');" ></textarea>							
                                        </div>
                                    </td>                        
                                    <td>
                                        <div class="invoice-right-data">
                                                <input type="text" class="form-control border-zero" id="edit_total_hours<?php print $cntr; ?>" name="edit_total_hours[<?php print $cntr; ?>]" 
                                                       value="" onchange="customEdit('','edit_total_hours<?php print $cntr; ?>');" /> 
                                        </div>                      
                                    </td>
                                    <td>
                                        <div class="invoice-right-data">
                                            <input type="text" class="form-control border-zero" id="rate_edit_total_hours<?php print $cntr; ?>" name="rate_edit_total_hours[<?php print $cntr; ?>]" 
                                                   value="" onchange="customEdit('','rate_edit_total_hours<?php print $cntr; ?>');" /> 
                                        </div>
                                    </td>
                                    <td class="amount-align">
                                        <?php print '<span id="cost_edit_total_hours' . $cntr . '"></span>';?>
                                    </td>
                                    <td><center><span class="sprite delete anchor" onclick="deleteInvoiceTimeLog(<?php echo $cntr; ?>);"></span></center></td>
                                </tr>
                        <?php } ?>
                            <tr id="addMoretr">
                                <td colspan="6" style="border-bottom:0px; padding:0px; margin:0px;">
                                    <div style="position:relative">
                                        <div style="position:absolute; left:15px; top:10px;"><a href="javascript:void(0);" onclick="addLineItem();" class="addLine">+ Add Line-item</a></div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    <div class="fr" style="width:50%;margin-right:40px;">
                        <div class="fr" style="min-width:31%;">
                            <div class="amt_final_block amt"><div class="amount subtotal-align" style="border:none;"><span id="cost_edit_total_hours"><?php print $this->format->format_price($grandTotal,2,'.',','); ?></span></div></div>
                            <div class="cb"></div>
                            <div class="amt_final_block amt">
                                <span id="total-discount">
                                    <?php
                                    $grandDiscount = $this->format->format_price(($i['Invoice']['discount_type'] != 'Flat') ? (($grandTotal * floatval($i['Invoice']['discount'])) / 100) : ( floatval($i['Invoice']['discount'])),2,'.',',');
                                    print $grandDiscount;
                                    ?>
                                </span>
                            </div>
                            <div class="cb"></div>
                            <div class="amt_final_block amt"><span id="total-tax"><?php $trandTax = $this->format->format_price((($grandTotal - $grandDiscount) * floatval($i['Invoice']['tax'])) / 100,2,'.',',');
                                    print $trandTax; ?></span></div>
                            <div class="cb"></div>
                            <div class="amt_final_block amt">
                                <span id="invoice_currency_code"><?php echo __('USD');?></span>
                                <span id="final_edit_total_hours"><?php print $this->format->format_price(($grandTotal - $grandDiscount + $trandTax),2,'.',','); ?></span>
                                <script>
                                $(".b_due").find(".inv_price").html('<?php print $this->format->format_price(($grandTotal - $grandDiscount + $trandTax),2,'.',','); ?>');
                                </script>
                            </div>
                        </div>
                        <div class="fr">
                            <div class="amt_final_block lbl"><?php echo __('Subtotal');?></div>
                            <div class="cb"></div>
                            <div class="amt_final_block lbl">
                                <div class="amount  fr" style="margin-left:10px;">
                                    <input type="text" style="width:65px;" class="form-control" id="edit_discount" name="edit_discount" value="<?php print $i['Invoice']['discount']; ?>"  onchange="customEdit('<?php print $i['Invoice']['id']; ?>','edit_discount');"  />
                                </div>
                                <div class="amount  fr">
                                    <select class="form-control" name="invoice_discount_type" id="invoice_discount_type" onchange="customEdit('<?php print $i['Invoice']['id']; ?>','edit_discount_type');">
                                        <option value="Percentage" <?php if ($i['Invoice']['discount_type'] != 'Flat') echo "selected='selected'"; ?>><?php echo __('Discount Percent');?></option>
                                        <option value="Flat" <?php if ($i['Invoice']['discount_type'] == 'Flat') echo "selected='selected'"; ?>><?php echo __('Discount Flat');?></option>
                                    </select>
                                </div>
                            </div>

                            <div class="cb"></div>
                            <div class="amt_final_block lbl">
                                <div class="amount  fr" style="margin-left:10px;">
                                    <input type="text" style="width:65px;" class="form-control" id="edit_tax" name="edit_tax" value="<?php print $i['Invoice']['tax']; ?>"  onchange="customEdit('<?php print $i['Invoice']['id']; ?>','edit_tax');"  />
                                </div>
                                <div class="amount  fr" style="padding:10px;"><?php echo __('Tax');?> (%)</div>
                            </div>
                            <div class="cb"></div>
                            <div class="amt_final_block lbl"><?php echo __('Total Amount');?></div>
                        </div>
                        <div class="cb"></div>
                    </div>
                </div>
            </div>
            <div class="cb"></div>
            <div>
                <div class="row not_term_ig">
                    <div class="col-sm-12" style="padding:0px;">
                            <div class="col-sm-6">
                                    <label><?php echo __('Message displayed on invoice');?></label><br />
                                    <textarea class="form-control" id="edit_notes" name="edit_notes" 
                                              onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_notes');" ><?php if (!empty($i['Invoice']['notes'])) {echo $i['Invoice']['notes'];}?></textarea>
                            </div>
                            <div class="col-sm-6">
                                    <label><?php echo __('Memo');?></label><br />
                                    <textarea class="form-control" id="edit_terms" name="edit_terms" 
                                              onchange="customEdit('<?php print $i['Invoice']['id'] ?>','edit_terms');" ><?php if (!empty($i['Invoice']['terms'])) { echo $i['Invoice']['terms']; } ?></textarea>
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
                    <button class="btn btn_blue mr0 fl no-border-radius saveInvoice" id="emailInvoice" onclick="saveInvoice('<?php echo $invoice_id;?>','export_email');" title="Save & Send"><?php echo __('Save & Send');?></button>
                    <div class="fl invoice-extra-block relative">
                        <button class="btn toggle-invoice-opts fl no-border-radius" onclick="$('#btn_invoice_munu').toggle();"><i class="caret"></i></button>
                    </div>
                    <ul class="btn_invoice_munu noprint" id="btn_invoice_munu">
                        <li class="" style="">
                            <a onclick="javascript:saveInvoice('<?php echo $invoice_id;?>','export_pdf');" class="anchor btn btn_blue no-border-radius mr0 saveInvoice"><?php echo __('Save & Download');?></a>
                        </li>
                        <li class="" style="display:list-item;text-align:center;  border-bottom: 1px solid #ccc;">
                            <a onclick="javascript:saveInvoice('<?php echo $invoice_id;?>','close');" class="anchor btn btn_blue no-border-radius mr0 saveInvoice"><?php echo __('Save & Close');?></a>
                        </li>
                        <li class="" style="display:list-item;text-align:center;">
                            <a onclick="javascript:saveInvoice('<?php echo $invoice_id;?>','createnew');" class="anchor btn btn_blue no-border-radius mr0 saveInvoice"><?php echo __('Save & New');?></a>
                        </li>
                    </ul>
                    <div class="cb"></div>
                </div>
                <span class="or_cancel cancel_on_direct_pj">or <a class="anchor" id="cancelInvoice" onclick="cancelInvoice();" title="Cancel"><?php echo __('Cancel');?></a></span>            
            </div>
            
        
        <?php /*?>
        <button class="btn btn_blue fr mr20" id="downloadInvoice" onclick="saveInvoice('#v#','export_pdf');">Save & Download</button>
        <button class="btn btn_blue fl mr0" id="saveInvoice" onclick="saveInvoice('#v#','close');" >Save & Close</button>
        <button class="btn btn_blue fl mr0" id="saveInvoice" onclick="saveInvoice('#v#','createnew');" >Save & New</button> 
         <button class="btn btn_blue fr mr0" id="emailInvoice" onclick="sendInvoiceEmail('#v#');" >Email Invoice</button>
        <button class="btn btn_blue fr mr20" id="downloadInvoice" onclick="buildInvoicePdf('#v#');"  >Download Invoice</button>
         <?php */?>
    </div>
</div>
        
<script type="text/javascript">
    var clone = $('#row0').clone();
    var tot_counter = $('tr[id^="row"]').length;
    function addLineItem() {
        var tot_tr = $('tr[id^="row"]').length;
        var html = clone;
        html.attr('id','row'+tot_counter);
        html.find('td').eq(0).html(parseInt(tot_counter)+1);
        html.find('input,select,li,textarea,span').each(function(){
            var type = this.type || this.tagName.toLowerCase();
            var oldid = $(this).attr('id');
            if(typeof oldid !='undefined'){
                var newid = oldid.replace(/\d+/,tot_counter); 
                $(this).attr('id',newid);
                if(typeof $(this).attr('onchange')!='undefined'){
                    $(this).attr('onchange',"customEdit('','"+newid+"');");
                }
            }
            var oldname = $(this).attr('name');
            if(typeof oldname != 'undefined'){
                var newname = oldname.replace(/\d+/,tot_counter);
                $(this).attr('name',newname);
            }
            if(type == 'span' && typeof $(this).attr('onclick') != 'undefined'){
                    $(this).attr('onclick',"deleteInvoiceTimeLog('"+tot_counter+"');");
            }
        });

        $('#addMoretr').before('<tr id="row'+tot_counter+'" class="logrow">'+html.html()+'</tr>');
        $("#row"+tot_counter).find('input,select,li,textarea,span').each(function(){
            var type = this.type || this.tagName.toLowerCase();
            if(type == 'text' || type == 'textarea'){
                $(this).val('');
            }else if(type=='span'){
                $(this).html('');
            }
        });
        $("#edit_log_date"+tot_counter).datepicker({
            format: 'M dd, yyyy',
            changeMonth: false,
            changeYear: false,
            hideIfNoPrevNext: true,
            autoclose:true,
        });
        tot_counter++;
        //$('#addMoretr').before(html);
        ($('.logrow').size()>1)?$('.logrow').find('.delete').show():'';
    }
    function customEdit(pk,iname){
        if(iname == "edit_due_date" || iname == "edit_issue_date" || iname.indexOf("edit_log_date")>-1){
            if($('#'+iname).val() != '' && new Date($('#'+iname).val())=='Invalid Date'){
                $('#'+iname).val('');
                return false;
            }            
        }
        if(iname == 'edit_invoiceNo'){
            $('#'+iname).val($('#'+iname).val().replace(/[^a-zA-Z0-9\-\_]+/g,''));
        }
        if(iname.indexOf('edit_total_hours')>-1 || iname.indexOf('rate_edit_total_hours')>-1 || iname == 'edit_discount' || iname == 'edit_tax'){
            $('#'+iname).val($('#'+iname).val()<0?0-$('#'+iname).val():$('#'+iname).val());
        }
        if(iname.indexOf('rate_edit_total_hours')>-1){
            $('#'+iname).val(number_format($('#'+iname).val(),2));
        }
        var val = $('#'+iname).val();
        change_more(pk,iname,val);
        /*if(pk>0){
            $.post('<?php print $this->Html->url(array('controller' => 'invoices', 'action' => 'editInvoice')); ?>',{pk:pk,name:iname,value:val},function(res){
                change_more(pk,iname,val);
            });
        }else{
            change_more(pk,iname,val);
        }*/
    }
    
    function change_more(pk,iname,val){
        if(iname=='edit_invoiceNo'){
            $('.newInvoice').find('.fl').html(val); 
        }else if(iname.indexOf("edit_log_date") === 0 || iname.indexOf("edit_description") === 0){
        }else{
                //console.log(pk+' >> '+iname+' >> '+val)
                if(iname=='edit_price'){
                    $("[id^='rate_edit_total_hours']").val(val);
                    $("[id^='edit_total_hours']").each(function() {
                        uid = $(this).attr('id');
                        t = !isNaN($(this).val()) ? parseFloat($(this).val()) : 0;
                        $('#cost_' + uid).html(number_format(parseFloat(t)*parseFloat(val),2));
                    });
                }else{
                    if(iname.indexOf("edit_total_hours") === 0 || iname.indexOf("rate_edit_total_hours") === 0){
                        var amount = 0; var uid = '';
                        if(iname.indexOf("edit_total_hours") === 0){
                                p = $('#rate_'+iname).val().replace(/[,]+/g,'');
                                uid = 'cost_' + $('#'+iname).attr('id');
                                isNaN(val) ? $('#'+iname).val(0) : (trim(val) != '' ? $('#'+iname).val(parseFloat(val)) : $('#'+iname).val(''));
                        }else if(iname.indexOf("rate_edit_total_hours") === 0){
                                p = $('#' + $('#'+iname).attr('id').replace("rate_", "")).val();
                                uid = $('#'+iname).attr('id').replace("rate_", "cost_");
                                val = val.replace(/[,]+/g,'');
                                isNaN(val) ? $('#'+iname).val(0) : (trim(val) != '' ? $('#'+iname).val(number_format(val,2)) : $('#'+iname).val(''));
                        }
                        amount = !isNaN(val) && !isNaN(p) && $.trim(val)!='' && $.trim(p)!='' ? (parseFloat(val) * parseFloat(p)).toFixed(2) : 0;
                        $("#"+uid).html(number_format(amount,2));
                    }else if(iname=='edit_discount' || iname == 'edit_tax'){
                        isNaN(val) ? $('#'+iname).val(0) : (trim(val) != '' ? $('#'+iname).val(parseFloat(val).toFixed(2)) : $('#'+iname).val(''));
                    }                    
                }
                updateTotalcost();
        }
    }
                
    function showPreviewImage(imgId) {
        $('#loader').show();
        var imgName = $('#photo').val();
        prevUrl = "<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'invoiceLogo')) ?>"
        $.ajaxFileUpload({
            url: prevUrl,
            secureuri: false,
            fileElementId: imgId,
            dataType: 'json',
            complete: function(data, status) {
                //console.log(data.responseText);
                var data = $.parseJSON(data.responseText);
                if(data.msg == "exceeds"){
                        showTopErrSucc('error',"<?php echo __('File size exceeds 2MB');?>.");
                        return false;
                }
                //var z = data.responseText.replace(new RegExp("<div(.*)</div>"), '');
                //if (z.indexOf('.') > 0) {
                
                if (data.success == 'yes') {
                    $('#logophoto').val(data.msg);
                    $('#loader').hide();
                    //$("#preview").html("<img src='<?php print HTTP_ROOT; ?>/invoice-logo/" + z + "' height='100'>");
                    $("#preview").html("<img src='" + data.url + "' height='100'>");
                } else {
                    $('#loader').hide();
                    $("#preview").html(data.msg);
                }
            }
        });

    }

    function  updateTotalcost() {
        var total = 0;
        var eachval = 0;
        $("[id^='cost_edit_total_hours']").not("#cost_edit_total_hours").each(function() {
            eachval = $(this).html().replace(/[,]+/g,'');
            total = (parseFloat(total) + (!isNaN(eachval) && $.trim(eachval)!='' ? parseFloat(eachval) : 0));
        });

        total = !isNaN(total) ? total.toFixed(2) : 0;
        /*set subtotal*/
        $("#cost_edit_total_hours").html(number_format(total,2));
        
        discount = !isNaN($("#edit_discount").val()) && $.trim($("#edit_discount").val())!='' ? parseFloat($("#edit_discount").val()) : 0;
        discountamount = (total * discount) > 0 ? ($('#invoice_discount_type').val()!='Flat' ? ((total * discount) / 100).toFixed(2) : discount) : 0;
        /*set discount val*/
        $('#total-discount').html(number_format(discountamount,2));
        
        tax = !isNaN($("#edit_tax").val()) && $.trim($("#edit_tax").val())!='' ? parseFloat($("#edit_tax").val()) : 0;
        taxamount=((total - discountamount)*tax) > 0 ? (((total - discountamount)*tax) / 100).toFixed(2) : 0;
        
        /*set tax amount*/
        $('#total-tax').html(number_format(taxamount,2));
        $("#final_edit_total_hours").html(number_format(parseFloat(total-discountamount) + parseFloat(taxamount),2));
        $(".b_due").find(".inv_price").html(number_format(parseFloat(total-discountamount) + parseFloat(taxamount),2));
    }
    function deleteInvoiceTimeLog(v) {
        //alert(v)
        if (confirm('Are you sure you want to delete this time log ?')) {
            var invoice_log_id = typeof $('#invoice_log_id' + v).val() != 'undefined' ? $('#invoice_log_id' + v).val() : '';
            if(invoice_log_id == ''){
                $('#row' + v).remove();
                updateTotalcost();
                ($('.logrow').size()<2)?$('.logrow').find('.delete').hide():'';
                return false;
            }
            $.post('<?php echo $this->Html->url(array('controller' => 'invoices', 'action' => 'deleteInvoiceTimeLog')) ?>', {v: invoice_log_id}, function(res) {
                if (parseInt(res) != 0) {
                    $('#row' + v).remove();
                    updateTotalcost();
                    ($('.logrow').size()<2)?$('.logrow').find('.delete').hide():'';
                }
            });
        }
    } 
    $(document).ready(function() { 
        /*set customer email and name*/
        ($('.logrow').size()<2)?$('.logrow').find('.delete').hide():'';
        if($('#invoice_customer_id').val()!=''){
            $obj = $("#opt_customer_"+$('#invoice_customer_id').val());
            $("#invoice_customer_opts").find('.opt1').html($obj.attr('data-name'));
            $("#invoice_customer_email").val($obj.attr('data-email'));
            $("#invoice_currency_code").html(''+($obj.attr('data-currency')!=''?$obj.attr('data-currency'):'USD')+'');
            $("#invoice_customer_currency").val(($obj.attr('data-currency')!=''?$obj.attr('data-currency'):'USD'));
            $(".inv_currency").html(($obj.attr('data-currency')!=''?$obj.attr('data-currency'):'USD'));
        }
        var terms = [0,15,30,60];
        //alert(invoices.date_diff($('#edit_issue_date').val(),$('#edit_due_date').val()))
        if($.inArray(invoices.date_diff($('#edit_issue_date').val(),$('#edit_due_date').val()),terms)>-1){
            $('#invoice_terms').val(invoices.date_diff($('#edit_issue_date').val(),$('#edit_due_date').val()));
        }else{
            $('#invoice_terms').val('<?php echo $i['Invoice']['invoice_term']?>');
        }
        
        $('.customer_opts').live('click',function(){
            invoices.set_invoice_to_details($(this));
        });
        $('#invoice_terms').change(function(){
            invoices.set_due_date($("#edit_issue_date").val());
        });
        $('#invoice_div textarea').autogrow();
        $("#edit_issue_date").datepicker({
            format: 'M dd, yyyy',
            changeMonth: false,
            changeYear: false,
            hideIfNoPrevNext: true,
            autoclose:true,
        }).on("changeDate", function(){
            var dateText = $("#edit_issue_date").datepicker('getFormattedDate');
            $("#edit_due_date").datepicker("setStartDate", dateText);
        });
        $("#edit_due_date").datepicker({
            format: 'M dd, yyyy',
            changeMonth: false,
            changeYear: false,
            hideIfNoPrevNext: true,
            autoclose:true,
        }).on("changeDate", function(){
            
        });
        $("#edit_due_date").datepicker( "option", "minDate", $("#edit_issue_date").val());

        $("[id^='edit_log_date']").datepicker({
            format: 'M dd, yyyy',
            changeMonth: false,
            changeYear: false,
            hideIfNoPrevNext: true,
            autoclose:true,
        });
        $("#edit_due_date,#edit_issue_date,input[id^='edit_log_date']").change(function(){
            if(new Date($(this).val())=='Invalid Date'){
                $(this).val('');
            }else{
                $(this).val(formatDate('M dd, yy',$(this).val()));
            }            
        });
    });
</script>