<% var due_date = getCookie('DUE_DATE');
var duedateArr = {'Anytime':'any', 'Overdue':'overdue', 'Today':'24'};
for(i in duedateArr){
var chked = '';
if(duedateArr[i] == 'any' && trim(due_date) == ''){
	chked = 'checked';
} else if(duedateArr[i] == 'overdue' && trim(due_date) == 'overdue'){
	chked = 'checked';
} else if(duedateArr[i] == '24' && trim(due_date) == '24'){
	chked = 'checked';
} %>
<li class="li_check_radio">
   <div class="radio radio-primary">
	  <label>
		<input type="radio"  name="duedate_filter" id="duedate_<%= duedateArr[i] %>" class="cbox_date" style="cursor:pointer" <%= chked %> onclick="checkboxdueDate(<%= '\''+duedateArr[i]+'\',\'check\'' %>);filterRequest(<%= '\'duedate\'' %>);" />
		<%= i %>
	  </label>
	</div>
</li>
<% } %>
<% var dt = '';
if(trim(due_date).indexOf(':')!=-1){
 var dt=trim(due_date).split(':');
} %>
<li class="li_check_radio">
	<div class="radio radio-primary">
	  <label>
		<input type="radio"  name="duedate_filter" id="duedate_custom" class="cbox_date" style="cursor:pointer" onclick="checkboxcustom(<%= '\'custom_duedate\',\'duedate_custom\',\'due\'' %>);" <% if(dt){ %> checked="checked" <% } %> />
		<?php echo __('Custom range');?>
	  </label>
	</div>
</li>
<li class="custom_date_li">
<div id="custom_duedate" <% if(!dt){%>style="display:none;"<% } %>>
	<div  class="cdate_div_cls">
		<input type="text" id="duefrm"  value="<%= dt[0] %>" placeholder="<?php echo __('From');?>" class="form-control"/>
		<input type="text" id="dueto" value="<%= dt[1] %>" placeholder="<?php echo __('To');?>" class="form-control" />
	</div>
	<div  class="cduedate_btn_div">
		<button class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info cdate_btn" onclick="return searchduedate();"><?php echo __('Search');?></button>
	</div>
</div>
</li>