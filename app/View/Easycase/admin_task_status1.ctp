<table class="table table-striped tbl_cmn top_prj_chrt_tbl">
    <tr ng-repeat="(key, value) in admin_task.projects" on-finish-render="ngRepeatFinished" ng-cloak >
        <td class="prj_nm">
            <div class="tfp-name">
                <a class="ellipsis-view" href="javascript:void(0);" rel="tooltip" title="{{value[0]}}" ng-click="projectBodyClick(key, event);" style="display:block"  ng-bind-html="value[0]" ng-cloak ></a>
                    <small ng-if="value[2] != ''" class="prj-desc ellipsis-view mx-width-100" ng-bind-html="value[2]" ng-cloak></small>
					<span class="prio_{{ value[4] }} prio_lmh prio_gen_prj prio-drop-icon" rel="tooltip" title="{{ value[3] }} <?php echo __('Priority');?>"></span> <span style="font-size:11px;">{{ value[3] }}</span>
					
                    <small class="prj-desc ellipsis-view mx-width-100" rel="tooltip" title="<?php echo __('Updated on')?>" ng-cloak ><span  ng-cloak> <?php echo __('Updated on');?> {{ value[1] | moment:"format: 'Do MMMM YYYY'" }}</span></small>
            </div>
        </td>        
        <td class="tfp-chart">
           <div id="{{$index+1}}_prj"></div> 
        </td>
    </tr>
    <?php /* <tr>
        <td colspan="3" class="sts_symbol">
            <span class="symbol new"><?php echo __('New');?></span>
            <span class="symbol ip"><?php echo __('In Progress');?></span>
            <span class="symbol resolve"><?php echo __('Resolved');?></span>
            <span class="symbol closed"><?php echo __('Closed');?></span>
        </td>
    </tr> */ ?>
</table>