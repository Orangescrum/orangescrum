<div class="listdv summary_row">
    <div class="fl stas_icn stas_red" ng-if="statistics.statistics[0].task_without_due_date.task_without_due_date" ng-cloak>{{statistics.statistics[0].task_without_due_date.task_without_due_date}}</div>
    <div class="fl stas_icn stas_red" ng-if="!statistics.statistics[0].task_without_due_date.task_without_due_date">0</div>
    <div class="fl stas_cnt_db"><?php echo __('Task without Due Date');?></div>
    <div class="cb"></div>
</div>

<div class="lstbtndv"></div>
<div class="listdv summary_row">
    <div class="fl stas_icn stas_green" ng-if="statistics.statistics[0].hours_spent.hours_spent" ng-cloak>{{osCommonMethods.format_time_hr_min(statistics.statistics[0].hours_spent.hours_spent)}}</div>
    <div class="fl stas_icn stas_green" ng-if="!statistics.statistics[0].hours_spent.hours_spent">0</div>
    <div class="fl stas_cnt_db"> <?php echo __('spent and still counting');?></div>
    <div class="cb"></div>
</div>
<div ng-if="statistics.extra != 'overview'">
<div class="lstbtndv"></div>
<div class="listdv summary_row">
    <div class="fl stas_icn stas_green" ng-if="statistics.statistics[0].task_hours.task_hours" ng-cloak>{{osCommonMethods.format_time_hr_min(statistics.statistics[0].task_hours.task_hours)}}</div>
    <div class="fl stas_icn stas_green" ng-if="!statistics.statistics[0].task_hours.task_hours">0</div>
    <div class="fl stas_cnt_db"> <?php echo __('spent on');?> <span ng-cloak>{{statistics.task_type_name}}</span></div>
    <div class="cb"></div>
</div>
</div>

