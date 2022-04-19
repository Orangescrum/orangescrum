<?php
class UserLogin extends AppModel{
	var $name = 'UserLogin';
	
	/**
	 * setLoginInfofromCache.
	 * This is used to set the user daily login info due to auto login feature
	 *
	 * @param mixed $user_id
	 *
	 * @return the user id if the login is set for the day
	 * @author PRB
	 * @date 18th Aug 2021
	 */
	public function setLoginInfofromCache($user_id) {
		$today = date('Y-m-d');
		if(($login_detl = Cache::read('user_login_'.$user_id.$today)) === false) {
			Cache::delete('prrofile_detl_'.$user_id);
			Cache::write('user_login_'.$user_id.$today, $user_id);
			//save login data
			$user_login = [];
			$user_login['user_id'] = $user_id;
			$this->create();
			$this->save($user_login);
		}	
		return Cache::read('user_login_'.$user_id.$today);
	}
}