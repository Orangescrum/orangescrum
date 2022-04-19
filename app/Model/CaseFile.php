<?php
class CaseFile extends AppModel{
	var $name = 'CaseFile';
/**
	 * This method calculate the total storage used by user.
	 * 
	 * @author Sunil
	 * @method getStorage
	 * @param
	 * @return string
	*/
	var $cacheQueries = false;
	function getStorage($comp_id = null){
		$company_id = ($comp_id)?$comp_id:SES_COMP;
	   $this->recursive = -1;
		$sql = "SELECT SUM(file_size) AS file_size  FROM case_files   WHERE company_id = '".$company_id."'";
	   $res1 = $this->query($sql);
	   $filesize = $res1['0']['0']['file_size']/1024;
		 
		App::import('Model', 'CaseEditorFile');
		$CaseEditorFile = new CaseEditorFile();
		$CaseEditorFile->recursive = -1;
		$sql_n = "SELECT SUM(file_size) AS file_size FROM case_editor_files WHERE company_id = '".$company_id."'";
		$res_n = $CaseEditorFile->query($sql_n);		
		$filesize_n = $res_n['0']['0']['file_size'] / 1024;
		
		$tot_size = $filesize_n+$filesize;	
		 
	   return round($tot_size, 2);
	   //return number_format($filesize,2);
	}						
}