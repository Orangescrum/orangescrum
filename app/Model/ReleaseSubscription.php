<?php
App::uses('AppModel', 'Model');
class ReleaseSubscription extends AppModel {


	// The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Release' => array(
			'className' => 'Release',
			'foreignKey' => 'release_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Subscription' => array(
			'className' => 'Subscription',
			'foreignKey' => 'subscription_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
