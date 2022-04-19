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
class MilestonesController extends AppController {
	var $helpers = array ('Html','Form','Casequery','Format');
	var $name = 'Milestone';
	public $components = array('Format');
    var $paginate = array();
    public $uses = array('EasyCase', 'EasycaseMilestone', 'Milestone');
	public function fetchTaskItemOptions(){
		$this->layout='ajax';
		$projuid = $this->data['projUniq'];
		$prj_cls = ClassRegistry::init('Project');
		$prj_cls->recursive = -1;
		$project_dtls = $prj_cls->find('first',array('conditions'=>array('Project.uniq_id'=>$projuid),'fields'=>'Project.id'));
		$this->loadModel("Milestone");
		$milestones = $this->Milestone->find('list',array('conditions'=>array('project_id'=>$project_dtls['Project']['id'],'isactive'=>1),'order'=>'end_date DESC'));
		
		$respArr['milestones'] = [];
		$respArr['labels'] = [];
		$respArr['milestones_status'] = false;
		$respArr['labels_status'] = false;
		$respArr['custom_fields']['caseCustomFieldDetails'] = [];
		
		if($milestones){
			$respArr['milestones'] = $milestones;
			$respArr['milestones_status'] = true;
		}
		
		//Fetch cfs
		$this->loadModel("CustomField");                      
		$taskCustomeFields = $this->CustomField->ajaxfetchTaskCustomField(); 
		$respArr['custom_fields']['caseCustomFieldDetails'] = $taskCustomeFields;
		
		//Fetch members
		$task_id = isset($this->request->data['task_id']) ? $this->request->data['task_id']:'';	
		echo json_encode($respArr);
		exit;		
	}
    function assign_case($miles = null) {
		$this->layout='ajax';
        if (!empty($miles)) {
            $this->request->data = $miles;
            $caseid = $this->request->data['caseid'];
            $project_id = $this->request->data['project_id'];
            $milestone_id = $this->request->data['milestone_id'];
        }else{
          $caseid = $this->params->data['caseid'];
      		$project_id = $this->params->data['project_id'];
      		$milestone_id = $this->params->data['milestone_id'];
        }
		    $this->loadModel('EasycaseMilestone');
        $this->loadModel('Easycase');

		$parentTasks = null;
		if (!empty($caseid)) {
			//fetch parent tasks to check if has any parent task
			$parentTasks = $this->Easycase->find('list', array('conditions' => array('Easycase.id' =>$caseid, 'Easycase.istype' => 1,'Easycase.project_id' =>$project_id), 'fields' => array('Easycase.id','Easycase.parent_task_id')));
		}else{
			echo json_encode(array("message"=>"error"));exit;
		}		
		//fetch children tasks to update milestone id
		$childTasks = $this->Easycase->getSubTaskChild($caseid, $project_id);
		if (!empty($childTasks['child'])) {
			$caseid = array_merge($caseid, $childTasks['child']);
		}
		if($caseid){
			$caseid = array_unique($caseid);
		}
		$id_seq_arr = $this->EasycaseMilestone->query('SELECT MAX(id_seq) as id_seq FROM easycase_milestones WHERE milestone_id = '.$milestone_id);
		$idseq_mil = 0;
		if($id_seq_arr && $id_seq_arr['0'][0]['id_seq']){
			$idseq_mil = (int)($id_seq_arr['0'][0]['id_seq']+1);
		}
		foreach($caseid as $k=>$cid){
			if($cid) {
				if($idseq_mil == 0){
					$idseq_mil = 1;
				}
				$EasycaseMilestone['EasycaseMilestone']['easycase_id'] = $cid;
				$EasycaseMilestone['EasycaseMilestone']['milestone_id'] = $milestone_id;
				$EasycaseMilestone['EasycaseMilestone']['project_id'] = $project_id;
				$EasycaseMilestone['EasycaseMilestone']['user_id'] = SES_ID;				
				$EasycaseMilestone['EasycaseMilestone']['id_seq'] = $idseq_mil;
				$this->EasycaseMilestone->saveAll($EasycaseMilestone);
				$idseq_mil++;
			}
		}
		//Removing parents of moved child
		if($parentTasks){
			foreach($parentTasks as $kp => $vp){
				if(!empty($vp)){
					if(!in_array($vp, $caseid)){ //for multiple move
						if(!$this->EasycaseMilestone->checkParentInMilestone($vp, $project_id, $milestone_id)){
							$this->Easycase->updateAll(array('Easycase.parent_task_id' => NULL), array('Easycase.id' => $kp, 'Easycase.project_id' => $project_id));
						}
					}
				}
			}		
		}
        if (!empty($miles)) {
            $arr['status'] = 1;
            $arr['msg'] = __('Task assigned successfully.');
            return $arr;
        } else {
           echo json_encode(array("message"=>"success"));exit;
        }
	}
	function remove_case(){
		$this->layout='ajax';
		$caseid = $this->params->data['caseid'];
		$project_id = $this->params->data['project_id'];
		$milestone_id = $this->params->data['milestone_id'];

		$this->loadModel('EasycaseMilestone');
		if($this->EasycaseMilestone->deleteAll(array('project_id'=>$project_id,'milestone_id'=>$milestone_id,'easycase_id'=>$caseid))){
			echo 'success';exit;
		}else{
			echo 'error';exit;
		}
	}
    function delete_milestone($uniqid = '', $page = NULL, $api_flag = '') {
        if (!empty($api_flag) && $api_flag == 1) {
            $this->request->data = $uniqid;
            unset($uniqid);
        }
        $uniqid = $uniqid ? $uniqid : $this->request->data['uniqid'];
		if(isset($uniqid) && $uniqid){
			$checkQuery = "SELECT Milestone.id, Milestone.title, Milestone.project_id FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id=".SES_ID." AND Milestone.uniq_id='".$uniqid."' AND Milestone.company_id='".SES_COMP."'";
			$checkMstn = $this->Milestone->query($checkQuery);                        
			if(count($checkMstn) && isset($checkMstn[0]['Milestone']['id']) && $checkMstn[0]['Milestone']['id']) {
				$id = $checkMstn[0]['Milestone']['id'];
				if($this->Milestone->delete($id)){
                $this->loadModel('EasycaseMilestone');
                if (isset($this->request->data['conf_check']) && $this->request->data['conf_check'] == 2) {
                    $cases = $this->EasycaseMilestone->find('list',array('conditions'=>array('EasycaseMilestone.milestone_id'=>$id),'fields'=>array('EasycaseMilestone.id','EasycaseMilestone.easycase_id')));
                    if($cases){
                        $this->loadModel('Easycase');
                        foreach($cases as $k => $v){
                            $this->Easycase->delete($v);
                        }
                    }
                }
				  $this->EasycaseMilestone->query("DELETE FROM easycase_milestones WHERE milestone_id='".$id."'");
				  $arr['err'] = 0;
          $arr['project_uid'] = $checkMstn[0]['Milestone']['project_id'];
				  $arr['msg'] = __("Task Group '").$checkMstn[0]['Milestone']['title'].__("' has been deleted.");
          }else{
					$arr['err'] = 1;
					$data['msg'] = __("Unable to delete Sprint. Please try again.");
				}
				//$this->Session->write('SUCCESS',"Milestone '".$checkMstn[0]['Milestone']['title']."' has been deleted.");
			} else {
				$arr['err'] = 1;
				$arr['msg'] = __("Oops! Error occured in deletion of Task Group.",true);
				//$this->Session->write('ERROR','Oops! Error occured in deletion of milestone');
			}
	    } else {
			$arr['err'] = 1;
			$arr['msg'] = __("Oops! Error occured in deletion of Task Group.",true);
			//$this->Session->write('ERROR','Oops! Error occured in deletion of milestone');
	    }
        if (!empty($api_flag) && $api_flag == 1) {
            return $arr;
        } else {
            echo json_encode($arr);
            exit;
        }
		//$this->redirect($_SERVER['HTTP_REFERER']);exit;
	    //$this->redirect(HTTP_ROOT."milestone");exit;
	}
	
	function case_listing(){
		$this->layout='ajax';
		$this->loadModel('EasycaseMilestone');
		
		$milestone_id = $this->params->data['milestone_id'];
		$getCount = $this->params->data['count'];
		$uid = $this->params->data['uid'];
		if(isset($this->params->data['msid']) && $this->params->data['msid']) {
			$id = $this->params->data['msid'];
			$allCases = $this->EasycaseMilestone->delete($id);
		}
		
		//$allCases = $this->EasycaseMilestone->find('all', array('conditions' => array('EasycaseMilestone.milestone_id' => $milestone_id),'order' => array('EasycaseMilestone.created DESC')));
		
		$allCases = $this->EasycaseMilestone->query("SELECT * FROM easycases as Easycase,easycase_milestones as EasycaseMilestone WHERE Easycase.isactive='1' AND Easycase.istype='1' AND  EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.milestone_id=".$milestone_id." ORDER BY EasycaseMilestone.created DESC LIMIT 0,50");
		
		$this->set('allCases',$allCases);
		$this->set('getCount',$getCount);
		$this->set('uid',$uid);
	}
    function add_case($miles = null) {
        if (!empty($miles)) {
            $this->request->data = $miles;
        }
		$this->layout='ajax';
        $mstid = $this->request->data['mstid'];
        $projid = $this->request->data['projid'];
		$query = "";
        if (isset($this->request->data['title']) && trim($this->request->data['title'])) {
            $srchstr = addslashes($this->request->data['title']);
			//$query = "AND Easycase.title LIKE '%$srchstr%'";
			if(trim(urldecode($srchstr))) {
				$query = $this->Format->caseKeywordSearch($srchstr,'title');
			}
		}
        $response = array();
		$milestone = $this->Milestone->findById($mstid);
		$this->loadModel('Easycase');
        $response +=$milestone;
		$easycases = $this->Easycase->query("SELECT * FROM easycases as Easycase WHERE Easycase.project_id=".$projid." AND Easycase.isactive='1' AND Easycase.legend !='3' AND Easycase.legend !='5' AND Easycase.type_id !='10' AND Easycase.istype='1' ".$query." AND NOT EXISTS(SELECT EasycaseMilestone.easycase_id FROM easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.project_id=".$projid.") ORDER BY Easycase.dt_created DESC LIMIT 0,50");
		
        $response['tasks'] = $easycases;
		$this->set('milestone',$milestone);
		$this->set('easycases',$easycases);
		
		$curProjName = NULL;
		$curProjShortName = NULL;
		
		$this->loadModel('ProjectUser');
		$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
		$projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.id' => $projid,'ProjectUser.user_id'=>SES_ID,'Project.isactive'=>1,'Project.company_id'=>SES_COMP),'fields' => array('Project.name','Project.short_name')));

		if(count($projArr)) {
			$curProjName = $projArr['Project']['name'];
			$curProjShortName = $projArr['Project']['short_name'];
		}
        $response['project_name'] = $curProjName;
        $response['project_short_name'] = $curProjShortName;
		
		$this->set('curProjName',$curProjName);
		$this->set('curProjShortName',$curProjShortName);
		$this->set('mstid',$mstid);
		$this->set('projid',$projid);
        $response['mstid'] = $mstid;
        $response['projid'] = $mstid;
        if (!empty($miles)) {
            return $response;
        }
        if (isset($this->request->data['from_dsbd']) && trim($this->request->data['from_dsbd'])) {
			$this->set('add_task_from_dsbd',1);
		}else{
			$this->set('add_task_from_dsbd',0);
		}
	}
	function removeCasesFromMilestone(){
		$this->layout='ajax';
		$mstid = $this->params->data['mstid'];
		$projid = $this->params->data['projid'];
		$query = "";
		if(isset($this->params->data['title']) && trim($this->params->data['title'])) {
			$srchstr = addslashes($this->params->data['title']);
			//$query = "AND Easycase.title LIKE '%$srchstr%'";
			if(trim(urldecode($srchstr))) {
				$query = $this->Format->caseKeywordSearch($srchstr,'title');
			}
		}
		
		$milestone = $this->Milestone->findById($mstid);
		$this->loadModel('Easycase');
		$easycases = $this->Easycase->query("SELECT * FROM easycases as Easycase,easycase_milestones AS Em WHERE Easycase.id=Em.easycase_id AND Em.milestone_id = $mstid  AND Easycase.project_id=".$projid." AND Easycase.isactive='1' AND Easycase.type_id !='10' AND Easycase.istype='1' ".$query." ORDER BY Easycase.dt_created DESC LIMIT 0,50");
		$this->set('milestone',$milestone);
		$this->set('easycases',$easycases);
		
		$curProjName = NULL;
		$curProjShortName = NULL;
		
		$this->loadModel('ProjectUser');
		$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
		$projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.id' => $projid,'ProjectUser.user_id'=>SES_ID,'Project.isactive'=>1,'Project.company_id'=>SES_COMP),'fields' => array('Project.name','Project.short_name')));

		if(count($projArr)) {
			$curProjName = $projArr['Project']['name'];
			$curProjShortName = $projArr['Project']['short_name'];
		}
		
		$this->set('curProjName',$curProjName);
		$this->set('curProjShortName',$curProjShortName);
		$this->set('mstid',$mstid);
		$this->set('projid',$projid);
		//$this->render('add_case');
	}

