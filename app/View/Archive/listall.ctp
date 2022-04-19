<div class="task_section">
	<div class="loader_bg" id="caseLoader"> 
		<div class="loadingdata">
			<img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="<?php echo __('loading');?>..."/>
		</div>
	</div>	
	<div class="arc_grids">
	<input type="hidden" id="tab_diff" value="task"/>	
	<div id="caselistDiv" class="task_listing cmn_tbl_widspace m-cmn-flow" style="display:none;">
		<table class="table table-striped table-hover m-list-tbl" id="caselist">
			<thead>
				<tr> 
				<th class="verysmall_th" style="width:5%"> 
					<div class="checkbox">
					  <label>
						<input id="allcase" type="checkbox" style="cursor: pointer;" class="fl chkAllTsk">
						<span class="all_chk dropdown">
							<a class="arc_case_listing dropdown-toggle active" data-toggle="" href="javascript:void(0);" data-target="#">
								<i title="<?php echo __('Choose at least one task');?>" rel="tooltip" class="material-icons custom-dropdown">&#xE5C5;</i>
							</a>
							<ul id="dropdown_menu_chk" class="dropdown-menu">
								<li><a onclick="restoreall()" href="javascript:void(0);"><div class="act_icon act_restore_task fl" title="<?php echo __('Restore');?>"></div><i class="material-icons">&#xE8B3;</i> <?php echo __('Restore');?></a></li>
								<li><a onclick="removeall()" href="javascript:void(0);"><div class="act_icon act_del_task fl" title="<?php echo __('Delete');?>"></div><i class="material-icons">&#xE15C;</i> <?php echo __('Delete');?></a></li>
							</ul>
						</span>
					  </label>
					</div>
				</th>
				<th  style="width:5%" class="text-center small_th"><?php echo __('Task');?>#</th>
				<th  style="width:50%"><?php echo __('Title');?></th>
				<th  style="width:15%"><?php echo __('Due Date');?></th>									
				<th  style="width:10%"><?php echo __('Status');?></th>
				<th  style="width:15%"><?php echo __('Project');?></th>
			</tr>
			</thead>
			<tbody class="caselistall">
			</tbody>
		</table>
        <div class="crt_task_btn_btm">
        	 <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
            <div class="os_plus">
                <div class="ctask_ttip">
                    <span class="label label-default"><?php echo __('Create Task');?></span>
                </div>
                <a href="javascript:void(0)" onclick="setSessionStorage('Task Archive Page', 'Create Task');creatask();">
                    <img src="<?php echo HTTP_ROOT; ?>img/images/creat-task.png" class="ctask_icn"/>
                    <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
                </a>
            </div>
        <?php } ?>
        </div>
	</div>
	<div id="filelistDiv" class="files_top_ttl cmn_bdr_shadow task_listing m-cmn-flow" style="display:none">
		<table class="table table-striped m-list-tbl" id="filelist">			
			<thead>
			<tr>
				<th class="verysmall_th">
					<div class="checkbox">
					  <label>
						<input id="allfile" type="checkbox" style="cursor: pointer;" class="fl chkAllTsk">
						<span class="all_chk dropdown">
							<a class="arc_file_listing dropdown-toggle active" data-toggle="" href="javascript:void(0);" data-target="#">
								<i title="<?php echo __('Choose at least one file');?>" rel="tooltip" class="material-icons custom-dropdown">&#xE5C5;</i>
							</a>
							<ul id="dropdown_menu_chk" class="dropdown-menu">
								<li><a onclick="restorefile()" href="javascript:void(0);"><div class="act_icon act_restore_task fl" title="<?php echo __('Restore');?>"></div><i class="material-icons">&#xE8B3;</i> <?php echo __('Restore');?></a></li>
								<li><a onclick="removefile()" href="javascript:void(0);"><div class="act_icon act_del_task fl" title="<?php echo __('Remove');?>"></div><i class="material-icons">&#xE15C;</i> <?php echo __('Remove');?></a></li>
							</ul>
						</span>
					  </label>
					</div>
				</th>
				<th class="small_th"><?php echo __('Task');?>#</th>
				<th><?php echo __('File Name');?></th>
				<th class="ftype_width"><?php echo __('File Type');?></th>
				<th><?php echo __('Date & Time');?></th>
				<th><?php echo __('Size');?></th>
				<th><?php echo __('Project');?></th>        
			</tr>
			</thead>
			<tbody class="filelistall">
			</tbody>
		</table>
		</div>
	</div>
