<?php
class ProjectNote extends AppModel {
	var $name = 'ProjectNote';
	
	function getProjNotes($comp_id, $proje_id){
		$nots = $this->find('all',array('conditions'=>array('ProjectNote.company_id'=>$comp_id,'ProjectNote.project_id'=>$proje_id),'fields'=>array('ProjectNote.*','User.name','User.last_name','User.photo','User.id'),'order'=>array('ProjectNote.modified'=>'DESC')));
		return $nots;
	} 
	function getProjNote($comp_id, $proje_id, $not_id){
		$nots = $this->find('first',array('conditions'=>array('ProjectNote.company_id'=>$comp_id,'ProjectNote.project_id'=>$proje_id,'ProjectNote.uniq_id'=>$not_id)));
		return $nots;
	} 
}