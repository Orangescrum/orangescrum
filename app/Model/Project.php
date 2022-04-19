<?php

class Project extends AppModel {

    public $name = 'Project';
    //var $actsAs = array('Global');

    public $hasAndBelongsToMany = array(
        'User' =>
        array(
            'className' => 'User',
            'joinTable' => 'project_users',
            'foreignKey' => 'project_id',
            'associationForeignKey' => 'user_id'
        )
    );
    var $hasMany = array('ProjectUser' =>
        array('className' => 'ProjectUser',
            'foreignKey' => 'project_id'
        )
    );

    function getProjectFields($condition = array(), $fields = array()) {
        $this->recursive = -1;
        return $this->find('first', array('conditions' => $condition, 'fields' => $fields));
    }
	function getProjName($proj_id){
		$this->recursive = -1;
		$recProj = $this->find('first', array('fields' => array('name'), 'conditions' => array('Project.id' => $proj_id)));
		return $recProj['Project']['name'];
	}
	function getProjUid($proj_id){
		$this->recursive = -1;
		$recProj = $this->find('first', array('fields' => array('uniq_id'), 'conditions' => array('Project.id' => $proj_id)));
		return $recProj['Project']['uniq_id'];
	}
    function getProjectMembers($projId = NULL) {
        if (isset($projId)) {
            return $this->query("SELECT User.id, User.uniq_id, User.name FROM users AS User, company_users AS CompanyUser,project_users AS ProjectUser WHERE User.id=CompanyUser.user_id AND User.id=ProjectUser.user_id AND ProjectUser.project_id='" . $projId . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active ='1' ORDER BY User.name ASC");
        }
    }

    public function beforeSave($options = array()) {
        if (trim($this->data['Project']['name'])) {
            $this->data['Project']['name'] = html_entity_decode(strip_tags($this->data['Project']['name']));
        }
        if (trim($this->data['Project']['short_name'])) {
            $this->data['Project']['short_name'] = html_entity_decode(strip_tags($this->data['Project']['short_name']));
        }
    }
	//onboarding phase
	function saveFirstProject($proj_name, $proj_sht_nm='', $user_id, $uniq_id, $comp_id){
		if(empty($proj_name)){
			return true;
		}
		if(empty($proj_sht_nm)){
			$proj_sht_nm = substr($proj_name, 0, 2);
		}
		
		$projArr = array();
		$projArr['Project']['name'] = $proj_name;
		$projArr['Project']['short_name'] = strtoupper($proj_sht_nm);
		$projArr['Project']['priority'] = 2;
		$projArr['Project']['task_type'] = 0;
		$projArr['Project']['status_group_id'] = 0;
		$projArr['Project']['project_methodology_id'] = 1;
		$projArr['Project']['validate'] = 1;
		$projArr['Project']['click_referer'] = 'Onboarding';
		$projArr['Project']['uniq_id'] = $uniq_id;
		$projArr['Project']['user_id'] = $user_id;
		$projArr['Project']['default_assign'] = $user_id;
		$projArr['Project']['project_type'] = 1;
		$projArr['Project']['isactive'] = 1;
		$projArr['Project']['status'] = 1;
		$projArr['Project']['dt_created'] = GMT_DATETIME;
		$projArr['Project']['company_id'] = $comp_id;
		
		if($this->save($projArr)){
			$proj_id = $this->getLastInsertID();
			
			$ProjectUser = ClassRegistry::init('ProjectUser');
			$ProjectUser->recursive = -1;
			$getLastId = $ProjectUser->find('first', array('fields' => array('ProjectUser.id'), 'order' => array('ProjectUser.id DESC')));
			$lastid = $getLastId['ProjectUser']['id'] + 1;
			
			$ProjUsr = array();
			$ProjUsr['ProjectUser']['id'] = $lastid;
			$ProjUsr['ProjectUser']['project_id'] = $proj_id;
			$ProjUsr['ProjectUser']['user_id'] = $user_id;
			$ProjUsr['ProjectUser']['company_id'] = $comp_id;
			$ProjUsr['ProjectUser']['default_email'] = 1;
			$ProjUsr['ProjectUser']['istype'] = 1;
			$ProjUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
			$this->ProjectUser->saveAll($ProjUsr);	
			return $proj_id;
		}
	}	
	function createDummyProject($proj_id, $comp_id, $user_id, $comp_uid, $tzone){
		$user_mod_ret = array();
		//dummy user to company and project user save
		$user_mod = ClassRegistry::init('User');
		$user_mod_ret = $user_mod->addDummyUser($proj_id, $comp_id, $user_id, $comp_uid);		
		$ownr_user = array('User'=>array('id'=>$user_id));
		array_push($user_mod_ret, $ownr_user);
		
		//dummy milestone
		$milestone_mod_ret = array();
		$milestone_mod = ClassRegistry::init('Milestone');
		$milestone_mod_ret = $milestone_mod->addDummyMilestone($proj_id, $comp_id, $user_id);
		
		//add default template
		$ProjectTemplate = ClassRegistry::init('ProjectTemplate');
		$pt_id = $ProjectTemplate->addDummyTemplate($comp_id, $user_id);
		//Project template task group ids
		$ProjectTemplateCase = ClassRegistry::init('ProjectTemplateCase');
		$PtTgIds = $ProjectTemplateCase->addDummyPtTg($comp_id, $user_id, $pt_id);
		
		//Dummy task and time log
		$easycase_mod = ClassRegistry::init('Easycase');
		$easycase_mod_ret = $easycase_mod->addDummyTasks($proj_id, $comp_id, $user_id, $milestone_mod_ret, $user_mod_ret, $tzone, $PtTgIds, $pt_id);
		/*exit;
		//dummy customer create
		$inv_cus_mod = ClassRegistry::init('InvoiceCustomer');
		$ret_inv_cus = $inv_cus_mod->addDummyCustomer($proj_id, $comp_id, $user_id);*/
	}	
    function getAllProjects() {
        $this->recursive = -1;
        if (PAGE_NAME == "groupupdatealerts" || PAGE_NAME == "resource_allocation_report") {
            $orderby = "ORDER BY Project.name ASC";
            $fld = 'Project.id';
        }else if(PAGE_NAME == "popupGoogleCalendarSetting"){
            $orderby = "ORDER BY ProjectUser.dt_visited DESC";
            $fld = 'Project.id';
        } else {
            $orderby = "ORDER BY ProjectUser.dt_visited DESC";
            $fld = 'Project.uniq_id';
        }
        $sql = "SELECT DISTINCT Project.name," . $fld . " FROM projects AS Project,
		project_users AS ProjectUser WHERE Project.id = ProjectUser.project_id AND ProjectUser.user_id='" . SES_ID . "'
		    and ProjectUser.company_id='" . SES_COMP . "' AND Project.isactive='1' AND Project.name !='' " . $orderby;
        $projects = $this->query($sql);
        $allProject = array();
        if (isset($projects) && !empty($projects)) {
            foreach ($projects as $project) {
                if (PAGE_NAME != "groupupdatealerts" && PAGE_NAME != "popupGoogleCalendarSetting" && PAGE_NAME != "resource_allocation_report" ) {
                    $allProject[$project['Project']['uniq_id']] = $project['Project']['name'];
                } else {
                    $allProject[$project['Project']['id']] = $project['Project']['name'];
                }
            }
        }
        return $allProject;
    }
    function getAllAngProjects($user_id) {
        $this->recursive = -1;
		$orderby = "ORDER BY ProjectUser.dt_visited DESC";
		$fld = 'Project.uniq_id';
        $sql = "SELECT DISTINCT Project.id,Project.uniq_id,Project.name FROM projects AS Project,
		project_users AS ProjectUser WHERE Project.id = ProjectUser.project_id AND ProjectUser.user_id='" . $user_id . "'
		    and ProjectUser.company_id='" . SES_COMP . "' AND Project.isactive='1' AND Project.name !='' " . $orderby;
        $projects = $this->query($sql);
		if (isset($projects) && !empty($projects)) {
			$allProject = null;
            foreach ($projects as $k => $v) {
				$allProject[$k] = $v['Project'];
            }
        }
        return $allProject;
    }

    /**
     * @method public deleteprojects(string $projuid) Deleting project and all associated data from project
     * @author GDR<abc@mydomain.com>
     * @return array 
     */
    function deleteprojects($projuid, $company_id = null) {
        $ses_comp = ($company_id) ? $company_id : SES_COMP;
        $this->recursive = -1;
        $proj = $this->find('first', array('conditions' => array('Project.uniq_id' => $projuid, 'Project.company_id' => $ses_comp)));
        if ($proj) {
            $prjid = $proj['Project']['id'];
            // Milestone table record deletion
            $milestone_cls = ClassRegistry::init('Milestone');
            $milestone_cls->recursive = -1;
            $milestone_cls->deleteAll(array('project_id' => $prjid));

            /* //Ganttchart table data deletion
              $gntchart_cls = ClassRegistry::init('Ganttchart');
              $gntchart_cls->recursive = -1;
              $gntchart_cls->deleteAll(array('project_id'=>$prjid)); */

            //Easycase Milestone tbl
            $easycasemilestone_cls = ClassRegistry::init('EasycaseMilestone');
            $easycasemilestone_cls->recursive = -1;
            $easycasemilestone_cls->deleteAll(array('project_id' => $prjid));
			
			//Easycase Favourite tbl
            $EasycaseFavourite_cls = ClassRegistry::init('EasycaseFavourite');
            $EasycaseFavourite_cls->recursive = -1;
            $EasycaseFavourite_cls->deleteAll(array('project_id' => $prjid));
			//Easycase linking tbl
            $EasycaseLinking_cls = ClassRegistry::init('EasycaseLinking');
            $EasycaseLinking_cls->recursive = -1;
            $EasycaseLinking_cls->deleteAll(array('project_id' => $prjid));
			
			//Easycase label tbl
            $EasycaseLabel_cls = ClassRegistry::init('EasycaseLabel');
            $EasycaseLabel_cls->recursive = -1;
            $EasycaseLabel_cls->deleteAll(array('EasycaseLabel.project_id' => $prjid));

            //Easycase tbl data deletion
            $easycase_cls = ClassRegistry::init('Easycase');
            $easycase_cls->recursive = -1;
            $easycase_cls->deleteAll(array('project_id' => $prjid));

            //Daily update tbl data deletion
            $dupdate_cls = ClassRegistry::init('DailyUpdate');
            $dupdate_cls->recursive = -1;
            $dupdate_cls->deleteAll(array('project_id' => $prjid));

            //Custom filter update tbl data deletion
            $cfilter_cls = ClassRegistry::init('CustomFilter');
            $cfilter_cls->recursive = -1;
            $cfilter_cls->deleteAll(array('project_uniq_id' => $projuid));
            //Case User View tbl data deletion
            $cuview_cls = ClassRegistry::init('CaseUserView');
            $cuview_cls->recursive = -1;
            $cuview_cls->deleteAll(array('project_id' => $prjid));
            //Case Recent tbl data deletion
            $caserecent_cls = ClassRegistry::init('CaseRecent');
            $caserecent_cls->recursive = -1;
            $caserecent_cls->deleteAll(array('project_id' => $prjid));
            //Case File Drive tbl data deletion
            $cfdrive_cls = ClassRegistry::init('CaseFileDrive');
            $cfdrive_cls->recursive = -1;
            $cfdrive_cls->deleteAll(array('project_id' => $prjid));
						
						$CaseEditorFile = ClassRegistry::init('CaseEditorFile');
						$CaseEditorFile->recursive = -1;
						$CaseEditorFile->updateAll(array('CaseEditorFile.is_deleted' => 1), array('CaseEditorFile.project_id' => $project_id));
						
            //Status Group delete
            if($proj['Project']['status_group_id']){
                App::import('Component', 'Format');
                $format = new FormatComponent(new ComponentCollection);
                $format->deleteCustomStatusGroup($proj['Project']['status_group_id']); 
            }

            //Case File tbl data deletion
            $casefile_cls = ClassRegistry::init('CaseFile');
            $casefile_cls->recursive = -1;
            $case_files_list = $casefile_cls->find('list', array('conditions' => array('company_id' => SES_COMP, 'downloadurl IS NULL', 'project_id' => $prjid), 'fields' => array('id', 'file')));
            $casefile_cls->deleteAll(array('project_id' => $prjid));
            //Removing all the files from S3 Bucket
            foreach ($case_files_list AS $k => $v) {
                $photo = $v;
                if (defined('USE_S3') && USE_S3 == 1) {
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->deleteObject(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER . $photo);
                } else {
                    if (file_exists(DIR_CASE_FILES . $photo)) {
                        unlink(DIR_CASE_FILES . $photo);
                    }
                }
            }

            //Case Activity tbl data deletion
            $caseactivity_cls = ClassRegistry::init('CaseActivity');
            $caseactivity_cls->recursive = -1;
            $caseactivity_cls->deleteAll(array('project_id' => $prjid));
            //Project User tbl data deletion
            $projectuser_cls = ClassRegistry::init('ProjectUser');
            $projectuser_cls->recursive = -1;
            $projectuser_cls->deleteAll(array('project_id' => $prjid));
            //Project tbl data deletion
            if ($this->delete($prjid, false)) {
                $arr['succ'] = 1;
                $arr['msg'] = __('Project deleted successfully');
            }
        } else {
            $arr['error'] = 1;
            $arr['msg'] = __('Oops! No project found with the given id.');
        }
        return $arr;
    }
    function getLatestProjectId($lst_id, $lst_comp_id){
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $ProjectUser->unbindModel(array('belongsTo' => array('User')));
        $sql = "SELECT DISTINCT Project.id,Project.uniq_id,Project.name,Project.default_assign, ProjectUser.dt_visited FROM project_users AS ProjectUser,projects AS Project WHERE Project.id= ProjectUser.project_id AND ProjectUser.user_id=" . $lst_id . " AND Project.isactive='1' AND Project.company_id='" . $lst_comp_id . "' order by ProjectUser.dt_visited DESC limit 1";
        $getlatestproj =$ProjectUser->query($sql);
        $latestprojuniqid = $getlatestproj['0']['Project']['uniq_id'];
        $getProjectUniqId = $latestprojuniqid;  
        $getprojectId = $this->find("first", array('conditions' => array('Project.uniq_id' => $getProjectUniqId)));
             
        $project_id = $getprojectId['Project']['id'];
        return  $project_id;
    }
    function getProjectId($name, $mbchk=0, $chk_stsgrp=0) {
        $this->unbindModel(array('hasMany' => array('ProjectUser'), 'hasAndBelongsToMany' => array('User')));
		if($mbchk){
			$project = $this->find('first', array('fields' => array('id','status_group_id'), 'conditions' => array('Project.isactive' => 1, 'Project.company_id' => SES_COMP, 'Project.name LIKE ' => $name)));
		}else{
        $project = $this->find('first', array('fields' => array('id','status_group_id'), 'conditions' => array('Project.isactive' => 1, 'Project.company_id' => SES_COMP, 'Project.name LIKE ' => trim(strtolower($name)))));
		}
		if($chk_stsgrp){
			$pro_id = !empty($project['Project']['id']) ? $project['Project']['id'].'__'.$project['Project']['status_group_id'] : '';
		}else{
			$pro_id = !empty($project['Project']['id']) ? $project['Project']['id'] : '';
		}
        return $pro_id;
    }
    function getComProjCount($company_id) {
        $prjlist = $this->find('list', array('conditions' => array('company_id' => $company_id), 'fields' => array('id', 'name')));
        $prjcnt = !empty($prjlist) ? count($prjlist) : 0;
        return $prjcnt;
    }

    function getDefaultTask() {
        $defaultTask = $this->find('list', array('fields' => array('Project.id', 'Project.task_type'), "conditions" => array('Project.company_id' => SES_COMP)));
        return $defaultTask;
}
function projectSetVisted($proj_uniqID, $proj_userID = null, $companyID = null) {
        App::import('Model', 'ProjectUser');
        $ProjectUser_modl = new ProjectUser();
       //$this->bindModel(array('hasMany' => array('ProjectUser')));
        if (!empty($proj_uniqID)) {
            $condition = array();
            $fields = "";
            $condition['Project.uniq_id'] = $proj_uniqID;
            $condition['Project.isactive'] = '1';
            if (!empty($proj_userID) && !empty($companyID)) {
                $condition['ProjectUser.user_id'] = $proj_userID;
                $condition['ProjectUser.company_id'] = $companyID;
                $fields = array('Project.id', 'Project.short_name','ProjectUser.id');
            } else if (!empty($proj_userID)) {
                $condition['ProjectUser.user_id'] = $proj_userID;
                $fields = array('Project.id', 'Project.name','ProjectUser.id');
            }           
            $projArr = $ProjectUser_modl->find('first', array('conditions' => $condition, 'fields' => $fields));
            #pr($projArr);exit;
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = isset($projArr['Project']['short_name']) ? $projArr['Project']['short_name'] : $projArr['Project']['name'];

                #if ($projIsChange != $projUniq) {
                $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                $ProjectUser['dt_visited'] = GMT_DATETIME;
                $ProjectUser_modl->save($ProjectUser);
                #}
                return $curProjId;
            }
        }
        return false;
    }
    function getDefaultPstatus($comp_id) {
			$this->unbindModel(array('hasMany' => array('ProjectUser'), 'hasAndBelongsToMany' => array('User')));
			$defaultTask = $this->find('all', array('fields' => array('Project.status','COUNT(Project.id) as cnt'), "conditions" => array('Project.company_id' => $comp_id), 'group'=>array('Project.status')));
			return $defaultTask;
		}
		function getPstatusDtl($comp_id, $id) {
			$this->unbindModel(array('hasMany' => array('ProjectUser'), 'hasAndBelongsToMany' => array('User')));
			$defaultTask = $this->find('all', array('fields' => array('Project.status','COUNT(Project.id) as cnt'), "conditions" => array('Project.company_id' => $comp_id,'Project.status' => $id), 'group'=>array('Project.status')));
			return $defaultTask;
		}
		function getDefaultPtype($comp_id) {
			$this->unbindModel(array('hasMany' => array('ProjectUser'), 'hasAndBelongsToMany' => array('User')));
			$this->bindModel(array('hasOne' => array('ProjectMeta')));
			$defaultTask = $this->find('all', array('fields' => array('ProjectMeta.proj_type','COUNT(Project.id) as cnt'), "conditions" => array('Project.company_id' => $comp_id), 'group'=>array('ProjectMeta.proj_type')));
			return $defaultTask;
		}
		function getPtypeDtl($comp_id, $id) {
			$this->unbindModel(array('hasMany' => array('ProjectUser'), 'hasAndBelongsToMany' => array('User')));
			$this->bindModel(array('hasOne' => array('ProjectMeta')));
			$defaultTask = $this->find('all', array('fields' => array('ProjectMeta.proj_type','COUNT(Project.id) as cnt'), "conditions" => array('Project.company_id' => $comp_id,'ProjectMeta.proj_type' => $id), 'group'=>array('ProjectMeta.proj_type')));
			return $defaultTask;
		}
    function updateDtVisited($uid, $user_id, $comp_id=null){
		$prjusers = ClassRegistry::init('ProjectUser');
		$Easycs = ClassRegistry::init('Easycase');		
		$projmod = ClassRegistry::init('Project');		
		$resEC = $Easycs->find('first', array('conditions' => array('Easycase.uniq_id' => $uid,'Easycase.istype' => 1), 'fields' => array('id', 'project_id')));
		if($resEC){
			$resPU = $prjusers->find('first', array('conditions' => array('ProjectUser.project_id' => $resEC['Easycase']['project_id'],'ProjectUser.user_id' => $user_id), 'fields' => array('id', 'project_id','company_id')));
			if($resPU){				
				$resProjMod = $projmod->find('first', array('conditions' => array('Project.id' => $resEC['Easycase']['project_id']), 'fields' => array('id', 'name','uniq_id','company_id')));				
				$ProjectUser = null;
				$ProjectUser['id'] = $resPU['ProjectUser']['id'];
                $ProjectUser['dt_visited'] = GMT_DATETIME;
                $prjusers->save($ProjectUser);	
				return $resProjMod;
			}
		}
		return false;		
	}
	function updateRptVisited($proj_uniqID, $proj_userID = null, $companyID = null) {
        $prjusers = ClassRegistry::init('ProjectUser');
		$prjusers->bindModel(array('belongsTo' => array('Project')));
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

            $projArr = $prjusers->find('first', array('conditions' => $condition, 'fields' => $fields));
            #pr($projArr);exit;
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = isset($projArr['Project']['short_name']) ? $projArr['Project']['short_name'] : $projArr['Project']['name'];

                #if ($projIsChange != $projUniq) {
                $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                $ProjectUser['dt_visited'] = GMT_DATETIME;
                $prjusers->save($ProjectUser);
                #}
                return $curProjId;
            }
        }
        return false;
    }
	function getLastVisiedProject($proj_id, $userID = null, $companyID = null) {
		$prjusers = ClassRegistry::init('ProjectUser');
		$prjusers->recursive = 1;
        if (!empty($userID) && !empty($companyID) && ($proj_id != 'all' && !empty($proj_id))) {
			$res = $prjusers->find('first', array('conditions' => array('ProjectUser.user_id' => $userID, 'ProjectUser.company_id' => $companyID),'fields'=>array('ProjectUser.project_id'),'order'=>array('ProjectUser.dt_visited'=>'DESC')));
			if($res && $res['ProjectUser']['project_id'] != $proj_id){
				$projArr_t = $prjusers->find('first', array('conditions' => array('ProjectUser.user_id' => $userID, 'ProjectUser.company_id' => $companyID, 'ProjectUser.project_id' =>$proj_id)));
				if($projArr_t){
					$projArr_t['ProjectUser']['dt_visited'] = GMT_DATETIME;
					$prjusers->save($projArr_t);
				}
			}
        }
    }
    function compareProjectStatusgroup($frm_proj_id, $to_proj_id){
		$to_proj_id = trim($to_proj_id);
		$frm_proj_id = trim($frm_proj_id);
		if($frm_proj_id == $to_proj_id){
			return true;
		}
		$prjLst = $this->find('list', array('conditions' => array('Project.id' => array($frm_proj_id, $to_proj_id),'Project.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.status_group_id')));
		if($prjLst && $prjLst[$frm_proj_id] == $prjLst[$to_proj_id]){
			return true;
		}	
		return false;
	}
     /* Check resources and create new project from resource availability page.
    * Resources to be adde to projectUsers table.
    Sangita - 22/06/2021
    */
    function resource_create_project($projectId,$resourceIds){      
        $ProjectUser = ClassRegistry::init('ProjectUser'); 
            $checkProjectExist = $ProjectUser->find('all',array('conditions'=>array('ProjectUser.project_id'=>$projectId,'ProjectUser.company_id'=>SES_COMP)));
        $existingUsers = Hash::extract($checkProjectExist, "{n}.ProjectUser.user_id");      
        $distinctUsers=array_diff($resourceIds,$existingUsers);
       
        if(!empty($distinctUsers)){ 
            foreach($distinctUsers as $distinctUser) {                         
                $createUser['id'] = '';
                $createUser['project_id'] = $projectId;
                $createUser['company_id'] = SES_COMP;          
                $createUser['user_id'] = $distinctUser;
                $createUser['istype'] = 1;
                $createUser['default_email'] = 1;
                $createUser['dt_visited'] = GMT_DATETIME;
                $createUser['role_id'] = 3;
                $ProjectUser->create();
                $success = $ProjectUser->save($createUser);                        
            }
            return $success; 
        }
     }
  /* Get all project list.
    *  Sangita - 22/06/2021
    */
    function getAllProjectsList() {
        $project_list = Hash::combine($this->find('all', array('conditions' => array('Project.company_id' => SES_COMP, 'Project.isactive' => 1),'order'=>array('Project.name' => 'ASC'),'recursive' => -1)), '{n}.Project.id', '{n}.Project.name');
        return $project_list;
    }
      /**
 * getProjectRoles
 *
 * @param  mixed $company_id
 * @param  mixed $project_id
 * @return void
 * @author debashis
 * @author bijay
 * date - 28/07/2021
 */
