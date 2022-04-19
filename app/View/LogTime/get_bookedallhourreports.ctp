<style type="text/css">
    #pop-up-booked-rsrc{width:100%;}
    #pop-up-booked-rsrc > thead > tr > th, #pop-up-booked-rsrc > tbody > tr > td{border-bottom: 1px solid #ebeff2;}
    #pop-up-booked-rsrc > tbody > tr:last-child{border:0px;}
    #pop-up-booked-rsrc > thead > tr > th,#pop-up-booked-rsrc > tbody > tr > td , #pop-up-booked-rsrc > tbody > tr > td span{font-size: 14px;}
    #pop-up-booked-rsrc > tbody > tr > td{padding:10px 0;}
    .red-sqr{height: 15px;width: 15px;margin-right: 4px;vertical-align: -1px;display: inline-block;background: #FF3A46;}
    .pink-sqr{height: 15px;width: 15px;margin-right: 4px;vertical-align: -1px;display: inline-block;background: #7C6AFF;}
    .popup_title{padding: 20px 10px 0px 25px;height: inherit;}
    .ovrld-txt{cursor: pointer;color:#006699;text-decoration: underline;font-size:15px}
</style>
<div style="width:100%;padding: 0px 0px 0px; font-size:13px;">
    <?php if(count($data_arr['booked_rsrs']) > 0){ ?>
		<div style="float:left;display:inline-block">
			<h4 style="position:relative;top:-30px;">
				<?php echo __('User');?>: <?php echo $data_arr['user'];?>
			</h4>
		</div>
	<?php } ?>
	<?php /*?><div style="float:right;display:inline-block">
		<div class="pink-sqr"></div>
		<span <?php if(!empty($total_overload)){ ?>class="ovrld-txt" onclick="showOverloaddet(this);" <?php } ?> data-userid="<?php echo $data_arr['userId'];?>" data-date="<?php echo $data_arr['date'];?>" rel="tooltip" original-title="<?php echo __('View details');?>"><?php echo __('Overload');?> <?php echo number_format((float)($total_overload / 3600), 2, '.', '');?> <?php echo __('Hr');?>
		</span>
	</div><?php */?>
<div style="clear:both"></div>
</div>
<table id="pop-up-booked-rsrc" cellspacing='15' cellpadding='15'>
    <thead>
        <tr>
            <th style="width:15%;"><?php echo __('Date');?></th>
			<th style="width:20%;"><?php echo __('Project');?></th>
            <th style="width:10%;"><?php echo __('Task #');?></th>
            <th style="width:35%;"><?php echo __('Title');?></th>
            <th style="width:10%;"><?php echo __('Assigned Hours');?></th>
			<th style="width:10%;"><?php echo __('Hours Overload');?></th>
        </tr>
    </thead>
    <tbody>
        <?php 
		if(count($data_arr['booked_rsrs']) > 0){
			foreach ($data_arr['booked_rsrs'] as $k => $val) { ?>
            <tr>
			<td><?php echo $val['datevalue'];?></td>
            <td>
            <?php $leng_over = strlen($val['project']) > 15 ? true : false;?>
            <span <?php echo ($leng_over) ? 'rel="tooltip" original-title="'.$val['project'].'"' : "";?>><?php echo $this->Text->truncate($val['project'],15,array('ellipsis' => '..','exact' => true));?></span>
            </td>
            <td>#<?php echo $val['case_no'];?></td>
            <td>
            <?php $task_leng_over = strlen($val['case_title']) > 15 ? true : false;?>
            <span <?php echo ($leng_over) ? 'rel="tooltip" original-title="'.$val['case_title'].'"' : "";?>><?php echo $this->Text->truncate($val['case_title'],15,array('ellipsis' => '..','exact' => true));?></span>
            </td>
            <td style="color:red;">
				<?php if($val['hours_booked']){ ?>
					<div class="red-sqr"></div><?php echo $val['hours_booked'] ? number_format((float)$val['hours_booked'], 2, '.', '') . ' Hr' : '';?>
				<?php } ?>
			</td>
			<td style="color:#7C6AFF;">
				<?php if($val['hours_overload']){ ?>
					<div class="pink-sqr"></div><?php echo $val['hours_overload'] ? number_format((float)$val['hours_overload'], 2, '.', '') . ' Hr' : '';?>
				<?php } ?>
			</td>
            </tr>
        <?php } }else{ ?>
			<tr>
				<td colspan="6" align="center">This Resource is available from <b><?php echo $data_start_date; ?></b> to <b><?php echo $data_end_date; ?></b> !</td>
			</tr>
		<?php } ?>
    </tbody>
</table>