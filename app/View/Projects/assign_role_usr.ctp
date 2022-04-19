<?php echo $this->Form->create('ProjectUser', array('url' => '/projects/assignProjectUserRole', 'name' => 'projectuserasgnrole','id'=>'ProjectUserAssignRoleUsrFormuser')); ?>
<div class="row">
  <div class="col-md-12">
    <div class="ad_prj_usr_tbl user_role_modal">
    <input type="hidden" id="adusrprojnm" value="<?php echo $this->Format->formatText($pjname); ?>">
      <p class="user_on_proj"><?php echo __("Project(s) of this"); ?> User</p>
      <table class="table users_no">
                    <tr class="hdr_tr">
          <th class="user_name"><?php echo __("Projects"); ?></th>
          <th><?php echo __("Role"); ?></th>
          <th><?php echo __("Action"); ?></th>
                    </tr>
                    <tr>
          <td colspan="3">
            <div class="role_user_scroll">
              <table class="table asign_role">
                    <?php
                    $userCount = count($memsExstArr);
                    $count = 0;
                    $class = "";
                    $totCase = 0;
                    $totids = "";
                    if ($userCount) {
                        $typ = "";
                        foreach ($memsExstArr as $memsAvlArr) {
                            $project_id = $memsAvlArr['Project']['id'];
                            $project_name = ucfirst($memsAvlArr['Project']['name']);
                            $count++;
                            if ($count % 2 == 0) {
                                $class = "row_col";
                            } else {
                                $class = "row_col_alt";
                            }
                            ?>
                            <tr id="extlisting<?php echo $project_id; ?>" class="rw-cls1 <?php echo $class; ?>"  <?php /* onmouseover="displayDeleteImg('<?php echo $user_id; ?>');" onmouseout="hideDeleteImg('<?php echo $user_id; ?>');" */ ?>>
                              <td <?php echo $class; ?>>
                                    <div class="fl" title="<?php echo $project_name; ?>">
                                        <?php echo $this->Format->shortLength($project_name, 25); ?>
                                    </div>
                                    <div id="deleteImg_<?php echo $project_id; ?>" title="Delete" class="dropdown_cross fr" style="display:none;color:#D4696F;font-weight:bold;cursor:pointer" onclick="deleteUsersInProject('<?php echo $project_id; ?>', '<?php echo $projid; ?>', '<?php echo urlencode($project_name); ?>');">&times;</div>
                                    <div class="cb"></div>
                                </td>
                              <td <?php echo $class; ?>>
                                    <div class="">
                                        <?php echo $this->Form->input('ProjectUser.id.', array('type' => 'hidden', 'value' => $memsAvlArr['ProjectUser']['id'])); ?>
                                         <?php echo $this->Form->input('ProjectUser.user_id.', array('type' => 'hidden', 'value' => $memsAvlArr['User']['id'])); ?>
                                         <?php if($memsAvlArr['CompanyUser']['role_id'] == 699){ ?>
                                            <input type="hidden" name="data[ProjectUser][role_id][]" value = "699">
                                                <span><?php echo __('Guest'); ?></span>
                                        <?php   } else{
                                        echo $this->Form->input('ProjectUser.role_id.', array('value' => $memsAvlArr['0']['role_id'], 'class' => 'form-control select_role_add', 'type' => 'select', 'div' => false, 'label' => false, 'id'=>'ProjectUserRoleId'.$memsAvlArr['ProjectUser']['id'], 'options' => $roles,'onchange'=>'addActionId(this)'));
                                            } ?>    
                                </div>
                                    <div class="cb"></div>
                                </td>
								<td>
                                  <a href="javascript:void(0)" class="actionViewId" data-roleId ="<?php echo $memsAvlArr['0']['role_id']; ?>" data-roleName ="<?php echo $memsAvlArr['0']['role_name']; ?>" onclick="manage_project_role(this,'user')"><i class="material-icons">visibility</i> View<a>
								</td>
                            </tr>
                            <?php
                            $totids.= $project_id . "|";
                            $typ = $user_istype;
                        }
                    } else {
                        ?>
                        <tr>
                          <td colspan="3">
                                <center class="fnt_clr_rd"><?php echo __("No user(s) available."); ?></center>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </td>
    </tr>
</table>
    </div> 
  </div>
</div>
<?php $this->Form->end(); ?>
<input type="hidden" name="hid_cs" id="hid_cs" value="<?php echo $count; ?>"/>
<input type="hidden" name="totid" id="totid" value="<?php echo $totids; ?>"/>
<input type="hidden" name="chkID" id="chkID" value=""/>
<input type="hidden" name="slctcaseid" id="slctcaseid" value=""/>
<input type="hidden" id="getusercount" value="<?php echo $userCount; ?>" readonly="true"/>
<input type="hidden" name="user_id" id="puserId" value="<?php echo $usrid; ?>"/>
<input type="hidden" name="user_name" id="puser_name" value="<?php echo $usrname; ?>"/>
<input type="hidden" name="cntmng" id="cntmng" value="<?php echo $cntmng; ?>"/>
<script>
    $(document).ready(function(){
        $(".select_role_add").select2().on('select2:select', function(evt) {
             $(this).closest('tr').find('.actionViewId').attr('data-roleId', $(this).val());
        });
        
    });
</script>