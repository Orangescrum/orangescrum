<style type="text/css">
.hsc_page .help_video .help-tabs{border:none;border-bottom:2px solid #ddd;border-radius:0px}
.help-srch{margin:15px 0}
.help-srch .form-group label.control-label{font-size:15px}
.help-srch .form-group .form-control{height:45px}
.hsc_page ul{border: 1px solid #eee;padding: 15px 30px 30px;border-radius: 5px;}
.hsc_page .help_video .help-questions li.hlp-subcat{font-size: 28px;line-height:40px;color:#333;padding: 20px 0;margin-left: 0;}
.hsc_page .help_video .help-questions li{font-size:14px;color:#00598a;line-height:24px;padding: 8px 8px 8px 20px;position:relative;margin-left:20px}
.hsc_page .help_video .help-questions li::before{content:'';width:8px;height:8px;background:#333;border-radius:50%;display:inline-block;position:absolute;left:0;top:0;bottom:0;margin:auto}
.hsc_page .help_video .help-questions li.hlp-subcat::before{display:none}
</style>

<div class="help-container">
	<div class="help-srch">
			<div class="form-group label-floating">
					<label class="control-label" for="search_help">Enter question or keyword</label>
					<input class="form-control" id="search_help" type="text" maxlength='240' onkeyup='hlpFilterItems(this);' />
			</div>
	</div>
	<ul id="subjects_list">
	<?php 
		if(!empty($help_posts)) {
					$unq_subcat = '';
					$arrsub = array();
					foreach ($help_posts as $key => $value) { ?>
					<?php if($unq_subcat != $value['terms']['category'][0]['ID'] && !empty($help_subcat[$value['terms']['category'][0]['ID']])){  ?>
					<?php if(!in_array($help_subcat[$value['terms']['category'][0]['ID']], $arrsub)){ array_push($arrsub, $help_subcat[$value['terms']['category'][0]['ID']]); ?>
						<li class="hlp-subcat">
							<?php echo $help_subcat[$value['terms']['category'][0]['ID']]; ?>
						</li>
					<?php } ?>
					<?php } ?>
					<?php $unq_subcat = $value['terms']['category'][0]['ID']; ?>
					<li class="active">
						<a href="<?php echo $value['link']; ?>" target="_blank" style="outline:none;">
								<?php echo $value['title']; ?>
						</a>	
					</li>
			<?php }
			} ?>	
	</ul>
</div>
<script>
	function hlpFilterItems(obj) {
			val = $(obj).val().toUpperCase();
			$('#subjects_list').find('li').each(function() {
				if ($(this).text().toUpperCase().indexOf(val) > -1) {
						$(this).show();
				} else {
						//if(!$(this).hasClass('hlp-subcat')){
							$(this).hide();
						//}
				}
				if (val.trim() == '') {
						$(this).show();
				}
			});
	}
</script>