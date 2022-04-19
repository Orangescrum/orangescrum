<?php

class LogTime extends AppModel
{
    public $name = 'LogTime';
    public $primaryKey = 'log_id';
    public $virtualFields = array(
        'hours' => "ROUND(LogTime.total_hours/3600,1)"
    );

    public function updateWeeklyTimeStatus($rowid,$userid, $status, $start_day, $end_day,$timesheetAppovalDetail)
    {
            $data = array();
            $arr=array();
            $approverStatus = $status;
            $dataApproverId = SES_ID;
            $datauserId = $userid;
            $project_id = rtrim($timesheetAppovalDetail['TimesheetApprovalDetail']['project_ids'],',');
            $this->query("update log_times set pending_status='" . $approverStatus . "',
                approver_id='" . $dataApproverId . "' where project_id IN (".$project_id.") AND user_id='" . $datauserId . "' AND task_date >= '"
            . $start_day . "' AND task_date <= '"  . $end_day . "' AND pending_status >= 1");

            $aar['approver_record_id'] =$rowid;
            $aar['request_user_id'] = $datauserId; 
            $aar['approver_id'] = $datauserId;
            $aar['status'] = $approverStatus;
            $aar['created'] = GMT_DATETIME;
            $TimesheetApprovalLog = ClassRegistry::init('TimesheetApprovalLog');
            if(!$TimesheetApprovalLog->save($aar)){
                $res = false;
            }else{
                $res = true;
            }
          
            return $res;
           
    }
    
    public function getProjectUserList($date_cond,$limit,$offset,$report_type, $usr_proj = []){
        $tids = array();
        if($report_type == "projects"){
					$usrprj_cond = (!empty($usr_proj)) ? " AND t.project_id IN(".implode(',',$usr_proj).") " : "";
            if($limit == 0 && $offset == 0){
                $sql = "SELECT DISTINCT t.project_id from log_times as t "
                        . "LEFT JOIN projects as Project On t.project_id = Project.id "
                        . "WHERE Project.company_id =".SES_COMP." ".$date_cond.$usrprj_cond." Order by Project.name ASC";
            } else{
              $sql = "SELECT DISTINCT t.project_id from log_times as t "
                      . "LEFT JOIN projects as Project On t.project_id = Project.id "
                      . "WHERE Project.company_id =".SES_COMP." ".$date_cond.$usrprj_cond." Order by Project.name ASC LIMIT $offset, $limit";  
            }
            
            $tlg_list = $this->query($sql);
            if($tlg_list){
                $tids = Hash::extract($tlg_list, '{n}.t.project_id');
            }
            //$tlg_list = $this->find('list',array('conditions'=>array('task_date >='=>date('Y-m-d', strtotime($start_date)),'task_date <='=>date('Y-m-d', strtotime($end_date)))));
        } else {
					$usrprj_cond = (!empty($usr_proj)) ? " AND t.user_id IN(".implode(',',$usr_proj).") " : "";
            if($limit == 0 && $offset == 0){
                $sql = "SELECT DISTINCT t.user_id from log_times as t "
                        . "LEFT JOIN users as User On t.user_id = User.id "
                        . "LEFT JOIN projects as Project On t.project_id = Project.id "
                        . "WHERE Project.company_id =".SES_COMP." ".$date_cond.$usrprj_cond." Order by User.name ASC";
            } else{
                $sql = "SELECT DISTINCT t.user_id from log_times as t "
                        . "LEFT JOIN users as User On t.user_id = User.id "
                        . "LEFT JOIN projects as Project On t.project_id = Project.id "
                        . "WHERE Project.company_id =".SES_COMP." ".$date_cond.$usrprj_cond." Order by User.name ASC LIMIT $offset, $limit";
            }
            $tlg_list = $this->query($sql);
            if($tlg_list){
             $tids = Hash::extract($tlg_list, '{n}.t.user_id');
            }
        }
       return $tids;
    //    echo "<pre>";print_r($tlg_list);exit;
        
    }

    /*
    *
    Author:C Pattnaik
    function to show the timesheet chart in timesheet chart report
    */
    public function fetchTimesheetChartReport($start_date,$end_date,$client_sts, $usrproj_cond=[], $is_proj=0) {
        
        $clt_sql = "";
        if ($client_sts == 1) {
            $clt_sql = " AND ((Easycase.client_status = :is_client AND Easycase.user_id = :auth_user_id) OR Easycase.client_status != :is_client) ";
        }
        #$dateCond = " AND `LogTime`.`start_datetime` >= :start_date AND `LogTime`.`start_datetime` < :end_date ";
        $dateCond = " AND `LogTime`.`task_date` >= :start_date AND `LogTime`.`task_date` <= :end_date ";
     
				if(!empty($usrproj_cond)){
					if($is_proj){
						$usrprj_cond = (!empty($usrproj_cond)) ? " AND LogTime.project_id IN(".implode(',',$usrproj_cond).") " : "";
					}else{
						$usrprj_cond = (!empty($usrproj_cond)) ? " AND LogTime.user_id IN(".implode(',',$usrproj_cond).") " : "";
					}					
				}
	
        $count_sql = 'SELECT sum(total_hours) as secds,is_billable '
                . 'FROM log_times AS `LogTime` '
                . "INNER JOIN easycases AS Easycase ON Easycase.id=LogTime.task_id AND LogTime.project_id=Easycase.project_id "
                . 'INNER JOIN projects AS Project ON Easycase.project_id=Project.id WHERE is_billable IN(0, 1) AND Easycase.isactive =1 AND Project.isactive=1 AND Project.company_id=:company_id ' . $clt_sql . $dateCond .$usrprj_cond. '  '
                . 'GROUP BY LogTime.start_datetime  '
                ;
        $db = $this->getDataSource();
        if ($client_sts == 1) {
            $res = $db->fetchAll(
                $count_sql,
                array('auth_user_id' => SES_ID,'is_client'=>$client_sts,'company_id' => SES_COMP,'start_date'=>$start_date,'end_date'=>$end_date)
            );
        } else{
                $res = $db->fetchAll(
                    $count_sql,
                    array('company_id' => SES_COMP,'start_date'=>$start_date,'end_date'=>$end_date)
                );
                //$db = ConnectionManager::getDataSource('default');
								//$db->showLog();
        }        
        return $res;
    }
		
