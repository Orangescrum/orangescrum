<!DOCTYPE html>
<html>

<head>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <?php  echo $this->Html->css('bootstrap.min'); ?>
    <?php  echo $this->Html->css('bootstrap-material-design.min'); ?>
    <?php  echo $this->Html->css('custom'); ?>
    <style>
        th {
            font-weight: bold !important;
            font-size: 16px;
        }

        tr,
        td,
        th {
            page-break-inside: avoid !important;
            page-break-before: always;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            tr,
            td,
            th {
                page-break-inside: avoid !important;
                page-break-before: always;
            }

            /*                    thead {display: table-header-group;}*/
            -fs-table-paginate: paginate;
        }
    </style>
</head>

<body style="margin:0px;">
    <?php #print_r($checkedFields);exit;?>
    <div class="task_listing timelog_lview  hidetablelog timelog-detail-tbl">
        <h1 style="width:100%;text-align: center;"><?php echo __('Time Log Reports');?>
        </h1>
        <div class="tlog_top_cnt">
            <div class="m-cmn-flow" style="overflow: auto;width: 100%;">
                <div style="width:74%;padding:10px 0; font-size: 16px; margin-bottom: 20px; float:left;">
                    <span style="width:25%"><?php echo __('Total Records');?>:<strong
                            style="margin-left: 10px;"><?php echo $caseCount;?></strong></span>
                    <strong style="margin-right: 10px;margin-left: 10px;">|</strong>
                    <span><?php echo __('Billable Hrs');?>:<strong
                            style="margin-left: 10px;"><?php echo $this->Format->gethh_mm($total_billable_hours);?>
                            hrs</strong></span>
                    <strong style="margin-right: 10px;margin-left: 10px;">|</strong>
                    <span style="width:25%"><?php echo __('Non-Billable Hrs');?>:<strong
                            style="margin-left: 10px;"><?php echo $this->Format->gethh_mm($total_non_billable_hours);?>
                            hrs</strong></span>
                    <strong style="margin-right: 10px;margin-left: 10px;">|</strong>
                    <span style="width:25%"><?php echo __('Total Hrs');?>:<strong
                            style="margin-left: 10px;"><?php echo $this->Format->gethh_mm($total_billable_hours+$total_non_billable_hours);?>
                            hrs</strong></span>
                </div>
                <div
                    style="width:25%; float: right; text-align: right;padding:10px 0; font-size: 16px; margin-bottom: 20px;">
                    <span style="width:25%"><?php echo __('Export Date');?>:<strong
                            style="margin-left: 10px;">
                            <?php $_curdt =  $this->Tmzone->GetDateTime($SES_TIMEZONE, $TZ_GMT, $TZ_DST, $TZ_CODE, GMT_DATETIME, "datetime");
                        $_fmt = ($SES_TIME_FORMAT ==12)?'M d,Y g:i a':'M d,Y H:i';
                        echo date($_fmt, strtotime($_curdt));
                     ?>
                        </strong></span>
                </div>
                <div style="clear:both;"></div>
                <table class="table table-striped table-hover m-list-tbl"
                    style="display: table;overflow-x: hidden;white-space: normal;width:100%">
                    <tbody>
                        <tr>
                            <?php if (in_array('date', $checkedFields)) { ?>
                            <th style="width:10%;"><?php echo __('Date');?>
                            </th>
                            <?php } ?>
                            <?php if (in_array('usr_name', $checkedFields)) { ?>
                            <th style="width:10%;"><?php echo __('Resource Name');?>
                            </th>
                            <?php }?>
                            <?php if ($projFil =='all') { ?>
                            <th style="width:10%;"><?php echo __('Project Name');?>
                            </th>
                            <?php } ?>
                            <?php if (in_array('task_no', $checkedFields)) { ?>
                            <th style="width:7%;"><?php echo __('Task');?>
                            </th>
                            <?php }?>
                            <?php if (in_array('task_title', $checkedFields)) { ?>
                            <th style="width:19%;"><?php echo __('Task Title');?>
                            </th>
                            <?php } ?>
                            <?php if (in_array('hours', $checkedFields)) { ?>
                            <th style="width:5%;"><?php echo __('Logged Hours');?>
                            </th>
                            <?php } ?>
                            <?php if (in_array('description', $checkedFields)) { ?>
                            <th style="width:19%;"><?php echo __('Note');?>
                            </th>
                            <?php } ?>
                            <?php if (in_array('start', $checkedFields)) { ?>
                            <th style="width:5%;"><?php echo __('Start');?>
                            </th>
                            <?php } ?>
                            <?php if (in_array('end', $checkedFields)) { ?>
                            <th style="width:5%;"><?php echo __('End');?>
                            </th>
                            <?php }?>
                            <?php if (in_array('break', $checkedFields)) { ?>
                            <th style="width:5%;"><?php echo __('Break');?>
                            </th>
                            <?php } ?>
                            <?php if (in_array('billable', $checkedFields)) { ?>
                            <th style="width:5%;" class="text-center"><?php echo __('Billable');?>
                            </th>
                            <?php }?>
                        </tr>
                        <?php foreach ($caseDetail as $k=>$v) { ?>
                        <tr class="timelog-hover-block">
                            <?php if (in_array('date', $checkedFields)) { ?>
                            <td><?php echo date('M d,Y', strtotime($v[0]['start_datetime_v1']));?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('usr_name', $checkedFields)) { ?>
                            <td><?php echo $v[0]['user_name'];?>
                            </td>
                            <?php } ?>
                            <?php if ($projFil =='all') { ?>
                            <td><?php echo $v['LogTime']['prj_name'];?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('task_no', $checkedFields)) { ?>
                            <td><?php echo ($v[0]['task_no'])?$v[0]['task_no']:'---' ?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('task_title', $checkedFields)) { ?>
                            <td style="width:200px;overflow-wrap:break-word;"><?php echo ($v[0]['task_name'])?$this->Format->smart_wordwrap($v[0]['task_name'], 30):'---' ?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('hours', $checkedFields)) { ?>
                            <td><?php echo ($v['LogTime']['total_hours'])?$this->Format->gethh_mm($v['LogTime']['total_hours']).' hrs':'---';?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('description', $checkedFields)) { ?>
                            <td><?php echo ($v['LogTime']['description'])?$this->Format->smart_wordwrap($v['LogTime']['description'], 30):'---';?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('start', $checkedFields)) { ?>
                            <td><?php echo ($v['LogTime']['start_time'] && $v['LogTime']['start_time'] !='00:00:00')?$v['LogTime']['start_time']:'---';?>
                            </td>
                            <?php }?>
                            <?php if (in_array('end', $checkedFields)) { ?>
                            <td><?php echo ($v['LogTime']['end_time']&& $v['LogTime']['end_time'] !='00:00:00')?$v['LogTime']['end_time']:'---';?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('break', $checkedFields)) { ?>
                            <td><?php echo ($v['LogTime']['break_time'])?$this->Format->gethh_mm($v['LogTime']['break_time']).' hrs':'---';?>
                            </td>
                            <?php } ?>
                            <?php if (in_array('billable', $checkedFields)) { ?>
                            <td class="text-center bilble_icn timelog">
                                <?php if ($v['LogTime']['is_billable']) { ?>
                                <a class="tlg-status-link"><i class="material-icons tick_mark">&#xE834;</i></a>
                                <?php } else { ?>
                                <a class="tlg-status-link"><i class="material-icons cross_mark">&#xE5CD;</i></a>
                                <?php } ?>
                            </td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>