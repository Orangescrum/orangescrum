<?php
App::uses('AppModel', 'Model');
/**
 * Action Model
 *
 * @property Company $Company
 * @property Module $Module
 */
class Action extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'action';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Module' => array(
			'className' => 'Module',
			'foreignKey' => 'module_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'RoleAction' => array(
			'className' => 'RoleAction',
			'foreignKey' => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
