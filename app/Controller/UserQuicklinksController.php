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
/**
 * UserQuicklinks Controller
 *
 * @property UserQuicklink $UserQuicklink
 * @property PaginatorComponent $Paginator
 */
class UserQuicklinksController extends AppController {


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->loadModel('QuicklinkMenu');
		$this->loadModel('QuicklinkSubmenu');
		$this->loadModel('UserQuicklink');
		$this->QuicklinkMenu->hasMany['UserQuicklink']['conditions'] = array('UserQuicklink.user_id' => SES_ID,'UserQuicklink.company_id' => SES_COMP);
		$this->QuicklinkMenu->hasMany['QuicklinkSubmenu']['fields'] = array('QuicklinkSubmenu.*','LOWER(QuicklinkSubmenu.name) AS smenu_lowered');
		if(SES_TYPE == 1 || SES_TYPE <= 2){
			$conditions = array('LOWER(QuicklinkMenu.name) !=' => 'personal settings');
		}else{
			$conditions = array('LOWER(QuicklinkMenu.name) !=' => 'company settings');
		}
		$this->QuicklinkMenu->recursive = 2;
		$this->QuicklinkMenu->bindModel(array('belongsTo' => array('MenuLanguage' => array('className' => 'MenuLanguage', 'foreignKey' => 'menu_language_id'))));
		$this->QuicklinkMenu->QuicklinkSubmenu->bindModel(array('belongsTo' => array('MenuLanguage' => array('className' => 'MenuLanguage', 'foreignKey' => 'menu_language_id'))));
		$this->QuicklinkSubmenu->unBindModel(array('hasMany' => array('UserQuicklink','QuicklinkMenu')));
		$this->UserQuicklink->unBindModel(array('belongsTo' => array('User','Company')));
		$menu_data = $this->QuicklinkMenu->find('all', array('conditions' => $conditions, 'order' => array('QuicklinkMenu.id' => 'ASC')));
		foreach ($menu_data as $key => $value) {
			$submenu_count = count($value['QuicklinkSubmenu']);
			$sel_sub_menu = Hash::extract($value, "UserQuicklink.{n}.quicklink_submenu_id");
			$is_new = $this->UserQuicklink->find('count', array('conditions' => array('UserQuicklink.user_id' => SES_ID, 'UserQuicklink.company_id' => SES_COMP,'UserQuicklink.quicklink_menu_id' => $value['QuicklinkMenu']['id'])));
			$menu_data[$key]['QuicklinkMenu']['is_new'] = empty($is_new) ? true : false;
			if(empty($is_new)){
				$menu_data[$key]['QuicklinkMenu']['all'] = true;
			}else if($submenu_count == count($sel_sub_menu)){
				$menu_data[$key]['QuicklinkMenu']['all'] = true;
			}else{
				$menu_data[$key]['QuicklinkMenu']['all'] = false;
			}
		}
		$checked_ql = Hash::extract($menu_data, "{n}.UserQuicklink.{n}.quicklink_submenu_id");
		$this->set('menu_data', $menu_data);
		$this->set('checked_ql', $checked_ql);
	}

/**
 * add method
 *
 * @return void
 */
	public function ajax_add() {
		$res = array('status'=>false);
		if ($this->request->is('ajax')) {
			if ($this->request->is('post')) {
				$data = $this->request->data;
				$this->UserQuicklink->recursive = -1;
	            foreach ($data['UserQuicklink'] as $k => $v) {
					$results_ql_ids = array();
	            	$ql_data = array();
	            	foreach ($v['QuicklinkMenu']['QuicklinkSubmenu'] as $key => $value) {
		                $ql_condition = array('user_id' => SES_ID, 'company_id' => SES_COMP,'quicklink_menu_id'=>$v['QuicklinkMenu']['id'],'quicklink_submenu_id'=>$value);
		                $results_ql_ids[] = $value;
		                if (!$this->UserQuicklink->hasAny($ql_condition)) {
		                    $ql_data[] = array('user_id' => SES_ID, 'company_id' => SES_COMP,'quicklink_menu_id'=>$v['QuicklinkMenu']['id'],'quicklink_submenu_id'=>$value);
		                }
	            	}
		            if (is_array($ql_data) && count($ql_data) > 0) {
		                $this->UserQuicklink->saveAll($ql_data);
		            }
		            $del_opt = array('UserQuicklink.user_id' => SES_ID, 'UserQuicklink.company_id' => SES_COMP,'UserQuicklink.quicklink_menu_id'=>$v['QuicklinkMenu']['id'], 'NOT' => array('UserQuicklink.quicklink_submenu_id' => $results_ql_ids));
	            	$this->UserQuicklink->deleteAll($del_opt);
	            }
	            $this->UserQuicklink->cacheSettings();
	            $res['status'] = true;
	            $res['msg'] = __('Quick link settings has been saved.');
				echo json_encode($res);exit;
			}
		}
	}
}
