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
#App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));
#App::import('Vendor', 'ElephantIO', array('file' => 'ElephantIO' . DS . 'Client.php'));
#use ElephantIO\Client as ElephantIOClient;
require_once(ROOT . DS . 'app' . DS . 'Vendor' . DS . 'PHPExcel' . DS . 'Classes' . DS . 'PHPExcel.php');
class LogTimesController extends AppController {

    public $name = 'LogTime';
    public $components = array('Format', 'Postcase', 'Sendgrid', 'Tmzone','Pushnotification');

     public function beforeFilter() {
        parent::beforeFilter();
         $this->Auth->allow('timesheetPDF');
     }
    function export_csv_timelog() {
        $this->loadModel('Easycase');
        $this->loadModel('LogTime');
        $this->loadModel('Project');
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        $data = $this->params->query;
        $from_date = trim($data['strddt']);
        $to_date = trim($data['enddt']);
        $user_id = trim($data['usrid'], ',');
        $date = trim($data['date']);
        $checkedFields = explode(',', $data['checkedFields']);
	//	$csv_dt_format = end($checkedFields);
		$CSV_DT_FORMAT = trim($data['dt_format']);

       //$csv_dt_format='y-m-d';
      // define('CSV_DT_FORMAT', $csv_dt_format);
		//array_pop($checkedFields);
        $prjid = $GLOBALS['getallproj'][0]['Project']['id'];
        $prjuniqueid = $GLOBALS['getallproj'][0]['Project']['uniq_id'];

        $projFil = trim($data['projuniqid']);
        $usid = '';
        $st_dt = '';
        $where = '';
        /* project details */
        if ($projFil != '') {
            $params = array(
                'conditions' => array('Project.uniq_id' => $projFil, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                'fields' => array('Project.id'));
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', $params);
            $project_id = $projArr['Project']['id'];
        } else {
            $project_id = $prjid;
            $projFil = $prjuniqueid;
        }
        $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        if ($user_id) {
            $usrid = $user_id;
            $where .= " AND `LogTime`.`user_id` IN (" . $usrid . ")";
            //$usid = " AND user_id = '" . $usrid . "'";
            //$count_usid = " AND LogTime.user_id = '" . $usrid . "'";
        }
        if ($date && $date != '' && $date != 'alldates') {
            $filter = $date;
            $dates = $this->Format->date_filter($filter, $curDateTime);
            $data = array_merge($data, $dates);
            //print_r($data);exit;
			if ($data['strddt'] != '') {
            $from_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($data['strddt']), "datetime");
			}
			if($data['enddt'] != ''){
            $to_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($data['enddt']), "datetime");
            $to_date = date('Y-m-d H:i:s', strtotime($to_date . '+1 day'));
			}            
        } else if ($from_date != '' || $to_date != '') {
            if ($from_date != '') {
                $from_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime(trim($data['strddt']))), "datetime");
            }
            if ($to_date != '') {
                $to_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime(trim($data['enddt']))), "datetime");
                $to_date = date('Y-m-d H:i:s', strtotime($to_date . '+1 days'));
            }
        }
        if ($date && $date != '' && ($date == 'today' || $date == 'yesterday')) {
			$where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "' AND `LogTime`.`start_datetime` < '" . date('Y-m-d H:i:s', strtotime($from_date . '+1 day')) . "'";
            $st_dt = " AND `start_datetime` >= '" . $from_date . "' AND `start_datetime` < '" . date('Y-m-d H:i:s', strtotime($from_date . '+1 day')) . "'";			
        } elseif ($from_date != '' && $to_date != '') {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "' AND `LogTime`.`start_datetime` < '" . $to_date . "'";
            $st_dt = " AND `start_datetime` >= '" . $from_date . "' AND `start_datetime` < '" . $to_date . "'";
            /* $where .= " AND `LogTime`.`start_datetime` BETWEEN '" . date('Y-m-d', strtotime($from_date)) . "' AND '" . date('Y-m-d', strtotime($to_date)) . "'";
              $st_dt = " AND DATE(start_datetime) BETWEEN '" . date('Y-m-d', strtotime($from_date)) . "' AND '" . date('Y-m-d', strtotime($to_date)) . "'"; */
        } elseif ($from_date != '') {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "'";
            $st_dt = " AND start_datetime >= '" . $from_date . "'";
        } elseif ($to_date != '') {
            $where .= " AND `LogTime`.`start_datetime` < '" . $to_date . "'";
            $st_dt = " AND start_datetime < '" . $to_date . "'";
        }


        $options = array();
        $options['fields'] = array("LogTime.*", "DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1",
            "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name",
            "(SELECT title FROM easycases AS `Easycase` WHERE Easycase.id=LogTime.task_id LIMIT 1) AS task_name",
            "(SELECT case_no FROM easycases AS `Easycase` WHERE Easycase.id=LogTime.task_id LIMIT 1) AS task_no");
        if ($projFil == 'all') {
             $options['joins'] = array(array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'LEFT', 'conditions' => array('Easycase.id=LogTime.task_id', 'LogTime.project_id=Easycase.project_id')), array('table' => 'projects', 'alias' => 'Project', 'type' => 'LEFT', 'conditions' => array('Project.id=LogTime.project_id','Project.isactive=1')));
            $options['conditions'] = array("Easycase.isactive" => 1,'Project.isactive'=>1,'Project.company_id'=>SES_COMP ,trim(trim($where), 'AND'));
            if (SES_TYPE == 3 && SES_ID != 13902) {
                $options['conditions'] = array("Easycase.isactive" => 1, "LogTime.user_id" => SES_ID, trim(trim($where), 'AND'));
            }
        } else {
            $options['joins'] = array(array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'LEFT', 'conditions' => array('Easycase.id=LogTime.task_id', 'LogTime.project_id=Easycase.project_id')));
            $options['conditions'] = array("LogTime.project_id" => $project_id, "Easycase.isactive" => 1, trim(trim($where), 'AND'));
            if (SES_TYPE == 3 && SES_ID != 13902) {
                $options['conditions'] = array("LogTime.project_id" => $project_id, "Easycase.isactive" => 1, "LogTime.user_id" => SES_ID, trim(trim($where), 'AND'));
            }
        }
        $options['order'] = 'start_datetime DESC';
        $logtimes = $this->LogTime->find('all', $options);
        $caseCount = $this->LogTime->find('count', $options);
        //print_r($caseCount);
        #echo "<pre>";print_r($logtimes);exit;
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {
                $logtimes[$key]["LogTime"]['start_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['start_datetime'], "datetime");
                $logtimes[$key]["LogTime"]['end_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['end_datetime'], "datetime");
                $logtimes[$key][0]['start_datetime_v1'] = date('M d Y H:i:s', strtotime($logtimes[$key]["LogTime"]['start_datetime']));

                $logtimes[$key]['LogTime']['start_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['start_datetime']));
                $logtimes[$key]['LogTime']['end_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['end_datetime']));
                if($projFil == 'all' && in_array('prj_name', $checkedFields)){
                    $logtimes[$key]['LogTime']['prj_name'] = $this->Format->getProjectName($logtimes[$key]['LogTime']['project_id']);
                }
            }
        }
				if($projFil != 'all'){					
					foreach($checkedFields as $chk => $chv){
						if($chv == 'prj_name'){
							unset($checkedFields[$chk]);
						}
					}
				}
        $content = '';
        if (in_array('date', $checkedFields)) {
            $content.= 'Date';
        }
        if (in_array('usr_name', $checkedFields)) {
            $content == '' ? $content.= 'Name' : $content.= ',Name';
        }
        if (in_array('prj_name', $checkedFields)) {
            $content == '' ? $content.= 'Project Name' : $content.= ',Project Name';
        }
        if (in_array('task_no', $checkedFields)) {
            $content == '' ? $content.= 'Task#' : $content.= ',Task#';
        }
        if (in_array('task_title', $checkedFields)) {
            $content == '' ? $content.= 'Task Title' : $content.= ',Task Title';
        }
        if (in_array('description', $checkedFields)) {
            $content == '' ? $content.= 'Note' : $content.= ',Note';
        }
        if (in_array('start', $checkedFields)) {
            $content == '' ? $content.= 'Start' : $content.= ',Start';
        }
        if (in_array('end', $checkedFields)) {
            $content == '' ? $content.= 'End' : $content.= ',End';
        }
        if (in_array('break', $checkedFields)) {
            $content == '' ? $content.= 'Break(hours)' : $content.= ',Break(hours)';
        }
        if (in_array('billable', $checkedFields)) {
            $content == '' ? $content.= 'Billable' : $content.= ',Billable';
        }
        if (in_array('hours', $checkedFields)) {
            $content == '' ? $content.= 'Logged Hours' : $content.= ',Logged Hours';
        }
        $content .= "\n";
        $total_billable_hours = 0;
        $total_non_billable_hours = 0;
		#pr($logtimes);exit;
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {
			
                $date = date($CSV_DT_FORMAT, strtotime($val["LogTime"]['start_datetime']));
                if (in_array('date', $checkedFields)) {
                   // $content .= '"' . $this->Format->dateFormatReverse($date) . '",';
                    $content .= '" ' . $date . '",';
                }
                if (in_array('usr_name', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val[0]['user_name'])) . '",';
                }
                //if (in_array('usr_name', $checkedFields)) {
                if (in_array('prj_name', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val['LogTime']['prj_name'])) . '",';
                }
                if (in_array('task_no', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val[0]['task_no'])) . '",';
                }
                if (in_array('task_title', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val[0]['task_name'])) . '",';
                }
                if (in_array('description', $checkedFields)) {
                    $content .='"' . $this->Format->stripHtml(str_replace('"', '""', trim($val['LogTime']['description']))) . '",';
                }
                if (in_array('start', $checkedFields)) {
                    $content .='"' . $this->Format->format_24hr_to_12hr($val['LogTime']['start_time']) . '",';
                }
                if (in_array('end', $checkedFields)) {
                    $content .='"' . $this->Format->format_24hr_to_12hr($val['LogTime']['end_time']) . '",';
                }
                if (in_array('break', $checkedFields)) {
                    $content .='"' . round(($val['LogTime']['break_time'] / 3600), 2) . '",';
                }
                if (in_array('billable', $checkedFields)) {
                    $content .='"' . ($val['LogTime']['is_billable'] == '1' ? 'Yes' : 'No') . '",';
                }
                if (in_array('hours', $checkedFields)) {
                    $content .='"' . round(($val['LogTime']['total_hours'] / 3600), 2) . '",';
                }
                $content = trim($content, ',');
                $content .="\n";
                ($val['LogTime']['is_billable'] == '1' ? $total_billable_hours+= $val['LogTime']['total_hours'] : $total_non_billable_hours+= $val['LogTime']['total_hours']);
            }
        }



        $_curdt =  $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $_fmt = ($SES_TIME_FORMAT ==12)?'m/d/Y g:i a':'m/d/Y H:i';
       // $content .= "\n" . "Export Date," . $this->Format->dateFormatReverse(GMT_DATETIME);
        $content .= "\n" . "Export Date, " . date($CSV_DT_FORMAT,strtotime($_curdt));
        $content .= "\n" . "Total," . $caseCount . " records";
        $content .= "\n" . "Total Billable Hours," . $this->Format->format_time_hr_min($total_billable_hours) . " ";
        $content .= "\n" . "Total Non-Billable Hours," . $this->Format->format_time_hr_min($total_non_billable_hours) . " ";
        $content .= "\n" . "Total Hours," . $this->Format->format_time_hr_min($total_billable_hours + $total_non_billable_hours) . " ";
        #echo $content;exit;
        if (!is_dir(LOGTIME_CSV_PATH)) {
            @mkdir(LOGTIME_CSV_PATH, 0777, true);
        }

        $name = $projFil;
        if (trim($name) != '' && strlen($name) > 25) {
            $name = substr($name, 0, 24) . "_" . date('m-d-Y', strtotime(GMT_DATE)) . "_timelog.csv";
        } else {
            $name .= (trim($name) != '' ? "_" : '') . date('m-d-Y', strtotime(GMT_DATE)) . "_timelog.csv";
        }
        $download_name = date('m-d-Y', strtotime(GMT_DATE)) . "_timelog.csv";
        
        $file_path = LOGTIME_CSV_PATH . $name;
        $fp = @fopen($file_path, 'w+');
        fwrite($fp, $content);
        fclose($fp);

        $this->response->file($file_path, array('download' => true, 'name' => urlencode($download_name)));
        return $this->response;
    }
    function export_csv_timelog_orginal() {
        $this->loadModel('Easycase');
        $this->loadModel('LogTime');
        $this->loadModel('Project');
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        $data = $this->params->query;
        $from_date = trim($data['strddt']);
        $to_date = trim($data['enddt']);
        $user_id = trim($data['usrid'], ',');
        $date = trim($data['date']);
        $checkedFields = explode(',', $data['checkedFields']);
        $prjid = $GLOBALS['getallproj'][0]['Project']['id'];
        $prjuniqueid = $GLOBALS['getallproj'][0]['Project']['uniq_id'];

        $projFil = trim($data['projuniqid']);
        $usid = '';
        $st_dt = '';
        $where = '';
        /* project details */
        if ($projFil != '') {
            $params = array(
                'conditions' => array('Project.uniq_id' => $projFil, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP),
                'fields' => array('Project.id'));
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', $params);
            $project_id = $projArr['Project']['id'];
        } else {
            $project_id = $prjid;
            $projFil = $prjuniqueid;
        }
        $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        if ($user_id) {
            $usrid = $user_id;
            $where .= " AND `LogTime`.`user_id` IN (" . $usrid . ")";
            //$usid = " AND user_id = '" . $usrid . "'";
            //$count_usid = " AND LogTime.user_id = '" . $usrid . "'";
        }
        if ($date && $date != '' && $date != 'alldates') {
            $filter = $date;
            $dates = $this->Format->date_filter($filter, $curDateTime);
            $data = array_merge($data, $dates);
            //print_r($data);exit;
			if ($data['strddt'] != '') {
            $from_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($data['strddt']), "datetime");
			}
			if($data['enddt'] != ''){
            $to_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($data['enddt']), "datetime");
            $to_date = date('Y-m-d H:i:s', strtotime($to_date . '+1 day'));
			}            
        } else if ($from_date != '' || $to_date != '') {
            if ($from_date != '') {
                $from_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime(trim($data['strddt']))), "datetime");
            }
            if ($to_date != '') {
                $to_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-d', strtotime(trim($data['enddt']))), "datetime");
                $to_date = date('Y-m-d H:i:s', strtotime($to_date . '+1 days'));
            }
        }
        if ($date && $date != '' && ($date == 'today' || $date == 'yesterday')) {
			$where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "' AND `LogTime`.`start_datetime` < '" . date('Y-m-d H:i:s', strtotime($from_date . '+1 day')) . "'";
            $st_dt = " AND `start_datetime` >= '" . $from_date . "' AND `start_datetime` < '" . date('Y-m-d H:i:s', strtotime($from_date . '+1 day')) . "'";			
        } elseif ($from_date != '' && $to_date != '') {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "' AND `LogTime`.`start_datetime` < '" . $to_date . "'";
            $st_dt = " AND `start_datetime` >= '" . $from_date . "' AND `start_datetime` < '" . $to_date . "'";
            /* $where .= " AND `LogTime`.`start_datetime` BETWEEN '" . date('Y-m-d', strtotime($from_date)) . "' AND '" . date('Y-m-d', strtotime($to_date)) . "'";
              $st_dt = " AND DATE(start_datetime) BETWEEN '" . date('Y-m-d', strtotime($from_date)) . "' AND '" . date('Y-m-d', strtotime($to_date)) . "'"; */
        } elseif ($from_date != '') {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "'";
            $st_dt = " AND start_datetime >= '" . $from_date . "'";
        } elseif ($to_date != '') {
            $where .= " AND `LogTime`.`start_datetime` < '" . $to_date . "'";
            $st_dt = " AND start_datetime < '" . $to_date . "'";
        }


        $options = array();
        $options['fields'] = array("LogTime.*", "DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1",
            "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name",
            "(SELECT title FROM easycases AS `Easycase` WHERE Easycase.id=LogTime.task_id LIMIT 1) AS task_name",
            "(SELECT case_no FROM easycases AS `Easycase` WHERE Easycase.id=LogTime.task_id LIMIT 1) AS task_no");
        if ($projFil == 'all') {
             $options['joins'] = array(array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'LEFT', 'conditions' => array('Easycase.id=LogTime.task_id', 'LogTime.project_id=Easycase.project_id')), array('table' => 'projects', 'alias' => 'Project', 'type' => 'LEFT', 'conditions' => array('Project.id=LogTime.project_id','Project.isactive=1')));
            $options['conditions'] = array("Easycase.isactive" => 1,'Project.isactive'=>1,'Project.company_id'=>SES_COMP ,trim(trim($where), 'AND'));
            if (SES_TYPE == 3 && SES_ID != 13902) {
                $options['conditions'] = array("Easycase.isactive" => 1, "LogTime.user_id" => SES_ID, trim(trim($where), 'AND'));
            }
        } else {
            $options['joins'] = array(array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'LEFT', 'conditions' => array('Easycase.id=LogTime.task_id', 'LogTime.project_id=Easycase.project_id')));
            $options['conditions'] = array("LogTime.project_id" => $project_id, "Easycase.isactive" => 1, trim(trim($where), 'AND'));
            if (SES_TYPE == 3 && SES_ID != 13902) {
                $options['conditions'] = array("LogTime.project_id" => $project_id, "Easycase.isactive" => 1, "LogTime.user_id" => SES_ID, trim(trim($where), 'AND'));
            }
        }
        $options['order'] = 'start_datetime DESC';
        $logtimes = $this->LogTime->find('all', $options);
        $caseCount = $this->LogTime->find('count', $options);
        //print_r($caseCount);
        #echo "<pre>";print_r($logtimes);exit;
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {
                $logtimes[$key]["LogTime"]['start_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['start_datetime'], "datetime");
                $logtimes[$key]["LogTime"]['end_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['end_datetime'], "datetime");
                $logtimes[$key][0]['start_datetime_v1'] = date('M d Y H:i:s', strtotime($logtimes[$key]["LogTime"]['start_datetime']));

                $logtimes[$key]['LogTime']['start_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['start_datetime']));
                $logtimes[$key]['LogTime']['end_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['end_datetime']));
                if($projFil == 'all' && in_array('prj_name', $checkedFields)){
                    $logtimes[$key]['LogTime']['prj_name'] = $this->Format->getProjectName($logtimes[$key]['LogTime']['project_id']);
                }
            }
        }
				if($projFil != 'all'){					
					foreach($checkedFields as $chk => $chv){
						if($chv == 'prj_name'){
							unset($checkedFields[$chk]);
						}
					}
				}
        $content = '';
        if (in_array('date', $checkedFields)) {
            $content.= 'Date';
        }
        if (in_array('usr_name', $checkedFields)) {
            $content == '' ? $content.= 'Name' : $content.= ',Name';
        }
        if (in_array('prj_name', $checkedFields)) {
            $content == '' ? $content.= 'Project Name' : $content.= ',Project Name';
        }
        if (in_array('task_no', $checkedFields)) {
            $content == '' ? $content.= 'Task#' : $content.= ',Task#';
        }
        if (in_array('task_title', $checkedFields)) {
            $content == '' ? $content.= 'Task Title' : $content.= ',Task Title';
        }
        if (in_array('description', $checkedFields)) {
            $content == '' ? $content.= 'Note' : $content.= ',Note';
        }
        if (in_array('start', $checkedFields)) {
            $content == '' ? $content.= 'Start' : $content.= ',Start';
        }
        if (in_array('end', $checkedFields)) {
            $content == '' ? $content.= 'End' : $content.= ',End';
        }
        if (in_array('break', $checkedFields)) {
            $content == '' ? $content.= 'Break(hours)' : $content.= ',Break(hours)';
        }
        if (in_array('billable', $checkedFields)) {
            $content == '' ? $content.= 'Billable' : $content.= ',Billable';
        }
        if (in_array('hours', $checkedFields)) {
            $content == '' ? $content.= 'Logged Hours' : $content.= ',Logged Hours';
        }
        $content .= "\n";
        $total_billable_hours = 0;
        $total_non_billable_hours = 0;
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {
                $date = date('Y-m-d', strtotime($val["LogTime"]['start_datetime']));
                if (in_array('date', $checkedFields)) {
                    $content .= '"' . $this->Format->dateFormatReverse($date) . '",';
                }
                if (in_array('usr_name', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val[0]['user_name'])) . '",';
                }
                //if (in_array('usr_name', $checkedFields)) {
                if (in_array('prj_name', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val['LogTime']['prj_name'])) . '",';
                }
                if (in_array('task_no', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val[0]['task_no'])) . '",';
                }
                if (in_array('task_title', $checkedFields)) {
                    $content .='"' . str_replace('"', '""', trim($val[0]['task_name'])) . '",';
                }
                if (in_array('description', $checkedFields)) {
                    $content .='"' . $this->Format->stripHtml(str_replace('"', '""', trim($val['LogTime']['description']))) . '",';
                }
                if (in_array('start', $checkedFields)) {
                    $content .='"' . $this->Format->format_24hr_to_12hr($val['LogTime']['start_time']) . '",';
                }
                if (in_array('end', $checkedFields)) {
                    $content .='"' . $this->Format->format_24hr_to_12hr($val['LogTime']['end_time']) . '",';
                }
                if (in_array('break', $checkedFields)) {
                    $content .='"' . round(($val['LogTime']['break_time'] / 3600), 2) . '",';
                }
                if (in_array('billable', $checkedFields)) {
                    $content .='"' . ($val['LogTime']['is_billable'] == '1' ? 'Yes' : 'No') . '",';
                }
                if (in_array('hours', $checkedFields)) {
                    $content .='"' . round(($val['LogTime']['total_hours'] / 3600), 2) . '",';
                }
                $content = trim($content, ',');
                $content .="\n";
                ($val['LogTime']['is_billable'] == '1' ? $total_billable_hours+= $val['LogTime']['total_hours'] : $total_non_billable_hours+= $val['LogTime']['total_hours']);
            }
        }
        $_curdt =  $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $_fmt = ($SES_TIME_FORMAT ==12)?'m/d/Y g:i a':'m/d/Y H:i';
       // $content .= "\n" . "Export Date," . $this->Format->dateFormatReverse(GMT_DATETIME);
        $content .= "\n" . "Export Date," . date($_fmt,strtotime($_curdt));
        $content .= "\n" . "Total," . $caseCount . " records";
        $content .= "\n" . "Total Billable Hours," . $this->Format->format_time_hr_min($total_billable_hours) . " ";
        $content .= "\n" . "Total Non-Billable Hours," . $this->Format->format_time_hr_min($total_non_billable_hours) . " ";
        $content .= "\n" . "Total Hours," . $this->Format->format_time_hr_min($total_billable_hours + $total_non_billable_hours) . " ";
        #echo $content;exit;
        if (!is_dir(LOGTIME_CSV_PATH)) {
            @mkdir(LOGTIME_CSV_PATH, 0777, true);
        }

        $name = $projFil;
        if (trim($name) != '' && strlen($name) > 25) {
            $name = substr($name, 0, 24) . "_" . date('m-d-Y', strtotime(GMT_DATE)) . "_timelog.csv";
        } else {
            $name .= (trim($name) != '' ? "_" : '') . date('m-d-Y', strtotime(GMT_DATE)) . "_timelog.csv";
        }
        $download_name = date('m-d-Y', strtotime(GMT_DATE)) . "_timelog.csv";

        $file_path = LOGTIME_CSV_PATH . $name;
        $fp = @fopen($file_path, 'w+');
        fwrite($fp, $content);
        fclose($fp);

        $this->response->file($file_path, array('download' => true, 'name' => urlencode($download_name)));
        return $this->response;
    }

     function download_pdf_timelog(){
        $data = $this->params->query;
        $from_date = trim($data['strddt']);
        $to_date = trim($data['enddt']);
        $user_id = trim($data['usrid'], ',');
        $date = trim($data['date']);
        $checkedFields  = trim($data['checkedFields']);

        $prjid = $GLOBALS['getallproj'][0]['Project']['id'];
        $prjuniqueid = $GLOBALS['getallproj'][0]['Project']['uniq_id'];

        $projFil = trim($data['projuniqid']);

       $filename = WWW_ROOT . DS.'timesheetpdf'.DS.'pdf'.DS.'project_timelog_' .$projFil.'.pdf';
            $layout = 'landscape';
            $orientation = " -O landscape "; //"  --javascript-delay 10000 ";
            if(file_exists($filename)) {
                @unlink($filename);
            }
       // $wkhtml = "/usr/bin/wkhtmltox/bin/wkhtmltopdf"; //PDF_LIB_PATH
        $parameters = 'projuniqid=' .$projFil . '&usrid=' . $user_id . '&date=' . $date . '&strddt=' . $from_date . '&enddt=' . $to_date . '&checkedFields=' . $checkedFields.'&SES_ID='.SES_ID.'&SES_COMP='.SES_COMP.'&SES_TYPE='.SES_TYPE.'&Gproject='.$prjid.'&Gproject_uid='.$prjuniqueid;
        #print HTTP_ROOT_INVOICE . 'log_times/export_pdf_timelog/?'.$parameters;exit;
        $wkhtml = PDF_LIB_PATH; //PDF_LIB_PATH ;
        exec('"'.$wkhtml.'"' . $orientation . ' "' . HTTP_ROOT_INVOICE . 'log_times/export_pdf_timelog/?'.$parameters.'" ' .' ' . $filename);
           
        if(file_exists($filename)) {
               header("Content-Type: application/octet-stream");
                $file = $filename;
                header("Content-Disposition: attachment; filename=" . urlencode('project_timelog_'.$projFil.'.pdf'));   
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");
                header("Content-Description: File Transfer");            
                header("Content-Length: " . filesize($file));
                flush();
                $fp = fopen($file, "r");
                while (!feof($fp))
                {
                    echo fread($fp, 65536);
                    flush(); 
                } 
                fclose($fp); 
                @unlink($filename);
        }else{
            die('Link Expired!!');
        } 
     }

     function export_pdf_timelog() {
        $this->layout = "ajax";
        $this->loadModel('Easycase');
        $this->loadModel('LogTime');
        $this->loadModel('Project');
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        $data = $this->params->query;
        $from_date = trim($data['strddt']);
        $to_date = trim($data['enddt']);
        $user_id = trim($data['usrid'], ',');
        $date = trim($data['date']);
        $checkedFields = explode(',', $data['checkedFields']);


        $prjid = trim($data['Gproject']);
        $prjuniqueid =  trim($data['Gproject_uid']);

        $projFil = trim($data['projuniqid']);
        $usid = '';
        $st_dt = '';
        $where = '';

        $SES_COMP = trim($data['SES_COMP']);
        $SES_TYPE = trim($data['SES_TYPE']);
        $SES_ID   = trim($data['SES_ID']);
        $this->loadModel('User');
        $this->loadModel('Timezone');
        $usr = $this->User->find('first', array('conditions' => array('User.id' => $SES_ID)));

        $SES_TIMEZONE = $usr['User']['timezone_id'];
        $SES_TIME_FORMAT =  $usr['User']['time_format'];

        $timezn = $this->Timezone->find('first', array('conditions' => array('Timezone.id' => $SES_TIMEZONE), 'fields' => array('Timezone.gmt_offset', 'Timezone.dst_offset', 'Timezone.code')));

        $TZ_GMT = $timezn['Timezone']['gmt_offset'];
        
        if($usr['User']['is_dst']){
            $TZ_DST = $usr['User']['is_dst'];
        }else{
            $TZ_DST =  $timezn['Timezone']['dst_offset'];
        }

        $TZ_CODE = $timezn['Timezone']['code'];

        $GMT_DATETIME = gmdate('Y-m-d H:i:s');

        /* project details */

        if ($projFil != '' &&  $projFil != 'all') {
            $params = array(
                'conditions' => array('Project.uniq_id' => $projFil, 'Project.isactive' => 1, 'Project.company_id' => $SES_COMP),
                'fields' => array('Project.id'));
            $this->Project->recursive = -1;
            $projArr = $this->Project->find('first', $params);
            $project_id = $projArr['Project']['id'];
        } else {
            $project_id = $prjid;
            if($projFil ==''){
                $projFil = $prjuniqueid;
            }
        }
        $curDateTime = $this->Tmzone->GetDateTime($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, $GMT_DATETIME, "datetime");
        if ($user_id) {
            $usrid = $user_id;
            $where .= " AND `LogTime`.`user_id` IN (" . $usrid . ")";
            //$usid = " AND user_id = '" . $usrid . "'";
            //$count_usid = " AND LogTime.user_id = '" . $usrid . "'";
        }

        if ($date && $date != '' && $date != 'alldates') {
            $filter = $date;
            $dates = $this->Format->date_filter($filter, $curDateTime);
            $data = array_merge($data, $dates);
            //print_r($data);exit;
            if ($data['strddt'] != '') {
            $from_date = $this->Tmzone->convert_to_utc($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, trim($data['strddt']), "datetime");
            }
            if($data['enddt'] != ''){
            $to_date = $this->Tmzone->convert_to_utc($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, trim($data['enddt']), "datetime");
            $to_date = date('Y-m-d H:i:s', strtotime($to_date . '+1 day'));
            }            
        } else if ($from_date != '' || $to_date != '') {
            if ($from_date != '') {
                $from_date = $this->Tmzone->convert_to_utc($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, date('Y-m-d', strtotime(trim($data['strddt']))), "datetime");
            }
            if ($to_date != '') {
                $to_date = $this->Tmzone->convert_to_utc($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, date('Y-m-d', strtotime(trim($data['enddt']))), "datetime");
                $to_date = date('Y-m-d H:i:s', strtotime($to_date . '+1 days'));
            }
        }
        if ($date && $date != '' && ($date == 'today' || $date == 'yesterday')) {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "' AND `LogTime`.`start_datetime` < '" . date('Y-m-d H:i:s', strtotime($from_date . '+1 day')) . "'";
            $st_dt = " AND `start_datetime` >= '" . $from_date . "' AND `start_datetime` < '" . date('Y-m-d H:i:s', strtotime($from_date . '+1 day')) . "'";            
        } elseif ($from_date != '' && $to_date != '') {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "' AND `LogTime`.`start_datetime` < '" . $to_date . "'";
            $st_dt = " AND `start_datetime` >= '" . $from_date . "' AND `start_datetime` < '" . $to_date . "'";
            /* $where .= " AND `LogTime`.`start_datetime` BETWEEN '" . date('Y-m-d', strtotime($from_date)) . "' AND '" . date('Y-m-d', strtotime($to_date)) . "'";
              $st_dt = " AND DATE(start_datetime) BETWEEN '" . date('Y-m-d', strtotime($from_date)) . "' AND '" . date('Y-m-d', strtotime($to_date)) . "'"; */
        } elseif ($from_date != '') {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $from_date . "'";
            $st_dt = " AND start_datetime >= '" . $from_date . "'";
        } elseif ($to_date != '') {
            $where .= " AND `LogTime`.`start_datetime` < '" . $to_date . "'";
            $st_dt = " AND start_datetime < '" . $to_date . "'";
        }





        $options = array();
        $options['fields'] = array("LogTime.*", "DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1",
            "(SELECT CONCAT_WS(' ',User.name,User.last_name) FROM users AS `User` WHERE `User`.id=LogTime.user_id) AS user_name",
            "(SELECT title FROM easycases AS `Easycase` WHERE Easycase.id=LogTime.task_id LIMIT 1) AS task_name",
            "(SELECT case_no FROM easycases AS `Easycase` WHERE Easycase.id=LogTime.task_id LIMIT 1) AS task_no");
        if ($projFil == 'all') {
             $options['joins'] = array(array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'LEFT', 'conditions' => array('Easycase.id=LogTime.task_id', 'LogTime.project_id=Easycase.project_id')), array('table' => 'projects', 'alias' => 'Project', 'type' => 'LEFT', 'conditions' => array('Project.id=LogTime.project_id','Project.isactive=1')));
            $options['conditions'] = array("Easycase.isactive" => 1,'Project.isactive'=>1,'Project.company_id'=>$SES_COMP ,trim(trim($where), 'AND'));
            if ($SES_TYPE == 3 && $SES_ID != 13902) {
                $options['conditions'] = array("Easycase.isactive" => 1, "LogTime.user_id" => $SES_ID, trim(trim($where), 'AND'));
            }
        } else {
            $options['joins'] = array(array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'LEFT', 'conditions' => array('Easycase.id=LogTime.task_id', 'LogTime.project_id=Easycase.project_id')));
            $options['conditions'] = array("LogTime.project_id" => $project_id, "Easycase.isactive" => 1, trim(trim($where), 'AND'));
            if ($SES_TYPE == 3 && $SES_ID != 13902) {
                $options['conditions'] = array("LogTime.project_id" => $project_id, "Easycase.isactive" => 1, "LogTime.user_id" => $SES_ID, trim(trim($where), 'AND'));
            }
        }
        $options['order'] = 'start_datetime DESC';
        $logtimes = $this->LogTime->find('all', $options);
        $caseCount = $this->LogTime->find('count', $options);
        $total_billable_hours = $total_non_billable_hours = 0;
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {
                $logtimes[$key]["LogTime"]['start_datetime'] = $this->Tmzone->GetDateTime($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, $logtimes[$key]["LogTime"]['start_datetime'], "datetime");
                $logtimes[$key]["LogTime"]['end_datetime'] = $this->Tmzone->GetDateTime($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, $logtimes[$key]["LogTime"]['end_datetime'], "datetime");
                $logtimes[$key][0]['start_datetime_v1'] = date('M d Y H:i:s', strtotime($logtimes[$key]["LogTime"]['start_datetime']));

                if( $logtimes[$key]["LogTime"]['timesheet_flag']){
                    $logtimes[$key]['LogTime']['start_time'] = '00:00:00';
                     $logtimes[$key]['LogTime']['end_time'] = '00:00:00';
                }else{
                   $dtformat = ($SES_TIME_FORMAT == 12)?'g:i a':'H:i';
                    $logtimes[$key]['LogTime']['start_time'] = date($dtformat, strtotime($logtimes[$key]['LogTime']['start_datetime']));
                    $logtimes[$key]['LogTime']['end_time'] = date($dtformat, strtotime($logtimes[$key]['LogTime']['end_datetime']));
                }
                if($projFil == 'all'){  
                $this->Project->recursive = -1;
                $pjArr = $this->Project->find('first', array('conditions' => array('Project.id' => $logtimes[$key]['LogTime']['project_id'], 'Project.isactive' => 1, 'Project.company_id' => $SES_COMP), 'fields' => array('Project.name')));
                    $logtimes[$key]['LogTime']['prj_name'] = $pjArr['Project']['name'];
                }

                  ($val['LogTime']['is_billable'] == '1' ? $total_billable_hours+= $val['LogTime']['total_hours'] : $total_non_billable_hours+= $val['LogTime']['total_hours']);

            }
        }
        //print_r($logtimes);
        $this->set('caseDetail',$logtimes);
        $this->set('checkedFields',$checkedFields);
        $this->set('projFil',$projFil);
        $this->set('caseCount',$caseCount);
        $this->set('total_non_billable_hours',$total_non_billable_hours);
        $this->set('total_billable_hours',$total_billable_hours);
        $this->set(compact('SES_TIME_FORMAT','SES_TIMEZONE', 'TZ_GMT', 'TZ_DST', 'TZ_CODE'));
        
     }


    function saveTimer() {
        $data = $this->request->data['params'];
        $data1 = [];
        $data1['is_from_timer'] = $data['is_from_timer'];
        $data1['project_id'] = $data['project_id'];
        $data1['task_id'] = $data['task_id'];
        $data1['description'] = $data['description'];
        $data1['task_date'][0] = date('Y-m-d', $data['start_time'] / 1000);
        $start_time = date('Y-m-d H:ia', $data['start_time'] / 1000);
        $start_time = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $start_time, "datetime");
        $start_time = explode(' ', $start_time);
        $data1['start_time'][0] =(SES_TIME_FORMAT == 12)?$this->Tmzone->convert12hourformat($start_time[1]):$start_time[1];
        //Check the end time more then 23 hr and 59 mins
        if ($data['totalduration'] > 86340000) {
            $data['end_time'] = $data['start_time'] + 86340000;
        }
		if($data['totalduration'] < 50000){
			$data['end_time'] = $data['start_time']+59665;
			$data['totalduration'] = 59673;
		}
        $end_time = date('Y-m-d H:ia', $data['end_time'] / 1000);
        $end_time = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $end_time, "datetime");
        $end_time = explode(' ', $end_time);
        $data1['end_time'][0] = (SES_TIME_FORMAT == 12)?$this->Tmzone->convert12hourformat($end_time[1]):$end_time[1];
        $data1['totalduration'][0] = (int) ($data['totalduration'] / 1000);
        $duration = (int) (($data['end_time'] - $data['start_time']) / 1000);
        $data1['totalbreak'][0] = (int) (($duration - $data1['totalduration'][0]) / 60);
        $data1['user_id'][0] = SES_ID;
        $data1['chked_ids'][0] = $data['chked_ids'];
        $Easycases = ClassRegistry::init('EasycasesController');
        $result = $Easycases->add_tasklog($data1);
        echo $result;
        exit;
    }

    function getlastLog($projUniq = '', $taskid = '') {
        $this->layout = 'ajax';
        $proj_uniq_id = !empty($this->data['projUniq']) ? $this->data['projUniq'] : $projUniq;
        $taskid = !empty($this->data['taskid']) ? $this->data['taskid'] : $taskid;
        if ($proj_uniq_id != 'all') {
            $this->loadModel('LogTime');
            $this->LogTime->bindModel(array('belongsTo' => array('Project')));
            $cond = array('Project.uniq_id' => $proj_uniq_id, 'Project.isactive' => 1, 'LogTime.created >' => date('Y-m-d 00:00:00'));
            $cond1 = array('Project.uniq_id' => $proj_uniq_id, 'Project.isactive' => 1);
            if (!empty($taskid)) {
                $cond['LogTime.task_id'] = $taskid;
                $cond1['LogTime.task_id'] = $taskid;
            }
            if (SES_TYPE == 3) {
                $cond['LogTime.user_id'] = SES_ID;
                $cond1['LogTime.user_id'] = SES_ID;
            }
            $projArr = $this->LogTime->find('all', array('conditions' => $cond, 'fields' => array('LogTime.hours', 'LogTime.created', 'LogTime.total_hours'), 'order' => array('LogTime.created DESC')));
            $this->LogTime->create();
            $this->LogTime->bindModel(array('belongsTo' => array('Project')));
            $latedittime = $this->LogTime->find('first', array('conditions' => $cond1, 'fields' => array('LogTime.created'), 'order' => array('LogTime.created DESC')));
            $total_hour = 0;
            $total_hour_format = '0 hr(s)';
            $created_on = '';
            if (count($projArr) > 0) {
                foreach ($projArr as $k => $v) {
                    $total_hour += intval($v['LogTime']['total_hours']);
                }
            }
            $total_hour_format = floor($total_hour / 3600) . ' hr(s) ';
            $mins = round(($total_hour % 3600) / 60);
            if ($mins > 0) {
                $total_hour_format.= $mins . " min(s) ";
            }
            $view = new View($this);
            $dt = $view->loadHelper('Datetime');
            $tz = $view->loadHelper('Tmzone');
            if (isset($latedittime['LogTime']['created'])) {
                $curDateTz = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                $locDT1 = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $latedittime['LogTime']['created'], "datetime");
                $created_on = $dt->facebook_style_date_time($locDT1, $curDateTz);
                if (!empty($projUniq)) {
                    $log_time['logged'] = $total_hour_format;
                    $log_time['last_entry'] = $created_on;
                    return $log_time;
//                    return "Logged: <b>{$total_hour_format} today</b>. Last entry: <b>{$created_on}</b>";
                } else {
                echo __("Logged").": <b>{$total_hour_format} ".__('today')."</b>. ".__('Last entry').": <b>{$created_on}</b>";
                }
            } else {
                if (!empty($projUniq)) {
                    $log_time['logged'] = $total_hour_format;
                    $log_time['last_entry'] = $created_on;
                    return $log_time;
//                    return "Logged: <b>{$total_hour_format} today</b>. Last entry: <b>none</b>";
            } else {
                echo __("Logged").": <b>{$total_hour_format} ".__('today')."</b>. ".__('Last entry').": <b>".__('none')."</b>";
            }
            }
        }
        if (!empty($projUniq)) {
            return true;
        } else {
            exit;
        }
    }

    function showChartView() {
        $this->layout = 'ajax';
        $this->loadModel('Easycase');
        $this->loadModel('LogTime');
        $this->loadModel('Project');
        /* Set the date */
        if (isset($this->data['currentdate']) && !empty($this->data['currentdate'])) {
            $date = strtotime($this->data['currentdate']);
        } else {
            $date = strtotime(date("Y-m-d"));
        }
         $fdate = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-01 00:00:00',$date), "datetime");
         $ldate = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, date('Y-m-t 23:59:59',$date), "datetime");
         
        $angularArr=[];
