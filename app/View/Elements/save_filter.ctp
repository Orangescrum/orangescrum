<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="filter_label"><?php echo __('Save Filter');?></h4>
            <a href="<?php echo HTTP_ROOT.'dashboard#searchFilters';?>" class="btn btn-default" style="border:1px solid #ddd; float:right; margin:0 10px 0 0;padding:5px 10px;">Manage Filter</a>
			
        </div>
        <div class="modal-body popup-container">
            <div class="row">
                <div class="col-lg-12">
                    <?php echo $this->form->create('User', array('url' => '/easycases/saveFilter', 'onsubmit'=>'', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal','id'=>'filter-edit-popup', 'autocomplete' => 'off')); ?>                 
                    <input type="hidden" name="data[SearchFilter][user_id]" id="profile-id-popup"  value="<?php print SES_ID;?>" />
                    <input type="hidden" name="data[SearchFilter][id]" id="flt-id-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][STATUS]" id="flt-STATUS-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][CUSTOM_STATUS]" id="flt-CUSTOM_STATUS-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][PRIORITY]" id="flt-PRIORITY-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][CS_TYPES]" id="flt-CS_TYPES-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][TASKLABEL]" id="flt-TASKLABEL-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][MEMBERS]" id="flt-MEMBERS-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][COMMENTS]" id="flt-COMMENTS-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][ASSIGNTO]" id="flt-ASSIGNTO-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][TASKGROUP]" id="flt-TASKGROUP-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][DATE]" id="flt-DATE-popup"  value="" />
                    <input type="hidden" name="data[SearchFilter][DUE_DATE]" id="flt-DUE_DATE-popup"  value="" />
					<div class="row form-group">
                                        <div class="row">                                        
					 <div class="col-lg-12">
					 <div class="col-lg-12">
					 
							<div class="ser-label">
								<div class="radio radio-primary semail-rdo">
                                                                    <label><input type="radio" name="data[SearchFilter][create]"  id="filter_create_1" value="1" /><?php echo __('Update the current filter');?> &nbsp;&nbsp;&nbsp;<strong id="updateFilterName"></strong></label>									
								</div>
							</div>
					</div>						
					 </div>
					 <div class="col-lg-12">
					<div class="col-lg-4">
						
							<div class="ser-label">
								<div class="radio radio-primary semail-rdo">
									<label><input type="radio" name="data[SearchFilter][create]"  id="filter_create_0" value="0"  /><?php echo __('Create new filter');?></label>									
								</div>
							</div>
					</div>
					<div class="col-lg-8">
					 <div class="custom-drop-lebel label-floating custom-filter-name">                    
                                             <input type="text" name="data[SearchFilter][name]" id="filter_name" class="form-control" placeholder="<?php echo __('Filter name');?>" maxlength="100" value=""/>
                    </div>
					</div>
					</div>
					</div>
                                        </div>
                    <div class="cb"></div>
                    <div class="">
                        <div class="btn_row fr">
                            <div id="subprof1-popup">
                                <div class="fl"><a class="btn btn-default btn_hover_link cmn_size fl" onclick="closePopup();"><?php echo __('Cancel');?></a></div>
                                <div class="fl btn-margin"><button type="submit" value="Update" name="submit_filter"  id="submit_filter-popup" class="btn btn_cmn_efect cmn_bg btn-info cmn_size fl"><?php echo __('Create');?></button></div>
                                <div class="cb"></div>
                            </div>
                            <span id="subprof2-popup" style="display:none">
                                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
                            </span>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>       
    </div>
</div>
<script>
    $(document).ready(function(){ 
        $(document).click(function(e){
         container = $("#filterSearch_id");
         container_kanban = $("#filterSearch_id_kanban");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
               // $("#filpopup").hide();
            }
            if (!container_kanban.is(e.target) && container_kanban.has(e.target).length === 0) {
                $("#filpopup_kanban").hide();
            }
        });
    });
    $(function(){    
      $('input[name="data[SearchFilter][create]"]').change(function() {
        if ($(this).val() == '1') {
           $("#updateFilterName").html("'"+$("#"+localStorage.SEARCHFILTER).find('.wrap_title_txt').text().replace(/\(.*\)/, '')+"'");
           $("#filter_name").val("").attr('disabled',true);
           $("#submit_filter-popup").html("Update");
           $("#filter_label").html("Update Filter");  
        }else {
           $("#updateFilterName").html("");
           $("#filter_name").attr('disabled',false);
           $("#submit_filter-popup").html("Save");
           $("#filter_label").html("Save Filter");
		   $("#filter_name").val("").attr('disabled',false);
        }
    });
	$("#filter-edit-popup").submit(function(e){
		e.preventDefault();
		if($('input[name="data[SearchFilter][create]"]:checked').val() !=1 && $("#filter_name").val().trim() ==''){
			showTopErrSucc('error','<?php echo __('Please enter a filter name');?>');return false;
		}else{
			 $.ajax({
					url : $(this).attr("action"),
					type: "POST",
					dataType:'json',
					data : $(this).serializeArray(),
					success:function(data, textStatus, jqXHR){
						if(data.type=='success'){
							showTopErrSucc('success',data.message);							
						$("#filter-edit-popup")[0].reset();
						localStorage.setItem("SEARCHFILTER", 'ftopt'+data.id);
						$('#caseMenuFilters').val("cases");
						easycase.refreshTaskList();
                                                        closePopup();
						}else{
							showTopErrSucc('error',data.message);                                                        
						}						
												
					},
					error: function(jqXHR, textStatus, errorThrown){
				}
			});
		}
	});
    });
</script>