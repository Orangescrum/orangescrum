<?php if ($mode == 'php') { ?>
        <div class="os_pagination">
        <div class="show_total_case"><?php echo $pgShLbl ?></div> 
        <ul class="pagination">
            <?php
            $page = intval($csPage);
            if ($page_limit < $caseCount) {
                $numofpages = $caseCount / $page_limit;
                if (($caseCount % $page_limit) != 0) {
                    $numofpages = $numofpages + 1;
                }
                $lastPage = $numofpages;

                $k = 1;
                $data1 = "";
                $data2 = "";
                if ($numofpages > 5) {
                    $newmaxpage = $page + 2;
                    if ($page >= 3) {
                        $k = $page - 2;
                        $data1 = "...";
                    }
                    if (($numofpages - $newmaxpage) >= 2) {
                        if ($data1) {
                            $data2 = "...";
                            $numofpages = $page + 2;
                        } else {
                            if ($numofpages >= 5) {
                                $data2 = "...";
                                $numofpages = 5;
                            }
                        }
                    }
                } ?>
                <?php if ($data1) { ?>
                    <li>
                        <?php if (isset($pagemode) && $pagemode = 'ajax') { ?>
                            <a href="javascript:void(0)" onclick='<?php echo $callback; ?>(1<?php echo $extraarg; ?>);' class="button_act">&laquo; <?php echo __('First');?></a>
                        <?php } else { ?>
                            <a href="<?php echo $page_url; ?>1" class="button_act">&laquo; <?php echo __('First');?></a>
                        <?php } ?>
                    </li>
                <?php } ?>
                <?php if ($page != 1) {
                    $pageprev = $page - 1;
                    ?>
                    <li class="button_act">
                        <?php if (isset($pagemode) && $pagemode = 'ajax') { ?>
                            <a href="javascript:void(0)" onclick='<?php echo $callback; ?>(<?php echo $pageprev; ?><?php echo $extraarg; ?>);'><i class="material-icons">&#xE314;</i><?php echo __('Prev');?></a>
                        <?php } else { ?>
                            <a href='<?php echo $page_url . $pageprev; ?>'><i class="material-icons">&#xE314;</i><?php echo __('Prev');?></a>
                        <?php  } ?>
                    </li>
                <?php } else { ?>
                    <li class="disabled button_prev"><a href="javascript:void(0)"><i class="material-icons">&#xE314;</i><?php echo __('Prev');?></a></li>
                <?php  } ?>
                <?php for ($i = $k; $i <= $numofpages; $i++) { ?>
                    <?php if ($i == $page) { ?>
                        <li class="active"><a href="javascript:jsVoid();"><?php echo $i ?></a></li>
                    <?php } else { ?>
                        <li>
                            <?php if (isset($pagemode) && $pagemode = 'ajax') { ?>
                                <a href="javascript:void(0)" onclick='<?php echo $callback; ?>(<?php echo $i; ?><?php echo $extraarg; ?>);' class="button_act"><?php echo $i ?></a>
                            <?php } else { ?>
                                <a href="<?php echo $page_url . $i; ?>" class="button_act" ><?php echo $i ?></a>
                            <?php } ?>
                        </li>
                    <?php } ?>
                <?php } ?>
        
                <?php
                if (($caseCount - ($page_limit * $page)) > 0) {
                    $pagenext = $page + 1;
                    ?>
                    <li>
                        <?php if (isset($pagemode) && $pagemode = 'ajax') { ?>
                            <a href="javascript:void(0)" onclick='<?php echo $callback; ?>(<?php echo $pagenext; ?><?php echo $extraarg; ?>);' class="button_act"><?php echo __('Next');?><i class="material-icons">&#xE315;</i></a>
                        <?php } else { ?>
                            <a class="button_act" href="<?php echo $page_url . $pagenext; ?>"><?php echo __('Next');?><i class="material-icons">&#xE315;</i></a>
                        <?php } ?>
                    </li>
                <?php } else { ?>
                    <li class="disabled button_prev">
                        <a href="javascript:void(0)"><?php echo __('Next');?><i class="material-icons">&#xE315;</i></a>
                    </li>
                <?php } ?>
                <?php if ($data2) { ?>
                    <li>
                        <?php if (isset($pagemode) && $pagemode = 'ajax') { ?>
                            <a href="javascript:void(0)" onclick='<?php echo $callback; ?>(<?php echo floor($lastPage); ?><?php echo $extraarg; ?>);' class="button_act"><?php echo __('Last');?> &raquo;</a>
                        <?php } else { ?>
                            <a href="<?php echo $page_url . floor($lastPage); ?>" class="button_act"><?php echo __('Last');?> &raquo;</a>
                        <?php } ?>
                    </li>
                <?php } ?>
            <?php } ?>
            </ul>
    </div>
<?php } else { ?>

<div class="os_pagination">
    <div class="show_total_case"><%= pgShLbl %></div> 
    <ul class="pagination">
    <% var page = parseInt(csPage);
    if(page_limit < caseCount) {
        var numofpages = caseCount / page_limit;
        if((caseCount % page_limit) != 0) {
                numofpages = numofpages+1;
        }
        var lastPage = numofpages;

        var k = 1;
        var data1 = "";
        var data2 = "";
        if(numofpages > 5) {
                var newmaxpage = page+2;
                if(page >= 3) {
                        var k = page-2;
                        data1 = "...";
                }
                if((numofpages - newmaxpage) >= 2) {
                        if(data1) {
                                data2 = "...";
                                numofpages = page+2;
                        } else {
                                if(numofpages >= 5) {
                                        data2 = "...";
                                        numofpages = 5;
                                }
                        }
                }
        }
        if(data1) { %>
                <li><a href="javascript:jsVoid();" class="button_act" onClick="casePaging(1)">&laquo; First</a></li>
    <% 	}
        if(page != 1) {
                var pageprev = page-1; %>
                <li class="button_act" onClick="casePaging(<%= '\'' + pageprev + '\'' %>)">
                    <a href="javascript:void(0)"><i class="material-icons">&#xE314;</i>Prev</a>
                </li>
    <% 	} else { %>
                <li class="disabled button_prev">
                    <a href="javascript:void(0)"><i class="material-icons">&#xE314;</i>Prev</a>
                </li>
    <% 	}
        for(var i = k; i <= numofpages; i++) {
                if(i == page) {
    %>
                        <li class="active"><a href="javascript:jsVoid();"><%= i %></a></li>
    <% 		} else { %>
                        <li><a href="javascript:jsVoid();" class="button_act" onClick="casePaging(<%= '\'' + i + '\'' %>)"><%= i %></a></li>
    <% 		}
        }
        if((caseCount - (page_limit * page)) > 0) {
                var pagenext = page+1; %>
                <li class="button_act" onClick="casePaging(<%= '\'' + pagenext + '\'' %>)">
                    <a href="javascript:void(0)">Next<i class="material-icons">&#xE315;</i></a>
                </li>
    <% 	} else { %>
                <li class="disabled button_prev">
                    <a href="javascript:void(0)">Next<i class="material-icons">&#xE315;</i></a>
                </li>
    <% 	}
        if(data2) { %>
                <li><a href="javascript:jsVoid();" class="button_act" onClick="casePaging(<%= '\'' + Math.floor(lastPage) + '\'' %>)">Last &raquo;</a></li>
    <% 	}
    } %>
    </ul>
</div>
<?php } ?>