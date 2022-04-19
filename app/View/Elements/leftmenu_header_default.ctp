<% $.each(menu_array, function(index, val) { %>
    <div class="menu_catagories">
      <div class="checkbox parent_check ch-disabled"> 
        <label>        
          <input type="checkbox" checked disabled>
          <span><%= val.menu_name %></span> 
        </label> 
      </div>
      <% if(val.submenus.length){ %>
          <ul>
            <% $.each(val.submenus, function(i, v) { %>
            <li>
              <div class="checkbox ch-disabled">
                <label>        
                  <input type="checkbox" checked disabled>
                  <span><%= v.submenu_name %></span> 
                </label> 
              </div>
            </li>
            <% }); %>
          </ul>
      <% } %>
    </div>
<% }); %>