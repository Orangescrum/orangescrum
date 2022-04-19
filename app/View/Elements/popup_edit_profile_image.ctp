<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Profile Image');?></h4>
        </div>
        <div class="modal-body popup-container">
            <div id="inner_prof_img">
                <form enctype="multipart/form-data" method="POST" action="<?php echo HTTP_ROOT; ?>users/show_preview_img/" id="file_upload1" class="upload applied file_upload">
                    <div class="customfile" id="inputfileid" style="display:none;">                
                        <span aria-hidden="true" class="customfile-button"><?php echo __('Browse');?></span>                
                        <span aria-hidden="true" class="customfile-feedback"><?php echo __('Select your profile image');?>...</span>                
                        <input type="file" size="50"  name="data[User][photo]" class="fileupload customfile-input" id="upldphoto" >               
                    </div>
                    <table cellpadding="0" cellspacing="0" class="col-lg-12">
                        <tr>
                            <td>
                                <div class="profile-img-note"><?php echo __('Drag and set the box on the area you want to crop');?>.</div>
                                <br/>
                                <span id="profLoader" style="display:none">
                                    <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading..." width="16" height="16"/>
                                </span>
                                <div id="up_files_photo" class="up_files"></div>
                                <input type="hidden" id="imgName" name="data[User][photo]" />
                            </td>
                        </tr>
                        <tr>
                            <td>									
                                <!-- hidden inputs -->
                                <input type="hidden" id="x" name="x" />
                                <input type="hidden" id="y" name="y" />
                                <input type="hidden" id="w" name="w" />
                                <input type="hidden" id="h" name="h" />

                            </td>
                        </tr>	
                    </table>
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <div id="actConfirmbtn" style="display:none;">
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" onclick="doneCropImage();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size file_confirm_btn"><?php echo __('Confirm');?></a></span>
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size file_confirm_btn" data-dismiss="modal" onclick="profilePopupCancel();"><?php echo __('Cancel');?></button></span>
                    <div id="file_confirm_btn_loader" class="fl" style="width: 60px;display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></div>
                </div>
                <div id="inactConfirmbtn" style="display:block;">
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" onclick="javascript:void(0);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive"><?php echo __('Confirm');?></a></span>
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="profilePopupCancel();"><?php echo __('Cancel');?></button></span>
                </div>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
