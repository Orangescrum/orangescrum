<style>
    .modal-dialog.subscription{display: none; position: relative; box-sizing: border-box; width: 100%;}
    .modal-dialog.subscription .modal-header{padding: 15px 20px 0px; display: table; clear: both; width: 100%; box-sizing: border-box; text-align: left;}
    .modal-dialog.subscription .modal-header button.close-icon{min-width:24px; padding: 0px; opacity: 0.2; float: right; background: transparent none repeat scroll 0px 0px; border: 0px none; line-height: 1px; margin: 0px;}
    .modal-dialog.subscription .modal-header h4{color: rgb(34, 34, 34); font-size: 20px; display: inline-block; font-weight: normal; line-height: 25px; margin: 0px;}
    .modal-dialog.subscription .cancel-link button{border: medium none; background: transparent none repeat scroll 0px 0px; margin: -3px 0px 0px; line-height: 16px;}
    .modal-dialog.subscription .form-group{text-align: left; margin: 5px 0; clear:both; line-height:22px; border-bottom: 1px solid #ccc; float: left; width:100%;}
    .modal-dialog.subscription .form-group .sub-level{display: inline-block;}
    .modal-dialog.subscription .form-group.row div{display: inline-block; float: left;}
    .modal-dialog.subscription .form-group.row .width-20{width:20%;}
    .modal-dialog.subscription .form-group.row .width-30{width:30%; text-align: left;}
    .modal-dialog.subscription .form-group.row .width-50{width:47%; text-align: left;}
    .modal-dialog.subscription .form-group.row ul li{float: left; width: 48%;}
    .cb{clear: both;}
</style>
<div class="modal-dialog subscription" id="dialog-form-subscription">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="$.unblockUI();"><i class="material-icons">&#xE14C;</i></button>
            <h4><?php echo __('Add Subscription');?></h4>
        </div>
        <div class="modal-body popup-container" style="padding: 10px 24px;">
            <form onsubmit="" id="companyAddSubscription" method="POST" action="<?php echo $this->Html->url(array('controller' => 'osadmins', 'action' => 'companyAddSubscription')); ?>">
                <?php #$PAID_plans = Configure::read('CURRENT_PAID_PLANS_REVISED'); ?>
                <?php $PAID_plans = Configure::read('CURRENT_MONTHLY_PLANS'); ?>
                <?php #pr($getPrices); ?>
                <?php foreach ($PAID_plans as $key => $plan) { ?>
									<?php if($comp_dtls[0]['Company']['is_per_user']){ ?>
										<?php if(in_array($key, array(45,47))){ ?>
										<div class="form-group row">
                        <div class="width-20">
                            <input type="radio" name="subscription_id" value="<?php echo $key?>" class="" id="chklbl<?php echo $key;?>" data-price="<?php echo $getPrices[$key]['Subscription']['price']; ?>"/>
                            <label class="sub-level" for="chklbl<?php echo $key;?>"><?php echo $plan ?></label>
                        </div>
                        <div class="width-30">
                            <div class="price">					
                                <h3><span>$</span><?php echo $getPrices[$key]['Subscription']['price']; ?><span>&nbsp;a month</span></h3>
                            </div>
                        </div>
                        <div class="width-50">
                            <ul>
                                <li><?php echo $getPrices[$key]['Subscription']['user_limit']; ?> <?php echo __('Users');?></li>
                                <li><?php echo $getPrices[$key]['Subscription']['project_limit']; ?> <?php echo __('Projects');?></li>
                                <li><?php echo $this->Format->displayStorage($getPrices[$key]['Subscription']['storage'], 1); ?> <?php echo __('Storage');?></li>
                                <li>$<?php echo $getPrices[$key]['Subscription']['price']; ?> <?php echo __('per month');?></li>
                            </ul>
                        </div>
                        <div class="cb"></div>
                    </div>
										<?php } ?>
									<?php }else{?>
                    <div class="form-group row">
                        <div class="width-20">
                            <input type="radio" name="subscription_id" value="<?php echo $key?>" class="" id="chklbl<?php echo $key;?>" data-price="<?php echo $getPrices[$key]['Subscription']['price']; ?>"/>
                            <label class="sub-level" for="chklbl<?php echo $key;?>"><?php echo $plan ?></label>
                        </div>
                        <div class="width-30">
                            <div class="price">					
                                <h3><span>$</span><?php echo $getPrices[$key]['Subscription']['price']; ?><span>&nbsp;a month</span></h3>
                            </div>
                        </div>
                        <div class="width-50">
                            <ul>
                                <li><?php echo $getPrices[$key]['Subscription']['user_limit']; ?> <?php echo __('Users');?></li>
                                <li><?php echo $getPrices[$key]['Subscription']['project_limit']; ?> <?php echo __('Projects');?></li>
                                <li><?php echo $this->Format->displayStorage($getPrices[$key]['Subscription']['storage'], 1); ?> <?php echo __('Storage');?></li>
                                <li>$<?php echo $getPrices[$key]['Subscription']['price']; ?> <?php echo __('per month');?></li>
                            </ul>
                        </div>
                        <div class="cb"></div>
                    </div>
                <?php } ?>
                <?php } ?>
                <div class="form-group row">
                    <input type="text" name="duration" id="uas_duration" class="numbersOnly" style="width:100px;" maxlength="3" placeholder="Duration" value="1"/> <?php echo __('Months');?> X 
                    <span id="uas_sub_price">$0</span> = 
                    Total <span id="uas_total_price">$0</span>
                </div>
								<?php if($comp_dtls[0]['Company']['is_per_user']){ ?>
								<div class="form-group row">
									<input type="text" name="user_cnt" id="uas_user_cnt" class="numbersOnly" style="width:100px;" maxlength="3" placeholder="Duration" value="10"/> <?php echo __('Users');?>
                </div>
								<?php } ?>
            </form>
            <div class="cb"></div>
        </div>
        <div class="modal-footer">
            <div class="fr popup-btn">
                <img src="<?php echo HTTP_ROOT . "img/images/case_loader2.gif"; ?>" alt="Loading" id="company_loader" style="display:none;" alt="" class="fr"/>
                <div id="invoice_btnn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="$.unblockUI();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a id="add_subscription_to_company" href="javascript:void(0)" onclick="return add_subscription_to_company();" class="btn btn_cmn_efect cmn_bg btn-info cmn_size"><?php echo __('Save');?></a></span>
                </div>
                <div class="cb"></div>
            </div>
            <div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
     $(document).ready(function(){
         $("input[name=subscription_id]").click(function(){
             uas_calculate();
         });
         $('#uas_duration').change(function(){
             uas_calculate();
         });
     });
     $(document).on('keydown', '.numbersOnly', function (event) {
        var key = window.event ? event.keyCode : event.which;
        var key_arr = [8, 46, 37,38, 39,40, 9, 91, 92, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 116,16,187,46,17,82,65,35,36,190];
        if (jQuery.inArray(key, key_arr) > -1) {return true;} else if (key < 48 || key > 57) {return false;} else {return true;}
    });
    var updateCompanySubscription = "<?php echo $this->Html->url(array('controller' => 'Osadmins', 'action' => 'companyAddSubscription')) ?>";
    function add_subscription_to_company() {
        var price = parseFloat($('input[name=subscription_id]:checked').attr('data-price'))||0;
        var duration = parseFloat($('#uas_duration').val());
        var error = 0;
        if (price == 0) {
            showErrSucc('error', '<?php echo __("Please select a subscription");?>!');
            error = 1;
        }
        if (error == 1) {
            return false;
        } else {
            if(confirm('<?php echo __("Are you sure to add subscription for this company");?>?')){
                while(!reason){
                    var reason = prompt("Please enter the reason to add subscription for this company", "");
                }
                window.location.href = updateCompanySubscription+'?cmp='+$('#company_id').val()+'&sub='+$('input[name=subscription_id]:checked').val()+'&dur='+duration+'&reason='+reason+'&user='+parseInt($('#uas_user_cnt').val());
            } else {
                $.unblockUI();
            }
        }
    }

    function showErrSucc(type, msg) {
        $("#topmostdiv").show();
        $("#btnDiv").show();
        if (type == 'error') {
            $("#upperDiv_err").html(msg);
            $("#upperDiv_err").show();
        } else {
            $("#upperDiv").html(msg);
            $("#upperDiv").show();
        }
        clearTimeout(time);
        time = setTimeout(removeMsg, 6000);
    }
    function uas_calculate(){
        var price = parseFloat($('input[name=subscription_id]:checked').attr('data-price'))||0;
        var duration = parseFloat($('#uas_duration').val());
        if(duration == 0){
            duration = 1;
            $('#uas_duration').val(duration);
        }
        $('#uas_sub_price').html('$'+price);
        $('#uas_total_price').html('$'+(price*duration));
    }
</script>