<?php 
echo $this->element('custom_left_menu_new',array('url' =>$url, 'checked_left_menu_submenu'=>$checked_left_menu_submenu,'roleAccess'=>$roleAccess,'page_array'=>$page_array,'left_menu_exist'=>$left_menu_exist,'sub_text_class'=>$sub_text_class,'exp_plan'=>$exp_plan,'cstm_order'=>$cstm_order,'pmethodology'=>$project_methodology_name));
?>
<script>
	<?php if(strtolower($project_methodology_name) != 'scrum'){
		if(in_array(strtolower($project_methodology_name),array('simple','kanban')) ){ ?>
			$('body').find(".kanban-or-board").text('<?php echo __("Kanban");?>');
	<?php }else{?> 
		$('body').find(".kanban-or-board").text('<?php echo __("Board");?>');
	<?php } ?> 
	$('body').find(".hide-in-scrum").show();
	<?php }else{?> 
		$('body').find(".hide-in-scrum").hide();
	<?php  } ?>
</script>