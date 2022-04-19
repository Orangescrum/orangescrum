<?php
class ProjectMeta extends AppModel {
	var $name = 'ProjectMeta';
	
	function getProjectMeta($comp_id, $proj_id){
		$p_metas = $this->find('first', array('conditions' => array('ProjectMeta.company_id' => $comp_id, 'ProjectMeta.project_id' => $proj_id),'order' => array("ProjectMeta.id"=>'DESC')));
		return $p_metas;
	}
	
}