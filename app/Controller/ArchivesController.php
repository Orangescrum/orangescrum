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

class ArchivesController extends AppController
{
    public $name = 'Archive';
    public $components = array('Format', 'Tmzone');
    public $uses = array('Easycase', 'ProjectUser', 'Milestone', 'Archive');

    public function listall()
    {
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
            $casecnt = "SELECT Easycase.id,Easycase.title,Easycase.uniq_id,Easycase.format,Easycase.case_no,Easycase.type_id,"
                    . "Easycase.legend,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,Archive.dt_created,"
                    . " User.name, User.last_name, User.short_name FROM easycases as Easycase,archives as Archive, users as User "
                    . "WHERE Easycase.id=Archive.easycase_id AND Easycase.user_id=User.id AND " . $clt_sql . " AND Archive.type = '1' "
                    . "AND Archive.company_id ='" . SES_COMP . "' " . $qry . " AND Easycase.project_id != '0';";
            #echo $casecnt;
            $caseCount1 = $this->Easycase->query($casecnt);
            $caseCount = count($caseCount1);
            $this->set('caseCount', $caseCount);
            $filecnt = "SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.user_id,Easycase.dt_created,Easycase.istype,"
                    . "Easycase.project_id,CaseFile.*,Archive.dt_created FROM easycases as Easycase,case_files as CaseFile,"
                    . "archives as Archive WHERE Archive.case_file_id=CaseFile.id AND Easycase.id=CaseFile.easycase_id AND "
                    . "Easycase.isactive='1' AND " . $clt_sql . " AND CaseFile.isactive = '0' AND Archive.type='1' AND "
                    . "Archive.company_id ='" . SES_COMP . "' " . $qry . " AND Easycase.project_id != '0'";
            #echo $filecnt;exit;
            $caseCount11 = $this->Easycase->query($filecnt);
            $caseCountt = count($caseCount11);
            $this->set('fileCount', $caseCountt);
        }
    }

    public function milestone_list($uniq_id = null)
    {
        $this->layout = 'ajax';
        $page_limit = ARC_PAGE_LIMIT;
        $pjid = $this->params->data['pjid'];
        $casePage = isset($this->params->data['casePage']) ? (int) $this->params->data['casePage'] : 1;
        if ($pjid == "all") {
            if (SES_TYPE == 1 || SES_TYPE == 2) {
                $total_record1 = $this->Milestone->query("SELECT * FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id='" . SES_ID . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0 ");
            } else {
                $total_record1 = $this->Milestone->query("SELECT * FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.	user_id ='" . SES_ID . "' AND Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id='" . SES_ID . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0 ");
            }
            $total_records = count($total_record1);
            $this->set('total_records', $total_records);
            $page = $casePage;
            $limit1 = $page * $page_limit - $page_limit;
            $limit2 = $page_limit;
            if (SES_TYPE == 1 || SES_TYPE == 2) {
                $query = "SELECT * FROM milestones AS Milestone WHERE Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0  ORDER BY Milestone.start_date ASC LIMIT " . $limit1 . "," . $limit2;
            } else {
                $query = "SELECT * FROM milestones AS Milestone WHERE Milestone.	user_id ='" . SES_ID . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0  ORDER BY Milestone.start_date ASC LIMIT " . $limit1 . "," . $limit2;
            }
            $milestones = $this->Milestone->query($query);
            $count_mile = count($milestones);
            $this->set('count_mile', $count_mile);
            $this->set('page_limit', $page_limit);
            $this->set('casePage', $casePage);
            $this->set('list', $milestones);
            $this->set('pjid', 'all');
        } else {
            if (SES_TYPE == 1 || SES_TYPE == 2) {
                $total_record1 = $this->Milestone->query("SELECT * FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id='" . SES_ID . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0 AND Milestone.project_id = '" . $pjid . "'");
            } else {
                $total_record1 = $this->Milestone->query("SELECT * FROM milestones AS Milestone,project_users AS ProjectUser WHERE Milestone.	user_id ='" . SES_ID . "' AND Milestone.project_id=ProjectUser.project_id AND ProjectUser.user_id='" . SES_ID . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0 AND Milestone.project_id = '" . $pjid . "'");
            }
            $total_records = count($total_record1);
            $this->set('total_records', $total_records);
            $page = $casePage;
            $limit1 = $page * $page_limit - $page_limit;
            $limit2 = $page_limit;
            if (SES_TYPE == 1 || SES_TYPE == 2) {
                $query = "SELECT * FROM milestones AS Milestone WHERE Milestone.project_id ='" . $pjid . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0 ORDER BY Milestone.start_date ASC LIMIT " . $limit1 . "," . $limit2;
            } else {
                $query = "SELECT * FROM milestones AS Milestone WHERE Milestone.	user_id ='" . SES_ID . "' AND Milestone.project_id ='" . $pjid . "' AND Milestone.company_id='" . SES_COMP . "' AND Milestone.isactive=0 ORDER BY Milestone.start_date ASC LIMIT " . $limit1 . "," . $limit2;
            }

            $milestones = $this->Milestone->query($query);
            $count_mile = count($milestones);
            $this->set('count_mile', $count_mile);
            $this->set('page_limit', $page_limit);
            $this->set('casePage', $casePage);
            $this->set('list', $milestones);
            $this->set('pjid', $pjid);
        }
    }

    public function case_list($uniq_id = null)
    {
        $this->layout = 'ajax';
        //$page_limit = ARC_PAGE_LIMIT;
        //$page_limit = 10;

        $pjid = $this->params->data['pjid']; //echo $pjid;
        //$limit1 = $this->params->data['limit1'];
        //$limit2 = $this->params->data['limit2'];
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt = $view->loadHelper('Datetime');
        $casePage = isset($this->params->data['casePage']) ? (int) $this->params->data['casePage'] : 1;
        
        $getAllProj = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'ProjectUser.project_id'));
        if (!empty($getAllProj)) {
            $qry = '';
            $projIds = array();
            if ($_COOKIE['ARCHIVE_PROJECT'] != '' && $_COOKIE['ARCHIVE_PROJECT'] != 'all') {
                $prjids = $_COOKIE['ARCHIVE_PROJECT'];
                $qry = $qry . $this->Format->projectFilter($prjids);
            } else {
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
            }
            if ($_COOKIE['ARCHIVE_STATUS'] != '' && $_COOKIE['ARCHIVE_STATUS'] != 'all') {
                $arcstatus = $_COOKIE['ARCHIVE_STATUS'];
                $qry = $qry . $this->Format->statusFilter($arcstatus);
            }
            if ($_COOKIE['ARCHIVE_USER'] != '' && $_COOKIE['ARCHIVE_USER'] != 'all') {
                $arcuser = $_COOKIE['ARCHIVE_USER'];
                $qry = $qry . $this->Format->arcUserFilter($arcuser);
            }
            if ($_COOKIE['ARCHIVE_ASSIGNTO'] != '' && $_COOKIE['ARCHIVE_ASSIGNTO'] != 'all' && $_COOKIE['ARCHIVE_ASSIGNTO'] != 'unassigned') {
                $arcuser = $_COOKIE['ARCHIVE_ASSIGNTO'];
                $qry = $qry . $this->Format->assigntoFilter($arcuser);
            } elseif ($_COOKIE['ARCHIVE_ASSIGNTO'] != '' && $_COOKIE['ARCHIVE_ASSIGNTO'] != 'all' && $_COOKIE['ARCHIVE_ASSIGNTO'] == 'unassigned') {
                $qry = $qry . "And Easycase.assign_to = 0";
            }
            $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            $dates = '';
            if ($_COOKIE['ARCHIVE_DATE'] != '' && $_COOKIE['ARCHIVE_DATE'] != 'all') {
                $filter = trim($_COOKIE['ARCHIVE_DATE']);
                if (strstr(trim($filter), ":")) {
                    $ar_dt = explode(":", trim($filter));
                    $dates['strddt'] = $ar_dt['0'];
                    $dates['enddt'] = $ar_dt['1'];
                } else {
                    $dates = $this->Format->date_filter($filter, $curDateTime);
                }
            }
            if ($_COOKIE['ARCHIVE_DATE'] && ($filter == 'today' || $filter == 'yesterday')) {
                $qry = $qry . " AND DATE(`Archive`.`dt_created`) = '" . date('Y-m-d', strtotime($dates['strddt'])) . "'";
            //$st_dt = " AND DATE(start_datetime) = '" . date('Y-m-d', strtotime($data['strddt'])) . "'";
                //$timelog_filter_msg .= " for <b>" . date('M d, Y', strtotime($data['strddt'])) . "</b> ";
            } elseif (isset($dates['strddt']) && isset($dates['enddt'])) {
                $qry = $qry . " AND DATE(`Archive`.`dt_created`) >= '" . date('Y-m-d', strtotime($dates['strddt'])) . "' AND DATE(`Archive`.`dt_created`) <= '" . date('Y-m-d', strtotime($dates['enddt'])) . "'";
                //$st_dt = " AND DATE(start_datetime) >= '" . date('Y-m-d', strtotime($data['strddt'])) . "'";
                //$timelog_filter_msg .= "from <b>" . date('M d, Y', strtotime($data['strddt'])) . "</b> ";
            }
            $duedates = '';
            if ($_COOKIE['ARCHIVE_DUEDATE'] != '' && $_COOKIE['ARCHIVE_DUEDATE'] != 'all') {
                $due = trim($_COOKIE['ARCHIVE_DUEDATE']);
                if (strstr(trim($due), ":")) {
                    $ar_dt = explode(":", trim($due));
                    $duedates['strddt'] = $ar_dt['0'];
                    $duedates['enddt'] = $ar_dt['1'];
                } else {
                    $duedates = $this->Format->date_filter($due, $curDateTime);
                }
            }
            if ($_COOKIE['ARCHIVE_DUEDATE'] && ($due == 'today' || $due == 'yesterday')) {
                $qry = $qry . " AND DATE(`Easycase`.`due_date`) = '" . date('Y-m-d', strtotime($duedates['strddt'])) . "'";
            //$st_dt = " AND DATE(start_datetime) = '" . date('Y-m-d', strtotime($data['strddt'])) . "'";
                //$timelog_filter_msg .= " for <b>" . date('M d, Y', strtotime($data['strddt'])) . "</b> ";
            } elseif (isset($duedates['strddt']) && isset($duedates['enddt'])) {
                $qry = $qry . " AND DATE(`Easycase`.`due_date`) >= '" . date('Y-m-d', strtotime($duedates['strddt'])) . "' AND DATE(`Easycase`.`due_date`) <= '" . date('Y-m-d', strtotime($duedates['enddt'])) . "'";
                //$st_dt = " AND DATE(start_datetime) >= '" . date('Y-m-d', strtotime($data['strddt'])) . "'";
                //$timelog_filter_msg .= "from <b>" . date('M d, Y', strtotime($data['strddt'])) . "</b> ";
            }
            #echo $qry; exit;
            $clt_sql = 1;
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }

            if ($pjid == "all") {
                /* $caseqry1 = "SELECT SQL_CALC_FOUND_ROWS Easycase.id,Easycase.title,Easycase.uniq_id,Easycase.format,Easycase.case_no,Easycase.type_id,Easycase.parent_task_id,"
                  . "Easycase.legend,Easycase.user_id,Easycase.due_date,Easycase.dt_created,Easycase.istype,Easycase.project_id,Archive.dt_created,"
                  . "User.name, User.last_name, User.short_name "
                  . "FROM easycases AS Easycase,archives AS Archive, users AS User "
                  . "WHERE Easycase.id=Archive.easycase_id AND Easycase.user_id=User.id AND Archive.type = '1' "
                  . "AND Archive.company_id ='" . SES_COMP . "' " . $qry . " AND Easycase.project_id != '0' AND " . $clt_sql .";";
                $caseCount1 = $this->Easycase->query($caseqry1);
                $caseCount = count($caseCount1);
                  $this->set('caseCount', $caseCount); */
                $page = $casePage;
                //$limit1 = $page*$page_limit-$page_limit;
                //$limit2 = $page_limit;
                $limit1 = $this->params->data['limit1'];
                $limit2 = $this->params->data['limit2'];
                $caseqry = "SELECT SQL_CALC_FOUND_ROWS Easycase.id,Easycase.title,Easycase.uniq_id,Easycase.format,Easycase.case_no,Easycase.type_id,Easycase.parent_task_id,"
                        . "Easycase.legend,Easycase.user_id,Easycase.due_date,Easycase.dt_created,Easycase.istype,Easycase.project_id,Easycase.assign_to,Easycase.custom_status_id,Archive.dt_created, "
                        . "User.name, User.last_name, User.short_name, IF(Easycase.assign_to = 0,0,User.name) AS assign_to FROM easycases AS Easycase,archives AS Archive, users AS User "
                        . "WHERE Easycase.id=Archive.easycase_id AND Easycase.user_id=User.id AND Archive.type = '1' AND "
                        . "Archive.company_id ='" . SES_COMP . "' " . $qry . " AND Easycase.project_id != '0' AND " . $clt_sql . " "
                        . "ORDER BY Archive.dt_created DESC LIMIT " . $limit1 . "," . $limit2;
                #echo $caseqry;exit;
                $cse = $this->Easycase->query($caseqry);

                $tot = $this->Easycase->query("SELECT FOUND_ROWS() AS total");
                $caseCount = $tot[0][0]['total'];
                $this->set('caseCount', $caseCount);
                
                //$parent_task_id = array_filter(Hash::combine($cse, '{n}.Easycase.id', '{n}.Easycase.parent_task_id'));
                //$related_tasks = !empty($parent_task_id) ? $this->Easycase->getSubTasks($parent_task_id) : array();
                $related_tasks = array();
                $this->set('related_tasks', $related_tasks);

                $this->set('page_limit', $page_limit);
                $this->set('casePage', $casePage);
                $this->set('list', $cse);
                if (isset($this->params->data['lastCount']) && $this->params->data['lastCount'] != '') {
                    $this->set('lastCount', $this->params->data['lastCount']);
                } else {
                    $this->set('lastCount', 0);
                }
                $this->set('limit_one', $limit1);
                $this->set('pjid', 'all');
                $allStatus = $this->Format->getStatusByProject('all');
                if ($allStatus) {
                    $allStatus = Hash::combine($allStatus, '{n}.Project.id', '{n}.StatusGroup');
                }
                $this->set('allStatus', $allStatus);
            } else {

                /* $caseqry1 = "SELECT SQL_CALC_FOUND_ROWS Easycase.id,Easycase.title,Easycase.uniq_id,Easycase.format,Easycase.case_no,Easycase.type_id,Easycase.parent_task_id,"
                  . "Easycase.legend,Easycase.user_id,Easycase.due_date,Easycase.dt_created,Easycase.istype,Easycase.project_id,Archive.dt_created "
                  . "FROM easycases as Easycase,archives as Archive "
                  . "WHERE Easycase.id=Archive.easycase_id AND Archive.type = '1' AND Archive.company_id ='" . SES_COMP . "' "
                  . "AND " . $clt_sql . " AND Easycase.project_id = '" . $pjid . "'";
                  $caseCount1 = $this->Easycase->query($caseqry1);
                $caseCount = count($caseCount1);
                  $this->set('caseCount', $caseCount); */
                $page = $casePage;
                $limit1 = $page * $page_limit - $page_limit;
                $limit2 = $page_limit;

                $caseqry = "SELECT SQL_CALC_FOUND_ROWS Easycase.id,Easycase.title,Easycase.uniq_id,Easycase.format,Easycase.case_no,Easycase.type_id,Easycase.parent_task_id,"
                        . "Easycase.legend,Easycase.user_id,Easycase.due_date,Easycase.dt_created,Easycase.istype,Easycase.project_id,Easycase.custom_status_id,Archive.dt_created "
                        . "FROM easycases AS Easycase,archives AS Archive "
                        . "WHERE Easycase.id=Archive.easycase_id AND Archive.type = '1' AND Archive.company_id ='" . SES_COMP . "' "
                        . "AND " . $clt_sql . " AND Easycase.project_id = '" . $pjid . "' "
                        . "ORDER BY Archive.dt_created DESC LIMIT " . $limit1 . "," . $limit2;
                $cse = $this->Easycase->query($caseqry);

                $tot = $this->Easycase->query("SELECT FOUND_ROWS() AS total");
                $caseCount = $tot[0][0]['total'];
                $this->set('caseCount', $caseCount);

                //$parent_task_id = array_filter(Hash::combine($cse, '{n}.Easycase.id', '{n}.Easycase.parent_task_id'));
                //$related_tasks = !empty($parent_task_id) ? $this->Easycase->getSubTasks($parent_task_id) : array();
                $related_tasks = array();
                $this->set('related_tasks', $related_tasks);

                $this->set('page_limit', $page_limit);
                $this->set('casePage', $casePage);
                $this->set('list', $cse);
                $this->set('pjid', $pjid);
                $this->set('limit_one', $limit1);
                
                $allStatus = $this->Format->getStatusByProject($pjid);
                if ($allStatus) {
                    $allStatus = Hash::combine($allStatus, '{n}.Project.id', '{n}.StatusGroup');
                }
                $this->set('allStatus', $allStatus);
            }
        }
    }

    public function file_list($uniq_id = null)
    {
        $this->layout = 'ajax';
        $page_limit = ARC_PAGE_LIMIT;
        $pjid = $this->params->data['pjid'];
        $casePage = isset($this->params->data['casePage']) ? (int) $this->params->data['casePage'] : 1;

        $getAllProj = $this->ProjectUser->find('all', array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP), 'fields' => 'ProjectUser.project_id'));
        if (!empty($getAllProj)) {
            $clt_sql = 1;
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }

            if ($pjid == "all") {
                $qry = '';
                $projIds = array();
                if ($_COOKIE['ARCHIVE_FILE_PROJECT'] != '' && $_COOKIE['ARCHIVE_FILE_PROJECT'] != 'all') {
                    $prjids = $_COOKIE['ARCHIVE_FILE_PROJECT'];
                    $qry = $qry . $this->Format->projectFilter($prjids);
                } else {
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
                }
                if ($_COOKIE['ARCHIVE_FILE_USER'] != '' && $_COOKIE['ARCHIVE_FILE_USER'] != 'all') {
                    $arcuser = $_COOKIE['ARCHIVE_FILE_USER'];
                    $qry = $qry . $this->Format->arcUserFilter($arcuser);
                }
                $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");

                if ($_COOKIE['ARCHIVE_FILE_DATE'] != '' && $_COOKIE['ARCHIVE_FILE_DATE'] != 'all') {
                    $filter = trim($_COOKIE['ARCHIVE_FILE_DATE']);
                    if (strstr(trim($filter), ":")) {
                        $ar_dt = explode(":", trim($filter));
                        $dates['strddt'] = $ar_dt['0'];
                        $dates['enddt'] = $ar_dt['1'];
                    } else {
                        $dates = $this->Format->date_filter($filter, $curDateTime);
                    }
                }
                if ($_COOKIE['ARCHIVE_FILE_DATE'] && ($filter == 'today' || $filter == 'yesterday')) {
                    $qry = $qry . " AND DATE(`Archive`.`dt_created`) = '" . date('Y-m-d', strtotime($dates['strddt'])) . "'";
                //$st_dt = " AND DATE(start_datetime) = '" . date('Y-m-d', strtotime($data['strddt'])) . "'";
                    //$timelog_filter_msg .= " for <b>" . date('M d, Y', strtotime($data['strddt'])) . "</b> ";
                } elseif (isset($dates['strddt']) && isset($dates['enddt'])) {
                    $qry = $qry . " AND DATE(`Archive`.`dt_created`) >= '" . date('Y-m-d', strtotime($dates['strddt'])) . "' AND DATE(`Archive`.`dt_created`) <= '" . date('Y-m-d', strtotime($dates['enddt'])) . "'";
                    //$st_dt = " AND DATE(start_datetime) >= '" . date('Y-m-d', strtotime($data['strddt'])) . "'";
                    //$timelog_filter_msg .= "from <b>" . date('M d, Y', strtotime($data['strddt'])) . "</b> ";
                }
                //$caseCount11 = $this->Easycase->query("SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,CaseFile.*,Archive.dt_created FROM easycases as Easycase,case_files as CaseFile,archives as Archive WHERE Archive.case_file_id=CaseFile.id AND Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND CaseFile.isactive = '0' AND Archive.type='1' AND Archive.user_id='".SES_ID."' AND Archive.company_id ='".SES_COMP."' AND Easycase.project_id != '0';");
                $sql = "SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,CaseFile.*,Archive.dt_created FROM easycases as Easycase,case_files as CaseFile,archives as Archive WHERE Archive.case_file_id=CaseFile.id AND Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND " . $clt_sql . " AND CaseFile.isactive = '0' AND Archive.type='1' AND Archive.company_id ='" . SES_COMP . "' " . $qry . " AND Easycase.project_id != '0'";
                $caseCount11 = $this->Easycase->query($sql);
                $caseCountt = count($caseCount11);
                $this->set('caseCountt', $caseCountt);
                $page = $casePage;
                //$limit1 = $page*$page_limit-$page_limit;
                //$limit2 = $page_limit;
                $limit1 = $this->params->data['limit1'];
                $limit2 = $this->params->data['limit2'];
                //$file = $this->Easycase->query("SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,CaseFile.*,Archive.dt_created FROM easycases as Easycase,case_files as CaseFile,archives as Archive WHERE Archive.case_file_id=CaseFile.id AND Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND CaseFile.isactive = '0' AND Archive.type='1' AND Archive.user_id='".SES_ID."' AND Archive.company_id ='".SES_COMP."' AND Easycase.project_id != '0' ORDER BY Archive.dt_created DESC LIMIT ".$limit1.",".$limit2);//pr($file);exit;

                $file = $this->Easycase->query("SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,CaseFile.*,Archive.dt_created FROM easycases as Easycase,case_files as CaseFile,archives as Archive WHERE Archive.case_file_id=CaseFile.id AND Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND " . $clt_sql . " AND CaseFile.isactive = '0' AND Archive.type='1' AND Archive.company_id ='" . SES_COMP . "' " . $qry . " AND Easycase.project_id != '0' ORDER BY Archive.dt_created DESC LIMIT " . $limit1 . "," . $limit2); //pr($file);exit;
                $this->set('page_limit', $page_limit);
                $this->set('casePage', $casePage);
                $this->set('file', $file);
                $this->set('pjid', 'all');
                if (isset($this->params->data['lastCountFiles']) && $this->params->data['lastCountFiles'] != '') {
                    $this->set('lastCountFiles', $this->params->data['lastCountFiles']);
                } else {
                    $this->set('lastCountFiles', 0);
                }
            } else {
                $caseCount11 = $this->Easycase->query("SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,CaseFile.*,Archive.dt_created FROM easycases as Easycase,case_files as CaseFile,archives as Archive WHERE Archive.case_file_id=CaseFile.id AND Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND " . $clt_sql . " AND CaseFile.isactive = '0' AND Archive.type='1' AND Archive.company_id ='" . SES_COMP . "' AND Easycase.project_id = '" . $pjid . "';");
                $caseCountt = count($caseCount11);
                $this->set('caseCountt', $caseCountt);
                $page = $casePage;
                $limit1 = $page * $page_limit - $page_limit;
                $limit2 = $page_limit;
                $file = $this->Easycase->query("SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.user_id,Easycase.dt_created,Easycase.istype,Easycase.project_id,CaseFile.*,Archive.dt_created FROM easycases as Easycase,case_files as CaseFile,archives as Archive WHERE Archive.case_file_id=CaseFile.id AND Easycase.id=CaseFile.easycase_id AND Easycase.isactive='1' AND " . $clt_sql . " AND CaseFile.isactive = '0' AND Archive.type='1' AND Archive.company_id ='" . SES_COMP . "' AND Easycase.project_id = '" . $pjid . "' ORDER BY Archive.dt_created DESC LIMIT " . $limit1 . "," . $limit2); //pr($file);exit;
                $this->set('page_limit', $page_limit);
                $this->set('casePage', $casePage);
                $this->set('file', $file);
                $this->set('pjid', $pjid);
            }
        }
        /* $proj_all_cond = array(
          'conditions' => array('ProjectUser.user_id'=>SES_ID,'Project.isactive'=>1,'Project.company_id'=>SES_COMP),
          'fields' => array('DISTINCT Project.id','Project.name','Project.uniq_id'),
          'order' => array('ProjectUser.dt_visited DESC')
          );
          $ProjectUser = ClassRegistry::init('ProjectUser');
          $CompanyUser = ClassRegistry::init('CompanyUser');

          $projAll = $ProjectUser->find('all', $proj_all_cond);
          $this->set('projAll',$projAll); */
    }

    public function move_list()
    {
        $this->layout = 'ajax';
        $val = $this->params->data['val'];
        foreach ($val as $val) {
            if (isset($this->params->data['chk'])) {
                $qrr = $this->Easycase->query("UPDATE easycases SET isactive = '1' WHERE easycases.id ='" . $val . "'");
                $qrid = $this->Easycase->query("SELECT id,project_id,case_no FROM easycases WHERE easycases.id ='" . $val . "' order by easycases.id ASC");
            } else {
                $qrr = $this->Easycase->query("UPDATE easycases SET isactive = '1' WHERE easycases.uniq_id ='" . $val . "'");
                $qrid = $this->Easycase->query("SELECT id,project_id,case_no FROM easycases WHERE easycases.uniq_id ='" . $val . "' order by easycases.id ASC");
            }
            $CaseActivity = ClassRegistry::init('CaseActivity');
            $CaseActivity->recursive = -1;
            $CaseActivity->query("UPDATE case_activities SET isactive='1' WHERE project_id=" . $qrid['0']['easycases']['project_id'] . " AND case_no=" . $qrid['0']['easycases']['case_no']);
            $qrr = $this->Archive->query("UPDATE archives SET type = '2' WHERE easycase_id ='" . $qrid['0']['easycases']['id'] . "'");
            $caseDtl = $this->Easycase->getCaseIdFrmCaseNo($qrid['0']['easycases']['project_id'], $qrid['0']['easycases']['case_no']);
            if (!empty($caseDtl)) {
                if (isset($caseDtl['Easycase']['milestone_id'])) {
                    $this->loadModel('EasycaseMilestone');
                    $this->EasycaseMilestone->updtaeParentMilestone($caseDtl['Easycase']['milestone_id'], $qrid['0']['easycases']['id'], $qrid['0']['easycases']['project_id']);
                }
            }
            /*$child_tasks = $this->Easycase->getSubTaskChildInactive($caseId, $qrid['0']['easycases']['project_id']);
            if($child_tasks){
                pr($child_tasks);exit;
                foreach($child_tasks as $k => $v){

                }
            }*/
        }
        echo "success";
        exit;
    }

    public function restore_case()
    {
        $this->layout = 'ajax';
        $val = $this->params->data['val'];
        $qrr = $this->Easycase->query("UPDATE easycases SET isactive = '1' WHERE easycases.uniq_id ='" . $val . "'");
        $qrid = $this->Easycase->query("SELECT id,project_id,case_no FROM easycases WHERE easycases.uniq_id ='" . $val . "'");

        $CaseActivity = ClassRegistry::init('CaseActivity');
        $CaseActivity->recursive = -1;
        $CaseActivity->query("UPDATE case_activities SET isactive='1' WHERE project_id=" . $qrid['0']['easycases']['project_id'] . " AND case_no=" . $qrid['0']['easycases']['case_no']);
        $qrr = $this->Archive->query("UPDATE archives SET type = '2' WHERE easycase_id ='" . $qrid['0']['easycases']['id'] . "'");

        echo "success";
        exit;
    }

    public function milestone_move_list()
    {
        $this->layout = 'ajax';
        $val = $this->params->data['val'];
        foreach ($val as $val) {
            $qrr = $this->Milestone->query("UPDATE milestones SET isactive = '1' WHERE milestones.uniq_id ='" . $val . "'");
        }
        echo "success";
        exit;
    }

    public function milestone_remove()
    {
        $this->layout = 'ajax';
        $val = $this->params->data['val']; //print_r($val);
        foreach ($val as $val) {
            $qrid = $this->Milestone->query("SELECT id FROM milestones WHERE milestones.uniq_id ='" . $val . "'");
            if ($qrid['0']['milestones']['id']) {
                $this->Milestone->query("delete from milestones WHERE id ='" . $qrid['0']['milestones']['id'] . "'");
            }
        }
        echo "success";
        exit;
    }

    public function case_remove()
    {
        $this->layout = 'ajax';
        $val = $this->params->data['val'];
        $task_id = array();
        $case_no = array();
        $project_id = '';
        foreach ($val as $val) {
            //$getCase = $this->Easycase->find('first',array('conditions'=>array('Easycase.uniq_id'=>$val)));
            if (isset($this->params->data['chk'])) {
                $qrid = $this->Easycase->query("SELECT id, case_no, project_id FROM easycases WHERE easycases.id ='" . $val . "' AND easycases.istype =1");
            } else {
                $qrid = $this->Easycase->query("SELECT id, case_no, project_id FROM easycases WHERE easycases.uniq_id ='" . $val . "' AND easycases.istype =1");
            }
            $project_id = $qrid['0']['easycases']['project_id'];
            $task_id[$project_id][] = $qrid['0']['easycases']['id'];
            $case_no[$project_id][] = $qrid['0']['easycases']['case_no'];
            $this->update_dependancy($qrid['0']['easycases']['id'], $project_id);
        }
        if (!empty($task_id) && is_array($task_id)) {
            foreach ($task_id as $pid => $task) {
                $this->Easycase->deleteTasksRecursively($task, $pid, '', 0);
            }
        }
        echo "success";
        exit;
    }

    public function move_file()
    {
        $this->layout = 'ajax';
        $val = $this->params->data['val'];
        $this->loadModel('CaseFile');
        foreach ($val as $val) {
            $qur = $this->CaseFile->query("UPDATE case_files SET isactive = '1' WHERE case_files.id =" . $val);
            $qrr = $this->Archive->query("UPDATE archives SET type = '2' WHERE case_file_id ='" . $val . "'");

            $getFiles = $this->CaseFile->find('first', array('conditions' => array('CaseFile.id' => $val)));
            $checkFiles = $this->CaseFile->find('all', array('conditions' => array('CaseFile.easycase_id' => $getFiles['CaseFile']['easycase_id'], 'CaseFile.isactive' => 1)));
            if (count($checkFiles) == 0) {
                $this->Easycase->query("UPDATE easycases SET format='2' WHERE id='" . $getFiles['CaseFile']['easycase_id'] . "'");
            } else {
                if (count($checkFiles) == 1) {
                    $cur_data = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $getFiles['CaseFile']['easycase_id']), 'fields' => array('Easycase.id','Easycase.case_no', 'Easycase.project_id','Easycase.format', 'Easycase.message','Easycase.istype')));
                    if (empty($cur_data['Easycase']['message']) && $cur_data['Easycase']['istype'] == 2) {
                        $this->Easycase->updateAll(array('thread_count'=>'thread_count+1'), array('project_id' => $cur_data['Easycase']['project_id'], 'case_no' => $cur_data['Easycase']['case_no'], 'istype' => 1));
                    }
                }
                $this->Easycase->query("UPDATE easycases SET format='1' WHERE id='" . $getFiles['CaseFile']['easycase_id'] . "'");
            }
        }
        echo "success";
        exit;
    }

    public function file_remove()
    {
        $this->layout = 'ajax';
        $val = $this->params->data['val'];
        $this->loadModel('CaseFile');
        $caseRemovedFile = ClassRegistry::init('CaseRemovedFile');
        foreach ($val as $val) {
            //$qrr = $this->Archive->query("UPDATE archives SET type = '3' WHERE case_file_id ='".$val."'");
            $datacaseR = null;
            $getFiles = $this->CaseFile->find('first', array('conditions' => array('CaseFile.id' => $val)));
            @unlink(DIR_CASE_FILES . $getFiles['CaseFile']['file']);
            $this->CaseFile->query("delete from case_files WHERE id ='" . $val . "'");

            $this->Archive->query("delete from archives WHERE case_file_id ='" . $val . "'");
                        
            $datacaseR['CaseRemovedFile']['case_file_id'] = $val;
            $datacaseR['CaseRemovedFile']['project_id'] = $getFiles['CaseFile']['project_id'];
            $datacaseR['CaseRemovedFile']['user_id'] = SES_ID;
            $datacaseR['CaseRemovedFile']['company_id'] = SES_COMP;
            $datacaseR['CaseRemovedFile']['case_file_name'] = !empty($getFiles['CaseFile']['upload_name'])?$getFiles['CaseFile']['upload_name']:$getFiles['CaseFile']['file'];
            $caseRemovedFile->saveAll($datacaseR);
            
            $cur_data = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $getFiles['CaseFile']['easycase_id']), 'fields' => array('Easycase.id','Easycase.case_no', 'Easycase.project_id','Easycase.format', 'Easycase.message','Easycase.istype')));
            if ($cur_data) {
                $org_data = $this->Easycase->find('list', array('conditions' => array('Easycase.project_id' => $cur_data['Easycase']['project_id'], 'Easycase.case_no' => $cur_data['Easycase']['case_no']), 'fields' => array('Easycase.id')));
                $files = $this->CaseFile->find('list', array('conditions' => array('CaseFile.company_id' => SES_COMP, 'CaseFile.easycase_id' => $org_data, 'CaseFile.isactive' => 1),'fields'=>array('CaseFile.id','CaseFile.easycase_id')));
                if (empty($cur_data['Easycase']['message']) && $cur_data['Easycase']['istype'] == 2 && !in_array($cur_data['Easycase']['id'], $files)) {
                    $this->Easycase->updateAll(array('thread_count'=>'thread_count-1'), array('project_id' => $cur_data['Easycase']['project_id'], 'case_no' => $cur_data['Easycase']['case_no'], 'istype' => 1));
                }
                if (empty($files)) {
                    $this->Easycase->updateAll(array('format' => 2), array('id' => $org_data, 'project_id' => $cur_data['Easycase']['project_id'], 'case_no' => $cur_data['Easycase']['case_no'], 'istype' => 1));
                }
            }
        }

        echo "success";
        exit;
    }

    public function ajax_projectall_size()
    {
        $this->layout = 'ajax';
        $proj_id = null;

        $company = SES_COMP;
        if (isset($this->params->data['comp'])) {
            $company = $this->params->data['comp'];
        }
        $this->set('type', @$this->params->data['type']);
        $this->set('company', @$company);
    }

    public function ajax_project_access()
    {
        $this->layout = 'ajax';
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $ProjectUser->recursive = -1;
        $latestactivity = $ProjectUser->find('first', array('conditions' => array('ProjectUser.user_id =' => SES_ID), 'fields' => array('dt_visited', 'project_id'), 'order' => array('ProjectUser.dt_visited DESC')));

        $projArr = $latestactivity['ProjectUser']['project_id'];
        $this->loadModel('Project');
        $this->Project->recursive = -1;
        $projArr = $this->Project->find('first', array('conditions' => array('Project.id' => $projArr, 'Project.isactive' => 1), 'fields' => array('Project.name', 'Project.id', 'Project.uniq_id')));

        $this->set('dt_visited', $latestactivity['ProjectUser']['dt_visited']);

        $this->set('projArr', $projArr);
    }

    public function common_filter_det()
    {
        $this->layout = 'ajax';
        $type = $this->params->data['type'];
        $filDate = $this->params->data['arcFilDate'];
        $filUser = $this->params->data['arcFilUser'];
        $filProj = $this->params->data['arcFilProject'];
        if ($type == 'task') {
            $filStatus = $this->params->data['arcFilStatus'];
            $filDuedate = $this->params->data['arcFilDuedate'];
            $filassignto = $this->params->data['arcFilAssign'];
        }
        //pr($this->params);
        if (isset($filStatus) && $filStatus) {
            $case_status = $filStatus;
        }
        if ($case_status && $case_status != "all") {
            //$case_status = strrev($case_status); //commented
            if (strstr($case_status, "-")) {
                $expst = explode("-", $case_status);
                foreach ($expst as $st) {
                    //$status.= $this->Format->displayStatus($st).", ";
                    $status .= "<span class='filter_opn' rel='tooltip' title='".__('Task Status', true)."' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"casestatus\");setcheck(\"casestatus\",\"" . $st . "\");'>" . $this->Format->displayStatus($st) . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"casestatus\",\"" .$st . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->displayStatus($st).", ";
                    //removed strrev($st) to $st
                }
            } else {
                $status = "<span class='filter_opn' rel='tooltip' title='".__('Task Status', true)."' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"casestatus\");setcheck(\"casestatus\",\"" . $case_status . "\");'>" . $this->Format->displayStatus($case_status) . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"casestatus\",\"" . $case_status . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; //$this->Format->displayStatus($case_status).", ";
            }
            $arr['case_status'] = trim($status, ', ');
            $val = 1;
        } else {
            $arr['case_status'] = 'All';
        }


        if (isset($filDuedate) && $filDuedate) {
            $case_duedate = $filDuedate;
        }
        if (!empty($case_duedate) && $case_duedate != 'all') {
            $val = 1;
            if (strstr(trim($case_duedate), ":")) {
                $arr['duedate'] = "<span class='filter_opn' rel='tooltip' title='".__('Due Date', true)."' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"archiveduedate\");'>" . str_replace(":", " - ", $case_duedate) . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"archiveduedate\",\"custom\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; // str_replace(":"," - ",$date);
            } else {
                $duedate = $this->Format->arcDateFiltxt($case_duedate);
                $arr['duedate'] = "<span class='filter_opn' rel='tooltip' title='".__('Due Date', true)."' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"archiveduedate\");setcheck(\"archiveduedate\",\"" . $case_duedate . "\");'>" . $duedate . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"archiveduedate\",\"" . $case_duedate . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
        } else {
            $arr['duedate'] = "alldates";
        }


        if (isset($filDate) && $filDate) {
            $case_date = $filDate;
        }
        if (!empty($case_date) && $case_date != 'all') {
            $val = 1;
            if (strstr(trim($case_date), ":")) {
                $arr['archivedate'] = "<span class='filter_opn' rel='tooltip' title='".__('Archived Date', true)."' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"casedate\");'>" . str_replace(":", " - ", $case_date) . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"casedate\",\"custom\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; // str_replace(":"," - ",$date);
            } else {
                $casedate = $this->Format->arcDateFiltxt($case_date);
                $arr['archivedate'] = "<span class='filter_opn' rel='tooltip' title='".__('Archived Date', true)."' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"casedate\");setcheck(\"casedate\",\"" . $case_date . "\");'>" . $casedate . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"casedate\",\"" . $case_date . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
        } else {
            $arr['archivedate'] = "alldates";
        }


        if (isset($filUser) && $filUser) {
            $assignto = $filUser;
        }
        if ($assignto && $assignto != "all") {
            if (strstr($assignto, "-")) {
                $expst5 = explode("-", $assignto);
                $asmembers = $this->Format->caseMemsList($expst5);
                foreach ($asmembers as $key => $st5) {
                    $asns .= "<span class='filter_opn' rel='tooltip' title='".__('Archived by', true)." " . $this->Format->caseMemsName($key) . "' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"archivedby\");'>" . $st5 . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"archivedby\",\"" . $key . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $asns = "<span class='filter_opn' rel='tooltip' title='".__('Archived by', true)." " . $this->Format->caseMemsName($assignto) . "' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"archivedby\");'>" . $this->Format->caseMemsList($assignto) . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"archivedby\",\"" . $assignto . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
            $arr['archived_by'] = $asns;
            $val = 1;
        } else {
            $arr['archived_by'] = 'all';
        }
        if (isset($filassignto) && $filassignto) {
            $assign = $filassignto;
        }
        if ($assign && $assign != "all" && $assign != "unassigned") {
            if (strstr($assign, "-")) {
                $expst5 = explode("-", $assign);
                $asmembers = $this->Format->caseMemsList($expst5);
                foreach ($asmembers as $key => $st5) {
                    $asnss .= "<span class='filter_opn' rel='tooltip' title='".__('Assign to', true)." " . $this->Format->caseMemsName($key) . "' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"archiveassign\");'>" . $st5 . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"archiveassign\",\"" . $key . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $asnss = "<span class='filter_opn' rel='tooltip' title='".__('Assign to', true)." " . $this->Format->caseMemsName($assign) . "' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"archiveassign\");'>" . $this->Format->caseMemsList($assign) . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"archiveassign\",\"" . $assign . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
            $arr['assignto'] = $asnss;
            $val = 1;
        } elseif ($assign == "unassigned") {
            $asnss = "<span class='filter_opn' rel='tooltip' title='".__('Assign to Nobody', true)."' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"archiveassign\");'>Unassigned<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"archiveassign\",\"unassign\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            $arr['assignto'] = $asnss;
            $val = 1;
        } else {
            $arr['assignto'] = 'all';
        }

        if (isset($filProj) && $filProj) {
            $arcprj = $filProj;
        }
        if ($arcprj && $arcprj != "all") {
            if (strstr($arcprj, "-")) {
                $expst5 = explode("-", $arcprj);
                foreach ($expst5 as $key => $val) {
                    $prjsnm = $this->Format->formatprjnm($val);
                    $prj .= "<span class='filter_opn' rel='tooltip' title='Project' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"project\");'>" . $prjsnm . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"project\",\"" . $val . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                }
            } else {
                $prj = "<span class='filter_opn' rel='tooltip' title='Project' onclick='openfilter_popup(1,\"dropdown_menu_archive_filters\");allfiltervalue(\"project\");'>" . $this->Format->formatprjnm($arcprj) . "<a href='javascript:void(0);' onclick='common_reset_archive_filter(\"project\",\"" . $arcprj . "\",this,event);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
            }
            $arr['project'] = $prj;
            $val = 1;
        } else {
            $arr['project'] = 'all';
        }

        $arr['val'] = $val;
        echo json_encode($arr);
        exit;
    }
}
