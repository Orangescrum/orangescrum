<style>
@font-face {	
	font-family:'RobotoDraft-Regular';
	src: url('../fonts/RobotoDraft-Regular.eot');
	src: url('../fonts/RobotoDraft-Regular.eot?#iefix') format('embedded-opentype'),
		url('../fonts/RobotoDraft-Regular.woff') format('woff'),
		url('../fonts/RobotoDraft-Regular.ttf') format('truetype'),
		url('../fonts/RobotoDraft-Regular.otf') format('opentype'),
		url('../fonts/RobotoDraft-Regular.svg#RobotoDraft-Regular') format('svg');
	font-weight: 400;
	font-style: normal;
	font-stretch: normal;
	unicode-range: U+000D-2212;
}
body{margin:0;padding:0;font-family:tahoma;}
.fl{float:left}
.fr{float:right}
.cb{clear:both}
.roadmap-banner{background:url(../img/updates/product-update-banner.jpg) no-repeat center center ;background-size:cover;width:100%;height:auto;position:relative;display:block}
.device-icon{position:relative}
.device-icon::before{content:'';background:url(../img/updates/sprite-updtaes.png) no-repeat 0px 0px ;position:relative;display:inline-block;vertical-align: middle;margin-right:3px;width: 24px;height: 30px;}
.device-icon.ios::before{background-position:0px 0px;}
.device-icon.android::before{background-position:0px -81px;}
.device-icon.chart::before{background-position: 0px -39px;}
.latest-update-btn{width:30%;margin:0 auto;padding-top:294px}
.latest-update-btn a{display:block;width:260px;padding:15px 0;background:#F79220;color:#fff;text-align:center;text-decoration:none;font-size:22px;margin:0 auto;border-radius:6px 6px 0 0}
.luf{width:100%;background:#F2F2F2}
.luf-cont{margin:0 auto;padding:30px 0;text-align:center}
.luf-cont h1{font-size:28px;color:#313131;font-weight:normal;margin:0}
.luf-cont h2{font-size:20px;color:#9F9F9F;line-height:30px;margin:15px 0 0;padding:0}
.luf-cont h6{font-size:16px;color:#ADADAD;margin:15px 0;line-height:24px;font-weight:normal}
.luf-cont a{text-decoration:none;color:#3667FF}
.version-info{width:100%;background:#FBFBFB;position:relative;padding-bottom:30px;}
.release-date{width:73%;min-height:185px;margin:0 auto;position:relative;}
.realease-desc div:first-child{width:25%;box-sizing:border-box}
.release-date > .date-flag{width:15%;margin-top:30px;padding:13px 0 13px 20px;text-align:center;box-sizing:border-box;position:relative;background:#E6E6E6;z-index:9}
.date-flag.green-flg{background:#48BF6F;color:#fff}
.date-flag.green-flg strong{font-size:13px;font-weight:bold;font-family: RobotoDraft-Regular}
.flag-arw{background:url(../img/updates/flag-arrow.png) no-repeat;display:block;left:-2px;top:0px;position:absolute;width:40px;height:44px}
.release-date > .version-dv{width:20%;height:94px;box-sizing:border-box;border:3px solid #E6E6E6;border-top:none;border-right:none;border-radius:0 0 0 10px;position:absolute;left:144px;top:72px;}
.version-dv .version-detail{position:relative;left:80px;top:-35px;}
.fnu-icon{background:url(../img/updates/prodcut-update-icons.png) no-repeat;display:inline-block;width:30px;height:30px;position:relative;}
.fnu-icon.fix-icon{background-position:9px 6px;left:0;top:10px}
.fnu-icon.new-icon{background-position:-20px 6px;left:0;top:10px}
.fnu-icon.update-icon{background-position:-45px 6px;left:0;top:10px}
.fnu-btn a{text-decoration:none;font-size:13px;background:#e6e6e6;padding:4px 8px;color:#5a5a5a;border-radius:5px;cursor:default;}
.version-dv.version-grn{border-color:#48BF6F}
.version-dv h6{font-size:18px;margin:60px 0 0 10px;display:inline-block}
.release-date > .realease-desc{width:65%;height:auto;box-sizing:border-box;position:relative;margin-top:140px}
.realease-desc .orange-icon{background:url(../img/updates/orange-icon.png) no-repeat 0px 0px;position:absolute;left:-6px;top:0;display:block;width:40px;height:40px}
.realease-desc a{display:block;width:110px;padding:8px 0;text-decoration:none;text-align:center;color:#000;font-size:17px;border:1px solid #E6E6E6;background:#E6E6E6;border-radius:5px;margin-left:35px;cursor:default;}
.realease-desc.green-btn a{background:#48BF6F;color:#fff}
.realease-desc h6{color:#313131;line-height:30px;font-size:16px;margin:0;font-weight:normal}
.realease-desc .release-info{width:75%;word-wrap:break-word;box-sizing:border-box}
.vertical-line{background:url(../img/updates/vertical-line.png) repeat-y center center;display:block;width:40px;height:100%;position:absolute;left:28%;top:0%}
.wrapper,.rht_content_cmn_help{padding-left:0;padding-right:0}
.wrapper{padding-top:36px}
.add_bar .wrapper{padding-top:0px}
.sticky_footer{padding-top:46px}
.realease-desc .release-info a{border: none;
width: auto;
text-align: left;
margin: 0;
font-size: 14px;
font-weight: 500;
background: transparent;
color: #1192E4;
outline:none;
}
.realease-desc .release-info a:hover{text-decoration:underline;cursor:pointer}
/*media query start*/
@media screen and (max-width:1280px){
	.release-date > .version-dv {left:137px}
	.vertical-line {height:97%;}
}
@media screen and (max-width:1030px){
.release-date > .version-dv {left:89px;top:70px}
.realease-desc h6 {padding-left:20px}
.release-date > .date-flag {font-size:13px}
}
@media screen and (max-width:980px){
.release-date > .version-dv {left:84px}
.realease-desc .orange-icon {left:-6px}
}
@media screen and (max-width:850px){
.release-date > .date-flag {width:20%}
.release-date > .version-dv {width:20%;left:124px}
.vertical-line {left:33%}
.release-date {width:80%}
}
@media screen and (max-width:768px){
.release-date > .version-dv {left:119px;}
.vertical-line{height:940px}
.latest-update-btn {width:40%}
}
@media screen and (max-width:650px){
.release-date {width:90%;}
.release-date > .version-dv {left:111px;}
.vertical-line {height:1000px;}
}
@media screen and (max-width:480px){
.latest-update-btn {width:60%}
.luf-cont {width:460px}
.luf-cont p {font-size:16px}
.luf-cont h6 {font-size:14px}
.release-date > .date-flag {width:25%;}
.release-date > .version-dv {left:104px;}
.realease-desc > div:first-child{width:70% !important;margin-left:20px;}
.realease-desc .release-info {float:none;width:90%}
.realease-desc .orange-icon {left:15px;}
.vertical-line {left:37%;}
}
@media screen and (max-width:360px){
.latest-update-btn {width:80%;}
.luf-cont {width:340px}
.luf-cont p br{display:none}
.release-date > .date-flag {width:33%}
.release-date > .version-dv {width:24%;}
.realease-desc > div:first-child {margin-left:56px;width:75% !important;}
.realease-desc .orange-icon {left:50px;}
.version-dv h6 {margin:40px 0 0 15px;}
.realease-desc h6 {font-size:14px}
.vertical-line {display:none}
}
@media screen and (max-width:330px){
.luf-cont {width:310px}
.release-date > .version-dv {left:92px;}
.realease-desc .orange-icon {left:43px;}
.realease-desc a {width:100px}
.realease-desc > div:first-child {margin-left:45px;}
}
ul, ol{
	color: #333;
	list-style: outside none circle;
}
	</style>
</head>
<body>
	<div class="roadmap-banner">
		<div class="latest-update-btn">
			<a href="javascript:void(0)" title="Latest Updates">Latest Updates</a>
		</div>
	</div>
	<div class="luf">
		<div class="luf-cont">
			<h1>Latest Updates & Fixes</h1>
			<h2>These updates come straight from our Orangescrum Research & Development warehouse.<br/>
			You can also subscribe to get the latest Orangescrum updates right in your inbox.
			</h2>
		</div>
	</div>
	<div class="version-info">
		<?php 
		foreach($updates as $k => $v){ 	
		$device_type = 'chart';
		if(stristr(strtolower($v['ProductUpdate']['description']), 'ios')){
			$device_type = 'ios';
		}elseif (stristr(strtolower($v['ProductUpdate']['description']), 'android')){
			$device_type = 'android';
		}
		?>
		<div class="release-date">
			<div class="fl date-flag <?php if($v['ProductUpdate']['status'] == 1){ ?>green-flg<?php } ?>">
				<strong><?php echo $v['ProductUpdate']['date']; ?></strong>
				<span class="flag-arw"></span>
			</div>
			<div class="fl version-dv">
				<h6><?php echo $v['ProductUpdate']['version']; ?></h6>
				<div class="version-detail">
					<span class="fnu-icon <?php echo $v['ProductUpdate']['type']; ?>-icon"></span>
					<span class="fnu-btn">
						<a href="javascript:void(0);"><?php echo ucfirst($v['ProductUpdate']['type']); ?></a>
					</span>
				</div>
			</div>
			<div class="fr realease-desc <?php if($v['ProductUpdate']['status'] == 1){ ?>green-btn<?php } ?>">
				<div class="fl">
					<span class="orange-icon"></span>
					<a href="javascript:void(0);" class="device-icon <?php echo $device_type; ?>"><?php if($v['ProductUpdate']['status'] == 1){ ?>Released<?php }else{ ?>Expected<?php } ?></a>
				</div>
				<div class="fl release-info">
					<h6><?php echo $v['ProductUpdate']['description']; ?></h6>
				</div>
				<div class="cb"></div>
			</div>
			<div class="cb"></div>
		</div>
		<?php } ?>
		<div class="vertical-line"></div>
	</div>