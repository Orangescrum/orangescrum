 <?php

App::uses('AppModel', 'Model');

class CustomFieldValue extends AppModel
{
	var $name = 'CustomFieldValue';
	public $belongsTo = array(
		'CustomField' => array(
			'className' => 'CustomField',
			'foreignKey' => 'custom_field_id'
		)
	);
	
	 /*
    Author:Sangita
    function to Save Task Custom Fields to DB       
    */
	function saveCSValues($caseId, $customFieldData, $customFieldId)
	{
		if (!empty($caseId)) {
			$checkExistance = $this->find('all', array('conditions' => array('CustomFieldValue.custom_field_id' => $customFieldId, 'CustomFieldValue.ref_id' => $caseId)));

			if (!empty($checkExistance)) {
				foreach ($customFieldData as $k => $v) {
					if ($checkExistance[$k]['CustomFieldValue']['custom_field_id'] == $customFieldId[$k]) {
						$this->id = $checkExistance[$k]['CustomFieldValue']['id'];
						$this->saveField('value', $v);
					} else {
						$this->create();
						$arrl = array();
						$arrl['company_id'] = SES_COMP;
						$arrl['ref_id'] = $caseId;
						$arrl['ref_type'] = 2;
						$arrl['custom_field_id'] = $customFieldId[$k];
						$arrl['value'] = $v;
						$this->save($arrl);
					}
				}
			} else {
				$CustomFieldData = array();
				foreach ($customFieldData as $k => $v) {
					$arrl = array();
					$arrl['company_id'] = SES_COMP;
					$arrl['ref_id'] = $caseId;
					$arrl['ref_type'] = 2;
					$arrl['custom_field_id'] = $customFieldId[$k];
					$arrl['value'] = $v;
					$CustomFieldData[] = $arrl;
				}
				$this->saveAll($CustomFieldData);
			}
		}
	}
	 /*
    Author:Sangita
    function to Fetch Task Custom Fields by taskId           
    */
	function getCaseCustomFields($caseId)
	{
		$customFieldValues = $this->find('all', array('conditions' => array('CustomFieldValue.ref_id' => $caseId, 'CustomField.company_id' => SES_COMP, 'CustomField.is_advanced'=>'0','CustomField.is_active'=>'1')));
		foreach($customFieldValues as $key => $customFieldValue){	
				
		if($customFieldValue['CustomField']['field_type'] == 3){
			$customFieldValues[$key]['CustomFieldValue']['value']= date('M d, D',strtotime($customFieldValue['CustomFieldValue']['value']));
			}		      
		}			  	
		return $customFieldValues;
	}
	 /*
    Author:Sangita
    function to Fetch the Advanced Task Custom Fields by taskId           
    */
	function getAllCustomFieldValues()
	{
		$allCustomFieldValues = $this->find('all', array('conditions' => array('CustomFieldValue.company_id' => SES_COMP,'CustomField.is_active' => 1),'fields' => array('CustomFieldValue.custom_field_id','CustomFieldValue.value','CustomField.is_advanced','CustomField.is_active','CustomField.id','CustomFieldValue.ref_id','CustomField.placeholder','CustomField.label')));
		return $allCustomFieldValues;
	}
	 /*
    Author:Sangita
    function to Fetch the Advanced Task Custom Fields by taskId          
    */
	function getAdvancedCustomFields($caseId)
	{
		$advCustomFieldValues = $this->find('all', array('conditions' => array('CustomFieldValue.ref_id' => $caseId, 'CustomField.company_id' => SES_COMP, 'CustomField.is_advanced'=>'1','CustomField.is_active'=>'1')));
		return $advCustomFieldValues;
	}
	 /*
    Author:Sangita
    function to Fetch all Custom Fields Ids for listing page           
    */
	function getAllCFIds()
	{
		$customFieldIds = $this->find('all', array('conditions' => array('CustomField.company_id' => SES_COMP), 'fields' => array('CustomFieldValue.custom_field_id')));
		$customFieldArray = Hash::extract($customFieldIds, "{n}.CustomFieldValue.custom_field_id");
		return $customFieldArray;
	}
	 /*
    Author:Sangita
    function to Delete custom field value records when deleting task          
    */
	function deleteCustomFields($caseId)
	{
		if (!empty($caseId)) {
			$cfData = $this->find('all', array('conditions' => array('CustomFieldValue.ref_id' => $caseId), 'recursive' => -1));

			foreach ($cfData as $CfDetails) {
				$this->deleteAll(
					[
						'CustomFieldValue.company_id' => SES_COMP,
						'CustomFieldValue.id' => $CfDetails['CustomFieldValue']['id']
					]
				);
			}
		}
	}
	 /*
    Author:Sangita
    function to Delete custom field value records when deleting a Project       
    */

