<?php 
$chat_active = 0;
$free_user_chat_hide = 0;
$settings_arr = array('mycompany','groupupdatealerts','importexport','task_type','labels','settings','task_settings','resource_settings','resource_utilization','pricing','creditcard','transaction','subscription','profile','changepassword','email_notifications','email_reports','default_view','getting_started','get_mobile_device');
if(defined('RELEASE_V') && RELEASE_V){ ?>
<?php if(isset($_COOKIE['FIRST_INVITE_1']) && $_COOKIE['FIRST_INVITE_1']==1 && PAGE_NAME=='dashboard'){?>
<div class="onboard_indicate_popup onboardPop">
    <h6><?php echo __('Task Management');?></h6>
    <p><?php echo __('Create and assign tasks to collaborate & initiate project execution');?>!</p>
    <div style="margin-top: 30px;">
        <a href="javascript:void(0)" class="skip" onclick="removeOnboard();"><?php echo __('Done? Click here to skip');?></a>
        <a href="javascript:void(0)" class="next" onclick="nextOnboard('onboard_indicate_popup_timelog');" ><?php echo __('Next');?></a>
        <div class="cb"></div>
    </div>
</div>
<div class="onboard_indicate_popup_timelog onboardPop" style="display:none;">
    <h6><?php echo __('Time Tracking');?></h6>
    <p><?php echo __('Log spent hours against your tasks & let all project members know of the progress');?>!</p>
    <div style="margin-top: 30px;">
        <a href="javascript:void(0)" class="skip" onclick="removeOnboard();"><?php echo __('Done? Click here to skip');?></a>
        <a href="javascript:void(0)" class="next" onclick="nextOnboard('onboard_indicate_popup_invoice');" ><?php echo __('Next');?></a>
        <div class="cb"></div>
    </div>
</div>
<div class="onboard_indicate_popup_invoice onboardPop" style="display:none;">
    <h6><?php echo __('Invoice');?></h6>
    <p><?php echo __('Generate professional invoices from your unbilled times for your Clients');?>!</p>
    <div style="margin-top: 30px;">
        <a href="javascript:void(0)" class="skip" onclick="removeOnboard();"><?php echo __('Done? Click here to skip');?></a>
        <a href="javascript:void(0)" class="next" onclick="removeOnboard();" ><?php echo __('Got It');?></a>
        <div class="cb"></div>
    </div>
</div>
<?php } ?>
<div class="timer-div">
             <div class="timer-header" onclick="expandTimer()" id="tour_timer_header">
                 <div class="timer-sec">
                     <span class="timer-minus-btn" rel="tooltip" title="<?php echo __('Substract 10mins');?>" onclick="minus10(event);" style="display:none;"><i class="material-icons">&#xE15B;</i></span>
                     <span class="timer-time"></span>
                     <span class="timer-plus-btn" rel="tooltip" title="<?php echo __('Add 10mins');?>" onclick="plus10(event);" style="display:none;"><i class="material-icons">&#xE145;</i></span>
                     <span class="timer-pause-btn" onclick="pauseTimer(event)" rel="tooltip" title="<?php echo __('Pause Timer');?>"><i class="material-icons">&#xE034;</i></span>
                     <span class="timer-play-btn" onclick="resumeTimer(event)" rel="tooltip" title="<?php echo __('Play Timer');?>" style="display:none"><i class="material-icons">&#xE037;</i></span>
                 </div>
                 <span class="tsk-title" style="display: none"></span>
                 <i class="material-icons open-activity up">&#xE316;</i>
             </div>
             <div class="timer-detail pr">
                 <div class="timer-detail-top">
                 <input type="hidden" id="timer_hidden_tsk_id" />
                 <input type="hidden" id="timer_hidden_tsk_uniq_id" />
                 <input type="hidden" id="timer_hidden_proj_id" />
                    <input type="hidden" id="timer_hidden_proj_nm" />
                 <input type="hidden" id="timer_hidden_duration" />
                    <div class="control-group">
						<label class="timer-proj-lable"><?php echo __('Project');?></label>
                        <select id="select-timer-proj" placeholder="<?php echo __('Select a Project');?>"></select>
                    </div>
                    <div class="control-group">
						<label class="timer-proj-lable"><?php echo __('Task');?></label>
                        <select id="select-timer-task" placeholder="<?php echo __('Select a Task');?>" ></select>
                    </div>
                    <?php /* <span class="tsk-span">Task: </span><span class="tsk-ttl ellipsis-view"></span><div class="cb"></div> */ ?>
                 <div class="form-group form-group-lg label-floating timer-desc">
                       <label class="control-label" for="timerdesc"><?php echo __('Note');?></label>
                       <input class="form-control" data-dynamic-opts=true id="timerdesc" onkeyup="setDescription()"/>
                </div>
                 <div class="checkbox custom-checkbox">
                     <label>
                         <input type="checkbox" id="timer_is_billable" checked="checked"/><?php echo __('Is Billable');?>?
                     </label>
                 </div>
                 <div class="cb"></div>
                 </div>
                 <div class="timer-detail-bottom">
                    <div class="popup-btn fr mright5">
                     <span class="cancel-link" id="cancel-timer-btn"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="stopTimer();"><?php echo __('Cancel');?></button></span>
                     <span class="hover-pop-btn" id="save-tm-span"><a href="javascript:void(0)" id="save_timer_btn" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick ="saveTimer()"><?php echo __('Save');?></a></span>
                        <span class="hover-pop-btn" id="start-tm-span" style="display:none"><a href="javascript:void(0)" id="start_timer_btn" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick ="startTaskTimer()"><?php echo __('Start Timer');?></a></span>
                     <span style="display:none;margin-right:20px;" id="timerquickloading">
                         <img alt="Loading..." title="<?php echo __('Loading');?>..." src="<?php echo HTTP_ROOT;?>img/images/case_loader2.gif">
                     </span>
                     <div class="cb"></div>
                 </div>
                    <div class="cb"></div>
             </div>
         </div>
         </div>
        
<div class="sticky_footer">
	<footer class="common-footer" <?php if(PAGE_NAME == "updates" || PAGE_NAME == "help" || PAGE_NAME == "tour" || PAGE_NAME == "customer_support"){ ?>style="padding-left:0px;"<?php } ?>>
		<div class="col-lg-12">
			<?php /* if(SES_TYPE == 1 && !in_array(PAGE_NAME,array('subscription','pricing','downgrade','upgrade_member','confirmationPage'))) { ?>
				<div class="refer_friend_click_btn" onclick="referAFriend();">Refer a Friend <span class="close_referal">X</span></div>
				<div class="circle_refer_friend" title="Refer a Friend"><span class="glyphicon glyphicon-bullhorn"></span></div>
			<?php } */ ?>
			<div class="row footer_wrapper">
				<div class="col-lg-4 text-left cmn_foot_cont" id="csTotalHours" style="padding:0px;">
				</div>
				<div class="col-lg-4  text-center cmn_foot_cont">
                    <?php echo $this->element('need_help');?>	
				</div>
                                
				<div class="col-lg-4 text-right cmn_foot_cont" id="projectaccess">
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		 <div class="clearfix"></div>
		 <?php if(PAGE_NAME != "customer_support" && PAGE_NAME != 'help' && CONTROLLER != 'ganttchart') { ?>
        <div class="all-activities" style="display:none;">
            <div class="activity-txt" data-backdrop="false" data-toggle="modal" data-target="#helpvideo" onclick="trackEventLeadTracker('Footer Right','Help & Support','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"> 
                <h5><?php echo __('Help & Support');?></h5>
                <i class="material-icons open-activity up">&#xE316;</i>
            </div>
        </div>
		 <?php } ?>
        <?php if(!$free_user_chat_hide && (((SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320) && $chat_active == 1) || ($this->Format->isChatOn(1) && $chat_active == 1 && $GLOBALS['user_subscription']['user_limit'] >= 15 || $GLOBALS['user_subscription']['user_limit'] == 'Unlimited'))){?>         
				<?php if($chat_active == 1){ ?>
        <!-- Chat button -->
         <!-- <div class="chat_btn_btm">         
            <div class="os_plus">    
                <div class="ctask_ttip"><span class="label label-default"><?php echo __('Start Conversation');?></span></div>     
                <a href="javascript:void(0)" onclick="chatStart();trackEventLeadTracker('Footer Right','Chat Icon','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0B7;</i></a>         
            </div>
         </div> -->
        <span class="chat-count-min"></span>
        <!-- End of chat button -->
				<?php } ?>
        <?php }else{
            if(SES_TYPE == 1 && ($this->Format->isChatOn(2))){?>
        <!-- Chat button -->
         <!-- <div class="chat_btn_btm">         
            <div class="os_plus">    
                <div class="ctask_ttip"><span class="label label-default">Start Conversation</span></div>     
                <a href="javascript:void(0)" onclick="showUpgradPopup(0,1,2);trackEventLeadTracker('Footer Right','Chat Icon','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><i class="material-icons">&#xE0B7;</i></a>         
            </div>
         </div> -->
        <!-- End of chat button -->
        <?php }
        }?>
	</footer>
</div>
<script type="text/template" id="ajax_list_view_tmpl">
<?php echo $this->element('manage_grid_tmpl'); ?>
</script>
<script type="text/template" id="case_customfield_tmpl">
<?php echo $this->element('case_customfield_add'); ?>
</script>
<script type="text/javascript">
	var is_change_reason_set = "<?php if($this->Format->isAllowed('Change Due Date Reason',$roleAccess)){ ?>1<?php }else{ ?>0<?php } ?>";
    var selectedColumns ="<?php echo $defaultfields['TaskField']['form_fields'];?>";
    var selectedColumnsProject ="<?php echo $defaultfields['TaskField']['project_form_fields'];?>";
    var bugSelectedColumns = "<?php echo $defaultdefectfields['DefectField']['form_fields'];?>";
    $(document).ready(function(){
				//set the change reason 
				localStorage.setItem("is_change_reason_set", is_change_reason_set);

        /* show hide fields */
        var selectedColumnsarr = selectedColumns.split(","); 
        $('.task-field-all').hide();        
        for(var i = 0; i < selectedColumnsarr.length; i++){
             $(".task-field-"+selectedColumnsarr[i]).show();
        }
		// for create bug popup
		var bugSelectedColumnsarr = bugSelectedColumns.split(",");
		$('.bug-field-all').hide();
		$('.edit-bug-field-all').hide();
		for(var i = 0; i < bugSelectedColumnsarr.length; i++){
             $(".bug-field-"+bugSelectedColumnsarr[i]).show();
			 $(".bug-edit-field-"+bugSelectedColumnsarr[i]).show();
        }


        var selectedColumnsarrProject = selectedColumnsProject.split(","); 
        $('.project-field-all').hide();        
        for(var i = 0; i < selectedColumnsarrProject.length; i++){
             $(".project-field-"+selectedColumnsarrProject[i]).show();
        }
        /* End */

        $('.select-timer-proj').selectize();
        $('.select-timer-task').selectize();
		if(localStorage.getItem("RaF") == 1){
			$('.circle_refer_friend').show();
            $('.refer_friend_click_btn').hide();
		}else{
			$('.circle_refer_friend').hide();
            $('.refer_friend_click_btn').show();
		}		
		$('.circle_refer_friend').on('click',function(){
            $(this).show();
            $('.refer_friend_click_btn').hide();			
			//localStorage.setItem("RaF", 0);
			referAFriend();
			trackEventLeadTracker('RaF Button','Refer a Friend','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');
    });
		$('.refer_friend_click_btn').on('click',function(){
            $(this).hide();
            $('.circle_refer_friend').show();			
			localStorage.setItem("RaF", 1);
			referAFriend();
			trackEventLeadTracker('RaF Button','Refer a Friend','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');
        });
		$('.close_referal').on('click',function(e){
			e.stopPropagation();
			e.preventDefault();
			localStorage.setItem("RaF", 1);
			$('.circle_refer_friend').show();
            $('.refer_friend_click_btn').hide();
		});
    });
</script>
<?php } ?>
<!-- Footer ends --> 
<?php if(CONTROLLER == 'easycases' && PAGE_NAME == 'dashboard'){?>
<?php /*<div id="widgethideshow" class="fix_btm" <?php if(strtotime("+2 months",strtotime(CMP_CREATED))>=time()){?>style="right: 0px;"<?php }?>>
	<section id="widgets-container" class="widget_section" style="border:0px solid #FF0000;">
		<span id="ajaxCaseStatus"></span>
	</section>
	<section id="widgets-containertype" style="display:none">
		<span id="ajaxCaseType" style="display:none"></span>
	</section>
</div>*/ ?>
<?php
 }else{?>
<?php if(strtotime("+2 months",strtotime(CMP_CREATED))>=time()){?>
<!--<div ng-click="showHelp = true" onclick="return showhelp();" title="Click for help" class="need-help no-select animated shake" ng-show="showNeedHelpTab" style="">Need help getting started?</div>-->
<?php } }
?>
<!--<div class="fix_btm need_help">This is footer</div>-->
<script type="text/javascript">
<?php /*?>JS VARs from footer_inner<?php */?>
var HTTP_ROOT = '<?php echo HTTP_ROOT; ?>'; //pageurl
var HTTP_HOME = '<?php echo HTTPS_HOME; ?>'; //pageurl
var HTTP_IMAGES = '<?php echo HTTP_IMAGES; ?>'; //hid_http_images
var MAX_FILE_SIZE = '<?php echo MAX_FILE_SIZE; ?>'; //fmaxilesize
var SES_ID = '<?php echo SES_ID; ?>'; //pub_show
var SES_TYPE = '<?php echo SES_TYPE; ?>';
<?php $GLOBALS['TYPE'] = array_filter($GLOBALS['TYPE']); ?>;
var GLOBALS_TYPE = <?php echo json_encode($GLOBALS['TYPE']); ?>;
var DESK_NOTIFY = <?php echo (int)DESK_NOTIFY; ?>;
var CONTROLLER = '<?php echo CONTROLLER; ?>';
var PAGE_NAME = '<?php echo PAGE_NAME; ?>';
var ARC_CASE_PAGE_LIMIT = 10;
var ARC_FILE_PAGE_LIMIT = 10;
var PUSERS = <?php echo json_encode($GLOBALS['projUser']); ?>;
var ACUSERS = <?php echo json_encode($GLOBALS['AllCompUser']); ?>;
var PROJECTS = <?php echo json_encode($GLOBALS['getallproj']); ?>;
var PROJECTS_ID_MAP = <?php echo json_encode($GLOBALS['project_id_map']); ?>;
var defaultAssign = '<?php echo $defaultAssign; ?>';
var dassign;
var TASKTMPL = <?php echo json_encode($GLOBALS['getTmpl']); ?>;
var SITENAME = '<?php echo SITE_NAME; ?>';
var DEFAULT_TASKVIEW = '<?php echo DEFAULT_TASKVIEW; ?>';
var DEFAULT_KANBANVIEW = '<?php echo DEFAULT_KANBANVIEW; ?>';
var DEFAULT_TIMELOGVIEW = '<?php echo DEFAULT_TIMELOGVIEW; ?>';
var DEFAULT_PROJECTVIEW = '<?php echo DEFAULT_PROJECTVIEW; ?>';
var DEFAULT_VIEW_TASK = '<?php echo DEFAULT_VIEW_TASK; ?>';
var DEFAULT_VIEW_VALUE = '<?php echo DEFAULT_VIEW_VALUE; ?>';
var DEFECTCLOSE = <?php echo DEFECTCLOSE; ?>;
var DEFECTBUG = <?php echo DEFECTBUG; ?>;
var DEFAULT_PAID = '<?php echo SES_COMP; ?>';
var CMP_ARABK = '<?php echo SES_COMP; ?>';
var SHOW_ARABK = '<?php echo SHOW_ARABIC; ?>';
var EDIT_TASK = 1;//'<?php //echo $edit_task; ?>';
var EXPIRED_PLAN = '<?php echo CURRENT_EXPIRED_PLAN; ?>';
var USER_SUB_NOW = '<?php echo $GLOBALS['user_subscription']['subscription_id']; ?>';
var NODEJS_HOST = '<?php echo NODEJS_HOST_CHAT; ?>';
var NODEJS_SECURE = '<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?"true":"true"; ?>';
var COMPANY_WORK_HOUR = '<?php echo $GLOBALS['company_work_hour'] ?>';
var COMPANY_WEEK_ENDS = '<?php echo $GLOBALS['company_week_ends'] ?>';
var COMPANY_HOLIDAY = '<?php echo $GLOBALS['company_holiday'] ?>';
var LANG_PREFIX = '<?php echo LANG_PREFIX; ?>';
var SES_TIME_FORMAT = '<?php echo SES_TIME_FORMAT; ?>';
var roleAccess = <?php echo json_encode($roleAccess); ?>;
var METHODOLOGY = '<?php echo $_SESSION['project_methodology']; ?>';
var ALLMETHODOLOGY = <?php echo json_encode(Cache::read('allTemplate')); ?> ;

