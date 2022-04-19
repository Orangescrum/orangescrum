<style type="text/css">		
	.lock_page_warn .alert-info {
		color: #31708f;
		background-color: #d9edf7;
		border-color: #bce8f1;
	}
	.lock_page_warn .alert {
		padding: 15px;
		margin-bottom: 20px;
		border: 1px solid transparent;
		border-radius: 4px;
	}
	.lock_page_warn {position:fixed;left:172px;right:0;top:0;bottom:0;height: calc(100% - 0%);height: -webkit-calc(100% - 0%);height: -moz-calc(100% - 0%);width: calc(100% - 176px);width: -webkit-calc(100% - 176px);width:-moz-calc(100% - 176px);background: rgba(204, 204, 204, 0.3);display:none;z-index: 9999;}
	.close_upgrd.close {float:left;}
	.mini-sidebar .lock_page_warn{left:45px;  width: -webkit-calc(100% - 45px);width: -moz-calc(100% - 45px);width: calc(100% - 45px);}
</style>
<div class="lock_page_warn">
	<div class="oops_pop alert alert-info">
		<button type="button" class="close close-icon close_upgrd" data-dismiss="modal" onclick="downWarnClose();"><i class="material-icons">&#xE14C;</i></button>
		<figure>
		</figure>
		<h5><?php echo __('Orangescrum service will be unavailable from') .' '.$downTimeDate.' '.__('for maintenance');?>. </h5>
		<p><?php echo __("If you have any queries, please contact us at").' <a style="color:#2525c9;" href="mailto:support&#64;orangescrum&#46;com"> support&#64;orangescrum&#46;com</a>';?></p>
	</div>
</div>
<script>
function downWarnClose(){
	localStorage.setItem('isDownWarnn',1);
	$('.lock_page_warn').hide();
}
function showDownWarnPopup(){
	if(!localStorage.getItem('isDownWarnn')){
		$('.lock_page_warn').show();
	}
}
//display down time warning to users
showDownWarnPopup();
</script>