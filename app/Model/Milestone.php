<?php
class Milestone extends AppModel{
	var $name = 'Milestone';
	
	function getMilestone($project_id){
	    return $this->find('list',array('conditions'=>array('Milestone.project_id'=>$project_id,'Milestone.user_id'=>SES_ID,'Milestone.company_id'=>SES_COMP),'fields'=>array('id','title'),'order'=>array('end_date ASC,title ASC')));
	}
	
	public function beforeSave($options = array()) {
		
		if(trim($this->data['Milestone']['title'])) {
			$this->data['Milestone']['title'] = html_entity_decode(strip_tags($this->data['Milestone']['title']));
			if(empty($this->data['Milestone']['title'])){
				return false;
		}
		}		
		if(trim($this->data['Milestone']['description'])) {
			$this->data['Milestone']['description'] = html_entity_decode(strip_tags($this->data['Milestone']['description']));
			if(empty($this->data['Milestone']['description'])){
				return false;
			}
		}
	}
	function milestoneKeywordSearch($caseSrch) {
			$searchcase = "";
			$escape = " ";
			if (trim(urldecode($caseSrch))) {
					$srchstr1 = addslashes(trim(urldecode($caseSrch)));
					if (substr($srchstr1, 0, 1) == "#") {
							$srchstr1 = substr($srchstr1, 1, strlen($srchstr1));
					} else {
							$srchstr1 = $srchstr1;
					}
					if(strpos($srchstr1, '\\') !== false){
						$escape = " ESCAPE '~'";
					}
					$searchcase = "AND (Milestone.title LIKE '%$srchstr1%' $escape OR Milestone.description LIKE '%$srchstr1%' $escape)";
			}
			return $searchcase;
	}
	public  function getMilestoneList($projId, $searchFiltrs, $page=1, $page_limit = 100)
	{	
		$offset = $page * $page_limit - $page_limit;
		$limit = $page_limit;	
		
		$qry_m = '';
		if($searchFiltrs['searchMilestone'] != ''){
			$qry_m = '1 '.$this->milestoneKeywordSearch($searchFiltrs['searchMilestone']);
		}
		if($qry_m == ''){
			$qry_m = '1';
		}
		
		$conds = array('Milestone.company_id'=>SES_COMP, 'Milestone.project_id'=>$projId,$qry_m);
		$fields = array('COUNT(Easycase.id) as CNT','Milestone.*');
		$options = array();
		$options['fields'] = $fields;
		$options['conditions'] = $conds;		
		$options['limit'] = $limit;
		$options['offset'] = $offset;
		
		$options['joins'] = array(
										array('table' => 'easycase_milestones', 'alias' => 'EasycaseMilestone', 'type' => 'LEFT', 'conditions' => array('EasycaseMilestone.milestone_id=Milestone.id','EasycaseMilestone.project_id'=>$projId)),
										array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'LEFT', 'conditions' => array('Easycase.id=EasycaseMilestone.easycase_id','Easycase.isactive'=>1,'Easycase.istype'=>1))
										);
											
		$options["group"] = 'Milestone.id';
		$options["order"] = ['Milestone.id_seq'=>'ASC'];
		$tgrps = $this->find('all',$options);
		$total_tgrps = $this->find('count',array('conditions'=>array('Milestone.project_id'=>$projId,'Milestone.company_id'=>SES_COMP,$qry_m)));
		
		return ['taskgroups'=>$tgrps, 'total' => $total_tgrps];
		
	}
	
	function checkStartedSprint($proj_id, $type=null, $searchFiltrs=array()){
		if($type){
			$EasycaseMilestone = ClassRegistry::init('EasycaseMilestone');
			$taskcnt = $EasycaseMilestone->getTaskcountForSprint($proj_id, $searchFiltrs);
			return $taskcnt;
		}else{
			$std_mil = $this->find('first',array('conditions'=>array('Milestone.project_id'=>$proj_id,'Milestone.company_id'=>SES_COMP,'Milestone.is_started'=>1,'Milestone.isactive'=>1),'fields'=>array('id','title'),'order'=>array('id_seq ASC')));
			if(!$std_mil){
				return 0;
			}
			return $std_mil['Milestone']['id'];
		}
	}
	
	function addDummyMilestone($proj_id, $comp_id, $user_id){		
		$mile_arra = array(
			0=> 'PLANNING(Sample)',
			1=> 'PROJECT CREATION AND RESOURCE LEVELING(Sample)',
			2=> 'DESIGN(Sample)',
			3=> 'DEVELOPMENT(Sample)',
			4=> 'QUALITY ASSURANCE PRE LIVE(Sample)',
			5=> 'RESPONSIVE / MOBILE AND CROSS BROWSER(Sample)',
			6=> 'SOCIAL MEDIA MARKETING ONGOING(Sample)',
			7=> 'PREP FOR GO LIVE(Sample)',
			8=> 'POST GO LIVE AUDIT(Sample)',
			9=> 'ON PAGE SEO(Sample)',
		);		
		App::import('Component', 'Format');
		$format = new FormatComponent(new ComponentCollection);	
		$array_milston_ids = array();
		foreach($mile_arra as $k => $v){			
			$milestone = array();		
			$milestone['title'] = trim($v);
			$milestone['description'] = '';
			$milestone['project_id'] = $proj_id;
			$milestone['user_id'] = $user_id;
			$milestone['company_id'] = $comp_id;
			$milestone['uniq_id'] = $format->generateUniqNumber();
			$this->create();
			$this->save($milestone);
			$milestone_last_insert_id = $this->getLastInsertID();
			array_push($array_milston_ids, $milestone_last_insert_id);
		}
		return $array_milston_ids;
	}
}