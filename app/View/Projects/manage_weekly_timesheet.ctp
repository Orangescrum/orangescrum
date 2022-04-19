
<?php if ($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN) { ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.bootgrid.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>css/jquery.bootgrid.min.css" />
<div class="proj_grids glide_div setting_wrapper task_listing resource_sec cmn_tbl_widspace" id="timesheet_approval_div">
<div class="cmn_timesheet_approver_layout manage_timesheet_approval">
<div class="row">
	<div class="col-md-12">
		<div class="tab-content pr">
		<div id="request" class="activate active tab-pane">
			<div class="section_header">
				<h3><?php echo __("Pending For Approval"); ?> </h3>
			</div>
			<div class="load-data-table">
			<table id="grid-timesheet-settings0" class="table table-condensed table-hover table-striped custom-datatable" data-visible-in-selection="false">
				<thead>
					<tr> 
						<th data-column-id="id" data-visible="false" data-sortable="false" data-type="numeric" data-identifier="true"  data-width="5%"></th>
						<th data-column-id="week_num" data-formatter="approve_link" data-order="desc" data-width="20%"><?php echo __('Week');?></th>
						<th data-column-id="submitted_by" data-visible="true" data-sortable="true"><?php echo __('Submitted By');?></th>
						<th data-column-id="req_hours"><?php echo __('Required Hours');?></th>
						<th data-column-id="submitted_hours" data-visible="true" data-sortable="false"><?php echo __('Submitted Hours');?></th>
						<th data-column-id="excess_short_hours" data-visible="true" data-sortable="true"><?php echo __('Excess/Short Hours');?></th>						
						<th data-column-id="comment"  data-sortable="true"><?php echo __('Comments');?></th>
						<th data-class="text-center" data-column-id="action" data-formatter="checkbox"  data-sortable="false"><?php echo __('Action');?></th>
					</tr>
				</thead>
			</table>
			</div>
			<div class="mtop20">
			<div class="section_header">
				<h3><?php echo __("My Activity"); ?> </h3>
			</div>
			<div class="load-data-table">
			<table id="grid-timesheet-settings2" class="table bgrid  table-condensed table-hover table-striped custom-datatable">
					<thead>
						<tr>
							<th data-column-id="week_num" data-order="desc" data-width="20%"><?php echo __('Week');?></th>
							<th data-column-id="submitted_by"><?php echo __('Submitted By');?></th>
							<th data-column-id="required_hours" data-visible="true" data-sortable="true"><?php echo __('Required Hours');?></th>
							<th data-column-id="submitted_hours" data-visible="true" data-sortable="true"><?php echo __('Submitted Hours');?></th>
							<th data-column-id="excess_short_hours" data-visible="true" data-sortable="true"><?php echo __('Excess/Short Hours');?></th>
                        <th data-column-id="approval_rejected" data-visible="true" data-sortable="true"><?php echo __('Approve/Reject');?></th>
							<th data-column-id="reject_note"  data-sortable="true"><?php echo __('Reject Note');?></th>
                        <th data-column-id="created_date"  data-sortable="true"><?php echo __('Date');?></th>
						</tr>
					</thead>
			</table>
			</div>
			</div>
		</div>
		<div id="allStatus"class="activate  tab-pane">
			<div class="load-datatable-table">
			<table id="grid-timesheet-settings1" class="table bgrid  table-condensed table-hover table-striped custom-datatable">
					<thead>
						<tr>
							<th data-column-id="week_num"  data-formatter="pending_link" data-order="desc" data-width="20%"><?php echo __('Week');?></th>
							<th data-column-id="req_hours"><?php echo __('Required Hours');?></th>
							<th data-column-id="submitted_hours" data-visible="true" data-sortable="true"><?php echo __('Submitted Hours');?></th>
							<th data-column-id="excess_short_hours" data-visible="true" data-sortable="true"><?php echo __('Excess/Short Hours');?></th>
							<th data-column-id="approval_by" data-visible="true" data-sortable="true"><?php echo __('Approver');?></th>
							<th data-column-id="comment"  data-sortable="true"><?php echo __('Comments');?></th>
						</tr>
					</thead>
			</table>
			</div>
		</div>
	 </div>
	</div>
</div>
</div>
</div>
<div class="modal fade timeapproval_modal" id="week_modal" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Time Log Details <button type="button" id="weekClose" class="close" data-dismiss="modal">&times;</button></h4>
        </div>
        <div class="modal-body" style="min-height:200px;">
         
         <div  id="loadWeekWiseTimesheetDetails"></div>
        
        </div>
      </div>
    </div>
  </div>
  <button type="button" style="display:none" id="weekDetails" class="btn btn-primary" data-toggle="modal" data-target="#week_modal">
  </button>
</div>
<div class="modal fade timeapproval_modal" id="rejectComment" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Reject Note
			<button type="button" id="rejectNoteClose" class="close" data-dismiss="modal">&times;</button>
		  </h4>
          
        </div>
        <div class="modal-body">
         <div class="row">
        <div class="col-sm-12">
        <form action="">
            <div class="form-group label-floating ">
                <label class="control-label" for="rejectNote"><?php echo __("Reject Note");?>:</label>
                <textarea id="rejectNote" class="form-control input-lg expand hideoverflow comment_desc_class" rows="1"  onkeypress="removeErr('rjctErrs')" name="rejectNote"></textarea>
                
            </div>
            <span id="rjctErrs" class="text-danger"></span>
            <!-- textarea name="rejectNote" id="rejectNote" cols="30" style="width:100%;" ></textarea -->
          </form>
        </div>
          </div>
        </div>
        <div class="modal-footer">
			<div class="text-right">
				<button type="button" id="btnSubmit" class="btn cmn_size btn_cmn_efect cmn_bg btn-info">Save</button>
		  </div>
        </div>
      </div>
    </div>
  </div>
  <button type="button" style="display:none" id="rejectBtn" class="btn btn-primary" data-toggle="modal" data-target="#rejectComment">
  </button>
</div>
<div class="modal fade timeapproval_modal" id="checkall" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Approve / Reject 
			<button type="button" id="approveRejectModalClose" class="close" data-dismiss="modal">&times;</button>
		  </h4>
          
        </div>
        <div class="modal-body">
         <div class="row">
           <h5 class="text-center">
                 Approve/Reject all timesheets on the current page?
           </h5>
           <br>
           <br>
        <div class="col-sm-12 text-right">
			<div class="text-right">
				<span class="d-inline-block">
			  <span class="btn cmn_size btn_cmn_efect cmn_bg btn-info"  id="btnApprove">Approve</span>
			  </span>
			  <span class="d-inline-block">
			  <span class="btn cmn_size btn_cmn_efect cmn_bg btn_reject" id="btnReject">Reject</span>
			  </span>
			</div>
        </div>
          </div>
        </div>
        <!-- <div class="modal-footer">
          <button type="button" id="btnSubmit" class="btn btn-danger">Save</button>
        </div> -->
      </div>
    </div>
  </div>
  
</div>
<button type="button" style="display:none" id="checkunchek" class="btn btn-primary" data-toggle="modal" data-target="#checkall">
  </button>
<script>
var params = 0;
var tab = 0;
$(document).ready(function(){
    
    localStorage.setItem("params", 0);
    localStorage.setItem("tab", 0);
    var id =0;
    bootgrid_data(id);
	});
function tabList(id,param){
    bootgrid_data(id);
  //  localStorage.setItem("params", param);
  //  localStorage.setItem("tab", id);
    params = param;
    tab = id;
    
    $(".cmntltab").removeClass("active-list");
    $("#tltab"+param).addClass("active-list");
    $("#grid-timesheet-settings"+id).bootgrid('reload');
    if(id > 0){
    $("#request").hide();
     $("#allStatus").show();
   
        $("#grid-timesheet-settings1").bootgrid('reload');
    }else{
        $("#allStatus").hide();
        $("#request").show();
      
      $("#grid-timesheet-settings0").bootgrid('reload');
     //  $("#grid-timesheet-settings2").bootgrid('reload');
    }
    
}
//var tab = localStorage.getItem("tab");
function bootgrid_data(id){
  // var params = localStorage.getItem("params");
   var url =  HTTP_ROOT+'projects/ajaxWeeklyTimesheetDetails';
   
    $(".cmntltab").removeClass("active-list");
    $("#tltab"+params).addClass("active-list");
   
   var grid = $("#grid-timesheet-settings"+id).bootgrid({
        
   ajax: true,
   post: function (){
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
            params:params,
            tab: tab
        };
   },
   url:url,
   columnSelection:false,
    formatters: { 
        'checkbox': function(column, row){
            return "<button type=\"button\" data-row-id=\"" + row.id + "\" data-week-num=\"" + row.week + "\" data-year=\"" + row.year + "\" data-approver-id=\"" + row.approverid + "\" data-user-id=\"" + row.userid + "\"  data-flag=\"" + 0 + "\" class=\"action-button actions-modal\" rel='tooltip' title='View Timesheet'><i class='material-icons'>visibility</i></button>"+
                    "<button type=\"button\" id=\"approve"+row.id+"\" class=\"action-button actions-approve\" data-row-id=\"" + row.id + "\" data-week=\"" + row.week + "\" data-year=\"" + row.year + "\" data-user-id=\"" + row.userid + "\" data-tab-id=\"" + row.tab + "\" rel='tooltip' title='Approve  Timesheet'><i class='material-icons'>task_alt</i></button>" + 
                    "<button type=\"button\" id=\"remove"+row.id+"\" class=\"action-button actions-delete\" data-row-id=\"" + row.id + "\" data-week=\"" + row.week + "\" data-year=\"" + row.year + "\" data-user-id=\"" + row.userid + "\" data-tab-id=\"" + row.tab + "\" rel='tooltip' title='Reject Timesheet'><i class='material-icons'>thumb_down_off_alt</i></button>";
        },
        "approve_link": function(column, row)
        {
            return "<a href=\"#\" data-row-id=\"" + row.id + "\" data-week-num=\"" + row.week + "\" data-year=\"" + row.year + "\" data-approver-id=\"" + row.approverid + "\" data-user-id=\"" + row.userid + "\"  data-flag=\"" + 0 + "\" class=\"actions-modal\" >" + row.week_num+ "</a>";
        },
        "pending_link": function(column, row)
        {
          if(row.params != 1){
              return row.week_num;
          }else{
              return "<a href=\"#\" data-row-id=\"" + row.id + "\" data-week-num=\"" + row.week + "\" data-year=\"" + row.year + "\" data-approver-id=\"" + row.approverid + "\" data-user-id=\"" + row.userid + "\" data-flag=\"" + 1 + "\" class=\"actions-modal\" >" + row.week_num+ "</a>";
        }
        }
    },
    selection: true,
    multiSelect: true,
    rowSelect: true,
    keepSelection: true,
   }).on("loaded.rs.jquery.bootgrid", function(){
		$('[rel=tooltip]').tipsy({gravity:'s',fade:true});
		$("img.lazy").lazyload({
				placeholder: HTTP_ROOT + "img/lazy_loading.png"
		});
    grid.find(".actions-approve").on("click", function(e){
       var rowid = $(this).data("row-id");
       var tab = $(this).data("tab-id");
       var week = $(this).data("week");
       var year = $(this).data("year");
       var userid = $(this).data("user-id");
       var status = 2;
       var cnfrm = confirm("<?php echo __('Are you sure you want to approve ?');?>");
       if(cnfrm){
            $.ajax({
           type:'post',
           url: HTTP_ROOT+'projects/ajaxTimesheetApproveAndReject',
           dataType:'json',
           data:{rowid:rowid,week:week,year:year,userid:userid,status:status,tab:tab},
           success:function(res){
              if(res.status){
                $("#approveRejectModalClose").trigger('click');
               $('#grid-timesheet-settings0').bootgrid('reload');
               $("#grid-timesheet-settings2").bootgrid('reload');
              }
           }
       });
       }
   }).end().find(".actions-delete").on("click", function(e){
       var rowid = $(this).data("row-id");
       var tab = $(this).data("tab-id");
       var week = $(this).data("week");
       var year = $(this).data("year");
       var userid = $(this).data("user-id");
       var status = 3;
       var cnfrm = confirm("<?php echo __('Are you sure you want to reject ?');?>");

       if(cnfrm){
           
           $('#rejectComment').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
            $("#rejectNote").val('');
           // $("#rejectBtn").trigger('click');
            $("#btnSubmit").click(function(){
                var rejectNote = $("#rejectNote").val();
                if(rejectNote == ''){
                     $("#rjctErrs").html("Please add a rejection note");
                     $("#rejectNote").focus();

                         //alert("Please add some reject note before rejecting the weekly timesheet");
                         return false;
                 }else{
                    $("#rejectNoteClose").trigger("click");
                    $.ajax({
                        type:'post',
                        url: HTTP_ROOT+'projects/ajaxTimesheetApproveAndReject',
                        dataType:'json',
                        data:{rowid:rowid,week:week,year:year,userid:userid,status:status,rejectNote:rejectNote,tab:tab},
                        success:function(res){
                            if(res.status){
                              $("#approveRejectModalClose").trigger('click');
                            $('#grid-timesheet-settings0').bootgrid('reload');
                            $("#grid-timesheet-settings2").bootgrid('reload');
                            }
                        }
                  });
                }
            });
       }
   }).end().find(".actions-modal").on("click", function(e){
       var rowid = $(this).data("row-id");
       var week = $(this).data("week-num");
       var year = $(this).data("year");
       var flag = $(this).data("flag");
       var approverid = $(this).data("approver-id");
       var userid = $(this).data("user-id");
      // var flag = 0;
       
    $('#week_modal').modal({
        show: true,
        backdrop: 'static',
        keyboard: false
    });
    //  $("#weekDetails").trigger('click');
      $.post(HTTP_ROOT + 'projects/weekWiseTimesheetDetails', {'rowid':rowid,'week':week,'year':year,'flag':flag,'approverid':approverid,'userid':userid}, function (data) {
			// $(".displaytimelog_loader_dv").hide();
			$("#loadWeekWiseTimesheetDetails").html(data);
			$("#approvers_record_id").val(rowid);
			$("#approvers_user_id").val(userid);
			$("#approver_id").val(approverid);
			$("#approve_start_week").val(approve_start_week);
			$("#approve_end_week").val(approve_end_week);
		});
   });
    }).on("selected.rs.jquery.bootgrid", function(e, rows){
    var rowIds = [];
    var rowWeeks = [];
    var rowyears = [];
    var userids = [];
    for (var i = 0; i < rows.length; i++){
        rowIds.push(rows[i].id);
        rowWeeks.push(rows[i].week);
        rowyears.push(rows[i].year);
        userids.push(rows[i].userid);
    }
     $('#checkall').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
    
   // $("#checkunchek").trigger('click');
     $("#btnApprove").off().on('click',function(){
     var status = 2;
     var approve_cnfrm = confirm("<?php echo __('Are you sure you want to approve all?');?>");
      if(approve_cnfrm){
     $.ajax({
           type:'post',
           url: HTTP_ROOT+'projects/ajaxAllTimesheetApprove',
           dataType:'json',
           data:{rowid:rowIds,status:status,rowweek:rowWeeks,rowyear:rowyears,userid:userids},
           success:function(res){
              if(res.status){
               $('#grid-timesheet-settings0').bootgrid('reload');
               $("#grid-timesheet-settings2").bootgrid('reload');
              }
           }
       });
      }else{
        rowIds = [];
        rowWeeks = [];
        rowyears = [];
        userids = [];
        
       }
});
   
$("#btnReject").off().on('click',function(){
  
  var cnfrm = confirm("<?php echo __('Are you sure you want to reject all ?');?>");
  if(cnfrm){
  $("#approveRejectModalClose").trigger('click');
      $('#rejectComment').modal({
                show: true,
                backdrop: 'static',
                keyboard: false
            });
            $("#rejectNote").val('');
   // $("#rejectBtn").trigger("click");
  }
    $("#btnSubmit").click(function(){
        var rejectNote = $("#rejectNote").val();
        var status = 3;
      
        if(rejectNote == ''){
            $("#rjctErrs").html("Please add a rejection note");
            $("#rejectNote").focus();

                //alert("Please add some reject note before rejecting the weekly timesheet");
                return false;
        }else{
     $.ajax({
           type:'post',
           url: HTTP_ROOT+'projects/ajaxAllTimesheetApprove',
           dataType:'json',
           data:{rowid:rowIds,status:status,rowweek:rowWeeks,rowyear:rowyears,userid:userids,rejectnote:rejectNote},
           success:function(res){
             $("#rejectNoteClose").trigger('click');
              if(res.status){
                      // tab = res.tab;
               $('#grid-timesheet-settings0').bootgrid('reload');
               $("#grid-timesheet-settings2").bootgrid('reload');
              }
           }
       });
        }
    });
  
});
});
MyActivity();
}

