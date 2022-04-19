<?php

class TypeCompany extends AppModel {

    var $name = 'TypeCompany';

    /**
     * Getting selected task types
     * 
     * @method getSelTypes
     * @author Sunil
     * @return
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    function getSelTypes() {
        return $this->find("list", array("conditions" => array('TypeCompany.company_id' => SES_COMP), 'fields' => array('TypeCompany.id', 'TypeCompany.type_id')));
    }
	function getSelType($comId = '', $project_id = '') {
        $comId = !empty($comId) ? $comId : SES_COMP;

        $project_id = empty($project_id)?$_COOKIE['CPUID']:$project_id;
        $project_id = (strtolower($project_id) == 'all' || empty($project_id) )?0:$project_id;
        if($project_id != 0){
             $Project = ClassRegistry::init('Project');
             $pid=$Project->find('first',array('conditions'=>array('Project.uniq_id'=>$project_id),'fields'=>array('Project.id')));
             $project_id = $pid['Project']['id'];
        }
        $TypeModel = ClassRegistry::init('Type');
        //$TypeModel->bindModel(array('hasMany' => array('TypeCompany' => array('className' => 'TypeCompany', 'foreignKey' => 'type_id','fields'=>array('TypeCompany.type_id')))));
        $allTaskTypeIDs = $TypeModel->find('all',array('conditions'=>array('Type.project_id'=>array($project_id,0),'Type.company_id'=>array(SES_COMP,0),'TypeCompany.type_id IS NOT NULL' ),'fields'=>array('Type.id'),'joins'=>array(array('table' => 'type_companies','alias' => 'TypeCompany','type' => 'left','foreignKey' => false,'conditions'=> array('Type.id = TypeCompany.type_id AND TypeCompany.company_id='.SES_COMP)))));
        foreach ($allTaskTypeIDs as $k=>$v) {
                $allTaskTypeID[] = $v['Type']['id'];
        }
        $TypeModel->bindModel(array('hasMany' => array('TypeCompany' => array('className' => 'TypeCompany', 'foreignKey' => 'type_id'))));
        $this->bindModel(array('belongsTo' => array('Type' => array('className' => 'Type', 'foreignKey' => 'type_id'))));
        $cond = array('TypeCompany.company_id' => $comId);
        if(isset($allTaskTypeID) && !empty($allTaskTypeID)){
            $cond['TypeCompany.type_id'] = $allTaskTypeID;
        }
        if($_SESSION['project_methodology'] == 'scrum'){
            $typeOrder = " Type.seq_order = 0,Type.seq_order=13 DESC,Type.seq_order=14 DESC,Type.project_id=0 DESC,Type.seq_order ASC ,Type.name ASC";
         }else{
            $typeOrder = " Type.seq_order = 0,Type.project_id=0 DESC,Type.seq_order ASC ,Type.name ASC";
         }
        $taskCompany = $this->find("first", array("conditions" =>$cond , 'order' => array($typeOrder)));
        
        if (empty($taskCompany)) {
            $conditions = array('Type.company_id IN(0,' . $comId.')');
            $conditions['Type.project_id'] = array($project_id,0);
            $types = $TypeModel->find('first', array('conditions' => $conditions, 'order' => array($typeOrder)));
            return $types['Type']['id'];
        } else {
            return $taskCompany['TypeCompany']['type_id'];
        }
    }    
    function getSelAllType($comId = '') {
        $comId = !empty($comId) ? $comId : SES_COMP;
        $TypeModel = ClassRegistry::init('Type');
        $TypeModel->bindModel(array('hasMany' => array('TypeCompany' => array('className' => 'TypeCompany', 'foreignKey' => 'type_id'))));
        $this->bindModel(array('belongsTo' => array('Type' => array('className' => 'Type', 'foreignKey' => 'type_id'))));
        $taskCompany = $this->find("all", array("conditions" => array('TypeCompany.company_id' => $comId), 'order' => array("Type.name ASC")));
        if (empty($taskCompany)) {
            $conditions = array('Type.company_id=0');
            $types = $TypeModel->find('all', array('conditions' => $conditions, 'order' => array('name'=>'ASC')));
            return $types;
        } else {
            return $taskCompany;
        }
    }     

    function getCheckedTaskType($task_type, $comId = '') {
        $comId = !empty($comId) ? $comId : SES_COMP;
        $checkTaskType = $this->find("list", array("conditions" => array('TypeCompany.company_id' => $comId), 'fields' => array('TypeCompany.id', 'TypeCompany.type_id'), 'order' => array("TypeCompany.id ASC")));
        if (!empty($checkTaskType)) {
			if(in_array($task_type, $checkTaskType)){
				return $task_type;
			}else{
				$task_types = $this->getSelType($comId);
				return $task_types;
			}
        } else {
			$task_types = $this->getSelType($comId);
			if(!empty($task_types)){
				return $task_types;
			}
            return $task_type;
        }
		/*$checkTaskType = $this->find("first", array("conditions" => array('TypeCompany.company_id' => $comId, 'TypeCompany.type_id' => $task_type), 'fields' => array('TypeCompany.id', 'TypeCompany.type_id'), 'order' => array("TypeCompany.id ASC")));
        if (!empty($checkTaskType['TypeCompany'])) {
            return $task_type;
        } else {
            $task_types = $this->getSelType($comId);
            return $task_types;
        }*/		
    }

    /**
     * Getting all task types
     * 
     * @method getTypes
     * @author Sunil
     * @return
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    function getTypes() {
        return $this->find("list", array("conditions" => array('TypeCompany.company_id' => SES_COMP)));
    }
	function getStoryId($comId, $type='story'){		
		$comId = !empty($comId) ? $comId : SES_COMP;
        $TypeModel = ClassRegistry::init('Type');
        $TypeModel->bindModel(array('hasMany' => array('TypeCompany' => array('className' => 'TypeCompany', 'foreignKey' => 'type_id'))));
        $this->bindModel(array('belongsTo' => array('Type' => array('className' => 'Type', 'foreignKey' => 'type_id'))));
        $taskCompany = $this->find("first", array("conditions" => array('TypeCompany.company_id' => $comId,'Type.name'=>'Story'), 'order' => array("Type.name ASC")));
        if (empty($taskCompany)) {
           // $dtypes = Configure::read('DEFAULT_TASK_TYPES');
					 if($type == 'epic'){
            $typeOrder = " Type.seq_order=13 DESC";
					 }else{
						$typeOrder = " Type.seq_order=14 DESC";
					 }
					 $sql = "SELECT Type.* FROM types AS Type 
					 WHERE Type.company_id=0 ORDER BY ".$typeOrder." LIMIT 1";
					 $TypeModel = ClassRegistry::init('Type');
					 $dtypes = $TypeModel->query($sql);
					 return $dtypes[0]['Type']['id'];
        } else {
            return $taskCompany['TypeCompany']['type_id'];
        }		
	}
    function getTypeForCompany($company_id) {
        $companies_id = array("0", $company_id);
        if ($company_id) {
            App::import('Model', 'Type');
            $Type = new Type();
            $sql = "SELECT Type.* FROM type_companies AS TypeCompany LEFT JOIN types AS Type ON (TypeCompany.type_id=Type.id)
		WHERE TypeCompany.company_id=" . $company_id . " ORDER BY Type.name ASC";
            $TypeCompany = $this->query($sql);
            $typeArr = null;
            if (empty($TypeCompany)) {
                $typeArr = $Type->find('all', array('conditions' => array('Type.company_id' => $companies_id)));
            } else {
                $typeArr = $TypeCompany;
            }
            $ouputArr = null;
            foreach ($typeArr as $key => $value) {
                $typeData = array("id" => $value['Type']['id'], "name" => $value['Type']['name'], "short_name" => $value['Type']['short_name']);
                $ouputArr[$key] = $typeData;
            }
            return $ouputArr;
        }
    }

    function getLegendForSas($lgndid = null, $type = null) {
        $legndArr = array(
            0 => array(
                "id" => 1,
                "name" => "New",
                "color" => "#F08E83",
                "percentage" => 0,
                "seq_order" => 1,
            ),
            1 => array(
                "id" => 2,
                "name" => "In Progress",
                "color" => "#6BA8DE",
                "percentage" => 0,
                "seq_order" => 1,
            ),
            1 => array(
                "id" => 2,
                "name" => "In Progress",
                "color" => "#6BA8DE",
                "percentage" => 0,
                "seq_order" => 1,
            ),
            2 => array(
                "id" => 5,
                "name" => "Resolve",
                "color" => "#FAB858",
                "percentage" => 0,
                "seq_order" => 1,
            ),
            3 => array(
                "id" => 3,
                "name" => "Close",
                "color" => "#72CA8D",
                "percentage" => 0,
                "seq_order" => 1,
            )
        );
        if ($lgndid) {
            if ($lgndid == 1) {
                return $legndArr[0][$type];
            } else if (in_array($lgndid, array(2, 4, 6))) {
                return $legndArr[1][$type];
            } else if ($lgndid == 3) {
                return $legndArr[3][$type];
            } else {
                return $legndArr[2][$type];
            }
        } else {
            return $legndArr;
        }
    }

}