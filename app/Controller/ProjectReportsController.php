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

class ProjectReportsController extends AppController {

    public $name = 'ProjectReports';
    public $components = array('Format', 'Postcase', 'Tmzone', 'Sendgrid', 'Pushnotification');
    public $helpers = array('Html', 'Form', 'Casequery', 'Format');
    public $uses = array('Easycase','ProjectUser', 'Project', 'User');
    public $paginate = array();
    function beforeRender() {
        if (SES_TYPE == 3) {
            //$this->redirect(HTTP_ROOT."dashboard");
        }
    }
    function dashboard() {        
    }
		
		public function utilization()
		{		
			if ((SES_TYPE > 2 && !$this->Format->isAllowed('View Resource Utilization', $roleAccess)) || (!$this->Format->isAllowed('View Resource Utilization', $roleAccess))) {
				$this->redirect(HTTP_ROOT . 'dashboard');
			}
			#echo date("M jS Y, g:i a", strtotime('2022-01-02'));
			#exit;
			/*$date = strtotime("2021-09-01");
			$fdate = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-01 00:00:00',$date), "datetime");
			$ldate = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-t 23:59:59',$date), "datetime");
			
			echo $date.'----'.$fdate.'----'.$ldate;exit;*/
		
			//$week_array = $this->getStartAndEndDate(52,2021);
			//print_r($week_array);
			//exit;
			/*echo 'First Date    = ' . date('Y-m-01 00:00:01') . '<br />';
			echo 'Last Date     = ' . date('Y-m-t 11:59:59')  . '<br />';
			
			echo date('W', strtotime(date('Y-m-01 00:00:01'))).'<br/>';
			echo date('W', strtotime(date('Y-m-t 11:59:59')));
			exit;*/
			$start_date = date('Y-m-01 00:00:01');
			$cur_date = date('Y-m-d', strtotime($start_date));
			//$this->set('cur_date', $cur_date);
			
			$restrict_uidd = 0;
			if(!$this->Format->isAllowed('View All Resource')){
				$restrict_uidd = SES_ID;
			}			
			$this->loadModel('Project');
			$this->loadModel('Role');
			$this->loadModel('RoleGroup');
			$allProjs = $this->Project->getProjLists(SES_COMP, SES_ID);
			$allUsers = $this->Project->getProjuserLists(SES_COMP, $restrict_uid);
			$allRoles = $this->Role->getRoles(SES_COMP);
			$allRoleGroups = $this->RoleGroup->getRoleGroups(SES_COMP);
			$isAvaillabityOn = $this->Format->isResourceAvailabilityOn();
			
			$isAvaillabityOn = 1;//Remove before live
			
			$this->set(compact('allProjs', 'allUsers','isAvaillabityOn','cur_date','allRoles','allRoleGroups'));
			$this->render('user_utilization');
		}
		
		function getStartAndEndDate($week, $year) {
			$dto = new DateTime();
			$dto->setISODate($year, $week);
			$ret['week_start'] = $dto->format('Y-m-d');
			$dto->modify('+6 days');
			$ret['week_end'] = $dto->format('Y-m-d');
			return $ret;
		}
    function average_age_report() {
        if(!$this->Format->isAllowed('View Average Age Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        if ($this->data['page'] == 'average_age_report') {
            $view = new View($this);
            $dt = $view->loadHelper('Datetime');

            #pr($this->params->data);exit;
            $proj_id = NULL;
            $prjUniqIdCsMenu = $this->params->data['pid'];
            $mode = $this->params->data['mode'];
            $qty = intval($this->params->data['qty']) > 0 ? intval($this->params->data['qty']) - 1 : intval($this->params->data['qty']);

            if ($_COOKIE['CURRENT_FILTER'] != "") {
                $filters = $_COOKIE['CURRENT_FILTER'];
            } else {
                $filters = '';
            }
            $filters = '';

            if (isset($this->params->data['filters']) && $this->params->data['filters'] == "files") {
                $filters = $this->params->data['filters'];
            } elseif (isset($this->params->data['filters']) && $this->params->data['filters'] == "cases") {
                $filters = $this->params->data['filters'];
            }
            $curDateTime = date('Y-m-d H:i:s');
            $start_dt = date('Y-m-d', strtotime($curDateTime . ' -' . $qty . ' days'));


            $searchcase = '';
            $clt_sql = 1;

            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") "
                        . "OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
            $resultCases = array();
            if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
                $this->Project->recursive = -1;
                $projArr = $this->Project->find('first', array(
                    'conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                    'fields' => array('Project.id')
                ));
                if (count($projArr)) {
					$this->Project->updateRptVisited($prjUniqIdCsMenu, SES_ID, SES_COMP);
                    $proj_id = $projArr['Project']['id'];
                }
                if (!$proj_id) {
                    die;
                }
                //$searchcase = ' AND Easycase.id NOT IN (SELECT Easycase.id FROM easycases Easycase WHERE Easycase.legend IN (3,5) AND DATE(Easycase.dt_created) < "' . $start_dt . '")';
                $searchcase = ' AND Easycase.legend NOT IN(3,5) AND DATE(Easycase.dt_created) < "' . $start_dt . '"';
                $sql1 = 'SELECT Easycase.id,Easycase.user_id,Easycase.project_id,Easycase.dt_created,Easycase.actual_dt_created,'
                        . 'Easycase.priority,Easycase.due_date,Easycase.type_id,Easycase.legend '
                        . 'FROM easycases Easycase '
                        . 'WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype= 1 AND Easycase.type_id !=10 '
                        . 'AND Easycase.project_id =' . $proj_id . ' ' . $searchcase;
                $caseNew_all = $this->Easycase->query($sql1);
                #echo $sql1;
                #pr($caseNew_all);
                #exit;
                $ret_arr = array('overdue' => 0, 'opeded' => 0);
                if (!empty($caseNew_all)) {
                    for ($i = $qty; $i >= 0; $i--) {
                        $result_dt = date('Y-m-d', strtotime($curDateTime . ' -' . $i . ' days'));
                        if ($mode == 'daily') {
                            $dis_res_dt = date('jS F, Y', strtotime($result_dt));
                        } elseif ($mode == 'weekly') {
                            $dis_year = date("Y", strtotime($result_dt));
                            $dis_week = date('W', strtotime($result_dt));
                            $dis_res_dt = $dis_year . $dis_week;
                        } elseif ($mode == 'monthly') {
                            $dis_res_dt = date('F, Y', strtotime($result_dt));
                        } elseif ($mode == 'quarterly') {
                            $dis_year = date("Y", strtotime($result_dt));
                            $month = date("m", strtotime($result_dt));
                            if ($month < 4) {
                                $dis_quarter_no = '01';
                            } elseif ($month > 3 && $month < 7) {
                                $dis_quarter_no = '02';
                            } elseif ($month > 6 && $month < 10) {
                                $dis_quarter_no = '03';
                            } elseif ($month > 9) {
                                $dis_quarter_no = '04';
                            }
                            $dis_res_dt = $dis_year . $dis_quarter_no;
                        } elseif ($mode == 'yearly') {
                            $dis_res_dt = date('Y', strtotime($result_dt));
                        }

                        foreach ($caseNew_all as $kk => $vk) {
                            $resultCases[$dis_res_dt]['label'] = $dis_res_dt;
                            #echo $dt_created . ' == ' . $result_dt . ($dt_created == $result_dt) . '<br>';
                            #echo $vk['Easycase']['actual_dt_created'] .' < '. $result_dt.' 23:59:59'.' x '.intval($vk['Easycase']['actual_dt_created'] < $result_dt.' 23:59:59') . '<br>';
                            #$resultCases[$dis_res_dt] = 0;
                            if ($mode == 'daily') {
                                $dt_created = date('Y-m-d', strtotime($vk['Easycase']['dt_created']));
                                if (in_array($vk['Easycase']['legend'], array(3, 5)) && $dt_created == $result_dt) {
                                    //no action
                                } elseif ($vk['Easycase']['actual_dt_created'] < $result_dt . ' 23:59:59') {
                                    $resultCases[$dis_res_dt]['unresolved_count'] = !empty($resultCases[$dis_res_dt]) ? $resultCases[$dis_res_dt]['unresolved_count'] + 1 : 1;
                                    $resultCases[$dis_res_dt]['age'] += $dt->dateDiff($vk['Easycase']['actual_dt_created'], $result_dt . ' 23:59:59');
                                    $resultCases[$dis_res_dt]['id'][] = $vk['Easycase']['id'];
                                }
                            } elseif ($mode == 'weekly') {
                                #$dis_year = date("Y", strtotime($result_dt));
                                #$dis_week = date('W', strtotime($result_dt));
                                #$dis_res_dt = $dis_year . $dis_week;
                                $dt_created = date('YW', strtotime($vk['Easycase']['dt_created']));
                                if (in_array($vk['Easycase']['legend'], array(3, 5)) && $dt_created == $dis_res_dt) {
                                    //no action
                                } elseif ($vk['Easycase']['actual_dt_created'] < $result_dt . ' 23:59:59' && !in_array($vk['Easycase']['id'], $resultCases[$dis_res_dt]['id'])) {
                                    $resultCases[$dis_res_dt]['unresolved_count'] = !empty($resultCases[$dis_res_dt]) ? $resultCases[$dis_res_dt]['unresolved_count'] + 1 : 1;
                                    $resultCases[$dis_res_dt]['age'] += $dt->dateDiff($vk['Easycase']['actual_dt_created'], $result_dt . ' 23:59:59');
                                    $resultCases[$dis_res_dt]['id'][] = $vk['Easycase']['id'];
                                }
                                $resultCases[$dis_res_dt]['label'] = $dis_year . ' Week ' . $dis_week;
                            } elseif ($mode == 'monthly') {
                                $dt_created = date('F, Y', strtotime($vk['Easycase']['dt_created']));
                                if (in_array($vk['Easycase']['legend'], array(3, 5)) && $dt_created == $dis_res_dt) {
                                    //no action
                                } elseif ($vk['Easycase']['actual_dt_created'] < $result_dt . ' 23:59:59' && !in_array($vk['Easycase']['id'], $resultCases[$dis_res_dt]['id'])) {
                                    $resultCases[$dis_res_dt]['unresolved_count'] = !empty($resultCases[$dis_res_dt]) ? $resultCases[$dis_res_dt]['unresolved_count'] + 1 : 1;
                                    $resultCases[$dis_res_dt]['age'] += $dt->dateDiff($vk['Easycase']['actual_dt_created'], $result_dt . ' 23:59:59');
                                    $resultCases[$dis_res_dt]['id'][] = $vk['Easycase']['id'];
                                }
                            } elseif ($mode == 'quarterly') {
                                $year = date("Y", strtotime($vk['Easycase']['dt_created']));
                                $month = date("m", strtotime($vk['Easycase']['dt_created']));
                                if ($month < 4) {
                                    $quarter_no = '01';
                                } elseif ($month > 3 && $month < 7) {
                                    $quarter_no = '02';
                                } elseif ($month > 6 && $month < 10) {
                                    $quarter_no = '03';
                                } elseif ($month > 9) {
                                    $quarter_no = '04';
                                }
                                $dt_created = $year . $quarter_no;

                                if (in_array($vk['Easycase']['legend'], array(3, 5)) && $dt_created == $dis_res_dt) {
                                    //no action
                                } elseif ($vk['Easycase']['actual_dt_created'] < $result_dt . ' 23:59:59' && !in_array($vk['Easycase']['id'], $resultCases[$dis_res_dt]['id'])) {
                                    $resultCases[$dis_res_dt]['unresolved_count'] = !empty($resultCases[$dis_res_dt]) ? $resultCases[$dis_res_dt]['unresolved_count'] + 1 : 1;
                                    $resultCases[$dis_res_dt]['age'] += $dt->dateDiff($vk['Easycase']['actual_dt_created'], $result_dt . ' 23:59:59');
                                    $resultCases[$dis_res_dt]['id'][] = $vk['Easycase']['id'];
                                }
                                $resultCases[$dis_res_dt]['label'] = $dis_year . ' Q' . intval($dis_quarter_no);
                            } elseif ($mode == 'yearly') {
                                $dt_created = date('Y', strtotime($vk['Easycase']['dt_created']));
                                if (in_array($vk['Easycase']['legend'], array(3, 5)) && $dt_created == $dis_res_dt) {
                                    //no action
                                } elseif ($vk['Easycase']['actual_dt_created'] < $result_dt . ' 23:59:59' && !in_array($vk['Easycase']['id'], $resultCases[$dis_res_dt]['id'])) {
                                    $resultCases[$dis_res_dt]['unresolved_count'] = !empty($resultCases[$dis_res_dt]) ? $resultCases[$dis_res_dt]['unresolved_count'] + 1 : 1;
                                    $resultCases[$dis_res_dt]['age'] += $dt->dateDiff($vk['Easycase']['actual_dt_created'], $result_dt . ' 23:59:59');
                                    $resultCases[$dis_res_dt]['id'][] = $vk['Easycase']['id'];
                                }
                            }
                        }
                        if ($resultCases[$dis_res_dt]['unresolved_count'] > 0) {

                            #$resultCases[$dis_res_dt]['age'] = $dt->dateDiff($result_dt, $curDateTime);
                            $resultCases[$dis_res_dt]['avg'] = round($resultCases[$dis_res_dt]['age'] / $resultCases[$dis_res_dt]['unresolved_count']);
                        } else {
                            $resultCases[$dis_res_dt]['unresolved_count'] = 0;
                            $resultCases[$dis_res_dt]['age'] = '---';
                            $resultCases[$dis_res_dt]['avg'] = '---';
                        }
                    }
                }
#exit;
                #$resultCases['openedtasks'] = $ret_arr['opeded'];
            } else if ($prjUniqIdCsMenu == 'all') {

                ######### Filter by Case Label ##########
                if (trim($caseLabel) && $caseLabel != "all") {
                    $qry.= $this->Format->labelFilter($caseLabel, 0, SES_COMP, SES_TYPE, SES_ID);
                    //$filterenabled = 1;
                }

                $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('DISTINCT Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));

                $this->loadModel('ProjectUser');
                $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                $allProjArr = $this->ProjectUser->find('all', $cond);

                $ids = array();
                $idlist = '';
                foreach ($allProjArr as $csid) {
                    $idlist .='\'' . $csid['Project']['id'] . '\',';
                    array_push($ids, $csid['Project']['id']);
                }

                $idlist = trim($idlist, ',');
                $n_pid_cond = 1;
                $n_pid_cond_t = 1;
                if ($idlist != '') {
                    $n_pid_cond = 'Easycase.project_id IN(' . $idlist . ')';
                    $n_pid_cond_t = "Easycase.project_id IN(" . $idlist . ")";
                }

                $cur_dt = date('Y-m-d', strtotime(GMT_DATETIME));

                $openedTasksArr = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS openedcnt '
                        . 'FROM easycases AS Easycase '
                        . 'WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND Easycase.type_id !=10 '
                        # . 'AND (Easycase.legend=1 OR Easycase.legend=2 OR Easycase.legend=5 OR Easycase.legend=4) AND Easycase.type_id !=10 '
                        . $qry . ' ' . $searchcase);
                $openedTasks = $openedTasksArr[0][0]['openedcnt'];

                $resultCases['openedtasks'] = (isset($openedTasks)) ? $openedTasks : 0;
            }
            #pr($resultCases);exit;
            echo json_encode($resultCases);
            exit;
        }
    }
     /*
     *  Created vs. Resolved Tasks Report
     */
    function create_resolve_report() {
        if(!$this->Format->isAllowed('View Created vs Resolved Tasks Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        if($this->request->is('ajax')){
        $view = new View($this);
        $dt = $view->loadHelper('Datetime');
        $proj_id = NULL;
        $prjUniqIdCsMenu = $this->params->data['pid'];
        $mode = $this->params->data['mode'];
        $qty = $this->params->data['qty'];
        $cumulative = $this->params->data['cumulative'];
        $filters = '';
        $curDateTime = date('Y-m-d H:i:s');
        $start_dt = date('Y-m-d', strtotime($curDateTime . ' -' . $qty . ' days'));
        $searchcase = '';
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") "
                    . "OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
		$clt_sql1 = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql1 = "((Easycase2.client_status = " . $this->Auth->user('is_client') . " AND Easycase2.user_id = " . $this->Auth->user('id') . ") "
                    . "OR Easycase2.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $resultCases = array();
        if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', array(
                'conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                'fields' => array('Project.id')
            ));
            if (count($projArr)) {
				$this->Project->updateRptVisited($prjUniqIdCsMenu, SES_ID, SES_COMP);
                $proj_id = $projArr['Project']['id'];
            }
            if (!$proj_id) {
                die;
            }
             /** Mysql check timezone **/
                $this->loadModel('TimezoneName');
                $tmz=$this->TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
                $tmz=  str_replace(array("GMT","(",")"), "", $tmz);
                $gmt_val = "+00:00";
            /* End*/
            
            $extraFields = ", DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt ";
            $innerCond = " AND DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = DATE(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
            $grpby = "DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
            $grpby1 = "DATE(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
            $orderby = "dt ASC";
            if ($mode == 'weekly') {
                $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, WEEK(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) wk, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
                $innerCond = " AND YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $innerCond .= " AND WEEK(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = WEEK(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), WEEK(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";   
                $grpby1 = "YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz')),WEEK(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $orderby = "yr ASC,wk ASC";
            } elseif ($mode == 'monthly') {
                $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, MONTH(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) mt, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
                $innerCond = " AND YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $innerCond .= " AND MONTH(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = MONTH(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), MONTH(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))"; 
                $grpby1 = "YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz')),MONTH(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $orderby = "yr ASC,mt ASC";
            } elseif ($mode == 'quarterly') {
               $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, QUARTER(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) qt, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
               $innerCond = " AND YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
               $innerCond .= " AND QUARTER(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = QUARTER(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
               $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), QUARTER(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
               $grpby1 = "YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz')),QUARTER(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
               $orderby = "yr ASC,qt ASC";
            } elseif ($mode == 'yearly') {
                $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
                $innerCond = " AND YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) = YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
                $grpby1 = "YEAR(CONVERT_TZ(Easycase2.dt_created,'$gmt_val','$tmz'))";
                $orderby = "yr ASC";
            }
            $sql1 = 'SELECT Easycase.id,Easycase.user_id,Easycase.project_id,Easycase.dt_created,Easycase.dt_created,Easycase.priority,'
                        . 'Easycase.due_date,Easycase.type_id,Easycase.legend,'
                        . 'COUNT(id) as created,'
                        . '(SELECT SUM(case when Easycase2.legend = 5 OR Easycase2.legend = 3 then 1 else 0 end)  FROM easycases AS Easycase2 WHERE Easycase2.isactive=1 AND '. $clt_sql1.' AND Easycase2.istype= 1 AND Easycase2.type_id !=10 AND Easycase2.project_id = '.$proj_id.' '.$innerCond.' GROUP BY '.$grpby1.') AS resolve'.$extraFields.' '
                        . 'FROM easycases Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND '. $clt_sql.' AND Easycase.project_id = '.$proj_id.' AND DATE(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'")) > "' . $start_dt . '" AND DATE(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'")) <= "' . date('Y-m-d',strtotime($curDateTime)) . '" GROUP BY '.$grpby.' ORDER BY '.$orderby ;
            $caseNew_all = $this->Easycase->query($sql1);
        }else if ($prjUniqIdCsMenu == 'all') {
            
}
        $result = array();
        $chart = array();
           