//        $day = date('d', $date);
//        $month = date('m', $date);
//        $year = date('Y', $date);
//        $nextMonth = date('Y-m-d', strtotime('+1 month', $date));
//        $prevMonth = date('Y-m-d', strtotime('-1 month', $date));
//        $firstDay = mktime(0, 0, 0, $month, 1, $year);
//        $title = strftime('%B', $firstDay);
//        $dayOfWeek = date('D', $firstDay);
//        $daysInMonth = cal_days_in_month(0, $month, $year);
//        $this->set(compact('day', 'month', 'year', 'title', 'daysInMonth', 'nextMonth', 'prevMonth'));
        /*         * *End *** */

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
                $this->loadModel('Project');
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
        $page_limit = 30;
        /* current page */
        $casePage = $this->params->data['casePage'] > 0 ? $this->params->data['casePage'] : 1; // Pagination
        $page = $casePage;
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;

        /* project details */
        $this->Project->recursive = -1;
        $projArr = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $projFil, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
        $project_id = $projArr['Project']['id'];

        $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        if (isset($this->data['currentdate']) && !empty($this->data['currentdate'])) {
//            $usrCndtn = " USERS.id IS NOT NULL AND LogTime.start_datetime >= (LAST_DAY('" . $this->data['currentdate'] . "') + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND LogTime.start_datetime <  (LAST_DAY('" . $this->data['currentdate'] . "') + INTERVAL 1 DAY) AND ";
//            $tskCndtn = " Easycase.id IS NOT NULL AND LogTime.start_datetime >= (LAST_DAY('" . $this->data['currentdate'] . "') + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND LogTime.start_datetime <  (LAST_DAY('" . $this->data['currentdate'] . "') + INTERVAL 1 DAY) AND ";
            $usrCndtn = " USERS.id IS NOT NULL AND LogTime.start_datetime >= '".$fdate."' AND LogTime.start_datetime <=  '".$ldate."' AND ";
            $tskCndtn = " Easycase.id IS NOT NULL AND LogTime.start_datetime >= '".$fdate."' AND LogTime.start_datetime <=  '".$ldate."' AND ";
        } else {
//            $usrCndtn = " USERS.id IS NOT NULL AND LogTime.start_datetime >= (LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND LogTime.start_datetime <  (LAST_DAY(CURDATE()) + INTERVAL 1 DAY) AND ";
//            $tskCndtn = " Easycase.id IS NOT NULL AND LogTime.start_datetime >= (LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND LogTime.start_datetime <  (LAST_DAY(CURDATE()) + INTERVAL 1 DAY) AND ";
            $usrCndtn = " USERS.id IS NOT NULL AND LogTime.start_datetime >= '".$fdate."' AND LogTime.start_datetime <=  '".$ldate."' AND ";
            $tskCndtn = " Easycase.id IS NOT NULL AND LogTime.start_datetime >= '".$fdate."' AND LogTime.start_datetime <=  '".$ldate."' AND ";
        }
        if (SES_TYPE == 3 && !$this->Format->isAllowed('View All Timelog',$roleAccess)) {
            $usrCndtn1 = " AND  `LogTime`.user_id= " . SES_ID . " ";
        } else {
            $usrCndtn1 = '';
        }
        if (isset($this->data['task_id']) && $this->data['task_id'] != '') {
            $tskCndtn = "`LogTime`.task_id= " . $this->data['task_id'] . " AND LogTime.start_datetime >= (LAST_DAY(CURDATE()) + INTERVAL 1 DAY - INTERVAL 1 MONTH) AND LogTime.start_datetime <  (LAST_DAY(CURDATE()) + INTERVAL 1 DAY) AND ";
            $curCaseId = $this->data['task_id'];
            $taskUid = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $curCaseId), 'fields' => array('Easycase.uniq_id', 'Easycase.title', 'Easycase.isactive')));
            $caseTitleRep = $taskUid['Easycase']['title'];
            $isactive = $taskUid['Easycase']['isactive'];
            $prjDtls = $this->Project->find('first', array('conditions' => array('Project.uniq_id' => $projFil), 'fields' => array('Project.name')));
        }
        /** Mysql check timezone **/
        $this->loadModel('TimezoneName');
        $tmz=$this->TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
        $tmz=  str_replace(array("GMT","(",")"), "", $tmz);
        $gmt_val = "+00:00";
        /* End*/
