<body style="width:100%; margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none; background-color:#ffffff;">
    <table cellpadding="0" cellspacing="0" border="0" id="backgroundTable" style="height:auto !important; margin:0; padding:0; width:100% !important; background-color:#F0F0F0;color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:19px; margin-top:0; padding:0; font-weight:normal;">
        <tr>
            <td>
                <div id="tablewrap" style="width:100% !important; max-width:600px !important; text-align:center; margin:0 auto;">
                    <table id="contenttable" width="600" align="center" cellpadding="0" cellspacing="0" border="0" style="background-color:#FFFFFF; margin:0 auto; text-align:center; border:none; width: 100% !important; max-width:600px !important;border-top:8px solid #5191BD">
                        <tr>
                            <td width="100%">
                                <?php echo NEW_EMAIL_HEADER; ?>
                                <table bgcolor="#FFF" border="0" cellspacing="0" cellpadding="20" width="100%">
                                    <tr>
                                        <td width="100%" bgcolor="#FFF" style="text-align:left;">
                                            <p>
                                             <?php echo __("Hi");?> <?php echo $user_nm ?>,
                                            </p>
                                            <p><?php echo __("Below are the information of the enabled company.");?></p>
                                            <p>
                                                <?php echo __("Company Id:");?> <?php echo $comp_nm; ?><br />
                                                <?php echo __("Owner name & email:");?> <?php echo $user_nm . '(' . $email_nm . ')'; ?><br />
                                                <?php echo __("Customer id:");?> <?php echo ($custo_nm) ? $custo_nm : NA; ?><br />
                                                <?php echo __("Plan:");?> <?php echo $plan_nm; ?><br />
                                                <?php
                                                if ($iscancelled == 1 || $iscancelled == 0) {
                                                    echo 'Subscription cancelled, status was ' . ($isstatus == '') ? Free : $isstatus;
                                                } else {
                                                    echo $iscancelled . ' ' . $isstatus;
                                                }
                                                ?>
                                            </p>								
                                            <table width="80%" align="center" cellpadding="0" cellspacing="0" border="0" style="padding-bottom:30px;padding-top:25px;">
                                                <tr>
                                                    <td align="center">
                                                        <div><a href="https://app.orangescrum.com/users/login" style="background-color:#ffffff;border:1px solid #d4d4d4;border-radius:4px;color:#4f9cde;display:inline-block;font-family:sans-serif;font-size:13px;line-height:40px;text-align:center;text-decoration:none;width:120px" target="_blank">LOGIN</a></div>
                                                    </td>
                                                    <td align="center">
                                                        <div><a href="https://www.orangescrum.com/how-it-works" style="background-color:#ffffff;border:1px solid #d4d4d4;border-radius:4px;color:#4f9cde;display:inline-block;font-family:sans-serif;font-size:13px;line-height:40px;text-align:center;text-decoration:none;width:194px" target="_blank">Or Explore Orangescrum</a></div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p>
                                                <?php echo __("Thanks,");?><br/>
                                                Omkar<br/>
                                                --<br/>
                                                Sr. Manager (Marketing), OrangeScrum.com<br/>
                                                2059 Camden Ave. #118,<br/>
                                                San Jose, CA - 95124, USA<br/>
                                            </p>
                                        </td>
                                    </tr>
                                </table>

                                <table bgcolor="#F0F0F0" border="0" cellspacing="0" cellpadding="10" width="100%" style="border-top:2px solid #F0F0F0;margin-top:10px;border-bottom:3px solid #2489B3">
                                    <tr>
                                        <td width="100%" bgcolor="#ffffff" style="text-align:center;">
                                            <p style="color:#222222; font-family:Arial, Helvetica, sans-serif; font-size:11px; line-height:14px; margin-top:0; padding:0; font-weight:normal;padding-top:5px;">
<?php echo NEW_EMAIL_FOOTER; ?>
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
    </table> 
</body>