function MyActivity(){
   var urls =  HTTP_ROOT+'projects/ajaxAllMyActivityDetails';
   var grid_v = $("#grid-timesheet-settings2").bootgrid({
   ajax: true,
   post: function (){
        return {
            id: "b0df282a-0d67-40e5-8558-c9e93b7befed",
            p:2
        };
   },
   url:urls,
    formatters: { 
     
    },
    sorting: true,
    multiSort: false,
    rowSelect: true,
    keepSelection: true,
    columnSelection:false,
   }).on("loaded.rs.jquery.bootgrid", function(){
    grid_v.find(".actions-approve").on("click", function(e){
     
   }).end().find(".actions-delete").on("click", function(e){
    
   });
    });
}
function approveRejectTimeSheetPopup(stsVal){
		if(stsVal == 'approve'){
			if(confirm("<?php echo __('Are you sure you want to approve the timesheet ?');?>")){
				$("#displayPopupButtons").hide();
				$("#displayPopupLoader").show();
				var user_ids = new Array();
				var getSignleRowRecord = $("#approvers_record_id").val() + "@#$%^" + $("#approvers_user_id").val() + "@#$%^" + $("#approver_id").val()+ "@#$%^" + $("#approve_start_week").val()+ "@#$%^" + $("#approve_end_week").val();
				user_ids.push(getSignleRowRecord);
				$.post(HTTP_ROOT + 'projects/approve_reject_timesheet', {'stsValue': stsVal, 'user_ids': user_ids}, function (data) {
					if(stsVal == "approve"){
						showTopErrSucc('success', 'Selected timesheet(s) approved successfully.');
					}else if(stsVal == "reject"){
						showTopErrSucc('success', 'Selected timesheet(s) rejected successfully.');
					}
          $("#weekClose").trigger('click');
				}, 'json');
			}else{
				return false;
			}
		}else if(stsVal == 'reject'){
			if($(".displayRejectNotePanel").is(":visible") === false){
				$(".displayRejectNotePanel").show();
				$(".scrolltotopclass").animate({ scrollTop: 200 }, "slow");
                                 $("#displayPopupButtons").hide();
                                $("#displayRejectPopupButtons").show();
                               
			}else{
				var rejectNoteVal = $.trim($("#rejectNoteId").val());
				if(rejectNoteVal == ''){
                                    $("#rjctErr").html("Please add a rejection note");
                                    $("#rejectNoteId").focus();
                                    
					//alert("Please add some reject note before rejecting the weekly timesheet");
					return false;
				}else{
					$("#displayPopupButtons").hide();
					$("#displayRejectPopupButtons").hide();
					$("#displayPopupLoader").show();
                                        
					var user_ids = new Array();
					var getSignleRowRecord = $("#approvers_record_id").val() + "@#$%^" + $("#approvers_user_id").val() + "@#$%^" + $("#approver_id").val() + "@#$%^" + rejectNoteVal + "@#$%^" + $("#approve_start_week").val()+ "@#$%^" + $("#approve_end_week").val();
					user_ids.push(getSignleRowRecord);
					$.post(HTTP_ROOT + 'projects/approve_reject_timesheet', {'stsValue': stsVal, 'user_ids': user_ids}, function (data) {
						if(stsVal == "approve"){
							showTopErrSucc('success', 'Selected timesheet(s) approved successfully.');
						}else if(stsVal == "reject"){
							showTopErrSucc('success', 'Selected timesheet(s) rejected successfully.');
						}
            $("#weekClose").trigger('click');
                                    $('#grid-timesheet-settings0').bootgrid('reload');
                                    $("#grid-timesheet-settings2").bootgrid('reload');
					}, 'json');
				}
				
			}
		}
	}
        
        function cancelReject(){
            $("#displayRejectPopupButtons").hide();
            $("#displayPopupButtons").show();
            $(".displayRejectNotePanel").hide();
            $("#rejectNoteId").val('');
        }
        function removeErr(id){
            $("#"+id).html("");
        }
</script>


