<style>
.errror_spn {color:red;font-size:12px;}
</style>
<?php if(!isset($check_smtp)){ ?>
<div class="user_profile_con setting_wrapper task_listing thwidth">
<!--Tabs section starts -->

<?php echo $this->Form->create('SmtpSettings', array('url' => '/users/smtp_settings','id'=>'SmtpSettings', 'onsubmit'=>'return validateSettings()')); ?>
	<div class="row inv-sett-section">
		<div class="col-lg-12 padlft-non">
		
		
			<div class="col-lg-8 padlft-non">
				<div class="col-lg-2 padlft-non">
					<label class="" for="is_smtp">
					<input type="radio" name="data[smpt_mail_type]" id="is_smtp" class="form-radio" value="smtp" <?php if(!PHPMAILER){ ?>checked="checked"<?php } ?>/>
					<?php echo __('SMTP');?></label>
					
				</div>
				<div class="col-lg-2 padlft-non">
					<label class="" for="is_phpmailer">
					<input type="radio" name="data[smpt_mail_type]" id="is_phpmailer" class="form-radio" value="mailer" <?php if(PHPMAILER){ ?>checked="checked"<?php } ?>/>
					<?php echo __('PHP Mailer');?></label>
					
				</div>
			</div>
			<div class="cb"></div>
			<div class="col-lg-8 padlft-non">
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="host"><?php echo __('Host');?></label>
					<input type="text" name="data[host]" id="host" class="form-control" value="<?php echo SMTP_HOST;?>" />
					<span id="host_error" class="errror_spn"></span>
				</div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="port"><?php echo __('Port');?></label>
					<input type="text" name="data[port]" id="port" class="form-control" value="<?php echo SMTP_PORT;?>" placeholder="25, 465 or 587"  autocomplete="off"/>
					<span id="port_error" class="errror_spn"></span>
				</div>
			</div>
			<div class="cb"></div>
			<div class="col-lg-8 padlft-non">
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="email"><?php echo __('Username or Email Address');?></label>
					<input type="text" name="data[email]" id="email" class="form-control" value="<?php echo SMTP_UNAME;?>"  placeholder="youremail@gmail.com"/>
					<span id="email_error" class="errror_spn"></span>
				</div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="password"><?php echo __('Password');?></label>
					<input type="password" name="data[password]" id="password" class="form-control" value="<?php echo SMTP_PWORD;?>" />
					<span id="password_error" class="errror_spn"></span>
				</div>
			</div>
			<div class="cb"></div>
			<div class="col-lg-8 padlft-non">
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="from_email"><?php echo __('From Email');?></label>
					<input type="text" name="data[from_email]" id="from_email" class="form-control" value="<?php echo FROM_EMAIL;?>" />
					<span id="from_email_error" class="errror_spn"></span>
				</div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="notify_email"><?php echo __('Notify Email');?></label>
					<input type="text" name="data[notify_email]" id="notify_email" class="form-control" value="<?php echo FROM_EMAIL_EC;?>" />
					<span id="notify_email_error" class="errror_spn"></span>
				</div>
			</div>
			
			<div class="cb"></div>
			<div class="col-lg-8 padlft-non">
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<a href="javascript:void(0);" onclick="checkEmailStatus();" style="font-size: 15px;color: #2983FD;"><?php echo __('Verify Email');?></a>
				</div>
			</div>
			
		</div>
		<div class="cb"></div>
		<div class="mtop20">
			<div id="invoice-btns" class="fl">
					<div class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" onclick="cancelProfile('<?php echo $referer; ?>');"><?php echo __('Cancel');?></button></div>
					<div class="fl hover-pop-btn btn-margin"><button type="submit" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></button></div>
				<div class="cb"></div>
			</div>
			<span id="invoice-loader" style="display:none">
				<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
			</span>
			<div class="cb"></div>
		</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
 <script type="text/javascript">
    function validateSettings(){
		var is_smtp = $('#is_smtp').is(":checked");
		var is_phpmailer = $('#is_phpmailer').is(":checked");
		var host = $.trim($('#host').val());
		var port = $.trim($('#port').val());
		var email = $.trim($('#email').val());
		var password = $.trim($('#password').val());
		var from_email = $.trim($('#from_email').val());
		var notify_email = $.trim($('#notify_email').val());
		var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;        
		var done=1;
		if(host == ''){
			$('#host_error').text(_("Please enter your smtp host name"));
			done=0;
		}
		if(port == ''){
			$('#port_error').text(_("Please enter your smtp port"));
			done=0;
		}
		if(!is_phpmailer){
			if(email == ''){
				$('#email_error').text(_("Please enter your smtp username or email"));
				done=0;
			}
			if(password == ''){
				$('#password_error').text(_("Please enter your smtp password"));
				done=0;
			}
		}
		if(from_email == ''){
			$('#from_email_error').text(_("Please enter your from email"));
			done=0;
		}
		if(from_email != '' && !from_email.match(emailRegEx)){
			$('#from_email_error').text(_("Please enter a valid from email"));
			done=0;
		}
		if(notify_email != '' && !notify_email.match(emailRegEx)){
			$('#notify_email_error').text(_("Please enter a valid notify email"));
			done=0;
		}
		if(!done){
			return false;
		}else{
			return true;
		}
	}
	function checkEmailStatus(){
		if(validateSettings()){
			var is_smtp = $('#is_smtp').is(":checked");
			var is_phpmailer = $('#is_phpmailer').is(":checked");
			var host = $.trim($('#host').val());
			var port = $.trim($('#port').val());
			var email = $.trim($('#email').val());
			var password = $.trim($('#password').val());
			var from_email = $.trim($('#from_email').val());
			openPopup();
			$(".smtp_email_popup").show();
			$(".loader_dv_eml").show();
			$("#inner_eml_sts").hide();
			$(".eml_sts_pop").show();
			$.post(HTTP_ROOT + "users/ajax_email_status_check", {
				"is_smtp": is_smtp,
				"is_phpmailer":is_phpmailer,
				"host":host,
				"port":port,
				"email":email,
				"password":password,
				"from_email":from_email
			}, function(data) {
				if (data) {
					$(".loader_dv_eml").hide();
					$('#inner_eml_sts').show();
					$('#inner_eml_sts').html(data);
				}
			});
		}
	}
</script>
<?php }else{ ?>

	<div class="user_profile_con setting_wrapper task_listing thwidth">
<!--Tabs section starts -->
<?php echo $this->Form->create('SmtpOther', array('url' => '/users/smtp_settings/others','id'=>'te1234567', 'onsubmit'=>'return validateSettings()')); ?>
<div class="row inv-sett-section">
	<div class="col-lg-12 padlft-non">
			<div class="col-lg-12 form-group custom-drop-lebel add_new_opt ">
				<label class="control-label" for="bkt_name"><?php echo __('Google Keys');?></label>
				<span class="cmn_labl_message">(<?php echo __('Used for Google login, Google contact and Google drive');?>)</span>
				<div class="cb"></div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="api_key"><?php echo __('API KEY');?></label>
					<input type="text" name="data[api_key]" placeholder="xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx" autocomplete="off" class="form-control" value="<?php if(API_KEY !='xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx'){ echo API_KEY; } ?>"/>
				</div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="client_id"><?php echo __('CLIENT ID');?></label>
					<input type="text" name="data[client_id]" placeholder="XXXXXXXXXXXX.apps.googleusercontent.com" autofocus="1" autocomplete="off" class="form-control" value="<?php if(CLIENT_ID !='XXXXXXXXXXXX.apps.googleusercontent.com'){ echo CLIENT_ID; } ?>"/>
				</div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="client_secret"><?php echo __('CLIENT SECRET');?></label>
					<input type="text" name="data[client_secret]" placeholder="xXxXXxxxx_xXxXXxxxx" autocomplete="off" class="form-control" value="<?php if(CLIENT_SECRET !='xXxXXxxxx_xXxXXxxxx'){ echo CLIENT_SECRET; } ?>"/>
				</div>
			</div>
			
			<div class="col-lg-6 form-group custom-drop-lebel add_new_opt ">
					<label class="control-label" for="bkt_name"><?php echo __('Dropbox');?></label>
					<span class="cmn_labl_message">(<?php echo __('Used for dropbox file sharing');?>)</span>
				<div class="cb"></div>
				<div class="col-lg-6 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="db_key"><?php echo __('API KEY');?></label>
					<input type="text" name="data[db_key]" placeholder="xXxxXxxxXx" autocomplete="off" class="form-control" value="<?php if(DROPBOX_KEY !='xXxxXxxxXx'){ echo DROPBOX_KEY; } ?>"/>
				</div>
			</div>
			
			
			<div class="col-lg-12 form-group custom-drop-lebel add_new_opt ">
				<label class="control-label" for="bkt_name"><?php echo __('AWS S3 Bucket');?></label>
				<span class="cmn_labl_message">(<?php echo __('Used for file storage');?>)</span>
				<div class="cb"></div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="bkt_name"><?php echo __('BUCKET NAME');?></label>
					<input type="text" name="data[bkt_name]" placeholder="Bucket Name"  autocomplete="off" class="form-control" value="<?php if(BUCKET_NAME !='Bucket Name'){ echo BUCKET_NAME; } ?>"/>
				</div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="aws_key"><?php echo __('AWS Access Key');?></label>
					<input type="text" name="data[aws_key]" placeholder="XXXXXXXXXXXXXX"  autocomplete="off" class="form-control" value="<?php if(awsAccessKey !='XXXXXXXXXXXXXX'){ echo awsAccessKey; } ?>" />
				</div>
				<div class="col-lg-4 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="aws_secret"><?php echo __('AWS Secret Key');?></label>
					<input type="text" name="data[aws_secret]" placeholder="XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX"  autocomplete="off" class="form-control" value="<?php if(awsSecretKey !='XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX'){ echo awsSecretKey; } ?>"/>
				</div>
			</div>
			
			<div class="col-lg-6 form-group custom-drop-lebel add_new_opt ">
					<label class="control-label" for="bkt_name"><?php echo __('Wkhtmltopdf');?></label>
					<span class="cmn_labl_message">(<?php echo __('Used for PDF file export');?>)</span>
				<div class="cb"></div>
				<div class="col-lg-6 form-group custom-drop-lebel add_new_opt padlft-non">
					<label class="control-label" for="db_key"><?php echo __('Path');?></label>
					<input type="text" name="data[wkhtml_path]" placeholder="" autocomplete="off" class="form-control" value="<?php if(PDF_LIB_PATH !=""){ echo PDF_LIB_PATH; } ?>"/>
				</div>
			</div>
		</div>
		<div class="cb"></div>
		<div class="mtop20">
			<div id="invoice-btns" class="fl">
					<div class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" onclick="cancelProfile('<?php echo $referer; ?>');"><?php echo __('Cancel');?></button></div>
					<div class="fl hover-pop-btn btn-margin"><button type="submit" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></button></div>
				<div class="cb"></div>
			</div>
			<span id="invoice-loader" style="display:none">
				<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
			</span>
			<div class="cb"></div>
		</div>
	<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
	function validateSettings(){
		return true;
	}
</script>
<?php } ?>
