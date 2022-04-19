<style>
#sample_project_modal .modal-dialog{width:750px;margin: 0 auto;    transform: translateY(-50%);-webkit-transform: translateY(-50%);-moz-transform: translateY(-50%);top: 50%;}
/*#sample_project_modal .modal-body{background:#fff;}*/
#sample_project_modal .modal-content{background:transparent;border:none;border-radius:0px;    text-align:center;box-shadow:none;-webkit-box-shadow:none;-moz-box-shadow:none}
#sample_project_modal .modal-title{font-size:55px;line-height:75px;color:#fff;font-weight: 700;margin:0;padding:0}
#sample_project_modal p{font-size:30px;line-height:45px;color:#fff;font-weight: 600;margin:15px 0 40px;padding:0}
#sample_project_modal a{text-decoration:none;display:inline-block;font-size:18px;line-height:18px;font-weight: 500;padding:15px 30px;text-align:center;background:#1A73E8;color:#fff;border-radius: 4px;cursor:pointer}
#sample_project_modal a:hover{background:#fff;color:#1A73E8}
#sample_project_modal .close{font-size: 40px;line-height: 30px;color: #fff;
    opacity: 1;font-weight: 300;cursor:pointer}
#sample_project_modal .close:hover{opacity:0.9}
.modal-backdrop {background: rgba(0, 0, 0, 0.98);}
</style>


<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-lg sample_project_btn" data-toggle="modal" data-target="#sample_project_modal" style="display:none;"></button>
<!-- Modal -->
<div class="modal fade" id="sample_project_modal" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
		<button type="button" class="close" data-dismiss="modal" onclick="closeSamplproj();">&times;</button>
		<div class="modal-title"><?php echo __('Sample Project');?></div>
		<p><?php echo __('See how your projects work in Orangescrum!');?></p>
		<a href="javascript:void(0)" title="Thank You" data-dismiss="modal"  onclick="closeSamplproj();"><?php echo __('Thank You');?></a>
			</div>
		</div>		
	</div>
</div>