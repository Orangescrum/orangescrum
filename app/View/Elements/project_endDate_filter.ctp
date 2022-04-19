<%  var dates = JSON.parse(localStorage.getItem("PROJECTENDDATE"));
 
var dateArr = {'Past 24 hours':'24', 'Past week':'week', 'Past month':'month', 'Past year':'year'};

for(i in dateArr){
var chked = '';
if(dateArr[i] == 'any' && trim(dates) == ''){
	chked = 'checked';
} else if(dateArr[i] == 'one' && trim(dates) == 'one'){
	chked = 'checked';
} else if(dateArr[i] == '24' && trim(dates) == '24'){
	chked = 'checked';
} else if(dateArr[i] == 'week' && trim(dates) == 'week'){
	chked = 'checked';
} else if(dateArr[i] == 'month' && trim(dates) == 'month'){
	chked = 'checked';
} else if(dateArr[i] == 'year' && trim(dates) == 'year'){
	chked = 'checked';
} %>
<li>
	<a href="javascript:void(0);">
	<input type="checkbox" id="projdate_<%= dateArr[i] %>" class="pjcbox_date custom_checkbox" <%= chked %> onclick="projendcheckboxDate(<%= '\''+dateArr[i]+'\',\'check\'' %>);"/>
	<label for="projdate_<%= dateArr[i] %>" class="check_label" >&nbsp;<%= _(i) %></label>
        <!-- font onClick="checkBox(<%= '\'date_'+dateArr[i]+'\'' %>);checkboxDate(<%= '\''+dateArr[i]+'\',\'text\'' %>);filterRequest(<%= '\'time\'' %>);" >&nbsp;<%= _(i) %></font -->
	</a>
</li>	
<% }
var dt = "";
if(trim(dates).indexOf(":")!=-1){
	var dt=trim(dates).split(":");
} %>
<li>
    <a href="javascript:void(0);">
	<input type="checkbox" id="proj_enddate_custom" class="pjcbox_date custom_checkbox"  onClick="projendcheckboxcustom(<%= '\'proendcustom_date\',\'proj_enddate_custom\',\'\'' %>);" <% if(dt){ %> checked="checked"<% } %> />
        <label for="proj_enddate_custom" class="check_label" >&nbsp;<?php echo __("Custom range"); ?></label>
	<!-- font onClick="checkBox(<%= '\'date_custom\'' %>);checkboxcustom(<%= '\'custom_date\',\'date_custom\',\'\'' %>);" >&nbsp;<?php echo __("Custom range"); ?></font -->
    </a>
</li>
<div id="proendcustom_date" <% if(!dt){ %>style="display:none;"<% } %>>
	<div  class="cdate_div_cls" style="padding-left:10px; padding-right:10px;">
		<input type="text" id="proj_endfrm"  value="<%= dt[0] %>" placeholder="<?php echo __('From'); ?>" class="form-control"/><br/>
		<input type="text" id="proj_endto" value="<%= dt[1] %>" placeholder="<?php echo __('To'); ?>" class="form-control"/>
	</div>
	<div  class="cdate_btn_div" style="text-align:center;margin-top: 5px;cursor:pointer">
		<button class="btn btn-primary cdate_btn"  onclick="projendcheckboxrange(<%= '\'custom_range\',\'text\'' %>);"><?php echo __("Search"); ?></button>
	</div>
</div>