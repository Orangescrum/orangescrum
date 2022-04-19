<span class="dropdown cmn_hover_menu_open">
    <a class="dropdown-toggle active main_page_menu_togl top_main_page_menu_togl" data-toggle="dropdown" href="javascript:void(0);" data-target="#">
        <i id="top_main_togl_nav" class="material-icons">&#xE5C3;</i>
    </a>
    <ul class="dropdown-menu main_page_menu_togl_ul">
       <?php
		//$reov = Configure::read('RESTRICTED_PROJ_OV');
		//if(in_array(SES_COMP,$reov) && SES_TYPE > 2){ ?>
		<?php //}else{ ?>
		<?php //} ?>
        <li>
            <a id="lview_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#tasks'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Task List','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('tasks');">
                <span title="<?php echo __('List View');?>"><i class="material-icons">&#xE896;</i><?php echo __('List');?></span>
            </a>
        </li>
		<?php if($_SESSION['project_methodology'] != 'scrum'){ ?>
            <?php /*if($this->Format->isAllowed('View Milestones',$roleAccess)){ ?> 
        <li><a id="cview_btn" class="" href="javascript:void(0);" onclick="groupby('milestone', event,1);trackEventLeadTracker('Top Bar Navigation','Task Group','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                <span title="<?php echo __('Task Group View');?>"><i class="material-icons">&#xE065;</i><?php echo __('Task Group');?></span>
            </a>
        </li>	
        <?php } */?>	
        <?php
        $kanbanurl = '';
        $kanbanurl = DEFAULT_KANBANVIEW == 'kanban' ? 'kanban' : 'milestonelist';
        ?>
        <?php if($this->Format->isAllowed('View Kanban',$roleAccess)){ ?> 
        <li>
            <a id="kbview_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#' . $kanbanurl; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Kanban','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('<?php echo $kanbanurl; ?>');"><span id="kbview_btn" class="" title="<?php echo __('Kanban View');?>"><i class="material-icons">&#xE8F0;</i><?php echo $this->Format->displayKanbanOrBoard();//__('Kanban');?></span></a>
        </li>	
        <?php } ?>	
		<?php }else{ ?>
		<?php /*<li>
            <a id="backlogview_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#backlog'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Backlog','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('backlog');"><span id="kbview_btn" class="" title="<?php echo __('Backlog View');?>"><i class="material-icons">ballot</i><?php echo __('Backlog');?></span></a>
        </li>
		<li>
            <a id="sprintview_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#' . $kanbanurl; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Sprint','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('sprint');"><span id="kbview_btn" class="" title="<?php echo __('Sprint View');?>"><i class="material-icons">horizontal_split</i><?php echo __('Sprint');?></span></a>
        </li> */ ?>
		<?php } ?>
		<?php if($this->Format->isAllowed('View File',$roleAccess)){ ?> 
        <li><a id="files_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#files'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Files','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('files');"> 
                <span title="<?php echo __('Files');?>"><i class="material-icons">&#xE226;</i><?php echo __('Files');?></span>  	
            </a>
        </li>
    <?php } ?>
        <li>
            <a id="actvt_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#activities'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Activities','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('activities');">
                <span title="<?php echo __('Activities');?>"><i class="material-icons">&#xE922;</i><?php echo __('Activities');?></span>
            </a>
        </li>
        <?php if($this->Format->isAllowed('View Calendar',$roleAccess)){ ?> 
        <li><a id="calendar_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#calendar'; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Calendar','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return calendarView('calendar');">
                <span title="<?php echo __('Calendar');?>"><i class="material-icons">&#xE916;</i><?php echo __('Calendar');?></span>
            </a></li>
        <?php } ?>
        <?php
        $timelogurl = '';
        $timelogurl = DEFAULT_TIMELOGVIEW == 'calendar_timelog' ? 'calendar_timelog' : 'timelog';
        ?>
        <li><a id="timelog_btn" class="" href="<?php echo HTTP_ROOT . 'dashboard#' . $timelogurl; ?>" onclick="trackEventLeadTracker('Top Bar Navigation','Time Log','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');return checkHashLoad('timelog');">
                <span title="<?php echo __('Time Log');?>"><i class="material-icons">&#xE192;</i><?php echo __('Time Log');?></span>	
            </a></li>
    </ul>
</span>