	function ajax_milestone_menu(){
		$this->layout='ajax';
		if(isset($this->request->data['project_id'])){
			$query = "SELECT Milestone.id,Milestone.title FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id='".SES_ID."' AND Milestone.isactive = 1 AND Milestone.company_id='".SES_COMP."' AND Milestone.project_id='".$this->request->data['project_id']."' ORDER BY Milestone.start_date ASC";
			$milestone_all = $this->Milestone->query($query);
			$this->set('milestone_all',$milestone_all);
			$this->set('pjid',$this->request->data['project_id']);
		}
	}
	
    function api_milestone_menu($proId = '',$pm_type=1) {
        $this->layout = 'ajax';
        $this->loadModel('EasycaseMilestone');
        $this->loadModel('Easycase');
		$pmcond = ' AND 1';
		$cond_mils = array('EasycaseMilestone.easycase_id = Easycase.id','Easycase.istype' => 1);
		if($pm_type == 2){
			$pmcond = ' AND Milestone.isactive = 1';
			$cond_mils = array('EasycaseMilestone.easycase_id = Easycase.id','Easycase.istype' => 1,'Easycase.legend' => array(1,2,4));
		}
        $project_id = !empty($this->request->data['project_id']) ? $this->request->data['project_id'] : $proId;
        if (isset($project_id) && !empty($project_id)) {
            $query = "SELECT * FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id='" . SES_ID . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.project_id='" . $project_id . "'".$pmcond." ORDER BY Milestone.id_seq ASC";
            $milestone_all = $this->Milestone->query($query);
            $in_con = array();
            if (!empty($milestone_all)) {
                foreach ($milestone_all as $key => $val) {
					if($pm_type == 2 && $val['Milestone']['is_started']){
                    $count = $this->EasycaseMilestone->find('count', array('conditions' => array('EasycaseMilestone.milestone_id' => $val['Milestone']['id'],'EasycaseMilestone.project_id' => $project_id),
                        'joins' => array(
                        array('table' => 'easycases',
                    'alias' => 'Easycase',
                    'type' => 'inner',
                    'conditions' => array('EasycaseMilestone.easycase_id = Easycase.id','Easycase.istype' => 1)))));
					}else{
						$count = $this->EasycaseMilestone->find('count', array('conditions' => array('EasycaseMilestone.milestone_id' => $val['Milestone']['id'],'EasycaseMilestone.project_id' => $project_id),
							'joins' => array(
							array('table' => 'easycases',
						'alias' => 'Easycase',
						'type' => 'inner',
						'conditions' => $cond_mils))));
					}
                    $milestone_all[$key]['Milestone']['no_task'] = $count;
                }
            }
			if($pm_type == 2){
				$tasks = $this->Easycase->find('all', array('fields' => array('Easycase.id', 'Easycase.project_id'), 'conditions' => array('Easycase.project_id' => $project_id, 'Easycase.istype' => 1,'Easycase.legend' => array(1,2,4))));
			}else{
            $tasks = $this->Easycase->find('all', array('fields' => array('Easycase.id', 'Easycase.project_id'), 'conditions' => array('Easycase.project_id' => $project_id, 'Easycase.istype' => 1)));
			}
            $default_task = array();
            $default_count = 0;
            foreach ($tasks as $tkey => $tval) {
                $easycase_milestone = $this->EasycaseMilestone->find('first', array('conditions' => array('EasycaseMilestone.easycase_id' => $tval['Easycase']['id'], 'EasycaseMilestone.project_id' => $tval['Easycase']['project_id'])));
                if (empty($easycase_milestone)) {
                    $default_count++;
                }
            }
            if (empty($key)) {
                $key = 0;
            }
            if (!empty($default_count)) {
                $milestone_all[$key + 1]['Milestone']['no_task'] = $default_count;
                $milestone_all[$key + 1]['Milestone']['title'] = 'Default Task Group';
                $milestone_all[$key + 1]['Milestone']['uniq_id'] = 'default';
                $milestone_all[$key + 1]['Milestone']['project_id'] = $project_id;
                $milestone_all[$key + 1]['Milestone']['user_id'] = SES_ID;
                $milestone_all[$key + 1]['Milestone']['company_id'] = SES_COMP;
            }
            if (!empty($proId)) {
                return $milestone_all;
            }
            $this->set('milestone_all', $milestone_all);
            $this->set('pjid', $this->request->data['project_id']);
        }
    }

