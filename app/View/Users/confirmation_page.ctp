<div style="border:1px dashed #ccc; padding:90px 5px 10px;background:#fafafa">
	<span style="display: block;text-align: center;" title="<?php echo __('Loading dashboard');?>...">
		<img id="paymnt_loader" style="display:none;" src="<?php echo HTTP_ROOT;?>img/payment_loading.gif" style="padding:5px;"/>
	</span>
	<center>
		<font size="10px;" style="color:#008000"><?php echo __('Congratulations');?>!!!</font>
	</center><br/>
	<center>
		<font size="6px;">
			<?php echo __('Your account');?>  <?php if($upgrade_flag==1){echo "upgraded";}else{echo __("downgraded");}?> <?php echo __('to');?> <b><?php echo ucfirst($plan_types[$subscription['UserSubscriptions']['subscription_id']]);?> <?php if($subscription['UserSubscriptions']['month']==12){ echo "(Yearly)";}else{echo "(Monthly)";}?></b> <?php echo __('plan Successfully');?>
		</font>
	</center><br/>
	<center>
		<font size="4px;">
			<?php echo __('You are now allowed to add');?> <b style="color:green"><?php echo $subscription['UserSubscriptions']['user_limit']; ?></b> <?php echo __('Users');?>, <b style="color:green"><?php echo $subscription['UserSubscriptions']['project_limit']; ?></b> Projects and <b style="color:green"><?php echo $this->Format->displayStorage($subscription['UserSubscriptions']['storage'])." ";//$this->Format->displayStorage($subscription['UserSubscriptions']['storage']); ?></b> <?php echo __('Space');?>. 
		</font>
	</center><br/>
</div>
<script type="text/javascript">

<?php 
if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com") || stristr($_SERVER['SERVER_NAME'],"payzilla.in")){
	if(isset($_SESSION['upgrade_ga'])){

	$all_os_plns = Configure::read('CURRENT_PAID_PLANS');
	$plan_type = (array_key_exists($subscription['UserSubscriptions']['subscription_id'], Configure::read('CURRENT_MONTHLY_PLANS')))?'Monthly':'Yearly';
	$plan_name = $all_os_plns[$subscription['UserSubscriptions']['subscription_id']];
	$sub_lavel = $_SESSION['upgrade_ga'];
	unset($_SESSION['upgrade_ga']);
	
	
?>
	<!-- GA E-commerce code -->
	ga('require', 'ecommerce');
	ga('ecommerce:addTransaction', {
	  'id': '<?php echo $owner_id; ?>',
	  'affiliation': 'Orangescrum SAAS <?php echo $sub_lavel; ?>',
	  'revenue': '<?php echo $subscription['UserSubscriptions']['price']; ?>',
	  'currency': 'USD'
	});
	ga('ecommerce:addItem', {
	  'id': '<?php echo $owner_id; ?>',
	  'name': '<?php echo $plan_name; ?>',
	  'category': '<?php echo $plan_type; ?>',
	  'price': '<?php echo $subscription['UserSubscriptions']['price']; ?>',
	  'quantity': '1',
	  'currency': 'USD'
	});
	ga('ecommerce:send');
	<?php } ?>
<?php } ?>
$(function(){
	setTimeout('showloaderfb()',2000);
	setTimeout('redirectToDb()',5000);
});
function showloaderfb(){
	$('#paymnt_loader').show()
}
function redirectToDb(){
	window.location.href="<?php echo HTTP_ROOT;?>mydashboard";
}
</script>

