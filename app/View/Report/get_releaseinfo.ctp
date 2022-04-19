<div class="modal-header">
    <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
    <?php if($rl_data['Release']['is_hyperlink'] == 1){ ?>
    	<h4 id="header_rlinfo"><a href="<?php echo HTTP_ROOT.$rl_data['Release']['hyperlink_url'];?>" class="link_url"><?php echo $rl_data['Release']['title'];?></a></h4>
    <?php } else{ ?>
    	<h4 id="header_rlinfo"><?php echo $rl_data['Release']['title'];?></h4>
    <?php } ?>
</div>
<div class="modal-body popup-container">
    <?php /*?><div class="loader_dv" style="display: block;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div><?php */?>
    <?php if($rl_data['Release']['is_hyperlink'] == 1){ 
    	if (strpos($rl_data['Release']['description'], '[HOST]') !== false) {
    		$rl_data['Release']['description'] = str_replace('[HOST]', HTTP_ROOT.$rl_data['Release']['hyperlink_url'], $rl_data['Release']['description']);
    	}
    } ?>
	<p><?php echo $rl_data['Release']['description'];?></p>
</div>
<div class="modal-footer popup-footer">
    <div class="text-right">
        <button type="button" id="" name="" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="closePopup();" >
            <span>Ok</span>
		</button>
    </div>
</div>