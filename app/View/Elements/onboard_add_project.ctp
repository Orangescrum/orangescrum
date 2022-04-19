<div style="width:600px;margin:10px auto 0;">
<center><div id="err_msg_onboard" style="color:#FF0000;display:none;"></div></center>
<?php  echo $this->Form->create('Project',array('url'=>'/projects/add_project','id'=>'projectadd_onboard')); ?>
    <div class="data-scroll">
    <table cellpadding="0" cellspacing="0" class="col-lg-10">
	<tr>
	    <td class="popup_label"></td>
	    <td>
		<?php echo $this->Form->text('name',array('value'=>'','class'=>'form-control','id'=>'txt_Proj_onboard','placeholder'=>__("My Project",true),'maxlength'=>'50','style'=>'font-weight:bold;')); ?>
                <?php echo $this->Form->text('short_name', array('value' => '', 'class' => 'form-control ttu', 'id' => 'txt_shortProj_onboard','placeholder'=>"MP",'maxlength'=>'5','style'=>'display:none;')); ?>
		
	    </td>
	</tr>
    </table>    
    </div>
    <div style="padding-left:61px;">
            <input type="hidden" name="data[Project][validate]" id="validate_onboard" readonly="true" value="0"/>
            <span id="loader_onboard" style="display:none;">
                <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
            </span>
            <span id="btn_onboard">
                <button type="button" value="Create" name="crtProject" class="btn btn_blue" onclick="return projectOnboardAdd('txt_Proj_onboard','txt_shortProj_onboard','loader_onboard','btn_onboard');"><i class="icon-big-tick"></i><?php echo __('Create Project');?></button>
            </span>
    </div>
<?php echo $this->Form->end(); ?>
</div>
