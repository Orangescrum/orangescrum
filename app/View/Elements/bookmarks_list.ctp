<table class="table table custom_fld_list_table m-btm0" id="bookmartable">
                <thead>
                    <tr>
                        <th style="width:20px;">Title</th>
                        <th style="width: 50px;">Link</th>
                        <!-- <th style="width: 20px;">Created by</th> -->
                        <!-- <th style="width: 20px;">Created</th> -->
                        <th style="width: 20px;" class="text-center"> Action</th>
                        
                    </tr>
                </thead> 
                <tbody id="sortableBookmarks" height="100">
                   <?php if($bookmark_list != null){?>
                    <?php  foreach($bookmark_list as $key=>$value){ 
                        ?>
                    <tr id="custom_bookmark_tr_<?php echo $value['Bookmark']['id'];?>" >
                        <td><?php echo  $value['Bookmark']['title'];?></td>
                        <td><?php echo $value['Bookmark']['link']; ?></td>
                        <!-- <td><?php echo $value['User']['name']; ?></td> -->
                        <!-- <td><?php echo $value['Bookmark']['created']; ?></td> -->
                        <td class="text-center">
                        <a href="javascript:void(0)" class="custom-t-type" onclick="editBookmark(<?php echo $value['Bookmark']['id']; ?>);" title="<?php echo __('Edit');?>"><i class="edit-link material-icons">edit</i></a>
                        <a href="javascript:void(0)" class="custom-t-type" onclick="deleteBookmark(<?php echo $value['Bookmark']['id']; ?>);" title="<?php echo __('delete');?>"><i class="edit-link material-icons">delete</i></a>
                        </td>
                    </tr>
                   <?php  } ?>
                    <tr class="empty"><td colspan="3" class="text-center noFoundError" style="display:none;" ><img src="<?php echo HTTP_ROOT?>/img/tools/links.svg" alt=""></td></tr>
                    <tr><td colspan="3" class="text-center noFoundError" style="display:none;">Opps! No data found</td></tr>
                   <?php  }else{ ?>
                    <tr class="empty"><td colspan="3" class="text-center"><img src="<?php echo HTTP_ROOT?>/img/tools/links.svg" alt=""></td></tr>
                    <tr class="empty"><td colspan="3" class="text-center" style="color:#fa5858;">Oops! No bookmark found.</td></tr>
                    <?php  } ?>
                </tbody>
            </table>

            <script>
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
        $('.search_control').on('keyup',function(){
		var searchValue= $('.search_control').val();
        var data = 0;
            $("#bookmartable tbody tr").filter(function() {
                 $(this).toggle($(this).text().toLowerCase().indexOf(searchValue.toLowerCase()) > -1);
                data = ($(this).text().toLowerCase().indexOf(searchValue.toLowerCase()));
            });
            if(data == -1){
               $(".noFoundError").show();
             }else{
               $(".noFoundError").hide();
             }
            });
       
            </script>