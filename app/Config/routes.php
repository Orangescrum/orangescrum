<?php

/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/', array('controller' => 'users', 'action' => 'signup'));
Router::connect('/mydashboard', array('controller' => 'easycases', 'action' => 'mydashboard'));
Router::connect('/dashboard', array('controller' => 'easycases', 'action' => 'dashboard'));
Router::connect('/onbording', array('controller' => 'projects', 'action' => 'onbording'));
Router::connect('/page/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/how-it-works/*', array('controller' => 'users', 'action' => 'tour'));
Router::connect('/project-management/*', array('controller' => 'users', 'action' => 'project_management'));
Router::connect('/time-log/*', array('controller' => 'users', 'action' => 'timelog'));
Router::connect('/invoice-how-it-works/*', array('controller' => 'users', 'action' => 'invoice_how_it_works'));
Router::connect('/cost-tracking/*', array('controller' => 'users', 'action' => 'cost_tracking'));
Router::connect('/faq/*', array('controller' => 'opensource', 'action' => 'community_faq'));
Router::connect('/task-groups/*', array('controller' => 'users', 'action' => 'task_groups'));
Router::connect('/kanban-view/*', array('controller' => 'users', 'action' => 'kanban_view'));
Router::connect('/catch-up/*', array('controller' => 'users', 'action' => 'catch_up'));
Router::connect('/tour/*', array('controller' => 'users', 'action' => 'tour'));
Router::connect('/demo/*', array('controller' => 'users', 'action' => 'request_demo'));
Router::connect('/getting_started/*', array('controller' => 'users', 'action' => 'getting_started'));
Router::connect('/termsofservice/*', array('controller' => 'users', 'action' => 'termsofservice'));
Router::connect('/signup/*', array('controller' => 'users', 'action' => 'signup'));
Router::connect('/lunchuser', array('controller' => 'users', 'action' => 'lunchuser'));
Router::connect('/bug-report/*', array('controller' => 'reports', 'action' => 'glide_chart'));
Router::connect('/task-report/*', array('controller' => 'reports', 'action' => 'chart'));
Router::connect('/hours-report/*', array('controller' => 'reports', 'action' => 'hours_report'));
Router::connect('/resource-utilization', array('controller' => 'reports', 'action' => 'resource_utilization'));
Router::connect('/planned-vs-actual-report', array('controller' => 'ProjectReports', 'action' => 'PlannedVsActualTaskView'));
Router::connect('/work-load', array('controller' => 'reports', 'action' => 'work_load'));
Router::connect('/timesheet-report', array('controller' => 'reports', 'action' => 'timesheetReport'));
Router::connect('/pending-task', array('controller' => 'reports', 'action' => 'pending_task'));
Router::connect('/privacypolicy', array('controller' => 'users', 'action' => 'privacypolicy'));
Router::connect('/securities', array('controller' => 'users', 'action' => 'securities'));
Router::connect('/termsofservice', array('controller' => 'users', 'action' => 'termsofservice'));
Router::connect('/aboutus', array('controller' => 'users', 'action' => 'aboutus'));
Router::connect('/help-support/*', array('controller' => 'users', 'action' => 'help_support'));
Router::connect('/users/notification', array('controller' => 'users', 'action' => 'email_notification'));
Router::connect('/activities', array('controller' => 'users', 'action' => 'activity'));
Router::connect('/help', array('controller' => 'easycases', 'action' => 'help'));
Router::connect('/help-:slug-:id', array('controller' => 'easycases', 'action' => 'help'), array('pass' => array('slug', 'id'), 'id' => "[0-9]+"));
Router::connect('/import-export', array('controller' => 'projects', 'action' => 'importexport'));
Router::connect('/import-timelog', array('controller' => 'projects', 'action' => 'importtimelog'));
Router::connect('/import-comment', array('controller' => 'projects', 'action' => 'importcomment'));
Router::connect('/project-templates', array('controller' => 'projects', 'action' => 'manageProjectTemplates'));
Router::connect('/task-type', array('controller' => 'projects', 'action' => 'task_type'));
Router::connect('/labels', array('controller' => 'projects', 'action' => 'labels'));
Router::connect('/my-company', array('controller' => 'users', 'action' => 'mycompany'));
Router::connect('/task-settings', array('controller' => 'projects', 'action' => 'task_settings'));
Router::connect('/chat-settings', array('controller' => 'projects', 'action' => 'chat_settings'));
Router::connect('/milestone/saveMilestoneTitle', array('controller' => 'milestones', 'action' => 'saveMilestoneTitle'));
Router::connect('/milestone/*', array('controller' => 'milestones', 'action' => 'milestone'));

