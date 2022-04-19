<style>
#myModalSignup .modal-dialog {width:450px;font-family: 'RobotoDraft-Regular';}
#login_dialog_signup h4 {font-size:13px;text-transform: capitalize;margin-top: -10px;margin-bottom: 0px;text-align:center;font-weight:500;line-height: 18px;}
#login_dialog_signup .free_account_popup form{display:block;width:100%;margin:0;padding:0;}
#login_dialog_signup .form-group.mtop-0{margin-top:0}
#login_dialog_signup .form-group.mbtm-0{margin-bottom:0}
#login_dialog_signup .form-group{margin:24px 0 10px}
#login_dialog_signup .ha-url .form-group{margin-top:15px}
#login_dialog_signup .cstmpop-select-label .form-group{margin:0}
#login_dialog_signup .cstmpop-select-label .form-group.label-floating label.control-label{top:-30px}
#login_dialog_signup .cstmpop-select-label select{padding-left:0}
#su_bmit_nps button{display:block;width:100%;background:#389ADC;font-size:16px;color: #fff;padding:6px 20px;margin:0 0 10px;}
#su_bmit_nps .no-crd-req{text-align:center;font-size:12px}
#login_dialog_signup #seo_url_nps{height:35px}
#login_dialog_signup .domainname.input_http{padding-left:0}
#login_dialog_signup .bdr_or{position: relative;margin: 25px auto;text-align: center;border-top: 1px solid #ddd;width: 72%;}
#login_dialog_signup .bdr_or span{position:absolute;left: 0;right: 0;top: -10px;
    margin: auto;z-index: 9;background: #fff;display: inline-block;width: 50px;}
#login_dialog_signup .goole_btn{text-align:center}
#login_dialog_signup .goole_btn a{background:transparent;padding:0;border:none}
#login_dialog_signup .ha-url .signup-g-text{left:-68%}

#myModalSignup .modal-header {border-bottom:1px solid #d2d2d2;}
#myModalSignup .modal-title {margin-bottom: 10px;text-align:center;}
#myModalSignup .modal-content .modal-body {padding-right: 45px; padding-left: 45px;}
#myModalSignup .showafteremail {display:none;}

#myModalSignup .goole_btn a {text-decoration: none; font-size: 12px;line-height: 30px;color: #F34A38;font-weight: 500;letter-spacing: 1px; display: inline-block;text-align: center;outline: none;background: #F5F5F5;padding: 4px 20px;border-radius: 3px;}
#myModalSignup .g_plus {background: url(../img/home_outer/fld-icon-sp.png) no-repeat 0px 0px;display: inline-block;position: relative;    vertical-align: middle;background-position: 0px -182px;top: -1px;height: 30px;width: 46px;}


