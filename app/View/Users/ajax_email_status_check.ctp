<style>
#txt_shortProjEdit {
	text-transform:uppercase;
}
</style>
<div class="modal-body popup-container">
    <div class="row">
        <div class="col-lg-12 padlft-non padrht-non" style="font-size: 15px;">
			<div><?php echo $Mesg['openMsg']; ?></div>
			<div><?php echo $Mesg['conMsg']; ?></div>
			<?php if($Mesg['err'] == 1){ ?>
				<div style="color:red;"><?php echo $Mesg['Msg']; ?></div>
			<?php }else{ ?>
				<div style="color:green;"><?php echo $Mesg['Msg']; ?></div>
			<?php } ?>
			<div class="cb"></div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="fr popup-btn">
            <span class="project_edit_button">
                <span class="fl cancel-link">
				<button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Ok Got It');?></button>
				</span>
            </span>
        </div>
    </div>
</div>