<?php
class EasycaseMilestone extends AppModel{
	var $name = 'EasycaseMilestone';
	
	/*var $belongsTo = array('Easycase' =>
						array('className'     => 'Easycase',
						'foreignKey'    => 'easycase_id'
						),
						'Milestone' =>
						array('className'     => 'Milestone',
						'foreignKey'    => 'milestone_id'
						)
					);*/
    function checkParentInMilestone($task_id, $proj_id, $mils_id){
		$fields = array('EasycaseMilestone.id');
		if($mils_id){
			$result = $this->find('first', array('conditions' => array('EasycaseMilestone.easycase_id' =>$task_id, 'EasycaseMilestone.project_id' => $proj_id,'EasycaseMilestone.milestone_id' =>$mils_id), 'fields' => $fields)); 
		}else{
			$result = 0;
		}        
        return ($result)?1:0;
	}
	function getCurrentMilestone($task_id, $proj_id=null){
		$fields = array('EasycaseMilestone.id','EasycaseMilestone.milestone_id');
		$conditions = array('EasycaseMilestone.easycase_id' =>$task_id);
		if($proj_id){
			$conditions = array('EasycaseMilestone.easycase_id' =>$task_id, 'EasycaseMilestone.project_id' => $proj_id);
		}
		$result = $this->find('first', array('conditions' => $conditions, 'fields' => $fields));
        return ($result && $result['EasycaseMilestone']['milestone_id'])?$result['EasycaseMilestone']['milestone_id']:0;
	}
	function updtaeParentMilestone($mil_id, $ec_id, $proj_id){
		$extres = $this->find('first', array('conditions' => array('EasycaseMilestone.easycase_id' =>$ec_id, 'EasycaseMilestone.project_id' => $proj_id), 'fields' => array('EasycaseMilestone.easycase_id','EasycaseMilestone.id')));
		if($extres){
			if($mil_id){
				$this->updateAll(array('milestone_id' => $mil_id), array('project_id' => $proj_id, 'easycase_id' => $ec_id));
			}else{
				$this->deleteAll(array('EasycaseMilestone.id' => $extres['EasycaseMilestone']['id'], 'EasycaseMilestone.project_id' => $proj_id));
			}			
		}else{
			if($mil_id){
				$mil_status = $this->find('first', array('conditions' => array('EasycaseMilestone.easycase_id' =>$mil_id, 'EasycaseMilestone.project_id' => $proj_id), 'fields' => array('EasycaseMilestone.id_seq')));	
				$postParams = array();
				$postParams['EasycaseMilestone']['easycase_id'] = $ec_id;
				$postParams['EasycaseMilestone']['milestone_id'] = $mil_id;
				$postParams['EasycaseMilestone']['project_id'] = $proj_id;
				$postParams['EasycaseMilestone']['user_id'] = SES_ID; 
				$postParams['EasycaseMilestone']['id_seq'] = ($mil_status)?$mil_status['EasycaseMilestone']['id_seq']:0;
				$this->saveAll($postParams);
			}
		}
	}
	function fetchAllEcIds($mid, $proj_id){
		$mil_ec_ids = $this->find('list', array('conditions' => array('EasycaseMilestone.milestone_id' =>$mid, 'EasycaseMilestone.project_id' => $proj_id), 'fields' => array('EasycaseMilestone.easycase_id')));	
		return $mil_ec_ids;
	}
	