var TOTAL_PROJECT = "<?php echo ((!$user_subscription['is_free']) && ($user_subscription['project_limit'] != "Unlimited"))?$this->Format->checkProjLimit($user_subscription['project_limit']):''; ?>";
var PROJECT_LIMIT = "<?php echo $user_subscription['project_limit'];?>";
var CMP_CREATED = "<?php echo CMP_CREATED;?>";

var COMP_LAYOUT = "<?php echo (defined('COMP_LAYOUT') && COMP_LAYOUT)?COMP_LAYOUT:0;?>";
var KEEP_HOVER_EFFECT = "<?php echo (isset($_SESSION['KEEP_HOVER_EFFECT']) && $_SESSION['KEEP_HOVER_EFFECT'])?$_SESSION['KEEP_HOVER_EFFECT']:0;?>";

var IS_PER_USER = "<?php echo (defined('IS_PER_USER') && IS_PER_USER)?IS_PER_USER:0;?>";
var GCAPTCH_KEY = "<?php echo (defined('GCAPTCH_KEY') && GCAPTCH_KEY)?GCAPTCH_KEY:0;?>";

var DEFAULT_TASK_TYPES = {"bug":"&#xE60E;","enh":"&#xE01D;","cr":"&#xE873;","dev":"&#xE1B0;","idea":"&#xE90F;","mnt":"&#xE869;","oth":"&#xE892;","qa":"Q","rel":"&#xE031;","rnd":"&#xE8FA;","unt":"&#xE3E8;","upd":"&#xE923;"};
var DEFAULT_THEME_COLOR = 'amber';
var bxslid = null;
var bxslid1 = null;
var TLUSER = null;
<?php /*?><?php
$curdate = gmdate("Y-m-d H:i:s");
$userDate = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$curdate,"datetime");
?>
var USERDATE = '<?php echo $userDate; ?>';
var CURDAY = '<?php echo date('D',strtotime($userDate)); ?>';
var FRIDAY = '<?php echo date('Y-m-d',strtotime($userDate."next Friday")); ?>';
var MONDAY = '<?php echo date('Y-m-d',strtotime($userDate."next Monday")); ?>';
var TOMORROW = '<?php echo date('Y-m-d',strtotime($userDate."+1 day")); ?>';<?php */?>
var TITLE_DLYUPD = '<?php echo "Daily Update - ".date("m/d"); ?>';
var RELEASE = '<?php echo RELEASE;?>';
var CompWorkHR = <?php echo $GLOBALS['company_work_hour'] == '' ? 8 : $GLOBALS['company_work_hour']; ?>;
</script>

