<div class="timelog-table" style="border:0px none;">
    <div class="timelog-table-head">
            <div class="fl"><span class="time-log-head"><?php echo __('Unbilled Time');?></span></div>
            <div class="fl" style="margin:5px 0 5px 25px;"><?php echo __('Total Billable');?>: <?php echo $this->Format->format_time_hr_min($total_hours);?></div>
            <?php if($this->Format->isAllowed('Create Invoice',$roleAccess)){ ?>
            <div class="fr mr5 relative" style="">
                <?php echo $this->Form->button('Create Invoice', array('type' => 'button', 'class' => 'btn btnaddto invoice-btn fl no-border-radius', 'onclick' => 'addToInvoice();','disabled'=>'disabled')); ?>
                <span class="invoice-extra-block">
                    <button class="btn toggle-invoice-opts fl no-border-radius"><i class="caret"></i></button>
                    <ul class="dropdown-menu crt-invoice-menu noprint">
                        <li class="" style="display:list-item;text-align:center;">
                            <a onclick="javascript:showInvoicePage('','New Invoice','new');" class="anchor create-invoice-without-unbilled-time" ><?php echo __('Create Invoice without Unbilled Time');?></a>
                        </li>
                    </ul>
                </span>
            </div>
        <?php } ?>
    </div>
    <div class="cb"></div>
    <div class="timelog-detail-tbl m-cmn-flow">
        <?php echo $this->Form->create('Invoice', array('type' => 'post')); ?>        
        <table cellpadding="3" cellspacing="4" class="m-invoice-table">
            <tr>
                <th style="width:5%" class="align_center"><?php echo $this->Form->checkbox('ids', array('hiddenField' => false, 'value' => '1', 'id' => 'ids')); ?></th>
                <th style="width:10%">
                    <a title="Date" onclick="invoices.ajaxSorting('timelog', 'date', this);" class="anchor">
                        <div class="fl"><?php echo __('Date');?></div><div class="tsk_sort fl <?php if($order_by=='date' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                    </a>
                </th>
                <th style="width:10%">
                    <a title="Resource" onclick="invoices.ajaxSorting('timelog', 'resource', this);" class="anchor">
                        <div class="fl"><?php echo __('Resource');?></div><div class="tsk_sort fl <?php if($order_by=='resource' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                    </a>                    
                </th>
                <th style="width:15%">
                    <a title="Task" onclick="invoices.ajaxSorting('timelog', 'task', this);" class="anchor">
                        <div class="fl"><?php echo __('Task');?></div><div class="tsk_sort fl <?php if($order_by=='task' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                    </a>
                </th>
                <th style="width:15%"><?php echo __('Description');?></th>
                <th style="width:10%">
                    <a title="Type" onclick="invoices.ajaxSorting('timelog', 'type', this);" class="anchor">
                        <div class="fl"><?php echo __('Type');?></div><div class="tsk_sort fl <?php if($order_by=='type' && $order_sort != ''){echo 'tsk_'.strtolower($order_sort);}?>"></div>
                    </a>
                </th>
                <th style="width:10%" class="align_center"><?php echo __('Start');?></th>
                <th style="width:10%" class="align_center"><?php echo __('End');?></th>
                <th style="width:10%" class="align_center"><?php echo __('Hours');?></th>
                <th style="width:5%"><?php echo __('Billable');?></th>
                
            </tr>
            <?php if (!empty($logtimes)) { ?>
                <?php foreach ($logtimes as $log) { ?>
                    <tr>
                        <?php 
                            $start_datetime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $log['LogTime']['start_datetime'], "datetime"); 
                            $end_datetime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $log['LogTime']['end_datetime'], "datetime"); 
                        ?>
                        <td class="align_center"><?php echo $this->Form->checkbox('ids', array('hiddenField' => false, 'value' => $log['LogTime']['log_id'], 'id' => 'ids' . $log['LogTime']['log_id'], 'class' => 'checkbox1 invoicechkbox')); ?></td>
                        <td><?php echo $this->format->get_date($start_datetime); ?></td>
                        <td><?php echo $log[0]['name']; ?></td>
                        <td <?php if(!empty($log['Easycase']['title'])){ print 'rel="tooltip"'; }?> title="<?php echo $log['Easycase']['title'];?>">
                            <?php echo $this->Format->frmtdata($log['Easycase']['title'],0,20); ?>
                        </td>
                        <td title="<?php echo $log['LogTime']['description']; ?>" <?php if(!empty($log['LogTime']['description'])){ ?> rel="tooltip" <?php } ?> ><?php echo $this->Format->frmtdata($log['LogTime']['description'],0,20); ?></td>
                        <td><?php echo $log['Type']['name']; ?></td>
                        
                        <td class="align_center"><?php echo $this->format->get_time($start_datetime); ?></td>
                        <td class="align_center"><?php echo $this->format->get_time($end_datetime); ?></td>
                        <td class="align_center"><?php echo $this->Format->format_time_hr_min($log['LogTime']['total_hours'],'hrmin'); ?></td>
                        <td style="text-align: center;"><span <?php if ($log['LogTime']['is_billable']) { ?> class="sprite yes" <?php } else { ?> class="sprite no" <?php } ?> style="left:25%;" ></span></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="12"><?php echo __('No records');?>......</td>
                </tr>
            <?php } ?>
            </table>
            <div class="cb"></div>
              <?php if($this->Format->isAllowed('Create Invoice',$roleAccess)){ ?>
            <div class="fr mr5 relative">
                <?php echo $this->Form->button('Create Invoice', array('type' => 'button', 'class' => 'btn btnaddto invoice-btn fl no-border-radius', 'onclick' => 'addToInvoice();','disabled'=>'disabled')); ?>
                <span class="invoice-extra-block">
                    <button class="btn toggle-invoice-opts fl no-border-radius"><i class="caret"></i></button>
                    <ul class="dropdown-menu crt-invoice-menu noprint">
                        <li class="" style="display:list-item;text-align:center;">
                            <a onclick="javascript:showInvoicePage('','New Invoice','new');" class="anchor create-invoice-without-unbilled-time"><?php echo __('Create Invoice without Unbilled Time');?></a>
                        </li>
                    </ul>
                </span>
            </div>
        <?php } ?>
            <div class="cb"></div>
            <?php echo $this->Form->end(); ?>
        </div>
    <div>
    <input type="hidden" id="getcasecount" value="<?php echo $caseCount; ?>" readonly="true"/>
    <?php if ($caseCount > 0) { ?>
        <div class="cb"></div>
        <div id='showUnbilled_paginate'></div>

        <script type="text/javascript">
            pgShLbl = '<?php echo $this->Format->pagingShowRecords($caseCount, $page_limit, $casePage); ?>';
            var pageVars = {pgShLbl:pgShLbl,csPage:<?php echo $casePage; ?>,page_limit:<?php echo $page_limit; ?>,caseCount:<?php echo $caseCount; ?>};
            //console.log(pageVars);
            $("#showUnbilled_paginate").html(tmpl("paginate_tmpl", pageVars)).show(); 
        </script>
        <div class="cb"></div>
    <?php } ?>
        <input type="hidden" id="totalcount" name="totalcount" value="<?php echo $count; ?>"/> 

        <div class="fl crt-task">
            <span><!-- Log time for this task --></span>
        </div>
        <div class="fr ht_log">
            <!--
            <span class="fl">Hide time log</span>
            <a href=""><span class="fl sprite up-btn"></span></a>
            -->
        </div>
        <div class="cb"></div>
    </div>

</div>
<script>
  $(document).ready(function() {        
        $('#ids').click(function(event) {  //on click
            if (this.checked) { // check select status
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = true;  //select all checkboxes with class "checkbox1"              
                });
            } else {
                $('.checkbox1').each(function() { //loop through each checkbox
                    this.checked = false; //deselect all checkboxes with class "checkbox1"                      
                });
            }
        });
        var checkboxes = $("input[type='checkbox']");       
        checkboxes.click(function() {  
            if($('.checkbox1').not(':checked').length > 0){                
                document.getElementById('ids').checked=false;
            }else{ 
                document.getElementById('ids').checked=true;
            }
            $('.btnaddto').attr("disabled", ! $('.checkbox1').is(":checked"));
             if(! $('.checkbox1').is(":checked")){  
                $('.btnaddto').removeClass('btn_blue');
             }else{
                 $('.btnaddto').addClass('btn_blue');
             }
        });
    });    
</script>