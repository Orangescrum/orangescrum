<?php
class ProjectMethodology extends AppModel{
	var $name = 'ProjectMethodology';
	
	/**
     * Listing of project methodologies list for dropdowns 
     * @method getAllMethodList
     * @author PRB
     * @return
     * @copyright (c) Aug/2018, Andolsoft Pvt Ltd.
     */
	function getAllMethodList($id=null){
		$this->recursive=-1;
		$res = $this->find('list', array('fields'=>array('ProjectMethodology.id','ProjectMethodology.title'),'order'=>array('ProjectMethodology.id'=>'DESC')));
        return $res;
	}
}