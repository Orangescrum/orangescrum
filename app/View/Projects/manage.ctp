<style>
    .proj_created_by {height: 36px;overflow-x: auto;}
	.proj_user_thumb_heit {height: 40px;overflow-y: auto;overflow-x: hidden;}
	.usr_cnts ul li span.cnt_usr, span.cnt_usr {display:inline;}
	.cmn_profile_holder.project_user_ov {height: 32px;width: 32px;margin-right: 3px;}
	.usr_cnts ul li span.cnt_ttl_usr.project_tasks:hover, .usr_cnts ul li span.cnt_usr.project_tasks:hover {color:#2d6dc4;text-decoration:underline;}
	/*.tsk_storage  li:hover .project_tasks {color:#2d6dc4;text-decoration:underline;}*/
	.project_tasks:hover, .project_tasks span:hover {text-decoration:underline;}
	.card_view_box .usr_top_cnt .project_tasks:hover,.card_view_box .usr_top_cnt li:hover , ,.card_view_box .usr_top_cnt p:hover {text-decoration:underline;color:#F6911D}
	.txt_upper_prj {text-transform: uppercase;}
	.top_projn h3 {color:#1A73E8}
	.card_view_box .usr_top_cnt .title_short_name h3 a {color:#1A73E8}
	.project_block .card_view_box .dropdown-menu {max-height: 270px;overflow-y: auto;}
</style>
<?php $project_methodology_array = $methodologies;//Configure::read('PROJECT_TYPE'); ?>
<div class="proj_grids">
    <?php
    $srch_res = '';
    if (isset($_GET['project']) && trim($_GET['project']) && isset($prjAllArr[0]['Project']) && !empty($prjAllArr[0]['Project'])) {
        if ($prjAllArr[0]['Project']['name']) {
            $srch_res = ucfirst($prjAllArr[0]['Project']['name']);
        } else {
            $srch_res = $prjAllArr[0]['Project']['short_name'];
        }
    }

    $active_url = HTTP_ROOT . 'projects/manage';
    $inactive_url = $active_url . '/inactive';
    if ($projtype == '') {
        $grid_url = $active_url . '/active-grid';
        $cookie_value = 'active-grid';
    } elseif ($projtype == 'inactive') {
        $grid_url = $active_url . '/inactive-grid';
        $cookie_value = 'inactive-grid';
    }
    if (isset($_GET['proj_srch']) && trim($_GET['proj_srch'])) {
        $srch_res = $proj_srch = $_GET['proj_srch'];
        $active_url .="?proj_srch=" . $proj_srch;
        $inactive_url .="?proj_srch=" . $proj_srch;
        $grid_url .="?proj_srch=" . $proj_srch;
    }
    ?>
    <?php if(trim($srch_res)){ ?>
    <div class="cmn_search_result cmn_bdr_shadow">
        <div class="global-srch-res fl"><?php echo __('Search Results for');?>: <span><?php echo $srch_res;?></span></div>
        <div class="fl global-srch-rst">
            <a href="<?php echo HTTP_ROOT.'projects/manage';?>"><i class="material-icons">&#xE8BA;</i></a></a>
        </div>
        <div class="cb"></div>
    </div>
    <?php } ?>
    <?php $count=0; $clas = ""; $space = 0;	$spacepercent=0; $totCase = 0; $totHours = '0.0';?>
    <div class="cb"></div>
    <div class=" prj_div">
        <?php /*<div class="loader_bg_new" id="projectLoader">
            <div class="loader-wrapper md-preloader md-preloader-warning"><svg version="1.1" height="48" width="48" viewBox="0 0 75 75"><circle cx="37.5" cy="37.5" r="25" stroke-width="4"></circle></svg>
					</div>
        </div> */ ?>				
				<div class="loader_bg" id="projectLoader"> 
					<div class="loadingdata">
						<img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="<?php echo __('loading');?>..."/>
					</div>
				</div>				
        <div class="m-cmn-flow">
            <div class="usrs_page proj_card project_block m-list-tbl">
        <?php if (count($prjAllArr)) {?>
            <?php $chk_tour = 0; foreach ($prjAllArr as $k => $prjArr) {?>
                <?php
                $totUser = !empty($prjArr[0]['totusers']) ? $prjArr[0]['totusers'] : '0';
                $totCase = (!empty($prjArr[0]['totalcase'])) ? $prjArr[0]['totalcase'] : '0';
                $totHours = (!empty($prjArr[0]['totalhours'])) ? $prjArr[0]['totalhours'] : '0';
                $sts_cls = '';
                $start_date = (!empty($prjArr['Project']['start_date']))?$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $prjArr['Project']['start_date'], "date"):'';
                $end_date = (!empty($prjArr['Project']['end_date']))?$this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $prjArr['Project']['end_date'], "date"):'';
                ?>
                <?php
                $prj_name = ucwords(trim($prjArr['Project']['name']));
                $len = 20;
                $prj_name_shrt = $this->Format->shortLength($prj_name, $len);
                $value_format = $this->Format->formatText($prj_name);
                $value_raw = html_entity_decode($value_format, ENT_QUOTES);
                $tooltip = '';
                if (strlen($value_raw) > $len) {
                    $tooltip = $prj_name;
                }
                if ($prjArr['Project']['status'] == 1) {
                    $sts_cls = 'started';
                    $sts_txt = __('Started',true);
                    $sts_icon = '<i class="material-icons">&#xE885;</i>';
                } else if ($prjArr['Project']['status'] == 2) {
                    $sts_cls = 'on-hold';
                    $sts_txt = __('On Hold',true);
                    $sts_icon = '<i class="material-icons">&#xE052;</i>';
                } else if ($prjArr['Project']['status'] == 3) {
                    $sts_cls = 'stack';
                    $sts_txt = __('Stack',true);
                    $sts_icon = '<i class="material-icons">&#xE53B;</i>';
                }else{
									$sts_cls = 'stack';
									$sts_txt = $All_status[$prjArr['Project']['status']];
									$sts_icon = '<i class="material-icons">card_travel</i>';
								}
                if ($prjArr['Project']['isactive'] == 2 || $prjArr['Project']['status'] == 4) {
                    $sts_cls = 'completed';
                    $sts_txt = __('Completed',true);
                    $sts_icon = '<i class="material-icons">&#xE86C;</i>';
                }
                ?>
                <?php
                $total_progress = $prjArr['Project']['estimated_hours'] > 0 ? ROUND(((($prjArr['0']['totalhours'] / 3600) / $prjArr['Project']['estimated_hours']) * 100), 2) : 0;
                $clr = 'red';
                $progress = intval($total_progress);
                if ($progress > 30 && $progress < 60) {
                    $clr = 'orange';
                } else if ($progress >= 60) {
                    $clr = 'green';
                }
                $tothrs = ($prjArr['0']['totalhours'] / 3600);
                if ($prjArr['Project']['estimated_hours'] == 0.0) {
                    $title = "No Estimated Hours";
                } else if ($tothrs > $prjArr['Project']['estimated_hours']) {
                    $remaining = ($tothrs - $prjArr['Project']['estimated_hours']);
                    $title = $remaining . " ".__('hours exceeded',true);
                } else {
                    $remaining = ($prjArr['Project']['estimated_hours'] - $tothrs);
                    $title = $remaining . " ".__("hours remaining",true);
                }
				$title = 'Overall Progress';
                ?>
                <?php
                $filesize = 0;
                if ($totCase && isset($prjArr[0]['storage_used']) && $prjArr[0]['storage_used']) {
                    $filesize = number_format(($prjArr[0]['storage_used'] / 1024), 2);
                    if ($filesize != '0.0' || $filesize != '0') {
                        $filesize = $filesize;
                    }
                    $space = $space + $filesize;
                }
                ?>
                <?php
                $getactivity = $this->Casequery->getlatestactivitypid($prjArr['Project']['id'], 1);
                if ($getactivity == "") {
                    $last_activity = __('No activity',true);
                } else {
                    $curCreated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");
                    $updated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $getactivity, "datetime");
                    $locDT = $this->Datetime->dateFormatOutputdateTime_day($updated, $curCreated);
                    $last_activity = '' . $locDT;
                }
                ?>
				<div class="usr_mcnt card_view_box fl cmn_bdr_shadow pr cmn_overflow <?php if($projtype == 'inactive' || $projtype == 'inactive-grid') { ?>inactv<?php } ?>"
				style="cursor:default;" data-prjuid="<?php echo $prjArr['Project']['uniq_id']; ?>">
                    <div class="fl triangle-topright-sts <?php echo $sts_cls; ?>"><?php echo $sts_txt; ?></div>
					<div class="usr_top_cnt">
						<?php if ($prjArr['Project']['isactive'] == 1) { ?>
							<span <?php if(!$chk_tour){ ?>id="tour_proj_prio"<?php  } ?> class=" prio_<?php echo $this->Format->getPriority($prjArr['Project']['priority']); ?> prio_lmh prio_gen_prj prio-drop-icon" rel="tooltip" title="<?php echo ucfirst($this->Format->getPriority($prjArr['Project']['priority'])); ?> <?php echo __('Priority');?>"></span> 
						<?php } else if ($prjArr['Project']['isactive'] == 2) { ?>
							<span <?php if(!$chk_tour){ ?>id="tour_proj_prio"<?php  } ?> <?php if(!$chk_tour){ ?>id="tour_proj_prio"<?php  } ?>  class=" prio_<?php echo $this->Format->getPriority($prjArr['Project']['priority']); ?> prio_lmh prio_gen_prj prio-drop-icon" rel="tooltip" title="<?php echo ucfirst($this->Format->getPriority($prjArr['Project']['priority'])); ?> <?php echo __('Priority');?>"></span> 
						<?php } ?>
						<div <?php if(!$chk_tour){ ?>id="tour_proj_sts" <?php  } ?> title="<?php echo $sts_txt;?>" class="<?php echo $sts_cls;?>"><?php echo $sts_icon ;?>
                            <span class="project_role_txt prtop8" title="<?php echo __('Role');?>"><?php echo ($prjArr[0]['role'])?$prjArr[0]['role']:$prjArr[0]['crole'];?></span>

                        </div>
                        <div class="usr_act_det" <?php if(!$chk_tour){ ?>id="tour_proj_actn"<?php  } ?>>
                            <span class="dropdown">
                                <a class="dropdown-toggle active" data-toggle="dropdown" data-target="#">
                                    <i class="material-icons">&#xE5D4;</i>
                                </a>
						<?php if(SES_TYPE == 1 || SES_TYPE == 2 || SES_TYPE == 3){ ?>
							<?php //if(SES_TYPE == 1 || SES_TYPE == 2 || (SES_TYPE == 3 && $prjArr['Project']['user_id'] == SES_ID)){ ?>
                            <ul class="dropdown-menu">
                            <?php if ($projtype == '') { 
                                if ($prjArr['Project']['isactive'] == 2 || $prjArr['Project']['status'] == 4) { ?>
																 <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                    <li onclick="trackEventLeadTracker('Project Card Page','Not Complete','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);" class="icon-enable-prj enbl_prj" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                <?php } ?>
																	<?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                    <li onclick="trackEventLeadTracker('Project Card Page','Delete Project','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);" class="icon-del-prj del_prj" data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                <?php } ?>
                                <?php } else { ?>
								<?php if((SES_TYPE == 1 || SES_TYPE == 2) && !empty($proj_users_list[$prjArr['Project']['id']]) && in_array(SES_ID,$proj_users_list[$prjArr['Project']['id']])){ ?>
                                    <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                    <li class="assgnremoveme<?php echo $prjArr['Project']['uniq_id']; ?>" onclick="trackEventLeadTracker('Project Card Page','Remove me','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);"  data-prj-uid ="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>" data-prj-usr="<?php echo SES_ID; ?>" onclick="removeMeFromPrj(this);"><i class="account-plus"></i><i class="material-icons">&#xE15C;</i> <?php echo __('Remove me from here');?></a></li>
                                <?php } ?>
								<?php }else if(SES_TYPE == 1 || SES_TYPE == 2){ ?>
                                    <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                    <li class="assgnremoveme<?php echo $prjArr['Project']['uniq_id']; ?>" onclick="trackEventLeadTracker('Project Card Page','Add Me','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);"  data-prj-uid ="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>" data-prj-usr="<?php echo SES_ID; ?>" onclick="assignMeToPrj(this);"><i class="account-plus"></i><i class="material-icons">&#xE147;</i> <?php echo __('Add me here');?></a></li>
                                <?php } ?>
								<?php } ?>
                                <?php if($this->Format->isAllowed('Add Users to Project',$roleAccess)){ ?>
                                    <li onclick="trackEventLeadTracker('Project Card Page','Add User','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);" class="icon-add-usr" data-prj-uid ="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>" data-prj-usr="<?php echo $prjArr['Project']['user_id']; ?>"><i class="material-icons">&#xE147;</i> <?php echo __('Add User');?></a></li>
                                <?php } ?>
                                    <li id="remove<?php echo $prjArr['Project']['id']; ?>" onclick="trackEventLeadTracker('Project Card Page','Remove User','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                    <?php if (!empty($prjArr[0]['totusers'])) { ?>
                                        <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                        <a href="javascript:void(0);" class="icon-remove-usr" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                    <?php } ?>
                                    <?php } ?>
                                    </li>
                                    <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                    <li id="ajax_remove<?php echo $prjArr['Project']['id']; ?>" style="display:none;" onclick="trackEventLeadTracker('Project Card Page','Remove User','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                        <a href="javascript:void(0);" class="icon-remove-usr" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                    </li>
                                  <?php } ?>																
                                    <?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>
                                    <li onclick="trackEventLeadTracker('Project Card Page','Edit Project','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);" class="icon-edit-usr " data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE254;</i> <?php echo __('Edit');?></a></li>
                                    <?php } ?>
                                    <li onclick="trackEventLeadTracker('Project Card Page','Complete or Delete Project','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                                    <?php if ($prjArr[0]['totalcase']) {?>	
                                  
									
									<?php 
									foreach($ProjectStatus as $key=>$val){
									if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){
										if($val !='Completed'){
										?>
										<a href="javascript:void(0);" class="icon-grid-enable-prj change_prj_status" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $prj_name; ?>" data-prj-status-name="<?php echo $val; ?>" data-prj-status-id="<?php echo $key; ?>"><i class="material-icons">&#xE86C;</i> <?php echo $val;?></a>
													<?php }}}?>
                                         <?php if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                                        <a href="javascript:void(0);" class="icon-enable-prj  disbl_prj" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE86C;</i> <?php echo __('Complete');?></a>
                                    <?php } ?>								
                                    <?php } else { ?>
                                        <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                        <a href="javascript:void(0);" class="icon-del-prj del_prj" data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a>
                                    <?php } ?>
                                    <?php } ?>
                                    </li>
                            <?php } 
                                    }else { ?>
                                         <?php if($this->Format->isAllowed('Notcomplete Project',$roleAccess)){ ?>
                                    <li onclick="trackEventLeadTracker('Project Card Page','Not Complete','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);" class="icon-enable-prj enbl_prj" data-prj-id="<?php echo $prjArr['Project']['id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE033;</i> <?php echo __('Not Complete');?></a></li>
                                <?php } ?>
                                    <?php if($this->Format->isAllowed('Delete Project',$roleAccess)){ ?>
                                    <li onclick="trackEventLeadTracker('Project Card Page','Delet Project','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><a href="javascript:void(0);" class="icon-del-prj del_prj" data-prj-id="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-uid="<?php echo $prjArr['Project']['uniq_id']; ?>" data-prj-name="<?php echo $this->Format->formatTitle($prj_name); ?>"><i class="material-icons">&#xE872;</i> <?php echo __('Delete');?></a></li>
                                <?php } ?>
                            <?php } ?>
                                </ul>
						<?php }else{ ?>
                                <ul class="dropdown-menu" <?php if(SES_TYPE == 3 && $prjArr['Project']['user_id'] != SES_ID){ ?>onclick="notAuthAlert();"<?php } ?>>
                            <?php if ($projtype == '') {                                 
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
                                        <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                    <?php if (!empty($prjArr[0]['totusers'])) { ?>
                                        
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                    <?php } ?>                                    
                                    </li>
                                    <?php } ?>
                                    <?php if($this->Format->isAllowed('Remove Users from Project',$roleAccess)){ ?>
                                    <li style="display:none;">
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove User');?></a>
                                    </li>
                                     <?php } ?>
                                     <?php if($this->Format->isAllowed('Edit Project',$roleAccess)){ ?>
                                    <li><a href="javascript:void(0);"><i class="material-icons">&#xE254;</i> <?php echo __('Edit');?></a></li>
                                <?php } ?>
                                    <li>
                                    <?php if ($prjArr[0]['totalcase']) {?>
                                        <?php if($this->Format->isAllowed('Complete Project',$roleAccess,0,SES_COMP)){ ?>
                                        <a href="javascript:void(0);"><i class="material-icons">&#xE86C;</i> <?php echo __('Complete');?></a>
                                    <?php } ?>
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
                            </span>
                        </div>
						<div class="title_short_name">
							<?php if ($prjArr['Project']['isactive'] == 1) { ?>
							<div class="top_projn">
								<h3>
									<a class="ellipsis-view" id="prj_ttl_<?php echo $prjArr['Project']['uniq_id']; ?>" href="javascript:void(0);" title="<?php echo $this->Format->formatTitle($tooltip); ?>" onclick="return projectBodyClick('<?php echo $prjArr['Project']['uniq_id']; ?>', event);"><?php echo $this->Format->formatTitle($prjArr['Project']['name']); ?>&nbsp;</a>
									<!-- span class="user_img user_img_proj proj_short_name" <?php if(!$chk_tour){ ?>id="tour_proj_shortnm"<?php  } ?> >
										(<span class="shortname_txt txt_upper_prj"><?php echo (($prjArr['Project']['short_name'])); ?></span>)
									</span -->
								</h3>
								<span>
								<span class="shortname_txt txt_upper_prj" <?php if(!$chk_tour){ ?>id="tour_proj_shortnm"<?php  } ?> >(<?php echo (($prjArr['Project']['short_name'])); ?>)</span>
								<span><?php echo $project_methodology_array[$prjArr['Project']['project_methodology_id']].' '.__('Project'); ?></span>
								</span> <?php //.' '.__('Project') ?>
								<span class="cnt_usr ellipsis-view proj_description_wdth" id ='actIn_<?php echo $prjArr['Project']['uniq_id']; ?>' data-actIn="<?php echo $prjArr['Project']['isactive']; ?>" style="display:none;"><?php //echo $this->Format->formatTitle($prjArr['Project']['description']); ?></span> 
							</div>
						<?php } else if ($prjArr['Project']['isactive'] == 2) { ?>
							<div class="top_projn">
								<h3>
									<a class="ellipsis-view" id="prj_ttl_<?php echo $prjArr['Project']['uniq_id']; ?>" href="javascript:void(0);" title="<?php echo $this->Format->formatTitle($tooltip); ?>" onclick="inactiveProjectBodyClick('<?php echo $prjArr['Project']['uniq_id']; ?>');"><?php echo $this->Format->formatTitle($prjArr['Project']['name']); ?>&nbsp;</a>
									<!--span class="user_img user_img_proj proj_short_name" <?php if(!$chk_tour){ ?>id="tour_proj_shortnm"<?php  } ?> >
										<span class="shortname_txt txt_upper_prj">(<?php echo (($prjArr['Project']['short_name'])); ?>)</span>
									</span -->
								</h3>
								<span class="shortname_txt txt_upper_prj" <?php if(!$chk_tour){ ?>id="tour_proj_shortnm"<?php  } ?> >(<?php echo (($prjArr['Project']['short_name'])); ?>)</span>
								<span><?php echo $project_methodology_array[$prjArr['Project']['project_methodology_id']].' '.__('Project'); ?></span>
								</span> <?php //.' '.__('Project') ?>
								<!--span><?php echo $project_methodology_array[$prjArr['Project']['project_methodology_id']].' '.__('Project'); ?></span -->
								<span class="cnt_usr ellipsis-view proj_description_wdth" id ='actIn_<?php echo $prjArr['Project']['uniq_id']; ?>' data-actIn="<?php echo $prjArr['Project']['isactive']; ?>" style="display:none;"><?php //echo $this->Format->formatTitle($prjArr['Project']['description']); ?></span> 
							</div>
						<?php } ?>
						</div>
						<?php
							$locDT = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $prjArr['Project']['dt_created'], "datetime");
							$gmdate = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
							$dateTime = $this->Datetime->dateFormatOutputdateTime_day($locDT, $gmdate, 'time');
						?>
						<div <?php if(!$chk_tour){ ?>id="tour_proj_crtdon"<?php  } ?> class="proj_created_by" title="<?php echo 'Created by  '.$this->Format->formatText($p_u_name[$prjArr['Project']['user_id']]); ?> on <?php echo $dateTime; ?>" rel='tooltip'>
							<?php echo __('Created by').'  '.$this->Format->formatText($p_u_name[$prjArr['Project']['user_id']]); ?> <?php echo __('on');?> <?php echo $dateTime; ?>
                        </div>
						<div class="hrs_progress_bar">
							<div <?php if(!$chk_tour){ ?>id="tour_proj_renmg"<?php  } ?> class="progress" title="<?php echo $title;?>" rel="tooltip">
								<div class="progress-bar cmpl_<?php echo $clr;?>" style="width:<?php echo round($project_progress_data[$prjArr['Project']['id']]); ?>%;">
								<span class="percent_circle" <?php if(round($project_progress_data[$prjArr['Project']['id']]) > 0 && round($project_progress_data[$prjArr['Project']['id']]) <=100){echo ' style="margin-right:35px;"';}?>><?php echo round($project_progress_data[$prjArr['Project']['id']]);?>%</span>
								</div>
							</div>
							<div class="cb"></div>
						</div>
						<div class="last_actvty">
							<span class="cnt_ttl_usr"><?php echo __('Status Workflow');?>:</span>
							<?php $status_grp_name = "";
							if($prjArr['Project']['status_group_id']){ 
								$sts_gp_name = $csts_arr_grp[$prjArr['Project']['status_group_id']]['name'];
								
								if (stripos($sts_gp_name, 'workflow') !== false) {
									$exstsgp = preg_split("/workflow/i", $sts_gp_name);
									$status_grp_name = $exstsgp[0];	
								} else {
									$status_grp_name = $sts_gp_name;
								} 					
							}else{ 
								$status_grp_name = __('Default Status Workflow',true); 
								} ?>
							<span class="cnt_usr"><?php echo $status_grp_name;?></span>
						</div>
						<div class="last_actvty">
							<span class="cnt_ttl_usr"><?php echo __('Last Activity');?>:</span>
							<span class="cnt_usr"><?php echo $last_activity;?></span>
						</div>
						<div class="">
							<span class="cnt_ttl_usr" <?php if(!$chk_tour){ ?>id="tour_proj_invlv"<?php  } ?>><?php echo __('User(s)');?>:  <span class="cnt_usr" id="tot_prjusers<?php echo $prjArr['Project']['id']; ?>"><?php echo!empty($prjArr[0]['totusers']) ? $prjArr[0]['totusers'] : '0'; ?></span></span>
						</div>
						<div class="proj_user_thumb_heit">
							<?php if (!empty($proj_users_list[$prjArr['Project']['id']])) {?>
								<div class="assign-user-img">
										<div <?php if($prjArr[0]['totusers'] > 5){?>class="proj_user_slider"<?php } ?>>
										<?php $ick =0; foreach ($proj_users_list[$prjArr['Project']['id']] as $key => $val) {
											$t_nm = '';
											$ick++;
											if(trim($proj_users_dtllist[$val]['User']['name']) == ''){
												$t_nm = explode('@',$proj_users_dtllist[$val]['User']['email']);
												$proj_users_dtllist[$val]['User']['name'] = $t_nm[0];
											}
											if($proj_users_dtllist[$val]['User']['name'] != ''){					
												$random_bgclr = $this->Format->getProfileBgColr($proj_users_dtllist[$val]['User']['id']);
												$usr_name_fst = mb_substr(trim($proj_users_dtllist[$val]['User']['name']),0,1, "utf-8");
											?>
											<div class="slide">
												<span class="overview_pimg fl">
													<?php if(trim($proj_users_dtllist[$val]['User']['photo']) != ''){ ?>
													<img title="<?php echo $proj_users_dtllist[$val]['User']['name']; ?>"  alt="" rel="tooltip" src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<?php echo trim($proj_users_dtllist[$val]['User']['photo']) != ''? trim($proj_users_dtllist[$val]['User']['photo']):'user.png'; ?>&sizex=32&sizey=32&quality=100" 
														 class="lazy round_profile_img" height="32" width="32" alt="No Image"/>
													<?php }else{ ?>
														<span title="<?php echo $proj_users_dtllist[$val]['User']['name']; ?>" rel="tooltip" class="cmn_profile_holder <?php echo $random_bgclr; ?> project_user_ov"><?php echo $usr_name_fst; ?></span>
													<?php } ?>
												</span>	
											</div>
											<?php }?>
										<?php }?>	
									</div>
								</div>
							<?php }?>
						</div>
						<div <?php if(!$chk_tour){ ?>id="tour_proj_renhr"<?php  } ?> class="all_hrs">
							<span class="cnt_ttl_usr"><?php echo __('Hours');?> (<?php echo __('Estimated');?>/<?php echo __('Spent');?>):</span>
							<span class="cnt_usr"><?php echo ($prjArr['Project']['estimated_hours'])?$prjArr['Project']['estimated_hours'].' hrs':'0 hrs';?>/<?php echo $totHours>0 ? $this->format->format_time_hr_min($totHours) : $totHours." hrs"; ?></span>
						</div>
						<div class="crdvw_foot_bg">
							<div class="crdvw_foot">
								<div class="tsk_storage">
									<ul>
                  <?php if ($prjArr['Project']['isactive'] == 2 || $prjArr['Project']['status'] == 4) { ?>
										<li class="" style="width:53%">
										<span class="crdvw task_icon " title="<?php echo __('Task(s)');?>"></span><?php echo __('Task(s)');?>
										<p  class=""><span class="" style="font-size: 12px;font-weight: bold;"><?php echo $totCase; ?></span></p>
									</li>	
                  <?php }else{ ?>
                    <li class="project_tasks" style="width:53%;color:#2983FD;cursor:pointer;">
										<span class="crdvw task_icon project_tasks" title="<?php echo __('Task(s)');?>"></span><?php echo __('Task(s)');?>
										<p  class="project_tasks"><span class="project_tasks" style="font-size: 12px;font-weight: bold;"><?php echo $totCase; ?></span></p>
									</li>
                  <?php } ?>									
									<li class="vline_li" style="cursor:default;">
										<span class="crdvw stroage_icon" title="<?php echo __('Storage');?>"></span><span style="font-weight:normal;"><?php echo __('Storage');?></span>
										<p><?php echo $filesize;?> mb </p>
									</li>
									</ul>
								</div>
								<div class="se_date" style="cursor:default;">
									<ul>
										<li>
											<span class="crdvw date_icon"></span><?php echo __("Start Date");?>
											<p><?php 
                                                                                        if($start_date){
                                                                                            echo date('d M',strtotime($start_date));
                                                                                            }else{
                                                                                            echo __("N/A");
                                                                                            }?>
                                                                                        </p>
										</li>
										<li>
											<span class="crdvw date_icon"></span><?php echo __("End Date");?>
                                                                                        <p>
                                                                                            <?php 
                                                                                        if($end_date){
                                                                                            echo date('d M',strtotime($end_date));
                                                                                            }else{
                                                                                            echo __("N/A");
                                                                                            }?>
                                                                                        </p>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php $chk_tour = 1;  } ?>
                <div class="cb"></div>
        <?php } ?>
            </div>
        </div>
	<?php if(!empty($prjAllArr[0]) && isset($prjAllArr[0])){} else { ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="no_usr fl cmn_bdr_shadow">
                    <h2 class="fnt_clr_rd"><?php echo __('No projects found');?>.</h2>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="cb"></div>
    <?php if ($caseCount) { ?>
        <?php 
            if ($projtype == 'inactive') {
                $page_url = HTTP_ROOT . "projects/manage/inactive?page=";
            } else if($filtype!=''){
                $page_url = HTTP_ROOT . "projects/manage?fil-type=" . $filtype . "&page=";
            } else {
                $page_url = HTTP_ROOT . "projects/manage?page=";
            }
            ?>
        <?php $pagedata = array('mode' => 'php', 'pgShLbl' => $this->Format->pagingShowRecords($caseCount, $page_limit, $casePage), 'csPage' => $casePage, 'page_limit' => $page_limit, 'caseCount' => $caseCount, 'page_url' => $page_url); ?>
        <?php echo $this->element("task_paginate",$pagedata);?>

    <?php } ?>

				<div class="crt_task_btn_btm <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT && $_SESSION['KEEP_HOVER_EFFECT'] && (($_SESSION['KEEP_HOVER_EFFECT'] & 4) == 4)){ ?>keep_hover_efct<?php } ?>">
				<span  class="hide_tlp_cross" title="<?php echo __('Close');?>" onclick="resetHoverEffect('project',this);">&times;</span>
        <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
        <div class="os_plus" id="tour_crt_proj_btn">
            <div class="ctask_ttip">
                <span class="label label-default">
                    <?php echo __('Create New Project');?>
                </span>
            </div>
            <a href="javascript:void(0)" onClick="setSessionStorage('Project Listing Card View Page Big Plus', 'Create Project');
                    newProject()">
                <i class="material-icons cmn-icon-prop ctask_icn">&#xE8F9;</i>
                <img src="<?php echo HTTP_ROOT; ?>img/images/plusct.png" class="add_icn" />
            </a>
        </div>
    <?php } ?>
    </div>
