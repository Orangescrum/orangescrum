<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INVOICE OS</title>
</head>
<body>
<?php //ob_start(); ?>
<?php //header("Content-type:application/pdf");  ?>
<style>  
    .listInfo td{padding:3px 10px;  color: rgb(34, 34, 34); font-size: 13px; font-weight: normal;}
    .pdfGrid{width:100%; font-family:'Helvetica'; border-collapse: collapse;border-spacing: 0; margin: 50px 0 50px 0 }
    .pdfGrid th {background-color: rgb(206, 216, 225);border-top: 1px solid rgb(204, 204, 204);color: rgb(34, 34, 34);font-size: 13px; font-weight: normal;padding: 10px 0 8px 10px;text-align: left;}
    .pdfGrid td {border: 1px solid rgb(204, 204, 204);padding: 8px 0 8px 10px; color: rgb(34, 34, 34); font-size: 13px; font-weight: normal;}
    p{ font-size: 13px; font-weight: normal;font-family:'Helvetica';}
    .listbold{font-weight:bold !important;}
</style>

<?php $grandTotal = 0; ?>
<div class="timelog-detail-tbl">  
    <table cellspacing="0" style="width: 100%; text-align: center; font-size: 14px; font-family:'Helvetica' ">
        <tr>
            <td style="width: 70%; text-align: left;">
                <?php if ($i['Invoice']['logo'] != '' && file_exists(WWW_ROOT . 'invoice-logo/' . $i['Invoice']['logo'])) { ?>          
                    <img src="<?php echo HTTP_ROOT . 'invoice-logo/' . $i['Invoice']['logo']; ?>" style="max-height:100px;" />
                <?php } else { ?>
                    <img src="<?php echo HTTP_IMAGES; ?>default-invoice-logo.png" style="max-height:100px;" />
                <?php } ?>
            </td>

            <td style="width: 30%; text-align: right;">
                <h1 style="line-height:100px; font-family:'Helvetica'; font-size:23px;"><?php echo __('Invoice');?></h1>
            </td>
        </tr>
        <tr>
            <td style="width: 50%; text-align: left;">
                <?php if (!empty($i['Invoice']['invoice_from'])) { ?>
                    <p>  <?php echo nl2br($i['Invoice']['invoice_from']); ?> </p>
                <?php } ?>

                <label style="font-weight:bold;font-size:16px;margin: 10px 0 0; font-family: 'Helvetica'"><?php echo __('Bill To');?></label><br/>
                <?php if (!empty($i['Invoice']['invoice_to'])) { ?>
                    <p><?php echo nl2br($i['Invoice']['invoice_to']); ?></p>               
                <?php } ?> 
            </td>
            <td style="width: 50%; text-align: right;">
                <table cellspacing="0" class='listInfo' style='float:right;'>
                    <tr><td class="listbold"><?php echo __('Invoice');?># : </td><td style="text-align:left;"><?php print $i['Invoice']['invoice_no']; ?></td></tr>
                    <tr><td class="listbold"><?php echo __('Invoice Date');?> : </td><td style="text-align:left;"><?php echo date('M d,Y', strtotime($i['Invoice']['issue_date'])); ?></td></tr>
                    <tr><td class="listbold"><?php echo __('Due Date');?> : </td><td style="text-align:left;"><?php echo date('M d,Y', strtotime($i['Invoice']['due_date'])); ?> </td></tr>
                </table>
            </td>
        </tr>
    </table>   
    <table cellpadding="3" cellspacing="4" class='pdfGrid'>
        <tr>
            <th><?php echo __('Description');?></th> 
            <th><?php echo __('Hours');?></th>
            <th><?php echo __('Rate');?></th>
            <th><?php echo __('Amount');?></th>                            
        </tr>
        <?php if (!empty($i['InvoiceLog'])) { ?>
            <?php foreach ($i['InvoiceLog'] as $log) { ?>
                <tr id="row<?php echo $log['id']; ?>">                        
                    <td> <?php echo $log['description']; ?> </td>                        
                    <td> <?php echo $log['total_hours']; ?> </td>
                    <td><?php
                        if ($log['rate'] != '') {
                            echo $log['rate'];
                        } else {
                            echo $i['Invoice']['price'];
                        }
                        ?>
                    </td>

                    <td style="text-align:right; padding-right:10px;"> <?php
                        $grandTotal += $log['total_hours'] * $log['rate'];
                        print number_format($log['total_hours'] * $log['rate'], 2, '.', '');
                        ?>
                    </td>
                </tr>
    <?php } ?>
            <tr>
                <td colspan="3" style="text-align:right; padding-right:10px;" > Subtotal</td>
                <td style="text-align:right; padding-right:10px;"><?php print number_format($grandTotal, 2, '.', ''); ?></td>                                    
            </tr>
              <?php if ($i['Invoice']['discount'] > 0) { ?>
                <tr>
                    <td colspan="3" style="text-align:right; padding-right:10px;" > Discount </td>
                    <td style="text-align:right; padding-right:10px;">
                        <?php
                        $discount = number_format(($grandTotal * $i['Invoice']['discount']) / 100, 2, '.', '');
                        print $discount;
                        ?>
                    </td>                                    
                </tr>
            <?php } ?>
                    <?php if ($i['Invoice']['tax'] > 0) { ?>
                <tr>
                    <td colspan="3" style="text-align:right; padding-right:10px;" > Tax </td>
                    <td style="text-align:right; padding-right:10px;"><?php
                $tax = number_format(($grandTotal * $i['Invoice']['tax']) / 100, 2, '.', '');
                print $tax;
                ?></td>                                    
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" style="text-align:right; padding-right:10px; " > Total Amount</td>
                <td style="text-align:right; padding-right:10px;"><?php print number_format(($grandTotal -$discount + $tax), 2, '.', ''); ?></td>                                    
            </tr>
        <?php } else { ?>
            <tr>
                <td colspan="10"><?php echo __('No records');?>......</td>
            </tr>
<?php } ?>
    </table>

    <div style='text-align:left;'>
        <label style="font-weight:bold;font-size:16px;margin: 10px 0 0; font-family: 'Helvetica'" ><?php echo __('Note');?></label><br />
        <p><?php echo nl2br($i['Invoice']['notes']); ?></p>
    </div>

    <div style='text-align:left;'>
        <label style="font-weight:bold;font-size:16px;margin: 10px 0 0; font-family: 'Helvetica'" ><?php echo __('Terms');?></label><br />
        <p> <?php echo nl2br($i['Invoice']['terms']); ?> </p>
    </div>
</div>
<?php //
//$content = ob_get_clean();
//print $content;exit;
//App::import('Vendor', 'Html2Pdf', array('file' => 'Html2Pdf/html2pdf.class.php'));
//$html2pdf = new HTML2PDF('P', 'A4', 'fr');
//$html2pdf->setDefaultFont('helvetica');
//$html2pdf->WriteHTML($content);
//$html2pdf->Output(APP . WEBROOT_DIR . DS . 'invoice' . DS . 'invoice-' . $i['Invoice']['id'] . '.pdf', 'F');
//print 1;
//exit;
?>
</body>
</html>