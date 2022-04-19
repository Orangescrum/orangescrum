<style type="text/css">
.cmn-popup #taskcsvForm .form-group.label-floating.is-focused label.control-label, .cmn-popup #taskcsvForm .form-group.label-floating:not(.is-empty) label.control-label, .cmn-popup #taskcsvForm .form-group.label-static label.control-label, .inv-sett-section #taskcsvForm .form-group.custom-drop-lebel label.control-label {
	top: -10px;
}
</style>
<?php
$url = "/easycases/exportTaskcsv";
echo $this->Form->create('Easycase', array('name' => 'taskcsvForm', 'id' => 'taskcsvForm', 'url' => $url, 'onsubmit' => "return validateCsvForm();"));
?>  
<div class="modal-body popup-container">
    <center><div id="exportTaskcsv_msg" class="err_msg"></div></center>
    <!--<center><div style="color: #639FED;font-size: 12px;padding: 5px;">Maximum of 1500 tasks can be exported at a time. You can use the below filters to export accordingly.</div></center>-->
     <div class="form-group" id="tr_active">
         <label class="control-label" style="display:block;"><?php echo __('Project Status');?></label>

            <!--<span class="radio radio-primary custom-rdo">
                <label style="padding-left:27px;">
                  <input name="data[Easycase][is_active]" id="is_activeId_0" value="0"  type="radio" onclick="project_change(this)"><span class="circle"></span><span class="check"></span>
                  All
                </label>

            </span>-->
            <span class="radio radio-primary custom-rdo">
               <label style="padding-left:27px;">
                <input name="data[Easycase][is_active]" id="is_activeId_1" value="1" checked type="radio" onclick="project_change(this)"><span class="circle"></span><span class="check"></span>
                <?php echo __('Active');?>
              </label>
            </span>
            <span class="radio radio-primary custom-rdo">
               <label style="padding-left:27px;">
                <input name="data[Easycase][is_active]" id="is_activeId_2" value="2"  type="radio" onclick="project_change(this)"><span class="circle"></span><span class="check"></span>
                <?php echo __('Completed');?>
              </label>
            </span>
    </div>
    <div class="form-group" >
        <select id="changeProject"  name="data[Easycase][project]" class="select form-control floating-label" placeholder="Project" data-dynamic-opts=true  <?php if (intval($is_milestone)) { ?>onchange="change_milestone(this);change_member_assignto(this);milestone_export();"<?php } else { ?>onchange="change_member_assignto(this);"<?php } ?>>
                <option value="0"><?php echo __('All');?></option>
            <?php if (isset($projArr)) { ?>
                <?php foreach ($projArr as $prj) { ?>
                    <option value="<?php echo $prj['Project']['id']; ?>" <?php if ($prj['Project']['uniq_id'] == $uniq_id) { ?>selected="selected"<?php } ?>><?php echo ucfirst($prj['Project']['name']); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div> 
    <?php if (intval($is_milestone)) { ?>
        <div class="form-group" id="milestone_dv">
            <select name="data[Easycase][milestone]" class="select form-control floating-label" placeholder="Task Group" data-dynamic-opts=true  onchange="milestone_export(this);" id="exportcsv_milestone">
                <option value=""><?php echo __('All');?></option>
                <?php if (isset($milestones)) { ?>
                    <?php foreach ($milestones as $key => $milestone) { ?>
                        <option value="<?php echo $key; ?>"><?php echo ucfirst($milestone); ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
    <?php } ?>
    <div class="form-group">
        <?php
            $Date = $_COOKIE['DATE'];
            $cst_rng = explode(":", $Date);
            ?>
            <select name="data[Easycase][date]" id="csv_date" class="select form-control floating-label" placeholder="Date" data-dynamic-opts=true onchange="showCustomRange(this);">
                <option value="all" <?php if (trim($Date) == '' && !strstr(trim($Date), ":")) { ?>selected="selected"<?php } ?>><?php echo __('Any time');?></option>
                <option value="1" <?php if (trim($Date) == 'one') { ?>selected="selected"<?php } ?>><?php echo __('Past hour');?></option>
                <option value="24" <?php if (trim($Date) == '24') { ?>selected="selected"<?php } ?>><?php echo __('Past 24 hours');?></option>
                <option value="week" <?php if (trim($Date) == 'week') { ?>selected="selected"<?php } ?>><?php echo __('Past week');?></option>
                <option value="month" <?php if (trim($Date) == 'month') { ?>selected="selected"<?php } ?>><?php echo __('Past month');?></option>
                <option value="year" <?php if (trim($Date) == 'year') { ?>selected="selected"<?php } ?>><?php echo __('Past year');?></option>
                <option value="cst_rng" <?php if (count($cst_rng) == 2) { ?>selected="selected"<?php } ?>><?php echo __('Custom range');?></option>
            </select>
    </div>
    <div class="row time_range_fld  padlft-non padrht-non"  id="tr_cst_rng" style="<?php if (count($cst_rng) == 2) { ?>display: show;<?php } else { ?>display:none;<?php } ?>">
        <div class="col-lg-6 ">
            <div class="form-group  label-floating">
                <label class="control-label" for="cst_frm">From</label>
                <input type="text" id="cst_frm" name="data[Easycase][from]" value="<?php if (count($cst_rng) == 2) echo $cst_rng['0']; ?>" class="form-control" placeholder="" />
            </div>
        </div>
        <div class="from_to">to</div>
        <div class="col-lg-6">
            <div class="form-group  label-floating">
                <label class="control-label blank-label1" for="cst_to"><?php echo __('To');?></label>
                <input type="text" id="cst_to" name="data[Easycase][to]" value="<?php if (count($cst_rng) == 2) echo $cst_rng['1']; ?>" class="form-control" placeholder="" />
            </div>
        </div>
    </div>
    <div class="form-group" id="tr_export_sts_dropdown">
        <?php $status = $_COOKIE['STATUS']; ?>
        <select name="data[Easycase][status]" class="select form-control floating-label" placeholder="Status" data-dynamic-opts=true id="export_sts_dropdown">
            <option value="all" <?php if (!$status || strstr($status, "all")) { ?>selected="selected"<?php } ?>><?php echo __('All');?></option>
			<?php if(!$is_uniq_proj_selected){ ?>
				<option value="1" <?php if (strstr($status, "1")) { ?>selected="selected"<?php } ?>><?php echo __('New');?></option>
				<option value="2" <?php if (strstr($status, "2")) { ?>selected="selected"<?php } ?>><?php echo __('In Progress');?></option>            
				<option value="5" <?php if (strstr($status, "5")) { ?>selected="selected"<?php } ?>><?php echo __('Resolved');?></option>
				<option value="3" <?php if (strstr($status, "3")) { ?>selected="selected"<?php } ?>><?php echo __('Closed');?></option>
			<?php } ?>
			<?php 
				//custom sttaus
				if($csts_arr){
					foreach($csts_arr as $sk => $sv){
			?>
						<option value="<?php echo $sv['id']; ?>" <?php if (strstr($status, $sv['id'])) { ?>selected="selected"<?php } ?>><?php echo $sv['name'];?></option>
			<?php
					}
				}
			?>
            <option value="attach" <?php if (strstr($status, "attch")) { ?>selected="selected"<?php } ?>><?php echo __('Files');?></option>
            <option value="update" <?php if (strstr($status, "upd")) { ?>selected="selected"<?php } ?>><?php echo __('Updates');?></option>
        </select>
    </div>
    <div class="form-group">
        <?php $types = $_COOKIE['CS_TYPES']; ?>
        <select name="data[Easycase][types]" class="select form-control floating-label" placeholder="Types" data-dynamic-opts=true>
            <option value="all" <?php if (!$types || trim($types) == 'all') { ?>selected="selected"<?php } ?>><?php echo __('All');?></option>
            <?php foreach ($typeArr as $key => $value) { ?>
                <option value="<?php echo $value['types']['id']; ?>" <?php if (trim($types) == $value['types']['id']) { ?>selected="selected"<?php } ?>><?php echo $value['types']['name']; ?></option>
            <?php } ?>
        </select>
    </div>
	 <div class="form-group">
        <select name="data[Easycase][label]" class="select form-control floating-label" placeholder="Label" data-dynamic-opts=true>
            <option value="all" <?php if (!$lblsArr || trim($lblsArr) == 'all') { ?>selected="selected"<?php } ?>><?php echo __('All');?></option>
            <?php foreach ($lblsArr as $key => $value) { ?>
                <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="form-group" id="tr_priority">
        <?php $priority = $_COOKIE['PRIORITY']; ?>
        <select name="data[Easycase][priority]" class="select form-control floating-label" placeholder="Priority" data-dynamic-opts=true>
            <option value="all" <?php if (!$priority || trim($priority) == 'all') { ?>selected="selected"<?php } ?>><?php echo __('All');?></option>
            <option value="2" <?php if (trim($priority) == 'Low') { ?>selected="selected"<?php } ?>><?php echo __('Low');?></option>
            <option value="1" <?php if (trim($priority) == 'Medium') { ?>selected="selected"<?php } ?>><?php echo __('Medium');?></option>
            <option value="0" <?php if (trim($priority) == 'High') { ?>selected="selected"<?php } ?>><?php echo __('High');?></option>
        </select>
    </div>
    <div class="form-group"  id="tr_members">
        <select name="data[Easycase][members]" class="select form-control floating-label" placeholder="Members" data-dynamic-opts=true>
             <option value="all"><?php echo __('All');?></option>
             <?php if (isset($memArr)) { ?>
                 <?php foreach ($memArr as $mem) { ?>
                    <?php $members = explode("-", $_COOKIE['MEMBERS']); ?>
                    <option value="<?php echo $mem['User']['id']; ?>" <?php if (in_array($mem['User']['id'], $members)) { ?>selected="selected"<?php } ?>><?php echo ucfirst($mem['User']['name']); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
    <div class="form-group" id="tr_assign_to">
        <select name="data[Easycase][assign_to]" class="select form-control floating-label" placeholder="<?php echo __('Assign to');?>" data-dynamic-opts=true>
            <option value="all"><?php echo __('All');?></option>
            <?php if (isset($asnArr)) { ?>
                <?php foreach ($asnArr as $Asn) { ?>
                  <?php  $Asnbers = explode("-", $_COOKIE['ASSIGNTO']);?>
                    <option value="<?php echo $Asn['User']['id']; ?>" <?php if (in_array($Asn['User']['id'], $Asnbers)) { ?>selected="selected"<?php } ?>><?php echo ucfirst($Asn['User']['name']); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
    <div class="form-group" id="tr_milestone_list">
        <select name="data[Easycase][milestone]" class="select form-control floating-label" placeholder="Task Group" data-dynamic-opts=true id="milestone_list">
            <option value="all"><?php echo __('All');?></option>
            <?php if (isset($milestone)) { ?>
                <?php foreach ($milestone as $key => $Asn) { ?>
                    <option value="<?php echo $key; ?>" ><?php echo ucfirst($Asn); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
    <div class="form-group" id="tr_comment">
        <select name="data[Easycase][comment]" class="select form-control floating-label" placeholder="Comments" data-dynamic-opts=true id="commentId">
            <option value="1"><?php echo __('Without Comment');?></option>
            <option value="2"><?php echo __('With Comment');?></option>
        </select>
</div>  
</div>
<div class="modal-footer">
    <div class="fr popup-btn">
        <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
        <span class="fl hover-pop-btn"><button type="submit" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Export CSV');?></button></span>
        <div class="cb"></div>
    </div>
</div>
<?php echo $this->Form->end(); ?>

<script>
    $(function() {
        $("#cst_to").datepicker({
            format: 'M d, yyyy',
            changeMonth: false,
            changeYear: false,
            startDate: 0,
            hideIfNoPrevNext: true,
            autoclose:true,
        }).on("changeDate", function(){
            var dateText = $("#cst_to").datepicker('getFormattedDate');
            $("#cst_frm").datepicker("setEndDate", dateText);
        });
        $("#cst_frm").datepicker({
            format: 'M d, yyyy',
            changeMonth: false,
            changeYear: false,
            startDate: 0,
            hideIfNoPrevNext: true,
            autoclose:true,
        }).on("changeDate", function(){
            var dateText = $("#cst_frm").datepicker('getFormattedDate');
            $("#cst_to").datepicker("setStartDate", dateText);
        });
    });


    $("#ui-datepicker-div").click(function(e) {
        e.stopPropagation();
    });
    function project_change(obj){
        $.post(HTTP_ROOT+'projects/getProjectDropdown',{v:$(obj).val()},function(res){
					$('#changeProject').html(res);  
					//$('#changeProject').show().next('.dropdownjs').remove(); 
					//$('#changeProject').show().next('label').next('.dropdownjs').remove();
					$.material.init();
					//$("#changeProject").dropdown({ "autoinit" : "#changeProject"});
           $("#changeProject").select2();
        });
    }
    function milestone_export(obj) {
        if (typeof obj == 'undefined') {
            obj = $('#exportcsv_milestone');
        }
        if ($(obj).val()) {
            $('#taskcsvForm').attr('action', HTTP_ROOT + "easycases/exporttoCSV_Milestone")
        } else {
            $('#taskcsvForm').attr('action', HTTP_ROOT + "easycases/exportTaskcsv");
        }
    }
    function validateCsvForm() {
        var done = 1;
        if ($("#csv_date option:selected").val() == 'cst_rng') {
            var start_date = document.getElementById('cst_frm');
            var end_date = document.getElementById('cst_to');
            var errMsg;
            if (Date.parse(start_date.value) > Date.parse(end_date.value)) {
                errMsg = "<?php echo __('From Date cannot exceed To Date');?>!";
                end_date.focus();
                done = 0;
            } else if (start_date.value.trim() == "") {
                errMsg = "<?php echo __('From Date cannot be left blank');?>!";
                start_date.focus();
                done = 0;
            } else if (end_date.value.trim() == "") {
                errMsg = "<?php echo __('End Date cannot be left blank');?>!";
                end_date.focus();
                done = 0;
            }

            if (done == 0) {
                //$("#exportTaskcsv_msg").html(errMsg);
                showTopErrSucc('error', errMsg);
                return false;
            }
        }
        if (done == 1) {
            closePopup();
            return true;
        } else {
            return false;
        }
    }
</script>
