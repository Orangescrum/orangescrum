<?php if(trim($this->Session->read("ERROR")) != ''){ $err_sts = $this->Session->read("ERROR"); $this->Session->write("ERROR",''); ?>
<?php } ?>
<?php echo $this->element('company_settings');?>
<?php //echo $this->element('workflow_settings');?>
<div class="slide_rht_con">    
    <div class="task_listing timelog_lview  hidetablelog timelog-detail-tbl">
        <div class="tlog_top_cnt">
            <div class="col-lg-4  padnon">
                <h2><?php echo $statusGroup['StatusGroup']['name'];?></h2>
            </div>
			<div class="col-lg-4  padnon">
                <span id="mng_sts_err" style="color:red;font-size:13px;"><?php echo $err_sts; ?></span>
            </div>
            <div class="col-lg-4 padnon btn_tlog_top">
                <a href="javascript:void(0)" class="btn btn-sm btn_cmn_efect fr" rel="tooltip" onclick="backToStatus();" title="<?php echo __("Back");?>">
                   <span class="os_sprite back-detail"></span>              
                    <?php //echo __("Back");?>
                </a>
                <?php if($statusGroup['StatusGroup']['parent_id'] == 0){ ?>
				<a href="javascript:void(0)" class="btn btn-sm btn_cmn_efect ellipsis-view fr" rel="tooltip" onclick="newProject('','','','',<?php echo $statusGroup['StatusGroup']['id'];?>);" title="<?php echo __("Create")." ".str_replace( 'Workflow', '', $statusGroup['StatusGroup']['name'])." ".__("Project");?>" style="max-width:165px;">
                   <?php echo __("Create")." ".str_replace( 'Workflow', '', $statusGroup['StatusGroup']['name'])." ".__("Project");?>              
                </a>
            <?php } ?>
				<?php if($statusGroup['StatusGroup']['company_id']){ ?>
                <a style="margin-right: 13px;" href="javascript:void(0)" class="btn btn-sm btn_cmn_efect fr" rel="tooltip" onclick="createStatusNew();" title="<?php echo __("Create New Status");?>">
                   <?php echo __("Create New Status");?>              
                </a>
				<?php } ?>            
            </div>
            <div class="cb"></div>
        </div>
        <!-- List of work status -->
        <div id="workflowStatusList">        
        <?php echo $this->element('workflow_status_list');?>
       </div>
    <div class="cb"></div>  
</div>
<script>
        function backToStatus(){
            <?php if($statusGroup['StatusGroup']['parent_id'] == 0){ ?>
                    self.location = '<?php echo HTTP_ROOT;?>workflow-setting';
            <?php }else{ ?>
                    self.location = '<?php echo HTTP_ROOT;?>workflow-setting/project';
           <?php  } ?>
        }
         
	function createStatusNew(){
		openPopup();
		$('#label_title_sts').text(_('Create New Status'));
		$('#createWorkFlowStatus').show();
		$("#task_status_content").html('<div style="width:100%; padding:20px; text-align:center"><img src="<?php echo HTTP_ROOT.'img/loading2.gif'?>" alt="<?php echo __('Loading...')?>"></div>');
		$.post("<?php echo HTTP_ROOT.'projects/crate_new_status'?>",{id:<?php echo $statusGroup['StatusGroup']['id'];?>},function(res){
			$("#task_status_content").html(res);			
		});
	}	
	function deleteWfStatus(id){
		if(confirm('<?php echo __("Are you sure you want to delete the Status?")?>')){
			$.post('<?php echo HTTP_ROOT."projects/deleteWfStatus"?>',{id:id},function(res){
				if(res.status == 1){
					showTopErrSucc('success', res.msg);
					self.location = '<?php echo HTTP_ROOT."status-setting/".base64_encode($statusGroup['StatusGroup']['id']);?>';
				}else{
					showTopErrSucc('error', res.msg);
				}
			},'json');
		}
	}
	function editWfStatus(id){
		openPopup();
        $('#createWorkFlowStatus').show();
        $("#task_status_content").html('<div style="width:100%; padding:20px; text-align:center"><img src="<?php echo HTTP_ROOT.'img/loading2.gif'?>" alt="<?php echo __('Loading...')?>"></div>');
        $.post("<?php echo HTTP_ROOT.'projects/crate_new_status'?>",{id:<?php echo $statusGroup['StatusGroup']['id'];?>,sid:id},function(res){
            $("#task_status_content").html(res);
						$('#label_title_sts').text(_('Update Status'));						
        });
	}   
	$(document).ready(function(){
		$( "#sortableStatus" ).sortable({
			placeholder: "ui-state-highlight",
			dropOnEmpty:false, 
			stop : function(event, ui){
				if($('#'+ui.item[0].id).attr('data-master-id') == 3){
					showTopErrSucc('error', _('Can not reorder closed map status'));
					return false;
				}else{
					$.post(HTTP_ROOT+'projects/reorderStatus',$('#sortableStatus').sortable("serialize"),function(res){},'json');
				}
			}
		});
	});
    
/* ajax call for workflow status add/update with "Add another" check option */
    function addKanbanNewSts(){ 
        var customStatus=$('#custom-status').val();
     
        if($("#custom_statuses_name").val().trim() ==''){        
            showTopErrSucc('error', "<?php echo __('Please enter status name')?>");
            return false;
        }else{                  
    
        var url = '<?php echo HTTP_ROOT; ?>';
     
		$.ajax({

            url: url + 'projects/manage_status/'+ customStatus,
			type: 'POST',
			data: $('#workflowStatusForm').serialize(),
			cached: true,
			dataType: 'html',
			success: function (res) {                               
				$("#workflowStatusList").html(res);
				
				$( "#sortableStatus" ).sortable({
					placeholder: "ui-state-highlight",
					dropOnEmpty:false, 
					stop : function(event, ui){
						if($('#'+ui.item[0].id).attr('data-master-id') == 3){
							showTopErrSucc('error', _('Can not reorder closed map status'));
							return false;
						}else{
							$.post(HTTP_ROOT+'projects/reorderStatus',$('#sortableStatus').sortable("serialize"),function(res){},'json');
						}
					}
				});
				
				if($('#custom_statuses_id').val()!= ''){                
						showTopErrSucc('success', _('Status updated successfully.'));    
				} else { 
					showTopErrSucc('success', _('Status added successfully.')); 
				}     	
         
				if($('#add_wf_status').is(":checked")){                        
						$('#custom_statuses_name').val('');
						$("#select2-custom_statuses_map-container").text('In-progress');                     
						$('#select2-select2-container').text('0');
						$('#colorSelector div').css('background-color', '#0000ff');  
						$('#custom_task_color').val('0000ff');                 
				} else {                                            
						closePopup();                        
				} 
			},
			error: function() {
				showTopErrSucc('error', _('Error in saving task status.'));
			}            
    });
 }
    }
</script>
<style>
    #sortableStatus tr {cursor: move;}
</style>