<style type="text/css">
	#tutorialpdf_modal .modal-content {background-color: #ff7a59;}
	#tutorialpdf_modal .close {font-size: 35px;font-weight: 100;position: absolute;right: 10px;
    top: 5px; outline: none;z-index: 1}
	#tutorialpdf_modal .modal-body {border: none;position: relative;display: block;padding:20px 40px 30px 90px;}
	#tutorialpdf_modal .modal-dialog {width: 600px;}
	#tutorialpdf_modal .modal-title {font-size:24px;line-height:40px;color: #fff;font-weight: 600;text-transform: uppercase;text-align: center;margin-bottom: 20px;}
	#tutorialpdf_modal .modal-title span {color: #38b10e;}
	
	#tutorialpdf_modal .pdf_form input {width: 100%; height: 45px;font-size: 14px;color: #fff;
    font-weight: 500;line-height: 45px;padding: 0 15px; border: 2px solid #f7937a;
    box-shadow: none;margin: 0;background-image: none;background-color: #fb7e5f; border-radius: 4px;margin-bottom: 20px;}
	#tutorialpdf_modal .pdf_form input.send_btn{font-weight:600;background-color: #38b10e;border-radius:30px;box-shadow: none;}
	#tutorialpdf_modal .pdf_form input.send_btn:hover{opacity:0.8}
	#tutorialpdf_modal .pdf_form p{margin-top:20px;color:#fff}
	#tutorialpdf_modal .pdf_form p small{font-size:14px;color:#fff}
	#tutorialpdf_modal .tutorialcopy{position:absolute;left:-145px;bottom:35px;transform: rotate(-10deg);-webkit-transform: rotate(-10deg);    -moz-transform: rotate(-10deg);}
	#tutorialpdf_modal .thankyou{font-size:35px;line-height:40px;color:#fff;position:static;width:100%;background: none;border: none;}
	
	
	#tutorialpdf_modal .pdf_form input::-webkit-input-placeholder { 
		color: #fff;text-transform: uppercase;
	}
	#tutorialpdf_modal .pdf_form input::-moz-placeholder { 
		color: #fff;text-transform: uppercase;
	}
	#tutorialpdf_modal .pdf_form input:-ms-input-placeholder { 
		color: #fff;text-transform: uppercase;
	}
	#tutorialpdf_modal .pdf_form input:-moz-placeholder { 
		color: #fff;text-transform: uppercase;
	}
</style>
 <?php 
	if(!empty($this->params->pass['1']) || (isset($nocond) && $nocond)){ $filename = $this->params->pass['1']; 
		if(isset($nocond) && $nocond){
			$filename = 'project-management-reporting-and-metrics';
		}
		?>
  <section class="download_pdf_sec" id ="tutorialDownloadSection">
	  	<div class="dtbl">
	  		<div class="dtbl_cel">
	  			<input type="button" value="Download tutorial" title="Download tutorial" class="download_pdf_btn" onclick="showDownloadForm();">
	  			<!-- <a href="<?php echo HTTP_ROOT;?>pages/downloadTutorialPdf/<?php echo $filename ;?>">Download PDF</a> -->
	  		</div>
	  	</div>
	  	<div class="modal fade cmn-popup" id="tutorialpdf_modal" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-body">
						<div class="digital_copy">
							<h4 class="modal-title">Download your <br><span>FREE</span> Digital Copy</h4>
							<figure class="tutorialcopy">
								<img src="<?php echo HTTP_ROOT;?>img/home_outer/tutorial/orangescrum-tutorial.png" alt="Orangescrum Tutorial" width="238" height="300" />
							</figure>
							<div class="pdf_form">
								<form class="formClas" action="javascript:void(0);" id="downloadFormId">
									<input type="hidden" name="filename" value= "<?php echo $filename;?>"" " placeholder="Your Name" id="tusrname_file">
									<input type="text" name="username" placeholder="Your Name" id="tusrname">
									<input type="hidden" name="lastname" id="tu_lastname">
									<input type="hidden" name="middlename" id="tu_middlename">
									<p class="tusrname_error error"  style="display: none;">Please enter your name.</p>
									<input type="email" name="useremail" placeholder="Your Email Address" id="temail">
									<input type="hidden" name="phone" placeholder="Your Name" id="phone">
									<p class="temail_error error" style="display: none;">Please enter your email.</p>
									<input type="button" id ="attachBtn" value="Send" class="send_btn" onclick="sendTutorialAttachement();">
								</form>
							<p><small>We're committed to your privacy. Orangescrum uses the information you provide to us to contact you about our relevant content, products, and services. You may unsubscribe from these communications at any time. For more information, check out our <a href="<?php echo HTTP_ROOT;?>privacypolicy" target="_blank">Privacy Policy</a>.</small></p>
							</div>
						</div>
						<div class="thankyou" id="responseTutorialId" style="display:none;">
							Thanks for your interest. We have sent the tutorial to your email, please check. 
						  <!--<span onclick="remove()">x</span> -->
						  </div>
					</div>
				</div>
			</div>
		</div>
	  </section>
<?php } ?> 

<script type="text/javascript">
	function showDownloadForm(){
		//$(".pdf_form").show();
		$('#tutorialpdf_modal').find('.modal-title').html($('.banner').find('h1').text());
		$('#tutorialpdf_modal').modal({show: true, backdrop: 'static', keyboard: false});
	}
  function remove(){
    $("#responseTutorialId").hide();
	$('.download_pdf_btn').show();
  }
</script>