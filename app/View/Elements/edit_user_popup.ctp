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
            <h4><?php echo __('Edit User');?>
                <span><img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png"></span>
                <span id="header_usr_name_edit" class="fnt-nrml ellipsis-view max-width-75"></span>
            </h4>
        </div>
        <div class="modal-body popup-container">
            <div class="row">
                <div class="col-lg-12">
										<div id="edit_user_recaptcha" style="display:none;"></div>
                    <?php echo $this->form->create('User', array('url' => '/users/profile', 'onsubmit'=>'', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal','id'=>'profile-edit-popup', 'autocomplete' => 'off')); ?>
                    <!--<input type="hidden" name="data[User][csrftoken]" class="csrftoken" readonly="true" value="" />-->
                    <input type="hidden" name="data[User][id]" id="profile-id-popup" class="csrftoken"  value="" />
                    <div class="form-group custom-drop-lebel label-floating mtop20">
                        <label class="control-label" for="profile_name"><?php echo __('First Name');?></label>
                        <input type="text" name="data[User][name]" id="profile_name-popup" class="form-control" value=""/>
                    </div>
                    <div class="form-group custom-drop-lebel label-floating mtop20">
                        <label class="control-label" for="profile_last_name"><?php echo __('Last Name');?></label>
                        <input type="text" name="data[User][last_name]" id="profile_last_name-popup" class="form-control" value=""/>
                    </div>
                    <div class="form-group custom-drop-lebel label-floating mtop20">
                        <label class="control-label" for="short_name"><?php echo __('Short Name');?></label>
                        <input type="text" name="data[User][short_name]" id="short_name-popup" class="form-control"  value=""/>
                    </div>
					<?php /*for honey pot*/?>
					<div class="form-group custom-drop-lebel label-floating mtop20" style="display:none;">
					<input type="hidden" name="data[User][address1]" id="address1_popup" class="form-control"  value=""/>
					<input type="hidden" name="data[User][address2]" id="address2_popup" class="form-control"  value=""/>
					<input type="hidden" name="data[User][gender]" id="gender_popup" class="form-control"  value="1"/>
					</div>
					
                    <div class="form-group custom-drop-lebel label-floating relative mtop20">
                        <label class="control-label" for="email"><?php echo __('Email');?></label>
                        <input type="text" name="data[User][email]" id="email-popup" class="form-control"  value=""/>
                        <div id="emailVarify-popup"></div>
                    </div>
                    
                    <div class="form-group custom-drop-lebel mtop20">
                        <select name="data[User][timezone_id]" id="timezone_id-popup"class="select form-control floating-label" placeholder="<?php echo __('Time Zone');?>" data-dynamic-opts=true>
                        <?php if (isset($timezones) && !empty($timezones)) : ?>
                            <?php foreach ($timezones as $get_timezone) { ?>
                                <option  <?php if ($get_timezone['TimezoneName']['id'] == $userdata['User']['timezone_id']) { ?> selected <?php } ?> value="<?php echo $get_timezone['TimezoneName']['id']; ?>"><?php echo $get_timezone['TimezoneName']['gmt']; ?> <?php echo $get_timezone['TimezoneName']['zone']; ?></option>
                            <?php } ?>
                        <?php endif; ?>
                        </select>
                    </div>
                    <div class="form-group custom-drop-lebel pro-img " style="margin: 0;">
                        <label class="control-label" for="short_name"><?php echo __('Profile Image');?></label>
                        <div id="profDiv-popup"></div>
                        <div id="IMG-DIV"></div>
                    </div>
                    <div class="profile-term-check checkbox">
                        <label>
                            <?php echo $this->Form->input('', array('label' => FALSE, 'name' => 'data[User][isemail]', 'type' => 'checkbox', 'div' => FALSE,'id'=>'profile-is-email-popup')); ?>
                            <?php echo __('Keep me upto date with new features');?>
                        </label>
                    </div>

                    <div class="cb"></div>
                    <div class="">
                        <div class="btn_row fr">
                            <div id="subprof1-popup">
                                <div class="fl"><a class="btn btn-default btn_hover_link cmn_size fl" onclick="closePopup();"><?php echo __('Cancel');?></a></div>
                                <div class="fl btn-margin"><button type="button" value="Update" name="submit_Profile"  id="submit_Profile-popup" class="btn btn_cmn_efect cmn_bg btn-info cmn_size fl"><?php echo __('Update');?></button></div>
                                <div class="cb"></div>
                            </div>
                            <span id="subprof2-popup" style="display:none">
                                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
                            </span>
                        </div>
                        <div class="cb"></div>
                    </div>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>       
    </div>
	<div class="popup_overlay_2"></div>
</div>
<script>
		$(function(){
            $('.select2-selection__choice__remove').on('click', function(){
                $(this).parent('.select2-selection__choice').remove();
            });
			$('#submit_Profile-popup').off().on('click', function(){
				$("input[name='g-recaptcha-response']").remove();
				$("#profile-edit-popup").submit();
				/*grecaptcha.ready(function() {
					// response is promise with passed token
					grecaptcha.execute('<?php echo GCAPTCH_KEY;?>', {action: 'create_payment'}).then(function(token) {
						// add token to form			
						$('#profile-edit-popup').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
						$("#profile-edit-popup").submit();
					});
				});*/
			});
        $("#profile-edit-popup").submit(function(e){					
             e.preventDefault();
            if(submitProfile('popup') != false){
             $("#subprof1-popup").hide();
             $("#subprof2-popup").show();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: "json",
                data:$(this).serialize(),
                success: function(result) {
                    $("#subprof2-popup").hide();
                    $("#subprof1-popup").show();
                    /*Function to save skills --Start--*/
                    saveUserSkills();
                    /*Function to save skills -- End --*/
                    if(typeof result.close !='undefined'){
                        showTopErrSucc('success',result.error);
                        var profile_name = $('#profile_name-popup').val().toString();
                        profile_name = profile_name.replace(/<[^>]*>/g, '');
                        $('#pn_'+$('#profile-id-popup').val()).text(profile_name).attr('data-usr-name',profile_name).attr('title',profile_name);
                         $('#edit-exist-usr'+$('#profile-id-popup').val()).attr('data-usr-name',profile_name);

                        $('#psn_'+$('#profile-id-popup').val()).text($('#short_name-popup').val());
                        if($('#email-popup').val().length > 25){
                            var formated_email=$('#email-popup').val().substr(0, 24)+'...';
                        }else{
                            var formated_email=$('#email-popup').val();
                        }
                        $('#pemail_'+$('#profile-id-popup').val()).html(formated_email).attr('title',$('#email-popup').val());
                        imgN=$("#exst_photo-popup").val();
                        if($("#imgName1-popup").val()!=''){
                          imgN=$("#imgName1-popup").val();  
                        }
                        img="<img class='lazy' src='"+HTTP_ROOT+"files/photos/"+imgN+"' width='94' height='94' />";
                        if(($("#imgName1-popup").val()!='' || $("#exst_photo-popup").val()!='') && typeof imgN !='undefined' ){
                            $('#pimg_'+$('#profile-id-popup').val()).html(img);
                        }else{
                            $('#pimg_'+$('#profile-id-popup').val()).html('<span class="name_txt">'+$('#profile_name-popup').val().charAt(0)+'</span>');
                        }
                        //$('#pcr_'+$('#profile-id-popup').val()).html($('#short_name-popup').val());
                        //$('#pla_'+$('#profile-id-popup').val()).html();
                        closePopup();
                    }else{
                        showTopErrSucc('error',result.error);
                    }
                }
            });
					}
        });
    });
    function removeImgPopup(img){
        if(confirm('Are you sure you want to delete?')){
            $.get(img,function(res){
                var obj = JSON.parse(res);
                 showTopErrSucc('success',obj.error);
                 $("#imgName1-popup").val('');
                 $("#exst_photo-popup").val('');
                 //$("#profphoto-popup").attr('src',HTTP_ROOT+'files/photos/profile_Img.png');	
				 $('#IMG-DIV').html('<div id="defaultUserImg-popup" class="fl"><img width="55" height="55" src="'+HTTP_ROOT+'files/photos/profile_Img.png" onClick="openProfilePopup(\'popup\')" id="profphoto-popup"></div>\n\
                            <div id="uploadImgLnk-popup" class="fl mtop20 editDeleteImg-popup"><a href="javascript:void(0);" onClick="openProfilePopup(\'popup\')" ><?php echo __('Choose Profile Image');?></a></div><div class="cb"></div><input type="hidden" id="imgName1-popup" name="data[User][photo]" />');				 
                 $('#pimg_'+$('#profile-id-popup').val()).html('<span class="name_txt">'+$('#profile_name-popup').val().charAt(0)+'</span>');
				 
            });
        }
    }
	function removeImgPopupTmp(){
		 $('#IMG-DIV').html('<div id="defaultUserImg-popup" class="fl"><img width="55" height="55" src="'+HTTP_ROOT+'files/photos/profile_Img.png" onClick="openProfilePopup(\'popup\')" id="profphoto-popup"></div>\n\
                            <div id="uploadImgLnk-popup" class="fl mtop20 editDeleteImg-popup"><a href="javascript:void(0);" onClick="openProfilePopup(\'popup\')" ><?php echo __('Choose Profile Image');?></a></div><div class="cb"></div><input type="hidden" id="imgName1-popup" name="data[User][photo]" />');	
	}
</script>