<?php

App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));

class FormatHelper extends AppHelper {

    function get_IP_address() {
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $IPaddress) {
                    $IPaddress = trim($IPaddress); //Just to be safe
                    if (filter_var($IPaddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $IPaddress;
                    }
                }
            }
        }
    }
	function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}
    function getRealIpAddr() {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false) {
            return false;
        }
        if ($this->is_private_ip($ip)) {
            return false;
        }
        return $ip;
    }

    function is_private_ip($ip) {
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
            if (($ip >= $min) && ($ip <= $max))
                return true;
        }
        return false;
    }

    function getUserDtls($uid) {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.name', 'User.photo', 'User.email', 'User.last_name', 'User.dt_created', 'User.dt_last_login','User.btprofile_id','User.uniq_id')));
        return $usrDtls;
    }

    function displayStorage($value, $flag = 0) {
        if (strtolower($value) != 'unlimited' && $value) {
            if ($value < 1024) {
                return $value . " MB";
            } else {
                if (!$flag) {
                    return number_format(($value / 1024), 1, '.', '') . " GB";
                } else {
                    return round(($value / 1024)) . " GB";
                }
            }
        } else {
            return $value;
        }
    }

    function longstringwrap($string = "") {
        return $string;
        //return preg_replace_callback( '/\w{10,}/', create_function( '$matches', 'return chunk_split( $matches[0], 5, "&#8203;" );' ), $string );
    }

    function checkProjLimit($limit = NULL) {
        $Project = ClassRegistry::init('Project');
        $Project->recursive = -1;
        $totProj = $Project->find('count', array('conditions' => array('Project.company_id' => SES_COMP, 'short_name !='=>'WDEV'), 'fields' => 'DISTINCT Project.id'));
        return $totProj;
    }

    function checkCountMilestone($limit = NULL) {
        $Milestone = ClassRegistry::init('Milestone');
        $Milestone->recursive = -1;
        $totMlstone = $Milestone->find('count', array('conditions' => array('Milestone.company_id' => SES_COMP), 'fields' => 'DISTINCT Milestone.id'));
        return $totMlstone;
    }

    function checkUsrLimit($limit = NULL) {
        App::import('Model', 'UserInvitation');
        $UserInvitation = new UserInvitation();
        $UserInvitation->recursive = -1;
        $totUsr = $UserInvitation->find('count', array('conditions' => array('UserInvitation.company_id' => SES_COMP), 'fields' => 'DISTINCT UserInvitation.id'));
        // 1 is added for the company owner account as its not inserted into the invitation table 
        $totUsr = $totUsr + 1;
        return $totUsr;
    }

    function getStatus($type, $legend) {
        if ($type == 10) {
            return '<span class="label label-update fade-update update">'.__('Update',true).'</span>';
        } else if ($legend == 1) {
            return '<span class="label new label-danger fade-red">'.__('New',true).'</span>';
        } else if ($legend == 2 || $legend == 4) {
            return '<span class="label wip label-info fade-blue">'.__('In Progress',true).'</span>';
        } else if ($legend == 3) {
            return '<span class="label closed label-success fade-green">'.__('Closed',true).'</span>';
        } else if ($legend == 5) {
            return '<span class="label resolved label-warning fade-orange">'.__('Resolved',true).'</span>';
        }
    }
	function getCustomStatus($customStatus){
		return '<span class="label label-custom label-info" style="background-color:#'. $customStatus['color'].'">'.$customStatus['name'].'</span>';
	}
	function getCustomStatusProj($customStatus, $proj_id, $sts_id){
		if($customStatus && $proj_id && isset($customStatus[$proj_id])){
			foreach($customStatus[$proj_id]['CustomStatus'] as $ks => $vs){
				if($sts_id == $vs['id']){
					return '<span class="label label-custom label-info" style="background-color:#'. $vs['color'].'">'.$vs['name'].'</span>';
				}
			}
		}
		return false;
	}
	function getttformats($v) {
		return implode('-',explode(' ',strtolower($v)));
	}
	function getUserStatus($total, $remain) {
		if(strtolower($total) == 'unlimited'){
			return 0;
		}
		$current = $total-$remain;
		$per_9 = round(0.9*$total);
		if($current >= $per_9){
			return 1;			
		}else{
			return 0;
		}
    }

