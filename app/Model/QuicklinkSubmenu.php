<?php
App::uses('AppModel', 'Model');
/**
 * QuicklinkSubmenu Model
 *
 * @property QuicklinkMenu $QuicklinkMenu
 * @property UserQuicklink $UserQuicklink
 */
class QuicklinkSubmenu extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'QuicklinkMenu' => array(
			'className' => 'QuicklinkMenu',
			'foreignKey' => 'quicklink_menu_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		// 'MenuLanguage' => array(
		// 	'className' => 'MenuLanguage',
		// 	'foreignKey' => 'menu_language_id',
		// 	'conditions' => '',
		// 	'fields' => '',
		// 	'order' => ''
		// )
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'UserQuicklink' => array(
			'className' => 'UserQuicklink',
			'foreignKey' => 'quicklink_submenu_id',
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

}
