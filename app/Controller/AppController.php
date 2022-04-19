<?php

//error_reporting(1);
//ini_set('error_reporting', E_ALL);
App::uses('Controller', 'Controller');

class AppController extends Controller
{
    public $helpers = array('Html', 'Form', 'Text', 'Format', 'Tmzone', 'Datetime', 'Cache', 'Casequery');
    public $components = array('Auth', 'Postcase', 'Session', 'Email', 'Cookie', 'Image', 'Format', 'Security','Commonapp');
    public $paginate = array();
    public $uses = array('User', 'Company', 'CompanyUser', 'Project', 'ProjectUser', 'Timezone', 'Easycase', 'CaseFile', 'UserSubscription');
    //added this during optimization
    public $cacheAction = true;
    public $taskpriorities = array('0' => 'high', '1' => 'medium', '2' => 'low');

    public function temp_logout()
    {
        $this->Session->write('Auth.User.id', '');

        unset($_SESSION['GOOGLE_USER_INFO']);
        unset($_SESSION['user_last_login']);

        setcookie('USER_UNIQ', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('USERTYP', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('USERTZ', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('REMEMBER', '', -1, '/', DOMAIN_COOKIE, false, false);

//        setcookie('SES_COMP', '', -1, '/', DOMAIN_COOKIE, false, false);
//        setcookie('SES_TYPE', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('SES_TZ', '', -1, '/', DOMAIN_COOKIE, false, false);

        setcookie('is_osadmin', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('REF_URL', '', -1, '/', DOMAIN_COOKIE, false, false);

        $cookie = array();
        // pr($cookie); exit;
        $this->Cookie->write('Auth.User', $cookie, '-2 weeks');
        /* if(SES_ID && !$qsrt) {
          $this->User->id = SES_ID;
          $this->User->saveField('dt_last_logout', GMT_DATETIME);
          if($this->isiPad() && HTTP_ROOT!=HTTP_APP){
          $retval = $this->Auth->logout();
          $this->redirect(HTTP_APP.'users/logout');exit;
          }
          } */
        $retval = $this->Auth->logout();
        $this->redirect(HTTP_APP . 'users/login');
        exit;
    }
    public function beforeFilter()
    {
        parent::beforeFilter();
        $outer_page_lilst = Configure::read('OUTER_PAGES');
        $ajax_action_exclude = Configure::read('AJAX_EXCLUDE_PAGES');				
				$ajaxPageArray = Configure::read('AJAX_PAGES');
     
        if (!$this->Auth->User('id') && !in_array($this->action, $outer_page_lilst) && (CHECK_DOMAIN && CHECK_DOMAIN != "www" && CHECK_DOMAIN != "app")) {
            //set your request uri
            //set your server name in session
            $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
            $l_url = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $this->Session->write('lastUrl', $l_url);
        } else {
            //unset sesson here
        }
        $this->loadModel('User');
       
        $user_cnt =  $this->User->find('count', array('conditions' => array('User.isactive' =>1)));
        if (!$user_cnt && ($this->action != 'signup' && $this->action != 'register_user' && $this->action != 'validate_emailurl') && $this->params['controller'] !='v2_rests') {
            $this->redirect(HTTP_ROOT . 'signup');
        }
        //,'milestone_list'
        if (MAINTENANCE && $this->Auth->User('id') && $this->action != 'logout') {
            $this->temp_logout();
        } elseif (MAINTENANCE && $this->action != 'pricing' && $this->action != 'login' && $this->action != 'home') {
            $this->redirect(HTTP_ROOT);
        }
        /*         * *Image cropping not require to enter function** */
        if ($this->action == 'image_thumb') {
            return;
        }
        //ld tracker
        define('USER_REAL_IP', $this->Format->getRealIpAddr());
        if ($this->params['controller'] !='v2_rests' && $this->Auth->User('id')) {
            //Set login data 
						$this->loadModel('UserLogin');
						$this->UserLogin->setLoginInfofromCache($this->Auth->User('id'));
				
            $user_profile = $this->User->readUserDetlfromCache($this->Auth->User('id'));
						$this->set("show_right_notification", $user_profile['User']['dt_created']);
            $_SESSION['KEEP_HOVER_EFFECT'] = $this->User->readKeepHoverfromCache($this->Auth->user('id'));
            if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'raf') {
                $_SESSION['RAF_OTHERS'] = 1;
                setcookie('RAF_OTHERS', '1', time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
            }
            /* if (!defined('SES_EMAIL_USER_LOGIN')) {
              $getUserEmailFromUserId = $this->Format->getUserNameForEmail($this->Auth->User('id'));
              define('SES_EMAIL_USER_LOGIN', $getUserEmailFromUserId['User']['email']);
              } */
            if (!isset($_SESSION['SES_EMAIL_USER_LOGIN']) || trim($_SESSION['SES_EMAIL_USER_LOGIN']) == '') {
                $getUserEmailFromUserId = $this->Format->getUserNameForEmail($this->Auth->User('id'));
                $_SESSION['SES_EMAIL_USER_LOGIN'] = $getUserEmailFromUserId['User']['email'];
            }
            /* below code is for CSRF issue fixing: */
            if (!isset($_SESSION['CSRFTOKEN'])) {
                $tokn = $this->Format->genRandomStringCustom(25);
                $_SESSION['CSRFTOKEN'] = $tokn;
            }

            /* below code is for log out users if password reset start: */
            $t_uid = $this->Auth->User('id');
            $this->User->getProfileBgColr($t_uid);
            if (!$_COOKIE['user_uniq_agent']) {
                $this->User->keepPassChk($t_uid);
            }
            if (!strstr(PAGE_NAME, "ajaX") && !in_array($this->action, $ajax_action_exclude)) {
                $this->LoadModel('OsSessionLog');
                $existing_ses = $this->OsSessionLog->getUserDetls($t_uid);
                if ($existing_ses) {
                    if ($user_profile['User']['password'] != $existing_ses['OsSessionLog']['user_agent'][$_COOKIE['user_uniq_agent']]) {
                        $this->temp_logout();
                    }
                }
            }
            /* end */
            if (!strstr(PAGE_NAME, "ajaX") && !$this->Auth->User('is_client') && !in_array($this->action, $ajax_action_exclude)) {
                $get_App_Comp = $this->Company->query("SELECT CompanyUser.is_client,CompanyUser.user_type,CompanyUser.company_id,Company.logo,Company.website,Company.name,Company.is_active,Company.is_deactivated,Company.created,Company.uniq_id,Company.is_skipped,Company.twitted  FROM company_users AS CompanyUser,companies AS Company WHERE CompanyUser.company_id=Company.id AND CompanyUser.user_id='" . $this->Auth->User('id') . "' AND Company.seo_url='" . $_SESSION['CHECK_DOMAIN'] . "'");
                $this->Session->write('Auth.User.is_client', $get_App_Comp[0]['CompanyUser']['is_client']);
                $this->Session->write('Auth.User.user_type', $get_App_Comp[0]['CompanyUser']['user_type']);
                if (!isset($_SESSION['user_last_login'])) {
                    if (!empty($get_App_Comp) && $get_App_Comp[0]['CompanyUser']['company_id']) {
                        $this->Company->query("UPDATE companies SET user_last_login='" . GMT_DATETIME . "' WHERE id=" . $get_App_Comp[0]['CompanyUser']['company_id']);
                        $_SESSION['user_last_login'] = 1;
                    }
                }
            }
        } else {
            //setcookie('helpdesk_uniq_agent', '-1', time()+60*60*24*30*12,'/',DOMAIN_COOKIE,false,false);
            $act_arr = array('login','test_email','forgotpassword','ajaxpostcase','ajaxemail','invoicePdf','project_overview_pdf','export_pdf_timelog','timesheetPDF','pdfsprint_report','ssoSetting','authenticateSaml', 'metadata', 'ssoLogin');
            if ($user_cnt && !in_array($this->action, $act_arr) && $this->params['controller'] !='v2_rests') {
                $this->redirect(HTTP_ROOT . 'users/login');
                exit;
            }
        }
        $referrer_link = $this->setReferrer(); //For Open Source Pages

        //$this->set("referrer_link",$referrer_link);
        $this->set("referrer_link", '');

        //Excluding below functionality from ajax calls
        if (!strstr(PAGE_NAME, "ajaX") && !in_array($this->action, $ajax_action_exclude)) {
            foreach ($_GET as $key => $value) {
                $_GET[$key] = strip_tags($value);
            }
        }
        $GLOBALS['FREE_SUBSCRIPTION'] = 0;
        $GLOBALS['FREE_SUBSCRIPTION_EMAIL'] = 0;

        //DEFAULT_PAGE cookie will only work only if Configure::read('default_action') is mydashboard
        if (Configure::read('default_action') == 'mydashboard' && isset($_COOKIE['DEFAULT_PAGE']) && in_array($_COOKIE['DEFAULT_PAGE'], array('dashboard', 'mydashboard'))) {
            Configure::write('default_page', $_COOKIE['DEFAULT_PAGE']);
        } else {
            Configure::write('default_page', Configure::read('default_action'));
        }
        // Codes added for SSL security
        $this->Security->validatePost = false;
        $this->Security->csrfCheck = false;
        $this->Security->csrfUseOnce = false;
        /*if ((SITE_NAME == 'Orangescrum.com') && trim($org) == "") {
            $sslnallowed_url = array('testnefield','send_mail_to_customers', 'send_mail_to_admin', 'terms', 'privacy', 'affiliates', 'display', 'faq', 'ajax_totalcase', 'ajax_get_referrer_cookie', 'ajax_set_referrer_cookie', 'invoicePage', 'invoicePdf', 'addon_download_invoice', 'installation_download_invoice','pdfcase_project','project_overview_pdf','export_pdf_timelog','pdfsprint_report'); //,'sub_transaction'
            $this->Security->blackHoleCallback = 'forceSSL';
            if (!in_array($this->params['action'], $sslnallowed_url)) {
                $this->Security->requireSecure('*');
            } else {
                if ($_SERVER['HTTPS']) {
                    $partern = '/((^http\:\/\/www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i';
                    $currenturl = Router::url($this->here, true);
                    if (!preg_match($partern, $currenturl)) {
                        $params = "";
                        if (isset($_GET['affiliate_key']) && $_GET['affiliate_key']) {
                            $params = "/?affiliate_key=" . $_GET['affiliate_key'];
                        }
                        $this->redirect('http://www.' . SITE_NAME . $this->here . $params);
                        exit;
                    }
                }
            }
        }*/
        //This section is set for user id and company id when calling by api from cron or rest controller.

        /**
        * This is used from the cron controller curlPostData() method
        */
        $user_uniq_id = isset($this->request->data['auth_token']) ? $this->request->data['auth_token'] : (isset($this->params->data['user_auth_key']) ? $this->params->data['user_auth_key'] : '');

        if (isset($user_uniq_id) && trim($user_uniq_id) != '') {
            $api_file = isset($this->params->data['api_file']) ? $this->params->data['api_file'] : "";
            $authToken = isset($this->request->data['auth_token']) ? $this->request->data['auth_token'] : "";
            $this->oauthCheck($this->request->data['projectId'], $this->params->data['pid'], $this->request->data['companyId'], $this->request->data['auth_token'], $user_uniq_id, $api_file);
        }

        if (!defined('IS_ERRROR')) {
            if ($this->name == 'CakeError') {
                define('IS_ERRROR', 1);
            } else {
                define('IS_ERRROR', 0);
            }
        }
        if ($this->params['controller'] == 'easycases' && $this->params['action'] == 'dashboard' && isset($this->params->query['case'])) {
            $this->set('caseForRecent', $this->params->query['case']);
        } else {
            $this->set('caseForRecent', '');
        }
        if (!defined('CONTROLLER')) {
            define('CONTROLLER', $this->params['controller']);
        }
        if (!defined('PAGE_REQUEST_URI') && isset($_SERVER['REQUEST_URI'])) {
            define('PAGE_REQUEST_URI', $_SERVER['REQUEST_URI']);
        }
        if (!defined('PAGE_NAME')) {
            define('PAGE_NAME', $this->action);
        }
        if (!defined('STATIC_PAGE')) {
            if (isset($this->params['pass']['0'])) {
                define('STATIC_PAGE', $this->params['pass']['0']);
            } else {
                define('STATIC_PAGE', "home");
            }
        }
        //define('USER_TYPE', $this->Auth->user('istype'));
        $pagesName = "";
        if (isset($this->params['pass']['0'])) {
            $pagesName = $this->params['pass']['0'];
        }

        $curProjId = "";
        $projUniq = "";
        if (CHECK_DOMAIN && CHECK_DOMAIN != "www" && PAGE_NAME == "home") {
            if ($this->Auth->User('id')) {
                $this->redirect(PROTOCOL . CHECK_DOMAIN . "." . DOMAIN . Configure::read('default_page'));
            } else {
                if (NO_SUB_DOMAIN) {
                    // Don't redirect any wheare
                } else {
                    $this->redirect(PROTOCOL . "www." . DOMAIN);
                }
            }
        }
        if (CONTROLLER == 'users' && PAGE_NAME == 'login' && CHECK_DOMAIN == 'www') {
            $this->redirect(trim(HTTP_APP, '/') . $_SERVER['REQUEST_URI']);
        }

        //$ajaxPageArray = array('project_menu', 'remember_filters', 'session_maintain', 'add_user', 'add_project', 'case_details', 'archive_case', 'archive_file', 'ajaxpostcase', 'check_email_reg', 'check_short_name_reg', 'check_url_reg', 'update_notification', 'feedback', 'check_short_name', 'new_user', 'notification', 'caseview_remove', 'project_all', 'jquery_multi_autocomplete_data', 'search_project_menu', 'project_listing', 'assign_prj', 'contactnow', 'ajax_totalcase', 'ajax_get_referrer_cookie', 'ajax_set_referrer_cookie', 'case_list', 'file_list', 'move_list', 'case_remove', 'move_file', 'file_remove', 'comment_edit', 'comment', 'fileremove', 'fileupload', 'case_update', 'case_files', 'case_project', 'case_reply', 'case_quick', 'case_message', 'update_assignto', 'exportcase', 'assign_userall', 'image_thumb', 'to_dos', 'recent_projects', 'recent_activities', 'recent_milestones', 'statistics', 'usage_details', 'task_progress', 'task_types', 'leader_board', 'post_support_inner','case_backlog','loadTaskByBacklog');
        $this->set('referer', (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''));

        #print $_COOKIE['USER_UNIQ'];exit;
        if (isset($_COOKIE['USER_UNIQ']) && isset($_COOKIE['USERTYP']) && isset($_COOKIE['USERTZ']) && isset($_COOKIE['USERSUB_TYPE']) && PAGE_NAME != 'os_rev_from_self') {
            setcookie('USER_UNIQ', $_COOKIE['USER_UNIQ'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
            setcookie('USERTYP', $_COOKIE['USERTYP'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
            setcookie('USERTZ', $_COOKIE['USERTZ'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
            setcookie('USERSUB_TYPE', $_COOKIE['USERSUB_TYPE'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);

            $uid = null; //var for user id, which will be retrieve form user unique id
            if ($this->Auth->user('id') && 0) {
                $uid = $this->Auth->user('id');
            } else {
                $this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
                $userLogRec = $this->User->find('first', array('conditions' => array('User.uniq_id' => $_COOKIE['USER_UNIQ']), 'fields' => 'User.id'));

                if ($userLogRec && count($userLogRec)) {
                    $uid = $userLogRec['User']['id'];
                }
            }

            if (!$uid) {
                setcookie('USER_UNIQ', '', -1, '/', DOMAIN_COOKIE, false, false);
                $this->redirect(HTTP_ROOT . "users/logout");
                die;
            }

            $this->Session->write('Auth.User.id', $uid);
            $this->Session->write('Auth.User.uniq_id', $_COOKIE['USER_UNIQ']);
            $this->Session->write('Auth.User.istype', $_COOKIE['USERTYP']);
            $this->Session->write('Auth.User.timezone_id', $_COOKIE['USERTZ']);
            $this->Session->write('Auth.User.usersub_type', $_COOKIE['USERSUB_TYPE']);
            $this->Session->write('Auth.User.is_moderator', $_COOKIE['IS_MODERATOR']);
        } else {
            if (!$this->isiPad() && CONTROLLER !='v2_rests') {
                $this->Session->write('Auth.User.id', '');
            }
        }
        if ($this->Auth->User("id")) {
            if ($this->isiPad()) {
                setcookie('USER_UNIQ', $this->Auth->user('uniq_id'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
                setcookie('USERTYP', $this->Auth->user('istype'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
                setcookie('USERTZ', $this->Auth->user('timezone_id'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
                setcookie('USERSUB_TYPE', $this->Auth->user('usersub_type'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
            }
            if ((!strstr(PAGE_NAME, "ajaX") && !strstr(PAGE_NAME, "ajaX") && !stristr(PAGE_NAME, "ajax_") && !in_array(PAGE_NAME, $ajaxPageArray) && !in_array(PAGE_NAME, $ajax_action_exclude)) || PAGE_NAME == 'categorytab' || PAGE_NAME == 'ajax_savecategorytab') {

                /*$this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
                $userDeskNotify = $this->User->find(
                    'first',
                    array(
                    'conditions' => array(
                        'User.id' => $this->Auth->User("id")
                    ),
                    'fields' => array('User.desk_notify', 'active_dashboard_tab', 'name')
                        )
                );*/
                $desk_notify = (int) $user_profile['User']['desk_notify'];

                define('DESK_NOTIFY', $desk_notify);
                if (!defined('ACT_TAB_ID')) {
                    define('ACT_TAB_ID', $user_profile['User']['active_dashboard_tab']);
                }
                if (!defined('USERNAME')) {
                    define('USERNAME', $user_profile['User']['name']);
                }
            }
            $uid = $this->Auth->User("id");
            if (!defined('SES_ID')) {
                define('SES_ID', $this->Auth->User("id"));
            }
            if (CHECK_DOMAIN && CHECK_DOMAIN == "app" && PAGE_NAME == "blankpage") {
            } elseif (!strstr(PAGE_NAME, "ajaX") && !stristr(PAGE_NAME, "ajax_") && !in_array(PAGE_NAME, $ajaxPageArray) && !in_array(PAGE_NAME, $ajax_action_exclude)) {
                if (CHECK_DOMAIN && CHECK_DOMAIN == "app" && PAGE_NAME != "launchpad" && PAGE_NAME != "logout" && PAGE_NAME != "paypalipnreturn" && PAGE_NAME != "paypalipn" && PAGE_NAME != "googleConnect" && PAGE_NAME != "syncGoogleCalendar" && PAGE_NAME != "gitconnect" && CONTROLLER !== 'rests' && PAGE_NAME !== 'unsubscribe') {
                    if (isset($this->request->params['action']) && $this->request->params['action'] != 'emailUpdate' && $this->request->params['action'] != 'os_rev_from_self' && $this->request->params['action'] != 'create_project') {
                        $this->redirect(HTTP_APP . "users/launchpad");
                    }
                }
                if (defined('CHECK_DOMAIN') && CHECK_DOMAIN != '' && CHECK_DOMAIN != "app") {
                    $checkCmnpyUsr = $this->CompanyUser->find('all', array('conditions' => array('CompanyUser.user_id' => $uid, 'CompanyUser.is_active' => 1), 'fields' => array('CompanyUser.company_id', 'CompanyUser.is_client', 'CompanyUser.user_type')));
                    $companyIds = array();
                    $companyChkIds = array();
                    foreach ($checkCmnpyUsr as $cu) {
                        $companyIds[] = $cu['CompanyUser']['company_id'];
                        $companyChkIds[$cu['CompanyUser']['company_id']] = $cu['CompanyUser']['user_type'];
                    }

                    $seoarr = $this->Company->find('all', array('conditions' => array('Company.id' => $companyIds), 'fields' => array('Company.id', 'Company.seo_url', 'Company.is_active')));
                    $seoArr = array();
                    foreach ($seoarr as $arr) {
                        if ($arr['Company']['is_active'] == 1 || ($companyChkIds && $companyChkIds[$arr['Company']['id']] != 3)) {
                            //if($arr['Company']['is_active'] == 1){
                            $seoArr[] = $arr['Company']['seo_url'];
                        }
                    }
                    if (!defined('TOT_COMPANY')) {
                        define('TOT_COMPANY', count($seoArr));
                    }
                    if (!in_array(CHECK_DOMAIN, $seoArr)) {
                        if (count($seoArr)) {
                            if (count($seoArr) == 1) {
                                $this->redirect(PROTOCOL . $seoArr[0] . "." . DOMAIN . Configure::read('default_page'));
                            } else {
                                if (PAGE_NAME != "launchpad") {
                                    if (isset($this->request->params['pass'][0]) && $this->request->params['pass'][0] == 'raf') {
                                        $_SESSION['RAF_OTHERS'] = 1;
                                        setcookie('RAF_OTHERS', '1', time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                                    }
                                    $this->redirect(HTTP_APP . "users/launchpad");
                                }
                            }
                        } else {
                            $this->redirect(HTTP_APP . "users/logout");
                        }
                    }
                }
                $this->loadModel("Project");
                $this->loadModel("ProjectUser");
                $sql = "SELECT DISTINCT Project.id,Project.uniq_id,Project.name,Project.default_assign, ProjectUser.dt_visited FROM project_users AS ProjectUser,projects AS Project WHERE Project.id= ProjectUser.project_id AND ProjectUser.user_id=" . SES_ID . " AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' order by ProjectUser.dt_visited DESC limit 1";
                $getlatestproj = $this->ProjectUser->query($sql);

                $GLOBALS['curProjId'] = $getlatestproj[0]['Project']['id'];
                $GLOBALS['projUniq'] = $getlatestproj[0]['Project']['uniq_id'];
            }
            define('USER_TYPE', $this->Auth->user('istype'));
            define('IS_MODERATOR', $this->Auth->user('is_moderator'));
            $this->set('success', $this->Session->read("SUCCESS"));
            $this->set('error', $this->Session->read("ERROR"));
            if (CONTROLLER == 'osadmins') {
                $this->layout = 'default_admin';
            } else {
                $this->layout = 'default_inner';
            }
            $this->Session->write("SUCCESS", "");
            $this->Session->write("ERROR", "");

            //Global Variable and cookie set
            if (!defined('FIRST_LOGIN')) {
                define('FIRST_LOGIN', $_COOKIE['FIRST_LOGIN']);
                if ($_COOKIE['FIRST_LOGIN']) {
                    setcookie('FIRST_LOGIN', '', -1, '/', DOMAIN_COOKIE, false, false);
                }
            }
            if (!defined('INVITE_USER')) {
                define('INVITE_USER', $_COOKIE['INVITE_USER']);
                if ($_COOKIE['INVITE_USER']) {
                    setcookie('INVITE_USER', '', -1, '/', DOMAIN_COOKIE, false, false);
                }
            }
            if (!defined('CREATE_CASE')) {
                define('CREATE_CASE', $_COOKIE['CREATE_CASE']);
                if ($_COOKIE['CREATE_CASE']) {
                    setcookie('CREATE_CASE', '', -1, '/', DOMAIN_COOKIE, false, false);
                }
            }
            if (!defined('ASSIGN_USER')) {
                define('ASSIGN_USER', $_COOKIE['ASSIGN_USER']);
                if ($_COOKIE['ASSIGN_USER']) {
                    setcookie('ASSIGN_USER', '', -1, '/', DOMAIN_COOKIE, false, false);
                }
            }
            if (!defined('PROJ_NAME')) {
                define('PROJ_NAME', $_COOKIE['PROJ_NAME']);
                if ($_COOKIE['PROJ_NAME']) {
                    setcookie('PROJ_NAME', '', -1, '/', DOMAIN_COOKIE, false, false);
                }
            }

            if (!defined('SES_ID')) {
                define('SES_ID', $this->Auth->User("id"));
            }
            if (!defined('SES_TIMEZONE')) {
                define('SES_TIMEZONE', $this->Auth->User("timezone_id"));
            }

            $sesType = "";
            $sesComp = "";
            $is_skipped = 0;
            $this->loadModel('TaskField');
            $defaultfields = $this->TaskField->readTaskFieldfromCache($this->Auth->User("id"));
            //$defaultfields = $this->TaskField->find('first', array('conditions' => array('TaskField.user_id' => SES_ID)));
            if (empty($defaultfields['TaskField']['form_fields'])) {
                $defaultfields['TaskField']['form_fields'] = implode(',', Configure::read('TASK_FIELDS_DEFAULT'));
            }
            if (empty($defaultfields['TaskField']['project_form_fields'])) {
                $defaultfields['TaskField']['project_form_fields'] = implode(',', Configure::read('PROJECT_FIELDS_DEFAULT'));
            }
            $this->set('defaultfields', $defaultfields);
            // jyoty sir's issues
               $this->set('defaultdefectfields', []);
            
            if (!strstr(PAGE_NAME, "ajaX") && !stristr(PAGE_NAME, "ajax_") && !in_array(PAGE_NAME, $ajaxPageArray)&& !in_array(PAGE_NAME, $ajax_action_exclude)) {
                $easy_chk = '';
                if (isset($_SESSION['CHECK_DOMAIN']) && !empty($_SESSION['CHECK_DOMAIN']) && !in_array(PAGE_NAME, $ajax_action_exclude)) {
                    $easy_chk = " AND Company.seo_url='" . $_SESSION['CHECK_DOMAIN'] . "'";
                }
                $getAppComp = $this->Company->query("SELECT CompanyUser.user_type,CompanyUser.company_id,CompanyUser.role_id,Company.logo,Company.website,Company.name,Company.is_active,Company.is_deactivated,Company.created,Company.uniq_id,Company.is_skipped,Company.twitted,Company.work_hour,Company.week_ends,Company.new_layout_no,Company.is_per_user FROM company_users AS CompanyUser,companies AS Company WHERE CompanyUser.company_id=Company.id AND CompanyUser.user_id='" . SES_ID . "'".$easy_chk);
                if ($getAppComp) {
                    $_SESSION['CHECK_DOMAIN'] = $getAppComp['0']['Company']['seo_url'];
                }

                $is_skipped = @$getAppComp['0']['Company']['is_skipped'];
                if (!defined('CMP_LOGO')) {
                    define('CMP_LOGO', @$getAppComp['0']['Company']['logo']);
                }
                if (!defined('ACCOUNT_STATUS')) {
                    define('ACCOUNT_STATUS', @$getAppComp['0']['Company']['is_active']);
                }
                if (!defined('IS_DEACTIVATED')) {
                    define('IS_DEACTIVATED', @$getAppComp['0']['Company']['is_deactivated']);
                }
                if (!defined('CMP_SITE')) {
                    define('CMP_SITE', @$getAppComp['0']['Company']['name']);
                }
                if (!defined('CMP_CREATED')) {
                    define('CMP_CREATED', @$getAppComp['0']['Company']['created']);
                }
                if (!defined('COMP_LAYOUT')) {
                    define('COMP_LAYOUT', $getAppComp['0']['Company']['new_layout_no']);
                }
                if (!defined('COMP_UID')) {
                    define('COMP_UID', @$getAppComp['0']['Company']['uniq_id']);
                }

                if (!defined('TWITTED')) {
                    define('TWITTED', @$getAppComp['0']['Company']['twitted']);
                }
    
                $sesType = @$getAppComp['0']['CompanyUser']['user_type'];
                $roleId = @$getAppComp['0']['CompanyUser']['role_id'];
                $sesComp = @$getAppComp['0']['CompanyUser']['company_id'];

                $this->Session->write("SES_TYPE", $sesType);
                $this->Session->write("SES_COMP", $sesComp);
                setcookie("SES_ROLE", $roleId, COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
                //This is already defined as constant above. So removed from cookie and did not set to session
                $this->Session->write("COMP_UID", @$getAppComp['0']['Company']['uniq_id']);

                if (!defined('SES_TYPE')) {
                    define('SES_TYPE', $sesType);
                }
                if (!defined('SES_COMP')) {
                    define('SES_COMP', $sesComp);
                }
                if (!defined('SES_ROLE')) {
                    define('SES_ROLE', $roleId);
                }
                if (!defined('IS_PER_USER')) {
                    define('IS_PER_USER', $getAppComp['0']['Company']['is_per_user']);
                }
                $GLOBALS['company_work_hour']=@$getAppComp['0']['Company']['work_hour'];
                $GLOBALS['company_week_ends']=@$getAppComp['0']['Company']['week_ends'];
            } else {
                $easy_chk = '';
                if (isset($_SESSION['CHECK_DOMAIN']) && !empty($_SESSION['CHECK_DOMAIN'])) {
                    $easy_chk = " AND Company.seo_url='" . $_SESSION['CHECK_DOMAIN'] . "'";
                }
                $getAppComp = $this->Company->query("SELECT CompanyUser.user_type,CompanyUser.company_id,CompanyUser.role_id,Company.logo,Company.website,Company.name,Company.is_active,Company.is_deactivated,Company.created,Company.uniq_id,Company.is_skipped,Company.twitted,Company.work_hour,Company.week_ends,Company.new_layout_no,Company.seo_url,Company.work_hour  FROM company_users AS CompanyUser,companies AS Company WHERE CompanyUser.company_id=Company.id AND CompanyUser.user_id='" . SES_ID . "'".$easy_chk);
                if ($getAppComp) {
                    $_SESSION['CHECK_DOMAIN'] = $getAppComp['0']['Company']['seo_url'];
                }
                if (!defined('SES_TYPE')) {
                    //define('SES_TYPE', $_COOKIE['SES_TYPE']);
                    define('SES_TYPE', $getAppComp['0']['CompanyUser']['user_type']);
                }
                if (!defined('SES_COMP')) {
                    //define('SES_COMP', $_COOKIE['SES_COMP']);
                    define('SES_COMP', @$getAppComp['0']['CompanyUser']['company_id']);
                }
                if (!defined('CMP_CREATED')) {
                    //define('CMP_CREATED',  $_COOKIE['CMP_CREATED']);
                    define('CMP_CREATED', $getAppComp['0']['Company']['created']);
                }
               
                if (!defined('COMP_LAYOUT')) {
                    define('COMP_LAYOUT', $getAppComp['0']['Company']['new_layout_no']);
                }
                if (!defined('COMP_UID')) {
                    define('COMP_UID', $getAppComp['0']['Company']['uniq_id']);
                }
                if (!defined('CMP_LOGO')) {
                    define('CMP_LOGO', '');
                }
                if (!defined('CMP_SITE')) {
                    define('CMP_SITE', '');
                }
                //added below two just after 08/09/2015(dd/mm/yyyy)
                if (!defined('ACCOUNT_STATUS')) {
                    define('ACCOUNT_STATUS', @$getAppComp['0']['Company']['is_active']);
                }
                if (!defined('CMP_SITE')) {
                    define('CMP_SITE', @$getAppComp['0']['Company']['name']);
                }
                $roleId = @$getAppComp['0']['CompanyUser']['role_id'];
                setcookie("SES_ROLE", $roleId, COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
                if (!defined('SES_ROLE')) {
                    define('SES_ROLE', $roleId);
                }
                if (!defined('IS_PER_USER')) {
                    define('IS_PER_USER', $getAppComp['0']['Company']['is_per_user']);
                }
                $GLOBALS['company_work_hour']=@$getAppComp['0']['Company']['work_hour'];
                $GLOBALS['company_week_ends']=@$getAppComp['0']['Company']['week_ends'];
            }
            if ($this->Auth->User("id") && !$this->Session->read('leftMenuSize')) {
                //$this->Session->write('leftMenuSize', 'mini-sidebar');
                $this->Session->write('leftMenuSize', 'big-sidebar');
            }
            //SET OR DEFINE DEFAULT TASK VIEW
            

            if (!strstr(PAGE_NAME, "ajaX") && !in_array($this->action, $ajax_action_exclude)) {
                $this->set('edit_task', 2);

                //Set or Define Chat Cettings
                // $this->loadModel('ChatSetting');
                // $chat_settings = $this->ChatSetting->getChatSettings();
                // if (empty($chat_settings)) {
                //     $chat_settings['ChatSetting']['is_active'] = 1;
                // }
                // $this->set('chat_active', $chat_settings['ChatSetting']['is_active']);
            }
            if (PAGE_NAME == 'download' && CONTROLLER == 'easycases') {
                $this->redirect(HTTP_ROOT . "easycases/downloadfiles/" . @$this->request->params['pass'][0]);
            }

            ##### Set Timezone Variables
            if (PAGE_NAME != 'image_thumb' && PAGE_NAME != 'project_menu' && PAGE_NAME != 'search_project_menu' && PAGE_NAME != 'ajax_case_menu' && !in_array(PAGE_NAME, array('recent_projects', 'recent_milestones', 'statistics', 'usage_details', 'task_progress', 'task_types', 'leader_board'))) {
//                $this->loadModel('Timezone');
                $timezn = $this->Timezone->find('first', array('conditions' => array('Timezone.id' => SES_TIMEZONE), 'fields' => array('Timezone.gmt_offset', 'Timezone.dst_offset', 'Timezone.code')));
                //Commented 01/09/2021
                //$user_dst = $this->User->getUserFields(array('User.id' =>$this->Auth->User("id")), array('id','is_dst'));
                if (!defined('TZ_GMT')) {
                    define('TZ_GMT', $timezn['Timezone']['gmt_offset']);
                }
                if (isset($user_profile['User']['is_dst'])) {
                    if (!defined('TZ_DST')) {
                        define('TZ_DST', $user_profile['User']['is_dst']);
                    }
                } else {
                    if (!defined('TZ_DST')) {
                        define('TZ_DST', $timezn['Timezone']['dst_offset']);
                    }
                }
                if (!defined('TZ_CODE')) {
                    define('TZ_CODE', $timezn['Timezone']['code']);
                }
            }

            //Excluding below functionality from ajax calls
            if (!strstr(PAGE_NAME, "ajaX") && !in_array($this->action, $ajax_action_exclude)) {
                ##### Set Privilege for User Access
                $this->loadModel('CompanyHoliday');
                $holidayListsGlobal = $this->CompanyHoliday->find('all', array('fields'=>array('holiday'),'conditions'=>array('company_id'=>SES_COMP,'or' => array('holiday >=' => GMT_DATETIME)),'order'=>array('created ASC')));
                $cho = array();
                $view = new View($this);
                $tz = $view->loadHelper('Tmzone');
                foreach ($holidayListsGlobal as $k=>$v) {
                    $cho[] = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['CompanyHoliday']['holiday'], "date");
                }
                $GLOBALS['company_holiday'] = implode(',', $cho);
                if (defined('DOWNTIME_WARN') && DOWNTIME_WARN) {
                    $mentain_time = Configure::read('MAINTENANCE_DTAE_TIME');
                    $dt_dwn_time = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $mentain_time[0], "datetime");
                    $dt_dwn_time_t = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $mentain_time[1], "datetime");
                    $this->set('downTimeDate', date('H:i', strtotime($dt_dwn_time)).' '.__('to').' '.date('H:i', strtotime($dt_dwn_time_t)).' '.__('on').' '.date('M d, Y', strtotime($dt_dwn_time_t)));
                }
            }
            if (!$this->Format->isAllowed('View Users')) { //SES_TYPE == 3
                if ((CONTROLLER == "users" && PAGE_NAME == "manage") || (CONTROLLER == "users" && PAGE_NAME == "add_new") || (CONTROLLER == "users" && PAGE_NAME == "add_template") || (CONTROLLER == "users" && PAGE_NAME == "manage_template")) {
                    $this->redirect(HTTP_ROOT . Configure::read('default_page'));
                }
            }

            if (PAGE_NAME == "dashboard") {
                if (isset($_GET['case']) && !isset($_GET['project'])) {
                    $this->redirect(HTTP_ROOT . "dashboard");
                } elseif (isset($_GET['case']) && isset($_GET['project'])) {
                    $caseUniq = urldecode($_GET['case']);
                    $countActCase = $this->Easycase->find('count', array('conditions' => array('Easycase.uniq_id' => $caseUniq, 'Easycase.isactive' => 1), 'fields' => 'Easycase.id'));
                    if (!$countActCase) {
                        $this->redirect(HTTP_ROOT . "dashboard");
                    }
                }
            }
            if (isset($_GET['project'])) {
                $projectUrl = trim(urldecode($_GET['project']));
                $project_id_crnt = $this->Project->getProjectFields(array('Project.uniq_id' => $projectUrl), array('id'));
                if ($project_id_crnt) {
                    $this->ProjectUser->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE project_id=" . $project_id_crnt['Project']['id'] . " AND user_id=" . SES_ID);
                }
            }
            ##### Get projects for Quick case switch case PRB-Doubt
            if (!strstr(PAGE_NAME, "ajaX") && !stristr(PAGE_NAME, "ajax_") && !in_array(PAGE_NAME, $ajaxPageArray) && !in_array(PAGE_NAME, $ajax_action_exclude)) {
                if (isset($_COOKIE['prjChangeId']) && !empty($_COOKIE['prjChangeId'])) {
                    $projDtl = $this->Project->getProjectFields(array("Project.uniq_id" => trim($_COOKIE['prjChangeId'])), array("Project.id","Project.uniq_id"));
                    $this->ProjectUser->updateAll(array('ProjectUser.dt_visited' => "'".GMT_DATETIME."'"), array('ProjectUser.user_id' => SES_ID, 'ProjectUser.project_id' => $projDtl['Project']['id']));
                    //unset($_COOKIE['prjChangeId']);
                    setcookie('prjChangeId', '', time() - 60 * 60 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
                }
//                $this->loadModel('ProjectUser');
                $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                $getallproj = $this->ProjectUser->query("SELECT DISTINCT Project.id,Project.uniq_id,Project.name,Project.default_assign,Project.project_methodology_id,ProjectMethodology.project_template_view_id FROM project_users AS ProjectUser,projects AS Project LEFT JOIN project_methodologies AS ProjectMethodology ON (Project.project_methodology_id = ProjectMethodology.id ) WHERE Project.id= ProjectUser.project_id AND ProjectUser.company_id='" . SES_COMP . "' AND ProjectUser.user_id=" . SES_ID . " AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' ORDER BY ProjectUser.dt_visited DESC");
                $getallprojForAdmin = $this->Project->query("SELECT DISTINCT Project.id,Project.uniq_id,Project.name FROM projects AS Project LEFT JOIN project_users AS ProjectUser ON (ProjectUser.project_id=Project.id)  WHERE Project.isactive='1' AND Project.company_id='" . SES_COMP . "' AND ProjectUser.company_id='" . SES_COMP . "' ORDER BY ProjectUser.dt_visited DESC");
                $this->set('getallprojForAdmin', $getallprojForAdmin);
                $GLOBALS['getallprojForAdmin'] = $getallprojForAdmin;
                $this->set('getallproj', $getallproj);
                $GLOBALS['getallproj'] = $getallproj;
                $sql = "SELECT DISTINCT Project.id,Project.uniq_id,Project.name,Project.default_assign, ProjectUser.dt_visited FROM project_users AS ProjectUser,projects AS Project WHERE Project.id= ProjectUser.project_id AND ProjectUser.user_id=" . SES_ID . " AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' order by ProjectUser.dt_visited DESC limit 1";
                $getlatestproj = $this->ProjectUser->query($sql);
                $latestprojuniqid = $getlatestproj['0']['Project']['uniq_id'];
                $GLOBALS['projUniqid'] = $latestprojuniqid;
                // pr($GLOBALS['projUniqid']);
                // exit;

                $GLOBALS['curProjId'] = $getlatestproj[0]['Project']['id'];
                $GLOBALS['projUniq'] = $getlatestproj[0]['Project']['uniq_id'];
                $project_id_map = array();
                foreach ($getallproj as $k=>$v) {
                    $project_id_map[$v['Project']['uniq_id']] = $v['Project']['id'];
                }
                $GLOBALS['project_id_map'] = $project_id_map;

                if ($getallproj) {
                    $_SESSION['project_methodology'] = $this->Format->getPMethodology($getallproj[0]['Project']['project_methodology_id']);
                    $_SESSION['project_template_view_id'] = $getallproj[0]['ProjectMethodology']['project_template_view_id'];
                } else {
                    $_SESSION['project_methodology'] = 'simple';
                    $_SESSION['project_template_view_id'] = 1;
                }
                if (PAGE_NAME =='launchpad' && CONTROLLER == 'users') {
                    Cache::delete('userRole'.SES_COMP.'_'.SES_ID);
                    $roleInfo = $roleAccess = $module_list = $userRoleAccess = $rolelist = array();
                } else {
                    if (Cache::read('userRole'.SES_COMP.'_'.SES_ID) === false) {
                        $this->Format->getCachedRoleInfo();     //$_COOKIE['CPUID']
                    }

                    $roleInfo = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
                                       
                    $roleAccess = $roleInfo['roleAccess'];
                    $module_list = $roleInfo['module_list'];
                    $userRoleAccess = $roleInfo['userRoleAccess'];
                    $Role = ClassRegistry::init('Role');
                    $rolelist = $Role->find('list', array('conditions' => array('OR' => array('Role.company_id' =>SES_COMP, 'Role.id' => array('2', '3', '4','699'))), 'fields' => array('Role.id', 'Role.role'), 'order' => 'Role.company_id ASC'));
                }
                $this->set('roleAccess', $roleAccess);
                $this->set('module_list', $module_list);
                $this->set('userRoleAccess', $userRoleAccess);
                $this->set('rolelist', $rolelist);
                //Get owners and admins for Create New project pop
//                $this->loadModel('User');
                $projOwnAdmin = $this->User->getProjectOwnAdmin();
                $this->setOCDetail();
                //if ($this->Auth->User('istype') == 3) { commented on 28/04/2017
                if (SES_TYPE == 3) {
//                    $this->loadModel('User');
                    //$data_user = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->User('id'))));
                    $data_user = $user_profile;
                    $temp_array['User']['name'] = $data_user['User']['name'];
                    $temp_array['User']['last_name'] = $data_user['User']['last_name'];
                    $temp_array['User']['id'] = $this->Auth->User('id');
                    $temp_array['User']['short_name'] = $data_user['User']['short_name'];
                    $temp_array['CompanyUser']['user_type'] = SES_TYPE;
                    if ($projOwnAdmin) {
                        array_unshift($projOwnAdmin, $temp_array);
                    } else {
                        $projOwnAdmin = $temp_array;
                    }
                }
                $GLOBALS['projOwnAdmin'] = $projOwnAdmin;
            }
            //SET OR DEFINE DEFAULT TASK VIEW
            $this->loadModel('DefaultTaskView');
            $default_view = $this->DefaultTaskView->readDTVDetlfromCache(SES_COMP, SES_ID);
            $deftview_value = (isset($default_view['DefaultTaskView']['default_view_id']) && !empty($default_view['DefaultTaskView']['default_view_id']))? $default_view['DefaultTaskView']['default_view_id'] :0;
            switch ($default_view['DefaultTaskView']['default_view_id']) {
                case 10:
                    $deftview = 'tasks';
                    break;
                case 11:
                    $deftview = 'kanban';
                    break;
                case 12:
                    $deftview = 'taskgroup';
                    break;
                case 13:
                    $deftview = 'milestonelist';
                    break;
                default:
										$deftview = 'tasks';
                    //$deftview = 'taskgroups';
                    break;
            }
            switch ($default_view['DefaultTaskView']['task_view_id']) {
                case 1:
                    $view = 'tasks';
                    break;
                case 2:
                    $view = 'task_group';
                 //   $view = 'taskgroups';
                    break;
                case 14:
                    $view = 'taskgroups';
                    break;
                default:
                    //$view = 'taskgroups';
                   $view = 'tasks';
                    break;
            }
            switch ($default_view['DefaultTaskView']['timelog_view_id']) {
                case 4:
                    $timelogview = 'calendar_timelog';
                    break;
                case 5:
                    $timelogview = 'timelog';
                    break;
                default:
                    $timelogview = 'timelog';
                    break;
            }
            switch ($default_view['DefaultTaskView']['kanban_view_id']) {
                case 6:
                    $kanbanview = 'milestonelist';
                    break;
                case 7:
                    $kanbanview = 'kanban';
                    break;
                default:
                    $kanbanview = 'kanban';
                    break;
            }
            switch ($default_view['DefaultTaskView']['project_view_id']) {
                case 8:
                    $projectview = 'manage';
                    break;
                case 9:
                    $projectview = 'active-grid';
                    break;
                default:
                    $projectview = 'manage';
                    break;
            }
            if ($_SESSION['project_methodology'] == 'scrum') {
                $view = 'backlog';
                $deftview = 'backlog';
                if ($_COOKIE['ALL_PROJECT'] == 'all') {
                    $view = 'tasks';
                    $deftview = 'tasks';
                }
            } elseif ($_SESSION['project_methodology'] == 'kanban') {
                $view = 'kanban';
                $deftview = 'kanban';
                if ($_COOKIE['ALL_PROJECT'] == 'all') {
                    $view = 'tasks';
                    $deftview = 'tasks';
                }
            } elseif ($_SESSION['project_methodology'] != 'simple') {
                if ($view=='taskgroups') {
                    $view = 'taskgroups';
                    $deftview = 'taskgroups';
                } else {
                    $view = 'kanban';
                    $deftview = 'kanban';
                }
                if ($_COOKIE['ALL_PROJECT'] == 'all') {
                    $view = 'tasks';
                    $deftview = 'tasks';
                }
            }
            if (!$this->Format->isAllowed('View Milestones')) {
                if ($view == 'task_group') {
                    $view == 'tasks';
                }
            }
            if ($default_view['DefaultTaskView']['user_id'] == SES_ID || empty($default_view['DefaultTaskView']['user_id'])) {
                if (!defined('DEFAULT_TASKVIEW')) {
                    define('DEFAULT_TASKVIEW', $view);
                }
                if (!defined('DEFAULT_KANBANVIEW')) {
                    define('DEFAULT_KANBANVIEW', $kanbanview);
                }
                if (!defined('DEFAULT_TIMELOGVIEW')) {
                    define('DEFAULT_TIMELOGVIEW', $timelogview);
                }
                if (!defined('DEFAULT_PROJECTVIEW')) {
                    define('DEFAULT_PROJECTVIEW', $projectview);
                }
                if (!defined('DEFAULT_VIEW_TASK')) {
                    define('DEFAULT_VIEW_TASK', $deftview);
                }
                if (!defined('DEFAULT_VIEW_VALUE')) {
                    define('DEFAULT_VIEW_VALUE', $deftview_value);
                }
            }
						
            // ######### jyoti Archive section start #########
            if (CONTROLLER == 'archives' && PAGE_NAME == 'listall') {
                if (!defined('PARAM_ARC')) {
                    define('PARAM_ARC', $this->params['pass']['0']);
                }
//                $this->loadModel('ProjectUser');
                $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                if (strpos($_SERVER['REQUEST_URI'], 'caselist')) {
                    $projAll1 = $this->ProjectUser->query("select distinct Project.id,Project.name,Project.uniq_id, (select count(distinct id) from easycases where easycases.project_id=Project.id and istype='1' and isactive='0' and user_id=" . SES_ID . ") as count FROM projects as Project,project_users as ProjectUser where ProjectUser.project_id=Project.id and  ProjectUser.user_id=" . SES_ID . " and Project.isactive = 1 and Project.company_id = '" . SES_COMP . "' order by ProjectUser.dt_visited DESC");
                } elseif (strpos($_SERVER['REQUEST_URI'], 'filelist')) {
                    $projAll1 = $this->ProjectUser->query("select distinct Project.id,Project.name,Project.uniq_id, (SELECT COUNT(Easycase.id) as count FROM easycases as Easycase,case_files as CaseFile WHERE Easycase.id=CaseFile.easycase_id AND Easycase.isactive=1 AND CaseFile.isactive =0 AND Easycase.user_id=" . SES_ID . " AND Easycase.project_id = Project.id) as count FROM projects as Project,project_users as ProjectUser where ProjectUser.project_id=Project.id and  ProjectUser.user_id=" . SES_ID . " and Project.isactive = 1 and Project.company_id ='" . SES_COMP . "' order by ProjectUser.dt_visited DESC");
                } elseif (strpos($_SERVER['REQUEST_URI'], 'milestonelist')) {
                    if (SES_TYPE == 1 || SES_TYPE == 2) {
                        $projAll1 = $this->ProjectUser->query("select distinct Project.id,Project.name,Project.uniq_id, (SELECT COUNT(Milestone.id) as count FROM milestones as Milestone WHERE Milestone.isactive=0 AND Milestone.company_id ='" . SES_COMP . "' AND Milestone.project_id = Project.id) as count FROM projects as Project,project_users as ProjectUser where ProjectUser.project_id=Project.id and  ProjectUser.user_id=" . SES_ID . " and Project.isactive = 1 and Project.company_id ='" . SES_COMP . "' order by ProjectUser.dt_visited DESC");
                    } else {
                        $projAll1 = $this->ProjectUser->query("select distinct Project.id,Project.name,Project.uniq_id, (SELECT COUNT(Milestone.id) as count FROM milestones as Milestone WHERE Milestone.	user_id ='" . SES_ID . "' AND Milestone.isactive=0 AND Milestone.company_id ='" . SES_COMP . "' AND Milestone.project_id = Project.id) as count FROM projects as Project,project_users as ProjectUser where ProjectUser.project_id=Project.id and  ProjectUser.user_id=" . SES_ID . " and Project.isactive = 1 and Project.company_id ='" . SES_COMP . "' order by ProjectUser.dt_visited DESC");
                    }
                }
                $this->set('projAll', $projAll1);
            }
            // ######### jyoti Archive section end #########

            $casePriority = array(0 => "Top", 1 => "High", 2 => "Medium", 3 => "Low", 4 => "Very Low", 5 => "Very Very Low");
            $this->set('casePriority', $casePriority);
            $proj_page_arr = array('dashboard', 'milestone', 'milestonelist', 'activity', 'glide_chart', 'chart', 'hours_report', 'mydashboard', 'dhtmlxgantt');
            if (in_array(PAGE_NAME, $proj_page_arr)) {
                $caseUrl = "";
                $urllvalue = 0;
                $urllvalueCase = 0;
                $projUniq = "";
                $projName = "";
                if (count($getallproj) == 1) {
                    $allpj = $getallproj[0]['Project']['uniq_id'];
                } else {
                    if ($_COOKIE['ALL_PROJECT']) {
                        $allpj = $_COOKIE['ALL_PROJECT'];
                    } elseif (PAGE_NAME == 'mydashboard' && SES_TYPE == 3 && empty($this->Auth->user('isdashboard'))) {
                        $allpj = "all";
                    } else {
                        $allpj = "";
                    }
                }
                if (isset($_GET['project'])) {
                    $projectUrl = trim(urldecode($_GET['project']));
                    $conditions = array(
                        'conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.uniq_id' => $projectUrl),
                        'fields' => array('DISTINCT Project.uniq_id', 'Project.name', 'Project.id', 'Project.default_assign'),
                        'order' => array('ProjectUser.dt_visited DESC')
                    );
					$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                    $prjs = $this->ProjectUser->find('first', $conditions);
                    if (is_array($prjs) && count($prjs)) {
                        $curProjId = $prjs['Project']['id'];
                        $projUniq = $prjs['Project']['uniq_id'];
                        $projName = $prjs['Project']['name'];
                        $defaultAssign = $prjs['Project']['default_assign'];
                        $_SESSION['project_methodology'] = $this->Format->getPMethodology($prjs['Project']['project_methodology_id']);
                        $urllvalue = 1;
                        if (isset($_GET['case']) && $_GET['case']) {
                            $caseUrl = trim(urldecode($_GET['case']));
                            $urllvalueCase = 1;
                        }
                    } else {
                        $this->redirect(HTTP_ROOT . Configure::read('default_page'));
                        $urllvalue = 0;
                    }
                }

                if ($urllvalue == 0 && $allpj == "") {
                    $conditions2 = array(
                        'conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP),
                        'fields' => array('DISTINCT Project.uniq_id', 'Project.name', 'Project.id'),
                        'order' => array('ProjectUser.dt_visited DESC'),
                        'limit' => 1
                    );

                    $projects = $this->ProjectUser->query("SELECT DISTINCT Project.uniq_id,Project.name,Project.id,Project.default_assign FROM project_users AS ProjectUser,projects AS Project WHERE Project.id= ProjectUser.project_id AND ProjectUser.user_id=" . SES_ID . " AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' ORDER BY ProjectUser.dt_visited DESC LIMIT 0,1");

                    if (count($projects)) {
                        $curProjId = $projects[0]['Project']['id'];
                        $projUniq = $projects[0]['Project']['uniq_id'];
                        $projName = $projects[0]['Project']['name'];
                        $defaultAssign = $projects[0]['Project']['default_assign'];
                        $GLOBALS['curProjId'] = $curProjId;
                         $GLOBALS['projUniq'] = $projUniq;
                    }
                }
                if ($allpj == "all") {
                    $curProjId = "all";
                    if (isset($_GET['project']) && isset($projUniq)) {
                        $projUniq = $projUniq;
                        $projName = $projName;
                        $defaultAssign = $defaultAssign;
                    } else {
                        $projUniq = "all";
                        $projName = "All";
                    }
                } elseif (!isset($_GET['project'])) {
                    $curProjId = $getallproj[0]['Project']['id'];
                    $projUniq = $getallproj[0]['Project']['uniq_id'];
                    $projName = $getallproj[0]['Project']['name'];
                    $defaultAssign = $getallproj[0]['Project']['default_assign'];
                    $GLOBALS['curProjId'] = $curProjId;
                    $GLOBALS['projUniq'] = $projUniq;
                }
                $this->set('sh_status', $this->Cookie->read('SH_STATUS'));
                $this->set('sh_member', $this->Cookie->read('SH_MEM'));
                $this->set('sh_pri', $this->Cookie->read('SH_PRI'));
                $this->set('sh_sts', $this->Cookie->read('SH_STS'));
                $this->set('sh_top', $this->Cookie->read('SH_TOP'));
                $this->set('sh_proj', $this->Cookie->read('SH_PROJ'));
                $this->set('sh_typ', $this->Cookie->read('SH_TYPE'));
                $this->set('curProjId', $curProjId);
                $this->set('projUniq', $projUniq);
                $this->set('defaultAssign', $defaultAssign);
                $this->set('projName', $projName);
                $this->set('urllvalue', $urllvalue);
                $this->set('urllvalueCase', $urllvalueCase);
                $this->set('caseUrl', $caseUrl);
            }
            if (PAGE_NAME == 'dashboard' && CONTROLLER == 'easycases') {
                
                // if (in_array('Task', $module_list)) {
                   
                // } else {
                //     $this->Session->write("ERROR", "You do not have permission to access Task Page");
                //     $this->redirect(HTTP_ROOT . "users/profile");
                // }
            }
            if (PAGE_NAME == 'settings' && CONTROLLER == "invoices") {
                if (!$this->Format->isAllowed('View Invoice Setting', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            if (PAGE_NAME == 'importexport' && CONTROLLER == "projects") {
                if (!$this->Format->isAllowed('View Import Export', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            if (PAGE_NAME == 'invoice' && CONTROLLER == "invoices") {
                if (!$this->Format->isAllowed('View Invoices', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            //  echo PAGE_NAME;exit;
            if (PAGE_NAME == 'mydashboard' && CONTROLLER == 'easycases') {
                if (!$this->Format->isAllowed('View Dashboard', $roleAccess)) {
                    //$this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
           
            if (PAGE_NAME == 'manage' && CONTROLLER == 'users') {
                if (!$this->Format->isAllowed('View Users', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            
           
            if (PAGE_NAME == 'dhtmlxgantt' || PAGE_NAME=='ganttv2' && CONTROLLER == 'Ganttchart') {
                if (!$this->Format->isAllowed('View Gantt Chart', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            if (PAGE_NAME == 'manage' && CONTROLLER == 'projects') {
                if (!$this->Format->isAllowed('View Project', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            if (in_array(PAGE_NAME, ['time_log']) && CONTROLLER == 'LogTimes') {
                if (!$this->Format->isAllowed('Manual Time Entry', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            if (in_array(PAGE_NAME, ['resource_utilization', 'time_log']) && CONTROLLER == 'LogTimes') {
                if (!$this->Format->isAllowed('View Resource Utilization', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
            if (in_array(PAGE_NAME, ['resource_availability']) && CONTROLLER == 'LogTimes') {
                if (!$this->Format->isAllowed('View Resource Availability', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }

            if (PAGE_NAME == 'folder_file' && CONTROLLER == 'Documents') {
                if (!$this->Format->isAllowed('View File', $roleAccess)) {
                    $this->Session->write("ERROR", "You do not have permission to access this page");
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
                
            $GLOBALS['roleAccess'] = $roleAccess;

            $this->set('rollEnabled', $rollEnabled);
            /* Get the Menu Section Here */
            $this->Format->setLeftMenu();


            /* End */

            /* End */
            if ($_COOKIE['SEARCH']) {
                unset($_COOKIE['SEARCH']);
                $caseSearch = "";
            }
            if (isset($_GET['search']) && urldecode(trim($_GET['search']))) {
                $caseSearch = urldecode(trim($_GET['search']));
                setcookie('SEARCH', $caseSearch, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
            } elseif ($_COOKIE['SEARCH']) {
                $caseSearch = $_COOKIE['SEARCH'];
            } elseif (isset($_REQUEST['case']) && urldecode(trim($_REQUEST['case'])) && isset($_REQUEST['project']) && urldecode(trim($_REQUEST['project'])) && !isset($_GET['search']) && !isset($_COOKIE['SEARCH'])) {
                $case = urldecode(trim($_REQUEST['case']));
//                $this->loadModel('Easycase');
                $case_no = $this->Easycase->getCaseNo($case);
                $caseSearch = "#" . $case_no['Easycase']['case_no'];
                setcookie('SEARCH', $caseSearch, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
            } else {
                $caseSearch = "";
            }
            $this->set('srch_text', $caseSearch);

            if (isset($_GET['case_no']) && urldecode(trim($_GET['case_no']))) {
                $case_num = urldecode(trim($_GET['case_no']));
                setcookie('CASESRCH', $case_num, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
            } elseif ($_COOKIE['CASESRCH']) {
                $case_num = $_COOKIE['CASESRCH'];
            } else {
                $case_num = "";
            }
            $this->set('case_num', $case_num);
            if (PAGE_NAME == "download" && CONTROLLER != 'defects') {
                $filename = substr(strrchr($_GET['url'], "/"), 1);
                if (!isset($filename) || empty($filename)) {
                    $var = "<table align='center' width='100%'><tr><td style='font:normal 14px verdana;color:#FF0000;' align='center'>Please specify a file name for download.</td></tr></table>";
                    die($var);
                }
                if (!file_exists(DIR_CASE_FILES . $filename)) {
                    $var = "<table align='center' width='100%'><tr><td style='font:normal 14px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
                    die($var);
                }
                $chkProject = 0;
//                $this->loadModel('CaseFile');
                $getCaseId = $this->CaseFile->find('first', array('conditions' => array('CaseFile.file' => $filename), 'fields' => array('CaseFile.easycase_id')));

                if (isset($getCaseId['CaseFile']['easycase_id']) && $getCaseId['CaseFile']['easycase_id']) {
                    $caseid = $getCaseId['CaseFile']['easycase_id'];
//                    $this->loadModel('Easycase');
                    $getProj = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $caseid, 'Easycase.isactive' => 1), 'fields' => array('Easycase.project_id')));

                    if (count($getCaseId)) {
                        $projid = $getProj['Easycase']['project_id'];

//                        $this->loadModel('ProjectUser');
                        $conditions = array(
                            'conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.id' => $projid),
                            'fields' => 'DISTINCT Project.id'
                        );
                        $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                        $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                        $chkProject = $this->ProjectUser->find('count', $conditions);
                    }
                    if ($chkProject == 0) {
                        $var = "<table align='center' width='100%'><tr><td style='font:normal 14px verdana;color:#FF0000;' align='center'>Oops! File cannot be download.<br/> You might not have access to download the file</td></tr></table>";
                        die($var);
                    }
                }
            }
            if (PAGE_NAME == "downloadImgFile" && CONTROLLER != 'defects') {
                $filename = substr(strrchr($_GET['url'], "/"), 1);

                if (!isset($filename) || empty($filename)) {
                    $var = "<table align='center' width='100%'><tr><td style='font:normal 14px verdana;color:#FF0000;' align='center'>Please specify a file name for download.</td></tr></table>";
                    die($var);
                }
                if (!file_exists(DIR_CASE_FILES . $filename)) {
                    $var = "<table align='center' width='100%'><tr><td style='font:normal 14px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
                    die($var);
                }
                $chkProject = 0;
//                $this->loadModel('CaseFile');
                $getCaseId = $this->CaseFile->find('first', array('conditions' => array('CaseFile.file' => $filename), 'fields' => array('CaseFile.easycase_id')));

                if (isset($getCaseId['CaseFile']['easycase_id']) && $getCaseId['CaseFile']['easycase_id']) {
                    $caseid = $getCaseId['CaseFile']['easycase_id'];
//                    $this->loadModel('Easycase');
                    $getProj = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $caseid, 'Easycase.isactive' => 1), 'fields' => array('Easycase.project_id')));

                    if (count($getCaseId)) {
                        $projid = $getProj['Easycase']['project_id'];

//                        $this->loadModel('ProjectUser');
                        $conditions = array(
                            'conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.id' => $projid),
                            'fields' => 'DISTINCT Project.id'
                        );
                        $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                        $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                        $chkProject = $this->ProjectUser->find('count', $conditions);
                    }
                    if ($chkProject == 0) {
                        $var = "<table align='center' width='100%'><tr><td style='font:normal 14px verdana;color:#FF0000;' align='center'>Oops! File cannot be download.<br/> You might not have access to download the file</td></tr></table>";
                        die($var);
                    }
                }
            }
            if (PAGE_NAME != 'image_thumb' && PAGE_NAME != 'project_menu' && PAGE_NAME != 'search_project_menu' && PAGE_NAME != 'ajax_case_menu' && !in_array(PAGE_NAME, array('to_dos', 'recent_projects', 'recent_activities', 'recent_milestones', 'statistics', 'task_progress', 'task_types', 'leader_board', 'ajax_activity'))) {
                //Checking if the company status is active or not
                if (($getAppComp[0]['Company']['is_active'] == '2' && $getAppComp[0]['CompanyUser']['user_type'] == 1) && ($this->params['action'] != 'upgrade_member' && $this->params['action'] != 'image_thumb' && $this->params['action'] != 'logout' && $this->params['action'] != 'company_name' && $this->params['action'] != 'company_detail' && $this->params['controller'] != 'pages' && $this->params['action'] != 'change_password' && $this->params['action'] != 'users_subscription' && $this->params['action'] != 'termsofservice' && $this->params['action'] != 'pricing' && $this->params['action'] != 'downgrade' && $this->params['action'] != 'downgrade_subscription' && $this->params['action'] != 'customer_support' && $this->params['action'] !='validateCoupon')) {

                    //$sub_chk_redirct = $this->UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
                    $sub_chk_redirct = $this->UserSubscription->readSubDetlfromCache(SES_COMP);
                    if (PAGE_NAME != 'launchpad') {
                        if ($sub_chk_redirct['UserSubscription']['subscription_id'] == CURRENT_FREE_PLAN) {
                            $this->redirect(array('controller' => 'users', 'action' => 'pricing'));
                        } else {
                            $this->redirect(array('controller' => 'users', 'action' => 'upgrade_member'));
                        }
                    }
                } elseif (SES_TYPE <= 3) {
//                    $project_cls = ClassRegistry::init('Project');
                    $prjlist = $this->Project->find('list', array('conditions' => array('company_id' => SES_COMP), 'fields' => array('id', 'name')));
                    $prjcnt = $prjlist ? count($prjlist) : 0;
                    $GLOBALS['project_count'] = $prjcnt;
                    $GLOBALS['active_proj_list'] = $prjlist;


                    $is_active_proj = (isset($is_skipped) && trim($is_skipped)) ? $is_skipped : $prjcnt;
                    $this->set('is_active_proj', $is_active_proj);
                    $this->set('active_proj_list', $prjlist);

                    $notforonboard_pages = array('skipOnbording', 'help', 'emailUpdate', 'default_inner', 'hide_default_inner', 'ajax_new_project', 'launchpad', 'googleConnect','syncGoogleCalendar', 'ajax_check_project_exists',
                        'check_fordisabled_user', 'onbording', 'ajax_quickcase_mem', 'ajax_case_menu', 'ajax_project_size', 'member_list',
                        'ajax_check_size', 'new_user', 'getProjects', 'add_project', 'logout', 'ajax_check_user_exists', 'image_thumb', 'ajax_recent_case',
                        'ajax_custom_filter_show', 'post_support_inner', 'session_maintain','getting_started','all_task_templates','all_project_templates','ajax_add_template_module','checkToken','onBoard','saveUserData','onBoardInvites','done_cropimage','show_preview_img','checkprojectcounts','gitconnect');

                    if (!$is_skipped) {
                        $skipforonboard_pages = array('case_list', 'file_list', 'manage_milestone', 'ajax_milestonelist', 'ajax_new_milestone', 'ajax_overdue',
                            'ajax_upcoming', 'case_project', 'case_files', 'ajax_common_breadcrumb', 'ajax_case_status', 'usage_details');
                        $notforonboard_pages = array_merge($notforonboard_pages, $skipforonboard_pages);
                    }

                    $onuser_pages = array('account_activity', 'transaction', 'creditcard', 'subscription', 'profile', 'changepassword',
                        'email_notifications', 'show_preview_img', 'done_cropimage', 'pricing', 'success_story','contact_support','choose_orangescrum','extendtrialdrip','timesheet_templates','excel_projt_templates','excel_gc_templates','excel_invo_templates','all_free_templates','about_timesheet','captcha1','rendCaptcha','validateCaptcha','compareos','tutorial','free_template_download', 'feed', 'termsofservice', 'confirmationPage', 'upgrade', 'resend_confemail', 'confirmation', 'cancel_account', 'cancel_subscription', 'check_password', 'upgrade_member', 'edit_creditcard', 'download_invoice', 'sendTransInvoiceEmail', 'invoicePage', 'downgrade', 'downgrade_subscription', 'os_rev_from_self','create_project','validateCoupon','users_subscription','community_addon_download','alternative_asana','alternative_jira','alternative_openproject','alternative_wrike','alternative_google_task','downloadTutorialPdf','sendTutorialAttachement');
                    if (SES_TYPE <= 2) {
                        $isactpaid = $this->is_user_activepaid();
                        if (PAGE_NAME == 'update_migration' || PAGE_NAME == 'migration') {
                            $isactpaid = 1;
                        }
                        if ($isactpaid && !$prjcnt && (PAGE_NAME == 'invoicePage' || PAGE_NAME == 'sendTransInvoiceEmail' || PAGE_NAME == 'update_migration' || PAGE_NAME == 'migration')) {
                            //return true;
                        } elseif (!$is_skipped && !$prjcnt && (!in_array(PAGE_NAME, $notforonboard_pages)) && (CONTROLLER != 'users' || !in_array(PAGE_NAME, $onuser_pages))) {
                            if (($this->request->params['action'] =='dashboard' && isset($this->request->query['first_login']) && $this->request->query['first_login']==1)) {
//                                setcookie('FIRST_LOGIN_1', 1,  time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                            } else {
                                $this->redirect(HTTP_ROOT . 'onbording');
                            }
                        }
                    }
                }
                if (!strstr(PAGE_NAME, "ajaX") && !in_array($this->action, $ajax_action_exclude)) {
                    $this->betauser_limitation();
                }

                if (!strstr(PAGE_NAME, "ajaX") && !stristr(PAGE_NAME, "ajax_") && !in_array(PAGE_NAME, $ajaxPageArray) && !in_array($this->action, $ajax_action_exclude)) {
                    /* Create Task Starts */

//                    $this->loadModel('Easycase');
                    if (count($getallproj)) {
                        if (PAGE_NAME == "dashboard" && $projName != 'All') {
                            $ctProjUniq = $projUniq;
                        } elseif (count($getallproj) >= 1) {
                            $ctProjUniq = $getallproj['0']['Project']['uniq_id'];
                        } else {
                            $ctProjUniq = '';
                        }
                    }
                    $projUser = array();
                    if ($ctProjUniq) {
                        $projUser = array($ctProjUniq => $this->Easycase->getMemebers($ctProjUniq));
                    }
                    $GLOBALS['projUser'] = $projUser;
                    $this->set('ctProjUniq', $ctProjUniq);

                    $All_compUser = $this->Easycase->getAllCompUsers(SES_COMP, SES_ID);
                    $GLOBALS['AllCompUser'] = $All_compUser;

                    //Getting Task templetes
                    $CaseTemplate = ClassRegistry::init('CaseTemplate');
                    $CaseTemplate->recursive = -1;
                    $getTmpl = $CaseTemplate->find('all', array(
                        'conditions' => array(
                            "OR" => array(
                                'AND' => array(
                                    'CaseTemplate.is_active' => 1,
                                    'CaseTemplate.company_id' => SES_COMP
                                )
                            )
                        ),
                        'fields' => array('id', 'name', 'description'),
                        'order' => 'CaseTemplate.name ASC'
                    ));
                    $GLOBALS['getTmpl'] = $getTmpl;
                    /* Create Task Ends */
                }
            }
        } else {
            //$downloadlink = HTTPS_HOME."free-download";
            $downloadlink = HTTP_HOME_ORG . "free-download";

            //$communitylink = HTTPS_HOME."community";
            $communitylink = HTTP_HOME_ORG . "community";

            //$roadmaplink = HTTPS_HOME."roadmap";
            $roadmaplink = HTTP_HOME_ORG . "roadmap";

            //$servicelink = HTTPS_HOME."services";
            $servicelink = HTTP_HOME_ORG . "services";
            $this->set(compact('downloadlink', 'communitylink', 'roadmaplink', 'servicelink'));


            /*             * ****** For Affiliate key ************** */
            if (!empty($this->request->query['affiliate_key']) && isset($this->request->query['affiliate_key'])) {
                setcookie("affiliated_code", $this->request->query['affiliate_key'], time() + 7776000, "/");
            }

            /*             * ****** For A/B Testing ************** */
            $abtest = "";
            $ablink = "";
            if (isset($this->request->query['ref'])) {
                $abtest = $this->request->query['ref'];
            }
            $this->set("abtest", $abtest);

            if ($abtest == "a") {
                $ablink = "/?ref=a";
            } elseif ($abtest == "b") {
                $ablink = "/?ref=b";
            } elseif ($abtest == "old") {
                $ablink = "/?ref=old";
            }
            $this->set("ablink", $ablink);

            /*             * **************************************** */

            $this->set('ses_signup', $this->Session->read("SES_SIGNUP"));
            $this->Session->write("SES_SIGNUP", "");
            $this->set('ses_email', $this->Session->read("SES_EMAIL"));
            $this->Session->write("SES_EMAIL", "");
            $this->set('login_error', $this->Session->read("LOGIN_ERROR"));
            $this->Session->write("LOGIN_ERROR", "");
            $this->set('error_reset', $this->Session->read("ERROR_RESET"));
            $this->Session->write("ERROR_RESET", "");
            $this->set('pass_succ', $this->Session->read("PASS_SUCCESS"));
            $this->Session->write("PASS_SUCCESS", "");
            $this->set('success', $this->Session->read("SUCCESS"));
            $this->set('error', $this->Session->read("ERROR"));
            $this->layout = 'default_outer';

            $this->Auth->autoRedirect = false;
            Security::setHash('md5');

            $this->Auth->authenticate = array('Form' => array('fields' => array('username' => 'email', 'password' => 'password')));
            $this->Auth->allow('home', 'gdrive', 'testnefield', 'updates', 'community_faq', 'lp_installation_guides', 'open_source_outer', 'mobile_app', 'site_map', 'slack_integration', 'invoice_how_it_works', 'time_login', 'consulting_details', 'os_premises', 'training', 'customization', 'get_involved', 'testimonial', 'contact_team', 'free_download', 'community', 'roadmap', 'services', 'unsubscribe', 'request_demo', 'send_mail_to_customers', 'checksubscription_cron', 'validate_emailurl', 'instantinvoice', 'eventLog', 'bttransaction', 'create_btprofile', 'register_user', 'login', 'pricing', 'success_story', 'contact_support', 'choose_orangescrum', 'extendtrialdrip', 'timesheet_templates', 'excel_projt_templates', 'excel_gc_templates', 'excel_invo_templates', 'all_free_templates', 'about_timesheet', 'captcha1', 'rendCaptcha', 'validateCaptcha', 'compareos', 'tutorial', 'free_template_download', 'feed', 'displayStorage', 'display', 'signup', 'give_away', 'get_mobile_device', 'watch_demo', 'gdpr_rule', 'all_features', 'termsofservice_refer', 'refer_a_friend', 'register', 'forgotpassword', 'feedback', 'contactnow', 'ajax_totalcase', 'ajax_get_referrer_cookie', 'ajax_set_referrer_cookie', 'price', 'privacypolicy', 'securities', 'affiliates', 'aboutus', 'tour', 'termsofservice', 'latest', 'update_email', 'dailyupdate_notifications', 'registration', 'check_short_name_reg', 'ajax_registration', 'confirmation', 'check_url_reg', 'check_email_reg', 'invitation', 'getlogin', 'session_maintain', 'post_support', 'invoicePage', 'sub_transaction', 'paypalipn', 'paypalipnreturn', 'thank_mail', 'lunchuser', 'help', 'googleConnect', 'syncGoogleCalendar', 'googleSignup', 'setGoogleInfo', 'emailUpdate', 'add_ons', 'installation_guide', 'install_windows', 'go_daddy', 'install_mac', 'local_setup', 'project_management', 'resource_utlization', 'gantt_chart', 'timelog', 'time_tracking', 'cost_tracking', 'task_groups', 'kanban_view', 'catch_up', 'invoicePdf', 'customer_support', 'nginx', 'addon_download_invoice', 'os_rev_from_self', 'enterprise_home', 'marketing_industry', 'it_industry', 'order_enterprise', 'community_installation_support', 'installation_download_invoice', 'sendEbookLink', 'user_build_form', 'create_project', 'contact_faq', 'timesheetPDF', 'resource_allocation_pdf', 'community_addon_download', 'pdfcase_project', 'task_management', 'os_v3', 'alternative_asana', 'alternative_jira', 'alternative_wrike', 'alternative_openproject', 'alternative_google_task', 'onboard_outer', 'register_user_outer', 'downloadTutorialPdf', 'sendTutorialAttachement', 'project_overview_pdf', 'unlimited_user', 'export_pdf_timelog', 'help_support', 'agile_pm', 'os_migration', 'pdfsprint_report', 'executive_demo', 'user_role_management', 'gcnotification', 'whats_new_update', 'resource_all', 'gcalendar_integration', 'custom_status_workflow', 'remote_team_management', 'agency_project_management', 'updategithubevents', 'sync', 'labelsync', 'gitconnect', 'gonetaplogin', 'os_press', 'product_videos', 'search_helpdesk', 'analytic_reports', 'project_templates', 'project_templates_scrum', 'project_templates_kanban', 'project_templates_bugtracker', 'project_templates_contentmgmt', 'project_templates_recruitment', 'project_templates_procurement', 'project_templates_simple', 'project_templates_tasktracking', 'ppc_landing','ppc_template','news_room', 'release', 'press_release_detail', 'press_release_detail_freetrial', 'press_release_detail_osv3', 'saveTraffic', 'thankyou', 'ajax_get_location', 'notify_me', 'allproduct', 'business_operations', 'professional_service', 'mention', 'work_management', 'workload_management', 'program_management', 'client_management','project_calendar','customers','build_vs_buy','custom_fields', 'verifySubDomain', 'ssoLogin','authenticateSaml', 'metadata', 'ssoLogin');
            $this->Session->write("SUCCESS", "");
            $this->Session->write("ERROR", "");
            if (PAGE_NAME == 'payment_details') {
                setcookie('redirect_page', 'payment_details', time() + (10 * 60));
            }
            if (PAGE_NAME == 'help' || strpos($_SERVER['REQUEST_URI'], 'help')) {
                setcookie('HELP', 1, $cookieTime, '/', DOMAIN_COOKIE, false, false);
            }
            if (PAGE_NAME == 'email_notification') {
                setcookie('CK_EMAIL_NOTIFICATION', 1, $cookieTime, '/', DOMAIN_COOKIE, false, false);
            }
            if (!in_array(PAGE_NAME, $this->Auth->allowedActions) && CONTROLLER !='v2_rests') {
                //$this->redirect(HTTP_HOME);
                if (CHECK_DOMAIN == "app") {
                    $this->redirect(HTTP_APP . "users/login");
                } elseif (CHECK_DOMAIN && CHECK_DOMAIN != "www") {
                    $this->Company->recursive = -1;
                    $seoarr = $this->Company->find('first', array('conditions' => array('Company.is_active' => 1, 'Company.seo_url' => CHECK_DOMAIN), 'fields' => array('Company.id')));
                    if (@$seoarr['Company']['id']) {
                        /** Redirect to getting started and resource availability and gantt chart **/
                        $rurl = "";
                        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
                        if (strpos($_SERVER['REQUEST_URI'], 'getting_started') > 0 || strpos($_SERVER['REQUEST_URI'], 'ganttchart/manage') > 0 || strpos($_SERVER['REQUEST_URI'], 'resource-availability') > 0) {
                            $rurl = $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                            if (strpos($_SERVER['REQUEST_URI'], 'resource-availability') > 0) {
                                setcookie('PLAYVIDEO', 1, time() + (10 * 60), '/', DOMAIN_COOKIE, false, false);
                            }
                        }
                        if ($rurl) {
                            setcookie('RURL', $rurl, time() + (10 * 60), '/', DOMAIN_COOKIE, false, false);
                        }
                        /** End code**/
                        $this->redirect(PROTOCOL . CHECK_DOMAIN . "." . DOMAIN . "users/login");
                    } else {
                        $this->redirect(HTTP_APP . "users/login");
                    }
                } else {
                    $this->redirect(HTTP_HOME);
                }
            }

            //feedback form
            $arrSubject = array("Suggestion", "Question", "Problem", "Other");
            $this->set('arrSubject', $arrSubject);
            if (CONTROLLER !='v2_rests') {
                if ($this->params['action'] != "project_overview_pdf") {
                    // Empty Session
                    if (!defined('SES_ID')) {
                        define('SES_ID', '');
                    }
                    if (!defined('SES_TYPE')) {
                        define('SES_TYPE', '');
                    }
                    if (!defined('SES_TIMEZONE')) {
                        define('SES_TIMEZONE', "");
                    }
                }
            }
            if (CHECK_DOMAIN && CHECK_DOMAIN != "app" && CHECK_DOMAIN != "www" && CONTROLLER !='v2_rests') {
                $this->Company->recursive = -1;
                $seoarr = $this->Company->find('first', array('conditions' => array('Company.is_active' => 1, 'Company.seo_url' => CHECK_DOMAIN), 'fields' => array('Company.id')));

                if (@$seoarr['Company']['id']) {
                    //$this->redirect(PROTOCOL.CHECK_DOMAIN.".".DOMAIN."dashboard");
                } else {
                    $this->redirect(HTTP_APP . "users/login");
                }
            }
        }
        if (!defined('PROJ_ID')) {
            define('PROJ_ID', $curProjId);
        }
        if (!defined('PROJ_UNIQ_ID')) {
            define('PROJ_UNIQ_ID', $projUniq);
        }
        if (!defined('projUniq')) {
            define('projUniq', $projUniq);
        }
        if (!defined('TOT_COMPANY')) {
            define('TOT_COMPANY', '');
        }
        //Excluding below functionality from ajax calls
        if (!strstr(PAGE_NAME, "ajaX") && !in_array($this->action, $ajax_action_exclude) || $this->action == 'ajax_common_breadcrumb') {
            if (@$_SESSION['SES_COMP'] || (defined('SES_COMP') && SES_COMP)) {
                $this->loadModel("TypeCompany");
                // PRB
                $comp_id = @$_SESSION['SES_COMP'];
                if ((defined('SES_COMP') && SES_COMP)) {
                    $comp_id = SES_COMP;
                }
                if ($_SESSION['project_methodology'] == 'scrum') {
                    $typeOrder = " Type.seq_order = 0,Type.seq_order=13 DESC,Type.seq_order=14 DESC,Type.project_id=0 DESC,Type.seq_order ASC ,Type.name ASC";
                } else {
                    $typeOrder = " Type.seq_order = 0,Type.project_id=0 DESC,Type.seq_order ASC ,Type.name ASC";
                }
                $sql = "SELECT Type.* FROM type_companies AS TypeCompany LEFT JOIN types AS Type ON (TypeCompany.type_id=Type.id)
    	     WHERE TypeCompany.company_id=" . $comp_id . " ORDER BY ".$typeOrder;
                $TypeCompany = $this->TypeCompany->query($sql);
            }
            if (isset($TypeCompany) && !empty($TypeCompany)) {
                $typeArr = $TypeCompany;
                $typeDflt = 1;
            } else {
                $typeDflt = 1;
                //$typeArr = Configure::read('DEFAULT_TASK_TYPES');
                if ($_SESSION['project_methodology'] == 'scrum') {
                    $typeOrder = " Type.seq_order = 0,Type.seq_order=13 DESC,Type.seq_order=14 DESC,Type.project_id=0 DESC,Type.seq_order ASC ,Type.name ASC";
                } else {
                    $typeOrder = " Type.seq_order = 0,Type.project_id=0 DESC,Type.seq_order ASC ,Type.name ASC";
                }
                $sql = "SELECT Type.* FROM types AS Type 
             WHERE Type.company_id=0 ORDER BY ".$typeOrder;
                $this->loadModel("Type");
                $typeArr = $this->Type->query($sql);
            }
        }
        $dashbord_itms = Configure::read('USER_DASHBOARD_ITEMS');
        if (SES_TYPE < 3) {
            $dashboardArr = $dashbord_itms[0];
        } elseif (SES_TYPE == 3) {
            $dashboardArr = $dashbord_itms[1];
        }
        $GLOBALS['DASHBOARD_ORDER'] = $dashboardArr;

        //Count notifications
        //$this->getNotificationCounts();

        //
        //Excluding below functionality from ajax calls
        if (!strstr(PAGE_NAME, "ajaX") && !in_array($this->action, $ajax_action_exclude)) {
            $plan_types = Configure::read('TYPES_PLAN');
            $this->set('plan_types', $plan_types);
            $GLOBALS['plan_types'] = $plan_types;
            $this->loadModel('EasycaseRelate');
            //$sql_relates = "SELECT EasycaseRelate.id,EasycaseRelate.title FROM easycase_relates AS EasycaseRelate WHERE EasycaseRelate.status = 1 ORDER BY EasycaseRelate.seq_id ASC";
            //$relates = $this->EasycaseRelate->query($sql_relates);
            $GLOBALS['RELATES'] = $this->EasycaseRelate->readERelateDetlfromCache();
        }
        //remove empty elements from aarray.
        $aryMain_type = @array_map(function ($val) {
            if (!empty($val['Type']['name'])) {
                return $val;
            }
        }, $typeArr);
        $aryMain_type = @array_values(@array_filter($aryMain_type));
        $GLOBALS['TYPE'] = $aryMain_type;
        
        //$GLOBALS['TYPE'] = $typeArr;
        $GLOBALS['TYPE_DEFAULT'] = $typeDflt;

        $industry_page = Configure::read('INDUSTRY_PAGES');
        if (in_array(PAGE_NAME, $industry_page)) {
            $this->loadModel('Industry');
						$industries = $this->Industry->getIndustries(CONTROLLER);
            $GLOBALS['industries'] = $industries;
            $this->set('industries', $industries);
        }
        if ($this->Auth->User('id')) {
            $this->User->recursive = -1;
            //$usrdata = $this->User->find('first', array('conditions' => array('User.id' => $this->Auth->User('id'))));
            $usrdata = $user_profile;
            $this->Set('usrdata', $usrdata);
            if ($this->request->data['type'] != 'inline') {
                if (SES_TYPE < 3) {
                    $user_subsons = $this->UserSubscription->readSubDetlfromCache(SES_COMP);
                    $next_bill_date = $user_subsons['UserSubscription']['next_billing_date'];
                    $ten_bill_date = date('Y-m-d h:i:s', strtotime("$next_bill_date +10 days"));
                    $view = new View($this);
                    $frmt = $view->loadHelper('Format');
                    $tz = $view->loadHelper('Tmzone');
                    $dt = $view->loadHelper('Datetime');
                    $locDT = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $ten_bill_date, "date");
                    $dateTime = date('F d, Y', strtotime($locDT));
                    if (!empty($user_subsons) && $user_subsons['UserSubscription']['is_updown'] == 4 && empty($this->Session->read('SUB_ERROR'))) {
                        $this->Set('sun_error', $dateTime);
                    }
                }
            }
        }
        if (file_exists(WWW_ROOT . 'error.check')) {
            unlink(WWW_ROOT . 'error.check');
        }
        /*         * ****New Code Added if more active tabs then check only 3  *********** */
        if (SES_ID && ACT_TAB_ID && ACT_TAB_ID > 1) {
            $tablists_check = Configure::read('DTAB');
            $s = 0;
            $checkIteraton = 1;
            foreach ($tablists_check as $tabkey => $tabvalue) {
                if ($tabkey & ACT_TAB_ID && $checkIteraton <= 3) {
                    $s += $tabkey;
                    $checkIteraton++;
                }
            }
//            $this->loadModel("User");
            $this->User->id = SES_ID;
            $this->User->saveField('active_dashboard_tab', $s);
            define('ACT_TAB_ID', $s);
        }

        //Excluding below functionality from ajax calls
        // if(!in_array($this->action,$ajax_action_exclude)){
        if ($this->params['action'] != "project_overview_pdf") {
            //$langArr = $this->User->find('first', array('conditions'=>array('id'=>SES_ID),'fields'=>array('language','time_format')));
            $langArr = $user_profile;
            $this->Session->write('Config.language', $langArr['User']['language']);
            $this->set('os_locale', $langArr['User']['language']);
            if (!defined('SES_TIME_FORMAT')) {
                define('SES_TIME_FORMAT', $langArr['User']['time_format']);
            }
            switch ($langArr['User']['language']) {
            case 'spa':
                $this->set('os_locale_short', 'es');
                 if (!defined('LANG_PREFIX')) {
                     define('LANG_PREFIX', '_spa');
                 }
                break;
            case 'por':
                $this->set('os_locale_short', 'pt');
                if (!defined('LANG_PREFIX')) {
                    define('LANG_PREFIX', '_por');
                }
                break;
            case 'deu':
                $this->set('os_locale_short', 'de');
                if (!defined('LANG_PREFIX')) {
                    define('LANG_PREFIX', '_deu');
                }
                break;
            case 'fra':
                $this->set('os_locale_short', 'fr');
                if (!defined('LANG_PREFIX')) {
                    define('LANG_PREFIX', '_fra');
                }
                break;
            default:
                $this->set('os_locale_short', 'en');
                if (!defined('LANG_PREFIX')) {
                    define('LANG_PREFIX', '');
                }
                break;
         }
        }
         
				//common component
        if ($this->Auth->user('id')) {
					$this->Commonapp->commonSetting(SES_COMP, SES_ID, $this);
        }
        $this->setEmailFooter();
    }
    public function initialize_slack_interface()
    {
			return 0;
    }
    public function do_action($slack, $action, $message='', $attachments='')
    {
			return true;
    }

    public function ajax_get_referrer_cookie()
    {
        $this->layout = '';
        if ($_COOKIE['REFERRER'] && (!stristr($_COOKIE['REFERRER'], "orangescrum.com") || stristr($_COOKIE['REFERRER'], "blog.orangescrum"))) {
            $json = json_encode($data);
            echo $_GET['callback'] . "(" . $json . ")";
        }
        exit;
    }
    public function setOCDetail()
    {
        $is_upgradedLic = $this->setOCDetailLices();
        $is_default = 1;
        if ($is_upgradedLic['status'] == 'YES' || $is_upgradedLic['type'] == '1') {
            $is_default = 0;
            $sub_chk_redirct = $this->UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
            if ($sub_chk_redirct) {
                if ($sub_chk_redirct['UserSubscription']['user_limit'] != $is_upgradedLic['u_cnt']) {
                    $sub_chk_redirct['UserSubscription']['user_limit'] = $is_upgradedLic['u_cnt'];
                    $this->UserSubscription->save($sub_chk_redirct);
                }
            }
        }
        if (file_exists(OCDPATH) && $is_default) {
            $currennt_pkg = parse_ini_file(OCDPATH, true);
            $u_count = ($currennt_pkg['package']['name'] == 'Professional')?'Unlimited':($currennt_pkg[$currennt_pkg['package']['name']]['user'])/strlen($currennt_pkg['package']['name']);
            $sub_chk_redirct = $this->UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
            if ($sub_chk_redirct) {
                if ($sub_chk_redirct['UserSubscription']['user_limit'] != $u_count) {
                    $sub_chk_redirct['UserSubscription']['user_limit'] = $u_count;
                    $this->UserSubscription->save($sub_chk_redirct);
                }
            }
        } else {
            //some one has deleted
        }
    }
    public function setOCDetailLices()
    {
        $key = OS_LICENSE_SALT;
        if (file_exists(WWW_ROOT.OS_LICENSE_SALT_FILE.'.txt')) {
            $handle = fopen(WWW_ROOT.OS_LICENSE_SALT_FILE.'.txt', 'r');
            $content = fread($handle, 4096);
            fclose($handle);
            $enc_key = explode('#########key-#####################', trim($content));
            $act_key = trim($enc_key[1], '\n ');
            //$decoded_cnt = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($act_key), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
            $decoded_cnt = explode('user', strtolower($this->User->convertLicenseKeyDocode($act_key)));
            $is_valid = Configure::read('VALID_USER_COUNT');
            if (in_array($decoded_cnt[0], $is_valid)) {
                return array('status'=>'YES','type'=>'1','u_cnt'=>$decoded_cnt[0]);
            } else {
                return array('status'=>'YES','type'=>'2');
            }
        }
        return array('status'=>'NO','type'=>'3');
    }
    public function ajax_set_referrer_cookie()
    {
        $this->layout = '';
        $referrer_cookie = $this->params->data['referrer_cookie'];
        if ($referrer_cookie) {
            setcookie('REFERRER', '', time() - 60 * 60 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
            setcookie('REFERRER', $referrer_cookie, time() + 60 * 60 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
        }
        echo $referrer_cookie . "---" . $_COOKIE['REFERRER'];
        exit;
    }

    public function setReferrer()
    {
        $referrer_link = "";
        if (!@$_COOKIE['REFERRER'] && (@$_SERVER['HTTP_REFERER'] || @$_GET['referrer'])) {
            if ($_GET['referrer']) {
                $referrer = urldecode($_GET['referrer']);
            } else {
                $referrer = @$_SERVER['HTTP_REFERER'];
            }
            if ($referrer && (!stristr($referrer, "orangescrum.com") || stristr($referrer, "blog.orangescrum"))) {
                //$ref_url = parse_url($referrer, PHP_URL_HOST);
                $parseurl = parse_url($referrer);
                if (stristr($parseurl['host'], "www.google.co") || stristr($referrer, "www.bing") || stristr($referrer, "search.yahoo")) {
                    $referrer = $parseurl['host'];
                } elseif (stristr($referrer, "utm_source") || stristr($referrer, "utm_medium")) {
                    parse_str($referrer['query'], $output);
                    if (isset($output['utm_source'])) {
                        $referrer = $output['utm_source'];
                    } elseif (isset($output['utm_medium'])) {
                        $referrer = $output['utm_medium'];
                    }
                }
                setcookie('REFERRER', $referrer, time() + 60 * 60 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
                if (stristr($_SERVER['SERVER_NAME'], "orangescrum.com")) {
                    $referrer_link = "?referrer=" . urlencode($referrer);
                }
            }
        } elseif (isset($_COOKIE['REFERRER']) && stristr($_SERVER['SERVER_NAME'], "orangescrum.com")) {
            $referrer_link = "?referrer=" . urlencode($_COOKIE['REFERRER']);
        }

        return $referrer_link;
    }

    public function session_maintain()
    {
        $this->layout = 'ajax';
        $sessionout = 0;
        if ($_COOKIE['USER_UNIQ']) {
            setcookie('USER_UNIQ', $_COOKIE['USER_UNIQ'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
            setcookie('USERTYP', $_COOKIE['USERTYP'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
            setcookie('USERTZ', $_COOKIE['USERTZ'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
        } else {
            $sessionout = 1;
        }
        echo $sessionout;
        exit;
    }

    /*     * ********* Image Thumb ********** */

    public function image_thumb()
    {
        $this->autoRender = false;

        $save_to_file = true;
        $image_quality = 100;
        $image_type = -1;
        $max_x = 100;
        $max_y = 100;
        $cut_x = 0;
        $cut_y = 0;
        $images_folder = '';
        $thumbs_folder = '';
        $to_name = '';

        if ($_REQUEST['type'] == "photos") {
            $images_folder = DIR_USER_PHOTOS;
            if (defined('USE_S3') && USE_S3 && urldecode($_REQUEST['file']) != 'user.png') {
                $images_folder = DIR_USER_PHOTOS_S3;
            }
        } elseif ($_REQUEST['type'] == "company") {
            $images_folder = DIR_FILES . 'company/';
            if (defined('USE_S3') && USE_S3) {
                $images_folder = DIR_USER_COMPANY_S3;
            }
        } elseif ($_REQUEST['type'] == "logo") {
            $images_folder = DIR_PROJECT_LOGO;
        } else {
            $images_folder = DIR_CASE_FILES;
        }
        if (isset($_REQUEST['nocache'])) {
            $save_to_file = intval($_REQUEST['nocache']) == 1;
        }
        if (isset($_REQUEST['file'])) {
            $from_name = urldecode($_REQUEST['file']);
        }
        if (isset($_REQUEST['dest'])) {
            $to_name = urldecode($_REQUEST['dest']);
        }
        if (isset($_REQUEST['quality'])) {
            $image_quality = intval($_REQUEST['quality']);
        }
        if (isset($_REQUEST['t'])) {
            $image_type = intval($_REQUEST['t']);
        }
        if (isset($_REQUEST['sizex'])) {
            $max_x = intval($_REQUEST['sizex']);
        }
        if (isset($_REQUEST['sizey'])) {
            $max_y = intval($_REQUEST['sizey']);
        }
        if (isset($_REQUEST['size'])) {
            $max_x = intval($_REQUEST['size']);
        }
        ini_set('memory_limit', '-1'); //echo $images_folder.$from_name;//exit;
        //$this->Image->GenerateThumbFile($images_folder.$from_name, $to_name,$max_x,$max_y);
        $this->Image->GenerateThumbFile($images_folder . $from_name, $to_name, $max_x, $max_y, $from_name);
    }

    public function files($type = 'cases', $files = null)
    {
        $this->layout = 'ajax';
        if ($type == 'photos') {
            $files = DIR_USER_PHOTOS . basename($files);
        } elseif ($type == 'company') {
            $files = DIR_FILES . 'company/' . basename($files);
        } else {
            $files = DIR_CASE_FILES . basename($files);
        }
        //$file_mime =  mime_content_type (DIR_CASE_FILES.basename($files));
        $file_mime = @finfo_file(finfo_open(FILEINFO_MIME_TYPE), $files);
        if ($file_mime) {
            header("Content-Type:$file_mime");
            header('Content-Disposition: attachment; filename=' . basename($files));
        }
        if (file_exists($files)) {
            readfile($files);
        } else {
            $var = "<table align='center' width='100%'><tr><td style='font:normal 14px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
            die($var);
        }
        exit;
    }

    public function _datestime()
    {
        if (gmdate('D', strtotime("now")) != "Fri") {
            $c = strtotime("next Friday");
            $re = gmdate('Y-m-d H:i:s', $c);
            $this->set('st', $re);
        } else {
            $re2 = gmdate('Y-m-d H:i:s', strtotime("now"));
            $this->set('st', $re2);
        }
        $timestamp = strtotime("now");
        $this->set('st1', gmdate('Y-m-d H:i:s', $timestamp));
        $timestamp = strtotime("next Monday");
        $this->set('st2', gmdate('Y-m-d H:i:s', $timestamp));
        $timestamp = strtotime("tomorrow");
        $this->set('st3', gmdate('Y-m-d H:i:s', $timestamp));
    }

    public function ajax_case_template()
    {
        $this->layout = '';

        $tmpl_id = $this->params->data['tmpl_id'];

        $CaseTemplate = ClassRegistry::init('CaseTemplate');
        $CaseTemplate->recursive = -1;
        $getVal = $CaseTemplate->findById($tmpl_id);

        echo $getVal['CaseTemplate']['description'];
        exit;
    }

    public function betauser_limitation()
    {
        $all_free_plan = Configure::read('ALL_FREE_PLANS');
        $limitation = $this->UserSubscription->readSubDetlfromCache(SES_COMP);
        //$limitation = $this->UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
        $pg_ar = array('ganttchart','invoice','groupupdatealerts','reports','resource_availability','resource_utlization');
        if ((in_array($this->params['controller'], $pg_ar) || in_array($this->action, $pg_ar)) && ($limitation['UserSubscription']['subscription_id'] == CURRENT_EXPIRED_PLAN)) {
            $_SESSION['redirect_restricted_pages'] = 1;
            $this->redirect(HTTP_ROOT . "dashboard");
        }
        if ($limitation['UserSubscription']['is_cancel'] == 1 && SES_TYPE != 1) {
            $this->redirect(HTTP_APP . 'users/logout');
        }
        $GLOBALS['Userlimitation'] = $limitation['UserSubscription'];
        $GLOBALS['user_subscription'] = $limitation['UserSubscription'];
        $this->set("user_subscription", $limitation['UserSubscription']);
        if (in_array($limitation['UserSubscription']['subscription_id'], $all_free_plan)) {
            $GLOBALS['FREE_SUBSCRIPTION'] = 1;
        }
        if (in_array($limitation['UserSubscription']['subscription_id'], array(1, 9))) {
            $GLOBALS['FREE_SUBSCRIPTION_EMAIL'] = 1;
        }
        $this->set('rem_projects', $this->projcetcount(SES_COMP, $limitation));
        $this->set('rem_milestone', $this->milestonecount(SES_COMP, $limitation));
        $this->set('rem_users', $this->usercount(SES_COMP, $limitation));

        $usedspace = $this->CaseFile->getStorage();
        $this->set('used_storage', $usedspace);
        $GLOBALS['usedspace'] = $usedspace;
        if (isset($limitation['UserSubscription']['storage']) && ((strtolower($limitation['UserSubscription']['storage']) == 'unlimited') || $limitation['UserSubscription']['is_free'])) {
            $this->set('remspace', 'Unlimited');
            $GLOBALS['remspace'] = 'Unlimited';
        } elseif (isset($limitation['UserSubscription']['storage']) && $usedspace <= $limitation['UserSubscription']['storage']) {
            $this->set('remspace', ($limitation['UserSubscription']['storage'] - $usedspace));
            $GLOBALS['remspace'] = $limitation['UserSubscription']['storage'] - $usedspace;
        } else {
            $GLOBALS['remspace'] = 0;
            $this->set('remspace', 0);
        }
        //echo "Deal count=".$rem_deal_count."--Contact = ".$rem_contact_count."--User = ".$rem_user_count."-Total Used Space:-".$totalused;exit;
    }

    public function is_user_activepaid()
    {
        $limitation_t = $this->UserSubscription->readSubDetlfromCache(SES_COMP);
        //$limitation_t = $this->UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
        if ($limitation_t['UserSubscription']['is_cancel'] == 1 && SES_TYPE != 1) {
            return 0;
        } elseif (!in_array($limitation_t['UserSubscription']['subscription_id'], array(1, 9, 11, 13))) {
            return 1;
        }
    }

    /**
     * @method projcetcount (int $deal_id) Description
     * @author Andola Admin <support@andola.com>
     * @return int Remaning deals for the logged in beta user
     */
    public function projcetcount($company_id = SES_COMP, $sub_limitation = array())
    {
        if (!$sub_limitation) {
            //$sub_limitation = $this->UserSubscription->find('first', array('conditions' => array('company_id' => $company_id), 'order' => 'id DESC'));
            $sub_limitation = $this->UserSubscription->readSubDetlfromCache($company_id);
        }
        $used_pcount = $this->Project->find('count', array('conditions' => array('company_id' => $company_id, 'short_name !='=>'WDEV')));
        $this->set('used_projects_count', $used_pcount);
        if ($sub_limitation['UserSubscription']['project_limit'] && (strtolower($sub_limitation['UserSubscription']['project_limit']) == 'unlimited' || $sub_limitation['UserSubscription']['is_free'])) {
            return 'Unlimited';
        } else {
            if ($sub_limitation['UserSubscription']['project_limit'] >= $used_pcount) {
                return ($sub_limitation['UserSubscription']['project_limit'] - $used_pcount);
            } else {
                return 0;
            }
        }
    }

    /**
     * @method public Contactcount(int $deal_id) Description
     * @author Andola Admin <support@orangescrum>
     * @return int Remaning Contacts for the logged in beta user
     */
    public function milestonecount($company_id = SES_COMP, $sub_limitation = array())
    {
        //Currently milestone is treated as Unlimited so calculation is not done if required later then will do
        return 'Unlimited';
        /* if(!$sub_limitation){
          App::import('Model','UserSubscription'); $usersubscription = new UserSubscription();
          $sub_limitation = $usersubscription->find('first',array('conditions'=>array('company_id'=>$company_id),'order'=>'id DESC'));
          }
          App::import('Model','EasycaseMilestones'); $milestone = new EasycaseMilestones();
          $used_ccount = $milestone->find('count',array('conditions'=>array('company_id'=>$company_id)));
          if($sub_limitation['UserSubscription']['contact_limit'] && (strtolower($sub_limitation['UserSubscription']['contact_limit'])=='unlimited' || $sub_limitation['UserSubscription']['is_free'])){
          return 'Unlimited';
          }else{
          if($sub_limitation['UserSubscription']['contact_limit']>=$used_ccount){
          return ($sub_limitation['UserSubscription']['contact_limit']-$used_ccount);
          }else{
          return 0;
          }
          } */
    }

    /**
     * @method public Usercount(int $deal_id) Description
     * @author Andola Admin <support@orangescrum>
     * @return int Remaning deals for the logged in beta user
     */
    public function usercount($company_id = ACC_ID, $sub_limitation = array())
    {
        if (!$sub_limitation) {
            //$sub_limitation = $this->UserSubscription->find('first', array('conditions' => array('company_id' => $company_id), 'order' => 'id DESC'));
            $sub_limitation = $this->UserSubscription->readSubDetlfromCache($company_id);
            $this->updatePkg($sub_limitation['UserSubscription']);
        } else {
            $this->updatePkg($sub_limitation['UserSubscription']);
        }
        if ($sub_limitation['UserSubscription']['btsubscription_id']) {
            //$used_ucount = $usr->find('count',array('conditions'=>array('company_id'=>$company_id,'((is_active=1 OR is_active=2) OR (is_active=0 AND DATE(billing_end_date)>="'.GMT_DATE.'"))',)));
            //It includes the deleted users who are paid for the current billing month.
            $used_ucount = $this->CompanyUser->find('count', array('conditions' => array('company_id' => $company_id, 'is_active' => 1, 'is_dummy' => 0,'role_id !=' => 699 )));
        } else {
            $used_ucount = $this->CompanyUser->find('count', array('conditions' => array('company_id' => $company_id, '(is_active=1 OR is_active=2)', 'is_dummy' => 0,'role_id !=' => 699)));
        }

        $GLOBALS['usercount'] = $used_ucount;
        $this->set('current_active_users', $used_ucount);
        if ($sub_limitation['UserSubscription']['user_limit'] && (strtolower($sub_limitation['UserSubscription']['user_limit']) == 'unlimited' || $sub_limitation['UserSubscription']['is_free'])) {
            return 'Unlimited';
        } else {
            if ($sub_limitation['UserSubscription']['user_limit'] >= $used_ucount) {
                return ($sub_limitation['UserSubscription']['user_limit'] - $used_ucount);
            } else {
                return 0;
            }
        }
    }
    public function updatePkg($res_sub)
    {
        $this->loadModel('FeatureSetting');
        $res = $this->FeatureSetting->find('first');
        if ($res && $res_sub['user_limit'] <=10 && !$res_sub['is_sub_upgraded_bt']) {
            if ($res_sub['user_limit'] != 'Unlimited') {
                $this->FeatureSetting->query('delete from feature_settings where 1');
            }
        }
    }
    public function blankpage()
    {
        echo "Blank Page";
        exit;
    }

    public function isiPad()
    {
        preg_match('/iPad/i', $_SERVER['HTTP_USER_AGENT'], $match);
        if (!empty($match)) {
            return true;
        }
        return false;
    }

    public function forceSSL()
    {
        if ($this->Auth->User('id')) {
            $this->redirect('https://' . CHECK_DOMAIN . '.' . SITE_NAME . $this->here);
        } else {
            if (CHECK_DOMAIN && CHECK_DOMAIN != "www" && PAGE_NAME == "home") {
                $this->redirect(PROTOCOL . "www." . DOMAIN);
            } else {
                if (PAGE_NAME != "setGoogleInfo" && PAGE_NAME != "validate_emailurl" && PAGE_NAME != "register_user" && PAGE_NAME != 'enterprise_home' && PAGE_NAME != 'order_enterprise') {
                    $this->redirect('https://' . CHECK_DOMAIN . '.' . SITE_NAME . $this->here);
                }
            }
        }
    }

    /**
    * This is used from the cron controller curlPostData() method
    */
    public function oauthCheck($project_Id, $pid, $company_Id, $authToken, $user_uniq_id, $api_file)
    {
        $project = array();
        if (isset($project_Id)) {
            $project = $this->Project->getProjectFields(array('Project.uniq_id' => $project_Id), array('id'));
        }
        $projectId = isset($project['Project']['id']) ? $project['Project']['id'] : $pid;

        if (isset($company_Id)) {
            $company = $this->Company->getCompanyFields(array('Company.uniq_id' => $company_Id), array('id'));
        }
        $companyId = isset($company['Company']['id']) ? $company['Company']['id'] : '';

        $cond = '';

        if (trim($projectId)) {
            $cond = " AND ProjectUser.project_id = '" . $projectId . "'";
        } elseif (trim($companyId)) {
            $cond = " AND ProjectUser.company_id = '" . $companyId . "'";
        }
        $sql = "SELECT User.id,User.timezone_id,User.is_dst,User.active_dashboard_tab,User.name,ProjectUser.company_id FROM users AS User LEFT JOIN project_users AS ProjectUser ON (User.id = ProjectUser.user_id) WHERE User.uniq_id = '" . $user_uniq_id . "'" . $cond;

        $user = $this->User->query($sql);

        if (isset($user) && !empty($user)) {
            if (!defined('SES_ID')) {
                define('SES_ID', $user['0']['User']['id']);
            }
            if (!defined('USERNAME')) {
                define('USERNAME', $user['0']['User']['name']);
            }
            if (!defined('ACT_TAB_ID')) {
                define('ACT_TAB_ID', $user['0']['User']['active_dashboard_tab']);
            }
            if (!defined('SES_COMP')) {
                define('SES_COMP', $user['0']['ProjectUser']['company_id']);
            }
            // if (isset($this->params->data['api_file']) && trim($this->params->data['api_file'])) {
            if (!empty($api_file)) {
                $this->Auth->allow($api_file);
                if ($api_file == 'ajaxemail') {
                    $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                    $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                }
            }

            if (!empty($authToken)) {
                $timezone = $this->Timezone->find('first', array("conditions" => array("Timezone.id" => $user['0']['User']['timezone_id'])));

                if (!defined('SES_TIMEZONE')) {
                    define('SES_TIMEZONE', $timezone['Timezone']['id']);
                }
                if (!defined('TZ_GMT')) {
                    define('TZ_GMT', $timezone['Timezone']['gmt_offset']);
                }
                if (isset($user['0']['User']['is_dst'])) {
                    if (!defined('TZ_DST')) {
                        define('TZ_DST', $user['0']['User']['is_dst']);
                    }
                } else {
                    if (!defined('TZ_DST')) {
                        define('TZ_DST', $timezone['Timezone']['dst_offset']);
                    }
                }
                if (!defined('TZ_CODE')) {
                    define('TZ_CODE', $timezone['Timezone']['code']);
                }

                $this->Auth->allow('case_details');
                $this->Auth->allow('ajaxpostcase');
                $this->Auth->allow('ajaxemail');
                //added newly
                $this->Auth->allow('changeCustomStatus');
                $this->Auth->allow('taskactions');

                $this->Auth->allow('users');
                $this->Auth->allow('cron/send_mail_to_customers');
            }
        } else {
            print "Oauth Error";
            die;
        }
        return;
    }

    /* Author GKM
     * chack task depedancy of a task and return task details
     */

    public function task_dependency($EasycaseId = '')
    {
        /* dependency check start */
        $this->loadModel('Easycase');
        $allowed = "Yes";
        $params = array(
            'conditions' => array('Easycase.id' => $EasycaseId),
            'fields' => array('Easycase.id', 'Easycase.depends')
        );
        $depends = $this->Easycase->find('first', $params);
        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
            if (stristr($depends['Easycase']['depends'], ',')) {
                $dpnds = array_filter(explode(',', $depends['Easycase']['depends']));
                $dpnds = trim(implode(',', $dpnds), ',');
            } else {
                $dpnds = $depends['Easycase']['depends'];
            }
            $parent_params = array(
                'conditions' => array('Easycase.id IN (' . $dpnds . ')'),
                'fields' => array('Easycase.id', 'Easycase.title', 'Easycase.legend', 'Easycase.status', 'Easycase.isactive', 'Easycase.due_date','Easycase.custom_status_id')
            );
            $result = $this->Easycase->find('all', $parent_params);
            if (is_array($result) && count($result) > 0) {
                foreach ($result as $key => $parent) {
                    $legend = $parent['Easycase']['legend'];
                    // For custom status get the Mapping legend
                    if ($parent['Easycase']['custom_status_id'] !=0) {
                        $this->loadModel('CustomStatus');
                        $cs_data = $this->CustomStatus->findById($parent['Easycase']['custom_status_id']);
                        $legend =$cs_data['CustomStatus']['status_master_id'];
                    }
                    if (($parent['Easycase']['status'] == 2 && $legend == 3) || ($legend == 3)) {
                        // NO ACTION
                    } elseif ($parent['Easycase']['isactive'] == 0) {
                        // NO ACTION
                    } else {
                        $allowed = "No";
                    }
                }
                $this->parent_task = $result;
            }
        }
        /* dependency check end */
        return $allowed;
    }

    /* Author Girish
     * This method is used to update dependancy field of tasks
     * Remove dependancy while move to project, copy to project, copy task, archive, delete
     */

    public function update_dependancy($EasycaseId = '', $proj_id=null)
    {
        $this->loadModel('Easycase');

        if ($proj_id) {
            $params = array(
            'conditions' => array('Easycase.project_id'=>$proj_id,"OR" => array("FIND_IN_SET('{$EasycaseId}',Easycase.depends)", "FIND_IN_SET('{$EasycaseId}',Easycase.children)")),
            'fields' => array('Easycase.id', 'Easycase.project_id', 'Easycase.depends', 'Easycase.children')
                    );
        } else {
            $params = array(
            'conditions' => array("OR" => array("FIND_IN_SET('{$EasycaseId}',Easycase.depends)", "FIND_IN_SET('{$EasycaseId}',Easycase.children)")),
            'fields' => array('Easycase.id', 'Easycase.project_id', 'Easycase.depends', 'Easycase.children')
        );
        }
        $tasks = $this->Easycase->find('all', $params);

        if (is_array($tasks) && count($tasks) > 0) {
            foreach ($tasks as $key => $task) {
                $depends = $task['Easycase']['depends'];
                if (trim($depends) != '') {
                    $dependsArr = explode(',', $depends);
                    if (in_array($EasycaseId, $dependsArr)) {
                        unset($dependsArr[array_search($EasycaseId, $dependsArr)]);
                    }
                    $depends = implode(',', $dependsArr);
                }
                $children = $task['Easycase']['children'];
                if (trim($children) != '') {
                    $childrenArr = explode(',', $children);
                    if (in_array($EasycaseId, $childrenArr)) {
                        unset($childrenArr[array_search($EasycaseId, $childrenArr)]);
                    }
                    $children = implode(',', $childrenArr);
                }
                $data = array(
                    'id' => $task['Easycase']['id'],
                    'depends' => trim($depends) != '' ? $depends : null,
                    'children' => trim($children) != '' ? $children : null,
                );
                #pr($task);pr($data);echo "<hr>";
                $this->Easycase->save($data);
            }
        }
        return true;
        #exit;
    }
    public function setEmailFooter()
    {
        $year = gmdate('Y');
        $newEmailFooter = __("Copyright")." ".$year." ".__("Orangescrum") .'.'.__("All Rights Reserved", true).'.<br>
                    '.__("2059 Camden Ave. #118, San Jose, CA 95124, USA").'
                    <br><br>
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://www.orangescrum.com/blog/">'.__("Blog").'</a>
                    .
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://www.orangescrum.com/how-it-works">'.__("How it Works").'</a>
                    .
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://www.orangescrum.com/help">'.__("Help").'</a>
                    .
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="http://www.orangescrum.com/aboutus">'.__("About Us", true).'</a>

                    <br><br>
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="https://twitter.com/theorangescrum"><img src="http://www.orangescrum.com/img/tw.png" alt="Twitter" style="width:32px;height:32px"></a>
                    <a style="color:#2489B3; font-weight:normal; text-decoration:underline;" href="https://www.facebook.com/pages/Orangescrum/170831796411793"><img src="http://www.orangescrum.com/img/fb.png" alt="Facebook" style="width:32px;height:32px"></a>

                    <br><br>';
        define('NEW_EMAIL_FOOTER', $newEmailFooter);
    }
}