   function ajax_new_milestone($mileuniqid = null, $inpu_default = null, $api_flag = null) {

        if (!empty($inpu_default) && !empty($api_flag) && ($api_flag == 2 || $api_flag = 3)) {
            $this->request->data = $inpu_default;
            unset($inpu_default);
        }
            $this->layout = 'ajax';
            $mileuniqid = 0;
            if (isset($this->data['mileuniqid']) && $this->data['mileuniqid']) {    
                $mileuniqid = $this->data['mileuniqid'];
            }
	    $this->loadModel('ProjectUser');
            $this->loadModel('Easycase');
	    $this->loadModel('Project');
		$proje_methodlogy = 1;
            if((isset($_REQUEST['type']) && trim($_REQUEST['type']) == 'inline') || $inpu_default){
            $this->request->data['Milestone'] = $this->request->data;
					if(trim($_REQUEST['project_id']) == ''){
                        $arr['error']=1;
                        $arr['msg'] = __('Sorry! You do not have active project. Please create a project.',true);
                        if($inpu_default){
                            return $arr;
                        }else{
                    echo json_encode($arr);
                    exit;
                        } 
                    }
                    $this->loadModel('Project');
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $this->request->data['project_id']), 'fields' => array('Project.id','Project.project_methodology_id')));
                    if($projArr){
                $this->request->data['Milestone']['project_id'] = $projArr['Project']['id'];
                            $arr['pid'] = $projArr['Project']['id'];
					$proje_methodlogy = $projArr['Project']['project_methodology_id'];
                    }else{                    
                            $arr['error']=1;
					if($proje_methodlogy == 2){
						$arr['msg'] = __('Sorry! We are not able to post this Sprint. Try again.',true);
					}else{
                            $arr['msg'] = __('Sorry! We are not able to post this Task Group. Try again.',true);
					}
                            if($inpu_default){
                                return $arr;
                            }else{
                                echo json_encode($arr);exit;
                            }
                    }
            }
        if (!empty($this->request->data['Milestone']) && $this->request->data['Milestone']['title'] && !$this->request->data['mileuniqid']) {
			$this->request->data['Milestone']['title'] = trim($this->request->data['Milestone']['title']);
			$chk = 1;
			if(trim($this->request->data['Milestone']['start_date']) != '' && trim($this->request->data['Milestone']['end_date']) != ''){
				$this->request->data['Milestone']['start_date'] = date('Y-m-d',strtotime($this->request->data['Milestone']['start_date']));
				$this->request->data['Milestone']['end_date'] = date('Y-m-d',strtotime($this->request->data['Milestone']['end_date']));
				if (strtotime($this->request->data['Milestone']['start_date']) > strtotime($this->request->data['Milestone']['end_date'])) {
						$chk = 0;
				}
			}else{
				unset($this->request->data['Milestone']['start_date']);
				unset($this->request->data['Milestone']['end_date']);
			}
			if(trim($this->request->data['Milestone']['estimated_hours']) == ''){
				unset($this->request->data['Milestone']['estimated_hours']);
			}
			if (!$chk) {
				$arr['error']=1;
				$arr['msg'] = __('Start date cannot exceed End date');
                if (!empty($api_flag) && $api_flag == 2) {
                    return $arr;
                } else {
                    echo json_encode($arr);
                    exit;
                }
			} else {
				if ($this->request->data['Milestone']['id']) {
					$checkDuplicate = $this->Milestone->query("SELECT Milestone.id FROM milestones AS Milestone WHERE Milestone.title='" . addslashes($this->request->data['Milestone']['title']) . "' AND Milestone.project_id='" . $this->request->data['Milestone']['project_id'] . "' AND Milestone.id != '" . $this->request->data['Milestone']['id'] . "'");
				} else {
					$mlUniqId = md5(uniqid());
					$this->request->data['Milestone']['uniq_id'] = $mlUniqId;
					$this->request->data['Milestone']['company_id'] = SES_COMP;
					$checkDuplicate = $this->Milestone->query("SELECT Milestone.id FROM milestones AS Milestone WHERE Milestone.title='" . addslashes($this->request->data['Milestone']['title']) . "' AND Milestone.project_id='" . $this->request->data['Milestone']['project_id'] . "'");
					$arr['muid']= $mlUniqId;
				}

				if (isset($checkDuplicate[0]['Milestone']['id']) && $checkDuplicate[0]['Milestone']['id']) {
					$arr['error']=1;
					if($proje_methodlogy == 2){
						$arr['msg'] = __('Oops! Sprint Title already exists',true);
					}else{
					$arr['msg'] = __('Oops! Task Group Title already exists',true);
          }
          if (!empty($api_flag) && $api_flag == 2) {
              return $arr;
          }
					//$this->Session->write("ERROR", "Milestone Title already exists.");
				} else {
					if(isset($this->request->data['Milestone']['user_id']) && trim($this->request->data['Milestone']['user_id'])){
					}else{
						$this->request->data['Milestone']['user_id'] = SES_ID;
					}
					if(empty($this->request->data['Milestone']['id']) || !isset($this->request->data['Milestone']['id'])){
						if($proje_methodlogy == 2){
						$Highest_sq = $this->Milestone->find('first', array('conditions' => array('Milestone.project_id' => $this->request->data['Milestone']['project_id']),'fields' => array('Milestone.id','Milestone.id_seq'),'order'=>array('Milestone.id_seq'=>'DESC')));		
						$this->request->data['Milestone']['id_seq'] = $Highest_sq['Milestone']['id_seq']+1;
						}else{
							$this->request->data['Milestone']['id_seq'] = 0;
						}
					}
					if ($this->Milestone->save($this->request->data)) {   
						$arr['milston_ttl'] =$this->request->data['Milestone']['title'];
                                                $milestone_id_now = $this->Milestone->getLastInsertId();
						$arr['success'] =1;
						$arr['milestone_id'] = $milestone_id_now;
						if($inpu_default || (isset($this->request->data['Milestone']['default_id']) && trim($this->request->data['Milestone']['default_id']) == 'default')){
							$alldefaultCases = $this->Easycase->query("SELECT Easycase.id FROM easycases AS Easycase WHERE Easycase.id NOT IN(SELECT EasycaseMilestone.easycase_id FROM easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.project_id =".$this->request->data['Milestone']['project_id'].") AND Easycase.project_id =".$this->request->data['Milestone']['project_id']);
							if($alldefaultCases){
								$emarr = array();
								$this->loadModel('EasycaseMilestone');
								$id_seq_arr = $this->EasycaseMilestone->query('SELECT MAX(id_seq) as id_seq FROM easycase_milestones WHERE milestone_id = '.$milestone_id_now);
								$id_seq = '';
								if($id_seq_arr['0'][0]['id_seq']){
									$id_seq = $id_seq_arr['0'][0]['id_seq'];
								}
								foreach($alldefaultCases as $k => $v){
									if($v['Easycase']['id']) {                                                            
											$EasycaseMilestone['EasycaseMilestone']['easycase_id'] = $v['Easycase']['id'];
											$EasycaseMilestone['EasycaseMilestone']['milestone_id'] = $milestone_id_now;
											$EasycaseMilestone['EasycaseMilestone']['project_id'] = $this->request->data['Milestone']['project_id'];
											$EasycaseMilestone['EasycaseMilestone']['user_id'] = SES_ID;
											if($id_seq != ''){
													$EasycaseMilestone['EasycaseMilestone']['id_seq'] = (int)($id_seq+1);
													$id_seq = $EasycaseMilestone['EasycaseMilestone']['id_seq'];
											}else{
													$EasycaseMilestone['EasycaseMilestone']['id_seq'] = 1;
											}
											$this->EasycaseMilestone->saveAll($EasycaseMilestone);
									}
								}
							}
						} 
						if ($this->request->data['Milestone']['id']) {
							if($proje_methodlogy == 2){
								$arr['msg'] = __('Sprint updated successfully.',true);
							}else{
							$arr['msg'] =__('Task Group updated successfully.',true);
							}
						} else {
							if($proje_methodlogy == 2){
								$arr['msg'] = __('Sprint added successfully.',true);
						} else {
							$arr['msg'] =__('Task Group added successfully.',true);
							}
							$this->ProjectUser->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE user_id=" . SES_ID . " and project_id='" . $this->request->data['Milestone']['project_id'] . "' and company_id='" . SES_COMP . "'");
						}
					} else {
						$arr['error']=1;
						if($proje_methodlogy == 2){
								$arr['msg'] = __('Sorry! We are not able to post this Sprint. Try again.',true);
							}else{
						$arr['msg'] = __('Sorry! We are not able to post this Task Group. Try again.',true);
							}
						//$this->Session->write("ERROR", "Milestone can't be posted");
					}
				}
        if (!empty($api_flag) && $api_flag == 2) {
            return $arr;
        }
        if($inpu_default){
            return $arr;
        }else{
            echo json_encode($arr); exit;
        }
			}
	    }

		$projCond = '';
        $edit_data = array();
	    if (isset($mileuniqid) && $mileuniqid && $mileuniqid != 'default') {
			$milearr = $this->Milestone->find('first', array('conditions' => array('Milestone.uniq_id' => $mileuniqid, 'Milestone.company_id' => SES_COMP)));
			$projCond = ' AND `Project`.`id`='.$milearr['Milestone']['project_id'];
			$this->set('milearr', $milearr);
			$this->set('edit', 'edit');
            if (!empty($api_flag) && $api_flag == 3) {
                $edit_data['Milestone'] = $milearr['Milestone'];
            }
	    }
            $this->set('mlstfrom',isset($this->data['mlstfrom'])?$this->data['mlstfrom']:'');
	    $this->set('mileuniqid', $mileuniqid);
		
            $prjAllArr = $this->ProjectUser->query("SELECT Project.name,Project.id,Project.uniq_id FROM  `project_users` AS ProjectUser inner JOIN  `projects` AS `Project`  ON (`ProjectUser`.`user_id` = '" . SES_ID . "' AND `ProjectUser`.`company_id` = '" . SES_COMP . "' AND Project.isactive=1 AND `ProjectUser`.`project_id` = `Project`.`id` ".$projCond.")");
        if ($mileuniqid == 'default') {
            $edit_data['Milestone']['title'] = 'Default Task Group';
        }
        if (!empty($api_flag) && $api_flag == 3) {
            $edit_data+=$prjAllArr;
            return $edit_data;
        }
        if (!empty($api_flag) && $api_flag == 1) {
            return $prjAllArr;
        }
	    $this->set('projArr', $prjAllArr);
            $this->set('projUid',$this->data['projUid']);
	}
     function inline_edit_milestone($title = '', $mid = '',$pid = ''){
        $this->layout = 'ajax';        
        $jsonResponse = array();
        if($title != '' && $mid != ''){
            $this->request->data['title'] = $title;
            $this->request->data['mid'] = $mid;
        }
        if($pid != '' ){
            $this->request->data['project_id'] = $pid;
        }
        if(trim($this->request->data['title']) != '' && trim($this->request->data['mid']) != ''){
            if(trim($this->request->data['mid']) == 'default'){                
                $resp = $this->ajax_new_milestone('',$this->request->data);
                if($resp['error']){
                    $jsonResponse['status']= 'error';
                    $jsonResponse['msg'] = $resp['msg'];
                }else{
                    $jsonResponse['status']= 'success';
                    $jsonResponse['msg'] = __('Task Group updated successfully.',true);
                }
            }else{
                $pcond = "" ;
                if(isset($this->request->data['project_id']) && !empty($this->request->data['project_id'])){
                    $this->loadModel('Projects');
                    $pid = $this->Projects->find('first',array('conditions'=>array('Projects.uniq_id'=>trim($this->request->data['project_id'])),'fields'=>array('Projects.id')));
                    $pcond = " AND Milestone.project_id = '" . $pid['Projects']['id'] . "'";
                }
                $checkDuplicate = $this->Milestone->query("SELECT Milestone.id FROM milestones AS Milestone WHERE Milestone.title='" . addslashes(trim($this->request->data['title'])) . "' AND Milestone.id != '" . trim($this->request->data['mid']) . "' $pcond");
                if (isset($checkDuplicate[0]['Milestone']['id']) && $checkDuplicate[0]['Milestone']['id']) {
                        $jsonResponse['status']= 'error';
                        $jsonResponse['msg'] = __('Oops! Task Group Title already exists',true);
                } else {
                        $this->request->data['Milestone']['title'] = trim($this->request->data['title']);
                        $this->request->data['Milestone']['id'] = trim($this->request->data['mid']);
                        unset($this->request->data['mid']);
                        unset($this->request->data['title']);
                        if ($this->Milestone->save($this->request->data)) {
                                $jsonResponse['status']= 'success';
                                $jsonResponse['msg'] = __('Task Group updated successfully.',true);
                        } else {
                                $jsonResponse['status']= 'error';
                                $arr['msg'] = __('Sorry! We are not able to update this Task Group. Try again.',true);
                        }
                }
            }
        }else{
            $jsonResponse['status']= 'error';
            $jsonResponse['msg'] = __('Sorry! We are not able to update this Task Group. Try again.',true);
        }
        if($title != '' && $mid != ''){
            return $jsonResponse;
        }else{
            echo json_encode($jsonResponse);exit;
        }
     }
    function milestone_restore($uniqid = '', $page = NULL, $api_flag = '') {
        if (!empty($api_flag) && $api_flag == 1) {
            $this->request->data = $uniqid;
            unset($uniqid);
        }
        $uniqid = $uniqid ? $uniqid : $this->request->data['uniqid'];
		if ($uniqid) { 
			$this->loadModel('Milestone');
			$qrr = $this->Milestone->query("UPDATE milestones SET isactive = '1',modified='".GMT_DATETIME."' WHERE milestones.uniq_id ='".$uniqid."'");
			$arr['success']= 1;
			$arr['msg'] = __('Task Group has been restored.',true);
			//$this->Session->write('SUCCESS',"Milestone has been restored.");
		} else {
			$arr['error']= 1;
			$arr['msg'] = __('Oops! Error occured in restoration of Task Group',true);
			//$this->Session->write('ERROR','Oops! Error occured in restoration of milestone');
		}
        if (!empty($api_flag) && $api_flag == 1) {
            return $arr;
        } else {
            echo json_encode($arr);
            exit;
        }
		//$this->redirect(HTTP_ROOT."milestone");exit;
     }	
    function milestone_archive($uniqid = '', $page = NULL, $api_flag = '') {
        if (!empty($api_flag) && $api_flag == 1) {
            $this->request->data = $uniqid;
            unset($uniqid);
        }
        $uniqid = $uniqid ? $uniqid : $this->request->data['uniqid'];
		if ($uniqid) {
			$this->loadModel('Milestone');
			$this->Milestone->query("UPDATE milestones SET isactive=0,modified='".GMT_DATETIME."' where uniq_id='" . $uniqid . "'");
			//$this->Session->write('SUCCESS',"Milestone has been completed.");
			$arr['success']= 1;
			$arr['msg'] = __('Task Group has been completed.',true);
		} else {
			$arr['error']= 1;
			$arr['msg'] = __('Oops! Error occured in completion of Task Group',true);
			//$this->Session->write('ERROR','Oops! Error occured in completion of milestone');
		}
        if (!empty($api_flag) && $api_flag == 1) {
            return $arr;
        } else {
            echo json_encode($arr);
            exit;
        }
		//$this->redirect($_SERVER['HTTP_REFERER']);exit;
	}
     
