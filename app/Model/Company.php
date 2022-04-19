<?php
class Company extends AppModel{
	public $name = 'Company';
	/* public $validate = array(
        'name' => 'alphaNumeric',
        'seo_url' => 'alphaNumeric'
    );*/
	/*var $hasAndBelongsToMany = array(
        'User' =>
            array(
                'className'              => 'User',
                'joinTable'              => 'company_users',
                'foreignKey'             => 'company_id',
                'associationForeignKey'  => 'user_id'
           )
    );*/
	function getCompanyFields($condition = array(), $fields = array()) {
	    $this->recursive = -1;
	    return $this->find('first',array('conditions'=>$condition,'fields'=>$fields));
	}
	public function beforeSave($options = array()) {
		
		if(trim($this->data['Company']['name'])) {
			$this->data['Company']['name'] = html_entity_decode(strip_tags($this->data['Company']['name']));
			if(empty($this->data['Company']['name'])){
				return false;
		}
		}
		if(trim($this->data['Company']['website'])) {
			$this->data['Company']['website'] = htmlentities(strip_tags($this->data['Company']['website']));
		}
		if(trim($this->data['Company']['contact_phone'])) {
			$this->data['Company']['contact_phone'] = htmlentities(strip_tags($this->data['Company']['contact_phone']));
		}
	}
	function checkCompUsrStatus($uid, $rqst_data){
		$rqst_data['companyId'] = isset($rqst_data['companyId'])?$rqst_data['companyId']:$rqst_data['company_id'];
		if(!isset($rqst_data['companyId']) || empty($rqst_data['companyId'])){
			$data['code'] = 2002;
			$data['status'] = "failure";
			$data['msg'] = __("Invalid parameters supplied.");
			print json_encode($data);exit;
		}else{
			$company = $this->getCompanyFields(array('Company.uniq_id' => $rqst_data['companyId']), array('id', 'name','uniq_id','seo_url','is_active'));
			if(empty($company)){
				$data['code'] = 2002;
				$data['status'] = "failure";
				$data['msg'] = __("Invalid parameters supplied.");
				print json_encode($data);exit;
			}else{
				$CompanyUser= ClassRegistry::init('CompanyUser');
				$CompanyUser->recursive = -1;
				$user_dtl = $CompanyUser->find('first',array('conditions'=>array('CompanyUser.company_id'=>$company['Company']['id'],'CompanyUser.user_id'=>$uid,'CompanyUser.is_active'=>1),'fields'=>array('id','user_type','is_client')));
				$ret = null;
				$ret = $company['Company'];
				if($user_dtl){
					$ret['user_type'] = $user_dtl['CompanyUser']['user_type'];
					$ret['is_client'] = $user_dtl['CompanyUser']['is_client'];
					return $ret;
				}else{
					$data['code'] = 2006;
					$data['status'] = "failure";
					$data['msg'] = __("Your account has been deactivated. Please contact your account owner.");
					print json_encode($data);exit;
}
			}
		}
	}
	function checkMobileApp($useragent){
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
			return true;
		}else{
			return false;
		}
	}
        
        function getWeeklyHour(){
            $this->recursive = -1;
            $getCompany = $this->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('name', 'work_hour','week_ends')));
            $companyWorkHours = $getCompany['Company']['work_hour'] ? $getCompany['Company']['work_hour'] : 8;
            $companyWorkDays = $getCompany['Company']['week_ends'] ? 7 - count(explode(',',$getCompany['Company']['week_ends'])) : 7;
            $requestedWeeklyHours = ($companyWorkHours * $companyWorkDays) * 3600;
            return $requestedWeeklyHours;
        }
		
		/**
		 * checkCompanyExist
		 *
		 * @return void
		 */
		public function checkCompanyExist($company_id){
			$comp = $this->find('first',array('conditions'=>array('Company.id'=>$company_id),'fields'=>array('Company.id')));
			if(!empty($comp['Company']['id'])){
				return  1;
			}else{
				return 0;
			}
		}

		public function validateAuthToken($token){
			$response = $this->find('first', array('conditions'=>array('Company.auth_token'=>$token),'fields'=>array('Company.id')));
			if(!empty($response)){
				return 1;
			}else{
				return 0;
			}
		}
		
		public function getWorkhour($comp_id, $start_date, $last_date, $weekArr=[], $cur_view_type=1)
		{
			$TimezoneName = ClassRegistry::init('TimezoneName');
			$tmz=$TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
			$tmz=  str_replace(array("GMT","(",")"), "", $tmz);
			$gmt_val = "+00:00";
			//find the below using conver tz and then compare
			/*$CompanyHoliday= ClassRegistry::init('CompanyHoliday');
			$holidayLists = $CompanyHoliday->find('list',array('fields'=>array('id','holiday'),'conditions'=>array('company_id'=>$comp_id,'holiday >=' => $start_date,'holiday <=' => $last_date),'order'=>array('created ASC')));*/
			
			$compDtl =  $this->find('first', array('conditions'=>array('id'=>$comp_id),'fields'=>array('work_hour','week_ends')));
			
			$db = $this->getDataSource();
			$inputArr = [
				'start_date' => $start_date,
				'end_date' => $last_date,
				'company_id' => $comp_id
			];
			$sql = "SELECT
								DATE_FORMAT(CONVERT_TZ(holiday,'$gmt_val','$tmz'),'%Y-%m-%d') as holiday_v1
							FROM company_holidays 
							WHERE 
								company_id =:company_id 
								AND holiday BETWEEN :start_date AND :end_date";
			$holidayLists = $db->fetchAll($sql, $inputArr);				
			$weeends = (!empty($compDtl['Company']['week_ends'])) ? explode(',', $compDtl['Company']['week_ends']) : [];
			
			if($holidayLists){
				$holidayLists = Hash::extract($holidayLists, '{n}.0.holiday_v1');
				$weekHolidayArr = [];
				foreach($holidayLists as $k => $v){
					if(!in_array(date('w', strtotime($v)), $weeends)){
						if($cur_view_type == 3){
							$weekHolidayArr[(int)date('m', strtotime($v))] = (isset($weekHolidayArr[(int)date('m', strtotime($v))])) ? $weekHolidayArr[(int)date('m', strtotime($v))]+1 : 1;
						}else{
						$weekHolidayArr[(int)date('W', strtotime($v))] = (isset($weekHolidayArr[(int)date('W', strtotime($v))])) ? $weekHolidayArr[(int)date('W', strtotime($v))]+1 : 1;
					}
				}
			}
			
			}
			foreach($weekArr as $wk => $wv){
				$estdhrCnt = count($weeends);
				if($weekHolidayArr && isset($weekHolidayArr[$wv['wnum']])){
					$estdhrCnt += $weekHolidayArr[$wv['wnum']];
				}
				if($cur_view_type == 3){
					$d = cal_days_in_month(CAL_GREGORIAN,$wv['wnum'], date('Y', $wv['display_date_t']));
				}else{
					$d = 7;
				}				
				$weekArr[$wk]['estimated_hour'] = ($d - $estdhrCnt)*$compDtl['Company']['work_hour']*3600;
			}
			//Compare the custom holidays and the week_ends also			
			$retResp['weeks'] = $weekArr;
			$retResp['compDtl'] = $compDtl;
			
			return $retResp;
		}
}