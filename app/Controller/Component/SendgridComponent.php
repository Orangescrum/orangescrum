<?php
App::import('Component', 'Email');
class SendgridComponent extends EmailComponent
{
	public $components = array('Session','Email', 'Cookie','Format','PhpMailer');
	public $tls = array('smtp.office365.com');
	function sendGridEmail($from,$to,$subject,$message,$type,$fromname=NULL, $chkpoint=0)
	{
		App::import('helper', 'Format');
		$frmtHlpr = new FormatHelper(new View(null));
	
		$to = $frmtHlpr->emailText($to);
		$subject = $frmtHlpr->emailText($subject);
		$message = $frmtHlpr->emailText($message);
	
		$message = str_replace("<script>","&lt;script&gt;",$message);
		$message = str_replace("</script>","&lt;/script&gt;",$message);
		$message = str_replace("<SCRIPT>","&lt;script&gt;",$message);
		$message = str_replace("</SCRIPT>","&lt;/script&gt;",$message);
		$message = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $message);
		if(defined("PHPMAILER") && PHPMAILER == 1){
            $this->PhpMailer->sendPhpMailer($from,$to,$subject,$message,$type,$fromname, $chkpoint);
        }else{
		$this->Email->delivery = EMAIL_DELIVERY;
		$this->Email->to = $to;
		$this->Email->replyTo = $from;
		$this->Email->subject = $subject;
		if(trim($fromname)) {
			$this->Email->from = $fromname."<".$from.">";
		}
		else {
			$this->Email->from = $from;
		}
		$this->Email->sendAs = 'html';

		if(defined('SMTP_UNAME') && defined('SMTP_PWORD') && SMTP_PWORD !== "******") {
			$email_array = array(
				'port' => SMTP_PORT,
				'host' => SMTP_HOST,
				'timeout'=>'30', 
				'client' => WEB_DOMAIN
			);
			$email_array['username'] = SMTP_UNAME;
			$email_array['password'] = SMTP_PWORD;
			if (in_array(SMTP_HOST, $this->tls)) {
                $email_array['tls'] = true;
            }
		}
		else {
			$email_array = array(
				'port' => SMTP_PORT,
				'host'=> SMTP_HOST
			);
		}
		$this->Email->smtpOptions = $email_array;
			try{
		$response = $this->Email->send($message);
				$response = true;
			} catch (Exception $e) {
				if($chkpoint){
					return $e->getMessage();
				}else{
					$response = true;
				}
			}
		return $response;
	}	
	}	
	function sendgridsmtp($email, $chkpoint=0){
		$email->replyTo = FROM_EMAIL;
		$email->delivery = EMAIL_DELIVERY;
		if(defined('SMTP_UNAME') && defined('SMTP_PWORD') && SMTP_PWORD !== "******") {
			$email_array = array(
				'port' => SMTP_PORT,
				'host' => SMTP_HOST,
				'timeout'=>'30', 
				'client' => WEB_DOMAIN
			);
			$email_array['username'] = SMTP_UNAME;
			$email_array['password'] = SMTP_PWORD;
			if (in_array(SMTP_HOST, $this->tls)) {
                $email_array['tls'] = true;
            }
		}
		else {
			$email_array = array(
				'port' => SMTP_PORT,
				'host'=> SMTP_HOST
			);
		}
		$email->smtpOptions = $email_array;
		//$response = $email->send();
		try{
		$response = $email->send();
			$response = true;
		} catch (Exception $e) {
            if($chkpoint){
				return $e->getMessage();
			}else{
				$response = true;
			}
        }
		return $response;
	}	
	function sendEmail($from,$to,$subject,$message,$type)
	{
		App::import('helper', 'Format');
		$frmtHlpr = new FormatHelper(new View(null));
		
		$to = $frmtHlpr->emailText($to);
		$subject = $frmtHlpr->emailText($subject);
		$message = $frmtHlpr->emailText($message);
		
		$message = str_replace("<script>","&lt;script&gt;",$message);
		$message = str_replace("</script>","&lt;/script&gt;",$message);
		$message = str_replace("<SCRIPT>","&lt;script&gt;",$message);
		$message = str_replace("</SCRIPT>","&lt;/script&gt;",$message);
		$message = preg_replace('/[^(\x20-\x7F)\x0A]*/','', $message);
		
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers.= 'From:' .$from."\r\n";

		if(mail($to,$subject,$message,$headers)) {
			return true;
		}
	}	
		
}
?>