/**
 * @method public manage_milestone() Manage milestone listing
 * @author GDR
 * @return json 
 */
	function manage_milestone(){
                $milestone_search=$this->data['file_srch'];
                $milestone_search="AND (Milestone.title LIKE '%$milestone_search%' OR Milestone.description LIKE '%$milestone_search%')";
		$page_limit = MILESTONE_PAGE_LIMIT;
		$page = (isset($this->data['page']) && $this->data['page'])? $this->data['page']:1;
		$limit1 = $page*$page_limit-$page_limit;
		$limit2 = $page_limit;
		$mlsttype = (isset($this->data['mlsttype']))?$this->data['mlsttype']:1;
		$cond = "Milestone.isactive='".$mlsttype."'";
		$projUniq = $this->data['projFil']; // Project Uniq ID
		$projIsChange = $this->data['projIsChange']; // Project Uniq ID
		$this->loadModel('ProjectUser');
		if($projUniq!='' && $projUniq !='all'){
			$allpj = $_GET['pj'];
			$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
			$projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq,'ProjectUser.user_id'=>SES_ID,'Project.isactive'=>1,'ProjectUser.company_id' => SES_COMP),'fields' => array('Project.id','Project.short_name','ProjectUser.id','Project.name')));
			if(count($projArr)){
				$projectId = $projArr['Project']['id'];
				//Updating ProjectUser table to current date-time
				if($projIsChange != $projUniq) {
					$ProjectUser['id'] = $projArr['ProjectUser']['id'];
					$ProjectUser['dt_visited'] = GMT_DATETIME;
					$this->ProjectUser->save($ProjectUser);
					$projName=$projArr['Project']['name'];
				}
			}
		}
		
		$mlstArr = array();
		if (trim($projUniq) != '') {
		    $this->loadModel('Milestone');
		    $sql = "SELECT SQL_CALC_FOUND_ROWS `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`created`,`Milestone`.`modified`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`,GROUP_CONCAT(e.legend) AS `legend`,User.name FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id LEFT JOIN easycases AS e ON (c.easycase_id = e.id) LEFT JOIN users User ON Milestone.user_id=User.id WHERE ".$cond." AND `Milestone`.`company_id` = ".SES_COMP;
		    if($projUniq && ($projUniq != "all")) {
			    $sql .= " AND `Milestone`.`project_id` =".$projectId." AND ".$cond." AND `Milestone`.`company_id` = ".SES_COMP."  GROUP BY Milestone.id ORDER BY `Milestone`.`modified` DESC LIMIT $limit1,$limit2";
		    } else {
			    $allcond = array('conditions'=>array('ProjectUser.user_id' => SES_ID,'ProjectUser.company_id' => SES_COMP,'Project.isactive' => 1), 'fields' => array('DISTINCT  Project.id'),'order'=>array('ProjectUser.dt_visited DESC'));
			    $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
			    $allProjArr = $this->ProjectUser->find('all', $allcond);
			    $ids = array();
			    foreach($allProjArr as $csid){
			    array_push($ids,$csid['Project']['id']);
			    }
			    $all_ids = implode(',',$ids);
			    $sql .= " AND `Milestone`.`project_id` IN (".$all_ids.") AND ".$cond." AND `Milestone`.`company_id` = ".SES_COMP." GROUP BY Milestone.id ORDER BY `Milestone`.`modified` DESC LIMIT $limit1,$limit2";
		    }
		    $milestones = $this->Milestone->query($sql);
		    $tot = $this->Milestone->query("SELECT FOUND_ROWS() as total");

		    //Finding number of closed case.
		    $view = new View($this);
		    $tz = $view->loadHelper('Tmzone');
		    $dt = $view->loadHelper('Datetime');
		    $frmt = $view->loadHelper('Format');
		    foreach($milestones as $key => $milestone) {
			    if($milestone['0']['legend']) {
				    $legends = explode(",",$milestone['0']['legend']);
				    //if(in_array(3,$legends)) {
					    $close_cnt = 0;$resolve_cnt=0;
					    foreach($legends as $value) {
						    if($value == 3) {
							    $close_cnt = $close_cnt+1;
						    }else if($value == 5) {
							    $resolve_cnt = $resolve_cnt+1;
						    }
					    }
					    $milestones[$key]['0']['closed'] = $close_cnt;
					    $milestones[$key]['0']['resolved'] = $resolve_cnt;
				    //} else {
				    //	$milestones[$key]['0']['closed'] = 0;
				    //}
			    } else {
				    $milestones[$key]['0']['closed'] = 0;
				    $milestones[$key]['0']['resolved'] = 0;
			    }
			    $date = $milestone['Milestone']['created'];
			    if($milestone['Milestone']['modified']) {
				    $date = $milestone['Milestone']['modified'];
			    }
			    $curCreated = $tz->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,GMT_DATETIME,"date");
			    $updated = $tz->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$date,"date");
			    $locDT = $dt->dateFormatOutputdateTime_day($updated, $curCreated,'',1);
			    $crted = $tz->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$milestone['Milestone']['created'],"date");
			    $crt_dt = $dt->dateFormatOutputdateTime_day($crted, $curCreated,'',1);
			    $milestones[$key]['Milestone']['locDT'] = $locDT;
			    $milestones[$key]['Milestone']['closed'] = $milestones[$key]['0']['closed'];
			    $milestones[$key]['Milestone']['resolved'] = $milestones[$key]['0']['resolved'];
			    $milestones[$key]['Milestone']['totalcases'] = $milestones[$key]['0']['totalcases'];
			    //$milestones[$key]['Milestone']['hrSpent'] = $milestones[$key]['0']['hours_spent'];
			    $milestones[$key]['Milestone']['crtUser'] = '<i>Created by:</i> '.$frmt->splitwithspace($milestones[$key]['User']['name']).' on '.$crt_dt;
		    }
		    //echo "<pre>";print_r($milestones);exit;
		    $pgShLbl = $frmt->pagingShowRecords($tot[0][0]['total'],$page_limit,$page);
		}
		
		$mlstArr['pgShLbl'] = (isset($pgShLbl)) ? $pgShLbl : '';
		$mlstArr['milestoneAll'] = (isset($milestones)) ? $milestones : '';
		$mlstArr['caseCount'] = (isset($tot[0][0]['total'])) ? $tot[0][0]['total'] : 0;
		$mlstArr['csPage'] = (isset($page)) ? $page : '';
		$mlstArr['page_limit'] = (isset($page_limit)) ? $page_limit : '';
		$mlstArr['mlsttype'] = (isset($mlsttype)) ? $mlsttype : '';
		$mlstArr['projName'] = (isset($projName)) ? $projName : '';
		$mlstArr['projUniq'] = (isset($projUniq)) ? $projUniq : '';
		$this->set('resMilestone', json_encode($mlstArr));
		//$this->set("milestones",$milestones);
		//$this->set('caseCount',$tot[0][0]['total']);
		//$this->set('page_limit',$page_limit);
		//$this->set('casePage',$page);
		//$this->set('pageprev',$pageprev);
		//$this->set('type',$type);
		//$this->set('projId',$allpj);
		//$this->set('projName',$projName);
	}
	
     function milestone($type = NULL){
		$page_limit = 5;
		$page = 1;
		$pageprev=1;
		if(isset($_GET['page']) && $_GET['page']){
			$page = $_GET['page'];
		}
		if(isset($this->data['page']) && $this->data['page']){
			$page = $this->data['page'];
		}
		$limit1 = $page*$page_limit-$page_limit;
		$limit2 = $page_limit;

		$cond = "Milestone.isactive='1'";
		if($type == "completed" || (isset($this->data['mlsttype']) && $this->data['mlsttype']==0)) {
			$cond = "Milestone.isactive='0'";
		}

		$is_ajax = 0;
		$this->loadModel('ProjectUser');
		if($_GET['pj'] && $_GET['pj'] !='all'){
			$allpj = $_GET['pj'];
			$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
			$projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $allpj,'ProjectUser.user_id'=>SES_ID,'Project.isactive'=>1,'ProjectUser.company_id' => SES_COMP),'fields' => array('Project.id','Project.short_name','ProjectUser.id')));
			if(count($projArr)){
				$projectId = $projArr['Project']['id'];
				//Updating ProjectUser table to current date-time
				if($projIsChange != $projUniq) {
					$ProjectUser['id'] = $projArr['ProjectUser']['id'];
					$ProjectUser['dt_visited'] = GMT_DATETIME;
					$this->ProjectUser->save($ProjectUser);
				}
			}
		}else if($_GET['pj'] && $_GET['pj']=='all'){
			$allpj = 'all';
		}
		if(isset($this->params->data['project_id'])) {
			$is_ajax = 1;
			$this->layout = "ajax";
			if($this->params->data['project_id'] !== 'all') {
				$allpj = $projectId = $this->params->data['project_id'];
				$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
				$projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.id' => $allpj,'ProjectUser.user_id'=>SES_ID,'Project.isactive'=>1,'ProjectUser.company_id' => SES_COMP),'fields' => array('Project.id','Project.short_name','Project.name','ProjectUser.id')));
				if(count($projArr)){
					//Updating ProjectUser table to current date-time
					$ProjectUser['id'] = $projArr['ProjectUser']['id'];
					$ProjectUser['dt_visited'] = GMT_DATETIME;
					$this->ProjectUser->save($ProjectUser);
					$projName=$projArr['Project']['name'];
				}
			} else {
				$allpj = "all";$projName='All';
			}
		}else if($_COOKIE['ALL_PROJECT'] =='all'){
			$allpj = $_COOKIE['ALL_PROJECT'];
			$projName = 'All';
		} else {
			$allpj = $projectId = $GLOBALS['getallproj'][0]['Project']['id'];
			//$allpj = $GLOBALS['getallproj'][0]['Project']['uniq_id'];
			$projName = $GLOBALS['getallproj'][0]['Project']['name'];
//			$getallproj = $this->ProjectUser->query("SELECT DISTINCT Project.id,Project.uniq_id,Project.name FROM project_users AS ProjectUser,projects AS Project WHERE Project.id= ProjectUser.project_id AND ProjectUser.user_id=".SES_ID." AND Project.isactive='1' AND Project.company_id='".SES_COMP."' ORDER BY ProjectUser.dt_visited DESC LIMIT 1");
//			if(count($getallproj) == 1){
//				$allpj = $getallproj[0]['Project']['uniq_id'];
//				$projectId = $getallproj[0]['Project']['id'];
//			} else {
//				$allpj = "all";
//			}
		}

		$this->loadModel('Milestone');
		$sql = "SELECT SQL_CALC_FOUND_ROWS `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`created`,`Milestone`.`modified`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`,GROUP_CONCAT(e.legend) AS `legend` FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id LEFT JOIN easycases AS e ON (c.easycase_id = e.id) WHERE ".$cond." AND `Milestone`.`company_id` = ".SES_COMP;
		if($allpj != "all") {
			$sql .= " AND `Milestone`.`project_id` =".$projectId." AND ".$cond." AND `Milestone`.`company_id` = ".SES_COMP."  GROUP BY Milestone.id ORDER BY `Milestone`.`modified` DESC LIMIT $limit1,$limit2";
		} else {
			$allcond = array('conditions'=>array('ProjectUser.user_id' => SES_ID,'ProjectUser.company_id' => SES_COMP,'Project.isactive' => 1), 'fields' => array('DISTINCT  Project.id'),'order'=>array('ProjectUser.dt_visited DESC'));
			$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
			$allProjArr = $this->ProjectUser->find('all', $allcond);
			$ids = array();
			foreach($allProjArr as $csid){
			array_push($ids,$csid['Project']['id']);
			}
			$all_ids = implode(',',$ids);
			$sql .= " AND `Milestone`.`project_id` IN (".$all_ids.") AND ".$cond." AND `Milestone`.`company_id` = ".SES_COMP." GROUP BY Milestone.id ORDER BY `Milestone`.`modified` DESC LIMIT $limit1,$limit2";
		}

		$milestones = $this->Milestone->query($sql);
		$tot = $this->Milestone->query("SELECT FOUND_ROWS() as total");

		//Finding number of closed case.
		foreach($milestones as $key => $milestone) {
			if($milestone['0']['legend']) {
			$legends = explode(",",$milestone['0']['legend']);
			if(in_array(3,$legends)) {
				$cnt = 0;
				foreach($legends as $value) {
				if($value == 3) {
					$cnt = $cnt+1;
				}
				}
				$milestones[$key]['0']['closed'] = $cnt;
			} else {
				$milestones[$key]['0']['closed'] = 0;
			}
			} else {
			$milestones[$key]['0']['closed'] = 0;
			}
		}
		$this->set("milestones",$milestones);
		$this->set('caseCount',$tot[0][0]['total']);
		$this->set('page_limit',$page_limit);
		$this->set('casePage',$page);
		$this->set('pageprev',$pageprev);
		$this->set('type',$type);
		$this->set('projId',$allpj);
		$this->set('projName',$projName);

		if($is_ajax){
			$this->render('listing');
		}
	//print '<pre>';print_r($milestones);exit;
    }
