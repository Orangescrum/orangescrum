<?php
	App::uses('AppModel', 'Model');
 
class CustomField extends AppModel {
	public $name = 'CustomField';
	public $hasMany = array(
        'CustomFieldValue' => array(
            'className' => 'CustomFieldValue',
            'foreignKey'=>'custom_field_id'
        ),
        'CustomFieldOption' => array(
            'className' => 'CustomFieldOption',
            'foreignKey'=>'custom_field_id'
        )
    );
    
    public $belongsTo = array(
    'User' => array('className' => 'User',
            'foreignKey' => 'user_id'
        )
    );
/*  
Author:Sangita
function to Save all Custom Fields 
*/
    function saveCustomField($fieldData){        
        $id = $fieldData['id'];       
        $data = array();
        $data['company_id'] = SES_COMP;
        $data['project_id'] = 0;
        $data['user_id'] = SES_ID;
        $data['associated_to'] = 2;
        $data['label'] = $fieldData['label_nm'];
        $data['placeholder'] = $fieldData['placeholder'];
        $data['is_required'] = $fieldData['is_required'];
            
            if(!empty($id)){                                
                $data['id'] = $id;        
                $saveData =$this->save($data);            
            } else { 
                $data['field_type'] = $fieldData['field_type'];
                $data['is_active'] = 1;
                $customFieldList = $this->find('all',array('conditions'=>array('CustomField.company_id'=>SES_COMP,'CustomField.is_active'=>1,'CustomField.is_advanced'=>0),'fields'=>array('CustomField.id')));
                     
                if(count($customFieldList) >= 5){
                    $data['is_active'] = 0;
            }
                $this->create();    
                $saveData = $this->save($data); 
               
            }
            
        return $saveData;
    }
/*  
Author:Sangita
function to Save all Advanced Custom Fields data
*/
    function saveAdvancedCustomField($customFieldData,$customFieldId,$advCustomPlaceholder,$companyId,$advFieldId,$advFieldCount){        
        $cfId = $advFieldId;      
        $data = array();
      
        $data['project_id'] = 0;
        $data['user_id'] = SES_ID;
        $data['associated_to'] = 2;     
        $data['field_type'] = 1;
        $data['company_id'] = $companyId;
        $data['is_active'] = 0;
        $data['is_advanced'] = 1;
       
        if($advFieldCount == 0){
        foreach($customFieldData as $key => $value){         
            if($customFieldId[$key] == $cfId){
                $data['is_active'] = 1;            
            } else {
                $data['is_active'] = 0; 
            }
            $data['placeholder']= $advCustomPlaceholder[$key];
            $data['label'] = $value;
            $this->create(); 
            $checkExistance=$this->find('first',array('conditions'=>array('CustomField.company_id'=>SES_COMP,'CustomField.is_advanced'=>1,'CustomField.placeholder'=>$data['placeholder'])));   
            if(empty($checkExistance)){
                $saveData =$this->save($data); 
            }              
        }  
    } else {
        $checkExistance=$this->find('first',array('conditions'=>array('CustomField.company_id'=>SES_COMP,'CustomField.is_advanced'=>1,'CustomField.id'=>$customFieldId)));      
        if(!empty($checkExistance)){                                
            $data['id'] = $checkExistance['CustomField']['id']; 
            if($checkExistance['CustomField']['is_active'] == 1) {
                $data['is_active'] = 0;
            } else {
                $data['is_active'] = 1;
            }     
            $saveData =$this->save($data); 
         }     
    }    
        return $saveData;
    }

/*  
Author:Sangita
function to Fetch list of all Custom Fields  
*/
function fetchTaskCustomField(){   
    $taskCustomField = $this->find('all', array('conditions' => array('CustomField.company_id' => SES_COMP, 'CustomField.associated_to'=>'2','CustomField.is_advanced' => 0),'order'=>array('CustomField.seq' => 'ASC')));
    return $taskCustomField;           
}
/*  
Author:Sangita
function to Fetch default Advanced Custom Fields      
*/
function fetchDefaultAdvCustomField(){   
     $defaultAdvCustomField = $this->find('all', array('conditions' => array('CustomField.company_id' => 0, 'CustomField.associated_to'=>'2','CustomField.is_advanced' => 1)));
     return $defaultAdvCustomField;           
 }
/*  
Author:Sangita
function to Fetch Advanced Custom Fields of a company
*/
function fetchAdvCustomField($compId){   
    $advCustomField = $this->find('all', array('conditions' => array('CustomField.company_id' => $compId, 'CustomField.associated_to'=>'2','CustomField.is_advanced' => 1)));
    return $advCustomField;           
 }
/*  
Author:Sangita
function to Fetching Project Custom Fields         
*/
function fetchActiveAdvCustomField($compId){   
    $activeAdvCustomField = $this->find('all', array('conditions' => array('CustomField.company_id' => $compId, 'CustomField.associated_to'=>'2','CustomField.is_advanced' => 1,'CustomField.is_active' => 1),'fields'=>array('CustomField.id','CustomField.placeholder')));
    return $activeAdvCustomField;           
 }
 function fetchActiveAdvCustomFieldAll($compId){   
    $activeAdvCustomField = $this->find('all', array('conditions' => array( 'CustomField.company_id' => $compId,'CustomField.associated_to'=>'2','CustomField.is_advanced' => 1,'CustomField.is_active' => 1),'fields'=>array('CustomField.id','CustomField.placeholder', 'CustomField.label')));
    
    return $activeAdvCustomField;           
 }
/*  
Author:Sangita
function to Fetch Only active Task Custom Fields       
*/
function ajaxfetchTaskCustomField(){
    $taskCustomeField = $this->find('all', array('conditions' => array('CustomField.company_id' => SES_COMP, 'CustomField.associated_to'=>'2','CustomField.is_active'=>1,'CustomField.is_advanced' => 0),'order'=>array('CustomField.seq' => 'ASC')));
    return $taskCustomeField;       
}
/*  
Author:Sangita
function to Fetch All Active Task Custom Fields for edit task popup        
*/
function fetchActiveCustomField(){
     $taskCustomeField = $this->find('all', array('conditions' => array('CustomField.company_id' => SES_COMP, 'CustomField.associated_to'=>'2','CustomField.is_active'=>1,'CustomField.is_advanced' => 0),'order'=>array('CustomField.seq' => 'ASC'),'recursive' => -1));
     return $taskCustomeField;       
}
/*  
Author:Sangita
function to Fetching Project Custom Fields         
*/
function fetchProjectCustomField(){
    $projectCustomeField = $this->find('all', array('conditions' => array('CustomField.company_id' => SES_COMP, 'CustomField.user_id' => SES_ID, 'CustomField.associated_to'=>'1')));
    return $projectCustomeField;
}
/*  
Author:Sangita
function to Manage custom field active/inactive status         
*/
function isActiveManage($id, $activeValue){
    $customFields = $this->find('all',array('conditions'=>array('CustomField.company_id'=>SES_COMP,'CustomField.is_active'=>1,'CustomField.is_advanced'=>0),'fields'=>array('CustomField.id')));
 
     if(count($customFields) >= 5 && $activeValue == 1){
        return 2; 
     } else {
			$this->create();
			$this->id = $id;  
			$activeStatus = $this->saveField('is_active', $activeValue);
			if($activeStatus){
			 return 1;  
			} else {
					return 0;
			}
		}       
}
    /*
    Author:Sangita
    function to Fetch custom field details by id of the current company           
    */
    function getCFDetails($id){
        $getCustomeField = $this->find('first', array('conditions' => array('CustomField.company_id' => SES_COMP,'CustomField.id'=>$id),'fields'=>array('CustomField.id','CustomField.company_id','CustomField.user_id','CustomField.associated_to','CustomField.label','CustomField.field_type','CustomField.placeholder','CustomField.default_value','CustomField.is_required')));
        return $getCustomeField; 
    }

    public function getAllActiveCustomFields()
	{
		$allCustomFieldValues = $this->find('list', array('conditions' => array('CustomField.company_id' => SES_COMP,'CustomField.is_active' => 1),'fields' => array('CustomField.id','CustomField.label'),'order'=>array('CustomField.is_advanced' => 'DESC')));
		return $allCustomFieldValues;
	}
}