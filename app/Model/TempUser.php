<?php
class TempUser extends AppModel{
	var $name = 'TempUser';
/**
	 * This method calculate the total storage used by user.
	 * 
	 * @author PRB
	 * @method getStorage
	 * @param
	 * @return string
	*/		
	function getgaCount($uid, $fld=null){
		$data_sub = $this->find('first', array('conditions' => array('uniq_id' => $uid), 'order' => 'id DESC'));
		if($data_sub){
			if($fld){
				return $data_sub['TempUser']['user_id'];
			}else{
				$data_sub['TempUser']['ga_count'] += 1;
				$this->save($data_sub);
				return $data_sub['TempUser']['ga_count'];
			}
		}
		return 0;
	}
}