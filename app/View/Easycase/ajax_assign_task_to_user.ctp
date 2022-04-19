<style>
.assign-task-to-usr .dropdownjs ul {max-height:250px !important;}
</style>
<div class="modal-body popup-container">
    <div class="data-scroll user_pdt">
        <?php if (isset($users) && !empty($users)) { ?>
            <div>
                <div class="custom-task-fld assign-to-fld labl-rt add_new_opt select_placeholder assign-task-to-usr">
                    <select name="new_asntskuser" id="new_asntskuser" class="select form-control floating-label" placeholder="<?php echo __('Select User');?>" data-dynamic-opts=true onchange="rmverrmsg();" >
                        <?php
                        foreach ($users as $usr) {
                            if ($usr['User']['id'] == $project_id) {
                                $project_name = ucwords($this->Format->shortLength($usr['User']['name'], 75));
                            }
							$u_nm = $usr['User']['name'];
							if(!empty($usr['User']['last_name'])){
								$u_nm .= ' '.$usr['User']['last_name'];
							}
                            ?>

                            <option value="<?php echo $usr['User']['id']; ?>"><?php echo ucwords($this->Format->shortLength($u_nm, 75)); ?></option>
                        <?php } ?>
                    </select>
                    <div id="err_msgassn_dv" class="exist-prj exit-pro-txt" style="display:none"><?php echo __('Already in this Project');?>.</div>
                </div>
            </div>
            <input type="hidden" id="project_asntskuser" value="<?php echo $project_id ?>" />
            <input type="hidden" id="ismultiple_asntskuser" value="<?php echo $is_multiple; ?>" />
        <?php } else { ?>
            <div>
                <p class="v-top" colspan="2"><span class="fnt_clr_rd"><?php echo __('No User(s) assigned');?>!</span></p>
            </div>
        <?php } ?>

    </div>
</div>
<div class="modal-footer ">
    <div class="fr popup-btn">
        <span id="asntskuserloader" class="asntskuserlder fr" style="display: none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/> </span>
        <div id="asntskuser_btn">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
            <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="mvbtn" onclick="assignTaskToUser();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Assign');?></a></span>
            <div class="cb"></div>
        </div>
    </div>
</div>