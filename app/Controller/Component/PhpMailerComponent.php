<?php 
App::uses('Component', 'Controller');
App::import('Vendor', 'PHPMailer', array('file' => 'PHPMailer' .DS. 'PHPMailerAutoload.php'));

class PhpMailerComponent extends Component {

 	 function sendPhpMailer($from,$to,$subject,$message,$type,$fromname=NULL, $chkpoint=0){
 	 	$this->EmailSetting = ClassRegistry::init('EmailSetting');
 	 	 $email_setting = $this->EmailSetting->find('first',array('conditions'=>array('EmailSetting.is_default'=>1,'EmailSetting.status'=>1,'EmailSetting.company_id'=>SES_COMP)));
         if(!empty($email_setting) && $email_setting['EmailSetting']['is_smtp']==1){
            $password = $email_setting['EmailSetting']['password'];
            $from = !empty($email_setting['EmailSetting']['from_email'])?$email_setting['EmailSetting']['from_email']:$from;
            //Create a new PHPMailer instance
            $mail = new PHPMailer();
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'tex';
            //Set the hostname of the mail server
            $mail->Host = $email_setting['EmailSetting']['host'];
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port =$email_setting['EmailSetting']['port'];
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $mail->Username = $email_setting['EmailSetting']['email'];;
            //Password to use for SMTP authentication
            $mail->Password =  $password ;
            //Set who the message is to be sent from
            $mail->setFrom($from);
            //Set an alternative reply-to address
            $mail->addReplyTo(!empty($email_setting['EmailSetting']['reply_email'])?$email_setting['EmailSetting']['reply_email']:$from);
            //Set who the message is to be sent to
            $mail->addAddress($to);
            //Set the subject line
            $mail->Subject = $subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($message);
            //Replace the plain text body with one created manually
            // $mail->AltBody = 'This is a plain-text message body';
            //Attach an image file
            // $mail->addAttachment('images/phpmailer_mini.png');

            //send the message, check for errors
            if (!$mail->send()) {
                //echo "Mailer Error: " . $mail->ErrorInfo;exit;
                if($chkpoint){
					return "Mailer Error: " . $mail->ErrorInfo;
				}else{
					return true;
				}
            } else {
                // echo "Message Sent!";
                return true;
            }
            // exit;
        }else if(!empty($email_setting) && $email_setting['EmailSetting']['is_smtp']==2){
        	$from = !empty($email_setting['EmailSetting']['from_email'])?$email_setting['EmailSetting']['from_email']:$from;
        	//Create a new PHPMailer instance
			$mail = new PHPMailer();
			// Set PHPMailer to use the sendmail transport
			$mail->isSendmail();
			//Set who the message is to be sent from
			$mail->setFrom($from);
			//Set an alternative reply-to address
			$mail->addReplyTo(!empty($email_setting['EmailSetting']['reply_email'])?$email_setting['EmailSetting']['reply_email']:$from);
			//Set who the message is to be sent to
			$mail->addAddress($to);
			//Set the subject line
			$mail->Subject = $subject;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML($message);
			//Replace the plain text body with one created manually
			// $mail->AltBody = 'This is a plain-text message body';
			//Attach an image file
			// $mail->addAttachment('images/phpmailer_mini.png');

			//send the message, check for errors
			if (!$mail->send()) {
			    // echo "Mailer Error: " . $mail->ErrorInfo;
			    return true;
			} else {
			    // echo "Message sent!";
			     return true;
			}
        } else if(!empty($email_setting) && $email_setting['EmailSetting']['is_smtp']==3){
        	if(defined('FROM_EMAIL') && FROM_EMAIL != ''){
				$from = FROM_EMAIL;
			}else{
				$from = !empty($email_setting['EmailSetting']['from_email'])?$email_setting['EmailSetting']['from_email']:$from;
			}
			if(defined('FROM_EMAIL_EC') && FROM_EMAIL_EC != ''){
				$from_reply = FROM_EMAIL_EC;
			}else{
				$from_reply = !empty($email_setting['EmailSetting']['reply_email'])?$email_setting['EmailSetting']['reply_email']:$from;
			}			
			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			$mail->Host = $email_setting['EmailSetting']['host'];
			$mail->Port = $email_setting['EmailSetting']['port'];
			$mail->SMTPAuth = false;
			$mail->setFrom($from, 'OrangeScrum');
			$mail->addReplyTo($from_reply, 'OrangeScrum');
			$mail->addAddress($to);
			$mail->Subject = $subject;
			$mail->msgHTML($message);
			//$mail->AltBody = 'This is a plain-text message body';
			if (!$mail->send()) {
				if($chkpoint){
					return "Mailer Error: " . $mail->ErrorInfo;
				}else{
					return true;
				}
			} else {
				return true;
			}
        }else{
        	return true;
        }
 	 }

