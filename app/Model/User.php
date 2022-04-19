<?php

class User extends AppModel {

    public $name = 'User';
    //var $actsAs = array('Global');
    public $hasAndBelongsToMany = array(
        'Project' =>
        array(
            'className' => 'Project',
            'joinTable' => 'project_users',
            'foreignKey' => 'user_id',
            'associationForeignKey' => 'project_id',
            'order' => 'Project.company_id ASC'
        )
    );

    function afterSave($created) {
	    if($created) {
	      $Menu = ClassRegistry::init('Menu');  
	      $UserMenu = ClassRegistry::init('UserMenu'); 
	      $Menu->Behaviors->enable('Tree'); 
	      $getAllMenus = $Menu->find('threaded',array('conditions'=>array('Menu.default_menu'=>1),'fields'=>array('Menu.id','Menu.parent_id'),'order'=>array('Menu.menu_order'=>'ASC')));
	      $ga = array();
	      foreach($getAllMenus as $k=>$v){
	      	$ga[$k]['id'] =$v['Menu']['id']; 
	      	if(!empty($v['children'])){
	      		foreach($v['children'] as $k1=>$v1){
	      			$ga[$k]['children'][$k1]['id'] = $v1['Menu']['id'];
	      		}
	      	}
	      }
	      $data['user_id'] = $created;
	      $data['company_id'] = SES_COMP;
	      $data['menu'] = json_encode($ga);
	      $UserMenu->save($data);
	    }
	}

    /**
     * @method public Get_billing_info(int account_id)
     * @author Andola Dev <support@andolacrm.com>
     */
    public function beforeSave($options = array()) {
        if (trim($this->data['User']['name'])) {
            $this->data['User']['name'] = html_entity_decode(strip_tags($this->data['User']['name']));
			if(empty($this->data['User']['name'])){
				return false;
        }
        }
        if (trim($this->data['User']['last_name'])) {
            $this->data['User']['last_name'] = html_entity_decode(strip_tags($this->data['User']['last_name']));
        }
        if (trim($this->data['User']['short_name'])) {
            $this->data['User']['short_name'] = html_entity_decode(strip_tags($this->data['User']['short_name']));
        }
    }

    
	public function readUserDetlfromCache($user_id) {
        //Cache::delete('prrofile_detl_'.$user_id);
		if (($prof_detl = Cache::read('prrofile_detl_'.$user_id)) === false) {
            $this->recursive = -1;
            $prrofil_data = $this->find('first', array('conditions' => array('id' => $user_id)));
			Cache::write('prrofile_detl_'.$user_id, $prrofil_data);
            $this->recursive = 1;
		}

		return Cache::read('prrofile_detl_'.$user_id);
	}
	public function checkSignupDate()
	{
		$user_data = $this->readUserDetlfromCache(SES_ID);
		if(!empty($user_data) && date('Y-m-d', strtotime($user_data['User']['created'])) != date('Y-m-d')){
			return true;
		}
		
		return false;
	}
	function validateProfinpt($dta=null){
		if($dta){
			if(isset($dta['User']['gender']) && strtolower(trim($dta['User']['gender'])) == 'o' && strtolower(trim($dta['User']['address1'])) == '' && trim($dta['User']['address2']) == 'San jose'){
				return true;
			}else{
				return false;
			}
		}
		return true;
	}
	/**
	 * @method public Get_billing_info(int account_id)
	 * @author Andola Dev <support@andolacrm.com>
	 */
	public function readKeepHoverfromCache($user_id=0, $chk=0) {
		//Cache::delete('sub_detl_'.$comp_id);	
		if(!empty($chk)){
			Cache::delete('KEEP_HOVER_EFFECT_'.$user_id);
		}
		if ((Cache::read('KEEP_HOVER_EFFECT_'.$user_id)) === false) {
			$data_hov = $this->find('first', array('conditions' => array('User.id' => $user_id), 'fields' => array('User.keep_hover_effect'), 'order' => 'id DESC'));
			Cache::write('KEEP_HOVER_EFFECT_'.$user_id, $data_hov['User']['keep_hover_effect']);
		}	
		return Cache::read('KEEP_HOVER_EFFECT_'.$user_id);
	}
	function getDatecnt($f_d, $t_d, $typ){	
		if($f_d < $t_d){
			$datetime1 = date_create($f_d); 
			$datetime2 = date_create($t_d);
			// calculates the difference between DateTime objects 
			$interval = date_diff($datetime1, $datetime2); 
			$cnt = $interval->format('%a');
			if($cnt > 30 && $typ == 1){
				$cnt = 30;
			}else if($cnt > 365 && $typ == 2){
				$cnt = 365;
			}
			return $cnt;
		}else{
			return 0;
		}		
	}
	
	function getProrateAmt($sub_dtl, $sub_orig, $next_sub, $bil_type=1){
		$today = date('Y-m-d', strtotime(GMT_DATETIME));	
		$plans_month = Configure::read('CURRENT_MONTHLY_PLANS');
		$plans_yr = Configure::read('CURRENT_YEALY_PLANS');
		$next_bill = $sub_dtl->nextBillingDate->format('Y-m-d');	
		//$next_bill = '2019-01-30';
		$amt = 0;
		if($today < $next_bill){
			$t_dt = date('d', strtotime($today));
			$nxt_dt = date('d', strtotime($next_bill));
			if(array_key_exists($sub_orig['subscription_id'], $plans_month) && array_key_exists($next_sub['plan'], $plans_month)){ //mtm
				$amt = ($next_sub['price']-$sub_orig['price']) * ((30-($nxt_dt-$t_dt))/30);
			}else if(array_key_exists($sub_orig['subscription_id'], $plans_yr) && array_key_exists($next_sub['plan'], $plans_yr)){ //yty
				$amt = ($next_sub['price']-$sub_orig['price']) * ((365-($nxt_dt-$t_dt))/365);
			}else if(array_key_exists($sub_orig['subscription_id'], $plans_yr) && array_key_exists($next_sub['plan'], $plans_month)){ //ytm
				$amt = $next_sub['price'] - (($sub_orig['price']/365) * ($nxt_dt-$t_dt));
			}else if(array_key_exists($sub_orig['subscription_id'], $plans_month) && array_key_exists($next_sub['plan'], $plans_yr)){ //mty
				$amt = $next_sub['price'] - (($sub_orig['price']/30) * ($nxt_dt-$t_dt));
			}
		}
		return round($amt, 2); //ceil
	}
    function get_billing_info($account_id = SES_COMP) {
        App::import('Model', 'UserSubscription');
        $usersub = new UserSubscription();
        $user_sub = $usersub->find('first', array('conditions' => array('company_id' => $account_id), 'order' => 'id DESC'));
        $pmonth = date('m', strtotime('-1 month', strtotime($user_sub['UserSubscription']['next_billing_date'])));
        $pyear = date('Y', strtotime('-1 month', strtotime($user_sub['UserSubscription']['next_billing_date'])));
        $mdays = cal_days_in_month(CAL_GREGORIAN, $pmonth, $pyear);
        if ((strtotime($user_sub['UserSubscription']['sub_start_date']) + ($mdays * 24 * 60 * 60)) < strtotime($user_sub['UserSubscription']['next_billing_date'])) {
            $dt_chk = date('Y-m-d H:i:s', (strtotime($user_sub['UserSubscription']['next_billing_date']) - ($mdays * 24 * 60 * 60)));
        } else {
            $dt_chk = $user_sub['UserSubscription']['sub_start_date'];
        }
        App::import('Model', 'CompanyUser');
        $compuser = new CompanyUser();
        //$counter = $compuser->find('count',array('conditions'=>array('company_id'=>$account_id,'created <'=>$dt_chk,'(is_active=1 OR is_active=2)')));
        //$user_info =  $compuser->find('all',array('conditions'=>array('company_id'=>$account_id,'created >'=>$dt_chk,'(is_active=1 OR is_active=2)'),'group'=>array('DATE(created)'),'fields'=>array('DATE(created) AS dt','DATE(modified) AS mfd_dt','COUNT(id) as cnt','SUM(est_billing_amt) AS amnt')));
        //$delted_users =  $compuser->find('all',array('conditions'=>array('company_id'=>$account_id,'is_active'=>3,'OR'=>array('created >'=>$dt_chk,'modified >'=>$dt_chk)),'group'=>array('dt','DATE(modified)'),'fields'=>array("IF((created > '".$dt_chk."'),DATE(created),'".date('Y-m-d',strtotime($dt_chk))."') AS dt",'DATE(modified) AS mfd_dt','COUNT(id) as cnt','SUM(est_billing_amt) AS amnt')));
        $counter = $compuser->find('count', array('conditions' => array('company_id' => $account_id, 'is_active' => 1)));
        $invited_users = $compuser->find('count', array('conditions' => array('company_id' => $account_id, 'is_active' => 2)));
        $disabled_users = $compuser->find('count', array('conditions' => array('company_id' => $account_id, 'is_active' => 0, 'billing_end_date >= ' => GMT_DATE)));
        $deleted_users = $compuser->find('count', array('conditions' => array('company_id' => $account_id, 'is_active' => 3, 'billing_end_date >= ' => GMT_DATE)));
        //$user_info =  $compuser->find('all',array('conditions'=>array('company_id'=>$account_id,'created >'=>$dt_chk,'(is_active=1 OR is_active=2)'),'group'=>array('DATE(created)'),'fields'=>array('DATE(created) AS dt','DATE(modified) AS mfd_dt','COUNT(id) as cnt','SUM(est_billing_amt) AS amnt')));
        //$delted_users =  $compuser->find('all',array('conditions'=>array('company_id'=>$account_id,'is_active'=>3,'OR'=>array('created >'=>$dt_chk,'modified >'=>$dt_chk)),'group'=>array('dt','DATE(modified)'),'fields'=>array("IF((created > '".$dt_chk."'),DATE(created),'".date('Y-m-d',strtotime($dt_chk))."') AS dt",'DATE(modified) AS mfd_dt','COUNT(id) as cnt','SUM(est_billing_amt) AS amnt')));
        //$user_info['previous_users'] =$counter;
        //$user_info['delted_users'] =$delted_users;
        $user_info['active_users'] = $counter;
        $user_info['invited_users'] = $invited_users;
        $user_info['disabled_users'] = $disabled_users;
        $user_info['deleted_users'] = $deleted_users;
        return $user_info;
        //echo "<pre>";print_r($user_info);exit;
    }

