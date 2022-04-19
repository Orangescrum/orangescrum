<li>
    <a href="javascript:void(0);">
	<input type="radio"  name="duedate_filter" id="duedate_any" class='cbox_date' style="cursor:pointer" <?php if(trim($due_date) == '' && !strstr(trim($due_date),":" )){echo "checked";} ?> onClick="checkboxdueDate('','check');filterRequest('duedate');"/>
	<font onClick="checkboxdueDate('any','text');filterRequest('duedate');" >&nbsp;<?php echo __('Anytime');?></font>
    </a>
</li>

<!--<li>
    <a href="javascript:void(0);">
	<input type="radio"  name="duedate_filter" id="duedate_one" class='cbox_date' style="cursor:pointer" <?php if(trim($due_date) == 'one'){echo "checked";} ?> onClick="checkboxdueDate('one','check');filterRequest('duedate');"/>
	<font onClick="checkBox('duedate_one');checkboxdueDate('one','text');filterRequest('duedate');" >&nbsp;Past hour</font>
    </a>
</li>-->
<li>
    <a href="javascript:void(0);">
	<input type="radio"  name="duedate_filter" id="duedate_overdue" class='cbox_date' style="cursor:pointer" <?php if(trim($due_date) == 'overdue'){echo "checked";} ?> onClick="checkboxdueDate('overdue','check');filterRequest('duedate');"/>
	<font onClick="checkboxdueDate('overdue','text');filterRequest('duedate');" >&nbsp;<?php echo __('Overdue');?></font>
    </a>
</li>
<li>
    <a href="javascript:void(0);">
	<input type="radio"  name="duedate_filter" id="duedate_24" class='cbox_date' style="cursor:pointer" <?php if(trim($due_date) == '24'){echo "checked";} ?> onClick="checkboxdueDate('24','check');filterRequest('duedate');"/>
	<font onClick="checkboxdueDate('24','text');filterRequest('duedate');" >&nbsp;<?php echo __('Today');?></font>
    </a>
</li>
<!--<li>
    <a href="javascript:void(0);">
	<input type="radio"  name="duedate_filter" id="duedate_month" class='cbox_date' style="cursor:pointer" <?php if(trim($due_date) == 'month'){echo "checked";} ?> onClick="checkboxdueDate('month','check');filterRequest('duedate');"/>
	<font onClick="checkBox('duedate_month');checkboxdueDate('month','text');filterRequest('duedate');" >&nbsp;Next month</font>
    </a>
</li>
<li>
    <a href="javascript:void(0);">
	<input type="radio"  name="duedate_filter" id="duedate_year" class='cbox_date' style="cursor:pointer" <?php if(trim($due_date) == 'year'){echo "checked";} ?> onClick="checkboxdueDate('year','check');filterRequest('duedate');"/>
	<font onClick="checkBox('duedate_year');checkboxdueDate('year','text');filterRequest('duedate');" >&nbsp;Next year</font>
    </a>
</li>-->
<?php if(strstr(trim($due_date),":")){
 $dt=explode(":",trim($due_date));
 $duefrm = date('M d, Y',strtotime($dt['0']));
 $dueto = date('M d, Y',strtotime($dt['1']));
}
?>
<li>
    <a href="javascript:void(0);">
		<input type="radio"  name="duedate_filter" id="duedate_custom" class='cbox_date' style="cursor:pointer" <?php echo "onClick=\"checkboxcustom('custom_duedate','duedate_custom','due');\""; if($dt){?> checked="checked"<?php } ?> />
		<font onClick="checkboxcustom('custom_duedate','duedate_custom','due');" >&nbsp;<?php echo __('Custom range');?></font>
    </a>
</li>
<div id="custom_duedate" <?php if(!$dt){?>style="display:none;"<?php }?> >
	<div  class="cdate_div_cls">
		<input type="text" id="duefrm"  value='<?php echo $duefrm;?>' placeholder="From" class="form-control"/><br/>
		<input type="text" id="dueto" value='<?php echo $dueto;?>' placeholder="To" class="form-control" />
	</div>
	<div  class="cduedate_btn_div" style="text-align:center;margin-top: 5px;cursor:pointer">
		<button class="btn btn-primary cdate_btn" style="cursor: pointer;"  onclick="return searchduedate();"><?php echo __('Search');?></button>
	</div>
</div>
<script>
$(function() {
	$( "#duefrm" ).datepicker({
		format: 'M d, yyyy',
		changeMonth: false,
		changeYear: false,
		//minDate: 0,
		hideIfNoPrevNext: true,
		//maxDate: "0D",
		autoclose:true
    }).on("changeDate", function(){
        var dateText = $("#duefrm").datepicker('getFormattedDate');
        $("#dueto").datepicker( 'setStartDate', dateText );
    });
});
$(function() {
	$( "#dueto" ).datepicker({
		format: 'M d, yyyy',
		changeMonth: false,
		changeYear: false,
		//minDate: 0,
		hideIfNoPrevNext: true,
		//maxDate: "0D",
		autoclose:true
    }).on("changeDate", function(){
        var dateText = $("#dueto").datepicker('getFormattedDate');
        $("#duefrm").datepicker( 'setEndDate', dateText );
    });
});


$("#ui-datepicker-div").click(function(e){
	e.stopPropagation();
});
function searchduedate(){
	var fduedate =$.trim($('#duefrm').val());
	var tduedate = $.trim($('#dueto').val());
	if(fduedate==''){
		showTopErrSucc('error', '<?php echo __("From Date cannot be left blank");?>!');
		$('#duefrm').focus();return false;
	}else if(tduedate==''){
		showTopErrSucc('error', '<?php echo __("To Date cannot be left blank");?>!');
		$('#dueto').focus();return false;
	}else if(Date.parse(fduedate) > Date.parse(tduedate)) {
		showTopErrSucc('error', '<?php echo __("From Date cannot exceed To Date");?>!');
		$('#duefrm').focus();return false;
	}else{
		var x = fduedate + ":" + tduedate;
		$('#casedueDateFil').val(x);
		remember_filters('DUE_DATE',encodeURIComponent(x));
		filterRequest('duedate');
	}
}
</script>