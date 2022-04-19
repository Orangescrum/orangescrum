<?php

App::uses('AppController', 'Controller');

class TemplatesController extends AppController {

    public $name = 'Templates';
    public $components = array('Format', 'Postcase', 'Tmzone');

    function beforeRender() {
        if ($this->Auth->User('is_client') == 1 && SES_TYPE != 2 && !in_array(PAGE_NAME,array('all_project_templates','all_task_templates','all_workflows'))) {
            $this->redirect(HTTP_ROOT . "dashboard");
        }
    }

    function default_install() {
        $this->loadModel('DefaultTemplate');
        $this->DefaultTemplate->store_default_template();

        $this->loadModel("Company");
        $all_company = $this->Company->find('list', array('fields' => array('id'), 'conditions' => array('is_active' => 1)));

        $this->DefaultTemplate->store_default_to_cstmpl($all_company);
        echo 'Done';
        die;
    }

    function ajax_sort_tasks() {
        $this->layout = 'ajax';
        $this->loadModel("ProjectTemplateCase");
        $listings = $_POST['menu'];
        for ($i = 0; $i < count($listings); $i++) {
            $this->ProjectTemplateCase->query("UPDATE `project_template_cases` SET `sort`=" . $i . " WHERE `id`='" . $listings[$i] . "'");
        }
        exit;
    }

