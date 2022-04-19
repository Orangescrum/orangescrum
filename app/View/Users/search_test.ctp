<br/><br/><br/>
<center>
<input type="textbox" name="case_search" id="case_search" onkeyup="ajaxCaseSearch(event,'ajax_search.php','ajax_search','case_search','case_project','<?php echo PAGE_NAME; ?>');onKeyPress(event,'case_search');" onkeypress="onKeyPress(event,'case_search');" onkeydown="return goForSearch(event,'case_search','<?php echo PAGE_NAME; ?>');"  autocomplete="off" <?php if($srch_text) { echo "value='".$srch_text."'"; } else { ?>placeholder="Jump to a Task" <?php } ?> style="width:600px"/>
<span id="ajax_search"></span>

<input type="hidden" name="casePage" id="casePage" value="1" size="4" readonly="true"/>



<div id="srch_load1" style="display:none;position:relative;padding-top:2px;left:-10px;"> 
			  <img src="<?php echo HTTP_IMAGES; ?>images/del.gif" alt="loading" title="loading"/> 
			</div>
			<div id="srch_load2" <?php if($srch_text) { ?>style="display:none;cursor:pointer;position:relative;padding-top:2px;left: -11px;" <?php } else { ?>style="display:block;cursor:pointer;position:relative;padding-top:2px;left: -11px;" <?php } ?>>
				<a href="javascript:jsVoid();" onclick="validateSearch('case_search','<?php echo PAGE_NAME; ?>')"><img alt="Search" src="<?php echo HTTP_IMAGES; ?>images/go.png"  style="height:25px;"></a>
			</div>
			<div id="closesrch" <?php if($srch_text) { ?>style="display:block;cursor:pointer;position:relative; left:-10px;padding-top:2px;" <?php } else { ?>style="display:none;cursor:pointer;position:relative; left:-10px;padding-top:2px;" <?php } ?>>
				<span onclick="clearSrch()"><img src="<?php echo HTTP_IMAGES; ?>images/close_search.png"/></span>
			</div>
			
			
			<input type="hidden" name="projFil" id="projFil" value="all" size="24" readonly="true"/>
			<input type="hidden" name="projIsChange" id="projIsChange" value="all" size="24" readonly="true"/>
			
			<input type="hidden" name="CS_project_id" id="CS_project_id" value="all" size="24" readonly="true"/>
			
			
			<input type="hidden" name="pageurl" id="pageurl" value="<?php echo HTTP_ROOT; ?>" size="1" readonly="true"/></center>

<br/>
<br/><br/>