	function getStatuscountForSprint($projId){
		$this->bindModel(array('belongsTo' => array('Easycase','Milestone')));
		$Easycase = ClassRegistry::init('Easycase');
		//$statusCases = $this->find('all',array('conditions'=>array('EasycaseMilestone.project_id'=>$projId,'Easycase.isactive'=>1,'Easycase.istype'=>1,'Milestone.is_started'=>1,'Milestone.project_id'=>$projId,'Milestone.isactive'=>1),'fields'=>array('COUNT(Easycase.id) as CNT','Easycase.legend'),'group'=>array('Easycase.legend'),'order'=>array('Easycase.id'=>'DESC')));
		$TypeCompany = ClassRegistry::init('TypeCompany');
		$stortyp_id = $TypeCompany->getStoryId(SES_COMP);

		/* Parallel Sprint Check Starts */
        $SprintSetting = ClassRegistry::init('SprintSetting');
        $ss = $SprintSetting->find('first',array('conditions'=>array('SprintSetting.company_id'=>SES_COMP)));
        if(isset($ss['SprintSetting']) && !empty($ss['SprintSetting'])){
            $parallel_sprint = $ss['SprintSetting']['is_active'];
        }else{
            $parallel_sprint = 0;        
        }
        /* Parallel Sprint End */   
        $ProjectSetting = ClassRegistry::init('ProjectSetting');
        $velo = $ProjectSetting->find('first',array('conditions'=>array('ProjectSetting.project_id'=>$projId),'fields'=>array('ProjectSetting.velocity_reports')));
        $velocity = (isset($velo['ProjectSetting']) && !empty($velo['ProjectSetting']))?$velo['ProjectSetting']['velocity_reports']:0;
        
        $sum_where_cund = array('EasycaseMilestone.project_id'=>$projId,'Easycase.isactive'=>1,'Easycase.istype'=>1,'Milestone.is_started'=>1,'Milestone.project_id'=>$projId,'Milestone.isactive'=>1);

        if($velocity == 1){
        	$sum_cond ='SUM(Easycase.estimated_hours) as CNT';
        }else if($velocity == 2){
        	$sum_cond ='COUNT(DISTINCT Easycase.id) as CNT';
        }else{
        	$sum_cond ='SUM(Easycase.story_point) as CNT';
        	$sum_where_cund['Easycase.type_id'] = $stortyp_id;
        }
        App::import('Component', 'Format');
        $this->Format = new FormatComponent(new ComponentCollection);
        if(!$this->Format->isAllowed('View All Task',$roleAccess)){
             $sum_where_cund[] = " (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }


		if($parallel_sprint != 0){
			$statusCases = $this->find('all',array('conditions'=>$sum_where_cund,'fields'=>array($sum_cond,'Easycase.legend','Milestone.id'),'group'=>array('EasycaseMilestone.milestone_id','Easycase.legend'),'order'=>array('Easycase.id'=>'DESC')));
			$mile_arr = array();
			$spntHr = array();
			if($statusCases){
				foreach($statusCases as $k => $v){
					$ret = array('opn'=>0,'wip'=>0,'done'=>0);
					$stsArr = array(1=>'opn',2=>'wip',4=>'wip',6=>'wip',3=>'done',5=>'done');
					foreach($statusCases as $spk => $spv){
					  if($v['Milestone']['id'] == $spv['Milestone']['id']){	
							if(isset($ret[$stsArr[$spv['Easycase']['legend']]])){
								$ret[$stsArr[$spv['Easycase']['legend']]] += $spv['0']['CNT'];
							}else{
								$ret[$stsArr[$spv['Easycase']['legend']]] = $spv['0']['CNT'];
							}
						}
					}
					$mile_arr[$v['Milestone']['id']] = $ret;
					$totalSpntHr = $Easycase->totalSpentHrClosedTask($projId,$v['Milestone']['id']);

					array_push($spntHr,$totalSpntHr);
				}
			}
			if($velocity == 1){
				$i = -1;
				foreach ($mile_arr as $key => $value) {
					$i++;
					foreach($value as $k =>$v){
						if($k == 'done'){
							 $mile_arr[$key][$k] = $this->convertSecToHrMin($v) . "/" . $this->convertSecToHrMin($spntHr[$i][0][0]['secds']);
						}else{
						$mile_arr[$key][$k] = $this->convertSecToHrMin($v);
					}
				}
			}		
			}
			return $mile_arr;

		}else{
			$statusCases = $this->find('all',array('conditions'=>$sum_where_cund,'fields'=>array($sum_cond,'Easycase.legend','Milestone.id'),'group'=>array('EasycaseMilestone.milestone_id','Easycase.legend'),'order'=>array('Easycase.id'=>'DESC')));	
			 
			$mile_arr = array();
			if($statusCases){
			$ret = array('opn'=>0,'wip'=>0,'done'=>0);
			$stsArr = array(1=>'opn',2=>'wip',4=>'wip',6=>'wip',3=>'done',5=>'done');
                foreach ($statusCases as $k => $v) {
				foreach($statusCases as $spk => $spv){
					if(isset($ret[$stsArr[$spv['Easycase']['legend']]])){
						$ret[$stsArr[$spv['Easycase']['legend']]] += $spv['0']['CNT'];
					}else{
						$ret[$stsArr[$spv['Easycase']['legend']]] = $spv['0']['CNT'];
					}
				}
			}
				$mile_arr[$v['Milestone']['id']] = $ret;
			}
			if($velocity == 1){
				foreach ($mile_arr as $key => $value) {
					$mile_arr[$key] = $this->convertSecToHrMin($value);
				}
			}

			return $mile_arr;
		}	
	}
	function convertSecToHrMin($sec){
		$hours = floor($sec / 3600);
	    $minutes = floor(($sec / 60) % 60);
	  	return "$hours:".str_pad($minutes, 2, '0', STR_PAD_LEFT);
	}

	function getTaskcountForSprint($projId, $searchFiltrs){
		$qry_m = '';
		if($searchFiltrs['searchMilestone'] != ''){
			$qry_m = '1 '.$searchFiltrs['searchMilestone'];
		}
		if($searchFiltrs['qry'] != ''){
			$qry_m = '1 '.$searchFiltrs['qry'];
		}
		if($qry_m == ''){
			$qry_m = '1';
		}
		$this->bindModel(array('belongsTo' => array('Easycase','Milestone')));
		$statusCases = $this->find('all',array('conditions'=>array('EasycaseMilestone.project_id'=>$projId,'Easycase.isactive'=>1,'Easycase.istype'=>1,'Milestone.is_started'=>1,'Milestone.project_id'=>$projId,'Milestone.isactive'=>1,$qry_m),'fields'=>array('COUNT(Easycase.id) as CNT','Milestone.*'),'order'=>array('Easycase.id'=>'DESC')));
		if($statusCases){
			return array('started_cnt'=>$statusCases[0][0]['CNT'],'started_key'=>$statusCases[0]['Milestone']['id'],'milestone'=>$statusCases[0]['Milestone']);
		}
		return array('started_cnt'=>0,'started_key'=>0);
	}
}