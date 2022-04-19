<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Add Unbilled time to Invoice');?></h4>
        </div>
        <div class="modal-body popup-container">
            <div  class="logtime-content" id="inner_log">
                <form onsubmit="" method="POST" action="<?php echo $this->Html->url(array('controller' => 'easycases', 'action' => 'addInvoice')); ?>">
                    <div class="form-group">
                        <label for="invoiceList" class="control-label"><?php echo __('Choose an invoice');?></label>
                        <span  id="invoiceListDropdown">
                        <select name="invoiceList" id="invoiceList" onchange="checkInvoice($(this));" class="select form-control floating-label" placeholder="<?php echo __('Choose an invoice');?>" data-dynamic-opts=true>
                            <option value="0"><?php echo __('Add New Invoice');?>...</option>
                            <?php
                            if (!empty($invoice)) {
                                foreach ($invoice as $k => $v) {
                                    echo "<option value='" . $k . "'>" . $v . "</option>";
                                }
                            } else {
                                echo "<option value=''>".__('Select an invoice')."</option>";
                            }
                            ?>
                        </select>
                        </span>
                    </div>			
                </form>
            </div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <span class="cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size reset_btn" data-dismiss="modal" onclick="closePopup();"><?php echo __("Cancel");?></button></span>
                <span class="hover-pop-btn"><a href="javascript:void(0)" onclick="assign2Invoice();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive1"><?php echo __("Update");?></a></span>
            </div>
			 <div class="cb"></div>
        </div>
    </div>
</div>