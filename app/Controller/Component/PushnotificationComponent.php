<?php
class PushnotificationComponent extends Component {

    public $components = array('Session', 'Email', 'Cookie', 'Date');
	
    function getUserShortName($uid) {
        $User = ClassRegistry::init('User');
        $User->recursive = -1;
        $usrDtls = $User->find('first', array('conditions' => array('User.id' => $uid), 'fields' => array('User.name', 'User.short_name', 'User.photo')));
        return $usrDtls;
    }
    
	function sendPushNotiGeneral($comp_uid, $user_uid, $proj_uid, $arr, $task_details){	
		return true;
	}
	function sendPushNotificationToDevicesIOS($userIds, $PushMessage, $responseArray = NULL){
	return true;	
	}
	function sendPushNotiToAndroid($userIds, $message, $inpts=null) {
		if(FIREBASE_API_KEY == ''){return true;}
		return true;
	}
}
