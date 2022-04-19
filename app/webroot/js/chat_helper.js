var chat_client_group;
$(document).ready(function() {
    setInterval(function() {
        showOnlines();
    }, 1800000);
    if (typeof localStorage.CHATOPEN != 'undefined' && localStorage.CHATOPEN == 1) {
        if (typeof localStorage.LASTCHAT != 'undefined') {
            if (typeof localStorage.LASTCHAT != '' && localStorage.LASTCHAT != '' && localStorage.LASTCHAT.indexOf('group') != -1) {
                arr = {
                    "chat_group_id": localStorage.LASTCHAT.replace("group-", "")
                };
            } else if (typeof localStorage.LASTCHAT != '' && localStorage.LASTCHAT != '' && localStorage.LASTCHAT.indexOf('user') != -1) {
                arr = {
                    "user_id": localStorage.LASTCHAT.replace("user-", "")
                };
            }
        } else {
            arr = {};
        }
        chatStart(arr, 1);
    }
});
function chatStart($arr) {
    getLastActivity();
    if ($('.chat_loading').length <= 0) {
        $(".chat_btn_btm").find("a").html('<i class="material-icons chat_loading">&#xE863;</i>');
        var dialogOptions = {
            "title": "",
            "width": 900,
            "height": 550,
            "modal": false,
            "resizable": true,
            "draggable": true,
            "create": function(event) {
                $(event.target).parent().css({
                    'position': 'fixed'
                });
								$(event.target).parent().addClass('inapp_chat_layout');
            },
            "close": function() {
                $(".chat_btn_btm").show();
                localStorage.removeItem('CHATOPEN');
                //localStorage.removeItem('LASTCHAT');
                $(this).remove();
            },
            open: function() {
                showOnlines();
            },
            show: {
                effect: 'slide',
                complete: function() {
                    console.log('animation complete');
                }
            }
        };
        var dialogExtendOptions = {
            "closable": true,
            "minimizable": true,
						"maximizable": true,
            "minimizeLocation": 'right' || false,
            "collapsable": false,
            "dblclick": 'minimize' || false,
            "titlebar": '' || false
        };
        var chat_alive = (typeof arguments[1] != 'undefined') ? arguments[1] : 0;
        $.post(HTTP_ROOT + "chat", {}, function(res) {
            if (chat_alive == 1) {
                $("<div id='chatContainer'/>").dialog(dialogOptions).dialogExtend(dialogExtendOptions);
                $("#chatContainer").dialogExtend("minimize");
            } else {
                $("<div id='chatContainer'/>").dialog(dialogOptions).dialogExtend(dialogExtendOptions);
            }
            $("#chatContainer").parent().css("position", "fixed");
            $("#chatContainer").html(res);
            $(".chat_btn_btm").find("a").html('<i class="material-icons">&#xE0B7;</i>');
            $(".chat_btn_btm").hide();
            localStorage.setItem('CHATOPEN', 1);
            if (typeof $arr != 'undefined') {
                refreshChatList($arr);
            }else if(typeof localStorage.LASTCHAT != 'undefined' && localStorage.LASTCHAT != '' ){
                if(localStorage.LASTCHAT.indexOf('group') != -1){
                    refreshChatList({"chat_group_id": localStorage.LASTCHAT.replace("group-", "")});
                    showAllChatUser('group',$(".userTabs").eq(2));
                }else if(localStorage.LASTCHAT.indexOf('user') != -1){
                    refreshChatList({"user_id": localStorage.LASTCHAT.replace("user-", "")});
                }
            }

        });
    }
}
function showChat($arr) {
    if (typeof $arr['Oschat']['chat_group_id'] != 'undefined' && $arr['Oschat']['chat_group_id'] != '' && $arr['Oschat']['chat_group_id'] != 0) {
        localStorage.setItem('LASTCHAT', 'group-' + $arr['Oschat']['chat_group_id']);
        subscribeToGroup($arr['Oschat']['chat_group_id']);
    } else {
        localStorage.setItem('LASTCHAT', 'user-' + $arr['Oschat']['user_id']);
    }
    if ($("#chatBox").length <= 0) {
        chatStart($arr['Oschat']);
    } else {
        if ($arr['Oschat']['chat_group_id']) {
            console.log($arr);
            $("#chatReceiver").val($arr['Oschat']['group_receiver_id']);
            getReadyChat();
            if ($("#og" + $arr['Oschat']['chat_group_id']).length <= 0) {
                var groupRow = '<li id="og' + $arr['Oschat']['chat_group_id'] + '" data-user="' + $arr['Oschat']['user_id'] + '" data-name="' + $arr['Oschat']['chat_group_name'] + '" data-val="' + $arr['Oschat']['group_receiver_id'] + '"><div class="online_avil_user"><a href="javascript:void(0);" onclick="chatWithGroup(\'' + $arr['Oschat']['chat_group_id'] + '\');" title="' + $arr['Oschat']['chat_group_name'] + '">';
                groupRow += '<span class="cmn-pf-img  project-icon"></span></a></div><div class="username_type">';
                groupRow += '<p class="inlineeditgrouphide" ><a href="javascript:void(0);" onclick="chatWithGroup(\'' + $arr['Oschat']['chat_group_id'] + '\');" title="' + $arr['Oschat']['chat_group_name'] + '" rel="tooltip" class="chatWith" >' + $arr['Oschat']['chat_group_name'] + '</a></p>';
                groupRow += '<div style="display:none;" class="groupInputBox"><input type="text" value="' + $arr['Oschat']['chat_group_name'] + '" id="groupInput' + $arr['Oschat']['chat_group_id'] + '"><button class="editGroup" onclick="updateGroup(' + $arr['Oschat']['chat_group_id'] + ')"><i class="material-icons">&#xE876;</i></button></div></div>';
                groupRow += '<span class="round-notification groupChatCount' + $arr['Oschat']['chat_group_id'] + '" style="display:block;">1</span><div class="cb"></div>';
                if ($arr['Oschat']['user_id'] == SES_ID) {
                    groupRow += '<div class="editChatGroup"><a href="javascript:void(0);" onclick="editGroupTitle(' + $arr['Oschat']['chat_group_id'] + ')"><i class="material-icons">&#xE254;</i></a>';
                    groupRow += '<a href="javascript:void(0);" onclick="deleteGroupTitle(' + $arr['Oschat']['chat_group_id'] + ')"><i class="material-icons">&#xE92B;</i></a></div>';
                }
                groupRow += '</li>';

                $(".online-group ul").prepend(groupRow);
                gcount = (isNaN(parseInt($(".groupsMessagenotify").html()))) ? 0 : parseInt($(".groupsMessagenotify").html());
                $(".groupsMessagenotify").css('display', 'inline-block').html(++gcount);
            } else {
                if ($arr['Oschat']['chat_group_id'] == $("#chatGroup").val() && $arr['Oschat']['group_receiver_id'].split(",").indexOf(SES_ID) !== -1) {
                    refreshChatListRecord($arr['Oschat']);
                } else {
                    if ($arr['Oschat']['group_receiver_id'].split(",").indexOf(SES_ID) !== -1) {
                        count = (isNaN(parseInt($(".groupChatCount" + $arr['Oschat']['chat_group_id']).html()))) ? 0 : parseInt($(".groupChatCount" + $arr['Oschat']['chat_group_id']).html())
                        $(".groupChatCount" + $arr['Oschat']['chat_group_id']).show().html(++count);
                        gcount = (isNaN(parseInt($(".groupsMessagenotify").html()))) ? 0 : parseInt($(".groupsMessagenotify").html());
                        $(".groupsMessagenotify").css('display', 'inline-block').html(++gcount);
                        $title = $(".all-" + $arr['Oschat']['user_id']).find(".chatUserNameMenu").html();
                        notifyChat($title, $arr['Oschat']['message']);
                    }
                }
            }
            if (!$("#chatContainer").is(":visible")) {
                count1 = (isNaN(parseInt($(".chat-count-min").html()))) ? 0 : parseInt($(".chat-count-min").html());
                $(".chat-count-min").show().html(++count1);
                if (count1) {
                    $title = $(".all-" + $arr['Oschat']['user_id']).find(".chatUserNameMenu").html();
                    notifyChat($title, $arr['Oschat']['message']);
                }
            }
        } else if ($arr['Oschat']['user_id'] != $("#chatReceiver").val()) {
            count = (isNaN(parseInt($(".userChatCount" + $arr['Oschat']['user_id']).html()))) ? 0 : parseInt($(".userChatCount" + $arr['Oschat']['user_id']).html());
            $(".userChatCount" + $arr['Oschat']['user_id']).show().html(++count);
            ucount = (isNaN(parseInt($(".usersMessagenotify").html()))) ? 0 : parseInt($(".usersMessagenotify").html());
            $(".usersMessagenotify").css('display', 'inline-block').html(++ucount);
            $title = $(".all-" + $arr['Oschat']['user_id']).find(".chatUserNameMenu").html();
            notifyChat($title, $arr['Oschat']['message']);
        } else {
            refreshChatListRecord($arr['Oschat']);
        }
        if (!$("#chatContainer").is(":visible")) {
            count1 = (isNaN(parseInt($(".chat-count-min").html()))) ? 0 : parseInt($(".chat-count-min").html());
            $(".chat-count-min").show().html(++count1);
            if (count1) {
                $title = $(".all-" + $arr['Oschat']['user_id']).find(".chatUserNameMenu").html();
                notifyChat($title, $arr['Oschat']['message']);
            }
        }
    }
    u_id = (typeof $arr['Oschat']['chat_group_id'] != 'undefined' && $arr['Oschat']['chat_group_id'] != '' && $arr['Oschat']['chat_group_id'] != 0) ? "g" + $arr['Oschat']['chat_group_id'] : "u" + $arr['Oschat']['user_id'];
    addtorecent(u_id);
}
function showOnlines(ids) {
    $.post(HTTP_ROOT + "chats/getOnlineUser", {
        ids: ids
    }, function(res) {
        $(".onlineChatUser").hide();
        $(".onlineChatUser").each(function() {
            if (typeof res[$(this).attr('data-val')] != 'undefined') {
                $(".onlineChatUser" + $(this).attr('data-val')).show();
                $(".lastLoginInfo" + $(this).attr('data-val')).html('').hide();
            } else {
                $(".onlineChatUser" + $(this).attr('data-val')).hide();
            }
        });
    }, 'json');
}
function addtorecent(id) {
    type = (id.indexOf("u") != -1) ? "user" : "group";
    ugid = id.substring(1);
    if (type == "user") {
        $(".recent-" + ugid).remove();
        h = $(".all-" + ugid).clone().removeAttr("id").removeClass("all-" + ugid).addClass("recent-" + ugid);
    } else {
        $("#recent-og-" + ugid).remove();
        h = $("#og" + ugid).clone().prop("id", "recent-og-" + ugid);
    }
    $("#recent_chat_user ul").prepend(h);
    $("#recent_chat_user ul").find("p").removeClass("inlineeditgrouphide");
    $("#recent_chat_user ul").find(".editChatGroup").remove();
    $("#recent_chat_user ul").find(".groupInputBox").remove();
    $(".chatToday").remove();
    $("#recent_chat_user ul").prepend('<div class="recentChatDate chatToday">Today</div>');
}
function notifyChat(title, desc) {
    console.log(123);
    if (DESK_NOTIFY) {
        var returnvalue = notifyMe(title, desc, HTTP_IMAGES + 'logo/orangescrum-200-200.png');
        if (window.webkitNotifications && returnvalue == 1) {
            var havePermission = window.webkitNotifications.checkPermission();
            if (havePermission == 0) {
                var notification = window.webkitNotifications.createNotification(HTTP_IMAGES + 'logo/orangescrum-200-200.png', title, desc);
                notification.onclick = function() {
                    try {
                        window.focus();
                        removePubnubMsg();
                        notification.cancel();
                    } catch (e) {}
                }
                ;
                setTimeout(function() {
                    try {
                        notification.cancel();
                    } catch (e) {}
                }, 5000);
                notification.show();
            } else {
                window.webkitNotifications.requestPermission();
            }
        }
    }
}
function subscribeToGroup(id) {
    if (chat_client_group) {
        chat_client_group.emit('subscribeToGroup', {
            channel: "group-" + id
        });
    } else {
        chat_client_group = io.connect(NODEJS_HOST, {
            secure: NODEJS_SECURE
        });
        chat_client_group.on('connect', function(data) {
            chat_client_group.emit('subscribeToGroup', {
                channel: "group-" + id
            });
        });
    }
    chat_client_group.on('iotogroup', function(data) {
        $group = JSON.parse(data['message']);
        if ($group['msg'] != 'delete') {
            if ($("#og" + $group['group_id']).length > 0) {
                $("#og" + $group['group_id']).attr('data-name', $group['name']);
                $("#og" + $group['group_id']).attr('data-val', $group['value']);
                $("#og" + $group['group_id']).find('.inlineeditgrouphide a').html($group['name']);
            }
            if ($("#recent-og-" + $group['group_id']).length > 0) {
                $("#recent-og-" + $group['group_id']).attr('data-name', $group['name']);
                $("#recent-og-" + $group['group_id']).attr('data-val', $group['value']);
                $("#recent-og-" + $group['group_id']).find('.inlineeditgrouphide a').html($group['name']);
            }
            if ($("#chatGroup").val() == $group['group_id']) {
                $("#chatTo").html("<h6 class='chatProjectName'>" + $group['name'] + "</h6>");
                $("#chatGroupName").val($group['name']);
                $("#chatReceiver").val($group['value']);
                var varr = $group['value'].split(',');
                h = '';
                ttitle = [];
                for (var i = 0; i < varr.length; i++) {
                    if (varr[i] != SES_ID && typeof $("#projectUserProfile" + varr[i]).html() != 'undefined') {
                        h += "<div class='gitem' title='" + $("#projectUserProfile" + varr[i]).closest('li').find(".chatUserNameMenu").html() + "' >" + $("#projectUserProfile" + varr[i]).html();
                        if ($("#og" + $group['group_id']).attr("data-user") == SES_ID) {
                            h += '<a href="javascript:void(0);" onclick="deleteGItem(' + varr[i] + ')"><img src="' + HTTP_ROOT + 'img/cancel.png" alt="Remove"></a>';
                        }
                        h += '</div>';
                    ttitle.push($("#projectUserProfile" + varr[i]).closest('li').find(".chatUserNameMenu").html());
                    }
                }
                p = '<span rel="tooltip" class="gparticipants" title="'+ttitle.join(', ')+'">'+ttitle.length+' participants'+'</span>';
    
                $("#chatToGroup").html(p);
                //createReadMore();
            }
        } else {
            $("#og" + $group['group_id']).remove();
            $("#recent-og-" + $group['group_id']).remove();
            if ($("#chatGroup").val() == $group['group_id']) {
                resetChat();
            }
        }
    });
}

function updateLastActivity(){
    $.post(HTTP_ROOT + 'chats/updateLastActivity',{LASTCHAT:localStorage.LASTCHAT},function(res){

    });
}
function getLastActivity(){
    $.post(HTTP_ROOT + 'chats/getLastActivity',{},function(res){
        if(res){
            localStorage.setItem('LASTCHAT', res);
        }
    });
}
