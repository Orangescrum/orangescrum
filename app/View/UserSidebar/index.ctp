<style type="text/css">
	.setting_wrapper.task_listing{padding:0px}
	.checkbox input[type="checkbox"]:disabled:checked + .checkbox-material .check::before, .checkbox input[type="checkbox"]:disabled:checked + .checkbox-material .check {
	border-color: #639fed !important;
	color: #639fed !important;
	}
	.ch-disabled input[type="checkbox"]:disabled:checked + .checkbox-material .check::before, .ch-disabled input[type="checkbox"]:disabled:checked + .checkbox-material .check {
	border-color: #787878 !important;
	color: #787878 !important;
	}
	/**
	* Nestable
	*/
	
	.dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
	.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none;}
	.dd-list .dd-list { padding-left: 30px; }
	.dd-collapsed .dd-list { display: none; }
	.dd-item,.dd-empty,.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
	.dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
	background: #fafafa;background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
	background:linear-gradient(top, #fafafa 0%, #eee 100%);-webkit-border-radius: 3px;border-radius: 3px;box-sizing: border-box; -moz-box-sizing: border-box;}
	.dd-nodrag{ display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #000; text-decoration: none; font-weight: bold; border: 1px solid #ccc;background: #dedede;-webkit-border-radius: 3px;border-radius: 3px;box-sizing: border-box; -moz-box-sizing: border-box; cursor: no-drop; font-weight: 500 ; }
	.dd-handle:hover { color: #2ea8e5; background: #fff; }
	.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 8px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
	.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0;color:#000 }
	.dd-item > button[data-action="collapse"]:before { content: '-'; }
	.dd-placeholder,.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
	.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
	-webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
	-moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
	linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);background-size: 60px 60px;background-position: 0 0, 30px 30px;
	}
	.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
	.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
	.dd-dragel .dd-handle {-webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);}
	
	/**
	* Nestable Extras
	*/
	
	.nestable-lists { display: block; clear: both; padding:0; width: 100%; border: 0;}
	#nestable-menu { padding: 0; margin:0; float:right; display:none; }
	#nestable-output,#nestable2-output { width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }
	#nestable2 .dd-handle {color: #fff;border: 1px solid #999;background: #bbb;background: -webkit-linear-gradient(top, #bbb 0%, #999 100%);
	background:    -moz-linear-gradient(top, #bbb 0%, #999 100%);background:         linear-gradient(top, #bbb 0%, #999 100%);}
	#nestable2 .dd-handle:hover { background: #bbb; }
	#nestable2 .dd-item > button:before { color: #000; }
	@media only screen and (min-width: 700px) {
	.dd {float: left; width: 48%;}
	.dd + .dd {float:right;margin-left: 2%;}
	}
	.dd-hover > .dd-handle { background: #2ea8e5 !important; }
	
	.choose_left_menu .left_menu_configure{}
	.choose_left_menu .dd-empty{min-height:200px;margin:0}
	.choose_left_menu .dd-empty::before{content:'No Menu Found';width:100%;height:100%;display:flex;align-items:center;justify-content:center;font-size:20px;line-height:30px;color:#ff0000;position:absolute;left:0;right:0;top:0;bottom:0;margin:auto;}
	.choose_left_menu .dd-item{cursor:grab}
	.choose_left_menu .dd-handle{height: 35px;margin: 7px 0;padding: 7px 10px;font-size:13px;font-weight:500}
	.choose_left_menu .dd-handle,.choose_left_menu .dd-nodrag{font-size:15px;}
	.choose_left_menu #nestable .dd-handle, .choose_left_menu #nestable .dd-nodrag{color:#fff;border: 1px solid #5276A6;
    background: #5b9cf3;background: -webkit-linear-gradient(top, #5b9cf3 0%, #436fab 100%);
    background: -moz-linear-gradient(top, #5b9cf3 0%, #436fab 100%);
    background: linear-gradient(top, #5b9cf3 0%, #436fab 100%);}
	.choose_left_menu #nestable .dd-item > button:before{color:#fff}
	.choose_left_menu #nestable2 .dd-handle {color: #000;
    border: 1px solid #ddd;background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background: -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
	background: linear-gradient(top, #fafafa 0%, #eee 100%);}

	#nestable-menu button {text-decoration: none;font-size: 14px;line-height: 20px;color: #333;border: 1px solid #ddd;padding: 5px 10px;border-radius: 20px;display: inline-block; background: #fff; position: relative; top:-10px; } 
	.choose_left_menu .borderbtm{border-bottom: 1px solid #ddd;padding-bottom: 10px;}
	.choose_left_menu h5{margin-bottom: 15px; }
	
</style>
<?php 
$fixParent =  array('tasks','dashboard','projects','users','more');
$fixSubmenuof =  array('tasks','reports','time log','resource_mgmt');

?>
<div class="user_profile_con setting_wrapper ">
	<div class="choose_left_menu">
		<div class="row">
			<div class="col-md-12">
				<h4 class="borderbtm"><?php echo __("Menu Settings");?>
				<menu id="nestable-menu">
			        <button type="button" data-action="expand-all">Expand All</button>
			        <button type="button" data-action="collapse-all">Collapse All</button>
			    </menu>
			</h4>
				<div class="cf nestable-lists">	
					<div class="dd left_menu_configure" id="nestable">
						<h5><?php echo __("Available Menu Items");?></h5>
						<?php if(count($menus)){ ?>
							<ol class="dd-list" style="min-height: 200px;">
                <?php foreach($menus as $k=>$v){ ?>
									<li class="dd-item" data-id="<?php echo $v['Menu']['id'];?>">
                    <div class="<?php if(in_array(strtolower($v['Menu']['name']),$fixParent)){ ?>dd-nodepth <?php } ?>dd-handle parent_handle"><?php echo __($v['Menu']['name']);?></div>
										<?php if(count($v['children'])){ ?>
											<ol class="dd-list">
												<?php foreach($v['children'] as $k1=>$v1){ ?>
													<li class="dd-item" data-id="<?php echo $v1['Menu']['id'];?>">
														<div class="<?php if(in_array(strtolower($v['Menu']['name']),$fixSubmenuof)){ ?> dd-nodrag <?php }else{ ?>dd-handle<?php } ?>"><?php echo __($v1['Menu']['name']);?></div>
													</li>
												<?php } ?>
											</ol>
										<?php } ?>
									</li>
								<?php } ?>
                
							</ol>
							<?php }else{ ?>
							<div class="dd-empty"></div>
						<?php } ?>
					</div>
					
					<div class="dd left_menu_configure" id="nestable2">
						<h5><?php echo __("Customize Left Menu");?></h5>
            <?php if(count($allUsermenus)){ ?>
							<ol class="dd-list" style="min-height: 200px;">
								<?php foreach($allUsermenus as $k=>$v){ ?> 
                  <li class="dd-item" data-id="<?php echo $v['id'];?>">
                    <div class="<?php if(in_array(strtolower($menuName[$v['id']]),$fixParent)){ ?>dd-nodepth <?php } ?>dd-handle parent_handle"><?php echo __($menuName[$v['id']]);?></div>                
										<?php if(count($v['children'])){ ?>
											<ol class="dd-list">
												<?php foreach($v['children'] as $k1=>$v1){ ?>
													<li class="dd-item " data-id="<?php echo $v1['id'];?>">
                            <div class="<?php if(in_array(strtolower($menuName[$v['id']]),$fixSubmenuof)){ ?> dd-nodrag <?php }else{ ?> dd-handle<?php } ?>"><?php echo __($menuName[$v1['id']]);?></div>
													</li>
												<?php } ?>
											</ol>
										<?php } ?>
									</li>
								<?php } ?>
							</ol>
							<?php }else{ ?>
							<div class="dd-empty"></div>
						<?php } ?>
					</div>
					<div class="cb"></div>
					
				</div>    
			</div>
		</div>
	</div>
	
	
	<script src="<?php echo JS_PATH;?>jquery.nestable.js"></script>
	<script>
		$(document).ready(function(){
    var updateOutput = function(e){
		var list   = e.length ? e : $(e.target),
		output = list.data('output');
		if (window.JSON) {
		// output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
		$.post("<?php echo HTTP_ROOT.'UserSidebar/ajax_save_menu';?>",{menu:window.JSON.stringify(list.nestable('serialize'))},function(res){
		
		},'json');
		} else {
		output.val('JSON browser support required for this demo.');
		}
    };
    // activate Nestable for list 1
    $('#nestable').nestable({group: 0,maxDepth:2,threshold:0});
    // activate Nestable for list 2
    $('#nestable2').nestable({group: 0,maxDepth:2}).on('change', updateOutput);    

    $("#nestable-menu").show();
    
		});

  	$('#nestable-menu').on('click', function(e){
        var target = $(e.target),
            action = target.data('action');
        if (action === 'expand-all') {
            $('.dd').nestable('expandAll');
        }
        if (action === 'collapse-all') {
            $('.dd').nestable('collapseAll');
        }
    });

	</script>
