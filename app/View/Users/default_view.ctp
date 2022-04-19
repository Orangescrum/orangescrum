<div class="setting_wrapper task_listing cmn_tbl_widspace width_hover_tbl default-view-page">
    <?php echo $this->Form->create('DefaultView', array('url' => '/users/saveDefaultView', 'onsubmit' => 'return validateDefaultViewForm()', 'name' => 'defaultviewform')); ?>
    <input name="default_view_id" type="hidden" value="<?php echo $id; ?>" />
		<div class="row">
		<div class="col-lg-12">
    <div class="col-lg-4 col-sm-4 padlft-non">
		<?php if(defined('CMP_CREATED') && CMP_CREATED >= '2018-01-17 00:00:59' && 0){ ?>
        <div class="form-group custom-drop-lebel cmn-popup dflt-drpdwn">
            <?php echo $this->Form->select('defaulttaskview', $def_views, array('value' => $defview, 'class' => 'form-control floating-label ', 'placeholder' => 'Show my tasks in', 'data-dynamic-opts' => 'true', 'empty' => false)); ?>
            <?php echo $this->Form->input('taskviews', array('value' => $taskview, 'type' => 'hidden')); ?>
            <?php echo $this->Form->input('kanbanview',array('value' => $kanbanview,'type' => 'hidden')); ?>
        </div>
		<?php }else{ ?>
			<div class="form-group custom-drop-lebel cmn-popup dflt-drpdwn">
				<?php echo $this->Form->select('taskviews', $task_views, array('value' => $taskview, 'class' => 'form-control floating-label', 'placeholder' => __('Tasks',true), 'data-dynamic-opts' => 'true', 'empty' => false)); ?>
			</div>
			<?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
			<?php }else{ ?>
			<div class="form-group custom-drop-lebel cmn-popup dflt-drpdwn">
				<?php echo $this->Form->select('kanbanview', $kanban_views, array('value' => $kanbanview, 'class' => 'form-control floating-label ', 'placeholder' => __('Kanban',true), 'data-dynamic-opts' => 'true', 'empty' => false)); ?>
			</div>
			<?php } ?>
		<?php } ?>
        <div class="form-group custom-drop-lebel cmn-popup dflt-drpdwn">
            <?php echo $this->Form->select('timelogview', $timelog_views, array('value' => $timelogview, 'class' => 'form-control floating-label ', 'placeholder' => __('Time Log',true), 'data-dynamic-opts' => 'true', 'empty' => false)); ?>
        </div>
        <div class="form-group custom-drop-lebel cmn-popup dflt-drpdwn">
            <?php echo $this->Form->select('projectview', $project_views, array('value' => $projectview, 'class' => 'form-control floating-label ', 'placeholder' => __('Projects',true), 'data-dynamic-opts' => 'true', 'empty' => false)); ?>
        </div>
				</div>
				<div class="cb"></div>
        <div class="row">
            <div class=" col-lg-12">
                <div class="btn_row fr">
                    <div id="defaultView-btns ">
                        <div class="fl"><a class="btn btn-default btn_hover_link cmn_size" onclick="cancelProfile('<?php echo $referer; ?>');"><?php echo __('Cancel');?></a></div>
						<div class="fl btn-margin">
							<span id="defaultView-loader" style="display:none">
								<img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." />
							</span>
							<button type="submit" name="submit_defaultView" id="submit_defaultView" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></button></div>
						<div class="cb"></div>
                    </div>                    
                </div>
            </div>
        </div>
    <?php echo $this->Form->end(); ?>
		</div>
		</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.material.init();
        //$(".select").dropdown({"optionClass": "withripple"});
        <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
            $("#DefaultViewTaskviews, #DefaultViewTimelogview, #DefaultViewProjectview").select2({minimumResultsForSearch: -1});
        <?php }else{ ?>
        $("#DefaultViewTaskviews, #DefaultViewKanbanview, #DefaultViewTimelogview, #DefaultViewProjectview").select2({minimumResultsForSearch: -1});
         <?php } ?>
    });
    function validateDefaultViewForm() {
        $('#submit_defaultView').hide();
        $('#defaultView-loader').show();
        var taskview = $('#DefaultViewTaskviews').val();
        var timelogview = $('#DefaultViewTimelogview').val();
         <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
            <?php }else{ ?>
        var kanbanview = $('#DefaultViewKanbanview').val();
        <?php } ?>
        var projectview = $('#DefaultViewProjectview').val();
        var done = 1;
        if (!taskview) {
            showTopErrSucc('error', '<?php echo __('Please Select a Task view.');?>');
            done = 0;
        }
        if (!timelogview) {
            showTopErrSucc('error', '<?php echo __('Please Select a Time Log view.');?>');
            done = 0;
        }
        <?php if(defined('COMP_LAYOUT') && COMP_LAYOUT){ ?>
            <?php }else{ ?>
        if (!kanbanview) {
            showTopErrSucc('error', '<?php echo __('Please Select a Kanban view.');?>');
            done = 0;
        }
    <?php } ?>
        if (!projectview) {
            showTopErrSucc('error', '<?php echo __('Please Select a Project view.');?>');
            done = 0;
        }
        if (done == 1) {
            $('#DefaultViewDefaultViewForm').submit();
        } else {
            $('#submit_defaultView').show();
            $('#defaultView-loader').hide();
            return false;
        }
    }
</script>
