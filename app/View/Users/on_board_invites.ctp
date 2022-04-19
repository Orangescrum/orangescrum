<div class="onboard_page_wrap">
     <div class="logo">
        <a href=""  title="Orangescrum Project Mamangemet Tool">
            <img src="<?php echo HTTP_ROOT ?>img/header/orangescrum-logo.png" alt="#1 Productivity Tool" title="#1 Productivity Tool" width="200" height="58">
        </a>
    </div>
    <div class="content_wrap">
        <!--Design Project start-->
        <div class="design_project">
            <h3>People in <div><strong style="display:inline-block;"><?php echo ucfirst($projects['Project']['name']);?></strong> <span>Project</span></div></h3>
            <div class="dproj_inner">
                <?php echo $this->Form->create('User', array('url' => '/users/new_user', 'id' => 'myform', 'name' => 'myform', 'onsubmit' => 'return memberCustomer(\'txt_email\',\'sel_custprj\',\'loader\',\'btn\')')); ?>

                <input type="hidden" name="data[TimezoneName][id]" value="<?php echo SES_TIMEZONE; ?>" id="txt_loc"/>
                <input type="hidden" name="data[User][istype]" value="3" id="sel_Typ"/>
                <div class="input_email_name">
					<div class="full_width">
						<label>Enter Email Address</label>
						 <?php echo $this->Form->textarea('email', array('id' => 'txt_email', 'class' => '', 'placeholder' => '', 'rows' => '1')); ?>
                            <p class="help-block">Use comma to separate multiple email ids</p>
					</div>

   

                        </div> 
				<a href="javascript:void(0);" class="connect_to_google" onclick="contactListGoogle('<?php echo COMP_UID; ?>');"><span class="cmn_onbd_sp"></span>connect to google contacts</a>
		
                <?php echo $this->Form->input('role', array('id' => 'role_hid', 'type' => 'hidden')); ?>
                <?php echo $this->Form->input('pid', array('id' => 'pid', 'type' => 'hidden','value'=>$projects['Project']['id'])); ?>
                <div id="err_email_new" style="color:#FF0000;display:none;text-align:center; font-size: 14px;"></div>
                <div class="cb"></div>                

                <div class="type_user_tbl">
                    <table>
                        <tr>
                            <td>
                                <span class="cmn_onbd_sp owner"></span>
                            </td>
                            <td><strong>Owner</strong></td>
                            <td>Access to Everything.</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="cmn_onbd_sp admin"></span>
                            </td>
                            <td><strong>Admin</strong></td>
                            <td>All access as Owner except subscriptions.</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="cmn_onbd_sp user"></span>
                            </td>
                            <td><strong>User</strong></td>
                            <td>Can view and access tasks, time log, comments for ONLY projects assigned to him/her.</td>
                        </tr>
                        <tr>
                            <td>
                                <span class="cmn_onbd_sp client"></span>
                            </td>
                            <td><strong>Client</strong></td>
                            <td>Same as user but additional restrictions available.</td>
                        </tr>
                    </table>
                </div>
                <div class="skip_done">
                    <?php /* if(@$_COOKIE['FIRST_DISPLAY_LIST'] ==1){?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard#kanban' ?>">Click here to skip</a>
                    <?php }else{*/ ?>
                    <a href="<?php echo HTTP_ROOT . 'dashboard' ?>">Click here to skip</a>
                    <?php /*}*/ ?>
                    <span id="ldr" style="display:none;float:right;">
                        <img src="<?php echo HTTP_ROOT; ?>img/images/case_loader2.gif" alt="Loading..." title="Loading...">
                    </span>                   
                    <button type="submit" class="done" id="btn_addmem">Done</button>
                    <div class="cb"></div>
                </div>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>
        <!--Design Project end-->
    </div>
</div>

<script type="text/javascript" src="<?php echo JS_PATH; ?>bootstrap.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>material.min.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>scripts/jquery.imgareaselect.pack.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.fileupload.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>jquery.fileupload-ui.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>ripples.min.js" defer></script>
<script type="text/javascript">
    var HTTP_ROOT ="<?php echo HTTP_ROOT;?>";
                                    var CLIENT_ID = "<?php echo CLIENT_ID; ?>";
                                    var REDIRECT = "<?php echo REDIRECT_URI; ?>";
                                    var API_KEY = "<?php echo API_KEY; ?>";
                                    var DOMAIN_COOKIE = "<?php echo DOMAIN_COOKIE; ?>";
