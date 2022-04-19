<?php

class Easycase extends AppModel
{
    public $name = 'Easycase';
    public $virtualFields = array(
        'srttitle' => "IF(LENGTH(Easycase.title) > 90, CONCAT(SUBSTRING(Easycase.title,1,90),'...'), Easycase.title)"
    );
    public function checktask($cas_id)
    {
        return $this->find('count', array('conditions'=>array('Easycase.id'=>$cas_id,'Easycase.istype'=>1)));
    }
    public function updateEcThreadCount($formatData = null)
    {
        $updEcArr = null;
        if ($formatData && $formatData['CS_id']) {
            $formatData['allFiles'] = array_filter($formatData['allFiles']);
            if (!empty($formatData['allFiles']) || !empty($formatData['CS_message'])) {
                $this->updateAll(array('Easycase.thread_count'=>'Easycase.thread_count+1','Easycase.case_count'=>'Easycase.case_count+1'), array('Easycase.id'=>$formatData['CS_id']));
            }
        }
    }
    public function getStatusFortasks($tasks, $chk_flg=0)
    {
        $csts_arr = array();
        //custom status ref for other pages
        if ($chk_flg == 1) {
            $sts_ids = array_filter(array_unique(Hash::extract($tasks, '{n}.Result.custom_status_id')));
        } elseif ($chk_flg == 2) {
            $sts_ids = array_filter(array_unique(Hash::extract($tasks, '{n}.res.custom_status_id')));
        } else {
            $sts_ids = array_filter(array_unique(Hash::extract($tasks, '{n}.Easycase.custom_status_id')));
        }
        if ($sts_ids) {
            $Csts = ClassRegistry::init('CustomStatus');
            $csts_arr = $Csts->find('all', array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
            if ($csts_arr) {
                $csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
            }
        }
        return $csts_arr;
    }
    public function getDuedtDiffernce($oriduedt,$currentduedt){
        if (($currentduedt != "1970-01-01") && (($oriduedt != "--") && ($oriduedt != "1970-01-01"))) {
            $currentduedt = new DateTime($currentduedt);
            $oriduedt = new DateTime($oriduedt);
            $timeBalance= date_diff($oriduedt,$currentduedt);
            if ($timeBalance->invert == 1) {
                if ($timeBalance->d == 0 && $timeBalance->h != 0) {
                    $timeBalanceRemaining = $timeBalance->format('%h hours ahead');
                } elseif ($timeBalance->d != 0 && $timeBalance->h == 0) {
                    $timeBalanceRemaining = $timeBalance->format('%a days ahead');
                } elseif ($timeBalance->d == 0 && $timeBalance->h == 0) {
                    $timeBalanceRemaining = '0 days';
                } else {
                    $timeBalanceRemaining = $timeBalance->format('%a days %h hours ahead');
                }
            } else {
                if ($timeBalance->d == 0 && $timeBalance->h != 0) {
                    $timeBalanceRemaining = $timeBalance->format('%h hours');
                } elseif ($timeBalance->d != 0 && $timeBalance->h == 0) {
                   
                    $timeBalanceRemaining = $timeBalance->format('%a days');
                } elseif ($timeBalance->d == 0 && $timeBalance->h == 0) {
                    $timeBalanceRemaining = '0 days';
                } else {
                    $timeBalanceRemaining = $timeBalance->format('%a days %h hours');
                }
            }
        }else{
            $timeBalanceRemaining = "--";
        }
           return $timeBalanceRemaining;

    }
    public function getTimeBalance($taskData, $allActiveFields)
    {
        $tb_key = 0;
        foreach ($allActiveFields as $k => $v) {
            if ($v == 'Time Balance Remaining') {
                $tb_key = $k;
                break;
            }
        }
        if (!empty($taskData['due_date']) && $taskData['legend'] != 3) {
            // $currDateTime = date("Y-m-d H:i:s");
            $currDateTime = GMT_DATETIME;
            $currentDate = new DateTime($currDateTime);
            if($taskData['due_date'] == '0000-00-00 00:00:00'){
                $timeBalanceRemaining = '--';
            }else{
            $dueDate = new DateTime($taskData['due_date']);
            $timeBalance= date_diff($currentDate, $dueDate);
            if ($timeBalance->invert == 1) {
                if($allActiveFields == []){
                    if($timeBalance->d == 0 && $timeBalance->h != 0){
                        $timeBalanceRemaining = $timeBalance->format('%h hours over');
                    }else if($timeBalance->d != 0 && $timeBalance->h == 0){
                         $timeBalanceRemaining = $timeBalance->format('%a days over');
                    }else if($timeBalance->d == 0 && $timeBalance->h == 0){
                        $timeBalanceRemaining = '0 days';
                    }else{
                        $timeBalanceRemaining = $timeBalance->format('%a days over');
                    } 
                    $tb_key = "over";
                }else{
                if ($timeBalance->d == 0 && $timeBalance->h != 0) {
                    $timeBalanceRemaining = $timeBalance->format('-%h hours');
                } elseif ($timeBalance->d != 0 && $timeBalance->h == 0) {
                    $timeBalanceRemaining = $timeBalance->format('-%a days');
                } elseif ($timeBalance->d == 0 && $timeBalance->h == 0) {
                    $timeBalanceRemaining = '--';
                } else {
                    $timeBalanceRemaining = $timeBalance->format('-%a days %h hours');
                }
                }
            } else {
                if($allActiveFields == []){
                    if($timeBalance->d == 0 && $timeBalance->h != 0){
                        $timeBalanceRemaining = $timeBalance->format('%h hours left');
                    }else if($timeBalance->d != 0 && $timeBalance->h == 0){
                        $timeBalanceRemaining = $timeBalance->format('%a days left');
                    }else if($timeBalance->d == 0 && $timeBalance->h == 0){
                        $timeBalanceRemaining = '0 days';
                    } else {
                        $timeBalanceRemaining = $timeBalance->format('%a days left');
                    }
                    $tb_key = "left";
            } else {
                if ($timeBalance->d == 0 && $timeBalance->h != 0) {
                    $timeBalanceRemaining = $timeBalance->format('%h hours');
                } elseif ($timeBalance->d != 0 && $timeBalance->h == 0) {
                    $timeBalanceRemaining = $timeBalance->format('%a days');
                } elseif ($timeBalance->d == 0 && $timeBalance->h == 0) {
                    $timeBalanceRemaining = '--';
                } else {
                    $timeBalanceRemaining = $timeBalance->format('%a days %h hours');
                }
            }
            }
        }
        } else {
            $timeBalanceRemaining = '--';
        }

        // pr($timeBalanceRemaining);exit;
        return [$tb_key, $timeBalanceRemaining];
    }

    public function getDurationOfTask($taskData, $allActiveFields)
    {
        $tb_key = 0;
        foreach ($allActiveFields as $k => $v) {
            if ($v == 'Duration Of Task') {
                $tb_key = $k;
                break;
            }
        }
        if (!empty($taskData['due_date'])) {
            if (!empty($taskData['gantt_start_date'])) {
                $currentDate = new DateTime($taskData['gantt_start_date']);
            } else {
                $currentDate = new DateTime($taskData['actual_dt_created']);
            }
            // $currDateTime = GMT_DATETIME;
            // $currentDate = new DateTime($currDateTime);
            if($taskData['due_date'] == '0000-00-00 00:00:00'){
                // pr('sweta'); exit;
                $durationTaskRemaining = '--';
            }else{
                // pr('swetalina'); exit;
            $dueDate = new DateTime($taskData['due_date']);
            $durationTask= date_diff($currentDate, $dueDate);
            if ($durationTask->invert == 1) {
                if ($durationTask->d == 0 && $durationTask->h != 0) {
                    $durationTaskRemaining = $durationTask->format('-%h hours');
                } elseif ($durationTask->d != 0 && $durationTask->h == 0) {
                    $durationTaskRemaining = $durationTask->format('-%a days');
                } elseif ($durationTask->d == 0 && $durationTask->h == 0) {
                    $durationTaskRemaining = '--';
                } else {
                    $durationTaskRemaining = $durationTask->format('-%a days %h hours');
                }
            } else {
                if ($durationTask->d == 0 && $durationTask->h != 0) {
                    $durationTaskRemaining = $durationTask->format('%h hours');
                } elseif ($durationTask->d != 0 && $durationTask->h == 0) {
                    $durationTaskRemaining = $durationTask->format('%a days');
                } elseif ($durationTask->d == 0 && $durationTask->h == 0) {
                    $durationTaskRemaining = '--';
                } else {
                    $durationTaskRemaining = $durationTask->format('%a days %h hours');
                }
            }
                    }
        } else {
            $durationTaskRemaining = '--';
        }
        return [$tb_key, $durationTaskRemaining];
    }
    public function formatCases($caseAll, $caseCount, $caseMenuFilters, $closed_cases, $milestones, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, $chk = null, $dependency = array(), $short = 0, $AllCustomFields=[], $allActiveFields=[])
    {
        $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $curdtT = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
        $curTime = date('H:i:s', strtotime($curCreated));

        if (count($caseAll) > 0) { //$caseCount
            $chkDateTime = $chkDateTime1 = $projIdcnt = $newpjcnt = $repeatcaseTypeId = $repeatLastUid = $repeatAssgnUid = "";
            $pjname = '';
            $sql = "SELECT Type.* FROM types AS Type WHERE Type.company_id = 0 OR Type.company_id =" . SES_COMP;
            $typeArr = $this->query($sql);
            
            $ecs_esc_ids = Hash::extract($caseAll, '{n}.Easycase.id');
            $pro_ids = Hash::extract($caseAll, '{n}.Easycase.project_id');
            if ($caseMenuFilters != 'milestone') {
                $rplyFilesArr = $this->getCaseFiles($ecs_esc_ids);
            }
            $EasycaseFavourite = ClassRegistry::init('EasycaseFavourite');
            $favouriteconditions = array('EasycaseFavourite.easycase_id'=>$ecs_esc_ids,'EasycaseFavourite.project_id'=>$pro_ids,'EasycaseFavourite.company_id'=>SES_COMP,'EasycaseFavourite.user_id'=>SES_ID);
            $easycase_favourite = $EasycaseFavourite->find('list', array('fields'=>array('EasycaseFavourite.easycase_id','EasycaseFavourite.id'),'conditions'=>$favouriteconditions));
            
            $csts_arr = array();
            //custom status ref for other pages
            $sts_ids = array_filter(array_unique(Hash::extract($caseAll, '{n}.Easycase.custom_status_id')));
            if ($sts_ids) {
                $Csts = ClassRegistry::init('CustomStatus');
                $csts_arr = $Csts->find('all', array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
                if ($csts_arr) {
                    $csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
                }
            }
            //Fetching custom field values
            $CustomFieldValue = ClassRegistry::init('CustomFieldValue');
            $CustomField = ClassRegistry::init('CustomField');
            if ($AllCustomFields) {
                $getAllCustomFields = $CustomFieldValue->reorderCustomFieldArray($AllCustomFields, 'taskid', $dt, $tz);
            }
            // Preparing an array of all CFs for each task - End
            // To append that array to the index of that task
            foreach ($caseAll as $caseKey => $getdata) {
                if (isset($getAllCustomFields[$getdata['Easycase']['id']])) {
                    $caseAll[$caseKey]['Easycase']['custom_fields'] = $getAllCustomFields[$getdata['Easycase']['id']];
                } else {
                    $caseAll[$caseKey]['Easycase']['custom_fields'] = [];
                }
                if (!empty($allActiveFields)) {
                    $tasktimeBalance = $this->getTimeBalance($getdata['Easycase'], $allActiveFields);
                    $task_duration = $this->getDurationOfTask($getdata['Easycase'], $allActiveFields);
                    $caseAll[$caseKey]['Easycase']['custom_fields'][$tasktimeBalance[0]]['CustomFieldValue']['value'] = $tasktimeBalance[1];
                    $caseAll[$caseKey]['Easycase']['custom_fields'][$tasktimeBalance[0]]['CustomField']['placeholder'] = 'timeBalance';
                    $caseAll[$caseKey]['Easycase']['custom_fields'][$task_duration[0]]['CustomFieldValue']['value'] = $task_duration[1];
                    $caseAll[$caseKey]['Easycase']['custom_fields'][$task_duration[0]]['CustomField']['placeholder'] = 'taskDuration';
                }
                // End fetch the Custom fields & advanced CFs for this Task
                // Start fetch the Favourite Task in EasycaseFavourite table
                if (!empty($easycase_favourite) && !empty($easycase_favourite[$getdata['Easycase']['id']])) {
                    $caseAll[$caseKey]['Easycase']['isFavourite'] = 1;
                    $caseAll[$caseKey]['Easycase']['favouriteColor'] = '#FFDC77';
                } else {
                    $caseAll[$caseKey]['Easycase']['isFavourite'] = 0;
                    $caseAll[$caseKey]['Easycase']['favouriteColor'] = '#888888';
                }
                // End fetch the Favourite Task in EasycaseFavourite table
                if (isset($getdata[0]['spent_hrs'])) {
                    $caseAll[$caseKey]['Easycase']['spent_hrs'] = $getdata[0]['spent_hrs'];
                } else {
                    $caseAll[$caseKey]['Easycase']['spent_hrs'] = 0;
                }
                
                if (isset($getdata[0]['sub_sub_task'])) {
                    $caseAll[$caseKey]['Easycase']['sub_sub_task'] = $getdata[0]['sub_sub_task'];
                } else {
                    $caseAll[$caseKey]['Easycase']['sub_sub_task'] = null;
                }
                if (isset($getdata[0]['is_sub_sub_task'])) {
                    $caseAll[$caseKey]['Easycase']['is_sub_sub_task'] = $getdata[0]['is_sub_sub_task'];
                } else {
                    $caseAll[$caseKey]['Easycase']['is_sub_sub_task'] = null;
                }

                if (isset($getdata['Easycase']['tot_spent_hour'])) {
                    App::import('Component', 'Format');
                    $format = new FormatComponent(new ComponentCollection);
                    $caseAll[$caseKey]['Easycase']['tot_spent_hour'] = $format->format_time_hr_min($getdata['Easycase']['tot_spent_hour']);
                } elseif (isset($getdata[0]['tot_spent_hour'])) {
                    App::import('Component', 'Format');
                    $format = new FormatComponent(new ComponentCollection);
                    $caseAll[$caseKey]['Easycase']['tot_spent_hour'] = $format->format_time_hr_min($getdata[0]['tot_spent_hour']);
                } else {
                    $caseAll[$caseKey]['Easycase']['tot_spent_hour'] = 0;
                }
                if (isset($getdata['Easycase']['estimated_hours'])) {
                    App::import('Component', 'Format');
                    $format = new FormatComponent(new ComponentCollection);
                    $caseAll[$caseKey]['Easycase']['estimated_hours_convert'] = $format->format_time_hr_min($getdata['Easycase']['estimated_hours']);
                } else {
                    $caseAll[$caseKey]['Easycase']['estimated_hours_convert'] = 0;
                }
                $projId = $getdata['Easycase']['project_id'];
                $newpjcnt = $projId;
                $caseAll[$caseKey]['Easycase']['count_tasks'] = isset($getdata[0]['cnt']) ? $getdata[0]['cnt'] : '';
                $caseAll[$caseKey]['Easycase']['default_count_tasks'] = isset($milestones[$getdata['Milestone']['id']]['totalcases']) ? $milestones[$getdata['Milestone']['id']]['totalcases'] : 0;
                $actuallyCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['actual_dt_created'], "datetime");
                $newdate_actualdate = explode(" ", $actuallyCreated);
                $updated = @$tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['dt_created'], "datetime");
                $newdate = explode(" ", $updated);
                $mdata = array();
                if ($caseMenuFilters == "milestone") { //count($milestones);exit;
                    $mdata[] = $getdata['Easycase']['Mid'];
                    if ($chkMstone != $getdata['Easycase']['Mid']) {
                        if (trim($getdata['Easycase']['end_date']) != '0000-00-00') {
                            $endDate = $getdata['Easycase']['end_date'] . " " . $curTime;
                            $days = $dt->dateDiff($endDate, $curCreated);
                        } elseif (trim($getdata['Easycase']['end_date']) == '0000-00-00') {
                            $days = '';
                            $endDate = '';
                        }
                        $mlstDT = '';
                        if (trim($getdata['Easycase']['end_date']) != '0000-00-00') {
                            $mlstDT = $dt->dateFormatOutputdateTime_day($getdata['Easycase']['end_date'], GMT_DATETIME, 'week');
                        }
                        $totalCs = $milestones[$getdata['Easycase']['Mid']]['totalcases'];
                        $totalClosedCs = 0;
                        if (isset($closed_cases[$getdata['Easycase']['Mid']])) {
                            $totalClosedCs = $closed_cases[$getdata['Easycase']['Mid']]['totalclosed'];
                        }
                        $fill = 0;
                        if ($totalClosedCs != 0) {
                            $fill = round((($totalClosedCs / $totalCs) * 100));
                        }

                        $caseAll[$caseKey]['Easycase']['intEndDate'] = strtotime($endDate);
                        $caseAll[$caseKey]['Easycase']['days_diff'] = $days;
                        $caseAll[$caseKey]['Easycase']['mlstDT'] = $mlstDT;
                        $caseAll[$caseKey]['Easycase']['mlstFill'] = $fill;
                        $caseAll[$caseKey]['Easycase']['totalClosedCs'] = $totalClosedCs;
                        $caseAll[$caseKey]['Easycase']['totalCs'] = $totalCs;
                    }
                    if ($projIdcnt != $newpjcnt && $projUniq == 'all') {
                        $pjname = $cq->getProjectName($projId);
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                        $caseAll[$caseKey]['Easycase']['pjMethodologyid'] = $pjname['Project']['project_methodology_id'];
                    } elseif ($projUniq != 'all') {
                        if (!$pjname) {
                            $pjname = $cq->getProjectName($projId);
                        }
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                        $caseAll[$caseKey]['Easycase']['pjMethodologyid'] = $pjname['Project']['project_methodology_id'];
                    }

                    //$getdata['Easycase']['Mid'];
                } else {
                    if ($projIdcnt != $newpjcnt && $projUniq == 'all') {
                        $pjname = $cq->getProjectName($projId);
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                        $caseAll[$caseKey]['Easycase']['pjMethodologyid'] = $pjname['Project']['project_methodology_id'];
                    } elseif ($projUniq != 'all') {
                        if (!$pjname) {
                            $pjname = $cq->getProjectName($projId);
                        }
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                        $caseAll[$caseKey]['Easycase']['pjMethodologyid'] = $pjname['Project']['project_methodology_id'];
                    }

                    if ($caseCreateDate) {
                        if (($chkDateTime1 != $newdate_actualdate[0])) {
                            $caseAll[$caseKey]['Easycase']['newActuldt'] = @$dt->dateFormatOutputdateTime_day($actuallyCreated, $curCreated, 'date');
                        }
                    } else {
                        if (($chkDateTime != $newdate[0]) || ($projIdcnt != $newpjcnt && $projUniq == 'all')) {
                            $caseAll[$caseKey]['Easycase']['newActuldt'] = @$dt->dateFormatOutputdateTime_day($updated, $curCreated, 'date');
                        }
                    }
                }

                //case type start
                $typeShortName = "";
                $typeName = "";
                $caseTypeId = $getdata['Easycase']['type_id'];
                //if ($repeatcaseTypeId != $caseTypeId) {

                //$types = $cq->getTypeArr($caseTypeId,$GLOBALS['TYPE']);
                $types = $cq->getTypeArr($caseTypeId, $typeArr);
                if (count($types)) {
                    $typeShortName = $types['Type']['short_name'];
                    $typeName = $types['Type']['name'];
                } else {
                    $typeShortName = "";
                    $typeName = "";
                }
                //}
                $iconExist = 0;
                if (trim($typeShortName) && file_exists(WWW_ROOT . "img/images/types/" . $typeShortName . ".png")) {
                    $iconExist = 1;
                }
                //$caseAll[$caseKey]['Easycase']['csTdTyp'] = $frmt->todo_typ($typeShortName,$typeName);
                $caseAll[$caseKey]['Easycase']['csTdTyp'] = array($typeShortName, $typeName, $iconExist);
                //case type end
                //Updated column start
                $caseAll[$caseKey]['Easycase']['fbActualDt'] = @$dt->facebook_datetimestyle($updated);
                $caseAll[$caseKey]['Easycase']['updted'] = @$dt->dateFormatOutputdateTime_day($updated, $curCreated, 'week');
                //Updated column end
                //Title Caption start
                if ($getdata['Easycase']['case_count']) {
                    $getlastUid = $getdata['Easycase']['updated_by'];
                } else {
                    $getlastUid = $getdata['Easycase']['user_id'];
                }

                if ($repeatLastUid != $getlastUid) {
                    if ($getlastUid && $getlastUid != SES_ID) {
                        $usrDtls = $cq->getUserDtlsArr($getlastUid, $usrDtlsArr);
                        $usrName = $frmt->formatText($usrDtls['User']['name']);
                        //$usrShortName = ucfirst($usrDtls['User']['name']);
                        $usrShortName = mb_convert_case($usrDtls['User']['name'], MB_CASE_TITLE, "UTF-8");
                    } else {
                        $usrName = "";
                        $usrShortName = "me";
                    }
                }
                $caseAll[$caseKey]['Easycase']['usrName'] = $usrName; //case status title caption name
                $caseAll[$caseKey]['Easycase']['usrShortName'] = $usrShortName; //case status title caption sh_name
                $caseAll[$caseKey]['Easycase']['updtedCapDt'] = @$dt->dateFormatOutputdateTime_day($updated, $curCreated); //case status title caption date
                $caseAll[$caseKey]['Easycase']['fbstyle'] = @$dt->facebook_style($updated, $curCreated, 'time'); //case status title caption date
                if ($caseMenuFilters == 'milestone') {
                    $caseAll[$caseKey]['Easycase']['proImage'] = @$frmt->formatprofileimage($usrDtlsArr[$getlastUid]['User']['photo']); //case status title caption sh_name
                }
                //Title Caption end
                //case status start
                $caseLegend = $getdata['Easycase']['legend'];
                //$caseAll[$caseKey]['Easycase']['csSts'] = $frmt->getStatus($caseTypeId,$caseLegend);
                //case status end
                //assign info start
                $caseUserId = $getdata['Easycase']['user_id'];
                $caseAssgnUid = $getdata['Easycase']['assign_to'];
                if ($caseAssgnUid && $repeatAssgnUid != $caseAssgnUid) {
                    if ($caseAssgnUid != SES_ID) {
                        $usrAsgn = $cq->getUserDtlsArr($caseAssgnUid, $usrDtlsArr);
                        $asgnName = $frmt->formatText($usrAsgn['User']['name']);
                        //$asgnShortName = strtoupper($usrAsgn['User']['short_name']);
                        //$asgnShortName = $frmt->shortLength(ucfirst($usrAsgn['User']['name']), 8);
                        $asgnShortName = trim($frmt->shortLength(mb_convert_case($usrAsgn['User']['name'], MB_CASE_TITLE, "UTF-8"), 8, $short), '.');
                    } elseif ($caseAssgnUid == 0) {
                        $asgnShortName = '<span>Unassigned</span>';
                        $asgnName = "";
                    } else {
                        $asgnShortName = '<span>me</span>';
                        $asgnName = "";
                    }
                }
                if ($caseAssgnUid == 0) {
                    $asgnShortName = '<span>Unassigned</span>';
                    $asgnName = "";
                }
                $caseAll[$caseKey]['Easycase']['asgnName'] = $asgnName;
                $caseAll[$caseKey]['Easycase']['asgnShortName'] = $asgnShortName;
                if (!empty($dependency)) {
                    if (!empty($dependency['children'][$caseAll[$caseKey]['Easycase']['id']])) {
                        $caseAll[$caseKey]['Easycase']['children'] = implode(',', $dependency['children'][$caseAll[$caseKey]['Easycase']['id']]);
                    }
                    if (!empty($dependency['depends'][$caseAll[$caseKey]['Easycase']['id']])) {
                        $caseAll[$caseKey]['Easycase']['depends'] = implode(',', $dependency['depends'][$caseAll[$caseKey]['Easycase']['id']]);
                    }
                }
                //assign info end
                //Created date start
                //$actualDt1 = $tz->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$getdata['Easycase']['actual_dt_created'],"datetime");
                //$caseAll[$caseKey]['Easycase']['actualDt1FbDtT'] = $dt->facebook_datetimestyle($actualDt1);
                //$caseAll[$caseKey]['Easycase']['actualDt1FbDt'] = $dt->facebook_style($actualDt1,$curCreated,'date');
                //Created date end
                #$caseDueDate = $getdata['Easycase']['due_date'];
                $caseDueDate = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['due_date'], "datetime");
                $caseDueDateInintial = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['initial_due_date'], "datetime");
                if ($caseDueDateInintial != "NULL" && $caseDueDateInintial != "0000-00-00 00:00:00" && $caseDueDateInintial != "" && $caseDueDateInintial != "1970-01-01 00:00:00") {
                    $csDuDtFmtInitial = $dt->dateFormatOutputdateTime_day($caseDueDateInintial, $curCreated, 'week');
                } else {
                    $csDuDtFmtInitial = '--';
                }

                if ($caseTypeId == 10 || $caseLegend == 3 || $caseLegend == 5) {
                    if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00") {
                        if ($caseDueDate < $curdtT) {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                            $csDueDate = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDuDtFmt = $csDueDate; //revised
                            $csDuDtFmt1 = $csDueDate;
                        } else {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDuDtFmt1 = $csDuDtFmt;
                        }
                    } else {
                        $csDuDtFmtT = '';
                        $csDuDtFmt = '';
                        $csDuDtFmt1 = $csDuDtFmt;
                    }
                    $csDueDate = $csDuDtFmt;
                    $csDueDate1 = $csDuDtFmt1;
                } else {
                    if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00") {
                        if ($caseDueDate < $curdtT) {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                            //Find date diff in days.
                            $date1 = date_create($curdtT);
                            $date2 = date_create(date('Y-m-d', strtotime($caseDueDate)));
                            $diff = date_diff($date1, $date2, true);
                            $diff_in_days = $diff->format("%a");
                            $csDuDtFmtBy = ($diff_in_days > 1) ? 'by ' . $diff_in_days . ' days' : 'by ' . $diff_in_days . ' day';
                            $csDueDate = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDueDate1 = $csDueDate;
                        } else {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDuDtFmt1 = $csDuDtFmt;
                            $csDueDate = $csDuDtFmt;
                            $csDueDate1 = $csDuDtFmt1;
                            $csDuDtFmtBy = '';
                        }
                    } else {
                        $csDuDtFmtT = '';
                        $csDuDtFmt = '<span class="set-due-dt">'.__('Schedule it', true).'</span>';
                        $csDuDtFmt1 = $csDuDtFmt;
                        $csDueDate = '';
                        $csDueDate1 = '';
                        $csDuDtFmtBy = '';
                    }
                }
                $caseDtId = $getdata['Easycase']['id'];
                if ($caseMenuFilters == 'milestone') {
                    $rplyFilesArr = $this->getAllCaseFiles($caseAll[$caseKey]['Easycase']['project_id'], $caseAll[$caseKey]['Easycase']['case_no']);
                } else {
                    //$rplyFilesArr = $this->getCaseFiles($caseDtId);
                }
                foreach ($rplyFilesArr as $fkey => $getFiles) {
                    $caseFileName = $getFiles['CaseFile']['file'];
                    $caseFileUName = $getFiles['CaseFile']['upload_name'] != '' ? $getFiles['CaseFile']['upload_name'] : $getFiles['CaseFile']['file'];

                    $rplyFilesArr[$fkey]['CaseFile']['is_exist'] = 0;
                    if (trim($caseFileName)) {
                        $rplyFilesArr[$fkey]['CaseFile']['is_exist'] = 1; //$frmt->pub_file_exists(DIR_CASE_FILES_S3_FOLDER,$caseFileName);
                    }

                    if (stristr($getFiles['CaseFile']['downloadurl'], 'www.dropbox.com')) {
                        $rplyFilesArr[$fkey]['CaseFile']['format_file'] = 'db'; //'<img src="'.HTTP_IMAGES.'images/db16x16.png" alt="Dropbox" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                    } elseif (stristr($getFiles['CaseFile']['downloadurl'], '.google.com')) {
                        $rplyFilesArr[$fkey]['CaseFile']['format_file'] = 'gd'; //'<img src="'.HTTP_IMAGES.'images/gd16x16.png" alt="Google" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                    } else {
                        $rplyFilesArr[$fkey]['CaseFile']['format_file'] = substr(strrchr(strtolower($caseFileName), "."), 1); //str_replace(array('"','\''), array('\'','"'), $frmt->imageType($caseFileName,25,10,1));
                    }
                    $rplyFilesArr[$fkey]['CaseFile']['is_ImgFileExt'] = $frmt->validateImgFileExt($caseFileUName);

                    if ($rplyFilesArr[$fkey]['CaseFile']['is_ImgFileExt']) {
                        if (defined('USE_S3') && USE_S3 == 1) {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                        } else {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                        }
                        if (trim($rplyFilesArr[$fkey]['CaseFile']['thumb']) != '') {
                            $info = true; #$s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $caseFileName, S3::ACL_PRIVATE);
                            if ($info && defined('USE_S3') && USE_S3 == 1) {
                                $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . "thumb/" . $caseFileUName);
                            } else {
                                $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = HTTP_CASE_FILES . trim($rplyFilesArr[$fkey]['CaseFile']['thumb']);
                            }
                        } else {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = '';
                        }
                    }

                    //$rplyFilesArr[$fkey]['CaseFile']['file_shname'] = $frmt->shortLength($caseFileName,37);
                    $rplyFilesArr[$fkey]['CaseFile']['file_size'] = $frmt->getFileSize($getFiles['CaseFile']['file_size']);
                }
                $caseAll[$caseKey]['Easycase']['all_files'] = $rplyFilesArr;
                $caseAll[$caseKey]['Easycase']['csDuDtFmtT'] = $csDuDtFmtT;
                $caseAll[$caseKey]['Easycase']['csDuDtFmt'] = $csDuDtFmt;
                $caseAll[$caseKey]['Easycase']['csDuDtFmtInitial'] = $csDuDtFmtInitial;
                $caseAll[$caseKey]['Easycase']['csDuDtFmt1'] = $csDueDate1;
                $caseAll[$caseKey]['Easycase']['csDuDtFmtBy'] = $csDuDtFmtBy;
                $caseAll[$caseKey]['Easycase']['csDueDate'] = $csDueDate;
                $caseAll[$caseKey]['Easycase']['csDueDate1'] = $csDueDate1;

                //$caseAll[$caseKey]['Easycase']['title'] = htmlspecialchars(html_entity_decode($getdata['Easycase']['title'], ENT_QUOTES, 'UTF-8'));
                $caseAll[$caseKey]['Easycase']['title'] = h($getdata['Easycase']['title'], true, 'UTF-8');
                $caseAll[$caseKey]['Easycase']['parent_task_id'] = $getdata['Easycase']['parent_task_id'];

                $repeatLastUid = $getlastUid;
                $repeatAssgnUid = $caseAssgnUid;
                $repeatcaseTypeId = $caseTypeId;
                $chkDateTime = $newdate[0];
                $chkDateTime1 = $newdate_actualdate[0];
                $projIdcnt = $newpjcnt;
                $caseAll[$caseKey]['Easycase']['reply_cnt'] = $caseAll[$caseKey]['Easycase']['thread_count'];
                #$caseAll[$caseKey]['Easycase']['children'] = $getdata['Easycase']['children'];
                /* Get custom taskstatus informations */
                /*if($caseAll[$caseKey]['Easycase']['custom_status_id']){
                    $Csts = ClassRegistry::init('CustomStatus');
                    $csts_arr = $Csts->find('first',array('conditions'=>array('CustomStatus.id'=>$caseAll[$caseKey]['Easycase']['custom_status_id'])));
                    $caseAll[$caseKey]['Easycase']['CustomStatus'] = $csts_arr['CustomStatus'];
                }*/
                if ($caseAll[$caseKey]['Easycase']['custom_status_id']) {
                    $caseAll[$caseKey]['Easycase']['CustomStatus'] = $csts_arr[$caseAll[$caseKey]['Easycase']['custom_status_id']];
                }
                unset(
                        $caseAll[$caseKey]['Easycase']['updated_by'], $caseAll[$caseKey]['Easycase']['message'], $caseAll[$caseKey]['Easycase']['hours'], $caseAll[$caseKey]['Easycase']['completed_task'], $caseAll[$caseKey]['Easycase']['due_date'], $caseAll[$caseKey]['Easycase']['istype'], $caseAll[$caseKey]['Easycase']['status'], $caseAll[$caseKey]['Easycase']['dt_created'], $caseAll[$caseKey]['Easycase']['reply_type'], $caseAll[$caseKey]['Easycase']['id_seq'], $caseAll[$caseKey]['Easycase']['end_date'], $caseAll[$caseKey]['Easycase']['Mproject_id'], $caseAll[$caseKey][0], $caseAll[$caseKey]['User']
                );
                $caseAll[$caseKey]['Easycase']['completed_task'] = $getdata['Easycase']['completed_task'];
                if ($caseLegend == 3 || $caseLegend == 5) {
                    $caseAll[$caseKey]['Easycase']['completed_task'] =100;
                }
                if ($caseAll[$caseKey]['Easycase']['custom_status_id']) {
                    $caseAll[$caseKey]['Easycase']['completed_task'] = $csts_arr[$getdata['Easycase']['custom_status_id']]['progress'];
                }
                #$caseAll[$caseKey]['Easycase']['actual_dt_created'],
            }
        }

        if ($caseMenuFilters == "milestone" && count($milestones)) {
            foreach ($milestones as $key => $ms) {
                if (!$ms['totalcases']) {
                    $days = '';
                    if ($ms['end_date'] != '0000-00-00') {
                        $endDate = $ms['end_date'] . " " . $curTime;
                        $days = $dt->dateDiff($endDate, $curCreated);
                    }

                    $milestones[$key]['days_diff'] = $days;
                    $mlstDT = '';
                    if (trim($ms['end_date']) != '0000-00-00') {
                        $mlstDT = $dt->dateFormatOutputdateTime_day($ms['end_date'], GMT_DATETIME, 'week');
                    }
                    $milestones[$key]['mlstDT'] = $mlstDT;
                    if (trim($ms['end_date']) != '0000-00-00') {
                        $milestones[$key]['intEndDate'] = strtotime($ms['end_date']);
                    } elseif (trim($ms['end_date']) == '0000-00-00') {
                        $milestones[$key]['intEndDate'] = '';
                    }
                } /* else {
                  unset(
                  $milestones[$key]['title'],
                  $milestones[$key]['uinq_id'],
                  $milestones[$key]['isactive'],
                  $milestones[$key]['user_id']
                  );
                  } */

//				unset(
//					$milestones[$key]['end_date']
//				);
            }
        }
        return array('caseAll' => $caseAll, 'milestones' => $milestones);
    }
    public function formatCasesPdf($caseAll, $caseCount, $caseMenuFilters, $closed_cases, $milestones, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, $user_data, $timezone_data)
    {
        if (isset($user_data['is_dst'])) {
            if (!defined('TZ_DST')) {
                define('TZ_DST', $user_data['is_dst']);
            }
        } else {
            if (!defined('TZ_DST')) {
                define('TZ_DST', $timezone_data['dst_offset']);
            }
        }
        if (!defined('TZ_CODE')) {
            define('TZ_CODE', $timezone_data['code']);
        }
        $curCreated = $tz->GetDateTime($timezone_data['id'], $timezone_data['gmt_offset'], TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $curdtT = $tz->GetDateTime($timezone_data['id'], $timezone_data['gmt_offset'], TZ_DST, TZ_CODE, GMT_DATETIME, "date");
        $curTime = date('H:i:s', strtotime($curCreated));

        if ($caseCount) {
            $chkDateTime = $chkDateTime1 = $projIdcnt = $newpjcnt = $repeatcaseTypeId = $repeatLastUid = $repeatAssgnUid = "";
            $pjname = '';
            if (!defined(SES_COMP)) {
                $sql = "SELECT Type.* FROM types AS Type";
            } else {
                $sql = "SELECT Type.* FROM types AS Type WHERE Type.company_id = 0 OR Type.company_id =" . SES_COMP;
            }
            $typeArr = $this->query($sql);
            $csts_arr = array();
            //custom status ref for other pages
            $sts_ids = array_filter(array_unique(Hash::extract($caseAll, '{n}.Easycase.custom_status_id')));
            if ($sts_ids) {
                $Csts = ClassRegistry::init('CustomStatus');
                $csts_arr = $Csts->find('all', array('conditions'=>array('CustomStatus.id'=>$sts_ids)));
                if ($csts_arr) {
                    $csts_arr = Hash::combine($csts_arr, '{n}.CustomStatus.id', '{n}.CustomStatus');
                }
            }
            foreach ($caseAll as $caseKey => $getdata) {
                $projId = $getdata['Easycase']['project_id'];
                $newpjcnt = $projId;
                $caseAll[$caseKey]['Easycase']['count_tasks'] = isset($getdata[0]['cnt']) ? $getdata[0]['cnt'] : '';
                $caseAll[$caseKey]['Easycase']['default_count_tasks'] = isset($milestones[$getdata['Milestone']['id']]['totalcases']) ? $milestones[$getdata['Milestone']['id']]['totalcases'] : 0;
                $actuallyCreated = $tz->GetDateTime($timezone_data['id'], $timezone_data['gmt_offset'], TZ_DST, TZ_CODE, $getdata['Easycase']['actual_dt_created'], "datetime");
                $newdate_actualdate = explode(" ", $actuallyCreated);
                $updated = $tz->GetDateTime($timezone_data['id'], $timezone_data['gmt_offset'], TZ_DST, TZ_CODE, $getdata['Easycase']['dt_created'], "datetime");
                $newdate = explode(" ", $updated);
                $mdata = array();
                if ($caseMenuFilters == "milestone" && count($milestones)) {
                    $mdata[] = $getdata['Easycase']['Mid'];
                    if ($chkMstone != $getdata['Easycase']['Mid']) {
                        if (trim($getdata['Easycase']['end_date']) != '0000-00-00') {
                            $endDate = $getdata['Easycase']['end_date'] . " " . $curTime;
                            $days = $dt->dateDiff($endDate, $curCreated);
                        } elseif (trim($getdata['Easycase']['end_date']) == '0000-00-00') {
                            $days = '';
                            $endDate = '';
                        }
                        $mlstDT = '';
                        if (trim($getdata['Easycase']['end_date']) != '0000-00-00') {
                            $mlstDT = $dt->dateFormatOutputdateTime_day($getdata['Easycase']['end_date'], GMT_DATETIME, 'week');
                        }
                        $totalCs = $milestones[$getdata['Easycase']['Mid']]['totalcases'];
                        $totalClosedCs = 0;
                        if (isset($closed_cases[$getdata['Easycase']['Mid']])) {
                            $totalClosedCs = $closed_cases[$getdata['Easycase']['Mid']]['totalclosed'];
                        }
                        $fill = 0;
                        if ($totalClosedCs != 0) {
                            $fill = round((($totalClosedCs / $totalCs) * 100));
                        }

                        $caseAll[$caseKey]['Easycase']['intEndDate'] = strtotime($endDate);
                        $caseAll[$caseKey]['Easycase']['days_diff'] = $days;
                        $caseAll[$caseKey]['Easycase']['mlstDT'] = $mlstDT;
                        $caseAll[$caseKey]['Easycase']['mlstFill'] = $fill;
                        $caseAll[$caseKey]['Easycase']['totalClosedCs'] = $totalClosedCs;
                        $caseAll[$caseKey]['Easycase']['totalCs'] = $totalCs;
                    }
                    if ($projIdcnt != $newpjcnt && $projUniq == 'all') {
                        $pjname = $cq->getProjectName($projId);
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                    } elseif ($projUniq != 'all') {
                        if (!$pjname) {
                            $pjname = $cq->getProjectName($projId);
                        }
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                    }

                    //$getdata['Easycase']['Mid'];
                } else {
                    if ($projIdcnt != $newpjcnt && $projUniq == 'all') {
                        $pjname = $cq->getProjectName($projId);
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                    } elseif ($projUniq != 'all') {
                        if (!$pjname) {
                            $pjname = $cq->getProjectName($projId);
                        }
                        $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                        $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                    }

                    if ($caseCreateDate) {
                        if (($chkDateTime1 != $newdate_actualdate[0])) {
                            $caseAll[$caseKey]['Easycase']['newActuldt'] = $dt->dateFormatOutputdateTime_day($actuallyCreated, $curCreated, 'date');
                        }
                    } else {
                        if (($chkDateTime != $newdate[0]) || ($projIdcnt != $newpjcnt && $projUniq == 'all')) {
                            $caseAll[$caseKey]['Easycase']['newActuldt'] = $dt->dateFormatOutputdateTime_day($updated, $curCreated, 'date');
                        }
                    }
                }

                //case type start
                $typeShortName = "";
                $typeName = "";
                $caseTypeId = $getdata['Easycase']['type_id'];
                //if ($repeatcaseTypeId != $caseTypeId) {

                //$types = $cq->getTypeArr($caseTypeId,$GLOBALS['TYPE']);
                $types = $cq->getTypeArr($caseTypeId, $typeArr);
                if (count($types)) {
                    $typeShortName = $types['Type']['short_name'];
                    $typeName = $types['Type']['name'];
                } else {
                    $typeShortName = "";
                    $typeName = "";
                }
                //}
                $iconExist = 0;
                if (trim($typeShortName) && file_exists(WWW_ROOT . "img/images/types/" . $typeShortName . ".png")) {
                    $iconExist = 1;
                }
                //$caseAll[$caseKey]['Easycase']['csTdTyp'] = $frmt->todo_typ($typeShortName,$typeName);
                $caseAll[$caseKey]['Easycase']['csTdTyp'] = array($typeShortName, $typeName, $iconExist);
                //case type end
                //Updated column start
                $caseAll[$caseKey]['Easycase']['fbActualDt'] = $dt->facebook_datetimestyle($updated);
                $caseAll[$caseKey]['Easycase']['updted'] = $dt->dateFormatOutputdateTime_day($updated, $curCreated, 'week');
                //Updated column end
                //Title Caption start
                if ($getdata['Easycase']['case_count']) {
                    $getlastUid = $getdata['Easycase']['updated_by'];
                } else {
                    $getlastUid = $getdata['Easycase']['user_id'];
                }

                if ($repeatLastUid != $getlastUid) {
                    if ($getlastUid && $getlastUid != SES_ID) {
                        $usrDtls = $cq->getUserDtlsArr($getlastUid, $usrDtlsArr);
                        $usrName = $frmt->formatText($usrDtls['User']['name']);
                        //$usrShortName = ucfirst($usrDtls['User']['name']);
                        $usrShortName = mb_convert_case($usrDtls['User']['name'], MB_CASE_TITLE, "UTF-8");
                    } else {
                        $usrName = "";
                        $usrShortName = "me";
                    }
                }
                $caseAll[$caseKey]['Easycase']['usrName'] = $usrName; //case status title caption name
                $caseAll[$caseKey]['Easycase']['usrShortName'] = $usrShortName; //case status title caption sh_name
                $caseAll[$caseKey]['Easycase']['updtedCapDt'] = $dt->dateFormatOutputdateTime_day($updated, $curCreated); //case status title caption date
                $caseAll[$caseKey]['Easycase']['fbstyle'] = $dt->facebook_style($updated, $curCreated, 'time'); //case status title caption date
                if ($caseMenuFilters == 'milestone') {
                    $caseAll[$caseKey]['Easycase']['proImage'] = $frmt->formatprofileimage($usrDtlsArr[$getlastUid]['User']['photo']); //case status title caption sh_name
                }
                //Title Caption end
                //case status start
                $caseLegend = $getdata['Easycase']['legend'];
                //$caseAll[$caseKey]['Easycase']['csSts'] = $frmt->getStatus($caseTypeId,$caseLegend);
                //case status end
                //assign info start
                $caseUserId = $getdata['Easycase']['user_id'];
                $caseAssgnUid = $getdata['Easycase']['assign_to'];
                if ($caseAssgnUid && $repeatAssgnUid != $caseAssgnUid) {
                    if ($caseAssgnUid != SES_ID) {
                        $usrAsgn = $cq->getUserDtlsArr($caseAssgnUid, $usrDtlsArr);
                        $asgnName = $frmt->formatText($usrAsgn['User']['name']);
                        //$asgnShortName = strtoupper($usrAsgn['User']['short_name']);
                        //$asgnShortName = $frmt->shortLength(ucfirst($usrAsgn['User']['name']), 8);
                        $asgnShortName = mb_convert_case($usrAsgn['User']['name'], MB_CASE_TITLE, "UTF-8");
                    } elseif ($caseAssgnUid == 0) {
                        $asgnShortName = '<span>Unassigned</span>';
                        $asgnName = "";
                    } else {
                        $asgnShortName = '<span>me</span>';
                        $asgnName = "";
                    }
                }
                if ($caseAssgnUid == 0) {
                    $asgnShortName = '<span>Unassigned</span>';
                    $asgnName = "";
                }
                $caseAll[$caseKey]['Easycase']['asgnName'] = $asgnName;
                $caseAll[$caseKey]['Easycase']['asgnShortName'] = $asgnShortName;
                //assign info end
                //Created date start
                //$actualDt1 = $tz->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$getdata['Easycase']['actual_dt_created'],"datetime");
                //$caseAll[$caseKey]['Easycase']['actualDt1FbDtT'] = $dt->facebook_datetimestyle($actualDt1);
                //$caseAll[$caseKey]['Easycase']['actualDt1FbDt'] = $dt->facebook_style($actualDt1,$curCreated,'date');
                //Created date end
                #$caseDueDate = $getdata['Easycase']['due_date'];
                $caseDueDate = $tz->GetDateTime($timezone_data['id'], $timezone_data['gmt_offset'], TZ_DST, TZ_CODE, $getdata['Easycase']['due_date'], "datetime");

                if ($caseTypeId == 10 || $caseLegend == 3 || $caseLegend == 5) {
                    if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00") {
                        if ($caseDueDate < $curdtT) {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                            $csDueDate = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDuDtFmt = $csDueDate; //revised
                            $csDuDtFmt1 = $csDueDate;
                        } else {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDuDtFmt1 = $csDuDtFmt;
                        }
                    } else {
                        $csDuDtFmtT = '';
                        $csDuDtFmt = '';
                        $csDuDtFmt1 = $csDuDtFmt;
                    }
                    $csDueDate = $csDuDtFmt;
                    $csDueDate1 = $csDuDtFmt1;
                } else {
                    if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00") {
                        if ($caseDueDate < $curdtT) {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                            //Find date diff in days.
                            $date1 = date_create($curdtT);
                            $date2 = date_create(date('Y-m-d', strtotime($caseDueDate)));
                            $diff = date_diff($date1, $date2, true);
                            $diff_in_days = $diff->format("%a");
                            $csDuDtFmtBy = ($diff_in_days > 1) ? 'by ' . $diff_in_days . ' days' : 'by ' . $diff_in_days . ' day';
                            $csDueDate = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDueDate1 = $csDueDate;
                        } else {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                            $csDuDtFmt1 = $csDuDtFmt;
                            $csDueDate = $csDuDtFmt;
                            $csDueDate1 = $csDuDtFmt1;
                            $csDuDtFmtBy = '';
                        }
                    } else {
                        $csDuDtFmtT = '';
                        $csDuDtFmt = '<span class="set-due-dt">'.__('Schedule it', true).'</span>';
                        $csDuDtFmt1 = $csDuDtFmt;
                        $csDueDate = '';
                        $csDueDate1 = '';
                        $csDuDtFmtBy = '';
                    }
                }
                $caseDtId = $getdata['Easycase']['id'];
                if ($caseMenuFilters == 'milestone') {
                    $rplyFilesArr = $this->getAllCaseFiles($caseAll[$caseKey]['Easycase']['project_id'], $caseAll[$caseKey]['Easycase']['case_no']);
                } else {
                    $rplyFilesArr = $this->getCaseFiles($caseDtId);
                }
                foreach ($rplyFilesArr as $fkey => $getFiles) {
                    $caseFileName = $getFiles['CaseFile']['file'];
                    $caseFileUName = $getFiles['CaseFile']['upload_name'] != '' ? $getFiles['CaseFile']['upload_name'] : $getFiles['CaseFile']['file'];

                    $rplyFilesArr[$fkey]['CaseFile']['is_exist'] = 0;
                    if (trim($caseFileName)) {
                        $rplyFilesArr[$fkey]['CaseFile']['is_exist'] = 1; //$frmt->pub_file_exists(DIR_CASE_FILES_S3_FOLDER,$caseFileName);
                    }

                    if (stristr($getFiles['CaseFile']['downloadurl'], 'www.dropbox.com')) {
                        $rplyFilesArr[$fkey]['CaseFile']['format_file'] = 'db'; //'<img src="'.HTTP_IMAGES.'images/db16x16.png" alt="Dropbox" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                    } elseif (stristr($getFiles['CaseFile']['downloadurl'], '.google.com')) {
                        $rplyFilesArr[$fkey]['CaseFile']['format_file'] = 'gd'; //'<img src="'.HTTP_IMAGES.'images/gd16x16.png" alt="Google" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                    } else {
                        $rplyFilesArr[$fkey]['CaseFile']['format_file'] = substr(strrchr(strtolower($caseFileName), "."), 1); //str_replace(array('"','\''), array('\'','"'), $frmt->imageType($caseFileName,25,10,1));
                    }
                    $rplyFilesArr[$fkey]['CaseFile']['is_ImgFileExt'] = $frmt->validateImgFileExt($caseFileUName);

                    if ($rplyFilesArr[$fkey]['CaseFile']['is_ImgFileExt']) {
                        if (defined('USE_S3') && USE_S3 == 1) {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                        } else {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                        }
                        if (trim($rplyFilesArr[$fkey]['CaseFile']['thumb']) != '') {
                            $info = true; #$s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $caseFileName, S3::ACL_PRIVATE);
                            if ($info && defined('USE_S3') && USE_S3 == 1) {
                                $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . "thumb/" . $caseFileUName);
                            } else {
                                $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = HTTP_CASE_FILES . trim($rplyFilesArr[$fkey]['CaseFile']['thumb']);
                            }
                        } else {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = '';
                        }
                    }

                    //$rplyFilesArr[$fkey]['CaseFile']['file_shname'] = $frmt->shortLength($caseFileName,37);
                    $rplyFilesArr[$fkey]['CaseFile']['file_size'] = $frmt->getFileSize($getFiles['CaseFile']['file_size']);
                }
                $caseAll[$caseKey]['Easycase']['all_files'] = $rplyFilesArr;
                $caseAll[$caseKey]['Easycase']['csDuDtFmtT'] = $csDuDtFmtT;
                $caseAll[$caseKey]['Easycase']['csDuDtFmt'] = $csDuDtFmt;
                $caseAll[$caseKey]['Easycase']['csDuDtFmt1'] = $csDueDate1;
                $caseAll[$caseKey]['Easycase']['csDuDtFmtBy'] = $csDuDtFmtBy;
                $caseAll[$caseKey]['Easycase']['csDueDate'] = $csDueDate;
                $caseAll[$caseKey]['Easycase']['csDueDate1'] = $csDueDate1;

                //$caseAll[$caseKey]['Easycase']['title'] = htmlspecialchars(html_entity_decode($getdata['Easycase']['title'], ENT_QUOTES, 'UTF-8'));
                $caseAll[$caseKey]['Easycase']['title'] = $getdata['Easycase']['title'];

                $repeatLastUid = $getlastUid;
                $repeatAssgnUid = $caseAssgnUid;
                $repeatcaseTypeId = $caseTypeId;
                $chkDateTime = $newdate[0];
                $chkDateTime1 = $newdate_actualdate[0];
                $projIdcnt = $newpjcnt;
                $caseAll[$caseKey]['Easycase']['reply_cnt'] = $caseAll[$caseKey]['Easycase']['thread_count'];
                $caseAll[$caseKey]['Easycase']['children'] = $getdata['Easycase']['children'];
                if ($caseAll[$caseKey]['Easycase']['custom_status_id']) {
                    $caseAll[$caseKey]['Easycase']['CustomStatus'] = $csts_arr[$caseAll[$caseKey]['Easycase']['custom_status_id']];
                }
                unset(
                        $caseAll[$caseKey]['Easycase']['updated_by'], $caseAll[$caseKey]['Easycase']['message'], $caseAll[$caseKey]['Easycase']['hours'], $caseAll[$caseKey]['Easycase']['completed_task'], $caseAll[$caseKey]['Easycase']['due_date'], $caseAll[$caseKey]['Easycase']['istype'], $caseAll[$caseKey]['Easycase']['status'], $caseAll[$caseKey]['Easycase']['dt_created'], $caseAll[$caseKey]['Easycase']['reply_type'], $caseAll[$caseKey]['Easycase']['id_seq'], $caseAll[$caseKey]['Easycase']['end_date'], $caseAll[$caseKey]['Easycase']['Mproject_id'], $caseAll[$caseKey][0], $caseAll[$caseKey]['User']
                );
                #$caseAll[$caseKey]['Easycase']['actual_dt_created'],
            }
        }

        if ($caseMenuFilters == "milestone" && count($milestones)) {
            foreach ($milestones as $key => $ms) {
                if (!$ms['totalcases']) {
                    $days = '';
                    if ($ms['end_date'] != '0000-00-00') {
                        $endDate = $ms['end_date'] . " " . $curTime;
                        $days = $dt->dateDiff($endDate, $curCreated);
                    }

                    $milestones[$key]['days_diff'] = $days;
                    $mlstDT = '';
                    if (trim($ms['end_date']) != '0000-00-00') {
                        $mlstDT = $dt->dateFormatOutputdateTime_day($ms['end_date'], GMT_DATETIME, 'week');
                    }
                    $milestones[$key]['mlstDT'] = $mlstDT;
                    if (trim($ms['end_date']) != '0000-00-00') {
                        $milestones[$key]['intEndDate'] = strtotime($ms['end_date']);
                    } elseif (trim($ms['end_date']) == '0000-00-00') {
                        $milestones[$key]['intEndDate'] = '';
                    }
                } /* else {
                  unset(
                  $milestones[$key]['title'],
                  $milestones[$key]['uinq_id'],
                  $milestones[$key]['isactive'],
                  $milestones[$key]['user_id']
                  );
                  } */

//				unset(
//					$milestones[$key]['end_date']
//				);
            }
        }
        return array('caseAll' => $caseAll, 'milestones' => $milestones);
    }
    public function getReplyCount($projectId = null, $caseNo = null)
    {
        if (isset($projectId) && isset($caseNo)) {
            $sql = "SELECT COUNT(case_no) AS reply_cnt FROM easycases WHERE project_id=" . $projectId . " AND case_no=" . $caseNo . " AND message !='' AND istype=2 AND legend!=6 GROUP BY case_no";
            $reply = $this->query($sql);
            $reply_attach = $this->getFilesInTasksCount($projectId, $caseNo);
            if (!empty($reply) || !empty($reply_attach)) {
                if (!empty($reply) && !empty($reply_attach)) {
                    return $reply['0']['0']['reply_cnt']+$reply_attach;
                } elseif (!empty($reply_attach)) {
                    return $reply_attach;
                } else {
                    return $reply['0']['0']['reply_cnt'];
                }
            }
        }
        return 0;
    }
    public function getFilesInTasksCount($projectId, $caseNo, $typ_chk=null)
    {
        $files_ids = $this->find('list', array('conditions' => array('Easycase.message' =>'', 'Easycase.format !='=>2,'Easycase.project_id'=>$projectId,'Easycase.case_no'=>$caseNo,'Easycase.istype'=>2), 'fields' => array('Easycase.id')));
        if (!empty($files_ids)) {
            App::import('Model', 'CaseFile');
            $CaseFile = new CaseFile();
            if ($typ_chk) {
                $cnts = $CaseFile->find('all', array('conditions' => array('CaseFile.easycase_id' =>array_values($files_ids),'CaseFile.isactive' =>1), 'fields' => array('CaseFile.id','CaseFile.file','CaseFile.display_name','CaseFile.easycase_id')));
                if ($cnts) {
                    $retArr = array();
                    foreach ($cnts as $k => $v) {
                        if (isset($retArr[$v['CaseFile']['easycase_id']])) {
                            $retArr[$v['CaseFile']['easycase_id']] .= (!empty($v['CaseFile']['file']))?', '.$v['CaseFile']['file']:', '.$v['CaseFile']['display_name'];
                        } else {
                            $retArr[$v['CaseFile']['easycase_id']] = (!empty($v['CaseFile']['file']))?$v['CaseFile']['file']:$v['CaseFile']['display_name'];
                        }
                    }
                    return $retArr;
                } else {
                    return false;
                }
            } else {
                $cnts = $CaseFile->find('count', array('conditions' => array('CaseFile.easycase_id' =>array_values($files_ids),'CaseFile.isactive' =>1), 'fields' => array('CaseFile.id'),'group'=>'CaseFile.easycase_id'));
            }
            return $cnts;
        }
        return 0;
    }
    public function formatKanbanTask($statusTasklist, $caseCount, $caseMenuFilters, $closed_cases, $milestones, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, $dependency = array())
    {
        $retarr = array();
        $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
        $curdtT = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
        $curTime = date('H:i:s', strtotime($curCreated));
        $sql = "SELECT Type.* FROM types AS Type WHERE Type.company_id = 0 OR Type.company_id =" . SES_COMP;
        $typeArr = $this->query($sql);
        $key_legend_sts = 0;
        foreach ($statusTasklist as $taskkey => $caseAll) {
            $chkDateTime = $chkDateTime1 = $projIdcnt = $newpjcnt = $repeatcaseTypeId = $repeatLastUid = $repeatAssgnUid = "";
            $pjname = '';
            $rplyFilesArr = array();
            $rplyFilesArr_cno = array();
            if ($caseAll) {
                $reslt_pids = array_filter(array_unique(Hash::extract($caseAll, '{n}.Easycase.project_id')));
                $rplyFilesArr = $this->getAllCaseFiles($reslt_pids, 'kanban');
                if ($rplyFilesArr) {
                    $rplyFilesArr_cno = Hash::extract($rplyFilesArr, '{n}.Easycase.case_no');
                }
            }
            foreach ($caseAll as $caseKey => $getdata) {
                if (isset($getdata[0]['sub_sub_task'])) {
                    $caseAll[$caseKey]['Easycase']['sub_sub_task'] = $getdata[0]['sub_sub_task'];
                } else {
                    $caseAll[$caseKey]['Easycase']['sub_sub_task'] = null;
                }
                if (isset($getdata[0]['is_sub_sub_task'])) {
                    $caseAll[$caseKey]['Easycase']['is_sub_sub_task'] = $getdata[0]['is_sub_sub_task'];
                } else {
                    $caseAll[$caseKey]['Easycase']['is_sub_sub_task'] = null;
                }
                if (isset($getdata[0]['spent_hrs'])) {
                    $caseAll[$caseKey]['Easycase']['spent_hrs'] = $getdata[0]['spent_hrs'];
                } else {
                    $caseAll[$caseKey]['Easycase']['spent_hrs'] = 0;
                }
                $projId = $getdata['Easycase']['project_id'];
                $caseNo = $getdata['Easycase']['case_no'];
                $newpjcnt = $projId;
                $actuallyCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['actual_dt_created'], "datetime");
                $newdate_actualdate = explode(" ", $actuallyCreated);
                $updated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['dt_created'], "datetime");
                $newdate = explode(" ", $updated);

                /*if($caseMenuFilters == "milestone" && count($milestones)) {
                    $mdata[] =$getdata['Easycase']['Mid'];
                    if($chkMstone != $getdata['Easycase']['Mid']) {

                        $endDate = $getdata['Easycase']['end_date']." ".$curTime;
                        $days = $dt->dateDiff($endDate,$curCreated);

                        $mlstDT = $dt->dateFormatOutputdateTime_day($getdata['Easycase']['end_date'],GMT_DATETIME,'week');

                        $totalCs = $milestones[$getdata['Easycase']['Mid']]['totalcases'];
                        $totalClosedCs = 0;
                        if(isset($closed_cases[$getdata['Easycase']['Mid']])){
                            $totalClosedCs = $closed_cases[$getdata['Easycase']['Mid']]['totalclosed'];
                        }
                        $fill = 0;
                        if($totalClosedCs != 0) {
                            $fill = round((($totalClosedCs/$totalCs)*100));
                        }

                        $caseAll[$caseKey]['Easycase']['intEndDate'] = strtotime($endDate);
                        $caseAll[$caseKey]['Easycase']['days_diff'] = $days;
                        $caseAll[$caseKey]['Easycase']['mlstDT'] = $mlstDT;
                        $caseAll[$caseKey]['Easycase']['mlstFill'] = $fill;
                        $caseAll[$caseKey]['Easycase']['totalClosedCs'] = $totalClosedCs;
                        $caseAll[$caseKey]['Easycase']['totalCs'] = $totalCs;
                    }
                    //$getdata['Easycase']['Mid'];
                } else {*/
                if ($projIdcnt != $newpjcnt && $projUniq == 'all') {
                    $pjname = $cq->getProjectName($projId);
                    $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                    $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                    $caseAll[$caseKey]['Easycase']['pjsname'] = $pjname['Project']['short_name'];
                    $caseAll[$caseKey]['Easycase']['pjMethodologyid'] = $pjname['Project']['project_methodology_id'];
                } elseif ($projUniq != 'all') {
                    if (!$pjname) {
                        $pjname = $cq->getProjectName($projId);
                    }
                    $caseAll[$caseKey]['Easycase']['pjname'] = $pjname['Project']['name'];
                    $caseAll[$caseKey]['Easycase']['pjUniqid'] = $pjname['Project']['uniq_id'];
                    $caseAll[$caseKey]['Easycase']['pjMethodologyid'] = $pjname['Project']['project_methodology_id'];
                }

                if ($caseCreateDate) {
                    if (($chkDateTime1 != $newdate_actualdate[0])) {
                        $caseAll[$caseKey]['Easycase']['newActuldt'] = $dt->dateFormatOutputdateTime_day($actuallyCreated, $curCreated, 'date');
                    }
                } else {
                    if (($chkDateTime != $newdate[0]) || ($projIdcnt != $newpjcnt && $projUniq == 'all')) {
                        $caseAll[$caseKey]['Easycase']['newActuldt'] = $dt->dateFormatOutputdateTime_day($updated, $curCreated, 'date');
                    }
                }

                //				}
                //case type start
                $typeShortName = "";
                $typeName = "";
                $caseTypeId = $getdata['Easycase']['type_id'];
//                if ($repeatcaseTypeId != $caseTypeId) {
                $types = $cq->getTypeArr($caseTypeId, $typeArr);
//                    $types = $cq->getTypeArr($caseTypeId, $GLOBALS['TYPE']);
                if (count($types)) {
                    $typeShortName = $types['Type']['short_name'];
                    $typeName = $types['Type']['name'];
                } else {
                    $typeShortName = "";
                    $typeName = "";
                }
//                }
                $iconExist = 0;
                if (trim($typeShortName) && file_exists(WWW_ROOT . "img/images/types/" . $typeShortName . ".png")) {
                    $iconExist = 1;
                }
                 
                $caseAll[$caseKey]['Easycase']['csTdTyp'] = array($typeShortName, $typeName, $iconExist);
                //case type end
                //Updated column start
                $caseAll[$caseKey]['Easycase']['fbActualDt'] = $dt->facebook_datetimestyle($updated);
                $caseAll[$caseKey]['Easycase']['updted'] = $dt->dateFormatOutputdateTime_day($updated, $curCreated, 'week');
                //Updated column end
                //Title Caption start
                if ($getdata['Easycase']['case_count']) {
                    $getlastUid = $getdata['Easycase']['updated_by'];
                } else {
                    $getlastUid = $getdata['Easycase']['user_id'];
                }
                $caseAll[$caseKey]['Easycase']['reply_cnt'] = $caseAll[$caseKey]['Easycase']['thread_count'];
                $caseAll[$caseKey]['Easycase']['proImage'] = $frmt->formatprofileimage($usrDtlsArr[$getlastUid]['User']['photo']); //case status title caption sh_name
                if ($repeatLastUid != $getlastUid) {
                    if ($getlastUid && $getlastUid != SES_ID) {
                        $usrDtls = $cq->getUserDtlsArr($getlastUid, $usrDtlsArr);
                        $usrName = $frmt->formatText($usrDtls['User']['name']);
                        //$usrShortName = strtoupper($usrDtls['User']['short_name']);
                        $usrShortName = ucfirst($usrDtls['User']['name']);
                    } else {
                        $usrName = "";
                        $usrShortName = "me";
                    }
                }
                $caseAll[$caseKey]['Easycase']['usrName'] = $usrName; //case status title caption name
                $caseAll[$caseKey]['Easycase']['usrShortName'] = $usrShortName; //case status title caption sh_name
                //$caseAll[$caseKey]['Easycase']['proImage'] = $frmt->formatprofileimage($getdata['User']['photo']); //case status title caption sh_name
                $caseAll[$caseKey]['Easycase']['updtedCapDt'] = $dt->dateFormatOutputdateTime_day($updated, $curCreated, '', '', 'kanban'); //case status title caption date
                //Title Caption end
                //case status start
                $caseLegend = $getdata['Easycase']['legend'];
                //case status end
                //assign info start
                $caseUserId = $getdata['Easycase']['user_id'];
                $caseAssgnUid = $getdata['Easycase']['assign_to'];
                if ($caseAssgnUid && $repeatAssgnUid != $caseAssgnUid) {
                    if ($caseAssgnUid != SES_ID) {
                        $usrAsgn = $cq->getUserDtlsArr($caseAssgnUid, $usrDtlsArr);
                        $asgnName = $frmt->formatText($usrAsgn['User']['name']);
                        //$asgnShortName = strtoupper($usrAsgn['User']['short_name']);
                        $asgnShortName = trim($frmt->shortLength(ucfirst($usrAsgn['User']['name']), 7, 1), '.');
                    } elseif ($caseAssgnUid == 0) {
                        $asgnShortName = 'Unassigned';
                        $asgnName = "";
                    } else {
                        $asgnShortName = '<span>me</span>';
                        $asgnName = "";
                    }
                }
                if (!$caseAssgnUid && $caseUserId == SES_ID) {
                    $asgnShortName = '<span>me</span>';
                    $asgnName = "";
                } elseif (!$caseAssgnUid) {
                    $usrAsgn = $cq->getUserDtlsArr($caseUserId, $usrDtlsArr);
                    $asgnName = $frmt->formatText($usrAsgn['User']['name']);
                    $asgnShortName = trim($frmt->shortLength(ucfirst($usrAsgn['User']['name']), 10), '.');
                }
                if ($caseAssgnUid == 0) {
                    $asgnShortName = 'Unassigned';
                    $asgnName = "";
                }
                $caseAll[$caseKey]['Easycase']['asgnName'] = $asgnName;
                $caseAll[$caseKey]['Easycase']['asgnShortName'] = $asgnShortName;
                if (!empty($dependency)) {
                    if (!empty($dependency['children'][$caseAll[$caseKey]['Easycase']['id']])) {
                        $caseAll[$caseKey]['Easycase']['children'] = implode(',', $dependency['children'][$caseAll[$caseKey]['Easycase']['id']]);
                    }
                    if (!empty($dependency['depends'][$caseAll[$caseKey]['Easycase']['id']])) {
                        $caseAll[$caseKey]['Easycase']['depends'] = implode(',', $dependency['depends'][$caseAll[$caseKey]['Easycase']['id']]);
                    }
                }
                //assign info end
                #$caseDueDate = $getdata['Easycase']['due_date'];
                $caseDueDate = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['due_date'], "datetime");
                if ($caseTypeId == 10 || $caseLegend == 3 || $caseLegend == 5) {
                    if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00") {
                        if ($caseDueDate < $curdtT) {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                            $csDueDate = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                        } else {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                        }
                    } else {
                        $csDuDtFmtT = '';
                        $csDuDtFmt = 'No Due Date';
                    }
                } else {
                    if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00") {
                        if ($caseDueDate < $curdtT) {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                        } else {
                            $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                            $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                        }
                    } else {
                        $csDuDtFmtT = '';
                        $csDuDtFmt = '<span class="set-due-dt">Set Due Dt</span>';
                    }
                }
                $caseDtId = $getdata['Easycase']['id'];
                //$rplyFilesArr = $this->getAllCaseFiles($caseAll[$caseKey]['Easycase']['project_id'], $caseAll[$caseKey]['Easycase']['case_no']);
                
                $rplyFilesArr_out = array();
                if ($rplyFilesArr_cno && in_array($caseAll[$caseKey]['Easycase']['case_no'], $rplyFilesArr_cno)) {
                    $ik = 0;
                    foreach ($rplyFilesArr as $fkey => $getFiles) {
                        if ($caseAll[$caseKey]['Easycase']['case_no'] == $getFiles['Easycase']['case_no'] && $caseAll[$caseKey]['Easycase']['project_id'] == $getFiles['CaseFile']['project_id']) {
                            $rplyFilesArr_out[$ik] = $getFiles;
                            $caseFileName = $getFiles['CaseFile']['file'];
                            $caseFileUName = $getFiles['CaseFile']['upload_name'] != '' ? $getFiles['CaseFile']['upload_name'] : $getFiles['CaseFile']['file'];

                            $rplyFilesArr_out[$ik]['CaseFile']['is_exist'] = 0;
                            if (trim($caseFileName)) {
                                $rplyFilesArr_out[$ik]['CaseFile']['is_exist'] = 1; //$frmt->pub_file_exists(DIR_CASE_FILES_S3_FOLDER,$caseFileName);
                            }

                            if (stristr($getFiles['CaseFile']['downloadurl'], 'www.dropbox.com')) {
                                $rplyFilesArr_out[$ik]['CaseFile']['format_file'] = 'db'; //'<img src="'.HTTP_IMAGES.'images/db16x16.png" alt="Dropbox" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                            } elseif (stristr($getFiles['CaseFile']['downloadurl'], '.google.com')) {
                                $rplyFilesArr_out[$ik]['CaseFile']['format_file'] = 'gd'; //'<img src="'.HTTP_IMAGES.'images/gd16x16.png" alt="Google" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                            } else {
                                $rplyFilesArr_out[$ik]['CaseFile']['format_file'] = substr(strrchr(strtolower($caseFileName), "."), 1); //str_replace(array('"','\''), array('\'','"'), $frmt->imageType($caseFileName,25,10,1));
                            }
                            $rplyFilesArr_out[$ik]['CaseFile']['is_ImgFileExt'] = $frmt->validateImgFileExt($caseFileUName);

                            if ($rplyFilesArr_out[$ik]['CaseFile']['is_ImgFileExt']) {
                                if (defined('USE_S3') && USE_S3 == 1) {
                                    $rplyFilesArr_out[$ik]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                                } else {
                                    $rplyFilesArr_out[$ik]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                                }
                                if (trim($rplyFilesArr_out[$ik]['CaseFile']['thumb']) != '') {
                                    $info = true; #$s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $caseFileName, S3::ACL_PRIVATE);
                                    if ($info && defined('USE_S3') && USE_S3 == 1) {
                                        $rplyFilesArr_out[$ik]['CaseFile']['fileurl_thumb'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . "thumb/" . $caseFileUName);
                                    } else {
                                        $rplyFilesArr_out[$ik]['CaseFile']['fileurl_thumb'] = HTTP_CASE_FILES . trim($rplyFilesArr_out[$ik]['CaseFile']['thumb']);
                                    }
                                } else {
                                    $rplyFilesArr_out[$ik]['CaseFile']['fileurl_thumb'] = '';
                                }
                            }

                            //$rplyFilesArr[$fkey]['CaseFile']['file_shname'] = $frmt->shortLength($caseFileName,37);
                            $rplyFilesArr_out[$ik]['CaseFile']['file_size'] = $frmt->getFileSize($getFiles['CaseFile']['file_size']);
                            $ik++;
                        }
                    }
                } else {
                    $rplyFilesArr_out = array();
                }
                $caseAll[$caseKey]['Easycase']['all_files'] = $rplyFilesArr_out;
                $caseAll[$caseKey]['Easycase']['csDuDtFmtT'] = $csDuDtFmtT;
                $caseAll[$caseKey]['Easycase']['csDuDtFmt'] = $csDuDtFmt;
                #$caseAll[$caseKey]['Easycase']['children'] = $caseAll[$caseKey]['Easycase']['children'];
                //$caseAll[$caseKey]['Easycase']['title'] = $frmt->formatTitle(ucfirst($frmt->convert_ascii($frmt->longstringwrap($getdata['Easycase']['title']))));
                $caseAll[$caseKey]['Easycase']['title'] = h($getdata['Easycase']['title'], true, 'UTF-8');
                $repeatLastUid = $getlastUid;
                $repeatAssgnUid = $caseAssgnUid;
                $repeatcaseTypeId = $caseTypeId;
                $chkDateTime = $newdate[0];
                $chkDateTime1 = $newdate_actualdate[0];
                $projIdcnt = '';//$newpjcnt;
                unset(
                        $caseAll[$caseKey]['Easycase']['updated_by'], $caseAll[$caseKey]['Easycase']['message'], $caseAll[$caseKey]['Easycase']['hours'], $caseAll[$caseKey]['Easycase']['completed_task'], $caseAll[$caseKey]['Easycase']['due_date'], $caseAll[$caseKey]['Easycase']['istype'], $caseAll[$caseKey]['Easycase']['status'], $caseAll[$caseKey]['Easycase']['dt_created'], $caseAll[$caseKey]['Easycase']['actual_dt_created'], $caseAll[$caseKey]['Easycase']['reply_type'], $caseAll[$caseKey]['Easycase']['id_seq'], $caseAll[$caseKey]['Easycase']['end_date'], $caseAll[$caseKey]['Easycase']['Mproject_id'], $caseAll[$caseKey][0], $caseAll[$caseKey]['User']
                );
                if ($taskkey == 'allTask') {
                    if (in_array(array(2,4,6), $caseAll[$caseKey]['Easycase']['custom_legend'])) {
                        $key_legend_sts = 2;
                    } else {
                        $key_legend_sts = $caseAll[$caseKey]['Easycase']['custom_legend'];
                    }
                } else {
                    $key_legend_sts = 0;
                }
                if ($key_legend_sts) {
                    if ($key_legend_sts == 4) {
                        $key_legend_sts = 2;
                    }
                    $key_separator = 'kanban_board_'.$key_legend_sts;
                    if ($retarr && array_key_exists($key_separator, $retarr)) {
                        array_push($retarr[$key_separator], $caseAll[$caseKey]);
                    } else {
                        $retarr[$key_separator][0] = $caseAll[$caseKey];
                    }
                }
            }
            if (!$key_legend_sts) {
                $retarr[$taskkey] = $caseAll;
            }
        }
        //}
        //		if($caseMenuFilters == "milestone" && count($milestones)) {
        //			foreach($milestones AS $key =>$ms){
        //				if(!$ms['totalcases']){
        //					$endDate = $ms['end_date']." ".$curTime;
        //					$days = $dt->dateDiff($endDate,$curCreated);
