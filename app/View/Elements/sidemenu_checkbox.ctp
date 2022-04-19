<?php $s_checked = '';
if($is_new || in_array($v['id'],$checked_menu_submenu[$row['SidebarMenu']['id']])){
	$s_checked = 'checked="checked"';
}?>
<?php $qls_name = $v['name'];?>
<?php if($qls_name =='Resource Allocation Report'){
	if(SES_TYPE < 3){ ?>
<li>
  <div class="checkbox" id="dv_smenu_<?php echo $v['id'];?>">
    <label class="lbl_smenu_<?php echo $v['id'];?>">        
      <input type="checkbox" class="mnu-chkbx s_menu_chkbx_<?php echo $row['SidebarMenu']['id'];?>" value="<?php echo $v['id'];?>" name="data[UserSidebar][<?php echo $cnt;?>][SidebarMenu][UserSidebarSubmenu][]" id="smenu_chkbx_<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>" data-name="<?php echo __($qls_name,true);?>" <?php echo $s_checked;?>>
      <span><?php echo __($qls_name,true);?></span> 
    </label> 
  </div>
</li>
<?php }}else{ ?>
<li>
  <div class="checkbox" id="dv_smenu_<?php echo $v['id'];?>">
    <label class="lbl_smenu_<?php echo $v['id'];?>">        
      <input type="checkbox" class="mnu-chkbx s_menu_chkbx_<?php echo $row['SidebarMenu']['id'];?>" value="<?php echo $v['id'];?>" name="data[UserSidebar][<?php echo $cnt;?>][SidebarMenu][UserSidebarSubmenu][]" id="smenu_chkbx_<?php echo $v['id'];?>" data-id="<?php echo $v['id'];?>" data-name="<?php echo __($qls_name,true);?>" <?php echo $s_checked;?>>
      <span><?php echo __($qls_name,true);?></span> 
    </label> 
  </div>
</li>
<?php } ?>