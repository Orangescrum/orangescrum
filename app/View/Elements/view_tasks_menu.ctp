<ul id="topactions_ul" class="hover_sub_menu view_tasks_menu <?php if (CONTROLLER == "easycases" && (PAGE_NAME == "dashboard")) { ?> inner_ul_list <?php }?>">
    <?php
    if (ACT_TAB_ID && ACT_TAB_ID > 1) {
        if($os_locale =='spa'){
           $tablists = Configure::read('DTAB_SPA');
        }else if($os_locale =='por'){
           $tablists = Configure::read('DTAB_POR'); 
	   }else if($os_locale =='deu'){
           $tablists = Configure::read('DTAB_DEU');
       }else if($os_locale =='fra'){
           $tablists = Configure::read('DTAB_FRA');
        }else{
            $tablists = Configure::read('DTAB');
        }
        if(!$this->Format->isAllowed('View All Task',$roleAccess)){
            unset($tablists[1]);
        }
        foreach ($tablists AS $tabkey => $tabvalue) {
            if ($tabkey & 255) {
                $default_actv = "";
                $placed_icons = "";
                if ($tabvalue["fkeyword"] == "cases") {
                    $tab_spn_id = "tskTabAllCnt";
                    $default_actv = "active-list";
                    $placed_icons = '<i class="material-icons">&#xE0DF;</i>';
                    $title = __('All Tasks',true);
                } elseif ($tabvalue["fkeyword"] == "assigntome") {
                    $tab_spn_id = "tskTabMyCnt";
                    if(!$this->Format->isAllowed('View All Task',$roleAccess)){
                        $default_actv = "active-list";
                    }
                    $placed_icons = '<i class="material-icons">&#xE862;</i>';
                    $title = __('All tasks assigned to me',true);
                } elseif ($tabvalue["fkeyword"] == "favourite") {
                    $tab_spn_id = "tskTabFavCnt";
                    $placed_icons = '<i class="material-icons">star</i>';
                    $title = __('All favourite tasks',true);
                } elseif ($tabvalue["fkeyword"] == "delegateto") {
                    $tab_spn_id = "tskTabDegCnt";
                    $placed_icons = '<i class="material-icons">&#xE569;</i>';
                    $title = __('All tasks not assinged to me',true);
                } elseif ($tabvalue["fkeyword"] == "highpriority") {
                    $tab_spn_id = "tskTabHPriCnt";
                    $placed_icons = '<i class="material-icons">&#xE7F4;</i>';
                    $title = __('All high priority tasks',true);
                } elseif ($tabvalue["fkeyword"] == "overdue") {
                    $tab_spn_id = "tskTabOverdueCnt";
                    $placed_icons = '<i class="material-icons">&#xE001;</i>';
                    $title = __('All overdue tasks',true);
                } elseif ($tabvalue["fkeyword"] == "openedtasks") {
                    $tab_spn_id = "tskTabOpenedcnt";
                    $placed_icons = '<i class="material-icons">&#xE895;</i>';
                    $title = __('All tasks having status new, in progress and resolve',true);
                } elseif ($tabvalue["fkeyword"] == "closedtasks") {
                    $tab_spn_id = "tskTabClosedCnt";
                    $placed_icons = '<i class="material-icons">&#xE876;</i>';
                    $title = __('All Closed tasks',true);
                }
                ?>
				<?php if(!$left_smenu_exist || in_array(strtolower($tabvalue["ftext_org"]),$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                <li id="<?php echo $tabvalue["fkeyword"]; ?>_id" class="cattab prevent_togl_li <?php if (strtolower($tabvalue["ftext"]) == 'all tasks') { ?>all-list-glyph<?php } ?> <?php echo $default_actv; ?>">
                    <a href="<?php echo HTTP_ROOT; ?>dashboard#tasks/<?php echo $tabvalue["fkeyword"];?>" onclick="setTabSelection();" data-toggle="tab"  title="<?php echo $title; ?>">
                <?php //echo $placed_icons; ?>
                        <span style="display: inline-block; vertical-align: middle;" class="multilang_ellipsis">
                <?php
                if (strtolower($tabvalue["ftext"]) == 'all tasks') {
                    echo __('All Tasks');
                } else {
                    echo $tabvalue["ftext"];
                }
                ?></span>
                        <span class="<?php echo $tabvalue["fkeyword"]; ?>">
                            <span id="<?php echo $tab_spn_id; ?>" class="spncls"></span>
                        </span>
                    </a>
                </li>					
					<?php } ?>
        <?php }
    }
    ?>  
                <li  class="filter-dropdown" data-step="2" data-intro="<?php echo __('This is the filter drop-down, by choosing this you can move to any filter type');?>." >  					
						<div class="btn-group margin-left-2" id="filterSearch_id">
							<button aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="top_project_btn btn btn_cmn_efect cmn_bg btn-info cmn_size dropdown-toggle project-drop-custom-pad prtl<?php echo ' '.$theme_settings['sidebar_color'].' gradient-shadow';?>" type="button" onclick="viewFilters_new();">
                                                            <span class=""><a href="javascript:void(0);" class="top_project_name1" rel=""><?php echo __('Loading');?></a>
															<span class="csm_flt_more"><i class="material-icons">&#xE5D4;</i></span>
															</span>
							</button>
                                                </div>
                <ul class="sub_level_menu" id="filpopup" style="display: none;">
                <li>							
								<div class="scroll-project" id="ajaxViewFilters"> 							
									<?php foreach ($tablists AS $tabkey => $tabvalue) { 
						if (!($tabkey & 255)) {	
											$tab_spn_id='';
											if($tabvalue["fkeyword"] == "cases") { 
												$tab_spn_id = "tskTabAllCnt";
											}elseif($tabvalue["fkeyword"] == "assigntome") { 
												$tab_spn_id = "tskTabMyCnt";
											}elseif($tabvalue["fkeyword"] == "favourite") { 
                                                $tab_spn_id = "tskTabFavCnt";
											}elseif($tabvalue["fkeyword"] == "delegateto") { 
												$tab_spn_id = "tskTabDegCnt";
											}elseif($tabvalue["fkeyword"] == "highpriority") { 
												$tab_spn_id = "tskTabHPriCnt"; 
											}elseif($tabvalue["fkeyword"] == "overdue") { 
												$tab_spn_id = "tskTabOverdueCnt";
											}elseif($tabvalue["fkeyword"] == "openedtasks") { 
												$tab_spn_id = "tskTabOpenedcnt"; 
											}elseif($tabvalue["fkeyword"] == "closedtasks") { 
												$tab_spn_id = "tskTabClosedCnt"; 							
											}										
										?>
										<?php if($tabvalue["fkeyword"] == "closedtasks"){ ?>
										<?php if(!$left_smenu_exist || in_array('all closed',$checked_left_menu_submenu['checked_left_submenus'])){ ?>
                        <a href="<?php echo HTTP_ROOT; ?>dashboard#tasks/<?php echo $tabvalue["fkeyword"];?>"   id="otheropt<?php echo $tabkey;?>" data-val="0" data-tabkey="<?php echo $tabvalue["fkeyword"]; ?>" rel="" class="gray-background oth_all_close"><?php echo $tabvalue["ftext"]; ?> <span id="<?php echo $tab_spn_id;?>" class="spncls"></span></a>
																	<?php } ?>
										<?php } else { ?>
                        <a href="<?php echo HTTP_ROOT; ?>dashboard#tasks/<?php echo $tabvalue["fkeyword"];?>"   id="otheropt<?php echo $tabkey;?>" data-val="0" data-tabkey="<?php echo $tabvalue["fkeyword"]; ?>" rel="" class="gray-background oth_all_close"><?php echo $tabvalue["ftext"]; ?> <span id="<?php echo $tab_spn_id;?>" class="spncls"></span></a>	
										<?php } ?>
					<?php } } ?>					
									
								</div>
					</li>
                </ul>
                </li>
       
        <script type="text/template" id="filterSearch_id_tmpl">								
        <?php echo $this->element('search_filter'); ?>                                                            
        </script>
<!--        <li id="filterSearch_id_less" class="filter-dropdown_less">  					
                <a href="javascript:void(0);" aria-expanded="false" aria-haspopup="true" data-toggle="dropdown" class="dropdown-toggle"  onclick="viewFilters();">
                    <span href="javascript:void(0);" class="top_project_name1" rel="tooltip"  title="Less Links" >Less ...</span>
                </a>
        </li>-->
        <!--else if(m==0){
                                        jsarray=sf[m]['SearchFilter']['json_array'];
                                } -->
<!--        <li class="pop_li" data-step="3" data-intro="Click here to customize the 'Tab' section.">
            <a href="javascript:void(0)" class="select_button_ftop" onclick="newcategorytab();trackEventLeadTracker('Top Bar', 'Tab Settings', '<?php echo $_SESSION['SES_EMAIL_USER_LOGIN']; ?>');" rel="tooltip" title="Tab Settings">
                <i class="material-icons plus-icon">&#xE145;</i>
            </a>
        </li>-->


<?php } ?>                    
</ul>