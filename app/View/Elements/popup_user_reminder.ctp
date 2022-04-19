<?php 
//avoid using bootstrap min as it destroy the originl css
//echo $this->Html->css('bootstrap.min.css'); 
echo $this->Html->script('adv-tinymce/tinymce/tinymce.min');
?>
<?php /*<script type="text/javascript" src="js/tinymce/tinymce.min.js"></script>*/ ?>
<div class="modal-dialog" id="dialog-form-reminder" style="display: none; position: relative; box-sizing: border-box; width: 100%;height:500px;">
    <div class="modal-content" style="height:500px;">
        <div class="modal-header" style="padding: 15px 20px 0px; display: table; clear: both; width: 100%; box-sizing: border-box; text-align: left;">
            <button style="min-width:24px; padding: 0px; opacity: 0.2; float: right; background: transparent none repeat scroll 0px 0px; border: 0px none; line-height: 1px; margin: 0px; " type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 style="color: rgb(34, 34, 34); font-size: 20px; display: inline-block; font-weight: normal; line-height: 25px; margin: 0px;"><?php echo __('Send Remainder email to');?> <span id="uNameReminder"></span></h4>
        </div>
        <div class="modal-body popup-container" style="padding: 10px 24px;">
            <form onsubmit="" id="userReminder" method="POST" action="<?php echo $this->Html->url(array('controller' => 'users', 'action' => 'reminder_email')); ?>">
                <?php echo $this->Form->input('company_Id', array('label' => false, 'type' => 'hidden','id'=>'reminderCID')); ?>
                <?php echo $this->Form->input('user_id', array('label' => false, 'type' => 'hidden','id'=>'reminderUID')); ?>                
                <div id="company_err_reminder" class="err_msg"></div>
                <div class="form-group">                   
                    <?php echo $this->Form->input('user_email', array('label' => false, 'class' => 'required', 'required' => 'required', 'style'=>'width:96%; padding:10px', 'id'=>'reminderEMAIL','placeholder'=>__('Email Id',true))); ?>
                </div>
                <div class="form-group">          
                    <?php echo $this->Form->input('user_subject', array('label' => false,'class' => 'required', 'required' => 'required','style'=>'width:96%; padding:10px','id'=>'reminderSubject','placeholder'=>__('Email Subject',true))); ?>
                </div>
                <div class="form-group">                   
                    <?php echo $this->Form->textarea('user_message', array('label'=>false,'class'=>'required', 'required' => 'required', 'style'=>'width:96%; padding:10px', 'id'=>'reminderMSG','placeholder'=>__('Messages',true))); ?>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <img src="<?php echo HTTP_ROOT . "img/images/case_loader2.gif"; ?>" alt="Loading" id="company_loader_reminder" style="display:none;" alt="" class="fr"/>
                <div id="reminder_btnn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();" style="border: medium none; background: transparent none repeat scroll 0px 0px; margin: -3px 0px 0px; line-height: 16px;"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a id="userNreminderBTN" data-ridd="" href="javascript:void(0)" onclick="sendCompanyReminder(this);" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __('Send');?></a></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var updateRemin = "<?php echo $this->Html->url(array('controller' => 'osadmins', 'action' => 'reminder_email')) ?>";
    function initializeEditor(){
				tinymce.init({
					selector: "#reminderMSG",
					plugins: 'image paste importcss autolink directionality fullscreen link  template  table charmap hr pagebreak nonbreaking anchor advlist lists wordcount autoresize imagetools help',
					menubar: false,
					branding: false,
					statusbar: false,
					toolbar: 'bold italic underline strikethrough | outdent indent | numlist bullist | forecolor backcolor fullscreen',
					toolbar_sticky: true,
					/*autosave_ask_before_unload: true,
					autosave_interval: "30s",
					autosave_restore_when_empty: false,
					autosave_retention: "2m",*/
					importcss_append: true,
					image_caption: true,
					browser_spellcheck: true,
					quickbars_selection_toolbar: 'bold italic | quicklink h2 h3',
					//directionality: dir_tiny,
					toolbar_drawer: 'sliding',
					contextmenu: "link",
					resize: false, 
					min_height: 180,
					max_height: 300,
					paste_data_images: false,
					paste_as_text: true,
					autoresize_on_init: true,
					autoresize_bottom_margin: 20,
					content_css: HTTP_ROOT+'css/tinymce.css',
					//paste_auto_cleanup_on_paste : true,
					setup: function(ed) {
							ed.on('Click',function(ed, e) {
							});
							ed.on('KeyUp',function(ed, e) {
							});
							ed.on('Change',function(ed, e) {
							});
							ed.on('init', function(e) {
							});
						}
					});
        /*tinymce.init({
            mode : "exact",
            elements : "reminderMSG",
            height : "250px",
            theme : "advanced",
            skin : "o2k7",
            plugins : "safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups",
            theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,code,preview",
            theme_advanced_buttons2 : "search,|,bullist,numlist,outdent,indent,|,undo,redo,|,image,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,emotions,|,ltr,rtl,|,fullscreen, |,link",
            theme_advanced_toolbar_location : "top",
            theme_advanced_toolbar_align : "left",
            theme_advanced_statusbar_location : "bottom",
            theme_advanced_resizing : false,
            // Example content CSS (should be your site CSS)
            content_css : "css/content.css",
            // Drop lists for link/image/media/template dialogs
            template_external_list_url : "lists/template_list.js",
            external_link_list_url : "lists/link_list.js",
            external_image_list_url : "lists/image_list.js",
            media_external_list_url : "lists/media_list.js",
            // Replace values for the template plugin
            template_replace_values : 
            {
                    username : "Some User",
                    staffid : "991234"
            }
        });*/
    }


