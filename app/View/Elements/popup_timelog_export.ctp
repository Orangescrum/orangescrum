<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close close-icon" data-dismiss="modal" onclick="closePopup();"><i class="material-icons">&#xE14C;</i></button>
            <h4 id="expt-tm-lg-headeing"><?php echo __('Export Timelog to csv file');?></h4>
        </div>
        <div class="cb"></div>
        <div id="inner_task_list_export">
            <div class="modal-body popup-container">
							<div class="row">
                            <span class="exprt-txt tlog-exp"><?php echo __('Below columns will be exported');?>.</span>
                <div class="col-lg-12 mbtm15">
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tldate">
													<input id="exp_tldate" type="checkbox" value="date" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Date');?>
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_resource">
													<input id="exp_resource" type="checkbox" value="usr_name" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Name');?>
													</span>
											</label>
									</div>
                                    <div class="checkbox custom-checkbox pop-task-type-check" id="tlog_exp_prj">
											<label for="exp_resource">
													<input id="exp_resource" type="checkbox" value="prj_name" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Project Name');?>
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tlcaseno">
													<input id="exp_tlcaseno" type="checkbox" value="task_no" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Task');?>#
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tlcasetitle">
													<input id="exp_tlcasetitle" type="checkbox" value="task_title" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Task Title');?>
													</span>
											</label>
									</div>
                                                                        <div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tloghours">
													<input id="exp_tloghours" type="checkbox" value="hours" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Logged Hours');?>
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tldescription">
													<input id="exp_tldescription" type="checkbox" value="description" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Note');?>
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tlogstart">
													<input id="exp_tlogstart" type="checkbox" value="start" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Start');?>
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tlogend">
													<input id="exp_tlogend" type="checkbox" value="end" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('End');?>
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tlogbreak">
													<input id="exp_tlogbreak" type="checkbox" value="break" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Break(hours)');?>
													</span>
											</label>
									</div>
									<div class="checkbox custom-checkbox pop-task-type-check">
											<label for="exp_tlogbillable">
													<input id="exp_tlogbillable" type="checkbox" value="billable" class="tlog_exp_chkbx" checked="checked"/>
													<span class="oya-blk">
														 <?php echo __('Billable');?>
													</span>
											</label>
									</div>
									
									<div class="cb"></div>
                </div>
				
			<span class="exprt-txt"><?php echo __('Please select date format');?>.</span>
			    <div class="col-lg-12">
				
					 <div class="checkbox custom-checkbox pop-task-type-check">
								<label for="">
									<input  name="dt_format" id="exp_dt1" type="radio" value="Y/m/d" class="tlog_exp_rdo" />
									<span class="oya-blk">
										 <?php echo __('YYYY/MM/DD');?>
									</span>
							</label>
							
								<label for="">
									<input  name="dt_format" id="exp_dt1" type="radio" value="y/m/d" class="tlog_exp_rdo" />
									<span class="oya-blk">
										 <?php echo __('YY/MM/DD');?>
									</span>
							</label>
							
							
					</div>
					
				 <div class="checkbox custom-checkbox pop-task-type-check">
						<label for="oya-blk">
									<input name="dt_format" id="exp_dt2" type="radio"  value="d/m/Y" class="tlog_exp_rdo" checked />
									<span class="oya-blk">
										 <?php echo __('DD/MM/YYYY');?>
									</span>
							</label>
							
							<label for="oya-blk">
									<input name="dt_format" id="exp_dt2" type="radio"  value="d/m/y" class="tlog_exp_rdo" checked />
									<span class="oya-blk">
										 <?php echo __('DD/MM/YY');?>
									</span>
							</label>
					</div>
					
			
					
				<div class="cb"></div>
                </div>
							</div>
            </div>
            <div class="modal-footer">
            	<input type="hidden" value="" id="tm-log-download-type" />
                <div class="fr popup-btn act_btttn">
                    <span class="fl cancel-link"><button type="button" class="btn btn-default btn_hover_link cmn_size" data-dismiss="modal" onclick="closePopup();"><?php echo __('Cancel');?></button></span>
                    <span class="fl hover-pop-btn"><a href="javascript:void(0)" class="btn btn_cmn_efect cmn_bg btn-info cmn_size" onclick="ajax_timelog_export_csv();"><?php echo __('Submit');?></a></span>
                    <div class="cb"></div>
                </div>
            </div>
        </div>
    </div>
</div>