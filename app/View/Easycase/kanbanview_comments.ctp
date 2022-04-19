<style>
    .comment_popup table{height:auto;display:table}
    .comment_popup table th{color:#888;border-bottom:2px solid #ddd}
    .comment_popup table td{color:#888;line-height:30px}
    #prj_btn_edit .btn_cmn_efect{font-size:14px;color:#2d6dc4}

</style>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup('kc');"><i class="material-icons">&#xE14C;</i></button>
            <h4 class="ellipsis-view">
                <span id="header_prj_task_temp"><?php echo __('Latest 5 Comments');?></span>
            </h4>
        </div>
        <div class="modal-body popup-container mtop20">
            <div class="loader_dv_prj"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="<?php echo __('Loading');?>..." /></center></div>
            <div id="inner_project_temp_edit" class="project-templete-pop">
                <center><div id="project_temp_err_edit" class="err_msg" style="margin-top: -32px;position: absolute;"></div></center>
				<?php if($is_client){ ?>
                <span style="font-size: 14px;color: #2983FD;margin-top: -23px;margin-bottom: 18px;display: block;"><?php echo $comments_cnt; ?> comment<?php if($comments_cnt > 1){ ?>s<?php } ?> for you!</span>
				<?php } ?>
                <div class="form-group label-floating task-form-group comment_popup">
                    <table cellpadding="0" cellspacing="0" class="col-lg-12 form-control">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th style ="text-align: left;width:20%" ><?php echo __('User Name');?></th>
                            <th style ="text-align: left;width:50%"><?php echo __('Comment');?></th>
                            <th style ="text-align: left;width:25%"><?php echo __('Date');?> / <?php echo __('Time');?></th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($comment_arr as $skey => $sval) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?> </td>
                                <td class="ellipsis-view" title="<?php echo $sval['username']; ?>"><?php echo $sval['username']; ?> </td>
                                <td><?php echo $sval['comment']; ?> </td>
                                <td><?php echo $sval['date_time']; ?> </td>
                            </tr>
                            <?php $i++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span id="prjtemploader_kanban" style="display:none;">
                    <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="<?php echo __('loading');?>..."/> 
                </span>
                <div id="prj_btn_edit">
                    <span class="fl hover-pop-btn">
                        <a href="javascript:void(0)" id="btn_edit_project_template" class=" btn_cmn_efect cmn_bg cmn_size" onclick='redirectMore("<?php echo $uid1; ?>")'><?php echo __('View More');?></a>
                    </span>
                    <div class="cb"></div>
                </div>
                <div class="cb"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function redirectMore(caseUniqId){
    // var url1 = HTTP_ROOT + 'dashboard#details/' + caseUniqId;
    closePopup();
    easycase.ajaxCaseDetails(caseUniqId,'case',0,'popup');
    // window.location.href = url1;
    }
    function boldAdvise(src) {
    var comment = $(src).attr('data-value');
    src.title = comment;
    return;
    }
</script>