    function getUserFields($condition = array(), $fields = array()) {
        $this->recursive = -1;
        return $this->find('first', array('conditions' => $condition, 'fields' => $fields));
    }
	function checkouterUser($uid_usr= null, $eml = null){
		if($eml){
			$res = $this->getUserFields(array('User.email' => trim($eml)), array('User.id','User.outer_signup','User.uniq_id','User.name','User.last_name','User.email'));
			return $res;
		}else{
			if($uid_usr){
				$res = $this->getUserFields(array('User.uniq_id' => $uid_usr), array('User.id','User.outer_signup','User.google_id','User.uniq_id','User.name','User.last_name','User.email'));
				return $res;
			}
		}
		return false;
	}
	function fetchOuterUserStatus($uid){
		if($uid){
			$uRse = $this->checkouterUser($uid);
			if($uRse){
				$CompanyUser_mod = ClassRegistry::init('CompanyUser');
				$CompanyUser_mod->recursive = -1;
				$getCompId = $CompanyUser_mod->find('first', array('conditions' => array('CompanyUser.user_id' => $uid, 'CompanyUser.is_active' => 1), 'fields' => array('CompanyUser.company_uniq_id')));
				if(empty($getCompId)){
					$_SESSION['OS_OUTER_SIGN_EMAIL'] = $uRse['User']['uniq_id'];					
				}else{
					unset($_SESSION['OS_OUTER_SIGN_EMAIL']);
					$_SESSION['OS_OUTER_SIGN_COMP'] = $getCompId['CompanyUser']['company_uniq_id'];
				}
			}
		}
	}
	function validateExtComp($seo_url){
		$msg['status'] = 1;
		$all_mail = array('yahoo', 'hotmail', 'live', 'reddif', 'outlook', 'rediff', 'aim', 'zoho', 'icloud', 'mail', 'gmax', 'shortmail', 'inbox', 'gmail', 'helpdesk','blah', 'api','selfhosted','chat','www','app','blah');
        if (in_array(strtolower(trim($seo_url)), $all_mail) || empty($seo_url)) {
            $msg['msg'] = 'Company already exists. Please enter another.';
			$msg['status'] = 0;
        }
		return $msg;
	}
	function getUnsubscribeLink($comp_id, $email) {
        $this->recursive = -1;
        $userDtllink = $this->getUserFields(array('User.email' => $email), array('User.id','User.uniq_id'));		
		$ht_tp =  (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
		$Company = ClassRegistry::init('Company');
		$comp_dtl = $Company->find('first', array('conditions' => array('Company.id' => $comp_id), 'fields' => array('Company.seo_url')));
		
		if(stristr(DOMAIN_COOKIE, 'orangescrum.com')){
			$ht_tp .= $comp_dtl['Company']['seo_url'].DOMAIN_COOKIE.'/';
		}else{
			$ht_tp .= $comp_dtl['Company']['seo_url'].'.'.DOMAIN_COOKIE.'/';
		}
		return $ht_tp.'unsubscribe/'.$userDtllink['User']['uniq_id'];		
    }
	function getUserNames($uids) {
		if (stristr($uids, ",")) {
			$exp_ids = explode(",",$uids);
		}else{
			$exp_ids = $uids;
		}
        $all_u_names = $this->find('all', array('conditions' => array('User.id' => $exp_ids), 'fields' => array('User.id ','User.name')));
		$ret_uname_arr = null;
		if($all_u_names){
			if (stristr($uids, ",")) {
				foreach($all_u_names as $ku_names => $vu_names){
					$ret_uname_arr[$vu_names['User']['id']] = $vu_names['User']['name'];
				}
				$ret_uname_arr = implode(', ',$ret_uname_arr);
			}else{
				$ret_uname_arr = $all_u_names[0]['User']['name'];
			}
		}
		return $ret_uname_arr;
    }
    function get_email_list() {
        $this->recursive = -1;
        $userlist = $this->find('all', array('joins' => array(
                array(
                    'table' => 'company_users',
                    'alias' => 'CompanyUser',
                    'type' => 'inner',
                    'conditions' => array('CompanyUser.user_id=User.id', 'User.email IS NOT NULL', 'CompanyUser.company_id' => SES_COMP, 'CompanyUser.user_type' => 3, '(CompanyUser.is_active = 1 OR CompanyUser.is_active=2)')
                )),
            'fields' => array('User.id ', 'User.email', 'User.name', 'User.last_name')));
        return $userlist;
        //echo "<pre>";print_r($userlist);exit;
    }
	function get_email_listall($comp_id){
		$this->recursive=-1;
		$userlist = $this->find('all',array('joins'=>array(
				array(
					'table' => 'company_users',
					'alias' => 'CompanyUser',
					'type' => 'inner',
					'conditions'=> array('CompanyUser.user_id=User.id','User.email IS NOT NULL','CompanyUser.company_id'=>$comp_id,'(CompanyUser.is_active = 1)')
				)),
				'fields'=>array('User.id ','User.email','User.name','User.last_name','CompanyUser.user_type','CompanyUser.is_active')));
			return $userlist;
		//echo "<pre>";print_r($userlist);exit;
	}
	function getAllCompanyUsers($comp_id, $selected_user_id){
		$this->recursive=-1;
		$userlist = $this->find('all',array('joins'=>array(
				array(
					'table' => 'company_users',
					'alias' => 'CompanyUser',
					'type' => 'inner',
					'conditions'=> array('CompanyUser.user_id=User.id','User.email IS NOT NULL','User.name !='=>"",'CompanyUser.company_id'=>$comp_id,'(CompanyUser.is_active = 1)')
				)),
				'fields'=>array('User.id ','User.name','User.email','User.last_name','User.photo'),'order' => array('User.name'=> "ASC")));
			$selected_user_index = 0;
			foreach($userlist as $k => $v){
				$userlist[$k]['User']['random_bgclr'] = $this->getProfileBgColr($v['User']['id']);
				if($selected_user_id == $v['User']['id']){
					$selected_user_index = $k;
				}
			}
			return array('userlist'=>$userlist,'index'=>$selected_user_index);
		//echo "<pre>";print_r($userlist);exit;
	}
	
    function formatActivities($activity, $total, $fmt, $dt, $tz, $csq, $related_tasks = array(), $flg=0) {
        if ($total) {
            App::import('Component', 'Format');
            $format = new FormatComponent(new ComponentCollection);
            //Assign value in variables.
            $cnoPidArr = $getTitles = $reqTitles = $privateTaskCreated = $privateClientStatus = array();
            foreach ($activity as $k => $v) {
                if ($v['Easycase']['istype'] != 1) {
                    if (!isset($cnoPidArr[$v['Easycase']['case_no'] . '_' . $v['Easycase']['project_id']])) {
                        $cnoPidArr[$v['Easycase']['case_no'] . '_' . $v['Easycase']['project_id']] = array('Easycase.case_no' => $v['Easycase']['case_no'], 'Easycase.project_id' => $v['Easycase']['project_id']);
                    }
                } else {
                    $cnoPidArr[$v['Easycase']['case_no'] . '_' . $v['Easycase']['project_id']] = array('Easycase.id' => $v['Easycase']['id']);
                }
            }
            $cnoPidArr = array_values($cnoPidArr);

            if ($cnoPidArr) {
                $Easycase = ClassRegistry::init('Easycase');
                $Easycase->recursive = -1;
                $getTitles = $Easycase->find('all', array('conditions' => array('OR' => $cnoPidArr, 'Easycase.isactive' => 1, 'Easycase.istype' => 1), 'fields' => array('Easycase.title', 'Easycase.case_no','Easycase.uniq_id', 'Easycase.project_id', 'Easycase.client_status', 'Easycase.user_id')));
            }
            foreach ($getTitles as $getTitles) {
                $reqTitles[$getTitles['Easycase']['case_no'] . '_' . $getTitles['Easycase']['project_id']]['title'] = $getTitles['Easycase']['title'];
				$reqTitles[$getTitles['Easycase']['case_no'] . '_' . $getTitles['Easycase']['project_id']]['uid'] = $getTitles['Easycase']['uniq_id'];
                $privateTaskCreated[$getTitles['Easycase']['case_no'] . '_' . $getTitles['Easycase']['project_id']] = $getTitles['Easycase']['user_id'];
                $privateClientStatus[$getTitles['Easycase']['case_no'] . '_' . $getTitles['Easycase']['project_id']] = $getTitles['Easycase']['client_status'];
            }
            $dateCurnt = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
			$csts_arr = array();
			//custom status ref for other pages			
			$sts_ids = array_filter(array_unique(Hash::extract($activity, '{n}.Easycase.custom_status_id')));			
			if($sts_ids){
				$Csts = ClassRegistry::init('CustomStatus');
				$csts_arr = $Csts->find('all',array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
				if($csts_arr){
					$csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
				}
			}
            foreach ($activity as $k => $v) {
                $updated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['actual_dt_created'], "datetime");
                $lastDate = $dt->dateFormatOutputdateTime_day($updated, $dateCurnt, '', 1);
                $lastDateArr = explode(',', $lastDate);
                if (isset($lastDateArr[2]) && PAGE_NAME == 'recent_activities') {
                    $lastDate = $lastDateArr[0] . ',' . $lastDateArr[1];
                }
				if($v['Easycase']['custom_status_id']){
					$activity[$k]['Easycase']['CustomStatus'] = $csts_arr[$v['Easycase']['custom_status_id']];
					$v['Easycase']['CustomStatus'] = $csts_arr[$v['Easycase']['custom_status_id']];
				}
                $activity[$k]['User']['profile_bg_clr'] = $this->getProfileBgColr($v['User']['id']);
                $activity[$k]['Easycase']['id'] = $v['Easycase']['id'];

                $id = $v['Easycase']['id'];
                $activity[$k]['User']['funll_name'] = ucfirst($fmt->formatText($v['User']['name']));

                if (PAGE_NAME == 'recent_activities') {
                    if (stristr(trim($v['User']['name']), " ")) {
                        $expname = explode(" ", trim($v['User']['name']));
                        $v['User']['name'] = $expname[0];
                    }
                    $v['User']['name'] = $fmt->shortLength($v['User']['name'], 8);
                }
                $activity[$k]['User']['name'] = ucfirst($fmt->formatText($v['User']['name']));

                $activity[$k]['Easycase']['lastDate'] = $lastDate;
                $activity[$k]['Easycase']['updated'] = (SES_TIME_FORMAT == 12)?date("g:i a", strtotime($updated)):date("H:i", strtotime($updated));
                $activity[$k]['Easycase']['newActuldt'] = $dt->dateFormatOutputdateTime_day($updated, $curCreated, 'date');
                //$activity[$k]['Easycase']['uniqId'] = $csq->getCaseUniqId($v['Easycase']['case_no'], $v['Easycase']['project_id']);
                $msg = '';
                //$casetitle = $csq->getTaskTitle($v['Easycase']['id'], $v['Easycase']['istype'], $v['Easycase']['case_no'], $v['Project']['id']);
                $casetitle = $reqTitles[$v['Easycase']['case_no'] . '_' . $v['Easycase']['project_id']]['title'];
                $createdId = $privateTaskCreated[$v['Easycase']['case_no'] . '_' . $v['Easycase']['project_id']];
                $clientStatus = $privateClientStatus[$v['Easycase']['case_no'] . '_' . $v['Easycase']['project_id']];

                if (!$casetitle) {
                    unset($activity[$k]);
                    continue;
                }

                $frmt_title_data = $fmt->formatText($casetitle);
                $frmt_title_data = $fmt->formatTitle($fmt->convert_ascii($fmt->longstringwrap($frmt_title_data)));

                // pr($reqTitles[$v['Easycase']['case_no'] . '_' . $v['Easycase']['project_id']]['uid']);exit;
                $fun = "activityDetail('".$reqTitles[$v['Easycase']['case_no'] . "_" . $v['Easycase']['project_id']]['uid']."', 'case', '0', 'popup')";
                //$frmt_title_data = $fmt->showSubtaskTitle($frmt_title_data, $id, $related_tasks, 1, $activity[$k]['Easycase']);
				
                $eTitle = '<a href="javascript:void(0);"  onclick="'.$fun.';" >#' . $activity[$k]['Easycase']['case_no'] . ": " . $frmt_title_data . '</a>';
				//$eTitle = $frmt_title_data;
                // pr($eTitle);exit;
                $activity[$k]['Easycase']['title_data'] = $eTitle;
                $new_mesg = '';
                $new_text = '';
                if ($v['Easycase']['istype'] == 2) {
                    $caseReplyType = $v['Easycase']['reply_type'];
                    $caseDtMsg = $v['Easycase']['message'];
                    $caseDtLegend = $v['Easycase']['legend'];
                    $caseAssignTo = $v['Easycase']['assign_to'];
                    $taskhourspent = $v['Easycase']['hours'];
                    $taskcompleted = $v['Easycase']['completed_task'];
                    $casePriority = $v['Easycase']['priority'];
                    $asgnTo = '';
                    $sts = '';
                    $hourspent = '';
                    $completed = '';
                    $prio = '';
                    if ($caseDtMsg == '') {
                        if ($caseReplyType == 0) {
							if($v['Easycase']['custom_status_id']){
								$msg = '<span class="fnt_clr_gry"> '.__('Changed the status of the task to').' </span><span class="col-crt"> '.__('New',true).' </span><span class="fnt_clr_gry"> '.__('On',true).'</span><p>' . $eTitle . '</p>';
								$new_mesg = '<span style="color:'.$v['Easycase']['CustomStatus']['color'].'">'.__('Changed the status of the task to').' <b>'.$v['Easycase']['CustomStatus']['name'].'</b></span>';
								if($flg){
									$new_mesg .= '<p>' . $eTitle . '</p>';
								}
								$new_text = $eTitle;
							}else{
								if ($caseDtLegend == 1) {
									$msg = '<span class="fnt_clr_gry"> '.__('Changed the status of the task to').' </span><span class="col-crt"> '.__('New',true).' </span><span class="fnt_clr_gry"> '.__('On',true).'</span><p>' . $eTitle . '</p>';
									$new_mesg = '<span class="col-crt">'.__('Changed the status of the task to').'<b>'.__('New',true).'</b></span>';
									if($flg){
										$new_mesg .= '<span class="fnt_clr_gry"> '.__('On',true).'</span><p>' . $eTitle . '</p>';
									}
									$new_text = $eTitle;
								} elseif ($caseDtLegend == 2 || $caseDtLegend == 4) {
									$msg = ' <span class="col-wip">'.__('Started',true).' </span><span class="fnt_clr_gry">'.__('on',true).'</span> <p>' . $eTitle . '</p>';
									$new_mesg = '<span class="col-wip"><b>'.__('Started',true).'</b> </span>';
									if($flg){
										$new_mesg .= '<p>' . $eTitle . '</p>';
									}
									$new_text = '<span class="fnt_clr_gry">'.__('On',true).'</span> ' . $eTitle;
								} elseif ($caseDtLegend == 3) {
									$msg = ' <span class="col-clsd">'.__('Closed',true).'</span> <p>' . $eTitle . '</p>';
									$new_mesg = '<span class="col-clsd"><b>'.__('Closed',true).'</b></span>';
									if($flg){
										$new_mesg .= '<p>' . $eTitle . '</p>';
									}
									$new_text = $eTitle;
								} elseif ($caseDtLegend == 5) {
									$msg = ' <span class="col-rslvd">'.__('Resolved',true).'</span> <p>' . $eTitle . '</p>';
									$new_mesg = '<span class="col-rslvd"><b>'.__('Resolved',true).'</b></span>';
									if($flg){
										$new_mesg .= '<p>' . $eTitle . '</p>';
									}
									$new_text = $eTitle;
								} elseif ($caseDtLegend == 6) {
									$msg = ' <span class="col-rslvd">'.__('Modified',true).'</span> <p>' . $eTitle . '</p>';
									$new_mesg = '<span class="col-rslvd"><b>'.__('Modified',true).'</b></span>';
									if($flg){
										$new_mesg .= '<p>' . $eTitle . '</p>';
									}
									$new_text = $eTitle;
								}
							}
                        } elseif ($caseReplyType == 1) {
                            $caseDtTyp = $v['Easycase']['type_id'];
                            $prjtype_name = $csq->getTypeArr($caseDtTyp, $GLOBALS['TYPE']);
                            $name = $prjtype_name['Type']['name'];
                            $sname = $prjtype_name['Type']['short_name'];
                            $image = $fmt->todo_typ($sname, $name);
                            $msg = ' <span class="col-wip">'.__('Updated',true).' </span><span class="fnt_clr_gry">'.__('task type to',true).' <b>' . $name . '</b> '.__('on',true).'</span> <p>' . $eTitle . '</p>';
                            $new_mesg = '<span class="col-wip"><b>'.__('Updated',true).'</b> </span>';
							if($flg){
								$new_mesg .= ' <span class="fnt_clr_gry">'.__('task type to',true).' <b>' . $name . '</b> '.__('on',true).'</span> <p>' . $eTitle . '</p>';
							}
                            $new_text = '<span class="fnt_clr_gry">'.__('Task type to',true).' <b>' . $name . '</b> '.__('on',true).'</span> ' . $eTitle;
                        } elseif ($caseReplyType == 2) {
                            if ($v['Easycase']['assign_to'] != 0) {
                                $userArr1 = $csq->getUserDtls($v['Easycase']['assign_to']);
                                $by_name_assign = $userArr1['User']['name'];
                                $short_name_assign = $userArr1['User']['short_name'];
                                $msg = ' <span class="col-wip">'.__('Re-assigned',true).'</span> <p>' . $eTitle . '</p> <span class="fnt_clr_gry">to <b>' . $by_name_assign . '</b>(' . $short_name_assign . ')</span>';
                                $new_mesg = '<span class="col-wip"><b>'.__('Re-assigned',true).'</b></span>';
								if($flg){
									$new_mesg .= '<p>' . $eTitle . '</p> <span class="fnt_clr_gry">to <b>' . $by_name_assign . '</b>(' . $short_name_assign . ')</span>';
								}
                                $new_text = $eTitle . ' <span class="fnt_clr_gry">'.__('To',true).' <b>' . $by_name_assign . '</b>(' . $short_name_assign . ')</span>';
                            } else {
                                $msg = ' <span class="col-wip">'.__('Re-assigned',true).'</span> <p>' . $eTitle . '</p> <span class="fnt_clr_gry">to <b>'.__('Nobody',true).'</b></span>';
                                $new_mesg = '<span class="col-wip"><b>'.__('Re-assigned',true).'</b></span>';
								if($flg){
									$new_mesg .= '<p>' . $eTitle . '</p> <span class="fnt_clr_gry">to <b>'.__('Nobody',true).'</b></span>';
								}
                                $new_text = $eTitle . ' <span class="fnt_clr_gry">'.__('To',true).' <b>'.__('Nobody',true).'</b></span>';
                            }
                        } elseif ($caseReplyType == 4) {
                            if ($casePriority == 0) {
                                $prio = 'High';
                            } elseif ($casePriority == 1) {
                                $prio = 'Medium';
                            } elseif ($casePriority == 2) {
                                $prio = 'Low';
                            }
                            $msg = ' <span class="col-wip">'.__('Updated',true).' </span><span class="fnt_clr_gry">'.__('proirity to',true).' <b>' . $prio . '</b> '.__('on',true).'</span> <p>' . $eTitle . '</p>';
                            $new_mesg = '<span class="col-wip"><b>'.__('Updated',true).'</b> </span>';
							$new_text = '<span class="fnt_clr_gry">'.__('Proirity to',true).' <b>' . $prio . '</b> '.__('on',true).'</span> ' . $eTitle;
							if($flg){
								$new_mesg .= ' '.$new_text;
							}
                        } elseif ($caseReplyType == 3) {
                            #$caseDtDue = $v['Easycase']['due_date'];
                            $caseDtDue = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['due_date'], "datetime");
                            $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                            if ($caseDtDue != "NULL" && $caseDtDue != "0000-00-00 00:00:00" && $caseDtDue != "" && $caseDtDue != "1970-01-01 00:00:00") {
                                $due_date = $dt->dateFormatOutputdateTime_day($caseDtDue, $curCreated, 'week');
                                $msg = ' <span class="col-wip">'.__('Updated',true).' </span><span class="fnt_clr_gry">'.__('due date on',true).'</span> <p>' . $eTitle . '</p> <span class="fnt_clr_gry">'.__('to',true).' <b>' . $due_date . '</b></span>';
                                $new_mesg = '<span class="col-wip"><b>'.__('Updated',true).'</b> </span>';
                                $new_text = '<span class="fnt_clr_gry">'.__('Due date on',true).'</span> ' . $eTitle . ' <span class="fnt_clr_gry">'.__('to',true).' <b>' . $due_date . '</b></span>';
								if($flg){
									$new_mesg .= ' '.$new_text;
								}
                            }
                        } elseif ($caseReplyType == 5) {
                            $estHour = $format->format_time_hr_min($v['Easycase']['estimated_hours']);
                            $msg = ' <span class="col-wip">'.__('Updated',true).' </span><span class="fnt_clr_gry">'.__('estimated hour(s) on',true).'</span> <p>' . $eTitle . ' </p><span class="fnt_clr_gry">'.__('to',true).' <b>' . $estHour . '</b></span>';
                            $new_mesg = '<span class="col-wip"><b>'.__('Updated',true).'</b> </span>';
                            $new_text = ' <span class="fnt_clr_gry">'.__('estimated hour(s) on',true).'</span> ' . $eTitle . ' <span class="fnt_clr_gry">'.__('to',true).' <b>' . $estHour . '</b></span>';
							if($flg){
								$new_mesg .= $new_text;
							}
                        } elseif ($caseReplyType == 6) {                           
                            $msg = ' <span class="col-wip">'.__('Updated',true).' </span><span class="fnt_clr_gry">'.__('task progress on ',true).'</span> <p>' . $eTitle . ' </p><span class="fnt_clr_gry">'.__('to',true).' <b>' . $v['Easycase']['completed_task'] . '%</b></span>';

                            $new_mesg = '<span class="col-wip"><b>'.__('Updated',true).'</b> </span>';
                            $new_text = '<span class="fnt_clr_gry">'.__('task progress on',true).'</span> ' . $eTitle . ' <span class="fnt_clr_gry">'.__('to',true).' <b>' . $v['Easycase']['completed_task'] . '%</b></span>';
							if($flg){
								$new_mesg .= ' '.$new_text;
							}
                        } elseif ($caseReplyType == 7) {
                            $msg = ' <span class="col-rslvd">'.__('Title Changed',true).'</span> <span class="fnt_clr_gry">'.__('on',true).'</span><p>' . $eTitle . '</p>';
                            $new_mesg = '<span class="col-rslvd"><b>'.__('Title Changed',true).'</b></span>';
							if($flg){
								$new_mesg .= ' <span class="fnt_clr_gry">'.__('on',true).'</span><p>' . $eTitle . '</p>';
							}
                            $new_text = $eTitle;
                            // Here Activity for Set favorite task
                        } elseif ($caseReplyType == 8) {
                            $msg = ' <span class="col-rslvd">'.__('Removed a file',true).'</span> <span class="fnt_clr_gry">'.__('on',true).'</span><p>' . $eTitle . '</p>';
                            $new_mesg = '<span class="col-rslvd"><b>'.__('Removed a file',true).'</b></span>';
							if($flg){
								$new_mesg .= ' <span class="fnt_clr_gry">'.__('on',true).'</span><p>' . $eTitle . '</p>';
							}
                            $new_text = $eTitle;
                            // Here Activity for Set favorite task
                         } elseif ($caseReplyType == 9) {
                            $msg = ' <span class="col-rslvd">'.__('Status changed',true).'</span> <span class="fnt_clr_gry">'.__('on',true).'</span><p>' . $eTitle . '</p>';
                            $new_mesg = '<span class="col-rslvd"><b>'.__('Status changed',true).'</b></span>';
							if($flg){
								$new_mesg .= ' <span class="fnt_clr_gry">'.__('on',true).'</span><p>' . $eTitle . '</p>';
							}
                            $new_text = $eTitle;
                            // Here Activity for Set favorite task
                         } elseif ($caseReplyType == 10) {
                            $msg = ' <span class="col-rslvd">'.__('Added time log',true).'</span> <span class="fnt_clr_gry">'.__('on',true).'</span><p>'. $eTitle . '</p>';
                            $new_mesg = '<span class="col-rslvd"><b>'.__('Added time log',true).'</b></span>';
							if($flg){
								$new_mesg .= ' <span class="fnt_clr_gry">'.__('on',true).'</span><p>'. $eTitle . '</p>';
							}
                            $new_text = $eTitle;
                            // Here Activity for Set favorite task
                         } elseif ($caseReplyType == 11) {
                            $msg = ' <span class="col-rslvd">'.__('Updated time log',true).'</span> <span class="fnt_clr_gry">'.__('on',true).'</span><p>'. $eTitle . '</p>';
                            $new_mesg = '<span class="col-rslvd"><b>'.__('Updated time log',true).'</b></span>';
							if($flg){
								$new_mesg .= ' <span class="fnt_clr_gry">'.__('on',true).'</span><p>'. $eTitle . '</p>';
							}
                            $new_text = $eTitle;
                            // Here Activity for Set favorite task
                        } elseif ($caseReplyType == 13) {
                            $msg = ' <span class="col-rslvd">'.__('Set favorite task',true).'</span> <p>' . $eTitle . '</p>';
                            $new_mesg = '<span class="col-rslvd"><b>'.__('Set favorite task',true).'</b></span>';
							if($flg){
								$new_mesg .= '<p>' . $eTitle . '</p>';
							}
                            $new_text = $eTitle;
                             // Here Activity for Set favorite task
                        } elseif ($caseReplyType == 14) {
                            $msg = ' <span class="col-rslvd">'.__('Removed favorite task',true).'</span> <p>' . $eTitle . '</p>';
                            $new_mesg = '<span class="col-rslvd"><b>'.__('Removed favorite task',true).'</b></span>';
							if($flg){
								$new_mesg .= '<p>' . $eTitle . '</p>';
							}
                            $new_text = $eTitle;
                        }
                    } else {
                        $msg = ' <span class="col-wip">'.__('Replied',true).' </span><span class="fnt_clr_gry">'.__('on',true).'</span> <p>' . $eTitle . '</p>';
                        $new_mesg = '<span class="col-wip"><b>'.__('Replied',true).'</b> </span>';
						if($flg){
							$new_mesg .= ' <span class="fnt_clr_gry">'.__('on',true).'</span> <p>' . $eTitle . '</p>';
						}
                        $new_text = '<span class="fnt_clr_gry">'.__('On',true).'</span> ' . $eTitle;
                    }
                } else {
                    $msg = ' <span class="col-crt">'.__('Created',true).'</span> <p>' . $eTitle . '</p>';
                    $new_mesg = '<span class="col-crt"><b>'.__('Created',true).'</b></span>';
					if($flg){
						$new_mesg .= '<p>' . $eTitle . '</p>';
					}
                    $new_text = $eTitle;
                }
                $activity[$k]['Easycase']['msg'] = $msg;
                $activity[$k]['Easycase']['puserid'] = $createdId;
                $activity[$k]['Easycase']['pclient_status'] = $clientStatus;
                $activity[$k]['Easycase']['nmsg'] = $new_mesg;
                $activity[$k]['Easycase']['ntxt'] = $new_text;
                if ($project_id != 'all') {
                    if ($project_id == $v['Project']['id']) {
                        $activity[$k]['Project']['name'] = '';
                    } else {
                        $activity[$k]['Project']['name'] = $v['Project']['name'];
                    }
                }
            }
            $activity = array_values($activity);
        }
        return array('activity' => $activity, 'total' => $total);
    }

