<?php
class ProjectType extends AppModel {
	var $name = 'ProjectType';
	
	function getProjectType($comp_id, $name){
		$p_type = $this->find('first', array('conditions' => array('ProjectType.company_id' => $comp_id, 'ProjectType.title' => trim($name)), 'fields' => array("ProjectType.title")));
		return $p_type;
	}
	function getAllProjectType($comp_id, $id=0){
		if(!empty($id)){
			$p_types = $this->find('list', array('conditions' => array('ProjectType.company_id' => $comp_id, 'OR'=>array('ProjectType.is_active'=>1,'ProjectType.id'=>$id)), 'fields' => array("ProjectType.id","ProjectType.title")));
		}else{
			$p_types = $this->find('list', array('conditions' => array('ProjectType.company_id' => $comp_id,'ProjectType.is_active'=>1), 'fields' => array("ProjectType.id","ProjectType.title")));
		}
		return $p_types;
	}
	function getAllTypes($comp_id) {
		//$this->bindModel(array('belongsTo' => array('Project')));
		$p_Statuss = $this->find('all', array('conditions' => array('ProjectType.company_id' =>$comp_id),'order' => array("ProjectType.company_id"=>'ASC',"ProjectType.title"=>'ASC')));
		return $p_Statuss;
	}
	/**
	 * Getting selected project statuses
	 * 
	 * @method getSelTypes
	 * @author PRB
	 * @return
	 * @copyright (c) Feb/2020, Andolsoft Pvt Ltd.
	 */
	function getSelTypes($comp_id) {
		return $this->find("list", array("conditions" => array('ProjectType.company_id' => $comp_id), 'fields' => array('ProjectType.id', 'ProjectType.title')));
	}
	
}