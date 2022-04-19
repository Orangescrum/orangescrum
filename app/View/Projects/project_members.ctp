<?php 
$time = array();
$uids = array();
$id = 0;
$timezone_id = 0;
$days = 5;

if(isset($selecteduser['DailyUpdate']) && !empty($selecteduser['DailyUpdate'])){
    $id = $selecteduser['DailyUpdate']['id'];
	if($tm_format['User']['time_format'] == 12){
		$times = array();
	$time_db =  $selecteduser['DailyUpdate']['notification_time'];
	
	$times = date("g:i A", strtotime("$time_db"));
	$time = preg_split( "/[: ]/", $times );
	}else{
		$time = explode(":", $selecteduser['DailyUpdate']['notification_time']);
	}
    
    $uids = explode(",", $selecteduser['DailyUpdate']['user_id']);
    $days = $selecteduser['DailyUpdate']['days'];
}
$timezone_id = isset($selecteduser['DailyUpdate']['timezone_id']) ? $selecteduser['DailyUpdate']['timezone_id'] : SES_TIMEZONE;
?>
<?php if(isset($projectuser) && !empty($projectuser)){ ?>
<tr id="tr_members">
    <!--<th>Users:</th>-->
   <td>
	 <p ><?php echo __('Users') ;?>: </p> <?php echo $time['2']; ?>
	 <div class="mtop10">
	 <div class="checkbox">
	<label class="userLbl"><input type="checkbox"  id="user_all" <?php if(isset($uids) && !empty($uids) && (count($uids)==count($projectuser))){ ?>checked="checked" <?php }elseif(count($uids) == 0){?>checked="checked" <?php }?> onclick="checkUncheckAll(1);" style="cursor: pointer;" />&nbsp;&nbsp;<?php echo __('All');?></label></div></div>
	<input type="hidden"  id="daily_update_id" value="<?php echo $id;?>" />
	<table cellspacing="0" cellpadding="0" class="projectMemberCls" style="width:100%">
    	<tbody>
	    <?php
		$cnt = 0;
		foreach($projectuser as $key => $value) {
	    ?>
	    <?php if(($cnt%3) == 0){ ?>
	    <tr>
	    <?php } $cnt++;
		$name = trim($value['User']['name']);
		if(strlen($name) <= 10)
		    $name = $value['User']['name'];
		else
		    $name = trim(substr($value['User']['name'],0,7))."...";
	    ?>
		<td>
				<div class="checkbox">
		    <label class="userLbl" title="<?php echo $value['User']['name'];?>"><input type="checkbox" name="data[Project][user][]" class="prj_users" onclick="checkUncheckAll(0);" style="cursor: pointer;" id="userId_<?php echo $value['User']['uniq_id'];?>" value="<?php echo $value['User']['uniq_id'];?>" <?php if(count($uids) > 0 && (in_array($value['User']['id'],$uids))){ ?>checked="checked" <?php }elseif(count($uids) == 0){?>checked="checked" <?php }?> />&nbsp;&nbsp;<?php echo ucfirst($name);?></label></div>
		</td>
	    <?php if(($cnt%3) == 0){ ?>
	    </tr>
	     <?php }?>
	    <?php } ?>
    	</tbody>	    
	</table>
    </td>
</tr>
<tr id="tr_time">
    <!--<th>Alert Time: </th>-->
    <td>
		<p><?php echo __('Alert Time');?>:</p>
	<?php $hour = array("1"=>"01","2"=>"02","3"=>"03","4"=>"04","5"=>"05","6"=>"06","7"=>"07","8"=>"08","9"=>"09","10"=>"10","11"=>"11","12"=>"12","13"=>"13","14"=>"14","15"=>"15","16"=>"16","17"=>"17","18"=>"18","19"=>"19","20"=>"20","21"=>"21","22"=>"22","23"=>"23","24"=>"24");
	    $hour_am_pm = array("1"=>"01","2"=>"02","3"=>"03","4"=>"04","5"=>"05","6"=>"06","7"=>"07","8"=>"08","9"=>"09","10"=>"10","11"=>"11","12"=>"12");
		$minute = array("0","15","30","45");
		$am_pm = array("1"=>"AM","2"=>"PM");
	?>
	
<div class="row mtop15">
<?php if($tm_format['User']['time_format'] == 12){ ?>
	<div class="col-lg-4 col-sm-4 col-xs-4">
<div class="opt_field"><?php echo __('Hour(s)');?><span style="color:red"> *</span></div>
	<div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder upd_hour">
	<select name="data[Project][hour]" class="select form-control mod-wid-153 fl" id="upd_hour">
	    <option value="-1">--<?php echo __('Select');?>--</option>
	    <?php foreach($hour_am_pm as $key => $value){ ?>
		<option value="<?php echo $key;?>" <?php if(isset($time) && isset($time['0']) && !empty($time) && ($time['0']==$value)){?>selected="selected"<?php }?>><?php echo $value;?></option>
	    <?php } ?>
	</select>
	</div>
</div>
<div class="col-lg-4 col-sm-4 col-xs-4">
<div class="opt_field"><?php echo __('Minute(s)');?><span style="color:red"> *</span></div>
	<div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder upd_minute">
	<select name="data[Project][minute]" id="upd_minute" class="select form-control mod-wid-153 min_mgt fl">
	    <option value="-1">--<?php echo __('Select');?>--</option>
	    <?php foreach($minute as $key => $value){ ?>
		<option value="<?php echo $value;?>" 
		<?php if(isset($time) && isset($time['1']) && !empty($time) && ($time['1']==$value)){?>
		selected="selected"<?php }?>>
		<?php echo $value <= 9 ?'0'.$value:$value; ?>
		</option>
	    <?php } ?>
	</select>
	</div>
</div>
<div class="col-lg-4 col-sm-4 col-xs-4">
<div class="opt_field"><?php echo __('AM/PM');?><span style="color:red"> *</span></div>
	<div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder upd_minute">
	<select name="data[Project][am]" id="upd_ampm"  class="select form-control mod-wid-153 min_mgt fl">
	    <option value="-1">--<?php echo __('Select');?>--</option>
	   
		<?php foreach($am_pm as $key => $value){ ?>
		<option value="<?php echo $value;?>" 
		<?php if(isset($time) && isset($time['2']) && !empty($time) && ($time['2']==$value)){?>
		selected="selected"<?php }?>>
		<?php echo $value;?>
		</option>
	    <?php } ?>
	</select>
	</div>
 </div>
<div class="cb"></div>

<?php }else { ?>


<div class="col-lg-6 col-sm-6 col-xs-6">
<div class="opt_field"><?php echo __('Hour(s)');?><span style="color:red"> *</span></div>
	<div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder upd_hour">
	<select name="data[Project][hour]" class="select form-control mod-wid-153 fl" id="upd_hour">
	    <option value="-1">--<?php echo __('Select');?>--</option>
	    <?php foreach($hour as $key => $value){ ?>
		<option value="<?php echo $key;?>" <?php if(isset($time) && isset($time['0']) && !empty($time) && ($time['0']==$value)){?>selected="selected"<?php }?>><?php echo $value;?></option>
	    <?php } ?>
	</select>
	</div>
</div>
<div class="col-lg-6 col-sm-6 col-xs-6">
<div class="opt_field"><?php echo __('Minute(s)');?><span style="color:red"> *</span></div>
	<div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder upd_minute">
	<select name="data[Project][minute]" id="upd_minute" class="select form-control mod-wid-153 min_mgt fl">
	    <option value="-1">--<?php echo __('Select');?>--</option>
	    <?php foreach($minute as $key => $value){ ?>
		<option value="<?php echo $value;?>" <?php if(isset($time) && isset($time['1']) && !empty($time) && ($time['1']==$value)){?>selected="selected"<?php }?>><?php echo $value <= 9 ?'0'.$value:$value; ?></option>
	    <?php } ?>
	</select>
	</div>
</div>
<div class="cb"></div>
<?php } ?>
</div>

    </td>
</tr>
<tr id="tr_timezone">
	<!--<th>Timezone: </th>-->
	<td>
			<p><?php echo __('TimeZone');?>:</p> 
			<div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder">
	    <select name="data[Project][timezone_id]" class="tmzn_select form-control dailyUpdate_sel" id="timezone_id">
            <?php /* <option value="0">--Select--</option> */ ?>
		<?php if(isset($timezones)){
		    foreach($timezones as $key => $value){ ?>
		    <option value="<?php echo $value['TimezoneName']['id'];?>" <?php if($timezone_id == $value['TimezoneName']['id']){?>selected="selected"<?php }?>><?php echo $value['TimezoneName']['gmt']; ?> <?php echo $value['TimezoneName']['zone']; ?></option>
		    <?php }
		} ?>
	    </select>
			</div>
	    <span id="loading_sel" style="display: none;"><img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." title="Loading..." /></span>
	</td>
</tr>
<tr id="tr_days">
    <!--<th>Frequency: </th>-->
    <td>
			<p><?php echo __('Frequency');?>:</p>
			<div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder">
				<select name="data[Project][days]" id="frequency" class="repeat_select form-control dailyUpdate_sel">
                    <?php /* <option value="0" <?php if($days == 0){?>selected="selected"<?php }?>>--Select--</option> */ ?>
					<option value="5" <?php if($days == 5){?>selected="selected"<?php }?>><?php echo __('5 days in week');?></option>
                    <option value="6" <?php if($days == 6){?>selected="selected"<?php }?>><?php echo __('6 days in week');?></option>
                    <option value="7" <?php if($days == 7){?>selected="selected"<?php }?>><?php echo __('7 days in week');?></option>
				</select>
			</div>
    </td>
</tr>
<?php } ?>
<script type="text/javascript">
    $(function(){
        var timezone_id = <?php echo $timezone_id ? $timezone_id:0; ?>;
        $('#timezone_id').val(timezone_id);
        var days = <?php echo $days ? $days:0; ?>;
        $('#frequency').val(days);
				
				$('#upd_hour, #upd_minute,#upd_ampm, #timezone_id, #frequency').select2();
				
    });
</script>  