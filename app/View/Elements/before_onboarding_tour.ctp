<style type="text/css">
	.request_callback_modal .modal-dialog{width:750px}
	.request_callback_modal .modal-content{padding:30px 0px 0px}
	.request_callback_modal h3{font-size:30px;line-height:40px;color:#fa7d57;font-weight: 600;text-align:center;margin:0 0 30px;padding:0}
	.request_callback_modal article{display:table;width:100%;background:#fa7d57;overflow:hidden;border-radius:0px 0px 10px 10px;}
	.request_callback_modal article aside{width:50%;display:table-cell;vertical-align:middle;background: #fff;
    padding: 30px;position:relative;border-radius:0px 0px 0px 10px;}
	.request_callback_modal article aside.lft{background: #fa7d57;border-radius: 0px 0px 0px 10px;}
	.request_callback_modal article aside.lft::before{content: '';width: 40px;
    height: calc(100% + 10px);height: -webkit-calc(100% + 10px);height: -moz-calc(100% + 10px);background: #fa7d57;position: absolute;top: -5px;transform: rotate(10deg);-webkit-transform: rotate(10deg);-moz-transform: rotate(10deg);right: -20px;z-index: 1;}
	.request_callback_modal ul{margin:0;padding:0;list-style-type:none}
	.request_callback_modal ul li{display:block;font-size:18px;line-height:30px;color:#fff;font-weight:500;position:relative;padding:0 0 0 30px;margin: 15px 0 0;}
	.request_callback_modal ul li:first-child{margin:0}
	.request_callback_modal ul li::before{content:'';background:url(../../img/home_outer/ok_circle1.png) no-repeat 0px 0px;width:20px;height:20px;background-size:100% 100%;display:inline-block;position:absolute;left:0;top:5px}
	.request_callback_modal .close{font-size: 50px;line-height: 20px;color: #fff;opacity: 1;font-weight: 300; right: -30px;position: absolute;top: -20px;outline: none;}
</style>
<div  class="request_callback_modal">
	<div class="modal-dialog">
		<button type="button" class="close" data-dismiss="modal" onclick="closePopupBefore();">&times;</button>
    <!-- Modal content-->
		<div class="modal-content">
			<h3><?php echo __('REQUEST CALLBACK');?></h3>
			<article>
				<aside class="lft">
					<ul>
						<li><?php echo __('Personalized advice specific to you');?> </li>
						<li><?php echo __('No commitment to buy');?> </li>
						<li><?php echo __('No cost to you');?> </li>
					</ul>
				</aside>
				<aside>
					<form id="phone_num_pop_frm">
					<div class="input-group">
						<span class="input-group-addon">+91</span>
						<input type="text" pattern="[789][0-9]{9}" maxlength="10" class="form-control" placeholder="<?php echo __('Ex. 9938****93'); ?>" id="user_phone_num_pop" autocomplete="off" required>
						<span class="input-group-addon"><i class="material-icons">smartphone</i></span>
					</div>
					<div class="text-center mtop15">
					<button type="submit" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></button>
					</div>
					</form>
				</aside>
			</article>
		</div>
	</div>
</div>
<?php
	if (isset($_COOKIE['FIRST_INVITE_2_CNTR'])) {
		$fst_invite_phn = 1;
		if($_SESSION['project_methodology'] == 'scrum'){
			$fst_invite_phn = 2;
		}
	}else{
		$fst_invite_phn = 0;
	}
?>
<script type="text/javascript">	
	console.log('<?php echo $fst_invite_phn; ?>');
  var fst_invite_phn = '<?php echo $fst_invite_phn; ?>';
	$('#phone_num_pop_frm').submit(function(){
		var phone = $.trim($('#user_phone_num_pop').val());
		if(phone == ''){
				return false;
		}
		if(phone.length < 10){
				return false;
		}
		$.ajax({
			url: HTTP_ROOT + 'users/ajax_savePhoneNumber',
			type: 'POST',
			data: {'phone': btoa(phone)},
			cached: true,
			dataType: 'json',
			success: function (res) {
				if (res.status == 'success') {
					showTopErrSucc("success", res.msg);
					//newOnboardingChk();					
					closePopupBefore();
					/*if(!localStorage.getItem("tour_type") && !localStorage.getItem("OSTOUR")){
						$('#manage_your_work').trigger('click');
					}*/
				} else {
					showTopErrSucc("error", res.msg);
				}
			}
		});
	});
	function closePopupBefore() {
			$(".popup_overlay_2").hide();
			$('#myModal').modal('hide');
			$(".sml_popup_bg").hide();
			$(".cmn_popup").hide();
			localStorage.setItem("OSBEFORTOUR", 1);
			//newOnboardingChk();
			if(!localStorage.getItem("tour_type") && !localStorage.getItem("OSTOUR")){
        if(fst_invite_phn == '1'){
				  $('#manage_your_work').trigger('click');
        }
			}
	}
</script>