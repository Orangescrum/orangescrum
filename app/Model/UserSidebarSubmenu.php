<?php
App::uses('AppModel', 'Model');
class UserSidebarSubmenu extends AppModel {


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
		'UserSidebar' => array(
			'className' => 'UserSidebar',
			'foreignKey' => 'user_sidebar_menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'SidebarSubmenu' => array(
			'className' => 'SidebarSubmenu',
			'foreignKey' => 'sidebar_submenu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
