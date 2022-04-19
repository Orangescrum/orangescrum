<?php
class PauseHistory extends AppModel {
	var $name = 'PauseHistory';
	
	function logPauseHistory($data, $type=1){
		$hist = array();
		$hist['PauseHistory']['company_id'] = $data['company_id'];
		$hist['PauseHistory']['user_id'] = $data['user_id'];
		$hist['PauseHistory']['user_subscription_id'] = $data['id'];
		$hist['PauseHistory']['next_billing_date'] = $data['next_billing_date'];
		$hist['PauseHistory']['type'] = $type;
		$this->create();
		$this->save($hist);
	}
	/*function getPauseHistories($comp_id, $proje_id){
		$hist = $this->find('all',array('conditions'=>array('PauseHistory.company_id'=>$comp_id),'fields'=>array('PauseHistory.*','User.name','User.last_name','User.photo','User.id'), 'order'=>array('PauseHistory.modified'=>'DESC')));
		return $hist;
	} 
	function getPauseHistory($comp_id,$pus_id){
		$hist = $this->find('first',array('conditions'=>array('PauseHistory.company_id'=>$comp_id,'PauseHistory.id'=>$pus_id)));
		return $hist;
	} */
}