Router::connect('/enterprise', array('controller' => 'pages', 'action' => 'enterprise_home'));

Router::connect('/unsubscribe/*', array('controller' => 'users', 'action' => 'unsubscribe'));
Router::connect('/ganttchart/manage', array('controller' => 'ganttchart', 'action' => 'dhtmlxgantt'));
Router::connect('/Ganttchart/manage', array('controller' => 'ganttchart', 'action' => 'dhtmlxgantt'));
#Router::connect('/ganttchart/manage', array('controller' => 'ganttchart', 'action' => 'ganttv2'));
#Router::connect('/Ganttchart/manage', array('controller' => 'ganttchart', 'action' => 'ganttv2'));
Router::connect('/cost-settings', array('controller' => 'costs', 'action' => 'settings'));
Router::connect('/feed/', array('controller' => 'pages', 'action' => 'feed'));
Router::parseExtensions('rss');
Router::connect('/chat', array('controller' => 'chats', 'action' => 'freeChat'));
Router::connect('/Chat/:controller/:action', array('plugin' => 'Chat'));
Router::connect('/slack-integration/*', array('controller' => 'users', 'action' => 'slack_integration'));
Router::connect('/resource-availability', array('controller' => 'LogTimes', 'action' => 'resource_availability'));
Router::connect('/sprint-setting', array('controller' => 'projects', 'action' => 'sprint_setting'));
Router::connect('/smtp-settings/*', array('controller' => 'users', 'action' => 'smtp_settings'));

Router::connect('/quick-link-settings', array('controller' => 'UserQuicklinks', 'action' => 'index')); 
Router::connect('/popupGoogleCalendarSetting', array('controller' => 'Users', 'action' => 'popupGoogleCalendarSetting'));
Router::connect('/workflow-setting/*', array('controller' => 'projects', 'action' => 'manage_task_status_group'));
Router::connect('/status-setting/*', array('controller' => 'projects', 'action' => 'manage_status'));

Router::connect('/mobile-device/*', array('controller' => 'users', 'action' => 'get_mobile_device'));

/* for RoleManagement */
Router::connect('/sidebar-settings', array('controller' => 'UserSidebar', 'action' => 'index'));
Router::connect('/gcnotification', array('controller' => 'Webhooks', 'action' => 'gcnotification'));
Router::connect('/search/*', array('controller' => 'users', 'action' => 'search_helpdesk'));
Router::connect('/project-type', array('controller' => 'projects', 'action' => 'project_types'));
Router::connect('/project-status', array('controller' => 'projects', 'action' => 'project_status'));
Router::connect('/custom-field', array('controller' => 'projects', 'action' => 'custom_field'));
Router::connect('/duedate-change-reason', array('controller' => 'task_actions', 'action' => 'duedateChangeReason'));
Router::connect('/api/v1.0/:action', array('controller' => 'rests'));
if (strpos(Router::url(), 'api/v1.0/') > -1) {
    Router::mapResources('rests');
    Router::parseExtensions('rss', 'json');
}
/** Version 2 **/
Router::connect('/api/v2.0/:action', array('controller' => 'v2_rests'));
if (strpos(Router::url(), 'api/v2.0/') > -1) {
    Router::mapResources('v2_rests');
    Router::parseExtensions('rss', 'json');
}
Router::connect('/timesheet-settings', array('controller' => 'projects', 'action' => 'manageTimesheetSettings'));
Router::connect('/timesheet-approvals', array('controller' => 'projects', 'action' => 'manageWeeklyTimesheet'));
Router::connect('/bookmark-list', array('controller' => 'bookmarks', 'action' => 'bookmarksList'));

Router::connect('/resource-cost-report', array('controller' => 'easycases', 'action' => 'resource_cost_report'));
Router::connect('/cost-report', array('controller' => 'easycases', 'action' => 'cost_report'));
// Router::connect('/profitable-report', array('controller' => 'projects', 'action' => 'profitable_report'));
Router::connect('/profitable-report', array('controller' => 'reports', 'action' => 'profitable_report'));

Router::connect('/team-utilization', array('controller' => 'project_reports', 'action' => 'utilization'));

Router::connect('/sso/metadata', array('controller' => 'sso', 'action' =>'metadata'));
if (strpos(Router::url(), '/sso/metadata') > -1) {
    Router::parseExtensions('xml');
}

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
CakePlugin::loadAll();
CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
require CAKE . 'Config' . DS . 'routes.php';