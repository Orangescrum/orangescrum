<?php

App::uses('AppController', 'Controller');
App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));

class RequestsController extends AppController
{
    public $name = 'Request';
    public $components = array('Format', 'Postcase', 'Sendgrid', 'Tmzone', 'RequestHandler');
    public $uses = array('Easycase', 'Project', 'ProjectUser', 'Milestone', 'User', 'SearchFilter', 'LogTime', 'EasycaseMilestone');

    public function beforeFilter()
    {
        $this->Auth->allow('pdfcase_project', 'taskgroup_pdfcase_project');
        parent::beforeFilter();
    }
        

    public function index()
    {
        return;
    }

    public function ajax_check_size()
    {
        $this->layout = '';
    }

    public function exportcsv()
    {
        $this->layout = '';
        exit;
    }
    public function getMoreParent()
    {
        $this->layout = 'ajax';
        $proj_id = '';
        $case_id = '';
        if ($this->data['csuniqid']) {
            $case_id = $this->data['csuniqid'];
        }
        $proj_id = $this->data['proj_id'];
        $result['parent_tasks'] = array();
        if (!empty($proj_id)) {
            $pid = $this->Project->getProjectFields(array("Project.uniq_id" => $proj_id), array("Project.id"));
            if ($pid) {
                $proj_id = $pid['Project']['id'];
                $proj_search = urlencode(trim($this->data['search_txt']));
                $result['parent_tasks'] = $this->Easycase->parentTaskOptions($proj_id, 0, $case_id, $proj_search);
            }
        }
        echo json_encode($result);
        exit;
    }
    public function ajax_case_menu()
    {
        $this->layout = 'ajax';

        $proj_id = null;
        $pageload = 0;
        $prjUniqIdCsMenu = $this->params->data['projUniq'];
        $pageload = $this->params->data['pageload'];
        $page = $this->params->data['page'];

        if ($_COOKIE['CURRENT_FILTER'] != "") {
            $filters = $_COOKIE['CURRENT_FILTER'];
        } else {
            $filters = '';
        }

        if (isset($this->params->data['filters']) && $this->params->data['filters'] == "files") {
            $filters = $this->params->data['filters'];
        } elseif (isset($this->params->data['filters']) && $this->params->data['filters'] == "cases") {
            $filters = $this->params->data['filters'];
        }

        if (isset($this->params->data['case'])) {
            $case = $this->params->data['case'];
        } else {
            $case = "";
        }

        $qry = '';
        $searchcase = '';
        $sf = array();
        $caseMenuFilters = $filters;
        //Filter Condition added in Menu filters counters
        ######### Filter by Assign To ##########
        $projUniq = $this->params->data['projUniq'];
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        } elseif ($caseMenuFilters == "favourite") {
            if ($projUniq != 'all') {
                $this->loadModel('ProjectUser');
                $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
                if (count($projArr)) {
                    $curProjId = $projArr['Project']['id'];
                    $curProjShortName = $projArr['Project']['short_name'];
                    $conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                    $this->loadModel('EasycaseFavourite');
                    $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                    //if(!empty($easycase_favourite)){
                    $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                    //}
                }
            } else {
                $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                $this->loadModel('EasycaseFavourite');
                $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                // if(!empty($easycase_favourite)){
                $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                // }
            }
        }
        ######### Filter by Delegate To ##########
        elseif ($caseMenuFilters == "delegateto") {
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
        } elseif ($caseMenuFilters == "closedtasks") {
            $qry.= " AND (Easycase.legend='3' OR Easycase.legend='5') AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "overdue") {
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $cur_dt = date('Y-m-d', strtotime(GMT_DATETIME));
            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date != '0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND DATE(Easycase.due_date) < '" . $cur_dt . "' AND (Easycase.legend !=3) ";
        } elseif ($caseMenuFilters == "highpriority") {
            $qry.= " AND Easycase.priority ='0' ";
        } elseif ($caseMenuFilters == "openedtasks") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='4')  AND Easycase.type_id !='10'";
        }
        /*if (!empty($search_val) && !empty($inactiveFlag)) {
            $qry.= "AND Easycase.title LIKE '%" . trim($search_val) . "%'";
        }*/
        if ($page == 'dashboard') {
            $projUniq = $this->params->data['projUniq'];
            $curProjId = $this->params->data['priFil'];
            $caseMenuFilters = $this->params->data['caseMenuFilters'];
            $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
            $caseCustomStatus = $this->params->data['caseCustomStatus']; // Filter by Custom Status
            $priorityFil = $this->params->data['priFil']; // Filter by Priority
            $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
            $caseLabel = $this->params->data['caseLabel']; // Filter by case Label
            $caseUserId = $this->params->data['caseMember']; // Filter by Member
            $caseComment = $this->params->data['caseComment']; // Filter by Member
            $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
            $caseSrch = $this->params->data['caseSearch']; // Search by keyword
            @$case_srch = $this->params->data['case_srch'];
            @$case_date = urldecode($this->params->data['case_date']);
            @$case_duedate = $this->params->data['case_due_date'];
            $milestoneIds = $this->params->data['milestoneIds'];
            $checktype = $this->params->data['checktype'];
						$caseTaskgroup = $this->params->data['caseTaskgroup'];
            ######### Filter by Case Types ##########
            if ($caseTypes && $caseTypes != "all") {
                $qry.= $this->Format->typeFilter($caseTypes);
            }
            ######### Filter by Priority ##########
            if ($priorityFil && $priorityFil != "all") {
                $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            }
            $is_def_status_enbled = 0;
            ######### Filter by Status ##########
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                $is_def_status_enbled = 1;
                $qry.= " AND (";
                $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus, 1);
            }
            ######### Filter by Status ##########
            if (trim($caseStatus) && $caseStatus != "all") {
                if (!$is_def_status_enbled) {
                    $qry.= " AND (";
                } else {
                    $qry.= " OR ";
                }
                $qry.= $this->Format->statusFilter($caseStatus, '', 1);
                $qry .= ")";
            } else {
                if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                    $qry .= ")";
                }
            }
            /*######### Filter by Status ##########
            if ($caseStatus && $caseStatus != 'all') {
            $qry.= $this->Format->statusFilter($caseStatus);
            }
            ######### Filter by Custom Status ##########
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
            $filterenabled = 1;
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus);
            }*/
            
            ######### Filter by Member ##########
            if ($caseUserId && $caseUserId != "all") {
                $qry.= $this->Format->memberFilter($caseUserId);
            }
            ######### Filter by AssignTo ##########
            #/* Added by smruti on 08082013*/
            if ($caseAssignTo && $caseAssignTo != "all" && $caseAssignTo != 'unassigned') {
                $qry.= $this->Format->assigntoFilter($caseAssignTo);
            } elseif ($caseAssignTo && $caseAssignTo == 'unassigned') {
                $qry.= " AND Easycase.assign_to=0";
            }
            $restrictedQuery ="";
            if (!$this->Format->isAllowed('View All Task', $roleAccess)) {
                $qry.= " AND (Easycase.assign_to=".SES_ID." || Easycase.user_id=".SES_ID.")";
                $restrictedQuery = " AND (Easycase.assign_to=".SES_ID." || Easycase.user_id=".SES_ID.")";
            }
            ######### Search by KeyWord ##########
            $searchcase = "";

            if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
                $qry = "";
                $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
            }

            if (trim(urldecode($case_srch)) != "") {
                $qry = "";
                $searchcase = "AND (Easycase.case_no = '$case_srch')";
            }

            if (trim(urldecode($caseSrch))) {
                if ((substr($caseSrch, 0, 1)) == '#') {
                    $qry = "";
                    $tmp = explode("#", $caseSrch);
                    $casno = trim($tmp['1']);
                    $searchcase = " AND (Easycase.case_no = '" . $casno . "')";
                }
            }

            if (trim($case_date) != "") {
                $case_date = urldecode($case_date);
                if ((SES_COMP == 25814 || SES_COMP == 28528 || SES_COMP == 1358) && (trim($caseComment) && $caseComment != "all")) {
                    // Modified for jayan (if date filter with commented by filter is applied then now apply the date filter in the parent task)
                } else {
                    $frmTz = '+00:00';
                    $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                    $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                    if (trim($case_date) == 'one') {
                        $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                        $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
                    } elseif (trim($case_date) == '24') {
                        $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                        $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
                    } 
                     elseif (trim($case_date) == 'today') {
                        $from_d = date("Y-m-d 00:00:00", strtotime($GMT_DATE));
                    $to_d = date("Y-m-d 23:59:59", strtotime($GMT_DATE));
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d H:i:s', strtotime($from_d)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d H:i:s', strtotime($to_d)) . "'";
                  
                    }
                    elseif (trim($case_date) == 'week') {
                        $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                        $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
                    } elseif (trim($case_date) == 'month') {
                        $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                        $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
                    } elseif (trim($case_date) == 'year') {
                        $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                        $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
                    } elseif (strstr(trim($case_date), ":")) {
                        //echo $case_date;exit;
                        $ar_dt = explode(":", trim($case_date));
                        $frm_dt = $ar_dt['0'];
                        $to_dt = $ar_dt['1'];
                        //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                        $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                    } elseif (strstr(trim($case_date), "_")) {
                        $filterenabled = 1;
                        $ar_dt = explode("_", trim($case_date));
                        $frm_dt = $ar_dt['0'];
                        $to_dt = $ar_dt['1'];
                        $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                    }
                }
            }
            if (trim($case_duedate) != "") {
                $case_duedate = urldecode($case_duedate);
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                if (trim($case_duedate) == '24') {
                    $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                    $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
                } elseif (trim($case_duedate) == 'overdue') {
                    $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                    $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3)";
                } elseif (strstr(trim($case_duedate), ":")) {
                    //echo $case_duedate;exit;
                    $ar_dt = explode(":", trim($case_duedate));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }
            /*             * * Call search filter controller **** */


            $sf = $this->SearchFilter->getFiltersWithCounts($this->params->data);
            $checkDefault = $this->SearchFilter->getDefault();
            /*             * **END******* */
        }
        //End
        $assignToMe = 0;
        $delegateTo = 0;
        $caseNew = 0;
        $caseFiles = 0;
        $caseHighPri = 0; // $latest = 0;

        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $resCaseMenu = array();
        if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
            if (count($projArr)) {
                $proj_id = $projArr['Project']['id'];
            }
            if (!$proj_id) {
                die;
            }
            ######### Filter by Case Label ##########
            if (trim($caseLabel) && $caseLabel != "all") {
                $qry.= $this->Format->labelFilter($caseLabel, $proj_id, SES_COMP, SES_TYPE, SES_ID);
                //$filterenabled = 1;
            }
            ######### Filter by Member ##########
            if ($caseComment && $caseComment != "all") {
                $qry.= $this->Format->commentFilter($caseComment, $proj_id, $case_date);
            }
			######### Filter by task group ##########           
			if ($caseTaskgroup && $caseTaskgroup != "all") {
					$qry.= $this->Format->caseTaskGroupFilter($caseTaskgroup,$proj_id);
			}
            //AssigntoMe
            $ret_arr = array('assignTo'=>0,'deligateTo'=>0,'newTask'=>0,'highPriority'=>0,'overdue'=>0,'opeded'=>0,'closed'=>0);
            $ret_arr_org = array('assignTo'=>0,'deligateTo'=>0,'newTask'=>0,'highPriority'=>0,'overdue'=>0,'opeded'=>0,'closed'=>0);
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            if (!empty($qry) || !empty($this->params['data']['filters'])) {
                $ret_arr['assignTo'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.assign_to' => SES_ID, $clt_sql,' 1 '.$qry,' 1 '.$searchcase)));
                
                $ret_arr['deligateTo'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.user_id' => SES_ID,'Easycase.assign_to NOT IN ' => array(SES_ID,0), $clt_sql,' 1 '.$qry,' 1 '.$searchcase)));
                
                $ret_arr['highPriority'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.priority' => 0, $clt_sql,' 1 '.$qry,' 1 '.$searchcase)));
                
                $ret_arr['opeded'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.legend' => array(1,2,4),'Easycase.type_id !=' => 10, $clt_sql,' 1 '.$qry,' 1 '.$searchcase)));
                
                $ret_arr['closed'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.legend' => array(3,5),'Easycase.type_id !=' => 10, $clt_sql,' 1 '.$qry,' 1 '.$searchcase)));
                
                $ret_arr['newTask'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1, $clt_sql,' 1 '.$qry,' 1 '.$searchcase)));
                
                $sql = 'SELECT COUNT(DISTINCT Easycase.id) as ovrduecount '
                        . 'FROM easycases Easycase '
                        . 'WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.due_date !="" '
                        . 'AND Easycase.due_date !="0000-00-00 00:00:00" AND Easycase.due_date !="1970-01-01 00:00:00" AND Easycase.due_date < "' . $cur_dt . '" '
                        . 'AND (Easycase.legend !=3) AND Easycase.istype= 1 '
                        . ' AND Easycase.project_id =' . $proj_id . ' ' . $qry . $searchcase;
                $overdue_count = $this->Easycase->query($sql);
                $ret_arr['overdue'] = $overdue_count[0][0]['ovrduecount'];
            }
            $ret_arr_org['assignTo'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.assign_to' => SES_ID, $clt_sql,' 1 '.$searchcase.$restrictedQuery)));
            
            $ret_arr_org['deligateTo'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.user_id' => SES_ID,'Easycase.assign_to NOT IN ' => array(SES_ID,0), $clt_sql,' 1 '.$searchcase.$restrictedQuery)));
            
            $ret_arr_org['highPriority'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.priority' => 0, $clt_sql,' 1 '.$searchcase.$restrictedQuery)));
            
            $ret_arr_org['opeded'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.legend' => array(1,2,4),'Easycase.type_id !=' => 10, $clt_sql,' 1 '.$searchcase.$restrictedQuery)));
            
            $ret_arr_org['closed'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1,'Easycase.legend' => array(3,5),'Easycase.type_id !=' => 10, $clt_sql,' 1 '.$searchcase.$restrictedQuery)));
            
            $ret_arr_org['newTask'] = $this->Easycase->find('count', array('conditions' => array('Easycase.project_id'=>$proj_id,'Easycase.istype'=>1,'Easycase.isactive'=>1, $clt_sql,' 1 '.$searchcase.$restrictedQuery)));
            
            $cur_dts = date('Y-m-d', strtotime(GMT_DATETIME));
            $sqlOrg = 'SELECT COUNT(DISTINCT Easycase.id) as ovrduecount '
                    . 'FROM easycases Easycase '
                    . 'WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.due_date !="" '
                    . 'AND Easycase.due_date !="0000-00-00 00:00:00"  AND Easycase.due_date !="1970-01-01 00:00:00" AND Easycase.due_date < "' . $cur_dts  . '" '
                    . 'AND Easycase.legend !=3 AND Easycase.legend !=5 AND Easycase.istype= 1 '
                    . ' AND Easycase.project_id =' . $proj_id . ' ' . $searchcase.$restrictedQuery;
            $overdue_count_o = $this->Easycase->query($sqlOrg);
            $ret_arr_org['overdue'] = $overdue_count_o[0][0]['ovrduecount'];
            $conditions = array('EasycaseFavourite.project_id'=>$proj_id,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
            $this->loadModel('EasycaseFavourite');
            $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
            if (!empty($easycase_favourite)) {
                $favList = " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                //print_r($favList); exit;
                if (!empty($qry)) {
                    $caseFav_all = $this->Easycase->query('SELECT COUNT(Easycase.id) as total_fav FROM easycases Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql .$favList. ' AND Easycase.istype= 1 AND Easycase.project_id =' . $proj_id . ' ' . $qry . $searchcase);
                    $ret_arr['caseFavourite'] = $caseFav_all['0']['0']['total_fav'];
                }
                $caseFavOrg_all = $this->Easycase->query('SELECT COUNT(Easycase.id) as total_fav FROM easycases Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . $favList.' AND Easycase.istype= 1 AND Easycase.project_id =' . $proj_id . ' ' . $searchcase.$restrictedQuery);
                $ret_arr_org['caseFavourite'] = $caseFavOrg_all['0']['0']['total_fav'];
            } else {
                $ret_arr['caseFavourite']  = 0;
                $ret_arr_org['caseFavourite']  = 0;
            }
            $resCaseMenu['assignToMe'] = $ret_arr['assignTo'];
            $resCaseMenu['assignToMeOrg'] = $ret_arr_org['assignTo'];
            $resCaseMenu['caseFavourite'] = $ret_arr['caseFavourite'];
            $resCaseMenu['caseFavouriteOrg'] = $ret_arr_org['caseFavourite'];
            $resCaseMenu['caseNew'] = $ret_arr['newTask'];
            $resCaseMenu['caseNewOrg'] = $ret_arr_org['newTask'];
            $resCaseMenu['highPri'] = $ret_arr['highPriority'];
            $resCaseMenu['highPriOrg'] = $ret_arr_org['highPriority'];
            $resCaseMenu['overdue'] = $ret_arr['overdue'];
            $resCaseMenu['overdueOrg'] = $ret_arr_org['overdue'];
            $resCaseMenu['delegateTo'] = $ret_arr['deligateTo'];
            $resCaseMenu['delegateToOrg'] = $ret_arr_org['deligateTo'];
            $resCaseMenu['openedtasks'] = $ret_arr['opeded'];
            $resCaseMenu['openedtasksOrg'] = $ret_arr_org['opeded'];
            $resCaseMenu['closedtasks'] = $ret_arr['closed'];
            $resCaseMenu['closedtasksOrg'] = $ret_arr_org['closed'];
            $caseCount = $this->Easycase->query("SELECT COUNT(CaseFile.id) as count FROM easycases as Easycase,case_files as CaseFile WHERE Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.project_id='" . $proj_id . "' AND CaseFile.isactive='1'");
            $caseFiles = $caseCount[0][0]['count'];
            $resCaseMenu['caseFiles'] = (isset($caseFiles)) ? $caseFiles : 0;
            $resCaseMenu['caseFilesOrg'] = (isset($caseFilesOrg)) ? $caseFilesOrg : 0;
        } elseif ($prjUniqIdCsMenu == 'all') {
            
            ######### Filter by Case Label ##########
            if (trim($caseLabel) && $caseLabel != "all") {
                $qry.= $this->Format->labelFilter($caseLabel, 0, SES_COMP, SES_TYPE, SES_ID);
                //$filterenabled = 1;
            }
            
            $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('DISTINCT Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));

            $this->loadModel('ProjectUser');
            $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
            $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
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

            if (!empty($qry)) {
                $assignToMe = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS asigntocnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND (Easycase.assign_to=' . SES_ID . ' ) ' . $qry . ' ' . $searchcase);
            }
            $assignToMeOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS asigntocnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND (Easycase.assign_to=' . SES_ID . ' )  ' . $searchcase);
            if (!empty($qry)) {
                $openedTasksArr = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS openedcnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND (Easycase.legend=1 OR Easycase.legend=2 OR Easycase.legend=4) AND Easycase.type_id !=10 ' . $qry . ' ' . $searchcase);
                $closedTasksArr = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS closedcnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND (Easycase.legend=3 OR Easycase.legend=5) AND Easycase.type_id !=10 ' . $qry . ' ' . $searchcase);
                $openedTasks = $openedTasksArr[0][0]['openedcnt'];
                $closedTasks = $closedTasksArr[0][0]['closedcnt'];
            }
            $openedTasksArrOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS openedcnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND (Easycase.legend=1 OR Easycase.legend=2 OR Easycase.legend=4) AND Easycase.type_id !=10  ' . $searchcase);
            $closedTasksArrOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS closedcnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND (Easycase.legend=3 OR Easycase.legend=5) AND Easycase.type_id !=10  ' . $searchcase);
            $openedTasksOrg = $openedTasksArrOrg[0][0]['openedcnt'];
            $closedTasksOrg = $closedTasksArrOrg[0][0]['closedcnt'];

            if (count($ids)) {
                //$delegateToArr = $this->Easycase->query("SELECT COUNT(id) as total FROM `easycases` AS `Easycase` WHERE Easycase.isactive='1' AND Easycase.istype='1' AND Easycase.project_id IN (".implode(",",$ids).") AND Easycase.assign_to!='0' AND Easycase.assign_to!='".SES_ID."' AND Easycase.user_id='".SES_ID."'");
                if (!empty($qry)) {
                    $delegateToArr = $this->Easycase->query("SELECT COUNT(DISTINCT Easycase.id) as total FROM `easycases` AS `Easycase` WHERE Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.istype='1' AND " . $n_pid_cond_t . " AND Easycase.assign_to!='0' AND Easycase.assign_to!='" . SES_ID . "' AND Easycase.user_id='" . SES_ID . "' " . $qry . " " . $searchcase);
                    $delegateTo = $delegateToArr[0][0]['total'];
                }
                $delegateToArrOrg = $this->Easycase->query("SELECT COUNT(DISTINCT Easycase.id) as total FROM `easycases` AS `Easycase` WHERE Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.istype='1' AND " . $n_pid_cond_t . " AND Easycase.assign_to!='0' AND Easycase.assign_to!='" . SES_ID . "' AND Easycase.user_id='" . SES_ID . "'  " . $searchcase);
                $delegateToOrg = $delegateToArrOrg[0][0]['total'];

                $caseCount = $this->Easycase->query("SELECT COUNT(CaseFile.id) as count FROM easycases as Easycase,case_files as CaseFile WHERE Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.project_id IN (" . implode(",", $ids) . ") AND Easycase.project_id!=0 AND CaseFile.isactive='1'");
                $caseFiles = $caseCount[0][0]['count'];
            }

            if (!empty($qry)) {
                $caseNew = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS newcount FROM easycases Easycase WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND ' . $clt_sql . ' AND ' . $n_pid_cond . ' ' . $qry . $searchcase);
            }
            $caseNewOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS newcount FROM easycases Easycase WHERE Easycase.isactive=1 AND Easycase.istype= 1 AND ' . $clt_sql . ' AND ' . $n_pid_cond . ' ' . $searchcase);

            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $cur_dt = date('Y-m-d', strtotime(GMT_DATETIME));
            if (!empty($qry)) {
                $sql = 'SELECT COUNT(DISTINCT Easycase.id) as ovrduecount '
                    . 'FROM easycases Easycase '
                    . 'WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.due_date !="" '
                    . 'AND Easycase.due_date !="0000-00-00 00:00:00" AND Easycase.due_date !="1970-01-01 00:00:00" AND DATE(Easycase.due_date) < "' . $cur_dt . '" '
                    . 'AND (Easycase.legend !=3) AND Easycase.istype= 1 '
                    . ' AND ' . $n_pid_cond . ' ' . $qry . $searchcase; #AND Easycase.project_id=' . $proj_id . '
            }
            $sqlOrg = 'SELECT COUNT(DISTINCT Easycase.id) as ovrduecount '
                    . 'FROM easycases Easycase '
                    . 'WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.due_date !="" '
                    . 'AND Easycase.due_date !="0000-00-00 00:00:00" AND Easycase.due_date !="1970-01-01 00:00:00" AND DATE(Easycase.due_date) < "' . $cur_dt . '" '
                    . 'AND (Easycase.legend !=3) AND Easycase.istype= 1 '
                    . ' AND ' . $n_pid_cond . ' ' . $searchcase; #AND Easycase.project_id=' . $proj_id . '

            if (!empty($qry)) {
                $ovrdueCase = $this->Easycase->query($sql);
                $caseHighPri = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) as hpcount FROM easycases Easycase WHERE Easycase.isactive = 1 AND ' . $clt_sql . ' AND Easycase.istype= 1 AND ' . $n_pid_cond . ' AND Easycase.priority = 0 AND Easycase.type_id != 10 ' . $qry . $searchcase);
            }
            $ovrdueCaseOrg = $this->Easycase->query($sqlOrg);

            $caseHighPriOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) as hpcount FROM easycases Easycase WHERE Easycase.isactive = 1 AND ' . $clt_sql . ' AND Easycase.istype= 1 AND ' . $n_pid_cond . ' AND Easycase.priority = 0 AND Easycase.type_id != 10 ' . $searchcase);

            $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
            $this->loadModel('EasycaseFavourite');
            $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
            if (!empty($easycase_favourite)) {
                $favList = " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                if (!empty($qry)) {
                    $caseFav_all = $this->Easycase->query('SELECT COUNT(Easycase.id) as total_fav FROM easycases Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql .$favList. ' AND Easycase.istype= 1 '. $qry . $searchcase);
                    $ret_arr['caseFavourite'] = $caseFav_all['0']['0']['total_fav'];
                }
                $caseFavOrg_all = $this->Easycase->query('SELECT COUNT(Easycase.id) as total_fav FROM easycases Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . $favList.' AND Easycase.istype= 1 ' . $searchcase);
                $ret_arr_org['caseFavourite'] = $caseFavOrg_all['0']['0']['total_fav'];
            } else {
                $ret_arr['caseFavourite']  = 0;
                $ret_arr_org['caseFavourite']  = 0;
            }
            $resCaseMenu['assignToMe'] = (isset($assignToMe[0][0]['asigntocnt'])) ? $assignToMe[0][0]['asigntocnt'] : 0;
            $resCaseMenu['assignToMeOrg'] = (isset($assignToMeOrg[0][0]['asigntocnt'])) ? $assignToMeOrg[0][0]['asigntocnt'] : 0;
            $resCaseMenu['caseFavourite'] = $ret_arr['caseFavourite'];
            $resCaseMenu['caseFavouriteOrg'] = $ret_arr_org['caseFavourite'];
            $resCaseMenu['delegateTo'] = (isset($delegateTo)) ? $delegateTo : 0;
            $resCaseMenu['delegateToOrg'] = (isset($delegateToOrg)) ? $delegateToOrg : 0;
            $resCaseMenu['openedtasks'] = (isset($openedTasks)) ? $openedTasks : 0;
            $resCaseMenu['openedtasksOrg'] = (isset($openedTasksOrg)) ? $openedTasksOrg : 0;
            $resCaseMenu['closedtasks'] = (isset($closedTasks)) ? $closedTasks : 0;
            $resCaseMenu['closedtasksOrg'] = (isset($closedTasksOrg)) ? $closedTasksOrg : 0;

            $resCaseMenu['caseFiles'] = (isset($caseFiles)) ? $caseFiles : 0;
            $resCaseMenu['caseFilesOrg'] = (isset($caseFilesOrg)) ? $caseFilesOrg : 0;
            $resCaseMenu['caseNew'] = (isset($caseNew[0][0]['newcount'])) ? $caseNew[0][0]['newcount'] : 0;
            $resCaseMenu['caseNewOrg'] = (isset($caseNewOrg[0][0]['newcount'])) ? $caseNewOrg[0][0]['newcount'] : 0;

            $resCaseMenu['overdue'] = (isset($ovrdueCase[0][0]['ovrduecount'])) ? $ovrdueCase[0][0]['ovrduecount'] : 0;
            $resCaseMenu['overdueOrg'] = (isset($ovrdueCaseOrg[0][0]['ovrduecount'])) ? $ovrdueCaseOrg[0][0]['ovrduecount'] : 0;
            $resCaseMenu['highPri'] = (isset($caseHighPri[0][0]['hpcount'])) ? $caseHighPri[0][0]['hpcount'] : 0;
            $resCaseMenu['highPriOrg'] = (isset($caseHighPriOrg[0][0]['hpcount'])) ? $caseHighPriOrg[0][0]['hpcount'] : 0;
        }
        $resCaseMenu['sf'] = $sf;
        $resCaseMenu['checkDefault'] = (!empty($checkDefault)) ? $checkDefault : 0;
        $resCaseMenu['showDetails'] = 1;
        $resCaseMenu['showDetailsAll'] = 0;
        if (empty($qry)) {
            $resCaseMenu['showDetailsAll'] = 1;
        }
        $this->set('resCaseMenu', json_encode($resCaseMenu));
        $this->render('/Easycase/ajax_case_menu');
    }

    public function ajax_project_size()
    {
        $this->layout = 'ajax';
        $proj_id = null;
        $pageload = 0;
        $proj_uniq_id = trim($this->params->data['projUniq']);
        if (!$proj_uniq_id) {
            exit;
        }
        if (SES_TYPE == 3) {
            $this->Session->write('Auth.User.isdashboard', 1);
        }

        $pageload = $this->params->data['pageload'];
        //$limitation = $this->UserSubscription->readSubDetlfromCache(SES_COMP); //OPTI
        //$user_subscription = $limitation['UserSubscription'];

        $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
        $this->ProjectUser->unbindModel(array('belongsTo' => array('User'))); //OPTI
        $projArr = $this->ProjectUser->find('first', array('conditions' => array('ProjectUser.company_id' => SES_COMP,'Project.uniq_id' => $proj_uniq_id,'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1), 'fields' => array('Project.id','Project.uniq_id','Project.name','ProjectUser.id','ProjectUser.dt_visited'), 'order' => array('ProjectUser.dt_visited DESC')));
        if ($proj_uniq_id != 'all') {
            if (count($projArr)) {
                $this->ProjectUser->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE id='" .$projArr['ProjectUser']['id']."'");
            }
            $arr['used_text'] = '';
            $arr['all'] = 0;
        } else {
            $arr['all'] = 1;
            $arr['used_text'] = '';
        }


        if ($projArr['Project']['name']) {
            $arr ['last_activity'] = "<span>".__('Last Activity', true)."</span><span> | </span> <strong>" . $this->Format->shortLength($projArr['Project']['name'], 20) . "</strong> ";

            if ($projArr['ProjectUser']['dt_visited'] && !stristr($projArr['ProjectUser']['dt_visited'], "0000")) {
                //$view = new View($this);
                //$tz = $view->loadHelper('Tmzone');
                //$last_logindt = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $projArr['ProjectUser']['dt_visited'], "datetime");
                //$locDResFun2 = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                $last_logindt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                $locDResFun2 = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");


                //$tz1 = $view->loadHelper('Datetime');
                $arr ['last_activity'] .= '<span>' . $this->Tmzone->dateFormatOutputdateTime_day_helper($last_logindt, $locDResFun2) . '</span>';
                $arr['lastactivity_proj_id'] = $projArr['Project']['id'];
                $arr['lastactivity_proj_uid'] = $projArr['Project']['uniq_id'];
            }
        }

        echo json_encode($arr);
        exit;
    }
    public function ajaXTaskMassAction(){
			if ($this->request->is('ajax')) {
				$projUniq = $this->data['projFil']; // Project Uniq I				
				$case_ids = $this->data['caseid']; // Case Uniq ID to close a case
				$actionType = $this->data['statusid'];
				if(empty($this->data['caseid']) || empty($this->data['projFil'])){
					$resCaseProj['status'] = 'failed';
					$resCaseProj['email_arr'] = '';
					echo json_encode($resCaseProj);
					exit;
				}
				$commonAllId = [];
				$caseid_list = [];
				if ($actionType == 'caseStart') {
					$csSts = 1;
					$csLeg = 4;
					$acType = 2;
					$cuvtype = 4;
					$commonAllId = $case_ids;
					$emailType = "Start";
					$msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
					$emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font> the Task.';
				} elseif ($actionType == 'caseResolve') {
					$csSts = 1;
					$csLeg = 5;
					$acType = 3;
					$cuvtype = 5;
					$commonAllId = $case_ids;
					$emailType = "Resolve";
					$msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
					$emailbody = '<font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font> the Task.';
				} elseif ($actionType == 'caseNew') {
					$csSts = 1;
					$csLeg = 1;
					$acType = 3;
					$cuvtype = 5;
					$commonAllId = $case_ids;
					$emailType = "New";
					$msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
					$emailbody = 'Changed the status of the task to<font color="#F08E83" style="font:normal 12px verdana;">NEW</font>.';
				} elseif ($actionType == 'caseId') {
					$csSts = 2;
					$csLeg = 3;
					$acType = 1;
					$cuvtype = 3;
					$commonAllId = $case_ids;
					$emailType = "Close";
					$msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
					$emailbody = '<font color="green" style="font:normal 12px verdana;">CLOSED</font> the Task.';
				}

				if ($commonAllId) {
					$commonArrId = $commonAllId;
					$done = 1;				
					$commonArrId_t = array_filter($commonArrId);
					foreach ($commonArrId as $commonCaseId) {
						if (!empty($commonCaseId)) {
							$allowed = "Yes";
							$depends = $this->Easycase->find('first', array('conditions' => array('id' => $commonCaseId)));
							if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
									$result = $this->Easycase->find('all', array('conditions' => array('id IN (' . $depends['Easycase']['depends'] . ')')));
									if (is_array($result) && count($result) > 0) {
											foreach ($result as $key => $parent) {
													if (($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) || ($parent['Easycase']['legend'] == 3)) {
															// NO ACTION
													} else {
															$allowed = "No";
													}
											}
									}
							}
							/* dependency check end */
							if ($allowed == 'No') {
									$resCaseProj['errormsg'] = __('Dependant tasks are not closed.',true);
							} else {
								$done = 1;
								$checkSts = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $commonCaseId . "' AND isactive='1'");
								if (isset($checkSts['0']) && count($checkSts['0']) > 0) {
									if ($checkSts['0']['easycases']['legend'] == 3) {
										$done = 0;
									}
									if ($csLeg == 4) {
										if ($checkSts['0']['easycases']['legend'] == 4) {
											$done = 0;
										}
									}
									if ($csLeg == 5) {
										if ($checkSts['0']['easycases']['legend'] == 5) {
											$done = 0;
										}
									}
								} else {
									$done = 0;
								}
								if ($done) {
									$caseid_list .= $commonCaseId . ',';
									$caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to')));
									$caseStsId = $caseDataArr['Easycase']['id'];
									$caseStsNo = $caseDataArr['Easycase']['case_no'];
									$closeStsPid = $caseDataArr['Easycase']['project_id'];
									$closeStsTyp = $caseDataArr['Easycase']['type_id'];
									$closeStsPri = $caseDataArr['Easycase']['priority'];
									$closeStsTitle = $caseDataArr['Easycase']['title'];
									$closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
									$caUid = $caseDataArr['Easycase']['assign_to'];

									$this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");
									/* Delete previous RA **/
									if($this->Format->isResourceAvailabilityOn() && $csLeg == 3){
										foreach($casearr as $casek=>$casev){
											$this->Format->delete_booked_hours(array('easycase_id' => $caseStsId, 'project_id' =>$closeStsPid));
										}
									}
									/* End */
									$caseuniqid = $this->Format->generateUniqNumber();
									$this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . SES_ID . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");

									$this->ProjectUser->recursive = -1;
									$getUser = $this->ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $closeStsPid . "'");
									$prjuniq = $this->Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
									$prjuniqid = $prjuniq[0]['projects']['uniq_id']; 
									$projShName = strtoupper($prjuniq[0]['projects']['short_name']);
									$channel_name = $prjuniqid;

									if($csLeg == 3){
										//on close of parent task close all children tasks
										$child_tasks = $this->Easycase->getSubTaskChild($commonCaseId, $caseDataArr['Easycase']['project_id']);
										if($child_tasks){
											$this->closerecursiveTaskFrmList($child_tasks['data'], $prjuniq);
										}
									}
								}
							}
						}
					}
					$_SESSION['email']['email_body'] = $emailbody;
					$_SESSION['email']['msg'] = $msg;					
					$email_notification = array('allfiles' => '', 'caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => '', 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => '', 'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid, 'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'caseUniqId' => $closeStsUniqId);

					$resCaseProj['status'] = 'success';
					$resCaseProj['email_arr'] = json_encode($email_notification);
					echo json_encode($resCaseProj);
					exit;
				}
				
				$resCaseProj['status'] = 'failed';
				$resCaseProj['email_arr'] = '';
				echo json_encode($resCaseProj);
				exit;
			}
		}
    public function case_project($inactiveFlag = '', $proUid = '', $inCasePage = '', $type = '', $cases = '', $csNum = '', $search_val = '', $impFormat=null)
    {
        if ($impFormat) {
            $this->Format = $this->Components->load('Format');
        }
        $this->layout = 'ajax';
        $resCaseProj = array();
        if (empty($inactiveFlag)) {
            $page_limit = CASE_PAGE_LIMIT;
        } else {
            $page_limit = INACT_CASE_PAGE_LIMIT;
        }
        if (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] == 'milestone') {
            if (empty($inactiveFlag)) {
                $page_limit = TASK_GROUP_CASE_PAGE_LIMIT;
            } else {
                $page_limit = INACT_TASK_GROUP_CASE_PAGE_LIMIT;
            }
        }
        $ajax_group_by = $this->request->data['casegroupby'];
        // pr($ajax_group_by); exit;
//        pr($this->request->data); exit;
        $this->_datestime();
        if (empty($inactiveFlag)) {
            $projUniq = $this->params->data['projFil']; // Project Uniq ID
        $projIsChange = $this->params->data['projIsChange']; // Project Uniq ID
        $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
            $caseCustomStatus = $this->params->data['caseCustomStatus']; // Filter by Custom Status
        $priorityFil = $this->params->data['priFil']; // Filter by Priority
        $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
            $caseLabel = $this->params->data['caseLabel']; // Filter by case Label
        $caseUserId = $this->params->data['caseMember']; // Filter by Member
            $caseComment = $this->params->data['caseComment']; // Filter by Member
            $caseTaskgroup = $this->params->data['caseTaskGroup']; // Filter by Member  // added by bijaya 03/08
        $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
        $caseDate = $this->params->data['caseDate']; // Sort by Date
        $caseDueDate = $this->params->data['caseDueDate']; // Sort by Due Date
            $caseEstHours = $this->params->data['caseEstHours']; // Sort by Estimated Hours
        @$case_duedate = $this->params->data['case_due_date'];
            @$case_date = $this->params->data['case_date'];
            @$case_date = urldecode($case_date);
            $caseSrch = $this->params->data['caseSearch']; // Search by keyword

            $casePage = $this->params->data['casePage']; // Pagination
        $caseUniqId = $this->params->data['caseId']; // Case Uniq ID to close a case
        $caseTitle = $this->params->data['caseTitle']; // Case Uniq ID to close a case
        $caseNum = $this->params->data['caseNum']; // Sort by Due Date
        $caseLegendsort = $this->params->data['caseLegendsort']; // Sort by Case Status
        $caseAtsort = $this->params->data['caseAtsort']; // Sort by Case Status
        $startCaseId = $this->params->data['startCaseId']; // Start Case
        $caseResolve = $this->params->data['caseResolve']; // Resolve Case
        $caseNew = $this->params->data['caseNew']; // New Case
        $caseMenuFilters = $this->params->data['caseMenuFilters']; // Resolve Case
        $milestoneIds = $this->params->data['milestoneIds']; // Resolve Case
        $caseCreateDate = $this->params->data['caseCreateDate']; // Sort by Created Date
        @$case_srch = $this->params->data['case_srch'];
            @$milestone_type = $this->params->data['mstype'];
            $changecasetype = $this->params->data['caseChangeType'];
            $caseChangeDuedate = $this->params->data['caseChangeDuedate'];
            $caseChangePriority = $this->params->data['caseChangePriority'];
            $caseChangeAssignto = $this->params->data['caseChangeAssignto'];
            $customfilterid = $this->params->data['customfilter'];
            $detailscount = $this->params->data['detailscount']; // Count number to open casedetails
        } else {
            $projUniq = $proUid;
            $casePage = !empty($inCasePage) ? $inCasePage : 1;
            $caseTitle = $search_val;
        }
        $filterenabled = 0;
        $clt_sql = 1;
        if (empty($inactiveFlag)) {
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
        }
        /* jyoti start */
        if ($customfilterid) {
            $this->loadModel('CustomFilter');
            $getcustomfilter = "SELECT SQL_CALC_FOUND_ROWS * FROM custom_filters AS CustomFilter WHERE CustomFilter.company_id = '" . SES_COMP . "' and CustomFilter.user_id =  '" . SES_ID . "' and CustomFilter.id='" . $customfilterid . "' ORDER BY CustomFilter.dt_created DESC ";
            $getfilter = $this->CustomFilter->query($getcustomfilter);

            if ($getfilter) {
                $caseStatus = $getfilter[0]['CustomFilter']['filter_status'];
                $caseCustomStatus = $getfilter[0]['CustomFilter']['filter_custom_status'];
                $priorityFil = $getfilter[0]['CustomFilter']['filter_priority'];
                $caseTypes = $getfilter[0]['CustomFilter']['filter_type_id'];
                $caseUserId = $getfilter[0]['CustomFilter']['filter_member_id'];
                $caseComment = $getfilter[0]['CustomFilter']['filter_comment'];
                $caseAssignTo = $getfilter[0]['CustomFilter']['filter_assignto'];
                $caseDate = $getfilter[0]['CustomFilter']['filter_date'];
                $case_duedate = $getfilter[0]['CustomFilter']['filter_duedate'];
                $caseSrch = $getfilter[0]['CustomFilter']['filter_search'];
            }
            $filterenabled = 1;
        }
        /* jyoti end */

        if ($caseMenuFilters) {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        } else {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        }
        $caseUrl = $this->params->data['caseUrl'];
        ######## get project ID from project uniq-id ################
        $curProjId = null;
        $curProjShortName = null;
        if ($projUniq != 'all') {
            /**
             * Binding of Project table is already done in ProjectUser model
             */
            $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
            if (empty($inactiveFlag)) {
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            } else {
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 2, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            }
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = $projArr['Project']['short_name'];

                //Updating ProjectUser table to current date-time
                if ($projIsChange != $projUniq && empty($inactiveFlag)) {
                    $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                    $ProjectUser['dt_visited'] = GMT_DATETIME;
                    $this->ProjectUser->save($ProjectUser);
                }
            }
        }
        ######### Filter by CaseUniqId ##########
        $qry = "";
        if (trim($caseUrl)) {
            $filterenabled = 1;
            $qry.= " AND Easycase.uniq_id='" . $caseUrl . "'";
        }
        $is_def_status_enbled = 0;
        ######### Filter by Custom Status ##########
        if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
            $is_def_status_enbled = 1;
            $filterenabled = 1;
            $qry.= " AND (";
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus, 1);
            $stsLegArr = $caseCustomStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
        }
        ######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
            if (!$is_def_status_enbled) {
                $qry.= " AND (";
            } else {
                $qry.= " OR ";
            }
            $qry.= $this->Format->statusFilter($caseStatus, '', 1);
            $qry .= ")";
            $stsLegArr = $caseStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
            if (!in_array("upd", $expStsLeg)) {
                $qry.= " AND Easycase.type_id !=10";
            }
        } else {
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                $qry .= ")";
            }
        }
        /*######### Filter by Custom Status ##########
        if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
        $filterenabled = 1;
        $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus);
        $stsLegArr = $caseCustomStatus . "-" . "";
        $expStsLeg = explode("-", $stsLegArr);
        }*/

        ######### Filter by Case Types ##########
        if (trim($caseTypes) && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Case Label ##########
        if (trim($caseLabel) && $caseLabel != "all") {
            $qry.= $this->Format->labelFilter($caseLabel, $curProjId, SES_COMP, SES_TYPE, SES_ID);
            $filterenabled = 1;
        }
        ######### Filter by Priority ##########
        if (trim($priorityFil) && $priorityFil != "all") {
            $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseUserId) && $caseUserId != "all") {
            $qry.= $this->Format->memberFilter($caseUserId);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseComment) && $caseComment != "all") {
            $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
            $filterenabled = 1;
        }
         ######### Filter by Member ##########
         if (trim($caseTaskgroup) && $caseTaskgroup != "all") {
            $qry.= $this->Format->taskgroupFilter($caseTaskgroup);
            // $qry.= $this->Format->commentFilter($caseComment,$curProjId,$case_date);
            $filterenabled = 1;
        }
        ######### Filter by AssignTo ##########
        if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
            $qry.= $this->Format->assigntoFilter($caseAssignTo);
            $filterenabled = 1;
        } elseif (trim($caseAssignTo) == "unassigned") {
            $qry.= " AND Easycase.assign_to='0'";
            $filterenabled = 1;
        }
        // Order by
        $sortby = '';
        $caseStatusby = '';
        $caseUpdatedby = '';
        $casePriority = '';
        $orderby = ($projUniq=='all'  && SES_COMP==25814)?'Easycase.project_id DESC,':'';

        if (isset($projUniq) && $projUniq == 'all') {
            $project_id = 'all';
            $status_group = 0;
        } else {
            $this->loadModel("Project");
            $getprojectId = $this->Project->find("first", array('conditions' => array('Project.uniq_id' => $projUniq)));
            $status_group = $getprojectId['Project']['status_group_id'];
            // pr($status_group); exit;
        }
        if (isset($_COOKIE['TASKSORTBY'])) {
            $sortby = $_COOKIE['TASKSORTBY'];
            $sortorder = $_COOKIE['TASKSORTORDER'];
        } else {
            $sortorder = 'DESC';
        }
        if (!empty($inactiveFlag)) {
            if (!empty($csNum) && $csNum != 'null') {
                if ($csNum == 'desc') {
                    $sortorder = 'ASC';
                } else {
                    $sortorder = 'DESC';
                }
            } else {
                $sortorder = 'ASC';
            }

            $sortby = !empty($type) ? $type : '';
        }
        if ($ajax_group_by == 'Assign to') {
            if($sortby == 'caseAt'){
                $orderby .= "Assigned " . $sortorder;
            }else{
                $orderby .= "Assigned ASC";
            }
        }elseif($ajax_group_by == 'Status'){
            if($status_group == 0){
                $orderby .= "Easycase.legend ASC";
            }else if($status_group >0){
                $orderby .= "Easycase.custom_status_id ASC";
            } 
        }elseif($ajax_group_by == 'Date'){
            if($sortby == 'updated'){
                $orderby .= "Easycase.dt_created " . $sortorder;
            }else{
                $orderby .= "Date(Easycase.dt_created) DESC";
            }
        }elseif($ajax_group_by == 'Priority'){
            if($sortby == 'priority'){
                $orderby .= "Easycase.priority " . $sortorder; 
            }else{
                $orderby .= "Easycase.priority ASC";
            }
        }
        //if ($ajax_group_by != "" && $sortby != "" ) {
        if (!empty($ajax_group_by) &&  $orderby != "") {
            $orderby .= ",";
        }
        if ($sortby == 'title') {
            $orderby .= "LTRIM(Easycase.title) " . $sortorder;
            $caseTitle = strtolower($sortorder);
        } elseif ($sortby == 'duedate') {
            $caseDueDate = strtolower($sortorder);
            $orderby .= "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'estimatedhours') {
            $caseEstHours = strtolower($sortorder);
            $orderby .= "Easycase.estimated_hours " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $caseNum = strtolower($sortorder);
            $orderby .= "Easycase.case_no " . $sortorder;
        } elseif ($sortby == 'caseAt') {
            $caseAtsort = strtolower($sortorder);
            $orderby .= "Assigned " . $sortorder;
        } elseif ($sortby == 'priority') {
            $casePriority = strtolower($sortorder);
            $orderby .= "Easycase.priority " . $sortorder;
        } elseif ($sortby == 'status') {
            $caseStatusby = strtolower($sortorder);
            $orderby .= "Easycase.legend " . $sortorder;
        } else {
            $caseUpdatedby = strtolower($sortorder);
            $orderby .= "Easycase.dt_created " . $sortorder;
        }
        $groupby = '';
        $gby = '';
        $mileSton_orderby = '';
        $case_join = 'LEFT';
        $milstone_filter_condition = '';

        if (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] != 'date') {
            $orderby = ($projUniq=='all')?'Project.name ASC,':'';
            $groupby = $_COOKIE['TASKGROUPBY'];
            if ($groupby != 'milestone') {
                setcookie('TASKSORTBY', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
                setcookie('TASKSORTORDER', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
            }
            if ($groupby == 'status') {
                $gby = 'status';
                $orderby .= " FIND_IN_SET(Easycase.type_id,'10'),FIND_IN_SET(Easycase.legend,'1,2,4,5,3,10') ";
            } elseif ($groupby == 'priority') {
                $orderby .= " if(Easycase.priority = '' or Easycase.priority is null,4,Easycase.priority),Easycase.priority";
                $gby = 'priority';
            } elseif ($groupby == 'duedate') {
                $orderby .= " Easycase.due_date DESC";
                $gby = 'due_date';
            } elseif ($groupby == 'estimatedhours') {
                $orderby .= "Easycase.estimated_hours DESC";
                $gby = 'estimated_hours';
            } elseif ($groupby == 'crtdate') {
                $gby = 'crtdate';
                $orderby .= " Easycase.actual_dt_created DESC";
            } elseif ($groupby == 'assignto') {
                $gby = 'assignto';
                $orderby .= " Assigned ASC";
            } elseif ($groupby == 'milestone') {
                $gby = 'milestone';
                $orderby .=" EasycaseMilestone.milestone_id ASC";

                if ((isset($_COOKIE['TASKGROUP_FIL']) && $_COOKIE['TASKGROUP_FIL']) || (isset($last_filter_taskgroup) && $last_filter_taskgroup)) {
                    if (trim($_COOKIE['TASKGROUP_FIL']) == 'active' || trim($last_filter_taskgroup) == 'active') {
                        $case_join = 'INNER';
                        if ($projUniq == 'all') {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=0 AND Milestone.company_id =' . SES_COMP . ') ';
                        } else {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=0 AND Milestone.company_id =' . SES_COMP . ' AND Milestone.project_id =' . $curProjId . ') ';
                        }
                    } elseif (trim($_COOKIE['TASKGROUP_FIL']) == 'completed' || trim($last_filter_taskgroup) == 'completed') {
                        $case_join = 'INNER';
                        if ($projUniq == 'all') {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=1 AND Milestone.company_id =' . SES_COMP . ') ';
                        } else {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=1 AND Milestone.company_id =' . SES_COMP . ' AND Milestone.project_id =' . $curProjId . ') ';
                        }
                    }
                }
            }

            if ($groupby != 'date' && $ajax_group_by == '') {
                $orderby .=" ,Easycase.dt_created DESC";
                if ($groupby == 'milestone') {
                    $orderby = " CASE WHEN EasycaseMilestone.milestone_id IS NULL THEN 99999999999999 ELSE EasycaseMilestone.m_order END  ASC, EasycaseMilestone.milestone_id ASC ";
                    if ($sortby == 'duedate') {
                        $caseDueDate = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.due_date " . $sortorder;
                    } elseif ($sortby == 'estimatedhours') {
                        $caseEstHours = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.estimated_hours " . $sortorder;
                    } elseif ($sortby == 'caseAt') {
                        $caseAtsort = strtolower($sortorder);
                        $mileSton_orderby = " ,Assigned " . $sortorder;
                    } elseif ($sortby == 'title') {
                        $caseTitle = strtolower($sortorder);
                        $mileSton_orderby = " ,LTRIM(Easycase.title) " . $sortorder;
                    } elseif ($sortby == 'caseno') {
                        $caseNum = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.case_no " . $sortorder;
                    } elseif ($sortby == 'priority') {
                        $casePriority = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.priority " . $sortorder;
                    } elseif ($sortby == 'updated') {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.dt_created " . $sortorder;
                    } else {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,EasycaseMilestone.id_seq ASC,Easycase.seq_id ASC ";
                    }
                }
            }
        }
        ######### Search by KeyWord ##########
        $searchcase = "";
        if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
            //$qry="";
            $filterenabled = 1;
            $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
        }

        if (trim(urldecode($case_srch)) != "") {
            //$qry="";
            $filterenabled = 1;
            $searchcase = "AND (Easycase.case_no = '$case_srch')";
        }

        if (trim(urldecode($caseSrch))) {
            $filterenabled = 1;
            if ((substr($caseSrch, 0, 1)) == '#') {
                //$qry="";
                $tmp = explode("#", $caseSrch);
                $casno = trim($tmp['1']);
                $searchcase = " AND (Easycase.case_no = '" . $casno . "')";
            }
        }

        $cond_easycase_actuve = "";

        if ((isset($case_srch) && !empty($case_srch)) || isset($caseSrch) && !empty($caseSrch)) {
            $cond_easycase_actuve = "";
        } else {
            $cond_easycase_actuve = "AND Easycase.isactive=1";
        }

        if (trim($case_date) != "") {
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            
            if (trim($case_date) == 'one') {
                $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
            } elseif (trim($case_date) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
            }
            elseif (trim($case_date) == 'today') {
                $filterenabled = 1;
                $from_d = date("Y-m-d 00:00:00", strtotime($GMT_DATE));
                $to_d = date("Y-m-d 23:59:59", strtotime($GMT_DATE));
                $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d H:i:s', strtotime($from_d)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d H:i:s', strtotime($to_d)) . "'";
              
            }elseif (trim($case_date) == 'week') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
            } elseif (trim($case_date) == 'month') {
                $filterenabled = 1;
                $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
            } elseif (trim($case_date) == 'year') {
                $filterenabled = 1;
                $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
            } elseif (strstr(trim($case_date), "_")) {
                $filterenabled = 1;
                //echo $case_date;exit;
                $ar_dt = explode("_", trim($case_date));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        

        if (trim($case_duedate) != "") {
            $case_duedate = urldecode($case_duedate);
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if (trim($case_duedate) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
            } elseif (trim($case_duedate) == 'overdue') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) ";
            } elseif (strstr(trim($case_duedate), ":") && trim($case_duedate) !== '0000-00-00 00:00:00') {
                $filterenabled = 1;
                $ar_dt = explode(":", trim($case_duedate));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        ######### Filter by Assign To ##########
        if (!$this->Format->isAllowed('View All Task', $roleAccess)) {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        } elseif ($caseMenuFilters == "favourite") {
            if ($projUniq != 'all') {
                $this->loadModel('ProjectUser');
                $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
                if (count($projArr)) {
                    $curProjId = $projArr['Project']['id'];
                    $curProjShortName = $projArr['Project']['short_name'];
                    $conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                    $this->loadModel('EasycaseFavourite');
                    $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                    //if(!empty($easycase_favourite)){
                    $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                    //}
                }
            } else {
                $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                $this->loadModel('EasycaseFavourite');
                $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                // if(!empty($easycase_favourite)){
                $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                // }
            }
        }
        ######### Filter by Delegate To ##########
        elseif ($caseMenuFilters == "delegateto") {
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
        } elseif ($caseMenuFilters == "closedtasks") {
            $qry.= " AND (Easycase.legend='3' OR Easycase.legend='5') AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "overdue") {
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $cur_dt = date('Y-m-d', strtotime(GMT_DATETIME));
            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date != '0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND DATE(Easycase.due_date) < '" . $cur_dt . "' AND (Easycase.legend !=3) AND (Easycase.legend !=5) ";
        } elseif ($caseMenuFilters == "highpriority") {
            $qry.= " AND Easycase.priority ='0' ";
        } elseif ($caseMenuFilters == "openedtasks") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='4')  AND Easycase.type_id !='10'";
        }
        if (!empty($search_val) && !empty($inactiveFlag)) {
            $qry.= "AND Easycase.title LIKE '%" . trim($search_val) . "%'";
        }
        ######### Filter by Latest ##########
        elseif ($caseMenuFilters == "latest") {
            $filterenabled = 1;
            $qry_rest = $qry;
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $all_rest = " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            $qry_rest.= " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
        }
        if ($caseMenuFilters == "latest" && $projUniq != 'all') {
            $CaseCount3 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase WHERE istype='1' " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry_rest));
            $CaseCount = $CaseCount3['0']['0']['count'];
            if ($CaseCount == 0) {
                $rest = $this->Easycase->query("SELECT dt_created FROM easycases WHERE project_id ='" . $curProjId . "' ORDER BY dt_created DESC LIMIT 0 , 1");
                @$sdate = explode(" ", @$rest[0]['easycases']['dt_created']);
                $qry.= " AND Easycase.dt_created >= '" . @$sdate[0] . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            } else {
                $qry = $qry . $all_rest;
            }
        } elseif ($caseMenuFilters == "latest" && $projUniq == 'all') {
            $qry = $qry . $all_rest;
        }

        ######### Close a Case ##########
        if ($changecasetype) {
            $caseid = $changecasetype;
        } elseif ($caseChangeDuedate) {
            $caseid = $caseChangeDuedate;
        } elseif ($caseChangePriority) {
            $caseid = $caseChangePriority;
        } elseif ($caseChangeAssignto) {
            $caseid = $caseChangeAssignto;
        }

        if ($caseid) {
            //$checkStatus = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $caseid . "' AND isactive='1'");
            $checkStatus = $this->Easycase->find('all', array('conditions' => array('id' => $caseid, 'isactive' => '1'), 'fields' => array('legend')));

            if ($checkStatus['0']['Easycase']['legend'] == 1) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#763532" style="font:normal 12px verdana;">NEW</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 4) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 5) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 3) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            }
        }

        $commonAllId = "";
        $caseid_list = '';
        if ($startCaseId) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $startCaseId;
            $emailType = "Start";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font> the Task.';
        } elseif ($caseResolve) {
            $csSts = 1;
            $csLeg = 5;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseResolve;
            $emailType = "Resolve";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = '<font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font> the Task.';
        } elseif ($caseNew) {
            $csSts = 1;
            $csLeg = 1;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseNew;
            $emailType = "New";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = 'Changed the status of the task to<font color="#F08E83" style="font:normal 12px verdana;">NEW</font>.';
        } elseif ($caseUniqId) {
            $csSts = 2;
            $csLeg = 3;
            $acType = 1;
            $cuvtype = 3;
            $commonAllId = $caseUniqId;
            $emailType = "Close";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            $emailbody = '<font color="green" style="font:normal 12px verdana;">CLOSED</font> the Task.';
        } elseif ($changecasetype) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $changecasetype;
            $emailType = "Change Type";
            $caseChageType1 = 1;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the type of</font> the Task.';
        } elseif ($caseChangeDuedate) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeDuedate;
            $emailType = "Change Duedate";
            $caseChageDuedate1 = 3;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the due date of</font> the Task.';
        } elseif ($caseChangePriority) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangePriority;
            $emailType = "Change Priority";
            $caseChagePriority1 = 2;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the priority of</font> the Task.';
        } elseif ($caseChangeAssignto) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeAssignto;
            $emailType = "Change Assignto";
            $caseChangeAssignto1 = 4;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the assigned to of</font> the Task.';
        }

        if ($commonAllId) {
            $commonAllId = $commonAllId . ",";
            $commonArrId = explode(",", $commonAllId);
            $done = 1;
            if ($caseChageType1 || $caseChageDuedate1 || $caseChagePriority1 || $caseChangeAssignto1) {
            } else {
                $commonArrId_t = array_filter($commonArrId);
                foreach ($commonArrId as $commonCaseId) {
                    if (trim($commonCaseId)) {
                        /* dependency check start */
                        $allowed = "Yes";
                        $depends = $this->Easycase->find('first', array('conditions' => array('id' => $commonCaseId)));
                        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
                            $result = $this->Easycase->find('all', array('conditions' => array('id IN (' . $depends['Easycase']['depends'] . ')')));
                            if (is_array($result) && count($result) > 0) {
                                foreach ($result as $key => $parent) {
                                    if (($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) || ($parent['Easycase']['legend'] == 3)) {
                                        // NO ACTION
                                    } else {
                                        $allowed = "No";
                                    }
                                }
                            }
                        }
                        /* dependency check end */
                        if ($allowed == 'No') {
                            $resCaseProj['errormsg'] = __('Dependant tasks are not closed.', true);
                        } else {
                            $done = 1;
                            $checkSts = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $commonCaseId . "' AND isactive='1'");
                            if (isset($checkSts['0']) && count($checkSts['0']) > 0) {
                                if ($checkSts['0']['easycases']['legend'] == 3) {
                                    $done = 0;
                                }
                                if ($csLeg == 4) {
                                    if ($checkSts['0']['easycases']['legend'] == 4) {
                                        $done = 0;
                                    }
                                }
                                if ($csLeg == 5) {
                                    if ($checkSts['0']['easycases']['legend'] == 5) {
                                        $done = 0;
                                    }
                                }
                            } else {
                                $done = 0;
                            }
                            if ($done) {
                                $caseid_list .= $commonCaseId . ',';
                                $caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to')));
                                $caseStsId = $caseDataArr['Easycase']['id'];
                                $caseStsNo = $caseDataArr['Easycase']['case_no'];
                                $closeStsPid = $caseDataArr['Easycase']['project_id'];
                                $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                                $closeStsPri = $caseDataArr['Easycase']['priority'];
                                $closeStsTitle = $caseDataArr['Easycase']['title'];
                                $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                                $caUid = $caseDataArr['Easycase']['assign_to'];

                                $this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");
                                /* Delete previous RA **/
                                if ($this->Format->isResourceAvailabilityOn() && $csLeg == 3) {
                                    foreach ($casearr as $casek=>$casev) {
                                        $this->Format->delete_booked_hours(array('easycase_id' => $caseStsId, 'project_id' =>$closeStsPid));
                                    }
                                }
                                /* End */
                                $caseuniqid = $this->Format->generateUniqNumber();
                                $this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . SES_ID . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                                //$thisCaseId = mysql_insert_id();
                                //socket.io implement start

                                $this->ProjectUser->recursive = -1;
                                $getUser = $this->ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $closeStsPid . "'");
                                $prjuniq = $this->Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
                                $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
                                $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                                $channel_name = $prjuniqid;

                                if ($csLeg == 3) {
                                    //on close of parent task close all children tasks
                                    $child_tasks = $this->Easycase->getSubTaskChild($commonCaseId, $caseDataArr['Easycase']['project_id']);
                                    if ($child_tasks) {
                                        $this->closerecursiveTaskFrmList($child_tasks['data'], $prjuniq);
                                    }
                                }

                                $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                                if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'osnewui16.com')) {
                                    $resCaseProj['iotoserver']= array('channel' => $channel_name, 'message' => $msgpub);
                                    //$this->Postcase->iotoserver(array('channel' => $channel_name, 'message' => $msgpub));
                                    //socket.io implement end
                                }
                            }
                        }
                    }
                }
            }
            $_SESSION['email']['email_body'] = $emailbody;
            $_SESSION['email']['msg'] = $msg;
            if ($caseChageType1 == 1) {
                $caseid_list = $commonAllId;
            } elseif ($caseChagePriority1 == 2) {
                $caseid_list = $commonAllId;
            } elseif ($caseChageDuedate1 == 3) {
                $caseid_list = $commonAllId;
            } elseif ($caseChangeAssignto1 == 4) {
                $caseid_list = $commonAllId;
            }
            $email_notification = array('allfiles' => $allfiles, 'caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg, 'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo, 'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid, 'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'caseUniqId' => $closeStsUniqId); // $caseuniqid

            $resCaseProj['email_arr'] = json_encode($email_notification);
        }
        $msQuery1 = " ";
        if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
            $msQuery = "";
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                foreach ($expMilestoneIds as $msid) {
                    if ($msid) {
                        $msQuery.= "EasycaseMilestone.milestone_id=" . $msid . " OR ";
                    }
                }
                if ($msQuery) {
                    $msQuery = substr($msQuery, 0, -3);
                    $msQuery = " AND (" . $msQuery . ")";
                }
            } else {
                $tody = date('Y-m-d', strtotime("now"));
            }
        }

        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        $resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['curProjId'] = $curProjId;
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['csTtl'] = $caseTitle;
        $resCaseProj['csDuDt'] = $caseDueDate;
        $resCaseProj['csEstHrsSrt'] = $caseEstHours;
        $resCaseProj['csCrtdDt'] = $caseCreateDate;
        $resCaseProj['csNum'] = $caseNum;
        $resCaseProj['csLgndSrt'] = $caseLegendsort;
        $resCaseProj['csAtSrt'] = $caseAtsort;

        $resCaseProj['csPriSrt'] = $casePriority;
        $resCaseProj['csStusSrt'] = $caseStatusby;
        $resCaseProj['csUpdatSrt'] = $caseUpdatedby;

        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        $mileSton_names = array();
        $all_mileSton_names = array();
        $all_prj_names = null;

        if ($projUniq) {
            //$this->Easycase->query('SET CHARACTER SET utf8');
            $page = $casePage;
            $limit1 = $page * $page_limit - $page_limit;
            $limit2 = $page_limit;

            if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                if ($milestone_type == 0) {
                    $qrycheck = "Milestone.isactive='0'";
                } else {
                    $qrycheck = "Milestone.isactive='1'";
                }
                if ($projUniq != 'all') {
                    $caseAll = $this->Easycase->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0 ) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0) AND E1.project_id!=0 AND E1.project_id='$curProjId') AS sub_sub_task FROM ( SELECT Easycase.*,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq,EasycaseMilestone.m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase,easycase_milestones AS EasycaseMilestone,milestones AS Milestone WHERE EasycaseMilestone.easycase_id=Easycase.id AND Milestone.id=EasycaseMilestone.milestone_id" . $msQuery1 . "AND Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND " . $qrycheck . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " AND EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.project_id=" . $curProjId . $msQuery . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY Easycase.end_date ASC,Easycase.Mtitle ASC," . $orderby . " LIMIT $limit1,$limit2");
                }
                if ($projUniq == 'all') {
                    $caseAll = $this->Easycase->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned  ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0 ) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0) AND E1.project_id!=0 AND E1.project_id='$curProjId') AS sub_sub_task FROM ( SELECT  Easycase.*,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq,EasycaseMilestone.m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase,easycase_milestones AS EasycaseMilestone,milestones AS Milestone WHERE EasycaseMilestone.easycase_id=Easycase.id AND Milestone.id=EasycaseMilestone.milestone_id AND Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND " . $qrycheck . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . " AND EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')" . $msQuery . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY Easycase.end_date ASC,Easycase.Mtitle ASC," . $orderby . " LIMIT $limit1,$limit2");
                }
            } else {
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                if ($projUniq == 'all') {
                    if ($this->Format->isAllowed('View All Task', $roleAccess)) {
                        $over_due_task_count = $this->Easycase->query("SELECT COUNT(*) as cnt from easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND  Easycase.project_id<>0 AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3)");
                    }else{
                        $over_due_task_count = $this->Easycase->query("SELECT COUNT(*) as cnt from easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND  Easycase.project_id<>0 AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) AND (Easycase.user_id = ".SES_ID." OR Easycase.assign_to = ".SES_ID.")");
                    }
                    
                    $over_due_task_count = $over_due_task_count[0][0]['cnt'];
                    if ($caseMenuFilters == "latest") {
                        // Target_4
                        
                        /* EXISTING METHOD
                        $caseAll = $this->Easycase->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AND E1.project_id!=0 AND E1.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AS sub_sub_task FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id FROM easycases as Easycase WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.dt_created DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT $limit1,$limit2");

                        */
                      
                        /* Modified on 21.12.2020 by Tapan Sir */
                        $caseAll = $this->Easycase->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where
						easycases.id=Easycase.parent_task_id AND Easycase.project_id!=0 AND easycases.project_id =Easycase.project_id ) AS is_sub_sub_task,(SELECT count(parent_task_id) from
						easycases as E1 where E1.parent_task_id IN (SELECT id FROM easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id!=0 AND E2.project_id =Easycase.project_id) AND E1.project_id!=0 AND E1.project_id =Easycase.project_id) AS sub_sub_task FROM (SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,
						Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,
						Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.initial_due_date,Easycase.due_date,Easycase.istype,
						Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,
						Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.
						from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,
						Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id FROM easycases as Easycase WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project
						WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . " ORDER BY Easycase.dt_created DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT $limit1,$limit2");
                    } else {
                        /* EXISTING METHOD

                       $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AND E1.project_id!=0 AND E1.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AS sub_sub_task FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id  FROM easycases as Easycase WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.project_id DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT $limit1,$limit2";

                        */
                        
                        /* Query optimized by Tapan Sir on 16.12.2020 */
                        
						 $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where easycases.project_id =Easycase.project_id AND id=Easycase.parent_task_id AND Easycase.project_id!=0 ) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.project_id =Easycase.project_id AND E2.parent_task_id = Easycase.id AND Easycase.project_id!=0 ) AND E1.project_id!=0 AND E1.project_id =Easycase.project_id) AS sub_sub_task,ifnull(lt.tot_spent_hour,0) tot_spent_hour FROM (SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.initial_due_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id  FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.project_id DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id LEFT JOIN (select sum(t.total_hours) as tot_spent_hour, t.task_id from log_times t, project_users p where t.project_id=p.project_id and p.company_id='" . SES_COMP . "' and t.user_id =p.user_id group by t.task_id ) as lt ON Easycase.id = lt.task_id ORDER BY " . $orderby . " LIMIT $limit1,$limit2";
						//echo $req_sql;exit;
                        
                        if ($gby == 'milestone') {
                            /* Code commented by Tapan Sir 04.01.2021

                            $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id as mid,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AND E1.project_id!=0 AND E1.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')) AS sub_sub_task FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id  FROM easycases as Easycase WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.project_id DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " ORDER BY " . $orderby . $mileSton_orderby . "   LIMIT $limit1,$limit2";  */
                            
                            
                            $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id as mid,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id!=0 AND easycases.project_id=Easycase.project_id) AS is_sub_sub_task,(
						SELECT 
							count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id!=0 AND E2.project_id=Easycase.project_id) AND E1.project_id!=0 AND E1.project_id = Easycase.project_id
						) AS sub_sub_task FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.initial_due_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id  FROM easycases as Easycase WHERE Easycase.istype=1 AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive=1 AND ProjectUser.company_id=" . SES_COMP . ") " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.project_id DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " ORDER BY " . $orderby . $mileSton_orderby . "   LIMIT $limit1,$limit2";
                        }
                        //print $req_sql;exit;
                        $caseAll = $this->Easycase->query($req_sql);
                        $allCSByProj = $this->Format->getStatusByProject('all');
                        if ($gby == 'milestone') {
                            $results_mids = Hash::extract($caseAll, '{n}.EasycaseMilestone.mid');
                            $results_mids = array_filter($results_mids);

                            if ($results_mids) {
                                $cond = array('conditions' => array('Milestone.id' => $results_mids), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.title', 'Milestone.isactive', 'Milestone.project_id','Milestone.estimated_hours','Milestone.start_date','Milestone.end_date'));
                                $mileSton_names = $this->Milestone->find('all', $cond);
                                $mileSton_names = Hash::combine($mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                                foreach ($mileSton_names as $miik => $miiv) {
                                    $mileSton_names[$miik]['title'] = htmlspecialchars_decode($miiv['title']);
                                }
                            }
                        }
                    }
                } else {
                    if($this->Format->isAllowed('View All Task', $roleAccess)) {
                        $over_due_task_count = $this->Easycase->query("SELECT COUNT(*) as cnt from easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id=".$curProjId." AND  Easycase.project_id<>0 AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3)");
                    }else{
                        $over_due_task_count = $this->Easycase->query("SELECT COUNT(*) as cnt from easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id=".$curProjId." AND  Easycase.project_id<>0 AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) AND (Easycase.user_id = ".SES_ID." OR Easycase.assign_to = ".SES_ID.")");
                    }
                   $over_due_task_count = $over_due_task_count[0][0]['cnt'];
                    /*
                    //Existing Query

                    $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0) AND E1.project_id!=0 AND E1.project_id='$curProjId') AS sub_sub_task FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id<>0  " . $searchcase . " " . trim($qry) . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT $limit1,$limit2";

                    */
                    
                    
                    // Query optimized by Tapan sir(17.12.2020)
                    
					$req_sql = "
                    SELECT
                        SQL_CALC_FOUND_ROWS
                        Easycase.id,
                        Easycase.uniq_id,
                        Easycase.case_no,
                        Easycase.case_count,
                        Easycase.project_id,
                        Easycase.user_id,
                        Easycase.updated_by,
                        Easycase.type_id,Easycase.
                        priority,Easycase.title,
                        Easycase.estimated_hours,
                        Easycase.hours,
                        Easycase.completed_task,
                        Easycase.assign_to,
                        Easycase.gantt_start_date,
												Easycase.initial_due_date,
                        Easycase.due_date,
                        Easycase.istype,
                        Easycase.client_status,
                        Easycase.format,
                        Easycase.status,
                        Easycase.legend,
                        Easycase.is_recurring,
                        Easycase.isactive,
                        Easycase.dt_created,
                        Easycase.actual_dt_created,
                        Easycase.reply_type,
                        Easycase.is_chrome_extension,
                        Easycase.from_email,
                        Easycase.depends,
                        Easycase.children,
                        Easycase.temp_est_hours,
                        Easycase.seq_id,
                        Easycase.parent_task_id,
                        Easycase.story_point,
                        Easycase.thread_count,
                        Easycase.custom_status_id,
                        User.short_name,
                        User.name,
                        IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,
                        Easycase.is_sub_sub_task,
                        IFNULL(Easycase.sub_sub_task,0) sub_sub_task,
                        Easycase.tot_spent_hour
                     FROM 
                     ( 
                         SELECT Easycase.id,
                         Easycase.uniq_id,
                         Easycase.case_no,
                         Easycase.case_count,
                         Easycase.project_id,
                         Easycase.user_id,
                         Easycase.updated_by,
                         Easycase.type_id,
                         Easycase.priority,
                         Easycase.title,
                         Easycase.estimated_hours,
                         Easycase.hours,
                         Easycase.completed_task,
                         Easycase.assign_to,
                         Easycase.gantt_start_date,
												 Easycase.initial_due_date,
                         Easycase.due_date,
                         Easycase.istype,
                         Easycase.client_status,
                         Easycase.format,
                         Easycase.status,
                         Easycase.legend,
                         Easycase.is_recurring,
                         Easycase.isactive,
                         Easycase.dt_created,
                         Easycase.actual_dt_created,
                         Easycase.reply_type,
                         Easycase.is_chrome_extension,
                         Easycase.from_email,
                         Easycase.depends,
                         Easycase.children,
                         Easycase.temp_est_hours,
                         Easycase.seq_id,
                         Easycase.parent_task_id,
                         Easycase.story_point,
                         Easycase.thread_count,
                         Easycase.custom_status_id,
                         is_sub_sub_task,
                         sub_sub_task,
						 tot_spent_hour
                         FROM easycases as Easycase 
					LEFT JOIN
                    (
                        SELECT
                         id,
                         parent_task_id AS is_sub_sub_task,
                         count(parent_task_id
                    ) 
                         sub_sub_task
                             FROM easycases as Easycase
                             WHERE project_id=".$curProjId." AND istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " GROUP BY id,parent_task_id 
                    ) IS_SUB ON IS_SUB.id=Easycase.parent_task_id
                             LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id
                             LEFT JOIN (select sum(t.total_hours) as tot_spent_hour, t.task_id from log_times  t WHERE  t.project_id=".$curProjId." group by t.task_id ) as lt ON Easycase.id = lt.task_id
                             WHERE 
                                istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND 
                                Easycase.project_id=".$curProjId." AND
                                Easycase.project_id<>0  " . $searchcase . " " . trim($qry) . " 
                ) AS Easycase
                 LEFT JOIN users User ON Easycase.assign_to=User.id
                 ORDER BY " . $orderby . "
                 LIMIT $limit1,$limit2";
                //echo $req_sql;exit;	

                    if ($gby == 'milestone') {
                        /*
                        //Existing Query
                            $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id as mid,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT parent_task_id from easycases where id=Easycase.parent_task_id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0) AS is_sub_sub_task,(SELECT count(parent_task_id) from easycases as E1 where E1.parent_task_id IN (SELECT id from easycases as E2 where E2.parent_task_id = Easycase.id AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0) AND E1.project_id!=0 AND E1.project_id='$curProjId') AS sub_sub_task FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id  FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id AND EasycaseMilestone.project_id ='" . $curProjId . "' " . $milstone_filter_condition . " ORDER BY " . $orderby . $mileSton_orderby . "  LIMIT $limit1,$limit2";

                              */
                    
                    
                        // Query optimized by Tapan sir(17.12.2020)
                    
					 $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.initial_due_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id,EasycaseMilestone.milestone_id as mid,User.short_name,IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,Easycase.is_sub_sub_task,IFNULL(Easycase.sub_sub_task,0) as sub_sub_task FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.initial_due_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id,IS_SUB.is_sub_sub_task,IS_SUB.sub_sub_task FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id LEFT JOIN (SELECT id,parent_task_id AS is_sub_sub_task,count(parent_task_id) sub_sub_task FROM easycases WHERE
                     project_id=".$curProjId." AND project_id!=0 AND istype=1 AND 1 AND isactive=1 	GROUP BY id,parent_task_id ) IS_SUB ON IS_SUB.id=Easycase.parent_task_id WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id AND EasycaseMilestone.project_id ='" . $curProjId . "' " . $milstone_filter_condition . " ORDER BY " . $orderby . $mileSton_orderby . "  LIMIT $limit1,$limit2";
                    }
                    $caseAll = $this->Easycase->query($req_sql);
                    $allCSByProj = $this->Format->getStatusByProject($curProjId);
                    if ($gby == 'milestone') {
                        $results_mids = Hash::extract($caseAll, '{n}.EasycaseMilestone.mid');
                        $results_mids = array_unique(array_filter($results_mids));

                        if ($results_mids) {
                            $cond = array('conditions' => array('Milestone.id' => $results_mids), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.title', 'Milestone.isactive', 'Milestone.project_id','Milestone.estimated_hours','Milestone.start_date','Milestone.end_date'));
                            $mileSton_names = $this->Milestone->find('all', $cond);
                            $mileSton_names = Hash::combine($mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                            foreach ($mileSton_names as $miik => $miiv) {
                                $mileSton_names[$miik]['title'] = htmlspecialchars_decode($miiv['title']);
                                $mileSton_names[$miik]['estimated_hours'] = $this->Format->formatTGMeta($miiv['estimated_hours'], 'est');
                                $mileSton_names[$miik]['start_date'] = $this->Format->formatTGMeta($miiv['start_date'], 'sdate');
                                $mileSton_names[$miik]['end_date'] = $this->Format->formatTGMeta($miiv['end_date'], 'edate');
                            }
                        }
                    }
                }
            }

            if ($gby == 'milestone') {
                if ($projUniq == 'all') {
                    $req_sql_cnt = "SELECT count(Easycase.id) as cnt FROM ( SELECT Easycase.* FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . " ) AS Easycase " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby;
                    $tot = $this->Easycase->query($req_sql_cnt);
                } else {
                    $req_sql_cnt = "SELECT count(Easycase.id) as cnt FROM ( SELECT Easycase.* FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby;
                    $tot = $this->Easycase->query($req_sql_cnt);
                }
                $CaseCount = $tot[0][0]['cnt'];


                $tsk_grp_fl = array(0, 1);
                if (isset($_COOKIE['TASKGROUP_FIL']) && $_COOKIE['TASKGROUP_FIL']) {
                    if (trim($_COOKIE['TASKGROUP_FIL']) == 'active') {
                        $tsk_grp_fl = 1;
                    } elseif (trim($_COOKIE['TASKGROUP_FIL']) == 'completed') {
                        $tsk_grp_fl = 0;
                    }
                }
                if ($projUniq == 'all') {
                    $ec_mil = $this->Easycase->query("SELECT DISTINCT(EasycaseMilestone.milestone_id) as mid FROM easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.project_id IN(SELECT PJU.project_id FROM project_users AS PJU WHERE PJU.company_id = " . SES_COMP . " AND PJU.user_id = " . SES_ID . ")");
                    $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title','Milestone.estimated_hours','Milestone.start_date','Milestone.end_date'), 'order' => 'Milestone.created DESC');
                    if ($ec_mil) {
                        $ec_mil = array_unique(Hash::extract($ec_mil, '{n}.EasycaseMilestone.mid'));
                        $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl, 'NOT' => array('Milestone.id' => $ec_mil)), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title','Milestone.estimated_hours','Milestone.start_date','Milestone.end_date'), 'order' => 'Milestone.created DESC');
                    }
                } else {
                    $ec_mil = $this->Easycase->query("SELECT DISTINCT(EasycaseMilestone.milestone_id) as mid FROM easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.project_id IN(SELECT PJU.project_id FROM project_users AS PJU WHERE PJU.company_id = " . SES_COMP . " AND PJU.user_id = " . SES_ID . " AND PJU.project_id = " . $curProjId . ")");
                    $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl, 'Milestone.project_id' => $curProjId), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title', 'Milestone.isactive','Milestone.estimated_hours','Milestone.start_date','Milestone.end_date'), 'order' => 'Milestone.created DESC');
                    if ($ec_mil) {
                        $ec_mil = array_unique(Hash::extract($ec_mil, '{n}.EasycaseMilestone.mid'));
                        $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl, 'Milestone.project_id' => $curProjId, 'NOT' => array('Milestone.id' => $ec_mil)), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title', 'Milestone.isactive','Milestone.estimated_hours','Milestone.start_date','Milestone.end_date'), 'order' => 'Milestone.created DESC');
                    }
                }
                $all_mileSton_names = $this->Milestone->find('all', $cond);
                $milestone_pids = null;
                if ($projUniq == 'all' && $all_mileSton_names) {
                    $milestone_pids = array_unique(Hash::extract($all_mileSton_names, '{n}.Milestone.project_id'));
                    $cond_pnames = array('conditions' => array('Project.id' => $milestone_pids), 'fields' => array('Project.id', 'Project.name'));
                    $all_prj_names = $this->Project->find('list', $cond_pnames);
                }
                if ($all_mileSton_names) {
                    $all_mileSton_names = Hash::combine($all_mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                    foreach ($all_mileSton_names as $mik => $miv) {
                        $all_mileSton_names[$mik]['title'] = htmlspecialchars_decode($miv['title']);
                        $all_mileSton_names[$mik]['estimated_hours'] = $this->Format->formatTGMeta($miv['estimated_hours'], 'est');
                        $all_mileSton_names[$mik]['start_date'] = $this->Format->formatTGMeta($miv['start_date'], 'sdate');
                        $all_mileSton_names[$mik]['end_date'] = $this->Format->formatTGMeta($miv['end_date'], 'edate');
                    }
                }
            } else {
                if ($projUniq == 'all') {
                    /*
                //Target_8
                // Code commented by Tapan sir on 23.12.2020
                       $req_sql_cnt = "SELECT count(Easycase.id) as total FROM (SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') AND Easycase.project_id<>0  " . $searchcase . " " . trim($qry) . " ) AS Easycase ORDER BY Easycase.id DESC";
                    */
				$req_sql_cnt = "SELECT count(Easycase.id) as total 
        FROM easycases as Easycase 
        LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id
        WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND 
        Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') 
        AND Easycase.project_id<>0  " . $searchcase . " " . trim($qry) . " ORDER BY Easycase.id DESC";
                    $tot = $this->Easycase->query($req_sql_cnt);
                } else {
                    /* Code commented by Tapan Sir
                    $req_sql_cnt = "SELECT count(Easycase.id) as total FROM (SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.story_point,Easycase.thread_count,Easycase.custom_status_id FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id ='$curProjId' AND Easycase.project_id<>0  " . $searchcase . " " . trim($qry) . " ) AS Easycase ORDER BY Easycase.id DESC"; */
                  
                   $req_sql_cnt = "SELECT count(Easycase.id) as total FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id ='$curProjId' AND Easycase.project_id<>0  " . $searchcase . " " . trim($qry) ;
                    $tot = $this->Easycase->query($req_sql_cnt);
                }
                //$tot = $this->Easycase->query("SELECT FOUND_ROWS() as total");
                #pr($tot);exit;
                if (empty($caseAll)) {
                    $CaseCount = 0;
                } else {
                    $CaseCount = $tot[0][0]['total'];
                }
            }
            $msQ = "";
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                $idArr = array();
                foreach ($expMilestoneIds as $msid) {
                    if (trim($msid)) {
                        $idArr[] = trim($msid);
                    }
                }
                if (count($idArr)) {
                    $msQ.= "AND Milestone.id IN (" . implode(",", $idArr) . ")";
                }
            }
            if ($projUniq != 'all') {
                $milestones = array();

                if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                    if ($milestone_type == 0) {
                        $qrycheck = "Milestone.isactive='0'";
                    } else {
                        $qrycheck = "Milestone.isactive='1'";
                    }
                    $milestones = $this->Milestone->query("SELECT `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`end_date`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`  FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id WHERE `Milestone`.`project_id` =" . $curProjId . " AND " . $qrycheck . " AND `Milestone`.`company_id` = " . SES_COMP . " " . $msQ . " GROUP BY Milestone.id ORDER BY `Milestone`.`id` ASC");
                }
                foreach ($milestones as $mls) {
                    $mid.= $mls['Milestone']['id'] . ',';
                    $m[$mls['Milestone']['id']]['id'] = $mls['Milestone']['id'];
                    $m[$mls['Milestone']['id']]['caseids'] = $mls[0]['caseids'];
                    $m[$mls['Milestone']['id']]['totalcases'] = $mls[0]['totalcases'];
                    $m[$mls['Milestone']['id']]['title'] = $mls['Milestone']['title'];
                    $m[$mls['Milestone']['id']]['project_id'] = $mls['Milestone']['project_id'];
                    $m[$mls['Milestone']['id']]['end_date'] = $mls['Milestone']['end_date'];
                    $m[$mls['Milestone']['id']]['uinq_id'] = $mls['Milestone']['uniq_id'];
                    $m[$mls['Milestone']['id']]['isactive'] = $mls['Milestone']['isactive'];
                    $m[$mls['Milestone']['id']]['user_id'] = $mls['Milestone']['user_id'];
                }
                $c = array();

                if ($mid) {
                    $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN(" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
                    foreach ($closed_cases as $key => $val) {
                        $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                    }
                }
                $resCaseProj['milestones'] = $m;
            }
            if ($projUniq == 'all') {
                $milestones = array();
                if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                    if ($milestone_type == 0) {
                        $qrycheck = "Milestone.isactive='0'";
                    } else {
                        $qrycheck = "Milestone.isactive='1'";
                    }
                    $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP, 'Project.isactive' => 1), 'fields' => array('DISTINCT  Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));
                    $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                    $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                    $allProjArr = $this->ProjectUser->find('all', $cond);
                    $ids = array();
                    foreach ($allProjArr as $csid) {
                        array_push($ids, $csid['Project']['id']);
                    }
                    $implode_ids = implode(',', $ids);
                    $this->Milestone->recursive = -1;

                    $milestones = $this->Milestone->query("SELECT `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`end_date`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`  FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id WHERE `Milestone`.`project_id` IN (" . $implode_ids . ") AND " . $qrycheck . " AND `Milestone`.`company_id` = " . SES_COMP . " " . $msQ . " GROUP BY Milestone.id ORDER BY `Milestone`.`id` ASC");

                    $mid = '';
                    foreach ($milestones as $k => $v) {
                        $mid.= $v['Milestone']['id'] . ',';
                        $m[$v['Milestone']['id']]['id'] = $v['Milestone']['id'];
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
                        $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN (" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
                        foreach ($closed_cases as $key => $val) {
                            $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                        }
                    }
                    $resCaseProj['milestones'] = $m;
                }
            }
            #pr($caseAll);exit;
            $usrDtlsAll = null;
            if (!empty($caseAll)) {
                $ecs_updated_by = Hash::extract($caseAll, '{n}.Easycase.updated_by');
                $ecs_user_id = Hash::extract($caseAll, '{n}.Easycase.user_id');
                $ecs_assign_to = Hash::extract($caseAll, '{n}.Easycase.assign_to');
                $tot_ecs_users = array_values(array_filter(array_unique(array_merge($ecs_updated_by, $ecs_user_id, $ecs_assign_to), SORT_REGULAR)));
                if ($tot_ecs_users) {
                    $usrDtlsAll = $this->User->find('all', array('conditions' => array('User.id' => $tot_ecs_users), 'fields' => array('User.id', 'User.name', 'User.email', 'User.istype','User.email','User.short_name','User.photo'), 'order' => array('User.short_name ASC')));
                }
            }
            $usrDtlsArr = array();
            $usrDtlsPrj = array();
            if ($usrDtlsAll) {
                foreach ($usrDtlsAll as $ud) {
                    $usrDtlsArr[$ud['User']['id']] = $ud;
                }
            }
        } else {
            $CaseCount = 0;
        }
        $resCaseProj['caseCount'] = $CaseCount;

        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
        $cq = $view->loadHelper('Casequery');
        $frmt = $view->loadHelper('Format');
        $related_tasks = array();
        if (is_array($caseAll) && count($caseAll) > 0) {
            //$parent_task_id = array_filter(Hash::combine($caseAll, '{n}.Easycase.id', '{n}.Easycase.parent_task_id'));
            //$related_tasks = !empty($parent_task_id) ? $this->Easycase->getSubTasks($parent_task_id) : array();
            $related_tasks = array();
            $taskIds = Hash::extract($caseAll, '{n}.Easycase.id');
            //$ParenttaskIds = Hash::extract($caseAll, '{n}.Easycase.parent_task_id');
            $ParenttaskIds = array();
            $dependency = array();
            /*if (is_array($taskIds) && count($taskIds) > 0) {
                $this->loadModel('EasycaseLink');
                $links = $this->EasycaseLink->find('all', array('conditions' => array('OR' => array('EasycaseLink.source' => $taskIds, 'EasycaseLink.target' => $taskIds))));
                if (is_array($links) && count($links) > 0) {
                    foreach ($links as $link) {
                        $dependency['children'][$link['EasycaseLink']['source']][] = $link['EasycaseLink']['target'];
                        $dependency['depends'][$link['EasycaseLink']['target']][] = $link['EasycaseLink']['source'];
                    }
                }
            }*/
        }
        $resCaseProj['related_tasks'] = $related_tasks;
        $resCaseProj['task_parent_ids'] = $ParenttaskIds;
        /* Adding CF names as title in case list -- Start--*/
        $this->loadModel('CustomFieldValue');
        $task_ids = array_filter(array_unique(Hash::extract($caseAll, '{n}.Easycase.id')));
        $getAllCustomFields = [];
        if ($task_ids) {
            $getAllCustomFields = $this->CustomFieldValue->getAllCustomFieldByTaskIds($task_ids, SES_COMP);     
        }
        /* Checking whether the user is allowed to see Advanced custom fields */
        $allowAdvancedCustomField = $this->Format->isAllowedAdvancedCustomFields();                     
        $resCaseProj['allowAdvancedCustomField']= $allowAdvancedCustomField;      
        /* --End-- */
        $this->loadModel('CustomField');
        $resCaseProj['allCustomFields'] = $this->CustomField->getAllActiveCustomFields();

        $resCaseProj['custom_field_ids'] = array_keys($resCaseProj['allCustomFields']);
        $resCaseProj['custom_field_head'] = array_values($resCaseProj['allCustomFields']);
        // pr($resCaseProj['custom_field_head']); exit;
        $frmtCaseAll = $this->Easycase->formatCases($caseAll, $CaseCount, $caseMenuFilters, $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, null, $dependency, 0, $getAllCustomFields, $resCaseProj['allCustomFields']);
        $resCaseProj['caseAll'] = $frmtCaseAll['caseAll'];
    //    pr($frmtCaseAll); exit;
        /* Calculating time balance for all looping task in task list page -Start- */
         
       $getActiveAdvCustomField = $this->CustomField->fetchActiveAdvCustomField(SES_COMP);                    
       $activeAdvCustomFieldArray = Hash::extract($getActiveAdvCustomField, "{n}.CustomField.placeholder");
     
       if(in_array('timeBalance',$activeAdvCustomFieldArray)) {
           $timeBalanceIsOn = '1';
       } else {
           $timeBalanceIsOn = '0';
       }       
        $resCaseProj['timeBalanceIsOn'] = $timeBalanceIsOn;     
        /* Calculating time balance for all looping task in task list page -End- */
        $resCaseProj['milestones'] = $frmtCaseAll['milestones'];
        $pgShLbl = $frmt->pagingShowRecords($CaseCount, $page_limit, $casePage);
        $resCaseProj['pgShLbl'] = $pgShLbl;

        $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $friday = date('Y-m-d', strtotime($curCreated . "next Friday"));
        $monday = date('Y-m-d', strtotime($curCreated . "next Monday"));
        $tomorrow = date('Y-m-d', strtotime($curCreated . "+1 day"));

        $resCaseProj['intCurCreated'] = strtotime($curCreated);
        $resCaseProj['mdyCurCrtd'] = date('m/d/Y', strtotime($curCreated));
        $resCaseProj['mdyFriday'] = date('m/d/Y', strtotime($friday));
        $resCaseProj['mdyMonday'] = date('m/d/Y', strtotime($monday));
        $resCaseProj['mdyTomorrow'] = date('m/d/Y', strtotime($tomorrow));
        $resCaseProj['GrpBy'] = $gby;
        $resCaseProj['milesto_names'] = $mileSton_names;
        $resCaseProj['all_milesto_names'] = $all_mileSton_names;
        $resCaseProj['all_milesto_prj_names'] = ($all_prj_names != null && $all_prj_names) ? $all_prj_names : 0;

        $customStatusByProject = array();
        $lastCustomStatus =[];
        $resCaseProj['QTAssigns']=null;
        if (isset($allCSByProj)) {
            foreach ($allCSByProj as $k=>$v) {
                if (isset($v['StatusGroup']['CustomStatus'])) {
                    $lastCustomStatus['LastCS'] = end($v['StatusGroup']['CustomStatus']);
                    $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                }
            }
        }
        $resCaseProj['customStatusByProject'] = $customStatusByProject;
        $resCaseProj['lastCustomStatus'] = $lastCustomStatus;
        if ($projUniq != 'all') {
            $projUser = array();
            if ($projUniq) {
                $projUser = array($projUniq => $this->Easycase->getMemebers($projUniq));
            }
            $resCaseProj['projUser'] = $projUser;
            $resCaseProj['case_date'] = $case_date;
            $resCaseProj['caseStatus'] = $caseStatus;
            $resCaseProj['caseCustomStatus'] = $caseCustomStatus;
            $resCaseProj['priorityFil'] = $priorityFil;
            $resCaseProj['caseTypes'] = $caseTypes;
            $resCaseProj['caseUserId'] = $caseUserId;
            $resCaseProj['caseComment'] = $caseComment;
            $resCaseProj['caseAssignTo'] = $caseAssignTo;
            $resCaseProj['case_duedate'] = $case_duedate;
            //$resCaseProj['caseSrch'] = $caseSrch;
            if (isset($allCSByProj[0]['Project']) && !empty($allCSByProj[0]['Project'])) {
                $prj['Project'] = $allCSByProj[0]['Project'];
            } else {
                $prj = $this->Project->findByUniqId($projUniq);
            }
            if ($projUser) {
                $resCaseProj['QTAssigns'] = Hash::extract($projUser[$projUniq], '{n}.User');
            }
            $resCaseProj['defaultAssign'] = $prj['Project']['default_assign'];
            $resCaseProj['defaultTaskType'] = $prj['Project']['task_type'];
        } else {
            $resCaseProj['defaultAssign'] = SES_ID;
            $resCaseProj['defaultTaskType'] = '';
            $resCaseProj['QTAssigns'][0]['id'] = SES_ID;
            $resCaseProj['QTAssigns'][0]['uniq_id'] = 'me';
            $resCaseProj['QTAssigns'][0]['name'] = 'Me';
        }
        if (isset($caseSrch)) {
            $resCaseProj['caseSrch'] = h($caseSrch);
        }
   // $field_name_arr = array("All", "Priority", "Updated", "Assigned to", "Status", "Due Date","Custom field","Advanced Custom field");
    $field_name_arr = array("All", "Priority", "Updated", "Assigned to", "Status", "Due Date");
        $this->loadModel('TaskField');
        $fields = $this->TaskField->readTaskFieldfromCache(SES_ID);
        if (!empty($fields)) {
            $field_name_arr = json_decode($fields['TaskField']['field_name'], true);
        }
    /* Adding CF names as title in case list -- Start--*/
    if ($getAllCustomFields) {
        //$getAllCustomFields = $this->CustomFieldValue->reorderCustomFieldArray($getAllCustomFields, 'label');
        $resCaseProj['totalColumnCount'] = 13 + count($resCaseProj['allCustomFields']) + count($activeAdvCustomFieldArray);

        //$resCaseProj['customFieldNameArr'] = $getAllCustomFields[0];
        //$resCaseProj['advCustomFieldNameArr'] = $getAllCustomFields[1];
        //$resCaseProj['customFieldCount'] = count($getAllCustomFields[0]);
        //$resCaseProj['advCustomFieldCount'] = count($getAllCustomFields[1]);        
    }else{
        $resCaseProj['totalColumnCount'] = 13;
    }
    /*$this->loadModel('CustomFieldValue');
    $task_ids = array_filter(array_unique(Hash::extract($caseAll, '{n}.Easycase.id')));
    if ($task_ids) {
        $getAllCustomFields = $this->CustomFieldValue->getAllCustomFieldByTaskIds($task_ids, SES_COMP);
        $getAllCustomFields = $this->CustomFieldValue->reorderCustomFieldArray($getAllCustomFields, 'label');
        $resCaseProj['totalColumnCount'] = 11 + count($getAllCustomFields[0]) + count($getAllCustomFields[1]);

        $resCaseProj['customFieldNameArr'] = $getAllCustomFields[0];
        $resCaseProj['advCustomFieldNameArr'] = $getAllCustomFields[1];
        $resCaseProj['customFieldCount'] = count($getAllCustomFields[0]);
        $resCaseProj['advCustomFieldCount'] = count($getAllCustomFields[1]);        
    }else{
        $resCaseProj['totalColumnCount'] = 11;
    }
    // Checking whether the user is allowed to see Advanced custom fields
    $allowAdvancedCustomField = $this->Format->isAllowedAdvancedCustomFields();                     
    $resCaseProj['allowAdvancedCustomField']= $allowAdvancedCustomField;   
    */   
    /* --End-- */
        $resCaseProj['field_name_arr'] = $field_name_arr;
        $resCaseProj['over_due_task_count'] = $over_due_task_count;
        $resCaseProj['ajax_group_by'] = $ajax_group_by;
        if (!empty($inactiveFlag)) {
            return $resCaseProj;
        }
        $this->set('resCaseProj', json_encode($resCaseProj));
    }
    public function saveSelectedColumns()
    {
        $this->loadModel('TaskField');
        $field_name_arr = array();
        $fields = $this->TaskField->find('first', array('conditions' => array('TaskField.user_id' => SES_ID)));
        if (!empty($fields)) {
            $field_name = explode(',', $this->request->data['cols']);
            $field_name = !empty($field_name)?$field_name:array('No Fields');
            $field_names = json_encode($field_name);
            $this->TaskField->id=$fields['TaskField']['id'];
            $this->TaskField->set(array('field_name'=>$field_names));
            $this->TaskField->save();
        } else {
            $field_name = explode(',', $this->request->data['cols']);
            $field_name = !empty($field_name)?$field_name:array('No Fields');
            $field_names = json_encode($field_name);
            $postdata['TaskField']['field_name'] = $field_names;
            $postdata['TaskField']['user_id'] = SES_ID;
            $postdata['TaskField']['created'] = date('Y-m-d H:i:s');
            $postdata['TaskField']['modified'] = date('Y-m-d H:i:s');
            $this->TaskField->save($postdata);
        }
        Cache::delete('task_field_'.SES_ID);
        echo 1;
        exit;
    }
    public function saveSelectedColumnsProject()
    {
        $this->loadModel('ProjectField');
        $field_name_arr = array();
        $fields = $this->ProjectField->find('first', array('conditions' => array('ProjectField.user_id' => SES_ID)));
        if (!empty($fields)) {
            $field_name = explode(',', $this->request->data['cols']);
            $field_name = !empty($field_name)?$field_name:array('No Fields');
            $field_names = json_encode($field_name);
            $this->ProjectField->id=$fields['ProjectField']['id'];
            $this->ProjectField->set(array('field_name'=>$field_names));
            $this->ProjectField->save();
        } else {
            $field_name = explode(',', $this->request->data['cols']);
            $field_name = !empty($field_name)?$field_name:array('No Fields');
            $field_names = json_encode($field_name);
            $postdata['ProjectField']['field_name'] = $field_names;
            $postdata['ProjectField']['user_id'] = SES_ID;
            $postdata['ProjectField']['created'] = date('Y-m-d H:i:s');
            $postdata['ProjectField']['modified'] = date('Y-m-d H:i:s');
            $this->ProjectField->save($postdata);
        }
        Cache::delete('project_field_'.SES_ID);
        echo 1;
        exit;
    }
    public function saveFormFileds()
    {
        $this->loadModel('TaskField');
        $field_name_arr = array();
        $fields = $this->TaskField->find('first', array('conditions' => array('TaskField.user_id' => SES_ID)));
        $field_names = $this->request->data['fieldID'];
        $types = $this->request->data['type'];

        if ($types =='project') {
            if (!empty($fields)) {
                $this->TaskField->id=$fields['TaskField']['id'];
                $this->TaskField->set(array('project_form_fields'=>implode(',', $field_names)));
                $this->TaskField->save();
            } else {
                $postdata['TaskField']['project_form_fields'] = implode(',', $field_names);
                $postdata['TaskField']['user_id'] = SES_ID;
                $this->TaskField->save($postdata);
            }
        } else {
            if (!empty($fields)) {
                $this->TaskField->id=$fields['TaskField']['id'];
                $this->TaskField->set(array('form_fields'=>implode(',', $field_names)));
                $this->TaskField->save();
            } else {
                $postdata['TaskField']['form_fields'] = implode(',', $field_names);
                $postdata['TaskField']['user_id'] = SES_ID;
                $this->TaskField->save($postdata);
            }
        }
        Cache::delete('task_field_'.SES_ID);
        echo 1;
        exit;
    }
    public function pdfcase_project($inactiveFlag = '', $proUid = '', $inCasePage = '', $type = '', $cases = '', $csNum = '', $search_val = '')
    {
        ini_set('memory_limit', '128M');
        set_time_limit(0);
        $this->layout = 'ajax';
        $uid= $this->params->query['user_id'];
        $auth_user=$this->User->findById($uid);
        $company_user=$this->CompanyUser->findByUserId($uid);
        $dom_array= explode('.', $_SERVER['HTTP_HOST']);
        //$company_data=$this->Company->findBySeoUrl($dom_array[0]);
        //$company_user['CompanyUser']['company_id']=$company_data['Company']['id'];
        $postdata['data']=$this->params->query;
        //Setting up timezone manually
        $timezone = $this->Timezone->find('first', array("conditions" => array("Timezone.id" => $auth_user['User']['timezone_id'])));
       
        if (isset($auth_user['User']['is_dst'])) {
            if (!defined('TZ_DST')) {
                define('TZ_DST', $auth_user['User']['is_dst']);
            }
        } else {
            if (!defined('TZ_DST')) {
                define('TZ_DST', $timezone['Timezone']['dst_offset']);
            }
        }
        if (!defined('TZ_CODE')) {
            define('TZ_CODE', $timezone['Timezone']['code']);
        }
        if (!defined('SES_COMP')) {
            define('SES_COMP', $timezone['Timezone']['code']);
        }
        if (!defined('TZ_GMT')) {
            define('TZ_GMT', $timezone['Timezone']['gmt_offset']);
        }
        if (!defined('SES_TIMEZONE')) {
            define('SES_TIMEZONE', $auth_user['User']['timezone_id']);
        }
        $resCaseProj = array();
        if (empty($inactiveFlag)) {
            $page_limit = 500;
        } else {
            $page_limit = 500;
        }
        if (isset($postdata['data']['filter_taskgroup']) && $postdata['data']['filter_taskgroup'] == 1) {
            if (empty($inactiveFlag)) {
                $page_limit = 500;
            } else {
                $page_limit = 500;
            }
        }
//        pr($this->request->data); exit;
        $this->_datestime();
        if (empty($inactiveFlag)) {
            $projUniq = $postdata['data']['projFil']; // Project Uniq ID
            $projIsChange = $postdata['data']['projIsChange']; // Project Uniq ID
            $caseStatus = $postdata['data']['caseStatus']; // Filter by Status(legend)
            $priorityFil = $postdata['data']['priFil']; // Filter by Priority
            $caseTypes = $postdata['data']['caseTypes']; // Filter by case Types
            $caseLabel = $postdata['data']['caseLabel']; // Filter by case Label
            $caseUserId = $postdata['data']['caseMember']; // Filter by Member
            $caseComment = $postdata['data']['caseComment']; // Filter by Member
						$caseTaskgroup = $postdata['data']['caseTaskGroup'];
            $caseAssignTo = $postdata['data']['caseAssignTo']; // Filter by AssignTo
            $caseDate = $postdata['data']['caseDate']; // Sort by Date
            $caseDueDate = $postdata['data']['caseDueDate']; // Sort by Due Date
            @$case_duedate = $postdata['data']['case_due_date'];
            @$case_date = $postdata['data']['case_date'];
            $caseSrch = $postdata['data']['caseSearch']; // Search by keyword

            $casePage = $postdata['data']['casePage']; // Pagination
            $caseUniqId = $postdata['data']['caseId']; // Case Uniq ID to close a case
            $caseTitle = $postdata['data']['caseTitle']; // Case Uniq ID to close a case
            $caseNum = $postdata['data']['caseNum']; // Sort by Due Date
            $caseLegendsort = $postdata['data']['caseLegendsort']; // Sort by Case Status
            $caseAtsort = $postdata['data']['caseAtsort']; // Sort by Case Status
            $startCaseId = $postdata['data']['startCaseId']; // Start Case
            $caseResolve = $postdata['data']['caseResolve']; // Resolve Case
            $caseNew = $postdata['data']['caseNew']; // New Case
            $caseMenuFilters = $postdata['data']['caseMenuFilters']; // Resolve Case
            $milestoneIds = $postdata['data']['milestoneIds']; // Resolve Case
            $caseCreateDate = $postdata['data']['caseCreateDate']; // Sort by Created Date
            @$case_srch = $postdata['data']['case_srch'];
            @$milestone_type = $postdata['data']['mstype'];
            $changecasetype = $postdata['data']['caseChangeType'];
            $caseChangeDuedate = $postdata['data']['caseChangeDuedate'];
            $caseChangePriority = $postdata['data']['caseChangePriority'];
            $caseChangeAssignto = $postdata['data']['caseChangeAssignto'];
            $customfilterid = $postdata['data']['customfilter'];
            $detailscount = $postdata['data']['detailscount']; // Count number to open casedetails
        } else {
            $projUniq = $proUid;
            $casePage = !empty($inCasePage) ? $inCasePage : 1;
            $caseTitle = $search_val;
        }
        $filterenabled = 0;
        $clt_sql = 1;
        if (empty($inactiveFlag)) {
            if ($auth_user['User']['is_client'] == 1) {
                $clt_sql = "((Easycase.client_status = " . $auth_user['User']['is_client'] . " AND Easycase.user_id = " . $auth_user['User']['id'] . ") OR Easycase.client_status != " . $auth_user['User']['is_client'] . ")";
            }
        }
        /* jyoti start */
        if ($customfilterid) {
            $this->loadModel('CustomFilter');
            $getcustomfilter = "SELECT SQL_CALC_FOUND_ROWS * FROM custom_filters AS CustomFilter WHERE CustomFilter.company_id = '" . $company_user['CompanyUser']['company_id'] . "' and CustomFilter.user_id =  '" . $auth_user['User']['id'] . "' and CustomFilter.id='" . $customfilterid . "' ORDER BY CustomFilter.dt_created DESC ";
            $getfilter = $this->CustomFilter->query($getcustomfilter);

            if ($getfilter) {
                $caseStatus = $getfilter[0]['CustomFilter']['filter_status'];
                $priorityFil = $getfilter[0]['CustomFilter']['filter_priority'];
                $caseTypes = $getfilter[0]['CustomFilter']['filter_type_id'];
                $caseUserId = $getfilter[0]['CustomFilter']['filter_member_id'];
                $caseComment = $getfilter[0]['CustomFilter']['filter_comment'];
                $caseAssignTo = $getfilter[0]['CustomFilter']['filter_assignto'];
                $caseDate = $getfilter[0]['CustomFilter']['filter_date'];
                $case_duedate = $getfilter[0]['CustomFilter']['filter_duedate'];
                $caseSrch = $getfilter[0]['CustomFilter']['filter_search'];
            }
            $filterenabled = 1;
        }
        /* jyoti end */
        
        if ($caseMenuFilters) {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        } else {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        }
        $caseUrl = $this->params->data['caseUrl'];
        ######## get project ID from project uniq-id ################
        $curProjId = null;
        $curProjShortName = null;
        
        if ($projUniq != 'all') {
            /**
             * Binding of Project table is already done in ProjectUser model
             */
            $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
            
            if (empty($inactiveFlag)) {
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => $auth_user['User']['id'], 'Project.isactive' => 1, 'ProjectUser.company_id' => $company_user['CompanyUser']['company_id']), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            } else {
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => $auth_user['User']['id'], 'Project.isactive' => 2, 'ProjectUser.company_id' => $company_user['CompanyUser']['company_id']), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            }
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = $projArr['Project']['short_name'];

                //Updating ProjectUser table to current date-time
                if ($projIsChange != $projUniq && empty($inactiveFlag)) {
                    $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                    $ProjectUser['dt_visited'] = GMT_DATETIME;
                    $this->ProjectUser->save($ProjectUser);
                }
            }
        }
        ######### Filter by CaseUniqId ##########
        $qry = "";
        if (trim($caseUrl)) {
            $filterenabled = 1;
            $qry.= " AND Easycase.uniq_id='" . $caseUrl . "'";
        }
        ######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
            $qry.= $this->Format->statusFilter($caseStatus);
            $stsLegArr = $caseStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
            if (!in_array("upd", $expStsLeg)) {
                $qry.= " AND Easycase.type_id !=10";
            }
        }
        ######### Filter by Case Types ##########
        if (trim($caseTypes) && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Case Label ##########
        if (trim($caseLabel) && $caseLabel != "all") {
            $qry.= $this->Format->labelFilter($caseLabel, $curProjId, $postdata['data']['SES_COMP'], $postdata['data']['SES_TYPE'], $postdata['data']['SES_ID']);
            $filterenabled = 1;
        }
        
        ######### Filter by Priority ##########
        if (trim($priorityFil) && $priorityFil != "all") {
            $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseUserId) && $caseUserId != "all") {
            $qry.= $this->Format->memberFilter($caseUserId);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseComment) && $caseComment != "all") {
            $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
            $filterenabled = 1;
        }
				######### Filter by Member ##########
         if (trim($caseTaskgroup) && $caseTaskgroup != "all") {
            $qry.= $this->Format->taskgroupFilter($caseTaskgroup);
            $filterenabled = 1;
        }
        ######### Filter by AssignTo ##########
        if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
            $qry.= $this->Format->assigntoFilter($caseAssignTo);
            $filterenabled = 1;
        } elseif (trim($caseAssignTo) == "unassigned") {
            $qry.= " AND Easycase.assign_to='0'";
            $filterenabled = 1;
        }
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
        if (!empty($inactiveFlag)) {
            if (!empty($csNum) && $csNum != 'null') {
                if ($csNum == 'desc') {
                    $sortorder = 'ASC';
                } else {
                    $sortorder = 'DESC';
                }
            } else {
                $sortorder = 'ASC';
            }

            $sortby = !empty($type) ? $type : '';
        }
        if ($sortby == 'title') {
            $orderby = "LTRIM(Easycase.title) " . $sortorder;
            $caseTitle = strtolower($sortorder);
        } elseif ($sortby == 'duedate') {
            $caseDueDate = strtolower($sortorder);
            $orderby = "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'estimatedhours') {
            $caseEstHours = strtolower($sortorder);
            $orderby = "Easycase.estimated_hours " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $caseNum = strtolower($sortorder);
            $orderby = "Easycase.case_no " . $sortorder;
        } elseif ($sortby == 'caseAt') {
            $caseAtsort = strtolower($sortorder);
            $orderby = "Assigned " . $sortorder;
        } elseif ($sortby == 'priority') {
            $casePriority = strtolower($sortorder);
            $orderby = "Easycase.priority " . $sortorder;
        } elseif ($sortby == 'status') {
            $caseStatusby = strtolower($sortorder);
            $orderby = "Easycase.legend " . $sortorder;
        } else {
            $caseUpdatedby = strtolower($sortorder);
            $orderby = "Easycase.dt_created " . $sortorder;
        }
        $groupby = '';
        $gby = '';
        $mileSton_orderby = '';
        $case_join = 'LEFT';
        $milstone_filter_condition = '';
        if (isset($this->params->query['filter_taskgroup']) && $this->params->query['filter_taskgroup']) {
            $groupby = 'milestone';
            $gby = 'milestone';
            $orderby .=" EasycaseMilestone.milestone_id ASC";
        }
        if ((isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] != 'date') || $groupby=='milestone') {
            $orderby = '';
            //$groupby = $_COOKIE['TASKGROUPBY'];
            if ($groupby != 'milestone') {
                setcookie('TASKSORTBY', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
                setcookie('TASKSORTORDER', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
            }
            if ($groupby == 'status') {
                $gby = 'status';
                $orderby .= " FIND_IN_SET(Easycase.type_id,'10'),FIND_IN_SET(Easycase.legend,'1,2,4,5,3,10') ";
            } elseif ($groupby == 'priority') {
                $orderby .= " if(Easycase.priority = '' or Easycase.priority is null,4,Easycase.priority),Easycase.priority";
                $gby = 'priority';
            } elseif ($groupby == 'duedate') {
                $orderby .= " Easycase.due_date DESC";
                $gby = 'due_date';
            } elseif ($groupby == 'crtdate') {
                $gby = 'crtdate';
                $orderby .= " Easycase.actual_dt_created DESC";
            } elseif ($groupby == 'assignto') {
                $gby = 'assignto';
                $orderby .= " Assigned ASC";
            } elseif ($groupby == 'milestone') {
                $gby = 'milestone';
                $orderby .=" EasycaseMilestone.milestone_id ASC";
                
                if ((isset($_COOKIE['TASKGROUP_FIL']) && $_COOKIE['TASKGROUP_FIL']) || (isset($last_filter_taskgroup) && $last_filter_taskgroup)) {
                    if (trim($_COOKIE['TASKGROUP_FIL']) == 'active' || trim($last_filter_taskgroup) == 'active') {
                        $case_join = 'INNER';
                        if ($projUniq == 'all') {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=0 AND Milestone.company_id =' . $company_user['CompanyUser']['company_id'] . ') ';
                        } else {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=0 AND Milestone.company_id =' . $company_user['CompanyUser']['company_id'] . ' AND Milestone.project_id =' . $curProjId . ') ';
                        }
                    } elseif (trim($_COOKIE['TASKGROUP_FIL']) == 'completed' || trim($last_filter_taskgroup) == 'completed') {
                        $case_join = 'INNER';
                        if ($projUniq == 'all') {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=1 AND Milestone.company_id =' . $company_user['CompanyUser']['company_id'] . ') ';
                        } else {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=1 AND Milestone.company_id =' . $company_user['CompanyUser']['company_id'] . ' AND Milestone.project_id =' . $curProjId . ') ';
                        }
                    }
                }
            }

            if ($groupby != 'date') {
                $orderby .=" ,Easycase.dt_created DESC";
                if ($groupby == 'milestone') {
                    $orderby = " CASE WHEN EasycaseMilestone.milestone_id IS NULL THEN 99999999999999 ELSE EasycaseMilestone.m_order END  ASC, EasycaseMilestone.milestone_id ASC ";
                    if ($sortby == 'duedate') {
                        $caseDueDate = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.due_date " . $sortorder;
                    } elseif ($sortby == 'caseAt') {
                        $caseAtsort = strtolower($sortorder);
                        $mileSton_orderby = " ,Assigned " . $sortorder;
                    } elseif ($sortby == 'title') {
                        $caseTitle = strtolower($sortorder);
                        $mileSton_orderby = " ,LTRIM(Easycase.title) " . $sortorder;
                    } elseif ($sortby == 'caseno') {
                        $caseNum = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.case_no " . $sortorder;
                    } elseif ($sortby == 'priority') {
                        $casePriority = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.priority " . $sortorder;
                    } elseif ($sortby == 'updated') {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.dt_created " . $sortorder;
                    } else {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,EasycaseMilestone.id_seq ASC,Easycase.seq_id ASC ";
                    }
                }
            }
        }
        ######### Search by KeyWord ##########
        $searchcase = "";
        if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
            //$qry="";
            $filterenabled = 1;
            $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
        }

        if (trim(urldecode($case_srch)) != "") {
            //$qry="";
            $filterenabled = 1;
            $searchcase = "AND (Easycase.case_no = '$case_srch')";
        }

        if (trim(urldecode($caseSrch))) {
            $filterenabled = 1;
            if ((substr($caseSrch, 0, 1)) == '#') {
                //$qry="";
                $tmp = explode("#", $caseSrch);
                $casno = trim($tmp['1']);
                $searchcase = " AND (Easycase.case_no = '" . $casno . "')";
            }
        }

        $cond_easycase_actuve = "";

        if ((isset($case_srch) && !empty($case_srch)) || isset($caseSrch) && !empty($caseSrch)) {
            $cond_easycase_actuve = "";
        } else {
            $cond_easycase_actuve = "AND Easycase.isactive=1";
        }

        if (trim($case_date) != "") {
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            
            if (trim($case_date) == 'one') {
                $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
            } elseif (trim($case_date) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
            } elseif (trim($case_date) == 'week') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
            } elseif (trim($case_date) == 'month') {
                $filterenabled = 1;
                $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
            } elseif (trim($case_date) == 'year') {
                $filterenabled = 1;
                $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
            } elseif (strstr(trim($case_date), "_")) {
                $filterenabled = 1;
                //echo $case_date;exit;
                $ar_dt = explode("_", trim($case_date));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        

        if (trim($case_duedate) != "") {
            $case_duedate = urldecode($case_duedate);
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if (trim($case_duedate) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
            } elseif (trim($case_duedate) == 'overdue') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) ";
            } elseif (strstr(trim($case_duedate), ":") && trim($case_duedate) !== '0000-00-00 00:00:00') {
                $filterenabled = 1;
                $ar_dt = explode(":", trim($case_duedate));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        ######### Filter by Assign To ##########
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . $auth_user['User']['id'] . ")";
        }
        ######### Filter by Delegate To ##########
        elseif ($caseMenuFilters == "delegateto") {
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . $auth_user['User']['id'] . " AND Easycase.user_id=" . $auth_user['User']['id'];
        } elseif ($caseMenuFilters == "closedtasks") {
            $qry.= " AND Easycase.legend='3' AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "overdue") {
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date != '0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND Easycase.due_date < '" . $cur_dt . "' AND (Easycase.legend !=3) ";
        } elseif ($caseMenuFilters == "highpriority") {
            $qry.= " AND Easycase.priority ='0' ";
        } elseif ($caseMenuFilters == "openedtasks") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='5' OR Easycase.legend='4')  AND Easycase.type_id !='10'";
        }
        if (!empty($search_val) && !empty($inactiveFlag)) {
            $qry.= "AND Easycase.title LIKE '%" . trim($search_val) . "%'";
        }
        ######### Filter by Latest ##########
        elseif ($caseMenuFilters == "latest") {
            $filterenabled = 1;
            $qry_rest = $qry;
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $all_rest = " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            $qry_rest.= " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
        }
        if ($caseMenuFilters == "latest" && $projUniq != 'all') {
            $CaseCount3 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase WHERE istype='1' " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry_rest));
            $CaseCount = $CaseCount3['0']['0']['count'];
            if ($CaseCount == 0) {
                $rest = $this->Easycase->query("SELECT dt_created FROM easycases WHERE project_id ='" . $curProjId . "' ORDER BY dt_created DESC LIMIT 0 , 1");
                @$sdate = explode(" ", @$rest[0]['easycases']['dt_created']);
                $qry.= " AND Easycase.dt_created >= '" . @$sdate[0] . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            } else {
                $qry = $qry . $all_rest;
            }
        } elseif ($caseMenuFilters == "latest" && $projUniq == 'all') {
            $qry = $qry . $all_rest;
        }

        ######### Close a Case ##########
        if ($changecasetype) {
            $caseid = $changecasetype;
        } elseif ($caseChangeDuedate) {
            $caseid = $caseChangeDuedate;
        } elseif ($caseChangePriority) {
            $caseid = $caseChangePriority;
        } elseif ($caseChangeAssignto) {
            $caseid = $caseChangeAssignto;
        }

        if ($caseid) {
            //$checkStatus = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $caseid . "' AND isactive='1'");
            $checkStatus = $this->Easycase->find('all', array('conditions' => array('id' => $caseid, 'isactive' => '1'), 'fields' => array('legend')));

            if ($checkStatus['0']['Easycase']['legend'] == 1) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#763532" style="font:normal 12px verdana;">NEW</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 4) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 5) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 3) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            }
        }

        $commonAllId = "";
        $caseid_list = '';
        if ($startCaseId) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $startCaseId;
            $emailType = "Start";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font> the Task.';
        } elseif ($caseResolve) {
            $csSts = 1;
            $csLeg = 5;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseResolve;
            $emailType = "Resolve";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = '<font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font> the Task.';
        } elseif ($caseNew) {
            $csSts = 1;
            $csLeg = 1;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseNew;
            $emailType = "New";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = 'Changed the status of the task to<font color="#F08E83" style="font:normal 12px verdana;">NEW</font>.';
        } elseif ($caseUniqId) {
            $csSts = 2;
            $csLeg = 3;
            $acType = 1;
            $cuvtype = 3;
            $commonAllId = $caseUniqId;
            $emailType = "Close";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            $emailbody = '<font color="green" style="font:normal 12px verdana;">CLOSED</font> the Task.';
        } elseif ($changecasetype) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $changecasetype;
            $emailType = "Change Type";
            $caseChageType1 = 1;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the type of</font> the Task.';
        } elseif ($caseChangeDuedate) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeDuedate;
            $emailType = "Change Duedate";
            $caseChageDuedate1 = 3;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the due date of</font> the Task.';
        } elseif ($caseChangePriority) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangePriority;
            $emailType = "Change Priority";
            $caseChagePriority1 = 2;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the priority of</font> the Task.';
        } elseif ($caseChangeAssignto) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeAssignto;
            $emailType = "Change Assignto";
            $caseChangeAssignto1 = 4;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the assigned to of</font> the Task.';
        }

        if ($commonAllId) {
            $commonAllId = $commonAllId . ",";
            $commonArrId = explode(",", $commonAllId);
            $done = 1;
            if ($caseChageType1 || $caseChageDuedate1 || $caseChagePriority1 || $caseChangeAssignto1) {
            } else {
                foreach ($commonArrId as $commonCaseId) {
                    if (trim($commonCaseId)) {
                        /* dependency check start */
                        $allowed = "Yes";
                        $depends = $this->Easycase->find('first', array('conditions' => array('id' => $commonCaseId)));
                        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
                            $result = $this->Easycase->find('all', array('conditions' => array('id IN (' . $depends['Easycase']['depends'] . ')')));
                            if (is_array($result) && count($result) > 0) {
                                foreach ($result as $key => $parent) {
                                    if (($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) || ($parent['Easycase']['legend'] == 3)) {
                                        // NO ACTION
                                    } else {
                                        $allowed = "No";
                                    }
                                }
                            }
                        }
                        /* dependency check end */
                        if ($allowed == 'No') {
                            $resCaseProj['errormsg'] = __('Dependant tasks are not closed.', true);
                        } else {
                            $done = 1;
                            $checkSts = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $commonCaseId . "' AND isactive='1'");
                            if (isset($checkSts['0']) && count($checkSts['0']) > 0) {
                                if ($checkSts['0']['easycases']['legend'] == 3) {
                                    $done = 0;
                                }
                                if ($csLeg == 4) {
                                    if ($checkSts['0']['easycases']['legend'] == 4) {
                                        $done = 0;
                                    }
                                }
                                if ($csLeg == 5) {
                                    if ($checkSts['0']['easycases']['legend'] == 5) {
                                        $done = 0;
                                    }
                                }
                            } else {
                                $done = 0;
                            }
                            if ($done) {
                                $caseid_list .= $commonCaseId . ',';
                                $caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to')));

                                $caseStsId = $caseDataArr['Easycase']['id'];
                                $caseStsNo = $caseDataArr['Easycase']['case_no'];
                                $closeStsPid = $caseDataArr['Easycase']['project_id'];
                                $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                                $closeStsPri = $caseDataArr['Easycase']['priority'];
                                $closeStsTitle = $caseDataArr['Easycase']['title'];
                                $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                                $caUid = $caseDataArr['Easycase']['assign_to'];

                                $this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . $auth_user['User']['id'] . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");
                                /* Delete previous RA **/
                                if ($this->Format->isResourceAvailabilityOn() && $csLeg == 3) {
                                    foreach ($casearr as $casek=>$casev) {
                                        $this->Format->delete_booked_hours(array('easycase_id' => $caseStsId, 'project_id' =>$closeStsPid));
                                    }
                                }
                                /* End */
                                $caseuniqid = $this->Format->generateUniqNumber();
                                $this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . $auth_user['User']['id'] . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                                //$thisCaseId = mysql_insert_id();
                                //socket.io implement start

                                $this->ProjectUser->recursive = -1;
                                $getUser = $this->ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $closeStsPid . "'");
                                $prjuniq = $this->Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
                                $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
                                $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                                $channel_name = $prjuniqid;

                                $msgpub = 'Updated.~~' . $auth_user['User']['id'] . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                                if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'osnewui16.com')) {
                                    $resCaseProj['iotoserver'] =  array('channel' => $channel_name, 'message' => $msgpub);
                                    //$this->Postcase->iotoserver(array('channel' => $channel_name, 'message' => $msgpub));
                                    //socket.io implement end
                                }
                            }
                        }
                    }
                }
            }
            $_SESSION['email']['email_body'] = $emailbody;
            $_SESSION['email']['msg'] = $msg;
            if ($caseChageType1 == 1) {
                $caseid_list = $commonAllId;
            } elseif ($caseChagePriority1 == 2) {
                $caseid_list = $commonAllId;
            } elseif ($caseChageDuedate1 == 3) {
                $caseid_list = $commonAllId;
            } elseif ($caseChangeAssignto1 == 4) {
                $caseid_list = $commonAllId;
            }
            $email_notification = array('allfiles' => $allfiles, 'caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg, 'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo, 'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid, 'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'caseUniqId' => $closeStsUniqId); // $caseuniqid

            $resCaseProj['email_arr'] = json_encode($email_notification);
        }
        $msQuery1 = " ";
        if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
            $msQuery = "";
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                foreach ($expMilestoneIds as $msid) {
                    if ($msid) {
                        $msQuery.= "EasycaseMilestone.milestone_id=" . $msid . " OR ";
                    }
                }
                if ($msQuery) {
                    $msQuery = substr($msQuery, 0, -3);
                    $msQuery = " AND (" . $msQuery . ")";
                }
            } else {
                $tody = date('Y-m-d', strtotime("now"));
            }
        }

        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        $resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['csTtl'] = $caseTitle;
        $resCaseProj['csDuDt'] = $caseDueDate;
        $resCaseProj['csCrtdDt'] = $caseCreateDate;
        $resCaseProj['csNum'] = $caseNum;
        $resCaseProj['csLgndSrt'] = $caseLegendsort;
        $resCaseProj['csAtSrt'] = $caseAtsort;

        $resCaseProj['csPriSrt'] = $casePriority;
        $resCaseProj['csStusSrt'] = $caseStatusby;
        $resCaseProj['csUpdatSrt'] = $caseUpdatedby;

        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        $mileSton_names = array();
        $all_mileSton_names = array();
        $all_prj_names = null;

        if ($projUniq) {
            //$this->Easycase->query('SET CHARACTER SET utf8');
            $page = $casePage;
            $limit1 = $page * $page_limit - $page_limit;
            $limit2 = $page_limit;

            if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                if ($milestone_type == 0) {
                    $qrycheck = "Milestone.isactive='0'";
                } else {
                    $qrycheck = "Milestone.isactive='1'";
                }
                if ($projUniq != 'all') {
                    $caseAll = $this->Easycase->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . $auth_user['User']['id'] . "),'Me',User.short_name) AS Assigned FROM ( SELECT Easycase.*,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq,EasycaseMilestone.m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase,easycase_milestones AS EasycaseMilestone,milestones AS Milestone WHERE EasycaseMilestone.easycase_id=Easycase.id AND Milestone.id=EasycaseMilestone.milestone_id" . $msQuery1 . "AND Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND " . $qrycheck . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " AND EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.project_id=" . $curProjId . $msQuery . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY Easycase.end_date ASC,Easycase.Mtitle ASC," . $orderby . " LIMIT $limit1,$limit2");
                }
                if ($projUniq == 'all') {
                    $caseAll = $this->Easycase->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . $auth_user['User']['id'] . "),'Me',User.short_name) AS Assigned FROM ( SELECT  Easycase.*,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq,EasycaseMilestone.m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase,easycase_milestones AS EasycaseMilestone,milestones AS Milestone WHERE EasycaseMilestone.easycase_id=Easycase.id AND Milestone.id=EasycaseMilestone.milestone_id AND Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND " . $qrycheck . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . $auth_user['User']['id']. " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . $company_user['CompanyUser']['company_id'] . "') " . $searchcase . " " . trim($qry) . " AND EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')" . $msQuery . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY Easycase.end_date ASC,Easycase.Mtitle ASC," . $orderby . " LIMIT $limit1,$limit2");
                }
            } else {
                if ($projUniq == 'all') {
                    if ($caseMenuFilters == "latest") {
                        $caseAll = $this->Easycase->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . $auth_user['User']['id'] . "),'Me',User.short_name) AS Assigned FROM ( SELECT * FROM easycases as Easycase WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . $auth_user['User']['id'] . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . $company_user['CompanyUser']['company_id'] . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.dt_created DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT $limit1,$limit2");
                    } else {
                        $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . $auth_user['User']['id'] . "),'Me',User.short_name) AS Assigned FROM ( SELECT Easycase.* FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . $auth_user['User']['id'] . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . $company_user['CompanyUser']['company_id'] . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.project_id DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT $limit1,$limit2";
                        if ($gby == 'milestone') {
                            $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id as mid,User.short_name,IF((Easycase.assign_to =" . $auth_user['User']['id'] . "),'Me',User.short_name) AS Assigned FROM ( SELECT * FROM easycases as Easycase WHERE Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . $auth_user['User']['id'] . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . $company_user['CompanyUser']['company_id'] . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.project_id DESC) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " ORDER BY " . $orderby . $mileSton_orderby . "   LIMIT $limit1,$limit2";
                        }
                        //print $req_sql;exit;
                        $caseAll = $this->Easycase->query($req_sql);
                        if ($gby == 'milestone') {
                            $results_mids = Hash::extract($caseAll, '{n}.EasycaseMilestone.mid');
                            $results_mids = array_filter($results_mids);

                            if ($results_mids) {
                                $cond = array('conditions' => array('Milestone.id' => $results_mids), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.title', 'Milestone.isactive', 'Milestone.project_id'));
                                $mileSton_names = $this->Milestone->find('all', $cond);
                                $mileSton_names = Hash::combine($mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                                foreach ($mileSton_names as $miik => $miiv) {
                                    $mileSton_names[$miik]['title'] = htmlspecialchars_decode($miiv['title']);
                                }
                            }
                        }
                    }
                } else {
                    $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to =" . $auth_user['User']['id'] . "),'Me',User.short_name) AS Assigned FROM ( SELECT Easycase.* FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT $limit1,$limit2";
                    if ($gby == 'milestone') {
                        $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id as mid,User.short_name,IF((Easycase.assign_to =" . $auth_user['User']['id'] . "),'Me',User.short_name) AS Assigned FROM ( SELECT * FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id AND EasycaseMilestone.project_id ='" . $curProjId . "' " . $milstone_filter_condition . " ORDER BY " . $orderby . $mileSton_orderby . "  LIMIT $limit1,$limit2";
                    }
                    $caseAll = $this->Easycase->query($req_sql);
                    if ($gby == 'milestone') {
                        $results_mids = Hash::extract($caseAll, '{n}.EasycaseMilestone.mid');
                        $results_mids = array_unique(array_filter($results_mids));

                        if ($results_mids) {
                            $cond = array('conditions' => array('Milestone.id' => $results_mids), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.title', 'Milestone.isactive', 'Milestone.project_id'));
                            $mileSton_names = $this->Milestone->find('all', $cond);
                            $mileSton_names = Hash::combine($mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                            foreach ($mileSton_names as $miik => $miiv) {
                                $mileSton_names[$miik]['title'] = htmlspecialchars_decode($miiv['title']);
                            }
                        }
                    }
                }
            }
            
            if ($gby == 'milestone') {
                if ($projUniq == 'all') {
                    $req_sql_cnt = "SELECT count(Easycase.id) as cnt FROM ( SELECT Easycase.* FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . $auth_user['User']['id'] . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . $company_user['CompanyUser']['company_id'] . "') " . $searchcase . " " . trim($qry) . " ) AS Easycase " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby;
                    $tot = $this->Easycase->query($req_sql_cnt);
                } else {
                    /*
                    //Code commented by Tapan sir

                    $req_sql_cnt = "SELECT count(Easycase.id) as cnt FROM ( SELECT Easycase.* FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase " . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby; */
                    
                    $req_sql_cnt = "SELECT count(Easycase.id) as cnt FROM easycases as Easycase WHERE istype=1 AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id=$curProjId AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry);
                    $tot = $this->Easycase->query($req_sql_cnt);
                }
                $CaseCount = $tot[0][0]['cnt'];
                $tsk_grp_fl = array(0, 1);
                if (isset($_COOKIE['TASKGROUP_FIL']) && $_COOKIE['TASKGROUP_FIL']) {
                    if (trim($_COOKIE['TASKGROUP_FIL']) == 'active') {
                        $tsk_grp_fl = 1;
                    } elseif (trim($_COOKIE['TASKGROUP_FIL']) == 'completed') {
                        $tsk_grp_fl = 0;
                    }
                }
                if ($projUniq == 'all') {
                    $ec_mil = $this->Easycase->query("SELECT DISTINCT(EasycaseMilestone.milestone_id) as mid FROM easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.project_id IN(SELECT PJU.project_id FROM project_users AS PJU WHERE PJU.company_id = " . $company_user['CompanyUser']['company_id'] . " AND PJU.user_id = " . $auth_user['User']['id'] . ")");
                    $cond = array('conditions' => array('Milestone.company_id' => $company_user['CompanyUser']['company_id'], 'Milestone.isactive' => $tsk_grp_fl), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title'), 'order' => 'Milestone.created DESC');
                    if ($ec_mil) {
                        $ec_mil = array_unique(Hash::extract($ec_mil, '{n}.EasycaseMilestone.mid'));
                        $cond = array('conditions' => array('Milestone.company_id' => $company_user['CompanyUser']['company_id'], 'Milestone.isactive' => $tsk_grp_fl, 'NOT' => array('Milestone.id' => $ec_mil)), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title'), 'order' => 'Milestone.created DESC');
                    }
                } else {
                    $ec_mil = $this->Easycase->query("SELECT DISTINCT(EasycaseMilestone.milestone_id) as mid FROM easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.project_id IN(SELECT PJU.project_id FROM project_users AS PJU WHERE PJU.company_id = " . $company_user['CompanyUser']['company_id'] . " AND PJU.user_id = " . $auth_user['User']['id'] . " AND PJU.project_id = " . $curProjId . ")");
                    $cond = array('conditions' => array('Milestone.company_id' => $company_user['CompanyUser']['company_id'], 'Milestone.isactive' => $tsk_grp_fl, 'Milestone.project_id' => $curProjId), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title', 'Milestone.isactive'), 'order' => 'Milestone.created DESC');
                    if ($ec_mil) {
                        $ec_mil = array_unique(Hash::extract($ec_mil, '{n}.EasycaseMilestone.mid'));
                        $cond = array('conditions' => array('Milestone.company_id' => $company_user['CompanyUser']['company_id'], 'Milestone.isactive' => $tsk_grp_fl, 'Milestone.project_id' => $curProjId, 'NOT' => array('Milestone.id' => $ec_mil)), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title', 'Milestone.isactive'), 'order' => 'Milestone.created DESC');
                    }
                }
                $all_mileSton_names = $this->Milestone->find('all', $cond);
                $milestone_pids = null;
                if ($projUniq == 'all' && $all_mileSton_names) {
                    $milestone_pids = array_unique(Hash::extract($all_mileSton_names, '{n}.Milestone.project_id'));
                    $cond_pnames = array('conditions' => array('Project.id' => $milestone_pids), 'fields' => array('Project.id', 'Project.name'));
                    $all_prj_names = $this->Project->find('list', $cond_pnames);
                }
                if ($all_mileSton_names) {
                    $all_mileSton_names = Hash::combine($all_mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                    foreach ($all_mileSton_names as $mik => $miv) {
                        $all_mileSton_names[$mik]['title'] = htmlspecialchars_decode($miv['title']);
                    }
                }
            } else {
                $tot = $this->Easycase->query("SELECT FOUND_ROWS() as total");
                $CaseCount = $tot[0][0]['total'];
            }
            $msQ = "";
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                $idArr = array();
                foreach ($expMilestoneIds as $msid) {
                    if (trim($msid)) {
                        $idArr[] = trim($msid);
                    }
                }
                if (count($idArr)) {
                    $msQ.= "AND Milestone.id IN (" . implode(",", $idArr) . ")";
                }
            }
            if ($projUniq != 'all') {
                $milestones = array();

                if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                    if ($milestone_type == 0) {
                        $qrycheck = "Milestone.isactive='0'";
                    } else {
                        $qrycheck = "Milestone.isactive='1'";
                    }
                    $milestones = $this->Milestone->query("SELECT `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`end_date`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`  FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id WHERE `Milestone`.`project_id` =" . $curProjId . " AND " . $qrycheck . " AND `Milestone`.`company_id` = " . $company_user['CompanyUser']['company_id'] . " " . $msQ . " GROUP BY Milestone.id ORDER BY `Milestone`.`id` ASC");
                }
                foreach ($milestones as $mls) {
                    $mid.= $mls['Milestone']['id'] . ',';
                    $m[$mls['Milestone']['id']]['id'] = $mls['Milestone']['id'];
                    $m[$mls['Milestone']['id']]['caseids'] = $mls[0]['caseids'];
                    $m[$mls['Milestone']['id']]['totalcases'] = $mls[0]['totalcases'];
                    $m[$mls['Milestone']['id']]['title'] = $mls['Milestone']['title'];
                    $m[$mls['Milestone']['id']]['project_id'] = $mls['Milestone']['project_id'];
                    $m[$mls['Milestone']['id']]['end_date'] = $mls['Milestone']['end_date'];
                    $m[$mls['Milestone']['id']]['uinq_id'] = $mls['Milestone']['uniq_id'];
                    $m[$mls['Milestone']['id']]['isactive'] = $mls['Milestone']['isactive'];
                    $m[$mls['Milestone']['id']]['user_id'] = $mls['Milestone']['user_id'];
                }
                $c = array();

                if ($mid) {
                    $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN(" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
                    foreach ($closed_cases as $key => $val) {
                        $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                    }
                }
                $resCaseProj['milestones'] = $m;
            }
            if ($projUniq == 'all') {
                $milestones = array();
                if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                    if ($milestone_type == 0) {
                        $qrycheck = "Milestone.isactive='0'";
                    } else {
                        $qrycheck = "Milestone.isactive='1'";
                    }
                    $cond = array('conditions' => array('ProjectUser.user_id' => $auth_user['User']['id'], 'ProjectUser.company_id' => $company_user['CompanyUser']['company_id'], 'Project.isactive' => 1), 'fields' => array('DISTINCT  Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));
                    $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                    $allProjArr = $this->ProjectUser->find('all', $cond);
                    $ids = array();
                    foreach ($allProjArr as $csid) {
                        array_push($ids, $csid['Project']['id']);
                    }
                    $implode_ids = implode(',', $ids);
                    $this->Milestone->recursive = -1;

                    $milestones = $this->Milestone->query("SELECT `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`end_date`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`  FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id WHERE `Milestone`.`project_id` IN (" . $implode_ids . ") AND " . $qrycheck . " AND `Milestone`.`company_id` = " . $company_user['CompanyUser']['company_id'] . " " . $msQ . " GROUP BY Milestone.id ORDER BY `Milestone`.`id` ASC");

                    $mid = '';
                    foreach ($milestones as $k => $v) {
                        $mid.= $v['Milestone']['id'] . ',';
                        $m[$v['Milestone']['id']]['id'] = $v['Milestone']['id'];
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
                        $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN (" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
                        foreach ($closed_cases as $key => $val) {
                            $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                        }
                    }
                    $resCaseProj['milestones'] = $m;
                }
            }

            if ($projUniq != 'all') {
                $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id='" . $curProjId . "' AND Easycase.isactive='1' AND Easycase.istype IN('1','2') ORDER BY User.short_name");
            } else {
                $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . $auth_user['User']['id'] . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . $company_user['CompanyUser']['company_id'] . "') AND Easycase.isactive='1' AND Easycase.istype IN('1','2') ORDER BY User.short_name");
            }

            $usrDtlsArr = array();
            $usrDtlsPrj = array();
            foreach ($usrDtlsAll as $ud) {
                $usrDtlsArr[$ud['User']['id']] = $ud;
            }
        } else {
            $CaseCount = 0;
        }
        $resCaseProj['caseCount'] = $CaseCount;

        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
        $cq = $view->loadHelper('Casequery');
        $frmt = $view->loadHelper('Format');

        $frmtCaseAll = $this->Easycase->formatCasesPdf($caseAll, $CaseCount, $caseMenuFilters, $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, $auth_user['User'], $timezone['Timezone']);
        $resCaseProj['caseAll'] = $frmtCaseAll['caseAll'];
        $resCaseProj['milestones'] = $frmtCaseAll['milestones'];

        $pgShLbl = $frmt->pagingShowRecords($CaseCount, $page_limit, $casePage);
        $resCaseProj['pgShLbl'] = $pgShLbl;
        
        
        $curCreated = $tz->GetDateTime($timezone['Timezone']['id'], $timezone['Timezone']['gmt_offset'], TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $friday = date('Y-m-d', strtotime($curCreated . "next Friday"));
        $monday = date('Y-m-d', strtotime($curCreated . "next Monday"));
        $tomorrow = date('Y-m-d', strtotime($curCreated . "+1 day"));

        $resCaseProj['intCurCreated'] = strtotime($curCreated);
        $resCaseProj['mdyCurCrtd'] = date('m/d/Y', strtotime($curCreated));
        $resCaseProj['mdyFriday'] = date('m/d/Y', strtotime($friday));
        $resCaseProj['mdyMonday'] = date('m/d/Y', strtotime($monday));
        $resCaseProj['mdyTomorrow'] = date('m/d/Y', strtotime($tomorrow));
        $resCaseProj['GrpBy'] = $gby;
        $resCaseProj['milesto_names'] = $mileSton_names;
        $resCaseProj['all_milesto_names'] = $all_mileSton_names;
        $resCaseProj['all_milesto_prj_names'] = ($all_prj_names != null && $all_prj_names) ? $all_prj_names : 0;
        
        if ($projUniq != 'all') {
            $projUser = array();
            if ($projUniq) {
                $projUser = array($projUniq => $this->Easycase->getMemebers($projUniq));
            }
            $resCaseProj['projUser'] = $projUser;
            $resCaseProj['case_date'] = $case_date;
            $resCaseProj['caseStatus'] = $caseStatus;
            $resCaseProj['priorityFil'] = $priorityFil;
            $resCaseProj['caseTypes'] = $caseTypes;
            $resCaseProj['caseUserId'] = $caseUserId;
            $resCaseProj['caseComment'] = $caseComment;
            $resCaseProj['caseAssignTo'] = $caseAssignTo;
            $resCaseProj['case_duedate'] = $case_duedate;
            //$resCaseProj['caseSrch'] = $caseSrch;
            $prj = $this->Project->findByUniqId($projUniq);
            if ($projUser) {
                $resCaseProj['QTAssigns'] = Hash::extract($projUser[$projUniq], '{n}.User');
            }
            $resCaseProj['defaultAssign'] = $prj['Project']['default_assign'];
            $resCaseProj['defaultTaskType'] = $prj['Project']['task_type'];
        } else {
            $resCaseProj['defaultAssign'] = $auth_user['User']['id'];
            $resCaseProj['defaultTaskType'] = '';
            $resCaseProj['QTAssigns'][0]['id'] = $auth_user['User']['id'];
            $resCaseProj['QTAssigns'][0]['uniq_id'] = 'me';
            $resCaseProj['QTAssigns'][0]['name'] = 'Me';
        }
        if (isset($caseSrch)) {
            $resCaseProj['caseSrch'] = $caseSrch;
        }
        if (!empty($inactiveFlag)) {
            return $resCaseProj;
        }
        $this->loadModel('Type');
        if ($resCaseProj['projUniq']!="all") {
            $pdf_proj_name=$this->Project->find('first', array('conditions' => array('Project.uniq_id' =>$resCaseProj['projUniq'])));
            $this->set('pdf_proj_name', $pdf_proj_name['Project']['name']);
        } else {
            $this->set('pdf_proj_name', 'All Projects');
        }
        $user_list=$this->User->find('list', array('fields' => array('User.id', 'User.name')));
        $type_list=$this->Type->find('list', array('fields' => array('Type.id', 'Type.name')));
        $this->set('user_list', $user_list);
        $this->set('type_list', $type_list);
        $this->set('resCaseProj', $resCaseProj);
        if (isset($postdata['data']['filter_taskgroup']) && $postdata['data']['filter_taskgroup'] == 1) {
            // Changing View Template
            $this->render('pdfcase_taskgroup');
        }
        //print "<pre>";
        //print_r($resCaseProj);exit;
    }
    public function ajax_common_breadcrumb()
    {
        $arr = array();
        $this->layout = 'ajax';
        $this->autoRender = false;
        $case_status = "all";
        $case_custom_status = "all";
        $case_types = "all";
        $pri_fil = "all";
        $case_member = "all";
        $case_assignto = "all";
        $case_taskgroup = "all";
        $val = 0;

        $this->LoadModel("SearchFilter");
        $record = $this->SearchFilter->find('first', array('conditions' => array('SearchFilter.user_id' => SES_ID, 'SearchFilter.company_id' => SES_COMP, 'SearchFilter.name' => 'default')));
        $json_array = json_decode($record['SearchFilter']['json_array']);
        $json_arr = array();

        //For Case Status
        if (isset($this->params->data['caseStatus']) && $this->params->data['caseStatus']) {
            $case_status = $this->params->data['caseStatus'];
        } elseif (isset($json_array->STATUS)) {
            $case_status = $json_array->STATUS;
        } elseif ($_COOKIE['STATUS']) {
            $case_status = $_COOKIE['STATUS'];
        }

        $json_arr['STATUS'] = $this->params->data['caseStatus']; //set the array and save in database.

        if ($case_status && $case_status != "all") {
            $case_status = strrev($case_status);
            if (strstr($case_status, "-")) {
                $expst = explode("-", $case_status);
                foreach ($expst as $st) {
                    $status .= "<span class='filter_opn' title='Task Status' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"status\");'>" . $this->Format->displayStatus($st) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"taskstatus\",\"" . strrev($st) . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->displayStatus($st).", ";
                }
            } else {
                $status = "<span class='filter_opn' title='Task Status' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"status\");'>" . $this->Format->displayStatus($case_status) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"taskstatus\",\"" . $case_status . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->displayStatus($case_status).", ";
            }

            $arr['case_status'] = trim($status, ', ');

            if ($json_arr['STATUS'] && $json_arr['STATUS'] != "all") {
                $val = 1;
            }
        } else {
            $arr['case_status'] = 'All';
        }
        //For Case Custom  Status
        if (isset($this->params->data['caseCustomStatus']) && $this->params->data['caseCustomStatus']) {
            $case_custom_status = $this->params->data['caseCustomStatus'];
        } elseif (isset($json_array->CUSTOM_STATUS)) {
            $case_custom_status = $json_array->CUSTOM_STATUS;
        } elseif ($_COOKIE['CUSTOM_STATUS']) {
            $case_custom_status = $_COOKIE['CUSTOM_STATUS'];
        }

        $json_arr['CUSTOM_STATUS'] = $this->params->data['caseCustomStatus']; //set the array and save in database.
        if ($case_custom_status && $case_custom_status != "all") {
            if (strstr($case_custom_status, "-")) {
                $expst = explode("-", $case_custom_status);
                $c_status = '';
                foreach ($expst as $st) {
                    $c_status .= "<span class='filter_opn' title='Task Status' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"status\");'>" . $this->Format->displayCustomStatus($st) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"customtaskstatus\",\"" .'custom_status_'.$st . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->displayStatus($st).", ";
                    
                    //strrev($st)
                }
            } else {
                $c_status = "<span class='filter_opn' title='Task Status' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"status\");'>" . $this->Format->displayCustomStatus($case_custom_status) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"customtaskstatus\",\"" .'custom_status_'. $case_custom_status . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->displayStatus($case_status).", ";
            }
            $arr['case_custom_status'] = trim($c_status, ', ');
            if ($json_arr['CUSTOM_STATUS'] && $json_arr['CUSTOM_STATUS'] != "all") {
                $val = 1;
            }
        } else {
            $arr['case_custom_status'] = 'All';
        }
        //For case Label
        if (isset($this->params->data['caseLabel']) && $this->params->data['caseLabel']) {
            $case_labels = $this->params->data['caseLabel'];
        } elseif (isset($json_array->TASKLABEL)) {
            $case_labels = $json_array->TASKLABEL;
        } elseif ($_COOKIE['TASKLABEL']) {
            $case_labels = $_COOKIE['TASKLABEL'];
        }
        $json_arr['TASKLABEL'] = $this->params->data['caseLabel']; //set case label
        $lbls = '';
        if ($case_labels && $case_labels != "all") {
            $this->loadModel('Label');
            if (strstr($case_labels, "-")) {
                $expst_lbl = explode("-", $case_labels);
            } else {
                $expst_lbl = $case_labels;
            }
            $res_lbls = $this->Label->getLabeByUid($expst_lbl, SES_COMP);
            if ($res_lbls) {
                foreach ($res_lbls as $st_lbl) {
                    $lbls.= "<span class='filter_opn' rel='tooltip' title='Label' onclick='allfiltervalue(\"label\");'>" . $st_lbl['Label']['lbl_title'] . "<a href='javascript:void(0);' onclick='common_reset_filter(\"label\",\"" . $st_lbl['Label']['id'] . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
                $lbls = trim($lbls, ', ');
            }
            $arr['case_label'] = $lbls;
            if ($json_arr['TASKLABEL'] && $json_arr['TASKLABEL'] != "all") {
                $val = 1;
            }
        } else {
            $arr['case_label'] = 'All';
        }
        //For case types
        if (isset($this->params->data['caseTypes']) && $this->params->data['caseTypes']) {
            $case_types = $this->params->data['caseTypes'];
        } elseif (isset($json_array->CS_TYPES)) {
            $case_types = $json_array->CS_TYPES;
        } elseif ($_COOKIE['CS_TYPES']) {
            $case_types = $_COOKIE['CS_TYPES'];
        }
        $json_arr['CS_TYPES'] = $this->params->data['caseTypes']; //set case type
        $types = '';

        if ($case_types && $case_types != "all") {
            $view = new View($this);
            $cq = $view->loadHelper('Casequery');
            if (strstr($case_types, "-")) {
                $expst3 = explode("-", $case_types);
                foreach ($expst3 as $st3) {
                    $csTypArr = $cq->getTypeArr($st3, $GLOBALS['TYPE']);
                    $types.= "<span class='filter_opn' rel='tooltip' title='Task Type' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"types\");'>" . $csTypArr['Type']['short_name'] . "<a href='javascript:void(0);' onclick='common_reset_filter(\"tasktype\",\"" . $st3 . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->caseBcTypes($st3).", ";
                }
                $types = trim($types, ', ');
            } else {
                $csTypArr = $cq->getTypeArr($case_types, $GLOBALS['TYPE']);
                $types = "<span class='filter_opn' rel='tooltip' title='Task Type' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"types\");'>" . $csTypArr['Type']['short_name'] . "<a href='javascript:void(0);' onclick='common_reset_filter(\"tasktype\",\"" . $case_types . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->caseBcTypes($case_types);
            }
            $arr['case_types'] = $types;
            if ($json_arr['CS_TYPES'] && $json_arr['CS_TYPES'] != "all") {
                $val = 1;
            }
        } else {
            $arr['case_types'] = 'All';
        }

        //For Priority
        if (isset($this->params->data['priFil']) && $this->params->data['priFil']) {
            $pri_fil = $this->params->data['priFil'];
        } elseif (isset($json_array->PRIORITY)) {
            $pri_fil = $json_array->PRIORITY;
        } elseif ($_COOKIE['PRIORITY']) {
            $pri_fil = $_COOKIE['PRIORITY'];
        }
        $json_arr['PRIORITY'] = $this->params->data['priFil']; //set Priority

        if ($pri_fil && $pri_fil != "all") {
            if (strstr($pri_fil, "-")) {
                $expst2 = explode("-", $pri_fil);
                foreach ($expst2 as $st2) {
                    $pri .= "<span class='filter_opn' rel='tooltip' title='Priority' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"priority\");'>" . $st2 . "<a href='javascript:void(0);' onclick='common_reset_filter(\"priority\",\"" . $st2 . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $pri = "<span class='filter_opn' rel='tooltip' title='Priority' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"priority\");'>" . $pri_fil . "<a href='javascript:void(0);' onclick='common_reset_filter(\"priority\",\"" . $pri_fil . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
            $arr['pri'] = $pri;
            if ($json_arr['PRIORITY'] && $json_arr['PRIORITY'] != "all") {
                $val = 1;
            }
        } else {
            $arr['pri'] = 'All';
        }

        //For Case Comment
        if (isset($this->params->data['caseComment']) && $this->params->data['caseComment']) {
            $case_comment = $this->params->data['caseComment'];
        } elseif (isset($json_array->COMMENTS)) {
            $case_comment = $json_array->COMMENTS;
        } elseif ($_COOKIE['COMMENTS']) {
            $case_comment = $_COOKIE['COMMENTS'];
        }
        $json_arr['COMMENTS'] = $this->params->data['caseComment']; //set Members

        if ($case_comment && $case_comment != "all") {
            if (strstr($case_comment, "-")) {
                $expst11 = explode("-", $case_comment);
                $cbycoms = $this->Format->caseMemsList($expst11);
                foreach ($cbycoms as $key => $st11) {
                    $coms .= "<span class='filter_opn' rel='tooltip' title='Commented By " . $this->Format->caseMemsName($key) . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"comments\");'>" . $st11 . "<a href='javascript:void(0);' onclick='common_reset_filter(\"comments\",\"" . $key . "\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $coms = "<span class='filter_opn' rel='tooltip' title='Commented By " . $this->Format->caseMemsName($case_comment) . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"comments\");'>" . $this->Format->caseMemsList($case_comment) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"comments\",\"" . $case_comment . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
            $arr['case_comment'] = $coms;
            if ($json_arr['COMMENTS'] && $json_arr['COMMENTS'] != "all") {
                $val = 1;
            }
        } else {
            $arr['case_comment'] = 'All';
        }
        
        //For Case Members
        if (isset($this->params->data['caseMember']) && $this->params->data['caseMember']) {
            $case_member = $this->params->data['caseMember'];
        } elseif (isset($json_array->MEMBERS)) {
            $case_member = $json_array->MEMBERS;
        } elseif ($_COOKIE['MEMBERS']) {
            $case_member = $_COOKIE['MEMBERS'];
        }
        $json_arr['MEMBERS'] = $this->params->data['caseMember']; //set Members

        if ($case_member && $case_member != "all") {
            if (strstr($case_member, "-")) {
                $expst4 = explode("-", $case_member);
                $cbymems = $this->Format->caseMemsList($expst4);
                foreach ($cbymems as $key => $st4) {
                    $mems .= "<span class='filter_opn' rel='tooltip' title='Created By " . $this->Format->caseMemsName($key) . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"users\");'>" . $st4 . "<a href='javascript:void(0);' onclick='common_reset_filter(\"members\",\"" . $key . "\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $mems = "<span class='filter_opn' rel='tooltip' title='Created By " . $this->Format->caseMemsName($case_member) . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"users\");'>" . $this->Format->caseMemsList($case_member) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"members\",\"" . $case_member . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
            $arr['case_member'] = $mems;
            if ($json_arr['MEMBERS'] && $json_arr['MEMBERS'] != "all") {
                $val = 1;
            }
        } else {
            $arr['case_member'] = 'All';
        }
        //For Case Taskgroup
        if (isset($this->params->data['caseTaskgroup']) && $this->params->data['caseTaskgroup']) {
            $case_taskgroup = $this->params->data['caseTaskgroup'];
        } elseif (isset($json_array->TASKGROUP)) {
            $case_taskgroup = $json_array->TASKGROUP;
        } elseif ($_COOKIE['TASKGROUP']) {
            $case_taskgroup = $_COOKIE['TASKGROUP'];
        }
        $json_arr['TASKGROUP'] = $this->params->data['caseTaskgroup']; //set Members

        if ($case_taskgroup && $case_taskgroup != "all") {
            if (strstr($case_taskgroup, "-")) {
                $expst4 = explode("-", $case_taskgroup);
                $cbymile = $this->Format->caseGroupsList($expst4);
                if (in_array('default', $expst4)) {
                    $cbymile['default'] = __("Default Task Group", true);
                }
                foreach ($cbymile as $key => $st4) {
                    $miles .= "<span class='filter_opn' rel='tooltip' title='Taskgroup-" . $st4 . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"taskgroups\");'>" . $st4 . "<a href='javascript:void(0);' onclick='common_reset_filter(\"taskgroups\",\"" . $key . "\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $cbymile = $this->Format->caseGroupsList($case_taskgroup);
                foreach ($cbymile as $key => $st4) {
                    $miles = "<span class='filter_opn' rel='tooltip' title='Taskgroup- " . $st4 . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"taskgroups\");'>" . $st4 . "<a href='javascript:void(0);' onclick='common_reset_filter(\"taskgroups\",\"" . $key . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            }
            $arr['case_taskgroup'] = $miles;
            if ($json_arr['TASKGROUP'] && $json_arr['TASKGROUP'] != "all") {
                $val = 1;
            }
        } else {
            $arr['case_taskgroup'] = 'All';
        }
        //For AssignTo
        if (isset($this->params->data['caseAssignTo']) && $this->params->data['caseAssignTo']) {
            $case_assignto = $this->params->data['caseAssignTo'];
        } elseif (isset($json_array->ASSIGNTO)) {
            $case_assignto = $json_array->ASSIGNTO;
        } elseif ($_COOKIE['ASSIGNTO']) {
            $case_assignto = $_COOKIE['ASSIGNTO'];
        }

        $json_arr['ASSIGNTO'] = $this->params->data['caseAssignTo']; //Set Assign to

        if ($case_assignto && $case_assignto != "all" && $case_assignto != "unassigned") {
            if (strstr($case_assignto, "-")) {
                $expst5 = explode("-", $case_assignto);
                $asmembers = $this->Format->caseMemsList($expst5);
                foreach ($asmembers as $key => $st5) {
                    $asns .= "<span class='filter_opn' rel='tooltip' title='Assign To: " . $this->Format->caseMemsName($key) . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"assignto\");'>" . $st5 . "<a href='javascript:void(0);' onclick='common_reset_filter(\"assignto\",\"" . $key . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $asns = "<span class='filter_opn' rel='tooltip' title='Assign To: " . $this->Format->caseMemsName($case_assignto) . "' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"assignto\");'>" . $this->Format->caseMemsList($case_assignto) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"assignto\",\"" . $case_assignto . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }

            $arr['case_assignto'] = $asns;

            if ($json_arr['ASSIGNTO'] && $json_arr['ASSIGNTO'] != "all" && $json_arr['ASSIGNTO'] != "unassigned") {
                $val = 1;
            }
        } elseif ($case_assignto && $case_assignto == "unassigned") {
            $asns = "<span class='filter_opn' rel='tooltip' title='Assign To: Nobody' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"assignto\");'>Unassigned<a href='javascript:void(0);' onclick='common_reset_filter(\"assignto\",\"" . $case_assignto . "\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            $arr['case_assignto'] = $asns;
            if ($json_arr['ASSIGNTO'] && $json_arr['ASSIGNTO'] != "all" && $json_arr['ASSIGNTO'] != "unassigned") {
                $val = 1;
            }
        } else {
            $arr['case_assignto'] = 'All';
        }
        //For Case Date Status ....
        if (isset($this->params->data['casedate']) && $this->params->data['casedate']) {
            $date = $this->params->data['casedate'];
        } elseif (isset($json_array->DATE)) {
            $date = $json_array->DATE;
        } else {
            if (isset($this->params->data['resetall']) && $this->params->data['resetall'] == 0) {
                $date = "";
            } else {
                $date = $this->Cookie->read('DATE');
            }
        }

        $json_arr['DATE'] = $this->params->data['casedate']; //set $date
        if (!empty($date) && ($date != 'any')) {
            if ($json_arr['DATE'] && $json_arr['DATE'] != "any") {
                $val = 1;
            }
            if (trim($date) == 'one') {
                $arr['date'] = "<span class='filter_opn' rel='tooltip' title='Time' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"date\");'>Past hour<a href='javascript:void(0);' onclick='common_reset_filter(\"date\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (trim($date) == '24') {
                $arr['date'] = "<span class='filter_opn' rel='tooltip' title='Time' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"date\");'>Past 24Hour<a href='javascript:void(0);' onclick='common_reset_filter(\"date\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (trim($date) == 'today') {
                $arr['date'] = "<span class='filter_opn' rel='tooltip' title='Time' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"date\");'>Today<a href='javascript:void(0);' onclick='common_reset_filter(\"date\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (trim($date) == 'week') {
                $arr['date'] = "<span class='filter_opn' rel='tooltip' title='Time' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"date\");');'>Past Week<a href='javascript:void(0);'  onclick='common_reset_filter(\"date\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (trim($date) == 'month') {
                $arr['date'] = "<span class='filter_opn' rel='tooltip' title='Time' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"date\");'>Past month<a href='javascript:void(0);' onclick='common_reset_filter(\"date\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (trim($date) == 'year') {
                $arr['date'] = "<span class='filter_opn' rel='tooltip' title='Time' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"date\");'>Past Year<a href='javascript:void(0);' onclick='common_reset_filter(\"date\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (strstr(trim(urldecode($date)), "_")) {
                $date = explode('_', urldecode($date));
                $view = new View($this);
                $tz = $view->loadHelper('Tmzone');
                $date[0] = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date[0])), "date");
                $date[1] = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date[1])), "date");
                $arr['date'] = "<span class='filter_opn' rel='tooltip' title='Time' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"date\");'>" . urldecode(implode(' : ', $date)) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"date\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; // str_replace(":"," - ",$date);
            }
        } else {
            $arr['date'] = "Any Time";
        }

        if (isset($this->params->data['caseduedate']) && $this->params->data['caseduedate']) {
            $duedate = $this->params->data['caseduedate'];
        } elseif (isset($json_array->DUE_DATE)) {
            $duedate = $json_array->DUE_DATE;
        } else {
            if (isset($this->params->data['resetall']) && $this->params->data['resetall'] == 0) {
                $duedate = "";
            } else {
                $duedate = $json_array->DUE_DATE;
            }
        }

        $json_arr['DUE_DATE'] = $this->params->data['caseduedate']; //set Due date
        if (!empty($duedate)) {
            if ($json_arr['DUE_DATE'] && $json_arr['DUE_DATE'] != "any") {
                $val = 1;
            }
            if (trim($duedate) == 'overdue') {
                $arr['duedate'] = "<span class='filter_opn' rel='tooltip' title='Due Date' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"duedate\");'>Overdue<a href='javascript:void(0);' onclick='common_reset_filter(\"duedate\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (trim($duedate) == '24') {
                $arr['duedate'] = "<span class='filter_opn' rel='tooltip' title='Due Date' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"duedate\");'>Today<a href='javascript:void(0);' onclick='common_reset_filter(\"duedate\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            } elseif (strstr(trim(urldecode($duedate)), ":")) {
                $arr['duedate'] = "<span class='filter_opn' rel='tooltip' title='Due Date' onclick='openfilter_popup(1,\"dropdown_menu_all_filters\");allfiltervalue(\"duedate\");'>" . str_replace(":", " - ", urldecode($duedate)) . "<a href='javascript:void(0);' onclick='common_reset_filter(\"duedate\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; // str_replace(":"," - ",$date);
            }
        } else {
            $arr['duedate'] = "Any Time";
        }
        // Case page
        if (isset($this->params->data['casePage']) && $this->params->data['casePage']) {
            $case_page = $this->params->data['casePage'];
        } elseif ($this->Cookie->read('PAGE')) {
            $case_page = $this->Cookie->read('PAGE');
        }
        // Case Search value
        if (isset($this->params->data['caseSearch']) && $this->params->data['caseSearch'] != "") {
            //$case_search = trim(urldecode(htmlentities(strip_tags($this->params->data['caseSearch']))));
            $case_search = h($this->params->data['caseSearch']);
        } elseif ($_COOKIE['SEARCH']) {
            //$case_search = trim(urldecode(htmlentities(strip_tags($_COOKIE['SEARCH']))));
            $case_search = h($_COOKIE['SEARCH']);
        }
        if (isset($this->params->data['resetall'])) {
            $resetall = $this->params->data['resetall'];
        }
        if (isset($this->params->data['clearCaseSearch']) && $this->params->data['clearCaseSearch']) {
            $case_search = "";
        }
        if (isset($case_search) && $case_search) {
            $arr['case_search'] = "<span title='Search'>" . $case_search . "<a href='javascript:void(0);' onclick='common_reset_filter(\"search\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            $arr['search_case'] = $case_search;
            $val = 1;
        }
        if (isset($case_page) && $case_page && $case_page != 1 && $resetall == 0) {
            $arr['case_page'] = "<span class='filter_opn' rel='tooltip' title='Pagination'>Page: " . $case_page . "<a href='javascript:void(0);' onclick='common_reset_filter(\"casepage\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            $arr['page_case'] = $case_page;
            $val = 1;
        }

        $arr['mlstn'] = "All";
        // Task Sort order tagging
        if (isset($_COOKIE['TASKSORTBY']) && $_COOKIE['TASKSORTBY'] != "") {
            $tsortby = $_COOKIE['TASKSORTBY'];
            $tsortorder = $_COOKIE['TASKSORTORDER'];

            if ($_COOKIE['TASKSORTBY'] == 'caseno') {
                $tsortby = 'Task#';
            } elseif ($_COOKIE['TASKSORTBY'] == 'caseAt') {
                $tsortby = 'Assigned to';
            } elseif ($_COOKIE['TASKSORTBY'] == 'duedate') {
                $tsortby = 'Due Date';
            } else {
                $tsortby = ucfirst($tsortby);
            }

            if ($tsortorder == 'DESC') {
                $sorticon = 'tsk_desc_icon';
            } else {
                $sorticon = 'tsk_asc_icon';
            }

            $arr['tasksortby'] = "<span class='filter_opn' rel='tooltip' style='position:relative;' title='Sort by " . $tsortby . ": " . $tsortorder . "' onclick='openfilter_popup(1,\"dropdown_menu_sortby_filters\");'>" . $tsortby . "<a href='javascript:void(0);' onclick='common_reset_filter(\"taskorder\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
        }

        // Task Group by Tagging
        if (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] != "") {
            $groupby = $_COOKIE['TASKGROUPBY'];
            if ($groupby == 'crtdate') {
                $gby = "Created Date";
            } elseif ($groupby == 'duedate') {
                $gby = 'Due Date';
            } elseif ($groupby == 'assignto') {
                $gby = 'Assigned to';
            } else {
                $gby = ucfirst($groupby);
            }
            if (strtolower($gby) != 'milestone') {
                $arr['taskgroupby'] = "<span class='filter_opn' rel='tooltip' title='Group by' onclick='openfilter_popup(1,\"dropdown_menu_groupby_filters\");'>" . $gby . "<a href='javascript:void(0);' onclick='common_reset_filter(\"taskgroupby\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
        }

        //if($this->params->data['caseMenuFilters'] == 'milestone') {
        if (isset($this->params->data['milestoneIds']) && $this->params->data['milestoneIds']) {
            $milestoneIds = $this->params->data['milestoneIds'];
        } elseif ($this->Cookie->read('MILESTONES')) {
            $milestoneIds = $this->Cookie->read('MILESTONES');
        }

        if (stristr($milestoneIds, "-")) {
            $cookies = trim(trim($milestoneIds, "-"));
            if ($cookies) {
                $ids = explode("-", $cookies);
                $this->loadModel('Milestone');
                $mlsArr = $this->Milestone->find('first', array('conditions' => array('Milestone.id' => $ids, 'Milestone.isactive' => 1), 'fields' => array('Milestone.title')));
                $titl = ucfirst(trim($mlsArr['Milestone']['title']));
                if (strlen($titl) > 5) {
                    $titl = substr($titl, 0, 5) . "...";
                }
                $arr['mlstn'] = "<span class='filter_opn' rel='tooltip' title='Task Group'>" . $titl . "<a href='javascript:void(0);' onclick='common_reset_filter(\"mlstn\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                $val = 1;
            }
        }

        if ((isset($_COOKIE['TASKGROUP_FIL']) && trim($_COOKIE['TASKGROUP_FIL']) != 'all')) {
            if (trim($_COOKIE['TASKGROUP_FIL']) != 'all' && trim($_COOKIE['TASKGROUP_FIL']) != '') {
                $text = $_COOKIE['TASKGROUP_FIL'];
            }
            $arr['tskgrp'] = "<span class='filter_opn' rel='tooltip' title='" . ucfirst($text) . " Task Group'>" . ucfirst($text) . "<a href='javascript:void(0);' data-tgid='" . trim($text) . "' id='cls_task_grp' onclick='common_reset_filter(\"tskgrp\",\"\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            $val = 1;
        }
        //}

        if ($record['SearchFilter']['id'] != '') {
            $data['SearchFilter']['id'] = $record['SearchFilter']['id'];
            $data['SearchFilter']['first_records'] = $record['SearchFilter']['first_records'];
        }
        $data['SearchFilter']['user_id'] = SES_ID;
        $data['SearchFilter']['name'] = 'default';
        $data['SearchFilter']['json_array'] = json_encode($json_arr);
        $data['SearchFilter']['company_id'] = SES_COMP;
        $this->SearchFilter->save($data);

        $arr['val'] = $val;

        echo json_encode($arr);
        exit;
    }

    public function ajax_case_status()
    {

        //$this->layout = 'ajax';
        $this->autoRender = false;
        $this->layout = 'ajax';

        $proj_id = null;
        $pageload = 0;
        if (isset($this->params->data['projUniq'])) {
            $proj_uniq_id = $this->params->data['projUniq'];
        }
        $pageload = $this->params->data['pageload'];

        $this->loadModel('Easycase');

        if ($proj_uniq_id != 'all') {
            $this->loadModel('Project');
            $proj_id = 0;
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $proj_uniq_id), 'fields' => array('Project.id')));
//            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $proj_uniq_id, 'Project.isactive' => 1), 'fields' => array('Project.id')));
            if (!empty($projArr)) {
                $proj_id = $projArr['Project']['id'];
            }
        }

        $projUniq = $proj_uniq_id;
        $curProjId = $proj_id;
        $caseMenuFilters = $this->params->data['caseMenuFilters'];

        $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
        $caseCustomStatus = $this->params->data['caseCustomStatus']; // Filter by Custom Status
        $priorityFil = $this->params->data['priFil']; // Filter by Priority
        $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
        $caseLabel = $this->params->data['caseLabel']; // Filter by case label
        $caseUserId = $this->params->data['caseMember']; // Filter by Member
        $caseComment = $this->params->data['caseComment']; // Filter by Member
        $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
        $caseSrch = $this->params->data['caseSearch']; // Search by keyword
        @$case_srch = $this->params->data['case_srch'];
        @$case_date = urldecode($this->params->data['case_date']);
        @$case_duedate = $this->params->data['case_due_date'];
        $milestoneIds = $this->params->data['milestoneIds'];
        $checktype = $this->params->data['checktype'];
        $milestoneId = isset($this->data['milestoneId']) ? $this->data['milestoneId'] : '';
        $qry = "";

        $restrictedQuery="";
        if (!$this->Format->isAllowed('View All Task', $roleAccess)) {
            $restrictedQuery= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }
        if (!$milestoneId) {
            ######### Filter by Case Label ##########
            if (trim($caseLabel) && $caseLabel != "all") {
                $qry.= $this->Format->labelFilter($caseLabel, $curProjId, SES_COMP, SES_TYPE, SES_ID);
            }
            ######### Filter by Case Types ##########
            if (trim($caseTypes) && $caseTypes != "all") {
                $qry.= $this->Format->typeFilter($caseTypes);
            }
            ######### Filter by Priority ##########
            if (trim($priorityFil) && $priorityFil != "all") {
                $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            }
            ######### Filter by Member ##########
            if (trim($caseUserId) && $caseUserId != "all") {
                $qry.= $this->Format->memberFilter($caseUserId);
            }
            ######### Filter by Member ##########
            if (trim($caseComment) && $caseComment != "all") {
                $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
            }
            /*######### Filter by Status ##########
            if (trim($caseStatus) && $caseStatus != "all") {
            $qry.= $this->Format->statusFilter($caseStatus);
            }
            ######### Filter by Status ##########
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq,$caseStatus);
            }*/
            $is_def_status_enbled = 0;
            ######### Filter by Status ##########
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                $is_def_status_enbled = 1;
                $qry.= " AND (";
                $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus, 1);
            }
            ######### Filter by Status ##########
            if (trim($caseStatus) && $caseStatus != "all") {
                if (!$is_def_status_enbled) {
                    $qry.= " AND (";
                } else {
                    $qry.= " OR ";
                }
                $qry.= $this->Format->statusFilter($caseStatus, '', 1);
                $qry .= ")";
            } else {
                if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                    $qry .= ")";
                }
            }
            ######### Filter by AssignTo ##########		/* Added by smruti on 08082013*/
            if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
                $qry.= $this->Format->assigntoFilter($caseAssignTo);
            } elseif (trim($caseAssignTo) == "unassigned") {
                $qry.= " AND Easycase.assign_to='0'";
            }
            ######### Search by KeyWord ##########
            $searchcase = "";
            if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
                $qry = "";
                $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
            }
            if (trim(urldecode($case_srch)) != "") {
                $qry = "";
                $searchcase = "AND (Easycase.case_no = '$case_srch')";
            }

            if (trim(urldecode($caseSrch))) {
                if ((substr($caseSrch, 0, 1)) == '#') {
                    $qry = "";
                    $tmp = explode("#", $caseSrch);
                    $casno = trim($tmp['1']);
                    $searchcase = " AND (Easycase.case_no = '" . $casno . "')";
                }
            }

            if (trim($case_date) != "") {
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                
                if (trim($case_date) == 'one') {
                    $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
                } elseif (trim($case_date) == '24') {
                    $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
                } elseif (trim($case_date) == 'week') {
                    $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
                } elseif (trim($case_date) == 'month') {
                    $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
                } elseif (trim($case_date) == 'year') {
                    $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
                } elseif (strstr(trim($case_date), ":")) {
                    $ar_dt = explode(":", trim($case_date));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
                    //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }

            if (trim($case_duedate) != "") {
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                if (trim($case_duedate) == '24') {
                    $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                    $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
                } elseif (trim($case_duedate) == 'overdue') {
                    $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                    $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (Easycase.legend !=3)";
                } elseif (strstr(trim($case_duedate), ":")) {
                    $ar_dt = explode(":", trim($case_duedate));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }
        }
        $qry1 = "";
        ######### Filter by Case Title in archive case list page##########
        if ($this->params->data['page_type'] == 'ajax_case_title') {
//            $this->layout = 'ajax';
            $this->loadModel('ProjectUser');
            $getAllProj = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'ProjectUser.project_id'));
            if (!empty($getAllProj)) {
                $qry = '';
                $projIds = array();
                if (!empty($getAllProj)) {
                    foreach ($getAllProj as $pj) {
                        $projIds[] = $pj['ProjectUser']['project_id'];
                    }
                    $getUsers = array();
                    if (count($projIds)) {
                        $pjids = "(" . implode(",", $projIds) . ")";
                        $qry = "AND Easycase.project_id IN " . $pjids . "";
                    }
                }

                $clt_sql = 1;
                if ($this->Auth->user('is_client') == 1) {
                    $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
                }
                $caseCount1 = $this->Easycase->query("SELECT Easycase.id,Easycase.title,Easycase.uniq_id,Easycase.format,Easycase.case_no,Easycase.type_id,Easycase.legend,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,Archive.dt_created, User.name, User.last_name, User.short_name FROM easycases as Easycase,archives as Archive, users as User WHERE Easycase.id=Archive.easycase_id AND Easycase.user_id=User.id AND " . $clt_sql . " AND Archive.type = '1' AND Archive.company_id ='" . SES_COMP . "' " . $qry . $restrictedQuery ." AND Easycase.project_id != '0';");

                //pr($caseCount1);exit;

                $caseCount = count($caseCount1);
                $this->set('caseCount', $caseCount);
                $cse = $this->Easycase->query("SELECT Easycase.id,Easycase.title,Easycase.uniq_id,Easycase.format,Easycase.case_no,Easycase.type_id,Easycase.legend,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,Archive.dt_created, User.name, User.last_name, User.short_name FROM easycases as Easycase,archives as Archive, users as User WHERE Easycase.id=Archive.easycase_id AND Easycase.user_id=User.id AND Archive.type = '1' AND Archive.company_id ='" . SES_COMP . "' " . $qry. $restrictedQuery . " AND Easycase.project_id != '0' AND " . $clt_sql . " ORDER BY Archive.dt_created DESC");

                $this->set('list', $cse);
                $this->set('pjid', 'all');
            }
            $this->render('/Easycase/ajax_case_title', 'ajax');
        }
        $mlstnQ1 = "";
        $mlstnQ2 = "";
        switch ($caseMenuFilters) {
                case "assigntome":
            $qry.= " AND ((Easycase.assign_to=" . SES_ID . ") OR (Easycase.assign_to=0 AND Easycase.user_id=" . SES_ID . "))";
            $qry1.= " AND ((Easycase.assign_to=" . SES_ID . ") OR (Easycase.assign_to=0 AND Easycase.user_id=" . SES_ID . "))";
                    break;
                case "openedtasks":
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='4') AND Easycase.type_id !='10' ";
            $qry1.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='4') AND Easycase.type_id !='10' ";
                    break;
                case "highpriority":
            $qry.= " AND Easycase.priority='0'  ";
            $qry1.= " AND Easycase.priority='0'  ";
                    break;
                case "delegateto":
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
            $qry1.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
                    break;
                case "closedtasks":
            $qry.= " AND (Easycase.legend='3' OR Easycase.legend='5') AND Easycase.type_id !='10'";
            $qry1.= " AND (Easycase.legend='3' OR Easycase.legend='5') AND Easycase.type_id !='10'";
                    break;
                case "overdue":
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));

            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date !='0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND DATE(Easycase.due_date) < '" . GMT_DATE . "' "
                    . "AND (Easycase.legend !=3) ";
            $qry1.= " AND Easycase.due_date !='' AND Easycase.due_date !='0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND DATE(Easycase.due_date) < '" . GMT_DATE . "' "
                    . "AND (Easycase.legend !=3) ";
                    break;
                case "favourite":
            if ($projUniq != 'all') {
                $this->loadModel('ProjectUser');
                $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
                if (count($projArr)) {
                    $curProjId = $projArr['Project']['id'];
                    $curProjShortName = $projArr['Project']['short_name'];
                    $conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                    $this->loadModel('EasycaseFavourite');
                    $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                    //if(!empty($easycase_favourite)){
                    $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                    $qry1 .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                    //}
                }
            } else {
                $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                $this->loadModel('EasycaseFavourite');
                $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                // if(!empty($easycase_favourite)){
                $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                $qry1 .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                echo $qry1;
                exit;
                // }
            }
                    break;
                case "latest":
            $qry_rest = $qry;
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $all_rest = " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            $qry_rest.= " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
                    if ($projUniq != 'all') {
                        $CaseCount3 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase WHERE istype='1' AND Easycase.isactive='1' AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry_rest));
                        $CaseCount = $CaseCount3['0']['0']['count'];

                        if ($CaseCount == 0) {
                            $rest = $this->Easycase->query("SELECT dt_created FROM easycases WHERE project_id ='" . $curProjId . "' ORDER BY dt_created DESC LIMIT 0 , 1");
                            @$sdate = explode(" ", @$rest[0]['easycases']['dt_created']);
                            $qry.= " AND Easycase.dt_created >= '" . @$sdate[0] . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";

                            $qry1.= " AND Easycase.dt_created >= '" . @$sdate[0] . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
                        } else {
                            $qry = $qry . $all_rest;
                            $qry1.= $all_rest;
                        }
                    } elseif ($projUniq == 'all') {
                        $qry = $qry . $all_rest;
                        $qry1.= $all_rest;
                    }

                    break;
                case 'kanban':
                    if ($milestoneId) {
                        $mlstnQ1 = ",easycase_milestones as em,milestones as m ";
                        if ($milestoneId == "all") {
                            $milearr = $this->Milestone->find('all', array('conditions' => array('Milestone.project_id' => $curProjId, 'Milestone.company_id' => SES_COMP,'Milestone.isactive' => 1,'Milestone.is_started' => 1),'order'=>array('Milestone.modified DESC')));
                            $activ_sprint_id_arr = Hash::extract($milearr, '{n}.Milestone.id');
                            $activ_sprint_id = implode(',', $activ_sprint_id_arr);
                            $mlstnQ2 = " AND em.easycase_id=Easycase.id AND em.milestone_id=m.id  AND em.milestone_id IN(" . $activ_sprint_id . ") ";
                        } else {
                            $mlstnQ2 = " AND em.easycase_id=Easycase.id AND em.milestone_id=m.id  AND em.milestone_id=" . $milestoneId . " ";
                        }
                    }
                    break;
                case "milestone":
            $mstIds = array();
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                foreach ($expMilestoneIds as $msid) {
                    if ($msid) {
                        $mstIds[] = $msid;
                    }
                }
                if (count($mstIds)) {
                    $mlstFilter = " AND em.milestone_id IN (" . implode(",", $mstIds) . ") ";
                }
            }
            $mlstnQ1 = ",easycase_milestones as em,milestones as m ";
            if ($checktype != 'completed') {
                $mlst = " AND m.isactive='1' ";
            } else {
                $mlst = " AND m.isactive='0' ";
            }
            $mlstnQ2 = " AND em.easycase_id=Easycase.id AND em.milestone_id=m.id " . trim($mlst . $mlstFilter);
                    break;
                default:
        }

//        $Easycase = ClassRegistry::init('Easycase');
        $this->Easycase->recursive = -1;


        if ($proj_uniq_id == 'all') {
            $projQry = "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.company_id=" . SES_COMP . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')";
            $projQryMem = "";
        } else {
            $projQry = "AND Easycase.project_id='" . $proj_id . "'";
            $projQryMem = "AND ProjectUser.project_id='" . $proj_id . "'";
        }

        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $page_type = (isset($this->params->data['page_type']))?$this->params->data['page_type']:'';
        switch ($page_type) {
                case 'ajax_priority':
            /**
             * below query is for displaying the count of the high priority  always same without calculating it dynamically
             */
            $query_pri_high1 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND " . $clt_sql . " AND priority='0' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry.$restrictedQuery . " ");
            $query_pri_high = $query_pri_high1['0']['0']['count'];
//            $query_pri_medium1 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND " . $clt_sql . " AND priority='1' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry . " " . trim($qry) . "");
            /**
             * below query is for displaying the count of the medium priority  always same without calculating it dynamically
             */
            $query_pri_medium1 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND " . $clt_sql . " AND priority='1' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry.$restrictedQuery . " ");
            $query_pri_medium = $query_pri_medium1['0']['0']['count'];
//            $query_pri_low1 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND " . $clt_sql . " AND priority='2' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry . " " . trim($qry) . "");
            /**
             * below query is for displaying the count of the low priority  always same without calculating it dynamically
             */
            $query_pri_low1 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND " . $clt_sql . " AND priority='2' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry.$restrictedQuery . " ");
            $query_pri_low = $query_pri_low1['0']['0']['count'];

            $this->set('proj_uniq_id', $proj_uniq_id);
            $this->set('proj_id', $proj_id);
            $this->set('CookiePriority', $_COOKIE['PRIORITY']);
            $this->set('query_pri_high', $query_pri_high);
            $this->set('query_pri_medium', $query_pri_medium);
            $this->set('query_pri_low', $query_pri_low);

            $this->render('/Easycase/ajax_priority', 'ajax');
                    break;
                case 'ajax_members':
            /**
             * below query is for displaying the count of the low priority  always same without calculating it dynamically
             */
            $memArr = $this->Easycase->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.last_name,User.short_name,User.dt_last_login, (select count(Easycase.id) from easycases as Easycase" . $mlstnQ1 . " where Easycase.user_id=User.id and Easycase.istype='1' AND " . $clt_sql . " and User.isactive='1' and Easycase.isactive='1' " . $mlstnQ2 . $projQry.$restrictedQuery . " ) as cases FROM users as User,project_users as ProjectUser,company_users as CompanyUser WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' " . $projQryMem . " AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.name ASC");

            $this->set('proj_uniq_id', $proj_uniq_id);
            $this->set('proj_id', $proj_id);
            $this->set('memArr', $memArr);
            $this->set('CookieMem', $_COOKIE['MEMBERS']);

            $this->render('/Easycase/ajax_members', 'ajax');
                    break;
                case 'ajax_comments':

            $comArr = $this->Easycase->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.last_name,User.short_name,User.dt_last_login, (select count(DISTINCT Easycase.case_no) from easycases as Easycase" . $mlstnQ1 . " where Easycase.user_id=User.id and Easycase.istype='2' AND " . $clt_sql . " and User.isactive='1' and Easycase.isactive='1' " . $mlstnQ2 . $projQry.$restrictedQuery . " ) as cases FROM users as User,project_users as ProjectUser,company_users as CompanyUser WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' " . $projQryMem . " AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.name ASC");

            $this->set('proj_uniq_id', $proj_uniq_id);
            $this->set('proj_id', $proj_id);
            $this->set('comArr', $comArr);
            $this->set('CookieCom', $_COOKIE['COMMENTS']);
            $this->render('/Easycase/ajax_filter_comments', 'ajax');
                    break;
                case 'ajax_taskgroup':
            $this->loadModel('Milestone');
						if($proj_uniq_id == 'all'){
							if(SES_TYPE <= 2){
								$projQry = "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser, projects as Project WHERE ProjectUser.company_id=" . SES_COMP . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')";
								$projMilQry = "AND Milestone.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser, projects as Project WHERE ProjectUser.company_id=" . SES_COMP . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')";
							}else{
								$projQry = "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser, projects as Project WHERE ProjectUser.company_id=" . SES_COMP . " AND ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')";
								$projMilQry = "AND Milestone.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser, projects as Project WHERE ProjectUser.company_id=" . SES_COMP . " AND ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')";
							}	
						}else{
							$projQry = "AND Easycase.project_id =". $proj_id;
							$projMilQry = "AND Milestone.project_id =". $proj_id;
						}
						
            $groupArr = $this->Milestone->query("SELECT DISTINCT Milestone.id, Milestone.title,(select count(DISTINCT Easycase.case_no) from easycases as Easycase,easycase_milestones AS em WHERE Easycase.id= em.easycase_id AND em.milestone_id = Milestone.id AND Easycase.isactive='1' AND $clt_sql ".$projQry." $restrictedQuery AND Easycase.istype='1') AS cases FROM milestones as Milestone WHERE Milestone.company_id='" .SES_COMP."' ".$projMilQry." ORDER BY Milestone.id_seq ASC");

           $getAllDefaulttasks = $this->Easycase->query("SELECT count(DISTINCT Easycase.case_no) AS cnt from easycases as Easycase LEFT JOIN easycase_milestones AS em ON Easycase.id= em.easycase_id WHERE em.milestone_id IS NULL AND Easycase.isactive='1' AND $clt_sql ".$projQry." $restrictedQuery AND Easycase.istype='1'");
            $count = $getAllDefaulttasks[0][0]['cnt'];
            if ($count) {
                $groupArr[] = array(array('cases'=>$count),'Milestone'=>array('id'=>'default','title'=>__('Default Task Group')));
            }
            $this->set('proj_uniq_id', $proj_uniq_id);
            $this->set('proj_id', $proj_id);
            $this->set('groupArr', $groupArr);
            $this->set('CookieGroup', $_COOKIE['TASKGROUP']);
            $this->render('/Easycase/ajax_filter_taskgroup', 'ajax');
                    break;
                case 'ajax_assignto':
            /* display the assign to me in */
            $asnArr = $this->Easycase->query("SELECT DISTINCT User.id, User.name, User.last_name, User.email, User.istype,User.short_name,User.dt_last_login,  (select count(Easycase.id) from easycases as Easycase" . $mlstnQ1 . " where Easycase.assign_to = User.id and Easycase.istype='1' AND " . $clt_sql . " and User.isactive='1' and Easycase.isactive='1' " . $mlstnQ2 . $projQry.$restrictedQuery . ") as cases FROM users as User,project_users as ProjectUser,company_users as CompanyUser,projects as Project WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' $projQryMem  AND Project.id=ProjectUser.project_id AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.name ASC");
            $unsncnt = "select count(Easycase.id) as unasn_count from easycases as Easycase where Easycase.assign_to = '0' AND Easycase.isactive = '1' AND Easycase.istype = '1' AND " . $clt_sql . " and Easycase.isactive='1' " . $mlstnQ2 . $projQry . " ";
            $unasncount = $this->Easycase->query($unsncnt);
            $this->set('proj_uniq_id', $proj_uniq_id);
            $this->set('proj_id', $proj_id);
            $this->set('asnArr', $asnArr);
            $this->set('CookieAsn', $_COOKIE['ASSIGNTO']);
            $this->set('unasncount', $unasncount);
            $this->render('/Easycase/ajax_assignto', 'ajax');
                    break;
                case 'ajax_types':
            /* display count without query */
            $ov_view = 0;
            if (isset($this->params->data['extra']) && $this->params->data['extra'] = 'overview') {
                $ov_view = 1;
            }
            if (SES_TYPE == 1 && isset($this->params->data['page_type_pie']) && $this->params->data['page_type_pie'] && !$ov_view) { //for owner
                $projQry = "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.company_id=" . SES_COMP . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')";
            }
            $assginto ="";
            if (SES_TYPE==3 && isset($this->params->data['page_type_pie']) && $this->params->data['page_type_pie']) {
                $assginto = " AND Easycase.assign_to=" . SES_ID ;
            }
            $pids = array();
            if ($proj_uniq_id !='all') {
                $pids[] = $proj_id;
            } else {
                $this->loadModel("ProjectUser");
                $allps = $this->ProjectUser->query("SELECT DISTINCT Project.id FROM project_users AS ProjectUser,projects AS Project WHERE Project.id= ProjectUser.project_id AND ProjectUser.user_id=" . SES_ID . " AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "' ORDER BY ProjectUser.dt_visited DESC");
                foreach ($allps as $k=>$v) {
                    $pids[] = $v['Project']['id'];
                }
            }
						if(!empty($pids)){
            $pids_implode = implode(',', $pids);
            
						}else{
							$pids_implode = 0;
						}
                    /*$types_sql = "select DISTINCT t.name,t.id,t.short_name,t.company_id,(select count(Easycase.id) from easycases as Easycase" . $mlstnQ1 . " where Easycase.istype='1'".$assginto." AND " . $clt_sql.$restrictedQuery . " AND Easycase.type_id=t.id AND Easycase.isactive='1' " . $mlstnQ2 . $projQry . " ) as count from types as t
            WHERE CASE WHEN (SELECT COUNT(*) AS total FROM type_companies WHERE company_id = " . SES_COMP . " HAVING total >=1) THEN id IN (SELECT type_id FROM type_companies WHERE company_id = " . SES_COMP . ") ELSE company_id = 0 End AND t.project_id in (".$pids_implode.")
            ORDER BY count DESC";
                    $typeArr = $this->Easycase->query($types_sql);*/
                
                    /*$types_sqlD = "select DISTINCT t.name,t.id,t.short_name,t.company_id,(select count(Easycase.id) from easycases as Easycase" . $mlstnQ1 . " where Easycase.istype='1'".$assginto." AND " . $clt_sql.$restrictedQuery . " AND Easycase.type_id=t.id AND Easycase.isactive='1' " . $mlstnQ2 . $projQry . " ) as count from types as t
                    WHERE t.company_id = ".SES_COMP." AND t.project_id in (".$pids_implode.")
                    ORDER BY count DESC";
                    $typeArrD = $this->Easycase->query($types_sqlD);
            $types_sql = "select DISTINCT t.name,t.id,t.short_name,t.company_id,(select count(Easycase.id) from easycases as Easycase" . $mlstnQ1 . " where Easycase.istype='1'".$assginto." AND " . $clt_sql.$restrictedQuery . " AND Easycase.type_id=t.id AND Easycase.isactive='1' " . $mlstnQ2 . $projQry . " ) as count from types as t
                    WHERE  t.company_id = 0 AND t.project_id in (".$pids_implode.")
            ORDER BY count DESC";
            $typeArr = $this->Easycase->query($types_sql);
                    pr($typeArr);*/
                    
                    $this->loadModel('Type');
                    $this->Type->bindModel(array('belongsTo' => array('Project')));
                    $allTypes = $this->Type->find('all', array('conditions' => array('Type.company_id'=>array(0,SES_COMP)),'fields'=>array('Type.id','Type.name','Type.short_name','Type.company_id','Project.short_name','Project.name'), 'order' => array('Type.company_id'=> 'ASC','Type.name'=> 'ASC')));
                    
                    $types_sql = "select count(e.id) as cnt,t.name,t.id,t.short_name,t.company_id from types as t LEFT JOIN easycases as e on e.type_id=t.id where e.project_id in (".$pids_implode.") and e.istype=1 and e.isactive=1 group by type_id order by t.company_id ASC";
                    $typeArr_new = $this->Easycase->query($types_sql);
                    if (!empty($typeArr_new)) {
                        $typeArr_new = Hash::combine($typeArr_new, '{n}.t.id', '{n}');
                    }
                    $typeArr = array();
                    foreach ($allTypes as $k => $v) {
                        $_tarr[0]['count'] = (!empty($typeArr_new[$v['Type']['id']]))?$typeArr_new[$v['Type']['id']][0]['cnt']:0;
                        $v['Type']['project_name'] = (!empty($v['Project']['name']))? $v['Type']['name'] .' ('.$v['Project']['name'].")":$v['Type']['name'];
                        $v['Type']['name'] = (!empty($v['Project']['short_name']))? $v['Type']['name'] .'-'.$v['Project']['short_name']:$v['Type']['name'];
                        $_tarr['t'] = $v['Type'];
                        array_push($typeArr, $_tarr);
                    }
                    /*if(isset($typeArrD)){
                        foreach ($typeArrD as $k => $v) {
                            array_push($typeArr, $v);
                        }
                    }*/
            $this->set('proj_uniq_id', $proj_uniq_id);
            $this->set('proj_id', $proj_id);
            $this->set('typeArr', $typeArr);
            $this->set('CookieTypes', $_COOKIE['CS_TYPES']);
            if (isset($this->params->data['page_type_pie'])) {
                $arr_ouput = array();
                $total_count = 0;
                $otherId = 0;
                if (SES_TYPE ==3) {
                    foreach ($typeArr as $k => $v) {
                        if ($v['t']['id'] == '8' || $v['t']['company_id'] != 0) {
                            if (!$otherId) {
                                $otherId = $k;
                                $arr_ouput[$otherId]['name'] = 'Others';
                                $arr_ouput[$otherId]['y'] = 0;
                                $arr_ouput[$otherId]['project_name'] = 'Others';
                            }
                            $arr_ouput[$otherId]['y'] += intval($v[0]['count']);
                            $total_count += intval($v[0]['count']);
                        } else {
                            $arr_ouput[$k]['name'] = trim($v['t']['name']);
                            $arr_ouput[$k]['y'] = intval($v[0]['count']);
                            $arr_ouput[$k]['project_name'] = trim($v['t']['project_name']);
                            $total_count += intval($v[0]['count']);
                        }
                    }
                } else {
                    foreach ($typeArr as $k => $v) {
                        $arr_ouput[$k]['name'] = trim($v['t']['name']);
                        $arr_ouput[$k]['y'] = intval($v[0]['count']);
                        $arr_ouput[$k]['project_name'] = trim($v['t']['project_name']);
                        $total_count += intval($v[0]['count']);
                    }
                }
                if ($arr_ouput) {
                    $arr_ouput = array_values($arr_ouput);
                }
                $arr_ouput_t['data'] = array();
                $arr_ouput_t['data'] = $arr_ouput;
                $arr_ouput_t['status'] = 'success';
                $arr_ouput_t['total_cnt'] = $total_count;
                echo json_encode($arr_ouput_t);
                exit;
            } else {
                $this->render('/Easycase/ajax_types', 'ajax');
            }
                    break;
                case 'ajax_label':
             /* We are showing records for */
             $this->loadModel('EasycaseLabel');
            $lbl_cond = array('EasycaseLabel.company_id' => SES_COMP, 'EasycaseLabel.project_id' => $proj_id);
            if (SES_TYPE == 1 && isset($this->params->data['page_type_pie']) && $this->params->data['page_type_pie']) {
                //for owner
                //$lbl_cond = '';
            }
            if ($proj_uniq_id == 'all') {
                $prjids = $this->ProjectUser->getAllActiveProject(SES_ID, SES_COMP, SES_TYPE);
                if ($prjids) {
                    $prjids= Hash::extract($prjids, '{n}.ProjectUser.project_id');
                    $lbl_cond = array('EasycaseLabel.company_id' => SES_COMP, 'EasycaseLabel.project_id' => $prjids);
                } else {
                    $lbl_cond = array('EasycaseLabel.company_id' => SES_COMP);
                }
                $lablesTasks = $this->EasycaseLabel->find('all', array('conditions' => $lbl_cond,'fields'=>array('EasycaseLabel.id as elbid','Label.lbl_title','Label.id','COUNT(EasycaseLabel.easycase_id) as ec_cnt'),'group' => 'EasycaseLabel.label_id','order' => 'EasycaseLabel.id DESC'));
                $eslids = Hash::combine($lablesTasks, "{n}.EasycaseLabel.elbid", "{n}.Label.lbl_title");
                //echo "<pre>";print_r($lablesTasks);
                //echo "<pre>";print_r($eslids);exit;
                $lbl_name = array();
                if ($lablesTasks) {
                    foreach ($lablesTasks as $k => $v) {
                        $crnt_lbl = $v['Label']['lbl_title'];
                        $lbl_cnt = $v[0]['ec_cnt'];
                        if (in_array($v['Label']['lbl_title'], $lbl_name)) {
                            unset($lablesTasks[$k]);
                            foreach ($lablesTasks as $k1 => $v1) {
                                if ($v1['Label']['lbl_title'] == $crnt_lbl) {
                                    $lablesTasks[$k1][0]['ec_cnt'] = $lablesTasks[$k1][0]['ec_cnt'] + $lbl_cnt;
                                    continue;
                                }
                            }
                        }
                        array_push($lbl_name, $v['Label']['lbl_title']);
                    }
                }
            } else {
                $lablesTasks = $this->EasycaseLabel->find('all', array('conditions' => $lbl_cond,'fields'=>array('EasycaseLabel.id as elbid','Label.lbl_title','Label.id','COUNT(EasycaseLabel.easycase_id) as ec_cnt'),'group' => 'EasycaseLabel.label_id','order' => 'EasycaseLabel.id DESC'));
            }
            $this->set('proj_uniq_id', $proj_uniq_id);
            $this->set('proj_id', $proj_id);
            $this->set('LabelArr', $lablesTasks);
            //$this->set('CookieLabel', $_COOKIE['CS_TYPES']);
            $this->render('/Easycase/ajax_label', 'ajax');
                    break;
                case 'ajax_archive_project':
                case 'ajax_utilization_project':
                case 'ajax_pending_project':
            if (SES_TYPE < 3 || $this->Format->isAllowed('View All Resource')) {
                $arc_prj_qry = "SELECT Project.id,  Project.name, Project.short_name FROM projects AS Project where Project.company_id = '" . SES_COMP . "' Order BY Project.name ASC";
            } else {
                $arc_prj_qry = "SELECT Project.id,  Project.name, Project.short_name FROM projects AS Project  LEFT JOIN project_users AS ProjectUser ON(ProjectUser.project_id = Project.id AND ProjectUser.company_id = Project.company_id) where Project.company_id = '" . SES_COMP . "' AND ProjectUser.user_id = ".SES_ID." Order BY Project.name ASC";
            }
            $caseCount = $this->Easycase->query($arc_prj_qry);
            $this->set('prjlist', $caseCount);
                    if ($page_type == 'ajax_utilization_project') {
                        $this->render('/Easycase/ajax_utilization_project', 'ajax');
                    } elseif ($page_type == 'ajax_pending_project') {
                        $this->render('/Easycase/ajax_pending_project', 'ajax');
                    } else {
                        $this->render('/Easycase/ajax_archive_project', 'ajax');
                    }
                    break;
                case 'ajax_archivedby':
                case 'ajax_utilization_resource':
                case 'ajax_pending_resource':
             if (SES_TYPE < 3 || $this->Format->isAllowed('View All Resource')) {
                 $ucond = " AND 1 ";
             } else {
                 $ucond = " AND User.id='".SES_ID."' ";
             }
            $qry = "SELECT DISTINCT User.id, User.name, User.last_name, User.short_name FROM users as User, company_users As CompanyUser WHERE CompanyUser.user_id=User.id AND CompanyUser.company_id =" . SES_COMP . " AND User.name != '' $ucond AND CompanyUser.is_active =1 ORDER BY User.name ASC";
            $cse = $this->Easycase->query($qry);
            $this->set('list', $cse);
                    if ($page_type == 'ajax_utilization_resource') {
                        $this->render('/Easycase/ajax_utilization_resource', 'ajax');
                    } elseif ($page_type == 'ajax_pending_resource') {
                        $this->render('/Easycase/ajax_pending_resource', 'ajax');
                    } else {
                        $this->render('/Easycase/ajax_archivedby', 'ajax');
                    }
                    break;
                case 'ajax_utilization_label':
            $this->LoadModel('Label');
            $qry = "SELECT DISTINCT Label.id, Label.lbl_title FROM labels as Label, easycase_labels As EasycaseLabel WHERE EasycaseLabel.label_id=Label.id AND EasycaseLabel.company_id =" . SES_COMP . " AND Label.lbl_title != '' AND Label.is_active =1 ORDER BY Label.lbl_title ASC";
            $cse = $this->Label->query($qry);
            $this->set('list', $cse);
              $this->render('/Easycase/ajax_utilization_label', 'ajax');
                    break;
                case 'ajax_archive_assign':
            $qry = "SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.dt_last_login,  (select count(Easycase.id) from easycases as Easycase where Easycase.assign_to = User.id and Easycase.istype='1' AND User.isactive='1' and Easycase.isactive!='1') as cases FROM users as User,project_users as ProjectUser,company_users as CompanyUser,projects as Project WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' AND Project.id=ProjectUser.project_id AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.short_name";
            $cse = $this->Easycase->query($qry);
            $this->set('list', $cse);
            $this->render('/Easycase/ajax_archive_assign', 'ajax');
                    break;
                case 'ajax_status':
                default:
                    $query_All = 0;
                    $query_New = 0;
                    $query_Open = 0;
                    $query_Close = 0;
                    $query_Start = 0;
                    $query_Resolve = 0;
                    $query_Attch = 0;
                    $query_Upd = 0;
                    $resCaseWidget = array();
                    /**
                        * below query is for displaying the count of the status type always same without calculating it dynamically
                    */
                    if ($caseMenuFilters == "assigntome") {
                        $qry_S = " AND Easycase.assign_to=" . SES_ID . " ";
                    } elseif ($caseMenuFilters == "favourite") {
                        if ($projUniq != 'all') {
                            $this->loadModel('ProjectUser');
                            $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                            $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
                            if (count($projArr)) {
                                $curProjId = $projArr['Project']['id'];
                                $curProjShortName = $projArr['Project']['short_name'];
                                $conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                                $this->loadModel('EasycaseFavourite');
                                $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                                //if(!empty($easycase_favourite)){
                                $qry_S .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."') ";
                                //}
                            }
                        } else {
                            $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                            $this->loadModel('EasycaseFavourite');
                            $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                            // if(!empty($easycase_favourite)){
                            $qry_S .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."') ";
                            // }
                        }
                    } else {
                        $qry_S= "";
                    }
                    $cstm_qry = ' Easycase.custom_status_id=0 ';
                    if ((isset($this->params->data['caseMenuType']) && trim($this->params->data['caseMenuType']) == 'sprint')) {
                        $cstm_qry = '1';
                    }
					if(!empty($_COOKIE['CURRENT_SPRINT_FILTER']) && $caseMenuFilters == "kanban"){
                         $qry_S.= ' '.$_COOKIE['CURRENT_SPRINT_FILTER'];
                     }
                    // echo "SELECT COUNT(Easycase.id) as count,if(Easycase.type_id=10,Easycase.legend,Easycase.legend) AS legend FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND ".$cstm_qry." AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry . $searchcase .$qry_S.$restrictedQuery. "  GROUP BY Easycase.legend";exit;
                    $common_qry = $this->Easycase->query("SELECT COUNT(Easycase.id) as count,if(Easycase.type_id=10,Easycase.legend,Easycase.legend) AS legend FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND ".$cstm_qry." AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry . $searchcase .$qry_S.$restrictedQuery. "  GROUP BY Easycase.legend"); //if(Easycase.type_id=10,10,Easycase.legend)
                    
                    #print "SELECT COUNT(Easycase.id) as count,if(Easycase.type_id=10,10,Easycase.legend) AS legend FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND " . $clt_sql . " AND  Easycase.isactive='1' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry . $searchcase .$qry_S.$restrictedQuery. "  GROUP BY if(Easycase.type_id=10,10,Easycase.legend)";exit;
                    
                    $customStatus = 0;
                    if ($proj_uniq_id != 'all') {
                        $customStatus = $this->Format->hasCustomTaskStatus($curProjId, 'Project.id');
                    }
                    $check_cstm_sts = 0;
                    if (!isset($this->params->data['caseMenuType']) || (isset($this->params->data['caseMenuType']) && trim($this->params->data['caseMenuType']) != 'sprint')) {
                        $check_cstm_sts = 1;
                    }
                    #pr($this->params->data);exit;
                    if ($proj_uniq_id == 'all' || $customStatus ==0 || $check_cstm_sts==0) {
						foreach ($common_qry AS $key => $val) {
                            if ($val[0]['legend'] == 1) {
                                $query_New = $val[0]['count'];
                            } elseif ($val[0]['legend'] == 2 || $val[0]['legend'] == 4) {
                                $query_Open +=$val[0]['count'];
                            } elseif ($val[0]['legend'] == 3) {
                                $query_Close = $val[0]['count'];
                            } elseif ($val[0]['legend'] == 5) {
                                $query_Resolve = $val[0]['count'];
                            }
                            if ($val[0]['legend'] == 10) {
                                $query_Upd = $val[0]['count'];
                            } else {
                                $query_All +=$val[0]['count'];
                            }
                        }
                    }
                    $query_custom_status = array();
                    if (($customStatus && $check_cstm_sts) || !isset($this->params->data['caseMenuType'])) {
                        /** Author: SSL
                            Custom Task Status Group
                        **/
                        $Cs_common_qry = $this->Easycase->query("SELECT COUNT(Easycase.id) as count,if(Easycase.type_id=10,Easycase.custom_status_id,Easycase.custom_status_id) AS legend,CustomStatus.name,CustomStatus.color  FROM easycases as Easycase LEFT JOIN custom_statuses as CustomStatus ON CustomStatus.id= Easycase.custom_status_id " . $mlstnQ1 . " WHERE Easycase.istype='1' AND " . $clt_sql . " AND  Easycase.isactive='1' AND  Easycase.custom_status_id !='0' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry . $searchcase .$qry_S.$restrictedQuery. "  GROUP BY if(Easycase.type_id=10,Easycase.custom_status_id,Easycase.custom_status_id)");
                        if ($proj_uniq_id != 'all') {
                            $allStatusNames = $this->Format->getCustomTaskStatus($customStatus);
                        } else {
                            $allStatusNames = $this->Format->getCustomTaskStatus(-1);
                        }
						foreach ($Cs_common_qry AS $key => $val) {
                            $query_custom_status[$val[0]['legend']]['count'] = ($val[0]['count'])?$val[0]['count']:0;
                            $query_custom_status[$val[0]['legend']]['legend'] = $val[0]['legend'];
                            $query_custom_status[$val[0]['legend']]['color'] = $val['CustomStatus']['color'];
                            $query_custom_status[$val[0]['legend']]['name'] = $val['CustomStatus']['name'];
                            $query_All += $val[0]['count'];
                        }
                        $final_status_array = array();
                        $final_sts_ary_names = array();
						foreach ($allStatusNames AS $key => $val) {
                            if ($proj_uniq_id == 'all') {
                                if (!array_key_exists($val['CustomStatus']['id'], $query_custom_status)) {
                                    $query_custom_status[$val['CustomStatus']['id']]['count'] = ($val[0]['count'])?$val[0]['count']:0;
                                    $query_custom_status[$val['CustomStatus']['id']]['legend'] = $val['CustomStatus']['id'];
                                    $query_custom_status[$val['CustomStatus']['id']]['color'] = $val['CustomStatus']['color'];
                                    $query_custom_status[$val['CustomStatus']['id']]['name'] = $val['CustomStatus']['name'];
                                }
                                //echo trim($val['CustomStatus']['name']).'---'.$query_custom_status[$val['CustomStatus']['id']]['count'].'======';
                                if (!array_key_exists(trim($val['CustomStatus']['name']), $final_sts_ary_names)) {
                                    $final_sts_ary_names[trim($val['CustomStatus']['name'])] = $val['CustomStatus']['id'];
                                    $final_status_array[$val['CustomStatus']['id']] = $query_custom_status[$val['CustomStatus']['id']];
                                } else {
                                    $final_status_array[$final_sts_ary_names[trim($val['CustomStatus']['name'])]]['count'] += $query_custom_status[$val['CustomStatus']['id']]['count'];
                                }
                            } else {
                                if (!array_key_exists($val['CustomStatus']['id'], $query_custom_status)) {
                                    $query_custom_status[$val['CustomStatus']['id']]['count'] = ($val[0]['count'])?$val[0]['count']:0;
                                    $query_custom_status[$val['CustomStatus']['id']]['legend'] = $val['CustomStatus']['id'];
                                    $query_custom_status[$val['CustomStatus']['id']]['color'] = $val['CustomStatus']['color'];
                                    $query_custom_status[$val['CustomStatus']['id']]['name'] = $val['CustomStatus']['name'];
                                    $final_status_array[$val['CustomStatus']['id']] = $query_custom_status[$val['CustomStatus']['id']];
                                } else {
                                    $final_status_array[$val['CustomStatus']['id']] = $query_custom_status[$val['CustomStatus']['id']];
                                }
                            }
                        }
                    }
                    if (!empty($final_status_array)) {
                        $final_status_array = array_values($final_status_array);
                    }
                    if ($page_type == 'ajax_status') {
                        $query_Attch1 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase" . $mlstnQ1 . " WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.format='1' AND Easycase.project_id!=0 " . $mlstnQ2 . $projQry . " " . trim($qry) .$restrictedQuery. "");
                        $query_Attch = $query_Attch1['0']['0']['count'];
                        
                        $this->set('projuniq', $proj_uniq_id);
                        $this->set('pageload', $pageload);
                        
                        $this->set('query_All', $query_All);
                        $this->set('query_New', $query_New);
                        $this->set('query_Open', $query_Open);
                        $this->set('query_Close', $query_Close);
                        $this->set('query_Resolve', $query_Resolve);
                        $this->set('query_Start', $query_Start);
                        $this->set('query_Attch', $query_Attch);
                        $this->set('query_Upd', $query_Upd);
                        //$this->set('custom_status', $query_custom_status);
                        $this->set('custom_status', $final_status_array);
                        $this->set('CookieStatus', $_COOKIE['STATUS']);
                        $this->set('CookieCustomStatus', $_COOKIE['CUSTOM_STATUS']);
                        if ($customStatus) {
                            $this->set('allCustomStatus', $this->Format->getCustomTaskStatus($customStatus));
                        }
                        $this->render('/Easycase/ajax_status', 'ajax');
                    } else {
                        $resCaseWidget['al'] = $query_All;
                        if ($proj_uniq_id == 'all') {
                            $resCaseWidget['nw'] = $query_New;
                            $resCaseWidget['opn'] = $query_Open;
                            if (isset($this->params->data['caseMenuType'])) {
                                $resCaseWidget['cls'] = $query_Close+$query_Resolve;
                            } else {
                                $resCaseWidget['cls'] = $query_Close;
                            }
                            $resCaseWidget['rslv'] = $query_Resolve;
                            $resCaseWidget['upd'] = $query_Upd;
                        } else {
                            if ($customStatus ==0 || $check_cstm_sts==0) {
                                $resCaseWidget['nw'] = $query_New;
                                $resCaseWidget['opn'] = $query_Open;
                                if (isset($this->params->data['caseMenuType'])) {
                                    $resCaseWidget['cls'] = $query_Close+$query_Resolve;
                                } else {
                                    $resCaseWidget['cls'] = $query_Close;
                                }
                                $resCaseWidget['rslv'] = $query_Resolve;
                                $resCaseWidget['upd'] = $query_Upd;
                            }
                        }
                        //$resCaseWidget['CustomStatus'] = $query_custom_status;
                        $resCaseWidget['CustomStatus'] = $final_status_array;
                        $resCaseWidget['total_length'] = count($query_custom_status);
                        if (isset($resCaseWidget['cls'])) {
                            $resCaseWidget['total_length'] = $resCaseWidget['total_length']+4;
                        }
                        #pr($resCaseWidget);exit;
                        $this->set('resCaseWidget', json_encode($resCaseWidget));
                        $this->render('/Easycase/ajax_case_status', 'ajax');
                    }
                    break;
        }
    }

    /**
     * Function to manage ajax call for time log
     */
    public function time_log()
    {
        $this->layout = 'ajax';
        $prjid = $GLOBALS['getallproj'][0]['Project']['id'];
        $prjuniqueid = $GLOBALS['getallproj'][0]['Project']['uniq_id'];
        #pr($this->data);exit;
        $projFil = $this->data['projFil'];
        $filter = $this->data['filter'];
        $data = $this->data;
        $usid = '';
        $st_dt = '';
        $where = '';
        /* updating latest project id for user */
        if ($data['projFil'] && !(isset($data['usrid']) || isset($data['strddt']) || isset($data['enddt']) || isset($data['filter']))) {
            if ($prjuniqueid != $projFil) {
                $projid = $this->Project->find('first', array('fields' => array('Project.id'), 'conditions' => array('Project.uniq_id' => $projFil)));
                $prjid = $projid['Project']['id'];
            }
            $this->loadModel('ProjectUser');
            $this->ProjectUser->recursive = -1;
            $this->ProjectUser->updateAll(array('ProjectUser.dt_visited' => "'" . GMT_DATETIME . "'"), array('ProjectUser.project_id' => $prjid, 'ProjectUser.user_id' => $_SESSION['Auth']['User']['id']));
            $timelog_filter_msg = "";
        } else {
            if (trim($data['usrid']) != '' || trim($data['strddt']) != '' || trim($data['enddt']) != '' || (trim($data['filter']) != '' && trim($data['filter']) != 'alldates')) {
                $timelog_filter_msg = "Showing data ";
            }
        }

        /* page limit set */
        $page_limit = CASE_PAGE_LIMIT;
        if (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] == 'milestone') {
            //$page_limit = TASK_GROUP_CASE_PAGE_LIMIT;
        }
        /* current page */
        $casePage = $this->params->data['casePage'] > 0 ? $this->params->data['casePage'] : 1; // Pagination
        $page = $casePage;
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;

        #######################Order By##################################
        // Order by
        $sortby = '';
        if (isset($_COOKIE['TASKSORTBY'])) {
            $sortby = $_COOKIE['TASKSORTBY'];
            $sortorder = $_COOKIE['TASKSORTORDER'];
        } else {
            $sortorder = 'DESC';
        }

        if ($sortby == 'date') {
            $orderby = "LogTime.start_datetime " . $sortorder;
        } elseif ($sortby == 'name') {
            $orderby = "user_name " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $orderby = "Easycase.case_no " . $sortorder;
        } elseif ($sortby == 'case_title') {
            $orderby = "task_name " . $sortorder;
        } elseif ($sortby == 'description') {
            $orderby = "description " . $sortorder;
        } elseif ($sortby == 'start') {
            $orderby = "start_datetime " . $sortorder;
        } elseif ($sortby == 'end') {
            $orderby = "end_datetime " . $sortorder;
        } elseif ($sortby == 'hours') {
            $orderby = "total_hours " . $sortorder;
        } else {
            $orderby = " LogTime.start_datetime DESC ";
        }
        #pr ($orderby);exit;
        #################End of Order by#################################

        /* project details */
        if ($projFil == 'all') {
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('all', array('conditions' => array('Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
            $project_id = $projArr['Project']['id'];
        } else {
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $projFil, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
            $project_id = $projArr['Project']['id'];
        }

        $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        #$curDateTime = date('Y-m-d H:i:s');
        $temp_show_dates = null;
        if (isset($data['filter']) && $data['filter']) {
            $filter = trim($data['filter']);   //echo $filter;exit;
            //	pr($dates);exit;
            if ((isset($data['strddt']) && !empty($data['strddt'])) || (isset($data['enddt']) && !empty($data['enddt']))) {
                $date['strddt'] = $data['strddt'];
                $date['enddt'] = $data['enddt'];
                if (isset($data['strddt']) && !empty($data['strddt'])) {
                    $dates['strddt'] = date('Y-m-d', strtotime($data['strddt']));
                    $date['strddt'] = $dates['strddt'];
                    $temp_show_dates = $date;
                    $dates['strddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dates['strddt'], "datetime");
                }
                if (isset($data['enddt']) && !empty($data['enddt'])) {
                    //$temp_show_dates = $data;
                    $dates['enddt'] = date('Y-m-d', strtotime($data['enddt']));
                    $date['enddt'] = $dates['enddt'];
                    $temp_show_dates = $date;
                    $dates['enddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dates['enddt'], "datetime");
                    $dates['enddt'] = date('Y-m-d H:i:s', strtotime($dates['enddt'] . '+1 days'));
                }
            } else {
                $dates = $this->Format->date_filter($filter, $curDateTime); //pr($dates);exit;
                $temp_show_dates = $dates;
                $dates['strddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dates['strddt'], "datetime");
                $dates['enddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dates['enddt'], "datetime");
                $dates['enddt'] = date('Y-m-d H:i:s', strtotime($dates['enddt'] . '+1 day'));
            }

            $data = array_merge($data, $dates); //pr($data);exit;
            if ($filter == 'alldates') {
                unset($data['strddt']);
                unset($data['enddt']);
                if (!isset($data['usrid'])) {
                    $timelog_filter_msg = "";
                }
            }
        }
        #pr($data);exit;
        if (isset($data['filter']) && ($filter == 'today' || $filter == 'yesterday') && isset($data['strddt'])) {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $data['strddt'] . "' AND `LogTime`.`start_datetime` < '" . date('Y-m-d H:i:s', strtotime($data['strddt'] . '+1 day')) . "'";
            $st_dt = " AND `start_datetime` >= '" . $data['strddt'] . "' AND `start_datetime` < '" . date('Y-m-d H:i:s', strtotime($data['strddt'] . '+1 day')) . "'";
            $timelog_filter_msg .= " for <b>" . date('M d, Y', strtotime($temp_show_dates['strddt'])) . "</b> ";
        } elseif (isset($data['strddt']) && isset($data['enddt'])) {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $data['strddt'] . "' AND `LogTime`.`start_datetime` < '" . $data['enddt'] . "'";
            $st_dt = " AND start_datetime >= '" . $data['strddt'] . "' AND start_datetime < '" . $data['enddt'] . "'";
            $timelog_filter_msg .= "from <b>" . date('M d, Y', strtotime($temp_show_dates['strddt'])) . "</b>&nbsp;&nbsp;to <b>" . date('M d, Y', strtotime($temp_show_dates['enddt'])) . "</b> ";
        } elseif (isset($data['strddt'])) {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $data['strddt'] . "'";
            $st_dt = " AND start_datetime >= '" . $data['strddt'] . "'";
            $timelog_filter_msg .= "from <b>" . date('M d, Y', strtotime($temp_show_dates['strddt'])) . "</b> ";
        } elseif (isset($data['enddt'])) {
            $where .= " AND `LogTime`.`start_datetime` < '" . $data['enddt'] . "'";
            $st_dt = " AND start_datetime <= '" . $data['enddt'] . "'";
            $timelog_filter_msg .= "till <b>" . date('M d, Y', strtotime($temp_show_dates['enddt'])) . "</b> ";
        }
        $count_usid = '';
        if (isset($data['usrid']) && !empty($data['usrid'])) {
            $usrid = explode("-", $data['usrid']);
            foreach ($usrid as $uid) {
                if ($uid != '') {
                    $qrylog.=" `LogTime`.`user_id`=" . $uid . " OR ";
                    $qryusr.= " `LogTime`.`user_id` = '" . $uid . "' OR ";
                }
            }
            $qrylog = substr($qrylog, 0, -3);
            $qry.=" AND (" . $qrylog . ")";
            $qryusr = substr($qryusr, 0, -3);
            $usr.=" AND (" . $qryusr . ")";
            $where .= $qry;
            $usid = $usr;
            $count_usid = $qry;
            $this->loadModel('User');
            $userdetails = $this->User->find("all", array('conditions' => array('id' => $usrid), "fields" => "CONCAT_WS(' ',User.name,User.last_name) AS user_name"));
            if (count($userdetails) == 1) {
                $timelog_filter_msg .= "&nbsp;of <b>" . $userdetails[0][0]['user_name'] . "</b>";
            } else {
                $timelog_filter_msg .= " of ";
                foreach ($userdetails as $key => $user) {
                    $timelog_filter_msg .= "<b>" . $user[0]['user_name'] . "</b> And ";
                }
                $timelog_filter_msg = substr($timelog_filter_msg, 0, -4);
            }
        }

        #echo $project_id;exit;
        $curCaseId = "0";
        $caseTitleRep = '';
        $isactive = '';
        $extra_condition = ""; #, "LogTime.task_id" => "'" . $curCaseId . "'"
        $usrCndtn = "";
        $tskCndtn = "";
        if ((SES_TYPE == 3 && SES_ID != 13902) && !$this->Format->isAllowed('View All Timelog', $roleAccess)) {
            $usrCndtn = " AND `LogTime`.user_id= " . SES_ID . " ";
        }
        if (isset($this->data['task_id']) && $this->data['task_id'] != '') {
            $tskCndtn = " AND `LogTime`.task_id= " . $this->data['task_id'] . " ";
            $curCaseId = $this->data['task_id'];
            $taskUid = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $curCaseId), 'fields' => array('Easycase.uniq_id', 'Easycase.title', 'Easycase.isactive', 'Easycase.legend')));
            $caseTitleRep = $taskUid['Easycase']['title'];
            $isactive = $taskUid['Easycase']['isactive'];
            $prjDtls = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $projFil), 'fields' => array('Project.name')));
        }
        if ($projFil == 'all') {
            //target_40
            
            /*Code Commented by Tapan Sir(30.12.2020)


         $logsql = "SELECT SQL_CALC_FOUND_ROWS LogTime.*, "
                   . " DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1,"
                   . "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name, "
                   . "CONCAT_WS('||',title,uniq_id,case_no) as task_name,Project.name AS project_name,Project.uniq_id "
                   . "FROM `log_times` AS `LogTime` "
                   . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                   . "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 WHERE Project.isactive=1 AND Project.company_id=" . SES_COMP . " AND Easycase.isactive=1 " . $usrCndtn . " " . $tskCndtn . " $where "
                   . "ORDER BY $orderby LIMIT $limit1, $limit2";


            */
            $logsql = "SELECT SQL_CALC_FOUND_ROWS LogTime.*, "
                    . " DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1,"
                    . "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name, "
                    . "(SELECT CONCAT_WS('||',title,uniq_id,case_no) FROM easycases AS `Easycase` WHERE `Easycase`.id=LogTime.task_id LIMIT 1) AS task_name, "
                    . "(SELECT Project.name FROM projects AS Project WHERE Project.id = LogTime.project_id) AS project_name,Project.uniq_id "
                    . "FROM `log_times` AS `LogTime` "
                    . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                    . "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 WHERE Project.isactive=1 AND Project.company_id=" . SES_COMP . " AND Easycase.isactive=1 " . $usrCndtn . " " . $tskCndtn . " $where "
                    . "ORDER BY $orderby LIMIT $limit1, $limit2";
        } else {
            /*Code Commented by Tapan Sir(30.12.2020)
            //target_39
            $logsql = "SELECT SQL_CALC_FOUND_ROWS LogTime.*, "
                   . " DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1,"
                   . "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name, "
                   . "(SELECT CONCAT_WS('||',title,uniq_id,case_no) FROM easycases AS `Easycase` WHERE `Easycase`.id=LogTime.task_id LIMIT 1) AS task_name "
                   #. ",(SELECT `Type`.`name` FROM `types` AS `Type` WHERE `Type`.id=(SELECT type_id FROM easycases AS `Easycase` WHERE `Easycase`.id=LogTime.task_id LIMIT 1) LIMIT 1) AS type_name "
                   . "FROM `log_times` AS `LogTime` "
                   . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                   . "WHERE `LogTime`.`project_id`='$project_id' AND Easycase.isactive=1 " . $usrCndtn . " " . $tskCndtn . "  $where "
                   . "ORDER BY $orderby LIMIT $limit1, $limit2";
               */
                
            $logsql = "SELECT SQL_CALC_FOUND_ROWS LogTime.*, "
                    . " DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1,"
                    . "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name, "
                    . "CONCAT_WS('||',title,uniq_id,case_no) AS task_name "
                    #. ",(SELECT `Type`.`name` FROM `types` AS `Type` WHERE `Type`.id=(SELECT type_id FROM easycases AS `Easycase` WHERE `Easycase`.id=LogTime.task_id LIMIT 1) LIMIT 1) AS type_name "
                    . "FROM `log_times` AS `LogTime` "
                    . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                    . "WHERE `LogTime`.`project_id`='$project_id' AND Easycase.isactive=1 " . $usrCndtn . " " . $tskCndtn . "  $where "
                    . "ORDER BY $orderby LIMIT $limit1, $limit2";
        }

        $logtimes = $this->LogTime->query($logsql);
        #pr($logtimes);exit;
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {#May 05 2015 11:05:00
                $logtimes[$key]["LogTime"]['start_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['start_datetime'], "datetime");
                $logtimes[$key]["LogTime"]['end_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['end_datetime'], "datetime");
                $logtimes[$key][0]['start_datetime_v1'] = date('M d Y H:i:s', strtotime($logtimes[$key]["LogTime"]['start_datetime']));
                $logtimes[$key][0]['task_name'] = $frmt->formatTitle($logtimes[$key][0]['task_name']);
                //$logtimes[$key]["LogTime"]['description'] = $frmt->formatTitle($logtimes[$key]["LogTime"]['description']);
                //$logtimes[$key]["LogTime"]['description'] = h($logtimes[$key]["LogTime"]['description']);
                $logtimes[$key]["LogTime"]['description'] = preg_replace('/<script.*>.*<\/script>/ims', '', $logtimes[$key]["LogTime"]['description']);
                $logtimes[$key]["LogTime"]['description'] = $frmt->formatCms($logtimes[$key]["LogTime"]['description']);
                if (!isset($logtimes[$key]["Project"]['uniq_id'])) {
                    $logtimes[$key]["Project"]['uniq_id'] = '';
                }
                $logtimes[$key]['LogTime']['start_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['start_datetime']));
                $logtimes[$key]['LogTime']['end_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['end_datetime']));
                $logtimes[$key]['LogTime']['is_from_timer'] = $logtimes[$key]['LogTime']['is_from_timer'];
                if ($logtimes[$key]['LogTime']['timesheet_flag'] ==1) {
                    $logtimes[$key]['LogTime']['start_time'] = '--';
                    $logtimes[$key]['LogTime']['end_time'] = '--';
                }
            }
        }
        //pr($logtimes);exit;
        $tot = $this->LogTime->query("SELECT FOUND_ROWS() as total");
        $caseCount = $tot[0][0]['total'];
        #pr($logtimes);exit;

        /* find total billable and non-billable time */
        $usrCndn = "";
        $tskcndn = "";
        if ((SES_TYPE == 3 && SES_ID != 13902) && !$this->Format->isAllowed('View All Timelog', $roleAccess)) { //id for mr class user
            $usrCndn = " AND `LogTime`.user_id= " . SES_ID;
        }
        if (isset($this->data['task_id']) && $this->data['task_id'] != '') {
            $tskcndn = " AND `LogTime`.task_id= " . $this->data['task_id'];
        }
        if ($projFil == 'all') {
            $count_sql = 'SELECT sum(total_hours) as secds,is_billable '
                    . 'FROM log_times AS `LogTime` '
                    . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                    . "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 AND Project.company_id=" . SES_COMP . " "
                    . 'WHERE Project.isactive=1 AND Project.company_id=' . SES_COMP . ' AND LogTime.is_billable = 1 AND Easycase.isactive =1 ' . $count_usid . $st_dt . ' '
                    . $usrCndn . ' ' . $tskcndn . ' GROUP BY LogTime.is_billable  '
                    . 'UNION '
                    . 'SELECT sum(total_hours) as secds, is_billable '
                    . 'FROM log_times AS LogTime '
                    . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                    . "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 AND Project.company_id=" . SES_COMP . " "
                    . 'WHERE Project.isactive=1 AND Project.company_id=' . SES_COMP . ' AND Project.isactive=1 AND LogTime.is_billable = 0 AND Easycase.isactive =1 ' . $count_usid . $st_dt . ' '
                    . $usrCndn . ' ' . $tskcndn . ' GROUP BY LogTime.is_billable ';
        } else {
            $count_sql = 'SELECT sum(total_hours) as secds,is_billable '
                    . 'FROM log_times AS `LogTime` '
                    . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                    . 'WHERE is_billable = 1 AND Easycase.isactive =1 AND LogTime.project_id = "' . $project_id . '" ' . $count_usid . $st_dt . ' '
                    . $usrCndn . ' ' . $tskcndn . ' GROUP BY LogTime.project_id  '
                    . 'UNION '
                    . 'SELECT sum(total_hours) as secds, is_billable '
                    . 'FROM log_times AS LogTime '
                    . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                    . 'WHERE is_billable = 0 AND Easycase.isactive =1 AND LogTime.project_id ="' . $project_id . '" ' . $count_usid . $st_dt . ' '
                    . $usrCndn . ' ' . $tskcndn . ' GROUP BY LogTime.project_id ';
        }
        $cntlog = $this->LogTime->query($count_sql);

        #pr($cntlog);exit;
        /* $billablehours = $cntlog[0][0]['is_billable'] > 0 ? $cntlog[0][0]['secds'] : 0;
          $thoursbillable = ($billablehours);
          $thours = ($cntlog[0][0]['secds'] + $cntlog[1][0]['secds']);
          $thrs = ($thours);
          $nonbillablehrs = $thrs - $thoursbillable; */

        $billablehours = 0;
        $thours = 0;
        $nonbillablehrs = 0;

        if ($cntlog) {
            foreach ($cntlog as $tk => $tv) {
                $thours += $tv[0]['secds'];
                if ($tv[0]['is_billable']) {
                    $billablehours += $tv[0]['secds'];
                }
            }
        }
        $thoursbillable = $billablehours;
        $thrs = ($thours);
        $nonbillablehrs = $thrs - $thoursbillable;



        $tasks = (trim($usid) != '' || trim($st_dt) != '') ? ' AND Easycase.id IN (SELECT LogTime.task_id FROM log_times AS LogTime WHERE LogTime.project_id ="' . $project_id . '" ' . $usid . $st_dt . ')' : '';
        $est_sql = "SELECT SUM(Easycase.estimated_hours) AS hrs FROM easycases AS Easycase WHERE Easycase.isactive=1 AND Easycase.project_id = '" . $project_id . "' AND Easycase.istype=1 " . $tasks;
        if (isset($this->data['task_id']) && $this->data['task_id'] != '') {
            $est_sql = "SELECT SUM(Easycase.estimated_hours) AS hrs FROM easycases AS Easycase WHERE Easycase.isactive=1 AND Easycase.project_id = '" . $project_id . "' AND Easycase.istype=1 AND Easycase.id = '" . $this->data['task_id'] . "'";
        }
        if ($projFil == 'all') {
            $tasks = (trim($usid) != '' || trim($st_dt) != '') ? ' AND Easycase.id IN (SELECT LogTime.task_id FROM log_times AS LogTime WHERE LogTime.project_id !="" ' . $usid . $st_dt . ')' : '';
            $est_sql = "SELECT SUM(Easycase.estimated_hours) AS hrs FROM easycases AS Easycase LEFT JOIN projects AS Project on Easycase.project_id=Project.id WHERE Project.company_id=" . SES_COMP . " AND Project.isactive=1 AND Easycase.isactive=1 AND Easycase.istype=1 " . $tasks;
        }
        $usrCndn_est = '';
        if ((SES_TYPE == 3 && SES_ID != 13902)  && !$this->Format->isAllowed('View All Timelog', $roleAccess)) { //id for mr class user
            $usrCndn_est = " AND (`Easycase`.user_id= " . SES_ID." OR `Easycase`.assign_to= " . SES_ID.") ";
        }
        $est_sql .= $usrCndn_est;
        $cntestmhrs = $this->Easycase->query($est_sql);
        $caseTitleRep = '';
        $pgShLbl = $frmt->pagingShowRecords($caseCount, $page_limit, $casePage);
        $page_typ = 'timelog';
        $showTitle = 'Yes';
        if (isset($this->data['task_id']) && $this->data['task_id'] != '') {
            $page_typ = "taskdetails";
            $showTitle = 'No';
        }
        $logtimesArr = array('logs' => $logtimes,
            'task_id' => $curCaseId,
            'task_title' => $caseTitleRep,
            'task_uniqId' => $taskUid['Easycase']['uniq_id'],
            'project_uniqId' => $projFil,
            'is_active' => $isactive,
            'project_name' => $prjDtls['Project']['name'],
            'pgShLbl' => $pgShLbl,
            'csPage' => $casePage,
            'csLgndRep' => $taskUid['Easycase']['legend'],
            'page_limit' => $page_limit,
            'caseCount' => $caseCount,
            'showTitle' => $showTitle,
            'page' => $page_typ,
            'details' => array(
                'totalHrs' => $thrs,
                'billableHrs' => $thoursbillable,
                'nonbillableHrs' => $nonbillablehrs,
                'estimatedHrs' => isset($this->data['task_id']) && $this->data['task_id'] != '' ? trim($cntestmhrs[0][0]['hrs']) : trim($cntestmhrs[0][0]['hrs']),
        ));

        $projUser = array();
        if ($projFil) {
            $projUser = array($projFil => $this->Easycase->getMemebers($projFil, 0, 0, 1));
        }
        $caseDetail['projUser'] = $projUser;

        #pr($logtimesArr);exit;
        $caseDetail['logtimes'] = $logtimesArr;
        $caseDetail['timelog_filter_msg'] = $timelog_filter_msg;
        $caseDetail['orderBy'] = $_COOKIE['TASKSORTBY'];
        $caseDetail['orderByType'] = $_COOKIE['TASKSORTORDER'];
        echo json_encode($caseDetail);
        exit;
        /* $this->set('caseDetail', json_encode($caseDetail));
          echo $this->render('/Elements/case_timelog');
          exit; */
    }

    
    public function ajaxemail($oauth_arg = null)
    {
        $oauth_return = 0;
        $this->loadModel("ProjectUser");
        if (isset($this->data['type'])) {
            $json_data = $this->data['json_data'];
            $data = json_decode($json_data, true);

            $data['emailbody'] = $_SESSION['email']['email_body'];
            $data['msg'] = $_SESSION['email']['msg'];
            unset($_SESSION['email']);

            if (strstr($data['caseid_list'], ',') || trim($data['caseid_list'], ',')) {
                $commonArrId = explode(',', $data['caseid_list']);
                $CaseUserEmail = ClassRegistry::init('CaseUserEmail');
                foreach ($commonArrId as $commonCaseId) {
                    if (trim($commonCaseId)) {
                        $this->loadModel("Easycase");
                        $caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to', 'Easycase.client_status')));
                        $caseStsId = $caseDataArr['Easycase']['id'];
                        $data['caseNo'] = $caseDataArr['Easycase']['case_no'];
                        $data['projId'] = $caseDataArr['Easycase']['project_id'];
                        $data['caseTypeId'] = $caseDataArr['Easycase']['type_id'];
                        $data['casePriority'] = $caseDataArr['Easycase']['priority'];
                        $data['emailTitle'] = $caseDataArr['Easycase']['title'];

                        $data['caseUniqId'] = $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                        $data['caUid'] = $caseDataArr['Easycase']['assign_to'];
                        $data['is_client'] = $caseDataArr['Easycase']['client_status'];

                        //Added by Sunil
                        $emailUsers = $CaseUserEmail->getEmailUsers($commonCaseId);
                        $getEmailUser = $this->getAllExistingNotifyUser($data['projId'], $emailUsers);
                        $this->Postcase->mailToUser($data, $getEmailUser);
                        //End
                    }
                }
            }
        } else {
            if (isset($oauth_arg) && !empty($oauth_arg)) {
                $data = $oauth_arg;
                $oauth_return = 1;
            } else {
                $data = $this->data;
            }

            if ($data['caseIstype'] == 1) {
                //$getEmailUser = $this->ProjectUser->getAllNotifyUser($data['projId'],$data['emailUser'], 'new');
                $getEmailUser = $this->getAllExistingNotifyUser($data['projId'], $data['emailUser'], 'new');
            } else {
                //$getEmailUser = $this->ProjectUser->getAllNotifyUser($data['projId'], $data['emailUser'], 'reply');
                $getEmailUser = $this->getAllExistingNotifyUser($data['projId'], $data['emailUser'], 'reply');
            }

            if ($getEmailUser) {
                $this->Postcase->mailToUser($data, $getEmailUser);
            }

            if (intval($oauth_return)) {
                $ret = array('success' => "success");
                return json_encode($ret);
            }
        }
        echo 1;
        exit;
    }

    public function getAllExistingNotifyUser($project_id = null, $emailUser = array(), $type = 'case_status')
    {
        $this->loadModel("ProjectUser");
        if (isset($project_id) && isset($type)) {
            $this->ProjectUser->recursive = -1;
            $fld = $type;
            $temp_var = '';
            if ($type == 'new' || $type == 'reply') {
                $fld = $type . "_case";
            }
            if ($type == 'new') {
                $temp_var = ', UserNotification.case_status';
            }
            $users = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email,CompanyUser.is_client, UserNotification.{$fld}" . $temp_var . "  FROM users AS User, project_users AS ProjectUser, user_notifications AS UserNotification, company_users as CompanyUser WHERE User.id=ProjectUser.user_id AND User.id=UserNotification.user_id AND User.id=CompanyUser.user_id AND User.isactive='1' AND CompanyUser.is_active='1' AND CompanyUser.company_id=" . SES_COMP . " AND ProjectUser.project_id='" . $project_id . "' AND ProjectUser.company_id = '" . SES_COMP . "' AND ProjectUser.default_email='1'");
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

    public function getAllTasks()
    {
        $this->layout = 'ajax';
        $arr=array();
        $prjUniqIdCsMenu = $this->request->data['projUniq'];
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $searchcase = "";
        $this->Project->recursive = -1;
        if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
            if (count($projArr)) {
                $proj_id = $projArr['Project']['id'];
            }
            $openedTasksArrOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS openedcnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND Easycase.project_id=' . $proj_id . ' AND Easycase.legend in(1,2,5,4) AND Easycase.type_id !=10 ' . ' ' . $searchcase);
        // $openedTasksArrOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS openedcnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND Easycase.project_id=' . $proj_id . ' AND (Easycase.legend=1 OR Easycase.legend=2 OR Easycase.legend=5 OR Easycase.legend=4) AND Easycase.type_id !=10 ' . ' ' . $searchcase);
        } else {
            $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('DISTINCT Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));

            $this->loadModel('ProjectUser');
            $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
            $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
            $allProjArr = $this->ProjectUser->find('all', $cond);

            $ids = array();
            $idlist = '';
            foreach ($allProjArr as $csid) {
                $idlist .='\'' . $csid['Project']['id'] . '\',';
                array_push($ids, $csid['Project']['id']);
            }

            $idlist = trim($idlist, ',');
            $n_pid_cond = 1;
            if ($idlist != '') {
                $n_pid_cond = 'Easycase.project_id IN(' . $idlist . ')';
            }
            $openedTasksArrOrg = $this->Easycase->query('SELECT COUNT(DISTINCT Easycase.id) AS openedcnt FROM easycases AS Easycase WHERE Easycase.isactive=1 AND ' . $clt_sql . ' AND Easycase.istype=1 AND ' . $n_pid_cond . ' AND (Easycase.legend=1 OR Easycase.legend=2 OR Easycase.legend=5 OR Easycase.legend=4) AND Easycase.type_id !=10  ' . $searchcase);
        }
        $arr['total_case']=$openedTasksArrOrg[0][0]['openedcnt'];
        print json_encode($arr);
        exit;
    }

    public function updateLeftMenuSize()
    {
        $data = $this->data;
        $this->Session->write('leftMenuSize', $data['menuMode']);
        exit;
    }
    public function getRecurringTasks()
    {
        $data=$this->data;
        $this->loadModel("Easycase");
        $case=array();
        $this->Easycase->bindModel(array('hasMany' => array('RecurringEasycase')));
        $mainCase=$this->Easycase->find('first', array('conditions'=>array('Easycase.id'=>$data['id']),'fields'=>array('Easycase.id,Easycase.title,Easycase.is_recurring')));
        $case= $mainCase;
        $allRCase= array();
        if (count($mainCase) > 0) {
            if ($mainCase['Easycase']['is_recurring'] ==2) {
                $mainCasetitle = explode(" - ", $mainCase['Easycase']['title']);
                if (count($mainCasetitle) > 1) {
                    unset($mainCasetitle[count($mainCasetitle)-1]);
                }
                $mainCase['Easycase']['title'] = implode(" - ", $mainCasetitle);
                $this->Easycase->bindModel(array('hasMany' => array('RecurringEasycase')));
                $allRCase= $this->Easycase->find('first', array('conditions'=>array('Easycase.title LIKE'=>"%".addslashes($mainCase['Easycase']['title'])."%",'Easycase.is_recurring'=>1),'fields'=>array('Easycase.id,Easycase.title,Easycase.is_recurring')));
                $case= $allRCase;
            }
        }
        $date = date('Y-m-d');
        $dateInRecurring= array();
        if (count($case['RecurringEasycase']) > 0) {
            $dateInRecurring = $this->Format->getRecurring($case['RecurringEasycase'][0], $date);
        }
        print_r(json_encode(array($case,$dateInRecurring)));
        exit;
    }
    public function stopRecurringTasks()
    {
        $data= $this->data;
        $this->loadModel("RecurringEasycase");
        if (isset($this->data['id']) && !empty($this->data['id'])) {
            $this->RecurringEasycase->id=$this->data['id'];
            if ($this->RecurringEasycase->delete()) {
                $this->loadModel("Easycase");
                $this->Easycase->id=$this->data['eid'];
                $this->Easycase->saveField("is_recurring", "0");
                print json_encode(array('status'=>1));
            } else {
                print json_encode(array('status'=>0));
            }
        } else {
            print json_encode(array('status'=>0));
        }
        exit;
    }
    public function checkIfParentTask()
    {
        $project_id = $this->data['project_id'];
        $caseIds = $this->data['EasycaseIds'];
      
        #pr($this->data);exit;
        $casedata = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $caseId, 'Easycase.project_id' => $project_id)));
        $parent_task_id = $casedata['Easycase']['parent_task_id'];
        if (!empty($parent_task_id)) {
            //fetch parent tasks to check if has any parent task
            $parentTasks = $this->Easycase->getSubTasks($parent_task_id);
            if (!empty($parentTasks['task'])) {
                //$final_arr = array('status' => 'confirm', 'message' => 'Are you sure you want to move task to new task group? It will also move its children tasks to new task group.');
                $final_arr = array('is_parent' => false, 'message' => 'Moving task to new task group is restricted for children tasks.');
            }
        } else {
            $final_arr = array('is_parent' => true);
        }
        echo json_encode($final_arr);
        exit;
    }
    public function resetCaseDropdown()
    {
        $resp = array();
        $this->layout = 'ajax';
        $pjuniqid= $this->request->data['project_id'];
        $projUser = array($pjuniqid => $this->Easycase->getMemebers($pjuniqid));
        $resp['project_users'] = $projUser;
        $prj = $this->Project->findByUniqId($pjuniqid);
        $defaultAssign = $prj['Project']['default_assign'];
        $resp['defaultAssign'] = $defaultAssign;
        /** Get the project Milestones **/
        $pid = ClassRegistry::init('Project')->find('first', array('conditions' => array('uniq_id' => $pjuniqid)));
        $mlst_list = ClassRegistry::init('Milestone')->find('list', array('conditions' => array('project_id' => $pid['Project']['id']), 'order' => 'end_date DESC'));
        $resp['project_milestones'] = $mlst_list;
        echo json_encode($resp);
        exit;
    }
    public function getParentTasks()
    {
        $this->layout = 'ajax';
        $arr = array('status'=>0);
        $project_uniqid = $this->request->data['project_id'];
        $task_id = isset($this->request->data['task_id']) ? $this->request->data['task_id']:'';
        $this->loadModel('Project');
        $this->loadModel('Easycase');
        $projects =  $this->Project->find('first', array('conditions'=>array('Project.uniq_id'=>$project_uniqid),'fields'=>array('Project.id')));
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $cond_easycase_actuve = "AND Easycase.isactive=1";
        $searchcase = "";
        $qry = "" ;
        $orderby = "Easycase.dt_created DESC";
    
        $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.id,Easycase.title,Easycase.case_no FROM ( "
            . "SELECT * FROM easycases as Easycase WHERE istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='".$projects['Project']['id']."' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " ";
        $tasks = $this->Easycase->query($req_sql);
   
        if (count($tasks)) {
            $arr['tasks'] =  $tasks;
            $arr['status'] =  1;
        }
        if ($task_id) {
            $this->loadModel('EasycaseLinking');
            $prefill = $this->EasycaseLinking->find('all', array('conditions'=>array('easycase_id'=>$task_id),'fields'=>array('link_id','id')));
            if (count($prefill)) {
                $pref = array();
                foreach ($prefill as $k=>$v) {
                    $pref[] = $v['EasycaseLinking']['link_id'];
                }
                $arr['prefill'] =  $pref;
            }
        }
        echo json_encode($arr);
        exit;
    }
    public function saveParentTask()
    {
        $this->layout = 'ajax';
        $arr = null;
        $d = new DateTime();
        $view = new View($this);
        $da = $d->format('Y-m-d H:i:s');
        $dt = $view->loadHelper('Datetime');
        $tz = $view->loadHelper('Tmzone');
        $curDateTz = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $updTzDate = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $da, "datetime");
        $last_updated = $dt->dateFormatOutputdateTime_day($updTzDate, $curDateTz);
        if (!empty($this->data)) {
            $est_hr = $this->data['est_hour'];
            ;
        
            $defaultAssignto = $this->data['assign_to'];
            $easyCaseExist = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $this->data['CS_parent_id'],'Easycase.istype' => 1,'Easycase.isactive' => 1), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.isactive', 'Easycase.istype','Easycase.uniq_id', 'Easycase.legend','Easycase.custom_status_id')));
            if ($easyCaseExist) {
                $prj = $this->Project->findById($easyCaseExist['Easycase']['project_id']);
                $task_type = isset($this->data['task_types'])&& !empty($this->data['task_types']) ? $this->data['task_types']: '';//!empty($prj['Project']['task_type']) ? $prj['Project']['task_type']."test2" : '';
                //$task_type = !empty($prj['Project']['task_type']) ? $prj['Project']['task_type'] : '';
                $custom_status = 0;
                $custom_legend = 1;
                /*if($prj['Project']['status_group_id']){
                    $CustomStatus = ClassRegistry::init('CustomStatus');
                    $sts_cond = array('CustomStatus.status_group_id'=>$prj['Project']['status_group_id']);
                    $CustomStatusArr =  $CustomStatus->find('first',array('conditions'=>$sts_cond,'order'=>array('CustomStatus.seq'=>'ASC')));
                    $custom_status = $CustomStatusArr['CustomStatus']['id'];
                    $custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
                }*/
                if (empty($task_type)) {
                    $this->loadModel("TypeCompany");
                    $task_type = $this->TypeCompany->getSelType(SES_COMP);
                } else {
                    $task_type = $task_type;//$this->TypeCompany->getCheckedTaskType($task_type, SES_COMP);
                }
                /*if ($prj) {
                    $defaultAssignto = $prj['Project']['default_assign'];
                } */
                /* saving in secs */
                $estHour = trim($est_hr) != '' ? trim($est_hr) : '0';
                $due_date = isset($this->data['due_date'])&& !empty($this->data['due_date']) ? $this->data['due_date']: 'No Due Date';
                $start_date = isset($this->data['start_date'])&& !empty($this->data['start_date']) ? $this->data['start_date']: 'No Start Date';
                if (empty($this->data['project_id'])) {
                    $arr['error'] = 1;
                    $arr['msg'] = __('Invalid input. Please try again.', true);
                    echo json_encode($arr);
                    exit;
                }
                $new_task = null;
                $new_task['CS_project_id'] = $this->data['projUID'];
                $new_task['CS_istype'] = 1;
                $new_task['CS_title'] = trim($this->data['title']);
                $new_task['CS_type_id'] = (!empty($task_type)) ? $task_type : 8; //update
                $new_task['CS_priority'] = 2;
                $new_task['CS_message'] = '';
                $new_task['CS_assign_to'] = $defaultAssignto;
                $new_task['CS_user_id'] = SES_ID;
                $new_task['CS_due_date'] = $due_date;
                $new_task['CS_start_date'] = $start_date;
                $new_task['CS_id'] = 0;
                $new_task['datatype'] = 0;
                $new_task['CS_legend'] = $custom_legend;
                //$new_task['custom_status_id'] = $custom_status;
                $new_task['prelegend'] = '';
                $new_task['hours'] = 0;
                $new_task['estimated_hours'] = $estHour;
                $new_task['completed'] = 0;
                $new_task['taskid'] = 0;
                $new_task['task_uid'] = 0;
                $new_task['editRemovedFile'] = '';
                $new_task['is_client'] = 0;
                $new_task['CS_parent_id'] = $this->data['CS_parent_id'];
                $mil_id = $this->EasycaseMilestone->getCurrentMilestone($this->data['CS_parent_id']);
                $new_task['CS_milestone'] = ($mil_id)?$mil_id:'';
                $value = $this->Postcase->casePosting($new_task);
                $value = json_decode($value, true);
                if ($value['success'] == 'success') {
                    $sub_cnd = array('parent_task_id' => $this->data['CS_parent_id'], 'project_id' => $easyCaseExist['Easycase']['project_id']);
                    if ($this->Auth->user('is_client') == 1) {
                        $sub_cnd = array('parent_task_id' => $this->data['CS_parent_id'], 'project_id' => $easyCaseExist['Easycase']['project_id'],'client_status !=' => 1);
                    }
                    $subtasks = $this->Easycase->find('all', array(
                    'fields' => array("Easycase.*", "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned,User.name AS FullName", "Project.uniq_id"),
                    'conditions' => $sub_cnd,
                    'joins' => array(
                        array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('Easycase.assign_to = User.id')),
                        array('table' => 'projects', 'alias' => 'Project', 'type' => 'LEFT', 'conditions' => array('Project.id = Easycase.project_id')),
                    ),
                    'order' => 'Easycase.due_date DESC'
                ));
                    $view = new View($this);
                    $frmt = $view->loadHelper('Format');
                    $allCSByProj = $this->Format->getStatusByProject($easyCaseExist['Easycase']['project_id']);
                    $customStatusByProject = array();
                    if (isset($allCSByProj)) {
                        foreach ($allCSByProj as $k=>$v) {
                            if (isset($v['StatusGroup']['CustomStatus'])) {
                                $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                            }
                        }
                    }
                    $arr['customStatusByProject'] = $customStatusByProject;
                    $Csts = ClassRegistry::init('CustomStatus');
                    //ref for other pages
                    if ($easyCaseExist['Easycase']['custom_status_id']) {
                        $sts_ids = array_unique(Hash::extract($subtasks, '{n}.Easycase.custom_status_id'));
                        $csts_arr = $Csts->find('all', array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
                        if ($csts_arr) {
                            $csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
                        }
                    }
                    if (!empty($subtasks)) {
                        foreach ($subtasks as $key => $val) {
                            if ($val['Easycase']['custom_status_id']) {
                                $subtasks[$key]['Easycase']['CustomStatus'] = $csts_arr[$val['Easycase']['custom_status_id']];
                            }
                            $empty_dt_arr = array('0000-00-00 00:00:00', '0000-00-00', '1970-01-01 00:00:00', '1970-01-01', '');
                            $subtasks[$key]['Easycase']['gantt_start_date'] = !in_array($val['Easycase']['gantt_start_date'], $empty_dt_arr) ? $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $val['Easycase']['gantt_start_date'], "datetime") : '';
                            $subtasks[$key]['Easycase']['due_date'] = !in_array($val['Easycase']['due_date'], $empty_dt_arr) ? $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $val['Easycase']['due_date'], "datetime") : '';
                            $subtasks[$key]['Easycase']['Assigned'] = $val[0]['Assigned'];
                            $subtasks[$key]['Easycase']['proj_uniq_to'] = $val['Project']['uniq_id'];
                            $subtasks[$key]['Easycase']['title'] = $frmt->formatTitle($val['Easycase']['title']);
                        }
                    }
                }
                $arr['success'] = 1;
                $arr['msg'] = __('Task successfully posted.', true);
                $arr['curCaseId'] = $value['curCaseId'];
                $arr['curCaseNo'] = $value['caseNo'];
                $arr['iotoserver'] = $value['iotoserver'];
                $arr['isAssignedUserFree'] = $value['isAssignedUserFree'];
                $arr['subtasks'] = $subtasks;
                //$arr['caseSrch'] = '';
                $arr['csAtId'] = $this->data['CS_parent_id'];
                $arr['taskCreatedDetails'] = $value;
                $arr['is_inactive_case'] = 0;
                $arr['caseUniqId'] = $this->data['CS_parent_id'];
                $arr['csProjIdRep'] = $this->data['project_id'];
                $arr['projUniqId'] = $this->data['projUID'];
                $arr['csUniqId'] = $this->data['csUID'];
                $arr['csLgndRep'] = $easyCaseExist['Easycase']['legend'];
                //$arr['csLgndRep'] = $easyCaseExist['Easycase']['legend'];
                $arr['is_active'] = $easyCaseExist['Easycase']['isactive'];
                $arr['projName'] = $this->Project->getProjName($this->data['project_id']);
                $arr['csNoRep'] = $this->Easycase->getCaseNo($this->data['csUID']);
                $arr['last_updated'] = $last_updated;
                $arr['task_milestone_id'] = $this->Easycase->getMilestoneIds($easyCaseExist['Easycase']['id'], $easyCaseExist['Easycase']['project_id']);
                echo json_encode($arr);
                exit;
            } else {
                $arr['error'] = 1;
                $arr['msg'] = __('Sorry! invalid input. Please try again.', true);
                echo json_encode($arr);
                exit;
            }
        } else {
            $arr['error'] = 1;
            $arr['msg'] = __('Sorry! invalid input. Please try again.', true);
            echo json_encode($arr);
            exit;
        }
    }
    public function getNewLinkTasks()
    {
        $this->layout = 'ajax';
        $arr = array('status'=>0);
        $project_uniqid = $this->request->data['project_id'];
        $task_id = isset($this->request->data['task_id']) ? $this->request->data['task_id'] : '';
        $this->loadModel('Project');
        $this->loadModel('Easycase');
        if ($task_id) {
            $this->loadModel('EasycaseLinking');
            $pref = $this->EasycaseLinking->find('list', array('conditions'=>array('easycase_id'=>$task_id),'fields'=>array('id','link_id')));
        }
        
        //print_r($pref); exit;
        $prefList =" ";
        if (!empty($pref)) {
            $prefList = " AND Easycase.id NOT IN('".implode("','", $pref)."')";
        }
        $projects =  $this->Project->find('first', array('conditions'=>array('Project.uniq_id'=>$project_uniqid),'fields'=>array('Project.id')));
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $cond_easycase_actuve = " AND Easycase.isactive=1";
        if (!empty($task_id)) {
            $cond_easycase_actuve .= " AND Easycase.id !=".$task_id;
        }
        $searchcase = "";
        if (!empty($this->request->data['searchTerm'])) {
            //$searchcase =" AND Easycase.title LIKE '%".$this->request->data['searchTerm']."%'";
            if (strpos($this->request->data['searchTerm'], '#') > -1) {
                $newSearchText = str_replace("#", "", $this->request->data['searchTerm']);
                $searchcase =" AND Easycase.case_no = ".$newSearchText;
            } else {
                $searchcase = $this->Format->caseKeywordSearch($this->request->data['searchTerm'], 'case_no_title');
                /*if(stristr($this->request->data['searchTerm'], "'")){
                     $searchcase =' AND (Easycase.title LIKE "%'.$this->request->data['searchTerm'].'%" || Easycase.case_no LIKE "%'.$this->request->data['searchTerm'].'%")';
                }else if(stristr($this->request->data['searchTerm'], '"')){
                    $searchcase =" AND (Easycase.title LIKE '%".$this->request->data['searchTerm']."%' || Easycase.case_no LIKE '%".$this->request->data['searchTerm']."%')";
                }*/
            }
        }
        $qry = "" ;
        $orderby = "Easycase.dt_created DESC";
        $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.id,Easycase.title,Easycase.case_no FROM ( "
            . "SELECT * FROM easycases as Easycase WHERE istype='1' ".$prefList." AND " . $clt_sql . " " . $cond_easycase_actuve . " AND Easycase.project_id='".$projects['Project']['id']."' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id ORDER BY " . $orderby . " LIMIT 0,10";
        $tasks = $this->Easycase->query($req_sql);
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        if (count($tasks)) {
            $arr['status'] =1;
            foreach ($tasks as $k => $v) {
                $title ='#' . $v['Easycase']['case_no'] . ': '.$frmt->formatTitle($v['Easycase']['title']);
                $arr['task'][] =array("id"=>$v['Easycase']['id'], "text"=> $title);
            }
        } else {
            $arr['task']=null;
        }

        echo json_encode($arr);
        exit;
    }
    public function showSubTaskList()
    {
        $arr['success'] = 0;
        if (!empty($this->data['CS_parent_uid'])) {
            $easyCaseExist = $this->Easycase->getEasycaseUsingId($this->data['CS_parent_uid']);
            if ($easyCaseExist) {
                $sub_cnd = array('parent_task_id' => $easyCaseExist['Easycase']['id'], 'project_id' => $easyCaseExist['Easycase']['project_id']);
                if ($this->Auth->user('is_client') == 1) {
                    $sub_cnd = array('parent_task_id' => $easyCaseExist['Easycase']['id'], 'project_id' => $easyCaseExist['Easycase']['project_id'],'client_status !=' => 1);
                }
                $subtasks = $this->Easycase->find('all', array(
                    'fields' => array("Easycase.*", "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned", "Project.uniq_id"),
                    'conditions' => $sub_cnd,
                    'joins' => array(
                        array('table' => 'users', 'alias' => 'User', 'type' => 'LEFT', 'conditions' => array('Easycase.assign_to = User.id')),
                        array('table' => 'projects', 'alias' => 'Project', 'type' => 'LEFT', 'conditions' => array('Project.id = Easycase.project_id')),
                    ),
                    'order' => 'Easycase.due_date DESC'
                ));
                $proj_uid = '';
                $view = new View($this);
                $frmt = $view->loadHelper('Format');
                if (!empty($subtasks)) {
                    $allCSByProj = $this->Format->getStatusByProject($easyCaseExist['Easycase']['project_id']);
                    $customStatusByProject = array();
                    if (isset($allCSByProj)) {
                        foreach ($allCSByProj as $k=>$v) {
                            if (isset($v['StatusGroup']['CustomStatus'])) {
                                $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                            }
                        }
                    }
                    $arr['customStatusByProject'] = $customStatusByProject;
                    $Csts = ClassRegistry::init('CustomStatus');
                    //ref for other pages
                    if ($easyCaseExist['Easycase']['custom_status_id']) {
                        $sts_ids = array_unique(Hash::extract($subtasks, '{n}.Easycase.custom_status_id'));
                        $csts_arr = $Csts->find('all', array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
                        if ($csts_arr) {
                            $csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
                        }
                    }
                    foreach ($subtasks as $key => $val) {
                        if ($val['Easycase']['custom_status_id']) {
                            $subtasks[$key]['Easycase']['CustomStatus'] = $csts_arr[$val['Easycase']['custom_status_id']];
                        }
                        $empty_dt_arr = array('0000-00-00 00:00:00', '0000-00-00', '1970-01-01 00:00:00', '1970-01-01', '');
                        $subtasks[$key]['Easycase']['gantt_start_date'] = !in_array($val['Easycase']['gantt_start_date'], $empty_dt_arr) ? $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $val['Easycase']['gantt_start_date'], "datetime") : '';
                        $subtasks[$key]['Easycase']['due_date'] = !in_array($val['Easycase']['due_date'], $empty_dt_arr) ? $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $val['Easycase']['due_date'], "datetime") : '';
                        $subtasks[$key]['Easycase']['Assigned'] = $val[0]['Assigned'];
                        $subtasks[$key]['Easycase']['proj_uniq_to'] = $val['Project']['uniq_id'];
                        $subtasks[$key]['Easycase']['title'] = $frmt->formatTitle($val['Easycase']['title']);
                        if ($proj_uid == '') {
                            $proj_uid = $val['Project']['uniq_id'];
                        }
                    }
                    $arr['success'] = 1;
                    $arr['subtasks'] = $subtasks;
                    $arr['csAtId'] = $easyCaseExist['Easycase']['id'];
                    $arr['csUniqId'] = $easyCaseExist['Easycase']['uniq_id'];
                    $arr['csProjIdRep'] = $easyCaseExist['Easycase']['project_id'];
                    $arr['projUniqId'] = $proj_uid;
                    $arr['csLgndRep'] = $easyCaseExist['Easycase']['legend'];
                    $arr['is_active'] = $easyCaseExist['Easycase']['isactive'];
                    $arr['projName'] = $this->Project->getProjName($easyCaseExist['Easycase']['project_id']);
                    $arr['csNoRep'] = $easyCaseExist['Easycase']['case_no'];
                } else {
                    $arr['success'] = 1;
                    $arr['subtasks'] = array();
                    $arr['csAtId'] = $easyCaseExist['Easycase']['id'];
                    $arr['csUniqId'] = $easyCaseExist['Easycase']['uniq_id'];
                    $arr['csProjIdRep'] = $easyCaseExist['Easycase']['project_id'];
                    $arr['projUniqId'] = $this->Project->getProjUid($easyCaseExist['Easycase']['project_id']);
                    $arr['csLgndRep'] = $easyCaseExist['Easycase']['legend'];
                    $arr['is_active'] = $easyCaseExist['Easycase']['isactive'];
                    $arr['projName'] = $this->Project->getProjName($easyCaseExist['Easycase']['project_id']);
                    $arr['csNoRep'] = $easyCaseExist['Easycase']['case_no'];
                }
            }
        }
        $arr['is_inactive_case '] = 0;
        echo json_encode($arr);
        exit;
    }
    //Close all child tasks while closing from mass actions.
    public function closerecursiveTaskFrmList($easy_recs, $projdetl)
    {
        if ($easy_recs) {
            foreach ($easy_recs as $tk => $tv) {
                $caseStsId = $tv['Easycase']['id'];
                $caseStsNo = $tv['Easycase']['case_no'];
                $closeStsPid = $tv['Easycase']['project_id'];
                $closeStsTyp = $tv['Easycase']['type_id'];
                $closeStsPri = $tv['Easycase']['priority'];
                $closeStsTitle = $tv['Easycase']['title'];
                $closeStsUniqId = $tv['Easycase']['uniq_id'];
                $caUid = $tv['Easycase']['assign_to'];
                $csLeg = 3;
                $csSts = 2;
                $this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");
                /* Delete previous RA **/
                if ($this->Format->isResourceAvailabilityOn() && $csLeg == 3) {
                    foreach ($casearr as $casek=>$casev) {
                        $this->Format->delete_booked_hours(array('easycase_id' => $caseStsId, 'project_id' =>$closeStsPid));
                    }
                }
                /* End */
                $caseuniqid = $this->Format->generateUniqNumber();
                $this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . SES_ID . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                
                $prjuniqid = $projdetl[0]['projects']['uniq_id']; //print_r($prjuniq);
                $projShName = strtoupper($projdetl[0]['projects']['short_name']);
                $channel_name = $prjuniqid;
                $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'osnewui16.com')) {
                    $resCaseProj['iotoserver']= array('channel' => $channel_name, 'message' => $msgpub);
                }
            }
        }
    }
    public function case_subtask($inactiveFlag = '', $proUid = '', $inCasePage = '', $type = '', $cases = '', $csNum = '', $search_val = '')
    {
        $this->layout = 'ajax';
        $resCaseProj = array();
        if (empty($inactiveFlag)) {
            $page_limit = CASE_PAGE_LIMIT;
        } else {
            $page_limit = INACT_CASE_PAGE_LIMIT;
        }
        if (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] == 'milestone') {
            if (empty($inactiveFlag)) {
                $page_limit = TASK_GROUP_CASE_PAGE_LIMIT;
            } else {
                $page_limit = INACT_TASK_GROUP_CASE_PAGE_LIMIT;
            }
        }
        #pr($this->request->data); exit;

        $this->_datestime();
        if (empty($inactiveFlag)) {
            $projUniq = $this->params->data['projFil']; // Project Uniq ID
            $projIsChange = $this->params->data['projIsChange']; // Project Uniq ID
            $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
            $priorityFil = $this->params->data['priFil']; // Filter by Priority
            $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
            $caseUserId = $this->params->data['caseMember']; // Filter by Member

            $caseComment = $this->params->data['caseComment']; // Filter by Member
            $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
            $caseDate = $this->params->data['caseDate']; // Sort by Date
            $caseDueDate = $this->params->data['caseDueDate']; // Sort by Due Date
            @$case_duedate = $this->params->data['case_due_date'];
            @$case_date = $this->params->data['case_date'];
            $caseSrch = $this->params->data['caseSearch']; // Search by keyword

            $casePage = $this->params->data['casePage']; // Pagination
            $caseUniqId = $this->params->data['caseId']; // Case Uniq ID to close a case
            $caseTitle = $this->params->data['caseTitle']; // Case Uniq ID to close a case
            $caseNum = $this->params->data['caseNum']; // Sort by Due Date
            $caseLegendsort = $this->params->data['caseLegendsort']; // Sort by Case Status
            $caseAtsort = $this->params->data['caseAtsort']; // Sort by Case Status
            $startCaseId = $this->params->data['startCaseId']; // Start Case
            $caseResolve = $this->params->data['caseResolve']; // Resolve Case
            $caseNew = $this->params->data['caseNew']; // New Case
            $caseMenuFilters = $this->params->data['caseMenuFilters']; // Resolve Case
            $milestoneIds = $this->params->data['milestoneIds']; // Resolve Case
            $caseCreateDate = $this->params->data['caseCreateDate']; // Sort by Created Date
            @$case_srch = $this->params->data['case_srch'];
            @$milestone_type = $this->params->data['mstype'];
            $changecasetype = $this->params->data['caseChangeType'];
            $caseChangeDuedate = $this->params->data['caseChangeDuedate'];
            $caseChangePriority = $this->params->data['caseChangePriority'];
            $caseChangeAssignto = $this->params->data['caseChangeAssignto'];
            $customfilterid = $this->params->data['customfilter'];
            $detailscount = $this->params->data['detailscount']; // Count number to open casedetails
        } else {
            $projUniq = $proUid;
            $casePage = !empty($inCasePage) ? $inCasePage : 1;
            $caseTitle = $search_val;
        }
        $filterenabled = 0;
        $clt_sql = 1;
        if (empty($inactiveFlag)) {
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
        }

        /* jyoti start */
        if ($customfilterid) {
            $this->loadModel('CustomFilter');
            #$getcustomfilter = "SELECT SQL_CALC_FOUND_ROWS * FROM custom_filters AS CustomFilter WHERE CustomFilter.company_id = '" . SES_COMP . "' and CustomFilter.user_id =  '" . SES_ID . "' and CustomFilter.id='" . $customfilterid . "' ORDER BY CustomFilter.dt_created DESC ";
            #$getfilter = $this->CustomFilter->query($getcustomfilter);
            $getfilter = $this->CustomFilter->find(
                'all',
                array(
                        'conditions' => array(
                            'CustomFilter.company_id' => "'" . SES_COMP . "'",
                            'CustomFilter.user_id' => "'" . SES_ID . "'",
                            'CustomFilter.id' => "'" . $customfilterid . "'"
                        ),
                        'order' => 'CustomFilter.dt_created DESC'
                    )
            );

            if ($getfilter) {
                $caseStatus = $getfilter[0]['CustomFilter']['filter_status'];
                $priorityFil = $getfilter[0]['CustomFilter']['filter_priority'];
                $caseTypes = $getfilter[0]['CustomFilter']['filter_type_id'];
                $caseUserId = $getfilter[0]['CustomFilter']['filter_member_id'];
                $caseComment = $getfilter[0]['CustomFilter']['filter_comment'];
                $caseAssignTo = $getfilter[0]['CustomFilter']['filter_assignto'];
                $caseDate = $getfilter[0]['CustomFilter']['filter_date'];
                $case_duedate = $getfilter[0]['CustomFilter']['filter_duedate'];
                $caseSrch = $getfilter[0]['CustomFilter']['filter_search'];
            }
            $filterenabled = 1;
        }
        /* jyoti end */

        if ($caseMenuFilters) {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        } else {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        }

        $caseUrl = $this->params->data['caseUrl'];
        ######## get project ID from project uniq-id ################
        $curProjId = null;
        $curProjShortName = null;
        if ($projUniq != 'all') {
            /**
             * Binding of Project table is already done in ProjectUser model
             */
//            $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
            if (empty($inactiveFlag)) {
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            } else {
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 2, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            }
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = $projArr['Project']['short_name'];

                //Updating ProjectUser table to current date-time
                if ($projIsChange != $projUniq && empty($inactiveFlag)) {
                    $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                    $ProjectUser['dt_visited'] = GMT_DATETIME;
                    $this->ProjectUser->save($ProjectUser);
                }
            }
        }
        ######### Filter by CaseUniqId ##########
        $qry = "";
        if (trim($caseUrl)) {
            $filterenabled = 1;
            $qry.= " AND Easycase.uniq_id='" . $caseUrl . "'";
        }
        ######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
            $qry.= $this->Format->statusFilter($caseStatus);
            $stsLegArr = $caseStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
            if (!in_array("upd", $expStsLeg)) {
                $qry.= " AND Easycase.type_id !=10";
            }
        }

        ######### Filter by Case Types ##########
        if (trim($caseTypes) && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Priority ##########
        if (trim($priorityFil) && $priorityFil != "all") {
            $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseUserId) && $caseUserId != "all") {
            $qry.= $this->Format->memberFilter($caseUserId);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseComment) && $caseComment != "all") {
            $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
            $filterenabled = 1;
        }
        ######### Filter by AssignTo ##########
        if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
            $qry.= $this->Format->assigntoFilter($caseAssignTo);
            $filterenabled = 1;
        } elseif (trim($caseAssignTo) == "unassigned") {
            $qry.= " AND Easycase.assign_to='0'";
            $filterenabled = 1;
        }
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
        if (!empty($inactiveFlag)) {
            if (!empty($csNum) && $csNum != 'null') {
                if ($csNum == 'desc') {
                    $sortorder = 'ASC';
                } else {
                    $sortorder = 'DESC';
                }
            } else {
                $sortorder = 'ASC';
            }

            $sortby = !empty($type) ? $type : '';
        }
        if ($sortby == 'title') {
            $orderby = "LTRIM(Easycase.title) " . $sortorder;
            $caseTitle = strtolower($sortorder);
        } elseif ($sortby == 'duedate') {
            $caseDueDate = strtolower($sortorder);
            $orderby = "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'estimatedhours') {
            $caseEstHours = strtolower($sortorder);
            $orderby = "Easycase.estimated_hours " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $caseNum = strtolower($sortorder);
            $orderby = "Easycase.case_no " . $sortorder;
        } elseif ($sortby == 'caseAt') {
            $caseAtsort = strtolower($sortorder);
            $orderby = "Assigned " . $sortorder;
        } elseif ($sortby == 'priority') {
            $casePriority = strtolower($sortorder);
            $orderby = "Easycase.priority " . $sortorder;
        } elseif ($sortby == 'status') {
            $caseStatusby = strtolower($sortorder);
            $orderby = "Easycase.legend " . $sortorder;
        } else {
            $caseUpdatedby = strtolower($sortorder);
            $orderby = "Easycase.dt_created " . $sortorder;
        }
        $groupby = '';
        $gby = 'milestone';
        $mileSton_orderby = '';
        $case_join = 'LEFT';
        $milstone_filter_condition = '';

        if (empty($_COOKIE['TASKGROUPBY']) || (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] != 'date')) {
            $orderby = '';
            #$groupby = $_COOKIE['TASKGROUPBY'];
            $groupby = 'milestone';
            if ($groupby != 'milestone') {
                setcookie('TASKSORTBY', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
                setcookie('TASKSORTORDER', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
            }
            if ($groupby == 'status') {
                $gby = 'status';
                $orderby .= " FIND_IN_SET(Easycase.type_id,'10'),FIND_IN_SET(Easycase.legend,'1,2,4,5,3,10') ";
            } elseif ($groupby == 'priority') {
                $orderby .= " if(Easycase.priority = '' or Easycase.priority is null,4,Easycase.priority),Easycase.priority";
                $gby = 'priority';
            } elseif ($groupby == 'duedate') {
                $orderby .= " Easycase.due_date DESC";
                $gby = 'due_date';
            } elseif ($groupby == 'crtdate') {
                $gby = 'crtdate';
                $orderby .= " Easycase.actual_dt_created DESC";
            } elseif ($groupby == 'assignto') {
                $gby = 'assignto';
                $orderby .= " Assigned ASC";
            } elseif ($groupby == 'milestone') {
                $gby = 'milestone';
                $orderby .=" EasycaseMilestone.milestone_id ASC";

                if ((isset($_COOKIE['TASKGROUP_FIL']) && $_COOKIE['TASKGROUP_FIL']) || (isset($last_filter_taskgroup) && $last_filter_taskgroup)) {
                    if (trim($_COOKIE['TASKGROUP_FIL']) == 'active' || trim($last_filter_taskgroup) == 'active') {
                        $case_join = 'INNER';
                        if ($projUniq == 'all') {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=0 AND Milestone.company_id =' . SES_COMP . ') ';
                        } else {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=0 AND Milestone.company_id =' . SES_COMP . ' AND Milestone.project_id =' . $curProjId . ') ';
                        }
                    } elseif (trim($_COOKIE['TASKGROUP_FIL']) == 'completed' || trim($last_filter_taskgroup) == 'completed') {
                        $case_join = 'INNER';
                        if ($projUniq == 'all') {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=1 AND Milestone.company_id =' . SES_COMP . ') ';
                        } else {
                            $milstone_filter_condition = ' AND EasycaseMilestone.milestone_id NOT IN(SELECT id FROM milestones as Milestone WHERE Milestone.isactive=1 AND Milestone.company_id =' . SES_COMP . ' AND Milestone.project_id =' . $curProjId . ') ';
                        }
                    }
                }
            }

            if ($groupby != 'date') {
                $orderby .=" ,Easycase.dt_created DESC";
                if ($groupby == 'milestone') {
                    $orderby = " CASE WHEN EasycaseMilestone.milestone_id IS NULL THEN 99999999999999 ELSE EasycaseMilestone.m_order END  ASC, EasycaseMilestone.milestone_id ASC ";
                    if ($sortby == 'duedate') {
                        $caseDueDate = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.due_date " . $sortorder;
                    } elseif ($sortby == 'caseAt') {
                        $caseAtsort = strtolower($sortorder);
                        $mileSton_orderby = " ,Assigned " . $sortorder;
                    } elseif ($sortby == 'title') {
                        $caseTitle = strtolower($sortorder);
                        $mileSton_orderby = " ,LTRIM(Easycase.title) " . $sortorder;
                    } elseif ($sortby == 'caseno') {
                        $caseNum = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.case_no " . $sortorder;
                    } elseif ($sortby == 'priority') {
                        $casePriority = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.priority " . $sortorder;
                    } elseif ($sortby == 'updated') {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.dt_created " . $sortorder;
                    } else {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,EasycaseMilestone.id_seq ASC,Easycase.seq_id ASC ";
                    }
                }
            }
        }
        ######### Search by KeyWord ##########
        $searchcase = "";
        if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
            //$qry="";
            $filterenabled = 1;
            $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
        }

        if (trim(urldecode($case_srch)) != "") {
            $filterenabled = 1;
            $searchcase = "AND (Easycase.case_no = '$case_srch')";
        }

        if (trim(urldecode($caseSrch))) {
            $filterenabled = 1;
            if ((substr($caseSrch, 0, 1)) == '#') {
                $tmp = explode("#", $caseSrch);
                $casno = trim($tmp['1']);
                $searchcase = " AND (Easycase.case_no = '" . $casno . "')";
            }
        }
        $cond_easycase_actuve = "";
        if ((isset($case_srch) && !empty($case_srch)) || isset($caseSrch) && !empty($caseSrch)) {
            $cond_easycase_actuve = "";
        } else {
            $cond_easycase_actuve = "AND Easycase.isactive=1";
        }

        if (trim($case_date) != "") {
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            
            if (trim($case_date) == 'one') {
                $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
            } elseif (trim($case_date) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
            } elseif (trim($case_date) == 'week') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
            } elseif (trim($case_date) == 'month') {
                $filterenabled = 1;
                $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
            } elseif (trim($case_date) == 'year') {
                $filterenabled = 1;
                $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
            } elseif (strstr(trim($case_date), "_")) {
                $filterenabled = 1;
                //echo $case_date;exit;
                $ar_dt = explode("_", trim($case_date));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        

        if (trim($case_duedate) != "") {
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if (trim($case_duedate) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
            } elseif (trim($case_duedate) == 'overdue') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) ";
            } elseif (strstr(trim($case_duedate), ":") && trim($case_duedate) !== '0000-00-00 00:00:00') {
                $filterenabled = 1;
                $ar_dt = explode(":", trim($case_duedate));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        ######### Filter by Assign To ##########
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        }
        ######### Filter by Delegate To ##########
        elseif ($caseMenuFilters == "delegateto") {
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
        } elseif ($caseMenuFilters == "closedtasks") {
            $qry.= " AND Easycase.legend='3' AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "overdue") {
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date != '0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND Easycase.due_date < '" . $cur_dt . "' AND (Easycase.legend !=3) ";
        } elseif ($caseMenuFilters == "highpriority") {
            $qry.= " AND Easycase.priority ='0' ";
        } elseif ($caseMenuFilters == "openedtasks") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='5' OR Easycase.legend='4')  AND Easycase.type_id !='10'";
        }
        if (!empty($search_val) && !empty($inactiveFlag)) {
            $qry.= "AND Easycase.title LIKE '%" . trim($search_val) . "%'";
        }
        ######### Filter by Latest ##########
        elseif ($caseMenuFilters == "latest") {
            $filterenabled = 1;
            $qry_rest = $qry;
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $all_rest = " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            $qry_rest.= " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
        }
        if ($caseMenuFilters == "latest" && $projUniq != 'all') {
            $CaseCount3 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases AS Easycase WHERE istype='1' " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry_rest));
            $CaseCount = $CaseCount3['0']['0']['count'];
            if ($CaseCount == 0) {
                $rest = $this->Easycase->query("SELECT dt_created FROM easycases WHERE project_id ='" . $curProjId . "' ORDER BY dt_created DESC LIMIT 0 , 1");
                @$sdate = explode(" ", @$rest[0]['easycases']['dt_created']);
                $qry.= " AND Easycase.dt_created >= '" . @$sdate[0] . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            } else {
                $qry = $qry . $all_rest;
            }
        } elseif ($caseMenuFilters == "latest" && $projUniq == 'all') {
            $qry = $qry . $all_rest;
        }

        ######### Close a Case ##########
        if ($changecasetype) {
            $caseid = $changecasetype;
        } elseif ($caseChangeDuedate) {
            $caseid = $caseChangeDuedate;
        } elseif ($caseChangePriority) {
            $caseid = $caseChangePriority;
        } elseif ($caseChangeAssignto) {
            $caseid = $caseChangeAssignto;
        }

        if ($caseid) {
            $checkStatus = $this->Easycase->find('all', array('conditions' => array('id' => $caseid, 'isactive' => '1'), 'fields' => array('legend')));
            if ($checkStatus['0']['Easycase']['legend'] == 1) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#763532" style="font:normal 12px verdana;">NEW</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 4) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 5) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 3) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            }
        }

        $commonAllId = "";
        $caseid_list = '';
        if ($startCaseId) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $startCaseId;
            $emailType = "Start";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font> the Task.';
        } elseif ($caseResolve) {
            $csSts = 1;
            $csLeg = 5;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseResolve;
            $emailType = "Resolve";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = '<font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font> the Task.';
        } elseif ($caseNew) {
            $csSts = 1;
            $csLeg = 1;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseNew;
            $emailType = "New";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = 'Changed the status of the task to<font color="#F08E83" style="font:normal 12px verdana;">NEW</font>.';
        } elseif ($caseUniqId) {
            $csSts = 2;
            $csLeg = 3;
            $acType = 1;
            $cuvtype = 3;
            $commonAllId = $caseUniqId;
            $emailType = "Close";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            $emailbody = '<font color="green" style="font:normal 12px verdana;">CLOSED</font> the Task.';
        } elseif ($changecasetype) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $changecasetype;
            $emailType = "Change Type";
            $caseChageType1 = 1;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the type of</font> the Task.';
        } elseif ($caseChangeDuedate) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeDuedate;
            $emailType = "Change Duedate";
            $caseChageDuedate1 = 3;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the due date of</font> the Task.';
        } elseif ($caseChangePriority) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangePriority;
            $emailType = "Change Priority";
            $caseChagePriority1 = 2;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the priority of</font> the Task.';
        } elseif ($caseChangeAssignto) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeAssignto;
            $emailType = "Change Assignto";
            $caseChangeAssignto1 = 4;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the assigned to of</font> the Task.';
        }

        if ($commonAllId) {
            $commonAllId = $commonAllId . ",";
            $commonArrId = explode(",", $commonAllId);
            $done = 1;
            if ($caseChageType1 || $caseChageDuedate1 || $caseChagePriority1 || $caseChangeAssignto1) {
            } else {
                foreach ($commonArrId as $commonCaseId) {
                    if (trim($commonCaseId)) {
                        /* dependency check start */
                        $allowed = "Yes";
                        $depends = $this->Easycase->find('first', array('conditions' => array('id' => $commonCaseId)));
                        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
                            $result = $this->Easycase->find('all', array('conditions' => array('id IN (' . $depends['Easycase']['depends'] . ')')));
                            if (is_array($result) && count($result) > 0) {
                                foreach ($result as $key => $parent) {
                                    if ($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) {
                                        // NO ACTION
                                    } else {
                                        $allowed = "No";
                                    }
                                }
                            }
                        }
                        /* dependency check end */
                        if ($allowed == 'No') {
                            $resCaseProj['errormsg'] = 'Dependant tasks are not closed.';
                        } else {
                            $done = 1;
                            $checkSts = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $commonCaseId . "' AND isactive='1'");
                            if (isset($checkSts['0']) && count($checkSts['0']) > 0) {
                                if ($checkSts['0']['easycases']['legend'] == 3) {
                                    $done = 0;
                                }
                                if ($csLeg == 4) {
                                    if ($checkSts['0']['easycases']['legend'] == 4) {
                                        $done = 0;
                                    }
                                }
                                if ($csLeg == 5) {
                                    if ($checkSts['0']['easycases']['legend'] == 5) {
                                        $done = 0;
                                    }
                                }
                            } else {
                                $done = 0;
                            }
                            if ($done) {
                                $caseid_list .= $commonCaseId . ',';
                                $caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to')));
                                $caseStsId = $caseDataArr['Easycase']['id'];
                                $caseStsNo = $caseDataArr['Easycase']['case_no'];
                                $closeStsPid = $caseDataArr['Easycase']['project_id'];
                                $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                                $closeStsPri = $caseDataArr['Easycase']['priority'];
                                $closeStsTitle = $caseDataArr['Easycase']['title'];
                                $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                                $caUid = $caseDataArr['Easycase']['assign_to'];

                                $this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");

                                $caseuniqid = $this->Format->generateUniqNumber();
                                $this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . SES_ID . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                                //$thisCaseId = mysql_insert_id();
                                //socket.io implement start

                                $this->ProjectUser->recursive = -1;
                                $getUser = $this->ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $closeStsPid . "'");
                                $prjuniq = $this->Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
                                $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
                                $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                                $channel_name = $prjuniqid;

                                $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                                if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'osnewui16.com')) {
                                    $this->Postcase->iotoserver(array('channel' => $channel_name, 'message' => $msgpub));
                                    //socket.io implement end
                                }
                            }
                        }
                    }
                }
            }
            $_SESSION['email']['email_body'] = $emailbody;
            $_SESSION['email']['msg'] = $msg;
            if ($caseChageType1 == 1) {
                $caseid_list = $commonAllId;
            } elseif ($caseChagePriority1 == 2) {
                $caseid_list = $commonAllId;
            } elseif ($caseChageDuedate1 == 3) {
                $caseid_list = $commonAllId;
            } elseif ($caseChangeAssignto1 == 4) {
                $caseid_list = $commonAllId;
            }
            $email_notification = array('allfiles' => $allfiles, 'caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg, 'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo, 'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid, 'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'caseUniqId' => $closeStsUniqId); // $caseuniqid

            $resCaseProj['email_arr'] = json_encode($email_notification);
        }
        $msQuery1 = " ";
        if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
            $msQuery = "";
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                foreach ($expMilestoneIds as $msid) {
                    if ($msid) {
                        $msQuery.= "EasycaseMilestone.milestone_id=" . $msid . " OR ";
                    }
                }
                if ($msQuery) {
                    $msQuery = substr($msQuery, 0, -3);
                    $msQuery = " AND (" . $msQuery . ")";
                }
            } else {
                $tody = date('Y-m-d', strtotime("now"));
            }
        }

        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        $resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['csTtl'] = $caseTitle;
        $resCaseProj['csDuDt'] = $caseDueDate;
        $resCaseProj['csCrtdDt'] = $caseCreateDate;
        $resCaseProj['csNum'] = $caseNum;
        $resCaseProj['csLgndSrt'] = $caseLegendsort;
        $resCaseProj['csAtSrt'] = $caseAtsort;

        $resCaseProj['csPriSrt'] = $casePriority;
        $resCaseProj['csStusSrt'] = $caseStatusby;
        $resCaseProj['csUpdatSrt'] = $caseUpdatedby;

        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        $mileSton_names = array();
        $all_mileSton_names = array();
        $all_prj_names = null;
        $sub_task_condition = " (Easycase.parent_task_id IS NULL OR Easycase.parent_task_id = '') AND ";
        if ($projUniq) {
            $page = $casePage;
            $limit1 = $page * $page_limit - $page_limit;
            $limit2 = $page_limit;

            if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                if ($milestone_type == 0) {
                    $qrycheck = "Milestone.isactive='0'";
                } else {
                    $qrycheck = "Milestone.isactive='1'";
                }
                if ($projUniq != 'all') {
                    $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,"
                            . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned "
                            . "FROM (SELECT Easycase.*,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,"
                            . "EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq,EasycaseMilestone.m_order,Milestone.id AS Mid,"
                            . "Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,"
                            . "Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id "
                            . "FROM easycases AS Easycase, easycase_milestones AS EasycaseMilestone, milestones AS Milestone "
                            . "WHERE {$sub_task_condition} EasycaseMilestone.easycase_id=Easycase.id AND Milestone.id=EasycaseMilestone.milestone_id" . $msQuery1 . ""
                            . "AND Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " AND " . $qrycheck . " "
                            . "AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " "
                            . "AND EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.project_id=" . $curProjId . $msQuery . " ) AS Easycase "
                            . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                            . "ORDER BY Easycase.end_date ASC,Easycase.Mtitle ASC," . $orderby . " "
                            . "LIMIT $limit1,$limit2";
                } elseif ($projUniq == 'all') {
                    $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,"
                            . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned "
                            . "FROM (SELECT Easycase.*,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,"
                            . "EasycaseMilestone.user_id AS Em_user_id, EasycaseMilestone.id_seq, EasycaseMilestone.m_order, Milestone.id AS Mid,"
                            . "Milestone.title AS Mtitle, Milestone.end_date, Milestone.isactive AS Misactive, Milestone.project_id AS Mproject_id,"
                            . "Milestone.uniq_id AS Muinq_id "
                            . "FROM easycases AS Easycase, easycase_milestones AS EasycaseMilestone, milestones AS Milestone "
                            . "WHERE {$sub_task_condition} EasycaseMilestone.easycase_id=Easycase.id AND Milestone.id=EasycaseMilestone.milestone_id AND Easycase.istype='1' "
                            . "AND " . $clt_sql . " " . $cond_easycase_actuve . " AND " . $qrycheck . " AND Easycase.project_id!=0 "
                            . "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project "
                            . "WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' "
                            . "AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . " "
                            . "AND EasycaseMilestone.easycase_id=Easycase.id "
                            . "AND EasycaseMilestone.project_id IN (SELECT ProjectUser.project_id "
                            . "FROM project_users AS ProjectUser,projects AS Project "
                            . "WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')" . $msQuery . " ) AS Easycase "
                            . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                            . "ORDER BY Easycase.end_date ASC,Easycase.Mtitle ASC," . $orderby . " "
                            . "LIMIT $limit1,$limit2";
                }
                $caseAll = $this->Easycase->query($req_sql);
                $case_count = $this->Easycase->query('SELECT FOUND_ROWS() AS cnt');
            #pr($case_count);exit;
            } else {
                if ($projUniq == 'all') {
                    if ($caseMenuFilters == "latest") {
                        $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,"
                                . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned "
                                . "FROM (SELECT * FROM easycases AS Easycase WHERE {$sub_task_condition} Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " "
                                . "AND Easycase.project_id!=0 "
                                . "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects AS Project "
                                . "WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' "
                                . "AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.dt_created DESC) AS Easycase "
                                . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                                . "ORDER BY " . $orderby . " "
                                . "LIMIT $limit1,$limit2";
                    } else {
                        $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id as mid,User.short_name,"
                                . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned "
                                . "FROM (SELECT * FROM easycases AS Easycase WHERE {$sub_task_condition} Easycase.istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " "
                                . "AND Easycase.project_id!=0 "
                                . "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project "
                                . "WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' "
                                . "AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . "  ORDER BY  Easycase.project_id DESC) AS Easycase "
                                . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                                . "" . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id" . $milstone_filter_condition . " "
                                . "ORDER BY " . $orderby . $mileSton_orderby . " "
                                . "LIMIT $limit1,$limit2";
                    }
                } else {
                    $req_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id as mid,User.short_name,"
                            . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned "
                            . "FROM (SELECT * FROM easycases AS Easycase WHERE {$sub_task_condition} istype='1' AND " . $clt_sql . " " . $cond_easycase_actuve . " "
                            . "AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase "
                            . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                            . "" . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id "
                            . "" . $milstone_filter_condition . " "
                            . "ORDER BY " . $orderby . $mileSton_orderby . " "
                            . "LIMIT $limit1,$limit2";
                }
                #print $req_sql
                $caseAll = $this->Easycase->query($req_sql);
                $case_count = $this->Easycase->query('SELECT FOUND_ROWS() AS cnt');
                #pr($case_count);exit;
                $results_mids = Hash::extract($caseAll, '{n}.EasycaseMilestone.mid');
                $results_mids = array_unique(array_filter($results_mids));
                #$results_mids = array_filter($results_mids);

                if ($results_mids) {
                    $cond = array('conditions' => array('Milestone.id' => $results_mids), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.title', 'Milestone.isactive', 'Milestone.project_id'));
                    $mileSton_names = $this->Milestone->find('all', $cond);
                    $mileSton_names = Hash::combine($mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                    foreach ($mileSton_names as $miik => $miiv) {
                        $mileSton_names[$miik]['title'] = htmlspecialchars_decode($miiv['title']);
                    }
                }
            }

            $CaseCount = $case_count[0][0]['cnt'];

            $tsk_grp_fl = array(0, 1);
            if (isset($_COOKIE['TASKGROUP_FIL']) && $_COOKIE['TASKGROUP_FIL']) {
                if (trim($_COOKIE['TASKGROUP_FIL']) == 'active') {
                    $tsk_grp_fl = 1;
                } elseif (trim($_COOKIE['TASKGROUP_FIL']) == 'completed') {
                    $tsk_grp_fl = 0;
                }
            }
            if ($projUniq == 'all') {
                $ec_mil = $this->Easycase->query("SELECT DISTINCT(EasycaseMilestone.milestone_id) AS mid "
                        . "FROM easycase_milestones AS EasycaseMilestone "
                        . "WHERE EasycaseMilestone.project_id IN(SELECT PJU.project_id FROM project_users AS PJU "
                        . "WHERE PJU.company_id = " . SES_COMP . " AND PJU.user_id = " . SES_ID . ")");
                $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title'), 'order' => 'Milestone.created DESC');
                if ($ec_mil) {
                    $ec_mil = array_unique(Hash::extract($ec_mil, '{n}.EasycaseMilestone.mid'));
                    $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl, 'NOT' => array('Milestone.id' => $ec_mil)), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title'), 'order' => 'Milestone.created DESC');
                }
            } else {
                $ec_mil = $this->Easycase->query("SELECT DISTINCT(EasycaseMilestone.milestone_id) AS mid FROM easycase_milestones AS EasycaseMilestone "
                        . "WHERE EasycaseMilestone.project_id IN(SELECT PJU.project_id FROM project_users AS PJU "
                        . "WHERE PJU.company_id = " . SES_COMP . " AND PJU.user_id = " . SES_ID . " AND PJU.project_id = " . $curProjId . ")");
                $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl, 'Milestone.project_id' => $curProjId), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title', 'Milestone.isactive'), 'order' => 'Milestone.created DESC');
                if ($ec_mil) {
                    $ec_mil = array_unique(Hash::extract($ec_mil, '{n}.EasycaseMilestone.mid'));
                    $cond = array('conditions' => array('Milestone.company_id' => SES_COMP, 'Milestone.isactive' => $tsk_grp_fl, 'Milestone.project_id' => $curProjId, 'NOT' => array('Milestone.id' => $ec_mil)), 'fields' => array('Milestone.id', 'Milestone.uniq_id', 'Milestone.project_id', 'Milestone.title', 'Milestone.isactive'), 'order' => 'Milestone.created DESC');
                }
            }
            $all_mileSton_names = $this->Milestone->find('all', $cond);
            
            $milestone_pids = null;
            if ($projUniq == 'all' && $all_mileSton_names) {
                $milestone_pids = array_unique(Hash::extract($all_mileSton_names, '{n}.Milestone.project_id'));
                $cond_pnames = array('conditions' => array('Project.id' => $milestone_pids), 'fields' => array('Project.id', 'Project.name'));
                $all_prj_names = $this->Project->find('list', $cond_pnames);
            }
            if ($all_mileSton_names) {
                $all_mileSton_names = Hash::combine($all_mileSton_names, '{n}.Milestone.id', '{n}.Milestone');
                foreach ($all_mileSton_names as $mik => $miv) {
                    $all_mileSton_names[$mik]['title'] = htmlspecialchars_decode($miv['title']);
                }
            }

            $msQ = "";
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                $idArr = array();
                foreach ($expMilestoneIds as $msid) {
                    if (trim($msid)) {
                        $idArr[] = trim($msid);
                    }
                }
                if (count($idArr)) {
                    $msQ.= "AND Milestone.id IN (" . implode(",", $idArr) . ")";
                }
            }
            if ($projUniq != 'all') {
                $milestones = array();

                if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                    if ($milestone_type == 0) {
                        $qrycheck = "Milestone.isactive='0'";
                    } else {
                        $qrycheck = "Milestone.isactive='1'";
                    }
                    $milestones = $this->Milestone->query("SELECT `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`end_date`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`  FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id WHERE `Milestone`.`project_id` =" . $curProjId . " AND " . $qrycheck . " AND `Milestone`.`company_id` = " . SES_COMP . " " . $msQ . " GROUP BY Milestone.id ORDER BY `Milestone`.`id` ASC");
                }
                foreach ($milestones as $mls) {
                    $mid.= $mls['Milestone']['id'] . ',';
                    $m[$mls['Milestone']['id']]['id'] = $mls['Milestone']['id'];
                    $m[$mls['Milestone']['id']]['caseids'] = $mls[0]['caseids'];
                    $m[$mls['Milestone']['id']]['totalcases'] = $mls[0]['totalcases'];
                    $m[$mls['Milestone']['id']]['title'] = $mls['Milestone']['title'];
                    $m[$mls['Milestone']['id']]['project_id'] = $mls['Milestone']['project_id'];
                    $m[$mls['Milestone']['id']]['end_date'] = $mls['Milestone']['end_date'];
                    $m[$mls['Milestone']['id']]['uinq_id'] = $mls['Milestone']['uniq_id'];
                    $m[$mls['Milestone']['id']]['isactive'] = $mls['Milestone']['isactive'];
                    $m[$mls['Milestone']['id']]['user_id'] = $mls['Milestone']['user_id'];
                }
                $c = array();

                if ($mid) {
                    $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) AS totcase "
                            . "FROM easycase_milestones AS EasycaseMilestone "
                            . "LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id "
                            . "WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' "
                            . "AND EasycaseMilestone.milestone_id IN(" . trim($mid, ',') . ") "
                            . "GROUP BY  EasycaseMilestone.milestone_id");
                    foreach ($closed_cases as $key => $val) {
                        $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                    }
                }
                $resCaseProj['milestones'] = $m;
            }
            if ($projUniq == 'all') {
                $milestones = array();
                if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
                    if ($milestone_type == 0) {
                        $qrycheck = "Milestone.isactive='0'";
                    } else {
                        $qrycheck = "Milestone.isactive='1'";
                    }
                    $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP, 'Project.isactive' => 1), 'fields' => array('DISTINCT  Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));
                    $this->ProjectUser->unbindModel(array('belongsTo' => array('User')));
                    $allProjArr = $this->ProjectUser->find('all', $cond);
                    $ids = array();
                    foreach ($allProjArr as $csid) {
                        array_push($ids, $csid['Project']['id']);
                    }
                    $implode_ids = implode(',', $ids);
                    $this->Milestone->recursive = -1;

                    $milestones = $this->Milestone->query("SELECT `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,"
                            . "`Milestone`.`end_date`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,"
                            . "COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids`  "
                            . "FROM milestones AS `Milestone` "
                            . "LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id "
                            . "WHERE `Milestone`.`project_id` IN (" . $implode_ids . ") AND " . $qrycheck . " AND `Milestone`.`company_id` = " . SES_COMP . " " . $msQ . " "
                            . "GROUP BY Milestone.id ORDER BY `Milestone`.`id` ASC");

                    $mid = '';
                    foreach ($milestones as $k => $v) {
                        $mid.= $v['Milestone']['id'] . ',';
                        $m[$v['Milestone']['id']]['id'] = $v['Milestone']['id'];
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
                        $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) AS totcase "
                                . "FROM easycase_milestones AS EasycaseMilestone "
                                . "LEFT JOIN easycases AS Easycase ON   EasycaseMilestone.easycase_id=Easycase.id "
                                . "WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' "
                                . "AND EasycaseMilestone.milestone_id IN (" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
                        foreach ($closed_cases as $key => $val) {
                            $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                        }
                    }
                    $resCaseProj['milestones'] = $m;
                }
            }

            if ($projUniq != 'all') {
                $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype, User.email, User.short_name, User.photo "
                        . "FROM users AS User,easycases AS Easycase "
                        . "WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) "
                        . "AND Easycase.project_id='" . $curProjId . "' AND Easycase.isactive='1' AND Easycase.istype IN('1','2') "
                        . "ORDER BY User.short_name");
            } else {
                $usrDtlsAll = $this->ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo "
                        . "FROM users AS User, easycases AS Easycase "
                        . "WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) "
                        . "AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project "
                        . "WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' "
                        . "AND ProjectUser.company_id='" . SES_COMP . "') AND Easycase.isactive='1' AND Easycase.istype IN('1','2') "
                        . "ORDER BY User.short_name");
            }
            $usrDtlsArr = Hash::combine($usrDtlsAll, "{n}.User.id", "{n}");
        } else {
            $CaseCount = 0;
        }
        $resCaseProj['caseCount'] = $CaseCount;

        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
        $cq = $view->loadHelper('Casequery');
        $frmt = $view->loadHelper('Format');

        $related_tasks = array();
        if (is_array($caseAll) && count($caseAll) > 0 && $projUniq != 'all') {
            $taskIds = array_filter(Hash::extract($caseAll, '{n}.Easycase.id'));

            $dependency = array();
            /*if (is_array($taskIds) && count($taskIds) > 0) {
                $this->loadModel('EasycaseLink');
                $links = $this->EasycaseLink->find('all', array('conditions' => array('OR' => array('EasycaseLink.source' => $taskIds, 'EasycaseLink.target' => $taskIds))));
                if (is_array($links) && count($links) > 0) {
                    foreach ($links as $link) {
                        $dependency['children'][$link['EasycaseLink']['source']][] = $link['EasycaseLink']['target'];
                        $dependency['depends'][$link['EasycaseLink']['target']][] = $link['EasycaseLink']['source'];
                    }
                }
            }*/

            //fetch all child tasks
            $related_tasks = !empty($taskIds) ? $this->Easycase->getSubTaskChild($taskIds, $curProjId) : array();
            
            if (!empty($related_tasks['child'])) {
                $sub_task_condition = " Easycase.id IN ('" . implode('\',\'', $related_tasks['child']) . "') AND ";
                $sub_task_sql = "SELECT SQL_CALC_FOUND_ROWS Easycase.*,EasycaseMilestone.milestone_id AS mid, User.short_name,"
                        . "Project.uniq_id,  "
                        . "IF((Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned "
                        . "FROM (SELECT * FROM easycases AS Easycase WHERE {$sub_task_condition} istype='1' AND " . $clt_sql . " "
                        . "AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry) . " ) AS Easycase "
                        . "LEFT JOIN users User ON Easycase.assign_to=User.id "
                        . "LEFT JOIN projects AS Project ON Project.id=Easycase.project_id "
                        . "" . $case_join . " JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id "
                        . "" . $milstone_filter_condition . " "
                        . "ORDER BY " . $orderby . $mileSton_orderby . " "
                        . "";

                $sub_caseAll = $this->Easycase->query($sub_task_sql);
                $sub_caseAll_tasks = $this->Easycase->formatCases($sub_caseAll, $CaseCount, $caseMenuFilters, $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, null, $dependency);
                $related_tasks['data'] = Hash::combine($sub_caseAll_tasks, "caseAll.{n}.Easycase.id", "caseAll.{n}");
            }
        }
        #pr($related_tasks);exit;
        $resCaseProj['related_tasks'] = $related_tasks;

        #pr($caseAll);exit;
        $frmtCaseAll = $this->Easycase->formatCases($caseAll, $CaseCount, $caseMenuFilters, $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, null, $dependency);
        #pr($frmtCaseAll);exit;
        $resCaseProj['caseAll'] = $frmtCaseAll['caseAll'];
        $resCaseProj['milestones'] = $frmtCaseAll['milestones'];

        $pgShLbl = $frmt->pagingShowRecords($CaseCount, $page_limit, $casePage);
        $resCaseProj['pgShLbl'] = $pgShLbl;

        $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $friday = date('Y-m-d', strtotime($curCreated . "next Friday"));
        $monday = date('Y-m-d', strtotime($curCreated . "next Monday"));
        $tomorrow = date('Y-m-d', strtotime($curCreated . "+1 day"));

        $resCaseProj['intCurCreated'] = strtotime($curCreated);
        $resCaseProj['mdyCurCrtd'] = date('m/d/Y', strtotime($curCreated));
        $resCaseProj['mdyFriday'] = date('m/d/Y', strtotime($friday));
        $resCaseProj['mdyMonday'] = date('m/d/Y', strtotime($monday));
        $resCaseProj['mdyTomorrow'] = date('m/d/Y', strtotime($tomorrow));
        $resCaseProj['GrpBy'] = $gby;
        $resCaseProj['milesto_names'] = $mileSton_names;
        $resCaseProj['all_milesto_names'] = $all_mileSton_names;
        $resCaseProj['all_milesto_prj_names'] = ($all_prj_names != null && $all_prj_names) ? $all_prj_names : 0;

        if ($projUniq != 'all') {
            $projUser = array();
            if ($projUniq) {
                $projUser = array($projUniq => $this->Easycase->getMemebers($projUniq));
            }
            $resCaseProj['projUser'] = $projUser;
            $resCaseProj['case_date'] = $case_date;
            $resCaseProj['caseStatus'] = $caseStatus;
            $resCaseProj['priorityFil'] = $priorityFil;
            $resCaseProj['caseTypes'] = $caseTypes;
            $resCaseProj['caseUserId'] = $caseUserId;
            $resCaseProj['caseComment'] = $caseComment;
            $resCaseProj['caseAssignTo'] = $caseAssignTo;
            $resCaseProj['case_duedate'] = $case_duedate;
            $resCaseProj['caseSrch'] = $caseSrch;
        }
        if (!empty($inactiveFlag)) {
            return $resCaseProj;
        }
        header("Content-Type: application/json; charset=utf-8");
        echo json_encode($resCaseProj);
        exit;
    }
    public function ajax_archive_sts_filter()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';

        $proj_id = 0;
        $pageload = 0;
        if (isset($this->params->data['projUniq'])) {
            $proj_uniq_id = $this->params->data['projUniq'];
        }
        $this->loadModel('Easycase');
        if ($proj_uniq_id != 'all') {
            $this->loadModel('Project');
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $proj_uniq_id), 'fields' => array('Project.id')));
            if (count($projArr)) {
                $proj_id = $projArr['Project']['id'];
            }
        }
        $projUniq = $proj_uniq_id;
        $curProjId = $proj_id;
        
        $customStatus = 0;
        if ($proj_uniq_id != 'all') {
            $customStatus = $this->Format->hasCustomTaskStatus($curProjId, 'Project.id');
        }
        /** Author: SSL
        Custom Task Status Group
        **/
        $query_custom_status = array();
        if ($proj_uniq_id != 'all') {
            $allStatusNames = $this->Format->getCustomTaskStatus($customStatus);
        } else {
            $allStatusNames = $this->Format->getCustomTaskStatus(-1);
            if ($allStatusNames) {
                $duplicate_sts = array();
                foreach ($allStatusNames as $sk => $sv) {
                    if (!in_array(trim($sv['CustomStatus']['name']), $duplicate_sts)) {
                        array_push($duplicate_sts, trim($sv['CustomStatus']['name']));
                    } else {
                        unset($allStatusNames[$sk]);
                    }
                }
                $allStatusNames = array_values($allStatusNames);
            }
        }
        $this->set('allCustomStatus', $allStatusNames);
        $this->render('/Easycase/ajax_status_archive', 'ajax');
    }
    
    /*for status filter in pending task page*/
    public function ajax_pending_sts_filter()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $proj_id = 0;
        $pageload = 0;
        if (isset($this->params->data['projUniq'])) {
            $proj_uniq_id = $this->params->data['projUniq'];
        }
        $this->loadModel('Easycase');
        if ($proj_uniq_id != 'all') {
            $this->loadModel('Project');
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $proj_uniq_id), 'fields' => array('Project.id')));
            if (count($projArr)) {
                $proj_id = $projArr['Project']['id'];
            }
        }
        $projUniq = $proj_uniq_id;
        $curProjId = $proj_id;
        
        $customStatus = 0;
        if ($proj_uniq_id != 'all') {
            $customStatus = $this->Format->hasCustomTaskStatus($curProjId, 'Project.id');
        }
        /** Author: SSL
        Custom Task Status Group
        **/
        $query_custom_status = array();
        if ($proj_uniq_id != 'all') {
            $allStatusNames = $this->Format->getCustomPendingTaskStatus($customStatus);
        } else {
            $allStatusNames = $this->Format->getCustomPendingTaskStatus(-1);
            if ($allStatusNames) {
                $duplicate_sts = array();
                foreach ($allStatusNames as $sk => $sv) {
                    if (!in_array(trim($sv['CustomStatus']['name']), $duplicate_sts)) {
                        array_push($duplicate_sts, trim($sv['CustomStatus']['name']));
                    } else {
                        unset($allStatusNames[$sk]);
                    }
                }
                $allStatusNames = array_values($allStatusNames);
            }
        }
        $this->set('allCustomStatus', $allStatusNames);
        $this->render('/Easycase/ajax_status_pending', 'ajax');
    }
    
    /*for status filter in pending task page*/
    public function ajax_utilization_sts_filter()
    {
        $this->autoRender = false;
        $this->layout = 'ajax';
        $proj_id = 0;
        $pageload = 0;
        if (isset($this->params->data['projUniq'])) {
            $proj_uniq_id = $this->params->data['projUniq'];
        }
        $this->loadModel('Easycase');
        if ($proj_uniq_id != 'all') {
            $this->loadModel('Project');
            $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $proj_uniq_id), 'fields' => array('Project.id')));
            if (count($projArr)) {
                $proj_id = $projArr['Project']['id'];
            }
        }
        $projUniq = $proj_uniq_id;
        $curProjId = $proj_id;
        
        $customStatus = 0;
        if ($proj_uniq_id != 'all') {
            $customStatus = $this->Format->hasCustomTaskStatus($curProjId, 'Project.id');
        }
        /** Author: SSL
        Custom Task Status Group
        **/
        $query_custom_status = array();
        if ($proj_uniq_id != 'all') {
            $allStatusNames = $this->Format->getCustomTaskStatus($customStatus);
        } else {
            $allStatusNames = $this->Format->getCustomTaskStatus(-1);
            if ($allStatusNames) {
                $duplicate_sts = array();
                foreach ($allStatusNames as $sk => $sv) {
                    if (!in_array(trim($sv['CustomStatus']['name']), $duplicate_sts)) {
                        array_push($duplicate_sts, trim($sv['CustomStatus']['name']));
                    } else {
                        unset($allStatusNames[$sk]);
                    }
                }
                $allStatusNames = array_values($allStatusNames);
            }
        }
        $this->set('allCustomStatus', $allStatusNames);
        $this->render('/Easycase/ajax_status_resourceutilization', 'ajax');
    }
    //Checklists
    //Checklist end
    
    public function case_subtask_list()
    {
        $this->layout = 'ajax';
        $resCaseProj = array();
        $page_limit = CASE_PAGE_LIMIT;

        $this->Easycase->Behaviors->enable('Tree');
        $this->Easycase->virtualFields['parent_id'] = 'Easycase.parent_task_id';


        /* Get variables */
        $projUniq = $this->params->data['projFil']; // Project Uniq ID
        if ($projUniq == '0') {
            $projUniq = "all";
        }
        $projIsChange = $this->params->data['projIsChange']; // Project Uniq ID
        $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
        $caseCustomStatus = $this->params->data['caseCustomStatus']; // Filter by Custom Status
        $priorityFil = $this->params->data['priFil']; // Filter by Priority
        $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
        $caseLabel = $this->params->data['caseLabel']; // Filter by case Label
        $caseUserId = $this->params->data['caseMember']; // Filter by Member
        $caseComment = $this->params->data['caseComment']; // Filter by Member
        $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
        $caseDate = $this->params->data['caseDate']; // Sort by Date
        $caseDueDate = $this->params->data['caseDueDate']; // Sort by Due Date
        $caseEstHours = $this->params->data['caseEstHours']; // Sort by Estimated Hours
        @$case_duedate = $this->params->data['case_due_date'];
        @$case_date = $this->params->data['case_date'];
        @$case_date = urldecode($case_date);
        $caseSrch = $this->params->data['caseSearch']; // Search by keyword

        $casePage = $this->params->data['casePage']; // Pagination
        $caseUniqId = $this->params->data['caseId']; // Case Uniq ID to close a case
        $caseTitle = $this->params->data['caseTitle']; // Case Uniq ID to close a case
        $caseNum = $this->params->data['caseNum']; // Sort by Due Date
        $caseLegendsort = $this->params->data['caseLegendsort']; // Sort by Case Status
        $caseAtsort = $this->params->data['caseAtsort']; // Sort by Case Status
        $startCaseId = $this->params->data['startCaseId']; // Start Case
        $caseResolve = $this->params->data['caseResolve']; // Resolve Case
        $caseNew = $this->params->data['caseNew']; // New Case
        $caseMenuFilters = $this->params->data['caseMenuFilters']; // Resolve Case
        $milestoneIds = $this->params->data['milestoneIds']; // Resolve Case
        $caseCreateDate = $this->params->data['caseCreateDate']; // Sort by Created Date
        @$case_srch = $this->params->data['case_srch'];
        @$milestone_type = $this->params->data['mstype'];
        $changecasetype = $this->params->data['caseChangeType'];
        $caseChangeDuedate = $this->params->data['caseChangeDuedate'];
        $caseChangePriority = $this->params->data['caseChangePriority'];
        $caseChangeAssignto = $this->params->data['caseChangeAssignto'];
        $customfilterid = $this->params->data['customfilter'];
        $detailscount = $this->params->data['detailscount']; // Count number to open casedetails
        /* End*/

        $filterenabled = 0;
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }

        if ($caseMenuFilters) {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        } else {
            setcookie('CURRENT_FILTER', $caseMenuFilters, COOKIE_REM, '/', DOMAIN_COOKIE, false, false);
        }
        $caseUrl = $this->params->data['caseUrl'];
        ######## get project ID from project uniq-id ################
        $curProjId = null;
        $curProjShortName = null;
        if ($projUniq != 'all') {
            $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = $projArr['Project']['short_name'];

                //Updating ProjectUser table to current date-time
                if ($projIsChange != $projUniq && empty($inactiveFlag)) {
                    $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                    $ProjectUser['dt_visited'] = GMT_DATETIME;
                    $this->ProjectUser->save($ProjectUser);
                }
            }
        }

        ######### Filter by CaseUniqId ##########
        $qry = "";
        if (trim($caseUrl)) {
            $filterenabled = 1;
            $qry.= " AND Easycase.uniq_id='" . $caseUrl . "'";
        }
        $is_def_status_enbled = 0;
        ######### Filter by Custom Status ##########
        if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
            $is_def_status_enbled = 1;
            $filterenabled = 1;
            $qry.= " AND (";
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus, 1);
            $stsLegArr = $caseCustomStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
        }
        ######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
            if (!$is_def_status_enbled) {
                $qry.= " AND (";
            } else {
                $qry.= " OR ";
            }
            $qry.= $this->Format->statusFilter($caseStatus, '', 1);
            $qry .= ")";
            $stsLegArr = $caseStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
            if (!in_array("upd", $expStsLeg)) {
                $qry.= " AND Easycase.type_id !=10";
            }
        } else {
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                $qry .= ")";
            }
        }
        /*######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
        $qry.= $this->Format->statusFilter($caseStatus);
        $stsLegArr = $caseStatus . "-" . "";
        $expStsLeg = explode("-", $stsLegArr);
        if (!in_array("upd", $expStsLeg)) {
            $qry.= " AND Easycase.type_id !=10";
        }
        }
        ######### Filter by Custom Status ##########
        if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
        $filterenabled = 1;
        $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus);
        $stsLegArr = $caseCustomStatus . "-" . "";
        $expStsLeg = explode("-", $stsLegArr);
        }*/

        ######### Filter by Case Types ##########
        if (trim($caseTypes) && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Case Label ##########
        if (trim($caseLabel) && $caseLabel != "all") {
            $qry.= $this->Format->labelFilter($caseLabel, $curProjId, SES_COMP, SES_TYPE, SES_ID);
            $filterenabled = 1;
        }
        ######### Filter by Priority ##########
        if (trim($priorityFil) && $priorityFil != "all") {
            $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseUserId) && $caseUserId != "all") {
            $qry.= $this->Format->memberFilter($caseUserId);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseComment) && $caseComment != "all") {
            $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
            $filterenabled = 1;
        }
        ######### Filter by AssignTo ##########
        if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
            $qry.= $this->Format->assigntoFilter($caseAssignTo);
            $filterenabled = 1;
        } elseif (trim($caseAssignTo) == "unassigned") {
            $qry.= " AND Easycase.assign_to='0'";
            $filterenabled = 1;
        }
        ######## Order by #################
        $sortby = '';
        $caseStatusby = '';
        $caseUpdatedby = '';
        $casePriority = '';
        $orderby = ($projUniq=='all'  && SES_COMP==25814)?'Easycase.project_id DESC,':'';

        if (isset($_COOKIE['TASKSORTBY'])) {
            $sortby = $_COOKIE['TASKSORTBY'];
            $sortorder = $_COOKIE['TASKSORTORDER'];
        } else {
            $sortorder = 'DESC';
        }
        if (!empty($inactiveFlag)) {
            if (!empty($csNum) && $csNum != 'null') {
                if ($csNum == 'desc') {
                    $sortorder = 'ASC';
                } else {
                    $sortorder = 'DESC';
                }
            } else {
                $sortorder = 'ASC';
            }

            $sortby = !empty($type) ? $type : '';
        }
        if ($sortby == 'title') {
            $orderby .= "LTRIM(Easycase.title) " . $sortorder;
            $caseTitle = strtolower($sortorder);
        } elseif ($sortby == 'duedate') {
            $caseDueDate = strtolower($sortorder);
            $orderby .= "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'estimatedhours') {
            $caseEstHours = strtolower($sortorder);
            $orderby .= "Easycase.estimated_hours " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $caseNum = strtolower($sortorder);
            $orderby .= "Easycase.case_no " . $sortorder;
        } elseif ($sortby == 'caseAt') {
            $caseAtsort = strtolower($sortorder);
            $orderby .= "Assigned " . $sortorder;
        } elseif ($sortby == 'priority') {
            $casePriority = strtolower($sortorder);
            $orderby .= "Easycase.priority " . $sortorder;
        } elseif ($sortby == 'status') {
            $caseStatusby = strtolower($sortorder);
            $orderby .= "Easycase.legend " . $sortorder;
        } else {
            $caseUpdatedby = strtolower($sortorder);
            $orderby .= "Easycase.dt_created " . $sortorder;
        }
        $groupby = '';
        $gby = '';
        $mileSton_orderby = '';
        $case_join = 'LEFT';
        $milstone_filter_condition = '';

        if (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] != 'date') {
            $orderby = ($projUniq=='all')?'Project.name ASC,':'';
            $groupby = $_COOKIE['TASKGROUPBY'];
            if ($groupby != 'milestone') {
                setcookie('TASKSORTBY', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
                setcookie('TASKSORTORDER', '', time() - 3600, '/', DOMAIN_COOKIE, false, false);
            }
            if ($groupby == 'status') {
                $gby = 'status';
                $orderby .= " FIND_IN_SET(Easycase.type_id,'10'),FIND_IN_SET(Easycase.legend,'1,2,4,5,3,10') ";
            } elseif ($groupby == 'priority') {
                $orderby .= " if(Easycase.priority = '' or Easycase.priority is null,4,Easycase.priority),Easycase.priority";
                $gby = 'priority';
            } elseif ($groupby == 'duedate') {
                $orderby .= " Easycase.due_date DESC";
                $gby = 'due_date';
            } elseif ($groupby == 'estimatedhours') {
                $orderby .= "Easycase.estimated_hours DESC";
                $gby = 'estimated_hours';
            } elseif ($groupby == 'crtdate') {
                $gby = 'crtdate';
                $orderby .= " Easycase.actual_dt_created DESC";
            } elseif ($groupby == 'assignto') {
                $gby = 'assignto';
                $orderby .= " Assigned ASC";
            }
            /*elseif ($groupby == 'milestone') {
                $gby = 'milestone';
                $orderby .=" EasycaseMilestone.milestone_id ASC";
            }*/

            if ($groupby != 'date') {
                $orderby .=" ,Easycase.dt_created DESC";
                if ($groupby == 'milestone') {
                    //$orderby = " CASE WHEN EasycaseMilestone.milestone_id IS NULL THEN 99999999999999 ELSE EasycaseMilestone.m_order END  ASC, EasycaseMilestone.milestone_id ASC ";
                    if ($sortby == 'duedate') {
                        $caseDueDate = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.due_date " . $sortorder;
                    } elseif ($sortby == 'estimatedhours') {
                        $caseEstHours = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.estimated_hours " . $sortorder;
                    } elseif ($sortby == 'caseAt') {
                        $caseAtsort = strtolower($sortorder);
                        $mileSton_orderby = " ,Assigned " . $sortorder;
                    } elseif ($sortby == 'title') {
                        $caseTitle = strtolower($sortorder);
                        $mileSton_orderby = " ,LTRIM(Easycase.title) " . $sortorder;
                    } elseif ($sortby == 'caseno') {
                        $caseNum = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.case_no " . $sortorder;
                    } elseif ($sortby == 'priority') {
                        $casePriority = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.priority " . $sortorder;
                    } elseif ($sortby == 'updated') {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,Easycase.dt_created " . $sortorder;
                    }
                    /*else {
                        $caseUpdatedby = strtolower($sortorder);
                        $mileSton_orderby = " ,EasycaseMilestone.id_seq ASC,Easycase.seq_id ASC ";
                    }*/
                }
            }
        }
        ######### Search by KeyWord ##########
        $searchcase = "";
        if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
            //$qry="";
            $filterenabled = 1;
            $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
        }

        if (trim(urldecode($case_srch)) != "") {
            //$qry="";
            $filterenabled = 1;
            $searchcase = "AND (Easycase.case_no = '$case_srch')";
        }

        if (trim(urldecode($caseSrch))) {
            $filterenabled = 1;
            if ((substr($caseSrch, 0, 1)) == '#') {
                //$qry="";
                $tmp = explode("#", $caseSrch);
                $casno = trim($tmp['1']);
                $searchcase = " AND (Easycase.case_no = '" . $casno . "')";
            }
        }
        $cond_easycase_actuve = "";

        if ((isset($case_srch) && !empty($case_srch)) || isset($caseSrch) && !empty($caseSrch)) {
            $cond_easycase_actuve = "";
        } else {
            $cond_easycase_actuve = "AND Easycase.isactive=1";
        }

        if (trim($case_date) != "") {
            if ((SES_COMP == 25814 || SES_COMP == 28528 || SES_COMP == 1358) && (trim($caseComment) && $caseComment != "all")) {
                // Modified for jayan (if date filter with commented by filter is applied then now apply the date filter in the parent task)
            } else {
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                if (trim($case_date) == 'one') {
                    $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
                } elseif (trim($case_date) == '24') {
                    $filterenabled = 1;
                    $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
                } elseif (trim($case_date) == 'week') {
                    $filterenabled = 1;
                    $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
                } elseif (trim($case_date) == 'month') {
                    $filterenabled = 1;
                    $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
                } elseif (trim($case_date) == 'year') {
                    $filterenabled = 1;
                    $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
                } elseif (strstr(trim($case_date), "_")) {
                    $filterenabled = 1;
                    //echo $case_date;exit;
                    $ar_dt = explode("_", trim($case_date));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
                    //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }
        }
        if (trim($case_duedate) != "") {
            $case_duedate = urldecode($case_duedate);
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if (trim($case_duedate) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
            } elseif (trim($case_duedate) == 'overdue') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) ";
            } elseif (strstr(trim($case_duedate), ":") && trim($case_duedate) !== '0000-00-00 00:00:00') {
                $filterenabled = 1;
                $ar_dt = explode(":", trim($case_duedate));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        ######### Filter by Assign To ##########
        if (!$this->Format->isAllowed('View All Task', $roleAccess)) {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        } elseif ($caseMenuFilters == "favourite") {
            if ($projUniq != 'all') {
                $this->loadModel('ProjectUser');
                $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
                if (count($projArr)) {
                    $curProjId = $projArr['Project']['id'];
                    $curProjShortName = $projArr['Project']['short_name'];
                    $conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                    $this->loadModel('EasycaseFavourite');
                    $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                    //if(!empty($easycase_favourite)){
                    $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                    //}
                }
            } else {
                $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                $this->loadModel('EasycaseFavourite');
                $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                // if(!empty($easycase_favourite)){
                $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                // }
            }
        }
        ######### Filter by Delegate To ##########
        elseif ($caseMenuFilters == "delegateto") {
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
        } elseif ($caseMenuFilters == "closedtasks") {
            $qry.= " AND (Easycase.legend='3' OR Easycase.legend='5') AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "overdue") {
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $cur_dt = date('Y-m-d', strtotime(GMT_DATETIME));
            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date != '0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND DATE(Easycase.due_date) < '" . $cur_dt . "' AND (Easycase.legend !=3) ";
        } elseif ($caseMenuFilters == "highpriority") {
            $qry.= " AND Easycase.priority ='0' ";
        } elseif ($caseMenuFilters == "openedtasks") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='4')  AND Easycase.type_id !='10'";
        }
        if (!empty($search_val) && !empty($inactiveFlag)) {
            $qry.= "AND Easycase.title LIKE '%" . trim($search_val) . "%'";
        }

        ######### Filter by Latest ##########
        elseif ($caseMenuFilters == "latest") {
            $filterenabled = 1;
            $qry_rest = $qry;
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $all_rest = " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            $qry_rest.= " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
        }
        if ($caseMenuFilters == "latest" && $projUniq != 'all') {
            $CaseCount3 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase WHERE istype='1' " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry_rest));
            $CaseCount = $CaseCount3['0']['0']['count'];
            if ($CaseCount == 0) {
                $rest = $this->Easycase->query("SELECT dt_created FROM easycases WHERE project_id ='" . $curProjId . "' ORDER BY dt_created DESC LIMIT 0 , 1");
                @$sdate = explode(" ", @$rest[0]['easycases']['dt_created']);
                $qry.= " AND Easycase.dt_created >= '" . @$sdate[0] . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            } else {
                $qry = $qry . $all_rest;
            }
        } elseif ($caseMenuFilters == "latest" && $projUniq == 'all') {
            $qry = $qry . $all_rest;
        }
        ######### Close a Case ##########
        if ($changecasetype) {
            $caseid = $changecasetype;
        } elseif ($caseChangeDuedate) {
            $caseid = $caseChangeDuedate;
        } elseif ($caseChangePriority) {
            $caseid = $caseChangePriority;
        } elseif ($caseChangeAssignto) {
            $caseid = $caseChangeAssignto;
        }

        if ($caseid) {
            //$checkStatus = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $caseid . "' AND isactive='1'");
            $checkStatus = $this->Easycase->find('all', array('conditions' => array('id' => $caseid, 'isactive' => '1'), 'fields' => array('legend')));

            if ($checkStatus['0']['Easycase']['legend'] == 1) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#763532" style="font:normal 12px verdana;">NEW</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 4) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 5) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            } elseif ($checkStatus['0']['Easycase']['legend'] == 3) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            }
        }

        $commonAllId = "";
        $caseid_list = '';
        if ($startCaseId) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $startCaseId;
            $emailType = "Start";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font> the Task.';
        } elseif ($caseResolve) {
            $csSts = 1;
            $csLeg = 5;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseResolve;
            $emailType = "Resolve";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = '<font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font> the Task.';
        } elseif ($caseNew) {
            $csSts = 1;
            $csLeg = 1;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseNew;
            $emailType = "New";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = 'Changed the status of the task to<font color="#F08E83" style="font:normal 12px verdana;">NEW</font>.';
        } elseif ($caseUniqId) {
            $csSts = 2;
            $csLeg = 3;
            $acType = 1;
            $cuvtype = 3;
            $commonAllId = $caseUniqId;
            $emailType = "Close";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            $emailbody = '<font color="green" style="font:normal 12px verdana;">CLOSED</font> the Task.';
        } elseif ($changecasetype) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $changecasetype;
            $emailType = "Change Type";
            $caseChageType1 = 1;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the type of</font> the Task.';
        } elseif ($caseChangeDuedate) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeDuedate;
            $emailType = "Change Duedate";
            $caseChageDuedate1 = 3;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the due date of</font> the Task.';
        } elseif ($caseChangePriority) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangePriority;
            $emailType = "Change Priority";
            $caseChagePriority1 = 2;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the priority of</font> the Task.';
        } elseif ($caseChangeAssignto) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeAssignto;
            $emailType = "Change Assignto";
            $caseChangeAssignto1 = 4;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the assigned to of</font> the Task.';
        }

        if ($commonAllId) {
            $commonAllId = $commonAllId . ",";
            $commonArrId = explode(",", $commonAllId);
            $done = 1;
            if ($caseChageType1 || $caseChageDuedate1 || $caseChagePriority1 || $caseChangeAssignto1) {
            } else {
                $commonArrId_t = array_filter($commonArrId);
                foreach ($commonArrId as $commonCaseId) {
                    if (trim($commonCaseId)) {
                        /* dependency check start */
                        $allowed = "Yes";
                        $depends = $this->Easycase->find('first', array('conditions' => array('id' => $commonCaseId)));
                        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
                            $result = $this->Easycase->find('all', array('conditions' => array('id IN (' . $depends['Easycase']['depends'] . ')')));
                            if (is_array($result) && count($result) > 0) {
                                foreach ($result as $key => $parent) {
                                    if (($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) || ($parent['Easycase']['legend'] == 3)) {
                                        // NO ACTION
                                    } else {
                                        $allowed = "No";
                                    }
                                }
                            }
                        }
                        /* dependency check end */
                        if ($allowed == 'No') {
                            $resCaseProj['errormsg'] = __('Dependant tasks are not closed.', true);
                        } else {
                            $done = 1;
                            $checkSts = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $commonCaseId . "' AND isactive='1'");
                            if (isset($checkSts['0']) && count($checkSts['0']) > 0) {
                                if ($checkSts['0']['easycases']['legend'] == 3) {
                                    $done = 0;
                                }
                                if ($csLeg == 4) {
                                    if ($checkSts['0']['easycases']['legend'] == 4) {
                                        $done = 0;
                                    }
                                }
                                if ($csLeg == 5) {
                                    if ($checkSts['0']['easycases']['legend'] == 5) {
                                        $done = 0;
                                    }
                                }
                            } else {
                                $done = 0;
                            }
                            if ($done) {
                                $caseid_list .= $commonCaseId . ',';
                                $caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to')));
                                $caseStsId = $caseDataArr['Easycase']['id'];
                                $caseStsNo = $caseDataArr['Easycase']['case_no'];
                                $closeStsPid = $caseDataArr['Easycase']['project_id'];
                                $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                                $closeStsPri = $caseDataArr['Easycase']['priority'];
                                $closeStsTitle = $caseDataArr['Easycase']['title'];
                                $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                                $caUid = $caseDataArr['Easycase']['assign_to'];

                                $this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");
                                /* Delete previous RA **/
                                if ($this->Format->isResourceAvailabilityOn() && $csLeg == 3) {
                                    foreach ($casearr as $casek=>$casev) {
                                        $this->Format->delete_booked_hours(array('easycase_id' => $caseStsId, 'project_id' =>$closeStsPid));
                                    }
                                }
                                /* End */
                                $caseuniqid = $this->Format->generateUniqNumber();
                                $this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . SES_ID . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                                //$thisCaseId = mysql_insert_id();
                                //socket.io implement start

                                $this->ProjectUser->recursive = -1;
                                $getUser = $this->ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $closeStsPid . "'");
                                $prjuniq = $this->Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
                                $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
                                $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                                $channel_name = $prjuniqid;
                                
                                if ($csLeg == 3) {
                                    //on close of parent task close all children tasks
                                    $child_tasks = $this->Easycase->getSubTaskChild($commonCaseId, $caseDataArr['Easycase']['project_id']);
                                    if ($child_tasks) {
                                        $this->closerecursiveTaskFrmList($child_tasks['data'], $prjuniq);
                                    }
                                }

                                $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                                if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'osnewui16.com')) {
                                    $resCaseProj['iotoserver']= array('channel' => $channel_name, 'message' => $msgpub);
                                    //$this->Postcase->iotoserver(array('channel' => $channel_name, 'message' => $msgpub));
                                    //socket.io implement end
                                }
                            }
                        }
                    }
                }
            }
            $_SESSION['email']['email_body'] = $emailbody;
            $_SESSION['email']['msg'] = $msg;
            if ($caseChageType1 == 1) {
                $caseid_list = $commonAllId;
            } elseif ($caseChagePriority1 == 2) {
                $caseid_list = $commonAllId;
            } elseif ($caseChageDuedate1 == 3) {
                $caseid_list = $commonAllId;
            } elseif ($caseChangeAssignto1 == 4) {
                $caseid_list = $commonAllId;
            }
            $email_notification = array('allfiles' => $allfiles, 'caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg, 'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo, 'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid, 'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'caseUniqId' => $closeStsUniqId); // $caseuniqid

            $resCaseProj['email_arr'] = json_encode($email_notification);
        }

        if ($commonAllId) {
            $commonAllId = $commonAllId . ",";
            $commonArrId = explode(",", $commonAllId);
            $done = 1;
            if ($caseChageType1 || $caseChageDuedate1 || $caseChagePriority1 || $caseChangeAssignto1) {
            } else {
                $commonArrId_t = array_filter($commonArrId);
                foreach ($commonArrId as $commonCaseId) {
                    if (trim($commonCaseId)) {
                        /* dependency check start */
                        $allowed = "Yes";
                        $depends = $this->Easycase->find('first', array('conditions' => array('id' => $commonCaseId)));
                        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
                            $result = $this->Easycase->find('all', array('conditions' => array('id IN (' . $depends['Easycase']['depends'] . ')')));
                            if (is_array($result) && count($result) > 0) {
                                foreach ($result as $key => $parent) {
                                    if (($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) || ($parent['Easycase']['legend'] == 3)) {
                                        // NO ACTION
                                    } else {
                                        $allowed = "No";
                                    }
                                }
                            }
                        }
                        /* dependency check end */
                        if ($allowed == 'No') {
                            $resCaseProj['errormsg'] = __('Dependant tasks are not closed.', true);
                        } else {
                            $done = 1;
                            $checkSts = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $commonCaseId . "' AND isactive='1'");
                            if (isset($checkSts['0']) && count($checkSts['0']) > 0) {
                                if ($checkSts['0']['easycases']['legend'] == 3) {
                                    $done = 0;
                                }
                                if ($csLeg == 4) {
                                    if ($checkSts['0']['easycases']['legend'] == 4) {
                                        $done = 0;
                                    }
                                }
                                if ($csLeg == 5) {
                                    if ($checkSts['0']['easycases']['legend'] == 5) {
                                        $done = 0;
                                    }
                                }
                            } else {
                                $done = 0;
                            }
                            if ($done) {
                                $caseid_list .= $commonCaseId . ',';
                                $caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to')));
                                $caseStsId = $caseDataArr['Easycase']['id'];
                                $caseStsNo = $caseDataArr['Easycase']['case_no'];
                                $closeStsPid = $caseDataArr['Easycase']['project_id'];
                                $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                                $closeStsPri = $caseDataArr['Easycase']['priority'];
                                $closeStsTitle = $caseDataArr['Easycase']['title'];
                                $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                                $caUid = $caseDataArr['Easycase']['assign_to'];

                                $this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");
                                /* Delete previous RA **/
                                if ($this->Format->isResourceAvailabilityOn() && $csLeg == 3) {
                                    foreach ($casearr as $casek=>$casev) {
                                        $this->Format->delete_booked_hours(array('easycase_id' => $caseStsId, 'project_id' =>$closeStsPid));
                                    }
                                }
                                /* End */
                                $caseuniqid = $this->Format->generateUniqNumber();
                                $this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . SES_ID . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                                //$thisCaseId = mysql_insert_id();
                                //socket.io implement start

                                $this->ProjectUser->recursive = -1;
                                $getUser = $this->ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $closeStsPid . "'");
                                $prjuniq = $this->Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
                                $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
                                $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                                $channel_name = $prjuniqid;
                                
                                if ($csLeg == 3) {
                                    //on close of parent task close all children tasks
                                    $child_tasks = $this->Easycase->getSubTaskChild($commonCaseId, $caseDataArr['Easycase']['project_id']);
                                    if ($child_tasks) {
                                        $this->closerecursiveTaskFrmList($child_tasks['data'], $prjuniq);
                                    }
                                }

                                $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                                if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'osnewui16.com')) {
                                    $resCaseProj['iotoserver']= array('channel' => $channel_name, 'message' => $msgpub);
                                    //$this->Postcase->iotoserver(array('channel' => $channel_name, 'message' => $msgpub));
                                    //socket.io implement end
                                }
                            }
                        }
                    }
                }
            }
            $_SESSION['email']['email_body'] = $emailbody;
            $_SESSION['email']['msg'] = $msg;
            if ($caseChageType1 == 1) {
                $caseid_list = $commonAllId;
            } elseif ($caseChagePriority1 == 2) {
                $caseid_list = $commonAllId;
            } elseif ($caseChageDuedate1 == 3) {
                $caseid_list = $commonAllId;
            } elseif ($caseChangeAssignto1 == 4) {
                $caseid_list = $commonAllId;
            }
            $email_notification = array('allfiles' => $allfiles, 'caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg, 'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo, 'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid, 'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'caseUniqId' => $closeStsUniqId); // $caseuniqid

            $resCaseProj['email_arr'] = json_encode($email_notification);
        }
        $msQuery1 = " ";
        if (isset($caseMenuFilters) && $caseMenuFilters == "milestone") {
            $msQuery = "";
            if ($milestoneIds != "all" && strstr($milestoneIds, "-")) {
                $expMilestoneIds = explode("-", $milestoneIds);
                foreach ($expMilestoneIds as $msid) {
                    if ($msid) {
                        $msQuery.= "EasycaseMilestone.milestone_id=" . $msid . " OR ";
                    }
                }
                if ($msQuery) {
                    $msQuery = substr($msQuery, 0, -3);
                    $msQuery = " AND (" . $msQuery . ")";
                }
            } else {
                $tody = date('Y-m-d', strtotime("now"));
            }
        }

        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        $resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['csTtl'] = $caseTitle;
        $resCaseProj['csDuDt'] = $caseDueDate;
        $resCaseProj['csEstHrsSrt'] = $caseEstHours;
        $resCaseProj['csCrtdDt'] = $caseCreateDate;
        $resCaseProj['csNum'] = $caseNum;
        $resCaseProj['csLgndSrt'] = $caseLegendsort;
        $resCaseProj['csAtSrt'] = $caseAtsort;

        $resCaseProj['csPriSrt'] = $casePriority;
        $resCaseProj['csStusSrt'] = $caseStatusby;
        $resCaseProj['csUpdatSrt'] = $caseUpdatedby;

        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        $mileSton_names = array();
        $all_mileSton_names = array();
        $all_prj_names = null;
        if ($projUniq) {
            $page = $casePage;
            $limit1 = $page * $page_limit - $page_limit;
            $limit2 = $page_limit;
        }

        
        $fields = array('Easycase.id','Easycase.uniq_id','Easycase.case_no','Easycase.case_count','Easycase.project_id','Easycase.user_id','Easycase.updated_by','Easycase.type_id','Easycase.priority','Easycase.title','Easycase.estimated_hours','Easycase.hours','Easycase.completed_task','Easycase.assign_to','Easycase.gantt_start_date','Easycase.due_date','Easycase.istype','Easycase.client_status','Easycase.format','Easycase.status','Easycase.legend','Easycase.is_recurring','Easycase.isactive','Easycase.dt_created','Easycase.actual_dt_created','Easycase.reply_type','Easycase.is_chrome_extension','Easycase.from_email','Easycase.depends','Easycase.children','Easycase.temp_est_hours','Easycase.seq_id','Easycase.parent_task_id','Easycase.story_point','Easycase.thread_count','Easycase.custom_status_id','Easycase.parent_id','User.short_name','User.name','AssignTo.short_name','AssignTo.photo','AssignTo.name','AssignTo.last_name','Project.uniq_id','Project.name','CustomStatus.*','Type.name'
        );
        $clt_sql = ltrim(trim($clt_sql), 'AND');
        $cond_easycase_actuve = ltrim(trim($cond_easycase_actuve), 'AND');
        $curProjId = ltrim(trim($curProjId), 'AND');
        $searchcase = ltrim(trim($searchcase), 'AND');
        $qry = ltrim(trim($qry), 'AND');

        $conditions = array('Easycase.istype'=>1,$clt_sql,$cond_easycase_actuve,'Easycase.project_id<>0', $searchcase,$qry);

        if ($projUniq == 'all') {
            $allCSByProj = $this->Format->getStatusByProject('all');
            $conditions[]="Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "')";
        } else {
            $conditions['Easycase.project_id'] = $curProjId;
            $allCSByProj = $this->Format->getStatusByProject($curProjId);
        }


 
        $this->Easycase->bindModel(array('belongsTo' => array(
                'User'=>array('className'=>'User','foreignKey'=>'user_id'),
                'AssignTo'=>array('className'=>'User','foreignKey'=>'assign_to'),
                'CustomStatus',
                'Project',
                'Type'
            )));
        //added to fix the task group  page sub task view loading issue
        $orderby = trim($orderby, ' , ');
                
        $resCaseProj = $this->Easycase->find('threaded', array('conditions'=>$conditions,'fields'=>$fields,'order'=>$orderby)); //,'limit'=>$limit2,'offset'=>$limit1
        $allcaseCount = $this->Easycase->find('count', array('conditions'=>$conditions,'order'=>$orderby));
        $totPages = ($allcaseCount/$page_limit);
        $totPages = ceil($totPages);
        foreach ($resCaseProj as $k=>$v) {
            if ($v['Easycase']['due_date'] && $v['Easycase']['due_date'] != '0000-00-00 00:00:00') {
                $formated_due_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['due_date'], "date");
                if ($v['Easycase']['gantt_start_date'] && $v['Easycase']['gantt_start_date'] != '0000-00-00 00:00:00') {
                    $gantt_start_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['gantt_start_date'], "date");
                    $resCaseProj[$k]['Easycase']['formated_due_date'] = date('M d', strtotime($gantt_start_date)).' - '.date('d', strtotime($formated_due_date));
                } else {
                    $resCaseProj[$k]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                }
            } else {
                $resCaseProj[$k]['Easycase']['formated_due_date'] = '';
            }
            if (count($v['children'])) {
                foreach ($v['children'] as $k1=>$v1) {
                    if ($v1['Easycase']['due_date'] && $v1['Easycase']['due_date'] != '0000-00-00 00:00:00') {
                        $formated_due_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v1['Easycase']['due_date'], "date");
                        if ($v1['Easycase']['gantt_start_date'] && $v1['Easycase']['gantt_start_date'] != '0000-00-00 00:00:00') {
                            $gantt_start_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v1['Easycase']['gantt_start_date'], "date");
                            $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] = date('M d', strtotime($gantt_start_date)).' - '.date('d', strtotime($formated_due_date));
                        } else {
                            $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                        }
                    } else {
                        $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] ='';
                    }
                }
                if (count($v1['children'])) {
                    foreach ($v1['children'] as $k2=>$v2) {
                        if ($v2['Easycase']['due_date'] && $v2['Easycase']['due_date'] != '0000-00-00 00:00:00') {
                            $formated_due_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v2['Easycase']['due_date'], "date");
                            if ($v2['Easycase']['gantt_start_date'] && $v2['Easycase']['gantt_start_date'] != '0000-00-00 00:00:00') {
                                $gantt_start_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v2['Easycase']['gantt_start_date'], "date");
                                $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = date('M d', strtotime($gantt_start_date)).' - '.date('d', strtotime($formated_due_date));
                            } else {
                                $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                            }
                        } else {
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = '';
                        }
                    }
                }
            }
        }
        $customStatusByProject = array();
        if (isset($allCSByProj)) {
            foreach ($allCSByProj as $k=>$v) {
                if (isset($v['StatusGroup']['CustomStatus'])) {
                    $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                }
            }
        }
        $resultArr['resCaseProj'] = $resCaseProj;
        $resultArr['casePage'] = $casePage;
        $resultArr['totPages'] = $totPages;
        $resultArr['customStatusByProject'] = $customStatusByProject;
        $resultArr['projUniq'] = $projUniq;
        $resultArr['curProjId'] = $curProjId;
        echo json_encode($resultArr);
        exit;
    }
            
    public function loadTaskGroup()
    {
        $this->layout = 'ajax';
        ############Decleration of Variables ###############
        $resCaseProj = array();
        $page_limit = TASK_GROUP_CASE_PAGE_LIMIT;
        $this->_datestime();
        $projUniq = $this->params->data['projFil']; // Project Uniq ID
        $projIsChange = $this->params->data['projIsChange']; // Project Uniq ID
        $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
        $caseCustomStatus = $this->params->data['caseCustomStatus']; // Filter by Status(legend)
        $priorityFil = $this->params->data['priFil']; // Filter by Priority
        $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
        $caseLabel = $this->params->data['caseLabel']; // Filter by case Label
        $caseUserId = $this->params->data['caseMember']; // Filter by Member
        $caseComment = $this->params->data['caseComment']; // Filter by Member
        $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
        $caseDate = $this->params->data['caseDate']; // Sort by Date
        $caseDueDate = $this->params->data['caseDueDate']; // Sort by Due Date
        $caseEstHours = $this->params->data['caseEstHours']; // Sort by Estimated Hours
        @$case_duedate = $this->params->data['case_due_date'];
        @$case_date = urldecode($this->params->data['case_date']);
        $caseSrch = $this->params->data['caseSearch']; // Search by keyword

        $casePage = 1;//$this->params->data['casePage']; // Pagination
        $caseUniqId = $this->params->data['caseId']; // Case Uniq ID to close a case
        $caseTitle = $this->params->data['caseTitle']; // Case Uniq ID to close a case
        $caseNum = $this->params->data['caseNum']; // Sort by Due Date
        $caseLegendsort = $this->params->data['caseLegendsort']; // Sort by Case Status
        $caseAtsort = $this->params->data['caseAtsort']; // Sort by Case Status
        $startCaseId = $this->params->data['startCaseId']; // Start Case
        $caseResolve = $this->params->data['caseResolve']; // Resolve Case
        $caseMenuFilters = $this->params->data['caseMenuFilters']; // Resolve Case
        $milestoneIds = $this->params->data['milestoneIds']; // Resolve Case
        $caseNew = $this->params->data['caseNew']; // New Case
        $caseCreateDate = $this->params->data['caseCreateDate']; // Sort by Created Date
        @$case_srch = $this->params->data['case_srch'];
        @$milestone_type = $this->params->data['mstype'];
        $changecasetype = $this->params->data['caseChangeType'];
        $caseChangeDuedate = $this->params->data['caseChangeDuedate'];
        $caseChangePriority = $this->params->data['caseChangePriority'];
        $caseChangeAssignto = $this->params->data['caseChangeAssignto'];
        $customfilterid = $this->params->data['customfilter'];
        $detailscount = $this->params->data['detailscount']; // Count number to open casedetails
        $searchMilestoneUid = $this->params->data['searchMilestoneUid']; // Search Milestone Unique Id wise
        $filterenabled = 0;
        $clt_sql = 1;
        
        $this->loadModel('Projects');
        $prj = $this->Project->getProjectFields(array("Project.uniq_id" => $projUniq), array("Project.id","Project.task_type"));
        $defaultTaskType = $prj['Project']['task_type'];
        
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
            $sortbygroup = $_COOKIE['TASKSORTBY2'];
            $sortorder = $_COOKIE['TASKSORTORDER'];
            $sortordergroup = $_COOKIE['TASKSORTORDER2'];
        } else {
            $sortorder = 'DESC';
        }
        $orderbyMilestone = '';
        if ($sortbygroup == 'title') {
            $orderbyMilestone = "LTRIM(Milestone.title) " . $sortordergroup;
            $casegroupTitle = strtolower($sortordergroup);
        } else {
            $orderbyMilestone = "Milestone.id_seq ASC,EasycaseMilestone.m_order ASC";
        }

        if ($sortby == 'title') {
            // $orderby = "LTRIM(Easycase.title) " . $sortorder;
            $caseTitle = strtolower($sortorder);
        } elseif ($sortby == 'duedate') {
            $caseDueDate = strtolower($sortorder);
        //  $orderby = "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'estimatedhours') {
            $caseEstHours = strtolower($sortorder);
        //  $orderby = "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $caseNum = strtolower($sortorder);
        // $orderby = "Easycase.id " . $sortorder;
        } elseif ($sortby == 'caseAt') {
            $caseAtsort = strtolower($sortorder);
        // $orderby = "Assigned " . $sortorder;
        } elseif ($sortby == 'priority') {
            $casePriority = strtolower($sortorder);
        // $orderby = "Easycase.priority " . $sortorder;
        } elseif ($sortby == 'status') {
            $caseStatusby = strtolower($sortorder);
        //   $orderby = "Easycase.legend " . $sortorder;
        } else {
            $caseUpdatedby = strtolower($sortorder);
            //$orderby = "Easycase.dt_created DESC";
            //   $orderby=" Milestone.id_seq ASC,EasycaseMilestone.m_order ASC ";
        }
        #pr ($orderby);exit;
        #################End of Order by#################################
        ######## get project ID from project uniq-id ################
        $curProjId = null;
        $curProjShortName = null;
        
        if ($projUniq != 'all') {
            $this->loadModel('ProjectUser');
            $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
            $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            if (count($projArr)) {
                $curProjId = $projArr['Project']['id'];
                $curProjShortName = $projArr['Project']['short_name'];


                if ($projIsChange != $projUniq) {
                    $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                    $ProjectUser['dt_visited'] = GMT_DATETIME;
                    $this->ProjectUser->save($ProjectUser);
                }
            }
        }
        ######## End of  project ID from project uniq-id ################
        ##########Set the result array for search and pagination variables ##################
        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        //$resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['csTtl'] = $caseTitle;
        $resCaseProj['csTtl2'] = $casegroupTitle;
        $resCaseProj['csDuDt'] = $caseDueDate;
        $resCaseProj['csEstHrsSrt'] = $caseEstHours;
        $resCaseProj['csCrtdDt'] = $caseCreateDate;
        $resCaseProj['csNum'] = $caseNum;
        $resCaseProj['csLgndSrt'] = $caseLegendsort;
        $resCaseProj['csAtSrt'] = $caseAtsort;


        $resCaseProj['csPriSrt'] = $casePriority;
        $resCaseProj['csStusSrt'] = $caseStatusby;
        $resCaseProj['csUpdatSrt'] = $caseUpdatedby;

        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        ##########End the result array for search and pagination variables ##################
        ################Filter Starts#################################
        $qry = '';
        $all_rest = '';
        $qry_rest = '';
        $searchMilestone = "";
        #######################Search by filter Date#######################
        if (!$this->Format->isAllowed('View All Task', $roleAccess)) {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }
        if (trim($case_date) != "") {
            if ((SES_COMP == 25814 || SES_COMP == 28528 || SES_COMP == 1358) && (trim($caseComment) && $caseComment != "all")) {
                // Modified for jayan (if date filter with commented by filter is applied then now apply the date filter in the parent task)
            } else {
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                if (trim($case_date) == 'one') {
                    $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
                } elseif (trim($case_date) == '24') {
                    $filterenabled = 1;
                    $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
                } elseif (trim($case_date) == 'week') {
                    $filterenabled = 1;
                    $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
                } elseif (trim($case_date) == 'month') {
                    $filterenabled = 1;
                    $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
                } elseif (trim($case_date) == 'year') {
                    $filterenabled = 1;
                    $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
                } elseif (strstr(trim($case_date), ":")) {
                    $filterenabled = 1;
                    $ar_dt = explode(":", trim($case_date));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
                    //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }
        }

        ##################Filter By Taskgroup Status###############
        if (isset($_COOKIE['TASKGROUP_FIL']) && $_COOKIE['TASKGROUP_FIL']) {
            if (trim($_COOKIE['TASKGROUP_FIL']) == 'active') {
                $searchMilestone.= " AND (Milestone.isactive ='1')";
            } elseif (trim($_COOKIE['TASKGROUP_FIL']) == 'completed') {
                $searchMilestone.= " AND (Milestone.isactive ='0')";
            }
        }
        #####################Filter By Case due date##############3##
        if (trim($case_duedate) != "") {
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if (trim($case_duedate) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
            } elseif (trim($case_duedate) == 'overdue') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) ";
            } elseif (strstr(trim($case_duedate), ":") && trim($case_duedate) !== '0000-00-00 00:00:00') {
                $filterenabled = 1;
                $ar_dt = explode(":", trim($case_duedate));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        ######### Filter by CaseUniqId ##########$qry = "";
        if (trim($caseUrl)) {
            $filterenabled = 1;
            $qry.= " AND Easycase.uniq_id='" . $caseUrl . "'";
        }
        $is_def_status_enbled = 0;
        ######### Filter by Custom Status ##########
        if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
            $is_def_status_enbled = 1;
            $filterenabled = 1;
            $qry.= " AND (";
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus, 1);
            $stsLegArr = $caseCustomStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
        }
        ######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
            if (!$is_def_status_enbled) {
                $qry.= " AND (";
            } else {
                $qry.= " OR ";
            }
            $qry.= $this->Format->statusFilter($caseStatus, '', 1);
            $qry .= ")";
            $stsLegArr = $caseStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
            if (!in_array("upd", $expStsLeg)) {
                $qry.= " AND Easycase.type_id !=10";
            }
        } else {
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                $qry .= ")";
            }
        }
        /*######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
            $qry.= $this->Format->statusFilter($caseStatus);
            $stsLegArr = $caseStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
            if (!in_array("upd", $expStsLeg)) {
                $qry.= " AND Easycase.type_id !=10";
            }
        }
                ######### Filter by Custom Status ##########
        if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
            $filterenabled = 1;
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus);
            $stsLegArr = $caseCustomStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
        }*/
        ######### Filter by Case Types ##########
        if (trim($caseTypes) && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Case Label ##########
        if (trim($caseLabel) && $caseLabel != "all") {
            $qry.= $this->Format->labelFilter($caseLabel, $curProjId, SES_COMP, SES_TYPE, SES_ID);
        }
        ######### Filter by Priority ##########
        if (trim($priorityFil) && $priorityFil != "all") {
            $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseUserId) && $caseUserId != "all") {
            $qry.= $this->Format->memberFilter($caseUserId);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseComment) && $caseComment != "all") {
            $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
            $filterenabled = 1;
        }
        #########memberFilter Filter by AssignTo ##########
        if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
            $qry.= $this->Format->assigntoFilter($caseAssignTo);
            $filterenabled = 1;
        } elseif (trim($caseAssignTo) == "unassigned") {
            $qry.= " AND Easycase.assign_to='0'";
            $filterenabled = 1;
        }
        
    
        ######### Filter by $caseMenuFilters ##########
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        } elseif ($caseMenuFilters == "favourite") {
            if ($projUniq != 'all') {
                $this->loadModel('ProjectUser');
                $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
                if (count($projArr)) {
                    $curProjId = $projArr['Project']['id'];
                    $curProjShortName = $projArr['Project']['short_name'];
                    $conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                    $this->loadModel('EasycaseFavourite');
                    $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                    //if(!empty($easycase_favourite)){
                    $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."') ";
                    //}
                }
            } else {
                $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                $this->loadModel('EasycaseFavourite');
                $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                // if(!empty($easycase_favourite)){
                $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."') ";
                // }
            }
        }
        ######### Filter by Delegate To ##########
        elseif ($caseMenuFilters == "delegateto") {
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
        } elseif ($caseMenuFilters == "closecase") {
            $qry.= " AND (Easycase.legend='3' OR Easycase.legend='5') AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "closedtasks") {
            $qry.= " AND (Easycase.legend='3' OR Easycase.legend='5') AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "overdue") {
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date != '0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND Easycase.due_date < '" . $cur_dt . "' AND (Easycase.legend !=3) ";
        } elseif ($caseMenuFilters == "highpriority") {
            $qry.= " AND Easycase.priority ='0' ";
        } elseif ($caseMenuFilters == "newwip") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2')  AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilters == "openedtasks") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='4')  AND Easycase.type_id !='10'";
        }
        ######### Filter by Latest ##########
        elseif ($caseMenuFilters == "latest") {
            $filterenabled = 1;
            $qry_rest = $qry;
            $before = date('Y-m-d H:i:s', strtotime(GMT_DATETIME . "-2 day"));
            $all_rest = " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            $qry_rest.= " AND Easycase.dt_created > '" . $before . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
        }
        if ($caseMenuFilters == "latest" && $projUniq != 'all') {
            $CaseCount3 = $this->Easycase->query("SELECT COUNT(Easycase.id) as count FROM easycases as Easycase WHERE istype='1' " . $cond_easycase_actuve . " AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  " . $searchcase . " " . trim($qry_rest));
            $CaseCount = $CaseCount3['0']['0']['count'];
            if ($CaseCount == 0) {
                $rest = $this->Easycase->query("SELECT dt_created FROM easycases WHERE project_id ='" . $curProjId . "' ORDER BY dt_created DESC LIMIT 0 , 1");
                @$sdate = explode(" ", @$rest[0]['easycases']['dt_created']);
                $qry.= " AND Easycase.dt_created >= '" . @$sdate[0] . "' AND Easycase.dt_created <= '" . GMT_DATETIME . "'";
            } else {
                $qry = $qry . $all_rest;
            }
        } elseif ($caseMenuFilters == "latest" && $projUniq == 'all') {
            $qry = $qry . $all_rest;
        }

        #####Update status of tasks ###############
        ######### Close a Case ##########
        if ($changecasetype) {
            $caseid = $changecasetype;
        } elseif ($caseChangeDuedate) {
            $caseid = $caseChangeDuedate;
        } elseif ($caseChangePriority) {
            $caseid = $caseChangePriority;
        } elseif ($caseChangeAssignto) {
            $caseid = $caseChangeAssignto;
        }
        if ($caseid) {
            $checkStatus = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $caseid . "' AND isactive='1'");
            if ($checkStatus['0']['easycases']['legend'] == 1) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#763532" style="font:normal 12px verdana;">NEW</font>';
            } elseif ($checkStatus['0']['easycases']['legend'] == 4) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            } elseif ($checkStatus['0']['easycases']['legend'] == 5) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            } elseif ($checkStatus['0']['easycases']['legend'] == 3) {
                $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            }
        }
         /* Start Code for adding ACF when status changed to close */
        if(!empty($caseUniqId)){           
            $saveAdvCustomFields = $this->Easycase->advCustomFieldAction($caseUniqId);

           if ($saveAdvCustomFields) {
                $resCaseProj['advancedCustomFieldSave'] = 'success';
            } else {
                $resCaseProj['advancedCustomFieldSave'] = 'error';
            }                                                            
        }
        /* End Code for adding ACF when status changed to close */
        //echo $startCaseId."---".$caseResolve."---".$caseUniqId."----".$caseNew;exit;
        $commonAllId = "";
        $caseid_list = '';
        if ($startCaseId) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $startCaseId;
            $emailType = "Start";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font> the Task.';
        } elseif ($caseResolve) {
            $csSts = 1;
            $csLeg = 5;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseResolve;
            $emailType = "Resolve";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = '<font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font> the Task.';
        } elseif ($caseNew) {
            $csSts = 1;
            $csLeg = 1;
            $acType = 3;
            $cuvtype = 5;
            $commonAllId = $caseNew;
            $emailType = "New";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
            $emailbody = 'Changed the status of the task to<font color="#F08E83" style="font:normal 12px verdana;">NEW</font>.';
        } elseif ($caseUniqId) {
            $csSts = 2;
            $csLeg = 3;
            $acType = 1;
            $cuvtype = 3;
            $commonAllId = $caseUniqId;
            $emailType = "Close";
            $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
            $emailbody = '<font color="green" style="font:normal 12px verdana;">CLOSED</font> the Task.';
        } elseif ($changecasetype) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $changecasetype;
            $emailType = "Change Type";
            $caseChageType1 = 1;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the type of</font> the Task.';
        } elseif ($caseChangeDuedate) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeDuedate;
            $emailType = "Change Duedate";
            $caseChageDuedate1 = 3;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the due date of</font> the Task.';
        } elseif ($caseChangePriority) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangePriority;
            $emailType = "Change Priority";
            $caseChagePriority1 = 2;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the priority of</font> the Task.';
        } elseif ($caseChangeAssignto) {
            $csSts = 1;
            $csLeg = 4;
            $acType = 2;
            $cuvtype = 4;
            $commonAllId = $caseChangeAssignto;
            $emailType = "Change Assignto";
            $caseChangeAssignto1 = 4;
            $msg = $status;
            $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the assigned to of</font> the Task.';
        }
        if ($commonAllId) {
            $commonAllId = $commonAllId . ",";
            $commonArrId = explode(",", $commonAllId);
            $done = 1;
            if ($caseChageType1 || $caseChageDuedate1 || $caseChagePriority1 || $caseChangeAssignto1) {
            } else {
                foreach ($commonArrId as $commonCaseId) {
                    if (trim($commonCaseId)) {
                        /* dependency check start */
                        $allowed = "Yes";
                        $depends = $this->Easycase->find('first', array('conditions' => array('id' => $commonCaseId)));
                        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
                            $result = $this->Easycase->find('all', array('conditions' => array('id IN (' . $depends['Easycase']['depends'] . ')')));
                            if (is_array($result) && count($result) > 0) {
                                foreach ($result as $key => $parent) {
                                    if (($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) || ($parent['Easycase']['legend'] == 3)) {
                                        // NO ACTION
                                    } else {
                                        $allowed = "No";
                                    }
                                }
                            }
                        }
                        /* dependency check end */
                        if ($allowed == 'No') {
                            $resCaseProj['errormsg'] = __('Dependant tasks are not closed.', true);
                        } else {
                            $done = 1;
//                            $checkSts = $this->Easycase->query("SELECT legend FROM easycases WHERE id='" . $commonCaseId . "' AND isactive='1'");
//                            if (isset($checkSts['0']) && count($checkSts['0']) > 0) {
//                                if ($checkSts['0']['easycases']['legend'] == 3) {
//                                    $done = 0;
//                                }
//                                if ($csLeg == 4) {
//                                    if ($checkSts['0']['easycases']['legend'] == 4) {
//                                        $done = 0;
//                                    }
//                                }
//                                if ($csLeg == 5) {
//                                    if ($checkSts['0']['easycases']['legend'] == 5) {
//                                        $done = 0;
//                                    }
//                                }
//                            } else {
//                                $done = 0;
//                            }
                            if ($done) {
                                $caseid_list .= $commonCaseId . ',';
                                $caseDataArr = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $commonCaseId), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.assign_to')));

                                $caseStsId = $caseDataArr['Easycase']['id'];
                                $caseStsNo = $caseDataArr['Easycase']['case_no'];
                                $closeStsPid = $caseDataArr['Easycase']['project_id'];
                                $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                                $closeStsPri = $caseDataArr['Easycase']['priority'];
                                $closeStsTitle = $caseDataArr['Easycase']['title'];
                                $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                                $caUid = $caseDataArr['Easycase']['assign_to'];

                                $this->Easycase->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "' WHERE id=" . $caseStsId . " AND isactive='1'");

                                /* Delete previous RA **/
                                if ($this->Format->isResourceAvailabilityOn() && $csLeg == 3) {
                                    foreach ($casearr as $casek=>$casev) {
                                        $this->Format->delete_booked_hours(array('easycase_id' => $caseStsId, 'project_id' =>$closeStsPid));
                                    }
                                }
                                /* End */
                                $caseuniqid = $this->Format->generateUniqNumber();
                                $this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . SES_ID . "', format='2', istype='2', actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                                //$thisCaseId = mysql_insert_id();
                                //socket.io implement start

                                $this->ProjectUser->recursive = -1;
                                $getUser = $this->ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $closeStsPid . "'");
                                $prjuniq = $this->Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
                                $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
                                $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                                $channel_name = $prjuniqid;
                                //$pname = $this->Format->getProjectName($closeStsPid);
                                //$msg = "'Case Started in ".$pname."'";
                                if ($csLeg == 3) {
                                    //on close of parent task close all children tasks
                                    $child_tasks = $this->Easycase->getSubTaskChild($commonCaseId, $caseDataArr['Easycase']['project_id']);
                                    if ($child_tasks) {
                                        $this->closerecursiveTaskFrmList($child_tasks['data'], $prjuniq);
                                    }
                                }
                                $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                                if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'orangegigs.com')) {
                                    $resCaseProj['iotoserver']= array('channel' => $channel_name, 'message' => $msgpub);
                                    //$this->Postcase->iotoserver(array('channel' => $channel_name, 'message' => $msgpub));
                                    //socket.io implement end
                                }

                                $CaseActivity = ClassRegistry::init('CaseActivity');
                                $CaseActivity->recursive = -1;
                                $CaseAct['easycase_id'] = $thisCaseId;
                                $CaseAct['user_id'] = SES_ID;
                                $CaseAct['project_id'] = $closeStsPid;
                                $CaseAct['case_no'] = $caseStsNo;
                                $CaseAct['type'] = $csLeg;
                                $CaseAct['dt_created'] = GMT_DATETIME;
                                //$CaseActivity->saveAll($CaseAct);
                            }
                        }
                    }
                }
            }
            $_SESSION['email']['email_body'] = $emailbody;
            $_SESSION['email']['msg'] = $msg;
            if ($caseChageType1 == 1) {
                $caseid_list = $commonAllId;
            } elseif ($caseChagePriority1 == 2) {
                $caseid_list = $commonAllId;
            } elseif ($caseChageDuedate1 == 3) {
                $caseid_list = $commonAllId;
            } elseif ($caseChangeAssignto1 == 4) {
                $caseid_list = $commonAllId;
            }
            $email_notification = array('allfiles' => $allfiles, 'caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg, 'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo, 'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid, 'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'caseUniqId' => $closeStsUniqId); // $caseuniqid

            $resCaseProj['email_arr'] = json_encode($email_notification);
        }
        #End of Update tasks#############
        ###############Searching Conditions ##############
        $searchMilestone_dflt = '';
        if (!empty($caseSrch)) {
            $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
            $qry .= $searchcase;
            $searchMilestone_dflt = $searchcase;
            $searchMilestone .= " AND (Milestone.title like '%" . $caseSrch . "%' OR EasycaseMilestone.milestone_id = Milestone.id) ";
        } elseif (!empty($searchMilestoneUid)) {
            $searchMilestone .= " AND Milestone.uniq_id='" . $searchMilestoneUid . "' ";
            $searchMilestone_dflt = " AND Easycase.uniq_id='" . $searchMilestoneUid . "' ";
        }
        #$searchMilestone .=$qry;
        ###############End of Searching Conditions ##############
        $page = $casePage;
        //    $limit1 = $page * $page_limit - $page_limit;
        //    $limit2 = $page_limit;
        //    $sql1 = " SELECT SQL_CALC_FOUND_ROWS ";
        $limit1 = !empty($this->params->data["limit1"])?$this->params->data["limit1"]:0;
        $limit2 = !empty($this->params->data["limit2"])?$this->params->data["limit2"]:20;
        $sql1 = " SELECT SQL_CALC_FOUND_ROWS ";
        $fields = " Milestone.*,EasycaseMilestone.milestone_id as mid, EasycaseMilestone.m_order,User.short_name,IF((Milestone.user_id =" . SES_ID . "),'Me',User.short_name) AS Assigned,EasycaseMilestone.cnt as count ,IF(EasycaseMilestone.cnt IS NULL,0,EasycaseMilestone.cnt) AS cnt ";
        $count = " COUNT(DISTINCT Milestone.id) as caseCount ";

        $sql2 = " FROM milestones AS Milestone LEFT JOIN users User ON Milestone.user_id=User.id "
                . "LEFT JOIN (SELECT count(*) as cnt , EM.milestone_id,EM.m_order from easycase_milestones as EM Left join easycases as Easycase ON EM.easycase_id=Easycase.id WHERE EM.project_id=".$curProjId." AND Easycase.isactive=1 AND  Easycase.istype=1 {$qry} GROUP BY EM.milestone_id ) as EasycaseMilestone ON Milestone.id=EasycaseMilestone.milestone_id ";
        $sql_default = " FROM milestones AS Milestone LEFT JOIN users User ON Milestone.user_id=User.id "
                . "LEFT JOIN (SELECT count(*) as cnt , EM.milestone_id,EM.m_order from easycase_milestones as EM Left join easycases as Easycase ON EM.easycase_id=Easycase.id  WHERE EM.project_id=".$curProjId." AND Easycase.isactive=1 AND  Easycase.istype=1 GROUP BY EM.milestone_id ) as EasycaseMilestone ON Milestone.id=EasycaseMilestone.milestone_id ";
        $where = " WHERE Milestone.project_id='" . $curProjId . "' ";
        $groupby = " GROUP BY Milestone.id ";
    
        #print $sql1.$fields.$sql2.$where.$searchMilestone.$groupby." ORDER BY ".$orderbyMilestone." LIMIT $limit1,$limit2";exit;
        if (!empty($curProjId)) {
            //  $caseCount = $this->Milestone->query($sql1 . $count . $sql2 . $where); /*commted by Tapan sir */
      
            $sql1_new = " SELECT SQL_CALC_FOUND_ROWS  COUNT(DISTINCT Milestone.id) as caseCount  FROM milestones AS Milestone ";
            $where_new = " WHERE Milestone.project_id='" . $curProjId . "' ";
            $caseCount = $this->Milestone->query($sql1_new. $where_new);
            $resCaseProj['caseCount'] = $caseCount[0][0]['caseCount'];
        } else {
            $resCaseProj['caseCount'] = 0;
        }
                
        //  $resCaseProj['caseCount'] = $caseCount[0][0]['caseCount'];
        $resCaseProj['GrpBy'] = 'milestone';
        //$caseMenuFilters='milestone';
        
        if (!empty($curProjId)) {
            $caseAll = $this->Milestone->query($sql1 . $fields . $sql2 . $where . $searchMilestone . $groupby . " ORDER BY " . $orderbyMilestone . " LIMIT $limit1,$limit2");
        } else {
            $caseAll=array();
        }
    
        $lastcount = count($caseAll);
        if ($lastcount) {
            foreach ($caseAll as $k => $v) {
                $caseAll[$k]['Milestone']['estimated_hours'] = $this->Format->formatTGMeta($v['Milestone']['estimated_hours'], 'est');
                $caseAll[$k]['Milestone']['start_date'] = $this->Format->formatTGMeta($v['Milestone']['start_date'], 'sdate');
                $caseAll[$k]['Milestone']['end_date'] = $this->Format->formatTGMeta($v['Milestone']['end_date'], 'edate');
            }
        }

            
        //pr($caseAll);exit;
        if ($limit1 == 0) {
            $caseAll[$lastcount]['Milestone']['id'] = 0;
            $caseAll[$lastcount]['Milestone']['uniq_id'] = 0;
            $caseAll[$lastcount]['Milestone']['project_id'] = $curProjId;
            $caseAll[$lastcount]['Milestone']['company_id'] = 0;
            $caseAll[$lastcount]['Milestone']['title'] = 'Default Task Group';
            $caseAll[$lastcount]['Milestone']['description'] = '';
            $caseAll[$lastcount]['Milestone']['user_id'] = '';
            $caseAll[$lastcount]['Milestone']['start_date'] = '';
            $caseAll[$lastcount]['Milestone']['end_date'] = '';
            $caseAll[$lastcount]['Milestone']['estimated_hours'] = '';
            $caseAll[$lastcount]['Milestone']['modified'] = '';
            $caseAll[$lastcount]['Milestone']['isactive'] = '1';
            $caseAll[$lastcount]['Milestone']['id_seq'] = '1';
            $caseAll[$lastcount]['EasycaseMilestone']['mid'] = 0;
            $caseAll[$lastcount]['User']['short_name'] = '';
            $caseAll[$lastcount][0]['Assigned'] = '';
            if (!empty($curProjId)) {
                $cntdefault = $this->Easycase->query("select count(*) as cnt from easycases as Easycase left join easycase_milestones as EasycaseMilestone on Easycase.id=EasycaseMilestone.easycase_id left join milestones as Milestone on Milestone.id=EasycaseMilestone.milestone_id WHERE Easycase.id NOT in (select EasycaseMilestones.easycase_id from easycase_milestones as EasycaseMilestones WHERE EasycaseMilestones.project_id='" . $curProjId . "') and Easycase.isactive='1'and Easycase.istype='1' {$qry}  and  Easycase.project_id='" . $curProjId . "' $searchMilestone_dflt");
                $caseAll[$lastcount][0]['cnt'] = $cntdefault[0][0]['cnt'];
                $caseAll[$lastcount]['Milestone']['count_tasks'] = $cntdefault[0][0]['cnt'];
            } else {
                $caseAll[$lastcount][0]['cnt'] = 0;
                $caseAll[$lastcount]['Milestone']['count_tasks'] =0;
            }
            # pr("select count(*) as cnt from easycases as Easycase left join easycase_milestones as EasycaseMilestone on Easycase.id=EasycaseMilestone.easycase_id left join milestones as Milestone on Milestone.id=EasycaseMilestone.milestone_id WHERE Easycase.id NOT in (select EasycaseMilestones.easycase_id from easycase_milestones as EasycaseMilestones WHERE EasycaseMilestones.project_id='".$curProjId."') and Easycase.isactive='1'and Easycase.istype='1' and  Easycase.project_id='".$curProjId."' $searchMilestone");exit;
        }
        $m = array();
        $c = array();
        $mid = '';
        if (!empty($curProjId)) {
            $caseAll_default = $this->Milestone->query($sql1 . $fields . $sql_default . $where . $groupby . " ORDER BY " . $orderbyMilestone . " LIMIT $limit1,$limit2");
        } else {
            $caseAll_default =array();
        }
        foreach ($caseAll_default as $k => $v) {
            $mid.= $v['Milestone']['id'] . ',';
            $m[$v['Milestone']['id']]['id'] = $v['Milestone']['id'];
            $m[$v['Milestone']['id']]['caseids'] = 0;
            $m[$v['Milestone']['id']]['totalcases'] = $v[0]['cnt'];
            $m[$v['Milestone']['id']]['title'] = $v['Milestone']['title'];
            $m[$v['Milestone']['id']]['project_id'] = $v['Milestone']['project_id'];
            $m[$v['Milestone']['id']]['end_date'] = $v['Milestone']['end_date'];
            $m[$v['Milestone']['id']]['uinq_id'] = $v['Milestone']['uniq_id'];
            $m[$v['Milestone']['id']]['isactive'] = $v['Milestone']['isactive'];
            $m[$v['Milestone']['id']]['user_id'] = $v['Milestone']['user_id'];
        }

        if ($mid) {
            $closed_cases = $this->Easycase->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN (" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
            foreach ($closed_cases as $key => $val) {
                $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
            }
        }
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
        $cq = $view->loadHelper('Casequery');
        $frmt = $view->loadHelper('Format');
        if (!empty($curProjId)) {
            $frmtCaseAll = $this->Easycase->formatCases($caseAll, ($caseCount[0][0]['caseCount'] + 1), $caseMenuFilters, $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq);
        } else {
            $frmtCaseAll =array();
        }
        $resCaseProj['all_milesto_names'] = !empty($frmtCaseAll['caseAll'])?$frmtCaseAll['caseAll']:array(); //$caseAll;
        $pgShLbl = $frmt->pagingShowRecords($caseCount[0][0]['caseCount'], $page_limit, $casePage);
        $resCaseProj['pgShLbl'] = $pgShLbl;
        $resCaseProj['case_date'] = $case_date;
        $resCaseProj['caseStatus'] = $caseStatus;
        $resCaseProj['priorityFil'] = $priorityFil;
        $resCaseProj['caseTypes'] = $caseTypes;
        $resCaseProj['caseUserId'] = $caseUserId;
        $resCaseProj['caseComment'] = $caseComment;
        $resCaseProj['caseAssignTo'] = $caseAssignTo;
        $resCaseProj['case_duedate'] = $case_duedate;
        $resCaseProj['caseSrch'] = $caseSrch;
        $field_name_arr = array("All", "Priority", "Updated", "Assigned to", "Status", "Due Date");
        $this->loadModel('TaskField');
        $field_name_arr = array();
        $fields = $this->TaskField->find('first', array('conditions' => array('TaskField.user_id' => SES_ID)));
        if (!empty($fields)) {
            $field_name_arr = json_decode($fields['TaskField']['field_name'], true);
        }
        $allCSByProj = $this->Format->getStatusByProject($curProjId);
        $customStatusByProject = array();
        if (isset($allCSByProj)) {
            foreach ($allCSByProj as $k=>$v) {
                if (isset($v['StatusGroup']['CustomStatus'])) {
                    $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                }
            }
        }
        $resCaseProj['customStatusByProject'] = $customStatusByProject;
        $resCaseProj['curProjId'] = $curProjId;
        
        $resCaseProj['field_name_arr'] = $field_name_arr;
        $this->set('resCaseProj', json_encode($resCaseProj));
    }
    public function loadTaskByTaskgroup()
    {
        $this->layout = 'ajax';
        $curProjId = $this->params->data['pid'];
        $mid = $this->params->data['mid'];
        $this->loadModel("Easycase");
        $this->Easycase->Behaviors->enable('Tree');
        $this->Easycase->virtualFields['parent_id'] = 'Easycase.parent_task_id';
        $this->LoadModel('Milestone');
        ############Decleration of Variables ###############
        $resCaseProj = array();
        $this->_datestime();
        $projUniq = $this->params->data['projFil']; // Project Uniq ID
        $projIsChange = $this->params->data['projIsChange']; // Project Uniq ID
        $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
        $caseCustomStatus = $this->params->data['caseCustomStatus']; // Filter by Status(legend)
        $priorityFil = $this->params->data['priFil']; // Filter by Priority
        $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
        $caseLabel = $this->params->data['caseLabel']; // Filter by case Label
        $caseUserId = $this->params->data['caseMember']; // Filter by Member
        $caseComment = $this->params->data['caseComment']; // Filter by Member
        $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
        $caseDate = $this->params->data['caseDate']; // Sort by Date
        $caseDueDate = $this->params->data['caseDueDate']; // Sort by Due Date
        @$case_duedate = $this->params->data['case_due_date'];
        @$case_date = urldecode($this->params->data['case_date']);
        $caseSrch = $this->params->data['caseSearch']; // Search by keyword

        $casePage = $this->params->data['casePage']; // Pagination
        $caseUniqId = $this->params->data['caseId']; // Case Uniq ID to close a case
        $caseTitle = $this->params->data['caseTitle']; // Case Uniq ID to close a case
        $caseNum = $this->params->data['caseNum']; // Sort by Due Date
        $caseLegendsort = $this->params->data['caseLegendsort']; // Sort by Case Status
        $caseAtsort = $this->params->data['caseAtsort']; // Sort by Case Status
        $startCaseId = $this->params->data['startCaseId']; // Start Case
        $caseResolve = $this->params->data['caseResolve']; // Resolve Case
        $caseMenuFilters = $this->params->data['caseMenuFilters']; // Resolve Case
        $milestoneIds = $this->params->data['milestoneIds']; // Resolve Case
        $caseCreateDate = $this->params->data['caseCreateDate']; // Sort by Created Date
        @$case_srch = $this->params->data['case_srch'];
        @$milestone_type = $this->params->data['mstype'];
        $changecasetype = $this->params->data['caseChangeType'];
        $caseChangeDuedate = $this->params->data['caseChangeDuedate'];
        $caseChangePriority = $this->params->data['caseChangePriority'];
        $caseChangeAssignto = $this->params->data['caseChangeAssignto'];
        $customfilterid = $this->params->data['customfilter'];
        $detailscount = $this->params->data['detailscount']; // Count number to open casedetails
        $searchMilestoneUid = $this->params->data['searchMilestoneUid']; // Search Milestone Unique Id wise
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

        if ($sortby == 'title') {
            $orderby = "LTRIM(Easycase.title) " . $sortorder;
            $caseTitle = strtolower($sortorder);
        } elseif ($sortby == 'duedate') {
            $caseDueDate = strtolower($sortorder);
            $orderby = "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'estimatedhours') {
            $caseEstHours = strtolower($sortorder);
            $orderby = "Easycase.estimated_hours " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $caseNum = strtolower($sortorder);
            $orderby = "Easycase.id " . $sortorder;
        } elseif ($sortby == 'caseAt') {
            $caseAtsort = strtolower($sortorder);
            $orderby = " EasycaseMilestone.id_seq ASC, Easycase.seq_id ASC ";
        } elseif ($sortby == 'priority') {
            $casePriority = strtolower($sortorder);
            $orderby = "Easycase.priority " . $sortorder;
        } elseif ($sortby == 'status') {
            $caseStatusby = strtolower($sortorder);
            $orderby = "Easycase.legend " . $sortorder;
        } else {
            $caseUpdatedby = strtolower($sortorder);
            $orderby = " EasycaseMilestone.id_seq ASC, Easycase.seq_id ASC ";
        }
        #pr ($orderby);exit;
        #################End of Order by#################################
        ##########Set the result array for search and pagination variables ##################
        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        //$resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['csTtl'] = $caseTitle;
        $resCaseProj['csDuDt'] = $caseDueDate;
        $resCaseProj['csEstHrsSrt'] = $caseEstHours;
        $resCaseProj['csCrtdDt'] = $caseCreateDate;
        $resCaseProj['csNum'] = $caseNum;
        $resCaseProj['csLgndSrt'] = $caseLegendsort;
        $resCaseProj['csAtSrt'] = $caseAtsort;

        $resCaseProj['csPriSrt'] = $casePriority;
        $resCaseProj['csStusSrt'] = $caseStatusby;
        $resCaseProj['csUpdatSrt'] = $caseUpdatedby;

        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        ##########End the result array for search and pagination variables ##################
        ################Filter Starts#################################
        $qry = '';
        $all_rest = '';
        $qry_rest = '';
        if (!$this->Format->isAllowed('View All Task', $roleAccess)) {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }
        #######################Search by filter Date#######################
        if (trim($case_date) != "") {
            if ((SES_COMP == 25814 || SES_COMP == 28528 || SES_COMP == 1358) && (trim($caseComment) && $caseComment != "all")) {
                // Modified for jayan (if date filter with commented by filter is applied then now apply the date filter in the parent task)
            } else {
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                if (trim($case_date) == 'one') {
                    $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
                } elseif (trim($case_date) == '24') {
                    $filterenabled = 1;
                    $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
                } elseif (trim($case_date) == 'week') {
                    $filterenabled = 1;
                    $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
                } elseif (trim($case_date) == 'month') {
                    $filterenabled = 1;
                    $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
                } elseif (trim($case_date) == 'year') {
                    $filterenabled = 1;
                    $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                    $qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
                } elseif (strstr(trim($case_date), ":")) {
                    $filterenabled = 1;
                    $ar_dt = explode(":", trim($case_date));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
                    //$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }
        }
        #####################Filter By Case due date##############3##
        if (trim($case_duedate) != "") {
            $frmTz = '+00:00';
            $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if (trim($case_duedate) == '24') {
                $filterenabled = 1;
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
            } elseif (trim($case_duedate) == 'overdue') {
                $filterenabled = 1;
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) ";
            } elseif (strstr(trim($case_duedate), ":") && trim($case_duedate) !== '0000-00-00 00:00:00') {
                $filterenabled = 1;
                $ar_dt = explode(":", trim($case_duedate));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }
        ######### Filter by CaseUniqId ##########$qry = "";
        if (trim($caseUrl)) {
            $filterenabled = 1;
            $qry.= " AND Easycase.uniq_id='" . $caseUrl . "'";
        }
        $is_def_status_enbled = 0;
        ######### Filter by Custom Status ##########
        if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
            $is_def_status_enbled = 1;
            $filterenabled = 1;
            $qry.= " AND (";
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus, 1);
            $stsLegArr = $caseCustomStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
        }
        ######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
            if (!$is_def_status_enbled) {
                $qry.= " AND (";
            } else {
                $qry.= " OR ";
            }
            $qry.= $this->Format->statusFilter($caseStatus, '', 1);
            $qry .= ")";
            $stsLegArr = $caseStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
            if (!in_array("upd", $expStsLeg)) {
                $qry.= " AND Easycase.type_id !=10";
            }
        } else {
            if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
                $qry .= ")";
            }
        }
       
        ######### Filter by Case Types ##########
        if (trim($caseTypes) && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Case Label ##########
        if (trim($caseLabel) && $caseLabel != "all") {
            $qry.= $this->Format->labelFilter($caseLabel, $curProjId, SES_COMP, SES_TYPE, SES_ID);
        }
        ######### Filter by Priority ##########
        if (trim($priorityFil) && $priorityFil != "all") {
            $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseUserId) && $caseUserId != "all") {
            $qry.= $this->Format->memberFilter($caseUserId);
            $filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseComment) && $caseComment != "all") {
            $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
            $filterenabled = 1;
        }
        ######### Filter by AssignTo ##########
        if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
            $qry.= $this->Format->assigntoFilter($caseAssignTo);
            $filterenabled = 1;
        } elseif (trim($caseAssignTo) == "unassigned") {
            $qry.= " AND Easycase.assign_to='0'";
            $filterenabled = 1;
        }

        ######### Filter by $caseMenuFilters ##########
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        } elseif ($caseMenuFilters == "favourite") {
            if ($projUniq != 'all') {
                $this->loadModel('ProjectUser');
                $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
                $projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
                if (count($projArr)) {
                    $curProjId = $projArr['Project']['id'];
                    $curProjShortName = $projArr['Project']['short_name'];
                    $conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                    $this->loadModel('EasycaseFavourite');
                    $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                    //if(!empty($easycase_favourite)){
                    $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                    //}
                }
            } else {
                $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                $this->loadModel('EasycaseFavourite');
                $easycase_favourite = $this->EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
                // if(!empty($easycase_favourite)){
                $qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
                // }
            }
        }
        

        $searchMilestone = "";
        ###############Searching Conditions ##############

        if (!empty($caseSrch)) {
            $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
            $searchMilestone .= $searchcase;
        }
        $searchMilestone .=$qry;
				//replace starting AND with blank
				//$searchMilestone = ltrim($searchMilestone," AND ");
        $searchMilestone = preg_replace('/^AND/',"", trim($searchMilestone), 1);
        if ($mid) {
            $conds = array('Easycase.istype'=>1,$clt_sql,"Easycase.isactive"=>1,"Easycase.project_id"=>$curProjId,"EasycaseMilestone.milestone_id"=>$mid, $searchMilestone);
        } else {
            $conds = array('Easycase.istype'=>1,$clt_sql,"Easycase.isactive"=>1,"Easycase.project_id"=>$curProjId,"Easycase.id NOT IN (SELECT EasycaseMilestones.easycase_id from easycase_milestones as EasycaseMilestones WHERE EasycaseMilestones.project_id='" . $curProjId . "')", $searchMilestone);
        }
        $this->loadModel("Project");
        $prj = $this->Project->find("first", array("conditions"=>array("Project.id"=>$curProjId)));
        if ($prj['Project']['status_group_id']) {
            $CustomStatus = ClassRegistry::init('CustomStatus');
            $sts_cond = array('CustomStatus.status_group_id'=>$prj['Project']['status_group_id']);
            $CustomStatusArr =  $CustomStatus->find('first', array('conditions'=>$sts_cond,'order'=>array('CustomStatus.seq'=>'DESC')));
            $max_custom_status = $CustomStatusArr['CustomStatus']['id'];
            $custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
        } else {
            $max_custom_status = "3";
        }
        //  $conditions = array($extra_wheres,$clt_sql);
        $fields = array('Easycase.id','Easycase.uniq_id','Easycase.case_no','Easycase.case_count','Easycase.project_id','Easycase.user_id','Easycase.updated_by','Easycase.type_id','Easycase.priority','Easycase.title','Easycase.estimated_hours','Easycase.hours','Easycase.completed_task','Easycase.assign_to','Easycase.gantt_start_date','Easycase.due_date','Easycase.istype','Easycase.client_status','Easycase.format','Easycase.status','Easycase.legend','Easycase.is_recurring','Easycase.isactive','Easycase.dt_created','Easycase.actual_dt_created','Easycase.reply_type','Easycase.is_chrome_extension','Easycase.from_email','Easycase.depends','Easycase.children','Easycase.temp_est_hours','Easycase.seq_id','Easycase.parent_task_id','Easycase.story_point','Easycase.thread_count','Easycase.custom_status_id','Easycase.parent_id','User.short_name','User.name','AssignTo.short_name','AssignTo.photo','AssignTo.name','AssignTo.last_name','Project.uniq_id','Project.name','CustomStatus.*','Type.name'
        );
        $allCSByProj = $this->Format->getStatusByProject($curProjId);
        $this->Easycase->bindModel(array('belongsTo' => array(
                'User'=>array('className'=>'User','foreignKey'=>'user_id'),
                'AssignTo'=>array('className'=>'User','foreignKey'=>'assign_to'),
                'CustomStatus','Project','Type'
            )));
        // ,'hasMany' => array('LogTime' => array('className' => 'LogTime'))
        $orderby = trim($orderby, ' , ');
        $options = array();
        $options['fields'] = $fields;
        $options['conditions'] = $conds;
        //  $options['recursive'] = false;
        $options['joins'] = array(array('table' => 'easycase_milestones', 'alias' => 'EasycaseMilestone', 'type' => 'LEFT', 'conditions' => array('EasycaseMilestone.easycase_id=Easycase.id'))); //,array('table' => 'log_times', 'alias' => 'LogTime', 'type' => 'LEFT', 'conditions' => array('LogTime.task_id=Easycase.id'))
        $options["order"] = $orderby;
        //  echo "<pre>";print_r($options);exit;
        $resCaseProj = $this->Easycase->find('threaded', $options);
        //  echo "<pre>";print_r($resCaseProj);print_r($conds);print_r($caseAll_records);exit;
        /*         * *Manipulate results**** */
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
        $cq = $view->loadHelper('Casequery');
        $frmt = $view->loadHelper('Format');
        $total_tsk = 0;
        $EasycaseFavourite = ClassRegistry::init('EasycaseFavourite');
        foreach ($resCaseProj as $k=>$v) {
            $v['AssignTo']['usrPhotoBg'] = $v['Easycase']['assign_to'] != 0 ? $this->User->getProfileBgColr($v['Easycase']['assign_to']) : '';
            $resCaseProj[$k]["Easycase"]['sub_sub_task'] = 0 ;
            $total_tsk ++;
            // if($v['Easycase']['due_date'] && $v['Easycase']['due_date'] != '0000-00-00 00:00:00'){
            $formated_due_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['due_date'], "date");
            $resCaseProj[$k]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
            $caseLegend = $v['Easycase']['custom_status_id']  == 0 ? $v['Easycase']['legend'] : $v['Easycase']['custom_status_id'];
            $due_date_details = $this->Easycase->getformatedDueDate($formated_due_date, $v['Easycase']['type_id'], $caseLegend, $max_custom_status, $tz, $dt);
            /*	if($v['Easycase']['gantt_start_date'] && $v['Easycase']['gantt_start_date'] != '0000-00-00 00:00:00'){
                    $gantt_start_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['gantt_start_date'], "date");
                    $resCaseProj[$k]['Easycase']['formated_due_date'] = date('M d', strtotime($gantt_start_date)).' - '.date('d', strtotime($formated_due_date));
                }else{
                    $resCaseProj[$k]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                } */
            //  echo "<pre>";print_r($due_date_details);
              $resCaseProj[$k]['Easycase']['title'] = h($v['Easycase']['title'], true, 'UTF-8');
            $resCaseProj[$k]['Easycase']['formated_due_date'] = $formated_due_date;
            $resCaseProj[$k]['Easycase']['csDuDtFmtT'] = $due_date_details['csDuDtFmtT'];
            $resCaseProj[$k]['Easycase']['csDuDtFmt'] = $due_date_details['csDuDtFmt'];
            $resCaseProj[$k]['Easycase']['csDuDtFmt1'] = $due_date_details['csDuDtFmt1'];
            $resCaseProj[$k]['Easycase']['csDuDtFmtBy'] = $due_date_details['csDuDtFmtBy'];
            $resCaseProj[$k]['Easycase']['csDueDate'] = $due_date_details['csDueDate'];
            $resCaseProj[$k]['Easycase']['csDueDate1'] = $due_date_details['csDueDate1'];
            $resCaseProj[$k]['Easycase']['dt_created'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['dt_created'], "datetime");
            if ($v["CustomStatus"]["id"]) {
                $resCaseProj[$k]['Easycase']['completed_task'] = $v["CustomStatus"]["progress"];
            }
            $easycase_favourite = array();
            $favouriteconditions = array('EasycaseFavourite.easycase_id'=>$v['Easycase']['id'],'EasycaseFavourite.project_id'=>$v['Easycase']['project_id'],'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
            $easycase_favourite = $EasycaseFavourite->find('first', array('fields'=>array('EasycaseFavourite.id'),'conditions'=>$favouriteconditions));
            if (!empty($easycase_favourite['EasycaseFavourite']['id'])) {
                $resCaseProj[$k]['Easycase']['isFavourite'] = 1;
                $resCaseProj[$k]['Easycase']['favouriteColor'] = '#FFDC77';
            } else {
                $resCaseProj[$k]['Easycase']['isFavourite'] = 0;
                $resCaseProj[$k]['Easycase']['favouriteColor'] = '#888888';
            }
            /*   }else{
                   $resCaseProj[$k]['Easycase']['formated_due_date'] = '';
                   $resCaseProj[$k]['Easycase']['csDuDtFmtT'] = '';
                   $resCaseProj[$k]['Easycase']['csDuDtFmt'] = '';
                   $resCaseProj[$k]['Easycase']['csDuDtFmt1'] = '';
                   $resCaseProj[$k]['Easycase']['csDuDtFmtBy'] = '';
                   $resCaseProj[$k]['Easycase']['csDueDate'] = '';
                   $resCaseProj[$k]['Easycase']['csDueDate1'] = '';
               }*/
            if (count($v['children'])) {
                foreach ($v['children'] as $k1=>$v1) {
                    $total_tsk ++;
                    $v1['AssignTo']['usrPhotoBg'] = $v1['Easycase']['assign_to'] != 0 ? $this->User->getProfileBgColr($v1['Easycase']['assign_to']) : '';
                    //   if($v1['Easycase']['due_date'] && $v1['Easycase']['due_date'] != '0000-00-00 00:00:00'){
                        $resCaseProj[$k]['children'][$k1]['Easycase']['title'] =h($v1['Easycase']['title'],true, 'UTF-8');
                    $formated_due_date1 =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v1['Easycase']['due_date'], "date");
                    $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                    $caseLegend1 = $v1['Easycase']['custom_status_id']  == 0 ? $v1['Easycase']['legend'] : $v1['Easycase']['custom_status_id'];
                    $due_date_details1 = $this->Easycase->getformatedDueDate($formated_due_date1, $v1['Easycase']['type_id'], $caseLegend1, $max_custom_status, $tz, $dt);
                    $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] =$formated_due_date1;
                    $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmtT'] = $due_date_details1['csDuDtFmtT'];
                    $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmt'] = $due_date_details1['csDuDtFmt'];
                    $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmt1'] = $due_date_details1['csDuDtFmt1'];
                    $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmtBy'] = $due_date_details1['csDuDtFmtBy'];
                    $resCaseProj[$k]['children'][$k1]['Easycase']['csDueDate'] = $due_date_details1['csDueDate'];
                    $resCaseProj[$k]['children'][$k1]['Easycase']['csDueDate1'] = $due_date_details1['csDueDate1'];
                    $resCaseProj[$k]['children'][$k1]['Easycase']['dt_created'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v1['Easycase']['dt_created'], "datetime");
                    if ($v1["CustomStatus"]["id"]) {
                        $resCaseProj[$k]['children'][$k1]['Easycase']['completed_task'] = $v1["CustomStatus"]["progress"];
                    }
                    $easycase_favourite = array();
                    $favouriteconditions = array('EasycaseFavourite.easycase_id'=>$v1['Easycase']['id'],'EasycaseFavourite.project_id'=>$v1['Easycase']['project_id'],'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                    $easycase_favourite = $EasycaseFavourite->find('first', array('fields'=>array('EasycaseFavourite.id'),'conditions'=>$favouriteconditions));
                    if (!empty($easycase_favourite['EasycaseFavourite']['id'])) {
                        $resCaseProj[$k]['children'][$k1]['Easycase']['isFavourite'] = 1;
                        $resCaseProj[$k]['children'][$k1]['Easycase']['favouriteColor'] = '#FFDC77';
                    } else {
                        $resCaseProj[$k]['children'][$k1]['Easycase']['isFavourite'] = 0;
                        $resCaseProj[$k]['children'][$k1]['Easycase']['favouriteColor'] = '#888888';
                    }
                    // echo "<pre>";print_r($due_date_details1);
                            /*
                            if($v1['Easycase']['gantt_start_date'] && $v1['Easycase']['gantt_start_date'] != '0000-00-00 00:00:00'){
                                $gantt_start_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v1['Easycase']['gantt_start_date'], "date");
                                $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] = date('M d', strtotime($gantt_start_date)).' - '.date('d', strtotime($formated_due_date));
                            }else{
                                $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                            }
                             * */
                            
                      /*  }else{
                            $resCaseProj[$k]['children'][$k1]['Easycase']['formated_due_date'] ='';
                             $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmtT'] = '';
                            $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmt'] = '';
                            $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmt1'] = '';
                            $resCaseProj[$k]['children'][$k1]['Easycase']['csDuDtFmtBy'] = '';
                            $resCaseProj[$k]['children'][$k1]['Easycase']['csDueDate'] = '';
                            $resCaseProj[$k]['children'][$k1]['Easycase']['csDueDate1'] = '';
                        } */
                }
                if (count($v1['children'])) {
                    $resCaseProj[$k]["Easycase"]['sub_sub_task'] = 1 ;
                    foreach ($v1['children'] as $k2=>$v2) {
                        $total_tsk ++;
                        $v2['AssignTo']['usrPhotoBg'] = $v2['Easycase']['assign_to'] != 0 ? $this->User->getProfileBgColr($v2['Easycase']['assign_to']) : '';
                        //   if($v2['Easycase']['due_date'] && $v2['Easycase']['due_date'] != '0000-00-00 00:00:00'){
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['title'] =h($v2['Easycase']['title'],true, 'UTF-8');
                        $formated_due_date2 =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v2['Easycase']['due_date'], "date");
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                        $caseLegend2 = $v2['Easycase']['custom_status_id']  == 0 ? $v2['Easycase']['legend'] : $v2['Easycase']['custom_status_id'];
                        $due_date_details2 = $this->Easycase->getformatedDueDate($formated_due_date2, $v2['Easycase']['type_id'], $caseLegend, $max_custom_status, $tz, $dt);
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = $formated_due_date2;
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmtT'] = $due_date_details2['csDuDtFmtT'];
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmt'] = $due_date_details2['csDuDtFmt'];
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmt1'] = $due_date_details2['csDuDtFmt1'];
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmtBy'] = $due_date_details2['csDuDtFmtBy'];
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDueDate'] = $due_date_details2['csDueDate'];
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDueDate1'] = $due_date_details2['csDueDate1'];
                        $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['dt_created'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v2['Easycase']['dt_created'], "datetime");
                        if ($v2["CustomStatus"]["id"]) {
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['completed_task'] = $v2["CustomStatus"]["progress"];
                        }
                        $easycase_favourite = array();
                        $favouriteconditions = array('EasycaseFavourite.easycase_id'=>$v2['Easycase']['id'],'EasycaseFavourite.project_id'=>$v2['Easycase']['project_id'],'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
                        $easycase_favourite = $EasycaseFavourite->find('first', array('fields'=>array('EasycaseFavourite.id'),'conditions'=>$favouriteconditions));
                        if (!empty($easycase_favourite['EasycaseFavourite']['id'])) {
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['isFavourite'] = 1;
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['favouriteColor'] = '#FFDC77';
                        } else {
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['isFavourite'] = 0;
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['favouriteColor'] = '#888888';
                        }
                        /*			if($v2['Easycase']['gantt_start_date'] && $v2['Easycase']['gantt_start_date'] != '0000-00-00 00:00:00'){
                            $gantt_start_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v2['Easycase']['gantt_start_date'], "date");
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = date('M d', strtotime($gantt_start_date)).' - '.date('d', strtotime($formated_due_date));
                        }else{
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
                        }
                             * */
                                 
                      /*  }else{
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['formated_due_date'] = '';
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmtT'] = '';
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmt'] = '';
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmt1'] = '';
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDuDtFmtBy'] = '';
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDueDate'] = '';
                            $resCaseProj[$k]['children'][$k1]['children'][$k2]['Easycase']['csDueDate1'] = '';
                        } */
                    }
                }
            }
        }
        $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $friday = date('Y-m-d', strtotime($curCreated . "next Friday"));
        $monday = date('Y-m-d', strtotime($curCreated . "next Monday"));
        $tomorrow = date('Y-m-d', strtotime($curCreated . "+1 day"));

        $resultArr['intCurCreated'] = strtotime($curCreated);
        $resultArr['mdyCurCrtd'] = date('m/d/Y', strtotime($curCreated));
        $resultArr['mdyFriday'] = date('m/d/Y', strtotime($friday));
        $resultArr['mdyMonday'] = date('m/d/Y', strtotime($monday));
        $resultArr['mdyTomorrow'] = date('m/d/Y', strtotime($tomorrow));
        $customStatusByProject = array();
        if (isset($allCSByProj)) {
            foreach ($allCSByProj as $k=>$v) {
                if (isset($v['StatusGroup']['CustomStatus'])) {
                    $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                }
            }
        }
        $this->loadModel('Projects');
        $prjs = $this->Project->getProjectFields(array("Project.uniq_id" => $projUniq), array("Project.id","Project.task_type"));
        $defaultTaskType = $prjs['Project']['task_type'];
        $resultArr['defaultTaskType'] =$defaultTaskType;
    
        $projUser1 = array();
        if ($projUniq) {
            $projUser1 = array($projUniq => $this->Easycase->getMemebers($projUniq, 0, 0, 1));
            if (!empty($projUser1)) {
                $QTAssigns = Hash::extract($projUser1[$projUniq], '{n}.User');
            }
        }
        $resultArr['QTAssigns'] =!empty($QTAssigns)?$QTAssigns:array();
     
    
        $resultArr['mid'] =$mid;
        $resultArr['resCaseProj'] = $resCaseProj;
        $resultArr['casePage'] = $casePage;
        $resultArr['totPages'] = $totPages;
        $resultArr['customStatusByProject'] = $customStatusByProject;
        $resultArr['projUniq'] = $projUniq;
        $resultArr['curProjId'] = $curProjId;
        $resultArr['max_custom_status'] = $max_custom_status;
        $resultArr['projectName'] = $prj["Project"]["name"];
        $resultArr['total_task'] = $total_tsk;
        echo json_encode($resultArr);
        exit;
    }
    function ajaXLoadTaskByTaskgroup() {
        $this->layout = 'ajax';
				//echo 'In - '.date('H:i:s:v');
        $curProjId = $this->params->data['pid'];
        $mid = $this->params->data['mid'];
        $projUniq = $this->params->data['projFil']; // Project Uniq ID
				$this->loadModel('Projects');
				$this->Project->recursive = -1;
				$prj = $this->Project->find("first",array("conditions"=>array("Project.uniq_id"=>$projUniq)));
				$curProjId = $prj['Project']['id'];
				
				$page_limit = CASE_PAGE_LIMIT;
				
        $this->loadModel("Easycase");
        $this->Easycase->Behaviors->enable('Tree');
        $this->Easycase->virtualFields['parent_id'] = 'Easycase.parent_task_id';
        $this->LoadModel('Milestone');
        ############Decleration of Variables ###############
        $resCaseProj = array();
        $this->_datestime();
        
        $projIsChange = $this->params->data['projIsChange']; // Project Uniq ID
        $caseStatus = $this->params->data['caseStatus']; // Filter by Status(legend)
        $caseCustomStatus = $this->params->data['caseCustomStatus']; // Filter by Status(legend)
        $priorityFil = $this->params->data['priFil']; // Filter by Priority
        $caseTypes = $this->params->data['caseTypes']; // Filter by case Types
        $caseLabel = $this->params->data['caseLabel']; // Filter by case Label
        $caseUserId = $this->params->data['caseMember']; // Filter by Member
        $caseComment = $this->params->data['caseComment']; // Filter by Member
        $caseAssignTo = $this->params->data['caseAssignTo']; // Filter by AssignTo
        $caseDate = $this->params->data['caseDate']; // Sort by Date
        $caseDueDate = $this->params->data['caseDueDate']; // Sort by Due Date
        @$case_duedate = $this->params->data['case_due_date'];
        @$case_date = urldecode($this->params->data['case_date']);
        $caseSrch = $this->params->data['caseSearch']; // Search by keyword

        $casePage = $this->params->data['casePage']; // Pagination
        $caseUniqId = $this->params->data['caseId']; // Case Uniq ID to close a case
        $caseTitle = $this->params->data['caseTitle']; // Case Uniq ID to close a case
        $caseNum = $this->params->data['caseNum']; // Sort by Due Date
        $caseLegendsort = $this->params->data['caseLegendsort']; // Sort by Case Status
        $caseAtsort = $this->params->data['caseAtsort']; // Sort by Case Status
        $startCaseId = $this->params->data['startCaseId']; // Start Case
        $caseResolve = $this->params->data['caseResolve']; // Resolve Case
        $caseMenuFilters = $this->params->data['caseMenuFilters']; // Resolve Case
        $milestoneIds = $this->params->data['milestoneIds']; // Resolve Case
        $caseCreateDate = $this->params->data['caseCreateDate']; // Sort by Created Date
        @$case_srch = $this->params->data['case_srch'];
        @$milestone_type = $this->params->data['mstype'];
        $changecasetype = $this->params->data['caseChangeType'];
        $caseChangeDuedate = $this->params->data['caseChangeDuedate'];
        $caseChangePriority = $this->params->data['caseChangePriority'];
        $caseChangeAssignto = $this->params->data['caseChangeAssignto'];
        $customfilterid = $this->params->data['customfilter'];
        $detailscount = $this->params->data['detailscount']; // Count number to open casedetails
        $searchMilestoneUid = $this->params->data['searchMilestoneUid']; // Search Milestone Unique Id wise
				
        $viewType = $this->params->data['viewType']; //for sub and sub sub task
        $parentId = $this->params->data['parentId']; //for sub and sub sub task
				
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

        if ($sortby == 'title') {
            $orderby = "LTRIM(Easycase.title) " . $sortorder;
            $caseTitle = strtolower($sortorder);
        } elseif ($sortby == 'duedate') {
            $caseDueDate = strtolower($sortorder);
            $orderby = "Easycase.due_date " . $sortorder;
        } elseif ($sortby == 'estimatedhours') {
            $caseEstHours = strtolower($sortorder);
            $orderby = "Easycase.estimated_hours " . $sortorder;
        } elseif ($sortby == 'caseno') {
            $caseNum = strtolower($sortorder);
            $orderby = "Easycase.id " . $sortorder;
        } elseif ($sortby == 'caseAt') {
            $caseAtsort = strtolower($sortorder);
            $orderby = " EasycaseMilestone.id_seq ASC, Easycase.seq_id ASC ";
        } elseif ($sortby == 'priority') {
            $casePriority = strtolower($sortorder);
            $orderby = "Easycase.priority " . $sortorder;
        } elseif ($sortby == 'status') {
            $caseStatusby = strtolower($sortorder);
            $orderby = "Easycase.legend " . $sortorder;
        } else {
            $caseUpdatedby = strtolower($sortorder);
            $orderby = " EasycaseMilestone.id_seq ASC, Easycase.dt_created DESC ";
        }
        #pr ($orderby);exit;
        #################End of Order by#################################
        ##########Set the result array for search and pagination variables ##################
        $resCaseProj['page_limit'] = $page_limit;
        $resCaseProj['csPage'] = $casePage;
        //$resCaseProj['caseUrl'] = $caseUrl;
        $resCaseProj['projUniq'] = $projUniq;
        $resCaseProj['csdt'] = $caseDate;
        $resCaseProj['csTtl'] = $caseTitle;
        $resCaseProj['csDuDt'] = $caseDueDate;
				$resCaseProj['csEstHrsSrt'] = $caseEstHours;
        $resCaseProj['csCrtdDt'] = $caseCreateDate;
        $resCaseProj['csNum'] = $caseNum;
        $resCaseProj['csLgndSrt'] = $caseLegendsort;
        $resCaseProj['csAtSrt'] = $caseAtsort;

        $resCaseProj['csPriSrt'] = $casePriority;
        $resCaseProj['csStusSrt'] = $caseStatusby;
        $resCaseProj['csUpdatSrt'] = $caseUpdatedby;

        $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
        $resCaseProj['filterenabled'] = $filterenabled;
        ##########End the result array for search and pagination variables ##################  
        ################Filter Starts#################################
        $qry = '';
        $all_rest = '';
        $qry_rest = '';
        if(!$this->Format->isAllowed('View All Task',$roleAccess)){
             $qry.= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
        }
        #######################Search by filter Date#######################          
        if (trim($case_date) != "") {
					if((SES_COMP == 25814 || SES_COMP == 28528 || SES_COMP == 1358) && (trim($caseComment) && $caseComment != "all")){
							// Modified for jayan (if date filter with commented by filter is applied then now apply the date filter in the parent task)
					}else{
						$frmTz = '+00:00';
						$toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
						$GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
						if (trim($case_date) == 'one') {
							$one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
							$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
						} else if (trim($case_date) == '24') {
							$filterenabled = 1;
							$day_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE. " -1 day"));
							$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
						} else if (trim($case_date) == 'week') {
							$filterenabled = 1;
							$week_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE . " -1 week"));
							$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
						} else if (trim($case_date) == 'month') {
							$filterenabled = 1;
							$month_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE . " -1 month"));
							$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
						} else if (trim($case_date) == 'year') {
							$filterenabled = 1;
							$year_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE . " -1 year"));
							$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
						} else if (strstr(trim($case_date), ":")) {
							$filterenabled = 1;
							$ar_dt = explode(":", trim($case_date));
							$frm_dt = $ar_dt['0'];
							$to_dt = $ar_dt['1'];
							$qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
						}
					}
        }
        #####################Filter By Case due date##############3##
        if (trim($case_duedate) != "") {
					$frmTz = '+00:00';
					$toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
					$GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
					if (trim($case_duedate) == '24') {
						$filterenabled = 1;
						$day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
						$qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
					} else if (trim($case_duedate) == 'overdue') {
						$filterenabled = 1;
						$week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
						$qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) !='0000-00-00') AND (Easycase.legend !=3) ";
					} else if (strstr(trim($case_duedate), ":") && trim($case_duedate) !== '0000-00-00 00:00:00') {
						$filterenabled = 1;
						$ar_dt = explode(":", trim($case_duedate));
						$frm_dt = $ar_dt['0'];
						$to_dt = $ar_dt['1'];
						$qry.= " DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
					}
        }
        ######### Filter by CaseUniqId ##########$qry = "";
        if (trim($caseUrl)) {
					$filterenabled = 1;
					$qry.= " AND Easycase.uniq_id='" . $caseUrl . "'";
        }
				$is_def_status_enbled = 0;
				######### Filter by Custom Status ##########
				if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
					$is_def_status_enbled = 1;
					$filterenabled = 1;
					$qry.= " AND (";
					$qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq, $caseStatus, 1);
					$stsLegArr = $caseCustomStatus . "-" . "";
					$expStsLeg = explode("-", $stsLegArr);            
				}
        ######### Filter by Status ##########
        if (trim($caseStatus) && $caseStatus != "all") {
            $filterenabled = 1;
					if(!$is_def_status_enbled){
						$qry.= " AND (";	
					}else{
						$qry.= " OR ";
					}
					$qry.= $this->Format->statusFilter($caseStatus, '', 1);
					$qry .= ")";				
					$stsLegArr = $caseStatus . "-" . "";
					$expStsLeg = explode("-", $stsLegArr);
					if (!in_array("upd", $expStsLeg)) {
						$qry.= " AND Easycase.type_id !=10";
					}
				}else{
					if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
						$qry .= ")";	
					}
				}       
        ######### Filter by Case Types ##########
        if (trim($caseTypes) && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
            $filterenabled = 1;
        }
				######### Filter by Case Label ##########
				if (trim($caseLabel) && $caseLabel != "all") {
					$qry.= $this->Format->labelFilter($caseLabel, $curProjId, SES_COMP, SES_TYPE, SES_ID);
				}
        ######### Filter by Priority ##########
        if (trim($priorityFil) && $priorityFil != "all") {
					$qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
					$filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseUserId) && $caseUserId != "all") {
					$qry.= $this->Format->memberFilter($caseUserId);
					$filterenabled = 1;
        }
        ######### Filter by Member ##########
        if (trim($caseComment) && $caseComment != "all") {
					$qry.= $this->Format->commentFilter($caseComment,$curProjId,$case_date);
					$filterenabled = 1;
        }
        ######### Filter by AssignTo ##########
        if (trim($caseAssignTo) && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
					$qry.= $this->Format->assigntoFilter($caseAssignTo);
					$filterenabled = 1;
        } else if (trim($caseAssignTo) == "unassigned") {
					$qry.= " AND Easycase.assign_to='0'";
					$filterenabled = 1;
        }
        ######### Filter by $caseMenuFilters ##########
        if ($caseMenuFilters == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        }else if($caseMenuFilters == "favourite"){
					if ($projUniq != 'all') {
						$this->loadModel('ProjectUser');
						$this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
						$projArr = $this->ProjectUser->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
						if (count($projArr)) {
								$curProjId = $projArr['Project']['id'];
								$curProjShortName = $projArr['Project']['short_name'];
								$conditions = array('EasycaseFavourite.project_id'=>$curProjId,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
								$this->loadModel('EasycaseFavourite');
								$easycase_favourite = $this->EasycaseFavourite->find('list',array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
								//if(!empty($easycase_favourite)){
										$qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
								//}
						}
					}else{
            $conditions = array('EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
						$this->loadModel('EasycaseFavourite');
						$easycase_favourite = $this->EasycaseFavourite->find('list',array('fields'=>array('EasycaseFavourite.id','EasycaseFavourite.easycase_id'),'conditions'=>$conditions));
						$qry .= " AND Easycase.id IN('".implode("','", $easycase_favourite)."')";
					}
        }
        $searchMilestone = "";
        ###############Searching Conditions ##############
        if (!empty($caseSrch)) {
					$searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
					$searchMilestone .= $searchcase;
        }
        $searchMilestone .=$qry;
        //replace starting AND with blank
				$searchMilestone = preg_replace('/^AND/',"", trim($searchMilestone), 1);
        if($mid || $mid == '0'){					
					if($mid == '0'){
						$conds = array('Easycase.istype'=>1,$clt_sql,"Easycase.isactive"=>1,"Easycase.project_id"=>$curProjId,"EasycaseMilestone.easycase_id IS NULL", $searchMilestone);
					}else{
						$conds = array('Easycase.istype'=>1,$clt_sql,"Easycase.isactive"=>1,"Easycase.project_id"=>$curProjId,"EasycaseMilestone.milestone_id"=>$mid, $searchMilestone);
					}
        } else {
						$conds = array('Easycase.istype'=>1,$clt_sql,"Easycase.isactive"=>1,"Easycase.project_id"=>$curProjId, $searchMilestone);
        }
				
        if($prj['Project']['status_group_id']){
            $CustomStatus = ClassRegistry::init('CustomStatus');
            $sts_cond = array('CustomStatus.status_group_id'=>$prj['Project']['status_group_id']);
            $CustomStatusArr =  $CustomStatus->find('first',array('conditions'=>$sts_cond,'order'=>array('CustomStatus.seq'=>'DESC')));
            $max_custom_status = $CustomStatusArr['CustomStatus']['id'];
            $custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
        } else {
            $max_custom_status = "3";
        }
				
      //  $conditions = array($extra_wheres,$clt_sql);   
        $fields = array('Easycase.id','Easycase.uniq_id','Easycase.case_no','Easycase.case_count','Easycase.project_id','Easycase.user_id','Easycase.updated_by','Easycase.type_id','Easycase.priority','Easycase.title','Easycase.estimated_hours','Easycase.hours','Easycase.completed_task','Easycase.assign_to','Easycase.gantt_start_date','Easycase.due_date','Easycase.istype','Easycase.client_status','Easycase.format','Easycase.status','Easycase.legend','Easycase.is_recurring','Easycase.isactive','Easycase.dt_created','Easycase.actual_dt_created','Easycase.reply_type','Easycase.is_chrome_extension','Easycase.from_email','Easycase.depends','Easycase.children','Easycase.temp_est_hours','Easycase.seq_id','Easycase.parent_task_id','Easycase.story_point','Easycase.thread_count','Easycase.custom_status_id','Easycase.parent_id','User.short_name','User.name','AssignTo.short_name','AssignTo.photo','AssignTo.name','AssignTo.last_name','Project.uniq_id','Project.name','CustomStatus.*','Type.name','EasycaseFavourite.id','EasycaseFavourite.user_id'
        );
        $allCSByProj = $this->Format->getStatusByProject($curProjId);
        $this->Easycase->bindModel(array('belongsTo' => array(                
                'User'=>array('className'=>'User','foreignKey'=>'user_id'),
                'AssignTo'=>array('className'=>'User','foreignKey'=>'assign_to'),
                'CustomStatus','Project','Type'
            )));
        $orderby = trim($orderby, ' , ');				
        $options = array();
        $options['fields'] = $fields;
        $options['conditions'] = $conds;
				
				/*$offset = $casePage * $page_limit - $page_limit;
				$limit = $page_limit;				
				if($viewType == ''){
					$options['limit'] = $limit;
					//$options['page'] = 1;
					$options['offset'] = $offset;
				}*/
				//$options['recursive'] = false;
        $options['joins'] = array(array('table' => 'easycase_milestones', 'alias' => 'EasycaseMilestone', 'type' => 'LEFT', 'conditions' => array('EasycaseMilestone.easycase_id=Easycase.id')),
				array('table' => 'easycase_favourites', 'alias' => 'EasycaseFavourite', 'type' => 'LEFT', 'conditions' => array('EasycaseFavourite.easycase_id=Easycase.id'))
												);
        $options["order"] = $orderby;
				#echo "<pre>";print_r($options);exit;
        $resCaseProj = $this->Easycase->find('threaded',$options);
        //$resCaseProj = $this->Easycase->find('all',$options);
				/*if($viewType == ''){
					unset($options['limit']);
					unset($options['offset']);
					$totalCount = $this->Easycase->find('count',$options);
				}*/

        /*$db = ConnectionManager::getDataSource('default');
        $db->showLog();*/
				
				/*echo 'Out - '.date('H:i:s:v');
        echo "<pre>";
        print_r($resCaseProj);
        exit;*/
				
        /** *Manipulate results**** */
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
				$frmt = $view->loadHelper('Format');
        $total_tsk = 0;
				foreach($resCaseProj as $k=>$v){
					$v['AssignTo']['usrPhotoBg'] = $v['Easycase']['assign_to'] != 0 ? $this->User->getProfileBgColr($v['Easycase']['assign_to']) : '';
					$resCaseProj[$k]["Easycase"]['sub_sub_task'] = 0 ;
					$total_tsk ++;
					$formated_due_date =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['due_date'], "date");
					$resCaseProj[$k]['Easycase']['formated_due_date'] = date('M d', strtotime($formated_due_date));
					$caseLegend = $v['Easycase']['custom_status_id']  == 0 ? $v['Easycase']['legend'] : $v['Easycase']['custom_status_id'];
					$due_date_details = $this->Easycase->getformatedDueDate($formated_due_date,$v['Easycase']['type_id'],$caseLegend,$max_custom_status,$tz,$dt);
					$resCaseProj[$k]['Easycase']['title'] = h($v['Easycase']['title'], true, 'UTF-8');
					$resCaseProj[$k]['Easycase']['formated_due_date'] = $formated_due_date;
					$resCaseProj[$k]['Easycase']['csDuDtFmtT'] = $due_date_details['csDuDtFmtT'];
					$resCaseProj[$k]['Easycase']['csDuDtFmt'] = $due_date_details['csDuDtFmt'];
					$resCaseProj[$k]['Easycase']['csDuDtFmt1'] = $due_date_details['csDuDtFmt1'];
					$resCaseProj[$k]['Easycase']['csDuDtFmtBy'] = $due_date_details['csDuDtFmtBy'];
					$resCaseProj[$k]['Easycase']['csDueDate'] = $due_date_details['csDueDate'];
					$resCaseProj[$k]['Easycase']['csDueDate1'] = $due_date_details['csDueDate1'];
					$resCaseProj[$k]['Easycase']['dt_created'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['Easycase']['dt_created'], "datetime");
					if($v["CustomStatus"]["id"]){
						$resCaseProj[$k]['Easycase']['completed_task'] = $v["CustomStatus"]["progress"];
					}
					if($v['EasycaseFavourite']['id'] && $v['EasycaseFavourite']['user_id'] == SES_ID){
						$resCaseProj[$k]['Easycase']['isFavourite'] = 1;
						$resCaseProj[$k]['Easycase']['favouriteColor'] = '#FFDC77';
					}else{
					 $resCaseProj[$k]['Easycase']['isFavourite'] = 0;
					 $resCaseProj[$k]['Easycase']['favouriteColor'] = '#888888';
					}
        } 
			$curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
			$friday = date('Y-m-d', strtotime($curCreated . "next Friday"));
			$monday = date('Y-m-d', strtotime($curCreated . "next Monday"));
			$tomorrow = date('Y-m-d', strtotime($curCreated . "+1 day"));
			$resultArr['intCurCreated'] = strtotime($curCreated);
			$resultArr['mdyCurCrtd'] = date('m/d/Y', strtotime($curCreated));
			$resultArr['mdyFriday'] = date('m/d/Y', strtotime($friday));
			$resultArr['mdyMonday'] = date('m/d/Y', strtotime($monday));
			$resultArr['mdyTomorrow'] = date('m/d/Y', strtotime($tomorrow));
			$customStatusByProject = array();
        $lastCustomStatus = [];
			if(isset($allCSByProj)){
				foreach($allCSByProj as $k=>$v){
					if(isset($v['StatusGroup']['CustomStatus'])){
                    $lastCustomStatus['LastCS'] = end($v['StatusGroup']['CustomStatus']);
						$customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
					}
				}
			} 
			$resultArr['defaultTaskType'] = $prj['Project']['task_type'];			

			$projUser1 = array();
			if ($projUniq) {
				$projUser1 = array($projUniq => $this->Easycase->getMemebers($projUniq,0,0,1));
			if(!empty($projUser1)){
				$QTAssigns = Hash::extract($projUser1[$projUniq], '{n}.User');
			}  
		}
		$resultArr['QTAssigns'] =!empty($QTAssigns)?$QTAssigns:array();    
    
		$resultArr['mid'] = (!empty($mid)) ? $mid : 0;  
		$resultArr['resCaseProj'] = $resCaseProj;
		$resultArr['casePage'] = $casePage;
		$resultArr['csPage'] = $casePage;
		$resultArr['page_limit'] = $page_limit;
		$resultArr['totPages'] = $totPages;
		$resultArr['customStatusByProject'] = $customStatusByProject;
        $resultArr['lastCustomStatus'] = $lastCustomStatus;
		$resultArr['projUniq'] = $projUniq;
		$resultArr['curProjId'] = $curProjId;
		$resultArr['max_custom_status'] = $max_custom_status;
		$resultArr['projectName'] = $prj["Project"]["name"];
		$resultArr['total_task'] = $total_tsk;
		//$resultArr['viewType'] = $viewType;
		//$resultArr['parentId'] = $parentId;
		$resultArr['caseCount'] = 0;
		 
		 
		$resultArr['caseSrch'] = $caseSrch;
		/*if($viewType == ''){
			$resultArr['caseCount'] = $totalCount;		 
			$pgShLbl = $frmt->pagingShowRecords($totalCount, $page_limit, $casePage);
			$resultArr['pgShLbl'] = $pgShLbl;
		}*/
		 
		 /*$db = ConnectionManager::getDataSource('default');
			$db->showLog();
			exit;*/
		//echo 'Out - '.date('H:i:s');	
		echo json_encode($resultArr); 
		exit;				
	}
  public function ajaXLoadTaskGroupList()
	{
		$this->layout = 'ajax';
		$casePage = empty($this->data['page']) ? 1 : $this->data['page']; // Pagination
		$page_limit = 50;
		$allMilestones = [];
		$this->loadModel('Milestone');
		$this->Project->recursive = -1;
		$prj = $this->Project->find("first",array("conditions"=>array("Project.uniq_id"=>$this->data['projFil'])));
		if($prj){
			$curProjId = $prj['Project']['id'];
			
			$searchMilestone = [];
			if(!empty($this->data['caseSearch'])){
				$searchMilestone['searchMilestone'] = $this->data['caseSearch'];
			}		
			//$milestones = $this->EasycaseMilestone->getTaskcountForTaskGroups($curProjId, $searchMilestone, $casePage, $page_limit);
			$milestones = $this->Milestone->getMilestoneList($curProjId, $searchMilestone, $casePage, $page_limit);
			if(!empty($milestones['taskgroups'])){
					foreach($milestones['taskgroups'] as $k => $v){
						$milestones['taskgroups'][$k]['Milestone']['estimated_hours'] = $this->Format->formatTGMeta($v['Milestone']['estimated_hours'], 'est');
						$milestones['taskgroups'][$k]['Milestone']['start_date'] = $this->Format->formatTGMeta($v['Milestone']['start_date'], 'sdate');
						$milestones['taskgroups'][$k]['Milestone']['end_date'] = $this->Format->formatTGMeta($v['Milestone']['end_date'], 'edate');
					}
			}
			if($casePage <= 1){
				$add_default = 1;
				if(!empty($this->data['caseSearch'])){
					$search = $this->data['caseSearch'];
					if(!preg_match("/{$search}/i", 'Default Task Group')) {
						$add_default = 0;
					}
				}
				if($add_default){
					$d_milestones = $this->Easycase->getTaskCountOfDefauultTaskGroup($curProjId, []);
					if(!empty($d_milestones[0][0]['CNT'])){
						$d_milestones[0]['Milestone']['id'] = 0;
						$d_milestones[0]['Milestone']['title'] = 'Default Task Group';
						$allMilestones = array_merge($d_milestones, $milestones['taskgroups']);
					}else{
						$allMilestones = $milestones['taskgroups'];
					}	
				}else{
					$allMilestones = $milestones['taskgroups'];
				}
			}else{
				$allMilestones = $milestones['taskgroups'];
			}
		}
		$resultArr['milestones']['project_milestones'] = $allMilestones;
		$resultArr['total'] = $milestones['total'];
		$resultArr['page_limit'] = $page_limit;
		$resultArr['milestones']['selected_mid'] = $this->data['selected_mid'];
		
		//custom pagination
		$total_page = ceil($milestones['total']/$page_limit);
		if($casePage < $total_page){
			if($casePage > 1){
				$resultArr['left'] = 'active';
				$resultArr['right'] = 'active';
			}else{
				$resultArr['left'] = 'disable';
				$resultArr['right'] = 'active';
			}			
		}else if($casePage = $total_page && $casePage > 1){
			$resultArr['left'] = 'active';
			$resultArr['right'] = 'disable';
		}else{
			$resultArr['left'] = 'disable';
			$resultArr['right'] = 'disable';
		}
		
		echo json_encode($resultArr); 
		exit;				
	}
    public function delete_bulk_case()
    {
        $this->layout = 'ajax';
        
        $id = $this->params->data['id'];
        $cno = $this->params->data['cno'];
        $pid = $this->params->data['pid'];
        $arr = array();
        $usrDets = $this->User->find('all', array(
            'conditions' => array('User.id' => $this->Auth->user('id'))
        ));
        $prjuniq = $this->Project->query("SELECT uniq_id, short_name,name FROM projects WHERE id='" . $pid . "'");

        $prjuniqid = $prjuniq[0]['projects']['uniq_id'];
        $this->Easycase->recursive = -1;
        $case_lists = $this->Easycase->find('all', array('conditions' => array('Easycase.id' => $id, 'Easycase.istype' => '1', 'Easycase.project_id' => $pid), 'fields' => array('Easycase.id', 'Easycase.title','Easycase.isactive','Easycase.parent_task_id','Easycase.project_id','Easycase.dt_created','Easycase.user_id')));
        foreach ($case_lists as $k => $case_list) {
            $delCsTitle = '';
            if ($case_list) {
                $ids = $case_list['Easycase']['id'];
                $arr[] = $ids;
                $delCsTitle = $case_list['Easycase']['title'];
            }
            if (!$arr || empty($pid) || empty($cno)) {
                echo json_encode(array('status' => 0));
                exit;
            }
            //$delCsTitle = $this->Easycase->getCaseTitle($pid, $cno);
            
            $resArr = array();
            $resArr['parent_id'] = '';
            //$get_parent_task = $this->Easycase->getParentTask($id);
            if (!empty($case_list['Easycase']['parent_task_id'])) {
                $resArr['parent_id'] = $case_list['Easycase']['parent_task_id'];
            }

            if (SES_COMP != 19398) {
                //Delete github Task/Issue
                $comp_id = (SES_COMP != 'SES_COMP') ? SES_COMP : $prjuniq[0]['projects']['company_id'];
            }
            if (SES_COMP != 19398) {
                $this->Format->createGoogleCalendarEvent($case_list['Easycase']['id'], $case_list['Easycase'], 'delete');
            }
        }
         $this->loadModel('CustomFieldValue');
            $this->CustomFieldValue->deleteCustomFields($case_list['Easycase']['id']);
        $this->Easycase->deleteTasksRecursively($id, $pid, array());
        //socket.io implement start
        /* remove easycase id from other dependant tasks from depends and  children column */
        if (intval($id) > 0) {
            $this->update_dependancy($id, $pid);
        }
        $prjuniqid = $prjuniq[0]['projects']['uniq_id'];
        $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
        //$channel_name = 'my_channel_delete_case';
        $channel_name = $prjuniqid;
        //  if (!stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'orangegigs.com')) {
        //   $resArr['iotoserver'] = array('channel' => $channel_name, 'message' => 'Updated.~~' . SES_ID . '~~' . $cno . '~~' . 'DEL' . '~~' . $delCsTitle . '~~' . $projShName);
        // $this->Postcase->iotoserver(array('channel' => $channel_name, 'message' => 'Updated.~~' . SES_ID . '~~' . $cno . '~~' . 'DEL' . '~~' . $delCsTitle . '~~' . $projShName));
        //  }
        //socket.io implement end
        if (isset($oauth_arg['id']) && !empty($oauth_arg['id'])) {
            return "success";
        } else {
            $resArr['status'] = "success";
            echo json_encode($resArr);
        }
        exit;
    }
    public function taskgroup_pdfcase_project($inactiveFlag = '', $proUid = '', $inCasePage = '', $type = '', $cases = '', $csNum = '', $search_val = '')
    {
        // echo $proUid;exit;
        ini_set('memory_limit', '128M');
        set_time_limit(0);
        $this->layout = "ajax";
        $postparams = $this->params->query;
        $u_id = !empty($postparams['projFil']) ? $postparams['projFil'] : '';
        $this->loadModel('Project');
        $pdf_proj_name = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $u_id)));
       
        if ($pdf_proj_name['Project']['status_group_id']) {
            $CustomStatus = ClassRegistry::init('CustomStatus');
            $sts_cond = array('CustomStatus.status_group_id'=>$pdf_proj_name['Project']['status_group_id']);
            $CustomStatusArr =  $CustomStatus->find('first', array('conditions'=>$sts_cond,'order'=>array('CustomStatus.seq'=>'DESC')));
            $max_custom_status = $CustomStatusArr['CustomStatus']['id'];
            $custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
        } else {
            $max_custom_status = "3";
        }
        //echo "<pre>";
        //print_r($pdf_proj_name);exit;
        $curProjId = !empty($pdf_proj_name['Project']['id']) ? $pdf_proj_name['Project']['id'] : '';
        $this->loadModel('Milestone');
        $conditions = array('Milestone.project_id' => $curProjId);
        $mile_list = $this->Milestone->find('list', array('fields' => array('Milestone.id', 'Milestone.title'), 'conditions' => $conditions));
        $data_list = array();
        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $searchMilestone = "";
        $mile_list[0] = 'Default Milestone';

        if (!empty($mile_list)) {
            foreach ($mile_list as $key => $val) {
                $mid = $key;
                // ini_set('memory_limit', '128M');
                // set_time_limit(0);
                if ($key) {
                    $conds = array('Easycase.istype' => 1, $clt_sql, "Easycase.isactive" => 1, "Easycase.project_id" => $curProjId, "EasycaseMilestone.milestone_id" => $mid);
                } else {
                    $conds = array('Easycase.istype' => 1, $clt_sql, "Easycase.isactive" => 1, "Easycase.project_id" => $curProjId, "Easycase.id NOT IN (SELECT EasycaseMilestones.easycase_id from easycase_milestones as EasycaseMilestones WHERE EasycaseMilestones.project_id='" . $curProjId . "')");
                }
                //$conds=array('EasycaseMilestone.milestone_id'=>$key);
                $this->layout = 'ajax';
                //$curProjId = $this->params->data['pid'];
                //$mid = $this->params->data['mid'];
                $this->loadModel("Easycase");
                $this->Easycase->Behaviors->enable('Tree');
                $this->Easycase->virtualFields['parent_id'] = 'Easycase.parent_task_id';
                $this->LoadModel('Milestone');
                //  $conditions = array($extra_wheres,$clt_sql);
                $fields = array('Easycase.id', 'Easycase.uniq_id', 'Easycase.case_no', 'Easycase.case_count', 'Easycase.project_id', 'Easycase.user_id', 'Easycase.updated_by', 'Easycase.type_id', 'Easycase.priority', 'Easycase.title', 'Easycase.estimated_hours', 'Easycase.hours', 'Easycase.completed_task', 'Easycase.assign_to', 'Easycase.gantt_start_date', 'Easycase.due_date', 'Easycase.istype', 'Easycase.client_status', 'Easycase.format', 'Easycase.status', 'Easycase.legend', 'Easycase.is_recurring', 'Easycase.isactive', 'Easycase.dt_created', 'Easycase.actual_dt_created', 'Easycase.reply_type', 'Easycase.is_chrome_extension', 'Easycase.from_email', 'Easycase.depends', 'Easycase.children', 'Easycase.temp_est_hours', 'Easycase.seq_id', 'Easycase.parent_task_id', 'Easycase.story_point', 'Easycase.thread_count', 'Easycase.custom_status_id', 'Easycase.parent_id', 'User.short_name', 'User.name', 'AssignTo.short_name', 'AssignTo.photo', 'AssignTo.name', 'AssignTo.last_name', 'Project.uniq_id', 'Project.name', 'CustomStatus.*', 'Type.name'
                );
                // $allCSByProj = $this->Format->getStatusByProject($proUid);
                $this->Easycase->bindModel(array('belongsTo' => array(
                        'User' => array('className' => 'User', 'foreignKey' => 'user_id'),
                        'AssignTo' => array('className' => 'User', 'foreignKey' => 'assign_to'),
                        'CustomStatus', 'Project', 'Type'
                )));
                // ,'hasMany' => array('LogTime' => array('className' => 'LogTime'))
                $orderby = "Easycase.id ASC";
                //$orderby = trim($orderby, ' , ');
                $options = array();
                $options['fields'] = $fields;
                $options['conditions'] = $conds;
                //  $options['recursive'] = false;
                $options['joins'] = array(array('table' => 'easycase_milestones', 'alias' => 'EasycaseMilestone', 'type' => 'LEFT', 'conditions' => array('EasycaseMilestone.easycase_id=Easycase.id'))); //,array('table' => 'log_times', 'alias' => 'LogTime', 'type' => 'LEFT', 'conditions' => array('LogTime.task_id=Easycase.id'))
                $options["order"] = $orderby;
                $resCaseProj = $this->Easycase->find('threaded', $options);
                $data_list[$key] = $resCaseProj;
            }
        }
        $allCSByProj = $this->Format->getStatusByProject($curProjId);
        $customStatusByProject = array();
        if (isset($allCSByProj)) {
            foreach ($allCSByProj as $k=>$v) {
                if (isset($v['StatusGroup']['CustomStatus'])) {
                    $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                }
            }
        }

        $this->loadModel('Type');
        $this->loadModel('User');
        $user_list = $this->User->find('list', array('fields' => array('User.id', 'User.name')));
        $type_list = $this->Type->find('list', array('fields' => array('Type.id', 'Type.name')));
        $SES_TIMEZONE = $postparams['SES_TIMEZONE'];
        $TZ_GMT = $postparams['TZ_GMT'];
        $TZ_DST = $postparams['TZ_DST'];
        $TZ_CODE = $postparams['TZ_CODE'];
        $GMT_DATETIME = $postparams['GMT_DATETIME'];
        $this->loadModel('Milestone');
        $milestone_list = $this->Milestone->find('list', array('fields' => array('Milestone.id', 'Milestone.title')));
        $this->set('milestone_list', $milestone_list);
        $this->set('user_list', $user_list);
        $this->set('type_list', $type_list);
        $this->set('max_custom_status', $max_custom_status);
        $this->set(compact('data_list'));
        $this->set(compact('SES_TIMEZONE', 'TZ_GMT', 'TZ_DST', 'TZ_CODE', 'GMT_DATETIME'));
        $this->render('pdfcase_taskgroups');
    }
    
    public function getUserTaskList()
    {
        $this->layout = 'ajax';
        $result = array();
        $this->loadModel("Easycase");
        $uniqid = $this->params->data['proj_uniq_id'];
        $search_qry = $this->params->data['search_query'];
        $quickMem = $this->Easycase->getMembersAndTask($uniqid, SES_COMP, $search_qry);
        
        $result = $quickMem;
        echo json_encode($result);
        exit;
    }
    public function ajaxMentionEmail($oauth_arg = null)
    {
        $oauth_return = 0;
        
        $data = $this->data;

        $getEmailUser = $this->getAllExistingNotifyUser($data['projId'], $data['emailUser'], 'mention_case');
        if ($getEmailUser) {
            $this->Postcase->mailToMentionUser($data, $getEmailUser);
        }
        
        echo 1;
        exit;
    }

    public function saveProjectColumns()
    {
        $this->loadModel('ProjectField');
        $field_name_arr = array();
        $fields = $this->ProjectField->find('first', array('conditions' => array('ProjectField.user_id' => SES_ID)));
        if (!empty($fields)) {
            $field_name = explode(',', $this->request->data['cols']);
            $field_name = !empty($field_name)?$field_name:array('No Fields');
            $field_names = json_encode($field_name);
            $this->ProjectField->id=$fields['ProjectField']['id'];
            $this->ProjectField->set(array('field_name'=>$field_names));
            $this->ProjectField->save();
        } else {
            $field_name = explode(',', $this->request->data['cols']);
            $field_name = !empty($field_name)?$field_name:array('No Fields');
            $field_names = json_encode($field_name);
            $postdata['ProjectField']['field_name'] = $field_names;
            $postdata['ProjectField']['user_id'] = SES_ID;
            $postdata['ProjectField']['created'] = date('Y-m-d H:i:s');
            $postdata['ProjectField']['modified'] = date('Y-m-d H:i:s');
            $this->ProjectField->save($postdata);
        }
        Cache::delete('project_field_'.SES_ID);
        echo 1;
        exit;
    }
    public function updateBillableType()
    {
        $this->layout = "ajax";
        $data = $this->request->data ;
        // echo "<pre>";print_r($data);exit;
        $arr["status"] = 0;
        $this->loadModel("LogTime");
        if (count($data) > 0) {
            foreach ($data["log_id"] as $k=>$v) {
                $this->LogTime->id=$v;
                $this->LogTime->saveField("is_billable", $data["billable_type"]);
            }
            $arr["status"] = 1;
            $arr["msg"] = $data["billable_type"] == 1 ? __("Billable type successfully changed to billable") : __("Billable type successfully changed to non-billable");
        } else {
            $arr["msg"] = __("Please select a time log to change the billable type");
        }
        echo json_encode($arr);
        exit;
    }
    /*
    Author:c pattnaik
    function to get the timelog list of a task
    input parameter task uniq_id
    */
    public function ajaxShowTimeLogList()
    {
        $is_active_case = 0;
        $this->layout ="ajax";
        $task_uniq_id = $this->request->data['taskUniqId'];
        $is_active_case = ($this->request->data['is_active_case']) ? $this->request->data['is_active_case'] : 0 ;
        $taskdetails = $this->Easycase->findByUniqId($task_uniq_id, array('Easycase.*'), array('Easycase.id' => 'asc'));
        $caseLegendRep = $taskdetails['Easycase']['legend'];
        $sub_cnd = array('parent_task_id' => $taskdetails['Easycase']['id'], 'project_id' => $taskdetails['Easycase']['project_id']);
        $project_details =  $this->Project->findById($taskdetails['Easycase']['project_id']);
        $prjid = $project_details['Project']['id'];
        $curCaseId = $taskdetails['Easycase']['id'];
        $caseTitleRep = $taskdetails['Easycase']['title'];
        $caseUniqId = $task_uniq_id;
        $projUniqId = $project_details['Project']['uniq_id'];
        $ProjName = $project_details['Project']['name'];
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        /*    'pgShLbl' => $pgShLbl,
            'csPage' => $csPage,
            'page_limit' => $page_limit,
            'caseCount' => $caseCount, */
        $fields = "LogTime.*,"
                . " DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1, Project.uniq_id,"
                . "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name,"
                #. "(SELECT title FROM easycases AS `Easycase` WHERE `Easycase`.id=LogTime.task_id  LIMIT 1) AS task_name,"
                . "(SELECT `Type`.`name` FROM `types` AS `Type` WHERE `Type`.id=(SELECT type_id FROM easycases AS `Easycase` WHERE `Easycase`.id=LogTime.task_id  LIMIT 1) LIMIT 1) AS type_name";
        $this->LogTime->bindModel(array('belongsTo' => array('Project' => array('className' => 'Project','foreignKey' => 'project_id',))));
        if (SES_TYPE < 3 || $this->Format->isAllowed('View All Timelog', $roleAccess)) {
            $logtimes = $this->LogTime->find('all', array('conditions' => array("LogTime.project_id" => $prjid, "LogTime.task_id" => $curCaseId),
                'fields' => $fields,
                'order' => 'created DESC'
            ));
        } elseif (SES_TYPE == 3) {
            $logtimes = $this->LogTime->find('all', array('conditions' => array("LogTime.project_id" => $prjid, "LogTime.task_id" => $curCaseId, "LogTime.user_id" => SES_ID),
                'fields' => $fields,
                'order' => 'created DESC'
            ));
        }
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {
                $logtimes[$key]['LogTime']['description'] = preg_replace('/<script.*>.*<\/script>/ims', '', $logtimes[$key]['LogTime']['description']);
                $logtimes[$key]['LogTime']['description'] = $frmt->formatCms($logtimes[$key]['LogTime']['description']);
                //$logtimes[$key]['LogTime']['description'] = h($logtimes[$key]['LogTime']['description']);
                $logtimes[$key]['LogTime']['start_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]['LogTime']['start_datetime'], "datetime");
                $logtimes[$key]['LogTime']['end_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]['LogTime']['end_datetime'], "datetime");

                $logtimes[$key][0]['start_datetime_v1'] = date('M d Y H:i:s', strtotime($logtimes[$key]['LogTime']['start_datetime']));
                $logtimes[$key]['LogTime']['start_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['start_datetime']));
                $logtimes[$key]['LogTime']['end_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['end_datetime']));

                if ($logtimes[$key]['LogTime']['timesheet_flag'] == 1) {
                    $logtimes[$key]['LogTime']['start_time'] = '--';
                    $logtimes[$key]['LogTime']['end_time'] = '--';
                }
            }
        }
        $usrCndn = '';
        if (SES_TYPE == 3 && !$this->Format->isAllowed('View All Timelog', $roleAccess)) {
            $usrCndn = " AND user_id = " . SES_ID;
        }
        $cntlog = $this->LogTime->query('SELECT sum(total_hours) as secds,is_billable FROM log_times WHERE is_billable = 1 and project_id = "' . $prjid . '" ' . $usid . $st_dt . " AND task_id='" . $curCaseId . "'" . $usrCndn . " GROUP BY project_id  "
                . 'UNION '
                . 'SELECT sum(total_hours) as secds, is_billable FROM log_times WHERE is_billable = 0 and project_id ="' . $prjid . '" ' . $usid . $st_dt . " AND task_id='" . $curCaseId . "'" . $usrCndn . " GROUP BY project_id ");

        $thoursbillable = $cntlog[0][0]['is_billable'] == "1" ? $cntlog[0][0]['secds'] : 0;
        $thours = ($cntlog[0][0]['secds'] + $cntlog[1][0]['secds']);
        $totalHrs = ($thours);
        $hours = $thours;
        $nonbillableHrs = $totalHrs - $thoursbillable;

        $cntestmhrs = $this->Easycase->query("SELECT sum(estimated_hours) as hrs FROM easycases WHERE project_id = '" . $prjid . "' AND id='" . $curCaseId . "'");

        $logtimesArr = array('logs' => $logtimes,
            'task_id' => $curCaseId,
            'task_title' => $caseTitleRep,
            'task_uniqId' => $caseUniqId,
            'project_uniqId' => $projUniqId,
            'project_name' => $ProjName,
            'pgShLbl' => $pgShLbl,
            'csPage' => $csPage,
            'page_limit' => $page_limit,
            'caseCount' => $caseCount,
            'page' => 'taskdetails',
            'details' => array(
                'totalHrs' => $totalHrs,
                'billableHrs' => $thoursbillable,
                'nonbillableHrs' => $nonbillableHrs,
                'estimatedHrs' => $cntestmhrs[0][0]['hrs'],
            )
        );
        $data['logtimes'] = $logtimesArr;
        $data["is_active"] = $taskdetails['Easycase']['isactive']; //task is active
        $data["is_inactive_case"] = $is_active_case;
        echo json_encode($data);
        exit;
    }
}
