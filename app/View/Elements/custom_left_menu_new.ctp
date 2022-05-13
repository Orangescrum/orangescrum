<?php $allLeftMenu = Cache::read('userMenu'.SES_COMP.'_'.SES_ID);
if(!empty($cstm_order) && count($allLeftMenu['allUsermenus'])){

    $cstm_order_arr = explode(',', $cstm_order);
    $sorted_arr = $allLeftMenu['allUsermenus'];


    $short = $shorted = array();

    foreach($sorted_arr as $k=>$v){
        $short[$v['id']] = $v;
    }
    foreach($cstm_order_arr as $k=>$v){
        if(isset($short[$v]) && !empty($short[$v])){  
            $shorted[$v] =  $short[$v];
        }else{
            if(isset($allLeftMenu['menus'][$v]['menu_type']) && $allLeftMenu['menus'][$v]['menu_type'] == 1){
                $shorted[$v]['id'] = $v;
            }
        } 
    }
    //pr($allLeftMenu);
    foreach($short as $k=>$v){
        if(!array_key_exists($k,$shorted)){
           $shorted[$k] = $v;
        }
    }
    $allLeftMenu['allUsermenus'] = $shorted;
    
}

$pmethodology = !empty($pmethodology)?$pmethodology:$_SESSION['project_methodology'];

$inserted = array(array("id"=>56)); // not necessarily an array, see manual quote
/*$res = array_slice($allLeftMenu['allUsermenus'], 0, 3, true) +
    array("id"=>56) +
    array_slice($allLeftMenu['allUsermenus'], 3, count($allLeftMenu['allUsermenus'])-3, true); */
array_splice( $allLeftMenu['allUsermenus'], 1, 0, $inserted );

