<?php
class DefaultTaskView extends AppModel{
    var $name = 'DefaultTaskView';
	public function readDTVDetlfromCache($comp_id, $user_id, $data_sub = null) {
		//Cache::delete('sub_detl_'.$comp_id);
		if (($slack_detl = Cache::read('dtv_detl_'.$comp_id.'_'.$user_id)) === false) {
			if(empty($data_sub)){
				$data_sub = $this->find('first', array('conditions' => array('company_id' => $comp_id,'user_id' => $user_id), 'order' => 'id DESC'));
			}
			Cache::write('dtv_detl_'.$comp_id.'_'.$user_id, $data_sub);
		}else{
			if(!empty($data_sub)){
				Cache::delete('dtv_detl_'.$comp_id.'_'.$user_id);
				Cache::write('dtv_detl_'.$comp_id.'_'.$user_id, $data_sub);
			}
		}	
		return Cache::read('dtv_detl_'.$comp_id.'_'.$user_id);
	}
}