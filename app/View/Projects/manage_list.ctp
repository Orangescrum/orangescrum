<?php /*<link rel="stylesheet"  type="text/css" href="<?php echo HTTP_ROOT; ?>css/demo_page.css">
<link rel="stylesheet"  type="text/css" href="<?php echo HTTP_ROOT; ?>css/demo_table.css">
<link rel="stylesheet"  type="text/css" href="<?php echo HTTP_ROOT; ?>css/betauser.css">
<script type="text/javascript" src="<?php echo JS_PATH . 'betauser.js'; ?>"></script>
*/ ?>
<style>
.task_listing .proj_grids table.table th{padding: 5px 25px 5px 8px;position: relative;}
.task_listing .proj_grids table.table th:before{position:absolute;right:5px;top:10px;color:#888;font-family:'Material Icons';font-weight:normal;font-style:normal;font-size:16px;line-height:1;letter-spacing:normal;text-transform:none;display:inline-block;white-space:nowrap;word-wrap:normal;direction:ltr;-moz-font-feature-settings:'liga';-moz-osx-font-smoothing:grayscale;font-feature-settings:'liga';osx-font-smoothing:grayscale;-webkit-font-feature-settings:'liga';-webkit-osx-font-smoothing:grayscale;content:'';color:#555;vertical-align:middle}

.task_listing .proj_grids table.table th {vertical-align: top;}
.task_listing .proj_grids table.table th:first-child:before{content:'';}
.task_listing .proj_grids table.table th.sorting:before{content:'sort';}
.task_listing .proj_grids table.table th.sorting_asc:before{content:'keyboard_arrow_up';}
.task_listing .proj_grids table.table th.sorting_desc:before{content:'keyboard_arrow_down';}
.task_listing table.table td.proj_tsks_cnt:hover {color:#2d6dc4;text-decoration:underline;}
.txt_upper_prj {text-transform: uppercase;}
.prjct_lst_tr .dropdown .dropdown-menu {max-height: 270px;overflow-y: auto;}
#grid-keep-selection th.tophead{cursor:pointer;min-width: 170px;text-align:left;}
#grid-keep-selection th.tophead.manage-list-th1{min-width:50px;}
.task_listing .proj_grids #grid-keep-selection.table th:before{right:10px}
#grid-keep-selection.table td{text-align:left !important;}
#project_grid_div #grid-keep-selection {margin-top: 20px;}
#project_grid_div .dataTables_length{left: 0px; position: absolute;top: -40px;}
#project_grid_div .dataTables_filter{right: 130px;position: absolute;top: -45px;}


.cmn_list_sh_filter_dropdown .dropdown-menu{right:0;top:20px;padding:0}
#project_grid_div .cmn_list_sh_filter_dropdown .dropdown > a{padding: 4px 10px 3px;}
#grid-keep-selection_filter label input{margin-left:10px}
#ajax_project_inner_search{
  display: block;
  z-index: 11;
  background: #fff;
  position: absolute;
  top: 32px;
  min-width: 400px;
  box-shadow: 0px 3px 14px -2px rgb(0 0 0 / 69%);
}
.m-cmn-flow.min-height-400{
  min-height:400px;
}

.proj_grids .mb-20{margin-bottom:30px}

.proj_grids .inner_search_span{position: absolute;left:0;top:5px}
.proj_grids .inner_search_span .inner-search{padding-left:24px}
.proj_grids .inner_search_span .inner_search_icon {left: 5px;top: 5px;font-size: 18px;}

.proj_grids #inner-project-search {font-size: 14px;}
.proj_grids img#srch_inner_load1 {top: 5px;right: 3px;}
.showhide_search{position:absolute;right:15px;top:10px}
</style>
<?php  
if ($projtype == 'active-grid') {
  $gr_cookie_value = '';
  $cookie_value = 'active-grid';
} elseif ($projtype == 'inactive-grid') {
  $gr_cookie_value = 'inactive';
  $cookie_value = 'inactive-grid';
}
// pr(count($fields)); exit;
?>
<div class=" task_lis_page">
    <div class="task_listing">
        <div class="proj_grids glide_div pr" id="project_grid_div">
						<div class="d-flex width-100-per mb-20 pr">
						<div class="width-100-per pr">
								<span class="pr inner_search_span" onclick="slider_inner_project_search('open');">
								<i class="material-icons clear_close_icon" title="<?php echo __('Clear search');?>" id="clear_close_icon" onclick="setSessionStorage('Task Group Page', 'Search Task'); clearSearch('inner ');">close</i>
								<i class="inner_search_icon material-icons">&#xE8B6;</i>
								<input type="text" name="search_inner" id="inner-project-search" placeholder="<?php echo __('Search');?>" class="inner-search" value=""/>
								<img src="<?php echo HTTP_ROOT; ?>img/images/del.gif" alt="loading" title="<?php echo __('loading');?>" id="srch_inner_load1">
								<div id="ajax_project_inner_search" class="ajx-srch-inner-dv1"></div>
							</span> 
              <div class="showhide_search">
            <span class="pfl-icon-dv show_hide_column_filter cmn_list_sh_filter_dropdown">
              <span id="showhide_drpdwn postion-fixed" class="dropdown">
                <a href="javascript:jsVoid();" title="<?php echo __('Show/Hide Columns');?>" onclick="showColumnPreferences();" class="dropdown-toggle" data-toggle="dropdown">
                <i class="material-icons">visibility_off</i> <?php echo __("Show/Hide");?><div class="ripple-container"></div></a>
                <ul class="dropdown-menu drop_menu_mc" id="dropdown_menu_taskcolumns">
                  <?php if(!empty($fields)){ ?>
                    <li class="li_check_radio">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(count($fields) == 12 ){ ?> checked="checked" <?php } ?> class="selectedcls" value="All" id="column_all"  style="cursor:pointer" onchange="checkboxCol(this);"> <?php echo __('Show/Hide All');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Template", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Template" id="column_template" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="2"> <?php echo __('Template');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Description", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Description" id="column_description" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="4"> <?php echo __('Description');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Status", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Status" id="column_status" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="7"> <?php echo __('Status');?>
                            </label>
                          </div>
                      </li>
                        <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Status Workflow", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Status Workflow" id="column_statusworkflow" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="8"> <?php echo __('Status Workflow');?>
                            </label>
                          </div>
                      </li>

                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Tasks", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Tasks" id="column_tasks" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="9"> <?php echo __('Tasks');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Users", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Users" id="column_users" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="10"> <?php echo __('Users');?>
                            </label>
                          </div>
                      </li>
                      <?php if($this->Format->isAllowed('Budget',$roleAccess)){ ?>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Budget", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Budget" id="column_budget" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="13"> <?php echo __('Budget');?>
                            </label>
                          </div>
                      </li>
                      <?php  } ?>
                      <?php if($this->Format->isAllowed('Cost Appr',$roleAccess)){ ?>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Cost Approved", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Cost Approved" id="column_costapproved" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="14"> <?php echo __('Cost Approved');?>
                            </label>
                          </div>
                      </li>
                      <?php  } ?>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Project Type", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Project Type" id="column_projecttype" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="15"> <?php echo __('Project Type');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Industry", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Industry" id="column_industry" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="16"> <?php echo __('Industry');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Last Activity", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Last Activity" id="column_lastactivity" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="17"> <?php echo __('Last Activity');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" <?php if(in_array("Custom Field", $fields)){ ?> checked="checked" <?php } ?> class="selectedcls clmn_chkbx" value="Custom Field" id="column_custom_field" style="cursor:pointer" onchange="checkboxProjectColumn(this);" data-column="17"> <?php echo __('Custom Field');?>
                            </label>
                          </div>
                      </li>
                  <?php }else{ ?>
                    <li class="li_check_radio">
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls" value="All" id="column_all"  style="cursor:pointer" onchange="checkboxCol(this);"> <?php echo __('Show/Hide All');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Template" id="column_template" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Template');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Description" id="column_description" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Description');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Start Date" id="column_startdate" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Start Date');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="End Date" id="column_enddate" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('End Date');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Status" id="column_status" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Status');?>
                            </label>
                          </div>
                      </li>
                        <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Status Workflow" id="column_statusworkflow" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Status Workflow');?>
                            </label>
                          </div>
                      </li>

                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Tasks" id="column_tasks" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Tasks');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Progress" id="column_progress" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Users');?>
                            </label>
                          </div>
                      </li>
                      <?php if($this->Format->isAllowed('Budget',$roleAccess)){ ?>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Budget" id="column_budget" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Budget');?>
                            </label>
                          </div>
                      </li>
                      <?php  } ?>
                      <?php if($this->Format->isAllowed('Cost Appr',$roleAccess)){ ?>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Cost Approved" id="column_costapproved" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Cost Approved');?>
                            </label>
                          </div>
                      </li>
                      <?php  } ?>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Project Type" id="column_projecttype" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Project Type');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Industry" id="column_industry" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Industry');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Last Activity" id="column_lastactivity" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Last Activity');?>
                            </label>
                          </div>
                      </li>
                      <li class="li_check_radio"> 
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" checked="checked" class="selectedcls clmn_chkbx" value="Custom Field" id="column_custom_field" style="cursor:pointer" onchange="checkboxProjectColumn(this);"> <?php echo __('Custom Field');?>
                            </label>
                          </div>
                      </li>
                  <?php } ?>
                  <li class="li_check_radio"> 
                      <div class="save_sh_btn">
                        <label>
                          <input type="button" class="btn btn_cmn_efect cmn_bg btn-info show_btn" value="<?php echo __('Save');?>" onclick="saveAllowedColumns();">
                        </label>
                      </div>
                  </li>
                </ul>
                <!-- Custom code Ends -->
              </span>
            </span>
						</div>
						</div>
						</div>


            <div class="m-cmn-flow min-height-400 pr" id ="list_view_project_page">
            
              <div id="ajax_list_view_tmp_load">
								<div class="loader_bg"> 
										<div class="loadingdata">
												<img src="<?php echo HTTP_ROOT; ?>images/rolling.gif?v=<?php echo RELEASE; ?>" alt="loading..." title="<?php echo __('loading');?>..."/>
										</div> 
								</div>
							</div>
            </div>
    </div>
    <div id="project_paginate" style="display:block"></div>