</div>
<script type="text/javascript">
function file(){
    $('#tab_diff').val('file');
    $('.archive-filter-menu').find('input[type="checkbox"]').prop('checked', false);
    $('.archive-filter-menu').find('input[type="radio"]').prop('checked', false);
    $('.archive-filter-menu').find('input[type="text"]').val('');
    remember_filters('ARCHIVE_DATE', 'all');
    remember_filters('ARCHIVE_USER', 'all');
    remember_filters('ARCHIVE_PROJECT', 'all');
    remember_filters('ARCHIVE_ASSIGNTO', 'all');
    remember_filters('ARCHIVE_STATUS', 'all');
    remember_filters('ARCHIVE_DUEDATE', 'all');
	document.location.hash = 'filelist';
}
function task(){
    $('#tab_diff').val('task');
    $('.archive-filter-menu').find('input[type="checkbox"]').prop('checked', false);
    $('.archive-filter-menu').find('input[type="radio"]').prop('checked', false);
    $('.archive-filter-menu').find('input[type="text"]').val('');
    remember_filters('ARCHIVE_FILE_DATE', 'all');
    remember_filters('ARCHIVE_FILE_USER', 'all');
    remember_filters('ARCHIVE_FILE_PROJECT', 'all');
	document.location.hash = 'caselist';
}
</script>
<div class="col-lg-12 fl m-left-20">
<div id="activities"></div>
<div style="display:none;text-align:center;" id="more_loader_arc_case" class="morebar_arc_case">
	<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/> 
</div>
</div>
<script>
$(function(){
    $(document).on('click', 'body', function(e){
        $(e.target).closest('.dropdown-menu').size()>0 || $(e.target).hasClass('archive-filter-menu') || $(e.target).hasClass('filter_opn')?'':$('.archive-filter-menu').find('ul').hide();
    });
    $("#arcstrtdt").datepicker({
       format: 'M d, yyyy',
       changeMonth: false,
       changeYear: false,
       hideIfNoPrevNext: true,
       autoclose:true
   }).on("changeDate", function(){
        var dateText = $("#arcstrtdt").datepicker('getFormattedDate');
        $("#arcenddt").datepicker( 'setStartDate', dateText );
    });
   $("#arcenddt").datepicker({
       format: 'M d, yyyy',
       changeMonth: false,
       changeYear: false,
       hideIfNoPrevNext: true,
       autoclose:true
    }).on("changeDate", function(){
        var dateText = $("#arcenddt").datepicker('getFormattedDate');
        $("#arcstrtdt").datepicker( 'setEndDate', dateText );
    });
    $("#arcduestrtdt").datepicker({
       format: 'M d, yyyy',
       changeMonth: false,
       changeYear: false,
       hideIfNoPrevNext: true,
       autoclose:true
    }).on("changeDate", function(){
        var dateText = $("#arcduestrtdt").datepicker('getFormattedDate');
        $("#arcdueenddt").datepicker( 'setStartDate', dateText );
    });
   $("#arcdueenddt").datepicker({
       format: 'M d, yyyy',
       changeMonth: false,
       changeYear: false,
       hideIfNoPrevNext: true,
       autoclose:true
    }).on("changeDate", function(){
        var dateText = $("#arcdueenddt").datepicker('getFormattedDate');
        $("#arcduestrtdt").datepicker( 'setEndDate', dateText );
    });
		$("#select_view_timesheet").hide();
		var cs_cnt_t = '<?php echo $caseCount; ?>';
		var fl_cnt_t = '<?php echo $fileCount; ?>';
	$('.archive_active_task').html('<?php echo $caseCount; ?>');
	$('.archive_active_file').html('<?php echo $fileCount; ?>');
	if(cs_cnt_t == '0'){
		$('#allcase').prop('disabled', true);
	}
	if(fl_cnt_t == '0'){
		$('#allfile').prop('disabled', true);
	}
});
</script>