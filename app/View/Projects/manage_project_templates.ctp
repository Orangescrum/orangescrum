<style>
  .templates_modal .modal-dialog{width:700px;text-align:center}
.templates_modal .close{position:absolute;right:-35px;top:-30px;text-shadow:none;opacity:1}
.templates_modal .close .material-icons{font-size:40px;line-height:40px;color:#fff;}
.templates_modal .close .material-icons:hover{color:#ff0000;}
.templates_modal .templates_items{display: flex;flex-direction: column;align-items: center;justify-content: start;}
.templates_modal .template_image{margin:0;width:100%;height:250px;}
.templates_modal .template_image img{max-width:100%}
.templates_modal h4{font-size:24px;line-height:30px;color:#000;font-weight: 600;margin:15px 0}
.templates_modal p{font-size:16px;line-height:28px;color:#000;font-weight: 500;margin:0;padding:0}
.templates_modal ul{margin:10px 0 0;padding:0;list-style-type:none}
.templates_modal ul li{display:block;font-size:14px;line-height:24px;color:#333;font-weight: 500;padding:0 0 0 30px;margin-top:10px;position:relative;text-align:left}
.templates_modal ul li::before{content:'';background:url(../../img/pricing_tik.png) no-repeat 0px 0px;background-size:100% auto;width:18px;height:18px;display:inline-block;vertical-align:middle;position:absolute;left:0;top:5px;}
.ptModal_popup .modal-content .modal-body{padding:20px;}
</style>
<div class="cmn_template_page">
<?php if($this->Format->displayHelpVideo()){ ?>
<div class="mbtm10 text-right">
<a href="javascript:void(0);" class="help-video-pop " video-url = "https://www.youtube.com/embed/QPCt9lvFxP4" onclick="showVideoHelp(this);"><i class="material-icons">play_circle_outline</i><?php echo PLAY_VIDEO_TEXT;?></a>
</div>
<?php } ?>
<div class="cb"></div>
         <div class="row">
            <?php foreach($methodologies as $k=>$v){ ?>
                <?php if($k != 0 && $k%4 == 0){ ?>
                    <div class="height_30_cb"></div>
                <?php } ?>
            <div class="col-md-3">
                <div class="report_box">                
                    <div class="box_bg_ft">
                        <figure>
                            <img src="<?php echo HTTP_ROOT; ?>img/project_template_icons/<?php echo $v['ProjectMethodology']['thumbnail'];?>" alt="<?php echo $v['ProjectMethodology']['title'];?>"/>
                        </figure>
                    </div>
							<h5><?php echo $v['ProjectMethodology']['title'];?></h5>
                    <p><?php echo $v['ProjectMethodology']['short_description'];?></p>
							<a href="javascript:void(0);" class="dash_report_sprint" title="<?php echo $v['ProjectMethodology']['title'];?>" onclick="openProjectTemplate(<?php echo $v['ProjectMethodology']['id'];?>);" ><strong>What's inside ?</strong>
                </a>
				 <?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
					<a href="javascript:void(0);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="newProject('', '', '', '',0,<?php echo $v['ProjectMethodology']['id'];?>);trackEventLeadTracker('Project Template','Create <?php echo $v['ProjectMethodology']['title'];?> Project','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" title="<?php echo __("Create Project");?>" ><?php echo __("Create Project");?></a>
				 <?php } ?>
                </div>
            </div>
        <?php } ?>
            <div class="height_30_cb"></div>       
        </div>
    </div>

<div id="ptModal" class="modal fade ptModal_popup templates_modal" role="dialog">
  <div class="modal-dialog">


    <?php foreach($methodologies as $k=>$v){ ?>
    <div class="modal-content common-content-pt common-content-pt-<?php echo $v['ProjectMethodology']['id'];?>">
    <button type="button" class="close" data-dismiss="modal"><i class="material-icons">&#xE14C;</i></button>
      <div class="modal-body">
      <div class="templates_items">
        <figure class="template_image">
          <img src="<?php echo HTTP_ROOT; ?>img/project_template_icons/<?php echo $v['ProjectMethodology']['full_image'];?>" />
        </figure>
        <h4 class="modal-title"><?php echo $v['ProjectMethodology']['title'];?></h4>
        <?php echo $v['ProjectMethodology']['description'];?>
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		<?php if($this->Format->isAllowed('Create Project',$roleAccess)){ ?>
         <button type="button" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="newProject('', '', '', '',0,<?php echo $v['ProjectMethodology']['id'];?>); trackEventLeadTracker('Project Template','Create <?php echo $v['ProjectMethodology']['title'];?> Project','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" data-dismiss="modal"><?php echo __("Create Project");?></button>
		  <?php } ?>   
      </div>
    </div>

    <?php } ?>    
  </div>
</div>
<script>
    function openProjectTemplate(id){
        $("#ptModal").modal('show');
        $(".common-content-pt").hide();
        $(".common-content-pt-"+id).show();

    }
</script>