function getStatusWl($typ){
		if ($typ == 10) {
			return '<span class="label update label-update fade-update">'.__('Update',true).'</span>';
		} else if ($typ == 1) {
			return '<span class="label new label-danger fade-red">'.__('New',true).'</span>';
		} else if ($typ == 2 || $typ == 4) {
			return '<span class="label wip label-info fade-blue">'.__('In Progress',true).'</span>';
		}
		if ($typ == 3) {
			return '<span class="label closed label-success fade-green">'.__('Closed',true).'</span>';
		} else if ($typ == 4) {
			return '<span class="label wip label-info fade-blue">'.__('In Progress',true).'</span>';
		} else if ($typ == 5) {
			return '<span class="label resolved label-warning fade-orange">'.__('Resolved',true).'</span>';
		}
	}
    function fixtags($text) {
        //$text = htmlspecialchars($text);
        $text = preg_replace("/=/", "=\"\"", $text);
        $text = preg_replace("/&quot;/", "&quot;\"", $text);
        $tags = "/&lt;(\/|)(\w*)(\ |)(\w*)([\\\=]*)(?|(\")\"&quot;\"|)(?|(.*)?&quot;(\")|)([\ ]?)(\/|)&gt;/i";
        $replacement = "<$1$2$3$4$5$6$7$8$9$10>";
        $text = preg_replace($tags, $replacement, $text);
        $text = preg_replace("/=\"\"/", "=", $text);
        return $text;
    }

    function emailText($value) {
        $value = stripslashes(trim($value));
        $value = str_replace("“", "\"", $value);
        $value = str_replace("”", "\"", $value);
        $value = str_replace("�", "\"", $value);
        $value = str_replace("�", "\"", $value);
        //$value = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $value);
        $value = $this->fixtags($value);
        //$value = html_entity_decode($value, ENT_QUOTES);
        $value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
        return stripslashes($value);
    }

    function getBrowser() {
        $browser = $_SERVER['HTTP_USER_AGENT'];
        if (strstr($browser, "Safari") && !strstr($browser, "Chrome")) {
            $agent = "S";
        } elseif (strstr($browser, "Firefox")) {
            $agent = "F";
        } elseif (strstr($browser, "Chrome")) {
            $agent = "C";
        } elseif (strstr($browser, "MSIE")) {
            $agent = "I";
        }
        return $agent;
    }

    function pub_file_exists($folder, $fileName) { //echo $fileName;exit;
        try {
            $s3 = new S3(awsAccessKey, awsSecretKey);
            $info = $s3->getObjectInfo(BUCKET_NAME, $folder . $fileName);
            if ($info) {
                //File exists
                return true;
            } else {
                //File doesn't exists
                return false;
            }
        } catch (Exception $e) {
            print $e->getMessage();
            exit;
        }
    }

    function imageExists($dir, $image) {
        if ($image && file_exists($dir . $image)) {
            return true;
        } else {
            return false;
        }
    }

    function pagingShowRecords($total_records, $page_limit, $page) {
        $numofpages = $total_records / $page_limit;
        for ($j = 1; $j <= $numofpages; $j++) {
            
        }
        $start = $page * $page_limit - $page_limit;
        if ($page == $j) {
            $start1 = $start + 1;
            $retRec = $start1 . " - " . $total_records . " of " . $total_records;
        } else {
            $start1 = $start + 1;
            $retRec = $start1 . " - " . $page * $page_limit . " of " . $total_records;
        }
        return $retRec;
    }

    function formatText($value) {
        /* commented for supporting multi language

          $value = str_replace("“","\"",$value);
          $value = str_replace("”","\"",$value);
          $value = str_replace("�","\"",$value);
          $value = str_replace("�","\"",$value);
          $value = preg_replace('/[^(\x20-\x7F)\x0A]/','', $value);
          $value = stripslashes($value);
          $value = html_entity_decode($value, ENT_QUOTES);
          $trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
          $value = strtr($value, $trans);
          $value = stripslashes(trim($value));
          return $value; */

        $value = str_replace("“", "\"", $value);
        $value = str_replace("”", "\"", $value);
        $value = str_replace("�", "\"", $value);
        $value = str_replace("�", "\"", $value);
        $value = stripslashes($value);
        $value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
        $value = stripslashes(trim($value));
        return $value;
    }
	function formatSearchText($value) {
        $value = str_replace("“", "\"", $value);
        $value = str_replace("”", "\"", $value);
        $value = str_replace("�", "\"", $value);
        $value = str_replace("�", "\"", $value);
        //$value = stripslashes($value);
        //$value = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
        //$value = stripslashes(trim($value));
        return h($value);
    }
    function paragraph_trim($content) {
        $result = preg_replace('!(^(\s*<p>(\s|&nbsp;)*</p>\s*)*|(\s*<p>(\s|&nbsp;)*</p>)*\s*\Z)!em', '', $content);
        return $result === NULL ? $content : $result;
    }

    function formatCms($value) {        
        $value = stripslashes(trim($value));
        $value = str_replace("�", "\"", $value);
        $value = str_replace("�", "\"", $value);
        //$value = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $value);
        $value = str_replace("~", "&#126;", $value);

        if (!stristr($value, "target='_blank'") && !stristr($value, 'target="_blank"')) {
            $value = str_replace("a href=", "a style='text-decoration:underline;color:#371FEE' target='_blank' href=", $value);
        }

        /* $value = str_replace("<ul>","<ul style='list-style:disc;'>",$value); */
        //$value = $this->makeURL($value);
        // /(http:\/\/)?([a-zA-Z0-9\-.]+\.[a-zA-Z0-9\-]+([\/]([a-zA-Z0-9_\/\-.?&%=+])*)*)/

        if (!stristr($value, "<img src") && !stristr($value, "target='_blank'") && !stristr($value, 'target="_blank"')) {
            //commented when image paste functionality goes live.
						//$value = preg_replace("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", '<a href="http://\\0" target="_blank" style="color:#371FEE">\\0</a>', $value);
        }

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

    function shortLength($value, $len, $typ=0) {
        $value_format = $this->formatText($value);
        $value_raw = html_entity_decode($value_format, ENT_QUOTES);
        if (strlen($value_raw) > $len) {
            $value_strip = mb_substr($value_raw, 0, $len);
            $value_strip = $this->formatText($value_strip);
			if($typ){
				$lengthvalue = $value_strip;
			}else{
				$lengthvalue = $value_strip . "...";
			}
        } else {
            $lengthvalue = $value_format;
        }
        return $lengthvalue;
    }

    function shortLengthCMS($value, $len) {
        $value = stripslashes($value);
        $value = str_replace("�", "\"", $value);
        $value = str_replace("�", "\"", $value);
        //$value = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $value);
        $value = str_replace("~", "&#126;", $value);
        $value = strip_tags($value);
        $value = trim($value);

        if (strlen($value) > $len) {
            $value_strip = substr($value, 0, $len);
            $lengthvalue = $value_strip . "...";
        } else {
            $lengthvalue = $value;
        }
        //$lengthvalue = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $lengthvalue);
        return $lengthvalue;
    }

    function displayStatus($st) {
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
        } else {
            $status = "All";
        }
        return $status;
    }

    function getFileType($file_type) {
        $oldname = strtolower($file_type);
        $ext = substr(strrchr($oldname, "."), 1);

        if ($ext == 'pdf') {
            return '<div class=" os_sprite play_file pdf_file cmn_fl fl"></div>';
        } else if ($ext == 'doc' || $ext == 'docx' || $ext == 'rtf' || $ext == 'odt' || $ext == 'dotx' || $ext == 'docm') {
            return '<div class="doc_file cmn_fl os_sprite play_file fl"></div>';
        } else if ($ext == 'xls' || $ext == 'xlsx' || $ext == 'ods') {
            return '<div class="xls_file cmn_fl  os_sprite play_file fl"></div>';
        } else if ($ext == 'png') {
            return '<div class="png_file cmn_fl os_sprite play_file fl"></div>';
        } else if ($ext == 'tif') {
            return '<div class="tif_file cmn_fl os_sprite play_file fl"></div>';
        } else if ($ext == 'bmp') {
            return '<div class="bmp_file cmn_fl os_sprite play_file fl"></div>';
        } else if ($ext == 'gif') {
            return '<div class="png_file cmn_fl os_sprite play_file fl"></div>';
        } else if ($ext == 'jpg' || $ext == 'jpeg') {
            return '<div class="jpg_file cmn_fl os_sprite play_file fl"></div>';
        } else if ($ext == 'zip' || $ext == 'rar' || $ext == 'gz') {
            return '<div class="zip_file cmn_fl os_sprite play_file fl"></div>';
        } else {
            return '<div class="html_file cmn_fl os_sprite play_file fl"></div>';
        }
    }

    function imageType($filename, $width1, $height1, $link, $downloadUrl = NULL, $is_ext = NULL) {
        if ($width1 != 0) {
            $width = "width='" . $width1 . "'";
        } else {
            $width = "";
        }
        if ($height1 != 0) {
            $height = "height='" . $height1 . "'";
        } else {
            $height = "";
        }

        $oldname = strtolower($filename);
        $ext = substr(strrchr($oldname, "."), 1);

        if ($link == 1) {
            if (isset($downloadUrl) && trim($downloadUrl)) { //By Sunil
                $links1 = "<a href='" . $downloadUrl . "' target='_blank' style='font:bold 11px verdana;text-transform:uppercase;color:#000000'>";
            } else {
                $links1 = "<a href='" . HTTP_ROOT . "easycases/download/" . $filename . "' style='font:bold 11px verdana;text-transform:uppercase;color:#000000'>";
            }
            $links2 = "</a>";
        } else {
            $links1 = "";
            $links2 = "";
        }

        $style = "style='border:0px solid #C3C3C3'";

        if (isset($is_ext)) {
            return $ext;
        }

        if ($ext == "zip") {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/zip.png' alt='[zip]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        } elseif ($ext == "rar") {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/rar.png' alt='[rar]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        } elseif ($ext == "xls" || $ext == "xlsx") {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/xls.png' alt='[xls]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        } elseif ($ext == "doc" || $ext == "docx" || $ext == "rtf") {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/doc.png' alt='[doc]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        } elseif ($ext == "txt") {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/txt.png' alt='[txt]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        } elseif ($ext == "jpg" || $ext == "jpeg") {
            $image = "<img src='" . HTTP_IMAGES . "images/case/jpg.png' alt='[jpg]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />";
        } elseif ($ext == "png") {
            $image = "<img src='" . HTTP_IMAGES . "images/case/png.png' alt='[png]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />";
        } elseif ($ext == "gif") {
            $image = "<img src='" . HTTP_IMAGES . "images/case/gif.png' alt='[gif]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />";
        } elseif ($ext == "bmp") {
            $image = "<img src='" . HTTP_IMAGES . "images/case/bmp.png' alt='[bmp]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />";
        } elseif ($ext == "ppt") {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/ppt.png' alt='[ppt]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        } elseif ($ext == "pdf") {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/pdf.png' alt='[pdf]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        } else {
            $image = $links1 . "<img src='" . HTTP_IMAGES . "images/case/other.png' alt='[other]' title='" . $filename . "' " . $width . " " . $height . " border='0' " . $style . " />" . $links2;
        }
        return $image;
    }

    function todo_typ($type, $title) {
        if (file_exists('' . HTTP_IMAGES . 'images/types/' . $type . 'png')) {
            $disp_type = '<img src="' . HTTP_IMAGES . 'images/types/' . $type . '.png" title="' . $title . '" alt="' . $type . '" />';
        } else {
            $disp_type = "";
        }
        return $disp_type;
    }

    function todo_typ_src($type, $title) {
        $disp_type = HTTP_IMAGES . "images/types/" . $type . ".png'";
        return $disp_type;
    }

    ######## WordWrap #######

    function html_wordwrap($str, $width, $break = "\n", $cut = false) {
        //same functionality as wordwrap, but ignore html tags
        $unused_char = $this->find_unused_char($str); //get a single character that is not used in the string
        $tags_arr = $this->get_tags_array($str);
        $q = '?';
        $str1 = ''; //the string to be wrapped (will not contain tags)
        $element_lengths = array(); //an array containing the string lengths of each element
        foreach ($tags_arr as $tag_or_words) {
            if (preg_match("/<.*$q>/", $tag_or_words))
                continue;
            $str1 .= $tag_or_words;
            $element_lengths[] = strlen($tag_or_words);
        }
        $str1 = wordwrap($str1, $width, $unused_char, $cut);
        foreach ($tags_arr as &$tag_or_words) {
            if (preg_match("/<.*$q>/", $tag_or_words))
                continue;
            $tag_or_words = substr($str1, 0, $element_lengths[0]);
            $str1 = substr($str1, $element_lengths[0]);
            array_shift($element_lengths); //delete the first array element - we have used it now so we do not need it
        }
        $str2 = implode('', $tags_arr);
        $str3 = str_replace($unused_char, $break, $str2);
        return $str3;
    }

    function get_tags_array($str) {
        //given a string, return a sequential array with html tags in their own elements
        $q = '?';
        return preg_split("/(<.*$q>)/", $str, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    }

    function find_unused_char($str) {
        $possible_chars = array('|', '!', '@', '#', '$', '%', '^', '&', '*', '~');
        foreach ($possible_chars as $char)
            if (strpos($str, $char) === false)
                return $char;
    }

    //Start function explode_ wrap
    function explode_wrap($text, $chunk_length) {
        $string_chunks = explode(' ', $text);
        foreach ($string_chunks as $chunk => $value) {
            if (strlen($value) >= $chunk_length) {
                $new_string_chunks[$chunk] = chunk_split($value, $chunk_length, ' ');
            } else {
                $new_string_chunks[$chunk] = $value;
            }
        }
        return $new_text = implode(' ', $new_string_chunks);
    }

    function strip_word_html($text, $allowed_tags = '<b><i><sup><sub><em><strong><u><br><ul><li><ol><strike>') {
        mb_regex_encoding('UTF-8');
        $search = array('/&lsquo;/u', '/&rsquo;/u', '/&ldquo;/u', '/&rdquo;/u', '/&mdash;/u');
        $replace = array('\'', '\'', '"', '"', '-');
        $text = preg_replace($search, $replace, $text);
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        if (mb_stripos($text, '/*') !== FALSE) {
            $text = mb_eregi_replace('#/\*.*?\*/#s', '', $text, 'm');
        }
        $text = preg_replace(array('/<([0-9]+)/'), array('< $1'), $text);
        $text = strip_tags($text, $allowed_tags);
        $text = preg_replace(array('/^\s\s+/', '/\s\s+$/', '/\s\s+/u'), array('', '', ' '), $text);
        $search = array('#<(strong|b)[^>]*>(.*?)</(strong|b)>#isu', '#<(em|i)[^>]*>(.*?)</(em|i)>#isu', '#<u[^>]*>(.*?)</u>#isu');
        $replace = array('<b>$2</b>', '<i>$2</i>', '<u>$1</u>');
        $text = preg_replace($search, $replace, $text);
        $num_matches = preg_match_all("/\<!--/u", $text, $matches);
        if ($num_matches) {
            $text = preg_replace('/\<!--(.)*--\>/isu', '', $text);
        }
        return $text;
    }

    function closetags($html) {
        preg_match_all("#<([a-z]+)( .*)?(?!/)>#iU", $html, $result);
        $openedtags = $result[1];
        preg_match_all("#</([a-z]+)>#iU", $html, $result);
        $closedtags = $result[1];
        $len_opened = count($openedtags);
        if (count($closedtags) == $len_opened) {
            return $html;
        }
        $openedtags = array_reverse($openedtags);
        for ($i = 0; $i < $len_opened; $i++) {
            if (!in_array($openedtags[$i], $closedtags)) {
                $html .= "</" . $openedtags[$i] . ">";
            } else {
                unset($closedtags[array_search($openedtags[$i], $closedtags)]);
            }
        }
        return $html;
    }

    function getFileSize($size) {
        if ($size) {
            if ($size < 1024) {
                return $size . " Kb";
            } else {
                $filesize = $size / 1024;
                return number_format($filesize, 2) . " Mb";
            }
        }
    }

    function displayImages($caseFileName) {
        $imgaes = "";
        $oldname = strtolower($caseFileName);
        $ext = substr(strrchr($oldname, "."), 1);
        if ($ext == "png" || $ext == "jpeg" || $ext == "jpg" || $ext == "gif" || $ext == "ttf" || $ext == "bmp") {
            //$size = getimagesize(DIR_CASE_FILES.$caseFileName);
            //$size = getimagesize(DIR_CASE_FILES_S3.$caseFileName);
            $fileurl = $this->generateTemporaryURL(DIR_CASE_FILES_S3 . $caseFileName);
            $size = getimagesize($fileurl);
            if ($size[0] >= 225) {
                $imgaes = "<a href='" . HTTP_ROOT . "easycases/download/" . $caseFileName . "'>
								<img src='" . HTTP_ROOT . "easycases/image_thumb/?type=case&file=" . $caseFileName . "&sizex=225&sizey=200&quality=100' border='0' style='border:1px solid #D6D6D6;background:#FEFEE2' alt='" . $caseFileName . "' title='" . $caseFileName . "'/>
							</a>";
            } else {
                $imgaes = "<a href='" . HTTP_ROOT . "easycases/download/" . $caseFileName . "'>
								<img src='" . HTTP_CASE_FILES . $caseFileName . "' border='0' style='border:1px solid #D6D6D6;background:#FEFEE2'  alt='" . $caseFileName . "' title='" . $caseFileName . "'/>
							</a>";
            }
        }
        return $imgaes;
    }

    function validateImgFileExt($filename) {
        $ext = substr(strrchr($filename, "."), 1);
        $extList = array("png", "gif", "jpg", "jpeg", "bmp", "JPEG"); #"tif",

        $ext = strtolower($ext);
        if (in_array($ext, $extList)) {
            return true;
        } else {
            return false;
        }
    }
	function validatePdfFileExt($filename) {
        $ext = substr(strrchr($filename, "."), 1);
        $extList = array("pdf","PDF");
        $ext = strtolower($ext);
        if (in_array($ext, $extList)) {
            return true;
        } else {
            return false;
        }
    }
    function generateTemporaryURL($resource) {
        $bucketname = BUCKET_NAME;
        $awsAccessKey = awsAccessKey;
        $awsSecretKey = awsSecretKey;
        $expires = strtotime('+1 day'); //1.day.from_now.to_i; 
        $s3_key = explode(BUCKET_NAME, $resource);
        $x = $s3_key[1];
        $s3_key[1] = substr($x, 1);
        $string = "GET\n\n\n{$expires}\n/{$bucketname}/{$s3_key[1]}";
        $signature = urlencode(base64_encode((hash_hmac("sha1", utf8_encode($string), $awsSecretKey, TRUE))));
        return "{$resource}?AWSAccessKeyId={$awsAccessKey}&Signature={$signature}&Expires={$expires}";
    }

    function convert_ascii($string) {
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

    /**
     * @method public format_activity_message(json $json_arr,int $log_type_id,array $log) Here we are just formating the message of a log activity
     * @author Gayadhar <abc@mydomain.com>
     * @return String Well formated message with respect to the input json value
     */
    function activity_message($json = '', $log_type_id = '', $logtype) {
		$allplsns = Configure::read('TYPES_PLAN');
        $json_arr = json_decode($json, true);
        if ($log_type_id == 1) {// Account Created 
            $message = $logtype[1];
            if (USER_TYPE == 1) {
                $message .=" &nbsp<span style='color:#008cdd;'>" . $json_arr['company_name'] . "</span> ".__("As a",true)." " . "<span style='color:#008cdd;'>" . $json_arr['user_type'] . "</span> ".__("account",true).". ";
            }
            return $message;
        }
        if ($log_type_id == 24) { // Account Confirmed
            $message = $logtype[$log_type_id];
            if (USER_TYPE == 1) {
                $message .=" &nbsp<span style='color:#008cdd;'>" . $json_arr['company_name'] . "</span>";
            }
            return $message;
            return $message = __("Company account has been confirmed by",true)." '<span style='color:#008cdd;'>" . $json_arr['name'] . "</span>' ".__("as a",true)." <span style='color:#008cdd;'>" . $json_arr['user_type'] . "</span> ".__("user",true).". ";
        }
        if ($log_type_id == 25) {
            return $message = $logtype[$log_type_id] . "&nbsp ".__('With email',true)." '<span style='color:#008cdd;'>" . $json_arr['email'] . "</span>'";
        }
        if ($log_type_id == 26) {
            return $message = $logtype[26] . " ".__('With',true)." '<span style='color:#008cdd;'>" . $json_arr['email'] . "</span>' ";
        }
        if ($log_type_id == 27) {
            return $message = $logtype[27] . " ".__("With email",true)." '<span style='color:#008cdd;'>" . $json_arr['email'] . "</span>' ";
        }
        if ($log_type_id == 28) {
            return $message = $logtype[28] . " ".__("With email",true)." '<span style='color:#008cdd;'>" . $json_arr['email'] . "</span>' ";
        }
        if ($log_type_id == 3) {
            return $message = "<span style='color:#EE0000'>" . $logtype[3] . "</span> ".__('With')." '<span style='color:#008cdd;'>" . $json_arr['email'] . "</span>' ";
        }
        if ($log_type_id == 4) {
			if(isset($json_arr['old_subscription']) && isset($json_arr['new_subscription'])){
				return $message = $logtype[4] . " ".__('from',true)." '<span style='color:#008cdd;'>" . $allplsns[$json_arr['old_subscription']] . "</span>' ".__('To',true)." '<span style='color:#008cdd;'>" . $allplsns[$json_arr['new_subscription']] . "</span>'";
			}else{
            return $message = $logtype[4] . " ".__('from',true)." '<span style='color:#008cdd;'>" . $json_arr['previous_plan'] . "</span>' ".__('To',true)." '<span style='color:#008cdd;'>" . $json_arr['current_plan'] . "</span>'";
        }
        }
        if ($log_type_id == 5) {
            return $message = $logtype[5];
        }
        if ($log_type_id == 6) {
            return $message = $logtype[6];
        }
        if ($log_type_id == 7) {
					//return $message = $logtype[7] . "- <span style='color:#008cdd;'>$" . $json_arr['amount'] . "</span>";
					return $message = $logtype[7];
        }
        if ($log_type_id == 8) {
            return $message = $logtype[8] . " - <span style='color:#008cdd;'>$" . $json_arr['price'] . "</span> , ".__('updated during',true)." <span style='color:#008cdd;'>" . $json_arr['message'] . '</span> ';
        }
        if ($log_type_id == 9) {
            return $message = $logtype[9] . " - <span style='color:#008cdd;'>$" . $json_arr['price'] . "</span>";
        }
        if ($log_type_id == 12) {
            return $message = "<span style='color:#EE0000'>" . $logtype[12] . "</span> - <span style='color:#008cdd;'>$" . $json_arr['price'] . "</span> ";
        }
        if ($log_type_id == 17) {
            return $message = $logtype[17] . " - <span style='color:#008cdd;'>$" . $json_arr['price'] . "</span>  ";
        }
        if ($log_type_id == 18) {
            return $message = $logtype[18] . " - $" . $json_arr['price'] . "</span>  ";
        }
        if ($log_type_id == 20) {
            return $message = $logtype[20] . " - <span style='color:#008cdd;'>$" . $json_arr['price'] . "</span> ";
        }
        if ($log_type_id == 36) {// trial period extended
            $message = $logtype[36];
            if (USER_TYPE == 1) {
                $message .=" ".__('to',true)."&nbsp<span style='color:#008cdd;'>" . $json_arr['extend_trial'] . "</span> ".__('days',true)." ";
            }
            return $message;
        }
        return $logtype[$log_type_id];
    }

    function gettimezone($timezone_id) {
        if ($timezone_id) {
            $timezone = ClassRegistry::init('TimezoneNames')->find('first', array('conditions' => array('id' => $timezone_id)));
            return $timezone['TimezoneNames']['gmt'] . "<br/>" . $timezone['TimezoneNames']['zone'];
        } else {
            return false;
        }
    }

    function isiPad() {
        preg_match('/iPad/i', $_SERVER['HTTP_USER_AGENT'], $match);
        if (!empty($match)) {
            return true;
        }
        return false;
    }

    /**
     * @method public iptolocation(string $ip) Detect the location from IP
     * @author GDR<support@ornagescrum.com>
     * @return string  Location fromt the ip
     */
    function iptoloccation($ip) {
        $key = IP2LOC_API_KEY;
        $data = file_get_contents('http://api.ipinfodb.com/v3/ip-city/?key=' . $key . '&ip=' . $ip . '&format=json');
        $data = json_decode($data, true);
        if ($data['ipAddress']) {
            $location = $data['ipAddress'];
        }
        $ipaddr = "";
        if (trim(trim($data['cityName']), '-')) {
            $ipaddr = $data['cityName'] . ", ";
        }
        if (trim(trim($data['regionName']), '-')) {
            $ipaddr .= $data['regionName'] . ", ";
        }
        if (trim(trim($data['countryName']), '-')) {
            $ipaddr .= $data['countryName'] . ", ";
        }
        if (trim(trim($data['latitude']), '-') && trim(trim($data['longitude']), '-')) {
            $location = "IP: " . $location . ", lon/lat: " . $data['longitude'] . "/ " . $data['latitude'];
        }
        if ($ipaddr) {
            $ipaddr = trim($ipaddr, ', ');
            $location = $ipaddr . "<br/>" . $location;
        }
        return $location;
        /* print "<pre>";
          print_r(json_decode($data));
          print "</pre>";
          $tags = get_meta_tags('http://www.geobytes.com/IpLocator.htm?GetLocation&template=php3.txt&IpAddress='.$ip);
          if(isset($tags['city']) && isset($tags['region']) && isset($tags['country']) && $tags['city']){
          $location = $tags['city'].", ".$tags['region'].", ".$tags['country'];
          if(isset($tags['longitude']) && isset($tags['latitude'])) {
          $location.= "<br/>IP: ".$ip.", lon/lat: ".$tags['longitude']."/".$tags['latitude'];
          }
          }else{
          $location = $ip;
          }
          return $location; */
    }

    /**
     * @method: public formatprofileimage(string $photoname) Get the formatted image
     * @author GDR <abc@mydomain.com>
     * @return String Formatted Image
     */
    function formatprofileimage($photoname = '') {
        if ($photoname) {
            return '<img src="' . HTTP_ROOT . 'users/image_thumb/?type=photos&file=' . $photoname . '&sizex=28&sizey=28&quality=100" class="round_profile_img" height="28" width="28" />';
        } else {
            return '<img src="' . HTTP_ROOT . 'users/image_thumb/?type=photos&file=user.png&sizex=28&sizey=28&quality=100" class="round_profile_img" height="28" width="28" />';
        }
    }

    /**
     * @method: public splitwithspace(string $photoname) Get the formatted image
     * @author GDR <abc@mydomain.com>
     * @return String Formatted Image
     */
    function splitwithspace($name = '') {
        if ($name && strstr($name, ' ')) {
            $arr = explode(' ', $name);
            return $arr[0];
        } else {
            return $name;
        }
    }

    function getTaskdetails($prjid, $tskid) {
        $Tasks = ClassRegistry::init('Easycase');
        //$Tasks->recursive = -1;
        $tskDtls = $Tasks->find('first', array('conditions' => array('Easycase.id' => $tskid, 'Easycase.project_id' => $prjid)));
        return $tskDtls;
    }

    function getTaskdetailsNew($tskid) {
        $Tasks = ClassRegistry::init('Easycase');
        //$Tasks->recursive = -1;
        $tskDtls = $Tasks->find('first', array('conditions' => array('Easycase.id' => $tskid)));
        return $tskDtls;
    }

    function getTaskType($tsktypid) {
        $Types = ClassRegistry::init('Type');
        //$Tasks->recursive = -1;
        $typDtls = $Types->find('first', array('conditions' => array('Type.id' => $tsktypid)));
        return $typDtls;
    }

    function frmtdata($str, $strt = 0, $len = 20) {
        if (!empty($str) && strlen($str) > $len) {
            $newstr = substr($str, $strt, $len);
            return $newstr . "...";
        } else {
            return $str;
        }
    }

    function chngdttime($lgdt, $lgtime) {
        $newdt = $lgdt . " " . $lgtime;
        return date("g:i A", strtotime($newdt));
    }

    /* Author: GKM
     * to format sec to hr min
     */

    function format_time_hr_min($totalsecs = '', $mode = '', $is_formt=0) {
        if ($mode == 'decimal') {
            $val = round($totalsecs / 3600, 2);
			if($is_formt){
				$val = number_format($val);
			}
            #$val = floor($totalsecs / 3600) . "." . round(($totalsecs % 3600) / 60);
        } elseif ($mode == 'hrmin') {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '0';
			if($is_formt){
				$hours = number_format($hours);
			}
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round(($totalsecs % 3600) / 60) : '00';
            $val = $hours . ":" . str_pad($mins, 2, '0', STR_PAD_LEFT);
        } else {
			if($is_formt){
				$hours = floor($totalsecs / 3600) > 0 ? number_format(floor($totalsecs / 3600)) . " hr" . (floor($totalsecs / 3600) > 1 ? 's' : '') . " " : '';
			}else{
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) . " hr" . (floor($totalsecs / 3600) > 1 ? 's' : '') . " " : '';
			}
            $mins = round(($totalsecs % 3600) / 60) > 0 ? "" . round(($totalsecs % 3600) / 60) . " min" . (round(($totalsecs % 3600) / 60) > 1 ? 's' : '') : '';
            $val = $hours . "" . $mins;
        }

        return $val;
    }
	function api_format_time_hr_min($totalsecs = '', $mode = '') {
        if ($mode == 'decimal') {
            $val = round($totalsecs / 3600, 2);
            #$val = floor($totalsecs / 3600) . "." . round(($totalsecs % 3600) / 60);
        } elseif ($mode == 'hrmin') {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '0';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round(($totalsecs % 3600) / 60) : '00';
            $val = $hours . ":" . str_pad($mins, 2, '0', STR_PAD_LEFT);
        } else {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) . ":" . (floor($totalsecs / 3600) > 1 ? '' : '') . "" : '00:';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? "" . round(($totalsecs % 3600) / 60) . "" . (round(($totalsecs % 3600) / 60) > 1 ? '' : '') : '00';
            $val = $hours . "" . $mins;
        }
        return $val;
    }
    /* By GKM
     * used to generate invoice number
     */

    function invoice_number($invoice) {
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
     * used to format time only
     */

    function get_time($date = '', $format = 'h:i a') {
        if ($date == '') {
            $date = date("Y-m-d H:i:s");
        }
        $format = (SES_TIME_FORMAT == 12)?'g:i a':'H:i';
        return date($format, strtotime($date));
    }

    /* By GKM
     * used to format date only
     */

    function get_date($date = '', $format = 'M d, Y') {
        if ($date == '') {
            $date = date("Y-m-d H:i:s");
        }
        return date($format, strtotime($date));
    }

    /* By GKM
     * used to format date and time
     */

    function get_date_time($date = '', $format = 'M d, Y h:i a') {
        if ($date == '') {
            $date = date("Y-m-d H:i:s");
        }
        return date($format, strtotime($date));
    }

    /* By GKM
     * currency dropdown data
     */

    function currency_opts($chk=0) {
        $Currency = ClassRegistry::init('Currency');
        $CurrencyData = $Currency->find('all', array(
            'conditions' => array('Currency.status' => 'Active'),
            'fields' => array('Currency.id', 'Currency.code', 'Currency.name'),
            'order' => 'Currency.code ASC'
                )
        );
        $final_arr = array();
        $length = 45;
        if (!$chk) {
            $final_arr[0] = 'Select Currency';
        }
        if (is_array($CurrencyData) && count($CurrencyData) > 0) {
            foreach ($CurrencyData as $val) {
                $name = trim($val['Currency']['name']);
                $final_arr[$val['Currency']['id']] = $val['Currency']['code'] . " : " . (strlen($name) > $length ? substr($name, 0, $length) . "..." : $name);
            }
        }
        return $final_arr;
    }

    /* By GKM
     * used to format price value
     */

    function format_price($number, $decimals = 2, $dec_point = '.', $thousands_sep = '') {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
        #return number_format($number, 2, '.', '');
    }

    /* By GKM
     * used to display_activity_log
     */

    function display_activity_log($data = array()) {
        if ($data['InvoiceActivity']['user_id'] == SES_ID) {
            $return_text = "You have ";
        } else {
            $return_text = $data['User']['name'] . " " . $data['User']['last_name'] . " has ";
        }

        if ($data['InvoiceActivity']['activity'] == 'create') {
            $return_text .= " created ";
        } elseif ($data['InvoiceActivity']['activity'] == 'download') {
            $return_text .= " downloaded ";
        } elseif ($data['InvoiceActivity']['activity'] == 'email') {
            $return_text .= " sent ";
        } elseif ($data['InvoiceActivity']['activity'] == 'modify') {
            $return_text .= " modified ";
        } elseif ($data['InvoiceActivity']['activity'] == 'view') {
            $return_text .= " viewed ";
        } elseif ($data['InvoiceActivity']['activity'] == 'paid') {
            $return_text .= " received payment on ";
        } elseif ($data['InvoiceActivity']['activity'] == 'unpaid') {
            $return_text .= " not received payment on ";
        }
        return $return_text .= " this invoice.";
    }

    function formatTitle($title) {
        if (isset($title) && !empty($title)) {
            $title = htmlspecialchars(html_entity_decode($title, ENT_QUOTES, 'UTF-8'));
        }
        return $title;
    }

    /* By STJ
     * used to Convert seconds into hours.mins format
     */

    function formatHour($secds) {
        $number = $secds / 3600;
        return number_format((float) $number, 2, '.', '');
    }

    function getProfileBgColr($uid = null) {
        if ($uid) {
            $t_clr = Configure::read('PROFILE_BG_CLR');
            $random_bgclr = $t_clr[array_rand($t_clr, 1)];
            $ret_colr = $random_bgclr;
            if (!isset($_SESSION['user_profile_colr'])) {
                $_SESSION['user_profile_colr'] = array();
                $_SESSION['user_profile_colr'][$uid] = $random_bgclr;
            } else {
                if (!array_key_exists($uid, $_SESSION['user_profile_colr'])) {
                    $_SESSION['user_profile_colr'][$uid] = $random_bgclr;
                } else {
                    $ret_colr = $_SESSION['user_profile_colr'][$uid];
                }
            }
            return $ret_colr;
        }
    }
	  /*
     * Author Satyajeet
     * To get the number of week in a month
     */
    public function weekOfMonth($date) {
        //Get the first day of the month.
        $firstOfMonth = strtotime(date("Y-m-01", $date));
        //Apply formula (Week of the month = Week of the year - Week of the year of first day of month + 1).
        return intval(date("W", $date)) - intval(date("W", $firstOfMonth)) + 1;
    }
	 /*
     * Check for chat On
     */
		 function isChatOn($sts = null){
			//$UserSubscription = ClassRegistry::init('UserSubscription');         
			//$Company = ClassRegistry::init('Company');  
			//$Companys = $Company->find('first', array('conditions' => array('id' => SES_COMP), 'order' => 'id DESC'));
			
			$chatAll = Configure::read('PLANS_NOT_ALLOW_CHAT');
			if(IS_PER_USER){
				//$curSubscriptions = $UserSubscription->find('first', array('conditions' => array('company_id' => $Companys['Company']['id']), 'order' => 'id DESC'));
				if(SES_COMP == 1 || SES_COMP==28528 || ($GLOBALS['user_subscription']['subscription_id'] == 16 && ($GLOBALS['user_subscription']['user_limit'] >= 15 || $GLOBALS['user_subscription']['user_limit'] == 'Unlimited')) || ($GLOBALS['user_subscription']['user_limit'] >= 15 || $GLOBALS['user_subscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15))){
					return 1;
				}else{
					return 0;
				}
			}else if($sts){
				if($sts == 1){
					if(!in_array($GLOBALS['user_subscription']['subscription_id'], $chatAll) || SES_COMP == 1 || SES_COMP==28528  ){
						return 1;
					}
				}else{
					if(in_array($GLOBALS['user_subscription']['subscription_id'], $chatAll)){
						return 1;
					}
				}				
			}
			return 0;
    }
	 /*
     * Check the resource availability On
     */
    function isResourceAvailabilityOn($sts = null){
         $FeatureSetting = ClassRegistry::init('FeatureSetting');
         $ResourceSetting = ClassRegistry::init('ResourceSetting');
         $UserSubscription = ClassRegistry::init('UserSubscription');         
		$NewPricingUser = ClassRegistry::init('NewPricingUser');
         $setting = $FeatureSetting->find('first', array('conditions' => array('id' => 1), 'fields' => array('subscription_id')));
		 if($setting['FeatureSetting']['subscription_id'] == ''){
              return 0;
         }
         $settingArr = explode(",", $setting['FeatureSetting']['subscription_id']); 
         /*
          * Get subscriptions
          */
         $curSubscriptions = $UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
		 $IsNewPricingUser = $NewPricingUser->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
           if($sts == 'upgrade'){
			if(in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr) || SES_COMP == 1 || SES_COMP==41080 || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))) || ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))){
                   return 1;
              }else{
                   return 0;
              }
         }else if($sts == 'status'){
             $rs = $ResourceSetting->find('first', array('conditions' => array('company_id' => SES_COMP), 'fields' => array('is_active')));
                if(empty($rs) || (isset($rs['ResourceSetting']['is_active']) && $rs['ResourceSetting']['is_active'] ==1)){
                   return 1;  
                }else{
                    return 0;
                }
         }else{
			 if(in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr) || SES_COMP == 1 || SES_COMP==41080 || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))) || ($curSubscriptions['UserSubscription']['user_limit'] >= 20 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))){
             $rs = $ResourceSetting->find('first', array('conditions' => array('company_id' => SES_COMP), 'fields' => array('is_active')));
             if( empty($rs) || (isset($rs['ResourceSetting']['is_active']) && $rs['ResourceSetting']['is_active'] ==1)){
            return 1;
         }else{
             return 0;
         }
         }else{
             return 0;
    }
    }
    }
	function imageTypeIcon($format) {
		$iconsArr = array("gd", "db", "zip", "xls", "doc", "jpg", "png", "bmp", "pdf", "tif", "txt", "psd", "video", "ppt", "sql", "csv");
		$format = strtolower($format);
		if ($format == "xlsx") {
			$format = "xls";
		} else if ($format == "docx" || $format == "rtf" || $format == "odt") {
			$format = "doc";
		} else if ($format == "jpeg") {
			$format = "jpg";
		} else if ($format == "gif") {
			$format = "png";
		} else if ($format == "rar" || $format == "gz" || $format == "bz2") {
			$format = "zip";
		} else if ($format == "mp4" || $format == "3gp" || $format == "mpeg4" || $format == "mkv") {
			$format = "video";
		}
		if (!in_array($format, $iconsArr)) {
			$format = 'html';
		}
		return $format;
	}
	 /*
     * Check the Timesheet  On
     */
    function isTimesheetOn($sts = null, $chk=0){
			return 0;
    }
		/*
     * Check the task reminder  On
     */
    function isTaskReminderOn($chk=0){			
			//global live delete this
			/*if(SES_COMP == 1 || SES_COMP == 28528){
				return 1;
			}else{
				return 0;
			}*/		
			$FeatureSetting = ClassRegistry::init('FeatureSetting');
			$UserSubscription = ClassRegistry::init('UserSubscription');
			$setting = $FeatureSetting->find('first', array('conditions' => array('id' => 6), 'fields' => array('subscription_id')));
			if($setting['FeatureSetting']['subscription_id'] == ''){
				return 0;
			}
			$settingArr = explode(",", $setting['FeatureSetting']['subscription_id']); 
			$curSubscriptions = $UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));	
			
			if($chk && in_array($curSubscriptions['UserSubscription']['subscription_id'], array(13,10,21))){ //start up and free (11)
				return 0;
			}
			if(in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr) || SES_COMP == 1 || SES_COMP == 28528 || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] >= 10 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited')) || ($curSubscriptions['UserSubscription']['user_limit'] >= 10 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited')){
				 return 1;  
			}else{
				return 0;
			}
	}
	function isFeatureOn($featur_nm = null, $sub_id=null){
		$all_comp_allow = Configure::read('ALLOWED_COMPANIES');
		$all_plan_restricted = Configure::read('FEATURE_RESTRICTED_PLAN');
		if(defined('CMP_CREATED') && CMP_CREATED <= '2018-01-23 00:00:59'){
			return 0;
		}
		if(!$sub_id){
			$UserSubscription = ClassRegistry::init('UserSubscription'); 
			$curSubscriptions = $UserSubscription->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
			$sub_id = $curSubscriptions['UserSubscription']['subscription_id'];
		}		
		$fetur_arra = $all_plan_restricted;
		if(isset($fetur_arra[$featur_nm]) && in_array($sub_id, $fetur_arra[$featur_nm]) && !in_array(SES_COMP,$all_comp_allow)){
			return 1; 
		}else{
			return 0; 
		}
    }
	/*
     * Author PRB
     * user_cnt: remaining user
	 * prj_cnt: tootal created project
	 * storage_cnt: remaining storage
     */
    public function getAlertText($user_cnt=0, $prj_cnt=0, $storage_cnt=0, $used_storage=0) {
		$ret_text = '';
		if(strtolower($GLOBALS['Userlimitation']['user_limit']) != 'unlimited'){
			/*if($user_cnt <= 2 && $user_cnt >0){
				$ret_text .= "<p>User limit of your account is almost completed(".($GLOBALS['Userlimitation']['user_limit']-$user_cnt)."/".$GLOBALS['Userlimitation']['user_limit'].")</p>";
			}else */
			if($user_cnt <=0){
				$ret_text .= "<p>".__("You have reached the allowed user limit for your current plan and cannot invite additional users",true).".</p>";
			}		
		}
		if(strtolower($GLOBALS['Userlimitation']['project_limit']) != 'unlimited'){
			$cnt_pj = $GLOBALS['Userlimitation']['project_limit']-$prj_cnt;
			/*if($cnt_pj <= 2 && $cnt_pj >0){
				$ret_text .= "<p>Project limit of your account is almost completed(".($GLOBALS['Userlimitation']['project_limit']-$prj_cnt)."/".$GLOBALS['Userlimitation']['project_limit'].")</p>";
			}else */				
			if($cnt_pj <=0){
				$ret_text .= "<p>".__("You have reached the allowed project(s) limit for your Free Plan",true).".</p>";
			}	
		}
		if(strtolower($GLOBALS['Userlimitation']['storage']) != 'unlimited'){
			/*if($storage_cnt <= 1 && $storage_cnt >0){
				$ret_text .= "<p>Storage limit of you account is almost completed(".$storage_cnt."/".$GLOBALS['Userlimitation']['storage'].")GB.</p>";
			}else */
			if($storage_cnt <=0 && $used_storage > 0){
				$ret_text .= "<p>".__("You have exhausted your storage limit",true).".</p>";
			}		
		}	
		if($GLOBALS['Userlimitation']['subscription_id'] == 11 && !$GLOBALS['Userlimitation']['is_free'] && ($GLOBALS['Userlimitation']['company_id'] != 5303 && $GLOBALS['Userlimitation']['company_id'] != 8728 && $GLOBALS['Userlimitation']['company_id'] !=15602 && $GLOBALS['Userlimitation']['company_id'] !=17945 && $GLOBALS['Userlimitation']['company_id'] != 20414)){
		//	$t_dt = date("Y-m-d H:i:s", strtotime($GLOBALS['Userlimitation']['created'] . ' +' . FREE_TRIAL_PERIOD . 'days'));
			$t_dt = date("Y-m-d H:i:s", strtotime($GLOBALS['Userlimitation']['created'] . ' +' . $GLOBALS['Userlimitation']['free_trail_days'] . 'days'));
			if ($GLOBALS['Userlimitation']['extend_trial'] != 0) {
				$t_dt = date("Y-m-d H:i:s", strtotime($GLOBALS['Userlimitation']['extend_date'] . ' +' . $GLOBALS['Userlimitation']['extend_trial'] . 'days'));
			}
			$datetime1 = new DateTime(date("Y-m-d H:i:s"));
			$datetime2 = new DateTime($t_dt);
			$interval = $datetime1->diff($datetime2);
			$days_to_go = $interval->format('%R%a');
			
			$vhk_t = 0;
			if ($days_to_go < 0) {
				$vhk_t = 1;
				//$ret_text .= "<p>" . FREE_TRIAL_PERIOD . "-".__("day Free trial has expired. Subscribe to one of the plans to activate your account",true).".</p>";
				$ret_text .= "<p>" . $GLOBALS['Userlimitation']['free_trail_days'] . "-".__("day Free trial has expired. Subscribe to one of the plans to activate your account",true).".</p>";
			} else if($days_to_go > 0 && $days_to_go < 2) {
				$ret_text .= "<p>".__("Your account expires in",true)." " . $interval->format('%a') . " day(s).</p>";
				$vhk_t = 1;
			}		 
			if($vhk_t != 1 && $ret_text != ''){
				//$ret_text .= "<p>Manage your account If you would like more users or more ptojects</p>";
			}
		}
		if($ret_text != '' && PAGE_NAME != 'pricing'){
			$ret_text .= "<a href='" . HTTP_ROOT . "users/pricing' onclick='return trackEventLeadTracker(\'Account Alert\',\'Upgrade\',\'".$_SESSION['SES_EMAIL_USER_LOGIN']."\');' class='dropdown-toggle upgrade_btn' ><button class='btn btn_cmn_efect cmn_bg btn-info cmn_size' type='button'>Upgrade Now!</button></a>";
		}else if($ret_text != '' && PAGE_NAME == 'pricing'){
			$ret_text .= "<a href='javascript:void(0);'>".__("Upgrade Now",true)."!</a>";
		}
		if($ret_text != ''){
			if(!isset($_SESSION['show_info'])){
				$_SESSION['show_info'] = 1;
			}
		}else{
			unset($_SESSION['show_info']);
		}
		return $ret_text;
    }
	function getQuickcaseMembers($projUniq) {
        $result = array();
		if($projUniq != 'all'){
			$Easycase_wc = ClassRegistry::init('Easycase');
			$Project_wc = ClassRegistry::init('Project');
			$quickMem = $Easycase_wc->getMemebers($projUniq);
			$result['quickMem'] = $quickMem;
			$prj = $Project_wc->findByUniqId($projUniq);
			$result['defaultAssign'] = $prj['Project']['default_assign'];
			$result['defaultTaskType'] = $prj['Project']['task_type'];
		}
		return $result;
    }
     function format_second_hrmin($totalsecs = '') {
        $hours = $mins = '00';
        if (!empty($totalsecs)) {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '00';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round(($totalsecs % 3600) / 60) : '00';
        }
			return str_pad($hours, 2, '0', STR_PAD_LEFT) . ":" . str_pad($mins, 2, '0', STR_PAD_LEFT);
    }
	function getlockIcon($type=null){
		if($GLOBALS['Userlimitation']['subscription_id'] == CURRENT_EXPIRED_PLAN || $type==1){
            if( $type==1){
			return '<i class="material-icons icon-lock-pos" style="font-size: 14px;color: #888;position:absolute;top:6px;">&#xE897;</i>';
		}else{
                return '<i class="material-icons icon-lock-pos" style="font-size: 14px;color: #888;">&#xE897;</i>';
            }
        }else{
			return '';
		}
	}
    function getworkhr($whl,$dt){
      if(!empty($whl)){
      foreach($whl as $k=>$v){
         $logdt = date('Y-m-d', strtotime($k));
         if(strtotime($dt) >= strtotime($logdt)){
             return $v;
         }
       } 
      }else{
          return 8;
      }
       return 8;
    }
	function getPriority($proj_priority) {
		if ($proj_priority == "NULL" || $proj_priority == "") {
			return;
		} else if ($proj_priority == 0) {
			return 'high';
		} else if ($proj_priority == 1) {
			return 'medium';
		} else if ($proj_priority >= 2) {
			return 'low';
		}
	}
