<?php 
if(!empty($usrdata['User']['verify_string'])){ ?>
<div class="breadcrumb_fixed">
<div class="fixed-n-bar" style="display:none; text-align: center;">
<div><?php echo __('Please confirm your email address');?>: <span style="font-weight:bold;"><?php echo $usrdata['User']['email']; ?></span> &nbsp;&nbsp;&nbsp;<span class="resend-email"><a href="<?php echo HTTP_ROOT."users/resend_confemail"; ?>"><?php echo __('Resend email');?>.</a></span>&nbsp;&nbsp;&nbsp; <span class="change-email"><a href="<?php echo HTTP_ROOT."users/profile"; ?>"><?php echo __('Change your email');?>.</a></span></div><span class="fr" style="background-color:#FFE5CA;margin-right:30px;width:20px;display:block;"><a id="closevarifybtn" style="display:none;" href="javascript:void(0);" class="close" onclick="closeemailvarify('<?php echo $usrdata['User']['id']; ?>')"><img src="<?php echo HTTP_IMAGES;?>Closed.png" /></a></span><div class="cb"></div></div>
</div>
<?php } ?>
<?php 
if($is_log_out){
     //echo $this->requestAction('/projects/default_inner',array('return'));
} ?>
<script>
$(function(){
    $('body').keydown(function(e){
        if(e.keyCode==27){
           close_test();
        }
    })
})
</script>
<?php
$cal_prog_per = 0;
$comp_steps = 0;
if($is_active_proj){
	$comp_steps++;
	$cal_prog_per +=33;
}
if($totalusers >1){
	$comp_steps++;
	$cal_prog_per +=33;
}
//if(isset($projectuser_count) && $projectuser_count>=1){
//	$comp_steps++;
//	$cal_prog_per +=25;
//}
if(isset($task_crted) && $task_crted>=1){
	$comp_steps++;
	$cal_prog_per +=34;
}
$autorefreshflag =0;
$usrArr = $this->Format->getUserDtls(SES_ID);
if(count($usrArr)) {
	$ses_photo = $usrArr['User']['photo'];
	if(trim($ses_photo) == ''){
		$ses_photo = 'user.png';
	}
}
?>
<div class="steps_os">
	<?php if(!$GLOBALS['project_count']) { ?>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<img width="80" height="80" src="../files/photos/user.png" style="border:1px solid #BAC1C6">
		</div>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<h1 style="color:#3DBB89"><?php echo __('Welcome');?> <?php echo USERNAME; ?>!</h1>
			<h2 style="color:#3DBB89"><?php echo __('Get started with your Orangescrum account');?></h2>
		</div>
		<div class="cb" style="height:10px;"></div>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<h1 style="color:#333"><?php echo __('Create your first project and start getting things done');?></h1>
		</div>
		<div style="text-align:center;position:absolute;left:41%"><img src="<?php echo HTTP_ROOT;?>img/arrow.png"></div>
		<div class="cb" style="height:5px;"></div>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<?php echo $this->element('onboard_add_project'); ?>
			<!--<button class="btn new_task" type="button" onclick="newProject();"><i class="icon_ct_task"></i>Create Project</button>-->
		</div>
	<?php } elseif($totalusers == 1) { ?>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<h1 style="color:#3DBB89"><?php echo __('Hey');?> <?php echo USERNAME; ?>!</h1>
		</div>
		<div class="cb" style="height:10px;"></div>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<h2 style="color:#455560"><?php echo __('Looks like its just you in here');?></h2>
		</div>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<h1 style="color:#333"><?php echo __('Orangescrum works best when you add your team');?></h1>
		</div>
		<!--<div style="text-align:center;position:absolute;left:44%"><img src="../img/arrow.png"></div>-->
		<div class="cb" style="height:5px;"></div>
		<div class="steps_usr onboard" style="text-align:center;width:100%;">
			<button class="btn new_task" type="button" onclick="newUser();"><i class="icon_ct_task"></i><?php echo __('Invite Users');?></button> <?php echo __('or');?>, <a href="<?php echo HTTP_ROOT."dashboard"; ?>" style="color:#FF7E00;text-decoration:underline;font-weight:bold;"><?php echo __('Explore');?></a>
		</div>
	<?php } ?>
</div>

<style type="text/css">
.crt-asn-task:hover{
	text-decoration: underline;
}	
.on_brd_blue:hover {
		background-color: #648740 !important;
    border-color: #74A844;
	}
	.on_brd_blue {
		background-image: none !important;
		border: 5px solid #FFFFFF;
		border-radius: 0;
		box-shadow: none !important;
		color: #FFFFFF !important;
		cursor: pointer;
		display: inline-block;
		margin: 0;
		position: relative;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25) !important;
		transition: all 0.15s ease 0s;
		vertical-align: middle;
		background-color: #7DAA50 !important;
		border-color: #8EBF60;
		font-size:18px;
		font-weight:normal;
		-moz-user-select: none;
		font-weight: normal;
		text-align: center;
		white-space: nowrap;
		border-width: 5px;
		line-height: 1.35;
		padding: 10px 26px;
		cursor: pointer;
		text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25) !important;
	
	}
	.icon-ok:before{content:'\2714'; position:absolute; top:0px; left:0px}

</style>
<script type="text/javascript">
<?php if($autorefreshflag){?>
	setInterval(function(){
		window.location.href=HTTP_ROOT+"<?php echo 'dashboard#tasks';?>";
	},10000);
	setInterval(function(){
		if(parseInt($('#seccnt').text())>=1){
			$('#seccnt').text(parseInt($('#seccnt').text())-1);
		}
	},1000);

<?php }	?>
function showInvitedUserLnk(wtLnk,Lnk){
	$("#"+Lnk).show();
	$("#"+wtLnk).hide();
}
function hideInvitedUserLnk(wtLnk,Lnk){
	$("#"+Lnk).hide();
	$("#"+wtLnk).show();
}	
</script>