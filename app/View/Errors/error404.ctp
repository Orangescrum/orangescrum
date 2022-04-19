<style type="text/css">
body{margin:0;padding:0}
.error_page{background: #eaeaee;padding:0;font-family:Tahoma, Sans-Serif;}
.error_page .error_type_item{width:100%;max-width:950px;height:100vh;margin:0 auto;display:flex;align-items: center;}
.error_page .error_type_item aside{width:50%;font-size:18px;line-height:30px;color:#000}
.error_page .error_type_item h1{font-size:130px;line-height:110px;color:#ff7a59;font-weight:600;margin:30px 0 30px}
.error_page .error_type_item p{font-size:40px;line-height:40px;color:#000;margin:0;padding:0}
.error_page .error_type_item p a{display:inline-block;vertical-align:middle;text-decoration:none;font-size:14px;line-height:20px;border:1px solid #39c;color:#39c;padding:10px 20px;border-radius:20px;margin-right:15px}
.error_page .error_type_item p a:hover{border-color:#39c;background-color:#39c;color:#fff}
.error_page .error_type_item aside.lft{text-align:left}
.error_page .error_type_item aside.rht{text-align:right;padding-left:30px}
.error_page .error_type_item .info{font-size:18px;line-height: 35px;margin:30px 0}
.error_page .error_type_item figure{margin:0;padding:0;position: relative;}
.error_page ul {margin:20px 0;padding: 0;list-style-type: none;text-align:left}
.error_page ul li {display:inline-block;text-align: left;color: #34465a;padding:0;matgin-right:10px;vertical-align:middle}
.error_page ul li a{text-decoration: none;display: inline-block;vertical-align:middle}
.error_page .os_apps{text-align:left}
.error_page .os_apps a{margin-right:10px}
@media only screen and (max-width:1100px){
	.error_page .error_type_item{max-width:95%;}
	.error_page .error_type_item h1 {font-size: 105px;}
	.error_page .error_type_item p {font-size: 32px;}
	.error_page .error_type_item p a{margin-right:5px}
}
@media only screen and (max-width:800px){
	.error_page .error_type_item{height:auto;flex-direction: column;}
	.error_page .error_type_item aside{width:100%;padding:15px}
}
@media only screen and (max-width:700px){
	.error_page .error_type_item h1 {font-size:40px;line-height:50px}
	.error_page .error_type_item p {font-size:24px;line-height:32px}
	.error_page .error_type_item p a{padding: 5px 15px;}
}
</style>
<section class="error_page">
	<div class="error_type_item">
		<aside class="lft">
			<a href="<?php echo HTTP_ROOT; ?>"><img src="https://www.orangescrum.com/img/header/orangescrum-cloud-logo.svg" alt="Orangescrum.com" title="Orangescrum.com" width="200" height="50"></a>
			<h1>Oh hi.</h1>
			<p>How did you get here ?</p>
			<div class="info">You might find one of these pages helpful.</div>
			<p><a href="<?php echo HTTP_ROOT; ?>" title="Home Page">Home Page</a>
			<a href="<?php echo BLLOG_OS_URL;?>ebook" title="eBooks">eBooks</a>
			<a href="https://www.orangescrum.com/contact-support/" title="Contact Us">Contact Us</a></p>
			<ul>
				<li><a href="https://www.facebook.com/OrangeScrum" target="_blank" alt="Orangescrum on facebook" title="Orangescrum on facebook" class="cmn_hf_sp facebook"></a></li>
				<li><a href="https://www.linkedin.com/company/the-orangescrum" target="_blank" alt="Orangescrum on linkedin" title="Orangescrum on linkedin" class="cmn_hf_sp linkdin hover_scale"></a></li>
				<li><a href="https://twitter.com/theorangescrum" target="_blank" alt="Orangescrum on twitter" title="Orangescrum on twitter" class="cmn_hf_sp twitter hover_scale"></a></li>
			</ul>
			<div class="os_apps">
				<a href="http://itunes.apple.com/WebObjects/MZStore.woa/wa/viewSoftware?id=1390552311&amp;mt=8" target="_blank" title="Orangescrum in App store">
					<span class="cmn_hf_sp app_store"></span>
				</a>
				<a href="https://play.google.com/store/apps/details?id=com.andolasoft.orangescrum&amp;hl=en" target="_blank" title="Orangescrum in play store">
					<span class="cmn_hf_sp play_store"></span>
				</a>
			</div>
		</aside>
		<aside class="rht">
			<figure>
				<img src="<?php echo HTTP_ROOT; ?>img/404.gif" alt="404" title="404" width="480" height="480">
			</figure>
		</aside>
	</div>
</section>