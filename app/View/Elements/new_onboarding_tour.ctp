<style>
<?php /*.onbording-li li { list-style:none;}
.onbording-li li a{border: 1px solid orange;width: 80%;}
.onbording-div {border-right: 1px solid #f3e7e7;height: 290px;text-align: center;
vertical-align: middle;line-height: 29px;}
.onbording-span_in {font-size:20px;color: #aeefe6;font-weight:bold;}
.onbording-span {font-size:15px;font-weight:bold;}
*/ ?>
</style>
<div id="start_journey">
<div class="modal-dialog">
		<button type="button" class="close" data-dismiss="modal" onclick="closePopup('onbd');">&times;</button>
    <!-- Modal content-->
	<div class="modal-content">
		<article>
			<aside>
				<?php /*<h2><?php echo __('Start Your');?></h2>
				<h3><?php echo __('Orangescrum Journey');?></h3>*/ ?>
				<h3><?php echo __('Welcome!');?></h3>
				<p>
					<strong><?php echo __("Take a tour of what you can do with Orangescrum.");?></strong>
					<small><?php echo __("All the focus you need to keep your team, projects and communication on track.");?></small>
				</p>
				<p><span id="tour_counter">0</span>/4 <?php echo __('Task completed');?></p>
				<div class="progress_line">
					<div class="fill_bar"></div>
				</div>
				<div class="ftbg"></div>
			</aside>
			<aside>
				<ul class="benefit_punch_lst">
					<li  id="plan_your_project">
						<div class="tab_img"><span class="lst_1"></div>
						<strong><?php echo __('Plan Your Project');?></strong>
						<small><?php echo __('Build your project plan with absolute clarity and details. No room for guess work!');?></small>
					</li>
					<li id="align_your_resource">
						<div class="tab_img"><span class="lst_2"></div>
						<strong><?php echo __('Align Your Resource');?></strong>
						<small><?php echo __('Get your team onboard to deliver strategic results.');?></small>
					</li>
					<li id="manage_your_work">
						<div class="tab_img"><span class="lst_3"></div>
						<strong><?php echo __('Manage Your Work');?></strong>
						<small><?php echo __('Prioritize, optimize & deliver quality outputs on-time, everytime!');?></small>
					</li>
					<li id="time_and_resource">
						<div class="tab_img"><span class="lst_4"></div>
						<strong><?php echo __('Time & Resource Management');?></strong>
						<small><?php echo __('Monitor and control 2 of your most critical project success factors!');?></small>
					</li>
					<?php /*<li>
						<div class="tab_img"><span class="lst_5"></div>
						<strong>Make your Project Agile</strong>
						<small>It is an iterative approach to planning and guiding project processes.</small>
					</li> */ ?>
				</ul>
			</aside>
		</article>
	</div>
</div>
</div>