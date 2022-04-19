<?php echo $this->Html->css('popup_new');?>
<div class="overlay_form" style="display:none;">
<div class="cmn_popup_n" id="new-couponpopop" style="display:none;">
    <div class="sidebar_popup want_order">
    <div class="close_popup_new" onclick="closeNewPopup('forgot_form_home','new-couponpopop')">✕</div>
        <h3><span><?php echo __('Want 5% off');?> </span><?php echo __('Your Order');?> ?</h3>
        <div class="coupon_code_blk">
            <small><?php echo __('Use coupon code');?></small>
            <div class="outer_line">
                <span class="coupon_btn">OSAUG05</span>
            </div>
            <p>
                <?php echo __('And enjoy site wide saving off 5% just for subscribing with us');?> !
                <br />
                <a href="<?php echo HTTP_ROOT.'pricing';?>" style="margin-top:10px; text-decoration: underline; " ><?php echo __('Upgrade Now');?></a>
            </p> 
        </div>
        <small>* <?php echo __('Online Order Only. Applicable to all subscription plans');?></small>      
    </div>
</div>
</div>

<script>
    if(typeof localStorage.showCoupon != 'undefined' &&  localStorage.showCoupon == 1 ){
       <?php if(PAGE_NAME != "confirmationPage" && PAGE_NAME != "upgrade_member" && PAGE_NAME != "pricing"){ ?>
            $('.overlay_form').show(); 
            $('#new-couponpopop').show();
        <?php } ?>
    }
    function closeNewPopup(el,div){
        $('.overlay_form').hide();
        $('#'+div).hide();
    }    
    <?php if(PAGE_NAME == "upgrade_member"){ ?>
    localStorage.setItem('showCoupon','1');
    <?php }else{
        if(PAGE_NAME != "pricing"){
        ?>
    localStorage.removeItem('showCoupon');
    <?php 
        }
        } ?>

</script>