//        $logsql = "SELECT SQL_CALC_FOUND_ROWS DAYS.*,TASK_TYPE.* FROM (SELECT DATE_FORMAT(LogTime.start_datetime,'%m %d %Y') AS start_datetime_v1,LogTime.start_datetime, "
//                . " COUNT(LogTime.total_hours) AS agrigate_hours "
//                . "FROM `log_times` AS `LogTime` "
//                . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
//                . "WHERE ". $usrCndtn ." " . $tskCndtn . "`LogTime`.`project_id`='$project_id' AND Easycase.isactive=1 $where "
//                . " GROUP BY  start_datetime_v1 ORDER BY LogTime.start_datetime DESC LIMIT $limit1, $limit2 ) AS DAYS "
//                . " LEFT JOIN "
//                . "(SELECT DATE_FORMAT(LogTime.start_datetime,'%m %d %Y') AS start_datetime_v2, "
//                . " COUNT(LogTime.total_hours) AS agrigate_hours , TYPES.name, TYPES.short_name "
//                . "FROM `log_times` AS `LogTime` "
//                . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
//                . "LEFT JOIN types as TYPES ON Easycase.type_id=TYPES.id "
//                . "WHERE ". $usrCndtn ." " . $tskCndtn . "`LogTime`.`project_id`='$project_id' AND Easycase.isactive=1 $where "
//                . "GROUP BY Easycase.type_id,start_datetime_v2 ) AS TASK_TYPE ON (DAYS.start_datetime_v1=TASK_TYPE.start_datetime_v2)";
//		#echo $logsql;
       $logsql = "SELECT SQL_CALC_FOUND_ROWS DAYS.*,TASK_TYPE.*,TASKS.* FROM "
                . "(SELECT DATE_FORMAT(CONVERT_TZ(LogTime.start_datetime,'$gmt_val','$tmz'),'%m %d %Y') AS start_datetime_v1,LogTime.start_datetime,LogTime.log_id,Easycase.title, "
                . "SUM(LogTime.total_hours) AS agrigate_hours "
                . "FROM `log_times` AS `LogTime` "
                . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                . "WHERE " . $tskCndtn . "`LogTime`.`project_id`='{$project_id}' AND Easycase.isactive=1 $usrCndtn1 $where "
                . "GROUP BY  start_datetime_v1 ORDER BY LogTime.start_datetime DESC ) AS DAYS "
                . "LEFT JOIN "
                . "(SELECT DATE_FORMAT(CONVERT_TZ(LogTime.start_datetime,'$gmt_val','$tmz'),'%m %d %Y') AS start_datetime_v2, "
                . "SUM(LogTime.total_hours) AS agrigate_hours ,USERS.name,USERS.email,USERS.photo ,LogTime.user_id "//TYPES.name, TYPES.short_name
                . "FROM `log_times` AS `LogTime` "
                //."LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                //."LEFT JOIN types as TYPES ON Easycase.type_id=TYPES.id "
                . "LEFT JOIN users as USERS ON LogTime.user_id=USERS.id "
                . "WHERE " . $usrCndtn . "`LogTime`.`project_id`='{$project_id}' $usrCndtn1 $where "
                . "GROUP BY LogTime.user_id,start_datetime_v2 ORDER BY agrigate_hours DESC ) AS TASK_TYPE ON (DAYS.start_datetime_v1=TASK_TYPE.start_datetime_v2)"
                . "LEFT JOIN "
                . "(SELECT DATE_FORMAT(CONVERT_TZ(LogTime.start_datetime,'$gmt_val','$tmz'),'%m %d %Y') AS start_datetime_v3,"
                . "SUM(LogTime.total_hours) AS agrigate_hours ,Easycase.title,Easycase.case_no ,LogTime.task_id ,"
                . "GROUP_CONCAT(DISTINCT LogTime.user_id) as userids "
                . "FROM `log_times` AS `LogTime` "
                . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                . "WHERE " . $tskCndtn . "`LogTime`.`project_id`='{$project_id}' AND Easycase.isactive=1 $usrCndtn1 $where "
                . "GROUP BY  LogTime.task_id,start_datetime_v3 ORDER BY agrigate_hours DESC) AS TASKS ON  (DAYS.start_datetime_v1=TASKS.start_datetime_v3) ORDER BY TASKS.agrigate_hours DESC ";

       //print $logsql;exit;
        $logtimes = $this->LogTime->query($logsql);
        $dates = array_unique(Hash::extract($logtimes, '{n}.DAYS.start_datetime_v1'));
        $results = [];
        $i = 0;
        $this->loadModel('User');
        foreach ($dates as $key => $val) {
            foreach ($logtimes as $k => $v) {
                $v['DAYS']['start_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,$v['DAYS']['start_datetime'],'datetime');
                $i = date('d', strtotime($v['DAYS']['start_datetime']));                
                if ($v['DAYS']['start_datetime_v1'] == $val) {
                    $results[$i]['DAYS'] = $v['DAYS'];
                }
                if ($v['TASK_TYPE']['start_datetime_v2'] == $val) {
                    $results[$i]['TASK_TYPE'][$v['TASK_TYPE']['user_id']] = $v['TASK_TYPE'];
                    $results[$i]['TASK_TYPE'][$v['TASK_TYPE']['user_id']]['random_bgclr'] = $this->User->getProfileBgColr($v['TASK_TYPE']['user_id']);
                }
                if ($v['TASKS']['start_datetime_v3'] == $val) {
                    $results[$i]['TASKS'][$v['TASKS']['task_id']] = $v['TASKS'];
                }
            }
        }
        /** get the max hours ****** */
        $max = 0;
        foreach ($results as $k => $v) {
            $max = max($max, $v['DAYS']['agrigate_hours']);
        }
        if(isset($this->data['angular']) && !empty($this->data['angular'])){
            $angularArr['max']=$max;
        }else{
            $this->set('max', $max);
        }
        /*         * *End** */
        /* set the json value for creating the chart** */
        $arr = array();
        $chart = array();
        foreach ($results as $k => $v) {
            $v['DAYS']['title'] = h($v['DAYS']['title'], true, 'UTF-8');
            $arr[$k]['name'] =$v['DAYS']['start_datetime_v1'];
            $arr[$k]['colorByPoint'] = 'true';
            $arr[$k]['agrigate_hours'] = round((($v['DAYS']['agrigate_hours'] / $max) * 100) / 2); // This is calculate the size of the piechnart max height is 50px so after calculate the % value devide by 2 
            $arr[$k]['agrigate_hours'] = ($arr[$k]['agrigate_hours'] < 20) ? 20 : $arr[$k]['agrigate_hours']; // Set the minimum size as 10 of the piechnart
            $arr1 = array();
            $j = 0;
            foreach ($v['TASK_TYPE'] as $k1 => $v1) {
                $arr1[$j]['name'] = $v1['name'];
                $arr1[$j]['y'] = (floatval($v1['agrigate_hours']) * 100) / floatval($v['DAYS']['agrigate_hours']);
                $arr1[$j]['hours'] = $this->Format->seconds2human($v1['agrigate_hours']);
                $j++;
            }
            $arr[$k]['data'] = $arr1;
            $chart[$k]['start_datetime'] = $v['DAYS']['start_datetime_v1'];
            $chart[$k]['actual_hours'] = $this->Format->seconds2human($v['DAYS']['agrigate_hours']);
            $chart[$k]['users'] = $v['TASK_TYPE'];
            usort($v['TASKS'], function($a, $b) { 
                if((int)$a['agrigate_hours'] == (int)$b['agrigate_hours']) {
                return 0;
                }
                return ((int)$a['agrigate_hours'] > (int)$b['agrigate_hours']) ? -1 : 1; 

            });
            $chart[$k]['tasks'] = $v['TASKS'];
            foreach ($v['TASKS'] as $tk => $tv) {
                $uids = explode(',', $tv['userids']);
                foreach ($uids as $uk => $uv) {
                    $dt =  date('Y-m-d',strtotime($v['DAYS']['start_datetime']));
                    $dt = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($dt." 00:00:00"), "datetime");
                    $u = $this->LogTime->find('all', array('fields' => array('SUM(LogTime.total_hours) as hrs'), 'conditions' => array('LogTime.task_id' => $tv['task_id'], 'LogTime.user_id' => $uv, 'start_datetime >=' => $dt,'start_datetime <=' => date('Y-m-d H:i:s',strtotime($dt.' +86390 seconds')))));
                    $chart[$k]['tasks'][$tk]['uid'][$uv] = $u[0][0]['hrs'];//$this->Format->seconds2fraction($u[0][0]['hrs']);
                }
                asort($chart[$k]['tasks'][$tk]['uid']);
                foreach($chart[$k]['tasks'][$tk]['uid'] as $ukey1 => $uval1){
                    $chart[$k]['tasks'][$tk]['uid'][$ukey1] = $this->Format->seconds2fraction($uval1);
                }
                $tv['userids']= implode(',',array_keys($chart[$k]['tasks'][$tk]['uid']));
				$chart[$k]['tasks'][$tk]['title'] = h($chart[$k]['tasks'][$tk]['title'], true, 'UTF-8');
                $chart[$k]['tasks'][$tk]['agrigate_hours'] = $this->Format->seconds2fraction($chart[$k]['tasks'][$tk]['agrigate_hours']);
            }
        }
         if(isset($this->data['angular']) && !empty($this->data['angular'])){
           $angularArr['datas']=$arr;
           $angularArr['chart']=$chart;
           print json_encode($angularArr);exit;
        }else{
            $this->set('datas', json_encode($arr));
            /* end* */
            $this->set('chart', $chart);
        }
    }
    	/**
     * Function to manage ajax call for time log
     */
    	function showAllProjects($data=null) {
            if(isset($data) && !empty($data)){
                $userid=SES_ID;
            }else{
            $userid=isset($this->data['user_id'])?$this->data['user_id']:SES_ID;
            }
                    $allprjs = $this->Project->getAllAngProjects($userid);
		if(empty($allprjs)){
			$jsonOuput = array();
		}else{
			$jsonOuput['Projects'] = $allprjs;
		}		
        if(isset($data) && !empty($data)){
            return $jsonOuput;
        }else{    
        echo json_encode($jsonOuput);exit;
    }
    }
    
    function getLastweekLog($data) {
        
        $usrCndtn = "";
        $tskCndtn = "";
        $where ='';
        $qrylog = '';
        
        $previous_week = strtotime("-1 week +1 day");
        $start_week = strtotime("last sunday midnight",$previous_week);
        $end_week = strtotime("next saturday",$start_week);

        $start_week = date("Y-m-d",$start_week);
        $end_week = date("Y-m-d",$end_week);
        
        $data['strddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $start_week. ' 00:00:00', "datetime");
        $data['enddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $end_week. ' 23:59:00', "datetime");
        
        
        $where .= " AND `LogTime`.`start_datetime` >= '" . $data['strddt'] . "' AND `LogTime`.`start_datetime` < '" . $data['enddt'] . "'";
        if (SES_TYPE == 3 && SES_ID != 13902) {
            $usrCndtn = " AND `LogTime`.user_id= " . SES_ID . " ";
        }
         if (isset($data['task_id']) && $data['task_id']) {
             $tskCndtn=" AND `LogTime`.task_id= ". $data['task_id'] . " ";
         }
         
        if (isset($data['usrid']) && !empty($data['usrid'])) {
               
        }else{
                $data['usrid'] = SES_ID;
        }
        if (isset($data['usrid']) && !empty($data['usrid'])) {
            $usrid = explode("-", $data['usrid']);
            foreach ($usrid as $uid) {
                if ($uid != '') {
                    $qrylog.=" `LogTime`.`user_id`=" . $uid . " OR ";                  
                }
            }
            $qrylog = substr($qrylog, 0, -3);
            $where.=" AND (" . $qrylog . ")";
        }
        
        $logsql = "SELECT SQL_CALC_FOUND_ROWS COUNT(LogTime.task_date) AS cnt,LogTime.task_date  FROM `log_times` AS `LogTime` "
                    . "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                    . "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 WHERE Project.isactive=1 AND Project.company_id=" . SES_COMP . " AND Easycase.isactive=1 " . $usrCndtn . " " . $tskCndtn . " $where GROUP BY LogTime.task_date";
         $logtimescnt = $this->LogTime->query($logsql);
         //return $logtimescnt[0][0]['cnt'];
         $formatedArray = array();
         if(count($logtimescnt) > 0){
            foreach($logtimescnt as $k=>$v){
                if($v['LogTime']['task_date'] != $start_week && $v['LogTime']['task_date'] != $end_week ){
                   $formatedArray[$k]['date'] =  $v['LogTime']['task_date'];  
                   $formatedArray[$k]['count'] = $v[0]['cnt'];   
                }
            }
         }
         return (count($formatedArray)==5)?1:0;
        
    }
    
    
	function getProjectTasks(){
		$this->layout = 'ajax';
                $this->loadModel('Project');
        $this->Project->recursive = -1;
        $cond = array('Easycase.project_id' => $this->data['project_id'], 'Easycase.isactive=1', 'istype=1');
        if (isset($this->data['q']) && !empty($this->data['q'])) {
            $cond[] = '(Easycase.title like "%' . trim($this->data['q']) . '%" OR Easycase.case_no like "%' . trim(str_replace('#', '', $this->data['q'])) . '%") AND Easycase.title != ""';
        } else {
            $cond[] = 'Easycase.title != ""';
        }
        if ($this->Auth->user('is_client') == 1) {
            $cond[] = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        $projid = $this->Project->find('first', array('fields' => array('Project.id','Project.status_group_id'), 'conditions' => array('Project.id' => $this->data['project_id'])));
        if($projid['Project']['status_group_id']){
            $CustomStatus = ClassRegistry::init('CustomStatus');
            $sts_cond = array('CustomStatus.status_group_id'=>$projid['Project']['status_group_id']);
            $CustomStatusArr =  $CustomStatus->find('first',array('conditions'=>$sts_cond,'order'=>array('CustomStatus.seq'=>'DESC')));
            $max_custom_status = $CustomStatusArr['CustomStatus']['id'];
            $custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
        } else {
            $max_custom_status = "3";
        }
		$roleInfo = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
		
        $roleAccess = $roleInfo['roleAccess'];
        if($projid['Project']['status_group_id']){
			if(!$this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){
				$cond[]= array('Easycase.custom_status_id !=' => $max_custom_status);	 
			}
		} else {
			if(!$this->Format->isAllowed('Time Entry On Closed Task',$roleAccess)){
				$cond[]= array('Easycase.legend !=' => $max_custom_status);	 
			}
		}
        $this->loadModel('Easycase');
		$tsktitles = $this->Easycase->find('all', array('fields' => array("Easycase.id", "Easycase.case_no","Easycase.title"), 'conditions' => $cond, 'limit' => 50, 'order' => 'Easycase.dt_created DESC'));
		/*if (isset($this->data['tid']) && !empty($this->data['tid'])) {
			$id_tsktitles = $this->Easycase->find('list', array('fields' => array("Easycase.case_no", "srttitle", "Easycase.id"), 'conditions' => array('Easycase.id' => $this->data['tid'])));
			$tsktitles = $id_tsktitles + $tsktitles;
			array_unique($tsktitles, SORT_REGULAR);
		}*/
		if(empty($tsktitles)){
			$jsonOuput = array();
		}else{
			$tsktitles = Hash::combine($tsktitles, '{n}.Easycase.id', '{n}.Easycase');
			$tsktitles = array_values($tsktitles);
                        $tsktitles = array_map(function($val) { return h($val); }, $tsktitles);
                        $tskCndtn_task = "";
                        if (SES_TYPE == 3 && SES_ID != 13902) {          
                            $tskCndtn_task = " AND `Easycase`.user_id= " . SES_ID . " ";
                        }else{
                            $tskCndtn_task = " AND `Easycase`.user_id= " . $this->data['usrid'] . " ";
                        }
                       
                        $data['strddt'] = date('Y-m-d',strtotime(' +1 day',strtotime($this->data['date']))). ' 00:00:00';
                        $data['enddt'] = date('Y-m-d',strtotime(' -1 day',strtotime($this->data['date']))). ' 23:59:00';

                        $data['strddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $data['strddt'], "datetime");
                        $data['enddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,  $data['enddt'], "datetime");
        
                        
                       $sql_task = "SELECT Easycase.case_no, Easycase.project_id FROM easycases AS Easycase LEFT JOIN projects AS Project ON Easycase.project_id = Project.id WHERE Project.company_id = '".SES_COMP."' AND Easycase.istype=2 AND Easycase.isactive=1 ".$tskCndtn_task." AND Easycase.dt_created <= '" . $data['strddt'] . "' AND Easycase.dt_created >= '" . $data['enddt'] . "' AND Project.id ='".$this->data['project_id']."' GROUP BY Easycase.project_id, Easycase.case_no ORDER BY Easycase.dt_created DESC";
                       $recentTasks = $this->Easycase->query($sql_task);
                       $taskarr = array();
                        if(count($recentTasks) > 0){
                            foreach($recentTasks as $k=>$v){
                                $get_rtasks = "SELECT Easycase.id,Easycase.case_no,Easycase.title FROM easycases AS `Easycase` WHERE  Easycase.case_no='".$v['Easycase']['case_no']."' AND Easycase.project_id ='".$v['Easycase']['project_id']."' AND Easycase.istype=1 AND Easycase.isactive=1 ";
                                $rtasks = $this->Easycase->query($get_rtasks); 
                                $taskarr[$rtasks[0]['Easycase']['id']] = $rtasks[0]['Easycase'];
                                foreach($tsktitles as $k=>$v){
                                    if($rtasks[0]['Easycase']['id'] == $v['id']){
                                        unset($tsktitles[$k]);
                                    }                                    
                                }
                            }
                        }
                        if(count($taskarr) > 0){
                            $tsktitles = array_merge(array_values($taskarr),$tsktitles);
                        }
			$jsonOuput['Tasks'] = $tsktitles;
		}
        echo json_encode($jsonOuput);exit;
	}
  	function saveTimesheet($data = Null) {
        $this->loadModel('Project');
        $this->loadModel('LogTime');
        $this->loadModel('Easycase');
        $this->loadModel('TimesheetApprovalDetail');
        $logdata = isset($data) && !empty($data) ? $data : $this->data;
              
        $start_time =  (isset($logdata['start_time']) && !empty($logdata['start_time']))?date("H:i:s", strtotime($logdata['start_time'])):'00:00:00';
        $end_time =  (isset($logdata['end_time']) && !empty($logdata['end_time']))?date("H:i:s", strtotime($logdata['end_time'])):'23:59:00';
        $start_time = $start_time;
        $end_time = ($end_time == "00:00:00")?'23:59:00':$end_time;
        $bArray = explode(':', $logdata['break_time']);
        $break_time = isset($bArray[0])?$bArray[0] * 3600:0;
        $break_time += isset($bArray[1])?$bArray[1] * 60:0;
		
        $log_id = (isset($this->data['log_id']) && trim($this->data['log_id']))?trim($this->data['log_id']):0;
        $mode = $log_id > 0 ? "edit" : "add";
        $slashes = $log_id > 0 ? '"' : '';
        $this->Project->recursive = -1;
        $project_id = $this->data['project_id'];
        $task_id = isset($logdata['task_id']) ? trim($logdata['task_id']) : intval($logdata['hidden_task_id']);

        $check_timelog_submitted_for_approval = $this->TimesheetApprovalDetail->checkSubmittedForApproval($logdata);
        if($check_timelog_submitted_for_approval){
                if(empty($check_timelog_submitted_for_approval['task_date'])){
                        echo json_encode(array('success' => 'err', 'message' => __('Not allowed to add timelog as timelog already submitted for approval.',true)));
                        exit;
                }
        }
        $allowed = $this->task_dependency($task_id);
        if ($allowed == 'No') {
            echo json_encode(array('success' => 'depend', 'message' => __('Dependant tasks are not closed.',true)));exit;
        }

        $users = $logdata['usrid'];
        $task_dates = $logdata['task_date'];

        $task_details = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $task_id), 'fields' => array('Easycase.*')));
        $easycase_uniq_id = $task_details['Easycase']['uniq_id'];
        $this->Format = $this->Components->load('Format');
        $caseuniqid = $this->Format->generateUniqNumber();
        $reply_type = isset($logdata['task_id']) ? 10 : 11;
		
		$curCaseId = $this->Easycase->insertCommentThreadCommon($task_details,'timelog',$reply_type);		
        //$this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', case_no = '" . $task_details['Easycase']['case_no'] . "', 	case_count=0, project_id='" . $task_details['Easycase']['project_id'] . "', user_id='" . SES_ID . "', updated_by=0, type_id='" . $task_details['Easycase']['type_id'] . "', priority='" . $task_details['Easycase']['priority'] . "', title='', message='', hours='0', assign_to='" . $task_details['Easycase']['assign_to'] . "', istype='2',format='2', status='" . $task_details['Easycase']['status'] . "', legend='" . $task_details['Easycase']['legend'] . "', isactive=1, dt_created='" . GMT_DATETIME . "',actual_dt_created='" . GMT_DATETIME . "',reply_type=" . $reply_type . "");
		
        $task_status = 0;
        $LogTime = array();
		$task_date = date('Y-m-d', strtotime($task_dates));
		if ($mode != 'edit') {
			$LogTime[0]['project_id'] = $project_id;
			$LogTime[0]['task_id'] = $task_id;
			$LogTime[0]['user_id'] = $users;
			$LogTime[0]['task_status'] = $task_status;
			$LogTime[0]['ip'] = $_SERVER['REMOTE_ADDR'];
			$LogTime[0]['timesheet_flag'] = 1;
		}
		
		$task_end_date = $task_date;
		if ($this->data['hrs']) {
			if((stristr($this->data['hrs'], ':'))){
				$t_hrs = explode(':',$this->data['hrs']);
				$total_hours = (int)$t_hrs[0] * 3600 + (int)$t_hrs[1] * 60;
			}else{
				$total_hours = (int)$this->data['hrs'] * 3600;
			}
		}		
//		$dt_start = '00:00:01';
//		$dt_end = '23:59:59';		

		$LogTime[0]['task_date'] = $slashes . $task_date . $slashes;

		/* here we are convering time to UTC as the date has been selected by user to in local time */
		#converted to UTC
		$this->Tmzone = $this->Components->load('Tmzone');
		$LogTime[0]['start_datetime'] = $slashes . $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_date . " " .  $start_time, "datetime") . $slashes;
		$LogTime[0]['end_datetime'] = $slashes . $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_end_date . " " .  $end_time, "datetime") . $slashes;
		
		#stored in sec
		$LogTime[0]['total_hours'] = $total_hours;
		$LogTime[0]['is_billable'] = $this->data['is_billable'];
		$LogTime[0]['description'] = $slashes . addslashes(trim($logdata['note'])) . $slashes;
		$LogTime[0]['start_time'] = ($start_time)?$start_time:'00:00:00';
		$LogTime[0]['end_time'] = ($end_time)?$end_time:'23:59:00';
		$LogTime[0]['break_time'] =($break_time)?$break_time:0;
                
                $LogTime[0]['start_time'] = $slashes .$LogTime[0]['start_time'].$slashes ;
		$LogTime[0]['end_time'] = $slashes .$LogTime[0]['end_time'].$slashes;
        $roleInfo = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
                
        $roleAccess = $roleInfo['roleAccess'];
        if(!$this->Format->isAllowed('Time Entry Greater Than Estimated Hour',$roleAccess)){
            $total_time_log_hours = $LogTime[0]['total_hours'] ;    
            $tsk_time = $this->LogTime->find('all',array("conditions"=>array("LogTime.task_id"=>$task_id),"fields"=>array("SUM(LogTime.total_hours) as log_hour")));
                if($tsk_time){
                        $total_time_log_hours = $total_time_log_hours + $tsk_time[0][0]['log_hour'] ;
                }
                if($total_time_log_hours > $task_details['Easycase']['estimated_hours']){
                        echo json_encode(array('success' => 'err', 'message' => __('Not allowed to add timelog more than task estimated hours.',true)));
                        exit;
                }
        }       
        if ($log_id > 0) {
            $this->LogTime->updateAll($LogTime[0], array('LogTime.log_id' => $log_id));
        } else {
            $this->LogTime->saveAll($LogTime);
			$log_id = $this->LogTime->getLastInsertID();
        }
        /* update easycases task dt_created */
        if (intval($task_id) > 0) {
            $this->Easycase->id = $task_id;
            $this->Easycase->save(array('dt_created' => date('Y-m-d H:i:s')));
        }
        /* update last project user visited */
        $this->ProjectUser->recursive = -1;
        $this->ProjectUser->updateAll(array('ProjectUser.dt_visited' => "'" . GMT_DATETIME . "'"), array('ProjectUser.project_id' => $project_id, 'ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP));
		
		$prj_details = $this->Project->find('first', array('conditions' => array('Project.id' => $project_id), 'fields' => array('Project.id','Project.name')));
		
		$resArr = null;
		$resArr['LogTime']['log_id'] = $log_id;
		$resArr['LogTime']['is_billable'] = $this->data['is_billable'];
		$resArr['LogTime']['description'] = trim($logdata['note']);
		$resArr['LogTime']['total_hours'] = $this->data['hrs'];
		$resArr['LogTime']['task_name'] = $task_details['Easycase']['title'];
		$resArr['LogTime']['project_name'] = $prj_details['Project']['name'];
                $resArr['LogTime']['task_no'] = $task_details['Easycase']['case_no'];
		$resArr['LogTime']['project_id'] = $project_id;
		$resArr['LogTime']['task_id'] = $task_details['Easycase']['id'];
		$resArr['LogTime']['start_time'] = ($logdata['start_time'])?$logdata['start_time']:'00:00:00';
		$resArr['LogTime']['end_time'] = ($logdata['end_time'])?$logdata['end_time']:'23:59:00';
		$resArr['LogTime']['break_time'] = ($logdata['break_time'])?$logdata['break_time']:'0';
		
		echo json_encode(array('success' => 'success', 'task_id' => $easycase_uniq_id, 'logs' => $resArr));exit;
    }


    function updateTimesheet($data = Null) {
        $this->loadModel('Project');
        $this->loadModel('LogTime');
        $this->loadModel('Easycase');
        $this->loadModel('ProjectUser');
        $logdata = isset($data) && !empty($data) ? $data : $this->data;	
        $start_time =  (isset($logdata['start_time']) && !empty($logdata['start_time']) && $logdata['start_time'] != '00:00:00')?date("H:i:s", strtotime($logdata['start_time'])):'00:00:01';
        $end_time =  (isset($logdata['end_time']) && !empty($logdata['end_time']) && $logdata['end_time'] != '00:00:00' )?date("H:i:s", strtotime($logdata['end_time'])):'23:59:59';
        $start_time = $start_time;
        $end_time = ($end_time == "00:00:00")?'23:59:00':$end_time;
        $bArray = explode(':', $logdata['break_time']);
        $break_time = isset($bArray[0])?$bArray[0] * 3600:0;
        $break_time += isset($bArray[1])?$bArray[1] * 60:0;
        
        $task_dates = $logdata['task_date'];
        $task_date = date('Y-m-d', strtotime($task_dates));
        $task_end_date = $task_date;
        
        $log_id = (trim($logdata['id']))?trim($logdata['id']):0;
		if($log_id){
			$log_details = $this->LogTime->find('first', array('conditions' => array('LogTime.log_id' => $log_id), 'fields' => array('LogTime.log_id','LogTime.project_id','LogTime.task_id','LogTime.total_hours','LogTime.is_billable','LogTime.description')));
			//Force update, can be managed if no changes made to the entry then don't update start and end time.
			$inHr  = $this->Format->format_second_hrmin($log_details['LogTime']['total_hours']);
			if($inHr  != $logdata['hours']){
				$start_time = '00:00:00';
				$end_time = '00:00:00';
				$break_time = 0;
				$log_details['LogTime']['timesheet_flag'] = 1;
			}
			$mode = "edit";
			$slashes = '"';
			$this->Project->recursive = -1;
			$project_id = $log_details['LogTime']['project_id'];
			
			$allowed = $this->task_dependency($log_details['LogTime']['task_id']);
			if ($allowed == 'No') {
				echo json_encode(array('success' => 'depend', 'message' => __('Dependant tasks are not closed.',true)));exit;
			}

			$task_details = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $log_details['LogTime']['task_id']), 'fields' => array('Easycase.*')));
			$easycase_uniq_id = $task_details['Easycase']['uniq_id'];
			$this->Format = $this->Components->load('Format');
			$caseuniqid = $this->Format->generateUniqNumber();
			$reply_type = isset($log_details['LogTime']['task_id']) ? 10 : 11;
			
			$curCaseId = $this->Easycase->insertCommentThreadCommon($task_details,'timelog',$reply_type);			
			//$this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', case_no = '" . $task_details['Easycase']['case_no'] . "', 	case_count=0, project_id='" . $task_details['Easycase']['project_id'] . "', user_id='" . SES_ID . "', updated_by=0, type_id='" . $task_details['Easycase']['type_id'] . "', priority='" . $task_details['Easycase']['priority'] . "', title='', message='', hours='0', assign_to='" . $task_details['Easycase']['assign_to'] . "', istype='2',format='2', status='" . $task_details['Easycase']['status'] . "', legend='" . $task_details['Easycase']['legend'] . "', isactive=1, dt_created='" . GMT_DATETIME . "',actual_dt_created='" . GMT_DATETIME . "',reply_type=" . $reply_type . "");		
			if ($logdata['hours']) {
				if((stristr($logdata['hours'], ':'))){
					$t_hrs = explode(':',$logdata['hours']);
					$total_hours = (int)$t_hrs[0] * 3600 + (int)$t_hrs[1] * 60;
				}else{
					$total_hours = (int)$logdata['hours'] * 3600;
				}
			}
			#stored in sec
			$log_details['LogTime']['total_hours'] = $total_hours;
			$log_details['LogTime']['is_billable'] = ($logdata['is_billable'])?$logdata['is_billable']:0;
			$log_details['LogTime']['description'] = $slashes . addslashes(trim($logdata['description'])) . $slashes;
			$log_details['LogTime']['start_time'] =($start_time)?$start_time:'00:00:00';
			$log_details['LogTime']['end_time'] = ($end_time)?$end_time:'23:59:00';
			$log_details['LogTime']['break_time'] = ($break_time)?$break_time:0;
                        $log_details['LogTime']['start_datetime'] = $slashes . $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_date . " " .  $start_time, "datetime") . $slashes;
                        $log_details['LogTime']['end_datetime'] = $slashes . $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $task_end_date . " " .  $end_time, "datetime") . $slashes;
                        $log_details['LogTime']['task_date'] = $slashes . $task_date . $slashes;
		
                        
                        $log_details['LogTime']['start_time'] = $slashes . $log_details['LogTime']['start_time'].$slashes;
                        $log_details['LogTime']['end_time'] = $slashes . $log_details['LogTime']['end_time'].$slashes;
			
			//pr($log_details['LogTime']);exit;
			$roleInfo = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
			
			$roleAccess = $roleInfo['roleAccess'];
			if(!$this->Format->isAllowed('Time Entry Greater Than Estimated Hour',$roleAccess)){
				$total_time_log_hours = $log_details['LogTime']['total_hours'] ;    
				$tsk_time = $this->LogTime->find('all',array("conditions"=>array("LogTime.task_id"=>$task_details["Easycase"]["id"]),"fields"=>array("SUM(LogTime.total_hours) as log_hour")));
					if($tsk_time){
							$total_time_log_hours = $total_time_log_hours + $tsk_time[0][0]['log_hour'] ;
					}
					if($total_time_log_hours > $task_details['Easycase']['estimated_hours']){
							echo json_encode(array('success' => 'err', 'message' => __('Not allowed to add timelog more than task estimated hours.',true)));
							exit;
					}
			}   
			$this->LogTime->updateAll($log_details['LogTime'], array('LogTime.log_id' => $log_id));
			
			/* update easycases task dt_created */
			if (intval($log_details['LogTime']['task_id']) > 0) {
				$this->Easycase->id = $log_details['LogTime']['task_id'];
				$this->Easycase->save(array('dt_created' => date('Y-m-d H:i:s')));
			}
			/* update last project user visited */
			$this->ProjectUser->recursive = -1;
			$this->ProjectUser->updateAll(array('ProjectUser.dt_visited' => "'" . GMT_DATETIME . "'"), array('ProjectUser.project_id' => $project_id, 'ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP));
			echo json_encode(array('success' => 'success', 'task_id' => $easycase_uniq_id));exit;
		}else{
			echo json_encode(array('success' => 'wrong information'));exit;
		}
    }
     function deleteTimesheet($data = Null) {
        $this->loadModel('LogTime');
        $logdata = isset($data) && !empty($data) ? $data : $this->data;
        $log_id = (trim($logdata['LogTime']['log_id']))?trim($logdata['LogTime']['log_id']):0;
		if($log_id){
			$log_details = $this->LogTime->find('first', array('conditions' => array('LogTime.log_id' => $log_id), 'fields' => array('LogTime.log_id','LogTime.project_id','LogTime.task_id')));
			if($log_details){
				$this->LogTime->query("DELETE FROM log_times WHERE log_id='" . $log_id . "'");
			}
			echo json_encode(array('success' => 'success'));exit;
		}else{
			echo json_encode(array('success' => 'wrong information'));exit;
		}
    }  
    
    function showAllUsers(){
        $this->layout='ajax';
        $arr=array();
        $usesList=array();        
        $this->loadModel('User');
        $this->User->recursive=-1;
        $user_id= SES_ID;
        $userlist = $this->User->find('all',array('joins'=>array(
                        array(
                                'table' => 'company_users',
                                'alias' => 'CompanyUser',
                                'type' => 'inner',
                                'conditions'=> array('CompanyUser.user_id=User.id','User.email IS NOT NULL','User.name !='=>"",'CompanyUser.company_id'=>SES_COMP,'(CompanyUser.is_active = 1)')
                        )),
                        'fields'=>array('User.id ','User.name','User.email','User.last_name','User.photo'),'order' => array('User.name'=> "ASC")));
        foreach($userlist as $k=>$v){
            $usesList[$k]=$v['User'];
            if(empty($usesList[$k]['photo']) || is_null($usesList[$k]['photo'])){  
                $usesList[$k]['random_bgclr']=$this->User->getProfileBgColr($usesList[$k]['id']);
            }
            if($usesList[$k]['id']==$user_id){
             $arr['Person']=$usesList[$k];
            }
         }
        $arr['Projects']=$this->Project->getAllAngProjects(SES_ID);
        $arr['Users']=$usesList;
        /* get all Task of first project **/
        $ProjectTasks = array();
        if(!empty($arr['Projects'])){
            $tpId= $arr['Projects'][0]['id'];
            $tcond = array('Easycase.project_id' => $tpId, 'Easycase.isactive=1', 'istype=1','Easycase.title != ""');
            if ($this->Auth->user('is_client') == 1) {
                $tcond[] = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
            if(!$this->Format->isAllowed('View All Task',$roleAccess)){
                $tcond[]= array('OR' => array('Easycase.assign_to' => SES_ID,'Easycase.user_id' => SES_ID));	     
            }
            $this->loadModel('Easycase');
            $ProjectTasks = $this->Easycase->find('all', array('fields' => array("Easycase.id", "srttitle",'case_no',"uniq_id"), 'conditions' => $tcond, 'order' => 'Easycase.dt_created DESC'));
        }
        if($ProjectTasks){
            foreach($ProjectTasks as $kp=>$vp){
                $ProjectTasks[$kp]["Easycase"]["srttitle_formated"] = "#".$vp["Easycase"]["case_no"]." ".$vp["Easycase"]["srttitle"];
            }
        }
        $arr['Selected']['project_id'] = $tpId;
        $arr['Selected']['pname'] = $arr['Projects'][0]['name'];
        $arr['ProjectTasks'] = $ProjectTasks;
        /*end */
        print json_encode($arr);exit;
    }
    function timesheet_weekly() {		
        $filter = $this->data['filter'];
        $data = $this->data;
        $usid = '';
        $st_dt = '';
        $where = '';
        $sortby = '';
        $sortorder = 'DESC';
        $orderby = " LogTime.start_datetime DESC ";		
        $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");		
        $temp_show_dates = null;       
        $data['strddt'] = date('Y-m-d',strtotime(' +1 day',strtotime($data['startdate']))). ' 00:00:00';
        $data['enddt'] = date('Y-m-d',strtotime(' -1 day',strtotime($data['enddate']))). ' 23:59:00';
                        
        $data['strddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $data['strddt'], "datetime");
        $data['enddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,  $data['enddt'], "datetime");
       // echo "<pre>";print_r($data['filter_type_id']);exit;
        $data['filter_type_id'] = isset($data['filter_type_id']) && !empty($data['filter_type_id']) ? Hash::extract($data['filter_type_id'], "{n}.id") : array();
     array_multisort($data['filter_type_id']);
        
        
                        
        if (isset($data['strddt']) && isset($data['enddt'])) {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $data['strddt'] . "' AND `LogTime`.`start_datetime` < '" . $data['enddt'] . "'";
            $st_dt = " AND start_datetime >= '" . $data['strddt'] . "' AND start_datetime < '" . $data['enddt'] . "'";
        } 
        $count_usid = '';		
        if (isset($data['usrid']) && !empty($data['usrid'])) {
                $selected_user = $data['usrid'];
        }else{
                $selected_user = SES_ID;
                $data['usrid'] = SES_ID;
        }
        if (isset($data['usrid']) && !empty($data['usrid'])) {
            $usrid = explode("-", $data['usrid']);
            foreach ($usrid as $uid) {
                if ($uid != '') {
                    $qrylog.=" `LogTime`.`user_id`=" . $uid . " OR ";
                    $qryusr.= " user_id = '" . $uid . "' OR ";
                }
            }
            $qrylog = substr($qrylog, 0, -3);
            $qry.=" AND (" . $qrylog . ")";
            $qryusr = substr($qryusr, 0, -3);
            $where .= $qry;
            $count_usid = $qry;
        }
        $curCaseId = "0";
        $caseTitleRep = '';
        $isactive = '';
        $extra_condition = "";
        $usrCndtn = "";
        $tskCndtn = "";
        $tskCndtn_task = "";
        if ((SES_TYPE == 3 && SES_ID != 13902) && !$this->Format->isAllowed('View All Timelog',$roleAccess) ) {
            $usrCndtn = " AND `LogTime`.user_id= " . SES_ID . " ";
         //   $tskCndtn_task = " AND `Easycase`.user_id= " . SES_ID . " ";
        }else{
          //   $tskCndtn_task = " AND `Easycase`.user_id= " . $selected_user . " ";
        }
        
        
      /*  if ((SES_TYPE == 3 && SES_ID != 13902) && !$this->Format->isAllowed('View All Timelog',$roleAccess)) { 
            if($data['filter_type_id'] == 1){
                $tskCndtn_task = " AND `Easycase`.assign_to= " . SES_ID . " ";
            } else if($data['filter_type_id'] == 2){
                $tskCndtn_task = " AND `Easycase`.user_id= " . SES_ID . " AND Easycase.assign_to!=" . SES_ID . " ";
            } else if($data['filter_type_id'] == 3){
                
                $tskCndtn_task = " AND `Easycase`.user_id= " . SES_ID . " AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3)) ";
            } else {
                $tskCndtn_task = " AND (`Easycase`.user_id= " . SES_ID . " OR Easycase.assign_to =" . SES_ID . ") AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3)) ";
            }
        } else{
            if($data['filter_type_id'] == 1){
                $tskCndtn_task = " AND `Easycase`.assign_to= " . $this->data['usrid'] . " ";
            } else if($data['filter_type_id'] == 2){
                $tskCndtn_task = " AND `Easycase`.user_id= " . $this->data['usrid'] . " AND Easycase.assign_to!=" . $this->data['usrid'] . " ";
            } else if($data['filter_type_id'] == 3){
                $tskCndtn_task = " AND `Easycase`.user_id= " . $this->data['usrid'] . "  AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3)) ";
            } else {
              //  $tskCndtn_task = " AND `Easycase`.user_id= " . $this->data['usrid'] . " ";
                $tskCndtn_task = " AND (`Easycase`.user_id= " . $this->data['usrid'] . " OR Easycase.assign_to =" . $this->data['usrid'] . ") AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3)) ";
            }
        } */
          if ((SES_TYPE == 3 && SES_ID != 13902) && !$this->Format->isAllowed('View All Timelog',$roleAccess)) {          
            if(count($data['filter_type_id']) > 0){
                foreach($data['filter_type_id'] as $k=>$vf){
                    if($vf == 1){
                        $tskCndtn_task .= " AND `Easycase`.assign_to= " . SES_ID . " " ;
                    } else if($vf == 2){
                        $tskCndtn_task .= " AND (`Easycase`.user_id= " . SES_ID . " AND Easycase.assign_to!=" . SES_ID . ") " ;
                    } else if($vf == 3){
                        if(in_array(4,$data['filter_type_id'])){
                            $tskCndtn_task .=  " AND ((`Easycase`.user_id= " . SES_ID . "  AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3))) " ;
                        } else {
                        $tskCndtn_task .=  " AND `Easycase`.user_id= " . SES_ID . " AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3)) ";
                        }
                        
                    } else if($vf == 4){
                        if(in_array(3,$data['filter_type_id'])){
                            $tskCndtn_task .=  " OR (`Easycase`.user_id= " . SES_ID . "  AND (Easycase.legend != 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id != 3)))) " ;
                        } else {
                           $tskCndtn_task .=  " AND `Easycase`.user_id= " . SES_ID . "  AND (Easycase.legend != 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id != 3)) " ; 
                        }
                    } else {
                        $tskCndtn_task = " AND (`Easycase`.user_id= " . SES_ID . " OR Easycase.assign_to =" . SES_ID . " OR (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3))) ";
                        break;
                    }
                }
            } else {
                $tskCndtn_task = " AND (`Easycase`.user_id= " . SES_ID . " OR Easycase.assign_to =" . SES_ID . ")";// OR (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3))) ";
            }
        } else{
            if(count($data['filter_type_id']) > 0){
                foreach($data['filter_type_id'] as $k=>$vf){
                   if($vf == 1){
                        $tskCndtn_task .=  " AND `Easycase`.assign_to= " . $this->data['usrid'] . " " ;
                    } else if($vf == 2){
                        $tskCndtn_task .=  " AND (`Easycase`.user_id= " . $this->data['usrid'] . " AND Easycase.assign_to!=" . $this->data['usrid'] . ") " ;
                    } else if($vf == 3){
                        if(in_array(4,$data['filter_type_id'])){
                            $tskCndtn_task .=  " AND ((`Easycase`.user_id= " . $this->data['usrid'] . "  AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3))) " ;
                        } else {
                        $tskCndtn_task .=  " AND `Easycase`.user_id= " . $this->data['usrid'] . "  AND (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3)) " ;
                        }
                        
                    } else if($vf == 4){
                        if(in_array(3,$data['filter_type_id'])){
                            $tskCndtn_task .=  " OR (`Easycase`.user_id= " . $this->data['usrid'] . "  AND (Easycase.legend != 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id != 3)))) " ;
                        } else {
                           $tskCndtn_task .=  " AND `Easycase`.user_id= " . $this->data['usrid'] . "  AND (Easycase.legend != 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id != 3)) " ; 
                        }
                    } else {
                        $tskCndtn_task = " AND (`Easycase`.user_id= " . $this->data['usrid'] . " OR Easycase.assign_to =" . $this->data['usrid'] . " OR (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3))) ";
                        break;
                    } 
                }
                        }else{
                $tskCndtn_task = " AND (`Easycase`.user_id= " . $this->data['usrid'] . " OR Easycase.assign_to =" . $this->data['usrid'] . ")";// OR (Easycase.legend = 3 OR Easycase.custom_status_id IN(SELECT CS.id from custom_statuses as CS WHERE CS.company_id =".SES_COMP." AND CS.status_master_id = 3))) ";
            }
        }
        $tidsArray = array(); 
        $this->loadModel('Easycase');
        
        $sql_task = "SELECT DISTINCT Easycase.case_no, Easycase.project_id FROM easycases AS Easycase LEFT JOIN projects AS Project ON Easycase.project_id = Project.id WHERE Project.company_id = '".SES_COMP."' AND (Easycase.istype=2 OR Easycase.istype=1) AND Easycase.isactive=1 ".$tskCndtn_task." AND Easycase.dt_created >= '" . $data['strddt'] . "' AND Easycase.dt_created < '" . $data['enddt'] . "' GROUP BY Easycase.project_id, Easycase.case_no ORDER BY Easycase.dt_created DESC";
        $recentTasks = $this->Easycase->query($sql_task);
        if(count($recentTasks) > 0){
            foreach($recentTasks as $k=>$v){
                $get_rtasks = "SELECT CONCAT_WS('|__|',Easycase.title,Easycase.uniq_id,Easycase.case_no) task_name,Easycase.id,Easycase.case_no,Easycase.uniq_id,Easycase.project_id,Project.name FROM easycases AS `Easycase` LEFT JOIN projects AS Project ON Easycase.project_id = Project.id WHERE  Easycase.case_no='".$v['Easycase']['case_no']."' AND Easycase.project_id ='".$v['Easycase']['project_id']."' AND Easycase.istype=1 AND Easycase.isactive=1 ".$tskCndtn_task;
                $rtasks = $this->Easycase->query($get_rtasks);     
                if(count($rtasks) > 0){
                    $arr = array("LogTime" => array("log_id" => "","user_id"=>"","project_id"=>$rtasks[0]['Easycase']['project_id'],"task_id"=>$rtasks[0]['Easycase']['id'],"task_date"=>"","start_time"=>"","end_time"=>"",
                                                    "total_hours"=> "","is_billable"=> "0","description"=> "","task_status"=> "0","created"=> "","start_datetime"=> "","end_datetime"=> "", "break_time"=> "0",
                                                    "inner"=>array("Saturday"=> "","SaturdayF"=> "","Friday"=> "","FridayF"=> "","Thursday"=> "","ThursdayF"=> "","Wednesday"=> "","WednesdayF"=> "","Tuesday"=> "","TuesdayF"=> "","Monday"=> "","MondayF"=> "","Sunday"=> "","SundayF"=> ""),
                                                    "start_datetime_v1"=> "","task_name"=> $rtasks[0][0]['task_name'],"task_uniqid"=> $rtasks[0]['Easycase']['uniq_id'],"task_no"=> $rtasks[0]['Easycase']['case_no'],"project_name"=> $rtasks[0]['Project']['name']                                                    
                        ),array("start_datetime_v1"=> "","ttime"=> 0,"task_name"=> $rtasks[0][0]['task_name'],"project_name"=>$rtasks[0]['Project']['name']),"Project"=>array("uniq_id"=>"")
                        );            
                    $tidsArray[$rtasks[0]['Easycase']['id']] = $arr;                           
                }
            }
        }
		
		$logsql = "SELECT SQL_CALC_FOUND_ROWS LogTime.*, "
				. " DATE_FORMAT(LogTime.start_datetime,'%M %d %Y %H:%i:%s') AS start_datetime_v1,SUM(LogTime.total_hours) AS ttime,"
				. "(SELECT CONCAT_WS('|__|',title,uniq_id,case_no) FROM easycases AS `Easycase` WHERE `Easycase`.id=LogTime.task_id LIMIT 1) AS task_name, "
				. "(SELECT Project.name FROM projects AS Project WHERE Project.id = LogTime.project_id) AS project_name,Project.uniq_id "
				. "FROM `log_times` AS `LogTime` "
				. "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
				. "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 WHERE Project.isactive=1 AND Project.company_id=" . SES_COMP . " AND Easycase.isactive=1 " . $usrCndtn . " " . $tskCndtn . " $where "
				. " GROUP BY Easycase.id ORDER BY $orderby";
                
                
              
        $logtimes = $this->LogTime->query($logsql);
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        $isAtleastOneHavingData = 0;
        if (is_array($logtimes) && count($logtimes) > 0) {
            foreach ($logtimes as $key => $val) {
                if(count($tidsArray) > 0){
                 if(isset($tidsArray[$val['LogTime']['task_id']])){
                     unset($tidsArray[$val['LogTime']['task_id']]);
                 }
               }
                /** Get inner dates **/
                $logsql1 = "SELECT SQL_CALC_FOUND_ROWS DATE_FORMAT(LogTime.start_datetime,'%Y-%m-%d') AS start_datetime_v1 ,LogTime.total_hours,LogTime.start_datetime,LogTime.log_id ,LogTime.is_billable,LogTime.description  FROM `log_times` AS `LogTime` "
				. "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
				. "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 WHERE Project.isactive=1 AND Project.company_id=" . SES_COMP . " AND Easycase.isactive=1 AND Easycase.id={$logtimes[$key]["LogTime"]['task_id']}" . $usrCndtn . " " . $tskCndtn . " $where "
				. "ORDER BY $orderby";
                $logtimes_inner = $this->LogTime->query($logsql1);                  
                foreach($logtimes_inner as $kt=>$vt){
                   $vt[0]['start_datetime_v1'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $vt['LogTime']['start_datetime'], "datetime");
                   $vt[0]['start_datetime_v1'] = date('l',strtotime($vt[0]['start_datetime_v1']));
                   $dt=date('Y-m-d',strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,$vt['LogTime']['start_datetime'], "datetime")));
                   $d=$this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dt.' 00:00:00', "datetime");
                   $d1=$this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dt.' 23:59:00', "datetime");
                   
                   $logsql2 = "SELECT SQL_CALC_FOUND_ROWS count(*) as cnt FROM `log_times` AS `LogTime` "
				. "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
				. "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 WHERE Project.isactive=1 AND Project.company_id=" . SES_COMP . " AND Easycase.isactive=1 AND Easycase.id={$logtimes[$key]['LogTime']['task_id']}" . $usrCndtn . " " . $tskCndtn." AND LogTime.start_datetime >= '" .$d . "' AND LogTime.start_datetime < '" . $d1 . "'";
                                   $innerCnt = $this->LogTime->query($logsql2); 
                                   
                    $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1']]= isset($logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1']])?$logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1']]:0;
                    $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1']] += $vt['LogTime']['total_hours'];
                    $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'cnt'] = $innerCnt[0][0]['cnt'];
                    $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'id'] = $vt['LogTime']['log_id'];
                    $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'F'] = $this->Format->format_second_hrmin($logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1']]);
                    $isAtleastOneHavingData += $vt['LogTime']['total_hours'];
                    if(isset($logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'C']) && !empty($logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'C'])){
                        $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'C'] = 1;
                    }else{
                         $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'C'] = $vt['LogTime']['is_billable'];
                    }
                    if(!isset($logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'desc'])){
                        $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'desc'] = "";
                }
                    $logtimes[$key]["LogTime"]['inner'][$vt[0]['start_datetime_v1'].'desc'] .= $vt['LogTime']['description'];
                }
                /*End*/
                $logtimes[$key]["LogTime"]['start_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['start_datetime'], "datetime");
                $logtimes[$key]["LogTime"]['end_datetime'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logtimes[$key]["LogTime"]['end_datetime'], "datetime");				
                $logtimes[$key]["LogTime"]['start_datetime_v1'] = date('m/d', strtotime($logtimes[$key]["LogTime"]['start_datetime']));
		$tskexplod = explode('|__|',$logtimes[$key][0]['task_name']);				
                $logtimes[$key]["LogTime"]['task_name'] = $frmt->formatTitle($tskexplod[0]);
                $logtimes[$key]["LogTime"]['task_uniqid'] = $tskexplod[1];
                $logtimes[$key]["LogTime"]['task_no'] = $tskexplod[2];
                $logtimes[$key]["LogTime"]['project_name'] = $frmt->formatTitle($logtimes[$key][0]['project_name']);
                $logtimes[$key]["LogTime"]['description'] = h($logtimes[$key]["LogTime"]['description']);
                $logtimes[$key]["LogTime"]['total_hours'] = $logtimes[$key]["LogTime"]['total_hours'];
                if (!isset($logtimes[$key]["Project"]['uniq_id'])) {
                    $logtimes[$key]["Project"]['uniq_id'] = '';
                }
                $logtimes[$key]['LogTime']['start_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['start_datetime']));
                $logtimes[$key]['LogTime']['end_time'] = date('H:i:s', strtotime($logtimes[$key]['LogTime']['end_datetime']));
            }
        }
        $tot = $this->LogTime->query("SELECT FOUND_ROWS() as total");
        $caseCount = $tot[0][0]['total'];
        if(count($tidsArray) > 0){
            $caseCount = $caseCount + count($tidsArray);
            $logtimes = array_merge(array_values($tidsArray),$logtimes);
        }
        $allProjects = $this->Project->getAllAngProjects($selected_user);
        
        /* get the approver users list created by admin starts here */
        $this->loadModel('TimesheetApprover');
        $this->loadModel('User');
        $selectAllApprovers = $this->TimesheetApprover->getApproverList(SES_COMP,SES_ID);
        $SelectedUserArray = array();
        if($selectAllApprovers){
            foreach($selectAllApprovers as $kk=>$vv){
                $SelectedUserArray[$kk] = $vv['users'];
                $SelectedUserArray[$kk]['name'] = $vv[0]['name'];
            }
        }
			
		/* get the approver users list created by admin ends here */
        $roleInfo = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
       $roleAccess = $roleInfo['roleAccess'];			
		
        $ProjectTasks = array();
        if(!empty($allProjects)){
            $tpId= $allProjects[0]['id'];
            $tcond = array('Easycase.project_id' => $tpId, 'Easycase.isactive=1', 'istype=1','Easycase.title != ""');
            if ($this->Auth->user('is_client') == 1) {
                $tcond[] = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
            }
            if(!$this->Format->isAllowed('View All Task',$roleAccess)){
                $tcond[]= array('OR' => array('Easycase.assign_to' => SES_ID,'Easycase.user_id' => SES_ID));	     
            }  
            $this->loadModel('Easycase');
            $ProjectTasks = $this->Easycase->find('all', array('fields' => array("Easycase.id", "srttitle",'case_no',"uniq_id"), 'conditions' => $tcond, 'order' => 'Easycase.dt_created DESC'));
        }
        if($ProjectTasks){
            foreach($ProjectTasks as $kp=>$vp){
                $ProjectTasks[$kp]["Easycase"]["srttitle_formated"] = "#".$vp["Easycase"]["case_no"]." ".$vp["Easycase"]["srttitle"];
            }
        }
        /* get details if user has already submitted the this week for approval or not starts here */
		
        $userIdVal = $data['usrid'];
        $startDateVal = explode(" ", $data['strddt'])[0];
        $endDateVal = explode(" ", $data['enddt'])[0];

        $this->loadModel('TimesheetApprovalDetail');
        $datee = $endDateVal;
        $date = new DateTime($datee);
        $week = $date->format("W");
       
        $selectAssignApprovers = $this->TimesheetApprovalDetail->checkTimesheetApproved(SES_COMP,$userIdVal,$week);//$this->AssignApprover->query("select * from assign_approvers where user_id='".$userIdVal."' AND (DATE(approve_start_week) BETWEEN '".$startDateVal."' AND '".$endDateVal."' ) AND (DATE(approve_end_week) BETWEEN '".$startDateVal."' AND '".$endDateVal."' ) AND (pending_status = 1 OR pending_status = 2)");
        if($selectAssignApprovers && count($selectAssignApprovers) > 0){
                $isApproveRequestSent = 1;
        }else{
                $isApproveRequestSent = 2;
        }
        /* get details if user has already submitted the this week for approval or not ends here */
        
        $caseDetail['isApproveRequestSent'] = $isApproveRequestSent;
        $caseDetail['Selected']['project_id'] = $tpId;
        $caseDetail['Selected']['pname'] = $allProjects[0]['name'];
        $caseDetail['ProjectTasks'] = $ProjectTasks;
        $caseDetail['logtimes'] = $logtimes;
        $caseDetail['lastweekLog'] = $this->getLastweekLog(array('usrid' => $data['usrid']));
        $caseDetail['total'] = $caseCount;
        $caseDetail['selected_date'] = $data['currentdate'];
        $caseDetail['weekdates'] = $week_array;		
        $caseDetail['projects'] = $allProjects;	
        $caseDetail['approvers'] = $SelectedUserArray;
        $caseDetail['isAtleastOneHavingData'] = $isAtleastOneHavingData;
        $caseDetail['company_id'] = SES_COMP;
        
        echo json_encode($caseDetail);exit;
    }
   
    function saveAllTimesheet(){
        $this->loadModel('Project');
        $this->loadModel('LogTime');
        $this->loadModel('Easycase');
        $logdatas = json_decode($this->request->data);
        $this->Project->recursive = -1;
        $task_id=0;
        $dependentTno = array();
        $dependent_msg = "";
        foreach($logdatas as $key=>$value){
            foreach($value as $key1=>$logdata){
                if(isset($logdata->task_id) && !empty($logdata->task_id)){
                    /**
                    * Variables need to send 
                    */
                   $is_billable = 0 ;
                   $project_id = $logdata->project_id;
                   $task_id = $logdata->task_id;
                   $user_id = $logdata->user_id;
                   $log_id = $logdata->log_id;
                   $is_billable = $logdata->is_billable;
                   $desc = trim($logdata->desc);
                   /*
                    * End
                    */
                   $task_details = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $task_id), 'fields' => array('Easycase.*')));
                   
                   $allowed = $this->task_dependency($task_id);
                   if ($allowed == 'No') {
                       $dependentTno[] = "#".$task_details['Easycase']['case_no'];
                       // echo json_encode(array('success' => false, 'message' => 'Dependant tasks are not closed.'));
                        break;
                    }
                    $easycase_uniq_id = $task_details['Easycase']['uniq_id'];
                    $this->Format = $this->Components->load('Format');
                    $caseuniqid = $this->Format->generateUniqNumber();
                    if(empty($log_id)){
                    $reply_type = isset($logdata->task_id) ? 10 : 11;
                    //$this->Easycase->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', case_no = '" . $task_details['Easycase']['case_no'] . "', 	case_count=0, project_id='" . $task_details['Easycase']['project_id'] . "', user_id='" . SES_ID . "', updated_by=0, type_id='" . $task_details['Easycase']['type_id'] . "', priority='" . $task_details['Easycase']['priority'] . "', title='', message='', hours='0', assign_to='" . $task_details['Easycase']['assign_to'] . "', istype='2',format='2', status='" . $task_details['Easycase']['status'] . "', legend='" . $task_details['Easycase']['legend'] . "', isactive=1, dt_created='" . GMT_DATETIME . "',actual_dt_created='" . GMT_DATETIME . "',reply_type=" . $reply_type . "");										
										$this->Easycase->insertCommentThreadCommon($task_details,'timelog',$reply_type);	
                    $task_status = 0;
                    }
                   
                    $LogTime = array();
                    $LogTime['LogTime']['log_id'] =$log_id;
                    $LogTime['LogTime']['task_id'] =$task_id;
                    $LogTime['LogTime']['project_id'] =$project_id;
                    $LogTime['LogTime']['user_id'] =$user_id;
                    $LogTime['LogTime']['task_date'] = $logdata->date;
                    $LogTime['LogTime']['start_time'] = '00:00:00';
                    $LogTime['LogTime']['end_time'] = '23:59:00';
                    $LogTime['LogTime']['start_datetime'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logdata->date . " 00:00:00", "datetime");
                    $LogTime['LogTime']['end_datetime'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $logdata->date . " 23:59:00" , "datetime");
                    $LogTime['LogTime']['break_time'] = 0;
                    $LogTime['LogTime']['total_hours'] =  (isset($logdata->sec)&& !empty($logdata->sec))?$logdata->sec:0; ;
                    $LogTime['LogTime']['is_billable'] = $is_billable;
                    $LogTime['LogTime']['description'] = $desc;
                    $LogTime['LogTime']['timesheet_flag'] =1;
                    $resArr['LogTime']['task_no'] = $task_details['Easycase']['case_no'];
                   #print_r($LogTime);
                    $this->LogTime->create();
                    $this->LogTime->save($LogTime);     
        /* update easycases task dt_created */
        if (intval($task_id) > 0 && empty($log_id)) {
                        $this->Easycase->create();
            $this->Easycase->id = $task_id;
            $this->Easycase->saveField('dt_created',date('Y-m-d H:i:s'));
        }

        /* update last project user visited */
                }
            }
        }   
        if(count($dependentTno) > 0){
            $dependent_msg = "Dependant tasks of task no ".  implode(",",$dependentTno)." are not closed.Other tasks are saved successfully.";
        }

        echo json_encode(array('success' => true, 'task_id' => $task_id,'msg' => $dependent_msg ));
        exit;
    }
    function getTasksByProject(){
        $this->layout="ajax";
        $arr= array();
        $project_id=$this->request->data['project_id']; 
        $cond = array('Easycase.project_id' => $project_id, 'Easycase.isactive=1', 'istype=1');
        if (isset($this->data['q']) && !empty($this->data['q'])) {
            $cond[] = '(Easycase.title like "%' . trim($this->data['q']) . '%" OR Easycase.case_no like "%' . trim(str_replace('#', '', $this->data['q'])) . '%") AND Easycase.title != ""';
        } else {
            $cond[] = 'Easycase.title != ""';
        }
        if ($this->Auth->user('is_client') == 1) {
            $cond[] = "((Easycase.client_status = " . $this->Auth->user('is_client') . " AND Easycase.user_id = " . $this->Auth->user('id') . ") OR Easycase.client_status != " . $this->Auth->user('is_client') . ")";
        }
        if(isset($this->data['notIn']) && !empty($this->data['notIn'])){          
             $cond['NOT']=array('Easycase.id'=>explode(',',$this->data['notIn']));
        }
       $roleInfo = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
       $roleAccess = $roleInfo['roleAccess'];			
		if(!$this->Format->isAllowed('View All Task',$roleAccess)){
	    $cond[]= array('OR' => array('Easycase.assign_to' => SES_ID,'Easycase.user_id' => SES_ID));	     
        }  
        $this->loadModel('Easycase');
        $tsktitles = $this->Easycase->find('all', array('fields' => array("Easycase.id", "srttitle",'case_no','uniq_id'), 'conditions' => $cond, 'order' => 'Easycase.dt_created DESC'));
        if($tsktitles){
            foreach($tsktitles as $kp=>$vp){
                $tsktitles[$kp]["Easycase"]["srttitle_formated"] = "#".$vp["Easycase"]["case_no"]." ".$vp["Easycase"]["srttitle"];
            }
        }
        $arr['tasks']=$tsktitles;
        print json_encode($arr);exit;
    }
    function deleteTimesheetWeek(){
      $arr=array();
//      $d=$this->data['date'].' 00:00:00';
//      $d1=$this->data['date1'].' 23:59:00';
      
      $d= $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $this->data['date'] . " 00:00:00", "datetime"); 
      $d1=$this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $this->data['date1'] . " 23:59:00" , "datetime");
      
      $task_id=$this->data['task_id'];
      $user_id=$this->data['user_id'];
      $project_id=$this->data['project_id'];
      $logsql="DELETE FROM log_times WHERE start_datetime >= '{$d}' AND start_datetime <= '{$d1}' AND user_id=$user_id AND task_id=$task_id AND project_id=$project_id";
