<?php
App::uses('AppModel', 'Model');
/**
 * RoleModule Model
 *
 * @property Module $Module
 * @property Role $Role
 */
class RoleModule extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'is_active';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'module_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
