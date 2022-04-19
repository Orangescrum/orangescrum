<?php
                //}
                if (count($prjAllArr)) {
                    foreach ($prjAllArr as $k => $prjArr) {
                        $totUser = !empty($prjArr[0]['totusers']) ? $prjArr[0]['totusers'] : '0';
                        $totCase = (!empty($prjArr[0]['totalcase'])) ? $prjArr[0]['totalcase'] : '0';
                        $totHours = (!empty($prjArr[0]['totalhours'])) ? $prjArr[0]['totalhours'] : '0';
						$estimatedHours = (!empty($prjArr['Project']['estimated_hours'])) ? $prjArr['Project']['estimated_hours'] : '0';
                        ?>
                            <?php
							//echo "<pre>";
							//print_r($All_status);exit;
                            $prj_name = ucwords(trim($prjArr['Project']['name']));
                            $len = 15;
                            $prj_name_shrt = $this->Format->shortLength($prj_name, $len);
                            $value_format = $this->Format->formatText($prj_name);
                            $value_raw = html_entity_decode($value_format, ENT_QUOTES);
                            $tooltip = '';
                            if (strlen($value_raw) > $len) {
                                $tooltip = $prj_name;
                            }
                            if ($prjArr['Project']['isactive'] == 1 && $prjArr['Project']['status'] == 1) {
                                $sts_txt = __('Started',true);
                            } else if ($prjArr['Project']['isactive'] == 1 && $prjArr['Project']['status'] == 2) {
                                $sts_txt = __('On Hold',true);
                            } else if ($prjArr['Project']['isactive'] == 1 && $prjArr['Project']['status'] == 3) {
                                $sts_txt = __('Stack',true);
                            } else if ($prjArr['Project']['isactive'] == 2) {
                                $sts_txt = __('Completed',true);
                            }else{
															$sts_txt = $All_status[$prjArr['Project']['status']];
														}
                            ?>
														
                        <tr class="row_tr prjct_lst_tr">
                            <td class="text-center">
                                <div class="dropdown">
                                    <div data-toggle="dropdown" class="sett dropdown-toggle" ><i class="material-icons">&#xE5D4;</i></div>
									<?php if(SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3){ ?>
                                    <ul class="dropdown-menu " >
                                        <li class="pop_arrow_new"></li>
                                        <?php if ($projtype == 'active-grid') {
                                            if ($prjArr['Project']['isactive'] == 2) { ?>
                                                <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                                <li><a href="javascript:void(0);" class="icon-grid-enable-prj enbl_prj" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>" data-view="<?php echo $projtype; ?>"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                            <?php } ?>
                                             <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                            <li><a href="javascript:void(0);" class="icon-grid-del-prj del_prj" data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                        <?php } ?>
                                            <?php } else { ?>
											<?php if((SES_TYPE == 1 || SES_TYPE == 2) && !empty($proj_users_list[$prjArr['Project']['id']]) && in_array(SES_ID,$proj_users_list[$prjArr['Project']['id']])){ ?>
                                                <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
												<li class="assgnremoveme<?php echo $prjArr['Project']['uniq_id']; ?>"><a href="javascript:void(0);"  data-prj-uid ="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>" data-prj-usr="<?php echo SES_ID; ?>" onclick="removeMeFromPrj(this);"><i class="account-plus"></i><i class="material-icons">&#xE15C;</i> <?php echo __('Remove me from here');?></a></li>
                                            <?php } ?>
												<?php }else if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
                                                    <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
													<li class="assgnremoveme<?php echo $prjArr['Project']['uniq_id']; ?>"><a href="javascript:void(0);"  data-prj-uid ="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>" data-prj-usr="<?php echo SES_ID; ?>" onclick="assignMeToPrj(this);"><i class="account-plus"></i><i class="material-icons">&#xE147;</i> <?php echo __('Add me here');?></a></li>
												<?php } ?>
                                                <?php } ?>
											<?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>
                                            <li><a href="javascript:void(0);" class="icon-grid-edit-usr " data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>"><i class="material-icons">&#xE254;</i> <?php echo __('Edit');?></a></li>
                                        <?php } ?>
                                            <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                            <li><a href="javascript:void(0);" class="icon-grid-add-usr " data-prj-uid ="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-name="<?php echo $prj_name; ?>" data-prj-usr="<?php echo $prjArr['Project']['user_id']; ?>"><i class="material-icons">&#xE147;</i> <?php echo __('Add User');?></a></li>
                                        <?php } ?>
                                            <?php if (!empty($prjArr[0]['totusers'])) { ?>
                                                 <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                                <li><a href="javascript:void(0);" class="icon-grid-remove-usr" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a></li>
                                            <?php } ?>
                                            <?php } ?>
                                             <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                            <li id="ajax_remove<?php echo $prjArr['Project']['id']; ?>" style="display:none;">
                                                <a href="javascript:void(0);" class="icon-grid-remove-usr" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                            </li>
                                        <?php } ?>
                                            <?php if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
                                                <li>
                                                    <a href="javascript:void(0);" class="icon-assgn-role" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE147;</i><?php echo __("Assign Role");?></a>
                                                </li>
                                            <?php } ?>
                                             
                                            <li><?php if ($prjArr[0]['totalcase']) { ?>
                                                <?php 
												foreach($ProjectStatus as $key=>$val){
												if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){
                                                    if($val !='Completed'){
													?>
                                                    <a href="javascript:void(0);" class="icon-grid-enable-prj change_prj_status" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>" data-prj-status-name="<?php echo $val; ?>" data-prj-status-id="<?php echo $key; ?>"><i class="material-icons">&#xE86C;</i> <?php echo $val;?></a>
													<?php }}}?>
												<a href="javascript:void(0);" class="icon-grid-enable-prj disbl_prj" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>"><i class="material-icons">&#xE86C;</i> <?php echo __('Completed');?></a>
												
                                                <?php } else { ?>
                                                    <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                                    <a href="javascript:void(0);" class="icon-grid-del-prj del_prj" data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                                <?php } ?>
                                                <?php } ?>
                                            </li>
                                        
                                            <?php } } elseif ($projtype == 'inactive-grid') { ?>
                                                <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                            <li><a href="javascript:void(0);" class="icon-grid-enable-prj enbl_prj" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>" data-view="<?php echo $projtype; ?>"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                        <?php } ?>
                                        <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                            <li><a href="javascript:void(0);" class="icon-grid-del-prj del_prj" data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                        <?php } ?>
                                        <?php } ?>
                                    </ul>
									<?php }else{ ?>
							<ul class="dropdown-menu" <?php if(SES_TYPE == 3 && $prjArr['Project']['user_id'] != SES_ID){ ?>onclick="notAuthAlert();"<?php } ?>>
                            <?php if ($projtype == 'active-grid') { 
                                if ($prjArr['Project']['isactive'] == 2 || $prjArr['Project']['status'] == 4) { ?>
                                    <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                    <li><a href="javascript:void(0);"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                <?php } ?>
                                <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                    <li><a href="javascript:void(0);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                <?php } ?>
                                <?php } else { ?>
                                      <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                <li><a href="javascript:void(0);"><i class="material-icons">&#xE147;</i> <?php echo __('Add User');?></a></li>
                            <?php } ?>
                                 <li>
                                    <?php if (!empty($prjArr[0]['totusers'])) { ?>
                                         <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                    <?php } ?>
                                    <?php } ?>
                                </li>
                                 <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                <li style="display:none;">
                                    <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                </li>
                            <?php } ?>
                             <?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>
                                <li><a href="javascript:void(0);"><i class="material-icons">&#xE254;</i> <?php echo __('Edit');?></a></li>
                            <?php } ?>
                                <li>
                                    <?php if ($prjArr[0]['totalcase']) { ?>
									
									      <?php 
										  
										  if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE86C;</i> <?php echo __('Complete');?></a>
                                    <?php }?>
									
									
                                        <?php if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE86C;</i> <?php echo __('Complete');?></a>
                                    <?php }?>
                                    <?php } else { ?>
                                        <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                    <?php } ?>
                                    <?php } ?>
                                </li>
                            <?php } 
								}else { ?>
                                     <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                <li><a href="javascript:void(0);"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a>
								</li>
                            <?php } ?>
                                 <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                <li><a href="javascript:void(0);"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                            <?php } ?>                            
                            <?php } ?>                            
                        </ul>
						
						<?php } ?>
                                </div>
                            </td>
							<?php if ($prjArr['Project']['isactive'] == 1) {
								$prio = $this->Format->getPriority($prjArr['Project']['priority']);
								if($prio =='high'){
									$prio_text = __('High',true);
								}else if($prio =='medium'){
									$prio_text = __('Medium',true);
								}else{
									$prio_text = __('Low',true);
								}
								?>
                            <td align="left"><a class="ttl_listing" id="prj_ttl_<?php echo $prjArr['Project']['uniq_id']; ?>" href="javascript:void(0);" title="<?php echo $tooltip; ?>" onclick="return projectBodyClick('<?php echo $prjArr['Project']['uniq_id']; ?>');"><?php echo $prj_name_shrt; ?>&nbsp;</a><br />
							<span class=" prio_<?php echo $this->Format->getPriority($prjArr['Project']['priority']); ?> prio_lmh prio_gen_prj prio-drop-icon" rel="tooltip" title="<?php echo $prio_text; ?> <?php echo __('Priority');?>"></span> <span style="font-size:12px;"><?php echo $prio_text; ?></span> 
                             <span class="project_role_txt"><?php echo ($prjArr[0]['role'])?$prjArr[0]['role']:$prjArr[0]['crole'];?></span>
                            <br />
							<span style="color:#8d8d8e;font-size:12px;">
								<?php
								$locDT = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $prjArr['Project']['dt_created'], "datetime");
								$gmdate = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
								$dateTime = $this->Datetime->dateFormatOutputdateTime_day($locDT, $gmdate, 'time');
								?>
								<?php echo __('Created by').'  '.$this->Format->formatText($p_u_name[$prjArr['Project']['user_id']]); ?> <?php echo __('on');?> <?php echo $dateTime; ?>
							</span>
							</td>
								<?php } else if ($prjArr['Project']['isactive'] == 2) { ?>
                                    <td align="left"><a class="ttl_listing" id="prj_ttl_<?php echo $prjArr['Project']['uniq_id']; ?>" href="javascript:void(0);" title="<?php echo $tooltip; ?>" onclick="inactiveProjectBodyClick('<?php echo $prjArr['Project']['uniq_id']; ?>');"><?php echo $prj_name_shrt; ?>&nbsp;</a><br />
									<span class=" prio_<?php echo $this->Format->getPriority($prjArr['Project']['priority']); ?> prio_lmh prio_gen_prj prio-drop-icon" rel="tooltip" title="<?php echo ucfirst($this->Format->getPriority($prjArr['Project']['priority'])); ?> <?php echo __('Priority');?>"></span> <span style="font-size:12px;"><?php echo ucfirst($this->Format->getPriority($prjArr['Project']['priority'])); ?></span><br />
                                        <span style="color:#8d8d8e;font-size:12px;">
                                            <?php
                                            $locDT = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $prjArr['Project']['dt_created'], "datetime");
                                            $gmdate = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
                                            $dateTime = $this->Datetime->dateFormatOutputdateTime_day($locDT, $gmdate, 'time');
                                            ?>
            <?php echo __('Created by').'  ' . $this->Format->formatText($p_u_name[$prjArr['Project']['user_id']]); ?> <?php echo __('on');?> <?php echo $dateTime; ?>
                                        </span>
                                    </td>
        <?php } ?>

							<?php if(in_array("Template", $fields)){ ?>
							<td class="text-center"><?php echo (($project_methodology_array[$prjArr['Project']['project_methodology_id']])); ?></td>
                        <?php } ?>
                            <td class="text-center txt_upper_prj"><?php echo (($prjArr['Project']['short_name'])); ?></td>
                            <?php if(in_array("Description", $fields)){ ?>
                            <td title="<?php echo ($this->Format->formatTitle($prjArr['Project']['description'])); ?>"><span class="ellipsis-view" style="display:block;width:150px"><?php echo ($this->Format->formatTitle($prjArr['Project']['description'])); ?></span></td>
                            <?php } ?>
							<?php $start_date = (!empty($prjArr['Project']['start_date']))?$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $prjArr['Project']['start_date'], "date"):'';
                $end_date = (!empty($prjArr['Project']['end_date']))?$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $prjArr['Project']['end_date'], "date"):'';
							$stdate = ($start_date) ? date('d M',strtotime($start_date)) : __("N/A");
							$stdatestamp = ($start_date) ? strtotime($start_date) : 0;
							$endate = ($end_date) ? date('d M',strtotime($end_date)) : __("N/A");
							$endatestamp = ($end_date) ? strtotime($end_date) : 0; ?>
                            <td class="text-center" data-order="<?php echo $stdatestamp;?>"><?php echo $stdate;?></td>
							<td class="text-center" data-order="<?php echo $endatestamp;?>"><?php echo $endate;?></td>
							 <td title="<?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['project_manager'])? $prjmanager_names[$prjArr['ProjectMeta']['ProjectMeta']['project_manager']]:'N/A'; ?>"><span class="ellipsis-view" style="display:block;width:150px"><?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['project_manager'])? $prjmanager_names[$prjArr['ProjectMeta']['ProjectMeta']['project_manager']]:'N/A';; ?></span></td>
                             <?php if($this->Format->isAllowed('Customer Name',$roleAccess)){ ?>
                             <td title="<?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['client'])? $user_list[$prjArr['ProjectMeta']['ProjectMeta']['client']]:'N/A'; ?>"><span class="ellipsis-view" style="display:block;width:150px"><?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['client'])? $user_list[$prjArr['ProjectMeta']['ProjectMeta']['client']]:'N/A';; ?></span></td>
                            <?php } ?>
                            <?php if(in_array("Status", $fields)){ ?>
							<td class="text-center"><?php echo $sts_txt; ?></td>
                            <?php } ?>
                            <?php if(in_array("Status Workflow", $fields)){ ?>
                            <td class="text-center"><?php if($prjArr['Project']['status_group_id']){ echo $csts_arr_grp[$prjArr['Project']['status_group_id']]['name']; }else{ echo __('Default Status Workflow'); } ?></td>
                            <?php } ?>
                            <?php if(in_array("Tasks", $fields)){ ?>
							<?php if ($prjArr['Project']['isactive'] == 2 || $prjArr['Project']['status'] == 4) { ?>
	                            <td class="text-center"><?php echo $totCase; ?></td>
							<?php }else{ ?>
                            <td class="text-center proj_tsks_cnt" onclick="return projectBodyClick('<?php echo $prjArr['Project']['uniq_id']; ?>','tasks');" style="cursor:pointer;"><?php echo $totCase; ?></td>
							<?php } ?>
                            <?php } ?>
                            <?php if(in_array("Users", $fields)){ ?>
                            <td class="text-center"><?php echo!empty($prjArr[0]['totusers']) ? $prjArr[0]['totusers'] : '0'; ?></td>
                            <?php } ?>
                            <!-- <td class="text-center">
																<?php
                                $filesize = 0;
                                if ($totCase && isset($prjArr[0]['storage_used']) && $prjArr[0]['storage_used']) {
                                    $filesize = number_format(($prjArr[0]['storage_used'] / 1024), 2);
                                    if ($filesize != '0.0' || $filesize != '0') {
                                        $filesize = $filesize;
                                    }
                                    $space = $space + $filesize;
                                }
                                echo $filesize;
                                ?>
															</td>  -->
							<td class="text-center"><?php echo $estimatedHours; ?></td>
                            <td class="text-center"><?php echo $totHours > 0 ? $this->format->formatHour($totHours) : $totHours; ?></td>
							<?php if($this->Format->isAllowed('Budget',$roleAccess)){ ?>
                                <?php if(in_array("Budget", $fields)){ ?>
							<td title="<?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['budget'])?$prjArr['ProjectMeta']['ProjectMeta']['budget']:'N/A'; ?>"><span class="ellipsis-view" style="display:block;width:150px"><?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['budget'])?$prjArr['ProjectMeta']['ProjectMeta']['budget']:'0.00'; ?></span></td>
                            <?php  } ?>
                            <?php  } ?>
                            <?php if($this->Format->isAllowed('Cost Appr',$roleAccess)){ ?>
                            <?php if(in_array("Cost Approved", $fields)){ ?>
                            <td title="<?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['cost_appr'])?$prjArr['ProjectMeta']['ProjectMeta']['cost_appr']:'N/A'; ?>"><span class="ellipsis-view" style="display:block;width:150px"><?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['cost_appr'])?$prjArr['ProjectMeta']['ProjectMeta']['cost_appr']:'0.00';; ?></span></td>
                            <?php  } ?> 
                            <?php  } ?>
                            <?php if(in_array("Project Type", $fields)){ ?>
                            <td title="<?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['proj_type'])?$projecttype[$prjArr['ProjectMeta']['ProjectMeta']['proj_type']]:'N/A'; ?>"><span class="ellipsis-view" style="display:block;width:150px"><?php echo !empty($projecttype[$prjArr['ProjectMeta']['ProjectMeta']['proj_type']])?$projecttype[$prjArr['ProjectMeta']['ProjectMeta']['proj_type']]:'N/A'; ?></span></td>
                            <?php  } ?>
                            <?php if(in_array("Industry", $fields)){ ?>
                            <td title="<?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['industry'])?$industries[$prjArr['ProjectMeta']['ProjectMeta']['industry']]:'N/A'; ?>"><span class="ellipsis-view" style="display:block;width:150px"><?php echo !empty($prjArr['ProjectMeta']['ProjectMeta']['industry'])?$industries[$prjArr['ProjectMeta']['ProjectMeta']['industry']]:'N/A'; ?></span></td>
                            <?php  } ?>
                            <?php if(in_array("Last Activity", $fields)){ ?>
                            <td>
																<?php
                                $getactivity = $this->Casequery->getlatestactivitypid($prjArr['Project']['id'], 1);
                                if ($getactivity == "") {
                                    echo __('No activity');
                                } else {
                                    $curCreated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                                    $updated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getactivity, "datetime");
                                    $locDT = $this->Datetime->dateFormatOutputdateTime_day($updated, $curCreated);
                                    echo $locDT;
                                }
                                ?></td>
                            <?php  } ?>
                        </tr>
                    <?php }
                }
                ?>