    function getOverdue($projid, $today, $type = NULL) {
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $Easycase = ClassRegistry::init('Easycase');
        $qry = '';
        if ($projid == 'all') {
            $getAllProj = $ProjectUser->find('all', array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'ProjectUser.project_id'));
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
            $pjids = $projid;
            $qry = "AND Project.uniq_id = '" . $pjids . "'";
        }
        $cond = '';
        if ($type == 'my') {
            $cond = " AND Easycase.assign_to ='" . SES_ID . "'";
        } elseif ($type == 'delegated') {
            $cond = " AND Easycase.user_id ='" . SES_ID . "' AND Easycase.assign_to !='" . SES_ID . "'";
        }

        $clt_sql = 1;
        if (CakeSession::read("Auth.User.is_client") == 1) {
            $clt_sql = "((Easycase.client_status = " . CakeSession::read("Auth.User.is_client") . " AND Easycase.user_id = " . CakeSession::read("Auth.User.id") . ") OR Easycase.client_status != " . CakeSession::read("Auth.User.is_client") . ")";
        }

        $over_milestone = "SELECT  `Easycase`.case_no,`Easycase`.dt_created,`Easycase`.uniq_id,`Easycase`.project_id,`Easycase`.due_date,
		    `Easycase`.title, `User`.name FROM `easycases` AS `Easycase` inner JOIN  project_users AS `ProjectUser` 
		    ON (`Easycase`.`project_id` = `ProjectUser`.`project_id`) inner JOIN `users` AS `User` 
		    ON(`Easycase`.`user_id` = `User`.`id` AND `Easycase`.`due_date` < '" . $today . "' AND  `Easycase`.`due_date`!= '0000-00-00 00:00:00' 
		    AND `Easycase`.`due_date`!= 'NULL' AND Easycase.isactive='1' AND `Easycase`.istype ='1' AND Easycase.title !='' " . $cond . "
		    AND `Easycase`.legend !='3' AND `Easycase`.legend !='5') inner JOIN `projects` AS `Project` 
		    ON(`ProjectUser`.`project_id`=`Project`.`id` AND `Project`.`isactive`='1') WHERE `ProjectUser`.`user_id` = '" . SES_ID . "' 
		    AND " . $clt_sql . " AND `ProjectUser`.`company_id` = '" . SES_COMP . "' " . $qry . " order by `Easycase`.due_date DESC LIMIT 0,5";
        $overdue = $Easycase->query($over_milestone);

