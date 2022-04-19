<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class TaskSetting extends AppModel{
	public $name = 'TaskSetting';
    
    function getTaskSettings(){
        $settings = $this->find('first', array('conditions'=>array('TaskSetting.company_id' => SES_COMP)));
        return $settings;
    }
	public function readTSDetlfromCache($comp_id, $data_sub = null) {
		//Cache::delete('sub_detl_'.$comp_id);
		if (($slack_detl = Cache::read('ts_detl_'.$comp_id)) === false) {
			if(empty($data_sub)){
				$data_sub = $this->find('first', array('conditions' => array('company_id' => $comp_id), 'order' => 'id DESC'));
			}
			if(!$data_sub){$data_sub = array();}
			Cache::write('ts_detl_'.$comp_id, $data_sub);
		}else{
			if(!empty($data_sub)){
				Cache::delete('ts_detl_'.$comp_id);
				Cache::write('ts_detl_'.$comp_id, $data_sub);
			}
		}	
		return Cache::read('ts_detl_'.$comp_id);
	}
}