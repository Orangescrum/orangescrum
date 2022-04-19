<style>
.cmn-popup h4.modhead {
text-align: center;
font-size: 32px;
color: #339999;
font-weight: 600;
margin-left: 7%;
margin-top:20px;
}
.total_savings > main.main_content_ext {
text-align: center;
color: #333;
font-size: 17px;
font-weight: 600;
margin: 25px 0px 10px 0px;
}
.btn_exrct {
background: #fb641b !important;
box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);
border: none;
color: #fff !important;
display: block;
border-radius: 2px;
padding: 10px 20px;
font-weight: 600;
transition: box-shadow .2s ease;
vertical-align: super;
cursor: pointer;
outline: none;
font-size: 15px;
height: 48px;
width: 500px !important;
-webkit-box-sizing: border-box;
}
.btn-default:hover {	
background: #fb641b;
box-shadow: 0 1px 2px 0 rgba(0,0,0,.2);
}

</style>
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header popup-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closeSession1();closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 class="modhead"><?php echo __('Extra Discount For Yearly Plans');?></h4>
        </div>
        <div class="modal-body popup-container" style="margin-top: 30px;">
            <figure class="total_savings">
				<aside class="cb"></aside>
				<main class="main_content_ext"><?php echo __('Use coupon');?> <span>OSNY10</span> <?php echo __('and get');?> <b>10% </b> <?php echo __('discount instantly');?>,<br /> <br /><?php echo __('including');?> <strong><?php echo __('All');?></strong> <?php echo __('yearly plans');?>.</main>
				<aside class="cb"></aside>
			</figure>
        </div>
        <div class="modal-footer popup-footer" style="text-align: center;margin-top: 30px;padding-bottom: 32px;">
            <div class="popup-btn">                
				<span id="btn">
					<span class="cancel-link cancel_on_direct_pj">
						<button type="button" class="btn btn-default btn_hover_link cmn_size btn_exrct" data-dismiss="modal" onclick="closeSession1();closePopup();" style="font-size:15px;"><?php echo __('Proceed To Checkout');?></button>
					</span>
				   <?php /* <span class="hover-pop-btn">
					<a href="javascript:void(0)" id="btn-add-new-project" class="btn btn_cmn_efect cmn_bg btn-info cmn_size loginactive"  onclick="return projectAdd('txt_Proj', 'txt_shortProj', 'txt_ProjStartDate', 'txt_ProjEndDate', 'txt_ProjEsthr', 'loader', 'btn');">Create</a>
				   </span> */ ?>
				</span>
                <div class="cb"></div>
            </div>
			<div class="cb"></div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
    });
</script>