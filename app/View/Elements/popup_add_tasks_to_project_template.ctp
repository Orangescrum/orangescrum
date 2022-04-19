<div class="modal-dialog" style="width:80%;">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 class="import_prod_temp_name proj_temp_name ellipsis-view" style="max-width: 85%;">
                <!-- dynamic -->
            </h4>
        </div>
        <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
        <div class="cb"></div>
        <div id="inner_tmp_add">
		
			
			<div class="user_profile_con setting_wrapper task_listing import-export-page cmn_tbl_widspace width_hover_tbl">
				<div class="row exp_innerdiv" id="imploade_file">
					<div class="col-lg-5 col-sm-5">
						<div class="import-csv-file">
							<form action="<?php echo HTTP_ROOT; ?>templates/csv_dataimport/" enctype="multipart/form-data" method="post" name="data_import_form_tmp" id="data_import_form_tmp">
								<input type="hidden" value="<?php echo $proj_id; ?>" name="proj_id" id="proj_id"/> 
								<input type="hidden" value="<?php echo $proj_uid; ?>" name="proj_uid" id="proj_uid"/> 
								<input type="hidden" value="" name="template_id" id="template_id"/>
								<input type="hidden" value="" name="template_name" id="template_name"/> 
								<div class="form-group">
									<input multiple="" type="file" name="import_csv" id="import_csv_tmp" onchange="check_csvfile();"/>
									<div class="input-group">
										<input readonly="" class="form-control" placeholder="<?php echo __('Upload your CSV file');?>" type="text">
										<span class="input-group-btn input-group-sm">
											<button type="button" class="btn btn-fab btn-fab-mini">
												<i class="material-icons import-attach-icon">attach_file</i>
											</button>
										</span>
									</div>
									<span class="upload_limit"><b>2 MB</b> <?php echo __('or');?> <b>1,000</b> <?php echo __('rows maximum size');?></span>
								</div>
								<span id="err_span" style="color:#900;font-size:12px"></span>
								<div class="import_btn_div text-right">
									<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..."  id="loader_img_csv" style="display: none;"/>
									<button type="submit" id="cnt_btn_tmp" class="btn btn_cmn_efect cmn_bg btn-info cmn_size cmn_disabled_btn" disabled="true">
										<i class="icon-big-tick"></i>
										<span><?php echo __('Continue');?></span>
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="col-lg-7 col-sm-7">
						<div class="import-info-dif import_proj">
							<div class="chk_content">
								<h4 class="chk_head"><?php echo __('CSV File');?></h4>
								<div class="download_samplefile">
									<a href="<?php echo HTTP_ROOT; ?>projects/download_sample_prjtemplate_csvfile"><?php echo __('Download the sample file');?></a> <?php echo __('to see what you can import');?>
								</div>
								<ul class="chk_desc">
									<li><b><?php echo __('Task Group');?> / <?php echo __('Sprint');?> </b></li>
									<li><b><?php echo __('Title');?> - </b> <?php echo __('Task Title');?> - <span><?php echo __('mandatory');?></span></li>
									<li><b><?php echo __('Description');?> - </b> <?php echo __('Description of the task');?></li>
									<li><b><?php echo __('Type');?> - </b> <?php echo __('Task type (Bug, Development, Enhancement, RnD, QA, Unit Testing, Maintenance, Release, Updates, Idea, Others, Story)');?> </li>
									<li><b><?php echo __('Story Point');?> - </b> <?php echo __('If Task type is story, they the story point will be inserted for task.');?> </li>
									<li><b><?php echo __('Priority');?> - </b> <?php echo __('Task priority (High, Medium, Low)');?> </li>
									<li><b><?php echo __('Assign to');?>  - </b> <?php echo __('Email ID of Task Assigned To');?></li>
									<li><b><?php echo __('Estimated Hour');?>  - </b>(<span><?php echo __('hh:mm format only');?></span>)</li>
								</ul>
		
								<h4 class="chk_head"><?php echo __('Help');?></h4>
								<ul class="chk_desc">
									<li><?php echo __('Upload the valid CSV file with your Tasks');?></li>
									<li><?php echo __('First system will validate your data and give error message if there is any error');?></li>
									<li><?php echo __('All the Tasks will be posted to the selected Project Template');?>.</li>
									<li><span><?php echo __('Left blank the columns having no entry');?>.</span></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="cb"></div>
				</div>
			</div>
			
			
		
		</div>
    </div>
</div>


<script>

function check_csvfile() {
	var url = '<?php echo HTTP_ROOT; ?>' + 'projects/checkfile_project_template_existance';
	if ($('#import_csv_tmp').val()) {
		var file = $('#import_csv_tmp').val();
		var ext = file.split('.').pop();
		if (ext == 'csv' || ext == 'CSV') {
			var data = new FormData();
			jQuery.each($('#import_csv_tmp')[0].files, function (i, file) {
				data.append('file-' + i, file);
			});
			//data.append('porject_id', $('#proj_id').val());

			$('#loader_img_csv').css('display', 'inline-block');
			//$('#cnt_btn_tmp').hide();
			$.ajax({
				url: url,
				data: data,
				cache: false,
				contentType: false,
				processData: false,
				type: 'POST',
				dataType: 'json',
				success: function (data) {
					$('#loader_img_csv').hide();
					//$('#cnt_btn_tmp').show();
					$('#err_span').html('');
					if (data.error) {
						$('#err_span').html(data.msg);
						$('#import_csv_tmp').val('');
					} else {
						$('#cnt_btn_tmp').prop('disabled', false);
						$('#cnt_btn_tmp').removeClass('cmn_disabled_btn');
					}
				}
			});
		} else {
			$('#err_span').html('<?php echo __('Please upload a valid csv file');?><br/>');
			$('#import_csv_tmp').val('');
		}
	} else {
		$('#cnt_btn_tmp').prop('disabled', true);
		$('#cnt_btn_tmp').addClass('cmn_disabled_btn');
	}
}

</script>