<table cellpadding="0" cellspacing="0" class="table top-tab-popup">
    <tr>
        <th style="visibility: hidden;">&nbsp;</th>
        <td rowspan="6" style="text-align: left;"><br />
            <img src="<?php echo HTTP_ROOT . 'img/images/category_tab.png'; ?>"/>
        </td>
    </tr>
    <?php
    $tablists = Configure::read('DTAB');
    foreach ($tablists AS $tabkey => $tabvalue) {
        ?>
        <tr>
            <td class="tab_cls"  <?php if ($tabvalue["fkeyword"] == 'openedtasks'){ ?> style="position:relative"<?php } ?>>
                <div class="tb_div_en <?php if ($tabvalue["fkeyword"] == 'cases' || $tabvalue["fkeyword"] == 'assigntome') { ?>disabletoptab<?php } ?>" >
                    <div class="fl checkbox custom-checkbox">
                        <label>
                            <input type="checkbox" <?php if ($tabkey & ACT_TAB_ID) { ?>checked="true"<?php } if ($tabvalue["fkeyword"] == 'cases' || $tabvalue["fkeyword"] == 'assigntome') { ?>disabled="disabled"<?php } ?> value="<?php echo $tabkey; ?>" class="cattab_cls" style="cursor: pointer;" onclick="checkCategoryLimit(this)">
                            <span><?php echo $tabvalue["ftext"]; ?></span>
                            <?php if ($tabvalue["fkeyword"] == 'openedtasks'){ ?>
                            <span class="tab-dtls">(<?php echo __('All tasks having status new, in progress and resolve');?>)</span>
                            <?php } ?>
                        </label>
                    </div>
                </div>
            </td>
            
        </tr>
    <?php } ?>
</table>