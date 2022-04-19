<link href="<?php echo HTTP_ROOT; ?>/favicon.ico" type="image/x-icon" rel="icon" />
<link href="<?php echo HTTP_ROOT; ?>/favicon.ico" type="image/x-icon" rel="shortcut icon" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link rel="stylesheet" href="<?php echo HTTP_ROOT; ?>/css/print.css" type="text/css" media="print" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/bootstrap-material-design.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/ripples.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/jquery.dropdown.css?v=850" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/custom.css?v=850" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/jquery-ui.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/datepicker/bootstrap-datepicker.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/selectize.default.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/bootstrap-datetimepicker.css"  />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/fcbkcomplete.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/pace-theme-minimal.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/prettyPhoto.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/jquery.timepicker.css" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/wick_new.css?v=850" />
<link rel="stylesheet" type="text/css" href="<?php echo HTTP_ROOT; ?>/css/pdf.css" />
<script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/moment.js" defer="defer">
</script><script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/datepicker/bootstrap-datepicker.min.js" defer="defer">
</script><script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/angular.min.js">
</script><script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/angular-route.js">
</script><script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/angular-sanitize.js">
</script><script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/angular-animate.js">
</script><script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/jquery.autogrowtextarea.min.js" defer="defer"></script>


<script type="text/javascript">
    if (typeof jQuery == 'undefined') {
        document.write(unescape("%3Cscript src='<?php echo HTTP_ROOT; ?>/js/jquery-1.10.1.min.js' type='text/javascript'%3E%3C/script%3E"));
        document.write(unescape("%3Cscript src='<?php echo HTTP_ROOT; ?>/js/jquery-migrate-1.2.1.min.js' type='text/javascript'%3E%3C/script%3E"));
    }
</script>

<style type="text/css">  
    @media all and (-ms-high-contrast:none) {
        .rht_content_cmn {padding-top:100px;}          
    }
