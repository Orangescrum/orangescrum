<style type="text/css">
  .cmn_tutorial_page .page_navigation_link {margin-top:80px}
	.cmn_tutorial_page .page_navigation_link a{vertical-align:middle;display:inline-block;width:auto}
	.cmn_tutorial_page .page_navigation_link .pagination_tbl table{box-shadow:none;border:none}
	.chapter_detail_page .pagination_tbl tr td{width:33.33%;text-align:right;border:none;vertical-align:top}
	.cmn_tutorial_page .page_navigation_link .pagination_tbl table tr td{border:none}
	.chapter_detail_page .pagination_tbl tr td:first-child{text-align:left}
	.chapter_detail_page .pagination_tbl tr td:nth-child(2){text-align:center}
	.chapter_detail_page .pagination_tbl .navigation_btn{margin-top:0px;text-align:center}
	.no_data {color:#c6c9d1; cursor: default;}
</style>
<div class="page_navigation_link">
	<?php
	$pages = Configure::read('CHAPTER');
  $pages = $pages[$chapter_cate];
	$pages_current = array_keys($pages);
	$pages_title = Configure::read('CHAPTER_TITLE');
  $pages_title = $pages_title[$chapter_cate];
	?>
  <?php if(count($pages_current) > 1){ ?>
	<?php /*<h3>Chapters</h3>
	<table>
		<?php foreach($pages_current as $k => $v){ ?>
			<tr>
				<td class="<?php if($this->params['pass'][1] == $v){ ?>active_td<?php } ?>">
					<?php echo ++$k; ?>.&nbsp;<a href="<?php echo HTTP_ROOT.'tutorial/introduction-to-project-management/'.$v;?>" ><?php echo $pages_title[$v]; ?></a>
				</td>
			</tr>
		<?php } ?>
	</table> */ ?>
	<div class="pagination_tbl">
		<table>
			<tr>
				<td>
					<?php if(empty($pages[$this->params['pass'][1]]['prev'])){ ?>					
					<a class="no_data" href="javascript:void(0);" title="No previous chapter"><< Prev</a>
					<?php }else{ ?>
					<a style="background: none;color:#628dec;" href="<?php echo HTTP_ROOT.'tutorial/introduction-to-project-management/'.$pages[$this->params['pass'][1]]['prev'];?>" title="Prev chapter"><< Prev</a>
					<?php } ?>
				</td>
				<td>
					<div class="navigation_btn">
						<a href="<?php echo HTTP_ROOT;?>tutorial" title="Modules & Chapters">Modules & Chapters</a>
						<?php /*<a href="<?php echo HTTP_ROOT;?>tutorial/introduction-to-project-management" title='Back To Introduction To Project Management'>Chapters</a> */?>
					</div>	
				</td>
				<td>
					<?php if(empty($pages[$this->params['pass'][1]]['next'])){ ?>					
					<a class="no_data" href="javascript:void(0);" title="No next chapter"> Next >></a>
					<?php }else{ ?>
					<a style="background: none;color:#628dec;" href="<?php echo HTTP_ROOT.'tutorial/introduction-to-project-management/'.$pages[$this->params['pass'][1]]['next'];?>" title="Next chapter" >Next >></a>
					<?php } ?>
				</td>
			</tr>
		</table>
	</div>	
  <?php }else{ ?>
   <div class="navigation_btn">
      <a href="<?php echo HTTP_ROOT;?>tutorial" title="Modules & Chapters">Modules & Chapters</a>
      <?php /*<a href="<?php echo HTTP_ROOT;?>tutorial/real-world-element-of-project-management" title='Back To Introduction To Project Management'>Chapters</a> */?>
    </div> 
    
 <?php } ?>  
</div>