<style type="text/css">
    #pop-up-booked-rsrc{width:100%;}
    #pop-up-booked-rsrc > thead > tr > th, #pop-up-booked-rsrc > tbody > tr > td{border-bottom: 1px solid #ebeff2;}
    #pop-up-booked-rsrc > tbody > tr:last-child{border:0px;}
    #pop-up-booked-rsrc > thead > tr > th,#pop-up-booked-rsrc > tbody > tr > td , #pop-up-booked-rsrc > tbody > tr > td span{font-size: 14px;}
    #pop-up-booked-rsrc > tbody > tr > td{padding:10px 0;}
    .red-sqr{height: 15px;width: 15px;margin-right: 4px;vertical-align: -1px;display: inline-block;background: #FF3A46;}
    .pink-sqr{height: 15px;width: 15px;margin-right: 4px;vertical-align: -1px;display: inline-block;background: #7C6AFF;}
    .popup_title{padding: 20px 10px 0px 25px;height: inherit;}
    .ovrld-txt{cursor: pointer;color:#006699;text-decoration: underline;;font-size:15px}
</style>
<div style="width:100%;padding: 0px 0px 0px; font-size:13px;">
    <div style="float:left;display:inline-block"><h4 style="position:relative;top:-30px;"><?php echo __('User');?>: <?php echo $data_arr['user'];?></h4></div>

<div style="clear:both"></div>
</div>
<table id="pop-up-booked-rsrc" cellspacing='15' cellpadding='15'>
    <thead>
        <tr>
            <th style="width:25%;"><?php echo __('Project');?></th>
            <th style="width:15%;"><?php echo __('Task #');?></th>
            <th style="width:40%;"><?php echo __('Title');?></th>
            <th style="width:20%;"><?php echo __('Assigned Hours');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data_arr['booked_rsrs'] as $k => $val) { ?>
            <tr>
            <td>
            <?php $leng_over = strlen($val['project']) > 15 ? true : false;?>
            <span <?php echo ($leng_over) ? 'rel="tooltip" original-title="'.$val['project'].'"' : "";?>><?php echo $this->Text->truncate($val['project'],15,array('ellipsis' => '..','exact' => true));?></span>
            </td>
            <td>#<?php echo $val['case_no'];?></td>
            <td>
            <?php $task_leng_over = strlen($val['case_title']) > 15 ? true : false;?>
            <span id="Ratsk_title_1" style="cursor:pointer" <?php echo ($leng_over) ? 'rel="tooltip" original-title="'.$val['case_title'].'"' : "";?>  data-task="<?php echo $val['uniq_id'];?>" ><?php echo $this->Text->truncate($val['case_title'],15,array('ellipsis' => '..','exact' => true));?></span> <?php //onclick="easycase.ajaxCaseDetails('<?php echo $val['uniq_id'];','case',0,'popup');" ?>
            </td>
            <td style="color:red;"><div class="red-sqr"></div><?php echo number_format((float)$val['hours_booked'], 2, '.', '');?> Hr</td>
            </tr>
        <?php } ?>
    </tbody>
</table>