<?php
    if(defined('RELEASE_V') && RELEASE_V){ 
	/* if(PAGE_NAME=='resource_availability'){
	 
	 $js_files = array( 'bootstrap_new.min.js', 'material.min.js','jquery.dropdown.js','ripples.min.js'); //echo $this->Html->script($js_files,array('defer')); 
     }else{
	 $js_files = array( 'bootstrap.min.js', 'material.min.js','jquery.dropdown.js','ripples.min.js'); //echo $this->Html->script($js_files,array('defer')); 
	 } */  
        $js_files = array( 'bootstrap.min.js', 'material.min.js','jquery.dropdown.js','ripples.min.js'); //echo $this->Html->script($js_files,array('defer')); 
   ?>
        <?php /* if(PAGE_NAME=='resource_availability'){ ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap_new.min.js" defer></script>
		<?php }else{ */?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap.min.js" defer></script>
		<?php// } ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>material.min.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.dropdown.js?v=<?php echo RELEASE; ?>" defer></script>
			<?php // if(CONTROLLER == 'Defects') { ?>
			<script type="text/javascript" src="<?php echo JS_PATH; ?>defect.js" defer="defer"></script>
			<?php // } ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>ripples.min.js" defer></script>
        <?php if(PAGE_NAME == "dashboard"){ ?>
             <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.contextMenu.min.js" defer></script>
         <?php } ?>       
        <script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.mask.min.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>selectize.min.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>angular_select.js?v=1" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>moment.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>xeditable.min.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap-datetimepicker.min.js" defer></script>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>select2.min.js" defer></script>
    <?php }else{
	//Bootstrap core JavaScript
	 if(PAGE_NAME =='resource_availability'){	
	     
	// $js_files = array( 'bootstrap_new.min.js', 'modernizer.js');
     }else{
	//	$js_files = array( 'bootstrap.min.js', 'modernizer.js');
	 }
	$js_files = array( 'bootstrap.min.js', 'modernizer.js');
	echo $this->Html->script($js_files,array('defer'));
    }
