<li><p class="drop-paragraph"><?php echo __('Notifications');?></p></li>
<input type="hidden" id="assigntome_date" value="<%= res.assigntomeDate %>"/>
<input type="hidden" id="overdue_date" value="<%= res.overdueDate %>"/>
<?php /*<li id="no_notification_li" style="display:none;">
    <a href="javascript:void(0)">
        <i class="material-icons cmn-icon-prop">&#xE7F4;</i> <?php echo __('No Notifications');?>
    </a>
</li> */ ?>
<?php //custom notification ?>
<?php  /*if(SES_TYPE < 3){ ?>
<li>
    <a href="<?php echo HTTP_ROOT;?>user-role-settings/" target="_blank">
        <i class="material-icons">notifications</i> <?php echo __('User Role & Privilege Management');?>
    </a>
</li>
<?php } ?>
<?php if(ACCOUNT_STATUS!=2){ ?>
<li>
    <a href="<?php echo HTTP_ROOT;?>quick-link-settings" target="_blank">
        <i class="material-icons">notifications</i> <?php echo __('Quick Link configuration');?>
    </a>
</li>
<?php } */ /*?>
<li>
    <a href="<?php echo HTTP_ROOT;?>sidebar-settings" target="_blank">
        <i class="material-icons">notifications</i> <?php echo __('Left Menu configuration');?>
    </a>
</li>
<?php */?>
<% if(res.overdueCount > 0){ %>
<li id="overdue_notification_li">
    <input type="hidden" id="overdue_count" value="<%= res.overdueCount %>"/>
    <a href="javascript:void(0)" onclick="seenNotification(<%= '\'overdue\'' %>)">
        <i class="material-icons cmn-icon-prop">&#xE862;</i> <%= parseInt(res.prevOverdueCount)+parseInt(res.overdueCount) %> <?php echo __('Total Overdue Task(s)');?>
    </a>
</li>
<% } %>
<% if(res.assigntomeCount > 0){ %>
<li id="assigntome_notification_li">
    <input type="hidden" id="assigntome_count" value="<%= res.assigntomeCount %>"/>
    <a href="javascript:void(0)" onclick="seenNotification(<%= '\'assigntome\'' %>)">
        <i class="material-icons cmn-icon-prop">&#xE862;</i> <%= res.assigntomeCount %> <?php echo __('Task(s) assigned to you');?>.
    </a>
</li>
<% } %>
<% if(res.timelogCount > 0){ %>
<li id="timelog_notification_li">
    <input type="hidden" id="timelog_count" value="<%= res.timelogCount %>"/>
    <a href="javascript:void(0)" onclick="seenNotification(<%= '\'timelog\'' %>)">
        <i class="material-icons cmn-icon-prop">&#xE192;</i> <?php echo __('No Time Log Entry since');?> <%= res.timeloglastEntry %>
    </a>
</li>
<% } %>
<% if(res.activityCount > 0){ %>
<li id="activity_notification_li">
    <input type="hidden" id="activity_count" value="<%= res.activityCount %>"/>
    <a href="javascript:void(0)" onclick="seenNotification(<%= '\'activity\'' %>)">
        <i class="material-icons cmn-icon-prop">&#xE922;</i> <%= res.activityCount %> <?php echo __('activities on tasks');?>
    </a>
</li>
<% } %>