//      $logsql="DELETE FROM log_times WHERE (DATE(start_datetime) = date_sub(date('{$d}'), INTERVAL 1 week)) AND user_id=$user_id AND task_id=$task_id AND project_id=$project_id";
      $logtimes = $this->LogTime->query($logsql);
      if($logsql){
         $arr['status']='success'; 
      }else{
          $arr['status']='failure'; 
      }
      print json_encode($arr);exit;
    }
    /*
     * This function is used to get the resource availability view
     */

	function getBookedallhourreports() {
        $this->layout = 'ajax';
        $this->loadModel('ProjectBookedResource');
		$this->loadModel('Overload');
        $data = $this->request->data;
        $dt= $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATE.' 00:00:01', "datetime");
		
		$next30DaysSeconds = 86390 * 30;
		
        $options['conditions'] = array('ProjectBookedResource.user_id' => $data['user_id'],'ProjectBookedResource.company_id'=>SES_COMP ,'ProjectBookedResource.date >=' => $dt, 'ProjectBookedResource.date <=' => date('Y-m-d H:i:s',strtotime($dt.' +'.$next30DaysSeconds.' seconds')));
        $options['fields'] = array("ProjectBookedResource.*", "Company.*", "Project.*", "Easycase.*", "User.*");
		
		$options['order'] = array("ProjectBookedResource.date ASC");
		
        $options['joins'] = array(
            array('table' => 'companies', 'alias' => 'Company', 'type' => 'INNER', 'conditions' => array('Company.id = ProjectBookedResource.company_id')),
            array('table' => 'projects', 'alias' => 'Project', 'type' => 'INNER', 'conditions' => array('Project.id = ProjectBookedResource.project_id')),
            array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'INNER', 'conditions' => array('Easycase.id = ProjectBookedResource.easycase_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'INNER', 'conditions' => array('User.id = ProjectBookedResource.user_id')),
        );
        $booked_data = $this->ProjectBookedResource->find('all', $options);
        foreach ($booked_data as $key => $value) {
			$ResourceBookedDate = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value['ProjectBookedResource']['date'], "dateFormat");
            $data_arr['booked_rsrs'][] = array('datevalue' => $ResourceBookedDate,'project' => $value['Project']['name'],'case_no' => $value['Easycase']['case_no'], 'case_title' => $value['Easycase']['title'], 'hours_overload' => '', 'hours_booked' => $value['ProjectBookedResource']['booked_hours'] / 3600);
           
			$dateover = date('Y-m-d', strtotime($ResourceBookedDate)); //print $date;exit;
	        $dtover = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dateover." 00:00:01", "datetime");
			
			$optionsover['conditions'] = array('Overload.user_id' => $data['user_id'],'Overload.company_id'=>SES_COMP ,'Overload.date >=' => $dtover,'Overload.date <=' => date('Y-m-d H:i:s',strtotime($dtover.' +86390 seconds')));
		    $over_data = $this->Overload->find('all', $optionsover);
		    foreach ($over_data as $key1 => $value1) {
			  $data_arr['booked_rsrs'][] = array('datevalue' => $ResourceBookedDate,'project' => $value1['Project']['name'],'case_no' => $value1['Easycase']['case_no'], 'case_title' => $value1['Easycase']['title'], 'hours_booked' => '', 'hours_overload' => $value1['Overload']['overload'] / 3600);
			  }
			
			$data_arr['user'] = $value['User']['name'];
            $data_arr['userId'] = $value['User']['id'];
        }
        $this->set('data_arr', $data_arr);
		$this->set('data_start_date', $data['res_start_date']);
		$this->set('data_end_date', $data['res_end_date']);
    }	
    function getBookedhourreports() {
        $this->layout = 'ajax';
        $this->loadModel('ProjectBookedResource');
        $data = $this->request->data;
        $dt= $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $data['date']." 00:00:01", "datetime");
        $options['conditions'] = array('ProjectBookedResource.user_id' => $data['user_id'],'ProjectBookedResource.company_id'=>SES_COMP ,'ProjectBookedResource.date >=' => $dt, 'ProjectBookedResource.date <=' => date('Y-m-d H:i:s',strtotime($dt.' +86390 seconds')));
        $options['fields'] = array("ProjectBookedResource.*", "Company.*", "Project.*", "Easycase.*", "User.*");
        $options['joins'] = array(
            array('table' => 'companies', 'alias' => 'Company', 'type' => 'INNER', 'conditions' => array('Company.id = ProjectBookedResource.company_id')),
            array('table' => 'projects', 'alias' => 'Project', 'type' => 'INNER', 'conditions' => array('Project.id = ProjectBookedResource.project_id')),
            array('table' => 'easycases', 'alias' => 'Easycase', 'type' => 'INNER', 'conditions' => array('Easycase.id = ProjectBookedResource.easycase_id')),
            array('table' => 'users', 'alias' => 'User', 'type' => 'INNER', 'conditions' => array('User.id = ProjectBookedResource.user_id')),
        );
        $booked_data = $this->ProjectBookedResource->find('all', $options);
        $data_arr['date'] = date('M d, Y', strtotime($data['date']));
        foreach ($booked_data as $key => $value) {
            $data_arr['booked_rsrs'][] = array('project' => $value['Project']['name'],'uniq_id' => $value['Easycase']['uniq_id'],'case_no' => $value['Easycase']['case_no'], 'case_title' => $value['Easycase']['title'], 'hours_booked' => $value['ProjectBookedResource']['booked_hours'] / 3600);
            /*if (isset($value['ProjectBookedResource']['overload']) && !empty($value['ProjectBookedResource']['overload'])) {
                $data_arr['overload'] = $value['ProjectBookedResource']['overload'];
            }*/
            $data_arr['user'] = $value['User']['name'];
            $data_arr['userId'] = $value['User']['id'];
        }
        $this->loadModel('Overload');
        $totalOverloadHours = $this->Overload->find('all', array('conditions' => array('Overload.user_id' => $data['user_id'],'Overload.company_id' =>SES_COMP,'Overload.date >=' => $dt,'Overload.date <=' => date('Y-m-d H:i:s',strtotime($dt.' +86390 seconds'))), 'fields' => array('SUM(Overload.overload) as total_overload'), 'group' => array('Overload.user_id')));
        $this->set('data_arr', $data_arr);
        $this->set('total_overload', $totalOverloadHours[0][0]['total_overload']);
    }
     function getOverloads(){
      $this->layout = 'ajax';
      $this->loadModel('Overload');
      $data = $this->request->data;
      $date = date('Y-m-d', strtotime($data['date'])); //print $date;exit;
      $dt= $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $data['date']." 00:00:01", "datetime");
