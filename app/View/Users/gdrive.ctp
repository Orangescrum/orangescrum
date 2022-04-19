    <script type="text/javascript">
		
		function createCookie(name,value,days,domain){var expires;if(days){var date=new Date();date.setTime(date.getTime()+(days*24*60*60*1000));expires="; expires="+date.toGMTString();}else
		expires="";if(domain)
		var domain=" ; domain="+DOMAIN_COOKIE;else
		var domain='';document.cookie=name+"="+value+expires+"; path=/"+domain;}
		
		function getCookie(c_name){if(document.cookie.length>0){c_start=document.cookie.indexOf(c_name+"=");if(c_start!=-1){c_start=c_start+c_name.length+1;c_end=document.cookie.indexOf(";",c_start);if(c_end==-1){c_end=document.cookie.length;}
		return unescape(document.cookie.substring(c_start,c_end));}}else{return"";}}
		
    // The Browser API key obtained from the Google API Console.
    // Replace with your own Browser API key, or your own key.
    var developerKey = "<?php echo API_KEY; ?>";

    // The Client ID obtained from the Google API Console. Replace with your own Client ID.
    var clientId = "<?php echo CLIENT_ID;?>"
    var CLIENT_ID = "<?php echo CLIENT_ID;?>"

    // Replace with your own project number from console.developers.google.com.
    // See "Project number" under "IAM & Admin" > "Settings"
    var appId = "<?php echo CLIENT_ID_NUM; ?>";
    var REDIRECT = "<?php echo REDIRECT_URI; ?>";

    // Scope to use to access user's Drive items.
    //var scope = ['https://www.googleapis.com/auth/drive.file'];

    /*var pickerApiLoaded = false;
    var oauthToken;

    // Use the Google API Loader script to load the google.picker script.
    function loadPicker() {
      gapi.load('auth', {'callback': onAuthApiLoad});
      gapi.load('picker', {'callback': onPickerApiLoad});
    }

    function onAuthApiLoad() {
      window.gapi.auth.authorize(
          {
            'client_id': clientId,
            'scope': scope,
            'immediate': false
          },
          handleAuthResult);
    }

    function onPickerApiLoad() {
      pickerApiLoaded = true;
      createPicker();
    }

    function handleAuthResult(authResult) {
      if (authResult && !authResult.error) {
        oauthToken = authResult.access_token;
        createPicker();
      }
    }

    // Create and render a Picker object for searching images.
    function createPicker() {
      if (pickerApiLoaded && oauthToken) {
        var view = new google.picker.View(google.picker.ViewId.DOCS);
        view.setMimeTypes("image/png,image/jpeg,image/jpg");
        var picker = new google.picker.PickerBuilder()
            .enableFeature(google.picker.Feature.NAV_HIDDEN)
            .enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
            .setAppId(appId)
            .setOAuthToken(oauthToken)
            .addView(view)
            .addView(new google.picker.DocsUploadView())
            .setDeveloperKey(developerKey)
            .setCallback(pickerCallback)
            .build();
         picker.setVisible(true);
      }
    }

    // A simple callback implementation.
    function pickerCallback(data) {
      if (data.action == google.picker.Action.PICKED) {
        var fileId = data.docs[0].id;
        alert('The user selected: ' + fileId);
      }
    }*/
		
		var OAUTHURL = 'https://accounts.google.com/o/oauth2/auth?';
		var SCOPE = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/drive.file';
		var TYPE = 'code';
		var _url = OAUTHURL + 'scope=' + SCOPE + '&client_id=' + CLIENT_ID + '&redirect_uri=' + REDIRECT + '&response_type=' + TYPE + '&approval_prompt=force&access_type=offline&state=gdrive';
		
		//alert(_url);
		console.log('--here in ---');

		var pickerApiLoaded = false;
		var oauthToken;

		var pollTimer;
		var caseId, caseDpId;
		function googleDriveConnect() {
						console.log(_url);
						createCookie("google_accessToken", '', -365, DOMAIN_COOKIE);
						window.open(_url, "windowname1", 'width=600, height=600');
						if (pollTimer) {
								window.clearInterval(pollTimer);
						}
						pollTimer = window.setInterval(function () {
								try {
										if (getCookie('google_accessToken')) {
												window.clearInterval(pollTimer);
												try {
														var google_accessToken = getCookie('google_accessToken');
														createCookie("google_accessToken", '', -365, DOMAIN_COOKIE);
														oauthToken = JSON.parse(google_accessToken).access_token;
												} catch (e) {
														return;
												}
												//gapi.load('auth', {'callback': onAuthApiLoad});
												gapi.load('picker', {'callback': onPickerApiLoad});
										}
								} catch (e) {
								}
						}, 500);
				//}
		}

		function onPickerApiLoad() {
			pickerApiLoaded = true;
			createPicker();
		}
		// Create and render a Picker object for searching images.
		function createPicker() {
			if (pickerApiLoaded && oauthToken) {
				var view = new google.picker.View(google.picker.ViewId.DOCS);
				//view.setMimeTypes("image/png,image/jpeg,image/jpg");
				var picker = new google.picker.PickerBuilder()
						.enableFeature(google.picker.Feature.NAV_HIDDEN)
						.enableFeature(google.picker.Feature.MULTISELECT_ENABLED)
						.setAppId(appId)
						.setOAuthToken(oauthToken)
						.addView(view)
						.addView(new google.picker.DocsUploadView())
						.setDeveloperKey(developerKey)
						.setCallback(pickerCallback)
						.build();
				 picker.setVisible(true);
			}
		}

		// A simple callback implementation.
		function pickerCallback(data) {
			console.log(data);
			if (data.action == google.picker.Action.PICKED) {
				var fileId = data.docs[0].id;
				if(data.docs.length > 0){
					$.each(data.docs, function( index, file ) {
						console.log(index);
						console.log(file);
					});
				}
			}
		}
		
    </script>
		
    	
    <div id="result"></div>
		
		<button type="button" onclick="googleDriveConnect();">Load Gdrive</button>

    <!-- The Google API Loader script. -->
    <?php /*<script type="text/javascript" src="https://apis.google.com/js/api.js?onload=loadPicker"></script>*/ ?>
    <script type="text/javascript" src="https://apis.google.com/js/api.js"></script>