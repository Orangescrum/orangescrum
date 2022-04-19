<?php
App::uses('AppModel', 'Model');
/**
 * QuicklinkMenu Model
 *
 * @property QuicklinkSubmenu $QuicklinkSubmenu
 * @property UserQuicklink $UserQuicklink
 */
class QuicklinkMenu extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'QuicklinkSubmenu' => array(
			'className' => 'QuicklinkSubmenu',
			'foreignKey' => 'quicklink_menu_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'UserQuicklink' => array(
			'className' => 'UserQuicklink',
			'foreignKey' => 'quicklink_menu_id',
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
