<?php
class Industry extends AppModel{
	var $name = 'Industry';
	
	public function getIndustries($controller)
	{
		$conditions = array();
		if ($controller != "osadmins") {
				$conditions = array("Industry.is_display" => 1);
		}
		//$industries = $this->find('list', array("conditions" => $conditions));
		$industries[17] = 'Information Technology and Services';
		array_unshift($industries, 'Select Industry');
		
		return $industries;
	}
}