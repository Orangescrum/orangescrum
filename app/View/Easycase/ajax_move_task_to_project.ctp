<style>
	.ml_10_minus{margin-left:-10px !important}
	.form-group .checkbox .checkbox-material{margin-right: 15px;top: 2px;}
</style>
<div class="modal-body popup-container">
    <div class="data-scroll user_pdt">
    <?php if($is_multiple){ ?>
	<div class="form-group padding_0 ml_10_minus">
		<span class="radio mbtm20 mright10">
			<label for="all-selected">
			<input type="radio" id="all-selected" name="selectedTask" value="allselected" checked> Only Selected Tasks</label>
		</span>
		<span class="radio m-btm0">
			<label for="all-task">
				<input type="radio" id="all-task" name="selectedTask" value="alltask">
				All Open Tasks In Project <strong><?php echo $projectname; ?></strong>
			</label>
		</span>
	</div>
<?php } ?>
        <?php if (isset($projects) && !empty($projects)) { ?>
            <div class="mtop15">
				<div class="form-group">
					<div class="checkbox">
						<label>
							<input type="checkbox" id="move_assignee" name="move_assignee">
							Do you want to move the assignee along with the task?
						</label>
					</div>
				</div>
                <div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder customize-plshdr">
                    <select name="new_project" id="new_project" class="select form-control movetoproj"  data-dynamic-opts=true onchange="rmverrmsg();">
                        <?php /*<option value=""></option>*/?>
                        <?php
                        foreach ($projects as $proj) {
                           /* if ($proj['Project']['id'] == $project_id) {
                                $project_name = ucwords($this->Format->shortLength($proj['Project']['name'], 75));
                            }*/
                            ?>
														<?php if ($proj['Project']['id'] == trim($project_id)) {
                                $project_name = ucwords($this->Format->shortLength($proj['Project']['name'], 75));
                            ?>
															<option value="" selected="selected"><?php echo __('Select Project'); ?></option>
														<?php
                            }else{ 
                            ?>
                            <option value="<?php echo $proj['Project']['id']; ?>" ><?php echo ucwords($this->Format->shortLength($proj['Project']['name'], 75)); ?></option>
                            <?php /*if ($proj['Project']['id'] == $project_id) { ?>selected="selected"<?php } */?>
                        <?php } ?>
                        <?php } ?>
                    </select>
                    <div id="err_msg_dv" class="exist-prj exit-pro-txt" style="display:none"><?php echo __('Already in this Project');?>.</div>
                </div>
            </div>
            <input type="hidden" id="case" value="<?php echo $case_id ?>" />
            <input type="hidden" id="case_no" value="0" />
            <input type="hidden" id="project" value="<?php echo $project_id ?>" />
            <input type="hidden" id="old_project_nm" value="<?php echo $project_name; ?>" />
            <input type="hidden" id="ismultiple_move" value="<?php echo $is_multiple; ?>" />
        <?php } else { ?>
            <div>
                <p class="v-top" colspan="2"><span class="fnt_clr_rd"><?php echo __('No Projects assigned yet');?>!</span></p>
            </div>
        <?php } ?>

    </div>
</div>
<div class="modal-footer ">
    <div class="fr popup-btn">
        <span id="mvprjloader" class="mvprjlder fr" style="display: none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/> </span>
        <div id="mvprj_btn">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="mvbtn" onclick="moveTaskToProject();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Move');?></a></span>
            <div class="cb"></div>
        </div>
    </div>
</div>