@media print and (color) {
   * {
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
   }
}
@media print {
   .wrap_title_txt a{display:block;white-space:inherit !important}
}
</style>
<script type="text/javascript" src="<?php echo HTTP_ROOT; ?>/js/jquery-ui-1.10.3.js" defer></script>
<div class="task_listing" style="padding:0px;margin:0px;">
    <div>
        <table class="table table-striped table-hover">      
            <tbody>
                <tr class="list-dt-row my_qt_row_selct">  
                    <td colspan="9" style="text-align:center;">    
                        <div class="dt_cmn_mc "> 
                            <span><h4><?php echo __('Task List');?> - <?php echo $pdf_proj_name; ?></h4></span>    
                        </div>   
                    </td>     
                </tr>
                <tr>
                    <td class="tsk_due_dt" width="7%"><b><?php echo __('Date');?></b></td>
                    <td width="30%"><b>#&nbsp;<?php echo __('Title');?></b></td>       
                    <td style="text-align:right;"><b><?php echo __('Assigned to');?></b></th>       
                    <td class="width_priority"><b><?php echo __('Priority');?></b></td>       
                    <td class="width_update text-center"><b><?php echo __('Updated');?></b></td>       
                    <td class="width_status text-center"><b><?php echo __('Status');?></b></td>
                    <td class="tsk_due_dt"><b><?php echo __('Due Date');?></b></td>     
                </tr> 
                <?php foreach($resCaseProj['caseAll'] as $key => $val){?>
                <tr class="row_tr tr_all trans_row " id="curRow5269578">      
                    <td> <?php echo $val['Easycase']['updted']; ?></td>
                    <td class="wrap_title_txt">
                        <div style="word-wrap: break-word;"><a href="#">#<?php echo $val['Easycase']['case_no']; ?>&nbsp;&nbsp;<?php echo $val['Easycase']['title']; ?></a></div>       
                        <div class="task_dependancy fr">     
                        </div>   
                        <div class="list-td-hover-cont">   
                            <span class="created-txt">
                                <?php echo ($val['Easycase']['case_count'] > 0)? __("Updated by")." ":__("Created by")." "; ?> <?php echo $user_list[$val['Easycase']['user_id']]." ".__('on')." ".$val['Easycase']['updtedCapDt']; ?>
                                </span>   
                            <span class="list-devlop-txt dropdown">    
                                <a class="dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" data-target="#">     
                                    <span id="showUpdStatus5269578" class="clsptr" title="<?php echo __('Enhancement');?>">      
                                        <span class="tsktype_colr" id="tsktype5269578"><?php echo $type_list[$val['Easycase']['type_id']]; ?><span class="due_dt_icn"></span></span>
                                    </span></a><span id="typlod5269578" class="type_loader">     
                                    <img src="<?php echo HTTP_ROOT; ?>img/images/del.gif" alt="Loading..." title="Loading...">    </span>                                          
                        </div> 
                    </td> 
                    <?php 
                    $grp_icons='';
                    if($val['Easycase']['format']!=1 && $val['Easycase']['format']!=1){
                    
                    }else{
                        $grp_icons.='<i class="glyphicon glyphicon-paperclip"></i> ';
                    }?>
                    
                    <?php $grp_icons.=$val['Easycase']['case_count'];?>
                    <td class="attach-file-comment wrap_assign_txt" data-task="7d178ec5b15b04dedfa5a8bd3be8e119" id="kanbancasecount1" style="cursor:pointer;">  
                        <?php echo !empty($val['Easycase']['case_count'])?$grp_icons.'&nbsp;<span class="glyphicon glyphicon-comment"></span>':'';?>&nbsp;&nbsp;&nbsp;
                        <span id="showUpdAssign5269578" data-toggle="dropdown" title="" class="clsptr" onclick="displayAssignToMem('5269578', '6d34d1472838d0330f3a24ed1c7756d8', '42920', '7d178ec5b15b04dedfa5a8bd3be8e119', ' ', ' ', '0')">
                            <span><?php echo !empty($user_list[$val['Easycase']['assign_to']])?$user_list[$val['Easycase']['assign_to']]:"Unassigned";?></span>
                            <span class="due_dt_icn"></span>                              
                        </span>      
                                                
                    </td>  
                    <td class="text-center task_priority csm-pad-prior-td">      
                        <div style="" id="pridiv5269578" data-priority="<?php echo $val['Easycase']['priority'];?>" class="pri_actions  dropdown">    
                        <div class="dropdown cmn_h_det_arrow lmh-width">
                            <div class="quick_action" data-toggle="dropdown" style="cursor:pointer">
                                <?php if($val['Easycase']['priority']==0) {?>
                                <span class=" prio_high prio_lmh prio_gen prio-drop-icon" rel="tooltip" original-title="Priority:high"></span>
                                <?php }else if($val['Easycase']['priority']==1) {?>
                                <span class=" prio_medium prio_lmh prio_gen prio-drop-icon" rel="tooltip" original-title="Priority:medium"></span>
                                <?php }else{ ?>
                                <span class=" prio_low prio_lmh prio_gen prio-drop-icon" rel="tooltip" original-title="Priority:low"></span>
                                <?php } ?>
                            </div>    
                        </div>     
                        </div>      
                    </td> 
                    <td class="text-center" title="<?php echo $val['Easycase']['fbstyle']; ?>">
                        <?php echo $val['Easycase']['fbstyle'];                    
                        ?> 
                    </td> 
                    <td>  
					<?php if($val['Easycase']['custom_status_id']){ ?>
						<span id="csStsRep1" class="">
							<span class="label" style="background:#<?php echo $val['Easycase']['CustomStatus']['color']; ?>"><?php echo $val['Easycase']['CustomStatus']['name'];?></span>
						</span>
					<?php }else{ ?>
						<?php if(in_array($val['Easycase']['legend'],['2','4','6'])){ ?>
						<span id="csStsRep1" class=""><span class="label wip label-info fade-blue"><?php echo __('In Progress');?></span></span> 
						<?php }else if($val['Easycase']['legend']==1){ ?>
						<span id="csStsRep17" class=""><span class="label new label-danger fade-red"><?php echo __('New');?></span></span> 
						<?php }else if($val['Easycase']['legend']==3){ ?>
						<span id="csStsRep16" class=""><span class="label closed label-success fade-green"><?php echo __('Closed');?></span></span> 
						<?php }else if($val['Easycase']['legend']==5){ ?>
						<span id="csStsRep12" class=""><span class="label resolved label-warning fade-orange"><?php echo __('Resolved');?></span></span>
						<?php } ?>
					<?php } ?>                       
                    </td>
                    <td class="due_dt_tlist">  
                        <div class="">    
                            <span class="show_dt" id="showUpdDueDate5269578">
                               <?php echo $val['Easycase']['csDueDate']; ?>
                            </span>    
                        </div>  
                        <div class="overdueby_spn overdueby_spn_5269578"></div> 
                    </td>  
                </tr>      
                <?php } ?>
            </tbody>     
        </table>  
    </div>
</div>