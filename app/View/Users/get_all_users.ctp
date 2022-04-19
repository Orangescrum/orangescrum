<div class="task-list-bar templates-bar">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-7">
                <ul class="proj_stas_bar personal-settings-bar">                    
                    <li <?php if($this->params->pass[0] !='community' && $this->params->pass[0] !='free'){ print 'class="active-list"';} ?>>
                        <a id="sett_my_profile" href="<?php echo HTTP_ROOT.'users/getAllUsers/' ;?>" class="all-list">
                            <i class="material-icons">&#xE7EF;</i> Cloud
                        </a>
                    </li>
                    <li <?php if($this->params->pass[0]=='community'){ print 'class="active-list"';} ?> >
                        <a id="sett_cpw_prof" href="<?php echo HTTP_ROOT.'users/getAllUsers/community' ;?>" class="all-list">
                            <i class="material-icons">&#xE7FD;</i> Community                       
						</a>
                    </li>
                    <li <?php if($this->params->pass[0]=='free'){ print 'class="active-list"';} ?>>
                        <a id="sett_mail_noti_prof" href="<?php echo HTTP_ROOT.'users/getAllUsers/free' ;?>" class="all-list">
                           <i class="material-icons">&#xE7FC;</i> Free Download
                        </a>
                    </li>                    
                </ul>
            </div>
            <div class="col-lg-5 text-right">
				<form name="search" action="<?php echo HTTP_ROOT.'users/getAllUsers/'.$this->params->pass[0]?>" method="get" >
					<input type="text" name="q" value="<?php echo $_GET['q'];?>" class="form-control" style="margin-top:15px;" placeholder="Search by email">
				</form>
            </div>
        </div>
    </div>
</div>


<div class="setting_wrapper task_listing cmn_tbl_widspace width_hover_tbl changepassword-page">
	<div class="row">
		<div class="col-lg-12">
		   <div class="task_listing timelog_lview"> <div class="m-cmn-flow">     
				<table class="table table-striped  m-list-tbl">
					<tbody>             
						<tr>                 
							<th style="width:10%; border-top:none;">Name</th>                 
							<th style="width:10%;border-top:none;">Email</th>                 
							<th style="width:30%; border-top:none;">Location</th>                 
							<th style="width:10%;border-top:none;">Payment Type</th>             
						</tr> 
						<?php 
						if($this->params->pass[0]=='community'){
						if(count($community) >0){ 
							foreach($community as $k=>$v){ ?>
								<tr>
									<td><?php echo $v['Community']['name'];?></td>
									<td><?php echo $v['Community']['email'];?></td>
									<td><?php echo $v['Community']['location'];?></td>
									<td><?php echo $v['Community']['addon_name']; ?></td>
								</tr>
						
						<?php }}else{ ?>
						<tr><td colspan="4" style="color:red; text-align:center;">No users found.</td></tr>	
						<?php }
						}else if($this->params->pass[0]=='free'){
							if(count($free) >0){ 
							foreach($free as $k=>$v){ ?>
								<tr>
									<td><?php echo $v['FreeDownload']['name'];?></td>
									<td><?php echo $v['FreeDownload']['email'];?></td>
									<td><?php echo $v['FreeDownload']['location'];?></td>
									<td><?php echo 'Free'; ?></td>
								</tr>
							<?php }}else{ ?>
							<tr><td colspan="4" style="color:red; text-align:center;">No users found.</td></tr>	
							<?php }
						}else{
							if(count($users) >0){ 
								foreach($users as $k=>$v){ ?>	
								<tr>
									<td><?php echo $v['User']['name'];?></td>
									<td><?php echo $v['User']['email'];?></td>
									<td><?php echo $timezones[$v['User']['timezone_id']];?></td>
									<td><?php $type=(in_array($v['UserSubscription'][0]['subscription_id'],array('5','10','12','14')))?"<span style='color:red;'>Paid</span>":"<span>Free</span>" ;
											echo $type;
									?></td>
								</tr>
							<?php }}else{ ?>
							<tr><td colspan="4" style="color:red; text-align:center;">No users found.</td></tr>						
							<?php } 
							}?>						
					</tbody>     
				</table> 
				<ul class="pagination">
				<?php 
				$queryString = $this->params->pass[0];
				$this->paginator->options(array('url'=> array('controller' => 'users', 'action' => 'getAllUsers', $queryString)));
				if(isset($_GET['q']) && !empty($_GET['q'])){
					$this->paginator->options['url']['?']='q='.$_GET['q'];
				}
				echo $this->paginator->prev('Previous', array('tag'=>'li'), null, 
					array('class' => 'disabled','tag'=>'li'));
				echo $this->paginator->numbers(array('separator' => '','tag'=>'li')); 							
				echo $this->paginator->next('Next', array('tag'=>'li'), null, 
					array('class' => 'disabled','tag'=>'li'));
				?>
				</ul>
				<style>
				.pagination .current,
				.pagination .disabled {
					float: left;
					padding: 0 14px;

					color: #999;
					cursor: default;
					line-height: 26px;
					text-decoration: none;

					border: 1px solid #DDD;
					border-left-width: 0;
				}
                                .pagination .current:first-child , .pagination .disabled:first-child{border-left-width: 1px;}
                                .pagination .disabled:first-child{border-radius: 5px 0 0 5px;}
				</style>
				
			</div>      
		</div>
		</div>
	</div>
</div>
