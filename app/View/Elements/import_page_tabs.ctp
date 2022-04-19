<div class="impexp_div">
    <div class="add-on-tab fl">
        <ul id="tabnav">
            <?php if ($mode == 'importexport') { ?>
                <li class="active-list"><a href="javascript:void(0)"><span><?php echo __('Import Task');?></span></a></li>
            <?php } elseif ($mode == 'importtimelog') { ?>
                <li><a href="<?php echo HTTP_ROOT . 'import-export'; ?>"><span><?php echo __('Import Task');?></span></a></li>
            <?php } elseif ($mode == 'importcustomers') { ?>
                <li><a href="<?php echo HTTP_ROOT . 'import-export'; ?>"><span><?php echo __('Import Task');?></span></a></li>
            <?php } elseif ($mode == 'importcomment') { ?>
                <li><a href="<?php echo HTTP_ROOT . 'import-export'; ?>"><span><?php echo __('Import Task');?></span></a></li>
                <li class="active-list"><a href="javascript:void(0)"><span><?php echo __('Import Comments');?></span></a></li>
            <?php } ?>

        </ul>
    </div>
    <?php if ($mode == 'importexport') { ?>
        <div class="fr btn_tlog_top">
            <a><button class="customfile-button btn btn-sm btn_cmn_efect" onclick="ajax_exportCsv(0);" rel="tooltip" title="<?php echo __('Export Task To CSV');?>">
                    <i class="material-icons">&#xE8D5;</i>
                </button></a>
        </div>
    <?php } ?>
    <div class="cb"></div>
</div>
<?php /* if(SES_COMP == '11848'){ */ ?>
<?php /* } */ ?>