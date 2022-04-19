<table cellpadding='0' cellspacing='0' align='left' style='width:100%'>
	<tr>
		<td align='left'>
			<table cellpadding='4' cellspacing='4' style='border:1px solid #CCCCCC;-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;box-shadow:4px 0px 4px rgba(0,0,0,0.3);-moz-box-shadow:4px 0px 4px rgba(0,0,0,0.3);-webkit-box-shadow:4px 0px 4px rgba(0,0,0,0.3);margin:10px 0;width:100% !important; max-width:600px !important;'>
				<tr>
					<td>
						<table cellpadding='2' cellspacing='2' style='font:bold 14px Arial;'>
							<tr>
								<td style='color:#FFF;background:#763532;min-width:25px;text-align:center;webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;'><?php echo $query_New;?></td>
								<td><?php echo __("New");?></td>
							</tr>
						</table>
					</td>
					<td>
						<table cellpadding='2' cellspacing='2' style='font:bold 14px Arial;'>
							<tr>
								<td style='color:#FFF;background:#244F7A;min-width:25px;text-align:center;webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;'><?php echo $query_Open;?></td>
								<td><?php echo __("In Progress");?></td>
							</tr>
						</table>
					</td>
					<?php if($query_Resolve){ ?>
					<td>
						<table cellpadding='2' cellspacing='2' style='font:bold 14px Arial;'>
							<tr>
								<td style='color:#FFF;background:#EF6807;min-width:25px;text-align:center;webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;'><?php echo $query_Resolve?></td>
								<td><?php echo __("Resolved");?></td>
							</tr>
						</table>
					</td>
					<?php } ?>
					<td>
						<table cellpadding='2' cellspacing='2' style='font:bold 14px Arial;'>
							<tr>
								<td style='color:#FFF;background:#387600;min-width:25px;text-align:center;webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;'><?php echo $query_Close;?>/<?php echo $query_All;?> <?php echo $fill;?></td>
								<td><?php echo __("Closed");?></td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<?php if ($query_All != 0) { 
					$typ_arr = array('1' => '<font color="#763532">New</font>', '2' => '<font color="#244F7A">In Progress</font>', '3' => '<font color="#387600">Closed</font>', '4' => '<font color="#55A0C7">Start</font>', '5' => '<font color="#EF6807">Resolved</font>');
				?>					
					<table style='border:1px solid #ccc; border-radius:5px;width:100% !important; max-width:600px !important;border-collapse:collapse;font-family:Arial;font-size:14px;box-shadow:0px 0px 7px #ccc;' cellpadding='4'>
						<tr style='background-color:#F0F0F0;font-weight:bold;'>
							<td style='border-bottom:1px solid #ccc'><?php echo __("Task#");?></td>
							<td style='border-bottom:1px solid #ccc'><?php echo __("Title");?></td>
							<td style='border-bottom:1px solid #ccc'><?php echo __("Status");?></td>
						</tr>
					<?php 
					foreach ($case_all as $case) {
						$prj_id = $case['Easycase']['project_id'];							
						$prj_shortname = $projShNmArr[$prj_id]; //$this->Format->getProjectShortName($prj_id);
						$case_no = strtoupper($prj_shortname) . " - " . $case['Easycase']['case_no'];
						$case_title = "<a href='" . $comp_url . "/dashboard#details/" . $case['Easycase']['uniq_id'] . "' target='_blank'>" . $case['Easycase']['title'] . "</a>";
						$case_status1 = $case['Easycase']['legend'];
						if($case['Easycase']['custom_status_id']){
							$case_status = '<label style="color:#'.$csts_arr[$case['Easycase']['custom_status_id']]['color'].'">'.$csts_arr[$case['Easycase']['custom_status_id']]['name'].'</lable>';
						}else{
							$case_status = $typ_arr[$case_status1];
						}
						echo "<tr style='height:30px'><td nowrap='nowrap' valign='top'>".$case_no."</td><td valign='top'>".$case_title."</td><td valign='top' style='width:150px;'>".$case_status."</td></tr>";
					}
					?>
					</table>
				<?php } ?>
		</td>
	</tr>
	<tr>
		<td align='left' style='padding:5px 0px'>
			<hr style='border: none; height: 0.1em; color:#DBDBDB;background:#DBDBDB;'/>
		</td>
	</tr>
	<tr>
		<td align='left' style='font:10px Arial;padding-top:2px;color:#737373'>
		 <?php echo __("You are receiving this email notification because you have subscribed to Orangescrum Task Status E-mail notification, to unsubscribe, please click");?> <a href='<?php echo $comp_url;?>/users/email_reports' target='_blank'><?php echo __("Unsubscribe Email Notification");?></a>
		</td>	  
	</tr>
</table>