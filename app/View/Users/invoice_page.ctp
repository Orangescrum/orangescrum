<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INVOICE OS</title>
</head>
<style type="text/css">
.fl{float:left}
.fr{float:right}
.cb{clear:both}
.tx_l{text-align:left;padding-left:15px}
h1{margin:0px}
.charge_tbl th.tophead {
	background:#3B69A4;
    color: #DBDCDA;
    font-size: 18px;
    padding: 5px;
    text-transform: uppercase;
}
.charge_tbl{width:100%;font-size:16px;text-align:center; border:2px solid #000; margin-bottom:35px;border-collapse: collapse;}
.charge_tbl td ,.charge_tbl th{border:2px solid #000}
.charge_tbl th{font-weight:bold; background:#DDDEDD;}
.charge_tbl td {font-size:18px}
.charge_tbl td table tr td{vertical-align:top;}
.brdr{border:none!important}
</style>
<body style="font-family:Arial">
	<?php $avl_discount = 0; ?> 
	<div style="width:1040px;min-height:500px;margin:50px auto;">
    <div class="fl" style="width:600px;">
        <div><img src="<?php echo HTTP_ROOT; ?>img/header/orangescrum-cloud-logo.svg"  border="0" alt="Orangescrum.com" title="Orangescrum.com" style="width:150px;height:80px;"/></div>
        <div>
        <table cellpadding="2" cellspacing="2" style="font-size:17px;margin-top:30px;">
        <tr>
			<td><font style="font-size: 21px;font-weight: bold;">Andolasoft</font></td>
        </tr>
        <tr>
        <td>2059 Camden Ave. #118</td>
        </tr>
        <tr>
        <td>San Jose, CA - 95124, USA</td>
        </tr>
       <!--tr>
        <td><b>(408) 625-7188</b></td>
        </tr-->
	   <tr>
		   <td>&nbsp;</td>
	   </tr>
        <tr>
			<td><b>Product & Sales Enquiry</b></td>
        </tr>
          <tr>
        <td>support&#64;orangescrum&#46;com</td>
        </tr>
        </table>
        </div>
                <div>
        <table cellpadding="2" cellspacing="2" style="font-size:17px;margin-top:30px;">
        <tr>
        <td><b>Subscribed By</b></td>
        </tr>
		<tr>
        <td><?php echo $companies['Companies']['name']; ?></td>
        </tr>
        <!--tr>
        <td>Name: <?php echo $users['Users']['name']." ".$users['Users']['last_name']; ?></td>
        </tr-->
		<!--tr>
        <td><?php //echo $users['Users']['work_phone']; ?></td>
        </tr-->	
		<tr>	
		<td><?php echo $users['Users']['email']; ?></td>
        </tr>
		<?php if(isset($companies['Companies']['billing_detail']) && !empty($companies['Companies']['billing_detail'])){ ?>
		<tr>	
		<td><?php echo $companies['Companies']['billing_detail']; ?></td>
        </tr>
		<?php } ?>
        <!--tr>
        <td><?php //echo $companies['Companies']['website']; ?></td>
        </tr-->
        </table>
        </div>
    </div>
    
    <div class="fr" style="width:435px;text-align:right;">
        <h1>INVOICE</h1>
        <table cellpadding="2" align="right" cellspacing="2" style="font-size:16px;width:auto;margin-top:33px;text-align: right;">
        <tr>
        <!--td style="text-align:right"><b>Invoice Date:</b></td-->
        <td align="right"><font style="font-size: 21px;font-weight: bold;"><?php echo date('F d, Y',strtotime($transactions['Transactions']['created'])); ?></font></td>
        </tr>
        <tr>
			<td style="text-align:right" align="right"><b>Invoice#: </b><!--/td>
        <td class="tx_l"--><?php echo $transactions['Transactions']['invoice_id']; ?></td>
        </tr>
		<!--tr><td>&nbsp;</td></tr>
        <tr>
        <td style="text-align:right">Subscription #:</td>
        <td class="tx_l"><?php //echo $transactions['Transactions']['btsubscription_id']; ?></td>
        </tr>
        <tr>
        <td style="text-align:right">Account #:</td>
        <td class="tx_l"><?php //echo $users['Users']['btprofile_id']; ?></td>
        </tr-->
        </table>
    </div>
    <div class="cb"></div>
    <div style="margin-top:50px;width:1039px">
    	<table cellpadding="0" cellspacing="0" class="charge_tbl">
        <tr><th class="tophead" colspan="4">Subscription Summary</th></tr>
        <tr>
        	<th width="20%">Plan Name</th>
            <th>Description</th>
            <th width="25%">Billing cycle</th>
            <th width="10%">Total</th>
        </tr>
		<?php
		$mdays = 30;
		$total_sub = count($subscriptions);
                $latestData = "";
		foreach ($subscriptions AS $key=>$val){	?>
         <tr>
        	<td>
				<?php 
					$plan_order = Configure::read('PLAN_SMALL_TO_LARGE');
					echo $plan_types[$val['UserSubscriptions']['subscription_id']]; 
					if(($total_sub==($key+1)) && ($total_sub>1)){
						if($plan_order[$val['UserSubscriptions']['subscription_id']] > $plan_order[$subscriptions[$key-1]['UserSubscriptions']['subscription_id']]){
							echo " (Upgraded)";
                                                        $latestData = "Upgraded";
						}else{
							echo " (Downgraded)";
                                                        $latestData = "Downgraded";
						}
					}
				?>
			</td>
            <td>
                    <?php $storage = $this->Format->displayStorage($val['UserSubscriptions']['storage']); ?>
            		Storage : <?php echo ($storage!="")? $storage : "N.A"; ?> 
            		Projects : <?php echo ($val['UserSubscriptions']['project_limit']!="")? $val['UserSubscriptions']['project_limit'] : "N.A"; ?> <br/>
                        Users : <?php echo ($val['UserSubscriptions']['user_limit']!="")? $val['UserSubscriptions']['user_limit'] : "N.A"; ?> 
                        Task Group : <?php echo ($val['UserSubscriptions']['milestone_limit']!="")? $val['UserSubscriptions']['milestone_limit'] : "N.A"; ?>
                </td>
		<?php if($val['UserSubscriptions']['month']==12){?>
			<td><?php echo 'Yearly' ?></td>	
		<?php }else{?>
            <td>
			<?php echo 'Monthly' ?></td>
		<?php } ?>
            <td>$<?php echo ($val['UserSubscriptions']['price']!="")? $val['UserSubscriptions']['price'] : "0.00"; ?></td>
        </tr>
		<?php 
                 //to avoid showing Downgrade/Upgrade section
                if ( ($total_sub>1) && (($key+2)==$total_sub) && (isset($subscriptions[$total_sub-1]['UserSubscriptions']['next_billing_date'])) ) { 
                    break; 
                }
                } ?>
       </table>
        <table cellpadding="0" cellspacing="0" class="charge_tbl">
        <tr><th class="tophead" colspan="5">TRANSACTIONS</th></tr>
        <tr>
        	<th width="13%">Date</th>
            <th>Number</th>
            <th>Type</th>
            <th>Description</th>            
            <th width="20%">Applied Amount</th>
        </tr>
        <tr>
        	<td><?php echo date('m/d/Y',strtotime($transactions['Transactions']['created'])); ?></td>
            <td><?php echo $transactions['Transactions']['transaction_id']; ?></td>
            <td>Sale</td>
            <td><?php echo ($val['UserSubscriptions']['month']==12)?"Yearly":"Monthly";?> Subscription</td>            
            <td width="20%">$<?php echo $transactions['Transactions']['amt']; ?></td>
        </tr>      
        </table>
        <table cellpadding="0" cellspacing="0" class="charge_tbl">
        <tr><th class="tophead" colspan="7">Usage Details</th></tr>
        <tr>
        	<th>Rate Plan Name</th>
            <th>Period</th>
            <th>Allocated Space</th>
            <th>Used Space</th>            
            <th>Billable</th>            
            <th>Rate</th>
            <th>Total</th>
        </tr>
        <tr>
            <?php $used_storage = $this->Casequery->usedSpace('',$subscriptions[$total_sub-1]['UserSubscriptions']['company_id']);?>
        	<td><?php echo $plan_type[$subscriptions[$total_sub-1]['UserSubscriptions']['subscription_id']]; ?></td>
            <td>
			<?php
			if(isset($transactions['Transactions']['usrBilling_start']) && $transactions['Transactions']['usrBilling_start']){
				echo $transactions['Transactions']['usrBilling_start'] .' - '. $transactions['Transactions']['usrBilling_end'];
			}else{
				$next_billing_date = date('Y-m-d',strtotime($subscriptions[$total_sub-1]['UserSubscriptions']['next_billing_date']));
                               if($val['UserSubscriptions']['month']==12){
                                   $pmonth =date('m',  strtotime('-12 month',strtotime($next_billing_date)));
                                   $pyear =date('Y',  strtotime('-12 month',strtotime($next_billing_date)));
                               }else{
				$pmonth =date('m',  strtotime('-1 month',strtotime($next_billing_date)));
				$pyear =date('Y',  strtotime('-1 month',strtotime($next_billing_date)));
                               }
				$mdays = cal_days_in_month(CAL_GREGORIAN,$pmonth,$pyear);
				echo date('m/d/Y',(strtotime($subscriptions[$total_sub-1]['UserSubscriptions']['next_billing_date'])-($mdays*24*60*60))).' - '. date('m/d/Y',(strtotime($subscriptions[$total_sub-1]['UserSubscriptions']['next_billing_date'])-(24*60*60)));
			}
			?>
			</td>
			<td><?php echo $this->Format->displayStorage($subscriptions[$total_sub-1]['UserSubscriptions']['storage']); ?> </td>
            <td><?php echo $this->Format->displayStorage($used_storage);?></td>            
                <td><?php if($used_storage>$subscriptions[$total_sub-1]['UserSubscriptions']['storage']){ echo ($used_storage-$subscriptions[$total_sub-1]['UserSubscription']['storage'])."MB";}else{ echo "0 MB";} ?></td>            
            <td>$0.00</td>
            <td>$0.00</td>
        </tr>      
        </table>
        <b style="font-size:17px">INVOICE TOTAL</b>
        <table class="charge_tbl">
        	<tr>
            	<td rowspan="1"></td>
                <td width="20%">
                	<table align="right">
                    	<tr><td align="right" class="brdr">Subtotal:</td></tr>
                        <tr><td align="right" class="brdr">Discount:</td></tr>
                        <tr><td align="right" class="brdr">Payments:</td></tr>
                    </table>
                </td>
                <td width="20%">
                	<table align="right">
                    	<tr><td align="right" class="brdr">$<?php echo number_format(($transactions['Transactions']['amt']+$transactions['Transactions']['discount']),2,'.',''); ?></td></tr>
                        <tr><td align="right" class="brdr">$<?php  if($transactions['Transactions']['discount']){ echo $transactions['Transactions']['discount'];}else{ echo '0.00';}  ?></td></tr>
                        <tr><td align="right" class="brdr">$<?php echo $transactions['Transactions']['amt']; ?></td></tr>
                    </table>
                </td>
            </tr>
            <tr>
            	<td></td>
                <td align="right">Invoice Balance:</td>
<!--                <td align="right">$<?php //echo $transactions['Transactions']['amt']; ?></td>-->
                <td align="right">$0.00</td>
            </tr>
        </table>
    </div>	
	<div class="fl">This charge will appear on your credit card statement as "<a href="http://www.andolasoft.com/">ANDOLASOFT INC</a>".</div>
</div>
</body>
</html>
