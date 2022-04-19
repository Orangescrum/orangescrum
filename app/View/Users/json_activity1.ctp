<div ng-controller="activity_Controller" id="activityController"> 
       <div ng-repeat="(x,data) in activity_records" ng-init="setcurrent(activity_records,x)" on-finish-render="callMyCustomMethod()" ng-cloak >          
           <div class="gray-dot">     
                <div class="fl activity-date" ng-if="data.Easycase.lastDate != activity_records[x - 1].Easycase.lastDate">{{data.Easycase.lastDate}}</div>         
                <div class="fr cwrc" id="allStatus{{data.Easycase.id}}" ng-if="data.Easycase.lastDate != activity_records[x - 1].Easycase.lastDate">
                    <ul><li><span><?php echo __('Created');?>(<small class='orange-txt'>{{statusCount[data[0].ddate].v_new}}</small>)</span></li><li><span> <?php echo __('Worked in progress');?>(<small class='blue-txt'>{{statusCount[data[0].ddate].v_replied}}</small>)</span></li>
					<?php /*<li><span> <?php echo __('Resolved');?>(<small class='orange-txt'>{{statusCount[data[0].ddate].v_resolved}}</small>)</span></li> */ ?>
					<li><span> <?php echo __('Done');?>(<small class='green-txt'>{{statusCount[data[0].ddate].v_closed}}</small>)</span></li></ul>
                </div>
                
                <div class="cb"></div>
                
                <div class="activity-row" ng-if="data.Easycase.nmsg !=''" >
                    <span>		
                    <span class="cmn_profile_holder prof_hold_pos_absl" ng-if="data.User.photo !='' && data.User.photo != null">
					<img class="round_profile_img ppl_invol lazy" data-original="<?php echo HTTP_ROOT ; ?>users/image_thumb/?type=photos&file={{data.User.photo}}&sizex=30&sizey=30&quality=100" width="30" height="30" title="{{data.User.name}} {{data.User.short_name }}" rel="tooltip" alt="Loading"/>
                    </span>
                    <span class="cmn_profile_holder prof_hold_pos_absl {{data.User.profile_bg_clr}}" ng-if="data.User.photo =='' || data.User.photo == null">{{data.User.name.charAt(0)}}</span>
                    </span>
                    <div class="activity-hover-bg totalstatus allStatus{{data.Easycase.id}}" rel="{{data.Easycase.legend}}">
                            <small class="fr activity-time">{{data.Easycase.updated}}</small>
                            <div ng-bind-html="trustAsHtml(data.Easycase.nmsg)"></div>
                            <span>{{data.User.name}}</span>			
                    </div>
                </div>
                
            </div>
       </div>
<input type="hidden" id="totalact" value="{{activity_total}}">
</div>