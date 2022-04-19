<?php

class Type extends AppModel {

    var $name = 'Type';
    var $inserted_ids = array();

    function afterSave($created) {
        if($created) {
            $this->inserted_ids[] = $this->getInsertID();
        }
        return true;
    }

    /**
     * Listing of task types
     * 
     * @method getAllTypes
     * @author Sunil
     * @return
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    function getAllTypes($viw=null) {
        $sql = "SELECT GROUP_CONCAT(DISTINCT id SEPARATOR ',') AS project_ids FROM projects WHERE company_id=" . SES_COMP;
        $data = $this->query($sql);
        $res = "";
        if (isset($data['0']['0']['project_ids']) && !empty($data['0']['0']['project_ids'])) {
					$data['0']['0']['project_ids'] = trim($data['0']['0']['project_ids'],','); 
        if($viw == 'list'){
					$sql = "SELECT Total.*, Type.*,Project.name FROM (SELECT Easycase.type_id, COUNT(Easycase.id) AS cnt FROM easycases AS Easycase
              WHERE Easycase.project_id IN (".$data['0']['0']['project_ids'].") AND Easycase.istype=1 GROUP BY Easycase.type_id) AS Total
								RIGHT JOIN types AS Type ON (Type.id=Total.type_id) LEFT JOIN projects AS Project ON (Type.project_id=Project.id) WHERE Type.company_id = ". SES_COMP ." OR Type.company_id = 0 ORDER BY Type.company_id ASC, Type.seq_order ASC";
			}else{
						$sql = "SELECT Total.*, Type.*,Project.name FROM (SELECT Easycase.type_id, COUNT(Easycase.id) AS cnt FROM easycases AS Easycase
				WHERE Easycase.project_id IN (" . $data['0']['0']['project_ids'] . ") AND Easycase.istype=1 GROUP BY Easycase.type_id) AS Total
						RIGHT JOIN types AS Type ON (Type.id=Total.type_id) LEFT JOIN projects AS Project ON (Type.project_id=Project.id) WHERE Type.company_id = " . SES_COMP . " OR Type.company_id = 0 ORDER BY Type.seq_order = 0,Type.seq_order=13 DESC,Type.seq_order=14 DESC,Type.seq_order ASC ,Type.name ASC";
			}
            $res = $this->query($sql);
        }
        return $res;
        //return $this->find("all", array("conditions" => array(1, '(Type.company_id = 0 OR Type.company_id =' . SES_COMP . ')')));
    }

    /**
     * Listing of default task types
     * 
     * @method getDefaultTypes
     * @author Sunil
     * @return
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    function getDefaultTypes() {
        return $this->find("all", array("conditions" => array('Type.company_id' => 0)));
    }
	function getAllType($type_id) {
		$res = "";
		if (!empty($type_id)) {
			$sql = "SELECT Total.type_id,COUNT(Total.id) AS cnt , Type.* FROM types AS Type LEFT JOIN easycases AS Total ON (Type.id=Total.type_id) WHERE Type.id=".$type_id." AND Type.company_id = ". SES_COMP;            
			$res = $this->query($sql);
			$res[0]['Total']['cnt'] = $res[0][0]['cnt'];            
		}
		return $res;
    }

}