  <ul role="tablist" class="nav nav-tabs" id="myTabs" ng-if="to_dos.extra != 'overview'">
        <li class="active tab_li anchor"  role="presentation">
        <a aria-expanded="true" aria-controls="home" data-toggle="tab" role="tab" id="overdue-tab" onclick="toggleOUTasks('overdue_tasks');"><i class="material-icons">&#xE001;</i><?php echo __('Overdue');?></a>
        </li>
        <li class="tab_li anchor"  role="presentation">
    <a aria-controls="profile" data-toggle="tab" id="upcoming-tab" role="tab" onclick="toggleOUTasks('upcomming_tasks');"><i class="material-icons">&#xE89C;</i><?php echo __('Upcoming');?></a>
        </li>
</ul>
<div ng-if="to_dos.gettodos.length > 0 || to_dos.get_od_todos.length > 0" ng-cloak>
    <table id="overdue_tasks" class="table table-striped table-hover" ng-if="to_dos.get_od_todos.length > 0 ">        
         <tr ng-repeat="(key,value) in to_dos.get_od_todos">
            <td class="td-1st"><p>                
                <a ng-if="to_dos.extra != 'overview'" href="<?php echo HTTP_ROOT; ?>dashboard/?project={{value.Project.uniq_id}}" title="{{ value.Project.name}}" style="color:#5191BD" ng-cloak>{{value.Project.short_name}}</a> - 
                <a href="javascript:void(0);" data-hrf="<?php echo HTTP_ROOT; ?>dashboard#details/{{value.Easycase.uniq_id}}" title="{{value.Easycase.title}}" ng-click="switchtaskwithProject($event);" data-pid="{{value.Easycase.uniq_id}}" ng-cloak class="max_width_tsk_title ellipsis-view">#{{ value.Easycase.case_no}}: {{value.Easycase.title}}</a>
	   </td> 
            <td class="td-2nd"><span class="prio_{{osCommonMethods.priArr(value.Easycase.priority)}} prio_lmh prio_gen" rel="tooltip" title="<?php echo __('Priority');?>: {{osCommonMethods.priArr(value.Easycase.priority)}}"></span></td>
            <td class="td-3rd">
                <div class="progress m-btm0" rel="tooltip" title="{{value.Easycase.completed_task}}% <?php echo __('Completed');?>">
                  <div class="progress-bar progress-bar-info" style="width:{{value.Easycase.completed_task}}%"></div>
                </div>
            </td>
        </tr>  
    </table>
    <div id="overdue_tasks" class="no-task-txt" ng-if="to_dos.get_od_todos.length <= 0 "><p><?php echo __('No overdue task');?></p></div>
    <table id="upcomming_tasks" class="table table-striped table-hover" style="display:none;" ng-if="to_dos.gettodos.length > 0 ">
         <tr ng-repeat="(key,value) in to_dos.gettodos">
            <td class="td-1st"><p>                
                <a ng-if="to_dos.extra != 'overview'" href="<?php echo HTTP_ROOT; ?>dashboard/?project={{value.Project.uniq_id}}" title="{{value.Project.name}}" style="color:#5191BD" ng-cloak>{{value.Project.short_name}}</a> - 
                <a href="javascript:void(0);" data-hrf="<?php echo HTTP_ROOT; ?>dashboard#details/{{value.Easycase.uniq_id}}" title="{{value.Easycase.title}}" ng-click="switchtaskwithProject($event);" data-pid="{{value.Easycase.uniq_id}}" ng-cloak class="max_width_tsk_title ellipsis-view">#{{ value.Easycase.case_no}}: {{value.Easycase.title}}</a>
	   </td>
            <td class="td-2nd"><span class="prio_{{osCommonMethods.priArr(value.Easycase.priority)}} prio_lmh prio_gen" rel="tooltip" title="<?php echo __('Priority');?>: {{osCommonMethods.priArr(value.Easycase.priority)}}"></span></td>
            <td class="td-3rd">
                <div class="progress m-btm0" rel="tooltip" title="{{value.Easycase.completed_task}}% <?php echo __('Completed');?>">
                  <div class="progress-bar progress-bar-info" style="width:{{value.Easycase.completed_task}}%"></div>
                </div>
            </td>
        </tr>  
    </table>
    <div id="upcomming_tasks" class="no-task-txt" style="display:none;" ng-if="to_dos.gettodos.length <= 0 "><p><?php echo __('No upcoming task');?></p></div>
     <div id="to_dos_more" data-value="{{to_dos.total}}" style="display: none;"></div>
</div>
<div ng-if="to_dos.gettodos.length <= 0 && to_dos.get_od_todos.length <= 0">
    <div  ng-if="to_dos.extra == 'overview'">
         <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
     <div class="mytask" onclick="setSessionStorage('To Do Overview Page', 'Create Task');creatask();" style="float:left;margin:40px 0 0 10px;"></div>
 <?php } ?>
     <div class="mytask_txt" style="float:right;margin:50px 40px 0 0;color:#EAC5C5"><?php echo __("Great Job. You don't have any overdue task");?></div>
     <div id="to_dos_more" data-value="0" style="display: none;"></div>
    </div>
    <div  ng-if="to_dos.extra != 'overview'">
     <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
        <div class="mytask" onclick="setSessionStorage('To Do Dashboard Page', 'Create Task');creatask();"></div>
        <div class="mytask_txt"><a onclick="setSessionStorage('To Do Dashboard Page', 'Create Task');creatask();" href="javascript:void(0);"><?php echo __('Create');?></a> <?php if(SES_TYPE <3){ ?><?php echo __('or');?> <a href="'.HTTP_ROOT.'import-export" ><?php echo __('Import');?></a><?php } ?> <?php echo __('Task');?></div>
    <?php } ?>
        <div id="to_dos_more" data-value="0" style="display: none;"></div>
    </div>
</div>
<input type="hidden" value="{{to_dos.Od_total}}" id="only_overdue_count" />

