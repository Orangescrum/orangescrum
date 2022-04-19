<?php
if(isset($projLogo))
{
?>
<table cellpadding="0" cellspacing="0">
	<tr>
		<td>
			<?php
			if($projLogo && $this->Format->imageExists(DIR_PROJECT_LOGO,$projLogo))
			{
			?>
				<?php /*?><a href="<?php echo HTTP_PROJECT_LOGO.$projLogo; ?>" target="_blank" style="text-decoration:none;" border="0"><?php */?>
					<img src="<?php echo HTTP_ROOT;?>users/image_thumb/?type=logo&file=<?php echo $projLogo; ?>&sizex=165&sizey=70&quality=100" border="0" alt="<?php echo $projName; ?>" title="<?php echo $projName; ?>"/>
				<!--</a>-->
			<?php
			}
			else
			{
			?>
				<img src="<?php echo HTTP_IMAGES; ?>images/comp_place_holder.jpg" alt="Logo Placeholder" title="Logo Placeholder"/>
			<?php
			}
			?>
		</td>
		<td width="45px" align="center"><div style="background:#dedede; width:1px; height:35px"></div></td>
	</tr>
</table>
<?php
}
?>
