<?php

class SlackCred extends AppModel {

  public $name = 'SlackCred'; 
	public function readSlackDetlfromCache($comp_id, $data_sub = null) {
		//Cache::delete('sub_detl_'.$comp_id);
		if (($slack_detl = Cache::read('slack_detl_'.$comp_id)) === false) {
			if(empty($data_sub)){
				$data_sub = $this->find('first', array('conditions' => array('company_id' => $comp_id), 'order' => 'id DESC'));
			}			
			if(!$data_sub){$data_sub = array();}
			Cache::write('slack_detl_'.$comp_id, $data_sub);
		}else{
			if(!empty($data_sub)){
				Cache::delete('slack_detl_'.$comp_id);
				Cache::write('slack_detl_'.$comp_id, $data_sub);
			}
		}	
		return Cache::read('slack_detl_'.$comp_id);
	}
}