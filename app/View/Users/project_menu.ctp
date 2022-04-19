<?php
if (isset($allProjArr) && count($allProjArr)) {
    $gp = 0;
    if (isset($_COOKIE['TASKGROUPBY']) && $_COOKIE['TASKGROUPBY'] == 'milestone') {
        $gp = 1;
      }

    $pageArr = ['reports', 'import', 'chart', 'hours_report', 'glide_chart','defect-severity'];
    #$pageFilterArr = ['files', 'timelog'];
    $pageFilterArr = ['files'];

//    if($page != 'reports' && $page!='import' && $page != 'chart' && $page != 'hours_report' && $page != 'glide_chart' && $pageFilter != 'timelog' && $pageFilter != 'files') 
    if (!in_array($page, $pageArr) && !in_array($pageFilter, $pageFilterArr)) {
        if (isset($this->request->data['popupid']) && $this->request->data['popupid'] != 'projpopup_log') {
            ?>    
            <a class="show_all_opt_in_listonly" style="<?php if ((DEFAULT_TASKVIEW == 'tasks' && $gp != 1)||($this->request->data['page']=='special_mydashoard')) { ?>display:block;<?php } else { ?>display:none;<?php } ?>" href="javascript:jsVoid();" onClick="<?php if ($page == 'activity') { ?>CaseActivity('all', 'All'); <?php } elseif ($page == 'mydashboard') { ?>CaseDashboard('all', 'All'); <?php } elseif ($page == 'milestone') { ?>caseMilestone('all', 'All', 1); <?php } else { ?>updateAllProj('0', '0', '<?php echo $page; ?>', 'all', 'All') <?php } ?>;"><?php echo __('All');?> <?php if(isset($allPjCount['0']['0']['count'])){?>(<?php echo $allPjCount['0']['0']['count']; ?>) <?php } ?></a>
        <?php }
    }  if($this->request->data['page']=='import' && $limit != "all"){?>

<a href="javascript:jsVoid();" class="proj_lnks ttc" onClick="updateAllProj('proj_all', 'all', '<?php echo $page; ?>', '0', '<?php echo  rawurlencode('All');?>')"><?php echo $this->Format->shortLength('All',30); ?> <?php if(isset($allPjCount['0']['0']['count'])){?>(<?php echo $allPjCount['0']['0']['count']; ?>)<?php  } ?></a>
    <?php } if ($this->request->data['page'] == 'mydashboard' && $limit != "all") { ?>
        <a href="javascript:jsVoid();" class="proj_lnks ttc" onClick="CaseDashboard('all', 'All');"><?php echo $this->Format->shortLength('All', 30); ?> <?php if(isset($allPjCount['0']['0']['count'])){?>(<?php echo $allPjCount['0']['0']['count']; ?>)<?php } ?></a>
    <?php } ?>
    <?php
    $i = 0;
    $colrs = "";
    foreach ($allProjArr as $proj) {
        $i++;
        $colrs = "";
        ?>
        <?php  
        if ($this->request->data['popupid'] != 'projpopup_log' && $this->request->data['popupid'] != 'projpopup_subtask' ) {
            if ($page == 'chart' || $page == 'hours_report' || $page == 'glide_chart') {
                ?>
                <?php if ($page == 'chart') { ?>
                    <a href="javascript:jsVoid();" class="proj_lnks ttc" onclick="ReportMenu('<?php echo $proj['p']['uniq_id']; ?>');"><?php echo $this->Format->shortLength(ucfirst($proj['p']['name']), 30); ?></a>
                <?php } else if ($page == 'hours_report') { ?>
                    <a href="javascript:jsVoid();" class="proj_lnks ttc" onclick="hoursreport('<?php echo $proj['p']['uniq_id']; ?>');"><?php echo $this->Format->shortLength(ucfirst($proj['p']['name']), 30); ?></a>
                <?php } else if ($page == 'glide_chart') { ?>
                    <a href="javascript:jsVoid();" class="proj_lnks ttc" onclick="ReportGlideMenu('<?php echo $proj['p']['uniq_id']; ?>');"><?php echo $this->Format->shortLength(ucfirst($proj['p']['name']), 30); ?></a>
                <?php } ?>
            <?php } else if ($page == 'timer') { ?>
                <option value="<?php echo $proj['p']['uniq_id']; ?>"><?php echo $this->Format->shortLength($proj['p']['name'], 25); ?></option>
            <?php } else { ?>
                <a href="javascript:jsVoid();" <?php if ($page == 'mydashboard') { ?>data-proj-name="<?php echo $proj['p']['name']; ?>" data-proj-id="<?php echo $proj['p']['uniq_id']; ?>"<?php } ?> class="proj_lnks ttc <?php if ($page == 'mydashboard') { ?>proj_link_for_invite<?php } ?>" onClick="<?php if ($page == 'activity') { ?>CaseActivity('<?php echo $proj['p']['id']; ?>', '<?php echo rawurlencode($proj['p']['name']); ?>'); <?php } elseif ($page == 'mydashboard') { ?>CaseDashboard('<?php echo $proj['p']['uniq_id']; ?>', '<?php echo rawurlencode($proj['p']['name']); ?>'); <?php } elseif ($page == 'milestone') { ?>caseMilestone('<?php echo $proj['p']['id']; ?>', '<?php echo rawurlencode($proj['p']['name']); ?>', 1); <?php } else { ?>updateAllProj('proj_<?php echo $proj['p']['uniq_id']; ?>', '<?php echo $proj['p']['uniq_id']; ?>', '<?php echo $page; ?>', '0', '<?php echo rawurlencode($proj['p']['name']); ?>','',<?php echo $proj['p']['project_methodology_id']; ?>) <?php } ?>;"><?php echo $this->Format->shortLength(ucfirst($proj['p']['name']), 30); ?> <?php if(isset($proj[0]['count'])){?>(<?php echo $proj['0']['count']; ?>)<?php } ?></a>
            <?php }
        } else {
            if($this->request->data['popupid'] == 'projpopup_subtask'){ ?>
<a href="javascript:jsVoid();" <?php if ($page == 'mydashboard') { ?>data-proj-name="<?php echo $proj['p']['name']; ?>" data-proj-id="<?php echo $proj['p']['uniq_id']; ?>"<?php } ?> class="proj_lnks ttc <?php if ($page == 'mydashboard') { ?>proj_link_for_invite<?php } ?>" onClick="updateAllProj('proj_<?php echo $proj['p']['uniq_id']; ?>', '<?php echo $proj['p']['uniq_id']; ?>', '<?php echo $page; ?>', '0', '<?php echo rawurlencode($proj['p']['name']); ?>','',<?php echo $proj['p']['project_methodology_id']; ?>)"><?php echo $this->Format->shortLength(ucfirst($proj['p']['name']), 30); ?> <?php if(isset($proj[0]['count'])){?>(<?php echo $proj['0']['count']; ?>)<?php } ?></a>
            <?php }else{ ?>
            <a href="javascript:jsVoid();" <?php if ($page == 'mydashboard') { ?>data-proj-name="<?php echo $proj['p']['name']; ?>" data-proj-id="<?php echo $proj['p']['uniq_id']; ?>"<?php } ?> class="proj_lnks ttc <?php if ($page == 'mydashboard') { ?>proj_link_for_invite<?php } ?>" onClick="setProjectid('<?php echo $proj['p']['id']; ?>', '<?php echo rawurlencode($proj['p']['name']); ?>', '<?php echo $proj['p']['uniq_id']; ?>')"><?php echo $this->Format->shortLength(ucfirst($proj['p']['name']), 30); ?> <?php if(isset($proj[0]['count'])){?>(<?php echo $proj['0']['count']; ?>)<?php } ?></a>
        <?php
        }
        }

        if ($i != count($allProjArr)) {
            ?>
            <?php
        }
    }
    ?>	
    <?php if ($page != 'timer') {
        if ($limit != "all" && $countAll > 6) {
            ?>

            <?php if (isset($this->request->data['popupid']) && $this->request->data['popupid'] == 'projpopup_log') { ?>
                <div id="showMenu_case_txt_log">
                    <a href="javascript:jsVoid();" class="proj_lnks more" onClick="displayMenuProjects('<?php echo $page; ?>', 'all');"><?php echo __('more');?>...</a>
                </div>
                <span id="loaderMenu_case_log" style="display:none;">
                    <a href="javascript:jsVoid();" style="text-decoration:none;color:#000000;padding:4px;cursor:wait">Loading...&nbsp;&nbsp;<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="loading..." border="0"/></a>
                </span>
            <?php } else { ?>
                <div id="showMenu_case_txt">
                    <a href="javascript:jsVoid();" class="proj_lnks more" onClick="displayMenuProjects('<?php echo $page; ?>', 'all');"><?php echo __('more');?>...</a>
                </div>
                <span id="loaderMenu_case" style="display:none;">
                    <a href="javascript:jsVoid();" style="text-decoration:none;color:#000000;padding:4px;cursor:wait">Loading...&nbsp;&nbsp;<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="loading..." border="0"/></a>
                </span>
            <?php } ?>

            <?php }
        ?>
        <!-- Add project option start -->
        <?php if ((SES_TYPE == 1 || SES_TYPE == 2) && $this->request->data['popupid'] != 'projpopup_log' && $this->request->data['popupid'] != 'projpopup_subtask') { ?>
            <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
            <div id="newprj_but">
                <a id="newproject" class="proj_lnks col333" href="javascript:jsVoid();" onclick="setSessionStorage('Project Drop Down Menu', 'Create Project'); newProject('newproject', 'loaderprj');">+ <?php echo __('Create Project');?></a>
            </div>
            <a href="javascript:jsVoid()" id="loaderprj" style="text-decoration:none;cursor:wait;display:none;">
                Loading...<img src="<?php echo HTTP_IMAGES; ?>images/del.gif" width="16" height="16" alt="loading..." title="loading..."/>
            </a>
        <?php } ?>
        <?php } ?>
        <!-- Add project option end -->
    <?php }
}
?>
 