        if(count($caseNew_all) > 0){
            $period = new DatePeriod(
                new DateTime(date('Y-m-d',strtotime('+1 day',strtotime($start_dt)))),
                new DateInterval('P1D'),
                new DateTime(date('Y-m-d',strtotime("+1 days")))
           );
        foreach($caseNew_all as $k=>$v){
               $result[$k] = $v;
              if($k != 0 && $cumulative == 'yes'){
                 $result[$k]['0']['created']  =   (int) $result[($k-1)]['0']['created']+ (int) $v['0']['created'];
                 $result[$k]['0']['resolve']  =   (int)$result[($k-1)]['0']['resolve']+ (int) $v['0']['resolve'];
               }
                if ($mode == 'weekly') {
                    $chart['rdate_row']['created'][$v[0]['wk'].'-'.$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['wk'].'-'.$v[0]['yr']] =  $result[$k][0]['resolve'];
                }else if ($mode == 'monthly') {
                    $chart['rdate_row']['created'][$v[0]['mt'].'-'.$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['mt'].'-'.$v[0]['yr']] =  $result[$k][0]['resolve'];
                }else if ($mode == 'quarterly') {
                    $chart['rdate_row']['created'][$v[0]['qt'].'-'.$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['qt'].'-'.$v[0]['yr']] =  $result[$k][0]['resolve'];
                }else if ($mode == 'yearly') {
                    $chart['rdate_row']['created'][$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['yr']] =  $result[$k][0]['resolve'];
        }else{
                     $chart['rdate_row']['created'][strtotime($v[0]['dt'])] =  $result[$k][0]['created'];
                     $chart['rdate_row']['resolved'][strtotime($v[0]['dt'])] =  $result[$k][0]['resolve'];
            }
        }
        
            $chart['xaxis'] = array();
            foreach ($period as $key => $value) {
               $cur_day = $value->format('Y-m-d');
               $cur_day_s = strtotime($cur_day);
            if ($mode == 'weekly') {
                    $cur_weeks = ltrim(date('W',strtotime($cur_day)),0).'-'.date('Y',strtotime($cur_day));

                    if(!in_array($value->format('W').' Week, '.$value->format('Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_weeks])?$chart['rdate_row']['created'][$cur_weeks]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_weeks])?$chart['rdate_row']['resolved'][$cur_weeks]:0;
                        $chart['xaxis'][] = $value->format('W').' Week, '.$value->format('Y') ;
                    }
            }else if($mode == 'monthly'){
                    $cur_month = date('n',strtotime($cur_day)).'-'.date('Y',strtotime($cur_day));
                    if(!in_array($value->format('M,Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_month])?$chart['rdate_row']['created'][$cur_month]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_month])?$chart['rdate_row']['resolved'][$cur_month]:0;
                        $chart['xaxis'][] = $value->format('M,Y') ;
                    }
            }else if($mode == 'quarterly'){
                   $qtrr = ceil(date('n',strtotime($cur_day))/3);
                    $cur_qtr = $qtrr.'-'.date('Y',strtotime($cur_day));
                    if(!in_array($qtrr.' Qtr, '.$value->format('Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_qtr])?$chart['rdate_row']['created'][$cur_qtr]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_qtr])?$chart['rdate_row']['resolved'][$cur_qtr]:0;
                        $chart['xaxis'][] = $qtrr.' Qtr, '.$value->format('Y') ;
                    }
            }else if($mode == 'yearly'){
                    $cur_year = date('Y',strtotime($cur_day));
                    if(!in_array($value->format('Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_year])?$chart['rdate_row']['created'][$cur_year]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_year])?$chart['rdate_row']['resolved'][$cur_year]:0;
                        $chart['xaxis'][] = $value->format('Y') ;
                    }
            }else{
                $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_day_s])?$chart['rdate_row']['created'][$cur_day_s]:0;
                $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_day_s])?$chart['rdate_row']['resolved'][$cur_day_s]:0;
                $chart['xaxis'][] = $value->format('d M,Y') ;
            }
        }
            if(count($chart['xaxis']) > 15){
                $chart['interval'] = ceil(count($chart['xaxis'])/15);  
                if ($mode == 'weekly') {
                    $chart['interval'] = $chart['interval']*2;
                }
            }else{
                  $chart['interval'] =1;
            }
        
        
            
        }
        $resultCases['result'] = $result;
        $resultCases['chart'] = $chart;
        echo json_encode($resultCases);exit;
    }
    }
    /*
     *  Pie Chart Report
     */
    function pie_chart_report() {
        if(!$this->Format->isAllowed('View Pie Chart Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        $priority_colors = array('#ff0000','#28AF51','#b4a532');
        $legend_colors = array('#f08e83','#f08e83','#6ba8de','#72ca8d','#6ba8de','#fab858','#6ba8de','#6ba8de');
        if($this->request->is('ajax')){
            $resultCases = array();
            $proj_id = NULL;
            $prjUniqIdCsMenu = $this->params->data['pid'];
            $mode = $this->params->data['mode'];
            $curDateTime = date('Y-m-d H:i:s');
            $searchcase = '';
            $clt_sql = 1;
            $proj_data = array();
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") "
                        . "OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
            if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
                $this->Project->recursive = -1;
                $projArr = $this->Project->find('first', array(
                    'conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                    'fields' => array('Project.id')
                ));
                if (count($projArr)) {
					$this->Project->updateRptVisited($prjUniqIdCsMenu, SES_ID, SES_COMP);
                    $proj_id = $projArr['Project']['id'];
                }
                if (!$proj_id) {
                    die;
                }
                if($mode == 'task_type'){
                    $sql1 = 'SELECT Easycase.id,Easycase.project_id,COUNT(Easycase.id) as created, '
                        .'IF((Easycase.type_id = 0),"---",Type.name) AS label '
                        . 'FROM easycases AS Easycase LEFT JOIN types AS Type ON Type.id = Easycase.type_id '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' ' 
                        . 'GROUP BY Easycase.type_id '
                        . 'ORDER BY Type.name ASC';
                }else if($mode == 'priority'){
                    $sql1 = 'SELECT Easycase.id,Easycase.project_id,COUNT(Easycase.id) as created,Easycase.priority, '
                        .'(CASE WHEN Easycase.priority = 0 THEN "High" WHEN Easycase.priority = 1 THEN "Medium" ELSE "Low" END) AS label '
                        . 'FROM easycases AS Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND Easycase.type_id !=10 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' ' 
                        . 'GROUP BY Easycase.priority '
                        . 'ORDER BY Easycase.priority ASC';
                    $sql2 = 'SELECT Easycase.id,Easycase.project_id,COUNT(Easycase.id) as created,Easycase.priority, "High" AS label '
                        . 'FROM easycases AS Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND Easycase.type_id =10 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' ' 
                        . 'GROUP BY Easycase.priority '
                        . 'ORDER BY Easycase.priority ASC';
                }else if($mode == 'status'){
                    $this->loadModel('Project');
                    $proj_data = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu), 'fields' => array('Project.status_group_id','Project.id')));
                    if(!empty($proj_data['Project']['status_group_id'])){
                        $sql1 = 'SELECT Easycase.id,Easycase.project_id, Easycase.legend,Easycase.custom_status_id,COUNT(Easycase.id) as created, '
                                . '(CASE WHEN Easycase.legend = 1 THEN "New" WHEN Easycase.legend = 3 THEN "Closed" WHEN Easycase.legend = 5 THEN "Resolved" ELSE "In-progress" END) AS label '
                                . 'FROM easycases AS Easycase '
                                . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND ' . $clt_sql . ' AND Easycase.project_id = ' . $proj_id . ' '
                                . 'GROUP BY Easycase.custom_status_id, if(Easycase.type_id=10,10,Easycase.legend)';
                                #. 'ORDER BY Easycase.legend=1,Easycase.legend=2,Easycase.legend=4,Easycase.legend=6,Easycase.legend=5,Easycase.legend=3,Easycase.legend ASC';
                    }else{
                        $sql1 = 'SELECT Easycase.id,Easycase.project_id, Easycase.legend,Easycase.custom_status_id,COUNT(Easycase.id) as created, '
                        .'(CASE WHEN Easycase.legend = 1 THEN "New" WHEN Easycase.legend = 3 THEN "Closed" WHEN Easycase.legend = 5 THEN "Resolved" ELSE "In-progress" END) AS label '
                        . 'FROM easycases AS Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' ' 
                        . 'GROUP BY Easycase.legend '
                        . 'ORDER BY Easycase.legend=1,Easycase.legend=2,Easycase.legend=4,Easycase.legend=6,Easycase.legend=5,Easycase.legend=3,Easycase.legend ASC';
                    }
                }else if($mode == 'epic_link'){  
                    if (stristr($_SERVER['SERVER_NAME'], "susil.com")) {
                        $epic_id = 296;
                    }else if(stristr($_SERVER['SERVER_NAME'], "payzilla.in")){
                       $epic_id = 304;  
                   }else{
                        $epic_id = 13;
                    }
                    $sql1 = 'SELECT Easycase.id,Easycase.project_id,(SELECT count(*) FROM easycase_linkings WHERE easycase_id = Easycase.id ) as created,'
                            . ' CONCAT("# ",Easycase.case_no,": ",Easycase.title) AS label '
                            . 'FROM easycases AS Easycase '
                            . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND '.$clt_sql.' AND Easycase.type_id ='.$epic_id.' AND Easycase.project_id = '.$proj_id.' '
                            . 'GROUP BY Easycase.id '
                            . 'ORDER BY Easycase.id DESC';
                }else if($mode == 'task_group'){
                     $sql1 = 'SELECT Easycase.id,Easycase.project_id,COUNT(Easycase.id) as created,'
                             . 'IF((IFNULL(M.milestone_id,0) = 0),"Default Task Group",M.title) AS label '
                             . 'FROM easycases AS Easycase LEFT JOIN '
                                . '(SELECT EasycaseMilestone.*,Milestone.title FROM easycase_milestones AS EasycaseMilestone '
                                . 'LEFT JOIN milestones AS Milestone ON Milestone.id = EasycaseMilestone.milestone_id) AS M ON Easycase.id = M.easycase_id '
                             . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' '
                             . 'GROUP BY M.milestone_id '
                             . 'ORDER BY M.Title ASC';
                }else{
                     $sql1 = 'SELECT Easycase.id,Easycase.project_id,COUNT(Easycase.id) as created, '
                        .'IF((Easycase.assign_to = 0),"Unassigned",User.name) AS label '
                        . 'FROM easycases AS Easycase LEFT JOIN users AS User ON User.id = Easycase.assign_to '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' ' 
                        . 'GROUP BY Easycase.assign_to '
                        . 'ORDER BY User.name ASC';
                }
                $caseNew_all = $this->Easycase->query($sql1);
                if($mode == 'priority'){
                    $caseNew_update = $this->Easycase->query($sql2);
                }
                
            }  
            $colors = $chart = $result = array();
            $total_count = 0;
//            if($mode == 'status'){
//                 $legend = 0 ;
//                 $legend_6 = 0 ;
//                 $legend_4 = 0 ;                
//              foreach($caseNew_all as $k=>$v){                 
//                 
//                  if($v['Easycase']['legend'] == 2 || $v['Easycase']['legend'] == 4 || $v['Easycase']['legend'] == 6){
//                     $caseNew_all[$k][0]['created'] = 
//                  }
//              }  
//            }
            $caseNew_all = array_values($caseNew_all);
            if ($mode == 'status' && !empty($proj_data['Project']['status_group_id'])){
                $csts_arr = array();
                $status = array();
                if ($caseNew_all) {
                    $this->loadModel('Easycase');
                    $csts_arr = $this->Easycase->getStatusFortasks($caseNew_all);
                    $csts_arr = Hash::sort($csts_arr, '{n}.seq', 'asc');
                    $csts_arr = Hash::combine($csts_arr, '{n}.id', '{n}');
                    foreach ($caseNew_all as $sk => $sv) {
                        if ($sv['Easycase']['custom_status_id']) {
                            $status[$sv['Easycase']['custom_status_id']] = $sv[0]['created'];
                        } else {
                            $status[$sv[0]['legend']] = $sv[0]['created'];
                        }
                    }
                }
                #$total_count = array_sum($status);
                if(!empty($csts_arr)){
                    foreach ($caseNew_all as $key => $value) {
                        $caseNew_all[$key][0]['label'] = $csts_arr[$value['Easycase']['custom_status_id']]['name'];
                        $caseNew_all[$key][0]['label_color'] = '#'.$csts_arr[$value['Easycase']['custom_status_id']]['color'];
                    }
                }
            }
            $legend = 0 ;
            $legend_array = $legend_array_chart = array();
            foreach($caseNew_all as $k=>$v){
              if($v[0]['label']== "High" &&  $mode == 'priority' && !empty($caseNew_update[0][0]['created'])){
                   $v[0]['created'] += $caseNew_update[0][0]['created'];
               }
              $total_count += $v[0]['created'];
              if($mode == 'priority'){
               $chart[$k]['color'] = $priority_colors[$v['Easycase']['priority']];               
              }else if($mode == 'status'){
                    if (empty($proj_data['Project']['status_group_id'])){
               if($v['Easycase']['legend'] == 6 || $v['Easycase']['legend'] == 4 || $v['Easycase']['legend'] == 2 ){
                    $legend += $v[0]['created'];
                    $legend_array['created'] = $legend;
                    $legend_array['label'] =  'In-Progress';
                    $legend_array_chart['color'] = '#6ba8de' ;
                    $legend_array_chart['name'] = 'In-Progress';
                    $legend_array_chart['y'] = $legend ;
                    unlink($caseNew_all[$k]); 
                    continue;
              }
                $chart[$k]['color'] = $legend_colors[$v['Easycase']['legend']];
            }
                }
                if (!empty($proj_data['Project']['status_group_id'])){
                    $chart[$k]['color'] = $v[0]['label_color'];
                }
              $result[$k]['created'] =  $v[0]['created'];  
              $result[$k]['label'] =  $v[0]['label'];
              $chart[$k]['name'] =  $v[0]['label'];  
              $chart[$k]['y'] = $v[0]['created'];
            
            }
            
            if($mode == 'status' && !empty($legend_array)){
                $result[] = $legend_array;
                $chart[] = $legend_array_chart;
            }
            
            $resultCases['result'] = $result;
            $resultCases['total_count'] = $total_count;
            $resultCases['chart'] = $chart;
            echo json_encode($resultCases);exit;
        }
    }
     /*
     *  Recent Created Task Report
     */
    function recent_created_task_report() {
        if(!$this->Format->isAllowed('View Recently Created Tasks Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        if($this->request->is('ajax')){
        $proj_id = NULL;
        $prjUniqIdCsMenu = $this->params->data['pid'];
        $mode = $this->params->data['mode'];
        $qty = $this->params->data['qty'];
        $filters = '';
        $curDateTime = date('Y-m-d H:i:s');
        $start_dt = date('Y-m-d', strtotime($curDateTime . ' -' . $qty . ' days'));
        $searchcase = '';
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") "
                    . "OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $resultCases = array();
        if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', array(
                'conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                'fields' => array('Project.id')
            ));
            if (count($projArr)) {
				$this->Project->updateRptVisited($prjUniqIdCsMenu, SES_ID, SES_COMP);
                $proj_id = $projArr['Project']['id'];
            }
            if (!$proj_id) {
                die;
            }
            /** Mysql check timezone **/
                $this->loadModel('TimezoneName');
                $tmz=$this->TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
                $tmz=  str_replace(array("GMT","(",")"), "", $tmz);
                $gmt_val = "+00:00";
            /* End*/
            $extraFields = ", DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt ";
            $grpby = "DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
            $orderby = "dt ASC";
            if ($mode == 'weekly') {
                $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, WEEK(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) wk , DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt ";
                $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), WEEK(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";   
                $orderby = "yr ASC,wk ASC";
            } elseif ($mode == 'monthly') {
                $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, MONTH(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) mt, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
                $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), MONTH(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))"; 
                $orderby = "yr ASC,mt ASC";
            } elseif ($mode == 'quarterly') {
               $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, QUARTER(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) qt, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
               $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), QUARTER(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
               $orderby = "yr ASC,qt ASC";
            } elseif ($mode == 'yearly') {
                $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
                $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
                $orderby = "yr ASC";
            }

            $sql1 = 'SELECT Easycase.id,Easycase.user_id,Easycase.project_id,Easycase.dt_created,Easycase.actual_dt_created,Easycase.priority,'
                        . 'Easycase.due_date,Easycase.type_id,Easycase.legend,'
                        . 'SUM(case when Easycase.legend != 5 AND Easycase.legend != 3  then 1 else 0 end) as created,SUM(case when Easycase.legend = 5 OR Easycase.legend = 3  then 1 else 0 end) as resolve'.$extraFields.' FROM easycases Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND Easycase.type_id !=10 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' AND DATE(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'")) > "' . $start_dt . '" AND DATE(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'")) <= "' . date('Y-m-d',strtotime($curDateTime)) . '" GROUP BY '.$grpby.' ORDER BY '.$orderby ;
           //print $sql1;exit;
            $caseNew_all = $this->Easycase->query($sql1);
        }else if ($prjUniqIdCsMenu == 'all') {
            
        }
        $chart = $result = array();
       if(count($caseNew_all) > 0){
       
           $period = new DatePeriod(
                new DateTime(date('Y-m-d',strtotime('+1 day',strtotime($start_dt)))),
                new DateInterval('P1D'),
                new DateTime(date('Y-m-d',strtotime("+1 days")))
           );
           
        foreach($caseNew_all as $k=>$v){
                $result[$k] = $v;  
                if($k != 0){
                   $result[$k][0]['created'] = $v['0']['created'] + $result[($k-1)][0]['created'];    
                   $result[$k][0]['resolve'] = $v['0']['resolve'] + $result[($k-1)][0]['resolve'];    
                }
            if ($mode == 'weekly') {
                    $chart['rdate_row']['created'][$v[0]['wk'].'-'.$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['wk'].'-'.$v[0]['yr']] =  $result[$k][0]['resolve'];
            }else if($mode == 'monthly'){
                    $chart['rdate_row']['created'][$v[0]['mt'].'-'.$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['mt'].'-'.$v[0]['yr']] =  $result[$k][0]['resolve'];
            }else if($mode == 'quarterly'){
                    $chart['rdate_row']['created'][$v[0]['qt'].'-'.$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['qt'].'-'.$v[0]['yr']] =  $result[$k][0]['resolve'];
            }else if($mode == 'yearly'){
                    $chart['rdate_row']['created'][$v[0]['yr']] =  $result[$k][0]['created'];
                    $chart['rdate_row']['resolved'][$v[0]['yr']] =  $result[$k][0]['resolve'];
            }else{
                     $chart['rdate_row']['created'][strtotime($v[0]['dt'])] =  $result[$k][0]['created'];
                     $chart['rdate_row']['resolved'][strtotime($v[0]['dt'])] =  $result[$k][0]['resolve'];
            }
            }
            $chart['xaxis'] = array();
            foreach ($period as $key => $value) {
               $cur_day = $value->format('Y-m-d');
               $cur_day_s = strtotime($cur_day);
               if ($mode == 'weekly') {
                    $cur_weeks = ltrim(date('W',strtotime($cur_day)),0).'-'.date('Y',strtotime($cur_day));

                    if(!in_array($value->format('W').' Week, '.$value->format('Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_weeks])?$chart['rdate_row']['created'][$cur_weeks]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_weeks])?$chart['rdate_row']['resolved'][$cur_weeks]:0;
                        $chart['xaxis'][] = $value->format('W').' Week, '.$value->format('Y') ;
        }
               }else if ($mode == 'monthly') {
                    $cur_month = date('n',strtotime($cur_day)).'-'.date('Y',strtotime($cur_day));
                    if(!in_array($value->format('M,Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_month])?$chart['rdate_row']['created'][$cur_month]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_month])?$chart['rdate_row']['resolved'][$cur_month]:0;
                        $chart['xaxis'][] = $value->format('M,Y') ;
                    }
               }else if ($mode == 'quarterly') {
                   $qtrr = ceil(date('n',strtotime($cur_day))/3);
                    $cur_qtr = $qtrr.'-'.date('Y',strtotime($cur_day));
                    if(!in_array($qtrr.' Qtr, '.$value->format('Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_qtr])?$chart['rdate_row']['created'][$cur_qtr]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_qtr])?$chart['rdate_row']['resolved'][$cur_qtr]:0;
                        $chart['xaxis'][] = $qtrr.' Qtr, '.$value->format('Y') ;
                    }
               }else if ($mode == 'yearly') {
                    $cur_year = date('Y',strtotime($cur_day));
                    if(!in_array($value->format('Y'), $chart['xaxis'])){
                        $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_year])?$chart['rdate_row']['created'][$cur_year]:0;
                        $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_year])?$chart['rdate_row']['resolved'][$cur_year]:0;
                        $chart['xaxis'][] = $value->format('Y') ;
                    }
               }else{
                $chart['rdate']['created'][] = ($chart['rdate_row']['created'][$cur_day_s])?$chart['rdate_row']['created'][$cur_day_s]:0;
                $chart['rdate']['resolved'][] = ($chart['rdate_row']['resolved'][$cur_day_s])?$chart['rdate_row']['resolved'][$cur_day_s]:0;
                $chart['xaxis'][] = $value->format('d M,Y') ;
               }
            }
            if(count($chart['xaxis']) > 15){
                $chart['interval'] = ceil(count($chart['xaxis'])/15);  
                if ($mode == 'weekly') {
                    $chart['interval'] = $chart['interval']*2;
                }
            }else{
                  $chart['interval'] =1;
            }
            
       }
        
        $resultCases['result'] = $result;
        $resultCases['chart'] = $chart;
        echo json_encode($resultCases);exit;
    }
    }
    function resolution_time_report(){
        if(!$this->Format->isAllowed('View Resolution Time Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        if($this->request->is('ajax')){
            $proj_id = NULL;
            $prjUniqIdCsMenu = $this->params->data['pid'];
            $mode = $this->params->data['mode'];
            $qty = $this->params->data['qty'];
            $filters = '';
            $curDateTime = date('Y-m-d H:i:s');
            $start_dt = date('Y-m-d', strtotime($curDateTime . ' -' . $qty . ' days'));
            $searchcase = '';
            $clt_sql = 1;
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") "
                        . "OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
            $resultCases = array();
            if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
                $this->Project->recursive = -1;
                $projArr = $this->Project->find('first', array(
                    'conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                    'fields' => array('Project.id')
                ));
                if (count($projArr)) {
					$this->Project->updateRptVisited($prjUniqIdCsMenu, SES_ID, SES_COMP);
                    $proj_id = $projArr['Project']['id'];
                }
                if (!$proj_id) {
                    die;
                }
                 /** Mysql check timezone **/
                    $this->loadModel('TimezoneName');
                    $tmz=$this->TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
                    $tmz=  str_replace(array("GMT","(",")"), "", $tmz);
                    $gmt_val = "+00:00";
                /* End*/
                $extraFields = ", DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt ";
                $grpby = "DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
                $orderby = "dt ASC";
                if ($mode == 'weekly') {
                    $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, WEEK(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) wk , DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt ";
                    $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), WEEK(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";   
                    $orderby = "yr ASC,wk ASC";
                } elseif ($mode == 'monthly') {
                    $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, MONTH(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) mt, DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt  ";
                    $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), MONTH(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))"; 
                    $orderby = "yr ASC,mt ASC";
                } elseif ($mode == 'quarterly') {
                   $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr, QUARTER(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) qt , DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt ";
                   $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')), QUARTER(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
                   $orderby = "yr ASC,qt ASC";
                } elseif ($mode == 'yearly') {
                    $extraFields = ", YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) yr , DATE(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')) dt ";
                    $grpby = "YEAR(CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz'))";
                    $orderby = "yr ASC";
                }
                $sql1 = 'SELECT Easycase.id,Easycase.project_id,SUM(case when Easycase.legend = 5 OR Easycase.legend = 3  then 1 else 0 end) as resolve,'
                        . 'SUM(case when Easycase.legend = 5 OR Easycase.legend = 3  then  (case when (DATEDIFF(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'"),CONVERT_TZ(Easycase.actual_dt_created,"'.$gmt_val.'","'.$tmz.'")) = 0) THEN 1 ELSE DATEDIFF(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'"),CONVERT_TZ(Easycase.actual_dt_created,"'.$gmt_val.'","'.$tmz.'")) END) else 0 end ) AS durations  '.$extraFields. ' '
                        . 'FROM easycases AS Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND Easycase.type_id !=10 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' AND DATE(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'")) > "' . $start_dt . '" AND DATE(CONVERT_TZ(Easycase.dt_created,"'.$gmt_val.'","'.$tmz.'")) <= "' . date('Y-m-d',strtotime($curDateTime)) . '" '
                        . 'GROUP BY '.$grpby.' ORDER BY '.$orderby;
                //print $sql1;exit;
                $caseNew_all = $this->Easycase->query($sql1);
            }else if ($prjUniqIdCsMenu == 'all') {
            }
            $result = array();
            $chart = array();
            if(count($caseNew_all) > 0){
                 $period = new DatePeriod(
                new DateTime(date('Y-m-d',strtotime('+1 day',strtotime($start_dt)))),
                    new DateInterval('P1D'),
                new DateTime(date('Y-m-d',strtotime("+1 days")))
               );
			   $cnt = 0;
            foreach($caseNew_all as $k=>$v){
				if($v[0]['resolve'] != 0 || $v[0]['durations'] !=0){
					$result[$cnt] = $v;  
					$result[$cnt][0]['average'] = ($v[0]['resolve'] != 0 && $v[0]['durations'] !=0)?$v[0]['durations']/$v[0]['resolve'] :0;
					$result[$cnt][0]['average'] = round($result[$cnt][0]['average']);					
					if ($mode == 'weekly') {
							$chart['rdate_row'][$v[0]['wk'].'-'.$v[0]['yr']] =  $result[$cnt][0]['average'];
					}else if($mode == 'monthly'){
							$chart['rdate_row'][$v[0]['mt'].'-'.$v[0]['yr']] =  $result[$cnt][0]['average'];
					}else if($mode == 'quarterly'){
							$chart['rdate_row'][$v[0]['qt'].'-'.$v[0]['yr']] =  $result[$cnt][0]['average'];
					}else if($mode == 'yearly'){
							$chart['rdate_row'][$v[0]['yr']] =  $result[$cnt][0]['average'];
					}else{
							 $chart['rdate_row'][strtotime($v[0]['dt'])] =  $result[$cnt][0]['average'];
					}
					$cnt++;
				}
            }
                $chart['xaxis'] = array();
                foreach ($period as $key => $value) {
                   $cur_day = $value->format('Y-m-d');
                   $cur_day_s = strtotime($cur_day);
                   if ($mode == 'weekly') {
                        $cur_weeks = ltrim(date('W',strtotime($cur_day)),0).'-'.date('Y',strtotime($cur_day));
            
                        if(!in_array($value->format('W').' Week, '.$value->format('Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_weeks])?$chart['rdate_row'][$cur_weeks]:0;
                            $chart['xaxis'][] = $value->format('W').' Week, '.$value->format('Y') ;
                        }
                   }else if ($mode == 'monthly') {
                        $cur_month = date('n',strtotime($cur_day)).'-'.date('Y',strtotime($cur_day));
                        if(!in_array($value->format('M,Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_month])?$chart['rdate_row'][$cur_month]:0;
                            $chart['xaxis'][] = $value->format('M,Y') ;
                        }
                   }else if ($mode == 'quarterly') {
                       $qtrr = ceil(date('n',strtotime($cur_day))/3);
                        $cur_qtr = $qtrr.'-'.date('Y',strtotime($cur_day));
                        if(!in_array($qtrr.' Qtr, '.$value->format('Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_qtr])?$chart['rdate_row'][$cur_qtr]:0;
                            $chart['xaxis'][] = $qtrr.' Qtr, '.$value->format('Y') ;
                        }
                   }else if ($mode == 'yearly') {
                        $cur_year = date('Y',strtotime($cur_day));
                        if(!in_array($value->format('Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_year])?$chart['rdate_row'][$cur_year]:0;
                            $chart['xaxis'][] = $value->format('Y') ;
                        }
                   }else{
                    $chart['rdate'][] = ($chart['rdate_row'][$cur_day_s])?$chart['rdate_row'][$cur_day_s]:0;
                    $chart['xaxis'][] = $value->format('d M,Y') ;
                   }
                }
                if(count($chart['xaxis']) > 15){
                  $chart['interval'] = ceil(count($chart['xaxis'])/15);  
                  if ($mode == 'weekly') {
                      $chart['interval'] = $chart['interval']*2;
                  }
                }else{
                    $chart['interval'] =1;
                }
            }
            $resultCases['result'] = $result;
            $resultCases['chart'] = $chart;
            echo json_encode($resultCases);exit;
        }  
    }
    function time_since_report(){
        if(!$this->Format->isAllowed('View Time Since Task Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        if($this->request->is('ajax')){
            $proj_id = NULL;
            $prjUniqIdCsMenu = $this->params->data['pid'];
            $mode = $this->params->data['mode'];
            $qty = $this->params->data['qty'];
            $date_fields = $this->params->data['date_fields'];
            $cumulative = $this->params->data['cumulative'];
            $filters = '';
            $curDateTime = date('Y-m-d H:i:s');
            $start_dt = date('Y-m-d', strtotime($curDateTime . ' -' . $qty . ' days'));
            $searchcase = '';
            $clt_sql = 1;
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") "
                        . "OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
            $resultCases = array();
            if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
                $this->Project->recursive = -1;
                $projArr = $this->Project->find('first', array(
                    'conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                    'fields' => array('Project.id','Project.status_group_id')
                ));
                if (count($projArr)) {
					$this->Project->updateRptVisited($prjUniqIdCsMenu, SES_ID, SES_COMP);
                    $proj_id = $projArr['Project']['id'];
                }
                if (!$proj_id) {
                    die;
                }
                /** Mysql check timezone **/
                    $this->loadModel('TimezoneName');
                    $tmz=$this->TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
                    $tmz=  str_replace(array("GMT","(",")"), "", $tmz);
                    $gmt_val = "+00:00";
                /* End*/
                $group_field = "CONVERT_TZ(Easycase.dt_created,'$gmt_val','$tmz')";
                if($date_fields == "created"){
                    $group_field = "CONVERT_TZ(Easycase.actual_dt_created,'$gmt_val','$tmz')";
                }else if($date_fields == "due_date"){
                    $group_field = "CONVERT_TZ(Easycase.due_date,'$gmt_val','$tmz')";
                }
                
               $extraFields = ", DATE(".$group_field.") dt ";
                $grpby = "DATE(".$group_field.")";
                $orderby = "dt ASC";
                if ($mode == 'weekly') {
                    $extraFields = ", YEAR(".$group_field.") yr, WEEK(".$group_field.") wk , DATE(".$group_field.") dt";
                    $grpby = "YEAR(".$group_field."), WEEK(".$group_field.")";   
                    $orderby = "yr ASC,wk ASC";
                } elseif ($mode == 'monthly') {
                    $extraFields = ", YEAR(".$group_field.") yr, MONTH(".$group_field.") mt, DATE(".$group_field.") dt ";
                    $grpby = "YEAR(".$group_field."), MONTH(".$group_field.")"; 
                    $orderby = "yr ASC,mt ASC";
                } elseif ($mode == 'quarterly') {
                   $extraFields = ", YEAR(".$group_field.") yr, QUARTER(".$group_field.") qt, DATE(".$group_field.") dt ";
                   $grpby = "YEAR(".$group_field."), QUARTER(".$group_field.")";
                   $orderby = "yr ASC,qt ASC";
                } elseif ($mode == 'yearly') {
                    $extraFields = ", YEAR(".$group_field.") yr, DATE(".$group_field.") dt ";
                    $grpby = "YEAR(".$group_field.")";
                    $orderby = "yr ASC";
                }
                
                if($date_fields == "created"){
                    $date_fields_sql =  ',COUNT(Easycase.id) as result_data ';
                }else if($date_fields == "due_date"){
                   $date_fields_sql =  ',COUNT(Easycase.id) as result_data ';
                }else if($date_fields == "resolved"){
                  $date_fields_sql = ',SUM(case when Easycase.legend = 5 OR Easycase.legend = 3  then 1 else 0 end) as result_data ';
                }
               if($date_fields == 'updated'){ 
                    $sql1 = 'SELECT Easycase.case_no,Easycase.project_id'.$extraFields.',COUNT(Easycase.id) as result_data '
                        . 'FROM easycases AS Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 2 AND Easycase.type_id !=10 AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' AND DATE(CONVERT_TZ('.$group_field.',"'.$gmt_val.'","'.$tmz.'")) > "' . $start_dt . '" AND DATE(CONVERT_TZ('.$group_field.',"'.$gmt_val.'","'.$tmz.'")) <= "' . date('Y-m-d',strtotime($curDateTime)) . '" '
                        //. 'GROUP BY '.$grpby.' ORDER BY '.$orderby;
						.'GROUP BY '.$grpby.',Easycase.project_id,Easycase.case_no ORDER BY '.$orderby;
               }else{
                    $sql1 = 'SELECT Easycase.id,Easycase.project_id'.$extraFields.$date_fields_sql
                        . 'FROM easycases AS Easycase '
                        . 'WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND Easycase.type_id !=10 AND '.$clt_sql.' AND '.$clt_sql.' AND Easycase.project_id = '.$proj_id.' AND DATE(CONVERT_TZ('.$group_field.',"'.$gmt_val.'","'.$tmz.'")) > "' . $start_dt . '" AND DATE(CONVERT_TZ('.$group_field.',"'.$gmt_val.'","'.$tmz.'")) <= "' . date('Y-m-d',strtotime($curDateTime)) . '" '
                        . 'GROUP BY '.$grpby.' ORDER BY '.$orderby;
               }                
                $caseNew_all = $this->Easycase->query($sql1); 
                
            }else if ($prjUniqIdCsMenu == 'all') {
            }
            $chart =$result= $xaxis = array();
            if(count($caseNew_all) > 0){
                
                $period = new DatePeriod(
                new DateTime(date('Y-m-d',strtotime('+1 day',strtotime($start_dt)))),
                    new DateInterval('P1D'),
                new DateTime(date('Y-m-d',strtotime("+1 days")))
               );
			   if($date_fields == 'updated'){
					if($caseNew_all){
						$result_t = array();
						foreach($caseNew_all as $k => $v){
							if(empty($result_t)){
								$result_t[$v[0]['dt']]= $v;
							}else{
								if(isset($result_t[$v[0]['dt']])){
									$result_t[$v[0]['dt']][0]['result_data'] += 1;
								}else{
									$result_t[$v[0]['dt']]= $v;
								}
							}
						}
						$caseNew_all = array_values($result_t);
					}
				}
                foreach($caseNew_all as $k=>$v){
                    $result[$k] = $v;
                    if($k != 0 && $cumulative =='yes'){
                     $result[$k][0]['result_data'] = $result[$k][0]['result_data'] + $result[($k-1)][0]['result_data']; 
                         }
                    if ($mode == 'weekly') {
                        $chart['rdate_row'][$v[0]['wk'].'-'.$v[0]['yr']] =  $result[$k][0]['result_data'];
                    }else if ($mode == 'monthly') {
                        $chart['rdate_row'][$v[0]['mt'].'-'.$v[0]['yr']] =  $result[$k][0]['result_data'];
                    }else if ($mode == 'quarterly') {
                        $chart['rdate_row'][$v[0]['qt'].'-'.$v[0]['yr']] =  $result[$k][0]['result_data'];
                    }else if ($mode == 'yearly') {
                        $chart['rdate_row'][$v[0]['yr']] =  $result[$k][0]['result_data'];
                }else{
                         $chart['rdate_row'][strtotime($v[0]['dt'])] =  $result[$k][0]['result_data'];
                    }
                }
				
				$chart['xaxis'] = array();
				foreach ($period as $key => $value) {
                   $cur_day = $value->format('Y-m-d');
                   $cur_day_s = strtotime($cur_day);
                    if ($mode == 'weekly') {
                        $cur_weeks = ltrim(date('W',strtotime($cur_day)),0).'-'.date('Y',strtotime($cur_day));
                        
                        if(!in_array($value->format('W').' Week, '.$value->format('Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_weeks])?$chart['rdate_row'][$cur_weeks]:0;
                            $chart['xaxis'][] = $value->format('W').' Week, '.$value->format('Y') ;
                        }
                    }else if($mode == 'monthly'){
                        $cur_month = date('n',strtotime($cur_day)).'-'.date('Y',strtotime($cur_day));
                        if(!in_array($value->format('M,Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_month])?$chart['rdate_row'][$cur_month]:0;
                            $chart['xaxis'][] = $value->format('M,Y') ;
                        }
                    }else if($mode == 'quarterly'){
                       $qtrr = ceil(date('n',strtotime($cur_day))/3);
                        $cur_qtr = $qtrr.'-'.date('Y',strtotime($cur_day));
                        if(!in_array($qtrr.' Qtr, '.$value->format('Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_qtr])?$chart['rdate_row'][$cur_qtr]:0;
                            $chart['xaxis'][] = $qtrr.' Qtr, '.$value->format('Y') ;
                        }
                    }else if($mode == 'yearly'){
                        $cur_year = date('Y',strtotime($cur_day));
                        if(!in_array($value->format('Y'), $chart['xaxis'])){
                            $chart['rdate'][] = ($chart['rdate_row'][$cur_year])?$chart['rdate_row'][$cur_year]:0;
                            $chart['xaxis'][] = $value->format('Y') ;
                        }
                    }else{
                    $chart['rdate'][] = ($chart['rdate_row'][$cur_day_s])?$chart['rdate_row'][$cur_day_s]:0;
                    $chart['xaxis'][] = $value->format('d M,Y') ;
                    }
                }
                
                if(count($chart['xaxis']) > 15){
                  $chart['interval'] = ceil(count($chart['xaxis'])/15);  
                  if ($mode == 'weekly') {
                      $chart['interval'] = $chart['interval']*2;
            }
                }else{
                    $chart['interval'] =1;
                }
                
            }
			$resultCases['result'] = $result;
            $resultCases['chart'] = $chart;
            echo json_encode($resultCases);
            exit;
        }
        
    }
    function completed_sprint_report(){
        if(!$this->Format->isAllowed('View Sprint Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        if(isset($this->request->params['pass'][0]) && !empty($this->request->params['pass'][0])){
            $puid = $this->request->params['pass'][0];
            $this->LoadModel("Project");
            $projs = $this->Project->find('first',array('conditions'=>array('Project.uniq_id'=>$puid,'Project.company_id'=>SES_COMP),'fields'=>array('Project.id')));
            if(!empty($projs)){
                $this->set('projectID',$projs['Project']['id']);
            }
        }
        if(isset($this->request->params['pass'][1]) && !empty($this->request->params['pass'][1])){
            $this->set('sprintID',$this->request->params['pass'][1]);
        }
        
    }

    function get_all_sprints(){
        $arr['status'] = 0;
        $arr['msg'] = 'No records found';
        $pid = $this->request->data['pid'];
        $cond = array('Milestone.project_id'=>$pid,'Milestone.company_id'=>SES_COMP);
        if(isset($this->request->data['type']) && !empty($this->request->data['type'])){
            $cond['Milestone.is_started'] = 1;
            //$cond['Milestone.isactive'] = 1;
        }
        if(!empty($pid)){
            $this->loadModel('Milestone');
            $all_sprints = $this->Milestone->find('all', array('conditions'=>$cond,'order'=>array('Milestone.modified DESC'))); //'Milestone.isactive'=>0,
            $arr['status'] = 1;
            $arr['records'] = $all_sprints;
        }
        echo json_encode($arr);
        exit;
    }

    function create_sprint_report(){
        $arr['status'] = 0;
        $arr['msg'] = 'No records found';

        $pid = $this->request->data['pid'];
        $milestone_id = $this->request->data['mode'];

        if(!empty($pid) && !empty($milestone_id)){
            $this->loadModel('SprintCompleteReport');
            $curProjId = $pid;
            $mid = $milestone_id;
            $this->LoadModel('Milestone');
        ############Decleration of Variables ###############
        $resCaseProj = array();
        $this->_datestime();
        $this->loadModel('Project');
        $projes = $this->Project->find('first',array('conditions'=>array('Project.id'=>$pid),'fields'=>array('Project.uniq_id','Project.status_group_id')));
        $projUniq =  $projes['Project']['uniq_id']; // Project Uniq ID
        $projStatusGrp =  $projes['Project']['status_group_id']; // Project Uniq ID
       
       // $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
        $caseDate = $this->params->data['caseDate']; // Sort by Date
        //$caseSrch = $this->params->data['caseSearch']; // Search by keyword

        $casePage = $this->params->data['casePage']; // Pagination        
        $caseMenuFilters = $this->params->data['caseMenuFilters']; // Resolve Case
        $filterenabled = 0;
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        #######################Order By##################################
        // Order by
        $sortby = '';
        $caseStatusby = '';
        $caseUpdatedby = '';
        $casePriority = '';
        if (isset($_COOKIE['TASKSORTBY'])) {
            $sortby = $_COOKIE['TASKSORTBY'];
            $sortorder = $_COOKIE['TASKSORTORDER'];
        } else {
            $sortorder = 'DESC';
        }
        $caseUpdatedby = strtolower($sortorder);
        $orderby = " EasycaseMilestone.id_seq ASC, Easycase.seq_id ASC ";
        #pr ($orderby);exit;
        #################End of Order by#################################
        ##########Set the result array for search and pagination variables ##################
        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        //$resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        ##########End the result array for search and pagination variables ##################  
        ################Filter Starts#################################
        $qry = '';
        $all_rest = '';
        $qry_rest = '';
        #######################Search by filter Date#######################          
        if (trim($case_date) != "") {
            $filterenabled = 1;
            $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " -1 day"));
            $qry.= " AND (Easycase.dt_created >='" . $day_date . "')";
        }       
        $qry.= $this->Format->getBacklogFilter($this->params->data['bkFilters'],$curProjId);
       

        $searchMilestone = "";
        
        $searchMilestone .=$qry;

        if ($mid) {
            $extra_where = " WHERE Easycase.isactive=1 AND Easycase.istype=1 AND EasycaseMilestone.project_id='{$curProjId}' AND EasycaseMilestone.milestone_id='{$mid}' " . $searchMilestone;
        } else {
            $extra_where = " WHERE Easycase.isactive=1 AND Easycase.istype=1 AND Easycase.project_id='{$curProjId}' AND Easycase.id NOT IN (select EasycaseMilestones.easycase_id from easycase_milestones as EasycaseMilestones WHERE EasycaseMilestones.project_id='" . $curProjId . "') " . $searchMilestone;
        }

        $sql = "SELECT SQL_CALC_FOUND_ROWS "
                . "Easycase.*, "
                . "EasycaseMilestone.milestone_id as mid, "
                . "User.short_name, "
                . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned, Project.short_name "
                . "FROM easycases AS Easycase "
                . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                . "LEFT JOIN projects Project ON Easycase.project_id=Project.id "
                . "LEFT JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id "
                . $extra_where
                . " ORDER BY " . $orderby;
        $caseAll_records = $this->Easycase->query($sql);

        $this->LoadModel('SprintCompleteReport');

        $this->SprintCompleteReport->bindModel(array('belongsTo' => array('Project'=>array('fields'=>array('Project.short_name')))));
        $caseAll_records1 = $this->SprintCompleteReport->find('all',array('conditions'=>array('SprintCompleteReport.milestone_id'=>$milestone_id,'SprintCompleteReport.project_id'=>$pid))); 
       // $eids = array();
       //  foreach($records as $k=>$v){
       //      $eids[$k] = $v['SprintCompleteReport']['task_id'];
       //  }
    //     if(!empty($eids)){
    //     $sql1 = "SELECT SQL_CALC_FOUND_ROWS "
    //             . "Easycase.*, "
    //             . "EasycaseMilestone.milestone_id as mid, "
    //             . "User.short_name, "
    //             . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned "
    //             . "FROM easycases AS Easycase "
    //             . "LEFT JOIN users User ON Easycase.assign_to=User.id "
    //             . "LEFT JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id "
    //             . " WHERE Easycase.id in( ".implode(',',$eids).") "
    //             . " ORDER BY " . $orderby;
    //     $caseAll_records1 = $this->Easycase->query($sql1);
    //      print_r($caseAll_records1);exit;
    // }else{
    //     $caseAll_records1 = array();
    // }


        #pr($sql);exit;
        /*         * *Manipulate results**** */
        if ($projUniq != 'all') {
            $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id='" . $curProjId . "' AND Easycase.isactive='1' AND Easycase.istype IN('1','2') ORDER BY User.short_name");
        } else {
            $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') AND Easycase.isactive='1' AND Easycase.istype IN('1','2') ORDER BY User.short_name");
        }
        $usrDtlsArr = array();
        $usrDtlsPrj = array();
        foreach ($usrDtlsAll as $ud) {
            $usrDtlsArr[$ud['User']['id']] = $ud;
        }
        $m = array();
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        //$caseMenuFilters = "milestone";
        $CaseCount = count($caseAll_records);
        $CaseCount1 = count($caseAll_records1);

        foreach ($caseAll_records as $k => $v) {
            $m[$v['Milestone']['id']]['id'] = $v['EasycaseMilestone']['mid'];
            $m[$v['Milestone']['id']]['caseids'] = $v[0]['caseids'];
            $m[$v['Milestone']['id']]['totalcases'] = $v[0]['totalcases'];
            $m[$v['Milestone']['id']]['title'] = $v['Milestone']['title'];
            $m[$v['Milestone']['id']]['project_id'] = $v['Milestone']['project_id'];
            $m[$v['Milestone']['id']]['end_date'] = $v['Milestone']['end_date'];
            $m[$v['Milestone']['id']]['uinq_id'] = $v['Milestone']['uniq_id'];
            $m[$v['Milestone']['id']]['isactive'] = $v['Milestone']['isactive'];
            $m[$v['Milestone']['id']]['user_id'] = $v['Milestone']['user_id'];
        }

        $c = array();
        if ($mid) {
            $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN(" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
            foreach ($closed_cases as $key => $val) {
                $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
            }
        }


        // $frmtCaseAll = $this->Easycase->formatCases($caseAll_records, $CaseCount, $caseMenuFilters, $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq);

        // $frmtCaseAllUnresolved = $this->Easycase->formatCases($caseAll_records1, $CaseCount1, $caseMenuFilters, $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq);
        /*         * *End of manipulations**** */

        $view = new View($this);
            $tz = $view->loadHelper('Tmzone');
            $dt = $view->loadHelper('Datetime');
            $cq = $view->loadHelper('Casequery');

        $this->loadModel('TypeCompany');
         if (!defined(SES_COMP)) {
                $sql = "SELECT Type.* FROM types AS Type";
            } else {
                $sql = "SELECT Type.* FROM types AS Type WHERE Type.company_id = 0 OR Type.company_id =" . SES_COMP;
            }
            $typeArr = $this->TypeCompany->query($sql);
            //print_r($typeArr);exit;
            $tps = array();
            foreach($typeArr as $k=>$v){
                $tps[$v['Type']['id']] = $v['Type']['name'];
            }
            #pr($caseAll_records1);exit;

		    $csts_arr = array();
			//custom status ref for other pages	
			if($projStatusGrp){
				$Csts = ClassRegistry::init('CustomStatus');
				$csts_arr = $Csts->find('all',array('conditions'=>array('CustomStatus.status_group_id'=>$projStatusGrp)));
				if($csts_arr){
					$csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
				}
			}
			#pr($csts_arr);exit;
            //pr($caseAll_records1);exit;
            if(count($caseAll_records1)){
        foreach ($caseAll_records1 as $key => $value) {
            if($value['SprintCompleteReport']['is_type']== 1){
              $resCaseProj['caseAll'][$key] =   $value['SprintCompleteReport'];
              $resCaseProj['caseAll'][$key]['Easycase'] =  json_decode($value['SprintCompleteReport']['tasks_detail']);
              $t_id = $resCaseProj['caseAll'][$key]['Easycase']->Easycase->type_id;  
              $resCaseProj['caseAll'][$key]['Easycase']->Easycase->type_name = $tps[$t_id];
              $resCaseProj['caseAll'][$key]['Easycase']->Project->short_name = $value['Project']['short_name'];

            }else if($value['SprintCompleteReport']['is_type']== 2){
              $resCaseProj['caseAllOut'][$key] =   $value['SprintCompleteReport'];
              $resCaseProj['caseAllOut'][$key]['Easycase'] =  json_decode($value['SprintCompleteReport']['tasks_detail']);
              $t_id = $resCaseProj['caseAllOut'][$key]['Easycase']->Easycase->type_id; 
             // echo $t_id."<br />"; 
              $resCaseProj['caseAllOut'][$key]['Easycase']->Easycase->type_name = $tps[$t_id];
              $resCaseProj['caseAllOut'][$key]['Easycase']->Project->short_name = $value['Project']['short_name'];

            }else{
              $resCaseProj['caseAllUnresolved'][$key] =   $value['SprintCompleteReport'];
              $resCaseProj['caseAllUnresolved'][$key]['Easycase'] =  json_decode($value['SprintCompleteReport']['tasks_detail']);
              $t_id = $resCaseProj['caseAllUnresolved'][$key]['Easycase']->Easycase->type_id; 
              $resCaseProj['caseAllUnresolved'][$key]['Easycase']->Easycase->type_name = $tps[$t_id];
              $resCaseProj['caseAllUnresolved'][$key]['Easycase']->Project->short_name = $value['Project']['short_name'];

            }
        }
            }else if(count($caseAll_records)){
                foreach ($caseAll_records as $key => $value) {
                    $v['SprintCompleteReport']['milestone_id'] = $value['EasycaseMilestone']['mid'];
                    $v['SprintCompleteReport']['project_id'] = $value['Easycase']['project_id'];
                    $v['SprintCompleteReport']['task_id'] = $value['Easycase']['id'];
                    $v['SprintCompleteReport']['tasks_detail'] = json_encode($value);
                    $v['SprintCompleteReport']['move_count'] = 1;
                    $v['SprintCompleteReport']['created'] = $value['Easycase']['dt_created'];
                    $v['SprintCompleteReport']['short_name'] = $value['Project']['short_name'];

                    if(($projStatusGrp != 0 && $value['Easycase']['custom_status_id'] == 3) || 
                        ($projStatusGrp == 0 && in_array($value['Easycase']['legend'], array(3,5)))
                ){
                      $v['SprintCompleteReport']['is_type'] = 1;
                      $resCaseProj['caseAll'][$key] =   $v['SprintCompleteReport'];
                      $resCaseProj['caseAll'][$key]['Easycase'] =  json_decode($v['SprintCompleteReport']['tasks_detail']);
                      $t_id = $resCaseProj['caseAll'][$key]['Easycase']->Easycase->type_id;  
                      $resCaseProj['caseAll'][$key]['Easycase']->Easycase->type_name = $tps[$t_id];

                    }else{
                      $v['SprintCompleteReport']['is_type'] = 0;
                      $resCaseProj['caseAllOut'][$key] =   $v['SprintCompleteReport'];
                      $resCaseProj['caseAllUnresolved'][$key]['Easycase'] =json_decode($v['SprintCompleteReport']['tasks_detail']);
                      $t_id = $resCaseProj['caseAllUnresolved'][$key]['Easycase']->Easycase->type_id; 
                     // echo $t_id."<br />"; 
                      $resCaseProj['caseAllUnresolved'][$key]['Easycase']->Easycase->type_name = $tps[$t_id];

            }
        }
            }
        //print_r($resCaseProj);exit;

        // $resCaseProj['caseAll'] = $frmtCaseAll['caseAll'];        
        
        // $related_tasks = array();
        /*if (is_array($caseAll_records) && count($caseAll_records) > 0) {
            $parent_task_id = array_filter(Hash::combine($caseAll_records, '{n}.Easycase.id', '{n}.Easycase.parent_task_id'));
            $related_tasks = !empty($parent_task_id) ? $this->Easycase->getSubTasks($parent_task_id) : array();
        }*/
        // $resCaseProj['related_tasks'] = $related_tasks;
        // $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        // $friday = date('Y-m-d', strtotime($curCreated . "next Friday"));
        // $monday = date('Y-m-d', strtotime($curCreated . "next Monday"));
        // $tomorrow = date('Y-m-d', strtotime($curCreated . "+1 day"));

        // $resCaseProj['intCurCreated'] = strtotime($curCreated);
        // $resCaseProj['mdyCurCrtd'] = date('m/d/Y', strtotime($curCreated));
        // $resCaseProj['mdyFriday'] = date('m/d/Y', strtotime($friday));
        // $resCaseProj['mdyMonday'] = date('m/d/Y', strtotime($monday));
        // $resCaseProj['mdyTomorrow'] = date('m/d/Y', strtotime($tomorrow));
        // $resCaseProj['GrpBy'] = 'milestone';
        // $resCaseProj['isCompleted'] = 1;

        // $milestoens = $this->Milestone->find('list', array('conditions' => array('Milestone.id' => $mid), 'fields' => array('Milestone.id', 'Milestone.isactive')));
        // $resCaseProj['milesto_names']['mid'] = $mid;
        // $resCaseProj['mid'] = $mid;
        // $resCaseProj['milesto_names']['isactive'] = $milestoens[$mid];
        
        // $resCaseProj1= $resCaseProj;
        // $resCaseProj1['caseAll'] = $frmtCaseAllUnresolved['caseAll'];
        // $resCaseProj1['isCompleted'] = 2;
        //print_r($resCaseProj);exit;

        $this->loadModel('ProjectSetting');
        $velo = $this->ProjectSetting->find('first',array('conditions'=>array('ProjectSetting.project_id'=>$pid),'fields'=>array('ProjectSetting.velocity_reports')));

         $arr['status'] = 1;
         $arr['result']['caseAll'] =($resCaseProj['caseAllUnresolved'])?$resCaseProj['caseAllUnresolved']:array();
         $arr['result']['isCompleted'] = 0;
         $arr['result']['velocity'] = $velo['ProjectSetting']['velocity_reports'];
		 $arr['result']['customSts'] = $csts_arr;

         $arr['result1']['caseAll'] =($resCaseProj['caseAll'])?$resCaseProj['caseAll']:array();
         $arr['result1']['isCompleted'] = 1;
         $arr['result1']['velocity'] = $velo['ProjectSetting']['velocity_reports'];
		 $arr['result1']['customSts'] = $csts_arr;

         $arr['result2']['caseAll'] =($resCaseProj['caseAllOut'])?$resCaseProj['caseAllOut']:array();
         $arr['result2']['isCompleted'] = 2;
         $arr['result2']['velocity'] = $velo['ProjectSetting']['velocity_reports'];
         $arr['result2']['customSts'] = $csts_arr;

          $this->loadModel('SprintSetting');
          $ss = $this->SprintSetting->find('first',array('conditions'=>array('SprintSetting.company_id'=>SES_COMP)));
          $ssp = isset($ss['SprintSetting']) && !empty($ss['SprintSetting']) ?$ss['SprintSetting']['is_active']:0;
          if($ssp ==1){
              $arr['any_completed'] = 0;
           }else{
             $this->loadModel('Milestone');            
              $checkQuery = "SELECT Milestone.id FROM milestones AS Milestone WHERE  Milestone.id !='".$milestone_id."' AND Milestone.company_id='".SES_COMP."' AND Milestone.isactive = 1 AND Milestone.is_started = 1 AND  Milestone.project_id='".$pid."'";
                $checkMstn = $this->Milestone->query($checkQuery); 
               if(count($checkMstn) && isset($checkMstn[0]['Milestone']['id']) && $checkMstn[0]['Milestone']['id']) {
                $arr['any_completed'] = 1;
               }else{
                $arr['any_completed'] = 0;
               }
           }
            

           $getMilestone = $this->Milestone->query("SELECT Milestone.start_date,Milestone.end_date,User.name,User.last_name,Milestone.created FROM milestones AS Milestone LEFT JOIN users AS User on Milestone.user_id=User.id WHERE Milestone.id = $milestone_id GROUP BY Milestone.id ");
            $name_ = $getMilestone[0]['User']['name'];
          if(count($caseAll_records1)){
            $start_date_ =  $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getMilestone[0]['Milestone']['start_date'], "datetime");
            $end_date_ = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getMilestone[0]['Milestone']['end_date'], "datetime");
            }else{
                $start_date_ =  $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getMilestone[0]['Milestone']['created'], "datetime");
                $end_date_ = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getMilestone[0]['Milestone']['created'], "datetime");
            }
            
           $start_date_ = date('d M, Y',strtotime($start_date_));
           $end_date_ = date('d M, Y',strtotime($end_date_));

           $arr['not_completed_count'] = count($arr['result']['caseAll']);

           if(count($caseAll_records1)){
           $arr['sprint_info'] = __("Closed sprint, by",true)." <strong>". $name_ ."</strong>  '<strong>". $start_date_ ."</strong> - <strong>". $end_date_ . "</strong>'";
           }else{
            $arr['sprint_info'] = __("Created sprint, by",true)." <strong>". $name_ ."</strong>  '<strong>". $start_date_ ."</strong>'";
           }

        }
        echo json_encode($arr);
        exit;
    }

    function remove_sprint(){
        $id = $this->request->data['id']; 
        if(isset($id) && $id){
            $this->loadModel('Milestone');
            $checkQuery = "SELECT Milestone.id, Milestone.title, Milestone.project_id FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id=".SES_ID." AND Milestone.id='".$id."' AND Milestone.company_id='".SES_COMP."'";
            $checkMstn = $this->Milestone->query($checkQuery);                        
            if(count($checkMstn) && isset($checkMstn[0]['Milestone']['id']) && $checkMstn[0]['Milestone']['id']) {
                $id = $checkMstn[0]['Milestone']['id'];
                $this->Milestone->delete($id);
                $this->loadModel('EasycaseMilestone');
                $this->EasycaseMilestone->query("DELETE FROM easycase_milestones WHERE milestone_id='".$id."'");
                $arr['err'] = 0;
                $arr['project_uid'] = $checkMstn[0]['Milestone']['project_id'];
                $arr['msg'] = "Sprint '".$checkMstn[0]['Milestone']['title']."' has been deleted.";
            } else {
                $arr['err'] = 1;
                $arr['msg'] = __("Oops! Error occured in deletion of Sprint.",true);
               
            }
        } else {
            $arr['err'] = 1;
            $arr['msg'] = __("Oops! Error occured in deletion of Sprint.",true);
        }
        echo json_encode($arr);exit;
    }


    function reopen_sprint(){
        $id = $this->request->data['id']; 
        $pid = $this->request->data['pid']; 
        if(isset($id) && $id){
          $this->loadModel('SprintSetting');
          $ss = $this->SprintSetting->find('first',array('conditions'=>array('SprintSetting.company_id'=>SES_COMP)));
          $ssp = isset($ss['SprintSetting']) && !empty($ss['SprintSetting']) ?$ss['SprintSetting']['is_active']:0;
        
            $this->loadModel('Milestone');            
            $checkQuery = "SELECT Milestone.id, Milestone.title, Milestone.project_id FROM milestones AS Milestone WHERE  Milestone.id !='".$id."' AND Milestone.company_id='".SES_COMP."' AND Milestone.isactive = 1 AND Milestone.is_started = 1 AND  Milestone.project_id='".$pid."'";
            $checkMstn = $this->Milestone->query($checkQuery); 
           if( $ssp == 0 && count($checkMstn) && isset($checkMstn[0]['Milestone']['id']) && $checkMstn[0]['Milestone']['id']) {
             $arr['err'] = 1;
             $arr['msg'] = __("Oops! Error occured in reopen of Sprint. Another sprint started.",true);
           }else{
              /* update milestone table **/
              $mdate = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d H:i:s'), "datetime");
              $this->Milestone->updateAll(array('Milestone.isactive'=>1,'Milestone.is_started'=>1,'Milestone.modified'=>"'".$mdate."'"),array('Milestone.id'=>$id)); 
              #remove record from Sprint Cmpleted reports and Update the in completed tasks.
              $this->LoadModel('SprintCompleteReport');
              $records = $this->SprintCompleteReport->find('all',array('conditions'=>array('SprintCompleteReport.milestone_id'=>$id,'SprintCompleteReport.project_id'=>$pid),'fields'=>array('SprintCompleteReport.task_id','SprintCompleteReport.id'))); 
           // $eids = array();
              $this->loadModel("EasycaseMilestone");
            foreach($records as $k=>$v){
                /* remove the task if in another milestone **/
                $this->EasycaseMilestone->deleteAll(array('EasycaseMilestone.easycase_id'=>$v['SprintCompleteReport']['task_id'],'EasycaseMilestone.project_id'=>$pid)); 
                $this->SprintCompleteReport->deleteAll(array('SprintCompleteReport.task_id'=>$v['SprintCompleteReport']['task_id'],'SprintCompleteReport.project_id'=>$pid,'SprintCompleteReport.milestone_id'=>$id));
                $this->EasycaseMilestone->create();
                $arr['EasycaseMilestone']['milestone_id'] =  $id;
                $arr['EasycaseMilestone']['easycase_id'] =  $v['SprintCompleteReport']['task_id'];
                $arr['EasycaseMilestone']['project_id'] =  $pid;
                $arr['EasycaseMilestone']['user_id'] =  SES_ID;
                $this->EasycaseMilestone->save($arr);

            }
            $arr['err'] = 0;
            $arr['msg'] = __("Sprint started successfully.",true);
           }

        }else{
            $arr['err'] = 1;
            $arr['msg'] = __("Oops! Error occured in reopen of Sprint.",true);
        }
        echo json_encode($arr);exit;
    }
    
    function velocity_reports(){
        if(!$this->Format->isAllowed('View Velocity Chart')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
		}
        if(isset($this->request->data['pid']) && !empty($this->request->data['pid'])){
            $pid =  $this->request->data['pid'];
            $this->loadModel('Project');
            $puid = $this->Project->find('first',array('conditions'=>array('Project.id'=>$pid),'fields'=>array('Project.uniq_id')));
            $this->loadModel('ProjectSetting');
            $ps = $this->ProjectSetting->find('first',array('conditions'=>array('ProjectSetting.project_id'=>$pid)));
            if(isset($ps['ProjectSetting']) && !empty($ps['ProjectSetting'])){
                $velocity_reports = $ps['ProjectSetting']['velocity_reports'];
            }else{
                $velocity_reports = 0;
            }
            $resultArr = $chartArr = array();
            $this->loadModel('SprintCompleteReport');
            $this->SprintCompleteReport->bindModel(array('belongsTo' => array('Milestone'=>array('fields'=>array('Milestone.title')))));
            $reports = $this->SprintCompleteReport->find('all',array('conditions'=>array('SprintCompleteReport.project_id'=>$pid,'Milestone.id !='=>''),'order'=>array('SprintCompleteReport.created'=> 'ASC')));
            if(count($reports) > 0){
                /* Build the Sprint array **/
                 foreach($reports as $k=>$v){
                    $mtitle = trim($v['Milestone']['title']);
                    $resultArr[$mtitle] = array('commited'=> 0,'completed'=>0);
                    $chartArr['xaxis'][$k] = $mtitle;
                 }
                 foreach ($reports as $k=>$v) {
                     $mtitle = trim($v['Milestone']['title']);
                     $mid_ =$v['SprintCompleteReport']['milestone_id'];
                     $commited = $completed = 0;
                     $easycase = json_decode($v['SprintCompleteReport']['tasks_detail'],true);
                     if($velocity_reports == 1){ // Estimated hour 
                        $commited =  (int) $easycase['Easycase']['estimated_hours'];
                        if($v['SprintCompleteReport']['is_type'] != 0){
                           $completed = (int) $easycase['Easycase']['estimated_hours'];
                        }

                     }else if($velocity_reports == 2){ // count
                         $commited =  1;
                         if($v['SprintCompleteReport']['is_type'] != 0){
                           $completed =  1;
                        }

                     }else{ //story point
                           $commited =  (int) $easycase['Easycase']['story_point'];
                         if($v['SprintCompleteReport']['is_type'] != 0){
                           $completed = (int) $easycase['Easycase']['story_point'];
                        }
                     }

                    $resultArr[$mtitle]['commited']  +=  $commited;
                    $resultArr[$mtitle]['completed']  +=  $completed;
                    $resultArr[$mtitle]['mid']  =  $mid_;

                 }
                
            }
            $chartArr['xaxis'] =  array_unique($chartArr['xaxis']);

            if($velocity_reports == 1){
                 $yaxis_text = "Original Time Estimate";
            }else if($velocity_reports == 2){
                 $yaxis_text = "Task Count";
            }else{
                 $yaxis_text = "Story Point";
            }
            $chartArr['yaxis_text'] = $yaxis_text;

            $total_completed_array = $total_commited_array =  array();
            foreach($resultArr as $k=>$v){
                if($velocity_reports == 1){
                 $total_commited_array[] =  $v['commited']*1000;
                 $total_completed_array[] =  $v['completed']*1000;
                }else{
                 $total_commited_array[] =  $v['commited'];
                 $total_completed_array[] =  $v['completed'];
               }
            }
            $chartArr['chart']['Commited'] = $total_commited_array;
            $chartArr['chart']['Completed'] =  $total_completed_array;

            $res['result'] = $resultArr;
            $res['puid'] = $puid['Project']['uniq_id'];
            $res['chart'] = $chartArr;
            echo json_encode($res);
            exit;
        }

    }
    function export_pdf_sprint(){
        ini_set('memory_limit','128M');
        set_time_limit(0);
        $this->layout='ajax';
        $postparams = $this->params->query;
        $uid=$this->Auth->user('id');
        $postparams['user_id']=$uid;
		
		$filename = "sprint_report_".$uid.time().".pdf";
		
		$postparams['SES_ID'] = SES_ID;
		$postparams['SES_TYPE'] = SES_TYPE;
		$postparams['SES_COMP'] = SES_COMP;
		
        $content = http_build_query($postparams); 		
        $filepath='"'.WWW_ROOT."pdfreports/tasks/".$filename.'"';
        $url='"'.HTTP_ROOT_INVOICE."project_reports/pdfsprint_report?".$content.'"';
        $cmdpath='"'.PDF_LIB_PATH.'"';
		
        $adcommand = '';
        $cmd = $cmdpath ." -O landscape ".$url." ".$filepath;
        exec($cmd);   
        $this->viewClass = 'Media';
        $params = array(
            'id'        => $filename,
            'name'      => $filename,
            'download'  => true,
            'extension' => 'pdf',
            'mimeType'  => array(
                'pdf' => 'application/pdf'
            ),
            'path'      => WWW_ROOT."pdfreports/tasks/"
        );
        $this->set($params);
    }
	function pdfsprint_report(){
		//ini_set('memory_limit','128M');
        //set_time_limit(0);
        $this->layout = 'ajax';
		
		$arr['status'] = 0;
        $arr['msg'] = 'No records found';
        $pid = (int)$this->params->query['projFil'];
        $milestone_id = (int)$this->params->query['mode'];
		
		$_ses_id = $this->params->query['SES_ID'];
		$_user_type = $this->params->query['SES_TYPE'];
		$_comp_id = $this->params->query['SES_COMP'];
		
		$this->loadModel('CompanyUser');
		$this->loadModel('User');
		$this->loadModel('Easycase');
		$this->loadModel('ProjectUser');
		
		$this->User->recursive = -1;
		$auth_user = $this->User->findById($_ses_id);
		if(empty($auth_user)){
			die(__('Invalid credential'));
		}
		$company_user = $this->CompanyUser->find('first', array("conditions" => array("CompanyUser.company_id" => $_comp_id, "CompanyUser.user_id" => $auth_user['User']['id'])));
		
		if(empty($company_user)){
			die(__('Invalid credential'));
		}
		
        if(!empty($pid) && !empty($milestone_id) && is_int($pid) && is_int($milestone_id)){
            $this->loadModel('SprintCompleteReport');
            $curProjId = $pid;
            $mid = $milestone_id;
            $this->LoadModel('Milestone');
        ############Decleration of Variables ###############
        $resCaseProj = array();
        $this->_datestime();
        $this->loadModel('Project');
        $projes = $this->Project->find('first',array('conditions'=>array('Project.id'=>$pid),'fields'=>array('Project.uniq_id','Project.name')));
        $projUniq =  $projes['Project']['uniq_id']; // Project Uniq ID
		
        $filterenabled = 0;
        $clt_sql = 1;
        if ($company_user['CompanyUser']['is_client'] == 1) {
            $clt_sql = "((Easycase.client_status = " . $company_user['CompanyUser']['is_client'] . " AND Easycase.user_id = " . $company_user['CompanyUser']['user_id'] . ") OR Easycase.client_status != " . $company_user['CompanyUser']['is_client'] . ")";
        }
        #######################Order By##################################
        // Order by
        $sortby = '';
        $caseStatusby = '';
        $caseUpdatedby = '';
        $casePriority = '';
        if (isset($_COOKIE['TASKSORTBY'])) {
            $sortby = $_COOKIE['TASKSORTBY'];
            $sortorder = $_COOKIE['TASKSORTORDER'];
        } else {
            $sortorder = 'DESC';
        }
        $caseUpdatedby = strtolower($sortorder);
        $orderby = " EasycaseMilestone.id_seq ASC, Easycase.seq_id ASC ";
        #pr ($orderby);exit;
        #################End of Order by#################################
		
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['filterenabled'] = $filterenabled;
        ##########End the result array for search and pagination variables
		
        $qry = '';
        $all_rest = '';
        $qry_rest = '';
        #######################Search by filter Date#######################          
        /*if (trim($case_date) != "") {
            $filterenabled = 1;
            $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " -1 day"));
            $qry.= " AND (Easycase.dt_created >='" . $day_date . "')";
        } */     

        $searchMilestone = "";        
        $searchMilestone .=$qry;

        if ($mid) {
            $extra_where = " WHERE Easycase.isactive=1 AND Easycase.istype=1 AND EasycaseMilestone.project_id='{$curProjId}' AND EasycaseMilestone.milestone_id='{$mid}' " . $searchMilestone;
        } else {
            $extra_where = " WHERE Easycase.isactive=1 AND Easycase.istype=1 AND Easycase.project_id='{$curProjId}' AND Easycase.id NOT IN (select EasycaseMilestones.easycase_id from easycase_milestones as EasycaseMilestones WHERE EasycaseMilestones.project_id='" . $curProjId . "') " . $searchMilestone;
        }

        $sql = "SELECT SQL_CALC_FOUND_ROWS "
                . "Easycase.*, "
                . "EasycaseMilestone.milestone_id as mid, "
                . "User.short_name, "
                . "IF((Easycase.assign_to =" . $_ses_id . "),'Me',User.short_name) AS Assigned,Project.short_name "
                . "FROM easycases AS Easycase "
                . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                . "LEFT JOIN projects Project ON Easycase.project_id=Project.id "
                . "LEFT JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id "
                . $extra_where
                . " ORDER BY " . $orderby;
        $caseAll_records = $this->Easycase->query($sql);

        $this->LoadModel('SprintCompleteReport');

        $this->SprintCompleteReport->bindModel(array('belongsTo' => array('Project'=>array('fields'=>array('Project.short_name')))));
        $caseAll_records1 = $this->SprintCompleteReport->find('all',array('conditions'=>array('SprintCompleteReport.milestone_id'=>$milestone_id,'SprintCompleteReport.project_id'=>$pid))); 
		
        /** *Manipulate results**** */
        if ($projUniq != 'all') {
            $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id='" . $curProjId . "' AND Easycase.isactive='1' AND Easycase.istype IN('1','2') ORDER BY User.short_name");
        } else {
            $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . $_ses_id . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . $_comp_id . "') AND Easycase.isactive='1' AND Easycase.istype IN('1','2') ORDER BY User.short_name");
        }
        $usrDtlsArr = array();
        $usrDtlsPrj = array();
        foreach ($usrDtlsAll as $ud) {
            $usrDtlsArr[$ud['User']['id']] = $ud;
        }
        $m = array();
        $clt_sql = 1;
        if ($company_user['CompanyUser']['is_client'] == 1) {
            $clt_sql = "((Easycase.client_status = " . $company_user['CompanyUser']['is_client'] . " AND Easycase.user_id = " . $company_user['CompanyUser']['user_id'] . ") OR Easycase.client_status != " . $company_user['CompanyUser']['is_client'] . ")";
        }
        //$caseMenuFilters = "milestone";
        $CaseCount = count($caseAll_records);
        $CaseCount1 = count($caseAll_records1);

        foreach ($caseAll_records as $k => $v) {
            $m[$v['Milestone']['id']]['id'] = $v['EasycaseMilestone']['mid'];
            $m[$v['Milestone']['id']]['caseids'] = $v[0]['caseids'];
            $m[$v['Milestone']['id']]['totalcases'] = $v[0]['totalcases'];
            $m[$v['Milestone']['id']]['title'] = $v['Milestone']['title'];
            $m[$v['Milestone']['id']]['project_id'] = $v['Milestone']['project_id'];
            $m[$v['Milestone']['id']]['end_date'] = $v['Milestone']['end_date'];
            $m[$v['Milestone']['id']]['uinq_id'] = $v['Milestone']['uniq_id'];
            $m[$v['Milestone']['id']]['isactive'] = $v['Milestone']['isactive'];
            $m[$v['Milestone']['id']]['user_id'] = $v['Milestone']['user_id'];
        }

        $c = array();
        if ($mid) {
            $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN(" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
            foreach ($closed_cases as $key => $val) {
                $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
            }
        }		
        /** *End of manipulations**** */
        $view = new View($this);
            $tz = $view->loadHelper('Tmzone');
            $dt = $view->loadHelper('Datetime');
            $cq = $view->loadHelper('Casequery');

        $this->loadModel('TypeCompany');
         if (!defined($_comp_id)) {
                $sql = "SELECT Type.* FROM types AS Type";
            } else {
                $sql = "SELECT Type.* FROM types AS Type WHERE Type.company_id = 0 OR Type.company_id =" . $_comp_id;
            }
            $typeArr = $this->TypeCompany->query($sql);
            //print_r($typeArr);exit;
            $tps = array();
            foreach($typeArr as $k=>$v){
                $tps[$v['Type']['id']] = $v['Type']['name'];
            }
           // print_r($caseAll_records1);exit;

		$custom_ids = array();
        if(count($caseAll_records1)){
        foreach ($caseAll_records1 as $key => $value) {
            if($value['SprintCompleteReport']['is_type']== 1){
              $resCaseProj['caseAll'][$key] =   $value['SprintCompleteReport'];
              $resCaseProj['caseAll'][$key]['Easycase'] =  json_decode($value['SprintCompleteReport']['tasks_detail'],true);
              $t_id = $resCaseProj['caseAll'][$key]['Easycase']['Easycase']['type_id'];  
              $resCaseProj['caseAll'][$key]['Easycase']['Easycase']['type_name'] = $tps[$t_id];
                  $resCaseProj['caseAll'][$key]['Easycase']['Project']['short_name'] = $value['Project']['short_name'];
			  unset($resCaseProj['caseAll'][$key]['tasks_detail']);
			  array_push($custom_ids,$resCaseProj['caseAll'][$key]['Easycase']['Easycase']['custom_status_id']);

            }else if($value['SprintCompleteReport']['is_type']== 2){
              $resCaseProj['caseAllOut'][$key] =   $value['SprintCompleteReport'];
              $resCaseProj['caseAllOut'][$key]['Easycase'] =  json_decode($value['SprintCompleteReport']['tasks_detail'],true);
              $t_id = $resCaseProj['caseAllOut'][$key]['Easycase']['Easycase']['type_id']; 
              $resCaseProj['caseAllOut'][$key]['Easycase']['Easycase']['type_name'] = $tps[$t_id];
                  $resCaseProj['caseAllOut'][$key]['Easycase']['Project']['short_name'] = $value['Project']['short_name'];
			  unset($resCaseProj['caseAll'][$key]['tasks_detail']);
			  array_push($custom_ids,$resCaseProj['caseAllOut'][$key]['Easycase']['Easycase']['custom_status_id']);

            }else{
              $resCaseProj['caseAllUnresolved'][$key] =   $value['SprintCompleteReport'];
              $resCaseProj['caseAllUnresolved'][$key]['Easycase'] =  json_decode($value['SprintCompleteReport']['tasks_detail'],true);
              $t_id = $resCaseProj['caseAllUnresolved'][$key]['Easycase']['Easycase']['type_id']; 
              $resCaseProj['caseAllUnresolved'][$key]['Easycase']['Easycase']['type_name'] = $tps[$t_id];
                  $resCaseProj['caseAllUnresolved'][$key]['Easycase']['Project']['short_name'] = $value['Project']['short_name'];
			  unset($resCaseProj['caseAll'][$key]['tasks_detail']);
			  array_push($custom_ids,$resCaseProj['caseAllUnresolved'][$key]['Easycase']['Easycase']['custom_status_id']);

            }
        }
        } else if(count($caseAll_records)){         
            foreach ($caseAll_records as $key => $value) {
                    $v['SprintCompleteReport']['milestone_id'] = $value['EasycaseMilestone']['mid'];
                    $v['SprintCompleteReport']['project_id'] = $value['Easycase']['project_id'];
                    $v['SprintCompleteReport']['task_id'] = $value['Easycase']['id'];
                    $v['SprintCompleteReport']['tasks_detail'] = json_encode($value);
                    $v['SprintCompleteReport']['move_count'] = 1;
                    $v['SprintCompleteReport']['created'] = $value['Easycase']['dt_created'];
                    $v['SprintCompleteReport']['short_name'] = $value['Project']['short_name'];
                   
                    if(($projStatusGrp != 0 && $value['Easycase']['custom_status_id'] == 3) || 
                        ($projStatusGrp == 0 && in_array($value['Easycase']['legend'], array(3,5)))
                ){
                      $v['SprintCompleteReport']['is_type'] = 1;
                      $resCaseProj['caseAll'][$key] =   $v['SprintCompleteReport'];
                      $resCaseProj['caseAll'][$key]['Easycase'] =  json_decode($v['SprintCompleteReport']['tasks_detail'],true);
                      $t_id = $resCaseProj['caseAll'][$key]['Easycase']['Easycase']['type_id'];  
                      $resCaseProj['caseAll'][$key]['Easycase']['Easycase']['type_name'] = $tps[$t_id];

                    }else{
                      $v['SprintCompleteReport']['is_type'] = 0;
                      $resCaseProj['caseAllUnresolved'][$key] =   $v['SprintCompleteReport'];
                      $resCaseProj['caseAllUnresolved'][$key]['Easycase'] =json_decode($v['SprintCompleteReport']['tasks_detail'],true);
                      $t_id = $resCaseProj['caseAllUnresolved'][$key]['Easycase']['Easycase']['type_id']; 
                     // echo $t_id."<br />"; 
                      $resCaseProj['caseAllUnresolved'][$key]['Easycase']['Easycase']['type_name'] = $tps[$t_id];

                    }
               }
        }
        //pr($resCaseProj);exit;
		$csts_arr = array();
		//custom status ref for other pages	
		$sts_ids = array_filter(array_unique($custom_ids));
		if($sts_ids){
			$Csts = ClassRegistry::init('CustomStatus');
			$csts_arr = $Csts->find('all',array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
			if($csts_arr){
				$csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
			}
		}		
        $this->loadModel('ProjectSetting');
        $velo = $this->ProjectSetting->find('first',array('conditions'=>array('ProjectSetting.project_id'=>$pid),'fields'=>array('ProjectSetting.velocity_reports')));

         $arr['status'] = 1;
         $arr['customStatus'] = $csts_arr;
         $arr['result0']['caseAll'] =($resCaseProj['caseAll'])?$resCaseProj['caseAll']:array();
         $arr['result0']['isCompleted'] = 1;
         $arr['result0']['velocity'] = $velo['ProjectSetting']['velocity_reports'];

		 $arr['result1']['caseAll'] =($resCaseProj['caseAllUnresolved'])?$resCaseProj['caseAllUnresolved']:array();
         $arr['result1']['isCompleted'] = 0;
         $arr['result1']['velocity'] = $velo['ProjectSetting']['velocity_reports'];

         $arr['result2']['caseAll'] =($resCaseProj['caseAllOut'])?$resCaseProj['caseAllOut']:array();
         $arr['result2']['isCompleted'] = 2;
         $arr['result2']['velocity'] = $velo['ProjectSetting']['velocity_reports'];

          $this->loadModel('SprintSetting');
          $ss = $this->SprintSetting->find('first',array('conditions'=>array('SprintSetting.company_id'=>$_comp_id)));
          $ssp = isset($ss['SprintSetting']) && !empty($ss['SprintSetting']) ?$ss['SprintSetting']['is_active']:0;
          if($ssp ==1){
              $arr['any_completed'] = 0;
           }else{
             $this->loadModel('Milestone');            
              $checkQuery = "SELECT Milestone.id FROM milestones AS Milestone WHERE  Milestone.id !='".$milestone_id."' AND Milestone.company_id='".$_comp_id."' AND Milestone.isactive = 1 AND Milestone.is_started = 1 AND  Milestone.project_id='".$pid."'";
                $checkMstn = $this->Milestone->query($checkQuery); 
               if(count($checkMstn) && isset($checkMstn[0]['Milestone']['id']) && $checkMstn[0]['Milestone']['id']) {
                $arr['any_completed'] = 1;
               }else{
                $arr['any_completed'] = 0;
               }
           }
           $getMilestone = $this->Milestone->query("SELECT Milestone.start_date,Milestone.end_date,Milestone.title,User.name,User.last_name FROM milestones AS Milestone LEFT JOIN users AS User on Milestone.user_id=User.id WHERE Milestone.id = $milestone_id GROUP BY Milestone.id ");
		   
		   $this->loadModel('Timezone');
		   $timezone = $this->Timezone->find('first', array("conditions" => array("Timezone.id" => $auth_user['User']['timezone_id'])));
		   
			if(isset($auth_user['User']['is_dst'])){
				if (!defined('TZ_DST')) {
						define('TZ_DST', $auth_user['User']['is_dst']);
				}
			}else{
				if (!defined('TZ_DST')) {
					define('TZ_DST', $timezone['Timezone']['dst_offset']);
				}
			}
			if (!defined('TZ_CODE')) {
				define('TZ_CODE', $timezone['Timezone']['code']);
			}
		   
            $name_ = $getMilestone[0]['User']['name'];
            $start_date_ =  $tz->GetDateTime($timezone['Timezone']['id'], $timezone['Timezone']['gmt_offset'], TZ_DST, TZ_CODE, $getMilestone[0]['Milestone']['start_date'], "datetime");
            $end_date_ = $tz->GetDateTime($timezone['Timezone']['id'], $timezone['Timezone']['gmt_offset'], TZ_DST, TZ_CODE, $getMilestone[0]['Milestone']['end_date'], "datetime");
            
           $start_date_ = date('d M, Y',strtotime($start_date_));
           $end_date_ = date('d M, Y',strtotime($end_date_));

           $arr['not_completed_count'] = count($arr['result0']['caseAll']);

           $arr['sprint_info'] = __("Closed sprint, by",true)." <strong>". $name_ ."</strong>  '<strong>". $start_date_ ."</strong> - <strong>". $end_date_ . "</strong>'";
		   $arr['mode'] = (int)$this->params->query['mode'];
		   $arr['sprint_selected'] = $getMilestone[0]['Milestone']['title'];
		   $arr['EDIT_TASK'] = $edit_task;
		   $arr['SES_ID'] = $_ses_id;
		   $arr['SES_TYPE'] = $_user_type;
        }
		if(!empty($pid) && !isset($projes)){
			$this->loadModel('Project');
			$projes = $this->Project->find('first',array('conditions'=>array('Project.id'=>$pid),'fields'=>array('Project.uniq_id','Project.name')));
		}
	    $arr['proj_selected'] = $projes['Project']['name'];	
		
		$this->set('data', $arr);		
	}
		public function ajaXGetRoles()
    {
        if($this->request->is('ajax')){
					//$data = $this->data;
					$Role = ClassRegistry::init('Role');
					$roles =  $Role->getRolesByRoleGroup(SES_COMP, $this->data['rolegroups']);
					$status['status'] = 'success';
					$status['roles'] = $roles;					
        }else{
					$status['roles'] = [];	
					$status['status'] = 'error';
					$status['msg'] = __('Invalid request.');
				}
				
				echo json_encode($status);
				exit;
    }
    
    
}
