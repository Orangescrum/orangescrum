<?php
//commented due to error 21-06-2018
/*use ElephantIO\Engine\SocketIO\Version1X as Version1X;
use ElephantIO\Client as Client;

require ROOT . '/app/Plugin/ElephantIO/vendor/autoload.php';
*/
App::import('Component', 'Cookie');
App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));

//use ElephantIO\Client as ElephantIOClient;

class PostcaseComponent extends CookieComponent
{
    public $components = array('Session', 'Email', 'Cookie', 'Format', 'Sendgrid', 'Tmzone','PhpMailer');

    public function casePosting($formdata, $fromMobile = null, $gitissue = array())
    {
        $Easycase = ClassRegistry::init('Easycase');
        $pagename = $formdata['pagename'];
        if (isset($formdata['gitissueArr'])) {
            $gitissue = 1;
        }
        $checkList = array();
        $checkListSts = array();
        if (isset($formdata['allchklistSts']) && isset($formdata['allchklist'])) {
            $checkList = $formdata['allchklist'];
            $checkListSts = $formdata['allchklistSts'];
        }
        $mention_array = array();
        if ($formdata['mention_array']['mention_type_id'] && $formdata['mention_array']['mention_type']) {
            $mention_array = $formdata['mention_array'];
        }
                                
        if (!empty($gitissue)) {
            $postParam['Easycase']['git_sync'] = isset($formdata['git_sync']) ? $formdata['git_sync'] : 0;
            $postParam['Easycase']['git_issue_id'] = isset($formdata['git_issue_id']) ? $formdata['git_issue_id'] : 0;
            $postParam['Easycase']['real_git_issue_id'] = isset($formdata['real_git_issue_id']) ? $formdata['real_git_issue_id'] : 0;
        }
        $postParam['Easycase']['isactive'] = 1;
        $postParam['Easycase']['project_id'] = $formdata['CS_project_id'];
        $postParam['Easycase']['istype'] = $formdata['CS_istype'];
        $postParam['Easycase']['title'] = $formdata['CS_title'];
        $postParam['Easycase']['type_id'] = $formdata['CS_type_id'];
        $postParam['Easycase']['priority'] = $formdata['CS_priority'];
        $postParam['Easycase']['assign_to'] = $formdata['CS_assign_to'];
        $custom_legend = 1;
        $custom_status = 0;
        $getTitle_dtl = null;
        $hasCustomStatusGroup = $this->Format->hasCustomTaskStatus($formdata['CS_project_id'], 'Project.uniq_id');
        $custom_legend_name = '';
        $custom_legend_clr = '';
        if (!empty($gitissue)) {
            $git_legend = $formdata['CS_legend'];
            if ($hasCustomStatusGroup) {
                $CustomStatus = ClassRegistry::init('CustomStatus');
                if ($git_legend) {
                    $sts_cond = array('CustomStatus.status_group_id' => $hasCustomStatusGroup, 'CustomStatus.status_master_id' => $git_legend);
                } else {
                    $sts_cond = array('CustomStatus.status_group_id' => $hasCustomStatusGroup);
                }
                $CustomStatusArr = $CustomStatus->find('first', array('conditions' => $sts_cond, 'order' => array('CustomStatus.seq' => 'ASC')));
                                
                $custom_status = $CustomStatusArr['CustomStatus']['id'];
                $custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
                $custom_legend_name = $CustomStatusArr['CustomStatus']['name'];
                $custom_legend_clr = $CustomStatusArr['CustomStatus']['color'];
            } else {
                $custom_legend = ($formdata['depend'] == "Yes") ? $formdata['CS_legend'] : 1;
            }
        } else {
            if ($hasCustomStatusGroup) {
                $CustomStatus = ClassRegistry::init('CustomStatus');
                if ((!$formdata['taskid'] && !$formdata['CS_id']) || ($formdata['taskid'] && !$formdata['CS_id'])) { // add and edit
                    $sts_cond = array('CustomStatus.status_group_id'=>$hasCustomStatusGroup);
                } else {
                    $sts_cond = array('CustomStatus.status_group_id'=>$hasCustomStatusGroup, 'CustomStatus.id'=>$formdata['CS_legend']);
                }
                $CustomStatusArr =  $CustomStatus->find('first', array('conditions'=>$sts_cond,'order'=>array('CustomStatus.seq'=>'ASC')));
                $custom_status = $CustomStatusArr['CustomStatus']['id'];
                $custom_legend = $CustomStatusArr['CustomStatus']['status_master_id'];
                $custom_legend_name = $CustomStatusArr['CustomStatus']['name'];
                $custom_legend_clr = $CustomStatusArr['CustomStatus']['color'];
            } else {
                $custom_legend = ($formdata['depend'] == "Yes") ? $formdata['CS_legend'] : 1;
            }
        }
        
        $postParam['Easycase']['legend'] = $custom_legend;
        $postParam['Easycase']['custom_status_id'] = $custom_status;
        $postParam['Easycase']['seq_id'] = intval($formdata['seq_id']);
        $postParam['Easycase']['hours'] = 0; #$formdata['hours'];
        if (isset($formdata['story_point'])) {
            $postParam['Easycase']['story_point'] = abs($formdata['story_point']);
        }
        if ($formdata['taskid']) {
            $postParam['Easycase']['parent_task_id'] = $Easycase->getSetParentId($formdata['taskid'], trim($formdata['CS_parent_id']));
        } else {
            $postParam['Easycase']['parent_task_id'] = trim($formdata['CS_parent_id']);
        }
        if (isset($formdata['gantt_start_date']) && !empty($formdata['gantt_start_date'])) {
            $postParam['Easycase']['gantt_start_date'] = $formdata['gantt_start_date'];
        }
        if (isset($formdata['CS_isRecurring'])) {
            $postParam['Easycase']['is_recurring'] = $formdata['CS_isRecurring'];
        } else {
            $postParam['Easycase']['is_recurring'] = 0;
        }
        $estimated_hours = $formdata['estimated_hours'];
        /* saving in secs */
        if (strpos($estimated_hours, ':') > -1) {
            $split_est = explode(':', $estimated_hours);
            $est_sec = ((($split_est[0]) * 60) + intval($split_est[1])) * 60;
        } else {
            $est_sec = $estimated_hours * 3600;
        }
        $estimated_hours = $est_sec;

        $postParam['Easycase']['completed_task'] = $formdata['completed'] ? $formdata['completed'] : 0;
        $postParam['Easycase']['is_chrome_extension'] = (isset($formdata['is_chrome_extension'])) ? $formdata['is_chrome_extension'] : 0;
        $postParam['Easycase']['client_status'] = $formdata['is_client'];
        $prelegend = $formdata['prelegend'];

        if (isset($formdata['datatype']) && $formdata['datatype'] == 1) {
            $postParam['Easycase']['message'] = $formdata['CS_message'];
        } else {
            $postParam['Easycase']['message'] = $formdata['CS_message'];
        }
        if (isset($formdata['CS_start_date']) && trim($formdata['CS_start_date']) != '' && trim($formdata['CS_start_date']) != 'No Start Date') {
            $postParam['Easycase']['gantt_start_date'] = $formdata['CS_start_date'];
        }
        $postParam['Easycase']['due_date'] = ($formdata['CS_due_date'] == "No Due Date") ? null : $formdata['CS_due_date'];
        
        $postParam['Easycase']['postdata'] = $formdata['postdata'];

        if (!$estimated_hours && !empty($postParam['Easycase']['due_date']) && !empty($postParam['Easycase']['gantt_start_date'])) {
            $estimated_hours = strtotime($postParam['Easycase']['due_date']) - strtotime($postParam['Easycase']['gantt_start_date']);
            $estimated_hours = ceil($estimated_hours/86400); //get no of day's
            if ($this->Format->isResourceAvailabilityOn()) {
                $days = 0;
                for ($i=0;$i<=$estimated_hours;$i++) {
                    $arr = explode(',', $GLOBALS['company_week_ends']);
                    $arr2 = explode(',', $GLOBALS['company_holiday']);
                    $wkd = date('w', strtotime($postParam['Easycase']['gantt_start_date']. "+".$i." days"));
                    $wkdy = date('Y-m-d', strtotime($postParam['Easycase']['gantt_start_date']. "+".$i." days"));
                    
                    if (!in_array($wkd, $arr) && !in_array($wkdy, $arr2)) {
                        $days++;
                    }
                }
                $estimated_hours =  $days -1; //adjust one day which is missing by substraction logic
                $estimated_hours = ($estimated_hours >= 0)?$estimated_hours:0;
            }
            $estimated_hours *= $GLOBALS['company_work_hour'];
            $estimated_hours += $GLOBALS['company_work_hour']; //adjust one day which is missing by substraction logic
            $estimated_hours *= 3600;
        }
        $postParam['Easycase']['estimated_hours'] = $estimated_hours;
        $milestone_id = 'na';
        if (isset($formdata['CS_milestone']) && trim($formdata['CS_milestone']) != '') { //&& $formdata['CS_milestone']
            $milestone_id = $formdata['CS_milestone'];
        }
        if (isset($formdata['CS_id']) && $formdata['CS_id']) {
            $caseid = $formdata['CS_id'];
        }
        if (isset($formdata['CS_case_no']) && $formdata['CS_case_no']) {
            $postParam['Easycase']['case_no'] = $formdata['CS_case_no'];
        }
        $emailUser = $formdata['emailUser'];
        $allUser = $formdata['allUser'];
        $fileArray = $formdata['allFiles'];
        $domain = isset($formdata['auth_domain']) ? $formdata['auth_domain'] : HTTP_ROOT;

        $cloud_storages = $formdata['cloud_storages']; //By Sunil

        $success = "fail";
        $emailTitle = "";
        $Easycase->recursive = -1;
        $update = 0;
        ######## Check File Exists and Size
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
        ###### Get Ptoject Id
        if ($formdata['CS_project_id'] != "all") {
            $Project = ClassRegistry::init('Project');
            $Project->recursive = -1;
            $prjArr = $Project->find('first', array('conditions' => array('Project.uniq_id' => $formdata['CS_project_id']), 'fields' => array('Project.id', 'Project.name')));
            $projId = $prjArr['Project']['id'];
            //$projName = urlencode($prjArr['Project']['name']);
            $projName = $prjArr['Project']['name'];
        } else {
            $projId = $formdata['pid'];
            $projName = 'All';
        }

        ####### Case Format
        if (isset($cloud_storages) && !empty($cloud_storages)) { //By Sunil
            $postParam['Easycase']['format'] = 1;
            $format = 1;
        } else {
            if (!$fromMobile) {
                if (!$formdata['task_uid']) {
                    if ($chk == 0) {
                        $postParam['Easycase']['format'] = 2;
                        $format = 2;
                    } else {
                        $postParam['Easycase']['format'] = 1;
                        $format = 1;
                    }
                } elseif ($chk != 0) {
                    $postParam['Easycase']['format'] = 1;
                    $format = 1;
                } elseif ($chk == 0) {
                    $postParam['Easycase']['format'] = 2;
                    $format = 2;
                }
            }
        }
        //To avoid default setting and fix the attachment icon issue
        if ($fromMobile && !$formdata['task_uid'] && !$formdata['CS_id']) {
            $postParam['Easycase']['format'] = 2;
            $format = 2;
        }
        //$emailTitle = $this->Format->convert_ascii($postParam['Easycase']['title']);
        $emailTitle = $postParam['Easycase']['title'];
        $caseIstype = $postParam['Easycase']['istype'];

        if ($caseIstype == 1) {
            ####### Case Type (if not selected it is "2", if type is update priority is NULL)
            if ($postParam['Easycase']['type_id'] == 10) {
                $postParam['Easycase']['priority'] = null;
            }
            $casePriority = $postParam['Easycase']['priority'];
            $caseTypeId = $postParam['Easycase']['type_id'];

            ####### Case Message (can be NULL)
            if ($postParam['Easycase']['message'] == "Enter Description...") {
                $postParam['Easycase']['message'] = "";
            }
            ####### Start Date (can be NULL, change Date format). As only date is passed while task create/update. it is appending user time
            if (isset($postParam['Easycase']['gantt_start_date']) && (!isset($formdata['CM']) || $formdata['CM'] != 'CREATETASK')) {
                $gantt_start_date = $postParam['Easycase']['gantt_start_date'];
                $time = $time != "" ? $time : $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "onlytime");
                $start_date = date('Y-m-d', strtotime($gantt_start_date)) . " " . $time;
                #$minutes = str_pad(floor((date('i', strtotime($start_date)) > 0 ? date('i', strtotime($start_date)) : 1) / 30) * 30, 2, 0);
                #$start_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H', strtotime($start_date)) . ':' . $minutes . ':00'));
                /* converting to UTC */
                $start_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $start_date, "datetime");

                $postParam['Easycase']['gantt_start_date'] = $start_date;
            }
            ####### Due Date (can be NULL, change Date format)
            if ($postParam['Easycase']['due_date']) {
                $duedt = $postParam['Easycase']['due_date'];
                $time = $time != "" ? $time : $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "onlytime");
                $due_date = date('Y-m-d', strtotime($duedt)) . " " . $time;
                #$minutes = str_pad(floor((date('i', strtotime($due_date)) > 0 ? date('i', strtotime($due_date)) : 1) / 30) * 30, 2, 0);
                #$due_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H', strtotime($due_date)) . ':' . $minutes . ':00'));
                /* converting to UTC */
                $due_date = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $due_date, "datetime");

                $postParam['Easycase']['due_date'] = date("Y-m-d H:i:s", strtotime($due_date.' +1 second'));
            #$postParam['Easycase']['due_date'] = $due_date;
                #$postParam['Easycase']['due_date'] = date("Y-m-d", strtotime($postParam['Easycase']['due_date']));
            } else {
                $postParam['Easycase']['due_date'] = null;
            }

            $postParam['Easycase']['status'] = 1;
            $postParam['Easycase']['legend'] = $custom_legend;

            ###### Get Case#
            if ($formdata['task_uid'] && $formdata['taskid']) {
                $emailbody = "Updated a task: ";
                $userCaseView = 1;
                $csType = "New";
                $caseNoArr = $Easycase->findByUniqId($formdata['task_uid'], array('Easycase.*'), array('Easycase.id' => 'asc'));
                $easy_id = $caseNoArr['Easycase']['id'];

                $caseNo = $caseNoArr['Easycase']['case_no'];
                $postParam['Easycase']['case_count'] = ($caseNoArr['Easycase']['case_count'] + 1);
                unset($caseNoArr['Easycase']['id']);
                unset($caseNoArr['Easycase']['parent_task_id']);
                $caseNoArr['Easycase']['legend'] = 6;
                $caseNoArr['Easycase']['user_id']=SES_ID;
                $caseNoArr['Easycase']['hours'] = 0;
                $caseNoArr['Easycase']['estimated_hours'] = 0;
                $caseNoArr['Easycase']['istype'] = 2;
                $caseNoArr['Easycase']['dt_created'] = GMT_DATETIME;
                $caseNoArr['Easycase']['actual_dt_created'] = GMT_DATETIME;
                $Easycase->save($caseNoArr);

                //Update updated_by in parent task
                $Easycase->id = $easy_id;
                $Easycase->saveField('updated_by', SES_ID);
                $Easycase->id = '';
            } else {
                if ($update == 0) {
                    $caseNoArr = $Easycase->find('first', array('conditions' => array('Easycase.project_id' => $projId), 'fields' => array('MAX(Easycase.case_no) as caseno')));
                    $caseNo = $caseNoArr[0]['caseno'] + 1;
                    $postParam['Easycase']['case_no'] = $caseNo;
                } else {
                    $caseNo = $postParam['Easycase']['case_no'];
                }
                ##### Status & Email Settings
                $postParam['Easycase']['status'] = 1;
                $postParam['Easycase']['legend'] = $custom_legend;
                if ($custom_legend_name != '') {
                    $msg = "<font color='#737373'><b>".__("Status").": </b></font><font color='#".$custom_legend_clr."'>".$custom_legend_name."</font>";
                } else {
                    $msg = "<font color='#737373'><b>".__("Status").": </b></font><font color='#763532'>".__("NEW")."</font>";
                }
                if ($update == 0) {
                    $userCaseView = 1;
                    $csType = "New";
                    $emailbody = __("posted a new Task");
                }
                if ($postParam['Easycase']['type_id'] == 10) {
                    $msg = "";
                }
            }
        } else {
            $postParam['Easycase']['title'] = "";
            $caseTypeId = $postParam['Easycase']['type_id'];
            $casePriority = $postParam['Easycase']['priority'];
            $caseNo = $postParam['Easycase']['case_no'];

            ##### Status
            if ($postParam['Easycase']['legend'] == "") {
            } else {
                $getTitle = $Easycase->query("SELECT id,uniq_id,title,legend,isactive,case_no,type_id,custom_status_id,completed_task,user_id FROM easycases WHERE id='" . $caseid . "'");
                if ($formdata['depend'] != "Yes") {
                    $postParam['Easycase']['legend'] = $getTitle[0]['easycases']['legend'];
                    $postParam['Easycase']['custom_status_id'] = $getTitle[0]['easycases']['custom_status_id'];
                }
                if ($postParam['Easycase']['legend'] == 3) {
                    $postParam['Easycase']['status'] = 2;
                    $status = 2;
                } else {
                    $postParam['Easycase']['status'] = 1;
                    $status = 1;
                }

                $postParam['Easycase']['legend'] = $postParam['Easycase']['legend'];
                $legend = $postParam['Easycase']['legend'];
                $userCaseView = $postParam['Easycase']['legend'];

                $getTitle = $Easycase->query("SELECT id,uniq_id,title,legend,isactive,case_no,type_id,custom_status_id,completed_task,user_id FROM easycases WHERE id='" . $caseid . "'");
                $getTitle_dtl = $getTitle;
                ##### Email Settings
                if ($postParam['Easycase']['legend'] == 3) {
                    if ($custom_legend_name != '') {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='".$custom_legend_clr."'>".$custom_legend_name."</font>";
                    } else {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='green'>".__("CLOSED")."</font>";
                    }
                    $csType = "Close";
                    if ($getTitle[0]['easycases']['legend'] == trim($postParam['Easycase']['legend'])) {
                        $emailbody = __("responded on the Task");
                    } else {
                        if ($custom_legend_name != '') {
                            $emailbody = "<font color='#".$custom_legend_clr."'>".$custom_legend_name."</font> ".__("the Task");
                        } else {
                            $emailbody = "<font color='green'>".__("CLOSED")."</font> ".__("the Task");
                        }
                    }
                }
                if ($postParam['Easycase']['legend'] == 1) {
                    $userCaseView = 2;
                    $csType = "Replied";
                    if ($custom_legend_name != '') {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#".$custom_legend_clr."' >".$custom_legend_name."</font>";
                    } else {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#EF6807' >".__("REPLIED")."</font>";
                    }
                    $emailbody = __("responded on the Task");
                }
                if ($postParam['Easycase']['legend'] == 2) {
                    $csType = "WIP";
                    if ($custom_legend_name != '') {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#".$custom_legend_clr."'>".$custom_legend_name."</font>";
                    } else {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#EF6807'>".__("In Progress")."</font>";
                    }
                    $emailbody = __("responded on the Task");
                }
                if ($postParam['Easycase']['legend'] == 5) {
                    $csType = "Resolved";
                    if ($custom_legend_name != '') {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#".$custom_legend_clr."'>".$custom_legend_name."</font>";
                    } else {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#EF6807'>".__("RESOLVED")."</font>";
                    }
                    if ($getTitle[0]['easycases']['legend'] == trim($postParam['Easycase']['legend'])) {
                        $emailbody = __("responded on the Task");
                    } else {
                        if ($custom_legend_name != '') {
                            $emailbody = "<font color='#".$custom_legend_clr."'>".$custom_legend_name."</font> ".__("the Task");
                        } else {
                            $emailbody = "<font color='#EF6807'>".__("RESOLVED")."</font> ".__("the Task");
                        }
                    }
                }
                if ($postParam['Easycase']['legend'] == 4) {
                    $csType = "Started";
                    if ($custom_legend_name != '') {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#".$custom_legend_clr."'>".$custom_legend_name."</font>";
                    } else {
                        $msg = "<font color='#737373' style='font-weight:bold'>".__("Status").":</font> <font color='#55A0C7'>".__("STARTED")."</font>";
                    }
                    if ($custom_legend_name != '') {
                        $emailbody = "<font color='#".$custom_legend_clr."'>".$custom_legend_name."</font> ".__("the Task");
                    } else {
                        $emailbody = "<font color='#55A0C7'>".__("STARTED")."</font> ".__("the Task");
                    }
                }
            }
            #### Update the status and legend of original case
            $dtcreated = GMT_DATETIME;
            $updquery = "";
            if ($postParam['Easycase']['assign_to'] != '') {
                $updquery = ",assign_to='" . $postParam['Easycase']['assign_to'] . "'";
            }
            $updquery .= ",priority='" . $postParam['Easycase']['priority'] . "'";
            $qryFrmt = "";
            if ($format == 1) {
                $qryFrmt = "format='" . $format . "',";
            }

            if ($formdata['depend'] == "Yes") {
                $legend_stat = "legend='" . $legend . "', custom_status_id='" . $postParam['Easycase']['custom_status_id'] . "', ";
                $getTitle_dtl[0]['easycases']['legend'] = $legend;
                $getTitle_dtl[0]['easycases']['custom_status_id'] = $postParam['Easycase']['custom_status_id'];
            } else {
                $legend_stat = "";
            }
            $Easycase->query("UPDATE easycases SET status='" . $status . "',updated_by='" . SES_ID . "',case_count=case_count+1, " . $legend_stat . $qryFrmt . " dt_created='" . $dtcreated . "' " . $updquery . " WHERE id='" . $caseid . "'");
            $Easycase->updateEcThreadCount($formdata);

            //$emailTitle = $this->Format->convert_ascii($getTitle[0]['easycases']['title']);
            $emailTitle = $getTitle[0]['easycases']['title'];
        }
        $emailMsg = $postParam['Easycase']['message'];

        if ($update == 0 && !$formdata['task_uid']) {
            $caseUniqId = md5(uniqid(mt_rand()) . time());
            $postParam['Easycase']['uniq_id'] = $caseUniqId;
            $postParam['Easycase']['actual_dt_created'] = GMT_DATETIME;
            $postParam['Easycase']['isactive'] = 1;
            if (isset($formdata['CS_user_id']) && $formdata['CS_user_id']) {
                $postParam['Easycase']['user_id'] = $formdata['CS_user_id']; //it is used when reading from mail
            } else {
                $postParam['Easycase']['user_id'] = SES_ID;
            }
            $postParam['Easycase']['user_short_name'] = "";
            $postParam['Easycase']['assign_short_name'] = "";
        } elseif ($formdata['task_uid']) {
            $caseUniqId = $formdata['task_uid'];
            $postParam['Easycase']['id'] = $formdata['taskid'];
            $postParam['Easycase']['uniq_id'] = $formdata['task_uid'];
        } else {
            $caseUniqId = $postParam['Easycase']['uniq_id'];
        }
        $postParam['Easycase']['dt_created'] = GMT_DATETIME;
        $postParam['Easycase']['project_id'] = $projId;

        #$postParam['Easycase']['title'] = $this->Format->convert_ascii(trim($postParam['Easycase']['title']));
        #$postParam['Easycase']['message'] = $this->Format->convert_ascii(trim($postParam['Easycase']['message']));

        if (empty($postParam['Easycase']['estimated_hours'])) {
            $postParam['Easycase']['estimated_hours'] = 0;
        }
        if (empty($postParam['Easycase']['client_status'])) {
            $postParam['Easycase']['client_status'] = 0;
        }
        if ((isset($formdata['taskid']) && $formdata['taskid']) && (isset($formdata['CS_id']) && $formdata['CS_id'] == 0)) {
            unset($postParam['Easycase']['legend']);
            unset($postParam['Easycase']['custom_status_id']);
        }
        if ($formdata['CS_recurring_startDate'] != '') {
            $postParam['Easycase']['due_date'] = date('Y-m-d', strtotime($formdata['CS_recurring_startDate']));
        }
        $availableFlag = false;
        if ($formdata['taskid'] != 0) {
            /*
            * Recursive data and conditions for the resource availability functionatliy.
            */
            $recurdata = $Easycase->find('first', array('conditions' => array('Easycase.id' => $formdata['taskid']), 'fields' => array('Easycase.is_recurring,Easycase.assign_to,Easycase.estimated_hours,Easycase.gantt_start_date,Easycase.due_date')));
            #$postParam['Easycase']['is_recurring'] = $recurdata['Easycase']['is_recurring'];
            //Check resource availability change for edit task functionaltiy
//            print_r($recurdata);
//            print '#####################';
//            print_r($postParam);exit;
            if ($recurdata['Easycase']['assign_to'] != $postParam['Easycase']['assign_to'] ||
                $recurdata['Easycase']['estimated_hours'] != $postParam['Easycase']['estimated_hours'] ||
                date('Y-m-d', strtotime($recurdata['Easycase']['gantt_start_date'])) != date('Y-m-d', strtotime($postParam['Easycase']['gantt_start_date'])) ||
                date('Y-m-d', strtotime($recurdata['Easycase']['due_date'])) != date('Y-m-d', strtotime($postParam['Easycase']['due_date']))
                ) {
                $availableFlag=true;
            }
        }
        $postParam['Easycase']['message'] = str_replace('\\', '&#92;', $postParam['Easycase']['message']); // keep the "\" as it is.
        if ($Easycase->saveAll($postParam)) {
            if (!empty($checkList) && !empty($checkListSts) && $caseIstype == 1) {
                //add update checklist here
                $CheckListMod = ClassRegistry::init('CheckList');
                $chEsdata = $postParam;
                if (!isset($chEsdata['Easycase']['id']) || empty($chEsdata['Easycase']['id'])) {
                    $chEsdata['Easycase']['id'] = $Easycase->getLastInsertID();
                }
                $CheckListMod->updateChecklist($chEsdata, $checkList, $checkListSts, SES_ID, SES_COMP);
            }
            $EasycaseMention = ClassRegistry::init('EasycaseMention');
            if (!empty($mention_array)) {
                if (!empty($mention_array['mention_type_id']) && !empty($mention_array['mention_type'])) {
                    $mtask_id = ($formdata['taskid']) ? $formdata['taskid'] : $Easycase->getLastInsertID();
      
                    $mcomment_id = 0;
                    $is_save_mention = 0;
                    if ($formdata['CS_id']) {
                        $mtask_id = $formdata['CS_id'];
                        $mcomment_id = $Easycase->getLastInsertID();
                    }
                    if (!empty($mention_array['mention_id'])) {
                        $easycaseMentionList = $EasycaseMention->find('list', array('conditions'=>array('easycase_id'=>$mtask_id,'comment_id'=>0),'fields'=>array('id')));
                        foreach ($easycaseMentionList as $kmm =>$vmm) {
                            foreach ($mention_array['mention_id'] as $kmt =>$vmt) {
                                if ($vmn == $vmt) {
                                    $is_save_mention = 1;
                                } else {
                                    $is_save_mention = 0;
                                    $EasycaseMention->delete($vmm);
                                }
                            }
                        }
                    } else {
                        // $easycaseMentionList = $EasycaseMention->find('list',array('conditions'=>array('easycase_id'=>$mtask_id,'comment_id'=>0),'fields'=>array('id')));
                    }
                }
            }
            $Project = ClassRegistry::init('Project');
            $ProjectUser = ClassRegistry::init('ProjectUser');
            $ProjectUser->recursive = -1;

            $getUser = $ProjectUser->query("SELECT user_id FROM project_users WHERE project_id='" . $projId . "'");
            $prjuniq = $Project->query("SELECT uniq_id, short_name FROM projects WHERE id='" . $projId . "'");
            $prjuniqid = $prjuniq[0]['projects']['uniq_id']; //print_r($prjuniq);
            $projShName = strtoupper($prjuniq[0]['projects']['short_name']);

            if (isset($postParam['Easycase']['assign_to']) && !empty($postParam['Easycase']['assign_to'])) {
                //$Project->query("UPDATE projects SET default_assign='".$postParam['Easycase']['assign_to']."' WHERE id='".$projId."'");
            }
            $iotoserver = array();
            if ($caseIstype == 2) { //if($postParam['Easycase']['message'] != '' && $caseIstype == 2)
                //socket.io implement start
                $channel_name = $prjuniqid;

                $pname = $this->Format->getProjectName($projId);
                $msgpub = "'Case Replay Available in '" . $postParam['Easycase']['title'] . "''";

                if (!stristr(HTTP_ROOT, 'orangegigs.com') && !stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'orangegigs.com')) {
                    $iotoserver = array('channel' => $channel_name, 'message' => 'Updated.~~' . SES_ID . '~~' . $postParam['Easycase']['case_no'] . '~~' . 'UPD' . '~~' . $emailTitle . '~~' . $projShName);
                    //$this->iotoserver(array('channel' => $channel_name, 'message' => 'Updated.~~' . SES_ID . '~~' . $postParam['Easycase']['case_no'] . '~~' . 'UPD' . '~~' . $emailTitle . '~~' . $projShName));
                }

                //socket.io implement end
            } else {
                //socket.io implement start
                $channel_name = $prjuniqid;
                $pname = $this->Format->getProjectName($projId);
                $msgpub = "'New Case Available in " . $pname . "'";

                if (SES_ID && (!stristr(HTTP_ROOT, 'orangegigs.com') && !stristr(HTTP_ROOT, 'payzilla.in') && !stristr(HTTP_ROOT, 'orangegigs.com'))) {
                    $iotoserver =array('channel' => $channel_name, 'message' => 'Updated.~~' . SES_ID . '~~' . $postParam['Easycase']['case_no'] . '~~' . 'NEW' . '~~' . $postParam['Easycase']['title'] . '~~' . $projShName);
                    //$this->iotoserver(array('channel' => $channel_name, 'message' => 'Updated.~~' . SES_ID . '~~' . $postParam['Easycase']['case_no'] . '~~' . 'NEW' . '~~' . $postParam['Easycase']['title'] . '~~' . $projShName));
                }

                //socket.io implement end
            }
            //return pr($Easycase->getLastInsertID());
            //fwrite($hj,'MILESTONE ID - IS ----'.$milestone_id.'====');

            $EasycaseMilestone = ClassRegistry::init('EasycaseMilestone');
            $EasycaseMilestone->recursive = -1;
            $existing_milestone_id = 0;
            if (!empty($formdata['taskid'])) {
                if ($milestone_id != 'na' && $milestone_id == '') {
                    $milestone_id = 0;
                }
                $milestone_dtls = $EasycaseMilestone->find('first', array('conditions' => array('easycase_id' => $formdata['taskid'], 'project_id' => $projId)));
            }
            if ($milestone_id != 'na' && $milestone_id > 0 && empty($formdata['CS_id'])) {
                if ($formdata['task_uid']) {
                    //$milestone_dtls = $EasycaseMilestone->find('first', array('conditions' => array('easycase_id' => $formdata['taskid'], 'project_id' => $projId)));
                    if ($milestone_dtls) {
                        $EasycaseMiles['id'] = $milestone_dtls['EasycaseMilestone']['id'];
                        $EasycaseMiles['m_order'] = $milestone_dtls['EasycaseMilestone']['m_order'];
                        $existing_milestone_id = $milestone_dtls['EasycaseMilestone']['milestone_id'];
                    }
                    $EasycaseMiles['easycase_id'] = $formdata['taskid'];
                } else {
                    $EasycaseMiles['easycase_id'] = $Easycase->getLastInsertID();
                }
                $milestone_order = $EasycaseMilestone->find('first', array('conditions' => array('milestone_id' => $milestone_id, 'project_id' => $projId)));
                if ($milestone_order) {
                    $EasycaseMiles['m_order'] = $milestone_order['EasycaseMilestone']['m_order'];
                }
                $EasycaseMiles['milestone_id'] = $milestone_id;
                $EasycaseMiles['project_id'] = $projId;
                $EasycaseMiles['user_id'] = SES_ID;
                $EasycaseMiles['dt_created'] = GMT_DATETIME;

                if ($EasycaseMilestone->saveAll($EasycaseMiles)) {
                    if ((($existing_milestone_id==0 && $milestone_id) || ($existing_milestone_id!=0 && !$milestone_id) || ($existing_milestone_id!=0 && $milestone_id != 0 && $existing_milestone_id !=$milestone_id)) && !empty($formdata['taskid'])) {
                        $child_tasks = $Easycase->getSubTaskChild($formdata['taskid'], $projId);
                        if (!empty($child_tasks['data'])) {
                            $new_Mils = null;
                            foreach ($child_tasks['data'] as $case) {
                                if ($existing_milestone_id == 0) {
                                    if ($milestone_order) {
                                        $new_Mils['m_order'] = $milestone_order['EasycaseMilestone']['m_order'];
                                    }
                                    $new_Mils['easycase_id'] = $case['Easycase']['id'];
                                    $new_Mils['milestone_id'] = $milestone_id;
                                    $new_Mils['project_id'] = $projId;
                                    $new_Mils['user_id'] = SES_ID;
                                    $new_Mils['dt_created'] = GMT_DATETIME;
                                    $EasycaseMilestone->saveAll($new_Mils);
                                } else {
                                    $mssctIds = Hash::extract($child_tasks['data'], '{n}.Easycase.id');
                                    $EasycaseMilestone->updateAll(array('milestone_id' => $milestone_id), array('easycase_id' => $mssctIds, 'project_id' => $projId));
                                }
                            }
                        }
                    }
                }
            } elseif ($milestone_id != 'na' && $milestone_id == 0 && !empty($formdata['taskid'])) {
                $EasycaseMilestone->deleteAll(array('easycase_id' => $formdata['taskid'], 'project_id' => $projId));
                $child_tasks = $Easycase->getSubTaskChild($formdata['taskid'], $projId);
                if (!empty($child_tasks['data'])) {
                    $mssctIds = Hash::extract($child_tasks['data'], '{n}.Easycase.id');
                    $EasycaseMilestone->deleteAll(array('easycase_id' => $mssctIds, 'project_id' => $projId));
                }
            }
            //fclose($hj);
            if ($update == 0) {
                if ($formdata['task_uid']) {
                    $caseid = $formdata['taskid'];
                } else {
                    $caseid = $Easycase->getLastInsertID();
                }
            }
            if ($caseIstype == 1 || $caseIstype == 2) {
                $ProjectUser = ClassRegistry::init('ProjectUser');
                $ProjectUser->recursive = -1;

                if (isset($formdata['CS_user_id']) && $formdata['CS_user_id']) {
                    $puser_id = $formdata['CS_user_id'];
                } else {
                    $puser_id = SES_ID;
                }
                $ProjectUser->query("UPDATE project_users SET dt_visited='" . GMT_DATETIME . "' WHERE project_id=" . $projId . " AND user_id=" . $puser_id);
            }

            //By Sunil
            if (isset($cloud_storages) && !empty($cloud_storages)) {
                $this->fileInfo($cloud_storages, $projId, $caseid);
            }

            $isUserModule = 0;

            if ($update == 1 || $formdata['task_uid']) {
                $CaseUserEmail = ClassRegistry::init('CaseUserEmail');
                $CaseUserEmail->query("DELETE FROM case_user_emails WHERE easycase_id=" . $caseid);
            }

            $caUid = "";
            $assignTo = "";
            if ($postParam['Easycase']['assign_to']) {
                $caUid = $postParam['Easycase']['assign_to'];
            }

            $due_date = "";
            $padd = "";
            if ($postParam['Easycase']['due_date']) {
                $due_date = $postParam['Easycase']['due_date'];
            }
            if ($caUid && $caUid != SES_ID) {
                if ($isUserModule == 0) {
                    $User = ClassRegistry::init('User');
                    $User->recursive = -1;
                }
                $usrDtls2 = $User->find('first', array('conditions' => array('User.id' => $caUid, 'User.isactive' => 1), 'fields' => array('User.name')));
                if (count($usrDtls2) && $usrDtls2['User']['name']) {
                    $assignTo = "<tr><td align='left' style='color:#235889;line-height:20px;padding-top:10px'>This task is assigned to <i>" . $usrDtls2['User']['name'] . "</i></td></tr>";
                }
            }
            if ($due_date != "NULL" && $due_date != "0000-00-00 00:00:00" && $due_date != "") {
                if (!$assignTo) {
                    $padd = "padding-top:10px;";
                }
                $assignTo.= "<tr><td align='left' style='" . $padd . "'>Due date: <font color='#235889'>" . date("m/d/Y", strtotime($due_date)) . "</font></td></tr>";
            }
            $allfiles = array('allfiles' => '', 'storage' => '', 'file_error' => '');
            if (is_array($fileArray) && count($fileArray)) {
                $editRemovedFile = $formdata['editRemovedFile'];
                if ($editRemovedFile && $formdata['taskid']) {
                    $this->removeFiles($editRemovedFile, $formdata['taskid'], 1);
                }
                $allfiles = $this->uploadAndInsertFile($fileArray, $caseid, 0, $projId, $domain, $editRemovedFile);
                if ($fileArray && $formdata['taskid']) {
                    $Easycase->updateAll(array('format' => 1), array('id' => $formdata['taskid'], 'project_id' => $projId,'istype' => 1));
                }
            }
            $isAssignedUserFree = 1;
            $is_resourceon = $this->Format->isResourceAvailabilityOn();
            if ($formdata['CS_id'] != 0 && $formdata['taskid'] == 0 && $postParam['Easycase']['legend'] == 3) {
                //if(!empty($caseUniqId)){
                $child_tasks = $Easycase->getSubTaskChild($formdata['CS_id'], $projId);
                //closing parent task
                //$response = $this->Easycase->actionOntask($formdata['CS_id'], $caseUniqId, 'close');
                //closing children tasks
                if (!empty($child_tasks['data'])) {
                    //$response['checkParentids'] = array($postdata['taskId']);
                    foreach ($child_tasks['data'] as $case) {
                        if ($case['Easycase']['legend'] != '3') {
                            $allowed = $this->Format->task_dependency($case['Easycase']['id']);
                            if ($allowed != 'No') {
                                $Easycase->actionOntask($case['Easycase']['id'], $case['Easycase']['uniq_id'], 'close');
                                if ($is_resourceon) {
                                    $this->Format->delete_booked_hours(array('easycase_id' => $case['Easycase']['id'], 'project_id' => $projId));
                                }
                            }
                        }
                    }
                }
                //}
            }
            if ($is_resourceon) {
                /**
                 * Check resource availability
                 */
            
            if ($estimated_hours != '' && !empty($postParam['Easycase']['gantt_start_date']) && $postParam['Easycase']['assign_to'] != 0) {
                    if ($formdata['task_uid'] && $formdata['taskid']) {
                        if ($availableFlag) {
									//Added
									$easycase_details = $Easycase->find('first',array('conditions'=>array('id'=>$formdata['taskid'],'project_id'=>$postParam['Easycase']['project_id'],'istype'=>1)));									
                        $this->Format->delete_booked_hours(array('easycase_id' => $formdata['taskid'], 'project_id' => $postParam['Easycase']['project_id']),1);
                            $data_avl = false;
                            $postParam['Easycase']['company_work_hour'] = $GLOBALS['company_work_hour'];
									//Added
									$postParam['Easycase']['legend'] = $easycase_details['Easycase']['legend'];
                            if ($postParam['Easycase']['legend'] != 3  && $postParam['Easycase']['assign_to'] != 0) {
                                $isAssignedUserFree = $this->setBookedData($postParam, $estimated_hours, $formdata['taskid'], SES_COMP);
                            }
                        }
                    } else {
                        $data_avl = false;
                        $taskId = isset($formdata['taskid']) && $formdata['taskid'] != '' && $formdata['taskid'] != 0 ? $formdata['taskid'] : $Easycase->getLastInsertID();
                        $postParam['Easycase']['company_work_hour'] = $formdata['company_work_hour'];
                        $isAssignedUserFree = $this->setBookedData($postParam, $estimated_hours, $taskId, SES_COMP);
                    }
                }
            //commented due to on comment post time it check resource availability
                if ($postParam['Easycase']['istype'] == 2) {
                    $easycase_details = $Easycase->find('first', array('conditions'=>array('case_no'=>$postParam['Easycase']['case_no'],'project_id'=>$postParam['Easycase']['project_id'],'istype'=>1)));
							if($easycase_details['Easycase']['estimated_hours'] != '' && $easycase_details['Easycase']['gantt_start_date'] != '' && ($postParam['Easycase']['assign_to'] != $easycase_details['Easycase']['assign_to'])){
                    $this->Format->delete_booked_hours(array('easycase_id' => $easycase_details['Easycase']['id'], 'project_id' => $easycase_details['Easycase']['project_id']),1);
               
                        $data_avl = false;
                        $taskIds = isset($formdata['taskid']) && $formdata['taskid'] != '' && $formdata['taskid'] != 0 ? $formdata['taskid'] : $easycase_details['Easycase']['id'];
                        if ($postParam['Easycase']['legend'] != 3  && $postParam['Easycase']['assign_to'] != 0) {
                            $isAssignedUserFree = $this->setBookedData($easycase_details, $easycase_details['Easycase']['estimated_hours'], $taskIds, SES_COMP);
                        }
                    }
							//$isAssignedUserFree = 1;//due to on comment post time it check resource availability
                }
            // pr($isAssignedUserFree);exit;
                /*
                 * End resource avalibility
                 */
            }
            if (empty($gitissue)) {
                ##########################################
                ####Check and update the google calendar##
                ##########################################
                if (!isset($formdata['fromGoogleCal']) && !isset($formdata['from_email'])) {
                    if (
                        (!isset($formdata['CS_id']) || empty($formdata['CS_id']))
                        &&
                        (!isset($formdata['taskid']) || empty($formdata['taskid']))
                    ) {
                        $cal_id = $this->Format->createGoogleCalendarEvent($Easycase->getLastInsertID(), $postParam['Easycase'], 'create');
                    } elseif (isset($formdata['taskid']) && !empty($formdata['taskid'])) {
                        $cal_id = $this->Format->createGoogleCalendarEvent($formdata['taskid'], $postParam['Easycase'], 'edit');
                    }
                }
                #############################
            #############################
            }
            if (isset($formdata['relates_to'])  && !empty($formdata['relates_to']) &&  isset($formdata['link_task']) && !empty($formdata['link_task']) && $formdata['CS_id'] == 0) {
                $rtask_id = ($formdata['taskid']) ? $formdata['taskid'] : $Easycase->getLastInsertID();
                $EasycaseLinking = ClassRegistry::init('EasycaseLinking');
                $link_task = $formdata['link_task'];
                $eLink = array();
                foreach ($link_task as $k=>$v) {
                    $arrl = array();
                    $arrl['easycase_id'] =  $rtask_id;
                    $arrl['company_id'] =  SES_COMP;
                    $arrl['project_id'] =  $postParam['Easycase']['project_id'];
                    $arrl['link_id'] =  $v;
                    $arrl['easycase_relate_id'] =  $formdata['relates_to'];
                    $eLink[] = $arrl;
                }
                $EasycaseLinking->saveAll($eLink);
            }
            $rtask_id = ($formdata['taskid']) ? $formdata['taskid'] : $Easycase->getLastInsertID();
            ############################
            # && $formdata['CS_id'] == 0 && $formdata['taskid'] == 0
            if ($postParam['Easycase']['is_recurring'] == 1) {
                $recurringEasycase = ClassRegistry::init('RecurringEasycase');
                
                $rRule = $this->Format->getRRule($formdata['recurringData'], 'test');
                $rRuleDetails = $rRule->getRule();
                $recurringEasycase->query("DELETE FROM `recurring_easycases` WHERE id='".$formdata['recurringData']['editRecurId']."' AND easycase_id='".$formdata['recurringData']['editEasycaseId']."' AND project_id='".$formdata['recurringData']['editRecurProjId']."'");
                
                
                if ($formdata['task_uid'] && $formdata['taskid']) {
                    $easycase_id_val = $formdata['taskid'];
                } else {
                    $easycase_id_val = $Easycase->getLastInsertID();
                }
                $recurringTask = array(
                    'easycase_id' => $easycase_id_val,
                    'project_id' => $postParam['Easycase']['project_id'],
                    'company_id' => SES_COMP,
                    'frequency' => $rRuleDetails['FREQ'],
                    'rec_interval' => $rRuleDetails['INTERVAL'],
                    'bymonthday' => $rRuleDetails['BYMONTHDAY'],
                    'byday' => $rRuleDetails['BYDAY'],
                    'byweekno' => $rRuleDetails['BYWEEKNO'],
                    'bymonth' => $rRuleDetails['BYMONTH'],
                    'start_date' => $rRuleDetails['DTSTART'],
                    'occurrences' => $formdata['recurringData']['recurrence_end_type'] != 'no' ? $rRuleDetails['COUNT'] : '',
                    'end_date' => $formdata['recurringData']['recurrence_end_type'] != 'no' ? $rRuleDetails['UNTIL'] : '',
                );
                $recurringEasycase->save($recurringTask);
            } elseif ($postParam['Easycase']['is_recurring'] == 0) { //Delete the record from the recurring table if recurring is stopped.
                $recurringEasycase = ClassRegistry::init('RecurringEasycase');
                $recurringEasycase->query("DELETE FROM `recurring_easycases` WHERE easycase_id='".$formdata['taskid']."' AND project_id='".$projId."'");
            }
            $this->write('STATUS', "", '-365 days');
            $this->write('PRIORITY', "", '-365 days');
            $this->write('CS_TYPES', "", '-365 days');
            $this->write('MEMBERS', "", '-365 days');
            $this->write('COMMENTS', "", '-365 days');
            $this->write('IS_SORT', "", '-365 days');
            $this->write('ORD_DATE', "", '-365 days');
            $this->write('ORD_TITLE', "", '-365 days');
            $this->write('SEARCH', "", '-365 days');
            $success = "success";            
        }
        $duedt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $postParam['Easycase']['due_date'], "datetime");
        $ret_res = array('success' => $success, 'pagename' => $pagename, 'formdata' => $formdata['CS_project_id'], 'postParam' => $postParam['Easycase']['postdata'], 'curCaseId' => $caseid, 'caseUniqId' => $caseUniqId, 'format' => $format, 'allfiles' => $allfiles['allfiles'], 'caseNo' => $caseNo, 'emailTitle' => $emailTitle, 'emailMsg' => $emailMsg, 'casePriority' => $casePriority, 'caseTypeId' => $caseTypeId, 'msg' => $msg, 'emailbody' => $emailbody, 'assignTo' => $assignTo, 'name_email' => $name_email, 'csType' => $csType, 'projId' => $projId, 'caseid' => $caseid, 'caUid' => $caUid, 'caseIstype' => $caseIstype, 'projName' => $projName, "storage_used" => $allfiles['storage'], 'file_upload_error' => $allfiles['file_error'],'due_date'=>$duedt,'isAssignedUserFree' => $isAssignedUserFree,'iotoserver'=>$iotoserver,'case_title'=>$formdata['CS_title']);
        if ($getTitle_dtl) {
            $ret_res['csUniqId'] = $getTitle_dtl[0]['easycases']['uniq_id'];
            $ret_res['csAtId'] = $getTitle_dtl[0]['easycases']['id'];
            $ret_res['csTypRep'] = $getTitle_dtl[0]['easycases']['type_id'];
            $ret_res['typetsk_id'] = $getTitle_dtl[0]['easycases']['type_id'];
            $ret_res['csLgndRep'] = $getTitle_dtl[0]['easycases']['legend'];
            $ret_res['is_active'] = $getTitle_dtl[0]['easycases']['isactive'];
            $ret_res['custom_status_id'] = $getTitle_dtl[0]['easycases']['custom_status_id'];
            $ret_res['csNoRep'] = $getTitle_dtl[0]['easycases']['case_no'];
            $ret_res['completedtask'] = $getTitle_dtl[0]['easycases']['completed_task'];
            $ret_res['csUsrDtls'] = $getTitle_dtl[0]['easycases']['user_id'];
            $ret_res['cust_sts_list'] = array();
            if ($getTitle_dtl['0']['easycases']['custom_status_id']) {
                $ret_res['cust_sts_list'] = $this->Format->getCustomTaskStatus($hasCustomStatusGroup);
            }
        }
        if ($ret_res['storage_used'] >= 1) {
            $ret_res['storage_used_gb'] = '';
            if ((strtolower($GLOBALS['Userlimitation']['storage']) == 'unlimited') || ($GLOBALS['Userlimitation']['storage'] >= 1024)) {
                if ($ret_res['storage_used'] >= 1024) {
                    $ret_res['storage_used_gb'] = round($ret_res['storage_used'] / 1024);
                } else {
                    $ret_res['storage_used_gb'] = 0;
                }
            }
        }
        if ($formdata['depend'] != "Yes") {
            if ($old_legend != trim($formdata['CS_legend']) || $old_completed_task != trim($formdata['completed'])) {
                $ret_res['depend_msg'] = 'Your reply is posted. But status, progress and time log cannot be changed as dependant tasks are not closed.';
            }
        }
        if ($postParam['Easycase']['istype'] == 2) {
            $ret_res['reply_strt_date'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $easycase_details['Easycase']['gantt_start_date'], "datetime");
            $ret_res['reply_due_date'] = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $easycase_details['Easycase']['due_date'], "datetime");
            $estimated_hours = $easycase_details['Easycase']['estimated_hours'];
            $ret_res['reply_caseUniqId'] = $easycase_details['Easycase']['uniq_id'];
            $ret_res['reply_caseId'] = $easycase_details['Easycase']['id'];
            $CompanyUser = ClassRegistry::init('CompanyUser');
            $isClient= $CompanyUser->find('first', array('conditions'=>array('CompanyUser.company_id'=>SES_COMP,'CompanyUser.user_id'=>$postParam['Easycase']['assign_to']),'fields'=>array('is_client')));
            if ($isClient['CompanyUser']['is_client'] == 1) {
                $ret_res['isAssignedUserFree'] = 1;
            }
        }
        /*Send Estimated hrs as response */
        $esh = floor($estimated_hours / 3600);
        $esm = floor(($estimated_hours / 60) % 60);
        $ret_res['estimated_hours'] = $esh.":".$esm;
        $ret_res['mention_array'] = $mention_array;
        /*end*/
        return json_encode($ret_res);
    }

    /**
     * This method keeps file's information of google drive and dropbox.
     *
     * @author Sunil
     * @method fileInfo
     * @params array, projectid, easycaseid
     * @return
     */
    public function fileInfo($files, $project_id, $case_id)
    {
        $Case_file = ClassRegistry::init('CaseFile');
        $Case_file->recursive = -1;

        $case_file_drive = ClassRegistry::init('caseFileDrive');
        $case_file_drive->recursive = -1;

        $caseFileDrives['project_id'] = $caseFile['project_id'] = $project_id;
        $caseFileDrives['easycase_id'] = $caseFile['easycase_id'] = $case_id;

        $caseFile['user_id'] = SES_ID;
        $caseFile['company_id'] = SES_COMP;
        $caseFile['isactive'] = 1;

        foreach ($files as $key => $value) {
            $caseFileDrives['file_info'] = $value;
            $file = json_decode($value, true);
            $caseFile['file'] = $file['title'];
            $caseFile['downloadurl'] = $file['alternateLink'];

            $Case_file->saveAll($caseFile);
            $case_file_drive->saveAll($caseFileDrives);
        }
    }

    public function uploadAndInsertFile($files, $caseid, $cmnt, $projId, $domain = HTTP_ROOT)
    {
        $CaseFile = ClassRegistry::init('CaseFile');
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
                    $csFiles['project_id'] = $projId;
                    $csFiles['company_id'] = SES_COMP;
                    $csFiles['easycase_id'] = $caseid;
                    $csFiles['file'] = $original_filename; #$filename;
                    $csFiles['upload_name'] = $filename;
                    $csFiles['thumb'] = $thumb_filename;
                    $csFiles['file_size'] = $sizeinkb;
                    $csFiles['comment_id'] = $cmnt;
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

    public function uploadFile($tmp_name, $name, $file_path)
    {
        if ($name) {
            // Remove all non-ASCII special characters
            $output = preg_replace('/[^(\x20-\x7F)]*/', '', $name);

            $rep1 = str_replace("~", "_", $output);
            $rep2 = str_replace("!", "_", $rep1);
            $rep3 = str_replace("@", "_", $rep2);
            $rep4 = str_replace("#", "_", $rep3);
            $rep5 = str_replace("%", "_", $rep4);
            $rep6 = str_replace("^", "_", $rep5);
            $rep7 = str_replace("&", "_", $rep6);
            $rep11 = str_replace("+", "_", $rep7);
            $rep13 = str_replace("=", "_", $rep11);
            $rep14 = str_replace(":", "_", $rep13);
            $rep15 = str_replace("|", "_", $rep14);
            $rep16 = str_replace("\"", "_", $rep15);
            $rep17 = str_replace("?", "_", $rep16);
            $rep18 = str_replace(",", "_", $rep17);
            $rep19 = str_replace("'", "_", $rep18);
            $rep20 = str_replace("$", "_", $rep19);
            $rep21 = str_replace(";", "_", $rep20);
            $rep22 = str_replace("`", "_", $rep21);
            $rep23 = str_replace(" ", "_", $rep22);
            $rep28 = str_replace("/", "_", $rep23);

            $oldname = $rep28;
            $ext1 = substr(strrchr($oldname, "."), 1);

            $tot = strlen($oldname);
            $extcnt = strlen($ext1);
            $end = $tot - $extcnt - 1;
            $onlyfile = substr($oldname, 0, $end);

            $CaseFile = ClassRegistry::init('CaseFile');
            $CaseFile->recursive = -1;

            $checkFile = $CaseFile->query("SELECT id,count FROM case_files as CaseFile WHERE file='$oldname'");
            if (count($checkFile) >= 1) {
                $newCount = $checkFile['0']['CaseFile']['count'] + 1;

                $newFileName = $onlyfile . "(" . $newCount . ")." . $ext1;
                $updateData = "|" . $checkFile['0']['CaseFile']['id'] . "|" . $newCount;
            } else {
                $newFileName = $oldname;
                $updateData = "";
            }

            $file = $file_path . $newFileName;
            copy($tmp_name, $file);
            return $newFileName . $updateData;
        } else {
            return false;
        }
    }

    public function sendEmail($from, $to, $subject, $message, $type)
    {
        $to = emailText($to);
        $subject = emailText($subject);
        $message = emailText($message);

        $message = str_replace("<script>", "&lt;script&gt;", $message);
        $message = str_replace("</script>", "&lt;/script&gt;", $message);
        $message = str_replace("<SCRIPT>", "&lt;script&gt;", $message);

        $message = str_replace("</SCRIPT>", "&lt;/script&gt;", $message);

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers.= 'From:' . $from . "\r\n";
        mail($to, $subject, $message, $headers);
    }

    public function generateMsgAndSendMail($uid, $allfiles, $hid_caseno, $case_title, $respond, $hid_proj, $hid_priority, $hid_type, $msg, $emailbody, $assignTo, $name_email, $case_uniq_id, $type, $toEmail = null, $toName = null, $domain = HTTP_ROOT)
    {
        App::import('helper', 'Casequery');
        $csQuery = new CasequeryHelper(new View(null));

        App::import('helper', 'Format');
        $frmtHlpr = new FormatHelper(new View(null));
        ##### get User Details
        $to = "";
        $to_name = "";
        if (!$toEmail) {
            $toUsrArr = $csQuery->getUserDtls($uid);
            if (count($toUsrArr)) {
                $to = $toUsrArr['User']['email'];
                $to_name = $frmtHlpr->formatText($toUsrArr['User']['name']);
            }
        } else {
            $to = $toEmail;
            $to_name = $toName;
        }
        ##### get Sender Details
        $senderUsrArr = $csQuery->getUserDtls(SES_ID);
        $by_name = "";
        $by_name = "";
        if (count($senderUsrArr)) {
            $by_email = $senderUsrArr['User']['email'];
            $by_name = $frmtHlpr->formatText($senderUsrArr['User']['name']);
        }
        //$from_name = preg_replace("/[^a-zA-Z0-9]+/", "", $by_name);
        $fromname = $frmtHlpr->formatText(trim($senderUsrArr['User']['name'] . " " . $senderUsrArr['User']['last_name']));

        ##### get Project Details
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $prjArr = $Project->find('first', array('conditions' => array('Project.id' => $hid_proj), 'fields' => array('Project.name', 'Project.short_name', 'Project.uniq_id')));
        $projName = "";
        $case_no = "";
        $projUniqId = "";
        if (count($prjArr)) {
            $projName = $frmtHlpr->formatText($prjArr['Project']['name']);
            $case_no = $frmtHlpr->formatText($prjArr['Project']['short_name']) . "-" . $hid_caseno;
            $projUniqId = $prjArr['Project']['uniq_id'];
        }
        ##### get Case Type
        $cseTyp = "";
        $csTypArr = $csQuery->getType($hid_type);
        if (count($csTypArr)) {
            $cseTyp = $csTypArr['Type']['name'];
        }
        if ($hid_type != 10) {
            $pri = "";
            if ($hid_priority == "NULL" || $hid_priority == "") {
                $pri = "<font  style='color:#AD9227;padding:0;margin:0;height:16px;'>".__("LOW")."</font>";
            } elseif ($hid_priority == 0) {
                $pri = "<font style='color:#AE432E;padding:0;margin:0;height:16px;'>".__("HIGH")."</font>";
            } elseif ($hid_priority == 1) {
                $pri = "<font style='color:#28AF51;padding:0;margin:0;height:16px;'>".__("MEDIUM")."</font>";
            } elseif ($hid_priority >= 2) {
                $pri = "<font style='color:#AD9227;padding:0;margin:0;height:16px;'>".__("LOW")."</font>";
            }
            $priRity = "<font color='#737373'><b>".__("Priority").":</b></font> " . $pri;
        } else {
            $priRity = "";
        }
        $postingName = "";
        if (SES_ID == $uid) {
            $postingName = __("You have");
        } elseif ($by_name) {
            $postingName = $by_name . " ".__("has");
        }
        $from = FROM_EMAIL_EC;
        if ($type == "Resolved") {
            $typ = "-" . strtoupper($type);
        } elseif ($type == "Closed") {
            $typ = "-" . strtoupper($type);
        } elseif ($type == "Started") {
            $typ = "-" . strtoupper($type);
        } else {
            $typ = "";
        }
        $projNameInSh = $projName;
        if (strlen($projNameInSh) > 10) {
            //$projNameInSh = substr($projNameInSh,0,9).'...';
            $projNameInSh = $projNameInSh;
        }
        $shrt = $frmtHlpr->formatText($prjArr['Project']['short_name']);
        if ($shrt) {
            $projShortNcaseNumber = $hid_caseno . "(" . $shrt . ")";
        } else {
            $projShortNcaseNumber = $hid_caseno;
        }
        //$subject = EMAIL_SUBJ . ":" . $projNameInSh . ":#" . $projShortNcaseNumber . "-" . stripslashes(html_entity_decode($case_title, ENT_QUOTES));
        //$subject = $projNameInSh . ":#" . $projShortNcaseNumber . "-" . stripslashes(html_entity_decode($case_title, ENT_QUOTES));
        $subject = $projNameInSh . " - " . stripslashes(html_entity_decode($case_title, ENT_QUOTES, 'UTF-8'));

        $message = "<!doctype html><html><head><style>.custom_span_color span.im {color:#ccc !important;}</style><meta charset='utf-8'></head><div style='font-family:Arial;font-size:14px;color:#787878;margin-bottom:5px;'>".__("Just REPLY to this Email the same will be added under the Task").". <br/><span style='font-size:11px;'><b>".__("NOTE").":</b> ".__("Do not remove this original message").".</span></div>
        <body style='width:100%; margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#ffffff;'>
        <table cellpadding='0' cellspacing='0' border='0' id='backgroundTable' style='height:auto !important; margin:0; padding:0; width:100% !important; background-color:#F0F0F0;color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;'>
        <tr>
        <td>
        <div id='tablewrap' style='width:100% !important; max-width:600px !important; text-align:center; margin:0 auto;'>
        <table id='contenttable' width='600' align='center' cellpadding='0' cellspacing='0' border='0' style='background-color:#FFFFFF; margin:0 auto; text-align:center; border:none; width: 100% !important; max-width:600px !important;border-top:8px solid #3DBB89'>
        <tr>
        <td width='100%'>
        " . NEW_EMAIL_HEADER . "
        <table bgcolor='#FFF' border='0' cellspacing='10' cellpadding='0' width='100%'>
        <tr>
        <td align='left' valign='top' style='line-height:22px;font:14px Arial;'>
        <font color='#737373'><b>".__("Title").": </b></font> <a href='" . $domain . "users/login/?dashboard#details/" . $case_uniq_id . "' target='_blank' style='text-decoration:underline;color:#F86A0C;'>" . stripslashes($case_title) . "</a>
        <br/><br/>
        <font color='#737373'><b>".__("Project").":</b></font> " . $projName . "
        </td>
        </tr>
        <tr>
        <td>
        <table bgcolor='#FFF' border='0' cellspacing='0' cellpadding='0'>
        <tr>
        <td align='left' style='line-height:22px;font:14px Arial'>
        <font color='#737373'><b>".__("Task")."#:</b></font> " . $case_no . "
        </td>
        <td style='padding-left:10px;line-height:22px;font:14px Arial'>
        <font color='#737373'><b>".__("Type").":</b></font> " . $cseTyp . "
        </td>
        </tr>
        <tr style='height:10px;'><td colspan='2'>&nbsp;</td></tr>
        <tr>
        <td align='left' style='line-height:22px;font:14px Arial'>" . $priRity . "</td>
        <td style='padding-left:10px;line-height:22px;font:14px Arial'>" . $msg . "</td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        <table bgcolor='#F0F0F0' border='0' cellspacing='0' cellpadding='10' width='100%' style='border-top:2px solid #F0F0F0;margin-top:5px;text-align:left;'>
        <tr>
        <td width='100%' bgcolor='#ffffff' style='text-align:left;font:14px Arial'>
        <p>
        <font color='#737373'><b>" . $postingName . " " . $emailbody . "</b></font>
        </p>
        <p class='custom_span_color' style='color:gray;'>
        " . htmlspecialchars(stripslashes($respond)) . "
        </p>
        <p>
        " . $allfiles . "
        </p>
        </td>	  
        </tr>
        " . $assignTo . "
        </table>
        <table bgcolor='#F0F0F0' border='0' cellspacing='0' cellpadding='10' width='100%' style='border-top:2px solid #F0F0F0;margin-top:10px;text-align:left;'>
        <tr>
        <td width='100%' bgcolor='#ffffff' style='text-align:left;font:14px Arial'>
        <p style='color:#676767; line-height:20px;'>
        ".__("To read the original message, view comments, reply & download attachment").": <br/> ".__("Link").": <a href='" . $domain . "users/login/dashboard#details/" . $case_uniq_id . "' target='_blank'>" . $domain . "users/login/dashboard#details/" . $case_uniq_id . "/</a>
        </p>
        <p style='color:#676767; padding-top:2px;'>
        ".__("This email notification is sent by")." " . $by_name . " ".__("to")." " . $name_email . "
        </p>

        </td>	  
        </tr>
        </table>
        <table bgcolor='#F0F0F0' border='0' cellspacing='0' cellpadding='10' width='100%' style='border-top:2px solid #F0F0F0;margin-top:5px;border-bottom:3px solid #3DBB89'>
        <tr>
        <td width='100%' bgcolor='#ffffff' style='text-align:center;'>
        <p style='color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;'>
        " . NEW_EMAIL_FOOTER . __("Don't want these emails? To unsubscribe, please contact your account administrator to turn off Email notification for you in the project level").".

        </p>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </div>
        </td>
        </tr>
        </table> 
        </body></html>";
        //return $this->Sendgrid->sendEmail($from,$to,$subject,$message,$type);
        return $this->Sendgrid->sendGridEmail($from, $to, $subject, $message, $type, $fromname);
    }

    ###########################################
    ###### SEND EMAIL TO ASSIGNED USERS #######
    ###########################################

    public function mailToUser($data = array(), $getEmailUser = array(), $type = 0)
    {
        $name_email = "";
        $ids = "";
        $usrArr = array();
        $emailToAssgnTo = 0;
        foreach ($getEmailUser as $usrMem) {
            if (isset($usrMem['User']['name']) && $usrMem['User']['name']) {
                if ($data['is_client'] == 1 && $usrMem['is_client'] != 1) {
                    array_push($usrArr, $usrMem['User']);
                    $name_email.= trim($usrMem['User']['name']) . ", ";
                    if ($data['caUid'] == $usrMem['User']['id']) {
                        $emailToAssgnTo = 1;
                    }
                } else {
                    array_push($usrArr, $usrMem['User']);
                    $name_email.= trim($usrMem['User']['name']) . ", ";
                    if ($data['caUid'] == $usrMem['User']['id']) {
                        $emailToAssgnTo = 1;
                    }
                }
            }
        }
        $name_email = trim(trim($name_email), ",");
        if (count($usrArr)) {

//By Sunil
            //Getting case uniquid of parent from child node.
            if (isset($data['caseUniqId']) && trim($data['caseUniqId'])) {
                $caseUniqId = $data['caseUniqId'];

                $Easycase = ClassRegistry::init('Easycase');
                $Easycase->recursive = -1;
                //$cases = $Easycase->find('first', array('conditions' => array('Easycase.uniq_id' => $data['caseUniqId'],'Easycase.project_id' => $data['projId'],'Easycase.case_no' => $data['caseNo'])));

                if (isset($data['caseIstype']) && $data['caseIstype'] == 2) {
                    $Easycase->recursive = -1;
                    $easycase_parent = $Easycase->find('first', array('conditions' => array('Easycase.case_no' => $data['caseNo'], 'Easycase.project_id' => $data['projId'], 'Easycase.istype' => 1)));
                    $caseUniqId = $easycase_parent['Easycase']['uniq_id'];
                }
            }//End


            $CaseUserEmail = ClassRegistry::init('CaseUserEmail');
            $CaseUserEmail->recursive = -1;
            $array_unq_test = array();
            foreach ($usrArr as $usr) {
                if (!empty($array_unq_test) && in_array($usr['email'], $array_unq_test)) {
                    //continue;
                } else {
                    array_push($array_unq_test, $usr['email']);
                    if ($usr['id']) {
                        if ($data['caseIstype'] == 1) {
                            ###### Insert to Case User Email table
                            $userEmail['easycase_id'] = $data['caseid'];
                            $userEmail['user_id'] = $usr['id'];
                            $userEmail['ismail'] = 1;
                            $CaseUserEmail->saveAll($userEmail);
                        }
                        $domain = isset($data['auth_domain']) ? $data['auth_domain'] : HTTP_ROOT;
                        if (isset($usr['is_new']) && $usr['is_new'] == 1) {
                        } else {
                            $this->generateMsgAndSendMail($usr['id'], $data['allfiles'], $data['caseNo'], $data['emailTitle'], $data['emailMsg'], $data['projId'], $data['casePriority'], $data['caseTypeId'], $data['msg'], $data['emailbody'], $data['assignTo'], $name_email, $caseUniqId, $data['csType'], $usr['email'], $usr['name'], $domain);
                        }
                    }
                }
            }
        }
    }

    /**
     * @method eventLog To log each event that a user did
     * @author Gayadhar Khilar <support@orangescrum.com>
     * @return bool true/false
     */
    public function eventLog($comp_id = SES_COMP, $user_id = SES_ID, $json_arr = array(), $activity_id)
    {
        $logactivity['LogActivity']['company_id'] = $comp_id;
        $logactivity['LogActivity']['user_id'] = $user_id;
        $logactivity['LogActivity']['log_type_id'] = $activity_id;
        $logactivity['LogActivity']['json_value'] = json_encode($json_arr);
        $logactivity['LogActivity']['ip'] = $_SERVER['REMOTE_ADDR'];
        $logactivity['LogActivity']['created'] = GMT_DATETIME;
        $logActivity = ClassRegistry::init('LogActivity');
        $logActivity->create();
        $logActivity->save($logactivity);
    }

    //socket.io implement start
    public function iotoserver($messageArr)
    {
        return true;
        /*if (defined('NODEJS_HOST') && trim(NODEJS_HOST)) {
            App::import('Vendor', 'ElephantIO', array('file' => 'ElephantIO' . DS . 'src' . DS . 'Client.php'));
            try {
                $client = new Client(new Version1X(NODEJS_HOST));
                $client->initialize();
                //$client->of('/iotoserver');
                $ret = $client->emit('iotoserver', $messageArr);
                $client->close();
            } catch (Exception $e) {
                //fwrite($jk,'erroror'.$e->getMessage());
            }*/
            /* App::import('Vendor', 'ElephantIO', array('file' => 'ElephantIO' . DS . 'Client.php'));
              try {
              $elephant = new ElephantIOClient(NODEJS_HOST, 'socket.io', 1, false, false, true);
              $elephant->setHandshakeTimeout(1000);
              $elephant->init();
              $elephant->send(
              ElephantIOClient::TYPE_EVENT, null, null, json_encode(array('name' => 'iotoserver', 'args' => $messageArr))
              );
              $elephant->close();
              } catch (Exception $e) {
              fwrite($jk,'erroror'.$e->getMessage());
              }
              fclose($jk);
        }*/
    }

    //socket.io implement end
    //socket.io implement start
    public function iotoserverchat($messageArr)
    {
        return true;
        /*if (defined('NODEJS_HOST_CHAT') && trim(NODEJS_HOST_CHAT)) {
            App::import('Vendor', 'ElephantIO', array('file' => 'ElephantIO' . DS . 'src' . DS . 'Client.php'));
            try {
                $client = new Client(new Version1X(NODEJS_HOST_CHAT));
                $client->initialize();
                $ret = $client->emit('iotoserverchat', $messageArr);
                $client->close();
            } catch (Exception $e) {

            }
        }*/
    }

    public function iotoserverlogout($messageArr)
    {
        return true;
        /*if (defined('NODEJS_HOST_CHAT') && trim(NODEJS_HOST_CHAT)) {
            App::import('Vendor', 'ElephantIO', array('file' => 'ElephantIO' . DS . 'src' . DS . 'Client.php'));
            try {
                $client = new Client(new Version1X(NODEJS_HOST_CHAT));
                $client->initialize();
                $ret = $client->emit('iotoserverlogout', $messageArr);
                $client->close();
            } catch (Exception $e) {

            }
        }*/
    }

    public function iotoservergroup($messageArr)
    {
        return true;
        /*if (defined('NODEJS_HOST_CHAT') && trim(NODEJS_HOST_CHAT)) {
            App::import('Vendor', 'ElephantIO', array('file' => 'ElephantIO' . DS . 'src' . DS . 'Client.php'));
            try {
                $client = new Client(new Version1X(NODEJS_HOST_CHAT));
                $client->initialize();
                $ret = $client->emit('iotoservergroup', $messageArr);
                $client->close();
            } catch (Exception $e) {

            }
        } */
    }

    //socket.io implement end

    public function dailyMail($user = null, $project = null, $date = null)
    {
        $from = FROM_EMAIL_EC;
        $to = $user['email'];
        App::import('helper', 'Format');
        $frmtHlpr = new FormatHelper(new View(null));
        $fromname = $frmtHlpr->formatText(trim($user['name'] . " " . $user['last_name']));
        $subject = ucfirst($project['name']) . " (" . strtoupper($project['short_name']) . ") Daily Catch-Up - " . $date;
        $message = "<table><tr><td><table cellpadding='0' cellspacing='0' align='left' border='0' style='border-collapse:collapse;border-spacing:0;text-align:left;width:600px;border:1px solid #3DBB89'>
<tr style='background:#3DBB89;height:50px;'>
<td style='font:bold 14px Arial;padding:10px;color:#FFFFFF;'>
<span style='font-size:18px;'>Orangescrum</span> - Daily Catch-Up Alert
</td>
</tr>
<tr>
<td align='left' style='font:14px Arial;padding:10px;'>
Hi " . ucfirst(trim($user['name'])) . ",
<span style='display:none;color:#fff;'>__0__" . $project['uniq_id'] . "__0__</span>
</td>
</tr>
<tr>
<td style='font:14px Arial;padding:10px;'>
This is a reminder to post your today's updates to Orangescrum. Just reply to this email with the updates, it will be added to the project.
<br/><br/><br/><b>NOTE:</b> DO NOT change the SUBJECT while replying.<br/><br/>
</td>
</tr>
<tr>
<td align='left' style='font:14px Arial;padding:15px 10px;border-top:1px solid #E1E1E1'>
Thanks,<br/>
Team Orangescrum
</td>	  
</tr>
</table></td></tr>
<tr><td>
<table style='margin-top:5px;width:600px;'>
<tr><td style='font:13px Arial;color:#737373;'>Don't want these emails? To unsubscribe, please contact your account administrator to turn off <b>Daily Catch-Up</b> alert for you.</td></tr>
</table></td></tr>
";
        return $this->Sendgrid->sendGridEmail($from, $to, $subject, $message, '', $fromname);
    }
    public function getMessage($name = null, $helpLink = null, $msg = null)
    {
        return true;
    }
    public function sendEmailReminder($user = null, $subject = null, $message = null)
    {
        $to = $user['email'];
        $this->Email->delivery = 'smtp';
        $this->Email->to = $to;
        $this->Email->subject = $subject;
        $this->Email->from = Configure::read('marketing_from');
        $this->Email->htmlMessage = $message;
        $this->Email->sendAs = 'html';
        //return $this->Sendgrid->sendMandrillEmail($this->Email, $message, 'EmailMarketing');
        return $this->Sendgrid->sendgridsmtp($this->Email);
    }

    /**
     * @method invitenewuser Inivite a list of user with email
     * @return array success and Failure email
     */
    public function invitenewuser($mail_arr = array(), $prj_id = 0, $obj, $is_mobile_api = null, $compani_id = null, $user_id = null, $company_uniq_id = null, $cmp_name = null)
    {
        App::import('Controller', 'Users');
        $userscontroller = new UsersController;
        $usercls = ClassRegistry::init('User');
        $CompanyUser = ClassRegistry::init('CompanyUser');
        $UserInvitation = ClassRegistry::init('UserInvitation');
        $err = 0;
        $ucounter = count($mail_arr);

        $comp_id = ($compani_id) ? $compani_id : SES_COMP;
        $User_id = ($user_id) ? $user_id : SES_ID;
        $comp_name = ($cmp_name) ? $cmp_name : CMP_SITE;
        $company_uniq_id = ($company_uniq_id) ? $company_uniq_id : COMP_UID;
        $cmp_name = ($cmp_name) ? $cmp_name : CMP_SITE;

        if (!$is_mobile_api) {
            $total_new_users = $ucounter + $GLOBALS['usercount'];
            if (strtolower($GLOBALS['Userlimitation']['user_limit']) != 'unlimited' && ($total_new_users > $GLOBALS['Userlimitation']['user_limit'])) {
                $this->Session->write("ERROR", "Sorry! You are exceeding your user limit");
                header('Location:' . HTTP_ROOT);
                exit;
            }
        }
        //for($i=0;$i<count($mail_arr);$i++){
        foreach ($mail_arr as $key => $val) {
            if (trim($val) != "") {
                $val = trim($val);
                $user_new_password = '';
                $findEmail = $usercls->find('first', array('conditions' => array('User.email' => $val)));
                $invitation_details = array();
                if (@$findEmail['User']['id']) {
                    $userid = $findEmail['User']['id'];
                    $invitation_details = $UserInvitation->find('first', array('conditions' => array('user_id' => $findEmail['User']['id'], 'company_id' => $comp_id), 'fields' => array('id', 'project_id')));
                    $array_input = array();
                    $array_input['User'] = $findEmail['User'];
                    if (!$findEmail['User']['password'] && !$findEmail['User']['dt_last_login']) {
                        $PIDS = $prj_id;
                        if (@$invitation_details['UserInvitation']['id']) {
                            $PIDS = $invitation_details['UserInvitation']['project_id'] ? $invitation_details['UserInvitation']['project_id'] . ',' . $prj_id : $prj_id;
                        }
                        $user_new_password = $this->Format->genRandomString();
                        $array_input['User']['password'] = md5($user_new_password);
                    } else {
                        $PIDS = $prj_id;
                    }
                    if (!$array_input['User']['timezone_id']) {
                        $array_input['User']['timezone_id'] = $obj->Auth->User('timezone_id');
                    }
                    if (!$array_input['User']['short_name']) {
                        $array_input['User']['short_name'] = $this->Format->makeShortName($array_input['User']['name'], '');
                    }
                    $userid_pass = $userscontroller->newInviteUserProcess($array_input, 'old', 1, $PIDS);
                    $resp_temp = explode('___', $userid_pass);
                    $obj->set('password', $user_new_password);
                } else {
                    $userdata['User']['uniq_id'] = $this->Format->generateUniqNumber();
                    $userdata['User']['isactive'] = 2;
                    $userdata['User']['isemail'] = 1;
                    $userdata['User']['dt_created'] = GMT_DATETIME;
                    $userdata['User']['email'] = $val;
                    $userdata['User']['timezone_id'] = $obj->Auth->User('timezone_id');
                    $user_new_password = $this->Format->genRandomString();
                    $userdata['User']['password'] = md5($user_new_password);

                    $temp_name = explode('@', $userdata['User']['email']);
                    $userdata['User']['name'] = $temp_name[0];
                    $userdata['User']['short_name'] = $this->Format->makeShortName($userdata['User']['name'], '');

                    //Below one line Added and twoline commented for the new invite user functionality
                    $userid_pass = $userscontroller->newInviteUserProcess($userdata, 'new', 1, $prj_id);
                    $resp_temp = explode('___', $userid_pass);
                    $userid = $resp_temp[0];
                    $obj->set('password', $user_new_password);
                    //$usercls->saveAll($userdata);
                    //$userid = $usercls->getLastInsertID();
                }
                if ($userid && $userid != $User_id) {
                    $cmpnyUsr = array();
                    $is_sub_upgrade = 1;
                    // Checking for a deleted user when gets invited again.
                    $compuser = $CompanyUser->find('first', array('conditions' => array('user_id' => $userid, 'company_id' => $comp_id)));
                    if ($compuser && $compuser['CompanyUser']['is_active'] == 0) {
                        $this->Session->write("ERROR", "Sorry! You are not allowed to add a disabled user to a the project");
                        continue;
                    }
                    $cmpnyUsr['CompanyUser']['is_active'] = 2;
                    $cmpnyUsr['CompanyUser']['user_type'] = 3;
                    $cmpnyUsr['CompanyUser']['role_id'] = 3;
                    if ($compuser) {
                        $is_sub_upgrade = 0;
                        $cmpnyUsr['CompanyUser']['user_type'] = $compuser['CompanyUser']['user_type'];
                        $cmpnyUsr['CompanyUser']['role_id'] = $compuser['CompanyUser']['user_type'];
                        $cmpnyUsr['CompanyUser']['is_active'] = $compuser['CompanyUser']['is_active'];
                        if ($compuser['CompanyUser']['is_active'] == 3) {
                            // If that user deleted in the same billing month and invited again then that user will not paid
                            if ($GLOBALS['Userlimitation']['btsubscription_id']) {
                                if (strtotime($GLOBALS['Userlimitation']['next_billing_date']) > strtotime($compuser['CompanyUser']['billing_end_date'])) {
                                    $is_sub_upgrade = 1;
                                }
                            }
                            $cmpnyUsr['CompanyUser']['user_type'] = 3;
                            $cmpnyUsr['CompanyUser']['role_id'] = 3;
                            $cmpnyUsr['CompanyUser']['is_active'] = 2;
                        }
                        $cmpnyUsr['CompanyUser']['id'] = $compuser['CompanyUser']['id'];
                    }
                    $cmpnyUsr['CompanyUser']['user_id'] = $userid;
                    $cmpnyUsr['CompanyUser']['company_id'] = $comp_id;
                    $cmpnyUsr['CompanyUser']['company_uniq_id'] = $company_uniq_id;
                    $cmpnyUsr['CompanyUser']['created'] = GMT_DATETIME;

                    //added for new invite functionality
                    $cmpnyUsr['CompanyUser']['is_active'] = 1;
                    $cmpnyUsr['CompanyUser']['act_date'] = GMT_DATETIME;

                    if ($CompanyUser->saveAll($cmpnyUsr)) {
                        $qstr = $this->Format->generateUniqNumber();
                        if (@$findEmail['User']['id'] && @$invitation_details['UserInvitation']['id']) {
                            $InviteUsr['UserInvitation']['id'] = $invitation_details['UserInvitation']['id'];
                            $InviteUsr['UserInvitation']['project_id'] = $invitation_details['UserInvitation']['project_id'] ? $invitation_details['UserInvitation']['project_id'] . ',' . $prj_id : $prj_id;
                        } else {
                            $InviteUsr['UserInvitation']['project_id'] = $prj_id;
                        }
                        $InviteUsr['UserInvitation']['invitor_id'] = $User_id;
                        $InviteUsr['UserInvitation']['user_id'] = $userid;
                        $InviteUsr['UserInvitation']['company_id'] = $comp_id;
                        $InviteUsr['UserInvitation']['qstr'] = $qstr;
                        $InviteUsr['UserInvitation']['created'] = GMT_DATETIME;
                        $InviteUsr['UserInvitation']['is_active'] = 1;
                        $InviteUsr['UserInvitation']['user_type'] = 3;
                        $InviteUsr['UserInvitation']['role_id'] = 3;

                        //added for new invite functionality
                        $InviteUsr['UserInvitation']['is_active'] = 0;

                        if ($UserInvitation->saveAll($InviteUsr)) {

//Event log data and inserted into database in account creation--- Start
                            $json_arr['email'] = $val;
                            $json_arr['created'] = GMT_DATETIME;
                            $this->eventLog($comp_id, $User_id, $json_arr, 25);
                            //End
                            //Subscription price update  if its a paid user -start
                            $comp_user_id = $CompanyUser->getLastInsertID();

                            if ($is_sub_upgrade) {
                                //$userscontroller->update_bt_subscription($comp_user_id, SES_COMP, 1);
                            }
                            //end
                            $to = $val;
                            $expEmail = explode("@", $val);
                            $expName = $expEmail[0];
                            $loggedin_users = $usercls->find('first', array('conditions' => array('User.id' => $User_id, 'User.isactive' => 1), 'fields' => array('User.name', 'User.email', 'User.id')));
                            $fromName = ucfirst($loggedin_users['User']['name']);
                            $fromEmail = $loggedin_users['User']['email'];
                            $ext_user = '';
                            if (@$findEmail['User']['id'] && trim($findEmail['User']['password'])) {
                                $subject = $fromName . " invited you to join " . $comp_name . " on Orangescrum";
                                $ext_user = 1;
                            } else {
                                $subject = $fromName . " created your account on Orangescrum";
                            }
                            $this->Email->delivery = 'smtp';
                            $this->Email->to = $to;
                            $this->Email->subject = $subject;
                            $this->Email->from = FROM_EMAIL;
                            $this->Email->template = 'invite_user';
                            $this->Email->sendAs = 'html';
                            $obj->set('expName', ucfirst($expName));
                            $obj->set('qstr', $qstr);
                            $obj->set('existing_user', $ext_user);

                            $obj->set('company_name', $comp_name);
                            $obj->set('fromEmail', $fromEmail);
                            $obj->set('fromName', $fromName);
                            $obj->set('email', $to);

                            try {
                                if (defined("PHPMAILER") && PHPMAILER == 1) {
                                    $this->Email->set_variables = $obj->render('/Emails/html/invite_user', false);
                                    $this->PhpMailer->sendPhpMailerTemplate($this->Email);
                                } else {
                                    $this->Sendgrid->sendgridsmtp($this->Email);
                                }
                            } catch (Exception $e) {
                            }
                        }
                    }
                    $rarr['success'][] = $userid;
                } else {
                    $err = 1;
                    $rarr['error'][] = 1;
                }
            }
        }
        return $rarr;
    }

    /** @method removeFiles It will remove all the Uncheked files during edit & Update of a Task
     * @return bool true/false
     * @author GDR<support@orangescrum.com>
     */
    public function removeFiles($caseFileids, $easycaseid, $chk=0)
    {
        if (strstr($caseFileids, ',')) {
            $caseFileids = explode(',', $caseFileids);
        }
        $caseRemovedFile = ClassRegistry::init('CaseRemovedFile');
        $caseFile = ClassRegistry::init('CaseFile');
        $easycase = ClassRegistry::init('Easycase');
        $ProjectTemplateCaseFile = ClassRegistry::init('ProjectTemplateCaseFile');
        $filedata = $caseFile->find('all', array('conditions' => array('CaseFile.id' => $caseFileids), 'field' => array('id,file,upload_name,file_size,project_id')));
        $delids = array();
        foreach ($filedata as $key => $val) {
            $data = [];
            $delids[] = $val['CaseFile']['id'];
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $folder_orig_Name = 'files/case_files/' . trim($val['CaseFile']['file']);
            //$info = $s3->getObjectInfo(BUCKET_NAME, $folder_orig_Name,S3::ACL_PRIVATE);
            //$s3->deleteObject(BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
            $data['CaseRemovedFile']['case_file_id'] = $val['CaseFile']['id'];
            $data['CaseRemovedFile']['project_id'] = $val['CaseFile']['project_id'];
            $data['CaseRemovedFile']['user_id'] = SES_ID;
            $data['CaseRemovedFile']['company_id'] = SES_COMP;
            $data['CaseRemovedFile']['case_file_name'] = !empty($val['CaseFile']['upload_name'])?$val['CaseFile']['upload_name']:$val['CaseFile']['file'];
            // $cnt = $ProjectTemplateCaseFile->find('count', array('conditions' => array('ProjectTemplateCaseFile.upload_name' => $data['CaseRemovedFile']['case_file_name'])));
            // if ($cnt ==0) {
                $caseRemovedFile->save($data);
            // }
        }
        if ($caseFile->deleteAll(array('CaseFile.id' => $delids, 'CaseFile.company_id' => SES_COMP, 'CaseFile.easycase_id' => $easycaseid))) {
            $cur_data = $easycase->find('first', array('conditions' => array('Easycase.id' => $easycaseid), 'fields' => array('Easycase.id','Easycase.case_no', 'Easycase.project_id', 'Easycase.thread_count','Easycase.format', 'Easycase.message','Easycase.istype')));
            $org_data = $easycase->find('list', array('conditions' => array('Easycase.project_id' => $cur_data['Easycase']['project_id'], 'Easycase.case_no' => $cur_data['Easycase']['case_no']), 'fields' => array('Easycase.id')));
            $files = $caseFile->find('list', array('conditions' => array('CaseFile.company_id' => SES_COMP, 'CaseFile.easycase_id' => $org_data,'CaseFile.isactive' => 1),'fields'=>array('CaseFile.id','CaseFile.easycase_id')));
            if (!$chk && empty($cur_data['Easycase']['message']) && $cur_data['Easycase']['istype'] == 2 && !in_array($cur_data['Easycase']['id'], $files)) {
                $easycase->updateAll(array('thread_count'=>'thread_count-1'), array('id' => $org_data, 'project_id' => $cur_data['Easycase']['project_id'], 'case_no' => $cur_data['Easycase']['case_no'], 'istype' => 1));
            }
            if (empty($files)) {
                $easycase->updateAll(array('format' => 2), array('id' => $org_data, 'project_id' => $cur_data['Easycase']['project_id'], 'case_no' => $cur_data['Easycase']['case_no'], 'istype' => 1));
            }
            return true;
        } else {
            return false;
        }
    }

    public function copyTaskFiles($filename)
    {
        try {
            $CaseFile = ClassRegistry::init('CaseFile');
            $CaseFile->recursive = -1;
            $orig_file = $filename;
            $checkFile = $CaseFile->query("SELECT id,count FROM case_files as CaseFile WHERE file='$filename'");
            if (count($checkFile) >= 1) {
                $newCount = $checkFile['0']['CaseFile']['count'] + 1;
                $ext1 = substr(strrchr($filename, "."), 1);
                $tot = strlen($filename);
                $extcnt = strlen($ext1);
                $end = $tot - $extcnt - 1;
                $onlyfile = substr($filename, 0, $end);
                $filename = $onlyfile . "(" . $newCount . ")." . $ext1;
            }
            if (defined('USE_S3') && USE_S3) {
                $s3 = new S3(awsAccessKey, awsSecretKey);
                $ret_res = $s3->copyObject(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER . $orig_file, BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER . $filename, S3::ACL_PRIVATE);
                $thumb_filename = $orig_file;
                $ret_res = $s3->copyObject(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $thumb_filename, BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_THUMB . $filename, S3::ACL_PRIVATE);
            } else {
                copy(DIR_CASE_FILES . $orig_file, DIR_CASE_FILES . $filename);
                copy(DIR_CASE_FILES . 'thumb_' . $thumb_filename, DIR_CASE_FILES . 'thumb_' . $filename);
            }
        } catch (Exception $e) {
            //return true;
        }
        return $filename;
    }
    /*
     * To check the date in leave or not
     */

    /* function checkDateInLeave($date, $leaves) {
         $date = date('Y-m-d',strtotime($date));
         foreach ($leaves as $k => $leave) {
             $sdate= date('Y-m-d',strtotime($leave['UserLeave']['start_date']));
             $edate= date('Y-m-d',strtotime($leave['UserLeave']['end_date']));
             if (strtotime($date) >= strtotime($sdate) && strtotime($date) <= strtotime($edate)) {
                 return 1;
             } else if (strtotime($date) <= strtotime($sdate) && strtotime($date) >= strtotime($edate)) {
                 return 0;
             }
         }
     }*/
    public function checkDateInLeave($date, $leaves)
    {
        $date = strtotime($date);
        foreach ($leaves as $k => $leave) {
            $sdate= strtotime($leave['UserLeave']['start_date']);
            $edate= strtotime($leave['UserLeave']['end_date']);
            if ($date >= $sdate && $date <= $edate) {
                return 1;
            } elseif ($date <= $sdate && $date >= $edate) {
                return 0;
            }
        }
    }

    /*
     * set booked data
     */
    public function setBookedData($postParam, $estimated_hours, $easycase_id, $company_id)
    {
        set_time_limit(0);
        $isAssignedUserFree = 1;
        $BookedResources = ClassRegistry::init('ProjectBookedResource');
        $UserLeaves = ClassRegistry::init('UserLeave');
        $Overload = ClassRegistry::init('Overload');
        
        $perDayWorkSec = isset($GLOBALS['company_work_hour']) ? $GLOBALS['company_work_hour'] * 3600 : $postParam['Easycase']['company_work_hour'] * 3600;
        $weekendArr = explode(',', $GLOBALS['company_week_ends']);
        
        /** gantt start date in UTC format but time is already added we will convert it to GMT ten set time 00:00:01 then convert to UTC again */
        $gntstdt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $postParam['Easycase']['gantt_start_date'], 'date');
        $postParam['Easycase']['gantt_start_date'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $gntstdt." 00:00:01", 'datetime');
        /** due date in UTC format but time is already added we will convert it to GMT ten set time 23:59:59 then convert to UTC again */
        $dueenddt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $postParam['Easycase']['due_date'], 'date');
        $postParam['Easycase']['due_date'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dueenddt." 23:59:59", 'datetime');

        $lastdate = $duedate = date('Y-m-d', strtotime($postParam['Easycase']['due_date']));
        //$no_of_days = ceil($estimated_hours / $perDayWorkSec);
        $startdate = $assigned_Resource_date = date('Y-m-d', strtotime($postParam['Easycase']['gantt_start_date']));
        //$lastdate = date('Y-m-d', strtotime($assigned_Resource_date . " +" . ($no_of_days - 1) . "days"));
        $start_datetime = strtotime($startdate);
        $end_datetime = strtotime($lastdate);
        //$no_of_days = ceil(abs($end_datetime - $start_datetime) / 86400)+1; // Commented due to less than 8 hour issue.
        $no_of_days = ceil(abs($end_datetime - $start_datetime) / 86400);
        $leaves = $UserLeaves->find('all', array('conditions' => array('UserLeave.company_id' => SES_COMP, 'UserLeave.user_id' => $postParam['Easycase']['assign_to'])));
        $CompanyHoliday = ClassRegistry::init('CompanyHoliday');
        $hLists = $CompanyHoliday->find('all', array('fields'=>array('holiday','description'),'conditions'=>array('company_id'=>SES_COMP,'or' => array('holiday >=' => $postParam['Easycase']['gantt_start_date'],'holiday >=' => $postParam['Easycase']['gantt_start_date'])),'order'=>array('created ASC')));
        foreach ($hLists as $k=>$v) {
            $arr = array();
            $arr['start_date'] = $v['CompanyHoliday']['holiday'];
            #$arr['end_date'] = $v['CompanyHoliday']['holiday'];
            $arr['end_date'] = date('Y-m-d H:i:s', strtotime($v['CompanyHoliday']['holiday'] . " +" . 86398 . " seconds"));
            $leaves[]['UserLeave'] = $arr;
        }
        if ($isAssignedUserFree == 1) {
            foreach ($leaves as $k => $leave) {
                $overlap = max(0, min(strtotime($lastdate), strtotime($leave['UserLeave']['end_date'])) - max(strtotime($postParam['Easycase']['gantt_start_date']), strtotime($leave['UserLeave']['start_date'])));
                if ($overlap > 0) {
                    $isAssignedUserFree = 3;
                    return $isAssignedUserFree;
                }
            }
        }
        
        $working_dates = array();
        $do = $no_of_days;
        $assigned_Resource_date_time = $postParam['Easycase']['gantt_start_date'];
        if ($do > 0) {
            while ($do > 0) {
                $inleave = $this->checkDateInLeave($assigned_Resource_date_time, $leaves);
                if (!$inleave) {
                    if ($startdate == date('Y-m-d', strtotime($postParam['Easycase']['due_date']))) {
                        $working_dates[] = $assigned_Resource_date_time;
                        break;
                    } else {
                        $working_dates[] = $assigned_Resource_date_time;
                        $do--;
                    }
                }
                $assigned_Resource_date_time = date('Y-m-d H:i:s', strtotime($assigned_Resource_date_time . " +" . 1 . " days"));
            }
        } else {
            $working_dates[] = $assigned_Resource_date_time;
        }
        $partial_days = array();
        $totBookedHr = 0;
        $datewiseHrs = array();
        foreach ($working_dates as $key => $value) {
            $val = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value, "date");
            $val = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $val." 00:00:01", "datetime");
            $query = "SELECT SUM(`ProjectBookedResource`.`booked_hours`) AS booked_hrs, `ProjectBookedResource`.`id`, `ProjectBookedResource`.`company_id`, `ProjectBookedResource`.`project_id`, `ProjectBookedResource`.`easycase_id`, `ProjectBookedResource`.`user_id`, `ProjectBookedResource`.`date` FROM `project_booked_resources` AS `ProjectBookedResource` INNER JOIN easycases AS Easycase on Easycase.id=`ProjectBookedResource`.`easycase_id` AND Easycase.isactive=1 WHERE `ProjectBookedResource`.`company_id` = " . SES_COMP . " AND `ProjectBookedResource`.`user_id` = " . $postParam['Easycase']['assign_to'] . " AND `ProjectBookedResource`.`date` >= '" .$val . "' AND `ProjectBookedResource`.`date` <= '" .date('Y-m-d H:i:s', strtotime($val.' +86390 seconds')) . "' GROUP BY DATE(`ProjectBookedResource`.`date`)";
            $hours_booked = $BookedResources->query($query);
            if (!empty($hours_booked)) {
                $booked_hours = 0;
                foreach ($hours_booked as $kv=>$vv) {
                    $booked_hours += $vv[0]['booked_hrs'];
                }
                $totBookedHr += $booked_hours;
                $datewiseHrs[date('Y-m-d', strtotime($value))] = $booked_hours;
                $available_hrs = $perDayWorkSec - $booked_hours;
                if ($estimated_hours > $available_hrs) {
                    $partial_days[$value] = $booked_hours;
                }
            }
        }

        /** Check the total hr of task is managegeable with in the start date and due date **/
        /** No of day's(hrs) available to complete the task */
        $gntdate = date('Y-m-d', strtotime($postParam['Easycase']['gantt_start_date']));
        $nd= round((strtotime($duedate) - strtotime($gntdate))/86400);
        if ($totBookedHr) {
            //$can_manage_with_in_time = (($nd+1) * $perDayWorkSec) - $totBookedHr;	 // Commented due to less than 8 hour issue.
            $can_manage_with_in_time = (($nd) * $perDayWorkSec) - $totBookedHr;
            if ($can_manage_with_in_time >= $estimated_hours) {
                $dta = array();
                $flgHr=0;
                for ($k = 0 ; $k <= $nd;$k++) {
                    $sdt= date('Y-m-d', strtotime($postParam['Easycase']['gantt_start_date'] . " +" . $k . " days"));
                    $sdt_t= date('Y-m-d H:i:s', strtotime($postParam['Easycase']['gantt_start_date'] . " +" . $k . " days"));
                    if (isset($datewiseHrs[$sdt])) {
                        $bhrs = $perDayWorkSec - $datewiseHrs[$sdt];
                        $bhrs = (($estimated_hours - $flgHr) >= $perDayWorkSec) ?$bhrs : $estimated_hours - $flgHr;
                    } else {
                        $bhrs = (($estimated_hours - $flgHr) >= $perDayWorkSec) ?$perDayWorkSec : $estimated_hours - $flgHr;
                    }
                    if ($bhrs) {
                        $dta[$k]['ProjectBookedResource']['company_id'] = $company_id;
                        $dta[$k]['ProjectBookedResource']['user_id'] = $postParam['Easycase']['assign_to'];
                        $dta[$k]['ProjectBookedResource']['project_id'] = $postParam['Easycase']['project_id'];
                        $dta[$k]['ProjectBookedResource']['easycase_id'] = $easycase_id;
                        $dta[$k]['ProjectBookedResource']['date'] = $sdt_t;
                        $dta[$k]['ProjectBookedResource']['booked_hours'] = ($bhrs >= 0)?$bhrs:0;
                        $flgHr += $bhrs;
                    }
                    if ($flgHr >= $estimated_hours) {
                        break;
                    }
                }
                if (count($dta) > 0) {
                    foreach ($dta as $k=>$v) {
                        $day_name =  date('w', strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['ProjectBookedResource']['date'], 'date')));
                        if (in_array($day_name, $weekendArr)) {
                            $isAssignedUserFree = 3;
                            return $isAssignedUserFree;
                        }
                    }
                }
                $BookedResources->saveMany($dta);
                $isAssignedUserFree = 1;
                return $isAssignedUserFree;
            }
        }
        /** End Logic **/
        /** Check if estimated total hr is not managable between hours **/
        $total_parcial_available = !empty($partial_days)?array_sum($partial_days):0;
        $total_parcial_available = (($nd+1) * $perDayWorkSec) - $total_parcial_available ; // Commented due to less than 8 hour issue.
        //$total_parcial_available = (($nd) * $perDayWorkSec) - $total_parcial_available ;
        /* end **/
        if (empty($partial_days) && $estimated_hours <= (($nd+1) * $perDayWorkSec) && $estimated_hours <= $total_parcial_available) {
            if ($estimated_hours > $perDayWorkSec) {
                foreach ($working_dates as $key => $value) {
                    $data[$key]['ProjectBookedResource']['id'] = '';
                    $data[$key]['ProjectBookedResource']['company_id'] = $company_id;
                    $data[$key]['ProjectBookedResource']['user_id'] = $postParam['Easycase']['assign_to'];
                    $data[$key]['ProjectBookedResource']['project_id'] = $postParam['Easycase']['project_id'];
                    $data[$key]['ProjectBookedResource']['easycase_id'] = $easycase_id;
                    $data[$key]['ProjectBookedResource']['date'] = $value;
                        
                    $bkedhr = $estimated_hours - ($perDayWorkSec * $key) >= $perDayWorkSec ? $perDayWorkSec : $estimated_hours - ($perDayWorkSec * $key);
                        
                    $data[$key]['ProjectBookedResource']['booked_hours'] = ($bkedhr >= 0)?$bkedhr:0;
                }
                $BookedResources->create();
                if (count($data) > 0) {
                    foreach ($data as $k=>$v) {
                        $day_name =  date('w', strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['ProjectBookedResource']['date'], 'date')));
                        if (in_array($day_name, $weekendArr)) {
                            $isAssignedUserFree = 3;
                            return $isAssignedUserFree;
                        }
                    }
                }
                $BookedResources->saveMany($data);
                if ($startdate == date('Y-m-d', strtotime($postParam['Easycase']['due_date']))) {
                    $overload_hr = $estimated_hours - $perDayWorkSec;
                    $overload = array('date'=>$postParam['Easycase']['due_date'],'easycase_id'=>$easycase_id,'project_id'=>$postParam['Easycase']['project_id'],'user_id'=>$postParam['Easycase']['assign_to'],'company_id'=>SES_COMP,'overload'=>$overload_hr);
                    $Overload->save($overload);
                }
            } else {
                $BookedResources->create();
                $data['ProjectBookedResource']['id'] = '';
                $data['ProjectBookedResource']['company_id'] = $company_id;
                $data['ProjectBookedResource']['user_id'] = $postParam['Easycase']['assign_to'];
                $data['ProjectBookedResource']['project_id'] = $postParam['Easycase']['project_id'];
                $data['ProjectBookedResource']['easycase_id'] = $easycase_id;
                $data['ProjectBookedResource']['date'] = $postParam['Easycase']['gantt_start_date'];
                    
                $bkedhr = $estimated_hours;
                    
                $data['ProjectBookedResource']['booked_hours'] = ($bkedhr >= 0)?$bkedhr:0;
                if (count($data) > 0) {
                    foreach ($data as $k=>$v) {
                        $day_name =  date('w', strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['date'], 'date')));
                        if (in_array($day_name, $weekendArr)) {
                            $isAssignedUserFree = 3;
                            return $isAssignedUserFree;
                        }
                    }
                }
                $BookedResources->save($data);
            }
            $isAssignedUserFree = 1;
        } else {
            $isAssignedUserFree = 2;
        }
        return $isAssignedUserFree;
    }

    public function mailToMentionUser($data = array(), $getEmailUser = array(), $type = 0)
    {
        $name_email = "";
        $ids = "";
        $usrArr = array();
        $emailToAssgnTo = 0;
        foreach ($getEmailUser as $usrMem) {
            if (isset($usrMem['User']['name']) && $usrMem['User']['name']) {
                if ($data['is_client'] == 1 && $usrMem['is_client'] != 1) {
                    array_push($usrArr, $usrMem['User']);
                    $name_email.= trim($usrMem['User']['name']) . ", ";
                    if ($data['caUid'] == $usrMem['User']['id']) {
                        $emailToAssgnTo = 1;
                    }
                } else {
                    array_push($usrArr, $usrMem['User']);
                    $name_email.= trim($usrMem['User']['name']) . ", ";
                    if ($data['caUid'] == $usrMem['User']['id']) {
                        $emailToAssgnTo = 1;
                    }
                }
            }
        }
        $name_email = trim(trim($name_email), ",");
        if (count($usrArr)) {

//By Sunil
            //Getting case uniquid of parent from child node.
            if (isset($data['caseUniqId']) && trim($data['caseUniqId'])) {
                $caseUniqId = $data['caseUniqId'];

                $Easycase = ClassRegistry::init('Easycase');
                $Easycase->recursive = -1;
                //$cases = $Easycase->find('first', array('conditions' => array('Easycase.uniq_id' => $data['caseUniqId'],'Easycase.project_id' => $data['projId'],'Easycase.case_no' => $data['caseNo'])));

                if (isset($data['caseIstype']) && $data['caseIstype'] == 2) {
                    $Easycase->recursive = -1;
                    $easycase_parent = $Easycase->find('first', array('conditions' => array('Easycase.case_no' => $data['caseNo'], 'Easycase.project_id' => $data['projId'], 'Easycase.istype' => 1)));
                    $caseUniqId = $easycase_parent['Easycase']['uniq_id'];
                }
            }//End
            $array_unq_test = array();
            foreach ($usrArr as $usr) {
                if (!empty($array_unq_test) && in_array($usr['email'], $array_unq_test)) {
                    //continue;
                } else {
                    array_push($array_unq_test, $usr['email']);
                    if ($usr['id']) {
                        if ($data['caseIstype'] == 1) {
                            $data['emailbody'] = __("Task");
                        } else {
                            $data['emailbody'] = __("Comment");
                        }
                        $domain = isset($data['auth_domain']) ? $data['auth_domain'] : HTTP_ROOT;
                        if ($usr['id'] != SES_ID) {
                            $this->generateMsgAndSendMentionMail($usr['id'], $data['caseNo'], $data['emailTitle'], $data['emailMsg'], $data['projId'], $data['casePriority'], $data['caseTypeId'], $data['msg'], $data['emailbody'], $data['assignTo'], $name_email, $caseUniqId, $data['csType'], $usr['email'], $usr['name'], $domain);
                        }
                    }
                }
            }
        }
    }
    public function generateMsgAndSendMentionMail($uid, $hid_caseno, $case_title, $respond, $hid_proj, $hid_priority, $hid_type, $msg, $emailbody, $assignTo, $name_email, $case_uniq_id, $type, $toEmail = null, $toName = null, $domain = HTTP_ROOT)
    {
        App::import('helper', 'Casequery');
        $csQuery = new CasequeryHelper(new View(null));

        App::import('helper', 'Format');
        $frmtHlpr = new FormatHelper(new View(null));
        ##### get User Details
        $to = "";
        $to_name = "";
        if (!$toEmail) {
            $toUsrArr = $csQuery->getUserDtls($uid);
            if (count($toUsrArr)) {
                $to = $toUsrArr['User']['email'];
                $to_name = $frmtHlpr->formatText($toUsrArr['User']['name']);
            }
        } else {
            $to = $toEmail;
            $to_name = $toName;
        }
        ##### get Sender Details
        $senderUsrArr = $csQuery->getUserDtls(SES_ID);
        $by_name = "";
        $by_name = "";
        if (count($senderUsrArr)) {
            $by_email = $senderUsrArr['User']['email'];
            $by_name = $frmtHlpr->formatText($senderUsrArr['User']['name']);
        }
        //$from_name = preg_replace("/[^a-zA-Z0-9]+/", "", $by_name);
        $fromname = $frmtHlpr->formatText(trim($senderUsrArr['User']['name'] . " " . $senderUsrArr['User']['last_name']));

        ##### get Project Details
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $prjArr = $Project->find('first', array('conditions' => array('Project.id' => $hid_proj), 'fields' => array('Project.name', 'Project.short_name', 'Project.uniq_id')));
        $projName = "";
        $case_no = "";
        $projUniqId = "";
        if (count($prjArr)) {
            $projName = $frmtHlpr->formatText($prjArr['Project']['name']);
            $case_no = $frmtHlpr->formatText($prjArr['Project']['short_name']) . "-" . $hid_caseno;
            $projUniqId = $prjArr['Project']['uniq_id'];
        }
        ##### get Case Type
        
        $postingName = "";
        if (SES_ID == $uid) {
            $postingName = __("You have been mentioned in");
        } elseif ($by_name) {
            $postingName = $by_name . " ".__("has mentioned you in");
        }
        $from = FROM_EMAIL_EC;
        
        $projNameInSh = $projName;
        if (strlen($projNameInSh) > 10) {
            //$projNameInSh = substr($projNameInSh,0,9).'...';
            $projNameInSh = $projNameInSh;
        }
        $shrt = $frmtHlpr->formatText($prjArr['Project']['short_name']);
        if ($shrt) {
            $projShortNcaseNumber = $hid_caseno . "(" . $shrt . ")";
        } else {
            $projShortNcaseNumber = $hid_caseno;
        }
        //$subject = EMAIL_SUBJ . ":" . $projNameInSh . ":#" . $projShortNcaseNumber . "-" . stripslashes(html_entity_decode($case_title, ENT_QUOTES));
        //$subject = $projNameInSh . ":#" . $projShortNcaseNumber . "-" . stripslashes(html_entity_decode($case_title, ENT_QUOTES));
        $subject = $projNameInSh . " - " . stripslashes(html_entity_decode($case_title, ENT_QUOTES, 'UTF-8'));

        $message = "<!doctype html><html><head><style>.custom_span_color span.im {color:#ccc !important;}</style><meta charset='utf-8'></head>
        <body style='width:100%; margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#ffffff;'>
        <table cellpadding='0' cellspacing='0' border='0' id='backgroundTable' style='height:auto !important; margin:0; padding:0; width:100% !important; background-color:#F0F0F0;color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;'>
        <tr>
        <td>
        <div id='tablewrap' style='width:100% !important; max-width:600px !important; text-align:center; margin:0 auto;'>
        <table id='contenttable' width='600' align='center' cellpadding='0' cellspacing='0' border='0' style='background-color:#FFFFFF; margin:0 auto; text-align:center; border:none; width: 100% !important; max-width:600px !important;border-top:8px solid #3DBB89'>
        <tr>
        <td width='100%'>
        " . NEW_EMAIL_HEADER . "
        <table bgcolor='#FFF' border='0' cellspacing='10' cellpadding='0' width='100%'>
        <tr>
        <td style='text-align:center;line-height:22px;font:18px Arial;'>
        <b>" . $postingName . " " . $emailbody . "</b>
        </td>
        </tr>
        <tr>
        <td align='left' valign='top' style='line-height:22px;font:14px Arial;'>
        <font color='#737373'><b>".__("Title").": </b></font> <a href='" . $domain . "users/login/?dashboard#details/" . $case_uniq_id . "' target='_blank' style='text-decoration:underline;color:#F86A0C;'>" . stripslashes($case_title) . "</a>
        <br/><br/>
        <font color='#737373'><b>".__("Project").":</b></font> " . $projName . "
        </td>
        </tr>
        
        </table>
        <table bgcolor='#F0F0F0' border='0' cellspacing='0' cellpadding='10' width='100%' style='border-top:2px solid #F0F0F0;margin-top:5px;text-align:left;'>
        <tr>
        <td width='100%' bgcolor='#ffffff' style='text-align:left;font:14px Arial'>
        <p class='custom_span_color' style='color:gray;'>
        " . stripslashes($respond) . "
        </p>
        </td>	  
        </tr>
        </table>
        <table bgcolor='#F0F0F0' border='0' cellspacing='0' cellpadding='10' width='100%' style='border-top:2px solid #F0F0F0;margin-top:10px;text-align:left;'>
        <tr>
        <td width='100%' bgcolor='#ffffff' style='text-align:left;font:14px Arial'>
        <p style='color:#676767; line-height:20px;'>
        ".__("To read the original message, view comments, reply & download attachment").": <br/> ".__("Link").": <a href='" . $domain . "users/login/dashboard#details/" . $case_uniq_id . "' target='_blank'>" . $domain . "users/login/dashboard#details/" . $case_uniq_id . "/</a>
        </p>
        </td>	  
        </tr>
        </table>
        <table bgcolor='#F0F0F0' border='0' cellspacing='0' cellpadding='10' width='100%' style='border-top:2px solid #F0F0F0;margin-top:5px;border-bottom:3px solid #3DBB89'>
        <tr>
        <td width='100%' bgcolor='#ffffff' style='text-align:center;'>
        <p style='color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;'>
        " . NEW_EMAIL_FOOTER . __("Don't want these emails? To unsubscribe, please contact your account administrator to turn off Email notification for you in the project level").".

        </p>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </div>
        </td>
        </tr>
        </table> 
        </body></html>";
        // echo $message;exit;
        //return $this->Sendgrid->sendEmail($from,$to,$subject,$message,$type);
        return $this->Sendgrid->sendGridEmail($from, $to, $subject, $message, $type, $fromname);
    }
}
