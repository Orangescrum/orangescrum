<input type="hidden" id="types_all">
<input type="text" placeholder="Search" class="searchType" onkeyup="searchFilterItems(this);" />
<?php

$DEFAULT_TASK_TYPES = array("bug"=>"&#xE60E;","enh"=>"&#xE01D;","cr"=>"&#xE873;","dev"=>"&#xE1B0;","idea"=>"&#xE90F;","mnt"=>"&#xE869;","oth"=>"&#xE892;","qa"=>"Q","rel"=>"&#xE031;","rnd"=>"&#xE8FA;","unt"=>"&#xE3E8;","upd"=>"&#xE923;");
if(isset($typeArr))
{
	$t=0;
	$totCase = 0;
	$h=0;
	$CookieTypes = explode("-", $CookieTypes);
	foreach($typeArr as $typ)
	{
		$typeId = $typ['t']['id'];
		$typeShortName = $typ['t']['short_name'];
		$typeName = $typ['t']['name'];
		$typecount = $typ['0']['count'];
		
		$img = "<img src='".HTTP_IMAGES."images/types/".$typeShortName.".png' />";
		if (isset($typ['t']['company_id']) && trim($typ['t']['company_id'])) {
		    $img = "<span class='ttl_dd_icn'>".mb_substr(trim($typeName),0,1, "utf-8")."</span>";
		}
		$t++;		
		$txs_typ = $typeName;
		foreach($DEFAULT_TASK_TYPES as $i=>$n) {
			if($i == $typeShortName){
				$txs_typ = $n;
			}
		} 
		//if($t > 5)	$h++;
		?>
		<li class="li_check_radio" <?php if($t > 5){ $h++;?>id="hidType_<?php echo $h; ?>" <?php } ?>> <!--style="display:none;"-->
		    
			<div class="checkbox">
			  <label>
				<input type="checkbox" class="cst_type_cls" id="types_<?php echo $typeId; ?>" data-id="<?php echo $typeId; ?>" onClick="checkboxTypes('types_<?php echo $typeId; ?>','check');filterRequest('type');" style="cursor:pointer;" <?php if(in_array($typeId,$CookieTypes)) { echo "checked"; } ?>/> 
				<?php if($txs_typ == $typeName){ ?>
					<span class="ttl_dd_icn"><?php echo mb_substr(trim($typeName),0,1, "utf-8"); ?></span>
				<?php }else{ ?>
					<i class="material-icons"><?php echo $txs_typ; ?></i>
				<?php } ?>
				<?php echo $typeName; ?> (<?php if($proj_uniq_id != 'all'){ echo $typecount; }else{echo $typecount;}?>)
			  </label>
			  <input type="hidden" name="typeids_<?php echo $typeId; ?>" id="typeids_<?php echo $typeId; ?>" value="<?php echo $typeId; ?>" readonly="true">
			</div>
		</li>
		<?php
	}
	if($h != 0)
	{
	?>
<!--	<div class="slide_menu_div1 more-hide-div">
		<div class="more" align="right" id="type_more">
			<a href="javascript:jsVoid();" onClick="moreLeftNav('type_more','type_hide','<?php echo $h; ?>','hidType_',event)">more...</a>
		</div>
		<div class="more" align="right" style="display:none;" id="type_hide">
			<a href="javascript:jsVoid();" onClick="hideLeftNav('type_more','type_hide','<?php echo $h; ?>','hidType_',event)">hide...</a>
		</div>
	</div>-->
	<?php
	}
	?>
	<input type="hidden" id="totType" value="<?php echo $t; ?>" readonly="true"/>
	<?php
}
?>