<?php $parent_slug = @$this->request->params['pass'][0];?>
<?php $sub_parent_slug = @$this->request->params['pass'][1];?>
<aside class="left_module_panel">  
	<div class="guide_home"><a href="<?php echo HTTP_ROOT;?>tutorial" title="Guide Home"><span></span>Guide Home</a></div>
  <div class="moduel_menu">
    <ul class="module_list">
      <li class="list_item <?php if($parent_slug == 'introduction-to-project-management'){ ?>active<?php } ?>">
        <a href="javascript:void(0)" title="Introduction to Project Management" class="item_link toggle_link">
          <span>Introduction to Project Management</span>
          <small>9 Chapters</small>
        </a>
        <ul class="chapter_list" <?php if($parent_slug == 'introduction-to-project-management'){ ?>style="display:block"<?php } ?>>
          <li class="chapters_bg1 <?php if($sub_parent_slug == 'introduction-to-project-management-terminologies'){ ?>active<?php } ?>">
		  <a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/introduction-to-project-management-terminologies" title="Introduction to Project Management terminologies">Intro to Project Mgtm. Terms</a></li>
          <li class="chapters_bg2 <?php if($sub_parent_slug == 'how-to-kick-start-your-projects-with-project-management-tool'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/how-to-kick-start-your-projects-with-project-management-tool" title="How to Kick Start your Projects?">How to Kick Start your Projects?</a></li>
          <li class="chapters_bg3 <?php if($sub_parent_slug == 'project-management-methodologies'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/project-management-methodologies" title="Project Management Methodologies">Project Management Methodologies</a></li>
          <li class="chapters_bg4 <?php if($sub_parent_slug == 'pmo-and-its-role-in-organization'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/pmo-and-its-role-in-organization" title="PMO and its role in Organization">PMO and its role in Organization</a></li>
          <li class="chapters_bg5 <?php if($sub_parent_slug == 'project-management-life-cycle'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/project-management-life-cycle" title="Project Management Life Cycle">Project Management Life Cycle</a></li>
          <li class="chapters_bg6 <?php if($sub_parent_slug == 'initiation-in-project-management-life-cycle'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/initiation-in-project-management-life-cycle" title="Initiation in Project Management Life Cycle">Initiation in Project Management Life Cycle </a></li>
          <li class="chapters_bg7 <?php if($sub_parent_slug == 'planning-in-project-management'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/planning-in-project-management" title="Planning in Project Management">Planning in Project Management</a></li>
          <li class="chapters_bg8 <?php if($sub_parent_slug == 'planning-in-project-management-part2'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/planning-in-project-management-part2" title="Planning in Project Management - Part 2">Planning in Project Management - Part 2</a></li>
          <li class="chapters_bg9 <?php if($sub_parent_slug == 'execution-in-project-management'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/execution-in-project-management" title="Execution in Project Management ">Execution in Project Management </a></li>
        </ul>
      </li>
      <li class="list_item <?php if($parent_slug == 'real-world-element-of-project-management'){ ?>active<?php } ?>">
        <a href="javascript:void(0)" title="Real World Elements of Project Management" class="item_link toggle_link">
          <span>Real World Elements of Project Management</span>
          <small>6 Chapters</small>
        </a>
        <ul class="chapter_list" <?php if($parent_slug == 'real-world-element-of-project-management'){ ?>style="display:block"<?php } ?> >
          <li class="chapters_bg1 <?php if($sub_parent_slug == 'scope-creep-and-its-impact-on-project-delivery'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/scope-creep-and-its-impact-on-project-delivery" title="Introduction to Project Management terminologies">Scope & Its Impact on Project Dlvy.</a></li>
          <li class="chapters_bg2 <?php if($sub_parent_slug == 'communication-your-antidote-to-project-stress'){ ?>active<?php } ?>">
            <a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/communication-your-antidote-to-project-stress" title="Communication - Your Antidote to Project Stress!">Communication - Your Antidote Stress!</a>
          </li>
          <li class="chapters_bg3 <?php if($sub_parent_slug == 'project-manager-the-dos-and-do-nots'){ ?>active<?php } ?>">
            <a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/project-manager-the-dos-and-do-nots" title="Project Manager - The Dos & Don'ts!">Project Manager - The Dos & Don'ts!</a>
          </li>
          <li class="chapters_bg4 <?php if($sub_parent_slug == 'budgeting-and-cost-control'){ ?>active<?php } ?>">
            <a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/budgeting-and-cost-control" title="Budgeting & Cost Control">Budgeting & Cost Control</a>
          </li>
          <li class="chapters_bg5 <?php if($sub_parent_slug == 'smart-goal-setting-and-project-planning'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/smart-goal-setting-and-project-planning" title="SMART Goal Setting & Project Planning"><span>SMART Goal Setting & Project Planning</span></a></li>
          <li class="chapters_bg6 <?php if($sub_parent_slug == 'project-management-reporting-and-metrics'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/project-management-reporting-and-metrics" title="Project Management Reporting & Metrics"><span>Project Management Reporting & Metrics</span></a></li>
        </ul>
      </li>
      <li class="list_item <?php if($parent_slug == 'agile-scrum-management-an-overview'){ ?>active<?php } ?>">
        <a href="javascript:void(0)" title="Real World Elements of Project Management" class="item_link toggle_link">
          <span>Agile Scrum Management - An overview</span>
          <small>2 Chapters</small>
        </a>
        <ul class="chapter_list" <?php if($parent_slug == 'agile-scrum-management-an-overview'){ ?>style="display:block"<?php } ?> >
          <li class="chapters_bg1 <?php if($sub_parent_slug == 'introduction-to-scrum-methodology'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/agile-scrum-management-an-overview/introduction-to-scrum-methodology" title="Introduction to Scrum Methodology">Introduction to Scrum Methodology</a></li>
		  <li class="chapters_bg2 <?php if($sub_parent_slug == 'understanding-the-scrum-team-and-scrum-roles'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/agile-scrum-management-an-overview/understanding-the-scrum-team-and-scrum-roles" title="Understanding the Scrum Team and Scrum Roles">Understanding the Scrum Team and Scrum Roles</a></li>
        </ul>
      </li>
			<li class="list_item <?php if($parent_slug == 'task-management'){ ?>active<?php } ?>">
        <a href="javascript:void(0)" title="Real World Elements of Project Management" class="item_link toggle_link">
          <span>Google Task Overview</span>
          <small>1 Chapters</small>
        </a>
        <ul class="chapter_list" <?php if($parent_slug == 'task-management'){ ?>style="display:block"<?php } ?> >
          <li class="chapters_bg1 <?php if($sub_parent_slug == 'google-tasks-guide-to-task-management'){ ?>active<?php } ?>"><a href="<?php echo HTTP_ROOT;?>tutorial/task-management/google-tasks-guide-to-task-management" title="A Detailed Google Tasks Guide to Make Task Management Easier">A Detailed Google Tasks Guide to Make Task Management Easier</a></li>
        </ul>
      </li>
    </ul>
  </div>
</aside>
<script type="text/javascript">
  $(document).ready(function () {
    $('.toggle_link').click(function(){     
      var $list = $(this);
      $('.chapter_list').not($(this).next()).slideUp(100);
      $('.chapter_list').not($(this).next()).closest('.list_item').removeClass('active');
        $(this).next().slideToggle(100,function(){
           if (!$list.closest('.list_item').hasClass('active')){
            $list.closest('.list_item').addClass('active');
          }else{
            $list.closest('.list_item').removeClass('active');
          }
        });
        
    });
  });
  $(window).scroll(function(){
    if ($(window).scrollTop() >= 300) {
		$('.left_module_panel').css('top', '15px');
    }
    else {
        $('.left_module_panel').css('top', '165px');
    }
});
</script>