//      $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $date, "datetime");
//      $date = date('Y-m-d', strtotime($curDateTime));
      $options['conditions'] = array('Overload.user_id' => $data['user_id'],'Overload.company_id'=>SES_COMP ,'Overload.date >=' => $dt,'Overload.date <=' => date('Y-m-d H:i:s',strtotime($dt.' +86390 seconds')));
      $over_data = $this->Overload->find('all', $options);
	  $data_arr=array();
	  $overload_time=0;
	  if(!empty($over_data)){
      $data_arr['date'] = date('M d, Y', strtotime($date));
      foreach ($over_data as $key => $value) {
		  $sum_time=!empty($value['Overload']['overload'])?$value['Overload']['overload']:0;
		  $overload_time +=$sum_time;
          $data_arr['overload_rsrs'][] = array('project' => $value['Project']['name'],'case_no' => $value['Easycase']['case_no'],'uniq_id' => $value['Easycase']['uniq_id'], 'case_title' => $value['Easycase']['title'], 'hours_overload' => $value['Overload']['overload'] / 3600);
          $data_arr['user'] = $value['User']['name'];
          $data_arr['userId'] = $value['User']['id'];
      }
	  if(!empty($overload_time)){
		  $overload_time=round(($overload_time/3600),2);
	  }
	  }
	  
	  $this->set('overload_time', $overload_time);
      $this->set('over_data', $data_arr);
      $this->set('date', $data['date']);
    }
      public function getProjs(){
      $this->loadModel('Project');
      if(SES_TYPE>=3){
       $sql = "SELECT DISTINCT Project.name,Project.uniq_id FROM projects AS Project,
        project_users AS ProjectUser WHERE Project.id = ProjectUser.project_id AND ProjectUser.user_id='" . SES_ID . "'
            and ProjectUser.company_id='" . SES_COMP . "' AND Project.isactive='1' AND Project.name !='' ORDER BY Project.name ASC" ;
        $projects = $this->Project->query($sql);
        $data_res = Hash::combine($projects,'{n}.Project.uniq_id', '{n}.Project.name');
    }else{
        $data_res = Hash::combine($this->Project->find('all', array('conditions' => array('Project.company_id' => SES_COMP, 'Project.isactive' => 1),'order'=>array('Project.name' => 'ASC'),'recursive' => -1)), '{n}.Project.uniq_id', '{n}.Project.name');
    }
        echo json_encode($data_res);exit;
    }
    function getProjusers() {
        $proj_id = $this->request->query['projUniq'];
        $this->loadModel('Project');
        $this->loadModel('User');
        $clt_sql = 1;
        $mlstnQ2 = '';
        $mlstnQ2 = '';
        $qry = '';
        $options = array();
        $options['group'] = array('ProjectUser.user_id');
        $options['fields'] = array('DISTINCT ProjectUser.user_id AS user_id','User.*');
        $options['conditions'] = array("User.isactive" => 1,'ProjectUser.company_id'=>SES_COMP,'User.name !='=>'');
        $options['order'] = array("User.name ASC");
        if (trim($proj_id) !== 'all') {
          $proj_options = array('conditions' => array('Project.uniq_id' => $proj_id));
          $project_data = $this->Project->find('first', $proj_options);
          $options['conditions'] = array('ProjectUser.project_id' => $project_data['Project']['id'],"User.isactive" => 1,'ProjectUser.company_id'=>SES_COMP);
        }
        if(!$this->Format->isAllowed('View All Resource')){
            $options['conditions']['User.id'] = SES_ID;
        }
        $this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
        $this->User->bindModel(array('hasOne' => array('CompanyUser' => array('className' => 'CompanyUser', 'foreignKey' => 'user_id','conditions'=>array('CompanyUser.company_id'=>SES_COMP),'fields'=>array('CompanyUser.is_active')))));
        $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $this->ProjectUser->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'user_id'))));
        $this->ProjectUser->recursive = 2;
        $user_data = $this->ProjectUser->find('all', $options);
        echo json_encode($user_data);
        exit;
    }
    function getSkillByProj() {
        $response['userdata'] = array();
        $response['skills'] = array();
        $proj_id = (!empty($this->data['projUniq'])) ? $this->data['projUniq'] : $this->request->query['projUniq'];
        $this->loadModel('Skill');
        $this->loadModel('User');
        $this->loadModel('UserSkill');
        $this->loadModel('Project');      
        $options = array();
        $options['group'] = array('ProjectUser.user_id');
        $options['fields'] = array('DISTINCT ProjectUser.user_id AS user_id','User.*');
        $options['conditions'] = array("User.isactive" => 1,'ProjectUser.company_id'=>SES_COMP,'User.name !='=>'');        
        $options['order'] = array("User.name ASC");
        
        if (trim($proj_id) !== 'all') {
          $proj_options = array('conditions' => array('Project.uniq_id' => $proj_id));
          $project_data = $this->Project->find('first', $proj_options);
       
          $options['conditions'] = array('ProjectUser.project_id' => $project_data['Project']['id'],"User.isactive" => 1,'ProjectUser.company_id'=>SES_COMP);
        }

        if(!$this->Format->isAllowed('View All Resource')){
            $options['conditions']['User.id'] = SES_ID;
        }
        $this->User->unbindModel(array('hasAndBelongsToMany' => array('Project')));
        $this->User->bindModel(array('hasOne' => array('CompanyUser' => array('className' => 'CompanyUser', 'foreignKey' => 'user_id','conditions'=>array('CompanyUser.company_id'=>SES_COMP),'fields'=>array('CompanyUser.is_active')))));
        $this->ProjectUser->unbindModel(array('belongsTo' => array('Project')));
        $this->ProjectUser->bindModel(array('belongsTo' => array('User' => array('className' => 'User', 'foreignKey' => 'user_id'))));
        $this->ProjectUser->recursive = 2;
        $user_data = $this->ProjectUser->find('all', $options);
            
        if($user_data){
           $userId = Hash::extract($user_data, "{n}.User.id"); 
           $skills= $this->Skill->skillFetch($userId);      
           $response['userdata'] = $user_data;
           $response['skills'] = $skills;
     }    
        echo json_encode($response);
        exit;
    }
    function save_vacation() {
        $data = $this->request->data;
        $this->loadModel('UserLeave');
        $arr = array();
        if (isset($data['id'])) {
            $this->UserLeave->id = $data['id'];
        }
        if (isset($data['start_date'])) {
         $data['start_date'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $data['start_date']." 00:00:01", "datetime");
        }
         if (isset($data['end_date'])) {
          $data['end_date'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $data['end_date']." 23:59:59", "datetime");
         }
        $data['company_id'] = SES_COMP;
        $data['dt_created'] = GMT_DATETIME;
        if ($this->UserLeave->save($data)) {
            $arr['success'] = 1;
        } else {
            $arr['success'] = 0;
        }
        echo json_encode($arr);
        exit;
    }
    function update_vacation() {
        $this->layout = 'ajax';
        $id = $this->request->data['id'];
        $this->loadModel('UserLeave');
        $leavearr = $this->UserLeave->find('first', array('conditions' => array('UserLeave.id' => $id, 'UserLeave.company_id' => SES_COMP)));
         if (isset($leavearr['UserLeave']['start_date'])) {
         #$leavearr['UserLeave']['start_date'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $leavearr['UserLeave']['start_date'], "datetime");
         $leavearr['UserLeave']['start_date'] =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $leavearr['UserLeave']['start_date']." 00:00:01", "datetime");
        }
         if (isset($leavearr['end_date'])) {
          #$leavearr['UserLeave']['end_date'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $leavearr['UserLeave']['end_date'], "datetime");
          $leavearr['UserLeave']['end_date'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $leavearr['UserLeave']['end_date']." 23:59:59", "datetime");
         }
        $this->set(compact('leavearr'));
        $this->render('/Elements/popup_user_leave_form');
    }
    function cancel_vacation(){
        $this->layout = 'ajax';
        $id= $this->request->data['leave_id'];
        $this->loadModel('UserLeave');
        if($this->UserLeave->delete($id)){
            echo 1;
        } else{
            echo 0;
        }
        exit;
    }
    function checkLeavestats($user_id, $start, $end) { 
        $start = date('Y-m-d', strtotime($start));
        $end = date('Y-m-d', strtotime($end));
        //Convert to UTC
        $start_utc=  $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $start." 00:00:01", "datetime");
        $end_utc=  $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $end." 23:59:59", "datetime");
        $dates_array = $this->createDateRangeArray($start, $end);
        $WorkHour = ClassRegistry::init('WorkHour');
        $whl= $WorkHour->find('list',array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>SES_COMP),'order'=>array('created DESC')));
        $perDayWorkSec =$this->Format->getworkhr($whl,$start);
        $perDayWorkSec =$perDayWorkSec * 3600;
        //$perDayWorkSec = $GLOBALS['company_work_hour'] * 3600;
        $UserLeaves = ClassRegistry::init('UserLeave');
        $leaves = $UserLeaves->find('all', array('conditions' => array('UserLeave.company_id' => SES_COMP, 'UserLeave.user_id' => $user_id)));
        $CompanyHoliday = ClassRegistry::init('CompanyHoliday');
        $hLists = $CompanyHoliday->find('all',array('fields'=>array('holiday','description'),'conditions'=>array('company_id'=>SES_COMP,'or' => array('holiday >=' => $start_utc,'holiday >=' => $start_utc)),'order'=>array('created ASC')));
        foreach($hLists as $k=>$v){
            $arr = array();
            $arr['start_date'] = $v['CompanyHoliday']['holiday'];
            #$arr['end_date'] = $v['CompanyHoliday']['holiday'];
            $arr['end_date'] = date('Y-m-d H:i:s',strtotime($v['CompanyHoliday']['holiday'] . " +" . 86398 . " seconds"));
            $leaves[]['UserLeave'] = $arr;
        }
        #$query = "SELECT SUM(`ProjectBookedResource`.`booked_hours`) AS booked_hours, `ProjectBookedResource`.`id`, `ProjectBookedResource`.`company_id`, `ProjectBookedResource`.`project_id`, `ProjectBookedResource`.`easycase_id`, `ProjectBookedResource`.`user_id`, `ProjectBookedResource`.`date` FROM `project_booked_resources` AS `ProjectBookedResource` INNER JOIN easycases AS Easycase ON Easycase.id=ProjectBookedResource.easycase_id  AND Easycase.isactive=1  WHERE `ProjectBookedResource`.`company_id` = " . SES_COMP . " AND `ProjectBookedResource`.`user_id` = " . $user_id . " AND `ProjectBookedResource`.`date` >= '" . $start_utc . "' AND `ProjectBookedResource`.`date` <= '" . $end_utc . "'  GROUP BY DATE(`ProjectBookedResource`.`date`)";
        $query = "SELECT `ProjectBookedResource`.`booked_hours` AS booked_hours, `ProjectBookedResource`.`id`, `ProjectBookedResource`.`company_id`, `ProjectBookedResource`.`project_id`, `ProjectBookedResource`.`easycase_id`, `ProjectBookedResource`.`user_id`, `ProjectBookedResource`.`date` FROM `project_booked_resources` AS `ProjectBookedResource` INNER JOIN easycases AS Easycase ON Easycase.id=ProjectBookedResource.easycase_id  AND Easycase.isactive=1  WHERE `ProjectBookedResource`.`company_id` = " . SES_COMP . " AND `ProjectBookedResource`.`user_id` = " . $user_id . " AND `ProjectBookedResource`.`date` >= '" . $start_utc . "' AND `ProjectBookedResource`.`date` <= '" . $end_utc . "'";
        $all_working_days = $this->ProjectBookedResource->query($query);
        #print_r($all_working_days);exit;
        #$bookedDates = Hash::extract($all_working_days, '{n}.ProjectBookedResource.date');
        $bookedDates =array();
        foreach($all_working_days as $k=>$v){
            $dk=$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['ProjectBookedResource']['date'], "date");
            $bookedDates[$dk]['hours'] += $v['ProjectBookedResource']['booked_hours'];
            $bookedDates[$dk]['date'] = $v['ProjectBookedResource']['date'];
        }
        $asg_arr = array();
        foreach ($dates_array as $key => $value) {
            //Check If User is on leave
            $inleave = $this->Postcase->checkDateInLeave($value, $leaves);
            if (!$inleave) {
                if (!array_key_exists($value, $bookedDates)) {
                    $asg_arr[] = array(0 => array('booked_hours' => 0), 'ProjectBookedResource' => array('date' => $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value." 00:00:01", "datetime")));
                } else {
                    //for every working day
                    foreach ($bookedDates as $k => $v) {
                        //IF date not available
                        if ($k === $value && $v['hours'] < $perDayWorkSec) {
                            $asg_arr[] = array(0 => array('booked_hours' => $v['hours']), 'ProjectBookedResource' => array('date' => $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['date'], "datetime")));
                        }
                    }
                }
            }
        }
       // echo $query;print_r($asg_arr);exit;
        return $asg_arr;
    }
    function checkAvailableUsers($callee = array()) {
        $this->layout = 'ajax';
        $data = !empty($callee) ? $callee : $this->request->data;
        $assigned_Resource_id = !empty($callee) ? $callee['assignTo'] : $this->request->data['assignedId'];
        $assigned_Resource_date = !empty($callee) ? $callee['str_date'] : date('Y-m-d', strtotime($this->request->data['gantt_start_date']));
        $assigned_due_date = !empty($callee) ? $callee['CS_due_date'] : (($this->request->data['CS_due_date'] == "0000-00-00 00:00:00") ? "0000-00-00 00:00:00" : date('Y-m-d', strtotime($this->request->data['CS_due_date'])));
        
        $assigned_Resource_date_time = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $assigned_Resource_date." 00:00:01", "datetime");
        
        $estimated_hrs = !empty($callee) ? $callee['est_hr'] : (!empty($data['estimated_hours']) ? $data['estimated_hours'] : 0);
        /*Convert : to . format **/
        $estimated_hrsarr= explode(":", $estimated_hrs);
        if(isset($estimated_hrsarr[1]) && !empty($estimated_hrsarr[1])){
          $estimated_hrs = $estimated_hrsarr[0];
          $dsml=($estimated_hrsarr[1]/60)*100;
          $dsml = round('0.'.$dsml, 2);
          $estimated_hrs = floatval($estimated_hrs) + floatval($dsml);
        }
        
        $weekendArr = explode(',',$GLOBALS['company_week_ends']);
        
        $assigned_Resource_project = !empty($callee) ? $callee['projectId'] : $this->request->data['project_id'];
        $caseId = !empty($callee) ? $callee['caseId'] : $this->request->data['caseid'];
        $WorkHour = ClassRegistry::init('WorkHour');
        $whl= $WorkHour->find('list',array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>SES_COMP),'order'=>array('created DESC')));
        $perDayWorkSec =$this->Format->getworkhr($whl,date('Y-m-d'));
