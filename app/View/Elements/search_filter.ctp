 <% 
    for(var m in sf){ %>
    <% if(localStorage["SEARCHFILTER"] == 'ftopt'+sf[m]['SearchFilter']['id']){
            jsarray=sf[m]['SearchFilter']['json_array'];
    } 
    %>
     </li>
        <a href="<%= HTTP_ROOT %>dashboard#tasks/custom-<%= sf[m]['SearchFilter']['id'] %>" class="show_all_opt_in_listonly pr" id="ftopt<%= sf[m]['SearchFilter']['id'] %>" data-val="<%= sf[m]['SearchFilter']['id'] %>" title="<%= sf[m]['SearchFilter']['name'] %>" data-valname="<%= sf[m]['SearchFilter']['url_name'] %>">
            <span class="ttl_dd_icn"><%= sf[m]['SearchFilter']['name'].charAt(0) %></span>
            <%= sf[m]['SearchFilter']['namewithcount'] %>
        </a>									
 </li>
    <% } 
            setTimeout(function(){ 	
            if(typeof jsarray !='undefined'){    
                checkFilterItemChanges(jsarray);
            }
            }, 1000);
     if(sf.length > 0){ %>
      </li>
      <a id="manageFilterAnchor" href="<%= HTTP_ROOT %>dashboard#searchFilters" class="show_all_opt_in_listonly" onclick="showOtherSubMenu();viewFilters_btn();" ><i class="glyphicon glyphicon-filter"></i> <?php echo __('Manage Filters');?></a>
       </li>
    <%  } %> 