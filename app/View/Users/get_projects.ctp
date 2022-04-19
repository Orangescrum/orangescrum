<div id="list_of_projects_select" class="opt1" onclick="open_more_projects(event);">
	<a class="ttfont" href="javascript:jsVoid()" style="">Select Project(s)<i class="material-icons fr">&#xE5C5;</i></a>
</div>
<div id="list_of_projects_below" style="display: none;">
    <div class="icon-srch-img-box">
        <input type="text" id="search_projectall_txt" class="form-control" placeholder="Find a Project">
        <i class="material-icons">&#xE8B6;</i>
        <div class="loading-pro" style="display:none;" id="load_find_pop_proj">
            <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="Loading...">
        </div>
    </div>
    <ul style="" id="instant_user_add">
        <?php echo $this->element('list_projects'); ?>
    </ul>
</div>
<script type="text/javascript">
	$(function(){
		$('#list_of_projects_below').mouseleave(function(){
                    $(this).slideUp();
                });
		/*$('#list_of_projects_select').mouseover(function(){
                    $('#list_of_projects_below').slideDown();
                });*/
		$('#search_projectall_txt').on('keyup',function(){
			var serc = $(this).val();
			$('#load_find_pop_proj').show();
			getAll_projects(serc);
		});			
                $(document).off('click','#popup_bg_main').on('click','#popup_bg_main',function(){
			$('#list_of_projects_below').slideUp('slow');
		});
		$(document).off('click','#list_of_projects_below').on('click','#list_of_projects_below',function(e){
		    e.stopPropagation();
		});
		$(document).off('click','input[id^=project_checked_]').on('click','input[id^=project_checked_]',function(){
			var p_id = $(this).val();
			if($(this).is(':checked')){
				//console.log(1111);
				$('#sel_custprj').append('<option selected="selected" class="selected" id="opt_proj_'+p_id+'" value="'+p_id+'">'+$('#project_checked_labl_'+p_id).text()+'</option>');
				$('#selected_proj_containerdv').append('<div id="selected_proj_containerdv_'+p_id+'" data-id="'+p_id+'" class="user_div fl"><span>'+$('#project_checked_labl_'+p_id).text()+'</span><span onclick="closelistProject('+p_id+')" class="close" title="Remove Project">x</span></div>');
				$('#selected_proj_container').show();
			}else{
				$('#opt_proj_'+p_id).remove();
				$('#selected_proj_containerdv_'+p_id).remove();
				if($('#selected_proj_containerdv').text() == ''){
					$('#selected_proj_container').hide();
				}
			}			
		});
                $.material.init();
	});
</script>