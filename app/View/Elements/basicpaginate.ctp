<?php if ($caseCount) { ?>
    <div class="cb mt20"></div>
    <div class="tot-cs1 fr">
        <div class="sh-tot-cs">
            <?php echo $this->Format->pagingShowRecords($caseCount, $page_limit, $casePage); ?>
        </div>
        <div class="pg-ntn">
            <ul class="pagination">
                <?php
                $page = $casePage;
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
                    }
                    if ($data1) {
                        echo "<li><a href='" . HTTP_ROOT . "easycases/invoice/?page=1' class=\"button_act\" >&laquo; ". __('First')."</a></li>";
                        echo "<li class='hellip'>&hellip;</li>";
                    }
                    if ($page != 1) {
                        $pageprev = $page - 1;
                        echo "<li><a href='" . HTTP_ROOT . "easycases/invoice/?page=" . $pageprev . "' class=\"button_act\">&lt;&nbsp;".__('Prev')."</a></li>";
                    } else {
                        echo "<li><a href='javascript:jsVoid();' class=\"button_prev\" style=\"cursor:text\">&lt;&nbsp;".__('Prev')."</a></li>";
                    }
                    for ($i = $k; $i <= $numofpages; $i++) {
                        if ($i == $page) {
                            echo "<li><a href='javascript:jsVoid();' class=\"button_page\" style=\"cursor:text\">" . $i . "</a></li>";
                        } else {
                            echo "<li><a href='" . HTTP_ROOT . "easycases/invoice/?page=" . $i . "' class=\"button_act\" >" . $i . "</a></li>";
                        }
                    }
                    if (($caseCount - ($page_limit * $page)) > 0) {
                        $pagenext = $page + 1;
                        echo "<li><a href='" . HTTP_ROOT . "easycases/invoice/?page=" . $pagenext . "' class=\"button_act\" >".__('Next')."&nbsp;&gt;</a></li>";
                    } else {
                        echo "<li><a href='" . HTTP_ROOT . "easycases/invoice/?page=" . $pagenext . "' class=\"button_prev\">".__('Next')."&nbsp;&gt;</a></li>";
                    }
                    if ($data2) {
                        echo "<li class='hellip'>&hellip;</li>";
                        echo "<li><a href='" . HTTP_ROOT . "easycases/invoice/?page=" . floor($lastPage) . "' class=\"button_act\" >".__('Last')." &raquo;</a></li>";
                    }
                }
                ?>
            </ul>
        </div>
    </div>
<?php } ?>