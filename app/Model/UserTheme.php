<?php
App::uses('AppModel', 'Model');
/**
 * UserTheme Model
 *
 * @property User $User
 */
class UserTheme extends AppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array('className' => 'User','foreignKey' => 'user_id','conditions' => '','fields' => '','order' => '')
	);

	public function cachethemeSettings($comp_id=null, $user_id=null){
		$cache_company_id = (!empty($comp_id))?$comp_id:SES_COMP;
		$cache_user_id = (!empty($user_id))?$user_id:SES_ID;
		$mini_leftmenu = 0;
		if($comp_id){
			$mini_leftmenu = 1;
		}
		if (Cache::read('themeData_'.$cache_company_id.'_'.$cache_user_id) === false) {
			/*if (Cache::read('themeData_'.$cache_company_id.'_'.$cache_user_id)) {
				Cache::delete('themeData_'.$cache_company_id.'_'.$cache_user_id);
			}*/
			$conditions = array('UserTheme.user_id' => $cache_user_id);
			$theme_data = $this->find('first', array('conditions' => $conditions,'recursive'=>-1));
			$arr_data = array();
			if(empty($theme_data)){
					$arr_data['UserTheme']['user_id'] = $cache_user_id;
					$arr_data['UserTheme']['sidebar_color'] = 'gradient-45deg-deep-orange-orange'; //gradient-45deg-indigo-blue
					$arr_data['UserTheme']['navbar_color'] = 'gradient-45deg-deep-orange-orange';
					$arr_data['UserTheme']['mini_leftmenu'] = $mini_leftmenu;
					$arr_data['UserTheme']['dark_leftmenu'] = 0;
					$arr_data['UserTheme']['dark_navbar'] = 0;
					$arr_data['UserTheme']['fixed_navbar'] = 0;
					$arr_data['UserTheme']['footer_dark'] = 0;
					$arr_data['UserTheme']['footer_fixed'] = 0;
					$this->create();
					$is_saved = $this->save($arr_data);
			}
			$theme_settings = !empty($theme_data) ? $theme_data : $arr_data;
			Cache::write('themeData_'.$cache_company_id.'_'.$cache_user_id, $theme_settings);
		}
		return Cache::read('themeData_'.$cache_company_id.'_'.$cache_user_id);
	}
}