		public function getBookedHours($input, $cur_view_type=1)
		{
			$TimezoneName = ClassRegistry::init('TimezoneName');
			$tmz=$TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
			$tmz=  str_replace(array("GMT","(",")"), "", $tmz);
			$gmt_val = "+00:00";
			#pr($input);exit;
			$inputArr = [
				'start_date' => $input['start_date'],
				'end_date' => $input['end_date'],
				'company_id' => $input['company_id']
			];
			//project filter
			$qry = '';
			if(!empty($input['pids'])){
				$pids = implode(',', $input['pids']);
				$qry = " AND pbr.project_id IN(".$pids.") ";
			}
			if(!empty($input['task_ids'])){
				$ecids = implode(',', $input['task_ids']);
				$qry = " AND pbr.easycase_id IN(".$ecids.") ";
			}
			//resource filter
			/*$qryUsr = '';
			if(!empty($input['user_id'])){
				$uids = implode(',',$input['user_id']);
				$qryUsr =" AND (Easycase.assign_to IN(".$uids.") OR Logtm.user_id IN(".$uids.")) ";
			}*/			
		
			$sql = "SELECT 
								SUM(pbr.booked_hours) AS estd_hours,
								pbr.easycase_id AS task_id,
								pbr.user_id AS uid,
								DATE_FORMAT(CONVERT_TZ(pbr.date,'$gmt_val','$tmz'),'%Y-%m-%d') as pbr_date,
								pbr.date
							FROM project_booked_resources AS pbr
							WHERE 
								pbr.company_id=:company_id
								AND pbr.date BETWEEN :start_date AND :end_date ".$qry."
							GROUP BY pbr.easycase_id,pbr.date";
								
			$db = $this->getDataSource();							
			$res = $db->fetchAll($sql, $inputArr);
			$retRes = [];
			if(!empty($res)){
				foreach($res as $k => $v){
					$week_number_pbr = (int)date('W', strtotime($v[0]['pbr_date']));
					if($cur_view_type ==3){
						$week_number_pbr = (int)date('m', strtotime($v[0]['pbr_date']));
					}
					if($week_number_pbr){
						#$week_number_pbr = ($week_number_pbr == 52) ? 0 : $week_number_pbr;
						if(isset($retRes[$v['pbr']['uid']][$week_number_pbr])){
							$retRes[$v['pbr']['uid']][$week_number_pbr]['hours'] += $v[0]['estd_hours'];
						}else{
							//new record
							$retRes[$v['pbr']['uid']][$week_number_pbr]['hours'] = $v[0]['estd_hours'];
						}
					}
				}
			}
			
			return $retRes;
		}
		
		public function getOverloadHours($input, $cur_view_type=1)
		{
			$TimezoneName = ClassRegistry::init('TimezoneName');
			$tmz=$TimezoneName->field('gmt', array('id' => SES_TIMEZONE));
			$tmz=  str_replace(array("GMT","(",")"), "", $tmz);
			$gmt_val = "+00:00";
			#pr($input);exit;
			$inputArr = [
				'start_date' => $input['start_date'],
				'end_date' => $input['end_date'],
				'company_id' => $input['company_id']
			];
			//project filter
			$qry = '';
			if(!empty($input['pids'])){
				$pids = implode(',', $input['pids']);
				$qry = " AND ovr.project_id IN(".$pids.") ";
			}
			if(!empty($input['task_ids'])){
				$ecids = implode(',', $input['task_ids']);
				$qry = " AND ovr.easycase_id IN(".$ecids.") ";
			}
			$sql = "SELECT 
								SUM(ovr.overload) AS estd_hours,
								ovr.easycase_id AS task_id,
								ovr.user_id AS uid,
								DATE_FORMAT(CONVERT_TZ(ovr.date,'$gmt_val','$tmz'),'%Y-%m-%d') as ovr_date
							FROM overloads AS ovr
							WHERE 
								ovr.company_id =:company_id 
								AND ovr.date BETWEEN :start_date AND :end_date ".$qry."
							GROUP BY 
								ovr.user_id,ovr.date";
								
			$db = $this->getDataSource();							
			$res = $db->fetchAll($sql, $inputArr);
			$retRes = [];
			if(!empty($res)){
				foreach($res as $k => $v){
					$week_number_pbr = (int)date('W', strtotime($v[0]['ovr_date']));
					if($cur_view_type ==3){
						$week_number_pbr = (int)date('m', strtotime($v[0]['ovr_date']));
					}
					if($week_number_pbr){
						#$week_number_pbr = ($week_number_pbr == 52) ? 0 : $week_number_pbr;
						if(isset($retRes[$v['ovr']['uid']][$week_number_pbr])){
							$retRes[$v['ovr']['uid']][$week_number_pbr]['hours'] += $v[0]['estd_hours'];
						}else{
							//new record
							$retRes[$v['ovr']['uid']][$week_number_pbr]['hours'] = $v[0]['estd_hours'];
						}
					}
				}
			}
			
			return $retRes;
		}
}