</script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>google_drive_v1.js" defer></script>
<script type="text/javascript" src="<?php echo JS_PATH; ?>google_contact.js" defer></script>
<script type="text/javascript">
                                    var HTTP_ROOT = '<?php echo HTTP_ROOT; ?>';
                                    var SES_TYPE = '<?php echo SES_TYPE; ?>';
                                    $('body').height($(window).height());
                                    $(document).ready(function () {
                                        $(".add_btn").click(function (e) {
                                            $("#addMoreWrapp").append('<div class="input_email_name mar10"><div class="half_width"><input type="text" name="emails[]" placeholder="Email"></div><div class="half_width"><input type="text" placeholder="Name" name="fnames[]" ></div><a href="javascript:void(0);" class="remove_btn">Remove</a><div class="cb"></div></div>'); //add input box
                                        });
                                        $("#addMoreWrapp").on("click", ".remove_btn", function (e) { //user click on remove text
                                            e.preventDefault();
                                            $(this).closest('.input_email_name').remove();
                                        });
                                    });
                                    function memberCustomer(txtEmailid, selprj, loader, btn) {
                                        var email_id = $('#' + txtEmailid).val();
                                        var email_arr = email_id.split(',');
                                        var done = 1;
                                        if (email_id == "") {
                                            done = 0;
                                            msg = "Email cannot be left blank!";
                                            $('#err_email_new').html('');
                                            $('#err_email_new').show();
                                            $('#err_email_new').html(msg);
                                            document.getElementById(txtEmailid).focus();
                                            return false;
                                        } else {
                                            var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                                            if (!email_id.match(emailRegEx)) {
                                                if (email_id.indexOf(',') != -1) {
                                                    var totlalemails = 0;
                                                    for (var i = 0; i < email_arr.length; i++) {
                                                        if (email_arr[i].trim() != "") {
                                                            if ((!email_arr[i].trim().match(emailRegEx))) {
                                                                done = 0;
                                                                msg = "Invalid Email: '" + email_arr[i] + "'";
                                                                $('#err_email_new').html('');
                                                                $('#err_email_new').show();
                                                                $('#err_email_new').html(msg);
                                                                document.getElementById(txtEmailid).focus();
                                                                return false;
                                                            }
                                                        } else {
                                                            totlalemails++;
                                                        }
                                                    }
                                                    if (totlalemails == email_arr.length) {
                                                        msg = "Entered stirng is not a valid email";
                                                        $('#err_email_new').html("");
                                                        $('#err_email_new').show();
                                                        $('#err_email_new').html(msg);
                                                        $('#' + txtEmailid).focus();
                                                        return false;
                                                    }
                                                } else {
                                                    done = 0;
                                                    msg = "Invalid E-Mail!";
                                                    $('#err_email_new').html('');
                                                    $('#err_email_new').show();
                                                    $('#err_email_new').html(msg);
                                                    document.getElementById(txtEmailid).focus();
                                                    return false;
                                                }
                                            }
                                            if (done != 0) {
                                                var type = $('#sel_Typ').val();
                                                if (type == 2) {
                                                    var usertype = "Admin";
                                                } else if (type == 3) {
                                                    var usertype = "Member";
                                                }
                                                $('#err_email_new').hide();
                                                $("#ldr").show();
                                                $("#btn_addmem").hide();
                                                var uniq_id = $("#uniq_id").val();
                                                var strURL = HTTP_ROOT;
                                                if (email_id.indexOf(',') != -1) {
                                                    $.post(strURL + "users/ajax_check_user_exists", {
                                                        "email": escape(email_id),
                                                        "uniq_id": escape(uniq_id)
                                                    }, function (data) {
                                                        if (data == "success") {
                                                            document.myform.submit();
                                                            return true;
                                                        } else {
                                                            if (data == 'errorlimit') {
                                                                $("#ldr").hide();
                                                                $("#btn_addmem").show();
                                                                $("#err_email_new").show();
                                                                $("#err_email_new").html("Sorry! You are exceeding your user limit.");
                                                            } else {
                                                                $("#ldr").hide();
                                                                $("#btn_addmem").show();
                                                                $("#err_email_new").show();
                                                                $("#err_email_new").html("Oops! Invitation already sent to '" + data + "'!");
                                                            }
                                                            return false;
                                                        }
                                                    });
                                                } else {
                                                    $.post(strURL + "users/ajax_check_user_exists", {
                                                        "email": escape(email_id),
                                                        "uniq_id": escape(uniq_id)
                                                    }, function (data) {
                                                        if (data == "invited" || data == "exists" || data == "owner" || data == "account") {
                                                            $("#ldr").hide();
                                                            $("#btn_addmem").show();
                                                            $("#err_email_new").show();
                                                            if (data == "owner") {
                                                                $("#err_email_new").html("Ah... you are inviting the company Owner!");
                                                            } else if (data == "account") {
                                                                $("#err_email_new").html("Ah... you are inviting yourself!");
                                                            } else {
                                                                $("#err_email_new").html("Oops! Invitation already sent to '" + email_id + "'!");
                                                            }
                                                            return false;
                                                        } else {
                                                            document.myform.submit();
                                                            return true;
                                                        }
                                                    });
                                                }
                                            }
                                        }
                                        return false;
                                    }
									

</script>