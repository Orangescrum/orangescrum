
<!-- <div class="fr filter_dt filter_analytics timelog-cal">
	<div class="task_due_dt">
		<div class="fl icon-date-filter"></div>
		<div class="fl">
			<input type="text" class="smal_txt" placeholder="From Date" readonly  style="width:115px;height:34px;" id="logstrtdt" value="<?php echo $frm; ?>"/> <span>-</span>
			<input type="text" class="smal_txt" placeholder="To Date" readonly style="width:115px;height:34px;" id="logenddt" value="<?php echo $to; ?>"/>
		</div>
		<div class="fl" style="margin-left:10px;">
		<select class="form-control" id="rsrclog">
		<option value="">Select Resource</option>
		<?php foreach($rsrclist as $uid=>$uname) { ?>
			<option value="<?php echo $uid; ?>"><?php echo $uname; ?></option>
		<?php } ?>
		</select>
		</div>
		<div class="fl apply_button">
			<div id="apply_btn" class="fl">
				<button class="btn btn_blue aply_btn" type="button" style="height:34px;" onclick= "showtimelog('datesrch');" value="Update" name="submit_Profile" id="submit_Profile">Search</button>
			</div>
		</div>
		
	</div>
</div> -->
<div class="cb"></div>
<div id="timelogloader" style="display:none;">
	<div class="loadingdata" style="background:#F0C36D;position:fixed;left:50%"><img src="<?php echo HTTP_IMAGES; ?>ajax-loader.gif" title="loading..."/> <?php echo __('Loading');?>...</div>
</div>
<div class="timelog-table" id="timelogtbl">
<?php echo $this->element('timelog'); ?>
</div>

</div>

<style>
.timelog-table{width:97%;border:1px solid #ccc;}
.timelog-table-head{margin:10px 5px 0px 5px;}
.timelog-table-head .time-log-head{font-size: 23px;font-weight: bold;color:#444;}
.logmore-btn a{width:150px;
				height:40px;
				color:#fff;
				background-color:#3FBA8B;
				font-size:14px;
				border-radius:5px;
				display: block;
				padding:6px;
				line-height: 29px;
				text-align: center;
				text-decoration:none;} 
.timelog-table-head .spent-time{margin:5px 0 10px;}
.spent-time .total{font-size:16px;color:#444;}
.spent-time .use-time{font-size:14px;color:#8E8E8E;}	
.timelog-table .timelog-detail-tbl table {width:100%;}
.timelog-table .timelog-detail-tbl th{background-color:#F3F3F3;font-size:13px;color:#222;padding:10px 0px 8px 10px; border-top:1px solid #CCC; font-weight:normal;  text-align: left;}	
.timelog-table .timelog-detail-tbl td{border:1px solid #ccc;padding:8px 0px 8px 10px; }
.timelog-table .timelog-detail-tbl table  tr:hover { background-color: #ffff99;}
.crt-task{font-size:14px;color:#558DD8;margin-left:10px; padding: 5px 0;}
.ht_log{padding: 5px 0;}
.sprite{background:url(../img/sprite.png)no-repeat;
		position:relative;
		display:block;
		width:20px;
		height:20px;}
.sprite.btn-clock{ background-position: 0px -63px;left:0;top:-23px;}
.sprite.yes{background-position:2px -40px;left:-6px;top:0}
.sprite.no{background-position:2px -20px;left:-6px;top:0}
.sprite.up-btn{background-position: 2px -80px;left:-2px;top:0;}
.sprite.note{ background-position:2px 0;left:8px;top:0;}
.icon-date-filter{
background: url("../img/sprite_osv2.png") no-repeat scroll -341px -166px transparent;
    height: 27px;
    margin-right: 10px;
    width: 28px;
}
</style>

<script type="text/javascript">
$(document).ready(function(){
	$("#logstrtdt").datepicker({
			dateFormat: 'M d, yy',
			changeMonth: false,
			changeYear: false,
			hideIfNoPrevNext: true,
			onClose: function( selectedDate ) {
				$("#logenddt").datepicker( "option", "minDate", selectedDate );
			},
	    });
	$("#logenddt").datepicker({
			dateFormat: 'M d, yy',
			changeMonth: false,
			changeYear: false,
			hideIfNoPrevNext: true,
			onClose: function( selectedDate ) {
				$("#logstrtdt").datepicker( "option", "maxDate", selectedDate );
			},
	    });
});
</script>
