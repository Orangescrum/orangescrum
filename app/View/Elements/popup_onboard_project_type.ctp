<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Project Methodology');?></h4>
        </div>
        <div class="modal-body popup-container onboard_modal_body">
            <div id="inner_proj_methodo">
				
				<div class="cmn_onboad_pop">
					<div class="dtbl">
					  <div class="dtbl_cel">
						<a href="javascript:void(0);" class="creat_proj creat_proj-scrum" onclick="selectProjectMethodology('scrum');">
						  <figure>
							<img class="imgptype" src="<?php echo HTTP_ROOT;?>img/onboard/ssd<?php echo ($projectmethodology==2)?'-yes':'';?>.png" alt="Scrum Software development">
						  </figure>
						  <strong><?php echo __('Scrum Software development');?></strong>
						  <?php echo __('Making software development more enjoyable and productive');?>
						</a>
					  </div>
					  <div class="dtbl_cel">
						<a href="javascript:void(0);" class="creat_proj creat_proj-simple" onclick="selectProjectMethodology('simple');">
						  <figure>
							<img class="imgptype" src="<?php echo HTTP_ROOT;?>img/onboard/spm<?php echo ($projectmethodology==1)?'-yes':'';?>.png" alt="Simple Project Mamangemet">
						  </figure>	
						  <strong><?php echo __('Simple Project Management');?></strong>
						  <?php echo __('Do more than just "manage" your project');?>
						</a>
					  </div>
					</div>
				  </div>
				<div class="cb"></div>
				<input type="hidden" id="projectmethodology" value="<?php echo $projectmethodology;?>" />
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr onboard_page_wrap">                
				<div class="onboad_inp_fld">
					<input type="button" value="Continue" onclick="changeStep(4);closePopup();"  class="continue_btn">
				</div>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
