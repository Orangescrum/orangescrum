<?php
App::uses('AppModel', 'Model');
/**
 * CakePHP EasycaseRelate
 * @author Andolasoft
 */
class EasycaseRelate extends AppModel {
	public $name = 'EasycaseRelate';    
	/**
	 * @method public readERelateDetlfromCache(int comp_id)
	 * @author Andola Dev <support@andolacrm.com>
	 */
	public function readERelateDetlfromCache($comp_id=0) {
		if (($sub_detl = Cache::read('easyrelate_detl_')) === false) {
			$data_er = $this->find('all', array('conditions' => array('EasycaseRelate.status' => 1), 'order' => array('EasycaseRelate.seq_id'=>'ASC')));			
			Cache::write('easyrelate_detl_', $data_er);
		}
		return Cache::read('easyrelate_detl_');
	}
}