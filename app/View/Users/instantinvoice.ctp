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
<?php 
	//$avl_discount = $this->ShortLength->discount_avl($no_of_users); ?> 
	<?php $avl_discount = 0; ?> 
	<div style="width:1040px;min-height:500px;margin:50px auto;">
    <div class="fl">
		<div><img src="<?php echo HTTP_ROOT; ?>img/logo/orangescrum-134-40.png"  border="0" alt="Orangescrum.com" title="Orangescrum.com"/></div>
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
			<td><?php //echo $users['Users']['name']." ".$users['Users']['last_name']; ?></td>
        </tr-->
		<!--tr>
        <td><?php //echo $users['Users']['work_phone']; ?></td>
        </tr-->	
		<tr><td><?php echo $users['Users']['email']; ?></td></tr>
        <!--tr>
        <td><?php //echo $companies['Companies']['website']; ?></td>
        </tr-->
        </table>
        </div>
    </div>
    
    <div class="fr" style="width:600px;text-align:right;">
        <h1>INVOICE</h1>
        <table cellpadding="2" align="right" cellspacing="2" style="font-size:16px;width:auto;margin-top:33px;text-align: right;">
        <tr>
        <!--td style="text-align:right">Invoice Date:</td-->
        <td align="right"><font style="font-size: 21px;font-weight: bold;"><?php echo date('F d, Y',strtotime($transactions['Transactions']['created'])); ?></font></td>
        </tr>
        <tr>
        <td  align="right"><b>Invoice #: </b><!--/td>
        <td class="tx_l"--><?php echo $transactions['Transactions']['invoice_id']; ?></td>
        </tr>
        <!--tr>
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
        <tr>
			<th class="tophead" colspan="4">Instant Payment Summary</th>
		</tr>
		 <tr>
        	<th width="20%">Plan Name</th>
            <th width="45%">Description</th>
            <th width="25%">Service Period</th>
            <th width="10%">Total</th>
        </tr>
		<?php 
		$amount = 0;
		//print_r($billing_info);exit;
		$next_billing_date =date('Y-m-d',strtotime($subscriptions['UserSubscriptions']['next_billing_date']));
		$pmonth =date('m',  strtotime('-1 month',strtotime($next_billing_date)));
		$pyear =date('Y',  strtotime('-1 month',strtotime($next_billing_date)));
		$mdays = cal_days_in_month(CAL_GREGORIAN,$pmonth,$pyear);
		?>
		<tr>	
			<td><?php echo $plan_types[$subscriptions['UserSubscriptions']['subscription_id']]; ?></td>
            <td>
				Storage : <?php echo $this->Format->displayStorage($subscriptions['UserSubscriptions']['storage']); ?> 
				Projects : <?php echo $subscriptions['UserSubscriptions']['project_limit']; ?> <Br/>
				Users : <?php echo $subscriptions['UserSubscriptions']['user_limit']; ?> 
				Task Group : <?php echo $subscriptions['UserSubscriptions']['milestone_limit']; ?>
            </td>
            <td><?php echo date('m/d/Y',  (strtotime($subscriptions['UserSubscriptions']['next_billing_date'])-($mdays*24*60*60)));?> to <?php echo date('m/d/Y',  (strtotime($subscriptions['UserSubscriptions']['next_billing_date'])-(24*60*50)));?></td>
            <td>$<?php echo $subscriptions['UserSubscriptions']['price']; ?></td>
		</tr>
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
            <td>Instant payment for cancellation of account</td>            
            <td width="20%">$<?php echo $transactions['Transactions']['amt']; ?></td>
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
                <td align="right">$<?php echo $transactions['Transactions']['amt']; ?></td>
            </tr>
        </table>
    </div>	
	<div class="fl">This charge will appear on your credit card statement as "<a href="http://www.andolasoft.com/">ANDOLASOFT INC</a>".</div>
</div>
</body>
</html>
