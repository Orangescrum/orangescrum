<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property Company $Company
 * @property RoleGroup $RoleGroup
 * @property CompanyUser $CompanyUser
 * @property RoleAction $RoleAction
 * @property RoleModule $RoleModule
 */
class Role extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'role';


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
		'RoleGroup' => array(
			'className' => 'RoleGroup',
			'foreignKey' => 'role_group_id',
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
		'CompanyUser' => array(
			'className' => 'CompanyUser',
			'foreignKey' => 'role_id',
			'dependent' => false,
			'conditions' => array('CompanyUser.company_id'=>SES_COMP),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'RoleAction' => array(
			'className' => 'RoleAction',
			'foreignKey' => 'role_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),/*
        'ProjectAction' => array(
			'className' => 'ProjectAction',
			'foreignKey' => 'role_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		), */
		'RoleModule' => array(
			'className' => 'RoleModule',
			'foreignKey' => 'role_id',
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
	public function getRoles($company_id)
	{
		$company_id = [
				0,
				$company_id
		];
		$this->recursive = -1;
		$roles = $this->find(
				'list',
				array(
						'conditions'=>array('company_id'=>$company_id),
						'fields'=>array('id','role')
				)
		);
		return $roles;
	}
	
	public function getRolesByRoleGroup($company_id, $group_id)
	{
		$roles_default = [];
		if(empty($group_id)){
			$company_id = [0, $company_id];			 
			$retRole = $this->find(
				'list',
				array(
					'conditions'=>array('company_id'=>$company_id),
					'fields'=>array('id','role')
				)
			);
		}else{
			if(in_array(0, $group_id)){
				$roles_default = $this->find(
					'list',
					array(
						'conditions'=>array('company_id'=>0),
						'fields'=>array('id','role')
					)
				);
			}			
			$roles = $this->find(
				'list',
				array(
					'conditions'=>array('role_group_id'=>$group_id),
					'fields'=>array('id','role')
				)
			);			
			$retRole = (!empty($roles_default)) ? $roles_default+$roles : $roles;
		}
		
		return $retRole;
	}
	
	public function getRoleUsers($company_id, $role_id, $users=[], $type=null)
	{
		$ProjectUser = ClassRegistry::init('ProjectUser');
		$CompanyUser = ClassRegistry::init('CompanyUser');
		$CompanyUser->recursive = -1;
		
		$compUsrCond = ['company_id'=>$company_id,'role_id'=>$role_id,'is_active'=>1];
		$projUsrCond = ['company_id'=>$company_id,'role_id'=>$role_id];
		
		if(!empty($users)){
			$compUsrCond['user_id'] = $users;
			$projUsrCond['user_id'] = $users;
		}
		$comUsers = $CompanyUser->find(
			'list',
			array(
				'conditions'=>$compUsrCond,
				'fields'=>array('id','user_id')
			)
		);
		
		$ProjectUser->recursive = -1;
		$projUsers = $ProjectUser->find(
			'list',
			array(
				'conditions'=>$projUsrCond,
				'fields'=>array('id','user_id')
			)
		);
		
		if(!empty($type)){ 
			/*if($type == 'projects'){
				$roleUsers = array_unique($projUsers);
			}else{*/
				$roleUsers = array_unique($comUsers);
			//}
		}else{		
			//$roleUsers = array_unique(array_merge($comUsers,$projUsers));
			$roleUsers = array_unique($comUsers);
		}
		
		if(empty($roleUsers)){
			$roleUsers = [0 => 0];
		}
		
		return $roleUsers;
	}
}