?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>os_core.js?v=<?php echo RELEASE; ?>" defer></script>

<?php if((CONTROLLER == 'templates') || (CONTROLLER == 'easycases' && (PAGE_NAME == "mydashboard" || PAGE_NAME == "dashboard"))){ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-ui-1.10.3.js" defer></script>
<?php }else{ 
    if((CONTROLLER != 'easycases' && PAGE_NAME != "dashboard" && PAGE_NAME != "manage_status" && PAGE_NAME !="bookmarksList" && trim(PAGE_NAME) !="custom_field")){?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery-ui-1.9.2.custom.min.js" defer></script>
<?php } }?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>script_v1.js?v=<?php echo RELEASE; ?>" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>easycase_new.js?v=<?php echo RELEASE; ?>" defer></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.tipsy.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.lazyload.min.js" defer></script>
<?php /*<script type="text/javascript" src="<?php echo JS_PATH; ?>tinymce/jquery.tinymce.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>tinymce/tiny_mce.js" defer></script>*/?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>adv-tinymce/tinymce/tinymce.min.js" defer></script>

<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.fcbkcomplete.js" defer></script>
<?php if(CONTROLLER == 'Ganttchart'){ ?>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.ganttView.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery-ui-1.10.3.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>date.js"></script>
<?php } ?>
 <?php if(!in_array(SES_COMP,Configure::read('REMOVE_DROPBOX_GDRIVE'))){ ?>
<!-- Dropbox starts-->
<?php if(defined('USE_LOCAL') && USE_LOCAL==1) {?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>dropins.js" id="dropboxjs" data-app-key="<?php echo DROPBOX_KEY;?>" defer></script>
<?php } else {?>
<script type="text/javascript" src="https://www.dropbox.com/static/api/1/dropins.js" id="dropboxjs" data-app-key="<?php echo DROPBOX_KEY;?>" defer></script>
<?php }?>
<!-- Dropbox ends-->
<?php } ?> 
<!-- Google drive starts-->
<script type="text/javascript">
    var CLIENT_ID = "<?php echo CLIENT_ID; ?>";
		var appId = "<?php echo CLIENT_ID_NUM; ?>";
    var REDIRECT = "<?php echo REDIRECT_URI; ?>";
    var API_KEY = "<?php echo API_KEY; ?>";
    var DOMAIN_COOKIE = "<?php echo DOMAIN_COOKIE; ?>";
</script>
<?php if(!in_array(SES_COMP,Configure::read('REMOVE_DROPBOX_GDRIVE'))){ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>google_drive_v1_new.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>google_contact.js" defer></script>
<?php if(defined('USE_LOCAL') && USE_LOCAL==1) {?>
    <!--<script src="<?php echo JS_PATH; ?>jsapi.js" defer></script>
    <script src="<?php echo JS_PATH; ?>client.js" defer></script> FOR LOCAL -->
<?php } else {?>
	<?php /*<script src="https://www.google.com/jsapi?key=<?php echo API_KEY; ?>" defer></script>
	<script src="https://apis.google.com/js/client.js" defer></script>*/ ?>
<script type="text/javascript" src="https://apis.google.com/js/api.js" defer></script>
<?php }?>
<?php }?>
<!-- Google drive ends-->

<script type="text/javascript" src="<?php echo JS_PATH; ?>fileupload.js?v=<?php echo RELEASE; ?>" defer></script>

<?php //if(PAGE_NAME == "dashboard"){ ?>

<script type="text/javascript">
$(document).ready(function(){
        $("#notify_lang_pop").select2();
	var pjuniq=$('#projFil').val();
        /** Call to new RequestsController function as per optimization process */
	var url = "<?php echo HTTP_ROOT?>requests/ajax_case_menu";
	loadCaseMenu(url,{"projUniq":pjuniq,"pageload":1,"page":"<?php echo PAGE_NAME; ?>","filters":"<?php echo $filters; ?>","case":"<?php echo $caseunid; ?>"}, 1);
});
var client = 0;
</script>

