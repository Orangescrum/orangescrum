<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {
    public function notFound($error, $type=null) {
		/*$this->controller->beforeFilter();
        $this->controller->set('title_for_layout', 'Not Found');
        $this->controller->render('/Errors/error400');
        $this->controller->response->send();*/
		if($type){
			$this->controller->redirect(array('controller' => 'Errors', 'action' => 'error404',"param" => "NF"));
		}else{
			$this->controller->redirect(array('controller' => 'Errors', 'action' => 'error400'));
		}
    }
    public function badRequest($error) {
		$this->notFound($error,'nf');
    }
    public function forbidden($error) {
		$this->notFound($error);
    }
	public function methodNotAllowed($error) {
		$this->notFound($error);
    }
	public function internalError($error) {
        $this->notFound($error,'nf');
    }
	public function missingController($error) {
        $this->notFound($error);
    }
    public function missingAction($error) {
        $this->notFound($error);
    }
    public function missingView($error) {
        $this->notFound($error);
    }
	public function missingConnection($error) {
        $this->internalError($error,'nf');
    }
	public function missingDatabase($error) {
        $this->internalError($error,'nf');
    }
/**
 * Convenience method to display a PDOException.
 *
 * @param PDOException $error
 * @return void
 */
	public function pdoError(PDOException $error) {		
		$url = $this->controller->request->here();
		$code = 500;
		$this->controller->response->statusCode($code);
		$this->controller->set(array(
			'code' => $code,
			'url' => h($url),
			'name' => $error->getMessage(),
			'error' => $error,
			'_serialize' => array('code', 'url', 'name', 'error')
		));
		$message = "<table cellpadding='1' cellspacing='1' align='left' width='100%'>".EMAIL_HEADER."
					<tr><td>&nbsp;</td></tr>
					<tr><td align='left' style='font-family:Arial;font-size:14px;'>Hi, </td></tr>
					<tr><td align='left' style='font-family:Arial;font-size:14px;'>A user is trying to do an activity on OS but not able to proceed due to below error </td></tr>
					<tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>	   
					<tr><td align='left' style='font-family:Arial;font-size:14px;'><font color='#EE0000;'>".$error->getMessage()."</font> </td></tr>	   
					<tr><td align='left' style='font-family:Arial;font-size:14px;'>&nbsp;</td></tr>
					<tr><td align='left' style='font-family:Arial;font-size:14px;'><b>Domain:</b> ".HTTP_ROOT."</td></tr>
					<tr><td align='left' style='font-family:Arial;font-size:14px;'><b>ERROR URL:</b> ".h($url)."</td></tr>
					<tr height='25px'><td>&nbsp;</td></tr>
					".EMAIL_FOOTER."</table>";
			$subject ="ORANGESCRUM DATABASE ERROR ";
			if(isset($GLOBALS['argv']) || stristr($_SERVER['SERVER_NAME'],"orangescrum.com") || stristr($_SERVER['SERVER_NAME'],"easyagile.us") ) {
				$this->alert_sendemail('',TO_DEV_EMAIL,$subject,$message,"",DEV_EMAIL,'yourmail@yourDomain.com');
			}
			$this->_outputMessage($this->template);
	}
/**
 * @method private alert_sendemail($message) Description
 * @author GDR<support@ornagescrum.com>
 * @return bool true/fals
 */
	function alert_sendemail($from = NULL,$to,$subject,$message,$file = NULL,$cc='',$bcc=''){
		if(!$from) {
			$from = 'Orangescrum<support@ornagescrum.com>';
		}
		$url = 'https://api.sendgrid.com/';
		$user = '';
		$pass = '';
		$filePath = DIR_IMAGES."pdf";
		$params = array(
			'api_user'  => $user,
			'api_key'   => $pass,
			//'to'        => $to,
			'subject'   => $subject,
			'html'      => $message,
			'text'      => '',
			'from'      => $from

			//'files['.$f.']' => '@'.$logfile,
		  );
			if($file){
				$params['files['.$file.']'] = '@'.$filePath.'/'.$file;
			}
			if($cc){
				$params['to[0]'] = $to;
				if(strstr($cc, ',')){
					$cc = explode(',', $cc);
					
					foreach($cc as $key=>$val){
						$params['to['.($key+1).']'] = $val;
					}
				} else {
					$params['to[1]'] = $cc;
				}
			}else{
				$params['to'] = $to;
			}
			if(stristr($_SERVER['SERVER_NAME'],"orangescrum.com")){
				$bcc ="yourmail@yourDomain.com"; 
			} 
			if($bcc){
				$params['to[0]'] = $to;
				if(strstr($bcc, ',')){
					$bcc = explode(',', $bcc);
					foreach($bcc as $k=>$v){
						$params['bcc['.$k.']'] = $v;
					}
				} else {
					$params['bcc'] = $bcc;
				}
			}
			$request =  $url.'api/mail.send.json';
			$session = curl_init($request);
			curl_setopt ($session, CURLOPT_POST, true);
			curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
			curl_setopt($session, CURLOPT_HEADER, false);
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($session);
			curl_close($session);
			return $response;
	}		
}
?>