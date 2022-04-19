<?php if(trim($this->Session->read("ERROR")) != ''){ $err_sts = $this->Session->read("ERROR"); $this->Session->write("ERROR",''); ?>
<?php } ?>
<?php echo $this->element('company_settings');?>
<?php //echo $this->element('workflow_settings');?>
<div class="slide_rht_con">    
    <div class="task_listing timelog_lview  hidetablelog timelog-detail-tbl">
        <div class="tlog_top_cnt">
            <div class="col-lg-5 padlft-non">
                <!-- <h2><?php echo __('Status Workflow Listing');?></h2> -->
                <div class="task-list-bar wf_page_nav_tabs"> <!---->
	                <ul class="proj_stas_bar">
					  <li class="<?php if(!isset($this->params['pass'][0]) || $this->params['pass'][0] !='project'){ ?> active-list <?php } ?> " ><a href="<?php echo HTTP_ROOT.'workflow-setting'; ?>" style="max-width: 160px"><?php echo __('Master Status Workflow');?></a></li>
					  <li  <?php if(isset($this->params['pass'][0]) && $this->params['pass'][0] == 'project' ){ ?> class="active-list" <?php } ?>><a href="<?php echo HTTP_ROOT.'workflow-setting/project'; ?>" style="max-width: 160px"><?php echo __('Project Status Workflow');?></a></li>
					</ul>
				</div>

            </div>
			<div class="col-lg-5 padlft-non mtop15">
                <span id="mng_sts_err" style="color:red;font-size:13px;"><span><?php echo $err_sts; ?></span>
            </div>
            <div class="col-lg-2 padnon btn_tlog_top mtop10">            	
            </div>
            <div class="cb"></div>
        </div>
        <div class="m-cmn-flow" style="overflow: auto;width: 100%;">
            <table class="table table-striped table-hover m-list-tbl" style="table-layout: fixed;">
                <tbody>
                	<tr>
                        <th style="width:25%"><?php echo  __("Workflow Name");?></th>
                        <th style="width:10%"><?php echo  __("# Status");?></th> 
                        <!-- <th><?php echo  __("# Project");?></th> -->
                        <th style="width:40%"><?php echo  __("Description");?></th> 
                        <th style="width:15%"><?php echo  __("Last Activity");?></th>                   
                        <th style="width:10%"><?php echo  __("Action");?></th>    
                    </tr>
                    <?php if(count($result) > 0 || count($dflt_stsarr)> 0){ 
						if(count($dflt_stsarr) > 0){ 
							foreach($dflt_stsarr as $kd=>$vd){ ?>
							<tr>
                    			<td>
								<a style="color:#2d6dc4;" href="<?php echo HTTP_ROOT.'status-setting/'.base64_encode($vd['StatusGroup']['id'])?>"><?php echo $vd['StatusGroup']['name'];?></a>
								</td>
                    			<td><?php echo count($vd['CustomStatus']);?></td>
                    			<!-- <td><?php echo $prj_cnt;?></td> -->
                    			<td><?php echo $vd['StatusGroup']['description'];?></td>
                    			<td><?php echo __('NA');?></td>
                    			<td>                    				
                    			</td>
                    		</tr>
							<?php } }
						if(count($result) > 0){
                    	foreach($result as $k=>$v){ ?>
                    		<tr>
                    			<td><a style="color:#2d6dc4;" href="<?php echo HTTP_ROOT.'status-setting/'.base64_encode($v['StatusGroup']['id'])?>"><?php echo $v['StatusGroup']['name'];?></a></td>
                    			<td><?php echo count($v['CustomStatus']);?></td>
                    			<!-- <td><?php echo count($v['Project']);?></td> -->
                    			<td><?php echo $v['StatusGroup']['description'];?></td>
                    			<td><?php echo date('d M, Y',strtotime($v['StatusGroup']['modified']));?></td>
                    			<td>
                    				<a href="javascript:void(0)" onclick="editStatusGroup(<?php echo $v['StatusGroup']['id'];?>)" title="<?php echo __('Edit');?>"><i class="material-icons">edit</i></a>
                    				<?php if(count($v['Project']) == 0){ ?>
                                    <a href="javascript:void(0)" onclick="deleteStatusGroup(<?php echo $v['StatusGroup']['id'];?>)" title="<?php echo __('Delete');?>"><i class="material-icons">delete_outline</i></a>
                                <?php } ?>
                    			</td>
                    		</tr>
						<?php } } }else{ ?>
                   	<tr>
                   		<td colspan="6" style="color: red; text-align: center;"><?php echo __("No workflow found.");?></td>
                   	</tr>
                   <?php } ?>
                </tbody>
            </table>   
        </div>   
    </div>
    <div class="cb"></div>  
</div>
<script>
	function createWorkflow(){
		$('#label_title_wf').text(_('Create New Status Workflow'));
		$('#newworkflow_btn').val(_('Add'));
	    openPopup();
        $('#createWorkFlow').show();
	}
	function validateWorkFlow(){
		if($("#StatusGroup_name").val().trim() ==''){
			showTopErrSucc('error', "<?php echo __('Please enter status workflow name')?>");
			return false;
		}else{
			$("#wfbtn").hide();
			$("#create_wloader").show();
			return true;
		}		
	}
	function deleteStatusGroup(id){
		if(confirm('<?php echo __("Are you sure you want to delete the Workflow?")?>')){
			$.post('<?php echo HTTP_ROOT."projects/deleteWorkflow"?>',{id:id},function(res){
				if(res.status == 1){
					showTopErrSucc('success', res.msg);
					self.location = '<?php echo HTTP_ROOT."workflow-setting"?>';
				}else{
					showTopErrSucc('error', res.msg);
				}
			},'json');
		}
	}
	function editStatusGroup(id){
		openPopup();
		$('#label_title_wf').text(_('Update Status Workflow'));
		$('#newworkflow_btn').val(_('Update'));
		$('#createWorkFlow').show();
		$.post('<?php echo HTTP_ROOT."projects/getWorkflow"?>',{id:id},function(res){
			if(res.status == 1){
				$("#StatusGroup_id").val(res.result.id);
				$("#StatusGroup_name").val(res.result.name).closest('.form-group').removeClass('is-empty');
				$("#StatusGroup_desc").val(res.result.description).closest('.form-group').removeClass('is-empty');
			}else{
				showTopErrSucc('error', res.msg);
			}
		},'json');

	}
	$('document').ready(function(){
		if(localStorage.getItem("tour_type") == '1'){			
			if(typeof hopscotch !='undefined'){
				GBl_tour = onbd_tour_project<?php echo LANG_PREFIX;?>;
				//setTimeout(function() {
					hopscotch.startTour(GBl_tour);
				//},500);
			}
		}
	});
</script>