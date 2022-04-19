<style type="text/css">
.profile_email_upd_inf {position: absolute;right: -29px;top: 10px;color: #959090;cursor:pointer;color: #ff0000;}
.profile_email_upd_inf:hover {color: #ff0000;}
.tipsy-inner { max-width: 280px;}
</style>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo GCAPTCH_KEY;?>"></script>
<div class="setting_wrapper task_listing myprofile-sett-page">
            <?php echo $this->form->create('User', array('url' => '/users/profile', 'onsubmit' => 'return submitProfile()', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal', 'autocomplete' => 'off')); ?>
	<div class="row m_0">
		<div class="col-md-5 col-sm-5 col-xs-12">
			<input type="hidden" name="data[User][csrftoken]" class="csrftoken" readonly="true" value="" />
			<div class="mtop20">
				<div class="field_wrapper nofloat_wrapper">
					<input type="text" name="data[User][name]" id="profile_name" class="" value="<?php echo $userdata['User']['name']; ?>"/>
					<div class="field_placeholder" for="profile_name"><span><?php echo __('First Name');?></span></div>
				</div>
            </div>
            <div class="mtop30">
				<div class="field_wrapper nofloat_wrapper">
					<input type="text" name="data[User][last_name]" id="profile_last_name" class="" value="<?php echo $userdata['User']['last_name']; ?>"/>
					<div class="field_placeholder" for="profile_last_name"><span><?php echo __('Last Name');?></span></div>
				</div>
            </div>
            <div class="mtop30">
				<div class="field_wrapper nofloat_wrapper">
					<input type="text" name="data[User][short_name]" id="short_name" class=""  value="<?php echo $userdata['User']['short_name']; ?>"/>
					<div class="field_placeholder" for="short_name"><span><?php echo __('Short Name');?></span></div>
				</div>
            </div>
			<?php /*for honey pot*/ ?>
			<div class="form-group custom-drop-lebel label-floating mtop30" style="display:none;">
			<input type="hidden" name="data[User][address1]" id="address1" class="form-control"  value=""/>
			<input type="hidden" name="data[User][address2]" id="address2" class="form-control"  value=""/>
			<input type="hidden" name="data[User][gender]" id="gender" class="form-control"  value="1"/>
			</div>
			
			<div class="mtop30">
				<div class="field_wrapper nofloat_wrapper">
					<input type="text" name="data[User][email]" id="email" class=""  value="<?php echo $userdata['User']['email']; ?>"/>
					<div class="field_placeholder" for="email"><span><?php echo __('Email');?></span></div>		
					
					<?php if(!empty($userdata['User']['update_email']) && !empty($userdata['User']['update_random'])){ ?>
						<span id="toltip_prof">
						<i class="material-icons profile_email_upd_inf" title="<?php echo _('Please login to').' '. ' \''.$userdata['User']['update_email'].'\' '.__('and change your email address');?>." rel="tooltip">info</i>
						</span>
					<?php } ?>
					
                <div>
                    <?php if (!empty($usrdata['User']['verify_string'])) { /*?>
                        <div class="dropdown messages-dropdown upgrade_nn">
                            <span id="varifyloader" class="email-varify-loader" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/small_loader1.gif"></span>
                            <a id="varifybtn" onclick="resendemail()" href="" class="dropdown-toggle upgrade_btn varify-email-btn">
                                <button class="btn email_btn blue_btn_sml orng-btn" type="button">
                                    <?php echo __('Verify your email Address');?>
                                </button>
                            </a>
                        </div>
                    <?php */ } else { ?>
                        <div class="verify-yes-icon">
                            <span><img title="<?php echo __('Email address verified');?>" rel="tooltip" src="<?php echo HTTP_IMAGES; ?>yes1.png"/></span>
                        </div>
                    <?php } ?>
                </div>
            </div>
            </div>
			<div class="mtop30">
				<div class="field_wrapper nofloat_wrapper">
					<input type="text" name="data[User][phone]" id="phone_num" class=""  value="<?php echo ($userdata['User']['phone'])?$userdata['User']['phone']:''; ?>" maxlength="17" onkeypress="return restrictAlpha(event)" />
					<div class="field_placeholder" for="phone_num"><span><?php echo __('Phone Number');?></span></div>	
				</div>
            </div>
            </div>
		<div class="col-md-1 col-sm-1 col-xs-12"></div>
		<div class="col-md-5 col-sm-5 col-xs-12">
            <div class="mtop20">
				<div class="select_field_wrapper up_select_control">
                <select name="data[User][timezone_id]" id="timezone_id"class="select form-control floating-label" placeholder="<?php echo __('Time Zone');?>" data-dynamic-opts=true>
                    <?php foreach ($timezones as $get_timezone) { ?>
                        <option  <?php if ($get_timezone['TimezoneName']['id'] == $userdata['User']['timezone_id']) { ?> selected <?php } ?> value="<?php echo $get_timezone['TimezoneName']['id']; ?>"><?php echo $get_timezone['TimezoneName']['gmt']; ?> <?php echo $get_timezone['TimezoneName']['zone']; ?></option>
                    <?php } ?>
                </select>
				</div>
				<div class="d-flex align-item-center font13 font-regular mtop10">
					<?php echo __('Do you want to set daylight saving time(DST)');?> ?
					<div class="togglebutton ml-15">
						<label>
							<input type="checkbox" name="data[User][is_dst]" id="user_is_dst" <?php if(isset($usrdata['User']['is_dst']) && $usrdata['User']['is_dst']){ ?>checked="checked"<?php } ?> style="cursor:pointer;" onclick="showDstMessage();">
						</label>
					</div>
				</div>
            </div>
            <div class="mtop20">
				<div class="select_field_wrapper up_select_control">
                <select name="data[User][language]" id="language_id"class="select form-control floating-label" placeholder="<?php echo __('Language');?>" data-dynamic-opts=true>
									<option  <?php if ($userdata['User']['language'] == 'dan') { ?> selected <?php } ?> value="dan">Danish</option>
									<option  <?php if ($userdata['User']['language'] == 'eng') { ?> selected <?php } ?> value="eng">English</option>									  
                   <option  <?php if ($userdata['User']['language'] == 'fra') { ?> selected <?php } ?> value="fra">French</option>
                   <option  <?php if ($userdata['User']['language'] == 'deu') { ?> selected <?php } ?> value="deu">German</option>
                   <option  <?php if ($userdata['User']['language'] == 'por') { ?> selected <?php } ?> value="por">Portuguese</option>
                   <option  <?php if ($userdata['User']['language'] == 'spa') { ?> selected <?php } ?> value="spa">Spanish</option>
                </select>
            </div>
            </div>
             <div class="mtop30">
				<div class="select_field_wrapper up_select_control">
                <select name="data[User][time_format]" id="timeformat_id"class="select form-control floating-label" placeholder="<?php echo __('Time Format');?>" data-dynamic-opts=true>
                   <option  <?php if ($userdata['User']['time_format'] == '12') { ?> selected <?php } ?> value="12">12 Hour Format</option>
                   <option  <?php if ($userdata['User']['time_format'] == '24') { ?> selected <?php } ?> value="24">24 Hour Format</option>                  
                </select>
            </div>
            </div>
            <div class="form-group custom-drop-lebel pro-img">
				<div class="upload_ospfl_image mtop20 pl-15">
                <label class="control-label" for="short_name"><?php echo __('Profile Image');?></label>
                <div id="profDiv"></div>
                <?php
                if (defined('USE_S3') && USE_S3) {
                    //if ($this->Format->pub_file_exists(DIR_USER_PHOTOS_S3_FOLDER, $userdata['User']['photo'])) {
					if ($userdata['User']['photo']) { 
                        $user_img_exists = 1;
                    }
                } elseif ($this->Format->imageExists(DIR_USER_PHOTOS, $userdata['User']['photo'])) {
                    $user_img_exists = 1;
                }
                if ($user_img_exists) {
                    ?>
                    <div id="existProfImg" onmouseover="showEditDeleteImg()" onmouseout="hideEditDeleteImg()">
                        <?php
                        if (defined('USE_S3') && USE_S3) {
                            $fileurl = $this->Format->generateTemporaryURL(DIR_USER_PHOTOS_S3 . $userdata['User']['photo']);
                        } else {
                            $fileurl = HTTP_ROOT . 'files/photos/' . $userdata['User']['photo'];
                        }
                        ?>
                        <div>
                            <a data-href="<?php echo $fileurl; ?>" href="javascript:void(0);" onClick="openProfilePopup()" class="d-flex-column align-item-center justify-center placeholder_user">
                                <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $userdata['User']['photo']; ?>&sizex=100&sizey=100&quality=100" border="0" id="profphoto"/>
                            </a>
                            <?php echo $this->Form->hidden('photo', array('class' => 'text_field', 'id' => 'imgName1', 'name' => 'data[User][photo]')); ?>
                            <?php echo $this->Form->hidden('exst_photo', array('value' => $userdata['User']['photo'], 'class' => 'text_field', 'name' => 'data[User][exst_photo]')); ?>
                        </div>
                        <div style="display:none" id="editDeleteImg">
                            <span id="uploadImgLnk">
                                <a title="Edit Profile Image" class="custom-t-type" href="javascript:void(0);" onClick="openProfilePopup()">
                                    <i class="material-icons size13 edit-link" title="Edit">&#xE254;</i>
                                </a>
                            </span>
                            <a title="Delete Profile Image"  class="custom-t-type" href="<?php echo HTTP_ROOT; ?>users/profile/<?php echo urlencode($userdata['User']['photo']); ?>">
                                <span onclick="return confirm('<?php echo __('Are you sure you want to delete');?>?')" > <i class="material-icons size13 delete-link" title="Delete">&#xE872;</i> </span>
                            </a>
                        </div>
                        <div class="cb"></div>
                    </div>
                <?php } else { ?>
					<div class="d-flex align-item-center justify-center">
						<div id="defaultUserImg" class="placeholder_user">
                        <img width="55" height="55" src="<?php echo HTTP_ROOT; ?>files/photos/profile_Img.png" onClick="openProfilePopup()">
                    </div>
						<div id="uploadImgLnk">									
                        <a href="javascript:void(0);" onClick="openProfilePopup()" ><?php echo __('Choose Profile Image');?></a>
                    </div>
					</div>
                    <input type="hidden" id="imgName1" name="data[User][photo]" />
                <?php } ?>
            </div>
            </div>
            <div class="profile-term-check checkbox pl-15">
                <label>
                    <?php echo $this->Form->input('', array('label' => FALSE, 'name' => 'data[User][isemail]', 'type' => 'checkbox', 'div' => FALSE, 'checked' => ($userdata['User']['isemail']) ? true : false)); ?>
                    <?php echo __('Keep me upto date with new features');?>
                </label>
            </div>
			<div class="btn_row mbtm20">
                    <div id="subprof1">
                        <div class="fl"><a class="btn btn-default btn_hover_link cmn_size fl" onclick="cancelProfile('<?php echo $referer; ?>');"><?php echo __('Cancel');?></a></div>
					<div class="fl btn-margin"><button type="button" value="Update" name="submit_Profile"  id="submit_Profile" class="btn btn_cmn_efect cmn_bg btn-info cmn_size fl" onclick="getRecap();"><?php echo __('Update');?></button></div>
												<div class="cb"></div>
                    </div>
                    <span id="subprof2" style="display:none">
                        <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
                    </span>
                </div>
								<div class="cb"></div>
            </div>
	</div>
            <?php echo $this->Form->end(); ?>
       </div>
<script type="text/javascript">
function getRecap(){
	checkCsrfToken('UserProfileForm');
	/*return true;
	$("input[name='g-recaptcha-response']").remove();
	grecaptcha.ready(function() {
		// response is promise with passed token
		grecaptcha.execute('<?php echo GCAPTCH_KEY;?>', {action: 'create_payment'}).then(function(token) {
			// add token to form			
			$('#UserProfileForm').prepend('<input type="hidden" name="g-recaptcha-response" value="' + token + '">');
			checkCsrfToken('UserProfileForm');
		});
	}); */
}
$(function() {
	/*select2 js customize event*/
	$('.up_select_control').click(function(){           
	if($(this).find('span').hasClass("select2-container--open")){
			$(this).addClass('open_label');        
	} else {
		//$(this).removeClass('open_label');
		$('.up_select_control').removeClass('open_label');
	}
	});
	/*end*/	
	$(".fixed-n-bar").hide();
	$('body').removeClass("open_hellobar");
	$('#language_id').select2();
	$('#timezone_id').select2();
	$('#timeformat_id').select2();
});
function restrictAlpha(e) {
		var unicode = e.charCode ? e.charCode : e.keyCode;
		if (unicode != 8) {
			if (unicode < 9 || unicode > 9 && unicode <= 46 || unicode > 57 || unicode == 47 || unicode == 186 || unicode == 58) {
					if (unicode == 40 || unicode == 41 || unicode == 45) {
						return true;
					} else {
						return false;
					}
			} else {
				return true;
			}
		} else {
				return true;
		}
	}
function showDstMessage(){
	showTopErrSucc('success', "<?php echo __('Please update your changes');?>.");
}
$(function() {
    var userId= '<?php echo SES_ID ;?>';
    var mode = 'profile';
    /* To fetch all skills for user profile page --Start-- */
    /* --End-- */
   
          
});
                                                                 
</script>