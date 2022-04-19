<?php if (count($allProjects)) { ?>
    <?php foreach ($allProjects as $key => $value) { ?>
        <li>
            <div class="checkbox">
                <label id="project_checked_labl_<?php echo $value['Project']['id']; ?>" for="project_checked_<?php echo $value['Project']['id']; ?>" class="ellipsis-view" style="max-width:302px;" title="<?php echo $value['Project']['name']; ?>">
                    <input type="checkbox" id="project_checked_<?php echo $value['Project']['id']; ?>" class="fl" value="<?php echo $value['Project']['id']; ?>" />
                    <span class="check-box-txt"><?php echo $value['Project']['name']; ?></span>
                </label>
            </div>
        </li>
    <?php } ?>
<?php
} else {
    echo __('No projects found.');
}?>