//        $perDayWorkSec = $GLOBALS['company_work_hour'] * 3600;
        $perDayWorkSec = $perDayWorkSec * 3600;
        $caseUniqId = !empty($callee) ? $callee['caseUniqId'] : $this->request->data['caseuniqid'];
        $this->loadModel('ProjectBookedResource');
        $this->loadModel('CompanyUser');

        $this->User->bindModel(array('hasMany' => array('ProjectBookedResource' => array('className' => 'ProjectBookedResource'))));
        $this->User->Behaviors->attach('Containable');
        $conditions_array = array('ProjectBookedResource.company_id' => SES_COMP, 'ProjectBookedResource.date >=' =>$assigned_Resource_date_time);
        $users_conditions = array('User.isactive' => 1);
        if (!empty($callee)) {
            $conditions_array['ProjectBookedResource.user_id'] = $callee['assignTo'];
            $users_conditions['User.id'] = $callee['assignTo'];
        }
        $data = $this->User->find('all', array('joins' => array(array('table' => 'company_users', 'alias' => 'CompanyUser', 'type' => 'INNER', 'conditions' => array('CompanyUser.user_id=User.id', 'CompanyUser.company_id' => SES_COMP,'CompanyUser.is_active=1')), array('table' => 'project_users', 'alias' => 'ProjectUser', 'type' => 'INNER', 'conditions' => array('ProjectUser.user_id=User.id', 'ProjectUser.project_id' => $assigned_Resource_project))), 'conditions' => $users_conditions, 'recursive' => -1));
        
        $ResourceNextAvailableDate = array();
        foreach ($data as $k => $usrdata) {
            //Find Last Assigned Date 
            $last_res_arr = $this->ProjectBookedResource->find('all', array(
                'conditions' => array(
                    'ProjectBookedResource.company_id' => SES_COMP,
                    'ProjectBookedResource.user_id' => !empty($callee) ? $callee['assignTo'] : $usrdata['User']['id'],
                    'ProjectBookedResource.date >=' => $assigned_Resource_date_time
                    ),
                'joins' => array(
                    array(
                        'table' => 'easycases',
                        'alias' => 'Easycase',
                        'type' => 'INNER',
                        'conditions' => array(
                            'Easycase.id=ProjectBookedResource.easycase_id',
                            'Easycase.isactive' => 1
                        )
                    )
                ),
                'order' => array('ProjectBookedResource.date' => 'DESC'),
                'limit' => 1
                ));				
            //print $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $last_res_arr[0]['ProjectBookedResource']['date'], "date");exit;
            //print date('Y-m-d', strtotime($assigned_Resource_date));exit;
            $ResourceNextAvailableDate[$usrdata['User']['id']]['name'] = $usrdata['User']['name'] . ' ' . $usrdata['User']['last_name'];
            $user_id = !empty($callee) ? $callee['assignTo'] : $usrdata['User']['id'];
            /* Fetching user role & skills --Start--
           
            * Sangita- 18/06/2021
            */
            $this->loadModel('Skill'); 
            $this->loadModel('ProjectUser');
            $this->loadModel('Role');
            $this->loadModel('UserSkill');         
            
            $fetch_role = $this->ProjectUser->find('first', array('conditions' => array('ProjectUser.user_id' => $user_id,'ProjectUser.project_id' => $assigned_Resource_project),'fields' => 'ProjectUser.role_id'));
            $userRoleRecord = $this->Role->findById($fetch_role['ProjectUser']['role_id'], 'role');
           
            if(!empty($userRoleRecord)){
                $userRole = $userRoleRecord['Role']['role'];               
            } 
            else {
                $fetchRole = $this->CompanyUser->find('first', array('conditions' => array('CompanyUser.user_id' => $user_id),'fields' => 'CompanyUser.role_id'));
                $userRecord = $this->Role->findById($fetchRole['CompanyUser']['role_id'], 'role');
                $userRole = $userRecord['Role']['role'];
            }
        $ResourceNextAvailableDate[$usrdata['User']['id']]['role']= $userRole; 
                 
        $fetch_skill = $this->UserSkill->find('all', array('conditions' => array('UserSkill.user_id' => $user_id)));
        $allSkill = Hash::extract($fetch_skill, "{n}.Skill.name");    
               
        $allSkill= array_slice($allSkill,1);         
        $skill= implode(',', $allSkill);       
    
        $ResourceNextAvailableDate[$usrdata['User']['id']]['skill']= $fetch_skill;  
        $ResourceNextAvailableDate[$usrdata['User']['id']]['skillList']= $skill; 
         /* Fetching user role & skills --End--*/
            
            if (!empty($last_res_arr)) {               
                $all_working_days = $this->checkLeavestats($user_id, $assigned_Resource_date, $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $last_res_arr[0]['ProjectBookedResource']['date'], "date"));
				$total_consumed_hours = 0;
                $AssignedResourceNextAvailableDataAll = array();
                $needed = $estimated_hrs;				
                foreach ($all_working_days as $key => $value) {
                    $day_name = date('w',strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value['ProjectBookedResource']['date'], "date")));
                    if(!in_array($day_name,$weekendArr)){
                    $Avlhrs = ($perDayWorkSec - $value[0]['booked_hours']) / 3600;
                    if ($needed > 0) {
                       $total_consumed_hours = floatval($total_consumed_hours)+ floatval($Avlhrs);
                        if($total_consumed_hours > $estimated_hrs) {
                            $AssignedResourceNextAvailableDataAll['next_available_dates'][] = array("date" => date('Y-m-d H:i:s', strtotime($value['ProjectBookedResource']['date'])), 'Avlhrs' => $needed);
                            break;
                        } else {
                            $AssignedResourceNextAvailableDataAll['next_available_dates'][] = array("date" => date('Y-m-d H:i:s', strtotime($value['ProjectBookedResource']['date'])), 'Avlhrs' => $Avlhrs);
                        }
                        $needed = floatval($needed) -  floatval($Avlhrs);
                    }
                }
                }
                $ResourceNextAvailableDate[$usrdata['User']['id']]['AvailableHours'] = ($total_consumed_hours < $estimated_hrs) ? $this->assignWork($last_res_arr[0]['ProjectBookedResource']['date'], $total_consumed_hours, $estimated_hrs, $AssignedResourceNextAvailableDataAll, date('Y-m-d', strtotime($assigned_Resource_date)),$user_id) : $AssignedResourceNextAvailableDataAll;
            } else {
               
                $last_date = $assigned_due_date;
                #echo $assigned_Resource_date."<br/>".$last_date;
                $assigned_Resource_date_other = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $assigned_Resource_date, "date");
                $total_no_estimate_dys = round($estimated_hrs/$this->Format->getworkhr($whl,date('Y-m-d')));
                $lastDate = date("Y-m-d", strtotime($assigned_Resource_date." + ".$total_no_estimate_dys." days"));
                //echo $total_no_estimate_dys."<br/>".$lastDate;exit;
                $all_working_days = $this->checkLeavestats($user_id,$assigned_Resource_date,$lastDate);
             
				$total_consumed_hours = 0;
                $needed = $estimated_hrs;
                $AssignedResourceNextAvailableDataAll = array();
                
                foreach ($all_working_days as $key => $value) {
                    $day_name = date('w',strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value['ProjectBookedResource']['date'], "date")));
                    if(!in_array($day_name,$weekendArr)){
                    if(!empty($value)){
                    $Avlhrs = ($perDayWorkSec - $value[0]['booked_hours']) / 3600;
                   
                     $projDate= $value['ProjectBookedResource']['date'];
                    if ($needed > 0) {
                        $total_consumed_hours = floatval($total_consumed_hours)+ floatval($Avlhrs);	 
						
                        if (($needed * 3600) <= ($Avlhrs * 3600)) { 
                            $AssignedResourceNextAvailableDataAll['next_available_dates'][] = array("date" => date('Y-m-d H:i:s', strtotime($projDate)), 'Avlhrs' => $needed);
                            $needed = floatval($needed) -  floatval($needed);							
                            break;
                        } else {
                            if (($needed * 3600) > $perDayWorkSec) {
                                $AssignedResourceNextAvailableDataAll['next_available_dates'][] = array("date" => date('Y-m-d H:i:s', strtotime($projDate)), 'Avlhrs' => $perDayWorkSec / 3600);
                                $needed = floatval($needed) - floatval(($perDayWorkSec / 3600));
                            } else {
                                $AssignedResourceNextAvailableDataAll['next_available_dates'][] = array("date" => date('Y-m-d H:i:s', strtotime($projDate)), 'Avlhrs' => $needed);
                                $needed = floatval($needed) - floatval($needed);
                            }
                        }
                    }
                }
            }
            }
                #$ResourceNextAvailableDate[$usrdata['User']['id']]['AvailableHours'] = $AssignedResourceNextAvailableDataAll;
                $ResourceNextAvailableDate[$usrdata['User']['id']]['AvailableHours'] = ($total_consumed_hours < $estimated_hrs) ? $this->assignWork((count($all_working_days) >0)?$all_working_days[(count($all_working_days)-1)]['ProjectBookedResource']['date']:$lastDate, $total_consumed_hours, $estimated_hrs, $AssignedResourceNextAvailableDataAll, date('Y-m-d', strtotime($assigned_Resource_date)),$user_id) : $AssignedResourceNextAvailableDataAll;
            }
        } //print_r($ResourceNextAvailableDate);//print_r($assigned_Resource_id);exit;
		if (!empty($callee)) {
            return $ResourceNextAvailableDate;
            exit;
        } else {
            $this->set('assignedResourceNextAvailabelData', $ResourceNextAvailableDate[$assigned_Resource_id]);
            $this->set('ResourceNextAvailableDate', $ResourceNextAvailableDate);
            $this->set('caseId', $caseId);
            $this->set('caseUniqId', $caseUniqId);
            $this->set('project_id', $assigned_Resource_project);
            $this->set('estimated_hours', $estimated_hrs);
            $this->set('gantt_start_date', date('Y-m-d', strtotime($this->request->data['gantt_start_date'])));
            $this->set('task_due_date', (($this->request->data['CS_due_date'] == "0000-00-00 00:00:00") ? "0000-00-00" : date('Y-m-d', strtotime($this->request->data['CS_due_date']))));
            $this->set('assigned_Resource_id', $assigned_Resource_id);
            $this->set('parenttaskId', $this->request->data['parenttaskId']);
        }
    }
     function createDateRangeArray($strDateFrom, $strDateTo) {
        $aryRange = array();
        $iDateFrom = mktime(1, 0, 0, substr($strDateFrom, 5, 2), substr($strDateFrom, 8, 2), substr($strDateFrom, 0, 4));
        $iDateTo = mktime(1, 0, 0, substr($strDateTo, 5, 2), substr($strDateTo, 8, 2), substr($strDateTo, 0, 4));
        if ($iDateTo >= $iDateFrom) {
            array_push($aryRange, date('Y-m-d', $iDateFrom));
            while ($iDateFrom < $iDateTo) {
                $iDateFrom+=86400;
                array_push($aryRange, date('Y-m-d', $iDateFrom));
            }
        }
        return $aryRange;
    }

     function assignWork($users_last_date, $total_consumed_hours, $estimated_hrs, $AssignedResourceNextAvailableData, $asgn_date, $user_id) {
         $WorkHour = ClassRegistry::init('WorkHour');
        $whl= $WorkHour->find('list',array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>SES_COMP),'order'=>array('created DESC')));
        $perDayWorkSec =$this->Format->getworkhr($whl,date('Y-m-d'));
