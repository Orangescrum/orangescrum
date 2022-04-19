<input type="hidden" id="types_all">
<input type="text" placeholder="<?php echo __('Search');?>" class="searchType" onkeyup="searchFilterItems(this);" />
<?php
$m=0;
if(isset($comArr))
{
	$m=0;
	$totComCase = 0;
	$h = 0;
	foreach($comArr as $mem)
	{   $members=explode("-",$CookieMem);
		$m++;
		$memId = $mem['User']['id'];
		$memUniqId = $mem['User']['uniq_id'];
		$memName = $mem['User']['name'];
		if(!empty($mem['User']['last_name'])){
			$memName .= ' '.$mem['User']['last_name'];
		}
		$memLogin = $mem['User']['dt_last_login'];
		$shortname =  $mem['User']['short_name'];
		?>
		<li class="li_check_radio" <?php if($m > 5){$h++;?> id="hidCom_<?php echo $h; ?>"  <?php }?> > <!--style="display:none;"-->
		<div class="checkbox">
		  <label>
                      <input type="checkbox" id="coms_<?php echo $m; ?>" class="comment<?php echo $memId; ?>" onClick="checkboxComs('coms_<?php echo $m; ?>','check');filterRequest('coms');"  style="cursor:pointer;" <?php if (in_array($memId, $members) ) { echo "checked"; } ?>/> <?php echo $this->Format->formatText($memName); ?> (<?php echo $mem[0]['cases']; ?>)
		  </label>
		  <div style="margin:0;color:#999999;line-height:16px;padding-left:20px;font-size:11px;">
			<?php
			if($memLogin == "" || $memLogin == "NULL" || $memLogin == "0000-00-00 00:00:00" || !SES_TIMEZONE)
			{
				echo __("Yet to Sign In");
			}
			else
			{
				$last_logindt = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,$memLogin,"datetime");
				$locDResFun2 = $this->Tmzone->GetDateTime(SES_TIMEZONE,TZ_GMT,TZ_DST,TZ_CODE,GMT_DATETIME,"date");
				echo __("Last Sign In").": ".$this->Datetime->dateFormatOutputdateTime_day($last_logindt,$locDResFun2);
			}
			?>
		</div>
		<input type="hidden" name="comids_<?php echo $m; ?>" id="comids_<?php echo $m; ?>" value="<?php echo $memId; ?>" readonly="true">
		</div>
	    </li>
		<?php
	}
	if($h != 0){?>

	<?php
	} ?>

<?php } ?>
<input type="hidden" id="totComId" value="<?php echo $m; ?>" readonly="true"/>
