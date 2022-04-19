<?php
class DuedateChangeReason extends AppModel {
	var $name = 'DuedateChangeReason';
	var $hasMany = array('TaskDueChangeReason' =>
        array('className' => 'TaskDueChangeReason',
            'foreignKey' => 'duedate_change_reason_id'
        )
    );
	
	/**
	 * getDuedateReasons
	 *
	 * @param  mixed $comp_id
	 * @return array
	 * @author PRB
	 */
	public function getDuedateReasonsList($comp_id)
	{
		$compArr = [0,$comp_id];
		$conds = array('DuedateChangeReason.company_id'=>$compArr,'DuedateChangeReason.is_active'=>1);   
		$fields = array('DuedateChangeReason.id','DuedateChangeReason.reason');
		$options = array();
		$options['fields'] = $fields;
		$options['conditions'] = $conds;
		$options['order'] = 'DuedateChangeReason.reason ASC';
		//$options['joins'] = array(array('table' => 'companies', 'alias' => 'Company', 'type' => 'INNER', 'conditions' => array('Company.id=DuedateChangeReason.company_id')));
		$resp = $this->find('list',$options);
		
		return $resp;
	}
	
	/**
	 * saveDuedateReason
	 *
	 * @param  mixed $comp_id
	 * @return void
	 * @author PRB
	 */
	public function saveDuedateReason($data)
	{
		$this->id = '';
		if(!empty($data) && $this->save($data)){
			return $this->getLastInsertID();
		}
		
		return 0;
	}
	
	/**
	 * getDetailByDomain
	 *
	 * @param  mixed $comp_id
	 * @return void
	 * @author Swetalina
	 * function to Fetch all datas from the table and to show in listing   
	 */
	public function getDuedateReasons($comp_id)
	{
		$comp_arr = [0,$comp_id];
		$reasons = $this->find('all', array('conditions'=> array('DuedateChangeReason.company_id'=>$comp_arr)));
		return $reasons; 
	}	
	/**
	 * saveDueDateChangeReason
	 *@author Swetalina
	 * @param  mixed $data
	 * @return void
	 * function to save and update the data inside the table.  
	 */
	public function saveDueDateChangeReason($data){
		$id = $data['id'];
		$data_to_save = array();
		$data_to_save['company_id'] = SES_COMP;
		$data_to_save['user_id'] = SES_ID;
		$data_to_save['reason'] = $data['change_rsn'];
		$data_to_save['is_default'] = 1;
		$data_to_save['is_active'] = 1;
		
		if(!empty($id)){
			$data_to_save['id'] = $id; 
			$saveData =$this->save($data_to_save);   
		}else{
			$this->create();
			$saveData = $this->save($data_to_save);
		}
		return $saveData;
	}	
	/**
	 * getDuedtChangeDetails
	 *@author Swetalina 
	 * @param  mixed $id
	 * @return void
	 */
	public function getDuedtChangeDetails($id){
		$get_due_dt_data = $this->find('first', array('conditions'=> array('DuedateChangeReason.id'=> $id), 'fields'=>array('DuedateChangeReason.id', 'DuedateChangeReason.reason')));
		return $get_due_dt_data;
	}	
	/**
	 * isActiveDueDtManage
	 *@author Swetalina
	 * @param  mixed $id
	 * @param  mixed $activeValue
	 * @return void
	 */
	public function isActiveDueDtManage($id, $activeValue){
		$this->create();
		$this->id = $id;  
		$activeStatus = $this->saveField('is_active', $activeValue);
		if($activeStatus){
		 return 1;  
		} else {
			return 0;
		}
	}
}