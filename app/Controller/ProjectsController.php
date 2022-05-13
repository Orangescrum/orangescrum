<?php
/*************************************************************************	
 * Orangescrum Community Edition is a web based Project Management software developed by
 * Orangescrum. Copyright (C) 2013-2022
 *
 * This program is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 3 as published by the
 * Free Software Foundation with the addition of the following permission added
 * to Section 15 as permitted in Section 7(a): THERE IS NO WARRANTY FOR THE PROGRAM, * TO THE EXTENT PERMITTED BY APPLICABLE LAW. EXCEPT WHEN OTHERWISE STATED IN   
 * WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES PROVIDE THE PROGRAM "AS IS"
 * WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING, BUT NOT 
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A
 * PARTICULAR PURPOSE. THE ENTIRE RISK AS TO THE QUALITY AND PERFORMANCE OF THE
 * PROGRAM IS WITH YOU. SHOULD THE PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF
 * ALL NECESSARY SERVICING, REPAIR OR CORRECTION..
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT
 * ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS
 * FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more
 * details.
 *
 * You should have received a copy of the GNU General Public License along with
 * this program; if not, see http://www.gnu.org/licenses or write to the Free
 * Software Foundation, Inc., 51 Franklin Street Fifth Floor, Boston, MA 02110,
 * United States.
 *
 * You can contact Orangescrum, 2059 Camden Ave. #118, San Jose, CA - 95124, US. 
   or at email address support@orangescrum.com.
 *
 * The interactive user interfaces in modified source and object code versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the "Powered by
 * Orangescrum" logo. If the display of the logo is not reasonably feasible for
 * technical reasons, the Appropriate Legal Notices must display the words
 * "Powered by Orangescrum".
 *****************************************************************************/
App::uses('AppController', 'Controller');

class ProjectsController extends AppController
{
    public $name = 'Projects';
    public $components = array('Format', 'Postcase', 'Tmzone', 'Sendgrid','Pushnotification','PhpMailer');
    public $uses = array('Easycase', 'ProjectUser', 'Project', 'User', 'Company');

    public function beforeRender()
    {
        if (SES_TYPE == 3) {
            //$this->redirect(HTTP_ROOT."dashboard");
        }
        /* if($this->action === 'index') {
          $this->set(	'scaffoldFields', array( 'name', 'short_name', 'isactive', 'dt_created' ) );
          }
          if($this->action === 'view') {
          $this->set(	'scaffoldFields', array( 'name', 'short_name', 'isactive', 'dt_created','dt_updated' ) );
          }
          if($this->action === 'edit') {
          $this->set(	'scaffoldFields', array( 'name', 'short_name') );
          }
          if($this->action === 'add') {
          $this->set(	'scaffoldFields', array( 'name', 'short_name') );
          } */
    }

    public function ajax_get_ptemp()
    {
        $this->layout = 'ajax';
        $this->loadModel('ProjectTemplate');
        $prjTemp = $this->ProjectTemplate->find('first', array('conditions' => array('ProjectTemplate.company_id' => SES_COMP), 'fields' => array('ProjectTemplate.id')));
        echo json_encode(array('uid'=>$prjTemp['ProjectTemplate']['id']));
        exit;
    }
    public function ajax_check_project_exists()
    {
        //$this->layout = 'ajax';
        $this->Project->recursive = -1;
        $retArr['status'] = 1;
        $name = $this->params->data['name'];
        $shortname = $this->params->data['shortname'];
        if (isset($this->params->data['uniqid'])) {
            $uniqid = $this->params->data['uniqid'];
            $conditions = array('Project.name' => urldecode($name), 'Project.company_id' => SES_COMP, 'Project.uniq_id !=' => $uniqid);
        } else {
            $conditions = array('Project.name' => urldecode($name), 'Project.company_id' => SES_COMP);
        }
        $chkName = $this->Project->find('first', array('conditions' => $conditions));
        if (isset($chkName['Project']['id']) && $chkName['Project']['id']) {
            $retArr['status'] = "Project";
        } else {
            if (isset($this->params->data['uniqid'])) {
                $uniqid = $this->params->data['uniqid'];
                $conditions = array('Project.short_name' => urldecode($shortname), 'Project.company_id' => SES_COMP, 'Project.uniq_id !=' => $uniqid);
            } else {
                $conditions = array('Project.short_name' => urldecode($shortname), 'Project.company_id' => SES_COMP);
            }
            $chkShortName = $this->Project->find('first', array('conditions' => $conditions));
            if (isset($chkShortName['Project']['id']) && $chkShortName['Project']['id']) {
                $retArr['status'] = "ShortName";
            } else {
                $retArr['status'] = 1;
            }
        }
        echo json_encode($retArr);
        exit;
    }
    public function manage_task_status_group($listType = null)
    {
        if (!$this->Format->isTimesheetOn(5)) {
            //$this->redirect(HTTP_ROOT."dashboard"); allow all plan
        }
        $this->loadModel('StatusGroup');
        if (isset($this->request->data['StatusGroup']['name']) && !empty($this->request->data['StatusGroup']['name'])) {
            $data = $this->request->data['StatusGroup'];
            $data['company_id'] =  SES_COMP;
            $data['created_by'] =  SES_ID;
            if ($this->request->data['StatusGroup']['id'] == '') {
                $exstSts = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.company_id' =>SES_COMP, 'StatusGroup.name' => trim($this->request->data['StatusGroup']['name']))));
            } else {
                $exstSts = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.company_id' =>SES_COMP, 'StatusGroup.name' => trim($this->request->data['StatusGroup']['name']),'StatusGroup.id !=' =>trim($this->request->data['StatusGroup']['id']))));
            }
            if ($exstSts) {
                $this->Session->write("ERROR", __("Oops! Workflow")." '<b>".trim($this->request->data['StatusGroup']['name'])."</b> '".__("already exists!", true));
                $this->request->data = array();
            } else {
                if ($this->StatusGroup->save($data)) {
                    $this->Session->write("SUCCESS", __("Workflow added successfully", true));
                    if ($this->request->data['StatusGroup']['id'] =='') {
                        $new_id = $this->StatusGroup->getLastInsertID();
                        $this->loadModel('CustomStatus');
                        $this->loadModel('StatusMaster');
                        $stm =$this->StatusMaster->find('list');
                        foreach ($stm as $k=>$v) {
                            $data = array();
                            $color = 'F08E83';
                            $prog = 0;
                            if ($k == 2) {
                                $color = '6ba8de';
                                $prog = 50;
                            } elseif ($k ==3) {
                                $color = '72ca8d';
                                $prog = 100;
                            }
                            $data['name'] = $v;
                            $data['status_master_id'] = $k;
                            $data['color'] =$color;
                            $data['company_id'] =SES_COMP;
                            $data['status_group_id'] =$new_id;
                            $data['progress'] = $prog;
                            $data['seq'] =$k;
                            $this->CustomStatus->create();
                            $this->CustomStatus->save($data);
                            $this->Session->write("SUCCESS", __("Workflow updateded successfully", true));
                        }
                    }
                }
            }
        }
        $dflt_stsarr = array();
        $conditions = array('StatusGroup.company_id'=>SES_COMP);
        if ($listType =='project') {
            $conditions['StatusGroup.parent_id !='] = 0;
        } else {
            $conditions['StatusGroup.parent_id'] = 0;
            $this->StatusGroup->bindModel(array('hasMany' => array('CustomStatus'=>array('fields'=>array('CustomStatus.id')),'Project'=>array('fields'=>array('Project.id')))));
            $dflt_stsarr = $this->StatusGroup->find('all', array('conditions'=>array('company_id'=>0,'is_default'=>1),'order'=>array('StatusGroup.id'=>'ASC')));
        }
        $this->StatusGroup->bindModel(array('hasMany' => array('CustomStatus'=>array('fields'=>array('CustomStatus.id')),'Project'=>array('fields'=>array('Project.id')))));
        $result = $this->StatusGroup->find('all', array('conditions'=>$conditions,'order'=>array('StatusGroup.id'=>'DESC')));

        $prj_cnt = $this->Project->find('count', array('conditions'=>array('Project.status_group_id'=>0, 'Project.company_id'=>SES_COMP),'order'=>array('Project.id'=>'DESC')));
        
        $this->set('dflt_stsarr', $dflt_stsarr);
        $this->set('prj_cnt', $prj_cnt);
        $this->set('result', $result);
    }
    public function ajax_edit_project()
    {
        $this->layout = 'ajax';
        $uniqid = null;
        $uname = null;
        $projArr = array();
        $getTech = array();

        if (Cache::read('userRole'.SES_COMP.'_'.SES_ID) === false) {
            $this->Format->getCachedRoleInfo();
        }

        $roleInfo = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
        $roleAccess = $roleInfo['roleAccess'];
        if (isset($this->request->data['pid']) && $this->request->data['pid']) {
            $uniqid = $this->request->data['pid'];
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $uniqid, 'Project.company_id' => SES_COMP)));
            if (count($projArr)) {
                $this->loadModel("User");
                $this->User->recursive = -1;
                $getUser = $this->User->find("first", array('conditions' => array('User.isactive' => 1, 'User.id' => $projArr['Project']['user_id']), 'fields' => array('User.name')));
                if (count($getUser)) {
                    $uname = $getUser['User']['name'];
                }
            }
        }
        $this->set('uniqid', $uniqid);
        $this->set('uname', $uname);
        $this->set('projArr', $projArr);

        $getProjUsers = $this->Project->query("select User.name,ProjectUser.default_email,User.id,Project.id,ProjectUser.id from project_users as ProjectUser, users as User, projects as Project where User.id=ProjectUser.user_id and Project.uniq_id='" . $_GET['pid'] . "' and Project.id=ProjectUser.project_id and User.isactive='1'");
        $this->set('getProjUsers', $getProjUsers);

        $this->Easycase->recursive = -1;
        $quickMem = $this->Easycase->getMemebers($uniqid, 'default');
        $this->set('quickMem', $quickMem);

        $prj = $this->Project->findByUniqId($uniqid);
        $this->set('defaultAssign', $prj['Project']['default_assign']);
        $task_type = !empty($prj['Project']['task_type']) ? $prj['Project']['task_type'] : '';
        $this->set(compact('task_type'));
        $this->loadModel('StatusGroup');
        $this->loadModel('Easycase');
        $wf_list = $this->StatusGroup->find('list', array('conditions' => array('StatusGroup.company_id' => array(SES_COMP,0),'StatusGroup.parent_id'=>0), 'fields' => array('StatusGroup.id', 'StatusGroup.name'),'order'=>array('StatusGroup.is_default DESC','CASE StatusGroup.is_default  WHEN 0 THEN StatusGroup.name ELSE StatusGroup.id END  ASC')));
        $status_group_id = !empty($prj['Project']['status_group_id']) ? $prj['Project']['status_group_id'] : '';
        if ($status_group_id) {
            $wf_list1 =  $this->StatusGroup->find('list', array('conditions' => array('StatusGroup.id' => $status_group_id), 'fields' => array('StatusGroup.id', 'StatusGroup.name')));
            $wf_list = $wf_list+$wf_list1;
        }
        $this->set(compact('status_group_id', 'wf_list'));
        $defect_status_group_id = !empty($prj['Project']['defect_status_group_id']) ? $prj['Project']['defect_status_group_id'] : '';
        if ($defect_status_group_id) {
            $dfct_wf_list1 =  $this->StatusGroup->find('list', array('conditions' => array('StatusGroup.id' => $defect_status_group_id), 'fields' => array('StatusGroup.id', 'StatusGroup.name')));
            $dfct_wf_list = $wf_list+$dfct_wf_list1;
        } else {
            $dfct_wf_list = $wf_list;
        }
        $this->set(compact('defect_status_group_id', 'dfct_wf_list'));
        $tcnt = $this->Easycase->find('count', array('conditions'=>array('Easycase.project_id'=>$prj['Project']['id'],'istype'=>1,'isactive'=>1)));
        $this->set('tcnt', $tcnt);
        $this->loadModel('Type');
        $task_types = $this->Type->getAllTypes();
        $this->loadModel("TypeCompany");
        $sel_types = $this->TypeCompany->getSelTypes();
        $is_projects = 0;
        $task_list = array();
        if (isset($sel_types) && !empty($sel_types) && isset($task_types) && !empty($task_types)) {
            foreach ($task_types as $key => $value) {
                if ($value['Type']['project_id'] == 0 || $value['Type']['project_id'] == $prj['Project']['id']) {
                    if (array_search($value['Type']['id'], $sel_types)) {
                        $task_list[$value['Type']['id']] = $value['Type']['name'];
                    }
                }
            }
            $is_projects = 1;
        } elseif (!empty($task_types)) {
            foreach ($task_types as $key => $value) {
                if ($value['Type']['project_id'] == 0 || $value['Type']['project_id'] == $prj['Project']['id']) {
                    $task_list[$value['Type']['id']] = $value['Type']['name'];
                }
            }
        }
        $this->set(compact('task_list'));
        $this->loadModel("ProjectMeta");
        $All_Metas = $this->ProjectMeta->getProjectMeta(SES_COMP, $prj['Project']['id']);
        $this->loadModel("ProjectType");
        $All_ptypes = $this->ProjectType->getAllProjectType(SES_COMP, $All_Metas['ProjectMeta']['proj_type']);
        $All_ptypes[0] = __('Select Type');
        ksort($All_ptypes);
        //array_unshift($All_ptypes, __('Select Type'));
        //$resJson['All_ptypes'] = $All_ptypes;
            
        $this->loadModel("ProjectStatus");
        $All_status = $this->ProjectStatus->getAllProjectStatus(SES_COMP, $projArr['Project']['status']);
        $All_status[0] =  __('Select Status');
        ksort($All_status);
        if (!$this->Format->isAllowed('Complete Project', 0, SES_COMP)) {
            if (($key = array_search('Completed', $All_status)) !== false) {
                unset($All_status[$key]);
            }
        }
        //array_unshift($All_status, __('Select Status'));
        //$resJson['All_psttaus'] = $All_status;
            
        $this->loadModel('Industry');
        $industries = $this->Industry->find('list', array('conditions' => array('Industry.is_display' => 1),'fields' => array('Industry.id', 'Industry.name'),'limit'=>29));
        $industries[0] = __('Select Industry');
        ksort($industries);
        //array_unshift($industries, __('Select Industry'));
        //$resJson['All_industry'] = $industries;
            
            
        $this->loadModel('CompanyUser');
        $this->CompanyUser->bindModel(
            array(
                            'belongsTo'=>array(
                                'User' => array(
                                    'className' => 'User',
                                    'foreignKey' => 'user_id',
                                )
                            )
            )
        );
        $this->CompanyUser->recursive = 2;
        $ActiveUsers = $this->CompanyUser->find("all", array("conditions" => array('CompanyUser.is_active' => 1,'CompanyUser.company_id' => SES_COMP), 'fields' => array('User.uniq_id','User.name','User.last_name'),'order'=>array('CompanyUser.user_type'=>'ASC')));
        $act_users = array('0'=>__('Select Project Manager'));
        if ($ActiveUsers) {
            foreach ($ActiveUsers as $k => $v) {
                $act_users[$v['User']['uniq_id']] = trim($v['User']['name'].' '.$v['User']['last_name']);
            }
        }
        //$resJson['All_managers'] = $act_users;
        $options = array();
        $options['fields'] = array('id', "currency", "CONCAT_WS(' ',title,first_name,last_name) AS name");
        $options['conditions'] = array('company_id' => SES_COMP, 'status' => 'Active');
        $options['order'] = 'first_name ASC';
        $all_customers = array();
       
        array_unshift($all_customers, __('Select Customer'));
        $all_customers['0__new'] = '+ Add New';
        $resJson['All_customers'] = $all_customers;
            
        $this->set(compact('all_customers', 'act_users', 'industries', 'All_status', 'All_ptypes', 'All_Metas', 'roleAccess'));
    }
    public function ajax_setting_project()
    {
        $this->layout = 'ajax';
        $uniqid = null;
        $projArr = array();
        $this->loadModel('ProjectSetting');

        if (isset($this->request->data['ProjectSetting']) && !empty($this->request->data['ProjectSetting'])) {
            $arr['status'] = 0;
            $arr['msg'] = __("Oops! something went worng.", true);
            $data = $this->request->data['ProjectSetting'];
            if ($this->ProjectSetting->save($data)) {
                $arr['status'] = 1;
                $arr['msg'] = __("Setting updated successfully.", true);
            } else {
                $arr['status'] = 0;
                $arr['msg'] = __("Oops! something went worng.", true);
            }
            echo json_encode($arr);
            exit;
        }

        if (isset($this->request->data['pid']) && $this->request->data['pid']) {
            $uniqid = $this->request->data['pid'];
            $projArr = $this->ProjectSetting->find('first', array('conditions' => array('ProjectSetting.project_id' => $uniqid, 'ProjectSetting.company_id' => SES_COMP)));
        }
        $this->set('pid', $uniqid);
        $this->set('projArr', $projArr);
    }

    public function settings($img = null)
    {
        $logo = urldecode($img);
        $projecturl = '';
        $projecturl = DEFAULT_PROJECTVIEW == 'manage' ? '/' : '/active-grid';
        if ($logo && file_exists(DIR_PROJECT_LOGO . $logo)) {
            $checkPhoto = $this->Project->find('count', array('conditions' => array('Project.logo' => $logo)));
            $uniq_id = $this->Project->find('first', array('conditions' => array('Project.logo' => $logo)));
            $unqid = $uniq_id['Project']['uniq_id'];
            $id = $uniq_id['Project']['id'];
            if ($checkPhoto) {
                unlink(DIR_PROJECT_LOGO . $logo);

                $Project['id'] = $id;
                $Project['logo'] = "";
                //$Project = Sanitize::clean($Project, array('encode' => false));
                $this->Project->save($Project);

                $this->Session->write("SUCCESS", __("Project Logo removed successfully", true));
                $this->redirect(HTTP_ROOT . "projects/settings/?pid=" . $unqid);
            }
        }

        if (isset($this->params->data['Project'])) {
            $this->loadModel("ProjectUser");
            $postProject['Project'] = $this->params->data['Project'];
            $postProject['Project']['name'] = htmlspecialchars(trim($postProject['Project']['name']), ENT_QUOTES);
            $postProject['Project']['short_name'] = trim($postProject['Project']['short_name']);
            $postProject['Project']['status'] = $this->params->data['Project']['status'];
            if (!empty($this->params->data['Project']['start_date'])) {
                $postProject['Project']['start_date'] = date("Y-m-d", strtotime($this->params->data['Project']['start_date']));
            }
            if ($postProject['Project']['status'] == 4) {
                $postProject['Project']['isactive'] = 2;
            } else {
                $postProject['Project']['isactive'] = 1;
            }
            if (!empty($this->params->data['Project']['end_date'])) {
                $postProject['Project']['end_date'] = date("Y-m-d", strtotime($this->params->data['Project']['end_date']));
            }
            if ($postProject['Project']['validateprj'] == 1) {
                $prjid = $postProject['Project']['id'];
                //$redirect = HTTP_ROOT . "projects/manage".$projecturl;
                $redirect = $_SERVER['HTTP_REFERER'];
                $page_lmt = $postProject['Project']['pg'];
                if (intval($page_lmt) > 1) {
                    $redirect.="?page=" . $page_lmt;
                }
                if (isset($this->data['viewpage']) && $this->data['viewpage'] == 'overview') {
                    $redirect = HTTP_ROOT . "dashboard#overview";
                }
                $findName = $this->Project->query("SELECT id FROM projects WHERE name='" . addslashes($postProject['Project']['name']) . "' AND id!=" . $prjid . " AND company_id='" . SES_COMP . "'");
                if (count($findName)) {
                    $this->Session->write("ERROR", __("Project name", true)." '" . $postProject['Project']['name'] . "' ".__('already exists', true));
                    $this->redirect($redirect);
                }

                $findShrtName = $this->Project->query("SELECT id FROM projects WHERE short_name='" . addslashes($postProject['Project']['short_name']) . "' AND id!=" . $prjid . " AND company_id='" . SES_COMP . "'");
                if (!empty($findShrtName)) {
                    $this->Session->write("ERROR", __("Project short name", true)." '" . $postProject['Project']['short_name'] . "' ".__('already exists', true));
                    $this->redirect($redirect);
                }
                $previousStatusId = $this->Project->find('first', array('conditions'=>array('Project.id'=>$prjid),'fields'=>array('status_group_id','defect_status_group_id')));
                $postProject['Project']['status_group_id'] = isset($postProject['Project']['status_group_id'])?$postProject['Project']['status_group_id']:$previousStatusId['Project']['status_group_id'] ;
                if ($previousStatusId['Project']['status_group_id'] != $postProject['Project']['status_group_id']) {
                    if (!empty($postProject['Project']['status_group_id'])) {
                        $postProject['Project']['status_group_id'] = $this->createAssociatedWorkFlow($postProject['Project']['status_group_id'], $postProject['Project']['short_name']);
                    }
                    $this->Format->deleteCustomStatusGroup($previousStatusId['Project']['status_group_id']);
                }
                $postProject['Project']['defect_status_group_id'] = isset($postProject['Project']['defect_status_group_id'])?$postProject['Project']['defect_status_group_id']:$previousStatusId['Project']['defect_status_group_id'] ;
                if ($previousStatusId['Project']['defect_status_group_id'] != $postProject['Project']['defect_status_group_id']) {
                    if (!empty($postProject['Project']['defect_status_group_id'])) {
                        $postProject['Project']['defect_status_group_id'] = $this->createAssociatedWorkFlow($postProject['Project']['defect_status_group_id'], $postProject['Project']['short_name']);
                    }
                    $this->Format->deleteCustomStatusGroup($previousStatusId['Project']['defect_status_group_id']);
                }

                $postProject['Project']['dt_updated'] = GMT_DATETIME;
                if ($this->Project->save($postProject)) {
                    //Save customer detail
                    $p_customer_id = 0;
                    $is_new_clnt = 0;
                    if (isset($this->request->data['ProjectMeta']) && empty($this->request->data['ProjectMeta']['client']) && !empty($this->request->data['InvoiceCustomer']['cust_fname'])) {
                        $p_customer_id = $this->addCustomer($postProject['Project']['id'], $this->params->data);
                        $is_new_clnt = 1;
                    }
                    //save project meta
                    if (isset($this->request->data['ProjectMeta'])) {
                        $this->loadModel('ProjectMeta');
                        $p_meta = $this->ProjectMeta->getProjectMeta(SES_COMP, $postProject['Project']['id']);
                        $postMeta['ProjectMeta'] = $this->request->data['ProjectMeta'];
                        if ($p_meta) {
                            $postMeta['ProjectMeta']['id'] = $p_meta['ProjectMeta']['id'];
                        } else {
                            if (isset($postMeta['ProjectMeta']['id'])) {
                                unset($postMeta['ProjectMeta']['id']);
                            }
                        }
                        if ($is_new_clnt) {
                            $postMeta['ProjectMeta']['client'] = $p_customer_id;
                        }
                        $postMeta['ProjectMeta']['company_id'] = SES_COMP;
                        $postMeta['ProjectMeta']['project_id'] = $postProject['Project']['id'];
                        $postMeta['ProjectMeta']['created'] = GMT_DATETIME;
                        $postMeta['ProjectMeta']['modified'] = GMT_DATETIME;
                        $this->ProjectMeta->saveAll($postMeta);
                    }
                        
                    if ($postProject['Project']['status'] == 4) {
                        $completeProjectId = $postProject['Project']['id'];
                            
                        $getUserIds = $this->ProjectUser->query("SELECT * FROM `project_users` WHERE `project_id`='".$completeProjectId."'");
                        $emailUser = array();
                        if (is_array($getUserIds) && count($getUserIds) > 0) {
                            foreach ($getUserIds as $k=>$v) {
                                $emailUser[] = $v['project_users']['user_id'];
                            }
                        }
                            
                        $notifyAndAssignToMeUsers = $emailUser;
                        $prjTitle = $postProject['Project']['name'];
                        $notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
                            
                        $messageToSend = "Project '".$prjTitle."' is completed.";
                        $this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
                        $this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);
                    }
                    /* Send Push Notification to devices if the project is completed ends here */
                    
                    
                    /* Send push notification to the user to whom the project is assigned starts here */
                    
                    $projectAssigneduser = $postProject['Project']['default_assign'];
                        
                    $getUserDetails = $this->User->query("SELECT `name` FROM `users` WHERE `id`='".$projectAssigneduser."'");
                    $userName = $getUserDetails[0]['users']['name'];
                        
                    $notifyAndAssignToMeUsers = array($projectAssigneduser);
                    $prjTitle = $postProject['Project']['name'];
                    $notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
                        
                    $messageToSend = __("Project '").$prjTitle.__("' is assigned to '").$userName.__("'.");
                    $this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
                    $this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);
                        
                    /* Send push notification to the user to whom the project is assigned ends here */                    
                    if (!stristr(HTTP_ROOT, 'payzilla.in')) {
                        //Code to save the event tracking to lead tracker
                        $sessionReferName = $this->params->data['Project']['click_referer_update'];
                        $sessionEventName = "Update Project";
                        $this->Format->SaveEventTrackUsingCURL($sessionEventName, $sessionReferName, SES_ID);
                    }
                    $this->Session->write("SUCCESS", "'" . strip_tags($postProject['Project']['name']) . "' ".__("saved successfully", true));
                    if ($postProject['Project']['status'] == 4 && isset($this->data['viewpage']) && $this->data['viewpage'] == 'overview') {
                        $uniqid = $this->Project->find('first', array('conditions'=>array('Project.id'=>$completeProjectId,'Project.company_id'=>SES_COMP),'fields'=>array('Project.uniq_id')));
                        $this->redirect(HTTP_ROOT.'dashboard#overview?prouid='.$uniqid['Project']['uniq_id']);
                    } else {
                        $this->redirect($redirect);
                    }
                }
            } else {
                //$this->redirect(HTTP_ROOT."projects/settings/?pid=".$postProject['Project']['uniq']);
            }
        }


        /* $uniqid = NULL; $uname = NULL;
          $projArr = array(); $getTech = array();
          if(isset($_GET['pid']) && $_GET['pid']) {
          $uniqid = $_GET['pid'];
          $this->Project->recursive = -1;
          //$uniqid = Sanitize::clean($uniqid, array('encode' => false));
          $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id'=>$uniqid,'Project.company_id'=>SES_COMP)));
          if(count($projArr))
          {
          $User = ClassRegistry::init('User');
          $User->recursive = -1;
          $getUser = $User->find("first",array('conditions'=>array('User.isactive'=>1,'User.id'=>$projArr['Project']['user_id']),'fields'=>array('User.name')));
          if(count($getUser)){
          $uname = $getUser['User']['name'];
          }

          $Technology = ClassRegistry::init('Technology');
          $getTech = $Technology->find("all",array('conditions'=>array('Technology.name'<>'')));
          }else{
          $this->redirect(HTTP_ROOT."projects/gridview/");
          }
          }
          $this->set('getTech',$getTech);
          $this->set('projArr',$projArr);
          $this->set('uniqid',$uniqid);
          $this->set('uname',$uname);
          This multi section is commenting is due to:
          implement in ajax_edit_project() in ajax.
         */

        /* $getProjUsers = $this->Project->query("select User.name,ProjectUser.default_email,User.id,Project.id,ProjectUser.id from project_users as ProjectUser, users as User, projects as Project where User.id=ProjectUser.user_id and Project.uniq_id='".$_GET['pid']."' and Project.id=ProjectUser.project_id and User.isactive='1'");
          $this->set('getProjUsers',$getProjUsers);

          $this->loadModel("Easycase");
          $this->Easycase->recursive = -1;
          $quickMem = $this->Easycase->getMemebers($_GET['pid'],'default');
          $this->set('quickMem',$quickMem);
          $prj = $this->Project->findByUniqId($uniqid);
          $defaultAssign = $prj['Project']['default_assign'];
          $this->set('defaultAssign',$defaultAssign); */
    }
    public function manage($projtype = null)
    {
        $page_limit = 18;
        if ($projtype == 'inactive') {
            $page_limit = 18;
        }
        if ($projtype == 'inactive-grid' || $projtype == 'active-grid') {
            $page_limit = 10;
        }
        if ($projtype) {
            setcookie('PROJECT_TYPE', $projtype, time() + 3600, '/', DOMAIN_COOKIE, false, false);
        } else {
            setcookie('PROJECT_TYPE', '', -1, '/', DOMAIN_COOKIE, false, false);
        }
        if (isset($_GET['fil-type']) && $projtype == 'active-grid') {
            setcookie('PROJECT_FILL_TYPE', $_GET['fil-type'], time() + 3600, '/', DOMAIN_COOKIE, false, false);
        } else {
            setcookie('PROJECT_FILL_TYPE', '', -1, '/', DOMAIN_COOKIE, false, false);
        }
        $this->Project->recursive = -1;
        $query = "";
        $all_assigned_proj = null;
        if (SES_TYPE == 3) {
            $all_assigned_proj = $this->Project->query('SELECT project_id FROm project_users WHERE user_id=' . $this->Auth->user('id') . ' AND company_id=' . SES_COMP);
            if ($all_assigned_proj) {
                $all_assigned_proj = Hash::extract($all_assigned_proj, '{n}.project_users.project_id');
                $all_assigned_proj = array_unique($all_assigned_proj);
                $query .= " AND (Project.user_id=" . $this->Auth->user('id') . " OR Project.id IN(" . implode(',', $all_assigned_proj) . "))";
            } else {
                $query .= " AND Project.user_id=" . $this->Auth->user('id');
            }
        }
        $active_project_cnt = 0;
        $inactive_project_cnt = 0;
        if (SES_TYPE == 3) {
            $ext_cond = 'Project.user_id=' . $this->Auth->user('id');
            if ($all_assigned_proj) {
                $ext_cond = '(Project.user_id=' . $this->Auth->user('id') . ' OR Project.id IN(' . implode(',', $all_assigned_proj) . '))';
            }
            $grpcount = $this->Project->query('SELECT count(Project.id) as prjcnt, Project.isactive '
                . 'FROM projects AS Project '
                . 'WHERE ' . $ext_cond . ' AND Project.company_id=' . SES_COMP . ' GROUP BY Project.isactive');
            $filcount = $this->Project->query('SELECT count(Project.id) as prjcnt, Project.status '
                . 'FROM projects AS Project '
                . 'WHERE Project.isactive !=2 AND ' . $ext_cond . ' AND Project.company_id=' . SES_COMP . ' GROUP BY Project.status');
        } else {
            $grpcount = $this->Project->query('SELECT count(Project.id) as prjcnt, Project.isactive '
                . 'FROM projects AS Project '
                . 'WHERE Project.company_id=' . SES_COMP . ' GROUP BY Project.isactive');
            $filcount = $this->Project->query('SELECT count(Project.id) as prjcnt, Project.status '
                . 'FROM projects AS Project '
                . 'WHERE Project.isactive !=2 AND Project.company_id=' . SES_COMP . ' GROUP BY Project.status');
        }
        if ($grpcount) {
            foreach ($grpcount as $key => $val) {
                if ($val['Project']['isactive'] == 1) {
                    $active_project_cnt = $val['0']['prjcnt'];
                } elseif ($val['Project']['isactive'] == 2) {
                    $inactive_project_cnt = $val['0']['prjcnt'];
                }
            }
        }
        $active_project_cnt = $active_project_cnt + $inactive_project_cnt;
        if ($filcount) {
            foreach ($filcount as $key => $val) {
                if ($val['Project']['status'] == 1) {
                    $started_project_cnt = $val['0']['prjcnt'];
                } elseif ($val['Project']['status'] == 2) {
                    $hold_project_cnt = $val['0']['prjcnt'];
                } elseif ($val['Project']['status'] == 3) {
                    $stack_project_cnt = $val['0']['prjcnt'];
                }
            }
        }
        $filtype = "";
            if (isset($_GET['fil-type']) && $_GET['fil-type'] == 'started') {
                $query = "AND Project.status='1' AND Project.isactive!='2'";
                $filtype = 'started';
            } elseif (isset($_GET['fil-type']) && $_GET['fil-type'] == 'on-hold') {
                $query = "AND Project.status='2' AND Project.isactive!='2'";
                $filtype = 'on-hold';
            } elseif (isset($_GET['fil-type']) && $_GET['fil-type'] == 'stack') {
                $query = "AND Project.status='3' AND Project.isactive!='2'";
                $filtype = 'stack';
            }
            $param_count = count($_GET);
            $p_type = $this->request->query['proj-type'];
            $manager_id = $this->request->query['manager'];
            $client = $this->request->query['client'];            
            $url_status = $this->request->query['fil-type'];
            if ((isset($url_status)) && $url_status != 'started' && $url_status != 'on-hold' && $url_status != 'stack') {
                if ($url_status == 4) {
                    $query .=" AND Project.status IN(". $url_status.")"." AND Project.isactive='2'";
                }else{
                    $query .=" AND Project.status IN(". $url_status.")"." AND Project.isactive!='2'";
                }
            }
        $this->set('inactive_project_cnt', $inactive_project_cnt);
        $this->set('active_project_cnt', $active_project_cnt);
        $this->set('started_project_cnt', $started_project_cnt);
        $this->set('hold_project_cnt', $hold_project_cnt);
        $this->set('stack_project_cnt', $stack_project_cnt);
        $this->set('projtype', $projtype);
        $this->set('filtype', $filtype);
         $this->set('p_type', $p_type);
        $this->set('manager_id', $manager_id);
        $this->set('client', $client);
        if ($projtype == "active-grid" || $projtype == "inactive-grid") {
            $this->loadModel('ProjectField');
            $fields = array();
            $fields = $this->ProjectField->find('first', array('conditions' => array('ProjectField.user_id' => SES_ID)));
            if (!empty($fields)) {
                $fields = json_decode($fields['ProjectField']['field_name']);
            }
            $this->set('fields', $fields);
        }else{
        $pjid = null;
        if (isset($_GET['id']) && $_GET['id']) {
            $pjid = $_GET['id'];
        }
        if (isset($_GET['proj_srch']) && $_GET['proj_srch']) {
            $pjname = htmlentities(strip_tags($_GET['proj_srch']));
            $this->set('prjsrch', 'project search');
        }
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }

        //reset model state
        $this->Project->clear();

        if (trim($pjid)) {
            $project = "Project";
            $getProj = $this->Project->find('first', array('conditions' => array('Project.id' => $pjid, 'Project.company_id' => SES_COMP), 'fields' => array('Project.name', 'Project.id')));
            if (isset($getProj['Project']['name']) && $getProj['Project']['name']) {
                $project = $getProj['Project']['name'];
            }
            if ($getProj['Project']['id']) {
                if (isset($_GET['action']) && $_GET['action'] == "activate") {
                    $this->Project->query("UPDATE projects SET isactive='1' WHERE id=" . $getProj['Project']['id']);
                    $this->Session->write("SUCCESS", "'" . $project . "' ".__("activated successfully", true));
                    $this->redirect(HTTP_ROOT . "projects/".isset($_GET['req_uri'])?$_GET['req_uri']:'manage/');
                }
                if (isset($_GET['action']) && $_GET['action'] == "delete") {
                    $this->Project->query("DELETE FROM projects WHERE id=" . $getProj['Project']['id']);

                    $this->ProjectUser->recursive = -1;
                    $this->ProjectUser->query("DELETE FROM project_users WHERE project_id=" . $getProj['Project']['id']);

                    $this->Session->write("SUCCESS", "'" . $project . "' ".__("deleted successfully", true));
                    $this->redirect(HTTP_ROOT . "projects/".isset($_GET['req_uri'])?$_GET['req_uri']:'manage/');
                }
                if (isset($_GET['action']) && $_GET['action'] == "deactivate") {
                    $this->Project->query("UPDATE projects SET isactive='2' WHERE id=" . $getProj['Project']['id']);
                    $this->Session->write("SUCCESS", "'" . $project . "' ".__("deactivated successfully", true));
                    $this->redirect(HTTP_ROOT . "projects/".isset($_GET['req_uri'])?$_GET['req_uri']:'manage/');
                }
            } else {
                $this->Session->write("ERROR", __("Invalid or Wrong action!", true));
                $this->redirect(HTTP_ROOT . "projects/manage");
            }
        }

        $action = "";
        $uniqid = "";
        if (isset($_GET['uniqid']) && $_GET['uniqid']) {
            $uniqid = $_GET['uniqid'];
        }

        if ($projtype == "inactive" || $projtype == "inactive-grid") {
            $query = "AND Project.isactive='2'";
        } else {
            //$query = "AND Project.isactive='1' AND Project.status!='4'";
        }
        if (isset($_GET['project']) && $_GET['project']) {
            $query .= " AND Project.uniq_id='" . $_GET['project'] . "'";
        }
        $query .= " AND Project.company_id='" . SES_COMP . "'";
        if (isset($_GET['action']) && $_GET['action']) {
            $action = $_GET['action'];
        }
        $page = 1;
        $pageprev = 1;
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        if ($projtype != "active-grid" && $projtype != "inactive-grid") {
            $limit1 = $page * $page_limit - $page_limit;
            $limit2 = $page_limit;
            $limit = "LIMIT $limit1,$limit2";
        } else {
            $limit = '';
        }

        $prjselect = $this->Project->query("SELECT name FROM projects AS Project WHERE name!='' " . $query . " ORDER BY dt_created DESC");
        $arrprj = array();
        foreach ($prjselect as $pjall) {
            if (isset($pjall['Project']['name']) && !empty($pjall['Project']['name'])) {
                array_push($arrprj, substr(trim($pjall['Project']['name']), 0, 1));
            }
        }
        if (isset($_GET['prj']) && $_GET['prj']) {
            //$_GET['prj'] = Sanitize::clean($_GET['prj'], array('encode' => false));
            $_GET['prj'] = chr($_GET['prj']);
            $pj = $_GET['prj'] . "%";
            $query .= " AND Project.name LIKE '" . addslashes($pj) . "'";
        }
        if ($pjname) {
            $query .= " AND name LIKE '%" . addslashes($pjname) . "%' ";
        }
        if (isset($p_type)){
           $query.=" AND Types.id IN(".$p_type.")";
            
        }
        $sql = "SELECT SQL_CALC_FOUND_ROWS Project.id,uniq_id,name,Project.user_id,project_type,short_name,Project.description,Project.isactive,Project.status,Project.estimated_hours,Project.priority,Project.dt_created,Project.dt_updated,Project.start_date,Project.end_date,Project.project_methodology_id,Project.status_group_id,
                (SELECT COUNT(easycases.id) AS tot FROM easycases WHERE easycases.project_id=Project.id and easycases.istype='1' and easycases.isactive='1') AS totalcase,
                (SELECT SUM(LogTime.total_hours) AS hours 
                FROM log_times AS LogTime 
                LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id 
                WHERE LogTime.project_id=Project.id AND Easycase.isactive=1) AS totalhours,
                (SELECT COUNT(company_users.id) AS tot FROM company_users, project_users where project_users.user_id = company_users.user_id and project_users.company_id = company_users.company_id and company_users.is_active = 1 and project_users.project_id = Project.id) as totusers,
                (SELECT SUM(case_files.file_size) AS file_size FROM case_files WHERE case_files.project_id=Project.id) AS storage_used,
                (SELECT roles.role FROM roles,project_users where project_users.role_id = roles.id and project_users.user_id ='". SES_ID ."' and project_users.company_id = '".SES_COMP."' and project_users.project_id = Project.id group by project_users.id ) as role,
                (SELECT roles.role FROM roles,company_users where company_users.role_id = roles.id and company_users.user_id ='". SES_ID ."' and company_users.company_id = '".SES_COMP."' group by company_users.id ) as crole
                FROM projects AS Project LEFT JOIN project_metas AS ProjectMeta ON ProjectMeta.project_id = Project.id
                LEFT JOIN project_types AS Types ON Types.id = ProjectMeta.proj_type
                WHERE Project.name!='' " . $query . " 
                ORDER BY dt_created DESC $limit";

        $prjAllArr = $this->Project->query($sql);
        $tot = $this->Project->query("SELECT FOUND_ROWS() as total");
        $CaseCount = $tot[0][0]['total'];
        $this->loadModel('CompanyUser');
        $Activeparams = array('conditions' => array('CompanyUser.is_active' => 1, 'CompanyUser.company_id' => SES_COMP));
        $Activeusers = $this->CompanyUser->find('all', $Activeparams);
        $Activeusers = Hash::extract($Activeusers, '{n}.CompanyUser.user_id');
            
        $this->loadModel('ProjectUser');
        $prjInusers = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.company_id' => SES_COMP,'ProjectUser.user_id' => $Activeusers), 'fields' => array('ProjectUser.project_id', 'ProjectUser.user_id')));
        $prjInusers_list = array();
        $prjuserslist = array();
        if ($prjInusers) {
            foreach ($prjInusers as $key => $val) {
                if (array_key_exists($val['ProjectUser']['project_id'], $prjInusers_list)) {
                    array_push($prjInusers_list[$val['ProjectUser']['project_id']], $val['ProjectUser']['user_id']);
                } else {
                    $prjInusers_list[$val['ProjectUser']['project_id']] = array($val['ProjectUser']['user_id']);
                }
                if (!in_array($val['ProjectUser']['user_id'], $prjuserslist)) {
                    array_push($prjuserslist, $val['ProjectUser']['user_id']);
                }
            }
        }
        $this->set('proj_users_list', $prjInusers_list);
            
        $this->loadModel('User');
        $prjInusersDetls = $this->User->find('all', array('conditions' => array('User.id' => $prjuserslist), 'fields' => array('User.id', 'User.name', 'User.last_name', 'User.photo')));
        if ($prjInusersDetls) {
            $prjInusersDetls = Hash::combine($prjInusersDetls, '{n}.User.id', '{n}');
        }
        $this->set('proj_users_dtllist', $prjInusersDetls);
        //}

        $csts_arr_grp = array();
        if ($prjAllArr) {
            $all_assigned_uids = Hash::extract($prjAllArr, '{n}.Project.user_id');
            $all_assigned_uids_list = array_unique($all_assigned_uids);
            $this->loadModel('User');
            $prjsers_names = $this->User->find('list', array('conditions' => array('User.id' => $all_assigned_uids_list), 'fields' => array('User.id', 'User.name')));
            $this->set('p_u_name', $prjsers_names);
            //custom status ref for other pages
            $sts_ids = array_filter(array_unique(Hash::extract($prjAllArr, '{n}.Project.status_group_id')));
            if ($sts_ids) {
                $Csts = ClassRegistry::init('StatusGroup');
                $csts_arr_grp = $Csts->find('all', array('conditions'=>array('StatusGroup.id'=>$sts_ids)));
                if ($csts_arr_grp) {
                    $csts_arr_grp = Hash::combine($csts_arr_grp, '{n}.StatusGroup.id', '{n}.StatusGroup');
                }
            }
        }
        //Code added by jyotiprakash to correct the Project Progress Calculation
            $this->loadModel('Easycase');
        $update_prjAllArr=$prjAllArr;
        foreach ($prjAllArr as $pkey => $pval) {
            $project_id=!empty($pval['Project']['id'])?$pval['Project']['id']:'';
            $this->loadModel('ProjectMeta');
            $ProjectMeta=array();
            $ProjectMeta = $this->ProjectMeta->find('first', array('conditions' => array('ProjectMeta.project_id' => $project_id)));
            $update_prjAllArr[$pkey]['ProjectMeta']=$ProjectMeta;
                $project_progress_details = $this->Easycase->query('SELECT legend, count(legend) as cnt FROM `easycases` WHERE `project_id`=' . $pval['Project']['id'] . ' AND `istype`=1 AND `isactive`=1 GROUP BY legend ORDER BY id DESC');
            if ($project_progress_details) {
                $complt = 0;
                $not_complt = 0;
                foreach ($project_progress_details as $k => $v) {
                    if (in_array($v['easycases']['legend'], array(3))) { //5
                        $complt += $v[0]['cnt'];
                    } else {
                        $not_complt += $v[0]['cnt'];
                    }
                }
                $project_progress_data[$pval['Project']['id']] = ($complt/($complt+$not_complt))*100;
            } else {
                $project_progress_data[$pval['Project']['id']] = 0;
            }
        }
        $this->set('project_progress_data', $project_progress_data);
        $this->set('csts_arr_grp', $csts_arr_grp);
        //Code added by jyotiprakash to correct the Project Progress Calculation
        $this->loadModel('User');
        $prjmanager_names = $this->User->find('list', array('fields' => array('User.uniq_id', 'User.name')));
        $this->loadModel('Industry');
        $industries = $this->Industry->find('list', array('conditions' => array('Industry.is_display' => 1),'fields' => array('Industry.id', 'Industry.name')));
        $this->loadModel('ProjectType');
        $ProjectType = $this->ProjectType->find('list', array('conditions' => array('ProjectType.is_active' => 1),'fields' => array('ProjectType.id', 'ProjectType.title')));

        $this->set('projecttype', $ProjectType);
        $this->set('industries', $industries);

        $this->set('caseCount', $tot[0][0]['total']);

        $this->loadModel('ProjectStatus');
        //$ProjectStatus = $this->ProjectStatus->find('list', array('conditions' => array('ProjectStatus.is_active' => 1,'ProjectStatus.name !=' => 'Completed'),'fields' => array('ProjectStatus.id', 'ProjectStatus.name')));
        $All_status = $this->ProjectStatus->getAllProjectStatus(SES_COMP);
        ksort($All_status);
        $this->set('ProjectStatus', $All_status);
        $this->set(compact('ProjectStatus'));
        $this->set(compact('data'));
        $this->set('user_list', $user_list);
        $this->set('prjmanager_names', $prjmanager_names);
        $this->set('total_records', $prjAllArr);
        $this->set('proj_srch', $pjname);
        $this->set('page_limit', $page_limit);
        $this->set('page', $page);
        $this->set('pageprev', $pageprev);
        $count_grid = count($prjAllArr);
        $this->set('count_grid', $count_grid);
        $this->set('prjAllArr', $update_prjAllArr);
        $this->set('action', $action);
        $this->set('uniqid', $uniqid);
        $this->set('arrprj', $arrprj);
        $this->set('page_limit', $page_limit);
        $this->set('casePage', $page);
        $this->loadModel("ProjectMethodology");
        $methodologies = $this->ProjectMethodology->find('list', array('fields'=>array('id','title'),'order'=>array('seq_no'=>'ASC')));
        $this->set('methodologies', $methodologies);
            
        $this->loadModel("ProjectStatus");
        $All_status = $this->ProjectStatus->getAllProjectStatus(SES_COMP);
        ksort($All_status);
        $this->set('All_status', $All_status);
            
        }
    }
    public function getCntryCod()
    {
        $ip = $this->Format->getRealIpAddr();
        $data = file_get_contents('https://api.ipinfodb.com/v3/ip-country/?key=' . IP2LOC_API_KEY_TRACK . '&ip=' . $ip . '&format=json');
        //ip-city for more detail
        $data = json_decode($data, true);
        if (!empty($data['countryName']) && $data['countryName'] != '-') {
            if (strtolower($data['countryName']) == 'india') {
                return 'INR';
            }
        }
        return 'USD';
    }
        
    public function addCustomer($project_id, $data)
    {
        $this->loadModel('InvoiceCustomer');
        $id = 0;
        $error = false;
        if (trim($data['InvoiceCustomer']['cust_fname']) == '') {
            $msg = __("Please enter customer name.", true);
            $error = true;
        } elseif (trim($data['InvoiceCustomer']['cust_email']) == '') {
            $msg = __("Please enter email address.", true);
            $error = true;
        } elseif (trim($data['ProjectMeta']['currency']) == '' || trim($data['ProjectMeta']['currency']) == '0') {
            $msg = __("Please select currency.", true);
            $error = true;
        } elseif (trim($data['InvoiceCustomer']['cust_email']) != '') {
            $conditions = array('email' => trim($data['InvoiceCustomer']['cust_email']));
            $conditions[] = "company_id=" . SES_COMP;
            $exist = $this->InvoiceCustomer->find('first', array('conditions' => $conditions));
            if (is_array($exist) && count($exist) > 0) {
                $id = $exist['InvoiceCustomer']['id'];
            }
        }
        if ($error == true) {
            return array('success' => "No", 'msg' => $msg);
        }
        /* assign customer id */
        if (trim($data['ProjectMeta']['currency']) != '' || trim($data['ProjectMeta']['currency']) != 0) {
            $currencyCode = $this->Format->getCurrencyCode($data['ProjectMeta']['currency']);
        }
        $user_id = 0;
        $email = trim($data['InvoiceCustomer']['cust_email']);
        if ($email != "") {
            $this->loadModel('User');
            $userdetails = $this->User->findByEmail($email);
            if (is_array($userdetails) && count($userdetails) > 0) {
                $user_id = $userdetails['User']['id'];
            }
        }
        if (trim($data['InvoiceCustomer']['cust_fname']) != '' && trim($data['InvoiceCustomer']['cust_email']) != '') {
            $customer = array(
                'title' => trim($data['InvoiceCustomer']['cust_title']) != "" ? trim(strip_tags($data['InvoiceCustomer']['cust_title'])) : null,
                    'first_name' => trim(strip_tags($data['InvoiceCustomer']['cust_fname'])),
                'last_name' => trim($data['InvoiceCustomer']['cust_lname']) != '' ? trim(strip_tags($data['InvoiceCustomer']['cust_lname'])) : null,
                'email' => trim($data['InvoiceCustomer']['cust_email']) != "" ? trim($data['InvoiceCustomer']['cust_email']) : null,
                'currency' => $currencyCode != '0' ? $currencyCode : null,
                'organization' => trim($data['InvoiceCustomer']['cust_organization']) != "" ? trim(strip_tags($data['InvoiceCustomer']['cust_organization'])) : null,
                'street' => trim($data['InvoiceCustomer']['cust_street']) != '' ? trim(strip_tags($data['InvoiceCustomer']['cust_street'])) : null,
                'city' => trim($data['InvoiceCustomer']['cust_city']) != '' ? trim(strip_tags($data['InvoiceCustomer']['cust_city'])) : null,
                'state' => trim($data['InvoiceCustomer']['cust_state']) != '' ? trim(strip_tags($data['InvoiceCustomer']['cust_state'])) : null,
                'country' => trim($data['InvoiceCustomer']['cust_country']) != '' ? trim(strip_tags($data['InvoiceCustomer']['cust_country'])) : null,
                'zipcode' => trim($data['InvoiceCustomer']['cust_zipcode']) != "" ? trim(strip_tags($data['InvoiceCustomer']['cust_zipcode'])) : null,
                'phone' => trim($data['InvoiceCustomer']['cust_phone']) != "" ? trim(strip_tags($data['InvoiceCustomer']['cust_phone'])) : null,
                    'status' => trim($data['InvoiceCustomer']['cust_status']) != "" ? trim($data['InvoiceCustomer']['cust_status']) : 'Active',
                    'modified' => date("Y-m-d H:i:s")
                );
            $customer['user_id'] = $user_id;
            if ($id > 0) {
                $this->InvoiceCustomer->id = $id;
            } else {
                $customer['uniq_id'] = $this->Format->generateUniqNumber();
                $customer['project_id'] = $project_id;
                $customer['company_id'] = SES_COMP;
                $customer['created'] = date("Y-m-d H:i:s");
            }
            $this->InvoiceCustomer->save($customer, array('validate' => false));
            return $this->InvoiceCustomer->getLastInsertID();
        }
        return 0;
    }

    public function add_project($createProject = null)
    {
        if (!empty($createProject)) {
            $this->request->data = $createProject;
        }
        $data=$this->request->data;
        $resourceId=$data['resourceId'];
        $projecturl = '';
        $projecturl = DEFAULT_PROJECTVIEW == 'manage' ? '/' : '/active-grid';
        $project_redirect_url = $_SERVER['HTTP_REFERER'];
        if (stristr($_SERVER['HTTP_REFERER'], '/dashboard')) {
            $project_redirect_url = HTTP_ROOT . "dashboard";
        } elseif (!stristr($_SERVER['HTTP_REFERER'], '/projects/manage')) {
            $project_redirect_url = HTTP_ROOT . "projects/manage/".$projecturl;
        }
        $Company = ClassRegistry::init('Company');
        $comp = $Company->find('first', array('conditions' => array('Company.seo_url' => CHECK_DOMAIN), 'fields' => array('Company.name')));
        $userscls = ClassRegistry::init('User');
        $companyusercls = ClassRegistry::init('CompanyUser');
        $postProject['Project'] = $this->params->data['Project'];
        if (!empty($createProject['Project'])) {
            $postProject['Project'] = $createProject['Project'];
        }

        if (!empty($this->params->data['Project']['start_date'])) {
            $postProject['Project']['start_date'] = date("Y-m-d", strtotime($this->params->data['Project']['start_date']));
        }
        if (!empty($this->params->data['Project']['end_date'])) {
            $postProject['Project']['end_date'] = date("Y-m-d", strtotime($this->params->data['Project']['end_date']));
        }
        if ($this->data['Project']['members_list']) {
            $emaillist = trim(trim($this->data['Project']['members_list']), ',');
            if (strstr(trim($emaillist), ',')) {
                $emailid = explode(',', $emaillist);
            } else {
                $emailid = explode(',', $emaillist);
            }
            $emailarr = array();
            foreach ($emailid as $ind => $data) {
                if (trim($data) != '') {
                    $emailarr[$ind] = trim($data);
                    $cond .= " (email LIKE '%" . trim($data) . "%') OR";
                }
            }
            if ($emailarr) {
                $emailarr = array_unique($emailarr);
                $cond = substr($cond, 0, strlen($cond) - 2);
                $userlist = $userscls->find('list', array('conditions' => array($cond), 'fields' => array('id', 'email')));
                if ($userlist) {
                    $compuserlist = $companyusercls->find('list', array('conditions' => array('company_id' => SES_COMP, 'user_id' => array_keys($userlist), 'is_active' => 1), 'fields' => array('CompanyUser.id', 'CompanyUser.user_id')));
                    if ($compuserlist) {
                        $removeduserlist = array();
                        foreach ($compuserlist as $k1 => $value) {
                            $postProject['Project']['members'][] = $value;
                            $removeduserlist[] = $userlist[$value];
                            //$index = array_search($userlist[$value],$emailarr);
                            //unset($emailarr[$index]);
                        }
                        foreach ($emailarr as $key1 => $edata) {
                            if (in_array(trim($edata), $removeduserlist)) {
                                unset($emailarr[$key1]);
                            }
                        }
                    }
                }
            }
        }
        $memberslist = array();
        $is_first_project = 0;
        if ($postProject['Project']['members']) {
            $memberslist = array_unique($postProject['Project']['members']);
        } elseif (!$GLOBALS['project_count']) {
            $memberslist[] = SES_ID;
            $is_first_project = 1;
        }
        if ($this->params->data['Project'] && $postProject['Project']['validate'] == 1) {
            $findName = $this->Project->find('first', array('conditions' => array('Project.name' => $postProject['Project']['name'], 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
            if ($findName) {
                if ($this->request->is('ajax')) {
                    echo json_encode(array('status'=>0,'msg'=>__('Project name', true).' '.$postProject['Project']['name'].' '.__('already exists', true)));
                    exit;
                } else {
                    $this->Session->write("ERROR", __("Project name", true)." '" . $postProject['Project']['name'] . "' ".__("already exists", true));
                    //$this->redirect(HTTP_ROOT . "projects/manage/".$projecturl);
                    if (empty($createProject)) {
                        $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }
            $findShrtName = $this->Project->find('first', array('conditions' => array('Project.short_name' => $postProject['Project']['short_name'], 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
            if ($findShrtName) {
                if ($this->request->is('ajax')) {
                    echo json_encode(array('status'=>0,'msg'=>__('Project short name', true).' '.$postProject['Project']['name'].' '.__('already exists', true)));
                    exit;
                } else {
                    $this->Session->write("ERROR", __("Project short name", true)." '" . $postProject['Project']['short_name'] . "' ".__("already exists", true));
                    //$this->redirect(HTTP_ROOT . "projects/manage/".$projecturl);
                    if (empty($createProject)) {
                        $this->redirect($_SERVER['HTTP_REFERER']);
                    }
                }
            }

            $postProject['Project']['uniq_id'] = trim($postProject['Project']['name']);
            $postProject['Project']['short_name'] = trim($postProject['Project']['short_name']);

            $prjUniqId = $this->Format->generateUniqNumber();
            $postProject['Project']['uniq_id'] = $prjUniqId;
            $postProject['Project']['user_id'] = SES_ID;
            $postProject['Project']['project_type'] = 1;
            if (isset($postProject['Project']['default_assign']) && !empty($postProject['Project']['default_assign'])) {
                $postProject['Project']['default_assign'] = $postProject['Project']['default_assign'];
            } else {
                $postProject['Project']['default_assign'] = SES_ID;
            }
            $postProject['Project']['isactive'] = 1;
            //PRB commented to fix the import task and project blank issue.
            //$postProject['Project']['name'] = htmlspecialchars(trim($postProject['Project']['name']), ENT_QUOTES);
            $postProject['Project']['name'] = strip_tags(trim($postProject['Project']['name']));
            $postProject['Project']['description'] = trim($postProject['Project']['description']);
            if (isset($postProject['Project']['status']) && !empty($postProject['Project']['status'])) {
                //$postProject['Project']['status'] = 1;
            } else {
                $postProject['Project']['status'] = 1;
            }
            $postProject['Project']['dt_created'] = GMT_DATETIME;
            $postProject['Project']['company_id'] = SES_COMP;
            if (isset($this->params->data['Project']['project_methodology'])) {
                $postProject['Project']['project_methodology_id'] = (!empty($_SESSION['projectmethodology']))?$_SESSION['projectmethodology']:$this->params->data['Project']['project_methodology'];
                if ($postProject['Project']['project_methodology_id'] == 2) {
                    $stortyp_id = $this->TypeCompany->getStoryId(SES_COMP, 'epic');
                    //to get epic
                    $postProject['Project']['task_type'] = $stortyp_id;
                }
            }
           
            if (!empty($postProject['Project']['status_group_id'])) {
                $postProject['Project']['status_group_id'] = $this->createAssociatedWorkFlow($postProject['Project']['status_group_id'], $postProject['Project']['short_name']);
            } else {
                $this->loadModel('StatusGroup');
                $stsg = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.is_default'=>1,'StatusGroup.company_id'=>0),'fields'=>array('StatusGroup.id'),'order'=>array('StatusGroup.id ASC'),'limit'=>1));
                $postProjectstatus_group_id = $stsg['StatusGroup']['id'];
                
                $postProject['Project']['status_group_id'] = $this->createAssociatedWorkFlow($postProjectstatus_group_id, $postProject['Project']['short_name']);
            }
            if (!empty($postProject['Project']['defect_status_group_id'])) {
                $postProject['Project']['defect_status_group_id'] = $this->createAssociatedWorkFlow($postProject['Project']['defect_status_group_id'], $postProject['Project']['short_name']);
            } else {
                $this->loadModel('StatusGroup');
                $stsg = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.is_default'=>1,'StatusGroup.company_id'=>0),'fields'=>array('StatusGroup.id'),'order'=>array('StatusGroup.id ASC'),'limit'=>1));
                $postProjectstatus_group_id = $stsg['StatusGroup']['id'];

                $postProject['Project']['status_group_id'] = $this->createAssociatedWorkFlow($postProjectstatus_group_id, $postProject['Project']['short_name']);
            }
            if ($this->Project->saveAll($postProject)) {
                $prjid = $this->Project->getLastInsertID();
                    
                //Save customer detail
                $is_new_clnt = 0;
                $p_customer_id = 0;
                if (isset($this->request->data['ProjectMeta']) && empty($this->request->data['ProjectMeta']['client']) && !empty($this->request->data['InvoiceCustomer']['cust_fname'])) {
                    $p_customer_id = $this->addCustomer($prjid, $this->params->data);
                    $is_new_clnt = 1;
                }
                //save project meta
                if (isset($this->request->data['ProjectMeta'])) {
                    $postMeta['ProjectMeta'] = $this->request->data['ProjectMeta'];
                    if ($is_new_clnt) {
                        $postMeta['ProjectMeta']['client'] = $p_customer_id;
                    }
                    $postMeta['ProjectMeta']['company_id'] = SES_COMP;
                    $postMeta['ProjectMeta']['project_id'] = $prjid;
                    $postMeta['ProjectMeta']['created'] = GMT_DATETIME;
                    $postMeta['ProjectMeta']['modified'] = GMT_DATETIME;
                    $this->loadModel('ProjectMeta');
                    $this->ProjectMeta->saveAll($postMeta);
                }
                    
                if (isset($_COOKIE['FIRST_INVITE_2']) && !empty($_COOKIE['FIRST_INVITE_2'])) {
                    $userlist_t = $userscls->find('first', array('conditions' => array('User.id' => SES_ID), 'fields' => array('User.id','User.phone','User.timezone_id')));
                    $countrycod = 'USD';
                    if (empty($userlist_t['User']['phone']) && $userlist_t['User']['timezone_id'] == '49') {
                        //$countrycod = $this->getCntryCod();
                        $countrycod = 'INR';
                        setcookie('FIRST_INVITE_2_CNTR', $countrycod, time() + 7200, '/', DOMAIN_COOKIE, false, false);
                    }
                }
                if (isset($_COOKIE['from_ref_page'])) {
                    setcookie('from_ref_page', '', -1, '/', DOMAIN_COOKIE, false, false);
                }
                if (isset($this->params->data['Project']['project_methodology'])) {
                    unset($_SESSION['projectmethodology']);
                }
                /* Pushnotification for creating a project starts here */
                            
                if (is_array($postProject['Project']['members']) && count($postProject['Project']['members']) > 0) {
                    $projectMemberUser = $postProject['Project']['members'];
                    $projectTitle = $postProject['Project']['name'];
                        
                    $messageToSend = "A new project with title '".$projectTitle."' is created and you are added to this project.";
                    $this->Pushnotification->sendPushNotificationToDevicesIOS($projectMemberUser, $messageToSend);
                    $this->Pushnotification->sendPushNotiToAndroid($projectMemberUser, $messageToSend);
                }
                
                /* Pushnotification for creating a project end here */
                
                $prjid = $this->Project->getLastInsertID();
                if (!stristr(HTTP_ROOT, 'payzilla.in')) {
                    //Code to save the event tracking to lead tracker
                    $sessionReferName = $this->params->data['Project']['click_referer'];
                    $sessionEventName = "Create Project";
                    $this->Format->SaveEventTrackUsingCURL($sessionEventName, $sessionReferName, SES_ID);
                }
                //Creating default template tasks if template is selected
                $new_case = array();
                if (isset($this->params->data['new_template']) && !empty($this->params->data['new_template'])) {
                    $tmpl_id = $this->params->data['new_template'];
                    /* insert Taskgroup  from Project template taskgroup table **/
                    $this->loadModel('ProjectTemplateTaskgroup');
                    $this->loadModel('Milestone');
                    $this->loadModel('EasycaseMilestone');
                    $this->loadModel('Type');
                    $this->loadModel('TypeCompany');
                    $tgs = $this->ProjectTemplateTaskgroup->find('all', array('conditions' => array('ProjectTemplateTaskgroup.template_id' => $tmpl_id, 'ProjectTemplateTaskgroup.company_id' => SES_COMP)));
                    $milestone_map = array();
                    foreach ($tgs as $k => $tg) {
                        // $checkDuplicate = $this->Milestone->query("SELECT Milestone.id FROM milestones AS Milestone WHERE Milestone.title='" . addslashes($tg['ProjectTemplateTaskgroup']['title']) . "' AND Milestone.project_id='" . $prjid . "'");
                        // if (isset($checkDuplicate[0]['Milestone']['id']) && $checkDuplicate[0]['Milestone']['id']) {
                        //       $milestone_map[$tg['ProjectTemplateTaskgroup']['id']] = $checkDuplicate[0]['Milestone']['id'];
                        // }else{
                        $new_tg['Milestone']['uniq_id'] = md5(uniqid());
                        $new_tg['Milestone']['project_id'] = $prjid;
                        $new_tg['Milestone']['company_id'] = SES_COMP;
                        $new_tg['Milestone']['title'] = $tg['ProjectTemplateTaskgroup']['title'];
                        $new_tg['Milestone']['description'] = $tg['ProjectTemplateTaskgroup']['description'];
                        $new_tg['Milestone']['user_id'] = SES_ID;
                        $new_tg['Milestone']['estimated_hours'] = ($tg['ProjectTemplateTaskgroup']['estimated_hr'])?$tg['ProjectTemplateTaskgroup']['estimated_hr']:0;
                        $new_tg['Milestone']['start_date'] = '0000-00-00';
                        $new_tg['Milestone']['end_date'] = '0000-00-00';
                        $new_tg['Milestone']['isactive'] = 1;
                        $new_tg['Milestone']['id_seq'] = $tg['ProjectTemplateTaskgroup']['sort'];
                        $this->Milestone->create();
                        $this->Milestone->save($new_tg);
                        $milestone_map[$tg['ProjectTemplateTaskgroup']['id']] = $this->Milestone->id;
                        //}
                    }
                    $this->loadModel('ProjectTemplateCase');
                    $tasks = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $tmpl_id, 'ProjectTemplateCase.company_id' => SES_COMP)));
                    #pr($tasks);exit;
                    $old_pt_ids = array();
                    $new_generated_ids = array();
                    foreach ($tasks as $k => $task) {
                        $assignTo = (in_array($task['ProjectTemplateCase']['assign_to'], $memberslist))?$task['ProjectTemplateCase']['assign_to']:0;
                        $new_case['CS_project_id'] = $prjUniqId;
                        $new_case['CS_istype'] = 1;
                        $new_case['CS_title'] = $task['ProjectTemplateCase']['title'];
                        /* Check the task type is in this project */
                        if ($task['ProjectTemplateCase']['task_type']) {
                            $typeInfo = $this->Type->find('first', array('conditions'=>array('Type.id'=>$task['ProjectTemplateCase']['task_type'])), false);
                            if ($typeInfo['Type']['project_id'] != 0) {
                                $dt = $this->Type->find('first', array('conditions'=>array('Type.project_id'=>$prjid, 'OR'=>array('Type.short_name'=>$typeInfo['Type']['short_name'],'Type.name'=>$typeInfo['Type']['name']))));
                                if (!empty($dt)) {
                                    $ttp_id = $dt['Type']['id'];
                                } else {
                                    $createType['id'] = '';
                                    $createType['company_id'] = SES_COMP;
                                    $createType['project_id'] = $prjid;
                                    $createType['short_name'] = $typeInfo['Type']['short_name'];
                                    $createType['name'] = $typeInfo['Type']['name'];
                                    $createType['seq_order'] = $typeInfo['Type']['seq_order'];
                                    $this->Type->create();
                                    $this->Type->save($createType);
                                    $ttp_id = $this->Type->getLastInsertId();
                                }
                                $isActive = $this->TypeCompany->find('count', array('conditions'=>array('TypeCompany.company_id'=>SES_COMP,'TypeCompany.type_id'=>$ttp_id)));
                                if (!$isActive) {
                                    $typeComp['company_id'] = SES_COMP;
                                    $typeComp['type_id'] = $ttp_id;
                                    $this->TypeCompany->create();
                                    $this->TypeCompany->save($typeComp);
                                }
                            } else {
                                $ttp_id = $case['Easycase']['type_id'];
                            }
                        } else {
                            $ttp_id = 2;
                        }
                        /* End */
                        $new_case['CS_type_id'] =  isset($ttp_id)?$ttp_id:2; //update
                        $new_case['CS_priority'] = $task['ProjectTemplateCase']['priority'];
                        $new_case['CS_message'] = $task['ProjectTemplateCase']['description'];
                        $new_case['CS_assign_to'] = $assignTo;
                        $new_case['story_point'] = ($task['ProjectTemplateCase']['story_point'])?$task['ProjectTemplateCase']['story_point']:0;
                        $new_case['CS_due_date'] = 'No Due Date';
                        $new_case['CS_id'] = 0;
                        $new_case['datatype'] = 0;
                        $new_case['CS_legend'] = 1;
                        $new_case['prelegend'] = '';
                        $new_case['hours'] = 0;
                        $new_case['estimated_hours'] = ($task['ProjectTemplateCase']['estimated'])?($task['ProjectTemplateCase']['estimated']/3600):0;
                        $new_case['completed'] = 0;
                        $new_case['taskid'] = 0;
                        $new_case['task_uid'] = 0;
                        $new_case['editRemovedFile'] = '';
                        $new_case['is_client'] = 0;
                        $ret = $this->Postcase->casePosting($new_case);
                        $objtask = json_decode($ret);

                        $old_pt_ids[$task['ProjectTemplateCase']['id']] =  $objtask->curCaseId;

                        if ($task['ProjectTemplateCase']['project_template_taskgroup_id'] != 0) {
                            $new_em['EasycaseMilestone']['project_id'] =  $prjid;
                            $new_em['EasycaseMilestone']['company_id'] =  SES_COMP;
                            $new_em['EasycaseMilestone']['user_id'] =  SES_ID;
                            $new_em['EasycaseMilestone']['easycase_id'] =   $objtask->curCaseId;
                            $new_em['EasycaseMilestone']['milestone_id'] =   $milestone_map[$task['ProjectTemplateCase']['project_template_taskgroup_id']];
                            $this->EasycaseMilestone->create();
                            $this->EasycaseMilestone->save($new_em);
                        }
                    }
                    //Save dependency
                    $this->Easycase->savePlanDependency($tasks, $old_pt_ids);
                    /* update the parent tasks */
                    $this->loadModel('Easycase');
                    foreach ($tasks as $k => $task) {
                        if ($task['ProjectTemplateCase']['parent_id']) {
                            $this->Easycase->create();
                            $this->Easycase->id = $old_pt_ids[$task['ProjectTemplateCase']['id']];
                            $this->Easycase->saveField('parent_task_id', $old_pt_ids[$task['ProjectTemplateCase']['parent_id']]);
                        }
                    }
                    /* End*/
                    /* update case files **/
                    $this->loadModel('ProjectTemplateCaseFile');
                    $this->loadModel('CaseFile');
                    $case_files = $this->ProjectTemplateCaseFile->find('all', array('conditions'=>array('ProjectTemplateCaseFile.template_id'=>$tmpl_id, 'ProjectTemplateCaseFile.company_id' => SES_COMP)));
                    foreach ($case_files as $k => $file) {
                        $this->CaseFile->create();
                        $new_files['CaseFile']['user_id'] = SES_ID;
                        $new_files['CaseFile']['company_id'] = SES_COMP;
                        $new_files['CaseFile']['project_id'] = $prjid;
                        $new_files['CaseFile']['easycase_id'] = $old_pt_ids[$file['ProjectTemplateCaseFile']['project_template_case_id']];
                        $new_files['CaseFile']['file'] = $file['ProjectTemplateCaseFile']['file'];
                        $new_files['CaseFile']['upload_name'] = $file['ProjectTemplateCaseFile']['upload_name'];
                        $new_files['CaseFile']['thumb'] = $file['ProjectTemplateCaseFile']['thumb'];
                        $new_files['CaseFile']['file_size'] = $file['ProjectTemplateCaseFile']['file_size'];
                        $new_files['CaseFile']['isactive'] = 1;
                        if ($old_pt_ids[$file['ProjectTemplateCaseFile']['project_template_case_id']]) {
                            if ($this->CaseFile->save($new_files)) {
                                $this->Easycase->id = $old_pt_ids[$file['ProjectTemplateCaseFile']['project_template_case_id']];
                                $this->Easycase->saveField('format', 1);
                            }
                        }
                    }
                    /* End */
                    //Insert One Record in Template module cases
                    $this->loadModel('TemplateModuleCase');
                    $tmpl_module_cases['TemplateModuleCase']['template_module_id'] = $tmpl_id;
                    $tmpl_module_cases['TemplateModuleCase']['user_id'] = SES_ID;
                    $tmpl_module_cases['TemplateModuleCase']['company_id'] = SES_COMP;
                    $tmpl_module_cases['TemplateModuleCase']['project_id'] = $prjid;
                    $this->TemplateModuleCase->save($tmpl_module_cases);
                }
                //Creating default task after first project created.
                $new_task = array();

                $this->User->recursive = -1;
                //$adminArr = $User->find("all",array('conditions'=>array('User.isactive'=>1,'User.istype'=>1),'fields'=>array('User.id')));

                $this->ProjectUser->recursive = -1;
                $getLastId = $this->ProjectUser->find('first', array('fields' => array('ProjectUser.id'), 'order' => array('ProjectUser.id DESC')));
                $lastid = $getLastId['ProjectUser']['id'] + 1;
//                $lastid = $getLastId[0][0]['maxid'] + 1;
                if (!empty($memberslist)) {
                    $ProjUsr = null;
                    foreach ($memberslist as $members) {
                        $ProjUsr['ProjectUser']['id'] = $lastid;
                        $ProjUsr['ProjectUser']['project_id'] = $prjid;
                        $ProjUsr['ProjectUser']['user_id'] = $members;
                        $ProjUsr['ProjectUser']['company_id'] = SES_COMP;
                        $ProjUsr['ProjectUser']['default_email'] = 1;
                        $ProjUsr['ProjectUser']['istype'] = 1;
                        $ProjUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                        $this->ProjectUser->saveAll($ProjUsr);
                        $lastid = $lastid + 1;
                        $_SESSION['project_increment_id'] = $lastid;
                        $_SESSION['puincrement_id'] = $lastid;
                        if ($this->Auth->user('id') != $members) {
                            $this->generateMsgAndSendPjMail($prjid, $members, $comp);
                        }
                    }
                    if (!stristr(HTTP_ROOT, 'payzilla.in')) {
                        //Code to save the event tracking to lead tracker
                        $sessionReferName = "During Project Creation";
                        $sessionEventName = "Add User to Project";
                        $this->Format->SaveEventTrackUsingCURL($sessionEventName, $sessionReferName, SES_ID);
                    }
                }
                //Adding resources to projectUser table
                $this->Project->resource_create_project($prjid, $resourceId);
                if (isset($postProject['Project']['module_id']) && isset($prjid) && $postProject['Project']['module_id']) {
                    //Add relation when template is added
                    $post_temp['TemplateModuleCase']['template_module_id'] = $postProject['Project']['module_id'];
                    $post_temp['TemplateModuleCase']['user_id'] = SES_ID;
                    $post_temp['TemplateModuleCase']['company_id'] = SES_COMP;
                    $post_temp['TemplateModuleCase']['project_id'] = $prjid;
                    $s = ClassRegistry::init('TemplateModuleCase')->save($post_temp);

                    $this->loadModel("ProjectTemplateCase");
                    $pjtemp = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $postProject['Project']['module_id']), 'order' => 'ProjectTemplateCase.sort ASC'));

                    $this->Easycase->recursive = -1;
                    $CaseActivity = ClassRegistry::init('CaseActivity');
                    foreach ($pjtemp as $temp) {
                        $postCases['Easycase']['uniq_id'] = $this->Format->generateUniqNumber();
                        $postCases['Easycase']['project_id'] = $prjid;
                        $postCases['Easycase']['user_id'] = SES_ID;
                        $postCases['Easycase']['type_id'] = 2;
                        $postCases['Easycase']['priority'] = 1;
                        $postCases['Easycase']['title'] = $temp['ProjectTemplateCase']['title'];
                        $postCases['Easycase']['message'] = $temp['ProjectTemplateCase']['description'];
                        $postCases['Easycase']['assign_to'] = SES_ID;
                        $postCases['Easycase']['due_date'] = "";
                        $postCases['Easycase']['istype'] = 1;
                        $postCases['Easycase']['format'] = 2;
                        $postCases['Easycase']['status'] = 1;
                        $postCases['Easycase']['legend'] = 1;
                        $postCases['Easycase']['isactive'] = 1;
                        $postCases['Easycase']['dt_created'] = GMT_DATETIME;
                        $postCases['Easycase']['actual_dt_created'] = GMT_DATETIME;
                        $caseNoArr = $this->Easycase->find('first', array('conditions' => array('Easycase.project_id' => $prjid), 'fields' => array('MAX(Easycase.case_no) as caseno')));
                        $caseNo = $caseNoArr[0]['caseno'] + 1;
                        $postCases['Easycase']['case_no'] = $caseNo;
                        if ($this->Easycase->saveAll($postCases)) {
                            $caseid = $this->Easycase->getLastInsertID();
                            /**
                            check the user availability
                            */
                            if ($postCases['Easycase']['estimated_hours'] != '' && $postCases['Easycase']['gantt_start_date'] != '' && $postCases['Easycase']['assign_to'] != 0) {
                                $isAssignedUserFree = $this->Postcase->setBookedData($postCases, $postCases['Easycase']['estimated_hours'], $caseid, SES_COMP);
                                if ($isAssignedUserFree != 1) {
                                    $overloadDataArr = array(
                                            'assignTo' => $postCases['Easycase']['assign_to'],
                                            'caseId' => $caseid,
                                            'caseUniqId' => $postCases['Easycase']['uniq_id'],
                                            'est_hr' => $postCases['Easycase']['estimated_hours'] / 3600,
                                            'projectId' => $postCases['Easycase']['project_id'],
                                            'str_date' => $postCases['Easycase']['gantt_start_date']
                                        );
                                    $response = $this->Format->overloadUsers($overloadDataArr);
                                }
                            }
                            //End



                            $CaseActivity->recursive = -1;
                            $CaseAct['easycase_id'] = $caseid;
                            $CaseAct['user_id'] = SES_ID;
                            $CaseAct['project_id'] = $prjid;
                            $CaseAct['case_no'] = $caseNo;
                            $CaseAct['type'] = 1;
                            $CaseAct['dt_created'] = GMT_DATETIME;
                            $CaseActivity->saveAll($CaseAct);
                        }
                    }
                }
                //New onboarding task create in first project
                if (!$GLOBALS['project_count']) {
                    $DumyTask = Configure::read('DEFAULT_TASK_DTL');
                    $easycase_mod = ClassRegistry::init('Easycase');
                    $easycase_mod_ret = $easycase_mod->addOnlyDummyTask($prjid, SES_COMP, SES_ID, $DumyTask);
                    if ($postProject['Project']['project_methodology_id'] == 2) {
                        setcookie('FIRST_INVITE_2', '0', time() - 60000, '/', DOMAIN_COOKIE, false, false);
                    } else {
                        setcookie('FIRST_INVITE_2', '1', time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                    }
                }
                if ($emailarr) {
                    $inviteduserlist = $this->Postcase->invitenewuser($emailarr, $prjid, $this);
                }
                /* Pushnotification for creating a project in slack */
                
                if (!$this->request->is('ajax')) {
                    $this->Session->write("SUCCESS", "'" . strip_tags($postProject['Project']['name']) . "' ".__("created successfully.", true));
                }

                if ($_COOKIE['FIRST_LOGIN_1']) {
                    setcookie('FIRST_LOGIN_1', '', -1, '/', DOMAIN_COOKIE, false, false);
                }
                
                setcookie('LAST_CREATED_PROJ', $prjid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                $CompanyUser = ClassRegistry::init('CompanyUser');
                $checkMem = $CompanyUser->find('all', array('conditions' => array('CompanyUser.company_id' => SES_COMP, 'CompanyUser.is_active' => 1)));
                if (isset($checkMem['CompanyUser']['id']) && $checkMem['CompanyUser']['id']) {
                    //					$ProjectUser = ClassRegistry::init("ProjectUser");
                    //					$checkProjusr = $ProjectUser->find('first',array('conditions'=>array('ProjectUser.project_id'=>$prjid,'ProjectUser.user_id !='=>SES_ID)));
//
                    //					if(isset($checkProjusr['ProjectUser']['id']) && $checkProjusr['ProjectUser']['id']) {
                    //						//setcookie('CREATE_CASE',1,time()+3600,'/',DOMAIN_COOKIE,false,false);
                    //						$this->redirect(HTTP_ROOT."dashboard");
                    //					}
                    //					else {
                    if (count($memberslist) < count($checkMem)) {
                        setcookie('LAST_PROJ', $prjid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                        setcookie('LAST_PROJ_UID', $prjUniqId, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                    }
                    setcookie('ASSIGN_USER', $prjid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                    setcookie('PROJ_NAME', trim($postProject['Project']['name']), time() + 3600, '/', DOMAIN_COOKIE, false, false);

                    //$this->redirect(HTTP_ROOT . "projects/manage".$projecturl);
                    if (empty($createProject)) {
                        if ($this->request->is('ajax')) {
                            echo json_encode(array('status'=>1,'msg'=>__('Project created successfully.', true),'proj_id'=>$prjid));
                            exit;
                        } else {
                            if (strpos($_SERVER['HTTP_REFERER'], 'getting_started') !== false) {
                                $this->redirect($_SERVER['HTTP_REFERER']);
                            } elseif (strpos($_SERVER['HTTP_REFERER'], 'onBoard') !== false) {
                                setcookie('FIRST_PROJECT_1', $prjid, time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                                $this->redirect(HTTP_ROOT . "users/onBoardInvites");
                            } else {
                                if (stristr($project_redirect_url, "projects/manage")) {
                                    $this->redirect(HTTP_ROOT . "projects/manage/");
                                } else {
                                    $this->redirect($project_redirect_url);
                                }
                            }
                        }
                    }
                } else {
                    //setcookie('INVITE_USER',1,time()+3600,'/',DOMAIN_COOKIE,false,false);
                    //$this->redirect(HTTP_ROOT."dashboard");
                    if ($GLOBALS['project_count'] >= 1) {
                        if (count($memberslist) < count($checkMem)) {
                            setcookie('LAST_PROJ', $prjid, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                            setcookie('LAST_PROJ_UID', $prjUniqId, time() + 3600, '/', DOMAIN_COOKIE, false, false);
                        }
                        //$this->redirect(HTTP_ROOT . "projects/manage".$projecturl);
                        if (empty($createProject)) {
                            if ($this->request->is('ajax')) {
                                echo json_encode(array('status'=>1,'msg'=>__('Project created successfully.', true),'proj_id'=>$prjid));
                                exit;
                            } else {
                                if (strpos($_SERVER['HTTP_REFERER'], 'getting_started') !== false) {
                                    $this->redirect($_SERVER['HTTP_REFERER']);
                                } elseif (strpos($_SERVER['HTTP_REFERER'], 'onBoard') !== false) {
                                    setcookie('FIRST_PROJECT_1', $prjid, time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                                    $this->redirect(HTTP_ROOT . "users/onBoardInvites");
                                } else {
                                    if (stristr($project_redirect_url, "projects/manage")) {
                                        $this->redirect(HTTP_ROOT . "projects/manage/");
                                    } else {
                                        $this->redirect($project_redirect_url);
                                    }
                                }
                            }
                        }
                    } else {
                        if (!isset($_COOKIE['TASKGROUPBY_DBDT'])) {
                            //setcookie('TASKGROUPBY_DBD', 'active', COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
                            //setcookie('TASKGROUPBY_DBDT', 'active', COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
                            //$op = fopen('ckckc.txt','a');
                            //fwrite($op,print_r($_COOKIE,true));
                        } else {
                            setcookie('TASKGROUPBY_DBD', 'active', time() - 3600, '/', DOMAIN_COOKIE, false, false);
                            setcookie('TASKGROUPBY_DBDT', 'active', time() - 3600, '/', DOMAIN_COOKIE, false, false);
                        }
                        //$this->redirect(HTTP_ROOT . 'onbording');
                        //above commented for default redirect to task group page after first project created
                        if (empty($createProject)) {
                            if ($this->request->is('ajax')) {
                                echo json_encode(array('status'=>1,'msg'=>__('Project created successfully.', true),'proj_id'=>$prjid));
                                exit;
                            } else {
                                if (strpos($_SERVER['HTTP_REFERER'], 'getting_started') !== false) {
                                    $this->redirect($_SERVER['HTTP_REFERER']);
                                } elseif (strpos($_SERVER['HTTP_REFERER'], 'onBoard') !== false) {
                                    setcookie('FIRST_PROJECT_1', $prjid, time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
                                    $this->redirect(HTTP_ROOT . "users/onBoardInvites");
                                } else {
                                    if (stristr($project_redirect_url, "projects/manage")) {
                                        $this->redirect(HTTP_ROOT . "projects/manage/");
                                    } else {
                                        $this->redirect($project_redirect_url);
                                    }
                                }
                            }
                        }
                    }
                }
                //setcookie('NEW_PROJECT',$prjid,time()+3600,'/',DOMAIN_COOKIE,false,false);
                if (!empty($createProject)) {
                    return $prjid;
                }
            }
        } else {
            $this->Session->write("ERROR", __("Error creating project", true));
            $this->redirect(HTTP_ROOT . "projects/manage" . $projecturl);
        }
    }

    public function check_proj_short_name()
    {
        $this->layout = 'ajax';
        //ob_clean();
        if (isset($this->params->data['shortname']) && trim($this->params->data['shortname'])) {
            $count = $this->Project->find("count", array("conditions" => array('Project.short_name' => trim(strtoupper($this->params->data['shortname'])), 'Project.company_id' => SES_COMP), 'fields' => 'DISTINCT Project.id'));
            $this->set('count', $count);
            $this->set('shortname', trim(strtoupper($this->params->data['shortname'])));
        }
    }

    public function assign()
    {
        if (isset($this->request->data['ProjectUser']['project_id'])) {
            $projectid = $this->request->data['ProjectUser']['project_id'];
            $lists1 = $this->request->data['ProjectUser']['mem_avl'] . ",";
            $lis1 = explode(",", $lists1);
            $lists2 = $this->request->data['ProjectUser']['mem_ext'];
            $lis2 = explode(",", $lists2);

            $lis1 = array_filter($lis1);
            $lis2 = array_filter($lis2);

            $this->ProjectUser->recursive = -1;
            $getLastId = $this->ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
            $lastid = $getLastId[0][0]['maxid'];

            $query = "";

            $this->Easycase->recursive = -1;
            $getcaseIds = $this->Easycase->find("all", array('conditions', array('Easycase.project_id' => $projectid, 'Easycase.istype' => 1), 'fields' => array('Easycase.id')));

            $CaseUserEmail = ClassRegistry::init('CaseUserEmail');
            $CaseUserEmail->recursive = -1;
            if (count($lis1)) {
                foreach ($lis1 as $ids1) {
                    $checkAvlMem1 = $this->ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => $ids1, 'ProjectUser.project_id' => $projectid), 'fields' => 'DISTINCT ProjectUser.id'));
                    if ($checkAvlMem1) {
                        $this->ProjectUser->query("DELETE FROM project_users WHERE user_id=" . $ids1 . " AND project_id=" . $projectid);

                        if (count($getcaseIds)) {
                            foreach ($getcaseIds as $getid) {
                                if ($getid['Easycase']['id']) {
                                    $CaseUserEmail->query("UPDATE case_user_emails SET ismail='0' WHERE user_id=" . $ids1 . " AND easycase_id=" . $getid['Easycase']['id']);
                                }
                            }
                        }
                    }
                }
            }
            if (count($lis2)) {
                foreach ($lis2 as $ids2) {
                    $checkAvlMem2 = $this->ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => $ids2, 'ProjectUser.project_id' => $projectid), 'fields' => 'DISTINCT id'));
                    if ($checkAvlMem2 == 0) {
                        $lastid++;
                        $this->ProjectUser->query("INSERT INTO project_users SET id='" . $lastid . "',user_id=" . $ids2 . ",project_id=" . $projectid . ",company_id='" . SES_COMP . "',dt_visited='" . GMT_DATETIME . "'");

                        if (count($getcaseIds)) {
                            foreach ($getcaseIds as $getid) {
                                if ($getid['Easycase']['id']) {
                                    $CaseUserEmail->query("UPDATE case_user_emails SET ismail='1' WHERE user_id=" . $ids2 . " AND easycase_id=" . $getid['Easycase']['id']);
                                }
                            }
                        }
                    }
                }
            }

            $prjid = $this->request->data['ProjectUser']['project_id'];
            $getProj = $this->Project->find('first', array('conditions' => array('Project.isactive' => 1, 'Project.id' => $prjid), 'fields' => array('Project.uniq_id', 'Project.name')));

            $this->Session->write("SUCCESS", __("User(s) successfully assigned to")." '" . $getProj['Project']['name'] . "'");
            $this->redirect(HTTP_ROOT . "projects/assign/?pid=" . $getProj['Project']['uniq_id']);
        }

        $pid = null;
        $projId = null;
        $memsAvlArr = array();
        $custAvlArr = array();
        $memsExtArr = array();
        $custExtArr = array();
        $this->Project->recursive = -1;
        $projArr = $this->Project->find('all', array('conditions' => array('Project.isactive' => 1, 'Project.name !=' => '', 'Project.company_id' => SES_COMP), 'fields' => array('DISTINCT Project.uniq_id,Project.name')));

        if (isset($_GET['pid']) && $_GET['pid']) {
            $pid = $_GET['pid'];

            $getProj = $this->Project->find('first', array('conditions' => array('Project.isactive' => 1, 'Project.uniq_id' => $pid, 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
            if (count($getProj['Project'])) {
                $projId = $getProj['Project']['id'];

                //$ProjectUser->unbindModel(array('belongsTo' => array('Project')));
                if (SES_TYPE == 1) {
                    $memsAvlArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser WHERE User.id = CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND User.isactive='1' AND User.name!='' AND NOT EXISTS(SELECT ProjectUser.user_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND ProjectUser.project_id=" . $projId . ") ORDER BY User.istype ASC,User.name");
                    $memsExtArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser,project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND User.id = CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND User.isactive='1' AND User.name!='' AND ProjectUser.project_id=" . $projId . " ORDER BY User.istype ASC,User.name");
                } else {
                    $memsAvlArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser WHERE User.id = CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.user_type!='1' AND User.isactive='1' AND User.name!=''  AND NOT EXISTS(SELECT ProjectUser.user_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND ProjectUser.project_id=" . $projId . ") ORDER BY User.istype ASC,User.name");
                    $memsExtArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser,project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND User.id = CompanyUser.user_id AND CompanyUser.user_type!='1' AND CompanyUser.company_id='" . SES_COMP . "' AND User.isactive='1' AND User.name!='' AND ProjectUser.project_id=" . $projId . " ORDER BY User.istype ASC,User.name");
                }
            }
        }
        $this->set('projArr', $projArr);
        $this->set('memsAvlArr', $memsAvlArr);
        //$this->set('custAvlArr',$custAvlArr);
        $this->set('memsExtArr', $memsExtArr);
        //$this->set('custExtArr',$custExtArr);
        $this->set('pid', $pid);
        $this->set('projId', $projId);
    }

    public function gridview($projtype = null)
    {
        //$this->redirect(HTTP_ROOT.'projects/manage/');exit;
        $page_limit = 15;
        $this->Project->recursive = -1;
        $pjid = null;
        if (isset($_GET['id']) && $_GET['id']) {
            $pjid = $_GET['id'];
        }
        if (isset($_GET['proj_srch']) && $_GET['proj_srch']) {
            $pjname = htmlentities(strip_tags($_GET['proj_srch']));
            $this->set('prjsrch', 'project search');
        }
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        if (trim($pjid)) {
            $project = "Project";
            $getProj = $this->Project->find('first', array('conditions' => array('Project.id' => $pjid, 'Project.company_id' => SES_COMP), 'fields' => array('Project.name', 'Project.id')));
            if (isset($getProj['Project']['name']) && $getProj['Project']['name']) {
                $project = $getProj['Project']['name'];
            }
            if ($getProj['Project']['id']) {
                if (isset($_GET['status_change']) && !empty($_GET['status_change'])) {
                    $this->Project->query("UPDATE projects SET 	dt_updated ='" . GMT_DATETIME . "', status=".$_GET['status_change']." WHERE id=" . $getProj['Project']['id']);
                    $this->Session->write("SUCCESS", "'" . $project . "' status changed");
                    $redirect = HTTP_ROOT . "projects/manage/";
                    if (isset($_GET['view']) && $_GET['view'] == 'inactive-grid') {
                        // $redirect = HTTP_ROOT . "projects/manage/inactive-grid/";
                    }
                    if (isset($_GET['pg']) && (intval($_GET['pg']) > 1)) {
                        //$redirect = HTTP_ROOT . "projects/manage/inactive/?page=" . $_GET['pg'];
                    }
                    $this->redirect(HTTP_ROOT . "projects/" . isset($_GET['req_uri']) ? $_GET['req_uri'] : 'manage/');
                }
                if (isset($_GET['action']) && $_GET['action'] == "activate") {
                    $this->Project->query("UPDATE projects SET 	dt_updated ='" . GMT_DATETIME . "',isactive='1', status='1' WHERE id=" . $getProj['Project']['id']);
                    $this->Session->write("SUCCESS", "'" . $project . "' marked as not complete");
                    $redirect = HTTP_ROOT . "projects/manage/";
                    if (isset($_GET['view']) && $_GET['view'] == 'inactive-grid') {
                        $redirect = HTTP_ROOT . "projects/manage/inactive-grid/";
                    }
                    if (isset($_GET['pg']) && (intval($_GET['pg']) > 1)) {
                        $redirect = HTTP_ROOT . "projects/manage/inactive/?page=" . $_GET['pg'];
                    }
                    $this->redirect(HTTP_ROOT . "projects/".isset($_GET['req_uri'])?$_GET['req_uri']:'manage/');
                }
                if (isset($_GET['action']) && $_GET['action'] == "delete") {
                    $this->Project->query("DELETE FROM projects WHERE id=" . $getProj['Project']['id']);

                    $this->ProjectUser->recursive = -1;
                    $this->ProjectUser->query("DELETE FROM project_users WHERE project_id=" . $getProj['Project']['id']);

                    $this->Session->write("SUCCESS", "'" . $project . "' deleted successfully");
                    $this->redirect(HTTP_ROOT . "projects/".isset($_GET['req_uri'])?$_GET['req_uri']:'manage/');
                }
                if (isset($_GET['action']) && $_GET['action'] == "deactivate") {
                    $redirect = HTTP_ROOT . "projects/manage/";
                    if (isset($_GET['pg']) && (intval($_GET['pg']) > 1)) {
                        $redirect = HTTP_ROOT . "projects/manage/?page=" . $_GET['pg'];
                    }
                    $this->Project->query("UPDATE projects SET dt_updated ='" . GMT_DATETIME . "',isactive='2', status='4' WHERE id=" . $getProj['Project']['id']);
                    /* Send Push Notification to devices if the project is completed starts here */
                            
                    $completeProjectId = $getProj['Project']['id'];
                    $getUserIds = $this->ProjectUser->query("SELECT * FROM `project_users` WHERE `project_id`='".$completeProjectId."'");
                    $emailUser = array();
                    if (is_array($getUserIds) && count($getUserIds) > 0) {
                        foreach ($getUserIds as $k=>$v) {
                            $emailUser[] = $v['project_users']['user_id'];
                        }
                    }
                            
                    $notifyAndAssignToMeUsers = $emailUser;
                    $prjTitle = $getProj['Project']['name'];
                    $notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
                            
                    $messageToSend = "Project '" . $prjTitle . "' ".__('is completed', true).".";
                    $this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
                    $this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);

                    /* Send Push Notification to devices if the project is completed ends here */
                    $this->Session->write("SUCCESS", "'" . $project . "' ".__("marked as complete", true));
                    $pg_no = '';
                    if (isset($_GET['page']) && $_GET['page']) {
                        $pg_no = '&page='.$_GET['page'];
                    }
                    $this->redirect(HTTP_ROOT . "projects/".isset($_GET['req_uri'])?$_GET['req_uri'].$pg_no:'manage/');
                }
            } else {
                $this->Session->write("ERROR", __("Invalid or Wrong action!", true));
                $this->redirect(HTTP_ROOT . "projects/gridview");
            }
        }

        $action = "";
        $uniqid = "";
        $query = "";
        if (isset($_GET['uniqid']) && $_GET['uniqid']) {
            $uniqid = $_GET['uniqid'];
        }
        if ($projtype == "disabled") {
            $query = "AND isactive='2'";
        } else {
            $query = "AND isactive='1'";
        }
        $query .= " AND company_id='" . SES_COMP . "'";
        if (isset($_GET['action']) && $_GET['action']) {
            $action = $_GET['action'];
        }
        $page = 1;
        $pageprev = 1;
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;

        $prjselect = $this->Project->query("SELECT name FROM projects AS Project WHERE name!='' " . $query . " ORDER BY name");
        $arrprj = array();
        foreach ($prjselect as $pjall) {
            if (isset($pjall['Project']['name']) && !empty($pjall['Project']['name'])) {
                array_push($arrprj, substr(trim($pjall['Project']['name']), 0, 1));
            }
        }
        if (isset($_GET['prj']) && $_GET['prj']) {
            //$_GET['prj'] = Sanitize::clean($_GET['prj'], array('encode' => false));
            $_GET['prj'] = chr($_GET['prj']);
            $pj = $_GET['prj'] . "%";
            $query .= " AND name LIKE '" . addslashes($pj) . "'";
        }

        if ($pjname) {
            $prjAllArr = $this->Project->query("SELECT SQL_CALC_FOUND_ROWS  id,uniq_id,name,user_id,project_type,priority,short_name,isactive,
                            (select count(easycases.id) as tot from easycases where easycases.project_id=Project.id and easycases.istype='1' and easycases.isactive='1') as totalcase,
                            (SELECT ROUND((SUM(TimeLog.total_hours)/3600),1) as hours FROM log_times as TimeLog WHERE TimeLog.project_id=Project.id) as totalhours,
                            (select count(company_users.id) as tot from company_users, project_users where project_users.user_id = company_users.user_id and project_users.company_id = company_users.company_id and company_users.is_active = 1 and project_users.project_id = Project.id) as totusers,
                            (SELECT SUM(case_files.file_size) AS file_size  FROM case_files   WHERE case_files.project_id=Project.id) AS storage_used 
                            FROM projects AS Project WHERE name!='' " . $query . " and name LIKE '%" . addslashes($pjname) . "%' ORDER BY name LIMIT $limit1,$limit2 ");
        } else {
            $prjAllArr = $this->Project->query("SELECT SQL_CALC_FOUND_ROWS id,uniq_id,name,user_id,project_type,priority,short_name,isactive,
                            (select count(easycases.id) as tot from easycases where easycases.project_id=Project.id and easycases.istype='1' and easycases.isactive='1') as totalcase,
                            (SELECT ROUND((SUM(TimeLog.total_hours)/3600),1) as hours FROM log_times as TimeLog WHERE TimeLog.project_id=Project.id) as totalhours,
                            (select count(company_users.id) as tot from company_users, project_users where project_users.user_id = company_users.user_id and project_users.company_id = company_users.company_id and company_users.is_active = 1 and project_users.project_id = Project.id) as totusers,
                            (SELECT SUM(case_files.file_size) AS file_size  FROM case_files   WHERE case_files.project_id=Project.id) AS storage_used 
                            FROM projects AS Project WHERE name!='' " . $query . " ORDER BY name LIMIT $limit1,$limit2");
        }

        $tot = $this->Project->query("SELECT FOUND_ROWS() as total");
        $CaseCount = $tot[0][0]['total'];
        $this->set('caseCount', $tot[0][0]['total']);

        $this->set(compact('data'));
        $this->set('total_records', $prjAllArr);
        $this->set('proj_srch', $pjname);
        $this->set('page_limit', $page_limit);
        $this->set('page', $page);
        $this->set('pageprev', $pageprev);
        $count_grid = count($prjAllArr);
        $this->set('count_grid', $count_grid);
        $this->set('prjAllArr', $prjAllArr);
        $this->set('projtype', $projtype);
        $this->set('action', $action);
        $this->set('uniqid', $uniqid);
        $this->set('arrprj', $arrprj);
        $this->set('page_limit', $page_limit);
        $this->set('casePage', $page);
    }
    public function projectMembers()
    {
        $this->layout = 'ajax';

        //Getting project id
        $project_id = '';
        if (isset($this->params->data['prj_id'])) {
            $project_id = $this->params->data['prj_id'];
        } else {
            $project = $this->Project->getProjectFields(array('Project.uniq_id' => $this->params->data['id']), array('id'));
            $project_id = $project['Project']['id'];
        }
        //Getting project members of correspoding project
        $projectuser = $this->Project->getProjectMembers($project_id);
        //time format for user
        $this->loadModel('User');
        $conditions = array('User.id' => SES_ID);
        $tm_format = $this->User->find('first', array('conditions' => $conditions,'fields'=>array('time_format')));

        // pr($tm_format);exit;
        $this->set('tm_format', $tm_format);
        //To whom sent an email
        $this->loadModel('DailyUpdate');
        $selecteduser = $this->DailyUpdate->getDailyUpdateFields($project_id);

        $this->loadModel('TimezoneName');
        $timezones = $this->TimezoneName->find('all');
        $this->set('timezones', $timezones);

        $this->set('projectuser', $projectuser);
        $this->set('selecteduser', $selecteduser);
    }

    public function dailyUpdate()
    {
        //Getting project id
        $project = $this->Project->getProjectFields(array('Project.uniq_id' => $this->data['Project']['uniq_id']), array('id'));
        if (empty($project)) {
            $project['Project']['id'] = $this->data['Project']['uniq_id'];
        }
        $usr = $this->data['Project']['user'];
        //Getting user ids
        $uids = '';
        foreach ($usr as $key => $value) {
            $user = $this->User->getUserFields(array('User.uniq_id' => $value), array('id'));
            $uids.="," . $user['User']['id'];
        }

        //Making an array to insert or update
        $data['company_id'] = SES_COMP;
        $data['project_id'] = $project['Project']['id'];
        $data['post_by'] = SES_ID;
        $data['user_id'] = ltrim($uids, ",");
        $data['timezone_id'] = $this->data['Project']['timezone_id'];
        if ($this->data['Project']['am'] == "AM" || $this->data['Project']['am'] == "PM") {
            $hr = $this->data['Project']['hour'];
            $tm = $this->data['Project']['am'];
            $time_in_24_hour_format  = date("H", strtotime("$hr $tm"));
          
            //pr($time_in_24_hour_format);exit;
            $data['notification_time'] = trim($time_in_24_hour_format) . ":" . trim($this->data['Project']['minute']);
        } else {
            $data['notification_time'] = trim($this->data['Project']['hour']) . ":" . trim($this->data['Project']['minute']);
        }
        // pr($data['notification_time']);exit;
        $data['days'] = $this->data['Project']['days'];

        //Check if insert or update
        $this->loadModel('DailyUpdate');
        $selecteduser = $this->DailyUpdate->getDailyUpdateFields($project['Project']['id']);
        if (isset($selecteduser['DailyUpdate']) && !empty($selecteduser['DailyUpdate'])) {
            $this->DailyUpdate->id = $selecteduser['DailyUpdate']['id'];
        }

        //Save or update records
        if ($this->DailyUpdate->save($data)) {
            $this->Session->write("SUCCESS", __("Daily Catch-Up has been saved successfully.", true));
        } else {
            $this->Session->write("ERROR", __("Failed to save of Daily Catch-Up.", true));
        }

        $this->redirect(HTTP_ROOT . "projects/groupupdatealerts");
    }

    public function cancelDailyUpdate()
    {
        if (intval($this->params['pass'][0])) {
            $this->loadModel('DailyUpdate');
            if ($this->DailyUpdate->delete($this->params['pass'][0])) {
                $this->Session->write("SUCCESS", __("Daily Catch-Up has been cancelled successfully.", true));
            } else {
                $this->Session->write("ERROR", __("Failed to cancel Daily Catch-Up.", true));
            }
        } else {
            $this->Session->write("ERROR", __("Failed to cancel Daily Catch-Up.", true));
        }

        $this->redirect(HTTP_ROOT . "projects/groupupdatealerts");
    }

    public function user_listing()
    {
        $this->layout = 'ajax';
        $projId = trim($this->params->data['project_id']);
        if (isset($this->params->data['userid']) && $this->params->data['userid'] && isset($this->params->data['InvitedUser']) && trim($this->params->data['InvitedUser'])) {
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $UserInvitation->unbindModel(array('belongsTo' => array('Project')));
            $checkAvlInvMem = $UserInvitation->query("SELECT * FROM `user_invitations` WHERE find_in_set('" . $projId . "', `user_invitations`.project_id) > 0 AND `user_invitations`.is_active = '1' AND `user_invitations`.user_id = '" . $this->params->data['userid'] . "'");
            if ($checkAvlInvMem && !empty($checkAvlInvMem[0]['user_invitations']['project_id'])) {
                $pattern_array = array("/(,$projId,)/", "/(^$projId,)/", "/(,$projId$)/", "/(^$projId$)/");
                $replace_array = array(",", "", "", "");
                $mstr = preg_replace($pattern_array, $replace_array, $checkAvlInvMem[0]['user_invitations']['project_id']);
                $UserInvitation->query("UPDATE user_invitations SET project_id = '" . $mstr . "' where id = '" . $checkAvlInvMem[0]['user_invitations']['id'] . "'");
            }
            echo "updated";
            exit;
        }
        if (isset($this->params->data['userid']) && $this->params->data['userid']) {
            $uid = $this->params->data['userid'];
            $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));
            $checkAvlMem3 = $this->ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => $uid, 'ProjectUser.project_id' => $projId), 'fields' => 'DISTINCT ProjectUser.id'));
            if ($checkAvlMem3) {
                $this->ProjectUser->query("DELETE FROM project_users WHERE user_id=" . $uid . " AND project_id=" . $projId);
            }
            //Remove from Group update table , that user should not get mail when he is removed from a project.
            $this->loadModel('DailyUpdate');
            $DailyUpdate = $this->DailyUpdate->getDailyUpdateFields($projId, array('DailyUpdate.id', 'DailyUpdate.user_id'));
            if (isset($DailyUpdate) && !empty($DailyUpdate)) {
                $user_ids = explode(",", $DailyUpdate['DailyUpdate']['user_id']);
                if (($index = array_search($uid, $user_ids)) !== false) {
                    unset($user_ids[$index]);
                }
                $du['user_id'] = implode(",", $user_ids);
                $this->DailyUpdate->id = $DailyUpdate['DailyUpdate']['id'];
                $this->DailyUpdate->save($du);
            }
            echo "removed";
            exit;
        }

        $qry = '';
        if (isset($this->params->data['name']) && trim($this->params->data['name'])) {
            $name = trim($this->params->data['name']);
            $qry = " AND User.name LIKE '%$name%'";
        }

        $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $memsArr = $this->ProjectUser->query("SELECT DISTINCT User.*,CompanyUser.*,ProjectUser.* FROM users AS User,company_users AS CompanyUser,project_users AS ProjectUser WHERE User.id=CompanyUser.user_id AND User.id=ProjectUser.user_id AND ProjectUser.project_id='" . $projId . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active=1" . $qry . " ORDER BY User.name ASC");
        $memsExtArr['Member'] = $memsArr;

        $UserInvitation = ClassRegistry::init('UserInvitation');
        $memsUserInvArr = $UserInvitation->query("SELECT * FROM users AS User,user_invitations AS UserInvitation,company_users AS CompanyUser WHERE User.id=CompanyUser.user_id AND User.id=UserInvitation.user_id AND UserInvitation.company_id='" . SES_COMP . "' AND find_in_set('" . $projId . "', UserInvitation.project_id) > 0 AND UserInvitation.is_active = '1' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active=2" . $qry . " ORDER BY User.name ASC");
        $memsExtArr['Invited'] = $memsUserInvArr;

        $CompanyUser = ClassRegistry::init('CompanyUser');
        $memsUserDisArr = $CompanyUser->query("SELECT DISTINCT User.*,CompanyUser.*,ProjectUser.* FROM users AS User,company_users AS CompanyUser,project_users AS ProjectUser WHERE User.id=CompanyUser.user_id AND User.id=ProjectUser.user_id AND ProjectUser.project_id='" . $projId . "' AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active=0" . $qry . " ORDER BY User.name ASC");
        $memsExtArr['Disabled'] = $memsUserDisArr;

        $this->set('memsExtArr', $memsExtArr);
        $this->set('pjid', $projId);
    }
    
    public function removeUserOverview()
    {
        $this->layout = 'ajax';
        $arrJson = array('status'=>'ok');
        $projId = trim($this->params->data['project_id']);
        $uid = trim($this->params->data['userid']);
        
        if (isset($this->request->data['assign_to_user'])) {
            $detlProj = $this->Project->find('first', array('conditions' => array('Project.id' => $this->request->data['project_id'])));
            $detlUser = $this->User->find('first', array('conditions' => array('User.id' => $this->request->data['userid'])));
        } else {
            $detlProj = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $projId)));
            $detlUser = $this->User->find('first', array('conditions' => array('User.uniq_id' => $uid)));
        }
        if (empty($detlProj) || empty($detlUser)) {
            $arrJson['status'] = 'fail';
            echo json_encode($arrJson);
            exit;
        } else {
            $projId = $detlProj['Project']['id'];
            $uid = $detlUser['User']['id'];
        }
        
        if ($uid) {
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $UserInvitation->unbindModel(array('belongsTo' => array('Project')));
            $checkAvlInvMem = $UserInvitation->query("SELECT * FROM `user_invitations` WHERE find_in_set('" . $projId . "', `user_invitations`.project_id) > 0 AND `user_invitations`.is_active = '1' AND `user_invitations`.user_id = '" . $uid . "'");
            if ($checkAvlInvMem && !empty($checkAvlInvMem[0]['user_invitations']['project_id'])) {
                $pattern_array = array("/(,$projId,)/", "/(^$projId,)/", "/(,$projId$)/", "/(^$projId$)/");
                $replace_array = array(",", "", "", "");
                $mstr = preg_replace($pattern_array, $replace_array, $checkAvlInvMem[0]['user_invitations']['project_id']);
                $UserInvitation->query("UPDATE user_invitations SET project_id = '" . $mstr . "' where id = '" . $checkAvlInvMem[0]['user_invitations']['id'] . "'");
                echo json_encode($arrJson);
                exit;
            }
        }
        if ($uid) {
            $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));
            $checkAvlMem3 = $this->ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => $uid, 'ProjectUser.project_id' => $projId), 'fields' => 'DISTINCT ProjectUser.id'));
            if ($checkAvlMem3) {
                $this->ProjectUser->query("DELETE FROM project_users WHERE user_id=" . $uid . " AND project_id=" . $projId);
                //Assign user tasks to selected one or left unassigned
                if (isset($this->request->data['assign_to_user'])) {
                    $this->loadModel('Easycase');
                    $easycases = $this->Easycase->find('all', array('fields' => array('Easycase.id','Easycase.uniq_id','Easycase.project_id','Easycase.assign_to','Easycase.gantt_start_date','Easycase.due_date','Easycase.estimated_hours'),'order' => array('Easycase.id ASC'),'conditions' => array('Easycase.assign_to' => $uid, 'Easycase.istype' => 1, 'Easycase.project_id' => $projId, 'Easycase.legend !=' => 3)));
                    if (!empty($easycases)) {
                        $case_ids = Hash::extract($easycases, '{n}.Easycase.id');
                        $case_ids = implode(', ', $case_ids);
                        $this->Easycase->query("UPDATE easycases SET assign_to = ".$this->request->data['assign_to_user']." WHERE id IN(".$case_ids.")");
                        if (!empty($this->request->data['assign_to_user'])) {
                            foreach ($easycases as $key => $values) {
                                $RA = array();
                                $RA = array(
                                    'caseId' => $values['Easycase']['id'],
                                    'caseUniqId' => $values['Easycase']['uniq_id'],
                                    'projectId' => $values['Easycase']['project_id'],
                                    'assignTo' => $this->request->data['assign_to_user'],
                                    'str_date' => $values['Easycase']['gantt_start_date'],
                                    'CS_due_date' => $values['Easycase']['due_date'],
                                    'est_hr' => $values['Easycase']['estimated_hours']
                                );
                                if ($values['Easycase']['legend'] != 3 && $values['Easycase']['assign_to'] && ((!empty($RA['str_date']) && !empty($RA['est_hr']) && trim($RA['est_hr']) != '00:00' && trim($RA['est_hr']) != '0:00' && trim($RA['est_hr']) != '00:0' && trim($RA['est_hr']) != '0:0') || (!empty($RA['str_date']) && !empty($RA['CS_due_date'])))) {
                                    $RES = $this->Format->overloadUsersUpdted($RA);
                                }
                            }
                        } else {
                            foreach ($easycases as $key => $values) {
                                if ($this->Format->isResourceAvailabilityOn()) {
                                    $this->Format->delete_booked_hours(array('easycase_id' => $values['Easycase']['id'], 'project_id' => $values['Easycase']['project_id']), 1);
                                }
                            }
                        }
                        $arrJson['proj_id'] = $detlProj['Project']['uniq_id'];
                        $arrJson['user_id'] = $detlUser['User']['uniq_id'];
                    }
                }
            }
            //Remove from Group update table , that user should not get mail when he is removed from a project.
            $this->loadModel('DailyUpdate');
            $DailyUpdate = $this->DailyUpdate->getDailyUpdateFields($projId, array('DailyUpdate.id', 'DailyUpdate.user_id'));
            if (isset($DailyUpdate) && !empty($DailyUpdate)) {
                $user_ids = explode(",", $DailyUpdate['DailyUpdate']['user_id']);
                if (($index = array_search($uid, $user_ids)) !== false) {
                    unset($user_ids[$index]);
                }
                $du['user_id'] = implode(",", $user_ids);
                $this->DailyUpdate->id = $DailyUpdate['DailyUpdate']['id'];
                $this->DailyUpdate->save($du);
            }
            echo json_encode($arrJson);
            exit;
        }
    }
    

    public function add_user()
    {
        $this->layout = 'ajax';
        $projid = $this->params->data['pjid'];
        $pjname = urldecode($this->params->data['pjname']);
        $cntmng = $this->params->data['cntmng'];
        $selected_uids = trim($this->params->data['choosen_user_ids']);
        $query = "";
        if (isset($this->params->data['name']) && trim($this->params->data['name'])) {
            $srchstr = addslashes(trim($this->params->data['name']));
            $query = "AND User.name LIKE '%$srchstr%'";
        }

        $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));

        if (SES_TYPE == 1) {
            $memsNotExstArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser WHERE User.id = CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND User.isactive='1' AND User.name!='' " . $query . " AND NOT EXISTS(SELECT ProjectUser.user_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND ProjectUser.project_id=" . $projid . ") ORDER BY User.name");
            $memsExstArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser WHERE User.id = CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND User.isactive='1' AND User.name!='' AND EXISTS(SELECT ProjectUser.user_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND ProjectUser.project_id=" . $projid . ") ORDER BY User.name");
        } else {
            $memsNotExstArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser WHERE User.id = CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND User.isactive='1' AND User.name!='' " . $query . " AND NOT EXISTS(SELECT ProjectUser.user_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND ProjectUser.project_id=" . $projid . ") ORDER BY User.name");
            $memsExstArr = $this->ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type FROM users AS User, company_users AS CompanyUser WHERE User.id = CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND User.isactive='1' AND User.name!='' AND EXISTS(SELECT ProjectUser.user_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id=User.id AND ProjectUser.project_id=" . $projid . ") ORDER BY User.name");
        }

        if ($selected_uids != '') {
            $uids = explode(',', $selected_uids);
            $this->User->recursive = -1;
            $selected_users = $this->User->find('list', array('conditions' => array('User.id' => $uids), 'fields' => array('User.id', 'User.name')));
            if ($selected_users) {
                $this->set('selected_users', $selected_users);
            }
        }


        $this->set('pjname', $pjname);
        $this->set('projid', $projid);
        $this->set('memsNotExstArr', $memsNotExstArr);
        $this->set('memsExstArr', $memsExstArr);
        $this->set('cntmng', $cntmng);
    }

    public function assign_userall($data = null)
    {
        $this->layout = 'ajax';
        if ($data) {
            $userid = $data['userid'];
            $pjid = $data['pjid'];
        } else {
            $userid = $this->params->data['userid'];
            $pjid = $this->params->data['pjid'];
        }
        $Company = ClassRegistry::init('Company');
        $comp = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('Company.name')));

        $this->ProjectUser->recursive = -1;
        $getLastId = $this->ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
        $lastid = $getLastId[0][0]['maxid'];

        $this->Easycase->recursive = -1;

        $CaseUserEmail = ClassRegistry::init('CaseUserEmail');
        $CaseUserEmail->recursive = -1;

        //$getcaseIds = $Easycase->find("all",array('conditions', array('Easycase.project_id' => $pjid, 'Easycase.istype' => 1), 'fields' => array('Easycase.id')));
        if (count($userid)) {
            foreach ($userid as $id) {
                $checkAvlMem2 = $this->ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => $id, 'ProjectUser.project_id' => $pjid, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'DISTINCT id'));
                if ($checkAvlMem2 == 0) {
                    $lastid++;
                    $this->ProjectUser->query("INSERT INTO project_users SET id='" . $lastid . "',user_id=" . $id . ",project_id=" . $pjid . ",company_id=" . SES_COMP . ",dt_visited='" . GMT_DATETIME . "'");

                    /* if(count($getcaseIds))
                      {
                      foreach($getcaseIds as $getid)
                      {
                      if($getid['Easycase']['id']) {
                      $CaseUserEmail->query("UPDATE case_user_emails SET ismail='1' WHERE user_id=".$id." AND easycase_id=".$getid['Easycase']['id']);
                      }
                      }
                      } */
                }
            }
        }
        if (count($userid)) {
            $Company = ClassRegistry::init('Company');
            $comp = $Company->find('first', array('conditions' => array('Company.id' => SES_COMP), 'fields' => array('Company.name')));
            foreach ($userid as $id) {
                $this->generateMsgAndSendPjMail($pjid, $id, $comp);
            }
        }
        if ($data) {
            return true;
        } else {
            echo "success";
            exit;
        }
    }

    public function add_template()
    {
        //pr($this->request);exit;
        if (isset($this->request->data['ProjectTemplateCase']) && !empty($this->request->data['ProjectTemplateCase'])) {
            if (isset($this->request->data['submit_template']) && count($this->request->data['ProjectTemplateCase']['title'])) {
                $this->loadModel('ProjectTemplateCase');
                $arr = $this->request->data['ProjectTemplateCase']['title'];
                $count_arr = 0;
                foreach ($arr as $cs) {
                    if (isset($cs) && !empty($cs)) {
                        $temp_case['user_id'] = SES_ID;
                        $temp_case['company_id'] = SES_COMP;
                        $temp_case['template_id'] = $this->request->data['ProjectTemplateCase']['template_id'];
                        $temp_case['title'] = $cs;
                        $temp_case['description'] = $this->request->data['ProjectTemplateCase']['description'][$count_arr];
                        $this->ProjectTemplateCase->saveAll($temp_case);
                    }
                    $count_arr++;
                }
            }
            $this->Session->write("SUCCESS", __("Template tasks added successfully"));
            $this->redirect(HTTP_ROOT . "projects/manage_template/");
        }
        $this->loadModel('ProjectTemplate');
        $prj = $this->ProjectTemplate->find('all', array('conditions' => array('ProjectTemplate.company_id' => SES_COMP, 'ProjectTemplate.is_active' => 1), 'fields' => array('ProjectTemplate.id', 'ProjectTemplate.module_name')));
        $this->set('template_mod', $prj);
    }

    public function manage_template()
    {
        $this->loadModel("ProjectTemplate");
        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->ProjectTemplate->id = $_GET['id'];
            $this->ProjectTemplate->delete();
            ClassRegistry::init('ProjectTemplateCase')->query("Delete FROM project_template_cases WHERE template_id='" . $_GET['id'] . "'");
            $this->Session->write("SUCCESS", __("Template Deleted successfully", true));
            $this->redirect(HTTP_ROOT . "projects/manage_template/");
        } elseif (isset($this->request->query['act']) && $this->request->query['act']) {
            $v = urldecode(trim($this->request->query['act']));
            $this->ProjectTemplate->id = $v;
            if ($this->ProjectTemplate->saveField("is_active", 1)) {
                $this->Session->write("SUCCESS", __("Template activated successfully", true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            } else {
                $this->Session->write("ERROR", __("Template can't be activated.Please try again.", true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            }
        } elseif (isset($this->request->query['inact']) && $this->request->query['inact']) {
            $v = urldecode(trim($this->request->query['inact']));
            $this->ProjectTemplate->id = $v;
            if ($this->ProjectTemplate->saveField("is_active", 0)) {
                $this->Session->write("SUCCESS", __("Template deactivated successfully", true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            } else {
                $this->Session->write("ERROR", __("Template can't be deactivated.Please try again.", true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            }
        }

        $proj_temp = $this->ProjectTemplate->find('all', array('conditions' => array('ProjectTemplate.company_id' => SES_COMP)));
        $proj_temp_active = $this->ProjectTemplate->find('all', array('conditions' => array('ProjectTemplate.company_id' => SES_COMP, 'ProjectTemplate.is_active' => 1)));
        $this->set('proj_temp', $proj_temp);
        $this->set('proj_temp_active', $proj_temp_active);
    }

    public function ajax_add_template_module()
    {
        //print_r($this->params->data['title']);exit;
        $this->layout = 'ajax';
        $title = $this->params->data['title'];
        if (isset($this->params->data['title']) && !empty($this->params->data['title'])) {
            $this->loadModel('ProjectTemplate');
            $prj = $this->ProjectTemplate->find('count', array('conditions' => array('ProjectTemplate.module_name' => $this->params->data['title'], 'ProjectTemplate.company_id' => SES_COMP)));
            if ($prj == 0) {
                $this->request->data['ProjectTemplate']['user_id'] = SES_ID;
                $this->request->data['ProjectTemplate']['company_id'] = SES_COMP;
                $this->request->data['ProjectTemplate']['module_name'] = $this->params->data['title'];
                $this->request->data['ProjectTemplate']['is_default'] = 1;
                $this->request->data['ProjectTemplate']['is_active'] = 1;
                if ($this->ProjectTemplate->save($this->request->data)) {
                    $last_insert_id = $this->ProjectTemplate->getLastInsertId();
                    echo $title . "-" . $last_insert_id;
                } else {
                    echo "0";
                }
            } else {
                echo "0";
            }
        }
        exit;
    }

    public function ajax_add_template_cases()
    {
        $this->layout = 'ajax';
        //ob_clean();
        if (isset($this->params->data['pj_id']) && isset($this->params->data['temp_mod_id'])) {
            $this->loadModel('TemplateModuleCase');
            $prj = $this->TemplateModuleCase->find('count', array('conditions' => array('TemplateModuleCase.company_id' => SES_COMP, 'TemplateModuleCase.project_id' => $this->params->data['pj_id'])));
            if ($prj == 0) {
                $this->request->data['TemplateModuleCase']['template_module_id'] = $this->params->data['temp_mod_id'];
                $this->request->data['TemplateModuleCase']['user_id'] = SES_ID;
                $this->request->data['TemplateModuleCase']['company_id'] = SES_COMP;
                $this->request->data['TemplateModuleCase']['project_id'] = $this->params->data['pj_id'];
                if ($this->TemplateModuleCase->save($this->request->data)) {
                    $this->loadModel("ProjectTemplateCase");
                    $pjtemp = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $this->params->data['temp_mod_id'], 'ProjectTemplateCase.company_id' => SES_COMP)));
                    $this->Easycase->recursive = -1;
                    $CaseActivity = ClassRegistry::init('CaseActivity');
                    foreach ($pjtemp as $temp) {
                        $postCases['Easycase']['uniq_id'] = $this->Format->generateUniqNumber();
                        $postCases['Easycase']['project_id'] = $this->params->data['pj_id'];
                        $postCases['Easycase']['user_id'] = SES_ID;
                        $postCases['Easycase']['type_id'] = 2;
                        $postCases['Easycase']['priority'] = 1;
                        $postCases['Easycase']['title'] = $temp['ProjectTemplateCase']['title'];
                        $postCases['Easycase']['message'] = $temp['ProjectTemplateCase']['description'];
                        $postCases['Easycase']['assign_to'] = SES_ID;
                        $postCases['Easycase']['due_date'] = "";
                        $postCases['Easycase']['istype'] = 1;
                        $postCases['Easycase']['format'] = 2;
                        $postCases['Easycase']['status'] = 1;
                        $postCases['Easycase']['legend'] = 1;
                        $postCases['Easycase']['isactive'] = 1;
                        $postCases['Easycase']['dt_created'] = GMT_DATETIME;
                        $postCases['Easycase']['actual_dt_created'] = GMT_DATETIME;
                        $caseNoArr = $this->Easycase->find('first', array('conditions' => array('Easycase.project_id' => $this->params->data['pj_id']), 'fields' => array('MAX(Easycase.case_no) as caseno')));
                        $caseNo = $caseNoArr[0]['caseno'] + 1;
                        $postCases['Easycase']['case_no'] = $caseNo;
                        if ($this->Easycase->saveAll($postCases)) {
                            $caseid = $this->Easycase->getLastInsertID();
                            $CaseActivity->recursive = -1;
                            $CaseAct['easycase_id'] = $caseid;
                            $CaseAct['user_id'] = SES_ID;
                            $CaseAct['project_id'] = $this->params->data['pj_id'];
                            $CaseAct['case_no'] = $caseNo;
                            $CaseAct['type'] = 1;
                            $CaseAct['dt_created'] = GMT_DATETIME;
                            $CaseActivity->saveAll($CaseAct);
                        }
                    }
                    echo "1";
                    exit;
                }
            } else {
                echo "0";
                exit;
            }
        }
        exit;
    }

    public function ajax_view_template_cases()
    {
        $this->layout = 'ajax';
        $this->loadModel("ProjectTemplateCase");
        //$pjtemp = $this->ProjectTemplate->find('all', array('conditions'=> array('ProjectTemplate.template_id'=>$this->params->data['temp_id'],'ProjectTemplate.company_id'=>SES_COMP)));
        $pjtemp = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $this->params->data['temp_id'], 'ProjectTemplateCase.company_id' => SES_COMP)));
        $this->set('temp_dtls_cases', $pjtemp);
    }

    public function ajax_refresh_template_module()
    {
        $this->layout = 'ajax';
        $this->loadModel('ProjectTemplate');
        $prj = $this->ProjectTemplate->find('all', array('conditions' => array('ProjectTemplate.company_id' => SES_COMP, 'ProjectTemplate.is_active' => 1), 'fields' => array('ProjectTemplate.id', 'ProjectTemplate.module_name')));
        $this->set('template_mod', $prj);
        $this->set('tmp_id', $this->params->data['tmp_id']);
    }

    public function ajax_view_temp_cases()
    {
        $this->layout = 'ajax';
        $pjtemp = ClassRegistry::init('ProjectTemplateCase')->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $this->params->data['template_id']), 'fields' => array('ProjectTemplateCase.title', 'ProjectTemplateCase.description', 'ProjectTemplateCase.created')));
        $this->loadModel('ProjectTemplate');
        $tmpmod = ClassRegistry::init('ProjectTemplate')->find('first', array('conditions' => array('ProjectTemplate.id' => $this->params->data['template_id']), 'fields' => array('ProjectTemplate.module_name')));
        $this->set('mod_name', $tmpmod['ProjectTemplate']['module_name']);
        $this->set('temp_dtls_cases', $pjtemp);
    }

    public function ajax_new_project()
    {
        $this->layout = 'ajax';
        //$this->loadModel('TemplateModule');
        //$modlist = ClassRegistry::init('ProjectTemplate')->find('all',array('conditions'=>array('ProjectTemplate.company_id'=>SES_COMP),'fields'=>array('ProjectTemplate.module_name','ProjectTemplate.id'), 'order'=>'ProjectTemplate.created DESC'));
        //$this->set("templates_modules",$modlist);

        $userArr = $this->User->query("SELECT User.name,User.last_name,User.id,User.short_name,CompanyUser.user_type FROM users AS User,company_users AS CompanyUser WHERE User.id=CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active ='1' AND CompanyUser.user_type!='3' AND User.isactive='1' ORDER BY CompanyUser.user_type ASC");
        $this->set("userArr", $userArr);
    }

    public function ajax_json_members()
    {
        $this->layout = 'ajax';
        $search = $this->params->query['tag'];
        $userArr = $this->User->query("SELECT User.name,User.last_name,User.id,User.short_name,User.email FROM users AS User,company_users AS CompanyUser WHERE User.id=CompanyUser.user_id AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND CompanyUser.user_type='3' AND User.isactive='1' AND (User.name LIKE '%" . $search . "%' OR User.email LIKE '%" . $search . "%') ORDER BY User.name ASC");
        //ob_clean();
        $items = array();
        foreach ($userArr as $urs) {
            //$unm = $urs['User']['name']." &lt".$urs['User']['email']."&gt;";
            $unm = $urs['User']['name'] . '|' . $urs['User']['email'];
            $items[] = array("name" => $unm, "value" => $urs['User']['id']);
        }
        print json_encode($items);
        exit;
    }

    public function ajax_json_project()
    {
        $this->layout = 'ajax';
        $search = isset($this->params->query['q']) ? $this->params->query['q'] : $this->params->query['tag'];
        //$proj_array = $this->ProjectUser->query("SELECT project_users.project_id FROM project_users WHERE project_users.user_id = '".SES_ID."' AND project_users.company_id = '".SES_COMP."'");
        $proj_array = $this->ProjectUser->query("SELECT project_users.project_id FROM project_users WHERE project_users.user_id = '" . SES_ID . "' AND project_users.project_id NOT IN(" . $this->params['pass'][0] . ")");
        $projcts = array();
        foreach ($proj_array as $k => $v) {
            foreach ($v as $k1 => $v1) {
                $projcts[] = $v1['project_id'];
            }
        }
        $this->Project->recursive = -1;
        $projname_array = $this->Project->find('all', array('conditions' => array('AND' => array('Project.id' => $projcts, 'Project.name LIKE "%' . $search . '%"')), 'fields' => array('Project.id', 'Project.name'), 'order' => 'Project.name asc'));
        //ob_clean();
        $items = array();

        foreach ($projname_array as $urs) {
            $items[] = array("id" => $urs['Project']['id'], "name" => $urs['Project']['name']);
        }
        print json_encode($items);
        exit;
    }

    public function ajax_template_case_listing()
    {
        $this->layout = 'ajax';
        //$all_cases=ClassRegistry::init('ProjectTemplateCase')->find('all',array('conditions'=>array('ProjectTemplateCase.template_id'=>$this->params->data['template_id'],'ProjectTemplateCase.company_id'=> SES_COMP)));
        if (isset($this->params->data['rem_template_id']) && $this->params->data['rem_template_id']) {
            $this->loadModel("ProjectTemplateCase");
            $this->ProjectTemplateCase->id = $this->params->data['rem_template_id'];
            $this->ProjectTemplateCase->delete();
            echo "removed";
            exit;
        }
        $all_cases = ClassRegistry::init('ProjectTemplateCase')->query("SELECT User.short_name,User.name,ProjectTemplateCase.*  FROM users AS User,project_template_cases AS ProjectTemplateCase WHERE ProjectTemplateCase.template_id='" . $this->params->data['template_id'] . "' AND ProjectTemplateCase.company_id='" . SES_COMP . "' AND ProjectTemplateCase.user_id=User.id ;");
        $this->set("templates_cases", $all_cases);
    }

    public function ajax_template_edit()
    {
        $this->layout = 'ajax';
        //ob_clean();
        if (isset($this->params->data['template_id']) && $this->params->data['template_id'] && isset($this->params->data['count']) && $this->params->data['count']) {
            $temp_id = $this->params->data['template_id'];
            $cnt = $this->params->data['count'];
            $ttl = urldecode($this->params->data['module_name']);
            $res = ClassRegistry::init('ProjectTemplate')->find('all', array('conditions' => array('module_name' => $ttl, 'company_id' => SES_COMP)));
            if (count($res) == 0) {
                $this->loadModel("ProjectTemplate");
                $this->ProjectTemplate->id = $temp_id;
                if ($this->ProjectTemplate->saveField("module_name", $ttl)) {
                    echo "<a class='classhover' href='javascript:void(0);'  title='Click here to view tasks' onclick='opencases($cnt);caseListing($cnt,$temp_id)'>$ttl</a>";
                    exit;
                } else {
                    echo "fail";
                    exit;
                }
            } else {
                echo "exist";
                exit;
            }
        } else {
            echo "fail";
            exit;
        }
    }

    public function assign_template_project()
    {
        $this->loadModel("ProjectTemplate");
        $res = $this->ProjectTemplate->find('all', array('conditions' => array('ProjectTemplate.module_name !=' => '', 'ProjectTemplate.company_id' => SES_COMP, 'ProjectTemplate.is_active' => 1)));
        $this->set('temp_module', $res);
        $this->Project->recursive = -1;
        $project_details = $this->Project->find('all', array('conditions' => array('Project.company_id' => SES_COMP, 'Project.isactive' => 1), 'fields' => array('Project.name', 'Project.id')));
        $this->set('project_details', $project_details);
    }

    public function update_email_notification()
    {
        $this->layout = 'ajax';
        $proj_user_id = $this->params->data['projectuser_id'];
        $email_type = $this->params->data['type'];
        if ($proj_user_id && $email_type) {
            if ($email_type == 'off') {
                $this->ProjectUser->query("UPDATE project_users SET default_email=0 where id='" . $proj_user_id . "'");
            } else {
                $this->ProjectUser->query("UPDATE project_users SET default_email=1 where id='" . $proj_user_id . "'");
            }
        }
        echo "sucess";
        exit;
    }

    public function ajax_save_filter()
    {
        $this->layout = 'ajax';
        //For Case Status
        if (isset($this->params->data['caseStatus']) && $this->params->data['caseStatus']) {
            $case_status = $this->params->data['caseStatus'];
        } elseif ($_COOKIE['STATUS']) {
            $case_status = $_COOKIE['STATUS'];
        }

        if ($case_status && $case_status != "all") {
            $case_status = strrev($case_status);
            if (strstr($case_status, "-")) {
                $expst = explode("-", $case_status);
                foreach ($expst as $st) {
                    $status.= $this->Format->displayStatus($st) . ", ";
                }
            } else {
                $status = $this->Format->displayStatus($case_status) . ", ";
            }
            $arr['case_status'] = trim($status, ', ');
        //$val =1;
        } else {
            $arr['case_status'] = 'All';
        }

        //For case types
        if (isset($this->params->data['caseType']) && $this->params->data['caseType']) {
            $case_types = $this->params->data['caseType'];
        } elseif ($_COOKIE['CS_TYPES']) {
            $case_types = $_COOKIE['CS_TYPES'];
        }
        $types = '';
        if ($case_types && $case_types != "all") {
            $case_types = strrev($case_types);
            if (strstr($case_types, "-")) {
                $expst3 = explode("-", $case_types);
                foreach ($expst3 as $st3) {
                    $types.= $this->Format->caseBcTypes($st3) . ", ";
                }
                $types = trim($types, ', ');
            } else {
                $types = $this->Format->caseBcTypes($case_types);
            }
            $arr['case_types'] = $types;
        //$val =1;
        } else {
            $arr['case_types'] = 'All';
        }
        //For Priority
        if (isset($this->params->data['casePriority']) && $this->params->data['casePriority']) {
            $pri_fil = $this->params->data['casePriority'];
        } elseif ($_COOKIE['PRIORITY']) {
            $pri_fil = $_COOKIE['PRIORITY'];
        }
        if ($pri_fil && $pri_fil != "all") {
            if (strstr($pri_fil, "-")) {
                $expst2 = explode("-", $pri_fil);
                foreach ($expst2 as $st2) {
                    $pri.= $st2 . ", ";
                }
                $pri = trim($pri, ', ');
            } else {
                $pri = $pri_fil;
            }
            $arr['pri'] = $pri;
        //$val =1;
        } else {
            $arr['pri'] = 'All';
        }
        //For Case Members
        if (isset($this->params->data['caseMemeber']) && $this->params->data['caseMemeber']) {
            $case_member = $this->params->data['caseMemeber'];
        } elseif ($_COOKIE['MEMBERS']) {
            $case_member = $_COOKIE['MEMBERS'];
        }
        if ($case_member && $case_member != "all") {
            if (strstr($case_member, "-")) {
                $expst4 = explode("-", $case_member);
                foreach ($expst4 as $st4) {
                    $mems.= $this->Format->caseBcMems($st4) . ", ";
                }
            } else {
                $mems = $this->Format->caseBcMems($case_member) . ", ";
            }
            $arr['case_member'] = trim($mems, ', ');
        //$val =1;
        } else {
            $arr['case_member'] = 'All';
        }


        //For Case Date Status ....
        if (isset($this->params->data['caseDate']) && $this->params->data['caseDate']) {
            $date = $this->params->data['caseDate'];
        } else {
            $date = $this->Cookie->read('DATE');
        }
        if (!empty($date)) {
            //$val = 1;
            if (trim($date) == 'one') {
                $arr['date'] = "Past hour";
            } elseif (trim($date) == '24') {
                $arr['date'] = "Past 24Hour";
            } elseif (trim($date) == 'week') {
                $arr['date'] = "Past Week";
            } elseif (trim($date) == 'month') {
                $arr['date'] = "Past month";
            } elseif (trim($date) == 'year') {
                $arr['date'] = "Past Year";
            } elseif (strstr(trim($date), ":")) {
                $arr['date'] = str_replace(":", " - ", $date);
            }
        } else {
            $arr['date'] = "Any Time";
        }
        $this->set('memebers', $arr['case_member']);
        $this->set('priority', $arr['pri']);
        $this->set('type', $arr['case_types']);
        $this->set('status', $arr['case_status']);
        $this->set('date', $arr['date']);

        $this->set('memebers_val', $case_member);
        $this->set('priority_val', $pri_fil);
        $this->set('type_val', $case_types);
        $this->set('status_val', $case_status);
        $this->set('date_val', $date);
    }

    public function ajax_customfilter_save()
    {
        $this->layout = 'ajax';

        $caseStatus = $this->params->data['caseStatus'];
        $caseType = $this->params->data['caseType'];
        $caseDate = $this->params->data['caseDate'];
        $caseMemeber = $this->params->data['caseMemeber'];
        $caseComment = $this->params->data['caseComment'];
        $casePriority = $this->params->data['casePriority'];
        $filterName = $this->params->data['filterName'];
        $projuniqid = $this->params->data['projuniqid'];
        $this->loadModel('CustomFilter');
        $this->CustomFilter->query("INSERT INTO custom_filters SET project_uniq_id='" . $projuniqid . "', company_id='" . SES_COMP . "', user_id='" . SES_ID . "', filter_name='" . $filterName . "',filter_date='" . $caseDate . "', filter_type_id='" . $caseType . "',filter_status='" . $caseStatus . "', filter_member_id='" . $caseMemeber ."', filter_comment='" . $caseComment . "', filter_priority='" . $casePriority . "', dt_created='" . GMT_DATETIME . "'");

        echo "success";
        exit;
    }

    public function ajax_custom_filter_show()
    {
        $this->layout = 'ajax';
        $limit_1 = $this->params->data['limit1'];
        if (isset($limit_1)) {
            $limit1 = (int) $limit_1 + 3;
            $limit2 = 3;
        } else {
            $limit1 = 0;
            $limit2 = 3;
        }
        $this->loadModel('CustomFilter');
        $getcustomfilter = "SELECT SQL_CALC_FOUND_ROWS * FROM custom_filters AS CustomFilter WHERE CustomFilter.company_id = '" . SES_COMP . "' and CustomFilter.user_id =  '" . SES_ID . "' ORDER BY CustomFilter.dt_created DESC LIMIT $limit1,$limit2";
        $getfilter = $this->CustomFilter->query($getcustomfilter);
        $tot = $this->CustomFilter->query("SELECT FOUND_ROWS() as total");
        //echo '<pre>';print_r($tot);
        $this->set('getfilter', $getfilter);
        $this->set('limit1', $limit1);
        $this->set('totalfilter', $tot[0][0]['total']);
    }

   

    /**
     * @method: public importexport(int proj_id) Dataimport Interface
     * @author Andola  <>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function importexport($proj_id = '')
    {
        if (SES_TYPE > 2) {
            $this->redirect(HTTP_ROOT.'dashboard');
        }
        if (!$proj_id && (!isset($GLOBALS['getallproj'][0]['Project']['uniq_id']))) {
            $this->redirect(HTTP_ROOT . 'projects/manage/');
            exit;
        } else {
            if (!empty($proj_id) && $proj_id == 'all') {
                $this->set('upload_file', 1);
                $this->set('proj_id', $proj_id);
                $this->set('proj_uid', $radio);
                $this->set('import_pjname', $proj_id);
            } else {
                if (!$proj_id) {
                    $proj_id = $GLOBALS['getallproj'][0]['Project']['uniq_id'];
                }
                $this->Project->recursive = -1;
                $proj_details = $this->Project->find('first', array('conditions' => array('uniq_id' => $proj_id, 'company_id' => SES_COMP)));
                if ($proj_details) {
                    $this->set('upload_file', 1);
                    $this->set('proj_id', $proj_details['Project']['id']);
                    $this->set('proj_uid', $proj_id);
                    $this->set('import_pjname', $proj_details['Project']['name']);
                } else {
                    $this->redirect(HTTP_ROOT . 'projects/gridview/');
                    exit;
                }
            }
        }
    }

    /**
     * @method public data_import Dataimport Interface
     * @author Andola  <>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function csv_dataimport()
    {
        $this->Session->write('csvimportflag', 1);
        $project_id = $this->data['proj_id'];
        $project_uid = $this->data['proj_uid'];
        $this->loadModel('Type');
        $task_types = $this->Type->getAllTypes();
        $this->loadModel("TypeCompany");
        $sel_types = $this->TypeCompany->getSelTypes();
        $is_projects = 0;
        $is_ttl_length = 0;
        $task_type_arr = array();
        if (isset($sel_types) && !empty($sel_types) && isset($task_types) && !empty($task_types)) {
            foreach ($task_types as $key => $value) {
                if (array_search($value['Type']['id'], $sel_types)) {
                    $task_type_arr[$value['Type']['id']] = strtolower($value['Type']['name']);
                }
            }
            $is_projects = 1;
        }
        //check custom status
        if ($project_id == 'all') {
            $allStst = $this->Format->getStatusByProject('all');
            $sts_arr = $this->Format->getCustomTaskStatus(-1);
        } else {
            $allStst = $this->Format->getStatusByProject($project_id);
            if ($allStst[0]['Project']['status_group_id'] != 0) {
                $sts_arr = $this->Format->getCustomTaskStatus($allStst[0]['Project']['status_group_id']);
            } else {
                $sts_arr = $this->Format->getCustomTaskStatus(-1);
            }
        }
        $allStsNmId = Hash::combine($sts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus.name');
//        $task_type_arr = array('enhancement', 'enh', 'bug', 'research n do', 'rnd', 'quality assurance', 'qa', 'unit testing', 'unt', 'maintenance', 'mnt', 'others', 'oth', 'release', 'rel', 'update', 'upd', 'development', 'dev');
        $task_status_arr = array('new', 'close', 'wip', 'resolve', 'resolved', 'closed', 'in progress');
        $task_is_billabe = array(0, 1);
        $this->loadModel('User');
        $this->loadModel('ProjectUser');
        if ($project_id != 'all') {
            $task_assign_to_userid = $this->ProjectUser->find('list', array('conditions' => array('company_id' => SES_COMP, 'project_id' => $project_id), 'fields' => 'user_id'));
            $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => 'email'));
            $status_group_id = $this->Project->find('first', array('conditions'=>array('Project.id'=>$project_id),'fields'=>'status_group_id'));
            if ($status_group_id['Project']['status_group_id'] != 0) {
                $this->loadModel('CustomStatus');
                $cusSts = $this->CustomStatus->find('list', array('conditions'=>array('CustomStatus.status_group_id'=>$status_group_id['Project']['status_group_id']),'fields'=>array('CustomStatus.id','CustomStatus.name'),'order'=>array('CustomStatus.seq'=>'ASC')));
                $task_status_arr = array_map('strtolower', array_values($cusSts));
            }
        }
        //$fields_arr = array('milestone title','milestone description','start date','end date','title','description','due date','status','type','assigned to');
        $fields_arr = array('project', 'taskgroup','sprint','sprint/taskgroup', 'title', 'description', 'start date', 'due date', 'status', 'type', 'assigned to', 'estimated hour', 'start time', 'end time', 'break time', 'is billable','created by');
        $fields_arr1 = array('task#', 'task title', 'description', 'start date', 'due date', 'task group','sprint','sprint/task group', 'project name', 'task type', 'assigned to', 'priority', 'created date', 'updated date', 'status', 'due date', 'comments', 'estimated hour', 'start time', 'end time', 'break time', 'is billable','label');
        //, 'created by'
//        $fields_arr1 = array('task#', 'project name', 'task group', 'task title', 'description', 'due date', 'status', 'task type', 'assigned to', 'priority', 'estimated hour', 'start time', 'end time', 'break time', 'is billable', 'created date', 'updated date', 'comments');
        if (isset($_FILES['import_csv'])) {
            //$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv','application/octet-stream');
            $ext = pathinfo($_FILES['import_csv']['name'], PATHINFO_EXTENSION);
            //if(in_array($_FILES['import_csv']['type'],$mimes)){
            if (strtolower($ext) == 'csv') {
                $csv_info = $_FILES['import_csv'];
                //Uploading the csv file to Our server
                $file_name = SES_ID . "_" . $project_id . "_" . $csv_info['name'];
                @copy($csv_info['tmp_name'], CSV_PATH . "task_milstone/" . $file_name);

                $row = 1;
                // Counting total rows and Restricting from uploading a file having more then 1000 record
                $linecount = count(file(CSV_PATH . "task_milstone/" . $file_name));
                if ($linecount > 1001) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "task_milstone/" . $file_name);
                    $this->Session->write("ERROR", __("Please split the file and upload again. Your file contain more than 1000 rows", true));
                    $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
                    exit;
                }
                if ($csv_info['size'] > 2097152) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "task_milstone/" . $file_name);
                    $this->Session->write("ERROR", __("Please upload a file with size less then 2MB", true));
                    $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
                    exit;
                }
                //Parsing the csv file
                if (($handle = fopen(CSV_PATH . "task_milstone/" . $file_name, "r")) !== false) {
                    $i = 0;
                    $j = 0;
                    $separator = ',';
                    $chk_coma = $data = fgetcsv($handle, 1000, ",");
                    if (count($chk_coma) == 1 && stristr($chk_coma[0], ";")) {
                        $separator = ';';
                    }
                    rewind($handle);
                    $project_list = array();
                    $project_name = array();
                    $j = 0;
                   
                    while (($data = fgetcsv($handle, 1000, $separator)) !== false) {
                        if ($project_id == 'all' && (strtolower($fileds[0]) == 'project' || strtolower($fileds[0]) == 'project name') && empty($data[0])) {
                            continue;
                        }
                        if (empty($data[0]) && count($data) == 1) {
                            continue;
                        }
                        if (strtolower(trim($data[0])) == 'export date' || strtolower(trim($data[0])) == 'total') {
                            continue;
                        }
                        if (!$i) {
                            // Check for column count
                            if (count($data) >= 1) {
                                // Check for exact number of fields
                                foreach ($data as $key => $val) {
                                    if (!in_array(strtolower($val), $fields_arr) && !in_array(strtolower($val), $fields_arr1)) {
                                        continue;
                                        @unlink(CSV_PATH . "task_milstone/" . $file_name);
                                        $this->Session->write("ERROR", "". __('Invalid CSV file', true).", <a href='" . HTTP_ROOT . "projects/download_sample_csvfile' style='text-decoration:underline;color:#0000FF'>".__('Download', true)."</a> ".__('and check with our sample file', true));
                                        $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
                                        exit;
                                    }
                                    if (strtolower($val) == 'task#' || strtolower($val) == 'comments' || strtolower($val) == 'label' || strtolower($val) == 'created date' || strtolower($val) == 'updated date') {
                                        continue;
                                    } else {
                                        $fileds[$key] = $val;
                                    }
                                }

                                //$header_arr = array_flip($data);
                                foreach ($data as $key => $val) {
                                    $header_arr[strtolower($val)] = $key;
                                }
                            } else {
                                @unlink(CSV_PATH . "task_milstone/" . $file_name);
                                $this->Session->write("ERROR", __("Require atleast Task Title column to import the Tasks", true));
                                $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
                                exit;
                            }
                        } else {
                            // Verifing data
                            $value = $data;
                            // If there is a comment then there should not task tile
                            if ((isset($value[$header_arr['task title']]) && empty($value[$header_arr['task title']])) || (isset($value[$header_arr['title']]) && empty($value[$header_arr['title']]))) {
                                continue;
                            }
                            
                            if (isset($value[$header_arr['title']]) && trim($value[$header_arr['title']]) || (isset($value[$header_arr['task title']]) && trim($value[$header_arr['task title']])) && $value[$header_arr['task#']] != 'Export Date' && $value[$header_arr['task#']] != 'Total') {
                                $temp_project_nm = '';
                                foreach ($value as $k => $v) {
                                    if (strtolower($fileds[$k]) == 'task#' || strtolower($fileds[$k]) == 'comments' || strtolower($fileds[$k]) == 'label' || strtolower($fileds[$k]) == 'created date' || strtolower($fileds[$k]) == 'updated date') {
                                        continue;
                                    }
                                    if (!in_array(strtolower($fileds[$k]), $fields_arr) && !in_array(strtolower($fileds[$k]), $fields_arr1)) {
                                        continue;
                                    }
                                    if (strtolower($fileds[$k]) == 'project' && mb_detect_encoding(utf8_encode($v), mb_detect_order(), true) == 'UTF-8') {
                                        $task_ass[strtolower($fileds[$k])] = utf8_encode($v);
                                    } else {
                                        if (strtolower($fileds[$k]) == 'title' || strtolower($fileds[$k]) == 'task title' || strtolower($fileds[$k]) == 'description') {
                                            // adding condition to check the title or description contains multi byte character
                                            $task_ass[strtolower($fileds[$k])] = !empty($v) ? $this->Format->contains_any_multibyte($v) ? utf8_encode($v) : utf8_encode($v)  : '';
                                            // $task_ass[strtolower($fileds[$k])] = !empty($v) ? $this->Format->contains_any_multibyte($v) ? $v : $this->formatImportText($v)  : '';//Commented By Srichandan for solve Spanish characters
                                            //!empty($v['title']) ? $this->formatImportText($v['title']) : '';$this->formatImportText($v);
                                            if (strlen($v) > 240 && (strtolower($fileds[$k]) == 'title' || strtolower($fileds[$k]) == 'task title')) {
                                                $is_ttl_length++;
                                            }
                                        } else {
                                            $task_ass[strtolower($fileds[$k])] = $v;
                                        }
                                    }
                                    //print utf8_encode($v).'===';exit;
                                    if ($project_id == 'all' && (strtolower($fileds[$k]) == 'project' || strtolower($fileds[$k]) == 'project name') && empty($v)) {
                                        @unlink(CSV_PATH . "task_milstone/" . $file_name);
                                        $this->Session->write("ERROR", "". __('Invalid CSV file', true).", <a href='" . HTTP_ROOT . "projects/download_sample_csvfile' style='text-decoration:underline;color:#0000FF'>".__('Download', true)."</a> ".__('and check with our sample file', true));
                                        $this->redirect(HTTP_ROOT . "projects/importexport/" .$project_uid);
                                    }
                                    if ((strtolower($fileds[$k]) == 'project' || strtolower($fileds[$k]) == 'project name') && $v) {
                                        $project_data_arr = $this->Project->find('list', array('fields' => array('Project.id', 'Project.name'), 'conditions' => array('Project.isactive' => 1, 'Project.company_id' => SES_COMP)));
                                        $project_data_arr = array_flip($project_data_arr);
                                        $project_data_arr = array_change_key_case($project_data_arr, CASE_LOWER);
                                        $project_data_arr = array_flip($project_data_arr);
                                        if (in_array(strtolower(trim($v)), $project_data_arr)) {
                                            if (trim($project_data_arr[$project_id]) != strtolower(trim($v)) && $project_id != "all") {
                                                @unlink(CSV_PATH . "task_milstone/" . $file_name);
                                                $this->Session->write("ERROR", __('Invalid CSV file', true)." ".__('or selected project does not match.'));
                                                $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
                                            }
                                            $project_name[] = ucwords($v);
                                            $task_error[strtolower($fileds[$k])] = 0;
                                            $temp_project_nm = $v;
                                        } else {
                                            if ($project_id != 'all') {
                                                $task_error[strtolower($fileds[$k])] = 1;
                                            }
                                            $temp_project_nm = '';
                                        }
//                                        pr($task_error); exit;
                                        if ($project_id == 'all') {
                                            $project = $this->Project->find('first', array('conditions' => array('Project.isactive' => 1, 'Project.company_id' => SES_COMP, 'Project.name LIKE ' => trim(strtolower($v)))));
                                            $project_list[$j] = $project;
                                            $task_assign_to_users = array();
                                            if (!empty($project)) {
                                                $pro_id = $project['Project']['id'];
                                                $temp_project_nm = $v;
                                                $task_is_billabe = array(0, 1);
                                                $task_assign_to_userid = $this->ProjectUser->find('list', array('conditions' => array('company_id' => SES_COMP, 'project_id' => $pro_id), 'fields' => 'user_id'));
                                                $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => 'email'));
                                                $j++;
                                            } else {
                                                $temp_project_nm = '';
                                            }
                                        }
                                    }
                                    // Parsing each data for error in data
                                    elseif ((strtolower($fileds[$k]) == 'type' || strtolower($fileds[$k]) == 'task type') && $v) {
                                        if (in_array(strtolower(trim($v)), $task_type_arr)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'status' && $v) {
                                        if (in_array(strtolower($v), $task_status_arr) || $this->Format->isValidStatus($v, $temp_project_nm, $allStst, $allStsNmId)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'start date' && $v) {
                                        if (stristr($v, "-")) {
                                            $v = str_replace("-", "/", $v);
                                        }
                                        if ($this->Format->isValidDateTime($v)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'due date' && $v) {
                                        if (stristr($v, "-")) {
                                            $v = str_replace("-", "/", $v);
                                        }
                                        if ($this->Format->isValidDateTime($v)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'assigned to' && strtolower($v) != 'me' && strtolower($v) != 'nobody' && $v) {
                                        if (filter_var($v, FILTER_VALIDATE_EMAIL)) {
                                            if (in_array($v, $task_assign_to_users)) {
                                                $task_error[strtolower($fileds[$k])] = 0;
                                            } else {
                                                $task_error[strtolower($fileds[$k])] = 1;
                                            }
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'estimated hour' && $v) {
                                        if ($this->Format->isValidDateHours($v, 0, 1)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'start time' && $v) {
                                        if ($this->Format->isValidTlDateHours($v, 1)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'end time' && $v) {
                                        if ($this->Format->isValidTlDateHours($v, 1)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'break time' && $v) {
                                        if ($this->Format->isValidDateHours($v)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'is billable' && $v) {
                                        if (in_array(trim($v), $task_is_billabe)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } else {
                                        $task_error[strtolower($fileds[$k])] = 0;
                                    }
                                }
                                $task[] = $task_ass;
                                $task_err[] = $task_error;
                            } else {
                                if (empty($fileds[$k])) {
                                    continue;
                                }
                                @unlink(CSV_PATH . "task_milstone/" . $file_name);
                                $this->Session->write("ERROR", "". __('Invalid CSV file', true).", <a href='" . HTTP_ROOT . "projects/download_sample_csvfile' style='text-decoration:underline;color:#0000FF'>".__('Download', true)."</a> ".__('and check with our sample file', true));
                                $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
                                exit;
                            }
                        }
                        $i++;
                    }
                    fclose($handle);
                }
                if ($project_id != 'all') {
                    $this->Project->recursive = -1;
                    $projectdata = $this->Project->findById($project_id);
                    $projectname = $projectdata['Project']['name'];
                } else {
                    $project_name = array_unique($project_name);
                    if (!empty($project_name)) {
                        $numItems = count($project_name);
                        $k = 0;
                        $pro_name = '';
                        $pro_name_last = '';
                        foreach ($project_name as $key => $value) {
                            if (++$k === $numItems && count($project_name) > 1) {
                                $pro_name_last = ' and ' . $value;
                            } else {
                                $pro_name .= $value . ',';
                            }
                        }
                    }
                    $projectname = trim($pro_name, ',') . $pro_name_last;
                }
                //pr($milestone_arr);echo "<hr/>";pr($task);echo "<hr/>";pr($task_err);exit;
                //$this->set('milestone_arr',$milestone_arr);
                $this->Project->recursive = -1;
                $this->set('projectname', $projectname);
                $this->set('task', $task);
                $this->set('task_err', $task_err);
                $this->set('preview_data', 1);
                $this->set('fileds', $fileds);
                $this->set('porj_id', $project_id);
                $this->set('porj_uid', $project_uid);
                $this->set('csv_file_name', $csv_info['name']);
                $this->set('total_rows', $linecount);
                $this->set('new_file_name', $file_name);
                $this->set('is_ttl_length', $is_ttl_length);
                if (empty($task)) {
                    $this->Session->write("ERROR", __("Please import a valid CSV file", true));
                    $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
                }
                $this->render('importexport');
            } else {
                $this->Session->write("ERROR", __("Please import a valid CSV file", true));
                $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
            }
        } else {
            $this->Session->write("ERROR", __("Please import a valid CSV file", true));
            $this->redirect(HTTP_ROOT . "projects/importexport/" . $project_uid);
        }
    }
    public function formatImportText($value)
    {
        //remove non printsble characters
        $value = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $value);
        return $value;
    }

    /**
     * @method public timelog data_import Dataimport Interface
     * @author Andola  <>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function csv_tldataimport()
    {
        $task_is_billabe = array(0, 1);
        $this->loadModel('User');
        $this->loadModel('CompanyUser');
        $task_assign_to_userid = $this->CompanyUser->find('list', array('conditions' => array('company_id' => SES_COMP, 'is_active' => 1), 'fields' => 'user_id'));
        $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => 'email'));
        $fields_arr = array('project name', 'task#', 'description', 'assigned to', 'date', 'hours', 'start time', 'end time', 'break time', 'is billable');

        $this->loadModel('Project');
        $task_assign_prj = $this->Project->find('list', array('conditions' => array('company_id' => SES_COMP, 'isactive' => 1), 'fields' => array('id', 'name')));
        $task_assign_prj_name = array_values($task_assign_prj);
        $task_assign_prj_name = array_map('strtolower', $task_assign_prj_name);

        $task = array();
        $task_err = array();
        
        if (isset($_FILES['tlimport_csv'])) {
            $ext = pathinfo($_FILES['tlimport_csv']['name'], PATHINFO_EXTENSION);
            if (strtolower($ext) == 'csv') {
                $csv_info = $_FILES['tlimport_csv'];
                //Uploading the csv file to Our server
                $file_name = SES_ID . "_timelog_" . $csv_info['name'];
                @copy($csv_info['tmp_name'], CSV_PATH . "timelog_import/" . $file_name);
                $row = 1;
                // Counting total rows and Restricting from uploading a file having more then 1000 record
                $linecount = count(file(CSV_PATH . "timelog_import/" . $file_name));
                if ($linecount > 20001) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "timelog_import/" . $file_name);
                    $this->Session->write("ERROR", __("Please split the file and upload again. Your file contain more than 1000 rows", true));
                    $this->redirect(HTTP_ROOT . "projects/importtimelog/");
                    exit;
                }
                if ($csv_info['size'] > 2097152) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "timelog_import/" . $file_name);
                    $this->Session->write("ERROR", __("Please upload a file with size less then 2MB", true));
                    $this->redirect(HTTP_ROOT . "projects/importtimelog/");
                    exit;
                }
                //Parsing the csv file
                if (($handle = fopen(CSV_PATH . "timelog_import/" . $file_name, "r")) !== false) {
                    $i = 0;
                    $j = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        if (!$i) {
                            // Check for column count
                            if (count($data) >= 1) {
                                // Check for exact number of fields
                                foreach ($data as $key => $val) {
                                    if (!in_array(strtolower($val), $fields_arr)) {
                                        @unlink(CSV_PATH . "timelog_import/" . $file_name);
                                        $this->Session->write("ERROR", "". __('Invalid CSV file', true).", <a href='" . HTTP_ROOT . "projects/download_sample_csvfile' style='text-decoration:underline;color:#0000FF'>".__('Download', true)."</a> ".__('and check with our sample file', true));
                                        $this->redirect(HTTP_ROOT . "projects/importtimelog/");
                                        exit;
                                    }
                                }
                                $fileds = $data;
                                foreach ($data as $key => $val) {
                                    $header_arr[strtolower($val)] = $key;
                                }
                            } else {
                                @unlink(CSV_PATH . "timelog_import/" . $file_name);
                                $this->Session->write("ERROR", __("Require atleast Task Title column to import the Tasks", true));
                                $this->redirect(HTTP_ROOT . "projects/importtimelog/");
                                exit;
                            }
                        } else {
                            // Verifing data
                            $value = $data;
                            if (isset($value[$header_arr['project name']]) && trim($value[$header_arr['project name']])) {
                                foreach ($value as $k => $v) {
                                    $task_ass[strtolower($fileds[$k])] = $v;

                                    // Parsing each data for error in data
                                    if (strtolower($fileds[$k]) == 'project name' && $v) {
                                        if (in_array(strtolower(trim($v)), $task_assign_prj_name)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'task#' && $v) {
                                        $ck_tsk = $this->chk_impt_task($task_assign_prj, $value[$header_arr['project name']], $value[$header_arr['task#']]);
                                        if ($ck_tsk) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'assigned to' && strtolower($v) != 'me' && $v) {
                                        if (in_array($v, $task_assign_to_users)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'start time' && $v) {
                                        if ($this->Format->isValidTlDateHours($v, 1)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'end time' && $v) {
                                        if ($this->Format->isValidTlDateHours($v, 1)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'break time' && $v) {
                                        if ($this->Format->isValidDateHours($v)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'is billable' && $v) {
                                        if (in_array(trim($v), $task_is_billabe)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } else {
                                        $task_error[strtolower($fileds[$k])] = 0;
                                    }
                                }
                                $task[] = $task_ass;
                                $task_err[] = $task_error;
                            }
                        }
                        $i++;
                    }
                    fclose($handle);
                }
                $this->set('task', $task);
                $this->set('task_err', $task_err);
                $this->set('preview_data', 1);
                $this->set('fileds', $fileds);
                $this->set('csv_file_name', $csv_info['name']);
                $this->set('total_rows', $linecount);
                $this->set('new_file_name', $file_name);
                $this->render('importtimelog');
            } else {
                $this->Session->write("ERROR", __("Please import a valid CSV file", true));
                $this->redirect(HTTP_ROOT . "projects/importtimelog/");
            }
        } else {
            $this->Session->write("ERROR", __("Please import a valid CSV file", true));
            $this->redirect(HTTP_ROOT . "projects/importtimelog/");
        }
    }

    public function chk_impt_task($all_prj, $proj, $caseno)
    {
        $this->loadModel('Easycase');
        $proj = trim($proj);
        $all_prj_flp = array_flip($all_prj);
        $pid = isset($all_prj_flp[$proj]) ? $all_prj_flp[$proj] : $all_prj_flp[strtolower($proj)];
        $task_valid = $this->Easycase->find('first', array('conditions' => array('project_id' => $pid, 'case_no' => $caseno), 'fields' => 'case_no'));
        if (!empty($task_valid)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteCsvFile()
    {
        $this->layout = 'ajax';
        if ($this->data['file']) {
            $fl = trim($this->data['file']);
            if (file_exists(CSV_PATH . "task_milstone/" . $fl)) {
                unlink(CSV_PATH . "task_milstone/" . $fl);
            }
        }
        echo 1;
        exit;
    }

    public function deleteTlCsvFile()
    {
        $this->layout = 'ajax';
        if ($this->data['file']) {
            $fl = trim($this->data['file']);
            if (file_exists(CSV_PATH . "timelog_import/" . $fl)) {
                unlink(CSV_PATH . "timelog_import/" . $fl);
            }
        }
        echo 1;
        exit;
    }

    /**
     * @method: public confirm_tlimport Dataimport Interface
     * @author Andola  <>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function confirm_tlimport()
    {
        $this->loadModel('User');
        $this->loadModel('CompanyUser');
        $task_assign_to_userid = $this->CompanyUser->find('list', array('conditions' => array('company_id' => SES_COMP, 'is_active' => 1), 'fields' => 'user_id'));
        $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => array('email', 'id')));

        $fields_arr = array('project name', 'task#', 'description', 'assigned to', 'date', 'hours', 'start time', 'end time', 'break time', 'is billable');

        $this->loadModel('Project');
        $task_assign_prj = $this->Project->find('list', array('conditions' => array('company_id' => SES_COMP, 'isactive' => 1), 'fields' => array('id', 'name')));
        $task_assign_prj_name = array_values($task_assign_prj);
        $task_assign_prj_name = array_map('strtolower', $task_assign_prj_name);
        $task_arr = array();
        if (trim($this->data['new_file_name']) != '') {
            if (($handle = fopen(CSV_PATH . "timelog_import/" . trim($this->data['new_file_name']), "r")) !== false) {
                $i = 0;
                $j = 0;
                while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                    if (!$i) {
                        // Check for column count
                        if (count($data) >= 1) {
                            $fileds = $data;
                            foreach ($data as $key => $val) {
                                $header_arr[strtolower($val)] = $key;
                            }
                        }
                    } else {
                        // Verifing data
                        $value = $data;
                        if (isset($value[$header_arr['project name']]) && trim($value[$header_arr['project name']])) {
                            foreach ($value as $k => $v) {
                                $task_ass[strtolower($fileds[$k])] = $v;
                            }
                            $task_arr[] = $task_ass;
                        }
                    }
                    $i++;
                }
                fclose($handle);
            }
        }
        $hind = 0;
        // Preparing history data
        $history[$hind++]['total_task'] = count($task_arr);
        $total_valid_rows = $total_valid_rows ? ($total_valid_rows + count($task_arr)) : count($task_arr);
        $task_assign_prj_flp = array_flip($task_assign_prj);

        $actual_rows_imported = 0;

        foreach ($task_arr as $k => $v) {
            if (!trim($v['project name'])) {
                continue;
            }
            $CS_message = (isset($v['description']) && $v['description']) ? $v['description'] : '';
            $due_date = (isset($v['date']) && $v['date']) ? $v['date'] : '';
            if ($due_date != '') {
                $due_date = $this->Format->isValidDateTime($due_date) ? date('Y-m-d', strtotime($due_date)) : date('Y-m-d', strtotime(GMT_DATETIME));
            } else {
                $due_date = date('Y-m-d', strtotime(GMT_DATETIME));
            }
            if (!trim($v['task#'])) {
                continue;
            }
            if (!isset($v['assigned to'])) {
                continue;
            }
            $uid = SES_ID;
            if (isset($task_assign_to_users[$v['assigned to']])) {
                $uid = $task_assign_to_users[$v['assigned to']];
            }
            $project_id = (isset($task_assign_prj_flp[$v['project name']])) ? $task_assign_prj_flp[$v['project name']] : '';
            if ($project_id == '') {
                $project_id = (isset($task_assign_prj_flp[strtolower($v['project name'])])) ? $task_assign_prj_flp[strtolower($v['project name'])] : '';
            }
            if ($project_id == '') {
                continue;
            }

            $selected_task_id = $this->Easycase->find('first', array('conditions' => array('Easycase.project_id' => $project_id, 'Easycase.istype' => 1, 'Easycase.case_no' => $v['task#']), 'fields' => array('Easycase.id', 'Easycase.legend')));
            if (!empty($selected_task_id)) {
                $current_id = $selected_task_id['Easycase']['id'];
            } else {
                $current_id = 0;
                continue;
            }

            if ($current_id) {
                $logdata = null;
                $task_is_billabe = array(0, 1);
                $logdata['start_time'] = trim($v['start time']);
                $logdata['end_time'] = trim($v['end time']);
                $logdata['break_time'] = trim($v['break time']);
                $logdata['hours'] = trim($v['hours']);
                if (isset($v['is billable']) && !empty($v['is billable'])) {
                    $logdata['is_billable'] = in_array(trim($v['is billable']), $task_is_billabe) ? $v['is billable'] : 0;
                } else {
                    $logdata['is_billable'] = 0;
                }
                $is_all_set = 0;
                if (!empty($logdata['start_time']) && !empty($logdata['end_time']) && !empty($logdata['hours'])) {
                    $is_all_set = 1;
                }
                $LogTime = null;
                if (empty($logdata['start_time']) || empty($logdata['end_time'])) {
                    $logdata['start_time'] = '00:00:00';
                    $logdata['end_time'] = '23:59:00';
                    $logdata['break_time'] = trim($v['break time']);
                    $LogTime[$i]['timesheet_flag'] = 1;
                    if (empty($logdata['hours'])) {
                        continue;
                    }
                } else {
                    $LogTime[$i]['timesheet_flag'] = 0;
                }
                if ($logdata['start_time'] != '' && $logdata['end_time'] != '') {
                    $this->loadModel('LogTime');
                    /* utc has been converted to users time zone */
                    //$task_date = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "date");
                    $task_date = $due_date;
                    $i = 0;
                    $LogTime = null;
                    $LogTime[$i]['task_id'] = $current_id;

                    $LogTime[$i]['project_id'] = $project_id;
                    $LogTime[$i]['user_id'] = $uid;
                    $LogTime[$i]['task_status'] = $selected_task_id['Easycase']['legend'];
                    $LogTime[$i]['ip'] = $_SERVER['REMOTE_ADDR'];
                    if ($logdata['start_time'] == '00:00:00') {
                        $LogTime[$i]['task_date'] = $task_date;
                        $LogTime[$i]['start_time'] = $logdata['start_time'];
                        $LogTime[$i]['end_time'] = $logdata['end_time'];
                        #stored in sec
                        $LogTime[$i]['break_time'] = 0;
                        $spntHour = trim($logdata['hours']) != '' ? trim($logdata['hours']) : '0';
                        if (strpos($spntHour, ':') > -1) {
                            $split_spnt = explode(':', $spntHour);
                            $spnt_sec = ((($split_spnt[0]) * 60) + intval($split_spnt[1])) * 60;
                        } else {
                            $spnt_sec = $spntHour * 3600;
                        }
                        $LogTime[$i]['total_hours'] = $spnt_sec;
                    } else {
                        /* start time set start */
                        $start_time = $logdata['start_time'];
                        $spdts = explode(':', $start_time);
                        #converted to min
                        if ((strpos($start_time, 'am') === false) && (strpos($start_time, 'AM') === false)) {
                            $nwdtshr = ($spdts[0] != 12) ? ($spdts[0] + 12) : $spdts[0];
                            if ((strpos($start_time, 'PM'))) {
                                $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'PM', true)) . ":00";
                            } else {
                                $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'pm', true)) . ":00";
                            }
                        } else {
                            $nwdtshr = ($spdts[0] != 12) ? ($spdts[0]) : '00';
                            //$dt_start = strstr($nwdtshr . ":" . $spdts[1], 'am', true) . ":00";
                            if ((strpos($start_time, 'AM'))) {
                                $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'AM', true)) . ":00";
                            } else {
                                $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'am', true)) . ":00";
                            }
                        }
                        $minute_start = ($nwdtshr * 60) + $spdts[1];
                        /* start time set end */

                        /* end time set start */
                        $end_time = $logdata['end_time'];
                        $spdte = explode(':', $end_time);
                        #converted to min

                        if ((strpos($end_time, 'am') === false) && (strpos($end_time, 'AM') === false)) {
                            $nwdtehr = ($spdte[0] != 12) ? ($spdte[0] + 12) : $spdte[0];
                            $dt_end = strstr($nwdtehr . ":" . $spdte[1], 'pm', true) . ":00";

                            if ((strpos($end_time, 'PM'))) {
                                $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'PM', true)) . ":00";
                            } else {
                                $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'pm', true)) . ":00";
                            }
                        } else {
                            $nwdtehr = ($spdte[0] != 12) ? ($spdte[0]) : '00';
                            if ((strpos($end_time, 'AM'))) {
                                $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'AM', true)) . ":00";
                            } else {
                                $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'am', true)) . ":00";
                            }
                        }
                        $minute_end = ($nwdtehr * 60) + $spdte[1];
                        /* end time set end */
                        /* checking if start is greater than end then add 24 hr in end i.e. 1440 min */
                        $duration = $minute_end >= $minute_start ? ($minute_end - $minute_start) : (($minute_end + 1440) - $minute_start);
                        $task_end_date = $minute_end >= $minute_start ? $task_date : date('Y-m-d', strtotime($task_date . ' +1 day'));

                        /* total working */
                        $totalbreak = trim($logdata['break_time']) != '' ? $logdata['break_time'] : '0';
                        $break_time = trim($totalbreak);
                        if (strpos($break_time, '.')) {
                            $split_break = $break_time * 60;
                            $break_hour = (intval($split_break / 60) < 10 ? "0" : "") . intval($split_break / 60);
                            $break_min = (intval($split_break % 60) < 10 ? "0" : "") . intval($split_break % 60);
                            $break_time = $break_hour . ":" . $break_min;
                            $minute_break = ($break_hour * 60) + $break_min;
                        } elseif (strpos($break_time, ':')) {
                            $split_break = explode(':', $break_time);
                            #converted to min
                            $minute_break = ($split_break[0] * 60) + $split_break[1];
                        } else {
                            $break_time = $break_time . ":00";
                            $minute_break = $break_time * 60;
                        }
                        $minute_break = $duration < $minute_break ? 0 : $minute_break;
                        /* break ends */

                        /* total hrs start */
                        $total_duration = $duration - $minute_break;
                        $total_hours = $total_duration;
                        /* total hrs end */

                        $LogTime[$i]['task_date'] = $task_date;
                        $LogTime[$i]['start_time'] = $dt_start;
                        $LogTime[$i]['end_time'] = $dt_end;
                        #stored in sec
                        $LogTime[$i]['break_time'] = $minute_break * 60;
                        $LogTime[$i]['total_hours'] = $total_hours * 60;
                    }

                    /* required to convert the date to utc as we are taking converted server date to save */
                    #converted to UTC
                    $LogTime[$i]['start_datetime'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_date . " " . $dt_start, "datetime");
                    $LogTime[$i]['end_datetime'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_end_date . " " . $dt_end, "datetime");


                    $LogTime[$i]['is_billable'] = $logdata['is_billable'];
                    $LogTime[$i]['description'] = strip_tags(addslashes(trim($CS_message)));
                    $actual_rows_imported++;
                    $this->LogTime->saveAll($LogTime);
                }
            }
        }
        $this->set('total_valid_rows', $actual_rows_imported);
        $this->set('csv_file_name', $this->data['csv_file_name']);
        $this->set('total_rows', $this->data['total_rows']);
        $this->set('total_task', count($task_arr));
        $this->set('history', $history);
        $this->render('importtimelog');
    }

    /**
    *Check for invalid sttaus
    */
    public function checkValidprojectStstus($proj_sts)
    {
        $this->loadModel('CustomStatus');
        $this->loadModel('Project');
        $retStsArr = array('status'=>1,'msg'=>'');
        foreach ($proj_sts as $pkk => $pvv) {
            $vSts = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.name LIKE ' =>$pvv[0], 'CustomStatus.company_id' => SES_COMP)));
            if ($vSts) {
                $this->Project->create();
                $this->Project->id = $pkk;
                $this->Project->saveField('status_group_id', $vSts['CustomStatus']['status_group_id']);
            } else {
                $retStsArr['status'] = 0;
                $retStsArr['msg'] = __('Invalid status').' '.$pvv[0].'. '.__('Please enter a valid status and upload again');
            }
        }
        return $retStsArr;
    }
    
    /**
     * @method: public confirm_import Dataimport Interface
     * @author Andola  <>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function confirm_import($id = null)
    {
        $subtask =array();
        $subtask1 =array();
        $subtasknotallow =array();
        if (!empty($this->Session->read('csvimportflag'))) {
            $this->loadModel('CompanyUser');
            $companyUsers = $this->CompanyUser->find('list', array('fields' => array('CompanyUser.id', 'CompanyUser.user_id'), 'conditions' => array('CompanyUser.company_id' => SES_COMP)));
            if (!empty($companyUsers)) {
                $this->loadModel('User');
                $user_con = array("User.id IN('" . implode("','", $companyUsers) . "')");
                $user_list = $this->User->find('list', array('fields' => array('User.email', 'User.id'), 'conditions' => $user_con));
            }
            $pro_id = trim($this->data['project_id']);
            if (trim($this->data['project_id']) != 'all') {
                $project_id = trim($this->data['project_id']);
                $validProject = $this->Project->find('first', array('conditions' => array('Project.id' => $project_id), 'fields' => 'Project.id'));
                if (empty($validProject)) {
                    $this->Session->write('ERROR', 'Oops! Error occurred in importing task');
                    $this->redirect($_SERVER['HTTP_REFERER']);
                }
                $task_assign_to_userid = $this->ProjectUser->find('list', array('conditions' => array('company_id' => SES_COMP, 'project_id' => $project_id), 'fields' => 'user_id'));
                $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => 'email'));
                //$milestone_arr = unserialize($this->data['milestone_arr']);
            }
            $task_arr = array();
            $con_val = 'allproject';
            $non_created_proj = array();
            $proj_sts_array = array();
            $proj_stsgrp_array = array();
            if (trim($this->data['new_file_name']) != '') {
                if (($handle = fopen(CSV_PATH . "task_milstone/" . trim($this->data['new_file_name']), "r")) !== false) {
                    $i = 0;
                    $j = 0;
                    $separator = ',';
                    $chk_coma = $data = fgetcsv($handle, 1000, ",");
                    if (count($chk_coma) == 1 && stristr($chk_coma[0], ";")) {
                        $separator = ';';
                    }
                    rewind($handle);
                    $project_list = array();
                    $j = 0;
                    while (($data = fgetcsv($handle, 1000, $separator)) !== false) {
                        if (!$i) {
                            // Check for column count
                            if (count($data) >= 1) {
                                $fileds = $data;
                                foreach ($data as $key => $val) {
                                    $header_arr[strtolower($val)] = $key;
                                }
                            }
                        } else {
                            // Verifing data
                            if ($pro_id != 'all' && (strlen($data[$header_arr['title']]) != 0 || strlen($data[$header_arr['task title']]) != 0)) {
                                $value = $data;
                            } elseif ($pro_id == 'all' && (strlen($data[$header_arr['project']]) != 0 || strlen($data[$header_arr['project name']]) != 0) && (strlen($data[$header_arr['title']]) != 0 || strlen($data[$header_arr['task title']]) != 0)) {
                                $value = $data;
                            } else {
                                continue;
                            }
                            /* Parent Logic by SSL */
                            if ($pro_id!='all') {
                                if (!empty($value[$header_arr['parent']])) {
                                    if (array_key_exists($value[$header_arr['parent']], $subtask)) {
                                        $subtask[$value[$header_arr['task#']]] = $subtask[$value[$header_arr['parent']]]+1;
                                    } else {
                                        $subtask[$value[$header_arr['task#']]] = 1;
                                    }

                                    $subtask1[$value[$header_arr['task#']]] = $value[$header_arr['parent']];
                                }
                            } else {
                                if (!empty($value[$header_arr['project']])) {
                                    $projectname = strtolower($value[$header_arr['project']]);
                                    if (!empty($value[$header_arr['parent']])) {
                                        if (array_key_exists($projectname.'@@@'.$value[$header_arr['parent']], $subtask)) {
                                            $subtask[$projectname.'@@@'.$value[$header_arr['task#']]] = $subtask[$projectname.'@@@'.$value[$header_arr['parent']]] + 1;
                                        } else {
                                            $subtask[$projectname.'@@@'.$value[$header_arr['task#']]] = 1;
                                        }
                                        $subtask1[$projectname.'@@@'.$value[$header_arr['task#']]] = $value[$header_arr['parent']];
                                    }
                                } elseif (!empty($value[$header_arr['project name']])) {
                                    $projectname = strtolower($value[$header_arr['project name']]);
                                    if (!empty($value[$header_arr['parent']])) {
                                        if (array_key_exists($projectname.'@@@'.$value[$header_arr['parent']], $subtask)) {
                                            $subtask[$projectname.'@@@'.$value[$header_arr['task#']]] = $subtask[$projectname.'@@@'.$value[$header_arr['parent']]] + 1;
                                        } else {
                                            $subtask[$projectname.'@@@'.$value[$header_arr['task#']]] = 1;
                                        }
                                        $subtask1[$projectname.'@@@'.$value[$header_arr['task#']]] = $value[$header_arr['parent']];
                                    }
                                }
                            }
                            /* End */
                            $assign_to = !empty($value[$header_arr['assigned to']]) ? $value[$header_arr['assigned to']] : '';
                            if ((isset($value[$header_arr['title']]) && trim($value[$header_arr['title']])) || (isset($value[$header_arr['task title']]) && trim($value[$header_arr['task title']]) && $value[$header_arr['task#']] != 'Export Date' && $value[$header_arr['task#']] != 'Total')) {
                                if ($value[$header_arr['task#']] == 'Export Date' || $value[$header_arr['task#']] == 'Total') {
                                    continue;
                                }
                                foreach ($value as $k => $v) {
                                    if (strtolower($fileds[$k]) == 'tasks#') {
                                        continue;
                                    }
                                    $mb_detect_chk = 0;
                                    if (strtolower($fileds[$k]) == 'project' && mb_detect_encoding(utf8_encode($v), mb_detect_order(), true) == 'UTF-8') {
                                        $mb_detect_chk = 1;
                                        $v = utf8_encode($v);
                                        $task_ass[(strtolower($fileds[$k]) == 'sprint' || strtolower($fileds[$k]) == 'sprint/taskgroup')?'taskgroup':strtolower($fileds[$k])] = $v;
                                    } else {
                                        $task_ass[(strtolower($fileds[$k]) == 'sprint' || strtolower($fileds[$k]) == 'sprint/taskgroup')?'taskgroup':strtolower($fileds[$k])] = $v;
                                    }
                                    if ((strtolower($fileds[$k]) == 'project' || strtolower($fileds[$k]) == 'project name') && !empty($v)) {
                                        $project_id_t = $this->Project->getProjectId($v, $mb_detect_chk, 1);
                                        if (!empty($project_id_t)) {
                                            $project_id_tt = explode('__', $project_id_t);
                                            $project_id1 = $project_id_tt[0];
                                            if ($assign_to) {
                                                $this->checkUser($project_id1, $assign_to);
                                            }
                                            $project_list[$j] = $project_id1;
                                            $project_list_data[trim(strtolower($v))] = $project_id1;
                                            $j++;
                                            if (!isset($proj_stsgrp_array[$project_id1])) {
                                                $proj_stsgrp_array[$project_id1] = $project_id_tt[1];
                                            }
                                            /*if(isset($proj_sts_array[$project_id1])){
                                                array_push($proj_sts_array[$project_id1], $value[$header_arr['status']]);
                                            }else{
                                                $proj_sts_array[$project_id1] = array($value[$header_arr['status']]);
                                            }*/
                                        } else {
                                            /* check no of project restriction for the company * */
                                            $this->loadModel('UserSubscription');
                                            $chk_subsc = $this->UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
                                            $totProj = $this->Project->find('count', array('conditions' => array('Project.company_id' => SES_COMP), 'fields' => 'DISTINCT Project.id'));
                                            /* end */
                                            if ($chk_subsc['UserSubscription']['project_limit'] == 'Unlimited' || ($totProj && $totProj < $chk_subsc['UserSubscription']['project_limit'])) {
                                                $proId = $this->createProject($v, $assign_to);
                                                $project_list[$j] = $proId;
                                                $project_list_data[trim(strtolower($v))] = $proId;
                                                $j++;
                                                if (isset($proj_sts_array[$proId])) {
                                                    array_push($proj_sts_array[$proId], $value[$header_arr['status']]);
                                                } else {
                                                    $proj_sts_array[$proId] = array($value[$header_arr['status']]);
                                                }
                                            } else {
                                                $non_created_proj[] = $v;
                                            }
                                        }
                                        if ($pro_id != 'all') {
                                            $con_val = 'sproject';
                                        }
                                    }
                                }
                                $task_arr[] = $task_ass;
                            }
                        }
                        $i++;
                    }
                    fclose($handle);
                }
            }
            if ($pro_id != 'all') {
                $project_list = null;
                $project_list[0] = $project_id;
            }
            if (!empty($subtask1)) {
                if ($pro_id!='all') {
                    $subtasknotallow = $subtasknotallow1 = $this->Format->checkmultilabel($subtask1);
                } else {
                    $subtasknotallow = $subtasknotallow1 = $this->Format->checkmultilabel($subtask1, 'all');
                }
            }
            if (!empty($subtasknotallow)) {
                $response['status']='failed';
                $response['taskIds'] = implode(',', array_keys($subtasknotallow));
                //$this->Session->write("ERROR", $response['taskIds'].__(" case no cannot be the subtask of another", true));
                $this->Session->write("ERROR", __('Wrong assignment of parent task')." ".implode(',', array_unique($subtasknotallow))." ".__('for the tasks of task#')." ".$response['taskIds'].". ".__("Please verify and upload again.", true));
                $this->redirect(HTTP_ROOT . "projects/importexport/");
            }
            // if(!empty($proj_sts_array)){
            // 	$res_stst = $this->checkValidprojectStstus($proj_sts_array);
            // 	if(!$res_stst['status']){
            // 		$this->Session->write("ERROR", $res_stst['msg']);
            // 		$this->redirect(HTTP_ROOT . "projects/importexport");
            // 		exit;
            // 	}
            // }
            //check custom status
            $allStst = $this->Format->getStatusByProject('all');
            $sts_arr = $this->Format->getCustomTaskStatus(-1);
            $allStsNmId = Hash::combine($sts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus.name');
            $proj_with_custom = array();
            $proj_with_custom_grp = array();
            if ($allStst) {
                $proj_with_custom = Hash::extract($allStst, '{n}.Project.id');
                $proj_with_custom_grp = Hash::combine($allStst, '{n}.Project.id', '{n}.StatusGroup');
            }

            $project_list = array_unique($project_list);
            if (!empty($project_list_data)) {
                $project_list_data = array_unique($project_list_data);
            }
            $project_name = array();
            $asigne_users_list = null;
            $array_milston_ids = array();
            foreach ($project_list as $pkey => $pval) {
                $project_name[trim(strtolower($this->Format->getProjectName($pval)))] = $this->Format->getProjectName($pval);
                $task_assign_to_userid = $this->ProjectUser->find('list', array('conditions' => array('company_id' => SES_COMP, 'project_id' => $pval), 'fields' => 'user_id'));
                $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid), 'fields' => 'email'));
                if (!$asigne_users_list) {
                    $asigne_users_list = $task_assign_to_users;
                } else {
                    foreach ($task_assign_to_users as $uk => $uv) {
                        if (!in_array(trim($uv), $asigne_users_list)) {
                            $asigne_users_list[$uk] = trim($uv);
                        }
                    }
                }
                if (!empty($asigne_users_list)) {
                    $asigne_users_list = array_unique($asigne_users_list);
                }

                $this->loadModel('Milestone');
                //$this->loadModel('EasycaseMilestone');
                $EasycaseMilestone = ClassRegistry::init('EasycaseMilestone');
                $EasycaseMilestone->recursive = -1;
                //Get the Case no. for the existing projects
                $caseNoArr = $this->Easycase->find('first', array('conditions' => array('Easycase.project_id' => $pval), 'fields' => array('MAX(Easycase.case_no) as caseno')));
                $caseNo = $caseNoArr[0]['caseno'] + 1;
                $project_list_data[$pval] = $caseNo; //set case no
                $hind = 0;
                // Preparing history data
//            $history[$hind++]['total_task'] = count($task_arr);
//            $total_valid_rows = $total_valid_rows ? ($total_valid_rows + count($task_arr)) : count($task_arr);
                //print_r(trim(strtolower($this->Format->getProjectName($pval))));exit;
                if ($pro_id != 'all') {
                    $task_arr_1 = $task_arr;
                } else {
                    $task_arr_1 = array();
                    foreach ($task_arr as $karr =>$varr) {
                        if (trim(strtolower($varr['project'])) == trim(strtolower($this->Format->getProjectName($pval)))) {
                            $task_arr_1[] = $varr;
                        }
                    }
                }
                
                $results_titles = Hash::extract($task_arr_1, '{n}.taskgroup');
                if (empty($results_titles)) {
                    $results_titles = Hash::extract($task_arr_1, '{n}.task group');
                }
                $results_titles = array_values(array_filter($results_titles));
                if (!empty($results_titles)) {
                    $results_titles = array_unique($results_titles);
                    $exist_milestones = $this->Milestone->find('list', array('conditions' => array('Milestone.title' => $results_titles, 'Milestone.project_id' => $pval, 'Milestone.company_id' => SES_COMP), 'fields' => array('Milestone.id', 'Milestone.title')));
                    foreach ($results_titles as $key => $val) {
                        $milestone = array();
                        if (!in_array(trim($val), $exist_milestones)) {
                            $milestone['title'] = trim($val);
                            $milestone['description'] = '';
                            $milestone['project_id'] = $pval;
                            $milestone['user_id'] = SES_ID;
                            $milestone['company_id'] = SES_COMP;
                            $milestone['uniq_id'] = $this->Format->generateUniqNumber();
                            $this->Milestone->create();
                            $this->Milestone->save($milestone);
                            $milestone_last_insert_id = $this->Milestone->getLastInsertID();
                            $array_milston_ids[$pval][$milestone['title']] = $milestone_last_insert_id;
                        } else {
                            $milestone_last_insert_id = array_search(trim($val), $exist_milestones);
                            if (!in_array($milestone_last_insert_id, $array_milston_ids)) {
                                $array_milston_ids[$pval][trim($val)] = $milestone_last_insert_id;
                            }
                        }
                    }
                }
            }
            $default = 1;
            $milestone_id = '';
            $non_existing_typ = null;
            $non_existing_typ_with = null;
            $no_task = 0;
            foreach ($task_arr as $k => $v) {
                $easycase = null;
                $csv_pro_name = !empty($v['project']) ? trim(strtolower($v['project'])) : '';
                $csv_pro_name = empty($csv_pro_name) ? trim(strtolower($v['project name'])) : $csv_pro_name;
                $projectId = !empty($project_list_data[$csv_pro_name]) ? $project_list_data[$csv_pro_name] : '';
                $project_id = !empty($project_id) ? $project_id : '';
                $map = array(
                    "allproject" => $project_id == $projectId || $pro_id != 'all',
                    "sproject" => $project_id == $projectId && $pro_id != 'all'
                );
                if ($pro_id == 'all') {
                    $pro_name = !empty($project_name[$csv_pro_name]) ? trim(strtolower($project_name[$csv_pro_name])) : '';
                    $map = array(
                        "allproject" => $pro_name == $csv_pro_name || $pro_id != 'all',
                        "sproject" => $projectId == $projectId && $pro_id != 'all'
                    );
                }
                if ($map[$con_val]) {
                    $pval = !empty($projectId) ? $projectId : $project_id;
                    if ((isset($v['taskgroup']) && trim($v['taskgroup']) || isset($v['task group']) && trim($v['task group'])) && strtolower(trim($v['taskgroup'])) != 'default') {
                        $default = 0;
                        $milestone_id = !empty($array_milston_ids[$pval][trim($v['taskgroup'])]) ? $array_milston_ids[$pval][trim($v['taskgroup'])] : '';
                        $milestone_id = empty($milestone_id) ? $array_milston_ids[$pval][trim($v['task group'])] : $milestone_id;
                    } elseif ($k == 0 && (trim($v['taskgroup']) == '' || trim($v['task group']) == '')) {
                        $default = 1;
                    } elseif (strtolower(trim($v['taskgroup'])) == 'default' || strtolower(trim($v['task group'])) == 'default') {
                        $default = 1;
                    }
                    $task_data_arr = array();
                    $task_data_arr = $this->Easycase->find('list', array('fields' => array('Easycase.id', 'Easycase.title'), 'conditions' => array('Easycase.project_id' => $pval, 'Easycase.istype' => 1)));
                    if (!empty($task_data_arr)) {
                        $task_data_arr = array_flip($task_data_arr);
                        $task_data_arr = array_change_key_case($task_data_arr, CASE_LOWER);
                    }
                    if (!trim($v['title']) && !trim($v['task title'])) {
                        continue;
                    }
                    $title = !empty($v['title']) ? $this->Format->contains_any_multibyte($v['title']) ? utf8_encode($v['title']) :utf8_encode($v['title'])  : '';
                    $easycase['title'] = empty($title) ? $v['task title'] : $title;
                    $easycase['title'] = substr($easycase['title'], 0, 240);
                    if (empty($easycase['title'])) {
                        continue;
                    }
                    $task_id = $task_data_arr[trim(strtolower($title))];
                    // if(!empty($task_id)){
                    //    $easycase['id'] = $task_id;
                    // }
                    $easycase['message'] = (isset($v['description']) && $v['description']) ? utf8_encode($v['description']) : '';
                    $start_date = (isset($v['start date']) && $v['start date']) ? $v['start date'] : '';
                    $due_date = (isset($v['due date']) && $v['due date']) ? $v['due date'] : '';
                    //$this->Format->isValidDateTime($due_date);
                    if ($start_date) {
                        if (stristr($start_date, "-")) {
                            $start_date = str_replace("-", "/", $start_date);
                        }
                        $start_date = $this->Format->isValidDateTime($start_date) ? date('Y-m-d', strtotime($start_date)) : '';
                    }
                    if ($due_date) {
                        if (stristr($due_date, "-")) {
                            $due_date = str_replace("-", "/", $due_date);
                        }
                        $due_date = $this->Format->isValidDateTime($due_date) ? date('Y-m-d', strtotime($due_date)) : '';
                    }
                    $easycase['gantt_start_date'] = $start_date;
                    $easycase['due_date'] = $due_date;
                    if (!isset($v['status'])) {
                        $ret_sts_arr = $this->Format->getValidprojectStstus($proj_with_custom_grp, '', $pval);
                        $legend = $ret_sts_arr[0];
                    } else {
                        $ret_sts_arr = $this->Format->getValidprojectStstus($proj_with_custom_grp, $v['status'], $pval);
                        $legend = $ret_sts_arr[0];
                    }
                    $easycase['legend'] = $legend;
                    $easycase['custom_status_id'] = $ret_sts_arr[1];
                    if (!isset($v['type']) && !isset($v['task type'])) {
                        if (isset($GLOBALS['TYPE'])) {
                            $easycase['type_id'] = isset($GLOBALS['TYPE'][0]) ? $GLOBALS['TYPE'][0]['Type']['id'] : $GLOBALS['TYPE'][1]['Type']['id'];
                        } else {
                            $easycase['type_id'] = 2;
                        }
                    } else {
                        if (isset($v['type'])) {
                            $t_tak_typ = $this->get_type_id($v['type']);
                        } else {
                            $t_tak_typ = $this->get_type_id($v['task type']);
                        }
                        if (stristr($t_tak_typ, "___")) {
                            $t_tak_typ_t = explode('___', $t_tak_typ);
                            $easycase['type_id'] = $t_tak_typ_t[0];
                            if (!$non_existing_typ_with) {
                                $non_existing_typ_with = $t_tak_typ_t[2];
                            }
                            if (!$non_existing_typ) {
                                $non_existing_typ = array($t_tak_typ_t[1]);
                            } else {
                                if (!in_array($t_tak_typ_t[1], $non_existing_typ)) {
                                    array_push($non_existing_typ, $t_tak_typ_t[1]);
                                }
                            }
                        } else {
                            $easycase['type_id'] = $t_tak_typ;
                        }
                    }
                    if (!isset($v['assigned to'])) {
                        $easycase['assign_to'] = 0;
                    } else {
                        if (strtolower($v['assigned to']) != 'me' && $v['assigned to']) {
                            if (!empty($asigne_users_list) && array_search($v['assigned to'], $asigne_users_list)) {
                                $easycase['assign_to'] = array_search($v['assigned to'], $asigne_users_list);
                            } else {
                                $easycase['assign_to'] = 0;
                            }
                        } else {
                            $easycase['assign_to'] = 0;
                        }
                    }

                    if (!empty($v['created date'])) {
                        $created_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i', strtotime($v['created date'])), "datetime");
                    } else {
                        $created_date = GMT_DATETIME;
                    }
                    if (!empty($v['updated date'])) {
                        $updated_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i', strtotime($v['updated date'])), "datetime");
                    } else {
                        $updated_date = GMT_DATETIME;
                    }
                    $easycase['project_id'] = $pval;
                    if (!isset($v['created by'])) {
                        $easycase['user_id'] = (isset($user_list[trim($v['created by'])]) && !empty($user_list[trim($v['created by'])])) ? $user_list[trim($v['created by'])] : SES_ID;
                    } else {
                        if (strtolower($v['created by']) != 'me' && $v['created by']) {
                            if (!empty($asigne_users_list) && array_search($v['created by'], $asigne_users_list)) {
                                $easycase['user_id'] = array_search($v['user_id'], $asigne_users_list);
                            } else {
                                //$easycase['assign_to'] = SES_ID;
                                $easycase['user_id'] = SES_ID;
                            }
                        } else {
                            $easycase['user_id'] = SES_ID;
                            //$easycase['assign_to'] = SES_ID;
                        }
                    }
//                $easycase['user_id'] = $user_list[trim($v['created by'])];
                    $easycase['user_id'] = (isset($user_list[trim($v['created by'])]) && !empty($user_list[trim($v['created by'])])) ? $user_list[trim($v['created by'])] : SES_ID;
                    $pror = 2 ;
                    if (isset($v['priority'])) {
                        if (strtolower($v['priority']) == 'high') {
                            $pror = 0;
                        } elseif (strtolower($v['priority']) == 'medium') {
                            $pror = 1 ;
                        }
                    }
                    /* Save Labels logic */
                    $labels = array();
                    $allLabels = array();
                    if (isset($v['label']) && trim($v['label'])) {
                        $this->loadModel('Label');
                        $allLabels = $this->Label->find('list', array('fields' => array('Label.id', 'Label.lbl_title'), 'conditions' => array('Label.company_id' => SES_COMP,'Label.project_id'=>array($pval,0))));
                        if (!empty($allLabels)) {
                            $allLabels = array_flip($allLabels);
                            $allLabels = array_change_key_case($allLabels, CASE_LOWER);
                        }
                        $labels_tmp = explode("|", $v['label']);
                        foreach ($labels_tmp as $k=>$v1) {
                            if ($allLabels[strtolower($v1)]) {
                                $labels[strtolower($v1)] = $allLabels[strtolower($v1)];
                            } else {
                                $larr['lbl_title'] = $v1;
                                $larr['company_id'] = SES_COMP;
                                $larr['user_id'] = SES_ID;
                                $larr['project_id'] = $pval;
                                $larr['is_active'] = 1;
                                $this->Label->create();
                                $this->Label->save($larr);
                                $labels[strtolower($v1)] = $this->Label->getLastInsertID();
                            }
                        }
                    }
                     

                    /* End Get All labels */
                    $easycase['priority'] = $pror;
                    $caseNo_t = $project_list_data[$pval]++;
                    $easycase['case_no'] = $this->Easycase->checkvalidCaseno($pval, $caseNo_t);
                    $easycase['uniq_id'] = $this->Format->generateUniqNumber();
                    $easycase['actual_dt_created'] = $created_date;
                    $easycase['dt_created'] = $updated_date;
                    $easycase['isactive'] = 1;
                    $easycase['format'] = 2;
                    if (isset($v['estimated hour'])) {
                        $estimated_hours = trim($v['estimated hour']);
                        if ($estimated_hours != '' && $this->Format->isValidDateHours($estimated_hours, 0, 1)) {
                            if (strpos($estimated_hours, ':') > -1) {
                                $split_est = explode(':', $estimated_hours);
                                $est_sec = ((($split_est[0]) * 60) + intval($split_est[1])) * 60;
                            } else {
                                $est_sec = $estimated_hours * 3600;
                            }
                            $easycase['estimated_hours'] = $est_sec;
                        } else {
                            $easycase['estimated_hours'] = 0;
                        }
                    } else {
                        $easycase['estimated_hours'] = 0;
                    }
                    $this->Easycase->create();
                    $sid = $this->Easycase->save($easycase);
                    $easycase_inserted_ids[$sid['Easycase']['project_id']][$v['task#']]= $sid['Easycase']['id'];
                    $easycase_inserted_parents[$sid['Easycase']['project_id']][$sid['Easycase']['id']]= $v['parent'];
                    $no_task++;
                    $history[$hind++]['total_task'] = $no_task;
                    $total_valid_rows = $no_task;
//                    $total_valid_rows = $total_valid_rows ? ($total_valid_rows + $no_task) : $no_task;
                    $current_id = $this->Easycase->getLastInsertID();
                    // if (empty($task_id)) {
                    //     $current_id = $this->Easycase->getLastInsertID();
                    // } else {
                    //     $current_id = $task_id;
                    // }
                    /* Save labels */
                    if (!empty($labels)) {
                        $this->loadModel('EasycaseLabel');
                        foreach ($labels as $k=>$v1) {
                            $lbb['easycase_id'] = $current_id;
                            $lbb['label_id'] = $v1;
                            $lbb['company_id'] = SES_COMP;
                            $lbb['project_id'] = $easycase['project_id'];
                            $this->EasycaseLabel->create();
                            $this->EasycaseLabel->save($lbb);
                        }
                    }

                    /* End */
                    /** Save the resourc availability data */
                    $RA = array(
                            'caseId'=>$current_id,
                            'caseUniqId'=>$easycase['uniq_id'],
                            'projectId'=>$easycase['project_id'],
                            'assignTo'=>$easycase['assign_to'],
                            'str_date'=>$easycase['gantt_start_date'],
                            'CS_due_date'=>$easycase['due_date'],
                            'est_hr'=>$v['estimated hour']
                        );
                    if ($easycase['legend'] !=3 && $easycase['assign_to'] && ((!empty($RA['str_date']) && !empty($RA['est_hr']) && trim($RA['est_hr']) != '00:00' && trim($RA['est_hr']) != '0:00' && trim($RA['est_hr']) != '00:0' && trim($RA['est_hr']) != '0:0') || (!empty($RA['str_date']) && !empty($RA['CS_due_date'])))) {
                        $RES = $this->Format->overloadUsersUpdted($RA);
                    }
                    /* End */
                    if (!$default && $milestone_id != '') {
                        $EasycaseMiles = array();
                        $EasycaseMiles['easycase_id'] = $current_id;
                        $EasycaseMiles['milestone_id'] = $milestone_id;
                        $EasycaseMiles['project_id'] = $pval;
                        $EasycaseMiles['user_id'] = SES_ID;
                        $EasycaseMiles['dt_created'] = GMT_DATETIME;
                        $EasycaseMilestone->create();
                        $EasycaseMilestone->save($EasycaseMiles);
                    }
                    if ($current_id && isset($v['start time']) && $this->Format->isValidTlDateHours($v['start time'], 1) && isset($v['end time']) && $this->Format->isValidTlDateHours($v['end time'], 1)) {
                        $task_is_billabe = array(0, 1);
                        $logdata['start_time'] = trim($v['start time']);
                        $logdata['end_time'] = trim($v['end time']);
                        $logdata['break_time'] = isset($v['break time']) ? trim($v['break time']) : 0;
                        if (!$this->Format->isValidDateHours($logdata['break_time'])) {
                            $logdata['break_time'] = 0;
                        }
                        if (isset($v['is billable'])) {
                            $logdata['is_billable'] = in_array(trim($v['is billable']), $task_is_billabe) ? $v['is billable'] : 0;
                        } else {
                            $logdata['is_billable'] = 0;
                        }
                        if ($logdata['start_time'] != '' && $logdata['end_time'] != '') {
                            $this->loadModel('LogTime');
                            /* utc has been converted to users time zone */
                            $task_date = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "date");
                            $i = 0;
                            $LogTime = array();
                            $LogTime[$i]['task_id'] = $current_id;

                            $LogTime[$i]['project_id'] = $pval;
                            $LogTime[$i]['user_id'] = $easycase['assign_to'];
                            $LogTime[$i]['task_status'] = $legend;
                            $LogTime[$i]['ip'] = $_SERVER['REMOTE_ADDR'];

                            /* start time set start */
                            $start_time = $logdata['start_time'];
                            $spdts = explode(':', $start_time);

                            #converted to min
                            if ((strpos($start_time, 'am') === false) && (strpos($start_time, 'AM') === false)) {
                                $nwdtshr = ($spdts[0] != 12) ? ($spdts[0] + 12) : $spdts[0];
                                if ((strpos($start_time, 'PM'))) {
                                    $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'PM', true)) . ":00";
                                } else {
                                    $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'pm', true)) . ":00";
                                }
                            } else {
                                $nwdtshr = ($spdts[0] != 12) ? ($spdts[0]) : '00';
                                if ((strpos($start_time, 'AM'))) {
                                    $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'AM', true)) . ":00";
                                } else {
                                    $dt_start = trim(strstr($nwdtshr . ":" . $spdts[1], 'am', true)) . ":00";
                                }
                            }
                            $minute_start = ($nwdtshr * 60) + $spdts[1];

                            /* start time set end */

                            /* end time set start */
                            $end_time = $logdata['end_time'];
                            $spdte = explode(':', $end_time);
                            #converted to min
                            if ((strpos($end_time, 'am') === false) && (strpos($end_time, 'AM') === false)) {
                                $nwdtehr = ($spdte[0] != 12) ? ($spdte[0] + 12) : $spdte[0];
                                $dt_end = strstr($nwdtehr . ":" . $spdte[1], 'pm', true) . ":00";
                                if ((strpos($end_time, 'PM'))) {
                                    $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'PM', true)) . ":00";
                                } else {
                                    $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'pm', true)) . ":00";
                                }
                            } else {
                                $nwdtehr = ($spdte[0] != 12) ? ($spdte[0]) : '00';
                                if ((strpos($end_time, 'AM'))) {
                                    $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'AM', true)) . ":00";
                                } else {
                                    $dt_end = trim(strstr($nwdtehr . ":" . $spdte[1], 'am', true)) . ":00";
                                }
                            }
                            $minute_end = ($nwdtehr * 60) + $spdte[1];
                            /* end time set end */

                            /* checking if start is greater than end then add 24 hr in end i.e. 1440 min */
                            $duration = $minute_end >= $minute_start ? ($minute_end - $minute_start) : (($minute_end + 1440) - $minute_start);
                            $task_end_date = $minute_end >= $minute_start ? $task_date : date('Y-m-d', strtotime($task_date . ' +1 day'));

                            /* total working */
                            $totalbreak = trim($logdata['break_time']) != '' ? $logdata['break_time'] : '0';
                            $break_time = trim($totalbreak);
                            if (strpos($break_time, '.')) {
                                $split_break = $break_time * 60;
                                $break_hour = (intval($split_break / 60) < 10 ? "0" : "") . intval($split_break / 60);
                                $break_min = (intval($split_break % 60) < 10 ? "0" : "") . intval($split_break % 60);
                                $break_time = $break_hour . ":" . $break_min;
                                $minute_break = ($break_hour * 60) + $break_min;
                            } elseif (strpos($break_time, ':')) {
                                $split_break = explode(':', $break_time);
                                #converted to min
                                $minute_break = ($split_break[0] * 60) + $split_break[1];
                            } else {
                                $break_time = $break_time . ":00";
                                $minute_break = $break_time * 60;
                            }
                            $minute_break = $duration < $minute_break ? 0 : $minute_break;
                            /* break ends */

                            /* total hrs start */
                            $total_duration = $duration - $minute_break;
                            $total_hours = $total_duration;
                            /* total hrs end */

                            $LogTime[$i]['task_date'] = $task_date;
                            $LogTime[$i]['start_time'] = $dt_start;
                            $LogTime[$i]['end_time'] = $dt_end;

                            /* required to convert the date to utc as we are taking converted server date to save */
                            #converted to UTC
                            $LogTime[$i]['start_datetime'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_date . " " . $dt_start, "datetime");
                            $LogTime[$i]['end_datetime'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_end_date . " " . $dt_end, "datetime");

                            #stored in sec
                            $LogTime[$i]['break_time'] = $minute_break * 60;
                            $LogTime[$i]['total_hours'] = $total_hours * 60;

                            $LogTime[$i]['is_billable'] = $logdata['is_billable'];
                            $LogTime[$i]['description'] = strip_tags(addslashes(trim($CS_message)));

                            #pr($LogTime);exit;
                            if ($LogTime[0]['user_id']) {
                                $this->LogTime->saveAll($LogTime);
                            }
                        }
                    }
                }
            }
//        }
            $project_name = array_unique($project_name);
            if (!empty($project_name)) {
                $numItems = count($project_name);
                $k = 0;
                $pro_name = '';
                $pro_name_last = '';
                foreach ($project_name as $key => $value) {
                    if (!empty($value)) {
                        if (++$k === $numItems && count($project_name) > 1) {
                            $pro_name_last = ' and ' . $value;
                        } else {
                            $pro_name .= $value . ',';
                        }
                    }
                }
            }
            if (!empty($total_valid_rows)) {
                $this->Session->delete('csvimportflag');
            }
            $pro_name = trim($pro_name, ',') . $pro_name_last;
            $total_task = $this->data['total_rows'] - 1;
            $this->set('total_valid_rows', $total_valid_rows);
            $this->set('csv_file_name', $this->data['csv_file_name']);
            $this->set('total_rows', $total_task);
            $this->set('newtotal_task', $no_task);
            $this->set('proj_name', !empty($this->Format->getProjectName($project_id)) ? $this->Format->getProjectName($project_id) : $pro_name);
            $this->set('history', $history);
            $this->set('non_existing_typ_with', $non_existing_typ_with);
            $this->set('non_existing_typ', $non_existing_typ);
            if ($non_created_proj > 0) {
                $this->set('non_create_projects', implode(",", array_unique($non_created_proj)));
            }
            foreach ($easycase_inserted_parents as $key => $val) {
                if ($val) {
                    foreach ($val as $k=>$v) {
                        if (array_key_exists($key, $easycase_inserted_ids)) {
                            if (!empty($v) && !empty($easycase_inserted_ids[$key][$v]) && $easycase_inserted_ids[$key][$v] != $k) {
                                //  print "UPDATE easycases SET parent_task_id = ".$easycase_inserted_ids[$key][$v]." WHERE id=".$k."<br/>1";
                                $this->loadModel('EasycaseMilestone');
                                $pr_easy_case_details = $this->EasycaseMilestone->find('first', array('conditions' => array('EasycaseMilestone.easycase_id' =>$easycase_inserted_ids[$key][$v],'EasycaseMilestone.project_id' =>$project_id)));
                                $prev_mile_id=!empty($pr_easy_case_details['EasycaseMilestone']['milestone_id'])?$pr_easy_case_details['EasycaseMilestone']['milestone_id']:0;
                                $sub_mile_details = $this->EasycaseMilestone->find('first', array('conditions' => array('EasycaseMilestone.easycase_id' =>$k,'EasycaseMilestone.project_id' =>$project_id)));
                                $sub_mile_id=!empty($sub_mile_details['EasycaseMilestone']['milestone_id'])?$sub_mile_details['EasycaseMilestone']['milestone_id']:0;
                                if ($prev_mile_id==$sub_mile_id) {
                                    $this->Easycase->query("UPDATE easycases SET parent_task_id = ".$easycase_inserted_ids[$key][$v]." WHERE id=".$k);
                                }
                            } else {
                                if ($v) {
                                    $prnt_id = array();
                                    $prnt_id = $this->Easycase->find("first", array("conditions"=>array("Easycase.project_id"=>$key,"Easycase.case_no" =>$v,"Easycase.istype"=>1)));
                                    //  echo "<pre>1";print_r($prnt_id);
                                    //  echo "<pre>";print_r(array("conditions"=>array("Easycase.project_id"=>$key,"Easycase.case_no" =>$v,"Easycase.istype"=>1)));
                                    if ($prnt_id) {
                                        if ($prnt_id['Easycase']['id'] != $k) {
                                            //  print "UPDATE easycases SET parent_task_id = ".$prnt_id['Easycase']['id']." WHERE id=".$k."<br/>2";
                                            $this->Easycase->query("UPDATE easycases SET parent_task_id = ".$prnt_id['Easycase']['id']." WHERE id=".$k);
                                        }
                                    }
                                }
                            }
                        } else {
                            if ($v) {
                                $prnt_id = array();
                                $prnt_id = $this->Easycase->find("first", array("conditions"=>array("Easycase.project_id"=>$key,"Easycase.case_no" =>$v,"Easycase.istype"=>1)));
                                //  echo "<pre>2";print_r($prnt_id);
                                //    echo "<pre>";print_r(array("conditions"=>array("Easycase.project_id"=>$key,"Easycase.case_no" =>$v,"Easycase.istype"=>1)));
                                if ($prnt_id) {
                                    if ($prnt_id['Easycase']['id'] != $k) {
                                        //   print "UPDATE easycases SET parent_task_id = ".$prnt_id['Easycase']['id']." WHERE id=".$k."<br/>3";
                                        $this->Easycase->query("UPDATE easycases SET parent_task_id = ".$prnt_id['Easycase']['id']." WHERE id=".$k);
                                    }
                                }
                            }
                        }
                    }
                }
                /*  if(!empty($val) && !empty($easycase_inserted_ids[$val]) && $easycase_inserted_ids[$val] != $key){
                    //  print "UPDATE easycases SET parent_task_id = ".$easycase_inserted_ids[$val]." WHERE id=".$key;
                     // $this->Easycase->query("UPDATE easycases SET parent_task_id = ".$easycase_inserted_ids[$val]." WHERE id=".$key);
                  } */
            }
            $this->render('importexport');
        } else {
            $this->Session->write("ERROR", "Sorry, " . $this->data['csv_file_name'] . " already imported");
            $this->redirect(HTTP_ROOT . "projects/importexport");
            exit;
        }
        //echo $project_id; pr($milestone_arr);echo "<hr/>";pr($task_arr);exit;
    }

    public function get_type_id($type)
    {
        $type = strtolower(trim($type));
        if (isset($GLOBALS['TYPE']) && !empty($GLOBALS['TYPE'])) {
            $t_typ = '';
            foreach ($GLOBALS['TYPE'] as $k => $v) {
                if ($type == strtolower(trim($v['Type']['name']))) {
                    $t_typ = $v['Type']['id'];
                    break;
                }
            }
            if ($t_typ != '') {
                return $t_typ;
            } else {
                if (isset($GLOBALS['TYPE'][0]['Type']) && trim($GLOBALS['TYPE'][0]['Type']['id'])) {
                    return $GLOBALS['TYPE'][0]['Type']['id'] . '___' . $type . '___' . $GLOBALS['TYPE'][0]['Type']['name'];
                } else {
                    return $GLOBALS['TYPE'][1]['Type']['id'] . '___' . $type . '___' . $GLOBALS['TYPE'][1]['Type']['name'];
                }
            }
        } else {
            if ($type == 'bug') {
                return 1;
            } elseif ($type == 'enhancement' || $type == 'enh') {
                return 3;
            } elseif ($type == 'research n do' || $type == 'rnd') {
                return 4;
            } elseif ($type == 'quality assurance' || $type == 'qa') {
                return 5;
            } elseif ($type == 'unit testing' || $type == 'unt') {
                return 6;
            } elseif ($type == 'maintenance' || $type == 'mnt') {
                return 7;
            } elseif ($type == 'others' || $type == 'oth') {
                return 8;
            } elseif ($type == 'release' || $type == 'rel') {
                return 9;
            } elseif ($type == 'update' || $type == 'upd') {
                return 10;
            } else {
                return 2;
            }
        }
    }

    /**
     * @method public download_sample_tlcsvfile
     * @author Andola  <>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function download_sample_tlcsvfile()
    {
        $myFile = 'Orangescrum_timelog_Sample.csv';
        $path = CSV_PATH . "timelog_import/" . $myFile;
        $this->response->file($path, array('download' => true, 'name' => $myFile,));
        return $this->response;
        /* header('HTTP/1.1 200 OK');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Orangescrum_timelog_Sample.csv");
        readfile(CSV_PATH . "timelog_import/" . $myFile);
          exit; */
    }

    /**
     * @method public download_sample_csv_file
     * @author Andola  <>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function download_sample_csvfile()
    {
        //$myFile ='demo_sample_milestone_csv_file.csv';
        $myFile = 'Orangescrum_Import_Task_Sample.csv';
        header('HTTP/1.1 200 OK');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Orangescrum_Task_Sample.csv");
        readfile(CSV_PATH . "task_milstone/" . $myFile);
        exit;
    }

    public function download_sample_prjtemplate_csvfile()
    {
        //$myFile ='demo_sample_milestone_csv_file.csv';
        $myFile = 'Orangescrum_Import_Project_Template_Task_Sample.csv';
        header('HTTP/1.1 200 OK');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=Orangescrum_Project_Template_Task_Sample.csv");
        readfile(CSV_PATH . "project_template/" . $myFile);
        exit;
    }
    public function checktlfile_existance()
    {
        $file_info = $_FILES['file-0'];
        $file_name = SES_ID . "_timelog_" . $file_info['name'];
        //echo $file_name;exit;
        $directory = CSV_PATH . "timelog_import";
        $err = 0;
        $arr = null;
        if ($handle = opendir($directory)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (trim($file_name) == trim($entry)) {
                        $filesize = filesize($directory . '/' . $file_name);
                        if ($file_info['size'] == $filesize) {
                            $arr['msg'] = __("Already a file with same name and same size of")." " . $filesize . " ".__("bytes exists. Would you like to replace the existing file?");
                        } else {
                            $arr['msg'] = __("Already file with same name and size of")." " . $filesize . " ".__("bytes exists. Would you like to replace the existing file?");
                        }
                        $err = 1;
                        $arr['success'] = 0;
                        $arr['error'] = 1;
                    }
                }
            }
            closedir($handle);
            if (!$err) {
                $arr['success'] = 1;
                $arr['msg'] = "";
                $arr['error'] = 0;
            }
            echo json_encode($arr);
            exit;
        }
    }

    public function checkfile_existance()
    {
        $file_info = $_FILES['file-0'];
        $file_name = SES_ID . "_" . $this->data['porject_id'] . "_" . $file_info['name'];
        //echo $file_name;exit;
        $directory = CSV_PATH . "task_milstone";
        if ($handle = opendir($directory)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if ($file_name == $entry) {
                        $filesize = filesize($directory . '/' . $file_name);
                        if ($file_info['size'] == $filesize) {
                            $arr['msg'] = __("Already a file with same name and same size of")." " . $filesize ." ". __("bytes exists. Would you like to replace the existing file?");
                        } else {
                            $arr['msg'] = __("Already file with same name and size of")." " . $filesize . " ".__("bytes exists. Would you like to replace the existing file?");
                        }
                        $err = 1;
                        $arr['success'] = 0;
                        $arr['error'] = 1;
                    }
                    //echo "$entry<br/>";
                }
            }
            closedir($handle);
            if (!$err) {
                $arr['success'] = 1;
                $arr['msg'] = "";
                $arr['error'] = 0;
            }
            echo json_encode($arr);
            exit;
        }
    }

    public function checkfile_project_template_existance()
    {
        $file_info = $_FILES['file-0'];
        $file_name = SES_ID . "_" . $file_info['name'];
        #echo $file_name;exit;
        $directory = CSV_PATH . "project_template";
        if ($handle = opendir($directory)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if ($file_name == $entry) {
                        $filesize = filesize($directory . '/' . $file_name);
                        if ($file_info['size'] == $filesize) {
                            $arr['msg'] = __("Already a file with same name and same size of")." " . $filesize . " ".__("bytes exists. Please try with another file name.");
                        } else {
                            $arr['msg'] = __("Already a file with same name and size of")." " . $filesize ." ". __("bytes exists. Please try with another file name.");
                        }
                        $err = 1;
                        $arr['success'] = 0;
                        $arr['error'] = 1;
                    }
                    //echo "$entry<br/>";
                }
            }
            closedir($handle);
            if (!$err) {
                $arr['success'] = 1;
                $arr['msg'] = "";
                $arr['error'] = 0;
            }
            echo json_encode($arr);
            exit;
        } else {
            $arr['success'] = 0;
            $arr['msg'] = "";
            $arr['error'] = 1;

            echo json_encode($arr);
            exit;
        }
    }
    public function learnmore()
    {
        $this->layout = '';
    }

    public function project_thumb_view()
    {
    }

    /**
     *
     */
    public function member_list()
    {
        $this->layout = "ajax";
        $this->loadModel('User');
        $list = $this->User->get_email_list();
        if ($list) {
            foreach ($list as $key => $val) {
                if ($this->Auth->User('istype') == 3) {
                    if ($val['User']['id'] == $this->Auth->User('id')) {
                        continue;
                    }
                }
                if (trim($val['User']['email']) != '' && trim(strtolower($val['User']['email'])) != 'null') {
                    $name = "";
                    if ($val['User']['name']) {
                        $name = stripcslashes($val['User']['name']);
                    }
                    if ($val['User']['last_name']) {
                        $name .=" " . stripcslashes($val['User']['last_name']);
                    }
                    if ($name) {
                        $email[$val['User']['id']] = $name . " <" . $val['User']['email'] . ">";
                    } else {
                        $email[$val['User']['id']] = $val['User']['email'];
                    }
                }
            }
        }
        //$arr['email'] = array_unique($email);
        echo json_encode(array_unique($email));
        exit;
    }

    /**
     * @method: Public onbording($paramName) Onboarding for create project
     * @author GDR <>
     * @return  html
     */
    public function onbording()
    {
        if (SES_TYPE > 2) {
            $this->redirect(HTTP_ROOT);
            exit;
        }
        if ($_COOKIE['FIRST_LOGIN_1']) {
            $this->redirect(HTTP_ROOT . 'getting_started');
            exit;
        }

        $totalusers = 0;
        if ($GLOBALS['project_count']) {
            $CompanyUser = ClassRegistry::init('CompanyUser');
            $totalusers = $CompanyUser->find('count', array('conditions' => array('company_id' => SES_COMP, 'is_active !=' => 3)));
            if ($totalusers >= 2) {
                $this->redirect(HTTP_ROOT);
            }
        }
        setcookie('FIRST_LOGIN_1', 1, time() + (86400 * 30), '/', DOMAIN_COOKIE, false, false);
        $this->redirect(HTTP_ROOT . 'users/onBoard');
        exit;
        $this->set('totalusers', $totalusers);
        setcookie('LOAD_TW_POP', 1, time() + 3600, '/', DOMAIN_COOKIE, false, false);
        $id = $this->Auth->user('id');
        $rec = $this->User->findById($id);
        $this->set('usrdata', $rec);
        if (($rec['User']['dt_last_logout'] == '' && $rec['User']['show_default_inner'])) {
            $this->set('is_log_out', 1);
        }
    }

    public function skipOnbording()
    {
        $this->layout = 'ajax';
        $this->loadModel("Company");
        $this->Company->query("UPDATE companies SET is_skipped='1' WHERE id=" . SES_COMP);
        print 1;
        exit;
    }

    public function hide_default_inner()
    {
        $this->User->id = SES_ID;
        $this->User->saveField('show_default_inner', 0);
        echo 'success';
        exit;
    }

    /**
     * @method: Public deleteprojects($projuid) Deleting project with all associated data to that project
     * @author  GDR <>
     * @return bool true/false
     */
    public function deleteprojects($projuid = '', $page = null)
    {
        if (SES_TYPE > 2) {
            $grpcount = $this->Project->query('SELECT Project.id FROM projects AS Project WHERE Project.user_id=' . $this->Auth->user('id') . ' AND Project.uniq_id="' . $projuid . '" AND Project.company_id=' . SES_COMP . '');
            if (!$grpcount[0]['Project']['id']) {
                $this->redirect(HTTP_ROOT);
                exit;
            }
        }
        //$redirect = HTTP_ROOT . "projects/manage";
        $redirect = $_SERVER['HTTP_REFERER'];
        if (isset($page) && (intval($page) > 1)) {
            $redirect.="?page=" . $page;
        }

        if (!$projuid) {
            $this->redirect($redirect);
            exit;
        } else {
            $arr = $this->Project->deleteprojects($projuid);
            if (isset($arr['succ']) && $arr['succ']) {
                $this->loadModel('CustomFieldValue');
                $this->CustomFieldValue->deleteProjectCustomFields($projuid);
                $this->Session->write('SUCCESS', $arr['msg']);
            } elseif (isset($arr['error']) && $arr['error']) {
                $this->Session->write('ERROR', $arr['msg']);
            } else {
                $this->Session->write('ERROR', 'Oops! Error occured in deletion of project');
            }
            $this->redirect($redirect);
            exit;
        }
    }

    public function ajax_existuser_delete($data = null)
    {
        $this->layout = 'ajax';
        if ((isset($this->params->data['userid']) && $this->params->data['userid']) || $data) {
            if ($data) {
                $uid = $data['userid'];
                $projId = $data['project_id'];
            } else {
                $uid = $this->params->data['userid'];
                $projId = trim($this->params->data['project_id']);
            }
            $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));
            $checkAvlMem3 = $this->ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => $uid, 'ProjectUser.project_id' => $projId), 'fields' => 'DISTINCT ProjectUser.id'));
            if ($checkAvlMem3) {
                $this->ProjectUser->query("DELETE FROM project_users WHERE user_id=" . $uid . " AND project_id=" . $projId);
            }
            //Remove from Group update table , that user should not get mail when he is removed from a project.
            $this->loadModel('DailyUpdate');
            $DailyUpdate = $this->DailyUpdate->getDailyUpdateFields($projId, array('DailyUpdate.id', 'DailyUpdate.user_id'));
            if (isset($DailyUpdate) && !empty($DailyUpdate)) {
                $user_ids = explode(",", $DailyUpdate['DailyUpdate']['user_id']);
                if (($index = array_search($uid, $user_ids)) !== false) {
                    unset($user_ids[$index]);
                }
                $du['user_id'] = implode(",", $user_ids);
                $this->DailyUpdate->id = $DailyUpdate['DailyUpdate']['id'];
                $this->DailyUpdate->save($du);
            }
            if ($data) {
                return true;
            } else {
                echo "success";
                exit;
            }
        }
    }

    public function generateMsgAndSendPjMail($pjid, $id, $comp)
    {
        $User_id = $this->Auth->user('id');
        $rec = $this->User->findById($User_id);
        $from_name = $rec['User']['name'] . ' ' . $rec['User']['last_name'];

        App::import('helper', 'Casequery');
        $csQuery = new CasequeryHelper(new View(null));

        App::import('helper', 'Format');
        $frmtHlpr = new FormatHelper(new View(null));

        ##### get User Details
        $toUsrArr = $this->User->findById($id);
        $to_email = "";
        $to_name = "";
        if (count($toUsrArr)) {
            $to_email = $toUsrArr['User']['email'];
            $to_name = $frmtHlpr->formatText($toUsrArr['User']['name']);
        }
//
        ##### get Project Details
        $this->Project->recursive = -1;
        $prjArr = $this->Project->find('first', array('conditions' => array('Project.id' => $pjid), 'fields' => array('Project.name', 'Project.short_name', 'Project.uniq_id')));
        $projName = "";
        $projUniqId = "";
        if (count($prjArr)) {
            $projName = $frmtHlpr->formatText($prjArr['Project']['name']);
            $projUniqId = $prjArr['Project']['uniq_id'];
        }

        $subject = __("You have been added to ") . $projName . __(" on ")."Orangescrum";
        $uEmail = $this->User->getLoginUserEmail(SES_ID);
        $this->Email->delivery = 'smtp';
        $this->Email->to = $to_email;
        $this->Email->subject = $subject;
        $this->Email->from = FROM_EMAIL; //$uEmail['User']['email']; 
        $this->Email->template = 'project_add';
        $this->Email->sendAs = 'html';
        $this->set('to_name', $to_name);
        $this->set('from_name', $from_name);
        $this->set('projName', $projName);
        $this->set('projUniqId', $projUniqId);
        $this->set('multiple', 0);
        $this->set('company_name', $comp['Company']['name']);

        if (defined("PHPMAILER") && PHPMAILER == 1) {
            $this->Email->set_variables = $this->render('/Emails/html/project_add', false);
            if ($this->PhpMailer->sendPhpMailerTemplate($this->Email)) {
                return true;
            } else {
                return true;
            }
        } else {
            return $this->Sendgrid->sendgridsmtp($this->Email);
        }
    }

    public function default_inner()
    {
        $this->layout = '';
    }

    /**
     * Showing and Managing task types by company owner
     *
     * @method task_type
     * @author Sunil
     * @return
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    public function task_type()
    {
        if ($this->request->is('ajax')) {
            $this->layout='ajax';
        }
        if (SES_TYPE == 3) {
            if ($this->request->is('ajax')) {
                echo 'not_authorized';
                exit;
            } else {
                $this->redirect(HTTP_ROOT . "dashboard");
                exit;
            }
        }
        $this->loadModel("Type");
        $task_types = $this->Type->getAllTypes('list');

        $this->loadModel("TypeCompany");
        $sel_types = $this->TypeCompany->getSelTypes();
        $is_projects = 0;
        $default_task = $this->Project->getDefaultTask();
        if (isset($sel_types) && !empty($sel_types) && isset($task_types) && !empty($task_types)) {
            foreach ($task_types as $key => $value) {
                //if (array_search($value['Type']['id'], $sel_types) || intval($value['Total']['cnt'])) {
                if (array_search($value['Type']['id'], $sel_types)) {
                    $task_types[$key]['Type']['is_exist'] = 1;
                } else {
                    $task_types[$key]['Type']['is_exist'] = 0;
                }
                if (in_array($value['Type']['id'], $default_task)) {
                    $task_types[$key]['Type']['is_default'] = 1;
                } else {
                    $task_types[$key]['Type']['is_default'] = 0;
                }
            }
            $is_projects = 1;
        }
        $task_types_custom = $tt = array();
        foreach ($task_types as $k=>$v) {
            if ($v['Type']['project_id'] == 0) {
                $tt[] = $v;
            } else {
                $task_types_custom[$v['Type']['project_id']][] = $v;
            }
        }
        $task_types = $tt;

        $this->set(compact('task_types', 'task_types_custom', 'sel_types', 'is_projects'));
    }
    /**
     * Add new task types by company owner
     *
     * @method addNewTaskType
     * @author Sunil
     * @return
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    public function addNewTaskType()
    {
        if (isset($this->data['Type']) && !empty($this->data['Type'])) {
            $data = $this->data['Type'];
            $data['short_name'] = strtolower($data['short_name']);
            $data['company_id'] = SES_COMP;
            $data['seq_order'] = 0;

            $this->loadModel("Type");
            if (isset($data['id']) && $data['id']) {
            } else {
                $this->Type->id = '';
            }
            $this->Type->save($data);
            $id = $this->Type->getLastInsertID();
            if (isset($data['id']) && $data['id']) {
                $this->Session->write("SUCCESS", "Task type '" . trim($data['name']) . "' updated successfully.");
            } else {
                $this->loadModel("TypeCompany");
                //Check record exists or not while added 1st time. If not then added all default type with new one.
                $isRes = $this->TypeCompany->getTypes();
                $cnt = 0;

                if (isset($isRes) && empty($isRes)) {
                    //Getting default task type
                    $types = $this->Type->getDefaultTypes();
                    foreach ($types as $key => $values) {
                        $data1[$key]['type_id'] = $values['Type']['id'];
                        $data1[$key]['company_id'] = SES_COMP;
                        $cnt++;
                    }
                }

                $data1[$cnt]['type_id'] = $id;
                $data1[$cnt]['company_id'] = SES_COMP;
                $this->TypeCompany->saveAll($data1);
                $this->Session->write("SUCCESS", __("Task type", true)." '" . trim($data['name']) . "' ".__("added successfully", true).".");
            }
        } else {
            $this->Session->write("ERROR", __("Error in addition of task type.", true));
        }
        $this->redirect(HTTP_ROOT . "task-type");
    }

    /**
     * Add New Task Type On the fly while creating new task type
     *
     */
    public function addNewTaskTypetoDropdown()
    {
        if (isset($this->request->data) && !empty($this->request->data)) {
            $data = $this->request->data;
            $data['short_name'] = strtolower($data['short_name']);
            $data['company_id'] = SES_COMP;
            $data['seq_order'] = 0;

            $this->loadModel("Type");
            if (isset($data['id']) && $data['id']) {
            } else {
                $this->Type->id = '';
            }
            if (isset($data['id']) && $data['id']) {
                $this->Type->saveAll($data);
                $id = $data['id'];
            } else {
                if ($data['project_id'][0] == 0) {
                    $this->loadModel('Project');
                    $orderby = "ORDER BY Project.name ASC";
                    $fld = 'Project.id';
                    $sql = "SELECT DISTINCT Project.name," . $fld . " FROM projects AS Project WHERE Project.company_id='" . SES_COMP . "' AND Project.isactive='1' AND Project.name !='' " . $orderby;
                    $projects = $this->Project->query($sql);
                    foreach ($projects as $k=>$v) {
                        $datas1 = $data;
                        $datas1['project_id'] = $v['Project']['id'];
                        $datas[] = $datas1;
                    }
                } else {
                    foreach ($data['project_id'] as $k=>$v) {
                        $datas1 = $data;
                        $datas1['project_id'] = $v;
                        $datas[] = $datas1;
                    }
                }
                // print_r($datas);exit;
                if ($this->Type->saveAll($datas)) {
                    $id = $this->Type->inserted_ids;
                }
            }
            if (isset($data['id']) && $data['id']) {
                $this->Session->write("SUCCESS", "Task type '" . trim($data['name']) . "' updated successfully.");
                echo json_encode($data);
                exit;
            } else {
                $this->loadModel("TypeCompany");
                //Check record exists or not while added 1st time. If not then added all default type with new one.
                $isRes = $this->TypeCompany->getTypes();
                $cnt = 0;

                if (isset($isRes) && empty($isRes)) {
                    //Getting default task type
                    $types = $this->Type->getDefaultTypes();
                    foreach ($types as $key => $values) {
                        $data1[$key]['type_id'] = $values['Type']['id'];
                        $data1[$key]['company_id'] = SES_COMP;
                        $cnt++;
                    }
                }
                foreach ($id as $k=>$v) {
                    $data1[$cnt]['type_id'] = $v;
                    $data1[$cnt]['company_id'] = SES_COMP;
                    $cnt++;
                }

                $this->TypeCompany->saveAll($data1);
                echo json_encode($data1);
                exit;
            }
        } else {
            $this->Session->write("ERROR", __("Error in addition of task type.", true));
            exit;
        }
    }

    /**
     * Save selected task types by company owner
     *
     * @method saveTaskType
     * @author Sunil
     * @return
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    public function saveTaskType()
    {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $arr['status'] =0 ;
            $isactive =$this->data['is_active'];
            $this->loadModel("TypeCompany");
            $this->TypeCompany->query("DELETE FROM type_companies WHERE company_id=" . SES_COMP." AND type_id='".$this->data['id']."'");
            if ($isactive ==1) {
                $data['type_id'] = $this->data['id'];
                $data['company_id'] = SES_COMP;
                $data['id'] = '';
                if ($this->TypeCompany->save($data)) {
                    $arr['status'] =1 ;
                }
            } else {
                $arr['status'] =1 ;
            }
            echo json_encode($arr);
            exit;
        } else {
            if (isset($this->data['Type']) && !empty($this->data['Type'])) {
                $this->loadModel("TypeCompany");

                $this->TypeCompany->query("DELETE FROM type_companies WHERE company_id=" . SES_COMP);
                foreach ($this->data['Type'] as $key => $value) {
                    $data['company_id'] = SES_COMP;
                    $data['type_id'] = $value;

                    $this->TypeCompany->id = '';
                    $this->TypeCompany->save($data);
                }
                $this->Session->write("SUCCESS", __("Task type saved successfully.", true));
            } else {
                $this->Session->write("ERROR", __("Error in saving of task type.", true));
            }
            $this->redirect(HTTP_ROOT . "task-type");
        }
    }

    public function saveLabel()
    {
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $arr['status'] =0 ;
            $isactive =$this->data['is_active'];
            $this->loadModel("Label");
            $p = $this->Label->find('first', array('conditions'=>array('Label.id'=>$this->data['id']),'fields'=>array('Label.project_id')));
            $project_id = $p['Label']['project_id'];
            $this->Label->id = $this->data['id'];
            if ($this->Label->saveField('is_active', $isactive)) {
                $arr['status'] =1 ;
            }
            Cache::delete('label_detl_'.$project_id);
            echo json_encode($arr);
            exit;
        } else {
            if (isset($this->data['Label']) && !empty($this->data['Label'])) {
                $this->loadModel("Label");
                $this->Label->query("UPDATE labels SET is_active = 0 WHERE company_id=" . SES_COMP);
                foreach ($this->data['Label'] as $key => $value) {
                    $this->Label->query("UPDATE labels SET is_active = 1 WHERE id=".$value." AND company_id=" . SES_COMP);
                }
                Cache::delete('label_detl_'.SES_COMP);
                $this->Session->write("SUCCESS", __("Labels saved successfully.", true));
            } else {
                $this->Session->write("ERROR", __("Error in saving of Labels.", true));
            }
            $this->redirect(HTTP_ROOT . "labels");
        }
    }
    public function addTaskLabel()
    {
        if (isset($this->data) && !empty($this->data)) {
            $data = $this->data;
            $data['company_id'] = SES_COMP;
            $data['is_active'] = 1;
            $this->loadModel("Label");
            $this->loadModel("EasycaseLabel");
            $this->Label->id = '';
            $data['user_id'] = SES_ID;
            $this->Label->save($data);
            $id = $this->Label->getLastInsertID();
            $postdata['easycase_id'] = $data['task_id'];
            $postdata['project_id'] = $data['project_id'];
            $postdata['label_id'] = $id;
            $postdata['company_id'] = SES_COMP;
            $postdata['created'] = date('Y-m-d H:i:s');
            $this->EasycaseLabel->save($postdata);
            $this->Session->write("SUCCESS", __("Label", true)." '" . trim($data['lbl_title']) . "' ".__("added successfully", true).".");
            echo 1;
        } else {
            $this->Session->write("ERROR", __("Error in addition of Labele.", true));
            echo 0;
        }
        exit;
    }
    /**
     * Delete task types by company owner
     *
     * @method deleteTaskType
     * @author Sunil
     * @return boolean
     * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
     */
    public function deleteTaskType()
    {
        $this->layout = 'ajax';
        $this->loadModel("Type");
        $id = $this->params->data['id'];
        $type_data = $this->Type->getAllType($id);
        if (empty($type_data['0']['Total']['cnt'])) {
            if (intval($id)) {
                $this->Type->id = $id;
                $this->Type->delete();
                $this->loadModel("TypeCompany");
                $this->TypeCompany->query("DELETE FROM type_companies WHERE type_id=" . $id . " AND company_id=" . SES_COMP);
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
        exit;
    }

    public function validateTaskType()
    {
        $jsonArr = array('status' => 'error');
        if (!empty($this->request->data['name'])) {
            $this->loadModel("Type");
            $srt_name = '';
            if (isset($this->request->data['sort_name']) && trim($this->request->data['sort_name']) != '') {
                $srt_name = trim($this->request->data['sort_name']);
            } else {
                $srt_name = trim($this->request->data['short_name']);
            }
            if (isset($this->request->data['project_id']) && !empty($this->request->data['project_id'])) {
                //$pids = $this->request->data['project_id'];
                if (in_array('0', $this->request->data['project_id'])) {
                    $this->loadModel('Project');
                    $sql = "SELECT DISTINCT Project.id FROM projects AS Project WHERE Project.company_id='" . SES_COMP . "' AND Project.isactive='1' AND Project.name !=''";
                    $projects = $this->Project->query($sql);
                    foreach ($projects as $k=>$v) {
                        $pids[] = $v['Project']['id'];
                    }
                } else {
                    $pids = $this->request->data['project_id'];
                }
            } else {
                $p = $this->Type->find('first', array('conditions' =>array('Type.id'=>$this->request->data['id']),'fields'=>array('Type.project_id')));
                $pids[] = $p['Type']['project_id'];
            }
            $pids[] = 0;

            $count_type = $this->Type->find('first', array('conditions' => array('Type.company_id' => array(SES_COMP, 0), 'OR' => array('Type.short_name' => $srt_name, 'Type.name' => trim($this->request->data['name'])), 'Type.id !=' => trim($this->request->data['id']),'Type.project_id'=> $pids), 'fields' => array("Type.name", "Type.short_name")));
            if (!$count_type) {
                $jsonArr['status'] = 'success';
            } else {
                if (trim(strtolower($count_type['Type']['short_name'])) == strtolower($srt_name)) {
                    $jsonArr['msg'] = 'sort_name';
                }
                if (trim(strtolower($count_type['Type']['name'])) == strtolower(trim($this->request->data['name']))) {
                    $jsonArr['msg'] = 'name';
                }
            }
        }
        echo json_encode($jsonArr);
        exit;
    }

    public function addUsersToProject()
    {
        $this->layout = 'ajax';
        $getProjUsers = $this->Project->query("select User.id from project_users as ProjectUser, users as User, projects as Project where User.id=ProjectUser.user_id and Project.uniq_id='" . $this->data['projUid'] . "' and Project.id=ProjectUser.project_id and User.isactive='1'");
        $allProjUsers = array();
        if ($getProjUsers) {
            $allProjUsers = Hash::extract($getProjUsers, '{n}.User.id');
        }
        $this->set('allProjUsers', $allProjUsers);
        $this->set('proj_uniq_id', $this->data['projUid']);

        //$allUsers = $this->Project->query("select User.name,User.id,User.email from users as User where User.id IN(SELECT user_id FROM company_users WHERE company_id = ".SES_COMP." AND is_active=1)");

        $allUsers = $this->Project->query("select User.name,User.id,User.email, CompanyUser.user_type,CompanyUser.is_client,CompanyUser.is_active from users as User,company_users as CompanyUser where User.id = CompanyUser.user_id AND CompanyUser.company_id = " . SES_COMP . "  AND CompanyUser.is_active = 1 ORDER BY User.name ASC"); //AND CompanyUser.is_active=1
        if ($allUsers) {
            $allUsers = Hash::combine($allUsers, '{n}.User.id', '{n}');
        }
        $this->set('allUsers', $allUsers);

        $prj_id = $this->Project->query('SELECT id,name FROM projects WHERE uniq_id="' . $this->data['projUid'] . '" LIMIT 1');

        $this->set('Pjid', $prj_id[0]['projects']['id']);
        $this->set('Pjname', $prj_id[0]['projects']['name']);
    }

    public function assignUserToProject()
    {
        $this->layout = 'ajax';
        $jsonArr = array();
        $jsonArr['message'] = '';
        if (!empty($this->data['usr_to_remove'])) {
            $rem_user_task_status = $this->ajaxcheckUserTasks($this->request->data);
            if (empty($rem_user_task_status['status'])) {
                $jsonArr['status'] = 'oc';
                $jsonArr['reqdata'] = $this->request->data;
                $jsonArr['rem_user_task_status'] = $rem_user_task_status;
            }
        }
        if (!empty($this->data['project_id']) && !empty($this->data['user_ids'])) {
            $getProjUsers = $this->Project->query("select User.id from project_users as ProjectUser, users as User, projects as Project where User.id=ProjectUser.user_id and Project.uniq_id='" . $this->data['project_id'] . "' and Project.id=ProjectUser.project_id and User.isactive='1'");
            $allProjUsers = array();
            if ($getProjUsers) {
                $allProjUsers = Hash::extract($getProjUsers, '{n}.User.id');
            }
            $prj_id = $this->Project->query('SELECT id,name FROM projects WHERE uniq_id="' . $this->data['project_id'] . '" LIMIT 1');
            $removeArr = array();
            $assignArr = array();
            $uids = trim($this->data['user_ids'], ',');
            $uids = explode(',', $uids);
            foreach ($uids as $k => $v) {
                if ($v != '' && !in_array($v, $allProjUsers)) {
                    array_push($assignArr, $v);
                }
            }
            if (!empty($assignArr)) {
                $input = array();
                $input['userid'] = $assignArr;
                $input['pjid'] = $prj_id[0]['projects']['id'];
                $this->assign_userall($input);
                /* Send Push Notification to devices while adding users to project starts here */
                        
                if ($input['userid'] && is_array($input['userid']) && count($input['userid']) > 0) {
                    $notifyAndAssignToMeUsers = $input['userid'];
                    $prjTitle = $prj_id[0]['projects']['name'];
                    $notifyAndAssignToMeUsers = array_unique($notifyAndAssignToMeUsers);
                        
                    $messageToSend = __("You have been added to the project")." '" . $prjTitle . "'";
                    $this->Pushnotification->sendPushNotificationToDevicesIOS($notifyAndAssignToMeUsers, $messageToSend);
                    $this->Pushnotification->sendPushNotiToAndroid($notifyAndAssignToMeUsers, $messageToSend);
                }
                    
                /* Send Push Notification to devices while adding users to project ends here */
                $jsonArr['message'] = count($assignArr) . __(' user(s) assigned successfully');
            }
            if (!empty($allProjUsers)) {
                $removeArr = array_diff($allProjUsers, $uids);
                if (!empty($removeArr)) {
                    $input = array();
                    $input['project_id'] = $prj_id[0]['projects']['id'];
                    foreach ($removeArr as $uk => $uv) {
                        $input['userid'] = $uv;
                        $this->ajax_existuser_delete($input);
                    }
                    if ($jsonArr['message'] != '') {
                        $jsonArr['message'] .= '<br />' . count($removeArr) . __(' user(s) removed successfully');
                    } else {
                        $jsonArr['message'] = count($removeArr) . __(' user(s) removed successfully');
                    }
                }
            }
            $jsonArr['status'] = 'success';
        } else {
            $jsonArr['status'] = 'nf';
        }
        echo json_encode($jsonArr);
        exit;
    }

    public function assignRemovMeToProject()
    {
        $this->layout = 'ajax';
        $jsonArr = array();
        $jsonArr['message'] = '';
        if (!empty($this->data['project_id']) && !empty($this->data['user_ids'])) {
            $this->loadModel('ProjectUser');
            $input_uid = trim($this->data['user_ids']);
            $input_pjid = trim($this->data['project_id']);
            $checkAvlMem2 = $this->ProjectUser->find('count', array('conditions' => array('ProjectUser.user_id' => $input_uid, 'ProjectUser.project_id' => $input_pjid, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'DISTINCT project_id'));
            if (trim($this->data['typ']) == 'rm') {
                if ($checkAvlMem2 != 0) {
                    $this->ProjectUser->query("DELETE FROM project_users WHERE project_id=" . $input_pjid . " AND user_id=" . $input_uid . " AND company_id=" . SES_COMP);
                }
                if (isset($this->request->data['assign_to_user'])) {
                    $this->loadModel('Easycase');
                    $easycases = $this->Easycase->find('all', array('fields' => array('Easycase.id','Easycase.uniq_id','Easycase.project_id','Easycase.assign_to','Easycase.gantt_start_date','Easycase.due_date','Easycase.estimated_hours'),'order' => array('Easycase.id ASC'),'conditions' => array('Easycase.assign_to' => $input_uid, 'Easycase.istype' => 1, 'Easycase.project_id' => $this->request->data['project_id'], 'Easycase.legend !=' => 3)));
                    if (!empty($easycases)) {
                        $case_ids = Hash::extract($easycases, '{n}.Easycase.id');
                        $case_ids = implode(', ', $case_ids);
                        $this->Easycase->query("UPDATE easycases SET assign_to = ".$this->request->data['assign_to_user']." WHERE id IN(".$case_ids.")");
                        if (!empty($this->request->data['assign_to_user'])) {
                            foreach ($easycases as $key => $values) {
                                $RA = array();
                                $RA = array(
                                    'caseId' => $values['Easycase']['id'],
                                    'caseUniqId' => $values['Easycase']['uniq_id'],
                                    'projectId' => $values['Easycase']['project_id'],
                                    'assignTo' => $this->request->data['assign_to_user'],
                                    'str_date' => $values['Easycase']['gantt_start_date'],
                                    'CS_due_date' => $values['Easycase']['due_date'],
                                    'est_hr' => $values['Easycase']['estimated_hours']
                                );
                                if ($values['Easycase']['legend'] != 3 && $values['Easycase']['assign_to'] && ((!empty($RA['str_date']) && !empty($RA['est_hr']) && trim($RA['est_hr']) != '00:00' && trim($RA['est_hr']) != '0:00' && trim($RA['est_hr']) != '00:0' && trim($RA['est_hr']) != '0:0') || (!empty($RA['str_date']) && !empty($RA['CS_due_date'])))) {
                                    $RES = $this->Format->overloadUsersUpdted($RA);
                                }
                            }
                        } else {
                            foreach ($easycases as $key => $values) {
                                if ($this->Format->isResourceAvailabilityOn()) {
                                    $this->Format->delete_booked_hours(array('easycase_id' => $values['Easycase']['id'], 'project_id' => $values['Easycase']['project_id']), 1);
                                }
                            }
                        }
                        $jsonArr['ses_id'] = SES_ID;
                    }
                }
                $jsonArr['message'] = 'Removed successfully';
            } else {
                $getLastId = $this->ProjectUser->query("SELECT MAX(id) as maxid FROM project_users");
                $lastid = $getLastId[0][0]['maxid'];
                $lastid = $lastid + 1;
                if ($checkAvlMem2 == 0) {
                    $this->ProjectUser->query("INSERT INTO project_users SET id='" . $lastid . "',user_id=" . $input_uid . ",project_id=" . $input_pjid . ",company_id=" . SES_COMP . ",dt_visited='" . GMT_DATETIME . "'");
                }
                $jsonArr['message'] = __('Added successfully', true);
            }
            $jsonArr['status'] = 'success';
        } else {
            $jsonArr['status'] = 'nf';
        }
        echo json_encode($jsonArr);
        exit;
    }

    public function updtaeDateVisited()
    {
        $this->layout = 'ajax';
        $project_id_crnt = $this->Project->getProjectFields(array('Project.uniq_id' => $this->data['uniq_id']), array('id','project_methodology_id'));
        if ($project_id_crnt) {
            $is_in_prj = $this->ProjectUser->query("SELECT project_id FROM project_users  WHERE project_id=" . $project_id_crnt['Project']['id'] . " AND user_id=" . SES_ID);
            if ($is_in_prj) {
                $this->ProjectUser->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE project_id=" . $project_id_crnt['Project']['id'] . " AND user_id=" . SES_ID);
                $reov = Configure::read('RESTRICTED_PROJ_OV');
                $this->loadModel('Easycase');
                $tsk_cnt = $this->Easycase->find('count', array('conditions'=>array('Easycase.project_id'=>$project_id_crnt['Project']['id'],'Easycase.isactive'=>1,'Easycase.istype'=>1),'order'=>array('Project.id'=>'DESC')));
                if (in_array(SES_COMP, $reov) && SES_TYPE > 2) {
                    echo json_encode(array('status' => 'success','redirect'=>'js','tsk_cnt'=>$tsk_cnt,'proj_math'=>$project_id_crnt['Project']['project_methodology_id']));
                } else {
                    echo json_encode(array('status' => 'success','redirect'=>'js','tsk_cnt'=>$tsk_cnt,'proj_math'=>$project_id_crnt['Project']['project_methodology_id']));
                }
            } else {
                echo json_encode(array('status' => 'error'));
            }
            exit;
        }
        echo json_encode(array('status' => 'error'));
        exit;
    }

    public function validateTaskTypeFromCreateTask()
    {
        $jsonArr = array('status' => 'error');
        if (!empty($this->request->data['name'])) {
            $project_id = (isset($this->request->data['project_id']) && !empty($this->request->data['project_id']))?$this->request->data['project_id']:0;
            if (isset($this->request->data['project_uid']) && !empty($this->request->data['project_uid'])) {
                $this->loadModel('Project');
                $p = $this->Project->find('first', array('conditions'=>array('Project.uniq_id'=>$this->request->data['project_uid']),'fields'=>array('Project.id')));
                $project_id = (isset($p['Project']['id']) && !empty($p['Project']['id']))?$p['Project']['id']:0;
            }
            $this->loadModel("Type");
            $count_type = $this->Type->find('first', array('conditions' => array('Type.company_id' => array(SES_COMP, 0), 'Type.name' => trim($this->request->data['name']),'project_id'=>$project_id), 'fields' => array("Type.name")));
            if (!$count_type) {
                $jsonArr['status'] = 'success';
                $srt_nm_arr = $this->Type->find('list', array('conditions' => array('Type.company_id' => array(SES_COMP, 0),'Type.project_id'=>$project_id), 'fields' => array('Type.short_name')));
                $shrt_nm = '';
                for ($i = 0; $i <= 100; $i++) {
                    $rndmsrtnm = $this->Format->generateRandomString($this->request->data['name'], 2);
                    if (!in_array($rndmsrtnm, $srt_nm_arr)) {
                        $shrt_nm = $rndmsrtnm;
                        break;
                    }
                }
                $data = array();
                $data['name'] = $this->request->data['name'];
                $data['short_name'] = strtolower($shrt_nm);
                $data['company_id'] = SES_COMP;
                $data['project_id'] = $project_id;
                $data['seq_order'] = 0;
                $this->Type->id = '';
                if ($this->Type->save($data)) {
                    $id = $this->Type->getLastInsertID();
                    $this->loadModel("TypeCompany");
                    //Check record exists or not while added 1st time. If not then added all default type with new one.
                    $isRes = $this->TypeCompany->getTypes();
                    $cnt = 0;
                    if (isset($isRes) && empty($isRes)) {
                        //Getting default task type
                        $types = $this->Type->getDefaultTypes();
                        foreach ($types as $key => $values) {
                            $data1[$key]['type_id'] = $values['Type']['id'];
                            $data1[$key]['company_id'] = SES_COMP;
                            $cnt++;
                        }
                    }

                    $data1[$cnt]['type_id'] = $id;
                    $data1[$cnt]['company_id'] = SES_COMP;
                    if ($this->TypeCompany->saveAll($data1)) {
                        $jsonArr['msg'] = 'saved';
                        $jsonArr['id'] = $id;
                    } else {
                        $jsonArr['msg'] = 'not saved';
                    }
                } else {
                    $jsonArr['msg'] = 'not saved';
                }
            } else {
                if (trim(strtolower($count_type['Type']['name'])) == strtolower(trim($this->request->data['name']))) {
                    $jsonArr['msg'] = 'name';
                }
            }
        }
        echo json_encode($jsonArr);
        exit;
    }
    public function task_settings()
    {
        $this->loadModel('TaskSetting');
        if (SES_TYPE > 2) {
            $this->redirect(HTTP_ROOT.'dashboard');
        }
        if ($this->request->data) {
            $settings = array();
            if (isset($this->request->data['TaskSetting']['hid']) && $this->request->data['TaskSetting']['hid'] != '') {
                $settings['id'] = $this->request->data['TaskSetting']['hid'];
            }
            $settings['company_id'] = SES_COMP;
            $settings['edit_task'] = $this->request->data['TaskSetting']['edit_task'];
            if ($this->TaskSetting->save($settings)) {
                if ((Cache::read('ts_detl_'.SES_COMP)) !== false) {
                    Cache::delete('ts_detl_'.SES_COMP);
                }
                $this->redirect('/projects/task_settings');
            }
        } else {
            $task_settings = $this->TaskSetting->getTaskSettings();
            $this->set('task_settings', $task_settings);
        }
    }
    public function checkfile_csv_validation()
    {
        if (!empty($this->request->data) && !empty($_FILES)) {
            $project_id = $this->request->data['proj_id'];
            if (isset($_FILES['import_csv'])) {
                $ext = pathinfo($_FILES['import_csv']['name'], PATHINFO_EXTENSION);
                if (strtolower($ext) == 'csv') {
                    $csv_info = $_FILES['import_csv'];
                    $file_name = $csv_info['name'];
                    @copy($csv_info['tmp_name'], CSV_PATH . "task_milstone/" . $file_name);
                    if (($handle = fopen(CSV_PATH . "task_milstone/" . trim($file_name), "r")) !== false) {
                        $flag = '';
                        $data = fgetcsv($handle, 1000, ",");
                        foreach ($data as $key => $val) {
                            if (preg_match('/project/', trim(strtolower($val)))) {
                                $flag = 1;
                                break;
                            } else {
                                $flag = 0;
                            }
                        }
                        if (!empty($flag)) {
                            echo 1;
                            exit;
                        } else {
                            echo 2;
                            exit;
                        }
                    }
                }
            } else {
                echo 3;
                exit;
            }
        } else {
            echo 4;
            exit;
        }
    }

    public function delete_file()
    {
        if (!empty($this->request->data['file_name'])) {
            $file_name = $this->request->data['file_name'];
            unlink(CSV_PATH . "task_milstone/" . $file_name);
            exit;
        }
        exit;
    }

    public function createProject($proName, $assign_to)
    {
        $createProject = null;
        $createProject['Project']['members'][0] = SES_ID;
        if (!empty($assign_to)) {
            $user_data = $this->User->find('first', array('fields' => array('User.id'), 'conditions' => array('User.email LIKE' => trim($assign_to))));
            if (!empty($user_data['User']['id'])) {
                $this->loadModel('CompanyUser');
                $com_user = $this->CompanyUser->find('first', array('fields' => array('CompanyUser.id'), 'conditions' => array('CompanyUser.user_id' => $user_data['User']['id'], 'CompanyUser.company_id' => SES_COMP, 'CompanyUser.is_active' => 1)));
                if (!empty($com_user['CompanyUser']['id'])) {
                    $createProject['Project']['members'][1] = $user_data['User']['id'];
                }
            }
        }
        $createProject['new_template'] = 0;
        $createProject['Project']['name'] = $proName;
        $createProject['Project']['task_type'] = 0;
        $createProject['Project']['description'] = '';
        $createProject['Project']['members'][0] = SES_ID;
        $createProject['Project']['members_list'] = '';
        $createProject['Project']['estimated_hours'] = '';
        $createProject['Project']['start_date'] = '';
        $createProject['Project']['end_date'] = '';
        $createProject['Project']['validate'] = 1;
        $createProject['Project']['click_referer'] = '';
        $shortname = $this->acronym($proName);
        $createProject['Project']['short_name'] = $shortname;
        $proId = $this->add_project($createProject);
        return $proId;
    }

    public function acronym($longname)
    {
        $newstring = $longname . '0123456789';
        $newstring = str_replace(' ', '', $newstring);
        $letters = array();
        $words = explode(' ', $longname);
        foreach ($words as $word) {
            $word = (substr($word, 0, 1));
            array_push($letters, $word);
        }
        $company_id = $this->Company->find('first', array('fields' => array('Company.id'), 'conditions' => array('Company.uniq_id' => COMP_UID)));
        $company_id = $company_id['Company']['id'];
        $projects = $this->Project->find('list', array('fields' => array('Project.name', 'Project.short_name'), 'conditions' => array("Project.company_id" => $company_id)));
        $status = false;
        do {
            $shortname = $letters;
            $newshortname = strtoupper(implode(array_slice($shortname, 0, 3)));

            if (in_array($newshortname, $projects)) {
                unset($letters[2]);
                if (count($letters) <= 2) {
                    $rendString = array_merge(range('A', 'Z'), range(0, 9));
                    $letters[] = $rendString[rand(0, 36)];
                } else {
                    $letters = array_values($letters);
                }
                $status = true;
            } else {
                $status = false;
            }
        } while ($status);
        return $newshortname;
    }

    public function check_multiple_project()
    {
        $this->layout = 'ajax';
        if (!empty($this->request->data) && !empty($_FILES['import_csv'])) {
            $project_id = $this->request->data['proj_id'];
            if ($project_id != 'all') {
//                $pro_data = $this->Project->find('list', array('conditions' => array('Project.id' => $project_id), 'fields' => array('Project.name')));
//                $pro_name = $pro_data[$project_id];
                if (isset($_FILES['import_csv'])) {
                    $ext = pathinfo($_FILES['import_csv']['name'], PATHINFO_EXTENSION);
                    if (strtolower($ext) == 'csv') {
                        $csv_info = $_FILES['import_csv'];
                        $file_name = $csv_info['name'];
                        @copy($csv_info['tmp_name'], CSV_PATH . "task_milstone/" . $file_name);
                        if (($handle = fopen(CSV_PATH . "task_milstone/" . trim($file_name), "r")) !== false) {
                            $i = 0;
                            $separator = ',';
                            $chk_coma = $data = fgetcsv($handle, 1000, ",");
                            if (count($chk_coma) == 1 && stristr($chk_coma[0], ";")) {
                                $separator = ';';
                            }
                            rewind($handle);
                            $j = 0;
                            $flag = '';
                            while (($data = fgetcsv($handle, 1000, $separator)) !== false) {
                                if (!$i) {
                                    if (count($data) >= 1) {
                                        $fileds = $data;
                                        foreach ($data as $key => $val) {
                                            $header_arr[strtolower($val)] = $key;
                                        }
                                    }
                                } else {
                                    $value = $data;
                                    if ((isset($value[$header_arr['title']]) && trim($value[$header_arr['title']])) || (isset($value[$header_arr['task title']]) && trim($value[$header_arr['task title']]) && $value[$header_arr['task#']] != 'Export Date' && $value[$header_arr['task#']] != 'Total')) {
                                        foreach ($value as $k => $v) {
                                            if (strtolower($fileds[$k]) == 'task#') {
                                                continue;
                                            }
                                            if ((strtolower($fileds[$k]) == 'project' || strtolower($fileds[$k]) == 'project name') && !empty($v)) {
                                                $project_id1 = $this->Project->getProjectId(trim(strtolower($v)));
                                                if ($project_id1 != $project_id) {
                                                    $flag = 'more_pro';
                                                    break;
                                                } else {
                                                    $flag = 'exists';
                                                    break;
                                                }
                                            } else {
                                                $flag = 'no_project';
                                            }
                                        }
                                    }
                                }
                                $i++;
                            }
                            fclose($handle);
                            echo $flag;
                            exit;
                        } else {
                            echo 3;
                            exit;
                        }
                    } else {
                        echo 3;
                        exit;
                    }
                } else {
                    echo 3;
                    exit;
                }
            } else {
                echo 'no_project';
                exit;
            }
        } else {
            echo 0;
            exit;
        }
    }

    public function checkTaskType()
    {
        $typeId = $this->request->data['typeId'];
        $this->loadModel("Project");
        $project_list = $this->Project->find('list', array('fields' => array('Project.id', 'Project.name'), 'conditions' => array('Project.company_id' => SES_COMP, 'Project.task_type' => $typeId)));
        $project_str = implode($project_list, ', ');
        echo $project_str;
        exit;
    }

    public function checkUser($proId, $assign_to)
    {
        if (!empty($assign_to)) {
            $user_data = $this->User->find('first', array('fields' => array('User.id'), 'conditions' => array('User.email LIKE' => $assign_to)));
            if (!empty($user_data['User']['id'])) {
                $this->loadModel('CompanyUser');
                $com_user = $this->CompanyUser->find('first', array('fields' => array('CompanyUser.id'), 'conditions' => array('CompanyUser.user_id' => $user_data['User']['id'], 'CompanyUser.company_id' => SES_COMP, 'CompanyUser.is_active' => 1)));
                if (!empty($com_user['CompanyUser']['id'])) {
                    $this->loadModel('ProjectUser');
                    $project_user = $this->ProjectUser->find('first', array("fields" => array('ProjectUser.id'), 'conditions' => array('ProjectUser.user_id' => $user_data['User']['id'], 'ProjectUser.company_id' => SES_COMP, 'ProjectUser.project_id' => $proId)));
                    if (empty($project_user['ProjectUser']['id'])) {
                        $last_project_user = $this->ProjectUser->find('first', array("fields" => array('ProjectUser.id'), 'order' => array('ProjectUser.id' => 'DESC')));
                        $createprojectUser['ProjectUser']['id'] = $last_project_user['ProjectUser']['id'] + 1;
                        $createprojectUser['ProjectUser']['project_id'] = $proId;
                        $createprojectUser['ProjectUser']['company_id'] = SES_COMP;
                        $createprojectUser['ProjectUser']['user_id'] = $user_data['User']['id'];
                        $createprojectUser['ProjectUser']['istype'] = 2;
                        $createprojectUser['ProjectUser']['default_email'] = 1;
                        $createprojectUser['ProjectUser']['dt_visited'] = GMT_DATETIME;
                        $this->ProjectUser->save($createprojectUser);
                    }
                }
            }
        }
        return true;
    }
    public function getProjectDropdown()
    {
        $value=isset($this->request->data['v'])?$this->request->data['v']:1;
        $this->loadModel('Project');
        $cond=($value != 0)? "AND Project.isactive='".$value."'":" ";
        $user_cond = "ProjectUser.user_id='" . SES_ID . "' AND";
        if (SES_TYPE == 1) {
            $user_cond = '';
        }
        $sql = "SELECT DISTINCT Project.uniq_id, Project.name, Project.id FROM project_users AS ProjectUser LEFT JOIN projects AS Project ON (Project.id= ProjectUser.project_id) WHERE ".$user_cond." ProjectUser.company_id='" . SES_COMP . "' ".$cond." ORDER BY Project.name ASC";
        $projArr = $this->Project->query($sql);
        $str="<option value='0'>All</option>";
        foreach ($projArr as $prj) {
            $str .="<option value='".$prj['Project']['id']."'>".ucfirst($prj['Project']['name'])."</option>";
        }
        echo $str;
        exit;
    }

    /* functions required for recurring invoice and recurring tasks*/
    public function testRRule()
    {
        $this->layout = 'ajax';
        $recurrenceDetail = $this->request->data['recurrenceDrtails'];
        if ($recurrenceDetail['recurrence_end_type'] != 'date') {
            $recurrenceDetail['recur_end_date'] = '';
        }
        $rRule = $this->Format->getRRule($recurrenceDetail, 'test');
        $occurrences = $rRule->getOccurrences();
        $arr = array();
        if (!empty($occurrences)) {
            $arr['formatted_end_date'] = $occurrences[count($occurrences) - 1]->format('M d, Y');
            $arr['end_date'] = $occurrences[count($occurrences) - 1]->format('Y-m-d');
        } else {
            $arr['formatted_end_date'] = '';
            $arr['end_date'] = '';
        }
        echo json_encode($arr);
        /* foreach ( $rrule as $occurrence ) {
          echo $occurrence->format('D d M Y'),"\n";
          }
          echo $rrule->humanReadable(),"\n"; */
        exit;
    }
    /*
     * Function to Export Project list page data
     * Author Sandeep Acharya
     */
    
    public function export_csv_projectlist()
    {
        $this->_datestime();
        $caseUrl = $this->params->query['caseUrl'];
        $exportTypeVal = $this->params->query['exportType'];
        
        $checkedFields = explode(',', $this->params->query['checkedFields']);
        
        if ($exportTypeVal == 'excel') {
            $exportSeparator = "\t";
        } elseif ($exportTypeVal == 'csv') {
            $exportSeparator = ",";
        }
        
        $content = '';
        if (in_array('project_name', $checkedFields)) {
            $content.= 'Project Name';
        }
        if (in_array('project_shortname', $checkedFields)) {
            $content == '' ? $content.= 'Project Short Name' : $content.= $exportSeparator.'Project Short Name';
        }
        if (in_array('project_methodo', $checkedFields)) {
            $content == '' ? $content.= 'Project Template' : $content.= $exportSeparator.'Project Template';
        }
        if (in_array('project_description', $checkedFields)) {
            $content == '' ? $content.= 'Project Description' : $content.= $exportSeparator.'Project Description';
        }
        if (in_array('project_manager', $checkedFields)) {
            $content == '' ? $content.= 'Project Manager' : $content.= $exportSeparator.'Project Manager';
        }
        if (in_array('project_customer', $checkedFields)) {
            $content == '' ? $content.= 'Customer' : $content.= $exportSeparator.'Customer';
        }
        if (in_array('project_priority', $checkedFields)) {
            $content == '' ? $content.= 'Project Priority' : $content.= $exportSeparator.'Project Priority';
        }
        if (in_array('project_status', $checkedFields)) {
            $content == '' ? $content.= 'Project Status' : $content.= $exportSeparator.'Project Status';
        }
        if (in_array('project_workflow', $checkedFields)) {
            $content == '' ? $content.= 'Project Workflow' : $content.= $exportSeparator.'Project Workflow';
        }
        if (in_array('project_start', $checkedFields)) {
            $content == '' ? $content.= 'Project Start Date' : $content.= $exportSeparator.'Project Start Date';
        }
        if (in_array('project_end', $checkedFields)) {
            $content == '' ? $content.= 'Project End Date' : $content.= $exportSeparator.'Project End Date';
        }
        if (in_array('project_est', $checkedFields)) {
            $content == '' ? $content.= 'Project Estimated Hours' : $content.= $exportSeparator.'Project Estimated Hours';
        }
        if (in_array('project_spent_hr', $checkedFields)) {
            $content == '' ? $content.= 'Project Spent Hours' : $content.= $exportSeparator.'Project Spent Hours';
        }
        if (in_array('project_budget', $checkedFields)) {
            $content == '' ? $content.= 'Number of Tasks' : $content.= $exportSeparator.'Number of Tasks';
        }
        if (in_array('project_budget', $checkedFields)) {
            $content == '' ? $content.= 'Project Budget' : $content.= $exportSeparator.'Project Budget';
        }
        if (in_array('project_cost_approve', $checkedFields)) {
            $content == '' ? $content.= 'Cost Approved' : $content.= $exportSeparator.'Cost Approved';
        }
        if (in_array('project_project_type', $checkedFields)) {
            $content == '' ? $content.= 'Project Type' : $content.= $exportSeparator.'Project Type';
        }
        if (in_array('project_industry', $checkedFields)) {
            $content == '' ? $content.= 'Industry' : $content.= $exportSeparator.'Industry';
        }
        if (in_array('project_last_activity', $checkedFields)) {
            $content == '' ? $content.= 'Last Activity Date' : $content.= $exportSeparator.'Last Activity Date';
        }
        $content .= "\n";
        
        $conditions = array('Project.company_id' => SES_COMP);
        if (isset($_COOKIE['PROJECT_TYPE']) && $_COOKIE['PROJECT_TYPE'] == 'active-grid' && !isset($_COOKIE['PROJECT_FILL_TYPE'])) {
            $conditions = array('Project.company_id' => SES_COMP);
        } elseif (isset($_COOKIE['PROJECT_TYPE'], $_COOKIE['PROJECT_FILL_TYPE']) && $_COOKIE['PROJECT_TYPE'] == 'active-grid' && $_COOKIE['PROJECT_FILL_TYPE'] == 'started') {
            $conditions = array('Project.company_id' => SES_COMP, 'Project.status' => 1, 'Project.isactive !=' => 2);
        } elseif (isset($_COOKIE['PROJECT_TYPE'], $_COOKIE['PROJECT_FILL_TYPE']) && $_COOKIE['PROJECT_TYPE'] == 'active-grid' && $_COOKIE['PROJECT_FILL_TYPE'] == 'on-hold') {
            $conditions = array('Project.company_id' => SES_COMP, 'Project.status' => 2, 'Project.isactive !=' => 2);
        } elseif (isset($_COOKIE['PROJECT_TYPE'], $_COOKIE['PROJECT_FILL_TYPE']) && $_COOKIE['PROJECT_TYPE'] == 'active-grid' && $_COOKIE['PROJECT_FILL_TYPE'] == 'stack') {
            $conditions = array('Project.company_id' => SES_COMP, 'Project.status' => 3, 'Project.isactive !=' => 2);
        } elseif (isset($_COOKIE['PROJECT_TYPE']) && $_COOKIE['PROJECT_TYPE'] == 'inactive-grid' && !isset($_COOKIE['PROJECT_FILL_TYPE'])) {
            $conditions = array('Project.company_id' => SES_COMP, 'Project.isactive' => 2);
        }
        
        if (SES_TYPE == 3) {
            $all_assigned_proj = $this->Project->query('SELECT project_id FROM project_users WHERE user_id=' . SES_ID . ' AND company_id=' . SES_COMP);
            if ($all_assigned_proj) {
                $all_assigned_proj = Hash::extract($all_assigned_proj, '{n}.project_users.project_id');
                $all_assigned_proj = array_unique($all_assigned_proj);
                $conditions['OR'] = array('Project.user_id' => SES_ID,'Project.id' => $all_assigned_proj);
            } else {
                $conditions['Project.user_id'] = SES_ID;
            }
        }
        $this->loadModel('ProjectMethodology');
        $this->Project->recursive = -1;
        $projArr = $this->Project->find('all', array('conditions' => $conditions, 'order' => 'Project.id DESC'));
            
        $update_prjAllArr=$projArr;
        foreach ($projArr as $pkey => $pval) {
            $project_id=!empty($pval['Project']['id'])?$pval['Project']['id']:'';
            $this->loadModel('ProjectMeta');
            $ProjectMeta=array();
            $ProjectMeta = $this->ProjectMeta->find('first', array('conditions' => array('ProjectMeta.project_id' => $project_id)));
    
            $update_prjAllArr[$pkey]['ProjectMeta']=$ProjectMeta;
        }
        $projArr=$update_prjAllArr;
        
        $this->loadModel('User');
        $prjmanager_names = $this->User->find('list', array('fields' => array('User.uniq_id', 'User.name')));

        
        $user_list=array();
        
        // $user_list = $this->User->find('list', array('fields' => array('User.id', 'User.name')));
        $this->loadModel('Industry');
        $industries = $this->Industry->find('list', array('conditions' => array('Industry.is_display' => 1),'fields' => array('Industry.id', 'Industry.name')));
        $this->loadModel('ProjectType');
        $ProjectType = $this->ProjectType->find('list', array('conditions' => array('ProjectType.is_active' => 1),'fields' => array('ProjectType.id', 'ProjectType.title')));
        if (is_array($projArr) && count($projArr) > 0) {
            //project_workflow
            $sts_ids = array_filter(array_unique(Hash::extract($projArr, '{n}.Project.status_group_id')));
            if ($sts_ids) {
                $Csts = ClassRegistry::init('StatusGroup');
                $csts_arr_grp = $Csts->find('all', array('conditions'=>array('StatusGroup.id'=>$sts_ids),'fields'=>array('StatusGroup.id','StatusGroup.name')));
                if ($csts_arr_grp) {
                    $csts_arr_grp = Hash::combine($csts_arr_grp, '{n}.StatusGroup.id', '{n}.StatusGroup');
                }
            }
            if (in_array('project_methodo', $checkedFields)) {
                $proj_mothod = $this->ProjectMethodology->getAllMethodList();
            }
            foreach ($projArr as $key => $val) {
                $getTaskCountForProject = $this->Easycase->query("select count(*) as `totalTasks` from `easycases` where `project_id`='".$val["Project"]['id']."' and `istype`=1");
                $getactivity = $this->Format->getlatestactivitypid($val["Project"]['id'], 1);
                if ($getactivity == "") {
                    $last_activity = __('No activity', true);
                } else {
                    $curCreated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                    $updated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getactivity, "datetime");
                    #$locDT = $this->Datetime->dateFormatOutputdateTime_day($updated, $curCreated);
                }
                $this->loadModel("ProjectStatus");
                $All_status = $this->ProjectStatus->getAllProjectStatus(SES_COMP);
                ksort($All_status);
                
                if ($val['Project']['isactive'] == 1 && $val['Project']['status'] == 1) {
                    $sts_txt = __('Started', true);
                } elseif ($val['Project']['isactive'] == 1 && $val['Project']['status'] == 2) {
                    $sts_txt = __('On Hold', true);
                } elseif ($val['Project']['isactive'] == 1 && $val['Project']['status'] == 3) {
                    $sts_txt = __('Stack', true);
                } elseif ($val['Project']['isactive'] == 2) {
                    $sts_txt = __('Completed', true);
                } else {
                    $sts_txt = $All_status[$val['Project']['status']];
                }
                
                if ($val["Project"]['priority'] == 0) {
                    $priority_txt = __('High', true);
                } elseif ($val["Project"]['priority'] == 1) {
                    $priority_txt = __('Medium', true);
                } elseif ($val["Project"]['priority'] == 2) {
                    $priority_txt = __('Low', true);
                }
                
                
                $workflow_txt = __('Default Workflow');
                if ($val["Project"]['status_group_id']) {
                    if (!empty($csts_arr_grp)) {
                        $workflow_txt = $csts_arr_grp[$val["Project"]['status_group_id']]['name'];
                    }
                }
                $prjAllArr = $this->Project->query("SELECT SQL_CALC_FOUND_ROWS id,uniq_id,name,user_id,project_type,priority,short_name,isactive,
                            (SELECT ROUND((SUM(TimeLog.total_hours)/3600),1) as hours FROM log_times as TimeLog WHERE TimeLog.project_id=Project.id) as totalhours
                            FROM projects AS Project WHERE name LIKE '%" . addslashes($val["Project"]['name']) . "%' ORDER BY name");
                
                if (in_array('project_name', $checkedFields)) {
                    $content .= trim($val["Project"]['name']) ? '"' . str_replace('"', '""', trim($val["Project"]['name'])) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_shortname', $checkedFields)) {
                    $content .= trim($val["Project"]['short_name']) ? '"' . str_replace('"', '""', trim($val["Project"]['short_name'])) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_methodo', $checkedFields)) {
                    $content .= trim($proj_mothod[$val["Project"]['project_methodology_id']]) ? '"' . trim($proj_mothod[$val["Project"]['project_methodology_id']]) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_description', $checkedFields)) {
                    $content .= trim($val["Project"]['description']) ? '"' . $this->Format->stripHtml(str_replace('"', '""', trim($val["Project"]['description']))) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_manager', $checkedFields)) {
                    $content .= trim($val["ProjectMeta"]['ProjectMeta']['project_manager']) ? '"' . $this->Format->stripHtml(str_replace('"', '""', trim($prjmanager_names[$val["ProjectMeta"]['ProjectMeta']['project_manager']]))) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_customer', $checkedFields)) {
                    $content .= trim($val["ProjectMeta"]['ProjectMeta']['client']) ? '"' . $this->Format->stripHtml(str_replace('"', '""', trim($user_list[$val["ProjectMeta"]['ProjectMeta']['client']]))) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_priority', $checkedFields)) {
                    $content .= $priority_txt ? '"' . $priority_txt . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_status', $checkedFields)) {
                    $content .= $sts_txt ? '"' . $sts_txt . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_workflow', $checkedFields)) {
                    $content .= $workflow_txt ? '"' . $workflow_txt . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_start', $checkedFields)) {
                    $content .= isset($val["Project"]['start_date']) ? '"' . date('d M', strtotime($val["Project"]['start_date'])) . '"' . $exportSeparator : $exportSeparator ;
                }
                if (in_array('project_end', $checkedFields)) {
                    $content .= $val["Project"]['end_date'] ? '"' . date('d M', strtotime($val["Project"]['end_date'])) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_est', $checkedFields)) {
                    $content .= $val["Project"]['estimated_hours'] ? '"' . $val["Project"]['estimated_hours'] . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_spent_hr', $checkedFields)) {
                    $content .= $prjAllArr[0][0]['totalhours'] ? '"' . $prjAllArr[0][0]['totalhours'] . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_num_tasks', $checkedFields)) {
                    $content .= $getTaskCountForProject[0][0]['totalTasks'] ? '"' . $getTaskCountForProject[0][0]['totalTasks'] . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_budget', $checkedFields)) {
                    $content .= trim($val["ProjectMeta"]['ProjectMeta']['budget']) ? '"' . $this->Format->stripHtml(str_replace('"', '""', trim($val["ProjectMeta"]['ProjectMeta']['budget']))) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_cost_approve', $checkedFields)) {
                    $content .= trim($val["ProjectMeta"]['ProjectMeta']['cost_appr']) ? '"' . $this->Format->stripHtml(str_replace('"', '""', trim($val["ProjectMeta"]['ProjectMeta']['cost_appr']))) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_project_type', $checkedFields)) {
                    $content .= trim($val["ProjectMeta"]['ProjectMeta']['proj_type']) ? '"' . $this->Format->stripHtml(str_replace('"', '""', trim($ProjectType[$val["ProjectMeta"]['ProjectMeta']['proj_type']]))) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_industry', $checkedFields)) {
                    $content .= trim($val["ProjectMeta"]['ProjectMeta']['industry']) ? '"' . $this->Format->stripHtml(str_replace('"', '""', trim($industries[$val["ProjectMeta"]['ProjectMeta']['industry']]))) . '"' . $exportSeparator : $exportSeparator;
                }
                if (in_array('project_last_activity', $checkedFields)) {
                    $content .= $updated ? '"' . date('d M, Y H:i:s', strtotime($updated)) . '"' . $exportSeparator : $exportSeparator;
                }
                
                $content = trim($content, $exportSeparator);
                $content .="\n";
            }
        }
        
        if (!is_dir(TASKLIST_CSV_PATH)) {
            @mkdir(TASKLIST_CSV_PATH, 0777, true);
        }

        $this->Company->recursive = -1;
        $compArr = $this->Company->find('all', array('conditions' => array('Company.id' => SES_COMP)));
        
        $name = $compArr[0]['Company']['name'];
        
        if ($exportTypeVal == 'excel') {
            $exportFileName = "projectlist.xls";
            $exportContentType = "application/vnd.ms-excel";
        } elseif ($exportTypeVal == 'csv') {
            $exportFileName = "projectlist.csv";
            $exportContentType = "application/csv";
        }
        
        if (trim($name) != '' && strlen($name) > 25) {
            $download_name = substr($name, 0, 24) . "_" . date('m-d-Y', strtotime(GMT_DATE)) . "_" . $exportFileName;
        } else {
            #$download_name = (trim($name) != '' ? "_" : '') . date('m-d-Y', strtotime(GMT_DATE)) . "_projectlist.xls";
            $download_name = $name . "_" . date('m-d-Y', strtotime(GMT_DATE)) . "_" . $exportFileName;
        }
        #$download_name = date('m-d-Y', strtotime(GMT_DATE)) . "_projectlist.xls";

        ob_clean();
        $file_path = TASKLIST_CSV_PATH . $name;
        $fp = @fopen($file_path, 'w+');
        fwrite($fp, $content);
        fclose($fp);
    
        $this->response->header(array('Content-Encoding'=>'UTF-8','Content-type'=>$exportContentType,'charset'=>'UTF-8'));
        //$this->response->charset('UTF-8');
        //$this->response->type('csv');
        $this->response->file($file_path, array('download' => true, 'name' => urlencode($download_name)));
        return $this->response;
    }
    public function deleteWorkflow()
    {
        $arr['msg'] = __("Oops! Something went wrong", true);
        $arr['status'] = 0;
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $this->loadModel('StatusGroup');
            $this->StatusGroup->id = $this->request->data['id'];
            if ($this->StatusGroup->delete()) {
                $arr['msg'] = __("Workflow deleted successfully", true);
                $arr['status'] =1;
            }
        }
        echo json_encode($arr);
        exit;
    }
    public function getWorkflow()
    {
        $arr['msg'] = __("Oops! Something went wrong", true);
        $arr['status'] = 0;
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $this->loadModel('StatusGroup');
            $res = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.id'=>$this->request->data['id'])));
            if (!empty($res)) {
                $arr['status'] = 1;
                $arr['result'] = $res['StatusGroup'];
            }
        }
        echo json_encode($arr);
        exit;
    }
    /*
    * Manage add/update Workflow status functionality using ajax
    */
    public function manage_status($id)
    {
        //if(!$this->Format->isTimesheetOn(5) || empty($id)){
          
        $data = $this->request->data;
        $check_ajax= false;

        if (isset($this->request->data['CustomStatus']['uu_id']) && !empty($this->request->data['CustomStatus']['uu_id'])) {
            $check_ajax = true;
            $id=$this->request->data['CustomStatus']['uu_id'];
        }
      
        if (empty($id)) {
            $this->redirect(HTTP_ROOT."dashboard");
        }
        $this->loadModel('StatusGroup');
        $this->loadModel('CustomStatus');
        $id = (int)base64_decode($id);
        $statusGroup = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.id' => $id,'StatusGroup.company_id' => array(SES_COMP,0))));
        if ($id == 0) {
            $statusGroup = array('StatusGroup'=>array('id'=>0,'company_id'=>0,'name'=>'Default Status Workflow','description'=>'','created_by'=>''));
        }
        $this->set('statusGroup', $statusGroup);
        if (isset($this->request->data['CustomStatus']['name']) && !empty($this->request->data['CustomStatus']['name'])) {
            $seq = 0;
            $hig_seq = array();
            $closeSts = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.status_master_id' =>3, 'CustomStatus.status_group_id' => $id,'CustomStatus.company_id' => SES_COMP)));
            if ($closeSts && $this->request->data['CustomStatus']['status_master_id'] == 3) {
                if ($this->request->data['CustomStatus']['id'] == '') {
                    $this->Session->write("ERROR", __("Oops! can add more than one close mapping status in a workflow", true));
                } else {
                    if ($this->request->data['CustomStatus']['progress'] != 100) {
                        $this->Session->write("ERROR", __("Oops! can not update progress percentage to close mapping status in this workflow", true));
                    }
                }
                $seq = $closeSts['CustomStatus']['seq']-1;
            }
            //}else{
            //check duplicate
            if ($this->request->data['CustomStatus']['id'] == '') {
                $exstSts = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.company_id' =>array(SES_COMP,0), 'CustomStatus.name' => trim($this->request->data['CustomStatus']['name']),'CustomStatus.status_group_id' => $id)));
            } else {
                $exstSts = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.company_id' =>array(SES_COMP,0), 'CustomStatus.name' => trim($this->request->data['CustomStatus']['name']),'CustomStatus.id !=' =>trim($this->request->data['CustomStatus']['id']),'CustomStatus.status_group_id' => $id)));
            }
            if ($exstSts) {
                $this->Session->write("ERROR", __("Oops! Status '<b>".trim($this->request->data['CustomStatus']['name'])."</b>' already exists!", true));
                $this->request->data = array();
            } else {
                if ($this->request->data['CustomStatus']['id'] != '' || $this->request->data['CustomStatus']['id'] == '' || $this->request->data['CustomStatus']['status_master_id'] == 3) {
                    $hig_seq = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.status_group_id'=>$id,'CustomStatus.company_id'=>SES_COMP),'fields'=>array('CustomStatus.seq','CustomStatus.id'),'order'=>array('CustomStatus.seq'=>'DESC'),'limit'=>1));
                    $seq = $hig_seq['CustomStatus']['seq'];
                }
                $data = $this->request->data;
                $data['CustomStatus']['status_group_id'] = $id;
                $data['CustomStatus']['company_id'] = SES_COMP;
                if ($this->request->data['CustomStatus']['id'] == '') {
                    $data['CustomStatus']['seq'] = $seq;
                }
                if ($this->CustomStatus->save($data)) {
                    if (!empty($closeSts)) {
                        $this->CustomStatus->create();
                        $this->CustomStatus->id = $closeSts['CustomStatus']['id'];
                        $this->CustomStatus->saveField('seq', ($seq+1));
                    }
                    if (!$check_ajax) {
                        $this->Session->write("SUCCESS", __("Status added successfully", true));
                    }
                } else {
                    if (!$check_ajax) {
                        $this->Session->write("ERROR", __("Oops! Some thing went wrong", true));
                    }
                }
            }
        }
        if ($id != 0) {
            $this->CustomStatus->bindModel(array('hasMany' => array('Easycase'=>array('fields'=>array('Easycase.id')))));
            $result = $this->CustomStatus->find('all', array('conditions'=>array('CustomStatus.status_group_id'=>$id),'order'=>array('CustomStatus.seq'=>'ASC')));
        } else {
            $result[0]['CustomStatus'] = array(
                'id' => 0,
                'company_id' => 0,
                'name' => __('New', true),
                'progress' => 0,
                'color' => 'F08E83',
                'status_master_id' => 1,
                'status_group_id' => 0,
                'seq' => 1
            );
            $result[1]['CustomStatus'] = array(
                'id' => 0,
                'company_id' => 0,
                'name' => __('In Progress', true),
                'progress' => 0,
                'color' => '6BA8DE',
                'status_master_id' => 2,
                'status_group_id' => 0,
                'seq' => 1
            );
            $result[2]['CustomStatus'] = array(
                'id' => 0,
                'company_id' => 0,
                'name' => __('Resolve', true),
                'progress' => 100,
                'color' => 'FAB858',
                'status_master_id' => 5,
                'status_group_id' => 0,
                'seq' => 1
            );
            $result[3]['CustomStatus'] = array(
                'id' => 0,
                'company_id' => 0,
                'name' => __('Close', true),
                'progress' => 100,
                'color' => '72CA8D',
                'status_master_id' => 3,
                'status_group_id' => 0,
                'seq' => 1
            );
        }
        $this->set('result', $result);

        $this->loadModel('StatusMaster');
        $statusMaster = $this->StatusMaster->find('list');
        $this->set('statusMaster', $statusMaster);
        if ($check_ajax) {
            $this->render('/Elements/workflow_status_list', 'ajax');
        }
    }
    
    
    public function ajax_saveNewstatusKanban()
    {
        $this->loadModel('StatusGroup');
        $this->loadModel('CustomStatus');
        $jsonRet['status'] = 'error';
        $jsonRet['msg'] =  __('Please enter status name');
        if (isset($this->data['CustomStatus']['uu_id']) && !empty($this->data['CustomStatus']['uu_id'])) {
            $id = (int)base64_decode($this->data['CustomStatus']['uu_id']);
            $statusGroup = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.id' => $id,'StatusGroup.company_id' => SES_COMP)));
                
            if (isset($this->request->data['CustomStatus']['name']) && !empty($this->request->data['CustomStatus']['name'])) {
                $seq = 0;
                $hig_seq = array();
                $closeSts = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.status_master_id' =>3, 'CustomStatus.status_group_id' => $id,'CustomStatus.company_id' => SES_COMP)));
                if ($closeSts && $this->request->data['CustomStatus']['status_master_id'] == 3) {
                    if ($this->request->data['CustomStatus']['id'] == '') {
                        $jsonRet['msg'] = __("Oops! can add more than one close mapping status in a workflow", true);
                    } else {
                        if ($this->request->data['CustomStatus']['progress'] != 100) {
                            $jsonRet['msg'] = __("Oops! can not update progress percentage to close mapping status in this workflow", true);
                        }
                    }
                    $seq = $closeSts['CustomStatus']['seq']-1;
                }
                //check duplicate
                if ($this->request->data['CustomStatus']['id'] == '') {
                    $exstSts = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.company_id' =>SES_COMP, 'CustomStatus.name' => trim($this->request->data['CustomStatus']['name']),'CustomStatus.status_group_id' => $id)));
                } else {
                    $exstSts = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.company_id' =>SES_COMP, 'CustomStatus.name' => trim($this->request->data['CustomStatus']['name']),'CustomStatus.id !=' =>trim($this->request->data['CustomStatus']['id']),'CustomStatus.status_group_id' => $id)));
                }
                if ($exstSts) {
                    $jsonRet['msg'] = __("Oops! Status '<b>".trim($this->request->data['CustomStatus']['name'])."</b>' already exists!", true);
                } else {
                    if ($this->request->data['CustomStatus']['id'] != '' || $this->request->data['CustomStatus']['id'] == '' || $this->request->data['CustomStatus']['status_master_id'] == 3) {
                        $hig_seq = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.status_group_id'=>$id,'CustomStatus.company_id'=>SES_COMP),'fields'=>array('CustomStatus.seq','CustomStatus.id'),'order'=>array('CustomStatus.seq'=>'DESC'),'limit'=>1));
                        $seq = $hig_seq['CustomStatus']['seq'];
                    }
                    $data = $this->request->data;
                    $data['CustomStatus']['status_group_id'] = $id;
                    $data['CustomStatus']['company_id'] = SES_COMP;
                    if ($this->request->data['CustomStatus']['id'] == '') {
                        $data['CustomStatus']['seq'] = $seq;
                    }
                    if ($this->CustomStatus->save($data)) {
                        if (!empty($closeSts)) {
                            $this->CustomStatus->create();
                            $this->CustomStatus->id = $closeSts['CustomStatus']['id'];
                            $this->CustomStatus->saveField('seq', ($seq+1));
                        }
                        $jsonRet['status'] = 'success';
                    } else {
                        $jsonRet['msg'] = __("Oops! Some thing went wrong", true);
                    }
                }
            }
        } else {
            $jsonRet['msg'] = __('Invalid parameter supplied.');
        }
        echo json_encode($jsonRet);
        exit;
    }
    public function crate_new_status()
    {
        $this->layout = 'ajax';
        $this->loadModel('StatusMaster');
        $this->set('wid', $this->request->data['id']);
        if (isset($this->data['from_page']) && !empty($this->data['from_page'])) {
            $this->set('wid', (int)base64_decode($this->request->data['id']));
        }
        $statusMaster = $this->StatusMaster->find('list');
        $this->set('statusMaster', $statusMaster);

        if (isset($this->request->data['sid']) && !empty($this->request->data['sid'])) {
            $this->loadModel('CustomStatus');
            $res = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.id'=>$this->request->data['sid'])));
            $this->set('res', $res);
        }
        //from kanaban page
        $from_page = '';
        if (isset($this->data['from_page']) && !empty($this->data['from_page'])) {
            $from_page = $this->data['from_page'];
        }
        $this->set('from_page', $from_page);
    }
    public function deleteWfStatus()
    {
        $arr['msg'] = __("Oops! Something went wrong", true);
        $arr['status'] = 0;
        if (isset($this->request->data['id']) && !empty($this->request->data['id'])) {
            $this->loadModel('CustomStatus');
            $this->CustomStatus->bindModel(array('hasMany' => array('Easycase'=>array('fields'=>array('Easycase.id')))));
            $result = $this->CustomStatus->find('first', array('conditions'=>array('CustomStatus.id'=>$this->request->data['id']),'order'=>array('CustomStatus.seq'=>'ASC')));
            if ($result && empty($result['Easycase'])) {
                $this->CustomStatus->id = $this->request->data['id'];
                if ($this->CustomStatus->delete()) {
                    $arr['msg'] = __("Status deleted successfully.", true);
                    $arr['status'] =1;
                }
            } else {
                $arr['msg'] = __("Status can not be deleted, because it is associated with a task.", true);
                $arr['status'] =0;
            }
        }
        echo json_encode($arr);
        exit;
    }
    public function reorderStatus()
    {
        $arr['msg'] = __('Something went wrong', true);
        $arr['status'] = 0;
        #pr($this->request->data['custom_status_tr']);exit;
        if (isset($this->request->data['custom_status_tr']) && !empty($this->request->data['custom_status_tr'])) {
            $this->loadModel('CustomStatus');
            $listStst = $this->CustomStatus->find('list', array('conditions' => array('CustomStatus.id' => $this->request->data['custom_status_tr']), 'fields' => array('CustomStatus.id', 'CustomStatus.status_master_id'),'order'=>array('CustomStatus.id ASC')));
            $lastSts = 0;
            foreach ($this->request->data['custom_status_tr'] as $k=>$v) {
                $this->CustomStatus->create();
                if ($listStst[$v] == 3) {
                    $lastSts = $v;
                }
                $this->CustomStatus->id = $v;
                $this->CustomStatus->saveField('seq', ($k+1));
            }
            //sleep(2);
            if ($lastSts) {
                $this->CustomStatus->create();
                $this->CustomStatus->id = $lastSts;
                $this->CustomStatus->saveField('seq', ($k+2));
            }
            $arr['status'] = 1;
        }
        echo json_encode($arr);
        exit;
    }
    /**
     * @method: public importcomment(int proj_id) Dataimport Interface
     * @author Andola  <info@andolasoft.com>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function importcomment()
    {
    }
    /**
     * @method public timelog data_import Dataimport Interface
     * @author Andola  <info@andolasoft.com>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function csv_commentimport()
    {
        $comp_id = 20234;
        $this->loadModel("TypeCompany");
        $sel_types = $this->TypeCompany->getSelAllType($comp_id);
        $is_projects = 0;
        $task_type_arr = array();
        if (isset($sel_types) && !empty($sel_types)) {
            foreach ($sel_types as $key => $value) {
                $task_type_arr[$value['Type']['id']] = strtolower($value['Type']['name']);
            }
        }
        
        $this->loadModel('User');
        $this->loadModel('CompanyUser');
        $this->loadModel('Easycase');
        $task_assign_to_userid = $this->CompanyUser->find('list', array('conditions' => array('company_id' => $comp_id, 'is_active' => 1), 'fields' => 'user_id'));
        $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => 'email'));
        $fields_arr = array('project', 'task#', 'commented by', 'assigned to', 'comment', 'status', 'type','comment date', 'priority');
        $task_status_arr = array('new', 'close', 'wip', 'resolve', 'resolved', 'closed', 'in progress');
        $task_priority_arr = array(0=>'high', 1=>'medium', 2=>'low');

        $this->loadModel('Project');
        $task_assign_prj = $this->Project->find('list', array('conditions' => array('company_id' => $comp_id, 'isactive' => 1), 'fields' => array('id', 'name')));
        $task_assign_prj_name = array_values($task_assign_prj);
        $task_assign_prj_name = array_map('strtolower', $task_assign_prj_name);
        
        if (isset($_FILES['commentimport_csv'])) {
            $ext = pathinfo($_FILES['commentimport_csv']['name'], PATHINFO_EXTENSION);
            if (strtolower($ext) == 'csv') {
                $csv_info = $_FILES['commentimport_csv'];
                //Uploading the csv file to Our server
                $file_name = SES_ID . "_comment_" . $csv_info['name'];
                @copy($csv_info['tmp_name'], CSV_PATH . "task_comment/" . $file_name);
                $row = 1;
                // Counting total rows and Restricting from uploading a file having more then 1000 record
                $linecount = count(file(CSV_PATH . "task_comment/" . $file_name));
                if ($linecount > 2001) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "task_comment/" . $file_name);
                    $this->Session->write("ERROR", __("Please split the file and upload again. Your file contain more than 1000 rows", true));
                    $this->redirect(HTTP_ROOT . "projects/importcomment/");
                    exit;
                }
                if ($csv_info['size'] > 2097152) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "task_comment/" . $file_name);
                    $this->Session->write("ERROR", __("Please upload a file with size less then 2MB", true));
                    $this->redirect(HTTP_ROOT . "projects/importcomment/");
                    exit;
                }
                //Parsing the csv file
                if (($handle = fopen(CSV_PATH . "task_comment/" . $file_name, "r")) !== false) {
                    $i = 0;
                    $j = 0;
                    while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                        if (!$i) {
                            // Check for column count
                            if (count($data) >= 1) {
                                // Check for exact number of fields
                                foreach ($data as $key => $val) {
                                    if (!in_array(strtolower($val), $fields_arr)) {
                                        @unlink(CSV_PATH . "task_comment/" . $file_name);
                                        $this->Session->write("ERROR", "". __('Invalid CSV file', true).", <a href='" . HTTP_ROOT . "projects/download_sample_comntcsvfile' style='text-decoration:underline;color:#0000FF'>".__('Download', true)."</a> ".__('and check with our sample file', true));
                                        $this->redirect(HTTP_ROOT . "projects/importcomment/");
                                        exit;
                                    }
                                }
                                $fileds = $data;
                                foreach ($data as $key => $val) {
                                    $header_arr[strtolower($val)] = $key;
                                }
                            } else {
                                @unlink(CSV_PATH . "task_comment/" . $file_name);
                                $this->Session->write("ERROR", __("Mandatory columns values are needed", true));
                                $this->redirect(HTTP_ROOT . "projects/importcomment/");
                                exit;
                            }
                        } else {
                            // Verifing data
                            $value = $data;
                            if (isset($value[$header_arr['project']]) && trim($value[$header_arr['project']])) {
                                foreach ($value as $k => $v) {
                                    $task_ass[strtolower($fileds[$k])] = $v;

                                    // Parsing each data for error in data
                                    if (strtolower($fileds[$k]) == 'project' && $v) {
                                        if (in_array(strtolower(trim($v)), $task_assign_prj_name)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'task#' && $v) {
                                        $ck_tsk = $this->chk_impt_task($task_assign_prj, $value[$header_arr['project']], $value[$header_arr['task#']]);
                                        if ($ck_tsk) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'commented by' && strtolower($v) != 'me' && $v) {
                                        if (in_array($v, $task_assign_to_users)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'assigned to' && strtolower($v) != 'me' && $v) {
                                        if (in_array($v, $task_assign_to_users)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif ((strtolower($fileds[$k]) == 'type' || strtolower($fileds[$k]) == 'task type') && $v) {
                                        if (in_array(strtolower(trim($v)), $task_type_arr)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'status' && $v) {
                                        if (in_array(strtolower($v), $task_status_arr)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } elseif (strtolower($fileds[$k]) == 'priority' && $v) {
                                        if (in_array(strtolower($v), $task_priority_arr)) {
                                            $task_error[strtolower($fileds[$k])] = 0;
                                        } else {
                                            $task_error[strtolower($fileds[$k])] = 1;
                                        }
                                    } else {
                                        $task_error[strtolower($fileds[$k])] = 0;
                                    }
                                }
                                $task[] = $task_ass;
                                $task_err[] = $task_error;
                            }
                        }
                        $i++;
                    }
                    fclose($handle);
                }
                
                // Preparing history data
                $total_valid_rows = $total_valid_rows ? ($total_valid_rows + count($task_arr)) : count($task_arr);
                $task_assign_prj_flp = array_flip($task_assign_prj);
                $task_assign_to_users_flp = array_flip($task_assign_to_users);

                $actual_rows_imported = 0;
                
                $task_type_arr_flp = array_flip($task_type_arr);
                $task_priority_arr_flp = array_flip($task_priority_arr);
                //pr($task_assign_prj_flp);exit;
                
                foreach ($task as $k => $v) {
                    if (!trim($v['project'])) {
                        continue;
                    }
                    //$CS_message = (isset($v['comment']) && $v['comment']) ? $v['comment'] : '';
                    if (!trim($v['task#'])) {
                        continue;
                    }
                    if (!isset($v['assigned to'])) {
                        continue;
                    }
                    if (!isset($v['commented by'])) {
                        continue;
                    }
                    if (!isset($task_assign_to_users_flp[$v['commented by']])) {
                        continue;
                    } else {
                        $uid_by = $task_assign_to_users_flp[$v['commented by']];
                    }
                    
                    $project_id = (isset($task_assign_prj_flp[$v['project']])) ? $task_assign_prj_flp[$v['project']] : '';
                    if ($project_id == '') {
                        continue;
                    }

                    $selected_task_id = $this->Easycase->find('first', array('conditions' => array('Easycase.project_id' => $project_id, 'Easycase.istype' => 1, 'Easycase.case_no' => $v['task#']), 'fields' => array('Easycase.id', 'Easycase.legend','Easycase.uniq_id','Easycase.type_id','Easycase.priority','Easycase.case_no','Easycase.assign_to')));
                    if (!empty($selected_task_id)) {
                        $current_id = $selected_task_id['Easycase']['id'];
                    } else {
                        $current_id = 0;
                        continue;
                    }

                    if ($current_id) {
                        $actual_rows_imported++;
                        
                        $easycase = null;
                        if (!isset($task_assign_to_users_flp[$v['assigned to']])) {
                            $easycase['assign_to'] = $selected_task_id['Easycase']['assign_to'];
                        } else {
                            $easycase['assign_to'] = $task_assign_to_users_flp[$v['assigned to']];
                        }
                        $easycase['message'] = $current_id;
                        $easycase['project_id'] = $project_id;
                        $easycase['user_id'] =  $uid_by;
                        $easycase['case_no'] = $selected_task_id['Easycase']['case_no'];
                        $easycase['message'] = (isset($v['comment']) && $v['comment']) ? $v['comment'] : '';
                        
                        if (!isset($v['status'])) {
                            $legend = $selected_task_id['Easycase']['legend'];
                        } else {
                            if ($v['status'] && ((strtoupper(trim($v['status'])) == 'WIP') || (strtoupper(trim($v['status'])) == 'IN PROGRESS'))) {
                                $legend = 2;
                            } elseif ($v['status'] && ((strtolower(trim($v['status'])) == 'close') || (strtoupper(trim($v['status'])) == 'CLOSED'))) {
                                $legend = 3;
                            } elseif ($v['status'] && (strtolower(trim($v['status'])) == 'resolve' || strtolower(trim($v['status'])) == 'resolved')) {
                                $legend = 5;
                            } else {
                                $legend = 1;
                            }
                        }
                        $easycase['legend'] = $legend;
                        if (isset($task_type_arr_flp[strtolower(trim($v['type']))])) {
                            $easycase['type_id'] = $task_type_arr_flp[strtolower(trim($v['type']))];
                        } else {
                            $easycase['type_id'] = $selected_task_id['Easycase']['type_id'];
                        }
                        
                        if (isset($task_priority_arr_flp[strtolower(trim($v['priority']))])) {
                            $easycase['priority'] = $task_priority_arr_flp[strtolower(trim($v['priority']))];
                        } else {
                            $easycase['priority'] = $selected_task_id['Easycase']['priority'];
                        }
                        $start_date = (isset($v['comment date']) && $v['comment date']) ? $v['comment date'] : '';
                        if ($start_date != '') {
                            if (stristr($start_date, "-")) {
                                //$start_date = str_replace("-", "/", $start_date);
                            }
                            //$start_date = $this->Format->isValidDateTime($start_date) ? date('Y-m-d', strtotime($start_date)) : '';
                            $start_date = date('Y-m-d', strtotime($start_date));
                            if ($start_date) {
                                $created_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s', strtotime($start_date)), "datetime");
                            } else {
                                $created_date = GMT_DATETIME;
                            }
                        } else {
                            $created_date = GMT_DATETIME;
                        }
                        
                        $easycase['uniq_id'] = $this->Format->generateUniqNumber();
                        $easycase['actual_dt_created'] = $created_date;
                        $easycase['dt_created'] = $created_date;
                        $easycase['isactive'] = 1;
                        $easycase['format'] = 2;
                        $easycase['istype'] = 2;
                        $easycase['title'] = '';
                        $easycase['status'] = 1;
                        $easycase['estimated_hours'] = 0;
                        $easycase['client_status'] = 0;
                        $easycase['completed_task'] = 0;
                        $easycase['is_chrome_extension'] = 0;
                        $easycase['story_point'] = 0;
                        $easycase['hours'] = 0;
                        $easycase['parent_task_id'] = 0;
                        $easycase['is_recurring'] = 0;
                        $easycase['seq_id'] = 0;
                        $this->Easycase->create();
                        if ($this->Easycase->save($easycase)) {
                            $updarr = array('thread_count'=>'thread_count+1','case_count'=>'case_count+1');
                            if ($selected_task_id['Easycase']['priority'] != $easycase['priority']) {
                                $updarr = array('thread_count'=>'thread_count+1','case_count'=>'case_count+1','priority'=>$easycase['priority']);
                            }
                            if ($selected_task_id['Easycase']['legend'] != $easycase['legend']) {
                                $updarr = array('thread_count'=>'thread_count+1','case_count'=>'case_count+1','priority'=>$easycase['priority'],'legend'=>$easycase['legend']);
                            }
                            if ($selected_task_id['Easycase']['assign_to'] != $easycase['assign_to']) {
                                $updarr = array('thread_count'=>'thread_count+1','case_count'=>'case_count+1','priority'=>$easycase['priority'],'legend'=>$easycase['legend'],'assign_to'=>$easycase['assign_to']);
                            }
                            if ($selected_task_id['Easycase']['type_id'] != $easycase['type_id']) {
                                $updarr = array('thread_count'=>'thread_count+1','case_count'=>'case_count+1','priority'=>$easycase['priority'],'legend'=>$easycase['legend'],'assign_to'=>$easycase['assign_to'],'type_id'=>$easycase['type_id']);
                            }
                            $this->Easycase->updateAll($updarr, array('id' => $current_id, 'project_id' => $project_id, 'istype' => 1));
                        }
                    }
                }
                $this->set('total_valid_rows', $actual_rows_imported);
                $this->set('csv_file_name', $this->data['csv_file_name']);
                $this->set('total_rows', $this->data['total_rows']);
                $this->set('display_resullt', 1);
                //import end
                /*$this->set('task', $task);
                $this->set('task_err', $task_err);
                $this->set('preview_data', 1);
                $this->set('fileds', $fileds);
                $this->set('csv_file_name', $csv_info['name']);
                $this->set('total_rows', $linecount);*/
                $this->set('new_file_name', $file_name);
                $this->render('importcomment');
            } else {
                $this->Session->write("ERROR", __("Please import a valid CSV file", true));
                $this->redirect(HTTP_ROOT . "projects/importcomment/");
            }
        } else {
            $this->Session->write("ERROR", __("Please import a valid CSV file", true));
            $this->redirect(HTTP_ROOT . "projects/importcomment/");
        }
    }
    public function deleteCommentCsvFile()
    {
        $this->layout = 'ajax';
        if ($this->data['file']) {
            $fl = trim($this->data['file']);
            if (file_exists(CSV_PATH . "task_comment/" . $fl)) {
                unlink(CSV_PATH . "task_comment/" . $fl);
            }
        }
        echo 1;
        exit;
    }
    public function checkcomntfile_existance()
    {
        $file_info = $_FILES['file-0'];
        $file_name = SES_ID . "_comment_" . $file_info['name'];
        //echo $file_name;exit;
        $directory = CSV_PATH . "task_comment";
        $err = 0;
        $arr = null;
        if ($handle = opendir($directory)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." && $entry != "..") {
                    if (trim($file_name) == trim($entry)) {
                        $filesize = filesize($directory . '/' . $file_name);
                        if ($file_info['size'] == $filesize) {
                            $arr['msg'] = __("Already a file with same name and same size of")." " . $filesize . " ".__("bytes exists. Would you like to replace the existing file?");
                        } else {
                            $arr['msg'] = __("Already file with same name and size of")." ". $filesize ." ".__(" bytes exists. Would you like to replace the existing file?");
                        }
                        $err = 1;
                        $arr['success'] = 0;
                        $arr['error'] = 1;
                    }
                }
            }
            closedir($handle);
            if (!$err) {
                $arr['success'] = 1;
                $arr['msg'] = "";
                $arr['error'] = 0;
            }
            echo json_encode($arr);
            exit;
        }
    }
    /**
     * @method public download_sample_comntcsvfile
     * @author Andola  <info@andolasoft.com>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
     */
    public function download_sample_comntcsvfile()
    {
        $myFile = 'Orangescrum_Import_Comment_Sample.csv';
        $path = CSV_PATH . "task_comment/" . $myFile;
        $this->response->file($path, array('download' => true, 'name' => $myFile,));
        return $this->response;
    }
    public function assign_role()
    {
        $this->layout = 'ajax';
        $projid = $this->params->data['pjid'];
        $pjname = urldecode($this->params->data['pjname']);
        $cntmng = $this->params->data['cntmng'];
        $query = "";
        if (isset($this->params->data['name']) && trim($this->params->data['name'])) {
            $srchstr = addslashes($this->params->data['name']);
            $query = "AND User.name LIKE '%$srchstr%'";
        }

        $ProjectUser = ClassRegistry::init('ProjectUser');
        $ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $Role = ClassRegistry::init('Role');
        $Role->unbindModel(array('belongsTo' => array('Company')));
        $roles = $Role->find('list', array('conditions' => array('Role.company_id' => array(SES_COMP, 0), 'Role.id NOT IN(1,699)')));
        if (SES_TYPE == 1) {
            $memsExstArr = $ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type,CompanyUser.role_id,ProjectUser.id, if(ProjectUserRole.role!='',ProjectUserRole.role,CompanyUserRole.role) as role, if(ProjectUserRole.role!='',ProjectUser.role_id,CompanyUser.role_id) as role_id FROM `users` AS User left join company_users AS CompanyUser on CompanyUser.user_id=User.id left join roles AS CompanyUserRole on CompanyUserRole.id=CompanyUser.role_id left join project_users AS ProjectUser on ProjectUser.user_id=User.id left join roles AS ProjectUserRole on ProjectUserRole.id=ProjectUser.role_id WHERE User.isactive='1' AND User.name!='' " . $query . " AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND ProjectUser.project_id=" . $projid . " AND CompanyUser.user_type NOT IN(1,2) ORDER BY User.name");
        } else {
            $memsExstArr = $ProjectUser->query("SELECT DISTINCT User.id,User.name,User.email,User.istype,User.short_name,CompanyUser.user_type,CompanyUser.role_id,ProjectUser.id, if(ProjectUserRole.role!='',ProjectUserRole.role,CompanyUserRole.role) as role, if(ProjectUserRole.role!='',ProjectUser.role_id,CompanyUser.role_id) as role_id FROM `users` AS User left join company_users AS CompanyUser on CompanyUser.user_id=User.id left join roles AS CompanyUserRole on CompanyUserRole.id=CompanyUser.role_id left join project_users AS ProjectUser on ProjectUser.user_id=User.id left join roles AS ProjectUserRole on ProjectUserRole.id=ProjectUser.role_id WHERE User.isactive='1' AND User.name!='' " . $query . " AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND ProjectUser.project_id=" . $projid . " AND CompanyUser.user_type NOT IN(1,2) ORDER BY User.name");
        }
        $this->set('pjname', $pjname);
        $this->set('projid', $projid);
        $this->set('memsExstArr', $memsExstArr);
        $this->set('roles', $roles);
        $this->set('cntmng', $cntmng);
    }
    public function assign_role_usr()
    {
        $this->layout = 'ajax';
        $usrid = $this->params->data['usrid'];
        $usrname = urldecode($this->params->data['usrname']);
        // $cntmng = $this->params->data['cntmng'];
        $query = "";
        if (isset($this->params->data['name']) && trim($this->params->data['name'])) {
            $srchstr = addslashes($this->params->data['name']);
            $query = "AND User.name LIKE '%$srchstr%'";
        }

        $ProjectUser = ClassRegistry::init('ProjectUser');
        $ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $Role = ClassRegistry::init('Role');
        $Role->unbindModel(array('belongsTo' => array('Company')));
        $roles = $Role->find('list', array('conditions' => array('Role.company_id' => array(SES_COMP, 0), 'Role.id NOT IN(1,699)')));

        if (SES_TYPE == 1) {
            $memsExstArr = $ProjectUser->query("SELECT DISTINCT Project.id,Project.name,Project.short_name,Project.uniq_id,User.id,CompanyUser.role_id,ProjectUser.id, if(ProjectUserRole.role!='',ProjectUserRole.role,CompanyUserRole.role) as role, if(ProjectUserRole.role!='',ProjectUser.role_id,CompanyUser.role_id) as role_id FROM `users` AS User left join company_users AS CompanyUser on CompanyUser.user_id=User.id left join roles AS CompanyUserRole on CompanyUserRole.id=CompanyUser.role_id left join project_users AS ProjectUser on ProjectUser.user_id=User.id left join roles AS ProjectUserRole on ProjectUserRole.id=ProjectUser.role_id left join projects AS Project ON ProjectUser.project_id=Project.id  WHERE User.isactive='1' AND User.name!='' " . $query . " AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND ProjectUser.user_id=" . $usrid . " AND ProjectUser.company_id=" . SES_COMP . "  ORDER BY Project.name");
        } else {
            $memsExstArr = $ProjectUser->query("SELECT DISTINCT Project.id,Project.name,Project.short_name,Project.uniq_id,User.id,CompanyUser.role_id,ProjectUser.id, if(ProjectUserRole.role!='',ProjectUserRole.role,CompanyUserRole.role) as role, if(ProjectUserRole.role!='',ProjectUser.role_id,CompanyUser.role_id) as role_id FROM `users` AS User left join company_users AS CompanyUser on CompanyUser.user_id=User.id left join roles AS CompanyUserRole on CompanyUserRole.id=CompanyUser.role_id left join project_users AS ProjectUser on ProjectUser.user_id=User.id left join roles AS ProjectUserRole on ProjectUserRole.id=ProjectUser.role_id left join projects AS Project ON ProjectUser.project_id=Project.id WHERE User.isactive='1' AND User.name!='' " . $query . " AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active='1' AND ProjectUser.user_id=" . $usrid . " AND ProjectUser.company_id=" . SES_COMP . " ORDER BY Project.name");
        }
        $this->set('usrname', $usrname);
        $this->set('usrid', $usrid);
        $this->set('memsExstArr', $memsExstArr);
        $this->set('roles', $roles);
        $this->set('cntmng', $cntmng);
    }
    public function assignProjectUserRole()
    {
        $this->layout = 'ajax';
        $data = array();
        parse_str($this->request->data['projectroles'], $data);
        $this->loadModel('ProjectUser');

        $this->loadModel('RoleAction');
        //  $this->loadModel('ProjectAction');
        $project_id = $data['project_id'];
        $user_id = $data['user_id'];
        //   $this->ProjectAction->deleteAll(array('ProjectAction.project_id' => $project_id));
        foreach ($data['data']['ProjectUser']['id'] as $k => $val) {
            $this->ProjectUser->id = $val;
            $this->ProjectUser->saveField('role_id', $data['data']['ProjectUser']['role_id'][$k]);
            if (Cache::read('userRole'.SES_COMP.'_'.$data['data']['ProjectUser']['user_id'][$k]) !== false) {
                Cache::delete('userRole'.SES_COMP.'_'.$data['data']['ProjectUser']['user_id'][$k]);
            }
            /*   $actions = $this->RoleAction->find('all', array('conditions' => array('RoleAction.company_id' => SES_COMP, 'RoleAction.role_id' => $data['data']['ProjectUser']['role_id'][$k]), 'fields' => array('RoleAction.role_id', 'RoleAction.action_id', 'RoleAction.is_allowed')));
              if (!empty($actions)) {
              foreach ($actions as $k => $action) {
              $action['ProjectAction'] = $action['RoleAction'];
              $action['ProjectAction']['project_id'] = $project_id;
              unset($action['RoleAction']);
              $this->ProjectAction->saveAll($action);
              }
              } */
        }
        echo 1;
        exit;
    }

    public function manage_role()
    {
        $this->layout = 'ajax';
        $roleId = $this->request->data['roleId'];
        $projectId = $this->request->data['project_id'];
        $project_name = $this->request->data['prjname'];
        $userId = $this->request->data['user_id'];
        $user_name = $this->request->data['user_name'];
        $this->loadModel('ProjectUser');
        $this->loadModel('RoleAction');
        //  $this->loadModel('ProjectAction');
        $this->loadModel('Module');
        $this->loadModel('Role');
        /*  $projectRoles = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.company_id' => SES_COMP, 'ProjectUser.project_id' => $projectId), 'fields' => 'DISTINCT ProjectUser.role_id as role', 'order' => 'role ASC'));
          $projectRoles = Hash::extract($projectRoles, '{n}.ProjectUser.role'); */
        //   $this->Role->unbindModel(array('belongsTo' => array('Company', 'RoleGroup'), 'hasMany' => array('RoleAction', 'CompanyUser')));
        $this->Role->unbindModel(array('belongsTo' => array('Company', 'RoleGroup')));
        //  $this->Role->bindModel(array('hasMany' => array('ProjectAction' => array('className' => 'ProjectAction', 'foreignKey' => 'role_id', 'conditions' => array('ProjectAction.project_id' => $projectId)))));
        $this->Role->bindModel(array('hasMany' => array('RoleAction' => array('className' => 'RoleAction', 'foreignKey' => 'role_id', 'conditions' => array('RoleAction.role_id' => $roleId)))));
        $roles = $this->Role->find('all', array('conditions' => array('Role.id' => $roleId)));

        $module_id = array();
        foreach ($roles as $k => $role) {
            $a = Hash::combine($role['RoleAction'], '{n}.action_id', '{n}.is_allowed');
            unset($roles[$k]['RoleAction']);
            $module_id = array_unique(Hash::extract($role['RoleModule'], '{n}.module_id'));
            $roles[$k]['RoleAction'] = $a;
        }
        #$projectRoles = $this->ProjectAction->find('all', array('conditions' => array('ProjectAction.project_id' => $projectId), 'fields' => array('ProjectAction.action_id', 'ProjectAction.is_allowed')));
        $this->Module->unbindModel(array('belongsTo' => array('Company')));
        $modules = $this->Module->find('all', array('conditions' => array('Module.is_active' => 1, 'Module.id' => $module_id)));
        #pr($modules);exit;
        $this->set(compact('roles', 'modules', 'projectId', 'project_name', 'userId', 'user_name'));
    }
    public function ajax_get_all_meta()
    {
        $this->layout = 'ajax';
            
        $this->loadModel("ProjectType");
        $All_ptypes = $this->ProjectType->getAllProjectType(SES_COMP);
        //array_unshift($All_ptypes, __('Select Type'));
        $All_ptypes[0] = __('Select Type');
        ksort($All_ptypes);
        $resJson['All_ptypes'] = $All_ptypes;
            
        $this->loadModel("ProjectStatus");
        $All_status = $this->ProjectStatus->getAllProjectStatus(SES_COMP);
        //array_unshift($All_status, __('Select Status'));
        $All_status[0] = __('Select Status');
        ksort($All_status);
        $resJson['All_psttaus'] = $All_status;
            
        $this->loadModel('Industry');
        $industries = $this->Industry->find('list', array('conditions' => array('Industry.is_display' => 1),'fields' => array('Industry.id', 'Industry.name'),'limit'=>29));
        //array_unshift($industries, __('Select Industry'));
        $industries[0] = __('Select Industry');
        ksort($industries);
        $resJson['All_industry'] = $industries;
            
            
        $this->loadModel('CompanyUser');
        $this->CompanyUser->bindModel(
            array(
                            'belongsTo'=>array(
                                'User' => array(
                                    'className' => 'User',
                                    'foreignKey' => 'user_id',
                                )
                            )
                        )
        );
        $this->CompanyUser->recursive = 2;
        $ActiveUsers = $this->CompanyUser->find("all", array("conditions" => array('CompanyUser.is_active' => 1,'CompanyUser.company_id' => SES_COMP), 'fields' => array('User.uniq_id','User.name','User.last_name'),'order'=>array('CompanyUser.user_type'=>'ASC')));
        $act_users = array('0'=>__('Select Project Manager'));
        if ($ActiveUsers) {
            foreach ($ActiveUsers as $k => $v) {
                $act_users[$v['User']['uniq_id']] = trim($v['User']['name'].' '.$v['User']['last_name']);
            }
        }
        $resJson['All_managers'] = $act_users;
        $options = array();
        $options['fields'] = array('id', "currency", "CONCAT_WS(' ',title,first_name,last_name) AS name");
        $options['conditions'] = array('company_id' => SES_COMP, 'status' => 'Active');
        $options['order'] = 'first_name ASC';
        $all_customers = array();
        array_unshift($all_customers, __('Select Customer'));
        $all_customers['__new'] = '+ Add New';
        $resJson['All_customers'] = $all_customers;
        echo json_encode($resJson);
        exit;
    }
    public function ajax_addProjectType()
    {
        $this->layout = 'ajax';
        $jsonArr = array('status' => 'error');
        if (!empty($this->request->data['name'])) {
            $this->loadModel("ProjectType");
            $count_type = $this->ProjectType->getProjectType(SES_COMP, trim($this->request->data['name']));
            if (!$count_type) {
                $jsonArr['status'] = 'success';
                $data = array();
                $data['title'] = $this->request->data['name'];
                $data['company_id'] = SES_COMP;
                $data['user_id'] = SES_ID;
                $this->ProjectType->id = '';
                if ($this->ProjectType->save($data)) {
                    $id = $this->ProjectType->getLastInsertID();
                    $jsonArr['msg'] = 'saved';
                    $jsonArr['id'] = $id;
                } else {
                    $jsonArr['msg'] = 'not saved';
                }
            } else {
                if (trim(strtolower($count_type['ProjectType']['name'])) == strtolower(trim($this->request->data['name']))) {
                    $jsonArr['msg'] = 'name';
                }
            }
        }
        echo json_encode($jsonArr);
        exit;
    }
    public function ajax_addProjectStatus()
    {
        $this->layout = 'ajax';
        $jsonArr = array('status' => 'error');
        if (!empty($this->request->data['name'])) {
            $this->loadModel("ProjectStatus");
            $count_Status = $this->ProjectStatus->getProjectStatus(SES_COMP, trim($this->request->data['name']));
            if (!$count_Status) {
                $jsonArr['status'] = 'success';
                $data = array();
                $data['name'] = $this->request->data['name'];
                $data['company_id'] = SES_COMP;
                $data['user_id'] = SES_ID;
                $this->ProjectStatus->id = '';
                if ($this->ProjectStatus->save($data)) {
                    $id = $this->ProjectStatus->getLastInsertID();
                    $jsonArr['msg'] = 'saved';
                    $jsonArr['id'] = $id;
                } else {
                    $jsonArr['msg'] = 'not saved';
                }
            } else {
                if (trim(strtolower($count_Status['ProjectStatus']['name'])) == strtolower(trim($this->request->data['name']))) {
                    $jsonArr['msg'] = 'name';
                }
            }
        }
        echo json_encode($jsonArr);
        exit;
    }
    public function createAssociatedWorkFlow($statusId, $short_name='')
    {
        $this->loadModel('StatusGroup');
        $this->loadModel('CustomStatus');
        $status = $this->StatusGroup->find('first', array('conditions'=>array('StatusGroup.id'=>$statusId)));
        if (!empty($status)) {
            /* insert status group id 0 in project table if status is default status group */
            if ($status['StatusGroup']['name'] == 'Default Status Workflow') {
                return 0;
            }
            $status['StatusGroup']['id'] = '';
            $status['StatusGroup']['parent_id'] = $statusId;
            $status['StatusGroup']['is_default'] = 0;
            $status['StatusGroup']['created_by'] = SES_ID;
            $status['StatusGroup']['company_id'] = SES_COMP;
            $short_name = ($short_name != '') ?"-".strtoupper($short_name):'';
            $status['StatusGroup']['name'] = $status['StatusGroup']['name'].$short_name;
            unset($status['StatusGroup']['created']);
            unset($status['StatusGroup']['modified']);
            $this->StatusGroup->save($status);
            $ID = $this->StatusGroup->getLastInsertID();
            $allCustomStatus = $this->CustomStatus->find('all', array('conditions'=>array('CustomStatus.status_group_id'=>$statusId),'order'=>array('CustomStatus.id'=>'ASC')));
            $customstatus = array();
            foreach ($allCustomStatus as $k=>$v) {
                $customstatus[$k]['company_id'] = SES_COMP;
                $customstatus[$k]['name'] = $v['CustomStatus']['name'];
                $customstatus[$k]['progress'] = $v['CustomStatus']['progress'];
                $customstatus[$k]['color'] = $v['CustomStatus']['color'];
                $customstatus[$k]['status_master_id'] = $v['CustomStatus']['status_master_id'];
                $customstatus[$k]['status_group_id'] = $ID;
                $customstatus[$k]['seq'] = $v['CustomStatus']['seq'];
            }
            if ($customstatus) {
                $this->CustomStatus->saveAll($customstatus);
            }
            return $ID;
        } else {
            return $statusId;
        }
    }
    public function importmpp($proj_id = '', $radio = '', $page = '', $all = '', $pname = '', $srch = '')
    {
        if (!$proj_id && (!isset($GLOBALS['getallproj'][0]['Project']['uniq_id']) && $GLOBALS['getallproj'][0]['Project']['uniq_id'])) {
            $this->redirect(HTTP_ROOT . 'projects/manage/');
            exit;
        } else {
            if (!empty($proj_id) && $proj_id == 'all') {
                $this->set('upload_file', 1);
                $this->set('proj_id', $proj_id);
                $this->set('proj_uid', $radio);
                $this->set('import_pjname', $proj_id);
            } else {
                if (!$proj_id) {
                    $proj_id = $GLOBALS['getallproj'][0]['Project']['uniq_id'];
                }
                $this->Project->recursive = -1;
                $proj_details = $this->Project->find('first', array('conditions' => array('uniq_id' => $proj_id, 'company_id' => SES_COMP)));
                if (defined("ROLE") && ROLE == 1) {
                    if ($proj_details && (SES_TYPE <= 2 || array_key_exists("View Import Export", $GLOBALS['roleAccess']) && $GLOBALS['roleAccess']['View Import Export'] == 1)) {
                        $this->set('upload_file', 1);
                        $this->set('proj_id', $proj_details['Project']['id']);
                        $this->set('proj_uid', $proj_id);
                        $this->set('import_pjname', $proj_details['Project']['name']);
                    } else {
                        $this->redirect(HTTP_ROOT . 'projects/manage/');
                        exit;
                    }
                } else {
                    if ($proj_details && (SES_TYPE <= 2)) {
                        $this->set('upload_file', 1);
                        $this->set('proj_id', $proj_details['Project']['id']);
                        $this->set('proj_uid', $proj_id);
                        $this->set('import_pjname', $proj_details['Project']['name']);
                    } else {
                        $this->redirect(HTTP_ROOT . 'projects/gridview/');
                        exit;
                    }
                }
            }
        }
        $tokn = $this->Format->genRandomStringCustom(25);
        $_SESSION['CSRFTOKEN'] = $tokn;
    }
    /**
            * @method public download_sample_csv_file
            * @author Andola  <info@andolasoft.com>
            * @copyright (c) 2013, Andolsoft Pvt Ltd.
        */
    public function download_sample_csvfile_mpp()
    {
        $myFile = 'Orangescrum_Import_Task_Sample_Mpp.xlsx';
        header('HTTP/1.1 200 OK');
        header('Cache-Control: no-cache, must-revalidate');
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Content-type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=Orangescrum_Import_Task_Sample.xlsx");
        readfile(CSV_PATH . "task_milstone/" . $myFile);
        exit;
    }
    public function mpp_dataimport()
    {
        $this->Session->write('mppimportflag', 1);
        $project_id = $this->data['proj_id'];
        $project_uid = $this->data['proj_uid'];
        $task_type_arr = array('enhancement', 'enh', 'bug', 'research n do', 'rnd', 'quality assurance', 'qa', 'unit testing', 'unt', 'maintenance', 'mnt', 'others', 'oth', 'release', 'rel', 'update', 'upd', 'development', 'dev');
        //$task_status_arr = array('new', 'close', 'wip', 'resolve', 'resolved', 'closed');
        $task_status_arr = array();
        $this->loadModel('User');
        $this->loadModel('ProjectUser');
        $this->loadModel('CompanyUser');
        $this->Project->recursive = -1;
        if ($project_id != 'all') {
            // to get list of statuses present in the selected projects
            /*$status_name = $this->Project->query("SELECT status.name AS Name from statuses as status LEFT JOIN projects as project ON status.workflow_id = project.workflow_id WHERE project.id =" . $project_id . " ORDER BY status.seq_order ASC");
            foreach ($status_name as $s => $sn) {
                $task_status_arr[] = strtolower($sn['status']['Name']);
            }*/
                
            $task_data_arr = array();
            $task_data_arr = $this->Easycase->find('list', array('fields' => array('Easycase.id', 'Easycase.title'), 'conditions' => array('Easycase.project_id' => $project_id, 'Easycase.istype' => 1)));
            if (!empty($task_data_arr)) {
                $task_data_arr = array_flip($task_data_arr);
                $task_data_arr = array_change_key_case($task_data_arr, CASE_LOWER);
                $task_data_arr = array_flip($task_data_arr);
            }
            //pr($task_data_arr);exit;
            $task_is_billabe = array(0, 1);
            $task_assign_to_userid = $this->ProjectUser->find('list', array('conditions' => array('company_id' => SES_COMP, 'project_id' => $project_id), 'fields' => 'user_id'));
            $task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => 'email'));
        }
        //$fields_arr = array('milestone title','milestone description','start date','end date','title','description','due date','status','type','assigned to');
        $fields_arr = array('Project', 'Milestone', 'Title', 'Assigned to', 'Start date', 'due date');
        $sheet_arr = array('Task_Table', 'Resource_Table', 'Assignment_table');
        if (isset($_FILES['import_mpp_file'])) {
            $ext = pathinfo($_FILES['import_mpp_file']['name'], PATHINFO_EXTENSION);
            if (strtolower($ext) == 'xls' || strtolower($ext) == 'xlsx') {
                $csv_info = $_FILES['import_mpp_file'];
                //Uploading the csv file to Our server
                $file_name = SES_ID . "_" . $project_id . "_" . $csv_info['name'];
                @copy($csv_info['tmp_name'], CSV_PATH . "tasks_csv/" . $file_name);
                $row = 1;
                $linecount = count(file(CSV_PATH . "tasks_csv/" . $file_name));
                if ($csv_info['size'] > 2097152) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "tasks_csv/" . $file_name);
                    $this->Session->write("ERROR", __("Please upload a file with size less then 2MB"));
                    $this->redirect(HTTP_ROOT . "projects/importMpp/" . $project_uid);
                    exit;
                }
                $inputFileName = CSV_PATH . "tasks_csv".DS. $file_name; //'./sampleData/example1.xls';
                //$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                    
                    
                    
                //  Create a new Reader of the type that has been identified
                //$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('xlsx');
                var_dump($reader);
                exit;
                $reader->setLoadAllSheets();
                //  Load $inputFileName to a Spreadsheet Object
                //Parsing the csv file
                if ($spreadsheet = $reader->load($inputFileName)) {
                    $loadedSheetNames = $spreadsheet->getSheetNames();
                    $sheetTask_Table = $sheetResource_Table = $sheetAssignment_table = $sheet_arr = array();
                    foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                        $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
                        $sheet_arr[] = $loadedSheetName;
                        if ($loadedSheetName == "Task_Table") {
                            $sheetTask_Table = $spreadsheet->getActiveSheet()->toArray();
                        }
                        if ($loadedSheetName == "Resource_Table") {
                            $sheetResource_Table = $spreadsheet->getActiveSheet()->toArray();
                        }
                        if ($loadedSheetName == "Assignment_Table") {
                            $sheetAssignment_table = $spreadsheet->getActiveSheet()->toArray();
                        }
                    }
                    if (in_array('Task_Table', $sheet_arr) && in_array('Resource_Table', $sheet_arr) && in_array('Assignment_Table', $sheet_arr)) {
                        $usr_arrys = $tsk_usr_arry = $tsk_arry = array();
                        if ($sheetResource_Table) {
                            for ($i = 1; $i < count($sheetResource_Table); $i ++) {
                                $usr_arrys[$sheetResource_Table[$i][1]] = $sheetResource_Table[$i][6];
                            }
                        }
                        if ($sheetAssignment_table) {
                            for ($i = 1; $i < count($sheetAssignment_table); $i ++) {
                                $tsk_usr_arry[$sheetAssignment_table[$i][0]] = $sheetAssignment_table[$i][1];
                            }
                        }
                        if ($sheetTask_Table) {
                            for ($i = 1; $i < count($sheetTask_Table); $i ++) {
                                $tsk_arry[$i - 1]['tsk_title'] = $sheetTask_Table[$i][3];
                                $strtdt = date("Y-m-d H:i:s", strtotime($sheetTask_Table[$i][5]));
                                $tsk_arry[$i - 1]['tsk_start_date'] = $sheetTask_Table[$i][5];
                                $tsk_arry[$i - 1]['tsk_start_end'] = $sheetTask_Table[$i][6];
                                $tsk_arry[$i - 1]['tsk_order'] = $sheetTask_Table[$i][8];
                                $tsk_arry[$i - 1]['tsk_msg'] = $sheetTask_Table[$i][9];
                            }
                        }
                    } else {
                        $this->Session->write("ERROR", __("Please import a valid file"));
                        $this->redirect(HTTP_ROOT . "projects/importMpp/" . $project_uid);
                        exit;
                    }
                }
                if ($project_id != 'all') {
                    $this->Project->recursive = -1;
                    $projectdata = $this->Project->findById($project_id);
                    $projectname = $projectdata['Project']['name'];
                }
                    
                pr($task_err);
                pr($tsk_arry);
                exit;
                    
                $this->set('projectname', $projectname);
                $this->set('porj_id', $project_id);
                $this->set('porj_uid', $project_uid);
                $this->set('tsk_usr_arry', $tsk_usr_arry);
                $this->set('usr_arrys', $usr_arrys);
                $this->set(compact('project_list'));
                $this->set('pro_type', $project_id);
                $this->set('task', $tsk_arry);
                $this->set('task_err', $task_err);
                $this->set('preview_data', 1);
                $this->set('fileds', $fields_arr);
                $this->set('csv_file_name', $csv_info['name']);
                $this->set('total_rows', $linecount);
                $this->set('new_file_name', $file_name);
                $this->render('importMpp');
            } else {
                $this->Session->write("ERROR", __("Please import a valid file"));
                $this->redirect(HTTP_ROOT . "projects/importMpp/" . $project_uid);
                exit;
            }
        } else {
            $this->Session->write("ERROR", __("Please import a valid file"));
            $this->redirect(HTTP_ROOT . "projects/importMpp/" . $project_uid);
            exit;
        }
    }
        
    /*function checkmppfile_existance() {
            $file_info = $_FILES['file-0'];
            $file_name = SES_ID . "_" . $this->data['porject_id'] . "_" . $file_info['name'];
            //echo $file_name;exit;
            $directory = CSV_PATH . "tasks_csv";
            if ($handle = opendir($directory)) {
                while (false !== ($entry = readdir($handle))) {
                    if ($entry != "." && $entry != "..") {
                        if ($file_name == $entry) {
                            $filesize = filesize($directory . '/' . $file_name);
                            if ($file_info['size'] == $filesize) {
                                $arr['msg'] = __("Already a file with same name and same size of", true) . $filesize . " " . __("bytes exists", true) . ". " . __("Would you like to replace the exsiting file", true) . "?";
                                } else {
                                $arr['msg'] = __("Already file with same name and size of", true) . $filesize . " " . __("bytes exists", true) . ". " . __("Would you like to replace the existing file", true) . "?";
                            }
                            $err = 1;
                            $arr['success'] = 0;
                            $arr['error'] = 1;
                        }
                        //echo "$entry<br/>";
                    }
                }
                closedir($handle);
                if (!$err) {
                    $arr['success'] = 1;
                    $arr['msg'] = "";
                    $arr['error'] = 0;
                }
                echo json_encode($arr);
                exit;
            }
        }*/
    
    public function confirm_import_mpp()
    {
        if (!empty($this->Session->read('mppimportflag'))) {
            $this->loadModel('Status');
            $this->loadModel('Milestone');
            $this->loadModel('Easycase');
            $this->loadModel('ProjectUser');
            $this->loadModel('EasycaseMilestone');
            $pro_id = trim($this->data['project_id']);
            $new_file_name = trim($this->data['new_mmp_file_name']);
            $this->Project->recursive = -1;
            $proj_dtls = $this->Project->find('first', array('conditions' => array('Project.id' => $pro_id)));
            $nw_sts = $this->Status->find('first', array('conditions' => array('Status.workflow_id' => $proj_dtls['Project']['workflow_id'], 'Status.percentage' => 0)));
            $inprgs_sts = $this->Status->find('first', array('conditions' => array('Status.workflow_id' => $proj_dtls['Project']['workflow_id'], 'Status.percentage >' => 0, 'Status.percentage <' => 100)));
            $clsd_sts = $this->Status->find('first', array('conditions' => array('Status.workflow_id' => $proj_dtls['Project']['workflow_id'], 'Status.percentage' => 100)));
            $milestone_list = $this->Milestone->find('list', array('conditions' => array('Milestone.project_id' => $pro_id), 'fields' => array('id', 'title')));
            $milestone_list = array_flip($milestone_list);
            $usrlst = $this->userList($pro_id, 'y');
            $proj_user_lst = array_flip($usrlst);
            $inputFileName = CSV_PATH . "tasks_csv/" . $new_file_name; //'./sampleData/example1.xls';
            $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
                
            //  Create a new Reader of the type that has been identified
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
            $reader->setLoadAllSheets();
            if ($spreadsheet = $reader->load($inputFileName)) {
                $loadedSheetNames = $spreadsheet->getSheetNames();
                    
                $sheetTask_Table = $sheetResource_Table = $sheetAssignment_table = array();
                foreach ($loadedSheetNames as $sheetIndex => $loadedSheetName) {
                    $spreadsheet->setActiveSheetIndexByName($loadedSheetName);
                    if ($loadedSheetName == "Task_Table") {
                        $sheetTask_Table = $spreadsheet->getActiveSheet()->toArray();
                    }
                    if ($loadedSheetName == "Resource_Table") {
                        $sheetResource_Table = $spreadsheet->getActiveSheet()->toArray();
                    }
                    if ($loadedSheetName == "Assignment_Table") {
                        $sheetAssignment_table = $spreadsheet->getActiveSheet()->toArray();
                    }
                    if ($loadedSheetName == "Tasks_with_Assignments") {
                        $sheetTaskWithAssignment_table = $spreadsheet->getActiveSheet()->toArray();
                    }
                }
                //   echo "<pre>";print_r($sheetTaskWithAssignment_arry);
                $usr_arrys = $tsk_usr_arry = $tsk_arry = $proj_usr_lst = $tsk_completion_arry = $tsk_estimt_arry = $sheetTaskWithAssignment_arry=array();
                if ($sheetTaskWithAssignment_table) {
                    for ($i=1;$i < count($sheetTaskWithAssignment_table);$i ++) {
                        if ($sheetTaskWithAssignment_table[$i][0] != 0) {
                            $j =0;
                            $sheetTaskWithAssignment_arry[$sheetTaskWithAssignment_table[$i][0]]['task_title'] = $sheetTaskWithAssignment_table[$i][3];
                            $sheetTaskWithAssignment_arry[$sheetTaskWithAssignment_table[$i][0]]['estimated_hours'] = $sheetTaskWithAssignment_table[$i][4];
                            $sheetTaskWithAssignment_arry[$sheetTaskWithAssignment_table[$i][0]]['start_date'] = $sheetTaskWithAssignment_table[$i][6];
                            $sheetTaskWithAssignment_arry[$sheetTaskWithAssignment_table[$i][0]]['due_date'] = $sheetTaskWithAssignment_table[$i][7];
                            $sheetTaskWithAssignment_arry[$sheetTaskWithAssignment_table[$i][0]]['work_complete'] = $sheetTaskWithAssignment_table[$i][8] <= 1 ? round($sheetTaskWithAssignment_table[$i][8] * 100) : 100;
                            $previous_data_id = $sheetTaskWithAssignment_table[$i][0];
                        } else {
                            $st_dts = explode('-', $sheetTaskWithAssignment_table[$i][6]);
                            $st_dts[2] = "20". $st_dts[2];
                            $sts_dts = implode('-', $st_dts);
                            $du_dts = explode('-', $sheetTaskWithAssignment_table[$i][7]);
                            $du_dts[2] = "20". $du_dts[2];
                            $dus_dts = implode('-', $du_dts);
                            $sheetTaskWithAssignment_arry[$previous_data_id]['User'][$j]['name'] = $sheetTaskWithAssignment_table[$i][3];
                            $sheetTaskWithAssignment_arry[$previous_data_id]['User'][$j]['estimated_hours'] = $sheetTaskWithAssignment_table[$i][4];
                            $sheetTaskWithAssignment_arry[$previous_data_id]['User'][$j]['start_date'] = date("d F Y", strtotime($sts_dts)) ." ".date('H:i:s', strtotime($sheetTaskWithAssignment_arry[$previous_data_id]['start_date']));
                            $sheetTaskWithAssignment_arry[$previous_data_id]['User'][$j]['due_date'] = date("d F Y", strtotime($dus_dts)) ." ".date('H:i:s', strtotime($sheetTaskWithAssignment_arry[$previous_data_id]['due_date']));
                            $j++;
                        }
                    }
                }
                    
                if ($sheetResource_Table) {
                    for ($i = 1; $i < count($sheetResource_Table); $i ++) {
                        $usr_arrys[$sheetResource_Table[$i][1]] = $sheetResource_Table[$i][6];
                    }
                }
                if ($sheetAssignment_table) {
                    for ($i = 1; $i < count($sheetAssignment_table); $i ++) {
                        $tsk_usr_arry[$sheetAssignment_table[$i][0]] = $sheetAssignment_table[$i][1];
                        $tsk_completion_arry[$sheetAssignment_table[$i][0]] = $sheetAssignment_table[$i][2];
                        $tsk_estimt_arry[$sheetAssignment_table[$i][0]] = $sheetAssignment_table[$i][3];
                        //    $tsk_estimt_arry[$i - 1] = $sheetAssignment_table[$i][3];
                    }
                }
                if ($sheetTask_Table) {
                    for ($i = 1; $i < count($sheetTask_Table); $i ++) {
                        $tsk_arry[$sheetTask_Table[$i][0]]['tsk_title'] = $sheetTask_Table[$i][3];
                        $tsk_arry[$sheetTask_Table[$i][0]]['tsk_start_date'] = $sheetTask_Table[$i][5];
                        $tsk_arry[$sheetTask_Table[$i][0]]['tsk_end_date'] = $sheetTask_Table[$i][6];
                        $tsk_arry[$sheetTask_Table[$i][0]]['tsk_order'] = $sheetTask_Table[$i][8];
                        $tsk_arry[$sheetTask_Table[$i][0]]['tsk_msg'] = $sheetTask_Table[$i][9];
                    }
                }
                //  echo "<pre>";print_r($tsk_arry);print_r($sheetTaskWithAssignment_arry);
                //  echo count($sheetTaskWithAssignment_arry[38]['User']);exit;
                if ($usr_arrys) {
                    foreach ($usr_arrys as $ulst => $ueml) {
                        if (array_key_exists($ueml, $proj_user_lst)) {
                            $proj_usr_lst[$ulst] = $proj_user_lst[$ueml];
                        } else {
                            if ($ueml) {
                                $proj_usr_lst[$ulst] = $this->invitenewuserimportMPP($ueml, $pro_id, SES_COMP);
                            } else {
                                $proj_usr_lst[$ulst] = 0;
                            }
                        }
                    }
                }
                //  echo "<pre>";print_r($sheetTaskWithAssignment_arry);print_r($tsk_arry);print_r($proj_usr_lst);exit;
                //  echo count($sheetTaskWithAssignment_arry[35]['User']);exit;
                $milestone_id = null;
                $parent_task_id = null;
                $caseNoArr = $this->Easycase->find('first', array('conditions' => array('Easycase.project_id' => $pro_id), 'fields' => array('MAX(Easycase.case_no) as caseno')));
                $caseNo = $caseNoArr[0]['caseno'] + 1;
                $no_task = 0;
                $tsk_est_arry = array();
                foreach ($tsk_arry as $tk => $tv) {
                    $milestone_arr = array();
                    $easycase = array();
                    $new_em = array();
                    $last_tsk_id = 0;
                    if ($tv['tsk_order'] == 1) {
                        if (array_key_exists($tv['tsk_title'], $milestone_list)) {
                            $milestone_id = $milestone_list[$tv['tsk_title']];
                        } else {
                            $milestone_arr['title'] = $tv['tsk_title'];
                            $strtdt = $tv['tsk_start_date'] ? date("Y-m-d H:i:s", strtotime($tv['tsk_start_date'])) : '';
                            $enddt = $tv['tsk_end_date'] ? date("Y-m-d H:i:s", strtotime($tv['tsk_end_date'])) : '';
                            $milestone_arr['start_date'] = $strtdt ? $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $strtdt, "datetime") : '';
                            $milestone_arr['end_date'] = $enddt ? $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $enddt, "datetime") : '';
                            $milestone_arr['project_id'] = $pro_id;
                            $milestone_arr['company_id'] = SES_COMP;
                            $milestone_arr['uniq_id'] = $this->Format->generateUniqNumber();
                            $milestone_arr['user_id'] = SES_ID;
                            $this->Milestone->save($milestone_arr);
                            $milestone_id = $this->Milestone->getLastInsertId();
                        }
                    } else {
                        $easycase['message'] = (isset($tv['tsk_msg']) && $tv['tsk_msg']) ? htmlspecialchars(trim($tv['tsk_msg']), ENT_QUOTES) : '';
                        $easycase['title'] = (isset($tv['tsk_title']) && $tv['tsk_title']) ? trim($tv['tsk_title']) : '';
                        $due_date = $tv['tsk_end_date'] ? date("Y-m-d H:i:s", strtotime($tv['tsk_end_date'])) : '';
                        $created_date = GMT_DATETIME;
                        $start_date = $tv['tsk_start_date'] ? date("Y-m-d H:i:s", strtotime($tv['tsk_start_date'])) : '';
                        $easycase['actual_dt_created'] = $created_date;
                        $easycase['dt_created'] = $created_date;
                        $easycase['gantt_start_date'] = $start_date ? $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $start_date, "datetime") : '';
                        $proj_usr_lst[$tsk_usr_arry[$tv['tsk_title']]] ? $proj_usr_lst[$tsk_usr_arry[$tv['tsk_title']]] : 0;
                        $easycase['due_date'] = $due_date ? $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $due_date, "datetime") : '';
                        if (array_key_exists($tk, $sheetTaskWithAssignment_arry) && $sheetTaskWithAssignment_arry[$tk]['work_complete'] && $sheetTaskWithAssignment_arry[$tk]['work_complete'] > 0 && $sheetTaskWithAssignment_arry[$tk]['work_complete'] != 100) {
                            $legend = $inprgs_sts['Status']['id'];
                        } elseif (array_key_exists($tk, $sheetTaskWithAssignment_arry) && $sheetTaskWithAssignment_arry[$tk]['work_complete'] && $sheetTaskWithAssignment_arry[$tk]['work_complete'] == 100) {
                            $legend = $clsd_sts['Status']['id'];
                        } elseif (array_key_exists($tk, $sheetTaskWithAssignment_arry) &&  $sheetTaskWithAssignment_arry[$tk]['work_complete'] == 0) {
                            $legend = $nw_sts['Status']['id'];
                        } else {
                            $legend = $nw_sts['Status']['id'];
                        }
                        $easycase['legend'] = $legend;
                        $easycase['previous_legend'] = $legend;
                        $easycase['completed_task'] = array_key_exists($tk, $sheetTaskWithAssignment_arry) ? $sheetTaskWithAssignment_arry[$tk]['work_complete'] : 0;
                        $easycase['type_id'] = 2;
                        $easycase['user_id'] = SES_ID;
                        $easycase['project_id'] = $pro_id;
                        $easycase['priority'] = 1;
                        $easycase['case_no'] = $caseNo;
                        $easycase['uniq_id'] = md5(uniqid());
                        $easycase['isactive'] = 1;
                        $easycase['format'] = 2;
                        $easycase['istype'] = 1;
                        $easycase['estimated_hours'] = array_key_exists($tk, $sheetTaskWithAssignment_arry) ? round($sheetTaskWithAssignment_arry[$tk]['estimated_hours'] * 3600) : 0;
                        //     $easycase['estimated_hours'] = array_key_exists($tk, $tsk_estimt_arry) ? round($tsk_estimt_arry[$tk] * 3600) : 0;
                        if ($tv['tsk_order'] == 3) {
                            $prnt_task_id = $parent_task_id;
                        }
                        if ($tv['tsk_order'] == 4) {
                            $prnt_task_id = $subparent_task_id;
                        }
                        $easycase['parent_task_id'] = ($tv['tsk_order'] == 3 || $tv['tsk_order'] == 4) ? $prnt_task_id : '';
                        $chck_tsk = $this->Easycase->find('first', array('conditions'=>array('Easycase.title'=>trim($tv['tsk_title']),'Easycase.project_id'=>$pro_id,'Easycase.istype'=>1,'Easycase.parent_task_id'=>$easycase['parent_task_id'])));
                        if ($chck_tsk) {
                            $easycase['id'] = $chck_tsk['Easycase']['id'];
                        }
                        $easycase['case_no'] = $chck_tsk ? $chck_tsk['Easycase']['case_no'] : $caseNo++;
                            
                        $easycase['is_multiple_assign'] = array_key_exists($tk, $sheetTaskWithAssignment_arry) ? $sheetTaskWithAssignment_arry[$tk]['User'] && count($sheetTaskWithAssignment_arry[$tk]['User']) > 1 ? 1 : 0 : 0;
                        $easycase['assign_to'] = array_key_exists($tk, $sheetTaskWithAssignment_arry) ? $sheetTaskWithAssignment_arry[$tk]['User'] ? $easycase['is_multiple_assign'] == 0 ? $proj_usr_lst[$sheetTaskWithAssignment_arry[$tk]['User'][0]['name']] : "0" : "0" : "0";
                            
                            
                        $this->Easycase->create();
                        $this->Easycase->save($easycase);
                        $tsk_estimate_hr = ceil($easycase['estimated_hours'] / 3600);
                        $proj_dtls = $this->Project->findById($easycase['project_id']);
                        $new_project_estimate_hr = $proj_dtls['Project']['estimated_hours'] + $tsk_estimate_hr;
                        $new_prjct_estmate_hr['Project']['estimated_hours'] = $new_project_estimate_hr;
                        $this->Project->id = $proj_dtls['Project']['id'];
                        //     $this->Project->save($new_prjct_estmate_hr);
                        $no_task++;
                        $last_tsk_id = $chck_tsk ? $chck_tsk['Easycase']['id'] : $this->Easycase->getLastInsertId();
                        if ($tv['tsk_order'] == 2) {
                            $parent_task_id = $last_tsk_id;
                        }
                        if ($tv['tsk_order'] == 3) {
                            $subparent_task_id = $last_tsk_id;
                        }
                        /*if ($tv['tsk_order'] == 2) {
                            $tsk_est_arry[$last_tsk_id] = array();
                            }
                            if ($tv['tsk_order'] == 3) {
                            //  $tsk_sub_arry = array($last_tsk_id=>$easycase['estimated_hours']);
                            //   array_push($tsk_est_arry,$tsk_sub_arry);
                            $tsk_est_arry[$parent_task_id] = array($last_tsk_id=>$easycase['estimated_hours']);
                            }
                            if ($tv['tsk_order'] == 4) {
                            $tsk_est_arry[$parent_task_id] = array($subparent_task_id=>array($last_tsk_id => $easycase['estimated_hours']));
                        } */
                        if ($sheetTaskWithAssignment_arry[$tk]['User']) {
                            $tsk_user_update_arry[$tk]['easycase_id'] = $last_tsk_id ;
                            $tsk_user_update_arry[$tk]['easycase_title'] = $easycase['title'] ;
                            $tsk_user_update_arry[$tk]['User'] = $sheetTaskWithAssignment_arry[$tk]['User'];
                        }
                            
                        if ($last_tsk_id) {
                            if ($milestone_id > 0 && !$chck_tsk) {
                                $new_em['EasycaseMilestone']['project_id'] = $pro_id;
                                $new_em['EasycaseMilestone']['company_id'] = SES_COMP;
                                $new_em['EasycaseMilestone']['user_id'] = SES_ID;
                                $new_em['EasycaseMilestone']['easycase_id'] = $last_tsk_id;
                                $new_em['EasycaseMilestone']['milestone_id'] = $milestone_id;
                                $this->EasycaseMilestone->create();
                                $this->EasycaseMilestone->save($new_em);
                            }
                        }
                    }
                    //  $no_task++;
                }
                if ($tsk_user_update_arry) {
                    $this->loadModel('EasycaseUser');
                    foreach ($tsk_user_update_arry as $tuk => $tuv) {
                        foreach ($tuv['User'] as $uk => $uv) {
                            $end_date = $uv['due_date'] ? date("Y-m-d H:i:s", strtotime($uv['due_date'])) : '';
                            $start_date = $uv['start_date'] ? date("Y-m-d H:i:s", strtotime($uv['start_date'])) : '';
                            $esycs_arry['user_id'] = $proj_usr_lst[$uv['name']];
                            $esycs_arry['easycase_id'] = $tuv['easycase_id'];
                            $esycs_arry['estimated_hours'] = $uv['estimated_hours'] ? round($uv['estimated_hours'] * 3600) : 0;
                            $esycs_arry['start_date'] = $start_date ? $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $start_date, "datetime") : '';
                            $esycs_arry['end_date'] = $end_date ? $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $end_date, "datetime") : '';
                            $esycs_arry['created'] = GMT_DATETIME;
                            $esycs_arry['project_id'] = $pro_id;
                            $isusr_ext = $this->EasycaseUser->find('first', array('conditions'=>array('EasycaseUser.easycase_id'=>$tuv['easycase_id'],'EasycaseUser.user_id'=>$proj_usr_lst[$uv['name']])));
                            if ($isusr_ext['EasycaseUser']) {
                                $esycs_arry['id'] = $isusr_ext['EasycaseUser']['id'];
                            }
                            $this->EasycaseUser->create();
                            if ($this->EasycaseUser->save($esycs_arry)) {
                                if (defined('GTLG') && GTLG == 1) {
                                    $this->loadModel('ProjectBookedResource');
                                    $this->loadModel('Overload');
                                    $postCases = array();
                                    $isAssignedUserFree = 1;
                                    $postCases['Easycase']['id'] = $tuv['easycase_id'];
                                    $postCases['Easycase']['estimated_hours'] = $esycs_arry['estimated_hours'];
                                    $postCases['Easycase']['due_date'] = $esycs_arry['end_date'];
                                    $postCases['Easycase']['gantt_start_date'] = $esycs_arry['start_date'];
                                    $postCases['Easycase']['assign_to'] = $esycs_arry['user_id'];
                                    $postCases['Easycase']['project_id'] = $pro_id;
                                    if ($esycs_arry['estimated_hours'] != '' && $esycs_arry['estimated_hours'] != '0' && $esycs_arry['start_date'] != '' && $esycs_arry['start_date'] != '0000-00-00 00:00:00' && $esycs_arry['end_date'] != '' && $esycs_arry['end_date'] != '0000-00-00 00:00:00' && $esycs_arry['user_id'] != 0) {
                                        //  $isAssignedUserFree = $this->Postcase->setBookedData($postCases, $postCases['Easycase']['estimated_hours'], $tuv['easycase_id'], SES_COMP);
                                        //   if ($isAssignedUserFree != 1) {
                                        $this->ProjectBookedResource->deleteAll(array('ProjectBookedResource.easycase_id' => $postCases['Easycase']['id'], 'ProjectBookedResource.project_id' => $postCases['Easycase']['project_id'],'ProjectBookedResource.user_id'=>$postCases['Easycase']['assign_to']));
                                        $this->Overload->deleteAll(array('Overload.easycase_id' => $postCases['Easycase']['id'], 'Overload.project_id' => $postCases['Easycase']['project_id'],'Overload.user_id'=>$postCases['Easycase']['assign_to']));
                                            
                                        $overloadDataArr = array(
                                            'assignTo' => $postCases['Easycase']['assign_to'],
                                            'caseId' => $tuv['easycase_id'],
                                            'est_hr' => $postCases['Easycase']['estimated_hours'] / 3600,
                                            'projectId' => $postCases['Easycase']['project_id'],
                                            'str_date' => $start_date,
                                            'CS_due_date' => $end_date,
                                            'is_multiple_assign' => 0,
                                            'is_user_data' => 1,
                                            );
                                        $response = $this->Format->overloadUsersUpdtedMpp($overloadDataArr);
                                        //  }
                                    }
                                }
                            }
                        }
                    }
                }
                //    echo "<pre>";print_r($tsk_est_arry);print_r($tsk_user_update_arry);exit;
                $pro_name = trim($pro_name, ',') . $pro_name_last;
                $total_task = $this->data['total_rows'] - 1;
                $this->set('total_valid_rows', $total_valid_rows);
                $this->set('csv_file_name', $this->data['csv_file_name']);
                $this->set('total_rows', $total_task);
                $this->set('newtotal_task', $no_task);
                $this->set('proj_name', !empty($this->Format->getProjectName($project_id)) ? $this->Format->getProjectName($project_id) : $pro_name);
                    
                $this->render('importMpp');
            }
            $this->Session->write('mppimportflag', 0);
        } else {
            $this->Session->write("ERROR", __("Please import a valid file"));
            $this->redirect(HTTP_ROOT . "projects/importMpp/");
            exit;
        }
    }
        
    /*function invitenewuserimportMPP($mail_arr = null, $prj_id = 0, $compani_id = null) {

            $usercls = ClassRegistry::init('User');
            $CompanyUser = ClassRegistry::init('CompanyUser');
            $UserInvitation = ClassRegistry::init('UserInvitation');
            $this->loadModel('CompanyUser');
            $this->loadModel('Company');
            $cmpny_dtls = $this->Company->find('first', array('conditions' => array('Company.id' => SES_COMP)));
            $err = 0;
            $ucounter = count($mail_arr);
            $comp_id = ($compani_id) ? $compani_id : SES_COMP;
            $User_id = SES_ID;
            $comp_name = $cmpny_dtls['Company']['name'];
            $USERID = 0;
            if (trim($mail_arr) != "") {
                $val = trim($mail_arr);
                $findEmail = $usercls->find('first', array('conditions' => array('User.email' => $mail_arr), 'fields' => array('User.id')));
                if (@$findEmail['User']['id']) {
                    $userid = $findEmail['User']['id'];
                    $invitation_details = $UserInvitation->find('first', array('conditions' => array('user_id' => $userid, 'company_id' => $comp_id), 'fields' => array('id', 'project_id')));

                    $USERID = $userid;
                    //  return $userid;
                    } else {
                    $userdata['User']['uniq_id'] = $this->Format->generateUniqNumber();
                    $userdata['User']['isactive'] = 2;
                    $userdata['User']['isemail'] = 1;
                    $userdata['User']['dt_created'] = GMT_DATETIME;
                    $userdata['User']['email'] = $val;
                    $usercls->saveAll($userdata);
                    $userid = $usercls->getLastInsertID();
                    $USERID = $userid;
                    $cmpnyUsr = array();
                    $cmpnyUsr['CompanyUser']['is_active'] = 2;
                    $cmpnyUsr['CompanyUser']['user_type'] = 3;
                    if (defined('ROLE') && ROLE == 1) {
                        $cmpnyUsr['CompanyUser']['role_id'] = 3;
                    }
                    $cmpnyUsr['CompanyUser']['user_id'] = $userid;
                    $cmpnyUsr['CompanyUser']['company_id'] = SES_COMP;
                    $cmpnyUsr['CompanyUser']['company_uniq_id'] = $cmpny_dtls['Company']['uniq_id'];
                    $cmpnyUsr['CompanyUser']['created'] = GMT_DATETIME;
                    if ($CompanyUser->saveAll($cmpnyUsr)) {
                        $qstr = $this->Format->generateUniqNumber();
                        if (@$findEmail['User']['id'] && @$invitation_details['UserInvitation']['id']) {
                            $InviteUsr['UserInvitation']['id'] = $invitation_details['UserInvitation']['id'];
                            $InviteUsr['UserInvitation']['project_id'] = $invitation_details['UserInvitation']['project_id'] ? $invitation_details['UserInvitation']['project_id'] . ',' . $prj_id : $prj_id;
                            } else {
                            $InviteUsr['UserInvitation']['project_id'] = $prj_id;
                        }
                        $InviteUsr['UserInvitation']['invitor_id'] = $User_id;
                        $InviteUsr['UserInvitation']['user_id'] = $userid;
                        $InviteUsr['UserInvitation']['company_id'] = $comp_id;
                        $InviteUsr['UserInvitation']['qstr'] = $qstr;
                        $InviteUsr['UserInvitation']['created'] = GMT_DATETIME;
                        $InviteUsr['UserInvitation']['is_active'] = 1;
                        $InviteUsr['UserInvitation']['user_type'] = 3;
                        // echo "<pre>";print_r($InviteUsr);
                        if ($UserInvitation->saveAll($InviteUsr)) {
                            $comp_user_id = $CompanyUser->getLastInsertID();

                            $to = $val;
                            $expEmail = explode("@", $val);
                            $expName = $expEmail[0];
                            $usercls->recursive = -1;
                            $loggedin_users = $usercls->find('first', array('conditions' => array('User.id' => $User_id, 'User.isactive' => 1), 'fields' => array('User.name', 'User.email', 'User.id')));

                            $fromName = ucfirst($loggedin_users['User']['name']);
                            $fromEmail = $loggedin_users['User']['email'];
                            $ext_user = '';
                            if (@$findEmail['User']['id']) {
                                $subject = $fromName . __(" invited you to join ", true) . $comp_name . " on " . COMPANY_NAME . "";
                                $ext_user = 1;
                                } else {
                                $subject = $fromName . __(" invited you to join " . COMPANY_NAME . "", true);
                            }
                            $this->Email->delivery = EMAIL_DELIVERY;
                            $this->Email->to = $to;
                            $this->Email->subject = $subject;
                            $this->Email->from = FROM_EMAIL;
                            $this->Email->template = 'invite_user';
                            $this->Email->sendAs = 'html';
                            $this->set('expName', ucfirst($expName));
                            $this->set('qstr', $qstr);
                            $this->set('existing_user', $ext_user);
                            $this->set('company_name', $comp_name);
                            $this->set('fromEmail', $fromEmail);
                            $this->set('fromName', $fromName);
                            try {
                                if (defined("PHPMAILER") && PHPMAILER == 1) {
                                    if ($is_mobile) {
                                        $this->Email->set_variables = $this->render('/Emails/html/invite_user_mobile', false);
                                        } else {
                                        $this->Email->set_variables = $this->render('/Emails/html/invite_user', false);
                                    }
                                    App::import('Component', 'PhpMailer.PhpMailer');
                                    $this->PhpMailer = new PhpMailerComponent();
                                    $this->PhpMailer->sendPhpMailerTemplate($this->Email);
                                    } else {
                                    $this->Sendgrid->sendgridsmtp($this->Email);
                                }
                                } Catch (Exception $e) {

                            }
                        }
                    }
                }
            }
            //  echo $USERID;exit;
            if ($USERID > 0) {
                $cmpny_usr_dtls = $CompanyUser->find('first', array('conditions' => array('CompanyUser.user_id' => $userid, 'CompanyUser.company_id' => SES_COMP)));
                $this->loadModel('ProjectUser');
                $this->ProjectUser->recursive = -1;
                $getLastId = $this->ProjectUser->find('first', array('fields' => array('ProjectUser.id'), 'order' => array('ProjectUser.id' => 'DESC')));
                $lastid = $getLastId['ProjectUser']['id'] + 1;
                $ProjUsr['ProjectUser']['id'] = $lastid;
                $ProjUsr['ProjectUser']['project_id'] = $prj_id;
                $ProjUsr['ProjectUser']['user_id'] = $USERID;
                $ProjUsr['ProjectUser']['company_id'] = SES_COMP;
                $ProjUsr['ProjectUser']['default_email'] = 1;
                $ProjUsr['ProjectUser']['istype'] = 1;
                $ProjUsr['ProjectUser']['dt_visited'] = GMT_DATETIME;
                if (defined("ROLE") && ROLE == 1) {
                    $ProjUsr['ProjectUser']['role_id'] = $cmpny_usr_dtls['CompanyUser']['role_id'];
                }
                $this->ProjectUser->saveAll($ProjUsr);
            }

            return $USERID;
        }*/
        
    public function checkfile_mpp_validation()
    {
        if (!empty($this->request->data) && !empty($_FILES)) {
            $project_id = $this->request->data['proj_id'];
            if (isset($_FILES['import_mpp_file'])) {
                $ext = pathinfo($_FILES['import_mpp_file']['name'], PATHINFO_EXTENSION);
                if (strtolower($ext) == 'csv') {
                    $csv_info = $_FILES['import_mpp_file'];
                    $file_name = $csv_info['name'];
                    @copy($csv_info['tmp_name'], CSV_PATH . "task_milstone/" . $file_name);
                    if (($handle = fopen(CSV_PATH . "task_milstone/" . trim($file_name), "r")) !== false) {
                        $flag = '';
                        $data = fgetcsv($handle, 1000, ",");
                        foreach ($data as $key => $val) {
                            if (preg_match('/project/', trim(strtolower($val)))) {
                                $flag = 1;
                                break;
                            } else {
                                $flag = 0;
                            }
                        }
                        if (!empty($flag)) {
                            echo 1;
                            exit;
                        } else {
                            echo 2;
                            exit;
                        }
                    }
                }
            } else {
                echo 3;
                exit;
            }
        } else {
            echo 4;
            exit;
        }
    }
        
    /*project status starts*/
        
    /**
        * Showing and Managing project status by company owner
        * @method project_status
        * @author PRB
        * @return
        * @copyright (c) Feb/2020, Andolsoft Pvt Ltd.
    */
    public function project_status()
    {
        if ($this->request->is('ajax')) {
            $this->layout='ajax';
        }
        if (SES_TYPE == 3) {
            if ($this->request->is('ajax')) {
                echo 'not_authorized';
                exit;
            } else {
                $this->redirect(HTTP_ROOT . "dashboard");
                exit;
            }
        }
        $this->loadModel("ProjectStatus");
        $project_status = $this->ProjectStatus->getAllStatus(SES_COMP);
        //ksort($project_status);
        $is_projects = 0;
        $default_task = $this->Project->getDefaultPstatus(SES_COMP);
        if ($default_task) {
            $default_task = Hash::combine($default_task, '{n}.Project.status', '{n}');
        }
        $project_status_custom = $tt = array();
        if (isset($project_status) && !empty($project_status)) {
            foreach ($project_status as $key => $value) {
                if ($value['ProjectStatus']['is_active']) {
                    $project_status[$key]['ProjectStatus']['is_exist'] = 1;
                } else {
                    $project_status[$key]['ProjectStatus']['is_exist'] = 0;
                }
                if (!$value['ProjectStatus']['company_id']) {
                    $project_status[$key]['ProjectStatus']['is_default'] = 1;
                    $project_status[$key]['ProjectStatus']['is_exist'] = 1;
                } else {
                    $project_status[$key]['ProjectStatus']['is_default'] = 0;
                }
                if (array_key_exists($value['ProjectStatus']['id'], $default_task)) {
                    $project_status[$key]['ProjectStatus']['is_used'] = 1;
                    $project_status[$key]['ProjectStatus']['proj_cnt'] = $default_task[$value['ProjectStatus']['id']][0]['cnt'];
                } else {
                    $project_status[$key]['ProjectStatus']['is_used'] = 0;
                    $project_status[$key]['ProjectStatus']['proj_cnt'] = 0;
                }
                if ($value['ProjectStatus']['company_id'] == 0) {
                    $tt[] = $project_status[$key];
                } else {
                    $project_status_custom[] = $project_status[$key];
                }
            }
            $is_projects = 1;
        }
        $project_status = $tt;
        $this->set(compact('project_status', 'project_status_custom', 'is_projects'));
    }
    public function checkProjectStatus()
    {
        $typeId = $this->request->data['typeId'];
        $this->loadModel("Project");
        $project_list = $this->Project->find('list', array('fields' => array('Project.id', 'Project.name'), 'conditions' => array('Project.company_id' => SES_COMP, 'Project.status' => $typeId)));
        $project_str = implode($project_list, ', ');
        echo $project_str;
        exit;
    }
    /**
        * Delete task types by company owner
        *
        * @method deleteTaskType
        * @author Sunil
        * @return boolean
        * @copyright (c) Aug/2014, Andolsoft Pvt Ltd.
    */
    public function deleteProjectStatus()
    {
        $this->layout = 'ajax';
        $this->loadModel("ProjectStatus");
        $id = $this->params->data['id'];
        $type_data = $this->Project->getPstatusDtl(SES_COMP, $id);
        if (empty($type_data)) {
            if (intval($id)) {
                $this->ProjectStatus->id = $id;
                $this->ProjectStatus->delete();
                echo 1;
            } else {
                echo 0;
            }
        } else {
            echo 0;
        }
        exit;
    }
    /*project type starts*/
        
    /**
        * Showing and Managing project type by company owner
        * @method project_type
        * @author PRB
        * @return
        * @copyright (c) Feb/2020, Andolsoft Pvt Ltd.
    */
    public function project_types()
    {
        if ($this->request->is('ajax')) {
            $this->layout='ajax';
        }
        if (SES_TYPE == 3) {
            if ($this->request->is('ajax')) {
                echo 'not_authorized';
                exit;
            } else {
                $this->redirect(HTTP_ROOT . "dashboard");
                exit;
            }
        }
        $this->loadModel("ProjectType");
        $project_status = $this->ProjectType->getAllTypes(SES_COMP);
        //ksort($project_status);
        $is_projects = 0;
        $default_task = $this->Project->getDefaultPtype(SES_COMP);
        if ($default_task) {
            $default_task = Hash::combine($default_task, '{n}.ProjectMeta.proj_type', '{n}');
        }
        #pr($default_task);exit;
        $project_status_custom = $tt = array();
        if (isset($project_status) && !empty($project_status)) {
            foreach ($project_status as $key => $value) {
                if ($value['ProjectType']['is_active']) {
                    $project_status[$key]['ProjectType']['is_exist'] = 1;
                } else {
                    $project_status[$key]['ProjectType']['is_exist'] = 0;
                }
                if (!$value['ProjectType']['company_id']) {
                    $project_status[$key]['ProjectType']['is_default'] = 1;
                    $project_status[$key]['ProjectType']['is_exist'] = 1;
                } else {
                    $project_status[$key]['ProjectType']['is_default'] = 0;
                }
                if (array_key_exists($value['ProjectType']['id'], $default_task)) {
                    $project_status[$key]['ProjectType']['is_used'] = 1;
                    $project_status[$key]['ProjectType']['proj_cnt'] = $default_task[$value['ProjectType']['id']][0]['cnt'];
                } else {
                    $project_status[$key]['ProjectType']['is_used'] = 0;
                    $project_status[$key]['ProjectType']['proj_cnt'] = 0;
                }
                $project_status_custom[] = $project_status[$key];
            }
            $is_projects = 1;
        }
        $this->set(compact('project_status_custom', 'is_projects'));
    }
        
    public function validateProjectType()
    {
        $jsonArr = array('status' => 'error');
        if (!empty($this->request->data['name'])) {
            $this->loadModel("ProjectType");
            $count_type = $this->ProjectType->find('first', array('conditions' => array('ProjectType.company_id' => SES_COMP, 'OR' => array('ProjectType.title' => trim($this->request->data['name'])), 'ProjectType.id !=' => trim($this->request->data['id'])), 'fields' => array("ProjectType.title")));
            if (!$count_type) {
                $jsonArr['status'] = 'success';
            } else {
                if (trim(strtolower($count_type['ProjectType']['name'])) == strtolower(trim($this->request->data['name']))) {
                    $jsonArr['msg'] = 'name';
                }
            }
        }
        echo json_encode($jsonArr);
        exit;
    }
    /* Fetch the list of all projects in RA
           * Sangita- 01/07/2021
        */
    public function resourceGetAllProject()
    {
        $this->layout = 'ajax';
        $project_list = $this->Project->getAllProjectsList();
        echo json_encode($project_list);
        exit;
    }
    /* Assign resources to project in RA
          * Sangita- 01/07/2021
       */
    public function resourceAssignProject()
    {
        $this->layout = 'ajax';
        $data = $this->request->data;
        $userId = $data['user_id'];
        $success = $this->Project->resource_create_project($data['project_id'], $userId);
        $arr = array();
        if ($success) {
            $Company = ClassRegistry::init('Company');
            $comp = $Company->find('first', array('conditions' => array('Company.seo_url' => CHECK_DOMAIN), 'fields' => array('Company.name')));
            foreach ($userId as $id) {
                $mailSent = $this->generateMsgAndSendPjMail($data['project_id'], $id, $comp);
            }
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }

    

    /*  public function getStartAndEndDate($week, $year) {
          $dto = new DateTime();
          $dto->setISODate($year, $week);
          $ret['week_start'] = $dto->format('Y-m-d');
          $dto->modify('+6 days');
          $ret['week_end'] = $dto->format('Y-m-d');
          return $ret;
      } */
    public function getStartAndEndDate($week, $year)
    {
        $dto = new DateTime();
        $result['week_start'] = $dto->setISODate($year, $week, 1)->format('Y-m-d');
        $result['week_end'] = $dto->setISODate($year, $week, 7)->format('Y-m-d');
        return $result;
    }

    public function getWeeklyWorkingHour($days = null, $workinghour = null)
    {
        if ($days != null && $workinghour != null) {
            $total_hour = $days * $workinghour;
        } else {
            $total_hour = 0;
        }
        return $total_hour;
    }

    public function format_time($t, $f = ':')
    { // t = seconds, f = separator
        return sprintf("%02d%s%02d%s%02d", floor($t / 3600), $f, ($t / 60) % 60, $f, $t % 60);
    }    

    public function sendEmailToUser($user_id, $approver_id, $approver_week_start, $approver_week_end, $status, $reject_note)
    {
        $startEmailDate = date("d F", strtotime($approver_week_start));
        $endEmailDate = date("d F", strtotime($approver_week_end));
        $endEmailDateYear = date("Y", strtotime($approver_week_end));

        $usrArr = $this->User->getUserDtls($user_id);
        if (count($usrArr)) {
            $ses_name = $usrArr['User']['name'];
            $ses_photo = $usrArr['User']['photo'];
            $ses_email = $usrArr['User']['email'];
            $ses_last_name = $usrArr['User']['last_name'];
        }
        $usrAppArr = $this->User->getUserDtls($approver_id);
        if (count($usrAppArr)) {
            $app_name = $usrAppArr['User']['name'];
            $app_photo = $usrAppArr['User']['photo'];
            $app_email = $usrAppArr['User']['email'];
            $app_last_name = $usrAppArr['User']['last_name'];
        }
        $sts_txt = $status == 2 ? __("Approved") : __("Rejected");
        $subject = "Timesheet Approval Status (" . $startEmailDate . " - " . $endEmailDate . " " . $endEmailDateYear . ") ";
        $this->Email->delivery = 'smtp';
        $this->Email->to = $ses_email;

        $this->Email->subject = $subject;
        $this->Email->from = FROM_EMAIL;
        $this->Email->template = 'approval_status';
        $this->Email->sendAs = 'html';

        $this->set('approverName', ($app_name ? $app_name : $app_email));
        $this->set('user_ses_name', ($ses_name ? $ses_name : $app_email));
        $this->set('timesheet_reject_note', $reject_note);
        $this->set('approval_status', $sts_txt);
        $this->set('status_val', $status);
        $this->set('submittedByWeek', $startEmailDate . " - " . $endEmailDate . " " . $endEmailDateYear);
        try {
            if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                return 1;
            } else {
                return 0;
            }
        } catch (Exception $e) {
            return 0;
        }
    }
    
    /* Showing
      *Sangita 09/07/2021
      */
    public function ajaxShowTaskCustomFields()
    {
        $this->loadModel("CustomField");
        $jsonArr = array();
        $taskCustomeFields = $this->CustomField->ajaxfetchTaskCustomField();
        $jsonArr['caseCustomFieldDetails'] = $taskCustomeFields;
        echo json_encode($jsonArr);
        exit;
    }
    /* Show Custom fields in Task popup
         *Sangita 09/07/2021
         */
    public function showTaskCustomFields()
    {
        $this->loadModel("CustomField");
        $taskCustomeFields = $this->CustomField->fetchTaskCustomField();
        return $taskCustomeFields;
    }
    /* Delete Custom field from custom field listing page
         *Sangita 21/07/2021
         */
    public function deleteCustomField()
    {
        $this->layout = 'ajax';
        $this->loadModel("CustomField");
        $id = $this->params->data['id'];
        if (intval($id)) {
            $this->CustomField->id = $id;
            $this->CustomField->delete();
            echo 1;
        } else {
            echo 0;
        }
        exit;
    }
    /* Edit Custom field from custom field listing page
         *Sangita 21/07/2021
         */
    public function editCustomField()
    {
        $this->layout = 'ajax';
        $this->loadModel("CustomField");
        $arr['data'] = array();
        $id = $this->params->data['id'];
        $custom_field_data = $this->CustomField->getCFDetails($id);
        $arr['data'] = $custom_field_data['CustomField'];
        echo json_encode($arr);
        exit;
    }

    /* Putting user restriction for Advanced CF in CF listing page
     *Sangita 1/09/2021
     */

    public function isAllowedAdvancedCustomFields()
    {
        if (isset($this->request->data['isAllow'])) {
            $isOnAdvancedCustomFields = $this->Format->isAllowedAdvancedCustomFields();
            echo json_encode($isOnAdvancedCustomFields);
            exit;
        }
    }
    //echo json_encode($arr); exit;
   
    /*
     * Project type filters
     */
    public function ajax_project_type_flt()
    {
        $this->layout = 'ajax';
        $this->loadModel("ProjectType");
        $diy_cond = array('ProjectType.is_active' => 1);
        $diy_list = $this->ProjectType->find('list', array('fields' => array('ProjectType.id', 'ProjectType.title'), 'conditions' => $diy_cond, 'order' => array('ProjectType.title' => 'ASC')));
        
        if ($this->request->data['page'] !== "manage") {
            $this->set(compact('diy_list'));    
        }else if($this->request->data['page'] == "manage"){
            $this->set('page',$this->request->data['page']);
            $this->set('diy_new_list',$diy_list);
        }
       
    }
    /*
    * Project status filters
    */
    public function ajax_project_status_flt()
    {
        $this->layout = 'ajax';
        if ($this->request->data['page'] !== "manage") {
            $diy_list = array(
                '1'=>'Started',
                '2'=>'Hold',
                '3'=>'Stack',
                '4'=>'Completed',
            );
            $this->set(compact('diy_list'));
        }else if($this->request->data['page'] == "manage"){
            $this->loadModel("ProjectStatus");
            $diy_new_list = $this->ProjectStatus->getAllProjectStatus(SES_COMP);
            $this->set('page',$this->request->data['page']);
            $this->set('diy_new_list',$diy_new_list);
        }
        
    }
    /*
    * Project client filters
    */
    public function ajax_project_clients_flt()
    {
        $this->layout = 'ajax';
        $this->loadModel("InvoiceCustomer");
        $diy_cond = array('InvoiceCustomer.company_id' => SES_COMP, 'InvoiceCustomer.status' => "Active");
        $diy_list = $this->InvoiceCustomer->find('list', array('fields' => array('InvoiceCustomer.id', 'InvoiceCustomer.organization'), 'conditions' => $diy_cond, 'order' => array('InvoiceCustomer.organization' => 'ASC')));
        $this->set(compact('diy_list'));
    }
    /*
     * Project Manager filters
     */
    public function ajax_project_project_manager_flt()
    {
        $this->layout = 'ajax';
        $this->loadModel("User");
        $this->loadModel("ProjectMeta");
        $joins = array(
                array('table' => 'project_metas',
                    'alias' => 'ProjectMeta',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'User.uniq_id = ProjectMeta.project_manager',
                    )
                )
        );
        $projmang_lst = $this->ProjectMeta->find('list', array('conditions'=>array('ProjectMeta.project_manager !='=>null,'ProjectMeta.company_id' => SES_COMP),'fields'=>array('id','project_manager')));
        $projmang_lst = array_unique($projmang_lst);
        $diy_cond_new = array('User.isactive' => 1,'User.uniq_id'=>$projmang_lst);
        $diy_list_new = $this->User->find('list', array('fields' => array('User.id', 'User.name'), 'conditions' => $diy_cond_new,'joins'=>$joins, 'order' => array('User.name' => 'ASC')));
        $this->set(compact('diy_list_new'));
    }
    public function ajaxProjectUserCount()
    {
        $projectid = $this->request->data['projectid'];
        $sql =  "SELECT count(user_id) as count,name as user_name
        FROM users
        INNER JOIN project_users
        ON project_users.user_id = users.id 
        WHERE project_users.company_id = ".SES_COMP." AND project_users.project_id = ".$projectid."";
        $res = $this->Project->query($sql);

        echo json_encode($res[0][0]['count']);
        exit;
    }
    public function ajaxcheckUserTasks($reqdata = array())
    {
        $is_ajax_req = $this->request->is('ajax');
        $data = $this->request->data;
        $res['status'] = true;
        $open_task_users = array();
        $this->loadModel('User');
        $this->loadModel('Project');
        $this->loadModel('Easycase');
        if (!empty($reqdata)) {
            $users =  $this->User->find('all', array('conditions'=>array('User.id IN'=>$reqdata['usr_to_remove']),'fields'=>array('User.id',"CONCAT(User.name, ' ', User.last_name) AS full_name")));
        } else {
            if (isset($data['field'])) {
                $users =  $this->User->find('all', array('conditions'=>array('User.id IN'=>$data['user_arr']),'fields'=>array('User.id',"CONCAT(User.name, ' ', User.last_name) AS full_name")));
            } else {
                $users =  $this->User->find('all', array('conditions'=>array('User.uniq_id IN'=>$data['user_arr']),'fields'=>array('User.id',"CONCAT(User.name, ' ', User.last_name) AS full_name")));
            }
        }
        $user_ids = Hash::extract($users, '{n}.User.id');
        $users = Hash::combine($users, '{n}.User.id', '{n}.{n}.full_name');
        $this->Project->recursive = -2;
        if (!empty($reqdata)) {
            $project =  $this->Project->find('first', array('conditions'=>array('Project.uniq_id'=>$reqdata['project_id']),'fields'=>array('Project.id')));
        } else {
            if (isset($data['field'])) {
                $project =  $this->Project->find('first', array('conditions'=>array('Project.id'=>$data['project_id']),'fields'=>array('Project.id')));
            } else {
                $project =  $this->Project->find('first', array('conditions'=>array('Project.uniq_id'=>$data['project_id']),'fields'=>array('Project.id')));
            }
        }

        $this->Project->recursive = -2;
        $easycases = $this->Easycase->find('all', array('fields' => array('Easycase.id', 'Easycase.assign_to', 'Easycase.project_id','Easycase.legend'),'order' => array('Easycase.id ASC'),'conditions' => array('Easycase.assign_to IN' => $user_ids, 'Easycase.project_id' => $project['Project']['id'], 'Easycase.istype' => 1, 'Easycase.legend !=' => 3)));
        if (!empty($easycases)) {
            $assigned_users = array_unique(Hash::extract($easycases, '{n}.Easycase.assign_to'));
            foreach ($assigned_users as $key => $value) {
                if (array_key_exists($value, $users)) {
                    $open_task_users[$value] = $users[$value];
                }
            }
            $res['status'] = false;
            $res['users'] = $open_task_users;
            $res['project_id'] = $project['Project']['id'];
        }
        if (!empty($reqdata)) {
            return $res;
        } else {
            echo json_encode($res);
            exit;
        }
    }

    public function ajaxGetProjUsers()
    {
        $this->layout = 'ajax';
        $data = $this->request->data;
        $ex_user_ids = array_keys($data['user_data']['users']);
        $projId = $data['user_data']['project_id'];
        $qry = '';
        $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $memsArr = $this->ProjectUser->query("SELECT DISTINCT User.*,CompanyUser.*,ProjectUser.* FROM users AS User,company_users AS CompanyUser,project_users AS ProjectUser WHERE User.id=CompanyUser.user_id AND User.id=ProjectUser.user_id AND ProjectUser.project_id='" . $projId . "' AND CompanyUser.company_id='" . SES_COMP . "' AND ProjectUser.user_id NOT IN(".implode(',', $ex_user_ids).") AND CompanyUser.is_active=1" . $qry . " ORDER BY User.name ASC");
        $memsExtArr['Member'] = $memsArr;

        $UserInvitation = ClassRegistry::init('UserInvitation');
        $memsUserInvArr = $UserInvitation->query("SELECT * FROM users AS User,user_invitations AS UserInvitation,company_users AS CompanyUser WHERE User.id=CompanyUser.user_id AND User.id=UserInvitation.user_id AND UserInvitation.company_id='" . SES_COMP . "' AND find_in_set('" . $projId . "', UserInvitation.project_id) > 0 AND UserInvitation.is_active = '1' AND CompanyUser.company_id='" . SES_COMP . "' AND UserInvitation.user_id NOT IN(".implode(',', $ex_user_ids).") AND CompanyUser.is_active=2" . $qry . " ORDER BY User.name ASC");
        $memsExtArr['Invited'] = $memsUserInvArr;

        $CompanyUser = ClassRegistry::init('CompanyUser');
        $memsUserDisArr = $CompanyUser->query("SELECT DISTINCT User.*,CompanyUser.*,ProjectUser.* FROM users AS User,company_users AS CompanyUser,project_users AS ProjectUser WHERE User.id=CompanyUser.user_id AND User.id=ProjectUser.user_id AND ProjectUser.project_id='" . $projId . "' AND ProjectUser.user_id NOT IN(".implode(',', $ex_user_ids).") AND CompanyUser.company_id='" . SES_COMP . "' AND CompanyUser.is_active=0" . $qry . " ORDER BY User.name ASC");
        $memsExtArr['Disabled'] = $memsUserDisArr;
        $this->set('memsExtArr', $memsExtArr);
        $this->set('pjid', $projId);
        $this->set('post_data', $data);
    }

    public function assignLeftCases()
    {
        if ($this->request->is('ajax')) {
            $data = $this->request->data;
            $user_ids = explode(',', trim($data['rem_users_array']));
            $project =  $this->Project->find('first', array('conditions'=>array('Project.id'=>$data['project_id']),'fields'=>array('Project.uniq_id')));
            $this->loadModel('Easycase');
            $easycases = $this->Easycase->find('all', array('fields' => array('Easycase.id','Easycase.uniq_id','Easycase.project_id','Easycase.assign_to','Easycase.gantt_start_date','Easycase.due_date','Easycase.estimated_hours'),'order' => array('Easycase.id ASC'),'conditions' => array('Easycase.assign_to IN' => $user_ids, 'Easycase.istype' => 1, 'Easycase.project_id' => $data['project_id'], 'Easycase.legend !=' => 3)));
            $status['status'] = false;
            if (!empty($easycases)) {
                $case_ids = Hash::extract($easycases, '{n}.Easycase.id');
                $case_ids = implode(', ', $case_ids);
                $this->Easycase->query("UPDATE easycases SET assign_to = ".$data['assign_to_user']." WHERE id IN(".$case_ids.")");
                if (!empty($data['assign_to_user'])) {
                    //Overload users
                    foreach ($easycases as $key => $values) {
                        $RA = array();
                        $RA = array(
                            'caseId' => $values['Easycase']['id'],
                            'caseUniqId' => $values['Easycase']['uniq_id'],
                            'projectId' => $values['Easycase']['project_id'],
                            'assignTo' => $data['assign_to_user'],
                            'str_date' => $values['Easycase']['gantt_start_date'],
                            'CS_due_date' => $values['Easycase']['due_date'],
                            'est_hr' => $values['Easycase']['estimated_hours']
                        );
                        if ($values['Easycase']['legend'] != 3 && $values['Easycase']['assign_to'] && ((!empty($RA['str_date']) && !empty($RA['est_hr']) && trim($RA['est_hr']) != '00:00' && trim($RA['est_hr']) != '0:00' && trim($RA['est_hr']) != '00:0' && trim($RA['est_hr']) != '0:0') || (!empty($RA['str_date']) && !empty($RA['CS_due_date'])))) {
                            $RES = $this->Format->overloadUsersUpdted($RA);
                        }
                    }
                } else {
                    foreach ($easycases as $key => $values) {
                        if ($this->Format->isResourceAvailabilityOn()) {
                            $this->Format->delete_booked_hours(array('easycase_id' => $values['Easycase']['id'], 'project_id' => $values['Easycase']['project_id']), 1);
                        }
                    }
                }
                $status['status'] = true;
                $status['uniq_id'] = $project['Project']['uniq_id'];
                if (empty($data['assign_to_user'])) {
                    $status['msg'] = __('Tasks unassigned');
                } else {
                    $status['msg'] = __('Tasks assigned successfully');
                }
            } else {
                $status['msg'] = __('Tasks not found!');
            }
            echo json_encode($status);
            exit;
        }
    }
		public function ajaXGetCompanyProects()
    {
        if($this->request->is('ajax')){
					//$data = $this->data;
					$projects =  $this->Project->find('list', array('conditions'=>array('Project.company_id'=>SES_COMP),'fields'=>array('Project.id','Project.name')));
					$status['status'] = 'success';
					$status['projects'] = $projects;					
        }else{
					$status['status'] = 'error';
					$status['msg'] = __('Invalid request.');
				}
				
				echo json_encode($status);
				exit;
    }
		
		public function ajaXGetCompanyUsers()
    {
        if($this->request->is('ajax')){
					//$data = $this->data;
					$this->loadModel('CompanyUser');
					$this->CompanyUser->bindModel(
							array(
									'belongsTo' => array(
											'User' => array(
													'className' => 'User',
													'foreignKey' => 'user_id',
											)
									)
							)
					);
					//$this->CompanyUser->recursive = 2;
					$ActiveUsers = $this->CompanyUser->find("all", array("conditions" => array('CompanyUser.is_active' => 1, 'CompanyUser.company_id' => SES_COMP), 'fields' => array('User.id', 'User.name', 'User.last_name'), 'order' => array('CompanyUser.user_type' => 'ASC')));
					$status['status'] = 'success';
					$status['users'] = $ActiveUsers;					
        }else{
					$status['status'] = 'error';
					$status['msg'] = __('Invalid request.');
				}
				
				echo json_encode($status);
				exit;
    }
}
