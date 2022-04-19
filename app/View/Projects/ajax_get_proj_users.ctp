<?php
$extusers = $rem_mem_ids = $uname_string = '';
foreach ($post_data['user_data']['users'] as $key => $value) {
    $extusers .= $value.", ";
    $rem_mem_ids .= $key.",";
    $uname_string .= $key."@@@".$value.",";
}
$extusers = rtrim($extusers, ', ');
$rem_mem_ids = rtrim($rem_mem_ids, ',');
$uname_string = rtrim($uname_string, ',');
$rem_page = !empty($post_data['page']) ? $post_data['page'] : '';
$rem_obj_class = !empty($post_data['el_class']) ? $post_data['el_class'] : '';
?>

<div class="scrl-ovr">
    <?php
    $cscount = 0;
    $class = "";
    $totCase = 0;
    $totids = "";
    ?>
    <?php if (!empty($memsExtArr['Member']) || !empty($memsExtArr['Invited']) || !empty($memsExtArr['Disabled'])) { ?>
        <span id="hid_ext_use_lbl"  style="display: none;"><?php echo $extusers;?> <?php echo __(' has open tasks. Assign these tasks to others or left them unassigned');?></span>
        <input type="hidden" id="rem_mem_ids" name="rem_mem_ids" value="<?php echo $rem_mem_ids;?>">
        <input type="hidden" id="rem_mem_id_wn" name="rem_mem_id_wn" value="<?php echo $uname_string;?>">
        <input type="hidden" id="rem_src_pjid" name="rem_src_pjid" value="<?php echo $pjid;?>">
        <input type="hidden" id="rem_page_src" name="rem_page_src" value="<?php echo $rem_page;?>">
        <input type="hidden" id="rem_obj_class" name="rem_obj_class" value="<?php echo $rem_obj_class;?>">
        <div class="radio radio-primary">
            <label style="color:#888;"><input type="radio" name="data[AssignUser][value]" value="0" checked="checked"/><?php echo __('Leave unassigned');?></label>
        </div>
        <table cellpadding="0" cellspacing="0" class="table table-striped table-hover asgn-task-users">
            <thead>
                <tr class="head-row">
            <th></th>
            <th><?php echo __('Name');?></th>
            <th><?php echo __('Short Name');?></th>
            <th><?php echo __('Email');?></th>
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
                        
                        <tr id="listing<?php echo $cscount; ?>" class="rw-cls">
                            <td class="td-1st <?php if ($v1['CompanyUser']['user_type'] == 1 && SES_TYPE != 1) { ?>disabletoptab<?php } ?>">
                                <div class="radio radio-primary">
                                    <label><input type="radio" name="data[AssignUser][value]" value="<?php echo $user_id; ?>"/></label>
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
                        <div class="radio radio-primary">
                            <label><input type="radio" name="data[AssignUser][value]" value="<?php echo $user_id; ?>"/></label>
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
                        <div class="radio radio-primary">
                            <label><input type="radio" name="data[AssignUser][value]" value="<?php echo $user_id; ?>"/></label>
                        </div>
                        </td>
                        <td class="td-2nd">
                            <?php echo $this->Format->formatText($user_email); ?>
                        </td>
                        <td class="td-3rd"></td>
                        <td class="td-4th"></td>
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