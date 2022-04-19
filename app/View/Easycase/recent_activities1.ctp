<div ng-if="activity.recent_activities.length >0">
<div ng-repeat="(key, value) in activity.recent_activities" >
        <div ng-if="(value.Easycase.pclient_status == 1 && value.Easycase.puserid == SES_ID) || value.Easycase.pclient_status != 1 || SES_TYPE < 3">
    <div class="gray-dot" ng-hide="checkLastDate($index);">
        <div class="activity-date" ng-cloak>{{value.Easycase.newActuldt}}</div>
    </div>
    <div class="activity-row">
        <span class="activity-img" rel="tooltip" title="{{ value.User.funll_name}}" ng-cloak>
            <span ng-if="value.User.photo != null && value.User.photo != '' ">            
            <img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file={{value.User.photo}}&sizex=30&sizey=30&quality=100" title="{{value.User.name}}" rel="tooltip" alt="Loading"/>
            </span>
            <span ng-if="value.User.photo == null || value.User.photo == ''">
                <span class="cmn_profile_holder {{value.User.profile_bg_clr}}">{{value.User.name.charAt(0)}}</span>
            </span>           
        </span>
        <small class="fr activity-time" ng-cloak>{{value.Easycase.updated}}</small>
        <span class="red-txt" ng-bind-html="value.Easycase.nmsg" ng-cloak></span>
        <p class="linkable-txt" title="{{value.Easycase.title}}" ng-bind-html="value.Easycase.ntxt" ng-cloak ></p>
                <p ng-if="activity.project == 'all'" ng-cloak style="color:#6699ff;"><i class="material-icons" style="font-size: 18px;vertical-align: middle;">work</i><a href="<?php echo HTTP_ROOT; ?>dashboard/?project={{value.Project.uniq_id}}" title="{{value.Project.name}}" style="color:#6699ff;vertical-align: middle;">{{value.Project.short_name}}</a></p>
                <span ng-cloak>{{value.User.name}}</span>
            </div>
    </div>
</div>
	<div id="recent_activities_more" data-value="{{activity.total}}" style="display: none;"></div>
	<div class="fr moredb" id="more_recent_activities"><a href="javascript:void(0);" onclick="showTasks('activities');"><?php echo __('View All');?> <span id="todos_cnt" style="display:none;">(0)</span></a></div>
</div>
<div ng-if="activity.recent_activities.length <= 0">
     <?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>     
	<div class="mytask" onclick="setSessionStorage('Recent Activities Page', 'Create Task');creatask();"></div>
<?php } ?>
	<div class="mytask_txt"><?php echo __('No Recent Activities');?></div>
    <div id="recent_activities_more" class="dash-activity-cont" data-value="0" style="display: none;"></div>
</div>
