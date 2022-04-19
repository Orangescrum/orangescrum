<?php

class ProjectUser extends AppModel {

    public $name = 'ProjectUser';
    public $belongsTo = array('Project' =>
        array('className' => 'Project',
            'foreignKey' => 'project_id'
        ),
        'User' => array('className' => 'User',
            'foreignKey' => 'user_id'
        )
    );

    /**
     * This method gets the user's detail
     * 
     * @author Sunil
     * @method getAllNotifyUser
     * @params number, array, string
     * @return array of user's detail
     */
    function getAllNotifyUser($project_id = NULL, $emailUser = array(), $type = 'case_status') {
        if (isset($project_id) && isset($type)) {
            $this->recursive = -1;
            $fld = $type;
            $temp_var = '';
            if ($type == 'new' || $type == 'reply')
                $fld = $type . "_case";
            if ($type == 'new') {
                $temp_var = ', UserNotification.case_status';
            }
            $users = $this->query("SELECT DISTINCT User.id, User.name, User.email,CompanyUser.is_client, UserNotification.{$fld}" . $temp_var . "  FROM users AS User, project_users AS ProjectUser, user_notifications AS UserNotification, company_users as CompanyUser WHERE User.id=ProjectUser.user_id AND User.id=UserNotification.user_id AND User.id=CompanyUser.user_id AND User.isactive='1' AND CompanyUser.is_active='1' AND CompanyUser.company_id=" . SES_COMP . " AND ProjectUser.project_id='" . $project_id . "' AND ProjectUser.company_id = '" . SES_COMP . "' AND ProjectUser.default_email='1'");
			$usrDtls = array();
            foreach ($users as $key => $value) {
                if ((($value['UserNotification'][$fld] == 1) && (in_array($value['User']['id'], $emailUser))) || ($type == 'new' && $value['UserNotification']['case_status'] == 1 && $value['UserNotification']['new_case'] != 1)) {
                    $value['User']['is_client'] = $value['CompanyUser']['is_client'];
                    if ($type == 'new' && $value['UserNotification']['case_status'] == 1 && $value['UserNotification']['new_case'] != 1) {
                        $value['User']['is_new'] = 1;
                    }
                    $usrDtls[]['User'] = $value['User'];
                }
            }
            return $usrDtls;
        }
    }

    function getProjectMembers($projId = NULL) {
        if (isset($projId)) {
            return $this->query("SELECT User.id, User.uniq_id, User.name FROM users AS User, company_users AS CompanyUser,project_users AS ProjectUser WHERE User.id=CompanyUser.user_id AND User.id=ProjectUser.user_id AND ProjectUser.project_id='" . $projId . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active ='1' ORDER BY User.name ASC");
        }
    }

    function getAllProjectsForUsers() {
        $data = $this->query("select `prj`.`uniq_id`, `prj`.`name` from `projects` as `prj`, `project_users` as `prju` where `prju`.`user_id`='" . SES_ID . "' and `prj`.`company_id`='" . SES_COMP . "' and `prju`.`project_id`=`prj`.`id` and `prj`.`isactive`=1 order by `prj`.`name` ASC");
        //echo SES_ID;echo count($data);echo "<pre>";print_r($data);exit;
        return $data;
    }

    function updateVisited($proj_uniqID, $proj_userID = null, $companyID = null) {
        if (!empty($proj_uniqID)) {
            $condition = array();
            $fields = "";
            $condition['Project.uniq_id'] = $proj_uniqID;
            $condition['Project.isactive'] = '1';
            if (!empty($proj_userID) && !empty($companyID)) {
                $condition['ProjectUser.user_id'] = $proj_userID;
                $condition['ProjectUser.company_id'] = $companyID;
                $fields = array('Project.id', 'Project.short_name', 'ProjectUser.id');
            } else if (!empty($proj_userID)) {
                $condition['ProjectUser.user_id'] = $proj_userID;
                $fields = array('Project.id', 'Project.name', 'ProjectUser.id');
            }

            $projArr = $this->find('first', array('conditions' => $condition, 'fields' => $fields));
            #pr($projArr);exit;
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = isset($projArr['Project']['short_name']) ? $projArr['Project']['short_name'] : $projArr['Project']['name'];

                #if ($projIsChange != $projUniq) {
                $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                $ProjectUser['dt_visited'] = GMT_DATETIME;
                $this->save($ProjectUser);
                #}

                return $curProjId;
            }
        }
        return false;
    }

	function checkAssignedProject($proj_id, $userID = null, $companyID = null) {
		$this->recursive = 1;
        if (!empty($proj_id)) {
            $condition = array();
            $fields = "";
            $condition['Project.id'] = $proj_id;
            if (!empty($userID) && !empty($companyID)) {
                $condition['ProjectUser.user_id'] = $userID;
                $condition['ProjectUser.company_id'] = $companyID;
                $fields = array('Project.id', 'Project.short_name', 'ProjectUser.id');
            } else if (!empty($userID)) {
                $condition['ProjectUser.user_id'] = $userID;
                $fields = array('Project.id', 'Project.name', 'ProjectUser.id');
}
            $projArr = $this->find('first', array('conditions' => $condition, 'fields' => $fields));
            if (count($projArr)) {
                return false;
            }else{
				return true;
			}
        }
		return true;
    }
	function getLastVisiedProject($proj_id, $userID = null, $companyID = null) {
		$this->recursive = 1;
        if (!empty($userID) && !empty($companyID) && ($proj_id != 'all' && !empty($proj_id))) {
			$res = $this->find('first', array('conditions' => array('ProjectUser.user_id' => $userID, 'ProjectUser.company_id' => $companyID),'fields'=>array('ProjectUser.project_id'),'order'=>array('ProjectUser.dt_visited'=>'DESC')));
			if($res && $res['ProjectUser']['project_id'] != $proj_id){
				$projArr_t = $this->find('first', array('conditions' => array('ProjectUser.user_id' => $userID, 'ProjectUser.company_id' => $companyID, 'ProjectUser.project_id' =>$proj_id)));
				if($projArr_t){
					$projArr_t['ProjectUser']['dt_visited'] = GMT_DATETIME;
					$this->save($projArr_t);
				}
			}
        }
    }
	function getAllActiveProject($userID = null, $companyID = null, $user_type) {
		$this->recursive = 1;
		if($user_type == 1){
			$res_pu = $this->find('all', array('conditions' => array('ProjectUser.company_id' => $companyID, 'Project.isactive'=>1),'fields'=>array('ProjectUser.project_id'),'order'=>array('ProjectUser.id'=>'DESC')));
		}else{
			$res_pu = $this->find('all', array('conditions' => array('ProjectUser.user_id' => $userID, 'ProjectUser.company_id' => $companyID, 'Project.isactive'=>1),'fields'=>array('ProjectUser.project_id'),'order'=>array('ProjectUser.id'=>'DESC')));
		}
		return $res_pu;
    }

        
    /**
     * updateProjectUserRole
     *
     * @param  mixed $id
     * @param  mixed $role_id
     * @param  mixed $project_id
     * @param  mixed $user_id
     * @return true
     * This function  update the role of a user
     */
    public function updateProjectUserRole($id,$role_id,$project_id,$user_id){
        if(isset($role_id) && $role_id != null){
            $this->id = $id;
            $this->saveField('role_id', $role_id);
            if(Cache::read('userRole'.SES_COMP.'_'.$user_id) !== false){ 
                Cache::delete('userRole'.SES_COMP.'_'.$user_id);
            }
        }
    }
}