<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="header_sprint"><?php echo __('Create Sprint');?></h4>
        </div>
        <div class="loader_dv" id="addeditSprnt"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
        <div id="inner_sprint" class="mils_ipad">
			<?php echo $this->element('ajax_new_sprint'); ?>
		</div>
    </div>
</div>