</style>
<div class="modal fade pdf_download_popup_kjhjk" id="myModalSignup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" onclick="stopShowSignup();">&times;</button>
			<h4 class="modal-title"><?php echo __('Create Your Free Account');?></h4>
        </div>
        <div class="modal-body">
			<div id="login_dialog_signup" style="display:block">
                    <h4><strong>76,000+</strong> <?php echo __('companies use Orangescrum to collaborate and manage projects everyday');?>.</h4>
                    <div id="signupsuccess_nps" style="text-align:center;width:100%;border:0px solid #666666;height:450px;display:none;">
						<img src="<?php echo HTTP_ROOT; ?>img/inbox.png" title="Inbox(1)" alt="Inbox(1)"/>
						<h3 class="reg" style="text-align:center;color:#FF7E00;font-size:30px;padding-top:10px;"><?php echo __('Thanks for Signing up');?></h3>
						<h3 class="reg" style="text-align:center;color:#5B767D;font-size:24px;padding-top:10px;"><?php echo __('Just one more step');?>...</h3>
						<div id="msgsuccess_nps" class="sml_hd_1 faq_ans" style="text-align:center;color:#333333;padding-top:10px;font-size:20px;">
							<?php echo __('A confirmation email is sent');?>,<br/><?php echo __('please activate your account and start using Orangescrum right away');?>.
						</div>
						<div class="faq_an" style="text-align:center;color:#333333;font-size:18px;padding-top:30px;">
							<?php echo __('If you do not receive any email');?>, <?php echo __('please feel free to');?> <br/><a href="mailto:support&#64;orangescrum&#46;com?subject=Please activate my Account" style="color:#FF7E00"><?php echo __('contact us');?></a> <?php echo __("and we'll activate it for you");?>.
						</div>
					</div>
					
					<?php if (isset($google_user_info['email']) && !empty($google_user_info['email'])) { ?>
					<?php } else { ?>
					<!--<div class="goole_btn">
						<a href="javascript:void(0)" class="btn btn_cmn_efect" onclick="googlesignuphome();signinWithGoogle();">
							<img src="<?php echo HTTP_ROOT; ?>img/images/gsignup.png"/>
						</a>
					</div>-->
					
					<div class="goole_btn">
						<a href="javascript:void(0)" onclick="googlesignuphome();signinWithGoogle();ga_tracking_google_signup('Signup Page');" class="btn btn_cmn_efect">
						<span class="fld_icon g_plus"></span>
						<?php echo __('One-click sign up using Google');?>
						</a>
					</div>
					
					<div class="bdr_or"><span>OR</span></div>
					<?php } ?>
					
                    <input type="hidden" name="hid_beta_token" id="hid_beta_token_nps" value="<?php echo $Token; ?>" />
                    <div class="free_account_popup">
					<?php echo $this->Form->create('User',array('url'=>HTTP_ROOT.'users/register_user/','onsubmit'=>'return validateForm()','id'=>'side_SIgnUp_nps')); ?>
                    <div class="log_sup_cnt">
                        <div class="form-group label-floating mtop-0">
                            <label class="control-label" for="email_nps"><?php echo __('Email');?></label>
                            <?php
                            $g_email_exist = 0;
                            if (isset($google_user_info['email']) && !empty($google_user_info['email'])) {
                            $g_email = $google_user_info['email'];
                            $g_email_exist = $google_user_info['isEmail'];
                            $readonly = "readonly";
                            $style = "background:#eee;";
                            if (intval($g_email_exist)) {
                            $readonly = "";
                            $style = "background:#fff;";
                            }
                            }
                            if($Email) {
                            echo $this->Form->text('email',array('class'=>'form-control','title'=>'Email','id'=>'email_nps', 'onchange'=>'validate_nps("email_nps")','autocomplete'=>'off','value'=>$Email,'readonly'=>'readonly'));
                            } elseif($g_email) {
                            echo $this->Form->text('email',array('class'=>'form-control','title'=>'Email','id'=>'email_nps', 'style'=>$style,'onchange'=>'validate_nps("email_nps")','autocomplete'=>'off','value'=>$g_email,'readonly'=>$readonly));
                            } else {
                            echo $this->Form->text('email',array('class'=>'form-control','title'=>'Email','id'=>'email_nps', 'onchange'=>'validate_nps("email_nps")','autocomplete'=>'off'));
                            }
                            ?>
							<?php if($g_email_exist) {?>
								<div id="email_exist_nps" style="font-size:11px;color:#FF0000; margin-left:5px;"><?php echo __('Email already exists! Please try another');?></div>
							<?php } else {?>
								<div id="email_exist_nps" style="display:none;font-size:11px;color:#FF0000; margin-left:5px;"></div>
							<?php }?>
                        </div>
                        <?php if (isset($google_user_info['email']) && !empty($google_user_info['email'])) { ?>
                        <?php } else { ?>
                        <div class="passm-15 form-group label-floating mtop-0 showafteremail">
                            <label class="control-label" for="password"><?php echo __('Password');?></label>
                            <?php echo $this->Form->password('password',array('class'=>'form-control','id'=>'password_nps','title'=>'Password(6 - 30 characters)','onchange'=>'validate_nps("password_nps")','maxlength'=>30,'autocomplete'=>'off')); ?><div id="password_err_nps" style="display:block;font-size:11px; position:absolute;top: 55px; left:2px;color:#FF0000"></div>
                            <span class="hint">(6 - 30 <?php echo __('characters');?>)<span class="hint-pointer">&nbsp;</span></span>
                        </div>
                        <?php } ?>
                        <div class="cstmpop-select-label showafteremail">
							<div class="form-group label-floating is-empty mv-label-up">
								<label class="control-label" for="industry"><?php echo __('Select an Industry');?></label>
								<?php echo $this->Form->input('industry', array('options' => $industries,'empty' => false, 'class'=>'select form-control floating-label','label'=>false,'div'=>false,'id'=>'industry_nps','title'=>'Industry', 'onchange'=>'showOthers_nps(this);', 'data-dynamic-opts'=>true, 'placeholder'=>'')); ?>
								<div id="industry_nps_others_dv_nps" class="form-group label-floating is-empty" style="display: none;">
									<input id="industry_nps_other_nps" class="form-control" type="text" autocomplete="off" name="data[User][industry_others]" placeholder="Enter Your Industry">
								</div>
							</div>
						</div>
						<div class="ha-url showafteremail">
							<div class="form-group col-lg-3 padnon">
							  <input class="domainname input_http form-control" type="text" placeholder="https://" disabled="" readonly = 'readonly'>
							</div>
							<div class="form-group label-floating col-lg-4 padnon">
							  <label class="control-label" for="focusedInput1"><?php echo __('Access URL');?></label>
							  <?php echo $this->Form->text('seo_url',array('class'=>'form-control domain_ipad','id'=>'seo_url_nps','title'=>'Access URL', 'onchange'=>'validate_nps("seo_url_nps")','autocomplete'=>'off')); ?>
							</div>
							<div class="form-group col-lg-5 padnon">
							  <input class="form-control domainname input_url" type="text" name="dname" disabled="" readonly = 'readonly' value="<?php echo DOMAIN_COOKIE;?>">
							</div>
							<div class="cb"></div>
							<div id="seo_url_exist_nps" style="display:none;font-size:14px;color:#FF0000;margin-top:5px;"></div>
							<p class="signup-g-text"><?php echo __("Each Orangescrum account gets a unique web address. For example, if you want your Orangescrum address to be apple.orangescrum.com, you'd enter apple");?>".</p>
							<div class="question-mark"></div>
						</div>
						<input type="hidden" name="data[User][timezone_id]" id="timezone_id_nps" value="">
						<input type="hidden" value="<?php if($membership_type){echo $sub_details[$membership_type]['Subscription']['plan'];}?>" name="plan_id" id="plan_id_nps">
						<div id="su_bmit_nps">
							<button type="button" value="Save" name="submit_button" id="submit_button_nps" class="btn btn_cmn_efect" onclick="return validateForm_nps()" ><?php echo __('Start My FREE Trial');?></button> 
							<img src="<?php echo HTTP_ROOT."img/images/case_loader2.gif"; ?>" alt="Loading" id="submit_loader" style="display:none;"/>
							<div class="no-crd-req"><?php echo __('Get started. No credit card required');?></div>
							<div class="no-crd-req" style="margin-top:10px;">Already have an account? <a href="<?php echo HTTP_ROOT.'users/login'; ?>"><?php echo __('Sign in');?></a>.</div>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
				
            </div>
        </div>
      </div>      
    </div>
  </div>
  <script type="text/javascript">
  $(document).ready(function() {
    $('#industry_nps').val(0);
	if($('#email_nps').val()){
		$('#seo_url').focus();
	}
	var visitortime = new Date();
	var visitortimezone = -visitortime.getTimezoneOffset()/60;
	$('#timezone_id_nps').val(visitortimezone);
	$.material.init();
});
function showOthers_nps(obj) {
    var id = $(obj).attr('id');
    $("#" + id + "_others_nps").val('');
    if ($.trim($("#" + id + " option[value='" + $(obj).val() + "']").text()) && $.trim($("#" + id + " option[value='" + $(obj).val() + "']").text()) === "Others") {
        $("#" + id + "_others_dv_nps").show();
        $("#" + id + "_other_nps").focus();
        $("#" + id + "_other_nps").css({
            border: 'none'
        });
    } else {
        $("#" + id + "_others_dv_nps").hide();
    }
}
function validateForm_nps(obj) {
    var form_id = (typeof($(obj).closest('form').attr('id')) == "undefined") ? "side_SIgnUp_nps" : $(obj).closest('form').attr('id');
    var fld_id_prec = (form_id == "side_SIgnUp_nps") ? "" : form_id + "_";
    $("#signupsuccess_nps").hide();
    $("#login_dialog_nps").show();

    $(".success_msg_nps").hide();
    $("#email_exist_nps").hide();
    var error_flag = 1;
    var name = '';
    var last_name = '';
    var seo_url = $.trim($("#" + fld_id_prec + "seo_url_nps").val());
    var company = '';
    var email = $.trim($("#" + fld_id_prec + "email_nps").val());
    var password = $.trim($("#" + fld_id_prec + "password_nps").val());
    var industry = $.trim($("#" + fld_id_prec + "industry_nps").val());
    var industry_val = $.trim($("#" + fld_id_prec + "industry_nps option[value='" + industry + "']").text());	
	var coupon_code = $.trim($("#coupon_code").val());

    var new_industry = "";
    if (industry_val === "Others") {
        new_industry = $.trim($("#" + fld_id_prec + "industry_nps_other_nps").val());
    }

    var plan_id = $("#" + fld_id_prec + "plan_id_nps").val();    
    var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var letterNumber = /^[0-9a-zA-Z]+$/;

    if (email == "") {
        //$("#email").css({"border":"1px solid #FF0000"});
        $("#" + fld_id_prec + "email_nps").parent('div').addClass('has-error');
        $("#" + fld_id_prec + "email_nps").focus();
        error_flag = 0;
    } else if (error_flag == 1) {
        if (!email.match(emailRegEx)) {
            //$("#email").css({"border":"1px solid #FF0000"});
            $("#" + fld_id_prec + "email_nps").parent('div').addClass('has-error');
            $("#" + fld_id_prec + "email_nps").focus();
            error_flag = 0;
        }
    }
	if(error_flag == 1){
		$('.showafteremail').show();
	}
    if ($("#" + fld_id_prec + "password_nps").length) {
        if (password == "") {
            $("#" + fld_id_prec + "password_nps").parent('div').addClass('has-error');
            $("#" + fld_id_prec + "password_nps").focus();
            error_flag = 0;
        } else if ($("#" + fld_id_prec + "password_nps").val().length < 6 || $("#password_nps").val().length > 30) {
            $("#" + fld_id_prec + "password_nps").parent('div').addClass('has-error');
            $("#" + fld_id_prec + "password_err_nps").show();
            $("#" + fld_id_prec + "password_err_nps").html('Password should be between 6-30 characters!');
            $("#" + fld_id_prec + "su_bmit_nps").css("padding-top", "20px");
            $("#" + fld_id_prec + "password_nps").focus();
            error_flag = 0;
        } else if (error_flag == 1) {
            $("#" + fld_id_prec + "password_nps").parent('div').removeClass('has-error');
            error_flag = 1;
        }
    }
	
	if(error_flag ==1){
		if (industry == 0) {
			$("#" + fld_id_prec + "industry_nps").parent('div').addClass('has-error');
			if (!$("#" + fld_id_prec + "industry_nps").parent('div').hasClass('is-empty')) {
				$("#" + fld_id_prec + "industry_nps").parent('div').addClass('is-empty');
			}
			$("#" + fld_id_prec + "industry_nps").focus();
			error_flag = 0;
		} else if (industry !== 0 && industry_val == "Others") {
			var industry_others = $.trim($("#" + fld_id_prec + "industry_nps_other_nps").val());

			if (industry_others === "") {
				$("#" + fld_id_prec + "industry_nps_other_nps").parent('div').addClass('has-error');
				$("#" + fld_id_prec + "industry_nps_other_nps").focus();
				error_flag = 0;
			} else {
				$("#" + fld_id_prec + "industry_nps_other_nps").parent('div').removeClass('has-error');
				error_flag = 1;
			}
		} else if (error_flag == 1) {
			$("#" + fld_id_prec + "industry_nps").parent('div').removeClass('has-error');
			error_flag = 1;
		}
	}
	if(error_flag ==1){
		if (seo_url == "") {
			$("#" + fld_id_prec + "seo_url_nps").parent('div').addClass('has-error');
			$("#" + fld_id_prec + "seo_url_nps").focus();
			error_flag = 0;
		} else if (!seo_url.match(letterNumber)) {
			$("#" + fld_id_prec + "seo_url_nps").parent('div').addClass('has-error');
			$("#" + fld_id_prec + "seo_url_exist_nps").show();
			$("#" + fld_id_prec + "seo_url_exist_nps").html("Only letters and numbers are allowed.");
			$("#" + fld_id_prec + "seo_url_nps").focus();
			error_flag = 0;
		} else if (error_flag == 1) {
			$("#" + fld_id_prec + "seo_url_nps").parent('div').removeClass('has-error');
			error_flag = 1;
		}
	}
    if (seo_url.toLowerCase() == 'helpdesk') {
        alert('Access URL "helpdesk" is already exists!\nPlease choose another one.');
        error_flag = 0;
        return false;
    }else if(seo_url.toLowerCase() == 'api'){
		alert('Access URL "api" is already exists!\nPlease choose another one.');
		error_flag=0;
		return false;
	}else if(seo_url.toLowerCase() == 'blah'){
		alert('Access URL "blah" is already exists!\nPlease choose another one.');
		error_flag=0;
		return false;
	}
    $("#coupon_code_nps").css({
        "border": "1px solid #D4D4D4"
    });

    if (!error_flag) {
        return false;
    }
    if ($('#basic_mtype').is(":checked") || $('#team_mtype').is(":checked") || $('#business_mtype').is(":checked") || $('#premium_mtype').is(":checked")) {
        if (validation_succ) {
            return false;
        }
    }

    var strURL = "<?php echo HTTP_ROOT; ?>";
    $("#" + fld_id_prec + "submit_button_nps").hide();
    $("#" + fld_id_prec + "submit_loader_nps").show();
    $("#" + fld_id_prec + "seo_url_exis_npst").hide();
    $("#" + fld_id_prec + "email_exist_nps").hide();
    $("#coupon_err_nps").hide();


    var is_agree = 1;
    $.post(strURL + "users/validate_emailurl", {
        "email": escape(email),
        "seo_url": escape(seo_url),
        "coupon_code": escape(coupon_code)
    }, function(data) {
        if (data.email == 'error' || data.seourl == 'error') {
            $("#" + fld_id_prec + "submit_button_nps").show();
            $("#" + fld_id_prec + "submit_loader_nps").hide();
            if (data.email == 'error') {
                $("#" + fld_id_prec + "email_nps").parent('div').addClass('has-error');
                $("#" + fld_id_prec + "email_nps").focus();
                $("#" + fld_id_prec + "email_exist_nps").show('slow');
                $("#" + fld_id_prec + "email_exist_nps").html(data.email_msg);
            }
            if (data.seourl == 'error') {
                $("#" + fld_id_prec + "seo_url_nps").parent('div').addClass('has-error');
                $("#" + fld_id_prec + "seo_url_exist_nps").show('slow');
                $("#" + fld_id_prec + "seo_url_exist_nps").html(data.seourl_msg);
            }
            if (data.coupon == 'error') {
                $("#coupon_code_nps").css({
                    "border": "1px solid #FF0000"
                });
                $("#coupon_err_nps").show('slow');
                $("#coupon_err_nps").html(data.coupon_msg);
            }
        } else {
            name = email.split('@')[0];
            company = seo_url;
            $('#cover_nps').show();
            $('#cover_nps').css({
                position: 'fixed',
                opacity: '0.7 !important'
            });
            $('#donot_refresh').show();
            var contact_phone = '';
            var timezone_id = $("#" + fld_id_prec + "timezone_id_nps").val().trim();
            if (plan_id) {                
            } else {
                $.post(strURL + "users/register_user", {
                    "plan_id": escape(plan_id),
                    "name": escape(name),
                    "last_name": escape(last_name),
                    "company": escape(company),
                    "seo_url": escape(seo_url),
                    "email": escape(email),
                    "password": escape(password),
                    "industry_id": industry,
                    "new_industry": new_industry,
                    'contact_phone': escape(contact_phone),
                    'timezone_id': escape(timezone_id),
                    'is_agree': is_agree
                }, function(data) {
                    var msg = jQuery.parseJSON(data);
                    if (msg.loggedin == 'loggedin') {
                        //Code for leader tracking sign up SDP
                        var useremail = jQuery("#" + fld_id_prec + "email_nps").val();
                        var username = useremail.substring(0, useremail.lastIndexOf("@"));
                        setSuptrackCookie('suptrack_usr_name', username, 365 * 10);
                        setSuptrackCookie('suptrack_usr_email', useremail, 365 * 10);
                        jQuery.post("<?php echo LDTRACK_URL; ?>users/saveleads", {
                                usr_code: getSuptrackCookie('suptrack_usr_code'),
                                name: username,
                                email: jQuery("#" + fld_id_prec + "email").val(),
                                phone: '',
                                start: '',
                                typeapps: '',
                                about: '',
                                loc: '<?php echo $_SERVER['
                                REMOTE_ADDR '];?>',
                                domain: '<?php echo HTTP_ROOT; ?>',
                                refer: getSuptrackCookie('suptrack_refer')
                            },
                            function(data) {
                                /* Code for Create Event tracking starts here */
                                var sessionEmail = jQuery("#" + fld_id_prec + "email").val();
                                var eventRefer = 'Regular Signup From Home Page Footer Form';
                                var event_name = 'Signup';

                                if (eventRefer && event_name) {
                                    trackEventLeadTrackerOuter(event_name, eventRefer, sessionEmail);
                                }
                                /* Code for Create Event tracking ends here */
                                if (getSuptrackCookie('suptrack_usr_name') && getSuptrackCookie('suptrack_usr_code')) {
                                    jQuery.post("<?php echo LDTRACK_URL; ?>users/updatepages", {
                                            usr_code: getSuptrackCookie('suptrack_usr_code'),
                                            usr_pages: getSuptrackCookie('suptrack_usr_pages')
                                        },
                                        function(data) {
                                            window.location = HTTP_APP + "users/login";
                                        }).fail(function(response) {
                                        window.location = HTTP_APP + "users/login";
                                    });
                                }
                            }).fail(function(response) {
                            window.location = HTTP_APP + "users/login";
                        });
                        return false;
                    }
                    if (msg.msg === "success") {
                        if (parseInt(msg.isGoogle)) {
                            createCookie("GOOGLE_INFO_SIGIN", msg.google_data, 1, DOMAIN_COOKIE);
                            window.location = HTTP_APP + "users/login";
                        } else {
                            $("#" + fld_id_prec + "submit_button_nps").show();
                            $("#" + fld_id_prec + "submit_loader_nps").hide();
                            $('#cover').hide();
                            $('#donot_refresh').hide();
							
                            $("#msgsuccess_nps").html("A confirmation link is sent to '" + email + "',<br/>please activate your account and start using Orangescrum rightaway.");
                            $("#signupsuccess_nps").slideDown('slow');
                            $("#login_dialog_nps").hide();

                            $('html, body').animate({
                                scrollTop: 0
                            }, 400);
                            $(".err_succ_nps").hide();

                            $("#" + fld_id_prec + "name_nps").val('');
                            $("#" + fld_id_prec + "last_name_nps").val('');
                            $("#" + fld_id_prec + "company_nps").val('');
                            $("#" + fld_id_prec + "email_nps").val('');
                            $("#" + fld_id_prec + "password_nps").val('');
                            $("#" + fld_id_prec + "seo_url_nps").val('');
                            $("#" + fld_id_prec + "contact_phone_nps").val('');
                            $("#" + fld_id_prec + "confirm_password_nps").val('');

                            // Conversion Tracking for GA and FB
                            conversionTracking('FREE');
                        }
                    } else {
                        $("#" + fld_id_prec + "submit_button_nps").show();
                        $("#" + fld_id_prec + "submit_loader_nps").hide();
                        $('#cover_nps').hide();
                        $('#donot_refresh').hide();

                        $(".err_succ_nps").hide();
                        $('#cover_nps').hide();
                        $('#donot_refresh').hide();
                        $(".error_msg_nps").show();
                        $(".error_msg_nps").html();
                        $("#" + fld_id_prec + "submit_button_nps").show();
                        $("#" + fld_id_prec + "submit_loader_nps").hide();
                        $('html, body').animate({
                            scrollTop: 0
                        }, 400);
                        if (msg.msg === "helpdesk") {
                            alert('Access URL "helpdesk" is already exists!\nPlease choose another one.');
                        } else if(msg.msg === "api"){
							alert('Access URL "api" is already exists!\nPlease choose another one.');
						} else if(msg.msg === "blah"){
							alert('Access URL "blah" is already exists!\nPlease choose another one.');
						} else {
                            alert("Something is wrong! Please try again after few minutes");
                        }
                    }
                });
            }
        }
    }, 'json');
    return false;
}
function validate_nps(id) {
	$("#email_exist_nps").hide();
	$("#password_err_nps").hide();
	if($.trim($("#"+id).val())) {
		//$("#"+id).css({"border":"1px solid #D4D4D4"});
		if(id == "email_nps") {
			var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!$("#"+id).val().trim().match(emailRegEx)){
				//$("#"+id).css({"border-bottom":"1px solid #FF0000"});
			}
		}
		if(id == "password_nps") {
			if($("#password_nps").val().length < 6 || $("#password_nps").val().length > 30){
				$("#password_err_nps").show();
				//$("#"+id).css({"border":"1px solid #FF0000"});
			}
		}
	}else {
		//$("#"+id).css({"border":"1px solid #FF0000"});
	}
	if(id == "seo_url_nps") {		
		var seo_url = $("#"+id).val().trim();
		var letterNumber = /^[0-9a-zA-Z]+$/;
		if(seo_url) {
			if(seo_url.match(letterNumber))	{
			   $("#seo_url_exist_nps").hide();
			   //$("#"+id).css({"border":"1px solid #D4D4D4"});
			}else {
				//$("#"+id).css({"border":"1px solid #FF0000"});
				$("#seo_url_exist_nps").show('slow');
				$("#seo_url_exist_nps").html("Only letters and numbers are alloweded.");
			}
		}
	}
}
function stopShowSignup(){
	// Save data to sessionStorage
	var dt = new Date();
    sessionStorage.setItem('stopShowSignup', dt.getDate());
}   
<?php if(CONTROLLER != "home"){ ?>
function googlesignuphome(){
    setSessionStorageOuter('Google Signup From Home Page', 'Signup');
}
<?php } ?>
</script>