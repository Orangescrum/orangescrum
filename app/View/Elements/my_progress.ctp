<%
var pgCaseCnt = caseAll?countJS(caseAll):0;
if(pgCaseCnt && pgCaseCnt != 0){ %>
<table>
    <thead>
        <tr>
            <th>Project</th>
            <th>Percent Complete</th>
        </tr>
    </thead>
    <tbody>
         <%for(var caseKey in caseAll){
            var getdata = caseAll[caseKey]; 
            %>
        <tr>
            <td><%= getdata.pro_short_name %></td>
            <td>
                <div class="hrz_progressbar">
                    <% if(getdata.percent==0){%>
                        <span style="width:<%= getdata.percent %>%;color: black;"><%= getdata.percent %>%</span>
                    <% }else{ %>
                        <span style="width:<%= getdata.percent %>%"><%= getdata.percent %>%</span>
                    <% } %>
                </div>
            </td>
        </tr>
        <% } %>
    </tbody>
    <% }else{ %>
    <thead>
        <tr>
            <th colspan="2">
                <img src="<?php echo HTTPS_HOME;?>img/sample/dashboard/progress.png" style="width:98%;margin-top:-11px;">
            </th>
        </tr>
    </thead>
    <% } %>
</table>