public function getProjectRoles($company_id, $project_id)
{
    
		$ProjectUser = ClassRegistry::init('ProjectUser');
		$allUsers = $ProjectUser->find(
				'list',
				array(
						'conditions'=>array('ProjectUser.company_id'=>$company_id,'ProjectUser.project_id'=>$project_id),
						'fields'=>array('ProjectUser.user_id','ProjectUser.role_id')
				)
		);
        
		return $allUsers;
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
				$projectUser = ClassRegistry::init('ProjectUser');
        if(isset($role_id) && $role_id != null){
            $projectUser->id = $id;
            $projectUser->saveField('role_id', $role_id);
            if(Cache::read('userRole'.SES_COMP.'_'.$user_id) !== false){ 
                Cache::delete('userRole'.SES_COMP.'_'.$user_id);
            }
        }
    }
    public function getProjLists($company_id, $user_id){
		if(SES_TYPE>=3){
			$sql = "SELECT DISTINCT Project.name,Project.uniq_id,Project.id FROM projects AS Project,
        project_users AS ProjectUser WHERE Project.id = ProjectUser.project_id AND ProjectUser.user_id='" . $user_id . "'
				 and ProjectUser.company_id='" . $company_id . "' AND Project.isactive='1' AND Project.name !='' ORDER BY Project.name ASC" ;
			$projects = $this->query($sql);
			$data_res = Hash::combine($projects,'{n}.Project.uniq_id', '{n}.Project.name');
    }else{
		$data_res = Hash::combine($this->find('all', array('conditions' => array('Project.company_id' => $company_id, 'Project.isactive' => 1),'order'=>array('Project.name' => 'ASC'),'recursive' => -1)), '{n}.Project.uniq_id', '{n}.Project.name');
    
    }
		
		return $data_res;
	}
	public function getProjuserLists($company_id, $restrict_uid=0, $proj_id=[]) {
        $User = ClassRegistry::init('User');
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $clt_sql = 1;
        $mlstnQ2 = '';
        $mlstnQ2 = '';
        $qry = '';
        $options = array();
        $options['group'] = array('ProjectUser.user_id');
        $options['fields'] = array('DISTINCT ProjectUser.user_id AS user_id','User.*');
        $options['conditions'] = array("User.isactive" => 1,'ProjectUser.company_id'=>$company_id,'User.name !='=>'');        
        $options['order'] = array("User.name ASC");
        if (!empty($proj_id)) {
          $proj_options = array('conditions' => array('Project.uniq_id' => $proj_id));
          $project_data = $this->find('first', $proj_options);
          $options['conditions'] = array('ProjectUser.project_id' => $project_data['Project']['id'],"User.isactive" => 1,'ProjectUser.company_id'=>$company_id);
        }
        if($restrict_uid){
					$options['conditions']['User.id'] = $restrict_uid;
        }
        //$User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
        $User->bindModel(array('hasOne' => array('CompanyUser' => array('className' => 'CompanyUser', 'foreignKey' => 'user_id','conditions'=>array('CompanyUser.company_id'=>$company_id),'fields'=>array('CompanyUser.is_active')))));
				
        $ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $ProjectUser->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'user_id'))));
        $ProjectUser->recursive = 2;
        $user_data = $ProjectUser->find('all', $options);
				
				if($user_data){
					$user_data = Hash::combine($user_data,'{n}.User.id', ['%s %s', '{n}.User.name', '{n}.User.last_name']);
				}
				
        return $user_data;
    }

	public function getProjectIdFromUser($company_id, $user_ids, $pids=[])
	{		
		$options = [];
		$options['fields'] = array('ProjectUser.project_id');
		$options['conditions'] = array("ProjectUser.company_id" => $company_id,"ProjectUser.user_id" => $user_ids);  
		if(!empty($pids)){
			$options['conditions']['ProjectUser.project_id'] = $pids;
		}	
		$ProjectUser = ClassRegistry::init('ProjectUser');
		//$ProjectUser->bindModel(array('belongsTo' => array('Project')));
		//$ProjectUser->unbindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'user_id'))));
		$ProjectUser->recursive = -1;
		$proj_data = $ProjectUser->find('list', $options);		
		
		if(empty($proj_data)){
			$proj_data = [0 => 0];
		}
		
		return $proj_data;
	}
}