<?php
class TaskDueChangeReason extends AppModel {
	var $name = 'TaskDueChangeReason';
	public $belongsTo = array('DuedateChangeReason' =>
		array('className' => 'DuedateChangeReason',
			'foreignKey' => 'duedate_change_reason_id'
		)
	);
	
	/**
	 * getDetailByDomain
	 *
	 * @param  mixed $comp_id
	 * @return void
	 * @author PRB
	 */
	public function saveChangeReasons($data)
	{
		//verify if this is the first entry
		if(!empty($data)){
			$reasonData = $this->find('first', array('conditions' => array('TaskDueChangeReason.easycase_id' => $data['easycase_id']), 'fields' => array('TaskDueChangeReason.id')));
			
			if(empty($reasonData)){
				//update the initial due date of tas table
				$Easycase = ClassRegistry::init('Easycase');
				$Easycase->id = $data['easycase_id'];
                $Easycase->saveField('initial_due_date', $data['due_date']);
			}

			$this->id = '';
			if(!empty($data) && $this->save($data)){
				return $this->getLastInsertID();
			}
			
			return 0;
		}
		
		/*$rejectDomains = [
			'www',
			'app',
		];
		if(empty($seo_url) || in_array($seo_url, $rejectDomains)){
			return [];
		}
		$conds = array('Company.seo_url'=>$seo_url,'TaskDueChangeReason.is_active'=>1);   
		$fields = array('TaskDueChangeReason.*','Company.id');
		$options = array();
		$options['fields'] = $fields;
		$options['conditions'] = $conds;
		$options['joins'] = array(array('table' => 'companies', 'alias' => 'Company', 'type' => 'INNER', 'conditions' => array('Company.id=TaskDueChangeReason.company_id')));
		$resp = $this->find('first',$options);
		
		return $resp;*/
	}
}