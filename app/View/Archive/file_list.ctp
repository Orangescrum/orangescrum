<?php
if (count($file)) {
    $count = $lastCountFiles;
    foreach ($file as $fil) {
        $external_link = "";
        $count++;
        $caseDtUploaded = $fil['Archive']['dt_created'];
        $updated = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, $caseDtUploaded, "datetime");
        $updatedCur = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "date");
        $displayTime = $this->Datetime->dateFormatOutputdateTime_day($updated, $updatedCur);
        $d_name = $fil['CaseFile']['file'];
        if ($fil['CaseFile']['display_name']) {
            $d_name = $fil['CaseFile']['display_name'];
        }
        /**
         * Add for showing file from external source. for e.g. google drive / dropbox
         */
        if ($fil['CaseFile']['downloadurl'] != "") {
            $external_link = $fil['CaseFile']['downloadurl'];
        } else {
            $url = $fil['CaseFile']['upload_name'] != '' ? $fil['CaseFile']['upload_name'] : $fil['CaseFile']['file'];
        }
        ?>
        <tr class="tr_all all_first_rows_files" id="fllisting<?php echo $count; ?>" data-value="<?php echo $count; ?>">
            <td>
                <div class="checkbox">
                    <label>
                        <input id="file<?php echo $count; ?>" value="<?php echo $fil['CaseFile']['id']; ?>" type="checkbox" style="cursor: pointer;" class="mglt chkOneArcFile">
                    </label>
                </div>
            </td>
            <td><a class="cmn_link_color"  href="<?php echo HTTP_ROOT; ?>dashboard#details/<?php echo $fil['Easycase']['uniq_id'] ?>">#<?php echo $fil['Easycase']['case_no'] ?></a></td>
            <td>			
        <?php if ($external_link != "") { ?>
                    <a class="cmn_link_color" title="<?php echo $d_name; ?>" href='<?php echo $external_link; ?>' target="_blank">
                <?php } else { ?>
                        <a class="cmn_link_color" title="<?php echo $d_name; ?>" href='<?php echo HTTP_ROOT; ?>easycases/download/<?php echo $url; ?>'>
                    <?php } ?>
                        <?php echo $d_name; ?>
                    </a>
            </td>	
            <td class="ftype_width">
        <?php
        $file_type = $fil['CaseFile']['file'];
        echo $this->Format->getFileType($file_type);
        ?>
<!--                <span class="os_sprite play_file "></span>-->
<!--               <span class="os_sprite play_file <%= easycase.imageTypeIcon(obj.file_type)%>_file"></span>-->
            </td>
            <td><?php echo $displayTime; ?></td>
            <td>
        <?php echo $this->Format->getFileSize($fil['CaseFile']['file_size']); ?>
            </td>
            <td>
        <?php
        if ($fil['Easycase']['project_id']) {
            $projectname = $this->Casequery->getpjname($fil['Easycase']['project_id']);
            echo $projectname;
        }
        ?>
            </td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr class="empty_task_tr">
        <td colspan="7">
            <?php echo $this->element('no_data', array('nodata_name' => 'filelist')); ?>
        </td>
    </tr>
<?php } ?>

<?php if ($lastCountFiles < 10) { ?>
    <?php /* ?><input type="hidden" id="all" class="all_count" value="<?php echo $count;?>"><?php */ ?>
    <input type="hidden" id="filepjid" class="filepjid" value="<?php echo $pjid; ?>">
    <input type="hidden" id="totalFiles" class="total_file_count" value="<?php echo $caseCountt; ?>">
    <input type="hidden" id="displayedFiles" value="<?php echo ARC_FILE_PAGE_LIMIT; ?>">
<?php } ?>