<?php

class TaskField extends AppModel {

    var $name = 'TaskField';
	
	/**
     * @method public readTaskFieldfromCache(int account_id)
     * @author Andola Dev <support@andolacrm.com>
     */
	public function readTaskFieldfromCache($user_id) {
		//Cache::delete('task_field_'.$user_id);
		if (Cache::read('task_field_'.$user_id) === false) {
			$data_tf = $this->find('first', array('conditions' => array('TaskField.user_id' => $user_id), 'order' => 'id DESC'));
			Cache::write('task_field_'.$user_id, $data_tf);
		}
		return Cache::read('task_field_'.$user_id);
	}
}
?>