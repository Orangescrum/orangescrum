<input type="text" name="search_user"  id="" placeholder="Search" class="searchType" onkeyup="searchFilterItems(this);" autocomplete="off"/>
<input type="hidden" id="project_sts_by_all">
<?php
$m = 0;
if(!isset($page)){
    if (isset($diy_list) && !empty($diy_list)) {
        $m = 0;
        $h = 0;
        $newArr = array();
        foreach ($diy_list as $drbKey=>$drbVal) {
            $m++;
            $drbId = $drbKey;
            $drbTitle = $drbVal;
            array_push($newArr,$drbId);
            ?>
           <li>
                <a href="javascript:void(0);">
                    <div class="slide_menu_div1">
                        <input type="checkbox" id="dprojstatus_<?php echo $drbId; ?>" onClick="checkboxProjectStatus('dprojstatus_<?php echo $drbId; ?>', 'check','<?php echo $drbId; ?>','<?php echo $this->Format->formatText($drbTitle); ?>');"/>
                        <font onClick="checkboxProjectStatus('dprojstatus_<?php echo $drbId; ?>', 'check','<?php echo $drbId; ?>','<?php echo $this->Format->formatText($drbTitle); ?>');"   title='<?php echo $this->Format->formatText($drbTitle); ?>'>
                        &nbsp;<?php echo $this->Format->formatText($drbTitle); ?></font>
                        <div style="margin:0;color:#999999;line-height:16px;padding-left:20px;font-size:11px;">
                        </div>
                        <input type="hidden" name="tcktsubmtd_<?php echo $drbId; ?>" id="Dcidrb_<?php echo $drbId; ?>" value="<?php echo $drbId; ?>" readonly="true">
                    </div>
                </a>
            </li>
            <?php
        }
        $str = json_encode($newArr);
        if ($h != 0) {
            ?>
            <?php }
        ?>
    <?php } else { ?>
        <li> <a href="javascript:void(0);">
                <div class="slide_menu_div1">
                    <font title='<?php echo __("Sorry, No Project Status");?>'>
                    &nbsp;<?php echo __('No Project Status'); ?> </font>
                    <div style="margin:0;color:#999999;line-height:16px;padding-left:20px;font-size:11px;">
                    </div>
                </div>
            </a></li>
    <?php } ?>
    <input type="hidden" id="totprojstsId" value="<?php echo $str; ?>" readonly="true"/>
<?php } else if(CONTROLLER == 'projects' && isset($page)){ 
    if (isset($diy_new_list) && !empty($diy_new_list)) {
        $m = 0;
        $h = 0;
        $newArr = array();
        foreach ($diy_new_list as $drbKey=>$drbVal) {
            $m++;
            $drbId = $drbKey;
            $drbTitle = $drbVal;
            array_push($newArr,$drbId);
            ?>
           <li>
                <a href="javascript:void(0);">
                    <div class="slide_menu_div1">
                        <input type="checkbox" id="dprojstatusmange_<?php echo $drbId; ?>" onClick="checkboxProjectStatus('dprojstatusmange_<?php echo $drbId; ?>', 'check','<?php echo $drbId; ?>','<?php echo $this->Format->formatText($drbTitle); ?>');"/>
                        <font onClick="checkboxProjectStatus('dprojstatusmange_<?php echo $drbId; ?>', 'check','<?php echo $drbId; ?>','<?php echo $this->Format->formatText($drbTitle); ?>');"   title='<?php echo $this->Format->formatText($drbTitle); ?>'>
                        &nbsp;<?php echo $this->Format->formatText($drbTitle); ?></font>
                        <div style="margin:0;color:#999999;line-height:16px;padding-left:20px;font-size:11px;">
                        </div>
                        <input type="hidden" name="tcktsubmtd_<?php echo $drbId; ?>" id="Dcidrb_<?php echo $drbId; ?>" value="<?php echo $drbId; ?>" readonly="true">
                    </div>
                </a>
            </li>
            <?php
        }
        $str = json_encode($newArr);
        if ($h != 0) {
            ?>
            <?php }
        ?>
    <?php } else { ?>
        <li><a href="javascript:void(0);">
                <div class="slide_menu_div1">
                    <font title='<?php echo __("Sorry, No Project Status");?>'>
                    &nbsp;<?php echo __('No Project Status'); ?> </font>
                    <div style="margin:0;color:#999999;line-height:16px;padding-left:20px;font-size:11px;">
                    </div>
                </div>
            </a></li>
    <?php } ?>
    <input type="hidden" id="totprojstsmanageId" value="<?php echo $str; ?>" readonly="true"/>


    <?php } ?>

