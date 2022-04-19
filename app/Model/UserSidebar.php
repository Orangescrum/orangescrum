<?php
App::uses('AppModel', 'Model');
class UserSidebar extends AppModel {

	public $useTable = 'user_sidebar_menus';

	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SidebarMenu' => array(
			'className' => 'SidebarMenu',
			'foreignKey' => 'sidebar_menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public $hasMany = array(
		'UserSidebarSubmenu' => array(
			'className' => 'UserSidebarSubmenu',
			'foreignKey' => 'user_sidebar_menu_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);


	public function readmenudataDetlfromCache($SES_ID='',$SES_COMP ='') {
		$SES_ID = (!empty($SES_ID))?$SES_ID:SES_ID;
		$SES_COMP = (!empty($SES_COMP))?$SES_COMP:SES_COMP;
		if (Cache::read('menuData_'.$SES_COMP.'_'.$SES_ID)) {
			Cache::delete('menuData_'.$SES_COMP.'_'.$SES_ID);
		}
		$UserSidebarSubmenu = ClassRegistry::init('UserSidebarSubmenu');
		$SidebarMenu = ClassRegistry::init('SidebarMenu');
        $this->recursive = 2;
        $this->unBindModel(array('belongsTo' => array('User', 'Company')));
        $UserSidebarSubmenu->unBindModel(array('belongsTo' => array('User', 'Company','UserSidebar')));
        $SidebarMenu->unBindModel(array('hasMany' => array('SidebarSubmenu','UserSidebar')));
        $conditions = array('UserSidebar.user_id' => $SES_ID, 'UserSidebar.company_id' => $SES_COMP);
        $user_menu_data = $this->find('all', array('conditions' => $conditions, 'order' => array('UserSidebar.id' => 'ASC')));
        if(!empty($user_menu_data)){
	        $m_s_array = array();
	        foreach ($user_menu_data as $key => $value) {
	            foreach ($value['UserSidebarSubmenu'] as $k => $v) {
	                $m_s_array[strtolower($value['SidebarMenu']['name'])][] = strtolower($v['SidebarSubmenu']['name']);
	            }
	        }
	        $checked_left_menus = Hash::extract($user_menu_data, "{n}.SidebarMenu.name");
	        $checked_left_menus = array_map('strtolower', $checked_left_menus);
	        $checked_left_submenus = Hash::extract($user_menu_data, "{n}.UserSidebarSubmenu.{n}.SidebarSubmenu.name");
	        $checked_left_submenus = array_map('strtolower', $checked_left_submenus);
	        $checked_left_menu_submenu['checked_left_menu'] = !empty($checked_left_menus) ? $checked_left_menus : array();
	        $checked_left_menu_submenu['checked_left_submenus'] = !empty($checked_left_submenus) ? $checked_left_submenus : array();
	        $checked_left_menu_submenu['m_s_array'] = !empty($m_s_array) ? $m_s_array : array();
			Cache::write('menuData_'.$SES_COMP.'_'.$SES_ID, $checked_left_menu_submenu);
			return Cache::read('menuData_'.$SES_COMP.'_'.$SES_ID);
        }else{
        	return array();
        }
	}
}
