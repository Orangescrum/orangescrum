<div class="scrl-ovr">
    <?php
    $cscount = 0;
    $class = "";
    $totCase = 0;
    $totids = "";
    ?>
    <?php if (!empty($memsExtArr['Member']) || !empty($memsExtArr['Invited']) || !empty($memsExtArr['Disabled'])) { ?>

        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover">
            <thead>
                <tr class="head-row">
                    <th><div class="fl checkbox"><label><input type="checkbox" value="1" class="chkbx_cur" onclick="selectremuserAll(1, 0)" id="remcheckAll"/></label></div></th>
            <th><?php echo __('Name');?></th>
            <th><?php echo __('Short Name');?></th>
            <th><?php echo __('Email');?></th>
            <th><?php echo __('Email Notification');?></th>
            </tr>
            </thead>
            <tbody>

                <?php if (!empty($memsExtArr['Member'])) { ?>
                    <?php foreach ($memsExtArr['Member'] as $v1) { ?>
                        <?php
                        $user_id = $v1['User']['id'];
                        $user_email = $v1['User']['email'];
                        $user_name = $v1['User']['name'];
                        $user_shortName = $v1['User']['short_name'];
                        $user_istype = $v1['User']['istype'];
                        $cscount++;
                        ?>
                        <tr id="listing<?php echo $cscount; ?>" class="rw-cls 12346">
                            <td class="td-1st <?php if ($v1['CompanyUser']['user_type'] == 1 && SES_TYPE != 1) { ?>disabletoptab<?php } ?>">
                                <div class="fl checkbox <?php if ($v1['CompanyUser']['user_type'] == 1 && SES_TYPE != 1) { ?>custom-checkbox<?php } ?>">
                                    <label>
                                        <?php if ($v1['CompanyUser']['user_type'] == 1 && SES_TYPE != 1) { ?>
                                            <input type="checkbox" class="chkbx_cur" id="usCheckBox<?php echo $cscount; ?>" value="<?php echo $user_id; ?>" checked="checked" disabled="disabled"/>
                                        <?php } else { ?>
                                            <input type="checkbox" class="chkbx_cur rem-usr-prj" id="usCheckBox<?php echo $cscount; ?>" value="<?php echo $user_id; ?>" data-usr-name="<?php echo trim($user_name); ?>" onclick="selectremuserAll(0,<?php echo $cscount; ?>);" />
                                            <input type="hidden" id="actionCls<?php echo $cscount; ?>" value="0"/>
                                        <?php } ?>
                                    </label>
                                </div>
                            </td>
                            <td class="td-2nd">
                                <?php
                                $show_name = trim($user_name) != '' ? ucfirst($this->Format->formatText($user_name)) : $this->Format->formatText($user_email);
                                ?>
                                <span title="<?php echo trim($show_name); ?>" rel="tooltip">
                                    <?php echo $this->Text->truncate($show_name, 16, array('ellipsis' => '...', 'exact' => true)); ?>
                                </span>
                                <?php
                                $usr_typ_name = '';
                                if ($v1['CompanyUser']['user_type'] == 1) {
                                    $colors = 'color:Green';
                                    $usr_typ_name = __('Owner',true);
                                } else if ($v1['CompanyUser']['user_type'] == 2) {
                                    $colors = 'color:Red';
                                    $usr_typ_name = __('Admin',true);
                                } else if ($v1['CompanyUser']['user_type'] == 3 && $role != 3) {
                                    
                                }

                                if ($v1['CompanyUser']['is_active'] == 0) {
                                    $colors = 'color:Blue';
                                    $usr_typ_name = __('Invited',true);
                                }
                                ?>
                                <span style="font-size: 13px;<?php echo $colors; ?>">&nbsp;&nbsp;&nbsp;<?php echo $usr_typ_name; ?></span>
                            </td>
                            <td class="td-3rd">
                                <div class="fl short-name"><?php echo strtoupper($user_shortName); ?></div>
                            </td>
                            <td class="td-4th">
                                <span title="<?php echo trim($user_email); ?>" rel="tooltip">
                                    <?php echo $this->Text->truncate($user_email, 35, array('ellipsis' => '...', 'exact' => true)); ?>
                                </span>

                            </td>
                            <td class="td-5th" style="width:20%;">
                                <div class="form-group1">
                                    <div class="togglebutton">
                                        <label class="checkedonofflbl mrg0">
                                            <?php /* if ($v1['ProjectUser']['default_email'] == 0) { ?>
                                              <ul class="onoff">
                                              <li class="off" ><a href="javascript:void(0)" onclick="setemail(this, 'off', '<?php echo $v1['ProjectUser']['id'] ?>', 'on');">OFF</a></li>
                                              <li><a href="javascript:void(0)" onclick="setemail(this, 'on', '<?php echo $v1['ProjectUser']['id'] ?>', 'off');">ON</a></li>
                                              </ul>
                                              <?php } else { ?>
                                              <ul class="onoff">
                                              <li ><a href="javascript:void(0)" onclick="setemail(this, 'off', '<?php echo $v1['ProjectUser']['id'] ?>', 'on');">OFF</a></li>
                                              <li class="on"><a href="javascript:void(0)" onclick="setemail(this, 'on', '<?php echo $v1['ProjectUser']['id'] ?>', 'off');">ON</a></li>
                                              </ul>
                                              <?php } */ ?>   
                                            <?php
                                            if ($v1['ProjectUser']['default_email'] == 0) {
                                                $checked = "";
                                                $checkedlbl = "OFF";
                                            } else {
                                                $checked = "checked='checked'";
                                                $checkedlbl = "ON";
                                            }
                                            ?>
                                            <input class="checkedonoff" type="checkbox" onchange="changeUserNotificatioSetting(this, '<?php echo $v1['ProjectUser']['id'] ?>')" <?php echo $checked; ?>>
                                            <span class="checkedonoffdisplay"><?php echo $checkedlbl; ?></span>
                                        </label>
                                    </div>
                                </div>

                            </td>

                        </tr>

                    <input type="hidden" id="allcases" name="allcases" value="<?php echo $cscount; ?>"/>
                <?php } ?>
            <?php } ?>

            <?php if (!empty($memsExtArr['Disabled']) || !empty($memsExtArr['Invited'])) { ?>

                <?php
                foreach ($memsExtArr['Disabled'] as $v2) {
                    $user_id = $v2['User']['id'];
                    $user_email = $v2['User']['email'];
                    $user_name = $v2['User']['name'];
                    $user_shortName = $v2['User']['short_name'];
                    $user_istype = $v2['User']['istype'];
                    $cscount++;
                    ?>
                    <tr id="disabledlist<?php echo $cscount; ?>" class="disable-cls">	
                        <td class="td-1st">
                            <div class="fl checkbox">
                                <label>
                                    <input type="checkbox" class="chkbx_cur rem-usr-prj" id="usDisCheckBox<?php echo $cscount; ?>" value="<?php echo $user_id; ?>" data-usr-name="<?php echo trim($user_name); ?>" onclick="selectremuserAll(0,<?php echo $cscount; ?>);" />
                                </label>
                            </div>
                        </td>
                        <td class="td-2nd">
                            <?php echo $this->Format->formatText($user_name); ?>
                        </td>
                        <td class="td-3rd">
                            <?php echo strtoupper($user_shortName); ?>
                        </td>
                        <td class="td-4th">
                            &nbsp;&nbsp;&nbsp; <span><?php echo $this->Format->formatText($user_email); ?></span>
                        </td>
                        <td class="td-5th">
                            <?php
                            $usr_typ_name = '';
                            if ($v2['CompanyUser']['is_active'] == 0) {
                                $colors = 'color:#DD4D4B';
                                $usr_typ_name = 'Disabled';
                            }
                            ?>
                            <span style="<?php echo $colors; ?>"><?php echo $usr_typ_name; ?></span>
                        </td>
                    </tr>
                <?php } ?>
                <?php
                foreach ($memsExtArr['Invited'] as $v) {

                    $user_id = $v['User']['id'];
                    $user_email = $v['User']['email'];
                    $user_istype = $v['User']['istype'];
                    $cscount++;
                    if ($cscount % 2 == 0) {
                        $class = 'border-bottom:1px solid #FFFFFF';
                    } else {
                        $class = "border-bottom:1px solid #FFFFFF";
                    }
                    ?>
                    <?php
                    if ($v['UserInvitation']['is_active'] == 1) {
                        $colors = 'color:Blue';
                        $usr_typ_name = __('Invited',true);
                    }
                    ?>
                    <tr id="Invitedlisting<?php echo $cscount; ?>" class="invited-cls">	
                        <td class="td-1st">
                            <div class="fl checkbox">
                                <label>
                                    <input type="checkbox" class="chkbx_cur rem-usr-prj" id="usInvCheckBox<?php echo $cscount; ?>" value="<?php echo $user_id; ?>" data-usr-name="<?php echo trim($user_email); ?>" onclick="selectremuserAll(0,<?php echo $cscount; ?>);" />
                                </label>
                            </div>
                        </td>
                        <td class="td-2nd">
                            <?php echo $this->Format->formatText($user_email); ?>
                        </td>
                        <td class="td-3rd"></td>
                        <td class="td-4th"></td>
                        <td class="td-5th">
                            <span style="<?php echo $colors; ?>">&nbsp;&nbsp;&nbsp;<?php echo $usr_typ_name; ?></span>
                        </td>
                    </tr>
                <?php } ?>	
            <?php } ?>
            </tbody>
        </table>
        <input type="hidden" id="is_users"  value="1"/>
    <?php } else { ?>
        <center class="fnt_clr_rd"><?php echo __('No match found');?>.</center>
        <input type="hidden" id="is_users"  value="0"/>
    <?php } ?>
    <input type="hidden" id="pjid" name="pjid" value="<?php echo $pjid; ?>"/>
</div>