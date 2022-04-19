<?php
class CompanyUser extends AppModel {
    var $name = 'CompanyUser';

    /* 	var $belongsTo = array('Company' =>
      array('className'     => 'Company',
      'foreignKey'    => 'company_id'
      ),
      'User' =>
      array('className'     => 'User',
      'foreignKey'    => 'user_id'
      )
      ); */
    /**
     * @method private delte_company(int $comp_id) Delete all the company data
     * @author GDR<support@orangescrum.com>
     * @return bool True/False
     */
	function checkuserPermiToDelete($ses_id, $comp_id){
		if($comp_id == 1){
			return 0;
		}
		if(SES_COMP == 1){
			return 0;
		}
		$userDetl_t = $this->find('first',array('conditions'=>array('CompanyUser.user_id'=>$ses_id,'CompanyUser.company_id'=>$comp_id,'CompanyUser.is_active'=>1),'fields'=>array('id','company_id','user_id','user_type')));
		if(!$userDetl_t || $userDetl_t['CompanyUser']['user_type'] != 1){
			return 0;
		}
		return 1;
	}
    function delete_company($comp_id) {
    }

    function getCompanyUserFields($uid = null, $companyId = null) {
        $this->recursive = -1;
        $sql_cu = "SELECT CompanyUser.company_id,CompanyUser.user_type,Company.uniq_id,Company.name, Company.seo_url FROM company_users CompanyUser , companies Company WHERE Company.id = CompanyUser.company_id AND CompanyUser.user_id=" . $uid . " AND CompanyUser.company_id=" . $companyId . " AND CompanyUser.is_active=1";
        return $this->query($sql_cu);
        //return $this->find('first',array('conditions'=>$condition,'fields'=>$fields));
    }
    function getComnameFromUser($uid) {
        $this->recursive = -1;
        $sql_cu = "SELECT CompanyUser.company_id,Company.seo_url FROM company_users CompanyUser , companies Company WHERE Company.id = CompanyUser.company_id AND CompanyUser.user_id=" . $uid . " AND CompanyUser.is_active=1";
        return $this->query($sql_cu);
    }
	function getCompanyIdFromUser($uid) {
        $this->recursive = -1;
	    return $this->find('first',array('conditions'=>array('CompanyUser.user_id' => $uid),'fields'=>array('CompanyUser.id', 'CompanyUser.company_id','CompanyUser.company_uniq_id')));
    }
	function getCompanyIdFromCompany($uid) {
        $this->recursive = -1;
	    return $this->find('first',array('conditions'=>array('CompanyUser.company_uniq_id' => $uid),'fields'=>array('CompanyUser.id', 'CompanyUser.company_id','CompanyUser.company_uniq_id','CompanyUser.user_id')));
    }
    function updateUserPerm($comp_id = null, $uid = null, $typ) {
        //for single company only
        if ($comp_id && $uid && ($typ || $typ == 0)) {
            $this->create();
            if ($typ == 2 || $typ == 1) {
                $this->query("Update company_users SET change_timestamp='" . time() . "',is_access_change='" . $typ . "' WHERE user_id='" . $uid . "'");
            } else {
                $this->query("Update company_users SET change_timestamp='" . time() . "',is_access_change='" . $typ . "' WHERE user_id='" . $uid . "' AND company_id='" . $comp_id . "'");
            }
        } else {
            if ($comp_id == 0) {
                $this->query("Update company_users SET change_timestamp='" . time() . "',is_access_change='" . $typ . "' WHERE user_id='" . $uid . "'");
            }
        }
    }
    function checkValidUser($uid = null, $company_id = null){
		if($uid){
			$userDetl = $this->find('all',array('conditions'=>array('CompanyUser.user_id'=>$uid,'CompanyUser.company_id'=>$company_id,'CompanyUser.is_active'=>1),'fields'=>array('id','company_id','user_id')));
			if($userDetl){
				return Hash::combine($userDetl, '{n}.CompanyUser.user_id', '{n}');
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
		function getAllActiveUsers($company_id = null){
			$allUsers = array();
			if($company_id){
				$this->bindModel(
					array(
						'belongsTo'=>array(
							'User' => array(
								'className' => 'User',
								'foreignKey' => 'user_id',
							)
						)
					));
				$allUsers = $this->find('all',array('conditions'=>array('CompanyUser.company_id'=>$company_id,'CompanyUser.is_active'=>1,'CompanyUser.user_type !='=>1),'fields'=>array('User.email')));
				if($allUsers){
					$allUsers = Hash::extract($allUsers,'{n}.User.email');
					return $allUsers;
				}
			}
			return $allUsers;
		}
       
        function getAllActiveApprovers($company_id = null){
            $TimesheetApprover = ClassRegistry::init('TimesheetApprover');
			$allUsers = array();
			if($company_id){
                    $allUsers = $this->query('select
                    cu.id,
                    cu.user_id,
                    cu.company_id,
                    cu.is_active,
                    u.name,
                    u.email,
                    u.isactive
             from company_users as cu
             left join users as  u on cu.user_id = u.id
             where cu.company_id = '.$company_id.' and cu.is_active = 1 AND u.id NOT IN (select approver_id from timesheet_approvers as ta where ta.company_id = '.$company_id.' )');
			}
			return $allUsers;
		}
     /**
 * getCompanyRoles
 *
 * @param  mixed $company_id
 * @return void
 */
public function getCompanyRoles($company_id)
{
	$this->bindModel(
		array(
			'belongsTo'=>array(
				'User' => array(
					'className' => 'User',
					'foreignKey' => 'user_id',
				)
			)
		));
$allUsers = $this->find('list',
    array(
            'conditions'=>array('CompanyUser.company_id'=>$company_id,'CompanyUser.is_active'=>1),
            'fields'=>array('CompanyUser.user_id','CompanyUser.role_id')
            )
    );
		return $allUsers;		
   }

   /**
 * getUserAndRoles
 *
 * @param  mixed $company_id
 * @param  mixed $project_id
 * @return void
 */
public function getUserAndRoles($company_id, $project_id)
{
	$Project = ClassRegistry::init('Project');
	$Role = ClassRegistry::init('Role');
	
	$roles = $Role->getRoles($company_id);	
	$projRoles = $Project->getProjectRoles($company_id, $project_id);
	$compRoles = $this->getCompanyRoles($company_id);
	
	$userRole = [];		
	if(!empty($projRoles)){
		foreach($projRoles as $k => $v){
			//if($compRoles[$k] != 1){
                if(empty($v)){
                    $userRole[$k] = $compRoles[$k];
                }
                else{
                    $userRole[$k] = $v; 
                }
			//}         
			
		}
	}
	
	return ['user_role' => $userRole, 'roles' => $roles];		
}


/**
 * getCompanyIdByEmailid
 * @author bijay
 * this function return company id 
 * @param  mixed $email
 * @return void
 * dt - 29/09/2021 
 */
public function  getCompanyIdByEmailid($email){
    if(isset($email) && $email != null){
        $User = ClassRegistry::init('User');
    }
    $uid = $User->find('first',array('conditions'=>array('User.email'=>$email),'fields'=>array('User.id')));
    $query = "select c.id, c.name, c.uniq_id from company_users cu left join companies c on cu.company_id = c.id where cu.user_id = ".$uid['User']['id'];
    $companies = $this->query($query);
    return $companies;
}
}