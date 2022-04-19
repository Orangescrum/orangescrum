<% 
var date = getCookie("DATE");
var projfil = $('#projFil').val();
var x = getCookie('LAST_FILTER_DATE_'+projfil);
if(x != '' && typeof x !='undefined'){
    d = x.split("-");
	date = d['1'];
}
var dateArr = {'Anytime':'any', 'Today':'today', 'Past hour':'one', 'Past 24 hours':'24', 'Past week':'week', 'Past month':'month', 'Past year':'year'};

for(i in dateArr){
var chked = '';
if(dateArr[i] == 'any' && (trim(date) == '' || typeof date == 'undefined')){
	chked = 'checked';
} else if(dateArr[i] == 'one' && trim(date) == 'one'){
	chked = 'checked';
} else if(dateArr[i] == '24' && trim(date) == '24'){
	chked = 'checked';
} else if(dateArr[i] == 'today' && trim(date) == 'today'){
	chked = 'checked';
}else if(dateArr[i] == 'week' && trim(date) == 'week'){
	chked = 'checked';
} else if(dateArr[i] == 'month' && trim(date) == 'month'){
	chked = 'checked';
} else if(dateArr[i] == 'year' && trim(date) == 'year'){
	chked = 'checked';
} %>
<li class="li_check_radio">
	<div class="checkbox">
	  <label>
		<input type="checkbox" id="date_<%= dateArr[i] %>" class="cbox_date" <%= chked %> onclick="checkboxDate(<%= '\''+dateArr[i]+'\',\'check\'' %>);filterRequest(<%= '\'time\'' %>);"/> <%= i %>
	  </label>
	</div>
</li>	
<% }
var dt = '';
if(trim(date).indexOf(':')!=-1){
	var dt=trim(date).split(':');
} %>
<li class="li_check_radio">
	<div class="checkbox">
	  <label>
		<input type="checkbox" id="date_custom" class="cbox_date"  onClick="checkboxcustom(<%= '\'custom_date\',\'date_custom\',\'\'' %>,event);" <% if(dt){ %> checked="checked"<% } %> /> <?php echo __('Custom range');?>
	  </label>
	</div>
</li>
<li class="custom_date_li">
<div id="custom_date" <% if(!dt){ %>style="display:none;"<% } %> onclick="stopProgress(event);">
	<div  class="cdate_div_cls">
		<input type="text" id="frm"  value="<%= dt[0] %>" placeholder="<?php echo __('From');?>" class="form-control"/>
		<input type="text" id="to" value="<%= dt[1] %>" placeholder="<?php echo __('To');?>" class="form-control"/>
	</div>
	<div  class="cdate_btn_div">
		<button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info cdate_btn"  onclick="checkboxrange(<%= '\'custom_range\',\'text\'' %>);"><?php echo __('Search');?></button>
	</div>
</div>
</li>