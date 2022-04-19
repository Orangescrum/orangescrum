<div class="timelog-table" id='showUnbilled' style="border:0px;">
    <div class="timelog-table-head">
        <div>
            <div class="fl">
                <span class="time-log-head"><?php echo __('Invoice');?></span>              
            </div>
            <div class="fr"></div>
            <div class="cb"></div>
        </div>

</div>
<div class="timelog-detail-tbl m-cmn-flow">       
	<table cellpadding="3" cellspacing="4" class="m-invoice-table">
		<tr>     
            <th style="width:15%">
                <a title="Invoice #" onclick="invoices.ajaxSorting('invoices', 'invoice', this);" class="anchor">
                    <div class="fl"><?php echo __('Invoice');?> #</div><div class="tsk_sort fl <?php if($order_by=='invoice' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                </a>
            </th>
            <th style="width:15%">
                <a title="Invoice Date" onclick="invoices.ajaxSorting('invoices', 'invoice_date', this);" class="anchor">
                    <div class="fl"><?php echo __('Invoice Date');?></div><div class="tsk_sort fl <?php if($order_by=='invoice_date' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                </a>
            </th>
            <th style="width:25%">
                <a title="Customer" onclick="invoices.ajaxSorting('invoices', 'customer', this);" class="anchor">
                    <div class="fl"><?php echo __('Customer');?></div><div class="tsk_sort fl <?php if($order_by=='customer' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                </a>
            </th>
            <th style="width:15%">
                <a title="Due Date" onclick="invoices.ajaxSorting('invoices', 'due_date', this);" class="anchor">
                    <div class="fl"><?php echo __('Due Date');?></div><div class="tsk_sort fl <?php if($order_by=='due_date' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                </a>
            </th>
            <th style="width:15%" class="align_center">
                <a title="Amount" onclick="invoices.ajaxSorting('invoices', 'amount', this);" class="anchor">
                    <div class="fl"><?php echo __('Amount');?></div><div class="tsk_sort fl <?php if($order_by=='amount' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                </a>
            </th>   
            <th style="width:10%" class="align_center"><?php echo __('Action');?></th>
    </tr>
    <?php if (!empty($inv)) { ?>
        <?php foreach ($inv as $invoice) { ?>
        <tr id="invoice_list<?php echo $invoice['Invoice']['id']; ?>" data-no="<?php echo $invoice['Invoice']['invoice_no']; ?>">
            <td> <a class="anchor" <?php if($this->Format->isAllowed('Edit Invoice',$roleAccess)){ ?> onclick='showInvoicePage(<?php echo $invoice['Invoice']['id']; ?>,"<?php echo $invoice['Invoice']['invoice_no']; ?>");' <?php } ?> ><?php echo $invoice['Invoice']['invoice_no']; ?></a></td>
            <td> <?php echo $this->Format->get_date($invoice['Invoice']['issue_date']); ?></td>
            <td> <?php echo trim($invoice[0]['customer_name'])!=''? $invoice[0]['customer_name']:'---'; ?></td>
            <?php /*?><td><?php $name = $this->Format->getUserDtls($invoice['Invoice']['user_id']);echo $name['User']['name']; ?></td><?php */?>
            <td><?php echo $this->Format->get_date($invoice['Invoice']['due_date']); ?></td>
            <td class="align_right"><?php echo $this->Format->format_price($invoice['Invoice']['price']);?></td>
            <td style="text-align:center;padding-left:2%;">
            <?php if($this->Format->isAllowed('Email Invoice',$roleAccess)){ ?>
                <span class="sprite email anchor fl tooltip" title="<?php echo __('Email');?>" onclick="invoices.opt_list_action('email','<?php print $invoice['Invoice']['id']?>','<?php print $invoice['Invoice']['customer_id']?>');"></span>
            <?php } ?>
            <?php if($this->Format->isAllowed('Download or Print Invoice',$roleAccess)){ ?>
                <span class="sprite download anchor fl tooltip" title="<?php echo __('Download');?>" onclick="invoices.opt_list_action('download','<?php print $invoice['Invoice']['id']?>');"></span>
            <?php } ?>
                <?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1) {?>
                <?php /*?><span class="sprite print anchor fl" title="Print" onclick="invoices.opt_list_action('print','<?php print $invoice['Invoice']['id']?>');"></span><?php */?>
                 <?php if($this->Format->isAllowed('Delete Invoice',$roleAccess)){ ?>
                    <span class="sprite delete anchor fl tooltip" title="<?php echo __('Delete');?>" onclick="deleteInvoice(<?php print $invoice['Invoice']['id']?>);"></span>
                <?php } ?>
                <?php } ?>
            </td>
		</tr>
        <?php } ?>
    <?php } else { ?>
          <tr><td colspan="6"> <?php echo __('No records');?>......</td></tr>
    <?php } ?>
   </table>
</div>

    <?php if ($caseCount > 0) { ?>
        <div class="cb"></div>
        <div id='show_invoice_paginate'></div>

        <script type="text/javascript">
            pgShLbl = '<?php echo $this->Format->pagingShowRecords($caseCount, $page_limit, $casePage); ?>';
            var pageVars = {pgShLbl:pgShLbl,csPage:<?php echo $casePage; ?>,page_limit:<?php echo $page_limit; ?>,caseCount:<?php echo $caseCount; ?>};
            //console.log(pageVars);
            $("#show_invoice_paginate").html(tmpl("paginate_tmpl", pageVars)).show(); 
        </script>
        <div class="cb"></div>
    <?php } ?>

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.tooltip').tipsy({gravity:'s',fade:true});
    });
    function deleteInvoice(v){
        if(confirm('Are you sure you want to delete this invoice ?')){
            $.post('<?php echo $this->Html->url(array('controller'=>'invoices','action'=>'deleteInvoice'));?>',{v:v},function(res){
                if(parseInt(res) != 0){
                    showTopErrSucc('success', '<?php echo __("Invoice deleted successfully");?>.');
                    invoices.switch_tab('invoice');
                }else{
                    showTopErrSucc('error',  '<?php echo __("Invoice not deleted");?>.');
                }
            });
        }
    }

        
</script>