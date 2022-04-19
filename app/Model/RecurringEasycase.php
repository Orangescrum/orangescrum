<?php
class RecurringEasycase extends AppModel{
	var $name = 'RecurringEasycase';
    
    function getRecurringDetails($caseid){
        $caseRecurringDet = $this->find('first', array('conditions'=>array('RecurringEasycase.easycase_id'=>$caseid)));
        $caseRecurringDet['RecurringEasycase']['formatted_endDate'] = date('M d, D', strtotime($caseRecurringDet['RecurringEasycase']['end_date']));
        return $caseRecurringDet;
    }
}