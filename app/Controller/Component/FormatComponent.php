<?php

App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));
use RRule\RRule;

class FormatComponent extends Component
{
    public $components = array('Session', 'Email', 'Cookie', 'Date', 'Tmzone','Postcase');

    public function SaveEventTrackUsingCURL($sessionEventName, $sessionReferName, $sessionUserID)
    {
        return true;
    }

    public function SaveLoginSessionCURL($sessionUserID, $datetime)
    {
        return true;
    }

    public function SaveLoguotSessionCURL($sessionUserID, $datetime)
    {
        return true;
    }
    function getHelpCatsCURL($id=0, $type='cat') {
        //$urlToCurl = "https://helpdesk.orangescrum.com/wp-json/taxonomies/category/terms/";
        if($type == 'cat'){ //subcat also
            $urlToCurl = "https://helpdesk.orangescrum.com/wp-json/taxonomies/category/terms/?filter[parent]=".$id;
        }else if($type == 'post'){
            $urlToCurl = "https://helpdesk.orangescrum.com/wp-json/posts/?type=post&filter[cat]=".$id."&filter[posts_per_page]=-1";
        }
        try{
            $ch = curl_init();
            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
            );
            curl_setopt($ch, CURLOPT_URL, $urlToCurl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            //curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            $server_output = curl_exec($ch);
            if (empty($server_output) || $server_output === false) {
                curl_close($ch);
                return array();
            }else{
                return $server_output;
                //$data = curl_getinfo($ch);
            }
            curl_close($ch);
        } catch (Exception $e) {
            //print $e->getMessage();exit;
            return array();
        } 
}
    public function formatTGMeta($val, $type)
    {
        if ($type == 'est') {
            if (!empty($val)) {
                if ($val > 1) {
                    //return $val.' '.__('hrs');
                    return $val;
                } else {
                    //return $val.' '.__('hr');
                    return $val;
                }
            }
            return __('--');
        } else {
            $invd_dts = array('0000-00-00',null, '1970-01-01');
            if (in_array($val, $invd_dts)) {
                return __('--');
            } else {
                return date('M d, Y', strtotime($val));
            }
        }
    }
    public function getUserTags($uids)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $uids = json_decode($uids);
        if (stristr($uids, ",")) {
            $uids = explode(',', $uids);
        }
        $usrDtls = $User->find('all', array('conditions' => array('User.id' => $uids), 'fields' => array('User.name', 'User.photo', 'User.last_name')));
         
