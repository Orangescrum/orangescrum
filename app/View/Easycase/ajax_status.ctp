<input type="text" name="search_user" id="project_status_searcht" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php
if(isset($query_All)){
	$CookieStatus = (string)$CookieStatus;
	if(isset($pageload) && $pageload == 0){
	    $default = 1;
	    if(strstr($CookieStatus,"1") || strstr($CookieStatus,"2") || strstr($CookieStatus,"3") || strstr($CookieStatus,"4") || strstr($CookieStatus,"5") || strstr($CookieStatus,"attch") || strstr($CookieStatus,"upd") || in_array('1',$last) || in_array('2',$last) || in_array('3',$last) || in_array('4',$last) || in_array('5',$last) || in_array('attch',$last) || in_array('upd',$last)){
		$default = 1;
	    }
	    if((!$CookieStatus || $CookieStatus == "all") && !$last){
		$default = 0;
	    }
	}else {
	    $CookieStatus = "all";
	    $default = 0;
	}
	$disabled = "";
	if($_COOKIE['CURRENT_FILTER'] == 'closecase') {
	    $disabled = "disabled='disabled'";
	}
	?>
	
	<li class="li_check_radio">
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="status_all" <?php if($default == 0 || !last) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxStatus('status_all','check');filterRequest('status');" <?php echo $disabled; ?>/> <?php echo __('All');?> (<?php echo $query_All; ?>)
		  </label>
		</div>
	</li>
	<?php if($projuniq == 'all' || count($custom_status) == 0){?>
	<li class="li_check_radio"> 
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="status_close" <?php if(strstr($CookieStatus,"3") || in_array('3',$last)) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxStatus('status_close','check');filterRequest('status');" <?php echo $disabled; ?>/> <?php echo __('Closed');?> (<?php echo $query_Close; ?>)
		  </label>
		</div>
	</li>
	<li class="li_check_radio">
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="status_new" <?php if(strstr($CookieStatus,"1") || in_array('1',$last)) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxStatus('status_new','check');filterRequest('status');" <?php echo $disabled; ?>/> <?php echo __('New');?> (<?php echo $query_New; ?>)
		  </label>
		</div>
	</li>
	<li class="li_check_radio">    
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="status_open" <?php if(strstr($CookieStatus,"2") || in_array('2',$last)) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxStatus('status_open','check');filterRequest('status');" <?php echo $disabled; ?>/> <?php echo __('In Progress');?> (<?php echo $query_Open; ?>)
		  </label>
		</div>
	</li>
	<li class="li_check_radio">
	  	<div class="checkbox">
		  <label>
			<input type="checkbox" id="status_resolve" <?php if(strstr($CookieStatus,"5") || in_array('5',$last)) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxStatus('status_resolve','check');filterRequest('status');" <?php echo $disabled; ?>/> <?php echo __('Resolved');?> (<?php echo $query_Resolve; ?>)
		  </label>
		</div>
	</li>
	<?php /*<li class="li_check_radio">
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="status_file" <?php if(strstr($CookieStatus,"attch") || in_array('attch',$last)) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxStatus('status_file','check');filterRequest('status');"/> <?php echo __('Files');?> (<?php echo $query_Attch; ?>)
		  </label>
		</div>
	</li>
	
	<li class="li_check_radio">
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="status_upd" <?php if(strstr($CookieStatus,"upd") || in_array('upd',$last)) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxStatus('status_upd','check');filterRequest('status');" <?php echo $disabled; ?>/> <?php echo __('Updates');?> (<?php echo $query_Upd; ?>)
		  </label>
		</div>		
	</li> */ ?>
<?php
}
}
if(count($custom_status) > 0){ 
	foreach($custom_status as $k=>$v){ ?>
	<li class="li_check_radio">
		<div class="checkbox">
		  <label>
			<input type="checkbox" id="custom_status_<?php echo $v['legend'];?>" <?php if(in_array('<?php echo  $v["legend"];?>',$last)) { echo "checked"; } ?> style="cursor:pointer" onClick="checkboxCustomStatus('custom_status_<?php echo $v["legend"];?>','check');filterRequest('custom_status');" <?php echo $disabled; ?>/> <?php echo $v['name'];?> (<?php echo $v['count']; ?>)
		  </label>
		</div>		
	</li>
<?php } } ?>
