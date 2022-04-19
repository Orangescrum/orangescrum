<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="label_title_wf"><?php echo __('Update Bookmark');?></h4>
        </div>
        <form name="bookmark" id="editbookmarkform" autocomplete="off">
        <div class="modal-body popup-container">
            <div id="inner_label">
                
            <center><div id="lterr_msg" class="err_msg"></div></center> 
            <input type="hidden" value="" class="form-control" name="id" id="bookmark_id"/>
                <div class="form-group label-floating">
                    <label class="control-label" for="label_nm"><?php echo __('Enter Link');?></label><br><br>
                    <input type="text" value="" class="form-control" name="link" id="edit_bookmark_link"/>
                    <div id="bookmark_elink_msg" style="display:none; color:red;font-size:10px;">Enter a valid link.</div>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="label_nm"><?php echo __('Title');?></label><br><br>
                    <input type="text" value="" class="form-control" name="title" id="edit_bookmark_title"/>
                    <div id="bookmark_elabel_msg" style="display:none; color:red;font-size:10px;">Enter a title.</div>
                </div>
                <div class="form-group label-floating">
                    <label for="pages">Open In...</label><br>
                    <select name="pages" class="select2" id="bookmark_pages">
                        <option value=0>Same tab</option>
                        <option value=1>New tab</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
            <span id="bmbtn">
                <span class="fl cancel-link"><button type="reset" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn">
                        <input type="button" id="newworkflow_btn" value="<?php echo __('Update');?>" name="add" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"onclick="editAjaxBookmark();" />
                    </span>
            </span>
                <div class="cb"></div>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function(){
        $(".select2").select2();
    });
</script>