<?php if($GLOBALS['user_subscription']['subscription_id'] == CURRENT_EXPIRED_PLAN){ ?>
<div class="common-user-overlay"></div>
<div class="common-user-overlay-btn">
<p><?php echo __('This feature is only available to the paid users');?>! <a href="<?php echo HTTP_ROOT.'pricing' ?>"><?php echo __('Please Upgrade');?></a></p>
</div>
<?php } ?>
<link rel="stylesheet" type="text/css" href="<?php HTTP_ROOT; ?>css/fullcalendar/fullcalendar.css"/>
<?php /*<link rel="stylesheet" type="text/css" href="/css/fullcalendar/fullcalendar.print.css"/>*/?>

<?php 
$t_clr = Configure::read('PROFILE_BG_CLR'); 
$random_bgclr = $t_clr[array_rand($t_clr,1)];
?>
<script src='<?php HTTP_ROOT; ?>js/fullcalendar/fullcalendar.min.js' type="text/javascript"></script>
<script type="text/javascript">
	var bgclr = '<?php echo $random_bgclr; ?>';
	$(document).ready(function() {
	        var strURL = HTTP_ROOT + "easycases/";		
		var url = strURL+"getTaskList";
		var current_url = '';
		var new_url     = '';
		var date = new Date();
		var d = date.getDate();
		var m = date.getMonth();
		var y = date.getFullYear();               
		var calendar = $('#calendar').fullCalendar({
			header: { 
				left: 'prev,next today',
				center: 'title',
				right: 'month,agendaWeek' /*,agendaDay*/
			},
			selectable: true,
			selectHelper: true,
          allDayDefault: false,
          disableResizing: true,
          events: function(start, end, callback) {
			    $('.fc-button-today').text('Today');			        
			    $('.fc-button-month').text('Month');
			    $('.fc-button-agendaWeek').text('Week');
			    $('.fc-button-agendaDay').text('Day');
			    var year = end.getFullYear();
			    var month = end.getMonth();
                if($('.fc-button-agendaWeek').hasClass('fc-state-active')){month = month+1;}
			    var s_year = start.getFullYear();
			    var s_month = start.getMonth();
            //console.log(month+'----'+year+'---'+s_year+'----'+s_month);
			    var type ='calendar';
			    new_url  = url;
			    //if( new_url != current_url ){
				//{"projFil":projFil,"projIsChange":projIsChange,"casePage":casePage,'caseStatus':caseStatus,'customfilter':customfilter,'caseTypes':caseTypes,'priFil':priFil,'caseMember':caseMember,'caseAssignTo':caseAssignTo,'caseSearch':caseSearch,'case_srch':case_srch,'case_date':case_date,'case_due_date':case_due_date,'morecontent':'','milestoneUid':milestone_uid}
				var params = parseUrlHash(urlHash);
				var milestone_uid = $('#milestoneUid').val();
				if(params[1]){
					milestone_uid = params[1];
					$('#milestoneUid').val(params[1]);
					if(($('#caseMenuFilters').val() =='milestone') || ($('#caseMenuFilters').val()=='milestonelist'))
						$('#refMilestone').val($('#caseMenuFilters').val());
				}
				$('#select_view div').tipsy({gravity:'n', fade:true});
				var globalkanbantimeout =null;var morecontent ='';

				if(type =='calendar'){
					//crt_popup_close();
					$('#select_view div').removeClass('disable');
					$('#calendar_btn').addClass('disable');
					easycase.routerHideShow('calendar');
					$("#caseMenuFilters").val('calendar');
					//$(".menu-cases").addClass('active');
					$(".menu-files").removeClass('active');
					$(".menu-milestone").removeClass('active');
					//$("#brdcrmb-cse-hdr").html('Tasks');
				}	
				var strURL = HTTP_ROOT+"easycases/";
				var casePage = $('#casePage').val(); // Pagination
				//if(morecontent){
					//$('#loader_'+morecontent).show();
				//}else{
					$('#caseLoader').show();
				//}
				var projFil = $('#projFil').val(); 
				var projIsChange = $('#projIsChange').val(); 
				var customfilter = $('#customFIlterId').value;//Change case type
				var caseStatus = $('#caseStatus').val(); // Filter by Status(legend)
				var priFil = $('#priFil').val(); // Filter by Priority
				var caseTypes = $('#caseTypes').val(); // Filter by case Types
				var caseLabel = $('#caseLabel').val(); // Filter by case Label
				var caseMember = $('#caseMember').val();  // Filter by Member
				var caseAssignTo = $('#caseAssignTo').val();  // Filter by AssignTo
				var caseSearch = $('#case_search').val(); // Search by keyword
				var case_date = $('#caseDateFil').val(); // Search by Date
				var case_due_date = $('#casedueDateFil').val(); // Search by Date
				var case_srch = $('#case_srch').val();
				var caseId = document.getElementById('caseId').value; // Close a case
				var strURL = HTTP_ROOT + "easycases/";
				var tskURL = strURL+"getTaskList";
				$.post(tskURL,{"from_view_year":s_year,"from_view_month":s_month,"to_view_year":year,"to_view_month":month,"projFil":projFil,"projIsChange":projIsChange,"casePage":casePage,'caseStatus':caseStatus,'customfilter':customfilter,'caseTypes':caseTypes,'caseLabel':caseLabel,'priFil':priFil,'caseMember':caseMember,'caseAssignTo':caseAssignTo,'caseSearch':caseSearch,'case_srch':case_srch,'case_date':case_date,'case_due_date':case_due_date,'morecontent':'','milestoneUid':milestone_uid},function(res){
					if(res=='NA'){window.location = HTTP_ROOT + 'dashboard#tasks';}
				    $('#caseLoader').hide();
				    callback(res);
					$('.fc-button-month').attr({'title':'Month View','rel':'tooltip'}).tipsy({gravity:'s',html: true });
					$('.fc-button-agendaWeek').attr({'title':'Week View'}).tipsy({gravity:'e',html: true });
          $('.fc-button-today').attr({'title':'Today','rel':'tooltip'}).tipsy({gravity:'s',html: true });
				},'json');				
			   //}else{
			      // console.log(user_events);
			       //callback(user_events);
			   //}
			},
			select: function(start, end, allDay) {	
				var check = $.fullCalendar.formatDate(start,'yyyy-MM-dd');
				var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd');
				if(check < today)
				{
				    return false;
				}
				else
				{
					var year = start.getFullYear();
					var month = start.getMonth();
					month_t = eval(month+1);
					var date = start.getDate();
					var dayArr = ['Sun','Mon','Tues','Weds','Thurs','Fri','Sat'];
					var monthArr = ['Jan','Feb','Mar','Apr','May','June','July','Aug','Sept','Oct','Nov','Dec'];
					gDueDate = 0;
                                        setSessionStorage('Task List Calendar Page', 'Create Task');
					<?php if($this->Format->isAllowed('Create Task',$roleAccess)){ ?>
          creatask('', '', '', '', monthArr[month]+' '+date+', '+year);                                
					<?php } ?>                              
					$('#CS_due_date').val(month_t+'/'+date+'/'+year);
					$('#date_dd').html(monthArr[month]+' '+date+', '+dayArr[start.getDay()]);
					$('#opt3').parent().removeClass('option-toggle').addClass('option-toggle_active');
					$('#date_dd').css('font-weight','bold');
				}
			},
			eventClick: function(calEvent, jsEvent, view) {
				$("#myModalDetail").modal();
				$(".task_details_popup").show();
        		$(".task_details_popup").find(".modal-body").height($(window).height() - 170);
       		 	$("#cnt_task_detail_kb").html("");
			    //console.log(calEvent);
			    //editask(calEvent.caseUniqId,calEvent.ProjectUniqId,calEvent.projectName);
			    easycase.ajaxCaseDetails(calEvent.caseUniqId, 'case', 0, 'popup');
			},
			eventRender: function(event, element) {
			    var addition = '';
			    var prj_typ = $('#projFil').val();
			    if(prj_typ == 'all')
					addition = "<div style='float:left' class='ellipsis-view_cal'> <b>("+event.projectSortName+")</b> #"+event.case_no+": </div>"+event.title;
			    else
					addition = " #"+event.case_no+": "+event.title;
                    
			    if(event.photo != undefined && event.photo != ''){
						element.find(".fc-event-title").before("<div style='float:left'><img rel='tooltip' src='"+HTTP_ROOT+"users/image_thumb/?type=photos&file="+event.photo+"&sizex=26&sizey=26&quality=100' class='round_profile_img' height='26' width='26' title='Assigned to: "+event.name+"'/></div>");
				//element.prev(".fc-day-number").css( "background-color", "red" );
			    }else{
					var first_letter_uname = event.name.charAt(0);
					element.find(".fc-event-title").before("<div style='float:left'><span class='cmn_profile_holder "+event.profile_bg_colr+"' title='Assigned to: "+event.name+"'>"+first_letter_uname+"</span></div>");
					//element.prev(".fc-day-number").css( "background-color", "red" );				
			    }
			    /*element.find('.fc-event-title').attr('title',event.original_title);*/
				element.find('.fc-event-time').css('display','none');
				addition = addition.replace(/\\'/g, "'");
				addition = addition.replace(/\\"/g, '"');
				element.find('.fc-event-title').html(addition);
				element.find('.fc-event-title').addClass('case_sub_task');
			    /*var clrCod = '';
			    if(event.legend == 1){ //new
				clrCod = '#DB7F6D';
			    }else if(event.legend == 5){ //resolved
				clrCod = '#EFA05F';
		            }else if(event.legend == 3){ //closed
				clrCod = '#78B07D';
			    }else{ //Wip
				clrCod = '#658FD3';
			    }*/
				var clrCod = event.clrCod;
			    if(clrCod != ''){
				    element.find('.fc-event-inner').parent().css('border','2px solid '+clrCod);
				    element.find('.fc-event-inner').css('background-color',clrCod);
			    }			    
			    $('[rel=tooltip]').tipsy({gravity:'s', fade:true});
			},
            eventDragStart: function(event, jsEvent, ui, view){
                
            },
			eventDrop: function( event, dayDelta, minuteDelta, allDay, revertFunc, jsEvent, ui, view ) { 
                    //console.log(view.name)
                    //var dt_created = $.fullCalendar.formatDate(new Date(event.actual_dt_created),'yyyy-MM-dd HH:mm:ss');
                    var dt_created = event.actual_dt_created;
                    if(view.name == 'month'){
			    var check = $.fullCalendar.formatDate(event.start,'yyyy-MM-dd');
			    var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd');
                        dt_created = dt_created.split(' ');
                        dt_created = dt_created[0];
                    }else{
                    var check = $.fullCalendar.formatDate(event.start,'yyyy-MM-dd HH:mm:ss');
                        var today = $.fullCalendar.formatDate(new Date(),'yyyy-MM-dd HH:mm:ss');
                    }
                    var time = $.fullCalendar.formatDate(event.start,'HH:mm:ss');
			    var arr = ['5','3'];
                    //console.log(check+' < '+today+' < '+dt_created+' >> '+(check < today)+' || '+(check < dt_created));
                    if((check < today) || (check < dt_created) || ($.inArray(event.legend,arr) != -1)){
					revertFunc();
			    }else{
                        //console.log('Okay');return false;
				//if (confirm("Are you sure you want to change the Due Date?")) {			       
				   var s_year = event.start.getFullYear();
				   var s_month = event.start.getMonth();
				   var s_date = event.start.getDate();
				   s_month = eval(s_month+1);
				   var sdate = s_year+'-'+s_month+'-'+s_date;				   
				   var edate = (event.end != null)?event.end.getFullYear()+'-'+eval(event.end.getMonth()+1)+'-'+event.end.getDate():sdate;
				   //return false;
				   var strURL = HTTP_ROOT + "easycases/";
				   var updURL = strURL+"updateDueDate";
				   var text ='';
				   date = s_month+'/'+s_date+'/'+s_year;    
				   $.post(HTTP_ROOT+"easycases/ajax_change_DueDate",{"caseId":event.caseId,"duedt":edate,"startdt":sdate,"text":text,"time":time},function(data) {
						if(data.success == 'No'){
							showTopErrSucc('error',data.message);
							revertFunc();	
						}else{
						 if (data.isAssignedUserFree != 1) {
                            var estimated_hr = Math.floor(data.task_details.Easycase.estimated_hours / 3600);
                            openResourceNotAvailablePopup(data.task_details.Easycase.assign_to, data.task_details.Easycase.gantt_start_date, data.task_details.Easycase.due_date, estimated_hr, data.task_details.Easycase.project_id, data.task_details.Easycase.id, data.task_details.Easycase.uniq_id, data.isAssignedUserFree);
                        }
							 // $('#calendar').fullCalendar('removeEventSource', event);
						  //    $('#calendar').fullCalendar('addEventSource', event);
						  //    $('#calendar').fullCalendar('refetchEvents');
						     //$("#calendar").fullCalendar("reinitView");
						}

				   },'json');				   
				   /*$.post(updURL,{'date':date,'uniq_id':event.caseUniqId},function(res){
				       //console.log(res);
				    },'json');*/
				/*}else{
				   revertFunc();
				}*/
			    }
			},
			editable: true
			//eventColor: '#378006'
		    });		    
	});

</script>
<div id='calendar'></div>
