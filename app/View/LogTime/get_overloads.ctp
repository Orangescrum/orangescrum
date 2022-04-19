<style type="text/css">
#pop-up-booked-ovlrod{width:100%;}
#pop-up-booked-ovlrod > thead > tr > th, #pop-up-booked-ovlrod > tbody > tr > td{border-bottom: 1px solid #ebeff2;}
#pop-up-booked-ovlrod > thead > tr > th,#pop-up-booked-ovlrod > tbody > tr > td ,#pop-up-booked-ovlrod > tbody > tr > td span{font-size: 14px;}
#pop-up-booked-ovlrod > tbody > tr > td{padding:10px 0;}
#pop-up-booked-ovlrod > tbody > tr:last-child{border:0px;}
.pink-sqr{height: 15px;
width: 15px;
margin-right: 4px;
vertical-align: -1px;
display: inline-block;
background: #7C6AFF;}
.popup_title{padding: 20px 10px 0px 25px;height: inherit;}
</style>
<div style="float:left;display:inline-block;padding-bottom:10px;padding-top:10px"><div class="pink-sqr"></div><span <?php if(!empty($overload_time)){ ?>class="ovrld-txt" onclick="showOverloaddet(this);" <?php } ?> data-userid="<?php echo $data_arr['userId'];?>" data-date="<?php echo $data_arr['date'];?>" rel="tooltip" original-title="<?php echo __('View details');?>"><?php echo __('Overload');?> <?php echo $overload_time;?> <?php echo __('Hr');?></span></div>
<?php if(!empty($over_data)){ ?>		
<table id="pop-up-booked-ovlrod" cellspacing='15' cellpadding='15' style="margin-top:30px;">
    <thead>
        <tr>
            <th style="width:25%;"><?php echo __('Project');?></th>
            <th style="width:15%;"><?php echo __('Task #');?></th>
            <th style="width:40%;"><?php echo __('Title');?></th>
            <th style="width:20%;"><?php echo __('Overload Hours');?></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($over_data['overload_rsrs'] as $k => $val) { ?>
            <tr>
            <td>
            <?php $leng_over = strlen($val['project']) > 15 ? true : false;?>
            <span <?php echo ($leng_over) ? 'rel="tooltip" original-title="'.$val['project'].'"' : "";?>><?php echo $this->Text->truncate($val['project'],15,array('ellipsis' => '..','exact' => true));?></span>
            </td>
            <td>#<?php echo $val['case_no'];?></td>
            <td>
            <?php $task_leng_over = strlen($val['case_title']) > 15 ? true : false;?>
            <span id="Ratsk_title_2" style="cursor:pointer"  data-task="<?php echo $val['uniq_id'];?>" <?php echo ($leng_over) ? 'rel="tooltip" original-title="'.$val['case_title'].'"' : "";?>><?php echo $this->Text->truncate($val['case_title'],15,array('ellipsis' => '..','exact' => true));?></span> <?php //onclick="easycase.ajaxCaseDetails('<?php echo $val['uniq_id'];','case',0,'popup');" ?>
            </td>
            <td style="color:red;"><div class="red-sqr"></div><?php echo number_format((float)$val['hours_overload'], 2, '.', '');?> <?php echo __('Hr');?></td>
            </tr>
        <?php } ?>

	<!--	<tr>
			<td style="border:none;" colspan="4"><a href="javascript:void(0);" onclick="closePopupOv()"><?php echo __('Back');?></a></td>
		</tr>  -->
    </tbody>
</table>
<br/>
  <div class="modal-footer">					
	<div class="fr popup-btn">
		<span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
	</div>
</div>
<?php }else{ ?>
<br/>
  <div class="modal-footer">					
	<div class="fr popup-btn">
		<span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
	</div>
		 <div class="fr popup-btn">
		<span class="cancel-link"><button type="button" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" data-dismiss="modal" onclick="creatask();"><?php echo __('Create Task');?></button></span>
	</div>
</div>

<?php } ?>
<input type="hidden" value="<?php echo $date;?>" id="ovrld-date"/>
<input type="hidden" value="<?php echo $over_data['userId'];?>" id="ovrld-user"/>