<?php if(defined('NODEJS_HOST') && trim(NODEJS_HOST)){ ?>
<script src="<?php echo NODEJS_HOST_CHAT; ?>/socket.io/socket.io.js"></script>
<script src="<?php echo JS_PATH; ?>jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.dialogextend.min.js" defer></script>
<script type="text/javascript">
var client = null;
var chat_client = null; 
var chat_client_login; 
subscribeClient();
function subscribeClient(){
	var prjuniqid = $("#CS_project_id").val();
	if(client && prjuniqid!='all'){
		client.emit('subscribeTo', { channel: prjuniqid });
		return;
	}
	var alltasks = new Array();
	try{
		client = io.connect('<?php echo NODEJS_HOST; ?>',{secure: <?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?"true":"false"; ?>});
		console.log(client);
		client.on('connect',function (data) {
			var prjuniqid = $("#CS_project_id").val();
			console.log('Joining client to: '+prjuniqid);
			if(prjuniqid!='all'){
				client.emit('subscribeTo', { channel: prjuniqid });
			}
		});
	
	
		client.on('iotoclient', function (data) {
			var message = data.message; //alert(message+'8888888888');
                        if(message.indexOf("~~") >= 0){
			var session_id = message.split('~~')[1];
			var msg = message.split('~~')[0];
			var caseNum = message.split('~~')[2];
			var caseTyp = message.split('~~')[3];
			var caseTtl = message.split('~~')[4];
			var projShName =  message.split('~~')[5];
			//var show_pub = $("#pub_show").val();
			
			console.log('Socket Running \n');
			
			if(session_id != SES_ID)      
			{
				console.log('Socket Message \n');
				
				var counter =$("#pub_counter").val();
				var casenumHid = $("#hid_casenum").val();
				if(casenumHid == '0') {
					alltasks = [];
				}
				
				//var index = alltasks.indexOf(caseNum);
				var index = $.inArray(caseNum, alltasks);
				
				if(index == -1) { //if the case number is not present
					alltasks.push(caseNum);
					$("#hid_casenum").val(alltasks);
					counter ++;
				} 
				
				if(counter == 1) {
					var tsk = "Task";
				} else {
					var tsk = "Tasks";
				}
				$("#punnubdiv").show();
				$("#pub_counter").val(counter);
				$('#pubnub_notf').html(counter+' '+ tsk +' '+msg);
				$("#pubnub_notf").slideDown("1000");
				setTimeout('removePubnubMsg()',3000);
				//if (window.webkitNotifications) {
				notify(getImNotifyMsg(projShName, caseNum, caseTtl, caseTyp),'Orangescrum.com');
				//}
			}
                    }	
		});
	} catch(e){ console.log('Socket ERROR\n'); console.log(e); }
    <?php if(SES_COMP==1 && $chat_active == 1){ ?>
        /// Chat logic
        if(chat_client){
            chat_client.emit('subscribeToChat', { channel: <?php echo SES_COMP;?> });
            return;
        }
        try{
		chat_client = io.connect('<?php echo NODEJS_HOST_CHAT; ?>',{secure: <?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')?"true":"false"; ?>});
                 /*******delivery *********
                var delivery = new Delivery(chat_client);
                delivery.on('receive.start',function(fileUID){
                  console.log('receiving a file!');
                });
                delivery.on('receive.success',function(file){
                    console.log(file);
//                          if (file.isImage()) {
//                            $('img').attr('src', file.dataURL());
//                          };
                });
                /*********End of delivery *****/
		
                chat_client.on('connect',function (data) {
			chat_client.emit('subscribeToChat', { channel: '<?php echo SES_COMP;?>'});                       
                       
		});   
                
		chat_client.on('iotoclientchat', function (data) {
				console.log(data);
                    $arr=JSON.parse(data['message']);                    
                        if($arr['Oschat']['user_id'] != "<?php echo SES_ID; ?>"){ 
                            if($arr['Oschat']['receiver_id'] == "<?php echo SES_ID; ?>"){
                                showChat($arr);
                            }else if($arr['Oschat']['chat_group_id'] != '' && typeof ($arr['Oschat']['group_receiver_id']) != "undefined"){
                            split_str = $arr['Oschat']['group_receiver_id'].split(",");
                            if (split_str.indexOf("<?php echo SES_ID; ?>") !== -1) { //|| ("#og"+$arr['Oschat']['chat_group_id']).length > 0
                                console.log(split_str);
                                 showChat($arr);
                            }
                            }
                    }
		});
                
                chat_client.on('iotoclientlogout', function (data) { console.log(data);
                    showOnlines();
		});
		
	} catch(e){ console.log('Socket ERROR\n'); console.log(e); }
<?php } ?>
}
</script>
<?php } else { ?>
<script type="text/javascript">
	function subscribeClient(){}
</script>
<?php } ?>

<?php //}?>
<?php if(SES_COMP==1  && $chat_active == 1){?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>chat_helper.js?v=<?php echo RELEASE; ?>"></script>
<?php } ?>
<?php 
if(CONTROLLER == "templates" && (PAGE_NAME == "tasks" || PAGE_NAME == "projects")){
?>
<script type="text/javascript">
	$(document).ready(function(){
		/*$('#desc').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo HTTP_ROOT; ?>js/tinymce/tiny_mce.js',
			theme : "advanced",
			plugins : "paste, directionality, lists, advlist",
			theme_advanced_buttons1 : "bold,italic,strikethrough,underline,|,numlist,bullist,|,indent,outdent",
			theme_advanced_resizing : false,
			theme_advanced_statusbar_location : "",
			paste_text_sticky : true,
			gecko_spellcheck : true,
			paste_text_sticky_default : true,
			forced_root_block : false,
			width : "650px",
			height : "100px",
		});
		$('#desc_edit').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo HTTP_ROOT; ?>js/tinymce/tiny_mce.js',
			theme : "advanced",
			plugins : "paste, directionality, lists, advlist",
			theme_advanced_buttons1 : "bold,italic,strikethrough,underline,|,numlist,bullist,|,indent,outdent",
			theme_advanced_resizing : false,
			theme_advanced_statusbar_location : "",
			paste_text_sticky : true,
			gecko_spellcheck : true,
			paste_text_sticky_default : true,
			forced_root_block : false,
			width : "650px",
			height : "100px",
		});*/
		
			/*if (typeof(tinymce) != "undefined") {
				//tinymce.execCommand('mceRemoveControl', true, 'proj_notes');
				tinymce.remove('#proj_notes');
			}*/
			tinymce.init({
				selector: "#desc",
				plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize imagetools help',
				menubar: false,
				branding: false,
				statusbar: false,
				toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor fullscreen',
				toolbar_sticky: true,
				/*autosave_ask_before_unload: true,
				autosave_interval: "30s",
				autosave_restore_when_empty: false,
				autosave_retention: "2m",*/
				importcss_append: true,
				image_caption: true,
				browser_spellcheck: true,
				quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
				//directionality: dir_tiny,
				toolbar_drawer: 'sliding',
				contextmenu: "link",
				resize: false, 
				min_height: 130,
				max_height: 400,
				paste_data_images: false,
				paste_as_text: true,
				autoresize_on_init: true,
				autoresize_bottom_margin: 20,
				content_css: HTTP_ROOT+'css/tinymce.css',
				setup: function(ed) {
					ed.on('Click',function(ed, e) {});
					ed.on('KeyUp',function(ed, e) {
						//var inpt = tinymce.activeEditor.getContent().trim();
					});
					ed.on('Change',function(ed, e) {
						//console.log('Change here');
						//var inpt = tinymce.activeEditor.getContent().trim();
					});
					ed.on('init', function(e) {
					});
				}
			});
			
			tinymce.init({
				selector: "#desc_edit",
				plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize imagetools help',
				menubar: false,
				branding: false,
				statusbar: false,
				toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor fullscreen',
				toolbar_sticky: true,
				/*autosave_ask_before_unload: true,
				autosave_interval: "30s",
				autosave_restore_when_empty: false,
				autosave_retention: "2m",*/
				importcss_append: true,
				image_caption: true,
				browser_spellcheck: true,
				quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
				//directionality: dir_tiny,
				toolbar_drawer: 'sliding',
				contextmenu: "link",
				resize: false, 
				min_height: 130,
				max_height: 400,
				paste_data_images: false,
				paste_as_text: true,
				autoresize_on_init: true,
				autoresize_bottom_margin: 20,
				content_css: HTTP_ROOT+'css/tinymce.css',
				setup: function(ed) {
					ed.on('Click',function(ed, e) {});
					ed.on('KeyUp',function(ed, e) {
						//var inpt = tinymce.activeEditor.getContent().trim();
					});
					ed.on('Change',function(ed, e) {
						//console.log('Change here');
						//var inpt = tinymce.activeEditor.getContent().trim();
					});
					ed.on('init', function(e) {
					});
				}
		});
		
		
	});
</script>
<?php
}

if(PAGE_NAME == 'defect_details' || PAGE_NAME == 'defect' ||PAGE_NAME == 'resource_availability' || PAGE_NAME == 'mydashboard' || PAGE_NAME == "dashboard" || PAGE_NAME=='milestone'|| PAGE_NAME=='milestone' || (CONTROLLER == "archives" && PAGE_NAME == "listall") || PAGE_NAME=='milestonelist' || PAGE_NAME == 'resource_utilization' || PAGE_NAME == 'pending_task') {?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>dashboard_v1.js?v=<?php echo RELEASE; ?>" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.prettyPhoto.js" defer></script>
<?php }
if(PAGE_NAME == "mydashboard" || PAGE_NAME=='milestone' || PAGE_NAME=='dashboard' || PAGE_NAME=='milestonelist' || PAGE_NAME=='user_detail' || (CONTROLLER == 'projects' && PAGE_NAME == 'manage')) {?>
	<script type="text/javascript" src="<?php echo HTTP_ROOT;?>js/jquery/jquery.mousewheel.js" defer></script>
    <script type="text/javascript" src="<?php echo HTTP_ROOT;?>js/jquery/jquery.jscrollpane.min.js" defer></script>
    <link type="text/css" href="<?php echo HTTP_ROOT;?>js/jquery/jquery.jscrollpane.css" />
<?php } ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>gettext.js"  defer></script>
<?php if($os_locale != 'eng'){ ?>
<link href="<?php echo HTTP_ROOT; ?>Languages/<?php echo $os_locale; ?>.json?v=<?php echo RELEASE; ?>" lang="es" rel="gettext" type="application/json" /> 
<?php } ?>
<script type="text/javascript">
<?php	if(PAGE_NAME != "dashboard" && PAGE_NAME !='pricing' && PAGE_NAME !='onbording') {?>
    //console.log("<?php echo CONTROLLER?> >>> <?php echo PAGE_NAME?>");
	<?php if(CONTROLLER == "milestones" && PAGE_NAME == "manage") {?>
			var project = $("#projFil").val();
	<?php }else{?>
			var project = 'all';
	<?php } ?>
        var project = typeof $("#projFil").val() != 'undefined' ? $("#projFil").val() : 'all';
        <?php if(((CONTROLLER == "projects" || CONTROLLER == "users") && PAGE_NAME == "manage") 
                || (CONTROLLER == "projects" && PAGE_NAME == "groupupdatealerts")
                || (CONTROLLER == "archives" && PAGE_NAME == "listall")
                || (CONTROLLER == "templates" && PAGE_NAME == "tasks")
                ) {?>
            project = 'all';
        <?php } ?>
            /** Call to new RequestsController function as per optimization process */
	$.post(HTTP_ROOT+"requests/ajax_project_size",{"projUniq":project,"pageload":0}, function(data){
		 if(data){
			$('#csTotalHours').html(data.used_text);
			if(data.last_activity){
				$('#projectaccess').html(data.last_activity);
				$('#last_project_id').val(data.lastactivity_proj_id);
				$('#last_project_uniqid').val(data.lastactivity_proj_uid);
				var url=document.URL.trim();
				if(isNaN(url.substr(url.lastIndexOf('/')+1)) && (url.substr(url.lastIndexOf('/')+1)).length != 32){
					$('#selproject').val($('#last_project_id').val());
					$('#project_id').val($('#last_project_id').val());
				}
		<?php if(CONTROLLER == "milestones" && PAGE_NAME == "add" && !$milearr['Milestone']['project_id']){	?>
					$('#selproject').val(data.lastactivity_proj_id);
					$('#project_id').val(data.lastactivity_proj_id);
		<?php }	?>
			}
		  }
		},'json');
<?php }
if(!$this->Format->isiPad()) { ?>
$(function(){
	checkuserlogin();
});
<?php } ?>

<?php if(!isset($first_login) || $first_login != 1 && isset($_SESSION['Auth']['User']['dt_last_login'])){ ?>
$(function(){
	//mobile app pop up
	if(localStorage.getItem('isMobilepopup') != 1){
		/*showMobileApppop();*/
	}
});
<?php } ?>
var window_height=$(window).height();
var top_menubar_height=$(".navbar.custom-navbar").height();
var left_menu_height=(window_height)-(top_menubar_height);
$(".left-menu-panel .fixed_left_nav").css({"height":left_menu_height});
$(function(){
		$('[rel="tooltip_down_btm"]').tipsy({gravity:'n', fade:true});
		$('[rel="tooltip_down"]').tipsy({gravity:'w', fade:true});
		$('[rel="tooltip_bot"]').tipsy({gravity:'n', fade:true});
		$(".circle_refer_friend").tipsy({gravity:'e', fade:true});
        $.material.init(); 
        /*$(".hover-menu").mouseover(function () {
            $(this).find('.dropdown-menu').removeClass("fadeout_bkp").addClass("fadein_bkp");
        }).mouseout(function () {
          $(this).find('.dropdown-menu').removeClass("fadein_bkp").addClass("fadeout_bkp");
        });*/
		//replacement of the above commented code.
		$(".hover-menu").on('click',function (e) {
			e.stopPropagation();
			if($('#style_switcher').hasClass('switcher_active')){
				$('#style_switcher_toggle').trigger('click');
			}
			if($(".hover-menu").find('.top_maindropdown-menu').hasClass("fadein_bkp") && $(this).hasClass('profl_nav_active_section')){
				$(".hover-menu").removeClass('profl_nav_active_section').removeClass('open');		
        $(".hover-menu").find('.top_maindropdown-menu').removeClass("fadein_bkp").addClass("fadeout_bkp").hide();
			}else{
				$(".hover-menu").removeClass('profl_nav_active_section');			
        $(".hover-menu").find('.top_maindropdown-menu').removeClass("fadein_bkp").addClass("fadeout_bkp").hide();
				$(this).find('.top_maindropdown-menu').removeClass("fadeout_bkp").addClass("fadein_bkp").show();
				$(this).addClass('profl_nav_active_section').addClass('open');
			}
        });
		$('.hide_on_click li').not('.not-hide-li').on('click',function (e) {
			e.stopPropagation();
			$('.top_maindropdown-menu').hide();
		});
		$('.top_maindropdown-menu').on('click',function (e) {
       if(!$(e.target).closest('div.top_maindropdown-menu').length && !$(e.target).closest('ul.top_maindropdown-menu').length){              
          $(this).removeClass("fadein_bkp").addClass("fadeout_bkp").hide();
       }
		});
		$(document).on('click',function () {
			$(".hover-menu").removeClass('profl_nav_active_section');
			$(this).find('.top_maindropdown-menu').removeClass("fadein_bkp").addClass("fadeout_bkp").hide();
		});
		
        /*$('.hover-menu').hover(function(){
            $(this).find('.dropdown-menu').slideToggle();
        });*/
        /*$(".select").dropdown({"optionClass": "withripple"});
        $("#myBtn").click(function(){
                $("#myModal").modal();
        });*/
		$(".prevent_togl_li").click(function(event){
			event.stopPropagation();
		}); 
		$(".template-menu-parent").click(function(){
                /*if($('.last_visited_projects').hasClass('glyphicon-menu-down')){
                    $('.recent_visited_projects').slideToggle("slow");
                    $('.last_visited_projects').removeClass("glyphicon-menu-down");
                    $('.last_visited_projects').addClass("glyphicon-menu-right");
                }*/
            if(!$(this).hasClass('menu-logs') && $('body').hasClass('big-sidebar')){ 
             if($(".template-menu").css("display")=="none"){
                $(".template-menu").css({display:"block"});
                $(".template-menu-parent").find(".gly_mis.glyphicon").removeClass("glyphicon-menu-right");
                $(".template-menu-parent").find(".gly_mis.glyphicon").addClass("glyphicon-menu-down");
            }
            else{
                $(".template-menu").css({display:"none"});
                $(".template-menu-parent").find(".gly_mis.glyphicon").removeClass("glyphicon-menu-down");
                $(".template-menu-parent").find(".gly_mis.glyphicon").addClass("glyphicon-menu-right");
            }
                }
        });
		
		
		
        // var window_height=$(window).height();
        // var top_menubar_height=$(".navbar.custom-navbar").height();
        // var left_menu_height=(window_height)-(top_menubar_height);
        // $(".left-menu-panel .fixed_left_nav").css({"height":left_menu_height});
		
		if($(window).width() < 1000){
			$(".respo_menu .material-icons").click(function(){
				$(".main-container").addClass("body_overlay");
				$(".left-menu-panel").show();
				$(".left-menu-panel").animate({left:0}, 'slow');
			});	
			$(".main-container").click(function(e) {
				if(!$(e.target).parent('li').hasClass('list_miscl')){
			$(".main-container").removeClass('body_overlay');
			$(".left-menu-panel").hide();
			$(".left-menu-panel").animate({left:-200}, 'slow');
				}
     });
			
		}
	$(".more_in_menu").parent("li").click(function(){
		if($(".more_menu_li").css("display")=="none"){
			$(".more_menu_li").css({display:"block"});
			$(this).children("a.more_in_menu").html("<div class='more_n smenu'></div>Less");
			$(this).addClass("open");
			$(".cust_rec").css({display:"none"});
		}
		else{
			$(".more_menu_li").css({display:"none"});
			$(this).children("a.more_in_menu").html("<div class='more_n smenu'></div>More");
			$(this).removeClass("open");
			$(".cust_rec").css({display:"block"}) ;
		}
	});
	
	
	$('[rel=tooltip]').tipsy({gravity:'s', fade:true});
	/*$('.company_name_view').tipsy({gravity:'n', fade: true});*/
	$('.top_project_name').tipsy({gravity:'n', fade: true});
	
	
	$(".scrollTop").click(function(){
		$('html, body').animate({ scrollTop: 0 }, 1200);
	});
	$('body').click(function() {
		$(".tipsy").remove();
		$(".hover-menu").removeClass('profl_nav_active_section');
		$(this).find('.top_maindropdown-menu').removeClass("fadein_bkp").addClass("fadeout_bkp").hide();
	 });
});

function showhelp(){
	console.log("Google Track Event: Clicked For help");
	<?php  if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")){?>
	 //_gaq.push(['_trackEvent', 'Help and Support', 'Help and Support', 'Clicked For Help']);	
	 <?php } ?>
	openPopup();
	
	$('.loader_dv').hide();
	$('.help_popup').show();
}
function trackEventGoogle(page, section, message){
	return true;
}
function filter_ga(type,value){
	return true;
}
function dashboadrview_ga(type){
	return true;
}
function action_ga(type){
	return true;
}
</script>
<?php if(PAGE_NAME == "profile" || PAGE_NAME =="manage") {?>
    <script type="text/javascript" src="<?php echo JS_PATH;?>scripts/jquery.imgareaselect.pack.js" defer></script>
<?php } ?>

<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.fileupload.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH;?>jquery.fileupload-ui.js" defer></script>



<?php /*?>Moved from Create New project ajax request page<?php */?>
<script type="text/javascript" src="<?php echo JS_PATH;?>wiki.js?v=<?php echo RELEASE; ?>" defer></script>
<!-- <script type="text/javascript" src="<?php echo JS_PATH; ?>highcharts.js" defer></script> -->
<script type="text/javascript" src="<?php echo JS_PATH; ?>exporting.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.timepicker.min.js" defer></script>

<script type="text/javascript" src="<?php echo JS_PATH; ?>highcharts_v9.2.2.js"></script>
<?php if(in_array($GLOBALS['user_subscription']['subscription_id'],array(11,13)) || 1){ ?>
	<link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/hopscotch/hopscotch.min.css?v=<?php echo RELEASE; ?>" />
<?php } ?>
<?php if(in_array($GLOBALS['user_subscription']['subscription_id'],array(11,13)) || 1){ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>hopscotch/hopscotch.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>tour.js?v=<?php echo RELEASE; ?>" defer></script>
<?php } ?>
<?php 
//for tracking user behaviour added on 05th Sept 2015
$usrArr = $this->Format->getUserDtls(SES_ID);
$nm_intercom = $usrArr['User']['name'];
if(trim($usrArr['User']['name']) == '' || trim($usrArr['User']['name']) == 'NA'){
	$nm_intercom_t = explode('@',$usrArr['User']['email']);
	$nm_intercom = $nm_intercom_t[0];
}
//Custom attributes:
$allplans = $GLOBALS['plan_types'];
$price_plan_intercom = $allplans[$user_subscription['subscription_id']];
$user_sub_intercom_is_actv = 'No Subscription';
$user_typ_intercom = 'User';
if(SES_TYPE == 1 || SES_TYPE == 2){
	if(SES_TYPE == 1){
		$user_typ_intercom = 'Owner';
		$user_sub_intercom_is_actv = ($user_subscription['is_cancel'])?'Cancelled':'Active';
	}else{
		$user_typ_intercom = 'Admin';
	}
}

?>
<script type="text/javascript">
$(document).click(function(ev){
    if(!$(ev.target).closest('ul.cust_drop_status').length){
        $(".cust_drop_status").hide();
    }
});
$(window).load(function(){ 
   /*if(typeof localStorage["islanguagepopup"] == 'undefined'){
        openPopup();
        $(".spa_popup_content").show();
        localStorage.setItem("islanguagepopup",1);
   }*/
});
function saveDefaultLanguage(){
    v = $("#notify_lang_pop").val();
    $(".loaderLanguage").show();
    $.post('<?php echo HTTP_ROOT;?>users/saveUserData',{language:v},function(res){
        $(".loaderLanguage").hide();
        closePopup();
        location.reload();
    },'json');
}
function showMobileApppop(){
	openPopup();
	$("#dialog-form-iosandroid").css('width','60%');
	$("#dialog-form-iosandroid").show();
	$(".mobile-app-ppop").show();
}
function closeMobilepop(){
	localStorage.setItem('isMobilepopup', 1);
	$("#dialog-form-iosandroid").hide();
	$(".mobile-app-ppop").hide();
}
	function trackEventWithIntercom(event_name, meta){
            return true;
	}
</script>
<script type="text/javascript">
function setSessionStorage(StorageRefer, StorageEvent){
	// Save data to sessionStorage
	sessionStorage.setItem('SessionStorageEmailValue', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');
	if(sessionStorage.getItem('SessionStorageEmailValue') == ''){
		$.post("<?php echo HTTP_ROOT; ?>users/get_ses_value",function(data){
			sessionStorage.setItem('SessionStorageEmailValue', data.msg);
			sessionStorage.setItem('SessionStorageReferValue', StorageRefer);
			sessionStorage.setItem('SessionStorageEventValue', StorageEvent);
		},'json').fail(function(response) {return true;});
	}else{
		sessionStorage.setItem('SessionStorageReferValue', StorageRefer);
		sessionStorage.setItem('SessionStorageEventValue', StorageEvent);
	}
}

function trackEventLeadTracker(event_name, eventRefer, email_id){
    return true;
}
function showUpgradPopup(){
	alert('<?php echo UPGD_PKG; ?>');
}
</script>
<!-- Flash Success and error msg starts --> 
<div id="topmostdiv">
    <?php if ($success) { ?>
        <div class="comn_message_div">
			<div class="comn_message_div_ctnir comn_message_div" style="overflow-x: hidden;">		
		</div>
        <script>showTopErrSucc('success',"<?php echo $success; ?>");setTimeout('removeMsg()',9000);</script>
	<?php } elseif ($error) {
	    if (stristr($error, 'Object(CakeResponse)')) {
	    } else { ?>
		<div class="comn_message_div">
			<div class="comn_message_div_ctnir comn_message_div" style="overflow-x: hidden;">		
		</div>
		<?php if(stristr("Your uploaded CSV file is blank", $error)){ ?>
			<script>showTopErrSucc('error',"<?php echo $error; ?>");setTimeout('removeMsg()',40000);</script>
		<?php }else{ ?>
			<script>
				<?php if(PAGE_NAME == 'importexport'){ ?>				
					showTopErrSucc('error',"<?php echo $error; ?>", 1);
				<?php }else{ ?>
					showTopErrSucc('error',"<?php echo $error; ?>"); 
					setTimeout('removeMsg()',9000);
				<?php } ?>
			</script>
		<?php } ?>
	    <?php }
	} else { ?>
		<div class="comn_message_div">
			<div class="comn_message_div_ctnir comn_message_div" style="overflow-x: hidden;">		
		</div>
</div>
	<?php } ?>
</div>
<?php  if(in_array($this->action,$settings_arr)){ ?>
            <style type="text/css">
                 /* .comn_message_div_ctnir {color: #fff;display: inline-block;font-size: 14px;border-radius:5px;height: 50px;min-width:230px;padding:0;position: fixed;left: 50%;
    transform: translateX(-50%);-webkit-transform: translateX(-50%);-moz-transform: translateX(-50%);bottom:10px;z-index: 99999;top:-108px;margin:0px auto;bottom:0px;background-image:linear-gradient(to bottom, #ffffff 0%, #f3f3f3 100%);overflow-y:auto;} */     
            </style>
                
<?php } ?>
<script>
if((PAGE_NAME == 'manage' && PAGE_NAME != 'projects') && localStorage.getItem("tour_type") =='1'){
		setTimeout(function() {
			hopscotch.startTour(GBl_tour);
		}, 2000);
} else if(localStorage.getItem("tour_type") == '2' && CONTROLLER == 'Roles'){
		//GBl_tour = onbd_tour_resource<?php echo LANG_PREFIX;?>;
		//GBl_tour = onbd_tour_resource;
}else if(localStorage.getItem("tour_type") =='3'){
	GBl_tour = onbd_tour_mngwork<?php echo LANG_PREFIX;?>;
	//hopscotch.endTour();
	setTimeout(function() {
		hopscotch.startTour(GBl_tour);
	}, 2000);
}
</script>
<!-- Flash Success and error msg ends -->
<script type="text/template" id="fetchAllActivityTskTmpl">
	<?php echo $this->element('case_detail_right_activity_new'); ?> 
</script>
<script type="text/template" id="case_timelog_load_tmpl">
<?php echo $this->element('case_timelog_new'); ?>
</script>
<script type="text/template" id="fetchFilesTskDtlTmpl">
	<?php echo $this->element('case_files_new'); ?> 
</script>
<script type="text/template" id="fetchAllReminderTskTmpl">
	<?php echo $this->element('case_reminder_new'); ?> 
</script>

<script type="text/template" id="fetchAllBugTskTmpl">
	<?php echo $this->element('case_defect_list_new'); ?> 
</script>
<script type="text/template" id="case_label_task_cmn_tmpl">
<?php echo $this->element('case_label_task'); ?>
</script>
<script type="text/template" id="case_detail_right_activity_tmpl">
<?php echo $this->element('case_detail_right_activity_new'); ?>
</script>
<script type="text/template" id="case_thread_tmpl">
<?php echo $this->element('case_thread'); ?>
</script>