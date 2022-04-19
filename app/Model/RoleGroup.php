<?php
App::uses('AppModel', 'Model');
/**
 * RoleGroup Model
 *
 * @property Company $Company
 * @property Role $Role
 */
class RoleGroup extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';


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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_group_id',
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
	
	/**
	 * getRoles
	 *
	 * @param  mixed $company_id
	 * @return void
	 */
	public function getRoleGroups($company_id)
	{
			$this->recursive = -1;
			$role_grps = $this->find(
					'list',
					array(
							'conditions'=>array('company_id'=>$company_id),
							'fields'=>array('id','name')
					)
			);
			//array_unshift($role_grps,"Default Role Group");
			$role_grps[0] = "Default Role Group";
			ksort($role_grps);
			
			return $role_grps;
	}
	
	public function getRoleUsers($company_id, $group_id, $users=[], $type=null)
	{
		$Role = ClassRegistry::init('Role');
		$roles = $Role->find(
			'list',
			array(
				'conditions'=>array('role_group_id'=>$group_id),
				'fields'=>array('id')
			)
		);
		if(in_array(0, $group_id)){
			$roles = array_merge($roles, [1,2,3,4,699]);
		}	
		$roleUsers = $Role->getRoleUsers($company_id, $roles, $users, $type);
		
		if(empty($roleUsers)){
			$roleUsers = [0 => 0];
		}
		
		return $roleUsers;
	}
}
