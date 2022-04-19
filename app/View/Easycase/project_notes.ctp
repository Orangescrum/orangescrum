<div class="task_group_catagory">

	<?php if(empty($notes)){ ?>
	<script>
		$(function(){
			$('#proj_note_link').hide();
			$('#proj_note_link_cont').show();
		});
	</script>
	<?php } ?>
	<?php if(!empty($notes)){ ?>
		<?php foreach($notes as $k => $note){ ?>
			<div class="project_not_contain">
				<div class="proj_note_dtl">
					<div class="project_note_profile">
						<div class="prof_sett">
							<?php if(!empty($note['User']['photo'])) { ?>
								<img src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=photos&file=<?php echo $note['User']['photo']; ?>&sizex=28&sizey=28&quality=100" class=" round_profile_img" height="28" width="28" />
							<?php } else {
								$random_bgclr = $this->Format->getProfileBgColr($note['User']['id']);
								$usr_name_fst = mb_substr(trim($note['User']['name'].' '.$note['User']['last_name']),0,1, "utf-8");
							?>
								<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
							<?php } ?>
						</div>
					</div>
					<div class="project_note_created">
						<?php
							//$created_on_ttl = $dt->facebook_datetimestyle($locDT1);
							$curDateTz = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE, GMT_DATETIME, "datetime");							
							$sh_txt = __('Created by').' <strong>'.$note['User']['name'].' '.$note['User']['last_name'].'</strong> '.__('on');
								if($note['ProjectNote']['is_updated']){
									$sh_txt = __('Updated by').' <strong>'.$note['User']['name'].' '.$note['User']['last_name'].'</strong> '.__('on');
									$locDT1 = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,$note['ProjectNote']['created'], "datetime");
									$created_on = $this->Datetime->facebook_style_date_time($locDT1, $curDateTz);
								}else{
									$locDT1 = $this->Tmzone->GetDateTime(SES_TIMEZONE, TZ_GMT, TZ_DST, TZ_CODE,$note['ProjectNote']['modified'], "datetime");
									$created_on = $this->Datetime->facebook_style_date_time($locDT1, $curDateTz);
								}
								$sh_txt .= ' <strong>'.$created_on.'</strong>';
								?>
						<?php echo $sh_txt; ?>						
					</div>
					<?php if($note['User']['id'] == $ses_id){ ?>
						<span class="edit_delete_note">
							<span id ="note_edt_id" data-uid="<?php echo $note['ProjectNote']['uniq_id'];?>" onclick="inlineNoteEdit(this);" class="inline-edit-not anchor" data-prj-id="" data-prj-name="" title="<?php echo __('Edit Note');?>" rel="tooltip">
								<i class="material-icons">&#xE254;</i>
							</span>
							
							<span id ="note_del_id" data-uid="<?php echo $note['ProjectNote']['uniq_id'];?>" onclick="inlineNoteDelete(this);" class="inline-edit-not anchor" data-prj-id="" data-prj-name="" title="<?php echo __('Delete Note');?>" rel="tooltip">
								<i class="material-icons">&#xE872;</i>
							</span>
						</span>
						<?php } ?>
					<div class="project_note_title" id="not<?php echo $note['ProjectNote']['uniq_id'];?>">
						<span id="not_title<?php echo $note['ProjectNote']['uniq_id'];?>">
							<?php 
								$caseMsgRep = $this->Format->formatCms($note['ProjectNote']['note']);
								$caseMsgRep = preg_replace('/<script.*>.*<\/script>/ims', '', $caseMsgRep);
							?>
							<?php echo $caseMsgRep; ?>
						</span>						
					</div>
				</div>
			</div>
		<?php	} ?>
		<div class="clearfix"></div>
	<?php } ?>
</div>

<input type="hidden" value="<?php echo $prjid; ?>" id="proj_uid_note"/>

<script type="text/javascript">
	$(document).ready(function() {
	});	
	//save project note
	function saveProjectNote(){
		//var notes = $.trim($('#proj_notes').val());
		var notes = $.trim(tinymce.get('proj_notes').getContent());
		var proj_id = $.trim($('#proj_uid_note').val());
		var id = $.trim($('#proj_notes_id').val());
		if(notes == ''){
			$('#proj_notes').focus();
			 showTopErrSucc('error', _('Note can not be left blank'));
			return false;
		}
		$('#ldr_pnote').show();
		$('#save_note_btn').hide();
                $("#cancel_note_btn").hide();
		$.post(HTTP_ROOT + "easycases/saveProjectNote", {
				"note":notes,
				"proj_id":proj_id,
				"id":id
		}, function(data) {	
				$('#ldr_pnote').hide();
				$('#save_note_btn').show();
                                $("#cancel_note_btn").show();
				if (data.status == 'error') {
					showTopErrSucc('error', data.msg);
					//tinyMCE.activeEditor.setContent(data);
				}else{
					showTopErrSucc('success', data.msg);
					//refresh the page here
					if(id == '0'){
						//tinyMCE.activeEditor.setContent('');
						tinymce.get('proj_notes').setContent('');
						loadNotes();						
					}else{
						$('#proj_note_link').show();
						$('#proj_note_link_cont').hide();
						//tinyMCE.activeEditor.setContent('');
						tinymce.get('proj_notes').setContent('');
						$('#not_title'+id).html(data.title);
						$('.project_note_created').html(data.update_txt);	
					}
				}
		},'json');
	}	
	
	//edit project note
	function inlineNoteEdit(obj){
		var id = $(obj).attr('data-uid');
		var notes = $.trim($('#not_title'+id).html());
		$('#proj_notes_id').val(id);
		//$('#proj_notes').tinymce().setContent(notes);
		tinymce.get('proj_notes').setContent(notes);
		$('#save_note_btn').text(_('Update Note'));
		$('#proj_note_link').hide();
		$('#proj_note_link_cont').show();
		
		var target = '#proj_note_link_cont';
		var $target = $(target);
		$('html, body').stop().animate({
				'scrollTop': $target.offset().top - 200
		}, 900, 'swing', function() {});
		
	}
	
	//delete project note
	function inlineNoteDelete(obj){
		if(confirm(_('Are you sure you want to delete the note?'))){
			var id = $(obj).attr('data-uid');
			var proj_id = $.trim($('#proj_uid_note').val());
			$.post(HTTP_ROOT + "easycases/deleteProjectNote", {
					"proj_id":proj_id,
					"id":id
			}, function(data) {				
					if (data.status == 'error') {
						showTopErrSucc('error', data.msg);
						//tinyMCE.activeEditor.setContent(data);
					}else{
						showTopErrSucc('success', data.msg);
						$('#not'+id).remove();
						//refresh the page here
						loadNotes();
					}
			},'json');
		}else{
			return false;
		}
	}
	function loadNotes(){
		var proj_id = $.trim($('#proj_uid_note').val());
		$.post(HTTP_ROOT + "easycases/project_notes", {
				"projid":proj_id
		}, function(data) {				
				if (data.status == 'error') {
					showTopErrSucc('error', data.msg);
				}else{
					$('#project_notes').html(data);
				}
		});
	}
</script>