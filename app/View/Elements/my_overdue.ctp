<table>
    <%
    var pgCaseCnt = caseAll?countJS(caseAll):0;
    if(caseCount && caseCount != 0){ 
    easycase.myOverTaskCount(caseCount);
    var getTotRep = 0;
    var curprojId = 0;
    var flag =0;
    for(var caseKey in caseAll){
    var getdata = caseAll[caseKey];
    var casePriority = getdata.Easycase.priority;
    var projId = parseInt(getdata.Easycase.project_id);
    if(getdata.Easycase.reply_cnt && getdata.Easycase.reply_cnt!=0) {		
    getTotRep = getdata.Easycase.reply_cnt;
    }
    if(curprojId != projId){
    curprojId = projId;
    flag =1;
    } else {
    flag=0;
    }
    %>
    <% if( (typeof getdata.Easycase.pjname !='undefined') && flag == 1 ){ %>
    <thead>
        <tr>
            <th colspan="3">
                <a href="javascript:void(0);" onclick="return projectBodyClick('<%= getdata.Easycase.pjUniqid %>');">
                    <span class="cmn_icon"><i class="material-icons">work</i></span>
                    <%= getdata.Easycase.pjname %>
                </a>
            </th>
        </tr>
    </thead>
    <% } %>
    <tbody>
        <tr>
            <td>
                # <%= getdata.Easycase.case_no %>
            </td>
            <td>
                <span class="priority_line prio_<%= easycase.getPriority(casePriority) %>"></span>
                <a href="<?php echo HTTP_ROOT; ?>dashboard#/details/<%= getdata.Easycase.uniq_id %>" style="color:#2d6dc;">
                    <span class="ttype_global tt_<%= getttformats(getdata.Easycase.csTdTyp[1])%>" style="margin-top:2px;"></span>
                    <%= getdata.Easycase.title %>
                    <small><% if(getTotRep && getTotRep!=0) { %><?php echo __('Updated'); ?><% } else { %><?php echo __('Created'); ?><% } %> <?php echo __('by'); ?> <%= easycase.shortName(getdata.Easycase.usrShortName) %> <% if(getdata.Easycase.updtedCapDt.indexOf('Today')==-1 && getdata.Easycase.updtedCapDt.indexOf('Y\'day')==-1) { %><?php echo __('on'); ?><% } %> <%= getdata.Easycase.updtedCapDt %></small>
                </a>
            </td>
            <td>
                <div class="over_due"><%= getdata.Easycase.csDuDtFmt %><small><%= getdata.Easycase.csDuDtFmtBy %></small></div>
            </td>
        </tr>
    </tbody>
    <% } %>
    <% }else{  easycase.myOverTaskCount(0); %>
    <thead>
        <tr>
            <th colspan="3">
                No Tasks
            </th>
        </tr>
    </thead>
    <% } %>
</table>