</div>
<script>
	var table;
  $(document).on('click','.disbl_prj',function() {
    var ref = window.location.href;
    ref = ref.split('projects/');
    var prj_id = $(this).attr('data-prj-id');
    var prj_name = $(this).attr('data-prj-name');
    var conf = confirm(_("Are you sure you want to mark") + " '" + prj_name + "' " + _("as completed ?"));
    if (conf == true) {
        var pg = $(".button_page").html();
        var loc = HTTP_ROOT + 'projects/gridview/?id=' + prj_id + '&action=deactivate';
        if (parseInt(pg) > 1) {
            loc = loc + "&pg=" + pg;
        }
        window.location = loc + "&req_uri=" + ref[1];
    } else {
        return false;
    }
});
  function casePaging(page) {
    var getpage = getPage();
    var filetype = localStorage.getItem("PROJECTLISTVIEW_FILTYPE");
    var srch = localStorage.getItem("PROJECTLISTVIEW_SCRH");
    var sort_by = localStorage.getItem("PROJECTLISTVIEW_SORTBY");
    var order = localStorage.getItem("PROJECTLISTVIEW_ORDER");
    var tcls = localStorage.getItem("PROJECTLISTVIEW_TCLS");
    if(getpage == "projects"){
      ajaxGridViewLoad('<?php echo $cookie_value; ?>',srch,page,filetype,order,sort_by,tcls);
      remember_filters('PROJECTLISTVIEW_PAGE', page);
    }
  }

    function slider_inner_project_search(v) {
        if (v == 'open') {
            if ($('#inner-project-search').width() == 0 || $('#inner-project-search').width() < 10) {
                $('#inner-project-search').addClass('open');
                $("#inner-project-search").animate({
                    width: '200px'
                }, 400, function() {
                    $('#inner-project-search').focus();
                });
            }
        }
        $("#inner-project-search").off().on('blur', function() {
        search_val = $('#inner-project-search').val().trim();
        if (search_val == '') {
            $(this).animate({
                width: '0px'
            }, 400, function() {
                $('#inner-project-search').removeClass('open');
            });
        }
    });
    }
    function addUserToProjectListView(obj){
      $(".icon-grid-add-usr").on("click", function(event) {
        event.stopPropagation();
        var prj_id = $(obj).attr('data-prj-uid');
        var prj_name = $(obj).attr('data-prj-name');
        $('#pop_up_add_user_label').hide();
        setSessionStorage('From Project Grid View', 'Add User to Project');
        addUsersToProject(prj_id, prj_name);
      });
    }
    function removeUsrFrmProjectListView(obj){
      $(".icon-grid-remove-usr").click(function(event) {
        event.stopPropagation();
        var prj_id = $(obj).attr('data-prj-id');
        var prj_name = $(obj).attr('data-prj-name');
        openPopup();
        $("#popupload2").show();
        $(".rmv_prj_usr").show();
        $("#header_prj_usr_rmv").html(prj_name);
        $('#inner_prj_usr_rmv').hide();
        $('.rmv-btn').hide();
        $('#rmname').val('');
        $('#remusersrch').hide();
        $.post(HTTP_ROOT + "projects/user_listing", {
            "project_id": prj_id
        }, function(data) {
            if (data) {
                $(".loader_dv").hide();
                $('#inner_prj_usr_rmv').show();
                $('#inner_prj_usr_rmv').html(data);
                if (parseInt($("#is_users").val())) {
                    $('.rmv-btn').show();
                    $('#remusersrch').show();
                    enableAddUsrBtns('.rem-usr-prj');
                }
                $("#popupload2").hide();
                $.material.init();
                $('[rel="tooltip"]').tipsy({
                    gravity: 's',
                    fade: true
                });
            }
        });
      });
    }
    function editProjectFrmListView(obj){
        setSessionStorage('From Project Grid View', 'Update Project');
        var prj_id = $(obj).attr('data-prj-id');
        var prj_name = $(obj).attr('data-prj-name');
        openPopup();
        $(".loader_dv").show();
        $("#inner_prj_edit").hide();
        $(".edt_prj").show();
        $("#header_prj").html(prj_name);
        $.post(HTTP_ROOT + "projects/ajax_edit_project", {
            "pid": prj_id
        }, function(data) {
          if (data) {
            $.post(HTTP_ROOT + "projects/getCustomFieldValuesDetail", {
                "pid": prj_id
            }, function(res) {
                $("#edt_custom_field_container").html(tmpl("proj_customfield_tmpl", res));
                $('.CS_people').select2();
                $('.custom_field_datpicker').datepicker({
                    format: "M d, yyyy",
                    todayHighlight: true,
                    changeMonth: false,
                    changeYear: false,
                    hideIfNoPrevNext: true,
                    autoclose: true
                }).on("changeDate", function(selectedDate) {
                    var dateText = $(this).datepicker("getFormattedDate");
                });
            }, 'json');
            $(".loader_dv").hide();
            $('#inner_prj_edit').show();
            $('#inner_prj_edit').html(data);
            $.material.init();
            $('.proj_prioty').select2();
            $('.proj_methodology').select2();
            $('.sel_Typ_dp').select2();
            $('.tsk_Typ_dp').select2({
              templateSelection: formatTaskType,
              templateResult: formatTaskType
            });
            $('.status_typ_dp').select2();
            $('.workflow_dp').select2();
            $('textarea').autoGrow().keyup();
          }
        });
     
    }
    function assignRoleFrmListView(obj){
      var prj_id = $(obj).attr('data-prj-id');
      var prj_name = $(obj).attr('data-prj-name');
      assign_role(prj_id, prj_name);
      e.preventDefault();
    }
    function changePrjStatus(obj){
        var ref = window.location.href;
        ref = ref.split('projects/');
        var prj_id = $(obj).attr('data-prj-id');
        var prj_name = $(obj).attr('data-prj-name');
        var status_name = $(obj).attr('data-prj-status-name');
        var status_id = $(obj).attr('data-prj-status-id');
        var conf = confirm(_("Are you sure you want to mark") + " '" + prj_name + "' as " + status_name);
        if (conf == true) {
            var pg = $(".button_page").html();
            var loc = HTTP_ROOT + 'projects/gridview/?id=' + prj_id + '&status_change=' + status_id;
            if (parseInt(pg) > 1) {
                loc = loc + "&pg=" + pg;
            }
            window.location = loc + "&req_uri=" + ref[1];
        } else {
            return false;
        }
    }
    function enablePrjListView(obj){
        var ref = window.location.href;
        ref = ref.split('projects/');
        var prj_id = $(obj).attr('data-prj-id');
        var prj_name = $(obj).attr('data-prj-name');
        if ($(obj).attr('data-view')) {
            var view = $(obj).attr('data-view');
        }
        var conf = confirm(_("Are you sure you want to mark") + " '" + prj_name + "' " + _("as not complete ?"));
        if (conf == true) {
            var pg = $(".button_page").html();
            var loc = HTTP_ROOT + 'projects/gridview/?id=' + prj_id + '&action=activate';
            if (parseInt(pg) > 1) {
                loc = loc + "&pg=" + pg;
            }
            if (view) {
                loc = loc + "&view=" + view;
            }
            window.location = loc + "&req_uri=" + ref[1];
        } else {
            return false;
        }
    }
    function disablePrjListView(obj){
      var ref = window.location.href;
      ref = ref.split('projects/');
      var prj_id = $(this).attr('data-prj-id');
      var prj_name = $(this).attr('data-prj-name');
      var conf = confirm(_("Are you sure you want to mark") + " '" + prj_name + "' " + _("as completed ?"));
      if (conf == true) {
        var pg = $(".button_page").html();
        var loc = HTTP_ROOT + 'projects/gridview/?id=' + prj_id + '&action=deactivate';
        if (parseInt(pg) > 1) {
          loc = loc + "&pg=" + pg;
        }
        window.location = loc + "&req_uri=" + ref[1];
      } else {
        return false;
      }
      
    }
    function deleteProjectListView(obj){
      var prj_unq_id = $(obj).attr('data-prj-uid');
      var prj_nm = $(obj).attr('data-prj-name');
      if (confirm(_("Are you sure to delete project") + " '" + prj_nm + "'")) {
          if (confirm(_("All the Tasks, Files associated with") + " '" + prj_nm + "' " + _("will be deleted permanently."))) {
            var pg = $(".button_page").html();
            var loc = HTTP_ROOT + "projects/deleteprojects/" + prj_unq_id;
            if (parseInt(pg) > 1) {
              loc = loc + "/" + pg;
            }
            window.location = loc;
          } else {
            return false;
          }
      } else {
          return false;
      }
    }
    $(document).ready(function() {
      remember_filters('PROJECTLISTVIEW_SORTBY', '');
      remember_filters('PROJECTLISTVIEW_ORDER', '');
      remember_filters('PROJECTLISTVIEW_TCLS', '');
      remember_filters('PROJECTLISTVIEW_SCRH', '');
      ajaxGridViewLoad('<?php echo $cookie_value; ?>','','<?php echo $csPage; ?>','<?php echo $filtype; ?>','','','');
      
		  setTimeout(hideCmnMesg, 2000);
        var url = HTTP_ROOT + 'projects/manage/grid';
    });
    function checkboxCol(ev){
        var status = $(ev).is(":checked");
        $(".clmn_chkbx").prop("checked",status);
        $("#showhide_drpdwn").addClass("open");
    }
    function checkboxProjectColumn(ev) {
        $("#showhide_drpdwn").addClass("open");
        var status = $(ev).is(":checked");
        var col_id = $(ev).attr('id');
        // var column = table.column( $(ev).attr('data-column') );
          if($('.clmn_chkbx:checked').length == $('.clmn_chkbx').length){
          $('#column_all').prop('checked',true);
        }else{
          $('#column_all').prop('checked',false);
        }
        
    }
    function showColumnPreferences(pref){
         //$(".selectedcols").trigger('change');
    }
    function saveAllowedColumns(){
        var cvals = [];
        $('.selectedcls:checkbox:checked').each(function() {
            cvals.push(this.value);
        });
        var selectedCols = cvals.join(",");
        $.post( HTTP_ROOT + "requests/saveProjectColumns", {"cols": selectedCols}, function(data){
          if (data) {
              window.location.reload();
          }
        });
    }
	function notAuthAlert(){
		showTopErrSucc('error', "<?php echo __('Oops! You are not authorized to do this operation. Please contact your Admin/Owner');?>.");
	}
	function assignMeToPrj(obj){
		var loc = HTTP_ROOT+"projects/assignRemovMeToProject/";
		var proj_id = $(obj).attr('data-prj-id');
		var proj_uid = $(obj).attr('data-prj-uid');
		var user_ids = $(obj).attr('data-prj-usr');
		var pname = $(obj).attr('data-prj-name');
		$.post(loc,{
			'user_ids':user_ids,
			'project_id':proj_id,
			'typ':'as'
		},function(res){
			if(res.status == 'nf'){
				showTopErrSucc('error', '<?php echo __("Failed to assign user to the project.");?>');
			}else{
				if(trim(res.message) != ''){
					showTopErrSucc('success', res.message);
					$('.assgnremoveme'+proj_uid).html('<a href="javascript:void(0);" class="icon-add-usr" data-prj-uid ="'+proj_uid+'" data-prj-id="'+proj_id+'" data-prj-name="'+pname+'" data-prj-usr="<?php echo SES_ID; ?>" onclick="removeMeFromPrj(this);"><i class="material-icons">&#xE15C;</i> <?php echo __("Remove me from here");?></a>');
				}
			}
		},'json');
	}
	function removeMeFromPrj(obj){
		var loc = HTTP_ROOT+"projects/assignRemovMeToProject/";
		var proj_id = $(obj).attr('data-prj-id');
		var proj_uid = $(obj).attr('data-prj-uid');
		var user_ids = $(obj).attr('data-prj-usr');
		var pname = $(obj).attr('data-prj-name');
		$.post(loc,{
			'user_ids':user_ids,
			'project_id':proj_id,
			'typ':'rm'
		},function(res){
			if(res.status == 'nf'){
				showTopErrSucc('error', '<?php echo __("Failed to assign user to the project.");?>');
			}else{
				if(trim(res.message) != ''){
					showTopErrSucc('success', res.message);
					$('.assgnremoveme'+proj_uid).html('<a href="javascript:void(0);" class="icon-add-usr" data-prj-uid ="'+proj_uid+'" data-prj-id="'+proj_id+'" data-prj-name="'+pname+'" data-prj-usr="<?php echo SES_ID; ?>" onclick="assignMeToPrj(this);"><i class="material-icons">&#xE147;</i> <?php echo __("Add me here");?></a>');
				}
			}
		},'json');
	}
  function inactiveProjectBodyClick(uid) {
    $('.project-dropdown').hide();
    $('.project-dropdown').prev('li').hide();
    $.post(HTTP_ROOT + "projects/updtaeDateVisited", {
        'uniq_id': uid
    }, function (res) {
      if (res.status == 'success') {
        window.location.href = HTTP_ROOT + "dashboard/#overview?prouid=" + uid;
      } else {
        showTopErrSucc('error', '<?php echo __('Oops! You are not a member of the project. Please add yourself as a member of this project.');?>');
        return false;
      }
    }, 'json');

  }
</script>

<script type="text/template" id="project_paginate_tmpl">
<?php echo $this->element('task_paginate'); ?>
</script>