	function deleteProjectCustomFields($projuid)
	{
		$Project = ClassRegistry::init('Project');
		$projectDetail = $Project->find('first', array('conditions' => array('Project.company_id' => SES_COMP, 'Project.isactive' => 1, 'Project.uniq_id' => $projuid), 'fields' => array('Project.name', 'Project.id'), 'order' => array('Project.name' => 'ASC'), 'recursive' => -1));

		$projectId = $projectDetail['Project']['id'];
		$Easycases = ClassRegistry::init('Easycase');
		$caseList = $Easycases->find('all', array('conditions' => array('Easycase.project_id' => $projectId), 'fields' => array('Easycase.id'), 'order' => array('Easycase.id' => 'ASC'), 'recursive' => -1));
		$caseIds = Hash::extract($caseList, "{n}.Easycase.id");

		foreach ($caseIds as $caseId) {
			$this->deleteCustomFields($caseId);
		}
	}

		
	/**
	 * getAllCustomFieldByTaskIds
	 *
	 * @param  mixed $task_ids
	 * @param  int $company_id
	 * @return void
	 */
	public function getAllCustomFieldByTaskIds($task_ids, $company_id)
	{
		$allCustomFieldValues = $this->find('all', 
											array('conditions' => 
												array(
													'CustomFieldValue.company_id' => $company_id,
													'CustomField.is_active' => 1,
													'CustomFieldValue.ref_id' => $task_ids
												),
												'fields' => array(
													'CustomFieldValue.custom_field_id',
													'CustomFieldValue.value',
													'CustomField.is_advanced',
													'CustomField.is_active',
													'CustomField.id',
													'CustomFieldValue.ref_id',
													'CustomField.placeholder',
													'CustomField.label'
												),
												'order' => 'CustomField.is_advanced ASC'
											));

		return !empty($allCustomFieldValues) ? $allCustomFieldValues : [];
	}

	/**
	 * reorderCustomFieldArray
	 *
	 * @param  mixed $customfieldArr
	 * @param  mixed $type
	 * @return void
	 */
	public function reorderCustomFieldArray($customfieldArr, $type='all',$dt=null, $tz=null)
	{	
		$allCustomFields = [];
		if(($type == 'taskid')){
			$retResp = []; //for custom fields
			/*$CustomField = ClassRegistry::init('CustomField');
			$allCustomFields = $CustomField->getAllActiveCustomFields();*/
		}else{
			$retResp[0] = []; //for custom fields
			$retResp[1] = []; //for adv custom fields
		}
		if(!empty($customfieldArr)){
			foreach($customfieldArr as  $k => $v){
                if ($v['CustomField']['is_advanced']) {
					//if($v['CustomField']['placeholder'] != 'time_balance')  {
						if(($type == 'taskid')){

							if($v['CustomField']['placeholder'] == 'taskCmplDate'){
								$currdtT = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
								$locDT11 = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['CustomFieldValue']['value'], "datetime");
								$v['CustomFieldValue']['value'] = $dt->facebook_style_date_time($locDT11, $currdtT);
							}

							$retResp[$v['CustomFieldValue']['ref_id']][$v['CustomField']['id']] = $v;
							/*if(isset($retResp[$v['CustomFieldValue']['ref_id']])){
								array_push($retResp[$v['CustomFieldValue']['ref_id']], $v);
							}else{
								$retResp[$v['CustomFieldValue']['ref_id']][] = $v;
							}*/
						}else{
							$vals = ($type == 'label') ? $v['CustomField']['label'] : $v['CustomField'];
							array_push($retResp[1], $vals);
						}
					//}
                }else{
					if(($type == 'taskid')){
						$retResp[$v['CustomFieldValue']['ref_id']][$v['CustomField']['id']] = $v;
						/*if(isset($retResp[$v['CustomFieldValue']['ref_id']])){
							array_push($retResp[$v['CustomFieldValue']['ref_id']], $v);
						}else{
							$retResp[$v['CustomFieldValue']['ref_id']][] = $v;
						}*/
					}else{
						$vals = ($type == 'label') ? $v['CustomField']['label'] : $v['CustomField'];
						array_push($retResp[0], $vals);
					}
				}				
			}			
		}

		/*if(($type == 'taskid') && !empty($retResp)){
			if($allCustomFields){
				foreach($retResp as $k => $v){
					foreach($allCustomFields as $kin => $vin){
						
					}
				}
			}
		}*/

		return $retResp;
	}

}