function showSubtaskTitle($title, $id, $related, $type=0, $c_ase=array()) {
		if($type){
			$title = '<a href="javascript:void(0);" data-href="' . HTTP_ROOT . 'dashboard#details/' . $c_ase['uniq_id'] . '" onclick="return switchtaskwithProject(this);" data-pid="' . $c_ase['uniq_id'] . '">#' . $c_ase['case_no'] . ": " . $title . '</a>';
		}else{
			$title = '<a href="'.HTTP_ROOT.'dashboard#details/'.$c_ase['uniq_id'].'" class="cmn_link_color">'.$title.'</a>';
		}
        if (!empty($related['parent'][$id])) {
            $parent_id = $related['parent'][$id];
            if (!empty($related['parent'][$parent_id])) {
                $super_parent_id = $related['parent'][$parent_id];
				if($related['client_status']['is_client'] && $related['client_status']['chekstatus'][$parent_id]){
				}else{
					if($type){
						$title .= '<a href="javascript:void(0);" data-href="' . HTTP_ROOT . 'dashboard#details/' . $related['data'][$parent_id]['uniq_id'] . '" onclick="return switchtaskwithProject(this);" data-pid="' . $related['data'][$parent_id]['uniq_id'] . '"> <i class="material-icons">&#xE314;</i> '. trim($related['task'][$parent_id]) . '</a>';
					}else{
						$title .= '<a href="'.HTTP_ROOT.'dashboard#details/'.$related['data'][$parent_id]['uniq_id'].'" class="cmn_link_color"> <i class="material-icons">&#xE314;</i> '.trim($related['task'][$parent_id]).'</a>';
					}
				}
				if($related['client_status']['is_client'] && $related['client_status']['chekstatus'][$super_parent_id]){
				}else{
					if($type){
						$title .= '<a href="javascript:void(0);" data-href="' . HTTP_ROOT . 'dashboard#details/' . $related['data'][$super_parent_id]['uniq_id'] . '" onclick="return switchtaskwithProject(this);" data-pid="' . $related['data'][$super_parent_id]['uniq_id'] . '"> <i class="material-icons">&#xE314;</i> '. trim($related['task'][$super_parent_id]) . '</a>';
					}else{
						$title .= '<a href="'.HTTP_ROOT.'dashboard#details/'.$related['data'][$super_parent_id]['uniq_id'].'" class="cmn_link_color"> <i class="material-icons">&#xE314;</i> '.trim($related['task'][$super_parent_id]).'</a>';
					}
				}
            } else {
				if($related['client_status']['is_client'] && $related['client_status']['chekstatus'][$parent_id]){
				}else{
					if($type){
						$title .= '<a href="javascript:void(0);" data-href="' . HTTP_ROOT . 'dashboard#details/' . $related['data'][$parent_id]['uniq_id'] . '" onclick="return switchtaskwithProject(this);" data-pid="' . $related['data'][$parent_id]['uniq_id'] . '"> <i class="material-icons">&#xE314;</i> '. trim($related['task'][$parent_id]) . '</a>';
					}else{
						$title .= '<a href="'.HTTP_ROOT.'dashboard#details/'.$related['data'][$parent_id]['uniq_id'].'" class="cmn_link_color"> <i class="material-icons">&#xE314;</i> '.trim($related['task'][$parent_id]).'</a>';
					}
				}
            }
        }
        return ucfirst($title);
    }
