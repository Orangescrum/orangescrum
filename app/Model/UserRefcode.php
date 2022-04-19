<?php
class UserRefcode extends AppModel{
	var $name = 'UserRefcode';	
	function getRefFields($condition = array(), $fields = array()) {
        $this->recursive = -1;
        return $this->find('first', array('conditions' => $condition, 'fields' => $fields));
    }
	
}