</div>
<div class="cb"></div>
<input type="hidden" id="getcasecount" value="<?php echo $caseCount; ?>" readonly="true"/>
<input type="hidden" id="totalcount" name="totalcount" value="<?php echo $count; ?>"/>

<script>
    $(document).ready(function () {
	if(localStorage.getItem("tour_type") == '1'){
		if(typeof hopscotch !='undefined'){
			GBl_tour = onbd_tour_project<?php echo LANG_PREFIX;?>;
		}
	}else{
		if(typeof hopscotch !='undefined' && localStorage.getItem("tour_type") == '0'){
			GBl_tour = tour_project<?php echo LANG_PREFIX;?>;
		}		
	}
	setTimeout(hideCmnMesg, 2000);
	$('.cmn_bdr_shadow').click(function (e) {
		if (!$(e.target).closest('.usr_act_det').length) {
			var prjuid = $(e.target).closest('.cmn_bdr_shadow').attr('data-prjuid');
			if (typeof prjuid != 'undefined') {
				var actIn = $("#actIn_" + prjuid).attr('data-actIn');
				if (actIn == 1) {
					if($(e.target).hasClass('project_tasks')){
						projectBodyClick(prjuid,'tasks');
					}else{
						//projectBodyClick(prjuid);
					}
				}else if (actIn == 2) {
					 //inactiveProjectBodyClick(prjuid);
				}
			}
		}
	});
        /*$(document).click(function(e){
         console.log(32423423)
         $(e.target).find('.usr_act_det').length>0?"" :$('.dropdown-menu').hide();
         });
         $('.dropdown-toggle').click(function(){
         $('.dropdown-menu').hide();
         $(this).closest('.dropdown').find('.dropdown-menu').toggle();
         });*/		 
	$('.proj_user_thumb_heit').off().on('click',function(e){
		e.preventDefault();e.stopPropagation();
	});
	$('.proj_user_slider').bxSlider({
			slideWidth:40,
			minSlides: 1,
			maxSlides: 8,
			moveSlides: 1,
			pager: false,
			slideMargin:5,
			auto: false,
			infiniteLoop:false,
			hideControlOnEnd:true,
		  });
    });
    function notAuthAlert() {
        showTopErrSucc('error', "<?php echo __('Oops! You are not authorized to do this operation. Please contact your Admin/Owner.');?>");
    }
    function assignMeToPrj(obj) {
        var loc = HTTP_ROOT + "projects/assignRemovMeToProject/";
        var proj_id = $(obj).attr('data-prj-id');
        var proj_uid = $(obj).attr('data-prj-uid');
        var user_ids = $(obj).attr('data-prj-usr');
        var pname = $(obj).attr('data-prj-name');
        var obj_t = obj;
        $.post(loc, {
            'user_ids': user_ids,
            'project_id': proj_id,
            'typ': 'as'
        }, function (res) {
            if (res.status == 'nf') {
                showTopErrSucc('error', '<?php echo __("Failed to assign user to the project.");?>');
            } else {
                if (trim(res.message) != '') {
                    showTopErrSucc('success', res.message);
                    $('.assgnremoveme' + proj_uid).html('<a href="javascript:void(0);" class="icon-add-usr" data-prj-uid ="' + proj_uid + '" data-prj-id="' + proj_id + '" data-prj-name="' + pname + '" data-prj-usr="<?php echo SES_ID; ?>" onclick="removeMeFromPrj(this);"><i class="material-icons">&#xE15C;</i> <?php echo __("Remove me from here");?></a>');
                }
            }
        }, 'json');
    }
    function removeMeFromPrj(obj) {
        var loc = HTTP_ROOT + "projects/assignRemovMeToProject/";
        var proj_id = $(obj).attr('data-prj-id');
        var proj_uid = $(obj).attr('data-prj-uid');
        var user_ids = $(obj).attr('data-prj-usr');
        var pname = $(obj).attr('data-prj-name');
        var obj_t = obj;
        let user_arr = [user_ids];
        let param_data = {
          project_id: proj_id, 
          user_arr: user_arr,
          field: 'id'
        }
        $.ajax({
            url: `${HTTP_ROOT}projects/ajaxcheckUserTasks`,
            type: 'POST',
            dataType: 'json',
            data: param_data,
        })
        .done(function(res) {
            if(res.status){
        $.post(loc, {
            'user_ids': user_ids,
            'project_id': proj_id,
            'typ': 'rm'
        }, function (res) {
            if (res.status == 'nf') {
                showTopErrSucc('error', '<?php echo __("Failed to assign user to the project.");?>');
            } else {
                if (trim(res.message) != '') {
                    showTopErrSucc('success', res.message);
                    $('.assgnremoveme' + proj_uid).html('<a href="javascript:void(0);" class="icon-add-usr" data-prj-uid ="' + proj_uid + '" data-prj-id="' + proj_id + '" data-prj-name="' + pname + '" data-prj-usr="<?php echo SES_ID; ?>" onclick="assignMeToPrj(this);"><i class="material-icons">&#xE147;</i> <?php echo __("Add me here");?></a>');
                }
            }
        }, 'json');
            }else{
                //Show Popup
                openPopup();
                $(".ass_task_user").show();
                $('#inner_usr_case_add').hide();
                $('#pop_up_assign_case_user_label').hide();
                $('.add-prj-btn').hide();
                $('#inner_usr_case_add').html('');
                $(".popup_bg").css({
                    "width": '850px'
                });
                $(".popup_form").css({
                    "margin-top": "6px"
                });
                $('#inner_usr_case_add').hide();
                $.ajax({
                    url: `${HTTP_ROOT}projects/ajaxGetProjUsers`,
                    type: 'POST',
                    dataType: 'html',
                    data: {param_data: param_data,user_data:res, page:PAGE_NAME, el_class: $(obj).closest('li').attr('class')},
                })
                .done(function(res_data) {
                    $(".loader_dv").hide();
                    $('#inner_usr_case_add').show();
                    $('#inner_usr_case_add').html(res_data);
                    $('#pop_up_assign_case_user_label').html('');
                    $('#pop_up_assign_case_user_label').html($('#hid_ext_use_lbl').html());
                    $('#pop_up_assign_case_user_label').css('display', 'block');
                    $('.add-prj-btn').show();
                    $.material.init();
                });
            }
        });
    }
    function inactiveProjectBodyClick(uid) {
        $('.project-dropdown').hide();
        $('.project-dropdown').prev('li').hide();
        $.post(HTTP_ROOT + "projects/updtaeDateVisited", {
            'uniq_id': uid
        }, function (res) {
            if (res.status == 'success') {
        window.location.href = HTTP_ROOT + "dashboard/#tasks";
            } else {
                showTopErrSucc('error', '<?php echo __('Oops! You are not a member of the project. Please add yourself as a member of this project.');?>');
                return false;
    }
        }, 'json');

    }
	
</script>