//        $perDayWorkSec = $GLOBALS['company_work_hour'] * 3600;
        $weekendArr = explode(',',$GLOBALS['company_week_ends']);
        $perDayWorkSec = $perDayWorkSec * 3600;     
        $total_left_hrs = $next_left_hrs = ((float) $estimated_hrs - (float) $total_consumed_hours) * 3600;       
        $more_days_needed = ceil((float)$total_left_hrs / (float)$perDayWorkSec);
        if (empty($users_last_date)){
            $users_last_date =GMT_DATE;
        }else{
           $users_last_date =  $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $users_last_date, "date");
                }
        $sts= array();
        $dn = 0;
        while (count($sts) < $more_days_needed) {                
            $sts = $this->checkLeavestats($user_id,date('Y-m-d', strtotime($users_last_date . " +" . 1 . "days")),date('Y-m-d', strtotime($users_last_date . " +" . ($more_days_needed + $dn) . "days")));            
            foreach($sts as $k=>$v) {
             $day_name = date('w',strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['ProjectBookedResource']['date'],'date')));   
             if(in_array($day_name,$weekendArr)){
                 unset($sts[$k]);
             }
            }  
            $dn += $more_days_needed - count($sts);
            }
           
        foreach($sts as $k=>$v) {
                $assgign_hour = ($next_left_hrs > $perDayWorkSec) ? $perDayWorkSec / 3600 : $next_left_hrs / 3600;
            $AssignedResourceNextAvailableData['next_available_dates'][] = array("date" => date('Y-m-d H:i:s', strtotime($v['ProjectBookedResource']['date'])), 'Avlhrs' => $assgign_hour);
                $next_left_hrs -= $perDayWorkSec;
            }
        return $AssignedResourceNextAvailableData;
    }

    function changeresource() {
        $res = $this->checkAvailableUsers($this->request->data);
        $caseId = $this->request->data['caseId'];
        $caseUniqId = $this->request->data['caseUniqId'];
        $assignTo = $this->request->data['assignTo'];
        $projectId = $this->request->data['projectId'];
        $start_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($this->request->data['str_date']." 00:00:01"), "datetime"); 
        $WorkHour = ClassRegistry::init('WorkHour');
        $whl= $WorkHour->find('list',array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>SES_COMP),'order'=>array('created DESC')));
        $perDayWorkSec =$this->Format->getworkhr($whl,$this->request->data['str_date']);
