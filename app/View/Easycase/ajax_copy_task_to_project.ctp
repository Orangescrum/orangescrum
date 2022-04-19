<style>
	.switch {
	  position: relative;
	  display: inline-block;
	  width: 50px;
	  height: 24px;
	  left: 20px;
	}
	
	.switch input { 
	  opacity: 0;
	  width: 0;
	  height: 0;
	}
	
	.slider {
	  position: absolute;
	  cursor: pointer;
	  top: 0;
	  left: 0;
	  right: -1px;
	  bottom: 0;
	  background-color: #ccc;
	  -webkit-transition: .4s;
	  transition: .4s;
	}
	
	.slider:before {
	  position: absolute;
	  content: "";
	  height: 20px;
	  width: 20px;
	  left: 3px;
	  bottom: 2px;
	  background-color: white;
	  -webkit-transition: .4s;
	  transition: .4s;
	}
	
	input:checked + .slider {
	  background-color: #00BCD5;
	}
	
	input:focus + .slider {
	  box-shadow: 0 0 1px #00BCD5;
	}
	
	input:checked + .slider:before {
	  -webkit-transform: translateX(26px);
	  -ms-transform: translateX(26px);
	  transform: translateX(26px);
	}
	
	/* Rounded sliders */
	.slider.round {
	  border-radius: 34px;
	}
	
	.slider.round:before {
	  border-radius: 50%;
	}
</style>
<div class="modal-body popup-container">
    <div class="data-scroll user_pdt">
		<?php /*?><div class="alert-info-copy"><?php echo __('Can not copy closed tasks');?>!</div><?php */?>
		<div style="width: 100%;font-size: 14px;padding: 10px 10px 10px 0px">
			<?php echo __('Do you want to copy the closed tasks');?>
			<label class="switch">
			  <input type="checkbox" id="chkRadioId" id="chkRadioName">
			  <span class="slider round"></span>
			</label>
		</div>
        <div class="">
            <?php
            $project_name = '';
            if (isset($projects) && !empty($projects)) {
                ?>
                <div>
                    <select class="select form-control" name="new_project" id="new_project_cp" onchange="rmverrmsg();">
                        <?php
                        foreach ($projects as $proj) {
                            if ($proj['Project']['id'] == trim($project_id)) {
                                $project_name = $proj['Project']['name'];
														?>
															<option value="0" selected="selected"><?php echo __('Select Project'); ?></option>
														<?php
                            }else{ 
                            ?>
                            <option value="<?php echo $proj['Project']['id']; ?>" <?php if ($proj['Project']['id'] == $project_id) { ?>selected="selected"<?php } ?>><?php echo ucwords($this->Format->shortLength($proj['Project']['name'], 75)); ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                    <div id="errcp_msg_dv" class="exist-prj exit-pro-txt" style="display:none"><?php echo __('Please select a project');?>.</div>
                </div>  
                <input type="hidden" id="case_cp" value="<?php echo $case_id; ?>" />
                <input type="hidden" id="case_no_cp" value="0" />
                <input type="hidden" id="project_cp" value="<?php echo $project_id; ?>" />
                <input type="hidden" id="old_project_nm_cp" value="<?php echo $project_name; ?>" />
                <input type="hidden" id="ismultiple_move_cp" value="<?php echo $is_multiple; ?>" />
            <?php } else { ?>
                <span class="fnt_clr_rd"><?php echo __('No Projects assigned yet');?>!</span>
            <?php } ?>
        </div>
    </div>
</div>
<div class="modal-footer ">
    <div class="fr popup-btn">
        <span id="cpprjloader" class="mvprjlder" style="display: none;">
            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/> 
        </span>
        <div id="cpprj_btn">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="cpbtn" onclick="copyTaskToProject();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Copy');?></a></span>
            <div class="cb"></div>
        </div>
    </div>
		<div class="cb"></div>
</div>