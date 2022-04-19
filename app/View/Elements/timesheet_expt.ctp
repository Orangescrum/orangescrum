<div class="modal-dialog gts_report_pop">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><?php echo __('Generate Timesheet Report');?></h4>
        </div>
        <div class="modal-body">
            <form action="<?php HTTP_ROOT;?>logTimes/createAndDownloadReport" method="post" id="tspdf" />
            <figure class="timesheet_img">
                <img src="<?php echo HTTP_ROOT."img/"?>timesheet_report.png" alt="" width="" height="">
            </figure>
             <div class="txtfld_blk pr">
                <label><?php echo __('Resource name');?></label>
                <select id="select-expt-resource" placeholder="<?php echo __('All Resource');?>"  name="usrid">                    
                </select>  
                <div class="loader_bg_inline_expt" style="top:42px;right:13px;"> 
                    <div class="loadingdata"><img src="<?php echo HTTP_ROOT; ?>img/images/del.gif" alt="loading..." title="<?php echo __('loading');?>..."/></div>
               </div>
            </div>
            <div class="txtfld_blk pr">
                <label><?php echo __('Project name');?></label>
                <select id="select-expt-proj" placeholder="<?php echo __('Select Project');?>" multiple></select> 
								<input type="hidden" value="" name="project" id="hidden_project_id" />
                <div class="loader_bg_inline_expt_project" style="top:42px;right:13px;"> 
                    <div class="loadingdata"><img src="<?php echo HTTP_ROOT; ?>img/images/del.gif" alt="loading..." title="<?php echo __('loading');?>..."/></div>
               </div>
            </div>
           
            <div>
                <div class="pull-left calender">
                    <div class="txtfld_blk">
                        <label><small><?php echo __('Starting Date');?></small></label>
                        <input type="text" id="expt_startDate" readonly="readonly" name="start_date" onchange="changeBtnDisable();" />
                    </div>
                </div>
                <div class="pull-right calender">
                    <div class="txtfld_blk">
                        <label><small><?php echo __('Ending Date');?></small></label>
                        <input type="text" id="expt_endDate" readonly="readonly" name="end_date" onchange="changeBtnDisable();" />
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </form>
        </div>
        <div class="modal-footer">
            <div class="col-md-4">
                <button onclick="printTimesheet();" class="print_report" disabled ><?php echo __('Print');?></button>
                <div class="prnttmlog" style="top:0px;right:50px;"> 
                    <div class="loadingdata"><img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/></div>
				</div>
            </div>
            <div class="col-md-4">
                <button class="download_report" disabled onclick="downloadTimesheet();" ><?php echo __('Download');?></button>
                <div class="dnldtmlog" style="top:0px;right:50px;"> 
                    <div class="loadingdata"><img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/></div>
               </div>
            </div>
            <div class="col-md-4">
                <a href="javascript:vioid(0)" data-dismiss="modal"><?php echo __('Cancel');?></a>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<script>
 $(function () {
    $selectP = $('#select-expt-proj').selectize();
    $selectR = $('#select-expt-resource').selectize();
    $("#expt_startDate").val(moment("YYYY-MM-DD").startOf('week').format('MMM DD, YYYY'));
    $("#expt_endDate").val(moment().add(6, 'days').format('MMM DD, YYYY'));
    $("#expt_startDate").datepicker({
        format: 'M d, yyyy',
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        autoclose: true
    }).on("changeDate", function(selectedDate) {
        var dateText = $("#expt_startDate").datepicker('getFormattedDate');
       
        var day1 = $("#expt_startDate").datepicker('getDate').getDate();                 
        var month1 = $("#expt_startDate").datepicker('getDate').getMonth() + 1;             
        var year1 = $("#expt_startDate").datepicker('getDate').getFullYear();
        var fullDate = year1 + "-" + month1 + "-" + day1;
        var day_in_month  = 6;//moment(fullDate, "YYYY-MM-DD").daysInMonth();
        var lastDateText = moment(fullDate, "YYYY-MM-DD").add(day_in_month, 'days').format('MMM DD, YYYY');
        $('#expt_endDate').val(lastDateText);
        
        //$("#expt_endDate").datepicker("setStartDate",dateText);
        $("#expt_endDate").datepicker("setEndDate",lastDateText);
    });
    $("#expt_endDate").datepicker({
        format: 'M d, yyyy',
        changeMonth: false,
        changeYear: false,
        hideIfNoPrevNext: true,
        maxDate: "0D",
        autoclose: true
    }).on("changeDate", function(selectedDate) {
        var dateText = $("#expt_endDate").datepicker('getFormattedDate');
        
        var day1 = $("#expt_endDate").datepicker('getDate').getDate();                 
        var month1 = $("#expt_endDate").datepicker('getDate').getMonth() + 1;             
        var year1 = $("#expt_endDate").datepicker('getDate').getFullYear();
        var fullDate = year1 + "-" + month1 + "-" + day1;
        var day_in_month  = 6;//moment(fullDate, "YYYY-MM-DD").daysInMonth();
        var lastDateText = moment(fullDate, "YYYY-MM-DD").subtract(day_in_month, 'days').format('MMM DD, YYYY');
        $('#expt_startDate').val(lastDateText);
        
        //$("#expt_startDate").datepicker("setEndDate", dateText);
        //$("#expt_startDate").datepicker("setStartDate",lastDateText);
        
    });
    var selectizeControlR = $selectR[0].selectize;
    var selectizeControlP = $selectP[0].selectize;
    selectizeControlR.on('change', function() {
      changeBtnDisable();  
      var test = selectizeControlR.getValue();
      selectizeControlP.disable();
       if(test != ''){
          $(".loader_bg_inline_expt_project").show();
          $.post('<?php echo HTTP_ROOT;?>LogTimes/showAllProjects',{'user_id':test},function(res){
              $(".loader_bg_inline_expt_project").hide();
              for (pi in res.Projects) {
                if (res.Projects[pi].name != '') {
                           selectizeControlP.addOption({value:res.Projects[pi].id,text:res.Projects[pi].name});
                           selectizeControlP.enable();
                           //selectizeControlP.addItem(res.Projects[pi].id);
                }
            }
          },'json'); 
       }
    });
});
function downloadTimesheet(){    
    var startDT = $("#expt_startDate").val();
    var endDT = $("#expt_endDate").val();
    
    var selectizeR = $('#select-expt-resource').get(0).selectize;
    var currentR = selectizeR.getValue(); 
    if(currentR == ''){
        showTopErrSucc('error', "<?php echo __('Please select a resource');?>");
        return false;
    }
    if(startDT == '' || startDT == 'Invalid date'){
        showTopErrSucc('error', "<?php echo __('Please select the start date');?>");
        return false;
    }
    if(endDT == '' || endDT == 'Invalid date'){
        showTopErrSucc('error', "<?php echo __('Please select the end date');?>");
        return false;
    }
    var selectizeP = $('#select-expt-proj').get(0).selectize;
    var currentp = selectizeP.getValue(); 
    $(".dnldtmlog").show();
    $(".download_report").hide();
		$('#hidden_project_id').val('');
	$(".print_report").hide();
    $('#caseLoader').show();
    $.post("<?php echo HTTP_ROOT.'logTimes/checkLogAvailable';?>",{usrid:currentR,start_date:startDT,end_date:endDT,project:currentp,comp:SES_COMP},function(res){
        $(".dnldtmlog").hide();
        $(".download_report").show();
		$(".print_report").show();        
        if(res.msg !='error'){
						$('#hidden_project_id').val(currentp);
            $("#tspdf")[0].submit();
            setTimeout(function(){$('#caseLoader').hide();},2000);
            closeExpert(); 
        }else{
            $('#caseLoader').hide();
           showTopErrSucc('error', "<?php echo __('No Timelog found in this date range. Please check another date range');?>");  
        }
    },'json');
      
}
function printTimesheet(){
    var startDT = $("#expt_startDate").val();
    var endDT = $("#expt_endDate").val();
    
    var selectizeR = $('#select-expt-resource').get(0).selectize;
    var currentR = selectizeR.getValue(); 
    if(currentR == ''){
        showTopErrSucc('error', "<?php echo __('Please select a resource');?>");
        return false;
    }
    
    if(startDT == '' || startDT == 'Invalid date'){
        showTopErrSucc('error', "<?php echo __('Please select the start date');?>");
        return false;
    }
    if(endDT == '' || endDT == 'Invalid date'){
        showTopErrSucc('error', "<?php echo __('Please select the end date');?>");
        return false;
    }
    var selectizeP = $('#select-expt-proj').get(0).selectize;
    var currentp = selectizeP.getValue();     
    $(".prnttmlog").show();
    $(".print_report").hide();
	$(".download_report").hide();
    $('#caseLoader').show();
    $.post("<?php echo HTTP_ROOT.'logTimes/checkLogAvailable';?>",{usrid:currentR,start_date:startDT,end_date:endDT,project:currentp,comp:SES_COMP},function(res){
        $(".prnttmlog").hide();        
        $(".print_report").show();
		$(".download_report").show();
        if(res.msg !='error'){   
            setTimeout(function(){$('#caseLoader').hide();},1000);    
            var oHiddFrame = document.createElement("iframe");
            oHiddFrame.onload = setPrint;
            oHiddFrame.style.visibility = "hidden";
            oHiddFrame.style.position = "fixed";
            oHiddFrame.style.right = "0";
            oHiddFrame.style.bottom = "0";
            oHiddFrame.src = '<?php echo HTTP_ROOT."logTimes/timesheetPDF?usrid="?>'+currentR+'&start_date='+startDT+'&end_date='+endDT+'&project='+currentp+'&comp='+SES_COMP;
            document.body.appendChild(oHiddFrame);
            closeExpert();
        }else{
            $('#caseLoader').hide();
            showTopErrSucc('error', "<?php echo __('No Timelog found in this date range. Please check another date range');?>");
        }
    },'json');

}
function closePrint () {
  document.body.removeChild(this.__container__);
}

