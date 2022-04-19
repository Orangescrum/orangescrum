<li><p class="drop-paragraph"><?php echo __("What's New");?></p></li>
<% if(!data.length){ %>
<li id="no_pr_notification_li">
    <a href="javascript:void(0)">
        <i class="material-icons cmn-icon-prop">update</i> <?php echo __('No Updates');?>
    </a>
</li>
<% }else{ %>
	<% var ses_type = "<?php echo SES_TYPE; ?>"; %>
    <% $.each(data, function(index, val) { %>		
        <li class="update_notify_data" id="overdue_notification_li" <% if(val[0]['id'] == 3 && ses_type > 2){ %> style="display:none;" <% } %>>
            <a href="javascript:void(0)" onclick="showReleasedtls(<%= val[0]['id'] %>)">
                <i class="material-icons cmn-icon-prop">offline_bolt</i> <%= val[0]['title'] %>
				<div class="rels_dt"><%= val[0]['release_date'] %></div>
            </a>
            <% if(!val[0]['is_seen']){ %>
                <span class="dot_active_notice" id="rls-new-<%= val[0]['id'] %>"></span>
            <% } %>
        </li>
    <% }); %>
    <li class="view_all"><a href="<%= HTTP_ROOT+'product-releases' %>">View all</a></li>
<% } %>