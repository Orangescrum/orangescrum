<style>
.form-group {padding-bottom: 20px;}
</style>

<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="label_title_wf"><?php echo __('Create New Bookmark');?></h4>
        </div>
        <form name="bookmark" id="bookmarkform" autocomplete="off">
        <div class="modal-body popup-container">
            <div id="inner_label">
                <center><div id="lterr_msg" class="err_msg"></div></center> 
                <div class="form-group label-floating">
                    <label class="control-label" for="label_nm"><?php echo __('Enter Link');?></label>
                    <input type="text" value="" class="form-control" name="link" id="bookmark_link"/>
                    <div id="bookmark_link_msg" style="display:none; color:red;font-size:10px;">Enter a valid link.</div>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="label_nm"><?php echo __('Title');?></label>
                    <input type="text" value="" class="form-control" name="title" id="bookmark_title"/>
                    <div id="bookmark_label_msg" style="display:none; color:red;font-size:10px;">Enter a title.</div>
                </div>
                <div class="form-group label-floating">
                    <label class="control-label" for="pages">Open In...</label>
                    <select name="pages" class="select2" id="pages">
                        <option value="0">Same Tab</option>
                        <option value="1">New Tab</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
            <span id="bmbtn">
            <span class="fl">
				<label style="line-height:25px;">
			    <input type="checkbox" id="add_another_bm" name="add_another_bm" value="1">
				<?php echo __("Create another");?>
				</label>
			</span>
                <span class="fl cancel-link"><button type="reset" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn">
                        <input type="button" id="newworkflow_btn" value="<?php echo __('Add');?>" name="add" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="createBookmark();"/>
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