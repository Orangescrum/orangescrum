<div id="helpvideo" class="modal fade help_video">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                 <h4 class="modal-title"><?php echo __('Help');?></h4>
            </div>
            <div class="modal-body">
				<ul class="help-tabs">
				  <li><a href="#how-to" onclick="trackEventLeadTracker('Help Video','How to Tab','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" ><?php echo __('How-to');?></a></li>
				  <!--li><a href="#support">Support</a></li-->
                                  <?php if(PAGE_NAME != "customer_support" && PAGE_NAME != 'help' && CONTROLLER != 'ganttchart') { ?>
				  <li><a href="#help_subjects" onclick="pauseYTVideo();trackEventLeadTracker('Help Video','Help & Support Tab','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');"><?php echo __('Help & Support');?></a></li>
<!--				  <li><a href="#help_live_chat" onclick="pauseYTVideo();trackEventLeadTracker('Help Video','Live chat Tab','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">Live Chat</a></li>-->
                                  <?php } ?>
				</ul>
				<div class="tab-content" id="nav-tabContent">
				  <div id="how-to">
					<h5 id="yt_video_title"><?php echo __('Getting Started');?></h5>
                                        <div class="player_wrapper11">
<!--					 <div id="player_1"></div>-->
                                         
                                        </div>
					 <div id="next_video_btn"><a href="javascript:void(0);" class="get_support_btn" onclick="playNextVideo();"><?php echo __('Next Video');?></a></div>
    
                                        <h6><?php echo __('Videos');?></h6>
					<div class="tagbtn">
                                            <?php 
                                            if($os_locale =='spa'){
                                                 $video_ids = Configure::read('VIDEO_IDS_SPA');
                                            }else if($os_locale =='por'){
                                                 $video_ids = Configure::read('VIDEO_IDS_POR'); 
										                        }else if($os_locale =='deu'){
                                                 $video_ids = Configure::read('VIDEO_IDS_DEU');
                                             }else if($os_locale =='fra'){
                                                 $video_ids = Configure::read('VIDEO_IDS_FRA');
                                             }else{
                                                $video_ids = Configure::read('VIDEO_IDS');
                                             }
                                            $objstr = '';
                                            foreach($video_ids as $k=>$v){
                                                $objstr .= $v['1'].",";
                                                ?>
                                                <a href="javascript:void(0);" id="<?php echo $v['1'];?>" onclick="play_video('<?php echo $v['1']; ?>');trackEventLeadTracker('Help Video','<?php echo $v['0'];?>','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');" <?php if($k ==0 ){echo " class='active displayed'";}?> ><?php echo $v['0']; ?></a>
                                            <?php } ?>
					</div>
                                        <div class="help_note"><p class="help_note_txt"><b><?php echo __('Note');?>:</b> <?php echo __('Please select 720p in the video settings for better visibility');?></p></div>
				  </div>
				  <!--div id="support">
					<h5>Orangescrum Support</h5>
					<p>Please visit our <a href="">customer support portal</a> to ask a question and view answers to common questions.</p>
					<a href="javascript:void();" class="get_support_btn">Get Support</a>
				  </div-->
                                     <?php if(PAGE_NAME != "customer_support" && PAGE_NAME != 'help' && CONTROLLER != 'ganttchart') { ?>
                                  <div id="help_subjects" class="pr"></div>
<!--                                  <div id="help_live_chat" class="pr">
                                      <span class="absLivChatLnk"><a class="btn btn-sm btn-raised  btn_cmn_efect cmn_bg btn-info btn-live-chat" href="<?php echo CUSTOMER_SUPPORT_URL; ?>" target="_blank" onclick="trackEventLeadTracker('Footer Right','Live Chat','<?php echo $_SESSION['SES_EMAIL_USER_LOGIN'];?>');">Live Chat</a></span>
                                     </div>-->
                                     <?php } ?>
				</div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function(){
       $('#helpvideo').on('hidden.bs.modal', function () { 
           document.getElementById('play_yt_video').contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
       });
       $('#helpvideo').on('shown.bs.modal', function (e) {
            <?php if(PAGE_NAME != "customer_support" && PAGE_NAME != 'help' && CONTROLLER != 'ganttchart') { ?>
            if($('#help_subjects').html() == ""){ 
                helpDesk();
            }
            <?php } ?>
       });
    });
    
      var playlist_json = <?php echo json_encode($video_ids);?>;
      
      var video_history = localStorage.getItem("videoHistory");
      
      if(video_history != null && video_history != ''){
          video_history = JSON.parse(video_history);
          for(var i =0; i < video_history.length;i++){              
              $("#"+video_history[i]).addClass('displayed');
          }
          
      }else{
          video_history = new Array();
      }
      function pauseYTVideo(){
           document.getElementById('play_yt_video').contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
      }
      function play_video(id){   
         $("#"+id).addClass('displayed');
         if (video_history.indexOf(id) == -1) {
            video_history.push(id); 
         }
         localStorage.setItem("videoHistory",JSON.stringify(video_history));
         $("#play_yt_video").attr('src','https://www.youtube.com/embed/'+id+'?rel=0&enablejsapi=1');
        $("#yt_video_title").text($("#"+id).text());
         $(".help_video .tagbtn").find('a').each(function(){ 
            $(this).removeClass('active');
            if($(this).attr('id') == id){
                $(this).addClass('active displayed');
            }
        });
      }
    </script>