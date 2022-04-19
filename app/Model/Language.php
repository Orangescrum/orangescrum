<?php
App::uses('AppModel', 'Model');
class Language extends AppModel {    
	var $name = 'Language';
	function getLanguageFields($condition = array(), $fields = array()) {
		$this->recursive = -1;
		return $this->find('first', array('conditions' => $condition, 'fields' => $fields));
	} 
	function getAllLanguage() {
		$this->recursive = -1;
		$res = $this->find('all', array('order'=>array('id'=>'ASC')));
		return Hash::combine($res, "{n}.Language.id", "{n}.Language");
	}   
}
