<style>
.pricing_help_cont{background:#e1e8f2;border:2px solid #a6cbfc;border-radius:10px;font-size:15px;padding:11px;}
.faq-no-margin{margin:0;width:100%}
.faq_new_label{font-size:26px;margin:0 auto;padding-bottom:4px;padding-top:1px;width:400px;font-weight:400;}
</style>
<div class="cmn_bdr_shadow outer_cmn_wrapper faq-static-table faq-no-margin">
<div class="faq_new_label"><?php echo __('Frequently Asked Questions');?></div>
<table class="table" cellspacing="10">
	<tbody>
		<tr>
			<td>
				<h5><?php echo __('What is Orangescrum Self-Hosted');?>?</h5>
				<p>
					<?php echo __('Orangescrum Self-Hosted (on Premises) is the self- hosted version of Orangescrum cloud');?>. 
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('Is there a self-hosted version of Orangescrum with all of the latest features');?>?</h5>
				<p>
					<?php echo __('You will get all the features in Self-Hosted version as that in the Cloud.However the Resource Availability, Mobile API and Chat features will need to be purchased separately');?>.
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<h5><?php echo __('Does Orangescrum Self-Hosted support plugins');?>?</h5>
				<p>
					<?php echo __('No, just like the existing');?> <a href="<?php echo HTTP_ROOT;?>" title="<?php echo __('Orangescrum cloud version');?>"><?php echo __('cloud version');?></a> <?php echo __("of Orangescrum, it doesn’t have plugins.However, we can customize as per your requirement with additional cost");?>. <?php echo __('So you can build Orangescrum according to your business need');?>.
					
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('What are the recommended specs for Orangescrum Self-Hosted');?>?</h5>
				<p>
					<?php echo __('It can be used on');?> <a href="https://www.orangescrum.org/installation-guide" target="_blank" title="<?php echo __('Linux');?>"><?php echo __('Linux');?></a> <?php echo __('operating system(Ex: Ubuntu Server 16.04 LTS x64, CentOS_7.2_x64) and Windows, Mac with minimum 4 GB RAM, 20 GB Disk space, 2.8 GHz or faster processor.');?>.
				</p>
				<div>
				<strong><?php echo __('Requirements');?>:</strong>
				<p>
				<?php echo __('Apache (2.4) with `mod_rewrite`, PHP 5.6,PHP 7.x (7.2 is better) MySQL 5.7, ImageMagick 6.7.710, wkhtmltopdf 0.12.2, Sendgrid used for outbound Emails.');?>.
				</p>
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<h5><?php echo __('Is Orangescrum Self-Hosted a separate product from Orangescrum Cloud');?>?</h5>
				<p>
					<?php echo __('No, Orangescrum Self-Hosted is the self-hosted version of Orangescrum cloud. You will get all the features in Self-Hosted version as that in Cloud.However the Resource Availability, Mobile API and Chat will need to be purchased separately. This version is especially for those who want to keep the project management data in-house and away from public view');?>.
				</p>
				<p>
					<?php echo __('Now, you can host');?> <a href="<?php echo HTTP_ROOT;?>" title="<?php echo __('Orangescrum cloud');?>"><?php echo __('Orangescrum cloud');?> </a><?php echo __('version on your own server');?>.  
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('Will Orangescrum Self-Hosted get automatic updates like cloud');?>?</h5>
				 <p>
					<?php echo __('No, given that Self-Hosted will run on your own servers, updates are not automatically applied. However, we can update it around every 6 months with your permission');?>. <a href="https://www.orangescrum.org/our-support-plan" target="_blank"><?php echo __('Our Support Team');?></a> <?php echo __('will carry this out');?>.
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<h5><?php echo __('Is Maintenance included for Self-Hosted');?>?</h5>
				<p>
					<?php echo __('Yes, maintenance is included for the first 12 months of on-going upgrades with unlimited email support');?>.
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('Can I evaluate Orangescrum Self-Hosted before purchasing');?>?</h5>
				<p><?php echo __('Yes, you can begin a');?> <a href="<?php echo HTTP_ROOT ;?><?php echo SIGNUP_CTA_LINK; ?>" style="text-decoration:none" title="<?php echo __('trial of our cloud version');?>"><strong><?php echo __('Trial of our cloud version');?> </strong></a><?php echo __('to understand the functionality provided by Self-Hosted');?>. <?php echo __('If you have other requirements, then');?> <a href="javascript:void(0)" style="text-decoration:none" onclick="order_now(4)" title="<?php echo __('Get in Touch');?>"><strong><?php echo __('Get in Touch');?></strong></a> <?php echo __('with us and we can help you');?>.</p>
			</td>
		</tr>
		<tr>
			<td>
				<h5><?php echo __('How is Orangescrum Self-Hosted licensed');?>?</h5>
				<p>
					<?php echo __('Orangescrum Self-Hosted is licensed under a subscription model. Licenses are');?> <a href="<?php echo HTTP_ROOT;?>pricing/#self-hosted" title="self-hosted"><?php echo __('purchased');?></a> <?php echo __('for a one-year period, which includes full support and access to all updates via regular upgrades');?>.
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('We are a large company (500+ users). Do you have licensing options for us');?>?</h5>
				<p>
					<?php echo __('Yes');?>, <a href="javascript:void(0)" style="text-decoration:none" onclick="order_now(4)" title="<?php echo __('Get in Touch');?>"><strong><?php echo __('Get in Touch');?></strong></a> <?php echo __('with us and we can always discuss your requirements to build the right package for your Self-Hosted');?>.
				</p>
			</td>
		</tr>
		<tr>
			<td>
				<h5><?php echo __('Does the license include access to the source code');?>?</h5>
				<p>
					<?php echo __('Of course, we can install Orangescrum in your environment for an Installation Fee of $99. Contact us for');?> <a href="<?php echo HTTP_ROOT;?>users/community_installation_support" title="<?php echo __('on-premise installation');?>"><?php echo __('on-premise installation');?></a>.  
				</p>
			</td>
			<td class="space_td"></td>
			<td>
				<h5><?php echo __('Is my data secured');?>?</h5>
				<p>
					<?php echo __('Since the Self-Hosted version will be set up and mounted in customers premises, the data security will be fully governed at the customers end');?>.
				</p>
			</td>
		</tr>
	</tbody>
</table>
</div>