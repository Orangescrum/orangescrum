<style>
#editDeleteImg {
    top: 0px;
    right: 0px;
}
.edt_company_url {
	position: absolute;right: 0px;top: 0px;display:none;cursor:pointer;
}
.edt_company_url_cont:hover .edt_company_url {display:block;}
.vishidden{border: 1px solid #ddd;}
.vishidden #billing_detail{visibility: hidden;}
</style>
<div class="loader_bg" id="caseLoader"> 
	<div class="loadingdata">
		<img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="<?php echo __('loading');?>..."/>
	</div>
</div>
<div class="user_profile_con setting_wrapper task_listing credit-card-popup thwidth">
<!--Tabs section starts -->
    <?php #echo $this->element("company_settings"); ?>
<?php echo $this->Form->create('Company', array('url' => '/users/mycompany', 'onsubmit' => 'return submitCompany()', 'enctype' => 'multipart/form-data')); ?>
<div class="row my-company-section">
		<div class="col-lg-12 padlft-non">
    <div class="col-lg-6 padlft-non">
					<div class="mtop20">
            <div class="form-group form-group-lg label-floating company-name">
                <label class="control-label" for="cmpname"><?php echo __('Name');?></label>
                <?php echo $this->Form->text('name', array('value' => $getCompany['Company']['name'], 'class' => 'form-control', 'id' => 'cmpname', 'autocomplete' => 'off')); ?>
            </div>
			</div>
			<div class="mtop20">
            <div class="form-group form-group-lg label-floating company-url">
                <label class="control-label" for="secsite"><?php echo __('Orangescrum URL');?></label>
                <?php echo $this->Form->text('secsite', array('value' => HTTP_ROOT, 'name' => 'securesite', 'class' => 'form-control', 'id' => 'secsite', 'autocomplete' => 'off', 'disabled' => 'disabled')); ?>
            </div>
					</div>
			
					<div class="mtop20">
            <div class="form-group form-group-lg label-floating company-website">
                <label class="control-label" for="website"><?php echo __('Website');?></label>
                <?php echo $this->Form->text('website', array('value' => $getCompany['Company']['website'], 'class' => 'form-control', 'id' => 'website', 'autocomplete' => 'off')); ?>
            </div>
			</div>
			<div class="mtop20">
            <div class="form-group form-group-lg label-floating company-contact">
                <label class="control-label" for="contact_phone"><?php echo __('Contact Number');?></label>
                <?php echo $this->Form->text('contact_phone', array('value' => $getCompany['Company']['contact_phone'], 'class' => 'form-control', 'id' => 'contact_phone','autocomplete' => 'off')); ?>
            </div>
			</div>
			<div class="mtop20">
				<div class="form-group form-group-lg label-floating company-logo">
                <label class="control-label" for="contact_phone"><?php echo __('Logo');?></label>
                <?php
                $logo = isset($getCompany['Company']['logo']) && trim($getCompany['Company']['logo']) != '' ? trim($getCompany['Company']['logo']) : "";
				$img_exists_typ = 1;
                if ($logo != '') {
					if(defined('USE_S3') && USE_S3 == 1 && $this->Format->pub_file_exists(DIR_COMPANY_PHOTOS_S3_FOLDER . SES_COMP . '/', $logo)){
						$img_exists = 1;
						$img_exists_typ =2;
					}else if(file_exists(DIR_COMPANY_LOGO.$logo)){
						$img_exists = 1;
					}
                    ?>
                <?php } ?>
                <?php if ($img_exists == 1) { ?>
                    <div id="exit_company_logo" onmouseover="showEditDeleteImg()" onmouseout="hideEditDeleteImg()" style="max-height: 100px;position: relative;width: 190px;">
                        <?php 
							if($img_exists_typ == 2){ 
							$fileurl = $this->Format->generateTemporaryURL(DIR_COMPANY_PHOTOS_S3 . SES_COMP . '/' . $logo);
							}else{
								$fileurl = HTTP_ROOT.'files/company-logo/' . $logo;
							} ?>
                        <div>
                            <a rel="<?php echo $fileurl; ?>" >
                                <img src="<?php echo $fileurl; ?>" alt="" border="0" id="company_logo" class="mx-height-100" onclick="$('#logo').trigger('click');" style="cursor:pointer;max-width:100px;"/>
                            </a>
                        </div>
                        <div style="display:none" id="editDeleteImg">
                            <a title="Edit Company Logo" class="anchor" onclick="$('#logo').trigger('click');">
                               <i style="color:black" class="material-icons" class="ed_del">photo_camera</i>
                            </a>
                            <a title="Delete Company Logo" class="anchor" onclick="deleteCompanyLogo();">
                                <img src="<?php echo HTTP_IMAGES; ?>images/delete.png" border="0" class="ed_del" alt=""/>
                            </a>
                        </div>
                        <div class="cb"></div>
                    </div>
                <?php } else { ?>
                    <div id="default_company_logo" class="fl mtop10">
                        <img src="<?php echo HTTP_IMAGES; ?>default-invoice-logo.png" alt="" class="mx-height-100 anchor" id="company_logo" onClick="$('#logo').trigger('click');" />
                    </div>
                    <div id="uploadImgLnk" class="cc-logo fl">								
                        <a class="anchor" onClick="$('#logo').trigger('click');" ><?php echo __('Choose Company Logo');?></a>
                    </div>
										<div class="cb"></div>
                <?php } ?>
                <input type="file" id="logo" name="data[Company][logo]" style="display:none;" onchange="showPreviewImage('logo')" />
                <?php echo $this->Form->hidden('exst_logo', array('value' => $logo,'id'=>'exst_logo','data-dflt'=>HTTP_IMAGES."default-invoice-logo.png")); ?>
            </div>
        </div>
			</div>
				<div class="cb"></div>
        <div class="mtop20">
            <div id="subprof1" class="mrg_center">
                <input type="hidden" name="data[User][changepass]" id="changepass" readonly="true" value="0"/>
								<span class="fl cancel-link btn-margin"><button type="button" class="btn btn-default btn_hover_link cmn_size" onclick="cancelProfile('<?php echo $referer; ?>');"><?php echo __('Cancel');?></button></span>
								<span class="fl hover-pop-btn"><button type="submit" value="Update" name="submit_Pass"  id="submit_Pass" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Update');?></button></span>

                <?php /*<!--<button type="button" class="btn btn_grey" onclick="cancelProfile('<?php echo $referer; ?>');"><i class="icon-big-cross"></i>Cancel</button>-->
                <span class="or_cancel">or
                    <a onclick="cancelProfile('<?php echo $referer; ?>');">Cancel</a>
                </span> */ ?>
								<div class="cb"></div>
            </div>
            <span id="subprof2" style="display:none;"><img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/></span>
						<div class="cb"></div>
        </div>
<?php echo $this->Form->end(); ?>
</div>
</div>
<?php echo $this->Html->script(array('ajaxfileupload'));?>
</div>
<script type="text/javascript">
    function showPreviewImage(imgId) {
        $('#loader').show();
        var imgName = $('#'+imgId).val();
        prevUrl = "<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'companyLogo')) ?>";
				$('#caseLoader').show();
        $.ajaxFileUpload({
            url: prevUrl,
            secureuri: false,
            fileElementId: imgId,
            dataType: 'json',
            complete: function(data, status) {
						$('#loader').hide();
						$('#caseLoader').hide();
                var data = $.parseJSON(data.responseText);
                if(data.msg == "exceeds"){
                        showTopErrSucc('error',_("Logo exceeds the maximum upload size 2MB")+".");
                        return false;
                }
                if(typeof data.url != 'undefined'){
                var url = (data.url).replace(/&amp;/g, '&');
                }
                if (data.success == 'yes') {
                    $('#exst_logo').val(data.msg);
                    $("#company_logo").attr('src', url);
                } else {
                    showTopErrSucc('error',data.msg);
                }
            }
        });
    }
    function deleteCompanyLogo(){
        if(confirm("Are you sure to delete logo?")){
            $.ajax({
                url:"<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'deleteCompanyLogo')) ?>",
                method:"post",
                dataType:"json",
                success:function(response){
                    if(response.success == 'Yes'){
                        showTopErrSucc('success',response.msg);
                        $("#company_logo").attr('src', $('#exst_logo').attr('data-dflt'));
						setTimeout(window.location.reload(), 10000);
                    }else{
                        showTopErrSucc('error',response.msg);
                    }
                }
            });
        }
    }
</script>
<script type="text/javascript">
	function randomString(length, chars) {
		var mask = '';
		if (chars.indexOf('a') > -1) mask += 'abcdefghijklmnopqrstuvwxyz';
		if (chars.indexOf('A') > -1) mask += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		if (chars.indexOf('#') > -1) mask += '0123456789';
		var result = '';
		for (var i = length; i > 0; --i) result += mask[Math.round(Math.random() * (mask.length - 1))];
		return result;
	}
  function restrictAlpha(e) {
		var unicode = e.charCode ? e.charCode : e.keyCode;
		console.log(unicode);
		if (unicode != 8) {
			if (unicode < 9 || unicode > 9 && unicode <= 46 || unicode > 57 || unicode == 47 || unicode == 186 || unicode == 58) {
					if (unicode == 40 || unicode == 41 || unicode == 45) {
							return true;
					} else {
							return false;
					}
			} else {
					return true;
			}
		} else {
				return true;
		}
	}
</script>
