<div ng-controller="mention_Controller" id="mentionController" > 
       <div ng-if="mention_total > 0" ng-repeat="(x,data) in mention_records" ng-init="setcurrent(mention_records,x)" on-finish-render="callMyCustomMethod()" ng-cloak >          
           <div class="gray-dot">     
                <div class="fl activity-date" ng-if="data.EasycaseMention.lastDate != activity_records[x - 1].EasycaseMention.lastDate">{{data.EasycaseMention.lastDate}}</div>         
                
                
                <div class="cb"></div>
                
                <div class="activity-row" ng-if="data.EasycaseMention.nmsg !=''" >
                    <span>		
                    <span class="cmn_profile_holder prof_hold_pos_absl" ng-if="data.User.photo !='' && data.User.photo != null">
					<img class="round_profile_img ppl_invol lazy" data-original="<?php echo HTTP_ROOT ; ?>users/image_thumb/?type=photos&file={{data.User.photo}}&sizex=30&sizey=30&quality=100" width="30" height="30" title="{{data.User.name}} {{data.User.short_name }}" rel="tooltip" alt="Loading"/>
                    </span>
                    <span class="cmn_profile_holder prof_hold_pos_absl {{data.User.profile_bg_clr}}" ng-if="data.User.photo =='' || data.User.photo == null">{{data.User.name.charAt(0)}}</span>
                    </span>
                    <div class="activity-hover-bg">
                            <!-- small class="fr activity-time">{{data.Easycase.updated}}</small -->
                            <div ng-bind-html="trustAsHtml(data.EasycaseMention.nmsg)"></div>
                            <span ng-bind-html="trustAsHtml(data.EasycaseMention.mention_message)" class="mentioned_message_cls"></span>			
                    </div>
                </div>
                
            </div>
       </div>
<div ng-if="mention_total== 0" class="empty_mntn"><?php /*echo __("All your ");?><strong><?php echo __("@mentions ");?></strong> <?php echo __("will appear here! Start collaborating with your teams by using");?><strong> <?php echo __(" @mentions");?></strong><?php echo __(" on task description and task comments.");*/?>
    <img src="<?php echo HTTP_ROOT;?>/img/images/no_mention_data.png">
</div>
<input type="hidden" id="totalmention" value="{{mention_total}}">
</div>
<style>
.dash-mention .dash-mentioned-cont .empty_mntn{text-align:center;border-left:none;}
.dash-mention .empty_mntn {background: #fff;position: relative;left: -1px;}
</style>