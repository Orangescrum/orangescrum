<tr id="row<?php echo $log['id']; ?>"> 
	<td align="center"><?php echo $tot_tr; ?></td>
    <td class="tableDate">                                        
		<div class="invoice-right-data">
			<input type="text" class="form-control" id="edit_log_date<?php print $log['id'] ?>" value=" <?php echo date('M d,Y', strtotime($log['task_date'])); ?> " onchange="customEdit('<?php print $log['id'] ?>','edit_log_date<?php print $log['id'] ?>');" />                                            
		</div>
    </td>
    <td  class="desc_ig">
		<div class="invoice-right-data">
			<textarea class="form-control" id="edit_description<?php print $log['id']; ?>" onchange="customEdit('<?php print $log['id'] ?>','edit_description<?php print $log['id'] ?>');"  ></textarea> 
		</div>		
    </td>                        
    <td>
		<div class="invoice-right-data">
			<input type="text" class="form-control" id="edit_total_hours<?php print $log['id']; ?>" value=""
                   onchange="customEdit('<?php print $log['id'] ?>', 'edit_total_hours<?php print $log['id'] ?>');" /> 
		</div>                                 
    </td>
    <td>
        <div class="invoice-right-data">
            <input type="text" class="form-control"  id="rate_edit_total_hours<?php print $log['id']; ?>" 
                   value="<?php if(!empty($log['rate']) && $log['rate'] != 0) { echo $log['rate'];}?>"
                   onchange="customEdit('<?php print $log['id'] ?>', 'rate_edit_total_hours<?php print $log['id'] ?>');" />
        </div>
    </td>
    <td class="amount-align">
        <?php
        $grandTotal += floatval($log['total_hours']) * floatval($log['rate']);
        print '<span id="cost_edit_total_hours' . $log['id'] . '">' . $this->format->format_price(floatval($log['total_hours']) * floatval($log['rate'])) . '</span>';
        ?>
    </td>
    <td><a href="javascript:void(0);" onclick="deleteInvoiceTimeLog(<?php echo $log['id']; ?>);"><span class="sprite no"></span></a></td>
</tr>
<script>
$(document).ready(function() { 
	$('textarea').autogrow();
	$("[id^='edit_log_date']").datepicker({
		format: 'M d, yyyy',
		changeMonth: false,
		changeYear: false,
		hideIfNoPrevNext: true,
        autoclose:true
	});
});
</script>