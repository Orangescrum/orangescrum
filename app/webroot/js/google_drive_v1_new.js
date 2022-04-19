var OAUTHURL = 'https://accounts.google.com/o/oauth2/auth?';
		var SCOPE = 'https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/drive.file';
		var TYPE = 'code';
		var _url = OAUTHURL + 'scope=' + SCOPE + '&client_id=' + CLIENT_ID + '&redirect_uri=' + REDIRECT + '&response_type=' + TYPE + '&approval_prompt=force&access_type=offline&state=gdrive';
		
		//console.log(_url);

		var pickerApiLoaded = false;
		var oauthToken;

		var pollTimer;
		var caseId, caseDpId;
		function googleConnect(arg, is_basic_or_free) {
						caseId = arg;
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
						.setDeveloperKey(API_KEY)
						.setCallback(pickerCallback)
						.build();
				 picker.setVisible(true);
			}
		}

	// A simple callback implementation.
	function pickerCallback(data) {
		//console.log(data);
		if (data.action == google.picker.Action.PICKED) {
			var fileId = data.docs[0].id;
			//alert('The user selected: ' + fileId);		
			if(data.docs.length > 0){
				$.each(data.docs, function( index, file ) {
					if (file.id != undefined) {
						var content = '{"id":"' + file.id + '","title":"' + file.name + '","alternateLink":"' + file.url + '"';
						if (file.embedUrl != undefined) {
								content = content + ',"embedLink":"' + file.embedUrl + '"';
						}
						if (file.parents != undefined && file.parents.length > 0) {
								content = content + ',"parent_id":"' + file.parents['0'].id + '"';
						}
						content = content + '}';
						var shortTitle, title;
						title = shortTitle = file.name;
						if (title.length > 70)
								shortTitle = jQuery.trim(title).substring(0, 67).split(" ").slice(0, -1).join(" ") + "...";

						var str = "<div id='gd_" + caseId + file.id + "'><div style='float:left;margin-top:2px;'><input id='chkbx_" + caseId + file.id + "' type='checkbox' checked='checked' onclick='removeLink(\"" + file.id + "\",\"" + file.name + "\");' style='cursor: pointer;' /></div><div style='float:left;margin-left: 6px;margin-top:4px; font-size: 14px;'><a href='" + file.url + "' target='_blank' title='" + file.name + "'>" + shortTitle + "</a><input type='hidden' name='data[Easycase][cloud_storage_files][]' value='" + content + "' /></div><div style='clear:both;'></div></div>";
						$("#drive_tr_" + caseId).show();

						if ($("#gd_" + caseId + file.id).length === 0)
								$("#cloud_storage_files_" + caseId).append(str);
					} else {
						var message = file.message;
						message = message.split(":");
						if (message['0'] == 'File not found') {
								alert(fileName + ": This file has no read permission.");
						} else {
								alert(fileName + ": " + message['0']);
						}
					}
				});
			}
		}
	}

function removeLink(id, title) {
    if (confirm("Are you sure you want to remove '" + title + "' file ?")) {
        $("#gd_" + caseId + id).remove();
    } else {
        $("#chkbx_" + caseId + id).attr("checked", "checked");
    }
}


//Dropbox starts.
function connectDropbox(arg, is_basic_or_free) {
    /*if (parseInt(is_basic_or_free) && DEFAULT_PAID != '5303' && DEFAULT_PAID != '8728' && DEFAULT_PAID != '10812' && DEFAULT_PAID != '15602' && DEFAULT_PAID !='14455' && DEFAULT_PAID !='17945' && DEFAULT_PAID !='20414') {
        alert("Upgrade your plan to attach files from Dropbox\r\nPlan starts at $9/month");
        return false;
    } else {*/
        caseDpId = arg;
        Dropbox.choose(options);
    //}
}
var options = {
    success: function (files) {
        var name, shortName, link, strlink, id, index, str, content;
        $("#drive_tr_" + caseDpId).show();
        for (var i in files) {
            console.log(files[i]);
            name = shortName = files[i].name;
            link = files[i].link;

            //Getting id.
            strlink = link.substring(0, link.lastIndexOf("/"));
            id = strlink.substring(strlink.lastIndexOf('/') + 1);

            content = '{"id":"' + id + '","title":"' + name + '","alternateLink":"' + link + '"}';
            if (name.length > 70)
                shortName = jQuery.trim(name).substring(0, 67).split(" ").slice(0, -1).join(" ") + "...";

            str = "<div id='dpbx_" + caseDpId + id + "'><div style='float:left;margin-top:2px;'><input id='dpchkbx_" + caseDpId + id + "' type='checkbox' checked='checked' onclick='removeDBLink(\"" + id + "\",\"" + name + "\");' style='cursor: pointer;' /></div><div style='float:left;margin-left: 6px;margin-top:4px; font-size: 14px;'><a href='" + link + "' target='_blank' title='" + name + "'>" + shortName + "</a><input type='hidden' name='data[Easycase][cloud_storage_files][]' value='" + content + "' /></div><div style='clear:both;'></div></div>";
            if ($("#dpbx_" + caseDpId + id).length === 0)
                $("#cloud_storage_files_" + caseDpId).append(str);
        }
    },
    cancel: function () {
        console.log("User cancel the prompt...");
    },
    linkType: "preview", //direct
    multiselect: true//false
            //extensions: ['.pdf', '.doc', '.docx'],
};

function removeDBLink(id, title) {
    if (confirm("Are you sure you want to remove '" + title + "' file ?")) {
        $("#dpbx_" + caseDpId + id).remove();
    } else {
        $("#dpchkbx_" + caseDpId + id).attr("checked", "checked");
    }
}
//Dropbox ends.