//
        //					$milestones[$key]['days_diff'] = $days;
//
        //					$mlstDT = $dt->dateFormatOutputdateTime_day($ms['end_date'],GMT_DATETIME,'week');
        //					$milestones[$key]['mlstDT'] = $mlstDT;
        //					$milestones[$key]['intEndDate'] = strtotime($ms['end_date']);
        //				} else {
        //					unset(
        //						$milestones[$key]['title'],
        //						$milestones[$key]['uinq_id'],
        //						$milestones[$key]['isactive'],
        //						$milestones[$key]['user_id']
        //					);
        //				}
//
        //				unset(
        //					$milestones[$key]['end_date']
        //				);
        //			}
        //		}
        //return array('caseAll' => $caseAll, 'milestones' => $milestones);
        return $retarr;
    }

    public function formatReplies($sqlcasedata, $allUserArr, $frmt, $cq, $tz, $dt, $completedtask=null)
    {
        $CSrepcount = 0;
        App::import('Component', 'Format');
        /**
         * The instance of ComponentCollection is required as a Component is called in model
         * or else it will throw error in debug mode
         */
        $format = new FormatComponent(new ComponentCollection);

        App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));
        $s3 = new S3(awsAccessKey, awsSecretKey);
        /*check for custom status*/
        $cust_sts_list = array();
        if ($sqlcasedata && $sqlcasedata[0]['Easycase']['custom_status_id']) {
            $sts_grp_id = $format->hasCustomTaskStatus($sqlcasedata[0]['Easycase']['project_id'], 'Project.id');
            if ($sts_grp_id) {
                $cust_sts_list = $format->getCustomTaskStatus($sts_grp_id, 'list');
            }
        }
        foreach ($sqlcasedata as $caseKey => $getdata) {
            $caseDtUid = $getdata['Easycase']['user_id'];
            $csUsrDtlArr = $cq->getUserDtlsArr($caseDtUid, $allUserArr);
            $by_photo = $csUsrDtlArr['User']['photo'];

            $csUsrDtlArr['User']['photo_exist'] = 0;
            if (trim($by_photo)) {
                $csUsrDtlArr['User']['photo_exist'] = 1; //$frmt->pub_file_exists(DIR_USER_PHOTOS_S3_FOLDER,$by_photo);
            } else {
                $csUsrDtlArr['User']['photo_existBg'] = $frmt->getProfileBgColr($csUsrDtlArr['User']['id']);
            }

            $sqlcasedata[$caseKey]['Easycase']['userArr'] = $csUsrDtlArr;
            //$getdata['Easycase']['message'] = preg_replace('/<script.*>.*<\/script>/ims', '', $getdata['Easycase']['message']);
            //$getdata['Easycase']['message'] =  $frmt->convert_ascii($getdata['Easycase']['message']);
            $getdata['Easycase']['message'] = preg_replace('/<script.*>.*<\/script>/ims', '', $getdata['Easycase']['message']);
            if ($getdata['Easycase']['legend'] == 6) {
                $sqlcasedata[$caseKey]['Easycase']['wrap_msg'] = '';
            } else {
                if ($getdata['Easycase']['message']) {
                    $CSrepcount ++;
                }
                $sqlcasedata[$caseKey]['Easycase']['wrap_msg'] = $frmt->html_wordwrap($frmt->formatCms($getdata['Easycase']['message']), 75);
            }
            $caseDtId = $getdata['Easycase']['id'];
            $rplyFilesArr = $this->getCaseFiles($caseDtId);
            foreach ($rplyFilesArr as $fkey => $getFiles) {
                $caseFileName = $getFiles['CaseFile']['file'];
                $caseFileUName = $getFiles['CaseFile']['upload_name'] != '' ? $getFiles['CaseFile']['upload_name'] : $getFiles['CaseFile']['file'];

                $rplyFilesArr[$fkey]['CaseFile']['is_exist'] = 0;
                if (trim($caseFileName)) {
                    $rplyFilesArr[$fkey]['CaseFile']['is_exist'] = 1; //$frmt->pub_file_exists(DIR_CASE_FILES_S3_FOLDER,$caseFileName);
                }

                if (stristr($getFiles['CaseFile']['downloadurl'], 'www.dropbox.com')) {
                    $rplyFilesArr[$fkey]['CaseFile']['format_file'] = 'db'; //'<img src="'.HTTP_IMAGES.'images/db16x16.png" alt="Dropbox" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                } elseif (stristr($getFiles['CaseFile']['downloadurl'], '.google.com')) {
                    $rplyFilesArr[$fkey]['CaseFile']['format_file'] = 'gd'; //'<img src="'.HTTP_IMAGES.'images/gd16x16.png" alt="Google" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                } else {
                    $rplyFilesArr[$fkey]['CaseFile']['format_file'] = substr(strrchr(strtolower($caseFileName), "."), 1); //str_replace(array('"','\''), array('\'','"'), $frmt->imageType($caseFileName,25,10,1));
                }
                $rplyFilesArr[$fkey]['CaseFile']['is_ImgFileExt'] = $frmt->validateImgFileExt($caseFileUName);

                if ($rplyFilesArr[$fkey]['CaseFile']['is_ImgFileExt']) {
                    if (defined('USE_S3') && USE_S3 == 1) {
                        $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                    } else {
                        $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                    }
                    if (trim($rplyFilesArr[$fkey]['CaseFile']['thumb']) != '') {
                        $info = true; #$s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $caseFileName, S3::ACL_PRIVATE);
                        if ($info && defined('USE_S3') && USE_S3 == 1) {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . "thumb/" . $caseFileUName);
                        } else {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = HTTP_CASE_FILES . trim($rplyFilesArr[$fkey]['CaseFile']['thumb']);
                        }
                    } else {
                        $rplyFilesArr[$fkey]['CaseFile']['fileurl_thumb'] = '';
                    }
                } else {
                    $rplyFilesArr[$fkey]['CaseFile']['is_PdfFileExt'] = $frmt->validatePdfFileExt($caseFileUName);
                    if ($rplyFilesArr[$fkey]['CaseFile']['is_PdfFileExt']) {
                        if (defined('USE_S3') && USE_S3 == 1) {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                        } else {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                        }
                    } else {
                        if (defined('USE_S3') && USE_S3 == 1) {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                        } else {
                            $rplyFilesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                        }
                    }
                }

                //$rplyFilesArr[$fkey]['CaseFile']['file_shname'] = $frmt->shortLength($caseFileName,37);
                $rplyFilesArr[$fkey]['CaseFile']['file_size'] = $frmt->getFileSize($getFiles['CaseFile']['file_size']);
            }
            $sqlcasedata[$caseKey]['Easycase']['rply_files'] = $rplyFilesArr;

            $caseReplyType = $getdata['Easycase']['reply_type'];
            $caseDtMsg = $getdata['Easycase']['message'];
            $caseDtLegend = $getdata['Easycase']['legend'];
            $caseAssignTo = $getdata['Easycase']['assign_to'];
            $taskhourspent = $getdata['Easycase']['hours'];
            $taskcompleted = $getdata['Easycase']['completed_task'];
            $replyCap = '';
            $asgnTo = '';
            $sts = '';
            $hourspent = '';
            $completed = '';
            if (($caseReplyType == 0 || $caseReplyType == 6) && $caseDtMsg != '') {
                if ($caseDtLegend == 1) {
                    $sts = '<b class="new">'.__('New', true).'</b>';
                } elseif ($caseDtLegend == 2 || $caseDtLegend == 4) {
                    $sts = '<b class="wip">'.__('In Progress', true).'</b>';
                } elseif ($caseDtLegend == 3) {
                    $sts = '<b class="closed">'.__('Closed', true).'</b>';
                } elseif ($caseDtLegend == 5) {
                    $sts = '<b class="resolved">'.__('Resolved', true).'</b>';
                }

                $userArr1 = $cq->getUserDtlsArr($caseAssignTo, $allUserArr);

                $by_id1 = $userArr1['User']['id'];
                $by_email1 = $userArr1['User']['email'];
                $by_name_assign1 = $userArr1['User']['name'];
                $by_photo1 = $userArr1['User']['photo'];
                $short_name_assign1 = $userArr1['User']['short_name'];
                //$replyCap .= ',&nbsp;&nbsp;Assigned To: <font color="black">'.$by_name_assign1.'('.$short_name_assign1.')</font>';
                $asgnTo = $by_name_assign1; //.' ('.$short_name_assign1.')';

                if ($taskhourspent != "0.0") {
                    $hourspent = $taskhourspent;
                }

                if ($taskcompleted != "0") {
                    $completed = $taskcompleted;
                }

                //$replyCap .= '<br />';
            }

            if ($getdata['Easycase']['istype'] == 1) {
                $replyCap = '<b class="created">'.__('Created', true).'</b> '.__('the Task', true);
            } else {
                if ($caseReplyType == 0 && ($caseDtMsg == '' || $caseDtLegend == 6)) {
                    if ($getdata['Easycase']['custom_status_id']) {
                        $replyCap = __('Changed the status of the task to', true).' <b class="resolved">'.__($cust_sts_list[$getdata['Easycase']['custom_status_id']], true).'</b>';
                    } else {
                        if ($caseDtLegend == 3) {
                            $replyCap = '<b class="closed">'.__('Closed', true).'</b> '.__('the Task', true);
                        } elseif ($caseDtLegend == 4 || $caseDtLegend == 2) {
                            $replyCap = '<b class="wip">'.__('Started', true).'</b> '.__('the Task', true);
                        } elseif ($caseDtLegend == 5) {
                            $replyCap = '<b class="resolved">'.__('Resolved', true).'</b> '.__('the Task', true);
                        } elseif ($caseDtLegend == 6) {
                            $replyCap = '<b class="resolved">'.__('Modified', true).'</b> '.__('the Task', true);
                        } elseif ($caseDtLegend == 1) {
                            $replyCap = __('Changed the status of the task to', true).' <b class="resolved">'.__('New', true).'</b>';
                        }
                    }
                } else {
                    if ($caseReplyType == 1) {
                        $caseDtTyp = $getdata['Easycase']['type_id'];
                        $prjtype_name = $cq->getTypeArr($caseDtTyp, $GLOBALS['TYPE']);
                        $name = $prjtype_name['Type']['name'];
                        $sname = $prjtype_name['Type']['short_name'];
                        $Type = ClassRegistry::init('Type');
                        $Type->recursive = -1;
                        $Type_name = $Type->find('first', array('conditions' => array('Type.id' => $caseDtTyp), 'fields' => array('Type.name')));
                        $image = $frmt->todo_typ($sname, $name);
                        $replyCap = 'Updated task type to  <b>' . $Type_name['Type']['name'] . '</b>';
                    } elseif ($caseReplyType == 2) {
                        if ($caseAssignTo == 0) {
                            $replyCap = __('Task re-assigned to', true).' <b class="ttc">'.__('Nobody', true).'</b>';
                        } else {
                            $userArr = $cq->getUserDtlsArr($caseAssignTo, $allUserArr);
                            $by_id = $userArr['User']['id'];
                            $by_email = $userArr['User']['email'];
                            $by_name_assign = $userArr['User']['name'];
                            $by_last_name_assign = $userArr['User']['last_name'];
                            $short_name_assign = $userArr['User']['short_name'];
                            $by_photo = $userArr['User']['photo'];
                            //$short_name_assign = $userArr['User']['short_name'];
                            $replyCap = __('Task re-assigned to', true).' <b class="ttc">' . $by_name_assign .'</b>('.$short_name_assign.')';
                        }
                    } elseif ($caseReplyType == 3) {
                        #$caseDtDue = $getdata['Easycase']['due_date'];
                        $caseDtDue = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getdata['Easycase']['due_date'], "datetime");
                        $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                        if ($caseDtDue != "NULL" && $caseDtDue != "0000-00-00 00:00:00" && $caseDtDue != "" && $caseDtDue != "1970-01-01 00:00:00") {
                            $due_date = $dt->dateFormatOutputdateTime_day($caseDtDue, $curCreated, 'week');
                            $replyCap = __('Updated due date to', true).' <b>' . $due_date . '</b>';
                        } else {
                            $replyCap = __('Due Date', true).': <i>'.__('No Due Date', true).'</i>';
                        }
                    } elseif ($caseReplyType == 4) {
                        $casePriority = $getdata['Easycase']['priority'];
                        if ($casePriority == 0) {
                            $replyCap = __('Updated priority to', true) . ' <b class="pr_high">' . __('High', true) . '</b>';
                        } elseif ($casePriority == 1) {
                            $replyCap = __('Updated priority to', true) . ' <b class="pr_medium">' . __('Medium', true) . '</b>';
                        } elseif ($casePriority == 2) {
                            $replyCap = __('Updated priority to', true) . ' <b class="pr_low">' . __('Low', true) . '</b>';
                        }
                    } elseif ($caseReplyType == 5) {
                        $caseEstHour = $format->format_time_hr_min($getdata['Easycase']['estimated_hours']);
                        $replyCap = __('Updated estimated hour(s) to', true).' <b>' . $caseEstHour . '</b>';
                    } elseif ($caseReplyType == 6) {
                        $completed = $getdata['Easycase']['completed_task'];
                        $replyCap = __('Updated task progress to', true).' <b>' . $completed . '%</b>';
                    } elseif ($caseReplyType == 7) {
                        $titl = $this->formatTitle($getdata['Easycase']['title']);
                        $replyCap = __('Changed task title to', true).' "<b>' . $titl . '</b>"';
                    } elseif ($caseReplyType == 8) {
                        $replyCap = __('Removed a file from this task', true);
                    } elseif ($caseReplyType == 9) {
                        $replyCap = __('Updated the status of this task', true);
                    } elseif ($caseReplyType == 10) {
                        $replyCap = __('Added time log', true);
                    } elseif ($caseReplyType == 11) {
                        $replyCap = __('Updated time log', true);
                    // Here Activity for Set favorite task
                    } elseif ($caseReplyType == 13) {
                        $replyCap = __('Set as favorite task', true);
                    // Here Activity for Remove favorite task
                    } elseif ($caseReplyType == 14) {
                        $replyCap = __('Removed as favorite task', true);
                    } elseif ($caseReplyType == 15) {
                        $replyCap = __('Added story point', true);
                    } elseif ($caseReplyType == 16) {
                        $replyCap = __('Updated story point', true);
                    }
                }
            }
            $sqlcasedata[$caseKey]['Easycase']['sts'] = $sts;
            $sqlcasedata[$caseKey]['Easycase']['asgnTo'] = $asgnTo;
            $sqlcasedata[$caseKey]['Easycase']['hourspent'] = $hourspent;
            $sqlcasedata[$caseKey]['Easycase']['completed'] = $completed;
            $sqlcasedata[$caseKey]['Easycase']['replyCap'] = $replyCap;
            if ($getdata['Easycase']['istype'] == 1) {
                $caseDtActdT = $getdata['Easycase']['actual_dt_created'];
            } else {
                $caseDtActdT = $getdata['Easycase']['dt_created'];
            }
            //$updated_by = $getdata['Easycase']['updated_by'];
            $replyDt = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $caseDtActdT, "datetime");
            $curDate = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if ($caseDtUid == SES_ID && 0) {
                $usrName = "me";
            } else {
                $usrName = $csUsrDtlArr['User']['name'];
            }
            $sqlcasedata[$caseKey]['Easycase']['usrName'] = $usrName;
            $sqlcasedata[$caseKey]['Easycase']['rply_dt'] = $dt->dateFormatOutputdateTime_day($replyDt, $curDate);
            $sqlcasedata[$caseKey]['Easycase']['CSrep_count'] = $CSrepcount;

            unset(
                //$sqlcasedata[$caseKey]['Easycase']['uniq_id'],
                $sqlcasedata[$caseKey]['Easycase']['case_no'], $sqlcasedata[$caseKey]['Easycase']['case_count'],$sqlcasedata[$caseKey]['Easycase']['thread_count'], $sqlcasedata[$caseKey]['Easycase']['updated_by'], $sqlcasedata[$caseKey]['Easycase']['type_id'], $sqlcasedata[$caseKey]['Easycase']['priority'], $sqlcasedata[$caseKey]['Easycase']['title'], $sqlcasedata[$caseKey]['Easycase']['reply_type'], $sqlcasedata[$caseKey]['Easycase']['assign_to'], $sqlcasedata[$caseKey]['Easycase']['completed_task'], $sqlcasedata[$caseKey]['Easycase']['hours'], $sqlcasedata[$caseKey]['Easycase']['due_date'], $sqlcasedata[$caseKey]['Easycase']['istype'], $sqlcasedata[$caseKey]['Easycase']['status'], $sqlcasedata[$caseKey]['Easycase']['isactive'], $sqlcasedata[$caseKey]['Easycase']['dt_created'], $sqlcasedata[$caseKey]['Easycase']['actual_dt_created'], $sqlcasedata[$caseKey]['Easycase']['caseReplyType'], $sqlcasedata[$caseKey]['Easycase']['userArr']['User']['id'], $sqlcasedata[$caseKey]['Easycase']['userArr']['User']['email'], $sqlcasedata[$caseKey]['Easycase']['userArr']['User']['istype']
            );
        }
        $arr['CSrepcount'] = $CSrepcount;
        $arr['sqlcasedata'] = $sqlcasedata;
        //$sqlcasedata['CSrepcount']=$CSrepcount;
        //return $sqlcasedata;
        return $arr;
    }

    public function formatTitle($title)
    {
        if (isset($title) && !empty($title)) {
            $title = htmlspecialchars(html_entity_decode($title, ENT_QUOTES, 'UTF-8'));
        }
        return $title;
    }

    //From CasequeryHelper.php
    public function getMilestoneName($caseid, $proj_id=null)
    {
        $Milestone = ClassRegistry::init('Milestone');
        $Milestone->recursive = -1;

        $proj_cond = "";
        if ($proj_id) {
            $proj_cond = " AND EasycaseMilestone.project_id='" . $proj_id . "'";
        }
        $milestones = $Milestone->query("SELECT Milestone.title as title FROM milestones as Milestone,easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.milestone_id=Milestone.id AND EasycaseMilestone.easycase_id='" . $caseid . "'".$proj_cond);
        if (isset($milestones['0']['Milestone']['title']) && $milestones['0']['Milestone']['title']) {
            return $milestones['0']['Milestone']['title'];
        } else {
            return false;
        }
    }

    public function getMilestoneId($caseid, $proj_id=null)
    {
        $Milestone = ClassRegistry::init('Milestone');
        $Milestone->recursive = -1;

        $proj_cond = "";
        if ($proj_id) {
            $proj_cond = " AND EasycaseMilestone.project_id='" . $proj_id . "'";
        }
        $proj_cond = "";
        $milestones = $Milestone->query("SELECT Milestone.id as mid FROM milestones as Milestone,easycase_milestones AS EasycaseMilestone WHERE EasycaseMilestone.milestone_id=Milestone.id AND EasycaseMilestone.easycase_id='" . $caseid . "'".$proj_cond);
        if (isset($milestones['0']['Milestone']['mid']) && $milestones['0']['Milestone']['mid']) {
            return $milestones['0']['Milestone']['mid'];
        } else {
            return false;
        }
    }

    public function getCaseFiles($cid, $csno=null, $proj=null)
    {
        App::import('Model', 'CaseFile');
        $CaseFile = new CaseFile();
        $CaseFile->recursive = -1;
        if ($csno && $proj) {
            $allTasksids = $this->find('all', array('conditions' => array('Easycase.project_id' => $proj, 'Easycase.case_no' => $csno), 'fields' => array('Easycase.id'),'order'=>array('Easycase.istype'=>'ASC')));
            $cid = Hash::extract($allTasksids, '{n}.Easycase.id');
        }
        $caseFiles = $CaseFile->find('all', array(
            'conditions' => array('CaseFile.easycase_id' => $cid, 'CaseFile.comment_id' => 0, 'CaseFile.isactive' => 1),
            'fields' => array('CaseFile.id', 'CaseFile.file', 'CaseFile.upload_name', 'CaseFile.display_name', 'CaseFile.file_size', 'CaseFile.downloadurl', 'CaseFile.thumb'),
            'order' => array('CaseFile.file ASC')));
        return $caseFiles;
    }
    public function getCountofChecklist($curCaseId, $prjid)
    {
        $CheckListModel = ClassRegistry::init('CheckList');
        $AllchklstDtl = $CheckListModel->find('all', array('conditions' => array('CheckList.company_id' => SES_COMP, 'CheckList.easycase_id' => $curCaseId, 'CheckList.project_id' => $prjid),'order'=>array('CheckList.sequence'=>'ASC')));

        $countCheckAll = $CheckListModel->find('all', array('conditions' => array('CheckList.company_id' => SES_COMP, 'CheckList.easycase_id' => $curCaseId, 'CheckList.project_id' => $prjid, 'CheckList.is_checked' => 1)));
        $checkList['checked'] = count($countCheckAll);
        $checkList['all'] = count($AllchklstDtl);
        return $checkList;
    }
    public function getAllCaseFiles($pid, $cno)
    {
        if (!$pid || !$cno) {
            return false;
        }

        App::import('Model', 'CaseFile');
        $CaseFile = new CaseFile();
        if ($cno == 'kanban') {
            $CaseFile->bindModel(array(
            'belongsTo' => array(
                'Easycase' => array(
                    'className' => 'Easycase',
                    'foreignKey' => 'easycase_id'
                    )
                )
                ), false);
            //$CaseFile->recursive = -1;
            $filesArr = $CaseFile->find(
                'all',
                array(
                'conditions' => array('CaseFile.project_id' => $pid, 'CaseFile.isactive' => 1),
                'fields' => array('CaseFile.id', 'CaseFile.file', 'CaseFile.display_name', 'CaseFile.upload_name', 'CaseFile.file_size', 'CaseFile.downloadurl', 'CaseFile.thumb','CaseFile.easycase_id','CaseFile.project_id','Easycase.case_no'),
                'order' => array('Easycase.actual_dt_created DESC','CaseFile.file ASC'))
            );
        } else {
            $CaseFile->bindModel(array(
            'belongsTo' => array(
                'Easycase' => array(
                    'className' => 'Easycase',
                    'foreignKey' => 'easycase_id'
                )
            )
                ), false);
            $filesArr = $CaseFile->find(
                'all',
                array(
            'conditions' => array('Easycase.project_id' => $pid, 'Easycase.case_no' => $cno, 'CaseFile.isactive' => 1),
            'fields' => array('CaseFile.id', 'CaseFile.file', 'CaseFile.display_name', 'CaseFile.upload_name', 'CaseFile.file_size', 'CaseFile.downloadurl', 'Easycase.actual_dt_created', 'CaseFile.thumb'),
            'order' => array('Easycase.actual_dt_created DESC', 'CaseFile.file ASC'))
            );
        }
        return $filesArr;
    }

    public function formatFiles($filesArr, $frmt, $tz, $dt)
    {
        if ($filesArr) {
            App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $curDateTz = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");

            foreach ($filesArr as $fkey => $getFiles) {
                $caseFileName = $getFiles['CaseFile']['file'];
                $caseFileUName = $getFiles['CaseFile']['upload_name'] != '' ? $getFiles['CaseFile']['upload_name'] : $getFiles['CaseFile']['file'];

                $filesArr[$fkey]['CaseFile']['is_exist'] = 0;
                if (trim($caseFileName)) {
                    $filesArr[$fkey]['CaseFile']['is_exist'] = 1;
                }

                $downloadurl = $getFiles['CaseFile']['downloadurl'];
                if (isset($downloadurl) && trim($downloadurl)) {
                    if (stristr($downloadurl, 'www.dropbox.com')) {
                        $filesArr[$fkey]['CaseFile']['format_file'] = 'db'; //'<img src="'.HTTP_IMAGES.'images/db16x16.png" alt="Dropbox" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                    } else {
                        $filesArr[$fkey]['CaseFile']['format_file'] = 'gd'; //'<img src="'.HTTP_IMAGES.'images/gd16x16.png" alt="Google" title="'.$caseFileName.'" width="16" height="16" border="0" style="border:0px solid #C3C3C3" />';
                    }
                } else {
                    $filesArr[$fkey]['CaseFile']['format_file'] = substr(strrchr(strtolower($caseFileName), "."), 1); //str_replace(array('"','\''), array('\'','"'), $frmt->imageType($caseFileName,25,10,1));
                    $filesArr[$fkey]['CaseFile']['is_ImgFileExt'] = $frmt->validateImgFileExt($caseFileUName);
                    if ($filesArr[$fkey]['CaseFile']['is_ImgFileExt']) {
                        if (defined('USE_S3') && USE_S3 == 1) {
                            $filesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                        } else {
                            $filesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                        }
                        if (trim($filesArr[$fkey]['CaseFile']['thumb']) != '') {
                            $info = true; #$s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $caseFileName, S3::ACL_PRIVATE);
                            if ($info && defined('USE_S3') && USE_S3 == 1) {
                                $filesArr[$fkey]['CaseFile']['fileurl_thumb'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . "thumb/" . $caseFileUName);
                            } else {
                                $filesArr[$fkey]['CaseFile']['fileurl_thumb'] = HTTP_CASE_FILES . trim($filesArr[$fkey]['CaseFile']['thumb']);
                            }
                        } else {
                            $filesArr[$fkey]['CaseFile']['fileurl_thumb'] = '';
                        }
                    } else {
                        $filesArr[$fkey]['CaseFile']['is_PdfFileExt'] = $frmt->validatePdfFileExt($caseFileUName);
                        if ($filesArr[$fkey]['CaseFile']['is_PdfFileExt']) {
                            if (defined('USE_S3') && USE_S3 == 1) {
                                $filesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                            } else {
                                $filesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                            }
                        } else {
                            if (defined('USE_S3') && USE_S3 == 1) {
                                $filesArr[$fkey]['CaseFile']['fileurl'] = $frmt->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileUName);
                            } else {
                                $filesArr[$fkey]['CaseFile']['fileurl'] = HTTP_CASE_FILES . $caseFileUName;
                            }
                        }
                    }
                    $filesArr[$fkey]['CaseFile']['file_size'] = $frmt->getFileSize($getFiles['CaseFile']['file_size']);
                }

                $caseDtActdT = $getFiles['Easycase']['actual_dt_created'];
                $replyDt = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $caseDtActdT, "datetime");
                $filesArr[$fkey]['CaseFile']['file_date'] = $dt->dateFormatOutputdateTime_day($replyDt, $curDateTz);
            }
        }
        return $filesArr;
    }

    public function getUserEmail($id)
    {
        $CaseUserEmail = ClassRegistry::init('CaseUserEmail');
        $CaseUserEmail->recursive = -1;
        $userIds = $CaseUserEmail->find('all', array('conditions' => array('CaseUserEmail.easycase_id' => $id, 'CaseUserEmail.ismail' => 1), 'fields' => array('CaseUserEmail.user_id')));
        return $userIds;
    }

    //End CasequeryHelper.php
    //From FormatComponent.php
    public function getMemebers($projId, $type = null, $comp_id = null, $no_noti = 0)
    {
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $user = ClassRegistry::init('User');
        $company_id = ($comp_id) ? $comp_id : SES_COMP;
        if ($projId == 'all') {
            $quickMem = $ProjectUser->query("SELECT DISTINCT User.id,User.uniq_id,CompanyUser.is_client, User.name, User.last_name, User.email, User.istype,User.short_name,User.photo, UserNotification.new_case FROM users as User,project_users as ProjectUser,company_users as CompanyUser, user_notifications as UserNotification WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . $company_id . "'  AND User.isactive='1' AND ProjectUser.user_id=User.id AND UserNotification.user_id=User.id ORDER BY User.name ASC");
        } else {
            if ($no_noti) {
                $quickMem = $ProjectUser->query("SELECT DISTINCT User.id,User.uniq_id,CompanyUser.is_client, User.name, User.last_name, User.email, User.istype,User.short_name,User.photo FROM users as User,project_users as ProjectUser,company_users as CompanyUser,projects as Project WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . $company_id . "' AND Project.uniq_id='" . $projId . "' AND Project.id=ProjectUser.project_id AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.name ASC");
            } else {
                $quickMem = $ProjectUser->query("SELECT DISTINCT User.id,User.uniq_id,CompanyUser.is_client, User.name, User.last_name, User.email, User.istype,User.short_name,User.photo, UserNotification.new_case  FROM users as User,project_users as ProjectUser,company_users as CompanyUser,projects as Project, user_notifications as UserNotification WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . $company_id . "' AND Project.uniq_id='" . $projId . "' AND Project.id=ProjectUser.project_id AND User.isactive='1' AND ProjectUser.user_id=User.id AND UserNotification.user_id=User.id  ORDER BY User.name ASC");
            }
        }
        $t_arr = array();
        if ($quickMem) {
            foreach ($quickMem as $k => $v) {
                if ($v['User']['photo'] == '') {
                    $quickMem[$k]['User']['asgnbgcolor'] = $user->getProfileBgColr($v['User']['id']);
                }
                //add newly on 26-09-2017
                if (!empty($v['User']['last_name'])) {
                    $quickMem[$k]['User']['name'] .= ' '.$v['User']['last_name'];
                }
                $quickMem[$k]['User']['is_client'] = $v['CompanyUser']['is_client'];
                if (!in_array($quickMem[$k]['User']['id'], $t_arr)) {
                    array_push($t_arr, $quickMem[$k]['User']['id']);
                } else {
                    unset($quickMem[$k]);
                }
            }
        }
        return $quickMem;
    }

    public function getAllCompUsers($comp_id, $login_user)
    {
        if ($comp_id) {
            $User = ClassRegistry::init('User');
            $sql = 'SELECT email FROM users where id IN(SELECT user_id FROM company_users WHERE company_id=' . $comp_id . ' AND user_type=3 AND is_active=1) AND id != ' . $login_user . ' ORDER BY email DESC';
            $res = $User->query($sql);
            if ($res) {
                $res = Hash::extract($res, '{n}.users.email');
                $res = implode(', ', $res);
                return $res;
            } else {
                return '';
            }
        } else {
            return true;
        }
    }

    public function getMemebersid($projId)
    {
        $ProjectUser = ClassRegistry::init('ProjectUser');

        //$quickMem = $ProjectUser->find('all', array('conditions' => array('Project.id' => $projId,'User.isactive' => 1,'Project.company_id' => SES_COMP),'fields' => array('DISTINCT User.id','User.name','User.istype','User.email','User.short_name'),'order' => array('User.name')));

        $quickMem = $ProjectUser->query("SELECT DISTINCT User.id,User.uniq_id, User.name, User.last_name, User.email, User.istype,User.short_name,CompanyUser.is_client, User.photo FROM users as User,project_users as ProjectUser,company_users as CompanyUser WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' AND ProjectUser.project_id='" . $projId . "' AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.name ASC");

        return $quickMem;
    }

    //End FormatComponent.php
    public function getCaseNo($case_uniq_id)
    {
        return $this->find('first', array('conditions' => array('Easycase.uniq_id' => $case_uniq_id), 'fields' => array('Easycase.case_no')));
    }

    public function getCaseTitle($project_id, $case_no)
    {
        $caseTitle = '';
        if (!$project_id) {
            $csTtl = $this->find('first', array('conditions' => array('Easycase.id' => $case_no, 'istype' => 1), 'fields' => array('Easycase.title')));
        } else {
            $csTtl = $this->find('first', array('conditions' => array('Easycase.project_id' => $project_id, 'Easycase.case_no' => $case_no, 'istype' => 1), 'fields' => array('Easycase.title')));
        }
        if ($csTtl) {
            $caseTitle = $csTtl['Easycase']['title'];
        }
        return $caseTitle;
    }
    public function parenthasParent($esid)
    {
        $csTtl = $this->find('first', array('conditions' => array('Easycase.id' =>$esid, 'istype' => 1), 'fields' => array('Easycase.parent_task_id','Easycase.id')));
        return ($csTtl && $csTtl['Easycase']['parent_task_id'])?$csTtl['Easycase']['parent_task_id']:0;
    }
    public function getCaseIdFrmCaseNo($project_id, $case_no)
    {
        App::import('Model', 'EasycaseMilestone');
        $EasycaseMilestone = new EasycaseMilestone();
        $caseID = '';
        if (!$project_id) {
            $csTtl = $this->find('first', array('conditions' => array('Easycase.id' => $case_no, 'istype' => 1), 'fields' => array('Easycase.id','Easycase.parent_task_id','Easycase.project_id')));
        } else {
            $csTtl = $this->find('first', array('conditions' => array('Easycase.project_id' => $project_id, 'Easycase.case_no' => $case_no, 'istype' => 1), 'fields' => array('Easycase.id','Easycase.parent_task_id','Easycase.project_id')));
        }
        if ($csTtl && !empty($csTtl['Easycase']['parent_task_id'])) {
            //$caseID = $csTtl['Easycase']['id'];
            $retSA_id = $this->parenthasParent($csTtl['Easycase']['parent_task_id']);
            if ($retSA_id) {
                $mil_id = $EasycaseMilestone->getCurrentMilestone($retSA_id, $csTtl['Easycase']['project_id']);
            } else {
                $mil_id = $EasycaseMilestone->getCurrentMilestone($csTtl['Easycase']['parent_task_id'], $csTtl['Easycase']['project_id']);
            }
            $csTtl['Easycase']['milestone_id']=$mil_id;
        }
        return $csTtl;
    }

    public function getLastResolved($projId, $caseNo)
    {
        return $this->find(
            'first',
            array(
                    'conditions' => array('Easycase.project_id' => $projId, 'Easycase.case_no' => $caseNo, 'Easycase.legend' => '5'),
                    'fields' => array('Easycase.dt_created'),
                    'order' => 'Easycase.dt_created DESC'
                        )
        );
    }

    public function getLastClosed($projId, $caseNo)
    {
        return $this->find(
            'first',
            array(
                    'conditions' => array('Easycase.project_id' => $projId, 'Easycase.case_no' => $caseNo, 'Easycase.legend' => '3'),
                    'fields' => array('Easycase.dt_created'),
                    'order' => 'Easycase.dt_created DESC'
                        )
        );
    }

    public function getEasycase($case_uniq_id)
    {
        $thisCase = $this->find('first', array('conditions' => array('Easycase.uniq_id' => $case_uniq_id), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.isactive', 'Easycase.istype', 'Easycase.custom_status_id','Easycase.due_date', 'Easycase.legend', 'Easycase.gantt_start_date', 'Easycase.actual_dt_created'))); //,'Easycase.istype' => 1
        if ($thisCase && $thisCase['Easycase']['istype'] != 1) {
            $thisCase = $this->find('first', array('conditions' => array('Easycase.case_no' => $thisCase['Easycase']['case_no'], 'Easycase.project_id' => $thisCase['Easycase']['project_id'], 'istype' => 1), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.isactive', 'Easycase.custom_status_id','Easycase.due_date', 'Easycase.legend', 'Easycase.gantt_start_date', 'Easycase.actual_dt_created')));
        }
        return $thisCase;
    }
    public function getEasycaseById($case_id)
    {
        $thisCase = $this->find('first', array('conditions' => array('Easycase.id' => $case_id), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.isactive', 'Easycase.istype', 'Easycase.custom_status_id','Easycase.due_date'))); //,'Easycase.istype' => 1
        if ($thisCase && $thisCase['Easycase']['istype'] != 1) {
            $thisCase = $this->find('first', array('conditions' => array('Easycase.case_no' => $thisCase['Easycase']['case_no'], 'Easycase.project_id' => $thisCase['Easycase']['project_id'], 'istype' => 1), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.isactive', 'Easycase.custom_status_id')));
        }
        return $thisCase;
    }
    public function getEasycaseUsingId($case_uniq_id)
    {
        $thisCase = $this->find('first', array('conditions' => array('Easycase.id' => $case_uniq_id,'Easycase.istype' => 1), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.isactive', 'Easycase.istype','Easycase.uniq_id', 'Easycase.legend','Easycase.custom_status_id')));
        return $thisCase;
    }
    public function checkvalidCaseno($proj_id, $case_no)
    {
        $thisCaseRes = $this->find('first', array('conditions' => array('Easycase.project_id' => $proj_id,'Easycase.case_no' => $case_no), 'fields' => array('Easycase.id', 'Easycase.case_no', 'Easycase.project_id')));
        if ($thisCaseRes) {
            $thisCaseRes = $this->find('first', array('conditions' => array('Easycase.project_id' => $proj_id), 'fields' => array('Easycase.id', 'Easycase.case_no'),'order' => array('Easycase.id DESC')));
            $case_no = $thisCaseRes['Easycase']['case_no']++;
        }
        return $case_no;
    }

    public function getTaskUser($projId, $caseNo)
    {
        if (!$projId || !$caseNo) {
            return false;
        }

        return $this->query("SELECT DISTINCT User.id, User.name, User.last_name, User.email, User.istype,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id='" . $projId . "' AND Easycase.case_no='" . $caseNo . "' AND Easycase.istype IN('1','2') ORDER BY User.short_name");
    }
    /*
     Author:Sangita
     function to Calculate and add ACF field values on changing task status to closed
    */
    public function advCustomFieldAction($taskId)
    {
        $easycase = $this->find('first', array('conditions' => array('Easycase.id' => $taskId)));
        $currDateTime = GMT_DATETIME;
      
        $taskCmplDate = $currDateTime;
        if (!empty($easycase['Easycase']['gantt_start_date'])) {
            $taskStartDate = $easycase['Easycase']['gantt_start_date'];
        } else {
            $taskStartDate = $easycase['Easycase']['actual_dt_created'];
        }
        $dateStart = new DateTime($taskStartDate);
        $currentDate = new DateTime($currDateTime);
        if ($dateStart > $currentDate) {
            $taskDurationValue = 0;
        } else {
            $taskDuration = $dateStart->diff($currentDate);
            $taskDurationValue = $taskDuration->format('%a days %h hours %i minutes');
        }
        if (!empty($easycase['Easycase']['due_date'])) {
            $dueDate = new DateTime($easycase['Easycase']['due_date']);
            //  $timeBalance = $dueDate->diff($currentDate);
            // $timeBalanceRemaining = $timeBalance->format('%a days');
            $timeBalanceRemaining = 0;
            $interval = $dueDate->diff($currentDate);
            if ($interval->invert == 1) {
                // if($dueDate > $currentDate){
                if ($interval->h == 0 && $interval->d != 0) {
                    $variation = $interval->format('%a days');
                } elseif ($interval->h != 0 && $interval->d == 0) {
                    $variation = $interval->format('%h hours');
                } elseif ($interval->h == 0 && $interval->d == 0) {
                    $variation = 0;
                } else {
                    $variation = $interval->format('%a days %h hours');
                }
                // $variation = $interval->format('%a days %h hours');
            } else {
                if ($interval->h == 0 && $interval->d != 0) {
                    $variation = $interval->format('-%a days');
                } elseif ($interval->h != 0 && $interval->d == 0) {
                    $variation = $interval->format('-%h hours');
                } elseif ($interval->h == 0 && $interval->d == 0) {
                    $variation = 0;
                } else {
                    $variation = $interval->format('-%a days %h hours');
                }
                // $variation = $interval->format('-%a days %h hours');
            }
        } else {
            //$dueDate = new DateTime($currentDate);
            $timeBalanceRemaining = 0;
            $variation = 0;
        }
       
        $CustomField = ClassRegistry::init('CustomField');
        $CustomFieldValue = ClassRegistry::init('CustomFieldValue');
        $CustomFieldData = array();
        $checkAdvFieldExist = $CustomFieldValue->find('all', array('conditions' => array('CustomFieldValue.company_id' => SES_COMP, 'CustomFieldValue.ref_id' => $taskId, 'CustomField.is_advanced' => '1')));

        if (empty($checkAdvFieldExist)) {
            $advCheckFields = $CustomField->find('all', array('conditions' => array('CustomField.company_id' => SES_COMP, 'CustomField.is_advanced' => '1')));

            foreach ($advCheckFields as $k => $v) {
                $arrl = array();
                if (($v['CustomField']['placeholder']) == 'taskCmplDate') {
                    $arrl['value'] = $taskCmplDate;
                } elseif (($v['CustomField']['placeholder']) == 'taskDuration') {
                    $arrl['value'] = $taskDurationValue;
                } elseif (($v['CustomField']['placeholder']) == 'variation') {
                    $arrl['value'] = $variation;
                } else {
                    $arrl['value'] = $timeBalanceRemaining;
                }

                $arrl['company_id'] = SES_COMP;
                $arrl['ref_id'] = $taskId;
                $arrl['ref_type'] = 2;
                $arrl['custom_field_id'] = $v['CustomField']['id'];
                $CustomFieldData[] = $arrl;
            }
            $saveData = $CustomFieldValue->saveAll($CustomFieldData);
        } else {
            foreach ($checkAdvFieldExist as $k => $v) {
                $arrl = array();
                if (($v['CustomField']['placeholder']) == 'taskCmplDate') {
                    $arrl['value'] = $taskCmplDate;
                } elseif (($v['CustomField']['placeholder']) == 'taskDuration') {
                    $arrl['value'] = $taskDurationValue;
                } elseif (($v['CustomField']['placeholder']) == 'variation') {
                    $arrl['value'] = $variation;
                } else {
                    $arrl['value'] = $timeBalanceRemaining;
                }
                $arrl['id'] = $v['CustomFieldValue']['id'];
                $CustomFieldData[] = $arrl;
            }
            $saveData = $CustomFieldValue->saveAll($CustomFieldData);
        }
        return $saveData;
    }
    /**
     * @method: public actionOntask($easycase_id, $caseuid,$type)
     * @author GDR <abc@mydomain.com>
     * @return JSON
     */
    public function actionOntask($caseid, $caseuid, $type, $is_from_gantt=null, $git_user_id=null)
    {
        if (!empty($caseid)) {
            $checkStatus = $this->find('first', array('conditions' => array('Easycase.id' => $caseid, 'Easycase.uniq_id' => $caseuid, 'Easycase.isactive' => 1)));
            if ($is_from_gantt) {
                if ($checkStatus['Easycase']['legend'] == 3) {
                    return true;
                }
            }
            if ($checkStatus) {
                if ($checkStatus['Easycase']['legend'] == 1) {
                    $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#763532" style="font:normal 12px verdana;">NEW</font>';
                } elseif ($checkStatus['Easycase']['legend'] == 4) {
                    $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
                } elseif ($checkStatus['Easycase']['legend'] == 5) {
                    $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
                } elseif ($checkStatus['Easycase']['legend'] == 3) {
                    $status = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
                }
                $assignTo = $checkStatus['Easycase']['assign_to'] ;
                //Action wrt type
                if ($type == 'start') {
                    $csSts = 1;
                    $csLeg = 4;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Start";
                    $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font>';
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">STARTED</font> the Task.';
                } elseif ($type == 'resolve') {
                    $csSts = 1;
                    $csLeg = 5;
                    $acType = 3;
                    $cuvtype = 5;
                    $emailType = "Resolve";
                    $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font>';
                    $emailbody = '<font color="#EF6807" style="font:normal 12px verdana;">RESOLVED</font> the Task.';
                } elseif ($type == 'close') {
                    $csSts = 2;
                    $csLeg = 3;
                    $acType = 1;
                    $cuvtype = 3;
                    $emailType = "Close";
                    $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="green" style="font:normal 12px verdana;">CLOSED</font>';
                    $emailbody = '<font color="green" style="font:normal 12px verdana;">CLOSED</font> the Task.';
                } elseif ($type == 'new') {
                    $csSts = 2;
                    $csLeg = 1;
                    $acType = 1;
                    $cuvtype = 3;
                    $emailType = "New";
                    $msg = '<font color="#737373" style="font-weight:bold">Status:</font> <font color="#F08E83" style="font:normal 12px verdana;">New</font>';
                    $emailbody = 'Changed the status of the task to <font color="#F08E83" style="font:normal 12px verdana;">New</font>.';
                } elseif ($type == 'tasktype') {
                    $csSts = 1;
                    $csLeg = 4;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Change Type";
                    $caseChageType1 = 1;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the type of</font> the Task.';
                } elseif ($type == 'duedate') {
                    $csSts = 1;
                    $csLeg = 4;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Change Duedate";
                    $caseChageDuedate1 = 3;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the due date of</font> the Task.';
                } elseif ($type == 'priority') {
                    $csSts = 1;
                    $csLeg = 4;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Change Priority";
                    $caseChagePriority1 = 2;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the priority of</font> the Task.';
                } elseif ($type == 'assignto') {
                    $csSts = 1;
                    $csLeg = 4;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Change Assignto";
                    $caseChangeAssignto1 = 4;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed the assigned to of</font> the Task.';
                } elseif ($type == 'esthour') {
                    $csSts = 1;
                    $csLeg = 1;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Change Estimated Hour(s)";
                    $caseChangeEstHour = 5;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed estimated hour(s) of</font> the Task.';
                } elseif ($type == 'story_point') {
                    $csSts = 1;
                    $csLeg = 1;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = __("Change Story Point");
                    $caseChangeStory = 5;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed story point of</font> the Task.';
                } elseif ($type == 'cmpltsk') {
                    $csSts = 1;
                    $csLeg = 4;
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Change Task Progress";
                    $caseChangeCmplTask = 6;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed progress of</font> the Task.';
                } elseif ($type == 'titleChange') {
                    $csSts = 1;
                    $csLeg = $checkStatus['Easycase']['legend'];
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Change Task Title";
                    $caseChangeTitleTask = 7;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">changed title of</font> the Task.';
                } elseif ($type == 'removeFile') {
                    $csSts = 1;
                    $csLeg = $checkStatus['Easycase']['legend'];
                    $acType = 2;
                    $cuvtype = 4;
                    $emailType = "Remove File";
                    $caseChangeFile = 8;
                    $msg = $status;
                    $emailbody = '<font color="#55A0C7" style="font:normal 12px verdana;">Removed a file from</font> the Task.';
                }
                $commonAllId = "";
                $caseid_list = $caseid . ',';
                $done = 1;
                $curCaseId = '';
                if ($caseChageType1 || $caseChageDuedate1 || $caseChagePriority1 || $caseChangeAssignto1 || $caseChangeEstHour || $caseChangeCmplTask || $caseChangeTitleTask || $caseChangeFile || $caseChangeStory) {
                    //socket.io implement start
                    $Project = ClassRegistry::init('Project');
                    $ProjectUser = ClassRegistry::init('ProjectUser');
                    $ProjectUser->recursive = -1;

                    //$getUser = $ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='".$closeStsPid."'");
                    $actionStsPid = $checkStatus['Easycase']['project_id'];
                    $caseStsNo = $checkStatus['Easycase']['case_no'];
                    $closeStsTitle = $checkStatus['Easycase']['title'];

                    $prjuniq = $Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $actionStsPid . "'");
                    $prjuniqid = $prjuniq[0]['projects']['uniq_id'];
                    $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                    $channel_name = $prjuniqid;

                    if ($channel_name) {
                        $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;
                        $pub_msg = array('channel' => $channel_name, 'message' => $msgpub);
                    }
                    //socket.io implement end
                } else {
                    $done = 1;
                    $caseDataArr = $checkStatus;
                    /* if (($caseDataArr['Easycases']['legend'] == 3) || ($csLeg == 4 && ($caseDataArr['Easycases']['legend'] == 4)) || ($csLeg == 5 && ($caseDataArr['Easycases']['legend'] == 5))) {
                      $done = 0;
                      } */
                    if ($done) {
                        $caseid_list = $caseid . ',';
                        $caseStsId = $caseDataArr['Easycase']['id'];
                        $caseStsNo = $caseDataArr['Easycase']['case_no'];
                        $closeStsPid = $caseDataArr['Easycase']['project_id'];
                        $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                        $closeStsPri = $caseDataArr['Easycase']['priority'];
                        $closeStsTitle = $caseDataArr['Easycase']['title'];
                        $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                        $caUid = $caseDataArr['Easycase']['assign_to'];
                        
                        if ($is_from_gantt) {
                            $upd_gnt_arr = array();
                            $upd_gnt_arr['Easycase']['id'] = $caseStsId;
                            $upd_gnt_arr['Easycase']['case_no'] = $caseStsNo;
                            $upd_gnt_arr['Easycase']['updated_by'] = SES_ID;
                            $upd_gnt_arr['Easycase']['case_count'] = $caseDataArr['Easycase']['case_count']+1;
                            $upd_gnt_arr['Easycase']['project_id'] = $closeStsPid;
                            $upd_gnt_arr['Easycase']['type_id'] = $closeStsTyp;
                            $upd_gnt_arr['Easycase']['priority'] = $closeStsPri;
                            $upd_gnt_arr['Easycase']['status'] = $csSts;
                            $upd_gnt_arr['Easycase']['legend'] = $csLeg;
                            $upd_gnt_arr['Easycase']['dt_created'] = GMT_DATETIME;
                            //$this->recursive = -1;
                            $this->save($upd_gnt_arr['Easycase']);
                        } else {
                            $this->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . (!empty($git_user_id) ? $git_user_id : SES_ID) . "',case_count=case_count+1, "
                                . "project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', "
                                . "status='" . $csSts . "', legend='" . $csLeg . "',dt_created='" . GMT_DATETIME . "' "
                                . "WHERE id=" . $caseStsId . " AND isactive='1'");
                        }
                        // remove from google calendar if setting.
                        if ($type == 'close') {
                            if (empty($git_user_id)) {
                                $GoogleCalendarSetting = ClassRegistry::init('GoogleCalendarSetting');
                                $Gdata = $GoogleCalendarSetting->find('first', array('conditions'=>array('user_id'=>SES_ID,'company_id'=>SES_COMP)));
                                if ($Gdata['GoogleCalendarSetting']['removeCmpl'] ==1) {
                                    App::import('Component', 'Format');
                                    $format = new FormatComponent(new ComponentCollection);
                                    $format->createGoogleCalendarEvent($caseStsId, $checkStatus['Easycase'], 'delete');
                                }
                            }
                        }
                        /* adding advanced CF values when a task marked as Close Or Completed */
                        if ($type == 'close') {
                            $saveAdvCustomFields = $this->advCustomFieldAction($caseStsId);
                            if ($saveAdvCustomFields) {
                                $arr['advancedCustomFieldSave'] = 'success';
                            } else {
                                $arr['advancedCustomFieldSave'] = 'error';
                            }
                        }
                        $caseuniqid = md5(uniqid(mt_rand() . microtime()));
                        $this->query("INSERT INTO easycases SET uniq_id='" . $caseuniqid . "', user_id='" . (!empty($git_user_id) ? $git_user_id : SES_ID) . "', format='2', istype='2', "
                                . "actual_dt_created='" . GMT_DATETIME . "', case_no='" . $caseStsNo . "', project_id='" . $closeStsPid . "', "
                                . "type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', status='" . $csSts . "', "
                                . "legend='" . $csLeg . "', dt_created='" . GMT_DATETIME . "'");
                        $curCaseIdArr = $this->query('SELECT last_insert_id() as curCaseId');
                        $curCaseId = $curCaseIdArr[0][0]['curCaseId'];
                        //socket.io implement start
                        $Project = ClassRegistry::init('Project');
                        $ProjectUser = ClassRegistry::init('ProjectUser');
                        $ProjectUser->recursive = -1;

                        //$getUser = $ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='".$closeStsPid."'");
                        $prjuniq = $Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $closeStsPid . "'");
                        $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
                        $projShName = strtoupper($prjuniq[0]['projects']['short_name']);
                        $channel_name = $prjuniqid;
                        $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;

                        $pub_msg = array('channel' => $channel_name, 'message' => $msgpub);
                        //socket.io implement end
                    }
                }
                $_SESSION['email']['email_body'] = $emailbody;
                $_SESSION['email']['msg'] = $msg;
                $email_notification = array('caseNo' => $caseStsNo, 'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg,
                    'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo,
                    'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid, 'csType' => $emailType, 'closeStsPid' => $closeStsPid,
                    'caseStsId' => $caseStsId, 'caseIstype' => 5, 'caseid_list' => $caseid_list, 'curCaseId' => $curCaseId, 'caseUniqId' => $closeStsUniqId);
                // $caseuniqid
                $arr['curCaseId'] = $curCaseId;
                $arr['succ'] = 1;
                $arr['msg'] = 'Success';
                $arr['data'] = $email_notification;
                $arr['pub_msg'] = $pub_msg;
                $arr['prev_legend'] = $checkStatus['Easycase']['legend'];
                $arr['project_id'] = $checkStatus['Easycase']['project_id'];
                return $arr;
            } else {
                $arr['err'] = 1;
                $arr['msg'] = __('No Task found with the selected id');
                return $arr;
            }
        }
    }
    public function actionOntaskCustom($caseid, $caseuid, $staus_id, $is_from_gantt=null, $git_user_id=null)
    {
        if (!empty($caseid)) {
            $this->bindModel(array('belongsTo'=>array('CustomStatus')));
            $checkStatus = $this->find('first', array('conditions' => array('Easycase.id' => $caseid, 'Easycase.uniq_id' => $caseuid, 'Easycase.isactive' => 1)));
            $clegend =!empty($checkStatus['CustomStatus'])?$checkStatus['CustomStatus']['status_master_id']:$checkStatus['Easycase']['legend'];
            if ($is_from_gantt) {
                if ($clegend == 3) {
                    return true;
                }
            }
            if ($checkStatus) {
                $status = '<font color="#'.$checkStatus['CustomStatus']['color'].'" style="font-weight:bold">Status:</font> <font color="#763532" style="font:normal 12px verdana;">'.$checkStatus['CustomStatus']['name'].'</font>';
                //Action wrt type
                $csSts = ($clegend == 3)? 2 : 1;
                $ctm_sts = $this->getDtlCustomStatus($staus_id);
                $csLeg = ($ctm_sts)?$ctm_sts['CustomStatus']['status_master_id']:2;
                if ($csLeg == 3) {
                    $saveAdvCustomFields = $this->advCustomFieldAction($caseid);
                }
                $emailType = $checkStatus['CustomStatus']['name'];
                $msg = '<font color="#'.$checkStatus['CustomStatus']['color'].'" style="font-weight:bold">Status:</font> <font color="#'.$checkStatus['CustomStatus']['color'].'" style="font:normal 12px verdana;">'.$checkStatus['CustomStatus']['name'].'</font>';
                $emailbody = '<font color="#'.$checkStatus['CustomStatus']['color'].'" style="font:normal 12px verdana;">'.$checkStatus['CustomStatus']['name'].'</font> the Task.';
                
                $commonAllId = "";
                $caseid_list = $caseid . ',';
                $curCaseId = '';
                
                $done = 1;
                $caseDataArr = $checkStatus;
                  
                if ($done) {
                    $caseid_list = $caseid . ',';
                    $caseStsId = $caseDataArr['Easycase']['id'];
                    $caseStsNo = $caseDataArr['Easycase']['case_no'];
                    $closeStsPid = $caseDataArr['Easycase']['project_id'];
                    $closeStsTyp = $caseDataArr['Easycase']['type_id'];
                    $closeStsPri = $caseDataArr['Easycase']['priority'];
                    $closeStsTitle = $caseDataArr['Easycase']['title'];
                    $closeStsUniqId = $caseDataArr['Easycase']['uniq_id'];
                    $caUid = $caseDataArr['Easycase']['assign_to'];
                        
                    /*
                        if($is_from_gantt){
                            $upd_gnt_arr = array();
                            $upd_gnt_arr['Easycase']['id'] = $caseStsId;
                            $upd_gnt_arr['Easycase']['case_no'] = $caseStsNo;
                            $upd_gnt_arr['Easycase']['updated_by'] = SES_ID;
                            $upd_gnt_arr['Easycase']['case_count'] = $caseDataArr['Easycase']['case_count']+1;
                            $upd_gnt_arr['Easycase']['project_id'] = $closeStsPid;
                            $upd_gnt_arr['Easycase']['type_id'] = $closeStsTyp;
                            $upd_gnt_arr['Easycase']['priority'] = $closeStsPri;
                            $upd_gnt_arr['Easycase']['status'] = $csSts;
                            $upd_gnt_arr['Easycase']['legend'] = $csLeg;
                            $upd_gnt_arr['Easycase']['custom_status_id'] = $type;
                            $upd_gnt_arr['Easycase']['dt_created'] = GMT_DATETIME;
                            //$this->recursive = -1;
                            $this->save($upd_gnt_arr['Easycase']);
                        }else{
                            $this->query("UPDATE easycases SET case_no='" . $caseStsNo . "',updated_by='" . SES_ID . "',case_count=case_count+1, "
                                . "project_id='" . $closeStsPid . "', type_id='" . $closeStsTyp . "', priority='" . $closeStsPri . "', "
                                . "status='" . $csSts . "', legend='" . $csLeg . "', custom_status_id='" . $type . "',dt_created='" . GMT_DATETIME . "' "
                                . "WHERE id=" . $caseStsId . " AND isactive='1'");
                    }*/
                    
                    $upd_gnt_arr = array();
                    $upd_gnt_arr['Easycase']['id'] = $caseStsId;
                    $upd_gnt_arr['Easycase']['case_no'] = $caseStsNo;
                    $upd_gnt_arr['Easycase']['updated_by'] = SES_ID;
                    $upd_gnt_arr['Easycase']['case_count'] = $caseDataArr['Easycase']['case_count']+1;
                    $upd_gnt_arr['Easycase']['project_id'] = $closeStsPid;
                    $upd_gnt_arr['Easycase']['type_id'] = $closeStsTyp;
                    $upd_gnt_arr['Easycase']['priority'] = $closeStsPri;
                    $upd_gnt_arr['Easycase']['status'] = $csSts;
                    $upd_gnt_arr['Easycase']['legend'] = $csLeg;
                    $upd_gnt_arr['Easycase']['custom_status_id'] = $staus_id;
                    $upd_gnt_arr['Easycase']['dt_created'] = GMT_DATETIME;
                    //$this->recursive = -1;
                    $this->save($upd_gnt_arr['Easycase']);
                    $caseuniqid = md5(uniqid(mt_rand() . microtime()));
                    $this->create();
                    $ins_gnt_arr = array();
                    $ins_gnt_arr['Easycase']['uniq_id'] = $caseuniqid;
                    $ins_gnt_arr['Easycase']['case_no'] = $caseStsNo;
                    $ins_gnt_arr['Easycase']['user_id'] = !empty($git_user_id) ? $git_user_id :SES_ID;
                    $ins_gnt_arr['Easycase']['format'] = 2;
                    $ins_gnt_arr['Easycase']['istype'] = 2;
                    $ins_gnt_arr['Easycase']['project_id'] = $closeStsPid;
                    $ins_gnt_arr['Easycase']['type_id'] = $closeStsTyp;
                    $ins_gnt_arr['Easycase']['priority'] = $closeStsPri;
                    $ins_gnt_arr['Easycase']['status'] = $csSts;
                    $ins_gnt_arr['Easycase']['legend'] = $csLeg;
                    $ins_gnt_arr['Easycase']['custom_status_id'] = $staus_id;
                    $ins_gnt_arr['Easycase']['dt_created'] = GMT_DATETIME;
                    $ins_gnt_arr['Easycase']['actual_dt_created'] = GMT_DATETIME;
                    $this->save($ins_gnt_arr['Easycase']);
                    $curCaseId = $this->getLastInsertID();
                    
                    //$curCaseIdArr = $this->query('SELECT last_insert_id() as curCaseId');
                    //$curCaseId = $curCaseIdArr[0][0]['curCaseId'];
                    //socket.io implement start
                    $Project = ClassRegistry::init('Project');
                    $prj_dtl = $Project->find('first', array('conditions' => array('Project.id' => $closeStsPid,'Project.company_id' => SES_COMP), 'fields' => array('Project.uniq_id', 'Project.short_name')));

                    $prjuniqid = $prj_dtl['Project']['uniq_id'];
                    $projShName = strtoupper($prj_dtl['Project']['short_name']);
                    $channel_name = $prjuniqid;
                    $msgpub = 'Updated.~~' . SES_ID . '~~' . $caseStsNo . '~~' . 'UPD' . '~~' . $closeStsTitle . '~~' . $projShName;

                    $pub_msg = array('channel' => $channel_name, 'message' => $msgpub);
                    //socket.io implement end
                }
                $_SESSION['email']['email_body'] = $emailbody;
                $_SESSION['email']['msg'] = $msg;
                $email_notification = array(
                    'caseNo' => $caseStsNo,
                    'closeStsTitle' => $closeStsTitle, 'emailMsg' => $emailMsg,
                    'closeStsPid' => $closeStsPid, 'closeStsPri' => $closeStsPri, 'closeStsTyp' => $closeStsTyp, 'assignTo' => $assignTo,
                    'usr_names' => $usr_names, 'caseuniqid' => $caseuniqid,
                    'csType' => $emailType, 'closeStsPid' => $closeStsPid,
                    'caseStsId' => $caseStsId, 'caseIstype' => 5,
                    'caseid_list' => $caseid_list, 'curCaseId' => $curCaseId, 'caseUniqId' => $closeStsUniqId);
                $arr['curCaseId'] = $curCaseId;
                $arr['succ'] = 1;
                $arr['msg'] = 'Success';
                $arr['data'] = $email_notification;
                $arr['pub_msg'] = $pub_msg;
                $arr['prev_legend'] = $clegend;
                $arr['git_user_id'] = $git_user_id;
                $arr['project_id'] = $closeStsPid;
                return $arr;
            } else {
                $arr['err'] = 1;
                $arr['msg'] = __('No Task found with the selected id');
                return $arr;
            }
        } else {
            $arr['err'] = 1;
            $arr['msg'] = __('No Task found with the selected id');
            return $arr;
        }
    }

    /**
     * @method: public ajax_milestonelist($data=array()) to retrive the latest 3 Milestone and respective tasks
     * @author GDR <abc@mydomain.com>
     * @return array()
     */
    public function ajax_milestonelist($data = array(), $frmt, $dt, $tz, $cq, $milestone_search = '', $froCompnt = null)
    {
        $milestone_search = "AND (Milestone.title LIKE '%$milestone_search%' OR Milestone.description LIKE '%$milestone_search%')";
        $caseStatus = $data['caseStatus']; // Filter by Status(legend)
        $caseCustomStatus = $data['caseCustomStatus']; // Filter by Custom Status
        $priorityFil = $data['priFil']; // Filter by Priority
        $caseTypes = $data['caseTypes']; // Filter by case Types
        $caseLabel = $data['caseLabel']; // Filter by case Label
        $caseUserId = $data['caseMember']; // Filter by Member
        $caseAssignTo = $data['caseAssignTo']; // Filter by AssignTo
        $caseDate = urldecode($data['caseDate']); // Sort by Date
        $caseSrch = $data['caseSearch']; // Search by keyword
        $casePage = $data['casePage']; // Pagination
        $caseUniqId = $data['caseId']; // Case Uniq ID to close a case
        $caseTitle = $data['caseTitle']; // Case Uniq ID to close a case
        $caseDueDate = $data['caseDueDate']; // Sort by Due Date
        $isActive = isset($data['isActive']) ? $data['isActive'] : 1; //to distinguish between active and completed
//               pr($isActive);exit;
        $caseNum = $data['caseNum']; // Sort by Due Date
        $caseLegendsort = $data['caseLegendsort']; // Sort by Case Status
        $caseAtsort = $data['caseAtsort']; // Sort by Case Status
        $startCaseId = $data['startCaseId']; // Start Case
        $caseComment = $data['caseComment']; // Filter by Member
        $caseResolve = $data['caseResolve']; // Resolve Case
        $caseNew = $data['caseNew']; // Resolve Case

        $caseMenuFilters = $data['caseMenuFilters']; // Resolve Case
        $milestoneIds = $data['milestoneIds']; // Resolve Case
        $caseCreateDate = $data['caseCreateDate']; // Sort by Created Date
        @$case_srch = $data['case_srch'];
        @$case_date = urldecode($data['case_date']);
        @$case_duedate = $data['case_due_date'];
        @$milestone_type = $data['mstype'];
        $changecasetype = $data['caseChangeType'];
        $caseChangeDuedate = $data['caseChangeDuedate'];
        $caseChangePriority = $data['caseChangePriority'];
        $caseChangeAssignto = $data['caseChangeAssignto'];
        $customfilterid = $data['customfilter'];
        $detailscount = $data['data']['detailscount'];
        
        App::import('Component', 'Format');
        //$this->Format = new FormatComponent();
        $this->Format = $froCompnt;
        ######### Filter by CaseUniqId ##########
        $qry =$ErestrictQuery= $restrictQuery= "";
        if (!$this->Format->isAllowed('View All Task', $roleAccess)) {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
            $restrictQuery.= " AND (Easycase.assign_to=" . SES_ID . " OR Easycase.user_id=".SES_ID.")";
            $ErestrictQuery= " AND (E.assign_to=" . SES_ID . " OR E.user_id=".SES_ID.")";
        }
        if (trim($caseUrl)) {
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
            if ($caseStatus != "all") {
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
            $qry.= $this->Format->customStatusFilter($caseCustomStatus, $projUniq,$caseStatus);
            $stsLegArr = $caseCustomStatus . "-" . "";
            $expStsLeg = explode("-", $stsLegArr);
        }*/
        ######### Filter by Case Types ##########
        if ($caseTypes && $caseTypes != "all") {
            $qry.= $this->Format->typeFilter($caseTypes);
        }
        ######### Filter by Priority ##########
        if ($priorityFil && $priorityFil != "all") {
            $qry.= $this->Format->priorityFilter($priorityFil, $caseTypes);
        }
        ######### Filter by Member ##########
        if ($caseUserId && $caseUserId != "all") {
            $qry.= $this->Format->memberFilter($caseUserId);
        }
        ######### Filter by AssignTo ##########
        if ($caseAssignTo && $caseAssignTo != "all" && $caseAssignTo != "unassigned") {
            $qry.= $this->Format->assigntoFilter($caseAssignTo);
        } elseif (trim($caseAssignTo) == "unassigned") {
            $qry.= " AND Easycase.assign_to='0'";
        }
        ######### Search by KeyWord ##########
        $searchcase = "";
        if (trim(urldecode($caseSrch)) && (trim($case_srch) == "")) {
            $searchcase = $this->Format->caseKeywordSearch($caseSrch, 'full');
        }
        if (trim(urldecode($case_srch)) != "") {
            $searchcase = "AND (Easycase.case_no = '$case_srch')";
        }

        if (trim(urldecode($caseSrch))) {
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
            App::import('Component', 'Tmzone');
            $Tmzone = new TmzoneComponent(new ComponentCollection);
            $frmTz = '+00:00';
            $toTz = $Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
            
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
            App::import('Component', 'Tmzone');
            $Tmzone = new TmzoneComponent(new ComponentCollection);
            $frmTz = '+00:00';
            $toTz = $Tmzone->getGmtTz(TZ_GMT, TZ_DST);
            $GMT_DATE =$Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
            if (trim($case_duedate) == '24') {
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 day"));
                $qry.= " AND (DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) ='" . $GMT_DATE . "')";
            } elseif (trim($case_duedate) == 'overdue') {
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " +1 week"));
                $qry .= " AND ( DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <'" . $GMT_DATE . "') AND (Easycase.legend =1 || Easycase.legend=2) ";
            } elseif (strstr(trim($case_duedate), ":")) {
                $ar_dt = explode(":", trim($case_duedate));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.due_date,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
            }
        }

        ######### Filter by Assign To ##########
        if ($caseMenuFilterskanban == "assigntome") {
            $qry.= " AND (Easycase.assign_to=" . SES_ID . ")";
        }
        ######### Filter by Delegate To ##########
        elseif ($caseMenuFilterskanban == "delegateto") {
            $qry.= " AND Easycase.assign_to!=0 AND Easycase.assign_to!=" . SES_ID . " AND Easycase.user_id=" . SES_ID;
        } elseif ($caseMenuFilterskanban == "closecase") {
            $qry.= " AND Easycase.legend='3' AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilterskanban == "overdue") {
            $cur_dt = date('Y-m-d H:i:s', strtotime(GMT_DATETIME));
            $qry.= " AND Easycase.due_date !='' AND Easycase.due_date != '0000-00-00 00:00:00' AND Easycase.due_date !='1970-01-01 00:00:00' AND Easycase.due_date < '" . $cur_dt . "' AND (Easycase.legend !=3) ";
        } elseif ($caseMenuFilterskanban == "highpriority") {
            $qry.= " AND Easycase.priority ='0' ";
        } elseif ($caseMenuFilterskanban == "newwip") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2')  AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilterskanban == "openedtasks") {
            $qry.= " AND (Easycase.legend='1' OR Easycase.legend='2' OR Easycase.legend='5' OR Easycase.legend='4')  AND Easycase.type_id !='10'";
        } elseif ($caseMenuFilterskanban == "closedtasks") {
            $qry.= " AND Easycase.legend='3' AND Easycase.type_id !='10'";
        }
        
        
        $msQuery = "";
        $msOrder = " ORDER BY c.id_seq ASC ";
        $orderby = " ORDER BY CASE WHEN Easycase.Em_milestone_id IS NULL THEN 99999999999999 ELSE Easycase.Em_m_order END  ASC, Easycase.Em_milestone_id ASC,Easycase.id DESC  "; //" ORDER BY Easycase.end_date ASC,Easycase.Mtitle ASC  ";
        $suborderby = " ORDER BY EasycaseMilestone.id_seq ASC ";
        $ispaginate = $data['ispaginate'];
        $mlimit = isset($data['mlimit']) ? $data['mlimit'] : 0;
        if ($ispaginate && $ispaginate == 'prev') {
            $mlimit -=(2 * MILESTONE_PER_PAGE);
        } elseif ($ispaginate == '' && $mlimit) {
            $mlimit -=MILESTONE_PER_PAGE;
        }
        $projUniq = $data['projFil'];
        $projIsChange = $data['projIsChange'];

        $clt_sql = 1;
        if (CakeSession::read("Auth.User.is_client") == 1) {
            $clt_sql = "((Easycase.client_status = " . CakeSession::read("Auth.User.is_client") . " AND Easycase.user_id = " . CakeSession::read("Auth.User.id") . ") OR Easycase.client_status != " . CakeSession::read("Auth.User.is_client") . ")";
        }

        if ($projUniq != 'all') {
            //$prj_cls = ClassRegistry::init('Project');
            $prj_usercls = ClassRegistry::init('ProjectUser');
            $prj_usercls->bindModel(array('belongsTo' => array('Project')));
            $projArr = $prj_usercls->find('first', array('conditions' => array('Project.uniq_id' => $projUniq, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'ProjectUser.company_id' => SES_COMP), 'fields' => array('Project.id', 'Project.short_name', 'ProjectUser.id')));
            //$projectDetails = $prj_cls->find('first',array('conditions'=>array('Project.uniq_id'=>$projUniq)));
            if ($projArr) {
                //Updating ProjectUser table to current date-time
                if ($projIsChange != $projUniq) {
                    $ProjectUser['id'] = $projArr['ProjectUser']['id'];
                    $ProjectUser['dt_visited'] = GMT_DATETIME;
                    $prj_usercls->save($ProjectUser);
                }
            }
            $curProjId = $projArr['Project']['id'];
        } elseif ($projUniq == 'all') {
        } else {
            $projUniq = $GLOBALS['getallproj'][0]['Project']['uniq_id'];
            $curProjId = $GLOBALS['getallproj'][0]['Project']['id'];
        }
        ######### Filter by Comments ##########
        if ($caseComment && $caseComment != "all") {
            $qry.= $this->Format->commentFilter($caseComment, $curProjId, $case_date);
        }
        ######### Filter by Case Label ##########
        if (trim($caseLabel) && $caseLabel != "all") {
            $qry.= $this->Format->labelFilter($caseLabel, $curProjId, SES_COMP, SES_TYPE, SES_ID);
        }
        ########Get all Milestone ###############
        $msOrder1 = " ORDER BY CASE WHEN TG.milestone_id IS NULL THEN 99999999999999 ELSE TG.m_order END  ASC, TG.milestone_id ASC  ";
        $all_miles_query =  "SELECT TG.* FROM (SELECT Milestone.id,Milestone.uniq_id,Milestone.title,Milestone.project_id,Milestone.estimated_hours,c.milestone_id,c.m_order,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(c.easycase_id) AS `caseids` FROM milestones AS Milestone LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id LEFT JOIN easycases as E On E.id = c.easycase_id  WHERE `Milestone`.`project_id` =" . $curProjId . " AND `Milestone`.`company_id` = " . SES_COMP .$ErestrictQuery. " GROUP BY Milestone.id ) AS TG $msOrder1 "; //AND ((E.istype=1 AND E.isactive= 1) OR E.id IS NULL)
        $allMilestones = $this->query($all_miles_query);
        
        
        $default_tasks_sql = "SELECT count(Easycase.id) as total FROM (SELECT Easycase.id,Easycase.assign_to FROM easycases as Easycase LEFT JOIN easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id LEFT JOIN milestones AS Milestone ON Milestone.id=EasycaseMilestone.milestone_id WHERE  Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql .$restrictQuery. " AND Easycase.isactive=1 AND Milestone.id IS NULL AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0 ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id";
        $default_task_count = $this->query($default_tasks_sql);
        
        $default_tasks_close_sql = "SELECT count(Easycase.id) as total FROM (SELECT Easycase.id,Easycase.assign_to FROM easycases as Easycase LEFT JOIN easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id LEFT JOIN milestones AS Milestone ON Milestone.id=EasycaseMilestone.milestone_id WHERE  Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql .$restrictQuery. " AND Easycase.isactive=1 AND Easycase.legend = 3 AND Milestone.id IS NULL AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0 ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id";
        $default_task_close_count = $this->query($default_tasks_close_sql);
        
        $all_tasks_sql = "SELECT count(Easycase.id) as total FROM (SELECT Easycase.id,Easycase.assign_to FROM easycases as Easycase LEFT JOIN easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id LEFT JOIN milestones AS Milestone ON Milestone.id=EasycaseMilestone.milestone_id WHERE  Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql .$restrictQuery . " AND Easycase.isactive=1 AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0 ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id";
        $all_task_count = $this->query($all_tasks_sql);
        
        $all_tasks_close_sql = "SELECT count(Easycase.id) as total FROM (SELECT Easycase.id,Easycase.assign_to FROM easycases as Easycase LEFT JOIN easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id LEFT JOIN milestones AS Milestone ON Milestone.id=EasycaseMilestone.milestone_id WHERE  Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql .$restrictQuery . " AND Easycase.isactive=1 AND Easycase.legend = 3 AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0 ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id";
        $all_task_close_count = $this->query($all_tasks_close_sql);
        
        
        $mstIds = Hash::extract($allMilestones, '{n}.TG.id');
        $closedtskmile = array();
        $tottskmile = array();
        if (count($mstIds) > 0) {
            $totmiles =  $this->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql .$restrictQuery. " AND EasycaseMilestone.milestone_id IN (" . implode(',', $mstIds) . ") GROUP BY  EasycaseMilestone.milestone_id");
            $closemiles =  $this->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql .$restrictQuery. " AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN (" . implode(',', $mstIds) . ") GROUP BY  EasycaseMilestone.milestone_id");
            foreach ($closemiles as $k=>$v) {
                $closedtskmile[$v['EasycaseMilestone']['milestone_id']] = $v[0]['totcase'];
            }
            foreach ($totmiles as $k=>$v) {
                $tottskmile[$v['EasycaseMilestone']['milestone_id']] = $v[0]['totcase'];
            }
        }
        /*** End ***/
        // 3 Milestone wrt Sequence
        $milestone_cls = ClassRegistry::init('Milestone');
        $usrCndn = ' AND project_id = Milestone.project_id';
        if (SES_TYPE == 3) {
            $usrCndn = " AND user_id = " . SES_ID . ' AND project_id = Milestone.project_id';
        }
        if ($projUniq != 'all' && trim($projUniq)) {
            $milestones = $milestone_cls->query("SELECT SQL_CALC_FOUND_ROWS `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`end_date`,`Milestone`.`estimated_hours`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(DISTINCT(c.easycase_id)) AS `caseids`, SUM(E.estimated_hours) AS est_hrs FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id LEFT JOIN easycases as E On E.id = c.easycase_id WHERE `Milestone`.`project_id` =" . $curProjId . " AND `Milestone`.`company_id` = " . SES_COMP . $ErestrictQuery." $milestone_search GROUP BY Milestone.id $msOrder"); //`Milestone`.`isactive` =" . $isActive . " AND
            if (!$milestones) {
                $milestones_all = $milestone_cls->query("SELECT SQL_CALC_FOUND_ROWS `Milestone`.`id`,`Milestone`.`isactive` FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id LEFT JOIN easycases as E On E.id = c.easycase_id WHERE `Milestone`.`project_id` =" . $curProjId . " AND `Milestone`.`company_id` = " . SES_COMP .$ErestrictQuery . " AND ((E.istype=1 AND E.isactive= 1) OR E.id IS NULL) GROUP BY Milestone.id $msOrder");
            }
            //$milestones = $milestone_cls->find('all',array('conditions'=>array('isactive' =>$isActive,'project_id' =>$curProjId,'company_id' => SES_COMP)));
            //pr($milestones);die;
        } elseif ($projUniq == 'all') {
            $milestones = $milestone_cls->query("SELECT SQL_CALC_FOUND_ROWS `Milestone`.`id`,`Milestone`.`title`,`Milestone`.`project_id`,`Milestone`.`end_date`,`Milestone`.`estimated_hours`,`Milestone`.`uniq_id`,`Milestone`.`isactive`,`Milestone`.`user_id`,COUNT(c.easycase_id) AS totalcases,GROUP_CONCAT(DISTINCT(c.easycase_id)) AS `caseids`, SUM(E.estimated_hours) AS est_hrs FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id LEFT JOIN projects Project on Project.id=Milestone.project_id LEFT JOIN easycases as E On E.id = c.easycase_id WHERE c.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') AND Project.isactive=$isActive AND Milestone.isactive=$isActive AND `Milestone`.`company_id` = " . SES_COMP .$ErestrictQuery. "  $milestone_search GROUP BY Milestone.id $msOrder "); //`Milestone`.`isactive` =" . $isActive . " AND
            if (!$milestones) {
                $milestones_all = $milestone_cls->query("SELECT SQL_CALC_FOUND_ROWS `Milestone`.`id`,`Milestone`.`isactive` FROM milestones AS `Milestone` LEFT JOIN easycase_milestones AS c ON Milestone.id = c.milestone_id LEFT JOIN easycases as E On E.id = c.easycase_id WHERE `Milestone`.`company_id` = " . SES_COMP .$ErestrictQuery. " AND ((E.istype=1 AND E.isactive= 1) OR E.id IS NULL) GROUP BY Milestone.id $msOrder");
            }
        }
        $totmlst = $milestone_cls->query("SELECT FOUND_ROWS() AS mtotal");
        $resCaseProj['totalMlstCnt'] = $totmlst[0][0]['mtotal'];
        $resCaseProj['mlimit'] = $mlimit + MILESTONE_PER_PAGE;
        // Check the No of task in the projects
        $Easy_cls = ClassRegistry::init('Easycase');
        $clt_sql = 1;
        $authClient = AuthComponent::user('is_client');
        $authId = AuthComponent::user('id');
        if ($authClient == 1) {
            $clt_sql = "((Easycase.client_status = " . $authClient . " AND Easycase.user_id = " . $authId . ") OR Easycase.client_status != " . $authClient . ")";
        }
        if ($projUniq != 'all' && trim($projUniq)) {
            $tot_easy = $Easy_cls->query("SELECT count(Easycase.id) as cnt FROM easycases AS Easycase LEFT JOIN  easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id= Easycase.id WHERE Easycase.project_id=$curProjId AND Easycase.istype=1 AND Easycase.isactive= 1 AND EasycaseMilestone.id IS NULL AND $clt_sql $restrictQuery ");
        } else {
            $tot_easy = $Easy_cls->query("SELECT count(Easycase.id) as cnt FROM easycases AS Easycase LEFT JOIN  easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id= Easycase.id WHERE Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') AND Easycase.istype=1 AND Easycase.isactive= 1 AND EasycaseMilestone.id IS NULL AND $clt_sql $restrictQuery");
        }
        //$milestones = $milestone_cls->find('all',array('conditions'=>array('Milestone.project_id'=>$curProjId),'order'=>array('id_seq ASC, end_date DESC'),'limit'=>'3'));
        if ($milestones || ($tot_easy[0][0]['cnt'] > 0 && $isActive == 1)) { //$milestones
            if ($milestones) {
                $milestone_ids = '';
                foreach ($milestones as $keys => $values) {
                    $milestone_ids .="'" . $values['Milestone']['id'] . "', ";
                }
                $milestone_ids = trim($milestone_ids, ', ');
            } else {
                $milestone_ids = '0';
            }
            $mstype = isset($data['msType']) ? $data['msType'] : 1;
            //$qry ="";
            $usrCndn1 = ' AND project_id = Easycase.project_id ';
            if (SES_TYPE == 3) {
                $usrCndn1 = " AND user_id = " . SES_ID . " AND project_id = Easycase.project_id ";
            }
            if ($projUniq) {
                if ($projUniq != 'all') {
                    $caseAllDefault = $this->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to = 0 OR Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT sum(total_hours) as secds FROM log_times WHERE task_id = Easycase.id $usrCndn1) AS spent_hrs FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.custom_status_id,Easycase.story_point,Easycase.thread_count,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq AS Em_id_seq,EasycaseMilestone.m_order AS Em_m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase LEFT JOIN easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id LEFT JOIN milestones AS Milestone ON Milestone.id=EasycaseMilestone.milestone_id WHERE  Easycase.istype='1' AND " . $clt_sql.$restrictQuery . " AND Easycase.isactive=1 AND Milestone.id IS NULL AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  $qry" . $msQuery . $suborderby . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id $orderby");
                    //echo  "SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to = 0 OR Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned ,(SELECT sum(total_hours) as secds FROM log_times WHERE task_id = Easycase.id $usrCndn1) AS spent_hrs FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.custom_status_id,Easycase.story_point,Easycase.thread_count,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq AS Em_id_seq,EasycaseMilestone.m_order AS Em_m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase LEFT JOIN easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id LEFT JOIN milestones AS Milestone ON Milestone.id=EasycaseMilestone.milestone_id WHERE  Easycase.istype='1' AND " . $clt_sql . " AND Easycase.isactive=1 AND Milestone.id IS NULL AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  $qry" . $msQuery . $suborderby . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id $orderby";exit;
                    $caseAll = $this->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to = 0 OR Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned,(SELECT sum(total_hours) as secds FROM log_times WHERE task_id = Easycase.id $usrCndn1) AS spent_hrs FROM ( SELECT Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.custom_status_id,Easycase.story_point,Easycase.thread_count,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq AS Em_id_seq,EasycaseMilestone.m_order AS Em_m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase,easycase_milestones AS EasycaseMilestone,milestones AS Milestone WHERE EasycaseMilestone.easycase_id=Easycase.id $milestone_search AND Milestone.id=EasycaseMilestone.milestone_id AND Easycase.istype='1' AND " . $clt_sql.$restrictQuery . " AND Easycase.isactive=1 AND Milestone.id IN(" . $milestone_ids . ") AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0  AND EasycaseMilestone.easycase_id=Easycase.id $qry AND  EasycaseMilestone.project_id=" . $curProjId . $msQuery . $suborderby." ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id $orderby"); //AND Milestone.isactive=" . $isActive . "
                    $closed_cases_default = $this->query("SELECT COUNT(Easycase.id) as totcase FROM easycases as Easycase LEFT JOIN  easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IS NULL AND Easycase.project_id='$curProjId' AND Easycase.project_id!=0 $qry");
                }
                if ($projUniq == 'all') {
                    $caseAllDefault = $this->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to = 0 OR Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned,(SELECT sum(total_hours) as secds FROM log_times WHERE task_id = Easycase.id $usrCndn1) AS spent_hrs  FROM ( SELECT  Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.custom_status_id,Easycase.story_point,Easycase.thread_count,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq AS Em_id_seq,EasycaseMilestone.m_order AS Em_m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase LEFT JOIN easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id LEFT JOIN milestones AS Milestone ON Milestone.id=EasycaseMilestone.milestone_id WHERE Easycase.istype='1' AND Easycase.isactive=1 AND " . $clt_sql.$restrictQuery . " AND Milestone.id IS NULL AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . " " . $msQuery . $suborderby . " ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id $orderby");
                    $caseAll = $this->query("SELECT SQL_CALC_FOUND_ROWS Easycase.*,User.short_name,IF((Easycase.assign_to = 0 OR Easycase.assign_to =" . SES_ID . "),'Me',User.short_name) AS Assigned,(SELECT sum(total_hours) as secds FROM log_times WHERE task_id = Easycase.id $usrCndn1) AS spent_hrs  FROM ( SELECT  Easycase.id,Easycase.uniq_id,Easycase.case_no,Easycase.case_count,Easycase.project_id,Easycase.user_id,Easycase.updated_by,Easycase.type_id,Easycase.priority,Easycase.title,Easycase.estimated_hours,Easycase.hours,Easycase.completed_task,Easycase.assign_to,Easycase.gantt_start_date,Easycase.due_date,Easycase.istype,Easycase.client_status,Easycase.format,Easycase.status,Easycase.legend,Easycase.is_recurring,Easycase.isactive,Easycase.dt_created,Easycase.actual_dt_created,Easycase.reply_type,Easycase.is_chrome_extension,Easycase.from_email,Easycase.depends,Easycase.children,Easycase.temp_est_hours,Easycase.seq_id,Easycase.parent_task_id,Easycase.custom_status_id,Easycase.story_point,Easycase.thread_count,EasycaseMilestone.id AS Emid, EasycaseMilestone.milestone_id AS Em_milestone_id,EasycaseMilestone.user_id AS Em_user_id,EasycaseMilestone.id_seq AS Em_id_seq,EasycaseMilestone.m_order AS Em_m_order,Milestone.id as Mid,Milestone.title AS Mtitle ,Milestone.end_date,Milestone.isactive AS Misactive,Milestone.project_id AS Mproject_id,Milestone.uniq_id AS Muinq_id FROM easycases as Easycase,easycase_milestones AS EasycaseMilestone,milestones AS Milestone WHERE EasycaseMilestone.easycase_id=Easycase.id $milestone_search AND Milestone.id=EasycaseMilestone.milestone_id AND Easycase.istype='1' AND Easycase.isactive=1 AND " . $clt_sql.$restrictQuery . " AND Milestone.id IN(" . $milestone_ids . ") AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') " . $searchcase . " " . trim($qry) . " AND EasycaseMilestone.easycase_id=Easycase.id AND EasycaseMilestone.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1')" . $msQuery . $suborderby." ) AS Easycase LEFT JOIN users User ON Easycase.assign_to=User.id $orderby"); //AND Milestone.isactive=" . $isActive . "
                    $closed_cases_default = $this->query("SELECT COUNT(Easycase.id) as totcase FROM easycases as Easycase LEFT JOIN  easycase_milestones AS EasycaseMilestone ON EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IS NULL AND Easycase.project_id!=0 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP ."' ".$ErestrictQuery. ") $qry");
                }
                $tot = $this->query("SELECT FOUND_ROWS() as total");
                $CaseCount = $tot[0][0]['total'];
                $msQ = "";
                $ecmil_model = ClassRegistry::init('EasycaseMilestone');
                if ($projUniq != 'all') {
                    foreach ($milestones as $mls) {
                        $ml_edids = $ecmil_model->fetchAllEcIds($mls['Milestone']['id'], $mls['Milestone']['project_id']);
                        $mls[0]['caseids'] = null;
                        if ($ml_edids) {
                            $mls[0]['caseids'] = implode(',', $ml_edids);
                        }
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
                        $m[$mls['Milestone']['id']]['est_hrs'] = $mls[0]['est_hrs'];
                        $m[$mls['Milestone']['id']]['m_est_hrs'] = $mls['Milestone']['estimated_hours'];
                        if ($mls[0]['caseids']) {
                            $usrCndn = ' AND project_id =' . $mls['Milestone']['project_id'];
                            if (SES_TYPE == 3) {
                                $usrCndn = " AND user_id = " . $mls['Milestone']['user_id'] . " AND project_id = " . $mls['Milestone']['project_id'];
                            }
                            $spnthr = $this->query("SELECT sum(total_hours) as secds FROM log_times WHERE task_id IN (" . $mls[0]['caseids'] . ") $usrCndn");
                            $m[$mls['Milestone']['id']]['spent_hrs'] = $spnthr[0][0]['secds'];
                        } else {
                            $m[$mls['Milestone']['id']]['spent_hrs'] = 0;
                        }
                    }
                    $c = array();
                    if ($mid) {
                        $closed_cases = $this->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql .$restrictQuery. " AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN(" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
                        foreach ($closed_cases as $key => $val) {
                            $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                        }
                    }
                    $resCaseProj['milestones'] = $m;
                }
                if ($projUniq == 'all') {
                    $cond = array('conditions' => array('ProjectUser.user_id' => SES_ID, 'ProjectUser.company_id' => SES_COMP, 'Project.isactive' => 1), 'fields' => array('DISTINCT  Project.id'), 'order' => array('ProjectUser.dt_visited DESC'));
                    $mid = '';
                    foreach ($milestones as $k => $v) {
                        $ml_edids = $ecmil_model->fetchAllEcIds($v['Milestone']['id'], $v['Milestone']['project_id']);
                        $v[0]['caseids'] = null;
                        if ($ml_edids) {
                            $v[0]['caseids'] = implode(',', $ml_edids);
                        }
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
                        //$m[$mls['Milestone']['id']]['est_hrs'] = $mls[0]['est_hrs'];
                        $m[$mls['Milestone']['id']]['est_hrs'] = $v[0]['est_hrs'];
                        $m[$mls['Milestone']['id']]['m_est_hrs'] = $v['Milestone']['estimated_hours'];
                        if ($mls[0]['caseids']) {
                            $usrCndn = ' AND project_id =' . $mls['Milestone']['project_id'];
                            if (SES_TYPE == 3) {
                                $usrCndn = " AND user_id = " . $mls['Milestone']['user_id'] . " AND project_id = " . $mls['Milestone']['project_id'];
                            }
                            $spnthr = $this->query("SELECT sum(total_hours) as secds FROM log_times WHERE task_id IN (" . $mls[0]['caseids'] . ") $usrCndn");
                            $m[$mls['Milestone']['id']]['spent_hrs'] = $spnthr[0][0]['secds'];
                        } else {
                            $m[$mls['Milestone']['id']]['spent_hrs'] = 0;
                        }
                    }
                    $c = array();
                    if ($mid) {
                        $closed_cases = $this->query("SELECT EasycaseMilestone.milestone_id,COUNT(Easycase.id) as totcase FROM easycase_milestones AS EasycaseMilestone LEFT JOIN easycases as Easycase ON   EasycaseMilestone.easycase_id=Easycase.id WHERE Easycase.istype='1' AND Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.legend='3' AND EasycaseMilestone.milestone_id IN (" . trim($mid, ',') . ") GROUP BY  EasycaseMilestone.milestone_id");
                        foreach ($closed_cases as $key => $val) {
                            $c[$val['EasycaseMilestone']['milestone_id']]['totalclosed'] = $val[0]['totcase'];
                        }
                    }
                    $resCaseProj['milestones'] = $m;
                }
                $ProjectUser = ClassRegistry::init('ProjectUser');
                if ($projUniq != 'all') {
                    $usrDtlsAll = $ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id='" . $curProjId . "' AND Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.istype IN('1','2') ORDER BY User.short_name");
                    $allCSByProj = $this->Format->getStatusByProject($curProjId);
                } else {
                    $usrDtlsAll = $ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name,User.photo FROM users as User,easycases as Easycase WHERE (Easycase.user_id=User.id || Easycase.updated_by=User.id || Easycase.assign_to=User.id) AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') AND Easycase.isactive='1' AND " . $clt_sql . " AND Easycase.istype IN('1','2') ORDER BY User.short_name");
                    $allCSByProj = $this->Format->getStatusByProject('all');
                }
                $usrDtlsArr = array();
                $usrDtlsPrj = array();
                foreach ($usrDtlsAll as $ud) {
                    $usrDtlsArr[$ud['User']['id']] = $ud;
                }
                $customStatusByProject = array();
                if (isset($allCSByProj)) {
                    foreach ($allCSByProj as $k=>$v) {
                        $customStatusByProject[$v['Project']['id']] = $v['StatusGroup']['CustomStatus'];
                    }
                }
                $resCaseProj['customStatusByProject'] = $customStatusByProject;
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
                $resCaseProj['caseMenuFilters'] = $caseMenuFilters;
                // pr($caseAll);
                $frmtCaseAll = $this->formatCases($caseAll, $CaseCount, 'milestone', $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, null, array(), 1);
                $frmtCaseAllDefault = $this->formatCases($caseAllDefault, count($caseAllDefault), 'milestone', $c, $m, $projUniq, $usrDtlsArr, $frmt, $dt, $tz, $cq, null, array(), 1);
                $resCaseProj['caseAll'] = $frmtCaseAll['caseAll'];
                $resCaseProj['milestones'] = $frmtCaseAll['milestones'];
                $defaultCase = Hash::extract($frmtCaseAllDefault['caseAll'], '{n}.Easycase.id');
                //$resCaseProj['milestones'][0] = array('id' => 0,'caseids' => implode(',',$defaultCase),'totalcases' =>count($frmtCaseAllDefault['caseAll']),'title' => 'Default Task Group','project_id' =>0,'end_date' => '0000-00-00','uinq_id' => 0,'isactive' => 1,'user_id' => 0);
                if ($isActive ==1) {
                    $resCaseProj['caseAllDefault'] = $frmtCaseAllDefault['caseAll'];
                    $resCaseProj['caseAllDefault_est'] = 0;
                    $resCaseProj['caseAllDefault_spent'] = 0;
                    foreach ($frmtCaseAllDefault['caseAll'] as $k => $v) {
                        $resCaseProj['caseAllDefault_est'] += intval($v['Easycase']['estimated_hours']);
                        $resCaseProj['caseAllDefault_spent'] += intval($v['Easycase']['spent_hrs']);
                    }
                } else {
                    $resCaseProj['caseAllDefault'] = array();
                }
                foreach ($closed_cases_default as $key => $val) {
                    $resCaseProj['totalclosed'] =  $val[0]['totcase'];
                }
                //$pgShLbl = $frmt->pagingShowRecords($CaseCount,$page_limit,$casePage);
                //$resCaseProj['pgShLbl'] = $pgShLbl;

                $curCreated = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                $friday = date('Y-m-d', strtotime($curCreated . "next Friday"));
                $monday = date('Y-m-d', strtotime($curCreated . "next Monday"));
                $tomorrow = date('Y-m-d', strtotime($curCreated . "+1 day"));

                $resCaseProj['intCurCreated'] = strtotime($curCreated);
                $resCaseProj['mdyCurCrtd'] = date('m/d/Y', strtotime($curCreated));
                $resCaseProj['mdyFriday'] = date('m/d/Y', strtotime($friday));
                $resCaseProj['mdyMonday'] = date('m/d/Y', strtotime($monday));
                $resCaseProj['mdyTomorrow'] = date('m/d/Y', strtotime($tomorrow));

                $resCaseProj['all_task_group'] = $allMilestones;
                $resCaseProj['all_closed'] = $closedtskmile;
                $resCaseProj['all_tot'] = $tottskmile;
                $resCaseProj['all_default'] = ($default_task_count[0][0]['total'])?$default_task_count[0][0]['total']:0;
                $resCaseProj['all_default_closed'] = ($default_task_close_count[0][0]['total'])?$default_task_close_count[0][0]['total']:0;
                $resCaseProj['all_task_cnt'] = ($all_task_count[0][0]['total'])?$all_task_count[0][0]['total']:0;
                $resCaseProj['all_task_cnt_closed'] = ($all_task_close_count[0][0]['total'])?$all_task_close_count[0][0]['total']:0;
                if ($projUniq != 'all') {
                    $projUser = array();
                    if ($projUniq) {
                        $projUser = array($projUniq => $this->getMemebers($projUniq));
                    }
                    $resCaseProj['projUser'] = $projUser;
                }

//                pr($resCaseProj);exit;
                $resCaseProj['error'] = 0;
                return $resCaseProj;
            }
        } else {
            $total_exist = 0;
            $total_active = 0;
            $total_inactive = 0;
            if ($milestones_all) {
                $total_exist = count($milestones_all);
                foreach ($milestones_all as $k => $v) {
                    if ($v['Milestone']['isactive']) {
                        $total_active++;
                    } else {
                        $total_inactive++;
                    }
                }
            }
            $arr['all_task_group'] = array();
            $arr['total_exist'] = $total_exist;
            $arr['total_active'] = $total_active;
            $arr['total_inactive'] = $total_inactive;
            $arr['mile_type'] = $isActive;
            $arr['error'] = "No task group";
            return $arr;
        }
    }

    public function usedSpace($curProjId = null, $company_id = SES_COMP, $typeChk=0)
    {
        App::import('Model', 'CaseFile');
        $CaseFile = new CaseFile();
        $CaseFile->recursive = -1;
        $cond = " 1 ";
        if ($company_id) {
            $cond .=" AND company_id=" . $company_id;
        }
        if ($curProjId) {
            $cond .=" AND project_id=" . $curProjId;
        }
        $sql = "SELECT SUM(file_size) AS file_size  FROM case_files   WHERE " . $cond;
        $res1 = $CaseFile->query($sql);
        $filesize = $res1['0']['0']['file_size'] / 1024;
        App::import('Model', 'CaseEditorFile');
        $CaseEditorFile = new CaseEditorFile();
        $CaseEditorFile->recursive = -1;
        $sql_n = "SELECT SUM(file_size) AS file_size FROM case_editor_files WHERE " . $cond;
        $res_n = $CaseEditorFile->query($sql_n);
        $filesize_n = $res_n['0']['0']['file_size'] / 1024;
            
        $tot_size = $filesize_n+$filesize;
        //return number_format($filesize, 2);
        if ($typeChk) {
            return round($tot_size, 2);
        } else {
            return number_format($tot_size, 2);
        }
    }

    public function getDateAgo($date = null, $typ)
    {
        if ($date) {
            $date = date('Y-m-d', strtotime($date));
            $today = date('Y-m-d');
            $date1 = date_create($date);
            $date2 = date_create($today);
            $diff = date_diff($date1, $date2);
            $no_of_days = $diff->format("%a");
            $ret_str = '';
            if ($typ == 'day') {
                if ($no_of_days == 0) {
                    $ret_str = 'Today';
                } else {
                    $ret_str = $no_of_days . ' Day(s)';
                }
            } else {
                if ($no_of_days == 0) {
                    $ret_str = 'Today';
                } elseif ($no_of_days >= 365) {
                    $m_y = $no_of_days / 365;
                    $m_y_r = $no_of_days % 365;
                    $ret_str = $m_y . ' Year(s) ';
                    if ($m_y_r > 1) {
                        if ($m_y_r >= 30) {
                            $m_y_r_d = $m_y_r / 30;
                            $m_y_r_d_r = $m_y_r % 30;
                            $ret_str .= $m_y_r_d . ' Month(s) ';
                            if ($m_y_r_d_r != 0) {
                                $ret_str .= $m_y_r_d_r . ' Day(s)';
                            }
                        } else {
                            $ret_str .= $m_y_r . ' Day(s)';
                        }
                    }
                } elseif ($no_of_days >= 30) {
                    $m_d = $no_of_days / 30;
                    $m_d_r = $no_of_days % 30;
                    $ret_str = $m_d . ' Month(s) ';
                    if ($m_d_r != 0) {
                        $ret_str .= $m_d_r . ' Day(s)';
                    }
                } else {
                    $ret_str .= $no_of_days . ' Day(s)';
                }
            }
            return $ret_str;
        } else {
            return '';
        }
    }

    /*
     * Author Satyajeet
     * This method is used to get the task title and description of a specific task
     */

    public function getDetailsofTask($case_id)
    {
        $case_det = $this->find('first', array('conditions' => array('Easycase.id' => $case_id), 'fields' => array('Easycase.title', 'Easycase.message','Easycase.type_id','Easycase.priority','Easycase.story_point','Easycase.assign_to','Easycase.estimated_hours','Easycase.parent_task_id')));
        return $case_det;
    }
    public function getTaskMilestone($case_id, $project_id)
    {
        App::import('Model', 'Milestone');
        $Milestone = new Milestone();
        $case_mile = $this->query('SELECT id,uniq_id,title FROM milestones WHERE id=(SELECT milestone_id FROM easycase_milestones WHERE easycase_id=' . $case_id . ' AND project_id=' . $project_id . '  LIMIT 1) LIMIT 1');
        if ($case_mile) {
            return $case_mile[0]['milestones'];
        } else {
            return 0;
        }
    }
    public function getAllMilestones($projId)
    {
        $milestone = ClassRegistry::init('Milestone');
        $allMilestones = $milestone->find('all', array('conditions' => array('Milestone.project_id' => $projId, 'Milestone.isactive' => 1), 'fields' => array('Milestone.id', 'Milestone.title')));
        return $allMilestones;
    }
    public function getEasycaseFields($condition, $fields = array())
    {
        $this->recursive = -1;
        return $this->find('first', array('conditions' => $condition, 'fields' => $fields));
    }
    /* fetch all parent tasks
     * @param: parent_task_id and project_id
     * @return: all children
     */

    public function getSubTasks($parent_task_id, $curCaseId = '0')
    {
        $all_parent_id = array($parent_task_id);
        if (!is_array($parent_task_id)) {
            $parent_task_id = array($curCaseId => $parent_task_id);
        }
        $fields = array('Easycase.id', 'Easycase.title', 'Easycase.case_no', 'Easycase.uniq_id', 'Easycase.parent_task_id', 'Easycase.legend','Easycase.project_id','Easycase.client_status','Easycase.user_id','Easycase.custom_status_id');
        //first level parents
        
        $condi_fst = array('Easycase.id' => $parent_task_id, 'Easycase.istype' => '1');
        /*if (CakeSession::read("Auth.User.is_client") == 1) {
            $condi_fst = array('Easycase.id' => $parent_task_id, 'Easycase.istype' => '1','OR'=>array(array('Easycase.client_status'=>1,'Easycase.user_id' =>SES_ID),'Easycase.client_status !='=>1));
        }*/
        $result = $this->find('all', array('conditions' => $condi_fst, 'fields' => $fields));
        $all_tasks = Hash::combine($result, '{n}.Easycase.id', '{n}.Easycase');
        $tasks = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s', '{n}.Easycase.title', '{n}.Easycase.case_no'));
        //$tasks = Hash::combine($result, '{n}.Easycase.id', array('#%1$d', '{n}.Easycase.case_no'));
        $curr_parent_id = array_filter(Hash::combine($result, '{n}.Easycase.id', '{n}.Easycase.parent_task_id'));
        $new_parent_ids = array_diff($curr_parent_id, $parent_task_id);
        $all_parent_id = array_replace($parent_task_id, $new_parent_ids);
        $client_chek_array = array();
        //second level parents
        if (!empty($new_parent_ids)) {
            $condi_fst = array('Easycase.id' => $new_parent_ids, 'Easycase.istype' => '1');
            /*if (CakeSession::read("Auth.User.is_client") == 1) {
                $condi_fst = array('Easycase.id' => $new_parent_ids, 'Easycase.istype' => '1','OR'=>array(array('Easycase.client_status'=>1,'Easycase.user_id' =>SES_ID),'Easycase.client_status !='=>1));
            }*/
            $result = $this->find('all', array('conditions' => $condi_fst, 'fields' => $fields));
            $result_list = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s', '{n}.Easycase.title', '{n}.Easycase.case_no'));
            //$result_list = Hash::combine($result, '{n}.Easycase.id', array('#%1$d', '{n}.Easycase.case_no'));
            $tasks = array_replace($tasks, $result_list);
            $curr_parent_id = array_filter(Hash::combine($result, '{n}.Easycase.id', '{n}.Easycase.parent_task_id'));
            $new_parent_ids = array_diff($curr_parent_id, $parent_task_id);
            $all_tasks = (Hash::combine($result, '{n}.Easycase.id', '{n}.Easycase') + $all_tasks);
            #pr($new_parent_ids);exit;
            $all_parent_id = array_replace($all_parent_id, $new_parent_ids);
            if (!empty($new_parent_ids)) {
                $condi_fst = array('Easycase.id' => $new_parent_ids, 'Easycase.istype' => '1');
                /*if (CakeSession::read("Auth.User.is_client") == 1) {
                    $condi_fst = array('Easycase.id' => $new_parent_ids, 'Easycase.istype' => '1','OR'=>array(array('Easycase.client_status'=>1,'Easycase.user_id' =>SES_ID),'Easycase.client_status !='=>1));
                }*/
                $result = $this->find('all', array('conditions' => $condi_fst, 'fields' => $fields));
                $result_list = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s', '{n}.Easycase.title', '{n}.Easycase.case_no'));
                //$result_list = Hash::combine($result, '{n}.Easycase.id', array('#%1$d','{n}.Easycase.case_no'));
                $tasks = array_replace($tasks, $result_list);
                $all_tasks = (Hash::combine($result, '{n}.Easycase.id', '{n}.Easycase') + $all_tasks);
            }
        }
        #$all_parent_id = array_replace($parent_task_id, $new_parent_ids);
        #pr($tasks);pr($all_parent_id);exit;
        #pr($all_tasks);exit;
        
        if (CakeSession::read("Auth.User.is_client")) {
            $client_chek_array = Hash::combine($all_tasks, '{n}.id', '{n}.client_status');
        }
        if ($tasks) {
            foreach ($tasks as $k => $v) {
                $tasks[$k] = htmlspecialchars(html_entity_decode($v, ENT_QUOTES, 'UTF-8'));
            }
        }
        if ($all_tasks) {
            foreach ($all_tasks as $ka => $va) {
                $all_tasks[$ka]['title'] = htmlspecialchars(html_entity_decode($va['title'], ENT_QUOTES, 'UTF-8'));
            }
        }
        $related_tasks = array('task' => $tasks,'parent_counts' => count($tasks), 'parent' => $all_parent_id, 'data' => $all_tasks, 'client_status' => array('is_client' => CakeSession::read("Auth.User.is_client"), 'chekstatus' => $client_chek_array));
        return $related_tasks;
    }

    /* Fetch all children tasks
     * @param: parent_task_id and project_id
     * @return: all children
     */

    public function getSubTaskChild($parent_task_id, $project_id)
    {
        $parent_child_id = array();
        $curr_child_id = array();
        $new_child_ids = array();
        $this->bindModel(array('belongsTo'=>array('CustomStatus')));
        $fields = array('Easycase.id', 'Easycase.uniq_id', 'Easycase.title', 'Easycase.case_no', 'Easycase.project_id', 'Easycase.parent_task_id','Easycase.legend','Easycase.type_id','Easycase.priority', 'Easycase.assign_to','Easycase.custom_status_id');
        //first level child
        $result = $this->find('all', array(
            'conditions' => array('Easycase.project_id' => $project_id,'Easycase.isactive' => '1','Easycase.istype' => '1','Easycase.parent_task_id' => $parent_task_id),
            'fields' => $fields,'recursive'=>2
        ));
        if (!empty($result) && is_array($result)) {
            $tasks = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s', '{n}.Easycase.title', '{n}.Easycase.case_no'));
            $curr_child_id = (Hash::extract($result, '{n}.Easycase.id'));
            foreach ($result as $case) {
                $parent_child_id[$case['Easycase']['parent_task_id']][] = $case['Easycase']['id'];
            }
            $data_arr = $result;

            //second level child
            $result = $this->find('all', array(
                'conditions' => array('Easycase.project_id' => $project_id,'Easycase.isactive' => '1','Easycase.istype' => '1','Easycase.parent_task_id' => $curr_child_id),
                'fields' => $fields
            ));
            if (!empty($result) && is_array($result)) {
                $result_list = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s', '{n}.Easycase.title', '{n}.Easycase.case_no'));
                $new_child_ids = array_filter(Hash::extract($result, '{n}.Easycase.id'));
                foreach ($result as $case) {
                    $parent_child_id[$case['Easycase']['parent_task_id']][] = $case['Easycase']['id'];
                }

                $tasks = array_merge($tasks, $result_list);
                $data_arr = array_merge($data_arr, $result);
            }
        }

        $all_child_id = array_merge($curr_child_id, $new_child_ids);
        if (!empty($data_arr) && is_array($data_arr)) {
            $data_arr = Hash::combine($data_arr, "{n}.Easycase.id", "{n}");
        }
        #pr($tasks);pr($all_child_id);pr($parent_child_id);return;
        return empty($parent_child_id) ? array() : array('task' => $tasks, 'child' => $all_child_id, 'data' => $data_arr, 'parent_child_id' => $parent_child_id);
    }
    /* check the task is a parent or not
     * @param: parent_task_id
     * @return: 1 or 0
     */

    public function getParentTask($_task_id)
    {
        $fields = array('Easycase.id', 'Easycase.isactive','Easycase.parent_task_id');
        $result = $this->find('first', array('conditions' => array('Easycase.id' => $_task_id, 'Easycase.istype' => '1', 'Easycase.isactive' => '1'), 'fields' => $fields));
        return $result;
    }
    /* check the task is a parent count
     * @param: parent_task_id
     * @return: 1 or 0
     */
    public function checkParentTaskCnt($parent_task_id)
    {
        $fields = array('Easycase.id', 'Easycase.isactive','Easycase.legend');
        $result = $this->find('first', array('conditions' => array('Easycase.parent_task_id' => $parent_task_id, 'Easycase.istype' => '1', 'Easycase.isactive' => '1'), 'fields' => $fields));
        return ($result)?1:'';
    }
    /* check the task is a parent count for custom task status
     * @param: parent_task_id
     * @return: 1 or 0
     */
    public function checkParentTaskCntCustom($parent_task_id)
    {
        $fields = array('Easycase.id', 'Easycase.isactive','Easycase.project_id','Easycase.legend','Easycase.custom_status_id');
        $result = $this->find('first', array('conditions' => array('Easycase.parent_task_id' => $parent_task_id, 'Easycase.istype' => '1', 'Easycase.isactive' => '1'), 'fields' => $fields));
        $proj_id = 0;
        if ($result) {
            $proj_id = $result['Easycase']['project_id'];
        } else {
            $result = $this->find('first', array('conditions' => array('Easycase.id' => $parent_task_id, 'Easycase.istype' => '1', 'Easycase.isactive' => '1'), 'fields' => $fields));
            if ($result) {
                $proj_id = $result['Easycase']['project_id'];
            }
        }
        if ($proj_id) {
            $Project = ClassRegistry::init('Project');
            $proj_res = $Project->getProjectFields(array("Project.id" => $proj_id), array("Project.status_group_id"));
            if ($proj_res) {
                return $this->getHighestCustomSts($proj_res['Project']['status_group_id']);
            }
        }
        return '';
    }
    /* check the task is a parent count for custom task status
     * @param: parent_task_id
     * @return: 1 or 0
     */
    public function getHighestCustomSts($status_group_id)
    {
        $Csts = ClassRegistry::init('CustomStatus');
        $csts_arr = $Csts->find('first', array('conditions'=>array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.status_group_id'=>$status_group_id),'order'=>array('CustomStatus.seq'=>'DESC')));
        return $csts_arr;
    }
    /* check the status master of custom task status
     * @param: custom_status_id
     * @return: 1 or 0
     */
    public function getDtlCustomStatus($status_id)
    {
        $Csts = ClassRegistry::init('CustomStatus');
        $csts_arr = $Csts->find('first', array('conditions'=>array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.id'=>$status_id),'order'=>array('CustomStatus.id'=>'DESC')));
        return $csts_arr;
    }
    /* check the task is a parent or not
     * @param: parent_task_id
     * @return: 1 or 0
     */

    public function checkParentTask($parent_task_id)
    {
        $fields = array('Easycase.id', 'Easycase.isactive','Easycase.legend');
        $result = $this->find('first', array('conditions' => array('Easycase.parent_task_id' => $parent_task_id, 'Easycase.istype' => '1', 'Easycase.isactive' => '1', 'Easycase.legend !=' => '3'), 'fields' => $fields));
        return ($result)?1:'';
    }
    public function checkParentInProject($task_id, $proj_id)
    {
        $fields = array('Easycase.id', 'Easycase.isactive','Easycase.legend');
        $result = $this->find('first', array('conditions' => array('Easycase.id' =>$task_id, 'Easycase.project_id' => $proj_id), 'fields' => $fields));
        return ($result)?1:0;
    }
    public function delete_task($task_id = array(), $case_no = array(), $project_id = '', $oauth_arg = array())
    {
        #pr($task_id);pr($case_no); echo $project_id;exit;

        $this->query("DELETE FROM easycases WHERE case_no IN (" . implode(',', $case_no) . ") AND project_id = $project_id ");

        #$CaseActivity = ClassRegistry::init('CaseActivity');
        #$CaseActivity->recursive = -1;
        #$CaseActivity->query("DELETE FROM case_activities WHERE project_id=" . $project_id . " AND case_no=" . $case_no);
        $this->query("DELETE FROM case_activities WHERE project_id=" . $project_id . " AND case_no IN (" . implode(',', $case_no) . ")");

        #$CaseRecent = ClassRegistry::init('CaseRecent');
        #$CaseRecent->recursive = -1;
        #$CaseRecent->query("DELETE FROM case_recents WHERE easycase_id IN (" . implode(',', $task_id) . ") AND project_id= $project_id");
        $this->query("DELETE FROM case_recents WHERE easycase_id IN (" . implode(',', $task_id) . ") AND project_id= $project_id");

        #$CaseUserView = ClassRegistry::init('CaseUserView');
        #$CaseUserView->recursive = -1;
        #$CaseUserView->query("DELETE FROM case_user_views WHERE easycase_id IN (" . implode(',', $task_id) . ") AND project_id= $project_id");
        $this->query("DELETE FROM case_user_views WHERE easycase_id IN (" . implode(',', $task_id) . ") AND project_id= $project_id");

        #$easycs_mlst_cls = ClassRegistry::init('EasycaseMilestone');
        #$easycs_mlst_cls->recursive = -1;
        #$easycs_mlst_cls->query("DELETE FROM easycase_milestones WHERE easycase_id=" . $id . " AND project_id=" . $project_id);
        $this->query("DELETE FROM easycase_milestones WHERE easycase_id=" . $id . " AND project_id=" . $project_id);

        #by GKM to delete time log while delete task
        #$ltime = ClassRegistry::init('LogTime');
        #$ltime->recursive = -1;
        #$ltime->query("DELETE FROM log_times WHERE task_id=" . $id . " AND project_id=" . $project_id);
        $this->query("DELETE FROM log_times WHERE task_id=" . $id . " AND project_id=" . $project_id);

        #$casefiles = ClassRegistry::init('CaseFile');
        #$casefiles->recursive = -1;
        #$cfiles = $casefiles->query("SELECT * FROM case_files WHERE easycase_id IN (" . implode(',', $task_id) . ")");
        $cfiles = $this->query("SELECT * FROM case_files WHERE easycase_id IN (" . implode(',', $task_id) . ")");
        if ($cfiles) {
            $caseRemovedFile = ClassRegistry::init('CaseRemovedFile');
            foreach ($cfiles as $k => $v) {
                #@unlink(DIR_FILES . "case_files/" . $v['case_files']['file']);
                $cfile = !empty($v['case_files']['upload_name']) ? $v['case_files']['upload_name'] : $v['case_files']['file'];
                $cthumb = !empty($v['case_files']['thumb']) ? $v['case_files']['thumb'] : 'thumb_' . $cfile;
                @unlink(DIR_FILES . "case_files" . DS . $cfile);
                @unlink(DIR_FILES . "case_files" . DS . $cthumb);
                $datacaseR = null;
                $datacaseR['CaseRemovedFile']['case_file_id'] = $v['case_files']['id'];
                $datacaseR['CaseRemovedFile']['project_id'] = $v['case_files']['project_id'];
                $datacaseR['CaseRemovedFile']['user_id'] = (isset($oauth_arg['u_id']) && $oauth_arg['u_id']) ? $oauth_arg['u_id'] : SES_ID;
                $datacaseR['CaseRemovedFile']['company_id'] = $v['case_files']['company_id'];
                $datacaseR['CaseRemovedFile']['case_file_name'] = !empty($v['case_files']['upload_name']) ? $v['case_files']['upload_name'] : $v['case_files']['file'];
                $caseRemovedFile->saveAll($datacaseR);
            }
        }
        $this->query("DELETE FROM case_files WHERE easycase_id IN (" . implode(',', $task_id) . ")");
        //By Sunil
        //Delete records from case file drive table.
        $CaseFileDrive = ClassRegistry::init('CaseFileDrive');
        $deleteGoogle = $CaseFileDrive->deleteRows(array('CaseFileDrive.easycase_id' => $task_id));
        return true;
    }
    public function deleteTasksRecursively($task_id, $project_id = '', $oauth_arg = array(), $type=1)
    {
        if (!empty($project_id)) {
            $EasycaseItems = $this->find('all', array('conditions' => array('Easycase.id' => $task_id, 'Easycase.project_id' => $project_id, 'Easycase.istype' => 1, 'Easycase.isactive' => $type), 'recursive' => -1));
        } else {
            $EasycaseItems = $this->find('all', array('conditions' => array('Easycase.id' => $task_id, 'Easycase.istype' => 1, 'Easycase.isactive' => $type), 'recursive' => -1));
        }
        App::import('Component', 'Format');
        $format = new FormatComponent(new ComponentCollection);
        #pr($EasycaseItems);exit;
        if (is_array($EasycaseItems) && count($EasycaseItems) > 0) {
            foreach ($EasycaseItems as $key => $case) {
                $easycase_id = $case['Easycase']['id'];
                $case_no = $case['Easycase']['case_no'];
                $project_id = $case['Easycase']['project_id'];

                //fetch all tasks based on case no of task to delete all replies
                $case_list = $this->query('SELECT id,case_no,project_id FROM easycases WHERE case_no=' . $case_no . " AND project_id = " . $project_id);

                $this->query("DELETE FROM easycases WHERE case_no='" . $case_no . "' AND project_id='" . $project_id . "'");
                $this->query("DELETE FROM case_activities WHERE case_no='" . $case_no . "' AND project_id=" . $project_id);
                $this->query("DELETE FROM easycase_milestones WHERE easycase_id=" . $easycase_id . " AND project_id=" . $project_id);
                #$this->query("DELETE FROM easycase_links WHERE (source=" . $easycase_id . " OR target=" . $easycase_id . ") AND project_id=" . $project_id);
                $this->query("DELETE FROM log_times WHERE task_id='" . $easycase_id . "' AND project_id='" . $project_id . "'");
                if ($format->isResourceAvailabilityOn()) {
                    $format->delete_booked_hours(array('easycase_id' => $easycase_id, 'project_id' => $project_id), 1);
                }
                //Easycase linking tbl
                $EasycaseLinking_cls = ClassRegistry::init('EasycaseLinking');
                $EasycaseLinking_cls->recursive = -1;
                $EasycaseLinking_cls->deleteAll(array('easycase_id'=>$easycase_id,'project_id' => $project_id));
                
                $CaseEditorFile = ClassRegistry::init('CaseEditorFile');
                $CaseEditorFile->recursive = -1;
                $CaseEditorFile->updateAll(array('CaseEditorFile.is_deleted' => 1), array('CaseEditorFile.easycase_id' => $easycase_id,'CaseEditorFile.project_id' => $project_id));
                //Easycase Favourite tbl
                $EasycaseFavourite_cls = ClassRegistry::init('EasycaseFavourite');
                $EasycaseFavourite_cls->recursive = -1;
                $EasycaseFavourite_cls->deleteAll(array('easycase_id'=>$easycase_id,'project_id' => $project_id));
                //Easycase label tbl
                $EasycaseLabel_cls = ClassRegistry::init('EasycaseLabel');
                $EasycaseLabel_cls->recursive = -1;
                $EasycaseLabel_cls->deleteAll(array('EasycaseLabel.easycase_id'=>$easycase_id,'EasycaseLabel.project_id' => $project_id));
                
                //Easycase due reason tbl
                if (is_array($case_list) && count($case_list) > 0) {
                    $task_id_arr = Hash::extract($case_list, "{n}.easycases.id");

                    $this->query("DELETE FROM case_recents WHERE easycase_id IN (" . implode(',', $task_id_arr) . ") AND project_id= $project_id");
                    $this->query("DELETE FROM case_user_views WHERE easycase_id IN (" . implode(',', $task_id_arr) . ") AND project_id= $project_id");
                    $this->query("DELETE FROM recurring_easycases WHERE easycase_id IN (" . implode(',', $task_id_arr) . ") ");

                    $cfiles = $this->query("SELECT * FROM case_files WHERE easycase_id IN (" . implode(',', $task_id_arr) . ")");
                    if (!empty($cfiles)) {
                        $caseRemovedFile = ClassRegistry::init('CaseRemovedFile');
                        foreach ($cfiles as $k => $v) {
                            #@unlink(DIR_FILES . "case_files/" . $v['case_files']['file']);
                            $cfile = !empty($v['case_files']['upload_name']) ? $v['case_files']['upload_name'] : $v['case_files']['file'];
                            $cthumb = !empty($v['case_files']['thumb']) ? $v['case_files']['thumb'] : 'thumb_' . $cfile;
                            @unlink(DIR_FILES . "case_files" . DS . $cfile);
                            @unlink(DIR_FILES . "case_files" . DS . $cthumb);

                            $datacaseR = null;
                            $datacaseR['CaseRemovedFile']['case_file_id'] = $v['case_files']['id'];
                            $datacaseR['CaseRemovedFile']['project_id'] = $v['case_files']['project_id'];
                            $datacaseR['CaseRemovedFile']['user_id'] = (isset($oauth_arg['u_id']) && $oauth_arg['u_id']) ? $oauth_arg['u_id'] : SES_ID;
                            $datacaseR['CaseRemovedFile']['company_id'] = $v['case_files']['company_id'];
                            $datacaseR['CaseRemovedFile']['case_file_name'] = !empty($v['case_files']['upload_name']) ? $v['case_files']['upload_name'] : $v['case_files']['file'];
                            $caseRemovedFile->saveAll($datacaseR);
                        }
                        $this->query("DELETE FROM case_files WHERE easycase_id IN (" . implode(',', $task_id_arr) . ")");
                    }
                    //By Orangescrum
                    //Delete records from case file drive table.
                    $CaseFileDrive = ClassRegistry::init('CaseFileDrive');
                    $deleteGoogle = $CaseFileDrive->deleteRows(array('CaseFileDrive.easycase_id' => $task_id_arr));
                }

                #fetch all children of current task list and recursively delete them
                $this->recursive = -1;
                $childTasks = $this->find('list', array('conditions' => array('Easycase.project_id' => $project_id, 'Easycase.isactive' => $type,'Easycase.parent_task_id' => $easycase_id),'fields'=>array('Easycase.id')));
                //update the rest of child
                if ($childTasks) {
                    //$ids = implode(',',$childTasks);
                    //$this->query("UPDATE `easycases` SET `parent_task_id`='' WHERE `easycases`.`id` IN (" . $ids . ") AND project_id='" . $project_id."'");
                    $this->query("UPDATE `easycases` SET `parent_task_id`='' WHERE project_id= '". $project_id."' AND `easycases`.`parent_task_id`='" . $easycase_id . "'");
                }
                if (is_array($childTasks) && count($childTasks) > 0) {
                    $this->deleteTasksRecursively(array_values($childTasks), $project_id, $oauth_arg);
                }
            }
        }
        return true;
    }
    public function checkFourthParent($task_id, $p_eid)
    {
        //checking archives too
        $cnt = $this->find('count', array('conditions'=>array('Easycase.parent_task_id'=>$task_id,'Easycase.istype'=>1)));
        if ($cnt) {
            $cnt_res = $this->find('first', array('conditions'=>array('Easycase.id'=>$p_eid,'Easycase.istype'=>1),'fields'=>array('Easycase.parent_task_id')));
            if (!empty($cnt_res['Easycase']['parent_task_id'])) {
                return 0;
            }
        }
        return 1;
    }
    public function getSetParentId($task_id, $p_eid)
    {
        //if closed return
        if (!CakeSession::read("Auth.User.is_client")) {
            return $p_eid;
        } else {
            if ($p_eid != '') {
                $ret_frth = $this->checkFourthParent($task_id, $p_eid);
                if (!$ret_frth) {
                    return '';
                }
            } else {
                $fields = array('Easycase.id', 'Easycase.title', 'Easycase.case_no', 'Easycase.legend', 'Easycase.parent_task_id','Easycase.client_status');
                $condition = array('Easycase.id' => $eid);
                $result = $this->find('first', array(
                    'conditions' => $condition,
                    'fields' => $fields
                ));
                if (!empty($result['Easycase']['parent_task_id'])) {
                    $condition = array('Easycase.id' => $result['Easycase']['parent_task_id']);
                    $resultp = $this->find('first', array(
                        'conditions' => $condition,
                        'fields' => $fields
                    ));
                    if ($resultp && $resultp['Easycase']['client_status']) {
                        return $result['Easycase']['parent_task_id'];
                    }
                }
            }
            return $p_eid;
        }
    }
    public function getEditTaskParent($eid, $pid)
    {
        //if closed return
        $fields = array('Easycase.id', 'Easycase.title', 'Easycase.case_no', 'Easycase.legend', 'Easycase.parent_task_id');
        $condition = array('Easycase.id' => $eid, 'Easycase.project_id' => $pid);
        $result = $this->find('first', array(
            'conditions' => $condition,
            'fields' => $fields
        ));
        if (!empty($result['Easycase']['parent_task_id'])) {
            $condition = array('Easycase.id' => $result['Easycase']['parent_task_id']);
            $resultp = $this->find('first', array(
                'conditions' => $condition,
                'fields' => $fields
            ));
            if ($resultp && $resultp['Easycase']['client_status']) {
                return array();
            } else {
                if ($resultp && ($resultp['Easycase']['legend'] == 3 || $resultp['Easycase']['isactive'] == 0)) {
                    return $resultp;
                }
            }
        }
        return array();
    }
    public function parentTaskOptions($project_id, $easycase_id = '', $check=0, $search='')
    {
        $parent_child_id = array();
        $curr_child_id = array();
        $new_child_ids = array();
        $edit_reslt = array();
        //Added virtual field for threaded view
        $this->Behaviors->enable('Tree');
        $this->virtualFields['parent_id'] = 'Easycase.parent_task_id';
        if (!empty($easycase_id)) {
            if (!$this->checkTopParent($easycase_id, $project_id)) {
                return array();
            }
            $edit_reslt = $this->getEditTaskParent($easycase_id, $project_id);
        }
        if (!empty($search)) {
            $search = urldecode($search);
            if (stristr($search, '#')) {
                $search = str_replace('#', '', $search);
            }
        }
        $fields = array('Easycase.id', 'Easycase.title', 'Easycase.case_no', 'Easycase.legend', 'Easycase.parent_task_id','parent_id');
            
        $condition = array('Easycase.project_id' => $project_id, 'Easycase.istype' => '1','Easycase.isactive' => '1','Easycase.legend !=' => '3');
        if ($check) { // for gantt
            $condition = array('Easycase.project_id' => $project_id, 'Easycase.istype' => '1','Easycase.isactive' => '1');
        }
        if ($search != '') {
            $condition['Easycase.case_no'] = $search;
        }
        if (!empty($easycase_id)) {
            $condition['id !='] = $easycase_id;
        }
        if (CakeSession::read("Auth.User.is_client")) {
            $condition['client_status !='] = 1;
        }
        $resCases = $this->find('threaded', array('conditions'=>$condition,'fields'=>$fields,'order'=>array('Easycase.id'=>'desc')));
        $opts = array();
        foreach ($resCases as $k => $v) {
            if (empty($v['Easycase']['parent_id'])) {
                $opts[$v['Easycase']['id']] = '#' . $v['Easycase']['case_no'] . ': ' . $v['Easycase']['title'];
                if (!empty($v['children'])) {
                    foreach ($v['children'] as $k_in => $v_in) {
                        $opts[$v_in['Easycase']['id']] = '#' . $v_in['Easycase']['case_no'] . ': ' . $v_in['Easycase']['title'];
                    }
                }
            }
        }
        if (!empty($edit_reslt)) {
            if (!array_key_exists($edit_reslt['Easycase']['id'], $opts)) {
                $opts[$edit_reslt['Easycase']['id']] = '#' . $edit_reslt['Easycase']['case_no'] . ': ' . $edit_reslt['Easycase']['title'];
            }
        }
        //first level parent
        /*$condition = array('OR' => array('Easycase.parent_task_id IS NULL', 'Easycase.parent_task_id=\'\''),
        'Easycase.istype' => '1','Easycase.isactive' => '1','Easycase.legend !=' => '3', 'Easycase.project_id' => $project_id);
        if($check){ // for gantt
        $condition = array('OR' => array('Easycase.parent_task_id IS NULL', 'Easycase.parent_task_id=\'\''),
        'Easycase.istype' => '1','Easycase.isactive' => '1', 'Easycase.project_id' => $project_id);
        }
        if($search != ''){
        $condition['Easycase.case_no'] = $search;
        }
        if(!empty($easycase_id)){
        $condition['id !='] = $easycase_id;
        }
        if(CakeSession::read("Auth.User.is_client")){
        $condition['client_status !='] = 1;
        }
        $result = $this->find('all', array(
        'conditions' => $condition,
        'fields' => $fields,'order'=>array('Easycase.id'=>'desc')
        ));
        if (!empty($edit_reslt)){
        array_push($result,$edit_reslt);
        }
        if (!empty($result) && is_array($result)) {
        $tasks = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s', '{n}.Easycase.title', '{n}.Easycase.case_no'));
        $curr_child_id = (Hash::extract($result, '{n}.Easycase.id'));
        foreach ($result as $case) {
            $parent_child_id[$case['Easycase']['parent_task_id']][] = $case['Easycase']['id'];
        }
        $data_arr = $result;
        if(count($result) < 10 || 1){
        //second level parents
        $condition = array('Easycase.parent_task_id' => $curr_child_id,'Easycase.isactive' => '1','Easycase.istype' => '1','Easycase.legend !=' => '3');
        if($check){
            $condition = array('Easycase.parent_task_id' => $curr_child_id,'Easycase.isactive' => '1','Easycase.istype' => '1');
        }
            if($search != ''){
                $condition['Easycase.case_no'] = $search;
            }
        if(!empty($easycase_id)){
            $condition['id !='] = $easycase_id;
        }
        if(CakeSession::read("Auth.User.is_client")){
            $condition['client_status !='] = 1;
        }
        $result = $this->find('all', array(
            'conditions' => $condition,
                'fields' => $fields,'order'=>array('Easycase.id'=>'desc')
        ));
            if (1 || !empty($result) && is_array($result) && count($result) < 10) {
            //$result_list = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s__|__%3$d', '{n}.Easycase.title', '{n}.Easycase.case_no', '{n}.Easycase.legend'));
            $result_list = Hash::combine($result, '{n}.Easycase.id', array('#%2$d: %1$s', '{n}.Easycase.title', '{n}.Easycase.case_no'));
            $new_child_ids = array_filter(Hash::extract($result, '{n}.Easycase.id'));
            foreach ($result as $case) {
                $parent_child_id[$case['Easycase']['parent_task_id']][] = $case['Easycase']['id'];
            }

            $tasks = array_merge($tasks, $result_list);
            $data_arr = array_merge($data_arr, $result);
        }
        }
        }
        $all_child_id = array_merge($curr_child_id, $new_child_ids);
        #pr($tasks);pr($all_child_id);pr($parent_child_id);return;
        $opts = $this->parentDropDown($data_arr, 0, 0, array(), $check);
        */
        if ($check) {
            App::import('Model', 'Milestone');
            $Milestone = new Milestone();
            $milestones = $Milestone->find('list', array('conditions'=>array('Milestone.project_id'=>$project_id),'fields'=>array('Milestone.id','Milestone.title'),'order'=>'Milestone.end_date DESC'));
            //,'Milestone.isactive'=>1
            if ($milestones) {
                foreach ($milestones as $mk => $mv) {
                    $opts['m'.$mk] = $mv;
                }
            }
        }
        return $opts;
        #return empty($parent_child_id) ? array() : array('task' => $tasks, 'child' => $all_child_id, 'data' => $data_arr, 'parent_child_id' => $parent_child_id, 'opts' => $opts);
    }
    public function parentDropDown($data, $parentId = 0, $level = 0, $options = array(), $check=0)
    {
        $level++;
        if (!empty($data)) {
            foreach ($data as $val) {
                if ($val['Easycase']['parent_task_id'] == $parentId) {
                    if ($check) {
                        $options[$val['Easycase']['id']] = str_repeat("-sub- ", $level - 1) . '#' . $val['Easycase']['case_no'] . ': ' . $val['Easycase']['title'].'__|__'.$val['Easycase']['legend'];
                    } else {
                        $options[$val['Easycase']['id']] = str_repeat("-sub- ", $level - 1) . '#' . $val['Easycase']['case_no'] . ': ' . $val['Easycase']['title'];
                    }
                    $newParent = $val['Easycase']['id'];
                    $options = $this->parentDropDown($data, $newParent, $level, $options, $check);
                } elseif ($check) {
                    $options[$val['Easycase']['id']] = '#' . $val['Easycase']['case_no'] . ': ' . $val['Easycase']['title'].'__|__'.$val['Easycase']['legend'];
                }
            }
        }
        return $options;
    }
    public function checkTopParent($eid, $proj_id, $chk=null)
    {
        $fields = array('Easycase.id');
        //first level parent
        $condition = array('Easycase.parent_task_id' => $eid,'Easycase.istype' => '1','Easycase.project_id' => $proj_id);
        $result = $this->find('list', array(
            'conditions' => $condition,
            'fields' => $fields
        ));
        if (empty($result)) {
            return 1;
        } else {
            if ($chk) {
                return 0;
            }
            return $this->checkTopParent(array_values($result), $proj_id, 1);
        }
    }
    public function calculateEstimate($ids)
    {
        $res = $this->query('SELECT SUM(Easycase.estimated_hours) AS esthours FROM easycases AS Easycase WHERE Easycase.id IN('.$ids.')');
        if ($res) {
            return $res[0][0]['esthours'];
        }
        return 0;
    }
    public function insertCommentThreadCommon($easycase_data, $field, $field_val, $custom_stst_temp = 0, $is_dummy = 0, $git_setting = array())
    {
        App::import('Component', 'Format');
        $format = new FormatComponent(new ComponentCollection);
        $message = '';
        if (!empty($easycase_data['Easycase']['reason_id'])) {
            $DuedateChangeReason = ClassRegistry::init('DuedateChangeReason');
            $reasondata = $DuedateChangeReason->find('first', array('conditions' => array('DuedateChangeReason.id' => $easycase_data['Easycase']['reason_id']), 'fields' => array('DuedateChangeReason.reason')));
            $message = $reasondata['DuedateChangeReason']['reason'];
        }
        $easy_new_thrd = array();
        $easy_new_thrd['title'] = '';
        if ($field == 'story_point') {
            $reply_type = 15;
            if (!empty($easycase_data['Easycase']['story_point'])) {
                $reply_type = 16;
            }
            $easy_new_thrd['story_point'] = $field_val;
        } elseif ($field == 'legend') {
            $reply_type = 0;
        } elseif ($field == 'completed_task') {
            $easy_new_thrd['completed_task'] = $field_val;
            $reply_type = 6;
        } elseif ($field == 'estimated_hours') {
            $reply_type = 5;
        } elseif ($field == 'type_id') {
            $reply_type = 1;
        } elseif ($field == 'assign_to') {
            $reply_type = 2;
        } elseif ($field == 'due_date') {
            $easy_new_thrd['gantt_start_date'] = $easycase_data['Easycase']['gantt_start_date'];
            $easy_new_thrd['due_date'] = $easycase_data['Easycase']['due_date'];
            $reply_type = 3;
        } elseif ($field == 'timelog') {
            $reply_type = $field_val; //10/11
        } elseif ($field == 'title') {
            $reply_type = 7;
            $easy_new_thrd['title'] = $field_val;
        } elseif ($field == 'priority') {
            $reply_type = 4;
        }
        //13(a) and 14(r)  for favorite case
        $this->create();
        $caseuniqid = $format->generateUniqNumber();
        $easy_new_thrd['uniq_id'] = $caseuniqid;
        $easy_new_thrd['title'] = ($field == 'title') ? $easy_new_thrd['title'] : '';
        $easy_new_thrd['message'] = $message;
        $easy_new_thrd['case_count'] = 0;
        if ($is_dummy) {
            $easy_new_thrd['user_id'] = $easycase_data['Easycase']['assign_to'];
            $easy_new_thrd['updated_by'] = $easycase_data['Easycase']['assign_to'];
        } else {
            $easy_new_thrd['user_id'] = SES_ID;
            $easy_new_thrd['updated_by'] = SES_ID;
        }
        $easy_new_thrd['hours'] = 0;
        $easy_new_thrd['istype'] = 2;
        $easy_new_thrd['format'] = 2;
        $easy_new_thrd['isactive'] = 1;
        $easy_new_thrd['assign_to'] = $easycase_data['Easycase']['assign_to'];
        $easy_new_thrd['case_no'] = $easycase_data['Easycase']['case_no'];
        $easy_new_thrd['project_id'] = $easycase_data['Easycase']['project_id'];
        $easy_new_thrd['type_id'] = $easycase_data['Easycase']['type_id'];
        $easy_new_thrd['priority'] = $easycase_data['Easycase']['priority'];
        $easy_new_thrd['estimated_hours'] = $easycase_data['Easycase']['estimated_hours'];
        $easy_new_thrd['status'] = $easycase_data['Easycase']['status'];
        $easy_new_thrd['legend'] = $easycase_data['Easycase']['legend'];
        $easy_new_thrd['custom_status_id'] = $easycase_data['Easycase']['custom_status_id'];
        $easy_new_thrd['reply_type'] = $reply_type;
        $easy_new_thrd['dt_created'] = GMT_DATETIME;
        $easy_new_thrd['actual_dt_created'] = GMT_DATETIME;
        $this->save($easy_new_thrd);
        $curCaseId = $this->getLastInsertID();
        return $curCaseId;
    }
    public function addDummyTasks($proj_id, $comp_id, $user_id, $milestone_mod_ret, $dumy_user, $tzone, $PtTgIds, $pt_id)
    {
        if (($handle = fopen(CSV_PATH . "dummy_project/Orangescrum_Task_comment_timelog-data-updated.csv", "r")) !== false) {
            App::import('Component', 'Format');
            $format = new FormatComponent(new ComponentCollection);
            $i = 0;
            $j = 0;
            $separator = ',';
            $chk_coma = $data = fgetcsv($handle, 1000, ",");
            if (count($chk_coma) == 1 && stristr($chk_coma[0], ";")) {
                $separator = ';';
            }
            rewind($handle);
            $project_list = array();
            while (($data = fgetcsv($handle, 1000, $separator)) !== false) {
                if (!$i) {
                    $i++;
                #pr($data);
                } else {
                    #pr($data);
                    if ($data) {
                        $ret_task = $this->addDummytask($data, $proj_id, $comp_id, $user_id, $milestone_mod_ret, $dumy_user, $tzone, $PtTgIds, $pt_id);
                    }
                }
            }
        }
    }
    
    public function getParentTaxId($cs_no, $proj_id)
    {
        $ret_tax = $this->find('first', array('conditions' => array('Easycase.case_no' => $cs_no,'Easycase.istype' => 1,'Easycase.project_id' => $proj_id), 'fields' => array('Easycase.id')));
        if ($ret_tax) {
            return $ret_tax['Easycase']['id'];
        }
        return 0;
    }
    public function addDummytask($task_arr, $proj_id, $comp_id, $user_id, $milestone_mod_ret, $dumy_user, $tzone, $PtTgIds, $pt_id)
    {
        App::import('Component', 'Format');
        $format = new FormatComponent(new ComponentCollection);
        
        App::import('Component', 'Postcase');
        $postcase = new PostcaseComponent(new ComponentCollection);
        App::import('Component', 'Tmzone');
        $timezone = new TmzoneComponent(new ComponentCollection);
        
        $EasycaseMilestone = ClassRegistry::init('EasycaseMilestone');
        if ($task_arr) {
            $easycase = array();
            //if ($map[$con_val]) {
            //task group
            $milestone_id = 0;
            if ($milestone_mod_ret[$task_arr[0]]) {
                $milestone_id = $milestone_mod_ret[$task_arr[0]];
            }
            //task no
            $easycase['case_no'] = $task_arr[1];
            //task parent
            if (!empty($task_arr[2])) {
                $easycase['parent_task_id'] = $this->getParentTaxId($task_arr[2], $proj_id);
            } else {
                $easycase['parent_task_id'] = '';
            }
            //task title
            if ($task_arr[5] == 2) {
                $easycase['title'] = '';
            } else {
                $easycase['title'] = $task_arr[3];
            }
            //task description
            $easycase['message'] = $task_arr[4];
                    
            //task or comment
            $easycase['istype'] = $task_arr[5];
            if ($task_arr[5] == 2) {
                $easycase['title'] = '';
                $easycase['case_no'] = $task_arr[1];
            }
            //task attachment
            if (!empty($task_arr[6])) {
                $easycase['format'] = 1;
            } else {
                $easycase['format'] = 2;
            }
                    
            //task created date
            if (empty($task_arr[7])) {
                $created_date = GMT_DATETIME;
            } else {
                if (stristr($task_arr[7], "-")) {
                    $created_date = $task_arr[7];
                } elseif (stristr($task_arr[7], "/")) {
                    $created_date = str_replace("/", "-", $task_arr[7]);
                }
                $created_date = $timezone->convert_to_utc($tzone['Timezone']['id'], $tzone['Timezone']['gmt_offset'], 0, $tzone['Timezone']['code'], date('Y-m-d H:i', strtotime($created_date)), "datetime");
            }
            $easycase['actual_dt_created'] = $created_date;
            $easycase['dt_created'] = $created_date;
                    
            //task start date
            if (empty($task_arr[8])) {
                $start_date = GMT_DATETIME;
            } else {
                if (stristr($task_arr[8], "-")) {
                    $start_date = $task_arr[8];
                } elseif (stristr($task_arr[8], "/")) {
                    $start_date = str_replace("/", "-", $task_arr[8]);
                }
                $start_date = $timezone->convert_to_utc($tzone['Timezone']['id'], $tzone['Timezone']['gmt_offset'], 0, $tzone['Timezone']['code'], date('Y-m-d H:i', strtotime($start_date)), "datetime");
                //date('Y-m-d', strtotime($start_date))
            }
            $easycase['gantt_start_date'] = $start_date;
            //task due date
            if (empty($task_arr[9])) {
                $due_date = GMT_DATETIME;
            } else {
                if (stristr($task_arr[9], "-")) {
                    $due_date = $task_arr[9];
                } elseif (stristr($task_arr[9], "/")) {
                    $due_date = str_replace("/", "-", $task_arr[9]);
                }
                $due_date = $timezone->convert_to_utc($tzone['Timezone']['id'], $tzone['Timezone']['gmt_offset'], 0, $tzone['Timezone']['code'], date('Y-m-d H:i', strtotime($due_date)), "datetime");
                //date('Y-m-d', strtotime($start_date))
            }
            $easycase['due_date'] = $due_date;
            if (strtotime($due_date) < strtotime("now")) {
                $easycase['dt_created'] = $due_date;
            }
            //task estimated
            if (!empty($task_arr[10])) {
                $estimated_hours = trim($task_arr[10]);
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
            //task status
            $easycase['legend'] = $task_arr[11];
            $easycase['custom_status_id'] = 0;
            //task type
            $easycase['type_id'] = $task_arr[12];
            //assign to
            $easycase['assign_to'] = $dumy_user[$task_arr[13]]['User']['id'];
            $easycase['project_id'] = $proj_id;
            $easycase['user_id'] = $user_id;
            $pror = 2; //low
            $easycase['priority'] = $pror;
            $easycase['uniq_id'] = $format->generateUniqNumber();
            $easycase['isactive'] = 1;
                    
            $this->create();
            if ($this->save($easycase)) {
                $current_id = $this->getLastInsertID();
                //upload files here
                if ($easycase['format'] == 1 && !empty($task_arr[6])) {
                    $ret_uplod = $postcase->uploadAndInsertDumyFile(trim($task_arr[6]), $current_id, 0, $easycase['project_id'], $comp_id, $user_id);
                }
                //update thread count
                if ($easycase['istype'] == 2 && (!empty($easycase['message']) || !empty($task_arr[6]))) {
                    $this->updateAll(array('Easycase.thread_count'=>'Easycase.thread_count+1','Easycase.case_count'=>'Easycase.case_count+1'), array('Easycase.project_id' => $easycase['project_id'], 'Easycase.case_no' => $easycase['case_no'], 'Easycase.istype' => 1));
                }
                if ($task_arr[5] == 1) {
                    /** Save the resource availability data */
                    $RA = array(
                                'caseId'=>$current_id,
                                'caseUniqId'=>$easycase['uniq_id'],
                                'projectId'=>$easycase['project_id'],
                                'assignTo'=>$easycase['assign_to'],
                                'str_date'=>$easycase['gantt_start_date'],
                                'CS_due_date'=>$easycase['due_date'],
                                'est_hr'=>$task_arr[10]
                            );
                    if ($easycase['legend'] !=3 && $easycase['assign_to'] && ((!empty($RA['str_date']) && !empty($RA['est_hr'])) || (!empty($RA['str_date']) && !empty($RA['CS_due_date'])))) {
                        $RES = $format->overloadUsersUpdted($RA, $comp_id, $tzone);
                    }
                    /* End */
                    if ($milestone_id != 0) {
                        $EasycaseMiles = array();
                        $EasycaseMiles['easycase_id'] = $current_id;
                        $EasycaseMiles['milestone_id'] = $milestone_id;
                        $EasycaseMiles['project_id'] = $easycase['project_id'];
                        $EasycaseMiles['user_id'] = $user_id;
                        $EasycaseMiles['dt_created'] = GMT_DATETIME;
                        $EasycaseMilestone->create();
                        $EasycaseMilestone->save($EasycaseMiles);
                    }
                }
                if ($task_arr[5] == 2) {
                    $current_id = $this->getParentTaxId($task_arr[2], $proj_id);
                } else {
                    if ($pt_id) {
                        $ProjectTemplateCase = ClassRegistry::init('ProjectTemplateCase');
                        $pt_tasks = $easycase;
                        $pt_tasks['id'] = $current_id;
                        $pt_tasks['mil_id'] = $task_arr[0];
                        $ProjectTemplateCase->addDummyPtTasks($comp_id, $user_id, $pt_id, $pt_tasks, $milestone_mod_ret, $PtTgIds, $pt_id);
                    }
                }
                if ($current_id && !empty($task_arr[15])) {
                    //for time log
                    $t_log_array = array();
                    $t_log_array['project_id'] = $easycase['project_id'];
                    $t_log_array['task_id'] = $current_id;
                    $t_log_array['hrs'] = $task_arr[15];
                    $t_log_array['note'] = '';
                    $t_log_array['is_billable'] = $task_arr[16];
                    $t_log_array['task_date'] = $task_arr[14];
                    $t_log_array['timesheet_flag'] = 1;
                    $t_log_array['start_time'] = '';
                    $t_log_array['end_time'] = '';
                    $t_log_array['break_time'] = '';
                    //$t_log_array['usrid'] = $user_id;
                    $t_log_array['usrid'] = $easycase['assign_to'];
                    $ret_log_data = $this->addDummyTimelog($t_log_array, $comp_id, $tzone);
                }
            }
            //}
        }
    }
    
    public function addDummyTimelog($t_log_array, $comp_id, $tzone)
    {
        $LogTime_mod = ClassRegistry::init('LogTime');
        $Project_mod = ClassRegistry::init('Project');
        $logdata = $t_log_array;
        $start_time =  (isset($logdata['start_time']) && !empty($logdata['start_time']))?date("H:i:s", strtotime($logdata['start_time'])):'00:00:00';
        $end_time =  (isset($logdata['end_time']) && !empty($logdata['end_time']))?date("H:i:s", strtotime($logdata['end_time'])):'23:59:00';
        $start_time = $start_time;
        $end_time = ($end_time == "00:00:00")?'23:59:00':$end_time;
        $bArray = explode(':', $logdata['break_time']);
        $break_time = isset($bArray[0])?$bArray[0] * 3600:0;
        $break_time += isset($bArray[1])?$bArray[1] * 60:0;
        
        $log_id = 0;
        $mode = $log_id > 0 ? "edit" : "add";
        $slashes = $log_id > 0 ? '"' : '';
        $Project_mod->recursive = -1;
        $project_id = $logdata['project_id'];
        $task_id = isset($logdata['task_id']) ? trim($logdata['task_id']) : intval($logdata['hidden_task_id']);
        $users = $logdata['usrid'];
        $task_dates = $logdata['task_date'];
        if (stristr($logdata['task_date'], "-")) {
            $task_dates = $logdata['task_date'];
        } elseif (stristr($logdata['task_date'], "/")) {
            $task_dates = str_replace("/", "-", $logdata['task_date']);
        }
        $task_details = $this->find('first', array('conditions' => array('Easycase.id' => $task_id), 'fields' => array('Easycase.*')));
        $easycase_uniq_id = $task_details['Easycase']['uniq_id'];
        
        App::import('Component', 'Format');
        $format = new FormatComponent(new ComponentCollection);
        $caseuniqid = $format->generateUniqNumber();
        $reply_type = isset($logdata['task_id']) ? 10 : 11;
        $curCaseId = $this->insertCommentThreadCommon($task_details, 'timelog', $reply_type, 0, 1);
        
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
        if ($logdata['hrs']) {
            $total_hours = (int)$logdata['hrs'] * 3600;
        }
        $LogTime[0]['task_date'] = $slashes . $task_date . $slashes;
        #converted to UTC
        
        App::import('Component', 'Tmzone');
        $tmzone = new TmzoneComponent(new ComponentCollection);
        $LogTime[0]['start_datetime'] = $slashes . $tmzone->convert_to_utc($tzone['Timezone']['id'], $tzone['Timezone']['gmt_offset'], 0, $tzone['Timezone']['code'], $task_date . " " .  $start_time, "datetime") . $slashes;
        $LogTime[0]['end_datetime'] = $slashes . $tmzone->convert_to_utc($tzone['Timezone']['id'], $tzone['Timezone']['gmt_offset'], 0, $tzone['Timezone']['code'], $task_end_date . " " .  $end_time, "datetime") . $slashes;
        
        #stored in sec
        $LogTime[0]['total_hours'] = $total_hours;
        $LogTime[0]['is_billable'] = $logdata['is_billable'];
        $LogTime[0]['description'] = $slashes . addslashes(trim($logdata['note'])) . $slashes;
        $LogTime[0]['start_time'] = ($start_time)?$start_time:'00:00:00';
        $LogTime[0]['end_time'] = ($end_time)?$end_time:'23:59:00';
        $LogTime[0]['break_time'] =($break_time)?$break_time:0;
        $LogTime[0]['start_time'] = $slashes .$LogTime[0]['start_time'].$slashes ;
        $LogTime[0]['end_time'] = $slashes .$LogTime[0]['end_time'].$slashes;
        
        //pr($LogTime);exit;
        $LogTime_mod->saveAll($LogTime);
        $log_id = $LogTime_mod->getLastInsertID();

        /* update easycases task dt_created */
        $this->updateAll(array('Easycase.case_count'=>'Easycase.case_count+1','Easycase.dt_created' => "'".$LogTime[0]['end_datetime']."'",'Easycase.updated_by'=>$logdata['usrid']), array('Easycase.project_id' => $project_id, 'Easycase.id' => $task_id, 'Easycase.istype' => 1));
        
        $prj_details = $Project_mod->find('first', array('conditions' => array('Project.id' => $project_id), 'fields' => array('Project.id','Project.name')));
        
        $resArr = null;
        $resArr['LogTime']['log_id'] = $log_id;
        $resArr['LogTime']['is_billable'] = $logdata['is_billable'];
        $resArr['LogTime']['description'] = trim($logdata['note']);
        $resArr['LogTime']['total_hours'] = $logdata['hrs'];
        $resArr['LogTime']['task_name'] = $task_details['Easycase']['title'];
        $resArr['LogTime']['project_name'] = $prj_details['Project']['name'];
        $resArr['LogTime']['task_no'] = $task_details['Easycase']['case_no'];
        $resArr['LogTime']['project_id'] = $project_id;
        $resArr['LogTime']['task_id'] = $task_details['Easycase']['id'];
        $resArr['LogTime']['start_time'] = ($logdata['start_time'])?$logdata['start_time']:'00:00:00';
        $resArr['LogTime']['end_time'] = ($logdata['end_time'])?$logdata['end_time']:'23:59:00';
        $resArr['LogTime']['break_time'] = ($logdata['break_time'])?$logdata['break_time']:'0';
        return $resArr;
    }
    public function addOnlyDummyTask($proj_id, $comp_id, $user_id, $task_arr)
    {
        App::import('Component', 'Format');
        $format = new FormatComponent(new ComponentCollection);
        $postcase = new PostcaseComponent(new ComponentCollection);
        $easycase = array();
        //task no
        $easycase['case_no'] = 1;
        //task title
        $easycase['title'] = $task_arr['title'];
        //task description
        $easycase['message'] = $task_arr['description'];
        //task or comment
        $easycase['istype'] = 1;
        //task attachment
        if (!empty($task_arr['attach'])) {
            $easycase['format'] = 1;
        } else {
            $easycase['format'] = 2;
        }
        $easycase['actual_dt_created'] = GMT_DATETIME;
        $easycase['dt_created'] = GMT_DATETIME;
        //task start date
        //$easycase['gantt_start_date'] = GMT_DATETIME;
        //task due date
        //$easycase['due_date'] = GMT_DATETIME;
        //task estimated
        $easycase['estimated_hours'] = 0;

        $Project = ClassRegistry::init('Project');
        $CustomStatus = ClassRegistry::init('CustomStatus');
        $status_group = $Project->find('first', array('conditions'=>array('Project.id'=>$proj_id),'fields'=>array('Project.status_group_id')));
        if (!empty($status_group['Project']['status_group_id'])) {
            $cstst = $CustomStatus->find('first', array('conditions'=>array('CustomStatus.status_group_id'=>$status_group['Project']['status_group_id']),'fields'=>array('CustomStatus.id','CustomStatus.status_master_id'),'order'=>array('  CustomStatus.seq'=>'ASC')));
            //task status
            $easycase['legend'] = $cstst['CustomStatus']['status_master_id'];
            $easycase['custom_status_id'] = $cstst['CustomStatus']['id'];
        } else {
            //task status
                $easycase['legend'] = 1; //will customize as per the status template later
                $easycase['custom_status_id'] = 0;
        }
            
            
        //task type (default development)
        $easycase['type_id'] = 2;
        //assign to
        $easycase['assign_to'] = $user_id;
        $easycase['project_id'] = $proj_id;
        $easycase['user_id'] = $user_id;
        $easycase['priority'] = 1; //Medium as default
        $easycase['uniq_id'] = $format->generateUniqNumber();
        $easycase['isactive'] = 1;
        $this->create();
        if ($this->save($easycase)) {
            $current_id = $this->getLastInsertID();
            //upload files here
            if ($easycase['format'] == 1 && !empty($task_arr['attach'])) {
                $ret_uplod = $postcase->uploadAndInsertOnlyDumyFile(trim($task_arr['attach']), $current_id, 0, $easycase['project_id'], $comp_id, $user_id);
            }
            return $current_id;
        }
        return false;
    }
    public function getformatedDueDate($caseDueDate, $caseTypeId, $caseLegend, $maxlegend, $tz, $dt)
    {
        $curdtT = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
        //  echo "caseTypeId:-".$caseTypeId."-- caseLegend--".$caseLegend."-- maxlegend".$maxlegend;
        if ($caseTypeId == 10 || $caseLegend == 3 || $caseLegend == 5 || $caseLegend == $maxlegend) {
            if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00" && $caseDueDate != "1970-01-01") {
                if ($caseDueDate < $curdtT) {
                    $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                    $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                    $csDueDate = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                    $csDuDtFmt = $csDueDate; //revised
                    $csDuDtFmt1 = $csDueDate;
                } else {
                    $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                    $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                    $csDuDtFmt1 = $csDuDtFmt;
                }
            } else {
                $csDuDtFmtT = '';
                $csDuDtFmt = '';
                $csDuDtFmt1 = $csDuDtFmt;
            }
            $csDueDate = $csDuDtFmt;
            $csDueDate1 = $csDuDtFmt1;
        } else {
            if ($caseDueDate != "NULL" && $caseDueDate != "0000-00-00 00:00:00" && $caseDueDate != "" && $caseDueDate != "1970-01-01 00:00:00" && $caseDueDate != "1970-01-01") {
                //  echo strtotime($caseDueDate)."--".strtotime($curdtT);
                //   echo $caseDueDate;
                if (strtotime($caseDueDate) < strtotime($curdtT)) {
                    //     echo "here1";
                    $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                    $csDuDtFmt = '<span class="over-due">'.__('Overdue', true).'</span>';
                    //Find date diff in days.
                    $date1 = date_create($curdtT);
                    $date2 = date_create(date('Y-m-d', strtotime($caseDueDate)));
                    $diff = date_diff($date1, $date2, true);
                    $diff_in_days = $diff->format("%a");
                    $csDuDtFmtBy = ($diff_in_days > 1) ? 'by ' . $diff_in_days . ' days' : 'by ' . $diff_in_days . ' day';
                    $csDueDate = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                    $csDueDate1 = $csDueDate;
                } else {
                    //   echo "here2";
                    $csDuDtFmtT = $dt->facebook_datestyle($caseDueDate);
                    $csDuDtFmt = $dt->dateFormatOutputdateTime_day($caseDueDate, $curCreated, 'week');
                    $csDuDtFmt1 = $csDuDtFmt;
                    $csDueDate = $csDuDtFmt;
                    $csDueDate1 = $csDuDtFmt1;
                    $csDuDtFmtBy = '';
                }
            } else {
                $csDuDtFmtT = '';
                $csDuDtFmt = '<span class="set-due-dt">'.__('Schedule it', true).'</span>';
                $csDuDtFmt1 = $csDuDtFmt;
                $csDueDate = '';
                $csDueDate1 = '';
                $csDuDtFmtBy = '';
            }
        }
        $caseAll['csDuDtFmtT'] = $csDuDtFmtT;
        $caseAll['csDuDtFmt'] = $csDuDtFmt;
        $caseAll['csDuDtFmt1'] = $csDueDate1;
        $caseAll['csDuDtFmtBy'] = $csDuDtFmtBy;
        $caseAll['csDueDate'] = $csDueDate;
        $caseAll['csDueDate1'] = $csDueDate1;
        return $caseAll;
    }
  
    public function getMilestoneIds($task_id, $project_id)
    {
        $Easycase_milestone = ClassRegistry::init('EasycaseMilestone');
        $esmlstn_dtls = $Easycase_milestone->find("first", array("conditions"=>array("EasycaseMilestone.easycase_id"=>$task_id,"EasycaseMilestone.project_id"=>$project_id)));
        $milestone_id =  $esmlstn_dtls ? $esmlstn_dtls["EasycaseMilestone"]["milestone_id"] : 0;
        return $milestone_id;
    }
  
    public function getMembersAndTask($projId, $comp_id = null, $search_val = '')
    {
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $user = ClassRegistry::init('User');
        $Project = ClassRegistry::init('Project');
        $company_id = ($comp_id) ? $comp_id : SES_COMP;
        
        if ($search_val) {
            $quickMem = $ProjectUser->query("SELECT DISTINCT User.name,User.id,User.uniq_id,CompanyUser.is_client,  User.last_name, User.email, User.istype,User.short_name,User.photo FROM users as User,project_users as ProjectUser,company_users as CompanyUser,projects as Project WHERE User.name LIKE '%" . trim($search_val) . "%' AND CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . $company_id . "' AND Project.uniq_id='" . $projId . "' AND Project.id=ProjectUser.project_id AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.name ASC");
        } else {
            $quickMem = $ProjectUser->query("SELECT DISTINCT User.id,User.uniq_id,CompanyUser.is_client, User.name, User.last_name, User.email, User.istype,User.short_name,User.photo FROM users as User,project_users as ProjectUser,company_users as CompanyUser,projects as Project WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . $company_id . "' AND Project.uniq_id='" . $projId . "' AND Project.id=ProjectUser.project_id AND User.isactive='1' AND ProjectUser.user_id=User.id ORDER BY User.name ASC");
        }
        $t_arr = array();
        $quickMems = array();
        if ($quickMem) {
            foreach ($quickMem as $k => $v) {
                $quickMems[$k] = $quickMem[$k]['User'];
                if (!empty($v['User']['last_name'])) {
                    $quickMems[$k]['name'] = $v['User']['name'].' ' . $v['User']['last_name'];
                } else {
                    $quickMems[$k]['name'] = $v['User']['name'];
                }
                // $quickMems[$k]['id'] = $v['User']['id'];
                if ($v['User']['photo'] == '') {
                    $quickMems[$k]['asgnbgcolor'] = $user->getProfileBgColr($v['User']['id']);
                } else {
                    $quickMems[$k]['photo'] = $v['User']['photo'];
                }
                $quickMems[$k]['type'] = "user";
                //add newly on 26-09-2017
                
                $quickMems[$k]['is_client'] = $v['CompanyUser']['is_client'];
                if (!in_array($quickMems[$k]['id'], $t_arr)) {
                    array_push($t_arr, $quickMems[$k]['id']);
                } else {
                    unset($quickMems[$k]);
                }
            }
        }
        $Project->recursive = -1;
        $this->recursive = -1;
        $prj = $Project->findByUniqId($projId);
        if ($search_val) {
            $case_lists = $this->find('all', array("conditions"=>array("Easycase.project_id"=>$prj["Project"]["id"],"Easycase.istype"=>1,"Easycase.isactive"=>1,"Easycase.title LIKE '%".trim($search_val)."%'"),"fields"=>array("id","title","uniq_id")));
        } else {
            $case_lists = $this->find('all', array("conditions"=>array("Easycase.project_id"=>$prj["Project"]["id"],"Easycase.istype"=>1,"Easycase.isactive"=>1),"fields"=>array("id","title","uniq_id")));
        }
        if ($case_lists) {
            $tsk_arr = array();
            $i =0;
            foreach ($case_lists as $ke=>$ve) {
                $tsk_arr[$i]["name"] = $ve["Easycase"]["title"];
                $tsk_arr[$i]["id"] = $ve["Easycase"]["id"];
                $tsk_arr[$i]["type"] = "task";
                $tsk_arr[$i]["uniq_id"] = $ve["Easycase"]["uniq_id"];
                $i++;
            }
            if ($tsk_arr) {
                $quickMems = array_merge($quickMems, $tsk_arr);
            }
        }
        // echo "<pre>";print_r();
        return $quickMems;
    }
  
    /* Save depends for task while creating project from project plan
    Sangita - 06/07/2021
    */
    public function saveDepends($id, $dependsId)
    {
        $this->create();
        $this->id = $id;
        $saveDependant = $this->saveField('depends', $dependsId);
        return $saveDependant;
    }
    /* Save children for task while creating project from project plan
      Sangita - 06/07/2021
      */
    public function saveChildren($id, $childrenId)
    {
        $this->create();
        $this->id = $id;
        $saveChildren = $this->saveField('children', $childrenId);
        return $saveChildren;
    }
    /* Save depends for task while creating project-plan from task list
     *  PRB
     */
    public function savePlanDependency($case_all, $template_cases)
    {
        $case_all = (empty($case_all))? array() : Hash::combine($case_all, '{n}.ProjectTemplateCase.id', '{n}.ProjectTemplateCase');
        if (empty($case_all) || empty($template_cases)) {
            return true;
        }
        foreach ($case_all as $k => $templateCase) {
            if (!empty($templateCase['depends'])) {
                $dependsId = explode(',', $templateCase['depends']);
                $dependsId = array_filter($dependsId);
                $this->saveDepends($template_cases[$templateCase['id']], $this->validateDependChildren($case_all, $dependsId, $template_cases));
            }
            if (!empty($templateCase['children'])) {
                $childrenId = explode(',', $templateCase['children']);
                $childrenId = array_filter($childrenId);
                $this->saveChildren($template_cases[$templateCase['id']], $this->validateDependChildren($case_all, $childrenId, $template_cases));
            }
        }
    }
        
    /*
    * Check the depend and children present in the project plans
    * PRB
    * 07/07/21
    * return string
    */
    public function validateDependChildren($case_all, $input_array, $template_cases)
    {
        $ret_id = '';
        foreach ($input_array as $id) {
            if (array_key_exists($id, $case_all)) {
                if (isset($template_cases[$id])) {
                    $ret_id .= ','.$template_cases[$id];
                }
            }
        }
            
        return trim($ret_id, ',');
    }
        
    /* Fetch all tasks of a project
    Sangita - 06/07/2021
    */
    public function fetchAllCases($projectId)
    {
        $allCaseList = $this->find('all', array('conditions'=>array('Easycase.project_id'=>$projectId,'Easycase.isactive'=>1,'Easycase.istype'=>1),"fields"=>array('Easycase.id')));
        $allCases = Hash::extract($allCaseList, "{n}.Easycase.id");
            
        return $allCases;
    }
        
    /*
     * Author PRB
     * This method is used to get the task title and description of selected tasks
     * $case_id might be a id or a array of ids
     */
    public function getDetailsofAllTask($case_id)
    {
        $AllTasks = $this->find('all', array('conditions' => array('Easycase.id' => $case_id), 'fields' => array('Easycase.id','Easycase.title', 'Easycase.message','Easycase.type_id','Easycase.priority','Easycase.story_point','Easycase.assign_to','Easycase.estimated_hours','Easycase.parent_task_id','Easycase.depends','Easycase.children')));
                
        return (empty($AllTasks))? array() : Hash::combine($AllTasks, '{n}.Easycase.id', '{n}.Easycase');
    }
    /*
     * Author Sangita
     * This method is used to calculate the ACF time balance
     * 01/08/2021
     */
    public function timeBalanceCalculation($caseId)
    {
        $easycaseDtl = $this->find('first', array('conditions' => array('Easycase.id' => $caseId)));
             
        if (!empty($easycaseDtl['Easycase']['due_date'])) {
            // $currDateTime = date("Y-m-d H:i:s");
            $currDateTime = GMT_DATETIME;
            $currentDate = new DateTime($currDateTime);
            $dueDate = new DateTime($easycaseDtl['Easycase']['due_date']);
            $timeBalance= date_diff($currentDate, $dueDate);
     
            if ($timeBalance->invert == 1) {
                $timeBalanceRemaining = $timeBalance->format('-%a days %h hours');
            } else {
                $timeBalanceRemaining = $timeBalance->format('%a days %h hours');
            }
        } else {
            $timeBalanceRemaining = '0';
        }
        return $timeBalanceRemaining;
    }


    /*
     * Author Bijaya
     * This method is used to get resource cost details

     */
    public function fetchResourceCostDetails($usr_cond, $dateCond, $projQry)
    {
        $log_sql ="SELECT 
        SUM(LogTime.total_hours) AS hours, 
        CONCAT(User.name,Char(32),User.last_name) AS user_name, 
        User.id, 
        InvoiceCustomer.currency, 
        Project.name, 
        ProjectMeta.project_manager, 
        ProjectMeta.default_rate, 
        RoleRate.rate as billable_rate, 
        RoleRate.actual_rate as actual_rate, 
        InvoiceCustomer.organization as project_company_name,
    IF(IFNULL(RoleRate.user_id,'0')='0',ProjectMeta.default_rate,IF(IFNULL(RoleRate.is_active,0)=0,ProjectMeta.default_rate,RoleRate.rate)) rate
    FROM log_times AS LogTime
         LEFT JOIN easycases AS Easycase
            ON LogTime.task_id=Easycase.id 
            AND LogTime.project_id=Easycase.project_id 
         LEFT JOIN users AS User 
            ON LogTime.user_id = User.id 
         LEFT JOIN projects AS Project 
            ON LogTime.project_id= Project.id 
         LEFT outer join project_metas ProjectMeta 
            ON Project.id = ProjectMeta.project_id 
         LEFT join invoice_customers as InvoiceCustomer 
            ON Project.id = InvoiceCustomer.project_id 
         LEFT JOIN role_rates AS RoleRate 
            ON (LogTime.project_id = RoleRate.project_id AND LogTime.user_id = RoleRate.user_id)
            WHERE Easycase.isactive=1 AND " . $usr_cond . " " . $dateCond . " " . $projQry . " AND
            Project.company_id=" . SES_COMP . " AND
            Project.isactive=1 AND
            LogTime.is_billable =1
    GROUP BY LogTime.user_id,LogTime.project_id 
    ORDER BY DATE(LogTime.start_datetime) DESC";
        return $log_sql;
    }
    
    /**
     * logTimeDetailsForCostReport
     * get the total log time hours of a project
     * @param  mixed $usr_cond_arr
     * @param  mixed $joins
     * @return array
     * @author bijay
     * date - 06/08/25021
     *
     */
    public function logTimeDetailsForCostReport($usr_cond_arr, $joins)
    {
        $logtime_cls = ClassRegistry::init('LogTime');
        $logtime = $logtime_cls->find('all', array(
            'conditions' => $usr_cond_arr,
            'fields' => array('SUM(LogTime.total_hours) AS spent_hours', 'LogTime.user_id', 'Project.id'),
            'group' => array('LogTime.user_id', 'LogTime.project_id'),
            'order' => 'LogTime.project_id ASC',
            'joins' => $joins
        ));
        return $logtime;
    }
    
    /**
     * rateDetailsForCostReport
     *  get the total rates of all the user of a project
     * @param  mixed $usr_rte_cond_arr
     * @param  mixed $joins
     * @return array
     * @author bijay
     * date - 06/08/25021
     */
    public function rateDetailsForCostReport($usr_rte_cond_arr, $joins)
    {
        $rorate_cls = ClassRegistry::init('RoleRate');
        $rates = $rorate_cls->find('all', array(
            'conditions' => $usr_rte_cond_arr,
            'fields' => array('RoleRate.rate', 'RoleRate.actual_rate', 'RoleRate.user_id', 'Project.id'),
            'group' => array('RoleRate.user_id', 'RoleRate.project_id'),
            'order' => 'RoleRate.project_id ASC',
            'joins' => $joins,
        ));
        return $rates;
    }
      
    /**
     * allProjectDetailsForCostReport
     * get all the projects and their users
     * @param  mixed $conditions
     * @param  mixed $ordr
     * @return array
     * @author bijay
     * date - 06/08/2021
     */
    public function allProjectDetailsForCostReport($conditions, $ordr)
    {
        $project_cls = ClassRegistry::init('Project');
        $projects = $project_cls->find(
            'all',
            array('joins' => array(
        array('table' => 'invoice_customers',
            'alias' => 'InvoiceCustomer',
            'type' => 'LEFT',
            'conditions' => array(
                'Project.id = InvoiceCustomer.project_id'
            )
        ),
        array('table' => 'project_metas',
        'alias' => 'ProjectMeta',
        'type' => 'LEFT',
        'conditions' => array(
            'Project.id = ProjectMeta.project_id'
            )
        )
    ), 'conditions' => $conditions,
    'fields' => array('Project.id', 'Project.name', 'Project.estimated_hours', 'ProjectMeta.budget', 'ProjectMeta.cost_appr', 'ProjectMeta.default_rate', 'ProjectMeta.min_tol', 'ProjectMeta.max_tol', 'Project.start_date', 'Project.end_date', 'Project.dt_created', 'ProjectMeta.currency', 'InvoiceCustomer.organization AS Company_name','ProjectMeta.project_manager', 'InvoiceCustomer.currency AS currency'),
    'order' => $ordr)
        );
        return $projects;
    }
    public function getTotalCloseDefectCount($task_id)
    {
        $Defect = ClassRegistry::init('Defect');
        $Project = ClassRegistry::init('Project');
        $task_detail = $this->findById($task_id);
        $getproj = $Project->findById($task_detail['Easycase']['project_id']);
        $latestprojuniqid = $getproj['Project']['uniq_id'];
        $resCaseProj['DefectAll'] = array();
        $getProjectUniqId = $latestprojuniqid;
        $project_id = $getproj['Project']['id'];
        $status_group = $getproj['Project']['defect_status_group_id'];
        if ($status_group > 0) {
            $CustomStatus = ClassRegistry::init('CustomStatus');
            $Defect_close = $CustomStatus->getCustomStatusId($project_id, 'max');
        } else {
            $Defect_close = 3;
        }

        $resCaseProj['projUniq'] = $getProjectUniqId;
        $resCaseProj['status_group'] = $status_group;
        $resCaseProj['Defect_close'] = $Defect_close;
        $resCaseProj['project_id'] = $project_id;
        $resCaseProj['task_id'] = $task_id;
        $params['joins'] = array(
        array(
            'table' => 'easycases',
            'alias' => 'Easycase',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`task_id` = `Easycase`.`id`'
            )
        ),
        array(
            'table' => 'projects',
            'alias' => 'Project',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`project_id` = `Project`.`id`'
            )
        )
    );
        $params2['joins'] = array(
        array(
            'table' => 'easycases',
            'alias' => 'Easycase',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`task_id` = `Easycase`.`id`'
            )
        )
    );
        if (isset($task_id)) {
            $params['conditions'] = array('Defect.task_id' => $task_id,'Defect.istype' => 1);
        }
        if (SES_TYPE == 3) {
            $params['conditions'][] = array('OR' => array('Defect.assign_to' => SES_ID, 'Defect.user_id' => SES_ID, 'Defect.reporter_id' => SES_ID, 'Defect.owner_id' => SES_ID));
        }
        $params['fields'] = array('Defect.*', 'Easycase.id', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.case_no', 'Easycase.istype', 'Project.id', 'Project.id', 'Project.uniq_id', 'Project.name');
    
        $Defect->recursive = 1;
        $defects = $Defect->find('all', $params);
        $params['conditions'] = [];
        if (isset($task_id)) {
            $params['conditions'] = array('Defect.task_id' => $task_id,'Defect.istype' => 1, 'Defect.defect_status_id' => 3);
        }
        if (SES_TYPE == 3) {
            $params['conditions'][] = array('OR' => array('Defect.assign_to' => SES_ID, 'Defect.user_id' => SES_ID, 'Defect.reporter_id' => SES_ID, 'Defect.owner_id' => SES_ID));
        }
        $defects_close = $Defect->find('all', $params);
        $resCaseProj['total'] = count($defects);
        $resCaseProj['closed'] = count($defects_close);
        return  $resCaseProj;
    }
    /*
       * Author PRB
       * This method is used to get the task counts and default task group
           * $case_id might be a id or a array of ids
       */
    public function getTaskCountOfDefauultTaskGroup($projId, $searchFiltrs)
    {
        //we will put this in cache later
        $qry_m = ' EasycaseMilestone.milestone_id IS NULL ';
        if ($searchFiltrs['qry'] != '') {
            $qry_m = '1 '.$searchFiltrs['qry'];
        }
        if ($qry_m == '') {
            $qry_m = '1';
        }
        $this->bindModel(array('hasOne' => array('EasycaseMilestone'=>array(
            'className' => 'EasycaseMilestone',
            'foreignKey' => 'easycase_id'
            ))));
        $default_tgrp = $this->find('all', array('conditions'=>array('Easycase.project_id'=>$projId,'Easycase.isactive'=>1,'Easycase.istype'=>1,$qry_m),'fields'=>array('COUNT(Easycase.id) as CNT')));
            
        return $default_tgrp;
    }
    /**
    * get the defect detail when task id is passsed
    *@author Ch pattnaik
    * @return array
    */
    public function getTaskDefect($task_id)
    {
        $Defect = ClassRegistry::init('Defect');
        $Project = ClassRegistry::init('Project');
        $task_detail = $this->findById($task_id);
        $getproj = $Project->findById($task_detail['Easycase']['project_id']);
        $latestprojuniqid = $getproj['Project']['uniq_id'];
        $resCaseProj['DefectAll'] = array();
        $getProjectUniqId = $latestprojuniqid;
        $project_id = $getproj['Project']['id'];
        $status_group = $getproj['Project']['defect_status_group_id'];
        if ($status_group > 0) {
            $CustomStatus = ClassRegistry::init('CustomStatus');
            $Defect_close = $CustomStatus->getCustomStatusId($project_id, 'max');
        } else {
            $Defect_close = 3;
        }

        $resCaseProj['projUniq'] = $getProjectUniqId;
        $resCaseProj['status_group'] = $status_group;
        $resCaseProj['Defect_close'] = $Defect_close;
        $resCaseProj['project_id'] = $project_id;
        $resCaseProj['task_id'] = $task_id;
        $params['joins'] = array(
        array(
            'table' => 'easycases',
            'alias' => 'Easycase',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`task_id` = `Easycase`.`id`'
            )
        ),
        array(
            'table' => 'projects',
            'alias' => 'Project',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`project_id` = `Project`.`id`'
            )
        ),
        array(
            'table' => 'defect_issue_types',
            'alias' => 'DefectIssueType',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_issue_type_id` = `DefectIssueType`.`id`'
            )
        ),
        array(
            'table' => 'defect_severities',
            'alias' => 'DefectSeverity',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_severity_id` = `DefectSeverity`.`id`'
            )
        ),
        array(
            'table' => 'defect_phases',
            'alias' => 'DefectPhase',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_phase_id` = `DefectPhase`.`id`'
            )
        ),
        array(
            'table' => 'defect_categories',
            'alias' => 'DefectCategory',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_category_id` = `DefectCategory`.`id`'
            )
        ),
        array(
            'table' => 'defect_activity_types',
            'alias' => 'DefectActivityType',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_activity_type_id` = `DefectActivityType`.`id`'
            )
        ),
        array(
            'table' => 'defect_affect_versions',
            'alias' => 'DefectAffectVersion',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_affects_version_id` = `DefectAffectVersion`.`id`'
            )
        ),
        array(
            'table' => 'defect_fix_versions',
            'alias' => 'DefectFixVersion',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_fix_version_id` = `DefectFixVersion`.`id`'
            )
        ),
        array('table' => 'custom_statuses',
            'alias' => 'DefectStatus',
            'type' => 'LEFT',
            'conditions' => array(
                'Defect.defect_status_id = DefectStatus.id'
            )
        ),
        array(
            'table' => 'defect_root_causes',
            'alias' => 'DefectRootCause',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_root_cause_id` = `DefectRootCause`.`id`'
            )
        ),
        array(
            'table' => 'defect_origins',
            'alias' => 'DefectOrigin',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_origin_id` = `DefectOrigin`.`id`'
            )
        ),
        array(
            'table' => 'defect_resolutions',
            'alias' => 'DefectResolution',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`defect_resolution_id` = `DefectResolution`.`id`'
            )
        ),
        array(
            'table' => 'users',
            'alias' => 'AssignUser',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`assign_to` = `AssignUser`.`id`'
            )
        ),
        array(
            'table' => 'users',
            'alias' => 'ReporterUser',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`reporter_id` = `ReporterUser`.`id`'
            )
        ),
        array(
            'table' => 'users',
            'alias' => 'OwnerUser',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`owner_id` = `OwnerUser`.`id`'
            )
        )
    );
        $params2['joins'] = array(
        array(
            'table' => 'easycases',
            'alias' => 'Easycase',
            'type' => 'LEFT',
            'conditions' => array(
                '`Defect`.`task_id` = `Easycase`.`id`'
            )
        )
    );
        if (isset($task_id)) {
            $params['conditions'] = array('Defect.task_id' => $task_id,'Defect.istype' => 1);
        }
        if (SES_TYPE == 3) {
            $params['conditions'][] = array('OR' => array('Defect.assign_to' => SES_ID, 'Defect.user_id' => SES_ID, 'Defect.reporter_id' => SES_ID, 'Defect.owner_id' => SES_ID));
        }
        $params['fields'] = array('Defect.*', 'DefectResolution.id', 'DefectResolution.name', 'DefectOrigin.id', 'DefectOrigin.name', 'OwnerUser.id', 'OwnerUser.name', 'ReporterUser.id', 'ReporterUser.name', 'AssignUser.id', 'AssignUser.name', 'DefectRootCause.id', 'DefectRootCause.name', 'DefectStatus.id', 'DefectStatus.name', 'DefectStatus.color', 'DefectFixVersion.id', 'DefectFixVersion.name', 'DefectAffectVersion.id', 'DefectAffectVersion.name', 'DefectActivityType.id', 'DefectActivityType.name', 'DefectCategory.id', 'DefectCategory.name', 'DefectPhase.id', 'DefectPhase.name', 'DefectSeverity.id', 'DefectSeverity.name', 'DefectSeverity.color', 'DefectIssueType.id', 'DefectIssueType.name', 'DefectIssueType.color', 'Easycase.id', 'Easycase.title', 'Easycase.uniq_id', 'Easycase.case_no', 'Easycase.istype', 'Project.id', 'Project.id', 'Project.uniq_id', 'Project.name');
    
        $Defect->recursive = 1;
        $defects = $Defect->find('all', $params);
        $resCaseProj['DefectAll'] = $defects;
        return  $resCaseProj;
    }
    public function totalSpentHrClosedTask($curProjId,$mid){
        $db = $this->getDataSource();
        $spnt_hr =  $db->fetchAll("SELECT sum(total_hours) as secds FROM log_times a, easycases b , easycase_milestones c WHERE a.task_id = b.id AND a.project_id=b.project_id and b.istype='1' AND b.isactive=1 AND b.project_id=:curProjId AND c.milestone_id=:mid and b.id= c.easycase_id and (b.legend = 3 OR b.legend = 5)",array('curProjId'=>$curProjId,'mid' =>$mid));
        return $spnt_hr;
    }
}
