<?php $userd = $this->Format->getUserDtls(SES_ID);
	$udtc = date('Y-m-d',strtotime($userd['User']['dt_created']));
 ?>
<script type="text/javascript" src="https://connect.facebook.net/en_US/sdk.js"></script>
<script type="text/javascript">
  FB.init({
		appId   : <?php echo FB_APP_ID;?>,
		status  : true,
		xfbml   : true,
		version : 'v2.9'
	});
  FB.AppEvents.logPageView();
</script>
<?php echo $this->Html->css('jquery.dropdown.css'); ?>
<?php echo $this->Html->css('select2.min'); ?>
<?php if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")) { ?>
				
		<!-- Anti-flicker snippet (recommended)  -->
		<style>.async-hide { opacity: 0 !important} </style>
		<script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
		h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
		(a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
		})(window,document.documentElement,'async-hide','dataLayer',4000,
		{'GTM-W3H5PWN':true});</script>
		
		<!-- Google Tag Manager -->
		<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
		new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
		j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
		'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
		})(window,document,'script','dataLayer','GTM-W3H5PWN');</script>
		<!-- End Google Tag Manager -->		
	<?php } ?>
<style>
	.step_count {display:none;}
	.onboard_page_wrap{min-height: 100vh;padding: 30px 0;display: flex;
    align-items: center;justify-content: center;flex-direction: column;}
	.cmn_onboard_layout{max-width: 1000px;margin:0 auto;font-family: 'Montserrat', sans-serif;}
	.cmn_onboard_layout .wecome_onboard_sec .wrapper{width:100%;max-width:1200px;margin:0 auto;padding:30px 0;}
	.cmn_onboard_layout .wecome_onboard_sec .logo a{margin:0}
	.cmn_onboard_layout .wecome_onboard_sec h1{font-size:40px;line-height:50px;font-weight:500;margin: 30px 0 30px;font-family: 'Montserrat', sans-serif;}
	.onboard_page_wrap .welcome_page h1 span{color:#24a90c;font-weight:600}
	.onboard_page_wrap .wecome_onboard_sec .form_fld_group{margin-top:1px}
	.cmn_onboard_layout .wecome_onboard_sec h2{font-size:28px;line-height:50px;color: #333;
    font-weight: 500;margin:30px 0 30px;padding:0;font-family: 'Montserrat', sans-serif;}
	.cmn_onboard_layout .wecome_onboard_sec h2 strong{font-size:24px;line-height:30px;font-weight:600;}
	.cmn_onboard_layout .wecome_onboard_sec h2 span{font-size:22px;line-height:30px;font-weight:400}
	.cmn_onboard_layout .wecome_onboard_sec .right h2 span{font-weight:400}
	.cmn_onboard_layout .wecome_onboard_sec .logo{text-align:center}
	.cmn_onboard_layout .wecome_onboard_sec article{display:table;width:100%;position:relative}
	.cmn_onboard_layout .wecome_onboard_sec article aside{float:none;display:table-cell;vertical-align:middle;width:50%;}
	.cmn_onboard_layout aside.left{padding-right:30px}
	.cmn_onboard_layout aside.right{padding-left:30px}
	.cmn_onboard_layout .wecome_onboard_sec .center_form{position:relative;transform:none;-webkit-transform:none;-moz-transform:none;top:0;font-family: 'Montserrat', sans-serif;}
	.cmn_onboard_layout .layout_view .dtbl .dtbl_cel a{font-size:16px;line-height:30px;color:#333;font-weight:400;cursor:default;}
	.cmn_onboard_layout .layout_view .dtbl .dtbl_cel a #template_title{font-size: 22px;font-weight:600;color: #ff7a58;}
	.cmn_onboard_layout .wecome_onboard_sec .custom-checkbox{float:none;width:auto;display: inline-block;vertical-align: middle;margin: 0 20px 0px 0px;}
	.onboard_page_wrap .wecome_onboard_sec .layout_view figure{width:100px;height:100px;margin:0 auto}
	.onboard_page_wrap .wecome_onboard_sec .step_image{display:none;width:250px;margin:35px auto 0}
	.onboard_page_wrap .wecome_onboard_sec .onboad_field_group{width:315px;margin:100px auto 0}
	.welcome_page .cmn_onboard_layout::before{display:none}
	.cmn_onboard_layout .wecome_onboard_sec article::before {content: '';
    background: url(<?php echo HTTP_ROOT;?>img/onboard/vline-shadow.png) no-repeat 0px 0px;width:5px;height:300px;position: absolute;left: 0;right: 0; top: 0;bottom: 0;margin: auto;z-index: 1;background-size: 100% 100%;}
	.cmn_onboard_layout .wecome_onboard_sec .back_next_btn a.next_btn:hover{opacity:0.9}
	.pm-img-wrap img{width:50px; margin-right: 10px;}
	
	/*Onboard step layer start*/
		.onboard_step_layer{background:url(<?php echo HTTP_ROOT;?>img/onboard/onboard-step-bg.jpg) no-repeat center center;background-size:cover}
		.onboard_step_layer .welcome_page .cmn_onboard_layout{max-width: 950px;}
		.onboard_step_layer .welcome_page .cmn_onboard_layout .wrapper{max-width: 100%;}
		.onboard_step_layer .cmn_onboard_layout .wecome_onboard_sec .wrapper{padding:0}
		.onboard_step_layer .cmn_onboard_layout .wecome_onboard_sec h1 {font-size: 30px;line-height: 45px;font-weight: 600; margin: 15px 0 50px;}
		.onboard_step_layer .onboard_steps_card{padding: 45px 45px 45px;border-radius: 30px;background-color: rgb(255, 255, 255); box-shadow: 0px 4px 70px 0px rgba(55, 90, 160, 0.17);}
	.cmn_onboard_layout .onboard_steps_card aside.left{padding-right: 80px;background:none;vertical-align:top}
	.cmn_onboard_layout .onboard_steps_card aside.right{padding-left: 80px;background:none;vertical-align:top}
	.cmn_onboard_layout .wecome_onboard_sec .onboard_steps_card  h2{line-height: 30px;margin:0 0 20px;position:relative;text-align:center}
	.cmn_onboard_layout .wecome_onboard_sec .onboard_steps_card  h2 span{font-size: 18px;line-height: 30px;font-weight: 600;}
		.onboard_step_layer .wecome_onboard_sec .onboard_steps_card .steps-icon{display: block;font-size: 24px;line-height: 30px;margin-bottom: 5px;text-align:center}
	/*.onboard_step_layer .wecome_onboard_sec .onboard_steps_card .right .steps-icon{left:initial;right:-30px}
	.onboard_step_layer .wecome_onboard_sec .onboard_steps_card .steps-icon small{display:block;font-size: 20px}*/
	.cmn_onboard_layout .onboard_steps_card .center_form{display:flex;flex-direction:column;position:relative;}
		
	.onboard_page_wrap .wecome_onboard_sec .create_first_project{width: 100%; margin: 0;
    display: flex;flex-direction: column;justify-content: center;}
	.onboard_page_wrap .create_first_project .onboad_inp_fld{margin:0}
	.onboard_page_wrap .wecome_onboard_sec .create_first_project .define-project-name-input{width:100%;height: 40px;
    line-height: 40px;color: #1d2b36;font-size: 14px;font-weight:500; padding: 0 15px;border:1px solid #c1cbd4;border-radius: 4px;
    background: #fff;-webkit-transition: -webkit-box-shadow .2s; transition: -webkit-box-shadow .2s;
    -o-transition: box-shadow .2s;transition: box-shadow .2s;transition: box-shadow .2s,-webkit-box-shadow .2s;}
	.cmn_onboard_layout .onboard_steps_card  .layout_view .dtbl .dtbl_cel a {font-size: 14px; line-height: 24px;font-weight: 500;}
	.onboard_steps_card .back_next_btn a.next_btn{display: block;background: #4a5ce2;color: #fff;border-color: #4a5ce2;
    outline: none;padding: 0px 30px;font-size: 14px; height: 40px;line-height: 38px;font-weight: 400;text-transform: uppercase;border-radius: 4px;}
	.onboard_steps_card .back_next_btn a.next_btn:hover,.onboard_steps_card .back_next_btn a.next_btn:focus{background: #3446d0;border-color: #3446d0;color:#fff}
	.onboard_steps_card .back_next_btn #btn_onboard[disabled="disabled"]{background:#ccc;border-color:#ccc;color:#000;cursor: not-allowed;opacity: 0.8;}
	.onboard_steps_card .back_next_btn #btn_onboard[disabled="disabled"]:hover,
	.onboard_steps_card .back_next_btn #btn_onboard[disabled="disabled"]:focus{background:#ccc;border-color:#ccc;color:#000}
	.onboard_steps_card .onboad_project{margin: 20px 0 0;}
	.onboard_page_wrap .wecome_onboard_sec .create_first_project .define-project-name-input:hover {
    border-color: rgba(0,0,0,0.1) !important;-webkit-box-shadow: 0 0 0 4px rgba(255,122,89,0.1);
    box-shadow: 0 0 0 4px rgba(255,122,89,0.1);}
	
	.create_first_project .define-project-name-input::-webkit-input-placeholder { color: #666;font-weight:500}
	.create_first_project .define-project-name-input::-webkit-input-placeholder::-moz-placeholder { color: #666;font-weight:500}
	.create_first_project .define-project-name-input::-webkit-input-placeholder:-ms-input-placeholder {color: #666;font-weight:500}
	.create_first_project .define-project-name-input::-webkit-input-placeholder:-moz-placeholder { color: #666;font-weight:500}
	.create_first_project .define-project-name-input:focus::-webkit-input-placeholder { color: transparent;}
	.create_first_project .define-project-name-input:focus::-webkit-input-placeholder::-moz-placeholder { color: transparent;}
	.create_first_project .define-project-name-input:focus::-webkit-input-placeholder:-ms-input-placeholder {color: transparent;}
	.create_first_project .define-project-name-input:focus::-webkit-input-placeholder:-moz-placeholder { color: transparent;}
	
	
	
	
	/*Onboard step layer end*/  
	
	
	
	@media only screen and (max-width:1360px){
		.ptModal_popup .template_item{padding: 15px 15px 15px;min-height: 260px}
		.ptModal_popup .template_item p {min-height: 60px;}
		.ptModal_popup .template_item h5{margin: 10px 0 10px;}
		.ptModal_popup .template_item a{margin-top:10px;}
		.ptModal_popup .template_item figure{height:80px;}
		.ptModal_popup .template_item figure img{max-height:100%}
	}
</style>
<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700,800,900&display=swap" rel="stylesheet">
<?php $page_b = ''; if(isset($from_ref_page)){ $page_b = $from_ref_page; } ?>
<div class="onboard_page_wrap onboard_step_layer">
	<!--Welcome page start-->
  <div class="welcome_page">        
    <!-- End of Step 1 -->
    <?php 
		/*<div class="step-2 steps cmn_onboard_layout bg_layer_4"  style="display:block;">
      <aside class="cmn_wh_aside left">
        <div class="center_image">
          <div class="box_wrapper">
						<figure>
							<img src="<?php echo HTTP_ROOT;?>img/onboard/get-set.png">
						</figure>
					</div>
				</div>
			</aside>
      <aside class="cmn_wh_aside right">
        <div class="logo">
          <a href="" title="Orangescrum Project Mamangemet Tool">
            <img src="<?php echo HTTP_ROOT;?>img/header/orangescrum-logo.png" alt="#1 Productivity Tool" title="#1 Productivity Tool" width="200" height="58">
					</a>			
				</div>
        <div class="center_form">
          <div class="box_wrapper">
						<div class="step_count"><?php echo __('Step'); ?> <span>2</span> <?php echo __('of'); ?> <span>6</span></div>
						<h1><?php echo __("Welcome").',';?> <span><?php echo ucfirst($user['User']['name']); ?>!</span>
						<small><?php echo __("Upload your profile image");?></small></h1>
						<div class="form_fld_group"> 
							<div class="upload_pflimg"> 
								<figure class="<?php if (isset($user['User']['photo']) && !empty($user['User']['photo'])) { echo 'filled';} ?>" onclick="openProfilePopup()" style="cursor: pointer;">
                  <img id="defaultPic" src="<?php
										if (isset($user['User']['photo']) && !empty($user['User']['photo'])) {
                      echo HTTP_ROOT . 'users/image_thumb/?type=photos&file=' . $user['User']['photo'] . '&sizex=100&sizey=100&quality=100';
											} else {
                      echo HTTP_ROOT . 'img/onboard/choose-profile-image.png';
										}
									?>" alt="Profile Photo" title="<?php echo __('Choose a profile image');?>" width="" height="">
								</figure>
							</div>                       
							<input type="hidden" id="imgName1" name="data[User][photo]" />
							<div class="upload_img_hangbx">
                <div class="input_wrapper">
									<?php echo __('Choose a profile image'); ?>
								</div>
							</div>    
							<div class="onboad_field_group">
								<div class="form-group label-floating onboad_inp_fld">
									<label class="control-label" for="fname"><?php echo __('Your Full Name');?></label>
									<input class="form-control" id="fname" type="text" value="<?php echo $user['User']['name']; ?>" onchange="saveTimezone();" />
								</div>				
                <div class="onboad_inp_fld">
									<div class="where_to_you">
										<label class="control-label"><?php echo __('Select your Time Zone'); ?></label>
										<div class="loaction_dropdown_bkp">
											<select name="timezone" class="form-control floating-label" data-dynamic-opts=true placeholder="" onchange="saveTimezone()" id="timezone" >
												<option value="0">--<?php echo __('Select'); ?>--</option>
												<?php foreach ($timezones as $get_timezone) { ?>
													<option  <?php if ($get_timezone['TimezoneName']['id'] == $user['User']['timezone_id']) { ?> selected <?php } ?> value="<?php echo $get_timezone['TimezoneName']['id']; ?>"><?php echo $get_timezone['TimezoneName']['gmt']; ?> <?php echo $get_timezone['TimezoneName']['zone']; ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
								</div>
								<div class="onboad_inp_fld">
									<div class="where_to_you">
										<label class="control-label"><?php echo __('Choose your language'); ?></label>
										<div class="loaction_dropdown_bkp">
											<select name="language" class=" form-control floating-label" placeholder="" data-dynamic-opts=true onchange="saveOnboardlang()" id="onboard_lang" >
												<option  <?php if ($this->Session->read('Config.language') == 'eng') { ?> selected <?php } ?> value="eng">English</option>
												<option  <?php if ($this->Session->read('Config.language') == 'spa') { ?> selected <?php } ?> value="spa">Spanish</option>
												<option  <?php if ($this->Session->read('Config.language') == 'por') { ?> selected <?php } ?> value="por">Portuguese</option>
												<option  <?php if ($this->Session->read('Config.language') == 'deu') { ?> selected <?php } ?> value="deu">German</option> 
												<option  <?php if ($this->Session->read('Config.language') == 'fra') { ?> selected <?php } ?> value="fra">French</option>
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="onboad_inp_fld help_next_btn">
							<div class="continue_btn">
								<input type="button" value="<?php echo __('Next'); ?>" onclick="changeStep(3);" >
							</div>
							<a href="https://helpdesk.orangescrum.com/cloud/" target="_blank" class="help"><i class="material-icons">&#xE887;</i> <?php echo __('Can I help');?></a>
						</div>
					</div>
				</div>
			</aside>
			<div class="cb"></div>
		</div>
		*/ ?>
		<!-- End of Step 1 -->
		<div class="cmn_onboard_layout">
			<section class="wecome_onboard_sec">
				<div class="wrapper">
					<div class="logo">
						<a href="javascript:void(0);" title="Orangescrum Project Mamangemet Tool">
							<img src="<?php echo HTTP_ROOT;?>img/header/orangescrum-cloud-logo.svg" alt="#1 Productivity Tool" title="#1 Productivity Tool" width="250" height="55">
						</a>			
					</div>
					<h1>
						<?php echo __("Welcome").',';?> <span><?php echo ucfirst($user['User']['name']); ?>!</span>
					</h1>
					<article class="onboard_steps_card">	
						<aside class="left">
							<strong class="steps-icon"><?php echo __('Step');?> <small><?php echo __('1');?></small></strong> 
							<div class="center_form">
								<div class="box_wrapper">
									<div class="form_fld_group">
										<div class="layout_view">
											
											<div class="dtbl">
												<div class="dtbl_cel">
													<a href="javascript:void(0);" class="creat_proj creat_proj-simple">
														<figure>
															<img class="imgptype" id="template_thumbnail" src="<?php echo HTTP_ROOT;?>img/project_template_icons/ok-<?php echo $pmF['ProjectMethodology']['thumbnail'];?>" alt="Simple Project Mamangemet">
														</figure>	
														<strong>
															
														<span id="template_title"><?php echo $pmF['ProjectMethodology']['title'];?></span></strong>
														<span id="template_short"><?php echo $pmF['ProjectMethodology']['short_description'];?></span>
													</a>
												</div>
																							
											</div> 
											<div class="back_next_btn">
											</div>
											
											<input type="hidden" id="projectmethodology" value="<?php echo $pmF['ProjectMethodology']['id'];?>" />	
											<input type="hidden" id="projectworkflow" value="<?php echo $pmF['ProjectMethodology']['status_group_id'];?>" />							
											<div class="onboad_inp_fld help_next_btn" style="display:none;">
												<div class="continue_btn">
													<input type="button" value="<?php echo __('Next'); ?>" onclick="changeStep(4);closePopup();" >
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</aside>
						<aside class="right">
							<strong class="steps-icon"><?php echo __('Step');?> <small><?php echo __('2');?></small></strong>
							<div class="center_form">
								<h2><span><?php echo __("Create your first project"); ?></span></h2>
								<div class="box_wrapper">
									<div class="step_count"><?php echo __('Step'); ?> <span>4</span> <?php echo __('of'); ?> <span>6</span></div> 
									<figure class="step_image">
										<img class="name-your-proj" src="<?php echo HTTP_ROOT;?>img/onboard/name-of-project.png" alt="" width="" height="">
									</figure>
									<figure class="onboad_project">
										<img  src="<?php echo HTTP_ROOT;?>img/onboard/Orangescrum-project.svg" alt="Create your first project" width="90" height="95">
									</figure>
									
									<div class="onboad_field_group create_first_project">
										<?php /*<p class="proj_name proj_name_onboard"><?php echo __('Simple Project'); ?></p> */?>
										<p class="proj_desc proj_desc_onboard"></p>
										<div class="form-group onboad_inp_fld">
											<?php /*<label class="control-label" for="txt_Proj_onboard"><?php echo __("Enter a project name"); ?></label> */?>
											<?php echo $this->Form->text('name', array('value' => '', 'class' => 'form-control define-project-name-input', 'id' => 'txt_Proj_onboard', 'maxlength' => '50', 'autocomplete' => 'off', 'placeholder' => 'Enter a project name')); ?>				
											<?php echo $this->Form->text('short_name', array('value' => '', 'class' => 'form-control ttu', 'id' => 'txt_shortProj_onboard', 'placeholder' => "MP", 'maxlength' => '5', 'style' => 'display:none;')); ?>
										</div>
										<div id="err_msg_onboard" style="color:#FF0000;display:none;font-size:14px;"></div>
										<div class="back_next_btn">
											<a href="javascript:void(0);" class="back_btn" onclick="changeStep(3);">
												<i class="material-icons">chevron_left</i>
												<?php echo __('Back');?>
											</a>
											<a href="javascript:void(0);" id="btn_onboard" class="next_btn" onclick="projectOnboardAdd('txt_Proj_onboard', 'txt_shortProj_onboard', 'loader_onboard', 'btn_onboard');">
												<?php echo __('Create Project');?>
											</a>
											<span id="loader_onboard" style="display:none;">
												<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
											</span>
										</div>
									</div>
								</div>
							</div>				
						</aside>
						<div class="cb"></div>
					</article>
				</div>
			</section>
		</div>
    <!-- End of Step 3 -->
	</div>
	<!--Welcome page end-->      
</div>
<div class="container cmn-popup ">
  	<div class="modal fade" id="myModal" role="dialog">
    	<div class="prof_img cmn_popup" style="display: none;">
			<?php echo $this->element('popup_edit_profile_image'); ?>
		</div>
		<div class="proj_type_methodo cmn_popup" style="display: none;">
			<?php //echo $this->element('popup_onboard_project_type'); ?>
		</div>  
	</div>
	<div class="proj_tmpl_methodo ptModal_popup modal fade" id="myModalTemplate" role="dialog">    	
			<div class="modal-dialog">
			    <div class="modal-content">
			        <div class="modal-header">
			            <button type="button" class="close close-icon" data-dismiss="modal"><i class="material-icons">&#xE14C;</i></button>
			            <h4><?php echo __('Project Templates');?></h4>
			        </div>
			        <div class="modal-body">
							<div class="layout_view">
					        	<div class="dtbl">					        		
					        	<?php foreach($pm as $k=>$v){
					        		if($k != 0 && $k%5 == 0){
					        			echo "</div><div class='dtbl'>";
					        		}
					        	 ?>
					        			<div class="dtbl_cel">
											<div class="template_item">
												<figure class="select_pt_image">
												<img class="imgptype" src="<?php echo HTTP_ROOT;?>img/project_template_icons/<?php echo $v['ProjectMethodology']['thumbnail'];?>" alt="<?php echo $v['ProjectMethodology']['title'];?>">
											</figure>	
												<h5>
												<?php echo __($v['ProjectMethodology']['title']);?></h5>
												<p><?php echo __($v['ProjectMethodology']['short_description']);?></p>
												<a href="javascript:void(0)" title="<?php echo __("Select")?>" onclick="selectTemplate(<?php echo $v['ProjectMethodology']['id']; ?>);  "><?php echo __("Select")?></a>
											</div>
										</div>
									
					        	<?php } ?>
					        	
					        </div>
					    </div>
					</div>
			        </div>
			    </div>
			</div>
		</div>  

<script type="text/javascript">
	var HTTP_ROOT ="<?php echo HTTP_ROOT;?>";
	var CLIENT_ID = "<?php echo CLIENT_ID; ?>";
	var REDIRECT = "<?php echo REDIRECT_URI; ?>";
	var API_KEY = "<?php echo API_KEY; ?>";
	var DOMAIN_COOKIE = "<?php echo DOMAIN_COOKIE; ?>";
</script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>material.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>scripts/jquery.imgareaselect.pack.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.fileupload.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.fileupload-ui.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.dropdown.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>google_drive_v1.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>google_contact.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>select2.min.js"></script>
<script type="text/javascript">
	var page_b = "<?php echo $page_b; ?>";
  var emlRegExpRFC = RegExp(
			/^[a-zA-Z0-9.’*+/_-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
		);
	var HTTP_ROOT = '<?php echo HTTP_ROOT; ?>';
	var SES_TYPE = '<?php echo SES_TYPE; ?>';
	
	$('body').height($(window).height());
	var pm = '<?php echo json_encode($pm);?>';
	

	function selectTemplate(id){
		var imgsrc = HTTP_ROOT+'img/project_template_icons/ok-'+pm[id].ProjectMethodology.thumbnail;
		$("#template_thumbnail").attr('src',imgsrc).attr('title',pm[id].ProjectMethodology.title);
		$("#template_title").html(pm[id].ProjectMethodology.title);
		$("#template_short").html(pm[id].ProjectMethodology.short_description);
		$("#projectmethodology").val(id);
		$("#projectworkflow").val(pm[id].ProjectMethodology.status_group_id);
		$('#myModalTemplate').modal("hide");
		var tit = pm[id].ProjectMethodology.title;
		$.post("<?php echo HTTP_ROOT; ?>/users/onBoard", {           
			"projectmethodology": id
			}, function(dt) {
		});
	}
	
	function loadprojectTypePopup() {
		$('#myModal').modal({
			show: true,
			backdrop: 'static',
			keyboard: false
		});
		$(".cmn_popup").hide();
		$(".popup_overlay_2").show();
		$(".proj_type_methodo").show();
	}	
	function changeTemplate(){
		$("#myModalTemplate").modal({
			show: true,
			backdrop: 'static',
			keyboard: false
		});
	}

	function referOuterFriend(type) {
    var sharSoc = '<?php echo urlencode("Hi there, I thought I would share this with you, Orangescrum, a project & task management tool, which helps you to do planning, proper resource utilization to finish your project on time & within budget.")?>';
    var shr_url = '<?php echo trim($refcode);?>';
    var shr_content = 'Hi there, I thought I would share this with you, Orangescrum, a project & task management tool, which helps you to do planning, proper resource utilization to finish your project on time & within budget.';
		if (type == 'f') {
      // window.open('http://www.facebook.com/sharer.php?u=' + shr_url + '&t=' + sharSoc, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
      FB.ui({
				method: 'share',
				display: 'popup',
				href: shr_url,
				quote: shr_content,
				}, function(response) {
				if (typeof response === 'undefined') {
					$.noop();
          } else {
					$.noop();
				}
			});
			} else if (type == 't') {
			window.open('https://twitter.com/intent/tweet?url=' + shr_url + '&text=' + sharSoc, '_blank', 'location=yes,height=570,width=520,scrollbars=yes,status=yes');
		}
	}

	
	
	$(document).ready(function () {
		<?php if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")) { ?>
		<?php if($udtc == date('Y-m-d')){ ?>
		if(typeof localStorage["issignup"] == 'undefined'){
			ga('send', 'pageview', 'https://www.orangescrum.com/pages/thankyou');
			localStorage.setItem("issignup",1);
		}
		<?php } ?>
		<?php } ?>

		$("#onboard_lang").select2();		
		$("#timezone").select2();
		$.material.init();
		$(".select").dropdown({"optionClass": "withripple"});
		//        $(".toggle-upld-arrow").click(function () {
		//            $(".upload_img_hangbx").slideToggle();
		//        });
		$('#upldphoto').change(function () {
			profilePopupClose();
			var ext = this.value.match(/\.(.+)$/)[1].toLowerCase();
			if ($.inArray(ext, ["jpg", "jpeg", "png", "gif", "bmp"]) == -1) {
				alert("Sorry, '" + ext + "' file type is not allowed!");
				this.value = '';
				} else {
				loadprofilePopup();
				$("#inactConfirmbtn").hide();
				$("#actConfirmbtn").show();
				$("#profLoader").show();
			}
		});
		$('#file_upload1').fileUploadUI({
			uploadTable: $('#up_files_photo'),
			downloadTable: $('#up_files_photo'),
			buildUploadRow: function (files, index) {
				var filename = files[index].name;
				if (filename.length > 35) {
					filename = filename.substr(0, 35);
				}
			},
			buildDownloadRow: function (file) {
				if (file.name != "error") {
					if (file.message == "success") {
						var filesize = file.sizeinkb;
						if (filesize >= 1024) {
							filesize = filesize / 1024;
							filesize = Math.round(filesize * 10) / 10;
							filesize = filesize + " Mb";
							} else {
							filesize = Math.round(filesize * 10) / 10;
							filesize = filesize + " Kb";
						}
						var imgNm = HTTP_ROOT + "files/profile/orig/" + file.filename;
						$('#up_files_photo').html('<img src="' + imgNm + '" id="profilephoto">');
						if (!$(".edit_usr_pop").is(':visible'))
						$("#imgName1").val(file.filename);
						else
						$("#imgName1-popup").val(file.filename);
						$("#profLoader").hide();
						$('#profilephoto').imgAreaSelect({
							handles: true,
							instance: true,
							x1: 10,
							y1: 20,
							x2: 60,
							y2: 60,
							fadeSpeed: 500,
							aspectRatio: '1:1',
							minHeight: 80,
							minWidth: 80,
							maxHeight: 170,
							maxWidth: 170,
							onInit: setInfo,
							onSelectChange: setInfo
						});
						} else if (file.message == "small size image") {
						alert("The image you tried to upload is too small. It needs to be at least 100 pixels wide.\nPlease try again with a larger image.");
						$("#profLoader").hide();
						$("#inactConfirmbtn").show();
						$("#actConfirmbtn").hide();
						} else if (file.message == "exceed") {
						alert("Error uploading file.\nStorage usage exceeds by " + file.storageExceeds + " Mb!");
						} else if (file.message == "size") {
						alert("Error uploading file. File size cannot be more then " + fmaxilesize + " Mb!");
						} else if (file.message == "error") {
						alert("Error uploading file. Please try with another file");
						} else if (file.message == "s3_error") {
						alert("Due to some network problem your file is not uploaded.Please try again after sometime.");
						} else {
						alert("Sorry, " + file.message + " file type is not allowed!");
					}
					} else {
					alert("Error uploading file. Please try with another file");
				}
			}
		});
		
		$('#txt_Proj').keyup(function () {
			$(this).val().trim() != '' ? $("#btn-add-new-project").removeClass('loginactive') : $("#btn-add-new-project").addClass('loginactive');
			$('#err_msg').html('');
			}).change(function () {
			$(this).val().trim() != '' ? $("#btn-add-new-project").removeClass('loginactive') : $("#btn-add-new-project").addClass('loginactive');
			$('#err_msg').html('');
		});
		var window_height=$(window).height(); 
		$('.cmn_wh_aside').height(window_height);
		
		$('#btn_onboard').attr('disabled',true); 
		$('#txt_Proj_onboard').keyup(function(){
			if($(this).val().length !=0){
				$('#btn_onboard').attr('disabled', false);
			}
			else
			{
				$('#btn_onboard').attr('disabled', true);        
			}
		})
	});
	

		

	
	function deleteCOOK(name, value, days, domain) {
		var expires;
		if (days) {
			var date = new Date();
			date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
		} else
		expires = "";
		if (domain)
		var domain = " ; domain=" + domain;
		else
		var domain = '';
		document.cookie = name + "=" + value + expires + "; path=/" + domain;
		
		window.open("<?php echo HTTP_ROOT . 'pricing' ?>", '_blank').focus();
		
	}
	function checkprojects() {
		$.post("<?php echo HTTP_ROOT . 'users/checkprojectcounts' ?>", {}, function (res) {
			if (res.count > 0) {
				self.location = "<?php echo HTTP_ROOT . 'dashboard'; ?>";
			}
		}, 'json');
	}
	function setInfo(i, e) {
		$('#x').val(e.x1);
		$('#y').val(e.y1);
		$('#w').val(e.width);
		$('#h').val(e.height);
	}
	function preview(img, selection) {
		if (!selection.width || !selection.height)
		return;
		$('#x').val(selection.x1);
		$('#y').val(selection.y1);
		$('#x2').val(selection.x2);
		$('#y2').val(selection.y2);
		$('#w').val(selection.width);
		$('#h').val(selection.height);
	}
	function profilePopupClose() {
		$('#profilephoto').imgAreaSelect({
			hide: true
		});
		$('#up_files_photo').html('');
		if (!$(".edit_usr_pop").is(':visible')) {
			closePopup();
		}
	}
	function doneCropImage() {
		var x = $('#x').val();
		var y = $('#y').val();
		var width = $('#w').val();
		var height = $('#h').val();
		if (!$(".edit_usr_pop").is(':visible'))
		var imgName = $("#imgName1").val();
		else
		var imgName = $("#imgName1-popup").val();
		$('#file_confirm_btn_loader').show();
		$('.file_confirm_btn').hide();
		if (width != 0 && height != 0 && imgName.trim() != '') {
			$.post(HTTP_ROOT + "users/done_cropimage", {
				'x-cord': x,
				'y-cord': y,
				'width': width,
				'height': height,
				'imgName': imgName
				}, function (res) {
				if (res) {
					profilePopupClose();
					$("#defaultUserImg").hide();
					$('#profilephoto').imgAreaSelect({
						hide: true
					});
					$("#imgName1").val(res);
					var filename_new = HTTP_ROOT + 'files/photos/' + res;
					$('#defaultPic').attr('src', filename_new);
					$('.upload_pflimg').addClass('filled');
					$.post("<?php echo HTTP_ROOT; ?>users/saveUserData", {photo: res}, function (res_data) {
						if (typeof res_data.error != 'undefined') {
							showTopErrSucc('error', res_data.error);
							} else {
							$('#defaultPic').attr('src', filename_new);
							$('.upload_pflimg').addClass('filled');
							//$(".upload_img_hangbx").hide();
						}
					}, 'json');
				}
				$('#file_confirm_btn_loader').hide();
				$('.file_confirm_btn').show();
			});
		}
	}
	function loadprofilePopup() {
		$('#myModal').modal({
			show: true,
			backdrop: 'static',
			keyboard: false
		});
		$(".cmn_popup").hide();
		$(".prof_img").show();
		$('#up_files_photo').html('');
		$("#actConfirmbtn").hide();
		$("#inactConfirmbtn").show();
	}
	function closePopup() {
		$(".popup_overlay_2").hide();
		$('#myModal').modal('hide');
		$(".sml_popup_bg").hide();
		$(".cmn_popup").hide();
	}
	function profilePopupCancel() {
		$('#profilephoto').imgAreaSelect({
			hide: true
		});
		$('#up_files_photo').html('');
		if (!$(".edit_usr_pop").is(':visible')) {
			closePopup();
			} else {
			$('.edit_profile_image').hide();
		}
		$(".popup_overlay_2").hide();
	}
	function openProfilePopup(page) {
		if (typeof page == 'undefined') {
			$("#upldphoto").trigger('click');
			} else {
			$("#upldphoto").trigger('click');
		}
	}
	function newProject() {
		checkprojects();
		if (SES_TYPE == '3') {
			showTopErrSucc('error', 'Oops! You are not authorized to add new Project. Please contact your account owner/admin.');
			return false;
		}
		$('#myModal').modal({show: true, backdrop: 'static', keyboard: false});
		$(".cmn_popup").hide();
		$(".new_project").show();
		$(".loader_dv").hide();
		
		var chk_proj = 0;
		$('.cancel_on_invite_pj').show();
		$('.cancel_on_direct_pj').hide();
		
		
		$('#validate').val(0);
		$('#txt_Proj').val('');
		$('#txt_Proj').val('');
		$('#inner_proj').find('#err_msg').hide();
		$('#err_msg').html('');
		$('#inner_proj').show();
		
		setTimeout(function () {
			$("#txt_Proj").focus();
		}, 500);
	}
	function saveTimezone() {
		if ($('#timezone').val() != 0) {
			$.post("<?php echo HTTP_ROOT; ?>users/saveUserData", {timezone: $('#timezone').val(), fname: $('#fname').val()}, function (res_data) {}, 'json');
		}
	}
	function projectOnboardAdd(txtProj, shortname, loader, btn) {
		$('#txt_Proj_onboard').keyup();
		$('#err_msg_onboard').html('');
		$('#validate_onboard').val('1');
		var proj1 = "";
		proj1 = $('#' + txtProj).val();
		shortname1 = $('#' + shortname).val();
		var strURL = HTTP_ROOT;
		proj1 = proj1.trim();
		if (proj1 == "") {
			msg = "'Project Name' cannot be left blank!";
			$('#err_msg_onboard').show();
			$('#err_msg_onboard').html(msg);
			document.getElementById(txtProj).focus();
			return false;
			} else {
			if (proj1.match(/[~`<>,;\+\\]+/)) {
				msg = "'Project Name' only accept Alphabets, Numbers, Special Characters except(~, `, <, >, \\, +, ;, ,)!";
				$('#err_msg_onboard').show();
				$('#err_msg_onboard').html(msg);
				$('#' + txtProj).focus();
				return false;
			}
		}
		if (shortname1.trim() == "") {
			makeShortName(proj1.toString());
			msg = "'Project Short Name' cannot be left blank!";
			$('#err_msg_onboard').show();
			$('#err_msg_onboard').html(msg);
			document.getElementById(shortname).focus();
			return false;
			} else {
			var x = shortname1.substr(-1);
			var inValid = /[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$?\^\+\"\';:,`\s]+/;
			var t_test = inValid.test(shortname1.trim());
			if (t_test) {
				msg = "Special characters are not allowed for 'Project Short Name'!";
				$('#err_msg').show();
				$('#err_msg').html(msg);
				document.getElementById(shortname).focus();
				return false;
			}
			var done = 1;
			$('#err_msg_onboard').hide();
			document.getElementById(loader).style.display = 'block';
			$('#' + btn).hide();
			$.post(strURL + "projects/ajax_check_project_exists", {
				"name": escape(proj1),
				"shortname": escape(shortname1)
			}, function (data) {
				if (data.status == "Project") {
					$('#' + loader).hide();
					document.getElementById(btn).style.display = 'block';
					msg = "'Project Name' is already exists!";
					$('#err_msg_onboard').show();
					$('#err_msg_onboard').html(msg);
					document.getElementById(shortname).focus();
					return false;
				} else if (data.status == "ShortName") {
					$('#' + loader).hide();
					document.getElementById(btn).style.display = 'block';
					msg = "'Project Short Name - " + shortname1 + "' already exists!";
					$('#err_msg_onboard').show();
					$('#err_msg_onboard').html(msg);
					document.getElementById(shortname).focus();
					return false;
				} else {
					//changeStep(5);
					<?php if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")){
						if (!in_array($GLOBALS['user_subscription']['subscription_id'], array(11,13))) { $sub_sl_type = 'Paid'; }else{ $sub_sl_type = 'Free';}
					?>

					<?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
					/*smartlook('identify', '<?php echo $user["User"]["uniq_id"]; ?>', {
						"name": '<?php echo $user["User"]["name"]." ".$user["User"]["last_name"]; ?>',
						"email": '<?php echo $user["User"]["email"]; ?>',
						"package": '<?php echo $sub_sl_type; ?>',
						"currency": "USD",
						"cost": '<?php echo $GLOBALS['user_subscription']['subscription_id']; ?>'
					 }); */
				<?php }
				} ?>
					$.post("<?php echo HTTP_ROOT;?>projects/add_project",{'data[Project][name]':proj1,'data[Project][short_name]':escape(shortname1),'data[Project][validate]':1,'data[Project][project_methodology]':$('#projectmethodology').val(),'data[Project][status_group_id]':$('#projectworkflow').val()},function(res){
						if(res.status){
							//$("#pid").val(res.proj_id);
							window.location.reload();
						}else{
							$('#err_msg_onboard').show();
							$('#err_msg_onboard').html(res.status);
						}
					},'json');
					
				}
			});
		}
	}
	
	
	$(function () {
		$('#txt_Proj_onboard')
		.keyup(function (e) {
			var str = $(this).val();
			var str_temp = '';
			if (e.keyCode == 32 || e.keyCode == 8 || e.keyCode == 46) {
				makeShortName(str, 0);
			}else if(e.keyCode == 13){
				makeShortName(str, 0);
				setTimeout(function () {
					projectOnboardAdd('txt_Proj_onboard', 'txt_shortProj_onboard', 'loader_onboard', 'btn_onboard');
				}, 200);
			}
		})
		.change(function () {
		})
		.blur(function (e) {
			var str = $(this).val();
			makeShortName(str);
		});
	});
	function makeShortName(str) {
		var str_temp = '';
		str = str.trim();
		str_temp = str;
		if (str != '') {
			if ($('#txt_shortProj_onboard').val().trim().length >= 5) {
				return true;
			}
			if ($('#short_nm_prj_new').val() == 1) {
				if ($('#txt_Proj_onboard').length) {
					$('#txt_shortProj_onboard').val(chr);
				} else {
					$('#txt_shortProj').keyup();
				}
				return true;
			}
			str = str.replace(/\s{2,}/g, ' ');
			var spltStr = str.split(' ');
			var chr = '';
			var inValid = /[\-\=\~\!@#\%&\*\(\)_\+\\\/<>\?\{\}\.\$?\^\+\"\';:,`\s]+/;
			if (spltStr.length >= 2) {
				$.each(spltStr, function (index, value) {
					var t_chr = value.substr(0, 1);
					var t_test = inValid.test(t_chr);
					if (!t_test) {
						chr += t_chr;
						} else {
						var t_chr = value.substr(1, 1);
						var t_test = inValid.test(t_chr);
						if (!t_test) {
							chr += t_chr;
						}
					}
				});
				} else {
				var t_chr = str.substr(0, 1);
				var t_test = inValid.test(t_chr);
				if (!t_test) {
					chr = t_chr;
					} else {
					var t_chr = str.substr(1, 1);
					var t_test = inValid.test(t_chr);
					if (!t_test) {
						chr = t_chr;
					}
				}
			}
			chr = chr.toUpperCase();
			if ($('#txt_Proj_onboard').length) {
				$('#txt_shortProj_onboard').val(chr);
				} else {
				$('#txt_shortProj').val(chr).keydown();
			}
			} else {
			$('#short_nm_prj_new').val(0);
			if ($('#txt_Proj_onboard').length) {
				$('#txt_shortProj_onboard').val('');
				$('#txt_shortProj_onboard').attr('placeholder', 'MP');
				} else {
				$('#txt_shortProj').val('');
			}
		}
	}
	function selectProjectView(val){
		$(".pjlv").each(function(){
			var src = $(this).find('img').attr('src');
			src = src.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','').replace('-yes','');
			src = '<?php echo HTTP_ROOT; ?>img/'+src+'.png';
			$(this).find('img').attr('src',src);            
		});  
		var src1 = $('.pjlv-'+val).find('img').attr('src');
		src1 = src1.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','');
		src1 = '<?php echo HTTP_ROOT; ?>img/'+src1+'-yes.png';
		$('.pjlv-'+val).find('img').attr('src',src1);
		
		if(val == 'list'){
			$('#projectviewval').val('9');
			}else{
			$('#projectviewval').val('8');
		}
		$.post("<?php echo HTTP_ROOT; ?>/users/onBoard", {           
			"projectview": $("#projectviewval").val()
			}, function(dt) {
		});
	}
	function changeStep(step) {
		$(".steps").hide();
		if (step == 2) {
			checkprojects();
			if (SES_TYPE == '3') {
				showTopErrSucc('error', 'Oops! You are not authorized to add new Project. Please contact your account owner/admin.');
				$(".step-2").show();
				return false;
			}
			$(".step-" + step).show();
			}else if(step == 4){
			$('.proj_name_onboard').text('Simple Project');
			$('.proj_desc_onboard').text('Do more than just "manage" your project');
			var ptypid = $('#projectmethodology').val();
			var ptypsrc= 'spmm.png';
			if(ptypid == 2){
				$('.proj_name_onboard').text('Scrum');
				$('.proj_desc_onboard').text('Making software development more enjoyable and productive');
				ptypsrc = 'ssdd.png';
			}
			$('.name-your-proj').attr('src',HTTP_ROOT+'img/onboard/'+ptypsrc);			
			$(".step-4").show();
		}
		else{
			if(page_b != '' && step == 3){
				$('#projectmethodology').val(1);
				changeStep(4);
				}else{
				$(".step-" + step).show();
			}
		}
	}
	function selectProjectMethodology(val){
		$(".creat_proj").each(function(){
			var src = $(this).find('.imgptype').attr('src');
			src = src.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','').replace('-yes','');
			src = '<?php echo HTTP_ROOT; ?>img/'+src+'.png';
			$(this).find('img').attr('src',src);            
		});  
		var src1 = $('.creat_proj-'+val).find('img').attr('src');
		src1 = src1.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','');
		src1 = '<?php echo HTTP_ROOT; ?>img/'+src1+'-yes.png';
		$('.creat_proj-'+val).find('img').attr('src',src1);
		
		if(val == 'scrum'){
			$('#projectmethodology').val('2');
			$('#scrum-check').prop('checked',true);
			$('#simple-check').prop('checked',false);
			}else{
			$('#projectmethodology').val('1');
			$('#scrum-check').prop('checked',false);
			$('#simple-check').prop('checked',true);
		}
		$.post("<?php echo HTTP_ROOT; ?>/users/onBoard", {           
			"projectmethodology": $("#projectmethodology").val()
			}, function(dt) {
		});
	}
	function selectTaskView(val){        
		$(".tsklv").each(function(){
			var src = $(this).find('img').attr('src');
			src = src.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','').replace('-yes','');
			src = '<?php echo HTTP_ROOT; ?>img/'+src+'.png';
			$(this).find('img').attr('src',src);            
		});  
		var src1 = $('.tsklv-'+val).find('img').attr('src');
		src1 = src1.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','');
		src1 = '<?php echo HTTP_ROOT; ?>img/'+src1+'-yes.png';
		$('.tsklv-'+val).find('img').attr('src',src1);
		if(val == 'list'){
			$('#taskviewval').val('10');
			}else{
			$('#taskviewval').val('11');
		}
		$.post("<?php echo HTTP_ROOT; ?>/users/onBoard", {           
			"taskviewval": $("#taskviewval").val()
			}, function(dt) {
		});
	}
	function saveOnboardlang(){
		$.post("<?php echo HTTP_ROOT; ?>/users/saveUserData", {           
			"language": $("#onboard_lang").val()
			}, function(dt) {
			location.reload(); // added by PRB
		},'json');
	}
	function selectLangonBoard(val){        
		$(".langlv").each(function(){
			var src = $(this).find('img').attr('src');
			src = src.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','').replace('-yes','');
			src = '<?php echo HTTP_ROOT; ?>img/'+src+'.png';
			$(this).find('img').attr('src',src);            
		});  
		var src1 = $('.langlv-'+val).find('img').attr('src');
		src1 = src1.replace('<?php echo HTTP_ROOT; ?>img/','').replace('.png','');
		src1 = '<?php echo HTTP_ROOT; ?>img/'+src1+'-yes.png';
		$('.langlv-'+val).find('img').attr('src',src1);
		$.post("<?php echo HTTP_ROOT; ?>/users/saveUserData", {           
			"language": val
			}, function(dt) {
		},'json');
	}
	
	function memberCustomer(txtEmailid, selprj, loader, btn) {
		var email_id = $('#' + txtEmailid).val();
		var admin_email_id = $('#' + txtEmailid+'_admin').val();
		var email_arr = email_id.split(',');
		var role_id = $("#select_role").val();
		var done = 1;
		if (email_id == "" && admin_email_id == "") {
			self.location = "<?php echo HTTP_ROOT . 'dashboard' ?>";
			return false;
			} else {
			var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			
			if (admin_email_id != '' && (!admin_email_id.match(emlRegExpRFC) || admin_email_id.search(/\.\./) != -1)) {
				done = 0;
				msg = "Invalid Email: '" + admin_email_id + "'";
				$('#err_email_new').html('');
				$('#err_email_new').show();
				$('#err_email_new').html(msg);
				document.getElementById(txtEmailid+'_admin').focus();
				return false;
			}
			if (email_id != '' && (!email_id.match(emlRegExpRFC) || email_id.search(/\.\./) != -1)) {
				if (email_id.indexOf(',') != -1) {
					var totlalemails = 0;
					for (var i = 0; i < email_arr.length; i++) {
						if (email_arr[i].trim() != "") {
							if ((!email_arr[i].trim().match(emlRegExpRFC) || email_arr[i].trim().search(/\.\./) != -1)) {
								done = 0;
								msg = "Invalid Email: '" + email_arr[i] + "'";
								$('#err_email_new').html('');
								$('#err_email_new').show();
								$('#err_email_new').html(msg);
								document.getElementById(txtEmailid).focus();
								return false;
							}
							} else {
							totlalemails++;
						}
					}
					if (totlalemails == email_arr.length) {
						msg = "Entered stirng is not a valid email";
						$('#err_email_new').html("");
						$('#err_email_new').show();
						$('#err_email_new').html(msg);
						$('#' + txtEmailid).focus();
						return false;
					}
					} else {
					done = 0;
					msg = "Invalid E-Mail!";
					$('#err_email_new').html('');
					$('#err_email_new').show();
					$('#err_email_new').html(msg);
					document.getElementById(txtEmailid).focus();
					return false;
				}
			}
			if (done != 0) {
				var type = $('#sel_Typ').val();
				if (type == 2) {
					var usertype = "Admin";
					} else if (type == 3) {
					var usertype = "Member";
				}
				$('#err_email_new').hide();
				$("#ldr").show();
				$("#btn_addmem").hide();
				var uniq_id = $("#uniq_id").val();
				var strURL = HTTP_ROOT;
				if(admin_email_id){
					var new_email_id =(email_id)? email_id + ','+admin_email_id : admin_email_id ;
					}else{
					var new_email_id = email_id;
				}
				if (new_email_id.indexOf(',') != -1) {
					$.post(strURL + "users/ajax_check_user_exists", {
						"email": escape(new_email_id),
						"uniq_id": escape(uniq_id),
						"role_id":role_id
						}, function (data) {
						if (data == "success") {
							document.myform.submit();
							return true;
							} else {
							if (data == 'errorlimit') {
								$("#ldr").hide();
								$("#btn_addmem").show();
								$("#err_email_new").show();
								$("#err_email_new").html("Sorry! You are exceeding your user limit.");
								} else {
								$("#ldr").hide();
								$("#btn_addmem").show();
								$("#err_email_new").show();
								$("#err_email_new").html("Oops! Invitation already sent to '" + data + "'!");
							}
							return false;
						}
					});
					} else {                                                    
					$.post(strURL + "users/ajax_check_user_exists", {
						"email": escape(new_email_id),
						"uniq_id": escape(uniq_id),
						"role_id":role_id
						}, function (data) {
						if (data == "invited" || data == "exists" || data == "owner" || data == "account") {
							$("#ldr").hide();
							$("#btn_addmem").show();
							$("#err_email_new").show();
							if (data == "owner") {
								$("#err_email_new").html("Ah... you are inviting the company Owner!");
								} else if (data == "account") {
								$("#err_email_new").html("Ah... you are inviting yourself!");
								} else {
								$("#err_email_new").html("Oops! Invitation already sent to '" + new_email_id + "'!");
							}
							return false;
							} else {
							document.myform.submit();
							return true;
						}
					});
				}
			}
		}
		return false;
	}
</script>
<?php /*if(stristr($_SERVER['SERVER_NAME'],"payzilla.in")){?>
<!-- User panda start -->
<script type="text/javascript">
    (function(d, s, id) {
      var js, ljs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)){ return; }
      js = d.createElement(s); js.id = id;js.async = true;
      js.src = "http://app.userpanda.com/assets/js/userpanda.js";
      ljs.parentNode.insertBefore(js, ljs);
    }(document, 'script','5e86bf24ba689401409593c2')); 
</script> 
<!-- User panda end -->
<?php } */ ?>
<?php if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")){
	if (!in_array($GLOBALS['user_subscription']['subscription_id'], array(11,13))) { $sub_sl_type = 'Paid'; }else{ $sub_sl_type = 'Free';}
?>

<?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
<!--smart look start-->
<?php if(false){ ?>
<script type="text/javascript">
   /* window.smartlook||(function(d) {
    var o=smartlook=function(){ o.api.push(arguments)},h=d.getElementsByTagName('head')[0];
    var c=d.createElement('script');o.api=new Array();c.async=true;c.type='text/javascript';
    c.charset='utf-8';c.src='https://rec.smartlook.com/recorder.js';h.appendChild(c);
    })(document);
    smartlook('init', '2624cfbeeb7f762fbbaabaf8f443539bc2e00da1'); */
</script>

<?php } ?>
<!--smart look end -->
<script>
	/*$(window).load(function() {
		setTimeout(function() {
			smartlook('identify', '<?php echo $user["User"]["uniq_id"]; ?>', {
				"name": '<?php echo $user["User"]["name"]." ".$user["User"]["last_name"]; ?>',
				"email": '<?php echo $user["User"]["email"]; ?>',
				"package": '<?php echo $sub_sl_type; ?>',
				"currency": "USD",
				"cost": '<?php echo $GLOBALS['user_subscription']['subscription_id']; ?>'
			});
		}, 1000);
	});*/
</script>
<!-- User panda start -->
<?php /*
<script type="text/javascript">
(function(d, s, id) {
	var js, ljs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)){ return; }
	js = d.createElement(s); js.id = id;js.async = true;
	js.src = "https://www.userpanda.com/js/userpanda.js";
	ljs.parentNode.insertBefore(js, ljs);
}(document, 'script','210d21444f82c2b048d2cd570eba9ef2')); 
</script> 
*/?>

<?php //if(isset($_COOKIE['FIRST_INVITE_2']) && !empty($_COOKIE['FIRST_INVITE_2']) || (isset($this->request->query['first_login']) && !empty($this->request->query['first_login']))){ ?>
<script>
	$(window).load(function() {
		setTimeout(function() {	
				console.log('inside....');
				<?php if(stristr($_SERVER['SERVER_NAME'],"payzilla.in")){ ?>
				// userpanda_customevents('Account Created',{"refrer": 'Sign up'});
				<?php } ?>
				<?php if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")){ ?>					
					smartlook('identify', '<?php echo $user["User"]["uniq_id"]; ?>', {
						"name": '<?php echo $user["User"]["name"]." ".$user["User"]["last_name"]; ?>',
						"email": '<?php echo $user["User"]["email"]; ?>',
						"package": '<?php echo $sub_sl_type; ?>',
						"currency": "USD",
						"price": '<?php echo $GLOBALS["user_subscription"]["subscription_id"]; ?>'
					}); 
				/*userpath_mapusers('<?php echo $user["User"]["email"]; ?>', {
					"email": '<?php echo $user["User"]["email"]; ?>',
					"first_name": '<?php echo $user["User"]["name"]; ?>',
					"last_name": '<?php echo $user["User"]["last_name"]; ?>',
					"plan": '<?php echo $sub_sl_type; ?>',    
					"price": '$<?php echo $GLOBALS["user_subscription"]["subscription_id"]; ?>',
					"is_signup": 1		
				});*/
				<?php } ?>
			
		}, 1000);
	});
</script>
<?php //} ?>
<!-- User panda end -->
<?php } ?>
<?php } ?>