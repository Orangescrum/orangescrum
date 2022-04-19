<?php
class SearchFilter extends AppModel {

    var $name = 'SearchFilter';
   function getDefault(){
         $User = ClassRegistry::init('User'); 
         /*
          * Display the notifications of search filter to the users who are registred before 2016-06-10 not show to teh new customers
          */
        $userCount=$User->find('count',array('conditions'=>array('User.id'=>SES_ID,'User.dt_created <= '=>'2016-06-10 00:00:00')));
        if($userCount){ 
        $sfarray=$this->find('count',array('conditions'=>array('SearchFilter.user_id'=>SES_ID,'SearchFilter.name'=>'default','SearchFilter.first_records'=>1)));
        }else{
            $sfarray=2;
        }
        return $sfarray;
   } 
   function getFiltersWithCounts($data){
        $sfarray=$this->find('all',array('conditions'=>array('SearchFilter.user_id'=>SES_ID,'SearchFilter.company_id'=>SES_COMP ,'SearchFilter.name != '=>'default'))); 
        foreach($sfarray as $k=>$v){
			$arr=json_decode($v['SearchFilter']['json_array'], true);   
            $sfarray[$k]['SearchFilter']['namewithcount']='<span class="wrap_title_txt">'.$v['SearchFilter']['name'].'</span> <span class="csn_flt_count">('.$this->getCount($arr,$data['projUniq'],$data['milestoneIds'],$data['case_srch'],$data['checktype']).')</span>';
        }
        return $sfarray;
   }
       function getCount($data,$prjUniqIdCsMenu,$milestoneIds,$case_srch,$checktype){
            $qry='';
          //Filter Condition added in Menu filters counters
//            $caseMenuFilters =$_COOKIE['CURRENT_FILTER'];
            $caseMenuFilters =$_SESSION['CURRENT_FILTER'];
		$caseStatus = (isset($data['STATUS']) && !empty($data['STATUS'])) ? $data['STATUS'] : ''; // Filter by Status(legend)
		$caseCustomStatus = (isset($data['CUSTOM_STATUS']) && !empty($data['CUSTOM_STATUS'])) ? $data['CUSTOM_STATUS'] : ''; // Filter by Status(legend)
		$priorityFil = (isset($data['PRIORITY']) && !empty($data['PRIORITY'])) ? $data['PRIORITY'] : ''; // Filter by Priority
		$caseTypes = (isset($data['CS_TYPES']) && !empty($data['CS_TYPES'])) ? $data['CS_TYPES'] : '';// Filter by case Types            
		$caseLabel = (isset($data['TASKLABEL']) && !empty($data['TASKLABEL'])) ? $data['TASKLABEL'] : '';// Filter by case Label            
		$caseUserId = (isset($data['MEMBERS']) && !empty($data['MEMBERS'])) ? $data['MEMBERS'] : ''; // Filter by Member
		$caseComment = (isset($data['COMMENTS']) && !empty($data['COMMENTS'])) ? $data['COMMENTS'] : '';// Filter by Member		
		$caseAssignTo = (isset($data['ASSIGNTO']) && !empty($data['ASSIGNTO'])) ? $data['ASSIGNTO'] : '';// Filter by AssignTo
		@$case_date = (isset($data['DATE']) && !empty($data['DATE'])) ? urldecode($data['DATE']) : ''; // Filter by date
		@$case_duedate = (isset($data['DUE_DATE']) && !empty($data['DUE_DATE'])) ? $data['DUE_DATE'] : ''; // Filter by due_date
            @$case_srch = $case_srch;
            $milestoneIds = $milestoneIds;
            $checktype = $checktype;
            App::import('Component','Format');
            $format = new FormatComponent(new ComponentCollection);
            ######### Filter by Case Types ##########
            if ($caseTypes && $caseTypes != "all") {
                $qry.= $format->typeFilter($caseTypes);
            }
            ######### Filter by Priority ##########
            if ($priorityFil && $priorityFil != "all") {
                $qry.= $format->priorityFilter($priorityFil, $caseTypes);
            }
		$is_def_status_enbled = 0;
            ######### Filter by Status ##########
		if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
			$is_def_status_enbled = 1;
			$qry.= " AND (";
			$qry.= $format->customStatusFilter($caseCustomStatus, $projUniq,$caseStatus, 1);
		}		
		######### Filter by Status ###########
		if (trim($caseStatus) && $caseStatus != "all") {
			if(!$is_def_status_enbled){
				$qry.= " AND (";	
			}else{
				$qry.= " OR ";
			}
			$qry.= $format->statusFilter($caseStatus, '',1);
			$qry .= ")";	
		}else{
			if (trim($caseCustomStatus) && $caseCustomStatus != "all") {
				$qry .= ")";	
			}
		}
		######### Filter by Member ##########
		if ($caseUserId && $caseUserId != "all") {
				$qry.= $format->memberFilter($caseUserId);
		}
            ######### Filter by AssignTo ##########		/* Added by smruti on 08082013*/
            if ($caseAssignTo && $caseAssignTo != "all" && $caseAssignTo != 'unassigned') {
                $qry.= $format->assigntoFilter($caseAssignTo);
            } else if ($caseAssignTo && $caseAssignTo == 'unassigned') {
                $qry.= " AND Easycase.assign_to=0";
            }
            ######### Search by KeyWord ##########
		/*$searchcase = "";
            if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
                $qry = "";
                $searchcase = $format->caseKeywordSearch($caseSrch, 'full');
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
		}*/