$inserted_bug = array(array("id"=>57));
if($pmethodology == 'simple'){
    array_splice( $allLeftMenu['allUsermenus'], 4, 0, $inserted_bug );
} else{
    array_splice( $allLeftMenu['allUsermenus'], 7, 0, $inserted_bug );
}
if(count($allLeftMenu['allUsermenus'])){
    $masterMenu = $allLeftMenu['menus'];
    foreach($allLeftMenu['allUsermenus'] as $k=>$v){ 
        if(!empty($v)){
            //echo $v['id']."--".$k;exit;
           if($v['id'] == 56 && $k != 1){
                continue;
            }
            if($pmethodology == 'simple'){
                if($v['id'] == 57 && $k != 4){
                    continue;
                }
            } else{
                if($v['id'] == 57 && $k != 7){
                    continue;
                }
            }
        $menu_id = $v['id'];
        $meta = json_decode($masterMenu[$menu_id]['meta'],true);
        $menuStatus = $this->Format->checkCustomMenuStatus($masterMenu[$menu_id],$theme_settings,$page_array,$roleAccess,$exp_plan,$user_subscription,$pmethodology,1, $url);
        ?>
        <?php if($menuStatus['isAllow']){ ?>
        <li class="sidebar_parent_li <?php echo $meta['li_class'];?>  <?php echo $menuStatus['active_class'];?>" id="<?php echo $meta['li_id'];?>" 
            <?php if($meta['li_click']){ ?>
            onclick="<?php echo $meta['li_click'];?>"
            <?php } ?> 

            onmouseover ="isInViewport(this);"

            >

            <?php
                $setUrl = ($menuStatus['dynamic_url'])? $menuStatus['dynamic_url'] : HTTP_ROOT . $meta['url'];
                $setaClick = ($menuStatus['dynamic_a_click'])? $menuStatus['dynamic_a_click'] : $meta['a_click'];
                $setMenuName = ($menuStatus['dynamic_menu_name'])? $menuStatus['dynamic_menu_name'] : $masterMenu[$menu_id]['name'];
            ?>

            <a href="<?php echo $setUrl; ?>" onclick="<?php echo $setaClick; if($masterMenu[$menu_id]['name'] == "Projects"){ ?> resetProjectFilterItem(); <?php  } ?> return trackEventLeadTracker('Left Panel','<?php echo $masterMenu[$menu_id]['name'] ;?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">
                        <?php echo $masterMenu[$menu_id]['menu_icon']; ?>
                        <span class="mini-sidebar-label"><?php echo __($setMenuName);?></span>
                        <?php if($v['id'] == 57){ ?>
                            <span class="new_blink_item"><?php echo __("New");?></span>
                      <?php  } ?>
                </a>


                <?php if(count($v['children']) && !isset($menuStatus['not_show_inner_menu'])){ ?>

                    <ul class="hover_sub_menu"> <!--view_tasks_menu-->
                    <?php foreach($v['children'] as $k1=>$v1){ 
                            if(!empty($v1)){
                            $c_menu_id = $v1['id'];
                            $c_meta = json_decode($masterMenu[$c_menu_id]['meta'],true);
                            $c_menuStatus = $this->Format->checkCustomMenuStatus($masterMenu[$c_menu_id],$theme_settings,$page_array,$roleAccess,$exp_plan,$user_subscription,$pmethodology,0,$url);

                        ?>
                        <?php  
                            $setUrl = ($c_menuStatus['dynamic_url'])? $c_menuStatus['dynamic_url'] : HTTP_ROOT . $c_meta['url'];
                            $setaClick = ($c_menuStatus['dynamic_a_click'])? $c_menuStatus['dynamic_a_click'] : $c_meta['a_click'];
                            $setMenuName = ($c_menuStatus['dynamic_menu_name'])? $c_menuStatus['dynamic_menu_name'] : $masterMenu[$c_menu_id]['name'];
                        ?>
                        <?php if($c_menuStatus['isAllow']){ ?>
                        <li id="<?php echo $c_meta['li_id'];?>" class="<?php echo $c_meta['li_class'];?> <?php echo $c_menuStatus['active_class'];?>" 
                            <?php if($c_meta['li_click']){ ?>
                            onclick="<?php echo $c_meta['li_click'];?>"
                        <?php } ?>
                             >
                    <a href="<?php echo $setUrl;?>" 
                        <?php if(true){ ?>
                        onclick="<?php echo $setaClick; ?> return trackEventLeadTracker('Left Panel Submenu','<?php echo $masterMenu[$c_menu_id]['name'] ;?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');displayMenuProjects('special_mydashoard', '6', '');"
                    <?php } ?>

                      title="<?php echo $c_meta['a_tooltip'];?>">
                                        <span style="display: inline-block; vertical-align: middle;" class="multilang_ellipsis"><?php echo __($setMenuName);?></span>
                        <?php echo $c_meta['cnt_span'];?>
                    </a>
                </li>
                <?php } } ?>
                    <?php } ?>
                    <?php if($masterMenu[$menu_id]['name'] == 'Tasks'){ ?>
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
                        <a href="<?php echo HTTP_ROOT; ?>dashboard#/tasks/<?php echo $tabvalue["fkeyword"];?>"   id="otheropt<?php echo $tabkey;?>" data-val="0" data-tabkey="<?php echo $tabvalue["fkeyword"]; ?>" rel="" class="gray-background oth_all_close"><?php echo $tabvalue["ftext"]; ?> <span id="<?php echo $tab_spn_id;?>" class="spncls"></span></a>
                                                                    <?php } ?>
                                        <?php } else { ?>
                        <a href="<?php echo HTTP_ROOT; ?>dashboard#/tasks/<?php echo $tabvalue["fkeyword"];?>"   id="otheropt<?php echo $tabkey;?>" data-val="0" data-tabkey="<?php echo $tabvalue["fkeyword"]; ?>" rel="" class="gray-background oth_all_close"><?php echo $tabvalue["ftext"]; ?> <span id="<?php echo $tab_spn_id;?>" class="spncls"></span></a>   
                                        <?php } ?>
                    <?php } } ?>                    
                                    
                                </div>
                    </li>
                </ul>
                </li>
       
                <script type="text/template" id="filterSearch_id_tmpl">                             
                <?php echo $this->element('search_filter'); ?>                                                            
                </script>
                    <?php }?>
                    </ul>
                <?php } ?>
        </li>
    <?php } }?>
   <?php }?>
<?php } ?>

<script>
var isInViewport = function (elem) {
    obj = $(elem).find('.hover_sub_menu');
    if(typeof obj !='undefined' && typeof obj.offset() !='undefined'){
        var top_of_element = obj.offset().top;
        var bottom_of_element = obj.offset().top + obj.outerHeight();
        var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
        var top_of_screen = $(window).scrollTop();

        if ((bottom_of_screen <= bottom_of_element)){
            $(elem).addClass('miscellaneous_li');
        } else {
            
        }
    }
};
</script>