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
class UserSidebarController extends AppController {

    /**
     * add method
     *
     * @return void
     */
    public function ajax_add() {
        $res = array('status' => false);
        if ($this->request->is('ajax')) {
            if ($this->request->is('post')) {
                $data = $this->request->data['UserSidebar'];
                #pr(Cache::read('menuData_'.SES_COMP.'_'.SES_ID));exit;
                $this->loadModel('UserSidebarSubmenu');
                $results_menu_ids = Hash::extract($data, "{n}.SidebarMenu.id");
                $menu_data = array();
                $del_option = array('UserSidebar.user_id' => SES_ID, 'UserSidebar.company_id' => SES_COMP);
                $this->UserSidebar->deleteAll($del_option);

                $del_opt = array('UserSidebarSubmenu.user_id' => SES_ID, 'UserSidebarSubmenu.company_id' => SES_COMP);
                $this->UserSidebarSubmenu->deleteAll($del_opt);
                foreach ($data as $k => $v) {
                    $arr_data = array();
                    if (!empty($v['SidebarMenu']['id'])) {
                        $this->UserSidebar->clear();
                        $arr_data['UserSidebar']['user_id'] = SES_ID;
                        $arr_data['UserSidebar']['company_id'] = SES_COMP;
                        $arr_data['UserSidebar']['sidebar_menu_id'] = $v['SidebarMenu']['id'];
                        $this->UserSidebar->create();
                        $is_saved = $this->UserSidebar->save($arr_data);
                        if (!empty($is_saved)) {
                            $newMenuId = $this->UserSidebar->id;
                            if (!empty($v['SidebarMenu']['UserSidebarSubmenu'])) {
                                $sub_menu = array();
                                $s_menu_ids = $v['SidebarMenu']['UserSidebarSubmenu'];
                                foreach ($v['SidebarMenu']['UserSidebarSubmenu'] as $key => $value) {
                                    $smenu_condition = array('user_id' => SES_ID, 'company_id' => SES_COMP, 'user_sidebar_menu_id' => $newMenuId, 'sidebar_submenu_id' => $value);
                                    if (!$this->UserSidebarSubmenu->hasAny($smenu_condition)) {
                                        $sub_menu[] = array('user_id' => SES_ID, 'company_id' => SES_COMP, 'user_sidebar_menu_id' => $newMenuId, 'sidebar_submenu_id' => $value);
                                    }
                                }
                                if (is_array($sub_menu) && count($sub_menu) > 0) {
                                    $this->UserSidebarSubmenu->saveAll($sub_menu);
                                }
                            }
                        }
                    }
                }
                $res['menus'] = $this->UserSidebar->readmenudataDetlfromCache();
                $res['status'] = true;
                $res['msg'] = __('Sidebar menu settings has been saved.');
                echo json_encode($res);
                exit;
            }
        }
    }
    function ajax_save_menu(){
        if ($this->request->is('ajax')) {
            if ($this->request->is('post')) { 
                $menu = $this->request->data['menu'];
                $data['user_id'] = SES_ID;
                $data['company_id'] = SES_COMP;
                $data['menu'] = $menu;
                $this->loadModel('UserMenu');
                $existsMenu = $this->UserMenu->find('first',array('conditions'=>array('UserMenu.user_id'=>SES_ID,'UserMenu.company_id'=>SES_COMP),'fields'=>array('UserMenu.id')));
                if(isset($existsMenu['UserMenu']['id']) && !empty($existsMenu['UserMenu']['id'])){
                    $data['id'] = $existsMenu['UserMenu']['id'];
                }
                $this->UserMenu->save($data);
                Cache::delete('userMenu'.SES_COMP.'_'.SES_ID);

            }
        }
        exit;
    }
    function ajax_draw_left_menu(){
        $this->layout = 'ajax';
        $projectUID = $this->request->data['projectID'];
        $url = $this->request->data['url'];
        $this->loadModel("Project");
        $menuOrder = Cache::read('menuOrderlists');
        $this->Project->unBindModel(array('hasAndBelongsToMany' => array('User'),'hasMany'=>array('ProjectUser')));
        $this->Project->bindModel(array('belongsTo' => array('ProjectMethodology')));
        $project = $this->Project->find('first',array('conditions'=>array('Project.company_id'=>SES_COMP,'Project.uniq_id'=>$projectUID),'fields'=>array('Project.id','Project.project_methodology_id','ProjectMethodology.project_template_view_id','ProjectMethodology.title')));

        $this->set('cstm_order',$menuOrder[$project['ProjectMethodology']['project_template_view_id']]);
        $this->set('project_methodology_name',$project['ProjectMethodology']['title']);
        $this->set('url',$url);
        
    }

}
