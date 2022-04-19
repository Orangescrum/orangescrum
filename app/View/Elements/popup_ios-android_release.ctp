<style type="text/css">
.modal-content{border-radius:10px}
.app_release_pop img{max-width:100%}
.app_release_pop .lft-cont{position:relative;float:left;width:25%;height:100%;text-align:center;background:#084669;box-sizing:border-box;border-radius:10px 0px 0px 10px;}
.app_release_pop .rht-cont{background:url(<?php echo HTTP_ROOT.'img/home/container-bg.png'; ?>) no-repeat 0px 0px;background-size: 100% 100%;float:left;width:75%;height:100%;box-sizing:border-box;padding:0px 50px 0;    border-radius:0px 10px 10px 0px;}
.app_release_pop h2{font-size:26px;line-height:30px;color:#303030;text-transform:uppercase;letter-spacing:1px;font-weight:600;margin:0 0 20px;}
.app_release_pop p{font-size:16px;line-height:26px;color:#303030;font-weight:500}
.app_release_pop ul{margin:20px 0;padding:0;list-style-type:none}
.app_release_pop ul li{position:relative;display:block;width:33%;float:left;padding-left:15px;line-height: 22px;padding-right:10px;box-sizing:border-box;}
.app_release_pop ul li:before{content:'';background:url(<?php echo HTTP_ROOT.'img/home/orange-point.png'; ?>) no-repeat 0px 0px;width:10px;height:10px;display:block;position:absolute;left:0;top:8px;}
.app_release_pop ul li a{text-decoration:none;color:#444;font-size:12px;text-transform:uppercase;letter-spacing:1px;font-weight:500;}
.app_release_pop .app-link-btn{text-align:left;margin-top:50px;}
.app_release_pop .app-link-btn a{text-decoration:none;width:200px;display:inline-block;margin:0 10px;height:50px}
.app_release_pop .app-link-btn a img{height:100%}
</style>
<div class="modal-dialog" id="dialog-form-iosandroid" style="display: none; position: relative; box-sizing: border-box; width: 100%;">
    <div class="modal-content">
        <!--<div class="modal-header" style="padding: 15px 20px 0px; display: table; clear: both; width: 100%; box-sizing: border-box; text-align: left;">
            <button style="min-width:24px; padding: 0px; opacity: 0.2; float: right; background: transparent none repeat scroll 0px 0px; border: 0px none; line-height: 1px; margin: 0px; " type="button" class="close close-icon" data-dismiss="modal" onclick="closeMobilepop();"><i class="material-icons">&#xE14C;</i></button>
        </div>-->
        <div class="modal-body popup-container" style="padding: 0px;">
			<button style="min-width:24px; padding: 0px; opacity: 0.2; float: right; background: transparent none repeat scroll 0px 0px; border: 0px none; line-height: 1px; margin:5px; " type="button" class="close close-icon" data-dismiss="modal" onclick="closeMobilepop();"><i class="material-icons">&#xE14C;</i></button>
           <div class="app_release_pop">
			  <div class="lft-cont">
				<img src="<?php echo HTTP_ROOT.'img/home/app-phone.png'; ?>" width="" height="" alt="apps">
			  </div>
			  <div class="rht-cont">
				<h2><?php echo __('Orangescrum goes Mobile');?>!</h2>
				<p>
				  <?php echo __('Your favorite project management tool is now with you all the time. Use and enjoy Orangescrum at your fingertips');?>.
				</p>
				<ul>
				  <li>
					<a href="#"><?php echo __('Add, Edit & Assign Tasks');?></a>
				  </li>
				  <li>
					<a href="#"><?php echo __('Invite, Enable, Disable User');?></a>
				  </li>
				  <li>
					<a href="#"><?php echo __('Create, Edit & Manage Projects');?></a>
				  </li>
				  <li>
					<a href="#"><?php echo __('Update profile from Mobile');?></a>
				  </li>
				  <li>
					<a href="#"><?php echo __('Attach document/images');?></a>
				  </li>
				  <li>
					<a href="#"><?php echo __('Reply Task');?></a>
				  </li>			  
				  <div class="cb"></div>
				</ul>
				<div class="app-link-btn">
				  <a href="https://itunes.apple.com/ph/app/id1132539893" target="_blank">
					<img src="<?php echo HTTP_ROOT.'img/home/app-store.png'; ?>">
				  </a>
				  <a href="https://play.google.com/store/apps/details?id=com.andolasoft.orangescrum&hl=en" target="_blank">
					<img src="<?php echo HTTP_ROOT.'img/home/google-play.png'; ?>">
				  </a>
				</div>
			  </div>
			   <div class="cb"></div>			   
		  </div>
        </div>
    </div>
</div>
<script type="text/javascript">
function showErrSucc(type, msg) {
    $("#topmostdiv").show();
    $("#btnDiv").show();
    if (type == 'error') {
        $("#upperDiv_err").html(msg);
        $("#upperDiv_err").show();
    } else {
        $("#upperDiv").html(msg);
        $("#upperDiv").show();
    }
    clearTimeout(time);
    time = setTimeout(removeMsg, 6000);
}
</script>