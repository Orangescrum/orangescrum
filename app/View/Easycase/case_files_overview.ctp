<?php if (isset($caseFiles['caseAll']) && !empty($caseFiles['caseAll'])) { ?>
<table>
	<thead>
		<tr>
			<th></th>
			<th><?php echo __('Task');?>#</th>
			<th><?php echo __('File Name');?></th>
			<th><?php echo __('User');?></th>
			<th><?php echo __('Download');?></th>
		</tr>
	</thead>
</table>
<div class="scroll_body">
	<table>
		<tbody>
			<?php $date_labels = ''; 
				foreach ($caseFiles['caseAll'] as $key => $value) {
			?>
			<?php if($date_labels == '' || $date_labels != $value['newdt']){ ?>			
				<tr class="no_bg">
					<td colspan="5">
						<?php echo $value['newdt']; ?>
					</td>
				</tr>
			<?php } ?>
				<tr id="curRow<?php echo $value['CaseFile']['id']; ?>">
					 <td class="drdown_width">
					 	<?php if($this->Format->isAllowed('Archive File',$roleAccess) || $this->Format->isAllowed('Delete File',$roleAccess)){ ?>
						<span class="dropdown">
							<a href="javascript:void(0)" class="main_page_menu_togl dropdown-toggle active" data-toggle="dropdown"  data-target="#">
								<i class="material-icons">&#xE5D4;</i>
							</a>
							<ul class="dropdown-menu">
								<?php if($this->Format->isAllowed('Archive File',$roleAccess)){ ?>
								<li><a onClick="archiveFile(this)" data-id="<?php echo $value['CaseFile']['id']; ?>" data-name="<?php echo $value['file_name']; ?>" href="javascript:void(0);"><i class="material-icons">&#xE149;</i> <?php echo __('Archive');?></a></li>
								<?php } ?>
								<?php if($this->Format->isAllowed('Delete File',$roleAccess)){ ?>
								<li><a onclick="removeFileFrmFiles(<?php echo $value['CaseFile']['id']; ?>)" data-name="<?php echo $value['file_name']; ?>" id="file_remove_<?php echo $value['CaseFile']['id']; ?>" href="javascript:void(0);"><i class="material-icons">&#xE15C;</i> <?php echo __('Remove');?></a></li>
							<?php } ?>
							</ul>
						</span>
					<?php } ?>
					</td>
					<td><a href="<?php echo HTTP_ROOT . 'dashboard#details/' . $value['Easycase']['uniq_id']; ?>">#<?php echo $value['Easycase']['case_no']; ?> </a></td>
					<td>
						<div class="file_img_name ftype_width">
							<span class="file_img os_sprite play_file <?php echo $this->Format->imageTypeIcon($value['file_type']).'_file';?>">
							</span>
							<?php echo $value['file_name']; ?>
						</div>
					</td>
					<td>
						<div class="user_name">
							<span class="pfl_img">
								<span rel="tooltip" title="<?php echo ucfirst($value['usrName']); ?>">
								<?php if($value['usrPhoto']){ ?>
									<img src="<?php echo HTTP_ROOT; ?>users/image_thumb/?type=photos&file=<?php echo $value['usrPhoto']; ?>&sizex=30&sizey=30&quality=100" title="<?php echo $value['usrName']; ?>" rel="tooltip" alt="Loading"/>
									<?php }else{
										$random_bgclr = $this->Format->getProfileBgColr($value['CaseFile']['user_id']);
										$usr_name_fst = mb_substr(trim($value['usrName']),0,1, "utf-8");
									?>
									<span class="cmn_profile_holder <?php echo $random_bgclr; ?>"><?php echo $usr_name_fst; ?></span>
								<?php } ?>
								</span>
							</span>
							<?php echo $value['usrName']; ?>
						</div>
					</td>
					<td>
						<?php if($this->Format->isAllowed('Download File',$roleAccess)){ ?>
						 <?php if($value['download_url'] != '') { ?>
                            <a href="<?php echo $value['download_url']; ?>" rel="tooltip" title="Download" data-url="<?php echo $value['download_url']; ?>" target="_blank">
                        <?php } else { ?>
                            <a href="javascript:void(0);" rel="tooltip" title="<?php echo __('Download');?>" data-url="<?php echo $value['link_url']; ?>" onclick="downloadImage(this);">
                        <?php } ?><span class="download_icon"></span>
                                <!-- <i class="material-icons">&#xE884;</i> -->
                            </a>
                        <?php }else{ ?> 
                        	---
                        <?php } ?>
					</td>
				</tr>
				
			<?php $date_labels = $value['newdt']; } ?>
		</tbody>
	</table>
</div>
<?php }else{ ?>
	<style>
	.os_projct_overview .wbox_data .download_icon {cursor: text;}
	</style>	
	<div class="scroll_body empty_line_cont">
		<table>
			<tbody>
				<tr class="no_bg">
					<td colspan="5">
						<div class="line_bar small gray"></div>
					</td>
				</tr>
				<tr>
					<td><i class="material-icons">&#xE5D4;</i></td>
					<td><div class="line_bar small gray"></div></td>
					<td>
						<div class="user_name">
							<span class="pfl_img drk_gray"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><span class="download_icon"></span></td>
				</tr>
				<tr>
					<td><i class="material-icons">&#xE5D4;</i></td>
					<td><div class="line_bar small gray"></div></td>
					<td>
						<div class="user_name">
							<span class="pfl_img purple"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><span class="download_icon"></span></td>
				</tr>
				<tr>
					<td><i class="material-icons">&#xE5D4;</i></td>
					<td><div class="line_bar small gray"></div></td>
					<td>
						<div class="user_name">
							<span class="pfl_img blue"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><span class="download_icon"></span></td>
				</tr>
				<tr class="no_bg">
					<td colspan="5">
						<div class="line_bar small gray"></div>
					</td>
				</tr>
				<tr>
					<td><i class="material-icons">&#xE5D4;</i></td>
					<td><div class="line_bar small gray"></div></td>
					<td>
						<div class="user_name">
							<span class="pfl_img drk_gray"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><span class="download_icon"></span></td>
				</tr>
				<tr>
					<td><i class="material-icons">&#xE5D4;</i></td>
					<td><div class="line_bar small gray"></div></td>
					<td>
						<div class="user_name">
							<span class="pfl_img purple"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><span class="download_icon"></span></td>
				</tr>
				<tr>
					<td><i class="material-icons">&#xE5D4;</i></td>
					<td><div class="line_bar small gray"></div></td>
					<td>
						<div class="user_name">
							<span class="pfl_img blue"></span>
							<span class="line_bar small gray"></span>
						</div>
					</td>
					<td><div class="line_bar small gray"></div></td>
					<td><span class="download_icon"></span></td>
				</tr>
			</tbody>
		</table>
		<div class="data_not_avail">No Data Available</div>
	</div>
<?php } ?>

<style type="text/css">
    .inactiveDetails:hover, .inactiveDetails:active,.inactiveDetails:link,.inactiveDetails:visited {
        text-decoration: none;
        color: black;
    }
</style>
<input type="hidden" value="<?php echo $caseFiles['caseCount']; ?>" id="only_casefile_count" />