<?php if ($project_list) { ?>
    <div class="scrl-ovr">
        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover">
            <thead>
                <tr class="head-row">
                    <th>
            <div class="fl checkbox"><label><input type="checkbox" class="chkbx_cur" id="checkAllprojects"/></label></div>
            </th>
            <th style="width:65%;">Name</th>
            <th>Short Name</th>
            <?php if (!$is_invite_user) { ?>
                <th>Email Notification</th>
            <?php } ?>
            </tr>
            </thead>
            <tbody>
                <?php
                $class = "";
                $cscount = 0;
                foreach ($project_list as $prj_lst) {
                    $project_name = $prj_lst['projects']['name'];
                    $project_id = $prj_lst['projects']['id'];
                    $cscount++;
                    if ($cscount % 2 == 0) {
                        $class = "row_col";
                    } else {
                        $class = "row_col_alt";
                    }
                    ?>
                    <tr id="listing<?php echo $cscount; ?>" class="tr_all rw-cls <?php echo $class; ?>">
                        <td>
                            <div class="fl checkbox">
                                <label>
                                    <input type="checkbox" class="chkbx_cur ad-usr-prj removePrjFromuser" id="actionChk<?php echo $cscount; ?>" value="<?php echo $project_id; ?>" data-prj-name="<?php echo trim($prj_lst['projects']['name']); ?>"/>
                                </label>
                            </div>
                            <input type="hidden" id="actionCls<?php echo $cscount; ?>" value="0"/>
                        </td>
                        <td>
                            <div class="rem_proj_usr ellipsis-view" title="<?php echo $prj_lst['projects']['name']; ?>">
                                <?php echo $prj_lst['projects']['name']; ?>
                            </div>
                        </td>
                        <td>
                            <?php echo $prj_lst['projects']['short_name']; ?>
                        </td>
                        <?php if (!$is_invite_user) { ?>
                            <td>
                                <?php /* if ($prj_lst['project_users']['default_email'] == 0) { ?>
                                  <ul class="onoff">
                                  <li class="off"><a href="javascript:void(0)" onclick="setemail(this, 'off', '<?php echo $prj_lst['project_users']['id'] ?>', 'on');">OFF</a></li>
                                  <li><a href="javascript:void(0)" onclick="setemail(this, 'on', '<?php echo $prj_lst['project_users']['id'] ?>', 'off');">ON</a></li>
                                  </ul>
                                  <?php } else { ?>
                                  <ul class="onoff">
                                  <li><a href="javascript:void(0)" onclick="setemail(this, 'off', '<?php echo $prj_lst['project_users']['id'] ?>', 'on');">OFF</a></li>
                                  <li class="on"><a href="javascript:void(0)" onclick="setemail(this, 'on', '<?php echo $prj_lst['project_users']['id'] ?>', 'off');">ON</a></li>
                                  </ul>
                                  <?php } */ ?>   
                                <?php
                                if ($prj_lst['project_users']['default_email'] == 0) {
                                    $checked = "";
                                    $checkedlbl = "OFF";
                                } else {
                                    $checked = "checked='checked'";
                                    $checkedlbl = "ON";
                                }
                                ?>
                                <div class="form-group1">
                                    <div class="togglebutton">
                                        <label class="checkedonofflbl mrg0">
                                            <input class="checkedonoff" type="checkbox" onchange="changeUserNotificationSetting_rmvPorj(this, '<?php echo $prj_lst['project_users']['id'] ?>')" <?php echo $checked; ?>/>
                                            <span class="checkedonoffdisplay"><?php echo $checkedlbl; ?></span>
                                        </label>
                                    </div>
                                </div>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="is_prj"  value="1"/>
    <input type="hidden" id="total_projects"  value="<?php echo $count; ?>"/>
<?php } else { ?>
    <center class="fnt_clr_rd">No project(s) assigned</center>
    <input type="hidden" id="is_prj"  value="0"/>
<?php } ?>
<input type="hidden" id="usrid" name="usrid" value="<?php echo $userid; ?>"/>
<input type="hidden" id="is_invite_user" name="is_invite_user" value="<?php echo $is_invite_user; ?>"/>