<?php if ($opt_as == 'list') { 
    if (isset($tsklist) && !empty($tsklist)) {
        foreach ($tsklist as $k => $v) {
            foreach ($v as $k1 => $v1) {
                ?>
                <a href="javascript:void(0);" onclick="setLogTask(<?php echo $k; ?>, this);"  class="logTasks" id="logTask_<?php echo $k; ?>" >#<?php echo $k1 . ': ' . h($v1,true, 'UTF-8'); ?></a>
                <?php
            }
        }
    } else {
        ?>
        <a class="logTasks"  style="color: red"><?php echo __('No task found');?>.</a>
    <?php }
    } else { ?>
<option value="0"> <?php echo $page == 'timer' ? __('Select Task',true) : '-- '.__('Select',true).' --'; ?></option>
    <?php if (isset($tsklist)) { ?>
        <?php foreach ($tsklist as $k => $v) { ?>
        <?php foreach ($v as $k1 => $v1) { ?>
            <option value= "<?php echo $k; ?>" ><?php echo $page == 'timer' && strlen($v1) > 26 ? '#'.$k1.': '.h($this->Format->shortLength(h($v1, true, 'UTF-8'), 23), true, 'UTF-8') : '#'.$k1.': '.h($v1, true, 'UTF-8'); ?></option>
            <?php
						}
				}
    }
}
?>