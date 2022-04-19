<div id="bookmark_list">
<?php echo $this->element('personal_settings');?>
                <div class="task_listing setting_wrapper add_custom_fld_page">	
					<div class="row">
						<div class="col-lg-4 text-left">
							<h3 class="noborder"><?php echo  __('Bookmark List'); ?></h3>
						</div>
						<div class="col-lg-8 d-flex">
						<div class="search_new_cf">
						<div class="d-flex">
							<div class="searchfld_group">
								<div class="search_inp">
									<input type="text" name=""  placeholder="Search" class="search_control" value="">
									<i class="material-icons magnify_icon">search</i>
								</div>
							</div>
							<div class="new_custom_fld_btn ml-15">
								<button class="btn btn_cmn_efect cmn_bg btn-info cmn_size cu_add" onclick="addBookmark();" ><i class="material-icons add_plus">add</i> <?php echo __('New Bookmark');?></button> 
							</div>
						</div>
					</div>
					</div>
					</div>
					<div class="row">
					<div class="col-md-12 cmn_custom_dtable">
					<div id="ajaxBookmarksList">
						<div class="loading-custom-dv"><?php echo  __('Loading Bookmark lists...'); ?></div>
					</div>
					</div>
					</div>
                </div>
</div>

<script>
         $(document).ready(function(){
            loadBookmark();
	    });
    /**
     * myFunction
     * opening popup for create bookmark
     * @return void
     */
    function addBookmark(){
        
        $('#label_title_wf').text(_('Create New Bookmark'));
		$('#newworkflow_btn').val(_('Add'));
        openPopup();
        $("#bookmark_link").val("").focus();
        $("#bookmark_title").val("");
        $('#createbookmark').show(); 
    }
      
    /**
     * createbookmark
     * create bookmarks
     * @author swetalina
     * @author bijay
     * @return void
     * date -
     */
    function createBookmark(){
        var url = $('#bookmark_link').val();
        var label =$('#bookmark_title').val();
        // var text_value = text.value;
        var response = url.match(/(http(s)?:\/\/.)(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        var status = true;
        if(url == ""){
            $("#bookmark_link_msg").show();
            status = false;
        }else if(response == null){
            $("#bookmark_link_msg").show();
            status = false;
        }else{
            $("#bookmark_link_msg").hide();
            if(label == ""){
            $("#bookmark_label_msg").show();
            status = false;
          }else{
            $("#bookmark_label_msg").hide();
               if(status){
                $("#bookmark_link_msg").hide();
                    var url = '<?php echo HTTP_ROOT; ?>';
                    $.ajax({
                        url: url + 'bookmarks/createBookmark',
                        type: 'POST',
                        data:$('#bookmarkform').serialize(),
                        cache:true,
                        dataType: 'json',
                        success: function(response){
                            $( "#sortableBookmarks" ).sortable({
                                placeholder: "ui-state-highlight",
                                dropOnEmpty:false, 
                                stop : function(event, ui){
                                    $.post("<?php echo HTTP_ROOT.'bookmarks/reorderBookmark'?>",$('#sortableBookmarks').sortable("serialize"),function(response){},'json');
                                }
                            });
                            if($('#add_another_bm').is(":checked")){                        
                                $('#bookmark_link').val('');
                                $('#bookmark_title').val('');
                                $("#select2-pages-container").text('Same Tab');   
                                loadBookmark();                      
                            } else {                                            
                                closePopup(); 
                                loadBookmark();
                                // self.location = "<?php echo HTTP_ROOT.'bookmarks/bookmarksList'?>";                       
                            } 
                        }
                        
                    });
            }
          }
        }
    }    
    /**
     * editAjaxBookmark
     * edit a single bookmark of bookmark list
     * @author swetalina
     * @author bijay
     * @return void
     * date - 10/08/2021
     */
    function editAjaxBookmark(){
        var url = $('#edit_bookmark_link').val();
        var label =$('#edit_bookmark_title').val();
        var response = url.match(/(http(s)?:\/\/.)?(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g);
        var status = true;
        if(url == ""){
            $("#bookmark_elink_msg").show();
            status = false;
        }else if(response == null){
            $("#bookmark_elink_msg").show();
            status = false;
        }else{
            $("#bookmark_elink_msg").hide();
            if(label == ""){
            $("#bookmark_elabel_msg").show();
            status = false;
          }else{
            $("#bookmark_elabel_msg").hide();
               if(status){
                $("#bookmark_elink_msg").hide();
                    var url = '<?php echo HTTP_ROOT; ?>';
                    $.ajax({
                   url: url + 'bookmarks/editBookmark',
                    type: 'POST',
                    data:$('#editbookmarkform').serialize(),
                    cache:true,
                    dataType: 'json',
                    success: function(res){
                        closePopup(); 
                        loadBookmark();
                    }
                });
            }
          }
        }
    }   
     
    /**
     * editBookmark
     * open popup for edit
     * @author swetalina
     * @return void
     * date - 10/08/2021
     */
    function editBookmark(id){
        $.post("<?php echo HTTP_ROOT.'bookmarks/editBookmark'?>",{sid:id},function(res){
            $("#bookmark_id").val(res.Bookmark.id);
            $("#edit_bookmark_link").val(res.Bookmark.link);
            $("#edit_bookmark_title").val(res.Bookmark.title);
            if(res.Bookmark.open_in_same_page == true){
                $("#bookmark_pages").val(1);
            }else{
                $("#bookmark_pages").val(0);
            }
            $(".select2").select2();
            openPopup();
		    $('#label_title_wf').text(_('Update Bookmark'));
		    $('#newworkflow_btn').val(_('Update'));
		    $('#editbookmark').show();
        },'json');   
    }    
    /**
     * deleteBookmark
     * this function confirm for delete a bookmark from bookmark list
     * @author swetalina
     * @return void
     * date - 10/08/2021
     */
    function deleteBookmark(id){
            if(confirm('<?php echo __("Are you sure you want to delete this Bookmark?")?>')){
            $.post("<?php echo HTTP_ROOT.'bookmarks/deleteBookmark'?>",{id:id},function(res){
                if(res.status == 1){
                     showTopErrSucc('success', res.msg);
                     loadBookmark();
                    // self.location = "<?php echo HTTP_ROOT.'bookmarks/bookmarksList'?>";
                }else{
                    showTopErrSucc('error', res.msg);
                }
            },'json');
        }
    }
    $(document).ready(function(){
		$("#sortableBookmarks").sortable({
			placeholder: "ui-state-highlight",
			dropOnEmpty:false, 
			stop : function(event,ui){
			    $.post("<?php echo HTTP_ROOT.'bookmarks/reorderBookmark'?>",
                $('#sortableBookmarks').sortable("serialize"),
                function(response){
                    if(response.status){
                        showTopErrSucc('success', _('Re-ordered successfully'));
                    }else{
                        showTopErrSucc('error', _('Something went wrong'));
                    }
                },'json');
			}
		});
      
	    });

</script>
<style>
    #sortableBookmarks tr {cursor: move;}
</style>