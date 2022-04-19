<?php 
$helpdeskurl = KNOWLEDGEBASE_URL;
if(CONTROLLER =='projects' && PAGE_NAME== 'manage'){
    $helpdeskurl = KNOWLEDGEBASE_URL;
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'dashboard'){
    $helpdeskurl = HELPDESK_URL.'cloud-category/reports/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'completed_sprint_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-are-sprint-reports/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'velocity_reports'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-is-velocity-chart/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'average_age_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/information-can-get-average-age-report/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'create_resolve_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/information-can-get-created-vs-resolved-tasks-report/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'pie_chart_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/information-can-get-pie-chart-report/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'recent_created_task_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/information-can-get-recent-created-task-report/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'resolution_time_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/information-can-get-resolution-time-report/';
}else if(CONTROLLER =='project_reports ' && PAGE_NAME== 'time_since_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/information-can-get-time-since-task-report/';
}else if(CONTROLLER =='reports ' && PAGE_NAME== 'hours_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-is-the-hours-spent-report/';
}else if(CONTROLLER =='reports ' && PAGE_NAME== 'weeklyusage_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-to-see-weekly-usage/';
}else if(CONTROLLER =='reports ' && PAGE_NAME== 'resource_utilization'){
    $helpdeskurl = HELPDESK_URL.'cloud/can-see-project-wise-resource-utilization/';
}else if(CONTROLLER =='reports ' && PAGE_NAME== 'pending_task'){
    $helpdeskurl = HELPDESK_URL.'cloud/pending-tasks-reports/';
}else if(CONTROLLER =='project_reports' && PAGE_NAME== 'resource_allocation_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-information-do-we-get-from-resource-allocation-reports/';
}else if(CONTROLLER =='project_reports' && PAGE_NAME== 'sprint_burndown_report'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-to-see-burn-down-chart/';
}else if(CONTROLLER =='LogTimes' && PAGE_NAME== 'resource_availability'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-can-i-know-which-resource-is-available-for-the-task/';
}else if(CONTROLLER =='users' && PAGE_NAME== 'manage'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-to-invite-a-new-user-to-orangescrum/';
}else if(CONTROLLER =='projects' && PAGE_NAME== 'manageProjectTemplates'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-project-management-methodologies-are-available-in-orangescrum/';
}else if(CONTROLLER =='projects' && PAGE_NAME== 'manage_task_status_group'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-is-status-workflow-setting/';
}else if(CONTROLLER =='Wiki'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-to-create-a-project-wiki/';
}else if(CONTROLLER =='easycases' && PAGE_NAME== 'invoice'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-to-create-invoice/';
}else if(CONTROLLER =='projects' && PAGE_NAME== 'groupupdatealerts'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-is-daily-catch-ups/';
}else if(CONTROLLER =='templates' && PAGE_NAME== 'projects'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-is-project-plan-how-it-helps-you/';
}else if(CONTROLLER =='templates' && PAGE_NAME== 'tasks'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-to-create-task-template/';
}else if(CONTROLLER =='users' && PAGE_NAME== 'profile'){
    $helpdeskurl = HELPDESK_URL.'cloud/can-edit-user/';
}else if(CONTROLLER =='users' && PAGE_NAME== 'changepassword'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-can-i-change-my-password/';
}else if(CONTROLLER =='users' && PAGE_NAME== 'email_notifications'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-are-the-other-email-notifications-and-settings/';
}else if(CONTROLLER =='users' && PAGE_NAME== 'email_reports'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-are-the-other-email-notifications-and-settings/';
}else if(CONTROLLER =='users' && PAGE_NAME== 'default_view'){
    $helpdeskurl = HELPDESK_URL.'cloud/what-are-the-options-available-in-orangescrum-settings-menu/';
}else if(CONTROLLER =='UserSidebar' && PAGE_NAME== 'index'){
    $helpdeskurl = HELPDESK_URL.'cloud/can-i-manage-my-left-menu-of-the-orangescrum/';
}else if(CONTROLLER =='UserQuicklinks' && PAGE_NAME== 'index'){
    $helpdeskurl = HELPDESK_URL.'cloud/how-can-i-manage-the-menus-in-quick-links/';
}
?>    


    <a href="<?php echo $helpdeskurl; ?>" target="_blank" onclick="return trackEventLeadTracker('Footer Link','Need Help','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" class="multilang_ellipsis" title="<?php echo __('Need Help');?>" > 
        <strong class="multilang_ellipsis" ><?php echo __('Need Help');?>?</strong>
    </a>
		
		<span style="padding:0 10px;">|</span>
		
		<a href="<?php echo GITHUB_LINK; ?>" target="_blank" class="multilang_ellipsis" title="<?php echo __('Report a BUG');?>" > 
        <strong class="multilang_ellipsis" ><?php echo __('Report a BUG');?>?</strong>
    </a>