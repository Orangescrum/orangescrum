<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
//<![CDATA[
var mc = null;
var map = null;
var mgr = null;
var kmlLayer = null;
var fusionLayer = null;
var showKmlLayer = false;
var showFusionLayer = false;
var showFusionLayerHeatmap = false;
var showMarketClusterer = false;
var showMarketManager = false;
var geocoder = null;
var icon;

function buildMap() {
  map = new google.maps.Map(document.getElementById('map'), {
    center: new google.maps.LatLng(40, -15),
    zoom: 2,
    mapTypeId: 'terrain'
  });
  
var contentString = '<p><span style="font-weight:bold">Corporate Headquarter<br> Andolasoft Inc.</span> <br>'+
    'San Jose,<br>'+
    'CA - 95124, USA.<br>'+
    '<span style="font-weight:bold">(408) 564-9964</span><br></p>';

var infowindow1 = new google.maps.InfoWindow({
    content: contentString
});
var marker1 = new google.maps.Marker({
    position: new google.maps.LatLng(37.256802, -121.923038),
    map: map
});

google.maps.event.addListener(marker1, 'click', function() {
  infowindow1.open(map,marker1);
});  
  
var contentString = '<p><span style="font-weight:bold">India Development Center<br></span>S-3 A/65, Mancheswar Industrial Estate<br>'+
    'Bhubaneswar-751010, Orissa, INDIA.<br>'+
    '<span style="font-weight:bold">+91(674)258-7439/40</span><br>'+
    '<span style="font-weight:bold">VOIP:&nbsp;&nbsp;(408) 907-4166</span></p>';

var infowindow2 = new google.maps.InfoWindow({
    content: contentString
});
var marker2 = new google.maps.Marker({
    position: new google.maps.LatLng(20.293515, 85.858594),
    map: map
});

google.maps.event.addListener(marker2, 'click', function() {
  infowindow2.open(map,marker2);
});  
    
  
}
window.onload = buildMap;

//]]>
</script>
<style>
a, a:visited, a:active{color:#017fd3; text-decoration: underline;}
.text p{
	line-height:21px;
}
</style>
<table cellspacing="0" cellpadding="0" align="center" width="100%" style="color:#616161; font-family:PT Sans; line-height:24px" id="faq">
	<tr><td align="center"><img src="<?php echo HTTP_ROOT; ?>img/images/footer_shadow_top.png" /></td></tr> 
	<tr>
		<td align="center">
			<table align="center" width="1000px" cellspacing="4" cellpadding="0" style="background:#FFFFFF; border-radius:10px; -moz-border-radius:10px; padding:20px">
				<tr>
					<td align="left" colspan="3" height="30px">
						<h2 style="color:#004D7D">Contact Us</h2>
					</td>
				</tr>
				<tr>
					<td align="left">
						<div id="map" style="width:635px;height:300px;z-index:10;"></div>
					</td>
					<td valign="top" style="padding-left:10px">
						<p><span style="font-weight:bold">Corporate Headquarter<br/> Andolasoft Inc.</span> <br/>
						San Jose,<br />
						CA - 95124, USA.<br />
						<span style="font-weight:bold">(408) 564-9964</span><br/></p>
					</td>
					<td width="200px" valign="top">
						<p><span style="font-weight:bold">India Development Center<br /></span>S-3 A/65, Mancheswar Industrial Estate<br />
						Bhubaneswar-751010, Orissa, INDIA.<br />
						<span style="font-weight:bold">+91(674)258-7439/40</span><br/>
						<span style="font-weight:bold">VOIP:&nbsp;&nbsp;(408) 907-4166</span></p>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center" style="padding-top:20px">
						<div style="border:0px solid yellow; height:50px">
						<div style="float:left;width:750px;border:0px solid red;height:0px; padding-left:120px">
						<div style="float:left;width:200px;"><p>Product &amp; Sales Enquiry<br/><a href="mailto:sales@andolasoft.com" class="emailLnk">sales@andolasoft.com</a></p></div>
						<div style="float:left;width:180px;"><p>General Information<br/><a href="mailto:support@orangescrum.com" class="emailLnk">support@orangescrum.com</a></p></div>
						<div style="float:left;width:180px;"><p>Careers<br/><a href="mailto:jobs@andolasoft.com" class="emailLnk">jobs@andolasoft.com</a></p></div>
						<div style="padding-left:20px"><p>For link exchange<br/><a href="mailto:links@andolasoft.com" class="emailLnk">links@andolasoft.com</a></p></div>
						</div>
						</div>
					</td>
				</tr>
			</table>
		</td>	 
	</tr>
</table>