<?php if($domain){?>
<script>
    $(function(){
        var automatic="<?php echo $insert_automatic;?>";
         $('#seo_url').val("<?php echo $domain;?>");
        if(automatic){
            $('#submit_button').trigger('click');
        }
    });

    </script>
<?php } ?>
<style>
.outer_cmn_wrapper.form-slider{width:70%}
	#login_dialog h4{font-size:14px;text-align:center;margin:0 0 5px}
    .section-testimonials{background:#334f67;padding:30px 20px;height:625px;box-shadow:0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);}
.section-testimonials .testimonials-info img{border:none}
.section-testimonials .bx-wrapper .bx-viewport{background:none;border:none;box-shadow:none;-webkit-box-shadow:none;-moz-box-shadow:none;height:330px !important;margin-top:100px}
.section-testimonials .bx-wrapper .bx-pager.bx-default-pager a:hover,.section-testimonials .bx-wrapper .bx-pager.bx-default-pager a.active {background:#FBAA16}
.section-testimonials .bx-wrapper .bx-pager.bx-default-pager a{background:#ccc}
.section-testimonials .bx-wrapper .bx-controls.bx-has-controls-auto.bx-has-pager .bx-pager{width:100%;text-align:center}
    p.author-name,p.testimonials-text,p.author-name em{float:none;color:#fff;display:block;line-height:26px;text-align:center}
    p.author-name,p.testimonials-text{padding-top:0px;padding-bottom:0;font-size:16px}
    .author-name em{font-size:16px;font-weight:bold;margin:10px;}
    .testimonials-info{padding:0;width:100%;height:auto;}
    .slider-wrapper-txt{width:100%;height:100%;margin:20px 0 0;}
    .slider-p-img{width:130px;height:130px;display:block;margin:0 auto 20px;}
    .slider-p-img img{max-width:100%;width:100%;height:100%;margin:0;float:none;padding:0;}
.cmn_bluebg_slider{padding-left:0;margin-top:108px;}
.plan_price {padding-bottom:0px;}
#su_bmit {margin:10px 0px;}
.signin_link {margin-top: 5px; font-family: "Open Sans"; font-weight: 500; color: rgb(128, 128, 128); font-size: 12px; text-align: center; margin-bottom: 0px;}
.signin_link a, .signin_link a:hover {color: #2a59a9;}
h5 a.btn-link.tearms_of_ser,h5 a.btn-link.tearms_of_ser:hover {color: #2a59a9;}
.no-crd-req{font-size: 12px;text-align: center;margin: 5px 0 0px;font-family: "Open Sans";color: rgb(128, 128, 128);}
@media only screen and (max-width:1100px) {
.cmn_bluebg_slider{display:none}
}
@media only screen and (max-width:850px) {
.outer_cmn_wrapper.form-slider{width:90%}
}
</style>
<link rel="stylesheet" type="text/css" href="../css/jquery.bxslider.css">
<div id="donot_refresh" class="donot_refresh" style="display:none;"><span style="margin-top: 3px;">Just a moment... we're setting up your account.<br/>Please don't refresh or close this page.</span><br/><span><img src="<?php echo HTTP_ROOT;?>img/payment_loading.gif" style="padding:5px;"/></span></div>
<?php if(defined('RELEASE_V') && RELEASE_V){
	$file_not_exist = 0;
	if(!$this->Format->is_url_exist(HTTP_ROOT.'img/header/orangescrum-logo.svg')){
		$file_not_exist = 1;
	}
	?>
	<script type="text/javascript">
	var flext_t = "<?php echo $file_not_exist; ?>";
	if(parseInt(flext_t)){
	   window.location.reload();
	}
    $(function(){
        $.material.init();
        $(".select").dropdown({"optionClass": "withripple"});
    });
	var GID_NO = '<?php echo CLIENT_ID_NUM; ?>'; // XXXXXXXXXXXX
	var DRP_NO = '<?php echo DROPBOX_KEY; ?>'; // xXxxXxxxXx
	var SMTP_UNAME = '<?php echo SMTP_UNAME; ?>'; // xXxxXxxxXx
	var SMTP_PWORD = '<?php echo SMTP_PWORD; ?>'; // xXxxXxxxXx
	var SKIP_MAIL_CHK = '<?php echo SKIP_MAIL_CHK; ?>'; // xXxxXxxxXx
</script>
<div class="top_sec" style="padding-top:0px;">
<div class="outer_cmn_wrapper form-slider">
<div class="row login_sup_page">
	<div class="col-lg-12">
    <div class="wrapper_sup">
		</div>
            <div  class="col-lg-3" style="padding-right:0"></div>
		<div  class="col-lg-7" style="padding-right:0">
                    <div class="satsf_img"><a href="<?php echo HTTP_ROOT; ?>"><img src="<?php echo HTTP_ROOT; ?>img/header/orangescrum-logo.svg" alt="Orangescrum"/></a></div>
        <div class="cmn_bdr_shadow">
            <div id="signupsuccess" style="text-align:center;width:100%;border:0px solid #666666;height:450px;display:none;">
                <img src="<?php echo HTTP_ROOT; ?>img/inbox.png" title="Inbox(1)" alt="Inbox(1)"/>
                <h3 class="reg" style="text-align:center;color:#FF7E00;font-size:30px;padding-top:10px;">Thanks for Signing up</h3>
                <h3 class="reg" style="text-align:center;color:#5B767D;font-size:24px;padding-top:10px;">Just one more step...</h3>
                <div id="msgsuccess" class="sml_hd_1 faq_ans" style="text-align:center;color:#333333;padding-top:10px;font-size:20px;">
                    A confirmation email is sent,<br/>please activate your account and start using Orangescrum right away.
                </div>
                <div class="faq_an" style="text-align:center;color:#333333;font-size:18px;padding-top:30px;">
                    If you do not receive any email, please feel free to <br/><a href="mailto:support@orangescrum.com?subject=Please activate my Account" style="color:#FF7E00">contact us</a> and we'll activate it for you.
                </div>
            </div>
            <div id="login_dialog" style="display:block">
                <h2>Get started in 60 seconds</h2>
                <h4>The right choice for smart people to get things done effortlessly</h4>
                
                <input type="hidden" name="hid_beta_token" id="hid_beta_token" value="<?php echo $Token; ?>" />
                <?php echo $this->Form->create('User',array('url'=>HTTP_ROOT.'users/register_user/','onsubmit'=>'return validateForm()')); ?>
                <div class="log_sup_cnt">
                    <div class="form-group label-floating">
                        <label class="control-label" for="email">Email</label>
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
                        echo $this->Form->text('email',array('class'=>'form-control','title'=>'Email','id'=>'email', 'onchange'=>'validate("email")','autocomplete'=>'off','value'=>$Email,'readonly'=>'readonly'));
                        } elseif($g_email) {
                        echo $this->Form->text('email',array('class'=>'form-control','title'=>'Email','id'=>'email', 'style'=>$style,'onchange'=>'validate("email")','autocomplete'=>'off','value'=>$g_email,'readonly'=>$readonly));
                        } else {
                        echo $this->Form->text('email',array('class'=>'form-control','title'=>'Email','id'=>'email', 'onchange'=>'validate("email")','autocomplete'=>'off'));
                        }
                        ?>
                        <?php if($g_email_exist) {?>
                                            <div id="email_exist" style="font-size:11px;color:#FF0000; margin-left:5px;">Email already exists! Please try another</div>
<?php } else {?>
                                            <div id="email_exist" style="display:none;font-size:11px;color:#FF0000; margin-left:5px;"></div>
<?php }?>
                    </div>
                    <?php if (isset($google_user_info['email']) && !empty($google_user_info['email'])) { ?>
                    <?php } else { ?>
                    <div class="passm-15 form-group label-floating">
                        <label class="control-label" for="password">Password</label>
                        <?php echo $this->Form->password('password',array('class'=>'form-control','id'=>'password','title'=>'Password(6 - 30 characters)','onchange'=>'validate("password")','maxlength'=>30,'autocomplete'=>'off')); ?><div id="password_err" style="display:block;font-size:11px; position:absolute;top: 55px; left:2px;color:#FF0000"></div>
                        <span class="hint">(6 - 30 characters)<span class="hint-pointer">&nbsp;</span></span>
                    </div>
                    <?php } ?>
                    <div class="cstmpop-select-label" style="display:none;">
                        <div class="form-group label-floating is-empty mv-label-up">
                            <label class="control-label" for="industry">Select an Industry</label>
                            <?php echo $this->Form->input('industry', array('options' => $industries,'empty' => false, 'class'=>'select form-control floating-label','label'=>false,'div'=>false,'id'=>'industry','title'=>'Industry', 'onchange'=>'showOthers(this);', 'data-dynamic-opts'=>true, 'placeholder'=>'')); ?>
                            <div id="industry_others_dv" class="form-group label-floating is-empty" style="display: none;">
                                <input id="industry_other" class="form-control" type="text" autocomplete="off" name="data[User][industry_others]" placeholder="Enter Your Industry">
                            </div>
                        </div>
                    </div>
                    <div>
                        <!--<div class="form-group col-lg-2 padnon">
                          <input class="domainname input_http form-control" type="text" placeholder="https://" disabled="" readonly = 'readonly'>
                        </div>-->
                        <div class="form-group label-floating col-lg-6 padnon">
                          <label class="control-label" for="focusedInput1">Company Name</label>
                          <?php echo $this->Form->text('seo_url',array('class'=>'form-control domain_ipad','id'=>'seo_url','title'=>'Access URL', 'onchange'=>'validate("seo_url")','autocomplete'=>'off')); ?>
                        </div>
                        <!--<div class="form-group col-lg-4 padnon">
                          <input class="form-control domainname input_url" type="text" name="dname" disabled="" readonly = 'readonly' value="<?php echo DOMAIN_COOKIE;?>">
                        </div>-->
                        <div class="cb"></div>
                        <div id="seo_url_exist" style="display:none;font-size:14px;color:#FF0000;margin-top:5px;"></div>
                    </div>
                    <input type="hidden" name="data[User][timezone_id]" id="timezone_id" value="">
                    <input type="hidden" value="<?php if($membership_type){echo $sub_details[$membership_type]['Subscription']['plan'];}?>" name="plan_id" id="plan_id">
                    <div id="su_bmit">
                        <button type="button" value="Save" name="submit_button" id="submit_button" class="btn btn_cmn_efect" onclick="return validateForm()" >Sign up</button> 
                        <img src="<?php echo HTTP_ROOT."img/images/case_loader2.gif"; ?>" id="submit_loader" style="display:none;"/>
                        <div class="signin_link">Already have an account? <a href="<?php echo HTTP_ROOT; ?>users/login">Sign in</a>.</div>
                    </div>                    
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>	
    </div>
</div>
</div>
</div>
<?php } ?>                     
<div class="cb"></div>
<div class="footer_btm">
<div class="" style="padding:15px 0px;text-align:center;">
<span class="pink" style="margin-left:0px;">
&copy; 2011-<?php echo date('Y'); ?> Orangescrum.
<a target="_blank" href="http://www.andolasoft.com/">Andolasoft</a>
. 
<a href="https://www.orangescrum.com/termsofservice" target="_blank">Terms</a>
 & 
 <a href="https://www.orangescrum.com/privacypolicy" target="_blank">Privacy</a>
</span>
<div class="cb"></div>
</div>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.tipsy.js"></script>
<script type="text/javascript">
// CVC must contain only numeric value
$(document).ready(function() {
    $('#industry').val(0);
	$('#email').focus();
	if($('#email').val()){
		$('#seo_url').focus();
	}
	var visitortime = new Date();
	var visitortimezone = -visitortime.getTimezoneOffset()/60;
	$('#timezone_id').val(visitortimezone);
	$('[rel=tooltip]').tipsy({gravity:'s', fade:true});
    $("#card_cvc,#card_number,#expiry_month,#expiry_year").keydown(function(event) {
        // Allow: backspace, delete, tab, escape, and enter
        if ( event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 ||
             // Allow: Ctrl+A
            (event.keyCode == 65 && event.ctrlKey === true) ||
             // Allow: home, end, left, right
            (event.keyCode >= 35 && event.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        } else {
            // Ensure that it is a number and stop the keypress
            if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105 )) {
                event.preventDefault();
            }
        }
    });
    $("#industry").val(0);
	$('#membership_type_dropdown').on('change',function(){
                var inpts = $( "#membership_type_dropdown option:selected" ).attr('data-vals');
                inpts = inpts.split('__');
                payment_div(inpts[0],inpts[1],inpts[2],inpts[3],inpts[4],inpts[5]);
	});
});

setGoogleInfo();
function setGoogleInfo() {
    var strURL = "<?php echo HTTP_ROOT;?>";
    $.post(strURL+"users/setGoogleInfo",{},function(data) {

    });
}
function validateForm() {
	if(SMTP_UNAME == 'youremail@gmail.com' || SMTP_UNAME.trim() == '' || SMTP_PWORD == '******' && !SKIP_MAIL_CHK){
		alert('Oops! You have not yet set the SMTP credentials in app/Config/constants.php.\nPlease update the SMTP deatails before proceed sign up.'); return false;
	}
	$("#signupsuccess").hide();
	$("#login_dialog").show();

	$(".success_msg").hide();
	$("#email_exist").hide();
	var error_flag =1;
	var name = '';
	var last_name = '';
	var seo_url = $.trim($("#seo_url").val());
	var company = '';
	var email =$.trim($("#email").val());
	var password =$.trim($("#password").val());
	var industry =$.trim($("#industry").val());
	var industry_val = $.trim($("#industry option[value='"+industry+"']").text());
	
	var new_industry = "";
	if (industry_val === "Others") {
	    new_industry = $.trim($("#industry_other").val());
	}
	
	var plan_id = $('#plan_id').val();
	var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	var letterNumber = /^[0-9a-zA-Z]+$/;

	if(email == "") {
		//$("#email").css({"border":"1px solid #FF0000"});
        $('#email').parent('div').addClass('has-error');
		$("#email").focus();
		error_flag=0;
	}else if(error_flag == 1) {
		if(!email.match(emailRegEx)){
			//$("#email").css({"border":"1px solid #FF0000"});
            $('#email').parent('div').addClass('has-error');
			$("#email").focus();
			error_flag=0;
		}
	}

	if($("#password").length){
		if(password == "") {
			//$("#password").css({"border":"1px solid #FF0000"});
            $('#password').parent('div').addClass('has-error');
			$("#password").focus();
			error_flag=0;
		}else if($("#password").val().length < 6 || $("#password").val().length > 30){
			//$("#password").css({"border":"1px solid #FF0000"});
            $('#password').parent('div').addClass('has-error');
			$("#password_err").show();
			$("#password_err").html('Password should be between 6-30 characters!');
			$("#su_bmit").css("padding-top","20px");
			$("#password").focus();
			error_flag=0;
		}else if(error_flag == 1){
			//$("#password").css({"border":"1px solid #D4D4D4"});
            $('#password').parent('div').removeClass('has-error');
			error_flag=1;
		}
	}

	/*if (industry == 0) {
	    //$("#industry").css({"border":"1px solid #FF0000"});
        $('#industry').parent('div').addClass('has-error');
        if(!$('#industry').parent('div').hasClass('is-empty')){$('#industry').parent('div').addClass('is-empty');}
	    $("#industry").focus();
	    error_flag=0;
	} else if (industry !== 0 && industry_val == "Others") {
	    var industry_others = $.trim($("#industry_other").val());

	    if (industry_others === "") {
			//$("#industry_others").css({"border":"1px solid #FF0000"});
            $('#industry_other').parent('div').addClass('has-error');
			$("#industry_other").focus();
			error_flag=0;
	    } else {
			//$("#industry_others").css({"border":"1px solid #D4D4D4"});
            $('#industry_other').parent('div').removeClass('has-error');
			error_flag=1;
	    }
	} else if(error_flag == 1) {
	    //$("#industry").css({"border":"1px solid #D4D4D4"});
        $('#industry').parent('div').removeClass('has-error');
	    error_flag=1;
	}*/
	industry = 17;
	if(seo_url == "") {
		//$("#seo_url").css({"border":"1px solid #FF0000"});
        $('#seo_url').parent('div').addClass('has-error');
		$("#seo_url").focus();
		error_flag=0;
		//return false;
	}else if(!seo_url.match(letterNumber)){
		//$("#seo_url").css({"border":"1px solid #FF0000"});
        $('#seo_url').parent('div').addClass('has-error');
		$("#seo_url_exist").show();
		$("#seo_url_exist").html("Only letters and numbers are allowed.");
		$("#seo_url").focus();
		error_flag=0;
		//return false;
	}else if(error_flag == 1) {
		//$("#seo_url").css({"border":"1px solid #D4D4D4"});
        $('#seo_url').parent('div').removeClass('has-error');
		error_flag=1;
	}
	if(!error_flag){
		return false;
	}
	if($('#basic_mtype').is(":checked") ||$('#team_mtype').is(":checked") || $('#business_mtype').is(":checked") || $('#premium_mtype').is(":checked")){
		if(validation_succ){return false;}
	}

	var strURL = "<?php echo HTTP_ROOT;?>";
	$("#submit_button").hide();
	$("#submit_loader").show();
	$("#seo_url_exist").hide();
	$("#email_exist").hide();
	$("#coupon_err").hide();	

	var is_agree = 1;
	$.post(strURL+"users/validate_emailurl",{"email":escape(email)},function(data) {
		if(data.email=='error' || data.seourl=='error'){
                    $("#submit_button").show();
                    $("#submit_loader").hide();
                    if(data.email=='error'){
                        //$("#email").css({"border":"1px solid #FF0000"});
                        $('#email').parent('div').addClass('has-error');
                        $('#email').focus();
                        $("#email_exist").show('slow');
                        $("#email_exist").html(data.email_msg);
                    }
                    if(data.coupon=='error'){
                            $("#coupon_code").css({"border":"1px solid #FF0000"});
                            $("#coupon_err").show('slow');
                            $("#coupon_err").html(data.coupon_msg);
                    }
		}else{
                name = email.split('@')[0];
                company = seo_url;
                $('#cover').show();
                $('#cover').css({position:'fixed',opacity:'0.7 !important'});
                $('#donot_refresh').show();
                var contact_phone = '';
                var timezone_id = $("#timezone_id").val().trim();

                $.post(strURL+"users/register_user",{"plan_id":escape(plan_id),"name":escape(name),"last_name":escape(last_name),"company":escape(company),"seo_url":escape(seo_url),"email":escape(email),"password":escape(password),"industry_id":industry,"new_industry" : new_industry, 'contact_phone':escape(contact_phone),'timezone_id':escape(timezone_id),'is_agree':is_agree},function(data) {
                         var msg = jQuery.parseJSON(data);
                         if(msg.loggedin == 'loggedin'){						
													 window.location=HTTP_APP+"users/login";
													 return false;
                         }
                         if(msg.msg === "success") {
                           if (parseInt(msg.isGoogle)) {
                               createCookie("GOOGLE_INFO_SIGIN", msg.google_data, 1, DOMAIN_COOKIE);
                               window.location=HTTP_APP+"users/login";
                           } else {
                                     $("#submit_button").show();
                                     $("#submit_loader").hide();
                                     $('#cover').hide();
                                     $('#donot_refresh').hide();

                                     //$(".success_msg").show('slow');
                                     //$(".success_msg").html("Thanks for Signing up. An activation link is sent to '"+email+"' for confirmation,<br/> Please click that and start using Orangescrum rightaway.");

                                     $("#msgsuccess").html("A confirmation link is sent to '"+email+"',<br/>please activate your account and start using Orangescrum rightaway.");
                                     $("#signupsuccess").slideDown('slow');
                                     $("#login_dialog").hide();

                                     $('html, body').animate({ scrollTop: 0 }, 400);
                                     $(".err_succ").hide();

                                     $("#name").val(''); $("#last_name").val(''); $("#company").val(''); $("#email").val(''); $("#password").val('');
                                     $("#seo_url").val(''); $("#contact_phone").val('');
                                     $("#confirm_password").val('');
                                     // Conversion Tracking for GA and FB
                                     conversionTracking('FREE');
                           }
                        }else {
                                     $("#submit_button").show();
                                     $("#submit_loader").hide();
                                     $('#cover').hide();
                                     $('#donot_refresh').hide();

                                     $(".err_succ").hide();
                                     $('#cover').hide();
                                     $('#donot_refresh').hide();
                                     $(".error_msg").show();
                                     $(".error_msg").html();
                                     $("#submit_button").show();
                                     $("#submit_loader").hide();
                                     $('html, body').animate({ scrollTop: 0 }, 400);
                                     if(msg.msg === "helpdesk"){
                                             alert('Access URL "helpdesk" is already exists!\nPlease choose another one.');
                                     } else if(msg.msg === "api"){
                                             alert('Access URL "api" is already exists!\nPlease choose another one.');
                                     }else{
                                             alert("Something is wrong! Please try again after few minutes");
                                     }
                        }
               });
            }
	},'json');
	return false;
}
function validate(id) {
	$("#email_exist").hide();
	$("#password_err").hide();
	if($.trim($("#"+id).val())) {
		$("#"+id).css({"border":"1px solid #D4D4D4"});
		//$("#"+id+"_right").show();
		if(id == "email") {
			var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if(!$("#"+id).val().trim().match(emailRegEx)){
				$("#"+id).css({"border":"1px solid #FF0000"});
			}
		}
		if(id == "password") {
			if($("#password").val().length < 6 || $("#password").val().length > 30){
				$("#password_err").show();
				$("#"+id).css({"border":"1px solid #FF0000"});
			}
		}
	}else {
		$("#"+id).css({"border":"1px solid #FF0000"});
	}

	if(id == "seo_url") {
		var seo_url = $("#"+id).val().trim();
		var letterNumber = /^[0-9a-zA-Z]+$/;
		if(seo_url) {
			if(seo_url.match(letterNumber))	{
			   $("#seo_url_exist").hide();
			   $("#"+id).css({"border":"1px solid #D4D4D4"});
			}else {
				 $("#"+id).css({"border":"1px solid #FF0000"});
				$("#seo_url_exist").show('slow');
				$("#seo_url_exist").html("Only letters and numbers are alloweded.");
			}
		}
	}
}
function hideSuccess() {
	$(".success_msg").fadeOut();
}
function hideError() {
	$(".error_msg").fadeOut();
}

function payment_div(price,plan_id,mem_type,user_limit,project_limit,storage){
        var ulim = user_limit;
        var plim = project_limit;
        var slim = storage;
	if(slim > 1024){
	    slim = slim/1024;
	    slim = slim+' GB';
	}else{
	     if(slim != 'Unlimited')
	    	slim = slim+' MB';
	}
	var str_limit = '<span>'+ulim+'</span> Users, <span>'+plim+'</span> Projects, <span>'+slim+'</span> storage';
	if(mem_type == 'free'){
		var ft = "<?php echo FREE_TRIAL_PERIOD; ?>";
		 str_limit = str_limit+'<br /><span style="font-weight:bold;">'+ft+'</span></b>-day FREE trial';
	}        
	$('#payment_user_limit').html(str_limit);
    
	if(mem_type == 'free'){
		$('#card_info').slideUp();
		$('#plan_id').val('');
		$('#payment_instruction').slideUp();
	}else{
		$('#plan_id').val(plan_id);
		$('#monthlyprice').html(price);
		$("#name_oncard").val('');
		$("#card_number").val('');
		$("#expiry_date").val('');
		$("#card_cvc").val('');
		$('#card_info').slideDown();
		$('#payment_instruction').slideDown();
	}
}
$('#UserSignupForm input').keydown(function(e) {
    if (e.keyCode == 13) {
       validateForm();
    }
});
function conversionTracking(account_type){return true;}
$('#email').blur(function(){
        var email=$('#email').val();
        var start=email.lastIndexOf('@');
        var email=email.substring(start+1);
        var end=email.indexOf('.');
        var value=email.substring(0, end);
        var arr=new Array('yahoo','hotmail','live','reddif','outlook','rediff','aim','zoho','icloud','mail','gmax','shortmail','inbox','gmail');
        if($.inArray(value,arr)==-1){
            $('#seo_url').val(value);
        }
    });
	$(".dropdown").change(function() {
	if ($.trim($(this).val())) {
	    $(this).removeClass("place_holder");
	} else {
	    $(this).addClass("place_holder");
	}
    });
	
	//jssor_1_slider_init();
    function googlesignuphome(){
        setSessionStorageOuter('Google Signup From Signup Page', 'Signup');
    }
	$(document).ready(function(){
		 $('.bxslider').bxSlider({
		  auto: true,
		  autoControls: true
		});
	});
</script>
<?php echo $this->element('affiliate'); ?>