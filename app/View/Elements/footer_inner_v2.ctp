<?php 
if(SES_COMP == 39072 || SES_COMP == 38938 || SES_COMP == 41775 || SES_COMP == 41327 || SES_COMP == 44509 || SES_COMP == 45127 || SES_COMP == 45259){ $chat_active = 0; }
if(SES_COMP == 28528 || SES_COMP == 19398){ $chat_active = 0;}
//to stop third party cal for free users 22-11-2019
$free_user_chat_hide = 0;
$chat_active = 0; // Forcefully set to 0
if(in_array($GLOBALS['user_subscription']['subscription_id'], array(11,13))){
	$free_user_chat_hide = 1;
}
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
        if(PAGE_NAME=='resource_availability'){
	 $js_files = array( 'bootstrap_new.min.js', 'material.min.js','jquery.dropdown.js','ripples.min.js'); //echo $this->Html->script($js_files,array('defer')); 
     }else{
	 $js_files = array( 'bootstrap.min.js', 'material.min.js','jquery.dropdown.js','ripples.min.js'); //echo $this->Html->script($js_files,array('defer')); 
	 }       
       ?>
	
          <?php /* if(PAGE_NAME=='resource_availability'){ ?>
        <script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap_new.min.js" defer></script>
		<?php }else{ */?>
      <script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap.min.js" defer></script>
		<?php // } ?>
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
<script type="text/javascript" src="<?php echo JS_PATH; ?>dropins.js" id="dropboxjs" data-app-key="<?php echo DROPBOX_KEY;?>" defer></script>
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
<?php } ?>
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

<?php if(!$free_user_chat_hide && defined('NODEJS_HOST') && trim(NODEJS_HOST)){ ?>
<?php if(SES_COMP != 39072 || SES_COMP == 38938){ ?>
<?php if(SES_COMP != 41775 && SES_COMP != 41327 && SES_COMP != 44509 && SES_COMP !=45127 && SES_COMP !=45259){ ?>
<script src="<?php echo NODEJS_HOST_CHAT; ?>/socket.io/socket.io.js"></script>
<?php } } ?>
<?php if(((SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320) && $chat_active == 1) || ($this->Format->isChatOn(1) && $chat_active == 1)){?>
<script src="<?php echo JS_PATH; ?>jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.dialogextend.min.js" defer></script>
<?php } ?>
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
    <?php if(((SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320) && $chat_active == 1) || ($this->Format->isChatOn(1) && $chat_active == 1)){ if(SES_COMP != 19398 && SES_COMP != 44509 && SES_COMP != 45127 && SES_COMP != 45259){ ?>
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
<?php }} ?>
}
</script>
<?php } else { ?>
<script type="text/javascript">
	function subscribeClient(){}
</script>
<?php } ?>

