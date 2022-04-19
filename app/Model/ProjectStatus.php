<?php
class ProjectStatus extends AppModel {
	var $name = 'ProjectStatus';
	
	function getProjectStatus($comp_id, $name){
		$p_Status = $this->find('first', array('conditions' => array('ProjectStatus.company_id' => $comp_id, 'ProjectStatus.name' => trim($name)), 'fields' => array("ProjectStatus.name"),'order' => array("ProjectStatus.id"=>'DESC')));
		return $p_Status;
	}
	function getAllProjectStatus($comp_id, $id=0){
		if(!empty($id)){
			$p_Statuss = $this->find('list', array('conditions' => array('ProjectStatus.company_id' => array(0,$comp_id), 'OR'=>array('ProjectStatus.is_active'=>1,'ProjectStatus.id'=>$id)), 'fields' => array("ProjectStatus.id","ProjectStatus.name"),'order' => array("ProjectStatus.name"=>'DESC')));
		}else{
			$p_Statuss = $this->find('list', array('conditions' => array('ProjectStatus.company_id' => array(0,$comp_id),'ProjectStatus.is_active'=>1), 'fields' => array("ProjectStatus.id","ProjectStatus.name"),'order' => array("ProjectStatus.name"=>'DESC')));
		}
		return $p_Statuss;
	}
	
	function getAllStatus($comp_id) {
		//$this->bindModel(array('belongsTo' => array('Project')));
		$p_Statuss = $this->find('all', array('conditions' => array('ProjectStatus.company_id' => array(0,$comp_id)),'order' => array("ProjectStatus.company_id"=>'ASC',"ProjectStatus.name"=>'ASC')));
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
		return $this->find("list", array("conditions" => array('ProjectStatus.company_id' => $comp_id), 'fields' => array('ProjectStatus.id', 'ProjectStatus.name')));
	}
	
}