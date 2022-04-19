<?php
App::uses('AppModel', 'Model');
/**
 * UserQuicklink Model
 *
 * @property User $User
 * @property Company $Company
 * @property QuicklinkMenu $QuicklinkMenu
 * @property QuicklinkSubmenu $QuicklinkSubmenu
 */
class UserQuicklink extends AppModel {

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array('className' => 'User','foreignKey' => 'user_id','conditions' => '','fields' => '','order' => ''),
		'Company' => array('className' => 'Company','foreignKey' => 'company_id','conditions' => '','fields' => '','order' => ''),
		'QuicklinkMenu' => array('className' => 'QuicklinkMenu','foreignKey' => 'quicklink_menu_id','conditions' => '','fields' => '','order' => ''),
		'QuicklinkSubmenu' => array('className' => 'QuicklinkSubmenu','foreignKey' => 'quicklink_submenu_id','conditions' => '','fields' => '','order' => '')
	);

	public function cacheSettings(){
		if (Cache::read('qlData_'.SES_COMP.'_'.SES_ID)) {
			Cache::delete('qlData_'.SES_COMP.'_'.SES_ID);
		}
		$QuicklinkMenu = ClassRegistry::init('QuicklinkMenu');
     	$QuicklinkSubmenu = ClassRegistry::init('QuicklinkSubmenu');

     	$QuicklinkMenu->hasMany['UserQuicklink']['conditions'] = array('UserQuicklink.user_id' => SES_ID,'UserQuicklink.company_id' => SES_COMP);
        $QuicklinkMenu->hasMany['QuicklinkSubmenu']['fields'] = array('QuicklinkSubmenu.*','LOWER(QuicklinkSubmenu.name) AS smenu_lowered');
        if(SES_TYPE == 1 || SES_TYPE <= 2){
            $conditions = array('LOWER(QuicklinkMenu.name) !=' => 'personal settings');
        }else{
            $conditions = array('LOWER(QuicklinkMenu.name) !=' => 'company settings');
        }
        $QuicklinkMenu->bindModel(array('belongsTo' => array('MenuLanguage' => array('className' => 'MenuLanguage', 'foreignKey' => 'menu_language_id'))));
        $QuicklinkMenu->QuicklinkSubmenu->bindModel(array('belongsTo' => array('MenuLanguage' => array('className' => 'MenuLanguage', 'foreignKey' => 'menu_language_id'))));
        $QuicklinkMenu->recursive = 2;
        $QuicklinkSubmenu->unBindModel(array('hasMany' => array('UserQuicklink','QuicklinkMenu')));
        $this->unBindModel(array('belongsTo' => array('User','Company')));
        $menu_data = $QuicklinkMenu->find('all', array('conditions' => $conditions, 'order' => array('QuicklinkMenu.id' => 'ASC')));
        $checked_ql = Hash::extract($menu_data, "{n}.UserQuicklink.{n}.quicklink_submenu_id");
        if(!empty($menu_data)){
	        $quicklink_settings['quick_link_menu'] = !empty($menu_data) ? $menu_data : array();
	        $quicklink_settings['checked_ql'] = !empty($checked_ql) ? $checked_ql : array();
			Cache::write('qlData_'.SES_COMP.'_'.SES_ID, $quicklink_settings);
			return Cache::read('qlData_'.SES_COMP.'_'.SES_ID);
        }else{
        	return array();
        }
	}
}
