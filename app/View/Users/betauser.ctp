<link rel="stylesheet"  type="text/css" href="<?php echo HTTP_ROOT; ?>css/demo_page.css">
<link rel="stylesheet"  type="text/css" href="<?php echo HTTP_ROOT; ?>css/demo_table.css">
<link rel="stylesheet"  type="text/css" href="<?php echo HTTP_ROOT; ?>css/betauser.css">
<script type="text/javascript" src="<?php echo JS_PATH.'datatable.js';?>"></script>
<script type="text/javascript" src="<?php echo JS_PATH.'betauser.js';?>"></script>
<script type='text/javascript'>
var dTable = '';
$('document').ready(function(){
	dTable = $('#example').dataTable({
	"aLengthMenu": [[10, 50, 100], [10,50, 100]],
	"iDisplayLength": 10,
	"iDisplayStart" : 0,
	"aaSorting": [[ 2, "desc" ]],
        "sPaginationType": "full_numbers",
        "bProcessing": true,
	"bServerSide": true,
	"sAjaxSource": "<?php echo HTTP_ROOT.'users/betauser_dtbl';?>",
	"aoColumns": [ 
			//{ "bSortable": false },
			null,
			null,
			null,
			{ "bSortable": false },
               			     
		    ]
	});

/*$("#txt_email").keydown(function(event){
if( e.KeyCode == 13){
          alert("dsgsdgsg");
     }
});
$("#txt_email").keyup(function(e){ 
    var code = e.which; // recommended to use e.which, it's normalized across browsers
    if(code==13){
     //e.preventDefault();
     sendInvitation();
     }
    
});*/

});

</script>    
<table style='width:100%;' cellpadding="0" cellspacing="0">
	<tr>
	<td  valign="left">
		<!--<div onclick="multipleBetauserAction('Approve',0)" id="approvebutton1" disabled="disabled" class="disable_button" style="padding: 3px;">Approve</div>
		<div onclick="multipleBetauserAction('Disapprove',0)" id="disapprovebutton1" disabled="disabled" class="disable_button" style="padding: 3px;">Block</div>-->
	</td> 
	<td align="right" valign="top" style="padding-bottom:2px;">
	
		
		<!--a onclick="newBetaUser('inviteLink','loader_id');" href="javascript:jsVoid();" id="inviteLink" style="display: block;"--><button id="inviteLink" class="green" onclick="newBetaUser('inviteLink','loader_id');">Invite Beta User</button><div class="inv_usr"></div><!--/a-->
		<a style="text-decoration: none; cursor: wait; display: none;" id="loader_id" href="javascript:jsVoid()">Loading...<img width="16" height="16" title="loading..." alt="loading..." src="<?php echo HTTP_ROOT;?>img/images/del.gif"/>
		</a>
		
	</td>
	</tr>
</table>
<table style='margin-left:0px;width:100%;margin-bottom:0px;position:relative' cellpadding="0" cellspacing="0">
	<tr>
		<td  valign="top">
			<div id="tskloader" style="position: fixed; left: 55%; top:40%; display: none; z-index:1;">
				<div class="loadingdata">Loading...</div>
			</div>
			<div id="dt_example" class="dt_beta">
				<div id="container" style="width:100%;border:1px solid #ccc;">
					<table style="margin-left:0px;width:100%;" id="example" class="display tab_dt" cellpadding="3" cellspacing="0">
						<thead>
							<tr>
								<td colspan="11" style="padding:0px;">
									<div class="fr sch_click">&nbsp;</div>							 	
								</td>
							</tr>						

							<tr style="height:29px;" bgcolor="#C9CFD6" class="tophead">
								<!--<th align="left"><input type="checkbox" id="chkall" onclick="selectAll()"/></th>-->
								<th align="left"><?php echo __('Email ID');?></th>
								<th align="left"><?php echo __('Created/Invited By');?></th>
								<th align="left"><?php echo __('Registered At');?></th>
								<!--<th align="left">Status</th>-->
                                        <th align="left">Action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>
				</div>
			</div>
			<div class="inner" style="position: fixed; left: 0pt; top: 0px; width: 100%; display: none;" id="betauser_popup">
				<form accept-charset="utf-8" method="post" name="myform" id="myform" action="/users/betauser" onsubmit="return sendInvitation('txt_email','loader','btn')" >
					<div style="display:none;"><input type="hidden" value="POST" name="_method"></div>  
						<table width="400px" cellspacing="0" cellpadding="0" align="center" style="margin:100px auto;" class="div_pop">
							 <tbody><tr>
								<td valign="middle" class="ms_hd" style="padding-left:10px;">
									<div style="float:left"><h1 class="popup_head" style="margin:0;padding:0;">Invite Beta User</h1></div>
									<div style="float:right;padding-right:5px;"><img style="cursor:pointer" onclick="cover_close('cover','betauser_popup');" title="Close" alt="Close" src="<?php echo HTTP_ROOT;?>img/images/popup_close.png"></div>
								</td>
							</tr>
							 <tr>
								  <td width="100%" align="left" style="padding-left:20px;">
									  <table width="100%" cellspacing="10" cellpadding="10" border="0" align="center">
										  <tbody><tr height="18px">
											  <td></td>
											  <td valign="top" align="left" style="color:#FF0000;">
												  <div style="color:#FF0000;display:none;" id="err_email_new"></div>
											  </td>
										  </tr>
										  <tr>
											   <td valign="top" align="right" class="case_fieldprof">
												  Email:
											  </td>
											  <td align="left"> 
													<!--<textarea style="height:60px;width:340px;color:#000;" id="txt_email" name="data[User][email]"></textarea>&nbsp;-->
													<input type="text" style="height:20px;width:240px;color:#000;" id="txt_email" name="data[User][email]" maxlength="50" />
													<input type="hidden" id="sel_Typ" value="3" name="data[User][istype]">
													<br>
													<!--<i style="font-size:12px;color:#333333">(Invite multiple Email with comma separate)</i>-->
											  </td>
										  </tr>
										  <tr>
												<td align="left">&nbsp;</td>
												<td align="left" style="padding-top:10px">
														<span id="btn_sendInv">
														<input type="hidden" value="20a5d17b63756aa8fceccb745a42cc89" id="uniq_id">
														<button class="blue small" style="margin-top:5px;width:60px" name="addMember" value="Add" type="button" onclick="return sendInvitation('txt_email','loader','btn')"><?php echo __('Send');?></button>
														&nbsp;&nbsp;or&nbsp;&nbsp;
														<a href="javascript:jsVoid();" onclick="cover_close('cover','betauser_popup');"><?php echo __('Cancel');?></a>
													</span>
													<span style="display:none" id="ldr">
														<img width="16" height="16" alt="" src="<?php echo HTTP_ROOT;?>img/images/del.gif">
													</span>
																		</td>
										  </tr>	
										  <tr><td colspan="2">&nbsp;</td></tr>
									  </tbody></table>
				  					</td>
			  					</tr>
						</tbody></table>
				</form>
			</div>
		</td>
	</tr>
</table>
<div style="float:left;text-decoration:underline;font-weight:bold;font-size:13px;">
	<!--<div onclick="multipleBetauserAction('Approve')" id="approvebutton2" disabled="disabled" class="disable_button" style="padding: 3px;">Approve</div>
	<div onclick="multipleBetauserAction('Disapprove')" id="disapprovebutton2" disabled="disabled" class="disable_button" style="padding: 3px;">Block</div>-->
	<div style="clear:both"></div>
</div>
    
