<?php

class CommonappComponent extends Component {

	//public $components = array('Format', 'Sendgrid', 'Email');
	public function commonSetting($company_id, $ses_id, $AppObj) {
		$response['menu_data'] = [];
		$response['checked_ql'] = [];
		$response['checked_left_menu_submenu'] = [];
		$response['left_smenu_exist'] = [];
		$response['theme_settings'] = [];
		if (Cache::read('qlData_'.$company_id.'_'.$ses_id) === false) {
			$UserQuicklink = ClassRegistry::init('UserQuicklink');
			$ql_data = $UserQuicklink->cacheSettings();
		} else {
			$ql_data = Cache::read('qlData_'.$company_id.'_'.$ses_id);
		}
		$AppObj->set('menu_data', $response['menu_data']);
		$AppObj->set('checked_ql', $response['checked_ql']);
		
		if (Cache::read('menuData_'.$company_id.'_'.$ses_id) === false) {
				$UserSidebar = ClassRegistry::init('UserSidebar');
				$checked_left_menu_submenu = $UserSidebar->readmenudataDetlfromCache();
		} else {
				$checked_left_menu_submenu = Cache::read('menuData_'.$company_id.'_'.$ses_id);
		}
		$AppObj->set('checked_left_menu_submenu', $response['checked_left_menu_submenu']);
		$AppObj->set('left_smenu_exist', $response['left_smenu_exist']);
		if (Cache::read('allTemplate') === false) {
				$ProjectMethodology = ClassRegistry::init('ProjectMethodology');
				$templates = $ProjectMethodology->find('list', array('fields'=>array('id','title')));
				Cache::write('allTemplate', $templates);
		}
		if (Cache::read('themeData_'.$company_id.'_'.$ses_id) === false) {
				$UserTheme = ClassRegistry::init('UserTheme');
				$theme_settings = $UserTheme->cachethemeSettings();
		} else {
				$theme_settings = Cache::read('themeData_'.$company_id.'_'.$ses_id);
		}
		$AppObj->set('theme_settings', $theme_settings['UserTheme']);
	}
}
