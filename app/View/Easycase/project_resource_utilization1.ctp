<table id="project_utilization" class="table table-striped tbl_cmn proj_wis_res">
	<tr>
		<th><?php echo __('Title');?></th>
		<th><?php echo __('This month work');?></th>
		<th class="text-center"><?php echo __('Future work');?></th>
	</tr>    
        <tr ng-repeat="(key, value) in resource.topprojects" ng-init="setDates(key,resource.topprojects[key])" ng-cloak>
            <td ng-cloak>{{value}}</td>
            <td  class="tm_work">
                <div class="last_30">
                    <div ng-if="upcls[i]==up-div" class="fl info_lst">
                        <h4 ng-cloak>{{osCommonMethods.formatHour(thismnthhour[key])}}</h4>
                    </div>
                    <div ng-if="upcls[i] != up-div" class="fl warn_lst">
                        <h4 ng-cloak>{{osCommonMethods.formatHour(thismnthhour[key])}}</h4>
                    </div>
                    <div class="fl">
                        <span ng-if="upcls[i] == up-div" class="label label-info" ng-cloak>
                            {{uptxt[key]}} {{percentageUp[key]}}{{totxt[key]}}{{osCommonMethods.formatHour(prevmnthhour[key])}}
                        </span>
                        <span ng-if="upcls[i] != up-div" class="label label-warn" ng-cloak>
                            {{uptxt[key]}} {{percentageUp[key]}}{{totxt[key]}}{{osCommonMethods.formatHour(prevmnthhour[key])}}
                        </span>
                        <h6><?php echo __('Last month to Date');?></h6>
                </div>
                <div class="cb"></div>
            </div>
        </td>
        <td class="text-center future_work"><strong ng-cloak>{{osCommonMethods.formatHour(futurehour[key])}}</strong></td>
    </tr>
</table>