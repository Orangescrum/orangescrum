<input type="hidden" name="data[UserSidebar][<?php echo $cnt;?>][SidebarMenu][user_id]" value="<?php echo SES_ID;?>">
<input type="hidden" name="data[UserSidebar][<?php echo $cnt;?>][SidebarMenu][company_id]" value="<?php echo SES_COMP;?>">
<div class="menu_catagories">
  <div class="checkbox parent_check"> 
    <label>        
      <input type="checkbox" name="data[UserSidebar][<?php echo $cnt;?>][SidebarMenu][id]" data-id="<?php echo $row['SidebarMenu']['id'];?>" id="menu_chkbx_all_<?php echo $row['SidebarMenu']['id'];?>" value="<?php echo $row['SidebarMenu']['id'];?>" <?php echo $checked;?> class="mnu-chkbx semenu" data-name="<?php echo __($menu_name,true);?>">
      <span><?php echo __($menu_name,true);?></span>
    </label> 
  </div>
  <ul>
  	<?php #if($row['SidebarMenu']['name'] == "Time Log"){ ?>
  	<?php #} ?>
    <?php foreach ($row['SidebarSubmenu'] as $k => $v) { 
					if($lowered_name == "resource utilization" && $row['SidebarMenu']['name'] =='Time Log'){
						continue;
					}
					if($lowered_name == "weekly timesheet" && $row['SidebarMenu']['name'] =='Time Log'){
						continue;
					}
				?>
        <?php $lowered_name = strtolower($v['name']);?>
        <?php $smenu_el_arr = array("cnt"=>$cnt,"row" => $row,"v" => $v,"checked_menu_submenu" => $checked_menu_submenu); ?>
        <?php if($lowered_name == "resource utilization"){ ?>
        	<?php if($row['SidebarMenu']['name'] == "Resource Mgmt"){ ?>
	            <?php if ($this->Format->isAllowed('View Resource Utilization',$roleAccess)) { ?>
	                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
	            <?php } ?>
            <?php }else{ ?>
            	<?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "resource availability"){ ?>
            <?php if ($this->Format->isAllowed('View Resource Availability',$roleAccess)) { ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "files"){ ?>
            <?php if ($this->Format->isAllowed('View File',$roleAccess)) { ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "invoices"){ ?>
            <?php if ($this->Format->isAllowed('View Invoices',$roleAccess)){ ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "weekly usage"){ ?>
            <?php if(SES_TYPE <= 2){ ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "resource utilization"){ ?>
            <?php if(SES_TYPE <= 2){ ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "pending tasks"){ ?>
            <?php if(SES_TYPE <= 2){ ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "daily catch-up"){ ?>
            <?php if ($this->Format->isAllowed('View Daily Catchup',$roleAccess)) { ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "all tasks"){ ?>
            <?php if ($this->Format->isAllowed('View All Task',$roleAccess)) { ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }elseif($lowered_name == "create project"){ ?>
            <?php if ($this->Format->isAllowed('Create Project',$roleAccess)) { ?>
                <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
            <?php } ?>
        <?php }else{ ?>
            <?php echo $this->element('sidemenu_checkbox', $smenu_el_arr); ?>
        <?php } ?>
    <?php } ?>
  </ul>
</div>