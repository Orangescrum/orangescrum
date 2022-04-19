<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Assign Project');?>
                <span><img src="<?php echo HTTP_IMAGES; ?>html5/icons/icon_breadcrumbs.png"></span>
                <span id="header_usr_prj_add" class="fnt-nrml ellipsis-view max-width-75"></span>
            </h4>
        </div>
        <div class="modal-body popup-container">
            <div>
                <div class="qtask fl width-100">
                    <!--<a href="javascript:void(0)" class="btn btn-raised btn-sm cmn-bxs-btn" onclick="setSessionStorage('Pop Up Add Project To User','Create Project');newProject(1);">
                        <i class="material-icons">&#xE145;</i><?php echo __('Create New Project');?>
                    </a>-->
                    <small id="pop_up_add_user_proj_label" style="display:none;"><?php echo __('Please check the below project(s) list and Save to add them to this User');?>.</small>
                </div>				
                <div class="fl width-30 btn_style" id="prjsrch" style="display:none;">
                    <div class="form-group label-floating">
                    <!-- <label class="control-label" for="proj_name"><i class="material-icons">search</i> <?php echo __('Search project');?></label> -->
                    <?php echo $this->Form->text('name', array('class' => 'form-control','id' => 'proj_name', 'maxlength' => '100', 'onkeyup' => "searchListWithInt('searchproj',600)", 'placeholder' => __('Search project'))); ?>
                    </div>
                </div>
                <div class="loader_dv"><center><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loading..." title="Loading..." /></center></div>
                <!-- <span id="prjpopupload1" class="ldr-ad-btn"><?php echo __('Loading projects');?>... <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" title="Loading..." alt="Loading..."/></span> -->
                <div class="cb"></div>
                <div class="popup-inner-container">
                    <div id="inner_usr_prj_add"></div>
                </div>
                <div class="cb"></div>
            </div>
        </div>
        <div class="modal-footer add-prj-btn" style="display: none;">
            <div class="fr popup-btn">
                <span id="prjloader" class="ldr-ad-btn fr"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="loading..." title="loading..."/></span>
                <span id="prjpopupload" class="ldr-ad-btn fr"><?php echo __('Loading projects');?>... <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" title="Loading..." alt="Loading..."/></span>
                <span id="confirmbtnprj" style="display:block;">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="confirmprjcls" onclick="assignproject(this)" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></a></span>
                    <div class="cb"></div>
                </span>
            </div>
        </div>
    </div>
</div>
