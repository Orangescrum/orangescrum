<?php $qls_name = $v['name'];?>
<li>
  <div class="checkbox">
    <label>        
      <input type="checkbox" class="def_s_menu_chkbx_<?php echo $row['SidebarMenu']['id'];?>" id="def_smenu_chkbx_<?php echo $v['id'];?>" checked disabled>
      <span><?php echo __($qls_name,true);?></span>
    </label> 
  </div>
</li>