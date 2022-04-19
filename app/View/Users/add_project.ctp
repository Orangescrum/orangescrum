<style>
  /* Aurobinda */
  tr.head-row.bg-graycolor {background-color: #F1F1F1;}
  .fl.width-55-per.tbl-border,
  .fr.width-40-per.tbl-border{background: #FFFFFF 0% 0% no-repeat padding-box; padding:20px 6px;border: 1px solid #C5C5C5;border-radius: 12px;opacity: 1;}
  .fl.width-55-per.tbl-border,
  .fr.width-40-per.tbl-border {height: 400px;}
  ul.holder li.bit-box, #apple-list ul.holder li.bit-box {padding:8px!important; margin:0!important;width: 100%;}  
  .table > tbody > tr > td.td-pad-top-only {padding: 0;}
  .cmn-popup .modal-content .modal-body {padding: 10px 24px 30px;}
  #prjList {padding: 0;}
  .fl.width-30.btn_style{border: 1px solid #C5C5C5;border-radius: 6px;padding: 0px !important; margin: 0 0 20px !important;}
  .fl.width-30.btn_style .form-group .form-control {margin-bottom: 0;background: none;}
  .fl.width-30.btn_style .form-group {padding: 0px 10px !important; margin:6px 0 !important;}
  .fl.width-30.btn_style {width: 54% !important;}  
  .form-group .material-icons {padding-right: 6px;}
  span#prjpopupload1 {position: absolute;top: 320px;left: 240px;} 
  input#proj_name::placeholder {font-size: 17px;}
  /* ========== */
    </style>
<input type="hidden" id="userpopupname" value="<?php echo $this->Format->formatText($name); ?>">
<!-- <div class="fl nap-tab"> -->
<div class="fl width-55-per tbl-border">
        <span id="prjpopupload1" class="ldr-ad-btn"><?php echo __('Loading projects');?>... <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" title="Loading..." alt="Loading..."/></span>
        <table cellpadding="0" cellspacing="0" class="table table-hover m-btm0" style="">
            <thead>
                <tr>
                    <th class="" colspan="3" style=""><?php echo __('Not assigned Project(s)');?></th>
                </tr>
            </thead>
            <tbody>
                <tr class="head-row bg-graycolor">
                    <td class="td-1st">
                        <div class="checkbox">
                            <label>
                                <input <?php if ($prj_count) { ?>style="display:block;"<?php } else { ?>style="display:none;"<?php } ?> type="checkbox" class="chkbx_cur" id="checkAllAddPrj"/>
                            </label>
                        </div>
                    </td>
                    <td class="td-2nd"><?php echo __('Name');?></td>
                    <td class="td-3rd"><?php echo __('Short Name');?></td>
                </tr>
            </tbody>
        </table>
        <div class="scrl-ovr">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover">
            <tbody>
                <?php
                $count = 0;
                $class = "";
                $pre_count = 0;
                if ($prj_count) {
                    foreach ($project_name as $prj_nm) { 
                        $pre_chk = 0;
                        if (isset($selected_pjids) && array_key_exists($prj_nm['projects']['id'], $selected_pjids)) {
                            $pre_chk = 1;
                            $pre_count++;
                        }
                        $project_id = $prj_nm['projects']['id'];
                        $project_name = ucfirst($prj_nm['projects']['name']);
                        $count++;
                        if ($count % 2 == 0) {
                            $class = "row_col";
                        } else {
                            $class = "row_col_alt";
                        }
                        ?>
                        <tr id="listing<?php echo $count; ?>" class="tr_all rw-cls nap <?php echo $class; ?>" style="<?php if ($pre_chk) { ?>display:none;<?php } ?> <?php if($prj_nm['projects']['isactive'] ==2){ echo "background: green; "; }?>" >	
                            <td>
                                <input type="hidden" id="actionCls<?php echo $count; ?>" value="0"/>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" class="chkbx_cur ad-usr-prj AddPrjToUser" id="actionChk<?php echo $count; ?>" value="<?php echo $project_id; ?>" data-prj-name="<?php echo urlencode(trim($project_name)); ?>" <?php if ($pre_chk) { ?> checked="checked" <?php } ?>/>
                                    </label>
                                </div>
                            </td>
                            <td style="<?php echo $class; ?>;  <?php if($prj_nm['projects']['isactive'] ==2){ echo "color:#FFF;"; }?>">
                                <div class="non_assn_proj ellipsis-view" title="<?php echo ucfirst($prj_nm['projects']['name']); ?>">
                                    <?php echo ucfirst($prj_nm['projects']['name']); ?>
                                </div>
                            </td>
                            <td  style="<?php echo $class; ?>;  <?php if($prj_nm['projects']['isactive'] ==2){ echo "color:#FFF;"; }?>">
                                <?php echo $prj_nm['projects']['short_name']; ?>
                            </td>
                        </tr>
                    <?php } ?>
                    <?php if ($pre_count == $count) { ?>
                        <tr class="no-proj_tr"><td colspan="3"><center class="fnt_clr_rd"><?php echo __('No project(s) available');?>.</center></td></tr>
                    <script> $('#checkAllAddPrj').hide();</script>
                <?php } ?>
            <?php } else { ?>
                <tr class="no-proj_tr"><td colspan="3"><center class="fnt_clr_rd"><?php echo __('No project(s) available');?>.</center></td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- <div class="fr ap-tab"> -->
<div class="fr width-40-per tbl-border">
        <table cellpadding="0" cellspacing="0" class="table table-hover ap-table m-btm0 mright10">
            <thead>
                <tr>
                    <th class="" colspan="3"><?php echo __('Assigned Project(s)');?></th>
                </tr>
            </thead>
            <tbody>
                <tr class="head-row bg-graycolor" id="">
                    <td><?php echo __('Name');?></td>
                </tr>
            </tbody>
        </table>
        <div class="scrl-ovr">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover ap-table">
            <tbody>
                <tr class="nap">
                    <td class="td-pad-top-only">
                        <ul id="prjList" class="holder" style="">
                            <?php
                            $selected_count = 0;
                            if (isset($selected_pjids)) {
                                foreach ($selected_pjids as $uk => $uv) {
                                    $selected_count = 1; ?>
                                    <li id="<?php echo $uk; ?>" rel="7" class="bit-box instant_select_proj" >
                                        <div class="existing_assn_proj ellipsis-view" title="<?php echo ucfirst($prj_nm['projects']['name']); ?>">
                                            <?php echo $uv; ?>
                                        </div>
                                        <a onclick="removeProjectName(\'<?php echo $uk; ?>\',\'selected\',\'#checkAllAddPrj\',\'.AddPrjToUser\',\'.tr_all\',\'tr_active\');" href="javascript:void(0);" id="close<?php echo $uk; ?>" class="closebutton"></a>
                                    </li>
                                <?php } ?>
                             <?php } ?>
                        </ul>
                    </td>
                </tr>
                <?php
                $count = 0;
                $class = "";
                if ($exst_prj_count) {
                    foreach ($exists_project_name as $exprj_nm) {
                        //$project_id = $exprj_nm['projects']['id'];
                        //$project_name = ucfirst($exprj_nm['projects']['name']);
                        $count++;
                        if ($count % 2 == 0) {
                            $class = "row_col";
                        } else {
                            $class = "row_col_alt";
                        }
                        ?>
                        <tr id="extlisting_<?php echo $exprj_nm['projects']['id']; ?>" class="tr_all rw-cls nap exst_projs <?php echo $class; ?>"  onmouseover="displayDeleteImg('<?php echo $exprj_nm['projects']['id']; ?>');" onmouseout="hideDeleteImg('<?php echo $exprj_nm['projects']['id']; ?>');">	
                            <td style="<?php echo $class; ?>">
                                <div class="fl existing_assn_proj ellipsis-view" title="<?php echo $exprj_nm['projects']['short_name']; ?>">
                                    <?php echo ucfirst($exprj_nm['projects']['name']); ?>
                                </div>
                                <a id="deleteImg_<?php echo $exprj_nm['projects']['id']; ?>" title="Delete" class="fr hidden-delete" onclick="deleteAssignedProject('<?php echo $exprj_nm['projects']['id']; ?>', '<?php echo $usrid; ?>', '<?php echo urlencode($exprj_nm['projects']['name']); ?>', '<?php echo $is_invite_user; ?>');"><i class="material-icons">&#xE14C;</i></a>
                                <div class="cb"></div>
                            </td>
                        </tr>
                    <?php } ?>
                <?php } else { ?>
                    <tr class="no-extproj_tr" <?php if ($selected_count) { ?> style="display:none;"<?php } ?>>
                        <td colspan="3"><center class="fnt_clr_rd"><?php echo __('No project(s) assigned');?>.</center></td>
                    </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>


<input type="hidden" id="user_id" name="user_id" value="<?php echo $usrid; ?>"/>
<input type="hidden" id="is_invite_user" name="is_invite_user" value="<?php echo $is_invite_user; ?>"/>
<input type="hidden" id="count" name="count" value="<?php echo $count1; ?>"/>
<script type="text/javascript">
    $(document).ready(function() {
        window.onbeforeunload = function() {
            if ($('#prjList li').length) {
                return '<?php echo __('Please save your changes before leaving this page.');?>';
            }
        };
    });
</script>