<?php //}?>
<?php if(((SES_COMP==1 || SES_COMP==605 || SES_COMP==15270 || SES_COMP==18326 || SES_COMP==21723 || SES_COMP==24624 || SES_COMP==29320) && $chat_active == 1) || ($this->Format->isChatOn(1) && $chat_active == 1)){?>
<?php if(!$free_user_chat_hide){ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>chat_helper.js?v=<?php echo RELEASE; ?>"></script>
<?php } ?>
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

	
if(PAGE_NAME == 'defect_details' || PAGE_NAME == 'defect' || PAGE_NAME == 'mydashboard'  || PAGE_NAME == "dashboard" || PAGE_NAME=='milestone' || (CONTROLLER == "archives" && PAGE_NAME == "listall") || PAGE_NAME=='milestonelist' || PAGE_NAME == 'resource_availability' || PAGE_NAME == 'resource_utilization' || PAGE_NAME == 'pending_task') {

	?>

	
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
		
		
	/*$(window).scroll(function () {
		if( $(window).scrollTop() > 32 ){
			$(".top_nav2").addClass("top_nav2_fixed");$(".side-nav").stop(true,true).animate({top:"1px"},300);
			$(".breadcrumb").addClass("breadcrumb_fixed");
			$(".task_action_bar").addClass("task_action_bar_fixed");
		}
		else{
			$(".top_nav2").removeClass("top_nav2_fixed");$(".side-nav").stop(true,true).animate({top:"33px"},300);
			$(".breadcrumb").removeClass("breadcrumb_fixed");
			$(".task_action_bar").removeClass("task_action_bar_fixed");
		}
	});*/
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
<script type="text/javascript" src="<?php echo JS_PATH; ?>highcharts_v9.2.2.js" defer></script>

<?php if(in_array($GLOBALS['user_subscription']['subscription_id'],array(11,13)) || 1){ ?>
	<link type="text/css" rel="stylesheet" href="<?php echo HTTP_ROOT; ?>css/hopscotch/hopscotch.min.css?v=<?php echo RELEASE; ?>" />
<?php } ?>
<?php if(in_array($GLOBALS['user_subscription']['subscription_id'],array(11,13)) || 1){ ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>hopscotch/hopscotch.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>tour_v2.js?v=<?php echo RELEASE; ?>" defer></script>
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
<?php /*
<script>
  window.intercomSettings = {
    app_id: "ojdlv9x2",
    name: "<?php echo $nm_intercom; ?>", // Full name
    email: "<?php echo $usrArr['User']['email']; ?>", // Email address
    created_at: <?php echo strtotime($usrArr['User']['dt_created']) ?>, // Signup date as a Unix timestamp
	'company_name': "<?php echo CHECK_DOMAIN; ?>",
	'price_plan': "<?php echo $price_plan_intercom; ?>",
	'user_type': "<?php echo $user_typ_intercom; ?>",
	'subscription_status': "<?php echo $user_sub_intercom_is_actv; ?>"
  };
</script>
 */ ?>
 
<?php 
$current_paid_plan = Configure::read('CURRENT_PAID_PLANS');
if (!in_array($user_subscription['subscription_id'], array(11,13))) { 
	$sub_sl_type = (isset($current_paid_plan[$user_subscription['subscription_id']])) ? $current_paid_plan[$user_subscription['subscription_id']] : 'Paid Outside'; 
}else{ 
	$sub_sl_type = 'Free';
}
if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")){ ?>
<?php if(array_key_exists($GLOBALS['user_subscription']['subscription_id'], $current_paid_plan)) { ?>

<?php } ?>
<!-- User panda start -->
<!-- User panda end -->
<?php } ?>
<?php /*
<script>(function(){var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',intercomSettings);}else{var d=document;var i=function(){i.c(arguments)};i.q=[];i.c=function(args){i.q.push(args)};w.Intercom=i;function l(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/ojdlv9x2';var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s,x);}if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})()</script>
*/ ?>
<script type="text/javascript">

$(document).click(function(ev){
    if(!$(ev.target).closest('ul.cust_drop_status').length){
        $(".cust_drop_status").hide();
    }
});

$(window).load(function(){ 
   // if(typeof localStorage["islanguagepopup"] == 'undefined'){
	  //   $(".spa_popup_content").hide();
   //      //openPopup();
   //      //$(".spa_popup_content").show();
   //      //localStorage.setItem("islanguagepopup",1);
   // }
   <?php if((SES_TYPE==1 || SES_TYPE==2) && !isset($_COOKIE['FIRST_INVITE_2']) ){ ?>
   if(typeof localStorage["userrolenotify"] == 'undefined'){
        /*openPopup();
        $(".userrolemanagementnotification").show();
        localStorage.setItem("userrolenotify",1);*/
   }
<?php } ?>
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
	function trackEventWithIntercom(event_name, meta){
		return true;
		if(meta !=''){
			//Intercom('trackEvent', event_name, meta);
		}else{
			//Intercom('trackEvent', event_name);
		}
	}
	<?php if(defined('CMP_CREATED') && CMP_CREATED <= '2019-11-15 00:00:59'){ ?>
	//Lead tracker event
	window.osSubDta = {
	 'name': "<?php echo $nm_intercom; ?>",
	 'email': "<?php echo $usrArr['User']['email']; ?>",
	 'plan_id': "<?php echo $user_subscription['subscription_id']; ?>",
	 'user_type': "<?php echo $user_typ_intercom; ?>",
	 'plan_status': "<?php echo $user_sub_intercom_is_actv; ?>",
	 'company_name':"<?php echo CHECK_DOMAIN; ?>",
	 'is_updown':"<?php echo $user_subscription['is_updown']; ?>",
	 'signed_up_date':"<?php echo $usrArr['User']['dt_created']; ?>",
	 'last_login_date':"<?php echo $usrArr['User']['dt_last_login']; ?>"
	};
	
	function isEquivalent(r,t){var e=Object.getOwnPropertyNames(r),n=Object.getOwnPropertyNames(t);if(e.length!=n.length)return!1;for(var a=0;a<e.length;a++){var i=e[a];if($.trim(r[i])!==$.trim(t[i]))return!1}return!0};

	(function () {var w = window;if (typeof(Storage) !== "undefined") {if (!localStorage.getItem("ltOsSubData")) {setSubData();localStorage.setItem("ltOsSubData", JSON.stringify(w.osSubDta));} else {var subLocalData = $.parseJSON(localStorage.getItem("ltOsSubData"));if (!isEquivalent(subLocalData, w.osSubDta)) {setSubData();localStorage.removeItem("ltOsSubData");localStorage.setItem("ltOsSubData", JSON.stringify(w.osSubDta));}}} else {console.log("Seccion/Local storage not supported");}})()

	function setSubData() {var w = window;$.ajax({url: '<?php echo LDTRACK_URL; ?>subscription-details',type: 'POST',dataType: 'json',data: {data: w.osSubDta}}).done(function(r) {console.log(r.message);}).fail(function(response){return true;});}	
	<?php }else{ ?>
		//Lead tracker event
	window.osSubDta = {};
	function isEquivalent(r,t){return true;}
	(function () {var w = window;if (typeof(Storage) !== "undefined") {if (!localStorage.getItem("ltOsSubData")) {setSubData();localStorage.setItem("ltOsSubData", JSON.stringify(w.osSubDta));} else {var subLocalData = $.parseJSON(localStorage.getItem("ltOsSubData"));if (!isEquivalent(subLocalData, w.osSubDta)) {setSubData();localStorage.removeItem("ltOsSubData");localStorage.setItem("ltOsSubData", JSON.stringify(w.osSubDta));}}} else {console.log("Seccion/Local storage not supported");}})()
	function setSubData() {return true;}	
	<?php } ?>
</script>
<script type="text/javascript">
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
function setSessionStorage(StorageRefer, StorageEvent){
	// Save data to sessionStorage
	<?php if(stristr($_SERVER['SERVER_NAME'],"payzilla.in")){ ?>
	/*	userpanda_customevents(StorageEvent,
	{"refrer": StorageRefer}); */
		<?php } ?>
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
	<?php if(stristr($_SERVER['SERVER_NAME'],"payzilla.in")){ ?>
		/* userpanda_customevents(eventRefer,
		{"refrer": event_name, "email":email_id}); */
		<?php } ?>
	// return true;
	<?php // if(defined('CMP_CREATED') && CMP_CREATED <= '2019-11-15 00:00:59'){ ?>
	$.post("<?php echo LDTRACK_URL; ?>users/saveeventtrack",
	{
		'event_name': event_name,
		'eventRefer':  eventRefer,
		'email_id':  email_id
	},
	function(data){
		return true;
	}).fail(function(response) {
		return true;
	});
	<?php /*}else{ ?>
		return true;
	<?php } */ ?>
}
function closeUpgradPopup(){
	var inpt = 0;
	if(typeof arguments[0] != 'undefined'){
		inpt = 1;	
	}
	if(typeof arguments[2] != 'undefined'){
		inpt = 2;	
	}
	if(inpt == 2){
		$('.lock_page_f').hide();
		$('.lock_page_f_sts').hide();
		$('.lock_page_f_standard').hide();
		if(parseInt(IS_PER_USER)){
			$('.lock_page_f_userwise20').hide();
			$('.lock_page_f_userwise35').hide();
		}
	} else if(inpt == 1){
		$('.lock_page_f').hide();
		$('.lock_page_f_standard').hide();
		if(parseInt(IS_PER_USER)){
			$('.lock_page_f_userwise20').hide();
			$('.lock_page_f_userwise35').hide();
		}
	}else{
		localStorage.setItem('isUpgradepopup',1);
		$('.lock_page').hide();
	}
}
function showUpgradPopup(){
	var inpt = 0;
	if(typeof arguments[0] != 'undefined'){
		inpt = 1;	
	}
	var inpt_f = 0;
	if(typeof arguments[1] != 'undefined'){
		inpt_f = 1;	
	}
	var inpt_resor = 0;
	var argument2  = 0;
	if(typeof arguments[2] != 'undefined'){
		inpt_resor = 1;	
		argument2 = arguments[2];
	}
	var inpt_csts_pop = 0;
	if(typeof arguments[3] != 'undefined'){
		inpt_csts_pop = 1;
	}
	if(inpt_csts_pop == 1){
		$('.lock_page_f_sts').show();
	}else if (inpt_f === 1 || inpt_resor ==1){
		if(argument2 ==2){
			if(parseInt(IS_PER_USER)){
				$('.lock_page_f_userwise35').show();
			}else{
				$('.lock_page_f_standard').show();
			}
		}else{
			if(parseInt(IS_PER_USER)){
				$('.lock_page_f_userwise20').show();
			}else{
				$('.lock_page_f').show();
			}
		}
	}else{
		if(!localStorage.getItem('isUpgradepopup') || (localStorage.getItem('isUpgradepopup') && localStorage.getItem('isUpgradepopup') != 1) || inpt){
			$('.lock_page').show();
		}
	}
}
<?php if(SES_TYPE <= 2 ){ //$this->Format->isResourceAvailabilityOn() &&  ?>
$(window).load(function(){           
		var popupdates = JSON.parse(localStorage.getItem("popupdates"));
		if((typeof localStorage["popupdates"] != 'undefined' && typeof popupdates[<?php echo SES_ID;?>] != 'undefined' && popupdates[<?php echo SES_ID;?>].val >=3) || (typeof localStorage["popupdates"] != 'undefined' && popupdates[<?php echo SES_ID;?>].dt =='<?php echo GMT_DATE;?>')){
				return false;
		}
		if(getCookie('FIRST_INVITE_1') != 1){
			setTimeout(function(){ /*openResourceUpgrade();*/            
				dt = "<?php echo GMT_DATE;?>";
				val = (typeof localStorage["popupdates"] != 'undefined' && typeof popupdates[<?php echo SES_ID;?>] != 'undefined' && popupdates[<?php echo SES_ID;?>].val >=1 )? parseInt(popupdates[<?php echo SES_ID;?>].val)+1:1;
				localStorage.setItem("popupdates",JSON.stringify({"<?php echo SES_ID;?>":{dt,val}}));
			}, 3000); 
		}
});
<?php } ?>
function extendTrialByUser(){
	$('.loader_dv_ext_usr_p').hide();
	$('.loader_dv_ext_usr').show();
	var url_ext = '<?php echo HTTP_ROOT; ?>';
	$.post(url_ext+"users/extendTrialByUser", {'company_id': '', 'user_id': '', 'extend': '', 'userlimit': ''}, function (res) {
		$('.loader_dv_ext_usr_p').show();
		$('.loader_dv_ext_usr').hide();
		if(res.status != 'success'){
			showTopErrSucc('error',res.message);
		}else{
			showTopErrSucc('success', 'Congratulations! Your Orangescrum FREE trial has been exttended to another <?php echo EXTEND_TRIAL_USER_DAYS; ?> days');
			setTimeout(function(){ 
				window.location.reload();
			}, 8000);
		}
		setTimeout('removeMsg()',7000);
	},'json');
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
<style type="text/css">
	.lock_page, .lock_page_f,.lock_page_f_sts,.lock_page_f_standard, .lock_page_f_userwise, .lock_page_cu, .lock_custom_page{position:fixed;left:0px;right:0;top:0;bottom:0;height: calc(100% - 0%);height: -webkit-calc(100% - 0%);height: -moz-calc(100% - 0%);width: calc(100% - 0px);width: -webkit-calc(100% - 0px);width:-moz-calc(100% - 0px);background: rgba(204, 204, 204, 0.3);display:none;z-index: 9999;}
	.oops_pop, .upgrade_plan_popup{width:600px;height:auto;text-align:center;border:1px solid #eee;margin:0 auto;position: relative;top:50%;z-index:9;background:#fff;box-shadow:0 0 20px 10px #bbb;transform: translateY(-50%);-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%)}
	.oops_pop figure{margin:20px 0;}
	.oops_pop figure img{max-width:100%;}
	.oops_pop h5{font-size:18px;line-height:30px;color:#333;margin:0 15px;padding:0}
	.oops_pop p{font-size:14px;line-height:24px;color:#333;margin:20px 15px;padding:0}
	.oops_pop .upgrade_now{display:inline-block;text-decoration:none;font-size:16px;padding:10px 30px;background:#1A73E8;color:#fff;font-weight:600;border-radius:5px;margin-bottom:20px}
    .oops_pop .upgrade_now:hover{opacity: 0.9}
	.close_upgrd.close {float:right; margin: 10px;}
	.mini-sidebar .lock_page, .mini-sidebar .lock_page_f, .mini-sidebar .lock_page_f_sts, .mini-sidebar .lock_page_f_standard, .lock_page_f_userwise{left:0px;  width: -webkit-calc(100% - 0px);width: -moz-calc(100% - 0px);width: calc(100% - 0px);}
	
	.upgrade_plan_popup{width:600px;height:auto;text-align:center;margin:20px auto 0;position: relative;z-index:9;background:#F2F2F2;box-shadow:0 0 20px 10px #ddd;padding:20px;border-radius: 10px;}
	.upgrade_plan_popup .plan_box aside{width:40%;text-align:center; box-sizing: border-box;border: 1px solid #ddd;box-shadow: 0px 0px 5px #999;}
	.upgrade_plan_popup h4{font-size:30px;line-height:40px;margin:0;padding:0;}
	.upgrade_plan_popup .sub_tddxt{font-size:15px;line-height:25px;margin:15px 0}
	.upgrade_plan_popup .bg_bx_hd{width:100%;font-size:20px;line-height:20px;font-weight:300;color:#fff;padding:8px 5px;margin-bottom:15px;box-sizing: border-box;}
	.upgrade_plan_popup aside.fl .bg_bx_hd{background:#B1AEAE}
	.upgrade_plan_popup aside.fr .bg_bx_hd{background:#60AC77}
	.upgrade_plan_popup h5{font-size:40px;line-height:40px;font-weight:700;margin:0;padding:0;color:#333;}
	.upgrade_plan_popup h5 small{font-size:15px;line-height:15px;display:inline-block;vertical-align:middle}
	.upgrade_plan_popup .plan_box > aside > strong{font-size:18px;line-height:30px;text-transform:uppercase;display:block;margin-top:5px}
	.upgrade_plan_popup h6{font-size:18px;line-height:30px;font-weight:300;margin:20px 0 15px;}
	.upgrade_plan_popup .upgrade_now{display:inline-block;text-decoration:none;font-size:16px;padding:10px 30px;background:#1CC760;color:#fff;font-weight:500;border-radius:5px;margin:20px 0 15px}
	.upgrade_plan_popup .no_thanks{text-decoration:underline;font-size:15px;line-height:25px;color:#666;}
	.upgrade_plan_popup .upgrade_arw{background:url(<?php echo HTTP_ROOT; ?>img/home/upgrade-arrow.png) no-repeat 0px 0px;width:100px;height:50px;background-size:100% auto;position:absolute;left:0;right:0;top:0;bottom:0;margin:auto;}
</style>
<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<?php
$t_dt_exp = date("Y-m-d H:i:s", strtotime($user_subscription['created'] . ' +' . FREE_TRIAL_PERIOD . 'days'));
if ($user_subscription['extend_trial'] != 0) {
	$t_dt_exp = date("Y-m-d H:i:s", strtotime($user_subscription['extend_date'] . ' +' . $user_subscription['extend_trial'] . 'days'));
}
?>
<div class="lock_page">
	<div class="oops_pop">
		<button type="button" class="close close-icon close_upgrd" data-dismiss="modal" onclick="closeUpgradPopup();"><i class="material-icons">&#xE14C;</i></button>
		<figure>
			<img src="<?php echo HTTP_ROOT;?>img/images/oops.png" alt="Unfortunately,Your free <?php echo TRIAL_DAY_TXT; ?>-day trial has expired">
		</figure>
		<h5><?php echo __('Unfortunately,Your free').' '.TRIAL_DAY_TXT.'-'.__('day trial has expired on');?> <?php echo date("D, j M Y", strtotime($t_dt_exp)); ?>. </h5>
		<p><?php echo __("Don't worry your data is safe and secured with us. We would love to provide you access to all our features, and there is still time to complete your subscription");?></p>
		 <?php if(SES_TYPE == 1){ ?>
		<a onclick="return closeUpgradPopup();" href="<?php echo HTTP_ROOT . "users/pricing"; ?>" class="upgrade_now"><?php echo __('Upgrade Now');?></a>
		 <?php }else{ ?>
		  <div style="padding: 20px;font-size: 14px;color: #f00;line-height: 20px;"><?php echo __('Contact Owner for upgrade account');?></div>
		 <?php } ?>
		
	</div>
</div>
<script type="text/javascript">
$(function(){
	<?php 
	if(isset($_SESSION['redirect_restricted_pages'])) { unset($_SESSION['redirect_restricted_pages']); ?>
		showUpgradPopup(1);
		//$('.close_upgrd').hide();
	<?php }else{ ?>
		$('.close_upgrd').show();
		showUpgradPopup();
	<?php } ?>
});
</script>
<?php } ?>

<div class="lock_page_f_sts">
	<div class="upgrade_plan_popup">
		<h4 style="font-size: 25px;margin:9px;"><?php echo __("Track your task statuses from strategy to execution with Custom Task Status Workflow");?>.</h4>
		
		<?php /*<div class="plan_box">
			<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 10 Users');?></div>
				<h5>$9<small>/<?php echo __('months');?></small></h5>
				<strong>$8 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?> <strong>5 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<div class="cb"></div>
		</div> */ ?>
		<div>
			<img src="<?php echo HTTP_ROOT.'img/ctst_pop.png'; ?>" style="max-height:200px;" /> 
		</div>
		 <?php if(SES_TYPE == 1){ ?>		
		<a onclick="return closeUpgradPopup(0,0,1);" href="<?php echo HTTP_ROOT . "users/pricing"; ?>" class="upgrade_now"><?php echo __('Try Custom Task Status for Free');?></a>
		 <?php }else{ ?>
		  <div style="padding: 20px;font-size: 14px;color: #f00;line-height: 20px;"><?php echo __('Contact Owner for upgrade account');?></div>
		 <?php } ?>
		 <div class="sub_tddxt" style="font-size:12px;margin:0;"><?php echo __('*This feature is available from BASIC plan onwards. During').' '.TRIAL_DAY_TXT.'-'.__('day trial period you won\'t be charged.');?></div>
		<div><a href="javascript:void(0);" class="no_thanks" onclick="closeUpgradPopup(0,0,1);"><?php echo __('No thanks');?> !</a></div>
	</div>
</div>

<div class="lock_page_f">
	<div class="upgrade_plan_popup">
		<h4><?php echo __("It's Time to Upgrade");?>.</h4>
		<div class="sub_tddxt"><?php echo __('This feature is available from');?> <strong><?php echo __('Basic Plan');?></strong> <?php echo __('onwards');?>.<br /><?php echo __('To use this cool feature, You need to upgrade your account');?>.</div>
		<div class="plan_box">
			<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 10 Users');?></div>
				<h5>$9<small>/<?php echo __('months');?></small></h5>
				<strong>$8 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?> <strong>5 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<div class="upgrade_arw"></div>
			<aside class="fr">
				<div class="bg_bx_hd"><?php echo __('Up to 20 Users');?></div>
				<h5>$29<small>/<?php echo __('months');?></small></h5>
				<strong>$26 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('All');?></strong> <?php echo __('Features');?> <strong>15 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<div class="cb"></div>
		</div>
		 <?php if(SES_TYPE == 1){ ?>		
		<a onclick="return closeUpgradPopup(0,1);" href="<?php echo HTTP_ROOT . "users/pricing"; ?>" class="upgrade_now"><?php echo __('Upgrade & Continue');?></a>
		 <?php }else{ ?>
		  <div style="padding: 20px;font-size: 14px;color: #f00;line-height: 20px;"><?php echo __('Contact Owner for upgrade account');?></div>
		 <?php } ?>
		<div><a href="javascript:void(0);" class="no_thanks" onclick="closeUpgradPopup(0,1);"><?php echo __('No thanks');?> !</a></div>
	</div>
</div>
<div class="lock_page_f_standard">
	<div class="upgrade_plan_popup">
		<h4><?php echo __("It's Time to Upgrade");?>.</h4>
		<div class="sub_tddxt"><?php echo __('This feature is available from');?> <strong><?php echo __('Standard Plan');?></strong> <?php echo __('onwards');?>.<br /><?php echo __('To use this cool feature, You need to upgrade your account');?>.</div>
		<div class="plan_box">
			<?php if(in_array($GLOBALS['user_subscription']['subscription_id'],array('11','13'))){ ?>
			<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 3 Users');?></div>
				<h5>$0<small>/<?php echo __('months');?></small></h5>
				<strong>$0 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?> <strong>2 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<?php }else if(in_array($GLOBALS['user_subscription']['subscription_id'],array('5','22'))){ ?>
			<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 20 Users');?></div>
				<h5>$29<small>/<?php echo __('months');?></small></h5>
				<strong>$26 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?> <strong>15 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<?php }else{ ?>
				<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 10 Users');?></div>
				<h5>$9<small>/<?php echo __('months');?></small></h5>
				<strong>$8 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?> <strong>5 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<?php } ?>
			<div class="upgrade_arw"></div>
			<aside class="fr">
				<div class="bg_bx_hd"><?php echo __('Up to 35 Users');?></div>
				<h5>$49<small>/<?php echo __('months');?></small></h5>
				<strong>$44 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('All');?></strong> <?php echo __('Features');?> <strong>30 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<div class="cb"></div>
		</div>
		<a onclick="return closeUpgradPopup(0,1);" href="<?php echo HTTP_ROOT . "users/pricing"; ?>" class="upgrade_now"><?php echo __('Upgrade & Continue');?></a>
		<div><a href="javascript:void(0);" class="no_thanks" onclick="closeUpgradPopup(0,1);"><?php echo __('No thanks');?> !</a></div>
	</div>
</div>


<?php $user_plan_storage = Configure::read('PER_USER_STORAGE'); ?>

<div class="lock_page_f_userwise lock_page_f_userwise20">
	<div class="upgrade_plan_popup">
		<h4><?php echo __("It's Time to Upgrade");?>.</h4>
		<div class="sub_tddxt"><?php echo __('This feature is available from');?> <strong id="upgd_pln_user">11 <?php echo __('users plan');?></strong> <?php echo __('onwards');?>.<br /><?php echo __('To use this cool feature, You need to upgrade your account');?>.</div>
		<div class="plan_box">
			<?php if(in_array($GLOBALS['user_subscription']['subscription_id'],array('11','13'))){ ?>
			<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 3 Users');?></div>
				<h5>$0<small>/<?php echo __('months');?></small></h5>
				<strong>$0 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?> <strong>2 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<?php }else{ ?>
				<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 10 Users');?></div>
				<h5>$9<small>/<?php echo __('month');?></small></h5>
				<strong>$8 <?php echo __('Billed Yearly');?> </strong>
				<h6 style="font-size:14px;padding: 5px;"><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?>, <strong><?php echo ($user_plan_storage[10]/1024); ?> GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<?php } ?>
			<div class="upgrade_arw"></div>
			<aside class="fr">
				<div class="bg_bx_hd" id="upgd_pln_user_upto"><?php echo __('Up to 11 Users');?></div>
				<h5>$<?php echo 9 + 1*PER_USER_PRICE; ?><small>/<?php echo __('month');?></small></h5>
				<strong>$<?php echo ((9 + 1*PER_USER_PRICE) - round(((9 + 1*PER_USER_PRICE)*0.1))); ?> <?php echo __('Billed Yearly');?> </strong>
				<h6 style="font-size:14px;padding: 5px;"><strong><?php echo __('All');?></strong> <?php echo __('Features');?> <?php echo __('included with ');?>, <strong><?php echo ($user_plan_storage[20]/1024); ?> GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<div class="cb"></div>
		</div>
		<a onclick="return closeUpgradPopup(0,1);" href="<?php echo HTTP_ROOT . "users/pricing"; ?>" class="upgrade_now"><?php echo __('Upgrade & Continue');?></a>
		<div><a href="javascript:void(0);" class="no_thanks" onclick="closeUpgradPopup(0,1);"><?php echo __('No thanks');?> !</a></div>
	</div>
</div>
<div class="lock_page_f_userwise lock_page_f_userwise35">
	<div class="upgrade_plan_popup">
		<h4><?php echo __("It's Time to Upgrade");?>.</h4>
		<div class="sub_tddxt"><?php echo __('This feature is available from');?> <strong id="upgd_pln_user">11 <?php echo __('users plan');?></strong> <?php echo __('onwards');?>.<br /><?php echo __('To use this cool feature, You need to upgrade your account');?>.</div>
		<div class="plan_box">
			<?php if(in_array($GLOBALS['user_subscription']['subscription_id'],array('11','13'))){ ?>
			<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 3 Users');?></div>
				<h5>$0<small>/<?php echo __('month');?></small></h5>
				<strong>$0 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?> <strong>2 GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<?php }else{ ?>
				<aside class="fl">
				<div class="bg_bx_hd"><?php echo __('Up to 10 Users');?></div>
				<h5>$9<small>/<?php echo __('month');?></small></h5>
				<strong>$8 <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('Limited');?></strong> <?php echo __('Features');?>, <strong><?php echo ($user_plan_storage[10]/1024); ?> GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<?php } ?>
			<div class="upgrade_arw"></div>
			<aside class="fr">
				<div class="bg_bx_hd" id="upgd_pln_user_upto"><?php echo __('Up to 11 Users');?></div>
				<h5>$<?php echo 9 + 1*PER_USER_PRICE; ?><small>/<?php echo __('months');?></small></h5>
				<strong>$<?php echo ((9 + 1*PER_USER_PRICE) - round(((9 + 1*PER_USER_PRICE)*0.1))); ?> <?php echo __('Billed Yearly');?> </strong>
				<h6><strong><?php echo __('All');?></strong> <?php echo __('Features');?>, <strong><?php echo ($user_plan_storage[20]/1024); ?> GB</strong><br/> <?php echo __('Storage');?></h6>
			</aside>
			<div class="cb"></div>
		</div>
		<a onclick="return closeUpgradPopup(0,1);" href="<?php echo HTTP_ROOT . "users/pricing"; ?>" class="upgrade_now"><?php echo __('Upgrade & Continue');?></a>
		<div><a href="javascript:void(0);" class="no_thanks" onclick="closeUpgradPopup(0,1);"><?php echo __('No thanks');?> !</a></div>
	</div>
</div>

<?php 
if(defined('DOWNTIME_WARN') && DOWNTIME_WARN){
echo $this->element('server_down_wanr'); 
}
?>
<?php if(SHOW_RELEASE_SIDEBAR){ ?>
<div class="inner_fix_notyfy">
	<div class="cmn_dasktop_notify cmn_dasktop_notify1">
		  <article>
			<h5><strong><?php echo __("Just Released");?> - <?php echo __("Skill");?> </strong> <?php echo __(" to assign projects to your available resources");?></h5>
			<p><?php echo __('Now assign projects to your resources using their skill. Based on the skill, the user can "Filter Resources" on the "Resource Availability" page.');?> </p>
			
			<?php /*<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(2);"><?php echo __('OK, GOT IT');?></a> */ ?>
				<span class="clear_not" onclick="checkDskClear(1);"><i class="material-icons">clear</i></span>
			<a class="notify_trynow_cta" href="<?php echo HTTP_ROOT;?>resource-availability" onclick="checkDskClear(1);">Try Now</a>														  
		  </article>
	</div>
	<div class="cmn_dasktop_notify cmn_dasktop_notify2">
		  <article>
			<h5><strong><?php echo __("Just Released");?> - <?php echo __("Timesheet");?> </strong> <?php echo __(" just got enhanced.");?></h5>
			<p><?php echo __("Now you can filter your task list in weekly timesheet based on Assign to me, Delegated to, Closed tasks.");?> </p>
			
			<?php /*<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(2);"><?php echo __('OK, GOT IT');?></a> */ ?>
				<span class="clear_not" onclick="checkDskClear(1);"><i class="material-icons">clear</i></span>
			<a class="notify_trynow_cta" href="<?php echo HTTP_ROOT;?>dashboard/#timesheet_weekly" onclick="checkDskClear(1);">Try Now</a>														  
		  </article>
	</div>
	<div class="cmn_dasktop_notify cmn_dasktop_notify3">
		  <article>
			<h5><strong><?php echo __("Just Released");?> - <?php echo __("@mentions");?> </strong> <?php echo __("for you to collaborate seamlessly with your teams");?></h5>
			<p><?php echo __("Team Collaboration & Task management got easier!Use @mentions in your task descriptions, comments & replies to share important information with specific project members.");?> </p>
			
			<?php /*<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(2);"><?php echo __('OK, GOT IT');?></a> */ ?>
				<span class="clear_not" onclick="checkDskClear(2);"><i class="material-icons">clear</i></span>
			<a class="notify_trynow_cta" href="<?php echo HTTP_ROOT;?>dashboard/#mentioned_list" onclick="checkDskClear(1); return checkHashLoad('mentioned_list');return trackEventLeadTracker('Just Released','Mention','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">Try Now</a>														  
		  </article>
	</div>
	<div class="cmn_dasktop_notify cmn_dasktop_notify4">
		  <article>
			<h5><strong><?php echo __("Just Released");?> - </strong><?php echo __("New Subtask View is here!");?></h5>
			<p><?php echo __("Simple hierarchy view of all your tasks, sub-tasks & sub-subtasks along with all task management actions. Visit Subtask View now.");?> </p>
			
			<?php /*<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(2);"><?php echo __('OK, GOT IT');?></a> */ ?>
				<span class="clear_not" onclick="checkDskClear(3);"><i class="material-icons">clear</i></span>
		  </article>
	</div>
	<div class="cmn_dasktop_notify cmn_dasktop_notify5">
		  <article>
			<h5><strong><?php echo __("Just Released");?> - </strong><?php echo __("Create Task from Resource Availability");?></h5>
			<p><?php echo __("Resource Management just got easier! Pan your tasks & resource assignment directly from the Resource Availability page. Seamless resource planning & increased productivity.");?> </p>
			
			<?php /*<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(2);"><?php echo __('OK, GOT IT');?></a> */ ?>
				<span class="clear_not" onclick="checkDskClear(4);"><i class="material-icons">clear</i></span>
		  </article>
	</div>
	<div class="cmn_dasktop_notify cmn_dasktop_notify6">
  <?php /*<article>
    <h5><strong><?php echo __("Just Released");?></strong><?php echo __("Google Calendar Integration");?></h5>
    <p><?php echo __("Take control of your project deadlines, appointments & tasks scheduled on your Google Calendar with a real-time, two-way integration with Orangescrum.");?> <a href="<?php echo HTTP_ROOT;?>users/syncGoogleCalendar" style="color:#1A73E8;"><?php echo __("Try it Now");?></a></p>
    <a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear();"><?php echo __('OK, GOT IT');?></a>
    <span class="clear_not" onclick="checkDskClear();"><i class="material-icons">clear</i></span>
  </article> 
  <article>
    <h5><strong><?php echo __("Just Released");?> - </strong><?php echo __("GitHub integration");?></h5>
    <p><?php echo __("Manage your GitHub issues with Orangescrum seamlessly. Auto sync enables realtime access to issues and comments without logging in to GitHub.");?> <a href="<?php echo HTTP_ROOT;?>github/gitconnect" class="okey_not"><?php echo __("Try it Now");?></a></p>
    <?php //<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(2);"><?php echo __('OK, GOT IT');?></a>  ?>
		<span class="clear_not" onclick="checkDskClear(2);"><i class="material-icons">clear</i></span>
	  </article>
	  <article> */ ?>
	  <article>
    <h5><strong><?php echo __("Just Released");?> - </strong><?php echo __("Create Subtasks from Task List now!");?></h5>
	<p><?php echo __("Create you subtasks directly from the actions menu on the task list page.");?> </p>
    
    <?php /*<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(2);"><?php echo __('OK, GOT IT');?></a> */ ?>
		<span class="clear_not" onclick="checkDskClear(5);"><i class="material-icons">clear</i></span>
	  </article>
	  </div>
	  <?php /* <div class="cmn_dasktop_notify cmn_dasktop_notify1">
	  <article>
		<h5><strong><?php echo __("Just Released");?></strong><?php echo __("Google Calendar Integration");?></h5>
		<p><?php echo __("Take control of your project deadlines, appointments & tasks scheduled on your Google Calendar with a real-time, two-way integration with Orangescrum.");?> <a href="<?php echo HTTP_ROOT;?>users/syncGoogleCalendar" style="color:#1A73E8;"><?php echo __("Try it Now");?></a></p>
		<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(1);"><?php echo __('OK, GOT IT');?></a>
		<span class="clear_not" onclick="checkDskClear(1);"><i class="material-icons">clear</i></span>
  </article>
</div> */ ?>
	<?php /*<div class="cmn_dasktop_notify cmn_dasktop_notify6">
	
			<article>
			<h5><strong><?php echo __("Just Released");?> - </strong><?php echo __("Project Templates");?></h5>
			<p><?php echo __("Create your next project with Orangescrum templates to fit your team's need and project use case.");?> 
			 <a href="<?php echo HTTP_ROOT;?>project-templates" class="okey_not"><?php echo __("Try it Now");?></a>
			</p>
			<?php //<a href="javascript:void(0);" class="okey_not" title="<?php echo __('OK, GOT IT');?>" onclick="checkDskClear(1);"><?php echo __('OK, GOT IT');?></a>  ?>
			<span class="clear_not" onclick="checkDskClear(1);"><i class="material-icons">clear</i></span>
		</article> 
		<article>
			<h5><strong><?php echo __("Just Released");?> - </strong><?php echo __("Convert task to subtask and vice versa.");?></h5>
			<p><?php echo __("No more struggles in managing tasks & subtasks. You can convert parent task to subtask and vice versa seamlessly. Get going with the updated action menu on the task list page.");?> </p>
			
			<span class="clear_not" onclick="checkDskClear(6);"><i class="material-icons">clear</i></span>
		</article> 
	</div> */ ?>
</div>
<script>
$(function(){
    if($(".configfields").length == $(".configfields:checked").length) {
        $("#column_all_fields").prop("checked", true);
    }else {
        $("#column_all_fields").prop("checked", false);            
    }
    $("#column_all_fields").click(function(){
        if($(this).is(":checked")){
            $(".configfields").prop('checked',true);
        }else{
            $(".configfields").prop('checked',false);
        }
        $(".configfields").each(function(){
            showHideTaskFields($(this).val(),'nosave');
        });
        saveTaskConfFields();
    });


    if($(".projectconfigfields").length == $(".projectconfigfields:checked").length) {
        $("#column_all_fields_project").prop("checked", true);
    }else {
        $("#column_all_fields_project").prop("checked", false);            
    }
    $("#column_all_fields_project").click(function(){
        if($(this).is(":checked")){
            $(".projectconfigfields").prop('checked',true);
        }else{
            $(".projectconfigfields").prop('checked',false);
        }
        $(".projectconfigfields").each(function(){
            showHideProjectFields($(this).val(),'nosave');
        });
        saveProjectConfFields();
    });
    <?php /*setTimeout(function(){
		//localStorage.setItem("DSKTP_NOPF", 0);		
		if(!localStorage.getItem("DSKTP_NOPF") || localStorage.getItem("DSKTP_NOPF") == '0'){
			if($('.cmn_dasktop_notify2').is(":visible")){
                $('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){
                    $('.cmn_dasktop_notify2').hide();
				$('.cmn_dasktop_notify1').show();
                     setTimeout(function(){ $('.inner_fix_notyfy').animate({right: '1px'},1000);},10000);
                });
                //$('.inner_fix_notyfy').animate({right: '1px'},1000);
				localStorage.setItem("DSKTP_NOPF", 1);
			}else{
        $('.cmn_dasktop_notify1').show();
				$('.inner_fix_notyfy').animate({right: '1px'},1000);
				localStorage.setItem("DSKTP_NOPF", 1);
			}
		}
    },36000); */ ?>
		/*	setTimeout(function(){
		if(!localStorage.getItem("DSKTP_NOPF_REMD") || localStorage.getItem("DSKTP_NOPF_REMD") == '0'){
			if($('.cmn_dasktop_notify2').is(":visible")){
						$('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){
						$('.cmn_dasktop_notify2').hide();
						$('.cmn_dasktop_notify1').show();
						 setTimeout(function(){ $('.inner_fix_notyfy').animate({right: '1px'},1000);},10000);
						});
						//$('.inner_fix_notyfy').animate({right: '1px'},1000);
						localStorage.setItem("DSKTP_NOPF_REMD", 1);
			}else{
        $('.cmn_dasktop_notify1').show();
				$('.inner_fix_notyfy').animate({right: '1px'},1000);
				localStorage.setItem("DSKTP_NOPF_REMD", 1);
			}
		}
    },36000);
    */
	
	setTimeout(function(){ 
		 // loopNotify();
              //  loopNotify_new();
    },30000);
    setTimeout(function(){
		//localStorage.setItem("DSKTP_NOPF_CSTS", 0);
    	/*if(!localStorage.getItem("DSKTP_NOPF") || localStorage.getItem("DSKTP_NOPF") == '0'){
    		$('.cmn_dasktop_notifyg').animate({right: '1px'},1000);
            localStorage.setItem("DSKTP_NOPF", 1);
    	}
		if(!localStorage.getItem("DSKTP_NOPF_CSTS") || localStorage.getItem("DSKTP_NOPF_CSTS") == '0'){
			$('.cmn_dasktop_notify1').hide();
    		$('.inner_fix_notyfy').animate({right: '1px'},1000);
				localStorage.setItem("DSKTP_NOPF_CSTS", 1);
    	}
    },20000);*/
		/*if(!localStorage.getItem("GITHUB_NOPF_REMD") || localStorage.getItem("GITHUB_NOPF_REMD") == '0'){
			$('.cmn_dasktop_notify1').hide();
    		$('.inner_fix_notyfy').animate({right: '1px'},1000);
				localStorage.setItem("GITHUB_NOPF_REMD", 1);
    	}*/
    },20000);
		
    /* setTimeout(function(){
        $('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){;
            $('.cmn_dasktop_notify2').hide();
            $('.cmn_dasktop_notify1').hide();
			
        });
    },65000); */
	setTimeout(function(){
        $('.inner_fix_notyfy').animate({right: '-360px'},1000,function(){
			if($('.cmn_dasktop_notify2').is(":visible")){
				$('.cmn_dasktop_notify2').hide();
			}if($('.cmn_dasktop_notify1').is(":visible")){
				$('.cmn_dasktop_notify1').hide();
			}if($('.cmn_dasktop_notify3').is(":visible")){
				$('.cmn_dasktop_notify3').hide();
			}if($('.cmn_dasktop_notify4').is(":visible")){
				$('.cmn_dasktop_notify4').hide();
			}if($('.cmn_dasktop_notify5').is(":visible")){
				$('.cmn_dasktop_notify5').hide();
			}if($('.cmn_dasktop_notify6').is(":visible")){
				$('.cmn_dasktop_notify6').hide();
			}
            
           // $('.cmn_dasktop_notify1').hide();
			
        });
    },90000);
});
function loopNotify_new(){
    if(!localStorage.getItem("DSKTP_TIMESHEET") || localStorage.getItem("DSKTP_TIMESHEET") == '0'){
			$('.cmn_dasktop_notify5').hide();
			$('.cmn_dasktop_notify4').hide();
			$('.cmn_dasktop_notify3').hide();
			$('.cmn_dasktop_notify2').hide();
			$('.cmn_dasktop_notify6').hide();
			$('.inner_fix_notyfy').animate({right: '1px'},1000,function(){
                            $('.cmn_dasktop_notify1').show();
                            $('.cmn_dasktop_notify5').hide();
                            $('.cmn_dasktop_notify4').hide();
                            $('.cmn_dasktop_notify3').hide();
                            $('.cmn_dasktop_notify2').hide();
                            $('.cmn_dasktop_notify6').hide();
					
                        });
				//$('.inner_fix_notyfy').animate({right: '1px'},1000);
				setTimeout(function(){
					$('.inner_fix_notyfy').animate({right: '-360px'},1000,function(){
						$('.cmn_dasktop_notify5').hide();
						$('.cmn_dasktop_notify4').hide();
						$('.cmn_dasktop_notify3').hide();
						$('.cmn_dasktop_notify1').hide();
						$('.cmn_dasktop_notify6').hide();
						$('.cmn_dasktop_notify2').hide();
				// setTimeout(function(){ ,10000);
				});
			//	loopNotify_new();
				},120000);
				localStorage.setItem("DSKTP_TIMESHEET", 1);
				//loopNotify();
        } else if(!localStorage.getItem("DSKTP_MENTION") || localStorage.getItem("DSKTP_MENTION") == '0'){
			$('.cmn_dasktop_notify5').hide();
			$('.cmn_dasktop_notify4').hide();
			$('.cmn_dasktop_notify3').hide();
			$('.cmn_dasktop_notify1').hide();
                        $('.cmn_dasktop_notify6').hide();
			$('.inner_fix_notyfy').animate({right: '1px'},1000,function(){
                            $('.cmn_dasktop_notify2').show();
                            $('.cmn_dasktop_notify5').hide();
                            $('.cmn_dasktop_notify4').hide();
                            $('.cmn_dasktop_notify3').hide();
                            $('.cmn_dasktop_notify1').hide();
                            $('.cmn_dasktop_notify6').hide();
					
                        });
				//$('.inner_fix_notyfy').animate({right: '1px'},1000);
			/*	setTimeout(function(){
					$('.inner_fix_notyfy').animate({right: '-360px'},1000,function(){
						$('.cmn_dasktop_notify5').hide();
						$('.cmn_dasktop_notify4').hide();
						$('.cmn_dasktop_notify3').hide();
						$('.cmn_dasktop_notify1').hide();
						$('.cmn_dasktop_notify2').show();
				// setTimeout(function(){ ,10000);
				});
				
			//	loopNotify();
				},20000); */
				localStorage.setItem("DSKTP_MENTION", 1);
				//loopNotify();
		}
}
function loopNotify(){
		if(!localStorage.getItem("DSKTP_MENTION") || localStorage.getItem("DSKTP_MENTION") == '0'){
			$('.cmn_dasktop_notify5').hide();
			$('.cmn_dasktop_notify4').hide();
			$('.cmn_dasktop_notify3').hide();
			$('.cmn_dasktop_notify2').hide();
			$('.inner_fix_notyfy').animate({right: '1px'},1000,function(){
					$('.cmn_dasktop_notify1').show();
					$('.cmn_dasktop_notify5').hide();
					$('.cmn_dasktop_notify4').hide();
					$('.cmn_dasktop_notify3').hide();
					$('.cmn_dasktop_notify2').hide();
					
					
				});
			
				//$('.inner_fix_notyfy').animate({right: '1px'},1000);
				setTimeout(function(){
					$('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){
						$('.cmn_dasktop_notify5').hide();
						$('.cmn_dasktop_notify4').hide();
						$('.cmn_dasktop_notify3').hide();
						$('.cmn_dasktop_notify1').hide();
						$('.cmn_dasktop_notify2').show();
				// setTimeout(function(){ ,10000);
				});
				
		//		loopNotify();
				},10000);
				localStorage.setItem("DSKTP_MENTION", 1);
				//loopNotify();
		} else if(!localStorage.getItem("DSKTP_SUBVIEW_REMD") || localStorage.getItem("DSKTP_SUBVIEW_REMD") == '0'){
			$('.cmn_dasktop_notify5').hide();
			$('.cmn_dasktop_notify4').hide();
			$('.cmn_dasktop_notify3').hide();
			$('.cmn_dasktop_notify1').hide();
			$('.inner_fix_notyfy').animate({right: '1px'},1000,function(){
					$('.cmn_dasktop_notify2').show();
					$('.cmn_dasktop_notify5').hide();
					$('.cmn_dasktop_notify4').hide();
					$('.cmn_dasktop_notify3').hide();
					$('.cmn_dasktop_notify1').hide();
					
				});
			
				//$('.inner_fix_notyfy').animate({right: '1px'},1000);
				setTimeout(function(){
					$('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){
						$('.cmn_dasktop_notify5').hide();
						$('.cmn_dasktop_notify4').hide();
						$('.cmn_dasktop_notify2').hide();
						$('.cmn_dasktop_notify1').hide();
						$('.cmn_dasktop_notify3').show();
				// setTimeout(function(){ ,10000);
				});
				
			//	loopNotify();
				},10000);
				localStorage.setItem("DSKTP_SUBVIEW_REMD", 1);
				//loopNotify();
		} else if(!localStorage.getItem("DSKTP_RATASK_REMD") || localStorage.getItem("DSKTP_RATASK_REMD") == '0'){
			
			$('.inner_fix_notyfy').animate({right: '1px'},1000,function(){
					$('.cmn_dasktop_notify3').show();
					$('.cmn_dasktop_notify5').hide();
					$('.cmn_dasktop_notify4').hide();
					$('.cmn_dasktop_notify1').hide();
					$('.cmn_dasktop_notify2').hide();
				});
				//$('.inner_fix_notyfy').animate({right: '1px'},1000);
				setTimeout(function(){
					
					$('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){
						$('.cmn_dasktop_notify5').hide();
						$('.cmn_dasktop_notify3').hide();
						$('.cmn_dasktop_notify1').hide();
						$('.cmn_dasktop_notify2').hide();
						$('.cmn_dasktop_notify4').show();
						// setTimeout(function(){ $('.inner_fix_notyfy').animate({right: '1px'},1000);},10000);
					});
					
				//	loopNotify();
				},10000);
				localStorage.setItem("DSKTP_RATASK_REMD", 1);
				
		} else if(!localStorage.getItem("DSKTP_CREATESUB_REMD") || localStorage.getItem("DSKTP_CREATESUB_REMD") == '0'){
			$('.inner_fix_notyfy').animate({right: '1px'},1000,function(){
					$('.cmn_dasktop_notify4').show();
					$('.cmn_dasktop_notify5').hide();
					$('.cmn_dasktop_notify3').hide();
					$('.cmn_dasktop_notify1').hide();
					$('.cmn_dasktop_notify2').hide();
				});
			
				//$('.inner_fix_notyfy').animate({right: '1px'},1000);
				setTimeout(function(){
					$('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){
				$('.cmn_dasktop_notify4').hide();
				$('.cmn_dasktop_notify1').hide();
				$('.cmn_dasktop_notify2').hide();
				$('.cmn_dasktop_notify3').hide();
				$('.cmn_dasktop_notify5').show();
				// setTimeout(function(){ $('.inner_fix_notyfy').animate({right: '1px'},1000);},10000);
				});
					
				//	loopNotify();
				},10000);
				localStorage.setItem("DSKTP_CREATESUB_REMD", 1);
				
				
		} else if(!localStorage.getItem("DSKTP_CONVERTSUB_REMD") || localStorage.getItem("DSKTP_CONVERTSUB_REMD") == '0'){
				$('.inner_fix_notyfy').animate({right: '1px'},1000,function(){
					$('.cmn_dasktop_notify5').show();
					$('.cmn_dasktop_notify4').hide();
					$('.cmn_dasktop_notify3').hide();
					$('.cmn_dasktop_notify1').hide();
					$('.cmn_dasktop_notify2').hide();
				});
			
				setTimeout(function(){
					$('.inner_fix_notyfy').animate({right: '-430px'},1000,function(){
				$('.cmn_dasktop_notify3').hide();
				$('.cmn_dasktop_notify2').hide();
				$('.cmn_dasktop_notify1').hide();
				$('.cmn_dasktop_notify4').hide();
				$('.cmn_dasktop_notify5').hide();
				//$('.cmn_dasktop_notify4').show();
				// setTimeout(function(){ $('.inner_fix_notyfy').animate({right: '1px'},1000);},10000);
				});
					
					
				//	loopNotify();
				},10000);
				//$('.inner_fix_notyfy').animate({right: '1px'},1000);
				localStorage.setItem("DSKTP_CONVERTSUB_REMD", 1);
				
				
		}  
		
	}
/*function checkDskClear(type){
	localStorage.setItem("DSKTP_NOPF", 1);
	localStorage.setItem("DSKTP_NOPF_CSTS", 1);
	localStorage.setItem("DSKTP_NOPF_REMD", 1);
	localStorage.setItem("GITHUB_NOPF_REMD", 1);
	if($('.cmn_dasktop_notify1').is(":visible") && $('.cmn_dasktop_notify2').is(":visible")){
		$('.cmn_dasktop_notify'+type).hide();
	}else{
		$('.cmn_dasktop_notify'+type).hide();
		$('.inner_fix_notyfy').animate({right: '-430px'},100);
	}
} */
function checkDskClear(type){
	
	$('.inner_fix_notyfy').animate({right: '-430px'},100);
	$('.cmn_dasktop_notify'+type).hide();
	//loopNotify();
}
</script>
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
<?php //echo $this->element('sql_dump'); ?>
<!-- Flash Success and error msg ends -->

<script type="text/template" id="fetchAllActivityTskTmpl">
	<?php echo $this->element('case_detail_right_activity_new'); ?> 
</script>
<script type="text/template" id="case_subtasks_tmpl">
<?php echo $this->element('case_subtasks_new'); ?>
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