function sendCompanyReminder(el) {    
    var error = 0;
    var user_id = $('#reminderUID').val();
    var company_Id = $('#reminderCID').val();
    var userEmail = $('#reminderEMAIL').val();
    var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    var letterNumber = /^[0-9a-zA-Z]+$/;
    var onlyNumber = /^\d+\.\d{0,2}$/;
    var remindSubject = $('#reminderSubject').val();

   if(userEmail.trim() == ""){
       $("#company_err_reminder").html('<?php echo __('Email id is required');?>.');
        $("#reminderEMAIL").focus();
        error = 1;
   }else if (!userEmail.match(emlRegExpRFC) || userEmail.search(/\.\./) != -1) {
        $("#company_err_reminder").html('<?php echo __('Invalid email');?>!');
        $("#reminderEMAIL").focus();
        error = 1;
    }
   if(remindSubject.trim() == ""){
       $("#company_err_reminder").html('<?php echo __('Subject is required');?>.');
        $("#reminderSubject").focus();
        error = 1;
   }
    if (error == 1) {
        return false;
    } else {
        $('#userNreminderBTN').hide();
        $('#company_loader_reminder').show();
				$('#reminderMSG').val(tinymce.get('reminderMSG').getContent());
        var e = $("#userReminder");
        v = e.serialize();
        $.post(updateRemin, {
            v: v
        }, function(res) {
            if (res == "success") {
							tinymce.get('reminderMSG').setContent('');
							$('#company_loader_reminder').hide();
							$('#userNreminderBTN').show();
							closePopup();
							showErrSucc('success', "Email sent Successfully!");
							$('#mng-btn-str-'+row_id).attr('onclick', "showManagePopup('"+company_Id+"', '"+user_count+"', '"+storageLimit+"', '"+sub_id+"','"+row_id+"')");
            } else {
                $('#company_loader_reminder').hide();
                $('#userNreminderBTN').show();
                showErrSucc('error', "<?php echo __('Problem in sending email. Please try later');?>!");
            }
        });
    }
}
</script>