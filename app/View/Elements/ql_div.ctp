<?php $checked = 'checked="checked"';
if(!in_array($v['id'], $checked_ql)){
	$checked = '';
}
if(empty($checked_ql)){
	$checked = 'checked="checked"';
}?>
<?php $l_prefix = str_replace('_', '', LANG_PREFIX); ?>
<?php $qls_name = !empty($l_prefix) ? $v['MenuLanguage'][$l_prefix] : $v['name'];?>
<div class="qlk_chld_check" id="dv_smenu_<?php echo $v['id'];?>">
  <div class="checkbox">
    <label class="lbl_smenu_<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>">
      <input type="checkbox" class="semenu s_menu_chkbx_<?php echo $value['QuicklinkMenu']['id'];?>" value="<?php echo $v['id'];?>" name="data[UserQuicklink][<?php echo $value['QuicklinkMenu']['id'];?>][QuicklinkMenu][QuicklinkSubmenu][]" id="smenu_chkbx_<?php echo $v['id'];?>" <?php echo $checked;?>>
      <span class="" rel="tooltip" title="<?php echo $qls_name;?>"><?php echo $sub_menu_icon;?> <?php if(!empty($double_icon)){echo "<span class='d-icon'>";}?><?php echo $qls_name;?><?php if(!empty($double_icon)){echo "</span>";}?></span>
    </label>
  </div>
</div>