        //we will consider photo later
        if ($usrDtls) {
            $retStr = '';
           
            foreach ($usrDtls as $k => $v) {
                // pr($uid); exit;
                $retStr .= '<span class="dtl_label_tag padrt10">'.$v['User']['name'].' '.$v['User']['last_name'].'</span>';                
            }
           
            return $retStr;
        } else {
            return __('NA');
        }
    }
    public function getUserTag($uids)
    {
        // pr($uids); exit;
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $uids = json_decode($uids);
        if (stristr($uids, ",")) {
            $uids = explode(',', $uids);
        }
        $usrDtls = $User->find('all', array('conditions' => array('User.id' => $uids), 'fields' => array('User.name','User.id', 'User.photo', 'User.last_name')));
        // pr($usrDtls);
        //we will consider photo later
        if ($usrDtls) {
            $retStr = '';
           
            foreach ($usrDtls as $k => $v) {
                $uid= $v['User']['id'];
                $retStr .= '<li  class="filter_tag remove_user_tsk_rem_td">
                <div class="ellipsis">'.$v['User']['name'].' '.$v['User']['last_name'].'</div>
                <span id="' . $uid . '" class="cursor remove_user_tsk_rem"onclick="removeUserFromReminder(this);">&times;</span>
            </li>';
                
            }
            return $retStr;
        } else {
            return __('NA');
        }
    }
    public function checkMems($project, $type)
    {
        if ($type == "uniq_id") {
            $cond = array('Project.uniq_id' => $project, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP);
        } else {
            $cond = array('Project.id' => $project, 'ProjectUser.user_id' => SES_ID, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP);
        }
        $ProjectUser = ClassRegistry::init('ProjectUser');
        $ProjectUser->unbindModel(array('belongsTo' => array('User')));
        $checkMem = $ProjectUser->find('count', array('conditions' => $cond, 'fields' => 'DISTINCT Project.id'));
        return $checkMem;
    }

    public function generateUniqNumber()
    {
        $uniq = uniqid(rand());
        return md5($uniq . time());
    }

    public function genRandomStringCustom($length = 7)
    {
        $characters = '0123456789@$abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        return $string;
    }
    /**
     * checkCsrf
     *@ added by- Swetalina
     * @param  mixed $csrf_data
     * @return void
     */
    function checkCsrf($csrf_data=null){
        if($csrf_data == $_SESSION['CSRFTOKEN']){
             return 1;
        }else{
             return 0;
        }
     }    
    /**
     * format_time_hr_min1
     * @ addedby - Swetalina
     * @param  mixed $totalsecs
     * @return void
     */
    function format_time_hr_min1($totalsecs = '') {
        $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) . " hr" . (floor($totalsecs / 3600) > 1 ? 's' : '') . " " : '';
        $mins = round(($totalsecs % 3600) / 60) > 0 ? "" . round(($totalsecs % 3600) / 60) . " min" . (round(($totalsecs % 3600) / 60) > 1 ? 's' : '') : '';
        return $hours != '' || $mins != '' ? $hours . "" . $mins : '';
    }
    public function genRandomString()
    {
        $length = 7;
        $characters = '0123456789@$abcdefghijklmnopqrstuvwxyz';
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters))];
        }
        return $string;
    }

    public function showlink($value)
    {
        $value = str_replace("a href=", "a style='text-decoration:underline;color:#066D99' target='_blank' href=", $value);
        $value = preg_replace("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", '<a href="http://\\0"target="_blank">\\0</a>', $value);
        if (stristr($value, "http://http://")) {
            $value = str_replace("http://http://", "http://", $value);
        }
        if (stristr($value, "http://http//")) {
            $value = str_replace("http://http//", "http://", $value);
        }
        if (stristr($value, "https://https://")) {
            $value = str_replace("https://https://", "https://", $value);
        }
        if (stristr($value, "https://https//")) {
            $value = str_replace("https://https//", "https://", $value);
        }
        if (stristr($value, "http://https://")) {
            $value = str_replace("http://https://", "https://", $value);
        }
        return stripslashes($value);
    }

    public function longstringwrap($string = "")
    {
        return $string;
        //return preg_replace_callback( '/\w{10,}/ ', create_function( '$matches', 'return chunk_split( $matches[0], 5, "&#8203;" );' ), $string );
    }

    public function getUserShortName($uid)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.name', 'User.short_name', 'User.photo')));
        return $usrDtls;
    }
    public function getUserFullName($uid)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.name','User.last_name', 'User.short_name', 'User.photo')));
        return $usrDtls;
    }
    public function getUserNameForEmail($uid)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid, 'User.isactive' => 1), 'fields' => array('User.name', 'User.email', 'User.id')));
        return $usrDtls;
    }

    public function getAllNotifyUser($project_id, $type = null)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        if ($type == 'new') {
            $usrDtls = $User->query("SELECT DISTINCT User.id, User.name, User.email FROM users as User,user_notifications as UserNotification,project_users as ProjectUser,company_users as CompanyUser WHERE User.id=UserNotification.user_id AND CompanyUser.user_id=UserNotification.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' AND UserNotification.new_case='1' AND User.isactive='1' AND ProjectUser.user_id=User.id AND ProjectUser.project_id='" . $project_id . "' AND ProjectUser.default_email='1'");
        } else {
            $usrDtls = $User->query("SELECT DISTINCT User.id, User.name, User.email FROM users as User,user_notifications as UserNotification,project_users as ProjectUser,company_users as CompanyUser WHERE User.id=UserNotification.user_id AND CompanyUser.user_id=UserNotification.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' AND UserNotification.reply_case='1' AND User.isactive='1' AND ProjectUser.user_id=User.id AND ProjectUser.project_id='" . $project_id . "' AND ProjectUser.default_email='1'");
        }
        return $usrDtls;
    }
    public function changeGanttData($json_arr)
    {
        //echo "<pre>";print_r($json_arr);
        $colors = array(0 => '#73BCDE', 1 => '#8BC2B9', 2 => '#F8B363', 3 => '#EA7373', 4 => '#9ECC61');
        foreach ($json_arr as $key => $value) {
            $json_arr[$key]['series'] = array();
            $json_arr[$key]['series'][0]['name'] = htmlspecialchars($value['title']);
            $json_arr[$key]['series'][0]['id'] = $value['id'];

            if ((!empty($value['gantt_start_date']) && !is_null($value['gantt_start_date']) && $value['gantt_start_date'] != '0000-00-00 00:00:00') && ($value['due_date'] != '' && !is_null($value['due_date']) && $value['due_date'] != '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);print $v['id'];echo "    1";exit;
                $json_arr[$key]['series'][0]['start'] = $value['gantt_start_date'];
                $json_arr[$key]['series'][0]['end'] = $value['due_date'];
                $json_arr[$key]['series'][0]['color'] = $colors[$key];
            } elseif ((empty($value['gantt_start_date']) || is_null($value['gantt_start_date']) || $value['gantt_start_date'] == '0000-00-00 00:00:00') && ($value['due_date'] != '' && !is_null($value['due_date']) && $value['due_date'] != '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);echo "   2";exit;
                $json_arr[$key]['series'][0]['start'] = $value['due_date'];
                $json_arr[$key]['series'][0]['end'] = $value['due_date'];
                $json_arr[$key]['series'][0]['color'] = $colors[$key];
            } elseif ((!empty($value['gantt_start_date']) && !is_null($value['gantt_start_date']) && $value['gantt_start_date'] != '0000-00-00 00:00:00') && ($value['due_date'] == '' || is_null($value['due_date']) || $value['due_date'] == '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);echo "   3";exit;
                $json_arr[$key]['series'][0]['start'] = $value['gantt_start_date'];
                $json_arr[$key]['series'][0]['end'] = date('Y-m-d', $this->dateConvertion($value['gantt_start_date']));
                $json_arr[$key]['series'][0]['color'] = $colors[$key];
            } else {
                //print_r($v['gantt_start_date']);echo "   4";exit;
                $start = explode(' ', $value['actual_dt_created']);
                $json_arr[$key]['series'][0]['start'] = $start[0];
                $json_arr[$key]['series'][0]['end'] = date('Y-m-d', $this->dateConvertion($value['actual_dt_created']));
                $json_arr[$key]['series'][0]['color'] = $colors[$key];
            }
            if ($value['legend'] == '1') {
                $json_arr[$key]['series'][0]['color'] = '#F08E83';
            } elseif ($value['legend'] == '2' || $value['legend'] == '6') {
                $json_arr[$key]['series'][0]['color'] = '#6BA8DE';
            } elseif ($value['legend'] == '5') {
                $json_arr[$key]['series'][0]['color'] = '#72CA8D';
            } elseif ($value['legend'] == '3') {
                $json_arr[$key]['series'][0]['color'] = '#FAB858';
            } else {
                $json_arr[$key]['series'][0]['color'] = '#3dbb89';
            }
            unset($json_arr[$key]['title']);
            unset($json_arr[$key]['id']);
            unset($json_arr[$key]['legend']);
            unset($json_arr[$key]['gantt_start_date']);
            unset($json_arr[$key]['due_date']);
            unset($json_arr[$key]['actual_dt_created']);
        }//exit;
        #echo "<pre>";print_r($json_arr);exit;
        return $json_arr;
    }
    public function getMemebersEmail($projId, $search)
    {
        $ProjectUser = ClassRegistry::init('ProjectUser');

        //$quickMem = $ProjectUser->find('all', array('conditions' => array('Project.uniq_id' => $projId,'Project.company_id' => SES_COMP,'User.isactive' => 1,'User.name LIKE'=>'%'.$search.'%'),'fields' => array('DISTINCT User.id','User.name','User.istype','User.email','User.short_name','User.photo'),'order' => array('User.name')));

        $quickMem = $ProjectUser->query("SELECT DISTINCT User.id, User.name, User.email, User.istype,User.email,User.short_name FROM users as User,project_users as ProjectUser,company_users as CompanyUser,projects as Project WHERE CompanyUser.user_id=ProjectUser.user_id AND CompanyUser.is_active='1' AND CompanyUser.company_id='" . SES_COMP . "' AND Project.uniq_id='" . $projId . "' AND Project.id=ProjectUser.project_id AND User.isactive='1' AND User.name LIKE '%" . $search . "%' AND ProjectUser.user_id=User.id ORDER BY User.short_name");

        return $quickMem;
    }

    public function getTypes()
    {
        $Type = ClassRegistry::init('Type');
        $quickTyp = $Type->find('all', array('order' => array('Type.seq_order')));

        return $quickTyp;
    }

    public function uploadPhoto($tmp_name, $name, $size, $path, $count, $type)
    {
        if ($name) {
            $inkb = $size / 1024;
            $oldname = strtolower($name);
            $ext = substr(strrchr($oldname, "."), 1);
            if (($ext != 'gif') && ($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'png')) {
                return "ext";
            }
            /* elseif($inkb > 1024) {
              return "size";
              } */ else {
                list($width, $height) = getimagesize($tmp_name);

                if ($width > 800) {
                    try {
                        if ($extname == "png") {
                            $src = imagecreatefrompng($tmp_name);
                        } elseif ($extname == "gif") {
                            $src = imagecreatefromgif($tmp_name);
                        } elseif ($extname == "bmp") {
                            $src = imagecreatefromwbmp($tmp_name);
                        } else {
                            $src = imagecreatefromjpeg($tmp_name);
                        }

                        $newwidth = 800;
                        $newheight = ($height / $width) * $newwidth;
                        $tmp = imagecreatetruecolor($newwidth, $newheight);

                        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

                        $newname = md5(time() . $count) . "." . $ext;
                        $targetpath = $path . $newname;

                        imagejpeg($tmp, $targetpath, 100);
                        imagedestroy($src);
                        imagedestroy($tmp);
                        // s3 bucket  start
                        $s3 = new S3(awsAccessKey, awsSecretKey);
                        //$s3->putBucket(BUCKET_NAME, S3::ACL_PUBLIC_READ_WRITE);
                        $s3->putBucket(BUCKET_NAME, S3::ACL_PRIVATE);
                        if ($type == "profile_img") {
                            $folder_orig_Name = 'files/photos/' . trim($newname);
                        } else {
                            $folder_orig_Name = 'files/company/' . trim($newname);
                        }
                        //$s3->putObjectFile($tmp_name,BUCKET_NAME ,$folder_orig_Name ,S3::ACL_PUBLIC_READ_WRITE);
                        $s3->putObjectFile($targetpath, BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
                        //s3 bucket end
                        unlink($targetpath);
                    } catch (Exception $e) {
                        return false;
                    }
                } else {
                    $newname = md5(time() . $count) . "." . $ext;
                    $targetpath = $path . $newname;
                    move_uploaded_file($tmp_name, $targetpath);
                    // s3 bucket  start
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putBucket(BUCKET_NAME, S3::ACL_PRIVATE);
                    if ($type == "profile_img") {
                        $folder_orig_Name = 'files/photos/' . trim($newname);
                    } else {
                        $folder_orig_Name = 'files/company/' . trim($newname);
                    }
                    //$folder_orig_Name = 'files/photos/'.trim($newname);
                    //$s3->putObjectFile($tmp_name,BUCKET_NAME ,$folder_orig_Name ,S3::ACL_PUBLIC_READ_WRITE);
                    $s3->putObjectFile($targetpath, BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
                    //s3 bucket end
                    unlink($targetpath);
                }

                if ($width < 200 || $height < 200) {
                    $im_P = 'convert ' . $targetpath . '  -background white -gravity center -extent 200x200 ' . $targetpath;
                    exec($im_P);
                }

                return $newname;
            }
        } else {
            return false;
        }
    }

    public function uploadProfilePhoto($name, $path)
    {
        if ($name) {
            $oldname = strtolower($name);
            $ext = substr(strrchr($oldname, "."), 1);
            if (($ext != 'gif') && ($ext != 'jpg') && ($ext != 'jpeg') && ($ext != 'png') && ($ext != 'bmp')) {
                return "ext";
            } else {
                $targetpath = $path . $name;
                $newname = $name; //md5(time().$count).".".$ext;
                if (defined('USE_S3') && USE_S3) {
                    // s3 bucket  start
                    $s3 = new S3(awsAccessKey, awsSecretKey);
                    $s3->putBucket(BUCKET_NAME, S3::ACL_PRIVATE);
                    $folder_orig_Name = 'files/photos/' . trim($newname);
                    //$s3->putObjectFile($targetpath,BUCKET_NAME ,$folder_orig_Name ,S3::ACL_PRIVATE);
                    $s3->copyObject(BUCKET_NAME, DIR_USER_PHOTOS_THUMB . trim($newname), BUCKET_NAME, $folder_orig_Name, S3::ACL_PRIVATE);
                    //s3 bucket end
                    //unlink($targetpath);
                }

                return $newname;
            }
        } else {
            return false;
        }
    }

    public function showuploadImage($tmp_name, $name, $size, $path, $count)
    {
        if ($name) {
            $image = strtolower($name);
            $extname = substr(strrchr($image, "."), 1);
            if (($extname != 'gif') && ($extname != 'jpg') && ($extname != 'jpeg') && ($extname != 'png') && ($extname != 'bmp')) {
                return false;
            } else {
                list($width, $height) = getimagesize($tmp_name);
                //$checkSize = round($size/1024);
                if (($width < 100 && $height < 100) || ($width < 100) || ($height < 100)) {
                    return 'small size image';
                } else {
                    if ($width > 200) {
                        try {
                            $type = exif_imagetype($tmp_name);
                            switch ($type) {
                                case 1:
                                    $src = imagecreatefromgif($tmp_name);
                                    break;
                                case 2:
                                    $src = imagecreatefromjpeg($tmp_name);
                                    break;
                                case 3:
                                    $src = imagecreatefrompng($tmp_name);
                                    break;
                                case 6:
                                    $src = imagecreatefromwbmp($tmp_name);
                                    break;
                                default:
                                    $src = imagecreatefromjpeg($tmp_name);
                                    break;
                            }

                            /* if($extname == "png") {
                              $src = imagecreatefrompng($tmp_name);
                              }
                              elseif($extname == "gif") {
                              $src = imagecreatefromgif($tmp_name);
                              }
                              elseif($extname == "bmp") {
                              $src = imagecreatefromwbmp($tmp_name);
                              }
                              else {
                              $src = imagecreatefromjpeg($tmp_name);
                              } */

                            $newwidth = 200;
                            $newheight = ($height / $width) * $newwidth;
                            //$newheight = 600;

                            $tmp = imagecreatetruecolor($newwidth, $newheight);

                            imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                            $time = time() . $count;
                            $filepath = md5($time) . "." . $extname;
                            $targetpath = $path . $filepath;
                            imagejpeg($tmp, $targetpath, 100);
                            imagedestroy($src);
                            imagedestroy($tmp);
                        } catch (Exception $e) {
                            return false;
                        }
                    } else {
                        $time = time() . $count;
                        $filepath = md5($time) . "." . $extname;
                        $targetpath = $path . $filepath;
                        if (!is_dir($path)) {
                            mkdir($path);
                        }
                        move_uploaded_file($tmp_name, $targetpath);
                    }
                    if (file_exists($targetpath)) {
                        return $filepath;
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    public function caseKeywordSearch($caseSrch, $type)
    {
        $searchcase = "";
        $escape = " ";
        if (trim(urldecode($caseSrch))) {
            $srchstr1 = addslashes(trim(urldecode($caseSrch)));
            if (substr($srchstr1, 0, 1) == "#") {
                $srchstr1 = substr($srchstr1, 1, strlen($srchstr1));
            } else {
                $srchstr1 = $srchstr1;
            }
            if (strpos($srchstr1, '\\') !== false) {
                $escape = " ESCAPE '~'";
            }
            if ($type == 'case_no_title') {
                $searchcase.= "AND (Easycase.title LIKE '%$srchstr1%' $escape OR Easycase.case_no LIKE '%$srchstr1%' $escape)";
            //} elseif (!preg_match('[^0-9]', $srchstr1)) { //commented Dec 21 2021
            } elseif (preg_match('/[0-9]/', $srchstr1)) {
                $searchcase = "AND (Easycase.title LIKE '%$srchstr1%' $escape OR Easycase.case_no LIKE '$srchstr1%' $escape)";
            } else {
                if (preg_match('[^A-Za-z -()@$&,]', $srchstr1) && !strstr($srchstr1, " ") && !strstr($srchstr1, "-") && !strstr($srchstr1, ",") && !strstr($srchstr1, "/") && !strstr($srchstr1, "_") && !strstr($srchstr1, "_") && !strstr($srchstr1, ":") && !strstr($srchstr1, ".") && !strstr($srchstr1, "&")) {
                    $projshortname = preg_replace("[^A-Za-z]", "", $srchstr1);
                    $caseno = preg_replace("[^0-9]", "", $srchstr1);
                    $searchcase = "AND (Easycase.case_no LIKE '$caseno%' $escape OR Easycase.title LIKE '%$srchstr1%' $escape)";
                } else {
                    if (strstr($srchstr1, " ") && $type == "full") {
                        /* $expsrch = explode(" ",$srchstr1);
                          foreach($expsrch as $newsrchstr) {
                          $searchcase.= "Easycase.title LIKE '%$newsrchstr%' OR Easycase.message LIKE '%$newsrchstr%' OR ";
                          }
                          $searchcase = substr($searchcase,0,-3);
                          $searchcase = "AND (".$searchcase.")"; */
                        $searchcase = "AND (Easycase.title LIKE '%$srchstr1%' $escape OR Easycase.message LIKE '%$srchstr1%' $escape)";
                    } elseif ($type == "half") {
                        $searchcase = "AND (Easycase.title LIKE '%$srchstr1%' $escape OR Easycase.message LIKE '%$srchstr1%' $escape)";
                    } elseif ($type == "title") {
                        $searchcase = "AND Easycase.title LIKE '%$srchstr1%' $escape";
                    } else {
                        $searchcase.= "AND (Easycase.title LIKE '%$srchstr1%' $escape OR Easycase.message LIKE '%$srchstr1%' $escape)";
                    }
                }
            }
        }
        return $searchcase;
    }

		public function defectKeywordSearch($caseSrch, $type)
    {
        $searchcase = "";
        $escape = " ";
        if (trim(urldecode($caseSrch))) {
            $srchstr1 = addslashes(trim(urldecode($caseSrch)));
            if (substr($srchstr1, 0, 1) == "#") {
                $srchstr1 = substr($srchstr1, 1, strlen($srchstr1));
            } else {
                $srchstr1 = $srchstr1;
            }
            if (strpos($srchstr1, '\\') !== false) {
                $escape = " ESCAPE '~'";
            }
            if (!preg_match('[^0-9]', $srchstr1)) {
                $searchcase = "(Easycase.title LIKE '%$srchstr1%' $escape OR Easycase.case_no LIKE '$srchstr1%' $escape OR Defect.title LIKE '%$srchstr1%' $escape OR Defect.issue_no LIKE '$srchstr1%' $escape)";
            } else {
                if (preg_match('[^A-Za-z -()@$&,]', $srchstr1) && !strstr($srchstr1, " ") && !strstr($srchstr1, "-") && !strstr($srchstr1, ",") && !strstr($srchstr1, "/") && !strstr($srchstr1, "_") && !strstr($srchstr1, "_") && !strstr($srchstr1, ":") && !strstr($srchstr1, ".") && !strstr($srchstr1, "&")) {
									$projshortname = preg_replace("[^A-Za-z]", "", $srchstr1);
									$caseno = preg_replace("[^0-9]", "", $srchstr1);
									$searchcase = "(Easycase.title LIKE '%$srchstr1%' $escape OR Easycase.case_no LIKE '$caseno%' $escape OR Defect.title LIKE '%$srchstr1%' $escape OR Defect.issue_no LIKE '$caseno%' $escape)";
                } else {
									$searchcase = "(Easycase.title LIKE '%$srchstr1%' $escape OR Defect.title LIKE '%$srchstr1%' $escape OR Defect.issue_no LIKE '$caseno%' $escape)";
                }
            }
        }
        return $searchcase;
    }
    public function statusFilter($caseStatus, $type=null, $no_brackt=0)
    {
        $qry = "";
        if (!empty($caseStatus)) {
        $caseStatus = $caseStatus . "-";
        $stsArr = explode("-", $caseStatus);
        $onlyDeflt = 0;
        $CstmStsArrLst = array();
        $CustomStatus = ClassRegistry::init('CustomStatus');
        $sts_cond = array('CustomStatus.company_id'=>SES_COMP);
        $CstmStsArrLst =  $CustomStatus->find('list', array('conditions'=>$sts_cond,'fields'=>array('CustomStatus.id','CustomStatus.name'),'order'=>array('CustomStatus.seq'=>'ASC')));
        foreach ($stsArr as $chksts) {
            if (trim($chksts)) {
                if ($type && $type == 'work_load') {
                    if ($chksts == 2) {
                        $qry.= "Easycase.legend=2 OR Easycase.legend=4 OR ";
                    } else {
                        $qry.= "Easycase.legend=" . $chksts . " OR ";
                    }
                } elseif ($chksts == "attch" || $chksts == "upd") {
                    if ($chksts == "attch") {
                        $qry.= "format=1 OR ";
                    }
                    if ($chksts == "upd") {
                        $qry.= "type_id=10 OR ";
                    }
                } elseif ($chksts == 2) {
                    $onlyDeflt = 1;
                    //$qry.= "legend=2 OR legend=4 OR ";
                    $qry.= "legend=2 OR legend=4 OR ";
                } else {
                    if (stristr($chksts, "c")) {
                        $chksts_temp = substr($chksts, 1);
                        //$qry.= "custom_status_id=".substr($chksts, 1)." OR ";
                        if (trim($chksts_temp)) {
                            if (!empty($CstmStsArrLst)) {
                                foreach ($CstmStsArrLst as $c_key => $c_val) {
                                    if (trim($c_key) == trim($chksts_temp)) {
                                        $qry.= "custom_status_id =" . $c_key . " OR ";
                                    }
                                }
                            } else {
                                $qry.= "custom_status_id =" . $chksts_temp . " OR ";
                            }
                        }
                    } else {
                        //$qry.= "legend=" . $chksts . " OR ";
                        $qry.= "legend=" . $chksts . " OR ";
                        $onlyDeflt = 1;
                    }
                }
            }
        }
        $qry = substr($qry, 0, -3);
        if ($onlyDeflt) { //added for custom sttaus
            if ($no_brackt) {
                $qry = "((" . trim($qry) . ") AND custom_status_id=0)";
            } else {
                $qry = " AND ((" . trim($qry) . ") AND custom_status_id=0)";
            }
        } else {
            if ($qry) {
                if ($no_brackt) {
                    $qry = "(" . trim($qry) . ")";
                } else {
                    $qry = " AND (" . trim($qry) . ")";
                }
            }
        }
        }
        return $qry;
    }
    public function customStatusFilter($caseCustomStatus, $type=null, $chk=0, $no_brackt=0)
    {
        #print $caseCustomStatus.'---'.$type.'---'.$chk;exit;
        $CstmStsArrLst = array();
        if (strtolower(trim($type)) == 'all') {
            $CustomStatus = ClassRegistry::init('CustomStatus');
            $sts_cond = array('CustomStatus.company_id'=>SES_COMP);
            $CstmStsArrLst =  $CustomStatus->find('list', array('conditions'=>$sts_cond,'fields'=>array('CustomStatus.id','CustomStatus.name'),'order'=>array('CustomStatus.seq'=>'ASC')));
        }
        $qry = "";
        if (!empty($caseCustomStatus)) {
        $caseCustomStatus = $caseCustomStatus . "-";
        $stsArr = explode("-", $caseCustomStatus);
        foreach ($stsArr as $chksts) {
            if (trim($chksts)) {
                if (!empty($CstmStsArrLst)) {
                    $sname = $CstmStsArrLst[$chksts];
                    foreach ($CstmStsArrLst as $c_key => $c_val) {
                        // if(trim($c_key) == trim($chksts)){
                        // 	$qry.= "custom_status_id =" . $c_key . " OR ";
                        // }
                        if (strtolower($sname) == strtolower($c_val)) {
                            $qry.= "custom_status_id =" . $c_key . " OR ";
                        }
                    }
                } else {
                    $qry.= "custom_status_id =" . $chksts . " OR ";
                }
            }
        }
        $qry = substr($qry, 0, -3);
        if (strtolower(trim($type)) == 'all' && (trim($chk) && $chk != "all")) {
            if ($qry) {
                if ($no_brackt) {
                    $qry = "(" . trim($qry) . ")";
                } else {
                    $qry = " OR (" . trim($qry) . ")";
                }
            }
        } else {
            if ($qry) {
                if ($no_brackt) {
                    $qry = "(" . trim($qry) . ")";
                } else {
                    $qry = " AND (" . trim($qry) . ")";
                }
            }
        }
        }
        return $qry;
    }

    public function typeFilter($caseTypes)
    {
        $qry = "";
        $qryTyp = "";
        if ($caseTypes != "all") {
            if (strstr($caseTypes, "-")) {
                $typArr = explode("-", $caseTypes);
                foreach ($typArr as $typChk) {
                    $qryTyp.="Easycase.type_id=" . $typChk . " OR ";
                }
                $qryTyp = substr($qryTyp, 0, -3);
                $qry.=" AND (" . $qryTyp . ")";
            } else {
                $qry.=" AND Easycase.type_id=" . $caseTypes;
            }
        }
        return $qry;
    }
    public function labelFilter($caseLabel, $curProjId, $comp_id, $ses_type, $ses_id)
    {
        $qry = "";
        $qryTyp = "";
        if (!empty($caseLabel) && $caseLabel != "all") {
            $easyc_clslbl = ClassRegistry::init('EasycaseLabel');
            $Label = ClassRegistry::init('Label');
            $caseLabel = trim($caseLabel, '-');
            if (strstr($caseLabel, "-")) {
                $lblArr = explode("-", $caseLabel);
            } else {
                $lblArr = array($caseLabel);
            }
            $lblArr_new = $lblArr;
            foreach ($lblArr as $k=>$v) {
                $Label_dtls = $Label->findById($v);
                $get_lbl_list = $Label->find('all', array('conditions'=>array('Label.lbl_title' => $Label_dtls['Label']['lbl_title'])));
                foreach ($get_lbl_list as $k1 => $v1) {
                    if ($v1['Label']['id'] != $v) {
                        array_push($lblArr_new, $v1['Label']['id']);
                    }
                }
            }
            if (!$curProjId || $curProjId == 'all') {
                $ProjectUser_clslbl = ClassRegistry::init('ProjectUser');
                $al_actvs = $ProjectUser_clslbl->getAllActiveProject($ses_id, $comp_id, $ses_type);
                if ($al_actvs) {
                    $al_actvs = Hash::extract($al_actvs, '{n}.ProjectUser.project_id');
                
                $lbl_qry = $easyc_clslbl->find('all', array('conditions' => array('EasycaseLabel.company_id' => $comp_id, 'EasycaseLabel.project_id' => $al_actvs, 'EasycaseLabel.label_id' => $lblArr_new),'fields'=>array('EasycaseLabel.id','EasycaseLabel.easycase_id'),'order' => 'EasycaseLabel.id DESC'));
            } else {
                    $lbl_qry = '';
                }
            } else {
                $lbl_qry = $easyc_clslbl->find('all', array('conditions' => array('EasycaseLabel.company_id' => $comp_id, 'EasycaseLabel.project_id' => $curProjId, 'EasycaseLabel.label_id' => $lblArr_new),'fields'=>array('EasycaseLabel.id','EasycaseLabel.easycase_id'),'order' => 'EasycaseLabel.id DESC'));
            }
            if (!empty($lbl_qry)) {
                $eids_lbl = Hash::extract($lbl_qry, '{n}.EasycaseLabel.easycase_id');
                $qry = " AND Easycase.id IN(".implode(',', $eids_lbl).")";
            } else {
                $qry = " AND Easycase.id =0";
            }
        }
        return $qry;
    }
    public function projectFilter($prjid)
    {
        $qry = "";
        $qryTyp = "";
        if ($prjid != "all") {
            if (strstr($prjid, "-")) {
                $typArr = explode("-", $prjid);
                //foreach ($typArr as $typChk) {
                if (!empty($typArr)) {
                    $typ = implode(",", $typArr);
                    $qry.="AND Easycase.project_id IN (" . $typ . ")";
                }
                //}
                //$qryTyp = substr($qryTyp, 0, -3);
                //$qry.=" AND (" . $qryTyp . ")";
            } else {
                $qry.=" AND Easycase.project_id=" . $prjid;
            }
        }
        return $qry;
    }
    public function arcDateFiltxt($duedate)
    {
        if (!empty($duedate)) {
            if ($duedate == 'today') {
                $txt = 'Today';
            } elseif ($duedate == 'yesterday') {
                $txt = 'Yesterday';
            } elseif ($duedate == 'thisweek') {
                $txt = 'This Week';
            } elseif ($duedate == 'thismonth') {
                $txt = 'This Month';
            } elseif ($duedate == 'thisquarter') {
                $txt = 'This Quarter';
            } elseif ($duedate == 'thisyear') {
                $txt = 'This Year';
            } elseif ($duedate == 'lastyear') {
                $txt = 'Last Year';
            } elseif ($duedate == 'lastweek') {
                $txt = 'Last Week';
            } elseif ($duedate == 'lastmonth') {
                $txt = 'Last Month';
            } elseif ($duedate == 'lastquarter') {
                $txt = 'Last Quarter';
            } elseif ($duedate == 'last365days') {
                $txt = 'Last 365 Days';
            } else {
                $txt = '';
            }
        }
        return $txt;
    }

    public function formatprjnm($prjid)
    {
        $prj = ClassRegistry::init('Project');
        //$prjsname = $prj->find('fisrt', array('conditions'=>array('Project.id'=>$prjid, 'Project.company_id'=>SES_COMP), 'fields'=>array('Project.short_name')));
        $prjsname = $prj->query("SELECT Project.short_name FROM projects AS Project WHERE Project.id=" . $prjid . " AND Project.company_id=" . SES_COMP . "");
        return $prjsname['0']['Project']['short_name'];
    }

    public function arcUserFilter($usrid, $type = null)
    {
        $qry = "";
        $qryTyp = "";
        if (!empty($usrid) && $usrid != "all") {
            if (strstr($usrid, "-")) {
                $typArr = explode("-", $usrid);
                foreach ($typArr as $typChk) {
                    if ($type == 'utilization') {
                        $qryTyp.="LogTime.user_id=" . $typChk . " OR ";
                    } elseif ($type == 'invoice') {
                        $qryTyp.="LogTime.user_id=" . $typChk . " OR ";
                    } elseif ($type == 'work_load') {
                        $qryTyp.="Easycase.assign_to=" . $typChk . " OR ";
                    } elseif ($type == 'pending') {
                        $qryTyp.=" Easycase.assign_to=" . $typChk . " OR ";
                    } else {
                        $qryTyp.="Archive.user_id=" . $typChk . " OR ";
                    }
                }
                $qryTyp = substr($qryTyp, 0, -3);
                if ($type != 'invoice') {
                    $qry.=" AND (" . $qryTyp . ")";
                } else {
                    $qry.=" (" . $qryTyp . ")";
                }
            } else {
                if ($type == 'utilization') {
                    $qry.=" AND LogTime.user_id=" . $usrid;
                } elseif ($type == 'invoice') {
                    $qry.="LogTime.user_id=" . $usrid;
                } elseif ($type == 'work_load') {
                    $qry.="Easycase.assign_to=" . $usrid;
                } elseif ($type == 'pending') {
                    $qry.=" AND Easycase.assign_to=" . $usrid;
                } else {
                    $qry.=" AND Archive.user_id=" . $usrid;
                }
            }
        }
        return $qry;
    }
    public function arcLabelFilter($labelid, $type = null)
    {
        $qry = "";
        $qryTyp = "";
        if (!empty($labelid) && $labelid != "all") {
            if (strstr($labelid, "-")) {
                $typArr = explode("-", $labelid);
                foreach ($typArr as $typChk) {
                    if ($type == 'utilization') {
                        $qryTyp.=" EasycaseLabel.label_id=" . $typChk . " OR ";
                    }
                }
                $qryTyp = substr($qryTyp, 0, -3);
                $qry.=" AND (" . $qryTyp . ")";
            } else {
                $qry.=" AND EasycaseLabel.label_id=" . $labelid;
            }
        }
        return $qry;
    }
    public function arcBillabilityFilter($billabilityid, $type = null)
    {
        $qry = "";
        $qryTyp = "";
        if (!empty($billabilityid) && $billabilityid != "all") {
            if (strstr($billabilityid, "-")) {
                $typArr = explode("-", $billabilityid);
                foreach ($typArr as $typChk) {
                    if ($type == 'utilization') {
                        $typChk1  = ($typChk == 'billable')?1:0;
                        $qryTyp.=" LogTime.is_billable=" . $typChk1 . " OR ";
                    }
                }
                $qryTyp = substr($qryTyp, 0, -3);
                $qry.=" AND (" . $qryTyp . ")";
            } else {
                $billabilityid  = ($billabilityid == 'billable')?1:0;
                $qry.=" AND LogTime.is_billable=" . $billabilityid;
            }
        }
        return $qry;
    }

    public function priorityFilter($priorityFil, $caseTypes)
    {
        $qry = "";
        $qryPri = "";
        if (!empty($priorityFil) && $priorityFil != "all") {
            if (strstr($priorityFil, "-")) {
                $priArr = explode("-", $priorityFil);
                foreach ($priArr as $priChk) {
                    if ($priChk) {
                        if ($priChk == "High") {
                            $qryPri.= "Easycase.priority=0 OR ";
                        } elseif ($priChk == "Medium") {
                            $qryPri.= "Easycase.priority=1 OR ";
                        } else {
                            $qryPri.= "Easycase.priority>=2 OR ";
                        }
                    }
                }
                $qryPri = substr($qryPri, 0, -3);
                $qry.=" AND (" . $qryPri . ")";
            } else {
                if ($priorityFil == "High") {
                    $qry.= " AND Easycase.priority=0";
                } elseif ($priorityFil == "Medium") {
                    $qry.= " AND Easycase.priority=1";
                } else {
                    $qry.= " AND Easycase.priority>=2";
                }
            }
            if ($caseTypes != 10) {
                $qry.= " AND type_id != 10";
            }
        }
        return $qry;
    }

    public function memberFilter($caseUserId)
    {
        $qry = "";
        $qryMem = "";
        if (!empty($caseUserId) && $caseUserId != "all") {
            if (strstr($caseUserId, "-")) {
                $memArr = explode("-", $caseUserId);
                foreach ($memArr as $memChk) {
                    $qryMem.= "Easycase.user_id=" . $memChk . " OR ";
                }
                $qryMem = substr($qryMem, 0, -3);
                $qry.=" AND (" . $qryMem . ")";
            } else {
                $qry.= " AND Easycase.user_id=" . $caseUserId;
            }
        }
        return $qry;
    }
    public function commentFilter($caseUserId, $curProjId = null, $case_date= null)
    {
        $qry = $qry1= "";
        $arr = [];
        $prj_ids = [];
        $upd_ids = [];
        if (!empty($caseUserId) && $caseUserId != "all") {
            if (strstr($caseUserId, "-")) {
                $memArr = explode("-", $caseUserId);
                foreach ($memArr as $memChk) {
                    $arr[]=$memChk;
                }
            } else {
                $arr[]= $caseUserId;
            }
            /* date condition for comments */
            if ($case_date && trim($case_date) !='') {
                $frmTz = '+00:00';
                $toTz = $this->Tmzone->getGmtTz(TZ_GMT, TZ_DST);
                $GMT_DATE =$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");

                if (trim($case_date) == 'one') {
                    $one_date = date('Y-m-d H:i:s', strtotime($GMT_DATE) - 3600);
                    $qry1.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $one_date . "'";
                } elseif (trim($case_date) == '24') {
                    $filterenabled = 1;
                    $day_date = date("Y-m-d H:i:s", strtotime($GMT_DATE. " -1 day"));
                    $qry1.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $day_date . "'";
                } elseif (trim($case_date) == 'week') {
                    $filterenabled = 1;
                    $week_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 week"));
                    $qry1.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $week_date . "'";
                } elseif (trim($case_date) == 'month') {
                    $filterenabled = 1;
                    $month_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 month"));
                    $qry1.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $month_date . "'";
                } elseif (trim($case_date) == 'year') {
                    $filterenabled = 1;
                    $year_date = date("Y-m-d H:i:s", strtotime($GMT_DATE . " -1 year"));
                    $qry1.= " AND CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."') >='" . $year_date . "'";
                } elseif (strstr(trim($case_date), "_")) {
                    $filterenabled = 1;
                    $ar_dt = explode("_", trim($case_date));
                    $frm_dt = $ar_dt['0'];
                    $to_dt = $ar_dt['1'];
                    $qry1.= " AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) >= '" . date('Y-m-d', strtotime($frm_dt)) . "' AND DATE(CONVERT_TZ(Easycase.dt_created,'".$frmTz."','".$toTz."')) <= '" . date('Y-m-d', strtotime($to_dt)) . "'";
                }
            }
            /* End */

            if (count($arr) > 0) {
                if (empty($curProjId) && (SES_COMP == 25814 || SES_COMP == 28528)) { //jayan
                    $sql = "select DISTINCT Easycase.case_no,Easycase.project_id,Easycase.updated_by from easycases as Easycase where Easycase.istype='2' and Easycase.isactive='1' AND Easycase.user_id IN(" . implode(',', $arr) . ") $qry1 AND Easycase.project_id IN (SELECT ProjectUser.project_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND ProjectUser.company_id='" . SES_COMP . "') AND Easycase.project_id!=0";
                } else {
                    $sql = "select DISTINCT Easycase.case_no from easycases as Easycase where Easycase.istype='2' and Easycase.isactive='1' AND Easycase.user_id IN(" . implode(',', $arr) . ") AND Easycase.project_id='" . $curProjId . "' $qry1 AND Easycase.project_id!=0";
                }
                #print $sql;exit;
                $easyc_cls = ClassRegistry::init('Easycase');
                $q = $easyc_cls->query($sql);
                                
                $n_qry = '';
                                
                if (count($q)) {
                    $s=array();
                    foreach ($q as $k=>$v) {
                        $s[]=$v['Easycase']['case_no'];
                        if (isset($v['Easycase']['project_id'])) {
                            $prj_ids[] = $v['Easycase']['project_id'];
                            if ($n_qry == '') {
                                $n_qry = "(Easycase.case_no = ".$v['Easycase']['case_no']." AND Easycase.project_id=".$v['Easycase']['project_id'].")";
                            } else {
                                $n_qry .= " OR (Easycase.case_no = ".$v['Easycase']['case_no']." AND Easycase.project_id=".$v['Easycase']['project_id'].")";
                            }
                            if (!empty($v['Easycase']['updated_by'])) {
                                $upd_ids[] = $v['Easycase']['updated_by'];
                            }
                        }
                    }
                    /*if(isset($v['Easycase']['project_id'])){
                        $qry = "Easycase.case_no IN(" . implode(',', $s) . ")";
                    }else{*/
                    $qry= " AND Easycase.case_no IN(" . implode(',', $s).")";
                //}
                } else {
                    /*if(isset($v['Easycase']['project_id'])){
                    $qry = "Easycase.case_no IN(0)";
                    }else{*/
                    $qry= " AND Easycase.case_no IN(0)";
                    //}
                }
                if ((SES_COMP == 25814 || SES_COMP == 28528) && $prj_ids) { //jayan
                    $qry = "AND (".$n_qry.")";
                    /*if(!empty($upd_ids)){
                        $qry .= " AND Easycase.updated_by IN(" . implode(',', $upd_ids) . ")";
                    }else{
                        $qry .= " AND Easycase.updated_by IN(" . implode(',', $arr) . ")";
                    }*/
                }
            }
        }
        return $qry;
    }

    public function caseTaskGroupFilter($caseTgId, $curProjId = null, $case_date= null)
    {
        $easycaseModel = ClassRegistry::init('Easycase');
            
        $qry = $this->taskgroupFilter($caseTgId);
        if ($qry == '' || $curProjId == 'all') {
            return $qry;
        }
        $final_qry = '';
        $sql = 'SELECT 
								Easycase.id,
								EasycaseMilestone.id,
								EasycaseMilestone.milestone_id  
							FROM easycases Easycase 
							LEFT JOIN easycase_milestones EasycaseMilestone ON Easycase.id=EasycaseMilestone.easycase_id 
							WHERE Easycase.project_id='.$curProjId.$qry;
        $res = $easycaseModel->query($sql);
            
        if (count($res)) {
            $task_ids = Hash::extract($res, '{n}.Easycase.id');
            $final_qry = " AND Easycase.id IN(" . implode(',', $task_ids) . ") ";
        }
            
        return $final_qry;
    }
    public function taskgroupFilter($caseTaskgroup)
    {
        $qry = "";
        $qrygroup = "";
        if (!empty($caseTaskgroup) && $caseTaskgroup != "all") {
            if (strstr($caseTaskgroup, "-")) {
                $groupArr = explode("-", $caseTaskgroup);
                foreach ($groupArr as $groupChk) {
                    if ($groupChk == 'default') {
                        $qrygroup.= "EasycaseMilestone.milestone_id IS NULL ". " OR ";
                    } else {
                        $qrygroup.= "EasycaseMilestone.milestone_id=" . $groupChk . " OR ";
                    }
                }
                $qrygroup = substr($qrygroup, 0, -3);
                $qry.=" AND (" . $qrygroup . ")";
            } else {
                if (strtolower($caseTaskgroup) == "default") {
                    $qry.= " AND EasycaseMilestone.milestone_id IS NULL ";
                } else {
                    $qry.= " AND EasycaseMilestone.milestone_id=" . $caseTaskgroup;
                }
            }
        }
        return $qry;
    }
    public function assigntoFilter($caseAssignTo)
    {
        $qry = "";
        $qryAsn = "";
        if (!empty($caseAssignTo) && $caseAssignTo != "all") {
            if (strstr($caseAssignTo, "-")) {
                $asnArr = explode("-", $caseAssignTo);
                foreach ($asnArr as $asnChk) {
                    $qryAsn.= "Easycase.assign_to=" . $asnChk . " OR ";
                }
                $qryAsn = substr($qryAsn, 0, -3);
                $qry.=" AND (" . $qryAsn . ")";
            } else {
                if (strtolower($caseAssignTo) == "unassigned") {
                    $caseAssignTo = 0;
                }
                $qry.= " AND Easycase.assign_to=" . $caseAssignTo;
            }
        }
        return $qry;
    }

    public function filterMilestone($milestoneUid = '')
    {
        if ($milestoneUid) {
            $mlst_cls = ClassRegistry::init('Milestone');
            $mlist = $mlst_cls->find('first', array('conditions' => array('Milestone.uniq_id' => $milestoneUid), 'fields' => 'Milestone.id,Milestone.title'));
            return ' AND EasycaseMilestone.milestone_id=' . $mlist['Milestone']['id'];
        } else {
            return '';
        }
    }

    public function find_file($dirname, $fname, &$file_path)
    {
        if (file_exists($dirname . $fname)) {
            return $dirname . $fname;
        } else {
            return false;
        }
    }

    public function emailBodyFilter($value)
    {
        $pattern = array("/\n/", "/\r/", "/content-type:/i", "/to:/i", "/from:/i", "/cc:/i");
        $value = preg_replace($pattern, "", $value);
        return $value;
    }

    public function validateEmail($email)
    {
        $at = strrpos($email, "@");
        if ($at && ($at < 1 || ($at + 1) == strlen($email))) {
            return false;
        }
        if (preg_match("/(\.{2,})/", $email)) {
            return false;
        }
        $local = substr($email, 0, $at);
        $domain = substr($email, $at + 1);
        $locLen = strlen($local);
        $domLen = strlen($domain);
        if ($locLen < 1 || $locLen > 64 || $domLen < 4 || $domLen > 255) {
            return false;
        }
        if (preg_match("/(^\.|\.$)/", $local) || preg_match("/(^\.|\.$)/", $domain)) {
            return false;
        }
        if (!preg_match('/^"(.+)"$/', $local)) {
            if (!preg_match('/^[-a-zA-Z0-9!#$%*\/?|^{}`~&\'+=_\.]*$/', $local)) {
                return false;
            }
        }
        if (!preg_match("/^[-a-zA-Z0-9\.]*$/", $domain) || !strpos($domain, ".")) {
            return false;
        }
        return true;
    }

    public function generatePassword($length)
    {
        $vowels = 'aeuy';
        $consonants = '3@Z6!29G7#$QW4';
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

    public function generateTemporaryURL($resource, $bkt_name = null)
    {
        $bucketname = BUCKET_NAME;
        if ($bkt_name) {
            $bucketname = $bkt_name;
        }
        $awsAccessKey = awsAccessKey;
        $awsSecretKey = awsSecretKey;
        $expires = strtotime('+1 day'); //1.day.from_now.to_i;
        $s3_key = explode($bucketname, $resource);
        $x = $s3_key[1];
        $s3_key[1] = substr($x, 1);
        $string = "GET\n\n\n{$expires}\n/{$bucketname}/{$s3_key[1]}";
        $signature = urlencode(base64_encode((hash_hmac("sha1", utf8_encode($string), $awsSecretKey, true))));
        //echo $expires."=====";echo $signature;
        return "{$resource}?AWSAccessKeyId={$awsAccessKey}&Signature={$signature}&Expires={$expires}";
    }

    public function downloadFile($filename, $chk = null)
    {
        set_time_limit(0);
        #error_reporting(0);
        if (!isset($filename) || empty($filename)) {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 14px verdana;color:#FF0000;' align='center'>Please specify a file name for download.</td></tr></table>";
            die($var);
        }
        if (defined('USE_S3') && USE_S3 == 1) {
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $info = $s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER . $filename);
        } elseif (file_exists(DIR_CASE_FILES . $filename)) {
            $info = 1;
        } elseif (file_exists(HTTP_DEFECT_ROOT_FILES . $filename)) {
            $info1 = 1;
        } 
        if ($info) {
            if (defined('USE_S3') && USE_S3 == 1) {
                $fileurl = $this->generateTemporaryURL(DIR_CASE_FILES_S3 . $filename);
            } else {
                $fileurl = DIR_CASE_FILES . $filename;
            }
            $file_path = $fileurl;
        } elseif($info1){
            if (defined('USE_S3') && USE_S3 == 1) {
                $fileurl = $this->generateTemporaryURL(DIR_CASE_FILES_S3 . $filename);
            } else {
                $fileurl = HTTP_DEFECT_ROOT_FILES . $filename;
            }
            $file_path = $fileurl;
        } else {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 12px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
            die($var);
        }
        /* Figure out the MIME type | Check in array */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain"
        );
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        }
        // Send file headers
        ////ob_clean();
        $chk = str_ireplace(" ", "", $chk);
        header("Content-type: $mime_type");
        header("Content-Disposition: attachment;filename=$chk");
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile($file_path);
    }

    public function downloadTMpFile($filename)
    {
        set_time_limit(0);
        if (!isset($filename) || empty($filename)) {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 14px verdana;color:#FF0000;' align='center'>Please specify a file name for download.</td></tr></table>";
            die($var);
        }
        if (defined('USE_S3') && USE_S3 == 1) {
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $info = $s3->getObjectInfo(BUCKET_NAME, DIR_CASE_FILES_S3_FOLDER_TEMP . $filename);
        } elseif (file_exists(DIR_CASE_FILES . 'temp/' . $filename)) {
            $info = 1;
        }
        if ($info) {
            if (defined('USE_S3') && USE_S3 == 1) {
                $fileurl = $this->generateTemporaryURL(DIR_CASE_FILES_S3 . 'temp/' . $filename);
            } else {
                $fileurl = DIR_CASE_FILES . 'temp/' . $filename;
            }
            $file_path = $fileurl;
        } else {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 12px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
            die($var);
        }
        /* Figure out the MIME type | Check in array */
        $known_mime_types = array(
            "pdf" => "application/pdf",
            "txt" => "text/plain",
            "html" => "text/html",
            "htm" => "text/html",
            "exe" => "application/octet-stream",
            "zip" => "application/zip",
            "doc" => "application/msword",
            "xls" => "application/vnd.ms-excel",
            "ppt" => "application/vnd.ms-powerpoint",
            "gif" => "image/gif",
            "png" => "image/png",
            "jpeg" => "image/jpg",
            "jpg" => "image/jpg",
            "php" => "text/plain"
        );
        $file_extension = strtolower(substr(strrchr($filename, "."), 1));
        if (array_key_exists($file_extension, $known_mime_types)) {
            $mime_type = $known_mime_types[$file_extension];
        } else {
            $mime_type = "application/force-download";
        };
        // Send file headers
        //ob_clean();
        $chk = str_ireplace(" ", "", $chk);
        header("Content-type: $mime_type");
        header("Content-Disposition: attachment;filename=$chk");
        header('Pragma: no-cache');
        header('Expires: 0');
        readfile($file_path);
    }

    public function getReplacedStrng($str='')
    {
        if (trim($str) != '') {
            return str_ireplace("''", "'", str_ireplace('"', "'", html_entity_decode(trim($str), ENT_QUOTES, 'UTF-8')));
        }
        return trim($str);
    }
    public function stripHtml($str='')
    {
        if (trim($str) != '') {
            return htmlspecialchars_decode(strip_tags($str));
        }
        return trim($str);
    }
    public function downloadFile1($filename)
    {
        set_time_limit(0);
        if (!isset($filename) || empty($filename)) {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 14px verdana;color:#FF0000;' align='center'>Please specify a file name for download.</td></tr></table>";
            die($var);
        }

        if (strpos($filename, "\0") !== false) {
            die('');
        }
        $fname = basename($filename);

        if (file_exists(DIR_CASE_FILES . $fname)) {
            $file_path = DIR_CASE_FILES . $fname;
        } else {
            $var = "<table align='center' width='100%'><tr><td style='font:bold 12px verdana;color:#FF0000;' align='center'>Oops! File not found.<br/> File may be deleted or make sure you specified correct file name.</td></tr></table>";
            die($var);
        }
        $fsize = filesize($file_path);

        $fext = strtolower(substr(strrchr($fname, "."), 1));

        if (!isset($_GET['fc']) || empty($_GET['fc'])) {
            $asfname = $fname;
        } else {
            $asfname = str_replace(array('"', "'", '\\', '/'), '', $_GET['fc']);
            if ($asfname === '') {
                $asfname = 'NoName';
            }
        }

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Type: ");
        header("Content-Disposition: attachment; filename=\"$asfname\"");
        header("Content-Transfer-Encoding: binary");
        header("Content-Length: " . $fsize);

        $file = @fopen($file_path, "rb");
        if ($file) {
            while (!feof($file)) {
                print(fread($file, 1024 * 8));
                flush();
                if (connection_status() != 0) {
                    @fclose($file);
                    die();
                }
            }
            @fclose($file);
        }
    }

    public function chnageUploadedFileName($filename)
    {
        //commented because: creating problem for korean languange
        //$output = preg_replace('/[^(\x20-\x7F)]*/','', $filename);
        $output = $filename;
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
        $rep29 = str_replace("�", "_", $rep28);
        $rep30 = str_replace("�", "_", $rep29);
        $rep31 = str_replace("(", "_", $rep30);
        $rep32 = str_replace(")", "_", $rep31);
        return $rep32;
    }

    public function validateFileExt($ext, $typChk=0)
    {
        //$extList = array("bat","com","cpl","dll","exe","msi","msp","pif","shs","sys","cgi","reg","bin","torrent","yps","mp4","mpeg","mpg","3gp","dat","mod","avi","flv","xvid","scr","com","pif","chm","cmd","cpl","crt","hlp","hta","inf","ins","isp","jse?","lnk","mdb","ms","pcd","pif","scr","sct","shs","vb","ws","vbs","mp3","wav");
        $extList = array("php","htaccess","bat", "com", "cpl", "dll", "exe", "msi", "msp", "pif", "shs", "sys", "cgi", "reg", "bin", "torrent", "yps", "mpg", "dat", "xvid", "scr", "com", "pif", "chm", "cmd", "cpl", "crt", "hlp", "hta", "inf", "ins", "isp", "jse?", "lnk", "mdb", "ms", "pcd", "pif", "scr", "sct", "shs", "vb", "ws", "vbs","bat","sh");

        $onlyIngExt = array("jpeg","jpg","png");
        //will consider later ico, bmp, gif, psd, svg etc

        $ext = strtolower($ext);
        if ($typChk) {
            if (in_array($ext, $onlyIngExt)) {
                return "success";
            } else {
                return "." . $ext;
            }
        } elseif (!in_array($ext, $extList)) {
            return "success";
        } else {
            //alert("Invalid input file format! Should be txt, doc, docx, xls, xlsx, pdf, odt, ppt, jpeg, tif, gif, psd, jpg or png");
            return "." . $ext;
        }
    }

    public function todo_typ($type, $title)
    {
        $disp_type = '<img src="' . HTTP_IMAGES . 'images/types/' . $type . '.png" title="' . $title . '" alt="' . $type . '" rel="tooltip"/>';
        return $disp_type;
    }

    public function formatText($value, $type = null)
    {
        $value = str_replace("�", "\"", $value);
        $value = str_replace("�", "\"", $value);
        if (!$type) {
            $value = preg_replace('/[^(\x20-\x7F)\x0A]*/', '', $value);
        }
        $value = stripslashes($value);
        $value = html_entity_decode($value, ENT_QUOTES);
        $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
        $value = strtr($value, $trans);
        $value = stripslashes(trim($value));
        return $value;
    }

    public function chgdate($val)
    {
        $dt = explode("/", $val);
        $dateformat = $dt['2'] . "-" . $dt['0'] . "-" . $dt['1'];
        return $dateformat;
    }

    public function dateFormatReverse($output_date)
    {
        if ($output_date != "") {
            if (strstr($output_date, " ")) {
                $exp = explode(" ", $output_date);
                $od = $exp[0];
                $date_ex2 = explode("-", $od);
                $dateformated_input = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0] . " " . $exp[1];
            } else {
                $exp = explode("-", $output_date);
                $dateformated_input = $exp[1] . "/" . $exp[2] . "/" . $exp[0];
            }
            return $dateformated_input;
        }
    }

    public function makeSeoUrl($url, $type=0)
    {
        if ($url) {
            $url = trim(strtolower($url));
            $url = str_replace(' ', '', $url); // Replaces all spaces .
            $value = preg_replace('/[^A-Za-z0-9\-]/', '', $url); // Removes special chars.
            //$value = preg_replace("![^a-z0-9]+!i", "", $url);
            $url = trim($value);
        }
        if ($type && strlen($url) > 20) {
            $url = substr($url, 0, 20);
        }
        return $url;
    }

    public function makeShortName($first, $last)
    {
        if (stristr($first, " ")) {
            $firstexp = explode(" ", $first);
            $let1 = substr($firstexp[0], 0, 1);
            $let2 = substr($firstexp[1], 0, 1);
        } else {
            $let1 = substr($first, 0, 2);
        }
        $let3 = substr($last, 0, 1);

        return strtoupper($let1 . $let2 . $let3);
    }

    public function displayStatus($st)
    {
        if ($st == 1) {
            $status = "New";
        } elseif ($st == 2) {
            $status = "In Progress";
        } elseif ($st == 3) {
            $status = "Closed";
        } elseif ($st == 4) {
            $status = "Started";
        } elseif ($st == 5) {
            $status = "Resolved";
        } elseif ($st == "hctta") {
            $status = "Files";
        } elseif ($st == "dpu") {
            $status = "Updates";
        } elseif (stristr($st, 'c')) {
            $status = $this->displayCustomStatus(substr($st, 1));
        } elseif ($st >= 20) {
            $status = $this->displayCustomStatus($st);
        } else {
            $status = "All";
        }
        return $status;
    }

    public function displayCustomStatus($st)
    {
        $CustomStatus = ClassRegistry::init('CustomStatus');
        $res = $CustomStatus->find('first', array('conditions'=>array('CustomStatus.id'=>$st),'fields'=>array('CustomStatus.name')));
        return !empty($res['CustomStatus']['name'])?$res['CustomStatus']['name']:'All';
    }
    public function caseBcMems($uid)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid, 'User.isactive' => 1), 'fields' => array('User.short_name')));
        return $usrDtls['User']['short_name'];
    }

    public function caseMemsList($uid)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('list', array('conditions' => array('User.id' => $uid, 'User.isactive' => 1), 'fields' => array('User.short_name')));
        if (count($usrDtls) == 1) {
            $memlist = array_values($usrDtls);
            return $memlist[0];
        } else {
            return $usrDtls;
        }
    }
    public function caseGroupsList($uid)
    {
        if ($uid =='default') {
            return array('default'=>__("Default Task Group", true));
        } else {
            $Milestone = ClassRegistry::init('Milestone');
            $Milestone->recursive = -1;
            $mileDtls = $Milestone->find('list', array('conditions' => array('Milestone.id' => $uid), 'fields' => array('Milestone.title')));
            // if (count($mileDtls) == 1) {
            //     $milelist = array_values($mileDtls);
            //     return $milelist[0];
            // } else {
            return $mileDtls;
            //}
        }
    }
    public function caseLabelList($uid)
    {
        $Label = ClassRegistry::init('Label');
        $Label->recursive = -1;
        $labelDtls = $Label->find('list', array('conditions' => array('Label.id' => $uid, 'Label.is_active' => 1), 'fields' => array('Label.lbl_title')));
        if (count($labelDtls) == 1) {
            $labellist = array_values($labelDtls);
            return $labellist[0];
        } else {
            return $labelDtls;
        }
    }
    public function caseBillabilityList($uid)
    {
        if ($uid =='billable') {
            $labellist = 'Billable';
        } else {
            $labellist = 'Unbillable';
        }
        return $labellist;
    }

    public function caseBcTypes($typ)
    {
        if (strlen($typ) == 2 && $typ == 01) {
            $typ = 10;
        }
        $Type = ClassRegistry::init('Type');
        $cstype = $Type->find('first', array('conditions' => array('Type.id' => $typ), 'fields' => array('Type.short_name')));
        return $cstype['Type']['short_name'];
    }

    public function caseBcLabels($lbl)
    {
        $Label = ClassRegistry::init('Label');
        $csLabel = $Label->find('first', array('conditions' => array('Label.id' => $lbl), 'fields' => array('Label.lbl_title')));
        return $csLabel['Label']['lbl_title'];
    }
    public function fullSpace($used, $totalsize = 1024)
    {
        $full = $used > 0 ? $used * 100 / $totalsize : 0;
        $used = round($full, 1);
        return $used;
    }

    public function usedSpace($curProjId = null, $company_id = SES_COMP, $typeChk=0)
    {
        $CaseFiles = ClassRegistry::init('CaseFiles');
        $this->recursive = -1;
        $cond = " 1 ";
        $cond_n = " 1 ";
        if ($company_id) {
            $cond .=" AND CaseFile.company_id=" . $company_id;
            $cond_n .=" AND CaseEditorFile.company_id=" . $company_id;
        }
        if ($curProjId) {
            $cond .=" AND CaseFile.project_id=" . $curProjId;
            $cond_n .=" AND CaseEditorFile.project_id=" . $curProjId;
        }
        $sql = "SELECT SUM(file_size) AS file_size  FROM case_files AS CaseFile  WHERE " . $cond;
        $res1 = $CaseFiles->query($sql);
        $filesize = $res1['0']['0']['file_size'] / 1024;
            
        $CaseEditorFile = ClassRegistry::init('CaseEditorFile');
        $CaseEditorFile->recursive = -1;
        $sql_n = "SELECT SUM(file_size) AS file_size FROM case_editor_files as CaseEditorFile WHERE " . $cond_n;
        $res_n = $CaseEditorFile->query($sql_n);
        $filesize_n = $res_n['0']['0']['file_size'] / 1024;
            
        $tot_size = $filesize_n+$filesize;
        if (empty($tot_size)) {
            return '0.00';
        }
        /*if (empty($res1)) {
            return '0.00';
        }	*/
        if ($typeChk) {
            return round($tot_size, 2);
        } else {
            return number_format($tot_size, 2);
        }
    }

    public function shortLength($value, $len, $wrap = true)
    {
        $value_format = $this->formatText($value, 1);
        $value_raw = html_entity_decode($value_format, ENT_QUOTES);
        if (strlen($value_raw) > $len) {
            //$value_strip = substr($value_raw, 0, $len);
            $value_strip = mb_substr($value_raw, 0, $len, "utf-8");
            $value_strip = $this->formatText($value_strip, 1);
            if ($wrap) {
                $lengthvalue = "<span title='" . $value_format . "' >" . $value_strip . "...</span>";
            } else {
                $lengthvalue = $value_strip . "...";
            }
        } else {
            $lengthvalue = $value_format;
        }
        return $lengthvalue;
    }

    public function getAllCsId($pid)
    {
        $Easycase = ClassRegistry::init('Easycase');
        $Easycase->recursive = -1;
        $caseIds = $Easycase->find('all', array('conditions' => array('Easycase.project_id' => $pid), 'fields' => 'id'));
        $ids = array();
        foreach ($caseIds as $csid) {
            array_push($ids, $csid['Easycase']['id']);
        }
        return $ids;
    }

    public function dateFormatOutputdateTime_day($date_time, $curdate = null, $type = null)
    {
        if ($date_time != "") {
            $date_time = date("Y-m-d H;i:s", strtotime($date_time));
            $output = explode(" ", $date_time);
            $date_ex2 = explode("-", $output[0]);

            $dateformated = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {
                $displayWeek = 0;
                $timeformat = date('g:i a', strtotime($date_time));

                $week1 = date("l", mktime(0, 0, 0, $date_ex2[1], $date_ex2[2], $date_ex2[0]));
                $week_sub1 = substr($week1, "0", "3");

                $yesterday = date("Y-m-d", strtotime($curdate . "-1 days"));

                if ($dateformated == $this->dateFormatReverse($curdate)) {
                    $dateTime_Format = "Today";
                } elseif ($dateformated == $this->dateFormatReverse($yesterday)) {
                    $dateTime_Format = "Y'day";
                } else {
                    $CurYr = date("Y", strtotime($curdate));
                    $DateYr = date("Y", strtotime($dateformated));
                    if ($CurYr == $DateYr) {
                        $dateformated = date("M d", strtotime($dateformated));
                        $dtformated = date("M d", strtotime($dateformated)) . ", " . date("D", strtotime($dateformated));
                        $displayWeek = 1;
                    } else {
                        $dateformated = date("M d, Y", strtotime($dateformated));
                        $dtformated = date("M d, Y", strtotime($dateformated));
                    }
                    $dateTime_Format = $dateformated;
                }

                if ($type == 'date') {
                    return $dateTime_Format;
                } elseif ($type == 'time') {
                    return $dateTime_Format . " " . $timeformat;
                } elseif ($type == 'week') {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day" || !$displayWeek) {
                        //return $dateTime_Format;
                        return $dtformated;
                    } else {
                        return $dateTime_Format . ", " . date("D", strtotime($dateformated));
                    }
                } else {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day") {
                        return $dateTime_Format . " " . $timeformat;
                    } else {
                        //return $dateTime_Format.", ".date("D",strtotime($dateformated))." ".$timeformat;
                        //return $dateTime_Format.", ".date("Y",strtotime($dateformated))." ".$timeformat;
                        return $dtformated . " " . $timeformat;
                    }
                }
            }
        }
    }

    public function GetDateTime($timezoneid, $gmt_offset, $dst_offset, $timezone_code, $db_date, $type)
    {
        $dst = 1;
        if (!$timezoneid) {
            return date('Y-m-d H:i');
        }
        if ($type == "revdate") {
            $exp = explode(" ", $db_date);
            $exp_d = explode("-", $exp[0]);
            $exp_t = explode(":", $exp[1]);

            if ($gmt_offset != 0) {
                $sign1 = substr($gmt_offset, 0, 1);
                $value = substr($gmt_offset, 1, -4);

                if ($this->isDaylightSaving($timezoneid, $gmt_offset)) {
                    $value = $value - $dst_offset;
                } else {
                    $value = $value + $dst_offset;
                }
                if ($sign1 == "+") {
                    return date("Y-m-d", mktime($exp_t[0] - $value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                } elseif ($sign1 == "-") {
                    return date("Y-m-d", mktime($exp_t[0] - $value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                } else {
                    return date("Y-m-d", mktime($exp_t[0] - $value, $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
                }
            } else {
                return date("Y-m-d", mktime($exp_t[0], $exp_t[1], $exp_t[2], $exp_d[1], $exp_d[2], $exp_d[0]));
            }
        } else {
            if ($dst_offset > 0) {
                if (!($dst)) {
                    $dst_offset = 0;
                } elseif (!$this->isDaylightSaving($timezoneid, $gmt_offset)) {
                    $dst_offset = 0;
                }
            }
            $dst_offset *= 60;
            $gmt_offset *= 60;

            $exp = explode(" ", $db_date);
            $exp_d = explode("-", $exp[0]);
            $exp_t = explode(":", $exp[1]);

            $gmt_hour = $exp_t[0];
            $gmt_minute = $exp_t[1];
            $gmt_secs = $exp_t[2];



            $time = $gmt_hour * 60 + $gmt_minute + $gmt_offset + $dst_offset;
            if ($type == "datetime") {
                return date('Y-m-d H:i:s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "date") {
                return date('Y-m-d', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "time") {
                return date('H-i-s', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "dateFormat") {
                return date('m/d/Y', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "header") {
                return date('l, F j Y h:i A', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            } elseif ($type == "td") {
                return date('"G.i"', mktime($time / 60, $time % 60, $gmt_secs, $exp_d[1], $exp_d[2], $exp_d[0]));
            }
        }
    }

    public function getProjectName($pid)
    {
        $shortName = "";
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $pjArr = $Project->find('first', array('conditions' => array('Project.id' => $pid, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.name')));
        return $pjArr['Project']['name'];
        //return $pjArr;
    }

    public function getProjectShortName($pid)
    {
        $shortName = "";
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $pjArr = $Project->find('first', array('conditions' => array('Project.id' => $pid, 'Project.isactive' => 1, 'Project.company_id' => SES_COMP), 'fields' => array('Project.short_name')));
        return $pjArr['Project']['short_name'];
        //return $pjArr;
    }

    public function getRequireUserName($UserId = null, $is_email = null)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->query("SELECT `name`, `last_name`, `email` FROM `users` WHERE `id`='" . $UserId . "'");
        $fullname = $usrDtls[0]['users']['name'] . " " . $usrDtls[0]['users']['last_name'];
        if (isset($is_email)) {
            $fullname = $usrDtls[0]['users']['email'];
        }
        return $fullname;
    }

    public function getRequireTypeName($TypeId = null)
    {
        $Type = ClassRegistry::init('Type');
        $Type->recursive = -1;
        $typDtls = $Type->query("SELECT `name` FROM `types` WHERE `id`='" . $TypeId . "'");
        $typename = $typDtls[0]['types']['name'];
        return $typename;
    }

    public function getRequireMilestoneName($MId = null)
    {
        $Mlstn = ClassRegistry::init('Milestone');
        $Mlstn->recursive = -1;
        $mlstnDtls = $Mlstn->query("SELECT `title` FROM `milestones` WHERE `id`='" . $MId . "'");
        $mlstnname = $mlstnDtls[0]['milestones']['title'];
        return $mlstnname;
    }

    public function dateFormatOutputdateTime_day_EXPORT($date_time, $curdate = null, $type = null)
    {
        if ($date_time != "") {
            $date_time = date("Y-m-d H:i:s", strtotime($date_time));
            $output = explode(" ", $date_time);
            $date_ex2 = explode("-", $output[0]);

            $dateformated = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {
                $displayWeek = 0;
                $timeformat = date('g:i a', strtotime($date_time));

                $week1 = date("l", mktime(0, 0, 0, $date_ex2[1], $date_ex2[2], $date_ex2[0]));
                $week_sub1 = substr($week1, "0", "3");

                $yesterday = date("Y-m-d", strtotime($curdate . "-1 days"));

                if ($dateformated == $this->dateFormatReverse($curdate)) {
                    $dateTime_Format = "Today";
                } elseif ($dateformated == $this->dateFormatReverse($yesterday)) {
                    $dateTime_Format = "Y'day";
                } else {
                    $CurYr = date("Y", strtotime($curdate));
                    $DateYr = date("Y", strtotime($dateformated));
                    if ($CurYr == $DateYr) {
                        $dateformated = date("m/d", strtotime($dateformated));
                        $displayWeek = 1;
                    } else {
                        $dateformated = date("M d Y", strtotime($dateformated));
                    }
                    $dateTime_Format = $dateformated;
                }

                if ($type == 'date') {
                    return $dateTime_Format;
                } elseif ($type == 'time') {
                    return $dateTime_Format . " " . $timeformat;
                } elseif ($type == 'week') {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day" || !$displayWeek) {
                        return $dateTime_Format;
                    } else {
                        return $dateTime_Format . ", " . date("D", strtotime($dateformated));
                    }
                } else {
                    if ($dateTime_Format == "Today" || $dateTime_Format == "Y'day") {
                        return $dateTime_Format . " " . $timeformat;
                    } else {
                        return $dateTime_Format . ", " . date("D", strtotime($dateformated)) . " " . $timeformat;
                    }
                }
            }
        }
    }

    public function mdyFormat($date_time, $type = null)
    {
        if ($date_time != "") {
            $date_time = date("Y-m-d H:i:s", strtotime($date_time));
            $output = explode(" ", $date_time);
            $date_ex2 = explode("-", $output[0]);

            $dateformated = $date_ex2[1] . "/" . $date_ex2[2] . "/" . $date_ex2[0];
            if ($date_ex2[2] != "00") {
                $timeformat = date('g:i a', strtotime($date_time));
                $dateformated = date("m/d/Y", strtotime($dateformated));
                $dateTime_Format = $dateformated;

                if ($type == 'time') {
                    return $dateTime_Format . " " . $timeformat;
                } else {
                    return $dateTime_Format;
                }
            }
        }
    }

    public function checkEmailExists($betaEmail)
    {
        $BetaUser = ClassRegistry::init('BetaUser');
        $BetaUser->recursive = -1;

        $findUserEmail = $BetaUser->find('first', array('conditions' => array('BetaUser.email' => $betaEmail), 'fields' => array('BetaUser.id', 'BetaUser.is_approve')));

        $id = $findUserEmail['BetaUser']['id'];
        $is_approve = $findUserEmail['BetaUser']['is_approve'];

        if ($id) {
            $User = ClassRegistry::init('User');
            $User->recursive = -1;
            $findUser = $User->find('count', array('conditions' => array('User.email' => $betaEmail), 'fields' => array('User.id')));

            if ($findUser) {
                return 1; //Present in both user table and betauser table  //User Already Exists
            } else {
                if ($is_approve == 1) {
                    return 2; //Present in beta table but not in user table and is_approve in 1  //Your beta user has been approved
                } else {
                    return 3; //Present in beta table but not in user table and is_approve in 0  //Your beta user has been disapproved
                }
            }
        } else {
            $User = ClassRegistry::init('User');
            $User->recursive = -1;
            $findUser = $User->find('count', array('conditions' => array('User.email' => $betaEmail), 'fields' => array('User.id')));

            if ($findUser) {
                return 4; //Present in user table and not present in betauser table  //User Already Exists
            } else {
                return 5; //Not present in both user and beta user table
            }
        }
    }

    public function isValidDateTime($dateTime)
    {
        if (preg_match("/^(\d{1,2})\/(\d{1,2})\/(\d{2,4})$/", $dateTime, $matches)) {
            if (checkdate($matches[1], $matches[2], $matches[3])) {
                return true;
            }
        }
        return false;
    }
    public function isValidStatus($sts_nm, $prj_name, $prjs, $stslists)
    {
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $findProj = $Project->find('first', array('conditions' => array('Project.name LIKE ' => trim(strtolower($v)),'Project.company_id' => SES_COMP), 'fields' => array('Project.id','Project.status_group_id')));
        if ($prj_name == '') {
            //new project
            if ($stslists) {
                $retSts = 0;
                foreach ($stslists as $stk => $stv) {
                    if (trim(strtolower($sts_nm)) == trim(strtolower($stv))) {
                        $retSts = $stk;
                    }
                }
                return $retSts;
            }
        } else {
            //existing project
            $retSts = 0;
            foreach ($prjs as $stk => $stv) {
                if (trim(strtolower($prj_name)) == trim(strtolower($stv['Project']['name']))) {
                    foreach ($stv['StatusGroup']['CustomStatus'] as $stk1 => $stv1) {
                        if (trim(strtolower($sts_nm)) == trim(strtolower($stv1['name']))) {
                            $retSts = $stv1['id'];
                        }
                    }
                }
            }
            return $retSts;
        }
        return false;
    }
    
    public function getValidprojectStstus($proj_sts, $sts_nm, $proj_id)
    {
        $legend = 1;
        $sts_grp = 0;
        if (isset($proj_sts[$proj_id])) {
            //Custom status
            if (trim($sts_nm) == '') {
                $legend = $proj_sts[$proj_id]['CustomStatus'][0]['status_master_id'];
                $sts_grp = $proj_sts[$proj_id]['CustomStatus'][0]['id'];
            } else {
                foreach ($proj_sts[$proj_id]['CustomStatus'] as $csk => $csvl) {
                    if (strtolower(trim($sts_nm)) == strtolower(trim($csvl['name']))) {
                        $legend = $csvl['status_master_id'];
                        $sts_grp = $csvl['id'];
                    }
                }
                if ($sts_grp == 0) {
                    $legend = $proj_sts[$proj_id]['CustomStatus'][0]['status_master_id'];
                    $sts_grp = $proj_sts[$proj_id]['CustomStatus'][0]['id'];
                }
            }
        } else {
            //Default sttaus
            $sts_grp = 0;
            if (trim($sts_nm) == '') {
                $legend = 1;
            } else {
                if (((strtolower(trim($sts_nm)) == 'wip') || (strtolower(trim($sts_nm)) == 'in progress'))) {
                    $legend = 2;
                } elseif (((strtolower(trim($sts_nm)) == 'close') || (strtoupper(trim($sts_nm)) == 'CLOSED'))) {
                    $legend = 3;
                } elseif ((strtolower(trim($sts_nm)) == 'resolve' || strtolower(trim($sts_nm)) == 'resolved')) {
                    $legend = 5;
                } else {
                    $legend = 1;
                }
            }
        }
        return array($legend,$sts_grp);
    }

    public function isValidDateHours($hour, $chk = null, $chk_1 = null)
    {
        if ($chk_1) {
            $exp = '/^[0-9]{0,5}:[0-9]{2}$/';
        } elseif ($chk) {
            $exp = '/^[0-9]{0,2}:[0-9]{2}[ap]m$/';
        } else {
            $exp = '/^[0-9]{0,2}:[0-9]{2}$/';
        }
        if (preg_match($exp, $hour)) {
            return true;
        }
        return false;
    }

    public function isValidTlDateHours($hour, $chk)
    {
        $exp = '/^[0-9]{0,2}:[0-9]{2}\s?[apAP][mM]$/';
        if (preg_match($exp, $hour)) {
            return true;
        }
        return false;
    }

    public function convert_ascii($string)
    {
        // Replace Single Curly Quotes
        $search[] = chr(226) . chr(128) . chr(152);
        $replace[] = "'";
        $search[] = chr(226) . chr(128) . chr(153);
        $replace[] = "'";

        // Replace Smart Double Curly Quotes
        $search[] = chr(226) . chr(128) . chr(156);
        $replace[] = '\"';
        $search[] = chr(226) . chr(128) . chr(157);
        $replace[] = '\"';

        // Replace En Dash
        $search[] = chr(226) . chr(128) . chr(147);
        $replace[] = '--';

        // Replace Em Dash
        $search[] = chr(226) . chr(128) . chr(148);
        $replace[] = '---';

        // Replace Bullet
        $search[] = chr(226) . chr(128) . chr(162);
        $replace[] = '*';

        // Replace Middle Dot
        $search[] = chr(194) . chr(183);
        $replace[] = '*';

        // Replace Ellipsis with three consecutive dots
        $search[] = chr(226) . chr(128) . chr(166);
        $replace[] = '...';

        $search[] = chr(150);
        $replace[] = "-";

        // Apply Replacements
        $string = str_replace($search, $replace, $string);

        // Remove any non-ASCII Characters
        //$string = preg_replace("/[^\x01-\x7F]/","", $string);
        return $string;
    }

    public function getSqlFields($arr, $prj_unq_id)
    {
        $qry = '';
        if (isset($arr)) {
            //Filter by date
            $case_date = $arr['date'];
            if (trim($case_date) == '1') {
                $one_date = date('Y-m-d H:i:s', time() - 3600);
                $qry.= " AND Easycase.dt_created >='" . $one_date . "'";
            } elseif (trim($case_date) == '24') {
                $day_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " -1 day"));
                $qry.= " AND Easycase.dt_created >='" . $day_date . "'";
            } elseif (trim($case_date) == 'week') {
                $week_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " -1 week"));
                $qry.= " AND Easycase.dt_created >='" . $week_date . "'";
            } elseif (trim($case_date) == 'month') {
                $month_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " -1 month"));
                $qry.= " AND Easycase.dt_created >='" . $month_date . "'";
            } elseif (trim($case_date) == 'year') {
                $year_date = date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s", strtotime(date("Y-m-d H:i:s"))) . " -1 year"));
                $qry.= " AND Easycase.dt_created >='" . $year_date . "'";
            } elseif (strstr(trim($case_date), ":")) {
                //echo $case_date;exit;
                $ar_dt = explode(":", trim($case_date));
                $frm_dt = $ar_dt['0'];
                $to_dt = $ar_dt['1'];
                $qry.= " AND DATE(Easycase.dt_created) >= '" . date('Y-m-d H:i:s', strtotime($frm_dt)) . "' AND DATE(Easycase.dt_created) <= '" . date('Y-m-d H:i:s', strtotime($to_dt)) . "'";
            }

            //	if($arr['date'] =='1'){
            //	    $qry .=" AND Easycase.dt_created >= DATE_SUB(NOW(), INTERVAL 1 HOUR)";
            //	}elseif($arr['date'] =='24'){
            //	    $qry .=" AND Easycase.dt_created >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
            //	}elseif($arr['date'] =='week'){
            //	    $qry .=" AND Easycase.dt_created >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
            //	}elseif($arr['date'] =='month'){
            //	    $qry .=" AND Easycase.dt_created >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
            //	}elseif($arr['date'] =='year'){
            //	    $qry .=" AND Easycase.dt_created >= DATE_SUB(NOW(), INTERVAL 12 MONTH)";
            //	}elseif($arr['date'] =='cst_rng'){
            //	    $fm_date = explode("/", $arr['from']);
            //	    $from_date = $fm_date['2']."-".$fm_date['0']."-".$fm_date['1'];
//
            //	    $t_date = explode("/", $arr['to']);
            //	    $to_date = $t_date['2']."-".$t_date['0']."-".$t_date['1'];
//
            //	    $qry .=" AND Easycase.dt_created >= ".$from_date." AND Easycase.dt_created <=".$to_date;
            //	}
            //Filter by status
            if (intval($arr['status'])) {
                if ($arr['status'] > 6) {
                    $CustomStatus = ClassRegistry::init('CustomStatus');
                    $sts_cond = array('CustomStatus.company_id'=>SES_COMP);
                    $CstmStsArrLst =  $CustomStatus->find('list', array('conditions'=>$sts_cond,'fields'=>array('CustomStatus.id','CustomStatus.name'),'order'=>array('CustomStatus.seq'=>'ASC')));
                    if (!empty($CstmStsArrLst)) {
                        $id_sep = '';
                        foreach ($CstmStsArrLst as $c_key => $c_val) {
                            if (trim($c_val) == trim($CstmStsArrLst[$arr['status']])) {
                                if ($id_sep == '') {
                                    $id_sep = $c_key;
                                } else {
                                    $id_sep .= ','.$c_key;
                                }
                            }
                        }
                        if ($id_sep != '') {
                            $qry .=" AND Easycase.custom_status_id IN(" . $id_sep . ")";
                        }
                    } else {
                        $qry .=" AND Easycase.custom_status_id='" . $arr['status'] . "'";
                    }
                } elseif ($arr['status'] == 2) {
                    $qry .=" AND (Easycase.legend='" . $arr['status'] . "' OR Easycase.legend='4')";
                } else {
                    $qry .=" AND Easycase.legend='" . $arr['status'] . "'";
                }
            } elseif ($arr['status'] == 'attach') {
                $qry .=" AND Easycase.format='1'";
            } elseif ($arr['status'] == 'update') {
                $qry .=" AND Easycase.type_id='10'";
            }
            if ($arr['types'] == 'all' && $arr['status'] != 'update') {
                $qry.=" AND Easycase.type_id !='10'";
            }
            //Filter by types
            if (intval($arr['types'])) {
                $qry .=" AND Easycase.type_id='" . $arr['types'] . "'";
            }
            //Filter by priority
            if ($arr['priority'] != 'all') {
                $qry .=" AND Easycase.priority='" . $arr['priority'] . "'";
            }

            //if (isset($prj_unq_id) && $prj_unq_id != 'all') {
            if (isset($prj_unq_id)) { //to fix the export with individual fields issue
                //Filter by members
                if (intval($arr['members'])) {
                    $qry .=" AND Easycase.user_id='" . $arr['members'] . "'";
                }
                //Filter by assign to
                if (intval($arr['assign_to'])) {
                    $qry .=" AND Easycase.assign_to='" . $arr['assign_to'] . "'";
                }
                //Filter by milestone
                if (intval($arr['milestone'])) {
                    $qry .=" AND EasycaseMilestone.milestone_id='" . $arr['milestone'] . "'";
                }
            }
            return $qry;
        }
    }

    /**
     * @method public iptolocation(string $ip) Detect the location from IP
     * @author GDR<support@ornagescrum.com>
     * @return string  Location fromt the ip
     */
    public function validate_ip($ip)
    {
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        return true;
    }

    public function getRealIpAddr()
    {
        /* try {
          $ipaddress = file_get_contents("http://www.telize.com/jsonip");
          $ipaddress = json_decode($ipaddress,true);
          if(isset($ipaddress['ip']) && ip2long($ipaddress['ip'])) {
          $ip = $ipaddress['ip'];
          }
          }catch(Exception $e){
          return $ip;
          } */

        $ip_keys = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
        foreach ($ip_keys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    $ip = trim($ip);
                    // attempt to validate IP
                    if ($this->validate_ip($ip)) {
                        return $ip;
                    }
                }
            }
        }
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : false;
    }

    public function is_private_ip($ip)
    {
        if (empty($ip) or ! ip2long($ip)) {
            return false;
        }
        $private_ips = array(
            array('10.0.0.0', '10.255.255.255'),
            array('172.16.0.0', '172.31.255.255'),
            array('192.168.0.0', '192.168.255.255')
        );
        $ip = ip2long($ip);
        foreach ($private_ips as $ipr) {
            $min = ip2long($ipr[0]);
            $max = ip2long($ipr[1]);
            if (($ip >= $min) && ($ip <= $max)) {
                return true;
            }
        }
        return false;
    }

    public function iptoloccation($ip)
    {
        if ($this->is_private_ip($ip)) {
            return $ip . " - PRIVATE NETWORK";
        }

        $data = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=' . IP2LOC_API_KEY . '&ip=' . $ip . '&format=json');
        $data = json_decode($data, true);

        if (isset($data['cityName']) && trim(trim($data['cityName']), '-')) {
            $location = $data['cityName'] . ", " . $data['regionName'] . ", " . $data['countryName'] . ", Lat/Lon: " . $data['latitude'] . "," . $data['longitude'] . ", IP: " . $ip;
        } else {
            $data = file_get_contents('http://ip-api.com/json');
            $data = json_decode($data, true);
            $location = $data['city'] . ", " . $data['regionName'] . ", " . $data['country'] . ", Lat/Lon: " . $data['lat'] . "," . $data['lon'] . ", IP: " . $data['query'];
        }
        return $location;
    }

    /**
     * @method: Public hoursspent($project_id) Total hours spent in a project
     * @author GDR <support@orangescrum.com>
     * @return int hours spent
     */
    public function hoursspent($project_id, $isClientValue = null)
    {
        $easycasecls = ClassRegistry::init('Easycase');
        $easycasecls->recursive = -1;
        if ($project_id) {
            //$result = $easycasecls->query("SELECT ROUND(SUM(easycases.hours), 1) as hours from easycases WHERE project_id=".$project_id." AND istype='2' and isactive='1'");
            if (SES_TYPE == 3 || $isClientValue == 1) {
                $userHoursSpent = "LogTime.user_id =" . SES_ID ;
            } elseif (SES_TYPE < 3) {
                $userHoursSpent = "1";
            }
            $sql = "SELECT SUM(LogTime.total_hours) AS hours "
                    . "FROM log_times as LogTime "
                    . "LEFT JOIN easycases AS Easycase ON LogTime.task_id=Easycase.id AND LogTime.project_id=Easycase.project_id "
                    . "WHERE " . $userHoursSpent . " AND LogTime.project_id =" . $project_id . " AND Easycase.isactive=1";
            $result = $easycasecls->query($sql);
            #pr($result);exit;
            return $this->format_time_hr_min($result['0']['0']['hours']);
        } else {
            $projcls = ClassRegistry::init('Project');
            $projcls->recursive = -1;
            $project_list = $projcls->find('list', array('conditions' => array('isactive' => 1, 'company_id' => SES_COMP), 'fields' => array('id')));
            if (empty($project_list)) {
                return '00 hrs 00 mins';
            }
            if (SES_TYPE == 3 || $isClientValue == 1) {
                $sql = "SELECT SUM(LogTime.total_hours) AS hours "
                        . "FROM log_times as LogTime "
                        . "LEFT JOIN easycases AS Easycase ON LogTime.task_id=Easycase.id AND LogTime.project_id=Easycase.project_id "
                        . "WHERE LogTime.user_id =" . SES_ID . " AND LogTime.project_id IN (" . implode(',', $project_list) . ") AND Easycase.isactive=1";
            } elseif (SES_TYPE < 3) {
                $sql = "SELECT SUM(LogTime.total_hours) AS hours "
                    . "FROM log_times as LogTime "
                    . "LEFT JOIN easycases AS Easycase ON LogTime.task_id=Easycase.id AND LogTime.project_id=Easycase.project_id "
                    . "WHERE LogTime.project_id IN (" . implode(',', $project_list) . ") AND Easycase.isactive=1";
            }
            $result = $easycasecls->query($sql);
            return $this->format_time_hr_min($result['0']['0']['hours']);
        }
    }

    /**
     * @method: PUBLIC generate_invoiceid()
     */
    public function generate_invoiceid()
    {
        $trnsclas = ClassRegistry::init('Transaction');
        $trnsclas->recursive = -1;
        $trans = $trnsclas->find('first', array('conditions' => ('invoice_id IS NOT NULL'), 'order' => 'id DESC', 'fields' => array('invoice_id')));

        if ($trans) {
            $prv_invoice_id = (int) $trans['Transaction']['invoice_id'];
            if ($prv_invoice_id == 1) {
                $prv_invoice_id = 153702;
            }
            $prv_invoice_id = (int) $trans['Transaction']['invoice_id'] + 1;
        } else {
            $prv_invoice_id = 153700;
        }
        $current_invoice_id = str_pad($prv_invoice_id, 6, 0, STR_PAD_LEFT);
        return $current_invoice_id;
    }

    public function getRemoteIP()
    {
        $ipaddress = '';
        if ($_SERVER['HTTP_CLIENT_IP']) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif ($_SERVER['HTTP_X_FORWARDED']) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } elseif ($_SERVER['HTTP_FORWARDED_FOR']) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } elseif ($_SERVER['HTTP_FORWARDED']) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } elseif ($_SERVER['REMOTE_ADDR']) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }

    /**
     *
     * @param type $source
     * @param type $destination
     * @param string $flag
     * @return boolean
     */
    public function zipFile($source, $destination, $flag = '')
    {
        if (!extension_loaded('zip') || !file_exists($source)) {
            return false;
        }
        $zip = new ZipArchive();
        if (!$zip->open($destination, ZIPARCHIVE::CREATE)) {
            return false;
        }
        $source = str_replace('\\', '/', realpath($source));
        if ($flag) {
            $flag = basename($source) . '/';
            //$zip->addEmptyDir(basename($source) . '/');
        }

        if (is_dir($source) === true) {
            $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source), RecursiveIteratorIterator::SELF_FIRST);
            $arr = array();
            foreach ($files as $file) {
                $arr[] = $file->getFileName();
                if ($file->getFileName() == '.' || $file->getFileName() == '..') {
                    continue;
                }
                $file = str_replace('\\', '/', realpath($file));
                if (is_dir($file) === true) {
                    $zip->addEmptyDir(str_replace($source . '/', '', $flag . $file . '/'));
                } elseif (is_file($file) === true) {
                    $zip->addFromString(str_replace($source . '/', '', $flag . $file), file_get_contents($file));
                }
            }
        } elseif (is_file($source) === true) {
            $zip->addFromString($flag . basename($source), file_get_contents($source));
        }
        return $zip->close();
    }

    /* gantt start GKM */

    public function changeGanttDataV2($json_arr)
    {
        #echo "<pre>";print_r($json_arr); exit;
        $user_ids = array();
        $colors = array(0 => '#73BCDE', 1 => '#8BC2B9', 2 => '#F8B363', 3 => '#EA7373', 4 => '#9ECC61');
        foreach ($json_arr as $key => $value) {
            $assign_to = intval($value['assign_to']);
            if ($assign_to > 0 && !in_array($assign_to, $user_ids)) {
                $user_ids[] = $assign_to;
            }

            $json_arr[$key]['id'] = $value['id'];
            $json_arr[$key]['name'] = trim($value['title']);
            $json_arr[$key]['description'] = trim($value['message']);

            #STATUS_ACTIVE, STATUS_DONE, STATUS_FAILED, STATUS_SUSPENDED, STATUS_UNDEFINED.
            #$json_arr[$key]['status'] = 'STATUS_ACTIVE';
            $json_arr[$key]['status'] = $assign_to > 0 ? 'color' . array_search($assign_to, $user_ids) . '' : 'color15';
            $json_arr[$key]['canWrite'] = true;


            $json_arr[$key]['startIsMilestone'] = false;
            $json_arr[$key]['endIsMilestone'] = false;
            $json_arr[$key]['collapsed'] = false;
            $json_arr[$key]['assigs'] = array();
            $json_arr[$key]['hasChild'] = 0;
            $json_arr[$key]['level'] = 1;
            $json_arr[$key]['depends'] = $value['depends'];
            $json_arr[$key]['progress'] = $value['progress'];
            $json_arr[$key]['assigned_to'] = $value['assigned_to'];
            $json_arr[$key]['priority'] = $value['priority'];
            $json_arr[$key]['type_id'] = $value['type_id'];
            $json_arr[$key]['case_no'] = $value['case_no'];

            if ((!empty($value['gantt_start_date']) && !is_null($value['gantt_start_date']) && $value['gantt_start_date'] != '0000-00-00 00:00:00') && ($value['due_date'] != '' && !is_null($value['due_date']) && $value['due_date'] != '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);print $v['id'];echo "    1";exit;
                $json_arr[$key]['start'] = $value['gantt_start_date'];
                $json_arr[$key]['end'] = $value['due_date'];
                $json_arr[$key]['color'] = $colors[$key];
            } elseif ((empty($value['gantt_start_date']) || is_null($value['gantt_start_date']) || $value['gantt_start_date'] == '0000-00-00 00:00:00') && ($value['due_date'] != '' && !is_null($value['due_date']) && $value['due_date'] != '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);echo "   2";exit;
                $json_arr[$key]['start'] = $value['due_date'];
                $json_arr[$key]['end'] = $value['due_date'];
                $json_arr[$key]['color'] = $colors[$key];
            } elseif ((!empty($value['gantt_start_date']) && !is_null($value['gantt_start_date']) && $value['gantt_start_date'] != '0000-00-00 00:00:00') && ($value['due_date'] == '' || is_null($value['due_date']) || $value['due_date'] == '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);echo "   3";exit;
                $json_arr[$key]['start'] = $value['gantt_start_date'];
                $json_arr[$key]['end'] = date('Y-m-d', $this->dateConvertion($value['gantt_start_date']));
                $json_arr[$key]['color'] = $colors[$key];
            } else {
                //print_r($v['gantt_start_date']);echo "   4";exit;
                $start = explode(' ', $value['actual_dt_created']);
                $json_arr[$key]['start'] = $start[0];
                $json_arr[$key]['end'] = date('Y-m-d', $this->dateConvertion($value['actual_dt_created']));
                $json_arr[$key]['color'] = $colors[$key];
            }

            /* convert to user timezone */
            $json_arr[$key]['start'] = $this->convert_date_timezone($json_arr[$key]['start']);
            $json_arr[$key]['end'] = $this->convert_date_timezone($json_arr[$key]['end']);

            $json_arr[$key]['duration'] = $this->days_diff($json_arr[$key]['start'], $json_arr[$key]['end']);
            $json_arr[$key]['o_start'] = ($json_arr[$key]['start']);
            $json_arr[$key]['o_end'] = ($json_arr[$key]['end']);

            /* convert to millisecond */
            $json_arr[$key]['start'] = strtotime($json_arr[$key]['start']) * 1000;
            $json_arr[$key]['end'] = strtotime($json_arr[$key]['end']) * 1000;

            if ($value['legend'] == '1') {
                $json_arr[$key]['color'] = '#f19a91';
            } elseif ($value['legend'] == '2' || $value['legend'] == '6') {
                $json_arr[$key]['color'] = '#8dc2f8';
            } elseif ($value['legend'] == '5') {
                $json_arr[$key]['color'] = '#f3c788';
            } elseif ($value['legend'] == '3') {
                $json_arr[$key]['color'] = '#8ad6a3';
            } else {
                $json_arr[$key]['color'] = '#3dbb89';
            }
            unset($json_arr[$key]['title']);
            #unset($json_arr[$key]['id']);
            #unset($json_arr[$key]['legend']);
            unset($json_arr[$key]['gantt_start_date']);
            unset($json_arr[$key]['due_date']);
            unset($json_arr[$key]['actual_dt_created']);
        }//exit;
        #echo "<pre>";print_r($json_arr);exit;
        return $json_arr;
    }

    public function get_formated_date($value = '')
    {
        $zero_dates = array('0000-00-00', '0000-00-00 00:00:00');
        if (
                (!empty($value['start_date']) && !is_null($value['start_date']) && !in_array($value['start_date'], $zero_dates)) &&
                (!empty($value['end_date']) && !is_null($value['end_date']) && !in_array($value['end_date'], $zero_dates))
            ) {
            $start = $value['start_date'];
            $end = $value['end_date'];
            $color = $colors[$key];
        } elseif (
                (empty($value['start_date']) || is_null($value['start_date']) || in_array($value['start_date'], $zero_dates)) &&
                (!empty($value['end_date']) && !is_null($value['end_date']) && !in_array($value['end_date'], $zero_dates))
            ) {
            $start = $value['created'];
            $end = $value['end_date'];
            $color = $colors[$key];
        } elseif (
                (!empty($value['start_date']) && !is_null($value['start_date']) && !in_array($value['start_date'], $zero_dates)) &&
                (empty($value['end_date']) || is_null($value['end_date']) || in_array($value['end_date'], $zero_dates))
            ) {
            $start = $value['start_date'];
            $end = date('Y-m-d', $this->dateConvertion($value['start_date']));
            $color = $colors[$key];
        } else {

            #$start = explode(' ', $value['created']);
            #$start = $start[0];
            $start = date('Y-m-d', strtotime($value['created']));
            $end = date('Y-m-d', $this->dateConvertion($value['created']));
            $color = $colors[$key];
        }
        /* overwrite if in-proper date  */
        $start_year = date('Y', strtotime($start));
        $end_year = date('Y', strtotime($end));
        if ($start_year == 1970 && $end_year == 1970) {
            $start = date('Y-m-d');
            $end = date('Y-m-d');
        }
        if ($start_year == 1970) {
            $start = $end_year == 1970 ? date('Y-m-d') : $end;
        }
        if ($end_year == 1970) {
            $end = date('Y-m-d');
        }
        /* convert to user timezone */
        $start = $this->convert_date_timezone($start);
        $end = $this->convert_date_timezone($end);

        $json_arr['duration'] = $this->days_diff($start, $end);
        $json_arr['o_start'] = $start;
        $json_arr['o_end'] = $end;
        $json_arr['start_date'] = $start;
        $json_arr['end_date'] = $end;

        $json_arr['color'] = $color;
        // convert to millisec
        $json_arr['start'] = strtotime($start) * 1000;
        $json_arr['end'] = strtotime($end) * 1000;
        return $json_arr;
    }

    public function days_diff($from = '', $to = '')
    {
        $from_date = strtotime($from); // or your date as well
        $to_date = strtotime($to);
        $datediff = $to_date - $from_date;
        //echo $from. " >>>>>> ".$to.' >>>>?? '.ceil($datediff / (60 * 60 * 24)).'<br>';
        #return round($datediff / (60 * 60 * 24)) > 1 ? round($datediff / (60 * 60 * 24)) : 1;
        return ceil($datediff / (60 * 60 * 24)) > 1 ? ceil($datediff / (60 * 60 * 24)) : 1;
    }

    public function convert_date_timezone($date = '')
    {
        if (trim($date == '')) {
            $date = date('Y-m-d H:i:s');
        }
        return $date;
        #return $this->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $date, "date");
    }

    public function formatTitle($title)
    {
        if (isset($title) && !empty($title)) {
            $title = stripcslashes(htmlspecialchars(html_entity_decode($title, ENT_QUOTES, 'UTF-8')));
        }
        return $title;
    }

    public function dateConvertion($date)
    {
        //print_r($date);exit;
        $seconds = strtotime($date);
        return ($seconds + 86400);
    }

    /* gantt end */

    public function format_date($date = '', $format = 'date')
    {
        if ($format == 'date') {
            return date('Y-m-d', strtotime($date));
        } else {
            return date('Y-m-d H:i:s', strtotime($date));
        }
    }

    /* Author: GKM
     * to format sec to hr min
     */

    public function format_time_hr_min($totalsecs = '', $typ = null)
    {
        if ($typ) {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '00';
            $hours_txt = floor($totalsecs / 3600) > 1 ? 's' : '';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round(($totalsecs % 3600) / 60) : '00';
            $mins_txt = round(($totalsecs % 3600) / 60) > 1 ? 's' : '';
            $str = '<div class="billable-graph un-bill-time"><h2>' . $hours . '<span>hr' . $hours_txt . '</span></h2><h2>' . $mins . '<span>min' . $mins_txt . '</span></h2></div>';
            return $str;
        } else {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) . " hr" . (floor($totalsecs / 3600) > 1 ? 's' : '') . " " : '';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? "" . round(($totalsecs % 3600) / 60) . " min" . (round(($totalsecs % 3600) / 60) > 1 ? 's' : '') : '';
            return $hours . "" . $mins;
        }
    }
    public function format_time_hr_min_point($totalsecs = '', $typ = null)
    {
        $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : 0;
        //return round(($totalsecs / 3600),1);
        $mins = round(($totalsecs % 3600) / 60) > 0 ? (($totalsecs % 3600) / 3600) : 0;
        if ($mins >= 0.5) {
            $mins = round($mins, 1);
        }
        if ($hours && $mins) {
            //return floatval($hours . "." . $mins);
            return $hours+$mins;
        } elseif ($hours) {
            return $hours;
        } elseif ($mins) {
            //return floatval('0.'.$mins);
            return $mins;
        } else {
            return 0;
        }
    }

    public function format_second_hrmin($totalsecs = '')
    {
        $hours = $mins = '00';
        if (!empty($totalsecs)) {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '00';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round(($totalsecs % 3600) / 60) : '00';
        }
        return str_pad($hours, 2, '0', STR_PAD_LEFT) . ":" . str_pad($mins, 2, '0', STR_PAD_LEFT);
    }
    public function format_second_hrmin_nopad($totalsecs = '')
    {
        $hours = $mins = '0';
        if (!empty($totalsecs)) {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '0';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round((($totalsecs % 3600) / 60), 2) : '0';
        }
        if (stristr($mins, '.')) {
            $mins = substr($mins, 0, strpos($mins, '.'));
        }
        return $hours.":".$mins;
    }

    /* By GKM
     * used to generate invoice number
     */

    public function invoice_number($invoice)
    {
        $invoice_code = 'IN';
        if ($invoice < 10) {
            $invoice_code .= '000';
        } elseif ($invoice < 100) {
            $invoice_code .= '00';
        } elseif ($invoice < 1000) {
            $invoice_code .= '0';
        } else {
            $invoice_code .= '';
        }
        return $invoice_code .= $invoice;
    }

    /* By GKM
     * used to format price value
     */

    public function format_price($price)
    {
        return number_format($price, 2, '.', '');
    }

    /* author: GKM
     * it is used to format 24 hr to 12 hr with am / pm format
     */

    public function format_24hr_to_12hr($time)
    {
        $out_time_arr = explode(":", $time);
        if (SES_TIME_FORMAT==12) {
            $out_mode = intval($out_time_arr[0]) < 12 ? 'am' : 'pm';
            $out_hr = intval($out_time_arr[0]) > 12 ? intval($out_time_arr[0]) - 12 : intval($out_time_arr[0]);
            $out_min = intval($out_time_arr[1]);
        } else {
            $out_mode = '';
            $out_hr = $out_time_arr[0];
            $out_min = intval($out_time_arr[1]);
        }
        return ($out_hr > 0 ? $out_hr : 12) . ':' . ($out_min < 10 ? '0' : '') . $out_min . '' . $out_mode;
    }
    public function api_format_24hr_to_12hr($time)
    {
        $out_time_arr = explode(":", $time);
        $out_mode = intval($out_time_arr[0]) < 12 ? ' AM' : ' PM';
        $out_hr = intval($out_time_arr[0]) > 12 ? intval($out_time_arr[0]) - 12 : intval($out_time_arr[0]);
        $out_min = intval($out_time_arr[1]);
        return ($out_hr > 0 ? $out_hr : 12) . ':' . ($out_min < 10 ? '0' : '') . $out_min . '' . $out_mode;
    }

    /* by GKM
     * for removing special characters
     */

    public function seo_url($string = '', $flag = '-')
    {
        if (trim($string) != '') {
            return trim(preg_replace('/[^a-z0-9]+/i', $flag, $string), $flag);
        } else {
            return '';
        }
    }

    public static function is_image($mime)
    {
        /* $image_type_to_mime_type = array(
          1 => 'image/gif', // IMAGETYPE_GIF
          2 => 'image/jpeg', // IMAGETYPE_JPEG
          3 => 'image/png', // IMAGETYPE_PNG
          4 => 'application/x-shockwave-flash', // IMAGETYPE_SWF
          5 => 'image/psd', // IMAGETYPE_PSD
          6 => 'image/bmp', // IMAGETYPE_BMP
          7 => 'image/tiff', // IMAGETYPE_TIFF_II (intel byte order)
          8 => 'image/tiff', // IMAGETYPE_TIFF_MM (motorola byte order)
          9 => 'application/octet-stream', // IMAGETYPE_JPC
          10 => 'image/jp2', // IMAGETYPE_JP2
          11 => 'application/octet-stream', // IMAGETYPE_JPX
          12 => 'application/octet-stream', // IMAGETYPE_JB2
          13 => 'application/x-shockwave-flash', // IMAGETYPE_SWC
          14 => 'image/iff', // IMAGETYPE_IFF
          15 => 'image/vnd.wap.wbmp', // IMAGETYPE_WBMP
          16 => 'image/xbm', // IMAGETYPE_XBM
          'gif' => 'image/gif', // IMAGETYPE_GIF
          'jpg' => 'image/jpeg', // IMAGETYPE_JPEG
          'jpeg' => 'image/jpeg', // IMAGETYPE_JPEG
          'png' => 'image/png', // IMAGETYPE_PNG
          'bmp' => 'image/bmp', // IMAGETYPE_BMP
          'ico' => 'image/x-icon',
          ); */
        $image_type_to_mime_type = array(
            'gif' => 'image/gif', // IMAGETYPE_GIF
            'jpg' => 'image/jpeg', // IMAGETYPE_JPEG
            'jpeg' => 'image/jpeg', // IMAGETYPE_JPEG
            'png' => 'image/png', // IMAGETYPE_PNG
            'bmp' => 'image/bmp', // IMAGETYPE_BMP
        );

        return (in_array($mime, $image_type_to_mime_type) ? true : false);
    }
    public function dateRangeFilter($filter,$start_date,$end_date){
        if($filter == "Week" || $filter == ""){
            $date_of_startdate = date('d',strtotime($start_date));
            $date_of_enddate = date('d M',strtotime($end_date));
            $date_range =  $date_of_startdate . "-". $date_of_enddate;

        }elseif($filter == "Month" ||$filter == "customdate"){
            $date_of_startdate = date('d M Y',strtotime($start_date));
            $date_of_enddate = date('d M Y',strtotime($end_date));
            $date_range =  $date_of_startdate . "-". $date_of_enddate;
        }elseif($filter == "Quater"){
            $year1 = date("Y", strtotime($start_date));
            $year2 = date("Y", strtotime($end_date));
            $month1 = date("m", strtotime($start_date));
            $month2 = date("m", strtotime($end_date));
            // pr($start_date); pr($end_date); exit;
            if($month1 > 9 && $month2 <= 01){
                $date_range1 = "Q4";
            }elseif($month1 > 3 && $month2 <= 7){
                $date_range1 = "Q2";
            }elseif($month1 > 6 && $month2 <= 10){
                $date_range1 = "Q3";
            }elseif($month2 <= 4){
                $date_range1 = "Q1";
            }
            $date_range =  $date_range1. " " .$year1;
        }
        return  $date_range;
    }
    public function date_filter($filter = '', $curDateTime = '')
    {
        $curDateTime = $curDateTime != "" ? $curDateTime : date('Y-m-d H:i:s');
        $data = array();
        $month = date("m", strtotime($curDateTime . ($filter == 'lastquarter' ? " -3 months" : "")));
        if(PAGE_NAME == "FetchPlannedVSActualData"){
            $month = date("m", strtotime($curDateTime));
        }
        if ($month < 4) {
            $start = 'first day of january';
            $end = 'last day of march';
        } elseif ($month > 3 && $month < 7) {
            $start = 'first day of april';
            $end = 'last day of june';
        } elseif ($month > 6 && $month < 10) {
            $start = 'first day of july';
            $end = 'last day of september';
        } elseif ($month > 9) {
            $start = 'first day of october';
            $end = 'last day of december';
        }
        switch ($filter) {
            case 'today':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'yesterday':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime . ' -1 day'));
                break;
            case 'thisweek':
                if (date('D', strtotime($curDateTime)) === 'Mon') {
                    $data['strddt'] = date('Y-m-d', strtotime($curDateTime));
                    $data['enddt'] = date('Y-m-d', strtotime($curDateTime . " +6 days"));
                } else {
                    $data['strddt'] = date('Y-m-d', strtotime('last monday', strtotime($curDateTime)));
                    $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                }
                break;
            case 'thismonth':
                $data['strddt'] = date('Y-m-d', strtotime('first day of this month', strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'thisquarter':
                $data['strddt'] = date('Y-m-d', strtotime($start, strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'thisyear':
                $data['strddt'] = date('Y-m-d', strtotime('first day of January', strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'lastweek':
                if (date('D', strtotime($curDateTime)) === 'Mon') {
                    $data['strddt'] = date('Y-m-d', strtotime('last monday', strtotime($curDateTime)));
                    $data['enddt'] = date('Y-m-d', strtotime($curDateTime. " -1 days"));
                } else {
                    $data['strddt'] = date('Y-m-d', strtotime('last monday', strtotime($curDateTime . " -7 days")));
                    $data['enddt'] = date('Y-m-d', strtotime('next sunday', strtotime($curDateTime . " -7 days")));
                }
                break;
            case 'lastmonth':
                $data['strddt'] = date('Y-m-d', strtotime('first day of this month', strtotime($curDateTime . " -1 month")));
                $data['enddt'] = date('Y-m-d', strtotime('last day of this month', strtotime($curDateTime . " -1 month")));
                break;
            case 'lastquarter':
                $data['strddt'] = date('Y-m-d', strtotime($start, strtotime($curDateTime)));
                $data['enddt'] = date('Y-m-d', strtotime($end, strtotime($curDateTime)));
                if ($month > 9) {
                    $data['strddt'] = date('Y-m-d', strtotime($data['strddt'] . '-1 year'));
                    $data['enddt'] = date('Y-m-d', strtotime($data['enddt'] . '-1 year'));
                }
                break;
            case 'lastyear':
                $data['strddt'] = date('Y-m-d', strtotime('first day of January', strtotime($curDateTime . ' -1 year')));
                $data['enddt'] = date('Y-m-d', strtotime('last day of December', strtotime($curDateTime . ' -1 year')));
                break;
            case 'last365days':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime . " -364 days"));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'last30days':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime . " -30 days"));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime));
                break;
            case 'next30days':
                $data['strddt'] = date('Y-m-d', strtotime($curDateTime));
                $data['enddt'] = date('Y-m-d', strtotime($curDateTime . " +30 days"));
                break;
            case 'alldates':
                /* unset($data['strddt']);unset($data['enddt']);$timelog_filter_msg = ''; */
                break;
            case 'custom':break;
            default:break;
        }
        return $data;
    }

		public function getQuarter($curDateTime){
			$curDateTime = $curDateTime != "" ? $curDateTime : date('Y-m-d H:i:s');
			$data = [];
			$month = date("m", strtotime($curDateTime));
			if ($month < 4) {
					$start = 'first day of january';
					$end = 'last day of march';
			} elseif ($month > 3 && $month < 7) {
					$start = 'first day of april';
					$end = 'last day of june';
			} elseif ($month > 6 && $month < 10) {
					$start = 'first day of july';
					$end = 'last day of september';
			} elseif ($month > 9) {
					$start = 'first day of october';
					$end = 'last day of december';
			}
			
			$data['strddt'] = date('Y-m-d', strtotime($start, strtotime($curDateTime)));
			$data['enddt'] = date('Y-m-d', strtotime($end, strtotime($curDateTime))); 
			
			return $data;
		}
    public function caseMemsName($uid)
    {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('list', array('conditions' => array('User.id' => $uid, 'User.isactive' => 1), 'fields' => array('User.name')));
        if (count($usrDtls) == 1) {
            $memlist = array_values($usrDtls);
            return $memlist[0];
        } else {
            return $usrDtls;
        }
    }
    public function caseMilestonesName($mid, $send_arr=0)
    {
        $Milestone = ClassRegistry::init('Milestone');
        $Milestone->recursive = -1;
        $mlDtls = $Milestone->find('list', array('conditions' => array('Milestone.id' => $mid, 'Milestone.isactive' => 1), 'fields' => array('Milestone.title')));
        if (count($mlDtls) == 1) {
            $memlist = array_values($mlDtls);
            return ($send_arr) ? $memlist : $memlist[0];
        } else {
            return $mlDtls;
        }
    }

    public function generateRandomString($str, $length = 2)
    {
        $str = str_replace(" ", "", $str);
        $characters = str_split($str);
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function getCurrencyCode($invId)
    {
        $currency = ClassRegistry::init('Currency');
        $currencyCode = $currency->query('SELECT code FROM currencies WHERE id=' . $invId);
        if ($currencyCode) {
            return $currencyCode[0]['currencies']['code'];
        } else {
            return 0;
        }
    }

    public function getDateFromYearAndMonth($year = '', $month = '', $curDateTime = '')
    {
        $curDateTime = $curDateTime != "" ? $curDateTime : date('Y-m-d H:i:s');
        $data = array();
        $start = 1;
        $end = 31;

        if ($month == '') {
            $month = date("m", strtotime($curDateTime));
        }
        if ($year == '') {
            $year = date("Y", strtotime($curDateTime));
        }
        $month30Arr = array(4, 6, 9, 11);
        if ((int) $month != 2 && in_array((int) $month, $month30Arr)) {
            $end = 30;
        } else {
            if ((int) $month == 2 && ($year % 4 == 0 || $year % 100 == 0 || $year % 400 == 0)) {
                $end = 29;
            } elseif ((int) $month == 2) {
                $end = 28;
            }
        }

        $data['strddt'] = date('Y-m-d', strtotime($year . '-' . $month . '-' . $start));
        $data['enddt'] = date('Y-m-d', strtotime($year . '-' . $month . '-' . $end));

        return $data;
    }

    public function seconds2human($ss)
    {
        $h = floor($ss / 3600);
        $m = floor($ss / 60 % 60);
        if ($h && $m) {
            $hrs = ($h == 1) ? 'hr' : 'hrs';
            return "$h $hrs $m mins";
        } elseif ($h) {
            $hrs = ($h == 1) ? 'hr' : 'hrs';
            return "$h $hrs";
        } elseif ($m) {
            return "$m mins";
        } else {
            return "";
        }
    }

    public function seconds2fraction($ss)
    {
        $h = floor($ss / 3600);
        if ($h) {
            $m = floor($ss / 60 % 60);
            $mi = ($m) ? ":" . round($m, 2) : '';
            return $h . $mi . " h";
        } else {
            $m = floor($ss / 60 % 60);
            return round($m, 2) . " m";
        }
    }
    /* To get the Recurrence Rule according to the input given by the user
         */
    public function getRRule($recurrenceDetail, $type = 'test')
    {
        $frequency = $interval = $byday = $bymonthday = $byweekno = $bymonth ='';
        $startDate = $recurrenceDetail['recur_start_date'];
        $endDate = $recurrenceDetail['recurrence_end_type'] == 'date' ? $recurrenceDetail['recur_end_date'] : '';
        $occurrences = $recurrenceDetail['recurrence_end_type'] == 'occurrances' ? $recurrenceDetail['occurrances'] : '10';
        if ($recurrenceDetail['recurrence_end_type'] == 'date') {
            $occurrences='';
        }
        switch ($recurrenceDetail['recur_pattern']) {
            case 'daily':
                $frequency = 'DAILY';
                $interval = $recurrenceDetail['daily_interval'];
                if ($recurrenceDetail['daily_check'] == 'interval') {
                    $byday = '';
                } else {
                    $byday = 'MO,TU,WE,TH,FR';
                }
                break;
            case 'weekly':
                $frequency = 'WEEKLY';
                $interval = $recurrenceDetail['weekly_interval'];
                $byday = $recurrenceDetail['weekly_days'];
                break;
            case 'monthly':
                $frequency = 'MONTHLY';
                $interval = $recurrenceDetail['monthly_interval'];
                $bymonthday = $recurrenceDetail['monthly_date'];
                if ($recurrenceDetail['monthly_check'] == 'complecated') {
                    $byweekno = $recurrenceDetail['monthly_mask'];
                    $byday = $recurrenceDetail['monthly_day'];
                    $interval = $recurrenceDetail['monthly_interval_complete'];
                }
                break;
            case 'yearly':
                $frequency = 'YEARLY';
                $interval = $recurrenceDetail['yearly_interval'];
                $bymonthday = $recurrenceDetail['yearly_date'];
                $bymonth = $recurrenceDetail['yearly_month'];
                if ($recurrenceDetail['yearly_check'] == 'complecated') {
                    $byday = $recurrenceDetail['yearly_day'];
                    $byweekno = $recurrenceDetail['yearly_mask'];
                    $bymonth = $recurrenceDetail['yearly_month_complete'];
                }
                break;
        }
        include_once ROOT . '/app/Vendor/php-rrule/src/RRuleInterface.php';
        include_once ROOT . '/app/Vendor/php-rrule/src/RRule.php';
        include_once ROOT . '/app/Vendor/php-rrule/src/RSet.php';
        $rrule = new RRule(array(
            'FREQ' => $frequency,
            'INTERVAL' => (is_numeric($interval) && $interval != 0)?round($interval):1,
            'BYMONTHDAY' => $bymonthday,
            'BYDAY' => $byday,
            'BYWEEKNO' => $byweekno,
            'BYMONTH' => $bymonth,
            'DTSTART' => ($startDate !='')?$startDate:date('Y-m-d'),
            'COUNT' => $occurrences,
            'UNTIL' => $endDate
        ));
        return $rrule;
    }
    /*
     * Author: Satyajeet
     * To check current date is in recurring date array or not
     */
    public function checkDateInRecurring($recurringDetails, $date)
    {
        include_once ROOT . '/app/Vendor/rrule/src/RRuleInterface.php';
        include_once ROOT . '/app/Vendor/rrule/src/RRule.php';
        include_once ROOT . '/app/Vendor/rrule/src/RSet.php';
        $recurr_dayy = ($recurringDetails['byweekno'] == 5)? -1 : $recurringDetails['byweekno'];
        $recurringDetails['bymonthday'] = ($recurringDetails['byday']) ? '' : $recurringDetails['bymonthday'];
        if ($recurringDetails['frequency'] == 'WEEKLY') {
            $ocrce = ($recurringDetails['occurrences']) ? $recurringDetails['occurrences'] : '';
        } elseif ($recurringDetails['frequency'] == 'DAILY') {
            $ocrce = ($recurringDetails['occurrences']) ? ($recurringDetails['occurrences']+1): '';
        } elseif ($recurringDetails['frequency'] == 'MONTHLY') {
            $ocrce = ($recurringDetails['occurrences']) ? ($recurringDetails['occurrences']+1): '';
        } elseif ($recurringDetails['frequency'] == 'YEARLY') {
            $ocrce = ($recurringDetails['occurrences']) ? ($recurringDetails['occurrences']+1): '';
        }
        $args = array(
            'FREQ' => $recurringDetails['frequency'],
            'INTERVAL' => $recurringDetails['rec_interval'],
            'BYMONTHDAY' => $recurringDetails['bymonthday'],
            'BYDAY' => $recurr_dayy.$recurringDetails['byday'],
           // 'BYWEEKNO' => $recurringDetails['byweekno'],
            'BYMONTH' => $recurringDetails['bymonth'],
            'DTSTART' => $recurringDetails['start_date'],
            'COUNT' => $ocrce,
            'UNTIL' => ($recurringDetails['occurrences']) ? '' : (empty($recurringDetails['end_date'])?$date:$recurringDetails['end_date'])
        );
        $rrule = new RRule($args);
        $occurrenceDates = $rrule->getOccurrences();
        foreach ($occurrenceDates as $k => $orrcurrences) {
            $orrcurrence = $orrcurrences->format('Y-m-d');
            if (strtotime($date) == strtotime($orrcurrence)) {
                return $k;
            }
        }
        return 0;
    }
    /*function checkDateInRecurring($recurringDetails, $date) {
        include_once ROOT . '/app/Vendor/php-rrule/src/RRuleInterface.php';
        include_once ROOT . '/app/Vendor/php-rrule/src/RRule.php';
        include_once ROOT . '/app/Vendor/php-rrule/src/RSet.php';
        $rrule = new RRule(array(
            'FREQ' => $recurringDetails['frequency'],
            'INTERVAL' => $recurringDetails['rec_interval'],
            'BYMONTHDAY' => $recurringDetails['bymonthday'],
            'BYDAY' => $recurringDetails['byday'],
            'BYWEEKNO' => $recurringDetails['byweekno'],
            'BYMONTH' => $recurringDetails['bymonth'],
            'DTSTART' => $recurringDetails['start_date'],
            'COUNT' => '',
            'UNTIL' => $date
        ));
        $occurrenceDates = $rrule->getOccurrences();
        foreach($occurrenceDates as $k => $orrcurrences){
            $orrcurrence = $orrcurrences->format('Y-m-d');
            if($date == $orrcurrence){
                return $k+1;
            }
        }
        return 0;
    }*/
    public function getRecurring($recurringDetails, $date)
    {
        include_once ROOT . '/app/Vendor/php-rrule/src/RRuleInterface.php';
        include_once ROOT . '/app/Vendor/php-rrule/src/RRule.php';
        include_once ROOT . '/app/Vendor/php-rrule/src/RSet.php';
        $recurr_dayy = $recurringDetails['byweekno'] == 5 ? -1 : $recurringDetails['byweekno'];
        $recurringDetails['bymonthday'] = $recurringDetails['byday'] ? '' : $recurringDetails['bymonthday'];
        if ($recurringDetails['frequency'] == 'WEEKLY') {
            $ocrce = ($recurringDetails['occurrences']) ? $recurringDetails['occurrences'] : '';
        } elseif ($recurringDetails['frequency'] == 'DAILY') {
            $ocrce = ($recurringDetails['occurrences']) ? ($recurringDetails['occurrences']+1): '';
        } elseif ($recurringDetails['frequency'] == 'MONTHLY') {
            $ocrce = ($recurringDetails['occurrences']) ? ($recurringDetails['occurrences']+1): '';
        } elseif ($recurringDetails['frequency'] == 'YEARLY') {
            $ocrce = ($recurringDetails['occurrences']) ? ($recurringDetails['occurrences']+1): '';
        }
        $rrule = new RRule(array(
            'FREQ' => $recurringDetails['frequency'],
            'INTERVAL' => $recurringDetails['rec_interval'],
            'BYMONTHDAY' => $recurringDetails['bymonthday'],
            'BYDAY' => $recurr_dayy.$recurringDetails['byday'],
         //   'BYWEEKNO' => $recurringDetails['byweekno'],
            'BYMONTH' => $recurringDetails['bymonth'],
            'DTSTART' => $recurringDetails['start_date'],
            //'COUNT' => ($recurringDetails['occurrences']) ? ($recurringDetails['occurrences'] + 1) : 6
            'COUNT' => $ocrce,
                        'UNTIL' => ($recurringDetails['occurrences']) ? '' : (empty($recurringDetails['end_date'])?$date:$recurringDetails['end_date'])
        ));
        $occurrenceDates = $rrule->getOccurrences();
        $occurrenceDates1 = array();
        foreach ($occurrenceDates as $k=>$v) {
            if (strtotime($date) < strtotime($v->format('Y-m-d'))) {
                $occurrenceDates1[] =  $v->format('l, d F Y');
            }
        }
        return $occurrenceDates1;
    }
    public function getApiStatus($type, $legend)
    {
        if ($type == 10) {
            return 'Update';
        } elseif ($legend == 1) {
            return 'New';
        } elseif ($legend == 2 || $legend == 4) {
            return 'In Progress';
        } elseif ($legend == 3) {
            return 'Closed';
        } elseif ($legend == 5) {
            return 'Resolved';
        }
    }
    public function getLeaveDates($start_date, $end_date, $id)
    {
        $start_date = date('Y-m-d', strtotime($start_date));
        $end_date = date('Y-m-d', strtotime($end_date));
        $days = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24);
        $x = floor($days);
        if ($x < 7) {
            $interval = 1;
        } elseif ($x > 80) {
            $interval = ceil($x / 10);
        } else {
            $interval = 7;
        }
        $dt_arr = array();
        for ($i = 0; $i <= $x; $i++) {
            $m = " +" . $i . "day";
            $dt = date('Y-m-d', strtotime(date("Y-m-d", strtotime($start_date)) . $m));
            $dt_arr = array_merge($dt_arr, array($dt => $id));
        }
        return $dt_arr;
    }
    public function overloadUsersUpdtedRecurringTasks($args = array(), $obj)
    {
        set_time_limit(0);
        $callee = $args;
        $assigned_Resource_id = $callee['assignTo'];
        $estimated_hrs = $callee['est_hr'];
        $assigned_Resource_project = $callee['projectId'];
        $assigned_userId = $callee['userId'];
        $assigned_Resource_company = $callee['companyId'];
        $caseId = $callee['caseId'];
        $caseUniqId = $callee['caseUniqId'];
        $WorkHour = ClassRegistry::init('WorkHour');
        $whl= $WorkHour->find('list', array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>$assigned_Resource_company),'order'=>array('created DESC')), false);
        $perDayWorkSec =$this->getworkhr($whl, date('Y-m-d'));
        $perDayWorkSec = $perDayWorkSec * 3600;
        $Company = ClassRegistry::init('Company');
        $getAppComp = $Company->query("SELECT CompanyUser.user_type,CompanyUser.company_id,Company.logo,Company.website,Company.name,Company.is_active,Company.is_deactivated,Company.created,Company.uniq_id,Company.is_skipped,Company.twitted,Company.work_hour,Company.week_ends  FROM company_users AS CompanyUser,companies AS Company WHERE CompanyUser.company_id=Company.id AND CompanyUser.user_id='" . $assigned_userId . "' AND Company.seo_url='" . CHECK_DOMAIN . "'");
            
        //$weekendArr = explode(',',$GLOBALS['company_week_ends']);
        $weekendArr = explode(',', $getAppComp['0']['Company']['week_ends']);
            
        /*$estArr = explode(":", $estimated_hrs);
        $estStr = ($estArr[0] * 3600);
        if(isset($estArr[1])){
            $estStr += ($estArr[1] * 60);
        }*/
        $estStr = $estimated_hrs;
        $no_of_days = $nof_of_days_lv = ceil((int)$estStr / (int)$perDayWorkSec);
        $nofD=$no_of_days -1;
            
        $startdate = $assigned_Resource_date = date('Y-m-d', strtotime($callee['str_date']));
        //$assigned_Resource_date_gmt = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($assigned_Resource_date." 00:00:01"), "datetime");
        $assigned_Resource_date_gmt = $this->Tmzone->convert_to_utc($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], trim($assigned_Resource_date." 00:00:01"), "datetime");
        $lastdate = $assigned_Resource_date;
        $CompanyHoliday = ClassRegistry::init('CompanyHoliday');
        $holidayListsGlobal = $CompanyHoliday->find('all', array('fields'=>array('holiday'),'conditions'=>array('company_id'=>$assigned_Resource_company,'or' => array('holiday >=' => GMT_DATETIME)),'order'=>array('created ASC')));
        $cho = array();
        $view = new View($obj);
        $tz = $view->loadHelper('Tmzone');
        foreach ($holidayListsGlobal as $k=>$v) {
            $cho[] = $tz->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['CompanyHoliday']['holiday'], "date");
        }
        $company_holiday = implode(',', $cho);
            
        //$holdy = explode(',',$GLOBALS['company_holiday']);
        $holdy = explode(',', $company_holiday);
        while ($nofD > 0) {
            $lastdate = date('Y-m-d', strtotime($lastdate . " +1 days"));
            if (!in_array(date('w', strtotime($lastdate)), $weekendArr) && !in_array(date('Y-m-d', strtotime($lastdate)), $holdy)) { //&& array1.indexOf(date.format('YYYY-MM-DD').toString()) == -1
                $nofD -= 1;
            }
        }
        /** change the last date and the no of days if due date is set **/
        if (isset($callee['CS_due_date']) && !empty($callee['CS_due_date'])) {
            $lastdate = date('Y-m-d', strtotime($callee['CS_due_date']));
            $no_of_days = round((strtotime($lastdate) -  strtotime($assigned_Resource_date)) / 86400) + 1;
        }
        /** END **/
        $OverloadModel = ClassRegistry::init('Overload');
        $ProjectBookedResourceModel = ClassRegistry::init('ProjectBookedResource');
        $UserLeaveModel = ClassRegistry::init('UserLeave');
            
        $leaves = $UserLeaveModel->find('all', array('conditions' => array('UserLeave.company_id' => $assigned_Resource_company, 'UserLeave.user_id' => $assigned_Resource_id)), false);
        $CompanyHoliday = ClassRegistry::init('CompanyHoliday');
        $hLists = $CompanyHoliday->find('all', array('fields'=>array('holiday','description'),'conditions'=>array('company_id'=>$assigned_Resource_company,'or' => array('holiday >=' => $assigned_Resource_date_gmt,'holiday >=' => $assigned_Resource_date_gmt)),'order'=>array('created ASC')), false);
        foreach ($hLists as $k=>$v) {
            $arr = array();
            $arr['start_date'] = $v['CompanyHoliday']['holiday'];
            #$arr['end_date'] = $v['CompanyHoliday']['holiday'];
            $arr['end_date'] = date('Y-m-d H:i:s', strtotime($v['CompanyHoliday']['holiday'] . " +" . 86398 . " seconds"));
            $leaves[]['UserLeave'] = $arr;
        }
            
        #$lastdatetime = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($lastdate." 00:00:01"), "datetime");
        $lastdatetime = $this->Tmzone->convert_to_utc($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], trim($lastdate." 00:00:01"), "datetime");
        $lastdatetimestamp = strtotime($lastdatetime);
        $working_dates = array();
        $do = $no_of_days;
        while ($lastdatetimestamp >= strtotime($assigned_Resource_date_gmt)) {
            $inleave = $this->Postcase->checkDateInLeave($assigned_Resource_date_gmt, $leaves);
            #$day_name = date('w',strtotime($this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,$assigned_Resource_date_gmt,'date')));
            $day_name = date('w', strtotime($this->Tmzone->GetDateTime($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], $assigned_Resource_date_gmt, 'date')));
            if (!in_array($day_name, $weekendArr)) {
                if (!$inleave) {
                    $working_dates[] = $assigned_Resource_date_gmt;
                    $do--;
                }
            }
            $assigned_Resource_date_gmt = date('Y-m-d H:i:s', strtotime($assigned_Resource_date_gmt . " +" . 1 . " days"));
        }
           
        $partial_days = array();
        $actual_time_covered  = 0;
        foreach ($working_dates as $key => $value) {
            $query = "SELECT `ProjectBookedResource`.`booked_hours`, `ProjectBookedResource`.`id`, `ProjectBookedResource`.`company_id`, `ProjectBookedResource`.`project_id`, `ProjectBookedResource`.`easycase_id`, `ProjectBookedResource`.`user_id`, `ProjectBookedResource`.`date` FROM `project_booked_resources` AS `ProjectBookedResource` WHERE `ProjectBookedResource`.`company_id` = " . $assigned_Resource_company . " AND `ProjectBookedResource`.`user_id` = " . $assigned_Resource_id . " AND `ProjectBookedResource`.`date` >= '" . $value . "' AND `ProjectBookedResource`.`date` <= '" . date('Y-m-d H:i:s', strtotime($value.' +86390 seconds')) . "'  ORDER BY `ProjectBookedResource`.`date` DESC ";
            $hours_booked = $ProjectBookedResourceModel->query($query, false);
            #$value_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $value, "date");
            $value_dt = $this->Tmzone->GetDateTime($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], $value, "date");
            if (!empty($hours_booked)) {
                $booked_hours = 0;
                foreach ($hours_booked as $kv=>$vv) {
                    $booked_hours += $vv['ProjectBookedResource']['booked_hours'];
                    $partial_days[$value_dt] = $booked_hours;
                }
            } else {
                $partial_days[$value_dt] = 0;
            }
                
            if ($actual_time_covered < $estStr) {
                $actual_time_covered += $perDayWorkSec - $partial_days[$value_dt];
            } else {
                unset($partial_days[$value_dt]);
                break;
            }
        }
           
        #print_r($working_dates);exit;
        $due_date =date('Y-m-d', strtotime($callee['CS_due_date']));
        if (empty($partial_days)) {
            $overload_hours = $ovhrs = $estStr / $no_of_days;
            $overload = array();
            foreach ($working_dates as $key => $value) {
                if ($value < $perDayWorkSec) {
                    $newDate = $due_date = $value;
                    $overload[] = array('date'=>$newDate,'easycase_id'=>$caseId,'project_id'=>$assigned_Resource_project,'user_id'=>$assigned_Resource_id,'company_id'=>$assigned_Resource_company,'overload'=>$overload_hours);
                }
            }
            $OverloadModel->create();
            $OverloadModel->saveAll($overload);
        } else {
            $estimated_hrss = $estStr;
            foreach ($partial_days as $key => $value) {
                if ($value < $perDayWorkSec) {
                    $pr_bk_hrs['ProjectBookedResource'] = array();
                    #$newDate = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($key." 00:00:01"), "datetime");
                    $newDate = $this->Tmzone->convert_to_utc($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], trim($key." 00:00:01"), "datetime");
                    $a = $perDayWorkSec - $value;
                    $valWorkSec = ($estimated_hrss < $perDayWorkSec)?$estimated_hrss:$perDayWorkSec;
                    $a = ($estimated_hrss < $a)?$estimated_hrss:$a;
                    $rest_to_assign = (empty($a)) ? $valWorkSec  : $a;
                    $bookde_val = (empty($a)) ? $valWorkSec : ($a);
                    $pr_bk_hrs['ProjectBookedResource'] = array('user_id' => $assigned_Resource_id, 'date' => $newDate, 'project_id' => $assigned_Resource_project, 'easycase_id' => $caseId, 'company_id' => $assigned_Resource_company, 'booked_hours' => $bookde_val, 'overload' => 0);
                    $ProjectBookedResourceModel->create();
                    $ProjectBookedResourceModel->save($pr_bk_hrs);
                    $estimated_hrss -= $rest_to_assign;
                }
            }
            if ($estimated_hrss) {
                $overload_hours = $estimated_hrss / count($partial_days); //$no_of_days;
                
                $last_date = $partial_days[count($partial_days) - 1];
                $overload = array();
                foreach ($partial_days as $key => $value) {
                    #$newDate = $due_date =  $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($key." 00:00:01"), "datetime");
                    $newDate = $due_date =  $this->Tmzone->convert_to_utc($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], trim($key." 00:00:01"), "datetime");
                    $overload[] = array('date'=>$newDate,'easycase_id'=>$caseId,'project_id'=>$assigned_Resource_project,'user_id'=>$assigned_Resource_id,'company_id'=>$assigned_Resource_company,'overload'=>$overload_hours);
                }
                $OverloadModel->create();
                $OverloadModel->saveAll($overload);
            }
        }
        $EasycaseModel = ClassRegistry::init('Easycase');
        #$startdate_1 = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($startdate." 00:00:01"), "datetime");
        $startdate_1 = $this->Tmzone->convert_to_utc($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], trim($startdate." 00:00:01"), "datetime");
        #$lastdate_1 = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, trim($lastdate." 00:00:01"), "datetime");
        $lastdate_1 = $this->Tmzone->convert_to_utc($callee['user_timezone'], $callee['tmzone_gmt_offset'], $callee['tmzone_dst_offset'], $callee['tmzone_code'], trim($lastdate." 00:00:01"), "datetime");
        $EasycaseModel->updateAll(array('Easycase.assign_to' => $assigned_Resource_id, 'Easycase.gantt_start_date' => '"' . $startdate_1 . '"', 'Easycase.due_date' => '"' . $lastdate_1 . '"'), array('Easycase.id' => $caseId));
        return 1;
    }
    public function overloadUsersUpdted($args = array(), $comp_id=null, $tzone=array())
    {
        set_time_limit(0);
        $ses_tzone = SES_TIMEZONE;
        $ses_tzgmt = TZ_GMT;
        $ses_tzdst = TZ_DST;
        $ses_tzcod = TZ_CODE;
        if (!empty($tzone)) {
            $ses_tzone = $tzone['Timezone']['id'];
            $ses_tzgmt = $tzone['Timezone']['gmt_offset'];
            $ses_tzdst = 0;
            $ses_tzcod = $tzone['Timezone']['code'];
        }
        $comp_id = (SES_COMP == 'SES_COMP')?$comp_id:SES_COMP;
        $callee = $args;
        $assigned_Resource_id = $callee['assignTo'];
        $estimated_hrs = $callee['est_hr'];
        $assigned_Resource_project = $callee['projectId'];
        $caseId = $callee['caseId'];
        $caseUniqId = $callee['caseUniqId'];
        $WorkHour = ClassRegistry::init('WorkHour');
        $whl= $WorkHour->find('list', array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>$comp_id),'order'=>array('created DESC')), false);
        $perDayWorkSec =$this->getworkhr($whl, date('Y-m-d'));
        $perDayWorkSec = $perDayWorkSec * 3600;
        $weekendArr = explode(',', $GLOBALS['company_week_ends']);
            
        $estArr = explode(":", $estimated_hrs);
        $estStr = ($estArr[0] * 3600);
        if (isset($estArr[1])) {
            $estStr += ($estArr[1] * 60);
        }
        $no_of_days = $nof_of_days_lv = ceil((int)$estStr / (int)$perDayWorkSec);
        $nofD=$no_of_days -1;
            
        $startdate = $assigned_Resource_date = date('Y-m-d', strtotime($callee['str_date']));
        $assigned_Resource_date_gmt = $this->Tmzone->convert_to_utc($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, trim($assigned_Resource_date." 00:00:01"), "datetime");
        $lastdate = $assigned_Resource_date;
        $holdy = explode(',', $GLOBALS['company_holiday']);
        while ($nofD > 0) {
            $lastdate = date('Y-m-d', strtotime($lastdate . " +1 days"));
            if (!in_array(date('w', strtotime($lastdate)), $weekendArr) && !in_array(date('Y-m-d', strtotime($lastdate)), $holdy)) { //&& array1.indexOf(date.format('YYYY-MM-DD').toString()) == -1
                $nofD -= 1;
            }
        }
        /** change the last date and the no of days if due date is set **/
        if (isset($callee['CS_due_date']) && !empty($callee['CS_due_date'])) {
            $lastdate = date('Y-m-d', strtotime($callee['CS_due_date']));
            $no_of_days = round((strtotime($lastdate) -  strtotime($assigned_Resource_date)) / 86400) + 1;
        }
        /** END **/
        $OverloadModel = ClassRegistry::init('Overload');
        $ProjectBookedResourceModel = ClassRegistry::init('ProjectBookedResource');
        $UserLeaveModel = ClassRegistry::init('UserLeave');
            
        $leaves = $UserLeaveModel->find('all', array('conditions' => array('UserLeave.company_id' => $comp_id, 'UserLeave.user_id' => $assigned_Resource_id)), false);
        $CompanyHoliday = ClassRegistry::init('CompanyHoliday');
        $hLists = $CompanyHoliday->find('all', array('fields'=>array('holiday','description'),'conditions'=>array('company_id'=>$comp_id,'or' => array('holiday >=' => $assigned_Resource_date_gmt,'holiday >=' => $assigned_Resource_date_gmt)),'order'=>array('created ASC')), false);
        foreach ($hLists as $k=>$v) {
            $arr = array();
            $arr['start_date'] = $v['CompanyHoliday']['holiday'];
            #$arr['end_date'] = $v['CompanyHoliday']['holiday'];
            $arr['end_date'] = date('Y-m-d H:i:s', strtotime($v['CompanyHoliday']['holiday'] . " +" . 86398 . " seconds"));
            $leaves[]['UserLeave'] = $arr;
        }
            
        $lastdatetime =  $this->Tmzone->convert_to_utc($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, trim($lastdate." 00:00:01"), "datetime");
        $lastdatetimestamp = strtotime($lastdatetime);
        $working_dates = array();
        $do = $no_of_days;
        while ($lastdatetimestamp >= strtotime($assigned_Resource_date_gmt)) {
            $inleave = $this->Postcase->checkDateInLeave($assigned_Resource_date_gmt, $leaves);
            $day_name = date('w', strtotime($this->Tmzone->GetDateTime($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, $assigned_Resource_date_gmt, 'date')));
            if (!in_array($day_name, $weekendArr)) {
                if (!$inleave) {
                    $working_dates[] = $assigned_Resource_date_gmt;
                    $do--;
                }
            }
            $assigned_Resource_date_gmt = date('Y-m-d H:i:s', strtotime($assigned_Resource_date_gmt . " +" . 1 . " days"));
        }
           
        $partial_days = array();
        $actual_time_covered  = 0;
        foreach ($working_dates as $key => $value) {
            $query = "SELECT `ProjectBookedResource`.`booked_hours`, `ProjectBookedResource`.`id`, `ProjectBookedResource`.`company_id`, `ProjectBookedResource`.`project_id`, `ProjectBookedResource`.`easycase_id`, `ProjectBookedResource`.`user_id`, `ProjectBookedResource`.`date` FROM `project_booked_resources` AS `ProjectBookedResource` WHERE `ProjectBookedResource`.`company_id` = " . $comp_id . " AND `ProjectBookedResource`.`user_id` = " . $assigned_Resource_id . " AND `ProjectBookedResource`.`date` >= '" . $value . "' AND `ProjectBookedResource`.`date` <= '" . date('Y-m-d H:i:s', strtotime($value.' +86390 seconds')) . "'  ORDER BY `ProjectBookedResource`.`date` DESC ";
            $hours_booked = $ProjectBookedResourceModel->query($query, false);
            $value_dt = $this->Tmzone->GetDateTime($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, $value, "date");
            if (!empty($hours_booked)) {
                $booked_hours = 0;
                foreach ($hours_booked as $kv=>$vv) {
                    $booked_hours += $vv['ProjectBookedResource']['booked_hours'];
                    $partial_days[$value_dt] = $booked_hours;
                }
            } else {
                $partial_days[$value_dt] = 0;
            }
                
            if ($actual_time_covered < $estStr) {
                $actual_time_covered += $perDayWorkSec - $partial_days[$value_dt];
            } else {
                unset($partial_days[$value_dt]);
                break;
            }
        }
           
        #print_r($working_dates);exit;
        $due_date =date('Y-m-d', strtotime($callee['CS_due_date']));
        if (empty($partial_days)) {
            $overload_hours = $ovhrs = $estStr / $no_of_days;
            $overload = array();
            foreach ($working_dates as $key => $value) {
                if ($value < $perDayWorkSec) {
                    $newDate = $due_date = $value;
                    $overload[] = array('date'=>$newDate,'easycase_id'=>$caseId,'project_id'=>$assigned_Resource_project,'user_id'=>$assigned_Resource_id,'company_id'=>$comp_id,'overload'=>$overload_hours);
                }
            }
            $OverloadModel->create();
            $OverloadModel->saveAll($overload);
        } else {
				$estimated_hrss = $estStr;
            foreach ($partial_days as $key => $value) {
                if ($value < $perDayWorkSec) {
                    $pr_bk_hrs['ProjectBookedResource'] = array();
                    $newDate = $this->Tmzone->convert_to_utc($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, trim($key." 00:00:01"), "datetime");
                    $a = $perDayWorkSec - $value;
                    $valWorkSec = ($estimated_hrss < $perDayWorkSec)?$estimated_hrss:$perDayWorkSec;
                    $a = ($estimated_hrss < $a)?$estimated_hrss:$a;
                    $rest_to_assign = (empty($a)) ? $valWorkSec  : $a;
                    $bookde_val = (empty($a)) ? $valWorkSec : ($a);
                    $pr_bk_hrs['ProjectBookedResource'] = array('user_id' => $assigned_Resource_id, 'date' => $newDate, 'project_id' => $assigned_Resource_project, 'easycase_id' => $caseId, 'company_id' => $comp_id, 'booked_hours' => $bookde_val, 'overload' => 0);
                    $ProjectBookedResourceModel->create();
                    $ProjectBookedResourceModel->save($pr_bk_hrs);
                    $estimated_hrss -= $rest_to_assign;
                }
            }
            if ($estimated_hrss) {
                $overload_hours = $estimated_hrss / count($partial_days); //$no_of_days;

                $last_date = $partial_days[count($partial_days) - 1];
                $overload = array();
                foreach ($partial_days as $key => $value) {
                    $newDate = $due_date =  $this->Tmzone->convert_to_utc($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, trim($key." 00:00:01"), "datetime");
                    $overload[] = array('date'=>$newDate,'easycase_id'=>$caseId,'project_id'=>$assigned_Resource_project,'user_id'=>$assigned_Resource_id,'company_id'=>$comp_id,'overload'=>$overload_hours);
                }
                $OverloadModel->create();
                $OverloadModel->saveAll($overload);
            }
        }
        $EasycaseModel = ClassRegistry::init('Easycase');
        $startdate_1 = $this->Tmzone->convert_to_utc($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, trim($startdate." 00:00:01"), "datetime");
        $lastdate_1 = $this->Tmzone->convert_to_utc($ses_tzone, $ses_tzgmt, $ses_tzdst, $ses_tzcod, trim($lastdate." 00:00:01"), "datetime");
        $EasycaseModel->updateAll(array('Easycase.assign_to' => $assigned_Resource_id, 'Easycase.gantt_start_date' => '"' . $startdate_1 . '"', 'Easycase.due_date' => '"' . $lastdate_1 . '"'), array('Easycase.id' => $caseId));
        return 1;
    }
    public function overloadUsers($callee = null)
    {
        $assigned_Resource_id = $callee['assignTo'];
        $estimated_hrs = $callee['est_hr'];
        $assigned_Resource_project = $callee['projectId'];
        $caseId = $callee['caseId'];
        $WorkHour = ClassRegistry::init('WorkHour');
        $whl= $WorkHour->find('list', array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>SES_COMP),'order'=>array('created DESC')));
        //$perDayWorkSec =$GLOBALS['company_work_hour'] * 3600;
        $perDayWorkSec =$this->getworkhr($whl, date('Y-m-d'));
        $perDayWorkSec =$perDayWorkSec * 3600;
        $caseUniqId = $callee['caseUniqId'];
        $no_of_days = $nof_of_days_lv = ceil(($estimated_hrs * 3600) / $perDayWorkSec);
        $startdate = $assigned_Resource_date = date('Y-m-d', strtotime($callee['str_date']));
        $lastdate = date('Y-m-d', strtotime($assigned_Resource_date . " +" . ($no_of_days - 1) . "days"));
        $Overload = ClassRegistry::init('Overload');
        $ProjectBookedResource = ClassRegistry::init('Timelog.ProjectBookedResource');
        $UserLeave = ClassRegistry::init('UserLeave');
        $leaves = $UserLeave->find('all', array('conditions' => array('UserLeave.company_id' => SES_COMP, 'UserLeave.user_id' => $assigned_Resource_id)));

        $CompanyHoliday = ClassRegistry::init('CompanyHoliday');
        $hLists = $CompanyHoliday->find('all', array('fields'=>array('holiday','description'),'conditions'=>array('company_id'=>SES_COMP,'or' => array('holiday >=' => $callee['str_date'],'holiday >=' =>$callee['str_date'])),'order'=>array('created ASC')));
        foreach ($hLists as $k=>$v) {
            $arr = array();
            $arr['start_date'] = $v['CompanyHoliday']['holiday'];
            #$arr['end_date'] = $v['CompanyHoliday']['holiday'];
            $arr['end_date'] = date('Y-m-d H:i:s', strtotime($v['CompanyHoliday']['holiday'] . " +" . 86398 . " seconds"));
            $leaves[]['UserLeave'] = $arr;
        }
        $working_dates = array();
        $do = $no_of_days;
        while ($do > 0) {
            $inleave = $this->Postcase->checkDateInLeave($assigned_Resource_date, $leaves);
            if (!$inleave) {
                $working_dates[] = $assigned_Resource_date;
                $do--;
            }
            $assigned_Resource_date = date('Y-m-d', strtotime($assigned_Resource_date . " +" . 1 . " days"));
        }
        $partial_days = array();
        foreach ($working_dates as $key => $value) {
            $query = "SELECT SUM(`ProjectBookedResource`.`booked_hours`) AS booked_hrs, `ProjectBookedResource`.`id`, `ProjectBookedResource`.`company_id`, `ProjectBookedResource`.`project_id`, `ProjectBookedResource`.`easycase_id`, `ProjectBookedResource`.`user_id`, `ProjectBookedResource`.`date` FROM `project_booked_resources` AS `ProjectBookedResource` WHERE `ProjectBookedResource`.`company_id` = " . SES_COMP . " AND `ProjectBookedResource`.`user_id` = " . $assigned_Resource_id . " AND DATE(`ProjectBookedResource`.`date`) = '" . date('Y-m-d', strtotime($value)) . "' GROUP BY `ProjectBookedResource`.`date`";
            $hours_booked = $ProjectBookedResource->query($query);
            if (!empty($hours_booked)) {
                $booked_hours = $hours_booked[0][0]['booked_hrs'];
                $all_hours_taken = ($booked_hours == $perDayWorkSec) ? true : false;
                if (!$all_hours_taken) {
                    $partial_days[$value] = $booked_hours;
                }
            } else {
                $partial_days[$value] = $perDayWorkSec;
            }
        }
        $due_date = date('Y-m-d', strtotime($startdate));
        if (empty($partial_days)) {
            $overload_hours = $ovhrs = ($estimated_hrs / $no_of_days) * 3600;
            $overload = array();
            foreach ($working_dates as $key => $value) {
                $newDate = $due_date = date('Y-m-d', strtotime($value));
                $load_data = $ProjectBookedResource->find('all', array('conditions' => array('ProjectBookedResource.user_id' => $assigned_Resource_id, 'ProjectBookedResource.company_id' => SES_COMP, 'DATE(ProjectBookedResource.date) =' => $newDate)));
                $overload[] = array('date' => $newDate, 'easycase_id' => $caseId, 'project_id' => $assigned_Resource_project, 'user_id' => $assigned_Resource_id, 'company_id' => SES_COMP, 'overload' => $overload_hours);
            }
            $Overload->saveAll($overload);
        } else {
            $estimated_hrss = $estimated_hrs;
            foreach ($partial_days as $key => $value) {
                $pr_bk_hrs['ProjectBookedResource'] = array();
                $newDate = date('Y-m-d', strtotime($key));
                $a = $perDayWorkSec - $value;
                $rest_to_assign = (empty($a)) ? ($perDayWorkSec / 3600) : ($a) / 3600;
                $bookde_val = (empty($a)) ? $perDayWorkSec : ($a);
                $pr_bk_hrs['ProjectBookedResource'] = array('user_id' => $assigned_Resource_id, 'date' => $newDate, 'project_id' => $assigned_Resource_project, 'easycase_id' => $caseId, 'company_id' => SES_COMP, 'booked_hours' => $bookde_val, 'overload' => 0);
                $ProjectBookedResource->create();
                $ProjectBookedResource->save($pr_bk_hrs);
                $estimated_hrss -= $rest_to_assign;
            }
            $overload_hours = ($estimated_hrss / $no_of_days) * 3600;
            $last_date = $working_dates[count($working_dates) - 1];
            $overload = array();
            foreach ($working_dates as $key => $value) {
                $newDate = $due_date = date('Y-m-d', strtotime($value));
                $load_data = $ProjectBookedResource->find('all', array('conditions' => array('ProjectBookedResource.user_id' => $assigned_Resource_id, 'ProjectBookedResource.company_id' => SES_COMP, 'DATE(ProjectBookedResource.date) =' => $newDate)));
                $overload[] = array('date' => $newDate, 'easycase_id' => $caseId, 'project_id' => $assigned_Resource_project, 'user_id' => $assigned_Resource_id, 'company_id' => SES_COMP, 'overload' => $overload_hours);
            }
            $Overload->saveAll($overload);
        }
        $Easycase = ClassRegistry::init('Easycase');
        $Easycase->updateAll(array('Easycase.assign_to' => $assigned_Resource_id, 'Easycase.gantt_start_date' => '"' . GMT_DATETIME . '"', 'Easycase.due_date' => '"' . date('Y-m-d H:i:s', strtotime($working_dates[count($working_dates) - 1])) . '"'), array('Easycase.id' => $caseId));
        return 1;
    }

    /*
     * Delete all booked and overloaded hours from database
     */

    public function delete_booked_hours($data = null, $type=0)
    {
        $easycase_id = $data['easycase_id'];
        $project_id = $data['project_id'];
        $ProjectBookedResource = ClassRegistry::init('ProjectBookedResource');
        $Overload = ClassRegistry::init('Overload');
        $arrRecords = $ProjectBookedResource->find('all', array('conditions' => array('ProjectBookedResource.easycase_id' => $easycase_id, 'ProjectBookedResource.project_id' => $project_id), 'fields' => array('ProjectBookedResource.date,ProjectBookedResource.user_id')));
        $crnt_local_dt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, 'date');
        $crnt_gmt_dt = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $crnt_local_dt." 00:00:01", 'datetime');
        if (!empty($arrRecords)) {
            if ($type == 1) {
            $ProjectBookedResource->deleteAll(array('ProjectBookedResource.easycase_id' => $easycase_id, 'ProjectBookedResource.project_id' => $project_id));
            $Overload->deleteAll(array('Overload.easycase_id' => $easycase_id, 'Overload.project_id' => $project_id));
            } else {
                $ProjectBookedResource->deleteAll(array('ProjectBookedResource.easycase_id' => $easycase_id, 'ProjectBookedResource.project_id' => $project_id,'ProjectBookedResource.date >'=>$crnt_gmt_dt));
                $Overload->deleteAll(array('Overload.easycase_id' => $easycase_id, 'Overload.project_id' => $project_id,'Overload.date >'=>$crnt_gmt_dt));
            }
            $dateArr = array();
            if (count($arrRecords) > 0) {
                foreach ($arrRecords as $k => $v) {
                    $dt = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $v['ProjectBookedResource']['date'], "date");
                    $dateArr[$k]['date'] = $this->Tmzone->convert_to_utc(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $dt . " 00:00:01", "datetime");
                    $dateArr[$k]['user_id'] = $v['ProjectBookedResource']['user_id'];
                }
            }
            $WorkHour = ClassRegistry::init('WorkHour');
            $whl= $WorkHour->find('list', array('fields'=>array('created','work_hours'),'conditions'=>array('company_id'=>SES_COMP),'order'=>array('created DESC')));
            foreach ($dateArr as $k => $v) {
                $getAllHrs = $ProjectBookedResource->find('all', array('conditions' => array('ProjectBookedResource.user_id' => $v['user_id'], 'ProjectBookedResource.date >=' => $v['date'], 'ProjectBookedResource.date <=' => date('Y-m-d H:i:s', strtotime($v['date'] . ' +86390 seconds'))), 'fields' => array('SUM(ProjectBookedResource.booked_hours) AS total')));
                $workhr = $this->getworkhr($whl, date('Y-m-d', strtotime($v['date'])));
                if ($getAllHrs[0][0]['total'] < ($workhr * 3600)) {
                    $allOver = $Overload->find('all', array('conditions' => array('Overload.user_id' => $v['user_id'], 'Overload.date >=' => $v['date'], 'Overload.date <=' => date('Y-m-d H:i:s', strtotime($v['date'] . ' +86390 seconds'))), 'fields' => array('Overload.*'), 'order' => array('Overload.id ASC')));
                    $needUpdateHrs = ($workhr * 3600) - $getAllHrs[0][0]['total'];
                    $updateOver = array();
                    foreach ($allOver as $ak => $av) {
                        if ($needUpdateHrs >= $av['Overload']['overload']) {
                            $needUpdateHrs -= $av['Overload']['overload'];

                            $updateBook['ProjectBookedResource'] = $av['Overload'];
                            $updateBook['ProjectBookedResource']['booked_hours'] = $av['Overload']['overload'];
                            $updateBook['ProjectBookedResource']['overload'] = 0;
                            $updateBook['ProjectBookedResource']['id'] = '';

                            $checkExistance = $ProjectBookedResource->find('first', array('conditions' => array('ProjectBookedResource.easycase_id' => $av['Overload']['easycase_id'], 'ProjectBookedResource.date >=' => $v['date'], 'ProjectBookedResource.date <= ' => date('Y-m-d H:i:s', strtotime($v['date'] . ' +86390 seconds')))));
                            if (count($checkExistance) > 0) {
                                $updateBook['ProjectBookedResource']['id'] = $checkExistance['ProjectBookedResource']['id'];
                                $updateBook['ProjectBookedResource']['booked_hours'] = $av['Overload']['overload'] + $checkExistance['ProjectBookedResource']['booked_hours'];
                            }
                            $ProjectBookedResource->save($updateBook);
                            $Overload->delete($av['Overload']['id']);
                        } else {
                            $Overload->id = $av['Overload']['id'];
                            $Overload->saveField('overload', ($av['Overload']['overload'] - $needUpdateHrs));

                            $updateBook['ProjectBookedResource'] = $av['Overload'];
                            $updateBook['ProjectBookedResource']['booked_hours'] = $needUpdateHrs;
                            $updateBook['ProjectBookedResource']['overload'] = 0;
                            $updateBook['ProjectBookedResource']['id'] = '';


                            $ProjectBookedResource->create();
                            $checkExistance = array();
                            $checkExistance = $ProjectBookedResource->find('first', array('conditions' => array('ProjectBookedResource.easycase_id' => $av['Overload']['easycase_id'], 'ProjectBookedResource.date >=' => $v['date'], 'ProjectBookedResource.date <= ' => date('Y-m-d H:i:s', strtotime($v['date'] . ' +86390 seconds')))));
                            if (count($checkExistance) > 0) {
                                $updateBook['ProjectBookedResource']['id'] = $checkExistance['ProjectBookedResource']['id'];
                                $updateBook['ProjectBookedResource']['booked_hours'] += $checkExistance['ProjectBookedResource']['booked_hours'];
                            }
                            $ProjectBookedResource->save($updateBook);
                            $needUpdateHrs = 0;
                        }
                        if ($needUpdateHrs == 0) {
                            break;
                        }
                    }
                }
            }
        }
        return true;
    }

    /*
     * To check task is active or not
     */

    public function taskIsActive($caseId)
    {
        $Easycase = ClassRegistry::init('Easycase');
        $taskDetails = $Easycase->find('first', array('conditions' => array('Easycase.id' => $caseId), 'fields' => array('Easycase.isactive')));
        return $taskDetails['Easycase']['isactive'];
    }

    /*
     * Check the resource availability On
     */

    public function isResourceAvailabilityOn($sts = null)
    {
        $FeatureSetting = ClassRegistry::init('FeatureSetting');
        $ResourceSetting = ClassRegistry::init('ResourceSetting');
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $setting = $FeatureSetting->find('first', array('conditions' => array('id' => 1), 'fields' => array('subscription_id')));
        if ($setting['FeatureSetting']['subscription_id'] == '') {
            return 0;
        }
        $settingArr = explode(",", $setting['FeatureSetting']['subscription_id']);
        /*
         * Get subscriptions
         */
        //$curSubscriptions = $UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
        $curSubscriptions = $UserSubscription->readSubDetlfromCache(SES_COMP);
        if ($sts == 'upgrade') {
            if (in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr) || SES_COMP == 1 || SES_COMP==41080 || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))) || ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11))) {
                return 1;
            } else {
                return 0;
            }
        } elseif ($sts == 'status') {
            $rs = $ResourceSetting->find('first', array('conditions' => array('company_id' => SES_COMP), 'fields' => array('is_active')));
            if (empty($rs) || (isset($rs['ResourceSetting']['is_active']) && $rs['ResourceSetting']['is_active'] == 1)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            if (in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr) || SES_COMP == 1 || SES_COMP==41080 || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited') || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser)) || ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11))) {
                $rs = $ResourceSetting->find('first', array('conditions' => array('company_id' => SES_COMP), 'fields' => array('is_active')));
                if (empty($rs) || (isset($rs['ResourceSetting']['is_active']) && $rs['ResourceSetting']['is_active'] == 1)) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }

    public function isTimesheetOn($sts = null)
    {
        $FeatureSetting = ClassRegistry::init('FeatureSetting');
        $UserSubscription = ClassRegistry::init('UserSubscription');

        if (!$sts) {
            $sts = 2;
        }
        $setting = $FeatureSetting->find('first', array('conditions' => array('id' => $sts), 'fields' => array('subscription_id')));
        if ($setting['FeatureSetting']['subscription_id'] == '') {
            return 0;
        }
        $settingArr = explode(",", $setting['FeatureSetting']['subscription_id']);
        //$curSubscriptions = $UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
        $curSubscriptions = $UserSubscription->readSubDetlfromCache(SES_COMP);
        
        if (in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr) || SES_COMP == 1 || SES_COMP == 28528 || SES_COMP == 52942 || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))) || ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11))) {
            return 1;
        } else {
            return 0;
        }
    }

    /* gantt start */

    public function changeGanttDataV3($json_arr, $status_arr = '', $date_format = 'Y-m-d')
    {
        #echo "<pre>";print_r($json_arr); exit;
        $user_ids = array();

        $colors = array(0 => '#73BCDE', 1 => '#8BC2B9', 2 => '#F8B363', 3 => '#EA7373', 4 => '#9ECC61');
        foreach ($json_arr as $key => $value) {
            $assign_to = intval($value['assign_to']);
            if ($assign_to > 0 && !in_array($assign_to, $user_ids)) {
                $user_ids[] = $assign_to;
            }

            $json_arr[$key]['id'] = $value['id'];
            #$json_arr[$key]['name'] = htmlspecialchars($value['title']);
            #$json_arr[$key]['description'] = htmlspecialchars($value['message']);
            #STATUS_ACTIVE, STATUS_DONE, STATUS_FAILED, STATUS_SUSPENDED, STATUS_UNDEFINED.
            #$json_arr[$key]['status'] = 'STATUS_ACTIVE';
            #$json_arr[$key]['status'] = $assign_to > 0 ? 'color' . array_search($assign_to, $user_ids) . '' : 'color15';
            #$json_arr[$key]['canWrite'] = true;
            #$json_arr[$key]['startIsMilestone'] = false;
            #$json_arr[$key]['endIsMilestone'] = false;
            #$json_arr[$key]['collapsed'] = false;
            #$json_arr[$key]['assigs'] = array();
            #$json_arr[$key]['hasChild'] = 0;
            #$json_arr[$key]['level'] = 1;
            $json_arr[$key]['depends'] = $value['depends'];
            $json_arr[$key]['progress'] = $value['progress'];
            $json_arr[$key]['assigned_to'] = $value['assigned_to'];
            $json_arr[$key]['priority'] = $value['priority'];
            $json_arr[$key]['type_id'] = $value['type_id'];
            $json_arr[$key]['case_no'] = $value['case_no'];

            if ((!empty($value['gantt_start_date']) && !is_null($value['gantt_start_date']) && $value['gantt_start_date'] != '0000-00-00 00:00:00') && ($value['due_date'] != '' && !is_null($value['due_date']) && $value['due_date'] != '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);print $v['id'];echo "    1";exit;
                $json_arr[$key]['start'] = $value['gantt_start_date'];
                $json_arr[$key]['end'] = $value['due_date'];
                $json_arr[$key]['color'] = $colors[$key];
            } elseif ((empty($value['gantt_start_date']) || is_null($value['gantt_start_date']) || $value['gantt_start_date'] == '0000-00-00 00:00:00') && ($value['due_date'] != '' && !is_null($value['due_date']) && $value['due_date'] != '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);echo "   2";exit;
                $json_arr[$key]['start'] = $value['due_date'];
                $json_arr[$key]['end'] = $value['due_date'];
                $json_arr[$key]['color'] = $colors[$key];
            } elseif ((!empty($value['gantt_start_date']) && !is_null($value['gantt_start_date']) && $value['gantt_start_date'] != '0000-00-00 00:00:00') && ($value['due_date'] == '' || is_null($value['due_date']) || $value['due_date'] == '0000-00-00 00:00:00')) {
                //print_r($v['due_date']);echo "   3";exit;
                $json_arr[$key]['start'] = $value['gantt_start_date'];
                $json_arr[$key]['end'] = date($date_format, $this->dateConvertion($value['gantt_start_date']));
                $json_arr[$key]['color'] = $colors[$key];
            } else {
                //print_r($v['gantt_start_date']);echo "   4";exit;
                $start = explode(' ', $value['actual_dt_created']);
                $json_arr[$key]['start'] = $start[0];
                $json_arr[$key]['end'] = date($date_format, $this->dateConvertion($value['actual_dt_created']));
                $json_arr[$key]['color'] = $colors[$key];
            }

            /* convert to user timezone */
            $json_arr[$key]['start'] = $this->convert_date_timezone($json_arr[$key]['start']);
            $json_arr[$key]['end'] = $this->convert_date_timezone($json_arr[$key]['end']);

            $json_arr[$key]['duration'] = $this->days_diff($json_arr[$key]['start'], $json_arr[$key]['end']);
            $json_arr[$key]['start_date'] = ($json_arr[$key]['start']);
            $json_arr[$key]['end_date'] = ($json_arr[$key]['end']);

            /* convert to millisecond */
            $json_arr[$key]['start_date'] = $json_arr[$key]['start'];
            $json_arr[$key]['start'] = strtotime($json_arr[$key]['start']) * 1000;
            $json_arr[$key]['end'] = strtotime($json_arr[$key]['end']) * 1000;

            if ($value['legend'] == '1') {
                $json_arr[$key]['color'] = '#f19a91';
            } elseif ($value['legend'] == '2' || $value['legend'] == '6') {
                $json_arr[$key]['color'] = '#8dc2f8';
            } elseif ($value['legend'] == '5') {
                $json_arr[$key]['color'] = '#f3c788';
            } elseif ($value['legend'] == '3') {
                $json_arr[$key]['color'] = '#8ad6a3';
            } elseif (isset($status_arr[$value['legend']]) && !empty($status_arr[$value['legend']])) {
                $json_arr[$key]['color'] = $status_arr[$value['legend']]['color'];
            } else {
                $json_arr[$key]['color'] = '#3dbb89';
            }
            unset($json_arr[$key]['title']);
            #unset($json_arr[$key]['id']);
            #unset($json_arr[$key]['legend']);
            unset($json_arr[$key]['gantt_start_date']);
            unset($json_arr[$key]['due_date']);
            unset($json_arr[$key]['actual_dt_created']);
            unset($json_arr[$key]['start']);
            unset($json_arr[$key]['end']);
            unset($json_arr[$key]['color']);
        }//exit;
        #echo "<pre>";print_r($json_arr);exit;
        return $json_arr;
    }

    public function recursive_map($haystack)
    {
        if (count($haystack) > 0) {
            foreach ($haystack as $key => $value) {
                foreach ($value as $ckey => $cval) {
                    if (!is_array($cval) && array_key_exists($cval, $haystack)) {
                        $haystack[$key][$cval] = $haystack[$cval];
                        unset($haystack[$cval]);
                        return $this->recursive_map($haystack);
                    } elseif (is_array($cval) && count($cval) > 0) {
                        foreach ($cval as $k1 => $v1) {
                            if (array_key_exists($k1, $haystack)) {
                                $haystack[$key][$ckey][$k1] = $haystack[$k1];
                                unset($haystack[$k1]);
                            }
                        }
                    } else {
                        continue;
                    }
                }
            }
        }
        return $haystack;
    }

    public function gethrev($msg = '')
    {
        $msg = trim($msg);
        if ($msg == '') {
            return '';
        }
        if (stristr($msg, "&lt;") || stristr($msg, "&gt;")) {
            $msg = htmlspecialchars_decode($msg);
        }
        return addslashes($msg);
    }
    public function geth($msg = '')
    {
        $msg = trim($msg);
        if ($msg == '') {
            return '';
        }
        $msg = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $msg);
        $msg = preg_replace('/(<br \/>)+$/', '', $msg);
        return addslashes($msg);
    }
    /* gantt end */
    public function subscribeToDrip($params=array())
    {
        return true;
    }
    public function subscribeToFomo($params=array())
    {
        return true;
    }
    public function resetCacheSub($comp_id)
    {
        if ((Cache::read('sub_detl_'.$comp_id)) !== false) {
            Cache::delete('sub_detl_'.$comp_id);
        }
    }
    public function getworkhr($whl, $dt)
    {
        if (!empty($whl)) {
            foreach ($whl as $k=>$v) {
                $logdt = date('Y-m-d', strtotime($k));
                if (strtotime($dt) >= strtotime($logdt)) {
                    return $v;
                }
            }
        } else {
            return 8;
        }
        return 8;
    }
    public function showSubtaskTitle($title, $id, $related, $is_angular=0)
    {
        if (!empty($related['parent'][$id])) {
            $parent_id = $related['parent'][$id];
            $aro_icon = ' <i class="material-icons">&#xE314;</i> ';
            if ($is_angular) { // for admin my dashboard
                $aro_icon = ' < ';
            }
            if (!empty($related['parent'][$parent_id])) {
                $super_parent_id = $related['parent'][$parent_id];
                $title .= $aro_icon . trim($related['task'][$parent_id]);
                $title .= $aro_icon . trim($related['task'][$super_parent_id]);
            } else {
                $title .= $aro_icon . trim($related['task'][$parent_id]);
            }
        }
        return $title;
    }

    public function parentDropDown($data, $parentId = 0, $level = 0, $options = array('Select Parent'))
    {
        $level++;
        foreach ($data as $val) {
            if ($val['parent_task_id'] == $parentId) {
                $options[$val['id']] = str_repeat("-- ", $level - 1) . $val['title'];
                $newParent = $val['id'];
                $options = $this->categoryDropDown($data, $newParent, $level, $options);
            }
        }
        return $options;
    }
    public function task_dependency($EasycaseId = '')
    {
        /* dependency check start */
        $Easycase = ClassRegistry::init('Easycase');
        $allowed = "Yes";
        $params = array(
            'conditions' => array('Easycase.id' => $EasycaseId),
            'fields' => array('Easycase.id', 'Easycase.depends')
        );
        $depends = $Easycase->find('first', $params);
        if (is_array($depends) && count($depends) > 0 && trim($depends['Easycase']['depends']) != '') {
            $parent_params = array(
                'conditions' => array('Easycase.id IN (' . $depends['Easycase']['depends'] . ')'),
                'fields' => array('Easycase.id', 'Easycase.title', 'Easycase.legend', 'Easycase.status', 'Easycase.isactive', 'Easycase.due_date')
            );
            $result = $Easycase->find('all', $parent_params);
            if (is_array($result) && count($result) > 0) {
                foreach ($result as $key => $parent) {
                    if (($parent['Easycase']['status'] == 2 && $parent['Easycase']['legend'] == 3) || ($parent['Easycase']['legend'] == 3)) {
                        // NO ACTION
                    } elseif ($parent['Easycase']['isactive'] == 0) {
                        // NO ACTION
                    } else {
                        $allowed = "No";
                    }
                }
                $this->parent_task = $result;
            }
        }
        /* dependency check end */
        return $allowed;
    }
    public function convert_hhmm_hours($time)
    {
        $timeArr = explode(':', $time);
        $decTime = ($timeArr[0]) + ($timeArr[1]/60);
        return $decTime;
    }
    public function getPMethodology($pmid)
    {
        //$array_PM = array(1=>'simple',2=>'scrum'); //will be made dynamic later
        //return $array_PM[$pmid];
        $ProjectMethodology =ClassRegistry::init('ProjectMethodology');
        $pm = $ProjectMethodology->find('first', array('conditions'=>array('ProjectMethodology.id'=>$pmid),'fields'=>array('title')));
        return strtolower($pm['ProjectMethodology']['title']);
    }
    
    
    /* Wiki Related Details Starts Here */
    
    public function getWikiCategoryName($WikiCatId)
    {
        $WikiCategory = ClassRegistry::init('WikiCategory');
        $getWikiCatname = $WikiCategory->find('first', array('conditions' => array('id' => $WikiCatId)));
        return $getWikiCatname['WikiCategory']['wiki_category_title'];
    }
    
    public function getWikiSubCategoryName($WikiSubcatId)
    {
        $WikiSubcategory = ClassRegistry::init('WikiSubcategory');
        $getWikiSubcatname = $WikiSubcategory->find('first', array('conditions' => array('id' => $WikiSubcatId)));
        return $getWikiSubcatname['WikiSubcategory']['wiki_subcategory_title'];
    }
    
    public function getWikiCreatorName($WikiUserId)
    {
        $User = ClassRegistry::init('User');
        $getWikiUsername = $User->find('first', array('conditions' => array('id' => $WikiUserId)));
        return $getWikiUsername['User']['name'];
    }
    
    public function getWikiProjectName($WikiProjectId)
    {
        $Project = ClassRegistry::init('Project');
        $getWikiProjectname = $Project->find('first', array('conditions' => array('id' => $WikiProjectId)));
        return $getWikiProjectname['Project']['name'];
    }
        
    public function display_activity_log_wiki($WikiUserId, $WikiActivityLog)
    {
        if ($WikiUserId == SES_ID) {
            $return_text = __("You have ", true);
        } else {
            $return_text = $this->getWikiCreatorName($WikiUserId) . __(" has ", true);
        }
    
        if ($WikiActivityLog == 'wiki disable') {
            $return_text .= __(" disabled wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki enable') {
            $return_text .= __(" enabled wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki comment') {
            $return_text .= __(" commented on wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki category update') {
            $return_text .= __(" updated wiki category. ", true);
        } elseif ($WikiActivityLog == 'wiki category create') {
            $return_text .= __(" created wiki category. ", true);
        } elseif ($WikiActivityLog == 'wiki subcategory update') {
            $return_text .= __(" updated wiki subcategory. ", true);
        } elseif ($WikiActivityLog == 'wiki subcategory create') {
            $return_text .= __(" created wiki category. ", true);
        } elseif ($WikiActivityLog == 'wiki approver enable') {
            $return_text .= __(" enabled wiki approver. ", true);
        } elseif ($WikiActivityLog == 'wiki approver disable') {
            $return_text .= __(" disabled wiki approver. ", true);
        } elseif ($WikiActivityLog == 'wiki approve') {
            $return_text .= __(" approved this wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki finally approve') {
            $return_text .= __(" finally approved this wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki reject') {
            $return_text .= __(" rejected wiki. ", true);
            ;
        } elseif ($WikiActivityLog == 'wiki update and finally submit') {
            $return_text .= __(" updated and finally submitted the wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki update') {
            $return_text .= __(" updated wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki attachment added') {
            $return_text .= __(" added attachments. ", true);
        } elseif ($WikiActivityLog == 'wiki add finally submit') {
            $return_text .= __(" added wiki and finally submitted. ", true);
        } elseif ($WikiActivityLog == 'wiki add') {
            $return_text .= __(" added wiki. ", true);
        } elseif ($WikiActivityLog == 'wiki attachment delete') {
            $return_text .= __(" deleted wiki attachments. ", true);
        } elseif ($WikiActivityLog == 'wiki attachment download') {
            $return_text .= __(" downloaded wiki attachments. ", true);
        } elseif ($WikiActivityLog == 'update approver heirarchy') {
            $return_text .= __(" updated approver hierarchy. ", true);
        }
    
        return $return_text;
    }
    /*
     * Check the resource availability On
     */
    public function isWikiOn($sts = null)
    {
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $user_sub = $UserSubscription->readSubDetlfromCache(SES_COMP);
        
        $subId= $user_sub['UserSubscription']['subscription_id'];
        $userLimit= $user_sub['UserSubscription']['user_limit'];
              
        if ($subId == 11  || ($subId != 13 && $userLimit > 10) || $userLimit == 'Unlimited') {
            return 1;
        } else {
            return 0;
        }
    }
    /* Wiki Related Details Ends Here */
    
    
    public function getlatestactivitypid($pid, $chk=null)
    {
        $Easycase = ClassRegistry::init('Easycase');
        $Easycase->recursive = -1;
        $latestactivity = $Easycase->find('first', array('conditions'=>array('Easycase.project_id =' => $pid),'fields' =>'dt_created','order' => array('Easycase.dt_created DESC')));
        if ($chk) {
            return $latestactivity['Easycase']['dt_created'];
        } else {
            $latestactivity1= explode(" ", $latestactivity['Easycase']['dt_created']);
            return $latestactivity1['0'];
        }
    }
    public function cmnHnyCheck($data, $key)
    {
        $allHnys = Configure::read('VALID_H_POT');
        $req_chk = $allHnys[$key];
        if ($key == 'inv_eml') { // done
            if ($data['name'] !== $req_chk[0]) {
                return false;
            }
        } elseif ($key == 'order_self') {// done
            if ($data['sp'] !== $req_chk[0] || $data['se'] !== $req_chk[1]) {
                return false;
            }
        } elseif ($key == 'register_outer') { //not done
            if ($data['lastname'] !== $req_chk[0] || $data['middlename'] !== $req_chk[1]) {
                return false;
            }
        } elseif ($key == 'register') {//not done
            if ($data['lastname'] !== $req_chk[0] || $data['middlename'] !== $req_chk[1]) {
                return false;
            }
        } elseif ($key == 'refer') {// done
            if ((int)$data['name'] !== $req_chk[0] || $data['whattsapp'] !== $req_chk[1]) {
                return false;
            }
        } elseif ($key == 'tutorial') {// done
            if ($data['lastname'] !== $req_chk[0] || $data['middlename'] !== $req_chk[1]) {
                return false;
            }
        }
        return true;
    }
    public function checkmultilabel($subtask1, $is_project= null)
    {
        $subtasknotallow = array();
        $subtasknotallow1 = array();
        $parent_ids = [];
        if ($is_project == 'all') {
            foreach ($subtask1 as $k=>$v) {
                $temp = $v;
                $taskid = explode('@@@', $k);
                $tid = $taskid[1];
                $pname =  $taskid[0];
                $subtasknotallow1[$tid] = 1;
                $count=0;
                do {
                    if ($count > 0 && $temp == $v) {
                        $subtasknotallow1[$tid] = 4; // This is the case for circular child and parent;
												$parent_ids[$tid] = $v;
                        break;
                    }
                    if (isset($subtask1[$pname.'@@@'.$temp])) {
                        $subtasknotallow1[$tid] =  $subtasknotallow1[$tid] + 1;
                        if ($subtasknotallow1[$tid] >= 4) {
                            break;
                        }
                        $temp = $subtask1[$pname.'@@@'.$temp];
                    } else {
                        $temp = 0;
                    }
                    $count++;
                    if ($count == 6) {
                        exit;
                    }
                } while ($temp);
            }
        } else {
            foreach ($subtask1 as $k=>$v) {
                $temp = $v;
                $subtasknotallow1[$k] = 1;
                $count=0;
                do {
                    if ($count > 0 && $temp == $v) {
                        $subtasknotallow1[$k] = 4; // This is the case for circular child and parent;
												$parent_ids[$k] = $v;
                        break;
                    }
                    if (isset($subtask1[$temp])) {
                        $subtasknotallow1[$k] =  $subtasknotallow1[$k] + 1;
                        if ($subtasknotallow1[$k] >= 4) {
                            break;
                        }
                        $temp = $subtask1[$temp];
                    } else {
                        $temp = 0;
                    }
                    $count++;
                } while ($temp);
            }
        }
        if (!empty($subtasknotallow1)) {
            foreach ($subtasknotallow1 as $k=>$v) {
                if ($v > 2) {
                    //$subtasknotallow[$k] = $v;
                    $subtasknotallow[$k] = $parent_ids[$k];
                }
            }
        }
        return $subtasknotallow;
    }
    public function getCachedRoleInfo()
    {
        $arr = array();
        $curProjId = '';
        $Project = ClassRegistry::init('Project');
        if ($curProjId != '' && $curProjId !='all') {
            $pInfo = $Project->find('first', array('conditions'=>array('uniq_id'=>$curProjId),'fields'=>array('id')));
            $curProjId = $pInfo['Project']['id'];
        }

        $RoleAction = ClassRegistry::init('RoleAction');
        $RoleAction->bindModel(array('belongsTo' => array('Action')));
        $roleAccess = $RoleAction->find('all', array('conditions' => array('RoleAction.role_id' => SES_ROLE, 'RoleAction.company_id' => array(SES_COMP,0)), 'fields' => array('Action.action', 'RoleAction.is_allowed')));
        $roleAccess = Hash::combine($roleAccess, '{n}.Action.action', '{n}.RoleAction.is_allowed');
        //$this->set(compact('roleAccess'));
        $module_query = "SELECT Module.name From modules AS Module LEFT JOIN role_modules AS RoleModule ON Module.id = RoleModule.module_id WHERE RoleModule.role_id = '" . SES_ROLE."'";
        #echo $module_query;exit;
        $module_list = $RoleAction->query($module_query);
        $module_list = Hash::extract($module_list, '{n}.Module.name');
        //$this->set('module_list', $module_list);
        if (SES_ROLE == 699) {
            $GuestRoleAction = ClassRegistry::init('GuestRoleAction');
           
            $guest_role_action = $GuestRoleAction->find('first', array('conditions'=>array('GuestRoleAction.company_id'=>SES_COMP,'GuestRoleAction.role_id' =>SES_ROLE)));
            if (!empty($guest_role_action)) {
                $Action = ClassRegistry::init('Action');
                $action_lists = $Action->find('list', array('fields'=>array('id','action')));
                
                $new_role_access = array();
                $roleAccess_arr = json_decode($guest_role_action['GuestRoleAction']['action_details'], true);
                foreach ($roleAccess_arr as $kr=>$vr) {
                    if (array_key_exists($kr, $action_lists)) {
                        $new_role_access[$action_lists[$kr]] = $vr;
                    }
                }
                $roleAccess = $new_role_access;
            }
            $guestroleAccess = $roleAccess;
        }
        $arr['roleAccess'][0] = $roleAccess;
        $arr['module_list'] = $module_list;

        if (isset($curProjId) && $curProjId != 'all' && $curProjId != '') {
            $ProjectUser = ClassRegistry::init('ProjectUser');

            $projectRole = $ProjectUser->find('first', array('conditions' => array('ProjectUser.project_id' => $curProjId, 'ProjectUser.user_id' => SES_ID), 'fields' => 'ProjectUser.role_id'));
            if (empty($projectRole['ProjectUser']['role_id']) || $projectRole['ProjectUser']['role_id'] == 0) {
                $role_id = SES_ROLE;
            } else {
                $role_id = $projectRole['ProjectUser']['role_id'];
            }
            $RoleAction = ClassRegistry::init('RoleAction');
            $RoleAction->bindModel(array('belongsTo' => array('Action')));
            $roleAccess = $RoleAction->find('all', array('conditions' => array('RoleAction.role_id' => $role_id, 'RoleAction.company_id' => array(SES_COMP,0)), 'fields' => array('Action.action', 'RoleAction.is_allowed')));
            //print_r($roleAccess);exit;
            $roleAccess = Hash::combine($roleAccess, '{n}.Action.action', '{n}.RoleAction.is_allowed');
            $module_query = "SELECT Module.name From modules AS Module LEFT JOIN role_modules AS RoleModule ON Module.id = RoleModule.module_id WHERE RoleModule.role_id = '" . $role_id."'";
            $module_list = $RoleAction->query($module_query);
            $module_list = Hash::extract($module_list, '{n}.Module.name');

       
            $puid = $Project->find('first', array('conditions'=>array('Project.id'=>$curProjId),'fields'=>array('Project.uniq_id')));
            if (SES_ROLE == 699) {
                $roleAccess= $guestroleAccess;
            }

            $arr['roleAccess'][$puid['Project']['uniq_id']] = $roleAccess;
            $arr['module_list'] = $module_list;
        //$this->set(compact('roleAccess'));
        //$this->set('module_list', $module_list);
        } else {
            //$this->loadModel('RoleAction');

            /*
            * Get all other projects Info
            */

            $ProjectUser = ClassRegistry::init('ProjectUser');
            $arrProjectIds = $ProjectUser->query("SELECT ProjectUser.project_id,Project.uniq_id FROM project_users AS ProjectUser,projects as Project WHERE ProjectUser.user_id=" . SES_ID . " AND ProjectUser.project_id=Project.id AND Project.isactive='1' AND Project.company_id='" . SES_COMP . "'");
            $projectIdList = Hash::combine($arrProjectIds, '{n}.ProjectUser.project_id', '{n}.Project.uniq_id');
            $arrProjectIds = Hash::extract($arrProjectIds, '{n}.ProjectUser.project_id');
            $ProjectUser->bindModel(array('belongsTo' => array('Role')));
            $ProjectUser->unbindModel(array('belongsTo' => array('Project')));
            $Role = ClassRegistry::init('Role');
            $Role->bindModel(array('hasMany' => array('RoleAction' => array('fields' => array('RoleAction.is_allowed,RoleAction.action_id')))));
            $Role->unbindModel(array('hasMany' => array('CompanyUser','RoleModule'),'belongsTo'=>array('RoleGroup','Company')));
            $RoleAction = ClassRegistry::init('RoleAction');
            $RoleAction->unbindModel(array('belongsTo' => array('Role')));
            $ProjectUser->recursive = 3;
            if (!empty($arrProjectIds)) {
                $allRoleActions = $ProjectUser->find('all', array('conditions' => array('ProjectUser.project_id IN ('.implode(',', $arrProjectIds).')', 'ProjectUser.user_id' => SES_ID), 'fields' => array('ProjectUser.role_id','Role.id','ProjectUser.project_id')));
            } else {
                $allRoleActions = array();
            }
            if (!empty($allRoleActions)) {
                foreach ($allRoleActions  as $k=>$v) {
                    $innrArr = array();
                    if (!empty($v['Role']['RoleAction'])) {
                        foreach ($v['Role']['RoleAction'] as $k1=>$v1) {
                            if (!empty($v1['Action'])) {
                                $innrArr[$v1['Action']['action']] = $v1['is_allowed'];
                            }
                        }
                    }
                    $arr['roleAccess'][$projectIdList[$v['ProjectUser']['project_id']]] = $innrArr;
                    if (SES_ROLE == 699) {
                        $arr['roleAccess'][$projectIdList[$v['ProjectUser']['project_id']]] = $guestroleAccess;
                    }
                }
            }
            /* End */
        }
    
        foreach ($roleAccess as $ki => $vi) {
            $ki = str_replace(" ", "_", $ki);
            $userRoleAccess[$ki] = $vi;
        }
        $arr['userRoleAccess'] =$userRoleAccess;
        //$this->set('userRoleAccess', json_encode($userRoleAccess));
        Cache::write('userRole'.SES_COMP.'_'.SES_ID, $arr);
    }
    /* Check user role */
    public function isAllowed($action, $project_id=0, $company=0)
    {
        if((SES_TYPE ==2 || SES_TYPE ==1) && $action != 'Change Due Date Reason'){
            return true;
        }
        $roleInfo1 = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
        $roleAccess1 = $roleInfo1['roleAccess'];
        if ($company!=0) {
            //$project_id = 0;
        } else {
            $project_id = $_COOKIE['CPUID'];

            if (!empty($project_id) && isset($roleAccess1[$project_id]) && !empty($roleAccess1[$project_id])) {
            } else {
                $project_id = 0; //Company Setting ;
            }
        }
       /*  if (array_key_exists($action,$roleAccess1[$project_id]) && $roleAccess1[$project_id][$action] == 0) {
             return false;                                 
         } else {
             return true;
         } */
		  if (array_key_exists($action,$roleAccess1[$project_id])){
			if($roleAccess1[$project_id][$action] == 0) {
            return false;
        } else {
            return true;
        }
         } else {
             return false;
         } 
    }
    /* returns the shortened url */
    public function get_bitly_short_url($url, $login=BITLY_USERNAME, $appkey=BITLY_APIKEY, $format='txt')
    {
        $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&apiKey='.$appkey.'&uri='.urlencode($url).'&format='.$format;
        return $this->curl_get_result($connectURL);
    }

    /* returns expanded url */
    public function get_bitly_long_url($url, $login, $appkey, $format='txt')
    {
        $connectURL = 'http://api.bit.ly/v3/expand?login='.$login.'&apiKey='.$appkey.'&shortUrl='.urlencode($url).'&format='.$format;
        return $this->curl_get_result($connectURL);
    }

    /* returns a result form url */
    public function curl_get_result($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
    /* End*/
    /* Google Calendar integration starts Here */
    public function GetAccessToken($client_id, $redirect_uri, $client_secret, $code)
    {
        $url = 'https://accounts.google.com/o/oauth2/token';
    
        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data = json_decode(curl_exec($ch), true);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code != 200) {
            throw new Exception('Error : Failed to receieve access token');
        }
      
        return $data;
    }
    public function createNewGoogleCalendar($name, $token=null)
    {
        return true;
        if (!$token) {
            $CompanyUser = ClassRegistry::init('CompanyUser');
            $tokesArr = $CompanyUser->find('first', array('conditions'=>array('company_id'=>SES_COMP, 'user_id'=>SES_ID),'fields'=>array('google_token')));
            $token = $tokesArr['CompanyUser']['google_token'];
        }
        if (!empty($token)) {
            App::import('Vendor', 'gc_vendor', array('file' => 'gc_vendor'.DS. 'autoload.php'));
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
            $client->setAuthConfig('credentials.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            try {
                $client->setAccessToken(json_decode($token, true));
                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return null;
            }
            $service = new Google_Service_Calendar($client);
            $calendar = new Google_Service_Calendar_Calendar();
            $calendar->setSummary($name);
            $createdCalendar = $service->calendars->insert($calendar);
            return $createdCalendar->getId();
        } else {
            return null;
        }
    }

    public function createGoogleCalendarEvent($eid, $task = array(), $type, $token=null)
    {
        $GoogleCalendarSetting = ClassRegistry::init('GoogleCalendarSetting');
        $start_date  = $task['dt_created'];
        $end_date  = $task['dt_created'];
        if (isset($task['gantt_start_date']) && !empty($task['gantt_start_date'])) {
            $start_date = $task['gantt_start_date'];
        }
        if (isset($task['due_date']) && !empty($task['due_date'])) {
            $end_date  = $task['due_date'];
        }
        if (strtotime($start_date) > strtotime($end_date)) {
            $end_date = $start_date;
        }
        if (isset($task['user_id']) && !empty($task['user_id'])) {
            $SES_ID = $task['user_id'];
        } else {
            $Easycase = ClassRegistry::init('Easycase');
            $uids = $Easycase->find('first', array('conditions'=>array('Easycase.id'=>$eid),'fields'=>array('Easycase.user_id')));
            $SES_ID = $uids['Easycase']['user_id'];
        }

        if (!$this->isGoogleSyncOn(SES_COMP, $SES_ID, '1')) {
            return null;
        }

        $calendarids = $GoogleCalendarSetting->find('first', array('conditions'=>array('company_id'=>SES_COMP, 'user_id'=>$SES_ID)));
        // If no Google Calendar setting
        if (count($calendarids) <= 0) {
            return null;
        }
        // If google calendar setting is for specific project
        if ($calendarids['GoogleCalendarSetting']['sync'] !=0 && $calendarids['GoogleCalendarSetting']['project_id'] != $task['project_id']) {
            return null;
        }
        // if due date is not set and calendar setting is set as not sync if no due date then
        if (!isset($task['due_date']) || empty($task['due_date'])) {
            if ($calendarids['GoogleCalendarSetting']['due_time'] ==1 && $type !='delete') {
                return null;
            }
        }
        if (isset($task['estimated_hours']) && !empty($task['estimated_hours']) && $task['estimated_hours'] != 0) {
            $duration = $task['estimated_hours'];
        } else {
            //$duration = $calendarids['GoogleCalendarSetting']['interval_time'] * 60;
            $duration = 60 * 60;
        }
        if (empty($token)) {
            $CompanyUser = ClassRegistry::init('CompanyUser');
            $tokesArr = $CompanyUser->find('first', array('conditions'=>array('company_id'=>SES_COMP, 'user_id'=>$SES_ID),'fields'=>array('google_token')));
            $token = $tokesArr['CompanyUser']['google_token'];
        }

        if (!empty($token)) {
            return true;
            $GoogleEventSetting = ClassRegistry::init('GoogleEventSetting');
            App::import('Vendor', 'gc_vendor', array('file' => 'gc_vendor'.DS. 'autoload.php'));
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
            $client->setAuthConfig('credentials.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            try {
                $client->setAccessToken(json_decode($token, true));
                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return null;
            }

            try {
                $service = new Google_Service_Calendar($client);
                if (date('Y-m-d', strtotime($end_date)) == date('Y-m-d', strtotime($start_date))) {
                    $end_date = strtotime($end_date) + $duration;
                    $end_date = date('Y-m-d H:i:s', $end_date);
                }
          

                $chkdt_first = $GoogleEventSetting->find('first', array('conditions'=>array('easycase_id'=>$eid,'company_id'=>SES_COMP,'user_id'=>$SES_ID)));
                $calendarId = $calendarids['GoogleCalendarSetting']['calendar_id'];

                if ($type !='delete') {
                    if (empty($chkdt_first)) {
                        $event = new Google_Service_Calendar_Event(array(
                  'summary' => $task['title'],
                  'sendNotifications' => true,
                  'description' => $task['message'],
                   'start' => array(
                         'dateTime' => str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($start_date))),
                         'timeZone' => 'UTC',
                   ),
                  'end' => array(
                        'dateTime' => str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($end_date))),
                         'timeZone' => 'UTC',
                  ),
                  'reminders' => array(
                    'useDefault' => false,
                    'overrides' => array(
                      array('method' => 'email', 'minutes' => 24 * 60),
                      array('method' => 'popup', 'minutes' => 10),
                    ),
                  ),
                ));

                        if (isset($task['assign_to']) && !empty($task['assign_to'])) {
                            $User = ClassRegistry::init('User');
                            $attendeeEmail = $User->find('first', array('conditions'=>array('User.id'=>$task['assign_to']),'fields'=>array('User.email')));
                            $attendee1 = new Google_Service_Calendar_EventAttendee();
                            $attendee1->setEmail($attendeeEmail['User']['email']);
                            $attendees = array($attendee1);
                            $event->attendees = $attendees;
                        }
                        $event = $service->events->insert($calendarId, $event);
                        $eventId = $event->id;
                    } else {
                        $gtevent = $service->events->get($calendarId, $chkdt_first['GoogleEventSetting']['google_event_id']);

                        $gtevent->setSummary($task['title']);
                        $gtevent->setDescription($task['message']);
                        $start = new Google_Service_Calendar_EventDateTime();
                        $start->setTimeZone('UTC');
                        $start->setDateTime(str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($start_date))));
                        $gtevent->setStart($start);

                        $end = new Google_Service_Calendar_EventDateTime();
                        $end->setTimeZone('UTC');
                        $end->setDateTime(str_replace(' ', 'T', date('Y-m-d H:i:s', strtotime($end_date))));
                        $gtevent->setEnd($end);

                        $updatedEvent = $service->events->update($calendarId, $gtevent->getId(), $gtevent);
                        $eventId = $gtevent->getId();
                    }

                    $arr['easycase_id']=$eid;
                    $arr['google_event_id']=$eventId;
                    $arr['company_id']=SES_COMP;
                    $arr['user_id']=$SES_ID;
                    //check event is exists or not
                    $chkdt = $GoogleEventSetting->find('first', array('conditions'=>array('easycase_id'=>$eid,'google_event_id'=>$eventId,'company_id'=>SES_COMP,'user_id'=>$SES_ID)));
                    if (empty($chkdt)) {
                        $GoogleEventSetting->create();
                        $GoogleEventSetting->save($arr);
                    }
                } else {
                    if (!empty($chkdt_first)) {
                        $service->events->delete($calendarId, $chkdt_first['GoogleEventSetting']['google_event_id']);
                        $GoogleEventSetting->id = $chkdt_first['GoogleEventSetting']['id'];
                        $GoogleEventSetting->delete();
                    } else {
                        return null;
                    }
                }

                $sevents = $service->events->listEvents($calendarId);
                $nextSyncToken = $sevents->getNextSyncToken();
                $GoogleCalendarSetting->id = $calendarids['GoogleCalendarSetting']['id'];
                $GoogleCalendarSetting->saveField('nextSyncToken', $nextSyncToken);
                return $eventId;
            } catch (Exception $e) {
                return null;
            }
        } else {
            return null;
        }
    }
    public function createChannel($calID, $token=null)
    {
        if (empty($token)) {
            $CompanyUser = ClassRegistry::init('CompanyUser');
            $tokesArr = $CompanyUser->find('first', array('conditions'=>array('company_id'=>SES_COMP, 'user_id'=>SES_ID),'fields'=>array('google_token')));
            $token = $tokesArr['CompanyUser']['google_token'];
        }

        if (!empty($token)) {
            return true;
            App::import('Vendor', 'gc_vendor', array('file' => 'gc_vendor'.DS. 'autoload.php'));
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
            $client->setAuthConfig('credentials.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            try {
                $client->setAccessToken(json_decode($token, true));
                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return null;
            }

            try {
                $service = new Google_Service_Calendar($client);
                $channel =  new Google_Service_Calendar_Channel($client);
                $channel->setId('orangescrum-'.SES_COMP.'-'.SES_ID.'-'.time()); //$calID
                $channel->setType('web_hook');
                $channel->setAddress(str_replace(array('http://app.','https://app.'), 'https://www.', HTTP_APP).'gcnotification');

                $watchEvent = $service->events->watch($calID, $channel);
                $events = $service->events->listEvents($calID);
                $nextSyncToken = $events->getNextSyncToken();
                $arr['id'] = $watchEvent->id;
                $arr['resourceId'] = $watchEvent->resourceId;
                $arr['nextSyncToken'] = $nextSyncToken;
                return $arr;
            } catch (Exception $e) {
                return null;
            }
        }
        return null;
    }
    public function updateGoogleEvents($cal_id)
    {
        $GoogleCalendarSetting = ClassRegistry::init('GoogleCalendarSetting');
        $GoogleEventSetting = ClassRegistry::init('GoogleEventSetting');
        $Easycase = ClassRegistry::init('Easycase');
        $Project = ClassRegistry::init('Project');


        $calData = $GoogleCalendarSetting->find('first', array('conditions'=>array('calendar_id'=>$cal_id)));
        if (!$this->isGoogleSyncOn($calData['GoogleCalendarSetting']['company_id'], $calData['GoogleCalendarSetting']['user_id'], '2')) {
            return null;
        }
        $CompanyUser = ClassRegistry::init('CompanyUser');
        $tokesArr = $CompanyUser->find('first', array('conditions'=>array('company_id'=>$calData['GoogleCalendarSetting']['company_id'], 'user_id'=>$calData['GoogleCalendarSetting']['user_id']),'fields'=>array('google_token')));
        $token = $tokesArr['CompanyUser']['google_token'];

        if (!empty($token)) {
            return true;
            App::import('Vendor', 'gc_vendor', array('file' => 'gc_vendor'.DS. 'autoload.php'));
            $client = new Google_Client();
            $client->setApplicationName('Google Calendar API PHP Quickstart');
            $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
            $client->setAuthConfig('credentials.json');
            $client->setAccessType('offline');
            $client->setPrompt('select_account consent');
            try {
                $client->setAccessToken(json_decode($token, true));
                if ($client->isAccessTokenExpired()) {
                    if ($client->getRefreshToken()) {
                        $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
                    } else {
                        return null;
                    }
                } else {
                    return null;
                }
            } catch (Exception $e) {
                return null;
            }

            $service = new Google_Service_Calendar($client);
            $optParams = array('syncToken'=>$calData['GoogleCalendarSetting']['nextSyncToken']);
            $events = $service->events->listEvents($cal_id, $optParams);

            $GoogleCalendarSetting->id = $calData['GoogleCalendarSetting']['id'];
            $GoogleCalendarSetting->saveField('nextSyncToken', $events->getNextSyncToken());

            $allEvents = $events->getItems();
            if (count($allEvents)) {
                foreach ($allEvents as $event) {
                    $gcSummary = ($event->getSummary())?$event->getSummary():'No title';
                    if ($gcSummary) {
                        $est =0;
                        $event_id = $event->getId();
                        if (isset($event->getStart()->date)) {
                            $event_StartDt = $event->getStart()->date;
                            $event_EndDt = $event->getEnd()->date;
                            $event_StartDt = date('Y-m-d', strtotime($event_StartDt));
                            $event_EndDt = date('Y-m-d', strtotime($event_EndDt));
                            $esthr =0;
                            $est = 0;
                        } else {
                            $event_StartDt = str_replace('Z', '', str_replace('T', ' ', $event->getStart()->dateTime));
                            $event_EndDt = str_replace('Z', '', str_replace('T', ' ', $event->getEnd()->dateTime));

                            $esthr = strtotime($event_EndDt)-strtotime($event_StartDt);
                            $est = $this->secondsToFormat($esthr);
                        }
                        $chk_exist = $GoogleEventSetting->find('first', array('conditions'=>array('google_event_id'=>$event_id)));
                        if (empty($chk_exist)) {
                            // Insert Google calendar data in incoming project in setting.=
                
                            if ($event->getStatus() != 'cancelled') {
                                $easycases['dt_created'] = GMT_DATETIME;

                                $new_task['CS_project_id'] = $Project->getProjUid($calData['GoogleCalendarSetting']['project_id']);
                                $new_task['CS_istype'] = 1;
                                $new_task['CS_title'] = $gcSummary;
                                $new_task['message'] = $event->getDescription()?$event->getDescription():'';
                                $new_task['CS_type_id'] = (!empty($task_type)) ? $task_type : 8; //update
                $new_task['story_point'] = 0; //update
                $new_task['CS_priority'] = 2;
                                $new_task['CS_message'] = $event->getDescription()?$event->getDescription():'';
                                $new_task['CS_assign_to'] = $calData['GoogleCalendarSetting']['user_id'];
                                $new_task['CS_user_id'] = $calData['GoogleCalendarSetting']['user_id'];
                                $new_task['CS_due_date'] = $event_EndDt;
                                $new_task['gantt_start_date'] = $event_StartDt;
                                $new_task['CS_id'] = 0;
                                $new_task['datatype'] = 0;
                                $new_task['CS_legend'] = 1;
                                $new_task['prelegend'] = '';
                                $new_task['hours'] = 0;
                                $new_task['estimated_hours'] =$est ;
                                $new_task['completed'] = 0;
                                $new_task['taskid'] = 0;
                                $new_task['task_uid'] = 0;
                                $new_task['editRemovedFile'] = '';
                                $new_task['is_client'] = 0;
                                $new_task['company_id'] = $calData['GoogleCalendarSetting']['company_id'];
                                $new_task['fromGoogleCal'] = 1;
                                $res = $this->Postcase->casePosting($new_task);
                                $res = json_decode($res);

                                if (isset($res->caseid)) {
                                    $easycases['id'] = $res->caseid;
                                    if (isset($event->getStart()->date)) {
                                        $easycases['due_date'] = date('Y-m-d H:i:s', strtotime($event_EndDt.' '.gmdate('H:i:s') .' -1 day'));
                                        $easycases['gantt_start_date'] = $event_StartDt.' '.gmdate('H:i:s');
                                    } else {
                                        $easycases['due_date'] = $event_EndDt;
                                        $easycases['gantt_start_date'] = $event_StartDt;
                                    }
                                    $Easycase->save($easycases);
                                    $newEvent['google_event_id'] = $event->getId();
                                    $newEvent['easycase_id'] = $res->caseid;
                                    $newEvent['user_id'] = $calData['GoogleCalendarSetting']['user_id'];
                                    $newEvent['company_id'] = $calData['GoogleCalendarSetting']['company_id'];
                                    $GoogleEventSetting->create();
                                    $GoogleEventSetting->save($newEvent);
                                }
                            }
                        } else {
                            // Update the google calendar data existing tasks
                            if ($event->getStatus() == 'cancelled') {
                                $easyData = $Easycase->find('first', array('conditions'=>array('id'=>$chk_exist['GoogleEventSetting']['easycase_id'],'isactive'=>1,'istype'=>1),'fields'=>array('case_no','project_id')));
                                $authArr['id'] = $chk_exist['GoogleEventSetting']['easycase_id'];
                                $authArr['cno'] = $easyData['Easycase']['case_no'];
                                $authArr['pid'] =  $easyData['Easycase']['project_id'];

                                $Easycase->deleteTasksRecursively($authArr['id'], $authArr['pid'], $authArr);

                                $GoogleEventSetting->id = $chk_exist['GoogleEventSetting']['id'];
                                $GoogleEventSetting->delete();
                            } else {
                                $easycases['id'] = $chk_exist['GoogleEventSetting']['easycase_id'];
                                $easycases['title'] = $gcSummary;
                                $easycases['message'] = $event->getDescription();
                                $easycases['gantt_start_date'] = $event_StartDt;
                                $easycases['dt_created'] = GMT_DATETIME;
                                $easycases['due_date'] = $event_EndDt;
                                $easycases['estimated_hours'] = $esthr;
                                $Easycase->save($easycases);
                            }
                        }
                    }
                }
            }
        }
        return null;
    }
    public function secondsToFormat($ss)
    {
        $h = floor($ss / 3600);
        $m = floor($ss / 60 % 60);
        if ($h && $m) {
            return "$h:$m";
        } elseif ($h) {
            return "$h:0";
        } elseif ($m) {
            return "0:$m";
        } else {
            return "0";
        }
    }
    public function hasCustomTaskStatus($pid, $column)
    {
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $res = $Project->find('first', array('conditions'=>array($column=>$pid),'fields'=>array('Project.status_group_id')));
        return !empty($res['Project']['status_group_id'])?$res['Project']['status_group_id']:0;
    }
    /*
  function to check whether the project has custom defect status group
  */
  function hasCustomDefectStatus($pid,$column){
    $Project = ClassRegistry::init('Project');
    $Project->recursive = -1;
    $res = $Project->find('first',array('conditions'=>array($column=>$pid),'fields'=>array('Project.defect_status_group_id')));
    return !empty($res['Project']['defect_status_group_id'])?$res['Project']['defect_status_group_id']:0;
  }
	function getStatusGroups($comp_id){
		$StatusGroup = ClassRegistry::init('StatusGroup');
		$wf_list = $StatusGroup->find('list', array('conditions' => array('StatusGroup.company_id' => array($comp_id,0),'StatusGroup.parent_id'=>0), 'fields' => array('StatusGroup.id', 'StatusGroup.name'),'order'=>array('StatusGroup.is_default DESC','CASE StatusGroup.is_default  WHEN 0 THEN StatusGroup.name ELSE StatusGroup.id END  ASC')));
		return (!empty($wf_list))?$wf_list:array();
	}
    public function getCustomTaskStatus($sts_grp_id=null, $type='all', $col_id=null, $ord='ASC')
    {
        $CustomStatus = ClassRegistry::init('CustomStatus');
        if ($sts_grp_id == 0) {
            return Configure::read('OS_DEFAULT_STS'); //default task status
        }
        if ($col_id && $sts_grp_id) {
            if ($sts_grp_id == -1) {
                $cond = array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.id'=>$col_id);
            } else {
                $cond = array('CustomStatus.status_group_id'=>$sts_grp_id, 'CustomStatus.id'=>$col_id);
            }
            $type = 'first';
        } elseif ($sts_grp_id) {
            if ($sts_grp_id == -1) {
                $Projects = ClassRegistry::init('Project');
                $Projects->recursive = -1;
                $allstsgrps = $Projects->find('list', array('conditions'=>array('Project.company_id'=>SES_COMP,'Project.isactive'=>1),'fields'=>array('Project.status_group_id')));
                if ($allstsgrps) {
                    $arrIDs = array_unique(array_values($allstsgrps));
                    $cond = array('CustomStatus.company_id'=>SES_COMP,'CustomStatus.status_group_id'=>$arrIDs);
                } else {
                    $cond = array('CustomStatus.company_id'=>SES_COMP);
                }
            } else {
                $cond = array('CustomStatus.status_group_id'=>$sts_grp_id);
            }
        } elseif ($col_id) {
            $cond = array('CustomStatus.id'=>$col_id);
            $type = 'first';
        }
        $CustomStatusArr =  $CustomStatus->find($type, array('conditions'=>$cond,'order'=>array('CustomStatus.seq'=>$ord)));
        return $CustomStatusArr;
    }
    /*pending status filter*/
    public function getCustomPendingTaskStatus($sts_grp_id=null, $type='all', $col_id=null, $ord='ASC')
    {
        $CustomStatus = ClassRegistry::init('CustomStatus');
        if ($col_id && $sts_grp_id) {
            if ($sts_grp_id == -1) {
                $cond = array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.id'=>$col_id, 'CustomStatus.status_master_id'=> array(1,2,3));
            } else {
                $cond = array('CustomStatus.status_group_id'=>$sts_grp_id, 'CustomStatus.id'=>$col_id, 'CustomStatus.status_master_id'=> array(1,2,3));
            }
            $type = 'first';
        } elseif ($sts_grp_id) {
            if ($sts_grp_id == -1) {
                $cond = array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.status_master_id'=> array(1,2,3));
            } else {
                $cond = array('CustomStatus.status_group_id'=>$sts_grp_id, 'CustomStatus.status_master_id'=> array(1,2,3));
            }
        } elseif ($col_id) {
            $cond = array('CustomStatus.id'=>$col_id, 'CustomStatus.status_master_id'=> array(1,2,3));
            $type = 'first';
        }
        $CustomStatusArr =  $CustomStatus->find($type, array('conditions'=>$cond,'order'=>array('CustomStatus.seq'=>$ord)));
        return $CustomStatusArr;
    }
    //get the custom task tis detail by id
    public function getStatusMasterId($sts_id, $proj_id, $chk_legnd=0)
    {
        //$proj_id check in future if required
        $CustomStatus = ClassRegistry::init('CustomStatus');
        if ($sts_id) {
            if ($chk_legnd) {
                $Project = ClassRegistry::init('Project');
                $dtlProj = $Project->getProjectFields(array("Project.id" => $proj_id), array("Project.status_group_id"));
                if ($sts_id < 7) {
                    $cond = array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.status_master_id'=>$sts_id,'CustomStatus.status_group_id'=>$dtlProj['Project']['status_group_id']);
                } else {
                    $cond = array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.id'=>$sts_id,'CustomStatus.status_group_id'=>$dtlProj['Project']['status_group_id']);
                }
            } else {
                $cond = array('CustomStatus.company_id'=>SES_COMP, 'CustomStatus.id'=>$sts_id);
            }
            $CustomStatusArr =  $CustomStatus->find('first', array('conditions'=>$cond,'order'=>array('CustomStatus.seq'=>'ASC')));
            return $CustomStatusArr;
        }
        return false;
    }
    public function getStatusByProject($pid)
    {
        $Project = ClassRegistry::init('Project');
        $StatusGroup = ClassRegistry::init('StatusGroup');
        $Project->unbindModel(array('hasMany' => array('ProjectUser')));
        $Project->unbindModel(array('hasAndBelongsToMany' => array('User')));
        $StatusGroup->bindModel(array('hasMany'=>array('CustomStatus'=>array('fields'=>array('CustomStatus.id','CustomStatus.name','CustomStatus.color','CustomStatus.status_master_id'),'order'=>array('CustomStatus.seq'=>'ASC')))));
        $Project->bindModel(array('belongsTo'=>array('StatusGroup'=>array('contains'=>array('CustomStatus'),'fields'=>array('StatusGroup.id')))));
        if ($pid != 'all') {
            $allCSByProj = $Project->find('all', array('conditions'=>array('Project.isactive'=>1,'Project.company_id'=>SES_COMP,'Project.id'=>$pid),'recursive'=>2));
        } else {
            $allCSByProj = $Project->find('all', array('conditions'=>array('Project.isactive'=>1,'Project.company_id'=>SES_COMP,'Project.status_group_id !='=>0),'recursive'=>2));
        }

        return $allCSByProj;
    }
    public function getCustomStatusProj($customStatus, $proj_id, $sts_id)
    {
        if ($customStatus && $proj_id && isset($customStatus[$proj_id])) {
            foreach ($customStatus[$proj_id]['CustomStatus'] as $ks => $vs) {
                if ($sts_id == $vs['id']) {
                    return $vs;
                }
            }
        }
        return array();
    }
    public function preprCustomKanban($customStatus, $key)
    {
        //Hash::combine($get_od_todos, '{n}.Easycase.eid', '{n}.Easycase.parent_task_id')
        if ($customStatus) {
            $retStst_arr = array();
            foreach ($customStatus as $k => $v) {
                $retStst_arr[$key.$v['CustomStatus']['id']] = $v['CustomStatus'];
            }
            return $retStst_arr;
        }
        return array();
    }
    public function isGoogleSyncOn($company_id, $user_id, $type='1')
    {
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $curSubscriptions = $UserSubscription->readSubDetlfromCache($company_id);
        $FeatureSetting = ClassRegistry::init('FeatureSetting');
        $setting = $FeatureSetting->find('first', array('conditions' => array('id' => 1), 'fields' => array('subscription_id')));
        if ($setting['FeatureSetting']['subscription_id'] == '') {
            return 0;
        }
        $settingArr = explode(",", $setting['FeatureSetting']['subscription_id']);

        if ($type == 1) {
            if (in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr)) {
                return 0;
            } else {
                return 1;
            }
        } else {
            if (in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr)) {
                return 0;
            } else {
                return 1;
            }
        }
    }
    /*
	 * Check the GitHub on
	 */
    public function isGithubOn($company_id, $chk=0)
    {
			return 0;
		}
    public function check_in_date_range($start_date, $end_date, $date_from_user)
    {
        $start_ts = strtotime($start_date);
        $end_ts = strtotime($end_date);
        $user_ts = strtotime($date_from_user);
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }
    public function strip_tags_deep($arr)
    {
        $res_arr = is_array($arr) ? array_map(array($this, 'strip_tags_deep'), $arr) : strip_tags($arr);
        return $res_arr;
    }
    public function getTaskPermalink($projShortName, $taskNo)
    {
        return strtoupper($projShortName).'#'.$taskNo;
    }

    /*For AMP Page start*/
    public function isAmp($url)
    {
        $status = false;
        if (!empty($url)) {
            $urlArr = explode('/', trim($url, '/'));
            if ($urlArr[0] == 'amp') {
                $status = true;
            }
        }
        return $status;
    }
    public function isMobileDevice()
    {
        $status = false;
        $detect = new Mobile_Detect();
        if ($detect->isMobile()) {
            $status = true;
        }
        return $status;
    }
    
    public function getMobileDeviceType()
    {
        $status = 0;
        $detect = new Mobile_Detect();
        if ($detect->is('iOS')) { //iOS
            $status = 1;
        }
        return $status;
    }

    /*For AMP Page end*/
    public function deleteCustomStatusGroup($id)
    {
        $StatusGroup = ClassRegistry::init('StatusGroup');
        $CustomStatus = ClassRegistry::init('CustomStatus');
        $group = $StatusGroup->find('first', array('conditions'=>array('StatusGroup.id'=>$id),'fields'=>array('StatusGroup.parent_id')));
        if ($group['StatusGroup']['parent_id'] != 0) {
            $StatusGroup->id = $id;
            if ($StatusGroup->delete()) {
                $CustomStatus->deleteAll(array('CustomStatus.status_group_id' => $id));
            }
        }
        return 1;
    }
    public function setLeftMenu()
    {
        if (SES_COMP) {
            Cache::delete('userMenu'.SES_COMP.'_'.SES_ID);
            if (Cache::read('userMenu'.SES_COMP.'_'.SES_ID) === false) {
                $Menu = ClassRegistry::init('Menu');
                $UserMenu = ClassRegistry::init('UserMenu');

                $userMenu = $UserMenu->find('all', array('conditions'=>array('UserMenu.user_id'=>SES_ID,'UserMenu.company_id'=>SES_COMP)));

                if (empty($userMenu)) {
                    $this->insertLeftMenu(SES_COMP, SES_ID);
                    $userMenu = $UserMenu->find('all', array('conditions'=>array('UserMenu.user_id'=>SES_ID,'UserMenu.company_id'=>SES_COMP)), false);
                }

                $arr['allUsermenus']  = json_decode($userMenu[0]['UserMenu']['menu'], true);

                $menus = $Menu->find('all');
                foreach ($menus as $k=>$v) {
                    $arr['menus'][$v['Menu']['id']]	= $v['Menu'];
                }
        
                Cache::write('userMenu'.SES_COMP.'_'.SES_ID, $arr);
            }
            return Cache::read('userMenu'.SES_COMP.'_'.SES_ID);
        }
    }
    public function insertLeftMenu($company_id, $user_id)
    {
        $Menu = ClassRegistry::init('Menu');
        $UserMenu = ClassRegistry::init('UserMenu');

        $isExists = $UserMenu->find('count', array('conditions'=>array('UserMenu.company_id'=>$company_id,'UserMenu.user_id'=>$user_id)), false);


        if (!$isExists) {
            $UserSidebar = ClassRegistry::init('UserSidebar');
            $clms = $UserSidebar->readmenudataDetlfromCache($user_id, $company_id);

            if (!empty($clms)) {
                $allM = $Menu->find('list', array('conditions'=>array('Menu.parent_id'=>0),'fields'=>array('Menu.id','Menu.name'),'order'=>array('Menu.menu_order'=>'ASC')));
                foreach ($allM as $k=>$v) {
                    $allM[$k] = strtolower($v);
                }
                $ids = array(0);
                foreach ($clms['checked_left_menu'] as $k=>$v) {
                    if (in_array($v, $allM)) {
                        $ids[] = array_search($v, $allM);
                    }
                }
                $Menu->Behaviors->enable('Tree');
                $getAllMenus = $Menu->find('threaded', array('conditions'=>array('OR'=>array('Menu.id'=>$ids,'Menu.parent_id'=>$ids)),'fields'=>array('Menu.id','Menu.parent_id'),'order'=>array('Menu.menu_order'=>'ASC')));
            } else {
                $Menu->Behaviors->enable('Tree');
                $getAllMenus = $Menu->find('threaded', array('conditions'=>array('Menu.default_menu'=>1),'fields'=>array('Menu.id','Menu.parent_id'),'order'=>array('Menu.menu_order'=>'ASC')));
            }
            $ga = array();
            foreach ($getAllMenus as $k=>$v) {
                $ga[$k]['id'] =$v['Menu']['id'];
                if (!empty($v['children'])) {
                    foreach ($v['children'] as $k1=>$v1) {
                        $ga[$k]['children'][$k1]['id'] = $v1['Menu']['id'];
                    }
                }
            }
            $UserMenu->create();
            $data['user_id'] = $user_id;
            $data['company_id'] = $company_id;
            $data['menu'] = json_encode($ga);
            $UserMenu->save($data);
        }
    }
    public function getParentTaskUnid($case_no, $proj_id, $unid)
    {
        $Easycase = ClassRegistry::init('Easycase');
        $ECDT = $Easycase->find('first', array('conditions'=>array('Easycase.case_no'=>$case_no,'Easycase.project_id'=>$proj_id, 'Easycase.istype'=>1)));
        if ($ECDT) {
            $unid = $ECDT['Easycase']['uniq_id'];
        }
        return $unid;
    }
    public function getNewPricing($user_cnt, $price_per_user, $type, $data)
    {
        $user_to_count = (!empty($data['NewPricingUser']['is_flat_price'])) ? $user_cnt : $user_cnt - 10 ;
        if ($type == "yearly") {
            $yearly_price = (!empty($data['NewPricingUser']['is_flat_price'])) ? ($user_to_count * $price_per_user)*12 : (9 + ($user_to_count * $price_per_user))*12;
            $discount_price = round($yearly_price * 0.1);
            $total_price = round($yearly_price - $discount_price);
        } else {
            $total_price = (!empty($data['NewPricingUser']['is_flat_price'])) ? ($user_to_count * $price_per_user) : 9 + ($user_to_count * $price_per_user);
        }
        return $total_price;
    }
            
    public function getStorageCount($user_count)
    {
        if ($user_count <= 14) {
            return 5120;
        } elseif ($user_count <= 24) {
            return 10240;
        } elseif ($user_count <= 54) {
            return 20480;
        } elseif ($user_count <= 100) {
            return 51200;
        } elseif ($user_count <= 200) {
            return 102400;
        } elseif ($user_count > 200) {
            return 153600;
        }
    }
    /*
    Author:C pattnaik
    function to check  given string contains multibyte character or not
    returns true if there is a multibyte character else false
    */
    public function contains_any_multibyte($string)
    {
        return !mb_check_encoding($string, 'ASCII') && mb_check_encoding($string, 'UTF-8');
    }
    /*
    Author:Sangita
    function to check usser restriction to access Advanced CF logic
    */
    public function isAllowedAdvancedCustomFields()
    {
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $user_sub = $UserSubscription->readSubDetlfromCache(SES_COMP);
      
        $subId= $user_sub['UserSubscription']['subscription_id'];
        $userLimit= $user_sub['UserSubscription']['user_limit'];
              
        if ($subId == 11  || ($subId != 13 && $userLimit > 10) || $userLimit == 'Unlimited') {
            return 1;
        } else {
            return 0;
        }
    }

    /*
     Author:C pattnaik
    * Check whether the current user is life time free
    */
    public function isLifeFreeUser()
    {
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $curSubscriptions = $UserSubscription->readSubDetlfromCache(SES_COMP);
        if ($curSubscriptions['UserSubscription']['lifetime_free'] == 1) {
            return 0;
        } else {
            return 1;
        }
    }
		/*
    Author:c pattnaik
    function to check usser restriction to access Defect module logic
    */
    public function isAllowedDefectModule()
    {
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $user_sub = $UserSubscription->readSubDetlfromCache(SES_COMP);
      
        $subId= $user_sub['UserSubscription']['subscription_id'];
        $userLimit= $user_sub['UserSubscription']['user_limit'];
              
        if ($subId == 11  || ($subId != 13 && $userLimit > 10) || $userLimit == 'Unlimited') {
            return 1;
        } else {
            return 0;
        }
    }
     /*
       Author:C pattnaik
      * returns the status name or color of default status
      */
      public function getDefaultStatus($sts,$type){
          $name_arry = [1=>"New",2=>"In-Progress",3=>"Closed",5=>"Resolved"];
          $color_arry = [1=>"#f19a91",2=>"#8dc2f8",3=>"#f3c788",5=>"#8ad6a3"];
          if($type == 'name'){
              return $name_arry[$sts];
          }else{
              return $color_arry[$sts];
          }
}

      public function getNewlinesInsingle($inpt=null){
		if($inpt){
			$inpt = trim(preg_replace('/\s+/', ' ', $inpt));
		}
		return $inpt;
	}
        /**
     * isAllowZapier
     * @author bijaya
     * @param  mixed $company_id
     * @return void
     * this function check whether user is allowed to access zpaier or not
     */
    public function isAllowZapier($company_id)
    {
			return 0;
    }

		public function isSsoOn()
    {
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $user_sub = $UserSubscription->readSubDetlfromCache(SES_COMP);
      
        $subId= $user_sub['UserSubscription']['subscription_id'];
        $userLimit= $user_sub['UserSubscription']['user_limit'];              
        if (($subId == 11 && !$user_sub['UserSubscription']['lifetime_free'])  || ($subId != 13 && $userLimit > 10) || $userLimit == 'Unlimited') {
            return 1;
        } else {
            return 0;
        }
    }
		
		public function isZoomOn()
    {
			return 0;
    }
}