<?php
/*************************************************************************	
	* Orangescrum Community Edition is a web based Project Management software developed by
 * Orangescrum. Copyright (C) 2013-2022
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): THERE IS NO WARRANTY FOR THE PROGRAM, * TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN   
 * WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS"
 * WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT 
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 * PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE
 * PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
 * ALL NECESSARY SERVICING, REPAIR OR CORRECTION..
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street Fifth Floor, Boston, MA 02110,
 * United States.
 *
 * You can contact Orangescrum, 2059 Camden Ave. #118, San Jose, CA - 95124, US. 
   or at email address support@orangescrum.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * Orangescrum" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by Orangescrum".
 *****************************************************************************/
App::uses('AppController', 'Controller');
App::import('Vendor', 'oauth');

class UsersController extends AppController {

    public $name = 'Users';
    public $components = array('Format', 'Postcase', 'Sendgrid', 'Tmzone', 'Email', 'Cookie','Pushnotification','PhpMailer');

    public function beforeFilter() {
        parent::beforeFilter();
    }

    function beforeRender() {
        if ($this->Auth->User("id")) {
            $withOutLoginPage = array('home', 'tour', 'home_blog', 'validate_emailurl', 'create_btprofile', 'register_user', 'login', 'display', 'signup','register' ,'forgotpassword', 'feedback', 'contactnow', 'ajax_totalcase', 'ajax_get_referrer_cookie', 'ajax_set_referrer_cookie', 'price', 'privacypolicy', 'securities', 'affiliates', 'aboutus', 'tour', 'latest', 'update_email', 'registration', 'check_short_name_reg', 'ajax_registration', 'confirmation', 'check_url_reg', 'check_email_reg', 'invitation', 'create_project');
            if (in_array($this->action, $withOutLoginPage)) {
                if (CHECK_DOMAIN == "app" || CHECK_DOMAIN == "www") {

                    $CompanyUser = ClassRegistry::init('CompanyUser');
                    $checkCmnpyUsr = $CompanyUser->find('all', array('conditions' => array('CompanyUser.user_id' => $this->Auth->User("id"), 'CompanyUser.is_active' => 1), 'fields' => array('CompanyUser.company_id')));

                    $companyIds = array();
                    foreach ($checkCmnpyUsr as $cu) {
                        $companyIds[] = $cu['CompanyUser']['company_id'];
                    }

                    $Company = ClassRegistry::init('Company');
                    $seoarr = $Company->find('all', array('conditions' => array('Company.id' => $companyIds, 'Company.is_active' => 1), 'fields' => array('Company.seo_url')));
                    $seoArr = array();
                    foreach ($seoarr as $arr) {
                        $seoArr[] = $arr['Company']['seo_url'];
                    }

                    if (!in_array(CHECK_DOMAIN, $seoArr)) {
                        if (count($seoArr)) {
                            if (count($seoArr) == 1) {
                                $this->redirect(PROTOCOL . $seoArr[0] . "." . DOMAIN . "dashboard");
                            } else {
                                if (PAGE_NAME != "launchpad") {
                                    $this->redirect(HTTP_APP . "users/launchpad");
                                }
                            }
                        } else {
                            $this->redirect(HTTP_APP . "users/logout");
                        }
                    }
                }
                $file = "";
                $caseid = "";
                if (isset($_GET['case'])) {
                    $caseid = $_GET['case'];
                }
                if (isset($_GET['project'])) {
                    $projectid = $_GET['project'];
                }
                if (isset($_GET['file'])) {
                    $file = $_GET['file'];
                }
                if ($caseid && $projectid) {
                    $this->redirect(HTTP_ROOT . "dashboard/?case=" . $caseid . "&project=" . $projectid);
                } elseif (!$caseid && $projectid) {
                    $this->redirect(HTTP_ROOT . "dashboard/?project=" . $projectid);
                } elseif ($file) {
                    $this->redirect(HTTP_ROOT . "easycases/download/" . $file);
                } elseif (PAGE_NAME == 'tour') {
                    // $this->redirect(HTTP_ROOT."easycases/download/".$file);
                } else {
					// $_SESSION['setredirectcasedetl'] = 1;
                    $this->redirect(HTTP_ROOT . "dashboard");
                }
            }
        }
    }
    public function verifySubDomain()
    {
        $this->layout = 'ajax';
        $retResp['status'] = 'success';
        $retResp['msg'] = '';
        if(!empty($this->request->data)){
            /*if(!$this->g_validate($this->request->data, 1)){
                //google captach validation
                $retResp['status'] = 'error';
                $retResp['msg'] = __('Unauthorized access.');
            }else{*/
                $this->loadModel('Company');
                $company = $this->Company->findBySeoUrl($this->request->data['domain']);
                if(empty($company)){
                    $retResp['status'] = 'error';
                    $retResp['msg'] = __('Invalid subdomain. Please enter a valid subdomain.');
                }else{
                    $this->loadModel('SamlConfiguration');
                    $samlResp = $this->SamlConfiguration->getDetailByDomain($this->request->data['domain']);
                    if(empty($samlResp) || !$samlResp['SamlConfiguration']['is_active']){
                        $retResp['status'] = 'error';
                        $retResp['msg'] = __('Please contact your admin/owner to verify SSO configuration from the integration setting section of Orangescrumm.');
                    }else{
                        //prepare the redirect ul here
                        $protocol = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
                        $host = DOMAIN_COOKIE; //change it to live url
                        $retResp['url'] = $protocol.$company['Company']['seo_url'].$host.'/sso/login';
												Cache::write('KEEP_SAML_DOMAIN', $company['Company']['seo_url']);
                    }
                }
           //}        
        }   
        
        echo json_encode($retResp);
        exit;
    }
    function gdrive()
		{
			
		}

    function testnefield() {
        //$this->loadmodel('Easycase');
        //$ea = $this->Easycase->find('first');
        //$this->loadmodel('ChatSetting');
        //$cs = $this->ChatSetting->find('first');
        $this->loadmodel('User');
        $nn = $this->User->find('first');
        echo "<pre>";
        //print_r($ea);
        //print_r($cs);
        print_r($nn);
        exit;
    }

    function unsubscribe($uniq_id = NULL) {
        if (isset($uniq_id)) {
            $this->User->recursive = -1;
            $user = $this->User->find('first', array('conditions' => array('User.uniq_id' => $uniq_id)));
            if (isset($user) && !empty($user)) {
                $this->User->id = $user['User']['id'];
                $this->User->saveField('isemail', '0');

                if ($this->Auth->User("id")) {
                    $this->layout = 'default_inner';
                } else {
                    //$this->layout = 'ajax';
                }
            } else {
                $this->redirect(HTTP_ROOT);
            }
        } else {
            $this->redirect(HTTP_ROOT);
        }
    }

    function getlogin() {
        $this->login(NULL, 'prakash.satpathy@andolasoft.com', '73803249c6667c5af2d51c0dedfae487');
        exit;
    }

    function test() {
        //echo md5(111);exit;
        //$this->layout = 'ajax';
    }

    function search_test() {
        
    }
		function get_mobile_device(){			
		}

    /*
     * If Sign up by google, Then:
     *     if email exists then login to user
     *     if new and not in universal domain, checking in compnay and if exits then prompt to seo url in sign up page else auto signup with login.
     *     if new and in universal domain, then prompt to seo url in sign up page
     * 
     * @author Sunil
     * @method: signup
     * @return
     */

    function signup() {
        $this->loadMOdel('Company');
        $companies = $this->Company->find('all', array('fields' => array('Company.id')));
        if(!empty($companies)){
            $this->redirect('login');
        }
        $subsc_cls = ClassRegistry::init('Subscription');
        //$sub_details = $subsc_cls ->find('all');
        $sub_details = $subsc_cls->find('all', array('conditions' => array('Subscription.is_active' => 1), 'order' => array('Subscription.price ASC')));
        $sub_details = Hash::combine($sub_details, '{n}.Subscription.plan', '{n}');
        $this->set('sub_details', $sub_details);
        $PAID_plans = Configure::read('CURRENT_PAID_PLANS');
        foreach ($PAID_plans as $k => $v) {
            $inpt = strtolower($k);
            if ($inpt == strtolower(trim($this->params['pass'][0]))) {
                $this->set('membership_type', $v);
                break;
            } else {
                $this->set('membership_type', 0);
            }
        }
        $flag = 0;

        if (strtolower($this->params['pass'][0]) == 'getstarted') {
            $flag = 1;
        }
        $this->set('homepage_flag', $flag);

        $flag = 0;
        if ($_GET['referral'] == "blog") {
            $flag = 1;
        }

        //Delete google info after each page refresh
        $google_user_info = "";
        $isEmailExist = 0;
        $isCompanyExist = 0;
        $isUniversalDomains = 0;
        $domain = "";

        if (isset($_SESSION['CHECK_GOOGLE_SES']) && intval($_SESSION['CHECK_GOOGLE_SES'])) {
            unset($_SESSION['GOOGLE_USER_INFO']);
        }

        //Set google info from session and check if google email exists in our record or not.
        if (isset($_SESSION['GOOGLE_USER_INFO']) && !empty($_SESSION['GOOGLE_USER_INFO'])) {
            $google_user_info = $_SESSION['GOOGLE_USER_INFO'];

            //Check email exists or not
            $isEmail = $this->User->find('first', array('conditions' => array('User.email' => urldecode($_SESSION['GOOGLE_USER_INFO']['email'])), 'fields' => array('User.id')));
            if (isset($isEmail['User']['id']) && trim($isEmail['User']['id'])) {
                $isEmailExist = 1;
            } else { // New email
                //Getting domain from email
                $start_pos = strrpos($_SESSION['GOOGLE_USER_INFO']['email'], '@');
                $email = substr($_SESSION['GOOGLE_USER_INFO']['email'], $start_pos + 1);
                $end_pos = strpos($email, '.');
                $domain = substr($email, 0, $end_pos);
                //All possible domains
                $all_mail = array('yahoo', 'hotmail', 'live', 'reddif', 'outlook', 'rediff', 'aim', 'zoho', 'icloud', 'mail', 'gmax', 'shortmail', 'inbox', 'gmail');

                //Check domain comes from email exists from possible domains or not
                if (in_array($domain, $all_mail)) {
                    $isUniversalDomains = 1;
                } else {
                    //Check company exists or not by taking domains from email
                    $this->loadModel('Company');
                    $company = $this->Company->findBySeoUrl($domain);
                    //print '<pre>';print_r($company);exit;
                    if (isset($company) && !empty($company)) {
                        $isCompanyExist = 1;
                    }
                }
            }
        }

        if ($isUniversalDomains) {
            $this->set('insert_automatic', 0);
            $this->set('domain', '');
        } else if ($isCompanyExist) {
            $this->set('insert_automatic', 0);
            $this->set('domain', '');
        } else {
            $this->set('insert_automatic', 1);
            $this->set('domain', $domain);
        }

        $google_user_info['isEmail'] = $isEmailExist;

        $this->set('google_user_info', $google_user_info);
        $this->set('blogpage_flag', $flag);
    }

    //Set global google session
    function setGoogleInfo() {
        $this->layout = 'ajax';
        $_SESSION['CHECK_GOOGLE_SES'] = 1;
        echo 1;
        exit;
    }

    /**
     * @method: public register_user() 
     * @author Andola Dev <>
     * @return void 
     */
    function register_user() {
        $this->layout = 'ajax';
        $this->loadModel('Company');
        //Company details from the form input
        $google_id = null;
        if (isset($_SESSION['GOOGLE_USER_INFO']['name']) && !empty($_SESSION['GOOGLE_USER_INFO']['name'])) {
            $nm = $_SESSION['GOOGLE_USER_INFO']['name'];
            $last = strripos($nm, " ");
            $name = substr($nm, 0, $last);
            $last_name = substr($nm, $last + 1, strlen($nm));
            $google_id = $_SESSION['GOOGLE_USER_INFO']['id'];
        } else {
            $name = urldecode($this->request->data['name']);
            $last_name = urldecode($this->request->data['last_name']);
        }

        $email = (isset($_SESSION['GOOGLE_USER_INFO']['email']) && !empty($_SESSION['GOOGLE_USER_INFO']['email'])) ? urldecode($_SESSION['GOOGLE_USER_INFO']['email']) : urldecode($this->request->data['email']);
        $gaccess_token = (isset($_SESSION['GOOGLE_USER_INFO']['access_token']) && !empty($_SESSION['GOOGLE_USER_INFO']['access_token'])) ? urldecode($_SESSION['GOOGLE_USER_INFO']['access_token']) : '';

        $password = urldecode($this->request->data['password']);
        $company = urldecode($this->request->data['company']);
        $seo_url = urldecode(trim($this->request->data['seo_url']));
            //$free_flag = isset($this->request->data['free_flag'])?urldecode($this->request->data['free_flag']):""; //free for all plans
            $free_flag = 'free'; //free for all plans
        $contact_phone = urldecode($this->request->data['contact_phone']);
        if (strtolower(trim($seo_url)) == 'helpdesk' || strtolower(trim($seo_url)) == 'api') {
            $msg['msg'] = (strtolower(trim($seo_url)) == 'api') ? 'api' : 'helpdesk';
            echo json_encode($msg);
            exit;
        }
        $isGoogle = 0;
        $google_data = "";
        if (isset($this->request->data['bt_profile_id'])) {
            $bt_profile_id = urldecode($this->request->data['bt_profile_id']);
            $credit_cardtoken = urldecode($this->request->data['credit_cardtoken']);
            $card_number = urldecode($this->request->data['card_number']);
            $len = strlen($card_number);
            $last4degit = substr($card_number, ($len - 4));
            $cnumber = '*';
            for ($i = 1; $i < ($len - 4); $i++) {
                $cnumber .='*';
            }
            $cnumber .=$last4degit;
            $expiry_date = urldecode($this->request->data['expiry_date']);
            $sub_type = 1;
        } else {
            $bt_profile_id = '';
            $credit_cardtoken = '';
            $cnumber = '';
            $expiry_date = '';
            $sub_type = 0;
        }
        $short_name = $this->Format->makeShortName($name, $last_name);

        //Get the timezone for the registered user
        $this->loadModel('Timezone');
        $getTmz = $this->Timezone->find('first', array('conditions' => array('Timezone.gmt_offset' => urldecode($this->request->data['timezone_id']))));
        $timezone_id = $getTmz['Timezone']['id'];
        //Choose the subscritpion plan as selected by the user 
        $plan_id = (isset($this->data['plan_id']) && $this->data['plan_id']) ? $this->data['plan_id'] : CURRENT_FREE_PLAN;
        $this->loadModel('Subscription');
        $subScription = $this->Subscription->find('first', array('conditions' => array('Subscription.plan' => $plan_id)));
        if ($this->request->data && $name && $email && $company) {
            if (!empty($_COOKIE["affiliated_code"])) {
                $ip = $_SERVER['REMOTE_ADDR'];
                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }
                //$this->send_to_sukinda($name, $email, $ip, $plan_id, 1, 0);
            }
				$comp = null;
            $comp['Company']['uniq_id'] = $this->Format->generateUniqNumber();
            $comp['Company']['seo_url'] = $this->Format->makeSeoUrl($seo_url);
            $comp['Company']['subscription_id'] = $subScription['Subscription']['id'];
            $comp['Company']['name'] = $company;
            $comp['Company']['contact_phone'] = $contact_phone;
                $comp['Company']['new_layout_no'] = 1;
                $comp['Company']['is_per_user'] = 1;
				if(isset($this->request->data['plan_type_check'])){
					$comp['Company']['refering_plan_id'] = empty($this->request->data['plan_type_check'])?0:$this->request->data['plan_type_check'];	
				}
            if (isset($this->request->data['industry_id']) && trim($this->request->data['industry_id'])) {
                $industries = $GLOBALS['industries'];
                $comp['Company']['industry_id'] = $industry_id = $this->request->data['industry_id'];
                $industry = $industries[$industry_id];
                if (trim($industry) == "Others") {
                    $this->loadModel("Industry");
                    $industry = $ind['name'] = $this->request->data['new_industry'];
                    $ind['is_display'] = 0;
                    $this->Industry->save($ind);
                    $comp['Company']['industry_id'] = $this->Industry->getLastInsertID();
                }
            }
            $referrer = "";
            if (isset($_COOKIE['REFERRER']) && trim($_COOKIE['REFERRER'])) {
                $referrer = $comp['Company']['referrer'] = $_COOKIE['REFERRER'];
            }
            $message = "success";
				$this->Company->create();
            try {
                $sus_comp = $this->Company->save($comp);
            } catch (Exception $e) {
                $this->Company->delete($company_id);
                $subject = "ORANGESCRUM DATABASE ERROR";
                $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
                //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "","");
                echo "error";
                exit;
            }

            if ($sus_comp) {
                $company_id = $this->Company->getLastInsertID();
                $activation_id = $this->Format->generateUniqNumber();
                $usr['User']['uniq_id'] = $this->Format->generateUniqNumber();
                $usr['User']['email'] = $email;
                $usr['User']['password'] = (isset($_SESSION['GOOGLE_USER_INFO']['email']) && !empty($_SESSION['GOOGLE_USER_INFO']['email'])) ? '' : $this->Auth->password($password);
                if (!trim($name)) {
                    $nme = explode("@", $email);
                    $name = $nme[0];
                }
                $usr['User']['name'] = $name;
                $usr['User']['last_name'] = $last_name;
                $usr['User']['short_name'] = $short_name;
                $usr['User']['istype'] = 2;
                $usr['User']['isactive'] = 1;
                $usr['User']['dt_created'] = GMT_DATETIME;
                $usr['User']['dt_updated'] = GMT_DATETIME;
                $usr['User']['query_string'] = $activation_id;
                $vstr = md5(uniqid(rand()));
                $usr['User']['verify_string'] = (isset($_SESSION['GOOGLE_USER_INFO']['email']) && !empty($_SESSION['GOOGLE_USER_INFO']['email'])) ? '' : $vstr;
                $usr['User']['timezone_id'] = $timezone_id ? $timezone_id : 26;
                $usr['User']['btprofile_id'] = $bt_profile_id;
                $usr['User']['credit_cardtoken'] = $credit_cardtoken;
                $usr['User']['card_number'] = $cnumber;
                $usr['User']['expiry_date'] = $expiry_date;
                $usr['User']['usersub_type'] = $sub_type;
                $usr['User']['is_agree'] = (trim($this->request->data['is_agree']) == 0) ? $this->request->data['is_agree'] : 1;
                $usr['User']['keep_hover_effect'] = 15;
                $ip = $this->Format->getRealIpAddr();
                $usr['User']['ip'] = $ip;
                $usr['User']['gaccess_token'] = $gaccess_token;
                //saving google id
                if ($google_id) {
                    $usr['User']['google_id'] = $google_id;
                }
                try {
                    $sus_user = $this->User->save($usr);
                    if (!empty($_SESSION['GOOGLE_USER_INFO'])) {
                        $this->saveUserInfo($this->User->getLastInsertId(), $_SESSION['GOOGLE_USER_INFO']['access_token'], 1);
                    }
                } catch (Exception $e) {
                    $this->Company->delete($company_id);
                    $subject = "ORANGESCRUM DATABASE ERROR";
                    $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
                    //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
                    echo "error";
                    exit;
                }
                if ($sus_user) {
                    $comp_usr['CompanyUser']['user_id'] = $this->User->getLastInsertID();
                    $comp_usr['CompanyUser']['company_id'] = $company_id;
                    $comp_usr['CompanyUser']['company_uniq_id'] = $comp['Company']['uniq_id'];
                    $comp_usr['CompanyUser']['user_type'] = 1;
                        $comp_usr['CompanyUser']['role_id'] = 1;
                    $this->loadModel('CompanyUser');
                    try {
                        $sus_companyuser = $this->CompanyUser->save($comp_usr);
                    } catch (Exception $e) {
                        $this->Company->delete($company_id);
                        $this->User->delete($comp_usr['CompanyUser']['user_id']);
                        $subject = "ORANGESCRUM DATABASE ERROR";
                        $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
                        //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
                        echo "error";
                        exit;
                    }
                    if ($sus_companyuser) {
                        $price = $subScription['Subscription']['price'];
                        //Saving coupon for user
                        //if (isset($this->request->data['coupon_code']) && $this->request->data['coupon_code']) {

                        if (USE_COUPON) {
                            $this->loadModel('Coupon');
                            $this->Coupon->recursive = -1;
                            $coupon = $this->Coupon->find('first', array('conditions' => array('Coupon.company_id' => '0', 'Coupon.isactive' => '1', array('OR' => array('Coupon.expires >= CURDATE()', 'Coupon.expires' => '0000-00-00')))));
                            $userCoupon = array();
                            $userCoupon = $coupon;
                            unset($userCoupon['Coupon']['id']);
                            unset($userCoupon['Coupon']['created']);
                            unset($userCoupon['Coupon']['modified']);
                            if ($coupon && !$coupon['Coupon']['company_id']) {
                                if ($coupon['Coupon']['discount'] && $coupon['Coupon']['discount_type']) {
                                    if ($coupon['Coupon']['discount_type'] == 2) {
                                        $dis_amt = number_format(($coupon['Coupon']['discount'] / 100) * $price, 2, '.', '');
                                    } else {
                                        $dis_amt = $coupon['Coupon']['discount'];
                                    }
                                    $price -= $dis_amt;
                                }
                                $userCoupon['Coupon']['company_id'] = $company_id;
                                $userCoupon['Coupon']['isactive'] = 1;
                                $userCoupon['Coupon']['ip'] = $_SERVER['REMOTE_ADDR'];
                                $userCoupon['Coupon']['isactive'] = 0;
                                $this->Coupon->save($userCoupon);
                            }
                        }

                        $companyUid = $this->CompanyUser->getLastInsertID();
                        $this->loadModel('UserSubscription');
                        $this->saveResourceSettings($company_id);// save Resource Settings
                        $sub_usr['UserSubscription']['user_id'] = $comp_usr['CompanyUser']['user_id'];
                        $sub_usr['UserSubscription']['company_id'] = $company_id;
                        $sub_usr['UserSubscription']['subscription_id'] = $subScription['Subscription']['id'];
                        $sub_usr['UserSubscription']['storage'] = $subScription['Subscription']['storage'];
                        $sub_usr['UserSubscription']['project_limit'] = $subScription['Subscription']['project_limit'];
                        $sub_usr['UserSubscription']['user_limit'] = $subScription['Subscription']['user_limit'];
                        $sub_usr['UserSubscription']['milestone_limit'] = $subScription['Subscription']['milestone_limit'];
                        if (CURRENT_FREE_PLAN == $plan_id) {
                            $sub_usr['UserSubscription']['free_trail_days'] = FREE_TRIAL_PERIOD;
                        } else {
                            $sub_usr['UserSubscription']['free_trail_days'] = $subScription['Subscription']['free_trail_days'];
                        }
                        $sub_usr['UserSubscription']['price'] = $price;
                        $sub_usr['UserSubscription']['month'] = $subScription['Subscription']['month'];
                        $sub_usr['UserSubscription']['created'] = GMT_DATETIME;
                        try {
                            $usersubs = $this->UserSubscription->save($sub_usr);
                            // add data for new signup in new_pricing_users for new pricing od addning user dynamically
                            $this->loadModel("NewPricingUser");
                            $np_users["NewPricingUser"]["company_id"] = $company_id ;
                            $np_users["NewPricingUser"]["user_id"] = $comp_usr['CompanyUser']['user_id'];
                            $np_users["NewPricingUser"]["per_user_price"] = CUR_PLAN_USER;
                            $np_users["NewPricingUser"]["total_price"] = 0;
                            $np_users["NewPricingUser"]["plan_id"] = $plan_id;
                            $np_users["NewPricingUser"]["created"] = GMT_DATETIME;
                                                                $np_users["NewPricingUser"]["is_flat_price"] = 1;
                            $this->NewPricingUser->save($np_users);
                        } catch (Exception $e) {
                            $this->Company->delete($company_id);
                            $this->User->delete($comp_usr['CompanyUser']['user_id']);
                            $this->CompanyUser->delete($companyUid);
                            $subject = "ORANGESCRUM DATABASE ERROR";
                            $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
                            //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
                            echo "error";
                            exit;
                        }
                        //setcookie('FIRST_INVITE_2', '1', time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                        //Insert a new record for user notification.
                        $notification['user_id'] = $comp_usr['CompanyUser']['user_id'];
                        $notification['type'] = 1;
                            $notification['value'] = 2;
                        $notification['due_val'] = 1;
                        ClassRegistry::init('UserNotification')->save($notification);
                        $json_arr['company_name'] = $comp['Company']['name'];
                        $json_arr['name'] = $usr['User']['name'];
                        $json_arr['user_type'] = isset($this->request->data['bt_profile_id']) ? 'Paid' : 'Free';
                        $json_arr['created'] = GMT_DATETIME;
                        $this->Postcase->eventLog($company_id, $comp_usr['CompanyUser']['user_id'], $json_arr, 1);

                        if (isset($_SESSION['GOOGLE_USER_INFO']['email']) && !empty($_SESSION['GOOGLE_USER_INFO']['email'])) {
                            $message = "success";
                            $isGoogle = 1;
                            $google_data = json_encode($_SESSION['GOOGLE_USER_INFO']);
                        } else {
                            //End
                            $to = $email;
                            $from = FROM_EMAIL;
                            $subject = "Welcome to Orangescrum, " . ucfirst($name) . "!";
                            $activation_url = HTTP_ROOT . "users/confirmation/" . $vstr;
                            $create_project = HTTP_ROOT. "users/create_project?project_url=create_project";
                            $web_address = HTTP_ROOT;
                            $this->Email->delivery = 'smtp';
                            $this->Email->to = $to;
                            $this->Email->subject = $subject;
                            $this->Email->from = $from;
                            $this->Email->template = 'signup';
                            $this->Email->sendAs = 'html';
                            $this->set('activation_url', $activation_url);
                            $this->set('create_project', $create_project);
                            $this->set('to_email', $to);
                            $this->set('project_limit', $subScription['Subscription']['project_limit']);
                            $this->set('user_limit', $subScription['Subscription']['user_limit']);
                            $this->set('storage', $subScription['Subscription']['storage']);
                            $this->set('expName', ucfirst($name));
                            $this->set('password', $password);
                            $this->set('web_address', $web_address);
                            $this->set('plan_id', $plan_id);
                            //if($plan_id == 1){
                            if (CURRENT_FREE_PLAN == $plan_id) {
                                $this->set('free_trail_days', FREE_TRIAL_PERIOD);
                            } else {
                                $this->set('free_trail_days', $subScription['Subscription']['free_trail_days']);
                            }
                            $this->set('price', $subScription['Subscription']['price']);
                            //if (isset($this->request->data['coupon_code']) && $this->request->data['coupon_code']) {
                            if (USE_COUPON) {
                                $this->set('discount_price', $price);
                            }
                            //$this->set('month', $subScription['Subscription']['month']);
                            //}
							if(defined("PHPMAILER") && PHPMAILER == 1){
								$this->Email->set_variables = $this->render('/Emails/html/signup',false);
								$this->PhpMailer->sendPhpMailerTemplate($this->Email);
																
								$subject = "Orangescrum Account Confirmation";
								$this->Email->subject = $subject;
								$this->set('usrname', ucfirst($name));
								$this->Email->set_variables = $this->render('/Emails/html/email_activation',false);	
								$this->PhpMailer->sendPhpMailerTemplate($this->Email);
							}else{							
								$this->Sendgrid->sendgridsmtp($this->Email);
								$this->Email->template = 'email_activation';
								$subject = "Orangescrum Account Confirmation";
								$this->Email->subject = $subject;
								$this->set('usrname', ucfirst($name));
								$this->Sendgrid->sendgridsmtp($this->Email);
							}
                        }
                        $message = "success";
                    }
                }
            }
        } else {
            if ($_SERVER['HTTP_REFERER']) {
                $this->redirect(HTTP_REFERER);
                exit;
            } else {
                $this->redirect(HTTP_HOME);
                exit;
            }
        }
        if ($message != "success") {
            if ($company_id) {
                $this->loadModel('Company');
                $this->Company->delete($company_id);
            }
            if ($comp_usr['CompanyUser']['user_id']) {
                $this->loadModel('User');
                $this->User->delete($comp_usr['CompanyUser']['user_id']);
            }
            if ($companyUid) {
                $this->loadModel('CompanyUser');
                $this->CompanyUser->delete($companyUid);
            }
        } else {
            $is_subscribe_now = 1;
            if (CURRENT_FREE_PLAN == $plan_id) {
                $is_subscribe_now = 0;
            }

            $arr_project = array();
                $arr_project['name'] = __('Getting Started Orangescrum',true);
            $arr_project['short_name'] = 'GSO';
            $arr_project['validate'] = 1;
            $arr_project['members'] = array($comp_usr['CompanyUser']['user_id']);
            define('SES_ID', $comp_usr['CompanyUser']['user_id']);
            //$prjid = $this->User->add_inline_project($arr_project, $comp_usr['CompanyUser']['user_id'], $company_id, $name, $this);
            $prjid=0;

            $arr_taskgroup = array();
            $arr_taskgroup = Configure::read('DEFAULT_TASKGROUP_INPUT');
            //$this->User->new_inline_milestone($arr_taskgroup, $comp_usr['CompanyUser']['user_id'], $company_id, $prjid);

            $msg['loggedin'] = $this->login(NULL, $email, $password, $is_subscribe_now, 1);
            //$is_subscribe_now is used for subscription
            $msg['msg'] = $message;
            $msg['isGoogle'] = $isGoogle;
            $msg['google_data'] = $google_data;
            echo json_encode($msg);
            exit;
        }
    }
    function update_cases() {
        $this->loadModel('Easycase');
        $allCase = $this->Easycase->find('all', array('conditions' => array('Easycase.istype' => 1)));
        //pr($allCase);

        foreach ($allCase as $cases) {
            $total = 0;

            $total = $this->Easycase->find('count', array('conditions' => array('Easycase.case_no' => $cases['Easycase']['case_no'], 'Easycase.project_id' => $cases['Easycase']['project_id'], 'Easycase.isactive' => 1, 'Easycase.id !=' => $cases['Easycase']['id']), 'fields' => 'DISTINCT Easycase.id'));

            $lastcase = $this->Easycase->find('first', array('conditions' => array('Easycase.case_no' => $cases['Easycase']['case_no'], 'Easycase.project_id' => $cases['Easycase']['project_id'], 'Easycase.isactive' => 1), 'fields' => array('Easycase.id', 'Easycase.user_id'), 'order' => array('Easycase.id DESC'), 'limit' => 1));

            //echo $cases['Easycase']['case_no']." - ".$cases['Easycase']['project_id'];
            //pr($lastcase);

            $this->Easycase->query("update easycases set case_count='" . $total . "',updated_by='" . $lastcase['Easycase']['user_id'] . "' where id='" . $cases['Easycase']['id'] . "'");
        }

        exit;
    }

    function autoComplete() {
        $this->autoRender = false;
        //print_r($this->request->query['prjid']);exit;
        $term = $this->request->query['tag'];
        $this->loadModel('Project');
        $this->loadModel('ProjectUser');
        $project = $this->Project->find('all', array('conditions' => array('Project.uniq_id' => $this->request->query['prjid'], 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
        //print_r($project);exit;
        $users_id = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.project_id' => $project['0']['Project']['id'], 'ProjectUser.company_id' => SES_COMP), 'fields' => array('ProjectUser.user_id')));
        //print_r($users_id);exit;
        foreach ($users_id as $k => $val) {
            $users = $this->User->find('all', array('conditions' => array('User.id' => $val['ProjectUser']['user_id'], 'User.isactive' => '1', 'OR' => array('User.name LIKE' => '% sat %', 'User.email LIKE' => '% sat %', 'User.last_name LIKE' => '% sat %'))));
        }

        $users = $this->User->query("SELECT User.name,User.short_name, User.id, User.email, CompanyUser.is_client from users as User Inner Join project_users as ProjectUser on User.id = ProjectUser.user_id Inner Join projects AS Project ON ProjectUser.project_id=Project.id Inner Join company_users AS CompanyUser ON CompanyUser.user_id=User.id Where Project.id=" . $project['0']['Project']['id'] . " AND (User.name LIKE '%" . $term . "%' OR User.email LIKE '%" . $term . "%' OR User.last_name LIKE '%" . $term . "%') AND User.isactive = '1' AND CompanyUser.company_id='" . SES_COMP . "'");
        //print_r($users);exit;
        foreach ($users as $key => $value) {
            $items[] = array("key" => $value['User']['id'], "value" => $value['User']['short_name']);
        }
        $json_response = json_encode($items); //$this->_encode($users)
        echo $json_response;
        exit;
    }

    private function _encode($postData) {
        $temp = array();
        foreach ($postData as $user) {
            array_push($temp, array(
                //'id' => $user['User']['id'],
                //'label' => $user['User']['name'],
                //'value' => $user['User']['name'],
                'email' => $user['User']['email'],
                    //'client' => $user['CompanyUser']['is_client'],
            ));
        }
        return $temp;
    }

    function post_support() {
        if (!empty($this->request->data)) {
            $support_email = urldecode($this->request->data['support_email']);
            $support_name = urldecode($this->request->data['support_name']);
            $support_msg = urldecode($this->request->data['support_msg']);
            $subject = "Feedback on Orangescrum by " . stripslashes(strip_tags($support_name));
            $ip = $this->Format->getRealIpAddr();
            $location = $this->Format->iptoloccation($ip);
            /* $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
              if(isset($tags['city']) && isset($tags['region']) && isset($tags['country']) && $tags['city']){
              $location = $tags['city'].", ".$tags['region'].", ".$tags['country'];
              if(isset($tags['longitude']) && isset($tags['latitude'])) {
              $location.= "\nIP: ".$ip.", lon/lat: ".$tags['longitude']."/".$tags['latitude'];
              }
              }else {
              $location.= "\nIP: ".$ip;
              } */
            $message = "<p style='font-family:Arial;font-size:14px;'>
                  <p style='font-family:Arial;font-size:14px;'>Dear site administrator,<p>
                  <p style='font-family:Arial;font-size:14px;'>You're lucky today; you've got feedback on Orangescrum.</p>
                  <p>&nbsp;</p>
                  <p style='font-family:Arial;font-size:14px;'><b>Company:</b> " . CMP_SITE . "</p>
                  <p style='font-family:Arial;font-size:14px;'><b>Name:</b> " . $support_name . "</p>
                  <p style='font-family:Arial;font-size:14px;'><b>Email:</b> " . $support_email . "</p>
                  <p style='font-family:Arial;font-size:14px;'><b>Message:</b> " . nl2br($support_msg) . "</p>
                  <p style='font-family:Arial;font-size:14px;'><b>Location:</b> " . $location . "</p>
          </p>";
            $to = FROM_EMAIL;
            //if ($this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'')) {
                echo "success";
            //}
        }
        exit;
    }

    function post_support_inner() {
        if (!empty($this->request->data)) {
            $support_email = urldecode($this->request->data['support_email']);
            $support_name = urldecode($this->request->data['support_name']);
            $support_msg = urldecode($this->request->data['support_msg']);
            $support_ref_url = urldecode($this->request->data['support_refurl']);
            $subject = "Feedback on Orangescrum by " . stripslashes(strip_tags($support_name));
            $ip = $this->Format->getRealIpAddr();
            $location = $this->Format->iptoloccation($ip);
            $message = "<p style='font-family:Arial;font-size:14px;'>
				    <p style='font-family:Arial;font-size:14px;'>Dear site administrator,<p>
				    <p style='font-family:Arial;font-size:14px;'>You're lucky today; you've got feedback on Orangescrum.</p>
				    <p>&nbsp;</p>
				    <p style='font-family:Arial;font-size:14px;'><b>Company:</b> " . CMP_SITE . "</p>
				    <p style='font-family:Arial;font-size:14px;'><b>Name:</b> " . $support_name . "</p>
				    <p style='font-family:Arial;font-size:14px;'><b>Email:</b> " . $support_email . "</p>
				    <p style='font-family:Arial;font-size:14px;'><b>Message:</b> " . nl2br($support_msg) . "</p>
					       <p style='font-family:Arial;font-size:14px;'><b>Sent From:</b> " . $support_ref_url . "</p>
				    <p style='font-family:Arial;font-size:14px;'><b>Location:</b> " . $location . "</p>
			    </p>";
            $to = FROM_EMAIL;
            //if ($this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'')) {
                echo "success";
            //} else {
              //  echo "fail";
            //}
        }
        exit;
    }

    function upgrade() {
        $this->redirect(HTTP_ROOT . "users/company");
        exit;
    }

    /**
     * @Method: public check_config() 
     * @return boolean
     */
    function check_config() {
        //if(SES_TYPE==1 && CONFIG_SUBSCRIPTION){
        if (SES_TYPE == 1) {
            return true;
        } else {
            $this->redirect(HTTP_ROOT);
        }
    }

    /**
     * cancel user account for upgrade failure in case of switching plan from yearly to monthly and vice versa.
     */
    function cancelUserAccountTemp() {
        $this->loadModel('UserSubscriptions');
        $usersub = $this->UserSubscriptions->find('first', array('conditions' => array('UserSubscriptions.company_id' => SES_COMP), 'order' => 'id DESC'));
        $data['UserSubscriptions']['id'] = $usersub['UserSubscriptions']['id'];
        $data['UserSubscriptions']['company_id'] = SES_COMP;
        $data['UserSubscriptions']['is_cancel'] = 1;
        $data['UserSubscriptions']['cancel_date'] = GMT_DATETIME;
        $data['UserSubscriptions']['next_billing_date'] = '';
        $this->UserSubscriptions->save($data);
        // Account table 
        $this->loadModel('Companies');
        $cmp_dat = $this->Companies->findById(SES_COMP);
        $adata['Companies']['id'] = SES_COMP;
        $adata['Companies']['is_active'] = 2;
        $this->Companies->save($adata);
        $this->loadModel('CompanyUsers');
        $this->CompanyUsers->UpdateAll(array('billing_start_date' => "''", 'billing_end_date' => "''"), array('company_id' => SES_COMP));
			$this->Format->resetCacheSub(SES_COMP);
    }

    function confirmationPage() {
        if (($this->params['pass'][0]) == 'upgrade') {
            $this->set('upgrade_flag', 1);
        } else {
            $this->set('upgrade_flag', 0);
        }
        $this->loadModel('UserSubscriptions');
        $subscription = $this->UserSubscriptions->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
        $this->set('subscription', $subscription);
            $this->set('owner_id', $this->Auth->user('id'));
    }

    function invoicePage() {
        $this->layout = NULL;        
    }

    function company($img = null) {
        if (SES_TYPE == 3) {
            $this->redirect(HTTP_ROOT . "dashboard");
        }

        $Company = ClassRegistry::init('Company');
        $Company->recursive = -1;

        $photo = urldecode($img);
        $s3 = new S3(awsAccessKey, awsSecretKey);
        $info = $s3->getObjectInfo(BUCKET_NAME, DIR_USER_COMPANY_S3_FOLDER . $photo);
        //if($photo && file_exists(DIR_FILES."company/".$photo))
        if ($photo && $info) {
            //unlink(DIR_FILES."company/".$photo);

            $s3->deleteObject(BUCKET_NAME, DIR_USER_COMPANY_S3_FOLDER . $photo);
            $comp['id'] = SES_ID;
            $comp['logo'] = $photo;
            $Company->save($comp);

                $this->Session->write("SUCCESS", __("Company photo removed successfully",true));
            $this->redirect(HTTP_ROOT . "users/company");
        }

        if (isset($this->request->data['Company'])) {
            $photo_name = "";
            if (isset($this->request->data['Company']['photo'])) {
                //$photo_name = $this->Format->uploadPhoto($this->request->data['Company']['photo']['tmp_name'],$this->request->data['Company']['photo']['name'],$this->request->data['Company']['photo']['size'],DIR_FILES."company/",SES_ID);
                $photo_name = $this->Format->uploadPhoto($this->request->data['Company']['photo']['tmp_name'], $this->request->data['Company']['photo']['name'], $this->request->data['Company']['photo']['size'], DIR_FILES . "company/", SES_ID, "cmp_logo");
                if ($photo_name == "ext") {
                        $this->Session->write("ERROR", __("Company logo should be an image file",true));
                    $this->redirect(HTTP_ROOT . "users/company");
                } elseif ($photo_name == "size") {
                        $this->Session->write("ERROR", __("Company logo size cannot excceed 1mb",true));
                    $this->redirect(HTTP_ROOT . "users/company");
                }
            }
            if (trim($this->request->data['Company']['name']) == "") {
                    $this->Session->write("ERROR", __("Name cannot be left blank",true));
                $this->redirect(HTTP_ROOT . "users/company");
            } else {
                $this->request->data['Company']['id'] = SES_COMP;
                if (isset($this->request->data['Company']['photo_name'])) {

                    $this->request->data['Company']['logo'] = $this->request->data['Company']['photo_name'];
                } else {
                    $this->request->data['Company']['logo'] = $photo_name;
                }

                $Company->save($this->request->data);
                    $this->Session->write("SUCCESS", __("Company updated successfully",true));
                $this->redirect(HTTP_ROOT . "users/company");
            }
        }

        $getCompany = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP)));
        $this->set('getCompany', $getCompany);
    }

    function home($abtest = NULL) {
        if (MAINTENANCE) {
            $this->layout = false;
            $this->render("mainten");
        }
        $this->redirect(HTTP_ROOT);
    }

    /* function registration(){

      $Subscription = ClassRegistry::init('Subscription');
      $Subscription->recursive = -1;
      $getPrices = $Subscription->find('first');
      $this->set('getPrices',$getPrices);
      } */

    function ajax_check_user_exists() {
        $this->layout = 'ajax';
        $this->User->recursive = -1;
			$role_id = $this->request->data['role_id'];
            if ($this->request->data['email']) { // && $this->request->data['uniq_id']
			if ( stristr( $this->request->data['email'], ",")){
				$stremails = $this->request->data['email'];
			} else {
				$stremails = urldecode($this->request->data['email']);
			}
                if (stristr($stremails, ",")) {
                $str = "";
                $CompanyUser = ClassRegistry::init('CompanyUser');
                $UserInvitation = ClassRegistry::init('UserInvitation');
                $mail_arr1 = explode(",", urldecode(trim(trim($this->request->data['email']), ",")));
                $cnt = 0;
                $mail_arr = array();
                foreach ($mail_arr1 AS $key => $val) {
                    if (trim($val) != "") {
                        $cnt ++;
                        $mail_arr[] = $val;
                    }
                }
                //Checking limitation of users 
                $totalusers_cnt = $cnt + $GLOBALS['usercount'];
                    if ((strtolower(trim($GLOBALS['Userlimitation']['user_limit'])) != "unlimited") && $totalusers_cnt > $GLOBALS['Userlimitation']['user_limit'] && $role_id != 699) {
                    echo "errorlimit";
                    exit;
                }
                    if($role_id == 699){
                        if($this->User->allowedGuestUserCount($cnt) == "excess"){
                            echo "errorlimit";
                            exit;
                        }
                    }

                for ($i = 0; $i < count($mail_arr); $i++) {
                    if (trim($mail_arr[$i]) != "") {
                        $mail_arr[$i] = trim($mail_arr[$i]);
                        $checkUsr = $this->User->find('first', array('conditions' => array('User.email' => $mail_arr[$i]), 'fields' => array('User.id')));
							if(!empty($checkUsr)){
                        $user_id = $checkUsr['User']['id'];
                        if ($user_id) {
                            $ui = $UserInvitation->find('first', array('conditions' => array('UserInvitation.company_id' => SES_COMP, 'UserInvitation.user_id' => $user_id), 'fields' => array('UserInvitation.user_id')));
                            if ($ui['UserInvitation']['user_id']) {
                                $str = $mail_arr[$i] . ",";
                                break;
                            } else {
                                $cu = $CompanyUser->find('first', array('conditions' => array('CompanyUser.company_id' => SES_COMP, 'CompanyUser.user_id' => $user_id, 'CompanyUser.is_active !=3'), 'fields' => array('CompanyUser.id')));
                                if ($cu['CompanyUser']['id']) {
                                    $str = $mail_arr[$i] . ",";
                                    break;
                                }
                            }
                        }
                    }
                }
                    }
                $str = trim($str);
                $str = trim($str, ",");
                if (trim($str) == "") {
                    echo "success";
                    exit;
                } else {
                    echo $str;
                    exit;
                }
            } else {
                $checkUsr = $this->User->find('first', array('conditions' => array('User.email' => urldecode($this->request->data['email'])), 'fields' => array('User.id')));
                $user_id = $checkUsr['User']['id'];

                if ($user_id) {
                    if ($user_id == SES_ID) {
                        echo "account";
                        exit;
                    }
                    $UserInvitation = ClassRegistry::init('UserInvitation');
                    $ui = $UserInvitation->find('first', array('conditions' => array('UserInvitation.company_id' => SES_COMP, 'UserInvitation.user_id' => $user_id), 'fields' => array('UserInvitation.id')));
                    if ($ui['UserInvitation']['id']) {
                        echo "invited";
                    } else {
                        $CompanyUser = ClassRegistry::init('CompanyUser');
                        $cu = $CompanyUser->find('first', array('conditions' => array('CompanyUser.company_id' => SES_COMP, 'CompanyUser.user_id' => $user_id, 'CompanyUser.user_type' => 1), 'fields' => array('CompanyUser.id')));
                        if ($cu['CompanyUser']['id']) {
                            echo "owner";
                        } else {
                            $chku = $CompanyUser->find('first', array('conditions' => array('CompanyUser.company_id' => SES_COMP, 'CompanyUser.user_id' => $user_id, 'CompanyUser.is_active !=3'), 'fields' => array('CompanyUser.id')));
                            if ($chku['CompanyUser']['id']) {
                                echo "exists";
                            }
                        }
                    }
                }
            }
        }
        exit;
    }

    function check_email_reg() {
        $this->layout = 'ajax';
        $this->User->recursive = -1;
        if ($this->request->data['email']) {
            $checkUsr = $this->User->find('first', array('conditions' => array('User.email' => urldecode($this->request->data['email'])), 'fields' => array('User.id')));
            if ($checkUsr['User']['id']) {
                echo $checkUsr['User']['id'];
            }
        }exit;
    }

    function check_short_name_reg() {
        $this->layout = 'ajax';

        $this->User->recursive = -1;
        if ($this->request->data['short_name']) {
            $checkUsr = $this->User->find('first', array('conditions' => array('User.short_name' => urldecode($this->request->data['short_name'])), 'fields' => array('User.id')));
            if ($checkUsr['User']['id']) {
                echo $checkUsr['User']['id'];
            }
        }
        exit;
    }

    function check_url_reg() {
        $this->layout = 'ajax';

        $Company = ClassRegistry::init('Company');
        $Company->recursive = -1;

        $seo_url = urldecode(trim($this->request->data['seo_url']));
        if ($seo_url == 'app' || $seo_url == 'www' || $seo_url == 'helpdesk' || $seo_url == 'api') {
            echo "#notallowed#";
        } else {
            $checkUsr = $Company->find('first', array('conditions' => array('Company.seo_url' => $seo_url), 'fields' => array('Company.id')));
            if ($checkUsr['Company']['id']) {
                echo "#exists#";
            } else {
                echo $seo_url;
            }
        }
        exit;
    }

    function confirmation($uniq_id = NULL) {
        $chkActivation = $this->User->find('first', array('conditions' => array('User.verify_string' => $uniq_id)));
        /* echo "<pre>";
          print $uniq_id;
          print_r($chkActivation);exit; */
        if ($chkActivation['User']['id'] && trim($uniq_id)) {
            $usr['User']['id'] = $chkActivation['User']['id'];
            $usr['User']['name'] = $chkActivation['User']['name'];
            $usr['User']['isactive'] = 1;
            $usr['User']['verify_string'] = "";
            //getting company id
            $comp = ClassRegistry::init('CompanyUser')->find('first', array('conditions' => array('CompanyUser.user_id' => $chkActivation['User']['id'], 'CompanyUser.user_type' => 1), 'fields' => array('CompanyUser.company_id', 'CompanyUser.user_id')));
            $comp_id = $comp['CompanyUser']['company_id']; //company id
            //Get all template modules data
            $all_pj_temp = ClassRegistry::init('DefaultProjectTemplate')->find('all', array('fields' => array('DefaultProjectTemplate.id', 'DefaultProjectTemplate.module_name')));

            $this->loadModel('ProjectTemplateCase');
            $this->loadModel('ProjectTemplate');
            $this->loadModel('Project');
            if ($this->User->save($usr)) {
                $notification['user_id'] = $chkActivation['User']['id'];
                $notification['type'] = 1;
                $notification['value'] = 0;
                $notification['due_val'] = 0;
                ClassRegistry::init('UserNotification')->save($notification);

                //Store default task templates to company
                $this->loadModel('DefaultTemplate');
                $this->DefaultTemplate->store_default_to_cstmpl(array($comp_id));

                //Event log data and inserted into database in account creation--- Start
                $json_arr['name'] = $chkActivation['User']['name'];
                $json_arr['usersub_type'] = $chkActivation['User']['user_type'] ? 'Paid' : 'Free';
                $json_arr['date'] = GMT_DATETIME;
                $this->Postcase->eventLog($comp_id, $chkActivation['User']['id'], $json_arr, 24);
                //End 
                $first_login = 0;
                if ($chkActivation['User']['usersub_type']) {
                    $first_login = 1;
                }
                $this->login(NULL, $chkActivation['User']['email'], $chkActivation['User']['password'], $first_login);
            }
        }
        if (CHECK_DOMAIN && CHECK_DOMAIN == "www") {
            $this->redirect(HTTP_APP . "users/login");
        } else {
            $this->redirect(HTTP_ROOT . "users/login");
        }
        exit;
    }

    function add_default_template($user_id = NULL, $company_id = NULL) {
        if (trim($user_id) && trim($company_id)) {
            $this->loadModel("CaseTemplate");
            $case_template = $this->CaseTemplate->getCaseTemplateFields(array('CaseTemplate.user_id' => $user_id, 'CaseTemplate.company_id' => $company_id), array('id'));
            if (empty($case_template)) {
                $default_template = Configure::read('default_template');
                foreach ($default_template as $key => $value) {
                    $template['user_id'] = $user_id;
                    $template['company_id'] = $company_id;
                    $template['name'] = $value['name'];
                    $template['description'] = $value['description'];
                    $template['is_active'] = 1;

                    //print '<pre>';print_r($template);exit;
                    $this->CaseTemplate->id = '';
                    $this->CaseTemplate->save($template);
                }
                $return = 1;
            } else
                $return = 0;
        } else
            $return = 0;
        return $return;
    }

    function launchpad() {
        $this->layout = 'default_outer';
            setcookie('CPUID', '', -1, '/', DOMAIN_COOKIE, false, false);
            Cache::delete('userRole'.SES_COMP.'_'.SES_ID);

        $CompanyUser = ClassRegistry::init('CompanyUser');
        $checkCmnpyUsr = $CompanyUser->find('all', array('conditions' => array('CompanyUser.user_id' => $this->Auth->user('id'), 'CompanyUser.is_active' => 1), 'fields' => array('CompanyUser.company_id', 'CompanyUser.user_type')));

        $companyIds = array();
        $companyOwnerIds = array();
        foreach ($checkCmnpyUsr as $cu) {
            $companyIds[] = $cu['CompanyUser']['company_id'];
            if ($cu['CompanyUser']['user_type'] == 1) {
                $companyOwnerIds[] = $cu['CompanyUser']['company_id'];
            }
        }

        if (count($companyOwnerIds) == 1) {
            $companyOwnerIds = $companyOwnerIds[0];
        }
        
        $Company = ClassRegistry::init('Company');
        $allCompany = $Company->find('all', array('conditions' => array('Company.id' => $companyIds, 'OR' => array('Company.is_active' => 1, 'Company.id' => $companyOwnerIds)), 'fields' => array('Company.seo_url', 'Company.id', 'Company.name')));
        $this->User->id = $this->Auth->user('id');
			$this->User->saveField('dt_last_login', GMT_DATETIME);
			$this->User->saveField('is_online', 1);
        $this->redirect(HTTP_ROOT);
        $this->set('allCompany', $allCompany);
    }

    /* function update_notification() 
      {
      $this->layout='ajax';

      $UserNotification = ClassRegistry::init('UserNotification');

      $this->User->recursive = -1;
      //$getAllUsr = $this->User->find('all',array('conditions'=>array('User.istype'=>1,'User.isactive'=>1)));

      $getAllUsr = $this->User->find('all');

      foreach($getAllUsr as $usr) {

      //$getAllNot = $UserNotification->find('first',array('conditions'=>array('UserNotification.user_id'=>$usr['User']['id'])));

      //$notif['id'] = $getAllNot['UserNotification']['id'];
      $notif['user_id'] = $usr['User']['id'];
      $notif['type'] = 0;
      $notif['value'] = 0;
      $notif['due_val'] = 0;
      $notif['new_case'] = 1;
      $notif['reply_case'] = 1;
      $UserNotification->saveAll($notif);
      }
      exit;

      }
      function update_companyuser()
      {
      $this->layout='ajax';

      $CompanyUser = ClassRegistry::init('CompanyUser');

      $this->User->recursive = -1;
      $getAllUsr = $this->User->find('all',array('conditions'=>array('User.isactive'=>0)));

      foreach($getAllUsr as $usr) {

      $getComUsr = $CompanyUser->find('first',array('conditions'=>array('CompanyUser.user_id'=>$usr['User']['id'])));

      $compusr['id'] = $getComUsr['CompanyUser']['id'];
      $compusr['is_active'] = 0;

      $CompanyUser->saveAll($compusr);
      }
      exit;

      } */

    function email_notification() {
        $UserNotification = ClassRegistry::init('UserNotification');

        $getAllNot = $UserNotification->find('first', array('conditions' => array('UserNotification.user_id' => SES_ID)));
        $this->set('getAllNot', $getAllNot);
        $DailyupdateNotification = ClassRegistry::init('DailyupdateNotification');
        $getAllDailyupdateNot = $DailyupdateNotification->find('first', array('conditions' => array('DailyupdateNotification.user_id' => SES_ID)));
        $this->set('getAllDailyupdateNot', $getAllDailyupdateNot);
        /* $this->User->recursive = -1;
          $getUsrNot = $this->User->find('first',array('conditions'=>array('User.id'=>SES_ID)));
          $this->set('getUsrNot',$getUsrNot); */
        //echo "<pre>";print_r($getAllNot);print_r($getAllDailyupdateNot);exit;

        if ($this->request->data) {
            $this->request->data['User']['id'] = SES_ID;
//			if(ACT_TAB_ID>1 && ($this->data['category_tab']==1)){
//				$this->request->data['User']['active_dashboard_tab']=1;
//				define('ACT_TAB_ID',1);
//			}elseif(ACT_TAB_ID<=1 && ($this->data['category_tab']>1)){
//				$this->request->data['User']['active_dashboard_tab']=15;//Default 4tabs active(Sum of there binary value)
//				define('ACT_TAB_ID',15);
//			}
            if (!isset($this->request->data['User']['desk_notify'])) {
                $this->request->data['User']['desk_notify'] = 0;
            }
            $this->User->save($this->request->data['User']);
        }
        if (isset($this->request->data['UserNotification'])) {
            $this->request->data['UserNotification']['user_id'] = SES_ID;
            $this->request->data['UserNotification']['id'] = $getAllNot['UserNotification']['id'];
            $UserNotification->save($this->request->data['UserNotification']);
        }
        if (isset($this->request->data['DailyupdateNotification'])) {
            $data['DailyupdateNotification']['id'] = $getAllDailyupdateNot['DailyupdateNotification']['id'];
            $data['DailyupdateNotification']['user_id'] = SES_ID;
            $data['DailyupdateNotification']['status'] = 0;
            if ($this->request->data['DailyupdateNotification']['dly_update'] == 1) {
                $data['DailyupdateNotification']['dly_update'] = 1;
                $data['DailyupdateNotification']['notification_time'] = $this->request->data['DailyupdateNotification']['not_hr'] . ':' . $this->request->data['DailyupdateNotification']['not_mn'];
                $comma_separated = implode(",", $this->request->data['DailyupdateNotification']['proj_name']);
                $data['DailyupdateNotification']['proj_name'] = trim($comma_separated, ',');
            } else {
                $data['DailyupdateNotification']['dly_update'] = 0;
                $data['DailyupdateNotification']['notification_time'] = '';
                $data['DailyupdateNotification']['proj_name'] = '';
            }
            $DailyupdateNotification->save($data['DailyupdateNotification']);

            /* $userData['User']['id'] = SES_ID;
              $userData['User']['isemail'] = $this->request->data['User']['isemail'];
              $this->User->save($userData); */

                $this->Session->write("SUCCESS", __("Notification settings saved successfully",true));
            //$this->redirect(HTTP_ROOT."users/email_notification");
            $this->redirect(HTTP_ROOT . "users/email_notifications");
        }
    }

    function latest() {
        
    }

    function feedback() {
        $this->layout = 'ajax';
        $response = "error";
        if ($this->request->data['email'] && $this->request->data['message'] && $this->request->data['sbject'] && $this->request->data['js_captcha'] && $this->request->data['hid_captcha']) {
            $email = trim($this->request->data['email']);
            $message = trim(htmlentities(strip_tags($this->request->data['message'])));
            $sbject = trim(htmlentities(strip_tags($this->request->data['sbject'])));
            $js_captcha = trim($this->request->data['js_captcha']);
            $hid_captcha = trim($this->request->data['hid_captcha']);

            if ($js_captcha == $hid_captcha) {
                if ($this->Format->validateEmail($email)) {
                    $message = $this->Format->emailBodyFilter($message);
                    //$sentAt = gmdate("m/d/Y g:i A");
                    $curdate = gmdate("Y-m-d H:i:s");
                    App::import('Helper', 'Tmzone');
                    $tmzone = new TmzoneHelper(new View(null));
                    $sentAt = $tmzone->GetDateTime(5, -8, 1, "P", $curdate, "datetime");
                    $sentAt = date('m/d/Y g:i A', strtotime($sentAt));
                    $to = SUPPORT_EMAIL;
                    $subject = "[Feedback on Orangescrum] " . $sbject;
                    $ip = $this->Format->getRealIpAddr();
                    $location = $this->Format->iptoloccation($ip);
                    /* $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
                      if(isset($tags['city']) && isset($tags['region']) && isset($tags['country']) && $tags['city'])
                      {
                      $location = $tags['city'].", ".$tags['region'].", ".$tags['country'];
                      if(isset($tags['longitude']) && isset($tags['latitude'])) {
                      $location.= "\nIP: ".$ip.", lon/lat: ".$tags['longitude']."/".$tags['latitude'];
                      }
                      }
                      else {
                      $location.= "\nIP: ".$ip;
                      } */
                    $message = "<table cellpadding='0' cellspacing='0' align='left' width='100%'>
								" . EMAIL_HEADER . "
								<tr>
									<td align='left'>
										<table cellpadding='2' cellspacing='2' align='left'>
											<tr><td align='left' style='font-family:Arial;font-size:14px;'>Dear site administrator,</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;'>You're lucky today; you've got feedback from your users</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:10px;'><b>Subject:</b> " . $sbject . "</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:5px;'><b>User's Email:</b> " . $email . "</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:5px;'><b>Sent at:</b> " . $sentAt . " PST</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:5px;'><b>Comments:</b><br/>" . nl2br(stripslashes($message)) . "</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:10px;'><b>Location:</b><br/> " . $location . "</td></tr>
										</table>
									</td>
								</tr>
							</table>";
                    if ($this->Sendgrid->sendGridEmail(FROM_EMAIL, $to, $subject, $message, "Feedback")) {
                        $response = "success";
                    }
                } else {
                    $response = "email_error";
                }
            }
        }
        echo $response;
        exit;
    }

    function invitation($qstr = NULL) {
        $isValid = 0;
        if (trim($qstr)) {
            $isValid = 1;
            if (isset($this->request->data['User'])) {
                if ($this->request->data['User']['name'] && $this->request->data['User']['last_name'] && $this->request->data['User']['password'] && $this->request->data['User']['qstr']) {
                    $this->request->data['User']['name'] = trim($this->request->data['User']['name']);
                    $this->request->data['User']['last_name'] = trim($this->request->data['User']['last_name']);
                    $this->request->data['User']['short_name'] = $this->Format->makeShortName($this->request->data['User']['name'], $this->request->data['User']['last_name']);

                    $qstr = $this->request->data['User']['qstr'];
                    $this->loadModel('Timezone');
                    $getTmz = $this->Timezone->find('first', array('conditions' => array('Timezone.gmt_offset' => urldecode($this->request->data['User']['timezone_id']))));
                    $timezone_id = $getTmz['Timezone']['id'];
                    $UserInvitation = ClassRegistry::init('UserInvitation');
                    $usrInvt = $UserInvitation->find('first', array('conditions' => array('UserInvitation.qstr' => $qstr, 'UserInvitation.is_active' => 1)));

                    if ($usrInvt['UserInvitation']['user_id']) {
                        $this->request->data['User']['id'] = $usrInvt['UserInvitation']['user_id'];
                        $this->request->data['User']['password'] = md5($this->request->data['User']['password']);
                        $this->request->data['User']['isactive'] = 1;
                        $this->request->data['User']['timezone_id'] = $timezone_id;
                        $this->request->data['User']['ip'] = $_SERVER['REMOTE_ADDR'];

                        $this->User->save($this->request->data);
                        $notification['user_id'] = $usrInvt['UserInvitation']['user_id'];
                        $notification['type'] = 1;
                        $notification['value'] = 1;
                        $notification['due_val'] = 1;
                        ClassRegistry::init('UserNotification')->save($notification);
                        $this->redirect(HTTP_ROOT . "users/invitation/" . $qstr);
                    }
                }
            }

            $UserInvitation = ClassRegistry::init('UserInvitation');
            $ui = $UserInvitation->find('first', array('conditions' => array('UserInvitation.qstr' => $qstr)));
            if ($ui['UserInvitation']['user_id']) {
                $Company = ClassRegistry::init('Company');
                $getComp = $Company->find('first', array('conditions' => array('Company.id' => $ui['UserInvitation']['company_id'])));
                $getUsr = $this->User->find('first', array('conditions' => array('User.id' => $ui['UserInvitation']['user_id'])));
                if ($getUsr['User']['id']) {
                    if (!$getUsr['User']['password'] && !$getUsr['User']['dt_last_login']) {
                        $email = $getUsr['User']['email'];
                    } else {
                        $usrInvt['UserInvitation']['id'] = $ui['UserInvitation']['id'];
                        $usrInvt['UserInvitation']['is_active'] = 0;
                        $UserInvitation->save($usrInvt);
                        if ($ui['UserInvitation']['is_active'] == 1) {
                            $comp_dtl = ClassRegistry::init('CompanyUser')->find('first', array('conditions' => array('CompanyUser.user_id' => $ui['UserInvitation']['user_id'], 'CompanyUser.company_id' => $ui['UserInvitation']['company_id'], 'CompanyUser.user_type' => $ui['UserInvitation']['user_type'], 'CompanyUser.is_active' => 2), 'fields' => array('CompanyUser.id')));
                            $CompanyUser = ClassRegistry::init('CompanyUser');
                            $cmpnyUsr['CompanyUser']['id'] = $comp_dtl['CompanyUser']['id'];
                            $cmpnyUsr['CompanyUser']['is_active'] = 1;
                            $cmpnyUsr['CompanyUser']['act_date'] = GMT_DATETIME;
                            if ($CompanyUser->save($cmpnyUsr)) {
                                //$json_arr = array('activation_date'=>GMT_DATETIME,'desc'=>'User confirmation by clicking on the activation link');
                                $comp_user_id = $CompanyUser->getLastInsertID();
                                //$this->update_bt_subscription($comp_user_id,$ui['UserInvitation']['company_id'],1);
                            }
                            //Event log data and inserted into database in account creation--- Start
                            $json_arr['email'] = $getUsr['User']['email'];
                            $json_arr['name'] = $getUsr['User']['name'] . " " . $getUsr['User']['last_name'];
                            $json_arr['created'] = GMT_DATETIME;
                            $this->Postcase->eventLog($ui['UserInvitation']['company_id'], $getUsr['User']['id'], $json_arr, 26);
                            //End 
                            if ($ui['UserInvitation']['project_id']) {
                                $ProjectUser = ClassRegistry::init('ProjectUser');
                                $ProjectUser->recursive = -1;
                                $getLastId = $ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
                                $nextid = $getLastId[0][0]['maxid'] + 1;
								$projectids = array();
                                if (strstr($ui['UserInvitation']['project_id'], ',')) {
                                    $projectids = explode(',', $ui['UserInvitation']['project_id']);
                                } else {
                                    $projectids[] = $ui['UserInvitation']['project_id'];
                                }
                                foreach ($projectids as $key => $val) {
                                    if (trim($val)) {
                                        $projUsr['ProjectUser']['id'] = $nextid;
                                        $projUsr['ProjectUser']['user_id'] = $ui['UserInvitation']['user_id'];
                                        $projUsr['ProjectUser']['project_id'] = trim($val);
                                        $projUsr['ProjectUser']['company_id'] = $ui['UserInvitation']['company_id'];
                                        $projUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                                        $ProjectUser->create();
                                        $ProjectUser->save($projUsr);
                                    }
                                }
                            }

                            $usr['User']['id'] = $ui['UserInvitation']['user_id'];
                            $usr['User']['isactive'] = 1;
                            //$this->User->save($usr);
                            $this->User->query("UPDATE users set isactive='1' where id='" . $usr['User']['id'] . "'");
                            if (defined('SES_ID') && SES_ID && (SES_ID != $ui['UserInvitation']['user_id'])) {
                                $this->Auth->logout();
                                $this->redirect(HTTP_ROOT . 'users/logout/' . $ui['UserInvitation']['user_id']);
                                exit;
                            } else {
                                $this->login(NULL, $getUsr['User']['email'], $getUsr['User']['password']);
                            }
                        } else if ($ui['UserInvitation']['is_active'] == 0) { // for new invite process 10-30-2014(m-d-y)
                            if (defined('SES_ID') && SES_ID && (SES_ID != $ui['UserInvitation']['user_id'])) {
                                $this->Auth->logout();
                                $this->redirect(HTTP_ROOT . 'users/logout/' . $ui['UserInvitation']['user_id']);
                                exit;
                            } else {
                                $this->login(NULL, $getUsr['User']['email'], $getUsr['User']['password']);
                            }
                        }
                        $this->redirect(HTTP_APP);
                        //$this->redirect(HTTP_ROOT);
                        //$this->login(NULL,$getUsr['User']['email'],$getUsr['User']['password']);
                    }
                } else {
                    $isValid = 0;
                }
            } else {
                $isValid = 0;
            }
            $this->set('email', $email);
            $this->set('qstr', $qstr);
            $this->set('company_name', $getComp['Company']['name']);
        }
        if (!$isValid) {
            $this->redirect(HTTP_APP);
        }
    }	
				function tasks(){
					$this->layout = 'default_inner';
				}
        function manage($input=null) {			
        //echo "<pre>";print_r($this->request);exit;
        $this->set('istype', $this->Auth->user('istype'));
        $search_key = $this->request->query['user_srch'];
        $search_query = "User.name LIKE '%$search_key%' OR User.last_name LIKE '%$search_key%' OR User.email  LIKE '%$search_key%' OR User.short_name  LIKE '%$search_key%'";
        $page_limit = CASE_PAGE_LIMIT;
        $page_limit = 25;
        $CompanyUser = ClassRegistry::init('CompanyUser');

        if (isset($_GET['del']) && trim(urldecode($_GET['del'])) != "") {
            $del = urldecode($_GET['del']);
            $del = addslashes($del);
            $getUsr = $this->User->find('first', array('conditions' => array('User.uniq_id' => $del), 'fields' => array('User.id', 'User.email', 'User.name', 'User.last_name')));
            $CompanyUser->deleteAll(array('user_id' => $getUsr['User']['id'], 'company_id' => SES_COMP, 'user_type!=1'));
                $ProjectUser = ClassRegistry::init('ProjectUser');
                  $project_user = $ProjectUser->find('all', array('conditions' => array('ProjectUser.user_id' => $getUsr['User']['id'], 'ProjectUser.company_id' => SES_COMP, 'ProjectUser.istype!=1')));
																if(!empty($project_user)){                  
                  foreach ($project_user as $key => $val) {
                      $ProjectUser->delete(array('ProjectUser.id' => $val['ProjectUser']['id']));
                  }
                }
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $UserInvitation->query("DELETE FROM user_invitations WHERE user_id='" . $getUsr['User']['id'] . "' AND company_id='" . SES_COMP . "'");
            $invit = $UserInvitation->find('first', array('conditions' => array('UserInvitation.user_id' => $getUsr['User']['id'])));

            //Event log data and inserted into database in account creation--- Start
            $json_arr['email'] = $getUsr['User']['email'];
                $json_arr['name'] = $getUsr['User']['name'] . " " . $getUsr['User']['last_name'];
            $json_arr['created'] = GMT_DATETIME;
            $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 3);			
			$this->User->query("DELETE FROM users WHERE id='" . $getUsr['User']['id']."'");
            //End 
			$this->Session->write("SUCCESS", __("user deleted successfully",true));
			$this->redirect(HTTP_ROOT . "users/manage/?role=all");
        }
        if (isset($_GET['act']) && trim(urldecode($_GET['act'])) != "") {
            if (strtolower($GLOBALS['Userlimitation']['user_limit']) != "unlimited") {
                    if (($GLOBALS['usercount'] >= $GLOBALS['Userlimitation']['user_limit']) || ($this->User->allowedGuestUserCount() == "excess")) {
                        $this->Session->write("ERROR", __("Sorry! User cannot be enabled. User Limit Exceeded!.<br />Please upgrade your account to enable more users.",true));
                    $this->redirect(HTTP_ROOT . "users/manage/?type=1&role=" . $_GET['role']);
                    exit;
                }
            }
            if ($GLOBALS['trial_expired'] == 1) {
                $this->Session->write("ERROR", "Sorry! User cannot be enabled.<br />Please upgrade your account to enable more users.");
                $this->redirect(HTTP_ROOT . "users/manage/?type=1&role=" . $_GET['role']);
                exit;
            }
            $act = urldecode($_GET['act']);
            $act = addslashes($act);
            $getUsr = $this->User->find('first', array('conditions' => array('User.uniq_id' => $act), 'fields' => array('User.id', 'User.email', 'User.name', 'User.last_name')));
            //Below code are written for the subscription i.e in case a disabled user get activated during a subscribed period	
            $comp_user = $CompanyUser->find('first', array('conditions' => array('user_id' => $getUsr['User']['id'], 'company_id' => SES_COMP)));
            if ($GLOBALS['Userlimitation']['btsubscription_id']) {
                if (strtotime($comp_user['CompanyUser']['billing_end_date']) < strtotime($GLOBALS['Userlimitation']['next_billing_date'])) {
                    //$this->update_bt_subscription($comp_user['CompanyUser']['id'], $comp_user['CompanyUser']['company_id'], 2);
                }
            }
            $CompanyUser->query("UPDATE company_users as CompanyUser SET CompanyUser.is_active='1' WHERE CompanyUser.user_id='" . $getUsr['User']['id'] . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.user_type!='1'");

            $CompanyUser->updateUserPerm(SES_COMP, $getUsr['User']['id'], 0);

            //Event log data and inserted into database in account creation--- Start
            $json_arr['email'] = $getUsr['User']['email'];
                $json_arr['name'] = $getUsr['User']['name'] . " " . $getUsr['User']['last_name'];
            $json_arr['created'] = GMT_DATETIME;
            $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 28);
            //End 
                $this->Session->write("SUCCESS", __("User enabled successfully",true));
            $this->redirect(HTTP_ROOT . "users/manage/?role=" . $_GET['role']);
        }
        if (isset($_GET['deact']) && trim(urldecode($_GET['deact'])) != "") {
            $deact = urldecode($_GET['deact']);
            $deact = addslashes($deact);
            $getUsr = $this->User->find('first', array('conditions' => array('User.uniq_id' => $deact), 'fields' => array('User.id', 'User.email', 'User.name', 'User.last_name')));
            $CompanyUser->query("UPDATE company_users as CompanyUser SET CompanyUser.is_active='0' WHERE CompanyUser.user_id='" . $getUsr['User']['id'] . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.user_type!='1'");

            $CompanyUser->updateUserPerm(SES_COMP, $getUsr['User']['id'], 8);

            //Event log data and inserted into database in account creation--- Start
            $json_arr['email'] = $getUsr['User']['email'];
                $json_arr['name'] = $getUsr['User']['name'] . " " . $getUsr['User']['last_name'];
            $json_arr['created'] = GMT_DATETIME;
            $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 27);
            //End 
                $this->Session->write("SUCCESS", __("User disabled successfully",true));
            $this->redirect(HTTP_ROOT . "users/manage");
        }
        if (isset($_GET['grant_admin']) && trim(urldecode($_GET['grant_admin'])) != "") {
            $grant_admin = urldecode($_GET['grant_admin']);
            $grant_admin = addslashes($grant_admin);
            $getUsr = $this->User->find('first', array('conditions' => array('User.uniq_id' => $grant_admin), 'fields' => array('User.id')));
                $CompanyUser->query("UPDATE company_users as CompanyUser SET CompanyUser.user_type='2',CompanyUser.role_id='2' WHERE CompanyUser.user_id='" . $getUsr['User']['id'] . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.user_type!='1'");

            $CompanyUser->updateUserPerm(SES_COMP, $getUsr['User']['id'], 3);

			/* Send push notification to user who is granted as ADMIN starts here */
			
				$grantAdminUser = $getUsr['User']['id'];
						
				$getUserDetails = $this->User->query("SELECT `name` FROM `users` WHERE `id`='".$grantAdminUser."'");
				$userName = $getUserDetails[0]['users']['name'];
				
				$notifyAndAssignToMeUsers = array($grantAdminUser);
				$notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
				
				//$messageToSend = "Granted admin privilege to '".$userName."'.";
				$messageToSend = __("You have been granted Admin Privileges.");
				$this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
				$this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);
			
			/* Send push notification to user who is granted as ADMIN ends here */
                $this->Session->write("SUCCESS", __("Granted admin privilege",true));
            $this->redirect(HTTP_ROOT . "users/manage");
        }
        if (isset($_GET['grant_client']) && trim(urldecode($_GET['grant_client'])) != "") {
            $grant_client = urldecode($_GET['grant_client']);
            $usr = $this->User->find('first', array('conditions' => array('User.uniq_id' => $grant_client), 'fields' => array('User.id')));
            if ($usr) {
                //print_r($usr);exit;
                $id = $usr['User']['id'];
                    $d = $CompanyUser->find('first',array('conditions'=>array('CompanyUser.user_id'=>$id,'CompanyUser.company_id'=>SES_COMP,'CompanyUser.user_type !='=>1),'fields'=>array('CompanyUser.user_type')));
                    if($d['CompanyUser']['user_type'] == 2){
                        $ut = 2;
                        $rt =2;
                    }else{
                         $ut = 3;
                         $rt = 4;
                    }
                    $CompanyUser->query("UPDATE company_users as CompanyUser SET CompanyUser.is_client='1',CompanyUser.user_type='".$ut."',CompanyUser.role_id='".$rt."' WHERE CompanyUser.user_id='" . $id . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.user_type!='1'");

                $CompanyUser->updateUserPerm(SES_COMP, $usr['User']['id'], 4);
                $this->Session->write("SUCCESS", __("Granted client privilege",true));
				
				/* Send push notification to user who is granted as CLIENT starts here */
			
					$grantClientUser = $id;
							
					$getUserDetails = $this->User->query("SELECT `name` FROM `users` WHERE `id`='".$grantClientUser."'");
					$userName = $getUserDetails[0]['users']['name'];
					
					$notifyAndAssignToMeUsers = array($grantClientUser);
					$notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
					
					//$messageToSend = "Granted client privilege to '".$userName."'.";
					$messageToSend = __("You have been granted Client Privilege.");
					$this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
					$this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);

				/* Send push notification to user who is granted as CLIENT ends here */
                $this->redirect(HTTP_ROOT . "users/manage");
            } else {
                $this->redirect(HTTP_ROOT . "users/manage");
            }
        }

        if (isset($_GET['revoke_client']) && trim(urldecode($_GET['revoke_client'])) != "") {
            $revoke_client = urldecode($_GET['revoke_client']);
            $usr = $this->User->find('first', array('conditions' => array('User.uniq_id' => $revoke_client), 'fields' => array('User.id')));
            if ($usr) {
                //print_r($usr);exit;
                $id = $usr['User']['id'];
                //print_r($id);exit;			
                     $d = $CompanyUser->find('first',array('conditions'=>array('CompanyUser.user_id'=>$id,'CompanyUser.company_id'=>SES_COMP,'CompanyUser.user_type !='=>1),'fields'=>array('CompanyUser.user_type')));
                    if($d['CompanyUser']['user_type'] == 2){
                        $ut = 2;
                        $rt =2;
                    }else{
                         $ut = 3;
                         $rt = 3;
                    }		
                    $CompanyUser->query("UPDATE company_users as CompanyUser SET CompanyUser.is_client='0',CompanyUser.user_type='".$ut."',CompanyUser.role_id='".$rt."' WHERE CompanyUser.user_id='" . $id . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.user_type!='1'");

                $CompanyUser->updateUserPerm(SES_COMP, $usr['User']['id'], 0);

                    $this->Session->write("SUCCESS", __("Revoked client privilege",true));
				/* Send push notification to user who is revoked as CLIENT starts here */
			
					$grantClientUser = $id;
							
					$getUserDetails = $this->User->query("SELECT `name` FROM `users` WHERE `id`='".$grantClientUser."'");
					$userName = $getUserDetails[0]['users']['name'];
					
					$notifyAndAssignToMeUsers = array($grantClientUser);
					$notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
					
					//$messageToSend = "Revoked client privilege from '".$userName."'.";
					$messageToSend = __("Your client privilege has been revoked.");
					$this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
					$this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);
				
				/* Send push notification to user who is revoked as CLIENT ends here */
                $this->redirect(HTTP_ROOT . "users/manage");
            } else {
                $this->redirect(HTTP_ROOT . "users/manage");
            }
        }

        if (isset($_GET['revoke_admin']) && trim(urldecode($_GET['revoke_admin'])) != "") {
            $revoke_admin = urldecode($_GET['revoke_admin']);
            $revoke_admin = addslashes($revoke_admin);
            $getUsr = $this->User->find('first', array('conditions' => array('User.uniq_id' => $revoke_admin), 'fields' => array('User.id')));
                $CompanyUser->query("UPDATE company_users as CompanyUser SET CompanyUser.user_type='3',CompanyUser.role_id='3' WHERE CompanyUser.user_id='" . $getUsr['User']['id'] . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.user_type!='1'");

            $CompanyUser->updateUserPerm(SES_COMP, $getUsr['User']['id'], 0);

			/* Send push notification to user who is revoked as ADMIN starts here */
			
				$grantAdminUser = $getUsr['User']['id'];
						
				$getUserDetails = $this->User->query("SELECT `name` FROM `users` WHERE `id`='".$grantAdminUser."'");
				$userName = $getUserDetails[0]['users']['name'];
				
				$notifyAndAssignToMeUsers = array($grantAdminUser);
				$notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
				
				$messageToSend = __("Your admin privilege has been revoked.");
				$this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
				$this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);
			
			/* Send push notification to user who is revoked as ADMIN ends here */
                $this->Session->write("SUCCESS", __("Revoked admin privilege",true));
            $this->redirect(HTTP_ROOT . "users/manage");
        }
        if (isset($_GET['resend']) && trim(urldecode($_GET['resend'])) != "") {
            $resend = urldecode($_GET['resend']);
            $resend = addslashes($resend);
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $invit = $UserInvitation->find('first', array('conditions' => array('UserInvitation.qstr' => $resend)));

            if ($invit['UserInvitation']['user_id']) {
                $getUser = $this->User->find('first', array('conditions' => array('User.id' => $invit['UserInvitation']['user_id'])));

                $Company = ClassRegistry::init('Company');
                $comp = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('Company.id', 'Company.name', 'Company.uniq_id')));

                $expEmail = explode("@", $getUser['User']['email']);
                $expName = $expEmail[0];

                $qstr = $this->Format->generateUniqNumber();
                $loggedin_users = $this->Format->getUserNameForEmail($this->Auth->User("id"));
                $fromName = ucfirst($loggedin_users['User']['name']);
                $fromEmail = $loggedin_users['User']['email'];

                $ext_user = '';
                if (!$getUser['User']['password']) {
                    $subject = $fromName . " added you to " . $comp['Company']['name'] . " on Orangescrum";
                    $ext_user = 1;
                } else {
                    $subject = $fromName . " added you to join on Orangescrum";
                }

                $this->Email->delivery = 'smtp';
                $this->Email->to = $to;
                $this->Email->subject = $subject;
                $this->Email->from = FROM_EMAIL;
                $this->Email->template = 'invite_user';
                $this->Email->sendAs = 'html';
                $this->set('expName', ucfirst($expName));
                $this->set('qstr', $qstr);
                $this->set('existing_user', $ext_user);

                $this->set('company_name', $comp['Company']['name']);
                $this->set('fromEmail', $fromEmail);
                $this->set('fromName', $fromName);

				if(defined("PHPMAILER") && PHPMAILER == 1){				
					$this->Email->set_variables = $this->render('/Emails/html/invite_user',false);
					if($this->PhpMailer->sendPhpMailerTemplate($this->Email)){
						$UserInvitation->query("UPDATE user_invitations set qstr='" . $qstr . "' where qstr='" . $resend . "'");
						$this->Session->write("SUCCESS", "Invitation resent to '" . $getUser['User']['email'] . "'");
						$this->redirect(HTTP_ROOT . "users/manage/?role=invited");
					}
				}else{
                if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                    $UserInvitation->query("UPDATE user_invitations set qstr='" . $qstr . "' where qstr='" . $resend . "'");
                    $this->Session->write("SUCCESS", "Invitation resent to '" . $getUser['User']['email'] . "'");
                    $this->redirect(HTTP_ROOT . "users/manage/?role=invited");
                }
            }
        }
        }

        $query = "";
        if (isset($_GET['role']) && $_GET['role']) {
            $role = $_GET['role'];
        }
        if (isset($_GET['type']) && $_GET['type']) {
            $type = $_GET['type'];
        }
        if (isset($_GET['user_srch']) && $_GET['user_srch']) {
            $user_srch = htmlentities(strip_tags($_GET['user_srch']));
        }

        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        if ($role == "invited") {
            $query.= " AND UserInvitation.is_active = '1'";
        } else if ($role == "recent") {
            //$query.= " AND UserInvitation.is_active = '0' AND User.dt_last_login IS NULL";
            $query .= "";
        } else {
            if (!$role || $role == 'all') {
                $query.= " AND (CompanyUser.is_active = '1')";
            } else {
                if ($role == 2) {
                    $query.= " AND (CompanyUser.user_type = '" . $role . "' OR CompanyUser.user_type = '1')";
                } elseif ($role == 3) {
                    $query.= " AND CompanyUser.user_type = '" . $role . "' AND CompanyUser.is_active = '1' ";
                } elseif ($role == 'disable') {
                    $query.= " AND CompanyUser.is_active = '0'";
                }
            }
        }
        $page = 1;
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;

        if ($user_srch) {
            $user_srch = addslashes(urldecode(htmlentities(strip_tags($user_srch))));
            $query.= " AND (User.name LIKE '%" . $user_srch . "%' OR User.last_name LIKE '%" . $user_srch . "%' OR User.email LIKE '%" . $user_srch . "%' OR User.short_name LIKE '%" . $user_srch . "%')";
        }

        if (isset($_GET['user']) && $_GET['user']) {
            $query.= " AND (User.uniq_id = '" . $_GET['user'] . "')";
        }
        if ($role == "invited") {
            #$userArr = $this->User->query("SELECT SQL_CALC_FOUND_ROWS * FROM users AS User,user_invitations AS UserInvitation WHERE User.id=UserInvitation.user_id AND UserInvitation.company_id='" . SES_COMP . "' " . trim($query) . " ORDER BY User.dt_created DESC LIMIT $limit1,$limit2");
                $userArr = $this->User->query("SELECT SQL_CALC_FOUND_ROWS *,Role.role FROM company_users AS CompanyUser LEFT JOIN users AS User ON CompanyUser.user_id=User.id LEFT JOIN roles AS Role ON CompanyUser.role_id=Role.id WHERE CompanyUser.company_id=" . SES_COMP . "  AND CompanyUser.is_active ='2' AND User.email!='' AND (" . $search_query . ") ORDER BY User.dt_created DESC LIMIT $limit1,$limit2");
            #pr($userArr);exit;
        } else if ($role == "recent") {
            //print "SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT User.*,CompanyUser.company_id,CompanyUser.company_uniq_id,CompanyUser.user_id,CompanyUser.is_active,CompanyUser.act_date,CompanyUser.created FROM company_users AS CompanyUser LEFT JOIN users AS User ON CompanyUser.user_id=User.id WHERE CompanyUser.company_id=".SES_COMP."  AND CompanyUser.is_active ='1' AND CompanyUser.created > '".date('Y-m-d H:i:s',strtotime('-24 hours', time()))."' AND User.email !='' ORDER BY User.dt_created DESC) as User LEFT JOIN user_invitations AS UserInvitation ON User.user_id = UserInvitation.user_id WHERE 1 ".trim($query)." ORDER BY User.dt_created DESC LIMIT $limit1,$limit2";exit;
                $userArr = $this->User->query("SELECT SQL_CALC_FOUND_ROWS * FROM (SELECT User.*,CompanyUser.company_id,CompanyUser.company_uniq_id,CompanyUser.user_id,CompanyUser.is_active,CompanyUser.act_date,CompanyUser.created, CompanyUser.is_client,Role.role FROM company_users AS CompanyUser LEFT JOIN users AS User ON CompanyUser.user_id=User.id LEFT JOIN roles AS Role ON CompanyUser.role_id=Role.id  WHERE CompanyUser.company_id=" . SES_COMP . "  AND CompanyUser.is_active ='1' AND CompanyUser.created > '" . date('Y-m-d H:i:s', strtotime('-7 days', time())) . "' AND User.email !='' ORDER BY User.dt_created DESC) as User LEFT JOIN user_invitations AS UserInvitation ON User.user_id = UserInvitation.user_id WHERE UserInvitation.company_id=" . SES_COMP . " " . trim($query) . " ORDER BY User.dt_created DESC LIMIT $limit1,$limit2");
        } else if ($role == "client") {
                $userArr = $this->User->query("SELECT SQL_CALC_FOUND_ROWS *,Role.role FROM users As User, company_users AS CompanyUser LEFT JOIN roles AS Role ON CompanyUser.role_id=Role.id WHERE User.id=CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_client= '1'");
            //echo "<pre>";print_r($userArr);exit;
        } else {
                $userArr = $this->User->query("SELECT SQL_CALC_FOUND_ROWS *,Role.role FROM users AS User,company_users AS CompanyUser LEFT JOIN roles AS Role ON CompanyUser.role_id=Role.id WHERE User.id=CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' " . trim($query) . " ORDER BY User.dt_last_login DESC LIMIT $limit1,$limit2");
        }
        $tot = $this->User->query("SELECT FOUND_ROWS() as total");
        $totUser = count($userArr);
        $arrusr = array();
        App::import("Helper", array("Format", "Casequery", "Tmzone", "Datetime"));
        $hFormat = new FormatHelper(new View(null));
        $hCasequery = new CasequeryHelper(new View(null));
        $hTmzone = new TmzoneHelper(new View(null));
        $hDatetime = new DatetimeHelper(new View(null));

			if($totUser){
				$checkuids = Hash::extract($userArr, '{n}.User.id');
				$getCompany_count = $CompanyUser->query('SELECT count(user_id) as cnt,company_id,user_id FROM company_users as CompanyUser where user_id in('.implode(',',$checkuids).') GROUP BY user_id having cnt>1');
				$getCompany_count = Hash::extract($getCompany_count, '{n}.CompanyUser.user_id');
			}
			#pr($getCompany_count);exit;
			$this->set('userinmorecompany', $getCompany_count);
        foreach ($userArr as $key => $usrall) {
            $userArr[$key]['User']['name'] = $hFormat->formatText($usrall['User']['name']);
            $userArr[$key]['User']['short_name'] = $hFormat->formatText($usrall['User']['short_name']);
            $userArr[$key]['User']['email'] = $hFormat->formatText($usrall['User']['email']);
            $userArr[$key]['User']['shln_email'] = $hFormat->shortLength($usrall['User']['email'], 30);

            if (($role != 'invited') && ($usrall['CompanyUser']['is_active'] != 2)) {
                $getprj = $hCasequery->getallproject($usrall['User']['id']);
                $allpj = "";
                foreach ($getprj as $k => $v) {
                    $allpj = $allpj . ", " . ucwords(strtolower($v));
                }
                $userArr[$key]['User']['all_project_lst'] = trim($allpj, ',');
                //$userArr[$key]['User']['all_project'] = $hFormat->shortLength(trim($allpj, ","), 30);
                $userArr[$key]['User']['all_project'] = trim($allpj, ",");
                $userArr[$key]['User']['all_projects'] = trim($allpj, ",");
                $userArr[$key]['User']['total_project'] = count($getprj);
            } else {
                $allpj = $hCasequery->getallInvitedProj($usrall['CompanyUser']['project_id']);
                //$userArr[$key]['User']['all_project'] = $hFormat->shortLength(trim($allpj, ","), 30);
                $userArr[$key]['User']['all_project'] = trim($allpj, ",");
                $userArr[$key]['User']['all_project_lst'] = trim($allpj, ',');
                //$userArr[$key]['User']['total_project'] = count($getprj);
            }

            if ($role == 'invited' || $role == "all" || $role == "recent" || !$role || $role == "client") {
                if ($role == "recent") {
                    $userArr[$key]['User']['qstr'] = $hCasequery->getinviteqstr($usrall['User']['company_id'], $usrall['User']['user_id']);
                } else {
                    $userArr[$key]['User']['qstr'] = $hCasequery->getinviteqstr($usrall['CompanyUser']['company_id'], $usrall['CompanyUser']['user_id']);
                }
            } else if ($usrall['CompanyUser']['is_active'] == 2) {
                $userArr[$key]['User']['qstr'] = $hCasequery->getinviteqstr($usrall['CompanyUser']['company_id'], $usrall['CompanyUser']['user_id']);
            }

            if ($usrall['User']['dt_last_login']) {
                $locDT = $hTmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $usrall['User']['dt_last_login'], "datetime");
                $gmdate = $hTmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                $userArr[$key]['User']['latest_activity'] = $hDatetime->dateFormatOutputdateTime_day($locDT, $gmdate);
            }
            if ($role == "invited") {
                $crdt = $usrall['User']['dt_created'];
            } else if ($role == "recent") {
                $crdt = $usrall['User']['dt_created'];
            } else {
                $crdt = $usrall['CompanyUser']['created'];
            }

            if ($crdt != "0000-00-00 00:00:00") {
                $locDT = $hTmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $crdt, "datetime");
                $gmdate = $hTmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                $userArr[$key]['User']['created_on'] = $hDatetime->dateFormatOutputdateTime_day($locDT, $gmdate);
            }

            if (isset($usrall['User']['name']) && !empty($usrall['User']['name'])) {
                array_push($arrusr, substr(trim($usrall['User']['name']), 0, 1));
            }
        }
        $active_user_cnt = 0;
        $invited_user_cnt = 0;
        $disabled_user_cnt = 0;
        $grpcount = $CompanyUser->query('SELECT count(CompanyUser.id) as usrcnt , CompanyUser.is_active FROM company_users CompanyUser LEFT JOIN users User on CompanyUser.user_id=User.id WHERE CompanyUser.company_id=' . SES_COMP . '  AND User.email!="" AND (' . $search_query . ') GROUP BY CompanyUser.is_active ');
//		pr('SELECT count(CompanyUser.id) as usrcnt , CompanyUser.is_active FROM company_users CompanyUser LEFT JOIN users User on CompanyUser.user_id=User.id WHERE CompanyUser.company_id='.SES_COMP.'  AND User.email!="" AND ('.$search_query.') GROUP BY CompanyUser.is_active ');exit;
        if ($grpcount) {
            foreach ($grpcount AS $key => $val) {
                if ($val['CompanyUser']['is_active'] == 1) {
                    $active_user_cnt = $val['0']['usrcnt'];
                } elseif ($val['CompanyUser']['is_active'] == 2) {
                    $invited_user_cnt = $val['0']['usrcnt'];
                } elseif ($val['CompanyUser']['is_active'] == 0) {
                    $disabled_user_cnt = $val['0']['usrcnt'];
                }
            }
        }

        $clientcnt = $CompanyUser->query('SELECT count(CompanyUser.id) as cnt , CompanyUser.is_client FROM company_users CompanyUser LEFT JOIN users User on CompanyUser.user_id=User.id WHERE CompanyUser.company_id=' . SES_COMP . ' AND User.email !="" And (' . $search_query . ') GROUP BY CompanyUser.is_client');
        if ($clientcnt) {
            foreach ($clientcnt as $k => $v) {
                if ($v['CompanyUser']['is_client'] == '1') {
                    $client_user_cnt = $v['0']['cnt'];
                }
            }
        }
        $recent_user_cnt = $this->User->query("SELECT count(User.id) as cnt FROM (SELECT User.*,CompanyUser.company_id,CompanyUser.company_uniq_id,CompanyUser.user_id,CompanyUser.is_active,CompanyUser.act_date,CompanyUser.created FROM company_users AS CompanyUser LEFT JOIN users AS User ON CompanyUser.user_id=User.id WHERE CompanyUser.company_id=" . SES_COMP . "  AND CompanyUser.is_active ='1' AND CompanyUser.created > '" . date('Y-m-d H:i:s', strtotime('-7 days', time())) . "' AND User.email !='') as User LEFT JOIN user_invitations AS UserInvitation ON User.user_id = UserInvitation.user_id WHERE UserInvitation.company_id=" . SES_COMP);
        if ($recent_user_cnt) {
            $this->set('recent_user_cnt', $recent_user_cnt[0][0]['cnt']);
        } else {
            $this->set('recent_user_cnt', 0);
        }
        $this->set('active_user_cnt', $active_user_cnt);
        $this->set('invited_user_cnt', $invited_user_cnt);
        $this->set('disabled_user_cnt', $disabled_user_cnt);

        $this->set('caseCount', $tot[0][0]['total']);
        $this->set('page_limit', $page_limit);
        $this->set('page', $page);
        $this->set('casePage', $page);
        $this->set('projArr', $projArr);
        $this->set('userArr', $userArr);
        $this->set('role', $role);
        $this->set('type', $type);
        //$this->set('user_srch', $user_srch);
        $this->set('user_srch', h($_GET['user_srch'], true, 'UTF-8'));
        $this->set('arrusr', $arrusr);
        $this->set('totUser', $totUser);
        $this->set('client_user_cnt', $client_user_cnt);
        if (isset($_GET['resetpassword']) && $_GET['resetpassword']) {
            $this->User->recursive = -1;
            $userUniqId = urldecode($_GET['resetpassword']);
            $getData = $this->User->find("first", array('conditions' => array('User.uniq_id' => $userUniqId), 'fields' => array('User.name', 'User.email')));
            if (count($getData)) {
                $name = $getData['User']['name'];
                $to = $getData['User']['email'];
                $newPasswrod = $this->Format->generatePassword(6);

                $subject = SITE_NAME . " Reset Password";
                $message = "<table cellspacing='1' cellpadding='1'  width='100%' border='0'>
									 " . EMAIL_HEADER . "
									<tr><td>&nbsp;</td></tr>
									<tr><td align='left' style='font:normal 14px verdana;'>Hi " . $name . ",</td></tr>
									<tr><td>&nbsp;</td></tr>
									<tr><td align='left' style='font:normal 14px verdana;'>Your Password has been reset to <b>" . $newPasswrod . "</b></td></tr>
									<tr><td>&nbsp;</td></tr>
									" . EMAIL_FOOTER . "
									<tr><td>&nbsp;</td></tr>
								</table>
								";
                if ($this->Sendgrid->sendGridEmail(FROM_EMAIL, $to, $subject, $message, "ResetPassword")) {
                    $newMd5Passwrod = md5($newPasswrod);
                    $this->User->query("UPDATE users SET password='" . $newMd5Passwrod . "' WHERE uniq_id='" . $userUniqId . "'");

                    $this->Session->write("SUCCESS", "Password of '" . $name . "' reset successfully");
                    $this->redirect(HTTP_ROOT . "users/manage/");
                }
            }
        }
    }
    public function saveUserFeedback()
    {
        $arr['msg'] = "error";
        $data = $this->request->data;
        $data['user_id'] = SES_ID;
        $data['company_id'] = SES_COMP;
        $user = $this->User->findById(SES_ID);
        $data['email'] = $user['User']['email'];
        $data['username'] = ucfirst($user['User']['name'])." ".ucfirst($user['User']['last_name']);
       
        
       
            /** Email send to User **/
            
            $this->Email->delivery = 'smtp';
            $this->Email->to = $data['email'];
            $this->Email->subject = "Thank you for posting feedback about Orangescrum";
            $this->Email->from = FROM_EMAIL;
            $this->Email->template = 'feedback_email';
            $this->Email->sendAs = 'html';
            $this->set('data', $data);
            $this->Sendgrid->sendgridsmtp($this->Email);
            /* End **/
            /** Email Send to  admin **/
            $this->Email->to = MARKETING_EMAIL;//MARKETING_EMAIL;
            $this->Email->bcc = ADMIN_EMAIL;//MARKETING_EMAIL;
            $this->Email->from = FROM_EMAIL;
            $this->Email->template = 'feedback_email_admin';
            $this->Email->subject = "Feedback from ". ucfirst($data['username'])." about Orangescrum SAAS Application";
            $this->set('data', $data);
            $this->Sendgrid->sendgridsmtp($this->Email);
            /** End **/
            $arr['msg'] = 'success';
            
       
        print json_encode($arr);
        exit;
    }
    function grant_moderate() {
        $this->layout = 'ajax';
        if (isset($this->request->data['user_id']) && trim($this->request->data['user_id'])) {
            $this->loadModel('User');
            $this->User->id = $this->request->data['user_id'];
            if ($this->User->saveField('is_moderator', $this->request->data['type'])) {
                print 1;
            } else {
                print 0;
            }
        } else {
            print 0;
        }
        exit;
    }
    function changeNewPassword()
    {
        $newMd5Passwrod = md5($this->request->data['password']);
        $unId = $this->request->data['u_id'];
        // $hj = fopen('testpass.txt','a');
        // fwrite($hj, print_r($this->request->data, true));
        // fclose($hj);
        $userdata = $this->User->findByUniqId($unId);
        if($userdata){
            $userdata['User']['password'] = md5(trim($this->request->data['password']));
            if($this->User->save($userdata)){
                echo json_encode(['status' => 'success']);        
            }else{
                echo json_encode(['status' => 'fail']);                   
            }
        }else{
            echo json_encode(['status' => 'fail']);
        }
       exit;
    }
    function forgotpassword() {
        if (!empty($this->request->data) && empty($this->request->data['User']['repass']) && empty($this->request->data['User']['newpass'])) {
            $to = trim($this->request->data['User']['email']);
            $this->User->recursive = -1;
            $getUsrData = $this->User->find("first", array('conditions' => array('User.email' => $to, 'User.isactive' => 1), 'fields' => array('User.id', 'User.name')));
            if ($getUsrData && is_array($getUsrData) && count($getUsrData)) {

                $id = $getUsrData['User']['id'];
                $name = stripslashes($getUsrData['User']['name']);
                $qstr = md5(uniqid(rand()));
                $urlValue = "?qstr=" . $qstr;

                $this->Email->delivery = 'smtp';
                $this->Email->to = $to;
                $this->Email->subject = Configure::read('forgot_password');
                    $this->Email->from = FROM_EMAIL;
                $this->Email->template = 'forgot_password';
                $this->Email->sendAs = 'html';
                $this->set('name', $name);
                $this->set('urlValue', $urlValue);

				if(defined("PHPMAILER") && PHPMAILER == 1){					
					$this->Email->set_variables = $this->render('/Emails/html/forgot_password',false);
					if($this->PhpMailer->sendPhpMailerTemplate($this->Email)){
						$this->User->query("UPDATE users SET query_string='" . $qstr . "' WHERE id=" . $id);
						$this->Session->setFlash(__("Please check your mail to reset your password",true), 'default', array('class' => 'success'));
						$this->redirect(HTTP_ROOT . "users/forgotpassword/");
					}
				}else{
                if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                    $this->User->query("UPDATE users SET query_string='" . $qstr . "' WHERE id=" . $id);

                        $this->Session->setFlash(__("Please check your mail to reset your password",true), 'default', array('class' => 'success'));
                    $this->redirect(HTTP_ROOT . "users/forgotpassword/");
                }
				}
            } else {
                //$this->Session->write("ERROR_RESET","<font style='color:red;'>If an account exists with this email address, we've sent instructions on resetting your password. Please check your email!</font>");
                    $this->Session->setFlash(__("If an account exists with this email address, we've sent instructions on resetting your password. Please check your email!",true), 'default', array('class' => 'error'));
                $this->redirect(HTTP_ROOT . "users/forgotpassword/");
            }
        }
        if (isset($_GET['qstr']) && $_GET['qstr']) {
            $queryString = urldecode($_GET['qstr']);
            $this->User->recursive = -1;

            $getData = $this->User->query("SELECT User.id,User.email,User.name FROM users AS User WHERE User.query_string='" . $queryString . "' AND User.isactive='1'");
            //pr($getData);exit;

            if (isset($getData) && count($getData) == 1) {
                $this->set('passemail', '12');
                $this->set('user_id', $getData['0']['User']['id']);
            }
        }
        if (!empty($this->request->data) && !empty($this->request->data['User']['repass']) && !empty($this->request->data['User']['newpass'])) {
            //echo $this->request->data['user_id'];exit;
            if ($this->request->data['User']['repass'] == $this->request->data['User']['newpass']) {
                $newMd5Passwrod = md5($this->request->data['User']['repass']);
					$getData = $this->User->query("SELECT User.id,User.email,User.name FROM users AS User WHERE User.query_string='" . $this->request->data['qstr_chk'] . "' AND User.isactive='1'");
					if(!empty($getData) && $getData[0]['User']['id'] == $this->request->data['user_id']){
                $id = $this->request->data['user_id'];
                    Cache::delete('prrofile_detl_'.$id);
                $this->User->query("UPDATE users SET password='" . $newMd5Passwrod . "',query_string='' WHERE id=" . $id);

                $this->loadModel('CompanyUser');
                $this->CompanyUser->updateUserPerm(0, $id, 2);

                $this->set('chkemail', '11');
					}else{
						$this->set('passemail', '12');
						$this->set('user_id', $getData['0']['User']['id']);
						$this->Session->setFlash("Unable to update your password. Please try again.", 'default', array('class' => 'error'));
						$this->redirect(HTTP_ROOT."users/forgotpassword/?qstr=".$this->request->data['qstr_chk']);
					}
            }
        }
    }

    function check_short_name() {
        $this->layout = 'ajax';
        if (isset($this->request->data['shortname']) && trim($this->request->data['shortname'])) {
            $count = $this->User->find("count", array("conditions" => array('User.short_name' => trim(strtoupper($this->request->data['shortname']))), 'fields' => 'DISTINCT User.id'));
            $this->set('count', $count);
            $this->set('shortname', trim(strtoupper($this->request->data['shortname'])));
        }
    }

    function ajax_registration() {
        //echo "<pre>";print_r($this->data);exit;
        //$this->layout='ajax';
        $this->loadModel('Company');
        /* $name = urldecode($this->request->data['name']);
          $email = urldecode($this->request->data['email']);
          $last_name = urldecode($this->request->data['last_name']);
          $password = urldecode($this->request->data['password']);
          $company = urldecode($this->request->data['company']);
          $seo_url = urldecode($this->request->data['seo_url']);
          $contact_phone = urldecode($this->request->data['contact_phone']); */

        $name = trim($this->data['User']['name']);
        $email = trim($this->data['User']['email']);
        $last_name = $this->data['User']['last_name'];
        $password = $this->data['User']['password'];
        $company = trim($this->data['User']['company']);
        $seo_url = trim($this->data['User']['seo_url']);
        //$contact_phone = $this->data['User']['contact_phone']?$this->data['User']['contact_phone']:'';

        $this->loadModel('Timezone');
        $getTmz = $this->Timezone->find('first', array('conditions' => array('Timezone.gmt_offset' => $this->data['User']['timezone_id'])));
        $timezone_id = $getTmz['Timezone']['id'];

        $short_name = $this->Format->makeShortName($name, $last_name);

        $this->loadModel('Subscription');
        $subScription = $this->Subscription->find('first', array('conditions' => array('Subscription.plan' => 1)));

        $comp['Company']['uniq_id'] = $this->Format->generateUniqNumber();
        $comp['Company']['seo_url'] = $this->Format->makeSeoUrl($seo_url);
        $comp['Company']['subscription_id'] = $subScription['Subscription']['id'];
        $comp['Company']['name'] = $company;
        $comp['Company']['contact_phone'] = '';
        $comp['Company']['is_beta'] = 1;
        $message = "success";
        try {
            $sus_comp = $this->Company->save($comp);
        } catch (Exception $e) {
            $this->Company->delete($company_id);
            $subject = "ORANGESCRUM DATABASE ERROR";
            $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
            //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
            echo "error";
            exit;
        }
        if ($sus_comp) {
            $company_id = $this->Company->getLastInsertID();
            $activation_id = $this->Format->generateUniqNumber();

            $usr['User']['uniq_id'] = $this->Format->generateUniqNumber();
            $usr['User']['email'] = $email;
            $usr['User']['password'] = $this->Auth->password($password);
            $usr['User']['name'] = $name;
            //$usr['User']['last_name'] = $last_name;
            $usr['User']['last_name'] = '';
            $usr['User']['short_name'] = $short_name;
            $usr['User']['istype'] = 2;
            $usr['User']['isactive'] = 2;
            $usr['User']['is_beta'] = 1;
            $usr['User']['dt_created'] = GMT_DATETIME;
            $usr['User']['dt_updated'] = GMT_DATETIME;
            $usr['User']['query_string'] = $activation_id;
            $usr['User']['timezone_id'] = $timezone_id ? $timezone_id : 26;
            $usr['User']['ip'] = $_SERVER['REMOTE_ADDR'];
            try {
                $sus_user = $this->User->save($usr);
            } catch (Exception $e) {
                $this->Company->delete($company_id);
                $subject = "ORANGESCRUM DATABASE ERROR";
                $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
                //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
                echo "error";
                exit;
            }
            if ($sus_user) {
                $comp_usr['CompanyUser']['user_id'] = $this->User->getLastInsertID();
                $comp_usr['CompanyUser']['company_id'] = $company_id;
                $comp_usr['CompanyUser']['company_uniq_id'] = $comp['Company']['uniq_id'];
                $comp_usr['CompanyUser']['user_type'] = 1;

                $this->loadModel('CompanyUser');
                try {
                    $sus_companyuser = $this->CompanyUser->save($comp_usr);
                } catch (Exception $e) {
                    $this->Company->delete($company_id);
                    $this->User->delete($comp_usr['CompanyUser']['user_id']);
                    $subject = "ORANGESCRUM DATABASE ERROR";
                    $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
                    //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
                    echo "error";
                    exit;
                }
                if ($sus_companyuser) {
                    	$this->saveResourceSettings($company_id);// save Resource Settings
                    $companyUid = $this->CompanyUser->getLastInsertID();
                    $this->loadModel('UserSubscription');
                    $sub_usr['UserSubscription']['user_id'] = $comp_usr['CompanyUser']['user_id'];
                    $sub_usr['UserSubscription']['company_id'] = $company_id;
                    $sub_usr['UserSubscription']['subscription_id'] = $subScription['Subscription']['id'];
                    $sub_usr['UserSubscription']['storage'] = $subScription['Subscription']['storage'];
                    $sub_usr['UserSubscription']['project_limit'] = $subScription['Subscription']['project_limit'];
                    $sub_usr['UserSubscription']['user_limit'] = $subScription['Subscription']['user_limit'];
                    $sub_usr['UserSubscription']['milestone_limit'] = $subScription['Subscription']['milestone_limit'];
                    $sub_usr['UserSubscription']['free_trail_days'] = $subScription['Subscription']['free_trail_days'];
                    $sub_usr['UserSubscription']['price'] = $subScription['Subscription']['price'];
                    $sub_usr['UserSubscription']['month'] = $subScription['Subscription']['month'];
                    $sub_usr['UserSubscription']['created'] = GMT_DATETIME;
                    try {
                        $usersubs = $this->UserSubscription->save($sub_usr);
                            // add data for new signup in new_pricing_users for new pricing od addning user dynamically
                            $this->loadModel("NewPricingUser");
                            $np_users["NewPricingUser"]["company_id"] = $company_id ;
                            $np_users["NewPricingUser"]["user_id"] = $comp_usr['CompanyUser']['user_id'];
                            $np_users["NewPricingUser"]["per_user_price"] = CUR_PLAN_USER;
                            $np_users["NewPricingUser"]["total_price"] = 0;
                            $np_users["NewPricingUser"]["plan_id"] = 1;
                            $np_users["NewPricingUser"]["created"] = GMT_DATETIME;
                            $np_users["NewPricingUser"]["is_flat_price"] = 1;
                            $this->NewPricingUser->save($np_users);
                    } catch (Exception $e) {
                        $this->Company->delete($company_id);
                        $this->User->delete($comp_usr['CompanyUser']['user_id']);
                        $this->CompanyUser->delete($companyUid);
                        $subject = "ORANGESCRUM DATABASE ERROR";
                        $message = "A user is trying to register into OS But not able to proceed due to below error <br/><font color='#EE0000'>" . $e->getMessage() . "</font><br/>Email: " . $email . "<br/>Domain: " . HTTP_ROOT;
                        //$this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
                        echo "error";
                        exit;
                    }
                    $to = $email;
                    $from = FROM_EMAIL;
                    $subject = "Welcome to Orangescrum!";

                    $activation_url = HTTP_ROOT . "users/confirmation/" . $activation_id;

                    //Event log data and inserted into database in account creation--- Start
                    $json_arr['company_name'] = $comp['Company']['name'];
                    $json_arr['name'] = $usr['User']['name'];
                    $json_arr['user_type'] = 'Free';
                    $json_arr['created'] = GMT_DATETIME;
                    $this->Postcase->eventLog($company_id, $comp_usr['CompanyUser']['user_id'], $json_arr, 1);
                    //End 
                    //Welcome email to user --- start 
                    $web_address = HTTP_ROOT;
                    $this->Email->delivery = 'smtp';
                    $this->Email->to = $to;
                    $this->Email->subject = $subject;
                    $this->Email->from = $from;
                    $this->Email->template = 'beta_signup';
                    $this->Email->sendAs = 'html';
                    $this->set('project_limit', $subScription['Subscription']['project_limit']);
                    $this->set('user_limit', $subScription['Subscription']['user_limit']);
                    $this->set('storage', $subScription['Subscription']['storage']);
                    $this->set('expName', ucfirst($name));
                    $this->set('password', $password);
                    $this->set('web_address', $web_address);
                    $this->set('plan_id', 1);
                    $this->set('free_trail_days', $subScription['Subscription']['free_trail_days']);
                    $this->set('price', $subScription['Subscription']['price']);
                    if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                        $betaTokenValue = urldecode($this->data['hid_beta_token']);
                        $this->loadModel('BetaUser');
                        $this->BetaUser->query("UPDATE `beta_users` set `invit_token`= '' WHERE `invit_token`='" . $betaTokenValue . "'");
                        $this->redirect($activation_url);
                        exit;
                    } else {
                        if ($company_id) {
                            $this->loadModel('Company');
                            $this->Company->delete($company_id);
                        }
                        if ($comp_usr['CompanyUser']['user_id']) {
                            $this->loadModel('User');
                            $this->User->delete($comp_usr['CompanyUser']['user_id']);
                        }
                        if ($companyUid) {
                            $this->loadModel('CompanyUser');
                            $this->CompanyUser->delete($companyUid);
                        }
                        $this->redirect($_SERVER['HTTP_REFERER']);
                        exit;
                    }


                    /* $message = "<div style='font-family:Arial;font-size:14px;'>
                      <h3>Hi ".$name.",</h3>
                      Welcome to Orangescrum and thanks for signing up!
                      <br/>
                      <div>Click to confirm your account </div>
                      <br/><br/>
                      <a href='".$activation_url."' style='color: white;font-size: 18px;font-weight: bold;text-align: center;
                      text-decoration: none;background-color: #FF6B09;border: 1px solid #BC4F06;padding: 8px 12px;margin-left:95px;width:150px;text-align:center;margin-top:10px;'>
                      Click here to complete Sign Up process
                      </a>
                      <br/>
                      <br/>
                      <div style='font-size:14px;margin-top:10px;'>
                      Trouble with the link above? Copy and paste the following link into your browser:
                      <br>
                      <a href='".$activation_url."' style='color:#1f8dd6font-size: 18px;font-weight: bold;text-align: center;
                      text-decoration: none;'>".$activation_url."</a>
                      <br/>
                      <br/>
                      <div style='font-size:11px;color:#999999;'>
                      You're getting this email because you requested an account on Orangescrum.com using this email address.
                      <br> If you didn't intend to do this, just ignore this email; no account has been created yet.
                      </div>
                      <br/><div style='line-height:20px;padding-top:10px;color:#999999;'>Regards,<br/>The Orangescrum Team</div><br/>
                      </div>";

                      $this->Sendgrid->sendGridEmail($from,$to,$subject,$message,"UserReg");

                      $message = "success"; */
                }
            }
        }
        /* if($message != "success") {

          }else{

          } */
    }

    /**
     * @Method: public new_user() Here we can invite new users to add into our project
     * @author Andola Dev <> 
     * @return HTML returns the success or failure
     */
    function new_user($resend = NULL) {
        $cmpnyUsr = array();
        if (isset($this->request->data['User']['role']) && $this->request->data['User']['role'] == 'client') {
            $cmpnyUsr['CompanyUser']['is_client'] = 1;
        }
        $Company = ClassRegistry::init('Company');
        //$comp = $Company->find('first',array('conditions'=>array('Company.seo_url'=>CHECK_DOMAIN),'fields'=>array('Company.id','Company.name','Company.uniq_id')));

        $company_id = SES_COMP;
        $projectcls = ClassRegistry::init('Project');
        $default_project_id = '';
        $previous_project_invitation_id = '';
        $previous_project_invitation_ids = '';
        $UserInvitation = ClassRegistry::init('UserInvitation');
        $invitation_id = "";
        if (isset($this->request->data['User']) || trim($resend)) {
            if ($resend) {
                $invit = $UserInvitation->find('first', array('conditions' => array('UserInvitation.qstr' => $resend)));
                if ($invit['UserInvitation']['user_id']) {
                    $invitation_id = $invit['UserInvitation']['id'];
                    $this->request->data['User']['pid'] = $invit['UserInvitation']['project_id'];
                    $this->request->data['User']['istype'] = 2;
                    $getEmail = $this->User->find('first', array('conditions' => array('User.id' => $invit['UserInvitation']['user_id']), 'fields' => array('User.email')));
                    $this->request->data['User']['email'] = $getEmail['User']['email'];
                }
            } else {
                $this->request->data['User']['email'] = trim($this->request->data['User']['email']);
                    if(isset($this->request->data['User']['admin_email']) && !empty($this->request->data['User']['admin_email'])){
                        $this->request->data['User']['email'] .= ",".trim($this->request->data['User']['admin_email']);
                }
            }
        }
            if (isset($GLOBALS['usercount']) && strtolower($GLOBALS['Userlimitation']['user_limit']) != 'unlimited' && ($GLOBALS['usercount'] >= $GLOBALS['Userlimitation']['user_limit']) && $this->request->data['User']['role_id'] != 699) {
            $userlimit = 1;
        } else {
            $userlimit = 0;
        }

        $Company = ClassRegistry::init('Company');
        $comp = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('Company.id', 'Company.name', 'Company.uniq_id')));

        if ($this->request->data['User']['email'] && !$userlimit) {
            if (isset($_SESSION['puincrement_id'])) {
                unset($_SESSION['puincrement_id']);
            }
            if (isset($_SESSION['project_increment_id'])) {
                unset($_SESSION['project_increment_id']);
            }
            $CompanyUser = ClassRegistry::init('CompanyUser');
            if (strstr($this->request->data['User']['email'], ",")) {
                $err = 0;
                $mail_list = explode(",", trim(trim($this->request->data['User']['email']), ','));
                $ucounter = 0;
                $mail_arr = array();
                foreach ($mail_list AS $key => $val) {
                    if (trim($val) != "") {
                        $mail_arr[] = trim($val);
                        $ucounter ++;
                    }
                }
                //$ucounter = count($mail_arr);
                $total_new_users = $ucounter + $GLOBALS['usercount'];
                if (strtolower($GLOBALS['Userlimitation']['user_limit']) != 'unlimited' && ($total_new_users > $GLOBALS['Userlimitation']['user_limit'])) {
                    if (SES_TYPE == 3) {
                        $this->Session->write("ERROR", "Sorry! you have exceeded the user limit. Please <a href='" . HTTP_ROOT . "/pricing'>Upgrade</a>");
                    } else {
                            $this->Session->write("ERROR", __("Sorry! This account exceeded the user limit.",true));
                    }
                    $this->redirect(HTTP_ROOT);
                    exit;
                }
                if($this->request->data['User']['role_id'] == 699){
                        if($this->User->allowedGuestUserCount($ucounter) == "excess"){
                            if (SES_TYPE == 3) {
                                $this->Session->write("ERROR", "Sorry! you have exceeded the guest user limit. Please <a href='" . HTTP_ROOT . "/pricing'>Upgrade</a>");
                            } else {
                                $this->Session->write("ERROR", __("Sorry! This account exceeded the guest user limit.",true));
                            }
                            $this->redirect(HTTP_ROOT);
                            exit;
                        }
                    }
                $error_emails = array();
                $invite_users = '';
                $invited_emails = '';
                $invited_to_only_new = '';
                for ($i = 0; $i < count($mail_arr); $i++) {
                    $auto_password = '';
                    if (trim($mail_arr[$i]) != "") {
                        if (!filter_var($mail_arr[$i], FILTER_VALIDATE_EMAIL)) {
                            $error_emails[] = $mail_arr[$i];
                            continue;
                        }
                        $mail_arr[$i] = trim($mail_arr[$i]);
                        //$findEmail = $this->User->find('first',array('conditions'=>array('User.email'=>$mail_arr[$i]),'fields'=>array('User.id')));
                        $findEmail = $this->User->find('first', array('conditions' => array('User.email' => $mail_arr[$i])));
                        if (@$findEmail['User']['id']) {
                            $userid = $findEmail['User']['id'];
                            //Below three line Added for the new invite user functionality
                            if (!$findEmail['User']['password'] && !$findEmail['User']['dt_last_login']) {
                                $invitation_details_t = $UserInvitation->find('first', array('conditions' => array('user_id' => $userid, 'company_id' => SES_COMP), 'fields' => array('id', 'project_id')));
                                $PIDS = null;
                                if (isset($this->request->data['User']['pid'])) {
                                    $PIDS = $this->request->data['User']['pid'];
                                }
                                if (@$invitation_details_t['UserInvitation']['id']) {
                                    $previous_project_invitation_id = $invitation_details_t['UserInvitation']['id'];
                                    if ($PIDS) {
                                        if (is_array($PIDS)) {
                                            $PIDS = implode(',', $PIDS);
                                        }
                                        $PIDS = $invitation_details_t['UserInvitation']['project_id'] ? $invitation_details_t['UserInvitation']['project_id'] . ',' . $PIDS : $PIDS;
                                    } else {
                                        if ($invitation_details_t['UserInvitation']['project_id']) {
                                            $PIDS = $invitation_details_t['UserInvitation']['project_id'];
                                        }
                                    }
                                }
                                $previous_project_invitation_ids = $PIDS;
                                $userid_pass = $this->newInviteUserProcess($findEmail, 'old', 1, $PIDS);
                                $temp_userid_pass = explode('___', $userid_pass);
                                $auto_password = $temp_userid_pass[1];
                                $invited_to_only_new = 1;
                            } else {
                                //$hj = fopen('ltest.txt','a');
                                //fwrite($hj,print_r($this->request->data,true));						
                                if (isset($this->request->data['User']['pid'])) {
                                    $PIDS = $this->request->data['User']['pid'];
                                    if (is_array($PIDS)) {
                                        $PIDS = implode(',', $PIDS);
                                    }
                                    $previous_project_invitation_ids = $PIDS;
                                    $ProjectUser = ClassRegistry::init('ProjectUser');
                                    $ProjectUser->recursive = -1;
                                    $projectids = array();
                                    $last_insert_id = '';
                                    if (strstr($PIDS, ',')) {
                                        $projectids = explode(',', $PIDS);
                                    } else {
                                        $projectids[] = $PIDS;
                                    }
                                    if ($projectids && !empty($projectids)) {
                                        foreach ($projectids as $key => $val) {
                                            if (trim($val)) {
                                                if (isset($_SESSION['project_increment_id']) && $_SESSION['project_increment_id']) {
                                                    $_SESSION['project_increment_id'] = $_SESSION['project_increment_id'] + 1;
                                                    $_SESSION['puincrement_id'] = $_SESSION['project_increment_id'];
                                                } else {
                                                    if (isset($_SESSION['puincrement_id']) && $_SESSION['puincrement_id']) {
                                                        $_SESSION['project_increment_id'] = $_SESSION['puincrement_id'] + 1;
                                                        $_SESSION['puincrement_id'] = $_SESSION['project_increment_id'];
                                                    } else {
                                                        $getLastId = $ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
                                                        $nextid = $getLastId[0][0]['maxid'] + 1;
                                                        $_SESSION['project_increment_id'] = $nextid;
                                                        $_SESSION['puincrement_id'] = $nextid;
                                                    }
                                                }
                                                $projUsr['ProjectUser']['id'] = $_SESSION['project_increment_id'];
                                                $projUsr['ProjectUser']['user_id'] = $userid;
                                                $projUsr['ProjectUser']['project_id'] = trim($val);
                                                $projUsr['ProjectUser']['company_id'] = SES_COMP;
                                                $projUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                                                //fwrite($hj,print_r($projUsr,true));
                                                $ProjectUser->create();
                                                $ProjectUser->save($projUsr);
                                            }
                                        }
                                    }
                                }
                            }
                        } else {
                            $previous_project_invitation_ids = '';
                            $previous_project_invitation_id = '';
                            $invited_to_only_new = 1;
                            $this->request->data['User']['uniq_id'] = $this->Format->generateUniqNumber();
                            $this->request->data['User']['isactive'] = 2;
                            $this->request->data['User']['isemail'] = 1;
                            $this->request->data['User']['dt_created'] = GMT_DATETIME;
                            $this->request->data['User']['email'] = trim($mail_arr[$i]);

                            $temp_name = explode('@', $this->request->data['User']['email']);
                            $this->request->data['User']['name'] = $temp_name[0];

                            //Below one line Added and twoline commented for the new invite user functionality
                            $userid_pass = $this->newInviteUserProcess($this->request->data, 'new', 1);
                            $temp_userid_pass = explode('___', $userid_pass);
                            $userid = $temp_userid_pass[0];
                            $auto_password = $temp_userid_pass[1];
                            //$this->User->saveAll($this->request->data);
                            //$userid = $this->User->getLastInsertID();
                        }
                        if ($userid && $userid != $this->Auth->User("id")) {
                            $qstr = $this->Format->generateUniqNumber();

                            if ($invitation_id) {
                                $InviteUsr['UserInvitation']['id'] = $invitation_id;
                            }
                            if ($previous_project_invitation_id != '') {
                                $InviteUsr['UserInvitation']['id'] = $previous_project_invitation_id;
                            }
                            $InviteUsr['UserInvitation']['invitor_id'] = $this->Auth->User("id");
                            $InviteUsr['UserInvitation']['user_id'] = $userid;

                            $InviteUsr['UserInvitation']['company_id'] = $company_id;
                            if (isset($this->request->data['User']['pid'])) {
                                if (is_array($this->request->data['User']['pid']) && !empty($this->request->data['User']['pid'])) {
                                    if ($previous_project_invitation_ids != '') {
                                        $InviteUsr['UserInvitation']['project_id'] = $previous_project_invitation_ids;
                                    } else {
                                        $InviteUsr['UserInvitation']['project_id'] = implode(",", $this->request->data['User']['pid']);
                                    }
                                } elseif ($this->request->data['User']['pid']) {
                                    if ($previous_project_invitation_ids != '') {
                                        $InviteUsr['UserInvitation']['project_id'] = $previous_project_invitation_ids;
                                    } else {
                                        $InviteUsr['UserInvitation']['project_id'] = $this->request->data['User']['pid'];
                                    }
                                }
                            }/* else{
                              if(!$project_flag){
                              $project_flag=1;
                              $project_list = $projectcls->find('first',array('conditions'=>array('Project.short_name'=>'WCOS','Project.isactive'=>1,'Project.company_id'=>SES_COMP),'fields'=>"Project.id"));
                              if($project_list){
                              $default_project_id = $project_list['Project']['id'];
                              }
                              }
                              if($default_project_id){
                              $InviteUsr['UserInvitation']['project_id'] = $default_project_id;
                              }
                              } */

                            $InviteUsr['UserInvitation']['qstr'] = $qstr;

                            $InviteUsr['UserInvitation']['created'] = GMT_DATETIME;
                            $InviteUsr['UserInvitation']['is_active'] = 1;
                                if(isset($this->request->data['User']['admin_email']) && !empty($this->request->data['User']['admin_email'])  && $mail_arr[$i] == trim($this->request->data['User']['admin_email'])){
                                $InviteUsr['UserInvitation']['user_type'] = 2;
                                }else{
                            $InviteUsr['UserInvitation']['user_type'] = $this->request->data['User']['istype'];
                                }

                            //Below one line Added for the new invite user functionality
                            //if($auto_password != ''){
                            $InviteUsr['UserInvitation']['is_active'] = 0;
                            //}

                            if ($UserInvitation->saveAll($InviteUsr)) {
                                if (!$invitation_id) {
                                    $invite_users = $invite_users . "," . $userid;
                                }
                                $is_sub_upgrade = 1;
                                // Checking for a deleted user when gets invited again.
                                $compuser = $CompanyUser->find('first', array('conditions' => array('user_id' => $userid, 'company_id' => SES_COMP)));
                                if ($compuser && $compuser['CompanyUser']['is_active'] == 3) {
                                    $is_sub_upgrade = 0;
                                    // If that user deleted in the same billing month and invited again then that user will not paid 
                                    if ($GLOBALS['Userlimitation']['btsubscription_id']) {
                                        if (strtotime($GLOBALS['Userlimitation']['next_billing_date']) > strtotime($compuser['CompanyUser']['billing_end_date'])) {
                                            $is_sub_upgrade = 1;
                                        }
                                    }
                                    $cmpnyUsr['CompanyUser']['id'] = $compuser['CompanyUser']['id'];
                                }
                                $cmpnyUsr['CompanyUser']['user_id'] = $userid;
                                $cmpnyUsr['CompanyUser']['company_id'] = $company_id;
                                $cmpnyUsr['CompanyUser']['company_uniq_id'] = COMP_UID;
                                    if(isset($this->request->data['User']['admin_email']) && !empty($this->request->data['User']['admin_email'])  && $mail_arr[$i] == trim($this->request->data['User']['admin_email'])){
                                        $cmpnyUsr['CompanyUser']['user_type'] = 2;
                                        $cmpnyUsr['CompanyUser']['role_id'] = 2;
                                    }else{
                                $cmpnyUsr['CompanyUser']['user_type'] = $this->request->data['User']['istype'];
                                    $cmpnyUsr['CompanyUser']['role_id'] = (isset($this->request->data['User']['role_id']) && !empty($this->request->data['User']['role_id'])) ? $this->request->data['User']['role_id'] : 3;
                                    // override the user type here if role id == 2 (Admin)
                                     if($cmpnyUsr['CompanyUser']['role_id'] ==2){
                                        $cmpnyUsr['CompanyUser']['user_type'] = 2;
                                     } 
                                     if($cmpnyUsr['CompanyUser']['role_id'] ==4){
                                        $cmpnyUsr['CompanyUser']['is_client'] = 1;
                                     }
                                    }
                                $cmpnyUsr['CompanyUser']['is_active'] = 2;
                                $cmpnyUsr['CompanyUser']['created'] = GMT_DATETIME;

                                //Below three line Added for the new invite user functionality
                                //if($auto_password != ''){
                                $cmpnyUsr['CompanyUser']['is_active'] = 1;
                                $cmpnyUsr['CompanyUser']['act_date'] = GMT_DATETIME;
                                //}

                                if ($CompanyUser->saveAll($cmpnyUsr)) {

                                    //$json_arr['email'] = $mail_arr[$i];
                                    //$json_arr['created'] = GMT_DATETIME;
                                    //$this->Postcase->eventLog(SES_COMP,SES_ID,$json_arr,25);

                                    $comp_user_id = $CompanyUser->getLastInsertID();

                                    $to = $mail_arr[$i];

                                    $expEmail = explode("@", $mail_arr[$i]);
                                    $expName = $expEmail[0];
                                    $loggedin_users = $this->Format->getUserNameForEmail($this->Auth->User("id"));
                                    $fromName = ucfirst($loggedin_users['User']['name']);
                                    $fromEmail = $loggedin_users['User']['email'];

                                    $ext_user = '';
                                    if (@$findEmail['User']['id'] && @$findEmail['User']['password']) {
                                        $subject = $fromName . " added you to " . $comp['Company']['name'] . " on Orangescrum";
                                        $ext_user = 1;
                                    } else {
                                        $subject = $fromName . " created your account on Orangescrum";
                                    }
                                    if ($invited_emails == '') {
                                        $invited_emails = $to;
                                    } else {
                                        $invited_emails .= ', ' . $to;
                                    }
                                    $uEmail = $this->User->getLoginUserEmail(SES_ID);
                                    $this->Email->delivery = 'smtp';
                                    $this->Email->to = $to;
                                    $this->Email->subject = $subject;
										$this->Email->from = FROM_EMAIL;//!empty($uEmail['User']['email']) ? $uEmail['User']['email'] : FROM_EMAIL; //FROM_EMAIL;
                                    $this->Email->template = 'invite_user';
                                    $this->Email->sendAs = 'html';
                                    $this->set('expName', ucfirst($expName));
                                    $this->set('qstr', $qstr);
                                    $this->set('existing_user', $ext_user);

                                    $this->set('company_name', $comp['Company']['name']);
                                    $this->set('fromEmail', $fromEmail);
                                    $this->set('fromName', $fromName);

                                    $this->set('email', $this->request->data['User']['email']);
                                    $this->set('password', $auto_password);

                                    try {
										if(defined("PHPMAILER") && PHPMAILER == 1){
											$this->Email->set_variables = $this->render('/Emails/html/invite_user',false);
											$this->PhpMailer->sendPhpMailerTemplate($this->Email);
										}else{
                                        $this->Sendgrid->sendgridsmtp($this->Email);
										}
                                    } Catch (Exception $e) {
                                        
                                    }
                                }
                            }
                        } else {
                            $err = 1;
                        }
                    }
                }
                if (!$err) {

                    /* if($error_emails){
                      $this->Session->write("ERROR","'".implode(',',$error_emails)."' are invalid emails. So they are not invited to OS Please try again!");
                      $this->redirect(HTTP_ROOT."users/manage/");
                      } */

                    $this->Session->write("SUCCESS", $invited_emails . " are successfully added");
                        if (strpos($_SERVER['HTTP_REFERER'],'onBoard')) {
                            setcookie('FIRST_INVITE_2', '1', time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                            setcookie('FIRST_INVITE_1', '0', time() - 60000, '/', DOMAIN_COOKIE, false, false);

//                            if($_COOKIE['FIRST_DISPLAY_LIST'] ==1){
//                                $this->redirect(HTTP_ROOT . "dashboard#kanban");
//                            }else{
                            $this->redirect(HTTP_ROOT . "dashboard");
                            //}
                            exit;
                        }
                    if ($_SERVER['HTTP_REFERER'] == HTTP_ROOT . 'onbording') {
                        $this->redirect(HTTP_ROOT . "onbording");
                        exit;
                    }
                    if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                        $this->redirect(HTTP_ROOT . "getting_started");
                        exit;
                    }

                    if ((strtolower($GLOBALS['Userlimitation']['user_limit']) != 'unlimited') && $GLOBALS['usercount'] <= 1) {
                         if ($_COOKIE['FIRST_LOGIN_1']){
                           // $this->redirect(HTTP_ROOT . 'getting_started');
                             $this->redirect(HTTP_ROOT . 'users/onBoard');
                        }else{
                        $this->redirect(HTTP_ROOT . "onbording");
                        }
                        exit;
                    } else {
                        if (trim($invite_users) && !isset($this->request->data['User']['pid'])) {
                            $invite_users = trim($invite_users, ',');
                            setcookie('LAST_INVITE_USR', $invite_users, time() + 3600, '/', DOMAIN_COOKIE, false, false);
								setcookie('LAST_INVITE_USR_NAMES', $this->User->getUserNames($invite_users), time() + 3600, '/', DOMAIN_COOKIE, false, false);
                        }
                       if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                            $this->redirect(HTTP_ROOT . "getting_started");
                            exit;
                        }
                        //$this->redirect(HTTP_ROOT."users/manage/?role=invited");
                        //if($invited_to_only_new){
                        $this->redirect(HTTP_ROOT . "users/manage/?role=recent");
                        /* }else{
                          $this->redirect(HTTP_ROOT."users/manage/?role=all");
                          } */
                    }
                       if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                            $this->redirect(HTTP_ROOT . "getting_started");
                            exit;
                        }
                    //$this->redirect(HTTP_ROOT."users/manage/?role=invited");
                    //if($invited_to_only_new){
                     if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                        $this->redirect(HTTP_ROOT . "getting_started");
                        exit;
                    }
                    $this->redirect(HTTP_ROOT . "users/manage/?role=recent");
                    /* }else{
                      $this->redirect(HTTP_ROOT."users/manage/?role=all");
                      } */
                } else {
                        $this->Session->write("ERROR", __("Invitation Failed. Please try again!",true));
                     if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                        $this->redirect(HTTP_ROOT . "getting_started");
                        exit;
                    }
                    $this->redirect(HTTP_ROOT . "users/manage/");
                }
            } else {
                $auto_password = '';
					if($this->request->data['User']['role_id'] == 699){ // this conditioon is checked for guest user
                        if($this->User->allowedGuestUserCount(1) == "excess"){
                            if (SES_TYPE == 3) {
                                $this->Session->write("ERROR", "Sorry! you have exceeded the guest user limit. Please <a href='" . HTTP_ROOT . "/pricing'>Upgrade</a>");
                            } else {
                                $this->Session->write("ERROR", __("Sorry! This account exceeded the guest user limit.",true));
                            }
                            $this->redirect(HTTP_ROOT);
                            exit;
                        }
                    }
                if (!filter_var($this->request->data['User']['email'], FILTER_VALIDATE_EMAIL)) {
                    $error_emails = $this->request->data['User']['email'];
                }
                $findEmail = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'])));
                if (@$findEmail['User']['id']) {
                    $userid = $findEmail['User']['id'];
                    $PIDS = null;
                    //Below three line Added for the new invite user functionality
                    if (!$findEmail['User']['password'] && !$findEmail['User']['dt_last_login']) {
                        $invitation_details_t = $UserInvitation->find('first', array('conditions' => array('user_id' => $userid, 'company_id' => SES_COMP), 'fields' => array('id', 'project_id')));
                        if (isset($this->request->data['User']['pid'])) {
                            $PIDS = $this->request->data['User']['pid'];
                        }
                        if (@$invitation_details_t['UserInvitation']['id']) {
                            $previous_project_invitation_id = $invitation_details_t['UserInvitation']['id'];
                            if ($PIDS) {
                                if (is_array($PIDS)) {
                                    $PIDS = implode(',', $PIDS);
                                }
                                $PIDS = $invitation_details_t['UserInvitation']['project_id'] ? $invitation_details_t['UserInvitation']['project_id'] . ',' . $PIDS : $PIDS;
                            } else {
                                if ($invitation_details_t['UserInvitation']['project_id']) {
                                    $PIDS = $invitation_details_t['UserInvitation']['project_id'];
                                }
                            }
                        }
                        $previous_project_invitation_ids = $PIDS;
                        $userid_pass = $this->newInviteUserProcess($findEmail, 'old', 0, $PIDS);
                        $temp_userid_pass = explode('___', $userid_pass);
                        $auto_password = $temp_userid_pass[1];
                    } else {
                        if (isset($this->request->data['User']['pid'])) {
                            $PIDS = $this->request->data['User']['pid'];
                            if (is_array($PIDS)) {
                                $PIDS = implode(',', $PIDS);
                            }
                            $previous_project_invitation_ids = $PIDS;
                            $ProjectUser = ClassRegistry::init('ProjectUser');
                            $ProjectUser->recursive = -1;
                            $projectids = array();
                            $last_insert_id = '';
                            if (strstr($PIDS, ',')) {
                                $projectids = explode(',', $PIDS);
                            } else {
                                $projectids[] = $PIDS;
                            }
                            if ($projectids && !empty($projectids)) {
                                foreach ($projectids as $key => $val) {
                                    if (trim($val)) {
                                        if ($last_insert_id != '') {
                                            $last_insert_id += 1;
                                        } else {
                                            $getLastId = $ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
                                            $nextid = $getLastId[0][0]['maxid'] + 1;
                                            $last_insert_id = $nextid;
                                        }
                                        $projUsr['ProjectUser']['id'] = $last_insert_id;
                                        $projUsr['ProjectUser']['user_id'] = $userid;
                                        $projUsr['ProjectUser']['project_id'] = trim($val);
                                        $projUsr['ProjectUser']['company_id'] = SES_COMP;
                                        $projUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                                        $ProjectUser->create();
                                        $ProjectUser->save($projUsr);
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $previous_project_invitation_ids = '';
                    $previous_project_invitation_id = '';
                    $this->request->data['User']['uniq_id'] = $this->Format->generateUniqNumber();
                    $this->request->data['User']['isactive'] = 2;
                    $this->request->data['User']['isemail'] = 1;
                    $this->request->data['User']['dt_created'] = GMT_DATETIME;

                    $temp_name = explode('@', $this->request->data['User']['email']);
                    $this->request->data['User']['name'] = $temp_name[0];

                    //Below one line Added and twoline commented for the new invite user functionality
                    $userid_pass = $this->newInviteUserProcess($this->request->data, 'new');
                    $temp_userid_pass = explode('___', $userid_pass);
                    $userid = $temp_userid_pass[0];
                    $auto_password = $temp_userid_pass[1];
                    //$this->User->save($this->request->data);
                    //$userid = $this->User->getLastInsertID();
                }
                if ($userid && $userid != $this->Auth->User("id")) {
                    $qstr = $this->Format->generateUniqNumber();

                    if ($invitation_id) {
                        $InviteUsr['UserInvitation']['id'] = $invitation_id;
                    }
                    if ($previous_project_invitation_id != '') {
                        $InviteUsr['UserInvitation']['id'] = $previous_project_invitation_id;
                    }
                    $InviteUsr['UserInvitation']['invitor_id'] = $this->Auth->User("id");
                    $InviteUsr['UserInvitation']['user_id'] = $userid;

                    $InviteUsr['UserInvitation']['company_id'] = $company_id;
                    if (isset($this->request->data['User']['pid'])) {
                        if (is_array($this->request->data['User']['pid']) && !empty($this->request->data['User']['pid'])) {
                            if ($previous_project_invitation_ids != '') {
                                $InviteUsr['UserInvitation']['project_id'] = $previous_project_invitation_ids;
                            } else {
                                $InviteUsr['UserInvitation']['project_id'] = implode(",", $this->request->data['User']['pid']);
                            }
                            //$InviteUsr['UserInvitation']['project_id'] = implode(",",$this->request->data['User']['pid']);
                        } elseif ($this->request->data['User']['pid']) {
                            //$InviteUsr['UserInvitation']['project_id'] = $this->request->data['User']['pid'];
                            if ($previous_project_invitation_ids != '') {
                                $InviteUsr['UserInvitation']['project_id'] = $previous_project_invitation_ids;
                            } else {
                                $InviteUsr['UserInvitation']['project_id'] = $this->request->data['User']['pid'];
                            }
                        }
                    } else {
                        $project_list = $projectcls->find('first', array('conditions' => array('Project.short_name' => 'WCOS', 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => "Project.id"));
                        if ($project_list) {
                            $InviteUsr['UserInvitation']['project_id'] = $project_list['Project']['id'];
                        }
                    }
                    $InviteUsr['UserInvitation']['qstr'] = $qstr;
                    $InviteUsr['UserInvitation']['created'] = GMT_DATETIME;
                    $InviteUsr['UserInvitation']['is_active'] = 1;
                    $InviteUsr['UserInvitation']['user_type'] = $this->request->data['User']['istype'];

                    //Below one line Added for the new invite user functionality
                    //if($auto_password != ''){
                    $InviteUsr['UserInvitation']['is_active'] = 0;
                    //}						
                    if ($UserInvitation->save($InviteUsr)) {
                        $is_sub_upgrade = 1;
                        // Checking for a deleted user when gets invited again.
                        $compuser = $CompanyUser->find('first', array('conditions' => array('user_id' => $userid, 'company_id' => SES_COMP)));
                        if ($compuser && $compuser['CompanyUser']['is_active'] == 3) {
                            $is_sub_upgrade = 0;
                            // If that user deleted in the same billing month and invited again then that user will not paid 
                            if ($GLOBALS['Userlimitation']['btsubscription_id']) {
                                if (strtotime($GLOBALS['Userlimitation']['next_billing_date']) > strtotime($compuser['CompanyUser']['billing_end_date'])) {
                                    $is_sub_upgrade = 1;
                                }
                            }
                            $cmpnyUsr['CompanyUser']['id'] = $compuser['CompanyUser']['id'];
                        }
                        if (!$resend) {
                            $cmpnyUsr['CompanyUser']['user_id'] = $userid;
                            $cmpnyUsr['CompanyUser']['company_id'] = $company_id;
                            $cmpnyUsr['CompanyUser']['company_uniq_id'] = COMP_UID;
                            $cmpnyUsr['CompanyUser']['user_type'] = $this->request->data['User']['istype'];
                            $cmpnyUsr['CompanyUser']['is_active'] = 2;
                                $cmpnyUsr['CompanyUser']['role_id'] = (isset($this->request->data['User']['role_id']) && !empty($this->request->data['User']['role_id'])) ? $this->request->data['User']['role_id'] : 3;

                                 if($cmpnyUsr['CompanyUser']['role_id'] ==2){
                                    $cmpnyUsr['CompanyUser']['user_type'] = 2;
                                 } 
                                 if($cmpnyUsr['CompanyUser']['role_id'] ==4){
                                    $cmpnyUsr['CompanyUser']['is_client'] = 1;
                                 }
                            $cmpnyUsr['CompanyUser']['created'] = GMT_DATETIME;

                            //Below three line Added for the new invite user functionality
                            //if($auto_password != ''){
                            $cmpnyUsr['CompanyUser']['is_active'] = 1;
                            $cmpnyUsr['CompanyUser']['act_date'] = GMT_DATETIME;
                            //}
                            if ($CompanyUser->saveAll($cmpnyUsr)) {
                                $comp_user_id = $CompanyUser->getLastInsertID();
                                /* if($is_sub_upgrade){
                                  $this->update_bt_subscription($comp_user_id,$company_id,1);
                                  } */
                            }
                        }
                        //Event log data and inserted into database in account creation--- Start
                        //$json_arr['email'] = $this->request->data['User']['email'];
                        //$json_arr['created'] = GMT_DATETIME;
                        //$this->Postcase->eventLog(SES_COMP,SES_ID,$json_arr,25);
                        //End 

                        $to = $this->request->data['User']['email'];
                        $expEmail = explode("@", $this->request->data['User']['email']);
                        $expName = $expEmail[0];
                        $loggedin_users = $this->Format->getUserNameForEmail($this->Auth->User("id"));
                        $fromName = ucfirst($loggedin_users['User']['name']);
                        $fromEmail = $loggedin_users['User']['email'];

                        $ext_user = '';
                        if (@$findEmail['User']['id'] && @$findEmail['User']['password']) {
                            $subject = $fromName . " added you to " . $comp['Company']['name'] . " on Orangescrum";
                            $ext_user = 1;
                        } else {
                            $subject = $fromName . " created your account on Orangescrum";
                        }
                        $uEmail = $this->User->getLoginUserEmail(SES_ID);
                        $this->Email->delivery = 'smtp';
                        $this->Email->to = $to;
                        $this->Email->subject = $subject;
							$this->Email->from = FROM_EMAIL;//!empty($uEmail['User']['email']) ? $uEmail['User']['email'] : FROM_EMAIL; //FROM_EMAIL;
                        $this->Email->template = 'invite_user';
                        $this->Email->sendAs = 'html';
                        $this->set('expName', ucfirst($expName));
                        $this->set('qstr', $qstr);
                        $this->set('existing_user', $ext_user);

                        $this->set('company_name', $comp['Company']['name']);
                        $this->set('fromEmail', $fromEmail);
                        $this->set('fromName', $fromName);
                        $this->set('email', $this->request->data['User']['email']);
                        $this->set('password', $auto_password);
                        try {
							if(defined("PHPMAILER") && PHPMAILER == 1){
								$this->Email->set_variables = $this->render('/Emails/html/invite_user',false);
								$this->PhpMailer->sendPhpMailerTemplate($this->Email);
							}else{
                            $res = $this->Sendgrid->sendgridsmtp($this->Email);
							}
                        } Catch (Exception $e) {
                            
                        }
                            $this->Session->write("SUCCESS", $this->request->data['User']['email'] . " ".__("is successfully added",true));
                             if (strpos($_SERVER['HTTP_REFERER'],'onBoard') !== false) {
                                setcookie('FIRST_INVITE_2', '1', time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                                setcookie('FIRST_INVITE_1', '0', time() - 60000, '/', DOMAIN_COOKIE, false, false);
//                                if($_COOKIE['FIRST_DISPLAY_LIST'] ==1){
//                                    $this->redirect(HTTP_ROOT . "dashboard#kanban");
//                                }else{
                                $this->redirect(HTTP_ROOT . "dashboard");
                               // }
                                exit;
                            }
                        if ($_SERVER['HTTP_REFERER'] == HTTP_ROOT . 'onbording') {
                            $this->redirect(HTTP_ROOT . "onbording");
                            exit;
                        }
                         if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                            $this->redirect(HTTP_ROOT . "getting_started");
                            exit;
                        }
                        if ($resend) {
                            $this->redirect($_SERVER['HTTP_REFERER']);
                            exit;
                            $this->redirect(HTTP_ROOT . "users/manage");
                        } else {
                            if ((strtolower($GLOBALS['Userlimitation']['user_limit']) != 'unlimited') && $GLOBALS['usercount'] <= 1) {
                                if ($_COOKIE['FIRST_LOGIN_1']){
                                    #$this->redirect(HTTP_ROOT . 'getting_started');
                                    $this->redirect(HTTP_ROOT . 'users/onBoard');
                                }else{
                                $this->redirect(HTTP_ROOT . "onbording");
                                }
                                exit;
                            } else {
                                if (!$invitation_id && (!isset($this->request->data['User']['pid']) || trim($this->request->data['User']['pid']) != '')) {
                                    setcookie('LAST_INVITE_USR', $userid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
										setcookie('LAST_INVITE_USR_NAMES', $this->User->getUserNames($userid), time() + 3600, '/', DOMAIN_COOKIE, false, false);
                                }
                                //Added for the new invite functioality
                                //$this->redirect(HTTP_ROOT."users/manage/?role=invited");
                                /* if($ext_user == 1)
                                  $this->redirect(HTTP_ROOT."users/manage/?role=all");
                                  else */
                                 if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                                    $this->redirect(HTTP_ROOT . "getting_started");
                                    exit;
                                }
                                if ($cmpnyUsr['CompanyUser']['is_client'] == '1') {
                                    $this->redirect(HTTP_ROOT . "users/manage/?role=client");
                                }
                                $this->redirect(HTTP_ROOT . "users/manage/?role=recent");
                            }
                        }
                    }
                }
                    $this->Session->write("ERROR", __("Invitation Failed. Please try again!",true));
                 if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
                    $this->redirect(HTTP_ROOT . "getting_started");
                    exit;
                }
                if ($resend) {
                    $this->redirect($_SERVER['HTTP_REFERER']);
                    exit;
                    $this->redirect(HTTP_ROOT . "users/manage");
                } else {
                    $this->redirect(HTTP_ROOT . "mydashboard");
                }
            }
            } else{
				 $this->Session->write("ERROR", __("Sorry, User Limit has Exceeded.",true));
				$this->redirect(HTTP_ROOT . "users/manage");
        }
        if (strpos($_SERVER['HTTP_REFERER'],'onBoard')) {
            $this->redirect(HTTP_ROOT . "dashboard");
                exit;
            }
         if (strpos($_SERVER['HTTP_REFERER'],'getting_started') !== false) {
            $this->redirect(HTTP_ROOT . "getting_started");
            exit;
        }
        if ($resend) {
            $this->redirect(HTTP_ROOT . "users/manage");
        }
        $this->layout = 'ajax';
        //$userType = array(2=>"Member",3=>"Customer");
        if (SES_TYPE == 1) {
            $userType = array(3 => "Member", 2 => "Admin");
        } else {
            $userType = array(3 => "Member");
        }

        $TimezoneName = ClassRegistry::init('TimezoneName');
        $TimezoneName->recursive = -1;
        $tmZoneArr = $TimezoneName->find('all');

        $this->set('userType', $userType);
        $this->set('tmZoneArr', $tmZoneArr);
        $this->set('uniq_id', COMP_UID);
    }

    function newInviteUserProcess($data, $type, $more = null, $pids = null) {
        $uArray = array();
        $this->loadModel('ProjectUser');

        if ($pids) {
            if (is_array($pids)) {
                $data['User']['pid'] = implode(',', $pids);
            } else {
                $data['User']['pid'] = $pids;
            }
        } else {
            if (isset($data['User']['pid'])) {
                if (is_array($data['User']['pid'])) {
                    $data['User']['pid'] = implode(',', $data['User']['pid']);
                } else {
                    $data['User']['pid'] = $data['User']['pid'];
                }
            }
        }

        //$ty = fopen('textMe.txt','a');
        //fwrite($ty,print_r($data,true));
        if (isset($data['User']['password']) && $data['User']['password'] && $type != 'resend') {
            $pass = '';
            $uArray['User']['password'] = $data['User']['password'];
        } else {
            $pass = $this->Format->genRandomString();
            $uArray['User']['password'] = md5($pass);
        }
        if (isset($data['User']['timezone_id']) && $data['User']['timezone_id']) {
            $uArray['User']['timezone_id'] = $data['User']['timezone_id'];
        } else {
            $uArray['User']['timezone_id'] = $data['TimezoneName']['id'];
        }
        if (isset($data['User']['ip']) && $data['User']['ip']) {
            $uArray['User']['ip'] = $data['User']['ip'];
        } else {
            $uArray['User']['ip'] = $_SERVER['REMOTE_ADDR'];
        }
        if (isset($data['User']['last_name']) && $data['User']['last_name']) {
            $uArray['User']['last_name'] = $data['User']['last_name'];
        } else {
            $uArray['User']['last_name'] = '';
        }
        if (isset($data['User']['short_name']) && $data['User']['short_name']) {
            $uArray['User']['short_name'] = $data['User']['short_name'];
        } else {
            $uArray['User']['short_name'] = $this->Format->makeShortName($data['User']['name'], '');
        }
        if (isset($data['User']['dt_created']) && $data['User']['dt_created']) {
            $uArray['User']['dt_created'] = $data['User']['dt_created'];
        } else {
            $uArray['User']['dt_created'] = GMT_DATETIME;
        }
        $uArray['User']['name'] = trim($data['User']['name']);
        if ($type == 'new') {
            if (isset($data['User']['uniq_id']) && $data['User']['uniq_id']) {
                $uArray['User']['uniq_id'] = $data['User']['uniq_id'];
            } else {
                $uArray['User']['uniq_id'] = $this->Format->generateUniqNumber();
            }
            $uArray['User']['email'] = $data['User']['email'];
        }
        $uArray['User']['isactive'] = 1;
            if (isset($data['User']['id']) && $data['User']['id']) {
            $uArray['User']['id'] = $data['User']['id'];
        } else {
            // no user		    
            //$qstr = $this->request->data['User']['qstr'];
							$uArray['User']['keep_hover_effect'] = 15;
        }
        if ($more) {
            $this->User->saveAll($uArray);
        } else {
            $this->User->save($uArray);
        }
        $UID = '';
        if (isset($data['User']['id']) && $data['User']['id']) {
            $UID = $data['User']['id'];
        } else {
            $UID = $this->User->getLastInsertID();
            if ($type != 'resend') {
                $notification['user_id'] = $UID;
                $notification['type'] = 1;
                    $notification['value'] = 0;
                    $notification['due_val'] = 0;
                if ($more) {
                    ClassRegistry::init('UserNotification')->saveAll($notification);
                } else {
                    ClassRegistry::init('UserNotification')->save($notification);
                }
            }
        }
        if (isset($data['User']['pid']) && $data['User']['pid']) {
            $ProjectUser = ClassRegistry::init('ProjectUser');
            $ProjectUser->recursive = -1;
            //$this->ProjectUser->recursive = -1;
            /* if(isset($_SESSION['puincrement_id'])){
              $_SESSION['puincrement_id'] = $_SESSION['puincrement_id'] + 1;
              }else{
              //$getLastId = $this->ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
              $getLastId = $ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
              $nextid = $getLastId[0][0]['maxid']+1;
              $_SESSION['puincrement_id'] = $nextid;
              } */
            $projectids = array();
            if (isset($data['User']['pid'])) {
                if (strstr($data['User']['pid'], ',')) {
                    $projectids = explode(',', $data['User']['pid']);
                } else {
                    if ($data['User']['pid']) {
                        $projectids[] = $data['User']['pid'];
                    }
                }
            }
                  if ($projectids && !empty($projectids)) {
                  foreach ($projectids as $key => $val) {
                  $projUsr = null;
                  if (trim($val)) {
                  if (isset($_SESSION['puincrement_id'])) {
					$_SESSION['puincrement_id'] = $_SESSION['puincrement_id'] + 1;
					$_SESSION['project_increment_id'] = $_SESSION['puincrement_id'];
                  } else {
					  if (isset($_SESSION['project_increment_id']) && $_SESSION['project_increment_id']) {
						$_SESSION['puincrement_id'] = $_SESSION['project_increment_id'] + 1;
						$_SESSION['project_increment_id'] = $_SESSION['puincrement_id'];
					  } else {
					  //$getLastId = $this->ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
						$getLastId = $ProjectUser->query("SELECT id FROM project_users order by id desc limit 1");
						$nextid = $getLastId[0]['project_users']['id'] + 1;
						$_SESSION['puincrement_id'] = $nextid;
						$_SESSION['project_increment_id'] = $nextid;
					  }
                  }
                  $projUsr['ProjectUser']['id'] = $_SESSION['puincrement_id'];
                  $projUsr['ProjectUser']['user_id'] = $UID;
                  $projUsr['ProjectUser']['project_id'] = trim($val);
                  $projUsr['ProjectUser']['company_id'] = SES_COMP;
                  $projUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                  //fwrite($ty,print_r($projUsr,true));
                  $ProjectUser->create();
                  $ProjectUser->save($projUsr);
                  /* if($more){
                  $this->ProjectUser->saveAll($projUsr);
                  }else{
                  $this->ProjectUser->saveAll($projUsr);
                  } */
                  }
                }
            }
        }
        if (!isset($data['User']['password'])) {
            //Event log data and inserted into database in account creation--- Start
            $json_arr['email'] = $data['User']['email'];
            $json_arr['name'] = $data['User']['name'] . " " . $data['User']['last_name'];
            $json_arr['created'] = GMT_DATETIME;
            $this->Postcase->eventLog(SES_COMP, $data['User']['id'], $json_arr, 26);
            //End 		
        }
        //$this->User->query("UPDATE users set isactive='1' where id='".$usr['User']['id']."'");		
        return $UID . '___' . $pass;
    }

    function getProjects() {
        $this->layout = 'ajax';
        $items = array();
        $Company = ClassRegistry::init('Company');
        //$comp = $Company->find('first', array('conditions' => array('Company.seo_url' => CHECK_DOMAIN), 'fields' => array('Company.id')));
        //$company_id = $comp['Company']['id'];
        $company_id = SES_COMP;
        $cond = "Project.isactive=1 AND Project.name != ''";
        $cond .= " AND Project.company_id = " . $company_id . " AND 
                    Project.id IN (SELECT DISTINCT ProjectUser.project_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id = " . SES_ID . ")";

        if (isset($this->request->query['view']) && $this->request->query['view'] == 'list') {
            $cond.= " AND Project.id !=''";
        } else {
            $q = ($this->request->query['tag']) ? $this->request->query['tag'] : $this->data['q'];

            if (trim($q)) {
                $cond .= " AND Project.name LIKE '%" . $q . "%'";
            }
            if (trim($this->params['pass'][0])) {
                $cond.= " AND Project.id NOT IN(" . $this->params['pass'][0] . ")";
            }
        }
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $sql = "SELECT DISTINCT Project.id,Project.name FROM projects AS Project WHERE " . $cond . " ORDER BY Project.name";
        $projArr = $Project->query($sql);
        //ob_clean();
        $str = '';
        if (isset($this->request->query['view']) && $this->request->query['view'] == 'list') {
            foreach ($projArr as $key => $value) {
                $items[$value['Project']['id']] = $value['Project']['name'];
            }
            print json_encode($items);
            exit;
        } else if (isset($this->request->query['tag']) && trim($this->request->query['tag'])) {
            foreach ($projArr as $key => $value) {
                $items[] = array("key" => $value['Project']['id'], "value" => $value['Project']['name']);
            }
            print json_encode($items);
            exit;
        } else {
            $this->set('allProjects', $projArr);
            if (trim($q) || ($this->data['serch_chk'] == 1)) {
                $this->render('/Elements/list_projects');
            }
        }
    }

    function notification() {
        $this->layout = 'ajax';
        $CaseUserView = ClassRegistry::init('CaseUserView');
        $allCases = $CaseUserView->find('all', array('conditions' => array('CaseUserView.user_id' => SES_ID, 'CaseUserView.isviewed' => 0, 'CaseUserView.istype' => 1), 'ORDER' => array('CaseUserView.id ASC'), 'limit' => 1));
        $this->set('allCases', $allCases);
    }

    function caseview_remove() {
        $this->layout = 'ajax';
        $id = NULL;
        if (isset($this->request->data['id'])) {
            $id = $this->request->data['id'];
        }
        $CaseUserView = ClassRegistry::init('CaseUserView');
        $CaseUserView->query("UPDATE case_user_views as CaseUserView SET CaseUserView.isviewed='1' WHERE CaseUserView.id=" . $id);
        exit;
    }

    function project_menu() {
        $this->layout = 'ajax';
        $page = $this->request->data['page'];
        $pgname = isset($this->request->data['page_name']) ? $this->request->data['page_name'] : '';
        $limit = $this->request->data['limit'];
        $filter = $this->request->data['filter']; //echo $filter;
        $qry = "";
            $restrictedQuery = "";
            if(!$this->Format->isAllowed('View All Task',$roleAccess)){
                 $restrictedQuery= " AND (ec.assign_to=" . SES_ID . " OR ec.user_id=".SES_ID.")";
            }
        $ProjectUser = ClassRegistry::init('ProjectUser');
        if ($filter == "delegateto") {
            $qry = " AND ec.user_id=" . SES_ID . " AND ec.assign_to!=0 AND ec.assign_to!=" . SES_ID;
        } else if ($filter == "assigntome") {
            $qry = " AND ((ec.assign_to=" . SES_ID . ") OR (ec.assign_to=0 AND ec.user_id=" . SES_ID . "))";
        } else if ($filter == "latest") {
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $qry = " AND ec.dt_created > '" . $before . "' AND ec.dt_created <= '" . GMT_DATETIME . "'";
        } else if ($filter == "files") {
            $qry = " AND ec.format = '1'";
        } else {
            $qry = "";
        }
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((ec.client_status = " . $this->Auth->user('is_client') . " AND ec.user_id = " . $this->Auth->user('id') . ") OR ec.client_status != " . $this->Auth->user('is_client') . ")";
        }
            $methodology_cond = ($this->request->data['methodology'] == 'sprint')?" AND p.project_methodology_id=2 ":"";
        if ($limit != "all") {
							if(defined('SHOW_LESS_INFO') && CMP_CREATED <= SHOW_LESS_INFO){
						$allProjArr = $ProjectUser->query("select SQL_CALC_FOUND_ROWS p.name,p.id,p.uniq_id as uniq_id,p.project_methodology_id,(select count(ec.id) from easycases as ec where ec.istype='1' AND ec.isactive='1' AND " . $clt_sql . " AND pu.project_id=ec.project_id " . trim($qry) .$restrictedQuery. ") as count from projects as p, project_users as pu where p.id=pu.project_id and pu.user_id='" . SES_ID . "' and p.company_id='" . SES_COMP . "' and p.company_id=pu.company_id AND p.isactive='1' $methodology_cond  ORDER BY pu.dt_visited DESC LIMIT 0,$limit");		
							}else{							
								$allProjArr = $ProjectUser->query("select SQL_CALC_FOUND_ROWS DISTINCT p.name,p.id,p.uniq_id as uniq_id,p.project_methodology_id from projects as p, project_users as pu where p.id=pu.project_id and pu.user_id='" . SES_ID . "' and p.company_id='" . SES_COMP . "' and p.company_id=pu.company_id AND p.isactive='1' $methodology_cond  ORDER BY pu.dt_visited DESC LIMIT 0,$limit");
							}
            } else {
							if(defined('SHOW_LESS_INFO') && CMP_CREATED <= SHOW_LESS_INFO){
                $allProjArr = $ProjectUser->query("select SQL_CALC_FOUND_ROWS DISTINCT p.name,p.id,p.project_methodology_id,p.uniq_id as uniq_id,(select count(ec.id) from easycases as ec where ec.istype='1' AND ec.isactive='1' AND " . $clt_sql . " AND pu.project_id=ec.project_id  " . trim($qry) . ") as count from projects as p, project_users as pu where p.id=pu.project_id and pu.user_id='" . SES_ID . "' and p.company_id='" . SES_COMP . "' and pu.company_id='" . SES_COMP . "' AND p.isactive='1' $methodology_cond  ORDER BY pu.dt_visited DESC");
        } else {
								$allProjArr = $ProjectUser->query("select SQL_CALC_FOUND_ROWS DISTINCT p.name,p.id,p.project_methodology_id,p.uniq_id as uniq_id from projects as p, project_users as pu where p.id=pu.project_id and pu.user_id='" . SES_ID . "' and p.company_id='" . SES_COMP . "' and pu.company_id='" . SES_COMP . "' AND p.isactive='1' $methodology_cond  ORDER BY pu.dt_visited DESC");
        }

            }
        $totProjCnt = $ProjectUser->query("SELECT FOUND_ROWS() as count");
        $countAll = $totProjCnt['0']['0']['count'];

            $methodology_cond = ($this->request->data['methodology'] == 'sprint')?" AND p.project_methodology_id=2 ":"";

						//commented not to show task count for new users
						if(defined('SHOW_LESS_INFO') && CMP_CREATED <= SHOW_LESS_INFO){
            $allPjCount = $ProjectUser->query("select count(DISTINCT ec.id) as count from projects as p, project_users as pu, easycases as ec where p.id=pu.project_id and pu.user_id='" . SES_ID . "' AND pu.project_id=ec.project_id AND ec.istype='1' and pu.company_id='" . SES_COMP . "' AND ec.isactive='1' AND p.isactive='1' $methodology_cond " . trim($qry) .$restrictedQuery. "");

						}else{
							$allPjCount = array();
						}


            if ($page == 'ganttv3') {
                echo json_encode($allProjArr);
                exit;
            }
            if($this->request->data['page'] == 'PROJECT_REPORTS'){
                echo json_encode(array('projects' => $allProjArr, 'allPjCount' => $allPjCount[0][0]));
                exit;
            }
        $this->set('allProjArr', $allProjArr);
        $this->set('allPjCount', $allPjCount);

        //$countAll = $ProjectUser->find('count', array('conditions'=>array('ProjectUser.user_id' => SES_ID,'Project.isactive' => 1), 'fields' => 'DISTINCT Project.id'));
        $this->set('countAll', $countAll);

        $this->set('page', $page);
        $this->set('pgname', $pgname);
        $this->set('limit', $limit);
        if ($filter == "timelog") {
            $this->set('pageFilter', 'timelog');
            }elseif($filter == "kanban_only"){
               //$this->request->data['popupid']='projpopup';
        } else {
            $this->set('pageFilter', '');
        }
    }

    function project_all() {
        $this->layout = 'ajax';

        $page = $this->request->data['page'];
        $type = $this->request->data['type'];

        if ($type == "enabled") {
            $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1), 'fields' => array('Project.name', 'Project.uniq_id'), 'order' => array('Project.name'));
        } else {
            $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 2), 'fields' => array('Project.name', 'Project.uniq_id'), 'order' => array('Project.name'));
        }


        $ProjectUser = ClassRegistry::init('ProjectUser');
        $ProjectUser->unbindModel(array('belongsTo' => array('User')));
        $allProjArr = $ProjectUser->find('all', $cond);

        $this->set('allProjArr', $allProjArr);
        $this->set('page', $page);
        $this->set('type', $type);
    }
    public function login($demo = NULL, $email = NULL, $pass = NULL, $first_login = 0, $dlogin = 0) {
            if (!empty($this->params->query('project_url'))) {
                $this->set("project_url", $this->params->query('project_url'));
                $_SESSION['project_url'] = $this->params->query('project_url');
        }
        
        if ($this->request->data['submit_Pass']) {
            $direct_login = 1;
        }
        $gdata = '';
        if (isset($_COOKIE['GOOGLE_INFO_SIGIN']) && !empty($_COOKIE['GOOGLE_INFO_SIGIN'])) {
            $gdata = (array) json_decode($_COOKIE['GOOGLE_INFO_SIGIN']);
            $this->request->data['User']['email'] = $gdata['email'];
        } else if (isset($_COOKIE['user_info']) && !empty($_COOKIE['user_info'])) {
            $gdata['email'] = $_COOKIE['user_info'];
            $this->request->data['User']['email'] = $gdata['email'];
            unset($_COOKIE['user_info']);
            setcookie('user_info', '', time() - 60000, '/', DOMAIN_COOKIE, false, false);
        } else if (isset($_COOKIE['GOOGLE_USER_INFOS']) && !empty($_COOKIE['GOOGLE_USER_INFOS'])) {
            $google_user_infos = json_decode($_COOKIE['GOOGLE_USER_INFOS'], true);
            $_SESSION['GOOGLE_USER_INFO'] = $google_user_infos['GOOGLE_USER_INFO'];
            setcookie('GOOGLE_USER_INFOS', '', time() - 60000, '/', DOMAIN_COOKIE, false, false);
        }

					$Linkdata = '';
					if (isset($_COOKIE['linkedin_info']) && !empty($_COOKIE['linkedin_info'])) {
						$Linkdata['email'] = $_COOKIE['linkedin_info'];
						$this->request->data['User']['email'] = $Linkdata['email'];
						unset($_COOKIE['linkedin_info']);
						setcookie('linkedin_info', '', time() - 60000, '/', DOMAIN_COOKIE, false, false);
					}	
        if (isset($_SESSION['GOOGLE_USER_INFO']) && !empty($_SESSION['GOOGLE_USER_INFO'])) {
            $this->request->data['User']['email'] = $_SESSION['GOOGLE_USER_INFO']['email'];
        }

        if (isset($this->request->data['User']['email'])) {
            $this->request->data['User']['email'] = trim($this->request->data['User']['email']);
        }
        $emailCheck = $this->request->data['User']['email'];
        $google_user_info = $_SESSION['GOOGLE_USER_INFO'];        

        if (!empty($this->request->data) || !empty($email)) {
            $chk_eml = ($this->request->data['User']['email']) ? $this->request->data['User']['email'] : $email;
            /* start check user login after free trial expired */
            $res_chk = $this->User->checkUserTrialExist($chk_eml);
            if (!empty($res_chk)) {
                $res_chk_cnt = count($res_chk);
                if ($res_chk_cnt == 1 && ($res_chk[0]['company_users']['company_trial_expired'] == 1)) {
                    $this->Session->setFlash("Oops! 30-day FREE trial has expired. Contact your account owner.", 'default', array('class' => 'error'));
                    unset($_SESSION['GOOGLE_USER_INFO']);
                    unset($_SESSION['user_last_login']);
                    $this->redirect(HTTP_APP . "users/login");
                } else if ($res_chk_cnt > 1) {
                    $quink_chk = 0;
                    foreach ($res_chk as $key_i => $val_i) {
                        if ($val_i['company_users']['company_trial_expired'] == 0) {
                            $quink_chk = 1;
                            break;
                        }
                    }
                    if ($quink_chk != 1) {
                        $this->Session->setFlash("Oops! 30-day FREE Trial has expired. Contact your Account Owner.", 'default', array('class' => 'error'));
                        unset($_SESSION['GOOGLE_USER_INFO']);
                        unset($_SESSION['user_last_login']);
                        $this->redirect(HTTP_APP . "users/login");
                    }
                }
            }
            /* end */
            $usrLogin = array();
            if (isset($this->data['User']['email']) && !empty($this->data['User']['email']) && isset($this->data['User']['password']) && !empty($this->data['User']['password'])) {
                $this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
                $usrLogin_check = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'], 'User.isactive' => 1)));
                /*                 * **check email edited by admin or owner ***** */
                if ($usrLogin_check['User']['updated_by'] == 1) {
                    $this->Session->setFlash("Your email id has been changed to '" . $usrLogin_check['User']['update_email'] . "'. Please check '" . $usrLogin_check['User']['update_email'] . "' to confirm your account and access your Orangescrum account using your updated Email ID.", 'default', array('class' => 'error'));
                    $this->redirect(HTTP_ROOT . "users/login");
                    exit;
                }
                /*                 * **End of check email edited by admin or owner ***** */
            }


            if ($email && $pass) {
                $this->request->data['User']['email'] = $email;
                if (strlen($pass) == 32) {
                    $this->request->data['User']['password'] = $pass;
                } else {
                    $this->request->data['User']['password'] = md5($pass);
                }
                $this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
                $usrLogin = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'], 'User.password' => $this->request->data['User']['password'], 'User.isactive' => 1)));
                $this->Session->write('Auth.User', $usrLogin['User']);
            } else if (isset($_SESSION['GOOGLE_USER_INFO']) && !empty($_SESSION['GOOGLE_USER_INFO'])) {
                $this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
                //$usrLogin = $this->User->find('first',array('conditions'=>array('User.email'=>$this->request->data['User']['email'],'User.isactive'=>1)));
                $usrLogin = $this->User->find('first', array('conditions' => array('User.email' => $_SESSION['GOOGLE_USER_INFO']['email'], 'User.isactive' => 1)));
                //saving google id
                if (isset($usrLogin['User']['google_id']) && empty($usrLogin['User']['google_id']) && isset($_SESSION['GOOGLE_USER_INFO']['id'])) {
                    $this->User->query("Update users SET google_id='" . $_SESSION['GOOGLE_USER_INFO']['id'] . "' WHERE id=" . $usrLogin['User']['id']);
                }

                $this->Session->write('Auth.User', $usrLogin['User']);
//                $this->saveUserInfo($usrLogin['User']['id'],$_SESSION['GOOGLE_USER_INFO']['access_token'],0);
                $access_token = $_SESSION['GOOGLE_USER_INFO']['access_token'];
                unset($_SESSION['GOOGLE_USER_INFO']);
            } else if (isset($gdata['email']) && !empty($gdata['email'])) {
                $this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
                $usrLogin = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'], 'User.isactive' => 1)));

                //saving google id
                if (isset($usrLogin['User']['google_id']) && !empty($usrLogin['User']['google_id']) && isset($_SESSION['GOOGLE_USER_INFO']['id'])) {
                    $this->User->query("Update users SET google_id='" . $_SESSION['GOOGLE_USER_INFO']['id'] . "' WHERE id=" . $usrLogin['User']['id']);
                }
                $this->Session->write('Auth.User', $usrLogin['User']);
                unset($_SESSION['GOOGLE_USER_INFO']);
//                $this->saveUserInfo($usrLogin['User']['id'],$_COOKIE['token'],0);
                $access_token = $_COOKIE['token'];
                setcookie('GOOGLE_INFO_SIGIN', '', -365, '/', DOMAIN_COOKIE, false, false);
						} else if (isset($Linkdata['email']) && !empty($Linkdata['email'])) {
								$this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
								$usrLogin = $this->User->find('first', array('conditions' => array('User.email' => $this->request->data['User']['email'], 'User.isactive' => 1)));
								//saving linkedin id
								if (isset($usrLogin['User']['linkedin_id']) && isset($_SESSION['LINKEDIN_USER_INFO']) && !empty($_SESSION['LINKEDIN_USER_INFO'])) {
									$this->User->query("Update users SET linkedin_id='" . $_SESSION['LINKEDIN_USER_INFO'] . "' WHERE id=" . $usrLogin['User']['id']);									
								}
								unset($_SESSION['LINKEDIN_USER_INFO']);
								$this->Session->write('Auth.User', $usrLogin['User']);
						}else if(!empty($glogin)){
								$this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
								$usrLogin = $this->User->find('first', array('conditions' => array('User.email' => $email, 'User.isactive' => 1)));
								//saving google id
								if (empty($usrLogin['User']['one_tap_token'])) {
										$this->User->query("UPDATE users SET one_tap_token='" . $glogin . "' WHERE id=" . $usrLogin['User']['id']);
										$usrLogin['User']['one_tap_token'] = $glogin;
								}else if(!empty($usrLogin['User']['one_tap_token'])){
									$usrLogin = $this->User->find('first', array('conditions' => array('User.email' => $email, 'User.isactive' => 1, 'User.one_tap_token' => $glogin)));
									if(empty($usrLogin)){
										//email here
										$subject = "G-ONETAP SIGNIN ERROR";
                    $message = "A user is trying to signin/signup into OS using one tap sign up, but not able to proceed due to mismatch auth token. <br/><font color='#EE0000'>" . $glogin . "</font><br/>Email: " . $email . "<br/>";
                    $this->Sendgrid->sub_sendgrid(FROM_EMAIL, 'prabhudas.behera@andolasoft.co.in', $subject, $message, "", 'jypti@andolasoft.com', '');
										return 'fail';
									}
								}
								$this->Session->write('Auth.User', $usrLogin['User']);
								unset($_SESSION['GOOGLE_USER_INFO']);
								//$this->saveUserInfo($usrLogin['User']['id'],$_COOKIE['token'],0);
								setcookie('GOOGLE_INFO_SIGIN', '', -365, '/', DOMAIN_COOKIE, false, false);
            }
            if (($this->Auth->login() || isset($usrLogin['User']['id'])) && $this->Auth->user('id')) {
                        Cache::delete('prrofile_detl_'.$this->Auth->user('id'));
						if (Cache::read('easyrelate_detl_') !== false) {
							Cache::delete('easyrelate_detl_');
						}
						if (Cache::delete('task_field_'.$this->Auth->user('id')) !== false) {
							Cache::delete('task_field_'.$this->Auth->user('id'));
						}
            $this->User->readKeepHoverfromCache($this->Auth->user('id'), 1);
				//used for lead tracker set up.
                if (isset($this->request->data['User']['email'])) {
                    $_SESSION['SES_EMAIL_USER_LOGIN'] = $this->request->data['User']['email'];
                }
                $this->User->keepPassChk($this->Auth->user('id'));
                if ($usrLogin['User']['id']) {
                    $this->saveUserInfo($usrLogin['User']['id'], $access_token, 0);
                }
                $inValid = 0;
                $CompanyUser = ClassRegistry::init('CompanyUser');
                $sql = "SELECT CompanyUser.company_id,Companies.is_active,CompanyUser.user_type,CompanyUser.is_client FROM company_users CompanyUser , companies Companies WHERE Companies.id = CompanyUser.company_id AND CompanyUser.user_id=" . $this->Auth->user('id') . " AND CompanyUser.is_active=1";
                $checkCmnpyUsr = $CompanyUser->query($sql);
                //$checkCmnpyUsr = $CompanyUser->find('all',array('conditions'=>array('CompanyUser.user_id'=>$this->Auth->user('id'),'CompanyUser.is_active'=>1),'fields'=>array('CompanyUser.company_id')));
				
                $companyIds = array();
                $inactiveCompIds = array();
                $is_user_owner = 0;
                foreach ($checkCmnpyUsr as $key => $cu) {
                    if ($checkCmnpyUsr[$key]['Companies']['is_active'] || ($cu['CompanyUser']['user_type'] == 1)) {
                        $companyIds[] = $cu['CompanyUser']['company_id'];
                        if ($checkCmnpyUsr[$key]['Companies']['is_active'] == 2) {
                            $inactiveCompIds[] = $cu['CompanyUser']['company_id'];
                        }
                        if ($cu['CompanyUser']['user_type'] == 1) {
                            $is_user_owner = 1;
                        }
							//reset the default view.
							if (Cache::read('dtv_detl_'.$cu['CompanyUser']['company_id'].'_'.$this->Auth->user('id')) !== false) {
								Cache::delete('dtv_detl_'.$cu['CompanyUser']['company_id'].'_'.$this->Auth->user('id'));
							}
							//reset the subscription information.
							if (Cache::read('sub_detl_'.$cu['CompanyUser']['company_id']) !== false) {
								Cache::delete('sub_detl_'.$cu['CompanyUser']['company_id']);
								$this->UserSubscription->readSubDetlfromCache($cu['CompanyUser']['company_id']);
							}
							}
                            //reset the userRole information.
                            if (Cache::read('userRole'.$cu['CompanyUser']['company_id'].'_'.$this->Auth->user('id')) !== false) {
                                Cache::delete('userRole'.$cu['CompanyUser']['company_id'].'_'.$this->Auth->user('id'));
                            }
							$this->Format->insertLeftMenu($cu['CompanyUser']['company_id'],$this->Auth->user('id'));						
                }
                /*if (CHECK_DOMAIN != "app" && CHECK_DOMAIN != "www") {
                    $Company = ClassRegistry::init('Company');
                    $checkCmpny = $Company->find('all', array('conditions' => array('Company.id' => $companyIds, 'Company.seo_url' => CHECK_DOMAIN), 'fields' => array('Company.id', 'Company.subscription_id', 'Company.seo_url')));
                } else {*/
                    $Company = ClassRegistry::init('Company');
                    $checkCmpny = $Company->find('all', array('conditions' => array('Company.id' => $companyIds), 'fields' => array('Company.id', 'Company.subscription_id', 'Company.seo_url')));
                //}
                $seoArr = array();
                $inctiveseo = '';
				
                //$is_user_owner
                foreach ($checkCmpny as $arr) {
                    if (!$is_user_owner && !empty($inactiveCompIds) && in_array($arr['Company']['id'], $inactiveCompIds) && ($arr['Company']['subscription_id'] == CURRENT_FREE_PLAN)) {
                        $inctiveseo .= ', "' . $arr['Company']['seo_url'] . '"';
                    } else {
                        $seoArr[] = $arr['Company']['seo_url'];
                    }
                }
                if ($inctiveseo != '') {
                    $inctiveseo = trim($inctiveseo, ',');
                }

                if (count($seoArr) == 0) {
                    $inValid = 1;
                } else {
                    $inctiveseo = '';
                }
				//echo "<pre>";print_r($this->Auth->user('isactive'));exit;
                if ($this->Auth->user('isactive') == 2 || $inValid || ($inctiveseo != '')) {
                    $cookie = array();
                  //  $this->Cookie->write('Auth.User', $cookie, '-2 weeks');
                    $this->Auth->logout();
                    $this->Session->write("SES_EMAIL", $this->request->data['User']['email']);
                    if ($inctiveseo != '') {
                        if (stristr($inctiveseo, ',')) {
                            $this->Session->setFlash('Oops! the accounts ' . $inctiveseo . ' are deactivated. Please contact your account owner.', 'default', array('class' => 'error'));
                        } else {
                            $this->Session->setFlash('Oops! The account ' . $inctiveseo . ' is deactivated. Please contact your account owner.', 'default', array('class' => 'error'));
                        }
                    } else if ($inValid == 1) {
                        //$this->Session->write("LOGIN_ERROR","Oops! this account has been cancelled or deleted");
                        $this->Session->setFlash("Oops! this account has been cancelled or deleted", 'default', array('class' => 'error'));
                    } else {
                        //$this->Session->write("LOGIN_ERROR","Sorry! We could not authenticate you");
                        $this->Session->setFlash("Sorry! We could not authenticate you", 'default', array('class' => 'error'));
                    }
                    if (CHECK_DOMAIN && CHECK_DOMAIN == "www") {
                        $this->redirect(HTTP_APP . "users/login");
                    } else {
                        $this->redirect(HTTP_ROOT . "users/login");
                    }
                }
						//redirect user to my task
						setcookie('FIRST_USER_LOGIN', 1, $cookieTime, '/', DOMAIN_COOKIE, false, false);
                $this->User->id = $this->Auth->user('id');
                $this->User->saveField('dt_last_login', GMT_DATETIME);
                $this->User->saveField('is_online', 1);
                $this->User->saveField('query_string', '');
                if (stristr($_SERVER['SERVER_NAME'], "orangescrum.com")) {
                    //Leadtracker Login Session Update
                    $this->Format->SaveLoginSessionCURL($this->Auth->user('id'), GMT_DATETIME);
                }
                if ($this->isiPad()) {
                    $user_sig = md5(uniqid(rand()) . time());
                    $this->User->saveField('sig', $user_sig);
                }

                if (isset($this->request->data['User']['remember_me'])) {
                    setcookie('REMEMBER', 1, time() + 3600 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
                    unset($this->request->data['User']['remember_me']);
                    $cookieTime = time() + 3600 * 24 * 7;
                } else {
                    $cookieTime = COOKIE_TIME;
                }

                if (!$this->Auth->user('dt_last_login')) {
                    setcookie('FIRST_LOGIN', 1, $cookieTime, '/', DOMAIN_COOKIE, false, false);
                }
                if ($_COOKIE['FIRST_LOGIN']) {
                    setcookie('FIRST_LOGIN', '', -1, '/', DOMAIN_COOKIE, false, false);
                }

                setcookie('USER_UNIQ', $this->Auth->user('uniq_id'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
                setcookie('USERTYP', $this->Auth->user('istype'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
                setcookie('USERTZ', $this->Auth->user('timezone_id'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
                setcookie('USERSUB_TYPE', $this->Auth->user('usersub_type'), $cookieTime, '/', DOMAIN_COOKIE, false, false);
                setcookie('IS_MODERATOR', $this->Auth->user('is_moderator'), $cookieTime, '/', DOMAIN_COOKIE, false, false);

                if ($this->Auth->User("istype") == '1') {
                    //$this->Cookie->write('CURRENT_FILTER','latest','365 days');
                    setcookie('CURRENT_FILTER', 'latest', time() + 3600 * 24 * 365, '/', DOMAIN_COOKIE, false, false);
                }
                $redirect = HTTP_ROOT;

                $this->Session->write('Auth.User.is_client', $checkCmnpyUsr[0]['CompanyUser']['is_client']);
                $this->Session->write('Auth.User.user_type', $checkCmnpyUsr[0]['CompanyUser']['user_type']);

                //Keeping track after successfully login.
                $this->loadModel('UserLogin');
                $user_login['user_id'] = $this->Auth->user('id');
                $this->UserLogin->save($user_login);
						Cache::write('user_login_'.$this->Auth->user('id').date('Y-m-d'), $this->Auth->user('id'));
                    if (!empty($this->params->query('project_url'))) {
                        $project_url = '?project_url=' . $this->params->query('project_url');
                }else{
                    $project_url = '';
                }
                
                if ($dlogin == 1) {
                    if (count($seoArr)) {
                        $_SESSION['CHECK_DOMAIN'] = $seoArr[0];
                    }
                    return "loggedin";
                }
                if (count($seoArr)) {
                            $lurl = $this->request->data['last_url'];
                           $ll = $this->request->data['la_url'];
                            $l_ss = parse_url($lurl);
                            
                           $vv = explode(".",$l_ss[host]);
                           $c_url = $vv[0];
                            //extract the seo url from the last_url	
                             if(in_array($c_url,$seoArr)){
                                $_SESSION['CHECK_DOMAIN'] = $c_url;
                               if(!empty($ll)){
                                $this->redirect($lurl ."#/". trim($ll));
                               
                            }else{
                                $this->redirect($lurl);
                               }
                            } 
                    if (CHECK_DOMAIN != "app" && CHECK_DOMAIN != "www") {
                        $_SESSION['CHECK_DOMAIN'] = $seoArr[0];
                        $redirect = HTTP_ROOT;
                    } else {
                        if (count($seoArr) == 1) {
                            if ($checkCmnpyUsr[0]['CompanyUser']['user_type']) {
                                $redirect = PROTOCOL . $seoArr[0] . "." . DOMAIN . "mydashboard".$project_url;
                            } else {
                                $redirect = PROTOCOL . $seoArr[0] . "." . DOMAIN . Configure::read('default_page');
                            }

                            if ($this->isiPad()) {
                                $redirect = PROTOCOL . $seoArr[0] . "." . DOMAIN . 'lunchuser?sig=' . $user_sig;
                            }
                        } else {
                            $this->redirect(HTTP_APP . "users/launchpad");
                        }
                    }
                }
                if (($checkCmnpyUsr[0]['CompanyUser']['user_type'] == 1) && ($_COOKIE['redirect_page'] == 'subscription')) {
                    setcookie('redirect_page', '', time() - 3600);
                    $this->redirect(PROTOCOL . $seoArr[0] . "." . DOMAIN . 'users/subscription');
                    exit;
                }
                if ($_COOKIE['HELP'] == 1) {
                    //setcookie('HELP', 0, $cookieTime, '/', DOMAIN_COOKIE, false, false);
                    //$this->redirect(PROTOCOL.$seoArr[0].".".DOMAIN."easycases/help");
                    // $this->redirect(PROTOCOL . $seoArr[0] . "." . DOMAIN . "help");
                }
						/** Redirect to getting started ganttchat or resource availability **/
						if( isset($_COOKIE['RURL']) && !empty($_COOKIE['RURL'])){
								$rurl = $_COOKIE['RURL'];
								unset($_COOKIE['RURL']);
								setcookie('RURL', '', -365, '/', DOMAIN_COOKIE, false, false);
								$this->redirect($rurl);exit;
						}
						/* End */
                if ($_COOKIE['CK_EMAIL_NOTIFICATION'] == 1) {
                    setcookie('CK_EMAIL_NOTIFICATION', 0, $cookieTime, '/', DOMAIN_COOKIE, false, false);
                    //$this->redirect(PROTOCOL.$seoArr[0].".".DOMAIN."users/email_notification");
                    $this->redirect(PROTOCOL . $seoArr[0] . "." . DOMAIN . "users/email_notifications");
                }
                if (isset($this->request->data['case_details']) && $this->request->data['case_details']) {
						$this->loadModel('Project');
						if($this->Project->updateDtVisited(trim($this->request->data['case_details']),$this->Auth->user('id'))){
							$this->redirect($redirect . "dashboard#details/" . trim($this->request->data['case_details']));
						}else{
							$this->redirect($redirect . "dashboard#tasks/");
						}
                        exit;
                    }
					if (isset($this->request->data['getting_started_lgn']) && $this->request->data['getting_started_lgn']) {
                        $this->redirect($redirect . "getting_started/");
                    exit;
                }
                    if (!empty($this->params->query('project_url'))) {
                        $project_url = '?project_url=' . $this->params->query('project_url');
                    $this->redirect(PROTOCOL . $seoArr[0] . "." . DOMAIN . "mydashboard".$project_url);
                    exit;
                }
                if (isset($this->request->data['User']['project']) && isset($this->request->data['User']['case'])) {
                    $this->redirect($redirect . "dashboard#details/" . $this->request->data['User']['case']);
                } elseif (isset($this->request->data['User']['project'])) {
                    $this->redirect($redirect . "dashboard/?project=" . $this->request->data['User']['project']);
                } elseif (isset($this->request->data['User']['file']) && trim($this->request->data['User']['file'])) {
                    @$files = trim($this->request->data['User']['file']);
                    $fext = strtolower(substr(strrchr($files, "."), 1));
                    $extList = array("jpg", "jpeg", "png", "tif", "gif", "bmp", "thm");
                    setcookie("REQUESTED_FILE", @$files, COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
                } elseif ($update_email_redirect) {
                    $this->redirect(HTTP_APP . "users/profile");
                }
                $this->redirect($redirect);
            } else {
                $this->Session->write("SES_EMAIL", $this->request->data['User']['email']);
                //$this->Session->write("LOGIN_ERROR","Email or Password is invalid!");
                $this->Session->setFlash("Email or Password is invalid!", 'default', array('class' => 'error'));
                $_SESSION['GOOGLE_USER_INFO'] = $google_user_info;
                if (CHECK_DOMAIN && CHECK_DOMAIN == "www") {
                    $this->redirect(HTTP_APP . "users/login");
                } else {
                    if (!$direct_login) {
                        $this->redirect(HTTP_ROOT . "users/signup");
                    }
                }
            }
        }
        if (isset($demo) && $demo == "demo") {
            $this->set("ses_email", "hello@orangescrum.com");
            $this->set("ses_pass", "hello123");
        }
        if (isset($demo) && $demo != "demo") {
            if (strstr($demo, '___')) {
                $t_demo = explode('___', $demo);
                $upd_user = $this->User->find('first', array('conditions' => array('User.update_random' => $t_demo[0])));
                if ($upd_user) {
                    $t_emal = $upd_user['User']['email'];
                    if ($t_demo[1] == "NOT_UPDATE") {
                        $this->set("update_email_message", '<span style="color:red">"' . $t_emal . '" email already exists!.</span>');
                    } else {
                        $upd_user['User']['update_random'] = '';
                        $this->User->save($upd_user);
                        $this->set("update_email_message", '<span style="color:green">Now you can login using "' . $t_emal . '"</span>');
                    }
                }
            }
        }
        //echo "login";
        //exit;
        $Company = ClassRegistry::init('Company');
        //$Company = ClassRegistry::init('Company');
        $Company->recursive = -1;
        $company = $Company->find('first', array('conditions' => array('Company.is_active' => 1, 'Company.seo_url' => CHECK_DOMAIN)));

        $this->set("company", $company);
        /* }
          else if($IsBetaUser == 1 && $IsBetaApproved == 0)
          {
          $this->Session->write("LOGIN_ERROR","Your beta user subscription is not approved yet.");
          } */
    }

    function lunchuser() {
        if (isset($_GET['sig']) && trim($_GET['sig'])) {
            //$User = ClassRegistry::init('User');
            //$User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
            $userLogRec = $this->User->find('first', array(
                'conditions' => array(
                    'User.sig' => $_GET['sig']
                ),
                'fields' => 'User.id'
                    )
            );
            if ($userLogRec && count($userLogRec)) {
                $this->Session->write('Auth.User', $userLogRec['User']);
                $this->Auth->login();

                //$this->User->id = $this->Auth->user('id');
                //$this->User->saveField('sig', '');
            }
        }

        $this->redirect(HTTP_ROOT . 'dashboard');
    }

         // It will check whether the current email id is already present in the db or not
        function checkemail(){
            if ($this->request->is('ajax')) {
                $this->layout = 'ajax';
            }  
        $is_exist = $this->User->find('first', array('conditions' => array('User.email' => trim($this->request->data['email']))));
        if($is_exist){
            $msg['status'] = "failed";
            $existEmail= base64_encode(trim($this->request->data['email'])); 
            $msg['existEmail'] = $existEmail;            
           echo json_encode($msg);                             
        } else {
            $msg['status'] ="success";
            echo json_encode($msg); 
                  }                 
            exit;
        }
        //deb func add
/** Function to check whether a skill to add is valid & already exist or not in the same company
 * validateskill
 * author: Sangita
 * @return void
 */
function validateskill(){
    $jsonArr = array('status' => 'error');
    if (!empty($this->request->data['name'])) {      
        $this->loadModel("Skill");
			$jsonArr= $this->Skill->validateSkillData(trim($this->request->data['name']), SES_COMP);       
    }
    echo json_encode($jsonArr);
    exit;

}
/** Save Skills to user profile
 * saveUserSkill
 * author: Sangita - 29/06/2021
 * @return void
*/
function saveUserSkill(){  
    $this->layout = 'ajax';
    $skillId = $this->request->data['skillID'];
    $userId = $this->request->data['userId'];
if(!empty($skillId) ){   
    $skill = ClassRegistry::init('UserSkill');  
    $checkExistance = $skill->find('all', array('conditions' => array('UserSkill.user_id'=> $userId),'fields'=>array('UserSkill.skill_id')));
    $existingSkills = Hash::extract($checkExistance, "{n}.UserSkill.skill_id");    
    $uniqueSkillsToAdd = array_diff($skillId,$existingSkills);
    $skillsToRemove = array_diff($existingSkills, $skillId);
    
    if(!empty($skillsToRemove)){
        $skill->removeSkill($skillsToRemove,$userId);
    }
    $eLink = array();
    if(!empty($uniqueSkillsToAdd)){
    foreach($uniqueSkillsToAdd as $k=>$v){
        $arrl = array();
				if(!empty($v)){
        $arrl['user_id'] =  $userId;
        $arrl['skill_id'] =  $v;        
        }       
        $eLink[] = $arrl;        
    }
    $skill->saveAll($eLink);              
}  
}  
exit;
}

/** Fetch list of all skills 
 * getSkills
 * author: Sangita
 * @return void
 */
function getSkills(){
    $this->loadModel('Skill'); 
    $allSkills = $this->Skill->getSkillList(); 
    $userId= array();
    $userId[] = $this->request->data['id'];      
    $userSkills = $this->Skill->skillFetch($userId);
    $skillData = array_diff($allSkills,$userSkills);
    $arr['skills'] = $skillData;   
    echo json_encode($arr);
    exit;
}
    function profile($img = null, $img_user_id = null) {
        $json_arr = ''; //json array to save in the event log table 

            Cache::delete('prrofile_detl_'.$this->Auth->user('id'));
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
        }
        $photo = urldecode($img);
        if (defined('USE_S3') && USE_S3) {
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $info = $s3->getObjectInfo(BUCKET_NAME, DIR_USER_PHOTOS_S3_FOLDER . $photo);
        } else if ($photo && file_exists(DIR_USER_PHOTOS . $photo)) {
            $info = 1;
        }
        if ($photo && $info) {
            if (!empty($img_user_id)) {
                $checkPhoto = $this->User->find('count', array('conditions' => array('User.photo' => $photo, 'id' => $img_user_id)));
            } else {
                $checkPhoto = $this->User->find('count', array('conditions' => array('User.photo' => $photo, 'id' => SES_ID)));
            }
            if ($checkPhoto) {
                if (defined('USE_S3') && USE_S3) {
                    $s3->deleteObject(BUCKET_NAME, DIR_USER_PHOTOS_S3_FOLDER . $photo);
                } else {
                    unlink(DIR_USER_PHOTOS . $photo);
                }
                $User['id'] = SES_ID;
                $User['photo'] = $photo_name;
                $this->User->save($User);
                if ($this->request->is('ajax')) {
                    $msg['error'] = "Profile photo removed successfully";
                    print json_encode($msg);
                    exit;
                } else {
                        $this->Session->write("SUCCESS", __("Profile photo removed successfully",true));
                    $this->redirect(HTTP_ROOT . "users/profile");
                }
            }
            if ($this->request->is('ajax')) {
                $msg['error'] = "Image Not existed";
                print json_encode($msg);
                exit;
            }
        }
        if ($this->request->is('ajax')) {
            $userdata = $this->User->findById($this->data['User']['id']);
            $json_arr['user_id'] = $userdata['User']['id'];    //set user id for event log table
            $json_arr['old_email'] = $userdata['User']['email']; // set the old email for event log table
            $json_arr['old_name'] = $userdata['User']['name']; // set the old name for event log table
            $json_arr['old_last_name'] = $userdata['User']['last_name']; // set the old last name for event log table
            $json_arr['old_short_name'] = $userdata['User']['short_name']; // set the old short name for event log table
            $json_arr['old_timezone_id'] = $userdata['User']['timezone_id']; // set the old time zone for event log table
            $json_arr['old_photo'] = $userdata['User']['photo']; // set the old photo for event log table
        } else {
            $userdata = $this->User->findById(SES_ID);
        }
        $this->set('userdata', $userdata);

        $this->loadModel('TimezoneName');
        $timezones = $this->TimezoneName->find('all');
        $this->set('timezones', $timezones);
        $email_update = 0;

        if ((isset($this->request->data['User']) && $_SESSION['CSRFTOKEN'] == trim($this->request->data['User']['csrftoken'])) || (isset($this->data['User']['id']) && !empty($this->data['User']['id']))) {
				if(!$this->User->validateProfinpt($this->request->data)){
					if (!$this->request->is('ajax')) {
                        $this->Session->write("ERROR", __("Oops! something went wrong.",true));
                        $this->redirect(HTTP_ROOT . "users/profile");
                    } else {
                        $msg['error'] = __("Oops! something went wrong.",true);
                        print json_encode($msg);
                        exit;
                    }
				}
			if(isset($this->request->data['User']['is_dst'])){
				$this->request->data['User']['is_dst'] = 1;
			}else{
				$this->request->data['User']['is_dst'] = 0;
			}
            if (trim($this->request->data['User']['email']) == "") {
                if (!$this->request->is('ajax')) {
                        $this->Session->write("ERROR", __("Email cannot be left blank",true));
                    $this->redirect(HTTP_ROOT . "users/profile");
                } else {
                        $msg['error'] = __("Email cannot be left blank",true);
                    print json_encode($msg);
                    exit;
                }
            } else if (trim($this->request->data['User']['email']) != $userdata['User']['email']) {
                $is_exist = $this->User->find('first', array('conditions' => array('User.email' => trim($this->request->data['User']['email']))));
                $this->loadmodel('CompanyUser');
                $is_cmpinfo = $this->CompanyUser->find('count', array('conditions' => array('CompanyUser.user_id' => $is_exist['User']['id'])));
                if (!$is_cmpinfo) {
                    $this->User->id = $userdata['User']['id'];
                    if (!$this->request->is('ajax')) {
                        $userdata['User']['update_email'] = trim($this->request->data['User']['email']);
                    } else {
                        $userdata['User']['update_email'] = trim($this->request->data['User']['email']);
                        $userdata['User']['updated_by'] = 1;
                    }
                    $userdata['User']['update_random'] = $this->Format->generateUniqNumber();
                    $this->User->save($userdata);
                    $email_update = trim($this->request->data['User']['email']);
                    if ($this->request->is('ajax')) {
                        $json_arr['updated_email'] = $email_update; //set the updated email for event log table
                    }
                    $this->send_update_email_noti($userdata, trim($this->request->data['User']['email']));
                    $this->request->data['User']['email'] = $userdata['User']['email'];
                } else {
                    if (!$this->request->is('ajax')) {
                            $this->Session->write("ERROR", __("Oops! Email address already exists.",true));
                        $this->redirect(HTTP_ROOT . "users/profile");
                    } else {
                            $msg['error'] = __("Oops! Email address already exists.",true);
                        print json_encode($msg);
                        exit;
                    }
                }
            }
            $photo_name = '';
            if (isset($this->request->data['User']['photo'])) {
                $uid = (isset($this->request->data['User']['id']) && !empty($this->request->data['User']['id']))? : SES_ID;
                if (!empty($this->request->data['User']['photo']) && !empty($this->request->data['User']['exst_photo'])) {
                    $checkProfPhoto = $this->User->find('count', array('conditions' => array('User.photo' => $this->request->data['User']['exst_photo'], 'id' => $uid)));
                    if ($checkProfPhoto) {
                        if (defined('USE_S3') && USE_S3) {
                            $s3->deleteObject(BUCKET_NAME, DIR_USER_PHOTOS_S3_FOLDER . $this->request->data['User']['exst_photo']);
                        } else {
                            unlink(DIR_USER_PHOTOS . $this->request->data['User']['exst_photo']);
                        }
                    }
                }


                //$photo_name = $this->Format->uploadPhoto($this->request->data['User']['photo']['tmp_name'],$this->request->data['User']['photo']['name'],$this->request->data['User']['photo']['size'],DIR_USER_PHOTOS,SES_ID);
                //$photo_name = $this->Format->uploadPhoto($this->request->data['User']['photo']['tmp_name'],$this->request->data['User']['photo']['name'],$this->request->data['User']['photo']['size'],DIR_USER_PHOTOS,SES_ID,"profile_img");

                $photo_name = $this->Format->uploadProfilePhoto($this->request->data['User']['photo'], DIR_USER_PHOTOS);


                if ($photo_name == "ext") {
                    if (!$this->request->is('ajax')) {
                            $this->Session->write("ERROR", __("Oops! Invalid file format! The formats supported are gif, jpg, jpeg & png.",true));
                        $this->redirect(HTTP_ROOT . "users/profile");
                    } else {
                            $msg['error'] = __("Oops! Invalid file format! The formats supported are gif, jpg, jpeg & png.",true);
                        print json_encode($msg);
                        exit;
                    }
                } elseif ($photo_name == "size") {
                    if (!$this->request->is('ajax')) {
                            $this->Session->write("ERROR", __("Profile photo size cannot excceed 1mb",true));
                        $this->redirect(HTTP_ROOT . "users/profile");
                    } else {
                            $msg['error'] = __("Profile photo size cannot excceed 1mb",true);
                        print json_encode($msg);
                        exit;
                    }
                }
            }
            if (trim($this->request->data['User']['name']) == "") {
                if (!$this->request->is('ajax')) {
                        $this->Session->write("ERROR", __("Name cannot be left blank",true));
                    $this->redirect(HTTP_ROOT . "users/profile");
                } else {
                        $msg['error'] = __("Name cannot be left blank",true);
                    print json_encode($msg);
                    exit;
                }
            } else {

					if (isset($this->request->data['User']['phone']) && strtolower(trim($this->request->data['User']['phone'])) == 'na') {
						$this->request->data['User']['phone'] = 0;
					}
                if (!isset($this->request->data['User']['id']) || empty($this->request->data['User']['id'])) {
                    $this->request->data['User']['id'] = SES_ID;
                }

                if (empty($this->request->data['User']['photo']) && !empty($this->request->data['User']['exst_photo'])) {
                    $this->request->data['User']['photo'] = $this->request->data['User']['exst_photo'];
                } else {
                    $this->request->data['User']['photo'] = $photo_name;
                }
                $this->request->data['User']['name'] = trim($this->request->data['User']['name']);
					if(isset($this->request->data['User']['password'])){
						unset($this->request->data['User']['password']);
					}
                $this->User->save($this->request->data);

                if ($this->request->data['User']['timezone_id'] != $_COOKIE['USERTZ'] && !$this->request->is('ajax')) {

                    $this->loadModel('Timezone');
                    $timezn = $this->Timezone->find('first', array('conditions' => array('Timezone.id' => $this->request->data['User']['timezone_id']), 'fields' => array('Timezone.gmt_offset', 'Timezone.dst_offset', 'Timezone.code')));
                    setcookie("USERTZ", '', time() - 3600, '/', DOMAIN_COOKIE, false, false);

                    setcookie("USERTZ", $this->request->data['User']['timezone_id'], COOKIE_TIME, '/', DOMAIN_COOKIE, false, false);
                    $auth_user = $this->Auth->user();
                    $auth_user['timezone_id'] = $this->request->data['User']['timezone_id'];
                    $this->Session->write('Auth.User', $auth_user);
                }
                if (!empty($json_arr) && isset($this->request->data['User']) && !empty($this->request->data['User']) && SES_ID != $json_arr['user_id']) {
                    $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 28);
                    $to = $json_arr['old_email'];
                    $Name = $this->request->data['User']['name'];
                    $ut = $this->Auth->user('name');
                    if (empty($ut)) {
                        $this->User->id = SES_ID;
                        $ut = $this->User->field('name');
                    }
                    $subject = "Orangescrum profile information changed by $ut";
                    $this->Email->delivery = 'smtp';
                    $this->Email->to = $to;
                    $this->Email->subject = $subject;
                    $this->Email->from = FROM_EMAIL;
                    $this->Email->template = 'profile_change';
                    $this->Email->sendAs = 'html';
                    $this->set('oldInfo', $json_arr);
                    $this->set('ut', $ut);
                    $this->set('newInfo', $this->request->data['User']);
                    //pr($this->Email);exit;
						$UserInvitation = ClassRegistry::init('UserInvitation');
						$ui = $UserInvitation->find('first', array('conditions' => array('UserInvitation.user_id' => $json_arr['user_id'],'UserInvitation.company_id' => SES_COMP)));
						if($ui){
							$this->set('qstr',$ui['UserInvitation']['qstr']);
						}
                    try {
						if(defined("PHPMAILER") && PHPMAILER == 1){
							$this->Email->set_variables = $this->render('/Emails/html/profile_change',false);
							$this->PhpMailer->sendPhpMailerTemplate($this->Email);
						}else{
                        $this->Sendgrid->sendgridsmtp($this->Email);
						}
                    } Catch (Exception $e) {
                        
                    }
                }

                if (!$this->request->is('ajax')) {
                    if ($email_update) {
								$this->Session->write("SUCCESS", "Profile updated successfully.<br />A confirmation link has been sent to '{$email_update}'. Please confirm email to change email address.");
                    } else {
                               // Configure::write('Config.language', $this->request->data['User']['language']);
                                $this->Session->write('Config.language', $this->request->data['User']['language']);
                                $this->Session->write("SUCCESS", __("Profile updated successfully",true));
                    }
                    $this->redirect(HTTP_ROOT . "users/profile");
                } else {
                    $msg['error'] = ($email_update) ? "Profile updated successfully.<br />A confirmation link has been sent to '{$email_update}'." : "Profile updated successfully";
                    $msg['close'] = 1;
                    print json_encode($msg);
                    exit;
                }
            }
        } else if (isset($this->request->data['User'])) {
                print __("You are not authorized to do this operation.",true);
            exit;
        }
        $Company = ClassRegistry::init('Company');
        $Company->recursive = -1;
        $getCompany = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP)));
        $this->set('getCompany', $getCompany);
		$this->loadMOdel('Language');
        $this->set('languages', $this->Language->getAllLanguage());
		
    }

    function emailUpdate($qstr = null) {
        if (isset($qstr) && $qstr) {
            $UserData = $this->User->find('first', array('conditions' => array('User.update_random' => $qstr)));
            if ($UserData && $UserData['User']['update_email']) {
                $user_email = $this->User->find('first', array('conditions' => array('User.email' => $UserData['User']['update_email'])));
                if ($user_email) {
                    $this->logout('emailUpdate', $qstr . '___NOT_UPDATE');
                    $this->redirect(HTTP_APP . 'users/login/' . $qstr . '___NOT_UPDATE');
                } else {
                    $this->logout('emailUpdate', $qstr . '___UPDATE');
                    $UserData['User']['email'] = $UserData['User']['update_email'];
                    $UserData['User']['update_email'] = '';
                    $UserData['User']['verify_string'] = '';
                    $UserData['User']['updated_by'] = 0;
                    $this->User->save($UserData);

                    $this->loadModel('CompanyUser');
                    $this->CompanyUser->updateUserPerm(0, $UserData['User']['id'], 1);

                    $this->redirect(HTTP_APP . 'users/login/' . $qstr . '___UPDATE');
                }
            } else {
                $this->redirect(HTTP_APP . 'users/login/');
            }
        }
        $this->redirect(HTTP_APP . 'users/login/');
    }

    function send_update_email_noti($user = null, $upd_email) {
        if ($user) {
            $qstr = $user['User']['update_random'];
            $to = $upd_email;
            $Name = $user['User']['name'];
            $subject = "Orangescrum Login Email ID Confirmation";
            $this->Email->delivery = 'smtp';
            $this->Email->to = $to;
            $this->Email->subject = $subject;
            $this->Email->from = FROM_EMAIL;
            $this->Email->template = 'update_email';
            $this->Email->sendAs = 'html';
            $this->set('Name', ucfirst($Name));
            $this->set('qstr', $qstr);
            try {
				if(defined("PHPMAILER") && PHPMAILER == 1){
					$this->Email->set_variables = $this->render('/Emails/html/update_email',false);
					$this->PhpMailer->sendPhpMailerTemplate($this->Email);
				}else{
                $this->Sendgrid->sendgridsmtp($this->Email);
				}
            } Catch (Exception $e) {
                
            }
        }
    }

    function checkToken() {
        $this->layout = 'ajax';
        if ($this->request->data['ajax']) {
            echo json_encode(array('token' => $_SESSION['CSRFTOKEN']));
            exit;
        } else {
            print "You are not authorized to do this operation.";
            exit;
        }
    }

    function changepassword($img = null) {
        if (isset($this->request->data['User']) && $this->request->data['User']['changepass'] == 1 && $_SESSION['CSRFTOKEN'] == trim($this->request->data['User']['csrftoken'])) {
            if ($this->request->data['submit_Pass'] == 'Change') {
                if (trim($this->request->data['User']['old_pass']) == "") {
                        $this->Session->write("ERROR", __("Old password cannot be left blank!",true));
                    $this->redirect(HTTP_ROOT . "users/changepassword");
                }
            }
            if ($this->request->data['User']['old_pass']) {
                $passwordArr = $this->User->find('first', array('conditions' => array('id' => SES_ID), 'fields' => array('password')));
                if ($passwordArr['User']['password'] != md5($this->request->data['User']['old_pass'])) {
                        $this->Session->write("ERROR", __("Please enter correct old password.",true));
                    $this->redirect(HTTP_ROOT . "users/changepassword");
                }
                if (trim($this->request->data['User']['pas_new']) == "") {
                        $this->Session->write("ERROR", __("New password cannot be left blank!",true));
                    $this->redirect(HTTP_ROOT . "users/changepassword");
                }
                if (trim($this->request->data['User']['pas_retype']) == "") {
                        $this->Session->write("ERROR", __("Re-type password cannot be left blank!",true));
                    $this->redirect(HTTP_ROOT . "users/changepassword");
                }
                if ($this->request->data['User']['pas_new'] != $this->request->data['User']['pas_retype']) {
                        $this->Session->write("ERROR", __("Re-type password do not match!",true));
                    $this->redirect(HTTP_ROOT . "users/changepassword");
                }
            }

            if ($this->request->data) {
                    Cache::delete('prrofile_detl_'.SES_ID);
                $this->request->data['User']['id'] = SES_ID;
                $this->request->data['User']['password'] = md5($this->request->data['User']['pas_new']);

					$passArr = null;
					$passArr['User']['id'] = SES_ID;
					$passArr['User']['password'] = md5($this->request->data['User']['pas_new']);					
                //pr($this->request->data); exit;
					try{
                    if ($this->User->save($passArr)) {
                    $this->User->keepPassChk(SES_ID);
                }
                $this->loadModel('CompanyUser');
                $this->CompanyUser->updateUserPerm(SES_COMP, SES_ID, 2);

                    $this->Session->write("SUCCESS", __("Password changed successfully",true));
					} Catch (Exception $e) {
						$this->Session->write("ERROR", __("We are sorry! This operation is completed. Please try once again.",true));
					}
                $this->redirect(HTTP_ROOT . "users/changepassword");
            }
        } else if (isset($this->request->data['User']) && $this->request->data['User']['changepass'] == 1) {
                print __("You are not authorized to do this operation.",true);
            exit;
        }
    }

    function logout($id = '', $qsrt = null) {
            $this->Session->write('SUB_ERROR', '');
        if (stristr($_SERVER['SERVER_NAME'], "orangescrum.com")) {
            //Save last logout date into ledatracker
            $this->Format->SaveLoguotSessionCURL($this->Auth->user('id'), GMT_DATETIME);
        }
            if($this->Auth->user('id')){
                Cache::delete('prrofile_detl_'.$this->Auth->user('id'));
            }
        $this->Session->write('Auth.User.id', '');

        unset($_SESSION['GOOGLE_USER_INFO']);
        unset($_SESSION['user_last_login']);
        if (isset($_SESSION['Notification'])) {
            unset($_SESSION['Notification']);
        }
        $companyId = $_COOKIE['SES_COMP'];
        $userId = SES_ID;

						setcookie('IS_MOB_DETECT', '', -1, '/', DOMAIN_COOKIE, false, false);	
        setcookie('helpdesk_uniq_agent', '-1', time() + 60 * 60 * 24 * 30 * 12, '/', DOMAIN_COOKIE, false, false);
        setcookie('USER_UNIQ', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('USERTYP', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('USERTZ', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('REMEMBER', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('FIRST_LOGIN_1', '', -1, '/', DOMAIN_COOKIE, false, false);

        setcookie('SES_COMP', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('SES_TYPE', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('SES_TZ', '', -1, '/', DOMAIN_COOKIE, false, false);

        setcookie('is_osadmin', '', -1, '/', DOMAIN_COOKIE, false, false);
        setcookie('REF_URL', '', -1, '/', DOMAIN_COOKIE, false, false);

        $cookie = "";
        $this->Cookie->write('Auth.User', $cookie, '-1 year');

        if (SES_ID && !$qsrt) {
            $this->User->id = SES_ID;
            $this->User->saveField('dt_last_logout', GMT_DATETIME);
            $this->User->saveField('is_online', 0);
            if ($this->isiPad() && HTTP_ROOT != HTTP_APP) {
                $retval = $this->Auth->logout();
                $this->redirect(HTTP_APP . 'users/logout');
                exit;
            }
        }

        $retval = $this->Auth->logout();
        if ($retval) {
            $addon_price = Configure::read('AUTOMATE_ADDON_NAMES');
            $addon_nams = Configure::read('AUTOMATE_ADDON');
            if ($id) {
                if ($id == 'emailUpdate') {
                    return true;
                } else if (array_key_exists($id, $addon_nams)) {
                    $this->redirect(HTTP_ROOT . 'community_addon_download?addon=' . $id);
                    exit;
                } else if ($id == 'community_installation_support') {
                    $this->redirect(HTTP_ROOT . 'users/community_installation_support');
                    exit;
                } else {
                    $this->redirect(HTTP_ROOT . 'users/login');
                    exit;
                }
            } else {
                $this->redirect(HTTP_HOME);
                exit;
            }
        }
    }

    function ajax_activity() {
        $this->layout = 'ajax';
        $limit1 = $this->params->data['limit1'];
        $limit2 = $this->params->data['limit2'];
        $project_id = $this->params->data['projid'];
        if ($project_id == 'all') {
            $cond = '';
        } else {
            $cond = "AND `Project`.`uniq_id` = '" . $project_id . "'";
        }

            if(!$this->Format->isAllowed('View All Task',$roleAccess)){
                $cond .= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.") ";
            }
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }

        $sql = "SELECT SQL_CALC_FOUND_ROWS `Easycase`.*,DATE_FORMAT(Easycase.actual_dt_created,'%d%m%Y') AS ddate ,`User`.id,`User`.name,`User`.short_name,`User`.photo,`Project`.id,`Project`.uniq_id,`Project`.name FROM `easycases` AS `Easycase` inner JOIN users AS `User` ON (`Easycase`.`user_id` = `User`.`id`) inner JOIN projects AS `Project` ON (`Easycase`.`project_id` = `Project`.`id`) inner JOIN project_users AS `ProjectUser` ON (`Easycase`.`project_id` = `ProjectUser`.`project_id` AND `ProjectUser`.`user_id` = '" . SES_ID . "' AND `ProjectUser`.`company_id` = '" . SES_COMP . "') WHERE Project.isactive='1' AND " . $clt_sql . " AND Easycase.isactive='1' $cond ORDER BY Easycase.actual_dt_created DESC LIMIT $limit1,$limit2";
        $activity = $this->User->query($sql);
        $tot = $this->User->query("SELECT FOUND_ROWS() as total");

        $total = $tot[0][0]['total'];

            /*$parent_task_id = array_filter(Hash::combine($activity, '{n}.Easycase.id', '{n}.Easycase.parent_task_id'));
            $related_tasks = !empty($parent_task_id) ? $this->Easycase->getSubTasks($parent_task_id) : array();*/
			$related_tasks = array();

        //This section is meant for json loading.
        //Load the helpers
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
        $csq = $view->loadHelper('Casequery');
        $fmt = $view->loadHelper('Format');

        if ($total != 0) {
            $frmtActivity['activity'] = array();
                $frmtActivity = $this->User->formatActivities($activity, $total, $fmt, $dt, $tz, $csq, $related_tasks,1);
            //Making one array to send in json format.
            $lastDate = '';
            $repeatDate = $frmtActivity['activity']['0']['Easycase']['lastDate'];
            $ajax_activity['activity'] = $frmtActivity['activity'];
            $ajax_activity['total'] = $frmtActivity['total'];
        } else {
            $ajax_activity['activity'] = "";
            $ajax_activity['total'] = $total;
        }
        $this->set('ajax_activity', json_encode($ajax_activity));
            $this->set('related_tasks', $related_tasks);
        //End   
    }

    function activity_pichart() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
            $this->loadModel('Project');
        $project_id = $this->params->data['pjid'];
            $project_sts_id = 0;
        $cond = "";
        if ($project_id == 'all') {
            $cond = '';
        } else {
                $proj = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $project_id), 'fields' => array('Project.id', 'Project.uniq_id','Project.status_group_id')));
                $cond = "AND `project_id` = '" . $proj['Project']['id'] . "'";
				$project_sts_id = $proj['Project']['status_group_id'];
        }

        $color_arr = array(1 => '#AE432E', 2 => '#244F7A', 3 => '#77AB13', 4 => '#244F7A', 5 => '#EF6807');
            $legend_arr = array(1 => __('New',true), 2 => __('Opened',true), 3 => __('Closed',true), 4 => __('Start',true), 5 => __('Resolved',true));

        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((client_status = " . $this->Auth->user('is_client') . " AND user_id = " . $this->Auth->user('id') . ") OR client_status != " . $this->Auth->user('is_client') . ")";
        }

			if ($project_id == 'all') {
				$sql = "SELECT count(*) AS cnt,if(type_id=10,10,legend) AS legend FROM easycases WHERE project_id !=0 " . $cond . " AND legend != 0 AND istype='1' AND " . $clt_sql . " GROUP BY if(type_id=10,10,legend) ORDER BY FIELD (legend,1,6,2,4,5,3)";
			}else{
				if($project_sts_id){
					$sql = "SELECT count(*) AS cnt,if(type_id=10,10,custom_status_id) AS custom_legend FROM easycases WHERE project_id !=0 " . $cond . " AND legend != 0 AND istype='1' AND " . $clt_sql . " GROUP BY if(type_id=10,10,custom_legend) ORDER BY custom_legend DESC";
				}else{
        $sql = "SELECT count(*) AS cnt,if(type_id=10,10,legend) AS legend FROM easycases WHERE project_id !=0 " . $cond . " AND legend != 0 AND istype='1' AND " . $clt_sql . " GROUP BY if(type_id=10,10,legend) ORDER BY FIELD (legend,1,6,2,4,5,3)";
				}
			}
        // print $sql;exit;
        $easycase = $this->Easycase->query($sql);

        $wip = 0;
        $new = 0;
        $clos = 0;
        $upd = 0;
		$cnt_array = array();
        if (!empty($easycase)) {
				$csts_arr = array();
				$piearr = array();
				//custom status ref for other pages	
				if(isset($easycase[0][0]['custom_legend'])){
					$i = 0;
					$sts_ids = array_filter(array_unique(Hash::extract($easycase, '{n}.0.custom_legend')));
					if($sts_ids){
						$Csts = ClassRegistry::init('CustomStatus');
						$csts_arr = $Csts->find('all',array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
						if($csts_arr){
							$csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
						}
					}
					$cnt_array = Hash::extract($easycase, '{n}.0.cnt');
					$tot = !empty($cnt_array) ? array_sum($cnt_array) : 0;
					foreach ($easycase as $k => $v) {
						$piearr[$i]['name'] = $csts_arr[$v[0]['custom_legend']]['name'];
						$piearr[$i]['y'] = (float) number_format(($v[0]['cnt'] / $tot) * 100, 2);
						$piearr[$i]['color'] = '#'.$csts_arr[$v[0]['custom_legend']]['color'];
						$i++;
					}					
				}else{				
            foreach ($easycase as $k => $v) {
                $cnt_array[] = $v[0]['cnt'];
                if ($v[0]['legend'] == 2 || $v[0]['legend'] == 4) {
                    $wip = $wip + $v[0]['cnt'];
                }
                if ($v[0]['legend'] == 1) { //|| $v['easycases']['legend'] == 6
                    $new = $new + $v[0]['cnt'];
                }
                if ($v[0]['legend'] == 3) {
                    $clos = $clos + $v[0]['cnt'];
                }
                if ($v[0]['legend'] == 10) {
                    $upd = $upd + $v[0]['cnt'];
                }
            }
            $tot = !empty($cnt_array) ? array_sum($cnt_array) : 0;
            $i = 0;
            $add = 0;
            $clos1 = 0;
            $wipadd = 0;
            $upd1 = 0;
            $piearr = array();

            foreach ($easycase as $k => $v) {
                if ($v[0]['legend'] == 2 || $v[0]['legend'] == 4) {
                    if ($wipadd == 0) {
                            $piearr[$i]['name'] = __('In Progress',true);
                        $piearr[$i]['y'] = (float) number_format(($wip / $tot) * 100, 2);
                        $piearr[$i]['color'] = $color_arr[$v[0]['legend']];
                        $i++;
                        $wipadd++;
                    }
                } else if ($v[0]['legend'] == 1) { //|| $v['easycases']['legend'] == 6
                    if ($add == 0) {
                            $piearr[$i]['name'] = __('New',true);
                        $piearr[$i]['y'] = (float) number_format(($new / $tot) * 100, 2);
                        $piearr[$i]['color'] = $color_arr[$v[0]['legend']];
                        $i++;
                        $add++;
                    }
                } else if ($v[0]['legend'] == 3) {
                    if ($clos1 == 0) {
                            $piearr[$i]['name'] = __('Close',true);
                        $piearr[$i]['y'] = (float) number_format(($clos / $tot) * 100, 2);
                        $piearr[$i]['color'] = $color_arr[$v[0]['legend']];
                        $i++;
                        $clos1++;
                    }
                } else if ($v[0]['legend'] == 10) {
                    if ($upd1 == 0) {
                            $piearr[$i]['name'] = __('Update',true);
                        $piearr[$i]['y'] = (float) number_format(($upd / $tot) * 100, 2);
                        $piearr[$i]['color'] = $color_arr[$v[0]['legend']];
                        $i++;
                        $upd1++;
                    }
                } else {
                    $piearr[$i]['name'] = $legend_arr[$v[0]['legend']];
                    $piearr[$i]['y'] = (float) number_format(($v[0]['cnt'] / $tot) * 100, 2);
                    $piearr[$i]['color'] = $color_arr[$v[0]['legend']];
                    $i++;
                }
            }
				}
            $this->set('piearr', json_encode($piearr));
        }
        print json_encode($piearr);
        exit;
    }

    function ajax_overdue() {
        $this->layout = 'ajax';
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $fmt = $view->loadHelper('Format');
        $today = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
        $this->set('today', $today);
        if (!empty($this->params->data['projid'])) {
            $getOverdue = $this->User->getOverdue($this->params->data['projid'], $today, $this->params->data['type']);
            $this->set('overdue', $getOverdue);
        }
        if (isset($this->params->data['angular'])) {
            $arr[0] = $today;
            foreach ($getOverdue as $k => $v) {
                $formated_date = "";
                $b = explode(" ", $v['Easycase']['due_date']);
                $a = explode("-", $b[0]);
                $formated_date .= date("M ", mktime(0, 0, 0, $a[1], $a[2], $a[0]));
                $b = explode(" ", $v['Easycase']['due_date']);
                $a = explode("-", $b[0]);
                $formated_date .= date("d ", mktime(0, 0, 0, $a[1], $a[2], $a[0]));
                $getOverdue[$k]['Easycase']['formated_due_date'] = $formated_date;
                $getOverdue[$k]['Easycase']['title'] = $fmt->formatTitle($v['Easycase']['title']);

                $date1 = $v['Easycase']['due_date'];
                $date2 = $today;
                $diff = abs(strtotime($date2) - strtotime($date1));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $getOverdue[$k]['Easycase']['late'] = $days;
            }
            $arr[1] = $getOverdue;
            print json_encode($arr);
            exit;
        }
    }

    function ajax_upcoming() {
        $this->layout = 'ajax';
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $fmt = $view->loadHelper('Format');
        $today = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
        $this->set('today', $today);
        if (!empty($this->params->data['projid'])) {
            $getUpcoming = $this->User->getUpcoming($this->params->data['projid'], $today, $this->params->data['type']);
            $this->set('nextdue', $getUpcoming);
        }

        if (isset($this->params->data['angular'])) {
            $arr[0] = $today;
            foreach ($getUpcoming as $k => $v) {
                $formated_date = "";
                $b = explode(" ", $v['Easycase']['due_date']);
                $a = explode("-", $b[0]);
                $formated_date .= date("M ", mktime(0, 0, 0, $a[1], $a[2], $a[0]));
                $b = explode(" ", $v['Easycase']['due_date']);
                $a = explode("-", $b[0]);
                $formated_date .= date("d ", mktime(0, 0, 0, $a[1], $a[2], $a[0]));
                $getUpcoming[$k]['Easycase']['formated_due_date'] = $formated_date;
                $getUpcoming[$k]['Easycase']['title'] = $fmt->formatTitle($v['Easycase']['title']);

                $date1 = $v['Easycase']['due_date'];
                $date2 = $today;
                $diff = abs(strtotime($date2) - strtotime($date1));
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
                $getUpcoming[$k]['Easycase']['late'] = $days;
            }
            $arr[1] = $getUpcoming;
            print json_encode($arr);
            exit;
        }
    }

    function ajax_member() {
        $this->layout = 'ajax';
        $this->loadModel('ProjectUser');
        $this->ProjectUser->recursive = -1;
        if (!empty($this->params->data['projid'])) {
            $qry = '';
            if ($this->params->data['projid'] == 'all') {
                $getAllProj = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'ProjectUser.project_id'));
                if (!empty($getAllProj)) {
                    $projIds = array();
                    foreach ($getAllProj as $pj) {
                        $projIds[] = $pj['ProjectUser']['project_id'];
                    }
                    $getUsers = array();
                    if (count($projIds)) {
                        $pjids = "(" . implode(",", $projIds) . ")";
                        $qry = "AND ProjectUser.project_id IN " . $pjids . "";
                    }
                } else {
                    $qry = "AND ProjectUser.user_id = " . SES_ID . "";
                }
            } else {
                $pjids = $this->params->data['projid'];
                $qry = "AND ProjectUser.project_id = " . $pjids . "";
            }
            $getUsers = "SELECT DISTINCT User.id, User.name, User.email, User.istype,User.short_name,User.photo FROM users as User,project_users as ProjectUser,company_users as CompanyUser WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' " . $qry . " AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.short_name ASC";

            $getUsers = $this->ProjectUser->query($getUsers);
            $this->set('getUsers', $getUsers);
        }
    }

    function activity() {
        $this->redirect(HTTP_ROOT . "dashboard");
        die;

        $userdata = $this->User->findById(SES_ID);
        $this->set('userdata', $userdata);
    }

    function jquery_multi_autocomplete_data() {
        $this->layout = 'ajax';

        $uniqid = $_GET['project'];
        $search = $_GET['tag'];
        $quickMem = $this->Format->getMemebersEmail($uniqid, $search);
		$items = array();
        foreach ($quickMem as $mem) {
            $items[] = array("name" => $mem['User']['name'], "value" => $mem['User']['id'], "sname" => $mem['User']['short_name'], "photo" => $mem['User']['photo']);
        }

        print json_encode($items);
        exit;
    }

    function search_project_menu() {
        $this->layout = 'ajax';
        $page = $this->params->data['page']; //echo $page;
        $val = $this->params->data['val'];
        $pgname = isset($this->request->data['page_name']) ? $this->request->data['page_name'] : '';

        $filter = $this->request->data['filter']; //echo $filter;
        $qry = "";
        if ($filter == "delegateto") {
            $qry = " AND EasyCase.user_id=" . SES_ID . " AND EasyCase.assign_to!=0 AND EasyCase.assign_to!=" . SES_ID;
        } else if ($filter == "assigntome") {
            $qry = " AND ((EasyCase.assign_to=" . SES_ID . ") OR (EasyCase.assign_to=0 AND EasyCase.user_id=" . SES_ID . "))";
        } else if ($filter == "latest") {
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $qry = " AND EasyCase.dt_created > '" . $before . "' AND EasyCase.dt_created <= '" . GMT_DATETIME . "'";
        } else if ($filter == "files") {
            $qry = " AND EasyCase.format = '1'";
        } else {
            $qry = "";
        }
		$remove = array();
        if ($val) {
            //$cond = array('conditions'=>array('Project.name LIKE' => '%'.$val.'%','ProjectUser.user_id' => SES_ID,'Project.isactive' => 1,'Project.company_id'=>SES_COMP), 'fields' => array('DISTINCT  Project.uniq_id', 'Project.id','Project.name'));
				$remove[] = "'";
				//$remove[] = '"';


				$val = str_replace($remove, "", $val);
            $Project = ClassRegistry::init('Project');
            //$ProjectUser->unbindModel(array('belongsTo' => array('User')));
            //$allProjArr = $ProjectUser->find('all', $cond);
            //$allProjArr = $Project->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT Project.uniq_id,Project.id,Project.name FROM project_users as ProjectUser,projects as Project WHERE ProjectUser.project_id=Project.id AND Project.isactive='1' AND Project.company_id='".SES_COMP."' AND Project.name LIKE '%".$val."%' AND ProjectUser.user_id='".SES_ID."'");
                $allProjArr = $Project->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT Project.uniq_id,Project.id,Project.name,Project.project_methodology_id,(select count(EasyCase.id) from easycases as EasyCase where EasyCase.istype='1' AND EasyCase.isactive='1' AND ProjectUser.project_id=EasyCase.project_id  " . trim($qry) . ") as count FROM project_users as ProjectUser,projects as Project WHERE ProjectUser.project_id=Project.id AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' AND Project.name LIKE '%" . $val . "%' AND ProjectUser.user_id='" . SES_ID . "' ORDER BY Project.name LIKE '" . $val . "%' DESC");

            $query = "SELECT SQL_CALC_FOUND_ROWS DISTINCT Project.uniq_id,Project.id,Project.name FROM project_users as ProjectUser,projects as Project WHERE ProjectUser.project_id=Project.id AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' AND Project.name LIKE '%" . $val . "%' AND ProjectUser.user_id='" . SES_ID . "'";
            //echo "<br/>";
            //pr($allProjArr);

            $totcnt = $Project->query("SELECT FOUND_ROWS() as count");
            $countAll = $totcnt['0']['0']['count'];

            //$countAll = $ProjectUser->find('count', array('conditions'=>array('Project.name LIKE' => '%'.$val.'%','Project.isactive' => 1,'Project.company_id'=>SES_COMP), 'fields' => 'DISTINCT Project.id'));
        }
        $this->set('countAll', $countAll);
        $this->set('allProjArr', $allProjArr);
        $this->set('page', $page);
        $this->set('pgname', $pgname);
        $this->set('query', $query);
        $this->set('val', $val);
        $fres = 1;
        $this->set('fres', $fres);
        if ($val == "" || $countAll == 0) {
            $fres = 0;
            $this->set('fres', $fres);
        }
    }

    function project_listing() {
        $this->layout = 'ajax';
        $userid = $this->request->data['user_id'];
        $is_invite_user = (isset($this->request->data['is_invite_user']) && trim($this->request->data['is_invite_user'])) ? $this->request->data['is_invite_user'] : 0;

        $this->loadModel('ProjectUser');
        $qry = '';
        if (isset($this->params->data['name']) && trim($this->params->data['name'])) {
            $name = trim($this->params->data['name']);
            $qry = " AND projects.name LIKE '%$name%'";
        }

        if ($is_invite_user) {
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $inviteuser = $UserInvitation->query("SELECT user_invitations.project_id FROM user_invitations,users WHERE user_invitations.user_id IN (" . $userid . ") AND user_invitations.user_id = users.id AND user_invitations.company_id='" . SES_COMP . "' LIMIT 1");
            if (isset($inviteuser) && !empty($inviteuser['0']['user_invitations']['project_id'])) {
                $project_id = explode(",", $inviteuser['0']['user_invitations']['project_id']);
                if (isset($this->request->data['project_id']) && $this->request->data['project_id']) {
                    if (in_array($this->request->data['project_id'], $project_id)) {
                        unset($project_id[array_search($this->request->data['project_id'], $project_id)]);
                    }
                    $prjId = implode(",", $project_id);
                    $UserInvitation->query("Update user_invitations SET project_id='" . $prjId . "' WHERE user_id='" . $userid . "'");
                    echo "removed";
                    exit;
                }

                $qry1 = '';
                $cnt = 1;
                foreach ($project_id as $key => $value) {
                    if (count($project_id) == $cnt) {
                        $qry1 = $qry1 . "projects.id = '" . $value . "'";
                    } else {
                        $qry1 = $qry1 . "projects.id = '" . $value . "' OR ";
                    }
                    $cnt++;
                }
                $sql = "SELECT DISTINCT projects.id,projects.name,projects.short_name FROM projects WHERE projects.name != '' AND (" . $qry1 . ") AND projects.company_id='" . SES_COMP . "' " . $qry . " ORDER BY projects.name";
            } else {
                $sql = "SELECT DISTINCT projects.id,projects.name,projects.short_name FROM projects WHERE projects.name != '' AND projects.company_id='" . SES_COMP . "' " . $qry . " ORDER BY projects.name";
            }
            $project_list = $this->ProjectUser->query($sql);
        } else {
            if (isset($this->request->data['project_id']) && $this->request->data['project_id']) {
                $project_id = $this->request->data['project_id'];
                $ProjectUser = ClassRegistry::init('ProjectUser');
                $ProjectUser->unbindModel(array('belongsTo' => array('Project')));
                $ProjectUser->query("DELETE FROM project_users WHERE user_id='" . $userid . "' AND project_id='" . $project_id . "'");
                echo "removed";
                exit;
            }
            if (isset($this->request->data['comp_id']) && $this->request->data['comp_id']) {
                $comp_id = $this->request->data['comp_id'];
                $ProjectUser = ClassRegistry::init('ProjectUser');
                $ProjectUser->unbindModel(array('belongsTo' => array('Project')));
                $ProjectUser->query("DELETE FROM project_users WHERE user_id='" . $userid . "' AND company_id='" . $comp_id . "'");
                echo "removedAll";
                exit;
            }
            $project_list = $this->ProjectUser->query("SELECT DISTINCT projects.id,projects.name,projects.short_name,project_users.id,project_users.default_email,project_users.user_id FROM projects, project_users  WHERE  projects.id= project_users.project_id AND project_users.user_id=" . $userid . " AND project_users.company_id=" . SES_COMP . $qry . " ORDER BY projects.name");
        }

        $this->set('project_list', $project_list);
        $this->set('userid', $userid);
        //$this->set('count',$this->request->data['count']);
        $this->set('count', count($project_list));
        $this->set('is_invite_user', $is_invite_user);
    }

    function add_project() {
        $this->layout = 'ajax';
        $user_id = $this->request->data['uid'];
        if (isset($this->request->data['count']) && $this->request->data['count']) {
            $count1 = $this->request->data['count'];
        }
        $query = "";
        if (isset($this->request->data['name']) && trim($this->request->data['name'])) {
            $srchstr = addslashes(trim($this->request->data['name']));
            $query = "AND projects.name LIKE '%$srchstr%'";
        }
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $is_invite_user = (isset($this->request->data['is_invite_user']) && trim($this->request->data['is_invite_user'])) ? $this->request->data['is_invite_user'] : 0;
        if ($is_invite_user) {
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $inviteuser = $UserInvitation->query("SELECT user_invitations.project_id FROM user_invitations,users WHERE user_invitations.user_id IN (" . $user_id . ") AND user_invitations.user_id = users.id AND user_invitations.company_id='" . SES_COMP . "' LIMIT 1");
            if (isset($inviteuser) && !empty($inviteuser['0']['user_invitations']['project_id'])) {
                $project_id = explode(",", $inviteuser['0']['user_invitations']['project_id']);
                $qry = '1 ';
                $extqry = '';
                $cnt = 1;
                foreach ($project_id as $key => $value) {
                    $qry = $qry . " AND projects.id != '" . $value . "'";
                    if (count($project_id) == $cnt) {
                        $extqry = $extqry . "projects.id = '" . $value . "'";
                    } else {
                        $extqry = $extqry . "projects.id = '" . $value . "' OR ";
                    }
                    $cnt++;
                }
                $sql = "SELECT DISTINCT projects.id,projects.name,projects.short_name FROM projects WHERE projects.name != '' " . $query . " AND (" . $qry . ") AND projects.company_id='" . SES_COMP . "' ORDER BY projects.name";
                $extsql = "SELECT DISTINCT projects.id,projects.name,projects.short_name FROM projects WHERE " . $extqry . " AND projects.name != '' AND projects.company_id='" . SES_COMP . "' ORDER BY projects.name";
            } else {
                $sql = "SELECT DISTINCT projects.id,projects.name,projects.short_name FROM projects WHERE projects.name != '' " . $query . " AND projects.company_id='" . SES_COMP . "' ORDER BY projects.name";
                $extsql = "";
            }
            $project_name = $ProjectUser->query($sql);
            if (!empty($extsql)) {
                $exists_project_name = $ProjectUser->query($extsql);
            } else {
                $exists_project_name = array();
            }
        } else {
            $project_name = $ProjectUser->query("SELECT DISTINCT projects.id,projects.name,projects.short_name FROM projects WHERE projects.name != '' " . $query . " AND projects.id NOT IN (SELECT project_users.project_id FROM project_users,users  WHERE project_users.user_id=users.id AND project_users.user_id='" . $user_id . "') AND projects.company_id='" . SES_COMP . "' ORDER BY projects.name");
            $exists_project_name = $ProjectUser->query("SELECT DISTINCT projects.id,projects.name,projects.short_name FROM projects WHERE projects.name != '' AND projects.id IN (SELECT project_users.project_id FROM project_users,users  WHERE project_users.user_id=users.id AND project_users.user_id='" . $user_id . "') AND projects.company_id='" . SES_COMP . "' ORDER BY projects.name");
        }
        $prj_count = count($project_name);
        $this->set('project_name', $project_name);
        $this->set('prj_count', $prj_count);

        $exst_prj_count = count($exists_project_name);
        $this->set('exists_project_name', $exists_project_name);
        $this->set('exst_prj_count', $exst_prj_count);

        $this->set('usrid', $user_id);
        $this->set('is_invite_user', $is_invite_user);
        $this->set('count1', $count1);
        if (isset($this->request->data['choosen_proj_ids'])) {
            $selected_pids = trim($this->request->data['choosen_proj_ids']);
            if ($selected_pids != '') {
                $pids = explode(',', $selected_pids);
                $Project = ClassRegistry::init('Project');
                $Project->recursive = -1;
                $selected_pjids = $Project->find('list', array('conditions' => array('Project.id' => $pids), 'fields' => array('Project.id', 'Project.name')));
                if ($selected_pjids) {
                    $this->set('selected_pjids', $selected_pjids);
                }
            }
        }
    }

    function assign_prj() {
        $this->layout = 'ajax';
        $Company = ClassRegistry::init('Company');
        $comp = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('Company.name')));
        $userid = $this->request->data['userid'];
        $projectid = $this->request->data['projectid'];
        $is_invite_user = $this->request->data['is_invite_user'];
        if (intval($is_invite_user)) {
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $inviteuser = $UserInvitation->query("SELECT user_invitations.project_id FROM user_invitations,users WHERE user_invitations.user_id IN (" . $userid . ") AND user_invitations.user_id = users.id AND user_invitations.company_id='" . SES_COMP . "' LIMIT 1");
            $projectid = implode(",", $projectid);
            $projectid = trim($projectid, ',');			
            if (isset($inviteuser) && !empty($inviteuser['0']['user_invitations']['project_id'])) {
                $project_ids = $inviteuser['0']['user_invitations']['project_id'] . "," . $projectid;
            } else {
                $project_ids = $projectid;
            }
            $inviteusers = $UserInvitation->query("UPDATE user_invitations SET project_id='" . $project_ids . "' WHERE user_id IN (" . $userid . ") AND company_id='" . SES_COMP . "'");
            $project_ids_t = array_unique(explode(',', $project_ids));
			$userid = trim($userid,',');
			$userid_t = null;
			if(stristr($userid,',')){
				$userid_t = explode(',', $userid);
			}
            $ProjectUser = ClassRegistry::init('ProjectUser');
            $ProjectUser->recursive = -1;
            $getLastId = $ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
            $lastid = $getLastId[0][0]['maxid'];			
            if (count($project_ids_t)) {
                foreach ($project_ids_t as $pid) {
					if($userid_t){
						foreach ($userid_t as $uids) {
							$checkAvlMembr = $ProjectUser->find('first', array('conditions' => array('ProjectUser.user_id' => $uids, 'ProjectUser.project_id' => $pid), 'fields' => 'DISTINCT id'));
							if ($checkAvlMembr == 0) {
								$lastid++;
								$ProjectUser->query("INSERT INTO project_users SET id='" . $lastid . "',user_id=" . $uids . ",project_id=" . $pid . ",company_id='" . SES_COMP . "',dt_visited='" . GMT_DATETIME . "'");
							}
						}
					}else{						
						$checkAvlMembr = $ProjectUser->find('first', array('conditions' => array('ProjectUser.user_id' => $userid, 'ProjectUser.project_id' => $pid), 'fields' => 'DISTINCT id'));
						if ($checkAvlMembr == 0) {
							$lastid++;
							$ProjectUser->query("INSERT INTO project_users SET id='" . $lastid . "',user_id=" . $userid . ",project_id=" . $pid . ",company_id='" . SES_COMP . "',dt_visited='" . GMT_DATETIME . "'");
						}
					}
                }
            }
        } else {
            $ProjectUser = ClassRegistry::init('ProjectUser');
            $ProjectUser->recursive = -1;
            $getLastId = $ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
            $lastid = $getLastId[0][0]['maxid'];
            if (count($projectid)) {
                foreach ($projectid as $pid) {
                    $checkAvlMembr = $ProjectUser->find('first', array('conditions' => array('ProjectUser.user_id' => $userid, 'ProjectUser.project_id' => $pid), 'fields' => 'DISTINCT id'));
                    if ($checkAvlMembr == 0) {
                        $lastid++;
                        $ProjectUser->query("INSERT INTO project_users SET id='" . $lastid . "',user_id=" . $userid . ",project_id=" . $pid . ",company_id='" . SES_COMP . "',dt_visited='" . GMT_DATETIME . "'");
                    }
                }
            }
            $pjname = "";
            if (count($projectid)) {
                foreach ($projectid as $pid) {
                    $Project = ClassRegistry::init('Project');
                    $Project->recursive = -1;
                    $prjArr = $Project->find('first', array('conditions' => array('Project.id' => $pid), 'fields' => array('Project.name', 'Project.uniq_id')));

                    $projName = $prjArr['Project']['name'];
                    $uniq_id = $prjArr['Project']['uniq_id'];
                    $pjname = $pjname . ", " . $projName;
                }
                $pjnames = substr($pjname, 2);
            }
            if (count($projectid) > 1) {
                $uniq_id = 'all';
            }

			/* Send push notification to the user to whom the projects are assigned starts here */
					
				$allAsiisgnProjectNames = $pjnames;
				
				$getUserDetails = $this->User->query("SELECT `name` FROM `users` WHERE `id`='".$this->request->data['userid']."'");
				$userName = $getUserDetails[0]['users']['name'];
				
				$notifyAndAssignToMeUsers = array($this->request->data['userid']);
				$prjTitle = $postProject['Project']['name'];
				$notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
				
				$messageToSend = __("Project(s) '").$allAsiisgnProjectNames.__("' assigned to you.");
				$this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
				$this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);
				
			/* Send push notification to the user to whom the projects are assigned ends here */
            $this->generateMsgAndSendUsMail($pjnames, $userid, $uniq_id, $comp);
        }
        print json_encode(array("message" => "success"));
        exit;
    }


    function privacypolicy() {
    }

    function securities() {
    }


    function aboutus() {
        
    }

    function termsofservice() {
        
    }

        
        function site_map($tour = NULL) {            
    }

    function contactnow() {
        $this->layout = 'ajax';
        $response = "error";
        if ($this->request->data['email1'] && $this->request->data['js_captcha1'] && $this->request->data['hid_captcha1']) {

            $email = trim($this->request->data['email1']);
            $js_captcha = trim($this->request->data['js_captcha1']);
            $hid_captcha = trim($this->request->data['hid_captcha1']);

            if ($js_captcha == $hid_captcha) {
                if ($this->Format->validateEmail($email)) {
                    $sentAt = gmdate("m/d/Y g:i A");
                    $curdate = gmdate("Y-m-d H:i:s");
                    App::import('Helper', 'Tmzone');
                    $tmzone = new TmzoneHelper(new View(null));
                    $sentAt = $tmzone->GetDateTime(5, -8, 1, "P", $curdate, "datetime");
                    $sentAt = date('m/d/Y g:i A', strtotime($sentAt));
                    $to = SUPPORT_EMAIL;
                    $subject = "[Contact NOW on Orangescrum]";
                    $message = "<table cellpadding='0' cellspacing='0' align='left' width='100%'>

								" . EMAIL_HEADER . "
								<tr>

									<td align='left'>
										<table cellpadding='2' cellspacing='2' align='left'>

											<tr><td align='left' style='font-family:Arial;font-size:14px;'>Dear site administrator,</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;'>You're lucky today; An  User contacted you on Orangescrum.</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:5px;'><b>User's Email:</b> " . $email . "</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:5px;'><b>Hi, i am interested in Orangescrum.</td></tr>
											<tr><td align='left' style='font-family:Arial;font-size:14px;padding-top:5px;'><b>Sent at:</b> " . $sentAt . " PST</td></tr>
										</table>

									</td>
								</tr>
							</table>";
                    if ($this->Sendgrid->sendGridEmail(FROM_EMAIL, $to, $subject, $message, "Contact Now")) {
                        $response = "success";
                    }
                } else {
                    $response = "email_error";
                }
            }
        }
        echo $response;
        exit;
    }

    function ajax_totalcase() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $totcase = $this->Easycase->query("SELECT COUNT(id) AS count FROM easycases AS Easycase WHERE Easycase.title != '' AND Easycase.isactive='1' ");
        $count = "10" . $totcase['0']['0']['count'];
        $cnt = strlen($count);
        if ($cnt == "3") {
            $s = str_split($count);
            echo "<div class='bg_digit'>0</div><div class='comma_digit' >,</div><div class='bg_digit'>0</div><div class='bg_digit'>0</div><div class='bg_digit'>0</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[0]</div><div class='bg_digit'>$s[1]</div><div class='bg_digit'>$s[2]</div>";
        } else if ($cnt == "4") {
            $s = str_split($count);
            echo "<div class='bg_digit'>0</div><div class='comma_digit' >,</div><div class='bg_digit'>0</div><div class='bg_digit'>0</div><div class='bg_digit'>$s[0]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[1]</div><div class='bg_digit'>$s[2]</div><div class='bg_digit'>$s[3]</div>";
        } else if ($cnt == "5") {
            $s = str_split($count);
            echo "<div class='bg_digit'>0</div><div class='comma_digit' >,</div><div class='bg_digit'>0</div><div class='bg_digit'>$s[0]</div><div class='bg_digit'>$s[1]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[2]</div><div class='bg_digit'>$s[3]</div><div class='bg_digit'>$s[4]</div>";
        } else if ($cnt == "6") {
            $s = str_split($count);
            echo "<div class='bg_digit'>0</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[0]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[1]</div><div class='bg_digit'>$s[2]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[3]</div><div class='bg_digit'>$s[4]</div><div class='bg_digit'>$s[5]</div>";
        } else if ($cnt == "7") {
            $s = str_split($count);
            echo "<div class='bg_digit'>$s[0]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[1]</div><div class='bg_digit'>$s[2]</div><div class='bg_digit'>$s[3]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[4]</div><div class='bg_digit'>$s[5]</div><div class='bg_digit'>$s[6]</div>";
        } else if ($cnt == "8") {
            $s = str_split($count);
            echo "<div class='bg_digit'>$s[0]</div><div class='bg_digit'>$s[1]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[2]</div><div class='bg_digit'>$s[3]</div><div class='bg_digit'>$s[4]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[5]</div><div class='bg_digit'>$s[6]</div><div class='bg_digit'>$s[7]</div>";
        } else if ($cnt == "9") {
            $s = str_split($count);
            echo "<div class='bg_digit'>$s[0]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[1]</div><div class='bg_digit'>$s[2]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[3]</div><div class='bg_digit'>$s[4]</div><div class='bg_digit'>$s[5]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[6]</div><div class='bg_digit'>$s[7]</div><div class='bg_digit'>$s[8]</div>";
        } else if ($cnt == "10") {
            $s = str_split($count);
            echo "<div class='bg_digit'>$s[0]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[1]</div><div class='bg_digit'>$s[2]</div><div class='bg_digit'>$s[3]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[4]</div><div class='bg_digit'>$s[5]</div><div class='bg_digit'>$s[6]</div><div class='comma_digit' >,</div><div class='bg_digit'>$s[7]</div><div class='bg_digit'>$s[8]</div><div class='bg_digit'>$s[9]</div>";
        } else {
            $s = str_split($count);
            $p = "";
            for ($i = 0; $i < count($s); $i++) {
                $p = $p . "<div class='bg_digit'>$s[$i]</div>";
            }
            echo $p;
        }
        exit;
    }

    function add_template($templateuniqid = null) {
        if (isset($this->params['pass'][0]) && $this->params['pass'][0]) {
            $this->loadModel("CaseTemplate");
            $res = $this->CaseTemplate->find('first', array('conditions' => array('CaseTemplate.id' => $this->params['pass'][0])));
            $this->set('TempalteArray', $res);
        } else {
            if (!empty($this->request->data) && $this->Auth->User('id')) {
                $this->request->data['CaseTemplate'] = $this->request->data['User'];
                $this->request->data['CaseTemplate']['name'] = $this->request->data['CaseTemplate']['title'];
                $this->request->data['CaseTemplate']['description'] = $this->request->data['CaseTemplate']['desc'];
                $this->request->data['CaseTemplate']['user_id'] = $this->Auth->User('id');
                $this->request->data['CaseTemplate']['company_id'] = SES_COMP;
                $this->loadModel("CaseTemplate");
                if ($this->request->data['CaseTemplate']['update_temp'] == 1) {
                    if (isset($this->request->data['User']['id'])) {
                        $this->CaseTemplate->id = $this->request->data['User']['id'];
                        if ($this->CaseTemplate->save($this->request->data)) {
                                $this->Session->write("SUCCESS", __("Template updated successfully",true));
                            $this->redirect(HTTP_ROOT . "users/manage_template");
                        } else {
                                $this->Session->write("ERROR", __("Template can't be updated",true));
                            $this->redirect(HTTP_ROOT . "users/add_template/" . $this->request->data['User']['id']);
                        }
                    } else {
                        if ($this->CaseTemplate->save($this->request->data)) {
                                $this->Session->write("SUCCESS", __("Template added successfully",true));
                            $this->redirect(HTTP_ROOT . "users/manage_template");
                        } else {
                                $this->Session->write("ERROR", __("Template can't be added",true));
                            $this->redirect(HTTP_ROOT . "users/add_template");
                        }
                    }
                }
            }
        }
    }

    function manage_template() {
        if (isset($this->params['pass'][0]) && $this->params['pass'][0]) {
            $this->loadModel("CaseTemplate");
            $this->CaseTemplate->id = $this->params['pass'][0];
            $this->CaseTemplate->delete();
            $this->CaseTemplate->delete();
                $this->Session->write("SUCCESS", __("Deleted successfully",true));
            $this->redirect(HTTP_ROOT . "users/manage_template");
        }
        if (isset($this->request->query['act']) && $this->request->query['act']) {
            $v = urldecode(trim($this->request->query['act']));
            $this->loadModel("CaseTemplate");
            $this->CaseTemplate->id = $v;
            if ($this->CaseTemplate->saveField("is_active", 1)) {
                    $this->Session->write("SUCCESS", __("Template activated successfully",true));
                $this->redirect(HTTP_ROOT . "users/manage_template/");
            } else {
                    $this->Session->write("ERROR", __("Template can't be activated.Please try again.",true));
                $this->redirect(HTTP_ROOT . "users/manage_template/");
            }
        }
        if (isset($this->request->query['inact']) && $this->request->query['inact']) {
            $v = urldecode(trim($this->request->query['inact']));
            $this->loadModel("CaseTemplate");
            $this->CaseTemplate->id = $v;
            if ($this->CaseTemplate->saveField("is_active", 0)) {
                    $this->Session->write("SUCCESS", __("Template deactivated successfully",true));
                $this->redirect(HTTP_ROOT . "users/manage_template/");
            } else {
                    $this->Session->write("ERROR", __("Template can't be deactivated.Please try again.",true));
                $this->redirect(HTTP_ROOT . "users/manage_template/");
            }
        }
        $this->loadModel("CaseTemplate");
        $res = $this->CaseTemplate->find('all', array('conditions' => array('company_id' => SES_COMP, 'user_id' => SES_ID, 'is_active' => 1)));
        $total_record1 = $res;
        $total_records = count($total_record1);
        $this->set('total_records', $total_records);

        $page_limit = MILE_PAGE_LIMIT;
        $page = 1;
        $pageprev = 1;
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;
        $query = "SELECT * FROM case_templates WHERE case_templates.company_id='" . SES_COMP . "' AND case_templates.user_id='" . SES_ID . "' ORDER BY created ASC LIMIT " . $limit1 . "," . $limit2;
        $TempalteArray = $this->CaseTemplate->query($query);

        //$limit = $limit1.",".$limit2;
        //$TempalteArray =$this->CaseTemplate->find('all', array('conditions'=> array('CaseTemplate.is_active'=>1,'order'=>array('CaseTemplate.created DESC'),'limit' =>$limit)));
        $count_mile = count($TempalteArray);
        $this->set('count_mile', $count_mile);
        $this->set('page_limit', $page_limit);
        $this->set('page', $page);
        $this->set('pageprev', $pageprev);
        $this->set('TempalteArray', $TempalteArray);
    }

    function ajax_project_list_milestone() {
        $this->layout = 'ajax';
        $page = $this->request->data['page'];
        $limit = $this->request->data['limit'];
        $qry = "";
        $ProjectUser = ClassRegistry::init('ProjectUser');

        if ($limit != "all") {

            $allProjArr = $ProjectUser->query("select DISTINCT p.name,p.uniq_id as uniq_id,(select count(ml.id) from milestones as ml where pu.project_id=ml.project_id ) as count from projects as p, project_users as pu where p.id=pu.project_id and pu.user_id='" . SES_ID . "' and pu.company_id='" . SES_COMP . "' AND p.isactive='1' ORDER BY pu.dt_visited DESC LIMIT 0,$limit");
        } else {
            $allProjArr = $ProjectUser->query("select DISTINCT p.name,p.uniq_id as uniq_id,(select count(ml.id) from milestones as ml where  pu.project_id=ml.project_id ) as count from projects as p, project_users as pu where p.id=pu.project_id and pu.user_id='" . SES_ID . "' and pu.company_id='" . SES_COMP . "' AND p.isactive='1' ORDER BY pu.dt_visited DESC");
        }

        $this->set('allProjArr', $allProjArr);

        $countAll = $ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => 'DISTINCT Project.id'));
        $this->set('countAll', $countAll);

        $this->set('page', $page);
        $this->set('limit', $limit);
    }

    function search_project_menu_milestone() {
        $this->layout = 'ajax';
        $page = $this->request->data['page'];
        $val = $this->request->data['val'];
        if ($val != "") {
            $cond = array('conditions' => array('Project.name LIKE' => '%' . $val . '%', 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('DISTINCT  Project.uniq_id', 'Project.id', 'Project.name'));


            $ProjectUser = ClassRegistry::init('ProjectUser');
            $ProjectUser->unbindModel(array('belongsTo' => array('User')));

            /* $allProjArr = $ProjectUser->find('all', $cond);	
              $countAll = $ProjectUser->find('count', array('conditions'=>array('Project.name LIKE' => '%'.$val.'%','Project.isactive' => 1,'Project.company_id'=>SES_COMP), 'fields' => 'DISTINCT Project.id')); */

            $allProjArr = $ProjectUser->query("SELECT SQL_CALC_FOUND_ROWS DISTINCT Project.uniq_id,Project.id,Project.name FROM project_users as ProjectUser,projects as Project WHERE ProjectUser.project_id=Project.id AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' AND Project.name LIKE '%" . $val . "%' AND ProjectUser.user_id='" . SES_ID . "'");

            //pr($allProjArr);

            $totcnt = $ProjectUser->query("SELECT FOUND_ROWS() as count");
            $countAll = $totcnt['0']['0']['count'];
        }
        $this->set('countAll', $countAll);
        $this->set('allProjArr', $allProjArr);
        $this->set('page', $page);
        $fres = 1;
        $this->set('fres', $fres);
        if ($val == "" || $countAll == 0) {
            $fres = 0;
            $this->set('fres', $fres);
        }
    }

########################################

    function update_tbl() {
        $this->layout = 'none';
        $this->loadmodel('Easycase');
        $this->recursive = -1;
        $caseno = array(7, 8, 9);
        foreach ($caseno AS $k => $v) {
            $res = $this->Easycase->query('SELECT *,MAX(id) AS pid ,MAX(dt_created) AS dt  FROM easycases WHERE case_no=' . $v . ' GROUP BY project_id');
            foreach ($res as $key => $val) {
                $sql = "UPDATE easycases set updated_by='SELECT user_id FROM easycases WHERE id=" . $val['0']['pid'] . " ',dt_created='" . $val[0]['dt'] . "'  WHERE case_no=" . $v . " AND project_id=" . $val['easycases']['project_id'] . " AND istype=1";
                $this->Easycase->query($sql);
                //echo $sql."<hr/>";
            }
        }echo "success";
        exit;
    }

    function betausers($error = NULL) { //User registration for beta user through web
        $this->layout = '';
        //echo "<pre>";print_r($this->request->data);
        if (isset($error) && $error == '1') {
            $this->set('messageDisplay', "User Already Exist");
        } else if (isset($error) && $error == '2') {
            $this->set('messageDisplay', "Your beta user request has been approved");
        } else if (isset($error) && $error == '3') {
            $this->set('messageDisplay', "Your beta user request has been disapproved");
        } else if (isset($error) && $error == '4') {
            $this->set('messageDisplay', "User Already Exist");
        } else if (isset($error) && $error == '5') {
            $this->set('messageDisplay', "Your beta user request has been sent");
        }
        if (!empty($this->request->data)) {
            $submitVal = $this->request->data['submit_Pass'];
            $betaEmail = $this->request->data['User']['email'];

            if (!(empty($submitVal))) {
                $return = $this->Format->checkEmailExists($betaEmail);
                //echo $return;exit;

                if ($return == 1) { //Present in both user table and betauser table  //User Already Exists
                    $this->redirect(HTTP_APP . "users/home/1");
                } else if ($return == 2) { //Present in beta table but not in user table and is_approve in 1  //Your beta user has been approved
                    $this->redirect(HTTP_APP . "users/home/2");
                } else if ($return == 3) { //Present in beta table but not in user table and is_approve in 0  //Your beta user has been disapproved
                    $this->redirect(HTTP_APP . "users/home/3");
                } else if ($return == 4) { //Present in user table and not present in betauser table  //User Already Exists
                    $this->redirect(HTTP_APP . "users/home/4");
                } else if ($return == 5) { //Not present in both user and beta user table //Your beta user request has been sent
                    $this->loadModel('BetaUser');

                    $betauser['BetaUser']['email'] = $betaEmail;
                    $betauser['BetaUser']['registered_at'] = GMT_DATETIME;
                    if (1) {
                        if ($this->BetaUser->save($betauser)) {
                            $this->redirect(HTTP_APP . "users/home/5");
                        }
                    }
                }
            }
        }
    }

    function registration($token = NULL) {
        if (!(empty($token))) {
            $this->loadmodel('BetaUser');
            $checkToken = $this->BetaUser->find('first', array('conditions' => array('BetaUser.invit_token' => $token), 'fields' => array('BetaUser.id', 'BetaUser.is_approve', 'BetaUser.email', 'BetaUser.name')));
            $id = $checkToken['BetaUser']['id'];
            $is_approve = $checkToken['BetaUser']['is_approve'];
            $email = $checkToken['BetaUser']['email'];

            if (!$id) { //Token is not present in the betauser table
                    $this->Session->write("LOGIN_ERROR", __("You have not register for beta subscription!",true));
                $this->redirect(HTTP_APP . "users/login");
            } else {
                if ($is_approve == 1) {  //Token is present in the betauser table and also approved
                    $this->set("Token", $token);

                    $this->set("Email", $email);
                    $this->set("username", $checkToken['BetaUser']['name']);
                } else {  //Token is present in the betauser table and not approved
                        $this->Session->write("LOGIN_ERROR", __("You beta subscription is not approved yet!",true));
                    $this->redirect(HTTP_APP . "users/login");
                }
            }
        } else {
                $this->Session->write("LOGIN_ERROR", __("Proper message display",true));
            $this->redirect(HTTP_APP . "users/login");
        }
    }

    /* ###################### Beta Users ########################## */

    function betauser() {
        $this->loadmodel('BetaUser');
        if (isset($this->data['id']) && isset($this->data['flag'])) {
            $x = '';
            for ($i = 0; $i < count($this->data['id']); $i++) {
                $id = $this->data['id'][$i];
                $betauser = $this->BetaUser->findById($id);
                //print_r($betauser);//exit;
                if (!empty($betauser)) {
                    $email_id_user = $betauser['BetaUser']['email'];
                    $userinfo = $this->User->query('SELECT id FROM users WHERE email="' . $email_id_user . '"');
                    //print_r($userinfo[0]['users']['id']);exit;
                    if (!empty($userinfo)) {
                        $user_id = $userinfo[0]['users']['id'];
                    }
                    $this->BetaUser->id = $id;
                    if ($this->data['flag'] == 1) {
                        $data['BetaUser']['invit_token'] = md5($betauser['BetaUser']['email']);
                    } else if ($this->data['flag'] == 0) {
                        $data['BetaUser']['invit_token'] = '';
                    } else if ($this->data['flag'] == 2) {
                        $data['BetaUser']['invit_token'] = '';
                    }
                    $data['BetaUser']['is_approve'] = $this->data['flag'];
                    //print_r($data);
                    if ($this->BetaUser->save($data)) {
                        $this->loadmodel('CompanyUser');

                        $this->loadmodel('Company');
                        if ($user_id) {
                            $cmpinfo = $this->CompanyUser->query('SELECT company_id FROM company_users WHERE user_id="' . $user_id . '"'); //print_r($cmpinfo);exit;
                            $cmpid = $cmpinfo[0]['company_users']['company_id'];
                            if ($this->data['flag'] == 0 || $this->data['flag'] == 2) {
                                $user = $this->User->query('UPDATE users SET isactive=2 WHERE id=' . $user_id . '');
                                $cmpuser = $this->CompanyUser->query('UPDATE company_users SET is_active=0  WHERE user_id=' . $user_id . '');
                                $company = $this->Company->query('UPDATE companies SET is_active=0 WHERE id=' . $cmpid . '');
                            } else {
                                $user = $this->User->query('UPDATE users SET isactive=1 WHERE id=' . $user_id . '');
                                $cmpuser = $this->CompanyUser->query('UPDATE company_users SET is_active=1  WHERE user_id=' . $user_id . '');
                                $company = $this->Company->query('UPDATE companies SET is_active=1 WHERE id=' . $cmpid . '');
                            }
                            //$cmpuser = $this->CompanyUser->query('UPDATE company_users SET is_active='.$this->data['flag'].' WHERE user_id='.$user_id.''); 
                            //$company = $this->Company->query('UPDATE companies SET is_active='.$this->data['flag'].' WHERE id='.$cmpid.''); 
                        }
                        if ($this->data['flag'] == 1) {
                            //if($this->_send_email_invite($betauser['BetaUser']['email']) == '1'){
                            //$this->Session->write("SUCCESS","'".$betauser['BetaUser']['email']."' is approved successfully.");
                            if (empty($userinfo)) {
                                $this->_send_email_invite($betauser['BetaUser']['email']);
                            }
                            $x = 'approve';
                            //}
                        } else if ($this->data['flag'] == 0 || $this->data['flag'] == 2) {
                            //$this->Session->write("SUCCESS","'".$betauser['BetaUser']['email']."' is disapproved successfully.");
                            $x = 'disapprove';
                        }

                        //$this->redirect(HTTP_ROOT."users/betauser");
                    }
                }
            }
            $x = $x;
            echo $x;
            exit;
        }

        if (!empty($this->data['email']) && isset($this->data['email'])) {
            if ($this->_check_email_exist($this->data['email']) == '1') {
                $data['BetaUser']['email'] = $this->data['email'];
                $data['BetaUser']['invit_token'] = md5($this->data['email']);
                $data['BetaUser']['is_approve'] = '1';
                $data['BetaUser']['is_admin_invited'] = '1';
                $data['BetaUser']['registered_at'] = GMT_DATETIME;
                $this->BetaUser->save($data);
                if ($this->_send_email_invite($this->data['email']) == '1') {
                    echo 'success';
                    exit;
                }
            } else {
                echo $this->_check_email_exist($this->data['email']);
            }
            exit;
        }


        $betausers = $this->BetaUser->find('all');
        $this->set('betausers', $betausers);
    }

    function _check_email_exist($email = null) {
        $this->loadmodel('BetaUser');
        $betauser = $this->BetaUser->findByEmail($email);
        $user = $this->User->find('first', array('conditions' => array('email' => $email)));
        if (!empty($user)) {
            return 'User already exists!';
        } else if (!empty($betauser)) {
            $msg = '';
            if ($betauser['BetaUser']['is_approve'] == 1) {
                $msg = 'Approved Betauser';
            } else {
                $msg = 'Disapproved Betauser';
            }
            return $msg;
        } else {
            return true;
        }
    }

    function _send_email_invite($email = null) {
        $to = $email;
        $expEmail = explode("@", $email);
        $expName = $expEmail[0];
        $qstr = md5($email);
        $subject = "Welcome to Orangescrum - project collaboration made simple";
        $invitationMsg = "<tr><td align='left'><br/></td></tr><tr><td align='left' style='font-family:Arial;font-size:14px;'>Thank you for showing interest on <b>Orangescrum</b>.</td></tr>
						<tr><td align='left' style='font-family:Arial;font-size:14px;line-height:25px;'>You are just one step away to start exploring Orangescrum.</td></tr>
						
						<tr><td align='left'><br/></td></tr><tr>
						";
        $message = "<table cellpadding='1' cellspacing='1' align='left' width='100%'>
						 " . EMAIL_HEADER . "
						<tr><td>&nbsp;</td></tr>
						<tr><td align='left' style='font-family:Arial;font-size:14px;'>Hi " . $expName . ",</td></tr>
						<tr><td>&nbsp;</td></tr>
						" . $invitationMsg . "
						<tr><td>&nbsp;</td></tr>
						<tr><td align='left' style='font-family:Arial;font-size:14px;'>Click below link to get started,</td></tr>
						<tr><td align='left' style='font-family:Arial;font-size:14px;'><a href='" . HTTP_ROOT . "users/registration/" . $qstr . "' target='_blank'>" . HTTP_ROOT . "users/registration/" . $qstr . "</a></td></tr>
						<tr height='25px'><td>&nbsp;</td></tr>
						" . EMAIL_FOOTER . "
					</table>";

        if ($this->Sendgrid->sendGridEmail(FROM_EMAIL, $to, $subject, $message, "BetaUserReg")) {
            return '1';
        } else {
            return false;
        }
    }

    function betauser_dtbl() {
        $this->loadmodel('BetaUser');
        //$aColumns = array('id','email', 'is_admin_invited','registered_at','is_approve','action');
        $aColumns = array('email', 'is_admin_invited', 'registered_at', 'action');
        $sIndexColumn = "id";
        $sTable = "beta_users";
        /*
         * Paging
         */
        $sLimit = "";
        if (isset($_REQUEST['iDisplayStart']) && $_REQUEST['iDisplayLength'] != '-1') {
            $sLimit = "LIMIT " . $_REQUEST['iDisplayStart'] . ", " . $_REQUEST['iDisplayLength'];
        }

        /*
         * Ordering
         */
        if (isset($_REQUEST['iSortCol_0'])) {
            $sOrder = "ORDER BY  ";
            for ($i = 0; $i < intval($_REQUEST['iSortingCols']); $i++) {
                if ($_REQUEST['bSortable_' . intval($_REQUEST['iSortCol_' . $i])] == "true") {
                    $sOrder .= $aColumns[intval($_REQUEST['iSortCol_' . $i])] . "
					 	" . $_REQUEST['sSortDir_' . $i] . ", ";
                }
            }
            $sOrder = substr_replace($sOrder, "", -2);
            if ($sOrder == "ORDER BY") {
                $sOrder = "";
            }
        }
        /*
         * Filtering
         * NOTE this does not match the built-in DataTables filtering which does it
         * word by word on any field. It's possible to do here, but concerned about efficiency
         * on very large tables, and MySQL's regex functionality is very limited
         */
        $sWord = '';
        $sWhere = "";
        if ($_REQUEST['sSearch'] != "") {
            $sWhere = "WHERE (";
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] == 'email') {
                    $sWhere .= "email LIKE '%" . $_REQUEST['sSearch'] . "%' OR ";
                } else if ($aColumns[$i] == 'is_admin_invited') {
                    if ($_REQUEST['sSearch'] == 'Admin' || $_REQUEST['sSearch'] == 'admin') {
                        $sWhere .= "is_admin_invited = 1 OR ";
                    }
                } else if ($aColumns[$i] == 'registered_at') {
                    $sWhere .= "registered_at LIKE '%" . $_REQUEST['sSearch'] . "%' OR ";
                } else if ($aColumns[$i] == 'is_approve') {
                    if ($_REQUEST['sSearch'] == 'Approve' || $_REQUEST['sSearch'] == 'approve') {


                        $sWhere .= "is_approve = 1 OR ";
                    } else if ($_REQUEST['sSearch'] == 'Disapprove' || $_REQUEST['sSearch'] == 'disapprove') {
                        $sWhere .= "is_approve = 0 OR ";
                    }
                }
            }
            $sWhere = substr_replace($sWhere, "", -3);
            $sWhere .= ')';
        }

        /*
         * SQL queries
         * Get data to display
         */
        if ($sWhere != '') {
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS id, email, is_admin_invited, is_approve, registered_at
			FROM   beta_users
			$sWhere
			$sOrder
			$sLimit";
        } else {
            $sQuery = "SELECT SQL_CALC_FOUND_ROWS id, email, is_admin_invited, is_approve, registered_at
				FROM   beta_users
				$sOrder 
				$sLimit";
        }
        $rResult = $this->BetaUser->query($sQuery);
        /* Data set length after filtering */
        $sQuery = "SELECT FOUND_ROWS()";
        $aResultFilterTotal = $this->BetaUser->query($sQuery);
        $iFilteredTotal = $aResultFilterTotal[0];
        $iFilteredTotal = $iFilteredTotal[0]['FOUND_ROWS()'];
        /*
         * Output
         */
        $output = array(
            "sEcho" => intval($_REQUEST['sEcho']),
            "iTotalRecords" => $iFilteredTotal,
            "iTotalDisplayRecords" => $iFilteredTotal,
            "aaData" => array()
        );
        $row = array();
        $aRow = array();
        foreach ($rResult as $v) {
            $email = $v['beta_users']['email'];
            $createdby = '';
            $curCreated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            $actualDt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['beta_users']['registered_at'], "datetime");
            $registered_at = $this->Format->dateFormatOutputdateTime_day($actualDt, $curCreated, 'week');
            //$registered_at = $this->Format->dateFormatReverse($v['beta_users']['registered_at']);
            if ($v['beta_users']['is_admin_invited'] == 1) {
                $createdby = 'Admin';
            } else {
                $createdby = 'Self';
            }

            $is_approve = '';
            if ($v['beta_users']['is_approve'] == 0) {
                //$is_approve = '<a href="'.HTTP_ROOT.'users/betauser?id='.$v['beta_users']['id'].'&flag=1" style="color:#4BA54B;text-align:center">Approve</a>';

                $is_approve = '<span style="color:#EF6807;">Pending</span>';
            } else {
                //$is_approve = '<a href="'.HTTP_ROOT.'users/betauser?id='.$v['beta_users']['id'].'&flag=0" style="color:#F2905C;text-align:center">Disapprove</a>';
                $is_approve = '<span style="color:#387600;">Approved</span>';
            }
            $is_action = '';
            if ($v['beta_users']['is_approve'] == 0) {
                $is_action = '<a style="color:#EF6807;cursor:pointer;" onClick="multipleBetauserAction(\'Approve\',' . $v['beta_users']['id'] . ')">Pending</a>';
            } elseif ($v['beta_users']['is_approve'] == 1) {
                //$is_action ='<a style="color:#387600;cursor:pointer;" onClick="multipleBetauserAction(\'Disapprove\','.$v['beta_users']['id'].')">Approved</a>';
                $is_action = '<a style="color:#387600;cursor:default;" herf="javascript:void(0);">Approved</a>';
            } else if ($v['beta_users']['is_approve'] == 2) {
                $is_action = '<a style="color:#000;cursor:pointer;" onClick="multipleBetauserAction(\'Reject\',' . $v['beta_users']['id'] . ')">Rejected</a>';
            }
            $id = '<div style="float:left;"><input type="checkbox" class="chkbox" style="cursor:pointer;" id="chk' . $v['beta_users']['id'] . '" value="' . $v['beta_users']['id'] . '|' . $v['beta_users']['is_approve'] . '" onClick="chk_emailId()"/></div>';
            for ($i = 0; $i < count($aColumns); $i++) {
                if ($aColumns[$i] != ' ') {
                    /* if($aColumns[$i] == 'id'){
                      $aRow[$aColumns[$i]] = $id;
                      }else */if ($aColumns[$i] == 'email') {
                        $aRow[$aColumns[$i]] = '<font color="#003366" style="font-size:13px">' . $email . '</font>';
                    } elseif ($aColumns[$i] == 'is_admin_invited') {
                        $aRow[$aColumns[$i]] = $createdby;
                    } elseif ($aColumns[$i] == 'registered_at') {
                        $aRow[$aColumns[$i]] = $registered_at;
                    } elseif ($aColumns[$i] == 'action') {
                        $aRow[$aColumns[$i]] = $is_action;
                    }
                    $row[$i] = $aRow[$aColumns[$i]];
                }
            }
            $output['aaData'][] = $row;
        }
        echo json_encode($output);
        exit;
    }

    function account_usages() {
        $cond = array('UserSubscription.company_id' => SES_COMP);
        $this->loadModel('UserSubscription');
        $subscription = $this->UserSubscription->find('all', array('joins' => array(
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array('UserSubscription.user_id=User.id', $cond)),
                array('table' => 'companies',
                    'alias' => 'Company',
                    'type' => 'inner',
                    'conditions' => array('UserSubscription.company_id=Company.id', 'Company.is_active!=0'))),
            'order' => "id DESC", 'fields' => "UserSubscription.*,User.name,User.last_name,User.email,Company.name"));
        $this->set('user_sub', $subscription);
        $this->set('company_details_flag', 1);
    }

    /**
     * @method: public pricing() Pricing page 
     * @author Andola Dev <>
     * @return  html
     */
    function pricing() {
        $this->redirect(HTTP_ROOT . "dashboard");
    }

    function thank_mail($name, $email, $flag = 0) {
        if ($flag) {
            $this->Email->delivery = 'smtp';
            $this->Email->to = $email;
            $this->Email->subject = Configure::read('enterprise_inquiry_subject');
            $this->Email->from = FROM_EMAIL;
            $this->Email->template = 'contact_us_thank';
            $this->Email->sendAs = 'html';
            $this->set('email', $email);
            $this->set('name', $name);
            try {
                $res = $this->Sendgrid->sendgridsmtp($this->Email);
            } Catch (Exception $e) {
                
            }
        }
    }
    /**
     * @method: public create_bt_subscription(array users,int company_id,$flag) Creating subscription for paid user in there first login
     * @author Andola Dev <support@andolacrm.com>
     */
    function create_bt_subscription($user, $company_id = SES_COMP, $flag) {
    }

    /**
     * @method: public billing_info(int $tot_user) Updating subscription info again
     * @author Andola Dev <support@andolacrm.com>
     */
    function billing_info() {
        $this->layout = 'ajax';
        $billing_info = $this->User->get_billing_info();
        $this->set('userinfo', $billing_info);
    }

    /**
     * @method: public sendmailtorpt(array $data) 
     * @author Andola Dev <support@anolacrm.com	>
     */
    function sendmailtorpt($data, $comp_name, $message, $resptext) {
            return 'pass';
    }

    /**
     * @method: public payment_details() 
     * @author Andola Dev <>
     * @return html Content to the view page
     */
    function payment_details() {
        $this->check_config();
        if (!$GLOBALS['Userlimitation']['btsubscription_id']) {
            $this->redirect(HTTP_ROOT);
        }
    }

    /**
     * @method: public billing_details() 
     * @author Andola Dev <>
     * @return html Content to the view page
     */
    function billing_details() {
        $this->layout = 'ajax';
        $billing_info = $this->User->get_billing_info();
        $this->set('userinfo', $billing_info);
    }

    /**
     * @method: public transacation_list() 
     * @author Andola Dev <>
     * @return html Content to the view page
     */
    function transaction() {
        //$this->layout='ajax';
            if ($this->Auth->user('istype') == 1 || ($this->Auth->user('istype') == 2 && SES_COMP == 1)) {
            if (isset($this->data['company_id'])) {
                $cond = " AND t.company_id = " . $this->data['company_id'];
            } else {
                $cond = " AND 1";
            }
        } elseif (SES_TYPE == 1) {
            $cond = " AND t.company_id = " . SES_COMP;
        } else {
            $this->redirect(HTTP_ROOT);
        }
        $sql = "SELECT t.*,a.name,concat(u.name,' ',u.last_name) as u_name, u.email "
                . "FROM transactions t "
                . "LEFT JOIN users u ON u.id = t.user_id "
                . "INNER JOIN companies a ON a.id = t.company_id  "
                . "WHERE (t.transaction_type = 'subscription_charged_successfully' OR t.transaction_type = 'Instant Payment on cancellation') $cond "
                . "GROUP BY t.transaction_id ORDER BY t.id DESC";
        $trans_data = $this->User->query($sql);
        $this->set('transaction', $trans_data);
//        pr($trans_data); exit;
        $this->set('email', $trans_data[0]['u']['email']);
        if ($this->data['company_id']) {
            $this->layout = 'ajax';
            $this->render('transaction_list');
        }
    }
    /**
     * @method: public cancel_sub(array $data) 
     * @author Andola Dev <support@anolacrm.com	>
     */
    function cancel_sub() {
        $this->layout = 'ajax';
        $this->set('company_id', $this->data['company_id']);
    }

    /**
     * @method: public cancel_account(array $data) 
     * @author Andola Dev <support@anolacrm.com	>
     */
    function cancel_account() {
        $this->check_config();
        $user = $this->User->findById(SES_ID);
        $this->set('password', $user['User']['password']);
    }
    /**
     * @method: instantinvoice()
     * @author GDR <>
     * @return html Retrun a html code which is converted to PDF
     */
    function instantinvoice() {
        $this->layout = NULL;
        $data = $this->params['named'];
        $transactionId = $data['transactionId'];
        $subscriptionId = $data['subscriptionId'];
        $this->loadModel('UserSubscriptions');
        $usrSub = $this->UserSubscriptions->find('first', array('conditions' => array('UserSubscriptions.btsubscription_id' => $subscriptionId), 'order' => 'UserSubscriptions.id DESC'));
        $this->loadModel('Transactions');
        $trans = $this->Transactions->find('first', array('conditions' => array('Transactions.id' => $transactionId)));
        //echo "<pre>".$transactionId;print_r($trans);print_r($usrSub);exit;
        $this->loadModel('Users');
        $usr = $this->Users->find('first', array('conditions' => array('Users.id' => $usrSub['UserSubscriptions']['user_id'])));
        //$billing_info = $this->User->get_billing_info($usrSub['UserSubscriptions']['company_id']);
        $this->loadModel('Companies');
        $cmp = $this->Companies->find('first', array('conditions' => array('Companies.id' => $usrSub['UserSubscriptions']['company_id'])));
        $this->set('transactions', $trans);
        $this->set('subscriptions', $usrSub);
        $this->set('users', $usr);
        $this->set('companies', $cmp);
        //$this->set('userinfo',$billing_info);
    }

    /**
     * @method: public cancel_action(int $account_id) Respective action after the cancelation of account
     * @author Andola Dev <support@andolacrm.com>
     * @return bool True if it updates all db colums else false 
     */
    function cancel_action($company_id, $flag = '', $userinfo, $inputdata = array()) {
        if ($flag) {
            $this->loadModel('DeletedCompany');
            $res = $this->DeletedCompany->deltededcompany_record($inputdata, $company_id, $userinfo['User']['name'] . ' ' . $userinfo['User']['last_name'], $userinfo['User']['email'], $GLOBALS['Userlimitation']['subscription_id']);
            if ($inputdata['is_delete'] == 1) {
                if ($res) {
                    if ($userinfo) {
                        $this->Email->delivery = 'smtp';
                        $this->Email->to = $userinfo['User']['email'];
                        //$this->Email->bcc = TO_DEV_EMAIL;
                        $this->Email->subject = Configure::read('delete_account');
                        $this->Email->from = FROM_EMAIL;
                        $this->Email->template = 'delete_notify';
                        $this->Email->sendAs = 'html';
                        $this->set('data', $userinfo);
                        $this->set('company_name', $cmp_dat['Companies']['name']);
                        $this->set('inputdata', $inputdata);
                        if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                            //Event log data and inserted into database for invoice mail not sent -- Start
                            $json_arr['company_id'] = $company_id;
                            $json_arr['owner_name'] = $userinfo['User']['name'] . " " . $userinfo['User']['last_name'];
                            $json_arr['email'] = $userinfo['User']['email'];
                            $json_arr['date'] = GMT_DATETIME;
                            $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 19);
                            //End 
                        } else {
                            //Event log data and inserted into database for invoice mail not sent -- Start
                            $json_arr['company_id'] = $company_id;
                            $json_arr['owner_name'] = $userinfo['User']['name'] . " " . $userinfo['User']['last_name'];
                            $json_arr['email'] = $userinfo['User']['email'];
                            $json_arr['date'] = GMT_DATETIME;
                            $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 29);
                            //End 
                        }

                        //Deleting company data 
                        $this->loadModel('CompanyUser');
                        if ($this->CompanyUser->delete_company($company_id)) {
                            $this->redirect(HTTP_ROOT);
                            exit;
                        }
                    }
                }
            } else {
                if ($company_id) {
                    $data = null;
                    //User subscription table update
                    $this->loadModel('UserSubscriptions');
                    $usersub = $this->UserSubscriptions->find('first', array('conditions' => array('UserSubscriptions.company_id' => $company_id), 'order' => 'id DESC'));

                    $remain_free_trial_days = $this->User->fetchUserTrialDays(SES_COMP);
                    $_cancel_active_period = '';
                    if (in_array($usersub['UserSubscriptions']['subscription_id'], array(11, 13)) || $remain_free_trial_days > 0) {
                        $data['UserSubscriptions']['id'] = $usersub['UserSubscriptions']['id'];
                        $data['UserSubscriptions']['company_id'] = $company_id;
                        $data['UserSubscriptions']['is_cancel'] = 1;
                        $data['UserSubscriptions']['cancel_date'] = GMT_DATETIME;
                        $data['UserSubscriptions']['next_billing_date'] = '';
                        $this->UserSubscriptions->save($data);

                        // Account table 
                        $this->loadModel('Companies');
                        $cmp_dat = $this->Companies->findById($company_id);
                        $adata['Companies']['id'] = $company_id;
                        $adata['Companies']['is_active'] = 2;
                        $this->Companies->save($adata);
                        $this->loadModel('CompanyUsers');
                        $this->CompanyUsers->UpdateAll(array('billing_start_date' => "''", 'billing_end_date' => "''"), array('company_id' => $company_id));
                    } else {
                        $_cancel_active_period = $usersub['UserSubscriptions']['next_billing_date'];
                        $data['UserSubscriptions']['id'] = $usersub['UserSubscriptions']['id'];
                        $data['UserSubscriptions']['company_id'] = $company_id;
                        $data['UserSubscriptions']['cancel_date'] = GMT_DATETIME;
                        $data['UserSubscriptions']['temp_sub_cancel'] = 1;
                        $this->UserSubscriptions->save($data);
							$this->Format->resetCacheSub(SES_COMP);
                    }
                }
                // Users table 
                //$this->loadModel('Users');
                //$this->Users->updateAll(array('status'=>4),array('account_id'=>$account_id,'status!=3'));
                // Formal email notification to the user after cancellation of account
                if ($userinfo) {
                    $this->Email->delivery = 'smtp';
                    //$this->Email->to = 'rpt@andolasoft.com';
                    $this->Email->to = $userinfo['User']['email'];
                    $this->Email->subject = Configure::read('cancel_subscription_subject');
                    $this->Email->from = FROM_EMAIL;
                    $this->Email->template = 'cancel_notify';
                    $this->Email->sendAs = 'html';
                    $this->set('data', $userinfo);
                    $this->set('company_name', $cmp_dat['Companies']['name']);
                    $this->set('inputdata', $inputdata);
                    $this->set('cancel_active_period', $_cancel_active_period);
                    if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                        //Event log data and inserted into database for invoice mail not sent -- Start
                        $json_arr['company_id'] = $company_id;
                        $json_arr['owner_name'] = $userinfo['User']['name'] . " " . $userinfo['User']['last_name'];
                        $json_arr['email'] = $userinfo['User']['email'];
                        $json_arr['date'] = GMT_DATETIME;
                        $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 19);
                        //End 
                    } else {
                        //Event log data and inserted into database for invoice mail not sent -- Start
                        $json_arr['company_id'] = $company_id;
                        $json_arr['owner_name'] = $userinfo['User']['name'] . " " . $userinfo['User']['last_name'];
                        $json_arr['email'] = $userinfo['User']['email'];
                        $json_arr['date'] = GMT_DATETIME;
                        $this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 29);
                        //End 
                    }
                }
            }
        }
    }

    /**
     * @method: public updatebtprofile(type $paramName) Description
     * @author Andola Dev <>
     */
    function updatebtprofile($user) {}

    /**
     * @method: public create_btprofile() Create a BT profile from the input signup page value
     * @author Andola Dev <>
     * @return json Return a json array if profile creation sucess then succ with bt_profile_id and credit card token else error message
     */
    function create_btprofile() {
    }

    /*
     * @author Sunil
     * @method: googleConnect
     * @return a token.
     */

    function googleConnect() {
        $this->layout = 'ajax';

        /* echo "<pre>";
          print_r($_GET['state']);
          exit; */

        if (isset($_GET['code'])) {
            App::import('Vendor', 'GoogleClient', array('file' => 'google-api' . DS . 'src' . DS . 'Google_Client.php'));
            if (isset($_GET['state'])) {
                App::import('Vendor', 'GoogleOauth', array('file' => 'google-api' . DS . 'src' . DS . 'contrib' . DS . 'Google_Oauth2Service.php'));
                $client = $this->setClient(1);
                $service = new Google_Oauth2Service($client);
            } else {
                App::import('Vendor', 'GoogleDrive', array('file' => 'google-api' . DS . 'src' . DS . 'contrib' . DS . 'Google_DriveService.php'));
                $client = $this->setClient();
            }

            $client->authenticate();
            $token = $client->getAccessToken();
            $emails = '';
            if (isset($_GET['state'])) {
                $params = explode('-', $_GET['state']);
                $_GET['state'] = $params[0];
                $emails = $params[1];
            }
            if (isset($_GET['state']) && $_GET['state'] != 'contact') {
                $user = $service->userinfo->get();
                $info = (array) $user;
										$isEmailT = array();
                if (isset($info) && !empty($info)) {
											$isEmailT = $this->User->find('first', array('conditions' => array('User.email' => $info['email']), 'fields' => array('User.id')));
                    $_SESSION['CHECK_GOOGLE_SES'] = 0;
											if(!empty($isEmailT)){
                    $_SESSION['GOOGLE_USER_INFO'] = $info;
                    $_SESSION['GOOGLE_USER_INFO']['access_token'] = $token;

                    $guser['GOOGLE_USER_INFO'] = $info;
                    $guser['GOOGLE_USER_INFO']['access_token'] = $token;
                    setcookie('GOOGLE_USER_INFOS', json_encode($guser), time() + 3600 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
                }

                    }
                if ($_GET['state'] == "login") {
											if(!empty($isEmailT)){
                    setcookie('google_login', 1, time() + 300, '/', DOMAIN_COOKIE, false, false);
											}else{
												setcookie('google_login', 0, time() + 300, '/', DOMAIN_COOKIE, false, false);
											}
                }
                setcookie('google_accessToken', $token, time() + 3600 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
            }
            if (isset($_GET['state']) && $_GET['state'] == 'contact') {

                $CompanyUser = ClassRegistry::init('CompanyUser');



                $checkCmnpyUsr = $CompanyUser->find('all', array('conditions' => array('CompanyUser.company_uniq_id' => $params[2]), 'fields' => array('CompanyUser.user_id')));
                $CmnpyUsr = array();
                if ($checkCmnpyUsr) {
                    $checkCmnpyUsr = Hash::extract($checkCmnpyUsr, '{n}.CompanyUser.user_id');
                    $checkCmnpyUsr = array_unique($checkCmnpyUsr);
                    $CmnpyUsr = $this->User->find('all', array('conditions' => array('User.id' => $checkCmnpyUsr), 'fields' => array('User.email')));
                    if ($CmnpyUsr) {

                        $CmnpyUsr = Hash::extract($CmnpyUsr, '{n}.User.email');
                    }
                }
                $this->set('CompUsers', $CmnpyUsr);
                $temp_arr = json_decode($token, true);
                $max_results = 500;
                $url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&alt=json&v=3.0&oauth_token=' . $temp_arr['access_token'] . '&orderby=lastmodified&sortorder=descending';
                $response = $this->getContacts($url);
                /* echo "<pre>";
                  print_r($response);
                  echo "</pre>";exit; */
                $response = json_decode($response, true);
                $this->set('contacts', $response);
                $this->set('emails', $emails);
                setcookie('google_accessToken', $temp_arr['access_token'], time() + 3600 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
                $this->render('google_contact');
            }
        }
    }

    function getContacts($url) {
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

        curl_setopt($curl, CURLOPT_URL, $url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5); //The number of seconds to wait while trying to connect.	

        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); //To stop cURL from verifying the peer's certificate.

        $contents = curl_exec($curl);
        curl_close($curl);
        return $contents;
    }

    /*
     * @author Sunil
     * @method setClient
     * @return an object of google.
     */

    function setClient($isLogin = NULL) {
        $client = new Google_Client();

        // Get your credentials from the APIs Console
        $client->setClientId(CLIENT_ID);
        $client->setClientSecret(CLIENT_SECRET);
        $client->setRedirectUri(REDIRECT_URI);
        if (isset($isLogin)) {
            $client->setDeveloperKey(API_KEY);
            $client->setScopes(array(
                'https://www.googleapis.com/auth/userinfo.profile'
            ));
        } else {
            $client->setScopes(array(
                'https://www.googleapis.com/auth/drive'
            ));
        }

        $client->setUseObjects(true);
        return $client;
    }

    /*
     * @author Sunil
     * @method googleConnect
     * @return a token.
     */

    function googleSignup() {
        $this->layout = 'ajax';
        $data = "";
        if (isset($_GET['code'])) {

            App::import('Vendor', 'GoogleClient', array('file' => 'google-api' . DS . 'src' . DS . 'Google_Client.php'));
            App::import('Vendor', 'GoogleOauth', array('file' => 'google-api' . DS . 'src' . DS . 'contrib' . DS . 'Google_Oauth2Service.php'));

            $client = $this->setClientForConnect();
            $service = new Google_Oauth2Service($client);

            $client->authenticate();
            $token = $client->getAccessToken();

            if (isset($_GET['state'])) {
                $user = $service->userinfo->get();
                $info = (array) $user;
                if (isset($info) && !empty($info)) {
                    $_SESSION['CHECK_GOOGLE_SES'] = 0;
                    $_SESSION['GOOGLE_USER_INFO'] = $info;
                    $_SESSION['GOOGLE_USER_INFO']['access_token'] = $token;
                }

                //Set google info from session and check if google email exists in our record or not.
                if (isset($info) && !empty($info)) {
                    $isEmail = $this->User->find('first', array('conditions' => array('User.email' => urldecode($info['email'])), 'fields' => array('User.id')));
                    if ($isEmail['User']['id']) {
                        setcookie('user_info', $info['email'], time() + 300, '/', DOMAIN_COOKIE, false, false);
                    }
                }
//                    pr($info);exit;
                if ($_GET['state'] == "signup") {
                    setcookie('google_signup', 1, time() + 300, '/', DOMAIN_COOKIE, false, false);
                }
            }

            setcookie('google_accessToken', $token, time() + 300, '/', DOMAIN_COOKIE, false, false);
        }
    }

    		function setDefaultOsMenu($comp_id, $user_id){
    			//$this->Session->write('leftMenuSize', 'mini-sidebar');
    			$this->loadModel('UserTheme');
    			$this->UserTheme->cachethemeSettings($comp_id, $user_id);
    		}
    /*
     * @author Sunil
     * @method setClientForConnect
     * @return an object of google.
     */

    function setClientForConnect() {
        $client = new Google_Client();

        // Get your credentials from the APIs Console
        $client->setClientId(CLIENT_ID_SIGNUP);
        $client->setClientSecret(CLIENT_SECRET_SIGNUP);
        $client->setRedirectUri(REDIRECT_URI_SIGNUP);
        $client->setDeveloperKey(API_KEY);
        $client->setScopes(array(
            'https://www.googleapis.com/auth/userinfo.profile'
        ));

        $client->setUseObjects(true);
        return $client;
    }

    /**
     * @method public paymentActivity() Listed all type of payment activity
     * @author Gayadhar  <>
     * @return html Returns a view page which contains listing
     */
        function account_activity($inpt=null) {
        /* if(SES_TYPE!=1){
          $this->redirect(HTTP_ROOT);exit;
          } */
        $flag = 0;
        $record_per_page = 20;
        if (isset($this->data['ajaxlayout']) && $this->data['ajaxlayout']) {
            $this->layout = 'ajax';
            $this->set('ajaxlayout', 1);
        }
        $this->loadModel('logType');
        $this->loadModel('logActivity');

        $conditions = " 1 AND logActivity.log_type_id!=5 ";
        if ($this->Auth->User('istype') != 1 && SES_TYPE == 1) {
            //$conditions=array('company_id'=>SES_COMP);
            $conditions .='   AND logActivity.company_id=' . SES_COMP;
            $company_id = SES_COMP;
                //} elseif ($this->Auth->User('istype') == 1 && isset($this->data['company_id'])) {
            } elseif (isset($this->data['company_id'])) {
            $flag = 1;
            $conditions .='   AND logActivity.company_id=' . $this->data['company_id'];
            $company_id = $this->data['company_id'];
        }
        if (isset($this->data['filter']) && $this->data['filter']) {
            $conditions .=" AND logActivity.log_type_id=" . $this->data['filter'];
            $this->set('filter', $this->data['filter']);
        } else {
            $this->set('filter', '0');
        }
        if (isset($this->data['page']) && $this->data['page']) {
            $page = $this->data['page'] - 1;
        } else {
            $page = 0;
        }
        $logtype = $this->logType->find('list', array('conditions' => array('id !=5'), 'fields' => array('id', 'name'), 'order' => 'name ASC'));
        $limit = $page * $record_per_page . ', ' . $record_per_page;
        $sql = "SELECT SQL_CALC_FOUND_ROWS  `logActivity`.*, `Company`.`name`, `User`.`name`, `User`.`last_name`, `User`.`email` 
                FROM `log_activities` AS `logActivity` 
                inner JOIN `companies` AS `Company` ON (`Company`.`id` = `logActivity`.`company_id`) 
                inner JOIN `users` AS `User` ON (`logActivity`.`user_id` = `User`.`id`) 
                WHERE " . $conditions . " ORDER BY logActivity.created DESC LIMIT " . $limit;
        $arr = $this->logActivity->query($sql);
        #pr($arr);exit;
        $sQuery = " SELECT FOUND_ROWS() AS cnt	";

        $total_record = $this->logActivity->query($sQuery);
            $logtype[0] = __('All',true);
						asort($logtype);
        $this->set('logtype', $logtype);
        $this->set('logactivity', $arr);
        $this->set('activityCount', $total_record[0][0]['cnt']);
        $this->set('page_limit', $record_per_page);
        $this->set('page', $page + 1);
        //Flag is required for osadmin company details page activity listing
        $this->set('flag', $flag);
        $this->set('comp_id', $company_id);
            if (!$inpt && $this->data['company_id']) {
            $this->layout = 'ajax';
            $this->render('payment_activity');
        }
    }

    /**
     * @method:  public welcomeback(array account_info) Welcome back mail after resubscription
     * @return boolen True/false
     * @author Andola  Dev <support@andolacrm.com>
     */
    function welcomeback($userinfo, $subscription, $next_billing_date) {
        return true;
    }

    /**
     * @method: public sendinvoicemail(); Resending Invoice email if its missed out
     * @author GDR <>
     * @return boolen 
     */
    function sendinvoicemail() {
        $to = $this->data['emailid'];
            $subject = "Re: OrangeScrum Invoice for Transaction : " . $this->data['invoiceid'];
        $message = "Hi,<br/> Sending the invoice attachement for the transaction";
        $file = "OrangeScrum_Invoice_" . $this->data['invoiceid'] . ".pdf";
        $filePath = DIR_IMAGES . "pdf";
        if (!file_exists($filePath . "/" . $file)) {
            exec(PDF_LIB_PATH . " " . HTTP_ROOT_INVOICE . "users/invoicePage/subscriptionId:" . $this->data['btsubscription_id'] . "/transactionId:" . $this->data['transactionid'] . " " . DIR_IMAGES . "pdf/OrangeScrum_Invoice_" . $this->data['invoiceid'] . ".pdf");
        }
        $response = $this->Sendgrid->sendGridEmail(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, "",'');
        if ($response) {
            $this->loadModel('Transactions');
            $tdata = array('invoice_mail_flag' => '1');
            $this->Transactions->updateAll($tdata, array('transaction_id' => $this->data['transactionid']));
            print 1;
        } else {
            print 0;
        }
        exit;
    }

    /**
     * @method: public download_invoice(); Downloading invoice for the logged in user
     * @author GDR <>
     * @return boolen 
     */
        function download_invoice($invoice_id, $company_id=null) {
        $path = DIR_IMAGES . "pdf/";
        $file = "OrangeScrum_Invoice_" . $invoice_id . ".pdf";
        $this->loadModel('Transactions');
			if($company_id && SES_ID == '522'){
				$trans = $this->Transactions->find('first', array('conditions' => array('company_id' => $company_id,'invoice_id' => $invoice_id)));
			}else{
        $trans = $this->Transactions->find('first', array('conditions' => array('company_id' => SES_COMP, 'user_id' => SES_ID, 'invoice_id' => $invoice_id)));
			}
        if ($trans) {
            //if (!file_exists($path . $file)) {
            exec(PDF_LIB_PATH . " " . HTTP_ROOT . "users/invoicePage/subscriptionId:" . $trans['Transactions']['btsubscription_id'] . "/transactionId:" . $trans['Transactions']['transaction_id'] . " " . DIR_IMAGES . "pdf/" . $file);
            //}
            $fullPath = $path . basename($file);
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header('Content-disposition: attachment; 
			filename=' . basename($fullPath));
            header("Content-Type: application/pdf");
            header("Content-Transfer-Encoding: binary");
            header('Content-Length: ' . filesize($fullPath));
            readfile($fullPath);
            exit;
        } else {
                $this->Session->write('ERROR', __("Requested file is not available with us!",true));
            $this->redirect(HTTP_ROOT);
        }
    }

    /**
     * 
     */
    function close_onbording() {
        $this->layout = 'ajax';
        $cookiename = $this->data['cookiename'];
        setcookie($cookiename . SES_ID, 1, time() + (7 * 24 * 60 * 60), '/', DOMAIN_COOKIE, false, false);
        echo 1;
        exit;
    }

    /**
     * @method:  public check_fordisabled_user() Durring add project checking for disabled users
     * @author GDR <>
     * @return bool true/false
     */
    function check_fordisabled_user() {
		$retArr = null;
		$emaillist = array();
        $emailids = trim(trim($this->data['email']), ',');
        if ($emailids && strstr($emailids, ',')) {
            $emails = explode(',', $emailids);
            foreach ($emails as $key => $value) {
                if (trim($value) != '') {
                    $emaillist[] = $value;
                }
            }
        } elseif ($emailids) {
            $emaillist[] = $emailids;
        }
        $userlist = $this->User->find('list', array('joins' => array(
                array(
                    'table' => 'company_users',
                    'alias' => 'CompanyUser',
                    'type' => 'inner',
                    'conditions' => array('CompanyUser.user_id=User.id', 'User.email IS NOT NULL', 'User.email' => $emaillist, 'CompanyUser.company_id' => SES_COMP, 'CompanyUser.user_type !=' => 1, 'CompanyUser.is_active' => 0)
                )),
            'fields' => array('User.id', 'User.email')));
        if ($userlist) {
			$retArr['status'] = 0;
			$retArr['users'] = implode(',', $userlist);
        } else {
            $retArr['status'] = 1;
        }
        echo json_encode($retArr);exit;
    }

    /**
     * @method:  public categorytab() Showing the tab lists in a popup
     * @author GDR <>
     * @return HTML 
     */
    function categorytab() {
        $this->layout = 'ajax';
    }

    /**
     * @method  public savecategorytab() Showing the tab lists in a popup
     * @author GDR <>
     * @return HTML 
     */
    function ajax_savecategorytab() {
        if ($this->data['is_ajaxflag']) {
            $this->layout = 'ajax';
            $tabvalue = $this->data['tabvalue'] ? $this->data['tabvalue'] : 0;
            $data['User']['id'] = SES_ID;
            $data['User']['active_dashboard_tab'] = $tabvalue;
            if ($this->User->save($data)) {
                define('ACT_TAB_ID', $tabvalue);
                echo '1';
                exit;
            } else {
                echo '0';
                exit;
            }
        } else {
            $this->redirect(HTTP_ROOT);
        }
    }

    function gmailContacts() {
        $this->layout = 'ajax';
        $contactEmail = gmailContactEmail();
        $this->set('gmailContact', $contactEmail);
    }

    /**
     * @method: public resend_invitation($querystring='') It will just send the link again to the user with email
     * @author GDR<>
     * @return JSON success/failure
     */
    function resend_invitation() {
        if (isset($_SESSION['puincrement_id'])) {
            unset($_SESSION['puincrement_id']);
        }
        if (isset($_SESSION['project_increment_id'])) {
            unset($_SESSION['project_increment_id']);
        }
        if ($this->data['querystring'] && $this->data['ajax_flag']) {
            $resend = $this->data['querystring'];
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $invit = $UserInvitation->find('first', array('conditions' => array('UserInvitation.qstr' => $resend)));
            if ($invit) {
                $qstr = $this->Format->generateUniqNumber();
                $data['UserInvitation']['id'] = $invit['UserInvitation']['id'];
                $data['UserInvitation']['qstr'] = $qstr;
                $invit['UserInvitation']['qstr'] = $qstr;
                if ($UserInvitation->save($data)) {

                    $inviteduser = $this->User->find('first', array('conditions' => array('User.id' => $invit['UserInvitation']['user_id']), 'fields' => array('User.id', 'User.name', 'User.email', 'User.password', 'User.timezone_id', 'User.short_name', 'User.last_name', 'User.ip', 'User.dt_created', 'User.dt_last_login')));
                    $new_array = array();
                    $new_array['User'] = $inviteduser['User'];
                    if (!$new_array['User']['timezone_id']) {
                        $new_array['User']['timezone_id'] = $this->Auth->User('timezone_id');
                    }
                    if ($invit['UserInvitation']['is_active'] == 1) {
                        $new_array['User']['pid'] = $invit['UserInvitation']['project_id'];
                    }
                    if (!$new_array['User']['password'] && !$new_array['User']['dt_last_login']) {
                        $resp = $this->newInviteUserProcess($new_array, 'old');
                        $resp_temp = explode('___', $resp);
                        $this->set('password', $resp_temp[1]);
                    } else {
                        $resp = $this->newInviteUserProcess($new_array, 'resend');
                        $resp_temp = explode('___', $resp);
                        $this->set('password', $resp_temp[1]);
                    }

                    //Below one line Added for the new invite user functionality
                    if (!$new_array['User']['password'] && !$new_array['User']['dt_last_login']) {
                        $invit['UserInvitation']['is_active'] = 0;
                    }
                    if ($UserInvitation->save($invit)) {
                        $comp_dtl = ClassRegistry::init('CompanyUser')->find('first', array('conditions' => array('CompanyUser.user_id' => $invit['UserInvitation']['user_id'], 'CompanyUser.company_id' => $invit['UserInvitation']['company_id'], 'CompanyUser.user_type' => $invit['UserInvitation']['user_type']), 'fields' => array('CompanyUser.id')));
                        if ($comp_dtl) {
                            $CompanyUser = ClassRegistry::init('CompanyUser');
                            $cmpnyUsr['CompanyUser']['id'] = $comp_dtl['CompanyUser']['id'];
                            $cmpnyUsr['CompanyUser']['is_active'] = 1;
                            if ($comp_dtl && $comp_dtl['CompanyUser']['is_active'] == 2) {
                                $cmpnyUsr['CompanyUser']['act_date'] = GMT_DATETIME;
                            }
                            $CompanyUser->save($cmpnyUsr);
                        }
                    }

                    $to = $inviteduser['User']['email'];
                    if ($inviteduser['User']['name']) {
                        $expName = $inviteduser['User']['name'];
                    } else {
                        $expEmail = explode("@", $inviteduser['User']['email']);
                        $expName = $expEmail[0];
                    }
                    $loggedin_users = $this->Format->getUserNameForEmail($this->Auth->User("id"));
                    $fromName = ucfirst($loggedin_users['User']['name']);
                    $fromEmail = $loggedin_users['User']['email'];

                    $Company = ClassRegistry::init('Company');
                    $comp = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('Company.id', 'Company.name', 'Company.uniq_id')));

                    $subject = $fromName . " added you to " . $comp['Company']['name'] . " on Orangescrum";

                    $uEmail = $this->User->getLoginUserEmail(SES_ID);
                    $this->Email->delivery = 'smtp';
                    $this->Email->to = $to;
                    $this->Email->subject = $subject;
						$this->Email->from = FROM_EMAIL;//!empty($uEmail['User']['email']) ? $uEmail['User']['email'] : FROM_EMAIL;
                    $this->Email->template = 'invite_user';
                    $this->Email->sendAs = 'html';
                    $this->set('expName', ucfirst($expName));
                    $this->set('qstr', $qstr);
                    if ($inviteduser['User']['password'] && $inviteduser['User']['dt_last_login']) {
                        $this->set('existing_user', 1);
                    } else {
                        $this->set('existing_user', 0);
                    }
                    $this->set('company_name', $comp['Company']['name']);
                    $this->set('fromEmail', $fromEmail);
                    $this->set('fromName', $fromName);

                    $this->set('email', $to);


                    try {
						if(defined("PHPMAILER") && PHPMAILER == 1){
							$this->Email->set_variables = $this->render('/Emails/html/invite_user',false);
							if($this->PhpMailer->sendPhpMailerTemplate($this->Email)){
								$arr['msg'] = 'succ';
								$arr['qstr'] = $qstr;
								echo json_encode($arr);
								exit;
							} else {
								$arr['msg'] = 'err';
								$arr['type'] = 'Mail not sent';
								echo json_encode($arr);
								exit;
							}
						}else{
                        if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                            $arr['msg'] = 'succ';
                            $arr['qstr'] = $qstr;
                            echo json_encode($arr);
                            exit;
                        } else {
                            $arr['msg'] = 'err';
                            $arr['type'] = 'Mail not sent';
                            echo json_encode($arr);
                            exit;
                        }
						}
                    } Catch (Exception $e) {
                        
                    }
                } else {
                    $arr['msg'] = 'err';
                    $arr['type'] = 'datasave_err';
                    echo json_encode($arr);
                    exit;
                }
            } else {
                $arr['msg'] = 'err';
                $arr['type'] = 'Wrong query string';
                echo json_encode($arr);
                exit;
            }
        } else {
            $arr['msg'] = 'err';
            $arr['type'] = 'Not Allowed';
            echo json_encode($arr);
            exit;
        }
    }

    /**
     * @method: public onbording_inviteuser($paramName) On-Bording for inviting an user to project
     * @author GDR<>
     * @return HTML Description
     */
    function onbording_inviteuser() {
        
    }
    /**
      Show Preview of Profile Image
     */
    function show_preview_img() {
        $this->layout = 'ajax';
        //sleep(20);
        if (!empty($this->params->data['User']['photo']['name'])) {
            $size = $this->params->data['User']['photo']['size'];
            $sizeinkb = $size / 1024;

            $name = $this->params->data['User']['photo']['name'];
            $tmp_name = $this->params->data['User']['photo']['tmp_name'];

            $type = $this->params->data['User']['photo']['type'];

            $file_path = WWW_ROOT . 'files/profile/orig/';

            $newFileName = "";
            $updateData = "";
            $message = "success";
            $displayname = "";
            //$allowedSize = MAX_FILE_SIZE*1024;
            //move_uploaded_file($tmp_name,$file_path.$name);
            //$newFileName = $name;

            $newFileName = $this->Format->showuploadImage($tmp_name, $name, $size, $file_path, SES_ID);
            if ($newFileName == 'small size image') {
                echo '{"message":"' . $newFileName . '"}';
            } else {
                if (defined('USE_S3') && USE_S3 == 1) {
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putObjectFile(WWW_ROOT . 'files/profile/orig/' . $newFileName, BUCKET_NAME, DIR_USER_PHOTOS_TEMP . $newFileName, S3::ACL_PRIVATE);
                }
                $res_array = array(
                    "name" => $displayname,
                    "sizeinkb" => $sizeinkb,
                    "filepath" => $file_path,
                    "filename" => $newFileName,
                    "message" => $message
                );
                echo json_encode($res_array);
                //echo '{"name":"'.$displayname.'","sizeinkb":"'.$sizeinkb.'","filepath":"'.$file_path.'","filename":"'.$newFileName.'","message":"'.$message.'"}';
            }
            exit;
        }
    }

    function done_cropimage() {
        $this->layout = 'ajax';
        if (!empty($this->params->data['width']) && !empty($this->params->data['height'])) {
            $valid_exts = array('jpeg', 'jpg', 'png', 'gif');
            $max_file_size = 100 * 1024; #200kb
            $nw = $nh = 100; # image with & height
            $imgName = HTTP_ROOT . 'files/profile/' . $this->params->data['imgName'];
            $imgthumbSrc = "";
            if (isset($imgName)) {
                # grab data form post request
                $x = (int) $this->params->data['x-cord'];
                $y = (int) $this->params->data['y-cord'];
                $w = (int) $this->params->data['width'];
                $h = (int) $this->params->data['height'];
                if (defined('USE_S3') && USE_S3 == 1) {
                    $imgSrc = $this->Format->generateTemporaryURL(DIR_USER_PHOTOS_S3_TEMP . $this->params->data['imgName']);
                } else {
                    $imgSrc = WWW_ROOT . 'files/profile/orig/' . $this->params->data['imgName'];
                }
                //getting the image dimensions
                list($width, $height) = getimagesize($imgSrc);
                //saving the image into memory (for manipulation with GD Library)
                $type = exif_imagetype($imgSrc);
                switch ($type) {
                    case 1 :
                        $myImage = imagecreatefromgif($imgSrc);
                        break;
                    case 2 :
                        $myImage = imagecreatefromjpeg($imgSrc);
                        break;
                    case 3 :
                        $myImage = imagecreatefrompng($imgSrc);
                        break;
                    case 6 :
                        $myImage = imagecreatefromwbmp($imgSrc);
                        break;
                    default:
                        $src = imagecreatefromjpeg($imgSrc);
                        break;
                }

                // calculating the part of the image to use for thumbnail
                /* if ($width > $height) {
                  $y = 0;
                  $x = ($width - $height) / 2;
                  $smallestSide = $height;
                  } else {
                  $x = 0;
                  $y = 0;
                  // $y = ($height - $width) / 2;
                  $smallestSide = $width;
                  } */



                // copying the part into thumbnail
                $thumbSize = 120;
                $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
                imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $w, $h);
                /* # read image binary data
                  $data = file_get_contents($imgName);
                  # create v image form binary data
                  $vImg = imagecreatefromstring($data);
                  $dstImg = imagecreatetruecolor($nw, $nh);
                  # copy image
                  imagecopyresampled($dstImg, $vImg, 0, 0, $x, $y, $nw, $nh, $w, $h);
                  # save image
                  imagejpeg($dstImg, $path); */
                //Imagejpeg($thumb, $path);
                $imgthumbNm = $this->params->data['imgName'];
                $imgthumbSrc = DIR_USER_PHOTOS . $imgthumbNm;
                try {
                    switch ($type) {
                        case 1 :
                            imagegif($thumb, $imgthumbSrc);
                            break;
                        case 2 :
                            imagejpeg($thumb, $imgthumbSrc);
                            break;
                        case 3 :
                            imagepng($thumb, $imgthumbSrc);
                            break;
                        case 6 :
                            imagewbmp($thumb, $imgthumbSrc);
                            break;
                        default:
                            imagejpeg($thumb, $imgthumbSrc);
                            break;
                    }
                    imagedestroy($src);
                    imagedestroy($thumb);
                } catch (Exception $e) {
                    return false;
                }
                if (defined('USE_S3') && USE_S3 == 1) {
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putObjectFile(DIR_USER_PHOTOS . $imgthumbNm, BUCKET_NAME, DIR_USER_PHOTOS_THUMB . $imgthumbNm, S3::ACL_PRIVATE);
                }
                echo $imgthumbNm;
            } else {
                echo 'file not set';
            }
        }
        exit;
    }

    function email_notifications() {
        $UserNotification = ClassRegistry::init('UserNotification');
        $getAllNot = $UserNotification->find('first', array('conditions' => array('UserNotification.user_id' => SES_ID)));
        $this->set('getAllNot', $getAllNot);
        if ($this->request->data) {
            $this->request->data['User']['id'] = SES_ID;
            if (!isset($this->request->data['User']['desk_notify'])) {
                $this->request->data['User']['desk_notify'] = 0;
            }
            $this->User->save($this->request->data['User']);
            if (isset($this->request->data['UserNotification'])) {
                $this->request->data['UserNotification']['user_id'] = SES_ID;
                $this->request->data['UserNotification']['id'] = $getAllNot['UserNotification']['id'];
                $UserNotification->save($this->request->data['UserNotification']);
            }
                $this->Session->write("SUCCESS", __("Notifications changed successfully",true));
            $this->redirect(HTTP_ROOT . "users/email_notifications");
        }
    }

    function email_reports() {
        $DailyupdateNotification = ClassRegistry::init('DailyupdateNotification');
        $getAllDailyupdateNot = $DailyupdateNotification->find('first', array('conditions' => array('DailyupdateNotification.user_id' => SES_ID, 'company_id' => SES_COMP)));
        #echo "<pre>".SES_ID."---".SES_COMP; print_r($getAllDailyupdateNot);exit;
        $this->set('getAllDailyupdateNot', $getAllDailyupdateNot);
        $UserNotification = ClassRegistry::init('UserNotification');
        $getAllNot = $UserNotification->find('first', array('conditions' => array('UserNotification.user_id' => SES_ID)));
        $this->set('getAllNot', $getAllNot);
        if ($this->request->data) {

            if (isset($this->request->data['UserNotification'])) {
                $this->request->data['UserNotification']['user_id'] = SES_ID;
                $this->request->data['UserNotification']['id'] = $getAllNot['UserNotification']['id'];
                $UserNotification->save($this->request->data['UserNotification']);
            }
            if (isset($this->request->data['DailyupdateNotification'])) {
                $data['DailyupdateNotification']['id'] = $getAllDailyupdateNot['DailyupdateNotification']['id'];
                $data['DailyupdateNotification']['user_id'] = SES_ID;
                $data['DailyupdateNotification']['status'] = 0;
                if ($this->request->data['DailyupdateNotification']['dly_update'] == 1) {
                    $data['DailyupdateNotification']['dly_update'] = 1;
                    $data['DailyupdateNotification']['notification_time'] = $this->request->data['DailyupdateNotification']['not_hr'] . ':' . $this->request->data['DailyupdateNotification']['not_mn'];
                    $comma_separated = implode(",", $this->request->data['DailyupdateNotification']['proj_name']);
                    $data['DailyupdateNotification']['proj_name'] = trim($comma_separated, ',');
                } else {
                    $data['DailyupdateNotification']['dly_update'] = 0;
                    $data['DailyupdateNotification']['notification_time'] = '';
                    $data['DailyupdateNotification']['proj_name'] = '';
                }
                $data['DailyupdateNotification']['company_id'] = SES_COMP;
                $DailyupdateNotification->save($data['DailyupdateNotification']);
            }
                $this->Session->write("SUCCESS", __("Reports changed successfully",true));
            $this->redirect(HTTP_ROOT . "users/email_reports");
        }
    }

    function mycompany() {
        if (SES_TYPE == 3) {
            $this->redirect(HTTP_ROOT . "dashboard");
        }
        $Company = ClassRegistry::init('Company');
        $Company->recursive = -1;
			$getCompany = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP)));
            $this->set('getCompany', $getCompany);

        if (isset($this->request->data['Company'])) {
            $this->request->data['Company']['logo'] = $this->request->data['Company']['exst_logo'];
            unset($this->request->data['Company']['exst_logo']);

            if (trim($this->request->data['Company']['name']) == "") {
                    $this->Session->write("ERROR", __("Name cannot be left blank",true));
                $this->redirect(HTTP_ROOT . "users/mycompany");
            } else {
                $this->request->data['Company']['id'] = SES_COMP;
					if(isset($this->request->data['Company']['seo_url'])){
						unset($this->request->data['Company']['seo_url']);
					}
                $ret = $Company->save($this->request->data);
                if (!$ret) {
                        $this->Session->write("ERROR", __("Invalid company name",true));
                } else {
                        $this->Session->write("SUCCESS", __("Company updated successfully",true));
                }
                $this->redirect(HTTP_ROOT . "users/mycompany");
            }
        }
        $getCompany = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP)));
        $this->set('getCompany', $getCompany);
    }

//	function importexport(){
//		
//	}
    function cancelact() {
        
    }

    function actactivity() {
        
    }

    function milestone() {
        
    }

    function analytics() {
        
    }

    function check_password() {
        $pass = $this->data['password'];
        if (SES_ID) {
            $userinfo = $this->User->find('first', array('conditions' => array('User.id' => SES_ID)));
            if ($userinfo['User']['password']) {
                if ($userinfo['User']['password'] == md5($pass)) {
                    echo 1;
                    exit;
                } else {
                    echo "Wrong password entered.";
                    exit;
                }
            } else if ($userinfo['User']['password'] == '' && $pass == '') {
                echo 1;
                exit;
            }
        } else {
            echo "You are not allowed to do this activity";
            exit;
        }
    }

    /**
     * @method: Public validate_emailurl() Check if inputed email exsists or not same with the Subdomain for a company
     * @author GDR<>
     * @return json data
     */
    function validate_emailurl() {
        $this->layout = 'ajax';
        $data = $this->User->validate_emailurl($this->data);
        echo json_encode($data);
        exit;
    }

    function user_twitted($tweetac = '') {
        $this->layout = 'ajax';
        $data = '';
        $status = 0;

        if ($tweetac == 'pluntw') {
            if (SITE_NAME != 'Orangescrum.com') {
                $this->loadModel('Company');
                $this->Company->query('UPDATE companies SET twitted =0');
            }
            $message = 'Done';
        } else if (!defined('SES_COMP') || !SES_COMP) {
            $message = 'Wo! what are you doing here! This can not be possible.';
        } elseif ($tweetac == 'tweeted' && ((SES_TYPE == 1 || SES_TYPE == 2) && defined('TWITTED') && TWITTED == 0)) {
            $this->loadModel('Company');
            $this->loadModel('UserSubscription');
            $this->UserSubscription->bindModel(array(
                'belongsTo' => array(
                    'Company' => array(
                        'className' => 'Company',
                        'foreignKey' => 'company_id'
                    )
                )
                    ), false);

            $getComp = $this->UserSubscription->find('first', array(
                'conditions' => array('UserSubscription.company_id' => SES_COMP, 'Company.twitted' => 0),
                'fields' => array('UserSubscription.id', 'UserSubscription.project_limit', 'UserSubscription.storage', 'UserSubscription.is_free'),
                'order' => array('UserSubscription.created desc')
                    )
            );

            if ($getComp) {
                $getComp['Company']['id'] = SES_COMP;
                $getComp['Company']['twitted'] = 1;
                if ($getComp['UserSubscription']['is_free'] == 0) {
                    if ($getComp['UserSubscription']['project_limit'] != 'Unlimited') {
                        $getComp['UserSubscription']['project_limit'] += 1;
                    }
                    if ($getComp['UserSubscription']['storage'] != 'Unlimited') {
                        $getComp['UserSubscription']['storage'] += 30;
                    }
                }
                if ($this->UserSubscription->saveAll($getComp)) {
                    $data = array('project_limit' => $getComp['UserSubscription']['project_limit'], 'storage' => $getComp['UserSubscription']['storage']);
                    $status = '1';
                    $message = 'success';
                } else {
                    $message = 'fail';
                }
            } else {
                $message = 'fail';
            }
        } else {
            $message = 'Wo! what are you doing here! Unauthorize access!';
        }
        $this->set('message', array('data' => $data, 'message' => $message, 'status' => $status));
    }

    function ajax_assignedproject_delete() {
        $this->layout = 'ajax';
        if (!empty($this->params->data['id']) && !empty($this->params->data['userId'])) {
            $this->loadModel('ProjectUser');
            $this->loadModel('UserInvitation');
            if (isset($this->params->data['isInvite']) && $this->params->data['isInvite'] == 1) {
                $inviteuser = $this->UserInvitation->query("SELECT user_invitations.project_id FROM user_invitations,users WHERE user_invitations.user_id IN (" . $this->params->data['userId'] . ") AND user_invitations.user_id = users.id AND user_invitations.company_id='" . SES_COMP . "' LIMIT 1");
                if (isset($inviteuser) && !empty($inviteuser['0']['user_invitations']['project_id'])) {
                    $project_id = explode(",", $inviteuser['0']['user_invitations']['project_id']);
                    if (isset($this->request->data['id']) && $this->request->data['id']) {
                        if (in_array($this->request->data['id'], $project_id)) {
                            unset($project_id[array_search($this->request->data['id'], $project_id)]);
                        }
                        $prjId = implode(",", $project_id);
                        $this->UserInvitation->query("Update user_invitations SET project_id='" . $prjId . "' WHERE user_id='" . $this->params->data['userId'] . "'");
                        echo json_encode(array("message" => "success"));
                        exit;
                    } else {
                        echo json_encode(array("message" => "error"));
                        exit;
                    }
                }
            } else {
                $projectUsers = $this->ProjectUser->find('first', array('conditions' => array('ProjectUser.project_id' => $this->params->data['id'], 'ProjectUser.user_id' => $this->params->data['userId'], 'ProjectUser.company_id' => SES_COMP), 'fields' => array('ProjectUser.id')));
                if (!empty($projectUsers) && !empty($projectUsers['ProjectUser']['id'])) {
                    $this->ProjectUser->id = $projectUsers['ProjectUser']['id'];
                    $res = $this->ProjectUser->delete();
                    if ($res) {
                        echo json_encode(array("message" => "success"));
                    } else {
                        echo json_encode(array("message" => "error"));
                    }
                } else {
                    echo json_encode(array("message" => "error"));
                }
            }
        }
        exit;
    }

    function generateMsgAndSendUsMail($pjnames, $userid, $projUniqId, $comp) {
        $User_id = $this->Auth->user('id');
        $this->loadModel('User');
        $rec = $this->User->findById($User_id);
        $from_name = $rec['User']['name'] . ' ' . $rec['User']['last_name'];

        App::import('helper', 'Casequery');
        $csQuery = new CasequeryHelper(new View(null));

        App::import('helper', 'Format');
        $frmtHlpr = new FormatHelper(new View(null));

        ##### get User Details
        $toUsrArr = $csQuery->getUserDtls($userid);
        $to = "";
        $to_name = "";
        if (count($toUsrArr)) {
            $to = $toUsrArr['User']['email'];
            $to_name = $frmtHlpr->formatText($toUsrArr['User']['name']);
        }

        $multiple = 0;
        if (stristr($pjnames, ",")) {
            $multiple = 1;
            $subject = "You have been added to multiple projects on Orangescrum";
        } else {
            $subject = "You have been added to " . $pjnames . " on Orangescrum";
        }

        $this->Email->delivery = 'smtp';
        $this->Email->to = $to;
        $this->Email->subject = $subject;
        $this->Email->from = FROM_EMAIL_EC_NOTIFY;
        $this->Email->template = 'project_add';
        $this->Email->sendAs = 'html';
        $this->set('to_name', $to_name);
        $this->set('projName', $pjnames);
        $this->set('projUniqId', $projUniqId);
        $this->set('multiple', $multiple);
        $this->set('company_name', $comp['Company']['name']);
        $this->set('from_name', $from_name);
		if(defined("PHPMAILER") && PHPMAILER == 1){
			$this->Email->set_variables = $this->render('/Emails/html/project_add',false);
			if($this->PhpMailer->sendPhpMailerTemplate($this->Email)){
				return true;
			}else{return true;}
		}else{		
        return $this->Sendgrid->sendgridsmtp($this->Email);
    }
    }

    function getting_started() {
			if(isset($_COOKIE['FIRST_LOGIN_1']) && $_COOKIE['FIRST_LOGIN_1']==1 && $GLOBALS['project_count'] ==0){
			setcookie('FIRST_LOGIN_1', 1, time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
            $this->redirect(HTTP_ROOT.'users/onBoard');exit;
			}else{
        $id = $this->Auth->user('id');
        $this->loadModel('UserInvitation');
        $this->loadModel('Project');
        $this->loadModel('Easycase');
        $this->loadModel('TypeCompany');
        $this->loadModel('UserNotification');
        $projects = $this->Project->findByUserId($id);
        $invitations = $this->UserInvitation->findByInvitorId($id);
        $tasks = $this->Easycase->findByUserId($id);
        $types = $this->TypeCompany->query("SELECT TypeCompany.id from type_companies AS TypeCompany WHERE TypeCompany.company_id=" . SES_COMP . " AND TypeCompany.type_id > 12");
        $notifications = $this->UserNotification->query("SELECT UserNotification.id from user_notifications AS UserNotification WHERE UserNotification.user_id=" . SES_ID . " AND (UserNotification.new_case != 0 OR UserNotification.reply_case != 0 OR UserNotification.case_status != 0)");
        if (isset($this->request->query['first_login'])) {
            $this->set('first_login', $this->request->query['first_login']);
        }
        $this->set(compact('projects', 'invitations', 'tasks', 'types', 'notifications'));
    }
        }
        function onBoard(){			
            if(isset($this->request->data['taskviewval']) && !empty($this->request->data['taskviewval'])){
            $this->loadModel('DefaultTaskView');
            $data = array();
                $id = $this->DefaultTaskView->find('first', array('conditions' => array('DefaultTaskView.company_id' => SES_COMP, 'DefaultTaskView.user_id' => SES_ID), 'fields' => array('DefaultTaskView.id')));
            $data['DefaultTaskView']['company_id'] = SES_COMP;
            $data['DefaultTaskView']['user_id'] = SES_ID;
                $data['DefaultTaskView']['default_view_id'] = $this->request->data['taskviewval'];
            $data['DefaultTaskView']['created'] = GMT_DATETIME;
            $data['DefaultTaskView']['modified'] = GMT_DATETIME;
                if(isset($id['DefaultTaskView']['id']) && !empty($id['DefaultTaskView']['id'])){
                    $data['DefaultTaskView']['id'] = $id['DefaultTaskView']['id'];
                }else{
                    $this->DefaultTaskView->id = '';
                }
                $this->DefaultTaskView->save($data);
                echo 1;exit;
            }
            if(isset($this->request->data['projectview']) && !empty($this->request->data['projectview'])){
                $this->loadModel('DefaultTaskView');
                $data = array();
                $id = $this->DefaultTaskView->find('first', array('conditions' => array('DefaultTaskView.company_id' => SES_COMP, 'DefaultTaskView.user_id' => SES_ID), 'fields' => array('DefaultTaskView.id')));
                $data['DefaultTaskView']['company_id'] = SES_COMP;
                $data['DefaultTaskView']['user_id'] = SES_ID;
                $data['DefaultTaskView']['default_view_id'] = $this->request->data['projectview'];
            $data['DefaultTaskView']['created'] = GMT_DATETIME;
            $data['DefaultTaskView']['modified'] = GMT_DATETIME;
            //setcookie('FIRST_DISPLAY_LIST', $this->request->data['defaulttaskview'], time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                if(isset($id['DefaultTaskView']['id']) && !empty($id['DefaultTaskView']['id'])){
                    $data['DefaultTaskView']['id'] = $id['DefaultTaskView']['id'];
                }else{
            $this->DefaultTaskView->id = '';
                }
            $this->DefaultTaskView->save($data);
            echo 1;exit;
            }
            //Check PRB
			      if(isset($this->request->data['projectmethodology']) && !empty($this->request->data['projectmethodology'])){
                $_SESSION['projectmethodology'] = $this->request->data['projectmethodology'];
            echo 1;exit;
            }
            if(isset($_COOKIE['FIRST_LOGIN_1']) && $_COOKIE['FIRST_LOGIN_1']==1 && $GLOBALS['project_count'] ==0){
               setcookie('FIRST_LOGIN_1', '', -1, '/', DOMAIN_COOKIE, false, false);
               setcookie('FIRST_INVITE_2', '1', time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
               setcookie('FIRST_INVITE_1', '0', time() - 60000, '/', DOMAIN_COOKIE, false, false);
			   
               $this->layout="no_header_footer";
               $this->loadModel('TimezoneName');
               $timezones = $this->TimezoneName->find('all');
               $this->set('timezones', $timezones);
               $user=$this->User->find('first',array('conditions'=>array('User.id'=>SES_ID)));
               $this->set('user',$user); 
               $this->loadModel('TaskView');
            $task_views = $this->TaskView->find('list', array('conditions' => array('TaskView.name' => 'Task'), 'fields' => array('TaskView.id', 'TaskView.sub_name')));
            $this->set('task_views', $task_views);
            $timelog_views = $this->TaskView->find('list', array('conditions' => array('TaskView.name' => 'Timelog'), 'fields' => array('TaskView.id', 'TaskView.sub_name')));
            $this->set('timelog_views', $timelog_views);
            $kanban_views = $this->TaskView->find('list', array('conditions' => array('TaskView.name' => 'Kanban'), 'fields' => array('TaskView.id', 'TaskView.sub_name')));
            $this->set('kanban_views', $kanban_views);
            $project_views = $this->TaskView->find('list', array('conditions' => array('TaskView.name' => 'Project'), 'fields' => array('TaskView.id', 'TaskView.sub_name')));
            foreach($project_views as $k=>$v){
              $project_views[$k] = $v." View";  
            }
            $this->set('project_views', $project_views);
               
            $def_views = $this->TaskView->find('list', array('conditions' => array('TaskView.name' => 'Default task view','TaskView.id'=>array(10,11)), 'fields' => array('TaskView.id', 'TaskView.sub_name')));

            $this->set('def_views', $def_views);
               $taskview = 1; // Default (task group)
               $kanbanview = 7; // Default (task status)
               $timelogview = 5; // Default (calendar)
               $projectview = 8; // Default (card)
               $defview = 10; // Default (List View)
               $projectmethodology = 1; // Default (List View)
                
                $this->set('taskview', $taskview);
                $this->set('kanbanview', $kanbanview);
                $this->set('timelogview', $timelogview);
                $this->set('projectview', $projectview);
                $this->set('projectmethodology', $projectmethodology);
                $this->set('defview', $defview);
            }else{
                 $this->redirect(HTTP_ROOT."dashboard#/".DEFAULT_TASKVIEW);
            }
            $this->loadModel('ProjectMethodology');
            $pm1 = $this->ProjectMethodology->find('all',array('order'=>array('id'=>'ASC')));
						$pm = array();
            foreach($pm1 as $k=>$v){
            	$pm[$v['ProjectMethodology']['id']] =$v; 
            }            
            $this->set('pm',$pm);
            $pmF = reset($pm);
            $this->set('pmF',$pmF);

            //pr($pm);exit;
        }
		function checkprojectcounts(){
			$this->loadModel('Project');
			$projects = $this->Project->find('all',array('conditions'=>array("Project.company_id"=>SES_COMP)));
			echo json_encode(array("count"=>count($projects)));exit;
		}
        function saveUserData(){
            $this->layout='ajax';
            $msg=array();            
                    $uid =  SES_ID;
//            $this->request->data['photo']='464d7975fe35eece325e524a65699cdb.png';
            if (isset($this->request->data['photo']) && !empty($this->request->data['photo'])) {
					 if (!empty($this->request->data['photo'])) {
                        $checkProfPhoto = $this->User->find('first', array('conditions' => array('id' => $uid),'fields'=>array('User.photo')));
                        if (!empty($checkProfPhoto) && !empty($checkProfPhoto['User'])) {
                            if (defined('USE_S3') && USE_S3) {
								$s3 = new S3(awsAccessKey, awsSecretKey);
                                $s3->deleteObject(BUCKET_NAME, DIR_USER_PHOTOS_S3_FOLDER . $checkProfPhoto['User']['photo']);
                            } else {
                                unlink(DIR_USER_PHOTOS . $checkProfPhoto['User']['photo']);
                            }
                        }
                    }
                    $photo_name = $this->Format->uploadProfilePhoto($this->request->data['photo'], DIR_USER_PHOTOS); 
                    $msg['file_name']= HTTP_ROOT.'users/image_thumb/?type=photos&file='.$this->request->data['photo'].'&sizex=100&sizey=100&quality=100';
                    if ($photo_name == "ext") {
                           $msg['error'] = __("Oops! Invalid file format! The formats supported are gif, jpg, jpeg & png.");                           
                    } elseif ($photo_name == "size") {
                           $msg['error'] = __("Profile photo size cannot excceed 1mb");
                    }else{
                        $this->User->id=$uid;
                        $this->User->saveField('photo',$this->request->data['photo']);
                    }
                }
                if (isset($this->request->data['language']) && !empty($this->request->data['language'])) {
                    $this->User->id=$uid;
                    $this->User->saveField('language',$this->request->data['language']);
                    $this->Session->write('Config.language', $this->request->data['language']);
                }
                if (isset($this->request->data['timezone']) && !empty($this->request->data['timezone'])) {
                    $this->User->id=$uid;
                    $this->User->saveField('timezone_id',$this->request->data['timezone']);
                }
                if (isset($this->request->data['fname']) && !empty($this->request->data['fname'])) {
                    $this->User->id=$uid;
                    $this->User->saveField('name',$this->request->data['fname']);
                }
                print json_encode($msg);
            exit;
        }
        public function onBoardInvites(){
            if(isset($_COOKIE['FIRST_PROJECT_1']) && !empty($_COOKIE['FIRST_PROJECT_1'])){
                $this->layout="no_header_footer";
                $pid=$_COOKIE['FIRST_PROJECT_1'];
                setcookie('FIRST_PROJECT_1', '', -1, '/', DOMAIN_COOKIE, false, false);
                $this->loadModel('Project');
                $projects = $this->Project->find('first',array('conditions'=>array("Project.id"=>$pid)));
                $this->set('projects',$projects);
                $u=$this->User->find('first',array('conditions'=>array('User.id'=> SES_ID),'fields'=>array('User.uniq_id')));
                $this->set('u',$u);
            }else{
              $this->redirect(HTTP_ROOT.'dashboard');  
            }
        }

    public function send_to_sukinda($name, $email, $ip, $plan_id, $free_trial_month, $amount) {
        $arr['name'] = $name;
        $arr['email'] = $email;
        $arr['ip'] = $ip;
        $arr['plan_id'] = $plan_id;
        $arr['free_trial_month'] = $free_trial_month;
        $arr['amount'] = $amount;
        $all_free_plan = Configure::read('ALL_FREE_PLANS');
        if (in_array($plan_id, $all_free_plan)) {
            $arr['type'] = 'Free';
            $arr['free_trial_month'] = 0;
        } else {
            $arr['type'] = 'Paid';
            $arr['free_trial_month'] = $free_trial_month;
        }
        $arr['company_id'] = 723534341;
        $arr['affiliated_code'] = $_COOKIE["affiliated_code"];
        // $postQueryString=http_build_query($arr);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.sukinda.com/users/saveData');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);
//        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        if (curl_exec($ch) === false) {
            $file = fopen(WWW_ROOT . "curl.log", "a");
            fwrite($file, curl_error($ch) . "\n");
            fclose($file);
        }
        setcookie("affiliated_code", '', time() - 7776000, "/");
        $data = curl_getinfo($ch);
        curl_close($ch);
    }

    public function request_demo($type = NULL) {
        if ($this->request->is('post')) {
            $this->loadModel('DemoRequest');
            $this->DemoRequest->create();
            $this->loadModel('Timezone');
            /* $this->Timezone->create();	    
              $tz = $this->Timezone->find('list',array('fields'=>array('gmt_offset','id')));
              $this->request->data['DemoRequest']['timezone_id'] = $tz[$this->request->data['DemoRequest']['timezone_id']]; */
            if ($this->DemoRequest->save($this->request->data)) {
                $this->send_mail_to_admin($this->request->data);
                return $this->redirect(HTTPS_HOME . "demo/success");
            } else {
                return $this->redirect(HTTPS_HOME . "demo");
            }
        }
        $this->set("type", $type);
    }

    public function send_mail_to_admin($data) {

    }

    public function saveUserInfo($user_id, $access_token, $is_signup) {
        $this->loadModel('UserInfo');
        $user_info = $this->UserInfo->findByUserId($user_id);
        if (empty($user_info)) {
            $arr['user_id'] = $user_id;
            $arr['access_token'] = $access_token;
            $arr['is_google_signup'] = $is_signup;
            $this->UserInfo->save($arr);
        }
    }

    public function resend_confemail() {
        $user_ses = $this->Session->read();
        $getUsrData = $this->User->findById($user_ses['Auth']['User']['id']);
        $to = $getUsrData['User']['email'];
        $from = FROM_EMAIL;
        $subject = "Orangescrum Account Confirmation";
        $CompanyUser = ClassRegistry::init('CompanyUser');
        $checkCmnpyUsr = $CompanyUser->find('first', array('conditions' => array('CompanyUser.user_id' => $this->Auth->User("id"), 'CompanyUser.is_active' => 1), 'fields' => array('CompanyUser.company_id')));
        $cmpid = $checkCmnpyUsr['CompanyUser']['company_id'];
        $Company = ClassRegistry::init('Company');
        $seo = $Company->find('first', array('conditions' => array('Company.id' => $cmpid, 'Company.is_active' => 1), 'fields' => array('Company.seo_url')));
        $activation_url = HTTP_ROOT . "users/confirmation/" . $getUsrData['User']['verify_string'];
        $web_address = HTTP_ROOT;
        $this->Email->delivery = 'smtp';
        $this->Email->to = $to;
        $this->Email->subject = $subject;
        $this->Email->from = $from;
        $this->Email->template = 'email_activation';
        $this->Email->sendAs = 'html';
        $this->set('activation_url', $activation_url);
        $this->set('usrname', ucfirst($getUsrData['User']['name']));
		if(defined("PHPMAILER") && PHPMAILER == 1){
			$this->Email->set_variables = $this->render('/Emails/html/email_activation',false);
			$this->PhpMailer->sendPhpMailerTemplate($this->Email);
		}else{
        $this->Sendgrid->sendgridsmtp($this->Email);
		}
        $this->Session->write("SUCCESS", "Confirmation email send successfully.<br />A confirmation link has been sent to '{$to}'.");
        $this->redirect($this->referer());
    }

    /*
     * by GKM
     * to upload company logo
     */

    function companyLogo() {
        #pr($this->request);exit;
        if (defined('USE_S3') && USE_S3 == 1) {
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $s3->putBucket(BUCKET_NAME, S3::ACL_PRIVATE);
        }
        $p = $this->request->data['Company']['logo'];
        $id = key($p['name']);
        $rep = array("'", " ", "?", "%", "&", "$", ",", "@");
        $repw = array("", "-", "", "", "", "", "", "");
        if ($p['name'] != "") {
            if ($p['size'] <= 2000000) {
                    $oldname = $this->Format->chnageUploadedFileName($p['name']);
                    $ext1 = substr(strrchr($oldname, "."), 1);
                    if (mb_detect_encoding($p['name'], mb_detect_order(), true) == 'UTF-8') {
                        $n_num = $this->Format->generateUniqNumber();
                        $oldname = $n_num . '.' . $ext1;
                    }
                    #$ext1 = $ext1 == 'tif' ? 'png' : $ext1;
						$message = $this->Format->validateFileExt($ext1, 1);
						/*$ty = fopen('wowowo.txt','a');
                    fwrite($ty,$message.'---'.$ext1.'---'.$oldname);
						fclose($ty);*/
                    if ($message == "success") {
                $s1 = time();
                    $realname = $oldname;
                $realname = str_replace($rep, $repw, $realname);
                $realname = $s1 . "_" . $realname;
                $newname = $realname;

                /* saving to s3 invoice */
                if (defined('USE_S3') && USE_S3 == 1) {
                    $folder_orig_Name = DIR_COMPANY_PHOTOS_S3_FOLDER . SES_COMP . '/' . trim($newname);
                    $s3->putObjectFile($p['tmp_name'], BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
                    $info = $s3->getObjectInfo(BUCKET_NAME, $folder_orig_Name);
                } else {
                    move_uploaded_file($p['tmp_name'], DIR_COMPANY_LOGO . trim($newname));
                }

                $img_name = trim($realname);
                /* save the image name to db while editing invoice */
                $this->loadModel('Company');
                $this->Company->id = SES_COMP;
                $this->Company->saveField('logo', $img_name);

                $view = new View($this);
                $format_helper = $view->loadHelper('Format');
                if (defined('USE_S3') && USE_S3 == 1) {
                    $url = $format_helper->generateTemporaryURL(DIR_COMPANY_PHOTOS_S3 . SES_COMP . '/' . $img_name);
                } else {
                    $url = HTTP_ROOT . 'files/company-logo/' . $img_name;
                }

                $ret_arr = array('msg' => $img_name, 'success' => "yes", 'url' => $url);
            } else {
							$ret_arr = array('msg' => "Supports only jpeg, jpg and png image.", 'success' => "no");
                }
                } else {
                $ret_arr = array('msg' => "exceeds", 'success' => "no");
            }
        } else {
            $ret_arr = array('msg' => "Please select an image.", 'success' => "no");
        }
        echo json_encode($ret_arr);
        exit;
    }

    /*
     * by GKM
     * to delete company logo
     */

    function deleteCompanyLogo() {
        if (SES_COMP > 0) {
            /* save the image name to db while editing invoice */
            $this->loadModel('Company');
				$compdetl = $this->Company->find('first', array('conditions' => array('Company.id' => SES_COMP)));				
            $this->Company->id = SES_COMP;
                if($compdetl && $this->Company->saveField('logo', '')){
					if($compdetl && !empty($compdetl['Company']['logo'])){
						if (defined('USE_S3') && USE_S3 == 1) {
							try{
							$s3 = new S3(awsAccessKey, awsSecretKey);
							$s3->deleteObject(BUCKET_NAME, DIR_COMPANY_PHOTOS_S3_FOLDER . SES_COMP . '/'.$compdetl['Company']['logo'], S3::ACL_PRIVATE);
							}catch (Exception $e) {}
						} else {
							unlink(DIR_COMPANY_LOGO.$compdetl['Company']['logo']);
						}
					}	
            $ret_arr = array('msg' => "Image deleted successfully.", 'success' => "Yes", 'url' => $url);
        } else {
            $ret_arr = array('msg' => "Image not deleted.", 'success' => "No");
        }
            } else {
                $ret_arr = array('msg' => "Image not deleted.", 'success' => "No");
            }
        echo json_encode($ret_arr);
        exit;
    }

    function updates() {
        $this->loadModel('ProductUpdate');
        if ($this->Auth->User("id")) {
            $this->layout = 'default_inner';
        } else {
            $this->layout = 'default_outer';
        }
        $upds = $this->ProductUpdate->find('all', array('order' => array('ProductUpdate.id' => 'DESC')));
        $this->set('updates', $upds);
    }

    function saveDefaultView() {
        #pr($this->request->data);exit;
        $this->loadModel('DefaultTaskView');
        $data = array();
        $data['DefaultTaskView']['company_id'] = SES_COMP;
        $data['DefaultTaskView']['user_id'] = SES_ID;
        $data['DefaultTaskView']['task_view_id'] = $this->request->data['DefaultView']['taskviews'];
        $data['DefaultTaskView']['timelog_view_id'] = $this->request->data['DefaultView']['timelogview'];
            $data['DefaultTaskView']['kanban_view_id'] = isset($this->request->data['DefaultView']['kanbanview'])?$this->request->data['DefaultView']['kanbanview']:0;
        $data['DefaultTaskView']['project_view_id'] = $this->request->data['DefaultView']['projectview'];
			if(isset($this->request->data['DefaultView']['defaulttaskview'])){
				$data['DefaultTaskView']['default_view_id'] = $this->request->data['DefaultView']['defaulttaskview'];
			}
        $data['DefaultTaskView']['created'] = GMT_DATETIME;
        $data['DefaultTaskView']['modified'] = GMT_DATETIME;
        $this->DefaultTaskView->id = $this->request->data['default_view_id'];
        #pr($data);exit;
        if ($this->DefaultTaskView->save($data)) {
				if ((Cache::read('dtv_detl_'.SES_COMP.'_'.SES_ID)) !== false) {
					Cache::delete('dtv_detl_'.SES_COMP.'_'.SES_ID);
				}
                $this->Session->write("SUCCESS", __("Default Views set successfully.",true));
        } else {
                $this->Session->write("ERROR", __("Default Views can not be set.",true));
        }
        $this->redirect(HTTP_ROOT . 'users/default_view');
    }

    function help_desk() {
        $this->layout = 'ajax';
        $this->loadModel('Help');
        $search = trim(htmlentities(strip_tags($this->request->data['page'])));
            if( $search =='Group Update Alerts'){
                    $conditions = array('OR' => array('Help.subject_id' => 10));
                    $subjects = $this->Help->searchResults($conditions);                
                    $this->set('allRelatedData', $subjects);
            }else{
        $search = $search != 'log time' ? preg_replace('/[\s]+/', '-', preg_replace('/[&]+/', '', strtolower($search))) : $search;
        if (trim($search)) {
            $conditions = array('OR' => array('Help.title LIKE' => '%' . $search . '%'));
            $subjects = $this->Help->searchResults($conditions);
            $this->set('allRelatedData', $subjects);
        }
            }
        if (empty($subjects)) {
            $this->loadModel('Subject');
            $subjects = $this->Subject->find('all', array('order' => array('Subject.seq_odr ASC')));
            $this->set('allSubjectData', $subjects);
        }
    }

    function help_desk_search() {
        $this->layout = 'ajax';
        $this->loadModel('Help');
        $search = trim(htmlentities(strip_tags($this->data['srch_txt'])));
        if (trim($search)) {
            $conditions = array('OR' => array('Help.title LIKE' => '%' . $search . '%', 'Help.description LIKE' => '%' . $search . '%'));
            $getSearchResult = $this->Help->searchResults($conditions);
        }
        $this->set('getSearchResult', $getSearchResult);
    }

    function getphpinfo($inpuy = null) {
            if (SES_COMP == 1 && $inpuy == '7504837987') {
                echo phpinfo();
                exit;
            } else {
                $this->redirect(HTTP_ROOT);
            }
        }

    
    public function mail_to_admin($data) {
    }


    function getUserInfo() {
        $user_id = $this->data['uid'];
        $userdata = $this->User->findByUniqId($user_id);
        $view = new View($this);
        $format = $view->loadHelper('Format');
        if (defined('USE_S3') && USE_S3) {
            if ($userdata['User']['photo']) {
                $userdata['User']['user_img_exists'] = 1;
                $userdata['User']['fileurl'] = $format->generateTemporaryURL(DIR_USER_PHOTOS_S3 . $userdata['User']['photo']);
            }
        } elseif ($format->imageExists(DIR_USER_PHOTOS, $userdata['User']['photo'])) {
            $userdata['User']['user_img_exists'] = 1;
            $userdata['User']['fileurl'] = HTTP_ROOT . 'files/photos/' . $userdata['User']['photo'];
        }

        $this->loadModel('TimezoneName');
        $timezones = $this->TimezoneName->find('all');
        $userdata['Timezone'] = $timezones;
        print json_encode($userdata);
        exit;
    }

    function getAllUsers($type = null) {
        if (SES_COMP != 1) {
            $this->redirect(HTTP_ROOT . 'dashboard');
        }
        $q = $_GET['q'];
        if ($type == 'community') {
            $this->loadModel('Community');
            $this->paginate = array('limit' => 30, 'order' => array('Community.name' => 'asc'));
            if (isset($q) && !empty($q)) {
                $this->paginate['conditions'] = array('Community.email LIKE' => '%' . $q . '%');
            } else {
                $this->paginate['conditions'] = array('Community.email !=' => '');
            }
            $community = $this->paginate('Community');
            $this->set('community', $community);
        } else if ($type == 'free') {
            $this->loadModel('FreeDownload');
            $this->paginate = array('limit' => 30, 'order' => array('FreeDownload.name' => 'asc'));
            if (isset($q) && !empty($q)) {
                $this->paginate['conditions'] = array('FreeDownload.email LIKE' => '%' . $q . '%');
            } else {
                $this->paginate['conditions'] = array('FreeDownload.email !=' => '');
            }
            $free = $this->paginate('FreeDownload');
            $this->set('free', $free);
        } else {
            $this->User->Behaviors->attach('Containable');
            $this->User->bindModel(array('hasMany' => array('UserSubscription')));
            $this->paginate = array('limit' => 30, 'order' => array('User.name' => 'asc'), 'contain' => array('UserSubscription' => array('fields' => array('UserSubscription.subscription_id'), 'order' => array('UserSubscription.id DESC'), 'limit' => 1)));
            if (isset($q) && !empty($q)) {
                $this->paginate['conditions'] = array('User.email LIKE' => '%' . $q . '%');
            } else {
                $this->paginate['conditions'] = array('User.email !=' => '');
            }
            $users = $this->paginate('User');
            $this->set('users', $users);
            $this->loadModel('TimezoneName');
            $timezones = $this->TimezoneName->find('list', array('fields' => array('TimezoneName.id', 'TimezoneName.zone')));
            $this->set('timezones', $timezones);
        }
    }

    /**
     * Function to manage ajax call to send Monthly Invoice mail to user if the checkbox is checked
     * in Subscription page.
     */
    public function manageSubscriptionMail() {
        if ($this->request->is('ajax')) {
            $allowMail = isset($this->request->data['mailling']) ? $this->request->data['mailling'] : "0";
            $user_subscriptionID = $this->request->data['sub_id'];

            if (!empty($user_subscriptionID)) {
                //update user_subscriptions table
                $this->UserSubscription->id = $user_subscriptionID;
                $this->UserSubscription->saveField('subscription_mail', $allowMail);
                echo 'success';
            } else {
                echo 'failure';
            }
        }
        exit;
    }

    /**
     * Function to handel ajax call from super admin to update user limit and storage limit
     */
    public function userNstorageLimit() {
        if ($this->request->is('ajax')) {
            $data = array();
            parse_str($this->request->data['v'], $data);
            $userLimit = isset($data['data']['user_count']) ? $data['data']['user_count'] : "0";
            $storageLimit = isset($data['data']['storage_usage']) ? $data['data']['storage_usage'] : "0";
            $storageLimit = ($storageLimit != "0" && strtolower($storageLimit) != "unlimited") ? round($storageLimit * 1024) : $storageLimit;
            $companyId = $data['data']['company_Id'];
            $sub_id = $data['data']['sub_Id'];
                $reason = $data['data']['reason'];
            $record = null;
            if (!empty($companyId)) {
                //update user_subscriptions table
                $record['UserSubscription']['id'] = $sub_id;
                $record['UserSubscription']['company_id'] = $companyId;
                $record['UserSubscription']['user_limit'] = $userLimit;
                $record['UserSubscription']['storage'] = $storageLimit;
                $this->UserSubscription->save($record);
                    $json_arr = array();
                    $json_arr['company_id'] = $companyId;
                    $json_arr['storage'] = $storageLimit;
                    $json_arr['user_limit'] = $userLimit;
                    $json_arr['created'] = GMT_DATETIME;
                    $json_arr['reason'] = $reason;
                    $this->Postcase->auditTrail($companyId,SES_ID, $json_arr, 7);                    
         $this->Format->resetCacheSub($companyId);
                echo 'success';
            } else {
                echo 'failure';
            }
        }
        exit;
    }

    function get_ses_value() {
        if ($this->Auth->User('id')) {
            $getUserEmailFromUserId = $this->Format->getUserNameForEmail($this->Auth->User('id'));
            $_SESSION['SES_EMAIL_USER_LOGIN'] = $getUserEmailFromUserId['User']['email'];
            echo json_encode(array('msg' => $getUserEmailFromUserId['User']['email']));
            exit;
        } else {
            echo json_encode(array('msg' => ''));
            exit;
        }
    }
    function create_project() {
      if ($this->Auth->User("id")) {
          $this->Session->write('project_url', 'create_project');
          $this->redirect('/mydashboard?project_url=create_project');
          die;
      } else {
          $this->redirect(HTTP_ROOT . 'users/login?project_url=create_project');
          die;
      }
  }

  public function contact_faq() {
  }
  function emailTesting(){
	 $mail = new PHPMailer();
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = "us-nyc-e2db.hwi.harrywinston.com";
		$mail->Port = 25;
		$mail->SMTPAuth = false;
		$mail->setFrom('orangescrum@harrywinston.com', 'OrangeScrum');
		$mail->addReplyTo('orangescrum@harrywinston.com', 'OrangeScrum');
		$mail->addAddress('prabhudas.behera@andolasoft.co.in', 'John Doe');
		$mail->Subject = 'PHPMailer SMTP without auth test';
		$mail->msgHTML('testing email');
		$mail->AltBody = 'This is a plain-text message body';
		if (!$mail->send()) {
			echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
			echo "Message sent!";
		}
		exit;
   }
   function smtp_settings($type=null){
	   if($type && $type=='others'){
		   $this->set('check_smtp', 1);
	   }
	   if(!empty($this->data)){
		   if(isset($this->request->params['pass']) && trim($this->request->params['pass'][0]) == 'others'){
			$others = $this->data;
			$client_id = !empty($others['client_id']) ? $others['client_id'] : 'XXXXXXXXXXXX.apps.googleusercontent.com';
			$client_secret = !empty($others['client_secret']) ? $others['client_secret'] : 'xXxXXxxxx_xXxXXxxxx';
			$api_key = !empty($others['api_key']) ? $others['api_key'] : 'xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx';
			$wkhtml_path = !empty($others['wkhtml_path']) ? $others['wkhtml_path'] : "";
			
			$db_key = !empty($others['db_key']) ? $others['db_key'] : 'xXxxXxxxXx';
			
			$bkt_name = !empty($others['bkt_name']) ? $others['bkt_name'] : 'Bucket Name';
			$aws_key = !empty($others['aws_key']) ? $others['aws_key'] : 'XXXXXXXXXXXXXX';
			$aws_secret = !empty($others['aws_secret']) ? $others['aws_secret'] : 'XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX';
			
			$constants_filename = APP.'Config'. DIRECTORY_SEPARATOR . 'constants.php';
			$tmp_constants_filename = APP.'Config'. DIRECTORY_SEPARATOR . 'constants.tmp.php';
			$file = fopen($constants_filename, "a+");
			$writing = fopen($tmp_constants_filename, 'w');
			$size = filesize($constants_filename);
			while (!feof($file)) {
				$line = fgets($file);
				$endline ="\n";			
				if (stristr($line, 'define("CLIENT_ID",') && !empty($client_id)) {
				   $client_id = '"'.$client_id.'"';
				   $line = 'define("CLIENT_ID", '.$client_id.');'.$endline;
				} elseif (stristr($line, 'define("CLIENT_SECRET",') && !empty($client_secret)) {
				   $client_secret = '"'.$client_secret.'"';
				   $line = 'define("CLIENT_SECRET", '.$client_secret.');'.$endline;
				} elseif (stristr($line, 'define("API_KEY",') && !empty($api_key)) {
					$api_key = '"'.$api_key.'"';
					$line = 'define("API_KEY", '.$api_key.');'.$endline;
				} elseif (stristr($line, 'define("USE_GOOGLE", 0);') && $client_id != 'XXXXXXXXXXXX.apps.googleusercontent.com' && $client_secret!= 'xXxXXxxxx_xXxXXxxxx' && $api_key != 'xXxXXxxxxxXXXXXXXXXXXXXxXXxxxx') {
					$line = 'define("USE_GOOGLE", 1);'.$endline;
				}
				//dropbox
				if (stristr($line, 'define("DROPBOX_KEY",') && !empty($db_key)) {
				   $db_key = '"'.$db_key.'"';
				   $line = 'define("DROPBOX_KEY", '.$db_key.');'.$endline;
				} elseif (stristr($line, 'define("USE_DROPBOX", 0);') && $db_key != 'xXxxXxxxXx') {
				   $line = 'define("USE_DROPBOX", 1);'.$endline;
				}
				//Aws s3
				if (stristr($line, 'define("BUCKET_NAME",') && !empty($api_key)) {
					$bkt_name = '"'.$bkt_name.'"';
					$line = 'define("BUCKET_NAME", '.$bkt_name.');'.$endline;
				} elseif (stristr($line, 'define("awsAccessKey",') && !empty($aws_key)) {
					$aws_key = '"'.$aws_key.'"';
					$line = 'define("awsAccessKey", '.$aws_key.');'.$endline;
				} elseif (stristr($line, 'define("awsSecretKey",')) {
					$aws_secret = '"'.$aws_secret.'"';
					$line = 'define("awsSecretKey", '.$aws_secret.');'.$endline;
				} elseif (stristr($line, 'define("USE_S3", 0);') && $bkt_name != 'Bucket Name' && $aws_secret != 'XXXX/XXXXXXXXXXXXXX/+XXXXXXXXXXXXXX' && $aws_key != 'XXXXXXXXXXXXXX') {
					$line = 'define("USE_S3", 1);'.$endline;
				}
				if (stristr($line, 'define("PDF_LIB_PATH",') && !empty($wkhtml_path)) {
					$line = 'define("PDF_LIB_PATH", "'.$wkhtml_path.'");'.$endline;
				}else if(stristr($line, 'define("PDF_LIB_PATH",') && empty($wkhtml_path)){
					$wkhtml_path = '';
					$line = 'define("PDF_LIB_PATH", "'.$wkhtml_path.'");'.$endline;
				}
				fputs($writing, $line);
			}
			fclose($file);
			fclose($writing);
			unlink($constants_filename);
			rename($tmp_constants_filename, $constants_filename);
			$this->redirect(HTTP_ROOT . "smtp-settings/others");
			
		   }else{
			   //smtp
			   if($this->data['smpt_mail_type'] && trim($this->data['smpt_mail_type']) == 'mailer'){
				    $this->EmailSetting = ClassRegistry::init('EmailSetting');
				    $esdata = array();
				    $esdata['host'] = $this->data['host'];
				    $esdata['port'] = $this->data['port'];
					$esdata['email'] = $this->data['email'];
					$esdata['password'] = $this->data['password'];
					if(empty($esdata['email']) || empty($esdata['password'])){
						$esdata['is_smtp'] = 3;
					}else{
						$esdata['is_smtp'] = 1;
					}
					$esdata['from_email'] = $this->data['from_email'];
					$esdata['reply_email'] = $this->data['notify_email'];
					$esdata['id'] = 1;
					$this->EmailSetting->save($esdata);
			   }
			   
				$smtp_post = $this->data;
				$SMTP_HOST = !empty($smtp_post['host']) ? $smtp_post['host'] : 'ssl://smtp.gmail.com';
				$SMTP_PORT = !empty($smtp_post['port']) ? $smtp_post['port'] : '465';
				$SMTP_UNAME = !empty($smtp_post['email']) ? $smtp_post['email'] : 'youremail@gmail.com';
				$SMTP_PWORD = !empty($smtp_post['password']) ? $smtp_post['password'] : '******';
				$FROM_EMAIL = !empty($smtp_post['from_email']) ? $smtp_post['from_email'] : "";
				if(!empty($smtp_post['notify_email'])){
					$NOTIFY_EMAIL = !empty($smtp_post['notify_email']) ? $smtp_post['notify_email'] : "";
				}else if($FROM_EMAIL != ''){
					$NOTIFY_EMAIL = $FROM_EMAIL;
				}else{
					$NOTIFY_EMAIL = !empty($smtp_post['notify_email']) ? $smtp_post['notify_email'] : "";
				}        
				$IS_SMTP = !empty($smtp_post['is_smtp']) ? $smtp_post['is_smtp'] : '0';
				
				$constants_filename = APP.'Config'. DIRECTORY_SEPARATOR . 'constants.php';
				$tmp_constants_filename = APP.'Config'. DIRECTORY_SEPARATOR . 'constants.tmp.php';
				$file = fopen($constants_filename, "a+");
				$writing = fopen($tmp_constants_filename, 'w');
				$size = filesize($constants_filename);
				while (!feof($file)) {
					$line = fgets($file);
					$endline ="\n";
					if (stristr($line, 'define("SMTP_HOST",') && !empty($SMTP_HOST)) {
					   $stmp_host = '"'.$SMTP_HOST.'"';
					   $line = 'define("SMTP_HOST", '.$stmp_host.');'.$endline;
					} elseif (stristr($line, 'define("SMTP_PORT",') && !empty($SMTP_PORT)) {
					   $stmp_host = '"'.$SMTP_PORT.'"';
					   $line = 'define("SMTP_PORT", '.$stmp_host.');'.$endline;
					} elseif (stristr($line, 'define("SMTP_UNAME",') && !empty($SMTP_UNAME)) {
						$stmp_uname = '"'.$SMTP_UNAME.'"';
						$line = 'define("SMTP_UNAME", '.$stmp_uname.');'.$endline;
					} elseif (stristr($line, 'define("SMTP_PWORD",') && !empty($SMTP_UNAME)) {
						$stmp_pword = '"'.$SMTP_PWORD.'"';
						$line = 'define("SMTP_PWORD", '.$stmp_pword.');'.$endline;
					}
					elseif (stristr($line, 'define("SUPPORT_EMAIL",') && !empty($FROM_EMAIL)) {
						//$FROM_EMAIL = '"'.$FROM_EMAIL.'"';
						$line = 'define("SUPPORT_EMAIL", "'.$FROM_EMAIL.'");'.$endline;
					} elseif (stristr($line, 'define("FROM_EMAIL",') && !empty($NOTIFY_EMAIL)) {
						//$FROM_EMAIL = '"'.$FROM_EMAIL.'"';
						$line = 'define("FROM_EMAIL", "'.$FROM_EMAIL.'");'.$endline;
					} elseif (stristr($line, 'define("FROM_EMAIL_EC",') && !empty($NOTIFY_EMAIL)) {
						$NOTIFY_EMAIL = '"'.$NOTIFY_EMAIL.'"';
						$line = 'define("FROM_EMAIL_EC", '.$NOTIFY_EMAIL.');'.$endline;
					}
					if(!empty($this->data['is_smtp']) && (stristr($line, 'define("IS_SMTP", 0);') || stristr($line, 'define("IS_SMTP", 1);')) && !empty($IS_SMTP)){
						$is_smtp = $IS_SMTP;
						$line = 'define("IS_SMTP", '.$is_smtp.');'.$endline;
					}	
					if($this->data['smpt_mail_type'] && trim($this->data['smpt_mail_type']) == 'mailer' && (stristr($line, 'define("PHPMAILER", 0);') || stristr($line, 'define("PHPMAILER", 1);'))){
						$line = 'define("PHPMAILER", 1);'.$endline;
					}else if(stristr($line, 'define("PHPMAILER", 1);')){
						$line = 'define("PHPMAILER", 0);'.$endline;
					}					
					fputs($writing, $line);
					//flush();
					//ob_flush();
				}
				fclose($file);
				fclose($writing);
				unlink($constants_filename);
				rename($tmp_constants_filename, $constants_filename);
				checkDebug();
				$smtp_flag =0;		
				$this->redirect(HTTP_ROOT . "smtp-settings");
		   }
	   }
   }
   function ajax_email_status_check() {
	   $this->layout = 'ajax';
		/*
		$this->data['host']
		$this->data['port']
		$this->data['email']
		$this->data['password']
		$this->data['is_phpmailer']
		$this->data['is_smtp']
		*/
	    $retArr = array();
	    $ports = array();
        $everythingisfine = 0;
        if (defined('SMTP_PWORD') && SMTP_PWORD != "******") {
            if (!in_array('openssl', get_loaded_extensions())) {
                $retArr['openMsg'] = '<div style="color:red">you have to enable php_openssl in php.ini to use this service</div><br />';
				$retArr['err'] = 1;
            } else {
                $retArr['openMsg'] = "php_openssl in php.ini is enabled <br /><br />";
                $everythingisfine = 1;
				$retArr['err'] = 0;
            }
            $host = SMTP_HOST;
            $ports[] = SMTP_PORT;
            foreach ($ports as $port) {
                $connection = @fsockopen($host, $port);
                if (is_resource($connection)) {
                    $retArr['conMsg'] = '<b>' . $host . ':' . $port . '</b> ' . '(' . getservbyport($port, 'ssl') . ') is open.<br /><br />' . "\n";
                    fclose($connection);
                    $everythingisfine = 1;
					$retArr['err'] = 0;
                } else {
                    $retArr['conMsg'] = '<div style="color:red"><b>' . $host . ':' . $port . '</b> is not responding.</div><br /><br />' . "\n";
					$retArr['err'] = 1;
                }
            }
            if ($everythingisfine && trim($this->data['from_email']) != '') {
                /*$emailDetails = SMTP_HOST . ":" . SMTP_PORT . " Username: " . SMTP_UNAME;
                try {
                    $response1 = $this->Sendgrid->sendGridEmail(SUPPORT_EMAIL, urldecode($_GET['to']), "Testing SMTP Simple Email -" . time(), $emailDetails, '',0,1);
                    echo "SMTP Simple Email Respond: ";
                    print_r($response1);
                    echo "<br/><br/>";
                } Catch (Exception $e) {
                    echo 'Simple Email Caught exception: ', $e->getMessage(), "\n<br/>";
                }*/
                $this->Email->delivery = 'smtp';
                $this->Email->to = trim($this->data['from_email']);
                $this->Email->subject = "Testing SMTP Template Email -" . time();
                $this->Email->from = trim($this->data['from_email']);
                $this->Email->template = 'test_email_template';
                $this->Email->sendAs = 'html';
				$this->set('message', 'Test message');
                try {
					if(defined("PHPMAILER") && PHPMAILER == 1){
						$this->Email->set_variables = $this->render('/Emails/html/test_email_template',false);
						$response2 = $this->PhpMailer->sendPhpMailerTemplate($this->Email,1);
						if($response2 !== true){
							$retArr['err'] = 1;							
							$retArr['Msg'] = "<br/>SMTP Template Email Respond: ".print_r($response2, true);							
						}else{
							$retArr['err'] = 0;
							$retArr['Msg'] = "Email sent successfully to ".trim($this->data['from_email']);
						}
						
					}else{
						$response2 = $this->Sendgrid->sendgridsmtp($this->Email, 1);
						if($response2 !== true){
							$retArr['err'] = 1;
							$retArr['Msg'] = "<br/>SMTP Template Email Respond: ".	print_r($response2,true);
						}else{
							$retArr['err'] = 0;
							$retArr['Msg'] = "Email sent successfully to ".trim($this->data['from_email']);
						}												
					}
                } Catch (Exception $e) {
                    $retArr['Msg'] = 'Template Email Caught exception: '. $e->getMessage();
					$retArr['err'] = 1;
                }
            }
        } else {
            $retArr['Msg'] = "Provide the details of SMTP email sending options in `app/Config/constants.php`";
			$retArr['err'] = 1;
        }		
		$this->set('Mesg', $retArr);
		$this->render('ajax_email_status_check');
    }
    function ajax_get_subcats(){
			$this->layout = 'ajax';
			$help_subcat = array();
			$help_posts = array();
			if($this->data['page']){
				try{
					//sub casts
					$help_subcat = $this->Format->getHelpCatsCURL(trim($this->data['page']),'cat');
					if(!empty($help_subcat)){
						$help_subcat = json_decode($help_subcat,true);
						$help_subcat = Hash::combine($help_subcat, '{n}.ID', '{n}.name');
					}
					//posts
					if($this->data['page']){
						$help_posts = $this->Format->getHelpCatsCURL($this->data['page'],'post');
						$help_posts = json_decode($help_posts,true);
					}
				}catch(Exception $e) {
					//echo $e->getMessage();
					//exit();
				}
			}
			$this->set(compact('help_subcat','help_posts'));
			$this->render('/Elements/ajax_helpsubcats');
    }
    
    function resetToken(){
        $this->loadModel('CompanyUser');
        $arr = $this->CompanyUser->find('first',array('conditions'=>array('company_id'=>SES_COMP, 'user_id'=>SES_ID)));
        $arr['CompanyUser']['google_token'] = '';
        $this->CompanyUser->save($arr);
    }
    
    public function ajax_savethemesetting(){
        if ($this->request->is('ajax')) {
            if ($this->request->is('post')) {
                $res = array('status'=>false);
                $data = $this->request->data;
                $this->loadModel('UserTheme');
                $exist = $this->UserTheme->find('first', array('conditions' => array('UserTheme.user_id' => SES_ID), 'fields' => array('UserTheme.*')));
                $arr_data['UserTheme']['user_id'] = SES_ID;
                $arr_data['UserTheme']['sidebar_color'] = !empty(trim($data['UserTheme']['sidebar_color'])) ? trim($data['UserTheme']['sidebar_color']) : null;
                $arr_data['UserTheme']['navbar_color'] = !empty(trim($data['UserTheme']['navbar_color'])) ? trim($data['UserTheme']['navbar_color']) : null;
                $arr_data['UserTheme']['mini_leftmenu'] = !empty($data['UserTheme']['mini_leftmenu']) && $data['UserTheme']['mini_leftmenu'] == "on" ? 1 : 0;
                $arr_data['UserTheme']['dark_leftmenu'] = !empty($data['UserTheme']['dark_leftmenu']) && $data['UserTheme']['dark_leftmenu'] == "on" ? 1 : 0;
                $arr_data['UserTheme']['dark_navbar'] = !empty($data['UserTheme']['dark_navbar']) && $data['UserTheme']['dark_navbar'] == "on" ? 1 : 0;
                $arr_data['UserTheme']['fixed_navbar'] = !empty($data['UserTheme']['fixed_navbar']) && $data['UserTheme']['fixed_navbar'] == "on" ? 1 : 0;
                $arr_data['UserTheme']['footer_dark'] = !empty($data['UserTheme']['footer_dark']) && $data['UserTheme']['footer_dark'] == "on" ? 1 : 0;
                $arr_data['UserTheme']['footer_fixed'] = !empty($data['UserTheme']['footer_fixed']) && $data['UserTheme']['footer_fixed'] == "on" ? 1 : 0;
                if(!empty($exist)){
                    $arr_data['UserTheme']['id'] = $exist['UserTheme']['id'];
                }else{
                    $this->UserTheme->create();
                }
                $is_saved = $this->UserTheme->save($arr_data);
                if ($is_saved) {
                    if (Cache::read('themeData_'.SES_COMP.'_'.SES_ID)) {
                        Cache::delete('themeData_'.SES_COMP.'_'.SES_ID);
                    }
                    Cache::write('themeData_'.SES_COMP.'_'.SES_ID, $arr_data);
                    $res['status'] = true;
                    $res['msg'] = __('Theme settings has been saved.');
                }else{
                    $res['msg'] = __('Theme settings could not saved.');
                }
                echo json_encode($res);exit;
            }
        }
    }

    public function ajax_getthemesetting(){
        if ($this->request->is('ajax')) {
            $this->loadModel('UserTheme');
            $exist = $this->UserTheme->find('first', array('conditions' => array('UserTheme.user_id' => SES_ID), 'fields' => array('UserTheme.*')));
            echo json_encode(array('data'=>!empty($exist) ? array($exist) : array()));exit;
        }
    }
    
    public function ajax_resetthemesetting(){
        if ($this->request->is('ajax')) {
            $this->loadModel('UserTheme');
            $exist = $this->UserTheme->find('first', array('conditions' => array('UserTheme.user_id' => SES_ID), 'fields' => array('UserTheme.*')));
            if(!empty($exist)){
              $this->UserTheme->id = $exist['UserTheme']['id'];
              $this->UserTheme->delete();
              if (Cache::read('themeData_'.SES_COMP.'_'.SES_ID)) {
                    Cache::delete('themeData_'.SES_COMP.'_'.SES_ID);
                }
            }
            echo json_encode(array('status'=> true));exit;
        }
    }
  function saveResourceSettings($company_id){
		$this->loadModel('ResourceSetting');

		$is_exists = $this->ResourceSetting->find('first',array('conditions'=>array('company_id'=>$company_id)));
		if(!empty($is_exists)){
			$arr['ResourceSetting']['id'] = $is_exists['ResourceSetting']['id'];
		}

		$arr['ResourceSetting']['company_id'] = $company_id;
		$arr['ResourceSetting']['is_active'] = 1;
		$this->ResourceSetting->save($arr);
	}
  /**
		* ajax_removeHoverEffect 
		*/
		function ajax_removeHoverEffect($srchTxt=''){
			$stsRet = array('status'=>1,'msg'=>'');
			$arr = array('task'=>8,'project'=>4,'user'=>2,'timelog'=>1);
			if(!empty($this->data['opt'])){				
				$this->User->id = SES_ID;
				$kep_hvr = Cache::read('KEEP_HOVER_EFFECT_'.SES_ID) - $arr[trim($this->data['opt'])];
				
				#echo Cache::read('KEEP_HOVER_EFFECT_'.SES_ID).'---'.$kep_hvr.'---'.$arr[trim($this->data['opt'])];exit;
				
				if($this->User->saveField('keep_hover_effect', $kep_hvr)){
					Cache::write('KEEP_HOVER_EFFECT_'.SES_ID, $kep_hvr);
					$_SESSION['KEEP_HOVER_EFFECT'] = $kep_hvr;
				}
			}
			echo json_encode($stsRet);
			exit;
		}
	function updateLeftMenu($last_user_id = 0){
  ini_set('max_execution_time', 0);	
		$UserSidebarMenu = ClassRegistry::init('UserSidebarMenu');
		$CompanyUser = ClassRegistry::init('CompanyUser');
		$allUsers = $this->User->find('all',array('conditions'=>array('User.id >='=>$last_user_id),'fields'=>array('User.id'),'limit'=>5000,'order'=>array('User.id'=>ASC)));
		
		foreach($allUsers as $k=>$v){
			$user_id = $last_user_id = $v['User']['id'];

			$sql = "SELECT CompanyUser.company_id,Companies.is_active,CompanyUser.user_type,CompanyUser.is_client FROM company_users CompanyUser , companies Companies WHERE Companies.id = CompanyUser.company_id AND CompanyUser.user_id=" . $user_id . " AND CompanyUser.is_active=1";
			$checkCmnpyUsr = $CompanyUser->query($sql,false);
			foreach($checkCmnpyUsr as $key=>$val){
				$this->Format->insertLeftMenu($val['CompanyUser']['company_id'],$user_id);
			}

		}
		echo $last_user_id;

		exit;
	}
        
    public function ajax_get_location($whitelist = ['127.0.0.1', '::1']){
    	$ip = $this->Format->getRealIpAddr();
    	#$ip = '182.66.61.253';
    	$is_on_localhost = in_array($ip, $whitelist);
    	$is_indian = false;
    	$response['status'] = false;
    	if(!$is_on_localhost){
		    $ch = curl_init('http://api.ipapi.com/'.$ip.'?access_key='.IPAPIKEY.'');
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		    $json = curl_exec($ch);
		    curl_close($ch);
		    $api_result = json_decode($json, true);
		    $response['status'] = true;
		    $response['loc_data'] = $api_result;
		    $is_indian = $api_result['country_code'] == "IN" ? true : false;
    	}
    	$response['is_indian'] = $is_indian;
    	echo json_encode($response);
    	exit;
    }
	
	
	function notify_me(){			
		  if(isset($this->request->data['email']) && !empty($this->request->data['email'])){
			   $data=array();
			   $email= $this->request->data['email'];
               $data['email']=$email;
			   $ip = $_SERVER['REMOTE_ADDR'];
			   $ipdat = @json_decode(file_get_contents( 
                "http://www.geoplugin.net/json.gp?ip=" . $ip)); 
               $country=$ipdat->geoplugin_countryName;
			   $city=$ipdat->geoplugin_city;
               $data['country']=$country;
               $data['city']=$city;
               $data['ip']=$ip;			  
			   $this->set('data', $data);    				 
			   $to = "support@orangescrum.com"; //support
			    //$to = "panda.rahul174@gmail.com";
			    $from = $email;
			    $subject = "OA new member signed up for Olympus";			
				$this->Email->delivery = 'smtp';
				$this->Email->to = $to;
				$this->Email->subject = $subject;
				$this->Email->from = $from;
				$this->Email->template ='contact_notify';
				$this->Email->sendAs = 'html';
                 			
				if($this->Sendgrid->sendgridsmtp($this->Email)){
                 $res['msg']="Message sent successfully. We will contact you soon!";				    
				 $res['success']=true;	
				 }else{
				 $res['msg']="Somthing! went wrong !";				    
				 $res['success']=false;		
}

				$d= $this->request->data['email'];	
			    $to = $email;
			    $from = FROM_EMAIL;
			    $subject = "Thank you for your interest in Orangescrum Olympus.";			
				$this->Email->delivery = 'smtp';
				$this->Email->to = $to;
				$this->Email->subject = $subject;
				$this->Email->from = $from;
				$this->Email->template = 'contact_notify_user';
				$this->Email->sendAs = 'html';             
			    $this->Sendgrid->sendgridsmtp($this->Email);						
				echo json_encode($res,true);
				exit;				
          }          
		}   
        /* Fetching resource details to show in create project popup
        * Sangita -22/06/2021
        */
        function ajax_get_resources(){
            $this->layout = 'ajax';
            $data = $this->request->data;  
            $fetchResources = $this->User->find('all',array('conditions'=>array('User.id'=>$data['user_id']), 'fields'=>array('User.name','User.id')));
           if(!empty($fetchResources)){
            foreach($fetchResources as $resource){                
                if($data['assign_project'] && !empty($data['assign_project'])) {     
                echo '<span class="dtl_label_tag new_resource" id='.$resource['User']['id'].'>'.$resource['User']['name'].'<a href="javascript:void(0)"; class="remove-resource" onclick="uncheck_resource('.$resource['User']['id'].')" title="Remove User">x</a></span>
                    <input type="hidden" name="resourceId[]" value="'.$resource['User']['id'].'">';
                     
                } else {
                echo '<span class="dtl_label_tag new_resource" id='.$resource['User']['id'].'>'.$resource['User']['name'].'<a href="javascript:void(0)"; onclick="manage_resource('.$resource['User']['id'].')" title="Remove User">x</a></span>
                <input type="hidden" name="resourceId[]" value="'.$resource['User']['id'].'">';
            }          
        }         
        }         
        exit;
        }
        /** Fetching skills for user profile
         * fetchUserSkill
                * Sangita -29/06/2021
         * @return void
        */
        function fetchUserSkill(){
            $this->layout = 'ajax';           
            $this->loadModel('Skill');
            $userId=array();
            $userId[] = $this->request->data['id'];             
        $skills= $this->Skill->skillFetch($userId); 
        echo json_encode($skills);
        exit;
        }   
        function insertAModule(){
        $this->loadModel('RoleModule');
        $this->loadModel('Role');
        $role_list = $this->Role->find('list',array('fields'=>array('id','company_id')));
        $is_report = $this->RoleModule->find('count',array('conditions'=>array('module_id'=>20)));
        if($is_report == 0){
            foreach($role_list as $k=>$v){
                $role_arry = array();
                $role_arry['role_id'] = $k;
                $role_arry['company_id'] = $v;
                $role_arry['is_active'] = 1;
                $role_arry['module_id'] = 20;
                $this->RoleModule->create();
                $this->RoleModule->save($role_arry);
            }
            echo "Role module table updated";exit;
        } else{
            echo "ALready inserted";exit;
        }
    }
        function help_support(){
			try{
				$help_cat = $this->Format->getHelpCatsCURL(0,'cat');
				$help_cat = json_decode($help_cat,true);
				if($help_cat){
					//sub casts
					$help_subcat = $this->Format->getHelpCatsCURL($help_cat[0]['ID'],'cat');
					if(!empty($help_subcat)){
						$help_subcat = json_decode($help_subcat,true);
						$help_subcat = Hash::combine($help_subcat, '{n}.ID', '{n}.name');
					}else{
						$help_subcat = array();
					}
					//posts
					if($help_cat[0]['ID']){
						$help_posts = $this->Format->getHelpCatsCURL($help_cat[0]['ID'],'post');
						$help_posts = json_decode($help_posts,true);
					}
				}
			}catch(Exception $e) {
				//echo $e->getMessage();
				//exit();
				$help_cat = array();
			}
			$this->set(compact('help_cat','help_subcat','help_posts'));
    }
    
}