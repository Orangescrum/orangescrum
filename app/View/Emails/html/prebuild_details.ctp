<body style="width:100%; margin:0; padding:22px; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#ffffff;">
    <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="height:auto !important; margin:0; padding:0; width:100% !important; background-color:#F0F0F0;color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;">
        <tr>
            <td>
                Customer Name:
            </td>
            <td>
                <?php echo $data['customer_name']?>
            </td>
        </tr>
        <tr>
            <td>
                Customer Email:
            </td>
            <td>
                <?php echo $data['customer_email']?>
            </td>
        </tr>
        <tr>
            <td>
                Preferred Date:
            </td>
            <td>
                <?php echo $data['peffered_date']?>
            </td>
        </tr>
        <tr>
            <td>
                Preferred Time:
            </td>
            <td>
                <?php echo $data['peffered_time']?>
            </td>
            
        </tr>
        <tr>
            <td>
                Timezone:
            </td>
            <td>
                <?php echo $data['Timezone_name']?>
            </td>
        </tr>
        <tr>
            <td>
                Indian Time:
            </td>
            <td>
                <?php echo $data['indian_time']?>
            </td>
        </tr> 
        <tr>
            <td>
                Type Of Hosting:
            </td>
            <td>
                <?php echo $data['hosting_type']?>
            </td>
        </tr>
        <tr>
            <td>
                Operating System:
            </td>
            <td>
                <?php echo $data['user_operating_system']?>
            </td>
        </tr>
        <tr>
            <td>
                PHP Version:
            </td>
            <td>
                <?php echo $data['php_version']?>
            </td>
        </tr>
        <tr>
            <td>
                Access Type:
            </td>
            <td>
                <?php echo $data['access_type']?>
            </td>
        </tr>
        <tr>
            <td>
                Company Name(URL):
            </td>
            <td>
                <?php echo $data['url_name']?>
            </td>
        </tr>
        <tr>
            <td>
                Login Email:
            </td>
            <td>
                <?php echo $data['login_email']?>
            </td>
        </tr>
        <tr>
            <td>
                Password:
            </td>
            <td>
                <?php echo $data['login_password']?>
            </td>
        </tr>
        <tr>
            <td>
                Mail Server:
            </td>
            <td>
                <?php echo $data['mailserver_type']?>
            </td>
        </tr>
        <tr>
            <td>
                Gmail and dropbox credential:
            </td>
            <td>
                <?php echo $data['mail_dropbox_credential']?>
            </td>
        </tr>
            
            
        
    </table>
</body>