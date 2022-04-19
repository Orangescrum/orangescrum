<style>
    .check_label{margin: 5px 0 0; color: #333; font-weight: 400;font-size: 14px;}
.check_label input{display:inline-block;margin:0 5px 0 0;vertical-align:middle}
.sin_fpd .btn-link{margin-top: 5px;display: inline-block;}
</style>
<script>
     $(document).ready(function() {
        setTimeout(function(){
            var unm = $('#txt_UserId'). val().trim();
            var pwd = $('#txt_Password'). val().trim();
            if(unm == '' && pwd == ''){
                $('#txt_UserId').parent('div').addClass('is-focused');
                $('#txt_UserId').focus();
            }else if(unm != '' && pwd == ''){
                $('#txt_Password').parent('div').addClass('is-focused');
                $('#submit_Pass').focus();
            }else if(unm != '' && pwd != ''){
                $('#txt_Password').parent('div').addClass('is-focused');
                $('#txt_UserId').parent('div').addClass('is-focused');
                $('#submit_Pass').focus();
            }
        }, 500);
        $("body").trigger('click');
        var hashurl = getHash()
        parseUrlHash(hashurl)
    });

    function loginDemo(email, pass) {
        $("#txt_UserId").val(email);
        $("#txt_Password").val(pass);
        $("#UserLoginForm").submit();
    }
    function getHash(window) {
        var match = (window || this).location.href.replace('#/','#').match(/#(.*)$/);
        return match ? match[1] : '';
    }

    function parseUrlHash(hash) {
        var urlVars = {};
        var params = (hash.substr(0)).split("/");
	//	console.log(params[0]);
        if (params[1]) {
            $('#case_details').val(params[1]);
        }else if(params[0] && params[0]=='getting_started'){
			$('#getting_started_lgn').val('getting_started');
		}else if(params[0] && params[0]=='extra10'){
			$('#extra_ten').val('extra10');
		}else if(params[0] && params[0]=='raf'){
			$('#extra_raf').val('raf');
		}else if(params[0] && params[0]=='upgrd'){
			$('#extra_ten').val('upgrd');
		}
		//return params;
    }
</script>
<?php if(defined('RELEASE_V') && RELEASE_V) { ?>
<div class="login_sup_page">
    <div class="wrapper_login">		
        <div class="login_side_logo"></div>
        <h6><a href="<?php echo HTTPS_HOME; ?>"><img src="<?php echo HTTP_ROOT; ?>img/header/orangescrum-logo.svg?v=<?php echo RELEASE; ?>" border="0" alt="Orangescrum.com" title="Orangescrum.com" /></a></h6>
        <h2>Login to your Orangescrum Account</h2>
        <div class="cmn_bdr_shadow">
            <div class="login_heading">
                <div class="user_img">
                    <img src="<?php echo HTTP_ROOT; ?>img/images/user.png"/>
                </div>
            </div>
            <div class="log_sup_cnt">
                <div class="invalid-msg">
                    <?php 
                         if(isset($update_email_message)){
							echo $update_email_message;
                         }else if(isset($_SESSION['extendMessage'])){
							echo $_SESSION['extendMessage'];
							unset($_SESSION['extendMessage']);
						 }else{
							echo $this->Session->flash(); 
                         }
                     ?>
                    <?php
                    if(isset($login_error) && $login_error) {
                    //echo "<font color='#FF0000'>".$login_error."</font>";
                    }
                    $demo_pass = "";
                    if(isset($ses_pass)) {
                    $demo_pass = $ses_pass;
                    }

                    ?>
                </div>
                <?php  $extra_params = !empty($project_url)?"?project_url=".$project_url:'';
                echo $this->Form->create('User', array('id'=>'UserLogin','url' => 'login'.$extra_params)); ?>
                <div class="form-group label-floating">
                  <label class="control-label" for="txt_UserId">Email ID</label>
                  <?php echo $this->Form->text('email',array('size'=>'30','class'=>'form-control','title'=>'Email ID', 'id'=>'txt_UserId', 'value'=>$ses_email,'autocomplate'=>'off')); ?>
                </div>
                <div class="form-group label-floating">
                  <label class="control-label" for="txt_Password">Password</label>
                    <?php
                    if($ses_email) {
                    echo $this->Form->password('password',array('size'=>'30','class'=>'form-control','title'=>'Password', 'id'=>'txt_Password','autocomplate'=>'off'));
                    }
                    else {
                    echo $this->Form->password('password',array('size'=>'30','class'=>'form-control','title'=>'Password', 'id'=>'txt_Password','autocomplate'=>'off'));
                    }
                    ?>
                </div>
                <input type="hidden" value="" name="case_details" id="case_details" />
				<input type="hidden" value="" name="getting_started_lgn" id="getting_started_lgn" />
				<input type="hidden" value="" name="extra_ten" id="extra_ten" />
				<input type="hidden" value="" name="extra_raf" id="extra_raf" />
                <button type="submit" value="Save" name="submit_Pass" id="submit_Pass" class="btn btn_cmn_efect">Log in</button>

                <div class="sin_fpd">
                    <div class="fl">
                        <div>
                          <label class="check_label">
                            <input type="checkbox" name="data[User][remember_me]" id="chk_Rem" class="auto" value="1" /> Stay logged in
                          </label>
                        </div>
                    </div>
                    <div class="fr">
                        <a href="<?php echo HTTP_ROOT; ?>users/forgotpassword" class="btn-link">Forgot Password?</a>
                    </div>
                    <div class="cb"></div>
                </div>
                <?php if(isset($_GET['project'])){ ?>
                <input type="hidden" name="data[User][project]" value="<?php echo $_GET['project'];?>" readonly="true">
                <?php } if(isset($_GET['case'])){ ?>
                <input type="hidden" name="data[User][case]" value="<?php echo $_GET['case'];?>" readonly="true">
                <?php } if(isset($_GET['file'])){ ?>
                <input type="hidden" name="data[User][file]" value="<?php echo $_GET['file'];?>" readonly="true">
                <?php } ?>
                <?php echo $this->Form->end(); ?>                
            </div>
        </div>
    </div>
</div>
<?php } ?>
<input type="hidden" name="pageurl" id="pageurl" value="<?php echo HTTP_ROOT; ?>" size="1" readonly="true"/>
<?php if(CHECK_DOMAIN == 'demo') { ?>
<?php echo $this->Html->css('index/style_outer.css?v='.RELEASE); ?>
<div id="inner_success" class="inner" style="top:10px;left:30%;margin:auto;">
    <table cellspacing="0" cellpadding="0" class="div_pop" align="center" style="margin-top:40px;width:550px;font-family:'Lucida Sans Unicode','Lucida Grande',sans-serif;">
        <tr style="height:65px;">
            <td valign="middle" style="color:#006600;font-size:18px;padding-top:20px;" align="center">
                <span id="successmsg"></span>
            </td>
        </tr>
    </table>
</div>
<div id="inner_support" class="inner" style="top:10px;left:0; right:0;margin:auto;">
    <table cellspacing="0" cellpadding="0" class="div_pop" align="center" style="margin-top:40px;width:550px;font-family:'Lucida Sans Unicode','Lucida Grande',sans-serif;">
        <tr style="height:35px;">
            <td style="padding-left:10px;" valign="middle"  class="ms_hd">
                <div style="float:left;font-size:16px;color:#3D4040;padding-top:4px;font-weight:bold">Feedback</div>
                <!--				<div style="float:right;padding-right:5px;padding-top:5px;"><span title="Close" onclick="cover_close('cover','inner_support')" style="cursor:pointer;color:#666666;font-size:13px;font-family:Verdana;font-weight:bold;">X</span></div>-->
                <div class="ms_cls"><img src="<?php echo HTTP_IMAGES;?>images/popup_close.png?v=<?php echo RELEASE; ?>" alt="Close" title="Close" onclick="cover_close('cover', 'inner_support')" style="cursor:pointer" /></div>
            </td>
        </tr>
        <tr>
            <td align="left" width="100%">
                <table cellpadding="10" cellspacing="10" border="0" align="center" width="100%" style="font:14px 'Lucida Sans Unicode','Lucida Grande',sans-serif;padding-left:50px;">
                    <tr height="18px">
                        <td align="left" valign="top" style="color:#FF0000;">
                            <div id="support_err" style="color:#FF0000;display:none;font:13px 'Lucida Sans Unicode','Lucida Grande',sans-serif;"></div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <font style="font-weight:bold">Name:</font> <input type="text" name="support_name" id="support_name" class="textbox" />
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <font style="font-weight:bold">E-mail:</font> <input type="text" name="support_email" id="support_email" class="textbox" />
                        </td>
                    </tr>
                    <tr>
                        <td align="left">
                            <font style="font-weight:bold">Message:</font>
                            <textarea name="support_msg" id="support_msg" class="textbox" style="height:80px"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" style="padding-top:5px">
                            <span id="btn_submit">
                                <button type="button" value="Post" name="addMember" style="margin-top:5px;width:60px;padding:2px 5px;cursor:pointer;font-family:'Lucida Sans Unicode','Lucida Grande',sans-serif;font-size:13px;" onclick="postSupport()">Post</button>
                                &nbsp;or&nbsp;
                                <a onclick="cover_close('cover', 'inner_support')" href="javascript:jsVoid();" style="color:#FF0000">Cancel</a>
                            </span>
                            <img src="<?php echo HTTP_IMAGES;?>images/del.gif?v=<?php echo RELEASE; ?>" alt="" width="16" height="16" id="loaderpost" style="display:none"/>
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>
                </table>
            </td>
        </tr>
    </table>
</div>
<a onclick="cover_open('cover', 'inner_support')" href="javascript:void(0);"  class="feddback_btn">
    <img style="border: none;" src="<?php echo HTTP_ROOT."img/images/support.png?v=".RELEASE; ?>"/>
</a>

<script>
    $(document).keydown(function(e) {
        if (e.keyCode == 27) {
            $("#cover").fadeOut('fast');
            $("#inner_support").slideUp('fast');
            $("#inner_success").slideUp('fast');
        }
    });
</script>
<?php } ?>
