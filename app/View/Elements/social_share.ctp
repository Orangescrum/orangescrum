<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&appId=344031535737414&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script src="https://apis.google.com/js/platform.js" async defer></script>

<?php 
$org_social_pages = array("free_download", "community", "services", "roadmap");
$page = "";
if(in_array(PAGE_NAME, $org_social_pages)) {
    $page = HTTP_HOME_ORG.ltrim($_SERVER['REQUEST_URI'], "/");
}
else {
	$page = HTTP_ROOT.ltrim($_SERVER['REQUEST_URI'], "/");
}
?>

<style>
.soc_links{text-align: center;}
.soc_links span.stMainServices{height:22px;}
.soc_links span.stButton_gradient{height:22px;}
.rt_soc_icon {background: none repeat scroll 0 0 #FFFFFF;border: 1px solid #CCCCCC;border-radius: 8px 8px 8px 8px;height: auto;right:20px;min-height: 310px;padding-bottom: 10px;position:fixed;top:100px;width:80px;padding:15px 5px;z-index:99999;}
.mb15{margin-bottom:15px;}
</style>
<div class="rt_soc_icon">
    <div class="soc_links">
	<div class="mb15">
	    <div class="fb-like" data-href="<?php echo $page;?>" data-layout="box_count" data-action="like" data-show-faces="false" data-share="false"></div>
	</div>
	<div class="mb15">
	    <a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $page;?>" data-via="TheOrangescrum" data-count="vertical">Tweet</a>
	</div>
	<div class="mb15">
	    <script src="//platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
	    <script type="IN/Share" data-url="<?php echo $page;?>" data-counter="top"></script>
	</div>
	<div>
	    <div class="g-plus" data-action="share" data-annotation="vertical-bubble" data-href="<?php echo $page;?>"></div>
	</div>            
    </div>
    <div class="cb"></div>
</div>