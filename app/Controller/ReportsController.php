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
require_once(ROOT . DS . 'app' . DS . 'Vendor' . DS . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel.php');
class ReportsController extends AppController {
    var $helpers = array('Html', 'Form', 'Casequery', 'Format');
    var $name = 'Report';
    public $components = array('Format', 'Tmzone');
    var $paginate = array();
    var $report_type = array('1' => 'Task', '2' => 'Hour', '3' => 'Bug', '4' => 'Project');

    function chart() {
        //ob_clean();
        if(!$this->Format->isAllowed('View Task Report')){
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');
				}
        $this->loadModel('ProjectUser');
        $this->loadModel('SaveReport');

        if (isset($this->params['pass']['0']) && !empty($this->params['pass']['0'])) {
            $this->loadModel('Project');
            if ($this->params['pass']['0'] == 'ajax') {
                $this->layout = 'ajax';
            }
            $prj = $this->params['pass']['0'] != 'ajax' ? $this->params['pass']['0'] : $this->params['pass']['1'];

            $projarr = $this->Project->query("SELECT id,name FROM projects WHERE uniq_id='" . $prj . "' AND company_id='" . SES_COMP . "'");
            $proj_id = $projarr['0']['projects']['id'];
            $this->set('pjid', $proj_id);
            $this->set('pjname', $projarr['0']['projects']['name']);
            $type_id = 0;
            $this->set('proj_uniq', $prj);

            $this->Project->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE user_id=" . SES_ID . " and project_id='" . $proj_id . "' and company_id='" . SES_COMP . "'");
        }

        $proj_all_cond = array(
            'recursive' => '1',
            'conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP, 'Project.isactive' => 1),
            'fields' => array('Project.id', 'Project.uniq_id'),
            'order' => array('ProjectUser.dt_visited DESC')
        );
        $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
        $projAll = $this->ProjectUser->find('list', $proj_all_cond);
        $this->set('projAll', $projAll);

        if (!isset($this->params['pass']['0'])) {
            foreach ($projAll as $pid => $puid) {
                $this->set('pjid', $pid);
                $this->set('proj_uniq', $puid);
                break;
            }
        }
        if (isset($this->params['pass']['0']) && !empty($this->params['pass']['0'])) {
            if (!in_array($prj, $projAll)) {
              //  $this->Session->write("ERROR", __("Unauthorized URL",true));
                $this->redirect(HTTP_ROOT . "task-report");
            }
        }

        $rptdata = $this->SaveReport->find('all', array('conditions' => array('user_id' => SES_ID)));
        if (!empty($rptdata)) {
            $this->set('frm', date('M d, Y', strtotime($rptdata[0]['SaveReport']['frm_dt'])));
            $this->set('to', date("M d, Y", strtotime($rptdata[0]['SaveReport']['to_dt'])));
            $before = $this->Format->chgdate(date('M d, Y', strtotime($rptdata[0]['SaveReport']['frm_dt'])));
            $to = $this->Format->chgdate(date('M d, Y', strtotime($rptdata[0]['SaveReport']['to_dt'])));
            $days = (strtotime($to) - strtotime($before)) / (60 * 60 * 24);
        } else {
            $timezone_offset = TZ_GMT;
            $cur_time = date('Y-m-d H:i:s', (strtotime(GMT_DATETIME) + ($timezone_offset * 60 * 60)));
            $before = date('Y-m-d H:i:s', strtotime($cur_time . "-7 day"));
            $days = (strtotime(date("Y-m-d H:i:s")) - strtotime($before)) / (60 * 60 * 24) + 1;
            $this->set('frm', date('M d, Y', strtotime($cur_time . "-7 day")));
            $this->set('to', date("M d, Y"));
        }
    }

    function convertinto_array($arr = '', $t = 0) {
        $ret_arr = array();
        global $resolved_type_arr;
        $resolved_type_arr = array();
        if (is_array($arr)) {
            foreach ($arr AS $key => $val) {
                foreach ($val AS $k => $v) {
                    if ($t) {
                        $ret_arr[$v['cdate']] = isset($ret_arr[$v['cdate']]) ? ($ret_arr[$v['cdate']] + $v['count']) : $v['count'];
                        $resolved_type_arr[$v['cdate']][$v['tid']] = $v['count'];
                    } else {
                        $ret_arr[$v['cdate']] = $v['count'];
                    }
                }
            }
        }
        return $ret_arr;
    }

    function glide_chart() {
        //ob_clean();
        $this->loadModel('ProjectUser');
        $this->loadModel('SaveReport');

        if (isset($this->params['pass']['0']) && !empty($this->params['pass']['0'])) {
            $this->loadModel('Project');
            if ($this->params['pass']['0'] == 'ajax') {
                $this->layout = 'ajax';
            }
            $prj = $this->params['pass']['0'] != 'ajax' ? $this->params['pass']['0'] : $this->params['pass']['1'];
            $projarr = $this->Project->query("SELECT id,name FROM projects WHERE uniq_id='" . $prj . "' AND company_id='" . SES_COMP . "'");
            $proj_id = $projarr['0']['projects']['id'];
            $this->set('pjid', $proj_id);
            $this->set('pjname', $projarr['0']['projects']['name']);
            $type_id = 0;
            $this->set('proj_uniq', $prj);

            $this->Project->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE user_id=" . SES_ID . " and project_id='" . $proj_id . "' and company_id='" . SES_COMP . "'");
        }

        $proj_all_cond = array(
            'recursive' => '1',
            'conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP, 'Project.isactive' => 1),
            'fields' => array('Project.id', 'Project.uniq_id'),
            'order' => array('ProjectUser.dt_visited DESC')
        );
        $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
        $projAll = $this->ProjectUser->find('list', $proj_all_cond);
        $this->set('projAll', $projAll);

        if (!isset($this->params['pass']['0'])) {
            foreach ($projAll as $pid => $puid) {
                $this->set('pjid', $pid);
                $this->set('proj_uniq', $puid);
                break;
            }
        }
        if (isset($this->params['pass']['0']) && !empty($this->params['pass']['0'])) {
            if (!in_array($prj, $projAll)) {
              // $this->Session->write("ERROR", __("Unauthorized URL",true));
                $this->redirect(HTTP_ROOT . "bug-report");
            }
        }
        //$timezone_offset = $_COOKIE['SES_TZ']['GMT'];

        $rptdata = $this->SaveReport->find('all', array('conditions' => array('user_id' => SES_ID)));
        if (!empty($rptdata)) {
            $this->set('frm', date('M d, Y', strtotime($rptdata[0]['SaveReport']['frm_dt'])));
            $this->set('to', date("M d, Y", strtotime($rptdata[0]['SaveReport']['to_dt'])));
            $before = $this->Format->chgdate(date('M d, Y', strtotime($rptdata[0]['SaveReport']['frm_dt'])));
            $to = $this->Format->chgdate(date('M d, Y', strtotime($rptdata[0]['SaveReport']['to_dt'])));
            $days = (strtotime($to) - strtotime($before)) / (60 * 60 * 24);
        } else {
            $timezone_offset = TZ_GMT;
            $cur_time = date('Y-m-d H:i:s', (strtotime(GMT_DATETIME) + ($timezone_offset * 60 * 60)));
            $before = date('Y-m-d H:i:s', strtotime($cur_time . "-7 day"));
            $days = (strtotime(date("Y-m-d H:i:s")) - strtotime($before)) / (60 * 60 * 24) + 1;
            $this->set('frm', date('M d, Y', strtotime($cur_time . "-7 day")));
            $this->set('to', date("M d, Y"));
        }
    }

    /**
     * @method: Public weeklyusage_report() Weekly usage Report for admin and owner only
     * @author GDR<abc@mydomain.com>
     * @return HTML html page with usage details
     */
    function weeklyusage_report() {
        if (SES_TYPE > 2 && !$this->Format->isAllowed('View Weekly Usage')) {
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.',true));
            $this->redirect(HTTP_ROOT.'dashboard');exit;
        }
        $easycasecls = ClassRegistry::init('Easycase');
        $companyusercls = ClassRegistry::init('CompanyUser');
        $projectcls = ClassRegistry::init('Project');
        $projectcls->recursive = -1;

        //$usernotificationcls = ClassRegistry::init('UserNotification');
        //$user_ids = $companyusercls->find('list',array('conditions'=>array('user_type < '=>3,'is_active'=>1,'user_id'),'fields'=>array('id','user_id')));
        //$user_lists = $usernotificationcls->find('list',array('conditions'=>array('user_id'=>SES_ID,'weekly_usage_alert'=>1),'fields'=>array('id','user_id')));
        $companyusercls->recursive = -1;
        $user_details = $companyusercls->find('all', array('joins' => array(
                array('table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => array('CompanyUser.user_id = User.id', 'User.id' => SES_ID, 'CompanyUser.is_active' => 1, 'CompanyUser.user_type <= ' => 3)),
                array('table' => 'companies',
                    'alias' => 'Company',
                    'type' => 'inner',
                    'conditions' => array('CompanyUser.company_id=Company.id', 'CompanyUser.company_id' => SES_COMP, 'Company.is_active!=0'))), 'fields' => "Company.id,DATE(Company.created) AS dt_created,User.timezone_id,User.id,User.name,User.last_name,User.email,Company.name,Company.seo_url"));
        //$prv_date = date('Y-m-d',  strtotime('-1 week'));
        //$last_week_date = date('Y-m-d',  strtotime('-2 week'));
        $prv_date = date('Y-m-d', strtotime('last monday'));
        $last_week_date = date('Y-m-d', strtotime('last monday', strtotime($prv_date)));
        $this->set('last_week_date', $last_week_date);
        $this->set('prv_date', $prv_date);
        $days_diff = (strtotime(date('Y-m-d')) - strtotime($prv_date)) / (24 * 60 * 60);
        $this->set('days_diff', $days_diff);
				$last7days = array();
        for ($i = 0; $i <= $days_diff; $i++) {
            $last7days[] = date('Y-m-d', strtotime('-' . $i . ' day'));
        }
        $this->set('last7days', $last7days);
        $timezone_details = '';
        $timezone_details = $tzone[$user_details['0']['User']['timezone_id']];
        $dateCurnt = $this->Tmzone->GetDateTime($user_details['0']['User']['timezone_id'], TZ_GMT, TZ_DST, '', GMT_DATETIME, "datetime");
        $this->set('dateCurnt', $dateCurnt);
        $dateCurnt1 = explode(' ', $dateCurnt);
        $tim = $dateCurnt1['0'];
        //$min=date('i',strtotime($dateCurnt)); 
        //$hour=date('H',strtotime($dateCurnt));  
        //$day =  gmdate('N',strtotime($dateCurnt)); // Day number in numeric value
        $dt = gmdate('j', strtotime($dateCurnt)); //Date in single numeric value
        $month = gmdate('m', strtotime($dateCurnt));
        $lastDate = gmdate('Y-m-d');
        $frmdt = date("M d, Y", (strtotime($dateCurnt) - (7 * 24 * 60 * 60)));
        $frmdtime = date('Y-m-d H:i:s', strtotime('last monday'));
        $todt = date("M d, Y", strtotime($dateCurnt));

        $userlogin = $companyusercls->query('SELECT COUNT(u.id) as notlogged,(SELECT COUNT(*) FROM company_users WHERE company_id=' . $user_details['0']['Company']['id'] . ' AND is_active=1) AS tot FROM users u , company_users cu WHERE u.id=cu.user_id AND cu.is_active=1 AND cu.company_id=' . $user_details['0']['Company']['id'] . ' AND (u.dt_last_login IS NULL OR u.dt_last_login < "' . $frmdtime . '") ');
        $this->set('userlogin', $userlogin);
        $projectidlists = $projectcls->find("list", array('conditions' => array('Project.company_id' => SES_COMP, 'isactive' => 1), 'fields' => array('Project.id')));
        $project_idcond = '';
        if ($projectidlists) {
            $this->set('project_idlist', implode(',', $projectidlists));
            //$project_idcond = ' FIND_IN_SET(Easycase.project_id ,"' . implode(',', $projectidlists) . '") ';
            $project_idcond = ' Easycase.project_id IN (SELECT id from projects WHERE company_id='.SES_COMP.' AND isactive=1) ';
        } else {
            $this->set('project_idlist', '');
            $project_idcond = " !Easycase.project_id ";
        }
        $taskid_sql = "SELECT id AS task_ids FROM easycases AS Easycase "
                . "WHERE Easycase.isactive=1 AND DATE(Easycase.dt_created )>='" . $prv_date . "' AND " . $project_idcond . "";
        $sql = "SELECT COUNT(Easycase.id) AS cnt,"
                . "(SELECT ROUND((SUM(LogTime.total_hours)/3600),1) as hours "
				. "FROM log_times as LogTime "
				. "LEFT JOIN easycases AS Easycase1 ON LogTime.task_id=Easycase1.id AND LogTime.project_id=Easycase1.project_id "
				. "WHERE Easycase1.isactive=1 AND FIND_IN_SET(LogTime.task_id,GROUP_CONCAT(DISTINCT Easycase.id))) AS hr_spent, "
                . "GROUP_CONCAT(DISTINCT Easycase.project_id) AS project_ids, "
                . "GROUP_CONCAT(DISTINCT Easycase.id) AS easycase_ids, "
                . "Easycase.istype, DATE(Easycase.dt_created) AS created_date "
                . "FROM easycases as Easycase "
                . "WHERE Easycase.id IN ($taskid_sql) "
                . "GROUP BY Easycase.istype,DATE(Easycase.dt_created)";
        $caseAll = $easycasecls->query($sql);
        $this->set('caseAll', $caseAll);

        $project_idlist = '';
        $easycase_idlist = '';
        $total_task_cr_current_week = 0;
        $total_task_upd_current_week = 0;
        $curr_wk_tot_hr_spent = 0;
        foreach ($last7days as $key1 => $val1) {
            $no_of_tasks = 0;
            $no_of_tasks_upd = 0;
            $total_hr_spent = 0;
            foreach ($caseAll AS $k => $value) {
                if (strtotime($value[0]['created_date']) == strtotime($val1)) {
                    if ($value['Easycase']['istype'] == 1) {
                        $no_of_tasks = $value[0]['cnt'];
                    } else {
                        $no_of_tasks_upd = $value[0]['cnt'];
                    }
                    $project_idlist .= $value[0]['project_ids'] . ',';
                    $easycase_idlist .= $value[0]['easycase_ids'] . ',';
                    //$curr_wk_tot_hr_spent += $value[0]['cnt']['hrs'];
                }
            }

            $total_task_cr_current_week +=$no_of_tasks;
            $total_task_upd_current_week +=$no_of_tasks_upd;
            //$curr_wk_tot_hr_spent += $total_hr_spent;
        }
        //Total task Created for the last week 
        $total_task_cr_prv_week = 0;
        $total_task_upd_prv_week = 0;
        $prv_wk_tot_hr_spent = 0;
        $prev_wk_proj_idlist = '';
        $prev_wk_closed_tasks = 0;
        $prev_wk_storage_usage = 0;
        $prev_wk_ecase_idlist = '';
        $prev_wk_ecase_idlists = array();
        $prev_wk_proj_idlists = array();
        $proj_cond = " ";
        $casefiles_cond = " ";
        if ($project_idlist) {
            $project_idlist = trim($project_idlist, ',');
            $project_idlist = explode(',', $project_idlist);
            $project_idlist = array_unique($project_idlist);
            $proj_cond .=" OR  FIND_IN_SET(Project.id,'" . implode(',', $project_idlist) . "')";
        }
        if ($easycase_idlist) {
            $easycase_idlist = trim($easycase_idlist, ',');
            $easycase_idlist = explode(',', $easycase_idlist);
            $easycase_idlist = array_unique($easycase_idlist);
            $casefiles_cond .=" AND  FIND_IN_SET(case_files.easycase_id,'" . implode(',', $easycase_idlist) . "')";
        } else {
            $casefiles_cond .=" AND !case_files.easycase_id ";
        }
        // Project details 
        $sql = "SELECT id,uniq_id,dt_created,name,user_id,project_type,short_name,isactive,"
                . "(SELECT count(easycases.id) as tot from easycases where easycases.project_id=Project.id and easycases.istype='1' and easycases.isactive='1' AND DATE(easycases.dt_created) >='" . $prv_date . "') as totalcase,"
                . "(SELECT count(easycases.id) as tot from easycases where easycases.project_id=Project.id and easycases.istype='1' AND easycases.isactive='1' AND easycases.legend='3'AND DATE(easycases.dt_created) >='" . $prv_date . "') as closedcase,"
                . "(SELECT SUM(LogTime.total_hours) AS hours "
				. "FROM log_times as LogTime "
				. "LEFT JOIN easycases AS Easycase ON LogTime.task_id=Easycase.id AND LogTime.project_id=Easycase.project_id "
				. "WHERE Easycase.isactive=1 AND LogTime.project_id=Project.id "
                . "AND DATE(LogTime.start_datetime) >='" . $prv_date . "' AND DATE(LogTime.start_datetime) <='$lastDate') as totalhours,"
                . "(SELECT SUM(case_files.file_size) AS file_size  FROM case_files   WHERE case_files.project_id=Project.id AND 1 " . $casefiles_cond . ") AS storage_used "
                . "FROM projects AS Project "
                . "WHERE  Project.company_id=" . $user_details['0']['Company']['id'] . " AND Project.short_name!='WCOS' "
                . "AND (Project.dt_created >='" . $prv_date . "' " . $proj_cond . ") "
                . "ORDER BY Project.name ASC";
        $getProj = $projectcls->query($sql);
        $curr_wk_tot_closed_tasks = 0;
        $curr_wk_tot_storage_usage = 0;
        if ($getProj) {
            foreach ($getProj AS $pkey => $pval) {
                $tot_close = $pval[0]['closedcase'] ? $pval[0]['closedcase'] : 0;
                $curr_wk_tot_closed_tasks +=$tot_close;
                $tot_users = $pval[0]['totusers'] ? $pval[0]['totusers'] : 0;
                $tot_hrs = $pval[0]['totalhours'] ? $pval[0]['totalhours'] : '0.0';
                $curr_wk_tot_hr_spent += $tot_hrs;
                if ($pval[0]['storage_used']) {
                    $tot_storage = number_format(($pval[0]['storage_used'] / 1024), 2);
                    $curr_wk_tot_storage_usage +=$tot_storage;
                }
            }
        }
        $this->set('getProj', $getProj);

        $progress_flag = 1;
        if (strtotime($user_details['0']['0']['dt_created']) >= strtotime($prv_date)) {
            $progress_flag = 0;
        }
        $this->set('progress_flag', $progress_flag);
        $this->set('prev_wk_storage_usage', $prev_wk_storage_usage);
        $this->set('prv_wk_tot_hr_spent', $prv_wk_tot_hr_spent);
        $this->set('total_task_cr_prv_week', $total_task_cr_prv_week);
        $this->set('total_task_upd_prv_week', $total_task_upd_prv_week);
        $this->set('prev_wk_closed_tasks', $prev_wk_closed_tasks);

        $this->set('curr_wk_tot_hr_spent', $curr_wk_tot_hr_spent);
        $this->set('total_task_cr_current_week', $total_task_cr_current_week);
        $this->set('total_task_upd_current_week', $total_task_upd_current_week);
        $this->set('curr_wk_tot_storage_usage', $curr_wk_tot_storage_usage);
        $this->set('curr_wk_tot_closed_tasks', $curr_wk_tot_closed_tasks);
    }

    /* BUG PIE CHART */

    function bug_pichart() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $cond = "";
        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            $cond .= " AND DATE(actual_dt_created) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            $cond .= " AND DATE(actual_dt_created) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND project_id = '" . $this->data['pjid'] . "' ";
        }
        if (!empty($this->data['type_id'])) {
            $cond .= " AND type_id = '" . $this->data['type_id'] . "'";
        }
        if (isset($this->data['dtsearch'])) {
            $this->_save_report(3);
        }
        $color_arr = array(1 => '#AE432E', 2 => '#244F7A', 3 => '#77AB13', 4 => '#244F7A', 5 => '#EF6807');
        $legend_arr = array(1 => 'New', 2 => 'Opened', 3 => 'Closed', 4 => 'Start', 5 => 'Resolved');

        $taskid_sql = "SELECT id AS task_ids FROM easycases AS Easycase WHERE istype = 1 AND project_id!=0 " . $cond . "";

        $sql = "SELECT legend, count(Easycase.id) AS cnt "
                . "FROM easycases AS Easycase "
                #. "WHERE istype =1 AND project_id!=0 " . $cond . " "
                . "WHERE Easycase.id IN ($taskid_sql) "
                . "GROUP BY legend "
                . "ORDER BY FIELD(legend,1,2,4,5,3)";

        $easycase = $this->Easycase->query($sql);
        $wip = 0;
		$cnt_array = array();
        if (!empty($easycase)) {
            foreach ($easycase as $k => $v) {
                $cnt_array[] = $v[0]['cnt'];
                if ($v['Easycase']['legend'] == 2 || $v['Easycase']['legend'] == 4) {
                    $wip = $wip + $v[0]['cnt'];
                }
            }
            $tot = !empty($cnt_array) ? array_sum($cnt_array) : 0;
            $i = 0;
            $add = 0;
            foreach ($easycase as $k => $v) {
                if ($v['Easycase']['legend'] == 2 || $v['Easycase']['legend'] == 4) {
                    if ($add == 0) {
                        $piearr[$i]['name'] = 'In Progress';
                        $piearr[$i]['y'] = ($wip / $tot) * 100;
                        $piearr[$i]['nos'] = $wip;
                        $clr[$i] = $color_arr[$v['Easycase']['legend']];
                        $i++;
                        $add++;
                    }
                } else {
                    $piearr[$i]['name'] = $legend_arr[$v['Easycase']['legend']];
                    $piearr[$i]['nos'] = $v[0]['cnt'];
                    $clr[$i] = $color_arr[$v['Easycase']['legend']];
                    $piearr[$i++]['y'] = ($v[0]['cnt'] / $tot) * 100;
                }
            }
            $this->set('piearr', json_encode($piearr));
            $this->set('clrarr', json_encode($clr));
        } else {
            print "<div class='fl'><font color='red' size='2px'>No data for this date range & project.</font></div>";
            exit;
        }
    }

    /* BUG STATISTICS */

    function bug_statistics() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $prjcond = "";
        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            $actcond .= " AND DATE(actual_dt_created) >= '" . $dt . "' ";
            $crtdcond .= " AND DATE(dt_created) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            $actcond .= " AND DATE(actual_dt_created) <= '" . $dt . "' ";
            $crtdcond .= " AND DATE(dt_created) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND project_id = '" . $this->data['pjid'] . "' ";
            $prjcond = " AND project_id = '" . $this->data['pjid'] . "' ";
        }
        if (!empty($this->data['type_id'])) {
            $cond .= " AND type_id = '" . $this->data['type_id'] . "'";
        }
        $actcond = $actcond . $cond;
        $crtdcond = $crtdcond . $cond;

        $cntsql = "SELECT COUNT(*) as cnt FROM easycases WHERE istype =1 " . $actcond;
        $cnt = $this->Easycase->query($cntsql);
        $this->set('cnt', $cnt[0][0]['cnt']);
        $hrsql = "SELECT SUM(hours) as tot_hrs FROM easycases WHERE istype =2 " . $crtdcond;
        $tot_hrs = $this->Easycase->query($hrsql);
        $this->set('tot_hrs', $tot_hrs[0][0]['tot_hrs']);
        $sql = "SELECT actual_dt_created as postdate,legend,dt_created,case_no FROM easycases WHERE istype =1 AND project_id!=0 AND (legend != 1)" . $actcond;
        $post_arr = $this->Easycase->query($sql);
        $resolved_cnt = 0;
        $closed_cnt = 0;
        $resolved = array();
        $closed = array();
        $resolved_diff = array();
        $closed_diff = array();
        if ($cnt[0][0]['cnt'] != 0) {
            if (!empty($post_arr)) {
                foreach ($post_arr as $k => $v) {
                    if ($v['easycases']['legend'] == 5) {
                        $resolved_diff[] = round(abs(strtotime($v['easycases']['dt_created']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                    } elseif ($v['easycases']['legend'] == 3) {
                        $closed_diff[] = round(abs(strtotime($v['easycases']['dt_created']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                        $ressql = "SELECT max(dt_created) as createdt,legend FROM easycases WHERE istype =2 AND legend = 5 AND case_no = '" . $v['easycases']['case_no'] . "'" . $prjcond;
                        $res_arr = $this->Easycase->query($ressql);
                        if (!empty($res_arr[0][0]['createdt'])) {
                            $resolved_diff[] = round(abs(strtotime($res_arr[0][0]['createdt']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                        }
                    } else {
                        $ressql = "SELECT max(dt_created) as createdt,legend FROM easycases WHERE istype =2 AND (legend = 5 OR legend = 3) AND case_no = '" . $v['easycases']['case_no'] . "'" . $prjcond;

                        $res_arr = $this->Easycase->query($ressql);
                        foreach ($res_arr as $k => $v1) {
                            if ($v1['easycases']['legend'] == 3) {
                                $closed_diff[] = round(abs(strtotime($v1[0]['createdt']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                            }
                            if ($v1['easycases']['legend'] == 5) {
                                $resolved_diff[] = round(abs(strtotime($v1[0]['createdt']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                            }
                        }
                    }
                }
                $avg_resolved = (!empty($resolved_diff)) ? array_sum($resolved_diff) / count($resolved_diff) : 0;
                $avg_closed = (!empty($closed_diff)) ? array_sum($closed_diff) / count($closed_diff) : 0;
                $this->set('avg_resolved', $avg_resolved);
                $this->set('avg_closed', $avg_closed);
            }
            $resolved_cnt = count($resolved_diff);
            $closed_cnt = count($closed_diff);
            $this->set('resolved_cnt', $resolved_cnt);
            $this->set('closed_cnt', $closed_cnt);
        }
    }

    /* BUG LINECHART */

    function bug_linechart() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            $cond .= " AND DATE(actual_dt_created) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            $cond .= " AND DATE(actual_dt_created) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND project_id = '" . $this->data['pjid'] . "' ";
        }
        if (!empty($this->data['type_id'])) {
            $cond .= " AND type_id = '" . $this->data['type_id'] . "'";
        }
        $sql = "SELECT case_no,actual_dt_created,dt_created FROM easycases WHERE istype =1 AND project_id!=0 AND legend = 3 " . $cond . " ORDER BY case_no ASC";
        $case_arr = $this->Easycase->query($sql);
        $case = array();
        if (!empty($case_arr)) {
            foreach ($case_arr as $k => $v) {
                $case[] = "#" . $v['easycases']['case_no'];
                $closedays[] = round(abs(strtotime($v['easycases']['actual_dt_created']) - strtotime($v['easycases']['dt_created'])) / 86400) + 1;
            }
            $this->set('case', json_encode($case));
            $this->set('closedays', json_encode($closedays));
        } else {
            print "<font color='red' size='2px'>No data for this date range & project.</font>";
            exit;
        }
    }

    /**
     * @method: Public ajax_statistics()
     * @author GDR<abc@mydomain.com>
     * @return JSON json value
     */
    function ajax_statistics() {
        $easycasecls = ClassRegistry::init('Easycase');
        $project_idlists = $this->data['project_idlists'];
        //$prv_date = date('Y-m-d',  strtotime('-1 week'));
        //$last_week_date = date('Y-m-d',  strtotime('-2 week'));
        $prv_date = date('Y-m-d', strtotime('last monday'));
        $last_week_date = date('Y-m-d', strtotime('last monday', strtotime($prv_date)));
        if ($project_idlists) {
            //$project_idcond = " FIND_IN_SET(Easycase.project_id,'" . $project_idlists . "') ";
            $project_idcond = " Easycase.project_id IN('" . $project_idlists . "') ";
        } else {
            $project_idcond = " !Easycase.project_id ";
        }
        $clt_sql = '';
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = " AND ((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $total_task_cr_prv_week = 0;
        $total_task_upd_prv_week = 0;
        $prv_wk_tot_hr_spent = 0;
        $prev_wk_proj_idlist = '';
        $prev_wk_closed_tasks = 0;
        $prev_wk_storage_usage = 0;
        $prev_wk_ecase_idlist = '';
        $prev_wk_ecase_idlists = array();
        $prev_wk_proj_idlists = array();

        $taskid_sql = "SELECT id AS task_ids FROM easycases AS Easycase "
                . "WHERE Easycase.isactive=1 AND " . $project_idcond . "" . $clt_sql . " "
                . "AND (DATE(Easycase.dt_created) BETWEEN '" . $last_week_date . "' AND '" . $prv_date . "') ";
       /* $sql = "SELECT COUNT(Easycase.id) AS cnt,
		(SELECT SUM(LogTime.total_hours) AS hours 
                    FROM log_times AS LogTime 
                    LEFT JOIN easycases AS Easycase1 ON LogTime.task_id=Easycase1.id AND LogTime.project_id=Easycase1.project_id 
                    WHERE Easycase1.isactive=1 AND FIND_IN_SET(LogTime.task_id,GROUP_CONCAT(DISTINCT Easycase.id))) AS hr_spent,"
                . "GROUP_CONCAT(DISTINCT Easycase.project_id) AS project_ids, "
                . "GROUP_CONCAT(DISTINCT Easycase.id) AS easycase_ids, Easycase.istype, DATE(Easycase.dt_created) AS created_date "
                . "FROM easycases as Easycase "
                . "WHERE Easycase.id IN ($taskid_sql) "
                . "GROUP BY Easycase.istype";*/
								$sql = "SELECT COUNT(Easycase.id) AS cnt,
		(SELECT SUM(LogTime.total_hours) AS hours 
                    FROM log_times AS LogTime 
                    LEFT JOIN easycases AS Easycase1 ON LogTime.task_id=Easycase1.id AND LogTime.project_id=Easycase1.project_id 
                    WHERE Easycase1.isactive=1 AND LogTime.task_id IN(GROUP_CONCAT(DISTINCT Easycase.id))) AS hr_spent,"
                . "GROUP_CONCAT(DISTINCT Easycase.project_id) AS project_ids, "
                . "GROUP_CONCAT(DISTINCT Easycase.id) AS easycase_ids, Easycase.istype, DATE(Easycase.dt_created) AS created_date "
                . "FROM easycases as Easycase "
                . "WHERE Easycase.id IN ($taskid_sql) "
                . "GROUP BY Easycase.istype";
        #echo $sql;exit;
        $lastweektask = $easycasecls->query($sql);
        #pr($lastweektask);
        if ($lastweektask) {
            $prv_wk_tot_hr_spent = @$lastweektask[0][0]['hr_spent'] + @$lastweektask[1][0]['hr_spent'];
            if (@$lastweektask[0]['Easycase']['istype'] == 1) {
                $total_task_cr_prv_week = @$lastweektask[0][0]['cnt'];
            } elseif (@$lastweektask[0]['Easycase']['istype'] == 2) {
                $total_task_upd_prv_week = @$lastweektask[0][0]['cnt'];
                ;
            }
            if (@$lastweektask[1]['Easycase']['istype'] == 1) {
                $total_task_cr_prv_week = @$lastweektask[1][0]['cnt'];
            } elseif (@$lastweektask[1]['Easycase']['istype'] == 2) {
                $total_task_upd_prv_week = @$lastweektask[1][0]['cnt'];
            }
            $prev_wk_proj_idlist = @$lastweektask[0][0]['project_ids'] . "," . @$lastweektask[1][0]['project_ids'];
            $prev_wk_ecase_idlist = @$lastweektask[0][0]['easycase_ids'] . "," . @$lastweektask[1][0]['easycase_ids'];
            if ($prev_wk_proj_idlist) {
                $prev_wk_proj_idlist = trim($prev_wk_proj_idlist, ',');
                if (strstr($prev_wk_proj_idlist, ',')) {
                    $prev_wk_proj_idlists = array_unique(explode(',', $prev_wk_proj_idlist));
                } else {
                    $prev_wk_proj_idlists[] = $prev_wk_proj_idlist;
                }
                if ($prev_wk_proj_idlist) {
                    //$prev_wk_proj_idlist = explode(',',$prev_wk_proj_idlist);
                    $last_week_closed_cases = $easycasecls->query("SELECT count(easycases.id) as tot from easycases "
                            . "WHERE FIND_IN_SET(easycases.project_id,'" . implode(',', $prev_wk_proj_idlists) . "') "
                            . "AND easycases.istype='1' AND easycases.isactive='1' AND easycases.legend='3'"
                            . " " . $clt_sql . " "
                            . "AND (DATE(easycases.dt_created) BETWEEN '" . $last_week_date . "' AND '" . $prv_date . "')");
                    #pr($last_week_closed_cases);
                    if ($last_week_closed_cases) {
                        $prev_wk_closed_tasks = $last_week_closed_cases[0][0]['tot'];
                    }
                }
            }

            // Calculating Prevous week storage usage	
            if ($prev_wk_ecase_idlist) {
                $prev_wk_ecase_idlist = trim($prev_wk_ecase_idlist, ',');
                if (strstr($prev_wk_ecase_idlist, ',')) {
                    $prev_wk_ecase_idlist = explode(',', $prev_wk_ecase_idlist);
                    $prev_wk_ecase_idlists = array_unique($prev_wk_ecase_idlist);
                } else {
                    $prev_wk_ecase_idlists[] = $prev_wk_ecase_idlist;
                }
                if ($prev_wk_ecase_idlist) {
                    $casefilecls = ClassRegistry::init('CaseFile');
                    $last_week_used_storage = $casefilecls->query("SELECT SUM(file_size) AS file_size  FROM case_files   WHERE FIND_IN_SET(easycase_id,'" . implode(',', $prev_wk_ecase_idlists) . "')");
                    if ($last_week_used_storage) {
                        $prev_wk_storage_usage = round(($last_week_used_storage[0][0]['file_size'] / 1024), 2);
                    }
                }
            }
        }
        $json_arr['prev_wk_closed_tasks'] = $prev_wk_closed_tasks;
        $json_arr['prev_wk_storage_usage'] = $prev_wk_storage_usage;
        $json_arr['prv_wk_tot_hr_spent'] = $prv_wk_tot_hr_spent;
        $json_arr['total_task_cr_prv_week'] = $total_task_cr_prv_week;
        $json_arr['total_task_upd_prv_week'] = $total_task_upd_prv_week;
        echo json_encode($json_arr);
        exit;
    }

    function bug_glide() {
        $this->layout = "ajax";
        $before = date('Y-m-d', strtotime($this->data['sdate']));
        $to = date('Y-m-d', strtotime($this->data['edate']));
        $days = (strtotime($to) - strtotime($before)) / (60 * 60 * 24);
        $proj_id = $this->data['pjid'];

        $x = floor($days);
        if ($x < 7) {
            $interval = 1;
        } elseif ($x > 80) {
            $interval = ceil($x / 10);
        } else {
            $interval = 7;
        }

        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            $cond .= " AND DATE(dt_created) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            $cond .= " AND DATE(dt_created) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND project_id = '" . $this->data['pjid'] . "' ";
        }
        if (!empty($this->data['type_id'])) {
            $cond .= " AND type_id = '" . $this->data['type_id'] . "'";
        }




        $this->loadModel('Easycase');
        $actualdtarr = $this->Easycase->query("SELECT dt_created FROM easycases WHERE istype='1' AND  isactive='1' AND project_id!=0 " . $cond . " ORDER BY dt_created ASC");

        $this->set('tinterval', $interval);
        $dt_arr = array();
        $dts_arr = array();

        foreach ($actualdtarr as $k => $v) {
            $dt = date('Y-m-d', strtotime(date("Y-m-d", strtotime($v['easycases']['dt_created']))));
            $dts = date('M d, Y', strtotime(date("Y-m-d H:i:s", strtotime($v['easycases']['dt_created']))));
            $times = explode(" ", GMT_DATETIME);
            array_push($dt_arr, $dt);
            array_push($dts_arr, $dts);
        }
        /* for($i=0;$i<=$x;$i++){
          $m=" +".$i."day";
          $dt=date('Y-m-d',strtotime(date("Y-m-d", strtotime($before)) .$m));
          $dts=date('M d, Y',strtotime(date("Y-m-d H:i:s", strtotime($before)) .$m));
          $times=explode(" ",GMT_DATETIME);
          array_push($dt_arr,$dt);
          array_push($dts_arr,$dts);
          } */

        $open_arr = array();
        $res_arr = array();
        $s = "";
        $r = "";
        foreach ($dt_arr as $key => $date) {

            $resolved_bug = $this->Easycase->query("SELECT count(type_id) AS tid ,DATE(Easycase.actual_dt_created) AS cdate,COUNT(Easycase.id) as count FROM easycases as Easycase WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND Easycase.legend='5' AND Easycase.type_id='1' AND Easycase.project_id!=0 AND Easycase.project_id='" . $proj_id . "' AND (DATE(Easycase.dt_created) <= '" . $date . "')");
            $resolvedCount = $resolved_bug['0']['0']['count'];


            $opened_bug = $this->Easycase->query("SELECT ROUND(type_id) AS tid ,DATE(Easycase.actual_dt_created) AS cdate,COUNT(Easycase.id) as count FROM easycases as Easycase WHERE Easycase.istype='1' AND  Easycase.isactive='1' AND Easycase.legend !='5' AND Easycase.legend !='3' AND Easycase.type_id='1' AND Easycase.project_id!=0 AND Easycase.project_id='" . $proj_id . "' AND (DATE(Easycase.dt_created) <= '" . $date . "')");
            $openedCount = $opened_bug['0']['0']['count'];



            array_push($res_arr, $resolvedCount + $openedCount);
            array_push($open_arr, $openedCount);
        }
		$yarr = array();
        if (!empty($res_arr) || !empty($open_arr)) {
            $resolved = implode(",", $res_arr);
            $opened = implode(",", $open_arr);

            $this->set('dt_arr', json_encode($dts_arr));

            $carr = array(array('name' => 'Resolved Bug', 'data' => '[' . $resolved . ']'), array('name' => 'Opened Bug', 'data' => '[' . $opened . ']'));

            for ($i = 5; $i <= 100; $i++) {
                $yarr[] = (int) $i;
            }
            $this->set('yarr', json_encode($yarr));
            $this->set('carr', json_encode($carr));
        } else {
            print "<font color='red' size='2px'>No data for this date range & project.</font>";
            exit;
        }
    }

    function _save_report($rpt_type) {
        $this->loadModel('SaveReport');
        $rptdata = $this->SaveReport->find('all', array('conditions' => array('user_id' => SES_ID)));
        if (!empty($rptdata)) {
            $saverpt['SaveReport']['id'] = $rptdata[0]['SaveReport']['id'];
        }
        $fdt = date('Y-m-d', strtotime($this->data['sdate']));
        $tdt = date('Y-m-d', strtotime($this->data['edate']));
        $saverpt['SaveReport']['frm_dt'] = $fdt;
        $saverpt['SaveReport']['to_dt'] = $tdt;
        $saverpt['SaveReport']['user_id'] = SES_ID;
        //$saverpt['SaveReport']['rpt_type'] = $rpt_type;
        $saverpt['SaveReport']['created'] = gmdate('Y-m-d H:i:s');
        $saverpt['SaveReport']['ip'] = $_SERVER['REMOTE_ADDR'];
        $this->SaveReport->save($saverpt);
    }

    function hours_report() {
        if (!$this->Format->isAllowed('View Hour Spent Report')) {
            $this->Session->write('ERROR', __('Oops! You don\'t have access to this report.', true));
            $this->redirect(HTTP_ROOT.'dashboard');
        }
        $this->loadModel('ProjectUser');
        $this->loadModel('SaveReport');

        if (isset($this->params['pass']['0']) && !empty($this->params['pass']['0'])) {
            $this->loadModel('Project');

            if ($this->params['pass']['0'] == 'ajax') {
                $this->layout = 'ajax';
            }
            $prj = $this->params['pass']['0'] != 'ajax' ? $this->params['pass']['0'] : $this->params['pass']['1'];

            $projarr = $this->Project->query("SELECT id,name FROM projects WHERE uniq_id='" . $prj . "' AND company_id='" . SES_COMP . "'");
            $proj_id = $projarr['0']['projects']['id'];
            $this->set('pjid', $proj_id);
            $this->set('pjname', $projarr['0']['projects']['name']);
            $type_id = 0;
            $this->set('proj_uniq', $prj);

            $this->Project->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE user_id=" . SES_ID . " and project_id='" . $proj_id . "' and company_id='" . SES_COMP . "'");
        }


        $proj_all_cond = array(
            'recursive' => '1',
            'conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP, 'ProjectUser.project_id !=' => 0, 'Project.isactive' => 1),
            'fields' => array('Project.id', 'Project.uniq_id'),
            'order' => array('ProjectUser.dt_visited DESC')
        );
        $this->ProjectUser->bindModel(array('belongsTo' => array('Project')));
        $projAll = $this->ProjectUser->find('list', $proj_all_cond);
        $this->set('projAll', $projAll);

        if (!isset($this->params['pass']['0'])) {
            foreach ($projAll as $pid => $puid) {
                $this->set('pjid', $pid);
                $this->set('proj_uniq', $puid);
                break;
            }
        }
        if (isset($this->params['pass']['0']) && !empty($this->params['pass']['0'])) {
            if (!in_array($prj, $projAll)) {
               // $this->Session->write("ERROR", __("Unauthorized URL",true));
                $this->redirect(HTTP_ROOT . "task-report");
            }
        }


        $rptdata = $this->SaveReport->find('all', array('conditions' => array('user_id' => SES_ID)));
        if (!empty($rptdata)) {
            $this->set('frm', date('M d, Y', strtotime($rptdata[0]['SaveReport']['frm_dt'])));
            $this->set('to', date("M d, Y", strtotime($rptdata[0]['SaveReport']['to_dt'])));
            $before = $this->Format->chgdate(date('M d, Y', strtotime($rptdata[0]['SaveReport']['frm_dt'])));
            $to = $this->Format->chgdate(date('M d, Y', strtotime($rptdata[0]['SaveReport']['to_dt'])));
            $days = (strtotime($to) - strtotime($before)) / (60 * 60 * 24);
        } else {
            $timezone_offset = TZ_GMT;
            $cur_time = date('Y-m-d H:i:s', (strtotime(GMT_DATETIME) + ($timezone_offset * 60 * 60)));
            $before = date('Y-m-d H:i:s', strtotime($cur_time . "-7 day"));
            $days = (strtotime(date("Y-m-d H:i:s")) - strtotime($before)) / (60 * 60 * 24) + 1;
            $this->set('frm', date('M d, Y', strtotime($cur_time . "-7 day")));
            $this->set('to', date("M d, Y"));
        }
		$this->set('loggedInUser', $this->Auth->user());
    }

    function hours_piechart() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('Type');
        $cond = "";
        $log_condition = "";
        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            #$cond .= " AND DATE(actual_dt_created) >= '" . $dt . "' ";
            $log_condition .= " AND DATE(start_datetime) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            #$cond .= " AND DATE(actual_dt_created) <= '" . $dt . "' ";
            $log_condition .= " AND DATE(start_datetime) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            #$cond .= " AND project_id = '" . $this->data['pjid'] . "'";
            $log_condition .= " AND LogTime.project_id = '" . $this->data['pjid'] . "'";
        }
        if (!empty($this->data['type_id'])) {
            $cond .= " AND type_id = '" . $this->data['type_id'] . "'";
        }

        $type_arr = $this->Type->find('list', array('fields' => array('id', 'name')));

        if (isset($this->data['dtsearch'])) {
            $this->_save_report(2);
        }

        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR client_status != " . $this->Auth->user('is_client') . ")";
        }
        $log_sql = "SELECT log_id AS ids FROM log_times AS LogTime WHERE 1=1 " . $log_condition . "";
		
		if(SES_TYPE == 3 || $this->Auth->user('is_client') == 1){
			$pieUserCond = "AND LogTime.user_id=".SES_ID;
		}elseif(SES_TYPE < 3){
			$pieUserCond = "";
		}
        $sql = "SELECT Easycase.type_id, Type.name, SUM(LogTime.total_hours) AS tot_hours
                FROM log_times AS LogTime
                LEFT JOIN easycases AS Easycase ON LogTime.task_id = Easycase.id AND LogTime.project_id = Easycase.project_id
                LEFT JOIN types AS Type ON Type.id = Easycase.type_id
				WHERE Easycase.isactive=1 ".$pieUserCond."
                AND LogTime.log_id IN ($log_sql)
                AND $clt_sql $cond
                GROUP BY Easycase.type_id";
        #$log_condition 
        #echo $sql;exit;
        $easycase = $this->Easycase->query($sql);
        #pr($easycase);exit;
		$cnt_array = array();
        if (!empty($easycase)) {
            foreach ($easycase as $k => $v) {
                $cnt_array[] = floatval($v[0]['tot_hours']);
            }
            $tot = !empty($cnt_array) ? array_sum($cnt_array) : 0;
            $i = 0;
            foreach ($easycase as $k => $v) {
                #$piearr[$i]['name'] = $type_arr[$v['Easycase']['type_id']];
                $piearr[$i]['name'] = $v['Type']['name'];
                $piearr[$i]['hours'] = $this->Format->format_time_hr_min($v[0]['tot_hours']);
                $piearr[$i++]['y'] = floatval($v[0]['tot_hours']) > 0 ? (floatval($v[0]['tot_hours']) / $tot) * 100 : 0;
            }

            $this->set('piearr', json_encode($piearr));
        } else {
            //print "<div class='fl'><font color='red' size='2px'>No data for this date range & project.</font></div>";exit;
            print '<img src="'.HTTP_ROOT.'img/sample/analytics/hours_spent_task_type.jpg" style="width:98%;">';
            exit;
        }
    }

    function hours_linechart() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('LogTime');

        $before = date('Y-m-d', strtotime($this->data['sdate']));
        $to = date('Y-m-d', strtotime($this->data['edate']));
        $days = (strtotime($to) - strtotime($before)) / (60 * 60 * 24);
        $proj_id = $this->data['pjid'];
        $x = floor($days);
        if ($x < 7) {
            $interval = 1;
        } elseif ($x > 80) {
            $interval = ceil($x / 10);
        } else {
            $interval = 7;
        }
        $this->set('tinterval', $interval);
        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dt_arr = array();
        $dts_arr = array();

        for ($i = 0; $i <= $x; $i++) {
            $m = " +" . $i . "day";
            $dt = date('Y-m-d', strtotime(date("Y-m-d", strtotime($before)) . $m));
            $dts = date('M d, Y', strtotime(date("Y-m-d H:i:s", strtotime($before)) . $m));
            $times = explode(" ", GMT_DATETIME);
            array_push($dt_arr, $dt);
            array_push($dts_arr, $dts);
        }
        $this->set('dt_arr', json_encode($dts_arr));


        $cond = "";
        if (!empty($this->data['sdate'])) {
            $dtt = date('Y-m-d', strtotime($this->data['sdate']));
            $cond .= " AND DATE(start_datetime) >= '" . $dt_arr[0] . "' ";
            $case_cond .= " AND DATE(actual_dt_created) >= '" . $dt_arr[0] . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dtt = date('Y-m-d', strtotime($this->data['edate']));
            $cond .= " AND DATE(start_datetime) <= '" . $dt_arr[$x] . "' ";
            $case_cond .= " AND DATE(actual_dt_created) <= '" . $dt_arr[$x] . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND LogTime.project_id = '" . $proj_id . "' ";
            $case_cond .= " AND Easycase.project_id = '" . $proj_id . "' ";
        }
        #if(!empty($this->data['type_id'])){$cond .= " AND type_id = '".$this->data['type_id']."'";}

        if (isset($this->data['dtsearch'])) {
            $this->_save_report(2);
        }

        $clt_sql = 1;
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            $case_sql = "SELECT Easycase.id FROM easycases as Easycase "
                    . "WHERE Easycase.project_id!=0 AND " . $clt_sql . " AND Easycase.reply_type=0 " . $case_cond . "";
            #$easycase = $this->Easycase->query($sql);
            $clt_sql = "LogTime.task_id IN ($case_sql)";
        }

        #$sql = "SELECT Users.name as devname ,Easycases.case_no,Easycases.project_id,Easycases.user_id,Easycases.hours,Easycases.actual_dt_created AS cdate FROM easycases as Easycases,users as Users WHERE Users.id = Easycases.user_id AND Easycases.project_id!=0 AND " . $clt_sql . " AND Easycases.reply_type=0 " . $cond . "";
        #$easycase = $this->Easycase->query($sql);
		if(SES_TYPE == 3 || $this->Auth->user('is_client') == 1){
			$extraUserCond = "AND LogTime.user_id=".SES_ID;
		}elseif(SES_TYPE < 3){
			$extraUserCond = "";
		}
		
        $sql = "SELECT Users.name as devname,LogTime.project_id,LogTime.user_id, LogTime.start_datetime AS cdate,"
                . "ROUND(LogTime.total_hours/3600,1) AS hours , LogTime.total_hours AS t_hours "
                . "FROM log_times as LogTime "
                . "LEFT JOIN users as Users ON Users.id = LogTime.user_id "
                . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
					. "WHERE Users.id>0 AND LogTime.project_id!=0 ".$extraUserCond." AND Easycase.isactive=1 AND " . $clt_sql . " " . $cond . "";		

        $easycase = $this->LogTime->query($sql);
        #pr($easycase);exit;
		$name = array();
        if (!empty($easycase)) {
            foreach ($easycase as $k => $v) {
                $name[] = $v['Users']['devname'];
                $cdts = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['LogTime']['cdate'], "date");
                $reportArr[$cdts]['name'] = $v['Users']['devname'];
                //$reportArr[$cdts][$v['Users']['devname']]['hour'][] = $v[0]['hours'];
                $reportArr[$cdts][$v['Users']['devname']]['hour'][] = $v['LogTime']['t_hours'];
            }

            foreach ($dt_arr as $key => $date) {
                foreach ($name as $nm) {
                    if (array_key_exists($date, $reportArr)) {
                        if (!empty($reportArr[$date][$nm]['hour'])) {
                            $hrspent = array_sum($reportArr[$date][$nm]['hour']);
                        } else {
                            $hrspent = 0;
                        }
                    } else {
                        $hrspent = 0;
                    }
                    $hourspent[$date][$nm] = (float) $hrspent;
                }
            }
            $uname = '';
            foreach ($hourspent as $key => $value) {
                foreach ($value as $nm => $hr) {
                    $userArr[$nm][] = $this->Format->format_time_hr_min_point($hr);
                    //$userArr[$nm][] = $hr;
                }
            }
            foreach ($userArr as $knm => $vhr) {
                $carr[] = array('name' => $knm, 'data' => $vhr);
            }

            $this->set('carr', json_encode($carr));
        } else {
            //print "<div class='fl'><font color='red' size='2px'>No data for this date range & project.</font></div>";exit;
            print '<img src="'.HTTP_ROOT.'img/sample/analytics/hours_spent_by_all_line.jpg" style="width:98%;">';
            exit;
        }
    }

    function hours_burndown() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('Project');
        $this->loadModel('LogTime');
        $this->Project->recursive = -1;
        if (!empty($this->data['pjid'])) {
            $project = $this->Project->find('first', array('conditions' => array('Project.id' => $this->data['pjid'])));
        }
        $proj_id = $project['Project']['id'];
        $easycase_date = $this->Easycase->query("SELECT MIN(Easycase.dt_created) AS start_date, "
                . "MAX(Easycase.dt_created) AS end_date "
                . "FROM easycases AS Easycase "
                . "WHERE Easycase.project_id='" . $proj_id . "' AND Easycase.reply_type=0");
        $hr_arr = array();

        if (!empty($project['Project']['estimated_hours'])) {
            /* if project estimate hour is more than 1,000, interval line size is 100 else 100 */
            if ($project['Project']['estimated_hours'] >= 1000) {
                for ($i = 0; $i <= floor(($project['Project']['estimated_hours']) / 100); $i++) {
                    $hr_arr[$i] = $i * 100;
                }
            } else {
                for ($j = 0; $j <= floor(($project['Project']['estimated_hours']) / 10); $j++) {
                    $hr_arr[$j] = $j * 10;
                }
            }
            $this->set('hr_arr', json_encode($hr_arr));

            $no_record = false;
            /* if project start date is set else min start date among all tasks of this project */
            if (!$project['Project']['start_date']) {
                $before = date('Y-m-d', strtotime($easycase_date[0][0]['start_date']));
            } elseif (!empty($project['Project']['start_date'])) {
                $before = date('Y-m-d', strtotime($project['Project']['start_date']));
            } else {
                $no_record = true;
            }
            /* if project end date is set else max end date among all tasks of this project */
            if (!$project['Project']['end_date']) {
                $to = date('Y-m-d', strtotime($easycase_date[0][0]['end_date']));
            } elseif (!empty($project['Project']['end_date'])) {
                $to = date('Y-m-d', strtotime($project['Project']['end_date']));
            } else {
                $no_record = true;
            }
            if ($before == $to) {
                $no_record = true;
            }
            if ($no_record == true) {
                print "<img src='".HTTP_ROOT."img/sample/analytics/burndown-chart.jpg' style='width: 98%;'/>";
                exit;
            }

            $days = (strtotime($to) - strtotime($before)) / (60 * 60 * 24);
            $x = floor($days);
            #print($x);exit;
            $this->set('estimated_hours', $project['Project']['estimated_hours']);
            $this->set('maxd', json_encode($to));
            if ($x <= 7) {
                $interval = 1;
            } elseif ($x > 80) {
                $interval = ceil($x / 10);
            } else {
                $interval = 7;
            }
            #print($interval);exit;
            $this->set('tinterval', $interval);
            $view = new View($this);
            $tz = $view->loadHelper('Tmzone');
            $dt_arr = array();
            $dts_arr = array();
						$wend_cnt = 0;
            for ($i = 0; $i <= $x; $i++) {
                $m = " +" . $i . "day";
                $dt = date('Y-m-d', strtotime(date("Y-m-d", strtotime($before)) . $m));
                $dts = date('M d, Y', strtotime(date("Y-m-d H:i:s", strtotime($before)) . $m));
                $times = explode(" ", GMT_DATETIME);
                array_push($dt_arr, $dt);
                array_push($dts_arr, $dts);
								$date_t = getdate(strtotime($dt));
                if ($date_t['weekday'] == "Saturday" || $date_t['weekday'] == "Sunday"){
									$wend_cnt++;
								}
            }
            #pr($dts_arr);exit;
            $this->set('dt_arr', json_encode($dts_arr));
            $ideal_arr = array();
            $prev_val = 0;
						$ded_cnt = count($dts_arr)-$wend_cnt;
						$deduct = round($project['Project']['estimated_hours']/$ded_cnt,1);
            /* 8 hours slot size */
           /* for ($k = 0; $prev_val <= $project['Project']['estimated_hours'] - 8; $k++) {
                $date = getdate(strtotime($dt_arr[$k]));
                if ($date['weekday'] == "Saturday" || $date['weekday'] == "Sunday") {
                    $ideal_arr[$k] = $prev_val;
                } else {
                    if ($k == 0) {
                        $ideal_arr[$k] = 0;
                    } else {
                        $ideal_arr[$k] = $prev_val + 8;
                    }
                }
                $prev_val = $ideal_arr[$k];
            }*/
						//$prev_val = $deduct;
						for ($k = 0; $k<count($dts_arr); $k++) {
							$date = getdate(strtotime($dt_arr[$k]));
							if ($date['weekday'] == "Saturday" || $date['weekday'] == "Sunday"){
								$ideal_arr[$k] = $prev_val;
							} else {
								if ($k == 0) {
									$ideal_arr[$k] = 0;
								} else {
									$ideal_arr[$k] = $prev_val + $deduct;
								}
            }
							$prev_val = $ideal_arr[$k];
            }
            #pr($ideal_arr);exit;
            $ideal_arr = array_reverse($ideal_arr);
            $this->set('ideal_arr', json_encode($ideal_arr));

            $clt_sql = 1;
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }

            //$sql = "SELECT Users.name as devname ,Easycases.case_no,Easycases.project_id,Easycases.user_id,Easycases.hours,Easycases.dt_created,Easycases.actual_dt_created AS cdate 
            //FROM easycases as Easycases,users as Users 
            //WHERE Users.id = Easycases.user_id AND Easycases.project_id!=0 AND ".$clt_sql." AND Easycases.reply_type=0 AND Easycases.dt_created <= CURDATE()".$cond."";
            $actual_arr = array();
            foreach ($dt_arr as $k => $date) {
                $sql = "SELECT ROUND((SUM(LogTime.total_hours)/3600),1) AS thours,LogTime.start_datetime AS dt_created "
                        . "FROM log_times as LogTime "
                        . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                        . "WHERE LogTime.project_id='" . $proj_id . "' AND Easycase.isactive=1 "
						. "AND DATE(LogTime.start_datetime)='" . $date . "'"; #. "' AND " . $clt_sql;
                #echo $sql;exit;
                $easycase = $this->LogTime->query($sql);
                #pr($easycase);
                foreach ($easycase as $k => $val) {
                    if ($val[0]['thours']) {
                        $hours = $prev_hours + $val[0]['thours'];
                    } else {
                        $hours = $prev_hours;
                    }
                    $prev_hours = $hours;
                    $actual_hours = $project['Project']['estimated_hours'] - $hours;
                    array_push($actual_arr, $actual_hours);
                }
            }
            //echo "<pre>"; print_r($actual_arr);exit;
            //str_replace('"',"'",json_encode($list));
            $this->set('actual_arr', str_replace('"', "", json_encode($actual_arr)));
        } else {
            print "<img src='".HTTP_ROOT."img/sample/analytics/burndown-chart.jpg' style='width: 98%;'/>";
            exit;
        }
    }

    function hours_gridview() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('LogTime');
        $this->loadModel('User');
        $cond = "";
        $log_condition = '';
        $user_id = array();
        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            $cond .= " AND DATE(Easycase.actual_dt_created) >= '" . $dt . "' ";
            $log_condition .= " AND DATE(start_datetime) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            $cond .= " AND DATE(Easycase.actual_dt_created) <= '" . $dt . "' ";
            $log_condition .= " AND DATE(start_datetime) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND Easycase.project_id = '" . $this->data['pjid'] . "' ";
            $log_condition .= " AND LogTime.project_id = '" . $this->data['pjid'] . "' ";
        }

        $clt_sql = '';
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = " AND ((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $taskid_sql = "SELECT id AS task_ids FROM easycases AS Easycase WHERE 1 " . $clt_sql . " " . $cond . "";
        #$caseno_sql = "SELECT case_no AS case_no FROM easycases AS Easycase WHERE  1 " . $clt_sql . " " . $cond . "";

        /* fetching records for timelog of current project */
        $log_sql = "SELECT LogTime.user_id, SUM(LogTime.total_hours) AS hours "
                . "FROM log_times AS LogTime "
                . "LEFT JOIN easycases AS Easycase ON LogTime.task_id=Easycase.id AND LogTime.project_id=Easycase.project_id "
                . "WHERE Easycase.isactive=1 " . $log_condition . ""
                . "GROUP BY user_id";
        #echo $log_sql;exit;
        $logtime = $this->LogTime->query($log_sql);
        $loglist = array();
        if (is_array($logtime) && count($logtime) > 0) {
            foreach ($logtime as $key => $val) {
                $loglist[$val['LogTime']['user_id']] = $val[0]['hours'];
                $user_id[] = $val['LogTime']['user_id'];
            }
        }

        /* fetching records for replies count */
        $sql = "SELECT Easycase.user_id, COUNT(Easycase.id) AS replies_no "
                . "FROM easycases AS Easycase "
                . "WHERE Easycase.istype != 1 AND Easycase.reply_type=0 AND Easycase.id IN ($taskid_sql) "
                . "GROUP BY Easycase.user_id ";
        $easycase = $this->Easycase->query($sql);
        #pr($easycase);exit;
        $replylist = array();
        if (is_array($easycase) && count($easycase) > 0) {
            foreach ($easycase as $key => $val) {
                $replylist[$val['Easycase']['user_id']] = $val[0]['replies_no'];
                $user_id[] = $val['Easycase']['user_id'];
            }
        }

        /* resolved count */
        $ressql = "SELECT COUNT(Easycase.id) AS resolved_no,Easycase.user_id "
                . "FROM easycases AS Easycase "
                . "WHERE Easycase.istype != 1 AND (Easycase.legend = 5 OR Easycase.legend = 3)  AND id IN ($taskid_sql) "
                . "GROUP BY Easycase.user_id";
        $rescnt = $this->Easycase->query($ressql);
        $resarr = array();
        if (is_array($rescnt) && count($rescnt) > 0) {
            foreach ($rescnt as $k => $v) {
                $resarr[$v['Easycase']['user_id']] = $v[0]['resolved_no'];
                $user_id[] = $v['Easycase']['user_id'];
            }
        }
        #pr($replylist);pr($resarr);pr($loglist);
        $user_id = array_unique($user_id);

        $users = array();
        if (is_array($user_id) && count($user_id) > 0) {
            $users = $this->User->find('all', array('conditions' => array("id IN (" . implode(',', $user_id) . ")"), 'fields' => 'id,name'));
        }

        if (!empty($easycase) || !empty($replylist) || !empty($resarr) || !empty($loglist)) {
            $this->set('easycases', $easycase);
            $this->set('resarr', $resarr);
            $this->set('replylist', $replylist);
            $this->set('loglist', $loglist);
            $this->set('users', $users);
			$this->set('loggedInUser', $this->Auth->user());
        } else {
            print '<img src="'.HTTP_ROOT.'img/sample/analytics/hours_spent_by_all_grid.jpg" style="width:98%;">';
            exit;
        }
    }

    /* Task Pie Chart */

    function tasks_pichart() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $cond = "";
        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            $cond .= " AND DATE(actual_dt_created) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            $cond .= " AND DATE(actual_dt_created) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND project_id = '" . $this->data['pjid'] . "' ";
        }
        if (!empty($this->data['type_id'])) {
            $cond .= " AND type_id = '" . $this->data['type_id'] . "'";
        }
        $this->_save_report(1);

        $clt_sql = '';
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = " AND ((client_status = " . $this->Auth->user('is_client') . " AND user_id = " . $this->Auth->user('id') . ") OR client_status != " . $this->Auth->user('is_client') . ")";
        }

        $taskid_sql = "SELECT id AS task_ids FROM easycases AS Easycase WHERE istype = 1 AND isactive = 1" . $clt_sql . " " . $cond . "";

        $sql = "SELECT type_id, count(Easycase.id) as cnt "
                . "FROM easycases AS Easycase "
                #. "WHERE istype =1 AND ".$clt_sql." AND project_id!=0 ".$cond." "
                . "WHERE Easycase.id IN ($taskid_sql) "
                . "GROUP BY type_id";
        #echo $sql;exit;
        $easycase = $this->Easycase->query($sql);
        #pr($easycase);exit;
		$cnt_array = array();
        if (!empty($easycase)) {
            $this->loadModel('Type');
            $type_arr = $this->Type->find('list', array('fields' => array('id', 'name')));
            foreach ($easycase as $k => $v) {
                $cnt_array[] = $v[0]['cnt'];
            }
            $tot = !empty($cnt_array) ? array_sum($cnt_array) : 0;
            $i = 0;
            $piearr = array();
            foreach ($easycase as $k => $v) {
                $piearr[$i]['name'] = $type_arr[$v['Easycase']['type_id']];
                $piearr[$i]['tasks'] = $v[0]['cnt'];
                $piearr[$i++]['y'] = ($v[0]['cnt'] / $tot) * 100;
            }

            $this->set('piearr', json_encode($piearr));
        } else {
            print '<img src="'.HTTP_ROOT.'img/sample/analytics/task_type_pie_chart.jpg" style="width:98%;">';
            exit;
        }
    }

    function tasks_statistics() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('LogTime');

        $prjcond = "";
        $logtime_condition = "";
        if (!empty($this->data['sdate'])) {
            $dt = date('Y-m-d', strtotime($this->data['sdate']));
            $actcond .= " AND DATE(actual_dt_created) >= '" . $dt . "' ";
            $crtdcond .= " AND DATE(dt_created) >= '" . $dt . "' ";
            #$logtime_condition .= " AND DATE(start_datetime) >= '" . $dt . "' ";
        }
        if (!empty($this->data['edate'])) {
            $dt = date('Y-m-d', strtotime($this->data['edate']));
            $actcond .= " AND DATE(actual_dt_created) <= '" . $dt . "' ";
            $crtdcond .= " AND DATE(dt_created) <= '" . $dt . "' ";
            #$logtime_condition .= " AND DATE(start_datetime) <= '" . $dt . "' ";
        }
        if (!empty($this->data['pjid'])) {
            $cond .= " AND project_id = '" . $this->data['pjid'] . "' ";
            $prjcond = " AND project_id = '" . $this->data['pjid'] . "' ";
            $logtime_condition .= " AND Easycase.project_id = '" . $this->data['pjid'] . "' ";
        }
        if (!empty($this->data['type_id'])) {
            $cond .= " AND type_id = '" . $this->data['type_id'] . "'";
        }
        $actcond = $actcond . $cond;
        $crtdcond = $crtdcond . $cond;

        $clt_sql = '';
        $case_condition_sql = '';
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = " AND ((client_status = " . $this->Auth->user('is_client') . " AND user_id = " . $this->Auth->user('id') . ") OR client_status != " . $this->Auth->user('is_client') . ")";
            $case_sql = "SELECT Easycase.id FROM easycases as Easycase WHERE istype =1 " . $clt_sql . " " . $crtdcond . "";
            $case_condition_sql = " AND LogTime.task_id IN ($case_sql) ";
        }

        $cntsql = "SELECT COUNT(*) as cnt FROM easycases WHERE istype =1 AND isactive =1 " . $clt_sql . " " . $actcond;
        $cnt = $this->Easycase->query($cntsql);
        $this->set('cnt', $cnt[0][0]['cnt']);

		if(SES_TYPE == 3 || $this->Auth->user('is_client') == 1){
			$TmLogUserCond = "AND LogTime.user_id=".SES_ID;
		}elseif(SES_TYPE < 3){
			$TmLogUserCond = "";
		}
		
        /* change for timelog */
        $logtime_sql = "SELECT SUM(LogTime.total_hours) as tot_hrs "
                . "FROM log_times as LogTime "
                . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                . "WHERE Easycase.isactive=1  " . $logtime_condition . " " . $case_condition_sql
                . " ".$TmLogUserCond." AND Easycase.id IN (SELECT id as cnt FROM easycases WHERE istype=1 " . $clt_sql . " " . $actcond . ")";
        #echo $logtime_sql;exit;
        $tot_hrs = $this->LogTime->query($logtime_sql);
        /* $hrsql = "SELECT SUM(hours) as tot_hrs FROM easycases WHERE istype =2 AND ".$clt_sql." ".$crtdcond;
          $tot_hrs = $this->Easycase->query($hrsql); */
        $this->set('tot_hrs', $this->Format->format_time_hr_min($tot_hrs[0][0]['tot_hrs']));

        $sql = "SELECT actual_dt_created as postdate,legend,dt_created,case_no "
                . "FROM easycases "
                . "WHERE istype =1 AND isactive =1" . $clt_sql . " AND project_id!=0 AND (legend != 1) " . $actcond;
        $post_arr = $this->Easycase->query($sql);
        $resolved_cnt = 0;
        $closed_cnt = 0;
        $resolved = array();
        $closed = array();
        $resolved_diff = array();
        $closed_diff = array();
        if ($cnt[0][0]['cnt'] != 0) {
            if (!empty($post_arr)) {
                foreach ($post_arr as $k => $v) {
                    if ($v['easycases']['legend'] == 5) {
                        $resolved_diff[] = round(abs(strtotime($v['easycases']['dt_created']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                    } elseif ($v['easycases']['legend'] == 3) {
                        $closed_diff[] = round(abs(strtotime($v['easycases']['dt_created']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                        $ressql = "SELECT max(dt_created) as createdt,legend FROM easycases WHERE istype =1 AND legend = 5 " . $clt_sql . " AND case_no = '" . $v['easycases']['case_no'] . "'" . $prjcond;
                        $res_arr = $this->Easycase->query($ressql);
                        if (!empty($res_arr[0][0]['createdt'])) {
                            $resolved_diff[] = round(abs(strtotime($res_arr[0][0]['createdt']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                        }
                    } else {
                        $ressql = "SELECT max(dt_created) as createdt,legend FROM easycases WHERE istype =1 " . $clt_sql . " AND (legend = 5 OR legend = 3) AND case_no = '" . $v['easycases']['case_no'] . "'" . $prjcond;
                        $res_arr = $this->Easycase->query($ressql);
                        foreach ($res_arr as $k => $v1) {
                            if ($v1['easycases']['legend'] == 3) {
                                $closed_diff[] = round(abs(strtotime($v1[0]['createdt']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                            }
                            if ($v1['easycases']['legend'] == 5) {
                                $resolved_diff[] = round(abs(strtotime($v1[0]['createdt']) - strtotime($v['easycases']['postdate'])) / 86400) + 1;
                            }
                        }
                    }
                }
                $avg_resolved = (!empty($resolved_diff)) ? array_sum($resolved_diff) / count($resolved_diff) : 0;
                $avg_closed = (!empty($closed_diff)) ? array_sum($closed_diff) / count($closed_diff) : 0;
                $this->set('avg_resolved', $avg_resolved);
                $this->set('avg_closed', $avg_closed);
            }
            $resolved_cnt = count($resolved_diff);
            $closed_cnt = count($closed_diff);
            $this->set('resolved_cnt', $resolved_cnt);
            $this->set('closed_cnt', $closed_cnt);
        }
    }

    function tasks_trend() {
        $this->layout = "ajax";
        $this->loadModel('Easycase');

        $before = date('Y-m-d', strtotime($this->data['sdate']));
        $to = date('Y-m-d', strtotime($this->data['edate']));
        $days = (strtotime($to) - strtotime($before)) / (60 * 60 * 24);
        $csts_arr = array();
        $proj_id = $this->data['pjid'];
        $this->loadModel('Project');
        $proj_data = $this->Project->find('first', array('conditions' => array('Project.id' => $proj_id), 'fields' => array('Project.status_group_id','Project.id'),'recursive'=>-1));
        $x = floor($days);
        if ($x < 7) {
            $interval = 1;
        } elseif ($x > 80) {
            $interval = ceil($x / 10);
        } else {
            $interval = 7;
        }
        $this->set('tinterval', $interval);
        $dt_arr = array();
        $dts_arr = array();
        for ($i = 0; $i <= $x; $i++) {
            $m = " +" . $i . "day";
            $dt = date('Y-m-d', strtotime(date("Y-m-d", strtotime($before)) . $m));
            $dts = date('M d, Y', strtotime(date("Y-m-d H:i:s", strtotime($before)) . $m));
            $times = explode(" ", GMT_DATETIME);
            //$dt=$dt." ".$times['1'];
            array_push($dt_arr, $dt);
            array_push($dts_arr, $dts);
        }
        $open_arr = array();
        $res_arr = $carr = array();
        $s = "";
        $r = "";
		$frmTz = '+00:00';
		$toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
        $clt_sql = '';
        if ($this->Auth->user('is_client') == 1) {
            $clt_sql = " AND ((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ") ";
        }
        $taskid_sql = "SELECT id AS task_ids FROM easycases AS Easycase "
                . "WHERE Easycase.istype='1' AND  Easycase.isactive='1' "
                . "AND Easycase.project_id='" . $proj_id . "'"
                . "AND (DATE(Easycase.actual_dt_created) >= '" . $dt_arr[0] . "' AND DATE(Easycase.actual_dt_created) <= '" . $dt_arr[$x] . "') "
                . "" . $clt_sql . "  ";
        if(!empty($proj_data['Project']['status_group_id'])){
            $newcstm_sql = "SELECT DATE(Easycase.actual_dt_created) AS cdate,COUNT(Easycase.id) as count, CustomStatus.id,CustomStatus.name,CustomStatus.progress,CustomStatus.color "
                . "FROM easycases as Easycase "
                . "LEFT JOIN custom_statuses AS CustomStatus ON Easycase.custom_status_id = CustomStatus.id "
                . "WHERE Easycase.id IN ($taskid_sql) "
                . "GROUP BY Easycase.custom_status_id,DATE(Easycase.actual_dt_created) ";
            $trend_report = $this->Easycase->query($newcstm_sql);
            if(!empty($trend_report)){
                $Csts = ClassRegistry::init('CustomStatus');
                $csts_arr = $Csts->find('all', array('conditions' => array('CustomStatus.status_group_id' => $proj_data['Project']['status_group_id']),'order'=>array('CustomStatus.seq'=>'ASC')));
                $csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
                $cstm_data = array();
                foreach ($csts_arr as $k => $v) {
                    $cstm_data[$v['name']]['name'] = $v['name'];
                    $cstm_data[$v['name']]['color'] = '#'.$v['color'];
                    $cstm_data[$v['name']]['connectNulls'] = true;
                    $cstm_data[$v['name']]['data'] = array();
                }
                foreach ($cstm_data as $key1 => $value1) {
                    foreach ($dt_arr as $key => $date) {
                        $dtcnt = 0;
                        foreach($trend_report as $k => $v){
                            if($date == $v[0]['cdate'] && $v['CustomStatus']['name'] == $key1){
                                $dtcnt = (int)$v[0]['count'];
                                break;
                            }
                        }
                        $cstm_data[$key1]['data'][] = $dtcnt;
                    }

                }
                foreach ($cstm_data as $key => $value) {
                    $carr[] = $value;
                }
            }else{
                print '<img src="'.HTTP_ROOT.'img/sample/analytics/task_trend_chart.jpg" style="width:98%;">';
                exit;
            }
        }else{
            $new_report = $this->Easycase->query("SELECT DATE(Easycase.actual_dt_created) AS cdate,COUNT(Easycase.id) as count, CustomStatus.id,CustomStatus.name,CustomStatus.progress,CustomStatus.color "
                . "FROM easycases as Easycase "
                . "LEFT JOIN custom_statuses AS CustomStatus ON Easycase.custom_status_id = CustomStatus.id "
                . "WHERE Easycase.legend='1' "
                . "AND Easycase.id IN ($taskid_sql) "
                . "GROUP BY DATE(Easycase.actual_dt_created) ");
        $new_report = $this->convertinto_array($new_report);

            $wip_report = $this->Easycase->query("SELECT DATE(Easycase.actual_dt_created) AS cdate,COUNT(Easycase.id) as count, CustomStatus.id,CustomStatus.name,CustomStatus.progress,CustomStatus.color "
                . "FROM easycases as Easycase "
                    . "LEFT JOIN custom_statuses AS CustomStatus ON Easycase.custom_status_id = CustomStatus.id "
                . "WHERE (Easycase.legend='2' || Easycase.legend='4') "
                . "AND Easycase.id IN ($taskid_sql) "
                . "GROUP BY DATE(Easycase.actual_dt_created) ");
        $wip_report = $this->convertinto_array($wip_report);


            $resolved_report = $this->Easycase->query("SELECT ROUND(type_id) AS tid ,DATE(Easycase.actual_dt_created) AS cdate, CustomStatus.id,CustomStatus.name,CustomStatus.progress,CustomStatus.color, "
                . "COUNT(Easycase.id) as count "
                . "FROM easycases as Easycase "
                    . "LEFT JOIN custom_statuses AS CustomStatus ON Easycase.custom_status_id = CustomStatus.id "
                . "WHERE Easycase.legend='5' "
                . "AND Easycase.id IN ($taskid_sql) "
                . "GROUP BY Easycase.type_id,DATE(Easycase.actual_dt_created) ");

        $resolved_report = $this->convertinto_array($resolved_report, 1);
        global $resolved_type_arr;
        $res_type_arr = $resolved_type_arr;
            $res_sql = "SELECT ROUND(type_id) AS tid,DATE(Easycase.actual_dt_created) AS cdate,COUNT(Easycase.id) as count, CustomStatus.id,CustomStatus.name,CustomStatus.progress,CustomStatus.color "
                . "FROM easycases as Easycase "
                . "LEFT JOIN custom_statuses AS CustomStatus ON Easycase.custom_status_id = CustomStatus.id "
                . "WHERE Easycase.legend='3' "
                . "AND Easycase.id IN ($taskid_sql) "
                . "GROUP BY Easycase.type_id,DATE(Easycase.actual_dt_created) ";
            $closed_report = $this->Easycase->query($res_sql);
        $closed_report = $this->convertinto_array($closed_report, 1);
        $cls_type_arr = $resolved_type_arr;
		$bugs = array();
		$enh = array();
		$dev = array();
		$resolved = array();
		$closed = array();
		$yarr = array();
        foreach ($dt_arr as $key => $date) {
            if (array_key_exists($date, $new_report)) {
                $bugs[] = (int) $new_report[$date];
            } else {
                $bugs[] = (int) 0;
            }
            if (array_key_exists($date, $wip_report)) {
                $enh[] = (int) $wip_report[$date];
            } else {
                $enh[] = (int) 0;
            }
            if (is_array($dev_report) && array_key_exists($date, $dev_report)) {
                $dev[] = (int) $dev_report[$date];
            } else {
                $dev[] = (int) 0;
            }
            if (array_key_exists($date, $resolved_report)) {
                $resolved[] = (int) $resolved_report[$date];
            } else {
                $resolved[] = (int) 0;
            }
            if (array_key_exists($date, $closed_report)) {
                $closed[] = (int) $closed_report[$date];
            } else {
                $closed[] = (int) 0;
            }
        }


        if (!$type_id) {
                $carr = array();
            $carr = array(array('name' => 'New', 'color' => '#F90F0F', 'connectNulls' => 'true', 'data' => $bugs), array('name' => 'In Progress', 'color' => '#0066FF', 'connectNulls' => 'true', 'data' => $enh), array('name' => 'Resolved', 'color' => '#DF6625', 'connectNulls' => 'true', 'data' => $resolved), array('name' => 'Closed', 'color' => '#77AB13', 'connectNulls' => 'true', 'data' => $closed));
        } elseif ($type_id == 1) {
            $carr = array(array('name' => 'New', 'color' => '#F90F0F', 'connectNulls' => 'true', 'data' => $bugs));
        } elseif ($type_id == 2) {
            $carr = array(array('name' => 'In Progress', 'd' => 'M 4 7 L 12 7 12 15 4 15 Z', 'color' => '#0066FF', 'connectNulls' => 'true', 'data' => $dev));
        } elseif ($type_id == 5) {
            $carr = array(array('name' => 'Closed', 'color' => '#77AB13', 'connectNulls' => 'true', 'data' => $closed));
        } elseif ($type_id == 4) {
            $carr = array(array('name' => 'Resolved', 'color' => '#DF6625', 'connectNulls' => 'true', 'data' => $resolved));
        }

        $bugs_t = array_filter($bugs);
        $enh_t = array_filter($enh);
        $closed_t = array_filter($closed);
        $resolved_t = array_filter($resolved);
        if (empty($bugs_t) && empty($enh_t) && empty($closed_t) && empty($resolved_t)) {
            print '<img src="'.HTTP_ROOT.'img/sample/analytics/task_trend_chart.jpg" style="width:98%;">';
            exit;
        }
        }
        for ($i = 5; $i <= 100; $i++) {
            $yarr[] = (int) $i;
        }
        $this->set('dt_arr', json_encode($dts_arr));
            $this->set('yarr', json_encode($yarr));
            $this->set('carr', json_encode($carr));
        }

    /*
     * @method resource_utilization
     * Author Satyajeet
     */
	
    public function ajax_work_load_export_csv() {
        $qparams = $this->request->query;
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('Project');
        $this->loadModel('User');
        $this->loadModel('CompanyUser');
        $this->loadModel('LogTime');
        $cond = "";
        $qry = '';
        $arr = array();
        $log_condition = '';
        $filter_msg = array();
        $dt_arr = array();
        $curDate = date('Y-m-d H:i:s');
        if (isset($_COOKIE['utilization_date_filter']) && $_COOKIE['utilization_date_filter'] != '' && $_COOKIE['utilization_date_filter'] != 'all') {
            $filter = $_COOKIE['utilization_date_filter'];
        }

        $sts_filter = $_COOKIE['utilization_status_filter'];
        $prj_filter = $_COOKIE['utilization_project_filter'];
        $usr_filter = $_COOKIE['utilization_resource_filter'];

        if (isset($sts_filter) && $sts_filter != '' && $sts_filter != 'all') {
            $qry .= $this->Format->statusFilter($sts_filter);
        }

        if (isset($prj_filter) && $prj_filter != '' && $prj_filter != 'all') {
            $qry .= $this->Format->projectFilter($prj_filter, 'utilization');
        }

        if (isset($usr_filter) && $usr_filter != '' && $usr_filter != 'all') {
            $qry .= $this->Format->arcUserFilter($usr_filter, 'utilization');
        }

        if (!empty($filter)) {
            $check_custom = stristr($filter, 'custom');
            if ($check_custom) {
                $cstm_date_ar = explode(":", $filter);
                $date = ['strddt' => date('Y-m-d', strtotime($cstm_date_ar[1])), 'enddt' => date('Y-m-d', strtotime($cstm_date_ar[2]))];
                $filter = str_replace('custom:', '', $filter);
            } else {
                $date = $this->Format->date_filter(trim($filter), $curDate);
            }
        } else {
            $date = (!empty($filter)) ? $this->Format->date_filter(trim($filter), $curDate) : $this->Format->date_filter('thisweek', $curDate);
        }

        $limit = $qparams['rowCount'] ? $qparams['rowCount'] : 50;
        $offset = ($qparams['currentPage'] > 1 ? $qparams['currentPage'] - 1 : 0) * $limit;
        $current = $qparams['currentPage'] > 1 ? $qparams['currentPage'] : 1;
        $searchPhrase = $qparams['getSearchPhrase'];
        $search_cond = '';
        $sort_cond = ' order by LogTime.user_id ASC';

        if ($qparams['chk_type'] == 'resource') {
            if ($qparams['chk_order_type'] == 'asc') {
                $sort_cond = " order by User.name ASC";
            } else {
                $sort_cond = " order by User.name DESC";
            }
        } elseif ($qparams['chk_type'] == 'project') {
            if ($qparams['chk_order_type'] == 'asc') {
                $sort_cond = " order by Project.name ASC";
            } else {
                $sort_cond = " order by Project.name DESC";
            }
        }
        $sort_cond = " order by LogTime.start_datetime DESC";
        $search_cond_pu = '';
        /* if (isset($searchPhrase) && trim($searchPhrase) != '') {
          $search_cond_pu = " AND (User.name LIKE '%" . $searchPhrase . "%'";
          if(in_array('project', $this->data['check'])){
          $search_cond .= " OR Project.name LIKE '%" . $searchPhrase . "%'";
          }
          if(in_array('task_title', $this->data['check'])){
          $search_cond .= " OR Easycase.title LIKE '%" . $searchPhrase . "%'";
          }
          $search_cond .=") ";
          } */
        if (!empty($date['strddt']) && !empty($date['enddt'])) {
            $cond .= " AND DATE(Easycase.actual_dt_created) >= '" . $dt . "' ";
            $log_condition .= " AND DATE(start_datetime) >= '" . date('Y-m-d', strtotime($date['strddt'])) . "' AND DATE(start_datetime) <= '" . date('Y-m-d', strtotime($date['enddt'])) . "' ";
            $log_condition_st = "DATE(start_datetime) >= '" . date('Y-m-d', strtotime($date['strddt'])) . "' AND DATE(start_datetime) <= '" . date('Y-m-d', strtotime($date['enddt'])) . "'";
            $days = (strtotime($date['enddt']) - strtotime($date['strddt'])) / (60 * 60 * 24);
        } else if (!empty($date['strddt'])) {
            $cond .= " AND DATE(Easycase.actual_dt_created) >= '" . $dt . "' ";
            $log_condition .= " AND DATE(start_datetime) = '" . date('Y-m-d', strtotime($date['strddt'])) . "' ";
            $log_condition_st = "DATE(start_datetime) = '" . date('Y-m-d', strtotime($date['strddt'])) . "'";
        } else if (isset($date['enddt']) && !empty($date['enddt'])) {
            $dt = date('Y-m-d', strtotime($date['enddt']));
            $cond .= " AND DATE(Easycase.actual_dt_created) <= '" . $dt . "' ";
            $log_condition .= " AND DATE(start_datetime) = '" . $dt . "' ";
            $log_condition_st = "DATE(start_datetime) = '" . $dt . "'";
        }

        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dtm = $view->loadHelper('Datetime');
        $fmt = $view->loadHelper('Format');
        $grpby = $grpby1 = '';
        $groupbyarr = array('date' => 'DATE(LogTime.start_datetime)', 'resource' => 'LogTime.user_id',
            'project' => 'LogTime.project_id', 'task_title' => 'Easycase.id', 'hours' => 'hours', 'is_billable' => 'billable');
        $groupbyarr1 = array('date' => 'DATE(Result.start_datetime)', 'resource' => 'Result.user_id',
            'project' => 'Result.project_id', 'task_title' => 'Result.id', 'hours' => 'Result.hours', 'is_billable' => 'Result.billable');
        $grpby1 = $grpby = 'GROUP BY ';
        $str1 = $str = '';

        if (trim(ucfirst($qparams['chk_type'])) == 'Resource') {
            $fieldsShow = array('resource', 'hours', 'esthrs');
        } else {
            $fieldsShow = array('project', 'hours', 'esthrs');
        }

        foreach ($fieldsShow as $k => $val) {
            if ($val != 'task_status' && $val != 'hours' && $val != 'task_type' && $val != 'task_group' && $val != 'esthrs') {
                $str = $str . $groupbyarr['' . $val . ''] . ',';
                $str1 = $str1 . $groupbyarr1['' . $val . ''] . ',';
            }
        }
        $str = rtrim($str, ',');
        $str1 = rtrim($str1, ',');
        $grpby = (!empty($str)) ? $grpby . $str : '';
        $grpby1 = (!empty($str1)) ? $grpby1 . $str1 : '';
        $usr_cond = '';
        if (SES_TYPE < 3) {
            $usr_cond = "LogTime.user_id >0";
       }else if($this->Format->isAllowed('View All Resource')){
            $usr_cond = "LogTime.user_id >0";
        } elseif (SES_TYPE == 3) {
            $usr_cond = "LogTime.user_id = " . SES_ID;
        }
        $userlist = null;
        $projectlist = null;
        $cmn_cond = '1';

        $cmn_sort = 'ASC';
        if ($qparams['chk_type'] == 'resource') {
            if ($qparams['chk_order_type'] == 'asc') {
                
            } else {
                $cmn_sort = "DESC";
            }
        } elseif ($qparams['chk_type'] == 'project') {
            if ($qparams['chk_order_type'] == 'asc') {
                
            } else {
                $cmn_sort = "DESC";
            }
        }
        $tot_od_temp = 0;
        if (trim(ucfirst($qparams['chk_type'])) == 'Resource') { //for Resource which is default
            $users_condition_array = array('joins' => array(
                    array(
                        'table' => 'company_users',
                        'alias' => 'CompanyUser',
                        'type' => 'inner',
                        'conditions' => array('CompanyUser.user_id=User.id', 'User.email IS NOT NULL', 'CompanyUser.company_id' => SES_COMP, '(CompanyUser.is_active = 1 AND CompanyUser.is_client != 1)', "User.name LIKE '%$searchPhrase%'")
                    )),
                'fields' => array('User.id', 'User.uniq_id', 'User.name', 'User.email', 'User.last_name', 'User.photo'), 'order' => array('User.name' => $cmn_sort), 'limit' => $limit, 'offset' => $offset);
            if (!empty($usr_filter) && $usr_filter != "all") {
                $usr_arr = explode('-', $usr_filter);
                if (sizeof($usr_arr) == 1) {
                    $users_condition_array['conditions']['User.id'] = $usr_arr[0];
                } else {
                    $users_condition_array['conditions']['User.id IN'] = $usr_arr;
                }
            }
            $this->User->recursive = -1;
            $userlist = $this->User->find('all', $users_condition_array);
            if ($userlist) {
                $userlist = Hash::combine($userlist, '{n}.User.id', '{n}');
                #$cmn_cond = Hash::extract($userlist, '{n}.User.id');
                $cmn_cond = 'AND User.id IN(' . implode(',', Hash::extract($userlist, '{n}.User.id')) . ')';
                unset($users_condition_array['limit']);
                unset($users_condition_array['offset']);
                $userlist_cnt = $this->User->find('count', $users_condition_array);
                $tot_od_temp = $userlist_cnt;
            }
        } else {
            //for project
            $this->Project->recursive = -1;
            $prjs_condition_array = array('conditions' => array("Project.company_id" => SES_COMP, "Project.name LIKE" => '%' . $searchPhrase . '%'), 'order' => array('Project.name' => $cmn_sort), 'limit' => $limit, 'offset' => $offset);
            if (!empty($prj_filter) && $prj_filter != "all") {
                $prj_arr = explode('-', $prj_filter);
                if (sizeof($prj_arr) == 1) {
                    $prjs_condition_array['conditions']['Project.id'] = $prj_arr[0];
                } else {
                    $prjs_condition_array['conditions']['Project.id IN'] = $prj_arr;
                }
            }
            $projectlist = $this->Project->find('all', $prjs_condition_array);
            if ($projectlist) {
                $projectlist = Hash::combine($projectlist, '{n}.Project.id', '{n}');
                $cmn_cond = 'AND Project.id IN(' . implode(',', Hash::extract($projectlist, '{n}.Project.id')) . ')';
                unset($prjs_condition_array['limit']);
                unset($prjs_condition_array['offset']);
                $projectlist_cnt = $this->Project->find('count', $prjs_condition_array);
                $tot_od_temp = $projectlist_cnt;
            }
        }
        $log_sql_inner = "SELECT LogTime.user_id, SUM(LogTime.total_hours) AS hours, GROUP_CONCAT(Distinct LogTime.task_id)  AS esthrs,max(LogTime.start_datetime) as mxlogsttime, "
                . "if(LogTime.is_billable=1, 'Yes', 'No') AS billable, User.name, User.last_name,Project.id as pid, Project.name as pname, Easycase.id, Easycase.title, Easycase.legend, Easycase.type_id, LogTime.start_datetime,LogTime.project_id, Milestone.title AS mlstn_name "
                . "FROM log_times AS LogTime "
                . "LEFT JOIN easycases AS Easycase ON LogTime.task_id=Easycase.id AND LogTime.project_id=Easycase.project_id "
                . "LEFT JOIN easycase_milestones AS EasycaseMilestone ON LogTime.task_id = EasycaseMilestone.easycase_id "
                . "LEFT JOIN milestones AS Milestone ON EasycaseMilestone.milestone_id=Milestone.id "
                . "LEFT JOIN users AS User ON LogTime.user_id = User.id "
                . "LEFT JOIN projects AS Project ON LogTime.project_id= Project.id "
                . "WHERE Easycase.isactive=1 AND " . $usr_cond . " " . $log_condition . " " . $qry . " " . $search_cond . $cmn_cond . " AND Project.company_id=" . SES_COMP . " AND Easycase.id IS NOT NULL "
                . "$grpby $sort_cond  LIMIT $offset, $limit";

        $log_sql = "SELECT Result.*,sum(p.estimated_hours) as est_hrs FROM ($log_sql_inner) AS Result LEFT JOIN easycases AS p ON find_in_set(p.id,Result.esthrs) LEFT JOIN projects pr ON p.project_id = pr.id WHERE pr.company_id =" . SES_COMP . " AND p.id IS NOT NULL AND Result.id IS NOT NULL $grpby1";
        $logtime = $this->LogTime->query($log_sql);
        $tot_od = $this->LogTime->query("SELECT FOUND_ROWS() as tot_od");
        $reslt_logtime = null;
        $project_ids = null;
        if ($logtime) {
            if (trim(ucfirst($qparams['chk_type'])) == 'Resource') {
                $reslt_logtime = Hash::combine($logtime, '{n}.Result.user_id', '{n}');
            } else {
                $reslt_logtime = Hash::combine($logtime, '{n}.Result.pid', '{n}');
            }
            $project_ids = Hash::extract($logtime, '{n}.Result.project_id');
        }
        $data = array();

        $checkArry = ($userlist) ? $userlist : $projectlist;
        foreach ($checkArry as $key => $value) {
            if (isset($value['User']) && empty($value['User']['name']) && empty($value['User']['last_name'])) {
                continue;
            } else if (isset($value['Project']) && empty($value['Project']['name'])) {
                continue;
            }
            $hour = $this->Format->format_time_hr_min($reslt_logtime[$key]['Result']['hours']);
            $esthrs = $this->Format->format_time_hr_min($reslt_logtime[$key]['0']['est_hrs']);
            $caseDtUploaded = $reslt_logtime[$key]['Result']['mxlogsttime'];
            $updated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $caseDtUploaded, "datetime");
            $updatedCur = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            $displayTime = $dtm->dateFormatOutputdateTime_day($updated, $updatedCur); //Nov 25, Thu at 1:25 pm
            if (date('M d, Y', strtotime($updated)) != "Jan 01, 1970") {
                $updated = date('M d, Y H:i:s', strtotime($updated));
            } else {
                $updated = '--';
                $displayTime = '--';
            }

            $check_field = '';
            $check_field_uid = '';
            if (isset($value['Project'])) {
                if ($hour) {
                    $check_field_v = $value['Project']['name'];
                } else {
                    $check_field_v = $value['Project']['name'];
                }
                $check_field_uid = trim($value['Project']['uniq_id']);
                $check_field_k = 'project';
            } else {
                if ($hour) {
                    $check_field_v = $value['User']['name'] . " " . $value['User']['last_name'];
                } else {
                    $check_field_v = $value['User']['name'] . " " . $value['User']['last_name'];
                }
                $check_field_uid = trim($value['User']['uniq_id']);
                $check_field_k = 'resource';
            }
            $data[] = array(
                $check_field_k => $check_field_v,
                'esthrs' => ($esthrs) ? $esthrs : '--',
                'hours' => ($hour) ? $hour : '--',
                'date' => $displayTime,
                'uniq_id' => $check_field_uid
            );
        }

        if (!empty($data)) {
            $cmn_sort = ($qparams['chk_order_type'] == 'asc') ? "ASC" : "DESC";
            $data = $this->workloadSort($data, $cmn_sort);
        }

        $content = '';
        if (trim($qparams['chk_type']) == 'resource') {
            $content .= ($content == '') ? 'Resource' : ',Resource';
        }
        if (trim($qparams['chk_type']) == 'project') {
            $content .= ($content == '') ? 'Project' : ',Project';
        }
        $content .= ($content == '') ? 'Estimated Time(hrs)' : ',Estimated Time(hrs)';
        $content .= ($content == '') ? 'Spent Time(hrs)' : ',Spent Time(hrs)';
        $content .= ($content == '') ? 'Last Post' : ',Last Post';

        $content .= "\n";
        if (is_array($data) && count($data) > 0) {
            foreach ($data as $key => $val) {
                if (trim($qparams['chk_type']) == 'resource') {
                    $content .= '"' . str_replace('"', '""', trim($val['resource'])) . '",';
                }
                if (trim($qparams['chk_type']) == 'project') {
                    $content .= '"' . str_replace('"', '""', trim($val['project'])) . '",';
                }
                $content .= '"' . $val['esthrs'] . '",';
                $content .= '"' . $val['hours'] . '",';
                $content .= '"' . $val['date'] . '",';
                $content = trim($content, ',');
                $content .= "\n";
            }
        }

        if (!is_dir(WORK_LOAD_CSV_PATH)) {
            @mkdir(WORK_LOAD_CSV_PATH, 0777, true);
        }

        $name = '';
        $name .= (trim($name) != '' ? "_" : '') . date('m-d-Y', strtotime(GMT_DATE)) . "_work_load.csv";
        $download_name = date('m-d-Y', strtotime(GMT_DATE)) . "_work_load.csv";

        $file_path = WORK_LOAD_CSV_PATH . $name;
        $fp = @fopen($file_path, 'w+');
        fwrite($fp, $content);
        fclose($fp);

        $this->response->file($file_path, array('download' => true, 'name' => urlencode($download_name)));
        return $this->response;
    }
	
    function ajax_work_load() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('Project');
        $this->loadModel('User');
        $this->loadModel('CompanyUser');
        $this->loadModel('LogTime');
        $cond = "";
        $sts_cond = "";
        $qry = '';
		$inner_log_cond = '';
        $arr = array();
        $log_condition = '';
        $filter_msg = array();
        $dt_arr = array();
        $curDate = date('Y-m-d H:i:s');
        if(isset($_COOKIE['utilization_date_filter']) && $_COOKIE['utilization_date_filter'] != '' && $_COOKIE['utilization_date_filter']!= 'all'){
			$filter = $_COOKIE['utilization_date_filter'];
        }
        $prj_filter = $_COOKIE['utilization_project_filter'];
        $usr_filter = $_COOKIE['utilization_resource_filter'];
		
		$sts_filter = $_COOKIE['wl_status_filter'];//PRB TODAY
		if(isset($sts_filter) && $sts_filter != ''){
			if($sts_filter == 'all'){
				
			}else{
				$sts_cond = $this->Format->statusFilter($sts_filter,'work_load');
				//if(substr($sts_filter, -1) == '-'){
					$sts = explode('-', $sts_filter);
					foreach($sts as $k=>$val){
						if(!empty($val) && $val == 1){
							$msg = '<span class="filter_opn">'.__('New',true).'<a class="fr" onclick="removeStatus(1)" href="javascript:void(0);"><i class="material-icons">?</i></a></span>';
						}else if(!empty($val) && $val == 2){
							$msg = '<span class="filter_opn">'.__('In Progress',true).'<a class="fr" onclick="removeStatus(2)" href="javascript:void(0);"><i class="material-icons">?</i></a></span>';
						}else if(!empty($val) && $val == 3){
							$msg = '<span class="filter_opn">'.__('Closed',true).'<a class="fr" onclick="removeStatus(3)" href="javascript:void(0);"><i class="material-icons">?</i></a></span>';
						}else if(!empty($val) && $val == 5){
							$msg = '<span class="filter_opn">'.__('Resolved',true).'<a class="fr" onclick="removeStatus(5)" href="javascript:void(0);"><i class="material-icons">?</i></a></span>';
						}
						$filter_msg['status'][] =$msg; 
					}
					$filter_msg['status'] = array_unique($filter_msg['status']);
				//}
			}            
        }else{
			setcookie('wl_status_filter', '1-2', time() + 3600 * 24 * 7, '/', DOMAIN_COOKIE, false, false);
			$sts_cond = 'AND (Easycase.legend IN (1,2,4))';
			$filter_msg['status'][] = '<span class="filter_opn">'.__('New',true).'<a class="fr" onclick="removeStatus(1)" href="javascript:void(0);"><i class="material-icons">?</i></a></span>'; 
			$filter_msg['status'][] = '<span class="filter_opn">'.__('In Progress',true).'<a class="fr" onclick="removeStatus(2)" href="javascript:void(0);"><i class="material-icons">?</i></a></span>';
		}
        if(isset($prj_filter) && $prj_filter != '' && $prj_filter != 'all'){
			if(trim($this->data['check'][0]) == 'Resource'){
				$qry.= $this->Format->projectFilter($prj_filter, 'work_load');
			}
			$prj = explode('-', $prj_filter);
			foreach($prj as $k=>$val){
				$msg = '<span class="filter_opn">'.$this->Format->formatprjnm($val).'<a class="fr" onclick="removeProject('.$val.')" href="javascript:void(0);"><i class="material-icons"></i></a></span>';
				$filter_msg['project'][] =$msg;
			}
			$filter_msg['project'] = array_unique($filter_msg['project']);
        }
        if(isset($usr_filter) && $usr_filter != '' && $usr_filter != 'all'){
			if(trim($this->data['check'][0]) == 'Project'){
				$qry.= $this->Format->arcUserFilter($usr_filter, 'work_load');
			}
            $usr = explode('-', $usr_filter);
            foreach($usr as $k=>$val){
                $msg = '<span class="filter_opn">'.$this->Format->caseMemsList($val).'<a class="fr" onclick="removeResource('.$val.')" href="javascript:void(0);"><i class="material-icons"></i></a></span>';
                $filter_msg['resource'][] =$msg;
            }
            $filter_msg['resource'] = array_unique($filter_msg['resource']);
        }
        if (!empty($filter)) {
            $check_custom = stristr($filter, 'custom');
            if ($check_custom) {
                $cstm_date_ar = explode(":", $filter);
                $date = ['strddt' => date('Y-m-d', strtotime($cstm_date_ar[1])), 'enddt' => date('Y-m-d', strtotime($cstm_date_ar[2]))];
                $filter = str_replace('custom:', '', $filter);
			} else {
                $date = $this->Format->date_filter(trim($filter), $curDate);
            }
		} else {
			$date = (!empty($filter)) ? $this->Format->date_filter(trim($filter), $curDate) : $this->Format->date_filter('today', $curDate);
		}
        $limit = $this->data['rowCount'] ? $this->data['rowCount'] : 50;
        $offset = ($this->data['current'] > 1 ? $this->data['current'] - 1 : 0) * $limit;
        $current = $this->data['current'] > 1 ? $this->data['current'] : 1;
        $searchPhrase = $this->data['searchPhrase'];
        $search_cond = '';
		$search_cond_pu = '';
        /*if (isset($searchPhrase) && trim($searchPhrase) != '') {
            $search_cond_pu = " AND (User.name LIKE '%" . $searchPhrase . "%'";
            if(in_array('project', $this->data['check'])){
                $search_cond .= " OR Project.name LIKE '%" . $searchPhrase . "%'";
            }
            if(in_array('task_title', $this->data['check'])){
                $search_cond .= " OR Easycase.title LIKE '%" . $searchPhrase . "%'";
			}
			$search_cond .=") ";
        }*/
		$dt_mes = '';
		if (!empty($filter) && ($filter == 'today' || $filter == 'yesterday') && isset($date['strddt'])) {			
			$date['strddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['strddt'])), "datetime");
            $cond .= " AND ((Easycase.dt_created >= '" . $date['strddt_tz'] . "' AND Easycase.dt_created < '" . date('Y-m-d H:i:s', strtotime($date['strddt_tz'] . '+1 day')) . "') OR (Easycase.due_date >= '" . $date['strddt_tz'] . "' AND Easycase.due_date < '" . date('Y-m-d H:i:s', strtotime($date['strddt_tz'] . '+1 day')) . "')) ";
			$inner_log_cond = " AND Logtime.start_datetime >= '" . $date['strddt_tz'] . "' AND Logtime.start_datetime < '" . date('Y-m-d H:i:s', strtotime($date['strddt_tz'] . '+1 day')) . "'";
            $filter_msg['date']='<span class="filter_opn">'.date('M d, Y', strtotime($date['strddt'])).'<a class="fr" onclick="removeDate()" href="javascript:void(0);"><i class="material-icons"></i></a></span>';
			$dt_mes = ' on <small>'.date('M d, Y', strtotime($date['strddt'])).'</small>';
			
        } else if (!empty($date['strddt']) && !empty($date['enddt'])) {
			$date['strddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['strddt'])), "datetime");
			$date['enddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['enddt'])), "datetime");
			$date['enddt_tz'] = date('Y-m-d H:i:s', strtotime($date['enddt_tz'] . '+1 days'));			
            $cond .= " AND ((Easycase.dt_created >= '" . $date['strddt_tz'] . "' AND Easycase.dt_created <= '" . $date['enddt_tz'] . "') OR (Easycase.due_date >= '" . $date['strddt_tz'] . "' AND Easycase.due_date <= '" . $date['enddt_tz'] . "')) ";			
			$inner_log_cond = " AND Logtime.start_datetime >= '" . $date['strddt_tz'] . "' AND Logtime.end_datetime <= '" . $date['enddt_tz'] . "'";
            $filter_msg['date']='<span class="filter_opn">'.date('M d, Y', strtotime($date['strddt'])). " to ".date('M d, Y', strtotime($date['enddt'])).'<a class="fr" onclick="removeDate()" href="javascript:void(0);"><i class="material-icons"></i></a></span>';
            $days = (strtotime($date['enddt']) - strtotime($date['strddt'])) / (60 * 60 * 24);
			$dt_mes = ' between <small>'.date('M d, Y', strtotime($date['strddt'])).'</small> and <small>'. date('M d, Y', strtotime($date['enddt'])).'</small>';
        }else if(!empty($date['strddt'])){
			$date['strddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['strddt'])), "datetime");
            $cond .= " AND (Easycase.dt_created >= '" . $date['strddt_tz'] . "' OR Easycase.due_date >= '" . $date['strddt_tz'] . "') ";
			$inner_log_cond = " AND Logtime.start_datetime >= '" . $date['strddt_tz'] . "' ";
            $filter_msg['date']='<span class="filter_opn">'.date('M d, Y', strtotime($date['strddt'])).'<a class="fr" onclick="removeDate()" href="javascript:void(0);"><i class="material-icons"></i></a></span>';
			$dt_mes = ' on <small>'.date('M d, Y', strtotime($date['strddt'])).'</small>';
        }else if (isset($date['enddt']) && !empty($date['enddt'])) {
			$date['enddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['enddt'])), "datetime");
			$date['enddt_tz'] = date('Y-m-d H:i:s', strtotime($date['enddt_tz'] . '+1 days'));
            $cond .= " AND (Easycase.dt_created <= '" .$date['enddt_tz'] . "' OR Easycase.due_date <= '" .$date['enddt_tz'] . "') ";
			$inner_log_cond = " AND Logtime.end_datetime >= '" . $date['enddt_tz'] . "' ";
            $filter_msg['date']='<span class="filter_opn">'.date('M d, Y', strtotime($date['enddt'])).'<a class="fr" onclick="removeDate()" href="javascript:void(0);"><i class="material-icons"></i></a></span>';
			$dt_mes = ' by <small>'.date('M d, Y', strtotime($date['enddt'])).'</small>';
        }

        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dtm = $view->loadHelper('Datetime');
        $fmt = $view->loadHelper('Format');
        $usr_cond = '';
        if(SES_TYPE < 3){
           $usr_cond = "LogTime.user_id >0";
        }else if($this->Format->isAllowed('View All Resource')){
            $usr_cond = "LogTime.user_id >0";
        }elseif(SES_TYPE == 3){
            $usr_cond = "LogTime.user_id = ".SES_ID;
        }		
		$userlist = null;
		$projectlist = null;
		$cmn_cond = '1';		
		$cmn_sort= 'ASC';		
		 if (isset($this->data['sort']['resource'])) {
            if ($this->data['sort']['resource'] == 'asc') {
            } else {
               $cmn_sort= "DESC";
            }
        } elseif (isset($this->data['sort']['project'])) {
            if ($this->data['sort']['project'] == 'asc') {
            } else {
               $cmn_sort= "DESC";
            }
		}
		$tot_od_temp = 0;
		$tot_rows_posted = 0;
		//$grp_by = 'GROUP By res.uid';
		$grp_by = 'GROUP By res.user_id';
		if(trim($this->data['check'][0]) == 'Resource'){ //for Resource which is default		
            $users_condition_array = array('joins' => array(
			array(
				'table' => 'company_users',
				'alias' => 'CompanyUser',
				'type' => 'inner',
				'conditions'=> array('CompanyUser.user_id=User.id','User.email IS NOT NULL','CompanyUser.company_id'=>SES_COMP,'(CompanyUser.is_active = 1 AND CompanyUser.is_client != 1)',"User.name LIKE '%$searchPhrase%'")
			)),
                'fields' => array('User.id', 'User.uniq_id', 'User.name', 'User.email', 'User.last_name', 'User.photo'), 'order' => array('User.name' => $cmn_sort), 'limit' => $limit, 'offset' => $offset);
            if (!empty($usr_filter) && $usr_filter != "all") {
                $usr_arr = explode('-', $usr_filter);
                if (sizeof($usr_arr) == 1) {
                    $users_condition_array['conditions']['User.id'] = $usr_arr[0];
                } else {
                    $users_condition_array['conditions']['User.id IN'] = $usr_arr;
                }
            }
            $this->User->recursive = -1;
            $userlist = $this->User->find('all', $users_condition_array);
			if($userlist){
				$tot_rows_posted = count($userlist);
				$userlist = Hash::combine($userlist, '{n}.User.id', '{n}');
				$cmn_cond = ' Easycase.assign_to IN('.implode(',',Hash::extract($userlist, '{n}.User.id')).')';				
                unset($users_condition_array['limit']);
                unset($users_condition_array['offset']);
                $userlist_cnt = $this->User->find('count', $users_condition_array);
				$tot_od_temp = $userlist_cnt;
			}			
		}else{
			//for project
			$this->Project->recursive=-1;			
            $prjs_condition_array = array('conditions' => array("Project.company_id" => SES_COMP, "Project.isactive" => 1, "Project.name LIKE" => '%' . $searchPhrase . '%'), 'order' => array('Project.name' => $cmn_sort), 'limit' => $limit, 'offset' => $offset);
            if (!empty($prj_filter) && $prj_filter != "all") {
                $prj_arr = explode('-', $prj_filter);
                if (sizeof($prj_arr) == 1) {
                    $prjs_condition_array['conditions']['Project.id'] = $prj_arr[0];
                } else {
                    $prjs_condition_array['conditions']['Project.id IN'] = $prj_arr;
                }
            }
            $projectlist = $this->Project->find('all', $prjs_condition_array);
			if($projectlist){
				$tot_rows_posted = count($projectlist);
				$projectlist = Hash::combine($projectlist, '{n}.Project.id', '{n}');
				$cmn_cond = ' Easycase.project_id IN('.implode(',',Hash::extract($projectlist, '{n}.Project.id')).')';
                unset($prjs_condition_array['limit']);
                unset($prjs_condition_array['offset']);
                $projectlist_cnt = $this->Project->find('count', $prjs_condition_array);
				$tot_od_temp = $projectlist_cnt;
			}
			$grp_by = 'GROUP By res.pid';
		}
		if($cmn_cond != 1){
			if(trim($this->data['check'][0]) == 'Resource'){
				$work_sql_inner = "SELECT res.*, sum(res.total_hours) as tot_hrs, sum(res.estimated_hours) as total_est, max(res.dt_created) as dt_cret,COUNT(Distinct res.tsk_id) AS tsk_ids FROM(SELECT Project.name as project_name,Project.id as pid,Easycase.id as tsk_id,Easycase.title,Easycase.type_id,Easycase.actual_dt_created,Easycase.estimated_hours,sum(Logtime.total_hours) as total_hours,Easycase.legend,if(Logtime.user_id IS NOT NULL, Logtime.user_id, Easycase.assign_to) AS user_id,Easycase.dt_created,User.id as uid,CONCAT(User.name,' ',User.last_name) as uname,User.short_name,Easycase.assign_to FROM (SELECT * FROM easycases as Easycase WHERE Easycase.istype='1' AND Easycase.isactive=1 AND Easycase.title !='' ".$sts_cond." AND ".$cmn_cond." AND Easycase.project_id!=0 ".$qry.$cond.") AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id INNER JOIN projects Project ON Easycase.project_id=Project.id AND Project.company_id=".SES_COMP." AND Project.isactive=1 LEFT JOIN log_times Logtime ON Easycase.id=Logtime.task_id".$inner_log_cond." group by Logtime.user_id,Easycase.id ORDER BY Easycase.estimated_hours DESC,Easycase.dt_created DESC) as res ".$grp_by;			
			}else{
				$work_sql_inner = "SELECT res.*,max(res.dt_crt) as dt_cret,SUM(res.tot_hrs_t) as tot_hrs, SUM(res.res_estmhr) as total_est,COUNT(Distinct res.tsk_id) AS tsk_ids from (SELECT res1.*, SUM(res1.tot_hrs) as tot_hrs_t,max(res1.dt_cret) as dt_crt from (SELECT res.*, SUM(res.total_hours) as tot_hrs, res.estimated_hours as res_estmhr, max(res.dt_created) as dt_cret,COUNT(Distinct res.tsk_id) AS tsk_ids FROM(SELECT Project.name as project_name,Project.id as pid,Easycase.id as tsk_id,Easycase.title,Easycase.type_id,Easycase.actual_dt_created,Easycase.estimated_hours,Logtime.total_hours,Easycase.legend,Logtime.user_id,Easycase.dt_created,User.id as uid,CONCAT(User.name,' ',User.last_name) as uname,User.short_name,Easycase.assign_to FROM (SELECT * FROM easycases as Easycase WHERE Easycase.istype='1' AND Easycase.isactive=1 AND Easycase.title !='' ".$sts_cond." AND ".$cmn_cond." AND Easycase.project_id!=0 ".$qry.$cond.") AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id INNER JOIN projects Project ON Easycase.project_id=Project.id AND Project.company_id=".SES_COMP." AND Project.isactive=1 LEFT JOIN log_times Logtime ON Easycase.id=Logtime.task_id".$inner_log_cond." ORDER BY Easycase.estimated_hours DESC,Easycase.dt_created DESC) as res GROUP By res.user_id,res.tsk_id,res.pid) as res1 group by res1.tsk_id) as res GROUP BY res.pid";
			}
			#print $work_sql_inner;exit;
			$logtime = $this->Easycase->query($work_sql_inner);
		}else{
			$logtime = array();
		}
		$reslt_logtime = null;
		$project_ids = null;
		$tot_posted = 0;
		$tot_hr_posted = 0;
		$tot_est_posted = 0;
		if($logtime){
			if(trim($this->data['check'][0]) == 'Resource'){
				$reslt_logtime = Hash::combine($logtime, '{n}.res.uid', '{n}');
			}else{
				$reslt_logtime = Hash::combine($logtime, '{n}.res.pid', '{n}');
			}
			$project_ids = Hash::extract($logtime, '{n}.res.pid');
			$tot_posted = count($logtime);
		}
        $data = array("current" => $current,
            "rowCount" => $limit,
            "rows" => array(),
            "total" => $tot_od_temp,
            "total_rows" => $tot_rows_posted,			
            "totalPosted" =>$tot_posted,
            "totalHrPosted" =>$tot_hr_posted,
            "totalEstPosted" =>$tot_est_posted,
            "by_msg" =>$dt_mes,
            "filter_msg" => $filter_msg);
		
		$checkArry = ($userlist)?$userlist:$projectlist;
		foreach ($checkArry as $key => $value) {
			if(isset($value['User']) && empty($value['User']['name']) && empty($value['User']['last_name'])){ 
				continue; 
			}else if(isset($value['Project']) && empty($value['Project']['name'])){ 
				continue; 
			}
            $hour = $this->Format->format_time_hr_min($reslt_logtime[$key][0]['tot_hrs']);
            $esthrs = $this->Format->format_time_hr_min($reslt_logtime[$key][0]['total_est']);
			$caseDtUploaded = $reslt_logtime[$key][0]['dt_cret'];
            $updated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $caseDtUploaded, "datetime");
            $updatedCur = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            $displayTime = $dtm->dateFormatOutputdateTime_day($updated, $updatedCur); //Nov 25, Thu at 1:25 pm
			if (date('M d, Y', strtotime($updated)) != "Jan 01, 1970") {
				$updated = date('M d, Y H:i:s', strtotime($updated));
			}else{				
				$updated = '--';
				$displayTime = '--';
			}
			
			$check_field = '';
			$check_field_uid = '';
			if(isset($value['Project'])){
				if($hour){					
					$check_field_v = $value['Project']['name'];
				}else{
					$check_field_v = $value['Project']['name'];
				}
				$check_field_uid = trim($value['Project']['uniq_id']);
				$check_field_k = 'project';
			}else{
				if($hour){
					$check_field_v = $value['User']['name'] . " " . $value['User']['last_name'];
				}else{
					$check_field_v = $value['User']['name'] . " " . $value['User']['last_name'];
				}
				$check_field_uid = trim($value['User']['uniq_id']);
				$check_field_k = 'resource';
			}
			if($hour){
				$tot_hr_posted += $reslt_logtime[$key][0]['tot_hrs'];
			}
			if($esthrs){
				$tot_est_posted += $reslt_logtime[$key][0]['total_est'];
			}
			$deviation = '--';
			if($reslt_logtime[$key][0]['tot_hrs'] > $reslt_logtime[$key][0]['total_est']){
				$deviation = $reslt_logtime[$key][0]['tot_hrs']-$reslt_logtime[$key][0]['total_est'];
				$deviation = $this->Format->format_time_hr_min($deviation);
			}			
			$data['rows'][] = array( 
			$check_field_k => $check_field_v, 
			'esthrs' => ($esthrs)?$esthrs:'--', 
			'hours' => ($hour)?$hour:'--',
			'date' => $displayTime,
			'uniq_id' => $check_field_uid,
			'deviation' => $deviation,
			'esthrstime' => empty($reslt_logtime[$key][0]['total_est']) ? 0 : $reslt_logtime[$key][0]['total_est'],
			'task_count'=>($reslt_logtime[$key][0]['tsk_ids'])?$reslt_logtime[$key][0]['tsk_ids']:'--'
			);
		}
		if($tot_est_posted || $tot_hr_posted){
			$tot_est_posted = $this->Format->format_time_hr_min($tot_est_posted);
			if($tot_est_posted){
				$data['totalEstPosted'] = ($tot_est_posted)?$tot_est_posted:'--';
			}
			$tot_hr_posted = $this->Format->format_time_hr_min($tot_hr_posted);
			if($tot_hr_posted){
				$data['totalHrPosted'] = ($tot_hr_posted)?$tot_hr_posted:'--';
			}
		}
        if (!empty($data['rows'])) {
            if (trim($this->data['check'][0]) == 'Resource') {
                $cmn_sort = ($this->data['sort']['resource'] == 'asc') ? "ASC" : "DESC";
            } else {
                $cmn_sort = ($this->data['sort']['project'] == 'asc') ? "ASC" : "DESC";
            }
            $data['rows'] = $this->workloadSort($data['rows'], $cmn_sort);
        }
        echo json_encode($data);
        exit;
    }
    public function workloadSort($data, $sort) {
        $esthrstime = array();
        foreach ($data as $key => $row) {
            $esthrstime[$key] = $row['task_count'];
        }
        ($sort == "ASC") ? array_multisort($esthrstime, SORT_ASC, $data) : array_multisort($esthrstime, SORT_DESC, $data);
        return $data;
    }
	function ajax_work_load_pop(){
		$this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('Project');
        $this->loadModel('User');
        $cond = "";
		$inner_log_cond = "";
        $qry = '';
		$sts_cond = '';
        $arr = array();
        $log_condition = '';
        $filter_msg = array();
        $dt_arr = array();
        $curDate = date('Y-m-d H:i:s');
        if(isset($_COOKIE['utilization_date_filter']) && $_COOKIE['utilization_date_filter'] != '' && $_COOKIE['utilization_date_filter']!= 'all'){
        $filter = $_COOKIE['utilization_date_filter'];
        }
        $prj_filter = $_COOKIE['utilization_project_filter'];
        $usr_filter = $_COOKIE['utilization_resource_filter'];
		
		$sts_filter = $_COOKIE['wl_status_filter'];//PRB TODAY
		if(isset($sts_filter) && $sts_filter != ''){
			if($sts_filter == 'all'){				
			}else{
				$sts_cond = $this->Format->statusFilter($sts_filter,'work_load');
			}            
        }else{
			 $sts_cond = 'AND (Easycase.legend IN (1,2,4))';
		}
		
        if(isset($prj_filter) && $prj_filter != '' && $prj_filter != 'all'){
            if(strtolower(trim($this->data['typ'])) == 'resource'){
				$qry.= $this->Format->projectFilter($prj_filter, 'work_load');
			}
        }
        if(isset($usr_filter) && $usr_filter != '' && $usr_filter != 'all'){
            if(strtolower(trim($this->data['typ'])) == 'project'){
				$qry.= $this->Format->arcUserFilter($usr_filter, 'work_load');
			}
        }
		//$qry = ''; PRB was there
        if (!empty($filter)) {
            $check_custom = stristr($filter, 'custom');
            if ($check_custom) {
                $cstm_date_ar = explode(":", $filter);
                $date = ['strddt' => date('Y-m-d', strtotime($cstm_date_ar[1])), 'enddt' => date('Y-m-d', strtotime($cstm_date_ar[2]))];
                $filter = str_replace('custom:', '', $filter);
			} else {
                $date = $this->Format->date_filter(trim($filter), $curDate);
            }
		} else {
			$date = (!empty($filter)) ? $this->Format->date_filter(trim($filter), $curDate) : $this->Format->date_filter('today', $curDate);
		}
		/*$sort_cond = " order by LogTime.start_datetime DESC";
		if ($this->data['sort']['date'] == 'asc') {
			//$sort_cond = " order by LogTime.start_datetime ASC";
		}*/
        #pr($this->data);exit;
        $searchPhrase = $this->data['searchPhrase'];
        $search_cond = ''; 
        if (!empty($filter) && ($filter == 'today' || $filter == 'yesterday') && isset($date['strddt'])) {			
			$date['strddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['strddt'])), "datetime");
            $cond .= " AND ((Easycase.dt_created >= '" . $date['strddt_tz'] . "' AND Easycase.dt_created < '" . date('Y-m-d H:i:s', strtotime($date['strddt_tz'] . '+1 day')) . "') OR (Easycase.due_date >= '" . $date['strddt_tz'] . "' AND Easycase.due_date < '" . date('Y-m-d H:i:s', strtotime($date['strddt_tz'] . '+1 day')) . "'))";
			$inner_log_cond = " AND Logtime.start_datetime >= '" . $date['strddt_tz'] . "' AND Logtime.start_datetime < '" . date('Y-m-d H:i:s', strtotime($date['strddt_tz'] . '+1 day')) . "'";
            $filter_msg['date']='<span class="filter_opn">'.date('M d, Y', strtotime($date['strddt'])).'<a class="fr" onclick="removeDate()" href="javascript:void(0);"><i class="material-icons"></i></a></span>';
			$dt_mes = ' on <small>'.date('M d, Y', strtotime($date['strddt'])).'</small>';
			
        } else if (!empty($date['strddt']) && !empty($date['enddt'])) {
			$date['strddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['strddt'])), "datetime");
			$date['enddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['enddt'])), "datetime");
			$date['enddt_tz'] = date('Y-m-d H:i:s', strtotime($date['enddt_tz'] . '+1 days'));			
            $cond .= " AND ((Easycase.dt_created >= '" . $date['strddt_tz'] . "' AND Easycase.dt_created <= '" . $date['enddt_tz'] . "') OR (Easycase.due_date >= '" . $date['strddt_tz'] . "' AND Easycase.due_date <= '" . $date['enddt_tz'] . "'))";
			$inner_log_cond = " AND Logtime.start_datetime >= '" . $date['strddt_tz'] . "' AND Logtime.end_datetime <= '" . $date['enddt_tz'] . "'";
        }else if(!empty($date['strddt'])){
			$date['strddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['strddt'])), "datetime");
            $cond .= " AND (Easycase.dt_created >= '" . $date['strddt_tz'] . "' OR Easycase.due_date >= '" . $date['strddt_tz'] . "')";
			$inner_log_cond = " AND Logtime.start_datetime >= '" . $date['strddt_tz'] . "'";
        }else if (isset($date['enddt']) && !empty($date['enddt'])) {
			$date['enddt_tz'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime($date['enddt'])), "datetime");
			$date['enddt_tz'] = date('Y-m-d H:i:s', strtotime($date['enddt_tz'] . '+1 days'));
            $cond .= " AND (Easycase.dt_created <= '" .$date['enddt_tz'] . "' OR Easycase.due_date <= '" .$date['enddt_tz'] . "')";
			$inner_log_cond = " AND Logtime.end_datetime <= '" . $date['enddt_tz'] . "'";
        }

        $view = new View($this);
        $tz = $view->loadHelper('Tmzone');
        $dtm = $view->loadHelper('Datetime');
        $fmt = $view->loadHelper('Format');    
        $usr_cond = '';
        if(SES_TYPE < 3){
           $usr_cond = "LogTime.user_id >0";
        }else if($this->Format->isAllowed('View All Resource')){
            $usr_cond = "LogTime.user_id >0";
        }elseif(SES_TYPE == 3){
            $usr_cond = "LogTime.user_id = ".SES_ID;
        }	
		$cmn_cond = '1';
		$view_type = 'resource';
		if(strtolower(trim($this->data['typ'])) == 'resource'){	
			$this->User->recursive=-1;
			$userlist = $this->User->find('first',array('conditions'=>array("User.uniq_id"=>$this->data['uid'])));			
			if($userlist){
				$cmn_cond = ' (Easycase.assign_to ='.$userlist['User']['id'].' OR Easycase.id IN(SELECT task_id from log_times Logtime WHERE Logtime.user_id='.$userlist['User']['id'].$inner_log_cond.'))';			
			}			
		}else{
			$view_type = 'project';
			//for project
			$this->Project->recursive=-1;			
			$projectlist = $this->Project->find('first',array('conditions'=>array("Project.uniq_id"=>$this->data['uid'])));
			if($projectlist){
				$cmn_cond = ' Easycase.project_id ='.$projectlist['Project']['id'];
			}
		}
		//Easycase.title !='' AND (Easycase.legend IN(1,2,4,5) OR (Easycase.legend =3 AND UNIX_TIMESTAMP(Easycase.dt_created)>UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 1 DAY)))) AND ".$cmn_cond
		
		if(strtolower(trim($this->data['typ'])) == 'resource'){	
			$work_sql_inner = "SELECT res.*, sum(res.total_hrs) as tot_hrs, res.estimated_hours as total_est, max(res.dt_created) as dt_cret FROM(SELECT Project.name as pname,Project.id as pid,Easycase.id as tsk_id,Easycase.title,Easycase.uniq_id,Easycase.type_id,Easycase.actual_dt_created,Logtime.user_id,Easycase.case_no,Easycase.user_id as euid,Easycase.estimated_hours,Easycase.due_date,Easycase.priority,sum(Logtime.total_hours) as total_hrs,Easycase.legend,Easycase.dt_created,User.id as uid,CONCAT(User.name,' ',User.last_name) as uname,User.short_name,Easycase.assign_to FROM (SELECT * FROM easycases as Easycase WHERE Easycase.istype='1' AND Easycase.isactive=1 AND Easycase.title !='' ".$sts_cond." AND ".$cmn_cond." AND Easycase.project_id!=0 ".$qry.$cond.") AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id INNER JOIN projects Project ON Easycase.project_id=Project.id AND Project.company_id=".SES_COMP." AND Project.isactive=1 LEFT JOIN log_times Logtime ON Easycase.id=Logtime.task_id AND Logtime.user_id=".$userlist['User']['id'].$inner_log_cond." group by Logtime.user_id,Easycase.id ORDER BY Easycase.estimated_hours DESC,Easycase.dt_created DESC) as res group by res.tsk_id ORDER BY res.dt_created DESC";
		}else{
			$work_sql_inner = "SELECT res.*, sum(res.total_hours) as tot_hrs, res.estimated_hours as total_est, max(res.dt_created) as dt_cret FROM(SELECT Project.name as pname,Project.id as pid,Easycase.id as tsk_id,Easycase.title,Easycase.uniq_id,Easycase.type_id,Easycase.actual_dt_created,Logtime.user_id,Easycase.user_id as euid,Easycase.case_no,Easycase.estimated_hours,Easycase.due_date,Easycase.priority,Logtime.total_hours,Easycase.legend,Easycase.dt_created,User.id as uid,CONCAT(User.name,' ',User.last_name) as uname,User.short_name,Easycase.assign_to FROM (SELECT * FROM easycases as Easycase WHERE Easycase.istype='1' AND Easycase.isactive=1 AND Easycase.title !='' ".$sts_cond." AND ".$cmn_cond." AND Easycase.project_id!=0 ".$qry.$cond.") AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id INNER JOIN projects Project ON Easycase.project_id=Project.id AND Project.company_id=".SES_COMP." AND Project.isactive=1 LEFT JOIN log_times Logtime ON Easycase.id=Logtime.task_id".$inner_log_cond." ORDER BY Easycase.estimated_hours DESC,Easycase.dt_created DESC) as res group by res.user_id,res.tsk_id ORDER BY res.dt_created DESC";
		}
		#print $work_sql_inner;exit;
		$logtime = $this->Easycase->query($work_sql_inner);		
        $data = array("rows" => array(),"total" => 0,'type'=>$view_type);
		$priority_arr = array(0=>'High',1=>'Medium',2=>'Low');
		$status_arr = array(1=>'New',2=>'In Progress',3=>'Closed',4=>'In Progress',5=>'Resolved');
		#pr($logtime);exit;
		if($logtime){
			$cratedIds = array_values(array_unique(Hash::extract($logtime, '{n}.res.euid')));
			$uids = (count($cratedIds)==1)?$cratedIds[0]:$cratedIds;
			$unames = $this->User->find('all',array('conditions'=>array('User.id'=>$uids),'fields'=>array('User.id','User.name','User.last_name')));
			$unames = Hash::combine($unames, '{n}.User.id', '{n}');
			
			$log_cratedIds = array_values(array_unique(Hash::extract($logtime, '{n}.res.user_id')));
			$log_uids = (count($log_cratedIds)==1)?$log_cratedIds[0]:$log_cratedIds;
			$log_unames = $this->User->find('all',array('conditions'=>array('User.id'=>$log_uids),'fields'=>array('User.id','User.name','User.last_name')));
			$log_unames = Hash::combine($log_unames, '{n}.User.id', '{n}');	
			
			$t_estimated = 0;
			$t_non_estimated = 0;
			$t_due_task = 0;
			$t_no_due_task = 0;
			$t_high_task = 0;			
			
		foreach ($logtime as $key => $value) {
			$deviation = 0;
			if($value[0]['total_est'] && $value[0]['tot_hrs'] > $value[0]['total_est']){
				$deviation = $this->Format->format_time_hr_min($value[0]['tot_hrs'] - $value[0]['total_est']);
			}
            $hour = $this->Format->format_time_hr_min($value[0]['tot_hrs']);
            //$esthrs = $this->Format->format_time_hr_min($value[0]['total_est']);
            $esthrs = $this->Format->format_time_hr_min($value['res']['estimated_hours']);
            $caseDtUploaded = $value[0]['dt_cret'];
            $updated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $caseDtUploaded, "datetime");
			
			$casedue_dt = $value['res']['due_date'];
			$due_dt = date('M d, Y', strtotime($tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $casedue_dt, "datetime")));
			if($due_dt == 'Jan 01, 1970'){
				$due_dt = '--';
			}
			$casecrted_dt = $value['res']['actual_dt_created'];
			$created_dt = date('M d, Y', strtotime($tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $casecrted_dt, "datetime")));
			if($created_dt == 'Jan 01, 1970'){
				$created_dt = '--';
			}
			$created_by = 'Me';
			if($value['res']['euid']!=SES_ID){
				$created_by = $unames[$value['res']['euid']]['User']['name'].' '.$unames[$value['res']['euid']]['User']['last_name'];
			}			
            //$updatedCur = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            //$displayTime = $dtm->dateFormatOutputdateTime_day($updated, $updatedCur); //Nov 25, Thu at 1:25 pm
            $typeNm = $this->Format->getRequireTypeName($value['res']['type_id']);
	
    if($esthrs !=''){
    $t_estimated += $value['res']['estimated_hours'];
    }else{
    $t_non_estimated += 1;
    }
    if($due_dt == '--'){
    $t_no_due_task += 1;
    }else{					
    $t_due_task += 1;
    }
    if($value['res']['priority'] == 0){					
    $t_high_task += 1;
    }
			$data['rows'][] = array( 
			'resource' => (!empty($log_unames[$value['res']['user_id']]['User']['name']))?$log_unames[$value['res']['user_id']]['User']['name'].' '.$log_unames[$value['res']['user_id']]['User']['last_name']:$value['res']['uname'], 
			'project' => $fmt->formatTitle($value['res']['pname']), 
			'task_no' => $value['res']['case_no'],
			'task_uid' => $value['res']['uniq_id'],
			'task_title' => $fmt->formatTitle($value['res']['title']),
			'task_status' => $status_arr[$value['res']['legend']],
			'task_type' => $typeNm,
			'task_legend' => ($value['res']['type_id'] == 10)?10:$value['res']['legend'],
			'priority' => $priority_arr[$value['res']['priority']],
			'esthrs' => ($esthrs !='')?$esthrs:'--', 
			'hours' => empty($hour)?'--':$hour,
			'deviation' => $deviation,
			'last_updated' => date('M d, Y', strtotime($updated)),
			'due_date' => $due_dt,
			'created_dt' => date('M d, Y', strtotime($created_dt)),
			'created_by'=> $created_by
			//'is_billable' => $value['res']['billable']
			);
        }
			$estmtd = $this->Format->format_time_hr_min($t_estimated);
			$data['misc'] = array('estimated'=>($estmtd !='')?$estmtd:0,
								  'non_estimated' =>$t_non_estimated,
								  'due_task' =>$t_due_task,
								  'no_due_task' =>$t_no_due_task,
								  'high_task' =>$t_high_task);			
		}
		$this->set(compact('data'));
	}
    
    /*
     * Author Satyajeet
     * To get count of notifications
     */

    function getNotificationCounts() {
    if (!isset($_SESSION['Notification']) || $_SESSION['Notification']['company'] != SES_COMP) {
			$user_id = SES_ID;
            $this->loadModel('Notification');
            $this->loadModel('User');
            $this->User->recursive = -1;
            $overdueLsatSeen = $assigntomeLastSeen = $timelogLastSeen = '';
            $notificationDet = $this->Notification->find('first', array('conditions' => array('Notification.user_id' => $user_id)));
            $lastLogoutdt = $this->User->find('first', array('conditions' => array('User.id' => $user_id), 'fields' => array('User.dt_last_logout','User.dt_created')));
            $lastLogoutdt['User']['dt_last_logout'] = $lastLogoutdt['User']['dt_last_logout'] == '' ? date('Y-m-d H:i:s', strtotime(GMT_DATETIME . " -1 day")) : $lastLogoutdt['User']['dt_last_logout'];
				
            if (empty($notificationDet)) {
                $overdueLsatSeen = $assigntomeLastSeen = $timelogLastSeen = $activityLastSeen = $lastLogoutdt['User']['dt_last_logout'];
                $pricingLastSeen = '';
            } else {
                $notificationInfo = json_decode($notificationDet['Notification']['notification_info']);
                $overdueLsatSeen = $notificationInfo->overdue == '' || strtotime($notificationInfo->overdue) < strtotime($lastLogoutdt['User']['dt_last_logout']) ? $lastLogoutdt['User']['dt_last_logout'] : $notificationInfo->overdue;
                $assigntomeLastSeen = $notificationInfo->assigntome == '' || strtotime($notificationInfo->assigntome) < strtotime($lastLogoutdt['User']['dt_last_logout']) ? $lastLogoutdt['User']['dt_last_logout'] : $notificationInfo->assigntome;
                $timelogLastSeen = $notificationInfo->timelog == '' || strtotime($notificationInfo->timelog) < strtotime($lastLogoutdt['User']['dt_last_logout']) ? $lastLogoutdt['User']['dt_last_logout'] : $notificationInfo->timelog;
                $activityLastSeen = $notificationInfo->activity == '' || strtotime($notificationInfo->activity) < strtotime($lastLogoutdt['User']['dt_last_logout']) ? $lastLogoutdt['User']['dt_last_logout'] : $notificationInfo->activity;
                if (SES_TYPE == 1 || SES_TYPE == 2) {
                    $pricingLastSeen = $notificationInfo->pricing;
                }
            }
			$datetime1 = new DateTime($timelogLastSeen);
			$datetime2 = new DateTime(GMT_DATETIME);
			$interval = $datetime1->diff($datetime2);
			$t_frmt = $interval->format('%R%a');
			if($t_frmt >=1 && $interval->h > 1){
				$timelogLastSeen = date('Y-m-d H:i:s', strtotime('-1 day'));
			}
            $usrcndn = '';
            if (SES_TYPE == 3) {
                $usrcndn = "(Easycase.user_id = $user_id OR Easycase.assign_to = $user_id) AND ";
            }
            $clt_sql = 1;
            if ($this->Auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
            $overdueCntSql = "SELECT count(DISTINCT(Easycase.id)) as count FROM easycases AS Easycase inner JOIN users AS User ON (Easycase.user_id = User.id) Inner JOIN projects AS Project ON (Easycase.project_id = Project.id) Inner JOIN project_users AS ProjectUser ON (Easycase.project_id = ProjectUser.project_id AND ProjectUser.company_id = '" . SES_COMP . "') WHERE Project.isactive='1' AND " . $clt_sql . " AND Easycase.istype='1' AND Easycase.isactive='1' AND Easycase.legend != '3' AND $usrcndn Easycase.due_date >= '$overdueLsatSeen' AND Easycase.due_date < '" . GMT_DATETIME . "'";
			
            $overdueCnt = $this->User->query($overdueCntSql);
			$prevOverdueCntSql = "SELECT count(DISTINCT(Easycase.id)) as count FROM easycases AS Easycase inner JOIN users AS User ON (Easycase.user_id = User.id) INNER JOIN projects AS Project ON (Easycase.project_id = Project.id) INNER JOIN project_users AS ProjectUser ON (Easycase.project_id = ProjectUser.project_id AND ProjectUser.company_id = '" . SES_COMP . "') WHERE Project.isactive='1' AND " . $clt_sql . " AND Easycase.istype='1' AND Easycase.isactive='1' AND Easycase.legend != '3' AND $usrcndn Easycase.due_date < '$overdueLsatSeen'";
			$prevOverdueCnt = $this->User->query($prevOverdueCntSql);
			
			
            $assigntomeCntSql = "SELECT count(DISTINCT(Easycase.id)) as count FROM easycases AS Easycase WHERE Easycase.assign_to=(SELECT CompanyUser.user_id FROM company_users AS CompanyUser WHERE CompanyUser.company_id = '" . SES_COMP . "' AND CompanyUser.user_id = '" . SES_ID . "' AND CompanyUser.is_active = 1) AND Easycase.project_id IN(SELECT Project.id FROM projects AS Project WHERE Project.company_id = '" . SES_COMP . "'  AND Project.isactive=1) AND (Easycase.istype='1' OR (Easycase.istype='2' AND Easycase.reply_type='2')) AND Easycase.isactive='1' AND Easycase.assign_to = '" . SES_ID . "' AND Easycase.actual_dt_created >= '$assigntomeLastSeen'";
            $assigntomeCnt = $this->User->query($assigntomeCntSql);
			
			if (SES_TYPE == 3) {
				$timelogCntSql = "SELECT if(SUM(LogTime.total_hours), 0, 1) as count FROM log_times AS LogTime WHERE LogTime.user_id = '" . SES_ID . "' AND LogTime.project_id IN (SELECT Project.id FROM projects AS Project WHERE Project.company_id = '" . SES_COMP . "' AND Project.isactive=1) AND LogTime.start_datetime >= '$timelogLastSeen'";
			}else{
				$timelogCntSql = "SELECT if(SUM(LogTime.total_hours), 0, 1) as count FROM log_times AS LogTime WHERE LogTime.user_id IN(SELECT CompanyUser.user_id FROM company_users AS CompanyUser WHERE CompanyUser.company_id = '" . SES_COMP . "' AND CompanyUser.is_active = 1) AND LogTime.project_id IN (SELECT Project.id FROM projects AS Project WHERE Project.company_id = '" . SES_COMP . "' AND Project.isactive=1) AND LogTime.start_datetime >= '$timelogLastSeen'";
			}
			if (SES_TYPE == 3) {
				$timeloglastEntrySql = "SELECT MAX(LogTime.created) as lastentry FROM log_times AS LogTime WHERE LogTime.user_id='" . SES_ID . "' AND LogTime.project_id IN (SELECT Project.id FROM projects AS Project WHERE Project.company_id = '" . SES_COMP . "' AND Project.isactive=1)";
			}else{
				$timeloglastEntrySql = "SELECT MAX(LogTime.created) as lastentry FROM log_times AS LogTime WHERE LogTime.user_id IN(SELECT CompanyUser.user_id FROM company_users AS CompanyUser WHERE CompanyUser.company_id = '" . SES_COMP . "' AND CompanyUser.is_active = 1) AND LogTime.project_id IN (SELECT Project.id FROM projects AS Project WHERE Project.company_id = '" . SES_COMP . "' AND Project.isactive=1)";
			}			
			
            $timelogCnt = $this->User->query($timelogCntSql);
            $timeloglastEntry = $this->User->query($timeloglastEntrySql);
            $lastEntry = $timeloglastEntry[0][0]['lastentry'] == '' ? $timelogLastSeen : $timeloglastEntry[0][0]['lastentry'];
			
			#$activityCntsql = "SELECT count(Easycase.id) as count FROM easycases AS Easycase inner JOIN users AS User ON (Easycase.user_id = User.id) inner JOIN projects AS Project ON (Easycase.project_id = Project.id) inner JOIN project_users AS ProjectUser ON (Easycase.project_id = ProjectUser.project_id AND ProjectUser.user_id = '" . SES_ID . "' AND ProjectUser.company_id = '" . SES_COMP . "') WHERE Project.isactive='1' AND " . $clt_sql . " AND Easycase.isactive='1' AND Easycase.istype!='1' AND Easycase.actual_dt_created >= '$activityLastSeen'";
            #$activityCnt = $this->User->query($activityCntsql);
            $_SESSION['Notification'] = array();
            $_SESSION['Notification']['company'] = SES_COMP;
            $_SESSION['Notification']['overdueCount'] = strtotime($lastLogoutdt['User']['dt_last_logout']) < strtotime($overdueLsatSeen) ? 0 : $overdueCnt[0][0]['count'];
            $_SESSION['Notification']['prevOverdueCount'] = strtotime($lastLogoutdt['User']['dt_last_logout']) < strtotime($overdueLsatSeen) ? 0 : $prevOverdueCnt[0][0]['count'];
            $_SESSION['Notification']['overdueDate'] = $overdueLsatSeen . '_' . GMT_DATETIME;
            $_SESSION['Notification']['assigntomeCount'] = strtotime($lastLogoutdt['User']['dt_last_logout']) < strtotime($assigntomeLastSeen) ? 0 : $assigntomeCnt[0][0]['count'];
            $_SESSION['Notification']['assigntomeDate'] = $assigntomeLastSeen . '_' . GMT_DATETIME;
            $_SESSION['Notification']['timelogCount'] = strtotime($lastLogoutdt['User']['dt_last_logout']) < strtotime($timelogLastSeen) ? 0 : $timelogCnt[0][0]['count'];
            $_SESSION['Notification']['timelogCount'] = date('Y-m-d', strtotime($timelogLastSeen)) == date('Y-m-d') ? 0 : $timelogCnt[0][0]['count'];
            $_SESSION['Notification']['timeloglastEntry'] = date('M d, Y', strtotime($lastEntry));
			if(date('Y-m-d') == date('Y-m-d',strtotime($lastLogoutdt['User']['dt_created']))){
				$_SESSION['Notification']['timelogCount'] = 0;
			}
            #$_SESSION['Notification']['activityCount'] = strtotime($lastLogoutdt['User']['dt_last_logout']) < strtotime($activityLastSeen) ? 0 : $activityCnt[0][0]['count'];
            if (SES_TYPE == 1 || SES_TYPE == 2) {
                $_SESSION['Notification']['pricingCount'] = $pricingLastSeen == '' ? 1 : 0;
            }
            $_SESSION['Notification']['totalCount'] = strtotime($lastLogoutdt['User']['dt_last_logout']) < strtotime($notificationDet['Notification']['total_seen']) ? 0 : (intval($_SESSION['Notification']['overdueCount'])>0?1:0) + (intval($_SESSION['Notification']['assigntomeCount'])>0?1:0) + (intval($_SESSION['Notification']['timelogCount'])>0?1:0) + (intval($_SESSION['Notification']['activityCount'])>0?1:0) + intval($_SESSION['Notification']['pricingCount']);
        }
        echo json_encode(array('res' => $_SESSION['Notification']));exit;
    }
    
    public function getProductreleaseCounts_back(){
        $user_subsons = $this->UserSubscription->readSubDetlfromCache(SES_COMP);
        $this->loadModel('Release');
        $release_sql = "(SELECT t1.id, t1.title, t1.release_date FROM releases t1 LEFT JOIN release_subscriptions t2 ON t1.id = t2.release_id WHERE t2.id IS NULL) UNION (SELECT  t1.id, t1.title, t1.release_date FROM releases t1 LEFT JOIN release_subscriptions t2 ON t1.id = t2.release_id WHERE t2.subscription_id = ".$user_subsons['UserSubscription']['subscription_id'].") ORDER BY release_date DESC LIMIT 4";
        $rl_data = $this->Release->query($release_sql);

        $this->loadModel('ReleaseLog');
        $params = array(
            'conditions' => array('ReleaseLog.user_id' => SES_ID),
            'fields' => array('ReleaseLog.release_id'),
        );
        $rlog = $this->ReleaseLog->find('all', $params);
        $user_rl_ids = array_unique(Hash::extract($rlog, "{n}.ReleaseLog.release_id"));
        $new_release_count = $_SESSION['Notification']['new_release_count'] = 0;
        foreach ($rl_data as $key => $value) {
            if(in_array($value[0]['id'],$user_rl_ids)){
               $rl_data[$key][0]['is_seen'] = true;
            }else{
                $new_release_count++;
                $rl_data[$key][0]['is_seen'] = false;
            }
			$rl_data[$key][0]['release_date'] = date('F j, Y', strtotime($value[0]['release_date']));
        }
        $resp['new_count'] = $new_release_count;
        $resp['data'] = $rl_data;
        echo json_encode($resp);exit;
    }

    public function getProductreleaseCounts(){
        $user_subsons = $this->UserSubscription->readSubDetlfromCache(SES_COMP);
        $this->loadModel('Release');
        $release_sql = "SELECT t1.id, t1.title, t1.release_date FROM releases t1  ORDER BY t1.release_date DESC LIMIT 4";
        $rl_data = $this->Release->query($release_sql);
      //  echo $release_sql;exit;
        $this->loadModel('ReleaseLog');
        $params = array(
            'conditions' => array('ReleaseLog.user_id' => SES_ID),
            'fields' => array('ReleaseLog.release_id'),
        );
        $rlog = $this->ReleaseLog->find('all', $params);
        $user_rl_ids = array_unique(Hash::extract($rlog, "{n}.ReleaseLog.release_id"));
        $new_release_count = $_SESSION['Notification']['new_release_count'] = 0;
       // echo "<pre>";print_r($rl_data);exit;
        foreach ($rl_data as $key => $value) {
            if(in_array($value['t1']['id'],$user_rl_ids)){
               $rl_data[$key][0]['is_seen'] = true;
            }else{
                $new_release_count++;
                $rl_data[$key][0]['is_seen'] = false;
            }
            $rl_data[$key][0]['release_date'] = date('F j, Y', strtotime($value['t1']['release_date']));
            $rl_data[$key][0]['id'] = $value['t1']['id'];
            $rl_data[$key][0]['title'] = $value['t1']['title'];
        }
        $resp['new_count'] = $new_release_count;
        $resp['data'] = $rl_data;
        echo json_encode($resp);exit;
    }
    public function get_releaseinfo(){
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $data = $this->request->data;
            $this->loadModel('Release');
            $options = array('conditions' => array('Release.' . $this->Release->primaryKey => $data['rl_id']));
            $rl_data = $this->Release->find('first', $options);
            $this->loadModel('ReleaseLog');
            $rlog_cond = array('user_id' => SES_ID, 'release_id' => $rl_data['Release']['id']);
            if (!$this->ReleaseLog->hasAny($rlog_cond)) {
                $rlog['ReleaseLog'] = array('user_id'=>SES_ID,'release_id'=>$rl_data['Release']['id']);
                $this->ReleaseLog->create();
                $this->ReleaseLog->save($rlog);
            }
            $this->set('rl_data',$rl_data);
        }
    }
    /*
     * Author Satyajeet
     * Update last seen of notifications
     */
    function updateLastSeen(){
        $this->loadModel('Notification');
        $notificationTypes = array('overdue', 'assigntome', 'timelog', 'activity', 'pricing');
        $type = $this->request->data['type'];
        $notifArr = array();
        $notificationDet = $this->Notification->find('first', array('conditions' => array('Notification.user_id' => SES_ID)));
        if(!empty($notificationDet)){
            $notifArr['id'] = $notificationDet['Notification']['id'];
        }
        $notifArr['user_id'] = SES_ID;
        if($type == 'total'){
            $notifArr['total_seen'] = GMT_DATETIME;
            $infoDet = $notificationDet['Notification']['notification_info'];
        }else{
            $notifArr['total_seen'] = $notificationDet['Notification']['total_seen'];
            $infoDet = json_decode($notificationDet['Notification']['notification_info'], true);
            foreach($notificationTypes as $val){
                if($val == $type){
                    $infoDet[$val] = GMT_DATETIME;
                }else{
                    //$infoDet[$val] = '';
                }
            }
            $infoDet = json_encode($infoDet);
        }
        $notifArr['notification_info'] = $infoDet;
        $notifArr['dt_created'] = GMT_DATETIME;
        if($this->Notification->save($notifArr)){
            //$_SESSION['Notification']['totalCount'] = $_SESSION['Notification']['totalCount'] - $_SESSION['Notification'][$type.'Count'];
            $_SESSION['Notification'][$type.'Count'] = 0;
            echo 1;exit;
        }
    }    
}