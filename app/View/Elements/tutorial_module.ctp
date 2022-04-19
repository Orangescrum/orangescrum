<?php $parent_slug = @$this->request->params['pass'][0]; ?>
<article class="tutorial_module_list">  
  <div class="moduel_menu">
    <ul class="module_list">
      <li class="list_item">
        <a href="javascript:void(0)" title="Introduction to Project Management" class="item_link toggle_link">
          <span>Introduction to Project Management</span>
          <small>9 Chapters</small>
        </a>
        <div class="chapter_list">
          <ul>
            <li class="chapters_bg1"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/introduction-to-project-management-terminologies" title="Introduction to Project Management terminologies"><span>Introduction to Project Management terminologies</span></a></li>
            <li class="chapters_bg2"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/how-to-kick-start-your-projects-with-project-management-tool" title="How to Kick Start your Projects?"><span>How to Kick Start your Projects?</span></a></li>
            <li class="chapters_bg3"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/project-management-methodologies" title="Project Management Methodologies"><span>Project Management Methodologies</span></a></li>
            <li class="chapters_bg4"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/pmo-and-its-role-in-organization" title="PMO and its role in Organization"><span>PMO and its role in Organization</span></a></li>
            <li class="chapters_bg5"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/project-management-life-cycle" title="Project Management Life Cycle"><span>Project Management Life Cycle</span></a></li>
          </ul>
          <ul>
            <li class="chapters_bg6"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/initiation-in-project-management-life-cycle" title="Initiation in Project Management Life Cycle"><span>Initiation in Project Management Life Cycle</span> </a></li>
            <li class="chapters_bg7"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/planning-in-project-management" title="Planning in Project Management"><span>Planning in Project Management</span></a></li>
            <li class="chapters_bg8"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/planning-in-project-management-part2" title="Planning in Project Management - Part 2"><span>Planning in Project Management - Part 2</span></a></li>
            <li class="chapters_bg9"><a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management/execution-in-project-management " title="Execution in Project Management "><span>Execution in Project Management</span> </a></li>
          </ul>
          <div class="cb"></div>
        </div>
      </li>
      <li class="list_item">
        <a href="javascript:void(0)" title="Real World Elements of Project Management" class="item_link toggle_link">
          <span>Real World Elements of Project Management</span>
          <small>6 Chapters</small>
        </a>
        <div class="chapter_list">
          <ul>
            <li class="chapters_bg1"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/scope-creep-and-its-impact-on-project-delivery" title="Introduction to Project Management terminologies"><span>Introduction to Project Management terminologies</span></a></li>        
            <li class="chapters_bg2">
              <a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/communication-your-antidote-to-project-stress" title="Communication - Your Antidote to Project Stress!"><span>Communication - Your Antidote to Project Stress!</span></a>
            </li>
            <li class="chapters_bg3"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/project-manager-the-dos-and-do-nots" title="Project Manager - The Dos & Don'ts!"><span>Project Manager - The Dos & Don'ts!</span></a></li>
          </ul>
          <ul>
            <li class="chapters_bg4"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/budgeting-and-cost-control" title="Budgeting & Cost Control"><span>Budgeting & Cost Control</span></a></li>     
            <li class="chapters_bg5"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/smart-goal-setting-and-project-planning" title="SMART Goal Setting & Project Planning"><span>SMART Goal Setting & Project Planning</span></a></li>
            <li class="chapters_bg6"><a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management/project-management-reporting-and-metrics" title="Project Management Reporting & Metrics"><span>Project Management Reporting & Metrics</span></a></li>
          </ul>
          <div class="cb"></div>
        </div>
      </li>
      <li class="list_item">
        <a href="javascript:void(0)" title="Real World Elements of Project Management" class="item_link toggle_link">
          <span>Agile Scrum Management - An overview</span>
          <small>2 Chapters</small>
        </a>
        <div class="chapter_list">
          <ul>
            <li class="chapters_bg1"><a href="<?php echo HTTP_ROOT;?>tutorial/agile-scrum-management-an-overview/introduction-to-scrum-methodology" title="Introduction to Scrum Methodology"><span>Introduction to Scrum Methodology</span></a></li> 
          </ul>
			<ul>
				<li class="chapters_bg2"><a href="<?php echo HTTP_ROOT;?>tutorial/agile-scrum-management-an-overview/understanding-the-scrum-team-and-scrum-roles" title="Understanding the Scrum Team and Scrum Roles"><span>Understanding the Scrum Team and Scrum Roles</span></a></li>
			</ul>
			<div class="cb"></div>
        </div>
      </li>
			 <li class="list_item active">
        <a href="javascript:void(0)" title="Real World Elements of Project Management" class="item_link toggle_link">
          <span>Google Task Overview</span>
          <small>1 Chapters</small>
        </a>
        <div class="chapter_list" style="display:block">
          <ul>
            <li class="chapters_bg1"><a href="<?php echo HTTP_ROOT;?>tutorial/task-management/google-tasks-guide-to-task-management" title="A Detailed Google Tasks Guide to Make Task Management Easier"><span>A Detailed Google Tasks Guide to Make Task Management Easier</span></a></li> 
          </ul>
					<div class="cb"></div>
        </div>
      </li>
    </ul>
  </div>
</article>
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
</script>