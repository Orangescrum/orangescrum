<style>
.instant_select_user{
	background: none repeat scroll 0 0 #FFFFCC;
	margin-left: -6px !important;
	padding: 6px 6px 6px 10px !important;
	width: 104% !important;
}
</style>
<table cellpadding="0" cellspacing="0" class="col-lg-12 ad_prj_usr_tbl ad_prj_usr_ipad">
    <input type="hidden" id="adusrprojnm" value="<?php echo $this->Format->formatText($pjname); ?>">
    <tr>
	<td valign="top" class="usersin_prj_frst_td">
	    <div class="scrl-ovr inner_prj_notextusr_add">
	    <table cellpadding="0" cellspacing="0" class="col-lg-12" style="width:100%">
		<tr class="hdr_tr">
		    <th class="nm_ipad" colspan="4" style="padding:8px 22px;background: none repeat scroll 0 0 #ABBAC3;color: #FFFFFF;"><?php echo __('User(s) not in this');?><?php //echo $this->Format->formatText($pjname); ?> <?php echo __('Project');?></th>
		</tr>
		<tr class="hdr_tr">
		    <th><input <?php if(count($memsNotExstArr)) { ?>style="display:block;"<?php }else{ ?>style="display:none;"<?php } ?> type="checkbox" class="chkbx_cur" onclick="selectuserAll(1,0)" id="checkAll"/></th>
		    <th class="nm_ipad" style="padding-left:10px;"><?php echo __('Name');?></th>
		    <th>&nbsp;</th>
		    <th><?php echo __('Email');?></th>
		</tr>
		<?php
		$userCount = count($memsNotExstArr);
		$count = 0;
		$class = "";
		$totCase = 0;
		$totids = "";
		$pre_count = 0;
		if ($userCount) {
		    $typ = "";		
		    foreach ($memsNotExstArr as $memsAvlArr) {
			$pre_chk = 0;
			if(isset($selected_users) && array_key_exists($memsAvlArr['User']['id'],$selected_users)){
			   $pre_chk = 1;
			   $pre_count++;
			}
			$user_id = $memsAvlArr['User']['id'];
			$user_name = ucfirst($memsAvlArr['User']['name']);
			$user_shortName = $memsAvlArr['User']['short_name'];
			$user_email = $memsAvlArr['User']['email'];
			$user_istype = $memsAvlArr['User']['istype'];
			$count++;
			if ($count % 2 == 0) {
			    $class = "row_col";
			} else {
			    $class = "row_col_alt";
			}
			?>
			<tr id="listing<?php echo $count; ?>" class="rw-cls <?php echo $class; ?>" <?php if($pre_chk){ ?>style="display:none;" <?php } ?>>  	
			    <td>
				<input type="checkbox" class="chkbx_cur ad-usr-prj" id="actionChk<?php echo $count; ?>" value="<?php echo $user_id.'@@|@@'.urlencode($user_name); ?>" onclick="selectuserAll(0,<?php echo $count; ?>,'<?php echo urlencode($user_name);?>');" <?php if($pre_chk){ ?> checked="checked" <?php } ?>/>
				<input type="hidden" id="actionCls<?php echo $count; ?>" value="0"/>
			    </td>
			    <td style="padding-left:10px;<?php echo $class; ?>">
				<?php echo $this->Format->shortLength($user_name, 25); ?>
				<?php
				$usr_typ_name = '';
				if ($memsAvlArr['CompanyUser']['user_type'] == 1) {
				    $colors = 'color:Green';
				    $usr_typ_name = 'Owner';
				} else if ($memsAvlArr['CompanyUser']['user_type'] == 2) {
				    $colors = 'color:Red';
				    $usr_typ_name = 'Admin';
				} else if ($memsAvlArr['CompanyUser']['user_type'] == 3 && $role != 3) {
				    
				}
				?>
				<span style="font-size:13px;<?php echo $colors; ?>">&nbsp;&nbsp;&nbsp;<?php echo $usr_typ_name; ?></span>
			    </td>
			    <td  style="<?php echo $class; ?>">
			<?php echo strtoupper($user_shortName); ?>
			    </td>
			    <td style="<?php echo $class; ?>">
			<?php echo $this->Format->shortLength($user_email, 25); ?>
			    </td>
			</tr>
			<?php
			$totids.= $user_id . "|";
			$typ = $user_istype;
		    }
			if($pre_count == $count){
				echo '<tr class="no-user_tr"><td colspan="7"><center class="fnt_clr_rd">'. __('No user(s) available').'</center></td></tr>';
			?>
			<script>
				$('#checkAll').hide();
			</script>
			<?php
			}
		} else {
		    ?>
				<tr class="no-user_tr">
		    		    <td colspan="7">
		    		<center class="fnt_clr_rd"><?php echo __('No user(s) available');?>.</center>
		    	</td>
			</tr>
			<script>
				$('#checkAll').hide();
			</script>
		    <?php
		}
		?>
	</table>
	</div>
	</td>
	<td valign="top" style="padding-left:10px">
	<div class="scrl-ovr">
	<table cellpadding="0" cellspacing="0" class="col-lg-12 users_no" style="width:100%">
		<tr class="hdr_tr">
		    <th class="nm_ipad" style="padding:8px 12px;background: none repeat scroll 0 0 #ABBAC3;color: #FFFFFF;"><?php echo __('User(s) in this');?><?php //echo $this->Format->formatText($pjname); ?> <?php echo __('Project');?></th>
		</tr>
		<tr>
		    <td >
			<ul id="userList" class="holder" style="border:1px solid #FAFAFA;width: 100%;">
			<?php 
				$selected_count = 0;
				if(isset($selected_users)){
				 	foreach($selected_users as $uk => $uv){
						$selected_count = 1;
						echo '<li id="'.$uk.'" rel="7" class="bit-box instant_select_user">'.$uv.'<a onclick="removeUserName(\''.$uk.'\',\'selected\');" href="javascript:void(0);" id="close'.$uk.'" class="closebutton"></a></li>';
					}
				}
			?>
			</ul>
		    </td>
		</tr>
		<?php
		$userCount = count($memsExstArr);
		$count = 0;
		$class = "";
		$totCase = 0;
		$totids = "";
		if ($userCount) {
		    $typ = "";
		    foreach ($memsExstArr as $memsAvlArr) {
			$user_id = $memsAvlArr['User']['id'];
			$user_name = ucfirst($memsAvlArr['User']['name']);
			$user_shortName = $memsAvlArr['User']['short_name'];
			$user_email = $memsAvlArr['User']['email'];
			$user_istype = $memsAvlArr['User']['istype'];
			$count++;
			if ($count % 2 == 0) {
			    $class = "row_col";
			} else {
			    $class = "row_col_alt";
			}
			?>
			<tr id="extlisting<?php echo $user_id; ?>" class="rw-cls1 <?php echo $class; ?>"  onmouseover="displayDeleteImg('<?php echo $user_id; ?>');" onmouseout="hideDeleteImg('<?php echo $user_id; ?>');">
			    <td style="padding-left:10px;<?php echo $class; ?>">
			   <div class="fl" title="<?php echo $user_email;?>">
				<?php echo $this->Format->shortLength($user_name, 25); ?>
				<?php
				$usr_typ_name = '';
				if ($memsAvlArr['CompanyUser']['user_type'] == 1) {
				    $colors = 'color:Green';
				    $usr_typ_name = 'Owner';
				} else if ($memsAvlArr['CompanyUser']['user_type'] == 2) {
				    $colors = 'color:Red';
				    $usr_typ_name = 'Admin';
				} else if ($memsAvlArr['CompanyUser']['user_type'] == 3 && $role != 3) {
				    
				}
				?>
				<span style="font-size:13px;<?php echo $colors; ?>">&nbsp;&nbsp;&nbsp;<?php echo $usr_typ_name; ?></span>
			</div>
			<div id="deleteImg_<?php echo $user_id; ?>" title="<?php echo __('Delete');?>" class="dropdown_cross fr" style="display:none;color:#D4696F;font-weight:bold;cursor:pointer" onclick="deleteUsersInProject('<?php echo $user_id; ?>','<?php echo $projid;?>','<?php echo urlencode($user_name);?>');">&times;</div>
				<div class="cb"></div>
			    </td>
			</tr>
			<?php
			$totids.= $user_id . "|";
			$typ = $user_istype;
			    }
			} else {
			    ?>
		    		<tr class="no-extuser_tr" <?php if($selected_count){ ?> style="display:none;"<?php } ?>>
		    		    <td colspan="7">
		    		<center class="fnt_clr_rd"><?php echo __('No user(s) available');?>.</center>
		    	</td>
			</tr>
		    <?php } ?>
	</table>
	</div>
	</td>
</tr>
</table>
<input type="hidden" name="hid_cs" id="hid_cs" value="<?php echo $count; ?>"/>
<input type="hidden" name="totid" id="totid" value="<?php echo $totids; ?>"/>
<input type="hidden" name="chkID" id="chkID" value=""/>
<input type="hidden" name="slctcaseid" id="slctcaseid" value=""/>
<input type="hidden" id="getusercount" value="<?php echo $userCount; ?>" readonly="true"/>
<input type="hidden" name="project_id" id="projectId" value="<?php echo $projid; ?>"/>
<input type="hidden" name="project_name" id="project_name" value="<?php echo $pjname; ?>"/>
<input type="hidden" name="cntmng" id="cntmng" value="<?php echo $cntmng; ?>"/>
<script type="text/javascript">
	$(document).ready(function(){
		window.onbeforeunload = function(){	
			if($('#userList li').length){		    
				return '<?php echo __('Please save your changes before leaving this page.');?>';
			}
		};
	});
</script>