 	 function sendPhpMailerTemplate($email, $chkpoint=0){
 	 	$this->EmailSetting = ClassRegistry::init('EmailSetting');
 	 	$email_setting = $this->EmailSetting->find('first',array('conditions'=>array('EmailSetting.is_default'=>1,'EmailSetting.status'=>1,'EmailSetting.company_id'=>1)));
          if(!empty($email_setting) && $email_setting['EmailSetting']['is_smtp']==1){
            $password =$email_setting['EmailSetting']['password'];
            $from = !empty($email_setting['EmailSetting']['from_email'])?$email_setting['EmailSetting']['from_email']:$email->from;
            //Create a new PHPMailer instance
            $mail = new PHPMailer();
            //Tell PHPMailer to use SMTP
            $mail->isSMTP();
            //Enable SMTP debugging
            // 0 = off (for production use)
            // 1 = client messages
            // 2 = client and server messages
            $mail->SMTPDebug = 0;
            //Ask for HTML-friendly debug output
            $mail->Debugoutput = 'tex';
            //Set the hostname of the mail server
            $mail->Host = $email_setting['EmailSetting']['host'];
            //Set the SMTP port number - likely to be 25, 465 or 587
            $mail->Port =$email_setting['EmailSetting']['port'];
            //Whether to use SMTP authentication
            $mail->SMTPAuth = true;
            //Username to use for SMTP authentication
            $mail->Username = $email_setting['EmailSetting']['email'];;
            //Password to use for SMTP authentication
            $mail->Password =  $password ;
            //Set who the message is to be sent from
            $mail->setFrom($from);
            //Set an alternative reply-to address
            $mail->addReplyTo(!empty($email_setting['EmailSetting']['reply_email'])?$email_setting['EmailSetting']['reply_email']:$from);
            //Set who the message is to be sent to
            $mail->addAddress($email->to);
            //Set the subject line
            $mail->Subject =$email->subject;
            //Read an HTML message body from an external file, convert referenced images to embedded,
            //convert HTML into a basic plain-text alternative body
            $mail->msgHTML($email->set_variables);
			//$mail->msgHTML($message);
            //Replace the plain text body with one created manually
            // $mail->AltBody = 'This is a plain-text message body';
            //Attach an image file
            if(isset($email->attachments)){
				$mail->addAttachment($email->attachments);
			}
            //send the message, check for errors
            if (!$mail->send()) {
                if($chkpoint){
					return "Mailer Error: " . $mail->ErrorInfo;
				}else{
					return true;
				}
            } else {
                // echo "Message Sent!";
                return true;
            }
            // exit;
        }else if(!empty($email_setting) && $email_setting['EmailSetting']['is_smtp']==2){
        	$from = !empty($email_setting['EmailSetting']['from_email'])?$email_setting['EmailSetting']['from_email']:$email->from;
        	//Create a new PHPMailer instance
			$mail = new PHPMailer();
			// Set PHPMailer to use the sendmail transport
			$mail->isSendmail();
			//Set who the message is to be sent from
			$mail->setFrom($from);
			//Set an alternative reply-to address
			$mail->addReplyTo(!empty($email_setting['EmailSetting']['reply_email'])?$email_setting['EmailSetting']['reply_email']:$from);
			//Set who the message is to be sent to
			$mail->addAddress($email->to);
			//Set the subject line
			$mail->Subject =$email->subject;
			//Read an HTML message body from an external file, convert referenced images to embedded,
			//convert HTML into a basic plain-text alternative body
			$mail->msgHTML($email->set_variables);
			//Replace the plain text body with one created manually
			// $mail->AltBody = 'This is a plain-text message body';
			//Attach an image file
			if(isset($email->attachments)){
				$mail->addAttachment($email->attachments);
			}
			//send the message, check for errors
			if (!$mail->send()) {
			    if($chkpoint){
					return "Mailer Error: " . $mail->ErrorInfo;
				}else{
					return true;
				}
			} else {
			    // echo "Message sent!";
			     return true;
			}
        } else if(!empty($email_setting) && $email_setting['EmailSetting']['is_smtp']==3){
        	if(defined('FROM_EMAIL') && FROM_EMAIL != ''){
				$from = FROM_EMAIL;
			}else{
				$from = !empty($email_setting['EmailSetting']['from_email'])?$email_setting['EmailSetting']['from_email']:$from;
			}
			if(defined('FROM_EMAIL_EC') && FROM_EMAIL_EC != ''){
				$from_reply = FROM_EMAIL_EC;
			}else{
				$from_reply = !empty($email_setting['EmailSetting']['reply_email'])?$email_setting['EmailSetting']['reply_email']:$from;
			}
			$mail = new PHPMailer();
			$mail->isSMTP();
			$mail->SMTPDebug = 0;
			$mail->Debugoutput = 'html';
			$mail->Host = $email_setting['EmailSetting']['host'];
			$mail->Port = $email_setting['EmailSetting']['port'];
			$mail->SMTPAuth = false;
			$mail->setFrom($from, 'OrangeScrum');
			$mail->addReplyTo($from_reply, 'OrangeScrum');
			$mail->addAddress($email->to);
			$mail->Subject = $email->subject;
			$mail->msgHTML($email->set_variables);
			//$mail->AltBody = 'This is a plain-text message body';
			//Attach an image file
			if(isset($email->attachments)){
				$mail->addAttachment($email->attachments);
			}			
			if (!$mail->send()) {
				if($chkpoint){
					return "Mailer Error: " . $mail->ErrorInfo;
				}else{
					return true;
				}
			} else {
				return true;
			}
        }else{
        	return true;
        }
 	 }

 	 function encryptPassword($text){ 
        $encrypted = base64_encode($text);
        return $encrypted;
    } 

    function decryptPassword($text){ 
        $key = SALT;
        $data = base64_decode($text);
        return  $decrypted;
    } 
}

?>