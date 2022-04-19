var emlRegExpRFC = RegExp(
			/^[a-zA-Z0-9.’*+/_-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/
		);
var time;function showTopErrSucc(type,msg){$("#topmostdiv").show();$("#btnDiv").show();$("#upperDiv").show();if(type=='error'){$("#upperDiv").find(".msg_span").removeClass('success');}else{$("#upperDiv").find(".msg_span").removeClass('error');}
$("#upperDiv").find(".msg_span").addClass(type);$("#upperDiv").find(".msg_span").html(msg);clearTimeout(time);time=setTimeout(removeMsg,6000);}
function removeMsg(){$('#upperDiv').fadeOut(300);$("#btnDiv").hide();}
var OAUTHURL='https://accounts.google.com/o/oauth2/auth?';var SCOPE='https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email';var TYPE='code';var google_signup;var google_login;var pollTimer;function signinWithGoogle(){
	if(GID_NO == 'XXXXXXXXXXXX'){
		alert('To use Google signup, please updtae the Google Keys in the `app/Config/constants.php`');	return false;	
	}	
	var uri=(window||this).location.href;var index=uri.indexOf(PROTOCOL+"www."+DOMAIN+"signup/");var param="getstarted";if(index!==-1){param=uri.replace(PROTOCOL+"www."+DOMAIN+"signup/","");param=(param)?param:"getstarted";}
var _url=OAUTHURL+'scope='+SCOPE+'&client_id='+CLIENT_ID_SIGNUP+'&redirect_uri='+REDIRECT_SIGNUP+'&response_type='+TYPE+'&access_type=offline&state=signup';createCookie("google_accessToken",'',-365,DOMAIN_COOKIE);window.open(_url,"windowname1",'width=600, height=600');if(pollTimer){window.clearInterval(pollTimer);}
pollTimer=window.setInterval(function(){try{if(getCookie('google_accessToken')){window.clearInterval(pollTimer);try{google_signup=getCookie('google_signup');var user_info=getCookie('user_info');createCookie("google_accessToken",'',-365,DOMAIN_COOKIE);createCookie("google_signup",'',-365,DOMAIN_COOKIE);if(user_info){window.location=PROTOCOL+"app."+DOMAIN+"users/login";}
else if(parseInt(google_signup)){window.location=PROTOCOL+"www."+DOMAIN+"signup/"+param;}}catch(e){return;}}}catch(e){}},500);}
function loginWithGoogle(){var _url=OAUTHURL+'scope='+SCOPE+'&client_id='+CLIENT_ID+'&redirect_uri='+REDIRECT+'&response_type='+TYPE+'&access_type=offline&state=login';createCookie("google_accessToken",'',-365,DOMAIN_COOKIE);window.open(_url,"windowname1",'width=600, height=600');if(pollTimer){window.clearInterval(pollTimer);}
pollTimer=window.setInterval(function(){try{if(getCookie('google_accessToken')){window.clearInterval(pollTimer);try{google_login=getCookie('google_login');createCookie("google_accessToken",'',-365,DOMAIN_COOKIE);createCookie("google_login",'',-365,DOMAIN_COOKIE);if(parseInt(google_login)){window.location=HTTP_APP+"users/login";}}catch(e){return;}}}catch(e){}},500);}
String.prototype.trim=function(){return this.replace(/^\s+|\s+$/g,"");}
function jsVoid(){}
function removeMsg(){$('#upperDiv').fadeOut(300);$("#btnDiv").hide();}
function getHeight()
{var height=document.body.offsetHeight;if(window.innerHeight)
{var theHeight=window.innerHeight;}
else if(document.documentElement&&document.documentElement.clientHeight)
{var theHeight=document.documentElement.clientHeight;}
else if(document.body)
{var theHeight=document.body.clientHeight;}
if(theHeight>height)
{var hg1=theHeight;}
else
{var hg1=height;}
var newhg=$(document).height();if(newhg>hg1){var hg=newhg+"px";}
else{var hg=hg1+"px";}
return hg;}
function cover_open(a,b)
{var hg=getHeight();document.getElementById(a).style.height=hg;$("#"+a).fadeIn();$("#"+b).slideDown('fast');}
function cover_close(a,b)
{document.body.style.overflow="visible";$("#"+a).fadeOut();$("#"+b).slideUp('fast');}
function postSupport(a,b)
{var support_name=$("#support_name").val().trim();var support_email=$("#support_email").val().trim();var support_msg=$("#support_msg").val().trim();$("#support_err").hide();if(support_name=="")
{$("#support_err").show();$("#support_err").html("Name cannot be blank!");$("#support_name").focus();return false;}
else if(support_email=="")
{$("#support_err").show();$("#support_err").html("E-mail cannot be blank!");$("#support_email").focus();return false;}
else
{var emailRegEx=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;if(!support_email.match(emlRegExpRFC) || support_email.search(/\.\./) != -1)
{$("#support_err").show();$("#support_err").html("Please enter a valid E-mail!");$("#support_email").focus();return false;}
else if(support_msg=="")
{$("#support_err").show();$("#support_err").html("Message cannot be blank!");$("#support_msg").focus();return false;}
else{$("#btn_submit").hide();$("#loaderpost").show();var strURL=$("#pageurl").val();$.post(strURL+"users/post_support",{"support_email":escape(support_email),"support_msg":escape(support_msg),"support_name":escape(support_name)},function(data){if(data=="success"){$("#btn_submit").show();$("#loaderpost").hide();cover_close('cover','inner_support');$("#support_name").val('');$("#support_email").val('');$("#support_msg").val('');cover_open('cover','inner_success');$("#successmsg").html("Thanks for your feedback. We will get back to you as soon as possible.");setTimeout("cover_close('cover','inner_success')",3000);}
else{cover_close('cover','inner_support');}});}}
return false;}
function validateSignUp()
{var name=document.getElementById('name');var pass_new=document.getElementById('pas_new');var pas_retype=document.getElementById('pas_retype');var errMsg;var done=1;if(name.value.trim()==""){errMsg="Name cannot be  blank!";name.focus();done=0;}
else if(pass_new.value.trim()==""){errMsg="Password cannot be  blank!";pass_new.focus();done=0;}
else if(pass_new.value.length<6||pass_new.value.length>15){errMsg="Password should be between 6-15 characters!";pass_new.focus();done=0;}
else if(pas_retype.value.trim()==""){errMsg="Confirm Password cannot be  blank!";pas_retype.focus();done=0;}
else if(pas_retype.value!=pass_new.value){errMsg="Password fields do not match!";pas_retype.focus();done=0;}
if(done==0){document.getElementById('err_signup').style.display='block';document.getElementById('err_signup').innerHTML=errMsg;return false;}
else{document.getElementById('err_signup').style.display='none';document.getElementById('signupbtn').style.display='none';document.getElementById('signupload').style.display='block';return true;}}
function validpwd(txtEmail)
{var email=document.getElementById(txtEmail).value;var done=1;if(email.trim()==""){err="'E-mail' cannot be left blank !";done=0;}
else{
var emailRegEx=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
if(!email.match(emlRegExpRFC) || email.search(/\.\./) != -1){err="Invalid 'E-mail' address !";done=0;}}
if(done==0){document.getElementById('error').style.display='block';document.getElementById('error').innerHTML=err;return false;}
else{document.getElementById('error').style.display='none';document.getElementById('fgpass').style.display='none';document.getElementById('fgload').style.display='block';return true;}}
function noSpace(e)
{var unicode=e.charCode?e.charCode:e.keyCode;if(unicode!=8){if(unicode==32){return false;}
else{return true;}}
else{return true;}}
function addLoadEvent(func){var oldonload=window.onload;if(typeof window.onload!='function'){window.onload=func;}else{window.onload=function(){oldonload();func();}}}
function vaidateSignIn(txt1,txt2)
{var uid=document.getElementById(txt1).value;var pass=document.getElementById(txt2).value;var done=1;if(uid.trim()==""){document.getElementById(txt1).style.background='#FBBBB9';document.getElementById(txt1).focus();done=0;}
else if(pass.trim()==""){document.getElementById(txt2).style.background='#FBBBB9';document.getElementById(txt2).style.background='#FFF';document.getElementById(txt2).focus();done=0;}
if(done==0){return false;}}
function randomNum()
{var x1=Math.ceil(Math.random()*12)+'';var x2=Math.ceil(Math.random()*20)+'';var tot=parseInt(x1)+parseInt(x2);var str="("+x1+" + "+x2+")";document.getElementById('showcaptcha').innerHTML=str;document.getElementById('hid_captcha').value=tot;document.getElementById('js_captcha').value="";document.getElementById('errorform').innerHTML='';}
function submitForm()
{var url=window.location.href;var contactForm=$(this);var email=document.getElementById('email').value;var message=document.getElementById('message').value;var js_captcha=document.getElementById('js_captcha').value;var hid_captcha=document.getElementById('hid_captcha').value;var sbject=document.getElementById('sbject').value;var done=1;if(email.trim()==""){msg="'E-mail' cannot be blank!";document.getElementById('email').focus();done=0;}
else if(email.trim()!=""){var emailRegEx=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;if(!email.match(emlRegExpRFC) || email.search(/\.\./) != -1){msg="Invalid E-mail!";document.getElementById('email').focus();done=0;}
else{if(message.trim()==""){msg="'Comment' cannot be blank!";document.getElementById('message').focus();done=0;}
else if(js_captcha.trim()==""){msg="'Result' cannot be blank!";document.getElementById('js_captcha').focus();done=0;}
else if(js_captcha.trim()!=hid_captcha.trim()){msg="Incorrect 'Result'!";document.getElementById('js_captcha').focus();done=0;}}}
if(done==0){randomNum();document.getElementById('errorform').style.display='block';document.getElementById('errorform').innerHTML=msg;return false;}
else{$('#sendingMessage').fadeIn();contactForm.fadeOut();var pageurlhome=document.getElementById('pageurlhome').value;pageurlhome=pageurlhome+"users/";$.post(pageurlhome+"feedback",{"email":email,"message":message,"sbject":sbject,"js_captcha":js_captcha,"hid_captcha":hid_captcha},function(response){if(response){submitFinished(response);}
else{submitFinished("success");}});}
return false;}
function submitFinished(response)
{response=$.trim(response);$('#sendingMessage').fadeOut();if(response=="success"){$('#successMessage').fadeIn().delay(2000).fadeOut();$('#senderEmail').val("");$('#message').val("");$('#txt_captcha').val("");randomNum();setTimeout("cover_close('cover','inner_feedback')",2800);}
else if(response=="email_error"){randomNum();$('#emailErrMsg').fadeIn().delay(1000).fadeOut();$('#contactForm').delay(1000).fadeIn();}
else{randomNum();$('#failureMessage').fadeIn().delay(1500).fadeOut();$('#contactForm').delay(1500+500).fadeIn();}}
function randomNumber()
{var x1=Math.ceil(Math.random()*12)+'';var x2=Math.ceil(Math.random()*20)+'';var tot=parseInt(x1)+parseInt(x2);var str="("+x1+" + "+x2+")";document.getElementById('showcaptcha1').innerHTML=str;document.getElementById('hid_captcha1').value=tot;document.getElementById('js_captcha1').value="";document.getElementById('errorform1').innerHTML='';}
$(contactnow);function contactnow()
{$('#contact').hide().submit(submitForm1).addClass('positioned');$('a[href="#contact"]').click(function(){$('#content1').fadeTo('slow',.2);$('#contact').fadeIn('slow',function(){$('#email1').focus();})
return false;});$('#cancel1').click(function(){$('#contact').fadeOut();$('#content1').fadeTo('slow',1);setTimeout("cover_close('cover','inner_feedback1')",500);});$('#close1').click(function(){$('#contact').fadeOut();$('#content1').fadeTo('slow',1);setTimeout("cover_close('cover','inner_feedback1')",500);});}
function submitForm1()
{var contact=$(this);var email=document.getElementById('email1').value;var js_captcha1=document.getElementById('js_captcha1').value;var hid_captcha1=document.getElementById('hid_captcha1').value;var done=1;if(email.trim()==""){msg="'E-mail' cannot be blank!";document.getElementById('email').focus();done=0;}
else if(email.trim()!=""){var emailRegEx=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;if(!email.match(emlRegExpRFC) || email.search(/\.\./) != -1){msg="Invalid E-mail!";document.getElementById('email').focus();done=0;}
else{if(js_captcha1.trim()==""){msg="'Result' cannot be blank!";document.getElementById('js_captcha1').focus();done=0;}
else if(js_captcha1.trim()!=hid_captcha1.trim()){msg="Incorrect 'Result'!";document.getElementById('js_captcha1').focus();done=0;}}}
if(done==0){randomNumber();document.getElementById('errorform1').style.display='block';document.getElementById('errorform1').innerHTML=msg;return false;}
else{$('#sendingMessage1').fadeIn();contact.fadeOut();var pageurlhome1=document.getElementById('pageurlhome').value;pageurlhome1=pageurlhome1+"users/";$.post(pageurlhome1+"contactnow",{"email1":email,"js_captcha1":js_captcha1,"hid_captcha1":hid_captcha1},function(response){if(response){submitFinishednew(response);}
else{submitFinishednew("success");}});}
return false;}
function submitFinishednew(response)
{response=$.trim(response);$('#sendingMessage1').fadeOut();if(response=="success"){$('#successMessage1').fadeIn().delay(2000).fadeOut();$('#email1').val("");$('#txt_captcha1').val("");randomNumber();setTimeout("cover_close('cover','inner_feedback1')",2800);}
else if(response=="email_error"){randomNumber();$('#emailErrMsg1').fadeIn().delay(1000).fadeOut();$('#contact').delay(1000).fadeIn();}
else{randomNumber();$('#failureMessage1').fadeIn().delay(1500).fadeOut();$('#contact').delay(1500+500).fadeIn();}}
function cover_open1(a,b)
{var height=document.body.offsetHeight;if(window.innerHeight){var theHeight=window.innerHeight;}
else if(document.documentElement&&document.documentElement.clientHeight){var theHeight=document.documentElement.clientHeight;}
else if(document.body){var theHeight=document.body.clientHeight;}
if(theHeight>height){var hg1=theHeight;}
else{var hg1=height;}
var newhg=$(document).height();if(newhg>hg1){var hg=newhg+"px";}
else{var hg=hg1+"px";}
document.getElementById(a).style.height=hg;document.getElementById(a).style.display='block';document.getElementById(b).style.display='block';}
function validate(email,span)
{var mailformat=/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;var email=document.getElementById(email).value;if(email=='')
{$("#"+span).html('Please enter your work email.');return false;}
else if(email.trim().match(mailformat))
{return true;}
else
{$("#"+span).html('Please enter your valid work email.');return false;}}
function getCookie(c_name){if(document.cookie.length>0){c_start=document.cookie.indexOf(c_name+"=");if(c_start!=-1){c_start=c_start+c_name.length+1;c_end=document.cookie.indexOf(";",c_start);if(c_end==-1){c_end=document.cookie.length;}
return unescape(document.cookie.substring(c_start,c_end));}}
return"";}
function checkusercuki(){setInterval(function(){if(getCookie('USER_UNIQ')&&getCookie('USERTYP')&&getCookie('USERTZ')){window.top.location.reload();}},1349);}
function createCookie(name,value,days,domain){var expires;if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));expires="; expires="+date.toGMTString();}else
expires="";if(domain)
var domain=" ; domain="+DOMAIN_COOKIE;else
var domain='';document.cookie=name+"="+value+expires+"; path=/"+domain;}
function getCookie(c_name){if(document.cookie.length>0){c_start=document.cookie.indexOf(c_name+"=");if(c_start!=-1){c_start=c_start+c_name.length+1;c_end=document.cookie.indexOf(";",c_start);if(c_end==-1){c_end=document.cookie.length;}
return unescape(document.cookie.substring(c_start,c_end));}}
return"";}
function formatPhone(){jQuery("input[id=phone]").unmask();jQuery("input[id=phone]").mask("(999) 999-9999");jQuery("#txt_ccd").intlTelInput({autoHideDialCode:false,defaultCountry:"us",preferredCountries:["us","gb"]});}
function errorMsg(id){$("#"+id).css({"border":"1px solid #FF0000"});}
function showOthers(obj){var id=$(obj).attr('id');$("#"+id+"_others").val('');if($.trim($("#"+id+" option[value='"+$(obj).val()+"']").text())&&$.trim($("#"+id+" option[value='"+$(obj).val()+"']").text())==="Others"){$("#"+id+"_others_dv").show();$("#"+id+"_other").focus();$("#"+id+"_other").css({border:'none'});}else{$("#"+id+"_others_dv").hide();}}
function validateDownload(){var name=$.trim($("#uname").val());var email=$.trim($("#email").val());var i_am_a=$.trim($("#i_am_a").val());var primary_interest=$.trim($("#primary_interest").val());var industry=$.trim($("#industry").val());var industry_val=$.trim($("#industry option[value='"+industry+"']").text());var error_flag=0;var emailRegEx=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;if(name===""){errorMsg("uname");error_flag=1;}
if(email===""){errorMsg("email");error_flag=1;}else if(email!==""&&!email.match(emlRegExpRFC) || email.search(/\.\./) != -1){errorMsg("email");error_flag=1;}
if(i_am_a===""){errorMsg("i_am_a");error_flag=1;}else if(i_am_a==="Others"){var i_am_a_others=$.trim($("#i_am_a_others").val());if(i_am_a_others===""){errorMsg("i_am_a_others");error_flag=1;}}
if(primary_interest===""){errorMsg("primary_interest");error_flag=1;}else if(primary_interest==="Others"){var primary_interest_others=$.trim($("#primary_interest_others").val());if(primary_interest_others===""){errorMsg("primary_interest_others");error_flag=1;}}
if(industry===""){errorMsg("industry");error_flag=1;}else if(industry!==""&&industry_val==="Others"){var industry_others=$.trim($("#industry_others").val());if(industry_others===""){errorMsg("industry_others");error_flag=1;}}
if(error_flag){return false;}else{free_download();}}
function free_download(){var name=$.trim($("#uname").val());var email=$.trim($("#email").val());var i_am_a=$.trim($("#i_am_a").val());if(i_am_a==="Others"){i_am_a=$.trim($("#i_am_a_others").val());}
var primary_interest=$.trim($("#primary_interest").val());if(primary_interest==="Others"){primary_interest=$.trim($("#primary_interest_others").val());}
var industry=$.trim($("#industry").val());var industry_val=$.trim($("#industry option[value='"+industry+"']").text());var new_industry="";if(industry_val==="Others"){new_industry=$.trim($("#industry_others").val());}
var version='1.0';var visitortime=new Date();var visitortimezone=-visitortime.getTimezoneOffset()/60;$('#gmt_offset').val(visitortimezone);var gmt_offset=$('#gmt_offset').val();$("#submit_button").hide();$("#submit_loader").show();var strURL=$("#pageurl").val();$.post(strURL+"opensource/free_download",{"name":name,"email":email,"i_am_a":i_am_a,"primary_interest":primary_interest,"industry_id":industry,"new_industry":new_industry,"version":version,"gmt_offset":gmt_offset,"is_download":1},function(res){if(parseInt(res)){$.getScript("http://w.sharethis.com/button/buttons.js",function(){stLight.options({publisher:"39f31a06-8166-451a-8c9c-6a2c0e14e464",doNotHash:false,doNotCopy:false,hashAddressBar:false});});$("#dwnld_frm").hide();$("#thnxmsg").html("Please check your Email <span style='font-weight:bold;'>"+email+"</span>, for a download link and installation manual.");$("#thanx_msg").show();$("#tweet_thanx_msg").hide();$("#frm_thanx_msg").show();$("#right_download").hide();$("#top_download").hide();$("#left_download").css({"width":'100%'});jQuery('html, body').animate({scrollTop:jQuery("#thanx_msg").offset().top-230},1000);}else{showTopErrSucc('error',"Error in request to Download Orangescrum Community Edition.");}
$("#submit_loader").hide();$("#submit_button").show();});}
function free_download_tweet(){var name="";var email="";var i_am_a="";var primary_interest="";var industry=0;var version='1.0';var visitortime=new Date();var visitortimezone=-visitortime.getTimezoneOffset()/60;var gmt_offset=visitortimezone;var strURL=$("#pageurl").val();$.post(strURL+"opensource/free_download",{"name":name,"email":email,"i_am_a":i_am_a,"primary_interest":primary_interest,"industry_id":industry,"version":version,"gmt_offset":gmt_offset,"is_download":1,"is_tweet":1},function(res){if(parseInt(res)!==0){$.getScript("http://w.sharethis.com/button/buttons.js",function(){stLight.options({publisher:"39f31a06-8166-451a-8c9c-6a2c0e14e464",doNotHash:false,doNotCopy:false,hashAddressBar:false});});$("#tweetshre").hide();$("#dwnld_frm").hide();$("#tweet_thnxmsg").html("Please click the link below to start downloading.<br/><a href="+strURL+"free-download/"+res+" style='color: blue;' target='_blank'>Download Orangescrum Community Edition</a>");$("#thanx_msg").show();$("#frm_thanx_msg").hide();$("#tweet_thanx_msg").show();jQuery('html, body').animate({scrollTop:jQuery("#thanx_msg").offset().top-230},1000);}});}
function closePopup(){$(".popup_overlay").css({display:"none"});$(".popup_bg,.popup_bgs").css({display:"none"});$(".sml_popup_bg").css({display:"none"});$(".cmn_popup").hide();}
function openpopup(){$(".popup_overlay").css({display:"block"});if(arguments[0]=="faq"){$(".popup_bgs").css({display:"block","width":'577px'});$('html, body').animate({scrollTop:$(".popup_bgs").offset().top-200},1000);}else{$(".popup_bg").css({display:"block","width":'577px'});$('html, body').animate({scrollTop:$(".popup_bg").offset().top-200},1000);}
$(".popup_form").css({"margin-top":"20px"});$(".loader_dv").show();$(".loader_dv").hide();}
function awshosting(){openpopup();$(".new_aws").show();}
function showCommunity(){var input=arguments[0];var addon='';if(typeof input!='undefined'){addon=input;}
var input_order=arguments[1];var order='';if(typeof order!='undefined'){order=input_order;}
$('#addon_label').hide();$('#addon_address').html('Description');$('#description').attr('placeholder','Description');$('.addon_btn').text('Submit');$('#popup_main_title').html('On-Premises Installation & Support');$('#popup_addon_title').html('We will set up Orangescrum on your domain.');$('#addon_name').val('');$('.support_label').html('Support Type:');$('#support_type').show();$('#support_type').find('option:contains("Add-ons")').attr("selected",false);if(order!=''){$('#support_type option').removeAttr('selected');$('#support_type option:eq('+order+')').attr('selected','selected');}
if(addon!=''){$('#addon_name').val(addon);$('#popup_main_title').html('Request to purchase '+addon+' Add-on');$('#popup_addon_title').html('Please fill out the following information.');$('#addon_address').html('Address');$('#description').attr('placeholder','Enter your address');$('#support_type').hide();$('#support_type').find('option:contains("Add-ons")').attr("selected",true);$('#addon_label').show();$('#addon_namesp').html(addon);$('.addon_btn').text('Submit');$('.support_label').html('Add-on:');}
openpopup();$('#community')[0].reset();$("#thnxmsg").html("").hide();$(".new_community").show();$("#inner_community").show();$("#uname").focus();$("#industry_others_dv").hide();formatPhone();}
function validateCommunity(){var name=$.trim($("#uname").val());var email=$.trim($("#email").val());var phone=$.trim($("#phone").val());var industry=$.trim($("#industry").val());var industry_val=$.trim($("#industry option[value='"+industry+"']").text());var support_type=$.trim($("#support_type").val());var description=$.trim($("#description").val());var error_flag=0;var emailRegEx=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;if(name===""){errorMsg("uname");error_flag=1;}
if(email===""){errorMsg("email");error_flag=1;}else if(email!==""&&!email.match(emlRegExpRFC) || email.search(/\.\./) != -1){errorMsg("email");error_flag=1;}
if(phone===""){errorMsg("phone");error_flag=1;}
if(industry===""){errorMsg("industry");error_flag=1;}else if(industry!==""&&industry_val==="Others"){var industry_others=$.trim($("#industry_others").val());if(industry_others===""){errorMsg("industry_others");error_flag=1;}}
if(support_type===""){errorMsg("support_type");error_flag=1;}
if(description===""){errorMsg("description");error_flag=1;}
if(error_flag){return false;}else{community();}}
function community(){var name=$.trim($("#uname").val());var email=$.trim($("#email").val());var phone=$('#txt_ccd').val()+" "+$.trim($("#phone").val());var industry=$.trim($("#industry").val());var industry_val=$.trim($("#industry option[value='"+industry+"']").text());var new_industry="";if(industry_val==="Others"){new_industry=$.trim($("#industry_others").val());}
var support_type=$.trim($("#support_type").val());var description=$.trim($("#description").val());var addon_name=$.trim($("#addon_name").val());var visitortime=new Date();var visitortimezone=-visitortime.getTimezoneOffset()/60;$('#gmt_offset').val(visitortimezone);var gmt_offset=$('#gmt_offset').val();$("#submit_button").hide();$("#submit_loader").show();var strURL=$("#pageurl").val();$.post(strURL+"opensource/community",{"addon_name":addon_name,"name":name,"email":email,"phone":phone,"industry_id":industry,"new_industry":new_industry,"description":description,"support_type":support_type,"gmt_offset":gmt_offset,"is_community":1},function(res){if(parseInt(res)){$("#inner_community").hide();if(support_type=='Add-ons'){$("#thnxmsg").html("Thank you for ordering "+addon_name+" Add-on.<br /><span style='color:#666666'>Please check your Email <b style='color:#5191BD'>"+email+"</b>, for more detail.</span>").show();}else{var ochk=support_type.indexOf("Support:");if(ochk!='-1'){$("#thnxmsg").html("Thank you for ordering On-Premises Installation & Support").show();}else{$("#thnxmsg").html("Thank you for joining Orangescrum Community").show();}}}
$("#submit_loader").hide();$("#submit_button").show();});}
function showfaqContactForm(){var input=arguments[0];var par="";var page=arguments[1];$('#submit_loaders').hide();$("#unames").val('');$("#emails").val('');$("#plans").val('');/*$("#plans").val(0);*/openpopup('faq');$("#thnxmsgs").html("").hide();$(".new_communities").show();$("#inner_communities").show();$("#unames").focus();$(".textbox").css({"border":"1px solid #AAAAAA"});$(".textareabox").css({"border":"1px solid #AAAAAA"});}
function validatefaqform(){var name=$.trim($("#unames").val());var email=$.trim($("#emails").val());var enviroment=$.trim($("#plans").val());var description=$.trim($("#descriptions").val());var error_flag=0;var emailRegEx=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;if(name===""){errorMsg("unames");error_flag=1;}
if(email===""){errorMsg("emails");error_flag=1;}else if(email!==""&&!email.match(emlRegExpRFC) || email.search(/\.\./) != -1){errorMsg("emails");error_flag=1;}
if(enviroment==="" || enviroment==0){errorMsg("plans");error_flag=1;}
if(error_flag){return false;}else{send_faq_contact();}}
function send_faq_contact(){var name=$.trim($("#unames").val());var email=$.trim($("#emails").val());var addon_name=$.trim($("#addon_names").val());var environment=$.trim($("#plans").val());var description=$.trim($("#descriptions").val());var visitortime=new Date();var visitortimezone=-visitortime.getTimezoneOffset()/60;$('#gmt_offset').val(visitortimezone);var gmt_offset=$('#gmt_offset').val();var sprt_type=$('#sprt_type').val();$("#submit_buttons").hide();$("#submit_loaders").show();var strURL=$("#pageurl").val();$.post(strURL+"users/contact_faq",{"name":name,"email":email,"plans":environment,"description":description,"gmt_offset":gmt_offset,"is_community":1},function(res){if(parseInt(res)){if(environment.indexOf('Users') > -1){$("#thnxmsgs").html("Thank you for submitting your request for Orangescrum Self Hosted Plan").show();}else{$("#thnxmsgs").html("Thank you for submitting your request for Orangescrum Annual Plan").show();}$("#inner_communities").hide();$("#submit_loaders").hide();$("#submit_buttons").show();}});}