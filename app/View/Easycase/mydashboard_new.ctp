<style>
.slide_rht_con{padding-left:12px;padding-top:4px;}
#wrapper{padding:0 0 17px 165px}
.cmpl_gblue{height:42px;margin: 0px;padding:8px 0 8px 22px;text-align: center;float: left;color:#fff; position: relative;}

.cmpl_gblue:after, .cmpl_gblue:before {left:103%;top: 50%;border: solid transparent;content: " ";height: 0;width: 0;position: absolute;
pointer-events: none; z-index:9999;}
.cmpl_gblue:after {border-width: 21px;margin-top: -21px;}
.cmpl_gblue:before {border-width: 21px;margin-top: -21px;}

.cmpl_gblue.task_one_g:after, .cmpl_gblue.task_one_g:before{left:100.5%;}
.cmpl_gblue.task_four_g:after, .cmpl_gblue.task_four_g:before{left:107%;}
.cmpl_gblue.task_one_g{position: relative;background: #AE432E;border: 4px solid #AE432E;}
.cmpl_gblue.task_one_g:after {border-color: rgba(174, 67, 46, 0);border-left-color: #AE432E;}
.cmpl_gblue.task_one_g:before {border-color: rgba(174, 67, 46, 0);border-left-color: #AE432E;}

.cmpl_gblue.task_two_g{position: relative;background: #244F7A;border: 4px solid #244F7A;}
.cmpl_gblue.task_two_g:after {border-color: rgba(36, 79, 122, 0);border-left-color: #244F7A;}
.cmpl_gblue.task_two_g:before {border-color: rgba(36, 79, 122, 0);border-left-color: #244F7A;}

.cmpl_gblue.task_three_g{position: relative;background:#EF6807;border: 4px solid #EF6807;}
.cmpl_gblue.task_three_g:after {border-color: rgba(239, 104, 7, 0);border-left-color:#EF6807;}
.cmpl_gblue.task_three_g:before {border-color: rgba(239, 104, 7, 0);border-left-color:#EF6807;}

.cmpl_gblue.task_four_g{position: relative;background:#77AB13;border: 4px solid #77AB13;}
.cmpl_gblue.task_four_g:after {border-color: rgba(119, 171, 19, 0);border-left-color:#77AB13;}
.cmpl_gblue.task_four_g:before {border-color: rgba(119, 171, 19, 0);border-left-color:#77AB13;}

</style>
<div class="fl wd-l-con">
<div class="left-board" id="my_left-board" <?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1){ ?> style="display:block" <?php }else{ ?> style="display:none;" <?php } ?>>
  <h4>Explore the power of Orangescrum</h4>
  <ul>
    <li><a href="javascript:void(0);" id="intro-to-video"><span><img src="<?php echo HTTP_IMAGES; ?>images/i-collaborate.png" title="Collaborate"/></span> <span><?php echo __('How to');?><br/><?php echo __('Collaborate');?></span></a></li>
    <li><a href="/task-type" target="_blank"><span><img src="<?php echo HTTP_IMAGES; ?>images/i-custom.png" title="Custom"/></span> <?php echo __('How to');?><br/><?php echo __('Customize Task');?></a></li>
    <li><a href="/tour/respond" style="margin-right:0px;"  target="_blank"><span><img src="<?php echo HTTP_IMAGES; ?>images/i-use.png" title="Use"/></span> <?php echo __('How to use');?><br/><?php echo __('on the go');?></a></li>
  </ul>
  <div class="cb"></div>
</div>
<div class="task-status" id="my_task-status" <?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1){ ?> style="display:none;" <?php }else{ ?> style="display:none;margin-top:35px;" <?php } ?>>
  <h5><?php echo __('Task Status');?></h5>
  <div class="status-bar">
    <div id="new_task_proj" class="cmpl_gblue task_one_g" rel="tooltip" ></div> 
    <div id="wip_task_proj" class="cmpl_gblue task_two_g" rel="tooltip" ></div> 
    <div id="resolved_task_proj" class="cmpl_gblue task_three_g" rel="tooltip" ></div>
    <div id="closed_task_proj" class="cmpl_gblue task_four_g" rel="tooltip" ></div>
  </div>
    <div class="cb"></div>
  <div class="color-hint">
  <ul>
    <li><span class="wd new-red"></span><span><?php echo __('New');?></span></li>
    <li><span class="wd progress-blue"></span><span><?php echo __('In Progress');?></span></li>
    <li><span class="wd resolved-org"></span><span><?php echo __('Resolved');?></span></li>
    <li><span class="wd closed-green"></span><span><?php echo __('Closed');?></span></li>
  </ul>
  <div class="cb"></div>
  </div>

</div>
<ul class="sortable" id="ul_mydashboard">
    <?php 
    foreach ($dashboard_order as $key => $value) {
	?>
	<?php if($value['name']=="To Dos") { ?>
    <li class="sortable-li" id="list_<?php echo $value['id'];?>">
	<div class="sort_li_inner">
	    <div class="dshbd-hed">
		<div class="fl"><?php echo $value['name'];?></div>
		<div class="fr active_icn portlet-header">
		    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="<?php echo __('Move');?>"/>
		</div>
         <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
		<div class="fr active_icn">
			<a href="javascript:void(0);" onclick="setSessionStorage('Dashboard User Page', 'Create Task');creatask()" class="" style="color:#5191BD; font-size:13px;" rel="tooltip" title="<?php echo __('Create Task');?>">
				<i id="ctask_icons" class="icon-create-tsk"></i>
			</a>
		</div>
    <?php } ?>
		<div class="cb"></div>
	    </div>
	    <div class="htdb custom_scroll">
			<div class="loader_dv_db" id="to_dos_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
			<div class="dboard_cont" id="to_dos"></div>
		</div>
	    <div class="fr moredb" id="more_to_dos"><a href="javascript:void(0);" onclick="showTasks('my');"><?php echo __('View All');?> <span id="todos_cnt" style="display:none;">(0)</span></a></div>
	</div>
    </li>
    <?php } elseif($value['name']=="Recent Projects") { ?>
    <li class="sortable-li" id="list_<?php echo $value['id'];?>" style="<?php if(PROJ_UNIQ_ID!='all'){ ?>display:none<?php } ?>">
	<div class="sort_li_inner">
	    <div class="dshbd-hed">
		<div class="fl"><?php echo $value['name'];?></div>
		<div class="fr active_icn portlet-header">
		    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="<?php echo __('Move');?>"/>
		</div>
        <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
		<div class="fr active_icn">
			<a href="javascript:void(0);" onclick="newProject()" class="" style="color:#5191BD; font-size:13px;" rel="tooltip" title="<?php echo __('Create Project');?>">
				<i class="icon-create-projj"></i>
			</a>
		</div>
    <?php } ?>
		<div class="cb"></div>
	    </div>
	    <div class="htdb custom_scroll">
			<div class="loader_dv_db" id="recent_projects_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
			<div class="dboard_cont" id="recent_projects"></div>
		</div>
	    <div class="fr moredb" id="more_recent_projects"><a href="javascript:void(0);" onclick="showTasks('all');"><?php echo __('View All');?> <span id="todos_cnt" style="display:none;">(0)</span></a></div>
	</div>
    </li>
    <?php } elseif($value['name']=="Recent Activities") { ?>
    <!--<li class="sortable-li" id="list_<?php echo $value['id'];?>">
        <div class="sort_li_inner">
            <div class="dshbd-hed">
                <div class="fl"><?php echo $value['name'];?></div>
                <div class="fr active_icn portlet-header">
                    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="Move"/>
                </div>
				<div class="fr active_icn">
					<a href="javascript:void(0);" onclick="newUser()" class="" style="color:#5191BD; font-size:13px;" rel="tooltip" title="Invite User">
						<i class="icon-invt-user"></i>
					</a>
				</div>
                <div class="cb"></div>
            </div>
	    	<div class="htdb custom_scroll">
				<div class="loader_dv_db" id="recent_activities_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
				<div class="dboard_cont" id="recent_activities"></div>
			</div>
		<div class="fr moredb" id="more_recent_activities"><a href="javascript:void(0);" onclick="showTasks('activities');">View All <span id="todos_cnt" style="display:none;">(0)</span></a></div>
        </div>
    </li>-->
    <?php } elseif($value['name']=="Recent Milestones") { ?>
    <li class="sortable-li " id="list_<?php echo $value['id'];?>">
        <div class="sort_li_inner">
            <div class="dshbd-hed">
                <div class="fl"><?php echo $value['name'];?></div>
                <div class="fr active_icn portlet-header">
                    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="<?php echo __('Move');?>"/>
                </div>
                <div class="cb"></div>
            </div>
	    	<div class="htdb custom_scroll">
				<div class="loader_dv_db" id="recent_milestones_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
				<div class="dboard_cont" id="recent_milestones"></div>
			</div>
            
        </div>
    </li>
    <?php } elseif($value['name']=="Statistics") { ?>
    <li class="sortable-li" id="list_<?php echo $value['id'];?>">
        <div class="sort_li_inner">
	<div class="dshbd-hed">
                <div class="fl"><?php echo __('Summary');?></div>
                <div class="fr active_icn portlet-header">
                    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="<?php echo __('Move');?>"/>
                </div>
                <div class="cb"></div>
            </div> 
            <div id="statistics" class="dboard_cont"></div>
            <div class="loader_dv_db" id="statistics_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
        </div>
    </li>
    <?php } elseif($value['name']=="Usage Details") { ?>    
    <!--<li class="sortable-li" id="list_<?php echo $value['id'];?>">
        <div class="sort_li_inner">
            <div class="dshbd-hed">
                <div class="fl"><?php echo $value['name'];?></div>
                <div class="fr active_icn portlet-header">
                    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="Move"/>
                </div>
                <div class="cb"></div>
            </div> 
            <div id="usage_details" class="dboard_cont"></div>
            <div class="loader_dv_db" id="usage_details_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
        </div>
    </li>-->
    <?php } elseif($value['name']=="Task Progress") { ?>    
    <li class="sortable-li" id="list_<?php echo $value['id'];?>">
        <div class="sort_li_inner">
            <div class="dshbd-hed">
                <div class="fl"><?php echo $value['name'];?></div>
				<div class="fl pichart_msg" id="task_progress_msg"></div>
                <div class="fr active_icn portlet-header">
                    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="<?php echo __('Move');?>"/>
                </div>
                <div class="cb"></div>
            </div> 
			<div id="task_progress" class="dboard_cont"></div>
            <div class="loader_dv_db" id="task_progress_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
        </div>
    </li>
    <?php } elseif($value['name']=="Task Types") { ?>    
    <li class="sortable-li" id="list_<?php echo $value['id']; ?>">
	<div class="sort_li_inner">
	    <div class="dshbd-hed">
		<div class="fl">
		    <?php //echo $value['name']; ?>
		    <select id="sel_task_types" style="background: #FFF;width: 140px;border: 1px solid #999;" onchange="showTaskStatus(this, '<?php echo PROJ_UNIQ_ID;?>');">
		    <?php foreach ($task_type as $key => $value) { ?>
			<option value="<?php echo $value['Type']['id']; ?>" <?php if (isset($_COOKIE['TASK_TYPE_IN_DASHBOARD']) && $_COOKIE['TASK_TYPE_IN_DASHBOARD']==$value['Type']['id']){echo "selected='selected'";}?>><?php echo $value['Type']['name']; ?></option>
		    <?php }?>
		    </select>
		</div>
		<div class="fl pichart_msg" id="task_types_msg" style="font-size: 15px;"></div>
		<div class="fr active_icn portlet-header">
		    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="<?php echo __('Move');?>"/>
		</div>
		<div class="cb"></div>
	    </div> 
	    <div id="task_types" class="dboard_cont"></div>
	    <div class="loader_dv_db" id="task_types_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="<?php echo __('Loading');?>..." title="<?php echo __('Loading');?>..." /></center></div>
	</div>
    </li>
    <li class="sortable-li" id="list_pie_chart" style="<?php if(PROJ_UNIQ_ID!='all'){ ?>display:none<?php } ?>">
        <div class="sort_li_inner">
            <div class="dshbd-hed">
                <div class="fl"><?php echo 'Task Types';?></div>
		<div class="fl pichart_msg" id="task_status_msg"></div>
                <div class="fr active_icn portlet-header">
		    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="<?php echo __('Move');?>"/>
		</div>
                <div class="cb"></div>
            </div>
	    <div id="task_status_pie" class="dboard_cont"></div>
            <div class="loader_dv_db" id="task_status_ldr_pie" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
        </div>
    </li>
    <?php } elseif($value['name']=="Task Status") { ?>    
    <!--<li class="sortable-li" id="list_<?php echo $value['id'];?>">
        <div class="sort_li_inner">
            <div class="dshbd-hed">
                <div class="fl"><?php echo $value['name'];?></div>
				<div class="fl pichart_msg" id="task_status_msg"></div>
                <div class="fr active_icn portlet-header">
                    <img style="position:relative;top:3px;" src="<?php echo HTTP_IMAGES; ?>images/move-dboard.png" rel="tooltip" title="Move"/>
                </div>
                <div class="cb"></div>
            </div>
			<div id="task_status" class="dboard_cont"></div>
            <div class="loader_dv_db" id="task_status_ldr" style="display: none;margin-top: 90px;"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
        </div>
    </li>-->
    <?php }
    }
    ?>
</ul>
</div>
<div class="right-board fl">
<div class="working-btn">
  <ul>
    <?php if($this->Format->isAllowed('Add New User',$roleAccess)){ ?>
    <li <?php if(SES_TYPE == 1 || SES_TYPE == 2 || IS_MODERATOR == 1){ ?> style="display:block" <?php }else{ ?> style="display:none;" <?php } ?>><a href="javascript:void(0);" onclick="newUser()" class="i-collaborate"><span><img src="<?php echo HTTP_IMAGES; ?>images/i-invite.png" title="Add New User"/></span> <span id="invt_mor_user"><?php echo __('Add New User');?></span></a></li>
<?php } ?>
    <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
    <li><a href="javascript:void(0);" onclick="newProject();" class="i-use"><span><img src="<?php echo HTTP_IMAGES; ?>images/i-projct.png" title="Project"/></span> <span id="cret_anthor_proj"><?php echo __('Create Project');?></span></a></li>
<?php } ?>
<?php if($this->Format->isAllowed('Create Milestone',$roleAccess)){ ?>
    <li><a href="javascript:void(0);" onclick = "setSessionStorage('Dashboard User Page','Create Task Group');addEditMilestone(this,'','','','','dashboard');" class="i-custom"><span><img src="<?php echo HTTP_IMAGES; ?>images/i-milestone.png" title="Milestone"/></span> <span id="cret_fst_milestone"><?php echo __('Create Milestone');?></span></a></li>
<?php } ?>
  </ul>
  <div class="cb"></div>
  <div class="all-activities">
    <h5><?php echo __('Activity');?></h5>
    <div id="new_recent_activities"></div>
    <!--<div class="activ-content">
      <div class="fl img-round-active">
        <img src="<?php echo HTTP_IMAGES; ?>images/act-img.png"/>
        <br/>
        <div class="">Anna</div>
      </div>
      <div class="fl con-width">
        <span class="arow-for-img"><img src="<?php echo HTTP_IMAGES; ?>images/arrow-active-img.png"/></span>
        <span class="fl" style="color:#ae432e">Created</span>
        <span class="fr" style="color:#aaaaaa">Today 9:05 am</span>
        <div class="cb" style="height:5px;"></div>
        <span class="case-no">
          #518: task status (new,resolved) 
        </span>
        <div class="cb"></div>
        <span class="pro-no">Orangescrum</span>
      </div>
      <div class="cb"></div>
    </div>-->
  </div>
</div>
</div>
<div class="cb"></div>

<script type="text/javascript">
    var DASHBOARD_ORDER = <?php echo json_encode($GLOBALS['DASHBOARD_ORDER']); ?>;
    $(document).ready(function() {
	loadDashboardPage('<?php echo PROJ_UNIQ_ID;?>');
    });
</script>
