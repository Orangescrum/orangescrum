<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Email</title>
	<style>
		@media only screen and (max-width: 650px) {
			.container{width:95% !important;max-width:100% !important;padding:0 !important;}
		}
	</style>
  </head>
  <body style="background-color:#f6f6f6;-webkit-font-smoothing: antialiased;font-size:14px;line-height:20px;margin:0;padding:0; -ms-text-size-adjust: 100%;-webkit-text-size-adjust:100%;">
	<table border="0" cellpadding="0" cellspacing="0" border="0" style="height:auto ;margin:0;padding:0;width:100%;background-color:#fff;color:#222;font-family:Arial, Helvetica, sans-serif;font-size:14px;line-height:20px;font-weight:normal;">
      <tr>
        <td class="container" style="display:block;Margin:0 auto;max-width:580px;padding:30px;width:580px;background:#F3F3F3">
          <table border="0" cellpadding="0" cellspacing="0" border="0" style="background:#fff;width:100%;margin:0;padding:0;">
			<tr>
				<td style="padding:10px">
					<a href="https://www.orangescrum.com/" target="_blank" style="text-decoration:none;width:200px;">
						<img src="https://www.orangescrum.com/img/header/orangescrum-cloud-logo.svg" alt="#1 Productivity Tool" title="#1 Productivity Tool" width="142" height="42" style="max-width:100%">
					</a>
				</td>
			</tr>
			<tr>
				<td>
					<div style="width:100%;height:145px">
						<img src="https://www.orangescrum.com/images/banner-1.png" alt="banner" width="" height="" style="max-width:100%;width:100%;height:100%">
					</div>
				</td>
			</tr>
			<tr>
				<td style="text-align:center;padding-bottom:40px">
					<h1 style="margin:20px 0;font-size:30px;line-height:30px;color:#333;font-weight:500">Email Confirmation</h1>
					<p style="font-size:14px;line-height:22px;margin:0;">
						Hey <?php echo $usrname; ?>, You're almost ready to start enjoying Orangescrum.<br>
						Simply click the big orange button below to verify your <br>mail address.
					</p>
					<a href="<?php echo $activation_url;?>" target="_blank" style="display:inline-block;margin:20px 0;padding:10px 20px;text-decoration:none;font-size:14px;color:#fff;text-align:center;background:#FF7E00;text-transform:capitalize;border-radius:5px">verify email address</a>
					<h6 style="margin:15px 0 40px;font-size:18px;color:#777;font-weight:500;">Get the Orangescrum app</h6>
					<a href="https://play.google.com/store/apps/details?id=com.andolasoft.orangescrum&hl=en" target="_blank" style="display:inline-block;text-decoration:none;width:156px;height:52px;margin:0 10px 10px">
						<img src="https://www.orangescrum.com/images/google-play.png" alt="Google play" width="" height="" style="max-width:100%;width:100%;height:100%">
					</a>
					<a href="https://itunes.apple.com/ph/app/id1132539893" target="_blank" style="display:inline-block;text-decoration:none;width:156px;height:52px;margin:0 10px 10px">
						<img src="https://www.orangescrum.com/images/app-store.png" alt="App Store" width="" height="" style="max-width:100%;width:100%;height:100%">
					</a>
				</td>
			</tr>
          </table>
		  <table border="0" cellpadding="0" cellspacing="0" border="0" style="width:100%;margin:0;padding:0;">
			<tr>
				<td style="text-align:center;padding:20px 0">
					<div style="font-size:25px;line-height:30px;color:#333;font-family:Segoe Print;margin-bottom:20px;">Stay in touch</div>
					<a href="https://in.linkedin.com/" target="_blank" style="text-decoration:none;display:inline-block;vertical-align:middle;margin:0 5px;">
						<img src="https://www.orangescrum.com/images/linkdin.png" alt="linkdin" width="" height="" style="max-width:100%;">
					</a>
					<a href="https://twitter.com/login" target="_blank" style="text-decoration:none;display:inline-block;vertical-align:middle;margin:0 5px;">
						<img src="https://www.orangescrum.com/images/tweeter.png" alt="tweeter" width="" height="" style="max-width:100%;">
					</a>
					<a href="www.facebook.com" target="_blank" style="text-decoration:none;display:inline-block;vertical-align:middle;margin:0 5px;">
						<img src="https://www.orangescrum.com/images/facebook.png" alt="facebook" width="" height="" style="max-width:100%;">
					</a>
					<a href="https://plus.google.com/" target="_blank" style="text-decoration:none;display:inline-block;vertical-align:middle;margin:0 5px;">
						<img src="https://www.orangescrum.com/images/g-plus.png" alt="Google plus" width="" height="" style="max-width:100%;">
					</a>
					<a href="https://in.pinterest.com/" target="_blank" style="text-decoration:none;display:inline-block;vertical-align:middle;margin:0 5px;">
						<img src="https://www.orangescrum.com/images/print.png" alt="Pinterest" width="" height="" style="max-width:100%">
					</a>
				</td>
			</tr>
			<tr>
				<td style="text-align:center">
					<p style="font-size:12px;line-height:20px;color:#555;margin:5px 0 0">
						<?php echo __("You received this message because you are a Orangescrum customer. If you would prefer not to receive these emails in the future, you can");?> <a href='<?php echo $user_unsub_link; ?>'><?php echo __("unsubscribe");?></a><?php echo __("at any time.");?>
					</p>
					<p style="font-size:12px;line-height:20px;color:#555;margin:5px 0 0"><?php echo __("Email sent by Orangescrum");?><br><?php echo __("&copy; 2017 Orangescrum 2059 Camden, Ave, #118 San Jose, CA");?></p>
				</td>
			</tr>
		  </table>
        </td>
      </tr>
    </table>
  </body>
</html>