		if (!empty($case_date)) {
				if((SES_COMP == 25814 || SES_COMP == 28528 || SES_COMP == 1358) && (trim($caseComment) && $caseComment != "all")){
						// Modified for jayan (if date filter with commented by filter is applied then now apply the date filter in the parent task)
				}else{
               App::import('Component','Tmzone');
				$Tmzone = new TmzoneComponent(new ComponentCollection);
				$frmTz = '+00:00';
				$toTz = $Tmzone->getGmtTz(TZ_GMT, TZ_DST);
				$GMT_DATE =$Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                if (trim($case_date) == 'one') {
						$one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
						$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
                } else if (trim($case_date) == '24') {
						$day_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE. " -1 day"));
						$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
					} elseif (trim($case_date) == 'today') {
                        $from_d = date("Y-m-d 00:00:00", strtotime($GMT_DATE));
                    $to_d = date("Y-m-d 23:59:59", strtotime($GMT_DATE));
                    $qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d H:i:s', strtotime($from_d)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d H:i:s', strtotime($to_d)) . "'";
                  
                    }
					 else if (trim($case_date) == 'week') {
						$week_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE . " -1 week"));
						$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
                } else if (trim($case_date) == 'month') {
						$month_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE . " -1 month"));
						$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
                } else if (trim($case_date) == 'year') {
					$year_date = date("Y-m-d H:i:s", strtotime( $GMT_DATE . " -1 year"));
						$qry.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
                } else if (strstr(trim($case_date), ":")) {
                    $ar_dt = explode(":", trim($case_date));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
						//$qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
						$qry.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
				
					}
                }
            }
            if (trim($case_duedate) != "") {
				App::import('Component','Tmzone');
				$Tmzone = new TmzoneComponent(new ComponentCollection);
				$frmTz = '+00:00';
				$toTz = $Tmzone->getGmtTz(TZ_GMT, TZ_DST);
				$GMT_DATE =$Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                if (trim($case_duedate) == '24') {
                    $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
						$qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
                } else if (trim($case_duedate) == 'overdue') {
                    $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
						$qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (Easycase.legend !=3)";
                } else if (strstr(trim($case_duedate), ":")) {
                    //echo $case_duedate;exit;
                    $ar_dt = explode(":", trim($case_duedate));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
						$qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }
            
            if ($prjUniqIdCsMenu != 'all' && trim($prjUniqIdCsMenu)) {
                $Project=ClassRegistry::init('Project');
                $Project->recursive = -1;
                $projArr = $Project->find('first', array('conditions' => array('Project.uniq_id' => $prjUniqIdCsMenu, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.id')));
                    if (count($projArr)) {
                    $proj_id = $projArr['Project']['id'];
						$qry.= " AND Easycase.project_id=".$proj_id." ";
                }            
            }else{
                $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('DISTINCT Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));

                    $ProjectUser = ClassRegistry::init('ProjectUser');
                    $ProjectUser->unbindModel(array('belongsTo' => array('User')));
                    $ProjectUser->bindModel(array('belongsTo' => array('Project')));
                    $allProjArr = $ProjectUser->find('all', $cond);

                    $ids = array();
                    $idlist = '';
                    foreach ($allProjArr as $csid) {
                        $idlist .='\'' . $csid['Project']['id'] . '\',';
                        array_push($ids, $csid['Project']['id']);
                    }
                                $idlist = trim($idlist, ',');
                                if($idlist != ''){
                                        $qry.= " AND Easycase.project_id IN(" . $idlist . ")";
                                }
            }
            
            $Easycase=ClassRegistry::init('Easycase');
              ######### Filter by Member ##########
            if ($caseComment && $caseComment != "all") {
				$qry.= $format->commentFilter($caseComment,$proj_id,$case_date);
            }
			######### Filter by Case Label ##########
            if ($caseLabel && $caseLabel != "all") {
                $qry.= $format->labelFilter($caseLabel, $proj_id, SES_COMP, SES_TYPE, SES_ID);
            }
		if (isset($data['TASKGROUP']) && !empty($data['TASKGROUP']) && $data['TASKGROUP'] != "all") {
				$qry.= $format->taskgroupFilter($data['TASKGROUP']);
		}
           # print "SELECT count(*) as cnt FROM easycases as Easycase WHERE Easycase.isactive=1 AND Easycase.istype= 1  ".$qry;exit;
            $clt_sql = 1;
            $auth = new AuthComponent(new ComponentCollection);
            if ($auth->user('is_client') == 1) {
                $clt_sql = "((Easycase.client_status = " . $auth->user('is_client') . " AND Easycase.user_id = " . $auth->user('id') . ") OR Easycase.client_status != " . $auth->user('is_client') . ")";
            }
		$cnt= $Easycase->query("SELECT count(*) as cnt FROM easycases as Easycase LEFT JOIN easycase_milestones EasycaseMilestone on Easycase.id = EasycaseMilestone.easycase_id WHERE Easycase.isactive=1 AND Easycase.istype= 1  AND ".$clt_sql." ".$qry);
            if($cnt){
                 return $cnt[0][0]['cnt'];
            }else{
                return 0;
            }
    }
}