<input type="hidden" id="assignTo_all">
<input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
    <li class="li_check_radio" id="unassigned">
      <div class="checkbox">
		  <label>
			  <input type="checkbox" id="unassgn" class="assignto0" <?php if(in_array('unassigned', $last)){ echo "checked"; } ?>onclick="checkboxAsns('unassgn','check');filterRequest('assignto');" <?php if($_COOKIE['ASSIGNTO'] == "unassigned" || in_array("unassigned", $last)){ echo "checked"; } ?> /> Unassigned (<?php echo $unasncount[0][0]['unasn_count']; ?>)
		  </label>
			<input type="hidden" name="Asnids_0" id="Asnids_0" value="0" readonly="true">
		</div>
    </li>
<?php
$m=0;
if(isset($asnArr))
{
//echo 'smruti';pr($asnArr);exit;
	$m=0;
	$totAsnCase = 0;
	$h = 0;
	foreach($asnArr as $Asn)
	{   $Asnbers=explode("-",$CookieAsn);
		$m++;
		$AsnId = $Asn['User']['id'];
		$AsnUniqId = $Asn['User']['uniq_id'];
		$AsnName = $Asn['User']['name'];
		if(!empty($Asn['User']['last_name'])){
			$AsnName .= ' '.$Asn['User']['last_name'];
		}
		$AsnLogin = $Asn['User']['dt_last_login'];
		$shortname =  $Asn['User']['short_name'];
		//if($m > 5){$h++;
		?>
			<li class="li_check_radio" <?php if($m > 5){$h++;?> id="hidAsn_<?php echo $h; ?>"  <?php }?>> <!--style="display:none;"-->
		    <div class="checkbox">
			  <label>
  <input type="checkbox" class="assignto<?php echo $AsnId; ?>" id="Asns_<?php echo $m; ?>" onClick="checkboxAsns('Asns_<?php echo $m; ?>','check');filterRequest('assignto');"  <?php if (in_array($AsnId, $Asnbers)) { echo "checked"; } ?>/> <?php echo $this->Format->formatText($AsnName); ?> (<?php echo $Asn[0]['cases']; ?>)
			  </label>
				<input type="hidden" name="Asnids_<?php echo $m; ?>" id="Asnids_<?php echo $m; ?>" value="<?php echo $AsnId; ?>" readonly="true">
			</div>
			<div style="margin:0;color:#999999;line-height:16px;padding-left:20px;font-size:11px;">
			<?php
			if($AsnLogin == "" || $AsnLogin == "NULL" || $AsnLogin == "0000-00-00 00:00:00" || !SES_TIMEZONE)
			{
				echo __("Yet to Sign In");
			}
			else
			{
				$last_logindt = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$AsnLogin,"datetime");
				$locDResFun2 = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,GMT_DATETIME,"date");
				echo __("Last Sign In").": ".$this->Datetime->dateFormatOutputdateTime_day($last_logindt,$locDResFun2);
			}
			?>
		    </div>
		</li>
		<?php
	}
	if($h != 0)
	{
	?>
<!--	<div class="slide_menu_div1 more-hide-div">
		<div class="more" align="right" id="Asn_more" >
			<a href="javascript:jsVoid();" onClick="moreLeftNav('Asn_more','Asn_hide','<?php echo $h; ?>','hidAsn_',event)">more...</a>
		</div>
		<div class="more" align="right" id="Asn_hide" style="display:none;">
			<a href="javascript:jsVoid();" onClick="hideLeftNav('Asn_more','Asn_hide','<?php echo $h; ?>','hidAsn_',event)">hide...</a>
		</div>
	</div>-->
	<?php
	} ?>
<?php } ?>
<input type="hidden" id="totAsnId" value="<?php echo $m; ?>" readonly="true"/>
