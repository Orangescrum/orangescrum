<style type="text/css">
@font-face{
	font-family:PT Sans;
	src:url(<?php echo HTTP_ROOT; ?>font/PTS55F.ttf)
}


* 	{margin:0;padding:0;}
html{overflow:-moz-scrollbars-vertical;overflow-y:scroll;}
body{
	margin:0px;
	padding:0px;
	font:14px/18px Arial, Helvetica, sans-serif;
}
body {
	background:#EB592A;
	height:100%;
	width:auto
}
.login_table{
	background:url(<?php echo HTTP_ROOT; ?>img/images/form_bg.jpg) center center no-repeat;
	height:100%;
	width:100%;
}
#container{
	width:100%;
	margin:0 auto;
	border:0;
	width:900px;
}
.login_box div.login_box div.extras {
    border-top: 1px dashed #CCCCCC;
    margin-top: 15px;
    padding-top: 10px;
}
.login_box div.login_box input.auto {
    width: auto;
}
.login_box div.login_box label input {
    margin-bottom: 0;
}
.login_box div.login_box input {
    font-size: 14px;
    padding: 3px;
    width: 275px;
}
input{
	border:1px inset #ccc;
}
input:focus{
	outline:none;
	border:1px inset #3D7BAD;
}

.login_box div.login_box input.button {
    font-size: 14px;
    margin: 10px 0 0;
    padding: 3px;
    width: auto;
	cursor:pointer;
}
.login_box div.login_box div.extras ul li {
    font-size: 12px;
    list-style: none outside none;
    padding-bottom: 3px;
}
input {
    padding: 3px;
}
.login_box {
    color: #000000;
}
.login_box div.login_box {
    -moz-border-radius: 10px 10px 10px 10px;
    -moz-box-shadow: 0 0 6px #999999;
	-webkit-border-radius: 10px 10px 10px 10px;
	-webkit-box-shadow: 0 0 6px #999999;
	border:1px solid #ddd;
    background: none repeat scroll 0 0 #FFFFFF;
    font-family: lucida grande,verdana;
    font-size: 12px;
    margin: 10px auto;
    padding: 10px 28px;
    text-align: left;
    width: 80%;
	border-top-right-radius:10px;
	border-bottom-right-radius :10px;
	border-bottom-left-radius:10px; 
	border-top-left-radius:10px; 
	border-radius:10px;
}
#contact_form input, #login_dialog input[type="text"], #login_dialog input[type="password"], #demo_login input[type="text"], #demo_login input[type="password"]{width:92% ; padding: 6px 0 6px 3px;}
input, textarea, select{
	height:20px;}
div#LogoBox.white img {
    background: none repeat scroll 0 0 #FFFFFF;
    padding: 10px;
}
.footer_login{
	position:relative;
	bottom:0px;	
	width:100%;
}
a{
	text-decoration:none;
	}
.fl{
	float:left;
}
.fr{
	float:right;
}
.cb {
	clear:both;
}
/*a, a:visited, a:active{outline:none; color:#f96400; text-decoration: none;}
a:hover{color:#017fd3; text-decoration: underline;}*/
a img{border:none;}

.demo_login_bg_l{
	font-family: lucida grande,verdana;
/*	border:12px solid #9DC6E4; 
*/	width:100%; 
/*	background:#FFFFFF; 
	padding-left:20px;*/ 
	margin:0px auto; 
	color:#555555; 
/*	border-radius:10px;
	-moz-border-radius:10px;
	-webkit-border-radius:10px
*/	margin-left:0px;
	padding-top: 20px;

	
}
.admin_demo_img_l{
    background: url("<?php echo HTTP_ROOT; ?>img/images/iconsprite.jpg") no-repeat scroll 0 0 transparent;
    height: 22px;
    margin-right: 13px;
    width: 17px;
	text-indent:30px;
	line-height:23px;
	color:#FFFFFF;
}

.emp_demo_img_l{
    background: url("<?php echo HTTP_ROOT; ?>img/images/iconsprite.jpg") no-repeat scroll -17px 0 transparent;
    height: 22px;
    margin-right: 8px;
    width: 22px;
	text-indent:30px;
	line-height:23px;
	color:#FFFFFF;
}

.login_demo_txt_l {
    background: none repeat scroll 0 0 #FAE9E3;
    border: 1px solid #EC5B2B;
    color: #333333;
    font-family: Tahoma;
    font-size: 13px;
    padding: 5px 10px;
    width: 150px;
}
.login_demo_txt_l:focus {
	border: 1px solid #EC5B2B;
}

.demo_lunch_l:hover{
	-moz-transition: all 0.2s linear 0s;
	-moz-transform: translate(0px, -0.2em);
}
.clikable {
	cursor:pointer;
}
.clikable:hover {
	text-decoration:underline;
	color:#FFFFFF;
}
</style>

<div id="wrapper" style="height:76%;">
	<div style="text-align:left;" class="logo"><a href="<?php echo HTTP_HOME; ?>"><img src="<?php echo HTTP_ROOT; ?>img/images/os_logo_white.png"></a></div>
	<div class="login_table">
		<div <?php if(PAGE_NAME == "home") { ?>class="home" <?php } else { ?>class="home_other" <?php } ?> style="height:100%;display:table">
			<div id="container" style="display:table-cell; vertical-align:middle">
				<div class="demo_login_bg_l">
					<div class="login_box" style="height:100%; float:right; width:50%">
						<span class="success_msg" style="font-family:Arial, Helvetica, sans-serif;font-size: 14px;margin-left:20px;"><?php echo $messageDisplay; ?></span>
						<div class="login_box" style="min-height:300px; height:auto; margin-right:20px">
							<div class="login_dialog" id="login_dialog">
								<?php echo $this->Form->create('User', array('action' => 'betausers')); ?>
								<div style="color:#4d4d4d; font-size:16px; margin-top:10px; margin-bottom:5px"><h6 class="sign_heading">Registration as Beta User</h6></div>
								<div style="width:100%"><img src="<?php echo HTTP_ROOT; ?>img/images/login_header_shadow.png" style="width:100%"/></div>
								<div style="height:10px"></div>
								<h2 style="font-weight:normal;color:#8a8a8a" class="sign_lable"><b>Email</b></h2>
								<div style="height:10px"></div>
								<?php echo $this->Form->text('email',array('size'=>'30','class'=>'','id'=>'txt_UserId', 'style'=>'background:#fff;height:35px;')); ?>
								<div style="height:10px"></div>
								<button type="submit" value="Save" name="submit_Pass" id="submit_Pass" style="cursor:pointer;border:1px solid #CCCCCC;font-weight:bold;margin-right:30px;float:right;" onclick="return validate();">Request</button>
								<?php echo $this->Form->end(); ?>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>
		<div class="cb"></div>
	</div>
</div>

<script language="javascript" type="text/javascript">
	function validate()
	{
		var pattern=/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/;
		var email = document.getElementById("txt_UserId").value;
		if(email == '')
		{
			alert("Please enter a email to subscribe.");
			return false;
		}
		else if(!pattern.test(email))
		{
			alert("Please enter a valid email for subscription.");
			return false;
		}
		else
		{
			return true;
		}
	}
</script>