function smart_wordwrap($string, $width = 75, $break = "<br>") {
        $pattern = sprintf('/([^ ]{%d,})/', $width);
        $output = '';
        $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        foreach ($words as $word) {
            // normal behaviour, rebuild the string
            if (false !== strpos($word, ' ')) {
                $output .= $word;
            } else {
                // work out how many characters would be on the current line
                $wrapped = explode($break, wordwrap($output, $width, $break));
                $count = $width - (strlen(end($wrapped)) % $width);

                // fill the current line and add a break
                $output .= substr($word, 0, $count) . $break;

                // wrap any remaining characters from the problem word
                $output .= wordwrap(substr($word, $count), $width, $break, true);
            }
        }

        // wrap the final output
        return wordwrap($output, $width, $break);
    }
    function gethh_mm($sec){
        $t = round($sec);
        return sprintf('%02d:%02d', ($t/3600),($t/60%60));
    }
	
	/* Wiki related code starts here */
	
		function createTreeView($array, $currentParent, $firstWikiId, $currLevel = 0, $prevLevel = -1) {
#			echo "<pre>";print_r($array);exit;
			foreach ($array as $categoryId => $category) {
				if ($currentParent == $category['parent_id']) {
					if ($currLevel > $prevLevel) {
						if ($currLevel == 0) {
							echo " <ul id='tree'> ";
						} else {
							echo " <ul> ";
						}
					}
					if ($currLevel == $prevLevel) {
						echo " </li> ";
					}
	
					if($firstWikiId == $categoryId){
						$selectedMenu = 'style="color:#f5911c;text-decoration:underline"';
					}else{
						$selectedMenu = '';
					}
					
					if ($currentParent == 0) {
						if(strlen($category['name']) > 33){
							$newCatName = substr(htmlspecialchars($category['name']), 0, 33)."&hellip;";
							echo '<li><a href="javascript:void(0);" class="selectedCls_'.$categoryId.'" '.$selectedMenu.' rel="tooltip" title="'.htmlspecialchars($category['name']).'" onclick="getWikiDetails(' . $categoryId . ')"><strong>' . $newCatName . '</strong></a>';
						}else{
							echo '<li><a href="javascript:void(0);" class="selectedCls_'.$categoryId.'" '.$selectedMenu.' onclick="getWikiDetails(' . $categoryId . ')"><strong>' . $category['name'] . '</strong></a>';
						}
					} else {
						if(strlen($category['name']) > 30){
							$newCatName = substr(htmlspecialchars($category['name']), 0, 30)."&hellip;";
							echo '<li><a href="javascript:void(0);" class="selectedCls_'.$categoryId.'" '.$selectedMenu.' rel="tooltip" title="'.htmlspecialchars($category['name']).'" onclick="getWikiDetails(' . $categoryId . ')">' . $newCatName . '</a>';
						}else{
							echo '<li><a href="javascript:void(0);" class="selectedCls_'.$categoryId.'" '.$selectedMenu.' onclick="getWikiDetails(' . $categoryId . ')">' . $category['name'] . '</a>';
						}
					}
	
					if ($currLevel > $prevLevel) {
						$prevLevel = $currLevel;
					}
	
					$currLevel++;
	
					$this->createTreeView($array, $categoryId, $currLevel, $prevLevel);
	
					$currLevel--;
				}
			}
	
			if ($currLevel == $prevLevel) {
				echo " </li>  </ul> ";
			}
		}
		
		function getWikiCreatorName($WikiUserId) {
			$User = ClassRegistry::init('User');
			$getWikiUsername = $User->find('first', array('conditions' => array('id' => $WikiUserId)));
			return $getWikiUsername['User']['name'];
		}
		
		function chngdate($lgdt) {
			if ($GLOBALS['DateFormat'] == 2) {
				$date_format = 'd M, Y';
			} else {
				$date_format = 'M d, Y';
			}
			return date($date_format, strtotime($lgdt));
		}
	
		function chngdate_csv($lgdt) {
			if ($GLOBALS['DateFormat'] == 2) {
				$date_format = 'd M Y';
			} else {
				$date_format = 'M d Y';
			}
			return date($date_format, strtotime($lgdt));
		}
		/*
     * Check the resource availability On
     */
	function isWikiOn($sts = null) {
        if(SES_COMP == 28528 || SES_COMP == 1){
            return 1;
        }
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
	/* Wiki related code ends here */
    /* Check user role */
    function isAllowed($action,$roleAccess,$project_id=0,$company=0){ 
			if((SES_TYPE ==2 || SES_TYPE ==1) && $action != 'Change Due Date Reason'){
			  return true;
		}
        if($roleAccess == ""){
            $roleInfo1 = Cache::read('userRole'.SES_COMP.'_'.SES_ID);
            $roleAccess = $roleInfo1['roleAccess'];
        }
        if($company!=0){
            $project_id = 0;
        }else{
        $project_id = $_COOKIE['CPUID'];

        if(!empty($project_id) && isset($roleAccess[$project_id]) && !empty($roleAccess[$project_id])){

        }else{
           $project_id = 0; //Company Setting ; 
        } 
        }
        /*  if (array_key_exists($action,$roleAccess1[$project_id]) && $roleAccess1[$project_id][$action] == 0) {
             return false;                                 
         } else {
             return true;
         } */
		
		  if (array_key_exists($action,$roleAccess[$project_id])){
			  
			if($roleAccess[$project_id][$action] == 0) {
             return false;                                 
         } else {
             return true;
         }
         } else {
             return false;
         } 
    }
	
    /* End*/	
    public function getsubmenucolor($color){
        $color = trim($color);
        $text_class = '';
        if (strpos($color, 'gradient-45deg-') !== false){
            if($color == "gradient-45deg-white"){
                $text_class = str_replace('gradient-45deg-','',$color);
                $text_class = $text_class.'-text';
            }else{
                $text_class = str_replace('gradient-45deg-','',$color);
            }
        }else{
            $text_class = $color."-text";
        }
        return $text_class;
    }
    function isGoogleSyncOn($company_id,$user_id,$type='1'){
     $UserSubscription = ClassRegistry::init('UserSubscription');
     $curSubscriptions = $UserSubscription->readSubDetlfromCache($company_id);
	$NewPricingUser = ClassRegistry::init('NewPricingUser');
	$IsNewPricingUser = $NewPricingUser->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));

     if($type == 1){
        if(in_array($curSubscriptions['UserSubscription']['subscription_id'], array(10,21)) || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] <= 20 && $curSubscriptions['UserSubscription']['user_limit'] != 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] < 11 && $IsNewPricingUser)) || ($curSubscriptions['UserSubscription']['user_limit'] < 11 && $curSubscriptions['UserSubscription']['user_limit'] != 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit']  < 11) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] < 11 && $IsNewPricingUser))) ){
          return 0;
        }else{
           return 1;
        }
     }else{
			if(in_array($curSubscriptions['UserSubscription']['subscription_id'], array(10,21,13)) || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] <= 20 && $curSubscriptions['UserSubscription']['user_limit'] != 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11))) || ($curSubscriptions['UserSubscription']['user_limit'] < 11 && $curSubscriptions['UserSubscription']['user_limit'] != 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] < 11) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] < 11 && $IsNewPricingUser))){
          return 0;
        }else{
           return 1;
        }
     }
  }
  /*
     * Check the GitHub on
     */
    function isGithubOn($company_id, $chk=0){			
			//global live delete this
			$FeatureSetting = ClassRegistry::init('FeatureSetting');
			$UserSubscription = ClassRegistry::init('UserSubscription');
			$NewPricingUser = ClassRegistry::init('NewPricingUser');
			$setting = $FeatureSetting->find('first', array('conditions' => array('id' => 7), 'fields' => array('subscription_id')));
		 if($setting['FeatureSetting']['subscription_id'] == ''){
              return 0;
         }
         $settingArr = explode(",", $setting['FeatureSetting']['subscription_id']); 

			$curSubscriptions = $UserSubscription->find('first', array('conditions' => array('company_id' => $company_id), 'order' => 'id DESC'));
			$IsNewPricingUser = $NewPricingUser->find('first', array('conditions' => array('company_id' => SES_COMP), 'order' => 'id DESC'));
			if($chk && (in_array($curSubscriptions['UserSubscription']['subscription_id'], array(1,9,2,3)) && $company_id != 1 && $company_id != 28528)){ //start up and free (11)
          return 0;
			}
			if($chk){
           return 1;
        }
			if(in_array($curSubscriptions['UserSubscription']['subscription_id'], $settingArr) || $company_id == 1 || $company_id == 28528 || ($curSubscriptions['UserSubscription']['subscription_id'] == 16 && ($curSubscriptions['UserSubscription']['user_limit'] >= 35 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))) || ($curSubscriptions['UserSubscription']['user_limit'] >= 35 || $curSubscriptions['UserSubscription']['user_limit'] == 'Unlimited' || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 15) || (IS_PER_USER && $curSubscriptions['UserSubscription']['user_limit'] >= 11 && $IsNewPricingUser))){
				 return 1;  
     }else{
          return 0;
        }
     }
  function getTaskPermalink($projShortName,$taskNo){
    return $projShortName.'-'.$taskNo;
  }

  function checkCustomMenuStatus($menu = array(),$theme_settings,$page_array,$roleAccess,$exp_plan,$user_subscription,$pmethodology,$is_parent_menu, $url=''){	
    $returnArr = array();
    $pmethodology = strtolower($pmethodology);
    $returnArr['active_class'] = '';
    $returnArr['isAllow'] = false;
    $returnArr['dynamic_url'] = $returnArr['dynamic_a_click'] = $returnArr['dynamic_menu_name'] = '';
    $grad = ($is_parent_menu)?$theme_settings['sidebar_color'].' gradient-shadow':''; 
    switch(strtolower($menu['name'])){
        case "dashboard":
             if(CONTROLLER == "easycases" && (PAGE_NAME == "mydashboard")){
                $returnArr['active_class'] = 'active '.$grad;
             }
            if($this->isAllowed('View Dashboard',$roleAccess)){
                $returnArr['isAllow'] = true;
            }
            break;
        ######################### 
		case "mention":
             
            $returnArr['isAllow'] = true;
			$returnArr['dynamic_url'] = HTTP_ROOT . 'dashboard#/mentioned_list';
            $returnArr['dynamic_a_click'] = " return checkHashLoad('mentioned_list');";
            if($url == HTTP_ROOT . 'dashboard#/mentioned_list'){
                $returnArr['active_class'] = 'active '.$grad;
            }
            break;
        ######################### 		
        case "bug tracking":
             
            $returnArr['isAllow'] = true;
			$returnArr['dynamic_url'] = HTTP_ROOT . 'defect';
            if(CONTROLLER == "Defects" && (PAGE_NAME == "defect" || PAGE_NAME == "defect_details")){
                $returnArr['active_class'] = 'active '.$grad;
             }
             if($url == HTTP_ROOT . 'defect'){
                $returnArr['active_class'] = 'active '.$grad;
             }
             if(!$this->isAllowedDefectModule()){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(0,0,0,1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon(1);
            }
            break;
        ######################### 		
        case "projects":
            if(CONTROLLER == "projects" && (PAGE_NAME == "manage")){
                $returnArr['active_class'] = 'active '.$grad;
             }
             if($this->isAllowed('View Project',$roleAccess)){
                $returnArr['isAllow'] = true;
             }

            $type = $_COOKIE['PROJECTVIEW_TYPE'];
            $type = explode('_', $type);
            $projecturl = '';
            $projecturl = DEFAULT_PROJECTVIEW == 'manage' ? '/' : '/active-grid';
            $returnArr['dynamic_url'] = HTTP_ROOT . 'projects/manage' . $projecturl;

            break;
        #########################    
        case "tasks":
            if(CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")){
               $returnArr['active_class'] = 'active '.$grad; 
            }
            $returnArr['isAllow'] = true;

            $tskurl = '';
            $onclick = '';
            $ldTrkUrl = '';
            if(DEFAULT_VIEW_VALUE != 0){
                $tskurl = DEFAULT_VIEW_TASK;
                $ldTrkUrl = DEFAULT_VIEW_TASK;
                if (DEFAULT_VIEW_TASK == 'tasks') {
                    $onclick = "checkHashLoad('tasks')";
                    $ldTrkUrl = 'Tasks Page';
                } else if (DEFAULT_VIEW_TASK == 'taskgroup') {
                    $tskurl = "tasks";
                    $onclick = "return groupby('milestone')";
                    $ldTrkUrl = 'Task List Page';
								}	else if (DEFAULT_VIEW_TASK == 'taskgroups') {
									$tskurl = "taskgroups";
									$onclick = "return ajaxCaseView('taskgroups')";
									$ldTrkUrl = 'Sub Task Group View';
								} else{
                    $onclick = "return checkHashLoad('milestonelist')";
                    $ldTrkUrl = 'Task Group Page';
                }
            }else{
                $tskurl = DEFAULT_TASKVIEW == 'milestonelist' ? 'milestonelist' : 'tasks';
                if (DEFAULT_TASKVIEW == 'tasks') {
                    $onclick = "checkHashLoad('tasks')";
                    $ldTrkUrl = 'Tasks Page';
                } else if (DEFAULT_TASKVIEW == 'task_group') {
                    $onclick = "return groupby('milestone')";
                    $ldTrkUrl = 'Task Group Page';
                } else if (DEFAULT_TASKVIEW == 'taskgroups') {
									$tskurl = "taskgroups";
									$onclick = "return ajaxCaseView('taskgroups')";
									$ldTrkUrl = 'Sub Task Group View';
								}else {
                    $onclick = "return checkHashLoad('milestonelist')";
                    $ldTrkUrl = 'Task Group Page';
                }
            }
            if($url == HTTP_ROOT . 'dashboard#/' . $tskurl){
                $returnArr['active_class'] = 'active '.$grad; 
            }
            $returnArr['url'] = $url;
            $returnArr['dynamic_url'] = HTTP_ROOT . 'dashboard#/' . $tskurl;
            $returnArr['dynamic_a_click'] = $onclick.";";

            break;
        #########################    
        case "reports":
             if((CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports'  || in_array(PAGE_NAME, $page_array) || CONTROLLER == 'ProjectReports' || CONTROLLER == 'project_reports')){
                   $returnArr['active_class'] = 'active '.$grad;
             }
             if(($url == HTTP_ROOT . 'project_reports/dashboard') || ($url == HTTP_ROOT . 'project_reports/dashboard/#tasks')){
                $returnArr['active_class'] = 'active '.$grad;
             }
             $returnArr['isAllow'] = true;
             if($exp_plan){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon();
                $returnArr['not_show_inner_menu'] = 1;
            }

            break;
        #########################    
        case "time log":
            if (CONTROLLER == "easycases" && (PAGE_NAME == "timelog")) {
                $returnArr['active_class'] = 'active '.$grad;
            }
            $returnArr['isAllow'] = true;

            $timelogurl = '';
            $ldTrkUrl = '';
            $timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
            $ldTrkUrl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'Time Log Calendar Page' : 'Time Log Page';
            $returnArr['dynamic_url'] = HTTP_ROOT . 'dashboard#/' . $timelogurl;

            if($url == HTTP_ROOT . 'dashboard#/timelog'){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if($exp_plan){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon();
                $returnArr['not_show_inner_menu'] = 1;
            }


            break;
        #########################
        case "gantt chart":
            if (CONTROLLER == "ganttchart") {
                $returnArr['active_class'] = 'active '.$grad;
            }
            if ($this->isAllowed('View Gantt Chart',$roleAccess)) {
              $returnArr['isAllow'] = true;
            }
            if ($this->isFeatureOn('gantt', $user_subscription['subscription_id'])) {
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(0,1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon(1);
            }
            if($exp_plan){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon();
            }
            break;
        #########################
        case "wiki":           
           if (CONTROLLER == "Wiki") {
                $returnArr['active_class'] = 'active '. $grad;
            }  
            if($this->isAllowed('View Wiki',$roleAccess) && $this->isWikiOn()){
                $returnArr['isAllow'] = true;
            }    
            if((SES_COMP == 1 || SES_COMP == 28528) && $this->isAllowed('View Wiki',$roleAccess) ) {
               $returnArr['isAllow'] = true; 
            } 
            if($exp_plan){   
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon();
            } 
            break;
        #########################
        case "kanban":

            if($this->isAllowed('View Kanban',$roleAccess) && ($pmethodology == 'kanban' || $pmethodology == 'simple') ){
                $returnArr['isAllow'] = true;
            }

            $kanbanurl = '';
            $ldTrkUrl = '';
            $kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist';
            $ldTrkUrl = DEFAULT_KANBANVIEW == 'kanban' ? 'Kanban Task Status Page' : 'Kanban Task Group';
            $returnArr['dynamic_url'] = HTTP_ROOT . 'dashboard#/' . $kanbanurl;
            
            break;
        #########################
        case "board":

            if($this->isAllowed('View Kanban',$roleAccess) && $pmethodology != 'scrum'  && $pmethodology != 'simple'){
                $returnArr['isAllow'] = true;
            }

            $kanbanurl = '';
            $ldTrkUrl = '';
            $kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist';
            $ldTrkUrl = DEFAULT_KANBANVIEW == 'kanban' ? 'Kanban Task Status Page' : 'Kanban Task Group';
            $returnArr['dynamic_url'] = HTTP_ROOT . 'dashboard#/' . $kanbanurl;
            $returnArr['dynamic_menu_name'] = ($pmethodology =='kanban')?__('Kanban'):__('Board');
            
            break;
        #########################
        case "users":
            if(CONTROLLER == "users" && (PAGE_NAME == "manage")) {
                $returnArr['active_class'] = 'active '.$grad;
            }
            if ($this->isAllowed('View Users',$roleAccess) ) {
                $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "backlog":
            if($pmethodology == 'scrum'){
                $returnArr['isAllow'] = true;
            }
            break;
        case "active sprint":
            if($pmethodology == 'scrum'){    
                $returnArr['isAllow'] = true;
            }
            if($exp_plan){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon();
            }

            break;
        #########################
        case "project plan":
            if (CONTROLLER == "templates") {
                $returnArr['active_class'] = 'active '.$grad;
            }
            if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) {
                $returnArr['isAllow'] = true;
            }
            break;        
        #########################
        case "project template":
            if (PAGE_NAME == "manageProjectTemplates") {
                $returnArr['active_class'] = 'active '.$grad;
            }
            if ($_SESSION['Auth']['User']['is_client'] != 1 || ($_SESSION['Auth']['User']['is_client'] == 1 && SES_TYPE == 2)) {
                $returnArr['isAllow'] = true;
            }
            break; 
        #########################
        case "resource mgmt":
            if(PAGE_NAME == "resource_utilization" || PAGE_NAME == "resource_availability"){
                $returnArr['active_class'] = 'active '.$grad;
             }
             if ($this->isAllowed('View Resource Utilization',$roleAccess) || $this->isAllowed('View Resource Availability',$roleAccess)) {
                $returnArr['isAllow'] = true;
             }
             if(!$this->isAllowed('View Resource Utilization',$roleAccess)){
                $returnArr['dynamic_url'] = "javascript:void(0);";
             }
             if($exp_plan){
                $returnArr['isAllow'] = false; 
            }
            break;
        #########################
        case "status workflow":
            if(PAGE_NAME == "manage_task_status_group" || PAGE_NAME == "manage_status"){
                $returnArr['active_class'] = 'active '.$grad;
             }
            if(SES_TYPE < 3){
                $returnArr['isAllow'] = true;
            }
            if(!$this->isTimesheetOn(5) || !$this->isLifeFreeUser()){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(0,0,0,1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon(1);
            }

            break;
        #########################
        case "more":
            $returnArr['isAllow'] = true;
            break;
        #########################
        #######Reports Submenus## 
        #########################    
        case "pending tasks":
            if(PAGE_NAME == 'pending_task' ){    
                $returnArr['active_class'] = 'active '.$grad;   
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Pending Task', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################        
        case "sprint report":
            if(PAGE_NAME == 'completed_sprint_report' ){
                 $returnArr['active_class'] = 'active '.$grad; 
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Sprint Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################        
        case "velocity chart":
            if(PAGE_NAME == 'velocity_reports' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Velocity Chart', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################        
        case "average age report":
            if(PAGE_NAME == 'average_age_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Average Age Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "created vs. resolved tasks report":
            if(PAGE_NAME == 'create_resolve_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Created vs Resolved Tasks Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
         case "resolution time report":
            if(PAGE_NAME == 'resolution_time_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
             if (SES_TYPE < 3 || $this->isAllowed('View Resolution Time Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
             }
            break;
        #########################
        case "recently created tasks report":
            if(PAGE_NAME == 'recent_created_task_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Recently Created Tasks Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "pie chart report":
            if(PAGE_NAME == 'pie_chart_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Pie Chart Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "time since tasks report":
            if(PAGE_NAME == 'time_since_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Time Since Task Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "hours spent report":
            if(PAGE_NAME == 'hours_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Hour Spent Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "tasks report":
            if(PAGE_NAME == 'chart' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Task Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "weekly usage":
            if(PAGE_NAME == 'weeklyusage_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Weekly Usage', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        case "resource utilization":
            if(PAGE_NAME == 'resource_utilization' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if ($this->isAllowed('View Resource Utilization',$roleAccess)){
                $returnArr['isAllow'] = true;
            }
            if($exp_plan){
                $returnArr['isAllow'] = false; 
            }
            break;
        #########################
         case "sprint burndown report":
            if(PAGE_NAME == 'sprint_burndown_report' ){
                $returnArr['active_class'] = 'active '.$grad;
            }
            if (SES_TYPE < 3 || $this->isAllowed('View Sprint Burndown Report', $roleAccess)) {
            $returnArr['isAllow'] = true;
            }
            break;
        #########################
        ########Tasks submenu####
        #########################
         case "all tasks":
         case "tasks assigned to me":
         case "favourites":
         case "overdue":
         case "tasks i have created":
         case "high priority":
         case "all opened":
         case "all closed":
            if(strtolower($menu['name']) == 'all tasks'){
                if(!$this->isAllowed('View All Task',$roleAccess)){
                    $returnArr['isAllow'] = false;
                }else{
                    $returnArr['isAllow'] = true; 
                }
            }else{
                 $returnArr['isAllow'] = true; 
            }
         break;
        #########################
        ########Timelog submenu####
        #########################
        case "time log list view":
            $returnArr['isAllow'] = true; 
            $timelogurl = '';
            $ldTrkUrl = '';
            $timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
            $ldTrkUrl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'Time Log Calendar Page' : 'Time Log Page';
            $returnArr['dynamic_url'] = HTTP_ROOT . 'dashboard/#' . $timelogurl;
            if(DEFAULT_TIMELOGVIEW == 'calendar_timelog'){
                $returnArr['dynamic_menu_name'] = __('Calender View');
            }
            if($exp_plan){
                $returnArr['isAllow'] = false; 
            }
        break;
        ######################### 
        case "weekly timesheet":
            $returnArr['isAllow'] = true; 
            if (!$this->isTimesheetOn() || !$this->isLifeFreeUser()) {
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(0, 1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon(1);
            }
            if($exp_plan){
                $returnArr['isAllow'] = false; 
            }
        break;
        #########################  
        case "resource availability":
            $returnArr['isAllow'] = true;
            if($this->isAllowed('View Resource Availability',$roleAccess)){
                $returnArr['isAllow'] = true; 
            } 
            if(!$this->isResourceAvailabilityOn('upgrade') || !$this->isResourceAvailabilityOn('status') || !$this->isLifeFreeUser()){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(0, 1, 1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon(1);
            }
            if($exp_plan){
                $returnArr['isAllow'] = false; 
            }
        break;
        #########################
        ########More submenu####
        #########################
        case "files":
            if($this->isAllowed('View File',$roleAccess)){
                $returnArr['isAllow'] = true; 
            }
        break;
        ######################### 
        case "invoices":
            if (CONTROLLER == "easycases" && (PAGE_NAME == "invoice")) {
                $returnArr['active_class'] = 'active '.$grad;
            }
            if($this->isAllowed('View Invoices',$roleAccess)){
                $returnArr['isAllow'] = true;
            } 
            if($exp_plan){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon(1);
            }
        break;
        #########################  
        case "daily catch-up":
            if (CONTROLLER == "projects" && (PAGE_NAME == "groupupdatealerts")) {
                     $returnArr['active_class'] = 'active '.$grad;
            }
            if($this->isAllowed('View Daily Catchup',$roleAccess)){
                $returnArr['isAllow'] = true;
            } 
            if($exp_plan){
                $returnArr['dynamic_url'] = "javascript:void(0);";
                $returnArr['dynamic_a_click'] = "showUpgradPopup(1);";
                $returnArr['dynamic_menu_name'] = $menu['name'].' '.$this->getlockIcon(1);
            } 
        break; 
        #########################  
        case "archive":
            if (CONTROLLER == "archives" && (PAGE_NAME == "listall")) {
                     $returnArr['active_class'] = 'active '.$grad;
            }  
            $returnArr['isAllow'] = true;          
        break;
        ######################### 
        default:

            break;
    }
    return  $returnArr;
  }
  function displayKanbanOrBoard(){
    if(in_array($_SESSION['project_methodology'],array('simple','scrum','kanban'))){
        return '<span class="kanban-or-board">'.__("Kanban").'</span>';
    }else{
        return '<span class="kanban-or-board">'.__("Board").'</span>';
    }
  }

  function displayHelpVideo(){
    return in_array($GLOBALS['Userlimitation']['subscription_id'],array(11,13));
  }
  function getStorageCount($user_count){
		if($user_count <= 14){
			return 5120;
		} else if($user_count <= 24){
			return 10240;
		} else if($user_count <= 54){
			return 20480;
		} else if($user_count <= 100){
			return 51200;
		} else if($user_count <= 200){
			return 102400;
		} else if($user_count > 200){
			return 153600;
		} 
	}
  
  function format_second_hrmin_pad($totalsecs = '') {
        $hours = $mins = '00';
        if (!empty($totalsecs)) {
            $hours = floor($totalsecs / 3600) > 0 ? floor($totalsecs / 3600) : '00';
            $mins = round(($totalsecs % 3600) / 60) > 0 ? round(($totalsecs % 3600) / 60) : '00';
        }
        return str_pad($hours, 2, '0', STR_PAD_LEFT) . ":" . str_pad($mins, 2, '0', STR_PAD_LEFT);
    }
    /**
     * isAllowZapier
     * @author bijaya
     * @param  mixed $company_id
     * @return void
     * this function check whether user is allowed to access zpaier or not
     */
    function isAllowZapier($company_id){
				return 0;
        $UserSubscription = ClassRegistry::init('UserSubscription');
        $user_sub = $UserSubscription->readSubDetlfromCache($company_id);
    
        $subId= $user_sub['UserSubscription']['subscription_id'];
        $userLimit= $user_sub['UserSubscription']['user_limit'];
        if ($subId == 11  || ($subId != 13 && $userLimit > 10) || $userLimit == 'Unlimited') {
            return 1;
        } else {
            return 0;
        }
    }
            
    /*
     * Check whether the current user is life time free
     */
    function isLifeFreeUser(){
        $UserSubscription = ClassRegistry::init('UserSubscription');       
				$curSubscriptions = $UserSubscription->readSubDetlfromCache(SES_COMP);        
        if($curSubscriptions['UserSubscription']['lifetime_free'] == 1){ //start up and free
            return 0;
        }else{
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
		public function isSsoOn()
    {
			return 0;
    }
		
		public function isZoomOn()
    {
			return 0;
    }
}