        return $overdue;
    }

    function getUpcoming($projid, $today, $type = NULL, $limit = 5) {
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $Easycase = ClassRegistry::init('Easycase');
        $qry = '';
        if ($projid == 'all') {
            $getAllProj = $ProjectUser->find('all', array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'ProjectUser.project_id'));
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
            $pjids = $projid;
            $qry = "AND Project.uniq_id = '" . $pjids . "'";
        }
        $cond = '';
        if ($type == 'my') {
            $cond = " AND Easycase.assign_to ='" . SES_ID . "'";
        } elseif ($type == 'delegated') {
            $cond = " AND Easycase.user_id ='" . SES_ID . "' AND Easycase.assign_to !='" . SES_ID . "'";
        }
        $clt_sql = 1;
        if (CakeSession::read("Auth.User.is_client") == 1) {
            $clt_sql = "((Easycase.client_status = " . CakeSession::read("Auth.User.is_client") . " AND Easycase.user_id = " . CakeSession::read("Auth.User.id") . ") OR Easycase.client_status != " . CakeSession::read("Auth.User.is_client") . ")";
        }
        $next_milestone = "SELECT  `Easycase`.case_no,`Easycase`.dt_created,`Easycase`.uniq_id,`Easycase`.project_id,`Easycase`.due_date, 
		    `Easycase`.title, `User`.name, `Project`.name, `Project`.uniq_id FROM `easycases` AS `Easycase` inner JOIN  project_users AS `ProjectUser` 
		    ON (`Easycase`.`project_id` = `ProjectUser`.`project_id`) inner JOIN `users` AS `User`
		    ON(`Easycase`.`user_id` = `User`.`id` AND `Easycase`.`due_date` >= '" . $today . "' AND Easycase.isactive='1'
		    AND `Easycase`.istype ='1' AND Easycase.title !='' " . $cond . ") inner JOIN `projects` AS `Project` ON(`ProjectUser`.`project_id`=`Project`.`id` 
		    AND `Project`.`isactive`='1') WHERE `ProjectUser`.`user_id` = '" . SES_ID . "' AND " . $clt_sql . " AND `ProjectUser`.`company_id` = '" . SES_COMP . "'
		    " . $qry . " order by `Easycase`.due_date ASC LIMIT 0,$limit";
        $upcoming = $Easycase->query($next_milestone);

        return $upcoming;
    }

    /**
     * @method: public downgrade_limitation(array $subscriptin) Checking limitation of the user while upgrading the plan
     * @author GDR<abc@mydomain.com>
     * @return array
     */
    function downgrade_limitation($subscription = array(), $plan_id = null) {
        if ($subscription) {
            // Checking for Project Limitation
            $Project = ClassRegistry::init('Project');
            $Project->recursive = -1;
            $totProj = $Project->find('count', array('conditions' => array('Project.company_id' => SES_COMP), 'fields' => 'DISTINCT Project.id'));
            $retarr['totproj'] = $totProj;
            // Checking for User Limitation
            $companyusers_cls = ClassRegistry::init('CompanyUser');
            $crnt_paid_plans = Configure::read('CURRENT_PAID_PLANS');
            if (array_key_exists($plan_id, $crnt_paid_plans)) {
                $totalUsers = $companyusers_cls->find('count', array('conditions' => array('company_id' => SES_COMP, 'is_active' => 1,'role_id !='=>699)));
            } else {
                $totalUsers = $companyusers_cls->find('count', array('conditions' => array('company_id' => SES_COMP, 'is_active !=' => 3,'role_id !='=>699)));
            }
            //check guest user
            $totalGuestUsers = $companyusers_cls->find('count', array('conditions' => array('company_id' => SES_COMP,'is_active' => 1,'role_id'=>699)));
            $retarr['totalusers'] = $totalUsers;
            $retarr['totalGuestUsers'] = $totalGuestUsers;
            // Checking for Storage Limitation
            App::import('Component', 'Format');
            $format = new FormatComponent(new ComponentCollection);
            $used_space = $format->usedSpace(0,SES_COMP,1);
            $retarr['used_space'] = $used_space;
            // Validating data with downgraded subscription Limit
            $retarr['proj_limit_exceed'] = 0;
            $retarr['user_limit_exceed'] = 0;
            $retarr['storage_limit_exceed'] = 0;
            if (strtolower($subscription['project_limit']) != 'unlimited') {
                if ($totProj > $subscription['project_limit']) {
                    $retarr['proj_limit_exceed'] = 1;
                }
            }
            if (strtolower($subscription['user_limit']) != 'unlimited') {
                if ($totalUsers > $subscription['user_limit']) {
                    $retarr['user_limit_exceed'] = 1;
                }
                $allowed_guest_user = floor((50*$subscription['user_limit'])/100);
                if ($totalGuestUsers > $allowed_guest_user) {
                    $retarr['guest_user_limit_exceed'] = 1;
                }
            }
            if (strtolower($subscription['storage']) != 'unlimited') {
                if ($used_space > $subscription['storage']) {
                    $retarr['storage_limit_exceed'] = 1;
                }
            }
            return $retarr;
        } else {
            return false;
        }
    }

    function getProjectOwnAdmin() {
        return $this->query("SELECT User.name,User.last_name,User.id,User.short_name,CompanyUser.user_type FROM users AS User,company_users AS CompanyUser WHERE User.id=CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active ='1' AND CompanyUser.user_type!='3' AND User.isactive='1' ORDER BY CompanyUser.user_type ASC");
    }

    /**
     * @Method: Public validate_emailurl($data=array()) Check email and URL existance with our db
     * @author GDR <abc@mydomain.com>
     * @return array 
     */
    function validate_emailurl($data = array()) {
        $this->recursive = -1;
        $arr['email'] = 'success';
        $arr['seourl'] = 'success';
        if ($data['email']) {
			if(isset($_SESSION['OS_OUTER_INFO_DISP'])){
				unset($_SESSION['OS_OUTER_INFO_DISP']);
			}
            if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $checkUsr = $this->find('first', array('conditions' => array('User.email' => urldecode($data['email'])), 'fields' => array('User.id')));
                if ($checkUsr['User']['id']) {
                    $arr['email'] = 'error';
                    $arr['email_msg'] = __("Email already exists! Please try another");
                }
            } else {
                $arr['email'] = 'error';
                $arr['email_msg'] = __("Please enter a valid email.");
            }
        }
		if (isset($data['seo_url']) && $data['seo_url']) {
        $Company = ClassRegistry::init('Company');
        $Company->recursive = -1;
        $seo_url = urldecode($data['seo_url']);
			//$all_mail = array('yahoo', 'hotmail', 'live', 'reddif', 'outlook', 'rediff', 'aim', 'zoho', 'icloud', 'mail', 'gmax', 'shortmail', 'inbox', 'gmail', 'helpdesk','blah');
			$is_exst_seo = $this->validateExtComp($seo_url);
        $check = 0;
			if (!$is_exst_seo['status']) {
            $check = 1;
        }
        if ($seo_url == 'app' || $seo_url == 'www' || $check) {
            $arr['seourl'] = 'error';
            $arr['seourl_msg'] = "<b>'" . $seo_url . "'</b>".__(" is not allowed.");
        } else {
            $checkUsr = $Company->find('first', array('conditions' => array('Company.seo_url' => $seo_url), 'fields' => array('Company.id')));
            if ($checkUsr['Company']['id']) {
                $arr['seourl'] = 'error';
                $arr['seourl_msg'] = __("Oops, site address already in use!");
            }
        }
        if (isset($data['company_name']) && $data['company_name']) {
            $company_name = urldecode($data['seo_url']);
            $checkUsr = $Company->find('first', array('conditions' => array('Company.name' => $company_name), 'fields' => array('Company.id')));
            if ($checkUsr['Company']['id']) {
                $arr['company_name'] = 'error';
                $arr['company_name_msg'] = __("Oops, company name already in use!");
            }
        }
		}
        if (isset($data['coupon_code']) && $data['coupon_code']) {
            $Coupon = ClassRegistry::init('Coupon');
            $Coupon->recursive = -1;
            $coupon = $Coupon->find('first', array('conditions' => array('Coupon.code' => trim($data['coupon_code']), 'Coupon.isactive' => '1', array('OR' => array('Coupon.expires >= CURDATE()', 'Coupon.expires' => '0000-00-00')))));
            if (!$coupon) {
                $arr['coupon'] = 'error';
                $arr['coupon_msg'] = __("Invalid coupon code!");
            } elseif ($coupon['Coupon']['company_id']) {
                $arr['coupon'] = 'error';
                $arr['coupon_msg'] = __("Oops! Coupon code has already used.");
            }
        }
        return $arr;
    }

    /**
     * @Method: Public keepPassChk($uid) Check users logged in different browsers and logged out if some one changes the password
     * @author PRB <abc@mydomain.com>
     * @return array 
     */
    function keepPassChk($uid) {
        App::import('Model', 'OsSessionLog');
        $OsSessionLog = new OsSessionLog();
        $existing_ses = $OsSessionLog->getUserDetls($uid);
        $rec_user_login = $this->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.password', 'User.name', 'User.email')));
        $ck_val = '';
        if (empty($rec_user_login['User']['name'])) {
            $_t_nm = explode('@', $rec_user_login['User']['email']);
            $arr_user_rec = array('temp_name' => $_t_nm[0], 'email' => $rec_user_login['User']['email']);
        } else {
            $arr_user_rec = array('temp_name' => $rec_user_login['User']['name'], 'email' => $rec_user_login['User']['email']);
        }
        if (isset($_COOKIE['helpdesk_uniq_agent'])) {
            unset($_COOKIE['helpdesk_uniq_agent']);
        }
        setcookie('helpdesk_uniq_agent', json_encode($arr_user_rec), time() + 60 * 60 * 24 * 30 * 12, '/', DOMAIN_COOKIE, false, false);
        if (!$_COOKIE['user_uniq_agent']) {
            $var_unq = uniqid(rand());
            setcookie('user_uniq_agent', $_SESSION['Config']['userAgent'] . $var_unq, time() + 60 * 60 * 24 * 30 * 12, '/', DOMAIN_COOKIE, false, false);
            $ck_val = $_SESSION['Config']['userAgent'] . $var_unq;
        } else {
            $ck_val = $_COOKIE['user_uniq_agent'];
        }
        if ($existing_ses) {
            $existing_ses['OsSessionLog']['user_agent'][$ck_val] = $rec_user_login['User']['password'];
            $existing_ses['OsSessionLog']['user_agent'] = json_encode($existing_ses['OsSessionLog']['user_agent']);
            $OsSessionLog->save($existing_ses);
        } else {
            $existing_ses_input['OsSessionLog']['user_id'] = $uid;
            $existing_ses_input['OsSessionLog']['user_agent'] = json_encode(array($ck_val => $rec_user_login['User']['password']));
            $OsSessionLog->save($existing_ses_input);
        }
    }

    function add_inline_project($data, $userid, $comp_id, $name, $obj) {
        App::import('Model', 'Company');
        $Company = new Company();
        App::import('Model', 'User');
        $userscls = new User();
        App::import('Model', 'CompanyUser');
        $companyusercls = new CompanyUser();

        App::import('Model', 'Project');
        $Project = new Project();

        $comp = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('Company.name')));
        $postProject['Project'] = $data;
        $memberslist = '';
        $is_first_project = 0;
        if ($postProject['Project']['members']) {
            $memberslist = array_unique($postProject['Project']['members']);
            $is_first_project = 1;
        }
        if ($postProject['Project']['validate'] == 1) {

            $prjUniqId = md5(uniqid());
            $postProject['Project']['uniq_id'] = $prjUniqId;
            $postProject['Project']['user_id'] = $userid;
            $postProject['Project']['project_type'] = 1;
            $postProject['Project']['default_assign'] = $userid;
            $postProject['Project']['isactive'] = 1;
            $postProject['Project']['dt_created'] = GMT_DATETIME;
            $postProject['Project']['company_id'] = $comp_id;

            if ($Project->save($postProject)) {
                $prjid = $Project->getLastInsertID();
                //Creating default task after first project created.

                $new_tasks_head = Configure::read('TASK_HEAD');
                $new_tasks_foot = Configure::read('TASK_FOOT');
                $name = "Hey, " . ucfirst($name) . "!";
                $task_welcome = '<h1 style="margin:5px 0 20px 0;color:#2f2f2f;font-size:26px;line-height:35px;font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;font-weight:normal">' . ucfirst($name) . '</h1>
                                        <p style="font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif;color:#999999;font-size:16px;line-height:26px">We\'re so happy that you\'re here. Here are a few key resources to help you get started:</p>';

                if ($is_first_project) {
                    $new_tasks_default = Configure::read('DEFAULT_TASK_INPUT');
                    foreach ($new_tasks_default as $k => $v) {
                        $new_tasks = array();
                        $new_task['CS_project_id'] = $prjUniqId;
                        $new_task['CS_istype'] = 1;
                        $new_task['CS_title'] = $v['title'];
                        $new_task['CS_type_id'] = 8; //update
                        $new_task['CS_priority'] = 1;
                        $description = '';
                        if ($v['title'] == 'Welcome to Orangescrum') {
                            $description = $task_welcome;
                        }
                        $description .= $new_tasks_head . $v['description'] . $new_tasks_foot;
                        $new_task['CS_message'] = $description;
                        $new_task['CS_assign_to'] = $userid;
                        $new_task['CS_user_id'] = $userid;
                        $new_task['CS_due_date'] = 'No Due Date';
                        $new_task['CS_id'] = 0;
                        $new_task['datatype'] = 0;
                        $new_task['CS_legend'] = 1;
                        $new_task['prelegend'] = '';
                        $new_task['hours'] = 0;

                        $new_task['estimated_hours'] = 0;
                        $new_task['completed'] = 0;
                        $new_task['taskid'] = 0;
                        $new_task['task_uid'] = 0;
                        $new_task['editRemovedFile'] = '';
                        $new_task['is_client'] = 0;
                        $obj->Postcase->casePosting($new_task);
                    }
                }

                App::import('Model', 'ProjectUser');
                $ProjectUser = new ProjectUser();
                $ProjectUser->recursive = -1;

                $getLastId = $ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
                $lastid = $getLastId[0][0]['maxid'] + 1;
                if (!empty($memberslist)) {
                    foreach ($memberslist as $members) {
                        $ProjUsr['ProjectUser']['id'] = $lastid;
                        $ProjUsr['ProjectUser']['project_id'] = $prjid;
                        $ProjUsr['ProjectUser']['user_id'] = $members;
                        $ProjUsr['ProjectUser']['company_id'] = $comp_id;
                        $ProjUsr['ProjectUser']['default_email'] = 1;
                        $ProjUsr['ProjectUser']['istype'] = 1;
                        $ProjUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                        $ProjectUser->saveAll($ProjUsr);
                        $lastid = $lastid + 1;
                    }
                }
                setcookie('LAST_CREATED_PROJ', $prjid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                //if(!isset($_COOKIE['TASKGROUPBY_DBDT'])){
                //setcookie('TASKGROUPBY_DBD', 'active', COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
                //setcookie('TASKGROUPBY_DBDT', 'active', COOKIE_REM, '/', DOMAIN_COOKIE, false, false);	
                //}
                /* $CompanyUser = ClassRegistry::init('CompanyUser');
                  $checkMem = $CompanyUser->find('all', array('conditions' => array('CompanyUser.company_id' => $comp_id, 'CompanyUser.is_active' => 1)));
                  if (isset($checkMem['CompanyUser']['id']) && $checkMem['CompanyUser']['id']) {
                  if (count($memberslist) < count($checkMem)) {
                  setcookie('LAST_PROJ', $prjid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                  }
                  setcookie('ASSIGN_USER', $prjid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                  setcookie('PROJ_NAME', trim($postProject['Project']['name']), time() + 3600, '/', DOMAIN_COOKIE, false, false);
                  $this->redirect(HTTP_ROOT . "projects/manage");
                  } else {
                  if(!isset($_COOKIE['TASKGROUPBY_DBDT'])){
                  setcookie('TASKGROUPBY_DBD', 'active', COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
                  setcookie('TASKGROUPBY_DBDT', 'active', COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
                  }
                  } */
                return $prjid;
            }
        }
    }

    function new_inline_milestone($data = null, $userid, $comp_id, $proj_id) {

        App::import('Model', 'ProjectUser');
        $ProjectUser = new ProjectUser();

        App::import('Model', 'Milestone');
        $Milestone = new Milestone();

        App::import('Model', 'EasycaseMilestone');
        $EasycaseMilestone = new EasycaseMilestone();

        App::import('Model', 'Easycase');
        $Easycase = new Easycase();
        $taskIds = $Easycase->find('all', array('conditions' => array('Easycase.project_id' => $proj_id, 'Easycase.user_id' => $userid), 'fields' => array('Easycase.id')));
        $taskIds = Hash::extract($taskIds, '{n}.Easycase.id');

        $arr = array();
        if ($data) {

            $array_milstone = array();
            foreach ($data as $k => $v) {
                $array_milstone['Milestone']['title'] = $v;
                $mlUniqId = md5(uniqid());
                $array_milstone['Milestone']['uniq_id'] = $mlUniqId;
                $array_milstone['Milestone']['project_id'] = $proj_id;
                $array_milstone['Milestone']['company_id'] = $comp_id;
                $array_milstone['Milestone']['user_id'] = $userid;
                if ($Milestone->saveAll($array_milstone)) {
                    $milestone_id_now = $Milestone->getLastInsertId();
                    if ($k == 1) {
                        $temp_taskIds = array_slice($taskIds, 9, 1);
                    } else if ($k == 2) {
                        $temp_taskIds = array_slice($taskIds, 6, 3);
                    } else if ($k == 3) {
                        $temp_taskIds = array_slice($taskIds, 1, 5);
                    } else {
                        $temp_taskIds = array_slice($taskIds, 0, 1);
                    }
                    if ($temp_taskIds) {
                        $emarr = array();
                        $id_seq_arr = $EasycaseMilestone->query('SELECT MAX(id_seq) as id_seq FROM easycase_milestones WHERE milestone_id = ' . $milestone_id_now);
                        $id_seq = '';
                        if ($id_seq_arr['0'][0]['id_seq']) {
                            $id_seq = $id_seq_arr['0'][0]['id_seq'];
                        }
                        $caseMilestone = array();
                        foreach ($temp_taskIds as $kt => $vt) {
                            if ($v) {
                                $caseMilestone['EasycaseMilestone']['easycase_id'] = $vt;
                                $caseMilestone['EasycaseMilestone']['milestone_id'] = $milestone_id_now;
                                $caseMilestone['EasycaseMilestone']['project_id'] = $proj_id;
                                $caseMilestone['EasycaseMilestone']['user_id'] = $userid;
                                if ($id_seq != '') {
                                    $caseMilestone['EasycaseMilestone']['id_seq'] = (int) ($id_seq + 1);
                                    $id_seq = $caseMilestone['EasycaseMilestone']['id_seq'];
                                } else {
                                    $caseMilestone['EasycaseMilestone']['id_seq'] = 1;
                                    $id_seq = 1;
                                }
                                $EasycaseMilestone->saveAll($caseMilestone);
                            }
                        }
                    }

                    $ProjectUser->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE user_id=" . $userid . " and project_id='" . $this->request->data['Milestone']['project_id'] . "' and company_id='" . $comp_id . "'");
                }
                //return $arr;
            }
        }
    }

    function checkUserTrialExist($email) {
        $sql_chk = "SELECT company_trial_expired,is_active FROM company_users WHERE user_id = (SELECT id FROM users WHERE email = '" . $email . "' AND isactive =1 LIMIT 1)"; // AND user_type !=1
        $ret = $this->query($sql_chk);
        return $ret;
    }

    function getCcodeFromId($id) {
        $cntry = $this->query('SELECT ccode FROM countries WHERE id=' . $id);
        if ($cntry) {
            return $cntry[0]['countries']['ccode'];
        } else {
            return 0;
        }
    }

    function getIdFromCcode($code) {
        $cntry = $this->query('SELECT id FROM countries WHERE ccode="' . $code . '"');
        if ($cntry) {
            return $cntry[0]['countries']['id'];
        } else {
            return 0;
        }
    }

    function getProfileBgColr($uid = null) {
        if ($uid) {
            $t_clr = Configure::read('PROFILE_BG_CLR');
            $random_bgclr = $t_clr[array_rand($t_clr, 1)];
            $ret_colr = $random_bgclr;
            if (!isset($_SESSION['user_profile_colr'])) {
                $_SESSION['user_profile_colr'] = array();
                $_SESSION['user_profile_colr'][$uid] = $random_bgclr;
            } else {
                if (!array_key_exists($uid, $_SESSION['user_profile_colr'])) {
                    $_SESSION['user_profile_colr'][$uid] = $random_bgclr;
                } else {
                    $ret_colr = $_SESSION['user_profile_colr'][$uid];
                }
            }
            return $ret_colr;
        }
    }

    function getLoginUserEmail($uid) {
        return $this->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.email')));
    }

    function fetchUserTrialDays($comp_id, $type = null) {
        App::import('Model', 'UserSubscription');
        $UserSubscription = new UserSubscription();
        if ($type) {
            $usersub_t = $UserSubscription->find('first', array('conditions' => array('company_id' => $comp_id), 'order' => "id DESC"));
            if ($usersub_t['UserSubscription']['is_cancel'] == 1) {
                return 0;
            }
        } else {
            $usersub_t = $UserSubscription->find('first', array('conditions' => array('company_id' => $comp_id), 'order' => "id ASC"));
        }
        $datetime1 = new DateTime(date("Y-m-d H:i:s"));
        if ($usersub_t['UserSubscription']['extend_trial'] != 0) {
            $t_dt = date('Y-m-d H:i:s', strtotime('+' . $usersub_t['UserSubscription']['extend_trial'] . ' days', strtotime($usersub_t['UserSubscription']['extend_date'])));
        } else {
            if ($type) {
                $t_dt = date("Y-m-d H:i:s", strtotime($usersub_t['UserSubscription']['next_billing_date']));
            } else {
                $t_dt = date("Y-m-d H:i:s", strtotime($usersub_t['UserSubscription']['created'] . ' +' . FREE_TRIAL_PERIOD . 'days'));
            }
        }
        $datetime2 = new DateTime($t_dt);
        $interval = $datetime1->diff($datetime2);

        $days_lft = $interval->format('%R%a');
        if ($days_lft <= 0) {
            return 0;
        } else {
			if($usersub_t['UserSubscription']['lifetime_free']){ //no trial for free plan accounts - free for ever plan
				return 0;
			}else{
				return $interval->format('%a');
			}
        }
    }

    function intermidiateCancelAmount($comp_id) {
        App::import('Model', 'UserSubscription');
        $UserSubscription = new UserSubscription();
        $usersub_t = $UserSubscription->find('first', array('conditions' => array('company_id' => $comp_id), 'order' => "id DESC"));
        $datetime1 = new DateTime(date("Y-m-d H:i:s"));
        $datetime2 = new DateTime($usersub_t['UserSubscription']['next_billing_date']);
        //$date1=date_create(date("Y-m-d"));
        //$date2=date_create(date('Y-m-d', strtotime($usersub_t['UserSubscription']['next_billing_date'])));
        //$diff=date_diff($date1,$date2);
        $interval = $datetime1->diff($datetime2);
        $days_lft = $interval->format('%R%a');
        if ($days_lft <= 0) {
            return 0;
        } else {
            $day = 30 * $usersub_t['UserSubscription']['month'];
            $t_day = $day - $interval->format('%a');
            $t_price = round($t_day * ($usersub_t['UserSubscription']['price'] / $day));
            return $t_price;
        }
    }

    function saveCancelTransactio($result, $user_sub, $obj, $type = null) {
        App::import('Model', 'Company');
        $Companies = new Company();

        App::import('Component', 'Format');
        $format = new FormatComponent(new ComponentCollection);

        App::import('Component', 'Postcase');
        $Postcase = new Postcase();
        App::import('Component', 'Sendgrid');
        $Sendgrid = new Sendgrid();
        echo "<pre>";
        print_r($result);
        exit;
        if ($result->success) {
            //App::import('Model','Transaction');
            //$Transactions = new Transaction();

            $tdata = null;
            $tdata['Transactions']['company_id'] = $user_sub['UserSubscription']['company_id'];
            $tdata['Transactions']['user_id'] = $user_sub['UserSubscription']['user_id'];
            $tdata['Transactions']['btsubscription_id'] = $user_sub['UserSubscription']['btsubscription_id'];
            $tdata['Transactions']['transaction_id'] = $result->transaction->id;
            $tdata['Transactions']['status'] = $result->transaction->status;
            $tdata['Transactions']['subscription_price'] = $cal_amt;
            $tdata['Transactions']['amt'] = $cal_amt;
            $tdata['Transactions']['transaction_type'] = 'Instant Payment on cancellation during upgrade or downgrade';
            $tdata['Transactions']['created'] = GMT_DATETIME;
            $tdata['Transactions']['invoice_id'] = $format->generate_invoiceid();
            $tdata['Transactions']['plan_id'] = $user_sub['UserSubscription']['subscription_id'];
            $obj->Transactions->save($tdata);
            $ltid = $obj->Transactions->getLastInsertId();

            //Event log data and inserted into database for instantpayment -- Start
            $json_arr['btsubscription_id'] = $tdata['Transactions']['btsubscription_id'];
            $json_arr['price'] = $cal_amt;
            $json_arr['transaction_id'] = $result->transaction->id;
            $json_arr['company_id'] = $user_sub['UserSubscription']['company_id'];
            $json_arr['owner_name'] = $userinfo['User']['name'] . " " . $userinfo['User']['last_name'];
            $json_arr['email'] = $userinfo['User']['email'];
            $json_arr['date'] = GMT_DATETIME;
            $Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 20);
            //End 
            $invo_file_name = "OrangeScrum_Invoice_" . $tdata['Transactions']['invoice_id'] . ".pdf";
            // Invoice mail on instant payment
            exec(PDF_LIB_PATH . " " . HTTP_ROOT . "users/instantinvoice/subscriptionId:" . $user_sub['UserSubscription']['btsubscription_id'] . "/transactionId:" . $ltid . " " . DIR_IMAGES . "pdf/" . $invo_file_name);
            $message = "<table cellpadding='1' cellspacing='1' align='left' width='100%'>" . EMAIL_HEADER . "
                        <tr><td>&nbsp;</td></tr>
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>Hi " . $userinfo['User']['name'] . " " . $userinfo['User']['last_name'] . ",</td></tr>
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>Thank you for being a customer.</b></td></tr>
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>Please find the attached invoice <b>" . $invo_file_name . "</b></td></tr>
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>	   
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>This is your receipt of payment against your credit card on cancellation of account an amount of <b>$" . $cal_amt . "</b> </td></tr>	   
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>Thank you</td></tr>
                        <tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
                        <tr height='25px'><td>&nbsp;</td></tr>
                        " . EMAIL_FOOTER . "</table>";
            $subject = "Instant Payment: " . $tdata['Transactions']['invoice_id'];
            $file = $invo_file_name;
            //$response = $Sendgrid->sub_sendgrid(FROM_EMAIL, $userinfo['User']['email'], $subject, $message, $file, '', $bcc);
            $response = true;
            if ($response) {
                $tdata = array('id' => $ltid, 'invoice_mail_flag' => '1');
                $obj->Transactions->save($tdata);
                //Event log data and inserted into database for invoice mail -- Start
                $json_arr['btsubscription_id'] = $tdata['Transactions']['btsubscription_id'];
                $json_arr['invoice_id'] = $tdata['Transactions']['invoice_id'];
                $json_arr['transaction_id'] = $result->transaction->id;
                $json_arr['company_id'] = $user_sub['UserSubscription']['company_id'];
                $json_arr['owner_name'] = $userinfo['User']['name'] . " " . $userinfo['User']['last_name'];
                $json_arr['email'] = $userinfo['User']['email'];
                $json_arr['date'] = GMT_DATETIME;
                $Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 22);
            } else {
                //Event log data and inserted into database for invoice mail not sent -- Start
                $json_arr['btsubscription_id'] = $tdata['Transactions']['btsubscription_id'];
                $json_arr['invoice_id'] = $tdata['Transactions']['invoice_id'];
                $json_arr['transaction_id'] = $result->transaction->id;
                $json_arr['company_id'] = $user_sub['UserSubscription']['company_id'];
                $json_arr['owner_name'] = $userinfo['User']['name'] . " " . $userinfo['User']['last_name'];
                $json_arr['email'] = $userinfo['User']['email'];
                $json_arr['date'] = GMT_DATETIME;
                $Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 23);
            }
            $accountinfo = $Companies->find('first', array('conditions' => array('id' => $company_id)));
            $subject = "Successful Instant payment for Account: " . $accountinfo['Companies']['name'];
            $message = "Admin received a sum of $" . $cal_amt . " in his account because of the cancellation of account '" . $accountinfo['Companies']['name'] . "' on @dated:" . date('m/d/Y H:i:s') . "<br/>" . " From site: " . HTTP_HOME;
            //$Sendgrid->sub_sendgrid(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, $file, '', '');
        } else {
            $accountinfo = $Companies->find('first', array('conditions' => array('id' => $company_id)));
            $subject = "Error in Instant payment for  Account: " . $accountinfo['Companies']['name'];
            $message = "Admin didn't  received a sum of $" . $cal_amt . " in his account becasuse of the cancellation of account '" . $accountinfo['Companies']['name'] . "' on @dated:" . date('m/d/Y H:i:s') . "<br/>" . " From site: " . HTTP_HOME;
            $message .=" <br/> Because of the following error" . print_r($result, TRUE);
            //$Sendgrid->sub_sendgrid(FROM_EMAIL, TO_DEV_EMAIL, $subject, $message, '', '', '');
        }
    }
	function getUserCurrentStatus($auth_token=null, $hFormat, $comp_id=null){
		$ret = array('code'=>2000,'status'=>'OK');
		if($auth_token){
			$user = $this->getUserFields(array('User.uniq_id' => trim($auth_token)), array('User.id','User.uniq_id','User.name','User.email','User.photo','User.password','User.short_name'));
			if(!empty($user)){
				$Company = ClassRegistry::init('Company');
				$is_client = ',CompanyUser.is_client';
				$work_hour = ',Company.work_hour';
				$comp_cond = '';
				if($comp_id){
					$comp_cond = " AND CompanyUser.company_uniq_id = '".$comp_id."'";
				}
				$getComps = $Company->query("SELECT CompanyUser.user_type,CompanyUser.is_active,CompanyUser.is_access_change,CompanyUser.change_timestamp,Company.uniq_id,Company.seo_url,Company.id,Company.name".$is_client.$work_hour." FROM company_users AS CompanyUser,companies AS Company WHERE CompanyUser.company_id=Company.id AND CompanyUser.user_id='" . $user["User"]["id"]. "' AND CompanyUser.is_active=1".$comp_cond);
				if(!empty($getComps)){
					if(!$comp_id){
						$t_comp['companies'] = null;
						foreach($getComps as $kc => $vc){
							$t_comp['companies'][$vc['Company']['uniq_id']] = $vc['CompanyUser'];
							$t_comp['companies'][$vc['Company']['uniq_id']]['id'] = $vc['Company']['id'];
							$t_comp['companies'][$vc['Company']['uniq_id']]['uniq_id'] = $vc['Company']['uniq_id'];
							$t_comp['companies'][$vc['Company']['uniq_id']]['name'] = $vc['Company']['name'];
						}
						$ret['companies'] = $t_comp['companies'];
					}else{
            if($getComps[0]['CompanyUser']['is_active'] == 1){
  						$ret['uniq_id'] = $getComps[0]['Company']['uniq_id'];
  						$ret['user_type'] = $getComps[0]['CompanyUser']['user_type'];
  						$ret['change_timestamp'] = $getComps[0]['CompanyUser']['change_timestamp'];
  						$ret['is_access_change'] = $getComps[0]['CompanyUser']['is_access_change'];
  						$ret['is_client'] = $getComps[0]['CompanyUser']['is_client'];
              $ret['work_hour'] = $getComps[0]['Company']['work_hour'];
            }else{
  						$ret['code'] = 2006;
  						$ret['status'] = "failure";
  						$ret['msg'] = __("Your account has been deactivated. Please contact your account owner.");
                                              }
  					}
						$ret['uid'] = $user["User"]["id"];
						$ret['name'] = $user["User"]["name"];
						$ret['email'] = $user["User"]["email"];
						$ret['password'] = $user["User"]["password"];
					$ret['short_name'] = $user["User"]["short_name"];
					$img_url = '';
					if($comp_id){
						$http_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? "https://" : "http://";
						if(isset($user["User"]["photo"]) && !empty($user["User"]["photo"])) {
							if (defined('USE_S3') &&  USE_S3) {
								$img_url = $http_url.$getComps[0]['Company']['seo_url'].USE_IMAGE_URL.'/users/image_thumb/?type=photos&file='.$user['User']['photo'].'&sizex=100&sizey=100&quality=100';
							}else{						
								$img_url = $http_url.$getComps[0]['Company']['seo_url'].USE_IMAGE_URL.'/users/image_thumb/?type=photos&file='.$user['User']['photo'].'&sizex=100&sizey=100&quality=100';
							}
						}
						}
					$ret['photo'] = $img_url;
					
					}else{
						$ret['code'] = 2006;
						$ret['status'] = "failure";
					$ret['msg'] = __("Your account has been deactivated. Please contact your account owner.");
				}
			}else{
				$ret['code'] = 2003;
				$ret['status'] = "failure";
				$ret['msg'] = __("Auth token is invalid!");
			}
		}else{
			$ret['code'] = 2003;
			$ret['status'] = "failure";
			$ret['msg'] = __("Auth token is invalid!");
		}	
		return $ret;
	}

	function newInviteUserApi($in_data, $type, $more = null, $pids = null) {
        $uArray = array();
		App::import('Component', 'Format');
		$format = new FormatComponent(new ComponentCollection);
		$ProjectUser = ClassRegistry::init('ProjectUser');
        if ($pids) {
            if (is_array($pids)) {
                $in_data['User']['pid'] = implode(',', $pids);
            } else {
                $in_data['User']['pid'] = $pids;
}
        } else {
            if (isset($in_data['User']['pid'])) {
                if (is_array($in_data['User']['pid'])) {
                    $in_data['User']['pid'] = implode(',', $in_data['User']['pid']);
                } else {
                    $in_data['User']['pid'] = $in_data['User']['pid'];
                }
            }
        }
        if (isset($in_data['User']['password']) && $in_data['User']['password']) {
            $pass = '';
            $uArray['User']['password'] = $in_data['User']['password'];
        } else {
            $pass = $format->genRandomString();
            $uArray['User']['password'] = md5($pass);
        }
        if (isset($in_data['User']['timezone_id']) && $in_data['User']['timezone_id']) {
            $uArray['User']['timezone_id'] = $in_data['User']['timezone_id'];
        } else {
            $uArray['User']['timezone_id'] = $in_data['TimezoneName']['id'];
        }
        if (isset($in_data['User']['ip']) && $in_data['User']['ip']) {
            $uArray['User']['ip'] = $in_data['User']['ip'];
        } else {
            $uArray['User']['ip'] = $_SERVER['REMOTE_ADDR'];
        }
        if (isset($in_data['User']['last_name']) && $in_data['User']['last_name']) {
            $uArray['User']['last_name'] = $in_data['User']['last_name'];
        } else {
            $uArray['User']['last_name'] = '';
        }
        if (isset($in_data['User']['short_name']) && $in_data['User']['short_name']) {
            $uArray['User']['short_name'] = $in_data['User']['short_name'];
        } else {
            $uArray['User']['short_name'] = $format->makeShortName($in_data['User']['name'], '');
        }
        if (isset($in_data['User']['dt_created']) && $in_data['User']['dt_created']) {
            $uArray['User']['dt_created'] = $in_data['User']['dt_created'];
        } else {
            $uArray['User']['dt_created'] = GMT_DATETIME;
        }
        $uArray['User']['name'] = trim($in_data['User']['name']);
        if ($type == 'new') {
            if (isset($in_data['User']['uniq_id']) && $in_data['User']['uniq_id']) {
                $uArray['User']['uniq_id'] = $in_data['User']['uniq_id'];
            } else {
                $uArray['User']['uniq_id'] = $format->generateUniqNumber();
            }
            $uArray['User']['email'] = $in_data['User']['email'];
        }
        $uArray['User']['isactive'] = 1;
        if ($in_data['User']['id']) {
            $uArray['User']['id'] = $in_data['User']['id'];
        } else {
            // no user	
        }
		$this->create();
        if ($more) {
            $this->saveAll($uArray);
        } else {
            $this->save($uArray);
        }
        $UID = '';
        if (isset($in_data['User']['id']) && $in_data['User']['id']) {
            $UID = $in_data['User']['id'];
        } else {
            $UID = $this->getLastInsertID();
            if ($type != 'resend') {
                $notification['user_id'] = $UID;
                $notification['type'] = 1;
                $notification['value'] = 1;
                $notification['due_val'] = 1;
                if ($more) {
                    ClassRegistry::init('UserNotification')->saveAll($notification);
                } else {
                    ClassRegistry::init('UserNotification')->save($notification);
                }
            }
        }
        if (isset($in_data['User']['pid']) && $in_data['User']['pid']) {
            $ProjectUser->recursive = -1;
            $projectids = null;
            if (isset($in_data['User']['pid'])) {
                if (strstr($in_data['User']['pid'], ',')) {
                    $projectids = explode(',', $in_data['User']['pid']);
                } else {
                    if ($in_data['User']['pid']) {
                        $projectids[] = $in_data['User']['pid'];
                    }
                }
            }
            if ($projectids && !empty($projectids)) {
                foreach ($projectids as $key => $val) {
                    if (trim($val)) {
                        if (isset($_SESSION['puincrement_id'])) {
                            $_SESSION['puincrement_id'] = $_SESSION['puincrement_id'] + 1;
                            $_SESSION['project_increment_id'] = $_SESSION['puincrement_id'];
                        } else {
                            if (isset($_SESSION['project_increment_id']) && $_SESSION['project_increment_id']) {
                                $_SESSION['puincrement_id'] = $_SESSION['project_increment_id'] + 1;
                                $_SESSION['project_increment_id'] = $_SESSION['puincrement_id'];
                            } else {
                                 $getLastId = $ProjectUser->find('first',array('fields'=>array('ProjectUser.id'),'order'=>array('ProjectUser.id DESC')));
								$nextid = $getLastId['ProjectUser']['id'] + 1;
                                $_SESSION['puincrement_id'] = $nextid;
                                $_SESSION['project_increment_id'] = $nextid;
                            }
                        }
                        $projUsr['ProjectUser']['id'] = $_SESSION['puincrement_id'];
                        $projUsr['ProjectUser']['user_id'] = $UID;
                        $projUsr['ProjectUser']['project_id'] = trim($val);
                        $projUsr['ProjectUser']['company_id'] = SES_COMP;
                        $projUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                        $ProjectUser->create();
                        $ProjectUser->save($projUsr);
                    }
                }
            }
        }
        return $UID . '___' . $pass;
    }	
	function mobileCheckUserExists($emails = null, $company_id) {
        $this->recursive = -1;
        if ($emails) {
			$emails = urldecode($emails);
			if (stristr($emails, ",")) {
				$mail_arr1 = explode(",", trim(trim($emails), ","));
			}else{
				$mail_arr1 = array(trim(trim($emails), ","));
}
            if (!empty($mail_arr1)) {
                $str = "";
                $CompanyUser = ClassRegistry::init('CompanyUser');
                $UserInvitation = ClassRegistry::init('UserInvitation');                
                $cnt = 0;
                $mail_arr = array();
                foreach ($mail_arr1 AS $key => $val) {
                    if (trim($val) != "") {
                        $cnt ++;
                        $mail_arr[] = $val;
                    }
                }
                //Checking limitation of users 
                for ($i = 0; $i < count($mail_arr); $i++) {
                    if (trim($mail_arr[$i]) != "") {
                        $mail_arr[$i] = trim($mail_arr[$i]);
                        $checkUsr = $this->find('first', array('conditions' => array('User.email' => $mail_arr[$i]), 'fields' => array('User.id')));
                        $user_id = $checkUsr['User']['id'];
                        if ($user_id) {
                            $ui = $UserInvitation->find('first', array('conditions' => array('UserInvitation.company_id' => $company_id, 'UserInvitation.user_id' => $user_id), 'fields' => array('UserInvitation.user_id')));
                            if ($ui['UserInvitation']['user_id']) {
                                $str = $mail_arr[$i] . ",";
                                break;
                            } else {
                                $cu = $CompanyUser->find('first', array('conditions' => array('CompanyUser.company_id' => $company_id, 'CompanyUser.user_id' => $user_id, 'CompanyUser.is_active !=3'), 'fields' => array('CompanyUser.id')));
                                if ($cu['CompanyUser']['id']) {
                                    $str = $mail_arr[$i] . ",";
                                    break;
                                }
                            }
                        }
                    }
                }
                $str = trim($str);
                $str = trim($str, ",");
                if (trim($str) == "") {
                    return "success";
                } else {
                    return $str;
                }
            }
        }
        return "success";
    }
  function convertLicenseKeyDocode($key){
		$t_key = explode(base64_encode(OS_LICENSE_SALT),$key);
		return base64_decode(strrev($t_key[0]));
	}
  function checkValidReferer($data_inpt){
		$ret_arr = array('status'=>'failure');
		if($data_inpt){
			$femails = array_filter(explode(',', $data_inpt['femail']));
			if(!empty($femails)){
				if(in_array(trim($data_inpt['email']),$femails)){
					$ret_arr['message'] = 'Inviting to yourself. Please remove yourself from the friends email list.';
				}else{
					$exist_emails = $this->find('list', array('conditions' => array('User.email' => $femails), 'fields' => array('User.id', 'User.email'), 'order' => array('User.id DESC')));
					if($exist_emails){
						$oseml = implode(', ', $exist_emails);
						$ret_arr['message'] = 'We found ('.$oseml. ') emails already registered with Orangescrum, please choose another!';
					}else{
						$ret_arr['status'] = 'success';
					}					
				}
			} else if(isset($data_inpt['type']) && $data_inpt['type'] != 'e'){
				$ret_arr['status'] = 'success';
			}
		}
		return $ret_arr;
	}
	function addDummyUser($proj_id, $comp_id, $user_id, $comp_uid){
		
		$dumy_users = $this->find('all', array('conditions' => array('User.is_dummy' => 1), 'fields' => array('User.id ','User.name','User.uniq_id'),'order'=>array('User.id'=>'DESC')));
		
		$CompanyUser_mod = ClassRegistry::init('CompanyUser');
		$ProjectUser_mod = ClassRegistry::init('ProjectUser');	
		$utyp_arr = array(0=>2,1=>3,2=>4); //user role
		
		foreach($dumy_users as $k => $v){			
			//company users
			$comp_usr = array();
			$comp_usr['CompanyUser']['user_id'] = $v['User']['id'];
			$comp_usr['CompanyUser']['company_id'] = $comp_id;
			$comp_usr['CompanyUser']['company_uniq_id'] = $comp_uid;
			$comp_usr['CompanyUser']['user_type'] = $utyp_arr[$k];
			if($k == 2){
				$comp_usr['CompanyUser']['user_type'] = 3;
				$comp_usr['CompanyUser']['is_client'] = 1;
			}else{
				$comp_usr['CompanyUser']['is_client'] = 0;
			}			
			$comp_usr['CompanyUser']['role_id'] = $utyp_arr[$k];
			$comp_usr['CompanyUser']['is_dummy'] = 1;
			$CompanyUser_mod->saveAll($comp_usr);
			
			//project users 
			
			$ProjectUser_mod->recursive = -1;
			$getLastId = $ProjectUser_mod->find('first', array('fields' => array('ProjectUser.id'), 'order' => array('ProjectUser.id DESC')));
			$lastid = $getLastId['ProjectUser']['id'] + 1;
			
			$ProjUsr = array();
			$ProjUsr['ProjectUser']['id'] = $lastid;
			$ProjUsr['ProjectUser']['project_id'] = $proj_id;
			$ProjUsr['ProjectUser']['user_id'] = $v['User']['id'];
			$ProjUsr['ProjectUser']['company_id'] = $comp_id;
			$ProjUsr['ProjectUser']['default_email'] = 1;
			$ProjUsr['ProjectUser']['istype'] = 2;
			$ProjUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
			$ProjectUser_mod->saveAll($ProjUsr);			
		}
		return $dumy_users;
	}
    
    function getUserDtls($uid) {
        $this->recursive = -1;
        $usrDtls = $this->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.name', 'User.photo', 'User.email', 'User.last_name', 'User.dt_created', 'User.dt_last_login','User.btprofile_id','User.uniq_id')));
        return $usrDtls;
    }
    /**
     * @method public allowedGuestUserCount(int addingUser)
     * @author Chandan P.
     * This method is used to check whether guest users can be added or not
     */
    public function allowedGuestUserCount($addingUser = 0){
        $CompanyUser = ClassRegistry::init('CompanyUser');
        $total_guest_user = $CompanyUser->find('count',array('conditions'=>array("CompanyUser.company_id"=>SES_COMP,"CompanyUser.role_id"=>699,"CompanyUser.is_active"=>1)));
        $total_user_limitation = $GLOBALS['Userlimitation']['user_limit'];
				if($GLOBALS['Userlimitation']['subscription_id'] == 11 && $GLOBALS['Userlimitation']['lifetime_free']){
					return "excess";
				}
        if($total_user_limitation != "unlimited"){
            $get_allowed_guest_user = floor((50*$total_user_limitation)/100);
            $allowed_guest_user = $get_allowed_guest_user - $total_guest_user;
            if($total_guest_user >= $get_allowed_guest_user){
                return "excess";
            }elseif($addingUser > $allowed_guest_user){
                return "excess";
            }else{
                return "allowed";
            }           
        } else {
            return "allowed";
        }
    }
}