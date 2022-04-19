<style>
*{
padding:5;
margin:5;	
}
body{
padding:5;
margin:5;	
}
.link:hover {
	text-decoration:underline;
}
</style>
<title>Page Not Found</title>
<script>
document.title = "Page Not Found";
</script>
<table width="100%" align="center"><tr><td align="center">
<table cellpadding="8" cellspacing="8" style="border:1px solid #999999;color:#000000" align="center" width="520px">
	<tr>
		<td align="left" style="border-bottom:1px solid #999999">
			<div style="float:left"><img src="<?php echo HTTP_ROOT."img/images/error.png"; ?>"></div>
			<div style="float:left;padding-left:10px;font-size:18px;">The page you requested was not found</div>
		</td>
	</tr>
	<tr>
		<td align="left" style="padding-top:10px">
			<font style="color:#000000;font-size:14px;">You may have clicked an expired link or mistyped the address.<br/>Some web addresses are case sensitive.</font>
			<br/>
			<br/>
			<a href="<?php echo HTTP_ROOT; ?>" style="color:#0000FF;" class="link">Return</a>
		</td>
	</tr>
</table>
</td></tr></table>