//        $perDayWorkSec = $GLOBALS['company_work_hour'] * 3600;
        $perDayWorkSec = $perDayWorkSec * 3600;
        $weekendArr = explode(',',$GLOBALS['company_week_ends']);
        $this->loadModel('Easycase');
        $caseDetails = $this->Easycase->find('first', array('conditions' => array('Easycase.id' => $caseId), 'fields' => array('Easycase.estimated_hours')));
        $estimated_hours = $caseDetails['Easycase']['estimated_hours'];
        if ($estimated_hours == '') {
            $due_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($this->request->data['str_date']." 23:59:59"), "datetime"); 
        } else {
            $BookedResources = ClassRegistry::init('ProjectBookedResource');
            $bookedData = $BookedResources->find('all', array('conditions' => array('ProjectBookedResource.company_id' => SES_COMP, 'ProjectBookedResource.user_id' => $assignTo, 'ProjectBookedResource.date >=' => $start_date)));
            $bookedDates = Hash::combine($bookedData, '{n}.ProjectBookedResource.date', '{n}.ProjectBookedResource.booked_hours');
            $data = array();
            $j = 0;
            foreach ($res[$assignTo]['AvailableHours']['next_available_dates'] as $key => $value) {
                $newbookedhrs = $value['Avlhrs'] * 3600;
                $data[$j]['ProjectBookedResource']['company_id'] = SES_COMP;
                $data[$j]['ProjectBookedResource']['user_id'] = $assignTo;
                $data[$j]['ProjectBookedResource']['project_id'] = $projectId;
                $data[$j]['ProjectBookedResource']['easycase_id'] = $caseId;
                $data[$j]['ProjectBookedResource']['date'] = $value['date'];
                $data[$j]['ProjectBookedResource']['booked_hours'] = $newbookedhrs;
                $estimated_hours -= $newbookedhrs;
                $j++;
            }
            $due_date = $data[$j - 1]['ProjectBookedResource']['date'];
            $start_date = $data[0]['ProjectBookedResource']['date'];
            #echo "<pre>";echo $j;print_r($data);exit;
            $BookedResources->saveMany($data);
        }
        $this->Easycase->updateAll(array('Easycase.assign_to' => $assignTo, 'Easycase.gantt_start_date' => '"' . $start_date . '"', 'Easycase.due_date' => '"' . $due_date . '"'), array('Easycase.id' => $caseId));
        echo 1;
        exit;
    }

     function overloadUsers() {
        set_time_limit(0);
        if ($this->request->is('ajax')) {
            $callee = $this->request->data;
            $assigned_Resource_id = $callee['assignTo'];
            $estimated_hrs = $callee['est_hr'];
            $assigned_Resource_project = $callee['projectId'];
            $caseId = $callee['caseId'];
            $WorkHour = ClassRegistry::init('WorkHour');
            $whl= $WorkHour->find('list',array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>SES_COMP),'order'=>array('created DESC')));
            $perDayWorkSec =$this->Format->getworkhr($whl,date('Y-m-d'));
    //        $perDayWorkSec = $GLOBALS['company_work_hour'] * 3600;
            $perDayWorkSec = $perDayWorkSec * 3600;
            $weekendArr = explode(',',$GLOBALS['company_week_ends']);
            $caseUniqId = $callee['caseUniqId'];
            $estArr = explode(":", $estimated_hrs); 
            $estStr = ($estArr[0] * 3600);
            if(isset($estArr[1])){
                $estStr += ($estArr[1] * 60);
            }
            $no_of_days = $nof_of_days_lv = ceil( (int)$estStr / (int)$perDayWorkSec);
            
            $startdate = $assigned_Resource_date = date('Y-m-d', strtotime($callee['str_date']));
            $assigned_Resource_date_gmt = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($assigned_Resource_date." 00:00:01"), "datetime");
            $lastdate = date('Y-m-d', strtotime($assigned_Resource_date . " +" . ($no_of_days - 1) . "days"));
            /** change the last date and the no of days if due date is set **/
            if(isset($callee['CS_due_date']) && !empty($callee['CS_due_date'])){
              $lastdate = (($callee['CS_due_date'] == "0000-00-00") ? "0000-00-00" : date('Y-m-d', strtotime($callee['CS_due_date'])));
              $no_of_days = round((strtotime($lastdate) -  strtotime($assigned_Resource_date)) / 86400) + 1;
            }
            /** END **/
            $this->loadModel('Overload');
            $this->loadModel('ProjectBookedResource');
            $this->loadModel('UserLeave');
            // $leaves = $this->UserLeave->find('all', array('conditions' => array('UserLeave.company_id' => SES_COMP, 'UserLeave.user_id' => $assigned_Resource_id)));
            // $CompanyHoliday = ClassRegistry::init('CompanyHoliday');
            // $hLists = $CompanyHoliday->find('all',array('fields'=>array('holiday','description'),'conditions'=>array('company_id'=>SES_COMP,'or' => array('holiday >=' => $assigned_Resource_date_gmt,'holiday >=' => $assigned_Resource_date_gmt)),'order'=>array('created ASC')));
            // foreach($hLists as $k=>$v){
            //     $arr = array();
            //     $arr['start_date'] = $v['CompanyHoliday']['holiday'];
            //     #$arr['end_date'] = $v['CompanyHoliday']['holiday'];
            //     $arr['end_date'] = date('Y-m-d H:i:s',strtotime($v['CompanyHoliday']['holiday'] . " +" . 86398 . " seconds"));
            //     $leaves[]['UserLeave'] = $arr;
            // }
            $leaves = array();
            $lastdatetime =  $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($lastdate." 00:00:01"), "datetime");
			$lastdatetimestamp = strtotime($lastdatetime);
            $working_dates = array();
            $do = $no_of_days;
            while ($lastdatetimestamp >= strtotime($assigned_Resource_date_gmt)) {
                // $inleave = $this->Postcase->checkDateInLeave($assigned_Resource_date_gmt, $leaves);
                $day_name = date('w',strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,$assigned_Resource_date_gmt,'date')));
                //if(!in_array($day_name,$weekendArr)){
                //if (!$inleave) {
                    $working_dates[] = $assigned_Resource_date_gmt;
                    $do--;
                //}
                //}
                $assigned_Resource_date_gmt = date('Y-m-d H:i:s', strtotime($assigned_Resource_date_gmt . " +" . 1 . " days"));
            }
           
            $partial_days = array();
            $actual_time_covered  = 0;
            foreach ($working_dates as $key => $value) {
                $query = "SELECT `ProjectBookedResource`.`booked_hours`, `ProjectBookedResource`.`id`, `ProjectBookedResource`.`company_id`, `ProjectBookedResource`.`project_id`, `ProjectBookedResource`.`easycase_id`, `ProjectBookedResource`.`user_id`, `ProjectBookedResource`.`date` FROM `project_booked_resources` AS `ProjectBookedResource` WHERE `ProjectBookedResource`.`company_id` = " . SES_COMP . " AND `ProjectBookedResource`.`user_id` = " . $assigned_Resource_id . " AND `ProjectBookedResource`.`date` >= '" . $value . "' AND `ProjectBookedResource`.`date` <= '" . date('Y-m-d H:i:s',strtotime($value.' +86390 seconds')) . "'  ORDER BY `ProjectBookedResource`.`date` DESC ";
                $hours_booked = $this->ProjectBookedResource->query($query);
                $value_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value, "date");
                if (!empty($hours_booked)) {
                    $booked_hours = 0;                    
                    foreach($hours_booked as $kv=>$vv){
                        $booked_hours += $vv['ProjectBookedResource']['booked_hours'];
                        $partial_days[$value_dt] = $booked_hours;
                    }
                } else {
                    $partial_days[$value_dt] = 0;
                }
                
                if($actual_time_covered < $estStr){                    
                    $actual_time_covered += $perDayWorkSec - $partial_days[$value_dt];
                }else{
                    unset($partial_days[$value_dt]);
                    break;
            }
         
            }
           
            #print_r($working_dates);exit;
            $due_date = (($callee['CS_due_date'] == "0000-00-00") ? "0000-00-00" : date('Y-m-d', strtotime($callee['CS_due_date'])));
            if (empty($partial_days)) {
                $overload_hours = $ovhrs = $estStr / $no_of_days;
                $overload = array();
                foreach ($working_dates as $key => $value) {
                    if($value < $perDayWorkSec){
                    $newDate = $due_date = $value;
                    $overload[] = array('date'=>$newDate,'easycase_id'=>$caseId,'project_id'=>$assigned_Resource_project,'user_id'=>$assigned_Resource_id,'company_id'=>SES_COMP,'overload'=>$overload_hours);
                }
                }
                $this->Overload->saveAll($overload);
            } else {
                $estimated_hrss = $estStr;
                foreach ($partial_days as $key => $value) {
                    if($value < $perDayWorkSec){
                    $pr_bk_hrs['ProjectBookedResource'] = array();
                    $newDate = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($key." 00:00:01"), "datetime");
                $a = $perDayWorkSec - $value;
                    $valWorkSec = ($estimated_hrss < $perDayWorkSec)?$estimated_hrss:$perDayWorkSec;
                    $a = ($estimated_hrss < $a)?$estimated_hrss:$a;
                    $rest_to_assign = (empty($a)) ? $valWorkSec  : $a;
                    $bookde_val = (empty($a)) ? $valWorkSec : ($a);
                    $pr_bk_hrs['ProjectBookedResource'] = array('user_id' => $assigned_Resource_id, 'date' => $newDate, 'project_id' => $assigned_Resource_project, 'easycase_id' => $caseId, 'company_id' => SES_COMP, 'booked_hours' => $bookde_val, 'overload' => 0);
                    $this->ProjectBookedResource->create();
                    $this->ProjectBookedResource->save($pr_bk_hrs);
                    $estimated_hrss -= $rest_to_assign;
                }
                }
                if($estimated_hrss){
                    $overload_hours = $estimated_hrss / count($partial_days); //$no_of_days;
                
                    $last_date = $partial_days[count($partial_days) - 1];
                $overload = array();
                    foreach ($partial_days as $key => $value) {
                        $newDate = $due_date =  $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($key." 00:00:01"), "datetime");
                    $overload[] = array('date'=>$newDate,'easycase_id'=>$caseId,'project_id'=>$assigned_Resource_project,'user_id'=>$assigned_Resource_id,'company_id'=>SES_COMP,'overload'=>$overload_hours);
                }
                $this->Overload->saveAll($overload);
            }
            }            
        $this->loadModel('Easycase');
            $startdate_1 = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($startdate." 00:00:01"), "datetime");
            if($lastdate == "0000-00-00"){
                $lastdate_1 = null;
            }else{
            $lastdate_1 = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($lastdate." 00:00:01"), "datetime");
            }
            $this->Easycase->updateAll(array('Easycase.assign_to' => $assigned_Resource_id, 'Easycase.gantt_start_date' => '"' . $startdate_1 . '"', 'Easycase.due_date' => '"' . $lastdate_1 . '"'), array('Easycase.id' => $caseId));
            echo 1;exit;
        }
    }
    
    function createAndDownloadReport(){
       $this->layout="ajax"; 
       if(isset($this->request->data) && !empty($this->request->data)){         
            $data = $this->request->data;
            $sdate = date('m_d_Y',strtotime($data['start_date']));
            $edate = date('m_d_Y',strtotime($data['end_date']));
            $filename = WWW_ROOT . DS.'timesheetpdf'.DS.'pdf'.DS.'timesheet_' .$sdate.$edate.'.pdf';
            $layout = 'landscape';
            $orientation = " -O landscape ";
            if(file_exists($filename)) {
                @unlink($filename);
            }
            //print HTTP_ROOT . 'logTimes/timesheetPDF?usrid='.$data['usrid'].'&start_date='.$data['start_date'].'&end_date='.$data['end_date'].'&project='.$data['project'].'&comp='.SES_COMP.'" ';exit;
            exec('"'.PDF_LIB_PATH.'"' . $orientation . ' "' . HTTP_ROOT . 'logTimes/timesheetPDF?usrid='.$data['usrid'].'&start_date='.$data['start_date'].'&end_date='.$data['end_date'].'&project='.$data['project'].'&comp='.SES_COMP.'" ' .' ' . $filename);
            #print '"'.PDF_LIB_PATH.'"' . $orientation . ' "' . HTTP_ROOT . 'logTimes/timesheetPDF?usrid='.$data['usrid'].'&start_date='.$data['start_date'].'&end_date='.$data['end_date'].'&project='.$data['project'].'&comp='.SES_COMP.'" ' . $layout . ' ' . $filename;exit;
            if(file_exists($filename)) {
                header("Content-Type: application/octet-stream");
                $file = $filename;
                header("Content-Disposition: attachment; filename=" . urlencode('timesheet_'.$sdate.'_'.$edate.'.pdf'));   
                header("Content-Type: application/octet-stream");
                header("Content-Type: application/download");
                header("Content-Description: File Transfer");            
                header("Content-Length: " . filesize($file));
                flush(); // this doesn't really matter.
                $fp = fopen($file, "r");
                while (!feof($fp))
                {
                    echo fread($fp, 65536);
                    flush(); // this is essential for large downloads
                } 
                fclose($fp); 
            } else {
                $this->redirect(HTTP_ROOT.'dashboard#/timesheet');
            }
       }else{
		   $this->redirect(HTTP_ROOT.'dashboard#/timesheet');
	   }
       exit;
    }
    function checkLogAvailable(){
        $arr['msg'] = "error";
        $data = $this->request->data;
        if(!empty($data)){
            $company = SES_COMP;
            
            $start_datetime = strtotime($data['start_date']);
            $end_datetime = strtotime($data['end_date']);
            $no_of_days = ceil(abs($end_datetime - $start_datetime) / 86400)+1;
            $data['totalday'] = $no_of_days;
                
        $usid = '';
        $st_dt = '';
        $where = '';
        $sortby = '';
        $sortorder = 'DESC';
        $orderby = " LogTime.project_id DESC, LogTime.start_datetime DESC ";		
        $count_usid = '';		
        if (isset($data['usrid']) && !empty($data['usrid'])) {
                $selected_user = $data['usrid'];
        }else{
                $selected_user = SES_ID;
                $data['usrid'] = SES_ID;
        }
        $projectCond = "";
        if(isset($data['project']) && !empty($data['project'])){
				$projectCond = " AND LogTime.project_id IN(".implode(',',$data['project']).") ";
        }
        
        $curDateTime = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");		
        $temp_show_dates = null;       
        $data['strddt'] = date('Y-m-d',strtotime($data['start_date'])). ' 00:00:00';
        $data['enddt'] = date('Y-m-d',strtotime($data['end_date'])). ' 23:59:00';
                        
        $data['strddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $data['strddt'], "datetime");
        $data['enddt'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,  $data['enddt'], "datetime");
        
      
                        
        if (isset($data['strddt']) && isset($data['enddt'])) {
            $where .= " AND `LogTime`.`start_datetime` >= '" . $data['strddt'] . "' AND `LogTime`.`start_datetime` < '" . $data['enddt'] . "'";
            $st_dt = " AND start_datetime >= '" . $data['strddt'] . "' AND start_datetime < '" . $data['enddt'] . "'";
        } 
        if (isset($data['usrid']) && !empty($data['usrid'])) {
            $usrid = explode(",", $data['usrid']);
            foreach ($usrid as $uid) {
                if ($uid != '') {
                    $qrylog.=" `LogTime`.`user_id`=" . $uid . " OR ";
                    $qryusr.= " user_id = '" . $uid . "' OR ";
                }
            }
            $qrylog = substr($qrylog, 0, -3);
            $qry.=" AND (" . $qrylog . ")";
            $qryusr = substr($qryusr, 0, -3);
            $where .= $qry;
            $count_usid = $qry;
        }
        $curCaseId = "0";
        $caseTitleRep = '';
        $isactive = '';
        $extra_condition = "";
        $usrCndtn = "";
        $tskCndtn = "";

        
            $usrCndtn = " AND `LogTime`.user_id= " . $data['usrid'] . " ";//          

    
		$logsql = "SELECT SQL_CALC_FOUND_ROWS LogTime.* "
				. "FROM `log_times` AS `LogTime` "
				. "LEFT JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
				. "LEFT JOIN projects AS Project ON Project.id=LogTime.project_id AND Project.isactive=1 WHERE Project.isactive=1 AND Project.company_id=" . SES_COMP . " AND Easycase.isactive=1 " . $usrCndtn . " " . $tskCndtn. $projectCond . " $where "
				. " GROUP BY Easycase.id ORDER BY $orderby";
                
                
       //print $logsql;exit;     
        $logtimes = $this->LogTime->query($logsql);
            if(count($logtimes) > 0){
                $arr['msg'] = "success";
            }
        }
        print json_encode($arr);exit;
    }
    
    function getAllUsersProjects(){
        $this->layout="ajax";
        /** Get all Users **/
        $allusers_t = null;
        $allusers =  array();
        if(SES_TYPE == 3){
           $userlis = $this->User->find('all',array(
                                'conditions'=>array('User.name !='=>"",'User.id'=>SES_ID),
				'fields'=>array('User.id ','User.name','User.email','User.last_name','User.photo'),'order' => array('User.name'=> "ASC")));
         $allusers['userlist'] =   $userlis;
        }else{
            $allusers = $this->User->getAllCompanyUsers(SES_COMP,SES_ID);
        }
            if($allusers){
                    $allusers_t = Hash::combine($allusers['userlist'], '{n}.User.id', '{n}.User');
                    $allusers_t = array_values($allusers_t);
            }else{
                    $allusers_t = array();
            }
       
        $all['resource'] = $allusers_t;
        /*End*/
        $all['projects'] = $this->showAllProjects(SES_ID);
        print json_encode($all);exit;
    }
    function removeHoliday(){
         $this->layout="ajax";
         $arr['status']=0;
         if(isset($this->request->data['id']) && !empty($this->request->data['id'])){
             $id = $this->request->data['id'];
             $this->loadModel('CompanyHoliday');
             if($this->CompanyHoliday->delete($id)){
                 $arr['status']=1;
             }else{
                 $arr['status']=0;
             }
         }
         echo json_encode($arr);
        exit;
    }
function getSkills(){
    $this->loadModel('Skill');
    $data_sub = $this->Skill->getSkillList('list', 1); 
    $arr['skills'] = $data_sub;        
    echo json_encode($arr);
    exit;
}
 function checkLessMoreTimeSubmit(){
        $this->loadModel('AssignApprover');
        $this->loadModel('LogTime');
        $this->loadModel('Company');
        $logdataschk = json_decode($this->request['data']);
        #echo "<pre>";print_r($logdataschk);

        $submittedWeeklyHours = $logdataschk->approve_total_hours;

        $Company = ClassRegistry::init('Company');
        $requestedWeeklyHours = $Company->getWeeklyHour();
        //$checkWeeklyHours['requestedHours'] = $requestedWeeklyHours;
        $checkWeeklyHours['requestedHours'] = $requestedWeeklyHours;
        $checkWeeklyHours['requestedHoursFormatted'] = $this->Format->format_time_hr_min($requestedWeeklyHours);
        //$checkWeeklyHours['submittedHours'] = $submittedWeeklyHours;
        $checkWeeklyHours['submittedHours'] = $submittedWeeklyHours;
        $checkWeeklyHours['submittedHoursFormatted'] = $this->Format->format_time_hr_min($submittedWeeklyHours);

        if ($requestedWeeklyHours > $submittedWeeklyHours) {
            $checkWeeklyHours['isRequestGreaterThanSubmitted'] = 1;
            $checkWeeklyHours['moreLessHours'] = $this->Format->format_time_hr_min($checkWeeklyHours['requestedHours'] - $checkWeeklyHours['submittedHours']);
        } else if ($requestedWeeklyHours < $submittedWeeklyHours) {
            $checkWeeklyHours['isRequestGreaterThanSubmitted'] = 2;
            $checkWeeklyHours['moreLessHours'] = $this->Format->format_time_hr_min($checkWeeklyHours['submittedHours'] - $checkWeeklyHours['requestedHours']);
        } else {
            $checkWeeklyHours['isRequestGreaterThanSubmitted'] = 3;
        }
        echo json_encode($checkWeeklyHours);
        exit;
    }
    
    function saveApproverTimesheet(){
        $this->loadModel('TimesheetApprovalDetail');
        $this->loadModel('LogTime');
        $this->loadModel('User');
        $logdatas = json_decode($this->request['data']);
        #echo "<pre>";print_r($logdatas);exit;

        $startEmailDate = date("d F", strtotime($logdatas->approver_week_start));
        $endEmailDate = date("d F", strtotime($logdatas->approver_week_end));
        $endEmailDateYear = date("Y", strtotime($logdatas->approver_week_end));
        $timesheet_comment_val = htmlspecialchars($logdatas->timesheet_comment_val);
        $project_id = $logdatas->project_id;
//echo "<pre>";print_r(array('LogTime.user_id' => $logdatas->user_id, 'LogTime.task_date  >=' =>"'". date("Y-m-d", strtotime($logdatas->approver_week_start))."'", 'LogTime.task_date <=' => "'" . date("Y-m-d", strtotime($logdatas->approver_week_end)) . "'" ));

        $usrApproverArr = $this->User->getUserDtls($logdatas->approver_user_id);
        if (count($usrApproverArr)) {
            $approver_ses_name = $usrApproverArr['User']['name'];
            $approver_ses_email = $usrApproverArr['User']['email'];
        }
        $usrArr = $this->User->getUserDtls(SES_ID);
        if (count($usrArr)) {
                $ses_name = $usrArr['User']['name'];
                $ses_photo = $usrArr['User']['photo'];
                $ses_email = $usrArr['User']['email'];
                $ses_last_name = $usrArr['User']['last_name'];
        }
        if($logdatas->week_number == 1){
            $logdatas->week_number = 52; // conditions for last week of year
        }else{
            $logdatas->week_number = $logdatas->week_number -1 ; // javascript give a week in advance so we subtract 1 from the request parameter
        }        
        $selectAssignApprovers = $this->TimesheetApprovalDetail->getTimesheetApprovalDetails($logdatas);//"select * from assign_approvers where user_id='" . $logdatas->user_id . "' AND DATE(approve_start_week)='" . $logdatas->approver_week_start . "' AND DATE(approve_end_week)='" . $logdatas->approver_week_end . "' AND (pending_status = 1 || pending_status = 2)");
	#echo "<pre>";	print_r($selectAssignApprovers);echo count($selectAssignApprovers);exit;
        $Company = ClassRegistry::init('Company');
        $requestedWeeklyHours = $Company->getWeeklyHour();
        $logdatas->weekly_hour = $requestedWeeklyHours;
        if ($selectAssignApprovers && count($selectAssignApprovers) > 0) {
            echo json_encode(array('success' => false, 'msg' => 'This week is already submitted for approval.'));
        } else {
            if($this->TimesheetApprovalDetail->saveTimesheetApprovalDetails($logdatas)){
                /* Update pending_status & approver_id fields in LogTime table for those comes under the week range as above ends here  */
                $project_ids = rtrim(implode(',',$project_id),',');
                $this->LogTime->query("UPDATE log_times set pending_status=1, approver_id='".$logdatas->approver_user_id."' where project_id IN(".$project_ids.") AND user_id='".$logdatas->user_id."' and task_date >= '".date("Y-m-d", strtotime($logdatas->approver_week_start))."' and task_date <= '".date("Y-m-d", strtotime($logdatas->approver_week_end))."'");
             //   $this->LogTime->updateAll(array('LogTime.pending_status' => 1,'LogTime.approver_id' => $logdatas->approver_user_id), array('LogTime.user_id' => $logdatas->user_id, 'LogTime.task_date >=' =>'"'. date("Y-m-d", strtotime($logdatas->approver_week_start)).'"', 'LogTime.task_date <=' => '"' . date("Y-m-d", strtotime($logdatas->approver_week_end)) . '"' ));
              if ($requestedWeeklyHours > $logdatas->approve_total_hours) {
                $this->set('moreLessHoursText', "Short Hours");
                $this->set('moreLessHours', $this->Format->format_time_hr_min($requestedWeeklyHours - $logdatas->approve_total_hours));
                $this->set('moreLessColor', "#FF0000");
            } else if ($requestedWeeklyHours < $logdatas->approve_total_hours) {
                $this->set('moreLessHoursText', "Excess Hours");
                $this->set('moreLessHours', $this->Format->format_time_hr_min($logdatas->approve_total_hours - $requestedWeeklyHours));
                $this->set('moreLessColor', "green");
            }

            /* Send Approver a notification that you are assigned with a timesheet for approval starts here */

            $subject = "Timesheet Approval Request (" . $startEmailDate . " - " . $endEmailDate . " " . $endEmailDateYear . ") : " . $ses_name;
           // $approver_ses_email = "chandan.pattnaik@andolasoft.co.in";
            $this->Email->delivery = 'smtp';
            $this->Email->to = $approver_ses_email;

            $this->Email->subject = $subject;
            $this->Email->from = FROM_EMAIL;
            $this->Email->template = 'approver_request';
            $this->Email->sendAs = 'html';

            $this->set('submittedByName', ($ses_name ? $ses_name : $ses_email));
            $this->set('approver_ses_name', ($approver_ses_name ? $approver_ses_name : $approver_ses_email));
            $this->set('requestedWeeklyHours', $this->Format->format_time_hr_min($requestedWeeklyHours));
            $this->set('timesheet_comment_val', $timesheet_comment_val);
            $this->set('submittedByEmail', $ses_email);
            $this->set('submittedByWeek', $startEmailDate . " - " . $endEmailDate . " " . $endEmailDateYear);
            $this->set('submittedByHour', $this->Format->format_time_hr_min($logdatas->approve_total_hours));
            try {
                if ($this->Sendgrid->sendgridsmtp($this->Email)) {
                    echo "success";
                } else {
                    echo "unsuccess";
                }
            } Catch (Exception $e) {
                echo "unsuccess";
            }
        
            /* Send Approver a notification that you are assigned with a timesheet for approval ends here */

            /* Update pending_status & approver_id fields in LogTime table for those comes under the week range as above starts here  */
             echo json_encode(array('success' => true, 'msg' => ''));
            } else {
                 echo json_encode(array('success' => false, 'msg' => __('Failed to submit the timesheet for approval.')));
            }
        }
        exit;
    }
    function timesheetReport_export(){
        $this->layout = "ajax";
        $this->loadModel('Project');
        $this->loadModel('User');
        $this->loadModel('Easycase');
        
       # echo "<pre>";print_r($this->params->data);exit;
        $data = $this->params->query;
       # echo "<pre>";print_r($data);exit;
        $report_type = $data["report_type"];
        $start_date =  $data["start_dt"];
        $end_date =  $data["end_dt"];
        //$report_type = "users";
        $date_cond = " AND `t`.`task_date` >= '" . date('Y-m-d', strtotime($start_date)) . "' AND t.`task_date` <= '" . date('Y-m-d', strtotime($end_date)) . "'";


				if(trim($report_type) == 'projects'){
					unset($data['users']);
				}else{
					unset($data['projects']);
				}
				if(!empty($data['projects'])){
					$data['projects'] = explode(',', $data['projects']);
					//rolegroup filter
					$tlg_user_lst = [];
					//role filter
					if(!empty($data['roles'])){
						$Role = ClassRegistry::init('Role');
						$tlg_user_lst = $Role->getRoleUsers(SES_COMP, $data['roles'],[],'projects');
					}else if(!empty($data['rolegroups'])){
						$RoleGroup = ClassRegistry::init('RoleGroup');
						$tlg_user_lst = $RoleGroup->getRoleUsers(SES_COMP, $data['rolegroups'],[],'projects');
					}					
					if(!empty($tlg_user_lst)){
						//Fetch  the project where these users are present
						$Project = ClassRegistry::init('Project');
						$pids = $Project->getProjectIdFromUser(SES_COMP, $tlg_user_lst, $data['projects']);
						$data['projects'] = $pids;
					}					
				}else if(!empty($data['users']) || !empty($data['rolegroups']) || !empty($data['roles'])){
					$data['users'] = !empty($data['users']) ? explode(',', $data['users']) : [];
					$tlg_user_lst = [];
					//role filter
					if(!empty($data['roles']) && trim($data['roles']) != 'null'){
						$Role = ClassRegistry::init('Role');
						$tlg_user_lst = $Role->getRoleUsers(SES_COMP, $data['roles'], $data['users'],'users');
					}else if(!empty($data['rolegroups']) && trim($data['rolegroups']) != 'null'){
						$RoleGroup = ClassRegistry::init('RoleGroup');
						$tlg_user_lst = $RoleGroup->getRoleUsers(SES_COMP, $data['rolegroups'], $data['users'],'users');
					}									
					$data['users'] = (empty($tlg_user_lst)) ? $data['users'] : $tlg_user_lst;	
				}

				$user_cond = '';
				$proj_cond = '';				
        if($report_type == "projects"){
						if(!empty($data['projects'])){
							$proj_cond = " AND t.project_id IN(".implode(',',$data['projects']).")";
						}
            $prj_sql = "SELECT User.name as username,Easycase.estimated_hours as estimated_hours,Project.name as projectname, "
                    . "SUM(Case WHEN t.is_billable = 1  THEN t.total_hours ELSE 0 END) as bill_total_hr,"
                    . "SUM(Case WHEN t.is_billable = 0  THEN t.total_hours ELSE 0 END) as non_bill_total_hr, "
                    . "SUM(Case WHEN t.pending_status = 2  THEN t.total_hours ELSE 0 END) as approve_total_hr, "
                    . "SUM(Case WHEN t.pending_status = 3  THEN t.total_hours ELSE 0 END) as reject_total_hr,"
                    . "SUM(Case WHEN t.pending_status = 1  THEN t.total_hours ELSE 0 END) as pending_total_hr "
                    . "FROM easycases as Easycase LEFT JOIN log_times as t on Easycase.id=t.task_id "
                    . "LEFT JOIN users as User on t.user_id=User.id LEFT JOIN projects as Project on t.project_id=Project.id "
                    . "WHERE Project.company_id = ".SES_COMP." AND Easycase.istype=1 ".$date_cond.$proj_cond." GROUP BY t.project_id, t.user_id ORDER BY Project.name ASC, User.name ASC";
            
            $time_list = $this->Project->query($prj_sql);
            
        } else {
						if(!empty($data['users'])){
							$user_cond = " AND t.user_id IN(".implode(',',$data['users']).")";
						}
            $usr_sql = "SELECT User.name as username,Sum(Easycase.estimated_hours) as estimated_hours,Project.name as projectname, "
                    . "SUM(Case WHEN t.is_billable = 1  THEN t.total_hours ELSE 0 END) as bill_total_hr,"
                    . "SUM(Case WHEN t.is_billable = 0  THEN t.total_hours ELSE 0 END) as non_bill_total_hr, "
                    . "SUM(Case WHEN t.pending_status = 2  THEN t.total_hours ELSE 0 END) as approve_total_hr, "
                    . "SUM(Case WHEN t.pending_status = 3  THEN t.total_hours ELSE 0 END) as reject_total_hr,"
                    . "SUM(Case WHEN t.pending_status = 1  THEN t.total_hours ELSE 0 END) as pending_total_hr "
                    . "FROM easycases as Easycase LEFT JOIN log_times as t on Easycase.id=t.task_id "
                    . "LEFT JOIN users as User on t.user_id=User.id "
                    . "LEFT JOIN projects as Project on t.project_id=Project.id "
                    . "WHERE Project.company_id = ".SES_COMP." AND Easycase.istype=1 And Easycase.isactive=1 ".$date_cond.$user_cond." GROUP BY t.user_id, t.project_id ORDER BY User.name ASC, Project.name ASC";
            $time_list = $this->Project->query($usr_sql);
        }
        $objPHPExcel = new PHPExcel();
        $objRichText = new PHPExcel_RichText();
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                ->setLastModifiedBy("Maarten Balliauw")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setSubject("Office 2007 XLSX Test Document")
                ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                ->setKeywords("office 2007 openxml php")
                ->setCategory("Test result file");
        if($report_type == "projects") {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'SL. No')
                    ->setCellValue('B1', 'Project Name')
                    ->setCellValue('C1', 'User Name')
                    ->setCellValue('D1', 'Estimated Hours')
                    ->setCellValue('E1', 'Billable Hours')
                    ->setCellValue('F1', 'Non Billable Hours')
                    ->setCellValue('G1', 'Total Hours')
					->setCellValue('H1', 'Approved Hours')
					->setCellValue('I1', 'Rejected Hours')
					->setCellValue('J1', 'Pending Hours');
        } else {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A1', 'SL. No')
                    ->setCellValue('B1', 'User Name')
                    ->setCellValue('C1', 'Project Name')
                    ->setCellValue('D1', 'Estimated Hours')
                    ->setCellValue('E1', 'Billable Hours')
                    ->setCellValue('F1', 'Non Billable Hours')
                    ->setCellValue('G1', 'Total Hours')
					->setCellValue('H1', 'Approved Hours')
					->setCellValue('I1', 'Rejected Hours')
					->setCellValue('J1', 'Pending Hours');
        }      

        $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("A1:K1")->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
                'rgb' => 'dde1e3'
            )
        ));
        $i = 1;
        $j = 2;
        $prev_proj = "";
        $prev_user = "";
        $est_hrs = 0;
        $bill_hrs = 0;
        $non_bill_hrs = 0;
        $total_hrss = 0;
		$total_approve_hrss = 0;
		$total_reject_hrss = 0;
		$total_pending_hrss = 0;
        if (is_array($time_list) && count($time_list) > 0) {
           if($report_type == "projects") {  
		   #echo "<pre>";print_r($time_list);exit;
            foreach ($time_list as $kp => $vp) {
                if($vp["User"]["username"] != '' && $vp["Project"]["projectname"] != ''){
                    $tsk_proj_est = floor($vp["0"]["estimated_hours"] / 3600) . " hrs " . floor(($vp["0"]["estimated_hours"] % 3600) / 60) . " min";
                    $est_hrs = $est_hrs + $vp["0"]["estimated_hours"];
                    $tsk_proj_bill = floor($vp[0]["bill_total_hr"] / 3600) . " hrs " . floor(($vp[0]["bill_total_hr"] % 3600) / 60) . " min";
                    $bill_hrs = $bill_hrs + $vp[0]["bill_total_hr"];
                    $tsk_proj_nonbill = floor($vp[0]["non_bill_total_hr"] / 3600) . " hrs " . floor(($vp[0]["non_bill_total_hr"] % 3600) / 60) . " min";
                    $non_bill_hrs = $non_bill_hrs + $vp[0]["non_bill_total_hr"];
                    $tot_hr =  $vp[0]["bill_total_hr"] + $vp[0]["non_bill_total_hr"];
                    $tott_hr = floor($tot_hr / 3600) . " hrs " . floor(($tot_hr % 3600) / 60) . " min";
                    $total_hrss = $total_hrss + $tot_hr;
                    $proj_name =  $prev_proj != $vp["Project"]["projectname"] ? $vp["Project"]["projectname"] : '' ;
					
					$tsk_proj_approve = floor($vp[0]["approve_total_hr"] / 3600) . " hrs " . floor(($vp[0]["approve_total_hr"] % 3600) / 60) . " min";
					$total_approve_hrss = $total_approve_hrss + $vp[0]["approve_total_hr"];
					
					$tsk_proj_reject = floor($vp[0]["reject_total_hr"] / 3600) . " hrs " . floor(($vp[0]["reject_total_hr"] % 3600) / 60) . " min";
					$total_reject_hrss = $total_reject_hrss + $vp[0]["reject_total_hr"];
					
					$tsk_proj_pending = floor($vp[0]["pending_total_hr"] / 3600) . " hrs " . floor(($vp[0]["pending_total_hr"] % 3600) / 60) . " min";
					$total_pending_hrss = $total_pending_hrss + $vp[0]["pending_total_hr"];
					$addedProjectTotalRow = 0;
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $i)
                            ->setCellValue('B' . $j,htmlspecialchars(trim($vp["Project"]["projectname"]), ENT_QUOTES, 'UTF-8', false))//$prev_proj != $vp["Project"]["projectname"] ? htmlspecialchars(trim($vp["Project"]["projectname"]), ENT_QUOTES, 'UTF-8', false) : '')
                            ->setCellValue('C' . $j, htmlspecialchars(trim($vp["User"]["username"]), ENT_QUOTES, 'UTF-8', false))
                            ->setCellValue('D' . $j, $tsk_proj_est)
                            ->setCellValue('E' . $j, $tsk_proj_bill)
                            ->setCellValue('F' . $j, $tsk_proj_nonbill)
                            ->setCellValue('G' . $j, $tott_hr)
							->setCellValue('H' . $j, $tsk_proj_approve)
							->setCellValue('I' . $j, $tsk_proj_reject)
							->setCellValue('J' . $j, $tsk_proj_pending);
                            
                    $prev_proj = $vp["Project"]["projectname"];
                    if($prev_proj != $time_list[$kp+1]['Project']['projectname']){ 
                        $tthr = floor($total_hrss / 3600) . " hrs " . floor(($total_hrss % 3600) / 60) . " min" ;
                        $tt_est = floor($est_hrs / 3600) . " hrs " . floor(($est_hrs % 3600) / 60) . " min";
                        $tt_bill = floor($bill_hrs / 3600) . " hrs " . floor(($bill_hrs % 3600) / 60) ;
                        $tt_non_bill =floor($non_bill_hrs / 3600) . " hrs " . floor(($non_bill_hrs % 3600) / 60) . " min";
						$tt_approve_bill =floor($total_approve_hrss / 3600) . " hrs " . floor(($total_approve_hrss % 3600) / 60) . " min";
						$tt_reject_bill =floor($total_reject_hrss / 3600) . " hrs " . floor(($total_reject_hrss % 3600) / 60) . " min";
						$tt_pending_bill =floor($total_pending_hrss / 3600) . " hrs " . floor(($total_pending_hrss % 3600) / 60) . " min";
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . ($j+1), $i+1)
                            ->setCellValue('B' . ($j+1), htmlspecialchars(trim($vp["Project"]["projectname"]), ENT_QUOTES, 'UTF-8', false))
                            ->setCellValue('C' . ($j+1), __("Total"))
                            ->setCellValue('D' . ($j+1),$tt_est )
                            ->setCellValue('E' . ($j+1),$tt_bill )
                            ->setCellValue('F' . ($j+1),$tt_non_bill )
                            ->setCellValue('G' . ($j+1), $tthr)
							->setCellValue('H' . ($j+1), $tt_approve_bill)
							->setCellValue('I' . ($j+1), $tt_reject_bill)
							->setCellValue('J' . ($j+1), $tt_pending_bill);
                          $est_hrs =0;  $bill_hrs =0; $non_bill_hrs = 0; $total_hrss = 0; $total_approve_hrss = 0; $total_reject_hrss = 0; $total_pending_hrss = 0;
						  $addedProjectTotalRow = 1;
                    }
                	
					if($addedProjectTotalRow == 1){
	                    $i = $i + 2;
	                    $j = $j + 2;
					}else{
						$i++;
	                    $j++;
					}
                }
            }
           } else {
              # echo "<pre>";print_r($time_list);exit;
               foreach ($time_list as $kp => $vp) {
                if($vp["User"]["username"] != '' && $vp["Project"]["projectname"] != ''){
                    $tsk_proj_est = floor($vp["0"]["estimated_hours"] / 3600) . " hrs " . floor(($vp["0"]["estimated_hours"] % 3600) / 60) . " min";
                    $est_hrs = $est_hrs + $vp["0"]["estimated_hours"];
                    $tsk_proj_bill = floor($vp[0]["bill_total_hr"] / 3600) . " hrs " . floor(($vp[0]["bill_total_hr"] % 3600) / 60) . " min";
                    $bill_hrs = $bill_hrs + $vp[0]["bill_total_hr"];
                    $tsk_proj_nonbill = floor($vp[0]["non_bill_total_hr"] / 3600) . " hrs " . floor(($vp[0]["non_bill_total_hr"] % 3600) / 60) . " min";
                    $non_bill_hrs = $non_bill_hrs + $vp[0]["non_bill_total_hr"];
                    $tot_hr =  $vp[0]["bill_total_hr"] + $vp[0]["non_bill_total_hr"];
                    $tott_hr = floor($tot_hr / 3600) . " hrs " . floor(($tot_hr % 3600) / 60) . " min";
                    $total_hrss = $total_hrss + $tot_hr;
					
					$tsk_proj_approve = floor($vp[0]["approve_total_hr"] / 3600) . " hrs " . floor(($vp[0]["approve_total_hr"] % 3600) / 60) . " min";
					$total_approve_hrss = $total_approve_hrss + $vp[0]["approve_total_hr"];
					
					$tsk_proj_reject = floor($vp[0]["reject_total_hr"] / 3600) . " hrs " . floor(($vp[0]["reject_total_hr"] % 3600) / 60) . " min";
					$total_reject_hrss = $total_reject_hrss + $vp[0]["reject_total_hr"];
					
					$tsk_proj_pending = floor($vp[0]["pending_total_hr"] / 3600) . " hrs " . floor(($vp[0]["pending_total_hr"] % 3600) / 60) . " min";
					$total_pending_hrss = $total_pending_hrss + $vp[0]["pending_total_hr"];
					$addedUserTotalRow = 0;
                  //  $proj_name =  $prev_user != $vp["Project"]["projectname"] ? $vp["Project"]["projectname"] : '' ;
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $j, $i)
                            ->setCellValue('B' . $j,htmlspecialchars(trim($vp["User"]["username"]), ENT_QUOTES, 'UTF-8', false))//$prev_user != $vp["User"]["username"] ? htmlspecialchars(trim($vp["User"]["username"]), ENT_QUOTES, 'UTF-8', false) : '')
                            ->setCellValue('C' . $j, htmlspecialchars(trim($vp["Project"]["projectname"]), ENT_QUOTES, 'UTF-8', false))
                            ->setCellValue('D' . $j, $tsk_proj_est)
                            ->setCellValue('E' . $j, $tsk_proj_bill)
                            ->setCellValue('F' . $j, $tsk_proj_nonbill)
                            ->setCellValue('G' . $j, $tott_hr)
							->setCellValue('H' . $j, $tsk_proj_approve)
							->setCellValue('I' . $j, $tsk_proj_reject)
							->setCellValue('J' . $j, $tsk_proj_pending);
                            
                    $prev_user = $vp["User"]["username"];
                    if(($vp["User"]["username"] != $time_list[$kp+1]['User']['username']) || !isset($time_list[$kp+1]['User']['username'])){ 
                        $tthr = floor($total_hrss / 3600) . " hrs " . floor(($total_hrss % 3600) / 60) . " min" ;
                        $tt_est = floor($est_hrs / 3600) . " hrs " . floor(($est_hrs % 3600) / 60) . " min";
                        $tt_bill = floor($bill_hrs / 3600) . " hrs " . floor(($bill_hrs % 3600) / 60) ;
                        $tt_non_bill =floor($non_bill_hrs / 3600) . " hrs " . floor(($non_bill_hrs % 3600) / 60) . " min";
                        $tt_approve_bill =floor($total_approve_hrss / 3600) . " hrs " . floor(($total_approve_hrss % 3600) / 60) . " min";
                        $tt_reject_bill =floor($total_reject_hrss / 3600) . " hrs " . floor(($total_reject_hrss % 3600) / 60) . " min";
                        $tt_pending_bill =floor($total_pending_hrss / 3600) . " hrs " . floor(($total_pending_hrss % 3600) / 60) . " min";
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . ($j+1), $i+1)
                            ->setCellValue('B' . ($j+1), htmlspecialchars(trim($vp["User"]["username"]), ENT_QUOTES, 'UTF-8', false))
                            ->setCellValue('C' . ($j+1), __("Total"))
                            ->setCellValue('D' . ($j+1),$tt_est )
                            ->setCellValue('E' . ($j+1),$tt_bill )
                            ->setCellValue('F' . ($j+1),$tt_non_bill )
                            ->setCellValue('G' . ($j+1), $tthr)
							->setCellValue('H' . ($j+1), $tt_approve_bill)
							->setCellValue('I' . ($j+1), $tt_reject_bill)
							->setCellValue('J' . ($j+1), $tt_pending_bill);
						  $est_hrs =0;  $bill_hrs =0; $non_bill_hrs = 0; $total_hrss = 0; $total_approve_hrss = 0; $total_reject_hrss = 0; $total_pending_hrss = 0;
						  $addedUserTotalRow = 1;
                    }
                
                    if($addedUserTotalRow == 1){
	                    $i = $i + 2;
	                    $j = $j + 2;
					}else{
						$i++;
	                    $j++;
					}
                }
            }
           }
        }
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . ($j+1), __("Export Date", true));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . ($j+1), date('Y-m-d', strtotime(GMT_DATETIME)));
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . ($j+2), __("Search Date Range", true));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . ($j+2), date('Y-m-d', strtotime($start_date)) . " - " . date('Y-m-d', strtotime($end_date)));
             
        $objPHPExcel->getActiveSheet()->setTitle('Timesheet Report Information');
        $filename = "Timesheet_Report_By_".ucfirst($report_type)."(" . gmdate('D, d M Y H:i:s') . ")";
        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }
}