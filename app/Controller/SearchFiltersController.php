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
App::import('Vendor', 's3', array('file' => 's3' . DS . 'S3.php'));

class SearchFiltersController extends AppController {

    public $name = 'SearchFilter';
    public $components = array('Format', 'Postcase', 'Sendgrid', 'Tmzone','Cookie');
    
   function setFilter(){
		if(isset($this->data['id']) && !empty($this->data['id'])){
			$this->layout='ajax'; 
			$this->autoRender = false;
			
			$id = $this->data['id'];
			if (stristr($this->data['id'], 'custom-')) {
				$serch_id = explode('custom-',$this->data['id']);
				//$serch_id = explode(SES_COMP, $serch_id[1]);
				$id = $serch_id[1];
			}
			$this->loadModel('SearchFilters');
			$sfarray=$this->SearchFilters->find('first',array('conditions'=>array('SearchFilters.id'=>$id)));
			echo $sfarray['SearchFilters']['json_array'];exit;			
		}
	}
    function getAllFilters(){		
		$this->loadModel('Label');
        $page_limit = FILTER_PAGE_LIMIT;
        $filterPage = (isset($this->params->data['casePage']) && !empty($this->params->data['casePage']))?$this->params->data['casePage']:1;
        $page = $filterPage;
        $limit1 = $page * $page_limit - $page_limit;
        $limit2 = $page_limit;
        $sortby = '';
        $orderby=array();
        if (isset($_COOKIE['TASKSORTBY'])) {
            $sortby = $_COOKIE['TASKSORTBY'];
            $sortorder = $_COOKIE['TASKSORTORDER'];
        }else{
             $sortorder = 'DESC';
        }        
        if ($sortby == 'name') {
            $orderby = array("SearchFilter.name"=> $sortorder) ;                
        }
        $searchFilters=ClassRegistry::init('SearchFilter');
        $count=$searchFilters->find('count',array('conditions'=>array('SearchFilter.user_id'=>SES_ID ,'SearchFilter.company_id'=>SES_COMP ,'SearchFilter.name !='=>'default')));
        $data=$searchFilters->find('all',array('conditions'=>array('SearchFilter.user_id'=>SES_ID ,'SearchFilter.company_id'=>SES_COMP,'SearchFilter.name !='=>'default'),'order'=>$orderby,'limit'=>$limit2,'offset'=>$limit1));
        $data_new=array();
        foreach($data as $k=>$v){
            $data_new[$k]['SearchFilter']=$v['SearchFilter'];            
            $arr=  json_decode($v['SearchFilter']['json_array']);
						$arr_fil = json_decode($v['SearchFilter']['json_array'], true);
            $data_new[$k]['SearchFilter']['namewithcount']=$searchFilters->getCount($arr_fil,$this->data['projUniq'],$this->data['milestoneIds'],$this->data['case_srch'],$this->data['checktype']);
            $arr1=[];
			$lbls = '';
            foreach($arr as $k1=>$v1){
                if($k1=="TASKLABEL" && !empty($v1) && $v1 != "all"){
									$lbls = '';
					if (strstr($v1, "-")) {
						$expst_lbl = explode("-", $v1);
					}else{
						$expst_lbl = $v1;
					}
					$res_lbls = $this->Label->getLabeByUid($expst_lbl, SES_COMP);
					//pr($res_lbls);exit;
					if($res_lbls){
						foreach ($res_lbls as $stv_lbl) {
							$lbls.= "<span class='filter_opn' rel='tooltip' title='Label'>" . $stv_lbl['Label']['lbl_title'] . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$stv_lbl['Label']['id']."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
						}
						//$lbls = trim($lbls, ', ');
					}
					$arr1['TASKLABEL'] = $lbls; 
                }else if($k1=="CS_TYPES" && !empty($v1) && $v1 != "all"){
                        $view = new View($this);
                        $cq = $view->loadHelper('Casequery');

												$types = '';
                        if (strstr($v1, "-")) {
                            $expst3 = explode("-", $v1);
                            foreach ($expst3 as $st3) {
                                $csTypArr = $cq->getTypeArr($st3, $GLOBALS['TYPE']);
                                $types.= "<span class='filter_opn' rel='tooltip' title='Task Type'>" . $csTypArr['Type']['short_name'] . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$st3."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                            }
                            $types = trim($types, ', ');
                        } else {
                            $csTypArr = $cq->getTypeArr($v1, $GLOBALS['TYPE']);
                            $types = "<span class='filter_opn' rel='tooltip' title='Task Type' >" . $csTypArr['Type']['short_name'] . "<a href='javascript:void(0);'  onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>"; 
                        }                                             
                    $arr1['CS_TYPES'] = $types; 
                }else if($k1=="MEMBERS" && $v1 !='' && $v1 != 'all'){
										$mems = '';
                     if (strstr($v1, "-")) {
                        $expst4 = explode("-", $v1);
                        $cbymems = $this->Format->caseMemsList($expst4);
                        foreach ($cbymems as $key => $st4) {
                            $mems .= "<span class='filter_opn' rel='tooltip' title='Created By " . $this->Format->caseMemsName($key) . "' >" . $st4 . "<a href='javascript:void(0);'  onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$st4."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                        }
                    } else {
                        $mems = "<span class='filter_opn' rel='tooltip' title='Created By " . $this->Format->caseMemsName($v1) . "' >" . $this->Format->caseMemsList($v1) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                    }
                    $arr1['MEMBERS'] = $mems;                  
                }else if($k1=="COMMENTS" && $v1 !='' && $v1 != 'all'){
										$coms = '';
                     if (strstr($v1, "-")) {
                        $expst14 = explode("-", $v1);
                        $cbymems = $this->Format->caseMemsList($expst14);
                        foreach ($cbymems as $key => $st14) {
                            $coms .= "<span class='filter_opn' rel='tooltip' title='Commented By " . $this->Format->caseMemsName($key) . "' >" . $st14 . "<a href='javascript:void(0);'  onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$st14."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                        }
                    } else {
                        $coms = "<span class='filter_opn' rel='tooltip' title='Commented By " . $this->Format->caseMemsName($v1) . "' >" . $this->Format->caseMemsList($v1) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                    }
                    $arr1['COMMENTS'] = $coms;                  
                }else if($k1=="TASKGROUP" && $v1 !='' && $v1 != 'all'){
                        $tsg = '';
                        if (strstr($v1, "-")) {
                            $expst19 = explode("-", $v1);
                            $tsgname = $this->Format->caseMilestonesName($expst19, 1);														
                            if( $expst19[0] == 'default'){
                                $tsg .= "<span class='filter_opn' rel='tooltip' title='Task Group' >Default Task Group/Backlog<a href='javascript:void(0);'  onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"default\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                            }
                            foreach ($tsgname as $key => $st19) {
                                $tsg .= "<span class='filter_opn' rel='tooltip' title='Task Group' >" . $st19 . "<a href='javascript:void(0);'  onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$key."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                            }
                        } else {
                            $tsg = "<span class='filter_opn' rel='tooltip' title='Task Group' >" . $this->Format->caseMilestonesName($v1) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                        }
                        $arr1['TASKGROUP'] = $tsg;                  
                }else if($k1=="ASSIGNTO" && $v1 !='' && $v1 != 'all'){
										$asns = '';
                     if (strstr($v1, "-")) {
                        $expst5 = explode("-", $v1);
                        $asmembers = $this->Format->caseMemsList($expst5);
                        foreach ($asmembers as $key => $st5) {
                            $asns .= "<span class='filter_opn' rel='tooltip' title='Assign To: " . $this->Format->caseMemsName($key) . "' >" . $st5 . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$st5."\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                        }
                    }else if($v1=='unassigned'){ 
                        $asns = "<span class='filter_opn' rel='tooltip' title='Assign To:No body' >Unassigned<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                    }else {
                        $asns = "<span class='filter_opn' rel='tooltip' title='Assign To: " . $this->Format->caseMemsName($v1) . "' >" . $this->Format->caseMemsList($v1) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                    }
                    $arr1['ASSIGNTO'] = $asns;                  
                }else if($k1=="STATUS" && $v1 !='' && $v1 != 'all'){                    
										$sts = '';
                     if (strstr($v1, "-")) {
                        $expst6 = explode("-", $v1);                        
                        foreach ($expst6 as $key => $st6) {
                            $sts .= "<span class='filter_opn' rel='tooltip' title='Task Status' >" . $this->Format->displayStatus($st6) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$st6."\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                        }
                    }else {
                        $sts = "<span class='filter_opn' rel='tooltip' title='Task Status' >" . $this->Format->displayStatus($v1) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                    }
                    $arr1['STATUS'] = $sts;                  
                }else if($k1=="CUSTOM_STATUS" && $v1 !='' && $v1 != 'all'){
										$csts = '';
                     if (strstr($v1, "-")) {
                        $expst6 = explode("-", $v1);                        
                        foreach ($expst6 as $key => $st6) {
                            $csts .= "<span class='filter_opn' rel='tooltip' title='Task Status' >" . $this->Format->displayStatus($st6) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$st6."\",this);' class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                        }
                    }else {
                        $csts = "<span class='filter_opn' rel='tooltip' title='Task Status' >" . $this->Format->displayStatus($v1) . "<a href='javascript:void(0);' onclick='deleteFilterItem(".$v['SearchFilter']["id"].",\"".$k1."\",\"".$v1."\",this);'  class='fr'><i class='material-icons'>&#xE14C;</i></a></span>";
                    }
                    $arr1['CUSTOM_STATUS'] = $csts;                  
                }else{
                    $arr1[$k1]=$v1;
                }                
            }
        $data_new[$k]['SearchFilter']['json_array']=json_encode($arr1);
        }
       
        $allFilters['details']=$data_new;
        $allFilters['page_limit'] = $page_limit;
        $allFilters['csPage'] = $filterPage;
        $allFilters['caseCount'] = $count;
        $allFilters['orderBy'] = $sortby;
        $allFilters['orderByType'] = $sortorder;
       
        $view = new View($this);
        $frmt = $view->loadHelper('Format');
        
        $pgShLbl = $frmt->pagingShowRecords($count, $page_limit, $filterPage);
        $allFilters['pgShLbl'] = $pgShLbl;
        $this->set('allFilters', json_encode($allFilters));
    }
    function deleteFilters(){
        $this->layout='ajax';
        $msg=array();
        if(isset($this->data['id']) && !empty($this->data['id'])){
           $this->loadModel('SearchFilters'); 
           $this->SearchFilters->delete($this->data['id']);
           $msg['message']= __("Filter deleted successfully",true).".";
           $msg['type']= "success";
        }else{
           $msg['message']= __("Filter can not delete. Please try again later",true);
           $msg['type']= "error"; 
        }
        echo json_encode($msg);exit;
    }
    function editFilters(){
        $this->layout='ajax';  
        $msg=array();
        if(isset($this->data['id']) && !empty($this->data['id'])){
            $this->loadModel('SearchFilters'); 
            $cnt=$this->SearchFilter->find("count",array("conditions"=>array("SearchFilter.name"=>trim($this->data['value']),"SearchFilter.user_id"=>SES_ID,"SearchFilter.company_id"=>SES_COMP,"SearchFilter.id != "=>$this->data['id'])));
            if($cnt >0){
                $msg['type']='error';
                $msg['message']="Filter name already exists.";
            }else{
            $data['SearchFilters']['id']=$this->data['id'];
                $data['SearchFilters']['name']=trim($this->data['value']);
            $this->SearchFilters->save($data);
            $msg['message']= __("Filter updated successfully",true).".";
            $msg['type']= "success";
            }
        }else{
            $msg['message']= __("Filter can not update. Please try again later",true);
            $msg['type']= "error";  
        }
        echo json_encode($msg);exit;
    }
    function setDefaultValue(){
        $this->layout='ajax';
        $this->loadModel('SearchFilters');
        $data['SearchFilter']['name']='default';	
        $json_arr=array();
        $data['SearchFilter']['id']='';
        $json_arr['PRIORITY']='';
        $json_arr['CS_TYPES']='';
        $json_arr['MEMBERS']='';
        $json_arr['COMMENTS']='';
        $json_arr['ASSIGNTO']='';
        $json_arr['DATE']='';
        $json_arr['DUE_DATE']='';
        $json_arr['TASKGROUP']='';
        $json_arr['TASKGROUP_FIL']='';
        $json_arr['STATUS']='';
        $data['SearchFilter']['json_array']=json_encode($json_arr);
        $data['SearchFilter']['company_id']=SES_COMP;
        $data['SearchFilter']['user_id']=SES_ID;
        $data['SearchFilter']['first_records']=1;
        $msg=array();
        $record=$this->SearchFilter->find('first',array('conditions'=>array('SearchFilter.user_id'=>SES_ID,'SearchFilter.company_id'=>SES_COMP ,'SearchFilter.name'=>'default')));
       if($record['SearchFilter']['id'] !=''){
            $this->SearchFilter->query("UPDATE search_filters as SearchFilter SET first_records=1 WHERE user_id=".SES_ID." AND company_id ='".SES_COMP."' AND name ='default'");
        }else{
            $this->SearchFilter->save($data);
        }
        exit; 
    }
    function deleteItems(){
        $this->layout="ajax";
        $n=$this->data['name'];
        if(isset($this->data['id']) && !empty($this->data['id'])){
            $datas=$this->SearchFilter->findById($this->data['id']); 
            $json_array=  json_decode($datas['SearchFilter']['json_array']);
            $val=$json_array->$n; 
            $val_arr=  explode('-', $val); 
            $result_arr = array_diff($val_arr, array($this->data['value']));
            $result_string = implode('-',$result_arr); 
            $json_array->$n=$result_string;            
            $this->SearchFilter->updateAll(array('SearchFilter.json_array' => "'". json_encode($json_array)."'"), array('SearchFilter.id'=>$datas['SearchFilter']['id']));
//            $this->SearchFilter->id=$datas['SearchFilter']['id'];
//            $this->SearchFilter->saveFileld('json_array',json_encode($json_array));
        }
        exit;
    }
    function kanbanFilters(){
        $this->layout='ajax';
        $this->loadModel("SearchFilter");                   
        $sf=$this->SearchFilter->getFiltersWithCounts($this->params->data);
        $data['sf']=$sf;
        print json_encode($data);exit;
    }

}