function setPrint () {  
  this.contentWindow.__container__ = this;
  this.contentWindow.onbeforeunload = closePrint;
  this.contentWindow.onafterprint = closePrint;
  this.contentWindow.focus(); // Required for IE
  this.contentWindow.print();
}
function closeExpert(){
    $(".prnttmlog").hide();
    $(".print_report").show();
    $(".dnldtmlog").hide();
    $(".download_report").show();
    
    $("#myModal").modal('hide');
    $("#expt_startDate").val(moment().format('MMM DD, YYYY'));
    $("#expt_endDate").val(moment().add(6, 'days').format('MMM DD, YYYY'));
    var selectizeP = $('#select-expt-proj').get(0).selectize;
    selectizeP.clear();
    var selectizeR = $('#select-expt-resource').get(0).selectize;
    selectizeR.clear();
}
 function changeBtnDisable(){
    var startDT = $("#expt_startDate").val();
    var endDT = $("#expt_endDate").val();
    
    var selectizeR = $('#select-expt-resource').get(0).selectize;
    var currentR = selectizeR.getValue(); 
    if(currentR == '' || startDT == '' || endDT == ''){
      $(".print_report").prop('disabled', true);
      $(".download_report").prop('disabled', true);
    }else{
      $(".print_report").prop('disabled', false);
      $(".download_report").prop('disabled', false);
    }
 }
</script>