/**
 * @method public milestonelist() Kanban view of Milestone 
 * @author GDR <abc@mydomain.com>
 * @return json 
 */
	function milestonelist(){}
	
	function ajax_milestonelist(){
		$this->loadModel('Easycase');
		$view = new View($this);
		$tz = $view->loadHelper('Tmzone');
		$dt = $view->loadHelper('Datetime');
		$cq = $view->loadHelper('Casequery');
		$frmt = $view->loadHelper('Format');
		$milestone_search=$this->params->data['file_srch'];
		$caseMenuFilters = $this->data['caseMenuFilters'];
		if($caseMenuFilters) {
			setcookie('CURRENT_FILTER',$caseMenuFilters,COOKIE_REM,'/',DOMAIN_COOKIE,false,false);
		}else {
			setcookie('CURRENT_FILTER',$caseMenuFilters,COOKIE_REM,'/',DOMAIN_COOKIE,false,false);
		}
		$data = $this->Easycase->ajax_milestonelist($this->data,$frmt, $dt, $tz, $cq,$milestone_search, $this->Format);
		$data['task_parent_ids'] = array();
		 $ErestrictedQuery =$restrictedQuery = "";
        if(!$this->Format->isAllowed('View All Task',$roleAccess)){
             $ErestrictedQuery = " AND (E.assign_to=" . SES_ID . " OR E.user_id=".SES_ID.")";
             $restrictedQuery = " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }
    //related tasks
    $data['related_tasks'] = '';
	$data['related_tasks_tg'] = array();
	$data['related_tasks_dflt'] = array();
    /*if(!empty($data['caseAll']) || !empty($data['caseAllDefault'])){
        $parent_task_id_tg = array_filter(Hash::combine($data, 'caseAll.{n}.Easycase.id', 'caseAll.{n}.Easycase.parent_task_id'));
        $parent_task_id_dflt = array_filter(Hash::combine($data, 'caseAllDefault.{n}.Easycase.id', 'caseAllDefault.{n}.Easycase.parent_task_id'));
		$parent_task_id = $parent_task_id_dflt;
		//pr($parent_task_id);
		//exit;
        if(!empty($parent_task_id_tg)){
            $related_tasks_tg = !empty($parent_task_id_tg) ? $this->Easycase->getSubTasks($parent_task_id_tg) : array();
            $data['related_tasks_tg'] = $related_tasks_tg;
        }
		if(!empty($parent_task_id_dflt)){
            $related_tasks_dflt = !empty($parent_task_id_dflt) ? $this->Easycase->getSubTasks($parent_task_id_dflt) : array();
            $data['related_tasks_dflt'] = $related_tasks_dflt;
        }
    }*/
                $clt_sql = "";
                if ($this->Auth->user('is_client') == 1) {
                    $clt_sql = " AND ((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ") ";
                }
		if($this->data['projFil'] == 'all'){
			$milestoCountts = $this->Milestone->query('SELECT M.isactive,count(M.isactive) as cnt FROM milestones AS M LEFT JOIN easycase_milestones AS EM ON EM.milestone_id = M.id LEFT JOIN easycases as E ON E.id = EM.easycase_id WHERE M.company_id ='.SES_COMP.' AND E.istype = 1 AND E.isactive = 1'.$ErestrictedQuery.'  GROUP BY isactive ORDER BY isactive DESC');
			$cntdefaulttaskgroup = $this->Easycase->query("SELECT COUNT(*) AS count FROM easycases AS Easycase LEFT JOIN  easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id= Easycase.id WHERE `Easycase`.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') AND `Easycase`.`istype` = 1 AND `Easycase`.`isactive` = 1 AND EasycaseMilestone.id IS NULL $clt_sql $restrictedQuery");
		}else{
			$milestoCountts = $this->Milestone->query('SELECT M.isactive,count(M.isactive) as cnt FROM milestones AS M LEFT JOIN easycase_milestones AS EM ON EM.milestone_id = M.id LEFT JOIN easycases as E ON E.id = EM.easycase_id WHERE M.company_id ='.SES_COMP.' AND M.project_id = (SELECT id FROM projects WHERE uniq_id="'.$this->data['projFil'].'") AND E.istype = 1 AND E.isactive = 1'.$ErestrictedQuery.' GROUP BY isactive ORDER BY isactive DESC');
			$cntdefaulttaskgroup = $this->Easycase->query("SELECT COUNT(*) AS count FROM easycases AS Easycase LEFT JOIN  easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id= Easycase.id WHERE `Easycase`.project_id = (SELECT id FROM projects WHERE uniq_id='".$this->data['projFil']."') AND `Easycase`.`istype` = 1 AND `Easycase`.`isactive` = 1 AND EasycaseMilestone.id IS NULL $clt_sql $restrictedQuery");
		}
		$act_mil  = 0; 
		$inact_mil  = 0;
		if($milestoCountts){
			if(count($milestoCountts) == 2){
				$act_mil = $milestoCountts[0][0]['cnt'];
				$inact_mil = $milestoCountts[1][0]['cnt'];
			}else{
				if($milestoCountts[0]['milestones']['isactive'] == 1){
					$act_mil = $milestoCountts[0][0]['cnt'];
				}else{
					$inact_mil = $milestoCountts[0][0]['cnt'];
				}
			}			
		}
                if($cntdefaulttaskgroup[0][0]['count'] > 0){
		$data['actmil'] = $act_mil+1;
                }
		$data['inactmil'] = $inact_mil;
		$this->set('resCaseProj',  json_encode($data));
//		echo json_encode($data);exit;
	}
	function milestone_list(){
		$this->layout='ajax';
		$projuid = $this->data['project_id'];
		$prj_cls = ClassRegistry::init('Project');
		$prj_cls->recursive = -1;
		$project_dtls = $prj_cls->find('first',array('conditions'=>array('Project.uniq_id'=>$projuid),'fields'=>'Project.id'));
		$milestones = $this->Milestone->find('list',array('conditions'=>array('project_id'=>$project_dtls['Project']['id'],'isactive'=>1),'order'=>'end_date DESC'));
		if($milestones){
			echo json_encode($milestones);exit;
		}else{
			echo 0;exit;
		}
	}
	public function ajax_check_parent(){
		$this->layout='ajax';
		$this->loadModel('Easycase');
		$jsonRes = array('status'=>'success','data'=>array());
		if($this->data['idstr']){
			$id_org = base64_decode($this->data['idstr']);
			$easyRes = $this->Easycase->find('first', array('conditions'=>array('Easycase.id'=>$id_org,'Easycase.istype'=>1),'fields'=>array('Easycase.project_id','Easycase.parent_task_id')));
			if($easyRes){
				$jsonRes['parentTsk'] = $easyRes['Easycase']['parent_task_id'];
				$childs = $this->Easycase->getSubTaskChild($id_org, $easyRes['Easycase']['project_id']);
				if($childs['child']){
					$jsonRes['data'] = $childs['child'];
				}
			}
		}
		echo json_encode($jsonRes);exit;
	}
	function moveTaskMilestone(){
		$this->layout='ajax';
                $this->loadModel("Project");
		$taskid = $this->data['taskid'];
		$mlstid = $this->data['mlstid'];
		$task_no = $this->data['task_no'];
		$project_id = $this->data['project_id'];
		$show_backlog  = 0;
                $this->Project->recursive = -1;
                $projdetails = $this->Project->findById($project_id);
              //  echo "<pre>";print_r($projdetails);exit;
		$type = 'single';
		if(isset($this->data['type']) && !empty($this->data['type'])){
			$type = $this->data['type'];
		}
			$emcls = ClassRegistry::init('EasycaseMilestone');
		if(!$mlstid &&  $type != 'all'){
			$mlstdetails = $emcls->find('first',array('conditions'=>array('easycase_id'=>$taskid,'project_id'=>$project_id)));
			if($mlstdetails){
				$mlstid = $mlstdetails['EasycaseMilestone']['milestone_id'];
			}
		}else{
			$mlstdetails = $emcls->find('list',array('conditions'=>array('easycase_id'=>$taskid,'project_id'=>$project_id),'fields'=>array('easycase_id','milestone_id')));
			
			if(count($taskid) == count($mlstdetails)){
				$show_backlog  = 1;
			}
			if($mlstdetails){
				$mlstdetails = array_values(array_unique($mlstdetails));
			}
		}
		if(is_array($taskid) && $type = 'all'){
			//for sprint and multiple move
			$cond_mil = array('project_id'=>$project_id,'isactive'=>1);
			if($mlstdetails){
				$cond_mil = array('project_id'=>$project_id,'isactive'=>1, 'id NOT IN'=>$mlstdetails);
			}
			$milestones = $this->Milestone->find('all',array('conditions'=>$cond_mil,'order'=>'end_date DESC'));
			if($show_backlog){				
				$milestones[count($milestones)]['Milestone'] = array(
				'id'=>0, 'title'=>'Default Task Group / Backlog', 'start_date'=>'','end_date'=>'','is_started'=>0, 'duration'=>0, 'user_id'=>0, 'project_id'=>0, 'company_id'=>0,'isactive'=>1);				
			}
			if(count($taskid) > 1){
				$mlstid ='';
		}
		
		}else{
		$milestones = $this->Milestone->find('all',array('conditions'=>array('project_id'=>$project_id),'order'=>'end_date DESC'));
		}		
		$this->set('milestones',$milestones);
		if(is_array($taskid) && $task_no == 'all' && count($taskid) == 1){
			$vl_tt = explode('|',$taskid[0]);
			$task_no = $vl_tt[1]; 
		}
		if(is_array($taskid)){
			$taskid_t = '';
			foreach($taskid as $kl => $vl){
				$vl_t = explode('|',$vl);
				$taskid_t .= ','.$vl_t[0]; 
			}
			$taskid = trim($taskid_t,',');
		}
		$this->set('mlst_id',$taskid);
		if($type = 'all'){
			$this->set('show_backlog',$show_backlog);
		}
		$this->set('project_id',$project_id);
		$this->set('mlstid',$mlstid);
		$this->set('task_no',$task_no);
	}
	function removeTaskMilestone(){
		$this->layout='ajax';
		$taskid = $this->data['taskid'];
		$mlstid = $this->data['mlstid'];
		$project_id = $this->data['project_id'];
		$this->loadModel('EasycaseMilestone');
                $this->EasycaseMilestone->deleteAll(array('easycase_id'=>$taskid));
                echo 'success';
                exit;
	}
	function switchTaskToMilestone(){
		$this->layout='ajax';
		$this->loadModel('User');
		$this->loadModel('Project');  
		$this->loadModel('Easycase');
		$old_mlst_id = $this->data['ext_mlst_id'];
		$project_id = $this->data['project_id'];
		$taskid = $this->data['taskid'];
		$is_multiple = 0;
		$taskid_arra = array();
		if(stristr($taskid, ',')){
			$is_multiple = 1;
			$taskid_arra = explode(',',$taskid);
		}else{
			$taskid_arra = array($taskid);
		}
		$curr_mlst_id = $this->data['curr_mlst_id'];
		$mode = $this->data['mode'];		
		$main_chk_arr = array();
		$main_chk_arr_parent = array();
		
		foreach($taskid_arra as $ka => $va){
		
			$moving_task = $va;	
			$taskid = (!$taskid)?$taskid:$va;
		if($taskid == 0){
			$task_uniq_id = $this->data['taskuid'];
			$data = $this->Easycase->find('first', array('conditions'=>array('Easycase.uniq_id'=>$task_uniq_id, 'Easycase.project_id'=>$project_id,'Easycase.istype'=>1)));
			$taskid = $data['Easycase']['id'];	
			$moving_task = $taskid;
			$parent_task_id = $data['Easycase']['parent_task_id'];
				//array_push($main_chk_arr_parent,$parent_task_id);
				if($parent_task_id){
					$main_chk_arr_parent[$taskid] = $parent_task_id;
				}
		} else {
			$data = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $taskid, 'Easycase.project_id' => $project_id)));
			$parent_task_id = $data['Easycase']['parent_task_id'];
				if($parent_task_id){
					//array_push($main_chk_arr_parent,$parent_task_id);
					$main_chk_arr_parent[$taskid] = $parent_task_id;
		}
			}
		//fetch children tasks to update milestone id
		$childTasks = $this->Easycase->getSubTaskChild($taskid, $project_id);
		if (!empty($childTasks['child'])) {
			$taskid = array_merge(array($taskid), $childTasks['child']);
		}
		$case_milestone_id = array();
		$exist_data = $this->EasycaseMilestone->find('all', array('conditions' => array('project_id' => $project_id, 'easycase_id' => $taskid)));
		if (!empty($exist_data)) {
			$case_milestone_id = Hash::combine($exist_data, "{n}.EasycaseMilestone.easycase_id", "{n}.EasycaseMilestone.id");
		}
			//not considered for all move
			if(isset($old_mlst_id) && !empty($old_mlst_id)){
			$this->EasycaseMilestone->deleteAll(array('project_id'=>$project_id,'milestone_id'=>$old_mlst_id,'easycase_id'=>$taskid));
		}
			if($curr_mlst_id != 0){
		$mid_ord = $this->EasycaseMilestone->find('first',array('conditions'=>array('EasycaseMilestone.milestone_id'=>$curr_mlst_id),'fields'=>array('EasycaseMilestone.m_order')));
		//$only_task = 0;
		if (is_array($taskid) && !empty($taskid)) {
			$arr = array();
			foreach ($taskid as $task_id) {
				$arr[] = array(
					'id' => !empty($case_milestone_id[$task_id]) ? $case_milestone_id[$task_id] : '',
					'milestone_id' => $curr_mlst_id,
					'easycase_id' => $task_id,
					'project_id' => $project_id,
					'm_order' => (isset($mid_ord['EasycaseMilestone']['m_order']))?$mid_ord['EasycaseMilestone']['m_order']:0,
					'user_id' => SES_ID,
					'dt_created' => GMT_DATETIME,
				);
					if(!in_array($task_id, $main_chk_arr)){
						array_push($main_chk_arr,$task_id);
					}
			}
		} else {
			$arr = array(
				'id' => !empty($case_milestone_id[$taskid]) ? $case_milestone_id[$taskid] : '',
				'milestone_id' => $curr_mlst_id,
				'easycase_id' => $taskid,
				'project_id' => $project_id,
				'm_order' => (isset($mid_ord['EasycaseMilestone']['m_order']))?$mid_ord['EasycaseMilestone']['m_order']:0,
				'user_id' => SES_ID,
				'dt_created' => GMT_DATETIME,
			);
				array_push($main_chk_arr,$taskid);
			//$only_task = $taskid;
		}
			}
		$status = false;
		if($curr_mlst_id){
			$status = $this->EasycaseMilestone->saveAll($arr);
		}elseif($curr_mlst_id == 0){
				if($case_milestone_id){
					$main_chk_arr = $taskid;
					$case_milestone_id_t = array_values($case_milestone_id);
					$this->EasycaseMilestone->deleteAll(array('project_id'=>$project_id,'id'=>$case_milestone_id_t,'easycase_id'=>$taskid));
				}				
			$status = true;
		}
			//parent id check was here
		}
		$main_chk_arr = array_unique($main_chk_arr);
		//remove the parent task id if only chind moving to milestone
		//if($status && !empty($parent_task_id) && $moving_task){
		if(!empty($main_chk_arr_parent)){
			foreach($main_chk_arr_parent as $kp => $vp){
				if(!in_array($vp, $main_chk_arr)){
					if(!$this->EasycaseMilestone->checkParentInMilestone($vp, $project_id, $curr_mlst_id)){
						$this->Easycase->updateAll(array('Easycase.parent_task_id' => NULL), array('Easycase.id' => $kp, 'Easycase.project_id' => $project_id));
					}
				}
			}
		}		
		if($status){
			$final_arr = array('status' => 'success');
			if(!$is_multiple){			
			}
		}else{
			$final_arr = array('status' => 'error');
		}
		echo json_encode($final_arr);
		exit;
	}
	function saveMilestoneTitle(){
	     $this->layout='ajax';
             $this->request->data['mid'] = ($this->request->data['mid'] ==0)?'default':$this->request->data['mid'];
	     if($this->request->data['mid'] && $this->request->data['mid'] != 'default'){
		$milearr = $this->Milestone->find('first', array('conditions' => array('Milestone.id' =>$this->request->data['mid'])));
		if($milearr){
		    $milearr['Milestone']['title'] = trim($this->request->data['title']);		    
		}
		$res = $this->inline_edit_milestone($milearr['Milestone']['title'],$milearr['Milestone']['id'],$milearr['Milestone']['project_id']);
		//$this->Milestone->save($milearr);
	     }else if($this->request->data['mid'] == 'default' && $this->request->data['project_id'] != 'all'){
                 $res = $this->inline_edit_milestone($this->request->data['title'],$this->request->data['id'],$this->request->data['project_id']);
	     }
	     echo json_encode($res);exit;
	}
    function checkParentForMilestone($taskid, $project_id, $type, $k, $milestone_id=0, $mseq=0, $ids){	
		$this->loadModel('EasycaseMilestone');        
	    $this->loadModel('Easycase');
		$data_chk = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $taskid, 'Easycase.project_id' => $project_id),'field'=>array('Easycase.parent_task_id')));
		$parent_task_id = $data_chk['Easycase']['parent_task_id'];
		//remove the parent task id if only chind moving to milestone
        if(!empty($parent_task_id)){
			if(!in_array($parent_task_id, $ids)){ //for multiple move
				if(!$this->EasycaseMilestone->checkParentInMilestone($parent_task_id, $project_id, $milestone_id)){
					$this->Easycase->updateAll(array('Easycase.parent_task_id' => NULL), array('Easycase.id' => $taskid, 'Easycase.project_id' => $project_id));
                }
            }
        }
		//fetch children tasks to update milestone id
		$childTasks_t = $this->Easycase->getSubTaskChild($taskid, $project_id);
		if (!empty($childTasks_t['child'])) {
			$cid_t = $childTasks_t['child'];
			if($type == 0){ //in default and moving to milestone
				foreach($cid_t as $ink => $inv){
					$this->EasycaseMilestone->saveAll(array('EasycaseMilestone'=>array('id_seq' => $k,'milestone_id'=>$milestone_id,'easycase_id'=>$inv, 'project_id'=>$project_id,'m_order'=>$mseq, 'user_id'=>SES_ID))); 
				}
			} else if($type == 1){ //in milestone and moving to milestone
				$this->EasycaseMilestone->updateAll(array('id_seq' => $k,'milestone_id'=>$milestone_id,'m_order'=>$mseq), array('easycase_id'=>$cid_t, 'project_id'=>$project_id));
			}else{ //in milestone and moving to default
				$cid_t = $childTasks_t['child'];
				$this->Easycase->updateAll(array('seq_id' => $k),array('id'=>$cid_t));  
				$this->EasycaseMilestone->deleteAll(array('easycase_id'=>$cid_t, 'project_id'=>$project_id), false);
			}
			return $childTasks_t['child'];
		}else{
			return array();
    }
	}
    function update_sequence_milestones(){
        #$this->loadModel('EasycaseMilestone');
        $project_id = $this->params->data['project_id'];
        $casePage=$this->params->data['casePage'];
        $cp=(($casePage-1)*TASK_GROUP_CASE_PAGE_LIMIT)+1 ;
        if(isset($this->params->data['mileIds'])){
            foreach($this->params->data['mileIds'] as $k=>$mid){
                $this->EasycaseMilestone->updateAll(array('m_order' => ($k+$cp)), array('milestone_id'=>$mid));//, 'project_id'=>$project_id
                $this->Milestone->updateAll(array('id_seq' => ($k+$cp)), array('id'=>$mid));
             }   
        }
		    echo "success";exit;
    } 
	function moveupdown_sprint(){
        #$this->loadModel('EasycaseMilestone');
        $project_uid = $this->params->data['projUid'];
		//$proj = $this->Project->getProjectFields(array("Project.uniq_id" => $this->data['project_id']), array("Project.id"));
        if(isset($this->params->data['mileuniqids'])){
            foreach($this->params->data['mileuniqids'] as $k=>$mid){
                $this->EasycaseMilestone->updateAll(array('m_order' => $k), array('milestone_id'=>$mid));//, 'project_id'=>$project_id
                $this->Milestone->updateAll(array('id_seq' => $k), array('id'=>$mid));
			}   
        }
		echo json_encode(array('status'=>'success'));
		exit;
    } 
    function get_task_milestone(){
		$this->layout='ajax';
		$this->loadModel('Easycase');
		$res = array('status'=>'failure', 'milestone_id'=>0,'message'=>'');
		if($this->data['task_id'] && $this->data['project_id']){
			$task_ids = explode('__',$this->data['task_id']);
			$rest_chk =1;
			if($task_ids[1]){
				$rest_chk = $this->Easycase->checkFourthParent($task_ids[1], $task_ids[0]);
				if(!$rest_chk){
					$res['message'] = __('This will create fourth level task, which is not allowed. Please choose another Parent.');
				}
			}
			$proj = $this->Project->getProjectFields(array("Project.uniq_id" => $this->data['project_id']), array("Project.id"));
			if($proj){
				$res_mils = $this->EasycaseMilestone->find('first', array('conditions' => array('EasycaseMilestone.easycase_id' => $task_ids[0],'EasycaseMilestone.project_id' => $proj['Project']['id']),'fields' => array('EasycaseMilestone.milestone_id')));
				if($res_mils){
					$res['milestone_id'] = $res_mils['EasycaseMilestone']['milestone_id'];
					$res['status'] = 'success';
				}else{
					$res['milestone_id'] = 0;
					$res['status'] = 'success';
				}
			}
		}
		echo json_encode($res);
		exit;
	} 
  function ajax_new_sprint() {
		$this->layout = 'ajax';
		$mileuniqid = 0;
		if (isset($this->data['mileuniqid']) && $this->data['mileuniqid']) {    
			$mileuniqid = $this->data['mileuniqid'];
		}
	    $this->loadModel('ProjectUser');
		$this->loadModel('Easycase');
	    $this->loadModel('Project');	
	    if (!empty($this->request->data['Milestone']) && $this->request->data['Milestone']['title'] && !$this->request->data['mileuniqid']) {
			$this->request->data['Milestone']['title'] = trim($this->request->data['Milestone']['title']);
			$chk = 1;
			if(trim($this->request->data['Milestone']['start_date']) != '' && trim($this->request->data['Milestone']['end_date']) != ''){
				$this->request->data['Milestone']['start_date'] = date('Y-m-d',strtotime($this->request->data['Milestone']['start_date']));
				$this->request->data['Milestone']['end_date'] = date('Y-m-d',strtotime($this->request->data['Milestone']['end_date']));
				if (strtotime($this->request->data['Milestone']['start_date']) > strtotime($this->request->data['Milestone']['end_date'])) {
					$chk = 0;
				}else{
					$this->request->data['Milestone']['is_started'] = 1;
				}
			}else{
				unset($this->request->data['Milestone']['start_date']);
				unset($this->request->data['Milestone']['end_date']);
			}
			if(trim($this->request->data['Milestone']['estimated_hours']) == ''){
				unset($this->request->data['Milestone']['estimated_hours']);
			}
			if (!$chk) {
				$arr['error']=1;
				$arr['msg'] = __('Start date cannot exceed End date');
				echo json_encode($arr);exit;
			} else {
				$proj = $this->Project->getProjectFields(array("Project.uniq_id" => $this->request->data['Milestone']['proj_id']), array("Project.id"));				
				if (!$proj) {
					$arr['error']=1;
					$arr['msg'] = __('Invalid Project!');
					echo json_encode($arr);exit;
				}
				$this->request->data['Milestone']['project_id'] = $proj['Project']['id'];
				if ($this->request->data['Milestone']['id']) {
					$checkDuplicate = $this->Milestone->find('first', array('conditions' => array('Milestone.title' => addslashes($this->request->data['Milestone']['title']),'Milestone.project_id' =>$proj['Project']['id'],'Milestone.id !=' => $this->request->data['Milestone']['id']),'fields' => array('Milestone.id','Milestone.isactive')));
				} else {
					$mlUniqId = $this->Format->generateUniqNumber();
					$this->request->data['Milestone']['uniq_id'] = $mlUniqId;
					$this->request->data['Milestone']['company_id'] = SES_COMP;
					$checkDuplicate = $this->Milestone->find('first', array('conditions' => array('Milestone.title' => addslashes($this->request->data['Milestone']['title']),'Milestone.project_id' => $proj['Project']['id']),'fields' => array('Milestone.id','Milestone.isactive')));
					$arr['muid']= $mlUniqId;
				}
				if (isset($checkDuplicate['Milestone']['id']) && $checkDuplicate['Milestone']['id']) {
					$arr['error']=1;
					if($checkDuplicate['Milestone']['isactive']){
						$arr['msg'] = __('Oops! Sprint Title already exists.',true);
					}else{
						$arr['msg'] = __('Oops! Sprint title already exist for completed sprint.',true);
					}
				} else {
					if(isset($this->request->data['Milestone']['user_id']) && trim($this->request->data['Milestone']['user_id'])){
					}else{
						$this->request->data['Milestone']['user_id'] = SES_ID;
					}
					if(empty($this->request->data['Milestone']['id'])){
						$Highest_sq = $this->Milestone->find('first', array('conditions' => array('Milestone.project_id' => $proj['Project']['id']),'fields' => array('Milestone.id','Milestone.id_seq'),'order'=>array('Milestone.id_seq'=>'DESC')));					
						$this->request->data['Milestone']['id_seq'] = $Highest_sq['Milestone']['id_seq']+1;
					}else{
						$Highest_sq = $this->Milestone->find('first', array('conditions' => array('Milestone.project_id' => $proj['Project']['id'],'Milestone.id' =>$this->request->data['Milestone']['id']),'fields' => array('Milestone.id','Milestone.id_seq','Milestone.is_started'),'order'=>array('Milestone.id_seq'=>'DESC')));	
					}
					if(isset($this->request->data['Milestone']['is_started']) && $this->request->data['Milestone']['is_started'] && $Highest_sq['Milestone']['is_started']){
						$arr['error']=1;
						$arr['msg'] = __('Sorry! this sprint is already started.',true);
						echo json_encode($arr);exit;
					}					
					if ($this->Milestone->save($this->request->data)) {   
						$arr['milston_ttl'] = $this->request->data['Milestone']['title'];
						$milestone_id_now = ($this->request->data['Milestone']['id'])?$this->request->data['Milestone']['id']:$this->Milestone->getLastInsertId();
						$arr['success'] =1;
						$arr['milestone_id'] = $milestone_id_now;
						if(empty($this->request->data['Milestone']['id'])){
							/*$alldefaultCases = $this->Easycase->query("SELECT Easycase.id FROM easycases AS Easycase WHERE Easycase.id NOT IN(SELECT EasycaseMilestone.easycase_id FROM easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.project_id =".$this->request->data['Milestone']['project_id'].") AND Easycase.project_id =".$this->request->data['Milestone']['project_id']);
							if($alldefaultCases){
								$emarr = array();
								$this->loadModel('EasycaseMilestone');
								$id_seq_arr = $this->EasycaseMilestone->query('SELECT MAX(id_seq) as id_seq FROM easycase_milestones WHERE milestone_id = '.$milestone_id_now);
								$id_seq = '';
								if($id_seq_arr['0'][0]['id_seq']){
									$id_seq = $id_seq_arr['0'][0]['id_seq'];
								}
								foreach($alldefaultCases as $k => $v){
									if($v['Easycase']['id']) {
										$EasycaseMilestone['EasycaseMilestone']['easycase_id'] = $v['Easycase']['id'];
										$EasycaseMilestone['EasycaseMilestone']['milestone_id'] = $milestone_id_now;
										$EasycaseMilestone['EasycaseMilestone']['project_id'] = $this->request->data['Milestone']['project_id'];
										$EasycaseMilestone['EasycaseMilestone']['user_id'] = SES_ID;
										if($id_seq != ''){
											$EasycaseMilestone['EasycaseMilestone']['id_seq'] = (int)($id_seq+1);
											$id_seq = $EasycaseMilestone['EasycaseMilestone']['id_seq'];
										}else{
											$EasycaseMilestone['EasycaseMilestone']['id_seq'] = 1;
										}
										$this->EasycaseMilestone->saveAll($EasycaseMilestone);
									}
								}
							}*/
						}else{
							$this->loadModel("EasycaseMilestone");
							$this->loadModel("Easycase");
							$this->EasycaseMilestone->bindModel(array('belongsTo'=>array('Easycase')));
							$this->EasycaseMilestone->recursive = 2;

                     		$tgs = $this->EasycaseMilestone->find('all', array('conditions' => array('EasycaseMilestone.milestone_id' => $milestone_id_now,'Easycase.legend '=>array(3,5)),'group'=>array('EasycaseMilestone.easycase_id')));                     		
	                     	if(count($tgs) > 0 ){
	                            $this->loadModel('SprintCompleteReport');
		                        foreach($tgs as $k=>$v){
		                        	$cnts = $this->SprintCompleteReport->find('first',array('conditions'=>array('SprintCompleteReport.task_id'=>$v['Easycase']['id']),'fields'=>array('SprintCompleteReport.move_count'),'order'=>('SprintCompleteReport.id DESC'),false));
		                        	$cnt = (count($cnts) > 0 )?$cnts['SprintCompleteReport']['move_count']:0;
		                            $this->SprintCompleteReport->create();
		                            $cmplSpnt['SprintCompleteReport']['milestone_id'] =  $milestone_id_now;
		                            $cmplSpnt['SprintCompleteReport']['task_id'] =  $v['Easycase']['id'];
		                            $cmplSpnt['SprintCompleteReport']['project_id'] =   $v['Easycase']['project_id'];
		                            $easy['Easycase'] = $v['Easycase'];
		                            $cmplSpnt['SprintCompleteReport']['tasks_detail'] =  json_encode($easy);
		                            $cmplSpnt['SprintCompleteReport']['is_type'] =  2; //  Completed Out side the Sprint
		                            $cmplSpnt['SprintCompleteReport']['move_count'] =  $cnt +1; //  Completed Out side the Sprint
		                            $this->SprintCompleteReport->save($cmplSpnt);

		                     	}
	                 		}
						} 
						if ($this->request->data['Milestone']['id']) {
							if(isset($this->request->data['Milestone']['is_started']) && $this->request->data['Milestone']['is_started']){
								$arr['msg'] =__('Sprint started successfully.',true);
							}else{
								$arr['msg'] =__('Sprint updated successfully.',true);
							}
						} else {
							$json_arr['sprint_uid'] = $milestone_id_now;
							$json_arr['sprint_puid'] = $proj['Project']['id'];
							$json_arr['created'] = GMT_DATETIME;
							$this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 56);
							$arr['msg'] =__('Sprint created successfully.',true);
							$this->ProjectUser->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE user_id=" . SES_ID . " and project_id='" . $this->request->data['Milestone']['project_id'] . "' and company_id='" . SES_COMP . "'");
						}
						$sprintDtl = $this->Milestone->find('first', array('conditions' => array('Milestone.project_id' => $proj['Project']['id'],'Milestone.id' =>$milestone_id_now),'fields' => array('Milestone.id','Milestone.title'),'order'=>array('Milestone.id'=>'DESC')));
						if($sprintDtl){
							$arr['title'] = $sprintDtl['Milestone']['title'];
							$arr['mid_bcklog'] = $sprintDtl['Milestone']['id'];
						}
					} else {
						$arr['error']=1;
						$arr['msg'] = __('Sorry! We are not able to post this Sprint. Try again.',true);
					}
				}
				echo json_encode($arr);exit;
			}
	    }
	    if (isset($mileuniqid) && $mileuniqid && $mileuniqid != 'default') {
			$milearr = $this->Milestone->find('first', array('conditions' => array('Milestone.uniq_id' => $mileuniqid, 'Milestone.company_id' => SES_COMP)));			
			if(isset($this->data['status']) && trim($this->data['status']) == 'complete'){
				
				$this->EasycaseMilestone->bindModel(array('belongsTo' => array('Easycase')));
				$cases = $this->EasycaseMilestone->find('all',array('conditions'=>array('EasycaseMilestone.milestone_id'=>$milearr['Milestone']['id'],'Easycase.isactive'=>1,'Easycase.istype'=>1),'fields'=>array('Easycase.id','Easycase.legend','COUNT(Easycase.id) as CNT'),'group'=>array('Easycase.legend')));
				$taskStaus = array('done'=>0,'incomplete'=>0);
				if($cases){
					foreach($cases as $k => $v){
						if(in_array($v['Easycase']['legend'],array(3,5))){
							$taskStaus['done'] += $v[0]['CNT'];
						}else{
							$taskStaus['incomplete'] += $v[0]['CNT']; 
						}
					}
				}
				$allMiles = $this->Milestone->find('list', array('conditions' => array('Milestone.project_id' => $milearr['Milestone']['project_id'], 'Milestone.company_id' => SES_COMP,'Milestone.id !=' => $milearr['Milestone']['id'],'Milestone.isactive' => 1)));
				$resMil['milesone'] = $milearr;
				$resMil['taskStatus'] = $taskStaus;
				$resMil['donemsg'] = ($taskStaus['done'] > 1)?'<strong>'.$taskStaus['done'].'</strong> '.__('tasks are done').'.':'<strong>'.$taskStaus['done'].'</strong> '.__('task done').'.';
				$resMil['incompletemsg'] = ($taskStaus['incomplete'] > 1)?'<strong>'.$taskStaus['incomplete'].'</strong> '.__('tasks are incomplete').'.':'<strong>'.$taskStaus['incomplete'].'</strong> '.__('task incomplete').'.';
				$resMil['mlst_list'] = $allMiles;
				echo json_encode($resMil);exit;
			}
			echo json_encode($milearr);exit;
	    }
	}
	
	function ajax_check_estd(){
		$this->layout = 'ajax';
		$mileuniqid = 0;
		if (isset($this->data['mileuniqid']) && $this->data['mileuniqid']) {    
			$mileuniqid = $this->data['mileuniqid'];
		}
		$this->loadModel('Easycase');
		$this->loadModel('TypeCompany');
		$resMil['status'] = 'success';
	    if (isset($mileuniqid) && $mileuniqid && $mileuniqid != 'default') {
			$milearr = $this->Milestone->find('first', array('conditions' => array('Milestone.uniq_id' => $mileuniqid, 'Milestone.company_id' => SES_COMP)));			
			if($milearr){				
				$stortyp_id = $this->TypeCompany->getStoryId(SES_COMP);				
				$this->EasycaseMilestone->bindModel(array('belongsTo' => array('Easycase')));
				$cases = $this->EasycaseMilestone->find('all',array('conditions'=>array('EasycaseMilestone.milestone_id'=>$milearr['Milestone']['id'],'Easycase.isactive'=>1,'Easycase.istype'=>1, 'Easycase.story_point'=>0,'Easycase.type_id'=>$stortyp_id),'fields'=>array('Easycase.id','Easycase.case_no')));
				$tasksList = array();
				if($cases){
					$tasksList = Hash::extract($cases, '{n}.Easycase.case_no');					
				}
				$resMil['taskList'] = $tasksList;
				echo json_encode($resMil);exit;
			}else{
				$resMil['status'] = 'failure';
				$resMil['msg'] = __('Invalid Sprint.');
				echo json_encode($resMil);exit;
			}
	    }else{
			$resMil['status'] = 'failure';
			$resMil['msg'] = __('This sprint can not be started.');
			echo json_encode($resMil);exit;
		}
	}
	
	function ajax_complete_sprint(){
		$this->layout = 'ajax';
	    $this->loadModel('Project');
	    if (!empty($this->request->data['Milestone']) && !empty($this->request->data['Milestone']['sprint_uid'])) {
			$proj = $this->Project->getProjectFields(array("Project.uniq_id" => $this->request->data['Milestone']['sprint_puid']), array("Project.id"));
			if (!$proj) {
				$arr['error']=1;
				$arr['msg'] = __('Invalid Project!');
				echo json_encode($arr);exit;
			}
			if ($this->request->data['Milestone']['sprint_uid']) {
				$checkExist = $this->Milestone->find('first', array('conditions' => array('Milestone.uniq_id' => $this->request->data['Milestone']['sprint_uid']),'fields' => array('Milestone.id','Milestone.isactive')));
			}
			if (!$checkExist['Milestone']['id']) {
				$arr['error']=1;
				$arr['msg'] = __('Oops! Sprint does not exists',true);
			} else {
				if (!$checkExist['Milestone']['isactive']) {
					$arr['error']=1;
					$arr['msg'] = __('Oops! Sprint is already completed',true);
					 print json_encode($arr);
					 exit;
				}
				if(SES_TYPE > 2){
					$arr['error']=1;
					$arr['msg'] = __('Oops! you are not authorized the perform this action',true);
					echo json_encode($arr);
					exit;
				}
				if($this->Milestone->updateAll(array('Milestone.isactive' => 0,'modified'=>"'".GMT_DATETIME."'"), array('Milestone.id' => $checkExist['Milestone']['id'], 'Milestone.project_id' => $proj['Project']['id']))){ //, 'Milestone.user_id' => SES_ID
						
					$json_arr['sprint_uid'] = $checkExist['Milestone']['id'];
					$json_arr['sprint_puid'] = $proj['Project']['id'];
					$json_arr['created'] = GMT_DATETIME;
					$this->Postcase->eventLog(SES_COMP, SES_ID, $json_arr, 57); 
					
					$arr['success'] =1;
					$arr['milestone_id'] = $checkExist['Milestone']['id'];					
					$new_milestone_id = 0;					
					$this->EasycaseMilestone->bindModel(array('belongsTo' => array('Easycase')));
					$this->EasycaseMilestone->recursive = 2;
					$unresolvedCases_arr = $this->EasycaseMilestone->find('all',array('conditions'=>array('EasycaseMilestone.milestone_id'=>$checkExist['Milestone']['id'],'Easycase.isactive'=>1,'Easycase.istype'=>1),'fields'=>array('Easycase.id','Easycase.legend'),'order'=>array('Easycase.id'=>'DESC'))); //'Easycase.legend'=>array(1,2,4),
					$unresolvedCases = array();
					$unresolvedCasesforUpdate = array();
					foreach($unresolvedCases_arr as $k=>$v){
						$unresolvedCases[$v['Easycase']['id']] = $v['Easycase']['legend'];
						if(in_array($v['Easycase']['legend'], array(1,2,4))){
							$unresolvedCasesforUpdate[$v['Easycase']['id']] = $v['Easycase']['legend'];
						}
					}
					$tasksListforUpdate = ($unresolvedCasesforUpdate)?array_keys($unresolvedCasesforUpdate):array();			
					if($unresolvedCases){						
						//$tasksList = Hash::extract($unresolvedCases, '{n}.Easycase.id');
						$tasksList = array_keys($unresolvedCases);
						$this->loadModel('Easycase');
						$this->loadModel('SprintCompleteReport');
						$tasksRept = $this->Easycase->find('all', array('conditions'=>array('Easycase.id'=>$tasksList, 'Easycase.project_id'=>$proj['Project']['id'])));
						$repArr = null;
						$repArr['SprintCompleteReport']['milestone_id'] = $checkExist['Milestone']['id'];
						$repArr['SprintCompleteReport']['project_id'] = $proj['Project']['id'];
						foreach($tasksRept as $kr => $vr){
							$cnts = $this->SprintCompleteReport->find('first',array('conditions'=>array('SprintCompleteReport.task_id'=>$vr['Easycase']['id']),'fields'=>array('SprintCompleteReport.move_count','SprintCompleteReport.milestone_id','SprintCompleteReport.id'),'order'=>array('SprintCompleteReport.id'=> 'DESC'),false));
                    		$cnt = (count($cnts) > 0 )?$cnts['SprintCompleteReport']['move_count']:0;

							$this->SprintCompleteReport->create();
							$repArr['SprintCompleteReport']['task_id'] = $vr['Easycase']['id'];
							$repArr['SprintCompleteReport']['tasks_detail'] = json_encode($vr);
							$legnd= $unresolvedCases[$vr['Easycase']['id']];
							$repArr['SprintCompleteReport']['is_type'] = ($legnd == 3 || $legnd == 5)? 1 : 0; // Check for completed or not completed tasks
							if($cnt){
								$repArr['SprintCompleteReport']['move_count'] = $cnt+1;
							}else{
								$repArr['SprintCompleteReport']['move_count'] = 1;
							}
							if(count($cnts) > 0 && $cnts['SprintCompleteReport']['milestone_id'] == $checkExist['Milestone']['id']){
								$repArr['SprintCompleteReport']['is_type'] = ($repArr['SprintCompleteReport']['is_type'] == 1)?2:$repArr['SprintCompleteReport']['is_type']; // Check for completed or complted out site 
								$repArr['SprintCompleteReport']['id'] = $cnts['SprintCompleteReport']['id'];
							}else{
								$repArr['SprintCompleteReport']['id'] ='';
							}

							$this->SprintCompleteReport->saveAll($repArr);
						}
						if($this->request->data['Milestone']['sprint'] == 0){
							$this->EasycaseMilestone->deleteAll(array('project_id'=>$proj['Project']['id'],'milestone_id'=>$checkExist['Milestone']['id'],'easycase_id'=>$tasksListforUpdate));
						}else{						
							$checkExistMil = $this->Milestone->find('first', array('conditions' => array('Milestone.id' => $this->request->data['Milestone']['sprint']),'fields' => array('Milestone.id')));						
							if($checkExistMil){
								$new_milestone_id = $checkExistMil['Milestone']['id'];
								$this->EasycaseMilestone->updateAll(array('EasycaseMilestone.milestone_id' =>$new_milestone_id), array('EasycaseMilestone.milestone_id' => $checkExist['Milestone']['id'], 'EasycaseMilestone.project_id' => $proj['Project']['id'], 'EasycaseMilestone.easycase_id' => $tasksListforUpdate));
							}
						}
					}					
					$arr['msg'] =__('Sprint completed successfully.',true);
				} else {
					$arr['error']=1;
					$arr['msg'] = __('Sorry! We are not able to complete this Sprint. Try again.',true);
				}
			}
			echo json_encode($arr);exit;
	    }
	}      
}