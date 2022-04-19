<?php echo $this->Form->create('User', array('url' => HTTP_ROOT . 'users/create_company/', 'onsubmit' => 'return validateForm()')); ?>
<div class="modal-body popup-container">
    <?php
    if ($user[0]['User']['email']) {
        echo $this->Form->input('email', array('type' => 'hidden', 'value' => $user[0]['User']['email']));
    }
    ?>
    <div class="form-group label-floating">
        <label class="control-label" for="comp_nm"><?php echo __('Specify company name');?></label>
        <?php echo $this->Form->text('company_name', array('class' => 'form-control', 'placeholder' => '', 'title' => 'Company Name', 'id' => 'comp_nm', 'onchange' => 'validate("comp_nm")', 'autocomplete' => 'off', 'value' => '')); ?>
        <div id="comp_nm_exist" class="err_msg"></div>
    </div>
    <div class="row" >
        <div class="form-group" >
            <?php echo $this->Form->input('industry', array('options' => $industries, 'empty' => 'Select your industry', 'class' => 'select form-control floating-label', 'data-dynamic-opts' => 'true', 'label' => '', 'id' => 'industry', 'placeholder' => 'Specify your industry', 'onchange' => 'showOthers(this);')); ?>
        </div>
        <div class="form-group floating-label" id="industry_others_dv" style="display: none;">
            <label class="control-label" for="industry_others"><?php echo __('Specify other industry name');?></label>
            <input id="industry_others" class="form-control" type="text" autocomplete="off"  name="data[User][industry_others]">
            <input type="hidden" name="data[User][timezone_id]" id="timezone_id" value="<?php echo $user[0]['User']['timezone_id'] ?>">
        </div>
    <table class="col-lg-12 new_auto_tab" cellspacing="0" cellpadding="0">
        
        
        <tr style="margin-top:10px;">
            <td style="width:124px;vertical-align:middle;"><?php echo __('Access URL');?>:</td>
            <td>
                <div class="web_domein_field">
                    <div class="fl web_type">
                        <input class="domainname input_http" type="text" name="" style="background:#EEEEEE;float: left;margin-left: 0;padding:10px 10px;cursor:not-allowed" readonly = 'readonly' value="https://" />
                    </div>
                    <div class="fl access_url">
                        <?php echo $this->Form->text('seo_url', array('size' => '20', 'class' => 'domain_ipad', 'id' => 'seo_url', 'placeholder' => 'Access URL', 'title' => 'Access URL', 'style' => 'background:#fff;float:left;margin-right:0px;margin-left:-2px', 'onchange' => 'validate("seo_url")')); ?>
                    </div>
                    <div class="fl web_side">
                        <input class="domainname input_url" type="text" name="dname" style='background:#EEEEEE;float: left;margin-left: 0;cursor:not-allowed' readonly = 'readonly' value="<?php echo DOMAIN_COOKIE; ?>">
                    </div>
                    <div id="seo_url_exist" style="display:none;font-size:13px;color:#FF0000;margin:5px;"></div>
                    <div class="cb"></div>
                </div>
            </td>
        </tr>
    </table>
    

</div>
<div class="modal-footer">
    <div class="fr popup-btn">
        <span id="submit_loader" class="fr" style="display:none;">
            <img src="<?php echo HTTP_IMAGES; ?>images/case_loader2.gif" alt="Loader"/>
        </span>
        <span id="submit_button">
            <span class="fl cancel-link"><button type="button" class="btn btn-default btn-sm" data-dismiss="modal" onclick="closePopup();">Cancel</button></span>
            <span class="fl hover-pop-btn"><a href="javascript:void(0)" id="" onclick="return validateForm();" class="btn btn-sm btn-raised btn_cmn_efect cmn_bg btn-info "loginactive>Create My Company</a></span>
        </span>

        <div class="cb"></div>
    </div>
</div>
<?php echo $this->Form->end(); ?>

