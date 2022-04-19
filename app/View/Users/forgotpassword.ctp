<style type="text/css">
.forgot_pwd_page .fpwd_page .cmn_bdr_shadow{background: transparent;box-shadow: rgb(0 0 0 / 10%) 0 0 10px;padding-bottom: 40px;}
.forgot_pwd_page h1{color: #000d33;margin: 0 0 15px;}
.forgot_pwd_page .punch_line{text-align:center;font-size:14px;color: #000d33;font-weight: 500;line-height: 24px;margin:0px 0 20px;}
.fpwd_page .field_wrapper{width:100%;position: relative;margin:0 0 24px;}
.fpwd_page .field_wrapper input.cmn_inp{border: 1.5px solid #DADCE0;
    width: 100%;height:45px;line-height:45px;font-size: 15px;color: #333;font-weight: 500;text-align: left;padding: 0 15px 0 20px !important;border-radius: 4px;}
.fpwd_page .field_wrapper .field_placeholder{font-size: 12px;
font-weight: 500;position: absolute;top: -8px;
color: #80868b;left: 15px; z-index: 1;text-align: left;
display: inline-block; background: #fff; padding: 0 5px;}
.fpwd_page .field_wrapper input:not([disabled]):focus~.field_placeholder{color:#1A73E8;}
.fpwd_page .field_wrapper input.cmn_inp:not([disabled]):focus{border-color:#1A73E8}
.forgot_pwd_page .inpfld_grp .cmn_inp{padding: 0 15px;}
.fld_error_msg{font-size: 14px;color: #fff;font-weight:500;margin: 0;position: absolute;left: 0;bottom: -45px;padding: 5px 25px;background: #fc5367;border-radius: 4px;z-index:1;display: none;} 
.forgot_pwd_page .fpwd_page .form-group.inpfld_grp {margin: 15px 0;}
.fld_error_msg::before {content: '';width: 0;height: 0;
    border-left: 8px solid transparent;border-right: 8px solid transparent;
    border-bottom: 8px solid #fc5367;position: absolute;left: 15px;top: -8px;}
#err_pass{display:none;font-size: 14px;color: #fc5367;font-weight: 500;margin: 0;
    padding: 10px 25px;background: #fce7e9;border-radius: 4px;z-index: 1;width: 100%;text-align: center; border: 1px solid #f8b5bd;}
</style>
<?php if(isset($passemail) && !empty($passemail)){}else{$passemail='10';}?>
<?php if(isset($chkemail) && !empty($chkemail)){$chkemail='10';}else{$chkemail='11';}?>
<div class="forgot_pwd_page">
<?php if(defined('RELEASE_V') && RELEASE_V){ ?>
<div class="login_sup_page fpwd_page">
    <div class="wrapper_sup">
        <div class="cmn_bdr_shadow forget_password_wrap">
        <div class="center_logo"><a href="<?php echo HTTPS_HOME; ?>"><img src="<?php echo HTTP_ROOT; ?>img/header/orangescrum-cloud-logo.svg"  alt="#1 Productivity Tool" title="#1 Productivity Tool" width="142" height="42"/></a></div>
        <?php if($chkemail=="11" && $passemail=="10") {?>
				<style type="text/css">
				.forgot_pwd_page .inpfld_grp .cmn_inp,
				.forgot_pwd_page .inpfld_grp .strength_wrapper .inp_fld {width: 100%;
						height: 45px;line-height: 45px;padding: 0 45px 0 55px; border: 1px solid #bbb;
						border-radius: 3px;font-size: 16px;color: #333;background: #fff;}
				</style>
        <?php echo $this->Form->create('User',array('url'=>'/users/forgotpassword','onsubmit'=>'return validpwd(\'txt_email\')')); ?>
            <h1>Not a problem, sometimes it happens with all of us.</h1>
            <div class="punch_line">Enter the email id registered with Orangescrum. <br/>
            We'll send you the link to reset your password.</div>
                                      
			                                             
            <div class="log_sup_cnt">
              <div class="field_wrapper inpfld_grp pr">
               <!-- <label for="">Email</label> -->
                <?php echo $this->Form->text('email',array('id'=>'txt_email','class'=>'cmn_inp','maxlength'=>'100','title'=>'Email ID', 'placeholder'=>'' ,'value'=>urldecode($_GET['email']))); ?>
				<div class="field_placeholder"><span>Email</span></div>
               <?php /* <span class="lft_icon"><span class="email_icon"></span></span>
                <span class="rht_icon help_ques">
                  <span class="info_icon"></span>
                  <span class="title_tltip">Set your email to access your account</span>
                </span> */?>
								<?php $msg_to_show = $this->Session->flash(); ?>
				<div class="fld_error_msg" id="error" <?php if(!empty($msg_to_show)){ ?>style="display:block;"<?php } ?>><?php echo $msg_to_show; ?>
						<?php if(isset($pass_succ) && $pass_succ) {
							//echo $pass_succ;
						}elseif(isset($error_reset) && $error_reset){
							//echo $error_reset;
						} ?>
				</div>   
                </div>
                <div class="submit_cancel_btn" id="fgpass">
                    <input type="hidden" name="hidtxt" value="<?php if(isset($_GET['login'])) { echo $_GET['login']; } ?>" readonly="true">
                    <input type="hidden" id="user_id" name="user_id" value="<?php if(isset($user_id)) { echo $user_id; } ?>" readonly="true">
                    <button type="submit" value="Submit" name="submit_pwd"class="btn btn_cmn_efect signin_btn transition" >Submit</button>
                    <a href="<?php echo HTTP_ROOT; ?>users/login" class="cancel_link">Cancel</a>
                </div>
                <span id="fgload" style="display:none;padding-left:20px">
                    <img src="<?php echo HTTP_IMAGES; ?>images/feed.gif?v=<?php echo RELEASE; ?>" alt="Loading" title="Loading"/>
                </span>
                <?php if(isset($pass_succ) && empty($pass_succ)) { ?>
                <!--<h5>(After submitting please click on the link sent to your email)</h5> -->
                <?php } ?>
            </div>
        <?php echo $this->Form->end(); ?>
        <?php } ?>
        <?php if($passemail=="12"){ ?>
        <?php echo $this->Form->create('User',array('url'=>'/users/forgotpassword','id'=>'forgotpassForm')); ?>
            <h2>Reset your password</h2>
            <div id="err_pass"></div>
            <div class="log_sup_cnt">
              <div class="form-group inpfld_grp">
                <label for="">New Password</label> 
                <?php //echo $this->Form->password('newpass',array('id'=>'newpass','class'=>'cmn_inp','maxlength'=>'15','onKeyPress'=>'return noSpace(event)','autocomplete'=>'off','title'=>'New Password')); ?>
								<div id="myPassword"></div>
                </div>
              <div class="form-group inpfld_grp">
                 <label>Re-type Password</label>
                  <?php echo $this->Form->password('repass',array('class'=>'cmn_inp','id'=>'repass','maxlength'=>'15','onKeyPress'=>'return noSpace(event)','autocomplete'=>'off','title'=>'Re-type Passowrd')); ?>
                </div>
                <div class="submit_cancel_btn" id="savpass">
                    <input type="hidden" name="hidtxt" value="<?php if(isset($_GET['login'])) { echo $_GET['login']; } ?>" readonly="true">
                    <input type="hidden" id="user_id" name="user_id" value="<?php if(isset($user_id)) { echo $user_id; } ?>" readonly="true">
					<input type="hidden" id="qstr_chk" name="qstr_chk" value="<?php if(isset($_GET['qstr'])) { echo $_GET['qstr']; } ?>" readonly="true">
                    <button type="button" value="Submit" name="submit_pwd" class="btn btn_cmn_efect signin_btn transition" onclick="validatepass();">Submit</button>
                    <a href="<?php echo HTTP_ROOT; ?>users/login" class="cancel_link">Cancel</a>
                    <span id="savload" style="display:none;padding-left:20px;">
                        <img src="<?php echo HTTP_IMAGES; ?>images/feed.gif?v=<?php echo RELEASE; ?>" alt="Loading" title="Loading"/>
                    </span>
                </div>
            </div>
        <?php echo $this->Form->end(); ?>
        <?php } ?>
        <?php if($chkemail=="10"){?>
            <h2>Your Password is successfully changed.</h2>
            <h4><a href="<?php echo HTTP_ROOT;?>users/login">Login</a> with your new password</a></h4>
        <?php } ?>
        </div>
    </div>
</div>
<?php } ?>
</div>
</div>
<script>
function validpwd(txtEmail)
{
	var email = document.getElementById(txtEmail).value;
	var done = 1;
	if(email.trim() == "")
	{
		err = "Please enter an email.";
		done = 0;
	}
	else
	{
		var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
		if(!email.match(emlRegExpRFC) || email.search(/\.\./) != -1)
		{
			err = "Invalid 'E-mail' address !";
			done = 0;
		}
	}
	if(done == 0)
	{
		document.getElementById('error').style.display='block';
		document.getElementById('error').innerHTML=err;
		return false;
	}
	else
	{
		document.getElementById('error').style.display='none';
		document.getElementById('fgpass').style.display='none';
		document.getElementById('fgload').style.display='block';
		return true;
	}
	
}
</script>

<?php /* <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery/jquery.min.1.5.1.js"></script> 
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery/jquery.pstrength-min.1.2.js"></script>*/ ?>

<link rel="stylesheet" type="text/css" href="<?php echo JS_PATH; ?>pswd-strength/pass-strength.css">
<?php /*<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.2.min.js"></script>*/ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>pswd-strength/pass-strength.js"></script>

<script>
$(document).ready(function() 
{
	//$('#newpass').pstrength();
	$('#myPassword').strength_meter();
    $.material.init();
    var w_height=$(window).height(); 
    $('.forgot_pwd_page').height(w_height);
});

function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      oldonload();
      func();
    }
  }
}
function prepareInputsForHints() {
	var inputs = document.getElementsByTagName("input");
	for (var i=0; i<inputs.length; i++){
		// test to see if the hint span exists first
		if (inputs[i].parentNode.getElementsByTagName("span")[0]) {
			// the span exists!  on focus, show the hint
			inputs[i].onfocus = function () {
				document.getElementById('hints').style.display='block';
				this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
			}
			// when the cursor moves away from the field, hide the hint
			inputs[i].onblur = function () {
				//alert(this.parentNode.getElementsByTagName("span")[0].style.display);
				document.getElementById('hints').style.display='none';
				this.parentNode.getElementsByTagName("span")[0].style.display = "none";
			}
		}
	}
	// repeat the same tests as above for selects
	var selects = document.getElementsByTagName("select");
	for (var k=0; k<selects.length; k++){
		if (selects[k].parentNode.getElementsByTagName("span")[0]) {
			selects[k].onfocus = function () {
				this.parentNode.getElementsByTagName("span")[0].style.display = "inline";
			}
			selects[k].onblur = function () {
				this.parentNode.getElementsByTagName("span")[0].style.display = "none";
			}
		}
	}
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
addLoadEvent(prepareInputsForHints);


function validatepass()
{	
	var newpass = document.getElementById('password');
	var repass = document.getElementById('repass');
	var errMsg; var done = 1;
	if(newpass.value.trim() == "")
	{
		errMsg = "Password cannot be  blank!";
		newpass.focus();
		done = 0;
	}
	else if(newpass.value.length < 8 || newpass.value.length > 30)
	{
		errMsg = "Password should be between 8-30 characters!";
		newpass.focus();
		done = 0;
	}
	else if(repass.value.trim() == "")
	{
		errMsg = "Re-Type Password cannot be  blank!";
		repass.focus();
		done = 0;
	}
	else if(repass.value != newpass.value)
	{
		errMsg = "Passwords do not match!";
		repass.focus();
		done = 0;
	}
	if(done == 0)
	{
		document.getElementById('err_pass').style.display='block';
		document.getElementById('err_pass').innerHTML=errMsg;
		return false;
	}
	else
	{
		document.getElementById('err_pass').style.display='none';
		document.getElementById('savpass').style.display='none';
		document.getElementById('savload').style.display='block';
		$('#forgotpassForm').submit();
		return true;
	}
}
function noSpace(e)
{
    var unicode = e.charCode ? e.charCode : e.keyCode;
    if(unicode != 8 ) {
        if(unicode == 32) {
            return false;
        }
        else {
            return true;
        }
    }
    else {
        return true;
    }
}
</script>
