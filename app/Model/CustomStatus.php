<?php
	App::uses('AppModel', 'Model');

    class CustomStatus extends AppModel {
        public $name = 'CustomStatus';

				
		/*
        Author c pattnaik
        get the max or min status id of a custom status group
        input parameter project id and type
        */

        public function getCustomStatusId($proj_id,$type){
            $ds_join = array(
                array('table' => 'status_groups',
                    'alias' => 'StatusGroup',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'CustomStatus.status_group_id = StatusGroup.id'
                    )
                ),
                array('table' => 'projects',
                    'alias' => 'Project',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'StatusGroup.id = Project.defect_status_group_id'
                    )
                ),
            );    
            $ds_cond = array('CustomStatus.company_id' => SES_COMP,'Project.id'=>$proj_id);
            $sort_type = $type == "max" ? 'DESC' : 'ASC';
            $ds_list = $this->find('first', array('joins'=>$ds_join,'fields' => array('CustomStatus.id', 'CustomStatus.name'), 'conditions' => $ds_cond, 'order' => array('CustomStatus.seq' => $sort_type)));
            return $ds_list['CustomStatus']['id'];
        }
    }
?>