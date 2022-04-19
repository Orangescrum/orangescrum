<div class="modal right fade filterModal" id="filterModal" role="dialog" data-backdrop="false">
	<input type="hidden" id="input_pm" /> 
	<input type="hidden" id="input_client" /> 
	<input type="hidden" id="input_status" /> 
	<input type="hidden" id="input_template" /> 
	<input type="hidden" id="input_workflow" /> 
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" id="filter_title_sec_proj"><?php echo __('Filter Your Project');?></h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeTaskFilter();"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">				
				<div class="active_filter_sec" style="display:none;">
					<div class="active_filter_sec_head">
							<?php echo __('Active Filters');?>
						</div>
					<div class="active_filter_sec_cont" style="display:block;">
							<div id="active_filter_contain">
								<span class="filter_opn" rel="tooltip" title="Time" onclick="openfilter_popup(1,&quot;dropdown_menu_all_filters&quot;);allfiltervalue(&quot;date&quot;);">Past 24Hour<a href="javascript:void(0);" onclick="common_reset_filter(&quot;date&quot;,&quot;&quot;,this);" class="fr"><i class="material-icons">close</i></a></span>
							</div>
						</div>
					</div>
				<div class="filter_accordion">					
					<div class="filter_set nolog">
						<div class="filter_type_header">
							<?php echo __('Project Manager');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_proj_pm" onclick="event.stopPropagation();"> </ul>
						</div>
				  </div>
					
					
				  <div class="filter_set nolog">
						<div class="filter_type_header">
							<?php echo __('Client');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_proj_client" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
				  <div class="filter_set nolog">
					<div class="filter_type_header" data-val="status" >
					  <?php echo __('Status');?>
					  <span class="fa_arrow fa-plus"></span>
					</div>
					<div class="filter_toggle_data">
					  <ul class="dropdown_status_filter_new ltsm scrollable" id="dropdown_menu_proj_satus" onclick="event.stopPropagation();"></ul>
					</div>
				  </div>
				  <!-- <div class="filter_set nolog">
					<div class="filter_type_header" data-val="types" >
					  <?php echo __('Date');?>
					  <span class="fa_arrow fa-plus"></span>
					</div>
					<div class="filter_toggle_data">
					  <ul class="dropdown_status_filter_new sub-panel-menu_archive ltsm" id="dropdown_menu_types" onclick="event.stopPropagation();"></ul>
					</div>
				  </div> -->
				  <div class="filter_set nolog">
						<div class="filter_type_header" data-val="priority">
							<?php echo __('Template');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_proj_template" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
				   <div class="filter_set nolog">
						<div class="filter_type_header" data-val="priority" onclick="allfiltervalue('priority', event);">
							<?php echo __('Workflow');?>
							<span class="fa_arrow fa-plus"></span>
						</div>
						<div class="filter_toggle_data">
							<ul class="dropdown_status_filter_new ltsm" id="dropdown_menu_proj_workflow" onclick="event.stopPropagation();"></ul>
						</div>
				  </div>
					
				</div>
			</div>
		</div>
	</div>
</div>