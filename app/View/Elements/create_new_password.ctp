<style type="text/css">
/*captach replacing*/
.grecaptcha-badge { 
	position: relative !important;
	bottom: 398px !important;
	right: 0 !important;
	left: 0px !important;
	margin: 0px auto !important;
	display: none !important;
}	
</style>
<?php /*<script src="https://www.google.com/recaptcha/api.js?render=<?php echo GCAPTCH_KEY;?>"></script> */?>
	<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Change Password');?>
                <span id="header_usr_name_edit" class="fnt-nrml ellipsis-view max-width-75"></span>
            </h4>
        </div>
        <div class="modal-body popup-container">
            <div class="row">
                <div class="col-lg-12">
                   
                   
                    <div class="form-group custom-drop-lebel label-floating mtop20">
                        <label class="control-label" for="password"><?php echo __('Password');?></label>
                        <input type="password" name="new_password" id="new_password" class="form-control" value=""/>
                    </div>
                    <div class="form-group custom-drop-lebel label-floating mtop20">
                        <label class="control-label" for="conform_password"><?php echo __('Conform Password');?></label>
                        <input type="password" name="new_conform_password" id="new_conform_password" class="form-control" value=""/>
                    </div>
					<?php /*for honey pot*/?>
					
                    
                    <div class="form-group custom-drop-lebel label-floating relative mtop20">

            </div>
                   
                    <div class="cb"></div>
                   
                    
                    <div class="">
                        <div class="btn_row fr">
                            <div id="subprof1-popup">
                                <div class="fl"><a class="btn btn-default btn_hover_link cmn_size fl" onclick="closePopup();"><?php echo __('Cancel');?></a></div>
                                <div class="fl btn-margin"><button type="button" value="Save" name="submit_password-popup"  id="submit_password-popup" class="btn btn_cmn_efect cmn_bg btn-info cmn_size fl"><?php echo __('Save');?></button></div>
                                <div class="cb"></div>
                            </div>
                            <span id="subprof2-popup" style="display:none">
                                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
                            </span>
                        </div>
                        <div class="cb"></div>
                    </div>
                    
                </div>
            </div>
        </div>       
    </div>
	<div class="popup_overlay_2"></div>
</div>
<script>
		$(function(){

        $("#submit_password-popup").click( function(e){					
            //  e.preventDefault();

            if(checkPassword($('#new_password').val(), $('#new_conform_password').val()) != false){
             $("#subprof1-popup").hide();
             $("#subprof2-popup").show();
             var url = HTTP_ROOT + "users/changeNewPassword";
             var password = $.trim($('#new_password').val());
            $.ajax({
                url: url,
                type: 'POST',
                dataType: "json",
                data:{"password" : password,"u_id" :  localStorage.getItem("unqID")},
                success: function(result) {
                    if(result.status == 'success'){
                        showTopErrSucc('success', "Password Updated");
                        $("#subprof2-popup").hide();
                        $("#subprof1-popup").show();
                        closePopup();
                    }else{
                        showTopErrSucc('error', "Password Update Fail");
                        $("#subprof2-popup").show();
                        $("#subprof1-popup").hide();
                    }
                }
            });
					}
        });
    });
    
</script>