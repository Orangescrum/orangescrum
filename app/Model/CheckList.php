<?php
class CheckList extends AppModel {
	var $name = 'CheckList';
	
	public function updateChecklist($Esdata, $checkList, $checkListSts, $user_id, $comp_id){
		if(!empty($checkListSts)){
			
			$exstlist = $this->find('list', array('conditions' => array('CheckList.easycase_id' => $Esdata['Easycase']['id'], 'CheckList.project_id' => $Esdata['Easycase']['project_id'], 'CheckList.company_id' => $comp_id),'fields'=>array('CheckList.id')));
			foreach($checkListSts as $k => $v){
				$v_t = explode('__', $v);	
				$remDtl = array();
				if(!empty($v_t[1])){
					$remDtl = $this->find('first', array('conditions' => array('CheckList.id' => trim($v_t[1]), 'CheckList.project_id' => $Esdata['Easycase']['project_id'], 'CheckList.company_id' => $comp_id)));
					if($remDtl){						
						if(in_array($remDtl['CheckList']['id'], $exstlist)){
							unset($exstlist[$remDtl['CheckList']['id']]);
						}						
						$remDtl['CheckList']['title'] = trim($checkList[$k]);
						$remDtl['CheckList']['is_checked'] = $v_t[0];
						$remDtl['CheckList']['modified'] = GMT_DATETIME;
						if($this->saveAll($remDtl)){
							$json_arr['data'] = $remDtl['CheckList'];
							$this->eventLog($comp_id, $user_id, $json_arr, 67);
						}
					}						
				}else{								
					$remDtl['CheckList']['uniq_id'] = $this->generateUniqNumber(); 
					$remDtl['CheckList']['company_id'] = $comp_id; 
					$remDtl['CheckList']['project_id'] = $Esdata['Easycase']['project_id']; 
					$remDtl['CheckList']['user_id'] = $user_id; 
					$remDtl['CheckList']['easycase_id'] = $Esdata['Easycase']['id']; 
					$remDtl['CheckList']['title'] = trim($checkList[$k]);
					$remDtl['CheckList']['is_checked'] = $v_t[0]; 
					$remDtl['CheckList']['created'] = GMT_DATETIME; 
					$remDtl['CheckList']['modified'] = GMT_DATETIME;
					if($this->saveAll($remDtl)){									
						$json_arr['data'] = $remDtl['CheckList'];									
						$this->eventLog($comp_id, $user_id, $json_arr, 66);
					}
				}
			}
			if(!empty($exstlist)){
				foreach($exstlist as $k => $v){
					$this->id = $v;
					$this->delete();
				}
			}
			
		}
	}
	
	function generateUniqNumber() {
			$uniq = uniqid(rand());
			return md5($uniq . time());
	}
    
	/**
	 * @method eventLog To log each event that a user did 
	 * @author Gayadhar Khilar <support@orangescrum.com>
	 * @return bool true/false
	 */
	function eventLog($comp_id, $user_id , $json_arr = array(), $activity_id) {
			$logactivity['LogActivity']['company_id'] = $comp_id;
			$logactivity['LogActivity']['user_id'] = $user_id;
			$logactivity['LogActivity']['log_type_id'] = $activity_id;
			$logactivity['LogActivity']['json_value'] = json_encode($json_arr);
			$logactivity['LogActivity']['ip'] = $_SERVER['REMOTE_ADDR'];
			$logactivity['LogActivity']['created'] = GMT_DATETIME;
			$logActivity = ClassRegistry::init('LogActivity');
			$logActivity->create();
			$logActivity->save($logactivity);
	}
}