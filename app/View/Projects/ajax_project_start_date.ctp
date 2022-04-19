<li>
    <a href="javascript:void(0);">
        <input type="radio" name="duedate_filter" id="defect_duedate_any" class="cbox_date" style="cursor:pointer" checked="" onclick="defectCheckboxdueDate('any', 'check');filterRequest('duedate');" checked="checked"> <font onclick="checkboxdueDate('any', 'text');dFilterRequest('defect_due_date');">&nbsp;<?php echo __("Anytime");?></font> </a>
</li>
<li>
    <a href="javascript:void(0);">
        <input type="radio" name="duedate_filter" id="defect_duedate_overdue" class="cbox_date" style="cursor:pointer" onclick="defectCheckboxdueDate('overdue', 'check');filterRequest('duedate');"> <font onclick="defectCheckboxdueDate('overdue', 'text');dFilterRequest('defect_due_date');">&nbsp;<?php echo __("Overdue");?></font> </a>
</li>
<li>
    <a href="javascript:void(0);">
        <input type="radio" name="duedate_filter" id="defect_duedate_24" class="cbox_date" style="cursor:pointer" onclick="defectCheckboxdueDate('24', 'check');filterRequest('duedate');"> <font onclick="defectCheckboxdueDate('24', 'text');dFilterRequest('defect_due_date');">&nbsp;<?php echo __("Today");?></font> </a>
</li>
<li>
    <a href="javascript:void(0);">
        <input type="radio" name="duedate_filter" id="defect_duedate_custom" class="cbox_date" style="cursor:pointer" onclick="defectCheckboxCustom('defect_custom_duedate', 'defect_duedate_custom', 'defect_due');"> <font onclick="defectCheckboxCustom('defect_custom_duedate', 'defect_duedate_custom', 'defect_due');">&nbsp;<?php echo __("Custom range");?></font> </a>
</li>
<div id="defect_custom_duedate" style="display: none;">
    <div class="cdate_div_cls">
        <input type="text" id="defect_duefrm" value="" placeholder="<?php echo __("From");?>" class="form-control" readonly="true">
        <br>
        <input type="text" id="defect_dueto" value="" placeholder="<?php echo __("To");?>" class="form-control" readonly="true"> </div>
    <div class="cduedate_btn_div" style="text-align:center;margin-top: 5px;cursor:pointer">
        <button class="btn btn-primary cdate_btn" style="cursor: pointer;" onclick="return defectSearchduedate();"><?php echo __("Search");?></button>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#defect_duefrm").datepicker({
            dateFormat: 'M d, yy',
            changeMonth: false,
            changeYear: false,
            //minDate: 0,
            hideIfNoPrevNext: true,
            //maxDate: "0D",
            onClose: function (selectedDate) {
                $("#defect_dueto").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#defect_dueto").datepicker({
            dateFormat: 'M d, yy',
            changeMonth: false,
            changeYear: false,
            //minDate: 0,
            hideIfNoPrevNext: true,
            //maxDate: "0D",
            onClose: function (selectedDate) {
                $("#defect_duefrm").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
</script>