<script type="text/javascript">
    $(function() {
        $("#comp_nm").focusout(function() {
            $("#seo_url").val($("#comp_nm").val());
        });
    });
    function validate(id) {
        $("#comp_nm_err").hide();
        if ($.trim($("#" + id).val())) {
            $("#" + id).css({"border": "1px solid #D4D4D4"});
            //$("#"+id+"_right").show();
            if (id == "comp_nm") {
                var letterNumber = /^[0-9a-zA-Z]+$/;
                if (!$("#" + id).val().trim().match(letterNumber)) {
                    $("#" + id).css({"border": "1px solid #FF0000"});
                }
            }
        } else {
            $("#" + id).css({"border": "1px solid #FF0000"});
        }

        if (id == "seo_url") {
            var seo_url = $("#" + id).val().trim();
            var letterNumber = /^[0-9a-zA-Z]+$/;
            if (seo_url) {
                if (seo_url.match(letterNumber)) {
                    $("#seo_url_exist").hide();
                    $("#" + id).css({"border": "1px solid #D4D4D4"});
                } else {
                    $("#" + id).css({"border": "1px solid #FF0000"});
                    $("#seo_url_exist").show('slow');
                    $("#seo_url_exist").html("<?php echo __('Only letters and numbers are alloweded');?>.");
                }
            }
        }
    }
    function showOthers(obj) {
        var id = $(obj).attr('id');
        $("#" + id + "_others").css({"border": "1px solid #AAAAAA"});
        $("#" + id + "_others").val('');

        if ($.trim($("#" + id + " option[value='" + $(obj).val() + "']").text()) && $.trim($("#" + id + " option[value='" + $(obj).val() + "']").text()) === "Others") {
            $("#" + id + "_others_dv").show();
            $("#" + id + "_others").focus();
        } else {
            $("#" + id + "_others_dv").hide();
        }
    }
    function validateForm() {
        $("#signupsuccess").hide();
        $("#login_dialog").show();

        $(".success_msg").hide();
        var error_flag = 1;
        var name = '';
        var last_name = '';
        var seo_url = $.trim($("#seo_url").val());
        var company = $.trim($("#comp_nm").val());
        var email = $.trim($("#email").val());
        var password = $.trim($("#password").val());
        var industry = $.trim($("#industry").val());
        var industry_val = $.trim($("#industry option[value='" + industry + "']").text());

        var new_industry = "";
        if (industry_val === "Others") {
            new_industry = $.trim($("#industry_others").val());
        }
        var emailRegEx = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var letterNumber = /^[0-9a-zA-Z]+$/;

        if (industry == "") {
            $("#industry").css({"border": "1px solid #FF0000"});
            $("#industry").focus();
            error_flag = 0;
        } else if (industry !== "" && industry_val == "Others") {
            var industry_others = $.trim($("#industry_others").val());

            if (industry_others === "") {
                $("#industry_others").css({"border": "1px solid #FF0000"});
                $("#industry_others").focus();
                error_flag = 0;
            } else {
                $("#industry_others").css({"border": "1px solid #D4D4D4"});
                error_flag = 1;
            }
        } else if (error_flag == 1) {
            $("#industry").css({"border": "1px solid #D4D4D4"});
            error_flag = 1;
        }

        if (company == "") {
            $("#comp_nm").css({"border": "1px solid #FF0000"});
            $("#comp_nm").focus();
            error_flag = 0;
            //return false;
        } else if (!company.match(letterNumber)) {
            $("#comp_nm").css({"border": "1px solid #FF0000"});
            $("#comp_nm_exist").show();
            $("#comp_nm_exist").html("<?php echo __('Only letters and numbers are allowed');?>.");
            $("#comp_nm").focus();
            error_flag = 0;
            //return false;
        } else if (error_flag == 1) {
            $("#comp_nm").css({"border": "1px solid #D4D4D4"});
            error_flag = 1;
        }

        if (seo_url == "") {
            $("#seo_url").css({"border": "1px solid #FF0000"});
            $("#seo_url").focus();
            error_flag = 0;
            //return false;
        } else if (!seo_url.match(letterNumber)) {
            $("#seo_url").css({"border": "1px solid #FF0000"});
            $("#seo_url_exist").show();
            $("#seo_url_exist").html("<?php echo __('Only letters and numbers are allowed');?>.");
            $("#seo_url").focus();
            error_flag = 0;
            //return false;
        } else if (error_flag == 1) {
            $("#seo_url").css({"border": "1px solid #D4D4D4"});
            error_flag = 1;
        }
        //$("#coupon_code").css({"border":"1px solid #D4D4D4"});

        if (!error_flag) {
            return false;
        }

        var strURL = "<?php echo HTTP_ROOT; ?>";
        $("#submit_button").hide();
        $("#submit_loader").show();
        $("#seo_url_exist").hide();
        $("#email_exist").hide();


        var is_agree = 1;
        $.post(strURL + "users/validate_emailurl", {"company_name": company, "seo_url": escape(seo_url)}, function(data) {
            if (data.company_name == 'error' || data.seourl == 'error') {
                $("#submit_button").show();
                $("#submit_loader").hide();
                if (data.seourl == 'error') {
                    $("#seo_url").css({"border": "1px solid #FF0000"});
                    $("#seo_url_exist").show('slow');
                    $("#seo_url_exist").html(data.seourl_msg);
                }
                if (data.company_name == 'error') {
                    $("#comp_nm").css({"border": "1px solid #FF0000"});
                    $("#comp_nm_exist").show('slow');
                    $("#comp_nm_exist").html(data.company_name_msg);
                }
            } else {
                company = $.trim($("#comp_nm").val());
                ;
                $('#cover').show();
                $('#cover').css({position: 'fixed', opacity: '0.7 !important'});
                $('#donot_refresh').show();
                var contact_phone = '';
                var timezone_id = $("#timezone_id").val().trim();
                $.post(strURL + "users/create_company", {"company": escape(company), "seo_url": escape(seo_url), "industry_id": industry, "new_industry": new_industry, 'timezone_id': escape(timezone_id), 'is_agree': is_agree}, function(data) {
                    console.log(data);
                    //var msg = jQuery.parseJSON(data);
                    if (data.msg == "success") {
                        /*$("#submit_button").show();
                         $("#submit_loader").hide();
                         $('#cover').hide();
                         $('#donot_refresh').hide();
                         
                         //$(".success_msg").show('slow');
                         //$(".success_msg").html("Thanks for Signing up. An activation link is sent to '"+email+"' for confirmation,<br/> Please click that and start using Orangescrum rightaway.");
                         
                         $("#msgsuccess").html("A confirmation link is sent to '"+email+"',<br/>please activate your account and start using Orangescrum rightaway.");
                         $("#signupsuccess").slideDown('slow');
                         $("#login_dialog").hide();
                         
                         $('html, body').animate({ scrollTop: 0 }, 400);
                         $(".err_succ").hide();
                         
                         $("#name").val(''); $("#last_name").val(''); $("#company").val(''); $("#email").val(''); $("#password").val('');
                         $("#seo_url").val(''); $("#contact_phone").val('');
                         $("#confirm_password").val('');
                         
                         // Conversion Tracking for GA and FB
                         conversionTracking('FREE');*/
                        window.location = HTTP_ROOT + 'users/launchpad';
                    } else {
                        $("#submit_button").show();
                        $("#submit_loader").hide();
                        /*$('#cover').hide();
                         $('#donot_refresh').hide();
                         
                         $(".err_succ").hide();
                         $('#cover').hide();
                         $('#donot_refresh').hide();
                         $(".error_msg").show();
                         $(".error_msg").html();
                         $("#submit_button").show();
                         $("#submit_loader").hide();
                         $('html, body').animate({ scrollTop: 0 }, 400);*/
                        alert("<?php echo __('Something is wrong! Please try again after few minutes');?>");
                    }
                }, 'JSON');
            }
        }, 'json');
        return false;
    }
</script>