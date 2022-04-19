<style type="text/css">
.pricing_help_cont{background: #e1e8f2;
    border: 2px solid #a6cbfc;border-radius: 10px;
    font-size: 15px;padding: 11px;}
.popup_overlay {background: #000405;height: 100%;left: 0;opacity: 0.21;position: fixed;top: 0;width: 100%;z-index: 99999;display: none;}
.popup_bg, .popup_bgs{position: fixed;left: 0;right: 0;top: 70px;margin: 0 auto;min-height: 200px;height: auto;padding: 1px 1px 20px;background: url(../img/rht_con_bg.png) repeat;border: 1px solid #ccc;border-radius: 2px;z-index: 999999;width: 540px;box-shadow: 0px 0px 8px #666;display: none;}
.popup_title {background: url("../img/popup_bg_title.jpg") repeat-x 0px 0px;padding: 6px 10px 0;font-size: 17px;color: #5191bd;height: 39px;}
.close_popup {color: #F00;font-size: 0px;font-weight: bold;background: url("../img/images/popup_close.png") no-repeat 0px 0px;width: 10px;height: 10px;cursor: pointer;margin-top: 7px;text-indent: 2000px;}
#thnxmsg, #thnxmsgs{display: none;font-weight: normal;color: #34AF33;font-size:14px;text-align: center;}
.cb20{clear:both;margin-bottom:20px;}
.cb15{clear:both;height:20px;}
.label1 {font-size:16px;text-align: right;width: 25%;float: left;padding-top: 6px;}
.field {padding-left: 20px;text-align: left;float: left;}
.textbox{box-shadow: none;color: #333333;font-size: 17px;padding: 5px;font-family:"OPENSANS-REGULAR";height:37px;}
.textareabox{resize:none;margin: 0;background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #AAAAAA;border-radius: 5px 5px 5px 5px;box-shadow: none;font-size: 17px;height:100px;width: 360px;padding: 5px;font-family:"OPENSANS-REGULAR";}
.btn.btn_blue.btn_orng{background:#F1841B;font-size:18px;font-weight:bold;color:#fff}
.btn.btn_blue.btn_orng:hover{background:#ea801a;}
.metadata{bottom: 73px;left: 50%;margin-left: -60px;position: absolute;}
#submit_buttons span {cursor:pointer;}
.opn-signup-free-btn a {left: 0;border: 2px solid #2DA053;color: #fff;background: #2DA053;right: 0;bottom: -90px;margin: 0 auto;}
.opn-download-free-btn a {left: 0;border: 2px solid #ED7804;color: #fff;background:#ED7804;right: 0;bottom: -90px;margin: 0 auto;}
.pmt_sign_down .pmt_download{position:relative}
.pmt_sign_down .pmt_signup{position:relative}
.pmt_sinup-cont,.pmt_down-cont{margin-left: 40px;}
.cm-manage{color:#FF7E00}
.cm-manage:hover{color:#FF7E00;text-decoration:underline}
.floader{width:25px; float:left;}
.btn.btn_blue.btn_orng:disabled{background:#D0CECE;}
.faq-static-table .faq_price_table{width:100%}
.faq-static-table .faq_price_table tr th{background:#2c6fa9;font-size:14px;color:#fff;text-align:center;font-weight:600;padding:5px;vertical-align:middle}
.faq-static-table .faq_price_table tr td{font-size:14px;color:#303030;text-align:center;padding:5px;vertical-align:middle;border:1px solid #ddd !important;font-weight:400;}

@media only screen and (max-width:800px){
    .plan_price .wrap_price{width:100%}
}
@media only screen and (max-width:700px){
    .faq-static-table .faq_price_table{table-layout:fixed}
    .faq-static-table .faq_price_table td,.faq-static-table .faq_price_table tr td:first-child, .faq-static-table .faq_price_table tr td:last-child{display:table-cell;width:33.33%}
    .popup_bg, .popup_bgs{position:absolute;top:0}
    .popup_bg  .cb15, .popup_bgs .cb15{height:5px}
}
@media only screen and (max-width:500px){
    .faq-static-table .faq_price_table tr th,.faq-static-table .faq_price_table tr td{font-size:11px}
    .popup_bg, .popup_bgs{width:95% !important}
    .popup_bg .popup_form,.popup_bgs .popup_form{padding:10px}
    .popup_bg .label1,.popup_bgs .label1{text-align:left;float:none;width:100%}
    .popup_bg .field,.popup_bgs .field{float:none;padding-left:0}
    .popup_bg .field input,.popup_bgs .field input,.popup_bgs .field select,.popup_bg .field select,.popup_bgs .field select, .popup_bgs .field textarea{width:100%}}
</style>
<div class="cmn_bdr_shadow outer_cmn_wrapper faq-static-table">
<table class="table" cellspacing="10">
	<tbody>
		<tr>
			<td>
				<h5><?php echo __('How is Orangescrum different from other tools or systems');?>?</h5>
				<p>
					<?php echo __('Orangescrum combines work management + team collaboration & file sharing + invoicing + timelog, so that you can do more with the help of just one app');?>. <?php echo __('Orangescrum, to accelerate your business without the botheration of managing multiple apps');?>. <br /><br />
					<?php echo __('Check in the');?> <a href="https://www.orangescrum.com/success-story/" target="_blank"><?php echo __('success story');?></a> <?php echo __('of SARAL using Orangescrum');?>. 
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('Can I avail a free trial plan with all features');?>?</h5>
				<p>
				<?php echo __("As soon as you sign up, you can enjoy Orangescrum's free trial for 30 days with all its features");?>.
				</p>
			</td>
		</tr>
		<tr>
			<td class="space_td">
<!--				<h5>What will happen to my account after my trial period is over?</h5>
				<p>
					Your account will downgrade to a limited account with 1 User, 2 Projects & 20MB of cloud storage. You can upgrade your account at any time to avail all its features and professional services.
					<br/><br/><br/>
					<div class="pricing_help_cont">
						<span style="display: block;font-weight: bold;padding-bottom: 10px;">Hi, need help in choosing the right plan?</span>
						<a href="mailto:support@orangescrum.com?subject=Need help in choosing the right plan?">Contact us</a> and we will help you choose the best plan that would synchronize with your business to accelerate it.
					</div>
					
				</p>-->
                                <h5><?php echo __('When will I be charged for the paid plan');?>?</h5>
				<p>
					<?php echo __('You will be charged at the beginning of the subscription date');?>. <?php echo __('All our plans are monthly chargeable plans');?>. <?php echo __('If you cancel your account at any time within the billing cycle,  you will not be charged further and your subscription will be active till the end of the next billing date');?>. <?php echo __('You will still have all the access to all the functionalities you have with your current plan');?>. <?php echo __('You will not be charged from the next billing cycle and your subscription will be deactivated at the end of your current cycle date');?>. <br /><br />
					<?php echo __('Ex: If you choose your plan on Jan 1, then your next payment date is Jan 31');?>.
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('Can I opt for an Annual Orangescrum Cloud Subscription');?>?</h5>
				<p>
					<?php echo __('Yes, you can! Orangescrum Cloud is available on an annual subscription plan in addition to monthly plan');?>.
				</p>
			</td>
			
		</tr>
		<tr>
			<td>
				<h5><?php echo __('I am not sure which plan best suits me');?>!</h5>
				<p>
					<?php echo __('You can start with the plan that suits your needs today (say with respect to number of users) and upgrade to higher plan any time as required');?>. <?php echo __('You will be charged a pro-rated amount based on the remaining time in the current billing cycle');?>.<br >
					<?php echo __('Ex: If you have 10 Users as of now then you can go for the "Startup" plan (10 users, Unlimited projects, 5 GB storage) and upgrade as per your requirement');?>.
				</p>
			</td>
                        <td class="space_td"></td>
			<td>
				<h5><?php echo __('Do you have any quick guide or getting started page');?>?</h5>
				<p>
					<?php echo __("Yes, we do. It's known as");?> "<a href='http://helpdesk.orangescrum.com/' target="_blank"><?php echo __('Orangescrum Helpdesk');?></a>" - <?php echo __("you will find all the answers to your questions with screenshots that will guide you in getting started with Orangescrum as well as rescue you if you're stuck somewhere");?>.   
				</p>
			</td>
			
			
		</tr>
		<tr><td>
				<h5><?php echo __('Can I downgrade or cancel');?>?</h5>
				 <p>
					<?php echo __('You can downgrade to a lower paid plan or cancel anytime');?>. 
				</p>
			</td>
                        <td class="space_td"></td>
			<td>
				<h5><?php echo __('How can I change my plan');?>?</h5>
				<p>
					<?php echo __('You can change it from "Account Settings"');?>. <?php echo __('Click on your profile and navigate to "Account Settings" to select "Subscription". Choose "Change Plan" to change your current plan');?>.  
				</p>
			</td>
			
		</tr>
		<tr>
                    
			<td>
				<h5><?php echo __('What if I have a huge team and expecting unlimited activities');?>?</h5>
				<p><?php echo __('No problem');?>, <a href="mailto:support@orangescrum.com?subject=What if I have a huge team and expecting unlimited activities?"><?php echo __('Contact us');?></a> <?php echo __('to avail customized pricing');?>.</p>
			</td>
                        <td class="space_td"></td>
			<td>
				<h5><?php echo __('Apart from online payment, is there any other way of making payment');?>?</h5>
				<p>
					<?php echo __('Yes, the other mode of payment is wire transfer. This mode is accepted for both monthly and yearly subscriptions');?>. <a href="mailto:support@orangescrum.com?subject=Apart from online payment, is there any other way of making payment?"><?php echo __('Contact us');?></a> <?php echo __('for any help to know more');?>.
				</p>
			</td>
			
			
		</tr>
		<tr>
			<td>
				<h5><?php echo __('Can I get a Custom Plan which best suits my business');?>?</h5>
				<p>
					<?php echo __('Yes');?>, <a href="mailto:support@orangescrum.com?subject=Can I get a Custom Plan which best suits my business?"><?php echo __('Contact us');?></a> <?php echo __('to get custom plan for your account');?>.
				</p>
			</td>
                        <td class="space_td"></td>
			<td>
				<h5><?php echo __('Is there any option to have Orangescrum on my premises');?>?</h5>
				<p>
					<?php echo __('Of course, we can install Orangescrum in your environment with a customized price');?>. <a href="mailto:support@orangescrum.com?subject=Is there any option to have Orangescrum on my premises?"><?php echo __('Contact us');?></a> <?php echo __('for on-premises solutions');?>.
				</p>
			</td>
			
			
		</tr>
		<tr>
			<td>
				<h5><?php echo __('Is my data secured');?>?</h5>
				<p>
					<?php echo __('The security of your information is extremely important to us. We do not save any credit card number in our database, neither share your email ids to third parties. All the sensitive information are encrypted using secure socket layer technology (SSL)');?>.
				</p>
			</td>
                        <td class="space_td"></td>
			<td>
				<h5><?php echo __('Do you need my credit card for a free trial');?>?</h5>
				<p>
					<?php echo __('There is no need of any credit card during your free trial');?>.
				</p>
			</td>
			
			
		</tr>
		<tr>
			<td>
				<h5><?php echo __('What payment modes do you accept');?>?</h5>
				<p>
					<?php echo __('We accept payments through all major credit card services (MasterCard, Visa, American Express, etc)');?> 
				</p>
			</td>
                        <td class="space_td"></td>
			<td>
				<h5><?php echo __('Can I use multiple Orangescrum accounts');?>? </h5>
				<p>
					<?php echo __('You can create only one Orangescrum account but if you are the owner of the account, it is possible to operate multiple companies');?>. 
				</p>
			</td>
			
			
		</tr>
		<tr>
			<td>
				<h5><?php echo __('What about the refund policy');?>?</h5>
				<p>
					<?php echo __('You are charged from your subscription start date till the end of 30-days of your subscription. If you cancel in between, your subscription would be still active till the next billing date');?>.</p>
          <p>
					<?php echo __('Ex: If you cancel your subscription on Jan 5 & your billing date was Jan 1, your account will active till Jan 31 and you will be charged for the month of January');?>. 
          </p>
          <p>
          For our refund policy, <a href="<?php echo HTTP_ROOT;?>termsofservice#10" target="_blank">refere here.</a> 
				</p>
			</td>
                        <td class="space_td"></td>
			<td>
				<h5><?php echo __('Can I customize my Orangescrum');?>?</h5>
				<p>
					<?php echo __('We do not accept any customization request for the cloud version. However, you can request us for a new feature');?>. <br />
					<?php echo __('Note: Customization request is possible if you are using or interested for the Orangescrum Community or Enterprise (on-Premises) Version');?>. 
				</p>
			</td>
			
			
		</tr>
	</tbody>
</table>
</div>
