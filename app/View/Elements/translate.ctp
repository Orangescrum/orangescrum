<style type="text/css">
	.wrapper{position:relative}
	.language_translate{position:absolute;left:0;top:-7px;display: inline-block;vertical-align: middle;}
	.language_translate .dropdown-toggle{margin:0;padding:5px 10px;border:1px solid transparent !important;background:transparent !important;}
	.language_translate .dropdown-toggle:hover{background:transparent !important}
	.language_translate .dropdown-toggle .material-icons{font-size:20px;color:#333}
	.language_translate .dropdown-toggle .select_fld_lang{margin:0 5px;font-size:18px;color:#fff;text-transform: capitalize;}
	.language_translate .dropdown-menu{margin:0;padding:0;list-style-type:none;width:500px;left:0;float: none;right: initial;bottom:50px;top: initial;border:none;box-shadow: 0px 0px 5px #d3d6d8;}
	.language_translate .dropdown-menu .flex_li{display: flex;padding: 25px 0;}
	.language_translate .dropdown-menu .flex_ul{display: inline-flex;
    flex-direction: column;width: 33.33%;padding:0px 40px;box-sizing:border-box}
	.language_translate .dropdown-menu .flex_ul li{padding:6px 0;}
	.language_translate .dropdown-menu .flex_ul li a{text-decoration:none;font-size:13px;line-height:20px;color:#215ca0}
	.language_translate .dropdown-menu .flex_ul li a:hover{color:#649ad6}
	.language_translate .dropdown-menu::before{content:'';width:0;height:0;border-left:12px solid transparent;border-right:12px solid transparent;border-top:12px solid #fff;position:absolute;left:45px;bottom:-12px;margin:auto;}
</style>
<script type="text/javascript">
		function googleTranslateElementInit() {
				new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE, autoDisplay: false}, 'google_translate_element');
		}
	      $(window).load(function() {
          var googleTranslateScript = document.createElement('script');
          googleTranslateScript.type = 'text/javascript';
          googleTranslateScript.async = true;
          googleTranslateScript.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit';
          ( document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0] ).appendChild( googleTranslateScript );
        });
</script>

<div class="dropdown">
	<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">
		<span class="cmn_hf_sp world-wide"></span>
		<span class="select_fld_lang">Worldwide</span>
		<span class="cmn_hf_sp caret"></span>
	</button>
	<ul class="dropdown-menu">
		<li class="flex_li" id='language'>
			<ul class="flex_ul">
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ar)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ar)';window.location.reload();">Arabic</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|zh-CN)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|zh-CN)';window.location.reload();">Chinese</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|da)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|da)';window.location.reload();">Danish</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|nl)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|nl)';window.location.reload();">Dutch</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|en)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|en)';window.location.reload();">English</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|fi)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|fi)';window.location.reload();">Finnish</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|fr)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|fr)';window.location.reload();">French</a></li>				
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|de)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|de)';window.location.reload();">German</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|el)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|el)';window.location.reload();">Greek</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|iw)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|iw)';window.location.reload();">Hebrew</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|hi)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|hi)';window.location.reload();">Hindi</a></li>
			</ul>
			<ul class="flex_ul">
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|hu)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|hu)';window.location.reload();">Hungarian</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|id)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|id)';window.location.reload();">Indonesian</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ga)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ga)';window.location.reload();">Irish</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|it)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|it)';window.location.reload();">Italian</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ja)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ja)';window.location.reload();">Japanese</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ko)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ko)';window.location.reload();">Korean</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ms)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ms)';window.location.reload();">Malay</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|pl)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|pl)';window.location.reload();">Polish</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|pt)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|pt)';window.location.reload();">Portugeuse</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ro)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ro)';window.location.reload();">Romanian</a></li>
			</ul>
			<ul class="flex_ul">
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ru)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ru)';window.location.reload();">Russian</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|st)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|st)';window.location.reload();">Sesotho</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|es)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|es)';window.location.reload();">Spanish</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|sv)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|sv)';window.location.reload();">Swedish</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ta)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ta)';window.location.reload();">Tamil</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|th)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|th)';window.location.reload();">Thai</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|tr)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|tr)';window.location.reload();">Turkish</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|ur)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|ur)';window.location.reload();">Urdu</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|vi)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|vi)';window.location.reload();">Vietnamese</a></li>
				<li><a href="<?php echo HTTP_ROOT;?>#googtrans(en|yo)" onClick="javascript:location.href='<?php echo HTTP_ROOT;?>#googtrans(en|yo)';window.location.reload();">Yoruba</a></li>
			</ul>
		</li>
	</ul>	
</div>