    function view_templates($templateId = NULL) {
        $this->loadModel("ProjectTemplateCase");
        $this->loadModel("ProjectTemplate");

        $template_name = $this->ProjectTemplate->find('first', array('conditions' => array('ProjectTemplate.id' => $templateId, 'ProjectTemplate.company_id' => SES_COMP)));
        //echo "<pre>";print_r($template_name);exit;
        $pjtemp = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $templateId, 'ProjectTemplateCase.company_id' => SES_COMP), 'order' => 'ProjectTemplateCase.sort ASC'));
        if (count($pjtemp) > 0) {
            $this->set('temp_dtls_cases', $pjtemp);
        }
        $this->set('template_name', $template_name['ProjectTemplate']['module_name']);
        $this->set('template_id', $templateId);
    }

    function projects() {
        if(isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])){
            $pass_id = base64_decode($this->request->params['pass'][0]);
            $this->set('pass_id',$pass_id);
        }else{
        $page_limit = TEMP_PROJECT_PAGE_LIMIT;
        $page = 1;
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;

        if (isset($_GET['id']) && !empty($_GET['id'])) {
            $this->loadModel("ProjectTemplate");
            $this->ProjectTemplate->id = $_GET['id'];
            $this->ProjectTemplate->delete();
            //ClassRegistry::init('ProjectTemplateCase')->query("Delete FROM project_template_cases WHERE template_id='".$_GET['id']."'");
            $this->Session->write("SUCCESS", __("Template Deleted successfully",true));
            $this->redirect(HTTP_ROOT . "templates/projects/");
        } else if (isset($this->request->query['act']) && $this->request->query['act']) {
            $v = urldecode(trim($this->request->query['act']));
            $this->loadModel("ProjectTemplate");
            $this->ProjectTemplate->id = $v;
            if ($this->ProjectTemplate->saveField("is_active", 1)) {
                $this->Session->write("SUCCESS", __("Template activated successfully",true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            } else {
                $this->Session->write("ERROR", __("Template can't be activated.Please try again.",true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            }
        } else if (isset($this->request->query['inact']) && $this->request->query['inact']) {
            $v = urldecode(trim($this->request->query['inact']));
            $this->loadModel("ProjectTemplate");
            $this->ProjectTemplate->id = $v;
            if ($this->ProjectTemplate->saveField("is_active", 0)) {
                $this->Session->write("SUCCESS", __("Template deactivated successfully",true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            } else {
                $this->Session->write("ERROR", __("Template can't be deactivated.Please try again.",true));
                $this->redirect(HTTP_ROOT . "projects/manage_template/");
            }
        }
        //$proj_temp = ClassRegistry::init('ProjectTemplate')->find('all',array('conditions'=>array('ProjectTemplate.company_id'=>SES_COMP)));
        $proj_temp = ClassRegistry::init('ProjectTemplate')->query("select ProjectTemplate.*, count(ProjectTemplateCase.id) as case_count from `project_templates` AS ProjectTemplate LEFT JOIN project_template_cases AS ProjectTemplateCase ON ProjectTemplate.id=ProjectTemplateCase.template_id where ProjectTemplate.`company_id`='" . SES_COMP . "' group by ProjectTemplate.id order by ProjectTemplate.`created` DESC LIMIT $limit1, $limit2");
        #pr($proj_temp);exit;
        $total_proj_count = ClassRegistry::init('ProjectTemplate')->find('count', array('conditions' => array('ProjectTemplate.company_id' => SES_COMP)));
        $options['conditions'] = array('ProjectTemplate.company_id' => SES_COMP, 'ProjectTemplate.is_active' => 1);
        $options['fields'] = array('ProjectTemplate.*', 'count(ProjectTemplateCase.id) AS case_count');
        $options['joins'] = array(
            array('table' => 'project_template_cases', 'alias' => 'ProjectTemplateCase', 'type' => 'LEFT', 'conditions' => array('ProjectTemplate.id = ProjectTemplateCase.template_id')),
        );
        $options['order'] = array('ProjectTemplate.created DESC');
        $options['group'] = array('ProjectTemplate.id');
        $proj_temp_active = ClassRegistry::init('ProjectTemplate')->find('all', $options);
        #$log = ClassRegistry::init('ProjectTemplate')->getDataSource()->showLog(false);debug($log);
        #pr($proj_temp_active);exit;
        $this->set('proj_temp', $proj_temp);
        $this->set('caseCount', $total_proj_count);
        $this->set('page_limit', $page_limit);
        $this->set('casePage', $page);
        $this->set('proj_temp_active', $proj_temp_active);
        $this->set('role', $_GET['role']);
    }
    }

    function ajax_add_template_module() {
        $this->layout = 'ajax';
        $title = $this->params->data['title'];
        if (isset($this->params->data['title']) && !empty($this->params->data['title'])) {
            $this->request->data['title'] = html_entity_decode(strip_tags($this->request->data['title']));
            if (empty($this->request->data['title'])) {
                $data['error'] = "invalid";
                echo json_encode($data);
                exit;
            }

            $easycase_array = array();
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
                    if (isset($this->request->data['case_id'])) {
                        $this->loadModel('ProjectTemplateCase');
                        $this->loadModel('Easycase');
                        //$case_ids = $this->request->data['case_id'];												
												$selectedTask = $this->request->data['selected_task'];
												if($selectedTask == "alltask"){
													$allCases = $this->Easycase->fetchAllCases($this->request->data['project_id']);        
													$case_ids = $allCases;
												} else {
													$case_ids = $this->request->data['case_id'];
												}
												//Fetch all the task details
												$case_all = $this->Easycase->getDetailsofAllTask($case_ids);				
												if(empty($case_all)){
													$data['error'] = "invalid";
													echo json_encode($data);
													exit;
												}
												
                        foreach ($case_ids as $k => $id) {
                            //$case_det = $this->Easycase->getDetailsofTask($id);
                            $data['title'] = $case_all[$id]['title'];
                            $data['description'] = $case_all[$id]['message'];
                            $data['task_type'] = $case_all[$id]['type_id'];
                            $data['priority'] = $case_all[$id]['priority'];
                            $data['story_point'] = $case_all[$id]['story_point'];
                            $data['assign_to'] = $case_all[$id]['assign_to'];
                            $data['estimated'] = $case_all[$id]['estimated_hours'];
                            $data['user_id'] = SES_ID;
                            $data['company_id'] = SES_COMP;
                            $data['template_id'] = $last_insert_id;
                            $data['created'] = GMT_DATETIME;
                            $data['modified'] = GMT_DATETIME;                           
                            $this->ProjectTemplateCase->saveAll($data);
                            $last_id = $this->ProjectTemplateCase->getLastInsertId();
                            $easycase_array[$id] = $last_id;
                        }
												
												//Save dependency
												$this->ProjectTemplateCase->savePlanDependency($case_all, $easycase_array);
												
                        /* Update the subtasks **/
                         foreach ($case_ids as $k => $id) {
                            $case_det = $this->Easycase->getDetailsofTask($id);
                            if($case_det['Easycase']['parent_task_id']){
                                $this->ProjectTemplateCase->create();
                                $pid = isset($easycase_array[$case_det['Easycase']['parent_task_id']])?$easycase_array[$case_det['Easycase']['parent_task_id']]:0;
                                $this->ProjectTemplateCase->id = $easycase_array[$id];
                                $this->ProjectTemplateCase->saveField('parent_id',$pid);
                            }
                        }
                        /* End */

                         /* update case files **/
                        $this->loadModel('ProjectTemplateCaseFile');
                        $this->loadModel('CaseFile');
                        $case_files = $this->CaseFile->find('all',array('conditions'=>array('CaseFile.easycase_id'=>$case_ids, 'CaseFile.company_id' => SES_COMP)));                       
                        foreach ($case_files as $k => $file) {
                            $this->ProjectTemplateCaseFile->create();
                            $new_files['ProjectTemplateCaseFile']['user_id'] = SES_ID;
                            $new_files['ProjectTemplateCaseFile']['company_id'] = SES_COMP;
                            $new_files['ProjectTemplateCaseFile']['template_id'] = $last_insert_id;
                            $new_files['ProjectTemplateCaseFile']['project_template_case_id'] = $easycase_array[$file['CaseFile']['easycase_id']];
                            $new_files['ProjectTemplateCaseFile']['file'] = $file['CaseFile']['file'];
                            $new_files['ProjectTemplateCaseFile']['upload_name'] = $file['CaseFile']['upload_name'];
                            $new_files['ProjectTemplateCaseFile']['thumb'] = $file['CaseFile']['thumb'];
                            $new_files['ProjectTemplateCaseFile']['file_size'] = $file['CaseFile']['file_size'];
                            $this->ProjectTemplateCaseFile->save($new_files);
                        }

                    /* End */
                     /* Create task group case files **/
                    $this->loadModel('ProjectTemplateTaskgroup');
                    $this->loadModel('Milestone');
                    $this->loadModel('EasycaseMilestone');

                    $this->EasycaseMilestone->bindModel(array('belongsTo'=>array('Milestone'))); 
                    $this->EasycaseMilestone->recursive = 2;

                     $tgs = $this->EasycaseMilestone->find('all', array('conditions' => array('EasycaseMilestone.easycase_id' => $case_ids),'group'=>array('EasycaseMilestone.milestone_id')));
                    
                    $milestone_map = array();
                     foreach ($tgs as $k => $tg) {
                      $checkDuplicate = $this->ProjectTemplateTaskgroup->query("SELECT ProjectTemplateTaskgroup.id FROM project_template_taskgroups AS ProjectTemplateTaskgroup WHERE ProjectTemplateTaskgroup.title='" . addslashes($tg['Milestone']['title']) . "' AND ProjectTemplateTaskgroup.template_id='" .$last_insert_id . "'");
                      if (isset($checkDuplicate[0]['ProjectTemplateTaskgroup']['id']) && $checkDuplicate[0]['ProjectTemplateTaskgroup']['id']) {
                            $milestone_map[$tg['Milestone']['id']] = $checkDuplicate[0]['ProjectTemplateTaskgroup']['id'];
                      }else{
                            $new_tg['ProjectTemplateTaskgroup']['template_id'] = $last_insert_id;
                            $new_tg['ProjectTemplateTaskgroup']['company_id'] = SES_COMP;
                            $new_tg['ProjectTemplateTaskgroup']['title'] = $tg['Milestone']['title'];
                            $new_tg['ProjectTemplateTaskgroup']['description'] = $tg['Milestone']['description'];
                            $new_tg['ProjectTemplateTaskgroup']['user_id'] = SES_ID;
                            $new_tg['ProjectTemplateTaskgroup']['estimated_hours'] = $tg['Milestone']['estimated_hours'];
                            $new_tg['ProjectTemplateTaskgroup']['sort'] = $tg['Milestone']['id_seq'];
                            $this->ProjectTemplateTaskgroup->create();
                            $this->ProjectTemplateTaskgroup->save($new_tg);
                            $milestone_map[$tg['Milestone']['id']] = $this->ProjectTemplateTaskgroup->id;
                        }
                    }
                    $this->EasycaseMilestone->bindModel(array('belongsTo'=>array('Milestone'))); 
                    $this->EasycaseMilestone->recursive = 2;
                     $tgs1 = $this->EasycaseMilestone->find('all', array('conditions' => array('EasycaseMilestone.easycase_id' => $case_ids)));
                    foreach ($tgs1 as $k => $tg) {
                        $this->ProjectTemplateCase->create();
                        $this->ProjectTemplateCase->id = $easycase_array[$tg['EasycaseMilestone']['easycase_id']];
                        $this->ProjectTemplateCase->saveField('project_template_taskgroup_id',$milestone_map[$tg['Milestone']['id']]);
                    }
       

                    }
                    //echo $title."-".$last_insert_id;
                    $data['tmpl_id'] = $last_insert_id;
                    $data['tmpl_title'] = $this->params->data['title'];
                } else {
                    $data['error'] = 'fail';
                }
            } else {
                $data['error'] = "duplicate";
            }
        }
        echo json_encode($data);
        exit;
    }

    function remove_from_tasks() {
        $this->layout = 'ajax';

        $this->loadModel("ProjectTemplateCase");
        $this->loadModel("Project");

        $pjtemp = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $this->params->data['temp_id'], 'ProjectTemplateCase.company_id' => SES_COMP), 'order' => 'ProjectTemplateCase.sort ASC'));
        //echo "<pre>";print_r($pjtemp);exit;

        if (count($pjtemp) > 0) {
            $this->set('temp_dtls_cases', $pjtemp);
            $this->set('template_id', $this->params->data['temp_id']);
        } else {
            $this->set('template_id', $this->params->data['temp_id']);
        }
    }

    function ajax_template_case_listing() {
        $this->layout = 'ajax';
        if (isset($this->params->data['templateId'], $this->params->data['case_id']) && $this->params->data['templateId'] && $this->params->data['case_id']) {
            $this->loadModel("ProjectTemplateCase");
            $this->ProjectTemplateCase->id = $this->params->data['case_id'];
            $this->ProjectTemplateCase->template_id = $this->params->data['templateId'];
            $this->ProjectTemplateCase->delete();
            $data = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $this->params->data['templateId'], 'ProjectTemplateCase.company_id' => SES_COMP), 'fields' => array('ProjectTemplateCase.id')));
            $res = ClassRegistry::init('ProjectTemplate')->find('first', array('conditions' => array('id' => $this->params->data['templateId'], 'company_id' => SES_COMP), 'fields' => array('module_name')));

            $arr['count'] = count($data);
            $arr['tmpl_nm'] = $res['ProjectTemplate']['module_name'];
            echo json_encode($arr);
        }
        exit;
    }

    function ajax_template_edit() {
        $this->layout = 'ajax';
        //ob_clean();
        if (isset($this->params->data['template_id']) && $this->params->data['template_id']) {
            $temp_id = $this->params->data['template_id'];
            $ttl = urldecode($this->params->data['module_name']);
            $ttl = html_entity_decode(strip_tags($ttl));
            if (empty($ttl)) {
                echo "invalid";
                exit;
            }
            $res = ClassRegistry::init('ProjectTemplate')->find('all', array('conditions' => array('module_name' => $ttl, 'company_id' => SES_COMP)));
            if (count($res) == 0) {
                $this->loadModel("ProjectTemplate");
                $this->ProjectTemplate->id = $temp_id;
                if ($this->ProjectTemplate->saveField("module_name", $ttl)) {
                    echo "success";
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

    function ajax_add_template_cases() {
        $this->layout = 'ajax';
        //ob_clean();
        //echo "<pre>";print_r($this->params->data);exit;
        if (isset($this->params->data['pj_id']) && isset($this->params->data['temp_mod_id'])) {
            $this->loadModel('TemplateModuleCase');
            $prj = $this->TemplateModuleCase->find('count', array('conditions' => array('TemplateModuleCase.company_id' => SES_COMP, 'TemplateModuleCase.project_id' => $this->params->data['pj_id'], 'TemplateModuleCase.template_module_id' => $this->params->data['temp_mod_id'])));
            if ($prj == 0) {
                $this->request->data['TemplateModuleCase']['template_module_id'] = $this->params->data['temp_mod_id'];
                $this->request->data['TemplateModuleCase']['user_id'] = SES_ID;
                $this->request->data['TemplateModuleCase']['company_id'] = SES_COMP;
                $this->request->data['TemplateModuleCase']['project_id'] = $this->params->data['pj_id'];
                if ($this->TemplateModuleCase->save($this->request->data)) {

                     /* insert Taskgroup  from Project template taskgroup table **/
                    $this->loadModel('ProjectTemplateTaskgroup');
                    $this->loadModel('Milestone');
                    $this->loadModel('EasycaseMilestone');
                    $tgs = $this->ProjectTemplateTaskgroup->find('all', array('conditions' => array('ProjectTemplateTaskgroup.template_id' => $this->params->data['temp_mod_id'], 'ProjectTemplateTaskgroup.company_id' => SES_COMP)));
                    $milestone_map = array();
                    foreach ($tgs as $k => $tg) {
                        $checkDuplicate = $this->Milestone->query("SELECT Milestone.id FROM milestones AS Milestone WHERE Milestone.title='" . addslashes($tg['ProjectTemplateTaskgroup']['title']) . "' AND Milestone.project_id='" .$this->params->data['pj_id'] . "'");
                          if (isset($checkDuplicate[0]['Milestone']['id']) && $checkDuplicate[0]['Milestone']['id']) {
                                $milestone_map[$tg['ProjectTemplateTaskgroup']['id']] = $checkDuplicate[0]['Milestone']['id'];
                          }else{
                            $new_tg['Milestone']['uniq_id'] = md5(uniqid());
                            $new_tg['Milestone']['project_id'] =$this->params->data['pj_id'];
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
                        }
                    }

                    $this->loadModel("ProjectTemplateCase");
                    $pjtemp = $this->ProjectTemplateCase->find('all', array('conditions' => array('ProjectTemplateCase.template_id' => $this->params->data['temp_mod_id'], 'ProjectTemplateCase.company_id' => SES_COMP), 'order' => array('ProjectTemplateCase.sort ASC')));
                    $Easycase = ClassRegistry::init('Easycase');
                    $Easycase->recursive = -1;
                    $CaseActivity = ClassRegistry::init('CaseActivity');
                    $old_pt_ids = array();
                    $new_generated_ids = array();
                    $this->loadModel("ProjectUser");
                    $getMemberList = $this->ProjectUser->find('all', array('conditions'=>array('ProjectUser.project_id'=>$this->params->data['pj_id']),'fields' => array('ProjectUser.user_id')));
                    $memberlists = array();
                    foreach($getMemberList as $k=>$v){
                        $memberlists[] = $v['ProjectUser']['user_id'];
                    }
					
					$hasCustomStatusGroup = $this->Format->hasCustomTaskStatus($this->params->data['pj_id'],'Project.id');
					
					//custom task status start
					$custom_status = 0;
					$custom_legend = 1;
					if($hasCustomStatusGroup){
						$CustomStatus = ClassRegistry::init('CustomStatus');
						$sts_cond = array('CustomStatus.status_group_id'=>$hasCustomStatusGroup);
						$CustomStatusArr =  $CustomStatus->find('first',array('conditions'=>$sts_cond,'order'=>array('CustomStatus.seq'=>'ASC')));
						$custom_status = $CustomStatusArr['CustomStatus']['id'];
						$custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
					}
                    foreach ($pjtemp as $temp) {
                       $assignTo = (in_array($temp['ProjectTemplateCase']['assign_to'], $memberlists))? $temp['ProjectTemplateCase']['assign_to']:0;
                        $postCases['Easycase']['uniq_id'] = md5(uniqid());
                        $postCases['Easycase']['project_id'] = $this->params->data['pj_id'];
                        $postCases['Easycase']['user_id'] = SES_ID;
                        $postCases['Easycase']['type_id'] = ($temp['ProjectTemplateCase']['task_type'])?$temp['ProjectTemplateCase']['task_type']:2;
                        $postCases['Easycase']['priority'] = $temp['ProjectTemplateCase']['priority'];
                        $postCases['Easycase']['title'] = $temp['ProjectTemplateCase']['title'];
                        $postCases['Easycase']['message'] = $temp['ProjectTemplateCase']['description'];
                        $postCases['Easycase']['assign_to'] =  $assignTo;
                        $postCases['Easycase']['due_date'] = "";
                        $postCases['Easycase']['story_point'] = ($temp['ProjectTemplateCase']['story_point'])?$temp['ProjectTemplateCase']['story_point']:0;
                        $postCases['Easycase']['estimated_hours'] = ($temp['ProjectTemplateCase']['estimated'])?$temp['ProjectTemplateCase']['estimated']:0;
                        $postCases['Easycase']['istype'] = 1;
                        $postCases['Easycase']['format'] = 2;
                        $postCases['Easycase']['status'] = 1;
                        $postCases['Easycase']['legend'] = $custom_legend;
                        $postCases['Easycase']['custom_status_id'] = $custom_status;
                        $postCases['Easycase']['isactive'] = 1;
                        $postCases['Easycase']['dt_created'] = GMT_DATETIME;
                        $postCases['Easycase']['actual_dt_created'] = GMT_DATETIME;
                        $caseNoArr = $Easycase->find('first', array('conditions' => array('Easycase.project_id' => $this->params->data['pj_id']), 'fields' => array('MAX(Easycase.case_no) as caseno')));
                        $caseNo = $caseNoArr[0]['caseno'] + 1;
                        $postCases['Easycase']['case_no'] = $caseNo;
                        if ($Easycase->saveAll($postCases)) {
                            $caseid = $Easycase->getLastInsertID();

                            $old_pt_ids[$temp['ProjectTemplateCase']['id']] =  $caseid;

                           if($temp['ProjectTemplateCase']['project_template_taskgroup_id'] != 0){
                            $new_em['EasycaseMilestone']['project_id'] =  $this->params->data['pj_id'];
                            $new_em['EasycaseMilestone']['company_id'] =  SES_COMP;
                            $new_em['EasycaseMilestone']['user_id'] =  SES_ID;
                            $new_em['EasycaseMilestone']['easycase_id'] =   $caseid;
                            $new_em['EasycaseMilestone']['milestone_id'] =   $milestone_map[$temp['ProjectTemplateCase']['project_template_taskgroup_id']];
                            $this->EasycaseMilestone->create();
                            $this->EasycaseMilestone->save($new_em);

                        }
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

										//Save dependency
										$this->Easycase->savePlanDependency($pjtemp, $old_pt_ids);
                     /* update the parent tasks */
                     $this->loadModel('Easycase');
                     foreach ($pjtemp as $temp) {
                        if($temp['ProjectTemplateCase']['parent_id']){
                            $this->Easycase->create();
                            $this->Easycase->id = $old_pt_ids[$temp['ProjectTemplateCase']['id']];
                            $this->Easycase->saveField('parent_task_id',$old_pt_ids[$temp['ProjectTemplateCase']['parent_id']]);
                        }
                     }
                    /* End*/
                    /* update case files **/
                    $this->loadModel('ProjectTemplateCaseFile');
                    $this->loadModel('CaseFile');
                    $case_files = $this->ProjectTemplateCaseFile->find('all',array('conditions'=>array('ProjectTemplateCaseFile.template_id'=>$this->params->data['temp_mod_id'], 'ProjectTemplateCaseFile.company_id' => SES_COMP)));
                    foreach ($case_files as $k => $file) {
                        $this->CaseFile->create();
                        $new_files['CaseFile']['user_id'] = SES_ID;
                        $new_files['CaseFile']['company_id'] = SES_COMP;
                        $new_files['CaseFile']['project_id'] = $this->params->data['pj_id'];
                        $new_files['CaseFile']['easycase_id'] = $old_pt_ids[$file['ProjectTemplateCaseFile']['project_template_case_id']];
                        $new_files['CaseFile']['file'] = $file['ProjectTemplateCaseFile']['file'];
                        $new_files['CaseFile']['upload_name'] = $file['ProjectTemplateCaseFile']['upload_name'];
                        $new_files['CaseFile']['thumb'] = $file['ProjectTemplateCaseFile']['thumb'];
                        $new_files['CaseFile']['file_size'] = $file['ProjectTemplateCaseFile']['file_size'];
                        $new_files['CaseFile']['isactive'] = 1;
                        if( $old_pt_ids[$file['ProjectTemplateCaseFile']['project_template_case_id']]){
                            if($this->CaseFile->save($new_files)){
                                $this->Easycase->id = $old_pt_ids[$file['ProjectTemplateCaseFile']['project_template_case_id']];
                                $this->Easycase->saveField('format',1);
                            }
                        }
                    }

                    /* End */



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

    function add_template() {
        $this->layout = 'ajax';
        //echo "<pre>";print_r($this->data);exit;
        $this->set('temp_id', $this->data['temp_id']);
        $this->set('temp_name', $this->data['temp_name']);
    }

    function add_template_task() {
        #pr($this->request);exit;
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
                        $temp_case['title'] = trim($cs);
                        $temp_case['description'] = trim($this->request->data['ProjectTemplateCase']['description'][$count_arr]);
                        $this->ProjectTemplateCase->saveAll($temp_case);
                    }
                    $count_arr++;
                }
            }
            $this->Session->write("SUCCESS", __("Template tasks added successfully",true));
            $this->redirect(HTTP_ROOT . "templates/projects/");
        }
    }

    function edit_template_task() {
        if (count($this->request->data) > 0) {
            if (isset($this->request->data['tmpl_id'])) {
                $this->loadModel('ProjectTemplateCase');
                $temp_case['ProjectTemplateCase']['title'] = $this->request->data['title'];
                $temp_case['ProjectTemplateCase']['description'] = $this->request->data['description'];
                $this->ProjectTemplateCase->id = $this->request->data['tmpl_id'];
                if ($this->ProjectTemplateCase->save($temp_case)) {
                    $tmpl_id = $this->ProjectTemplateCase->find('first', array('conditions' => array('ProjectTemplateCase.id' => $this->request->data['tmpl_id']), 'fields' => array('ProjectTemplateCase.template_id')));
                    $this->loadModel('ProjectTemplate');
                    $tmpl_name = $this->ProjectTemplate->find('first', array('conditions' => array('ProjectTemplate.id' => $tmpl_id['ProjectTemplateCase']['template_id'], 'ProjectTemplate.company_id' => SES_COMP), 'fields' => array('ProjectTemplate.module_name')));
                    $data['tmpl_id'] = $tmpl_id['ProjectTemplateCase']['template_id'];
                    $data['tmpl_name'] = $tmpl_name['ProjectTemplate']['module_name'];
                    $data['msg'] = 'success';
                }
            }
            /* $this->Session->write("SUCCESS","Template tasks updated successfully");
              $this->redirect(HTTP_ROOT."templates/projects/"); */
        }
        echo json_encode($data);
        exit;
    }

    function tasks() {
        $this->loadModel("CaseTemplate");
        $page_limit = TEMP_TASK_PAGE_LIMIT;
        $page = 1;
        $pageprev = 1;
        if (isset($_GET['page']) && $_GET['page']) {
            $page = $_GET['page'];
        }
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;
        //$query = "SELECT SQL_CALC_FOUND_ROWS * FROM case_templates WHERE case_templates.company_id='".SES_COMP."' AND (case_templates.user_id='".SES_ID."' OR case_templates.user_id='0') ORDER BY created DESC LIMIT ".$limit1.",".$limit2;
        $query = "SELECT SQL_CALC_FOUND_ROWS * FROM case_templates WHERE case_templates.company_id='" . SES_COMP . "' AND (1) ORDER BY created DESC LIMIT " . $limit1 . "," . $limit2;
        $TempalteArray = $this->CaseTemplate->query($query);

        $found_rows = $this->CaseTemplate->query("SELECT FOUND_ROWS() as total");
        //echo "<pre>";print_r($TempalteArray);exit;
        //$limit = $limit1.",".$limit2;
        $this->set('caseCount', $found_rows[0][0]['total']);
        $this->set('page_limit', $page_limit);
        $this->set('casePage', $page);
        $this->set('pageprev', $pageprev);
        $this->set('TempalteArray', $TempalteArray);
    }
    /*
     * Author SSL
     * Method to get the list of templates   
     */
     function all_workflows() {
        $this->layout = 'ajax';
        $this->loadModel('StatusGroup');
        $data = $this->request->data;
        $respArr = $this->StatusGroup->find('list', array('conditions' => array('StatusGroup.company_id' => array(SES_COMP,0),'StatusGroup.parent_id'=>0), 'fields' => array('StatusGroup.id', 'StatusGroup.name'),'order'=>array('StatusGroup.is_default DESC','CASE StatusGroup.is_default  WHEN 0 THEN StatusGroup.name ELSE StatusGroup.id END  ASC')));            
        $this->set('templates',$respArr);
        $this->set('type',$data['type']);
        
    }


    /*
     * Author Jaideep
     * Method to get the list of task    
     */

    function all_task_templates() {
        $this->layout = 'ajax';
        $this->loadModel('Type');
        $task_types = $this->Type->getAllTypes();
        $this->loadModel("TypeCompany");
        $sel_types = $this->TypeCompany->getSelTypes();
        $task_list = array();
        if (isset($sel_types) && !empty($sel_types) && isset($task_types) && !empty($task_types)) {
            foreach ($task_types as $key => $value) {
                if($value['Type']['project_id'] == 0){
                if (array_search($value['Type']['id'], $sel_types)) {
                    $task_list[$value['Type']['id']] = $value['Type']['name'];
                } 
            }
            }
        }else if (!empty($task_types)) {
            foreach ($task_types as $key => $value) {
                 if($value['Type']['project_id'] == 0){
                $task_list[$value['Type']['id']] = $value['Type']['name'];
            }
        }
        }
        $this->set(compact('task_list'));
        if (isset($this->request->data['val']) && $this->request->data['val'] == 'proj_create') {
            $this->set('proj', 'proj');
        }
    }

    /*
     * Author Satyajeet
     * Method to create Project Template from TAsk Listing Page
     */

    function createProjectTemplateFromTasks() {
        $this->loadModel('Easycase');
        $last_insert_id = $this->request->data['temp_id'];

        
        $selectedTask = $this->request->data['selected_task'];
        if($selectedTask == "alltask"){
					$allCases = $this->Easycase->fetchAllCases($this->request->data['project_id']);        
					$case_ids = $allCases;
        } else {
					$case_ids = $this->request->data['case_id'];
        }        
        $this->loadModel('ProjectTemplateCase');
        $count = 0;
        $easycase_array = array();
				//Fetch all the task details
				$case_all = $this->Easycase->getDetailsofAllTask($case_ids);				
				if(empty($case_all)){
					$arr['msg'] = 'fail';
					echo json_encode($arr);
					exit;
				}
        foreach ($case_ids as $k => $id) {
					if(isset($case_all[$id])){
						$data['title'] = $case_all[$id]['title'];
						$data['description'] = $case_all[$id]['message'];
						$data['task_type'] = $case_all[$id]['type_id'];
						$data['priority'] = $case_all[$id]['priority'];
						$data['story_point'] = $case_all[$id]['story_point'];
						$data['assign_to'] = $case_all[$id]['assign_to'];
						$data['estimated'] = $case_all[$id]['estimated_hours'];
            $data['user_id'] = SES_ID;
            $data['company_id'] = SES_COMP;
            $data['template_id'] = $last_insert_id;
            $data['created'] = GMT_DATETIME;
            $data['modified'] = GMT_DATETIME;
            if ($this->ProjectTemplateCase->saveAll($data)){
               $count ++; 
            $last_id = $this->ProjectTemplateCase->getLastInsertId();
            $easycase_array[$id] = $last_id;
						}						
					}					
        }


				if(empty($easycase_array)){
					$arr['msg'] = 'fail';
					echo json_encode($arr);
					exit;
        }
				//Update dependency
				$this->ProjectTemplateCase->savePlanDependency($case_all, $easycase_array);

            /* Update the subtasks **/
             foreach ($case_ids as $k => $id) {
                $case_det = $this->Easycase->getDetailsofTask($id);
                if($case_det['Easycase']['parent_task_id']){
                    $this->ProjectTemplateCase->create();
                    $pid = isset($easycase_array[$case_det['Easycase']['parent_task_id']])?$easycase_array[$case_det['Easycase']['parent_task_id']]:0;
                    $this->ProjectTemplateCase->id = $easycase_array[$id];
                    $this->ProjectTemplateCase->saveField('parent_id',$pid);
                }
            }
            /* End */

             /* update case files **/
            $this->loadModel('ProjectTemplateCaseFile');
            $this->loadModel('CaseFile');
            $case_files = $this->CaseFile->find('all',array('conditions'=>array('CaseFile.easycase_id'=>$case_ids, 'CaseFile.company_id' => SES_COMP)));                       
            foreach ($case_files as $k => $file) {
                $this->ProjectTemplateCaseFile->create();
                $new_files['ProjectTemplateCaseFile']['user_id'] = SES_ID;
                $new_files['ProjectTemplateCaseFile']['company_id'] = SES_COMP;
                $new_files['ProjectTemplateCaseFile']['template_id'] = $last_insert_id;
                $new_files['ProjectTemplateCaseFile']['project_template_case_id'] = $easycase_array[$file['CaseFile']['easycase_id']];
                $new_files['ProjectTemplateCaseFile']['file'] = $file['CaseFile']['file'];
					$file['CaseFile']['upload_name'] = (empty($file['CaseFile']['upload_name'])) ? $file['CaseFile']['file'] : $file['CaseFile']['upload_name'];
                $new_files['ProjectTemplateCaseFile']['upload_name'] = $file['CaseFile']['upload_name'];
                $new_files['ProjectTemplateCaseFile']['thumb'] = $file['CaseFile']['thumb'];
                $new_files['ProjectTemplateCaseFile']['file_size'] = $file['CaseFile']['file_size'];
                $this->ProjectTemplateCaseFile->save($new_files);
             }

        /* End */

        /* Create task group case files **/
        $this->loadModel('ProjectTemplateTaskgroup');
        $this->loadModel('Milestone');
        $this->loadModel('EasycaseMilestone');

        $this->EasycaseMilestone->bindModel(array('belongsTo'=>array('Milestone'))); 
        $this->EasycaseMilestone->recursive = 2;

         $tgs = $this->EasycaseMilestone->find('all', array('conditions' => array('EasycaseMilestone.easycase_id' => $case_ids),'group'=>array('EasycaseMilestone.milestone_id')));
        
        $milestone_map = array();
        foreach ($tgs as $k => $tg) {
          $checkDuplicate = $this->ProjectTemplateTaskgroup->query("SELECT ProjectTemplateTaskgroup.id FROM project_template_taskgroups AS ProjectTemplateTaskgroup WHERE ProjectTemplateTaskgroup.title='" . addslashes($tg['Milestone']['title']) . "' AND ProjectTemplateTaskgroup.template_id='" .$last_insert_id . "'");
          if (isset($checkDuplicate[0]['ProjectTemplateTaskgroup']['id']) && $checkDuplicate[0]['ProjectTemplateTaskgroup']['id']) {
                $milestone_map[$tg['Milestone']['id']] = $checkDuplicate[0]['ProjectTemplateTaskgroup']['id'];
          }else{
                $new_tg['ProjectTemplateTaskgroup']['template_id'] = $last_insert_id;
                $new_tg['ProjectTemplateTaskgroup']['company_id'] = SES_COMP;
                $new_tg['ProjectTemplateTaskgroup']['title'] = $tg['Milestone']['title'];
                $new_tg['ProjectTemplateTaskgroup']['description'] = $tg['Milestone']['description'];
                $new_tg['ProjectTemplateTaskgroup']['user_id'] = SES_ID;
                $new_tg['ProjectTemplateTaskgroup']['estimated_hours'] = $tg['Milestone']['estimated_hours'];
                $new_tg['ProjectTemplateTaskgroup']['sort'] = $tg['Milestone']['id_seq'];
                $this->ProjectTemplateTaskgroup->create();
                $this->ProjectTemplateTaskgroup->save($new_tg);
                $milestone_map[$tg['Milestone']['id']] = $this->ProjectTemplateTaskgroup->id;
            }
        }
        $this->EasycaseMilestone->bindModel(array('belongsTo'=>array('Milestone'))); 
        $this->EasycaseMilestone->recursive = 2;
         $tgs1 = $this->EasycaseMilestone->find('all', array('conditions' => array('EasycaseMilestone.easycase_id' => $case_ids)));
        foreach ($tgs1 as $k => $tg) {
            $this->ProjectTemplateCase->create();
            $this->ProjectTemplateCase->id = $easycase_array[$tg['EasycaseMilestone']['easycase_id']];
            $this->ProjectTemplateCase->saveField('project_template_taskgroup_id',$milestone_map[$tg['Milestone']['id']]);
        }

         /* End **/
        
        $arr = Array();
        if ($count == count($case_ids)) {
            $arr['msg'] = 'success';
        } else {
            $arr['msg'] = 'fail';
        }
        echo json_encode($arr);
        exit;
    }

    function project_template($args= null){
		$arr = array();
        $arr['msg'] = __('Something went wrong',true);
        $arr['status'] = 0;
        if($args){
            $this->request->data['id'] = $args;
        }
        if(isset($this->request->data) && !empty($this->request->data)){
            $id = $this->request->data['id'];
            $this->loadModel('ProjectTemplate');
            $pt = $this->ProjectTemplate->find('first',array('conditions'=>array('ProjectTemplate.id'=>$id)));
            $this->loadModel('ProjectTemplateTaskgroup');
            $this->loadModel('ProjectTemplateCase');
            $this->loadModel('Easycase');
            $projUser = $this->Easycase->getMemebers('all');
            $this->ProjectTemplateTaskgroup->bindModel(array('hasMany'=>array('ProjectTemplateCase'=>array('order'=>array('ProjectTemplateCase.sort ASC'))))); 

            $this->ProjectTemplateCase->bindModel(array('hasMany'=>array('ProjectTemplateCaseFile'))); 

            $this->ProjectTemplateTaskgroup->recursive = 2;
             $all_tg = $this->ProjectTemplateTaskgroup->find('all',array('conditions'=>array('ProjectTemplateTaskgroup.template_id'=>$id),'contain'=>array('ProjectTemplateCase'=>array('order'=>array('ProjectTemplateCase.sort ASC'))),'order'=>array('ProjectTemplateTaskgroup.sort ASC')));
            
            

            $arr['all_tasks'] =  $all_tg;
           

            /* Get all default task groups **/
            $this->ProjectTemplateCase->recursive = 2;
            $all_defaults = $this->ProjectTemplateCase->find('all',array('conditions'=>array('ProjectTemplateCase.template_id'=>$id,'ProjectTemplateCase.project_template_taskgroup_id'=>0),'order'=>array('ProjectTemplateCase.sort ASC')));

            $new_arr['ProjectTemplateTaskgroup']=array('id'=>0,'title'=>'Default Task Group','description'=>'','estimated_hr'=>'');
            
           foreach($all_defaults as $k=>$v){
                $case_arr = $v['ProjectTemplateCase'];
                $case_arr['ProjectTemplateCaseFile'] = $v['ProjectTemplateCaseFile'];
                $new_arr['ProjectTemplateCase'][$k] = $case_arr;
           }
           $arr['all_tasks'][] = $new_arr;


            $arr['template_name'] = $pt['ProjectTemplate']['module_name'];
            $arr['template_id'] = $pt['ProjectTemplate']['id'];
            if($projUser){
                $arr['QTAssigns'] = Hash::extract($projUser, '{n}.User');
            }
            $arr['status'] = 1;
            $arr['url'] = HTTP_ROOT.'templates/projects/'.base64_encode($id);
        }
       if($args){
            return $arr;
       }else{
        echo json_encode($arr);exit;
        }
    }    
	
	
	function get_type_id($type) {
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
     * @method public data_import Dataimport Interface 
     * @author Andola  <info@andolasoft.com>
     * @copyright (c) 2013, Andolsoft Pvt Ltd.
	 * @This import is for Project Templete Task Import
     */
    function csv_dataimport() {
        $this->Session->write('csvimportflag', 1);
        $project_template_id = $this->data['template_id'];
		$project_template_name = $this->data['template_name'];
        $this->loadModel('Type');
        $task_types = $this->Type->getAllTypes();
        $this->loadModel("TypeCompany");
        $sel_types = $this->TypeCompany->getSelTypes();
        $is_projects = 0;
        $task_type_arr = array();
        if (isset($sel_types) && !empty($sel_types) && isset($task_types) && !empty($task_types)) {
            foreach ($task_types as $key => $value) {
                if (array_search($value['Type']['id'], $sel_types)) {
                    $task_type_arr[$value['Type']['id']] = strtolower($value['Type']['name']);
                }
            }
            $is_projects = 1;
        }

        $task_status_arr = array('new', 'close', 'wip', 'resolve', 'resolved', 'closed', 'in progress');
        $task_is_billabe = array(0, 1);
        $this->loadModel('User');
        $this->loadModel('ProjectUser');

        $fields_arr = array('sprint/taskgroup','title', 'description', 'type', 'story point', 'priority', 'assigned to', 'estimated hour');
        $fields_arr1 = array('sprint/taskgroup','title', 'description', 'type', 'story point', 'priority', 'assigned to', 'estimated hour');

        if (isset($_FILES['import_csv'])) {
            //$mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv','application/octet-stream');
            $ext = pathinfo($_FILES['import_csv']['name'], PATHINFO_EXTENSION);
            if (strtolower($ext) == 'csv') {
                $csv_info = $_FILES['import_csv'];
                //Uploading the csv file to Our server
                $file_name = SES_ID . "_" . $project_template_id . "_" . $csv_info['name'];
                @copy($csv_info['tmp_name'], CSV_PATH . "project_template/" . $file_name);

                $row = 1;
                // Counting total rows and Restricting from uploading a file having more then 1000 record
                $linecount = count(file(CSV_PATH . "project_template/" . $file_name));
                if ($linecount > 1001) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "project_template/" . $file_name);
                    $this->Session->write("ERROR", __("Please split the file and upload again. Your file contain more than 1000 rows",true));
                    $this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
                    exit;
                }
                if ($csv_info['size'] > 2097152) {
                    @unlink($csv_info['tmp_name'], CSV_PATH . "project_template/" . $file_name);
                    $this->Session->write("ERROR", __("Please upload a file with size less then 2MB",true));
                    $this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
                    exit;
                }
				
				
				if($linecount > 1){
					//Parsing the csv file
					if (($handle = fopen(CSV_PATH . "project_template/" . $file_name, "r")) !== FALSE) {
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
						
						$titleNotPresentCount = 0;
						
						$this->loadModel('CompanyUser');
						$task_assign_to_userid = $this->CompanyUser->find('list', array('conditions' => array('company_id' => SES_COMP), 'fields' => 'user_id'));
						$task_assign_to_users = $this->User->find('list', array('conditions' => array('id' => $task_assign_to_userid, 'isactive' => 1), 'fields' => 'email'));
						
						while (($data = fgetcsv($handle, 1000, $separator)) !== FALSE) {
							if (!$i) {
								// Check for column count
								if (count($data) >= 1) {
									// Check for exact number of fields 
									foreach ($data AS $key => $val) {
										if (!in_array(strtolower($val), $fields_arr) && !in_array(strtolower($val), $fields_arr1)) {
											@unlink(CSV_PATH . "project_template/" . $file_name);
											$this->Session->write("ERROR","". __('Invalid CSV file',true).", <a href='" . HTTP_ROOT . "projects/download_sample_prjtemplate_csvfile' style='text-decoration:underline;color:#0000FF'>".__('Download',true)."</a> ".__('and check with our sample file',true));
											$this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
											exit;
										}
										$fileds[$key] = $val;
									}
									foreach ($data AS $key => $val) {
										$header_arr[strtolower($val)] = $key;
									}
								} else {
									@unlink(CSV_PATH . "project_template/" . $file_name);
									$this->Session->write("ERROR", __("Require atleast Task Title column to import the Tasks",true));
									$this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
									exit;
								}
							} else {
							#echo $i;exit;
								// Verifing data
								$value = $data;
								if(isset($value[$header_arr['title']]) && $value[$header_arr['title']] != ''){
									$TaskGroupComing = $value[$header_arr['sprint/taskgroup']];
									if(strlen($value[$header_arr['title']]) > 240){
										$TaskTitleComing = substr($value[$header_arr['title']], 0, 240);
									}else{
									$TaskTitleComing = $value[$header_arr['title']];
									}
									$TaskDescriptionComing = $value[$header_arr['description']];
									$TaskTypeComing = $value[$header_arr['type']];
									$TaskStoryPointComing = $value[$header_arr['story point']];
									$TaskPriorityComing = $value[$header_arr['priority']];
									$TaskAssignedToComing = $value[$header_arr['assigned to']];
									$TaskEstimatedHourComing = $value[$header_arr['estimated hour']];
									
									if(isset($TaskGroupComing) && $TaskGroupComing != ''){
										$this->loadModel('ProjectTemplateTaskgroup');
										$task_group_id = $this->ProjectTemplateTaskgroup->find('first', array('conditions' => array('title' => html_entity_decode(strip_tags($TaskGroupComing)), 'template_id' => $project_template_id, 'company_id' => SES_COMP), 'fields' => 'id'));
										
										if(isset($task_group_id['ProjectTemplateTaskgroup']['id']) && $task_group_id['ProjectTemplateTaskgroup']['id'] != ''){
											$presentTaskGroupId = $task_group_id['ProjectTemplateTaskgroup']['id'];
										}else{
											$dataTG['user_id'] = SES_ID;
											$dataTG['company_id'] = SES_COMP;
											$dataTG['template_id'] = $project_template_id;
											$dataTG['title'] = html_entity_decode(strip_tags($TaskGroupComing));
											$dataTG['created'] = GMT_DATETIME;
											$dataTG['modified'] = GMT_DATETIME;
											
											$this->ProjectTemplateTaskgroup->create();
											$this->ProjectTemplateTaskgroup->save($dataTG);
											
											$presentTaskGroupId = $this->ProjectTemplateTaskgroup->getLastInsertID();
										}
									}else{
										$presentTaskGroupId = 0;
									}
									
									 $data['user_id'] = SES_ID;
									 $data['company_id'] = SES_COMP;
									 $data['parent_id'] = 0;
									 $data['template_id'] = $project_template_id;
									 $data['project_template_taskgroup_id'] = ($presentTaskGroupId) ? $presentTaskGroupId : 0;
									 $data['title'] = html_entity_decode(strip_tags($TaskTitleComing));
									 $data['description'] = html_entity_decode(strip_tags($TaskDescriptionComing));
									 
									 $estimated_hours =  $TaskEstimatedHourComing ? $TaskEstimatedHourComing : 0;
									   /* saving in secs */
									   if (strpos($estimated_hours, ':') > -1) {
											$split_est = explode(':', $estimated_hours);
											$est_sec = ((($split_est[0]) * 60) + intval($split_est[1])) * 60;
										} else {
											$est_sec = $estimated_hours * 3600;
										}
										$estimated_hours = $est_sec;
									 $data['estimated'] = $estimated_hours; 
									 
									 
									if (!isset($TaskTypeComing)) {
										$data['task_type'] = 2;
									} else {
										if (isset($TaskTypeComing)) {
											$t_tak_typ = $this->get_type_id($TaskTypeComing);
										}
										if (stristr($t_tak_typ, "___")) {
											$t_tak_typ_t = explode('___', $t_tak_typ);
											$data['task_type'] = $t_tak_typ_t[0];
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
											$data['task_type'] = $t_tak_typ;
										}
									}
									
									if (isset($TaskTypeComing) && strtolower($TaskTypeComing) == 'story'){
										if(isset($TaskStoryPointComing) && is_numeric($TaskStoryPointComing)){
											if (strpos($TaskStoryPointComing, '.') > -1) {
												$NewStoryPoint = number_format($TaskStoryPointComing, 2);
											} else {
												$NewStoryPoint = $TaskStoryPointComing;
											}
											$data['story_point'] = $NewStoryPoint;
										}else{
											$data['story_point'] = 0;
										}
									}else{
										$data['story_point'] = 0;
									}
									
									$pror = 2;
									if(isset($TaskPriorityComing)){
										if (strtolower($TaskPriorityComing) == 'high') {
											$pror = 0;
										} elseif (strtolower($TaskPriorityComing) == 'medium') {
											$pror = 1;
										}
									}
									$data['priority'] = $pror;
									
									if (!isset($TaskAssignedToComing)) {
										$data['assign_to'] = 0;
									} else {
										if (strtolower($TaskAssignedToComing) != 'me' && $TaskAssignedToComing) {
											if (!empty($task_assign_to_users) && array_search($TaskAssignedToComing, $task_assign_to_users)) {
												$data['assign_to'] = array_search($TaskAssignedToComing, $task_assign_to_users);
											} else {
												$data['assign_to'] = 0;
											}
										} else {
											$data['assign_to'] = 0;
										}
									}
									
									$data['sort'] = 0;
									$data['task_label'] = 0;
									
									$data['created'] = GMT_DATETIME;
									$data['modified'] = GMT_DATETIME;
		
									$this->loadModel('ProjectTemplateCase');
									$this->ProjectTemplateCase->saveAll($data);
	
								}else{
									$titleNotPresentCount ++;
								}
								
							}
							$i++;
						}
						
						fclose($handle);
					}
	
					if($titleNotPresentCount > 0){
						$this->Session->write("ERROR", __("<b>" . $titleNotPresentCount. "</b> tasks did not import to the project template '<b>".$project_template_name."</b>' due to <b>blank title </b>",true));
						$this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
					}else{
						$this->Session->write("SUCCESS", __("Tasks imported successfully to the project template '".$project_template_name."'",true));
						$this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
					}
				}else{
					$this->Session->write("ERROR", __("Your uploaded CSV file is blank. Please import a valid CSV file with some data",true));
					$this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
				}
            } else {
                $this->Session->write("ERROR", __("Please import a valid CSV file",true));
                $this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
            }
        } else {
            $this->Session->write("ERROR", __("Please import a valid CSV file",true));
            $this->redirect(HTTP_ROOT . "templates/projects/".base64_encode($project_template_id));
        }
    }
	

    function quickTask(){
        $arr['msg'] = __('Something went wrong',true);
        $arr['status'] = 0;
        if(isset($this->request->data) && !empty($this->request->data)){
             $data['template_id'] = $this->request->data['template_id'];
             $data['user_id'] = SES_ID;
             $data['company_id'] = SES_COMP;
             $data['project_template_taskgroup_id'] = ($this->request->data['mid'])?$this->request->data['mid']:0 ;
             $data['title'] = $this->request->data['title'];
             $data['id'] = $this->request->data['task_id'];
             $data['description'] = $this->request->data['description'];
            

               $estimated_hours =  ($this->request->data['estimated'])? $this->request->data['estimated']:0;
               /* saving in secs */
               if (strpos($estimated_hours, ':') > -1) {
                    $split_est = explode(':', $estimated_hours);
                    $est_sec = ((($split_est[0]) * 60) + intval($split_est[1])) * 60;
                } else {
                    $est_sec = $estimated_hours * 3600;
                }
                $estimated_hours = $est_sec;
             $data['estimated'] = $estimated_hours;   

             $data['task_type'] = $this->request->data['task_type'];
             $data['priority'] = $this->request->data['priority'];
             $data['assign_to'] = $this->request->data['assign_to'];
             $data['story_point'] = $this->request->data['story_point'];
             $data['parent_id'] = ($this->request->data['parent_id'])?$this->request->data['parent_id']:0;
             $data['task_label'] = ($this->request->data['task_label'])?$this->request->data['task_label']:0;
             $fileArray = (isset($this->request->data['allFiles']))?$this->request->data['allFiles']:array();
             $this->loadModel('ProjectTemplateCase');
             if($this->ProjectTemplateCase->save($data)){
                $domain = HTTP_ROOT;
                $chk = 0;
                if (is_array($fileArray) && count($fileArray)) {
                    $usedspace = $GLOBALS['usedspace'];
                    foreach ($fileArray as $filename) {
                        if ($filename && strstr($filename, "|")) {
                            $fl = explode("|", $filename);
                            if (strstr($fl['0'], "__utf__")) {
                                $t_fl = explode("__utf__", $fl['0']);
                                $fl[0] = $t_fl[1];
                            }

                            if (isset($fl['0'])) {
                                $file = $fl['0'];
                                $filesize = number_format(($fl[1] / 1024), 2, '.', '');
                                if (strtolower($GLOBALS['Userlimitation']['storage']) == 'unlimited' || ($usedspace <= $GLOBALS['Userlimitation']['storage'])) {
                                    $usedspace +=$filesize;
                                    if (defined('USE_S3') && USE_S3 == 1) {
                                        $s3 = new S3(awsAccessKey, awsSecretKey);
                                        $info = $s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_TEMP . $file);
                                    } else {
                                        if (file_exists(DIR_CASE_FILES . 'temp/' . $file)) {
                                            $info = 1;
                                        }
                                    }
                                    if ($info) {
                                        $chk++;
                                    }
                                }
                            }
                        }
                    }
                }
                if(!empty($fileArray)){
                    $this->uploadAndInsertFile($fileArray, $this->ProjectTemplateCase->id, $this->request->data['template_id'], 0, $domain, '');
                }
                $arr = $this->project_template($data['template_id']);  
             }
        }
        echo json_encode($arr);exit;
    }
    function uploadAndInsertFile($files, $caseid, $tmpl_id,$cmnt, $domain = HTTP_ROOT) {
        $CaseFile = ClassRegistry::init('ProjectTemplateCaseFile');
        $CaseFile->recursive = -1;
        $CaseFile->cacheQueries = false;
        $sql = "SELECT SUM(file_size) AS file_size  FROM case_files   WHERE company_id = '" . SES_COMP . "'";
        $res1 = $CaseFile->query($sql);
        $fkb = $res1['0']['0']['file_size'];
        $allfiles = "";
        $filename = "";
        $sizeinkb = 0;
        $fileid = 0;
        $filecount = 0;
		$res = array();
        foreach ($files as $file) {
            if ($file && strstr($file, "|")) {
                $n_file_nm = '';
                $fl = explode("|", $file);
                if (strstr($fl['0'], "__utf__")) {
                    $t_fl = explode("__utf__", $fl['0']);
                    $fl[0] = $t_fl[1];
                    $csFiles['display_name'] = $t_fl[0];
                    $n_file_nm = $t_fl[0];
                }
                if (isset($fl['0'])) {
                    $filename = $fl['0'];
                    $original_filename = $fl[count($fl) - 1];
                    $thumb_filename = "thumb_" . $filename;
                }
                if (isset($fl['1'])) {
                    $sizeinkb = $fl['1'];
                }
                if (isset($fl['2'])) {
                    $fileid = $fl['2'];
                }
                if (isset($fl['3'])) {
                    $filecount = $fl['3'];
                }
                if ($filecount && $fileid) {
                    ###### Update case file table for same file
                    $csFile['id'] = $fileid;
                    $csFile['count'] = $filecount;
                    $CaseFile->saveAll($csFile);
                } elseif ($fileid) {
                    continue;
                }
                $res['file_error'] = 0;
                if ((strtolower($GLOBALS['Userlimitation']['storage']) == 'unlimited') || (($fkb / 1024) < $GLOBALS['Userlimitation']['storage'])) {
                    $fkb += $sizeinkb;
                    ###### Insert to case file table
                    $csFiles['user_id'] = SES_ID;
                    $csFiles['company_id'] = SES_COMP;
                    $csFiles['project_template_case_id'] = $caseid;
                    $csFiles['template_id'] = $tmpl_id;
                    $csFiles['file'] = $original_filename; #$filename;
                    $csFiles['upload_name'] = $filename;
                    $csFiles['thumb'] = $thumb_filename;
                    $csFiles['file_size'] = $sizeinkb;
                    if ($CaseFile->saveAll($csFiles)) {
                        if (defined('USE_S3') && USE_S3 == 1) {
                            $s3 = new S3(awsAccessKey, awsSecretKey);
                            $ret_res = $s3->copyObject(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_TEMP . $filename, BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER . $filename, S3::ACL_PRIVATE);
                            $ret_res = $s3->copyObject(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_TEMP . $thumb_filename, BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $filename, S3::ACL_PRIVATE);
                        } else {
                            $ret_res = copy(DIR_CASE_FILES . 'temp/' . $filename, DIR_CASE_FILES . $filename);
                            unlink(DIR_CASE_FILES . 'temp/' . $filename);
                            $ret_res = copy(DIR_CASE_FILES . 'temp/thumb_' . $filename, DIR_CASE_FILES . 'thumb_' . $filename);
                            unlink(DIR_CASE_FILES . 'temp/thumb_' . $filename);
                        }
                        if ($ret_res) {
                            //$s3->deleteObject(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_TEMP.$filename, S3::ACL_PRIVATE);
                        }
                    }
                    if ($n_file_nm != '') {
                        $allfiles.= "<a href='" . $domain . "users/login/?file=" . $filename . "' target='_blank' style='text-decoration:underline;color:#0571B5;line-height:24px;'>" . $n_file_nm . "</a> <font style='color:#989898;font-size:12px;'>(" . number_format($sizeinkb, 1) . " kb)</font><br/>";
                    } else {
                        $allfiles.= "<a href='" . $domain . "users/login/?file=" . $filename . "' target='_blank' style='text-decoration:underline;color:#0571B5;line-height:24px;'>" . $filename . "</a> <font style='color:#989898;font-size:12px;'>(" . number_format($sizeinkb, 1) . " kb)</font><br/>";
                    }
                } else {
                    $res['file_error'] = 1;
                    $res['efile'][] = $file;
                }
            }
        }
        $res['allfiles'] = $allfiles;
        $filesize = $fkb / 1024;
        $res['storage'] = number_format($filesize, 2);
        return $res;
    }
    function insertreorderTSK(){
        $arr['msg'] = __('Something went wrong',true);
        $arr['status'] = 0;
        //print_r($this->request->data);
         if(isset($this->request->data) && !empty($this->request->data)){
             $this->loadModel('ProjectTemplateCase');
                $data = $this->request->data;
                $tmpl_id = $this->request->data['tmpl_id'];
                $id = substr($this->request->data['id'],(strrpos($this->request->data['id'],'-'))+1);
                $parent_id = str_replace('ptr_', '',$this->request->data['parent_id']);
                $this->ProjectTemplateCase->create();
                $this->ProjectTemplateCase->id = $id;
                $data_arr['ProjectTemplateCase']['project_template_taskgroup_id'] = $parent_id;
                $data_arr['ProjectTemplateCase']['parent_id'] = 0;
                $this->ProjectTemplateCase->save($data_arr);

                $this->ProjectTemplateCase->updateAll(array('ProjectTemplateCase.parent_id'=>0),array('ProjectTemplateCase.parent_id'=>$id));

                unset($data['id']);
                unset($data['parent_id']);

               foreach($this->request->data as $key => $value){  
                foreach($value as $k=>$v){
                     $this->ProjectTemplateCase->create();
                     $this->ProjectTemplateCase->id = $v;
                     $this->ProjectTemplateCase->saveField('sort',($k+1));
                }
             }
             $arr = $this->project_template($tmpl_id); 
             $arr['msg'] = __('Task moved successfully',true);
             $arr['status'] = 1;
         }

        echo json_encode($arr);exit;
    }
    function fetchParentTask() {
        $mid = $this->data['id'];        
        $id = $this->data['v'];        
        $parent_id = $this->data['pid']; 
        $parents = array();
        $this->loadModel('ProjectTemplateCase');
        do{
          $arr = $this->ProjectTemplateCase->find('first',array('conditions'=>array('ProjectTemplateCase.id'=>$parent_id),'fields'=>array('ProjectTemplateCase.title','ProjectTemplateCase.parent_id'))); 
          $parents[] = $arr['ProjectTemplateCase'];  
          $parent_id =  $arr['ProjectTemplateCase']['parent_id'];

        }while($parent_id);    

        $ret_text = array();
        if($parents){
            $ret_text['parent'] = $parents;
            $ret_text['message'] = '';
            $ret_text['status'] = 1;
            $i = 0;
        }

        if(empty($ret_text)){
            $ret_text['message'] = __('No parent present or parent has limited access.');
            $ret_text['status'] = 0;
        }
        echo json_encode($ret_text);
        exit;
    }
    function get_project_templates(){
        $arr['status'] = 1;
        $this->loadModel('ProjectMethodology');
        $arr['result'] = $this->ProjectMethodology->find('all',array('fields'=>array('id','title','status_group_id'),'order'=>array('seq_no'=>'ASC')));
        echo json_encode($arr);exit;

}
/* Fetch dependant or parent details for project plan tasks
*Sangita 05/07/2021
*/
function plan_dependent_overview() {
    $this->layout='ajax';
    $this->loadModel('ProjectTemplateCase');
    $id = $this->data['id'];
    $depends = explode(',', $this->data['deps']);   
    $projPlan = $this->ProjectTemplateCase->find('all', array('conditions' => array('id' => $depends,'company_id'=>SES_COMP)));
    echo json_encode($projPlan);
    exit;
}
}